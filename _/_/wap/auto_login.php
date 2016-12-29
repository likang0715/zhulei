<?php

/*
 * 自动登录
 */
require_once dirname(__FILE__) . '/global.php';

// 获取参数
$param = array();
$param['uid'] = $_REQUEST['uid'];
$param['openid'] = $_REQUEST['openid'];
$param['time'] = $_REQUEST['time'];
$param['type'] = $_REQUEST['type'];
$sign = $_REQUEST['sign'];
$referer = $_REQUEST['referer'];

if (empty($param['uid']) || empty($param['openid']) || empty($param['time']) || empty($param['type'])) {
	pigcms_tips('参数错误');
}

if (!in_array($param['type'], array('APP', 'WEIXIN'))) {
	pigcms_tips('来源非法');
}

if ($param['time'] + 60 < time()) {
	pigcms_tips('URL有效期已过');
}

$sign_salt = option('config.weidian_key') ? option('config.') : 'pigcms';

ksort($param);
$sign_key = sha1(http_build_query($param));

if ($sign_key != $sign) {
	pigcms_tips('来源非法');
}

$where = array();
$where['uid'] = $param['uid'];
$user = D('User')->where($where)->find();

if (($param['type'] == 'APP' && ($param['openid'] == $user['app_openid'] || $param['openid'] == 'pigcms')) || ($param['type'] == 'WEIXIN' && $param['openid'] == $user['openid'])) {
	$_SESSION['wap_user'] = $user;
	
	if ($param['type'] == 'WEIXIN') {
		$_SESSION['openid'] = $param['openid'];
	}
	
	if ($param['type'] == 'APP') {
		$_SESSION['app_login'] = true;
		echo '1';
		exit;
	}
	
	if (empty($referer)) {
		$referer = option('config.wap_site_url');
	}
	
	header('location: ' . $referer);
	exit;
} else {
	pigcms_tips('登录失败');
}