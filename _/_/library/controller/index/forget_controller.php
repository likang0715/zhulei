<?php

/**
 * User: pigcms-s
 * Date: 2015/08/21
 * Time: 11:23
 */
class forget_controller extends base_controller {
	
	const PRECOOKIES = 'cpi18as4af';
	
	public function __construct(){
		parent::__construct();
		header("Cache-control:no-cache,no-store,must-revalidate");
		header("Pragma:no-cache");
		header("Expires:-1");
		
		if (!empty($this->user_session)) {
			redirect(url('index:index'));exit;
		}
		//check开启短信找密
		if($this->is_used_sms == '0') {
			//redirect(url('index:index'));exit;
		}
	}
	
	/*
	 * data：当为:decode的时候：为需要解密的加密串，当为encode的时候 为：需要加密的串
	 * type: decode  or  encode
	 * */
	private function acookies($data,$type) {
		$len = strlen(self::PRECOOKIES);
		$pre = self::PRECOOKIES;
		switch($type) {
				
			case 'encode':
				$data = $pre.$data.$pre;
				$return = $pre.base64_encode($data);
				break;
	
			case 'decode':
				$data = substr($data,$len);
				$return = base64_decode($data);
				$return = substr($return,$len,-$len);
				break;
		}
		return $return;
	}	

	
	// ajax 验证手机号是否注册
	public function checkaccount() {
		$username = $_POST ['username'];
		
		if (preg_match ( "/^[-a-zA-Z0-9_\.]+\@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$/i", $username )) {
			echo json_encode ( array ('status' => '1','msg' => '尚未开启邮箱找回密码！'));
			exit();
		}		
		if (!preg_match ( "/^1[3|5|7|8|9]{1}[0-9]{9}$/i", $username )) {
			echo json_encode ( array ('status' => '2','msg' => '该手机号不正确！' ));
			exit();
		}
		

				
		
		$user = D ('User')->where ( array('phone' => $username))->find();
		if (!$user) {
			echo json_encode ( array ('status' => '3','msg' => '对不起该手机号未注册！' ) );
			exit();
		}
		
		echo json_encode ( array ('status' => '0','msg' => 'ok！' ) );
		exit();
	}
	
	// ajax 检测所填验证码是否正确
	public function checkCaptcha() {
		if ($_SESSION ['verify'] != md5 ( $_GET ['verify'] )) {
			echo json_encode ( array ('status' => '1','msg' => '验证码填写不正确！' ) );
			exit();
		}
		echo json_encode ( array ('status' => '0','msg' => '填写正确！' ) );
		exit();
	}
	
	// 验证码
	public function verify() {
		import ( 'source.class.Image' );
		Image::buildImageVerify();
	}
	
	// 密码找回
	public function password_find() {
		$step = $_GET ['step'];
		
		//读取cookie mobile
		if(!in_array($step,array('two'))) {
			$formobile = $_COOKIE['formobile'];
			$cookie_mobile = $this->acookies($formobile,'decode');
			$cookie_mobile_pass = substr_replace($cookie_mobile,'****',3,4);

			if (!preg_match ( "/^1[3|5|7|8|9]{1}[0-9]{9}$/i", $cookie_mobile)) {
				$this->display();
				exit;
			}		

			$this->assign($cmobile,$cookie_mobile_pass);			
		}
		$name = "sfor_step";

		$cookie_step = $_COOKIE['sfor_step'];
		switch ($step) {
			// 找回密码第二步
			case 'two' :
				setcookie($name,"2",time()+86400);
				$this->_password_find_two();
				exit();
				break;
			
			// 找回密码第二步 手机找回pass
			case 'two_getbytel':
				
				if($cookie_step>='2') {
					setcookie($name,"3",time()+86400);
					$this->display('two_getbytel');
				} else{
					redirect(url('forget:password_find'));
				}
					exit();
				break;
			case 'third_vermobile':
				
				if($cookie_step>='3') {
					setcookie($name,"4",time()+86400);
					$this->_vermobile($cookie_mobile);
				}else {
					redirect(url('forget:password_find',array('step'=>'two')));
					
				}
				exit();
				break;
				
			//发送验证码	
			case 'sendcode':
				if($cookie_step!='3')  return;
				$mobile = $_REQUEST['mobile'];
				//验证code
				$identify_code = $_REQUEST['identify_code'] ? $_REQUEST['identify_code'] : '';
				$this->_sendcode($mobile,$cookie_mobile,$identify_code);	
				break;
			//更改验证码
			case 'pset_password':
					if($cookie_step >= 4)  {
						setcookie($name,"5",time()+86400);
						$this->_pset_password($cookie_mobile);
						exit();
					} else {
						redirect(url('forget:password_find',array('step'=>'two')));
						exit;
					}
				break;
				
				
				
			default :
				$this->display();
		}
	}
	
	//第二步展示拥有找回密码方式
	private function _password_find_two() {
		
		$mobile = $_POST['username'];
		
		/*预留邮箱找回密码方式*/
/* 		if (ereg("^[-a-zA-Z0-9_\.]+\@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$",$username)) {
			
		} */

		if (!preg_match ( "/^1[3|5|7|8|9]{1}[0-9]{9}$/i", $mobile)) {	
			$this->display('password_find');
			exit;
			
		}
		$en_mobile = $this->acookies($mobile,'encode');
		setcookie("formobile",$en_mobile,time()+60*60*24);

		$user = D('User')->where(array('phone'=>$mobile))->find();

		
		$this->assign("user", $user);
		$this->display("password_find_two");
	}
	
	// 第三步验证并操作找回密码操作
	private function _vermobile($cookie_mobile) {
		$verify = $_POST['verify']; // 验证码
		$code 	= $_POST ['code']; // 短信验证码
		$mobile = $_POST ['mobile']; // get的 手机号
		
		
		/*if ($_SESSION ['verify'] != md5 ( $verify )) {
			echo json_encode ( array ('status' => '1','msg' =>'验证码填写不正确！'));
			exit();
		}*/
		
		if (!preg_match ( "/^1[3|5|7|8|9]{1}[0-9]{9}$/i", $cookie_mobile )) {
			echo json_encode ( array ('status' => '2','msg' => '该手机号不正确！'));
			exit();
		}
		if(empty($code)) {
			echo  json_encode(array('status'=>'3','msg'=>'短信验证码为空！'));
			exit();
		}
		$cookie_mobile_pass = substr_replace($cookie_mobile,'****',3,4);
		if($mobile != $cookie_mobile_pass) {
			echo json_encode ( array ('status' => '4','msg' => $mobile.'手机号异常，请重新操作！'.$cookie_mobile_pass));
			exit();
		}		
		
		// 验证短信验证码 是否正确
		$times = time()-300;
		$record_sms = D('Sms_by_code')->where(array('mobile' => $cookie_mobile, 'type' => 'forget','timestamp'=>array('>',$times)))->order("id desc")->limit(1)->find();
		if($record_sms['code']!= $code) {
			echo  json_encode(array('status'=>'5','msg'=>'验证码已过期或错误，请重新发送！'));
			exit();
		}
		if(IS_AJAX) {
			echo  json_encode(array('status'=>'0','msg'=>''));
			exit();
			
		}
		$this->display('vermobile');
	}
	
	private function _sendcode($mobile,$cookie_mobile,$verify) {
		if($verify) {
			if ($_SESSION ['verify'] != md5($verify)) {
				echo json_encode ( array ('status' => '1','msg' => '验证码填写不正确！' ) );
				exit();
			}
		}
		$cookie_mobile_pass = substr_replace($cookie_mobile,'****',3,4);
				
		if($mobile != $cookie_mobile_pass) {
			echo json_encode ( array ('status' => '2','msg' => '手机号异常，请重新操作！'));
			exit();
		}		
		
		$record_sms = D('Sms_by_code')->where(array('mobile' => $cookie_mobile, 'type' => 'forget'))->order("id desc")->limit(1)->find();
		if(time() - $record_sms['timestamp'] <= 300) {
			echo json_encode(array('status' => '4','code'=>$record_sms['code'] , 'msg' => '短信验证码已发送至手机，请及时操作！'));exit;
		}
		

		//发送具体操作
		$return = M('Sms_by_code')->send($cookie_mobile,'forget');
	
		if($return['code_return']=='0') {
			echo json_encode(array('status' => '0','code'=>$record_sms['code'] , 'msg' => '短信验证码已发送至手机，请及时操作！'));exit;
		} else {
			switch($return['code_return']) {
				case '4085':
						echo json_encode(array('status' => '4085','msg' => '该手机号验证码短信每天只能发五个！'));exit;
					break;
				case '4084':
						echo json_encode(array('status' => '4084','msg' => '该手机号验证码短信每天只能发四个！'));exit;
					break;
				case '4030':
						echo json_encode(array('status' => '4030','msg' => ' 手机号码已被列入黑名单 ！'));exit;
					break;
				case '408':
						echo json_encode(array('status' => '408','msg' => '您的帐户疑被恶意利用，已被自动冻结，如有疑问请与客服联系！'));exit;
					break;
				default:
						echo json_encode(array('status' => $return['code_return'],'msg' => '该手机号操作异常！'));exit;
					break;
						
			}
			
		}
	}
	
	
	//重置密码操作
	private function _pset_password($cookie_mobile) {
		$referer = isset($_REQUEST['referer']) ? trim($_REQUEST['referer']) : '';
		if (empty($referer)) {
			$referer = url("forget:password_find");
		}

		header_nocache();	
		if (IS_POST) {
			$mobile = $_POST ['username'];
			$password = $_POST ['password'];
			$passwordagain = $_POST ['passwordagain'];
			
			if($mobile != $cookie_mobile) {
				echo json_encode ( array ('status' => '2','msg' => '手机号异常，请重新操作！'));
				exit();
			}			
			
			if (strlen ( $password ) < 6 || strlen ( $password ) > 16) {
				echo json_encode ( array ('status' => '3','msg' => '密码长度不符合规范长度！' ) );
				exit();
			}
			
			if ($password != $passwordagain) {
				echo json_encode ( array ('status' => '4','msg' => '两次输入的密码不一致！') );
				exit();
			}
			
			if (!preg_match ( "/^1[3|5|7|8|9]{1}[0-9]{9}$/i", $cookie_mobile )) {
				echo json_encode ( array ('status' => '5',	'msg' => '该手机号不正确！' ) );
				exit();
			}
			
			// 实例化user_model
			$user_model = M ( 'User' );
			$user_model->save_user ( array ('phone' => $cookie_mobile ), array ('password' => md5($password)));
			setcookie("formobile","",time()-60*60*24);
			
			//
			$data = array();
			$data['phone'] = $cookie_mobile;
			$data['password'] = md5($password);
			$user = D('User')->where($data)->find();
			// 设置登录成功session
			if($user) $_SESSION['user'] = $user;
			
			echo json_encode ( array ('status' => '0','msg' => '修改成功','data' => array ('nexturl' => 'refresh' )) );
			exit();
		}
		$this->display("pset_password");
	}
}