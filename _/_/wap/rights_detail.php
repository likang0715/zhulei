<?php
/**
 * 退货详细
 */
require_once dirname(__FILE__).'/global.php';

$id = $_GET['id'];
$order_no = $_GET['order_no'];
$pigcms_id = $_GET['pigcms_id'];
if (empty($id) && (empty($order_no) || empty($pigcms_id))) {
	pigcms_tips('缺少参数！', 'none');
}

$rights = array();
if (!empty($id)) {
	$rights = M('Rights')->getById($id);
} else {
	$order_no = trim($order_no, option('config.orderid_prefix'));
	$where = "r.order_no = '" . $order_no . "' AND rp.order_product_id = '" . $pigcms_id . "'";
	$rights_list = M('Rights')->getList($where);
		
	if ($rights_list) {
		$rights = $rights_list[0];
	}
}

if (empty($rights)) {
	pigcms_tips('未找到相应的维权！', 'none');
}

if ($rights['uid'] != $_SESSION['wap_user']['uid']) {
	pigcms_tips('请查看自己的维权申请！', 'none');
}

$store_id = $rights['store_id'];
if (!empty($_GET['store_id'])) {
	$tmp_store_id = intval(trim($_GET['store_id']));
} else {
	$tmp_store_id = $store_id;
}
//店铺资料
$now_store = M('Store')->wap_getStore($tmp_store_id);

$order = M('Order')->findOrderById($rights['order_id']);
include display('rights_detail');

echo ob_get_clean();
?>