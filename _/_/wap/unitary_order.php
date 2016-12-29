<?php
/**
 *  夺宝活动订单
 */
require_once dirname(__FILE__) . '/global.php';
$orderid = isset($_GET['orderid']) ? $_GET['orderid'] : '';

if (empty($orderid) || !$nowOrder = D('Unitary_order')->where(array('orderid' => $orderid))->find()) {
	pigcms_tips('该夺宝订单不存在', 'none');
}

$time = $_SERVER['REQUEST_TIME'];

if(empty($nowOrder['uid'])) {
	pigcms_tips("订单异常，未知购买者！",'none');
}

if ($nowOrder['paid'] == 1) {
	// 跳转到订单详细页面
	$return_url = option('config.site_url').'/wap/db_order_paid.php?orderid='.$orderid;
	redirect($return_url);
}

// 找到多条夺宝记录的 活动名/商品名称
$cart_list = D('Unitary_cart')->where(array('order_id'=>$nowOrder['pigcms_id']))->select();
if (empty($cart_list)) {
	pigcms_tips("未找到相关活动",'none');
}

foreach ($cart_list as $key => $val) {
	$cart_list[$key]['unitary'] = M('Unitary')->getUnitary($val['unitary_id']);
}

$is_all_selfproduct = true;
$is_all_supplierproduct = true;

$now_store = M('Store')->wap_getStore($nowOrder['store_id']);

$userAddress = M('User_address')->find(session_id(), $wap_user['uid']);

// if($time - $nowOrder['addtime'] >= 15*60) {
// 	pigcms_tips("该订单超过15分钟，已过期！",'none');
// }

//授权登陆 ??
$now_user = M('User')->wap_getUser($nowOrder['uid']);

//付款方式
$payMethodLists = M('Config')->get_pay_method();
// dump($payMethodLists);exit;
foreach($payMethodLists as $k=>$v) {
	if($k =='weixin') {
		$payMethodList[$k] = $v;
	}
}

if ($payMethodList['weixin']) {
	$payMethodList['weixin']['name'] = '微信安全支付';
	$payList[1] = $payMethodList['weixin'];
}

if (option('config.open_test_payment')) {
	//本地测试使用(危险代码，正式上线时需删除)
	$payList[] = array('name' => '测试支付', 'type' => 'test');
}

include display('unitary_order');
echo ob_get_clean();