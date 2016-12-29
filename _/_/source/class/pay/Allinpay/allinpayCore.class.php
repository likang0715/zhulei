<?php
class allinpayCore{

	/** 支付需要的参数 */
	var $parameters;
	
	/**
	 * 初始化方法
	 */
	public function __construct() {
		$this->parameters = array();
	}
	
	
	/**
	 * 设置参数值
	 * $parameter 键
	 * $parameterValue 值
	 */
	public function setParameter($parameter, $parameterValue) {
		$this->parameters[$parameter] = $parameterValue;
	}
	
	/**
	 * 构建签名，设为signMsg字段值
	 */
	public function setSignMsg(){

		$bufSignSrc  = 'inputCharset=1&';
		$bufSignSrc .= 'pickupUrl='.$this->parameters['pickupUrl'].'&';
		$bufSignSrc .= 'receiveUrl='.$this->parameters['receiveUrl'].'&';
		$bufSignSrc .= 'version=v1.0&';
		$bufSignSrc .= 'signType=0&';
		$bufSignSrc .= 'merchantId='.$this->parameters['merchantId'].'&';
		$this->parameters['payerName'] && $bufSignSrc .= 'payerName='.$this->parameters['payerName'].'&';
		$bufSignSrc .= 'orderNo='.$this->parameters['orderNo'].'&';
		$bufSignSrc .= 'orderAmount='.$this->parameters['orderAmount'].'&';
		$bufSignSrc .= 'orderDatetime='.$this->parameters['orderDatetime'].'&';
		$bufSignSrc .= 'productName='.$this->parameters['productName'].'&';
		$bufSignSrc .= 'productNum='.$this->parameters['productNum'].'&';
		$bufSignSrc .= 'payType=0&';
		$bufSignSrc .= 'tradeNature=GOODS&';
		$bufSignSrc .= 'key='.$this->parameters['key'];

		$this->parameters['signMsg'] = strtoupper(md5($bufSignSrc));
	}
	 
	 
	/**
	 * 建立跳转自动提交表单
	 */
	public function sendRequestForm(){
		//构造签名
		$this->setSignMsg();
		
		//开始构建form表单
		$formHtml = '';
		$param = $this->parameters;
		$formHtml .= '<div style="display: none">';
		$formHtml .= '<form id="allinpaysubmit" name="allinpaysubmit" action="'.$param['payUrl'].'" method="post">';
		$formHtml .= '<input type="hidden" name="inputCharset" value="1"/>';
		$formHtml .= '<input type="hidden" name="pickupUrl" value="' . $param['pickupUrl'] . '"/>';
		$formHtml .= '<input type="hidden" name="receiveUrl" value="' . $param['receiveUrl'] . '"/>';
		$formHtml .= '<input type="hidden" name="version" value="v1.0"/>';
		$formHtml .= '<input type="hidden" name="signType" value="0"/>';
		$formHtml .= '<input type="hidden" name="merchantId" value="' . $param['merchantId'] . '"/>';
		$formHtml .= '<input type="hidden" name="payerName" value="' . $param['payerName'] . '">';
		$formHtml .= '<input type="hidden" name="orderNo" value="' . $param['orderNo'] . '"/>';
		$formHtml .= '<input type="hidden" name="orderAmount" value="' . $param['orderAmount'] . '"/>';
		$formHtml .= '<input type="hidden" name="orderDatetime" value="' . $param['orderDatetime'] . '"/>';
		$formHtml .= '<input type="hidden" name="productName" value="' . $param['productName'] . '"/>';
		$formHtml .= '<input type="hidden" name="productNum" value="' . $param['productNum'] . '"/>';
		$formHtml .= '<input type="hidden" name="payType" value="0"/>';
		$formHtml .= '<input type="hidden" name="tradeNature" value="GOODS"/>';		
		$formHtml .= '<input type="hidden" name="signMsg" value="'.$param['signMsg'].'"/>';
		$formHtml .= '<input type="submit" value="进行支付">';
		$formHtml .= "<script type='text/javascript'>document.forms['allinpaysubmit'].submit();</script>";
		$formHtml .= '</form>';
		$formHtml .= '</div>';
		
		return ($formHtml);
	}
	
	/**
	 * 验签
	 */
	public function verify_pay($key){
		$bufSignSrc = '';
		if($_POST['merchantId'] != '') 		 $bufSignSrc .= 'merchantId='.$_POST['merchantId'].'&';
		if($_POST['version'] != '')   		 $bufSignSrc .= 'version='.$_POST['version'].'&';
		if($_POST['language'] != '')  		 $bufSignSrc .= 'language='.$_POST['language'].'&';
		if($_POST['signType'] != '')  		 $bufSignSrc .= 'signType='.$_POST['signType'].'&';
		if($_POST['payType'] != '')   		 $bufSignSrc .= 'payType='.$_POST['payType'].'&';
		if($_POST['issuerId'] != '')  		 $bufSignSrc .= 'issuerId='.$_POST['issuerId'].'&';
		if($_POST['paymentOrderId'] != '')   $bufSignSrc .= 'paymentOrderId='.$_POST['paymentOrderId'].'&';
		if($_POST['orderNo'] != '')   		 $bufSignSrc .= 'orderNo='.$_POST['orderNo'].'&';
		if($_POST['orderDatetime'] != '')    $bufSignSrc .= 'orderDatetime='.$_POST['orderDatetime'].'&';
		if($_POST['orderAmount'] != '')      $bufSignSrc .= 'orderAmount='.$_POST['orderAmount'].'&';
		if($_POST['payDatetime'] != '')      $bufSignSrc .= 'payDatetime='.$_POST['payDatetime'].'&';
		if($_POST['payAmount'] != '')        $bufSignSrc .= 'payAmount='.$_POST['payAmount'].'&';
		if($_POST['payResult'] != '')    	 $bufSignSrc .= 'payResult='.$_POST['payResult'].'&';
		if($_POST['returnDatetime'] != '')   $bufSignSrc .= 'returnDatetime='.$_POST['returnDatetime'].'&';
		
		$bufSignSrc .= 'key='.$key;
		
		$verify_signMsg =  strtoupper(md5($bufSignSrc));

		if($_POST['signMsg'] == $verify_signMsg){
			if($_POST['payResult'] == 1){
				return array('error'=>0,'orderNo'=>$_POST['orderNo'],'paymentOrderId'=>$_POST['paymentOrderId'],'pay_money'=>$_POST['orderAmount']/100);
			}else{
				return array('error'=>1,'msg'=>'订单支付失败！');
			}
		}else{
			return array('error'=>1,'msg'=>'报文验签失败！');
		}
	}
}
?>