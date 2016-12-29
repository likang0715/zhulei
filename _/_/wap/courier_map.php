<?php

/**
 *  查看配送地址 - 地图
 */
require_once dirname(__FILE__) . '/courier_global.php';

$package_id = isset($_GET['pigcms_id']) ? $_GET['pigcms_id'] : 0;

$package_info = D('Order_package')->where(array('package_id'=>$package_id, 'courier_id'=>$courier_info['courier_id']))->find();

if (empty($package_info)) {
	pigcms_tips('参数错误', 'none');
}

$order_info = M('Order')->getOrder($courier_info['store_id'], $package_info['order_id']);
if (empty($order_info)) {
	pigcms_tips('参数错误', 'none');
}

// // 包裹的产品
// $order_product_ids = explode(",", $package_info["order_products"]);
// foreach ($order_product_ids as $op_id) {
//     $op_info = M('Order_product')->getImageProduct($op_id);
//     $op_info['sku_data'] = unserialize($op_info['sku_data']);
//     $package_info['order_product'][] = $op_info;

// }

$order_info['address'] = unserialize($order_info['address']);

$order_info['address_string'] = $order_info['address']['province'].' '.$order_info['address']['city'].' '.$order_info['address']['area'].' '.$order_info['address']['address'];
//门店信息
$physical_info = M('Store_physical')->getOne($courier_info['physical_id']);
$physical_info['images'] = getAttachmentUrl($physical_info['images']);

$order_info['address']['address'] = str_replace(' ', '', $order_info['address']['address']);

//查询地址
import('Http');
$http_class = new Http();
$url = "http://api.map.baidu.com/place/v2/search?q=".$order_info['address']['address']."&region=".$order_info['address']['city']."&output=json&ak=4c1bb2055e24296bbaef36574877b4e2";
$map_json = $http_class->curlGet($url);
$address_map = json_decode($map_json, true);

$points = array();
if (!empty($address_map)) {
	foreach ($address_map['results'] as $point) {
		$points[] = array("name"=>$point['name'], "lat"=>$point['location']['lat'], 'lng' => $point['location']['lng']);
	}
}

$points = json_encode($points, true);
include display('courier_map');
echo ob_get_clean();
?>