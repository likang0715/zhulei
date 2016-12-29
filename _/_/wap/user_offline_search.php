<?php
/**
 * 用户做单前搜索页
 */
require_once dirname(__FILE__).'/global.php';

if(empty($wap_user)) {
	if (IS_AJAX) {
		json_return(1000, '请先登录');
	} else {
		redirect('./login.php?referer=' . urlencode($_SERVER['REQUEST_URI']));
	}
}

if ($_GET['action'] == 'search') {
	$phone = $_GET['phone'];
	if (empty($phone)) {
		json_return(1000, '请填写商家的手机号');
	}
	
	$user = D('User')->where(array('phone' => $phone))->find();
	$where_sql = "drp_level = 0 AND status = 1";
	if (!empty($user)) {
		$where_sql .= " AND (tel = '" . $phone . "' OR uid = '" . $user['uid'] . "')";
	} else {
		$where_sql .= " AND tel = '" . $phone . "'";
	}
	
	$store_list = D('Store')->where($where_sql)->field("store_id, name")->select();
	json_return(0, array('store_list' => $store_list));
}

//分享配置 start
$share_conf 	= array(
		'title' 	=> option('config.site_name').'-用户做单', // 分享标题
		'desc' 		=> str_replace(array("\r","\n"), array('',''),   option('config.seo_description')), // 分享描述
		'link' 		=> 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], // 分享链接
		'imgUrl' 	=> option('config.site_logo'), // 分享图片链接
		'type'		=> '', // 分享类型,music、video或link，不填默认为link
		'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);


$share_conf = array(
		'title'    => $user_info['nickname'], // 分享标题
		'desc'     => str_replace(array("\r", "\n"), array('', ''), $user_info['nickname']), // 分享描述
		'link'     => $config['wap_site_url'] . '/my_point.php', // 分享链接
		'imgUrl'   => '', // 分享图片链接
		'type'     => '', // 分享类型,music、video或link，不填默认为link
		'dataUrl'  => '', // 如果type是music或video，则要提供数据链接，默认为空
		'store_id' => '',
		'uid'      => ''
);

import('WechatShare');
$share = new WechatShare();
$share_data = $share->getSgin($share_conf);

$scene = strtonumber(option('config.site_url') . '/card');

include display('user_offline_search');
echo ob_get_clean();