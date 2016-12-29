<?php

/**
 *  配送员主页
 */
require_once dirname(__FILE__) . '/courier_global.php';

$action = isset($_GET['action']) && in_array($_GET['action'], array('all', 'wait', 'send', 'arrive')) ? $_GET['action'] : 'all';
switch ($action) {
	case 'wait':
		$status_id = 0;
		break;
	case 'send':
		$status_id = 1;
		break;
	case 'arrive':
		$status_id = 2;
		break;
	default:
		break;
}

$orderby = '`add_time` DESC';
$where['courier_id'] = intval($courier_info['courier_id']);

if (isset($status_id)) {
	$where['status'] = $status_id;
}

//门店信息
$physical_info = M('Store_physical')->getOne($courier_info['physical_id']);
$physical_info['images'] = getAttachmentUrl($physical_info['images']);

//店铺信息
$store_info = M('Store')->getStore($courier_info['store_id']);

$packages = array();

//配送包裹列表
// $total = M('Order_package')->getPackageTotal($where);

// import('source.class.user_page');
// $page = new Page($total, 10);
// $packages = M('Order_package')->getPackageList($where, $orderby, $page->firstRow, $page->listRows);

// foreach ($packages as $key => $package) {
//     $order_product_ids = explode(",", $package["order_products"]);
//     foreach ($order_product_ids as $op_id) {
//         $packages[$key]['order_product'][] = M('Order_product')->getImageProduct($op_id);
//     }
//     $tmp_order = M("Order")->getOrder($courier_info['store_id'], $package['order_id']);
//     $tmp_order['address'] = unserialize($tmp_order['address']);
//     $packages[$key]['order'] = $tmp_order;

//     $courier = D('Store_physical_courier')->where(array("courier_id"=>$package['courier_id']))->find();
//     $packages[$key]['courier'] = !empty($courier) ? $courier['name'] : '';
// }


include display('courier_list');
echo ob_get_clean();
?>