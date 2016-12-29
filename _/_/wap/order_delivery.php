<?php
/**
 * 订单确认收货
 */
require_once dirname(__FILE__).'/global.php';

$order_no = $_GET['order_no'];

if (empty($order_no)) {
	json_return(1001, '缺少参数');
}

$order = M('Order')->find($order_no);
if(empty($order)) {
	json_return(1001, '订单不存在');
}

if ($order['uid'] != $_SESSION['wap_user']['uid']) {
	json_return(1001, '请操作自己的订单');
}

if ($order['status'] != '3') {
	json_return(1001, '订单状态异常');
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

echo ob_get_clean();
?>