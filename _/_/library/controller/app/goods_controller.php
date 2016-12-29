<?php
class goods_controller extends base_controller{
	public function index() {
		$product_id = $_REQUEST['id'];
		$store_id = $_REQUEST['store_id'];
		
		if ($_REQUEST['app'] != 'app') {
			$url = option('config.wap_site_url') . '/good.php?id=' . $product_id . '&store_id=' . $store_id;
			header('location: ' . $url);
			exit;
		}
		
		if (empty($product_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		$product = D('Product')->where(array('product_id' => $product_id))->find();
		
		if (empty($product)) {
			json_return(1000, '未找到相应的产品');
		}
		
		if ($product['status'] != 1) {
			json_return(1000, '您访问的商品未上架或已删除');
		}
		
		if (empty($store_id)) {
			$store_id = $product['store_id'];
		}
		
		$store = M('Store')->getStore($store_id, true);
		if (empty($store)) {
			json_return(1000, '您访问产品的店铺已关闭');
		}
		
		// 查找供货商店铺
		$supplier_store = $store;
		if ($store['top_supplier_id']) {
			$supplier_store = M('Store')->getStore($store['top_supplier_id']);
		}
		
		// 是否只能显示供货商联系方式
		if ($supplier_store['tel'] && $supplier_store['is_show_drp_tel'] == 1) {
			$store['tel'] = $supplier_store['tel'];
		}
		
		// 批发商品时，需要对送他人、找人送功能单独处理
		$store_original = array();
		if ($product['wholesale_product_id']) {
			$product_original = D('Product')->where(array('product_id' => $product['wholesale_product_id']))->find();
			if (empty($product_original) || $product_original['status'] != '1') {
				json_return(1000, '您访问的商品不存在或未上架或已删除');
			}
			
			$product['send_other'] = $product_original['send_other'];
			
			$store_original = D('Store')->where(array('store_id' => $product_original['store_id']))->field('store_id, open_logistics, open_friend, buyer_selffetch')->find();
		
			if (empty($store_original)) {
				json_return(1000, '您访问的店铺不存在');
			}
		}
		
		// 用户是否关注此店铺，关注会享受相应的关注价格
		$is_subscribe_store = M('Store')->is_subscribe_store($this->user['uid'], $store_id);
		
		// 商品相关数据处理
		// 产品图片
		$product['image'] = getAttachmentUrl($product['image']);
		$product['images'] = M('Product_image')->getImages($product_id, true);
		$product['images_num'] = count($product['images']);
		
		// 产品价格
		$newPropertyList = array();
		if ($product['has_property']) {
			//库存信息
			$sku_list = D('Product_sku')->where(array('product_id' => $product_id))->order('`sku_id` ASC')->select();
			//如果有库存信息并且有库存，则查库存关系表
			if (!empty($sku_list)) {
				$sku_price_arr = $sku_property_arr = array();
				foreach ($sku_list as $value) {
					if (!empty($product['unified_price_setting']) && !empty($product['is_fx'])) { //分销商的价格
						$value['price'] = ($value['drp_level_' . ($store['drp_level'] <= 3 ? $store['drp_level'] : 3) . '_price'] > 0) ? $value['drp_level_' . ($store['drp_level'] <= 3 ? $store['drp_level'] : 3) . '_price'] : $value['price'];
					}
					
					if ($is_subscribe_store && $product['after_subscribe_discount'] > 0 && $product['after_subscribe_discount'] < 10) {
						$value['price'] = $value['price'] * $product['after_subscribe_discount'] / 10;
					}
					
					$sku_price_arr[] = $value['price'];
					$sku_property_arr[$value['properties']] = true;
				}
				if (!empty($sku_price_arr)) {
					$min_price = min($sku_price_arr);
					$max_price = max($sku_price_arr);
				} else {
					$product['quantity'] = 0;
				}
				$tmpPropertyList = D('')->field('`pp`.`pid`,`pp`.`name`')->table(array('Product_to_property' => 'ptp', 'Product_property' => 'pp'))->where("`ptp`.`product_id`='$product_id' AND `pp`.`pid`=`ptp`.`pid`")->order('`ptp`.`pigcms_id` ASC')->select();
				if (!empty($tmpPropertyList)) {
					$tmpPropertyValueList = D('')->field('`ppv`.`vid`,`ppv`.`value`,`ppv`.`pid`')->table(array('Product_to_property_value' => 'ptpv', 'Product_property_value' => 'ppv'))->where("`ptpv`.`product_id`='$product_id' AND `ppv`.`vid`=`ptpv`.`vid`")->order('`ptpv`.`pigcms_id` ASC')->select();
					if (!empty($tmpPropertyValueList)) {
						foreach ($tmpPropertyValueList as $value) {
							$propertyValueList[$value['pid']][] = array(
									'vid' => $value['vid'],
									'value' => $value['value'],
							);
						}
						foreach ($tmpPropertyList as $value) {
							$newPropertyList[] = array(
									'pid' => $value['pid'],
									'name' => $value['name'],
									'values' => $propertyValueList[$value['pid']],
							);
						}
						if (count($newPropertyList) == 1) {
							foreach ($newPropertyList[0]['values'] as $key => $value) {
								$tmpKey = $newPropertyList[0]['pid'] . ':' . $value['vid'];
								if (empty($sku_property_arr[$tmpKey])) {
									unset($newPropertyList[0]['values'][$key]);
								}
							}
						}
					}
				}
			}
			
			if ($min_price) {
				$product['price'] = $min_price;
			}
		} else {
			$maxPrice = 0;
			$minPrice = $product['price'];
			if (!empty($product['unified_price_setting']) && !empty($product['is_fx'])) { //分销商的价格
				$minPrice = ($product['drp_level_' . ($store['drp_level'] <= 3 ? $store['drp_level'] : 3) . '_price'] > 0) ? $product['drp_level_' . ($store['drp_level'] <= 3 ? $store['drp_level'] : 3) . '_price'] : $product['price'];
			}
			
			if ($is_subscribe_store && $product['after_subscribe_discount'] > 0 && $product['after_subscribe_discount'] < 10) {
				$minPrice = $product['price'] * $product['after_subscribe_discount'] / 10;
			}
		}
		
		// 产品规格
		$property_list = array();
		if (is_array($newPropertyList)) {
			foreach ($newPropertyList as $value) {
				$property_str = '';
				if (!empty($value['values'])) {
					$property_str = $value['name'] . '：';
					
					$i = 1;
					$count = count($value['values']);
					foreach ($value['values'] as $v) {
						$property_str .= $v['value'];
						if ($i != $count) {
							$property_str .= '、';
						}
						$i++;
					}
					
					$property_list[] = $property_str;
				}
			}
		}
		
		// 运费相关
		if ($product['postage_type']) {
			if (!empty($product['wholesale_product_id'])) {
				$tmp_product = D('Product')->field('store_id')->where(array('product_id' => $product['wholesale_product_id']))->find();
				$supplier_id = $tmp_product['store_id'];
			} else {
				$supplier_id = $product['store_id'];
			}
			$postage_template = M('Postage_template')->get_tpl($product['postage_template_id'], $supplier_id);
			if ($postage_template['area_list']) {
				foreach ($postage_template['area_list'] as $value) {
					if (!isset($min_postage)) {
						$min_postage = $max_postage = $value[2];
					} else if ($value[2] < $min_postage) {
						$min_postage = $value[2];
					} else if ($value[2] > $max_postage) {
						$max_postage = $value[2];
					}
				}
			}
			if ($min_postage == $max_postage) {
				$product['postage'] = $min_postage;
			} else {
				$product['postage_tpl'] = array('min' => $min_postage, 'max' => $max_postage);
			}
		}
		
		//商品的自定义字段
		$goods_custom_field = array();
		if ($product['has_custom']) {
			if ($this->app) {
				$goods_custom_field = M('Custom_field')->getFields($product['store_id'], 'good', $product['product_id'], $store_id, $store['drp_level'], $store['drp_diy_store']);
			} else {
				$goods_custom_field = M('Custom_field')->getParseFields($product['store_id'], 'good', $product['product_id'], $store_id, $store['drp_level'], $store['drp_diy_store']);
			}
		}
		
		// 产品评论相关,total:总数、t1:差评数、t2:中评数、t3:好评数、t4:带图片评论数
		$comment_data = M('Comment')->getCountList(array('relation_id' => $product_id));
		$comment_data['t1'] += 0;
		$comment_data['t2'] += 0;
		$comment_data['t3'] += 0;
		$comment_data['t4'] += 0;
		
		//公共广告判断
		$custom_field_ad = array();
		$custom_field_ad['page_has_ad'] = 0;
		if ($store['open_ad'] && !empty($store['use_ad_pages'])) {
			$user_ad_pages_arr = explode(',', $store['use_ad_pages']);
			if (in_array('2', $user_ad_pages_arr)) {
				if ($this->app) {
					$custom_field_ad_list = M('Custom_field')->getFields($product['store_id'], 'common_ad', $product['store_id'], $store_id, $store['drp_level'], $store['drp_diy_store']);
					if (!empty($custom_field_ad_list)) {
						$custom_field_ad['page_has_ad'] = 1;
						$custom_field_ad['list'] = $custom_field_ad_list;
						$custom_field_ad['position'] = $store['ad_position'];
					}
				} else {
					$custom_field_ad_list = M('Custom_field')->getParseFields($product['store_id'], 'common_ad', $product['store_id'], $store_id, $store['drp_level'], $store['drp_diy_store']);
					if (!empty($custom_field_ad_list)) {
						$custom_field_ad['page_has_ad'] = 1;
						$custom_field_ad['list'] = $custom_field_ad_list;
						$custom_field_ad['position'] = $store['ad_position'];
					}
				}
			}
		}
		
		// 满减
		$reward = M('Reward')->getRewardByProduct($product);
		// 是否喜欢(收藏)
		$product['is_collect'] = D('User_collect')->where(array('user_id' => $this->user['uid'], 'type' => 1, 'store_id' => $store_id, 'dataid' => $product_id))->count('collect_id');
		
		// 产品购买按钮
		// 保证金不足，商品暂停出售
		$constraint_sold_out = false;
		if (Margin::pre_recharge()) {
			Margin::init($store['store_id']);
			if (Margin::balance() <= 0) {
				$constraint_sold_out = true;
			}
		}
		
		// 限购
		$buyer_quota = false;
		$buy_quantity = 0;
		if (!empty($product['buyer_quota'])) {
			$user_type = 'uid';
			$uid = $this->user['uid'];
			//购物车
			$cart_number = D('User_cart')->field('sum(pro_num) as pro_num')->where(array('product_id' => $product['product_id'], 'uid' => $uid))->find();
			if (!empty($cart_number)) {
				$buy_quantity += $cart_number['pro_num'];
			}
			
			// 再加上订单里已经购买的商品
			$buy_quantity += M('Order_product')->getBuyNumber($uid, $product['product_id'], $user_type);
			if ($buy_quantity >= $product['buyer_quota']) {
				$buyer_quota = true;
			}
		}
		
		// 购买按钮
		$pay_btn_arr = array();
		if ($constraint_sold_out) {
			$tmp = array('type' => 'no_buy', 'name' => '暂停出售');
			$pay_btn_arr[] = $tmp;
		} else if ($product['quantity'] <= 0) {
			$tmp = array('type' => 'no_buy', 'name' => '商品已售罄');
			$pay_btn_arr[] = $tmp;
		} else if ($buyer_quota) {
			$tmp = array('type' => 'no_buy', 'name' => '限购，您已购买' . $buy_quantity . '件');
			$pay_btn_arr[] = $tmp;
		} else {
			$tmp = array('type' => 'self_buy', 'name' => '自己买');
			$pay_btn_arr[] = $tmp;
			
			if ($store['pay_agent']) {
				$tmp = array('type' => 'peerpay_buy', 'name' => '找人送');
				$pay_btn_arr[] = $tmp;
			}
			
			if (($product['wholesale_product_id'] > 0 && $product_original['send_other'] && $store_original['open_logistics'] && $store_original['open_friend']) || ($product['wholesale_product_id'] == 0 && $product['send_other'] && $store['open_logistics'] && $store['open_friend'])) {
				$tmp = array('type' => 'send_other', 'name' => '送他人');
				$pay_btn_arr[] = $tmp;
			}
			
			$tmp = array('type' => 'add_cart', 'name' => '加入购物车');
			$pay_btn_arr[] = $tmp;
		}
		
		// 赠送积分
		$point_arr = array();
		if ($product['check_give_points'] && $product['give_points']) {
			$point_arr[] = array('name' => '赠送店铺积分', 'number' => $product['give_points']);
		}
		
		if (Margin::check()) {
			$number = $product['open_return_point'] ? $product['return_point'] : $product['price'] * option('credit.platform_credit_rule');
			$point_arr[] = array('name' => '赠送' . option('credit.platform_credit_name'), 'number' => $number);
		}
		
		// 产品是否可以设置分销
		$fx_data = array();
		$fx_data['is_fx'] = $product['is_fx'];
		$fx_data['avatar'] = $this->user['avatar'] ? getAttachmentUrl($this->user['avatar']) : option('config.site_url') . '/static/images/avatar.png';
		if ($product['is_fx']) {
			$visitor = Drp::checkID($store_id, $this->user['uid']);
			if ($visitor['data']['store_id'] == $store_id && empty($visitor['data']['drp_supplier_id'])) {
				// 供货商自己访问
				$fx_data['allow_drp'] = true;
				$fx_data['type'] = 'SUPPLIER';
				$fx_data['store_id'] = $visitor['data']['store_id'];
				$fx_data['msg'] = '<p>亲爱的<span class="nickname">' . $this->user['nickname'] . '</span></p><p>此商品已经设置为可分销！</p>';
				$fx_data['button'] = '';
			} else if (!empty($visitor['data']['allow_drp_manage'])) {
				// 已经是分销商
				$fx_data['allow_drp'] = $visitor['data']['allow_drp'];
				$fx_data['type'] = 'FX';
				$fx_data['store_id'] = $visitor['data']['store_id'];
				$fx_data['msg'] = "<p>分销此商品您可赚取 <span class='profit'>{min_profit} ~ {max_profit}</span>元 佣金！</p>";
				$fx_data['url'] = option('config.wap_site_url') . '/drp_product_share.php?id=' . $product['product_id'] . '&store_id=' . $visitor['data']['store_id'];
				$fx_data['button'] = '去赚佣金';
				$drp_level = ($visitor['data']['drp_level'] > 3) ? 3 : $visitor['data']['drp_level'];
				
				$zx_profit = array(); //直销利润
				$fx_profit = array(); //分销利润
				
				if (!empty($sku_list)) {
					foreach ($sku_list as $sku) {
						$zx_profit[] = $sku['drp_level_3_price'] - $sku['drp_level_3_cost_price'];
						$fx_profit[] = $sku['drp_level_' . $drp_level . '_price'] - $sku['drp_level_' . $drp_level . '_cost_price'];
					}
				} else {
					//3级利润
					$zx_profit[] = $product['drp_level_3_price'] - $product['drp_level_3_cost_price'];
					$fx_profit[] = $product['drp_level_' . $drp_level . '_price'] - $product['drp_level_' . $drp_level . '_cost_price'];
				}
				if (!empty($product['unified_profit'])) {
					$min_profit = number_format(min($zx_profit), 2, '.', '');
					$max_profit = number_format(max($zx_profit), 2, '.', '');
				} else {
					$min_profit = number_format(min($fx_profit), 2, '.', '');
					$max_profit = number_format(max($fx_profit), 2, '.', '');
				}
				if ($min_profit != $max_profit) {
					$fx_data['msg'] = str_replace(array("{min_profit}", "{max_profit}"), array($min_profit, $max_profit), $fx_data['msg']);
				} else {
					$fx_data['msg'] = str_replace("{min_profit} ~ {max_profit}", $min_profit, $fx_data['msg']);
				}
			} else if (!empty($visitor['data']['allow_drp_register'])) {
				// 已经是分销商
				$fx_data['allow_drp'] = $visitor['data']['allow_drp'];
				$fx_data['type'] = 'OTHER';
				$fx_data['store_id'] = 0;
				$fx_data['msg'] = '<p>亲爱的<span class="nickname">' . $this->user['nickname'] . '</span></p><p>申请分销即可分销赚佣金！</p>';
				$fx_data['url'] = option('config.wap_site_url') . '/drp_register.php?id=' . $store_id . '&referer=' . urlencode(option('config.wap_site_url') . '/drp_product_share.php?id=' . $product['product_id'] . '&store_id=');
				$fx_data['button'] = '我要分销';
			}
		}
		
		// 产品封面图片上的实体店、活动、推荐、限购
		$image_icon_arr = array();
		// 产品参与活动、优惠券、游戏
		$a_c_g_arr = array();
		if ($store['physical_count']) {
			$image_icon_arr[] = '实体店';
		}
		
		$a_c_g_arr['activity'] = false;
		if (M('Product')->getActivity($product['product_id'], false)) {
			$image_icon_arr[] = '活动';
			$a_c_g_arr['activity'] = true;
		}
		
		if ($product['is_recommend']) {
			$image_icon_arr[] = '推荐';
		}
		
		if ($product['buyer_quota']) {
			$image_icon_arr[] = '限购';
		}
		
		// 供货商发货信息
		$send_data = array();
		$supplier_id = $store['top_supplier_id'] ? $store['top_supplier_id'] : $store['store_id'];
		$store_contact = M('Store_contact')->get($supplier_id);
		if ($store_contact) {
			$send_data['address'] = $store_contact['province_txt'] . ' ' . $store_contact['city_txt'] . ' ' . $store_contact['county_txt'];
			$send_data['lat'] = $store_contact['lat'];
			$send_data['long'] = $store_contact['long'];
		}
		$send_data['send_name'] = $supplier_store['name'];
		
		// 折扣相关数据处理
		$discount_arr = array();
		// 扫码折扣
		$activity = $_REQUEST['activity'];
		if ($activity) {
			$product_qrcode_activity = M('Product_qrcode_activity')->getActivityById($activity);
			if ($product_qrcode_activity && $product_qrcode_activity['product_id'] == $product['product_id'] && $product['store_id'] == $store['store_id']) {
				if ($product_qrcode_activity['type'] == 1) {
					$tmp = array();
					$tmp['name'] = '扫码优惠';
					$tmp['type'] = 'qrcode';
					$tmp['msg'] = '扫商品推广二维码，可优惠<span class="discount_color">' . $product_qrcode_activity['price'] . '元</span>';
				} else {
					$tmp = array();
					$tmp['name'] = '扫码优惠';
					$tmp['type'] = 'qrcode';
					$tmp['msg'] = '扫商品推广二维码，享受<span class="discount_color">' . $product_qrcode_activity['discount'] . '折</span>';
				}
				
				$discount_arr[] = $tmp;
				// 当存在扫码化优惠时，取消关注折扣
				$product['after_subscribe_discount'] = 0;
			}
		}
		
		// 店铺积分提现
		$store_points_config = D('Store_points_config')->where(array('store_id' => $supplier_id))->find();
		if ($store_points_config && $store_points_config['is_offset']) {
			$tmp = array();
			$tmp['name'] = '积分抵现';
			$tmp['type'] = 'point2cash';
			$tmp['msg'] = '店铺积分订单抵现，最高抵现订单额<span class="discount_color"></span>';
			
			// 换现百分比
			if ($store_points_config['is_percent'] && $store_points_config['offset_cash']) {
				$tmp['msg'] .= '，最高抵现订单额<span class="discount_color">' . $store_points_config['offset_cash'] . '%</span>';
			}
			
			// 最高抵现
			if ($store_points_config['is_limit'] && $store_points_config['offset_limit']) {
				$tmp['msg'] .= '，最高抵现<span class="discount_color">' . $store_points_config['offset_limit'] . '</span>元';
			}
			
			$discount_arr[] = $tmp;
		}
		
		// 店铺等级特权
		$count = D('User_degree')->where(array('store_id' => $supplier_id, ))->count('*');
		if ($count > 0) {
			$tmp = array();
			$tmp['name'] = '等级特权';
			$tmp['type'] = 'degree';
			$tmp['msg'] = '店铺会员开启等级购物特权';
			
			$discount_arr[] = $tmp;
		}
		
		// 满减
		if ($reward) {
			$tmp = array();
			$tmp['name'] = '满减';
			$tmp['type'] = 'reward';
			$tmp['msg'] = $reward;
			
			$discount_arr[] = $tmp;
		}
		
		// 认证店铺、7天无理由退货、担保交易、线下门店
		$credit_arr = array();
		if (option('config.is_show_credit')) {
			if ($store['approve']) {
				$tmp = array();
				$tmp['type'] = 'RZ';
				$tmp['name'] = '认证店铺';
				$credit_arr[] = $tmp;
			}
			
			$tmp = array();
			$tmp['type'] = '7D';
			$tmp['name'] = '7天无理由退款';
			$credit_arr[] = $tmp;
			
			if ($store['wxpay']) {
				$tmp = array();
				$tmp['type'] = 'DB';
				$tmp['name'] = '担保交易';
				$credit_arr[] = $tmp;
			}
			
			// 线下门店
			if ($store['physical_count'] && $store['store_id'] == $supplier_id) {
				$tmp = array();
				$tmp['type'] = 'MD';
				$tmp['name'] = '线下门店';
				$credit_arr[] = $tmp;
			}
		}
		
		// 同店宝贝
		$product_relation_list = M('Product_relation')->getRelationProduct($product_id, $store_id);
		foreach ($product_relation_list as $key => $product_relation) {
			$tmp = array();
			$tmp['product_id'] = $product_relation['product_id'];
			$tmp['name'] = $product_relation['name'];
			$tmp['image'] = $product_relation['image'];
			$tmp['price'] = ($product_relation['drp_level_' . ($store['drp_level'] <= 3 ? $store['drp_level'] : 3) . '_price'] > 0) ? $product_relation['drp_level_' . ($store['drp_level'] <= 3 ? $store['drp_level'] : 3) . '_price'] : $product_relation['price'];
			$tmp['original_price'] = $product_relation['original_price'];
			$tmp['sales'] = $product_relation['sales'];
			$tmp['quantity'] = $product_relation['quantity'];
			
			$product_relation_list[$key] = $tmp;
		}
		
		// 同店宝贝为空时，随机抽取，按销量、推荐排序
		if (empty($product_relation_list)) {
			$product_relation_list = D('Product')->where(array('store_id' => $product['store_id'], 'status' => 1, 'quantity' => array('>', 0)))->order('sales DESC, is_recommend DESC')->limit(6)->select();
			foreach ($product_relation_list as $key => $product_relation) {
				$tmp = array();
				$tmp['product_id'] = $product_relation['product_id'];
				$tmp['name'] = $product_relation['name'];
				$tmp['image'] = $product_relation['image'];
				$tmp['price'] = ($product_relation['drp_level_' . ($store['drp_level'] <= 3 ? $store['drp_level'] : 3) . '_price'] > 0) ? $product_relation['drp_level_' . ($store['drp_level'] <= 3 ? $store['drp_level'] : 3) . '_price'] : $product_relation['price'];
				$tmp['original_price'] = $product_relation['original_price'];
				$tmp['sales'] = $product_relation['sales'];
				$tmp['quantity'] = $product_relation['quantity'];
					
				$product_relation_list[$key] = $tmp;
			}
		}
		
		$time = time();
		// 是否有优惠券
		$where = array();
		$where['store_id'] = $supplier_id;
		$where['status'] = 1;
		$where['type'] = 1;
		$where['total_amount'] = array('>', 0);
		$where['start_time'] = array('<', $time);
		$where['end_time'] = array('>=', $time);
		$where['is_all_product'] = 0;
		$coupon_count = D('Coupon')->where()->count('*');
		if ($coupon_count == 0 || 1) {
			$where = "c.store_id = '" . $supplier_id . "' AND c.status = '1' AND c.type = '1' AND c.total_amount > 0 AND c.start_time < '" . $time . "' AND c.end_time >= '" . $time . "' AND c.is_all_product = 1 AND ctp.product_id = '" . $product_id . "'";
			$coupon_count = D('Coupon AS c')->join('Coupon_to_product AS ctp ON c.id = ctp.coupon_id')->where($where)->count('*');
		}
		$a_c_g_arr['coupon'] = $coupon_count ? true : false;
		
		// 游戏
		$a_c_g_arr['game'] = M('Product')->getGame($product_id, false);
		
		// webapp 增加浏览记录
		if (!$this->app) {
			$good_history = $_COOKIE['good_history'];
			if (empty($good_history)) {
				$new_history = true;
			} else {
				$good_history = json_decode(stripslashes($good_history), true);
				if (!is_array($good_history)) {
					$new_history = true;
				} else {
					$new_good_history = array();
					foreach ($good_history as &$history_value) {
						if ($history_value['id'] != $product['product_id']) {
							$new_good_history[] = $history_value;
						}
					}
					if (!empty($new_good_history)) {
						array_unshift($new_good_history, array('id' => $product['product_id'], 'store_id' => $store_id, 'time' => $_SERVER['REQUEST_TIME']));
						$new_good_history = array_slice($new_good_history, 0, 20);
					} else {
						$new_history = true;
					}
				}
			}
			if ($new_history) {
				$new_good_history[] = array('id' => $product['product_id'], 'store_id' => $store_id, 'time' => $_SERVER['REQUEST_TIME']);
			}
			setcookie('good_history', json_encode($new_good_history), $_SERVER['REQUEST_TIME'] + 86400 * 365, '/');
		}
		
		// 返回结果
		$return = array();
		$return['product'] = $product;
		$return['store'] = $store;
		$return['comment_data'] = $comment_data;
		$return['custom_field_ad'] = $custom_field_ad;
		$return['goods_custom_field'] = $goods_custom_field;
		$return['reward'] = $reward;
		$return['property_list'] = $property_list;
		$return['pay_btn_arr'] = $pay_btn_arr;
		$return['point_arr'] = $point_arr;
		$return['fx_data'] = $fx_data;
		$return['image_icon_arr'] = $image_icon_arr;
		$return['send_data'] = $send_data;
		$return['discount_arr'] = $discount_arr;
		$return['credit_arr'] = $credit_arr;
		$return['product_relation_list'] = $product_relation_list;
		$return['a_c_g_arr'] = $a_c_g_arr;
		
		json_return(0, $return);
	}
	
	// 单店铺里的搜索
	public function search_in_store() {
		$store_id = $_REQUEST['store_id'];
		$keyword = $_REQUEST['keyword'];
		$page = max(1, $_REQUEST['page']);
		$limit = 10;
		$offset = ($page - 1) * $limit;
		
		if (empty($store_id)) {
			json_return(1000, '缺少参数');
		}
		
		//店铺资料
		$store = M('Store')->getStore($store_id, true);
		if(empty($store)) {
			json_return(1000, '未找到相应的店铺');
		}
		
		$supplier_id = $store_id;
		if (!empty($store['top_supplier_id']) && empty($store['drp_diy_store'])) {
			$supplier_id = $store['top_supplier_id'];
		}
		
		$product_model = D('Product');
		$where = array();
		$where['store_id'] = $supplier_id;
		$where['status'] = 1;
		$where['quantity'] = array('>', 0);
		if (!empty($keyword)) {
			$where['name'] = array('like', '%' . $keyword . '%');
		}
		
		// 如果是分销店铺，只能搜索供货商已分销的产品
		if ($store['top_supplier_id']) {
			$where['is_fx'] = 1;
		}
		$count = $product_model->where($where)->count('product_id');
		
		// 定义返回数据
		$json_return = array();
		$json_return['count'] = $count;
		$json_return['next_page'] = true;
		if ($offset >= $count) {
			$json_return['product_list'] = array();
			$json_return['next_page'] = false;
		} else {
			if ($count > 0) {
				$product_list = $product_model->where($where)->field('product_id, name, quantity, price, original_price, weight, image, intro, is_fx, drp_level_1_price, drp_level_2_price, drp_level_3_price')->order('sort DESC, product_id DESC')->select();
				
				foreach ($product_list as &$product) {
					$product['image'] = getAttachmentUrl($product['image']);
					
					$drp_level = 0;
					if ($supplier_id != $store_id) {
						if ($store['drp_level'] >= 3) {
							$drp_level = 3;
						} else {
							$drp_level = $store['drp_level'];
						}
					}
					
					if ($product['is_fx'] && $supplier_id != $store_id && $drp_level > 0) {
						$product['price'] = !empty($product['drp_level_' . $drp_level . '_price']) ? $product['drp_level_' . $drp_level . '_price'] : $product['price'];
					}
					
					if ($product['original_price'] && $product['original_price'] < $product['price']) {
						$product['original_price'] = $product['price'];
					}
					
					$product['intro'] = mb_substr($product['intro'], 0, 50, 'utf-8');
					$product['url'] = url('goods:index', array('product_id' => $product['product_id'], 'store_id' => $store_id));
					unset($product['drp_level_1_price']);
					unset($product['drp_level_2_price']);
					unset($product['drp_level_3_price']);
				}
				
				$json_return['product_list'] = $product_list;
				if (count($product_list) < $limit) {
					$json_return['next_page'] = false;
				}
			}
		}
		
		json_return(0, $json_return);
	}
	
	
	// 综合商城搜索
	public function search() {
		$key_id = $_REQUEST['cid'];
		$keyword = $_REQUEST['keyword'];
		$page = max($_REQUEST['page'], 1);
		$prop = $_REQUEST['prop'];
		
		if (empty($keyword)) {
			json_return(1000, '搜索关键词不能为空');
		}
		
		// 筛选属性ID集合
		$prop_arr = array();
		if (!empty($prop)) {
			$prop_arr = explode('_', $prop);
		}
		
		// 查询属性条件
		$is_prop = false;
		$product_id_str = '';
		if (!empty($prop_arr)) {
			$product_id_str = M('System_product_to_property_value')->getProductIDByVid($prop_arr);
			$is_prop = true;
		}
		
		if($key_id){
			$now_category = D('Product_category')->field('`cat_id`,`cat_fid`')->where(array('cat_id' => $key_id))->find();
		}
		$condition['status'] = '1';
		$condition['supplier_id'] = '0'; //只出现供货商商品
		$condition['wholesale_product_id'] = '0';
		$condition['public_display'] = '1'; //只出现开启展示的商品
		$condition['quantity'] = array('!=','0');
		if($now_category){
			if($now_category['cat_fid']){
				$condition['category_id'] = $now_category['cat_id'];
			}else{
				$condition['category_fid'] = $now_category['cat_id'];
			}
		}else{
			$condition['name'] = array('like','%'.$keyword.'%');
		}
		
		if ($is_prop && $product_id_str) {
			$product_id_arr = explode(',', $product_id_str);
			$condition['product_id'] = array('in', $product_id_arr);
		} else if ($is_prop) {
			$json_return['count'] = 0;
			json_return(0, $json_return);
		}
		
		$json_return = array();
		if ($page == 1) {
			$json_return['count'] = D('Product')->where($condition)->count('product_id');
		}
		
		switch($_REQUEST['sort']) {
			case 'price_asc':
				$sort_by = '`price` ASC';
				break;
			case 'price_desc':
				$sort_by = '`price` DESC';
				break;
			case 'sale':
				$sort_by = '`sales` DESC';
				break;
			case 'pv':
				$sort_by = '`pv` DESC';
				break;
			default:
				$sort_by = '`product_id` DESC';
		}
		$json_return['list'] = D('Product')->field('`product_id`, `store_id`, `name`,`image`,`price`,`original_price`,`sales`')->where($condition)->order($sort_by)->limit((($page-1)*10).',10')->select();
		
		$json_return['next_page'] = true;
		if(count($json_return['list']) < 10){
			$json_return['next_page'] = false;
		}
		foreach($json_return['list'] as &$value){
			$value['image'] = getAttachmentUrl($value['image']);
			$value['url'] = url('goods:index', array('id' => $value['product_id'], 'store_id' => $value['store_id']));
		}
		
		json_return(0, $json_return);
	}
	
	// 折扣、优惠
	public function discount() {
		$type = $_REQUEST['type'];
		$page = max(1, $_REQUEST['page']);
		$max_page = $_REQUEST['max_page'];
		$limit = $_REQUEST['limit'] + 0;
		if (empty($limit)) {
			$limit = 10;
		}
		
		if (!in_array($type, array('ZHEKOU', 'YOUHUI'))) {
			$type = 'YOUHUI';
		}
		
		$offset = ($page - 1) * $limit;
		$product_module = M('Product');
		
		$count = $product_module->getProductDiscountCount($type);
		$json_return = array();
		$json_return['count'] = $count;
		if ($offset >= $count || (!empty($max_page) && $max_page < $page)) {
			$json_return['next_page'] = false;
		} else {
			$json_return['next_page'] = true;
		}
		
		if ($json_return['next_page']) {
			$json_return['product_list'] = $product_module->getProductDiscount($type, $offset, $limit);
			
			if (count($json_return['product_list']) < $limit) {
				$json_return['next_page'] = false;
			}
		}
		
		echo json_encode($json_return);
		exit;
	}

	// 购买记录
	public function buy_list() {
		$page = max(1, $_REQUEST['page'] + 0);
		$product_id = $_REQUEST['product_id'];
			
		if (empty($product_id)) {
			json_return(1000, '缺少最基本的参数');
		}
			
		$Order_product_model = M('Order_product');
		$count = $Order_product_model->getProductBuyCount($product_id);
		
			
		$order_product_list = array();
		$pages = '';
		$limit = 5;
		$total_page = ceil($count / $limit);
		if ($count > 0) {
			$page = min($page, ceil($count / $limit));
			$offset = ($page - 1) * $limit;
			$order_product_list = $Order_product_model->getProductBuyList($product_id, $limit, $offset, true);
		}
			
		$user_list = array();
		if ($order_product_list['user_list']) {
			foreach ($order_product_list['user_list'] as $key => $user) {
				$tmp = array();
				$tmp['nickname'] = anonymous($user['nickname']);
				$tmp['avatar'] = $user['avatar'];
		
				$user_list[$key] = $tmp;
			}
		}
		
		// debug用户
		$user_list[0] = array('nickname' => '匿名', 'avatar' => getAttachmentUrl('images/touxiang.png', false));
		
		$order_list = array();
		foreach ($order_product_list['order_product_list'] as $order_product) {
			$order_product['nickname'] = $user_list[$order_product['uid']]['nickname'];
			$order_product['avatar'] = $user_list[$order_product['uid']]['avatar'];
			
			$order_list[] = $order_product;
		}
		
		$json_return['order_list'] = $order_list;
		$json_return['count'] = $count;
		$json_return['max_page'] = ceil($count / $limit);
			
		$json_return['next_page'] = true;
		if(count($json_return['list']) < $limit || $total_page <= $page){
			$json_return['next_page'] = false;
		}
		
		json_return(0, $json_return);
		break;
	}
	
	// 产品购买信息
	public function info() {
		$store_id = $_REQUEST['store_id'];
		$product_id = $_REQUEST['product_id'];
		if (empty($store_id) || empty($product_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		// 是否关注过公众号 
		$where = array();
		$where['uid'] = $this->user['uid'];
		$where['store_id'] = $store_id;
		$where['subscribe_time'] = array('>', 0);
		$subscribe_store = D('Subscribe_store')->where($where)->find();
		
		$store = D('Store')->where(array('store_id' => $store_id))->find();
		if (empty($store) || $store['status'] != 1) {
			json_return(1000, '店铺不存在或店铺已关闭');
		}
		
		// 商品信息
		$product = D('Product')->where(array('product_id'=>$product_id))->field('`product_id`,`name`,`buy_way`,`quantity`,`image`,`price`,`after_subscribe_discount`,`sold_time`,`buyer_quota`,`buy_url`,`has_property`,`unified_price_setting`,`is_fx`,`drp_level_1_price`,`drp_level_2_price`,`drp_level_3_price`')->find();
		
		if (empty($product)) {
			json_return(1000, '商品不存在');
		} else if ($product['buy_way'] == '0') {  //检测是否外部购买
			json_return(1000, $product['buy_url'], 'buy_url');
		} else if ($product['quantity'] == '0') { //检测商品数量
			json_return(1000, '商品已经售完');
		} else if($product['sold_time'] > $_SERVER['REQUEST_TIME']) { //检测开售时间
			json_return(1000, '商品还未开始销售');
		} else if($product['sold_time'] > $_SERVER['REQUEST_TIME']) { //买家限购		---- 未写代码
			json_return(1000, '商品还未开始销售');
		}
		
		$product['image'] = getAttachmentUrl($product['image']);
		$return['product'] = $product;
		if ($product['has_property']) {
			//库存信息
			$sku_list = D('Product_sku')->field('`sku_id`,`properties`,`quantity`,`price`,`after_subscribe_price`,`drp_level_1_price`,`drp_level_2_price`,`drp_level_3_price`')->where(array('product_id' => $product_id,'quantity'=>array('>', '0')))->order('`sku_id` ASC')->select();
			
			//如果有库存信息并且有库存，则查库存关系表
			if(!empty($sku_list)){
				$sku_price_arr = $sku_property_arr = array();
				foreach($sku_list as $i => $value){
					if (!empty($product['unified_price_setting']) && !empty($product['is_fx'])) { //分销商的价格
						$value['price'] = ($value['drp_level_' . ($store['drp_level'] <= 3 ? $store['drp_level'] : 3) . '_price'] > 0) ? $value['drp_level_' . ($store['drp_level'] <= 3 ? $store['drp_level'] : 3) . '_price'] : $value['price'];
						$sku_list[$i] = $value;
					}
					if(!empty($subscribe_store) && $product['after_subscribe_discount'] >= 1 && $product['after_subscribe_discount'] < 10) {
						$value['price'] = $value['price'] * $product['after_subscribe_discount'] / 10;
						$sku_list[$i] = $value;
						$sku_price_arr[] = $value['price'];
						$sku_property_arr[$value['properties']] = true;
					} else {
						$sku_price_arr[] = $value['price'];
						$sku_property_arr[$value['properties']] = true;
					}
					
				}
				if (!empty($sku_price_arr)) {
					$min_price = min($sku_price_arr);
					$max_price = max($sku_price_arr);
				} else {
					json_return(1000, '商品已经售完');
				}
				$tmp_property_list = D('')->field('`pp`.`pid`,`pp`.`name`')->table(array('Product_to_property'=>'ptp','Product_property'=>'pp'))->where("`ptp`.`product_id`='$product_id' AND `pp`.`pid`=`ptp`.`pid`")->order('`ptp`.`order_by` ASC')->select();
				
				if(!empty($tmp_property_list)){
					$tmpPropertyValueList = D('')->field('`ppv`.`vid`,`ppv`.`value`,`ppv`.`pid`')->table(array('Product_to_property_value'=>'ptpv','Product_property_value'=>'ppv'))->where("`ptpv`.`product_id`='$product_id' AND `ppv`.`vid`=`ptpv`.`vid`")->order('`ptpv`.`pigcms_id` ASC')->select();
					if(!empty($tmpPropertyValueList)){
						foreach($tmpPropertyValueList as $value){
							$propertyValueList[$value['pid']][] = array(
									'vid'=>$value['vid'],
									'value'=>$value['value'],
							);
						}
						foreach($tmp_property_list as $value){
							$property_list[] = array(
									'pid'=>$value['pid'],
									'name'=>$value['name'],
									'values'=>$propertyValueList[$value['pid']],
							);
						}
						if(count($property_list) == 1){
							foreach($property_list[0]['values'] as $key=>$value){
								$tmpKey = $property_list[0]['pid'].':'.$value['vid'];
								if(empty($sku_property_arr[$tmpKey])){
									unset($property_list[0]['values'][$key]);
								}
							}
						}
						$return['sku_list'] = $sku_list;
						
						$property_list_tmp = array();
						foreach ($property_list as $tmp) {
							$tmp['values'] = array_values($tmp['values']);
							$property_list_tmp[] = $tmp;
						}
						$return['property_list'] = $property_list_tmp;
					}else{
						json_return(1000, '未找到商品的库存信息，无法购买');
					}
				}else{
					json_return(1000, '未找到商品的库存信息，无法购买');
				}
			}else{
				json_return(1000, '商品已经售完');
			}
		}
		
		if (!empty($product['unified_price_setting']) && !empty($product['is_fx'])) {
			$product['price'] = !empty($product['drp_level_' . ($store['drp_level'] <= 3 ? $store['drp_level'] : 3) . '_price']) ? $product['drp_level_' . ($store['drp_level'] <= 3 ? $store['drp_level'] : 3) . '_price'] : $product['price'];
		}
			
		if (!empty($subscribe_store) && $product['after_subscribe_discount'] > 0 && $product['after_subscribe_discount'] < 10) {
			$product['price'] = $product['price'] * $product['after_subscribe_discount'] / 10;
		}
		
		$return['product']['min_price'] = !empty($min_price) ? $min_price : $product['price'];
		$return['product']['max_price'] = !empty($max_price) ? $max_price : 0;
			
		//自定义字段
		$return['custom_field_list'] = D('Product_custom_field')->field('`field_name`,`field_type`,`multi_rows`,`required`')->where(array('product_id' => $product_id))->select();
		
		json_return(0, $return);
	}
	
	// 产品参与活动列表
	public function activity() {
		$product_id = $_REQUEST['product_id'];
		if (empty($product_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		$product = D('Product')->where(array('product_id' => $product_id))->find();
		
		if (empty($product)) {
			json_return(1000, '未找到相应的产品');
		}
		
		if ($product['status'] != 1) {
			json_return(1000, '您访问的商品未上架或已删除');
		}
		
		$activity_list = M('Product')->getActivity($product_id);
		
		json_return(0, array('activity_list' => $activity_list));
	}
	
	// 产品参与的游戏列表
	public function game() {
		$product_id = $_REQUEST['product_id'];
		if (empty($product_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		$product = D('Product')->where(array('product_id' => $product_id))->find();
		
		if (empty($product)) {
			json_return(1000, '未找到相应的产品');
		}
		
		if ($product['status'] != 1) {
			json_return(1000, '您访问的商品未上架或已删除');
		}
		
		$game_list = M('Product')->getGame($product_id);
		
		json_return(0, array('game_list' => $game_list));
	}
}
?>