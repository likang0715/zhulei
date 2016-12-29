<?php
/**
 * 用户中心充值
 * liuqi
 * 2016-04-06
 */
require_once dirname(__FILE__).'/global.php';
$flag = (int)$_GET['flag'];
$store_id = (int)$_GET['store_id'];
$amount = (int)$_GET['amount'];
$store = D('Store')->field('store_id,name')->where(array('store_id' => $store_id, 'uid' => $wap_user['uid']))->find();
if(!$store){
	pigcms_tips('店铺不存在');
}

// 获取充值帐号
$payMethodList = M('Config')->getPlatformPayMethod();
if(empty($payMethodList)) {
	pigcms_tips('没有找到通联支付相关帐号，请联系客服');
}

if(!$flag){
	// 显示充值界面
	include display('recharge');
	echo ob_get_clean();
	exit;
}
// 开始充值
if($amount<=0){
	pigcms_tips('充值金额不正确');
}

if ($amount < option('credit.cash_min_amount')) {
	pigcms_tips('最低充值金额为' . option('credit.cash_min_amount') . '元');
}

$payConfig = $payMethodList['allinpay']['config'];
foreach($payConfig as $key_config => $item_config){
	$count_arrs = explode(',', $item_config);
	if(count($count_arrs)>1){
		$payConfig[$key_config] = $count_arrs[1];
	}else{
		$payConfig[$key_config] = $count_arrs[0];
	}
}
import('source.class.Margin');
Margin::init($store['store_id']);
$order_no = Margin::log($amount, 0, time(), 0, '', '充值保证金');

// 支付宝与微信支付时，跳转到保证金支付页面
if ($_GET['pay_type'] == 'platform_weixin' || $_GET['pay_type'] == 'platform_alipay') {
	redirect(option('config.wap_site_url') . '/pay_platform.php?order_no=' . $order_no);
	exit;
}

$order_info['product_name'] 			= '帐号充值';
$order_info['order_no']     			= $order_no;
$order_info['total']        			= $amount;
$order_info['pro_num']     				= 1;			// 商品数量，默认1
$pay_config['pay_allinpay_merchantid']  = $payConfig['pay_allinpay_merchantid'];
$pay_config['pay_allinpay_merchantkey'] = $payConfig['pay_allinpay_merchantkey'];
$userinfo['nickname'] 					= $store['name'];

// 参数校验
if($order_info['order_no']==''||$order_info['total']<=0||$pay_config['pay_allinpay_merchantid']==''||$pay_config['pay_allinpay_merchantkey']==''){
	pigcms_tips('参数错误，请联系客服');
}
$ismobile = is_mobile();
// 支付成功后的异步通知地址
$callback_url = option('config.site_url') . '/user.php?c=trade&a=margin_recharge_callback&pay_type=allinpay';	// 支付成功后的跳转地址
$notify_url = option('config.site_url') . '/api/margin_recharge_notify.php?pay_type=allinpay';					// 支付成功后的跳转地址
import('source.class.pay.Allinpay');
$payClass = new Allinpay($order_info,$pay_config, $userinfo,$ismobile,$callback_url, $notify_url);
$payInfo = $payClass->pay();
exit($payInfo['form']);