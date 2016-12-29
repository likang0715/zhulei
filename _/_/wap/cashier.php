<?php
/**
 *  订单信息
 */
require_once dirname(__FILE__).'/global.php';

 


$cashier_id=$_REQUEST['order_id'];

$cashierOrder = D('Order_cashier')->where(array('order_id'=>$cashier_id,'status'=>'1'))->find();
if($cashierOrder){
$physical_id = $cashierOrder['physical_id'];
$store_id = $cashierOrder['store_id'];
$store =D('Store_physical')->where(array('store_id' => $store_id,'pigcms_id' => $store_id))->find();
$store['logo'] = getAttachmentUrl($store['logo']);
include display('pay_cashier');
}

import('Http');
$http = new Http();

$store_id=$_REQUEST['store_id'];
$physical_id=$_REQUEST['pid'];
$openid=$_REQUEST['openid'];
$price=$_REQUEST['price'];
$where=array();
$where['store_id'] = $store_id;
$where['physical_id'] = $physical_id;
$where['order_id'] = $cashier_id;
D('Order_cashier')->where($where)->data(array('price' => $price))->save();
//echo D('Order_cashier')->last_sql;
$nowOrder = D('Order_cashier')->where($where)->find();

$store =D('Store')->where(array('store_id' => $store_id))->find();
$nowOrder['store_name']=$store['name'];
$action = $_REQUEST['action'];

		switch ($action) {

			case 'test':
					import('source.class.OrderPay');
					$order_pay = new OrderPay();
					$order_pay->test();
					break;
			case 'pay_weixin':
			
			$where=array();
            $where['order_id'] = $_REQUEST['order_id'];
			$nowOrder = D('Order_cashier')->where($where)->find();
			$store =D('Store')->where(array('store_id' => $nowOrder['store_id']))->find();
			$nowOrder['store_name']=$store['name'];
			import('source.class.pay.Weixinapp');
					//支付入平台	
					//$user = M('User')->getUserById($uid);	
               $openid	= $nowOrder['openid'];
				if(empty($openid)){
				$openid=$_REQUEST['openid'];
				}
				
				
                $weixin_bind_info = D('Weixin_bind')->where(array('store_id'=>$nowOrder['store_id']))->find();
				if(empty($weixin_bind_info) || empty($weixin_bind_info['wxpay_mchid']) || empty($weixin_bind_info['wxpay_key'])){
				$payType='weixin';
				$payMethodList = M('Config')->get_pay_method();
				
				}else{
			
				$payMethodList[$payType]['config'] = array('pay_weixin_appid' => $weixin_bind_info['authorizer_appid'], 'pay_weixin_mchid' => $weixin_bind_info['wxpay_mchid'], 'pay_weixin_key' => $weixin_bind_info['wxpay_key']);
				
			
				
				
				}

				$payClass = new Weixinapp($nowOrder, $payMethodList[$payType]['config'], $user, $openid);
				$payInfo = $payClass->cashier_pay();

				if ($payInfo['err_code']) {
					json_return(10000, $payInfo['err_msg']);
				} else {
					json_return(0, json_decode($payInfo['pay_data']));
				}
              break;
}


echo ob_get_clean();
?>