<?php 
/*
 * @description: 验证码发送记录模型 
 * User: pigcms-s
 * Date: 2015/08/19
 * Time: 13:22
 */
class SmsByCodeModel extends Model{
	

	public function sendbycontent($sms_topmain,$sms_key,$mobile,$content="",$sign="",$price) {
		if(!$mobile) {
			$return = array('code_return'=>'-1000');
			return $return;
		}
		import('Sms', './source/class/');
		import('Factory', './source/class/');
		import('MessageFactory', './source/class/');
		$date = date("Y-m-d H:i:s",time());
		
		$params['mobile'] 	= $mobile;

		//$params['token'] = "test#".$sign;
		$params['token'] = "test";
		
		//测试模板 勿改
		$content = $content ? $content : '管理员测试短信发送，发送时间：'.$date.'。';
		$params['content'] = serialize(array('content'=>$content,'sms_key'=>$sms_key,'sms_topmain'=>$sms_topmain,'sms_sign'=>$sign,'sms_price'=>$price));
		
		$return = MessageFactory::method($params, array('SmsMessage'));
		$statuscode = "-100000";
		if(!is_array($return)) {
			$arr = explode('#',$return);
			$statuscode = $arr[0];
		} else {
			$statuscode = $return['SmsMessage'];
		} 	

		$return = array('code_return'=>$statuscode);
		return $return;
		
	}
	
	
	
	/*
	 *@验证码类短信发送操作
	 *@param： $mobile : 手机号
	 *@param:  $type：   短信操作类型(如： 注册(reg),忘记密码(forget))
	 */
	
	public function send($mobile,$type){
		
		if(empty($mobile)) return false;
		if(!in_array($type,array('reg','forget'))) return false;
		
		import('MessageFactory', './source/class/');
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
			$params['content'] = '您的验证码是：'.$code.'。此验证码5分钟内有效，请不要把验证码泄露给其他人。如非本人操作，可不用理会！';

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
				M('Sms_by_code')->data($data)->add();		
			}
			$return = array('code_return'=>$statuscode);
			return $return;
	}
	
	
}