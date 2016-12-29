<?php
require_once dirname(__FILE__) . '/global.php';
$order_info['address_user'] 			= trim($_GET['address_user']);
$order_info['product_name'] 			= trim($_GET['product_name']);
$order_info['order_no']     			= trim($_GET['order_no']);
$order_info['total']        			= trim($_GET['total']);
$order_info['pro_num']     				= trim($_GET['pro_num']);
$pay_config['pay_allinpay_merchantid']  = trim($_GET['pay_allinpay_merchantid']);
$pay_config['pay_allinpay_merchantkey'] = trim($_GET['pay_allinpay_merchantkey']);
$userinfo['nickname'] 					= trim($_GET['nickname']);

// 参数校验
if($order_info['order_no']==''||$order_info['total']<=0||$pay_config['pay_allinpay_merchantid']==''||$pay_config['pay_allinpay_merchantkey']==''){
	pigcms_tips('参数错误，请联系客服');
}
$ismobile = is_mobile();
// 支付成功后的异步通知地址
$pickup_url = option('config.wap_site_url').'/paynotice.php?pay_type=allinpay'; 	// 支付成功后的跳转地址
$receive_url = option('config.wap_site_url').'/paynotice.php?pay_type=allinpay'; //异步通知地址
import('source.class.pay.Allinpay');
$payClass = new Allinpay($order_info,$pay_config, $userinfo,$ismobile,$pickup_url,$receive_url);
$payInfo = $payClass->pay();
exit($payInfo['form']);