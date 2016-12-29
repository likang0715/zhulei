<?php

/**
 *  查看配送员位置
 */
require_once dirname(__FILE__) . '/global.php';	//换为global

$package_id = isset($_GET['package_id']) ? intval($_GET['package_id']) : 0;
$courier_id = isset($_GET['courier_id']) ? intval($_GET['courier_id']) : 0;

if (empty($package_id) || !$package_info = D('Order_package')->where(array('package_id'=>$package_id))->find()) {
	pigcms_tips('参数错误', 'none');
}

if (empty($courier_id) || !$courier_info = D('Store_physical_courier')->where(array('courier_id'=>$courier_id))->find()) {
	pigcms_tips('参数错误', 'none');
}

if ($courier_info['long'] == 0 || $courier_info['lat'] == 0) {
	pigcms_tips('未能获取配送员位置，请稍后再试', 'none');
}

$order_info = M('Order')->findOrderById($package_info['order_id']);
if(empty($order_info)) {
	pigcms_tips('该订单不存在','none');
}

//坐标转换 google -> baidu
import('Http');
$http_class = new Http();

$url = "http://api.map.baidu.com/geoconv/v1/?coords=".$courier_info['long'].",".$courier_info['lat']."&ak=4c1bb2055e24296bbaef36574877b4e2&output=json";
$map_json = $http_class->curlGet($url);
$location = json_decode($map_json, true);

if ($location['status'] != 0) {
	pigcms_tips('坐标转换错误', 'none');
}
// 配送员坐标
$long = $location['result'][0]['x'];
$lat = $location['result'][0]['y'];

// 门店坐标
$physical_info = M('Store_physical')->getOne($courier_info['physical_id']);
$order_info['address_arr']['address']['address'] = str_replace(' ', '', $order_info['address_arr']['address']['address']);

import('Http');
$http_class = new Http();
$url = "http://api.map.baidu.com/place/v2/search?q=".$order_info['address_arr']['address']['address']."&region=".$order_info['address_arr']['address']['city']."&output=json&ak=4c1bb2055e24296bbaef36574877b4e2";
$map_json = $http_class->curlGet($url);
$address_map = json_decode($map_json, true);

$points = array();
if (!empty($address_map)) {
	foreach ($address_map['results'] as $point) {
		$points[] = array("name"=>$point['name'], "lat"=>$point['location']['lat'], 'lng' => $point['location']['lng']);
	}
}

// 收货地址坐标(暂代)
if (empty($points)) {
	pigcms_tips('未搜索到地址位置', 'none');
}

$address_location = array_pop(array_reverse($points));
// dump($address_location);exit;
include display('courier_location');
echo ob_get_clean();

?>