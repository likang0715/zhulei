<?php
/**
 * 订单送他人，确认页面
 */
require_once dirname(__FILE__).'/global.php';
$order_id = $_GET['order_id'];

if (empty($order_id)) {
	if (IS_AJAX) {
		json_return(1000, '缺少参数');
	} else {
		pigcms_tips('缺少参数', 'none');
	}
}

$order = M('Order')->find($order_id);
if(empty($order)) {
	if (IS_AJAX) {
		json_return(1000, '订单不存在');
	} else {
		pigcms_tips('订单不存在','none');
	}
}

if ($order['uid'] != $_SESSION['wap_user']['uid']) {
	if (IS_AJAX) {
		json_return(1000, '订单不存在');
	} else {
		pigcms_tips('订单不存在','none');
	}
}

// 判断订单是否已经支付
if ($order['status'] > 1) {
	redirect('order.php?orderno=' . option('config.orderid_prefix') . $order['order_no']);
}

// 判断是否已经确认过送他人，无须确认页面
if ($order['status'] == 1) {
	redirect('order_friend_pay.php?order_id=' . option('config.orderid_prefix') . $order['order_no']);
}

// 判断是否为送他人订单，如果不是直接跳转普通订单支付页面
if ($order['shipping_method'] != 'send_other') {
	redirect('./pay.php?id=' . $order_id);
}

// 如果已经设定好赠送类型，直接进行支付页面
if (in_array($order['send_other_type'], array(1, 2, 3))) {
	redirect('./order_friend_pay.php?orderid=' . $order_id);
}

$store = M('Store')->getStore($order['store_id'], true);
$top_store_id = $store['top_supplier_id'] ? $store['top_supplier_id'] : $store['store_id'];
$commonweal_address = M('Commonweal_address')->find($top_store_id);

include display('order_friend_confirm');
echo ob_get_clean();
?>