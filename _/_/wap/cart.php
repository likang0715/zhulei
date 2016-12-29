<?php
/**
 *  订单信息
 */
require_once dirname(__FILE__).'/global.php';

$wap_user = !empty($_SESSION['wap_user']) ? $_SESSION['wap_user'] : array();
$now_store = M('Store')->wap_getStore($tmp_store_id);

//关注折扣判断
$follow = M('Store')->is_subscribe_store($wap_user['uid'],$now_store['store_id']);
$is_followed = !empty($follow)? 1:0;

//print_r($follow);

$action = isset($_GET['action']) ? $_GET['action'] : '';
if(empty($action)){

	$store_id = intval(trim($_GET['id']));
	//店铺资料
	$now_store = M('Store')->wap_getStore($store_id);
	if(empty($now_store)) pigcms_tips('您访问的店铺不存在','none');
	if ($now_store['top_supplier_id']) {
		$tmp_store_id = $now_store['top_supplier_id'];
	} else {
		$tmp_store_id = $store_id;
	}
	
	if($now_store['is_point_mall'] == 1) {
		//积分商城
		$tip = "积分商品";
		$is_point_mall = 1;
		$allow_drp = false;	//不允许分销
	} else {
		$tip = "商品";
		$is_point_mall = 0;
	}
	
	
	$cart_where = "`uc`.`store_id`='$store_id' AND `uc`.`product_id`=`p`.`product_id`";
	if($wap_user['uid']){
		$cart_where .= " AND `uc`.`uid`='".$wap_user['uid']."'";
	}else{
		$cart_where .= " AND `uc`.`session_id`='".session_id()."'";
	}
	$cartList = D('')->field('`uc`.`pigcms_id`,`uc`.`product_id`,`uc`.`pro_num`,`uc`.`pro_price`,`uc`.`sku_id`,`uc`.`sku_data`, `uc`.`store_id`, `p`.`name`,`p`.`image`,`p`.`quantity`,`p`.`status`,`p`.`buyer_quota`, `p`.`price`, `p`.`after_subscribe_discount`, `p`.`after_subscribe_price`,`p`.`drp_level_1_price`, `p`.`drp_level_2_price`, `p`.`drp_level_3_price`, `p`.`has_property`, `p`.`is_fx`')->table(array('User_cart'=>'uc','Product'=>'p'))->where($cart_where)->order('`pigcms_id` DESC')->select();
	
	$database_product_sku = D('Product_sku');
	foreach($cartList as $key=>$value){
        //限购
        if (!empty($value['buyer_quota'])) {
            if (empty($_SESSION['wap_user'])) { //游客购买
                $session_id = session_id();
                $orders = D('Order')->field('order_id')->where(array('session_id' => $session_id))->select();
                $quantity = 0;
                if (!empty($orders)) {
                    foreach ($orders as $order) {
                        $products = D('Order_product')->field('pro_num')->where(array('product_id' => $value['product_id'], 'order_id' => $order['order_id']))->select();
                        foreach ($products as $product) {
                            $quantity += $product['pro_num']; //购买数量
                        }
                    }
                }
            } else {
                $uid = $_SESSION['wap_user']['uid'];
                $orders = D('Order')->field('order_id')->where(array('uid' => $uid))->select();
                $quantity = 0;
                if (!empty($orders)) {
                    foreach ($orders as $order) {
                        $products = D('Order_product')->field('pro_num')->where(array('product_id' => $value['product_id'], 'order_id' => $order['order_id']))->select();
                        foreach ($products as $product) {
                            $quantity += $product['pro_num']; //购买数量
                        }
                    }
                }
            }
            $cartList[$key]['buy_quantity'] = $quantity;
        } else {
            $cartList[$key]['buy_quantity'] = 0;
        }
        
		$cartList[$key]['sku_num'] = 0;
		
		$nowSku = array();
		if ($value['has_property']) {
			//有商品属性
			$sku_data_arr = unserialize($value['sku_data']);
			$properties_arr = array();
			if (is_array($sku_data_arr)) {
				foreach ($sku_data_arr as $sku_data) {
					$properties_arr[] = $sku_data['pid'] . ':' . $sku_data['vid'];
				}
			}

			$properties = join(';', $properties_arr);
			// 库存信息没有时，直接删除购物车表里相应的信息
			if (empty($properties)) {
				D('User_cart')->where(array('pigcms_id' => $value['pigcms_id']))->delete();
				unset($cartList[$key]);
				continue;
			}
			
			$nowSku = $database_product_sku->where(array('properties' => $properties, 'product_id' => $value['product_id']))->find();
			if (empty($nowSku)) {
				D('User_cart')->where(array('pigcms_id' => $value['pigcms_id']))->delete();
				unset($cartList[$key]);
				continue;
			}

			if ($now_store['drp_level'] > 0 && $value['is_fx']) {
				$cartList[$key]['pro_price'] = $now_store['drp_level'] <= 3 ? $nowSku['drp_level_' . $now_store['drp_level'] . '_price'] : $nowSku['drp_level_3_price'];
				
				if (!empty($follow) && $value['after_subscribe_discount'] > 0 && $value['after_subscribe_discount'] < 10) {
					$cartList[$key]['pro_price'] = $cartList[$key]['pro_price'] * $value['after_subscribe_discount'] / 10;
				}
			} else {
				if(!empty($follow) && $value['after_subscribe_discount'] > 0 && $value['after_subscribe_discount'] < 10){
					$cartList[$key]['pro_price'] = $nowSku['price'] * $value['after_subscribe_discount'] / 10;
				}else{
					$cartList[$key]['pro_price'] = $nowSku['price'];
				}

			}
		} else {
//			无商品属性
			$cartList[$key]['sku_id'] = 0;
			$cartList[$key]['sku_data'] = '';
			
			if ($now_store['drp_level'] > 0 && $value['is_fx']) {
				$cartList[$key]['pro_price'] = $now_store['drp_level'] <= 3 ? $value['drp_level_' . $now_store['drp_level'] . '_price'] : $value['drp_level_3_price'];
				
				if(!empty($follow) && $value['after_subscribe_discount'] > 0 && $value['after_subscribe_discount'] < 10){
					$cartList[$key]['pro_price'] = $cartList[$key]['pro_price'] * $value['after_subscribe_discount'] / 10;
				}
			} else {
//				关注价格
				if(!empty($follow) && $value['after_subscribe_discount'] > 0 && $value['after_subscribe_discount'] < 10){
					$cartList[$key]['pro_price'] = $value['price'] * $value['after_subscribe_discount'] / 10;
				}else{
					$cartList[$key]['pro_price'] = $value['price'];
				}

//				$cartList[$key]['pro_price'] = $value['price'];
			}
		}
		
		if($value['sku_id'] && $value['quantity'] && $value['status'] == 1){
			$cartList[$key]['sku_num'] = $nowSku['quantity'];
		}else if($value['quantity']){
			$cartList[$key]['sku_num'] = $value['quantity'];
		}
		$cartList[$key]['image'] = getAttachmentUrl($value['image']);
	}

	//分享配置 start  
	$share_conf 	= array(
		'title' 	=> $now_store['name'], // 分享标题
		'desc' 		=> str_replace(array("\r","\n"), array('',''),  $now_store['intro']), // 分享描述
		'link' 		=> $now_store['url'], // 分享链接
		'imgUrl' 	=> $now_store['logo'], // 分享图片链接
		'type'		=> '', // 分享类型,music、video或link，不填默认为link
		'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
	);
	import('WechatShare');
	$share 		= new WechatShare();
	$shareData 	= $share->getSgin($share_conf);

	//分享配置 end
	include display('cart');
	
}else if($action == 'quantity'){
	if(empty($_POST['id'])) json_return(1,'数据异常');
	if(!empty($_POST['skuId'])){
		$condition_product_sku['sku_id'] = $_POST['skuId'];
		$product_sku = D('Product_sku')->field('`quantity`')->where($condition_product_sku)->find();
		$quantity = $product_sku['quantity'];
	}else if(!empty($_POST['proId'])){
		$condition_product['product_id'] = $_POST['proId'];
		$product = D('Product')->field('`quantity`')->where($condition_product)->find();
		$quantity = $product['quantity'];
	}else{
		json_return(1,'数据异常');
	}
	$condition_user_cart['pigcms_id'] = $_POST['id'];
	if($wap_user['uid']){
		$condition_user_cart['uid'] = $wap_user['uid'];
	}else{
		$condition_user_cart['session_id'] = session_id();
	}
	$data_user_cart['pro_num'] = $_POST['num'] < $quantity ? intval($_POST['num']) : $quantity;
	D('User_cart')->where($condition_user_cart)->data($data_user_cart)->save();
	json_return(0,$quantity);
}else if($action == 'del'){
	if(empty($_POST['ids'])){
		json_return(1000,'请勾选一些内容');
	}
	$condition_user_cart['pigcms_id'] = array('in',$_POST['ids']);
	$condition_user_cart['store_id'] = $_POST['storeId'];
	if($wap_user['uid']){
		$condition_user_cart['uid'] = $wap_user['uid'];
	}else{
		$condition_user_cart['session_id'] = session_id();
	}
	if(D('User_cart')->where($condition_user_cart)->delete()){
		json_return(0,'删除成功');
	}else{
		json_return(1001,'删除失败，请重试');
	}
}else if($action == 'pay'){

	$wap_user1 = !empty($_SESSION['wap_user']) ? $_SESSION['wap_user'] : array();

	$follow1 = M('Store')->is_subscribe_store($_SESSION['wap_user']['uid'], $_POST['storeId']);
	
//	支付
	if(empty($_POST['ids'])){
		json_return(1000,'请勾选一些内容');
	}
	$now_store = M('Store')->getStore($_POST['storeId']);
	if(empty($now_store)) {
		json_return(1001, '未找到相应的店铺');
	}

//	用户信息
	if($wap_user['uid']){
		$cart_where = "`uc`.`product_id`=`p`.`product_id` AND `uc`.`uid`='".$wap_user['uid']."' AND `uc`.`store_id`='".$_POST['storeId']."'";
	}else{
		$cart_where = "`uc`.`product_id`=`p`.`product_id` AND `uc`.`session_id`='".session_id()."' AND `uc`.`store_id`='".$_POST['storeId']."'";
	}

//	定义初始值
	$cartList = array();
	$pro_num = $pro_count = $pro_money = 0;

	foreach($_POST['ids'] as $value){
		$now_cart = D('')->field('`uc`.*, `p`.`uid` as p_uid, `p`.`name`, `p`.`buyer_quota`,`p`.`quantity`,`p`.`status`, `p`.`weight`, `p`.`price`, `p`.`after_subscribe_discount`, `p`.`after_subscribe_price`, `p`.`drp_level_1_price`, `p`.`drp_level_2_price`, `p`.`drp_level_3_price`, `p`.`has_property`, `p`.`is_fx`')->table(array('User_cart'=>'uc','Product'=>'p'))->where($cart_where." AND `uc`.`pigcms_id`='$value'")->find();
		
		if(empty($now_cart)){
			json_return(1001,'您选中的商品已下架');
		}
		
		if ($wap_user['uid'] && $wap_user['uid'] == $now_cart['p_uid']) {
			json_return(1000, '不能购买自己的商品');
		}
		
		// 限购
		if ($now_cart['buyer_quota']) {
			$buy_quantity = 0;
			$user_type = 'uid';
			$uid = $_SESSION['wap_user']['uid'];
			if (empty($_SESSION['wap_user'])) { //游客购买
				$user_type = 'session';
				$session_id = session_id();
				$uid = session_id();
				
				// 查找购物车里相同产品的数量
				$user_cart_sum = D('User_cart')->where(array('session_id' => $uid, 'product_id' => $now_cart['product_id']))->field('sum(pro_num) AS number')->find();
				$buy_quantity += $user_cart_sum['number'] + 0;
			} else {
				// 查找购物车里相同产品的数量
				$user_cart_sum = D('User_cart')->where(array('uid' => $uid, 'product_id' => $now_cart['product_id']))->field('sum(pro_num) AS number')->find();
				$buy_quantity += $user_cart_sum['number'] + 0;
			}
			
			$buy_quantity += M('Order_product')->getBuyNumber($uid, $now_cart['product_id'], $user_type);
			if ($buy_quantity > $now_cart['buyer_quota']) { //限购
				json_return(1001, $now_cart['name'] . '商品限购，请修改购买数量');
			}
		}
		
		//检测库存和同步产品价格
		if(!empty($now_cart['has_property'])){
//			有商品规格
			$sku_data_arr = unserialize($now_cart['sku_data']);
			$properties_arr = array();
			if (is_array($sku_data_arr)) {
				foreach ($sku_data_arr as $sku_data) {
					$properties_arr[] = $sku_data['pid'] . ':' . $sku_data['vid'];
				}
			}
			
			$properties = join(';', $properties_arr);
			// 库存信息没有时，直接删除购物车表里相应的信息
			if (empty($properties)) {
				json_return(1001, $now_cart['name'] . '商品已过期');
			}
				
			$product_sku = D('Product_sku')->where(array('properties' => $properties, 'product_id' => $now_cart['product_id']))->find();
			if (empty($product_sku)) {
				json_return(1001, $now_cart['name'] . '商品已过期');
			}
			
			if ($now_store['drp_level'] > 0 && $now_cart['is_fx']) {
				$now_cart['pro_price'] = $now_store['drp_level'] <= 3 ? $product_sku['drp_level_' . $now_store['drp_level'] . '_price'] : $product_sku['drp_level_3_price'];
			} else {
				$now_cart['pro_price'] = $product_sku['price'];
			}
			
			$quantity = $product_sku['quantity'];
			if (!empty($product_sku['weight'])) {
				$now_cart['weight'] = $product_sku['weight'];
			}
			$now_cart['return_point'] = $product_sku['return_point'];
		}else{
//			无商品规格
			if ($now_store['drp_level'] > 0 && $now_cart['is_fx']) {
				$now_cart['pro_price'] = $now_store['drp_level'] <= 3 ? $now_cart['drp_level_' . $now_store['drp_level'] . '_price'] : $now_cart['drp_level_3_price'];
			} else {
				$now_cart['pro_price'] = $now_cart['price'];
			}
			$quantity = $now_cart['quantity'];
			$now_cart['sku_id'] = 0;
			$now_cart['sku_data'] = '';
		}
		if($quantity < $now_cart['pro_num']){
			json_return(1001,'您选中的商品库存不足');
		}

		if (!empty($follow1) && $now_cart['after_subscribe_discount'] >= 1 && $now_cart['after_subscribe_discount'] < 10) {
			$now_cart['pro_price'] *= ($now_cart['after_subscribe_discount'] / 10);
			$now_cart['subscribed_discount'] = $now_cart['after_subscribe_discount'];
		}
		
		$cartList[] = $now_cart;
		$pro_num += $now_cart['pro_num'];
		$pro_money += ($now_cart['pro_price']*100)*$now_cart['pro_num']/100;
		$pro_count++;
	}
	
	$order_no = date('YmdHis',$_SERVER['REQUEST_TIME']).mt_rand(100000,999999);
	$data_order['store_id'] = $_POST['storeId'];
	$data_order['order_no'] = $data_order['trade_no'] = $order_no;
	if(!empty($wap_user['uid'])){
		$data_order['uid'] = $wap_user['uid'];
	}else{
		$data_order['session_id'] = session_id();
	}
	
	$data_order['pro_num'] = $pro_num;
	$data_order['pro_count'] = $pro_count;
	$data_order['add_time'] = $_SERVER['REQUEST_TIME'];
	if($now_store['is_point_mall'] == '1') {
		//积分订单
		$data_order['is_point_order'] = 1;
		$data_order['sub_total'] =  0;
		$data_order['order_pay_point'] = $pro_money;
	} else {
		$data_order['is_point_order'] = 0;
		$data_order['sub_total'] = $pro_money;
		$data_order['order_pay_point'] = 0;
	}
	$database = D('Order');

	//订单所属团队
	if (!empty($now_store['drp_team_id'])) {
		if (M('Drp_team')->checkDrpTeam($now_store['store_id'], true)) {
			$data_order['drp_team_id'] = $now_store['drp_team_id'];
		}
	}
	//分销商的等级
	if (!empty($now_store['drp_supplier_id']) && !empty($now_store['drp_supplier_id'])) {
		import('source.class.Points');
		$data_order['drp_degree_id'] = Points::drpDegree($now_store['store_id'], true);
	}

	$order_id = $database->data($data_order)->add();
	$nowOrder = array_merge($data_order,array('order_id'=>$order_id));
	if(empty($order_id)){
		json_return(1004,'订单产生失败，请重试');
	}
	if(!empty($wap_user['uid'])){
		M('Store_user_data')->upUserData($data_order['store_id'],$wap_user['uid'],'unpay');
	}
	$database_order_product = D('Order_product');
	$database_product = D('Product');

	//店铺信息
	$nowStore = D('Store')->field('store_id,drp_supplier_id,drp_diy_store')->where(array('store_id' => $data_order['store_id']))->find();

	$suppliers = array();

	foreach($cartList as $value){
		$data_order_product = array();
		$data_order_product['order_id'] = $order_id;

		$product_info = $database_product->field('is_fx,product_id,store_id,original_product_id,supplier_id,wholesale_product_id,name, check_give_points, check_degree_discount, give_points, open_return_point, return_point, has_property')->where(array('product_id' => $value['product_id']))->find();
		$first_product_name = msubstr($product_info['name'], 0, 11);
		if ($product_info['store_id'] != $nowStore['store_id'] && empty($product_info['supplier_id'])) {
			$type = 3; //分销
		}
		if ($product_info['store_id'] == $nowStore['store_id'] && empty($product_info['supplier_id'])) { //店铺自营商品
			$supplier_id         = 0;
			$original_product_id = 0;
			$data_order_product['is_fx']               = 0;
			$data_order_product['supplier_id']         = $supplier_id;
			$data_order_product['original_product_id'] = $original_product_id;
		} else if ($product_info['store_id'] == $nowStore['store_id'] && !empty($product_info['wholesale_product_id'])) { //店铺批发商品
			$supplier_id         = $product_info['supplier_id'];
			$suppliers[]         = $supplier_id;
			$original_product_id = $product_info['wholesale_product_id'];
			$data_order_product['is_fx']               = 0;
			$data_order_product['supplier_id']         = $supplier_id;
			$data_order_product['original_product_id'] = $original_product_id;
		} else if ($product_info['store_id'] != $nowStore['store_id'] && !empty($product_info['is_fx']) && empty($product_info['wholesale_product_id'])) { //分销供货商自营商品
			$supplier_id         = $product_info['store_id'];
			$suppliers[]         = $supplier_id;
			$original_product_id = $product_info['product_id'];
			$data_order_product['is_fx']               = 1;
			$data_order_product['supplier_id']         = $nowStore['drp_supplier_id'];
			$data_order_product['original_product_id'] = $original_product_id;
		} else if ($product_info['store_id'] != $nowStore['store_id'] && !empty($product_info['is_fx']) && !empty($product_info['wholesale_product_id'])) { //分销供货商批发商品
			$supplier_id         = $product_info['supplier_id'];
			$suppliers[]         = $supplier_id;
			$original_product_id = $product_info['wholesale_product_id'];
			$data_order_product['is_fx']               = 1;
			$data_order_product['supplier_id']         = $nowStore['drp_supplier_id'];
			$data_order_product['original_product_id'] = $original_product_id;
		} else if ($product_info['store_id'] != $nowStore['store_id'] && empty($product_info['is_fx']) && empty($product_info['wholesale_product_id'])) { //分销供货商未设置分销的自营商品
			$supplier_id         = $product_info['store_id'];
			$suppliers[]         = $supplier_id;
			$original_product_id = $product_info['product_id'];
			$data_order_product['is_fx']               = 1;
			$data_order_product['supplier_id']         = $nowStore['drp_supplier_id'];
			$data_order_product['original_product_id'] = $original_product_id;
		} else if ($product_info['store_id'] != $nowStore['store_id'] && empty($product_info['is_fx']) && !empty($product_info['wholesale_product_id'])) { //分销供货商未设置分销的批发商品
			$supplier_id         = $product_info['supplier_id'];
			$suppliers[]         = $supplier_id;
			$original_product_id = $product_info['wholesale_product_id'];
			$data_order_product['is_fx']               = 1;
			$data_order_product['supplier_id']         = $nowStore['drp_supplier_id'];
			$data_order_product['original_product_id'] = $original_product_id;
		}
		$data_order_product['product_id']    = $value['product_id'];
		$data_order_product['sku_id']        = $value['sku_id'];
		$data_order_product['sku_data']      = $value['sku_data'];
		$data_order_product['pro_num']       = $value['pro_num'];
		$data_order_product['pro_price']     = $value['pro_price'];

		$data_order_product['comment']       = !empty($value['comment']) ? $value['comment'] : '';
		$data_order_product['user_order_id'] = $order_id;
		$data_order_product['pro_weight']    = $value['weight'];

		if (!empty($value['subscribed_discount']) && $value['subscribed_discount'] > 0 && $value['subscribed_discount'] < 10) {
			$data_order_product['subscribed_discount'] = $value['subscribed_discount'];
		}

		//平台开启保证金
		if (option('credit.platform_credit_open')) {
			if (!empty($product_info['open_return_point'])) {
				if ($product_info['has_property']) {
					$data_order_product['return_point'] = !empty($value['return_point']) ? $value['return_point'] : 0;
				} else {
					$data_order_product['return_point'] = !empty($product_info['return_point']) ? $product_info['return_point'] : 0;
				}
			} else {
				import('source.class.Margin');
				Margin::init($nowStore['store_id']);
				//现金兑积分
				$data_order_product['return_point'] = Margin::convert($value['pro_price'], 'point');
			}
		}
		
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
		
		$database_order_product->data($data_order_product)->add();
	}
    $suppliers = array_unique($suppliers); //分销商
	$tmp_suppliers = $suppliers;
    $suppliers = implode(',', $suppliers);
    if (!empty($suppliers)) { //修改订单，设置分销商
        $data = array();
        $data['suppliers'] = $suppliers;
        if ((count($tmp_suppliers) > 1) || $suppliers != $nowStore['store_id']) {
            $data['is_fx'] = 1;
			$type = 3; //分销
        }
		if (!empty($type)) {
			$data['type'] = $type;
		}
        $database->where(array('order_id' => $order_id))->data($data)->save();
        $nowOrder = array_merge($nowOrder,$data);
    }
	//删除购物车商品
	$condition_user_cart['pigcms_id'] = array('in',$_POST['ids']);
	if(!empty($wap_user['uid'])){
		$condition_user_cart['uid'] = $wap_user['uid'];
	}else{
		$condition_user_cart['session_id'] = session_id();
	}
	D('User_cart')->where($condition_user_cart)->delete();
	
	// 产生提醒
	import('source.class.Notify');
	Notify::createNoitfy($_POST['storeId'], option('config.orderid_prefix') . $order_no);
	
	//////////////////////////////////////////////////////////////////////////////////////////////////
	$uid = $_SESSION['wap_user']['uid'];
	//产生提醒-已生成订单
	import('source.class.Notice');
	Notice::sendOut($uid, $nowOrder,$first_product_name);
	//////////////////////////////////////////////////////////////////////////////////////////////////
		
	json_return(0,$config['orderid_prefix'].$order_no);

}

echo ob_get_clean();
?>