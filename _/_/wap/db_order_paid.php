<?php

require_once dirname(__FILE__) . '/global.php';

$orderid = isset($_GET['orderid']) ? trim($_GET['orderid']) : '';
if (empty($orderid)) {
    pigcms_tips('非法访问', 'none');
}

// 获取订单信息/ 不判断是否是当前登录用户的订单 (允许代付)
$nowOrder = D('Unitary_order')->where(array('orderid'=>$orderid))->find();
if (empty($nowOrder)) {
    pigcms_tips('未找到对应活动订单', 'none');
}

$isMyOrder = 0;
if ($wap_user['uid'] == $nowOrder['uid']) {
	$isMyOrder = 1;
}

// 前往夺宝订单
$order_url = option('config.site_url').'/webapp/snatch/#/orderinfo/'.$nowOrder['store_id'];

// 支付按钮跳转
$send_url = option('config.site_url').'/wap/unitary_order.php?orderid='.$nowOrder['orderid'];

include display('db_order_paid');

echo ob_get_clean();
