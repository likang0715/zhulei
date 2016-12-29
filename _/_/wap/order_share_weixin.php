<?php
/**
 *  代付支付
 */
require_once dirname(__FILE__).'/global.php';

$order_id = $_POST['order_id'];
$name = $_POST['name'];
$content = $_POST['content'];
$money = $_POST['money'];

if (empty($order_id)) {
	json_return(1001, '缺少参数');
}

$nowOrder = M('Order')->find($order_id);
if(empty($nowOrder)) {
	json_return(1001, '订单不存在');
}

if ($nowOrder['payment_method'] != 'peerpay') {
	json_return(1001, '订单不是代付订单');
}

$peerpay_money = M('Order_peerpay')->sumMoney($nowOrder['order_id']);

$pay_money = $nowOrder['total'] - $peerpay_money;

if ($pay_money <= 0) {
	json_return(1001, '订单已经支付满额了，无须您的支付');
}

if ($nowOrder['peerpay_type'] == '1' && $pay_money > $money) {
	json_return(1001, '请支付' . ($nowOrder['total'] - $peerpay_money));
}

import('source.class.pay.Weixin');
$openid = $_SESSION['PLATFORM_OPENID'];

if (empty($openid)) {
	json_return(1012,'微信支付没有配置，请联系网站管理人员');
}



$payMethodList = M('Config')->get_pay_method();

$payType = 'weixin';
if(empty($payMethodList[$payType])){
	json_return(1012,'微信支付没有配置，请联系网站管理人员');
}

// 产生代付订单
$data = array();
$data['dateline'] = time();
$data['order_id'] = $nowOrder['order_id'];
$data['peerpay_no'] = 'PEERPAY_' . date('YmdHis') . mt_rand(100000,999999);
$data['money'] = $money;
$data['name'] = $name;
$data['content'] = $content;
$data['status'] = 0;

$result = D('Order_peerpay')->data($data)->add();

if (empty($result)) {
	json_return(1001, '代付失败');
}

$order = array();
$order['order_no_txt'] = option('config.orderid_prefix') . $data['peerpay_no'];
$order['trade_no'] = $data['peerpay_no'];
$order['total'] = $money;

$payClass = new Weixin($order, $payMethodList[$payType]['config'], $wap_user, $openid);
$payInfo = $payClass->pay();
if($payInfo['err_code']){
	json_return(1013, $payInfo['err_msg']);
}else{
	json_return(0, json_decode($payInfo['pay_data']), $result);
}
