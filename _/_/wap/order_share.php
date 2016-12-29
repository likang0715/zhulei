<?php
/**
 *  订单信息
 */
require_once dirname(__FILE__).'/global.php';
$order_id = $_GET['orderid'];
$is_ajax = $_POST['is_ajax'];

if (empty($order_id)) {
	if ($is_ajax) {
		json_return(1001, '缺少参数');
	} else {
		pigcms('缺少参数', 'none');
	}
}

$nowOrder = M('Order')->find($order_id);
if(empty($nowOrder)) {
	if ($is_ajax) {
		json_return(1001, '订单不存在');
	} else {
		pigcms_tips('订单不存在','none');
	}
}

if ($nowOrder['uid'] != $_SESSION['wap_user']['uid']) {
	if ($is_ajax) {
		json_return(0, './order_share_pay.php?orderid=' . $order_id);
	} else {
		redirect('./order_share_pay.php?orderid=' . $order_id);
	}
}

if ($nowOrder['payment_method'] != 'peerpay') {
	if ($is_ajax) {
		json_return(1001, '订单不是代付订单');
	} else {
		pigcms_tips('该订单不是代付订单', 'none');
	}
}

if ($nowOrder['peerpay_type'] == '1' || $nowOrder['peerpay_type'] == '2') {
	if ($is_ajax) {
		json_return(0, './order_share_pay.php?orderid=' . $order_id);
	} else {
		redirect('./order_share_pay.php?orderid=' . $order_id);
	}
}

if ($is_ajax) {
	$peerpay_content = $_POST['peerpay_content'];
	$type = $_POST['type'];
	
	if (!in_array($type, array('onepay', 'multipay'))) {
		$type = 'multipay';
	}
	
	$peerpay_type = 2;
	if ($type == 'onepay') {
		$peerpay_type = 1;
	}
	
	$data = array();
	$data['peerpay_type'] = $peerpay_type;
	$data['peerpay_content'] = $peerpay_content;
	$result = D('Order')->where(array('order_id' => $nowOrder['order_id']))->data($data)->save();
	
	if ($result) {
		json_return(0, './order_share_pay.php?orderid=' . $order_id . '&type=self');
	} else {
		json_return(1001, '保存失败');
	}
}

$store_pay_agent = D('Store_pay_agent')->where(array('type' => '0', 'store_id' => $nowOrder['store_id']))->order('rand()')->limit(1)->find();

include display('order_share');
echo ob_get_clean();
?>