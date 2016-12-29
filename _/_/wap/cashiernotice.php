<?php
/**
 *  支付异步通知
 */
require_once dirname(__FILE__) . '/global.php';

$payType = isset($_REQUEST['pay_type']) ? $_REQUEST['pay_type'] : (isset($_REQUEST['attach']) ? $_REQUEST['attach'] : 'weixin');

//file_put_contents($file, $content,FILE_APPEND);

// 支付宝支付
if (strpos($_REQUEST['service'], 'alipay')!==false) {
    $payType = 'alipay';
}

$payMethodList = M('Config')->get_pay_method();
$payMethodList['test'] = '测试支付';
if (empty($payMethodList[$payType])) {
    json_return(1009, '您选择的支付方式不存在<br/>请更新支付方式');
}
if ($payType == 'weixi_peerpay') {
    if (empty($payMethodList['weixin'])) {
        json_return(1009, '您选择的支付方式不存在<br/>请更新支付方式');
    }
} else {
    if (empty($payMethodList[$payType])) {
        json_return(1009, '您选择的支付方式不存在<br/>请更新支付方式');
    }
}

if ($payType == 'yeepay') {
    import('source.class.pay.Yeepay');
    $payClass = new Yeepay(array(), $payMethodList[$payType]['config'], $wap_user);
    $payInfo = $payClass->notice();
    pay_notice_call($payInfo);
} else if ($payType == 'tenpay') {
    import('source.class.pay.Tenpay');
    $payClass = new Tenpay(array(), $payMethodList[$payType]['config'], $wap_user);
    $payInfo = $payClass->notice();
    pay_notice_call($payInfo);
} else if ($payType == 'test') { //测试支付 正式环境中需删除
    $payInfo = array();
    $payInfo['order_param']['trade_no'] = $_REQUEST['trade_no'];
    $payInfo['order_param']['third_id'] = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(1000000000, 9999999999);
    $payInfo['order_param']['pay_money'] = $_REQUEST['pay_money'];
    $payInfo['order_param']['pay_type'] = $_REQUEST['pay_type'];
    $payInfo['err_code'] = 0;
    pay_notice_call($payInfo);
} else if ($payType == 'weixin_peerpay') {
    import('source.class.pay.Weixin');
    $payClass = new Weixin(array(), $payMethodList['weixin']['config'], $wap_user, '');
    $payInfo = $payClass->notice();
    if ($payInfo['err_code'] === 0) {
        peerpay_notice_call($payInfo, $payInfo['echo_content']);
    } else {
        peerpay_notice_call($payInfo);
    }
} else if ($payType == 'alipay') {
    import('source.class.pay.Alipay');
    $payClass = new Alipay(array(), $payMethodList[$payType]['config'], $wap_user);
    $payInfo = $payClass->notice();
    pay_notice_call($payInfo);
} else if (!empty($GLOBALS['HTTP_RAW_POST_DATA'])) {
    import('source.class.pay.Weixinapp');
    $payClass = new Weixinapp(array(), $payMethodList[$payType]['config'], $wap_user, '');
    $payInfo = $payClass->cashier_notice();
    if ($payInfo['err_code'] === 0) {
           pay_notice_call($payInfo, $payInfo['echo_content']);
    
    } else {
        pay_notice_call($payInfo);
    }
}

function getSign($data, $salt)
{
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $validate[$key] = getSign($value, $salt);
        } else {
            $validate[$key] = $value;
        }
    }
    $validate['salt'] = $salt;
    sort($validate, SORT_STRING);
    return sha1(implode($validate));
}


function pay_notice_call($payInfo, $ok_msg = 'success', $err_msg = 'fail') {
    $xml='<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
	$Financial=D('Cashier_record')->where(array('order_no' => $payInfo['order_param']['trade_no']))->find();
	if($Financial){
	 exit($xml);
	}
    if ($payInfo['err_code'] === 0) {
	
	        $out_trade_no = $payInfo['order_param']['trade_no'];
            $data_order['trade_no']       = $payInfo['order_param']['third_id'];
            $data_order['money'] = $payInfo['order_param']['pay_money'];
            $data_order['third_data']      = $payInfo['order_param']['echo_content'];
            $data_order['pay_dateline']      = $_SERVER['REQUEST_TIME'];
            $data_order['status']         = 1; //未发货
			
            if (D('Order_cashier')->where(array('pay_no'=>$out_trade_no))->data($data_order)->save()) {
			$nowOrder=D('Order_cashier')->where(array('pay_no' => $out_trade_no))->find();
			$order_total =$data_order['money'];
			$nowStore = D('Store')->where(array('store_id' => $nowOrder['store_id']))->find();
			$data_store = array();
			//店铺收益(分销、或批发订单会面处理会修改此项)
			$data_store['income'] = $nowStore['income'] + $order_total;
			if($nowOrder['type']==1){
			$data_store['balance'] = $nowStore['balance'] + $order_total;
			}else{
			
			$data_store['store_pay_income'] = $nowStore['store_pay_income'] + $order_total;
			}
			//店铺销售额（直销）
			$data_store['p_sales'] = $nowStore['p_sales'] + $order_total;
			//店铺订单数（直销）
			$data_store['p_orders'] = $nowStore['p_orders'] + 1;
			//非店铺收款（店铺收款不加收入）
			$data_store['last_edit_time'] = time();
			//更新店铺
			if (D('Store')->where(array('store_id' => $nowOrder['store_id']))->data($data_store)->save()) {
				//添加账务流水
				$data_financial_record['store_id'] = $nowOrder['store_id'];
				$data_financial_record['order_id'] = $nowOrder['order_id'];
				$data_financial_record['order_no'] = $nowOrder['pay_no'];
				$data_financial_record['income'] = $order_total;
				$data_financial_record['type'] = 1;
				$data_financial_record['balance'] = $nowStore['income'];
				$data_financial_record['payment_method'] = 'weixin';
				$data_financial_record['trade_no'] = $nowOrder['trade_no'];
				$data_financial_record['add_time'] = $_SERVER['REQUEST_TIME'];
				$data_financial_record['user_order_id'] = $nowOrder['order_id'];
				$data_financial_record['storeOwnPay'] = 0;
				$data_financial_record['supplier_id'] = $nowOrder['store_id'];
				$financial_record_id = D('Cashier_record')->data($data_financial_record)->add();
			}
			
          
			}
			 exit($xml);
        } else {
            exit($err_msg);
        }
  
}




?>