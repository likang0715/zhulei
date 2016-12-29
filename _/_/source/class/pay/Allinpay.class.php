<?php
class Allinpay{
	protected $order_info;
	protected $is_mobile;
	protected $pay_config;
	protected $user_info;
	protected $pickup_url;
	protected $receive_url;
	
	public function __construct($order_info,$pay_config,$user_info,$is_mobile=0,$pickup_url='',$receive_url=''){
		$this->order_info = $order_info;
		$this->is_mobile   = $is_mobile;
		$this->pay_config = $pay_config;
		$this->user_info  = $user_info;
		if (!empty($pickup_url)) {
			$this->pickup_url = $pickup_url;
		}
		if (!empty($receive_url)) {
			$this->receive_url = $receive_url;
		}
	}
	public function pay(){
		if(empty($this->pay_config['pay_allinpay_merchantid']) || empty($this->pay_config['pay_allinpay_merchantkey'])){
			return array('error'=>1,'msg'=>'通联支付缺少配置信息！请联系管理员处理或选择其他支付方式。');
		}
		if($this->is_mobile){
			return $this->mobile_pay();
		}else{
			return $this->web_pay();
		}
	}
	public function mobile_pay(){
		import('source.class.pay.Allinpay.allinpayCore');
		$payerName = !empty($this->user_info['nickname']) ? $this->user_info['nickname'] : $this->order_info['address_user'];
		$productName = !empty($this->order_info['product_name']) ? $this->order_info['product_name'] : '订单支付';
		$allinpayClass = new allinpayCore();
		$pay_url = 'http://service.allinpay.com/mobilepayment/mobile/SaveMchtOrderServlet.action';
		//$pay_url = 'http://ceshi.allinpay.com/mobilepayment/mobile/SaveMchtOrderServlet.action';
		$allinpayClass->setParameter('payUrl',$pay_url); //提交地址
		$allinpayClass->setParameter('pickupUrl',$this->pickup_url); //跳转通知地址
		$allinpayClass->setParameter('receiveUrl',$this->receive_url); //异步通知地址
		$allinpayClass->setParameter('merchantId',$this->pay_config['pay_allinpay_merchantid']); //商户号
		$allinpayClass->setParameter('orderNo',$this->order_info['order_no']); //订单号
		$allinpayClass->setParameter('orderAmount',floatval($this->order_info['total']*100)); //订单金额(单位分)
		$allinpayClass->setParameter('orderDatetime',date('YmdHis',$_SERVER['REQUEST_TIME'])); //订单提交时间
		$allinpayClass->setParameter('productName',$productName); //商品名称
		$allinpayClass->setParameter('productNum',$this->order_info['pro_num']);
		$allinpayClass->setParameter('payType',0); //支付方式
		$payerName && $allinpayClass->setParameter('payerName', $payerName); //付款人
		$allinpayClass->setParameter('key',$this->pay_config['pay_allinpay_merchantkey']); //支付方式
		
		//开始跳转支付
		$form = $allinpayClass->sendRequestForm();
		
		return array('error'=>0,'form'=>$form);
	}
	public function web_pay(){
		import('source.class.pay.Allinpay.allinpayCore');
		$payerName = !empty($this->user_info['nickname']) ? $this->user_info['nickname'] : $this->order_info['address_user'];
		$productName = !empty($this->order_info['product_name']) ? $this->order_info['product_name'] : '订单支付';
		$allinpayClass = new allinpayCore();
		$pay_url = 'https://service.allinpay.com/gateway/index.do';
		//$pay_url = 'http://ceshi.allinpay.com/gateway/index.do';
		$allinpayClass->setParameter('payUrl',$pay_url); //提交地址
		$allinpayClass->setParameter('pickupUrl',$this->pickup_url); //跳转通知地址
		$allinpayClass->setParameter('receiveUrl',$this->receive_url); //异步通知地址
		$allinpayClass->setParameter('merchantId',$this->pay_config['pay_allinpay_merchantid']); //商户号
		$allinpayClass->setParameter('orderNo',$this->order_info['order_no']); //订单号
		$allinpayClass->setParameter('orderAmount',floatval($this->order_info['total']*100)); //订单金额(单位分)
		$allinpayClass->setParameter('orderDatetime',date('YmdHis',$_SERVER['REQUEST_TIME'])); //订单提交时间
		$allinpayClass->setParameter('productName',$productName); //商品名称
		$allinpayClass->setParameter('productNum',$this->order_info['pro_num']);
		$allinpayClass->setParameter('payType',0); //支付方式
		$allinpayClass->setParameter('payerName', $payerName); //付款人
		$allinpayClass->setParameter('key',$this->pay_config['pay_allinpay_merchantkey']); //支付方式

		//开始跳转支付
		$form = $allinpayClass->sendRequestForm();

		return array('error'=>0,'form'=>$form);
	}
	
	public function notice_url(){
		if(empty($this->pay_config['pay_allinpay_merchantid']) || empty($this->pay_config['pay_allinpay_merchantkey'])){
			return array('error'=>1,'msg'=>'通联支付缺少配置信息！请联系管理员处理或选择其他支付方式。');
		}
		if($this->is_mobile){
			return $this->mobile_notice();
		}else{
			return $this->web_notice();
		}
	}
	public function mobile_notice(){
		exit('success');
	}
	public function web_notice(){
		exit('success');
	}
	public function return_url(){
		if(empty($this->pay_config['pay_allinpay_merchantid']) || empty($this->pay_config['pay_allinpay_merchantkey'])){
			return array('error'=>1,'msg'=>'通联支付缺少配置信息！请联系管理员处理或选择其他支付方式。');
		}
		
		import('source.class.pay.Allinpay.allinpayCore');
		$allinpayClass = new allinpayCore();
		$verify_result = $allinpayClass->verify_pay($this->pay_config['pay_allinpay_merchantkey']);
		if(empty($verify_result['error'])){

			$order_param['is_mobile'] = $this->is_mobile;
			$order_param['order_no'] = $verify_result['orderNo'];
			$order_param['trade_no']  = '';
			$order_param['pay_type'] = 'allinpay';
			$order_param['third_id']  = $verify_result['paymentOrderId'];
			$order_param['pay_money'] = $verify_result['pay_money'];
			$order_param['third_data'] = array();
				
			return array('error'=>0,'order_param'=>$order_param);
		}else{
			return array('error'=>1,'msg'=>$verify_result['msg']);
		}
	}
}
?>