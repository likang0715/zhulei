<?php
class test_controller extends base_controller {
	public function __construct() {
		parent::__construct ();
	}
	
	// 获取系统的版本
	function get_version() {
		// $domain = "chaibuy.cn";
		$domain = $_GET [domain];
		$url = "http://up.pigcms.cn/oa/admin.php?m=server&c=sys_file&a=getCustomer&domain=" . $domain . "&productid=4";
		$data = "";
		$ch = curl_init ();
		$headers [] = "Accept-Charset: utf-8";
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "GET" );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
		curl_setopt ( $ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1 );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)' );
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
		curl_setopt ( $ch, CURLOPT_AUTOREFERER, 1 );
		// curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		$result = curl_exec ( $ch );
		
		// 关闭curl
		curl_close ( $ch );
		$as = json_decode ( $result );
		$arr = object_array ( $as );
		
		switch ($arr ['version']) {
			
			case '1' :
				$tip = "企业托管版本";
				break;
			
			case '2' :
				$tip = "集团源码版";
				break;
			
			case '3' :
				$tip = "旗舰托管版";
				break;
			
			case '4' :
				$tip = "运营源码版";
				break;
			
			case '5' :
				$tip = "企业源码版";
				break;
			
			case '6' :
				$tip = "集团托管版";
				break;
			
			case '7' :
				$tip = "旗舰源码版";
				break;
			
			case '8' :
				$tip = "运营托管版";
				break;
			
			default :
				$tip = "不明((+﹏+)~ 也许是 营销系统对接的?))，请检查域名！！！";
				break;
		}
		echo "=========================" . $tip . "===============================";
	}
	
	// 同时发送 通知 和 短信
	public function sendnotice() {
		// 测试用：simon的 openid
		//在 d.pigcms.com上  $openid = "opCRPuKTtHgVy_PJOfCQt7FNqFXg";
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
		
		/**
		 * ***********增加 短信发送 start **************
		 */
		$mobile = "13856905308";
		$date = date ( 'Y-m-d H:i:s', time () );
		$params ['sms'] = array (
				'mobile' => $mobile,
				'token' => 'test',
				'content' => '111管理员测试短信发送，发送时间：' . $date . '。',
				'sendType' => 1 
		);
		/**
		 * ***********增加 短信发送 end **************
		 */
		// MessageFactory::method($params, array('TemplateMessage'));
		$return = MessageFactory::method ( $params, array (
				'smsMessage',
				'TemplateMessage' 
		) );
	}
	
	// 打印
	public function sendPrint() {
		import ( 'source.class.ArrayToStr' );
		import ( 'source.class.Factory' );
		import ( 'source.class.MessageFactory' );
		$tmparr = "";
		$company ['name'] = "XXX公司";
		$_POST ['omark'] = "des试试手";
		$company ['tel'] = "0551-66668888";
		$_POST ['ouserName'] = "o用户名";
		$_POST ['ouserTel'] = "o用户电话";
		$_POST ['ouserAddres'] = "o用户地址";
		$Orderarr ['time'] = "11111111";
		$Orderarr ['orderid'] = '88';
		$oarrivalTime = "2";
		$Orderarr ['price'] = "949";
		$Orderarr ['total'] = "6699";
		
		// $tmparr 为 单个订单的商品
		// 根据订单查商品
		$order_no = "20151126154140481350";
		$order_id = "790";
		$uid = 1; // 购买者uid
		
		$product_list = D ( '' )->table ( 'Order_product as op' )->join ( "Product p ON p.product_id = op.product_id", "left" )->where ( "op.order_id=" . $order_id )->field ( "op.pro_price,op.pro_num,p.name,p.product_id " )->select ();
		foreach ( $product_list as $k => &$v ) {
			$v ['price'] = $v ['pro_price'];
			$v ['num'] = $v ['pro_num'];
		}
		$order = D ( 'Order' )->where ( "order_id='" . $order_id . "'" )->find ();
		$shipping_method = "";
		if ($order ['shipping_method'] == 'express') {
			$shipping_method = "快递发送";
		} elseif ($order ['shipping_method'] == 'selffetch') {
			$shipping_method = "上门自提";
		}
		if ($order ['status'] == '1') {
			$status = "未支付";
		} elseif ($order ['status'] == 2) {
			$status = "未支付";
		} elseif ($order ['status'] == 3) {
			$status = "未发货";
		} elseif ($order ['status'] == 4) {
			$status = "已完成";
		} elseif ($order ['status'] == 5) {
			$status = "已取消";
		} elseif ($order ['status'] == 6) {
			$status = "退款中";
		} elseif ($order ['status'] == 7) {
			$status = "已收货";
		}
		
		$address = ! empty ( $order ['address'] ) ? unserialize ( $order ['address'] ) : array ();
		echo $address_detail = $address ['province'] . ' ' . $address ['city'] . ' ' . $address ['area'] . ' ' . $address ['address'];
		
		$nickname = $order ['address_user'] ? $order ['address_user'] : "暂无";
		$phone = $order ['address_tel'] ? $order ['address_tel'] : "暂无";
		
		echo "<pre>";
		print_r ( $product_list );
		echo "<hr>";
		$msg = array (
				'des' => trim ( $_POST ['omark'] ),
				'status' => $status,
				'truename' => trim ( $nickname ),
				'tel' => trim ( $phone ),
				'address' => trim ( $address_detail ),
				'buytime' => $order ['add_time'],
				'orderid' => $order ['order_no'],
				'price' => $order ['sub_total'],
				'total' => $order ['total'],
				'shipping_method' => $shipping_method,
				'list' => $product_list 
		);
		$msg = ArrayToStr::array_to_str ( $msg, 0 );
		

		
		$store_id = 1;
		$companyid = 222; // 无用
		$paid = "1";
		$qr = ""; // 二维码链接
		$type = "222222";
		
		$arrays = array (
				'store_id' => $store_id,
				'token' => 'test',
				'companyid' => $companyid,
				'content' => $msg,
				'paid' => $paid,
				'qr' => $qr,
				'type' => $type 
		);
		
		$params ['printer'] = $arrays;
		
		$return = MessageFactory::method ( $params, array (
				'printerMessage' 
		) );
	}
	
	/**
	 * 检测用户是否已经注册
	 */
	public function checkuser() {
		if ($_POST ['is_ajax'] == 1) {
			
			$mobile = trim ( $_POST ['mobile'] );
			
			if (empty ( $mobile )) {
				echo json_encode ( array (
						'status' => '3',
						'msg' => '手机号为空！' 
				) );
				exit ();
			}
			
			if (! preg_match ( "/^1[3|5|7|8|9]{1}[0-9]{9}$/i", $mobile )) {
				echo json_encode ( array (
						'status' => '2',
						'msg' => '该手机号不正确！' 
				) );
				exit ();
			}
			
			$user = D ( 'User' )->where ( array (
					'phone' => $mobile 
			) )->find ();
			if ($user) {
				// echo json_encode(array('status' => '1', 'msg' => '对不起该手机号已存在！'));
				// exit;
			}
			// echo json_encode(array('status' => '0', 'msg' => '该手机号可以注册'));
			
			// 记录 今日发送次数 （同一手机号 一日最多发3次注册短信）
			// 加载 短信类
			// import('source.class.sms');
			$this->do_send ( $mobile );
		}
	}
	
	//
	public function send_message() {
		$this->display ();
	}
	
	// 发送具体操作
	public function do_send() {
		import ( 'Sms' );
		$sms = new Sms ();
		
		// 发送短信
		$mobile = "13856905308";
		$content = "祝超测试短信接口！";
		$send_time = time ();
		$store_id = "4";
		return; //
		$return = $sms->sendSms ( $store_id, $content, $mobile, $send_time, $charset = 'utf-8', $id_code = '' );
		echo "<pre>";
		print_r ( $return );
		echo json_encode ( $return );
	}
	
	// 发送消息模版
	public function send_tpl() {
		
		// 测试用：simon的 openid
		//在 d.pigcms.com上  $openid = "opCRPuKTtHgVy_PJOfCQt7FNqFXg";
		$openid = "oRiG1wJM8FO4ct98upPXml9XdlK0";	//dd2.pigcms.com
		
		// 发送模板消息
		import ( 'source.class.Factory' );
		import ( 'source.class.MessageFactory' );
		
		/*
		 * $template_data = array(
		 * 'wecha_id' => $openid,
		 * 'first' => '短信 和 通知 成功，恭喜您成为 simon 的实验对象。',
		 * 'keyword1' => "这是一个name",
		 * 'keyword2' => "13856905308",
		 * 'keyword3' => date('Y-m-d H:i:s', time()),
		 * 'remark' => '状态：' . "啥状态？"
		 * );
		 * $params['template'] = array('template_id' => 'OPENTM201752540', 'template_data' => $template_data);
		 */
		
		// 发送模板消息
		import ( 'source.class.Factory' );
		import ( 'source.class.MessageFactory' );
		
		$template_data = array (
				'href' => option ( 'site_url' ) . '/index.php?g=Wap&m=Groupon&a=myOrders',
				'wecha_id' => $openid,
				'first' => '您好，你的订单完成啦',
				'keyword1' => 'weidian_0123456',
				'keyword2' => date ( 'Y-m-d H:i:s' ),
				'remark' => '' 
		);
		$params ['template'] = array (
				'template_id' => 'OPENTM202521011',
				'template_data' => $template_data 
		);
		$return = MessageFactory::method ( $params, array (
				'templateMessage' 
		) );
		
		echo "<pre>";
		print_r ( $return );
	}
	
	// 发送具体操作
	public function do_send1() {
		import ( 'MessageFactory' );
		//在 d.pigcms.com上  $openid = "opCRPuKTtHgVy_PJOfCQt7FNqFXg";
		$openid = "oRiG1wJM8FO4ct98upPXml9XdlK0";	//dd2.pigcms.com
		
		$template_data = array (
				'href' => option ( 'site_url' ) . '/index.php?g=Wap&m=Groupon&a=myOrders',
				'wecha_id' => $openid,
				'first' => '您好，你的订单完成啦',
				'keyword1' => 'weidian_0123456',
				'keyword2' => date ( 'Y-m-d H:i:s' ),
				'remark' => '' 
		);
		$params ['template'] = array (
				'template_id' => 'OPENTM202521011',
				'template_data' => $template_data 
		);
		$params ['mobile'] = '13856905308';
		$params ['token'] = $mobile;
		$params ['content'] = '这是一篇新的短信';
		
		$mobile = "13856905308";
		
		// $register_mobile_cache = F("register-".$mobile);
		
		// file_put_content($arr,FILE_APPEND)
		
		// dump($register_mobile_cache);
		// 验证码 保留120秒
		if (time () - $register_mobile_cache ['time'] <= 120) {
			// 不允发送
			echo '不与发送1111111111=22';
			
			return true;
		}
		
		// 记录短信发送时间
		$cached = array (
				'mobile' => $mobile,
				'time' => time () 
		);
		
		F ( "register-" . $mobile, $cached );
		
		echo "~~";
		exit ();
		
		$return = MessageFactory::method ( $params, array (
				'smsMessage'/*,'templateMessage'*/) );
		echo "<pre>";
		print_r ( $return );
		
		// $this->url_formark('/wap/good.php?id=',$goods_id_arr);
	}
}