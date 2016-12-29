<?php
/**
 * 维权申请
 */
require_once dirname(__FILE__).'/global.php';

$order_id = $_GET['order_id'];
$pigcms_id = $_GET['pigcms_id'];
$is_ajax = $_POST['is_ajax'];
if (empty($order_id) || empty($pigcms_id)) {
	if ($is_ajax) {
		echo json_encode(array('status' => false, 'msg' => '缺少最基本的参数'));
		exit;
	}
	pigcms_tips('缺少最基本的参数');
}

if (empty($_SESSION['wap_user'])) {
	if ($is_ajax) {
		echo json_encode(array('status' => false, 'data' => array('nexturl' => 'refresh')));
		exit;
	}
	redirect('./login.php?referer=' . urlencode($_SERVER['REQUEST_URI']));
}

// 只能查看自己的订单
$order_model = M('Order');
$order = $order_model->find($order_id);

if (empty($order)) {
	if ($is_ajax) {
		echo json_encode(array('status' => false, 'msg' => '未找到相应的订单'));
		exit;
	}
		
	pigcms_tips('未找到相应的订单');
}

if ($order['uid'] != $_SESSION['wap_user']['uid']) {
	if ($is_ajax) {
		echo json_encode(array('status' => false, 'msg' => '您无权查看此订单'));
		exit;
	}
	pigcms_tips('您无权查看此订单');
}

if (!in_array($order['status'], array(2, 3, 4, 7))) {
	if ($is_ajax) {
		echo json_encode(array('status' => false, 'msg' => '订单状态错误'));
		exit;
	}
	pigcms_tips('订单状态错误');
}

$order_product = D('')->table('Order_product AS op')->join('Product AS p ON p.product_id = op.product_id', 'left')->where("op.pigcms_id = '" . $pigcms_id . "'")->find();

if (empty($order_product)) {
	if ($is_ajax) {
		echo json_encode(array('status' => false, 'msg' => '未找到要维权的产品'));
		exit;
	}
	pigcms_tips('未找到要维权的产品');
}

if ($order_product['rights_status'] == 2) {
	if ($is_ajax) {
		echo json_encode(array('status' => false, 'msg' => '此产品已经申请维权了'));
		exit;
	}
	pigcms_tips('此产品已经申请维权了');
}

$type_arr = M('Rights')->rightsType();
// 根据退货数量，判断是否可以退货
$rights_number = M('Rights_product')->rightsNumber($order['order_id'], $pigcms_id);
if (IS_POST) {
	$type = $_POST['type'];
	$phone = $_POST['phone'];
	$content = trim($_POST['content']);
	$image_list = $_POST['images'];
	$number = max(0, $_POST['number'] + 0);
		
	if (!in_array($type, array(1, 2, 3))) {
		$type = 5;
	}
	
	if (empty($number)) {
		json_return(1001, '请至少维权一件商品');
	}
	
	if (strlen($content) == 0) {
		json_return(1001, '请填写维权说明');
	}
	
	if ($order_product['pro_num'] < $rights_number + $number) {
		json_return(1001, '维权数量超出购买数量');
	}
	
	import('source.class.RightsOrder');
	$data = array();
	$data['pigcms_id'] = $pigcms_id;
	$data['type'] = $type;
	$data['phone'] = $phone;
	$data['content'] = $content;
	$data['images'] = $image_list;
	$data['number'] = $number;
		
	$result = RightsOrder::apply($order, $data);
		
	if ($result) {
		json_return(0, '维权申请提交成功，请处理', $result);
	} else {
		json_return(1001, '维权申请失败，请重试');
	}
}

$now_store = M('Store')->wap_getStore($order['store_id']);
include display('rights_apply');

echo ob_get_clean();
?>