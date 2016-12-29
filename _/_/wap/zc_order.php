<?php

/**
 *  支付短信订单
 */
require_once dirname(__FILE__) . '/global.php';
$zcpay_no = $_GET['id'];
$nowOrder = D('Invest_order')->where(array('zcpay_no' => $zcpay_no))->find();
$time = $_SERVER['REQUEST_TIME'];
if (empty($nowOrder)){
	pigcms_tips('该订单号不存在', 'none');
}
if(empty($nowOrder['uid'])) {
	pigcms_tips("订单异常，未知购买者！",'none');
}

if($nowOrder['order_type'] == 1){
	if ($nowOrder['status'] == 2) {
		//已经支付
		pigcms_tips("已经支付",'none');
	}
} else {
	if($nowOrder['order_status'] == 2){
		//已经支付
		pigcms_tips("已经支付",'none');
	}
}






if($time - $nowOrder['time']>=86400) {
	pigcms_tips("该订单已过期！",'none');
}

//获取投资人信息
 $user = D('User_apply_invest')->where(array('uid'=>$nowOrder['uid']))->find();
//授权登陆
$now_user = M('User')->wap_getUser($nowOrder['uid']);

//付款方式
$payMethodLists = M('Config')->get_pay_method();

foreach($payMethodLists as $k=>$v) {
	if($k =='weixin') {
		$payMethodList[$k] = $v;
	}
}
//echo "<pre>";
//print_r($user);



if($nowOrder['order_type'] == 1){
	include display('zc_order');
} else {
	include display('zc_product_order');
}

echo ob_get_clean();