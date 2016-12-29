<?php

/**
 *  支付订单
 */
require_once dirname(__FILE__) . '/global.php';

if (strtolower($_GET['action']) == 'checkamount') {
    $order_id = intval(trim($_POST['order_id']));
    $float_amount = floatval(trim($_POST['float_amount']));
    $postage = floatval(trim($_POST['postage']));
    $tmpOrder = D('Order')->field('float_amount,postage')->where(array('order_id' => $order_id))->find();

    if ($tmpOrder['float_amount'] != $float_amount) {
        $_SESSION['float_amount'] = true;
        echo true;
    } else if ($postage != $tmpOrder['postage']) {
        $_SESSION['float_postage'] = true;
        echo true;
    } else {
        echo false;
    }
    exit;
}

$nowOrder = M('Order')->find($_GET['id']);

if($nowOrder['is_point_order'] == 1) {
	//积分商城
	$tip = "积分订单";
	$is_point_mall = 1;
	$allow_drp = false;	//不允许分销
} else {
	$tip = "商品";
	$is_point_mall = 0;
}

if (empty($nowOrder))
	pigcms_tips('该订单号不存在', 'none');

if ($nowOrder['status'] > 1 && $nowOrder['payment_method'] != 'codpay')
	redirect('./order.php?orderno=' . $_GET['id']);
if ($nowOrder['status'] > 1 && $nowOrder['payment_method'] == 'codpay')
	redirect('./order.php?orderid=' . $nowOrder['order_id']);
if ($nowOrder['status'] >= 1 && $nowOrder['payment_method'] == 'peerpay') {
	redirect('./order_share.php?orderid=' . option('config.orderid_prefix') . $nowOrder['order_no']);
}

//经销商付款到供货商
$pay_to_supplier = false;
if (!empty($_GET['sid']) && !empty($_GET['paykey']) && !empty($_GET['payer'])) {

	$weixin_bind = D('Weixin_bind')->field('wxpay_key')->where(array('store_id' => $_GET['sid']))->find();
	//是否店铺收款
	if (option('config.store_pay_weixin_open') && !empty($weixin_bind)) {
		$salt = $weixin_bind['wxpay_key'];
	} else {
		$salt = option('config.pay_weixin_key');
	}

	$now_store = M('Store')->wap_getStore(intval($_GET['sid']));
	
	$sha1_data = array(
		'order_no' => $_GET['id'],
		'sid' => $_GET['sid'],
		'payer'	=> $_GET['payer'],
		'oid' => $_GET['oid'],
		'salt' => $salt
	);
	ksort($sha1_data);
	$paykey = sha1(http_build_query($sha1_data));
	if (empty($_GET['timestamp']) || (time() - $_GET['timestamp']) > 600) {
		pigcms_tips('请求已过期，支付失败', 'none');
	}
	if (trim($_GET['paykey']) != $paykey || empty($now_store)) {
		pigcms_tips('参数有误，支付失败', 'none');
	}
	//模拟用户登陆
	$seller = D('Store')->field('uid')->where(array('store_id' => intval(trim($_GET['payer']))))->find();
	$_SESSION['wap_user'] = D('User')->where(array('uid' => $seller['uid']))->find();
	//付款到供货商
	$pay_to_supplier = true;
	$nowOrder['order_id'] = $nowOrder['user_order_id'];
} else {
	//普通支付
	//店铺资料
	$now_store = M('Store')->wap_getStore($nowOrder['store_id']);
}

if ($nowOrder['uid'] && empty($_SESSION['wap_user']))
	redirect('./login.php');


if (empty($now_store))
	pigcms_tips('您访问的店铺不存在', 'none');

$tmp_store_id = $now_store['store_id'];
setcookie('wap_store_id', $now_store['store_id'], $_SERVER['REQUEST_TIME'] + 10000000, '/');

// 货到付款
$offline_payment = false;
if ($now_store['offline_payment'] && empty($pay_to_supplier)) {
	$offline_payment = true;
}
$is_all_selfproduct = true;
$is_all_supplierproduct = true;

// 用户手动下单，没有商品时，模拟商品
$product_debug = false;
if ($nowOrder['is_offline'] == 1 && empty($nowOrder['proList'])) {
	$product_debug = true;
	$product_tmp = array();
	$product_tmp['product_id'] = 0;
	$product_tmp['name'] = '手工做单虚拟商品';
	$product_tmp['image'] = getAttachmentUrl('images/default_shop.png', true);
	$product_tmp['pro_price'] = $nowOrder['sub_total'];
	$product_tmp['pro_num'] = 1;
	$product_tmp['supplier_id'] = 0;
	$product_tmp['wholesale_product_id'] = 0;
	
	$nowOrder['proList'][0] = $product_tmp;
}


if ($nowOrder['status'] < 1) {
	//用户地址
	$userAddress = M('User_address')->find(session_id(), $wap_user['uid']);

    //用户地址列表
    $userAddressList = M('User_address')->select(session_id(), $wap_user['uid']);
	//上门自提
	if ($now_store['buyer_selffetch']) {
		$selffetch_list = array(); // M('Trade_selffetch')->getListNoPage($now_store['store_id']);

		$store_contact = M('Store_contact')->get($now_store['store_id']);
		$store_physical = M('Store_physical')->getList($now_store['store_id']);
		if ($store_contact) {
			$data = array();
			$data['pigcms_id'] = '99999999_store';
			$data['name'] = $now_store['name'] . '';
			$data['tel'] = ($store_contact['phone1'] ? $store_contact['phone1'] . '-' : '') . $store_contact['phone2'];
			$data['province_txt'] = $store_contact['province_txt'] . '';
			$data['city_txt'] = $store_contact['city_txt'] . '';
			$data['county_txt'] = $store_contact['area_txt'] . '';
			$data['address'] = $store_contact['address'] . '';
			$data['business_hours'] = '';
			$data['logo'] = $now_store['logo'];
			$data['description'] = '';
			$data['store_id'] = $now_store['store_id'];
			$data['long'] = $store_contact['long'];
			$data['lat'] = $store_contact['lat'];

			$selffetch_list[] = $data;
		}

		if ($store_physical) {
			foreach ($store_physical as $physical) {
				$data = array();
				$data['pigcms_id'] = $physical['pigcms_id'];
				$data['name'] = $physical['name'] . '';
				$data['tel'] = ($physical['phone1'] ? $physical['phone1'] . '-' : '') . $physical['phone2'];
				$data['province_txt'] = $physical['province_txt'] . '';
				$data['city_txt'] = $physical['city_txt'] . '';
				$data['county_txt'] = $physical['county_txt'] . '';
				$data['address'] = $physical['address'] . '';
				$data['business_hours'] = $physical['business_hours'] . '';
				$data['logo'] = $physical['images_arr'][0];
				$data['description'] = str_replace(array("\r\n", "\r", "\n", '"', "'"), '', $physical['description']);
				$data['long'] = $physical['long'];
				$data['lat'] = $physical['lat'];

				$selffetch_list[] = $data;
			}
		}
	}

	
    foreach ($nowOrder['proList'] as $product) {
        // 分销商品不参与满赠和使用优惠券
        if ($product['supplier_id'] != '0' || $product['wholesale_product_id'] != 0) {
            $offline_payment = false;
            $is_all_selfproduct = false;
            continue;
        } else {
            $is_all_supplierproduct = false;
        }
    }
    
	//预售订单
	if($nowOrder['type'] == '7') {
		$presale_info = D('Presale')->where(array('id'=>$nowOrder['data_id']))->find();
		if($nowOrder['presale_order_id'] != $nowOrder['order_id']) {
			$product_price = $presale_info['dingjin'];
			$presale_type = 'presale_first_pay';
			$presale_tips = "预付";
		} else {
		
			$orderproduct = D('Order_product')->where(array('order_id'=>$nowOrder['order_id'],'is_present'=>0))->find();
			$product_price = $orderproduct['presale_pro_price'] - $presale_info['dingjin'];
			$presale_type = 'presale_second_pay';
			$presale_tips = "尾款";
		}

		//pigcms_tips('您访问的店铺不存在', 'none');
	} 

	// 抽出用户可使用的积分
	$supplier_store_id = $now_store['store_id'];
	if (isset($now_store['top_supplier_id']) && !empty($now_store['top_supplier_id'])) {
		$supplier_store_id = $now_store['top_supplier_id'];
	}
	
	// 订单类型以以几种时，不需要用调用优惠信息
	$type_arr = array(6, 7, 55, 50);
	if (!in_array($nowOrder['type'], $type_arr)) {
		// 抽出可以享受的优惠信息与优惠券
		import('source.class.Order');
		$order_data = new Order($nowOrder['proList']);
		
		// 不同供货商的优惠、满减、折扣、包邮等信息
		$order_data = $order_data->all();
		
		$points_data = Points::getPointConfig($_SESSION['wap_user']['uid'], $supplier_store_id);
	}
	
	$max_platform_point = Margin::orderPoint($nowOrder['order_id']);
} else {
	$nowOrder['address'] = unserialize($nowOrder['address']);
	if (empty($pay_to_supplier)) {
		$selffetch_list = true;
		// 查看满减送
		$order_data['reward_list'] = M('Order_reward')->getByOrderId($nowOrder['order_id']);
		// 使用优惠券
		$user_coupon_list = M('Order_coupon')->getList($nowOrder['order_id']);
		// 查看使用的折扣
		$order_discount_list = M('Order_discount')->getByOrderId($nowOrder['order_id']);
		foreach ($order_discount_list as $order_discount) {
			$order_data['discount_list'][$order_discount['store_id']] = $order_discount['discount'];
		}

		foreach ($nowOrder['proList'] as $product) {
			// 分销商品不参与满赠和使用优惠券
			if ($product['supplier_id'] != '0' || $product['wholesale_product_id'] != 0) {
				$offline_payment = false;
				$is_all_selfproduct = false;
			} else {
				$is_all_supplierproduct = false;
			}
		}
		
		$order_point = D('Order_point')->where(array('order_id' => $nowOrder['order_id']))->find();
	}
}

if (!empty($nowOrder['float_amount']) && $nowOrder['float_amount'] > 0) {
	$nowOrder['sub_total'] += $nowOrder['float_amount'];
	$nowOrder['sub_total'] = number_format($nowOrder['sub_total'], 2, '.', '');
}

//付款方式
$payMethodList = M('Config')->get_pay_method();

$payList = array();
$useStorePay = false;
$storeOpenid = '';
//平台是否开启店铺收款
$platform_open_store_wxpay = option('config.store_pay_weixin_open');

/**
 * 微信支付授权
 * @param $store_id
 * @param $order_id
 * @return array
 */
function weixinpay($store_id, $order_id)
{
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
			$payMethodList['weixin']['name'] = '微信安全支付';
			$payList[0] = $payMethodList['weixin'];
			$useStorePay = TRUE;

			return array($payList[0], $useStorePay);
		}
	}
}


//平台收款
$usePlatformPay = true;

if (empty($pay_to_supplier)) { //普通用户付款

	//真实收款店铺id(是否有供货商)
	$pay_store_id 	= M('Store_supplier')->getSupplierId($now_store['store_id']);
	$pay_store_info = M('Store')->getStore($pay_store_id);

	//增加读取套餐商家独立支付配置
			
	$temp_arr = D('')->table("Store as s")
					->join('User as u ON s.uid=u.uid','LEFT')
					->join('Package as p ON u.package_id=p.pigcms_id','LEFT')
					->where("`s`.`store_id`=".$pay_store_id)
					->field("`u`.uid,`s`.store_id,`u`.package_id,`p`.store_pay_weixin_open " )
					-> find();

	$p_store_pay_weixin_open = $temp_arr['package_id'] ? true : $temp_arr['store_pay_weixin_open'];

	//增加店铺是否开启店铺收款
	if(isset($p_store_pay_weixin_open)){
		$platform_open_store_wxpay = ($platform_open_store_wxpay && $p_store_pay_weixin_open)?'1':'0';
	}


	if (!empty($platform_open_store_wxpay) && !empty($pay_store_info['wxpay']) && empty($_SESSION['sync_user'])) { //店铺收款
		weixinpay($pay_store_id, $nowOrder['order_id']);
		$usePlatformPay = false;
	} else { //不满足店铺收款条件,平台代收款
		$storePay = 0;
		$useStorePay = 0;
		//对接的店铺处理收款
		if (!empty($_SESSION['sync_user'])) {
			$sync_user = true;
			if (!empty($nowOrder['suppliers'])) {
				$tmp_supplier = explode($nowOrder['suppliers']);
				$storePay = $tmp_supplier[0];
			} else {
				$storePay = $nowOrder['store_id'];
			}
			$useStorePay = 1;
		}
		if (!D('Order')->where(array('order_id' => $nowOrder['order_id']))->data(array('useStorePay' => $useStorePay, 'storePay' => $storePay, 'storeOpenid' => '', 'trade_no' => date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999)))->save()) {
			pigcms_tips('订单信息保存失败，请重试。');
		}
	}
	
	if (option('credit.platform_credit_open') && $nowOrder['type'] != 6) {
		$user = D('User')->where(array('uid' => $_SESSION['wap_user']['uid']))->find();
	}
	
} else { //经销商给供货商付款（若供货商无法收款，平台代收）

	if (!empty($platform_open_store_wxpay) && !empty($now_store['wxpay'])) {
		$useStorePay = 1;
		$storePay = $now_store['store_id'];
		weixinpay($now_store['store_id'], $nowOrder['order_id']);
	}
}

if (empty($useStorePay) && empty($pay_to_supplier) && empty($nowOrder['is_offline'])) {
	if ($now_store['pay_agent'] && $_GET['pay_type'] == 'peerpay') {
		$payList[0] = array('name' => '找人代付', 'type' => 'peerpay');
	}
}

if ($payMethodList['weixin']) {
	$payMethodList['weixin']['name'] = '微信安全支付';
	$payList[1] = $payMethodList['weixin'];
}

if ($payMethodList['alipay']) {
    $payMethodList['aplipay']['name'] = '支付宝支付';
    $payList[2] = $payMethodList['alipay'];
}

if (empty($useStorePay) && empty($pay_to_supplier)) {
	if ($payMethodList['tenpay']) {
		$payList[3] = $payMethodList['tenpay'];
	}

	if ($payMethodList['yeepay']) {
		$payList[4] = $payMethodList['yeepay'];
	} else if ($payMethodList['allinpay']) {
		$payList[4] = $payMethodList['allinpay'];
	}

	if ($payList[4])
		$payList[4]['name'] = '银行卡支付';
}

if (empty($pay_to_supplier) && empty($nowOrder['is_offline'])) {
	if ($now_store['pay_agent']) {
		$payList[] = array('name' => '找人代付', 'type' => 'peerpay');
	}

	if ($offline_payment) {
		$payList[] = array('name' => '货到付款', 'type' => 'offline');
	}
}

if (option('config.open_test_payment')) {
	//本地测试使用(危险代码，正式上线时需删除)
	$payList[] = array('name' => '测试支付', 'type' => 'test');
}

if($nowOrder['is_point_order'] == '1') {
	
} else {
	
}

include display('pay');
echo ob_get_clean();
?>
