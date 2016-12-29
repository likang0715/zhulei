<?php
/**
 * 退货详细
 */
require_once dirname(__FILE__).'/global.php';

// 添加快递信息
$action = $_POST['action'];
if ($action == 'express') {
	$id = $_REQUEST['id'];
	$express_code = $_POST['express_code'];
	$express_no = $_POST['express_no'];
	
	if (empty($id) || empty($express_code) || empty($express_no)) {
		json_return(1001, '缺少参数');
	}
	$return = M('Return')->getById($id);
	
	if (empty($return)) {
		json_return(1001, '未找到相应的退货');
	}
	
	if ($return['uid'] != $_SESSION['wap_user']['uid']) {
		json_return(1001, '请操作自己的退货申请');
	}
	
	if ($return['status'] != 3) {
		json_return(1001, '退货状态不正确');
		exit;
	}
	
	$express = D('Express')->where("code = '" . $express_code . "'")->find();
	if (empty($express)) {
		json_return(1001, '未找到相应的快递公司');
	}
	
	
	$data = array();
	$data['status'] = 4;
	$data['shipping_method'] = 'express';
	$data['express_code'] = $express_code;
	$data['express_company'] = $express['name'];
	$data['express_no'] = $express_no;
	$result = D('Return')->where("user_return_id = '" . $id . "' or id = '" . $id . "'")->data($data)->save();
	
	if ($result) {
		json_return(0, '操作成功');
	} else {
		json_return(1001, '操作失败');
	}
	exit;
}

$id = $_GET['id'];
$order_no = $_GET['order_no'];
$pigcms_id = $_GET['pigcms_id'];
if (empty($id) && (empty($order_no) || empty($pigcms_id))) {
	pigcms_tips('缺少参数！', 'none');
}

$return = array();
if (!empty($id)) {
	$return = M('Return')->getById($id);
	
	$where = "r.order_no = '" . $return['order_no'] . "' AND rp.order_product_id = '" . $return['order_product_id'] . "' AND r.id != '" . $return['id'] . "'";
	$return_list = M('Return')->getList($where);
} else {
	$order_no = trim($order_no, option('config.orderid_prefix'));
	$where = "r.order_no = '" . $order_no . "' AND rp.order_product_id = '" . $pigcms_id . "'";
	$return_list = M('Return')->getList($where);
		
	if ($return_list) {
		$return = $return_list[0];
		unset($return_list[0]);
	}
}

if (empty($return)) {
	pigcms_tips('未找到相应的退货！', 'none');
}

if ($return['uid'] != $_SESSION['wap_user']['uid']) {
	pigcms_tips('请查看自己的退货申请！', 'none');
}

$express_list = array();
if ($return['status'] == 3) {
	$express_list = D('Express')->select();
}

$store_id = $return['store_id'];
if (!empty($_GET['store_id'])) {
	$tmp_store_id = intval(trim($_GET['store_id']));
} else {
	$tmp_store_id = $store_id;
}
//店铺资料
$now_store = M('Store')->wap_getStore($tmp_store_id);
$order = M('Order')->findOrderById($return['order_id']);
include display('return_detail');

echo ob_get_clean();
?>