<?php

/**
 *  分销店铺对帐
 */
define('PIGCMS_PATH', dirname(__FILE__).'/../');
require_once PIGCMS_PATH.'source/init.php';
require_once 'functions.php';

if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
    $now = time();
    $timestamp = $_POST['request_time'];
    $sign_key = $_POST['sign_key'];
    unset($_POST['request_time']);
    unset($_POST['sign_key']);
    //$_POST['salt'] = SIGN_SALT;
    $_POST['salt'] = 'pigcms';
    if (!_checkSign($sign_key, $_POST)) {
        $error_code = 1003;
        $error_msg = '签名无效';
    } else {
	$checked  = 2;
	$order_id = intval(trim($_POST['order_id']));//分销商订单ID
	
	if (empty($order_id)) {
	    $error_code = 1001;
	    $error_msg = '请求失败';
	}
	
	$order_info = D('Order')->where(array('order_id'=>$order_id))->find();
	if(!$order_info){
	    $error_code = 1001;
	    $error_msg = '请求失败';
	}
	$store_id = $order_info['suppliers'];
	
	    $sql = "UPDATE " . option('system.DB_PREFIX') . "order SET is_check = '" . $checked . "' WHERE status = 4 AND is_check = 1 AND store_id IN (SELECT seller_id FROM " . option('system.DB_PREFIX') . "store_supplier WHERE FIND_IN_SET(" . $store_id . ", supply_chain)) AND (order_id = '" . $order_id . "' OR user_order_id = '" . $order_id . "')";
	if (D('')->execute($sql)) {
	    $error_code = 0;
	    $error_msg = '对账处理成功';
	} else {
	    $error_code = 1001;
	    $error_msg = '请求失败';
	}
    }
}


echo json_encode(array('error_code' =>$error_code , 'error_msg' => $error_msg));
exit;
?>
