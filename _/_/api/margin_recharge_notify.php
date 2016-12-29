<?php
/**
 * 后台保证金充值回调
 */
define('PIGCMS_PATH', dirname(__FILE__).'/../');
require_once PIGCMS_PATH . 'source/init.php';
require_once PIGCMS_PATH . 'source/class/Margin.class.php';
require_once PIGCMS_PATH . 'source/class/pay/Allinpay.class.php';

$payment_method = !empty($_REQUEST['pay_type']) ? $_REQUEST['pay_type'] : '';
$payment_methods = M('Config')->get_pay_method();
$payConfig = $payment_methods['allinpay']['config'];
foreach($payConfig as $key_config => $item_config){
	$count_arrs = explode(',', $item_config);
	if(count($count_arrs)>1){
		$payConfig[$key_config] = $count_arrs[1];
	}else{
		$payConfig[$key_config] = $count_arrs[0];
	}
}
$pay_config['pay_allinpay_merchantid']  = $payConfig['pay_allinpay_merchantid'];
$pay_config['pay_allinpay_merchantkey'] = $payConfig['pay_allinpay_merchantkey'];

if (IS_POST) {
	if (strtolower($payment_method) == 'allinpay') {
		$payClass = new Allinpay(array(), $pay_config, array(), 0);
		$payInfo = $payClass->return_url();
		$status = 2; //已处理

		$log = D('Platform_margin_log')->where(array('order_no' => $payInfo['order_param']['order_no']))->find();
		if (!empty($log) && $payInfo['err_code'] == 0) {
			Margin::init($log['store_id']);
			Margin::recharge($payInfo['order_param']['order_no'], $payInfo['order_param']['third_id'], $payInfo['order_param']['pay_money'], $payInfo['order_param']['pay_type'], $status);
			exit('success');
		} else {
			exit('faild');
		}
	}
	exit('faild');
}