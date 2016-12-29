<?php
/**
 * 平台保证金
 */
require_once dirname(__FILE__).'/global.php';

$order_no = $_GET['order_no'];
if (empty($order_no)) {
	pigcms_tips('缺少参数', 'none');
}

$order_no = trim($order_no, option('config.orderid_prefix'));
$platform_margin_log = D('Platform_margin_log')->where(array('order_no' => $order_no))->find();
if(empty($platform_margin_log)) {
	pigcms_tips('平台保证金订单不存在', 'none');
}

$payment_method_arr = array('weixin' => '微信支付', 'alipay' => '支付宝支付');
$platform_margin_log['payment_method_txt'] = isset($payment_method_arr[$platform_margin_log['payment_method']]) ? $payment_method_arr[$platform_margin_log['payment_method']] : '其它';

include display('order_platform');
echo ob_get_clean();