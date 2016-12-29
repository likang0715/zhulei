<?php

/**
 *  处理夺宝订单
 */
require_once dirname(__FILE__) . '/global.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'add';
$payType = isset($_POST['payType']) ? $_POST['payType'] : '';

switch ($action) {

	case 'pay':

		if ($payType == 'weixin') {

			import('source.class.pay.Weixin');

			$orderid = trim($_POST['orderid']);	//付款人信息
			$address_id = isset($_POST['address_id']) ? intval($_POST['address_id']) : 0;


			if (empty($orderid)) {
				json_return("1001", '订单号异常，请稍后再试');
			}

			$nowOrder = D('Unitary_order')->where(array('orderid'=>$orderid))->find();
			if (empty($nowOrder)) {
				json_return("1002", '该订单不存在');
			}

			if ($nowOrder['paid'] == 1) {
				json_return("1004", '该订单已支付');
			}

			if (empty($address_id) || !$address_info = D('User_address')->where(array('address_id'=>$address_id))->find()) {
				json_return("1006", '缺少收货地址');
			}

			$nowOrder['unitary_id'] = intval($nowOrder['orderid']);

			$openid = $_SESSION['openid'];			//??
			$data_order = array();
			$data_order['trade_no'] = 'DBPAY_'.date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
			$data_order['address_user'] = $address_info['name'];
			$data_order['address_tel'] = $address_info['tel'];

			import('area');
			$areaClass = new area();
			$set_address = array(
				'address' => $address_info['address'],
				'province' => $areaClass->get_name($address_info['province']),
				'province_code' => $address_info['province'],
				'city' => $areaClass->get_name($address_info['city']),
				'city_code' => $address_info['city'],
				'area' => $areaClass->get_name($address_info['area']),
				'area_code' => $address_info['area'],
			);

			$data_order['address'] = serialize($set_address);

			$update_id = D('Unitary_order')->where(array('orderid'=>$orderid))->data($data_order)->save();
			if (empty($update_id)) {
				json_return("1003", '订单信息保存失败');
			}

			// if (empty($nowOrder['unitary_id'])) {
			// 	json_return("1005", '该夺宝活动不存在');
			// }

			// $unitary_info = D('Unitary')->where(array('id'=>$nowOrder['unitary_id']))->find();
			// $cart_info = D('Unitary_cart')->where(array('order_id'=>$nowOrder['pigcms_id']))->find();
			// if (empty($cart_info) || !$unitary_info = D('Unitary')->where(array('id'=>$cart_info['unitary_id']))->find()) {
			// 	json_return("1005", '该夺宝活动不存在');
			// }

			$payType = 'weixin';
			$nowOrder['order_no_txt'] = '夺宝活动购买记录';		// 商品描述

			// $config_pay=D('Config')->where(array('name'=>'open_test_payment'))->field('id,value')->find();
			// $nowOrder['total'] = $config_pay['value']=='1' ? '0.01' : $nowOrder['price'];
			$nowOrder['total'] = $nowOrder['price'];

			// $nowOrder['total'] = $nowOrder['price'];	// 支付价格
			$payMethodList = M('Config')->get_pay_method();

			// $submit_order = array('total'=>6546);
			// $nowOrder = array_merge($nowOrder,$submit_order);
			
			$nowOrder['trade_no'] = $data_order['trade_no'];
			$nowOrder['pay_type'] = 'weixin';
			$payClass = new Weixin($nowOrder, $payMethodList[$payType]['config'], $wap_user, $openid);

			$payInfo = $payClass->pay();
			if ($payInfo['err_code']) {
				json_return(1013, $payInfo['err_msg']);
			} else {
				json_return(0, json_decode($payInfo['pay_data']));
			}

		} else if ($payType == 'test') {

			$orderid = trim($_POST['orderid']);	//付款人信息
			$address_id = isset($_POST['address_id']) ? intval($_POST['address_id']) : 0;

			if (empty($orderid)) {
				json_return("1001", '订单号异常，请稍后再试');
			}

			$nowOrder = D('Unitary_order')->where(array('orderid'=>$orderid))->find();
			if (empty($nowOrder)) {
				json_return("1002", '该订单不存在');
			}

			if ($nowOrder['paid'] == 1) {
				json_return("1004", '该订单已支付');
			}

			if (empty($address_id) || !$address_info = D('User_address')->where(array('address_id'=>$address_id))->find()) {
				json_return("1006", '缺少收货地址');
			}

			$nowOrder['unitary_id'] = intval($nowOrder['orderid']);

			$openid = 'testopenid';			//??
			$data_order = array();
			$data_order['trade_no'] = 'DBPAY_'.date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
			$data_order['address_user'] = $address_info['name'];
			$data_order['address_tel'] = $address_info['tel'];

			import('area');
			$areaClass = new area();
			$set_address = array(
				'address' => $address_info['address'],
				'province' => $areaClass->get_name($address_info['province']),
				'province_code' => $address_info['province'],
				'city' => $areaClass->get_name($address_info['city']),
				'city_code' => $address_info['city'],
				'area' => $areaClass->get_name($address_info['area']),
				'area_code' => $address_info['area'],
			);
			$payType = 'test';

			$data_order['address'] = serialize($set_address);
			$data_order['paytype'] = $payType;

			$update_id = D('Unitary_order')->where(array('id'=>$nowOrder['unitary_id']))->data($data_order)->save();
			if (empty($update_id)) {
				json_return("1003", '订单信息保存失败');
			}

			$nowOrder['order_no_txt'] = '夺宝活动购买记录(测试)';		// 商品描述
			$nowOrder['total'] = "0.01";	// 支付价格
			
			$nowOrder['trade_no'] = $data_order['trade_no'];
			$nowOrder['pay_type'] = 'test';

			$payInfo = array(
				'trade_no' => $data_order['trade_no'],
				'pay_type' => 'test',
				'third_id' => 'test',
				'pay_money' => $nowOrder['price'],
				'third_data' => 'test',
				'echo_content' => '夺宝活动购买记录(测试)',
				'pay_data' => 'test_paydata',
				'pay_data' => 'test_paydata',
			);

	        $data['paytime'] = time();
	        $data['third_id'] = $payInfo['order_param']['third_id'];
	        $data['third_data'] = serialize($payInfo['order_param']['third_data']);
	        $data['pay_openid'] = 'xxxxxxxtest';
	        $data['paid'] = 1;
	        $data['total'] = $payInfo['order_param']['pay_money'];
	        $data['paytype'] = $payInfo['order_param']['pay_type'];
	        $update_id = D('Unitary_order')->where(array('orderid'=>$orderid))->data($data_order)->save();

			if ($payInfo['err_code']) {
				json_return(1013, $payInfo['err_msg']);
			} else {
				// json_return(0, json_decode($payInfo['pay_data']));
				$return_url = option('config.site_url').'/webapp.php?c=unitary&a=payend&orderid='.$nowOrder['orderid'];
				json_return(0, $return_url);
			}

		} else {
			json_return(1014, '缺少支付类型参数');
		}

		

		break;

}
