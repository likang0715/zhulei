<?php

/**
 *  处理订单
 */
require_once dirname(__FILE__) . '/global.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'add';

switch ($action) {

	case 'pay':
		$nowOrder = D('Order_sms')->where(array('smspay_no' => trim($_POST['orderNo'])))->find();

		if (empty($nowOrder['money']))  {

			json_return("1006", '订单异常，请稍后再试');
		}

		$trade_no = 'SMSPAY_'.date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);

		if ($nowOrder['status'] >= 1)	json_return(1007, '该订单已支付或关闭<br/>不再允许付款');

		if (empty($nowOrder['status'])) {
			if (empty($nowOrder['sms_order_id'])) json_return(1008, '该订单不存在');
		}



			$condition_order['sms_order_id'] = $nowOrder['sms_order_id'];
			if ($wap_user['uid']) {
				//付款人信息
				$pay_uid = $wap_user['uid'];
			} else {
				json_return(1018, '未登录');
			}

			$data_order = array();


			$condition_order['sms_order_id'] = $nowOrder['sms_order_id'];
			$data_order['trade_no'] = $trade_no;

			if (!D('Order_sms')->where($condition_order)->data($data_order)->save())
			json_return(1010, '订单信息保存失败');


		$nowOrder['trade_no'] = $trade_no;
		$payType = $_POST['payType'];


		$payMethodList = M('Config')->get_pay_method();
		if (empty($payMethodList[$payType])) {
			json_return(1012, '您选择的支付方式不存在<br/>请更新支付方式');
		}
		//$nowOrder['order_no_txt'] = option('config.orderid_prefix') . $nowOrder['trade_no'];
		$nowOrder['order_no_txt'] = "购买短信 ".$nowOrder['sms_num']." 条";

		unset($_SESSION['float_amount']);
		unset($_SESSION['float_postage']);
		switch ($payType) {

			case 'tenpay':
				import('source.class.pay.Tenpay');
				$payClass = new Tenpay($nowOrder, $payMethodList[$payType]['config'], $wap_user);
				$payInfo = $payClass->pay();
				if ($payInfo['err_code']) {
					json_return(1013, $payInfo['err_msg']);
				} else {
					json_return(0, $payInfo['url']);
				}
				break;

			case 'weixin':

				import('source.class.pay.Weixin');
				//付款人信息
				$openid = $_SESSION['openid'];

				$submit_order = array('total'=>$nowOrder['money']);
				$nowOrder = array_merge($nowOrder,$submit_order);

				$payClass = new Weixin($nowOrder, $payMethodList[$payType]['config'], $wap_user, $openid);
				$payInfo = $payClass->pay();

				if ($payInfo['err_code']) {
					json_return(1013, $payInfo['err_msg']);
				} else {
					json_return(0, json_decode($payInfo['pay_data']));
				}
				break;
		}
		break;







}
