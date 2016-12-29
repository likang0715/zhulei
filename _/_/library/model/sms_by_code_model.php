<?php 
/*
 * @description: 验证码发送记录模型 
 * User: pigcms-s
 * Date: 2015/08/19
 * Time: 13:22
 */
class sms_by_code_model extends base_model{
	
	public function getCategory($category_id){
		$category = $this->db->where(array('cat_id' => $category_id))->find();
		return $category;
	}
	

	
	public function power($store_id,$type){
		$power = D('Sms_power')->where(array('store_id' => $store_id,'type' => $type,'status' => '1'))->find();
		return $power;
	}
	
	/*
	 *@验证码类短信发送操作
	 *@param： $mobile : 手机号
	 *@param:  $type：   短信操作类型(如： 注册(reg),忘记密码(forget))
	 */
	
	public function send($mobile,$type){
		
		if(empty($mobile)) return false;
		if(!in_array($type,array('reg','forget'))) return false;
		
		//import('MessageFactory');
		$code = rand(1000,9999);
			$params['mobile'] 	= $mobile;
			$params['token'] 	= $type;			

			switch($type) {
				case 'reg':
					//存入cookie
					setcookie("reg_mobile",$mobile, time()+3600000);
					break;
					
				case 'forget':
					setcookie("forget_mobile",$mobile,time()+360000);
					break;	
				
			}
			
			//验证码模板 勿改
			$params['content']  = '【易点茶】您的验证码是：'.$code.'。此验证码5分钟内有效，请不要把验证码泄露给其他人。如非本人操作，可不用理会！';
			$params['sendType'] = 1;
			
			//$return = MessageFactory::method($params, array('SmsMessage'));
		

             import('source.class.SendSms');
		     		
		 	$return	= SendSms::send($params['mobile'],$params['content']);



			$statuscode = "-100000";
			if(!is_array($return)) {
				$arr = explode('#',$return);
				$statuscode = $arr[0];
			} else {
				$statuscode = $return['SmsMessage'];
			} 
			
			if (intval($statuscode)== '0') {
				//写入300秒数据库
				$data = array(
						'mobile' 	=> $mobile,
						'type'		=> $type,
						'code'		=> $code,
						'timestamp' => time(),
						'last_ip'	=> ip2long(get_client_ip())
				);
				D('Sms_by_code')->data($data)->add();		
			}
			
			$return = array('code_return'=>$statuscode);
			return $return;
	}
	
	public function info_notice_send($mobile,$type,$msg,$openid=0){
		import('MessageFactory');
		$code = rand(1000,9999);
		$params['mobile'] 	= $mobile;
		$params['token'] 	= $type;
		
		switch($type) {
			case 'goods_status':
				//存入cookie
				setcookie("goods_status_mobile",$mobile, time()+3600000);
				break;
		}
		 
		//验证码模板 勿改
		$params['content']  = $msg;
		$params['sendType'] = 1;
		$return = MessageFactory::method($params, array('SmsMessage'));
		
		
		$statuscode = "-100000";
		if(!is_array($return)) {
			$arr = explode('#',$return);
			$statuscode = $arr[0];
		} else {
			$statuscode = $return['SmsMessage'];
		}
		 
		if (intval($statuscode)== '0') {
			//写入300秒数据库
			$data = array(
					'mobile' 	=> $mobile,
					'type'		=> $type,
					'code'		=> $code,
					'timestamp' => time()
			);
			D('Sms_by_code')->data($data)->add();
		}
		$return = array('code_return'=>$statuscode);
		
		
		if($openid){
			//发送模板消息
			import('source.class.Factory');
			import('source.class.MessageFactory');
			
			$template_data = array(
					'wecha_id' => $openid,
					'first'    => '短信 和 通知 成功，恭喜您成为 simon 的实验对象。',
					'keyword1' => "这是一个name",
					'keyword2' => "13856905308",
					'keyword3' => date('Y-m-d H:i:s', time()),
					'remark'   => '状态：' . "啥状态？"
			);
			$params['template'] = array('template_id' => 'OPENTM201752540', 'template_data' => $template_data);
			$moban = array('TemplateMessage');
			MessageFactory::method($params,$moban);
		}
		
		return $return;
	}
	
	
}