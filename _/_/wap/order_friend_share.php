<?php
/**
 * 订单送他人，分享页
 */
require_once dirname(__FILE__).'/global.php';
$order_id = $_GET['order_id'];

if (empty($order_id)) {
	if (IS_AJAX) {
		json_return(1000, '缺少参数');
	} else {
		pigcms_tips('缺少参数', 'none');
	}
}

$order = M('Order')->find($order_id);
if (empty($order)) {
	if (IS_AJAX) {
		json_return(1000, '订单不存在');
	} else {
		pigcms_tips('订单不存在','none');
	}
}

// 检查是否是送他人订单
if ($order['shipping_method'] != 'send_other') {
	if (IS_AJAX) {
		json_return(1000, '此订单不是送他人订单');
	} else {
		pigcms_tips('此订单不是送他人订单');
	}
}

// 检查订单送他人类型，订单送他人类型优先于参数
if (!in_array($order['send_other_type'], array(1, 3))) {
	if (IS_AJAX) {
		json_return(1000, '送他人类型错误');
	} else {
		pigcms_tips('送他人类型错误', 'none');
	}
}

// 检查订单状态是否正确
if (!in_array($order['status'], array(2, 3, 4, 7))) {
	if (IS_AJAX) {
		json_return(1000, '订单状态不正确');
	} else {
		pigcms_tips('订单状态不正确', 'none');
	}
}

// 检查订单可送的有效时间
$share_valid = true;
$count = D('Order_friend_address')->where(array('order_id' => $order['order_id']))->count('id');
if ($count >= $order['send_other_number']) {
	$share_valid = false;
	if (IS_AJAX) {
		json_return(1000, '您来晚了，礼物全部被领完了');
	}
}

// 检查是否提交
if (IS_AJAX) {
	if (empty($_SESSION['PLATFORM_OPENID'])) {
		json_return(1000, '状态错误，请刷新页面再试');
	}
	
	if (time() - $order['paid_time'] > $order['send_other_hour'] * 3600) {
		json_return(1000, '领取礼物有效期已过');
	}
	
	$count = D('Order_friend_address')->where(array('order_id' => $order['order_id'], 'openid' => $_SESSION['PLATFORM_OPENID']))->count('id');
	if ($count > 0) {
		json_return(1000, '您已经领取过了');
	}
	
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$province = $_POST['province'];
	$city = $_POST['city'];
	$county = $_POST['county'];
	$address = $_POST['address'];
	
	if (empty($name)) {
		json_return(1000, '请填写收货人姓名');
	}
	
	if (!preg_match("/\d{6,13}$/", $phone)) {
		json_return(1000, '请填写正确的手机号');
	}
	
	if (empty($province)) {
		json_return(1000, '请选择省份');
	}
	
	if (empty($city)) {
		json_return(1000, '请选择城市');
	}
	
	if (empty($county)) {
		json_return(1000, '请选择区县');
	}
	
	if (empty($address)) {
		json_return(1000, '请填写详细地址');
	}
	
	if (mb_strlen($address, 'utf-8') > 120) {
		json_return(1000, '详细地址最多只能填写120个字符');
	}
	
	import('source.class.area');
	$area_class = new area();
	$province_txt = $area_class->get_name($province);
	$city_txt = $area_class->get_name($city);
	$county_txt = $area_class->get_name($county);
	
	if (empty($province_txt) || empty($city_txt)) {
		json_return(1009, '该地址不存在');
	}
	
	$data = array();
	$data['dateline'] = time();
	$data['order_id'] = $order['order_id'];
	$data['uid'] = $_SESSION['wap_user']['uid'];
	$data['store_id'] = $order['store_id'];
	$data['name'] = $name;
	$data['phone'] = $phone;
	$data['pro_num'] = $order['send_other_per_number'];
	$data['openid'] = $_SESSION['PLATFORM_OPENID'];
	$data['address'] = serialize(array(
			'address' => $address,
			'province' => $province_txt,
			'province_code' => $province,
			'city' => $city_txt,
			'city_code' => $city,
			'area' => $county_txt,
			'area_code' => $county
	));
	
	$result = D('Order_friend_address')->data($data)->add();
	if ($result) {
		json_return(0, '领取成功');
	} else {
		json_return(1000, '领取失败');
	}
}

if (time() - $order['paid_time'] < $order['send_other_hour'] * 3600) {
	// 每个用户只能领取一份
	if (empty($_SESSION['PLATFORM_OPENID'])) {
		if (empty($_GET['code'])) {
			$_SESSION['weixin']['state'] = md5(uniqid());
			$customeUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			$oauthUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . option('config.wechat_appid') . '&redirect_uri=' . urlencode($customeUrl).'&response_type=code&scope=snsapi_userinfo&state=' . $_SESSION['weixin']['state'] . '#wechat_redirect';
			redirect($oauthUrl);
			exit;
		} else if (isset($_GET['code']) && isset($_GET['state']) && ($_GET['state'] == $_SESSION['weixin']['state'])) {
			unset($_SESSION['weixin']);
			import('Http');
			$http = new Http();
			$return = $http->curlGet('https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . option('config.wechat_appid') . '&secret=' . option('config.wechat_appsecret') . '&code=' . $_GET['code'] . '&grant_type=authorization_code');
			$jsonrt = json_decode($return, true);
			if ($jsonrt['errcode']) {
				$error_msg_class = new GetErrorMsg();
				pigcms_tips('授权发生错误：' . $jsonrt['errcode'], 'none');
			}
			if ($jsonrt['openid']) {
				$_SESSION['PLATFORM_OPENID'] = $jsonrt['openid'];
			}
		}
	}
} else {
	$share_valid = false;
}

$order_friend_address = D('Order_friend_address')->where(array('order_id' => $order['order_id'], 'openid' => $_SESSION['PLATFORM_OPENID']))->find();
if ($order_friend_address) {
	$share_valid = false;
}
$store = M('Store')->getStore($order['store_id']);

//分享配置 start
$product_image = $order['proList'][0]['image'];
$share_conf 	= array(
		'title' 	=> '小伙伴快来领礼品', // 分享标题
		'desc' 		=> str_replace(array("\r","\n", "'"), array('','', ''),  $order['send_other_comment']), // 分享描述
		'link' 		=> option('config.wap_site_url') . '/order_friend_share.php?order_id=' . $order['order_no_txt'], // 分享链接
		'imgUrl' 	=> $product_image, // 分享图片链接
		'type'		=> '', // 分享类型,music、video或link，不填默认为link
		'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);


include display('order_friend_share');
echo ob_get_clean();
?>