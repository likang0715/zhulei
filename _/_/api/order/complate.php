<?php
/**
 * 订单
 */
define('PIGCMS_PATH', dirname(__FILE__).'/../../');
require_once PIGCMS_PATH.'source/init.php';
require_once '../functions.php';
import('source.class.Order');

if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
    $now = time();
    $timestamp = $_POST['timestamp'];
    $sign_key = $_POST['sign_key'];
    unset($_POST['timestamp']);
    unset($_POST['sign_key']);
    $_POST['salt'] = option('config.service_key');
    if (!_checkSign($sign_key, $_POST)) {
        $error_code = 1002;
        $error_msg = '签名无效';
    } else if (($now - $timestamp) > 300) { //5分钟请求过期
        $error_code = 1003;
        $error_msg = '请求已过期，请重新访问。';
    } else if (strtolower($_POST['api']) != 'order/complate') {
        $error_code = 1005;
        $error_msg = '无效的请求地址。';
    } else if (empty($_POST['order_id']) || empty($_POST['store_id'])) {
        $error_code = 1006;
        $error_msg = '缺少必要的参数。';
    } else {
        $order_id = intval($_POST['order_id']);
        $store_id = intval($_POST['store_id']);
        $result = Order::complate($order_id, $store_id);
        if (!empty($result)) {
            $error_code = $result['err_code'];
            $error_msg = $result['err_msg'];
        } else {
            $error_code = 1007;
            $error_msg = '交易完成失败。';
        }
    }
} else {
    $error_code = 1001;
    $error_msg = '请求失败';
    $orders = array();
}
echo json_encode(array('error_code' => $error_code, 'error_msg' => $error_msg));
exit;