<?php
class Weixin{
	protected $order_info;
	protected $pay_config;
	protected $user_info;
	protected $openid;

	public function __construct($order_info,$pay_config,$user_info,$openid){
		$this->order_info = $order_info;
		$this->pay_config = $pay_config;
		$this->user_info  = $user_info;
		$this->openid  = $openid;
	}
	public function pay(){
		if(empty($this->pay_config['pay_weixin_appid']) || empty($this->pay_config['pay_weixin_mchid']) || empty($this->pay_config['pay_weixin_key'])){
			return array('err_code'=>1,'err_msg'=>$this->pay_config['pay_weixin_appid'].'~微信支付缺少配置信息！'.$this->pay_config['pay_weixin_mchid'].'请联系管理员处理或选择其他支付方式。'.$this->pay_config['pay_weixin_key']);
		}
		if(empty($this->openid)){
			return array('err_code'=>1,'err_msg'=>'没有获取到用户的微信资料，无法使用微信支付');
		}
		import('source.class.pay.Weixinnewpay.WxPayPubHelper');
		//使用jsapi接口
		$jsApi = new JsApi_pub($this->pay_config['pay_weixin_appid'],$this->pay_config['pay_weixin_mchid'],$this->pay_config['pay_weixin_key']);
		//使用统一支付接口
		$unifiedOrder = new UnifiedOrder_pub($this->pay_config['pay_weixin_appid'],$this->pay_config['pay_weixin_mchid'],$this->pay_config['pay_weixin_key']);
		$unifiedOrder->setParameter("openid",$this->openid);//商品描述
		$unifiedOrder->setParameter("body",$this->order_info['order_no_txt']);//商品描述
		//自定义订单号，此处仅作举例
		$unifiedOrder->setParameter("out_trade_no",$this->order_info['trade_no']);//商户订单号
		$unifiedOrder->setParameter("total_fee",round($this->order_info['total']*100));//总金额
		$unifiedOrder->setParameter("notify_url",option('config.wap_site_url').'/paynotice.php');//通知地址
		$unifiedOrder->setParameter("trade_type","JSAPI");//交易类型
		$unifiedOrder->setParameter("attach",'weixin');//附加数据
		$prepay_result = $unifiedOrder->getPrepayId();
		if($prepay_result['return_code'] == 'FAIL'){
			return array('err_code'=>1,'err_msg'=>'没有获取微信支付的预支付ID，请重新发起支付！<br/><br/>微信支付错误返回：'.$prepay_result['return_msg']);
		}
		if($prepay_result['err_code']){
			return array('err_code'=>1,'err_msg'=>'没有获取微信支付的预支付ID，请重新发起支付！<br/><br/>微信支付错误返回：'.$prepay_result['err_code_des']);
		}

		//=========步骤3：使用jsapi调起支付============
		$jsApi->setPrepayId($prepay_result['prepay_id']);

		return array('err_code'=>0,'pay_data'=>$jsApi->getParameters());
	}

	public function qrcodePay()
	{

		if(empty($this->pay_config['pay_weixin_appid']) || empty($this->pay_config['pay_weixin_mchid']) || empty($this->pay_config['pay_weixin_key'])){
			return array('err_code'=>1,'err_msg'=>'微信支付缺少配置信息！请联系管理员处理或选择其他支付方式。');
		}
		if(empty($this->openid)){
			return array('err_code'=>1,'err_msg'=>'没有获取到用户的微信资料，无法使用微信支付');
		}

		import('source.class.pay.Weixinnewpay.WxPayPubHelper');
		//使用jsapi接口

		$jsApi = new JsApi_pub($this->pay_config['pay_weixin_appid'],$this->pay_config['pay_weixin_mchid'],$this->pay_config['pay_weixin_key']);
		//使用统一支付接口
		$unifiedOrder = new UnifiedOrder_pub($this->pay_config['pay_weixin_appid'],$this->pay_config['pay_weixin_mchid'],$this->pay_config['pay_weixin_key']);
		$unifiedOrder->setParameter("openid",$this->openid);//商品描述
		$unifiedOrder->setParameter("body",$this->order_info['order_no_txt']);//商品描述
		//自定义订单号，此处仅作举例
		$unifiedOrder->setParameter("out_trade_no",$this->order_info['trade_no']);//商户订单号
		$unifiedOrder->setParameter("total_fee",round($this->order_info['total']*100));//总金额
		$unifiedOrder->setParameter("notify_url",option('config.wap_site_url').'/paynotice.php');//通知地址
		$unifiedOrder->setParameter("trade_type", "NATIVE");//交易类型
		$unifiedOrder->setParameter("attach",'weixin');//附加数据

		$prepay_result = $unifiedOrder->getPrepayId();
		if($prepay_result['return_code'] == 'FAIL'){
			return array('err_code'=>1,'err_msg'=>'没有获取微信支付的预支付ID，请重新发起支付！<br/><br/>微信支付错误返回：'.$prepay_result['return_msg']);
		}
		if($prepay_result['err_code']){
			return array('err_code'=>1,'err_msg'=>'没有获取微信支付的预支付ID，请重新发起支付！<br/><br/>微信支付错误返回：'.$prepay_result['err_code_des']);
		}

		//=========步骤3：得到微信的二维码============
		$jsApi->setPrepayId($prepay_result['prepay_id']);
		return $prepay_result['code_url'];
	}

	public function notice(){
		$array_data = json_decode(json_encode(simplexml_load_string($GLOBALS['HTTP_RAW_POST_DATA'], 'SimpleXMLElement', LIBXML_NOCDATA)), true);

		if($array_data && $array_data['trade_type'] != 'APP'){
			$nowOrder = D('Order')->field('storePay as store_id,`useStorePay`,`storeOpenid`')->where(array('trade_no'=>$array_data['out_trade_no']))->find();
			if($nowOrder['useStorePay']){
				$weixin_bind_info = D('Weixin_bind')->where(array('store_id'=>$nowOrder['store_id']))->find();
				if(empty($weixin_bind_info) || empty($weixin_bind_info['wxpay_mchid']) || empty($weixin_bind_info['wxpay_key'])){
					return array('err_code'=>1,'err_msg'=>'商家未配置正确微信支付');
				}
				$this->pay_config = array('pay_weixin_appid'=>$weixin_bind_info['authorizer_appid'],'pay_weixin_mchid'=>$weixin_bind_info['wxpay_mchid'],'pay_weixin_key'=>$weixin_bind_info['wxpay_key']);
			}
		}

		if(empty($this->pay_config['pay_weixin_appid']) || empty($this->pay_config['pay_weixin_mchid']) || empty($this->pay_config['pay_weixin_key'])){
			return array('err_code'=>1,'err_msg'=>'微信支付缺少配置信息！请联系管理员处理或选择其他支付方式。');
		}

		import('source.class.pay.Weixinnewpay.WxPayPubHelper');
		//使用通用通知接口
		$notify = new Notify_pub($this->pay_config['pay_weixin_appid'],$this->pay_config['pay_weixin_mchid'],$this->pay_config['pay_weixin_key']);
		//存储微信的回调
		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
		$notify->saveData($xml);

		//验证签名，并回应微信。
		if($notify->checkSign() == FALSE){
			$notify->setReturnParameter("return_code","FAIL");//返回状态码
			$notify->setReturnParameter("return_msg","签名失败");//返回信息
			return array('err_code'=>1,'err_msg'=>$notify->returnXml());
		}else{
			$notify->setReturnParameter("return_code","SUCCESS");//设置返回码
			if($notify->data['return_code']=='SUCCESS' && $notify->data['result_code']=='SUCCESS'){
				$order_param['trade_no']  = $notify->data['out_trade_no'];
				$order_param['pay_type'] = 'weixin';
				$order_param['third_id']  = $notify->data['transaction_id'];
				$order_param['pay_money'] = $notify->data['total_fee']/100;
				$order_param['third_data'] = $notify->data;
				$order_param['echo_content'] = $notify->returnXml();
				return array('err_code'=>0,'order_param'=>$order_param);
			}else{
				return array('err_code'=>1,'err_msg'=>'支付时发生错误！<br/>错误提示：'.$e->GetMessage().'<br/>错误代码：'.$e->Getcode());
			}
		}

	}

	public function refund($from_tp = false) {
		if(empty($this->pay_config['pay_weixin_appid']) || empty($this->pay_config['pay_weixin_mchid']) || empty($this->pay_config['pay_weixin_key'])){
			return array('err_code'=>1,'err_msg'=>'微信支付缺少配置信息！请联系管理员处理或选择其他支付方式。');
		}
		if(empty($this->openid)){
			return array('err_code'=>1,'err_msg'=>'没有获取到用户的微信资料，无法使用微信支付');
		}

		if (!$from_tp) {
			import('source.class.pay.Weixinnewpay.WxPayPubHelper');
		} else {
			import('WxPayPubHelper', './source/class/pay/Weixinnewpay');
		}

		//使用统一支付接口
		$refund_order = new Refund_pub($this->pay_config['pay_weixin_appid'],$this->pay_config['pay_weixin_mchid'],$this->pay_config['pay_weixin_key']);

		$refund_order->setParameter("transaction_id", $this->order_info['transaction_id']);//微信订单号
		$refund_order->setParameter("out_trade_no", $this->order_info['out_trade_no']);//商户订单号
		$refund_order->setParameter("out_refund_no", $this->order_info['out_refund_no']);//退款单号
		$refund_order->setParameter("total_fee", floatval($this->order_info['total_fee'] * 100));//总金额
		$refund_order->setParameter("refund_fee", floatval($this->order_info['refund_fee'] * 100));//退款金额
		$refund_order->setParameter("op_user_id", $this->pay_config['pay_weixin_mchid']);//操作员

		$xml = $refund_order->createXml();

		return array('err_code'=>0, 'pay_data' => $refund_order->getResult($xml));
	}
}
?>