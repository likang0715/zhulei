<?php
/**
 * 购物车控制器
 */
class cart_controller extends base_controller{
	// 购物车列表，单店铺显示
	public function cart_list() {
		$store_id = $_REQUEST['store_id'];
		
		if (empty($store_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		//店铺资料
		$store = M('Store')->getStore($store_id, true);
		if(empty($store)) {
			json_return(1000, '您访问的店铺不存在');
		}
		
		// 是否关注过公众号
		$where = array();
		$where['uid'] = $this->user['uid'];
		$where['store_id'] = $store_id;
		$where['subscribe_time'] = array('>', 0);
		$subscribe_store = D('Subscribe_store')->where($where)->find();
		
		if($store['is_point_mall'] == 1) {
			//积分商城
			$tip = "积分商品";
			$is_point_mall = 1;
			$allow_drp = false;	//不允许分销
		} else {
			$tip = "商品";
			$is_point_mall = 0;
		}
		
		$where = "`uc`.`store_id`='" . $store_id . "' AND `uc`.`product_id`=`p`.`product_id` AND `uc`.`uid`='" . $this->user['uid']."'";
		$cart_list = D('')->field('`uc`.`pigcms_id`,`uc`.`product_id`,`uc`.`pro_num`,`uc`.`pro_price`,`uc`.`sku_id`,`uc`.`sku_data`, `uc`.`store_id`, `p`.`name`,`p`.`image`,`p`.`quantity`,`p`.`status`,`p`.`buyer_quota`, `p`.`price`, `p`.`after_subscribe_discount`, `p`.`after_subscribe_price`,`p`.`drp_level_1_price`, `p`.`drp_level_2_price`, `p`.`drp_level_3_price`, `p`.`has_property`, `p`.`is_fx`')->table(array('User_cart'=>'uc','Product'=>'p'))->where($where)->order('`pigcms_id` DESC')->select();
		
		$database_product_sku = D('Product_sku');
		foreach ($cart_list as $key => $value) {
			//限购
			if (!empty($value['buyer_quota'])) {
				$uid = $this->user['uid'];
				$cart_list[$key]['buy_quantity'] = M('Order_product')->getBuyNumber($uid, $value['product_id'], 'uid');
			} else {
				$cart_list[$key]['buy_quantity'] = 0;
			}
			
			$cart_list[$key]['sku_num'] = 0;
			
			$product_sku = array();
			if ($value['has_property']) {
				//有商品属性
				$sku_data_arr = unserialize($value['sku_data']);
				$properties_arr = array();
				if (is_array($sku_data_arr)) {
					foreach ($sku_data_arr as $sku_data) {
						$properties_arr[] = $sku_data['pid'] . ':' . $sku_data['vid'];
					}
				}
				
				$cart_list[$key]['sku_data'] = $sku_data_arr;
				$properties = join(';', $properties_arr);
				// 库存信息没有时，直接删除购物车表里相应的信息
				if (empty($properties)) {
					D('User_cart')->where(array('pigcms_id' => $value['pigcms_id']))->delete();
					unset($cart_list[$key]);
					continue;
				}
				
				$product_sku = $database_product_sku->where(array('properties' => $properties, 'product_id' => $value['product_id']))->find();
				if (empty($product_sku)) {
					D('User_cart')->where(array('pigcms_id' => $value['pigcms_id']))->delete();
					unset($cart_list[$key]);
					continue;
				}
				
				$cart_list[$key]['sku_id'] = $product_sku['sku_id'];
				if ($store['drp_level'] > 0 && $value['is_fx']) {
					$cart_list[$key]['pro_price'] = $store['drp_level'] <= 3 ? $product_sku['drp_level_' . $store['drp_level'] . '_price'] : $product_sku['drp_level_3_price'];
					
					if (!empty($subscribe_store) && $value['after_subscribe_discount'] > 0 && $value['after_subscribe_discount'] < 10) {
						$cart_list[$key]['pro_price'] = $cart_list[$key]['pro_price'] * $value['after_subscribe_discount'] / 10;
					}
				} else {
					if(!empty($subscribe_store) && $value['after_subscribe_discount'] > 0 && $value['after_subscribe_discount'] < 10){
						$cart_list[$key]['pro_price'] = $product_sku['price'] * $value['after_subscribe_discount'] / 10;
					}else{
						$cart_list[$key]['pro_price'] = $product_sku['price'];
					}
				}
				
			} else {
				// 无商品属性
				$cart_list[$key]['sku_id'] = 0;
				$cart_list[$key]['sku_data'] = array();
					
				if ($store['drp_level'] > 0 && $value['is_fx']) {
					$cart_list[$key]['pro_price'] = $store['drp_level'] <= 3 ? $value['drp_level_' . $store['drp_level'] . '_price'] : $value['drp_level_3_price'];
					
					if (!empty($subscribe_store) && $value['after_subscribe_discount'] > 0 && $value['after_subscribe_discount'] < 10) {
						$cart_list[$key]['pro_price'] = $cart_list[$key]['pro_price'] * $value['after_subscribe_discount'] / 10;
					}
				} else {
					// 关注价格
					if (!empty($subscribe_store) && $value['after_subscribe_discount'] > 0 && $value['after_subscribe_discount'] < 10) {
						$cart_list[$key]['pro_price'] = $value['price'] * $value['after_subscribe_discount'] / 10;
					} else {
						$cart_list[$key]['pro_price'] = $value['price'];
					}
				}
			}
			
			if ($value['sku_id'] && $value['quantity'] && $value['status'] == 1) {
				$cart_list[$key]['sku_num'] = $product_sku['quantity'];
			} else if($value['quantity']) {
				$cart_list[$key]['sku_num'] = $value['quantity'];
			}
			$cart_list[$key]['image'] = getAttachmentUrl($value['image']);
		}
		
		$return = array();
		$return['store_name'] = $store['name'];
		$return['cart_list'] = $cart_list;
		
		json_return(0, $return);
	}
	
	// 购物车是否有产品
	public function number() {
		$store_id = $_REQUEST['store_id'];
		
		if (empty($store_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		$count = D('User_cart')->where(array('store_id' => $store_id, 'uid' => $this->user['uid']))->count('pigcms_id');
		json_return(0, $count ? 1 : 2);
	}
	
	// 更改购物车数量
	public function quantity() {
		$pigcms_id = $_REQUEST['cart_id'];
		$sku_id = $_REQUEST['sku_id'];
		$product_id = $_REQUEST['product_id'];
		$number = max(1, $_REQUEST['number']);
		
		if (empty($pigcms_id) || (empty($sku_id) && empty($product_id))) {
			json_return(1000, '缺少最基本的参数');
		}
		
		$user_cart = D('User_cart')->where(array('pigcms_id' => $pigcms_id, 'uid' => $this->user['uid']))->find();
		if (empty($user_cart)) {
			json_return(1000, '未找到相应的记录');
		}
		
		if (!empty($sku_id)) {
			$condition_product_sku['sku_id'] = $sku_id;
			$condition_product_sku['product_id'] = $user_cart['product_id'];
			
			$product_sku = D('Product_sku')->field('`quantity`')->where($condition_product_sku)->find();
			if (empty($product_sku)) {
				json_return(1000, '未找到相应的库存');
			}
			
			if ($number > $product_sku['quantity']) {
				json_return(1000, '库存不足');
			}
			
			$quantity = $product_sku['quantity'];
		} else if (!empty($product_id)) {
			if ($product_id != $user_cart['product_id']) {
				json_return(1000, '数据异常');
			}
			
			$condition_product['product_id'] = $product_id;
			$product = D('Product')->field('`quantity`')->where($condition_product)->find();
			
			if (empty($product)) {
				json_return(1000, '未找到相应的产品');
			}
			
			if ($product['has_property']) {
				json_return(1000, '数据异常');
			}
			
			if ($number > $product['quantity']) {
				json_return(1000, '库存不足');
			}
			
			$quantity = $product['quantity'];
		}
		
		$data_user_cart['pro_num'] = min($number, $quantity);
		if (D('User_cart')->where(array('pigcms_id' => $pigcms_id))->data($data_user_cart)->save()) {
			json_return(0, '操作成功');
		} else {
			json_return(1000, '操作失败');
		}
	}
	
	// 删除购物车
	public function delete() {
		$pigcms_id_arr = $_REQUEST['cart_id'];
		$store_id = $_REQUEST['store_id'];
		error_log($pigcms_id_arr);
		error_log(json_encode($pigcms_id_arr));
		if (empty($pigcms_id_arr)) {
			json_return(1000, '请勾选一些内容');
		}
		
		if (empty($store_id)) {
			json_return(1000, '缺少参数');
		}
		
		$where = array();
		$where['pigcms_id'] = array('in', $pigcms_id_arr);
		$where['store_id'] = $store_id;
		$where['uid'] = $this->user['uid'];
		if (D('User_cart')->where($where)->delete()) {
			json_return(0, '删除成功');
		} else {
			json_return(1000, '删除失败，请重试');
		}
	}
	
	// 购物车支付
	public function pay() {
		$store_id = $_POST['store_id'];
		$pigcms_id_arr = $_POST['cart_id'];
		
		if(empty($pigcms_id_arr)){
			json_return(1000, '请勾选一些内容');
		}
		
		if (empty($store_id)) {
			json_return(1000, '缺少参数');
		}
		
		/* 是否关注过公众号 */
		$where = array();
		$where['uid'] = $this->user['uid'];
		$where['store_id'] = $store_id;
		$where['subscribe_time'] = array('>', 0);
		$subscribe_store = D('Subscribe_store')->where($where)->find();
		
		
		$store = M('Store')->getStore($store_id);
		if(empty($store)) {
			json_return(1000, '未找到相应的店铺');
		}
		
		// 用户信息
		$cart_where = "`uc`.`product_id`=`p`.`product_id` AND `uc`.`uid`='" . $this->user['uid'] . "' AND `uc`.`store_id`='" . $store_id . "'";
		
		// 定义初始值
		$cart_list = array();
		$pro_num = $pro_count = $pro_money = 0;
		
		foreach($pigcms_id_arr as $value){
			$user_cart = D('')->field('`uc`.*,`p`.`name`, `p`.`buyer_quota`,`p`.`quantity`,`p`.`status`, `p`.`weight`, `p`.`price`, `p`.`after_subscribe_discount`, `p`.`after_subscribe_price`, `p`.`drp_level_1_price`, `p`.`drp_level_2_price`, `p`.`drp_level_3_price`, `p`.`has_property`, `p`.`is_fx`')->table(array('User_cart' => 'uc', 'Product' => 'p'))->where($cart_where . " AND `uc`.`pigcms_id`='" . $value . "'")->find();
			
			if (empty($user_cart)) {
				json_return(1000, '您选中的商品已下架');
			}
			
			// 限购
			if ($user_cart['buyer_quota']) {
				$buy_quantity = 0;
				$user_type = 'uid';
				$uid = $this->user['uid'];
				// 查找购物车里相同产品的数量
				$user_cart_sum = D('User_cart')->where(array('uid' => $uid, 'product_id' => $user_cart['product_id']))->field('sum(pro_num) AS number')->find();
				$buy_quantity += $user_cart_sum['number'] + 0;
					
				$buy_quantity += M('Order_product')->getBuyNumber($uid, $user_cart['product_id'], $user_type);
				if ($buy_quantity > $user_cart['buyer_quota']) { //限购
					json_return(1000, $user_cart['name'] . '商品限购，请修改购买数量');
				}
			}
			
			//检测库存和同步产品价格
			if(!empty($user_cart['has_property'])){
				// 有商品规格
				$sku_data_arr = unserialize($user_cart['sku_data']);
				$properties_arr = array();
				if (is_array($sku_data_arr)) {
					foreach ($sku_data_arr as $sku_data) {
						$properties_arr[] = $sku_data['pid'] . ':' . $sku_data['vid'];
					}
				}
				
				$properties = join(';', $properties_arr);
				// 库存信息没有时，直接删除购物车表里相应的信息
				if (empty($properties)) {
					json_return(1000, $user_cart['name'] . '商品已过期');
				}
				
				$product_sku = D('Product_sku')->where(array('properties' => $properties, 'product_id' => $user_cart['product_id']))->find();
				if (empty($product_sku)) {
					json_return(1000, $user_cart['name'] . '商品已过期');
				}
				
				if ($store['drp_level'] > 0 && $user_cart['is_fx']) {
					$user_cart['pro_price'] = $store['drp_level'] <= 3 ? $product_sku['drp_level_' . $store['drp_level'] . '_price'] : $product_sku['drp_level_3_price'];
					
					if (!empty($subscribe_store) && $user_cart['after_subscribe_discount'] > 1 && $user_cart['after_subscribe_discount'] < 10) {
						$user_cart['pro_price'] = $user_cart['pro_price'] * $user_cart['after_subscribe_discount'] / 10;
					}
				} else {
					if(!empty($subscribe_store) && $user_cart['after_subscribe_discount'] > 1 && $user_cart['after_subscribe_discount'] < 10){
						$user_cart['pro_price'] = $product_sku['price'] * $user_cart['after_subscribe_discount'] / 10;
					}else{
						$user_cart['pro_price'] = $product_sku['price'];
					}
				}
				
				$quantity = $product_sku['quantity'];
				if (!empty($product_sku['weight'])) {
					$user_cart['weight'] = $product_sku['weight'];
				}
			}else{
				// 无商品规格
				if ($store['drp_level'] > 0 && $user_cart['is_fx']) {
					$user_cart['pro_price'] = $store['drp_level'] <= 3 ? $user_cart['drp_level_' . $store['drp_level'] . '_price'] : $user_cart['drp_level_3_price'];
					if (!empty($subscribe_store) && $user_cart['after_subscribe_discount'] > 1 && $user_cart['after_subscribe_discount'] < 10) {
						$user_cart['pro_price'] = $user_cart['pro_price'] * $user_cart['after_subscribe_discount'] / 10;
					}
				} else {
					if(!empty($subscribe_store) && $user_cart['after_subscribe_discount'] > 1 && $user_cart['after_subscribe_discount'] < 10){
						$user_cart['pro_price'] = $user_cart['price'] * $user_cart['after_subscribe_discount'] / 10;
					}else{
						$user_cart['pro_price'] = $user_cart['price'];
					}
				}
				$quantity = $user_cart['quantity'];
				$user_cart['sku_id'] = 0;
				$user_cart['sku_data'] = '';
			}
			
			if($quantity < $user_cart['pro_num']){
				json_return(1000, '您选中的商品库存不足');
			}
			
			$cart_list[] = $user_cart;
			$pro_num += $user_cart['pro_num'];
			$pro_money += $user_cart['pro_price'] * 100 * $user_cart['pro_num'] / 100;
			$pro_count++;
		}
		
		$order_no = date('YmdHis',$_SERVER['REQUEST_TIME']) . mt_rand(100000,999999);
		$data_order['store_id'] = $store_id;
		$data_order['order_no'] = $order_no;
		$data_order['trade_no'] = $order_no;
		$data_order['uid'] = $this->user['uid'];
		$data_order['pro_num'] = $pro_num;
		$data_order['pro_count'] = $pro_count;
		$data_order['add_time'] = $_SERVER['REQUEST_TIME'];
		if($store['is_point_mall'] == '1') {
			//积分订单
			$data_order['is_point_order'] = 1;
			$data_order['sub_total'] =  0;
			$data_order['order_pay_point'] = $pro_money;
		} else {
			$data_order['is_point_order'] = 0;
			$data_order['sub_total'] = $pro_money;
			$data_order['order_pay_point'] = 0;
		}
		
		//订单所属团队
		if (!empty($store['drp_team_id'])) {
			if (M('Drp_team')->checkDrpTeam($store['store_id'], true)) {
				$data_order['drp_team_id'] = $store['drp_team_id'];
			}
		}
		
		$order_id = D('Order')->data($data_order)->add();
		
		if(empty($order_id)){
			json_return(1000, '订单产生失败，请重试');
		}
		
		$order = array_merge($data_order, array('order_id' => $order_id));
		M('Store_user_data')->upUserData($store_id, $this->user['uid'], 'unpay');
		
		$database_order_product = D('Order_product');
		$database_product = D('Product');
		$data_order_product['order_id'] = $order_id;
		
		$suppliers = array();
		$first_product_name = '';
		foreach($cart_list as $value){
			$product_info = $database_product->field('is_fx,product_id,store_id,original_product_id,supplier_id,wholesale_product_id,name, check_give_points, check_degree_discount, give_points, open_return_point, return_point')->where(array('product_id' => $value['product_id']))->find();
			if (empty($first_product_name)) {
				$first_product_name = msubstr($product_info[name], 0, 11);
			}
			if ($product_info['store_id'] != $store['store_id'] && empty($product_info['supplier_id'])) {
				$type = 3; //分销
			}
			if ($product_info['store_id'] == $store['store_id'] && empty($product_info['supplier_id'])) { //店铺自营商品
				$supplier_id = 0;
				$original_product_id = 0;
				$data_order_product['is_fx'] = 0;
				$data_order_product['supplier_id'] = $supplier_id;
				$data_order_product['original_product_id'] = $original_product_id;
			} else if ($product_info['store_id'] == $store['store_id'] && !empty($product_info['wholesale_product_id'])) { //店铺批发商品
				$supplier_id = $product_info['supplier_id'];
				$suppliers[] = $supplier_id;
				$original_product_id = $product_info['wholesale_product_id'];
				$data_order_product['is_fx'] = 0;
				$data_order_product['supplier_id'] = $supplier_id;
				$data_order_product['original_product_id'] = $original_product_id;
			} else if ($product_info['store_id'] != $store['store_id'] && !empty($product_info['is_fx']) && empty($product_info['wholesale_product_id'])) { //分销供货商自营商品
				$supplier_id = $product_info['store_id'];
				$suppliers[] = $supplier_id;
				$original_product_id = $product_info['product_id'];
				$data_order_product['is_fx'] = 1;
				$data_order_product['supplier_id'] = $store['drp_supplier_id'];
				$data_order_product['original_product_id'] = $original_product_id;
			} else if ($product_info['store_id'] != $store['store_id'] && !empty($product_info['is_fx']) && !empty($product_info['wholesale_product_id'])) { //分销供货商批发商品
				$supplier_id = $product_info['supplier_id'];
				$suppliers[] = $supplier_id;
				$original_product_id = $product_info['wholesale_product_id'];
				$data_order_product['is_fx'] = 1;
				$data_order_product['supplier_id'] = $store['drp_supplier_id'];
				$data_order_product['original_product_id'] = $original_product_id;
			} else if ($product_info['store_id'] != $store['store_id'] && empty($product_info['is_fx']) && empty($product_info['wholesale_product_id'])) { //分销供货商未设置分销的自营商品
				$supplier_id = $product_info['store_id'];
				$suppliers[] = $supplier_id;
				$original_product_id = $product_info['product_id'];
				$data_order_product['is_fx'] = 1;
				$data_order_product['supplier_id'] = $store['drp_supplier_id'];
				$data_order_product['original_product_id'] = $original_product_id;
			} else if ($product_info['store_id'] != $store['store_id'] && empty($product_info['is_fx']) && !empty($product_info['wholesale_product_id'])) { //分销供货商未设置分销的批发商品
				$supplier_id = $product_info['supplier_id'];
				$suppliers[] = $supplier_id;
				$original_product_id = $product_info['wholesale_product_id'];
				$data_order_product['is_fx'] = 1;
				$data_order_product['supplier_id'] = $store['drp_supplier_id'];
				$data_order_product['original_product_id'] = $original_product_id;
			}
			$data_order_product['product_id'] = $value['product_id'];
			$data_order_product['sku_id'] = $value['sku_id'];
			$data_order_product['sku_data'] = $value['sku_data'];
			$data_order_product['pro_num'] = $value['pro_num'];
			$data_order_product['pro_price']  = $value['pro_price'];
			$data_order_product['comment'] = $value['comment'];
			$data_order_product['user_order_id'] = $order_id;
			$data_order_product['pro_weight'] = $value['weight'];
			//平台开启保证金
			if (option('credit.platform_credit_open')) {
				if (!empty($product_info['open_return_point'])) {
					$data_order_product['return_point'] = !empty($product_info['return_point']) ? $product_info['return_point'] : 0;
				} else {
					import('source.class.Margin');
					Margin::init($store['store_id']);
					//现金兑积分
					$data_order_product['return_point'] = Margin::convert($value['pro_price'], 'point');
				}
			}
			
			// 产品额外特权
			$product_discount = M('Product_discount')->getPointDiscount($product_info, $this->user['uid']);
			if (!empty($product_discount['point'])) {
				$data_order_product['point'] = $product_discount['point'];
			}
			if (!empty($product_discount['discount'])) {
				$data_order_product['discount'] = $product_discount['discount'];
			}
			
			$database_order_product->data($data_order_product)->add();
		}
		
		$suppliers = array_unique($suppliers); //分销商
		$tmp_suppliers = $suppliers;
		$suppliers = implode(',', $suppliers);
		if (!empty($suppliers)) { //修改订单，设置分销商
			$data = array();
			$data['suppliers'] = $suppliers;
			if ((count($tmp_suppliers) > 1) || $suppliers != $store['store_id']) {
				$data['is_fx'] = 1;
			}
			if (!empty($type)) {
				$data['type'] = $type;
			}
			D('Order')->where(array('order_id' => $order_id))->data($data)->save();
			$order = array_merge($order, $data);
		}
		
		//删除购物车商品
		$where = array();
		$where['pigcms_id'] = array('in', $pigcms_id_arr);
		$where['uid'] = $this->user['uid'];
		D('User_cart')->where($where)->delete();
		
		// 产生提醒
		import('source.class.Notify');
		Notify::createNoitfy($store_id, option('config.orderid_prefix') . $order_no);
		
		//产生提醒-已生成订单
		import('source.class.Notice');
		Notice::sendOut($this->user['uid'], $nowOrder, $first_product_name);
		
		json_return(0,  option('config.orderid_prefix') . $order_no);
	}
}
?>