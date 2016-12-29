<?php
/**
 * 订单ajax请求页
 */
require_once dirname(__FILE__).'/global.php';

if($_GET['action'] == 'goods_change'){
	$order_id = $_POST['order_id'];
	$send_other_number = $_POST['send_other_number'];
	$send_other_per_number = $_POST['send_other_per_number'];
	
	$order = M('Order')->find($order_id);
	
	// 判断订单是否存在，是否是自己的订单
	if (empty($order) || $order['uid'] != $_SESSION['wap_user']['uid']) {
		json_return(1000, '未找到相应的订单');
	}
	
	if (empty($order['total'])) {
		json_return(1006, '订单异常，请稍后再试');
	}
	
	if ($order['shipping_method'] != 'send_other') {
		json_return(1007, '订单类型错误，此订单不是送他人订单');
	}
	
	if ($order['status'] > 1) {
		json_return(1007, '该订单已支付或关闭<br/>不再允许付款');
	}
	
	if ($order['status'] == 1) {
		json_return(1007, '该订单不能再更改产品数量或送的份数');
	}
	
	// 购买总额
	$total_number = $send_other_number * $send_other_per_number;
	
	// 支付前重新判断库存
	$order_product_id_arr = array();
	foreach ($order['proList'] as $product) {
		$order_product_id_arr[] = $product['pigcms_id'];
		// 此次产品更改的数量
		$change_number = $total_number - $product['pro_num'];
		
		$product_tmp = D('Product')->where("product_id = '" . $product['product_id'] . "'")->find();
		// 查找库存
		if ($product_tmp['has_property'] == 0) {
			if ($product_tmp['quantity'] < $total_number) {
				json_return(1010, $product_tmp['name'] . '的库存不足');
				exit;
			}
		} else {
			$sku = D('Product_sku')->where(array('sku_id' => $product['sku_id']))->find();
			if ($sku['quantity'] < $total_number) {
				json_return(1010, $product['name'] . '的库存不足');
				exit;
			}
		}
		
		// 限购，支付时，也做限制判断
		if ($product_tmp['buyer_quota']) {
			$buy_quantity = 0;
			$user_type = 'uid';
			$uid = $_SESSION['wap_user']['uid'];
			if (empty($_SESSION['wap_user'])) { //游客购买
				$session_id = session_id();
				$uid = $session_id;
				$user_type = 'session';
				//购物车
				$cart_number = D('User_cart')->field('sum(pro_num) as pro_num')->where(array('product_id' => $nowProduct['product_id'], 'session_id' => $session_id))->find();
				if (!empty($cart_number)) {
					$buy_quantity += $cart_number['pro_num'];
				}
			} else {
				//购物车
				$cart_number = D('User_cart')->field('sum(pro_num) as pro_num')->where(array('product_id' => $nowProduct['product_id'], 'uid' => $uid))->select();
				if (!empty($cart_number)) {
					$buy_quantity += $cart_number['pro_num'];
				}
			}
	
			// 再加上订单里已经购买的商品
			$buy_quantity += M('Order_product')->getBuyNumber($uid, $product_tmp['product_id'], $user_type);
	
			if ($buy_quantity + $change_number > $product_tmp['buyer_quota']) {
				json_return(1010, '您购买的产品：' . $product['name'] . '超出了限购');
			}
		}
	}
	
	// 更改所有送他人的产品数
	$result = D('Order_product')->where(array('pigcms_id' => array('in', $order_product_id_arr)))->data(array('pro_num' => $total_number))->save();
	if ($result) {
		$order_data = new Order($order['proList']);
		// 折扣
		$order_discount = $order_data->discount();
		
		$discount_money = 0;
		$total_money = 0;
		foreach ($order['proList'] as $product) {
			$total_money += $product['pro_price'] * $total_number;
			if (isset($order_discount[$product['store_id']])) {
				$discount_money += $product['pro_price'] * $total_number * (10 - $order_discount[$product['store_id']]) / 10;
			}
		}
		
		// 更改订单相应人数和每份数量
		D('Order')->where(array('order_id' => $order['order_id']))->data(array('sub_total' => $total_money, 'send_other_number' => $send_other_number, 'send_other_per_number' => $send_other_per_number))->save();
		
		json_return(0, array('total_money' => $total_money, 'discount_money' => $discount_money));
	} else {
		json_return(1000, '操作失败，请重试');
	}
} else if ($_GET['action'] == 'cancel') {
	if(empty($wap_user)) {
		json_return(1000, '请先登录');
	}
	
	$store_id = $_GET['store_id'];
	$order_id = $_POST['order_id'];
	$current_uid = $wap_user['uid'];
	
	if (empty($store_id) || empty($order_id)) {
		json_return(1000, '缺少最基本的参数');
	}
	
	$store = M('Store')->getStoreById($store_id, $current_uid);
	if (empty($store)) {
		json_return(1000, '未找到相应店铺');
	}
	
	$order = M('Order')->get(array('order_id' => $order_id, 'store_id' => $store_id));
	if (empty($order)) {
		json_return(1000, '未找到相应的订单');
	}
	
	if ($order['status'] > 1) {
		json_return(1000, '订单状态不正确，不能取消订单');
	}
	
	M('Order')->cancelOrder($order, 1);
	
	json_return(0, '操作完成');
} else if ($_GET['action'] == 'complate') {
	if(empty($wap_user)) {
		json_return(1000, '请先登录');
	}
	
	$store_id = $_GET['store_id'];
	$order_id = $_POST['order_id'];
	$current_uid = $wap_user['uid'];
	
	if (empty($store_id) || empty($order_id)) {
		json_return(1000, '缺少最基本的参数');
	}
	
	$store = M('Store')->getStoreById($store_id, $current_uid);
	if (empty($store)) {
		json_return(1000, '未找到相应店铺');
	}
	
	$order_offline = D('Order_offline')->where(array('id' => $order_id, 'store_id' => $store_id))->find();
	if (empty($order_offline)) {
		json_return(1000, '未找到相应的订单');
	}
	
	if (empty($order_offline['check_status'])) {
		json_return(1000, '请等待审核');
	}
	
	if ($order_offline['check_status'] == 2) {
		json_return(1000, '订单未审核通过');
	}
	
	if (!empty($order_offline['status'])) {
		json_return(1000, '订单已完成，不须再次操作');
	}
	
	Offline::complete($order_offline);
	json_return(0, '操作完成');
} else if ($_GET['action'] == 'store_offline_complate') {
	if(empty($wap_user)) {
		json_return(1000, '请先登录');
	}
	
	$order_id = $_POST['order_id'];
	
	if (empty($order_id)) {
		json_return(1000, '缺少最基本的参数');
	}
	
	$order_offline = D('Order_offline')->where(array('id' => $order_id, 'uid' => $wap_user['uid']))->find();
	if (empty($order_offline)) {
		json_return(1000, '未找到相应的订单');
	}
	
	if (empty($order_offline['check_status'])) {
		json_return(1000, '请等待审核');
	}
	
	if ($order_offline['check_status'] == 2) {
		json_return(1000, '订单未审核通过');
	}
	
	if (!empty($order_offline['status'])) {
		json_return(1000, '订单已完成，不须再次操作');
	}
	
	Offline::complete($order_offline);
	json_return(0, '操作成功');
}