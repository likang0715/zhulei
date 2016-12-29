<?php
/**
 *  订单信息
 */
require_once dirname(__FILE__).'/global.php';

if(empty($wap_user)) {
	if (IS_AJAX) {
		json_return(1000, '请先登录');
	} else {
		redirect('./login.php?referer=' . urlencode($_SERVER['REQUEST_URI']));
	}
}

// 当前用户登录UID
$current_uid = $wap_user['uid'];
$store_id = $_GET['store_id'];

if (empty($store_id)) {
	if (IS_AJAX) {
		json_return(1000, '缺少参数');
	} else {
		pigcms_tips('缺少参数');
	}
}

$store = M('Store')->getStore($store_id);
if (empty($store)) {
	if (IS_AJAX) {
		json_return(1000, '未找到相应店铺');
	} else {
		pigcms_tips('未找到相应店铺');
	}
}

if ($store['uid'] == $wap_user['uid']) {
	if (IS_AJAX) {
		json_return(1000, '不能在自己店铺购买产品');
	} else {
		pigcms_tips('不能在自己店铺购买产品');
	}
}

if ($store['drp_level'] > 0) {
	if (IS_AJAX) {
		json_return(1000, '不能给分销店铺添加手工做单');
	} else {
		pigcms_tips('不能给分销店铺添加手工做单');
	}
}

$user = D('User')->where(array('uid' => $wap_user['uid']))->find();

if ($_GET['action'] == 'add') {
	$total = $_POST['total'];
	$platform_point = $_POST['platform_point'] + 0;
	$platform_point_money = 0;
	if (option('credit.platform_credit_use_value') > 0) {
		$platform_point_money = $platform_point / option('credit.platform_credit_use_value');
	}
	$comment = $_POST['comment'];
	
	if (empty($total)) {
		json_return(1000, '请输入订单总额');
	}
	
	if (!is_numeric($total)) {
		json_return(1000, '请输入正确的订单总额');
	}
	
	if (option('credit.platform_credit_open') && option('config.user_point_total') > 0 && $user['point_balance'] + $user['point_unbalance'] >= option('config.user_point_total') && $platform_point == 0) {
		json_return(1000, '您的积分过多，不支付现金做单');
	}
	
	// 积分保证金逻辑处理
	if (option('credit.platform_credit_open')) {
		if ($user['point_balance'] < $platform_point) {
			json_return(1000, '您的' . option('credit.platform_credit_name') . '不够');
		}
		
		if ($platform_point_money > 0 && $platform_point_money < $total) {
			$platform_point = $total * option('credit.platform_credit_use_value');
			json_return(1000, '请使用' . $platform_point . '个' . option('credit.platform_credit_name'));
		}
		
		// 强制店铺使用平台积分，直接找到供货商（批发商），查看平台积分保证金是否充足
		if (option('credit.force_use_platform_credit')) {
			$margin_balance = Margin::balance($store_id);
			
			$check_money = $total;
			if (option('credit.offline_trade_credit_type') == 1) {
				$check_money = $total - $platform_point_money;
			}
			
			if ($margin_balance < $check_money * option('credit.credit_deposit_ratio') / 100) {
				json_return(1000, '店铺' . option('credit.platform_credit_name') . '的保证金不够');
			}
		}
		
		// 最多使用多少积分,线下手工订单不判断使用数量
		if (0 && $platform_point > 0) {
			$max_platform_point = Margin::convert($total, 'point', option('credit.platform_credit_rule'));
			
			if ($max_platform_point < $platform_point) {
				json_return(1000, '此订单最多只能使用' . $max_platform_point . '个' . option('credit.platform_credit_name'));
			}
		}
		
		// 现金和积分比例,线下订单不判断现金比
		if (0 && option('credit.offline_trade_money') > 0 && $platform_point > 0) {
			if (option('credit.platform_credit_use_value') == 0) {
				json_return(1000, '此订单不能使用' . option('credit.platform_credit_name'));
			} else {
				// 在未使用平台积分时，需要支付的总额
				if (round($total * option('credit.offline_trade_money') / 100, 2) > round(($total - $platform_point_money), 2)) {
					$max_platform_point = round(($total - $total * option('credit.offline_trade_money') / 100) * option('credit.platform_credit_use_value'), 2);
					json_return(1000, '此订单最多只能使用' . $max_platform_point . '个' . option('credit.platform_credit_name'));
				}
			}
		}
	} else {
		// 平台未开启积分时，直接取消使用
		$platform_point = 0;
		$platform_point_money = 0;
	}
	
	$data = array();
	$data['store_id'] = $store_id;
	$data['order_no'] = $data['trade_no'] = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
	$data['uid'] = $wap_user['uid'];
	$data['sub_total'] = $total;
	$data['total'] = $total;
	$data['sale_total'] = $total;
	$data['pro_count'] = 1;
	$data['pro_num'] = 1;
	$data['status'] = 1;
	
	$data['add_time'] = $_SERVER['REQUEST_TIME'];
	$data['comment'] = $comment;
	$data['is_offline'] = 1;
	
	$selffetch = array();
	$selffetch = M('Store_contact')->get($store_id);
	$selffetch['tel'] = ($selffetch['phone1'] ? $selffetch['phone1'] . '-' : '') . $selffetch['phone2'];
	$selffetch['business_hours'] = '';
	$selffetch['name'] = $store['name'];
	$selffetch['physical_id'] = 0;
	$selffetch['store_id'] = $store_id;
	
	$data['postage'] = '0';
	$data['shipping_method'] = 'selffetch';
	$data['address_user'] = $user['nickname'] ? $user['nickname'] : $user['phone'];
	$data['address_tel'] = $user['phone'];
	$data['address'] = serialize(array(
			'name' => $selffetch['name'],
			'address' => $selffetch['address'],
			'province' => $selffetch['province_txt'],
			'province_code' => $selffetch['province'],
			'city' => $selffetch['city_txt'],
			'city_code' => $selffetch['city'],
			'area' => $selffetch['county_txt'],
			'area_code' => $selffetch['county'],
			'tel' => $selffetch['tel'],
			'long' => $selffetch['long'],
			'lat' => $selffetch['lat'],
			'business_hours' => $selffetch['business_hours'],
			'date' => date('Y-m-d'),
			'time' => date('H:i'),
			'store_id' => $selffetch['store_id'],
	));
	$data['cash_point'] = $platform_point;
	$data['point2money_rate'] = option('credit.platform_credit_use_value');
	
	if (option('credit.offline_trade_credit_type') == 1) {
		$data['return_point'] = ($total - $platform_point_money) * option('credit.platform_credit_rule');
	} else {
		$data['return_point'] = $total * option('credit.platform_credit_rule');
	}
	
	$data['total'] = $total - $platform_point_money;
	
	$order_id = D('Order')->data($data)->add();
	if ($order_id) {
		if ($platform_point > 0) {
			// 操作用户平台积分
			Margin::user_point_log($user['uid'], $order_id, $store_id, $platform_point * -1, 1, 1, '订单使用', 1, '', false, true);
		}
		
		json_return(0, option('config.wap_site_url') . '/pay.php?id=' . option('config.orderid_prefix') . $data['order_no']);
	} else {
		json_return(1000, '订单创建失败');
	}
	
}

include display('user_offline');
echo ob_get_clean();