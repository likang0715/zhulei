<?php

/**
 *  配送员主页
 */
require_once dirname(__FILE__) . '/courier_global.php';

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';


switch ($action) {
	case 'send':
		
		$package_id = isset($_POST['package_id']) ? $_POST['package_id'] : 0;
		if (empty($action) || empty($package_id)) {
			echo json_encode(array('status' => false, 'msg' => '请求参数错误'));
			exit;
		}

		$order_package = D('Order_package')->where(array('package_id'=>$package_id, 'store_id'=>$courier_info['store_id']))->find();
		if (empty($order_package)) {
			echo json_encode(array('status' => false, 'msg' => '请求参数错误'));
			exit;
		}

		if ($order_package['status'] != 1) {
			echo json_encode(array('status' => false, 'msg' => '状态错误'));exit;
		}

		$result = D('Order_package')->where(array('package_id'=>$package_id,'courier_id'=>$courier_info['courier_id']))->data(array('status'=>2, 'send_time'=>time()))->save();
		if ($result) {
			echo json_encode(array('status' => true, 'msg' => '开始配送成功',));exit;
		} else {
			echo json_encode(array('status' => false, 'msg' => '开始配送失败'));exit;
		}
		break;

	case 'arrive':

		$package_id = isset($_POST['package_id']) ? $_POST['package_id'] : 0;
		if (empty($action) || empty($package_id)) {
			echo json_encode(array('status' => false, 'msg' => '请求参数错误'));
			exit;
		}

		$order_package = D('Order_package')->where(array('package_id'=>$package_id, 'store_id'=>$courier_info['store_id']))->find();
		if (empty($order_package)) {
			echo json_encode(array('status' => false, 'msg' => '请求参数错误'));
			exit;
		}

		if ($order_package['status'] != 2) {
			echo json_encode(array('status' => false, 'msg' => '状态错误'));
			exit;
		}

		$result = D('Order_package')->where(array('package_id'=>$package_id,'courier_id'=>$courier_info['courier_id']))->data(array('status'=>3, 'arrive_time'=>time()))->save();
		if ($result) {
			echo json_encode(array('status' => true, 'msg' => '成功送达',));exit;
		} else {
			echo json_encode(array('status' => false, 'msg' => '设置送达失败'));exit;
		}
		break;
	
	case 'logout':
		if ($_SESSION['courier_session']) {
			unset($_SESSION['courier_session']);
			session_destroy();
		}

		pigcms_tips('请重新从微信进入', none);
	    // redirect('./wap.php?id=' . $store_id);
		break;
	default:
		echo json_encode(array('status' => false, 'msg' => '请求参数错误'));exit;
		break;
}



?>