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


$store_id = $_GET['id'];
$page = max(1, $_GET['page']);
$limit = 5;

//店铺资料
$now_store = M('Store')->wap_getStore($store_id);
if(empty($now_store)) pigcms_tips('您访问的店铺不存在','none');

$uid = $wap_user['uid'];

$where_sql = "`uid` = '$uid' AND `store_id` = '" . $store_id . "' AND user_rights_id = 0";

$count = M('Rights')->getCount($where_sql);

$rights_list = array();
$pages = '';
if ($count > 0) {
	$page = min($page, ceil($count / $limit));
	$offset = ($page - 1) * $limit;
	$where_sql = "r.uid = '$uid' AND r.store_id = '" . $store_id . "' AND r.user_rights_id = 0";
	$rights_list = M('Rights')->getList($where_sql, $limit, $offset);
	
	// 分页
	import('source.class.user_page');
	$user_page = new Page($count, $limit, $page);
	$pages = $user_page->show();
}

//分享配置 start
$share_conf 	= array(
	'title' 	=> option('config.site_name').'-用户中心', // 分享标题
	'desc' 		=> str_replace(array("\r","\n"), array('',''),  option('config.seo_description')), // 分享描述
	'link' 		=> 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], // 分享链接
	'imgUrl' 	=> option('config.site_logo'), // 分享图片
	'type'		=> '', // 分享类型,music、video或link，不填默认为link
	'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);
//分享配置 end

include display('rights');
echo ob_get_clean();
?>