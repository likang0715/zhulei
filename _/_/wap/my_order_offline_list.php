<?php
/**
 * 用户查看用户手工做单
 */
require_once dirname(__FILE__).'/global.php';

if(empty($wap_user)) {
	if (IS_AJAX) {
		json_return(1000, '请先登录');
	} else {
		redirect('./login.php?referer=' . urlencode($_SERVER['REQUEST_URI']));
	}
}

if ($_POST['ajax']) {
	// 操作分类
	$status = $_POST['status'];
	$page = max(1, $_POST['page']);
	$limit = 6;
	$offset = ($page - 1) * $limit;
	
	$where = "`uid` = '" . $wap_user['uid'] . "'";
	if ($status == 1) {
		$where .= " AND `status` in (2, 3, 7)";
	} else if ($status == 2) {
		$where .= " AND `status` = 4";
	}
	
	$order_list = D('Order')->field('`order_id`, `add_time`, `order_no`, `store_id`, `total`, `return_point`, `status`')->where($where)->order('`order_id` DESC')->limit($offset . ',' . $limit)->select();
	
	$store_list = array();
	foreach ($order_list as &$order) {
		$order['dateline'] = date('Y-m-d H:i', $order['add_time']);
		$order['order_no_txt'] = option('config.orderid_prefix') . $order['order_no'];
		if ($order['status'] != 4) {
			$order['status_txt'] = '未完成';
		} else {
			$order['status_txt'] = '已完成，积分已发放';
		}
		
		$order['product_id'] = 0;
		$order['product_image'] = getAttachmentUrl('images/default_product.png', true);
		$order['product_name'] = '用户手工做单';
		
		if (!isset($store_list[$order['store_id']])) {
			$store = D('Store')->where(array('store_id' => $order['store_id']))->field('name')->find();
			if (empty($store)) {
				$store_list[$order['store_id']] = '';
				$order['store_name'] = '';
			} else {
				$store_list[$order['store_id']] = $store['name'];
				$order['store_name'] = $store['name'];
			}
		} else {
			$order['store_name'] = $store_list[$order['store_id']];
		}
	}
	
	$return = array();
	$return['order_list'] = $order_list;
	$return['next_page'] = true;
	if (count($order_list) < $limit) {
		$return['next_page'] = false;
	}
	
	json_return(0, $return);
	exit;
}

$product_category_list_tmp = D('Product_category')->where(array('cat_status' => 1))->select();
$product_category_list = array();
foreach ($product_category_list_tmp as $product_category) {
	$tmp = array();
	$tmp['cat_id'] = $product_category['cat_id'];
	$tmp['cat_name'] = $product_category['cat_name'];
	$tmp['cat_fid'] = $product_category['cat_fid'];
	$product_category_list[$tmp['cat_id']] = $tmp;
}

$store = D('Store')->where(array('uid' => $wap_user['uid'], 'status' => 1, 'drp_level' => 0, 'root_supplier_id' => 0))->order('store_id ASC')->find();

include display('my_order_offline_list');
echo ob_get_clean();

