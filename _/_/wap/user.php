<?php
/**
 *  用户资料
 */
require_once dirname(__FILE__).'/global.php';

if(empty($wap_user)) {
	if (!IS_AJAX) {
		redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
	} else {
		json_return(1000, '请登录');
	}
}

// 查找是否为当关店铺
$store_id = $_REQUEST['store_id'];
$store = M('Store')->getStoreById($store_id, $wap_user['uid']);

if (empty($store)) {
	if (!IS_AJAX) {
		pigcms_tips('未找到相应的店铺');
	} else {
		json_return(1000, '店铺不存在');
	}
}

// 登录处理
$action = $_GET['action'];
if ($action == 'search') {
	$nickname = $_POST['nickname'];
	
	if (empty($nickname)) {
		json_return(1000);
	}
	
	$user_list = D('User')->where("uid != '" . $wap_user['uid'] . "' AND status = 1 AND (nickname like '%" . $nickname . "%' OR phone like '%" . $nickname . "%')")->limit(3)->select();
	$json_data = array();
	if (empty($user_list)) {
		json_return(1000);
	}
	
	foreach ($user_list as $user) {
		$tmp = array();
		$tmp['uid'] = $user['uid'];
		$tmp['nickname'] = $user['nickname'] ? $user['nickname'] : ($user['phone'] ? $user['phone'] : $user['uid']);
		$tmp['avatar'] = $user['avatar'] ? getAttachmentUrl($user['avatar']) : getAttachmentUrl('images/touxiang.png', false);
		$json_data[] = $tmp;
	}
	
	json_return(0, $json_data);
} else if ($action == 'check') {
	$nickname = $_POST['nickname'];
	$type = $_POST['type'];
	$uid = $_POST['uid'];
	
	
	if (empty($nickname)) {
		json_return(1000, '请填写用户昵称');
	}
	
	$user = array();
	if ($type == 'uid') {
		$user = D('User')->where(array('uid' => $nickname))->find();
	} else {
		if (!empty($uid)) {
			$user = D('User')->where(array('nickname' => $nickname, 'uid' => $uid))->find();
		} else {
			$user = D('User')->where("nickname = '" . $nickname . "' OR phone = '" . $nickname . "'")->find();
		}
	}
	
	if (empty($user)) {
		json_return(1000, '未找到相应的用户');
	}
	
	$return = array();
	$return['uid'] = $user['uid'];
	$return['nickname'] = $user['nickname'] ? $user['nickname'] : ($user['phone'] ? $user['phone'] : $user['uid']);
	$return['avatar'] = $user['avatar'] ? getAttachmentUrl($user['avatar']) : getAttachmentUrl('images/touxiang.png', false);;
	
	json_return(0, $return);
} else if ($action == 'scan') {
	$uid = $_POST['uid'];
	$card = $_POST['card'];
	$scene = $_POST['scene'];
	
	if (empty($uid)) {
		json_return(1000, '请先扫一扫用户的二维码');
	}
	
	if ($card != 1 && $card != 2) {
		json_return(1000, '扫一扫只能扫描用户的会员卡二维码');
	}
	
	//扫码场景
	$scan_qrcode_scenario = strtonumber(option('config.site_url') . '/card');
	if ($scan_qrcode_scenario != $scene) {
		json_return(1006, '扫码场景有误，请扫描本站其它用户的会员卡');
	}
	
	$user = D('User')->where(array('uid' => $uid))->find();
	
	if ($user['uid'] == $store['uid']) {
		json_return(1000, '不能给自己手工做单');
	}
	
	$return = array();
	$return['uid'] = $uid;
	$return['nickname'] = $user['nickname'] ? $user['nickname'] : ($user['phone'] ? $user['phone'] : $user['uid']);
	$return['avatar'] = $user['avatar'] ? getAttachmentUrl($user['avatar']) : getAttachmentUrl('images/touxiang.png', false);
	
	json_return(0, $return);
}