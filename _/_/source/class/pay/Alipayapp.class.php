<?php

class Alipayapp {

    protected $order_info;
    protected $user_info;


    public function __construct($order_info, $user_info) {
        $this->order_info = $order_info;
        $this->user_info = $user_info;
        
    }

    public function pay() {
        require('Alipayapp/alipay_rsa.function.php');
        require('Alipayapp/alipay.config.php');
		
		
		
		
		
		//商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = $this->order_info['order_no'].'_'.$this->order_info['trade_no'];

        //订单名称，必填
        $subject = $this->order_info['order_no'] . '_alipay';

        //付款金额，必填
        $total_fee = $this->order_info['total'];

        //收银台页面上，商品展示的超链接，必填
        $show_url = $_POST['WIDshow_url'];

        //商品描述，可空
        $body = $_POST['WIDbody'];



/************************************************************/

//构造要请求的参数数组，无需改动
$parameter = array(
		"service"       => $alipay_config['service'],
		"partner"       => $alipay_config['partner'],
		"seller_id"  => $alipay_config['seller_id'],
		"payment_type"	=> $alipay_config['payment_type'],
		"notify_url"	=> option('config.wap_site_url') . '/paynotice.php',
	//	"return_url"	=> option('config.wap_site_url') . '/alipay_callback.php',
		"_input_charset"	=> trim(strtolower($alipay_config['input_charset'])),
		"out_trade_no"	=> $out_trade_no,
		"subject"	=> $subject,
		"total_fee"	=> $total_fee,
		//"show_url"	=> $show_url,
		//"app_pay"	=> "Y",//启用此参数能唤起钱包APP支付宝
		"body"	=> $body,
		//其他业务参数根据在线开发文档，添加参数.文档地址:https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.2Z6TSk&treeId=60&articleId=103693&docType=1
        //如"参数名"	=> "参数值"   注：上一个参数末尾需要“,”逗号。
		
);
		
		
	 $param = '';
        $sign  = '';

        foreach ($parameter AS $key => $val)
        {
		   
        $param .= $key.'="' .$val. '"&';


        }
		$param = substr($param, 0, -1);

			
$rsaSign = rsaSign($param,$alipay_config['private_key']);
$rsaSign = urlencode($rsaSign);
$param=$param.'&sign="'.$rsaSign.'"&sign_type="RSA"';	
  
       return  $param;
    }

   
}

?>