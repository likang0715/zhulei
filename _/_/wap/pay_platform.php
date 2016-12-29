<?php
/**
 * 平台保证金
 */
require_once dirname(__FILE__) . '/global.php';

$order_no = $_GET['order_no'];
if (empty($order_no)) {
	pigcms_tips('该订单号不存在', 'none');
}

$platform_margin_log = D('Platform_margin_log')->where(array('order_no' => $order_no))->find();
if (empty($platform_margin_log) || $platform_margin_log['type'] != '0') {
	pigcms_tips('平台保证金充值订单不存在', 'none');
}

if ($platform_margin_log['status'] == '2') {
	pigcms_tips('此平台保证金充值订单已支付', 'none');
}

$store = D('Store')->where(array('store_id' => $platform_margin_log['store_id']))->find();
if (empty($store)) {
	pigcms_tips('未找到要充值的店铺', 'none');
}

$payment_methods_list = M('Config')->getPlatformPayMethod();
unset($payment_methods_list['allinpay']);

// 调用微信openid
if ($is_weixin && empty($_SESSION['platform_weixin_openid']) && isset($payment_methods_list['platform_weixin'])) {
	weixinpay();
}

include display('pay_platform');
echo ob_get_clean();


/**
 * 平台保证金微信支付授权
 */
function weixinpay() {
	if (empty($_SESSION['platform_weixin_openid'])) {
		$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		
		if (empty($_GET['code'])) {
			$_SESSION['platform_weixin']['state']   = md5(uniqid());
			$oauth_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . option('config.platform_wechat_appid') . '&redirect_uri=' . urlencode($url) . '&response_type=code&scope=snsapi_base&state=' . $_SESSION['platform_weixin']['state'] . '#wechat_redirect';
			redirect($oauth_url);
			exit;
		} else if (isset($_GET['code']) && isset($_GET['state']) && ($_GET['state'] == $_SESSION['platform_weixin']['state'])) {
			unset($_SESSION['platform_weixin']);
			import('Http');
			$http = new Http();
			
			$tokenUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . option('config.platform_wechat_appid') . '&secret=' . option('config.platform_wechat_appsecret') . '&code=' . $_GET['code'] . '&grant_type=authorization_code';
			$return = $http->curlGet($tokenUrl);
			$jsonrt = json_decode($return, true);
			
			if ($jsonrt['errcode']) {
				$error_msg_class = new GetErrorMsg();
				exit('授权发生错误：' . $jsonrt['errcode']);
			}
			
			if($jsonrt['openid']) {
				$_SESSION['platform_weixin_openid'] = $jsonrt['openid'];
			}
		}
	}
}