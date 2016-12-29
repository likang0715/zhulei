<?php

/**
 *  支付短信订单
 */
require_once dirname(__FILE__) . '/global.php';
$smspay_no = $_GET['id'];
$nowOrder = D('Order_sms')->field('`smspay_no`,`status`,`uid`,`money`,`sms_num`,`sms_price`,`dateline`')->where(array('smspay_no' => $smspay_no))->find();

$time = time();
if (empty($nowOrder)){
	 pigcms_tips('该订单号不存在', 'none');
}
if(!$nowOrder['uid']) {
	pigcms_tips("订单异常，未知购买者！",'none');
}

if ($nowOrder['status'] == 1) {
	//已经支付
	 redirect('./order.php?orderno=' . $_GET['id']);
} 
if($time - $nowOrder['dateline']>=86400) {
	
	pigcms_tips("该短信订单已过期！",'none');
}


//获取购买人信息
 $user = D('User')->where(array('uid'=>$nowOrder['uid']))->find();
//授权登陆
$now_user = M('User')->wap_getUser($nowOrder['uid']);
//dump($now_user);
//付款方式
$payMethodLists = M('Config')->get_pay_method();

foreach($payMethodLists as $k=>$v) {
	if($k =='weixin') {
		$payMethodList[$k] = $v;
	}
}
//echo "<pre>";
//print_r($user);

include display('pay_by_sms');
echo ob_get_clean();