<?php
/**
 * 订单代付
 */
require_once dirname(__FILE__).'/global.php';
$order_id = $_GET['orderid'];
$type = $_GET['type'];
$is_ajax = $_POST['is_ajax'];

if (empty($order_id)) {
	if ($is_ajax) {
		json_return(1001, '缺少参数');
	} else {
		pigcms('缺少参数', 'none');
	}
}

$nowOrder = M('Order')->find($order_id);
if(empty($nowOrder)) {
	if ($is_ajax) {
		json_return(1001, '订单不存在');
	} else {
		pigcms_tips('订单不存在','none');
	}
}

if ($nowOrder['payment_method'] != 'peerpay') {
	if ($is_ajax) {
		json_return(1001, '订单不是代付订单');
	} else {
		pigcms_tips('该订单不是代付订单', 'none');
	}
}

$order_over = false;
if ($nowOrder['status'] > 1) {
	if ($nowOrder['uid'] != $_SESSION['wap_user']['uid']) {
		$order_over = true;
	} else {
		redirect('./order.php?orderid=' . $nowOrder['order_id']);
	}
}

$peerpay_custom_field = D('Custom_field')->where(array('store_id' => $nowOrder['store_id'], 'module_name' => 'peerpay'))->find();

if (empty($peerpay_custom_field)) {
	$peerpay_custom_field['txt_color'] = '#FFFFFF';
	$peerpay_custom_field['img'] = '';
} else {
	$tmp = unserialize($peerpay_custom_field['content']);
	$peerpay_custom_field['txt_color'] = $tmp['color'];
	$peerpay_custom_field['img'] = getAttachmentUrl($tmp['img']);
}
$peerpay_custom_field['color'] = '#a0bf54';

$peerpay_money = M('Order_peerpay')->sumMoney($nowOrder['order_id']);

if ($nowOrder['total'] == 0) {
	$peerpay_money_per = '0%';
} else {
	$peerpay_money_per = ceil($peerpay_money / $nowOrder['total'] * 100) . '%';
}

$store_pay_agent = D('Store_pay_agent')->where(array('type' => '0', 'store_id' => $nowOrder['store_id']))->order('rand()')->limit(1)->find();

$is_pay_btn = true;
if ($type != 'self' || $nowOrder['uid'] != $_SESSION['wap_user']['uid']) {
	if (!$order_over && $peerpay_money < $nowOrder['total']) {
		if(empty($_GET['code'])){
			$_SESSION['weixin']['state'] = md5(uniqid());
			$customeUrl = 'http://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$oauthUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . option('config.wechat_appid') . '&redirect_uri=' . urlencode($customeUrl).'&response_type=code&scope=snsapi_userinfo&state=' . $_SESSION['weixin']['state'].'#wechat_redirect';
			redirect($oauthUrl);
			exit;
		} else if(isset($_GET['code']) && isset($_GET['state']) && ($_GET['state'] == $_SESSION['weixin']['state'])){
			unset($_SESSION['weixin']);
			import('Http');
			$http = new Http();
			$return = $http->curlGet('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.option('config.wechat_appid').'&secret='.option('config.wechat_appsecret').'&code='.$_GET['code'].'&grant_type=authorization_code');
			$jsonrt = json_decode($return,true);
			if($jsonrt['errcode']){
				$error_msg_class = new GetErrorMsg();
				if ($is_ajax) {
					json_return(1001, '授权发生错误：' . $jsonrt['errcode']);
				} else {
					pigcms_tips('授权发生错误：' . $jsonrt['errcode'], 'none');
				}
			}
			if($jsonrt['openid']){
				$_SESSION['PLATFORM_OPENID'] = $jsonrt['openid'];
			}
		}
	}
} else {
	$is_pay_btn = false;
}

$money_cha = sprintf("%.2f", max(0, $nowOrder['total'] - $peerpay_money));
$money_fu = sprintf("%.2f", max(0, $nowOrder['total'] - $peerpay_money > 1 ? 1 : $nowOrder['total'] - $peerpay_money));
$money_max = sprintf("%.2f", max(0, $nowOrder['total'] - $peerpay_money));

if ($nowOrder['peerpay_type'] == 1) {
	$money_fu = $money_max;
}

//分享配置 start
$share_conf 	= array(
		'title' 	=> '我想对你说：', // 分享标题
		'desc' 		=> str_replace(array("\r","\n"), array('',''), $nowOrder['peerpay_content']), // 分享描述
		'link' 		=> option('config.wap_site_url') . '/order_share_pay.php?orderid=' . $order_id, // 分享链接
		'imgUrl' 	=> getAttachmentUrl($_SESSION['user']['avatar']), // 分享图片链接
		'type'		=> '', // 分享类型,music、video或link，不填默认为link
		'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);

import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);

include display('order_share_pay');
echo ob_get_clean();
?>