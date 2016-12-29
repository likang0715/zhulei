<?php
/**
 * 订单送他人，确认页面
 */
require_once dirname(__FILE__).'/global.php';
$order_id = $_GET['order_id'];
$type = $_GET['type'];

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

// 是否是自己的订单
if ($order['uid'] != $_SESSION['wap_user']['uid']) {
	if (IS_AJAX) {
		json_return(1000, '订单不存在');
	} else {
		pigcms_tips('订单不存在','none');
	}
}

// 检查订单送他人类型，订单送他人类型优先于参数
if (in_array($order['send_other_type'], array(1, 2, 3))) {
	$type = $order['send_other_type'];
}

if (!in_array($type, array(1, 2, 3)) && !in_array($order['send_other_type'], array(1, 2, 3))) {
	if (IS_AJAX) {
		json_return(1000, '送他人类型错误');
	} else {
		pigcms_tips('送他人类型错误', 'none');
	}
}

// 判断订单是否已经支付
if ($order['status'] > 1 && $order['payment_method'] != 'codpay') {
	redirect('./order.php?orderno=' . $order_id);
}

if ($order['status'] > 1 && $order['payment_method'] == 'codpay') {
	redirect('./order.php?orderid=' . $order['order_id']);
}
if ($order['status'] >= 1 && $order['payment_method'] == 'peerpay') {
	redirect('./order_share.php?orderid=' . option('config.orderid_prefix') . $order['order_no']);
}

// 判断是否为送他人订单，如果不是直接跳转普通订单支付页面
if ($order['shipping_method'] != 'send_other') {
	redirect('./pay.php?orderid=' . $order_id);
}

$store = M('Store')->wap_getStore($order['store_id']);

$user_address = array();
if ($order['status'] < 1) {
	//用户地址
	$user_address = M('User_address')->find(session_id(), $wap_user['uid']);
	
	if ($type == 2) {
		$top_store_id = $store['top_supplier_id'] ? $store['top_supplier_id'] : $store['store_id'];
		$commonweal_address_list = M('Commonweal_address')->select($top_store_id);
		
		if (empty($commonweal_address_list)) {
			pigcms_tips('店铺未设置公益地址', 'none');
		}
		
		if (isset($commonweal_address_list[0])) {
			$user_address = $commonweal_address_list[0];
			$user_address['commonweal'] = true;
		}
	}
	
	// 抽出可以享受的优惠信息与优惠券
	import('source.class.Order');
	$order_data = new Order($order['proList']);
	// 不同供货商的优惠、满减、折扣、包邮等信息
	$order_data = $order_data->all();

	foreach ($order['proList'] as $product) {
		// 分销商品不参与满赠和使用优惠券
		if ($product['supplier_id'] != '0' || $product['wholesale_product_id'] != 0) {
			$offline_payment = false;
			$is_all_selfproduct = false;
			continue;
		} else {
			$is_all_supplierproduct = false;
		}
	}
	
	// 抽出用户可使用的积分
	$supplier_store_id = $store['store_id'];
	if (isset($store['top_supplier_id']) && !empty($store['top_supplier_id'])) {
		$supplier_store_id = $store['top_supplier_id'];
	}
	$points_data = Points::getPointConfig($_SESSION['wap_user']['uid'], $supplier_store_id, $nowOrder['proList']);
} else {
	$order['address'] = unserialize($order['address']);
	
	$selffetch_list = true;
	// 查看满减送
	$order_data['reward_list'] = M('Order_reward')->getByOrderId($order['order_id']);
	// 使用优惠券
	$user_coupon_list = M('Order_coupon')->getList($order['order_id']);
	// 查看使用的折扣
	$order_discount_list = M('Order_discount')->getByOrderId($order['order_id']);
	foreach ($order_discount_list as $order_discount) {
		$order_data['discount_list'][$order_discount['store_id']] = $order_discount['discount'];
	}

	foreach ($order['proList'] as $product) {
		// 分销商品不参与满赠和使用优惠券
		if ($product['supplier_id'] != '0' || $product['wholesale_product_id'] != 0) {
			$offline_payment = false;
			$is_all_selfproduct = false;
		} else {
			$is_all_supplierproduct = false;
		}
	}
	$order_point = D('Order_point')->where(array('order_id' => $order['order_id']))->find();
}

// 支付方式
$pay_method_list = M('Config')->get_pay_method();
$pay_list = array();

if ($pay_method_list['weixin']) {
	$pay_method_list['weixin']['name'] = '微信安全支付';
	$pay_list[0] = $pay_method_list['weixin'];
}

if ($pay_method_list['alipay']) {
	$pay_method_list['aplipay']['name'] = '支付宝支付';
	$pay_list[1] = $pay_method_list['alipay'];
}

if (empty($useStorePay)) {
	if ($pay_method_list['tenpay']) {
		$pay_list[2] = $pay_method_list['tenpay'];
	}
	if ($pay_method_list['yeepay']) {
		$pay_list[3] = $pay_method_list['yeepay'];
	} else if ($pay_method_list['allinpay']) {
		$pay_list[3] = $pay_method_list['allinpay'];
	}
	if ($pay_list[3])
		$pay_list[3]['name'] = '银行卡支付';


	if ($now_store['pay_agent']) {
		$pay_list[] = array('name' => '找人代付', 'type' => 'peerpay');
	}
}

//平台是否开启店铺收款
$platform_open_store_wxpay = option('config.store_pay_weixin_open');

$pay_store_id 	= !empty($store['top_supplier_id']) ? $store['top_supplier_id'] : $store['store_id'];
$pay_store_info = M('Store')->getStore($pay_store_id);


//增加读取套餐商家独立支付配置

$temp_arr = D('')->table("Store as s")
				->join('User as u ON s.uid=u.uid','LEFT')
				->join('Package as p ON u.package_id=p.pigcms_id','LEFT')
				->where("`s`.`store_id`=".$pay_store_id)
				->field("`u`.uid,`s`.store_id,`u`.package_id,`p`.store_pay_weixin_open " )
				-> find();

//$p_store_pay_weixin_open = $temp_arr['store_pay_weixin_open'];
$p_store_pay_weixin_open = $temp_arr['package_id'] ? true : $temp_arr['store_pay_weixin_open'];

//增加店铺是否开启店铺收款
if(isset($p_store_pay_weixin_open)){
	$platform_open_store_wxpay = ($platform_open_store_wxpay && $p_store_pay_weixin_open)?'1':'0';
}


if (!empty($platform_open_store_wxpay) && !empty($pay_store_info['wxpay'])) { //店铺收款
	weixinpay($pay_store_id, $order['order_id']);
}

function weixinpay($store_id, $order_id) {
	$weixin_bind_info = D('Weixin_bind')->where(array('store_id' => $store_id))->find();
	if ($weixin_bind_info && $weixin_bind_info['wxpay_mchid'] && $weixin_bind_info['wxpay_key']) {
		if (empty($_GET['code'])) {
			$_SESSION['store_weixin_state'] = md5(uniqid());
			//代店铺发起获取openid
			redirect('https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $weixin_bind_info['authorizer_appid'] . '&redirect_uri=' . urlencode(option('config.site_url') . $_SERVER['REQUEST_URI']) . '&response_type=code&scope=snsapi_base&state=' . $_SESSION['store_weixin_state'] . '&component_appid=' . option('config.wx_appid') . '#wechat_redirect');
		} else if (isset($_GET['code']) && isset($_GET['state']) && ($_GET['state'] == $_SESSION['store_weixin_state'])) {
			import('Http');
			$component_access_token_arr = M('Weixin_bind')->get_access_token($store_id, TRUE);
			if ($component_access_token_arr['errcode']) {
				pigcms_tips('与微信通信失败，请重试。');
			}
			$result = Http::curlGet('https://api.weixin.qq.com/sns/oauth2/component/access_token?appid=' . $weixin_bind_info['authorizer_appid'] . '&code=' . $_GET['code'] . '&grant_type=authorization_code&component_appid=' . option('config.wx_appid') . '&component_access_token=' . $component_access_token_arr['component_access_token']);
			$result = json_decode($result, TRUE);
			if ($result['errcode']) {
				pigcms_tips('微信返回系统繁忙，请稍候再试。微信错误信息：' . $result['errmsg']);
			}
			$storeOpenid = $result['openid'];
			if (!D('Order')->where(array('order_id' => $order_id))->data(array('useStorePay' => 1, 'storePay' => $store_id, 'storeOpenid' => $storeOpenid, 'trade_no' => date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999)))->save()) {
				pigcms_tips('订单信息保存失败，请重试。');
			}
			
			unset($_SESSION['store_weixin_state']);
		}
	}
}

include display('order_friend_pay');
echo ob_get_clean();
?>