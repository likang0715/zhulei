<?php
/*
 * 平台保证金支付宝支付
 */
require_once dirname(__FILE__) . '/global.php';

$order_no = $_GET['order_no'];
if (empty($order_no)) {
	pigcms_tips('缺少参数', 'none');
}

$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

if ($_GET['status']) {
	$platform_margin_log = D('Platform_margin_log')->where(array('order_no' => $order_no))->find();
	if (empty($platform_margin_log) || $platform_margin_log['type'] != 0) {
		pigcms_tips('未找到要支付的平台保证金订单', 'none');
	}
	
	if ($platform_margin_log['status'] == 2) {
		pigcms_tips('平台保证金订单已支付', 'none');
	}
	
	if (empty($platform_margin_log['amount'])) {
		pigcms_tips('订单异常，请稍后再试', 'none');
	}
	
	$pay_method_list = M('Config')->getPlatformPayMethod();
	if (empty($pay_method_list['platform_alipay'])) {
		pigcms_tips('您选择的支付方式不存在<br/>请更新支付方式', 'none');
	}
	
	$trade_no = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
	D('Platform_margin_log')->where(array('order_no' => $order_no))->data(array('trade_no' => $trade_no))->save();
	
	// 订单信息
	$order = array();
	$order['order_no'] = $platform_margin_log['order_no'];
	$order['trade_no'] = 'PMPAY' . $trade_no;
	$order['total'] = $platform_margin_log['amount'];
	
	// 支付宝帐号信息
	$pay_method = array();
	$pay_method['pay_alipay_pid'] = option('config.platform_alipay_pid');
	$pay_method['pay_alipay_name'] = option('config.platform_alipay_name');
	$pay_method['pay_alipay_key'] = option('config.platform_alipay_key');
	
	import('source.class.pay.Alipay');
	$payClass = new Alipay($order, $pay_method, array());
	$payInfo = $payClass->pay();
} else {
	include display('alipay_iframe_pay');
}
?>
