<?php
/**
 *  配送员ajax
 */
require_once dirname(__FILE__) . '/courier_global.php';

$action = $_GET['action'];

switch ($action) {
	case 'package_list':

		$status_action = isset($_POST['status_action']) && in_array($_POST['status_action'], array('all', 'wait', 'send', 'arrive')) ? $_POST['status_action'] : 'all';
		$page_num = isset($_POST['page']) ? intval($_POST['page']) : 1;

		if ($status_action == 'wait') {
			$where['status'] = 1;
		} else if ($status_action == 'send') {
			$where['status'] = 2;
		} else if ($status_action == 'arrive') {
			$where['status'] = 3;
		}

		$orderby = '`add_time` DESC';
		$where['courier_id'] = intval($courier_info['courier_id']);

		//配送包裹列表
		$json_return['count'] = M('Order_package')->getPackageTotal($where);

		$packages = M('Order_package')->getPackageList($where, $orderby, (($page_num-1)*10), 10);
		foreach ($packages as $key => $package) {
		    $order_product_ids = explode(",", $package["order_products"]);
		    foreach ($order_product_ids as $op_id) {
		        $packages[$key]['order_product'][] = M('Order_product')->getImageProduct($op_id);
		    }
		    $tmp_order = M("Order")->getOrder($courier_info['store_id'], $package['order_id']);
		    $tmp_order['address'] = unserialize($tmp_order['address']);
		    $packages[$key]['order'] = $tmp_order;

		    $courier = D('Store_physical_courier')->where(array("courier_id"=>$package['courier_id']))->find();
		    $packages[$key]['courier'] = !empty($courier) ? $courier['name'] : '';
		}

		$json_return['list'] = $packages;

		if(count($json_return['list']) < 10){
			$json_return['noNextPage'] = true;
		}

		json_return(0,$json_return);
		break;
	case 'location':

		$data['long'] = isset($_POST['long']) ? trim($_POST['long']) : 0;
		$data['lat'] = isset($_POST['lat']) ? trim($_POST['lat']) : 0;

		if (empty($courier_info) || empty($data['long']) || empty($data['lat'])) {
			json_return(1, '缺少参数');
		}

		$time = time();
		$c_info = D("Store_physical_courier")->where(array('courier_id'=>$courier_info['courier_id']))->find();
		if (empty($c_info) || ($time - $c_info['location_time'] < 30)) {
			json_return(0, '过于频繁，30秒一传');
		}

		$data = array_merge($data, array('location_time'=>time()));
		$result = D('Store_physical_courier')->where(array('courier_id'=>$courier_info['courier_id']))->data($data)->save();
		if ($result) {
			json_return(0, '上传成功');
		} else {
			json_return(1, '上传失败');
		}

		break;
	default:
		# code...
		break;
}

echo ob_get_clean();
?>