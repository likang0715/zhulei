<?php
/**
 * 订单控制器
 */
class myorder_controller extends base_controller{
	// 添加订单
	public function add() {
	
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
		$store_id = $_REQUEST['store_id'];
		$uid = $_REQUEST['uid'];
	
	
		$product_id = $_REQUEST['product_id'];
		$quantity = max(1, $_REQUEST['quantity']); //数量
		$sku_id = $_REQUEST['sku_id'];        //属性ID
		$send_other = $_REQUEST['send_other']; //是否赠送 0:否，1：是
		$is_add_cart = $_REQUEST['is_add_cart']; // 1 加入购物车
		//$_REQUEST['type'] 订单类型 0普通 1代付 2送礼 3分销
		//$_REQUEST['bak']  备注
		//$_REQUEST['custom'] 买家留言
		if (empty($product_id)) {
			$results['result']='1';
			$results['msg']='缺少最基本的参数';
			exit(json_encode($results));
		}
		
		//验证商品
		$product = D('Product')->field('`product_id`,`store_id`,`price`,`after_subscribe_discount`,`after_subscribe_price`,`has_property`,`status`,`supplier_id`,`buyer_quota`,`weight`,`is_fx`,`unified_price_setting`,`drp_level_1_price`,`drp_level_2_price`,`drp_level_3_price`, `send_other`, `wholesale_product_id`, `open_return_point`, `return_point`')->where(array('product_id' => $product_id))->find();
		if (empty($product) || empty($product['status'])) {
			
			$results['result']='1';
			$results['msg']='商品不存在';
			exit(json_encode($results));
		}
		
		if ($product['uid'] == $uid) {
		
			$results['result']='1';
			$results['msg']='不能购买自己的商品';
			exit(json_encode($results));
		}
	
		$drp_level = $store['drp_level'];
		if ($drp_level > 3) {
			$drp_level = 3;
		}
		
		// 是否关注过公众号
		$where = array();
		$where['uid'] = $uid;
		$where['store_id'] = $store_id;
		$where['subscribe_time'] = array('>', 0);
		$subscribe_store = D('Subscribe_store')->where($where)->find();
		
		// 送他人，代付物流相关判断
		if ($product['wholesale_product_id']) {
			// 批发商品id
			$product_original = D('Product')->where(array('product_id' => $product['wholesale_product_id']))->find();
			if (empty($product_original) || $product_original['status'] != '1') {
			
			$results['result']='1';
			$results['msg']='您访问的商品不存在或未上架或已删除';
			exit(json_encode($results));
			}
			$store_original = D('Store')->where(array('store_id' => $product_original['store_id']))->find();
			
			if (empty($store_original)) {
			
			$results['result']='1';
			$results['msg']='您访问的店铺不存在';
			exit(json_encode($results));
			}
			
			if ($send_other == '1' && $product_original['send_other'] != '1' && $store_original['open_logistics'] != '1' && $store_original['open_friend'] != '1') {
			
			$results['result']='1';
			$results['msg']='商品不能送他人';
			exit(json_encode($results));
			}
		} else {
			if ($product['store_id'] != $store_id) {
				$store_original = D('Store')->where(array('store_id' => $product['store_id']))->find();
				$store['open_logistics'] = $store_original['open_logistics'];
				$store['open_friend'] = $store_original['open_friend'];
			}
			
			if ($send_other == '1' && $product['send_other'] != '1' && $store['open_logistics'] != '1' && $store['open_friend'] != '1') {
			
			$results['result']='1';
			$results['msg']='商品不能送他人';
			exit(json_encode($results));
			}
		}
		
		//限购
		$buy_quantity = 0;
		if (!empty($product['buyer_quota'])) {
			$user_type = 'uid';
			$uid = $uid;
			
			// 查找购物车里相同产品的数量
			$user_cart_sum = D('User_cart')->where(array('uid' => $uid, 'product_id' => $product['product_id']))->field('sum(pro_num) AS number')->find();
			$buy_quantity += $user_cart_sum['number'] + 0;
			
			$tmp_quantity = intval(trim($quantity));
			
			$buy_quantity += M('Order_product')->getBuyNumber($uid, $product['product_id'], $user_type);
			if (($buy_quantity + $tmp_quantity) > $product['buyer_quota']) {
			
			$results['result']='1';
			$results['msg']='商品限购，请修改购买数量';
			exit(json_encode($results));
			}
		}
		
		// 产品价格
		$product_price = $product['price'];
		$weight = $product['weight'];
		$properties_str = '';
		if (empty($product['has_property'])) {
			$sku_id = 0;
			if (!empty($product['unified_price_setting']) && !empty($product['is_fx'])) {
				$product_price = ($product['drp_level_' . $drp_level . '_price'] > 0) ? $product['drp_level_' . $drp_level . '_price'] : $product['price'];
				if ($product['after_subscribe_discount'] > 0 && $product['after_subscribe_discount'] < 10 && !empty($subscribe_store)) {
					$product_price = $product_price * $product['after_subscribe_discount'] / 10;
				}
			} else {
				if ($product['after_subscribe_discount'] > 0 && $product['after_subscribe_discount'] < 10 && !empty($subscribe_store)) {
					$product_price = $product['after_subscribe_discount'] * $product['price'] / 10;
				} else {
					$product_price = $product['price'];
				}
			}
		} else {
			// 有商品属性
			if (empty($sku_id)) {
			
			$results['result']='1';
			$results['msg']='请选择商品属性';
			exit(json_encode($results));
			}
			
			//判断库存是否存在
			$product_sku = D('Product_sku')->field('`sku_id`,`product_id`,`properties`,`price`,`after_subscribe_price`, `weight`,`drp_level_1_price`,`drp_level_2_price`,`drp_level_3_price`')->where(array('sku_id' => $sku_id))->find();
			if ($product['product_id'] != $product_sku['product_id']) {
			
			$results['result']='1';
			$results['msg']='商品属性选择错误';
			exit(json_encode($results));
			}
			
			if ($product_sku['weight']) {
				$weight = $product_sku['weight'];
			}
			
			$properties_arr = explode(';', $product_sku['properties']);
			$properties = $propertiesValue = $productProperties = array();
			foreach ($properties_arr as $value) {
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
			if (!empty($product['unified_price_setting']) && !empty($product['is_fx'])) {
				//分销商的价格
				$product_price = ($product_sku['drp_level_' . ($drp_level <= 3 ? $drp_level : 3) . '_price'] > 0) ? $product_sku['drp_level_' . ($drp_level <= 3 ? $drp_level : 3) . '_price'] : $product_sku['price'];
				
				// 用户是否关注
				if ($product['after_subscribe_discount'] > 0 && $product['after_subscribe_discount'] < 10 && !empty($subscribe_store)) {
					$product_price = $product_price * $product['after_subscribe_discount'] / 10;
				}
			} else {
				// 用户是否关注
				if ($product['after_subscribe_discount'] > 0 && $product['after_subscribe_discount'] < 10 && !empty($subscribe_store)) {
					$product_price = $product_sku['price'] * $product['after_subscribe_discount'] / 10;
				} else {
					$product_price = $product_sku['price'];
				}
			}
		}
		
		// 是否加入购物车
		if (empty($is_add_cart)) {
			//立即购买
			$order_no = $trade_no = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
			$data_order['store_id'] = 18;
			$data_order['order_no'] = $trade_no;
			$data_order['trade_no'] = $trade_no;
			$data_order['status'] = 1;
			$data_order['uid'] = $uid;
			$data_order['pro_num'] = $quantity;
			$data_order['pro_count'] = '1';
			$data_order['type'] = $_REQUEST['type'] ? (int) $_REQUEST['type'] : 0;
			$data_order['bak'] = $_REQUEST['bak'] ? serialize($_REQUEST['bak']) : '';
			$data_order['add_time'] = $_SERVER['REQUEST_TIME'];
			if ($send_other == '1') {
				$data_order['shipping_method'] = 'send_other';
			}
			
			//订单所属团队
			if (!empty($store['drp_team_id'])) {
				if (M('Drp_team')->checkDrpTeam($store['store_id'], true)) {
					$data_order['drp_team_id'] = $store['drp_team_id'];
				}
			}
			//积分商城订单
			if($store['is_point_mall'] == '1') {
				$data_order['sub_total'] = 0;
				$data_order['order_pay_point'] = intval(($product_price * 100) * $quantity / 100);
				$data_order['is_point_order'] = 1;
			} else {
				$data_order['sub_total'] = ($product_price * 100) * $quantity / 100;
				$data_order['order_pay_point'] = 0;
				$data_order['is_point_order'] = 0;
			}
			
			$order_id = D('Order')->data($data_order)->add();
			$order = array_merge($data_order, array('order_id' => $order_id));
			
			if (empty($order_id)) {
			
			$results['result']='1';
			$results['msg']='订单产生失败，请重试';
			exit(json_encode($results));
			}
			
			$data_order_product['order_id'] = $order_id;
			$data_order_product['product_id'] = $product['product_id'];
			$data_order_product['sku_id'] = $sku_id;
			$data_order_product['sku_data'] = $properties_str;
			$data_order_product['pro_num'] = $quantity;
			$data_order_product['pro_price'] = $product_price;
			$data_order_product['comment'] = !empty($_REQUEST['custom']) ? serialize($_REQUEST['custom']) : '';
			$data_order_product['pro_weight'] = $weight;
			// 平台开启保证金
			if (option('credit.platform_credit_open')) {
				if (!empty($product['open_return_point'])) {
					$data_order_product['return_point'] = !empty($product['return_point']) ? $product['return_point'] : 0;
				} else {
					import('source.class.Margin');
					Margin::init($store_id);
					//现金兑积分
					$data_order_product['return_point'] = Margin::convert($product_price, 'point');
				}
			}
			
			$product_info = D('Product')->field('is_fx,product_id,store_id,original_product_id,supplier_id,wholesale_product_id,name, check_give_points, check_degree_discount, give_points')->where(array('product_id' => $product['product_id']))->find();
			if ($product_info['store_id'] == $store['store_id'] && empty($product_info['supplier_id'])) { //店铺自营商品
				$supplier_id = 0;
				$original_product_id = 0;
				$data_order_product['is_fx'] = 0;
				$data_order_product['supplier_id'] = $supplier_id;
				$data_order_product['original_product_id'] = $original_product_id;
			} else if ($product_info['store_id'] == $store['store_id'] && !empty($product_info['wholesale_product_id'])) { //店铺批发商品
				$supplier_id = $product_info['supplier_id'];
				$original_product_id = $product_info['wholesale_product_id'];
				$data_order_product['is_fx'] = 0;
				$data_order_product['supplier_id'] = $supplier_id;
				$data_order_product['original_product_id'] = $original_product_id;
			} else if ($product_info['store_id'] != $store['store_id'] && !empty($product_info['is_fx']) && empty($product_info['wholesale_product_id'])) { //分销供货商自营商品
				$supplier_id = $product_info['store_id'];
				$original_product_id = $product_info['product_id'];
				$data_order_product['is_fx'] = 1;
				$data_order_product['supplier_id'] = $store['drp_supplier_id'];
				$data_order_product['original_product_id'] = $original_product_id;
			} else if ($product_info['store_id'] != $store['store_id'] && !empty($product_info['is_fx']) && !empty($product_info['wholesale_product_id'])) { //分销供货商批发商品
				$supplier_id = $product_info['supplier_id'];
				$original_product_id = $product_info['wholesale_product_id'];
				$data_order_product['is_fx'] = 1;
				$data_order_product['supplier_id'] = $store['drp_supplier_id'];
				$data_order_product['original_product_id'] = $original_product_id;
			} else if ($product_info['store_id'] != $store['store_id'] && empty($product_info['is_fx']) && empty($product_info['wholesale_product_id'])) { //分销供货商未设置分销的自营商品
				$supplier_id = $product_info['store_id'];
				$original_product_id = $product_info['product_id'];
				$data_order_product['is_fx'] = 1;
				$data_order_product['supplier_id'] = $store['drp_supplier_id'];
				$data_order_product['original_product_id'] = $original_product_id;
			} else if ($product_info['store_id'] != $store['store_id'] && empty($product_info['is_fx']) && !empty($product_info['wholesale_product_id'])) { //分销供货商未设置分销的批发商品
				$supplier_id = $product_info['supplier_id'];
				$original_product_id = $product_info['wholesale_product_id'];
				$data_order_product['is_fx'] = 1;
				$data_order_product['supplier_id'] = $store['drp_supplier_id'];
				$data_order_product['original_product_id'] = $original_product_id;
			}
			$data_order_product['user_order_id'] = $order_id;
				
			// 产品额外特权
			$product_discount = M('Product_discount')->getPointDiscount($product_info, $uid);
			if (!empty($product_discount['point'])) {
				$data_order_product['point'] = $product_discount['point'];
			}
			if (!empty($product_discount['discount'])) {
				$data_order_product['discount'] = $product_discount['discount'];
			}
			
			// 
			if (D('Order_product')->data($data_order_product)->add()) {
				M('Store_user_data')->upUserData($product['store_id'], $uid, 'unpay');
				
				if (!empty($supplier_id)) { //修改订单，设置分销商
					$data = array();
					$data['suppliers'] = $supplier_id;
					if (!empty($supplier_id) && ($supplier_id != $store['store_id'])) {
						$data['is_fx'] = 1;
						$data['type'] = 3;
					}
					D('Order')->where(array('order_id' => $order_id))->data($data)->save();
					$order = array_merge($order, $data);
				}
			
				// 产生提醒
				import('source.class.Notify');
				Notify::createNoitfy($store_id, option('config.orderid_prefix') . $order_no);
			
				//////////////////////////////////////////////////////////////////////////////////////////////////
				$uid = $uid;
				$first_product_name = $product_info ? msubstr($product_info['name'], 0, 11) : '';
			
				//产生提醒-已生成订单
				import('source.class.Notice');
				Notice::sendOut($uid, $order, $first_product_name);
			
				//////////////////////////////////////////////////////////////////////////////////////////////////
			//	json_return(0, option('config.orderid_prefix') . $order_no);
			$data['order_no']=$order_no;
			$results['data']=$data;
			exit(json_encode($results));
			} else {
				D('Order')->where(array('order_id' => $order_id))->delete();
			
			$results['result']='1';
			$results['msg']='订单产生失败，请重试';
			exit(json_encode($results));
			}
		} else {
			// 加入购物车
			$data_user_cart = array();
			$data_user_cart['uid'] = $uid;
			
			// 查找购物车里相同产品的数量
			$user_cart = D('User_cart')->field('pigcms_id')->where(array('uid' => $data_user_cart['uid'], 'product_id' => $product['product_id'], 'sku_id' => $sku_id, 'pro_price' => $product_price))->find();
			if (!empty($user_cart['pigcms_id'])) {
				if (D('User_cart')->where(array('pigcms_id' => $user_cart['pigcms_id']))->setInc('pro_num', $quantity)) {
					
		
					$results['msg']='添加成功';
					exit(json_encode($results));
				} else {
					
					$results['result']='1';
					$results['msg']='加入购物车失败';
					exit(json_encode($results));
				}
			}
			
			$data_user_cart['product_id'] = $product['product_id'];
			$data_user_cart['store_id'] = $store_id;
			$data_user_cart['sku_id'] = $sku_id;
			$data_user_cart['sku_data'] = $properties_str;
			$data_user_cart['pro_num'] = $quantity;
			$data_user_cart['pro_price'] = $product_price;
			$data_user_cart['add_time'] = $_SERVER['REQUEST_TIME'];
			$data_user_cart['comment'] = !empty($_REQUEST['custom']) ? serialize($_REQUEST['custom']) : '';
			
			$product_info = D('Product')->field('is_fx,product_id,store_id,original_product_id,supplier_id,wholesale_product_id,name')->where(array('product_id' => $nowProduct['product_id']))->find();
			if ($product_info['store_id'] == $store['store_id'] && empty($product_info['supplier_id'])) { //店铺自营商品
				$supplier_id = 0;
				$data_user_cart['is_fx'] = 0;
			} else if ($product_info['store_id'] == $store['store_id'] && !empty($product_info['wholesale_product_id'])) { //店铺批发商品
				$supplier_id = $product_info['supplier_id'];
				$data_user_cart['is_fx'] = 0;
			} else if ($product_info['store_id'] != $store['store_id'] && !empty($product_info['is_fx']) && empty($product_info['wholesale_product_id'])) { //分销供货商自营商品
				$supplier_id = $product_info['store_id'];
				$data_user_cart['is_fx'] = 1;
			} else if ($product_info['store_id'] != $store['store_id'] && !empty($product_info['is_fx']) && !empty($product_info['wholesale_product_id'])) { //分销供货商批发商品
				$supplier_id = $product_info['supplier_id'];
				$data_user_cart['is_fx'] = 1;
			} else if ($product_info['store_id'] != $store['store_id'] && empty($product_info['is_fx']) && empty($product_info['wholesale_product_id'])) { //分销供货商未设置分销的自营商品
				$supplier_id = $product_info['store_id'];
				$data_user_cart['is_fx'] = 1;
			} else if ($product_info['store_id'] != $store['store_id'] && empty($product_info['is_fx']) && !empty($product_info['wholesale_product_id'])) { //分销供货商未设置分销的批发商品
				$supplier_id = $product_info['supplier_id'];
				$data_user_cart['is_fx'] = 1;
			}
			
			if (D('User_cart')->data($data_user_cart)->add()) {
				
				  
					$results['msg']='添加成功';
					exit(json_encode($results));
			} else {
			
				$results['result']='1';
				$results['msg']='加入购物车失败，请重试';
				exit(json_encode($results));
				
			}
		}
	}
	
	// 预售订单付尾款
	public function presale_add() {
		$order_id = $_REQUEST['order_id'];
		
		if (empty($order_id)) {
			json_return(1000, '缺少参数');
		}
		
		$order_master = D('Order')->where(array('order_id' => $order_id, 'uid' => $uid))->find();
		if (empty($order_master) || $order_master['type'] != 7 || empty($order_master['data_id'])) {
			json_return(1000, '未找到相应的预售订单');
		}
		
		$order_product = D('Order_product')->where(array('order_id' => $order_master['order_id']))->find();
		if (empty($order_product)) {
			json_return(1000, '未找到相应的预售产品');
		}
		
		$presale = D('Presalce')->where(array('id' => $order_master['data_id']))->find();
		if (empty($presale)) {
			json_return(1000, '未找到相应的预售');
		}
		
		if ($presale['final_paytime'] < time() || $presale['is_open'] != 1) {
			json_return(1000, '预售尾款支付时间已结束');
		}
		
		// 判断尾款订单是否已支付
		if ($order_master['presale_order_id']) {
			$order_slave = D('Order')->where(array('order_id' => $order_master['presale_order_id']))->find();
			if (!empty($order_slave)) {
				if ($order_slave['status'] > 1) {
					json_return(1000, '预售尾款已支付');
				} else {
					json_return(0, option('config.orderid_prefix') . $order_slave['order_no']);
				}
			}
		}
		
		$store = D('Store')->where(array('store_id' => $order_master['store_id']))->find();
		
		// 验证商品
		$product = D('Product')->where(array('product_id' => $presale['product_id']))->find();
		if (empty($product) || $product['status']) {
			json_return(1004, '商品不在预售范围！');
		}
		
		// 生成订单
		$quantity = $order_product['pro_num'];
		$trade_no = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
		$data_order['store_id'] = $order_master['store_id'];
		$data_order['order_no'] = $data_order['trade_no'] = $trade_no;
		$order_no = $data_order['order_no'];
		$data_order['order_no'] = $data_order['trade_no'] = $order_no;
		$data_order['type'] = 7;	//预售订单
		$data_order['data_id'] = $order_master['data_id'];
		$data_order['presale_order_id'] = $order_master['order_id'];
		$data_order['pro_num'] = $quantity;
		$data_order['pro_count'] = '1';
		$data_order['bak'] = $order_master['bak'];
		$data_order['activity_data'] = $order_master['activity_data'] ? $order_master['activity_data'] : '';
		$data_order['add_time'] = $_SERVER['REQUEST_TIME'];
		$data_order['uid'] = $uid;
		
		// 订单所属团队
		if (!empty($store['drp_team_id'])) {
			if (M('Drp_team')->checkDrpTeam($store['store_id'], true)) {
				$data_order['drp_team_id'] = $store['drp_team_id'];
			}
		}
		
		// 预售订单价格
		$product_price = $order_product['presale_pro_price'] - $presale['dingjin'];
		$data_order['sub_total'] = ($product_price * 100) * $quantity / 100;
		$data_order['order_pay_point'] = 0;
		$data_order['is_point_order'] = 0;
		$data_order['data_money'] = $presale['privileged_cash'];
		
		$order_id = D('Order')->data($data_order)->add();
		$data_order['order_id'] = $order_id;
		
		if (empty($order_id)) {
			json_return(1000, '预售尾款订单产生失败，请重试');
		}
		// 主、丛订单记录尾款订单ID
		D('Order')->data(array('presale_order_id' => $order_id))->where(array('order_id' => array('in', array($order_master['order_id'], $order_id))))->save();
		
		/*计算特权优惠*/
		if ($presale_info['privileged_coupon']) {
			$coupon_info = D('Coupon')->where(array('id' => $presale_info['privileged_coupon']))->find();
			$data_user_coupon = array();
			$data_user_coupon['uid'] = $uid;
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
		
		// 送赠品
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
		$data_order_product['presale_pro_price'] = $order_product['presale_pro_price'];
		$data_order_product['pro_weight'] = $order_product['pro_weight'];
		$data_order_product['product_id'] = $order_product['product_id'];
		$data_order_product['sku_id'] = $order_product['sku_id'];
		$data_order_product['sku_data'] = $order_product['sku_data'];
		$data_order_product['pro_num'] = $order_product['pro_num'];
		$data_order_product['pro_price']  = $product_price;
		$data_order_product['comment'] = $order_product['comment'];
		$data_order_product['is_fx'] = $order_product['is_fx'];
		$data_order_product['supplier_id'] = $order_product['supplier_id'];
		$data_order_product['original_product_id'] = $order_product['original_product_id'];
		
		//平台开启保证金
		if (option('credit.platform_credit_open')) {
			if (!empty($product['open_return_point'])) {
				$data_order_product['return_point'] = !empty($product['return_point']) ? $product['return_point'] : 0;
			} else {
				import('source.class.Margin');
				Margin::init($order_master['store_id']);
				//现金兑积分
				$data_order_product['return_point'] = Margin::convert($product_price, 'point');
			}
		}
		$data_order_product['user_order_id'] = $order_id;
			
		// 产品额外特权
		if (!empty($this->user)) {
			$product_discount = M('Product_discount')->getPointDiscount($product, $uid);
			if (!empty($product_discount['point'])) {
				$data_order_product['point'] = $product_discount['point'];
			}
			if (!empty($product_discount['discount'])) {
				$data_order_product['discount'] = $product_discount['discount'];
			}
		}
		
		// 添加$data_order_product、
		if (D('Order_product')->data($data_order_product)->add()) {
			if (!empty($uid)) {
				M('Store_user_data')->upUserData($order_product['store_id'], $wap_user['uid'], 'unpay');
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
	}
	
	// 支付页面
	public function pay() {
	 $results = array('result'=>'0','data'=>array(),'msg'=>'');
		$uid = $_REQUEST['uid'];
		
		$order_no = $_REQUEST['order_no'];
		if (empty($order_no)) {
		
			$results['result']='1';
			$results['msg']='缺少最基本的参数';
			exit(json_encode($results));
		}
		
		$order = M('Order')->find($order_no);
		if (empty($order)) {
		
			$results['result']='1';
			$results['msg']='该订单不存在';
			exit(json_encode($results));
		}
		
		
		$comment = $_REQUEST['comment'];
		$condition_order=array();
		$condition_order['order_id'] = $order['order_id'];
		if (!empty($comment)) {
		$data_order['comment'] = $comment;
		}
		$data_order['store_id'] = 18;
		$data_order['status'] = 1;
		D('Order')->where($condition_order)->data($data_order)->save();
		if ($order['is_point_order'] == 1) {
			//积分商城
			$tip = "积分订单";
			$is_point_mall = 1;
			$allow_drp = false;	// 不允许分销
		} else {
			$tip = "商品";
			$is_point_mall = 0;
		}
		
		if ($order['status'] > 1) {
			
			$results['result']='1';
			$results['msg']='此订单状态错误';
			exit(json_encode($results));
		}
		
	
		
		$payType=$_REQUEST['type'];
		$payMethodList = M('Config')->get_pay_method();
		
		$user = D('User')->where(array('uid' => $order['uid']))->find();
		switch($payType) {
			//微信支付
			case 'weixin':
					import('source.class.pay.Weixinapp');
					//支付入平台	
					$user = M('User')->getUserById($uid);	
		
					$openid = $user['app_openid'];
				
					$payClass = new Weixinapp($order, $payMethodList[$payType]['config'], $user, $openid);
					$payInfo = $payClass->pay();
				
					if ($payInfo['err_code']) {
						
			        $results['result']='1';
			        $results['msg']=$payInfo['err_msg'];
		            exit(json_encode($results));
					
					} else {
					$results['data']=$payInfo;
		            exit(json_encode($results));
					}
				break;
			case 'alipay':
		
					import('source.class.pay.Alipayapp');
				
					//支付入平台	
					$user = M('User')->getUserById($uid);	
	
					$payClass = new Alipayapp($order, $user);
				
					$payInfo = $payClass->pay();
		
					$results['data']=$payInfo;
		            exit(json_encode($results));
					
				break;
			
			default:
					$return = array('msg'=>'支付类型选择错误','code'=>'5');
					return $return;
				break;
		}
		
	}
	
	// 邮费
	public function postage() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
		$order_no = $_REQUEST['order_no'];
		$address_id = $_REQUEST['address_id'];
		$province_id = $_REQUEST['province_id'];
		
		
		// 判断参数
		if (empty($order_no) || (empty($address_id) && empty($province_id))){
			$results['msg']='缺少基本的参数';
			exit(json_encode($results));
		}
		
		$order = M('Order')->find($order_no);
		if (empty($order)) {
		
			$results['result']='1';
			$results['msg']='该订单不存在';
			exit(json_encode($results));
		}
	
		if (!empty($address_id)) {
			
			$address = D('User_address')->where(array('address_id' => $address_id))->find();
			
			if(empty($address)) {
			
			$results['result']='1';
			$results['msg']='该地址不存在';
			exit(json_encode($results));
			}
		} else if (!empty($province_id)) {
			import('area');
			$areaClass = new area();
			$province_txt = $areaClass->get_name($province_id);
			if (empty($province_txt)) {
			$results['result']='1';
			$results['msg']='该地址不存在';
			exit(json_encode($results));
			}
			$address['province'] = $province_id;
		}
	
	
			//计算运费
			$postage_arr = array();
			$hasTplPostage = false;
			$order_products = array();
			$postage_details = array();
			// 送他人运费计算
			$send_other_postage_arr = array();
			
			// 当前供货商store_id
			$supplier_store_id = 0;
			
			// 有无运费模板
			$has_tpl_postage_arr = array();
			$hast_tpl_postage_arr = array();
			
			$postage_template_model = M('Postage_template');
			foreach ($order['proList'] as $key => $product) {
				if (!empty($product['wholesale_supplier_id']) && !empty($product['wholesale_product_id'])) {
					// 使用供货商的运费模板、库存重量
					$supplier_product = D('Product')->where(array('product_id' => $product['wholesale_product_id']))->find();
					if (!empty($supplier_product)) {
						$product['postage_type'] = $supplier_product['postage_type'];
						$product['postage_template_id'] = $supplier_product['postage_template_id'];
						$product['postage'] = $supplier_product['postage'];
						$product['pro_weight'] = $supplier_product['weight'];
						
						if ($supplier_product['has_property'] && $product['sku_data']) {
							$sku_data_arr = unserialize($product['sku_data']);
							
							$properties = '';
							if (is_array($sku_data_arr)) {
								foreach ($sku_data_arr as $sku_data) {
									$properties .= ';' . $sku_data['pid'] . ':' . $sku_data['vid'];
								}
								$properties = trim($properties, ';');
							}
							
							if (!empty($properties)) {
								$product_sku = D('Product_sku')->where(array('product_id' => $product['wholesale_product_id'], 'properties' => $properties))->find();
								if (!empty($product_sku)) {
									$product['pro_weight'] = $product_sku['weight'];
								}
							}
						}
					}
					$product['supplier_id'] = $product['wholesale_supplier_id'];
				} else {
					$product['supplier_id'] = $product['store_id'];
					$supplier_store_id = $product['store_id'];
				}
				
				if ($product['postage_template_id'] && $product['postage_type'] == '1') {
					$postage_template = $postage_template_model->get_tpl($product['postage_template_id'], $product['supplier_id']);
					
					// 没有相应运费模板，直接跳出
					if (empty($postage_template)) {
						continue;
					}
					
					$has_tpl = false;
					foreach ($postage_template['area_list'] as $area) {
						$has_tpl = false;
						if (in_array($address['province'], explode('&', $area[0]))) {
							if (isset($has_tpl_postage_arr[$product['supplier_id'] . '_' . $product['postage_template_id']])) {
								$has_tpl_postage_arr[$product['supplier_id'] . '_' . $product['postage_template_id']]['weight'] += $product['pro_num'] * $product['pro_weight'];
							} else {
								$has_tpl_postage_arr[$product['supplier_id'] . '_' . $product['postage_template_id']]['weight'] = $product['pro_num'] * $product['pro_weight'];
								$has_tpl_postage_arr[$product['supplier_id'] . '_' . $product['postage_template_id']]['area'] = $area;
							}
							
							$has_tpl = true;
							break;
						}
					}
					
					// 没有相应运费模板，直接跳出
					if (!$has_tpl) {
					
						$results['result']='1';
			           $results['msg']='没有相应运费模板';
			             exit(json_encode($results));
					}
				} else {
					$hast_tpl_postage_arr[$product['supplier_id']] += $product['postage'];
				}
				// 送他人统一运费，不考虑是否支持，不重复计数量
				$send_other_postage_arr[$product['supplier_id']] += $product['send_other_postage'];
			}
			import('source.class.Order');
			$order_data = new Order($order['proList']);
			$order_data->discount();
			$postage_free_list = $order_data->postage_free_list;
			
			$supplier_postage_arr = array();
			$supplier_postage_nofree_arr = array();
			$postageCount = 0;
			foreach ($has_tpl_postage_arr as $key => $postage_detail) {
				list($supplier_id, $tpl_id) = explode('_', $key);
				
				// 计算不免邮费情况下的邮费
				$supplier_postage_nofree_arr[$supplier_id] += $postage_detail['area'][2];
				if ($postage_detail['weight'] > $postage_detail['area']['1'] && $postage_detail['area'][3] > 0 && $postage_detail['area'][4] > 0) {
					$supplier_postage_nofree_arr[$supplier_id] += ceil(($postage_detail['weight'] - $postage_detail['area']['1']) / $postage_detail['area'][3]) * $postage_detail['area']['4'];
				}
				
				if ($postage_free_list[$supplier_id]) {
					continue;
				}
				
				$supplier_postage_arr[$supplier_id] += $postage_detail['area'][2];
				$postageCount += $postage_detail['area'][2];
				if ($postage_detail['weight'] > $postage_detail['area']['1'] && $postage_detail['area'][3] > 0 && $postage_detail['area'][4] > 0) {
					$supplier_postage_arr[$supplier_id] += ceil(($postage_detail['weight'] - $postage_detail['area']['1']) / $postage_detail['area'][3]) * $postage_detail['area']['4'];
					$postageCount += ceil(($postage_detail['weight'] - $postage_detail['area']['1']) / $postage_detail['area'][3]) * $postage_detail['area']['4'];
				}
			}
			
			// 无运费模板运费计算
			foreach ($hast_tpl_postage_arr as $key => $postage) {
				$supplier_postage_nofree_arr[$key] += $postage;
				if ($postage_free_list[$key]) {
					continue;
				}
				$supplier_postage_arr[$key] += $postage;
				$postageCount += $postage;
			}
			
			// 送他人用统一运费重新计算
			if ($pay_type == 'send_other') {
				// 送他人计算邮费，重新计算
				$supplier_postage_arr = array();
				$supplier_postage_nofree_arr = array();
				$postageCount = 0;
				
				foreach ($send_other_postage_arr as $key => $postage) {
					$supplier_postage_nofree_arr[$key] += $postage;
					if ($postage_free_list[$key]) {
						continue;
					}
					
					$supplier_postage_arr[$key] += $postage * $send_other_number;
					$postageCount += $postage * $send_other_number;
				}
			}
			
			$fx_postage = '';
			if (!empty($supplier_postage_arr)) {
				$fx_postage = serialize($supplier_postage_arr);
			}
			
			$session_id=$address['session_id'];
			$address = M('User_address')->getAdressById($session_id, $uid, $address_id);
			$condition_order['order_id'] = $order['order_id'];
			
			
			
			 $data_order['shipping_method'] = 'express';
            $data_order['address_user'] = $address['name'];
            $data_order['address_tel'] = $address['tel'];
            $data_order['address'] = serialize(array(
                    'address' => $address['address'],
                    'province' => $address['province_txt'],
                    'province_code' => $address['province'],
                    'city' => $address['city_txt'],
                    'city_code' => $address['city'],
                    'area' => $address['area_txt'],
                    'area_code' => $address['area'],
            ));
			
			$data_order['postage'] = $postageCount;
			$data_order['total'] = $order['sub_total'] + $postageCount;
			$data_order['fx_postage'] = $fx_postage;
			D('Order')->where($condition_order)->data($data_order)->save();
			$data['postage'] = $postageCount;
			$data['total'] = $order['sub_total'] + $postageCount;
			$data['sale_total'] = $order['sub_total'];
			$results['data']=$data;
			exit(json_encode($results));
		
	}
	
	// 保存订单
	public function save() {
		$user = D('User')->where(array('uid' => $uid))->find();
		
		$_REQUEST['is_app'] = true;
		import('source.class.OrderPay');
		$order_pay = new OrderPay(array('user' => $user, 'is_app' => true));
		$order_pay->pay();
	}
	
	// 订单详情
	public function order_show() {
	 $results = array('result'=>'0','data'=>array(),'msg'=>'');
		$order_no = $_REQUEST['order_no'];
		$uid = $_REQUEST['uid'];
		if (empty($order_no)) {
	
			$results['result']='1';
			$results['msg']='order_no不正确';
			exit(json_encode($results));
		}
		
		$order = M('Order')->find($order_no);
		
		
		if(empty($order) || $order['user_order_id'] > 0 || $order['uid'] != $uid) {
			$results['result']='1';
			$results['msg']='该订单不存在';
			exit(json_encode($results));
		}
		
		$order['address'] = unserialize($order['address']);
		
		
		
		// 物流
		$package_list = array();
		if($order['sent_time']){
			$package_list = M('Order_package')->getPackages(array('user_order_id' => $order['order_id']));
		}
		
		// 查看满减送
		$order_ward_list_tmp = M('Order_reward')->getByOrderId($order['order_id']);
		$order_ward_list = array();
		foreach ($order_ward_list_tmp as $order_ward_list_t) {
			foreach ($order_ward_list_t as $order_ward) {
				$tmp = array('cash' => $order_ward['content']['cash'], 'reward_str' => getRewardStr($order_ward['content']));
				$order_ward_list[] = $tmp;
			}
		}
		
		// 使用优惠券
		$order_coupon_list = M('Order_coupon')->getList($order['order_id']);
		// 查看使用的折扣
		$order_discount_list_tmp = M('Order_discount')->getByOrderId($order['order_id']);
		$order_discount_list = array();
		foreach ($order_discount_list_tmp as $tmp) {
			$order_discount_list[$tmp['store_id']] = $tmp['discount'];
		}
		
		// 查看使用积分
		$order_point = D('Order_point')->where(array('order_id' => $order['order_id']))->find();
		if (empty($order_point)) {
			$order_point = null;
		}
		
		$order_peerpay_list = array();
		if ($order['payment_method'] == 'peerpay') {
			$order_peerpay_list = D('Order_peerpay')->where(array('order_id' => $order['order_id'], 'status' => 1))->select();
		}
		
		$product_list = array();
		foreach ($order['proList'] as $product) {
			$tmp = array();
			$tmp['product_id'] = $product['product_id'];
			$tmp['name'] = $product['name'];
			$tmp['image'] = getAttachmentUrl($product['image']);
			$tmp['is_present'] = $product['is_present'];
			$tmp['sku_data_arr'] = !empty($product['sku_data_arr']) ? $product['sku_data_arr'] : array();
			$tmp['pro_price'] = $product['pro_price'];
			$tmp['pro_num'] = $product['pro_num'];
			$tmp['comment_arr'] = !empty($product['comment_arr']) ? $product['comment_arr'] : array();
				
			$discount = 10;
			if ($product['wholesale_supplier_id']) {
				$discount = $order_discount_list[$product['wholesale_supplier_id']];
			} else {
				$discount = $order_discount_list[$product['store_id']];
			}
				
			if ($product['discount'] > 0 && $product['discount'] <= 10) {
				$discount = $product['discount'];
			}
			
			if ($order['type'] == 7 || $order['type'] == 6) {
				$discount = 10;
			}
			
			if ($discount != 10 && $discount > 0) {
				$discount_money += $product['pro_num'] * $product['pro_price'] * (10 - $discount) / 10;
				$tmp['discount'] = $discount;
				if (empty($product['wholesale_supplier_id'])) {
					$supplier_money += $product['pro_num'] * $product['pro_price'] * $discount / 10;
				}
			} else if (empty($product['wholesale_supplier_id'])) {
				$supplier_money += $product['pro_num'] * $product['pro_price'];
				$tmp['discount'] = 10;
			}
				
			$product_list[] = $tmp;
		}
		unset($order['proList']);
	

	
		

		// 收货地址信息处理
		$address = $order['address'];
		$address['address_user'] = $order['address_user'];
		$address['address_tel'] = $order['address_tel'];
		
		$orders = array();
		$orders['order_no'] = $order['order_no'];
	    $orders['postage'] = $order['postage'];
		$orders['sub_total'] = $order['sub_total'];
		$orders['total'] = $order['total'];
		$orders['sale_total'] = $order['sale_total'];
		$orders['pro_count'] = $order['pro_count'];
		$orders['pro_num'] = $order['pro_num'];
		$orders['status'] = $order['status'];
		$orders['add_time'] = date('Y-m-d H:i:s',$order['add_time']);
		$orders['paid_time'] =$order['paid_time'] ? date('Y-m-d H:i:s',$order['paid_time']) :'';
		$orders['comment'] = $order['comment'];
		
		
		
		$return['package_list'] = $package_list;
		$return['address'] = $address;
		$return['product_list'] = $product_list;
		$return['reward_list'] = $order_ward_list;
		
		
		$data['0']['r']=1;
		$data['0']['data1']=$orders;
		
		$data['1']['r']=2;
		$data['1']['data1']=$package_list ? $package_list :array();
		
		$data['2']['r']=3;
		$data['2']['data1']=!empty($address['address_user']) ? $address :array();
		
		$data['3']['r']=4;
		$data['3']['data1']=$product_list ? $product_list :array();
		
		$data['4']['r']=5;
		$data['4']['data1']=$order_ward_list ? $order_ward_list :array();
		
		$results['data']=$data;

	exit(json_encode($results));

	}
	
	// 确认收货
	public function receive() {
		$order_no = $_REQUEST['order_no'];
		if (empty($order_no)) {
			json_return(1000, '缺少参数');
		}
		
		$order = M('Order')->findSimple($order_no);
		if(empty($order)) {
			json_return(1000, '订单不存在');
		}
		
		if ($order['uid'] != $uid) {
			json_return(1000, '请操作自己的订单');
		}
		
		if ($order['status'] != '3') {
			json_return(1000, '订单状态异常');
		}
		
		$data = array();
		$data['status'] = 7;
		$data['delivery_time'] = time();
		$result = D('Order')->where("order_id = '" . $order['order_id'] . "' OR user_order_id = '" . $order['order_id'] . "'")->data($data)->save();
		
		if ($result) {
			D('Order_product')->where("order_id = '" . $order['order_id'] . "' OR user_order_id = '" . $order['order_id'] . "'")->data(array('in_package_status' => 3))->save();
			json_return(0, '确认收货成功');
		} else {
			json_return(0, '确认收货失败');
		}
	}
	
	// 订单交易完成
	public function complete() {
		import('source.class.Order');
		
		$order_no = trim($_REQUEST['order_no']);
		$order = M('Order')->findSimple($order_no);
		
		if (empty($order) || $order['uid'] != $uid || $order['status'] != 7) {
			json_return(1000, '订单不存在');
		}
		
		$result = Order::complate($order['order_id']);
		if (!empty($result['err_code'])) {
			json_return(1000, $result['err_msg']);
		} else {
			json_return(0, '订单交易完成');
		}
	}
	
	// 用户订单列表
	public function goods_orders() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');

	    $uid = $_REQUEST['uid'];
		$token = $_REQUEST['token'];
		if (empty($uid)) {
		     $results['result']='1';
			$results['msg']='uid不正确';
			exit(json_encode($results));
		}
			
	
		$page = max(1, $_REQUEST['page']);
		$type = $_REQUEST['type'];
		$limit = max(1, $_REQUEST['size']);
		
		$type_arr = array('unpay', 'unsend', 'send', 'complete', 'all');
	
		
		// 搜索条件
		$where = array();
		$where['uid'] = $uid;
		if (!empty($store_id)) {
			$where['store_id'] = $store_id;
		}
		$where['user_order_id']  = 0; //排除分销订单

		switch($type){
			case '1':
				$where['status'] = 1;
				break;
			case '2':
				$where['status'] = 2;
				break;
			case '3':
				$where['status'] = 3;
				break;
			case '4':
				$where['status'] = array('in', array('4', '7'));
				break;
			default:
				$where['status'] =array(array('!=', 5), array('!=', '0'));
		}
		
		// 手工做单debug
		$product_debug = array();
		$product_debug['product_id'] = 0;
		$product_debug['name'] = '手工做单虚拟商品';
		$product_debug['image'] = getAttachmentUrl('images/default_shop.png', true);
		$product_debug['pro_price'] = 0;
		$product_debug['pro_num'] = 1;
		$product_debug['supplier_id'] = 0;
		$product_debug['wholesale_product_id'] = 0;
		$product_debug['debug'] = 1;
		
		$offset = ($page - 1) * $limit;
		$orders_list=array();
		$count = D('Order')->where($where)->count();
	
		$total_pages = ceil($count / $limit);
		$order_list = D('Order')->where($where)->order('order_id desc')->limit($offset . ', ' . $limit)->select();

		$store_physical_list = array();
		$store_list = array();
		$i=0;
		
		foreach ($order_list as &$order) {
			//预售订单处理
			
		
			
			
			if ($order['type'] == 7) {
				$presale_id = $value['data_id'];
				$presale = D('Presale')->where(array('id' => $presale_id))->find();
				
				if ($presale['final_paytime'] < time()) {
					// 过期后不用支付
					$value['show_pay_button'] = 'no';
				} else {
					if ($order['order_id'] != $order['presale_order_id']) {
						if ($order['presale_order_id']) {
							$order_info = D('Order')->where(array('order_id'=>$order['presale_order_id']))->find();
							if ($order_info['status'] > 1) {
								//定金订单 不显示付款
								$order['show_pay_button'] = 'no';
							} else {
								$order['show_pay_button'] = 'yes';
							}
						} else {
							$order['show_pay_button'] = 'yes';
						}
					}  else {
						if ($order['status'] > 1) {
							//定金订单 不显示付款
							$order['show_pay_button'] = 'no';
						} else {
							$order['show_pay_button'] = 'yes';
						}
					}
				}
			}
			
			$order['order_no_txt'] = option('config.orderid_prefix').$order['order_no'];
			if ($order['shipping_method'] == 'selffetch') {
			//	$order['address'] = unserialize($order['address']);
				if ($order['address']['physical_id']) {
					$physical_id = $order['address']['physical_id'];
					if (!isset($store_physical_list[$physical_id])) {
						$store_physical = D('Store_physical')->where(array('pigcms_id' => $order['address']['physical_id']))->find();
						$store_physical_list[$physical_id] = $store_physical['name'];
					}
					
					$order['store_type'] = 1;
					$order['store_name'] = $store_physical_list[$physical_id];
					$order['physical_id'] = $physical_id;
					
				} else if ($order['address']['store_id']) {
					$store_id_tmp = $order['address']['store_id'];
					
					if (!isset($store_list[$store_id_tmp])) {
						$store_tmp = D('Store')->where(array('store_id' => $store_id_tmp))->find();
						$store_list[$store_id_tmp] = $store_tmp['name'];
					}
					
					$order['store_type'] = 2;
					$order['store_name'] = $store_list[$store_id_tmp];
					$order['physical_id'] = $store_id_tmp;
				}
			}
			
			$is_return = false;
			if ($order['status'] == '7') {
				if ($order['delivery_time'] + $config_order_return_date * 24 * 3600 >= time()) {
					$is_return = true;
				}
			} else if ($order['status'] == '3') {
				if ($order['send_time'] + $config_order_complete_date * 24 * 3600 >= time()) {
					$is_return = true;
				}
			} else if ($order['status'] == 2) {
				$is_return = true;
			}
			
			$is_rights = false;
			if (in_array($order['status'], array(2, 3, 4, 7)) && $order['add_time'] + 5 * 24 * 3600 < time()) {
				$is_rights = true;
			}
			
			$order['is_return'] = $is_return;
			$order['is_rights'] = $is_rights;
			$order['order_product_list'] = M('Order_product')->orderProduct($order['order_id']);
		
		
		
			if ($order['is_offline'] && empty($order['order_product_list'])) {
				$product_debug['pro_price'] = $order['sub_total'];
				$order['order_product_list'][] = $product_debug;
			}
				
			foreach ($order['order_product_list'] as $key=>$order_product_list)
			   {
					$product_list[$key]['product_id']=$order_product_list['product_id'];
					$product_list[$key]['name']=$order_product_list['name'];
					$product_list[$key]['image']=$order_product_list['image'];
					$product_list[$key]['pro_num']=$order_product_list['pro_num'];
					$product_list[$key]['pro_price']=$order_product_list['pro_price'];
				
			   }	
				
			//退货
			$order['returning'] = false;
			if (D('Return')->where(array('order_id' => $order['order_id'], 'status' => array('!=', 5)))->count('id')) {
				$order['returning'] = true;
			}
				$stores = D('Store')->where("store_id = '$order[store_id]'")->find();
			
			//$order['store_name'] =$stores['name'];
	    	//$order['address'] =	unserialize($order['address']);
			$orders_list[$i]['order_id']=$order['order_id'];
			$orders_list[$i]['store_name']=$stores['name'];
			$orders_list[$i]['order_no']=$order['order_no'];
			$orders_list[$i]['trade_no']=$order['trade_no'];
			$orders_list[$i]['postage']=$order['postage'];
			$orders_list[$i]['sub_total']=$order['sub_total'];
			$orders_list[$i]['total']=$order['total'];
			$orders_list[$i]['pro_count']=$order['pro_count'];
			$orders_list[$i]['pro_num']=$order['pro_num'];
			$orders_list[$i]['address_user']=$order['address_user'];
			$orders_list[$i]['address_tel']=$order['address_tel'];
			$orders_list[$i]['payment_method']=$order['payment_method'];
			$orders_list[$i]['shipping_method']=$order['shipping_method'];
			$orders_list[$i]['data_id']=$order['data_id'];
			$orders_list[$i]['data_money']=$order['data_money'];
			$orders_list[$i]['status']=$order['status'];
			$orders_list[$i]['add_time']=$order['add_time'];
			$orders_list[$i]['paid_time']=$order['paid_time'];
			$orders_list[$i]['cancel_method']=$order['cancel_method'];
			$orders_list[$i]['pay_money']=$order['pay_money'];
			$orders_list[$i]['type']=$order['type'];
			$orders_list[$i]['order_product_list']=$product_list;
			$orders_list[$i]['order_no']=$order['order_no'];
		
			$i++;
		}
	
			$results['data']=$orders_list;
			
			$page_info['page_count'] =  (string)$total_pages;;
	        $page_info['page_index'] =  (string)$page;
        	$results['page_info'] =  $page_info;
	
			exit(json_encode($results));
	}
	
	
	// 店铺订单列表
	public function yuyue_orders() {
		
		$results = array('result'=>'0','data'=>array(),'msg'=>'');

	    $uid = $_REQUEST['uid'];
		if (empty($uid)) {
		     $results['result']='1';
			$results['msg']='uid不正确';
			exit(json_encode($results));
		}
		$token = $_REQUEST['token'];
		$tokens = D('Users_token')->where(array('uid' => $uid))->find();
		
		if ($token!=$tokens['token']) {
		     $results['result']='1';
			$results['msg']='token不正确';
			exit(json_encode($results));
		}
		
		$store_id = $_REQUEST['store_id'];
		$page = max(1, $_REQUEST['page']);
		$type = $_REQUEST['type'];
		$limit = max(1, $_REQUEST['size']);
		
		$where = array();
    	$where['uid'] = $uid;
		if (!empty($store_id)) {
		 $where['store_uid'] = $store_id;
		}
		switch($type){
		case '1':
	
			$where['status'] = 1;
			break;
		case '2':
	
			$where['status'] = 2;
			break;
    	case '3':
		
			$where['status'] = 3;
			break;
		case '4':
			
			$where['status'] = 4;
			break;
		default:
			$where['status'] = array('<', 5);
			
	   }
		
		$count = D('Meal_order')->where($where)->count('order_id');
	$total_pages = ceil($count / $limit);
	$orderList = array();

	if ($count > 0) {

		$offset = ($page - 1) * $limit;
		
		$orderList = D('Meal_order')->where($where)->order('order_id desc')->limit($offset . ', ' . $limit)->select();

			
			 foreach ($orderList as $key => $value)
        {
         	

		   $physical =  D('Store_physical')->where(array('pigcms_id'=>$value['physical_id']))->find();
		   $orderList[$key]['store_name'] = $physical['name'];
		   $orderList[$key]['images'] = getAttachmentUrl($physical['images']);
		   if(empty($value['use_time'])){
		   $orderList[$key]['use_time']='';
		   }else{
		   $orderList[$key]['use_time']=date('Y-m-d H:i:s',$value['use_time']);
		   }
		   if(empty($value['dateline'])){
		   $orderList[$key]['dateline']='';
		   }else{
		   $orderList[$key]['dateline']=date('Y-m-d H:i:s',$value['dateline']);
		   }
		   $orderList[$key]['dd_time']=date('Y-m-d H:i',$value['dd_time']);
		   if(empty($value['food'])){
		   $orderList[$key]['food']='';
		   }
		   if(empty($value['num'])){
		   $orderList[$key]['num']='';
		   } 
		    if(empty($value['bz'])){
		   $orderList[$key]['bz']='';
		   } 
		   unset($orderList[$key]['uid']);
		    unset($orderList[$key]['physical_id']);
			unset($orderList[$key]['edittime']);
			unset($orderList[$key]['sms']);
        }

		
	}
	    $return['next_page'] = '1';
		if (count($orderList) < $limit) {
			$return['next_page'] = '0';
		}
		
		$results['data']=$orderList;
		$page_info['page_count'] =  (string)$total_pages;;
	        $page_info['page_index'] =  (string)$page;
        	$results['page_info'] =  $page_info;
		exit(json_encode($results));
	}
	
	
	
	
	
	public function baoming_orders() {
		
		$results = array('result'=>'0','data'=>array(),'msg'=>'');

	    $uid = $_REQUEST['uid'];
		if (empty($uid)) {
		     $results['result']='1';
			$results['msg']='uid不正确';
			exit(json_encode($results));
		}
		$token = $_REQUEST['token'];
		$tokens = D('Users_token')->where(array('uid' => $uid))->find();
		
		if ($token!=$tokens['token']) {
		     $results['result']='1';
			$results['msg']='token不正确';
			exit(json_encode($results));
		}
		
		$store_id = $_REQUEST['store_id'];
		$page = max(1, $_REQUEST['page']);
		$type = $_REQUEST['type'];
		$limit = max(1, $_REQUEST['size']);
		
		$where = array();
    	$where['uid'] = $uid;
		if (!empty($store_id)) {
		 $where['store_id'] = $store_id;
		}
		switch($type){
		case '1':
		
			$where['status'] = 1;
			break;
		case '2':
		
			$where['status'] = 2;
			break;
    	case '3':
			
			$where['status'] = 3;
			break;
		default:
			$where['status'] = array('<', 4);
			
	   }
		
	$count = D('Chahui_bm')->where($where)->count('id');
	$total_pages = ceil($count / $limit);
	$orderList = array();

	if ($count > 0) {

		$offset = ($page - 1) * $limit;
		
		$orderList = D('Chahui_bm')->where($where)->order('id desc')->limit($offset . ', ' . $limit)->select();

			
			 foreach ($orderList as $key => $value)
        {
	
		    $chahui = D('Chahui')->where(array('pigcms_id'=>$value['cid']))->find();
            $orderList[$key]['ch_name'] = $chahui['name'];
			$orderList[$key]['images'] = getAttachmentUrl($chahui['images']);
			$orderList[$key]['address'] = $chahui['address'];
			$orderList[$key]['sttime']=date('m/d H:i',$chahui['sttime']);
			$orderList[$key]['endtime']=date('m/d H:i',$chahui['endtime']);
			$store = D('Store')->where(array('store_id'=>$chahui['store_id']))->find();
			$orderList[$key]['store_name'] = $store['name'];
			$orderList[$key]['addtime']=date('Y-m-d H:i:s',$value['addtime']);
			 unset($orderList[$key]['uid']);
		    unset($orderList[$key]['physical_id']);
        }
	

	}
		

		$return['next_page'] = '1';
		if (count($orderList) < $limit) {
			$return['next_page'] = '0';
		}
		
		$results['data']=$orderList;
		$page_info['page_count'] =  (string)$total_pages;;
	        $page_info['page_index'] =  (string)$page;
        	$results['page_info'] =  $page_info;
		exit(json_encode($results));
		
	}
	
	
	
	
	
public function baoming_show() {
		
		$results = array('result'=>'0','data'=>array(),'msg'=>'');

	    $uid = $_REQUEST['uid'];
		if (empty($uid)) {
		     $results['result']='1';
			$results['msg']='uid不正确';
			exit(json_encode($results));
		}
		$token = $_REQUEST['token'];
		$tokens = D('Users_token')->where(array('uid' => $uid))->find();
		
		if ($token!=$tokens['token']) {
		     $results['result']='1';
			$results['msg']='token不正确';
			//exit(json_encode($results));
		}
		
		$id = $_REQUEST['id'];
	
		$where = array();
    	$where['id'] = $id;
	
		
		
        	$value = D('Chahui_bm')->where($where)->find();
			$cid = $value['cid'];
	        $chahui = D('Chahui')->where(array('pigcms_id'=>$cid))->find();
	        $store = D('Store_physical')->where(array('pigcms_id'=>$chahui['physical_id']))->find();
		    $orderList['id'] = $value['id'];
			$orderList['cid'] = $cid;
            $orderList['ch_name'] = $chahui['name'];
			$orderList['images'] = getAttachmentUrl($chahui['images']);
			$orderList['store_name'] = $store['name'];
			$orderList['address'] = $chahui['address'];
			$orderList['sttime']=date('m/d H:i',$chahui['sttime']);
			$orderList['endtime']=date('m/d H:i',$chahui['endtime']);
			$orderList['status'] = $value['status'];
		
			$orderList['name']=$value['name'];
		    $orderList['mobile']=$value['mobile'];
            $orderList['addtime']=date('Y-m-d H:i:s',$value['addtime']);
		
		$results['data']=$orderList;
	
		exit(json_encode($results));
		
	}	
	
	
	
	
	// 店铺订单列表
	public function store_all() {
		
	}
	
	// 退货申请
	public function return_apply() {
		$order_no = $_REQUEST['order_no'];
		$pigcms_id = $_REQUEST['pigcms_id'];
		
		if (empty($order_no) || empty($pigcms_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		// 只能查看自己的订单
		$order_model = M('Order');
		$order = $order_model->find($order_no);
		
		if (empty($order)) {
			json_return(1000, '未找到相应的订单');
		}
		
		if ($order['uid'] != $uid) {
			json_return(1000, '您无权查看此订单');
		}
		
		if (($order['status'] != 7 && $order['status'] != 2) || $order['is_offline'] == 1) {
			json_return(1000, '此订单状态不能退货');
		}
		
		$order_product = D('')->table('Order_product AS op')->join('Product AS p ON p.product_id = op.product_id', 'left')->field('p.name, op.pro_price, return_status')->where("op.pigcms_id = '" . $pigcms_id . "'")->find();
		
		if (empty($order_product)) {
			json_return(1000, '未找到要退货的产品');
		}
		
		if ($order_product['return_status'] == 2) {
			json_encode(array('status' => false, 'msg' => '此产品已经申请退货了'));
		}
		
		$order_product['order_no_txt'] = option('config.orderid_prefix') . $order['order_no'];
		
		$type_arr = M('Return')->returnType();
		
		// 根据退货数量，判断是否可以退货
		$return_number = M('Return_product')->returnNumber($order['order_id'], $pigcms_id);
		
		$return = array();
		$return['order_product'] = $order_product;
		$return['type_arr'] = $type_arr;
		$return['return_number'] = $return_number;
		
		json_return(0, $return);
	}
	
	// 维权保存
	public function return_save() {
		
	}
	
	public function cancel() {
		$results = array('result'=>'0','data'=>array(),'msg'=>'');
		$uid = $_REQUEST['uid'];
		if (empty($uid)) {
		     $results['result']='1';
			$results['msg']='uid不正确';
			exit(json_encode($results));
		}
		$token = $_REQUEST['token'];
		$dataid = $_REQUEST['dataid'];
		$type = intval($_REQUEST['type']);
				
		if (empty($dataid)) {
			
			$results['result']='1';
			$results['msg']='缺少最基本的参数';
			exit(json_encode($results));
		}
		
		if (!in_array($type, array(1, 2, 3))) {
		
			$results['result']='1';
			$results['msg']='类型错误';
			exit(json_encode($results));
		}
		
		if ($type == 1) {
		
		  $condition_order=array();
		  $condition_order['order_id'] = intval($dataid);
	      $condition_order['uid'] = $uid;
	      $condition_order['status'] = array('<','2');
	      $database_order = D('Order');
	      $nowOrder = $database_order->where($condition_order)->find();
				
			if(empty($nowOrder)) {
		    $results['result']='1';
			$results['msg']='该订单不存在或已关闭';
			exit(json_encode($results));
			}
			
			if(M('Order')->cancelOrder($nowOrder, 2)){
				if($nowOrder['status'] == 1 && !empty($uid)) {
					M('Store_user_data')->editUserData($nowOrder['store_id'],$uid,'unpay','');
				}
			
			$results['msg']='关闭订单成功';
			exit(json_encode($results));
			}else{
			
			$results['result']='1';
			$results['msg']='关闭订单失败';
			exit(json_encode($results));
			}

		} elseif ($type == 2) {
		
	$condition_order['order_id'] = intval($dataid);
	$condition_order['uid'] = $uid;
	$condition_order['status'] = array('<','2');
	$database_order = D('Meal_order');
	$nowOrder = $database_order->field('`order_id`,`orderid`,`store_uid`,`status`')->where($condition_order)->find();

	if(empty($nowOrder)){
	$results['result']='1';
	$results['msg']='该订单不存在或已关闭';
	exit(json_encode($results));
	}
	$condition_save_order['order_id'] = $nowOrder['order_id'];
	$data_save_order['status'] = '4';
	$data_save_order['use_time'] = $_SERVER['REQUEST_TIME'];
	if($database_order->where($condition_save_order)->data($data_save_order)->save()){
			$results['msg']='关闭订单成功';
			exit(json_encode($results));
	}else{
	        $results['result']='1';
			$results['msg']='关闭订单失败';
			exit(json_encode($results));
	}
		} elseif ($type == 3) {
		
	$condition_order['id'] = intval($dataid);
	$condition_order['uid'] = $uid;
	$condition_order['status'] = array('<','2');
	$database_order = D('Chahui_bm');
	$nowOrder = $database_order->field('`id`,`store_id`,`uid`,`status`')->where($condition_order)->find();
	if(empty($nowOrder)){
	$results['result']='1';
	$results['msg']='该订单不存在或已关闭';
	exit(json_encode($results));
	}
	$condition_save_order['id'] = $nowOrder['id'];
	$data_save_order['status'] = '4';
	$data_save_order['use_time'] = $_SERVER['REQUEST_TIME'];
	if($database_order->where($condition_save_order)->data($data_save_order)->save()){
			$results['msg']='关闭订单成功';
			exit(json_encode($results));
	}else{
	        $results['result']='1';
			$results['msg']='关闭订单失败';
			exit(json_encode($results));
	}
		}
		
		
	}
}
