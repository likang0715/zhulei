<?php
/**
 * 代付订单支付跳转页面
 */
require_once dirname(__FILE__).'/global.php';
$peerid = $_GET['peerid'];

if (empty($peerid)) {
	pigcms('缺少参数', 'none');
}

$order_peerpay = D('Order_peerpay')->where(array('id' => $peerid))->find();
if(empty($order_peerpay)) {
	pigcms_tips('代付订单不存在','none');
}

$order = D('Order')->where(array('order_id' => $order_peerpay['order_id']))->find();

if (empty($order)) {
	pigcms_tips('订单不存在','none');
}

include display('order_share_paid');
echo ob_get_clean();
?>