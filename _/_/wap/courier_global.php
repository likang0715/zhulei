<?php

/**
 *  配送员session
 */
define('PIGCMS_PATH', dirname(__FILE__).'/../');
define('DEBUG',true);
define('GROUP_NAME','wap');
define('IS_SUB_DIR',true);
require_once PIGCMS_PATH.'source/init.php';

$is_weixin = is_weixin();

$courier_info = array();

if (empty($_SESSION['courier_session'])) {
	$openid = isset($_GET['openid']) ? $_GET['openid'] : pigcms_tips('您输入的网址有误，请从微信重新进入', 'none');
	$courier = D('Store_physical_courier')->where(array("openid"=>$openid))->find();

	if (empty($courier)) {
		pigcms_tips('该配送员不存在', 'none');
	}

	$_SESSION['courier_session'] = $courier;
}

$courier_info = $_SESSION['courier_session'];