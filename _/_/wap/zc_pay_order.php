<?php

/**
 *  处理订单
 */
require_once dirname(__FILE__) . '/global.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'add';

switch ($action) {
	case 'pay':
		import('source.class.pay.Weixin');
		//付款人信息
		$zcpay_no=trim($_POST['zcpay_no']);
		if(empty($zcpay_no)){
			json_return("1001", '订单号异常，请稍后再试');
		}
		$nowOrder=D('Invest_order')->where(array('zcpay_no'=>$zcpay_no))->find();
		if (empty($nowOrder)) {
			json_return("1002", '该订单不存在');
		}

		if($nowOrder['order_type'] == 1){
			if ($nowOrder['status'] == 2) {
				//已经支付
				json_return("1004", '该订单已支付');
			}
		} else {
			if($nowOrder['order_status'] == 2){
				//已经支付
				json_return("1004", '该订单已支付');
			}
		}
		$openid = $_SESSION['openid'];
		$data_order=array();
		$data_order['trade_no'] = 'ZCPAY_'.date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
		$effId=D('Invest_order')->where(array('zcpay_no'=>$zcpay_no))->data($data_order)->save();
		if(empty($effId)){
			json_return("1003", '订单信息保存失败');
		}
		if(empty( $nowOrder['project_id'] )){
			json_return("1005", '该项目不存在');
		}
		if($nowOrder['order_type'] == 1){
			$proInfo=D('Project')->where(array('project_id'=>$nowOrder['project_id']))->find();
			if(empty($proInfo)){
				json_return("1005", '该项目不存在');
			}
		} else {
			$proInfo=D('Zc_product')->where(array('product_id'=>$nowOrder['project_id']))->find();
			if(empty($proInfo)){
				json_return("1005", '该项目不存在');
			}
		}
		$payType = 'weixin';
		$nowOrder['order_type'] == 1 ? $nowOrder['order_no_txt'] = $proInfo['projectName'] : $nowOrder['order_no_txt'] = $proInfo['productName'];

		// 检测是否测试支付
		$config_pay=D('Config')->where(array('name'=>'open_test_payment'))->field('id,value')->find();
		$nowOrder['total'] = $config_pay['value']=='1' ? '0.01' : trim($_POST['total']);
		$payMethodList = M('Config')->get_pay_method();
		$nowOrder['trade_no']=$data_order['trade_no'];
		$nowOrder['pay_type'] = 'weixin';
		$payClass = new Weixin($nowOrder, $payMethodList[$payType]['config'], $wap_user, $openid);
		$payInfo = $payClass->pay();
		if ($payInfo['err_code']) {
			json_return(1013, $payInfo['err_msg']);
		} else {
			json_return(0, json_decode($payInfo['pay_data']));
		}

	break;


}
