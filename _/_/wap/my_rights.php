<?php
/**
 *  订单信息
 */
require_once dirname(__FILE__).'/global.php';

$action = $_POST['action'];
if ($action == 'cancel') {
	$id = $_POST['id'];
	if (empty($id)) {
		echo json_encode(array('status' => false, 'msg' => '缺少参数'));
		exit;
	}
	$rights = M('Rights')->getById($id);
	
	if (empty($rights)) {
		echo json_encode(array('status' => false, 'msg' => '未找到相应的维权'));
		exit;
	}
	
	if ($rights['uid'] != $_SESSION['wap_user']['uid']) {
		echo json_encode(array('status' => false, 'msg' => '请操作自己的维权'));
		exit;
	}
	
	if ($rights['status'] == 3) {
		echo json_encode(array('status' => false, 'msg' => '维权已完成，不能取消维权'));
		exit;
	}
	
	if ($rights['status'] == 10) {
		echo json_encode(array('status' => false, 'msg' => '维权已取消，无须再次取消'));
		exit;
	}
	
	$data = array();
	$data['status'] = 10;
	$data['user_cancel_dateline'] = time();
	$result = D('Rights')->where("user_rights_id = '" . $id . "' or id = '" . $id . "'")->data($data)->save();
	
	if ($result) {
		echo json_encode(array('status' => true, 'msg' => '取消维权成功',));
		exit;
	} else {
		echo json_encode(array('status' => false, 'msg' => '取消维权失败'));
		exit;
	}
	exit;
}

$page = max(1, $_GET['page']);
$limit = 5;


$uid = $wap_user['uid'];

$where_sql = "`uid` = '$uid' AND user_rights_id = 0";

$count = M('Rights')->getCount($where_sql);

$rights_list = array();
$pages = '';
if ($count > 0) {
	$page = min($page, ceil($count / $limit));
	$offset = ($page - 1) * $limit;
	$where_sql = "r.uid = '$uid' AND r.user_rights_id = 0";
	$rights_list = M('Rights')->getList($where_sql, $limit, $offset);
	
	// 分页
	import('source.class.user_page');
	$user_page = new Page($count, $limit, $page);
	$pages = $user_page->show();
}

include display('my_rights');
echo ob_get_clean();
?>