<?php
class order_controller extends base_controller{
	// 添加订单
	function add() {
		if (empty($this->user_session)) {
			echo json_encode(array('status' => false, 'msg' => 'nologin'));
			exit;
		}
		
		// 参数获取
		$product_id = $_POST['product_id'];
		$sku_id = $_POST['sku_id'];
		$quantity = $_POST['quantity'];
		
		//验证商品
		$product = D('Product')->field('`product_id`,`store_id`,`original_product_id`,`price`,`has_property`,`status`,`supplier_id`,`quantity`, `buyer_quota`, `weight`, `check_give_points`, `check_degree_discount`, `give_points`, `open_return_point`, `return_point`')->where(array('product_id'=>$product_id))->find();

		//店铺
		$nowStore = D('Store')->where(array('store_id' => $product['store_id']))->find();
		if ($nowStore['uid'] == $this->user_session['uid']) {
			echo json_encode(array('status' => false, 'msg' => '不能购买自己的商品'));
			exit;
		}

		$weight = $product['weight'];
		if(empty($product) || empty($product['status'])){
			echo json_encode(array('status' => false, 'msg' => '商品不存在'));
			exit;
		}
		
		// 限购
		if ($product['buyer_quota']) {
			$number = M('Order_product')->getBuyNumber($this->user_session['uid'], $product_id);
			// 查找购物车里相同产品的数量
			$user_cart_sum = D('User_cart')->where(array('uid' => $this->user_session['uid'], 'product_id' => $product['product_id']))->field('sum(pro_num) AS number')->find();
			$number += $user_cart_sum['number'] + 0;
			
			if ($number + $quantity > $product['buyer_quota']) {
				echo json_encode(array('status' => false, 'msg' => '对不起，您超出了限购'));
				exit;
			}
		}
		
		if(empty($product['has_property'])){
			$sku_id = 0;
			$propertiesStr = '';
			$product_price = $product['price'];
			
			if ($product['quantity'] < $quantity) {
				echo json_encode(array('status' => false, 'msg' => '商品库存不足'));
				exit;
			}
			
		}else{
			if (empty($sku_id)) {
				echo json_encode(array('status' => false, 'msg' => '请选择商品属性'));
				exit;
			}
			
			//判断库存是否存在
			$nowSku = D('Product_sku')->field('`sku_id`,`product_id`,`properties`, `price`, `quantity`, `weight`')->where(array('sku_id' => $sku_id))->find();
			if ($nowSku['weight']) {
				$weight = $nowSku['weight'];
			}
			if ($nowSku['quantity'] < $quantity) {
				echo json_encode(array('status' => false, 'msg' => '商品库存不足'));
				exit;
			}
			
				
			$tmpPropertiesArr = explode(';',$nowSku['properties']);
			$properties = $propertiesValue = $productProperties = array();
			foreach($tmpPropertiesArr as $value){
				$tmpPro = explode(':',$value);
				$properties[] = $tmpPro[0];
				$propertiesValue[] = $tmpPro[1];
			}
			if(count($properties) == 1){
				$findPropertiesArr = D('Product_property')->field('`pid`,`name`')->where(array('pid'=>$properties[0]))->select();
				$findPropertiesValueArr = D('Product_property_value')->field('`vid`,`value`')->where(array('vid'=>$propertiesValue[0]))->select();
			}else{
				$findPropertiesArr = D('Product_property')->field('`pid`,`name`')->where(array('pid'=>array('in',$properties)))->select();
				$findPropertiesValueArr = D('Product_property_value')->field('`vid`,`value`')->where(array('vid'=>array('in',$propertiesValue)))->select();
			}
			foreach($findPropertiesArr as $value){
				$propertiesArr[$value['pid']] = $value['name'];
			}
			foreach($findPropertiesValueArr as $value){
				$propertiesValueArr[$value['vid']] = $value['value'];
			}
			foreach($properties as $key=>$value){
				$productProperties[] = array('pid'=>$value,'name'=>$propertiesArr[$value],'vid'=>$propertiesValue[$key],'value'=>$propertiesValueArr[$propertiesValue[$key]]);
			}
			$propertiesStr = serialize($productProperties);
			if($product['product_id'] != $nowSku['product_id']) {
				echo json_encode(array('status' => false, 'msg' => '商品属性选择错误'));
				exit;
			}
				
			$product_price = $nowSku['price'];
		}
		if($_POST['activityId']){
			$nowActivity = M('Product_qrcode_activity')->getActivityById($_POST['activityId']);
			if($nowActivity['product_id'] == $product['product_id']){
				if($nowActivity['type'] == 0){
					$product_price = round($product_price*$nowActivity['discount']/10,2);
				}else{
					$product_price = $product_price-$nowActivity['price'];
				}
			}
		}
		
		if (empty($quantity)) {
			echo json_encode(array('status' => false, 'msg' => '请输入购买数量'));
			exit;
		}
		
		if($_POST['type'] == 'add'){	//立即购买
			$order_no = date('YmdHis',$_SERVER['REQUEST_TIME']).mt_rand(100000,999999);
			$data_order['store_id'] = $product['store_id'];
			$data_order['order_no'] = $data_order['trade_no'] = $order_no;
			$data_order['uid'] = $this->user_session['uid'];
			$data_order['sub_total'] = ($product_price*100)*$quantity/100;
			$data_order['pro_num'] = $quantity;
			$data_order['pro_count'] = '1';
			$data_order['add_time'] = $_SERVER['REQUEST_TIME'];

			//订单所属团队
			if (!empty($nowStore['drp_team_id'])) {
				if (M('Drp_team')->checkDrpTeam($nowStore['store_id'], true)) {
					$data_order['drp_team_id'] = $nowStore['drp_team_id'];
				}
			}
			
			$order_id = D('Order')->data($data_order)->add();
			if(empty($order_id)){
				echo json_encode(array('status' => false, 'msg' => '订单产生失败，请重试'));
				exit;
			}
			
			$data_order_product['order_id'] = $order_id;
			$data_order_product['product_id'] = $product['product_id'];
			$data_order_product['sku_id'] = $sku_id;
			$data_order_product['sku_data'] = $propertiesStr;
			$data_order_product['pro_num'] = $quantity;
			$data_order_product['pro_price'] = $product_price;
			$data_order_product['comment'] = !empty($_POST['custom']) ? serialize($_POST['custom']) : '';
			$data_order_product['pro_weight'] = $weight;
			//平台开启保证金
			if (option('credit.platform_credit_open')) {
				if (!empty($product['open_return_point'])) {
					$data_order_product['return_point'] = !empty($product['return_point']) ? $product['return_point'] : 0;
				} else {
					import('source.class.Margin');
					Margin::init($nowStore['store_id']);
					//现金兑积分
					$data_order_product['return_point'] = Margin::convert($product_price, 'point');
				}
			}
			
			// 折扣
			$product_discount = M('Product_discount')->getPointDiscount($product, $this->user_session['uid']);
			if (!empty($product_discount['point'])) {
				$data_order_product['point'] = $product_discount['point'];
			}
			if (!empty($product_discount['discount'])) {
				$data_order_product['discount'] = $product_discount['discount'];
			}
			
			//分销商品
			if (!empty($product['supplier_id'])) {
				$data_order_product['is_fx'] = 1;
			}
			
			if (!empty($product['original_product_id'])) {
				$tmp_product_info = D('Product')->field('store_id')->where(array('product_id' => $product['original_product_id']))->find();
				$supplier_id = $tmp_product_info['store_id'];
				$original_product_id = $product['original_product_id'];
			} else {
				$supplier_id = $product['store_id'];
				$original_product_id = $product['product_id'];
			}
			$data_order_product['supplier_id'] = $supplier_id;
			$data_order_product['original_product_id'] = $original_product_id;
			$data_order_product['user_order_id'] = $order_id;
			
			if(D('Order_product')->data($data_order_product)->add()){
				if(!empty($this->user_session['uid'])){
					M('Store_user_data')->upUserData($product['store_id'],$this->user_session['uid'],'unpay');
				}
				if (!empty($supplier_id)) { //修改订单，设置分销商
					D('Order')->where(array('order_id' => $order_id))->data(array('suppliers' => $supplier_id))->save();
				}
				
				echo json_encode(array('status' => true, 'msg' => '订单添加成功', 'data' => array('order_no' => option('config.orderid_prefix') . $order_no)));
				// 产生提醒
				import('source.class.Notify');
				Notify::createNoitfy($product['store_id'], option('config.orderid_prefix') . $order_no);
				exit;
			}else{
				echo json_encode(array('status' => false, 'msg' => '订单产生失败，请重试'));
				exit;
			}
		}else{
			// 查找购物车里是否有相应的产品
			$user_cart = D('User_cart')->where(array('uid' => $this->user_session['uid'], 'product_id' => $product['product_id'], 'store_id' => $product['store_id'], 'sku_id' => $sku_id))->find();
			if (!empty($user_cart)) {
				if (D('User_cart')->where(array('pigcms_id' => $user_cart['pigcms_id']))->setInc('pro_num', $quantity)) {
					// 查找购物车数量
					$pro_num = D('User_cart')->where(array('uid' => $this->user_session['uid']))->sum('pro_num');
					
					echo json_encode(array('status' => true, 'msg' => '添加购物车成功', 'data' => array('number' => $pro_num)));
					exit;
				} else {
					echo json_encode(array('status' => false, 'msg' => '添加购物车失败'));
					exit;
				}
			}
			
			$data_user_cart['uid'] = $this->user_session['uid'];
			$data_user_cart['product_id'] = $product['product_id'];
			$data_user_cart['store_id'] = $product['store_id'];
			$data_user_cart['sku_id'] = $sku_id;
			$data_user_cart['sku_data'] = $propertiesStr;
			$data_user_cart['pro_num'] = $quantity;
			$data_user_cart['pro_price'] = $product_price;
			$data_user_cart['add_time'] = $_SERVER['REQUEST_TIME'];
			$data_user_cart['comment'] = !empty($_POST['custom']) ? serialize($_POST['custom']) : '';
			if (!empty($product['supplier_id'])) {
				$data_user_cart['is_fx'] = 1;
			}
			if(D('User_cart')->data($data_user_cart)->add()){
				// 查找购物车数量
				$pro_num = D('User_cart')->where(array('uid' => $this->user_session['uid']))->sum('pro_num');
				
				echo json_encode(array('status' => true, 'msg' => '添加购物车成功', 'data' => array('number' => $pro_num)));
				exit;
			}else{
				echo json_encode(array('status' => false, 'msg' => '添加购物车失败'));
				exit;
			}
		}
	}
	
	function address() {
		$order_id = $_GET['order_id'];
		
		if (IS_POST) {
			$_POST['orderNo'] = $order_id;
			$coupon_id = $_POST['coupon_id'];
			
			if (empty($coupon_id)) {
				$coupon_id = array(0);
			} else {
				$coupon_id = explode(',', $coupon_id);
			}
			
			$_REQUEST['user_coupon_id'] = $coupon_id;
			$pay_config = array();
			$pay_config['user'] = $this->user_session;
			$pay_config['is_wap'] = false;
				
			import('source.class.OrderPay');
			$order_pay = new OrderPay($pay_config);
			$order_pay->pc_pay();
			exit;
		}
		
		if (empty($order_id)) {
			pigcms_tips('缺少最基本的参数');
		}
		
		$order = M('Order')->find($order_id);
		// 有收货地址不给更改收货地址
		if ($order['address']) {
			redirect(url('order:detail', array('order_id' => $order_id)));
		}
		
		if (empty($order)) {
			pigcms_tips('未找到相应的订单');
		}
		
		if ($order['uid'] != $this->user_session['uid']) {
			pigcms_tips('请您操作自己的订单');
		}
		
		if ($order['status'] > 1) {
			redirect(url('order:detail', array('order_id' => $order_id)));
		}
		
		$store = M('Store')->getStore($order['store_id'], true);
		$supplier_store_id = $store['store_id'];
		if ($store['top_supplier_id']) {
			$supplier_store_id = $store['top_supplier_id'];
		}
		
		// 抽出可以享受的优惠信息与优惠券
		import('source.class.Order');
		$order_data = new Order($order['proList']);
		// 不同供货商的优惠、满减、折扣、包邮等信息
		$order_data = $order_data->all();
		
		// 优惠活动
		$product_id_arr = array();
		$store_id = 0;
		$uid = 0;
		$total_price = 0;
		$product_price_arr = array();
		$offline_payment = $store['offline_payment'];
		$is_all_selfproduct = true;
		$is_all_supplierproduct = true;
		$discount_money = 0;
		foreach ($order['proList'] as $product) {
			if(!$first_product_name)	$first_product_name = msubstr($product[name],0,11);
			if (IS_POST) {
				// 限购，支付时，也做限制判断
				if ($product['buyer_quota']) {
					// 再加上订单里已经购买的商品
					$buy_quantity = M('Order_product')->getBuyNumber($this->user_session['uid'], $product['product_id']);
					
					if ($buy_quantity + $product['pro_num'] > $product['buyer_quota']) {
						echo json_encode(array('status' => false, 'msg' => '您购买的产品：' . $product['name'] . '超出了限购'));
						exit;
					}
				}
			}
			
			$discount = 10;
			if ($product['wholesale_supplier_id']) {
				$discount = $order_data['discount_list'][$product['wholesale_supplier_id']];
				$product_price_arr[$product['wholesale_supplier_id']]['total'] += $product['pro_price'] * $product['pro_num'];
			} else {
				$discount = $order_data['discount_list'][$product['store_id']];
				$product_price_arr[$product['store_id']]['total'] += $product['pro_price'] * $product['pro_num'];
			}
			
			if ($product['discount'] > 0 && $product['discount'] <= 10) {
				$discount = $product['discount'];
			}
			
			if ($discount != 10 && $discount > 0) {
				$discount_money += $product['pro_num'] * $product['pro_price'] * (10 - $discount) / 10;
			}
			
			
			// 批发商品不能货到付款
			if ($product['wholesale_product_id'] != 0) {
				$offline_payment = false;
				$is_all_selfproduct = false;
				continue;
			} else {
				$is_all_supplierproduct = false;
			}
			
			$product_id_arr[] = $product['product_id'];
			$store_id = $product['store_id'];
			$uid = $product['uid'];
			// 单个商品总价
			$product_price_arr[$product['product_id']]['price'] = $product['pro_price'];
			// 每个商品购买数量
			$product_price_arr[$product['product_id']]['pro_num'] = $product['pro_num'];
			// 所有商品价格
			$total_price += $product['pro_price'] * $product['pro_num'];
		}
		
		$address_list = '';
		if ($store['open_logistics']) {
			$address_list = M('User_address')->getMyAddress($this->user_session['uid']);
		}
		
		//店铺资料
		if(empty($store)) {
			pigcms_tips('您访问的店铺不存在', 'none');
		}
		//上门自提
		if($store['buyer_selffetch'] && $is_all_selfproduct){
			$selffetch_list = array();// M('Trade_selffetch')->getListNoPage($now_store['store_id']);
			
			$store_contact = M('Store_contact')->get($store['store_id']);
			$store_physical = M('Store_physical')->getList($store['store_id']);
			
			if ($store_contact) {
				$data = array();
				$data['pigcms_id'] = '99999999_store';
				$data['name'] = $store['name'] . '';
				$data['tel'] = ($store_contact['phone1'] ? $store_contact['phone1'] . '-' : '') . $store_contact['phone2'];
				$data['province_txt'] = $store_contact['province_txt'] . '';
				$data['city_txt'] = $store_contact['city_txt'] . '';
				$data['county_txt'] = $store_contact['area_txt'] . '';
				$data['address'] = $store_contact['address'] . '';
				$data['business_hours'] = '';
					
				$selffetch_list[] = $data;
			}
			
			if ($store_physical) {
				foreach ($store_physical as $physical) {
					$data = array();
					$data['pigcms_id'] = $physical['pigcms_id'];
					$data['name'] = $physical['name'] . '';
					$data['tel'] = ($physical['phone1'] ? $physical['phone1'] . '-' : '') . $physical['phone2'];
					$data['province_txt'] = $physical['province_txt'] . '';
					$data['city_txt'] = $physical['city_txt'] . '';
					$data['county_txt'] = $physical['county_txt'] . '';
					$data['address'] = $physical['address'] . '';
					$data['business_hours'] = $physical['business_hours'] . '';
						
					$selffetch_list[] = $data;
				}
			}
			//$selffetch_list = M('Trade_selffetch')->getListNoPage($store['store_id']);
			$this->assign('selffetch_list', $selffetch_list);
		}
		
		if ($store['pay_agent']) {
			$store_pay_agent = D('Store_pay_agent')->where(array('type' => '0', 'store_id' => $store['store_id']))->order('rand()')->limit(1)->find();
			$this->assign('store_pay_agent', $store_pay_agent);
		}
		
		$points_data = Points::getPointConfig($this->user_session['uid'], $supplier_store_id);
		$user = D('User')->where(array('uid' => $this->user_session['uid']))->find();
		
		$this->assign('points_data', $points_data);
		$this->assign('user', $user);
		$this->assign('address_list', $address_list);
		$this->assign('order', $order);
		$this->assign('order_data', $order_data);
		$this->assign('store', $store);
		$this->assign('offline_payment', $offline_payment);
		$this->assign('is_all_selfproduct', $is_all_selfproduct);
		$this->assign('is_all_supplierproduct', $is_all_supplierproduct);
		$this->display();
	}

	// 订单支付
	function pay() {
		$order_id = $_GET['order_id'];	
		if (empty($order_id)) {
			pigcms_tips('缺少最基本的参数');
		}	
		$order_model = M('Order');
		$order = $order_model->find($order_id);
		if (empty($order)) {
			pigcms_tips('未找到要付款的订单');
		}
		if (empty($order['address'])) {
			redirect(url('order:address', array('order_id' => $order_id)));
		}
		
		if ($order['status'] > 1 && $order['payment_method'] != 'codpay') {
			pigcms_tips('此订单无需支付');
		}
		
		if ($order['shipping_method'] == 'selffetch') {
			$store = M('Store')->getStore($order['store_id']);
			$this->assign('store', $store);
		}
		$this->assign('order', $order);
		$this->display();
	}


	/**
	 * 订单详情表
	 * 只能查看自己的订单
	 */
	public function detail() {
		$order_id = $_GET['order_id'];
		if (!isset($order_id)) {
			pigcms_tips('缺少最基本的参数');
		}
		
		if (empty($this->user_session)) {
			$referer = url('order:detail', array('order_id' => $order_id));
			redirect(url('account:login', array('referer' => $referer)));
			pigcms_tips('您无权查看此订单', url('account:login'));
		}
		
		
		
		// 只能查看自己的订单
		$order_model = M('Order');
		$order = $order_model->find($order_id);
		
		if (empty($order)) {
			pigcms_tips('未找到相应的订单');
		}
		
		if ($order['uid'] != $this->user_session['uid']) {
			pigcms_tips('您无权查看此订单');
		}
		
		// 查看物流信息
		$order_package = D('Order_package')->where(array('user_order_id' => $order['order_id']))->select();
		foreach ($order_package as $key => $value) {
			if (empty($value['express_code'])) {
				unset($order_package[$key]);
			}
		}
		
		// 店铺信息
		$store = M('Store')->getStore($order['store_id']);
		// 相关折扣、满减、优惠
		import('source.class.Order');
		$order_data = Order::orderDiscount($order);
		
		if ($order['payment_method'] == 'peerpay') {
			$order_peerpay_list = D('Order_peerpay')->where(array('order_id' => $order['order_id'], 'status' => 1))->select();
			$this->assign('order_peerpay_list', $order_peerpay_list);
		}
		
		$this->assign('order', $order);
		$this->assign('store', $store);
		$this->assign('order_package', $order_package);
		$this->assign('order_data', $order_data);
		$this->display();
	}
	
	/**
	 * JSON检测订单状态
	 */
	public function check(){
		$order_id = $_GET['order_id'];
		if (!isset($order_id)) {
			pigcms_tips('缺少最基本的参数');
		}
		
		// 只能查看自己的订单
		$order = M('Order')->find($order_id);
		if($order['status'] > 1){
			json_return(0,'ok');
		}else{
			json_return(1,'error');
		}
	}
	
	/**
	 * 获取物流信息
	 */
	public function express() {
		$type = $_GET['type'];
		$order_no = $_GET['order_no'];
		$express_no = $_GET['express_no'];
		
		if (empty($type) || empty($express_no) || empty($order_no)) {
			echo json_encode(array('status' => false));
			exit;
		}
		
		$express = D('Express')->where(array('code' => $type))->find();
		if (empty($express)) {
			echo json_encode(array('status' => false));
			exit;
		}
		
		$url = 'http://www.kuaidi100.com/query?type=' . $type . '&postid=' . $express_no . '&id=1&valicode=&temp=' . time() . rand(100000, 999999);
		import('class.Express');
		//$content = Http::curlGet($url);
		$content = Express::kuadi100($url);
		$content_arr = json_decode($content, true);
		
		if ($content_arr['status'] != 200) {
			echo json_encode(array('status' => false));
			exit;
		} else {
			echo json_encode(array('status' => true, 'data' => $content_arr));
			exit;
		}
	}
	
	/**
	 * 退货申请
	 */
	public function return_apply() {
		$order_id = $_GET['order_id'];
		$pigcms_id = $_GET['pigcms_id'];
		$is_ajax = $_POST['is_ajax'];
		if (empty($order_id) || empty($pigcms_id)) {
			if ($is_ajax) {
				echo json_encode(array('status' => false, 'msg' => '缺少最基本的参数'));
				exit;
			}
			pigcms_tips('缺少最基本的参数');
		}
		
		if (empty($this->user_session)) {
			$referer = $_SERVER['HTTP_REFERER'];
			if (empty($referer)) {
				$referer = url('account:order');
			}
			
			if ($is_ajax) {
				echo json_encode(array('status' => false, 'data' => array('nexturl' => 'refresh')));
				exit;
			}
			redirect(url('account:login', array('referer' => $referer)));
		}
		
		// 只能查看自己的订单
		$order_model = M('Order');
		$order = $order_model->find($order_id);
		
		if (empty($order)) {
			if ($is_ajax) {
				echo json_encode(array('status' => false, 'msg' => '未找到相应的订单'));
				exit;
			}
			
			pigcms_tips('未找到相应的订单');
		}
		
		if ($order['uid'] != $this->user_session['uid']) {
			if ($is_ajax) {
				echo json_encode(array('status' => false, 'msg' => '您无权查看此订单'));
				exit;
			}
			pigcms_tips('您无权查看此订单');
		}
		
		if ($order['status'] != 7 && $order['status'] != 2) {
			if ($is_ajax) {
				echo json_encode(array('status' => false, 'msg' => '此订单未完成，暂时不能退货'));
				exit;
			}
			pigcms_tips('此订单未完成，暂时不能退货');
		}
		
		$order_product = D('Order_product')->where(array('pigcms_id' => $pigcms_id))->find();
		
		if (empty($order_product)) {
			if ($is_ajax) {
				echo json_encode(array('status' => false, 'msg' => '未找到要退货的产品'));
				exit;
			}
			pigcms_tips('未找到要退货的产品');
		}
		
		if ($order_product['return_status'] == 2) {
			if ($is_ajax) {
				echo json_encode(array('status' => false, 'msg' => '此产品已经申请退货了'));
				exit;
			}
			pigcms_tips('此产品已经申请退货了');
		}
		
		// 根据退货数量，判断是否可以退货
		$return_number = M('Return_product')->returnNumber($order['order_id'], $pigcms_id);
		
		if (IS_POST) {
			$type = $_POST['type'];
			$phone = $_POST['phone'];
			$content = trim($_POST['content']);
			$image_list = $_POST['image_list'];
			$number = max(0, $_POST['number'] + 0);
			
			if (!in_array($type, array(1, 2, 3, 4, 5))) {
				$type = 5;
			}
			
			if (empty($number)) {
				echo json_encode(array('status' => false, 'msg' => '请至少退一件商品'));
				exit;
			}
			
			if (strlen($content) == 0) {
				echo json_encode(array('status' => false, 'msg' => '退货说明'));
				exit;
			}
			
			if ($order_product['pro_num'] < $return_number + $number) {
				echo json_encode(array('status' => false, 'msg' => '退货数量超出购买数量'));
				exit;
			}
			
			import('source.class.ReturnOrder');
			$data = array();
			$data['pigcms_id'] = $pigcms_id;
			$data['type'] = $type;
			$data['phone'] = $phone;
			$data['content'] = $content;
			$data['images'] = $image_list;
			$data['number'] = $number;
			
			$result = ReturnOrder::apply($order, $data);
			
			if ($result) {
			
			
			$now_store = D('Store')->where(array('store_id' => $order['store_id']))->find();
			$user=M('User')->getUserById($now_store['uid']);
			
			
			
			$pj = D('Sms_power')->where(array('store_id' => $order['store_id'],'type' => '5','app' => '1'))->find();
				if ($pj) {
					$sms = D('Sms_tpl')->where(array('id'=>'5','status'=>'1'))->find();

						if($sms){
				$price=$order['total']; 
			 $ordersn=$order['order_no']; 
					 $receiver_send = D('User')->where(array('drp_store_id'=>$_POST['store_id'],'group'=>'2'))->select();
					$value = '';
					foreach($receiver_send as $key =>$r){
					
					$value .= 'store'.$r['uid'].',';
					
					 }
					 $value .= 'store'.$now_store['uid'];
					
				
					 
		
			$name=$user['name'];
		     $str=$sms['text'];
			 $str=str_replace('{ordersn}',$ordersn,$str); 
			  $str=str_replace('{price}',$price,$str);
		     $str=str_replace('{name}',$name,$str);
			 $str=str_replace('{content}',$content,$str);
				
					            $n_title   =  $str;
								$n_content =  $str;		
								$receiver_value = $value;	
								$ios=array('sound'=>'default', 'content-available'=>1);
								$sendno = $order['order_id'];
								$platform = 'android,ios' ;
								$msg_content = json_encode(array('n_builder_id'=>0, 'n_title'=>$n_title, 'n_content'=>$n_content, 'n_extras'=>array('ios'=>$ios)));        
								import('source.class.Jpush');
				                $jpush = new Jpush();
								$jpush->send($sendno, 3, $receiver_value, 1, $msg_content, $platform, 1);	

                        $data = array(
						'uid' 	=> $value,
						'store_id' 	=> $now_store['store_id'],
						'price' 	=> 10,
						'mobile' 	=> $mobile,
						'text'		=> $str,
						'status'	=> 1,
						'time' => time(),
						'type'	=> 5,
						'last_ip'	=> ip2long(get_client_ip())
			               	);
		          	D('Sms_jpush')->data($data)->add();
					}
				} 
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			$power=M('Sms_by_code')->power($now_store['store_id'],5);
			if($user['smscount']>0 && $power){
			
				$sms = D('Sms_tpl')->where(array('id'=>'5','status'=>'1'))->find();
				
				if($sms){
			 import('source.class.SendSms');
			 $price=$order['total']; 
			 $ordersn=$order['order_no']; 
			  $m = D('Sms_mobile')->where(array('store_id'=>$order['store_id'],'type'=>'1'))->find();
			 if($m){
			 $mobile=$m['mobile'];
			 }else{
			 $mobile=$now_store['tel'];
			 }
			 $name=$user['name'];
		     $str=$sms['text'];
			 $str=str_replace('{ordersn}',$ordersn,$str); 
			 $str=str_replace('{mobile}',$mobile,$str); 
			 $str=str_replace('{price}',$price,$str);
		     $str=str_replace('{name}',$name,$str);
			 $str=str_replace('{content}',$content,$str);
		 	 $return	= SendSms::send($mobile,$str);
	//	exit(json_encode(array('error' => 0, 'message' => $return)));
			
			$uid=array($now_store['uid']);
			if($return==0){
			 M('User')->deduct_sms($uid,1);	
			 
				}
			$data = array(
						'uid' 	=> $this->user_session['uid'],
						'store_id' 	=> $order['store_id'],
						'price' 	=> 10,
						'mobile' 	=> $mobile,
						'text'		=> $str,
						'status'	=> $return,
						'time' => time(),
						'type'	=> 5,
						'last_ip'	=> ip2long(get_client_ip())
				);
			D('Sms_record')->data($data)->add();
			
			 }
			}
			
				echo json_encode(array('status' => true, 'msg' => '退货申请提交成功，请等待商家处理', 'data' => array('nexturl' => url('account:return_detail&id=' . $result))));
				exit;
			} else {
				echo json_encode(array('status' => false, 'msg' => '退货申请失败，请重试'));
				exit;
			}
		}
		
		// 店铺信息
		$store = M('Store')->getStore($order['store_id']);
		
		// 查看满减送
		$order_ward_list = M('Order_reward')->getByOrderId($order['order_id']);
		// 使用优惠券
		$order_coupon = M('Order_coupon')->getByOrderId($order['order_id']);
		
		if ($order['payment_method'] == 'peerpay') {
			$order_peerpay_list = D('Order_peerpay')->where(array('order_id' => $order['order_id'], 'status' => 1))->select();
			$this->assign('order_peerpay_list', $order_peerpay_list);
		}
		
		$type_arr = M('Return')->returnType();
		
		$this->assign('type_arr', $type_arr);
		$this->assign('pigcms_id', $pigcms_id);
		$this->assign('order', $order);
		$this->assign('store', $store);
		$this->assign('return_number', $return_number);
		$this->assign('order_package', $order_package);
		$this->assign('order_ward_list', $order_ward_list);
		$this->assign('order_coupon', $order_coupon);
		$this->display();
	}
	
	// 图片添加
	public function attachment() {
		if (empty($this->user_session)) {
			echo json_encode(array('status' => false, 'msg' => 'nologin'));
			exit;
		}
		
		if(!empty($_FILES['file']) && $_FILES['file']['error'] != 4){
			$img_path_str = '';
		
			// 用会员uid
			$img_path_str = sprintf("%09d",$this->user_session['uid']);
		
			// 产生目录结构
			$rand_num = 'images/' . substr($img_path_str, 0, 3) . '/' . substr($img_path_str, 3, 3) . '/' . substr($img_path_str, 6, 3) . '/' . date('Ym', $_SERVER['REQUEST_TIME']) . '/';
				
			$upload_dir = './upload/' . $rand_num;
			if(!is_dir($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}
		
			// 进行上传图片处理
			import('UploadFile');
			$upload = new UploadFile();
			$upload->maxSize = 1 * 1024 * 1024;
			$upload->allowExts = array('jpg', 'jpeg', 'png', 'gif');
			$upload->allowTypes = array('image/png', 'image/jpg', 'image/jpeg', 'image/gif');
			$upload->savePath = $upload_dir;
			$upload->saveRule = 'uniqid';
			if($upload->upload()) {
				$uploadList = $upload->getUploadFileInfo();
				$pigcms_id = $this->_attachmentAdd($uploadList[0]['name'], $rand_num . $uploadList[0]['savename'], $uploadList[0]['size']);
				if(!$pigcms_id){
					unlink($upload_dir . $uploadList[0]['name']);
					
					echo json_encode(array('status' => false, 'msg' => '图片上传失败'));
					exit;
				} else {
					$attachment_upload_type = option('config.attachment_upload_type');
					// 上传到又拍云服务器
					if ($attachment_upload_type == '1') {
						import('source.class.upload.upyunUser');
						upyunUser::upload('./upload/' . $rand_num . $uploadList[0]['savename'], '/' . $rand_num . $uploadList[0]['savename']);
					}
					
					echo json_encode(array('status' => true, 'msg' => '上传成功', 'data' => array('id' => $pigcms_id, 'file' => getAttachmentUrl($rand_num . $uploadList[0]['savename']))));
					exit;
				}
			} else {
				echo json_encode(array('status' => false, 'msg' => '图片上传失败'));
				exit;
			}
		} else {
			echo json_encode(array('status' => false, 'msg' => '未找到要上传文件'));
			exit;
		}
	}
	
	/**
	 * 插入会员素材图片
	 */
	private function _attachmentAdd($name, $file, $size, $from=0, $type=0){
		$data['uid'] = $this->user_session['uid'];
		$data['name'] = $name;
		$data['from'] = $from;
		$data['type'] = $type;
		$data['file'] = $file;
		$data['size'] = $size;
		$data['add_time'] = $_SERVER['REQUEST_TIME'];
		$data['ip'] = get_client_ip(1);
		$data['agent'] = $_SERVER['HTTP_USER_AGENT'];
	
		if($type == 0) {
			list($data['width'], $data['height']) = getimagesize('./upload/' . $file);
		}
	
		if($pigcms_id = M('Attachment_user')->add($data)) {
			return $pigcms_id;
		} else {
			return false;
		}
	}
}