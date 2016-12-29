<?php
/**
 *  订单信息
 */
require_once dirname(__FILE__).'/global.php';

if(empty($wap_user)) {
	if (IS_AJAX) {
		json_return(1000, '请先登录');
	} else {
		redirect('./login.php?referer=' . urlencode($_SERVER['REQUEST_URI']));
	}
}

// 当前用户登录UID
$current_uid = $wap_user['uid'];
$store_id = $_GET['store_id'];

if (empty($store_id)) {
	if (IS_AJAX) {
		json_return(1000, '缺少参数');
	} else {
		pigcms_tips('缺少参数');
	}
}

$store = M('Store')->getStoreById($store_id, $current_uid);
if (empty($store)) {
	if (IS_AJAX) {
		json_return(1000, '未找到相应店铺');
	} else {
		pigcms_tips('未找到相应店铺');
	}
}

// 显示订单
if ($_POST['ajax'] == "1") {
	// 操作分类
	$status = $_POST['status'];
	$page = max(1, $_POST['page']);
	$limit = 4;
	$offset = ($page - 1) * $limit;
	
	$where = "`store_id` = '" . $store_id . "'";
	if ($status == 1) {
		$where .= " AND `check_status` = 0";
	} else if ($status == 2) {
		$where .= " AND `check_status` = 1 AND `status` = 0";
	} else if ($status == 3) {
		$where .= " AND `check_status` = 1 AND `status` = 1";
	} else if ($status == 4) {
		$where .= " AND `check_status` = 2";
	}
	
	$order_offline_list = D('Order_offline')->field('`id`, `dateline`, `order_no`, `uid`, `store_id`, `total`, `cat_id`, `product_name`, `return_point`, `status`, `check_status`')->where($where)->order('`id` DESC')->limit($offset . ',' . $limit)->select();
	
	$user_list = array();
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
	
		if (!isset($user_list[$order_offline['uid']])) {
			$user = D('User')->where(array('uid' => $order_offline['uid']))->field('nickname, phone')->find();
			if (empty($user)) {
				$user_list[$order_offline['uid']] = '匿名';
				$order_offline['user_name'] = '匿名';
			} else {
				$user_list[$order_offline['uid']] = $user['nickname'];
				$order_offline['user_name'] = $user['nickname'];
			}
		} else {
			$order_offline['user_name'] = $user_list[$order_offline['uid']];
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

include display('my_offline_list');
echo ob_get_clean();
