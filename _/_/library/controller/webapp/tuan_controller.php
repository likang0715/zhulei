<?php
class tuan_controller extends base_controller {
	// 团购首页
	public function index() {
		$store_id = $_REQUEST['store_id'];
		$group_id = $_REQUEST['group_id'];
		$page = max(1, $_REQUEST['page']);
		$limit = 10;
		$offset = ($page - 1) * $limit;
		
		if (empty($store_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		$store = M('Store')->getStore($store_id);
		if (empty($store)) {
			json_return(1000, '未找到相应的店铺');
		}
		
		// 获取店铺的产品分组
		$product_group_list = M('Product_group')->get_all_list($store_id);
		
		$count = M('Tuan')->getCountByGroup($store_id, $group_id);
		$tuan_list = array();
		if ($count > 0) {
			$tuan_list = M('Tuan')->getListByGroup($store_id, $group_id, $limit, $offset);
		}
		
		$next_page = true;
		if (count($tuan_list) < $limit) {
			$next_page = false;
		} else if ($offset >= $count) {
			$next_page = false;
		} else if ($offset + $limit == $count) {
			$next_page = false;
		}
		
		// 返回数据
		$return = array();
		//店铺导航
		if ($store['open_nav'] && !empty($store['use_nav_pages'])) {
			$use_nav_pages_arr = explode(',', $store['use_nav_pages']);
			if (in_array('7', $use_nav_pages_arr)) {
				$store_nav = M('Store_nav')->getParseNav($store['store_id'], $store['store_id'], $store['drp_diy_store']);
				$return['store_nav'] = $store_nav;
			}
		}
		
		$return['product_group_list'] = $product_group_list;
		$return['tuan_list'] = $tuan_list;
		$return['next_page'] = $next_page;
		
		$url = urldecode($_REQUEST['url']);
		// 分享
		import('WechatShare');
		$share = new WechatShare();
		$share_data = $share->getSgin('', true, $url);
		$return['share_data'] = $share_data;
		
		json_return(0, $return);
	}
	
	// 团购详情
	public function detail() {
		$tuan_id = $_REQUEST['tuan_id'];
		
		if (empty($tuan_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		// 查找团购信息
		$tuan = D('Tuan')->where(array('id' => $tuan_id))->field('*, description as info')->find();
		if (empty($tuan)) {
			json_return(1000, '未找到相应的团购活动');
		}
		$tuan['tuan_id'] = $tuan['id'];
		unset($tuan['id']);
		
		// 团购状态，1：未开始，2：进行中，3：成功，4：失败
		if ($tuan['status'] == 2) {
			$tuan['status'] = 4;
		} else if ($tuan['start_time'] > $_SERVER['REQUEST_TIME']) {
			$tuan['status'] = 1;
		} else if ($tuan['start_time'] <= $_SERVER['REQUEST_TIME'] && $tuan['end_time'] >= $_SERVER['REQUEST_TIME']) {
			$tuan['status'] = 2;
		} else if (!empty($tuan_team)) {
			if ($tuan_team['status'] == 0) {
				$tuan['status'] = 2;
			} else if ($tuan_team['status'] == 1) {
				$tuan['status'] = 3;
			} else {
				$tuan['status'] = 4;
			}
		} else if ($tuan['status'] == 1) {
			$tuan['status'] = 2;
		}
		
		// 查找店铺
		$store = M('Store')->getStore($tuan['store_id']);
		if (empty($store)) {
			json_return(1000, '未找到相应的店铺');
		}
		
		$tuan_config_list = D('Tuan_config')->where(array('tuan_id' => $tuan_id))->field('id as item_id, number, discount')->order('discount DESC')->select();
		
		// 团购产品
		$product = M('Product')->get(array('store_id' => $tuan['store_id'], 'product_id' => $tuan['product_id'], 'status' => 1), 'product_id, name, price, image, sales, info, has_property');
		if (empty($product)) {
			json_return(1000, '未找到相应的团购商品');
		}
		// 产品图片
		$product_image_list = M('Product_image')->getImages($product['product_id']);
		
		// 
		foreach ($tuan_config_list as &$tuan_config) {
			$tuan_config['price'] = round($product['price'] * $tuan_config['discount'] / 10, 2);
		}
		
		$return = array();
		$return['product'] = $product;
		$return['product_image_list'] = $product_image_list;
		$return['tuan'] = $tuan;
		$return['tuan_config_list'] = $tuan_config_list;
		$return['title'] = $tuan['name'] . '_' . $store['name'] . '_' . option('config.site_name');
		$return['current_time'] = time();
		
		$url = urldecode($_REQUEST['url']);
		// 分享
		import('WechatShare');
		$share = new WechatShare();
		$share_data = $share->getSgin('', true, $url);
		$return['share_data'] = $share_data;
		
		json_return(0, $return);
	}
	
	// 团购购买
	public function tuan_info() {
		$tuan_id = $_REQUEST['tuan_id'];
		$type = $_REQUEST['type'];
		$item_id = $_REQUEST['item_id'] + 0;
		$team_id = $_REQUEST['team_id'] + 0;
		
		if (empty($tuan_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		if ($type == 1 && empty($item_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		// 查找团购信息
		$tuan = D('Tuan')->where(array('id' => $tuan_id, 'delete_flg' => 0))->find();
		if (empty($tuan)) {
			json_return(1000, '未找到相应的团购活动');
		}
		
		// 查找店铺
		$store = M('Store')->getStore($tuan['store_id']);
		if (empty($store)) {
			json_return(1000, '未找到相应的店铺');
		}
		
		// 团购团队
		$tuan_team = array();
		if (!empty($team_id)) {
			$tuan_team = D('Tuan_team')->where(array('team_id' => $team_id, 'tuan_id' => $tuan_id))->find();
			if (empty($tuan_team)) {
				json_return(1000, '未找到相应的团');
			}
			
			$type = $tuan_team['type'];
			$item_id = $tuan_team['item_id'];
		}
		
		// 团购状态，1：未开始，2：进行中，3：成功，4：失败
		if ($tuan['status'] == 2) {
			$tuan['status'] = 4;
		} else if ($tuan['start_time'] > $_SERVER['REQUEST_TIME']) {
			$tuan['status'] = 1;
		} else if ($tuan['start_time'] <= $_SERVER['REQUEST_TIME'] && $tuan['end_time'] >= $_SERVER['REQUEST_TIME']) {
			$tuan['status'] = 2;
		} else if (!empty($tuan_team)) {
			if ($tuan_team['status'] == 0) {
				$tuan['status'] = 2;
			} else if ($tuan_team['status'] == 1) {
				$tuan['status'] = 3;
			} else {
				$tuan['status'] = 4;
			}
		} else if ($tuan['status'] == 1) {
			$tuan['status'] = 2;
		}
		
		// 团购产品
		$product = M('Product')->get(array('store_id' => $tuan['store_id'], 'product_id' => $tuan['product_id'], 'status' => 1), 'product_id, name, price, image, quantity, buyer_quota, sold_time, sales, info, has_property');
		if (empty($product)) {
			json_return(1000, '未找到相应的团购商品');
		}
		
		if (empty($product)) {
			json_return(1000, '未找到相应的团购商品');
		} else if ($product['quantity'] == '0') {
			json_return(1000, '商品已经售完');
		} else if ($product['sold_time'] > $_SERVER['REQUEST_TIME']) {
			json_return(1000, '商品还未开始销售');
		}
		
		if ($product['buyer_quota']) {
			$buy_quantity = 0;
			$user_type = 'uid';
			$uid = $this->user['uid'];
				
			//购物车
			$cart_number = D('User_cart')->field('sum(pro_num) as pro_num')->where(array('product_id' => $product['product_id'], 'uid' => $uid))->select();
			if (!empty($cart_number)) {
				$buy_quantity += $cart_number['pro_num'];
			}
				
			// 再加上订单里已经购买的商品
			$buy_quantity += M('Order_product')->getBuyNumber($uid, $product['product_id'], $user_type);
			$product['buy_quantity'] = $buy_quantity;
		}
		
		// 产品图片
		$product_image_list = M('Product_image')->getImages($product['product_id']);
		
		// 查找所有团购项
		$tuan_config_list = D('Tuan_config')->where(array('tuan_id' => $tuan_id))->order('discount DESC')->select();
		foreach ($tuan_config_list as $key => $tmp) {
			$tuan_config_list[$key]['price'] = round($product['price'] * $tmp['discount'] / 10, 2);
			
			if ($type == 1 && $tmp['id'] == $item_id) {
				$tuan_config = $tmp;
			} else if ($type != 1 && $key == 0) {
				$item_id = $tmp['id'];
				$tuan_config = $tmp;
			}
		}
		
		if (empty($tuan_config)) {
			json_return(1000, '未找到相应的团购项');
		}
		
		// 团购价格，默认的团购价格
		$product['original_price'] = $product['price'];
		$product['price'] = $product['price'] * $tuan_config['discount'] / 10;
		
		// 查出团购买数量
		$count = 0;
		if (!empty($team_id)) {
			$where = array();
			$where['store_id'] = $tuan['store_id'];
			$where['type'] = 6;
			$where['data_id'] = $tuan_id;
			$where['data_item_id'] = $team_id;
			$where['status'] = array('in', array(2, 3, 4, 7));
			$count = D('Order')->where($where)->sum('pro_num');
			$count += $tuan_config['start_number'];
		}
		$tuan_config['count'] = $count;
		unset($tuan_config['start_number']);
		//$product['price'] = $product['price'] * $discount / 10;
		
		// 返回数据
		$return = array();
		$return['tuan'] = $tuan;
		$return['tuan_config_list'] = $tuan_config_list;
		$return['tuan_config'] = $tuan_config;
		$return['product'] = $product;
		$return['product_image_list'] = $product_image_list;
		$return['title'] = $tuan['name'] . '_' . $store['name'] . '_' . option('config.site_name');
		
		$discount = min(10, $tuan_config['discount']);
		$store_id = $tuan['store_id'];
		$product_id = $tuan['product_id'];
		if ($product['has_property']) {
			//库存信息
			$sku_list = D('Product_sku')->field('`sku_id`,`properties`,`quantity`,`price`')->where(array('product_id' => $product_id, 'quantity' => array('>','0')))->order('`sku_id` ASC')->select();
			//如果有库存信息并且有库存，则查库存关系表
			if (!empty($sku_list)) {
				$sku_price_arr = $sku_property_arr = array();
				foreach ($sku_list as $i => $value) {
					$sku_list[$i]['price'] = $value['price'] * $discount / 10;
					
					$sku_price_arr[] = $value['price'] * $discount / 10;
					$sku_property_arr[$value['properties']] = true;
				}
				
				$min_price = min($sku_price_arr);
				$max_price = max($sku_price_arr);
				
				$tmp_property_list = D('')->field('`pp`.`pid`,`pp`.`name`')->table(array('Product_to_property'=>'ptp','Product_property'=>'pp'))->where("`ptp`.`product_id`='$product_id' AND `pp`.`pid`=`ptp`.`pid`")->order('`ptp`.`order_by` ASC')->select();
				if (!empty($tmp_property_list)) {
					$tmp_property_value_list = D('')->field('`ppv`.`vid`,`ppv`.`value`,`ppv`.`pid`')->table(array('Product_to_property_value'=>'ptpv','Product_property_value'=>'ppv'))->where("`ptpv`.`product_id`='$product_id' AND `ppv`.`vid`=`ptpv`.`vid`")->order('`ptpv`.`pigcms_id` ASC')->select();
					if (!empty($tmp_property_value_list)) {
						foreach ($tmp_property_value_list as $value) {
							$propertyValueList[$value['pid']][] = array(
									'vid' => $value['vid'],
									'value' => $value['value'],
							);
						}
						foreach ($tmp_property_list as $value) {
							$property_list[] = array(
									'pid' => $value['pid'],
									'name' => $value['name'],
									'values' => $propertyValueList[$value['pid']],
							);
						}
						if (count($property_list) == 1) {
							foreach ($property_list[0]['values'] as $key=>$value) {
								$tmpKey = $property_list[0]['pid'] . ':' . $value['vid'];
								if (empty($sku_property_arr[$tmpKey])) {
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
					} else {
						json_return(1000, '未找到商品的库存信息，无法购买');
					}
				} else {
					json_return(1000, '未找到商品的库存信息，无法购买');
				}
			} else {
				json_return(1000, '商品已经售完');
			}
		}
		
		$return['product']['min_price'] = !empty($min_price) ? $min_price : $product['price'];
		$return['product']['max_price'] = !empty($max_price) ? $max_price : 0;
		
		//自定义字段
		$return['custom_field_list'] = D('Product_custom_field')->field('`field_name`,`field_type`,`multi_rows`,`required`')->where(array('product_id'=>$product_id))->select();
		
		// 检查当前用户是否开过此团，开过团将不可以再开团
		$tuan_team_count = D('Tuan_team')->where(array('uid' => $this->user['uid'], 'tuan_id' => $tuan_id, 'pay_status' => 1))->count('team_id');
		
		$url = urldecode($_REQUEST['url']);
		error_log($url);
		// 分享
		import('WechatShare');
		$share = new WechatShare();
		$share_data = $share->getSgin('', true, $url);
		$return['share_data'] = $share_data;
		$return['tuan_exists'] = $tuan_team_count ? true : false;
		$return['current_time'] = time();
		
		json_return(0, $return);
	}
	
	// 购买记录
	public function buy_list() {
		$tuan_id = $_REQUEST['tuan_id'];
		$team_id = $_REQUEST['team_id'];
		$page = max(1, $_REQUEST['page']);
		$limit = 5;
		$offset = ($page - 1) * $limit;
		
		if (empty($tuan_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		// 查找团购信息
		$tuan = D('Tuan')->where(array('id' => $tuan_id))->find();
		if (empty($tuan)) {
			json_return(1000, '未找到相应的团购活动');
		}
		
		$count = M('Order')->getActivityOrderCount(6, $tuan_id, $team_id);
		$data = array('order_list' => array(), 'user_list' => array());
		if ($count > 0) {
			$data = M('Order')->getActivityOrderList(6, $tuan_id, $team_id, $limit, $offset);
		}
		
		$next_page = true;
		if (count($data['order_list']) < $limit) {
			$next_page = false;
		} else if ($offset >= $count) {
			$next_page = false;
		} else if ($offset + $limit == $count) {
			$next_page = false;
		}
		
		$order_list = array();
		foreach ($data['order_list'] as &$tmp) {
			$tmp['nickname'] = $data['user_list'][$tmp['uid']]['nickname'];
			$tmp['avatar'] = $data['user_list'][$tmp['uid']]['avatar'];
		}
		
		$return = array();
		$return['order_list'] = $data['order_list'];
		$return['user_list'] = $data['user_list'];
		$return['next_page'] = $next_page;
		$return['current_time'] = time();
		
		json_return(0, $return);
	}
	
	// 订单
	public function order() {
		$tuan_id = $_REQUEST['tuan_id'];
		$quantity = max(1, $_REQUEST['quantity']);
		$type = $_REQUEST['type'];
		$item_id = $_REQUEST['item_id'];
		$sku_id = $_REQUEST['sku_id'];
		$team_id = $_REQUEST['team_id'];
		
		if (empty($tuan_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		if ($type == 1 && empty($item_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		// 查找团购信息
		$tuan = D('Tuan')->where(array('id' => $tuan_id))->find();
		if (empty($tuan)) {
			json_return(1000, '未找到相应的团购活动');
		}
		
		if ($tuan['start_time'] > $_SERVER['REQUEST_TIME']) {
			json_return(1000, '团购未开始');
		}
		
		if ($tuan['end_time'] < $_SERVER['REQUEST_TIME']) {
			json_return(1000, '团购已结束');
		}
		
		// 查找店铺
		$store = M('Store')->getStore($tuan['store_id']);
		if (empty($store)) {
			json_return(1000, '未找到相应的店铺');
		}
		
		// 检查当前用户是否开过此团，开过团将不可以再开团
		$tuan_team_count = D('Tuan_team')->where(array('uid' => $this->user['uid'], 'tuan_id' => $tuan_id, 'pay_status' => 1))->count('team_id');
		if ($tuan_team_count > 0 && $team_id == 0) {
			json_return(1000, '您已开过团，不能再开团');
		}
		
		// 查找参与的团长
		$tuan_team = array();
		if (!empty($team_id)) {
			$tuan_team = D('Tuan_team')->where(array('team_id' => $team_id, 'tuan_id' => $tuan_id))->find();
			if (empty($tuan_team)) {
				json_return(1000, '未找到相应的团');
			}
			
			$type = $tuan_team['type'];
			$item_id = $tuan_team['item_id'];
		}
		
		// 查找团购项
		$tuan_config = array();
		if ($type == 1) {
			$tuan_config = D('Tuan_config')->where(array('tuan_id' => $tuan_id, 'id' => $item_id))->find();
		} else {
			$tuan_config = D('Tuan_config')->where(array('tuan_id' => $tuan_id))->order('discount DESC')->find();
		}
		
		if (empty($tuan_config)) {
			json_return(1000, '未找到相应的团购项');
		}
		
		$item_id = $tuan_config['id'];
		$discount = min(10, $tuan_config['discount']);
		$store_id = $tuan['store_id'];
		$product_id = $tuan['product_id'];
		
		// 团购产品
		$product = M('Product')->get(array('store_id' => $tuan['store_id'], 'product_id' => $tuan['product_id'], 'status' => 1), 'product_id, name, price, image, quantity, buyer_quota, sold_time, has_property, weight');
		
		if (empty($product)) {
			json_return(1000, '未找到相应的团购商品');
		} else if ($product['quantity'] == '0') {
			json_return(1000, '商品已经售完');
		} else if ($product['sold_time'] > $_SERVER['REQUEST_TIME']) {
			json_return(1000, '商品还未开始销售');
		}
		
		if ($product['buyer_quota']) {
			error_log('aaa');
			$buy_quantity = 0;
			$user_type = 'uid';
			$uid = $this->user['uid'];
			
			//购物车
			$cart_number = D('User_cart')->field('sum(pro_num) as pro_num')->where(array('product_id' => $product['product_id'], 'uid' => $uid))->select();
			if (!empty($cart_number)) {
				$buy_quantity += $cart_number['pro_num'];
			}
			
			// 再加上订单里已经购买的商品
			$buy_quantity += M('Order_product')->getBuyNumber($uid, $product['product_id'], $user_type);
			
			if ($buy_quantity > $product['buyer_quota']) {
				json_return(1000, '您购买的产品：' . $product['name'] . '超出了限购');
			}
		}
		
		$weight = $product['weight'];
		$properties_str = '';
		// 计算产品团购价格
		$price = 0;
		if ($product['has_property']) {
			if (empty($sku_id)) {
				json_return(1000, '请选择商品属性');
			}
			
			$product_sku = D('Product_sku')->where(array('sku_id' => $sku_id, 'product_id' => $tuan['product_id']))->find();
			if (empty($product_sku)) {
				json_return(1000, '未找到商品相应的库存信息');
			}
			
			if ($product_sku['quantity'] < $quantity) {
				json_return(1000, '商品已经售完');
			}
			
			$price = round($product_sku['price'] * $discount / 10, 2);
			
			if ($product_sku['weight']) {
				$weight = $product_sku['weight'];
			}
			$tmpPropertiesArr = explode(';', $product_sku['properties']);
			$properties = $propertiesValue = $productProperties = array();
			foreach ($tmpPropertiesArr as $value) {
				$tmpPro = explode(':', $value);
				$properties[] = $tmpPro[0];
				$propertiesValue[] = $tmpPro[1];
			}
			if (count($properties) == 1) {
				$findPropertiesArr = D('Product_property')->field('`pid`,`name`')->where(array('pid' => $properties[0]))->select();
				$findPropertiesValueArr = D('Product_property_value')->field('`vid`,`value`')->where(array('vid' => $propertiesValue[0]))->select();
			} else {
				$findPropertiesArr = D('Product_property')->field('`pid`,`name`')->where(array('pid' => array('in', $properties)))->select();
				$findPropertiesValueArr = D('Product_property_value')->field('`vid`,`value`')->where(array('vid' => array('in', $propertiesValue)))->select();
			}
			foreach ($findPropertiesArr as $value) {
				$propertiesArr[$value['pid']] = $value['name'];
			}
			foreach ($findPropertiesValueArr as $value) {
				$propertiesValueArr[$value['vid']] = $value['value'];
			}
			foreach ($properties as $key => $value) {
				$productProperties[] = array('pid' => $value, 'name' => $propertiesArr[$value], 'vid' => $propertiesValue[$key], 'value' => $propertiesValueArr[$propertiesValue[$key]]);
			}
			$properties_str = serialize($productProperties);
		} else {
			$price = round($product['price'] * $discount / 10, 2);
		}
		
		// 开团进行处理
		if (empty($team_id)) {
			$data = array();
			$data['dateline'] = time();
			$data['tuan_id'] = $tuan_id;
			$data['uid'] = $this->user['uid'];
			$data['type'] = $type;
			$data['item_id'] = $item_id;
			$data['number'] = $tuan_config['number'];
			$data['price'] = round($product['price'] * $discount / 10, 2);
			$data['order_number'] = 0;
			
			$team_id = D('Tuan_team')->data($data)->add();
			if (empty($team_id)) {
				json_return(1000, '开团失败,请重试');
			}
		}
		
		// 订单数据
		$order_no = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
		$order_data = array();
		$data_order['store_id'] = $store_id;
		$data_order['uid'] = $this->user['uid'];
		$data_order['order_no'] = $data_order['trade_no'] = $order_no;
		$data_order['sub_total'] = $price * $quantity;
		$data_order['pro_num'] = $quantity;
		$data_order['pro_count'] = '1';
		$data_order['type'] = 6;
		$data_order['data_id'] = $tuan_id;
		$data_order['data_type'] = $type;
		$data_order['data_item_id'] = $team_id;
		$data_order['add_time'] = $_SERVER['REQUEST_TIME'];
		
		//订单所属团队
		if (!empty($store['drp_team_id'])) {
			if (M('Drp_team')->checkDrpTeam($store['store_id'], true)) {
				$data_order['drp_team_id'] = $store['drp_team_id'];
			}
		}
		
		$order_id = D('Order')->data($data_order)->add();
		$data_order['order_id'] = $order_id;
		if ($order_id) {
			$data_order_product = array();
			$data_order_product['order_id'] = $order_id;
			$data_order_product['product_id'] = $tuan['product_id'];
			$data_order_product['sku_id'] = $sku_id;
			$data_order_product['sku_data'] = $properties_str;
			$data_order_product['pro_num'] = $quantity;
			$data_order_product['pro_price'] = $price;
			$data_order_product['comment'] = !empty($_REQUEST['custom']) ? serialize($_REQUEST['custom']) : '';
			$data_order_product['pro_weight'] = $weight;
			$data_order_product['type'] = 1;
			$data_order_product['data_id'] = $tuan_id;
			$data_order_product['user_order_id'] = $order_id;
			
			if (D('Order_product')->data($data_order_product)->add()) {
				M('Store_user_data')->upUserData($store_id, $this->user['uid'], 'unpay');
				
				// 产生提醒
				import('source.class.Notify');
				Notify::createNoitfy($store_id, option('config.orderid_prefix') . $order_no);
				
				$uid = $this->user['uid'];
				$first_product_name = msubstr($product['name'], 0, 11);
				
				//产生提醒-已生成订单
				import('source.class.Notice');
				Notice::sendOut($uid, $data_order, $first_product_name);
				
				// 记录开团的团长订单号
				if (empty($tuan_team)) {
					D('Tuan_team')->where(array('team_id' => $team_id))->data(array('order_id' => $order_id))->save();
				}
				
				// 通知团长，团长自己开团不发
				if (0 && !empty($tuan_team)) {
					ShopNotice::TuanSuccessNotice($tuan_team['uid'], $this->user['uid'], $store_id);
				}
				
				json_return(0, array('url' => option('config.wap_site_url') . '/pay.php?id=' . option('config.orderid_prefix') . $order_no));
			} else {
				D('Order')->where(array('order_id' => $order_id))->delete();
				json_return(1005, '订单产生失败，请重试');
			}
		} else {
			json_return(1000, '订单产生失败，请重试');
		}
	}
	
	// 我的团购
	public function my_tuan() {
		$type = $_REQUEST['type'];
		$store_id = $_REQUEST['store_id'];
		$page = max(1, $_REQUEST['page']);
		$limit = 10;
		$offset = ($page - 1) * $limit;
		
		$link_arr = array();
		if (!empty($store_id)) {
			$store = M('Store')->getStore($store_id);
			if (empty($store)) {
				json_return(1000, '未找到相应的店铺');
			}
			
			$link_arr[] = array('name' => '店铺主页', 'url' => $store['url']);
			$link_arr[] = array('name' => '会员中心', 'url' => $store['ucenter_url']);
			if ($store['physical_count'] > 0) {
				$link_arr[] = array('name' => '线下门店', 'url' => option('config.wap_site_url').'/physical.php?id=' . $store['store_id']);
			}
		}
		
		// 条件
		$where = "tt.team_id = o.data_item_id AND tt.tuan_id = t.id AND t.product_id = p.product_id AND o.uid = '" . $this->user['uid'] . "' AND o.type = 6 AND (o.status = 2 OR o.status = 3 OR o.status = 4 OR o.status = 6 OR o.status = 7)";
		if ($store_id) {
			$where .= " AND o.store_id = '" . $store_id . "'";
		}
		if ($type == '1') {
			$where .= " AND tt.status = 0";
		} else if ($type == '2') {
			$where .= " AND tt.status = 1";
		} else if ($type == '3') {
			$where .= " AND tt.status = 2";
		}
		
		// 查询表
		$table_arr = array();
		$table_arr['Order'] = 'o';
		$table_arr['Tuan_team'] = 'tt';
		$table_arr['Tuan'] = 't';
		$table_arr['Product'] = 'p';
		
		// 所需字段
		$field = "o.order_id, o.order_no, o.total, o.pro_num, o.status as o_status, o.data_money, tt.team_id, tt.tuan_id, tt.uid, tt.type, tt.item_id, tt.status, tt.order_id as tt_order_id, t.product_id, p.name, p.image";
		$order_list = D('')->table($table_arr)->field($field)->where($where)->limit($offset . ', ' . $limit)->order('o.order_id DESC')->select();
		
		foreach ($order_list as &$order) {
			if ($order['uid'] == $this->user['uid'] && $order['tt_order_id'] == $order['order_id']) {
				$order['is_leader'] = true;
			} else {
				$order['is_leader'] = false;
			}
			$order['order_no'] = option('config.orderid_prefix') . $order['order_no'];
			$order['image'] = getAttachmentUrl($order['image']);
			$order['order_url'] = option('config.wap_site_url') . '/order.php?orderid=' . $order['order_id'];
			$order['tuan_url'] = $url = option('config.site_url') . '/webapp/groupbuy/#/detailinfo/' . $order['tuan_id'] . '/' . $order['type'] . '/' . $order['item_id'] . '/' . $order['team_id'];
		}
		
		$return = array();
		$return['order_list'] = $order_list;
		$return['next_page'] = true;
		if (empty($order_list)) {
			$return['next_page'] = false;
		} else if (count($order_list) < $limit) {
			$return['next_page'] = false;
		}
		$return['link_arr'] = $link_arr;
		
		json_return(0, $return);
	}
	
	// 团购频道
	public function channel() {
		$adver_list = M('Adver')->get_adver_by_key('wap_tuan_adver', 6);
		
		//首页自定义导航,后面用100000来表示不限制导航数量
		$slider_list = M('Slider')->get_slider_by_key('wap_tuan_nav', 100000);
		
		// 团购列表
		$tuan_list = M('Tuan')->getListByHome();
		// 没有查到推荐，直接用默认
		if (empty($tuan_list)) {
			$tuan_list = M('Tuan')->getListByCategory('', '', 't.id DESC');
		}
		
		$return = array();
		$return['adver_list'] = $adver_list;
		$return['slider_list'] = $slider_list;
		$return['tuan_list'] = $tuan_list;
		$return['title'] = '拼团商城-' . option('config.site_name');
		
		$url = urldecode($_REQUEST['url']);
		// 分享
		import('WechatShare');
		$share = new WechatShare();
		$share_data = $share->getSgin('', true, $url);
		$return['share_data'] = $share_data;
		
		json_return(0, $return);
	}
	
	// 团购列表
	public function tuan_list() {
		$cat_id = $_REQUEST['cat_id'];
		$type = $_REQUEST['type'];
		$page = max(1, $_REQUEST['page']);
		$limit = 6;
		$offset = ($page - 1) * $limit;
		
		if (!in_array($type, array('new', 'hot'))) {
			$type = 'new';
		}
		
		$order = 't.id DESC';
		if ($type == 'hot') {
			$order = 't.count DESC';
		}
		
		$tuan_list = M('Tuan')->getListByCategory($cat_id, '', $order, $offset, $limit);
		
		$return = array();
		$return['tuan_list'] = $tuan_list;
		$return['next_page'] = true;
		if (count($tuan_list) < $limit) {
			$return['next_page'] = false;
		}
		
		if ($page == 1) {
			$url = urldecode($_REQUEST['url']);
			// 分享
			import('WechatShare');
			$share = new WechatShare();
			$share_data = $share->getSgin('', true, $url);
			$return['share_data'] = $share_data;
		}
		
		json_return(0, $return);
	}
	
	// 正在开团列表
	public function team_list() {
		$cat_id = $_REQUEST['cat_id'];
		$page = max(1, $_REQUEST['page']);
		$limit = 6;
		$offset = ($page - 1) * $limit;
		
		$tuan_list = M('Tuan')->getListByTeam($cat_id, '', 'tt.team_id DESC', $offset, $limit);
		
		$return = array();
		$return['tuan_list'] = $tuan_list;
		$return['next_page'] = true;
		if (count($tuan_list) < $limit) {
			$return['next_page'] = false;
		}
		
		if ($page == 1) {
			$url = urldecode($_REQUEST['url']);
			// 分享
			import('WechatShare');
			$share = new WechatShare();
			$share_data = $share->getSgin('', true, $url);
			$return['share_data'] = $share_data;
		}
		
		json_return(0, $return);
	}
}
?>