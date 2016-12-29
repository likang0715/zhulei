<?php 
/**
 * 店铺推广中心
 */
class drp_ucenter_controller extends base_controller {
	// 推广仓库、分销商品
	public function product_list() {
		$store = $this->_storeCheck();
		$page = max(1, $_REQUEST['page']);
		
		// 当前分销商级别
		$drp_level = $store['drp_level'];
		
		// 平台和店铺都开启分销等级
		$drp_degree = array();
		$fx_degree_name = array();
		$fx_degree_name['icon'] = option('config.site_url') . '/template/wap/default/ucenter/images/kong.png';
		$fx_degree_name['name'] = '尚未获得分销等级';
		
		if ($page == 1 && option('config.open_drp_degree') && $store['open_drp_degree']) {
			//分销等级
			$drp_degree = D('Drp_degree')->where(array ('pigcms_id' => $store['drp_degree_id'], 'status' => 1))->find();
			
			$platform_drp_degree = array();
			// 等级使用平台默认名称、图标
			if (!empty($drp_degree['is_platform_degree_name'])) {
				$platform_drp_degree = D('Platform_drp_degree')->field('icon,name')->where(array('pigcms_id' => $drp_degree['is_platform_degree_name']))->find();
				
				if (!empty($platform_drp_degree)) {
					$fx_degree_name['name'] = $platform_drp_degree['name'];
				}
			} else if ($drp_degree['degree_alias']) {
				$fx_degree_name['name'] = $drp_degree['degree_alias'];
			}
			
			if (!empty($drp_degree['is_platform_degree_icon'])) {
				if ($drp_degree['is_platform_degree_icon'] == $drp_degree['is_platform_degree_name']) {
					$fx_degree_name['icon'] = $platform_drp_degree['icon'] ? getAttachmentUrl($platform_drp_degree['icon']) : $fx_degree_name['icon'];
				} else {
					$platform_drp_degree = D('Platform_drp_degree')->field('icon,name')->where(array('pigcms_id' => $drp_degree['is_platform_degree_icon']))->find();
					
					if (!empty($platform_drp_degree)) {
						$fx_degree_name['icon'] = $platform_drp_degree['icon'] ? getAttachmentUrl($platform_drp_degree['icon']) : $fx_degree_name['icon'];
					}
				}
			} else if ($drp_degree['degree_icon_custom']) {
				$fx_degree_name['icon'] = getAttachmentUrl($drp_degree['degree_icon_custom']);
			}
		}
		
		$limit = 10;
		$offset = ($page - 1) * $limit;
		$product_list_tmp = D('Product')->where(array('store_id' => $store['top_supplier_id'], 'status' => 1, 'is_fx' => 1))->order('is_recommend DESC, product_id DESC')->limit($offset . ',' . $limit)->select();
		
		$product_list = array();
		foreach ($product_list_tmp as $product) {
			$tmp = array();
			$drp_degree_data = array('seller_reward_1' => $drp_degree['seller_reward_1'], 'seller_reward_2' => $drp_degree['seller_reward_2'], 'seller_reward_3' => $drp_degree['seller_reward_3']);
			// 有分销等级
			if ($drp_degree) {
				$product_drp_degree = D('Product_drp_degree')->where(array('product_id' => $product['product_id'], 'store_id' => $store['top_supplier_id']))->find();
				if (!empty($product_drp_degree)) {
					$drp_degree_data['seller_reward_1'] = $product_drp_degree['seller_reward_1'];
					$drp_degree_data['seller_reward_2'] = $product_drp_degree['seller_reward_2'];
					$drp_degree_data['seller_reward_3'] = $product_drp_degree['seller_reward_3'];
				}
			}
			
			$tmp['product_id'] = $product['product_id'];
			$tmp['name'] = $product['name'];
			$tmp['image'] = getAttachmentUrl($product['image']);
			$tmp['price'] = $product['price'];
			$tmp['unified_profit'] = $product['unified_profit'];
			
			// 是否是统一直销利润，统一直销利润，当为一级自己卖，则为第三级的利润
			$unified_profit = $product['unified_profit'];
			
			if ($drp_level == 1) {
				if ($unified_profit) {
					$tmp['reward_1'] = round(($product['drp_level_3_price'] - $product['drp_level_3_cost_price']) * (1 + $drp_degree_data['seller_reward_1'] / 100), 2);
				} else {
					$tmp['reward_1'] = round(($product['drp_level_1_price'] - $product['drp_level_1_cost_price']) * (1 + $drp_degree_data['seller_reward_1'] / 100), 2);
				}
				
				$tmp['reward_2'] = round(($product['drp_level_2_cost_price'] - $product['drp_level_1_cost_price']) * (1 + $drp_degree_data['seller_reward_2'] / 100), 2);
				$tmp['reward_3'] = round(($product['drp_level_2_cost_price'] - $product['drp_level_1_cost_price']) * (1 + $drp_degree_data['seller_reward_3'] / 100), 2);;
			} else if ($drp_level == 2) {
				if ($unified_profit) {
					$tmp['reward_1'] = round(($product['drp_level_3_price'] - $product['drp_level_3_cost_price']) * (1 + $drp_degree_data['seller_reward_1'] / 100), 2);
				} else {
					$tmp['reward_1'] = round(($product['drp_level_2_price'] - $product['drp_level_2_cost_price']) * (1 + $drp_degree_data['seller_reward_1'] / 100), 2);
				}
				
				$tmp['reward_2'] = round(($product['drp_level_3_cost_price'] - $product['drp_level_2_cost_price']) * (1 + $drp_degree_data['seller_reward_2'] / 100), 2);
				$tmp['reward_3'] = round(($product['drp_level_2_cost_price'] - $product['drp_level_1_cost_price']) * (1 + $drp_degree_data['seller_reward_3'] / 100), 2);
			} else {
				$tmp['reward_1'] = round(($product['drp_level_3_price'] - $product['drp_level_3_cost_price']) * (1 + $drp_degree_data['seller_reward_1'] / 100), 2);
				$tmp['reward_2'] = round(($product['drp_level_3_cost_price'] - $product['drp_level_2_cost_price']) * (1 + $drp_degree_data['seller_reward_2'] / 100), 2);
				$tmp['reward_3'] = round(($product['drp_level_2_cost_price'] - $product['drp_level_1_cost_price']) * (1 + $drp_degree_data['seller_reward_3'] / 100), 2);
			}
			
			$product_list[] = $tmp;
		}
		
		$return = array();
		if ($page == 1) {
			$return['fx_degree'] = $fx_degree_name;
		}
		$return['product_list'] = $product_list;
		$return['next_page'] = true;
		if (count($product_list) < $limit) {
			$return['next_page'] = false;
		}
		
		json_return(0, $return);
	}
	
	// 分销商品每个等级利润、平台或店铺未开启分销等级，直接提示报错信息
	public function product_detail() {
		if (option('config.open_drp_degree') != 1) {
			json_return(1000, '平台还未开启分销等级分润');
		}
		
		$product_id = $_REQUEST['product_id'];
		if (empty($product_id)) {
			json_return(1000, '缺少参数');
		}
		
		$store = $this->_storeCheck();
		
		if (empty($store['open_drp_degree'])) {
			json_return(1000, '商家还未开启分销等级分润');
		}
		
		$product = D('Product')->where(array('product_id' => $product_id))->field('product_id, name, image, store_id, price, unified_profit, drp_level_1_price, drp_level_2_price, drp_level_3_price, drp_level_1_cost_price, drp_level_2_cost_price, drp_level_3_cost_price')->find();
		if (empty($product) || $product['store_id'] != $store['top_supplier_id']) {
			json_return(1000, '未找到相应的商品');
		}
		$product['image'] = getAttachmentUrl($product['image']);
		
		// 当前分销商级别
		$drp_level = $store['drp_level'];
		
		// 是否是统一直销利润，统一直销利润，当为一级自己卖，则为第三级的利润
		$unified_profit = $product['unified_profit'];
		
		if ($drp_level == 1) {
			if ($unified_profit) {
				$product['reward_1'] = $product['drp_level_3_price'] - $product['drp_level_3_cost_price'];
			} else {
				$product['reward_1'] = $product['drp_level_1_price'] - $product['drp_level_1_cost_price'];
			}
			
			$product['reward_2'] = $product['drp_level_2_cost_price'] - $product['drp_level_1_cost_price'];
			$product['reward_3'] = $product['drp_level_2_cost_price'] - $product['drp_level_1_cost_price'];
		} else if ($drp_level == 2) {
			if ($unified_profit) {
				$product['reward_1'] = $product['drp_level_3_price'] - $product['drp_level_3_cost_price'];
			} else {
				$product['reward_1'] = $product['drp_level_2_price'] - $product['drp_level_2_cost_price'];
			}
			
			$product['reward_2'] = $product['drp_level_3_cost_price'] - $product['drp_level_2_cost_price'];
			$product['reward_3'] = $product['drp_level_2_cost_price'] - $product['drp_level_1_cost_price'];
		} else {
			$product['reward_1'] = $product['drp_level_3_price'] - $product['drp_level_3_cost_price'];
			$product['reward_2'] = $product['drp_level_3_cost_price'] - $product['drp_level_2_cost_price'];
			$product['reward_3'] = $product['drp_level_2_cost_price'] - $product['drp_level_1_cost_price'];
		}
		
		// 当开启分销等级时，操作分销商等级折扣
		$drp_degree_list = array(array('pigcms_id' => 0, 'name' => '未有等级', 'icon' => option('config.site_url') . '/template/wap/default/ucenter/images/kong.png', 'seller_reward_1' => 0, 'seller_reward_2' => 0, 'seller_reward_3' => 0));
		if (option('config.open_drp_degree') && $store['open_drp_degree']) {
			// 查找供货商的分销商等级
			$drp_degree_list_tmp = D('Drp_degree')->where(array('store_id' => $store['top_supplier_id'], 'status' => 1))->select();
			
			if (!empty($drp_degree_list_tmp)) {
				// 平台设置的默认等级数据
				$platform_drp_degree_list_tmp = D('Platform_drp_degree')->where(array('status' => 1))->select();
				$platform_drp_degree_list = array();
				foreach ($platform_drp_degree_list_tmp as $platform_degree) {
					$tmp = array();
					$tmp['pigcms_id'] = $platform_degree['pigcms_id'];
					$tmp['name'] = $platform_degree['name'];
					$tmp['icon'] = $platform_degree['icon'] ? getAttachmentUrl($platform_degree['icon']) : option('config.site_url') . '/template/wap/default/ucenter/images/kong.png';
					
					$platform_drp_degree_list[$platform_degree['pigcms_id']] = $tmp;
				}
				
				// 店铺设置的分销商等级
				foreach ($drp_degree_list_tmp as $drp_degree) {
					$tmp = array();
					$tmp['pigcms_id'] = $drp_degree['pigcms_id'];
					if (!empty($drp_degree['is_platform_degree_name']) && isset($platform_drp_degree_list[$drp_degree['is_platform_degree_name']])) {
						$tmp['name'] = $platform_drp_degree_list[$drp_degree['is_platform_degree_name']]['name'];
					} else if ($drp_degree['degree_alias']) {
						$tmp['name'] = $drp_degree['degree_alias'];
					} else {
						$tmp['name'] = '默认等级';
					}
					
					if (!empty($drp_degree['is_platform_degree_icon']) && isset($platform_drp_degree_list[$drp_degree['is_platform_degree_icon']])) {
						$tmp['icon'] = $platform_drp_degree_list[$drp_degree['is_platform_degree_icon']]['icon'];
					} else if ($drp_degree['degree_icon_custom']) {
						$tmp['icon'] = getAttachmentUrl($drp_degree['degree_icon_custom']);
					} else {
						$tmp['icon'] = option('config.site_url') . '/template/wap/default/ucenter/images/kong.png';
					}
					
					$tmp['seller_reward_1'] = $drp_degree['seller_reward_1'];
					$tmp['seller_reward_2'] = $drp_degree['seller_reward_2'];
					$tmp['seller_reward_3'] = $drp_degree['seller_reward_3'];
					
					$drp_degree_list[$drp_degree['pigcms_id']] = $tmp;
				}
				
				// 产品的等级折扣
				$product_drp_degree_list = D('Product_drp_degree')->where(array('product_id' => $product_id))->select();
				$product_drp_degree_list = array();
				foreach ($product_drp_degree_list as $product_drp_degree) {
					if (isset($drp_degree_list[$product_drp_degree['degree_id']])) {
						$drp_degree_list[$product_drp_degree['degree_id']]['seller_reward_1'] = $product_drp_degree['seller_reward_1'];
						$drp_degree_list[$product_drp_degree['degree_id']]['seller_reward_2'] = $product_drp_degree['seller_reward_2'];
						$drp_degree_list[$product_drp_degree['degree_id']]['seller_reward_3'] = $product_drp_degree['seller_reward_3'];
					}
				}
			}
		}
		
		$drp_degree_list = array_merge($drp_degree_list);
		
		$return = array();
		$return['degree_id'] = $store['drp_degree_id'];
		$return['product'] = $product;
		$return['drp_degree_list'] = $drp_degree_list;
		
		json_return(0, $return);
	}
	
	// 分销商品分享
	public function product_share() {
		$product_id = $_REQUEST['product_id'];
		if (empty($product_id)) {
			json_return(1000, '缺少参数');
		}
		
		$product = D('Product')->where(array('product_id' => $product_id, 'status' => 1))->find();
		if (empty($product)) {
			json_return(1000, '未找到相应的商品');
		}
		
		if (empty($product['is_fx'])) {
			json_return(1000, '产品未设置分销');
		}
		
		$store = $this->_storeCheck();
		
		if ($product['store_id'] == $store['store_id']) {
			json_return(1000, '您是本商品的供货商，不能分销');
		}
		
		if ($product['store_id'] != $store['top_supplier_id']) {
			json_return(1000, '未找到相应的商品');
		}
		
		$drp_level = $store['drp_level'];
		if ($drp_level > 3) {
			$drp_level = 3;
		}
		$product['cost_price'] = $product['drp_level_' . $drp_level . '_cost_price'];
		$product['price'] = $product['drp_level_' . $drp_level . '_price'];
		
		$zx_profit = array(); //直销利润
		$fx_profit = array(); //分销利润
		if (!empty($product['has_property'])) {
			$skus = D('Product_sku')->where(array('product_id' => $product_id))->select();
			foreach ($skus as $sku) {
				$zx_profit[] = $sku['drp_level_3_price'] - $sku['drp_level_3_cost_price'];
				$fx_profit[] = $sku['drp_level_' . ($drp_level + 1) . '_cost_price'] - $sku['drp_level_' . $drp_level . '_cost_price'];
			}
		} else {
			//3级利润
			$zx_profit[] = $product['drp_level_3_price'] - $product['drp_level_3_cost_price'];
			if ($drp_level == 3) {
				$fx_profit[] = $product['drp_level_3_price'] - $product['drp_level_3_cost_price'];
			} else {
				$fx_profit[] = $product['drp_level_' . ($drp_level + 1) . '_cost_price'] - $product['drp_level_' . $drp_level . '_cost_price'];
			}
		}
		if (!empty($product['unified_profit'])) {
			$min_profit = number_format(min($zx_profit), 2, '.', '');
			$max_profit = number_format(max($zx_profit), 2, '.', '');
		} else {
			$min_profit = number_format(min($fx_profit), 2, '.', '');
			$max_profit = number_format(max($fx_profit), 2, '.', '');
		}
		$product['min_profit'] = $min_profit;
		$product['max_profit'] = $max_profit;
		
		if ($product['min_profit'] == $product['max_profit']) {
			$product['profit'] = $product['max_profit'];
		} else {
			$product['profit'] = $product['min_profit'] . '~' . $product['max_profit'];
		}
		
		$return = array();
		$return['store_name'] = $store['name'];
		$return['product'] = array(
								'product_id' => $product['product_id'],
								'name' => $product['name'],
								'image' => getAttachmentUrl($product['image']),
								'price' => $product['price'],
								'profit' => $product['profit'],
								'qrcode' => option('config.site_url') . '/source/qrcode.php?type=good&id=' . $product_id . '&store_id=' . $store['store_id'],
								);
		
		if ($this->is_app) {
			$share_data = array();
			$share_data['title'] = $product['name'];
			$share_data['image'] = $return['product']['image'];
			$share_data['url'] = option('config.wap_site_url') . '/good.php?id=' . $product_id . '&store_id=' . $store['store_id'];
			$share_data['desc'] = '';
			$return['app_share_data'] = $share_data;
		} else {
			$url = urldecode($_REQUEST['url']);
			// 分享
			import('WechatShare');
			$share = new WechatShare();
			$share_data = $share->getSgin('', true, $url);
			$return['wap_share_data'] = $share_data;
		}
		
		json_return(0, $return);
	}
	
	// 分销订单，用户在本店铺买的订单
	public function order() {
		$store = $this->_storeCheck();
		
		$page = max(1, $_REQUEST['page']);
		$type = $_REQUEST['type'];
		$limit = 10;
		
		if (!in_array($type, array(1, 2))) {
			$type = 1;
		}
		
		$where = array();
		$where['store_id'] = $store['store_id'];
		if ($type == 1) {
			$where['status'] = array('in', array(2, 3, 6, 7));
		} else {
			$where['status'] = 4;
		}
		
		$offset = ($page - 1) * $limit;
		$order_list_tmp = M('Order')->getOrdersByStatus($where, $offset, $limit);
		
		$order_list = array();
		foreach ($order_list_tmp as $order) {
			$tmp = array();
			$tmp['order_id'] = $order['order_id'];
			
			//订单来源
			if (!empty($order['is_fx'])) {
				$seller = array('store_id' => $store['store_id'], 'name' => '本店');
			} else {
				$tmp_seller = D('Fx_order')->field('store_id')->where(array('fx_order_id' => $order['fx_order_id']))->find();
				$seller_id = $tmp_seller['store_id'];
				$seller = D('Store')->field('store_id,name')->where(array('store_id' => $seller_id))->find();
			}
			
			$tmp['store_id'] = $seller['store_id'];
			$tmp['store_name'] = $seller['name'];
			
			$fans = '游客';
			if (!empty($order['address_user'])) {
				$fans = $order['address_user'];
			} else if (!empty($order['uid'])) {
				$userinfo = $user->getUserById($order['uid']);
				$fans = !empty($userinfo['nickname']) ? $userinfo['nickname'] : '匿名';
			}
			
			$tmp['fans'] = $fans;
			$tmp['total'] = $order['total'];
			$tmp['add_time'] = $order['add_time'];
			
			$profit = M('Financial_record')->getTotal(array('order_id' => $order['order_id']));
			$tmp['profit'] = $profit;
			
			$order_list[] = $tmp;
		}
		
		$return = array();
		$return['order_list'] = $order_list;
		$return['next_page'] = true;
		if (count($order_list) < $limit) {
			$return['next_page'] = false;
		}
		
		if ($page == 1) {
			// 未分佣订单数
			$return['uncomplated_count'] = M('Order')->getOrderCountByStatus(array('store_id' => $store['store_id'], 'status' => array('in', array(2, 3, 6, 7))));
			//已分佣订单数
			$return['complated_count'] = M('Order')->getOrderCountByStatus(array('store_id' => $store['store_id'], 'status' => 4));
		}
		
		json_return(0, $return);
	}
	
	// 利润图表
	public function statistics() {
		$store = $this->_storeCheck();
		$type = $_REQUEST['type'];
		
		if (!in_array($type, array('today', 'yesterday', 'week', 'month'))) {
			$type = 'today';
		}
		
		$financial_record = M('Financial_record');
		
		if ($type == 'today') {
			//今日佣金 00:00-6:00 6:00-12:00 12:00-18:00 18:00-24:00
			//00:00-6:00
			$starttime = strtotime(date('Y-m-d') . ' 00:00:00');
			$stoptime  = strtotime(date('Y-m-d') . ' 06:00:00');
			$where = array();
			$where['store_id'] = $store['store_id'];
			$where['status']   = array('in', array(1, 3));
			$where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
			$todaycommissiontotal_0_6 = $financial_record->drpProfit($where);
			if (!$todaycommissiontotal_0_6) {
				$todaycommissiontotal_0_6 = 0;
			}
			
			//6:00-12:00
			$starttime = strtotime(date('Y-m-d') . ' 06:00:00');
			$stoptime  = strtotime(date('Y-m-d') . ' 12:00:00');
			$where = array();
			$where['store_id'] = $store['store_id'];
			$where['status']   = array('in', array(1, 3));
			$where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
			$todaycommissiontotal_6_12 = $financial_record->drpProfit($where);
			if (!$todaycommissiontotal_6_12) {
				$todaycommissiontotal_6_12 = 0;
			}
			
			//12:00-18:00
			$starttime = strtotime(date('Y-m-d') . ' 12:00:00');
			$stoptime  = strtotime(date('Y-m-d') . ' 18:00:00');
			$where = array();
			$where['store_id'] = $store['store_id'];
			$where['status']   = array('in', array(1, 3));
			$where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
			$todaycommissiontotal_12_18 = $financial_record->drpProfit($where);
			if (!$todaycommissiontotal_12_18) {
				$todaycommissiontotal_12_18 = 0;
			}
			
			//18:00-24:00
			$starttime = strtotime(date('Y-m-d') . ' 18:00:00');
			$stoptime  = strtotime(date('Y-m-d') . ' 23:59:59');
			$where = array();
			$where['store_id'] = $store['store_id'];
			$where['status']   = array('in', array(1, 3));
			$where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
			$todaycommissiontotal_18_24 = $financial_record->drpProfit($where);
			if (!$todaycommissiontotal_18_24) {
				$todaycommissiontotal_18_24 = 0;
			}
			
			$return = array();
			$return['data'] = $todaycommissiontotal_0_6 . ',' . $todaycommissiontotal_6_12 . ',' . $todaycommissiontotal_12_18 . ',' . $todaycommissiontotal_18_24;
			// 金额
			$unbalance = !empty($store['unbalance']) ? $store['unbalance'] : 0;
			$balance = !empty($store['balance']) ? $store['balance'] : 0;
			$money_arr = array();
			$money_arr['balance'] = number_format($balance, 2, '.', '');
			$money_arr['unbalance'] = number_format($unbalance, 2, '.', '');
				
			$return['money_arr'] = $money_arr;
			json_return(0, $return);
		} else if ($type == 'yesterday') {
			//昨日佣金 00:00-6:00 6:00-12:00 12:00-18:00 18:00-24:00
			$date = date('Y-m-d' , strtotime('-1 day'));
			
			//00:00-6:00
			$starttime = strtotime($date . ' 00:00:00');
			$stoptime  = strtotime($date . ' 06:00:00');
			$where = array();
			$where['store_id'] = $store['store_id'];
			$where['status']   = array('in', array(1, 3));
			$where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
			$yesterdaycommissiontotal_0_6 = $financial_record->drpProfit($where);
			if (!$yesterdaycommissiontotal_0_6) {
				$yesterdaycommissiontotal_0_6 = 0;
			}
			
			//6:00-12:00
			$starttime = strtotime($date . ' 06:00:00');
			$stoptime  = strtotime($date . ' 12:00:00');
			$where = array();
			$where['store_id'] = $store['store_id'];
			$where['status']   = array('in', array(1, 3));
			$where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
			$yesterdaycommissiontotal_6_12 = $financial_record->drpProfit($where);
			if (!$yesterdaycommissiontotal_6_12) {
				$yesterdaycommissiontotal_6_12 = 0;
			}
			
			//12:00-18:00
			$starttime = strtotime($date . ' 12:00:00');
			$stoptime  = strtotime($date . ' 18:00:00');
			$where = array();
			$where['store_id'] = $store['store_id'];
			$where['status']   = array('in', array(1, 3));
			$where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
			$yesterdaycommissiontotal_12_18 = $financial_record->drpProfit($where);
			if (!$yesterdaycommissiontotal_12_18) {
				$yesterdaycommissiontotal_12_18 = 0;
			}
			
			//18:00-24:00
			$starttime = strtotime($date . ' 18:00:00');
			$stoptime  = strtotime($date . ' 23:59:59');
			$where = array();
			$where['store_id'] = $store['store_id'];
			$where['status']   = array('in', array(1, 3));
			$where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
			$yesterdaycommissiontotal_18_24 = $financial_record->drpProfit($where);
			if (!$yesterdaycommissiontotal_18_24) {
				$yesterdaycommissiontotal_18_24 = 0;
			}
			
			$return = array();
			$return['data'] = $yesterdaycommissiontotal_0_6 . ',' . $yesterdaycommissiontotal_6_12 . ',' . $yesterdaycommissiontotal_12_18 . ',' . $yesterdaycommissiontotal_18_24;
			// 金额
			$unbalance = !empty($store['unbalance']) ? $store['unbalance'] : 0;
			$balance = !empty($store['balance']) ? $store['balance'] : 0;
			$money_arr = array();
			$money_arr['balance'] = number_format($balance, 2, '.', '');
			$money_arr['unbalance'] = number_format($unbalance, 2, '.', '');
				
			$return['money_arr'] = $money_arr;
			json_return(0, $return);
		} else if ($type == 'week') {
			$date = date('Y-m-d');  //当前日期
			$first = 1; //$first =1 表示每周星期一为开始日期 0表示每周日为开始日期
			$w = date('w',strtotime($date));  //获取当前周的第几天 周日是 0 周一到周六是 1 - 6
			$now_start = date('Y-m-d',strtotime("$date -".($w ? $w - $first : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天
			$now_end   = date('Y-m-d',strtotime("$now_start +6 days"));  //本周结束日期
			
			//周一佣金
			$starttime = strtotime($now_start . ' 00:00:00');
			$stoptime  = strtotime($now_start . ' 23:59:59');
			$where = array();
			$where['store_id'] = $store['store_id'];
			$where['status']   = array('in', array(1, 3));
			$where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
			$weekcommissiontotal_1 = $financial_record->drpProfit($where);
			if (!$weekcommissiontotal_1) {
				$weekcommissiontotal_1 = 0;
			}
			//周二佣金
			$starttime = strtotime(date("Y-m-d",strtotime($now_start . "+1 day")) . ' 00:00:00');
			$stoptime  = strtotime(date("Y-m-d",strtotime($now_start . "+1 day")) . ' 23:59:59');
			$where = array();
			$where['store_id'] = $store['store_id'];
			$where['status']   = array('in', array(1, 3));
			$where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
			$weekcommissiontotal_2 = $financial_record->drpProfit($where);
			if (!$weekcommissiontotal_2) {
				$weekcommissiontotal_2 = 0;
			}
			//周三佣金
			$starttime = strtotime(date("Y-m-d",strtotime($now_start . "+2 day")) . ' 00:00:00');
			$stoptime  = strtotime(date("Y-m-d",strtotime($now_start . "+2 day")) . ' 23:59:59');
			$where = array();
			$where['store_id'] = $store['store_id'];
			$where['status']   = array('in', array(1, 3));
			$where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
			$weekcommissiontotal_3 = $financial_record->drpProfit($where);
			if (!$weekcommissiontotal_3) {
				$weekcommissiontotal_3 = 0;
			}
			//周四佣金
			$starttime = strtotime(date("Y-m-d",strtotime($now_start . "+3 day")) . ' 00:00:00');
			$stoptime  = strtotime(date("Y-m-d",strtotime($now_start . "+3 day")) . ' 23:59:59');
			$where = array();
			$where['store_id'] = $store['store_id'];
			$where['status']   = array('in', array(1, 3));
			$where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
			$weekcommissiontotal_4 = $financial_record->drpProfit($where);
			if (!$weekcommissiontotal_4) {
				$weekcommissiontotal_4 = 0;
			}
			//周五佣金
			$starttime = strtotime(date("Y-m-d",strtotime($now_start . "+4 day")) . ' 00:00:00');
			$stoptime  = strtotime(date("Y-m-d",strtotime($now_start . "+4 day")) . ' 23:59:59');
			$where = array();
			$where['store_id'] = $store['store_id'];
			$where['status']   = array('in', array(1, 3));
			$where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
			$weekcommissiontotal_5 = $financial_record->drpProfit($where);
			if (!$weekcommissiontotal_5) {
				$weekcommissiontotal_5 = 0;
			}
			//周六佣金
			$starttime = strtotime(date("Y-m-d",strtotime($now_start . "+5 day")) . ' 00:00:00');
			$stoptime  = strtotime(date("Y-m-d",strtotime($now_start . "+5 day")) . ' 23:59:59');
			$where = array();
			$where['store_id'] = $store['store_id'];
			$where['status']   = array('in', array(1, 3));
			$where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
			$weekcommissiontotal_6 = $financial_record->drpProfit($where);
			if (!$weekcommissiontotal_6) {
				$weekcommissiontotal_6 = 0;
			}
			//周日佣金
			$starttime = strtotime(date("Y-m-d",strtotime($now_start . "+6 day")) . ' 00:00:00');
			$stoptime  = strtotime(date("Y-m-d",strtotime($now_start . "+6 day")) . ' 23:59:59');
			$where = array();
			$where['store_id'] = $store['store_id'];
			$where['status']   = array('in', array(1, 3));
			$where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
			$weekcommissiontotal_7 = $financial_record->drpProfit($where);
			if (!$weekcommissiontotal_7) {
				$weekcommissiontotal_7 = 0;
			}
			
			$return = array();
			$return['data'] = $weekcommissiontotal_1 . ',' . $weekcommissiontotal_2 . ',' . $weekcommissiontotal_3 . ',' . $weekcommissiontotal_4 . ',' . $weekcommissiontotal_5 . ',' . $weekcommissiontotal_6 . ',' . $weekcommissiontotal_7;
			// 金额
			$unbalance = !empty($store['unbalance']) ? $store['unbalance'] : 0;
			$balance = !empty($store['balance']) ? $store['balance'] : 0;
			$money_arr = array();
			$money_arr['balance'] = number_format($balance, 2, '.', '');
			$money_arr['unbalance'] = number_format($unbalance, 2, '.', '');
				
			$return['money_arr'] = $money_arr;
			json_return(0, $return);
		} else {
			$month = date('m');
			$year  = date('Y');
			//1-7日
			$starttime = strtotime($year . '-' . $month . '-01' . ' 00:00:00');
			$stoptime  = strtotime($year . '-' . $month . '-07' . ' 00:00:00');
			$where = array();
			$where['store_id'] = $store['store_id'];
			$where['status']   = array('in', array(1, 3));
			$where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
			$monthcommissiontotal_1_7 = $financial_record->drpProfit($where);
			if (!$monthcommissiontotal_1_7) {
				$monthcommissiontotal_1_7 = 0;
			}
			//7-14日
			$starttime = strtotime($year . '-' . $month . '-07' . ' 00:00:00');
			$stoptime  = strtotime($year . '-' . $month . '-14' . ' 00:00:00');
			$where = array();
			$where['store_id'] = $store['store_id'];
			$where['status']   = array('in', array(1, 3));
			$where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
			$monthcommissiontotal_7_14 = $financial_record->drpProfit($where);
			if (!$monthcommissiontotal_7_14) {
				$monthcommissiontotal_7_14 = 0;
			}
			//14-21日
			$starttime = strtotime(($year . '-' . $month . '-14') . ' 00:00:00');
			$stoptime  = strtotime(($year . '-' . $month . '-21') . ' 00:00:00');
			$where = array();
			$where['store_id'] = $store['store_id'];
			$where['status']   = array('in', array(1, 3));
			$where['_string']  = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
			$monthcommissiontotal_14_21 = $financial_record->drpProfit($where);
			if (!$monthcommissiontotal_14_21) {
				$monthcommissiontotal_14_21 = 0;
			}
			//21-本月结束
			//当月最后一天
			$lastday = date('t',time());
			$starttime = strtotime($year . '-' . $month . '-21' . ' 00:00:00');
			$stoptime  = strtotime($year . '-' . $month . '-' . $lastday . ' 23:59:59');
			$where = array();
			$where['store_id'] = $store['store_id'];
			$where['status']   = array('in', array(1, 3));
			$where['_string']  = "add_time >= " . $starttime . " AND add_time <= " . $stoptime;
			$monthcommissiontotal_21_end = $financial_record->drpProfit($where);
			if (!$monthcommissiontotal_21_end) {
				$monthcommissiontotal_21_end = 0;
			}
			
			$return = array();
			$monthcommissiontotal = $monthcommissiontotal_1_7 . ',' . $monthcommissiontotal_7_14 . ',' . $monthcommissiontotal_14_21 . ',' . $monthcommissiontotal_21_end;
			$return['data'] = $monthcommissiontotal;
			$return['lastday'] = $lastday;
			
			// 金额
			$unbalance = !empty($store['unbalance']) ? $store['unbalance'] : 0;
			$balance = !empty($store['balance']) ? $store['balance'] : 0;
			$money_arr = array();
			$money_arr['balance'] = number_format($balance, 2, '.', '');
			$money_arr['unbalance'] = number_format($unbalance, 2, '.', '');
			
			$return['money_arr'] = $money_arr;
			
			json_return(0, $return);
		}
	}
	
	// 利润统计列表
	public function profit_list() {
		$store = $this->_storeCheck();
		
		$page = max(1, $_REQUEST['page']);
		$date = strtolower(trim($_REQUEST['date']));
		$limit = 10;
		
		$financial_record = M('Financial_record');
		
		$where = array();
		$where['store_id'] = $store['store_id'];
		if ($date == 'today') { //今天佣金明细
			$starttime = strtotime(date("Y-m-d") . ' 00:00:00');
			$stoptime  = strtotime(date("Y-m-d") . ' 23:59:59');
			$where['_string'] = "add_time >= " . $starttime . " AND add_time <= " . $stoptime;
		} else if ($date == 'yesterday') { //昨天佣金明细
			$date = date('Y-m-d' , strtotime('-1 day'));
			$starttime = strtotime($date . ' 00:00:00');
			$stoptime  = strtotime($date . ' 23:59:59');
			$where['_string'] = "add_time >= " . $starttime . " AND add_time <= " . $stoptime;
		} else if ($date == 'week') { //本周佣金明细
			$date = date('Y-m-d');  //当前日期
			$first = 1; //$first =1 表示每周星期一为开始日期 0表示每周日为开始日期
			$w = date('w',strtotime($date));  //获取当前周的第几天 周日是 0 周一到周六是 1 - 6
			$now_start = date('Y-m-d',strtotime("$date -".($w ? $w - $first : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天
			$now_end   = date('Y-m-d',strtotime("$now_start +6 days"));  //本周结束日期
			
			$starttime = strtotime($now_start . ' 00:00:00');
			$stoptime  = strtotime($now_end . ' 23:59:59');
			$where['_string'] = "add_time >= " . $starttime . " AND add_time <= " . $stoptime;
		} else if ($date == 'month') { //本月佣金明细
			$month = date('m');
			$year = date('Y');
			//当月最后一天
			$lastday = date('t',time());
			
			$starttime = strtotime($year . '-' . $month . '-01' . ' 00:00:00');
			$stoptime = strtotime($year . '-' . $month . '-' . $lastday . ' 23:59:59');
			$where['_string'] = "add_time >= " . $starttime . " AND add_time <= " . $stoptime;
		}
		
		$offset = ($page - 1) * $limit;
		$financial_record_list_tmp = $financial_record->getProfitRecords($where, $offset, $limit);
		$financial_record_list = array();
		$prefix = option('config.orderid_prefix');
		foreach ($financial_record_list_tmp as $financial_record) {
			// 退货
			$return_profit = D('Financial_record')->where(array('order_id' => $financial_record['order_id'], 'store_id' => $financial_record['store_id'], 'type' => 3))->sum('income');
			
			$tmp = array();
			$tmp['order_id'] = $financial_record['order_id'];
			$tmp['order_no'] = $prefix . $financial_record['order_no'];
			$tmp['profit'] = $financial_record['profit'] + $return_profit;
			$tmp['add_time'] = $financial_record['add_time'];
			
			$financial_record_list[] = $tmp;
		}
		
		$return = array();
		$return['financial_record_list'] = $financial_record_list;
		$return['next_page'] = true;
		if (count($financial_record_list) < $limit) {
			$return['next_page'] = false;
		}
		
		json_return(0, $return);
	}
	
	// 订单详情
	public function order_detail() {
		$order_id = $_REQUEST['order_id'];
		if (empty($order_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		$store = $this->_storeCheck();
		
		$order_model = M('Order');
		$order = $order_model->getOrder($store['store_id'], $order_id);
		if (empty($order)) {
			json_return(1000, '未找到相应的订单');
		}
		
		//订单状态
		$order_status = $order_model->status();
		
		$order['order_no'] = option('config.orderid_prefix') . $order['order_no'];
		$order['address'] = unserialize($order['address']);
		$order['address'] = $order['address']['province'] . ' ' . $order['address']['city'] . ' ' . $order['address']['area'] . ' ' . $order['address']['address'];
		$order['status_txt'] = $order_status[$order['status']];
		
		//供货商
		$fx_order = M('Fx_order')->getSellerOrder($store['store_id'], $order_id);
		$supplier = D('Store')->field('name')->where(array('store_id' => $fx_order['supplier_id']))->find();
		$order['supplier'] = $supplier['name'];
		
		//订单来源
		if (empty($order['fx_order_id'])) {
			$order['from'] = '本店';
		} else {
			$fx_order = D('Fx_order')->field('store_id')->where(array('fx_order_id' => $order['fx_order_id']))->find();
			$seller = D('Store')->field('name')->where(array('store_id' => $fx_order['store_id']))->find();
			$order['from'] = $seller['name'];
		}
		
		//利润
		$profit = M('Financial_record')->getTotal(array('order_id' => $order_id));
		$order['profit'] = $profit;
		
		$product_list = M('Order_product')->getProducts($order_id);
		
		foreach ($product_list as $key => $product) {
			$product_list[$key]['image'] = getAttachmentUrl($product['image']);
			if (!empty($product['sku_data'])) {
				$sku_data = unserialize($product['sku_data']);
				$product_list[$key]['sku_data'] = $sku_data;
			} else {
				$product_list[$key]['sku_data'] = array();
			}
			//向后兼容利润计算
			$no_profit = false;
			if ($product['profit'] == 0) {
				$fx_order = D('Fx_order')->field('fx_order_id')->where(array('order_id' => $order['order_id']))->find();
				$fx_order_product = D('Fx_order_product')->field('cost_price')->where(array('fx_order_id' => $fx_order['fx_order_id'], 'source_product_id' => $product['product_id']))->find();
				$product['cost_price'] = $fx_order_product['cost_price'];
				$product['profit'] = $product['pro_price'] - $product['cost_price'];
				if ($product['profit'] <= 0) {
					$product['profit'] = 0;
					$no_profit = true;
				}
			}
			
			$product['cost_price'] = ($product['pro_price'] - $product['profit'] > 0) ? $product['pro_price'] - $product['profit'] : 0;
			if ($product['profit'] == 0 && empty($product['supplier_id']) && empty($no_profit)) {
				$product['profit'] = $product['pro_price'];
			}
			$product_list[$key]['profit'] = number_format($product['profit'], 2, '.', '');
			$product_list[$key]['cost_price'] = number_format($product['cost_price'], 2, '.', '');
		}
		
		//包裹
		$where = array();
		$where['user_order_id'] = array('in', array($order['order_id'], $order['user_order_id']));
		$package_list = M('Order_package')->getPackages($where);
		
		$return = array();
		$return['order'] = $order;
		$return['product_list'] = $product_list;
		$return['package_list'] = $package_list;
		json_return(0, $return);
		print_r($return);
	}
	
	// 提现列表
	public function withdrawal_list() {
		$store = $this->_storeCheck();
		$page = max(1, $_REQUEST['page']);
		$limit = 10;
		$offset = ($page - 1) * $limit;
		
		$store_withdrawal_list = D('Store_withdrawal')->where(array('store_id' => $store['store_id']))->limit($offset . ', ' . $limit)->select();
		$status_arr = M('Store_withdrawal')->getWithdrawalStatus();
		foreach ($store_withdrawal_list as &$store_withdrawal) {
			$store_withdrawal['status_txt'] = isset($status_arr[$store_withdrawal['status']]) ? $status_arr[$store_withdrawal['status']] : '';
		}
		
		$return = array();
		$return['store_withdrawal_list'] = $store_withdrawal_list;
		$return['next_page'] = true;
		if (count($store_withdrawal_list) < $limit) {
			$return['next_page'] = false;
		}
		
		json_return(0, $return);
	}
	
	// 提现帐号
	public function withdrawal_account() {
		$store = $this->_storeCheck();
		$bank_list = D('Bank')->where(array('status' => 1))->select();
		
		// 提交保存提现帐号
		if ($_POST['action'] == 'submit') {
			$bank_id = $_REQUEST['bank_id'];
			$bank_card = $_REQUEST['bank_card'];
			$bank_card_user = $_REQUEST['bank_card_user'];
			$opening_bank = $_REQUEST['opening_bank'];
			
			if (empty($bank_id) || empty($bank_card) || empty($bank_card_user) || empty($opening_bank)) {
				json_return(1000, '请填写完整数据');
			}
			
			$bank = D('Bank')->where(array('bank_id' => $bank_id, 'status' => 1))->find();
			if (empty($bank)) {
				json_return(1000, '您所选的银行不存在');
			}
			
			$data = array();
			$data['bank_id'] = $bank_id;
			$data['bank_card'] = $bank_card;
			$data['bank_card_user'] = $bank_card_user;
			$data['opening_bank'] = $opening_bank;
			
			D('Store')->where(array('store_id' => $store['store_id']))->data($data)->save();
			
			json_return(0, '操作完成');
		}
		
		$return = array();
		$return['bank_list'] = $bank_list;
		$return['store'] = array('bank_id' => $store['bank_id'], 'bank_card' => $store['bank_card'], 'bank_card_user' => $store['bank_card_user'], 'opening_bank' => $store['opening_bank']);
		
		json_return(0, $return);
	}
	
	// 提现申请
	public function withdrawal() {
		$store = $this->_storeCheck();
		
		$withdrawal_min_amount = Drp::withdrawal_min($store['root_supplier_id']);
		
		if ($_POST['action'] == 'submit') {
			if ($withdrawal_min_amount > 0 && $withdrawal_min_amount > $_POST['amount']) {
				json_return(1000, '申请提现最底不能少于' . $withdrawal_min_amount . '元');
			}
			
			$data = array();
			$data['supplier_id'] = $store['top_supplier_id'];
			$data['trade_no'] = date('YmdHis',$_SERVER['REQUEST_TIME']).mt_rand(100000,999999);
			$data['uid'] = $store['uid'];
			$data['store_id'] = $store['store_id'];
			$data['bank_id'] = $store['bank_id'];
			$data['opening_bank'] = $store['opening_bank'];
			$data['bank_card'] = $store['bank_card'];
			$data['bank_card_user'] = $store['bank_card_user'];
			$data['withdrawal_type'] = 0; //对私
			$data['amount'] = isset($_POST['amount']) ? floatval(trim($_POST['amount'])) : 0;
			$data['status'] = 1; //申请中
			$data['add_time'] = time();
			
			if ($store['balance'] >= $data['amount']) {
				if (M('Store_withdrawal')->add($data)) {
					//减余额
					M('Store')->applywithdrawal($data['store_id'], $data['amount']);
					json_return(0, '提现申请成功');
				} else {
					json_return(1000, '提现申请失败');
				}
			} else {
				json_return(1000, '余额不足，提现失败');
			}
		}
		
		//可提现金额
		$balance = number_format($store['balance'], 2, '.', '');
		//佣金总额
		$income = number_format($store['income'], 2, '.', '');
		//开户行
		$bank_name = '';
		if (!empty($store['bank_id'])) {
			$bank = M('Bank')->getBank($store['bank_id']);
			$bank_name = $bank['name'];
		}
		
		$data = array();
		$data['balance'] = $balance;
		$data['income'] = $income;
		$data['bank_id'] = $store['bank_id'];
		$data['bank_name'] = $bank_name;
		$data['bank_card'] = $store['bank_card'];
		$data['bank_card_user'] = $store['bank_card_user'];
		$data['opening_bank'] = $store['opening_bank'];
		$data['withdrawal_min_amount'] = $withdrawal_min_amount;
		
		$return = array();
		$return['store'] = $data;
		
		json_return(0, $return);
	}
	
	// 我的团队
	public function team() {
		$open_drp_team = option('config.open_drp_team');
		if (empty($open_drp_team)) {
			json_return(1000, '未开启分销团队');
		}
		
		$store = $this->_storeCheck();
		// 获取第一级分销商
		$store_level_1 = array();
		if ($store['drp_level'] > 1) {
			$fx_supplier_info = D('Store_supplier')->where(array('root_supplier_id' => $store['top_supplier_id'], 'seller_id' => $store['store_id']))->find();
			$fx_store_id = explode(',', $fx_supplier_info['supply_chain']);
			$store_level_1 = D('Store')->where(array('store_id' => $fx_store_id[2]))->find();
		} else if($store['drp_level'] == 1) {
			$store_level_1 = $store;
		}
		
		// 没找到一级分销商，直接报错
		if (empty($store_level_1)) {
			json_return(1000, '团队数据错误');
		}
		
		// 获取分销团队
		$drp_team = M('Drp_team')->getDrpTeam(array('store_id' => $store_level_1['store_id']));
		
		// 成员数量进行实时统计
		$member_num = D('Store_supplier')->where('FIND_IN_SET(' . $store_level_1['store_id'] . ', supply_chain)')->count('*');
		
		$level_1 = M('Drp_team')->getMemberCountByLevel($store['store_id'], $store['drp_level'] + 1, true, true);
		$level_2 = M('Drp_team')->getMemberCountByLevel($store['store_id'], $store['drp_level'] + 2, true, true);
		
		$drp_team_member_list = array(
									array('name' => '直属成员', 'level' => $store['drp_level'] + 1, 'member_count' => $level_1['member_count'], 'orders' => $level_1['orders'], 'sales' => $level_1['sales']),
									array('name' => '下级成员', 'level' => $store['drp_level'] + 2, 'member_count' => $level_2['member_count'], 'orders' => $level_2['orders'], 'sales' => $level_2['sales'])
								);
		
		// 没有分销团队
		if (empty($drp_team)) {
			$drp_team['logo'] = option('config.site_url') . '/static/images/default_shop_2.jpg';
			$drp_team['name'] = $store_level_1['name'];
			$drp_team['team_level'] = 1;
			$drp_team['sales'] = $store['sales'];
			$drp_team['team_level'] = 1;
		} else {
			$drp_team['logo'] = $drp_team['logo'] ? getAttachmentUrl($drp_team['logo']) : option('config.site_url') . '/static/images/default_shop_2.jpg';
			$drp_team['team_level'] = M('Drp_team')->getTeamRank($team_info['pigcms_id']);
			
			$drp_team_member_label_list = D('Drp_team_member_label')->where(array('team_id' => $drp_team['pigcms_id']))->order('drp_level ASC')->select();
			foreach ($drp_team_member_label_list as $drp_team_member_label) {
				if ($drp_team_member_label['drp_level'] == $store['drp_level'] + 1) {
					$drp_team_member_list[0]['name'] = $drp_team_member_label['name'];
				} else if ($drp_team_member_label['drp_level'] == $store['drp_level'] + 2) {
					$drp_team_member_list[1]['name'] = $drp_team_member_label['name'];
				}
			}
		}
		
		$drp_team['members'] = $member_num;
		$drp_team['store_name'] = $store_level_1['name'];
		
		$return = array();
		$return['drp_team'] = $drp_team;
		$return['drp_label_list'] = $drp_team_member_list;
		
		json_return(0, $return);
	}
	
	// 团队管理
	public function team_manage() {
		$open_drp_team = option('config.open_drp_team');
		if (empty($open_drp_team)) {
			json_return(1000, '未开启分销团队');
		}
		
		$store = $this->_storeCheck();
		// 获取第一级分销商
		$store_level_1 = array();
		if ($store['drp_level'] > 1) {
			$fx_supplier_info = D('Store_supplier')->where(array('root_supplier_id' => $store['top_supplier_id'], 'seller_id' => $store['store_id']))->find();
			$fx_store_id = explode(',', $fx_supplier_info['supply_chain']);
			$store_level_1 = D('Store')->where(array('store_id' => $fx_store_id[2]))->find();
		} else if($store['drp_level'] == 1) {
			$store_level_1 = $store;
		}
		
		// 获取分销团队
		$drp_team = M('Drp_team')->getDrpTeam(array('store_id' => $store_level_1['store_id']));
		
		// 一级分销商如果没有设置团队，不能进行团队管理
		if ($store['drp_level'] > 1 && empty($drp_team)) {
			json_return(1000, '暂未设置团队');
		}
		
		//下属团队别名
		$team_member_label_list = array();
		if ($drp_team) {
			$where = array();
			$where['team_id'] = $drp_team['pigcms_id'];
			$where['store_id'] = $store['store_id'];
			$team_member_label_list = M('Drp_team_member_label')->getMemberLabels($where);
		}
		
		if ($_REQUEST['action'] == 'upload') {
			if (empty($_REQUEST['logo'])) {
				json_return(1000, '参数错误');
			}
			
			// 分销等级大于1级，不能更改团队图片
			if ($store['drp_level'] > 1) {
				json_return(1000, '您不能更改团队logo');
			}
			
			$data = array();
			$data['store_id'] = $store['store_id'];
			$data['supplier_id'] = $store['top_supplier_id'];
			$data['logo'] = getAttachment($_REQUEST['logo']);
			
			if (empty($drp_team)) {
				$data['name'] = $store['name'];
				$data['add_time'] = time();
				
				$result = D('Drp_team')->data($data)->add();
				if ($result) {
					// 更新团队成员
					M('Drp_team')->setMembers($result);
					json_return('0','操作成功');
				}
				json_return(1000, '上传失败');
			} else {
				$result = D('Drp_team')->where(array('pigcms_id' => $drp_team['pigcms_id']))->data($data)->save();
				if ($result) {
					json_return('0','操作成功');
				}
				json_return(1000, '上传失败');
			}
		} else if ($_REQUEST['action'] == 'edit') {
			$team_name = $_REQUEST['team_name'];
			$member_label_1 = $_REQUEST['member_label_1'] ? $_REQUEST['member_label_1'] : '直属成员';
			$member_label_2 = $_REQUEST['member_label_2'] ? $_REQUEST['member_label_2'] : '下级成员';
			
			$store_name = $_REQUEST['store_name'];
			$intro = $_REQUEST['intro'];
			
			// 当前分销商为1级分销商时，可以更改团队名称
			if ($store['drp_level'] == 1) {
				$data = array();
				$data['store_id'] = $store['store_id'];
				$data['supplier_id'] = $store['top_supplier_id'];
				$data['name'] = $team_name ? $team_name : $store['name'];
				
				if (empty($drp_team)) {
					$data['add_time'] = time();
					
					
					$result = D('Drp_team')->data($data)->add();
					if ($result) {
						// 更新团队成员
						M('Drp_team')->setMembers($result);
						$data['pigcms_id'] = $result;
						$drp_team = $data;
					} else {
						json_return(1000, '操作失败');
					}
				} else {
					$result = D('Drp_team')->where(array('pigcms_id' => $drp_team['pigcms_id']))->data($data)->save();
				}
			}
			
			// 团队成员别称设置
			if ($team_member_label_list) {
				foreach ($team_member_label_list as $team_member_label) {
					if ($team_member_label['drp_level'] == $store['drp_level'] + 1) {
						D('drp_Team_member_label')->where(array('pigcms_id' => $team_member_label['pigcms_id']))->data(array('name' => $member_label_1))->save();
					} else if ($team_member_label['drp_level'] == $store['drp_level'] + 2) {
						D('drp_Team_member_label')->where(array('pigcms_id' => $team_member_label['pigcms_id']))->data(array('name' => $member_label_2))->save();
					}
				}
			} else {
				$data = array();
				$data['team_id'] = $drp_team['pigcms_id'];
				$data['store_id'] = $store['store_id'];
				
				// 直属成员数据
				$data['name'] = $member_label_1;
				$data['drp_level'] = $store['drp_level'] + 1;
				D('drp_Team_member_label')->data($data)->add();
				
				// 二级成员数据
				$data['name'] = $member_label_2;
				$data['drp_level'] = $store['drp_level'] + 2;
				D('drp_Team_member_label')->data($data)->add();
			}
			
			// 更新店铺名称与简介
			$data = array();
			$data['name'] = $store_name ? $store_name : $store['name'];
			$data['intro'] = $intro;
			D('Store')->where(array('store_id' => $store['store_id']))->data($data)->save();
			
			json_return(0, '操作成功');
		}
		
		// 分销团队
		if ($drp_team) {
			$drp_team['logo'] = $drp_team['logo'] ? getAttachmentUrl($drp_team['logo']) : option('config.site_url') . '/static/images/default_shop_2.jpg';
		} else {
			$drp_team['name'] = $store_level_1['name'];
			$drp_team['logo'] = option('config.site_url') . '/static/images/default_shop_2.jpg';
		}
		
		$team_member_label_arr = array('直属成员', '下级成员');
		if ($team_member_label_list) {
			foreach ($team_member_label_list as $key => $team_member_label) {
				$team_member_label_arr[$key] = $team_member_label['name'];
			}
		}
		
		$return = array();
		$return['drp_team'] = $drp_team;
		$return['team_member_label_arr'] = $team_member_label_arr;
		$return['store'] = array('name' => $store['name'], 'intro' => $store['intro']);
		$return['is_edit'] = $store['drp_level'] == 1 ? true : false;
		
		json_return(0, $return);
	}
	
	// 我的分销商
	public function staff() {
		$store = $this->_storeCheck();
		$level = $_REQUEST['level'];
		
		// 防止数据错误时，抽出下一级分销商
		if ($level != $store['drp_level'] + 1 && $level != $store['drp_level'] + 2) {
			$level = $store['drp_level'] + 1;
		}
		
		$store_list_tmp = M('Drp_team')->getMembersByLevel($store['store_id'], $level);
		$store_list = array();
		foreach ($store_list_tmp as $store) {
			$tmp = array();
			$tmp['store_id'] = $store['store_id'];
			$tmp['name'] = $store['name'];
			$tmp['sales'] = $store['sales'];
			$tmp['income'] = $store['income'];
			
			$store_list[] = $tmp;
		}
		
		json_return(0, array('store_list' => $store_list));
	}
	
	// 团队信息显示和修改
	public function team_rank() {
		$store = $this->_storeCheck();
		
		$drp_team_id = $store['drp_team_id'];
		if ($store['drp_team_id'] == 0) {
			// 获取第一级分销商
			if ($store['drp_level'] > 1) {
				$fx_supplier_info = D('Store_supplier')->where(array('root_supplier_id' => $store['top_supplier_id'], 'seller_id' => $store['store_id']))->find();
				$fx_store_id = explode(',', $fx_supplier_info['supply_chain']);
				$store_level_1 = D('Store')->where(array('store_id' => $fx_store_id[2]))->find();
				
				$drp_team_id = $store_level_1['drp_team_id'];
				
				// 如果有团队，直接更新团队
				if ($drp_team_id) {
					D('Store')->where(array('store_id' => $store['store_id']))->data(array('drp_team_id' => $drp_team_id))->save();
				}
			}
		}
		
		// 获取当前团队排名
		if ($drp_team_id) {
			// 所属总队排名
			$drp_team = D('Drp_team')->where(array('pigcms_id' => $drp_team_id))->find();
			
			// 没有分销团队，直接返回暂无数据
			if (empty($drp_team)) {
				$return = array();
				$return['has_team'] = false;
				json_return(0, $return);
			}
			
			$drp_team_level = D('Drp_team')->where(array('supplier_id' => $store['top_supplier_id'], 'sales' => array('>', $drp_team['sales'])))->count('*');
			$drp_team['drp_team_level'] = $drp_team_level + 1;
			$drp_team['logo'] = $drp_team['logo'] ? getAttachmentUrl($drp_team['logo']) : option('config.site_url') . '/static/images/default_shop_2.jpg';
			
			$drp_team_list = D('Drp_team')->where(array('supplier_id' => $store['top_supplier_id']))->order('sales desc')->limit(20)->select();
			foreach ($drp_team_list as &$drp_team_tmp) {
				$drp_team_tmp['logo'] = $drp_team['logo'] ? getAttachmentUrl($drp_team['logo']) : option('config.site_url') . '/static/images/default_shop_2.jpg';
			}
			
			// 我在团队中的排名
			$store_level = D('Store')->where(array('drp_team_id' => $drp_team_id, 'sales' => array('>', $store['sales'])))->count('*');
			$store['store_level'] = $store_level + 1;
			
			$store_list = D('Store')->where(array('drp_team_id' => $drp_team_id))->order('sales DESC')->limit(20)->field('store_id, name, logo, sales')->select();
			foreach ($store_list as &$store_tmp) {
				$store_tmp['logo'] = $store_tmp['logo'] ? getAttachmentUrl($store_tmp['logo']) : getAttachmentUrl('images/default_shop_2.jpg', false);
			}
			
			$return = array();
			$return['has_team'] = true;
			$return['drp_team'] = $drp_team;
			$return['drp_team_list'] = $drp_team_list;
			$return['store'] = array('store_id' => $store['store_id'], 'name' => $store['name'], 'logo' => $store['logo'], 'sales' => $store['sales'], 'store_level' => $store['store_level'], 'drp_team_id' => $store['drp_team_id']);
			$return['store_list'] = $store_list;
			
			json_return(0, $return);
		} else {
			$return = array();
			$return['has_team'] = false;
			json_return(0, $return);
		}
	}
	
	// 商家推广名片
	public function store_qrcode() {
		$store = $this->_storeCheck();
		
		// 默认的店铺地址
		$store_url = option('config.wap_site_url') . '/home.php?id=' . $store['store_id'];
		
		//推广信息
		$store_promote_setting = D('Store_promote_setting')->where(array('store_id' => $store['store_id'], 'type' => 1, 'status' => 1, 'owner' => 1))->find();
		if (empty($store_promote_setting) && $store['top_supplier_id']) {
			$store_promote_setting = D('Store_promote_setting')->where(array('store_id' => $store['top_supplier_id'], 'type' => 1, 'status' => 1, 'owner' => 1))->find();
		}
		
		if (empty($store_promote_setting)) {
			json_return(1000, '店铺未开启推广海报');
		}
		
		if ($_REQUEST['action'] == 'down') {
			$qrcode = M('Store')->concernRelationship(700000000, $this->user['uid'], $store['store_id'], $type = '1');
			
			if ($qrcode['error_code'] > 0) {
				json_return(1000, $qrcode['msg']);
			}
			
			$result = M('Store_promote_setting')->createImage($store_promote_setting, $qrcode, $this->user, $store);
			json_return(0, option('config.site_url') . $result[0]);
		}
		
		// 推广数据
		$promote_data = array();
		$promote_data['store_nickname'] = $store_promote_setting['store_nickname'] ? $store_promote_setting['store_nickname'] : $store['name'];
		$promote_data['store_name'] = $store['name'];
		$promote_data['image'] = option('config.site_url') . '/template/wap/default/img/' . $store_promote_setting['poster_type'] . '.png';
		
		// 分享数据
		$share_data = array();
		$share_data['title'] = $store['name'];
		$share_data['image'] = getAttachmentUrl($store['logo']);
		$share_data['intro'] = str_replace(array('"', "'", "\r", "\n"), '', $store['intro']);
		$share_data['url'] = $store_url;
		
		$return = array();
		$return['promote_data'] = $promote_data;
		$return['share_data'] = $share_data;
		json_return(0, $return);
	}
	
	// 推广说明
	public function drp_desc() {
		$data_arr = array();
		$data_arr['image'] = option('config.site_url') . '/template/wap/default/ucenter/images/301.png';
		$data_arr['message'] = '无限级分销，三级分润模式 在国家法律框架下做无限级裂变分销，三级分润的分销模式。在不触犯国家法律和微信运营规范的前提下，让商品在朋友圈爆炸式传播销售。当有分销商把商品销售出去之后，只有当前分销商和他的上两级分销商参与分润，比如七级分销商售出一件商品，那么他、六级和五级分销商是有利润分配的，其他级别不参与分润。';
		
		json_return(0, array('data_arr' => $data_arr));
	}
	
	// 企业简介
	public function intro() {
		$store = $this->_storeCheck();
		$supplier_id = $store['top_supplier_id'];
		
		//获取供货商信息
		$supplier_info = D('Store')->where(array('store_id' => $supplier_id))->find();
		
		//所属公司
		$company_info = D('Company')->where(array('uid' => $supplier_info['uid']))->find();
		
		//主营类目-父
		$category_f = D('Sale_category')->where(array('cat_id'=>$supplier_info['sale_category_fid']))->find();
		
		//主营类目-子
		$category_c = D('Sale_category')->where(array('cat_id'=>$supplier_info['sale_category_id']))->find();
		
		
		$data_arr = array();
		$data_arr['company_name'] = $company_info['name'];
		$data_arr['supplier_name'] = $supplier_info['name'];
		$data_arr['category_name'] = $category_f['name'] . ($category_c['name'] ? '-' . $category_c['name'] : '');
		$data_arr['add_time'] = $supplier_info['date_added'];
		$data_arr['linkman'] = $supplier_info['linkman'];
		$data_arr['qq'] = $supplier_info['qq'];
		$data_arr['tel'] = $supplier_info['tel'];
		$data_arr['intro'] = $supplier_info['intro'];
		
		json_return(0, array('data_arr' => $data_arr));
	}
	
	// 我的推广
	public function popularize() {
		$store = $this->_storeCheck();
		
		$data = array();
		$data['logo'] = $store['logo'];
		$data['name'] = $store['name'];
		$data['level'] = $store['drp_level'] . '级分销商';
		
		$share_conf 	= array(
				'title' 	=> $store['name'], // 分享标题
				'desc' 		=> '', // 分享描述
				'link' 		=> option('config.wap_site_url') . '/home.php?id=' . $store['store_id'], // 分享链接
				'imgUrl' 	=> $store['logo'], // 分享图片链接
		);
		
		$return = array();
		$return['store'] = $data;
		$return['share_conf'] = $share_conf;
		
		json_return(0, $return);
	}
	
	// 分销商等级
	public function degree() {
		$store = $this->_storeCheck();
		//供货商是否开启分销等级
		$open_drp_degree = option('config.open_drp_degree');  //平台是否开启分销等级
		
		$next_drp_degree = array();
		$now_drp_degree = array();
		if (!empty($open_drp_degree) && $store['open_drp_degree']) {
			$drp_degree_list = M('Drp_degree')->getDrpDegrees(array('store_id' => $store['top_supplier_id']));
			
			if ($store['drp_degree_id']) {
				$now_drp_degree = D('Drp_degree')->where(array('pigcms_id' => $store['drp_degree_id']))->find();
			}
			
			$has_degree = false;
			if ($now_drp_degree) {
				$has_degree = true;
			}
			
			foreach ($drp_degree_list as $key => $drp_degree_tmp) {
				if (empty($now_drp_degree) && $key == 0) {
					$next_drp_degree = $drp_degree_tmp;
				} else if ($drp_degree_tmp['pigcms_id'] == $now_drp_degree['pigcms_id']) {
					$now_drp_degree = $drp_degree_tmp;
				}
				
				if ($has_degree && $drp_degree_tmp['value'] > $now_drp_degree['value']) {
					$next_drp_degree = $drp_degree_tmp;
					$has_degree = false;
				}
			}
			
			if (empty($now_drp_degree)) {
				$now_drp_degree['name'] = '暂无等级';
				$now_drp_degree['icon'] = option('config.site_url') . '/template/wap/default/ucenter/images/kong.png';
			}
			
			$store_user_data = D('Store_user_data')->field('store_point')->where(array('store_id' => $store['top_supplier_id'], 'uid' => $this->user['uid']))->find();
			
			$return = array();
			$return['has_degree'] = true;
			$return['now_drp_degree'] = $now_drp_degree;
			$return['next_drp_degree'] = $next_drp_degree;
			$return['drp_degree_list'] = $drp_degree_list;
			$return['point'] = $store_user_data['store_point'];
			
			json_return(0, $return);
		}else{
			json_return(0, array('has_degree' => false));
		}
	}
	
	// 分销积分
	public function drp_point() {
		$store = $this->_storeCheck();
		$limit = 10;
		$page = max(1, $_REQUEST['page']);
		
		$type_arr = array(
				1 => '发展分销商送',
				2 => '销售额比例生成',
				3 => '分享送',
				4 => '签到送',
				5 => '推广增加',
				6 => '销售额未达标扣积分'
		);
		
		$offset = ($page - 1) * $page;
		$where = array();
		$where['store_id']= $store['top_supplier_id'];
		$where['uid']= $this->user['uid'];
		$store_points_list = D('Store_points')->order('timestamp desc')->where($where)->limit($offset . ', ' . $limit)->select();
		foreach ($store_points_list as &$store_points) {
			$store_points['type_txt'] = isset($type_arr[$store_points['type']]) ? $type_arr[$store_points['type']] : '-';
		}
		
		$return = array();
		$return['store_points_list'] = $store_points_list;
		$return['next_page'] = true;
		if (count($store_points_list) < $limit) {
			$return['next_page'] = false;
		}
		
		json_return(0, $return);
	}
	
	// 切换店铺
	public function store() {
		$store_model = M('Store');
		$store_list_tmp = $store_model->getUserDrpStores($this->user['uid'], 0, 0);
		
		$store_list = array();
		foreach ($store_list_tmp as $store) {
			$tmp = array();
			$tmp['store_id'] = $store['store_id'];
			$tmp['name'] = $store['name'];
			
			if (empty($store['logo'])) {
				$store['logo'] = 'images/default_shop.png';
			}
			$tmp['logo'] = getAttachmentUrl($store['logo']);
			$tmp['drp_supplier_id'] = $store['drp_supplier_id'];
			
			if (!empty($store['drp_supplier_id'])) {
				$supplier = $store_model->getStore($store['drp_supplier_id']);
				$tmp['supplier_name'] = $supplier['name'];
			}
			
			$store_list[] = $tmp;
		}
		
		$return = array();
		$return['store_list'] = $store_list;
		$return['pc_url'] = option('config.site_url') . '/user.php?c=user&a=login';
		$return['phone'] = $this->user['phone'];
		
		json_return(0, $return);
		
	}
	
	// 退货列表
	public function service() {
		$store = $this->_storeCheck();
		$type = $_REQUEST['type'];
		$page = max(1, $_REQUEST['page']);
		$limit = 10;
		$offset = ($page - 1) * $limit;
		
		if (!in_array($type, array('return', 'rights'))) {
			json_return(1000, '参数错误');
		}
		
		if ($type == 'return') {
			$return_list_tmp = M('Return')->getList("r.store_id = '" . $store['store_id'] . "'", $limit, $offset);
			
			$return_list = array();
			foreach ($return_list_tmp as $return) {
				$tmp = array();
				$tmp['return_id'] = $return['id'];
				$tmp['name'] = $return['name'];
				$tmp['image'] = $return['image'];
				$tmp['type_txt'] = $return['type_txt'];
				$tmp['status_txt'] = $return['status_txt'];
				$tmp['pro_num'] = $return['pro_num'];
				$tmp['pro_price'] = $return['pro_price'];
				
				$return_list[] = $tmp;
			}
			
			$return = array();
			$return['return_list'] = $return_list;
			$return['next_page'] = true;
			if (count($return_list) < $limit) {
				$return['next_page'] = false;
			}
			
			json_return(0, $return);
		} else {
			$rights_list_tmp = M('Rights')->getList("r.store_id = '" . $store['store_id'] . "'", $limit, $offset);
				
			$rights_list = array();
			foreach ($rights_list_tmp as $rights) {
				$tmp = array();
				$tmp['rights_id'] = $rights['id'];
				$tmp['name'] = $rights['name'];
				$tmp['image'] = $rights['image'];
				$tmp['type_txt'] = $rights['type_txt'];
				$tmp['status_txt'] = $rights['status_txt'];
				$tmp['pro_num'] = $rights['pro_num'];
				$tmp['pro_price'] = $rights['pro_price'];
			
				$rights_list[] = $tmp;
			}
				
			$return = array();
			$return['rights_list'] = $rights_list;
			$return['next_page'] = true;
			if (count($rights_list) < $limit) {
				$return['next_page'] = false;
			}
			
			json_return(0, $return);
		}
	}
	
	// 退货、维权详情
	public function service_detail() {
		$store = $this->_storeCheck();
		$type = $_REQUEST['type'];
		$id = $_REQUEST['id'];
		
		if (!in_array($type, array('return', 'rights')) || empty($id)) {
			json_return(1000, '参数错误');
		}
		
		if ($type == 'return') {
			$return = M('Return')->getById($id);
			
			if (empty($return)) {
				json_return(1000, '未找到相应的退货申请');
			}
			
			if ($return['store_id'] != $store['store_id']) {
				json_return(1000, '您无权查看此退货申请');
			}
			
			$return['sku_data'] = unserialize($return['sku_data']);
			if (empty($return['sku_data'])) {
				$return['sku_data'] = array();
			}
			
			if (empty($return['images'])) {
				$return['images'] = array();
			}
			
			$return['pigcms_id'] = $return['id'];
			unset($return['id']);
			
			json_return(0, array('data' => $return));
		} else {
			$rights = M('Rights')->getById($id);
				
			if (empty($rights)) {
				json_return(1000, '未找到相应的退货申请');
			}
				
			if ($rights['store_id'] != $store['store_id']) {
				json_return(1000, '您无权查看此退货申请');
			}
				
			$rights['sku_data'] = unserialize($rights['sku_data']);
			if (empty($rights['sku_data'])) {
				$rights['sku_data'] = array();
			}
				
			if (empty($rights['images'])) {
				$rights['images'] = array();
			}
				
			$rights['pigcms_id'] = $rights['id'];
			unset($rights['id']);
			
			json_return(0, array('data' => $rights));
		}
	}
	
	// 我的粉丝
	public function fans() {
		$store = $this->_storeCheck();
		$action = $_REQUEST['action'];
		
		if ($action == 'list') {
			$page = max(1, $_REQUEST['page']);
			$limit = 10;
			$offset = ($page - 1) * $limit;
			
			$root_supplier_id = !empty($store['top_supplier_id']) ? $store['top_supplier_id'] : $store['store_id'];
			
			$where = array();
			$where['store_id'] = $store['store_id'];
			$fans_list = M('Store_user_data')->getMembers($where, $offset, $limit);
			foreach ($fans_list as $key => $fans) {
				$user = D('User')->field('nickname,avatar')->where(array('uid' => $fans['uid']))->find();
				$store_supplier = D('Store_supplier')->field('seller_id')->where("root_supplier_id = '" . $root_supplier_id . "' AND FIND_IN_SET(" . $store['store_id'] . ", supply_chain) AND seller_id IN (SELECT store_id FROM " . option('system.DB_PREFIX') . "store WHERE uid = '" . $fans['uid'] . "')")->find();
				
				$seller_id = !empty($store_supplier['seller_id']) ? $store_supplier['seller_id'] : 0;
				$fans_list[$key]['nickname'] = !empty($user['nickname']) ? $user['nickname'] : '匿名会员';
				$fans_list[$key]['avatar'] = !empty($user['avatar']) ? getAttachmentUrl($user['avatar']) : getAttachmentUrl('images/avatar.png', false);
				$fans_list[$key]['money'] = number_format($fans['money'], 2, '.', '');
				$fans_list[$key]['seller_id'] = $seller_id;
			}
			
			$return = array();
			$return['fans_list'] = $fans_list;
			$return['next_page'] = true;
			if (count($fans_list) < $limit) {
				$return['next_page'] = false;
			}
			
			json_return(0, $return);
			exit;
		}
		
		// 粉丝总数
		$where = array();
		$where['store_id'] = $store['store_id'];
		$fans_count = M('Store_user_data')->getMemberCount($where);
		
		//今日新增粉丝
		$start_time = strtotime(date('Y-m-d') . ' 00:00:00');
		$end_time = strtotime(date('Y-m-d') . ' 23:59:59');
		$where = array();
		
		$where['store_id'] = $store['store_id'];
		$where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $end_time . "'";
		$today_fans = M('Store_user_data')->getMemberCount($where);
		
		//昨日新增粉丝
		$start_time = strtotime(date("Y-m-d", strtotime("-1 day")) . ' 00:00:00');
		$end_time = strtotime(date("Y-m-d", strtotime("-1 day")) . ' 23:59:59');
		$where = array();
		$where['store_id'] = $store['store_id'];
		$where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $end_time . "'";
		$yesterday_fans = M('Store_user_data')->getMemberCount($where);
		
		$fans_arr = array();
		$fans_arr['total'] = $fans_count;
		$fans_arr['today'] = $today_fans;
		$fans_arr['yesterday'] = $yesterday_fans;
		
		$count_arr = array();
		$day_arr = array();
		for ($i = 6; $i >= 0; $i--) {
			$start_time = strtotime(date('Y-m-d 0:0:0', strtotime('-' . $i . 'day')));
			$end_time = strtotime(date('Y-m-d 23:59:59', strtotime('-' . $i . 'day')));
			
			//七日粉丝流量
			$where = array();
			$where['store_id'] = $store['store_id'];
			$where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $end_time . "'";
			$count_arr[] = M('Store_user_data')->getMemberCount($where);
			$day_arr[] = date('m-d', $start_time);
		}
		
		$return = array();
		$return['fans_arr'] = $fans_arr;
		$return['count_str'] = join(',', $count_arr);
		$return['day_str'] = join(',', $day_arr);
		
		json_return(0, $return);
	}
	
	// 分销商公共验证部分
	private function _storeCheck() {
		$store_id = $_REQUEST['store_id'];
		
		if (empty($store_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		$store = M('Store')->getStore($store_id, true);
		if (empty($store) || $store['uid'] != $this->user['uid']) {
			json_return(1000, '未找到相应的店铺');
		}
		
		if ($store['top_supplier_id'] == 0) {
			json_return(1000, '此店铺不是分销店铺');
		}
		
		return $store;
	}
}