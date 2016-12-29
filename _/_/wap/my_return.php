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
	$return = M('Return')->getById($id);
	
	if (empty($return)) {
		echo json_encode(array('status' => false, 'msg' => '未找到相应的退货'));
		exit;
	}
	
	if ($return['uid'] != $_SESSION['wap_user']['uid']) {
		echo json_encode(array('status' => false, 'msg' => '请操作自己的退货申请'));
		exit;
	}
	
	if ($return['status'] >= 4) {
		echo json_encode(array('status' => false, 'msg' => '不能取消退货申请'));
		exit;
	}
	
	$data = array();
	$data['status'] = 6;
	$data['user_cancel_dateline'] = time();
	$result = D('Return')->where("user_return_id = '" . $id . "' or id = '" . $id . "'")->data($data)->save();
	
	if ($result) {
		echo json_encode(array('status' => true, 'msg' => '取消退货成功',));
		exit;
	} else {
		echo json_encode(array('status' => false, 'msg' => '取消退货失败'));
		exit;
	}
	exit;
}

$page = max(1, $_GET['page']);
$limit = 5;


$uid = $wap_user['uid'];

$where_sql = "`uid` = '$uid' AND user_return_id = 0";

$count = M('Return')->getCount($where_sql);

$return_list = array();
$pages = '';
if ($count > 0) {
	$page = min($page, ceil($count / $limit));
	$offset = ($page - 1) * $limit;
	$where_sql = "r.uid = '$uid' AND r.user_return_id = 0";
	$return_list = M('Return')->getList($where_sql, $limit, $offset);
	
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

include display('my_return');
echo ob_get_clean();
?>