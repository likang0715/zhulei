<?php

/**
 *  查看配送员位置
 */
require_once dirname(__FILE__) . '/courier_global.php';	//换为global

$package_id = isset($_GET['package_id']) ? $_GET['package_id'] : 0;
if (empty($package_id) || !$package_info = D('Order_package')->where(array('package_id'=>$package_id, 'courier_id'=>$courier_info['courier_id']))->find()) {
	pigcms_tips('参数错误', 'none');
}
// 订单信息
$order_info = M('Order')->getOrder($courier_info['store_id'], $package_info['order_id']);
$order_info['address'] = unserialize($order_info['address']);

// 查看所有包裹
$total_count = M('Order_package')->getPackageTotal(array('order_id'=>$package_info['order_id']));

// 包裹产品列表
$order_product = array();
$order_product_ids = explode(",", $package_info["order_products"]);
foreach ($order_product_ids as $op_id) {
    $op_info = M('Order_product')->getImageProduct($op_id);
    $op_info['sku_data'] = unserialize($op_info['sku_data']);
    $order_product[] = $op_info;
}
// dump($order_product);exit;

include display('courier_detail');
echo ob_get_clean();

?>