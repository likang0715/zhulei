<?php
/**
 * 用户查看店铺手工做单
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
		$where .= " AND `check_status` = 0";
	} else if ($status == 2) {
		$where .= " AND `check_status` = 1 AND `status` = 0";
	} else if ($status == 3) {
		$where .= " AND `check_status` = 1 AND `status` = 1";
	} else if ($status == 4) {
		$where .= " AND `check_status` = 2";
	}
	
	$order_offline_list = D('Order_offline')->field('`id`, `dateline`, `order_no`, `store_id`, `total`, `cat_id`, `product_name`, `return_point`, `status`, `check_status`')->where($where)->order('`id` DESC')->limit($offset . ',' . $limit)->select();
	
	$store_list = array();
	foreach ($order_offline_list as &$order_offline) {
		$order_offline['dateline'] = date('Y-m-d H:i', $order_offline['dateline']);
		$order_offline['order_no'] = option('config.orderid_prefix') . $order_offline['order_no'];
		if ($order_offline['check_status'] == 0) {
			$order_offline['status_txt'] = '未审核';
		} else if ($order_offline['check_status'] == 1 && $order_offline['status'] == 0) {
			$order_offline['status_txt'] = '积分未发放';
		} else if ($order_offline['check_status'] == 1 && $order_offline['status'] == 1) {
			$order_offline['status_txt'] = '积分已发放';
		} else {
			$order_offline['status_txt'] = '审核不通过';
		}
		
		$order_offline['product_id'] = 0;
		$order_offline['product_image'] = getAttachmentUrl('images/default_product.png', true);
		
		if (!isset($store_list[$order_offline['store_id']])) {
			$store = D('Store')->where(array('store_id' => $order_offline['store_id']))->field('name')->find();
			if (empty($store)) {
				$store_list[$order_offline['store_id']] = '';
				$order_offline['store_name'] = '';
			} else {
				$store_list[$order_offline['store_id']] = $store['name'];
				$order_offline['store_name'] = $store['name'];
			}
		} else {
			$order_offline['store_name'] = $store_list[$order_offline['store_id']];
		}
	}
	
	$return = array();
	$return['order_list'] = $order_offline_list;
	$return['next_page'] = true;
	if (count($order_offline_list) < $limit) {
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

include display('store_offline_list');
echo ob_get_clean();

