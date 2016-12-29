<?php

/**
 *  处理订单
 */
require_once dirname(__FILE__) . '/global.php';
//默认add
$action = isset($_GET['action']) ? $_GET['action'] : 'add';

switch ($action) {
	
	//预售支付尾款（二次支付）
	case 'endpay':

		$order_id = $_POST['order_id'];
		$conditionOrder = array('order_id'=>$order_id);
		$firstOrder = D('Order')->where($conditionOrder)->find();
		$nowOrderProduct = D('Order_product')->where(array('order_id'=>$firstOrder['order_id']))->find();
		//if(!$firstOrder || ($firstOrder['type']!=7) || (!$firstOrder['data_id']) || !$nowOrderProduct) {
		if(!$firstOrder || ($firstOrder['type']!=7) || (!$firstOrder['data_id']) || !$nowOrderProduct) {
			json_return(1001, '你要支付的预售商品订单未找到！');
		}
		if($firstOrder['presale_order_id']) {
			//跳转进入二次支付页面
			$secOrderProduct =  D('Order')->where(array('order_id'=>$firstOrder['presale_order_id']))->find();
			json_return('9999',$config['orderid_prefix'] .$secOrderProduct['order_no']);
		}
		
		$nowStore = D('Store')->where(array('store_id' => $firstOrder['store_id']))->find();
		
		$drp_level = $nowStore['drp_level'];
		if ($drp_level > 3) {
			$drp_level = 3;
		}
		$presale_id = $firstOrder['data_id'];
		if(!$presale_id) {
			json_return(1002, '预售商品不存在');
		}
		
		
			
		//预售订单价格
		$time = time();
		$presale_info = D('Presale')->where(array('id'=>$presale_id))->find();
		if(($presale_info['is_open']!=1) || ($time > $presale_info['final_paytime'])) {
			json_return(1003,"该预售活动已结束，不能再支付咯！");
		}
		$product_Id = $presale_info['product_id'];
		//验证商品
		$nowProduct = D('Product')->field('`product_id`,`store_id`,`price`,`after_subscribe_discount`,`has_property`,`status`,`supplier_id`,`buyer_quota`,`weight`,`is_fx`,`unified_price_setting`,`drp_level_1_price`,`drp_level_2_price`,`drp_level_3_price`, `send_other`, `wholesale_product_id`, `open_return_point`, `return_point`')->where(array('product_id' => $product_Id))->find();
		if (empty($nowProduct) || $nowProduct['status']) {
			json_return(1004, '商品不在预售范围！');
		}
			
		//生成订单			
		///////////
		$quantity = $nowOrderProduct['pro_num'];
		$trade_no = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
		$data_order['store_id'] = $firstOrder['store_id'];
		$data_order['order_no'] = $data_order['trade_no'] = $trade_no;
		$order_no 	= $data_order['order_no'];
		$data_order['order_no'] = $data_order['trade_no'] = $order_no;
		$data_order['type'] = 7;	//预售订单
		$data_order['data_id'] = $firstOrder['data_id'];
		$data_order['presale_order_id'] = $firstOrder['order_id'];
		$data_order['pro_num'] = $quantity;
		$data_order['pro_count'] = '1';
		$data_order['bak'] = $firstOrder['bak'];
		$data_order['activity_data'] = $firstOrder['activity_data'] ? $firstOrder['activity_data'] : '';
		$data_order['add_time'] = $_SERVER['REQUEST_TIME'];
		if (!empty($wap_user['uid'])) {
			$data_order['uid'] = $wap_user['uid'];
		} else {
			$data_order['session_id'] = session_id();
		}
		if ($_POST['send_other'] == '1') {
			$data_order['shipping_method'] = 'send_other';
		}
		
		//订单所属团队
		if (!empty($nowStore['drp_team_id'])) {
			if (M('Drp_team')->checkDrpTeam($nowStore['store_id'], true)) {
				$data_order['drp_team_id'] = $nowStore['drp_team_id'];
			}
		}
		//预售订单价格
		$product_price = $nowOrderProduct['presale_pro_price'] - $presale_info['dingjin'];
		$data_order['sub_total'] = ($product_price * 100) * $quantity / 100;
		$data_order['order_pay_point'] = 0;
		$data_order['is_point_order'] = 0;
		//$data_order['status'] = 7;	//已发货
		
		$order_id = D('Order')->data($data_order)->add();
		$nowOrder = array_merge($data_order,array('order_id'=>$order_id));
		if (empty($order_id)) {
			json_return(1004, '订单产生失败，请重试');
		}
		D('Order')->data(array('presale_order_id'=>$order_id))->where(array('order_id'=>$firstOrder['order_id']))->save();
		D('Order')->data(array('presale_order_id'=>$order_id))->where(array('order_id'=>$nowOrder['order_id']))->save();
		
		/*计算特权优惠*/		
		
		//1。赠送优惠券
		$presale_info = D('Presale')-> where(array('id'=>$firstOrder['data_id']))->find();
		//增加预售特权折扣

		if($presale_info['privileged_cash']) {
			$privileged_cash = $presale_info['privileged_cash'] ;
			D('Order')->data("data_money = '".$presale_info['privileged_cash']."' ")->where(array('order_id'=>$nowOrder['order_id']))->save();		
		}
		
		if ($presale_info['privileged_coupon']) {
			$coupon_info = D('Coupon')->where(array('id'=>$presale_info['privileged_coupon']))->find();
			$data_user_coupon = array();
			$data_user_coupon['uid'] = $wap_user['uid'];
			$data_user_coupon['store_id'] = $coupon_info['store_id'];
			$data_user_coupon['coupon_id'] = $presale_info['privileged_coupon'];
			$data_user_coupon['card_no'] = String::keyGen();
			$data_user_coupon['cname'] = $coupon_info['name'];
			$data_user_coupon['face_money'] = $coupon_info['face_money'];
			$data_user_coupon['limit_money'] = $coupon_info['limit_money'];
			$data_user_coupon['start_time'] = $coupon_info['start_time'];
			$data_user_coupon['end_time'] = $coupon_info['end_time'];
			$data_user_coupon['is_expire_notice'] = $coupon_info['is_expire_notice'];
			$data_user_coupon['is_share'] = $coupon_info['is_share'];
			$data_user_coupon['is_all_product'] = $coupon_info['is_all_product'];
			$data_user_coupon['is_original_price'] = $coupon_info['is_original_price'];
			$data_user_coupon['description'] = $coupon_info['description'];
			$data_user_coupon['timestamp'] = time();
			$data_user_coupon['type'] = 2;
			$data_user_coupon['give_order_id'] = $order_id;
			
			D('User_coupon')->data($data_user_coupon)->add();
		}		

		//2。送赠品
		if ($presale_info['privileged_present']) {
			$present_product_arr =  M('Present')->getProductByPid($presale_info['privileged_present']);
			 
			if (is_array($present_product_arr) && count($present_product_arr) > 0) {
				foreach ($present_product_arr as $present) {
					$data_order_product = array();
					$data_order_product['order_id'] = $order_id;
					$data_order_product['product_id'] = $present['product_id'];
					
					// 是否有属性，有则随机挑选一个属性
					if ($present['has_property']) {
						$sku_arr = M('Product_sku')->getRandSku($present['product_id']);
						$data_order_product['sku_id'] = $sku_arr['sku_id'];
						$data_order_product['sku_data'] = $sku_arr['propertiey'];
					}
					
					$data_order_product['pro_num'] = 1;
					$data_order_product['pro_price'] = 0;
					$data_order_product['is_present'] = 1;
					
					$pro_num++;
					if (!in_array($present['product_id'], $product_id_arr)) {
						$pro_count++;
					}
					
					D('Order_product')->data($data_order_product)->add();
					unset($data_order_product);
				}
			}			 
		}
		
		$data_order_product['order_id'] = $order_id;
		$data_order_product['presale_pro_price'] = $nowOrderProduct['presale_pro_price'];
		$data_order_product['pro_weight'] = $nowOrderProduct['pro_weight'];
		$data_order_product['product_id'] = $nowOrderProduct['product_id'];
		$data_order_product['sku_id']	 = $nowOrderProduct['sku_id'];
		$data_order_product['sku_data']   = $nowOrderProduct['sku_data'];
		$data_order_product['pro_num']	= $quantity;
		//是否关注判断
		////////////////////////////////////////////////
		$data_order_product['pro_price']  = $product_price;
			
		$data_order_product['comment']	= !empty($_POST['custom']) ? serialize($_POST['custom']) : '';
		$data_order_product['pro_weight'] = $weight;
		//平台开启保证金
		if (option('credit.platform_credit_open')) {
			if (!empty($nowProduct['open_return_point'])) {
				$data_order_product['return_point'] = !empty($nowProduct['return_point']) ? $nowProduct['return_point'] : 0;
			} else {
				import('source.class.Margin');
				Margin::init($nowStore['store_id']);
				//现金兑积分
				$data_order_product['return_point'] = Margin::convert($product_price, 'point');
			}
		}
		
		$product_info = D('Product')->field('is_fx,product_id,store_id,original_product_id,supplier_id,wholesale_product_id,name, check_give_points, check_degree_discount, give_points')->where(array('product_id' => $nowProduct['product_id']))->find();
		if ($product_info['store_id'] == $nowStore['store_id'] && empty($product_info['supplier_id'])) { //店铺自营商品
			$supplier_id		 = 0;
			$original_product_id = 0;
			$data_order_product['is_fx']			   = 0;
			$data_order_product['supplier_id']		   = $supplier_id;
			$data_order_product['original_product_id'] = $original_product_id;
		} else if ($product_info['store_id'] == $nowStore['store_id'] && !empty($product_info['wholesale_product_id'])) { //店铺批发商品
			$supplier_id		 = $product_info['supplier_id'];
			$original_product_id = $product_info['wholesale_product_id'];
			$data_order_product['is_fx']			   = 0;
			$data_order_product['supplier_id']		   = $supplier_id;
			$data_order_product['original_product_id'] = $original_product_id;
		} else if ($product_info['store_id'] != $nowStore['store_id'] && !empty($product_info['is_fx']) && empty($product_info['wholesale_product_id'])) { //分销供货商自营商品
			$supplier_id		 = $product_info['store_id'];
			$original_product_id = $product_info['product_id'];
			$data_order_product['is_fx']			   = 1;
			$data_order_product['supplier_id']		   = $nowStore['drp_supplier_id'];
			$data_order_product['original_product_id'] = $original_product_id;
		} else if ($product_info['store_id'] != $nowStore['store_id'] && !empty($product_info['is_fx']) && !empty($product_info['wholesale_product_id'])) { //分销供货商批发商品
			$supplier_id		 = $product_info['supplier_id'];
			$original_product_id = $product_info['wholesale_product_id'];
			$data_order_product['is_fx']			   = 1;
			$data_order_product['supplier_id']		   = $nowStore['drp_supplier_id'];
			$data_order_product['original_product_id'] = $original_product_id;
		} else if ($product_info['store_id'] != $nowStore['store_id'] && empty($product_info['is_fx']) && empty($product_info['wholesale_product_id'])) { //分销供货商未设置分销的自营商品
			$supplier_id		 = $product_info['store_id'];
			$original_product_id = $product_info['product_id'];
			$data_order_product['is_fx']			   = 1;
			$data_order_product['supplier_id']		   = $nowStore['drp_supplier_id'];
			$data_order_product['original_product_id'] = $original_product_id;
		} else if ($product_info['store_id'] != $nowStore['store_id'] && empty($product_info['is_fx']) && !empty($product_info['wholesale_product_id'])) { //分销供货商未设置分销的批发商品
			$supplier_id		 = $product_info['supplier_id'];
			$original_product_id = $product_info['wholesale_product_id'];
			$data_order_product['is_fx']			   = 1;
			$data_order_product['supplier_id']		   = $nowStore['drp_supplier_id'];
			$data_order_product['original_product_id'] = $original_product_id;
		}
		$data_order_product['user_order_id']	   = $order_id;
			
		// 产品额外特权
		if (!empty($_SESSION['wap_user'])) {
			$product_discount = M('Product_discount')->getPointDiscount($product_info, $_SESSION['wap_user']['uid']);
			if (!empty($product_discount['point'])) {
				$data_order_product['point'] = $product_discount['point'];
			}
			if (!empty($product_discount['discount'])) {
				$data_order_product['discount'] = $product_discount['discount'];
			}
		}
		
		//			添加$data_order_product、
		if (D('Order_product')->data($data_order_product)->add()) {
			if (!empty($wap_user['uid'])) {
				M('Store_user_data')->upUserData($nowProduct['store_id'], $wap_user['uid'], 'unpay');
			}
			if (!empty($supplier_id)) { //修改订单，设置分销商
				$data = array();
				$data['suppliers'] = $supplier_id;
				if (!empty($supplier_id) && ($supplier_id != $nowStore['store_id'])) {
					$data['is_fx'] = 1;
					$data['type']  = 3;
				}
				D('Order')->where(array('order_id' => $order_id))->data($data)->save();
				$nowOrder = array_merge($nowOrder,$data);
			}
		
			// 产生提醒
			import('source.class.Notify');
			Notify::createNoitfy($nowStore['store_id'], option('config.orderid_prefix') . $order_no);
		
			//////////////////////////////////////////////////////////////////////////////////////////////////
			$uid = $_SESSION['wap_user']['uid'];
			$first_product_name = $product_info ? msubstr($product_info[name],0,11) : "";
		
			//产生提醒-已生成订单
			import('source.class.Notice');
			Notice::sendOut($uid, $nowOrder,$first_product_name);
		
			//////////////////////////////////////////////////////////////////////////////////////////////////
			json_return(0, $config['orderid_prefix'] . $order_no);
		} else {
			D('Order')->where(array('order_id' => $order_id))->delete();
			json_return(1005, '订单产生失败，请重试');
		}
	
		return;
		
		
		
		
		
		
		
		
		
		break;
	
	case 'add':
		
			$nowStore = D('Store')->where(array('store_id' => $_POST['storeId']))->find();

			$drp_level = $nowStore['drp_level'];
			if ($drp_level > 3) {
				$drp_level = 3;
			}
			$presale_id = $_POST['presale_id'];
			if(!$presale_id) {
				json_return(1002, '预售商品不存在');
			}
			
			//预售订单价格
			$time = time();
			$presale_info = D('Presale')->where(array('id'=>$presale_id))->find();
			if(($presale_info['is_open']!=1) || ($time > $presale_info['endtime']) || ($time < $presale_info['starttime'])) {
				json_return(1003,"该预售活动尚未开启或结束");
			}
			//验证商品
			$nowProduct = D('Product')->field('`product_id`,`store_id`,`price`,`after_subscribe_discount`,`has_property`,`status`,`supplier_id`,`buyer_quota`,`weight`,`is_fx`,`unified_price_setting`,`drp_level_1_price`,`drp_level_2_price`,`drp_level_3_price`, `send_other`, `wholesale_product_id`, `open_return_point`, `return_point`')->where(array('product_id' => $_POST['proId']))->find();
			if (empty($nowProduct) || $nowProduct['status']) {
				json_return(1004, '商品不在预售范围！');
			}
			
			if ($_POST['presale'] != '1' ) {
				json_return(1005, '商品不能被预订');
			}	
					
			// 送他人，代付物流相关判断
			if ($nowProduct['wholesale_product_id']) {
				// 
				$product_original = D('Product')->where(array('product_id' => $nowProduct['wholesale_product_id']))->find();
				
				//判定预售
				if (empty($product_original) || $product_original['status'] != '0') {
					json_return(1006, '您访问的商品已上架或售罄！');
				}

				$store_original = D('Store')->where(array('store_id' => $product_original['store_id']))->find();
				
				if (empty($store_original)) {
					json_return(1007, '您访问的店铺不存在');
				}
				

			} else {
				if ($nowProduct['store_id'] != $_POST['storeId']) {
					$store_original = D('Store')->where(array('store_id' => $nowProduct['store_id']))->find();
					$nowStore['open_logistics'] = $store_original['open_logistics'];
					$nowStore['open_friend'] = $store_original['open_friend'];
				}
				
				if ($_POST['send_other'] == '1' && $nowProduct['send_other'] != '1' && $nowStore['open_logistics'] != '1' && $nowStore['open_friend'] != '1') {
					json_return(1007, '商品不能送他人');
				}
				
			}
			
			//限购
			$buy_quantity = 0;
			$weight = $nowProduct['weight'];
			if (!empty($nowProduct['buyer_quota'])) {
				$user_type = 'uid';
				$uid = $_SESSION['wap_user']['uid'];
				if (empty($_SESSION['wap_user'])) { //游客购买
					$user_type = 'session';
					$session_id = session_id();
					$uid = session_id();
					
					// 查找购物车里相同产品的数量
					$user_cart_sum = D('User_cart')->where(array('session_id' => $uid, 'product_id' => $nowProduct['product_id']))->field('sum(pro_num) AS number')->find();
					$buy_quantity += $user_cart_sum['number'] + 0;
				} else {
					// 查找购物车里相同产品的数量
					$user_cart_sum = D('User_cart')->where(array('uid' => $uid, 'product_id' => $nowProduct['product_id']))->field('sum(pro_num) AS number')->find();
					$buy_quantity += $user_cart_sum['number'] + 0;
				}
				$tmp_quantity = intval(trim($_POST['quantity']));
				
				$buy_quantity += M('Order_product')->getBuyNumber($uid, $nowProduct['product_id'], $user_type);
				if (($buy_quantity + $tmp_quantity) > $nowProduct['buyer_quota']) { //限购
					json_return(1001, '商品限购，请修改购买数量');
				}
			}

			if (empty($nowProduct['has_property'])) {
				$skuId = 0;
				$propertiesStr = '';
				if (!empty($nowProduct['unified_price_setting']) && !empty($nowProduct['is_fx'])) { //分销商的价格
					$product_price = ($nowProduct['drp_level_' . $drp_level . '_price'] > 0) ? $nowProduct['drp_level_' . $drp_level . '_price'] : $nowProduct['price'];
				} else {
					$product_price = $nowProduct['price'];
				}
			} else {
				$skuId = !empty($_POST['skuId']) ? intval($_POST['skuId']) : json_return(1001, '请选择商品属性');
				//判断库存是否存在
				$nowSku = D('Product_sku')->field('`sku_id`,`product_id`,`properties`,`price`,`after_subscribe_price`, `weight`,`drp_level_1_price`,`drp_level_2_price`,`drp_level_3_price`')->where(array('sku_id' => $skuId))->find();
				
				if ($nowSku['weight']) {
					$weight = $nowSku['weight'];
				}
				$tmpPropertiesArr = explode(';', $nowSku['properties']);
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
				$propertiesStr = serialize($productProperties);
				if ($nowProduct['product_id'] != $nowSku['product_id'])
					json_return(1002, '商品属性选择错误');
				if (!empty($nowProduct['unified_price_setting']) && !empty($nowProduct['is_fx'])) { //分销商的价格
					$product_price = ($nowSku['drp_level_' . ($drp_level <= 3 ? $drp_level : 3) . '_price'] > 0) ? $nowSku['drp_level_' . ($drp_level <= 3 ? $drp_level : 3) . '_price'] : $nowSku['price'];
				} else {
//					是否关注，预留判断
					if($nowProduct['after_subscribe_discount'] >= 1){
						$product_price = $nowSku['after_subscribe_price'];
					}else{
						$product_price = $nowSku['price'];

					}
				}
			}

/* 			if ($_POST['activityId']) {
				$nowActivity = M('Product_qrcode_activity')->getActivityById($_POST['activityId']);
				if ($nowActivity['product_id'] == $nowProduct['product_id']) {
					if ($nowActivity['type'] == 0) {
						$product_price = round($product_price * $nowActivity['discount'] / 10, 2);
					} else {
						$product_price = $product_price - $nowActivity['price'];
					}
				}
			} */
		


		$quantity = intval($_POST['quantity']) > 0 ? intval($_POST['quantity']) : json_return(1003, '请输入购买数量');
		
		if (empty($_POST['isAddCart'])) { //立即购买
			$trade_no = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);

			$data_order['store_id'] = intval(trim($_POST['storeId']));
			$data_order['order_no'] = $data_order['trade_no'] = $trade_no;
			
			$order_no 	= $data_order['order_no'];
			$data_order['order_no'] = $data_order['trade_no'] = $order_no;
			if (!empty($wap_user['uid'])) {
				$data_order['uid'] = $wap_user['uid'];
			} else {
				$data_order['session_id'] = session_id();
			}
			
			$data_order['pro_num'] = $quantity;
			$data_order['pro_count'] = '1';
			$data_order['type'] = 7;	//预售订单
			$data_order['data_id'] = $presale_info[id];	//预售id
			$data_order['bak'] = $_POST['bak'] ? serialize($_POST['bak']) : '';
			$data_order['activity_data'] = $_POST['activity_data'] ? serialize($_POST['activity_data']) : '';
			$data_order['add_time'] = $_SERVER['REQUEST_TIME'];
			if ($_POST['send_other'] == '1') {
				$data_order['shipping_method'] = 'send_other';
			}

			//订单所属团队
			if (!empty($nowStore['drp_team_id'])) {
				if (M('Drp_team')->checkDrpTeam($nowStore['store_id'], true)) {
					$data_order['drp_team_id'] = $nowStore['drp_team_id'];
				}
			}
			//预售订单价格
			$presale_pro_price = $product_price;
			$product_price = $presale_info['dingjin'];
			
			$data_order['sub_total'] = ($product_price * 100) * $quantity / 100;
			$data_order['order_pay_point'] = 0;
			$data_order['is_point_order'] = 0;
			//$data_order['status'] = 7;	//已发货

			$order_id = D('Order')->data($data_order)->add();
			$nowOrder = array_merge($data_order,array('order_id'=>$order_id));
			if (empty($order_id)) {
				json_return(1004, '订单产生失败，请重试');
			}

			$data_order_product['order_id'] = $order_id;
			$data_order_product['product_id'] = $nowProduct['product_id'];
			$data_order_product['sku_id']	 = $skuId;
			$data_order_product['sku_data']   = $propertiesStr;
			$data_order_product['pro_num']	= $quantity;
//			是否关注判断
			////////////////////////////////////////////////
			$data_order_product['pro_price']  = $product_price;
			$data_order_product['presale_pro_price']  = $presale_pro_price;
			$data_order_product['comment']	= !empty($_POST['custom']) ? serialize($_POST['custom']) : '';
			$data_order_product['pro_weight'] = $weight;
			//平台开启保证金
			if (option('credit.platform_credit_open')) {
				if (!empty($nowProduct['open_return_point'])) {
					$data_order_product['return_point'] = !empty($nowProduct['return_point']) ? $nowProduct['return_point'] : 0;
				} else {
					import('source.class.Margin');
					Margin::init($nowStore['store_id']);
					//现金兑积分
					$data_order_product['return_point'] = Margin::convert($product_price, 'point');
				}
			}

			$product_info = D('Product')->field('is_fx,product_id,store_id,original_product_id,supplier_id,wholesale_product_id,name, check_give_points, check_degree_discount, give_points')->where(array('product_id' => $nowProduct['product_id']))->find();
			if ($product_info['store_id'] == $nowStore['store_id'] && empty($product_info['supplier_id'])) { //店铺自营商品
				$supplier_id		 = 0;
				$original_product_id = 0;
				$data_order_product['is_fx']			   = 0;
				$data_order_product['supplier_id']		   = $supplier_id;
				$data_order_product['original_product_id'] = $original_product_id;
			} else if ($product_info['store_id'] == $nowStore['store_id'] && !empty($product_info['wholesale_product_id'])) { //店铺批发商品
				$supplier_id		 = $product_info['supplier_id'];
				$original_product_id = $product_info['wholesale_product_id'];
				$data_order_product['is_fx']			   = 0;
				$data_order_product['supplier_id']		   = $supplier_id;
				$data_order_product['original_product_id'] = $original_product_id;
			} else if ($product_info['store_id'] != $nowStore['store_id'] && !empty($product_info['is_fx']) && empty($product_info['wholesale_product_id'])) { //分销供货商自营商品
				$supplier_id		 = $product_info['store_id'];
				$original_product_id = $product_info['product_id'];
				$data_order_product['is_fx']			   = 1;
				$data_order_product['supplier_id']		   = $nowStore['drp_supplier_id'];
				$data_order_product['original_product_id'] = $original_product_id;
			} else if ($product_info['store_id'] != $nowStore['store_id'] && !empty($product_info['is_fx']) && !empty($product_info['wholesale_product_id'])) { //分销供货商批发商品
				$supplier_id		 = $product_info['supplier_id'];
				$original_product_id = $product_info['wholesale_product_id'];
				$data_order_product['is_fx']			   = 1;
				$data_order_product['supplier_id']		   = $nowStore['drp_supplier_id'];
				$data_order_product['original_product_id'] = $original_product_id;
			} else if ($product_info['store_id'] != $nowStore['store_id'] && empty($product_info['is_fx']) && empty($product_info['wholesale_product_id'])) { //分销供货商未设置分销的自营商品
				$supplier_id		 = $product_info['store_id'];
				$original_product_id = $product_info['product_id'];
				$data_order_product['is_fx']			   = 1;
				$data_order_product['supplier_id']		   = $nowStore['drp_supplier_id'];
				$data_order_product['original_product_id'] = $original_product_id;
			} else if ($product_info['store_id'] != $nowStore['store_id'] && empty($product_info['is_fx']) && !empty($product_info['wholesale_product_id'])) { //分销供货商未设置分销的批发商品
				$supplier_id		 = $product_info['supplier_id'];
				$original_product_id = $product_info['wholesale_product_id'];
				$data_order_product['is_fx']			   = 1;
				$data_order_product['supplier_id']		   = $nowStore['drp_supplier_id'];
				$data_order_product['original_product_id'] = $original_product_id;
			}
			$data_order_product['user_order_id']	   = $order_id;
			
			// 产品额外特权
			if (!empty($_SESSION['wap_user'])) {
				$product_discount = M('Product_discount')->getPointDiscount($product_info, $_SESSION['wap_user']['uid']);
				if (!empty($product_discount['point'])) {
					$data_order_product['point'] = $product_discount['point'];
				}
				if (!empty($product_discount['discount'])) {
					$data_order_product['discount'] = $product_discount['discount'];
				}
			}

//			添加$data_order_product、
			if (D('Order_product')->data($data_order_product)->add()) {
				if (!empty($wap_user['uid'])) {
					M('Store_user_data')->upUserData($nowProduct['store_id'], $wap_user['uid'], 'unpay');
				}
				if (!empty($supplier_id)) { //修改订单，设置分销商
					$data = array();
					$data['suppliers'] = $supplier_id;
					if (!empty($supplier_id) && ($supplier_id != $nowStore['store_id'])) {
						$data['is_fx'] = 1;
						$data['type']  = 3;
					}
					D('Order')->where(array('order_id' => $order_id))->data($data)->save();
					$nowOrder = array_merge($nowOrder,$data);
				}

				// 产生提醒
				import('source.class.Notify');
				Notify::createNoitfy($nowStore['store_id'], option('config.orderid_prefix') . $order_no);

				//////////////////////////////////////////////////////////////////////////////////////////////////
				$uid = $_SESSION['wap_user']['uid'];
				$first_product_name = $product_info ? msubstr($product_info[name],0,11) : "";
				
				//产生提醒-已生成订单
				import('source.class.Notice');
				Notice::sendOut($uid, $nowOrder,$first_product_name);

				//////////////////////////////////////////////////////////////////////////////////////////////////	
				json_return(0, $config['orderid_prefix'] . $order_no);
			} else {
				D('Order')->where(array('order_id' => $order_id))->delete();
				json_return(1005, '订单产生失败，请重试');
			}
		} else {
			if (!empty($wap_user['uid'])) {
				$data_user_cart['uid'] = $wap_user['uid'];

				// 查找购物车里相同产品的数量
				$user_cart = D('User_cart')->field('pigcms_id')->where(array('uid' => $data_user_cart['uid'], 'product_id' => $nowProduct['product_id'], 'sku_id' => $skuId, 'pro_price' => $product_price))->find();
				if (!empty($user_cart['pigcms_id'])) {
					if (D('User_cart')->where(array('pigcms_id' => $user_cart['pigcms_id']))->setInc('pro_num', $quantity)) {
						break;
					}
				}
			} else {
				$data_user_cart['session_id'] = session_id();

				// 查找购物车里相同产品的数量
				$user_cart = D('User_cart')->field('pigcms_id')->where(array('session_id' => $data_user_cart['session_id'], 'product_id' => $nowProduct['product_id'], 'sku_id' => $skuId, 'pro_price' => $product_price))->find();
				if (!empty($user_cart['pigcms_id'])) {
					if (D('User_cart')->where(array('pigcms_id' => $user_cart['pigcms_id']))->setInc('pro_num', $quantity)) {
						break;
					}
				}
			}
			$data_user_cart['product_id'] = $nowProduct['product_id'];
			$data_user_cart['store_id']   = intval(trim($_POST['storeId']));
			$data_user_cart['sku_id']	  = $skuId;
			$data_user_cart['sku_data']   = $propertiesStr;
			$data_user_cart['pro_num']	  = $quantity;
//			$data_user_cart['pro_price']  = 1;
			$data_user_cart['pro_price']  = $product_price;
			$data_user_cart['add_time']   = $_SERVER['REQUEST_TIME'];
			$data_user_cart['comment']	  = !empty($_POST['custom']) ? serialize($_POST['custom']) : '';

			$product_info = D('Product')->field('is_fx,product_id,store_id,original_product_id,supplier_id,wholesale_product_id,name')->where(array('product_id' => $nowProduct['product_id']))->find();
			if ($product_info['store_id'] == $nowStore['store_id'] && empty($product_info['supplier_id'])) { //店铺自营商品
				$supplier_id			 = 0;
				$data_user_cart['is_fx'] = 0;
			} else if ($product_info['store_id'] == $nowStore['store_id'] && !empty($product_info['wholesale_product_id'])) { //店铺批发商品
				$supplier_id			 = $product_info['supplier_id'];
				$data_user_cart['is_fx'] = 0;
			} else if ($product_info['store_id'] != $nowStore['store_id'] && !empty($product_info['is_fx']) && empty($product_info['wholesale_product_id'])) { //分销供货商自营商品
				$supplier_id			 = $product_info['store_id'];
				$data_user_cart['is_fx'] = 1;
			} else if ($product_info['store_id'] != $nowStore['store_id'] && !empty($product_info['is_fx']) && !empty($product_info['wholesale_product_id'])) { //分销供货商批发商品
				$supplier_id			 = $product_info['supplier_id'];
				$data_user_cart['is_fx'] = 1;
			} else if ($product_info['store_id'] != $nowStore['store_id'] && empty($product_info['is_fx']) && empty($product_info['wholesale_product_id'])) { //分销供货商未设置分销的自营商品
				$supplier_id			 = $product_info['store_id'];
				$data_user_cart['is_fx'] = 1;
			} else if ($product_info['store_id'] != $nowStore['store_id'] && empty($product_info['is_fx']) && !empty($product_info['wholesale_product_id'])) { //分销供货商未设置分销的批发商品
				$supplier_id			 = $product_info['supplier_id'];
				$data_user_cart['is_fx'] = 1;
			}

			if (D('User_cart')->data($data_user_cart)->add()) {
				json_return(0, '添加成功');
				
			} else {
				json_return(1005, '订单产生失败，请重试');
			}
		}
		break;
	case 'pay':
		import('source.class.OrderPay');
		$order_pay = new OrderPay();
		$order_pay->pay();
		break;
	case 'cart_count':
		if (empty($_COOKIE['wap_store_id']))
			json_return(1014, '访问异常');
		if ($wap_user['uid']) {
			$condition_user_cart['uid'] = $wap_user['uid'];
		} else {
			$condition_user_cart['session_id'] = session_id();
		}
		$condition_user_cart['store_id'] = $_COOKIE['wap_store_id'];
		$return['count'] = D('User_cart')->where($condition_user_cart)->count('pigcms_id');
		$return['store_id'] = $_COOKIE['wap_store_id'];
//		返回count、store_id
		json_return(0, $return);
	case 'test_pay':
		import('source.class.OrderPay');
		$order_pay = new OrderPay();
		$order_pay->test();
		break;
	case 'go_pay':
		import('source.class.OrderPay');
		$order_pay = new OrderPay();
		$order_pay->go_pay();
}
?>