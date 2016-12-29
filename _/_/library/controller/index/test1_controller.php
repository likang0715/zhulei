<?php
class test1_controller extends base_controller {
	public function __construct() {
		parent::__construct ();
	}
	

	public	function send_notice () {
		
		$action = $_GET['action'];
		
		switch($action) {
			
			case 'end':
				$nowOrder = D('Order')->where(array('order_id'=>2984))->find();
				dump($nowOrder);
				Notice::orderComplete($nowOrder);
				break;

			case 'pay':
				$nowOrder = D('Order')->where(array('order_id'=>2979))->find();
				dump($nowOrder);
				Notice::OrderPaymentSuccess($nowOrder, '测试发送商品哈哈哈哈哈哈');
				break;

			case 'yydb':
				ShopNotice::yydbResultNotice('33','17','259',55);
				break;
				
			//秒杀帮助提醒
			case 'ms':
				ShopNotice::MsHelpNotice('33','17','259',55);
				break;
			
			//保证金不足
			case 'bzj':
				//import('source.class.ShopNotice');
				file_put_contents("./cache/1111.php","\r\n\r\n\r\n"."八八八八八八",FILE_APPEND);
				import('source.class.Margin');
				// echo Margin::check_balance(10000, true, 33);
				ShopNotice::bbjNotice('33','66');
				break;
			
			//保证金不足
			case 'bzj2':
				//import('source.class.ShopNotice');
				//file_put_contents("./cache/1111.php","\r\n\r\n\r\n"."八八八八八八",FILE_APPEND);
				//import('source.class.Margin');
				// echo Margin::check_balance(10000, true, 33);
				Notice::bbjNotice('33','66');
				break;

			//开团
			case 'tuan_start':
					
				ShopNotice::TuanSuccessNotice('17','259','33','13','http://ifeng.com');
				break;
				
			//开团结束通知	
			case 'tuan_end':
				ShopNotice::TuanResultNotice(array('17'),array('259'),'13',13,'http://youku.com');
				break;
				
			//普通通知
			case 'notice':
				// 测试用：simon的 openid
				$openid = "oRiG1wJM8FO4ct98upPXml9XdlK0";	//dd2.pigcms.com
				
				// 发送模板消息
				import ( 'source.class.Factory' );
				import ( 'source.class.MessageFactory' );
			
				$template_data = array (
						'wecha_id' => $openid,
						'first' => '短信 和 通知 成功，恭喜您成为 simon 的实验对象。',
						'keyword1' => "这是一个name",
						'keyword2' => "13856905308",
						'keyword3' => date ( 'Y-m-d H:i:s', time () ),
						'remark' => '状态：' . "啥状态？"
				);
				$params ['template'] = array (
						'template_id' => 'OPENTM201752540',
						'template_data' => $template_data
				);
	
				// MessageFactory::method($params, array('TemplateMessage'));
				$return = MessageFactory::method ( $params, array (
						'TemplateMessage'
				) );
		}
		
	}
	
}