<?php
class users_controller extends base_controller{

	public $arrays=array();
	public $config;
	public $_G;
	public function __construct(){
		global $_G;
		$this->_G = $_G;
		$this->arrays['config'] = $this->config = $_G['config'];
	}
	/**
	 * 通过手机号和密码登录
	 */
	public function mobile_login() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
		$phone = $_REQUEST['phone'];
		$password = $_REQUEST['password'];
		$type = $_REQUEST['type'];
		if (empty($phone)) {
	
			$results['result']='1';
			$results['msg']='请填写手机号';
			exit(json_encode($results));
		}
		
		if (empty($password)) {
			$results['result']='1';
			$results['msg']='请填写密码';
			exit(json_encode($results));
		}
		
		$user = D('User')->where(array('phone' => $phone, 'password' => md5($password)))->find();
		if (empty($user)) {
		$user = D('User')->where(array('nickname' => $phone, 'password' => md5($password)))->find();
		if (empty($user)) {
			$results['result']='1';
			$results['msg']='手机号或密码不正确';
			exit(json_encode($results));
		     }
		}
		$_SESSION['app_user'] = $user;
		
		
		
		$data = array();
		
		if($type){
		if($user['drp_store_id']){
		$store = D('Store')->where(array('store_id' => $user['drp_store_id']))->find();
		}else{
		$store = D('Store')->where(array('uid' => $user['uid']))->find();
		}
		if (empty($store)) {
			$results['result']='1';
			$results['msg']='没有相关店铺';
			exit(json_encode($results));
		     }
		$data['store_id'] = $store['store_id'];
		$data['name'] = $store['name'];
		$data['qrcode'] = $this->config['site_url']."/source/qrcode.php?type=home&id=".$store['store_id'];
		$data['url'] = $this->config['wap_site_url']."/home.php?id=".$store['store_id'];
		$data['info'] = $store['intro'];
		}
		$data['uid'] = $user['uid'];
		$data['openid'] = $user['app_openid'] ? $user['app_openid'] : 'pigcms';
		$data['item_store_id'] = $user['item_store_id'] ? $user['item_store_id'] : ''; 
	//	$data['group'] = !empty($user['group']) ? $user['group'] : '';
		$data['type'] = 'APP';
		$data['time'] = time();
		$data['sign'] = $this->get_sign($data);
		
		$results['data']=$data;
		exit(json_encode($results));
		
	}
	

	
	public function sms_login() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
		$mobile = $_REQUEST['mobile']; // get的 手机号
		$code = $_REQUEST['code'];
		$type = $_REQUEST['type'];
		
		
		if (!preg_match ( "/^1[3|5|7|8|9]{1}[0-9]{9}$/i", $mobile )) {
			$results['result']='1';
			$results['msg']='手机号码格式不正确';
			exit(json_encode($results));
		}
		if(empty($code)) {
			
			$results['result']='1';
			$results['msg']='短信验证码为空';
			exit(json_encode($results));
		}
	
	
		// 验证短信验证码 是否正确
		$times = time()-300;
		$record_sms = D('Sms_by_code')->where(array('mobile' => $mobile, 'is_use' => '0', 'type' => 'forget','timestamp'=>array('>',$times)))->order("id desc")->limit(1)->find();
	
		if($record_sms['code']!= $code) {
			$results['result']='1';
			$results['msg']='验证码已过期或错误，请重新发送！';
			exit(json_encode($results));
		}
		
		
		
		
		
		$user = D('User')->where(array('phone' => $mobile))->find();
		if (empty($user)) {
		   
			$reg=$this->register($mobile);
			if($reg['result']=='1'){
			 $results['result']='1';
			$results['msg']='注册失败！';
			exit(json_encode($results));
			}else{
		   $user = D('User')->where(array('phone' => $mobile))->find();
		   $newuser=1;
			}
		}
	
		
		$data = array();
		
		if($type){
		if($user['drp_store_id']){
		$store = D('Store')->where(array('store_id' => $user['drp_store_id']))->find();
		}else{
		$store = D('Store')->where(array('uid' => $user['uid']))->find();
		}
		if (empty($store)) {
			$results['result']='1';
			$results['msg']='没有相关店铺';
			exit(json_encode($results));
		     }
		$data['store_id'] = $store['store_id'];
		$data['name'] = $store['name'];
		$data['qrcode'] = $this->config['site_url']."/source/qrcode.php?type=home&id=".$store['store_id'];
		$data['url'] = $this->config['wap_site_url']."/home.php?id=".$store['store_id'];
		}
		$data['uid'] = $user['uid'];
		$data['openid'] = $user['app_openid'] ? $user['app_openid'] : 'pigcms';
		$data['item_store_id'] = $user['item_store_id'] ? $user['item_store_id'] : ''; 
	//	$data['group'] = !empty($user['group']) ? $user['group'] : '';
		$data['type'] = 'APP';
		
		$data['newuser'] = $newuser ? $newuser :'0';
		
		$data['time'] = time();
		$data['sign'] = $this->get_sign($data);
		
		$results['data']=$data;
		exit(json_encode($results));
	}
	
	public function wx_login() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
		$openid = $_REQUEST['openid'];
	
		if (empty($openid)) {
			$results['result']='1';
			$results['msg']='缺少参数';
		}
		
		$user = D('User')->where(array('app_openid' => $openid))->find();
		if (empty($user)) {
		$data = array();
		//$data['openid'] = $openid;
		$data['nickname'] = $_REQUEST['nickname'];
		$data['avatar'] = $_REQUEST['avatar'];
		$data['phone'] = ' ';
		$data['password'] = md5(123456);
		$return = M('User')->add_user($data);
		
		$user = D('User')->where(array('uid' => $return['err_msg']['uid']))->find();
		$result = D('User')->where(array('uid' => $user['uid']))->data(array('app_openid' => $openid))->save();
		}
	
		
		$data = array();
		$data['uid'] = $user['uid'];
		$data['openid'] = $user['app_openid'] ? $user['app_openid'] : 'pigcms';
		$data['type'] = 'APP';
		$data['time'] = time();
		$data['sign'] = $this->get_sign($data);
		
		
		$results['data']=$data;
		exit(json_encode($results));
	}
	
	public function bind() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');




//import('source.class.Http');

//$token = Http::curlGet($url);

	 $uid = $_REQUEST['uid'];
		if (empty($uid)) {
		     $results['result']='1';
			$results['msg']='uid不正确';
			exit(json_encode($results));
		}
		$token = $_REQUEST['token'];
		$tokens = D('Users_token')->where(array('uid' => $uid))->find();
		if ($token!=$tokens['token']) {
		     $results['result']='1';
			$results['msg']='token不正确';
			exit(json_encode($results));
		}
		
		$openid = $_REQUEST['openid'];
		$phone = $_REQUEST['phone'];
		$nickname = $_REQUEST['nickname'];
		$avatar = $_REQUEST['avatar'];
		$sex = $_REQUEST['sex'];
		$province = $_REQUEST['province'];
		$city = $_REQUEST['city'];
		
		if (empty($openid)) {
			$results['result']='1';
			$results['msg']='缺少参数';
			exit(json_encode($results));
		}
		
		if (empty($phone) || !preg_match("/\d{5,12}$/", $phone)) {
			
			$results['result']='1';
			$results['msg']='手机号码格式不正确';
			exit(json_encode($results));
		}
		
		
		
		$user = D('User')->where(array('uid' => $uid))->find();
		if($user['phone']){
		$user = D('User')->where(array('phone' => $phone))->find();
		
		
		
		
		}else{
		$type=2;
		}
		
		
		
		
		
		
		
		
		if (!empty($user) && $user['app_openid'] == $openid) {
				$results['msg']='绑定成功';
				exit(json_encode($results));
		} else if (!empty($user) && !empty($user['app_openid']) && $user['app_openid'] != $openid) {
					$results['result']='1';
			$results['msg']='手机号已经存在';
			exit(json_encode($results));
		} else if (!empty($user)) {
			$result = D('User')->where(array('uid' => $user['uid']))->data(array('app_openid' => $openid))->save();
			if ($result) {
				$results['msg']='绑定成功';
			} else {
				$results['result']='1';
				$results['msg']='绑定失败';
			}
			exit(json_encode($results));
		} else {
			$user = D('User')->where(array('app_openid' => $openid))->find();
			if (!empty($user)) {
				$result = D('User')->where(array('uid' => $user['uid']))->data(array('phone' => $phone))->save();
				
				if ($result) {
					$results['msg']='绑定成功';
				} else {
					$results['result']='1';
					$results['msg']='绑定失败';
				}
				exit(json_encode($results));
			}
			
			$data = array();
			$data['nickname'] = $nickname;
			$data['password'] = md5($phone);
			$data['phone'] = $phone;
			$data['app_openid'] = $openid;
			$data['reg_time'] = time();
			$data['reg_ip'] = get_client_ip(1);
			$data['avatar'] = $avatar;
			$data['sex'] = $sex;
			$data['province'] = $province;
			$data['city'] = $city;
			
			$result = D('User')->data($data)->add();
			if ($result) {
				$results['msg']='绑定成功';
			} else {
			    $results['result']='1';
				$results['msg']='绑定失败';
			}
		}
		
		exit(json_encode($results));
	}
	
	/**
	 * 生成跳转到web登录的url参数
	 * $data = array('uid' => 10000, 'openid' => 'openid', 'type' => 'APP', 'time' => time())
	 */
	private function get_sign($data) {
		$sign_salt = option('config.weidian_key') ? option('config.') : 'pigcms';
		$tk['uid']=$data['uid'];
		$tk['addtime']=$data['time'];
		ksort($data);
		$sign_key = sha1(http_build_query($data));
		$tk['token']=$sign_key;
		$user = D('Users_token')->where(array('uid' => $tk['uid']))->find();
		if($user){
		D('Users_token')->where(array('uid' => $tk['uid']))->data($tk)->save();
		}else{
		D('Users_token')->data($tk)->add();
		}
		return $sign_key;
	}
	
	
	
	public function set_password() {
		$results = array('result'=>'0','data'=>array(),'msg'=>'');
		$code 	= $_REQUEST['code']; // 短信验证码
		$mobile = $_REQUEST['mobile']; // get的 手机号
		$password = $_REQUEST['password'];
		
		
		
		if (!preg_match ( "/^1[3|5|7|8|9]{1}[0-9]{9}$/i", $mobile )) {
			$results['result']='1';
			$results['msg']='手机号码格式不正确';
			exit(json_encode($results));
		}
		if(empty($code)) {
			
			$results['result']='1';
			$results['msg']='短信验证码为空';
			exit(json_encode($results));
		}
		if(empty($password)) {
			
			$results['result']='1';
			$results['msg']='密码为空';
			exit(json_encode($results));
		}	
		
		// 验证短信验证码 是否正确
		$times = time()-300;
		$record_sms = D('Sms_by_code')->where(array('mobile' => $mobile, 'is_use' => '0', 'type' => 'forget','timestamp'=>array('>',$times)))->order("id desc")->limit(1)->find();
		
		if($record_sms['code']!= $code) {
			$results['result']='1';
			$results['msg']='验证码已过期或错误，请重新发送！';
			exit(json_encode($results));
		}
		
		if (strlen ( $password ) < 6 || strlen ( $password ) > 16) {
			$results['result']='1';
			$results['msg']='密码长度不符合规范长度';
			exit(json_encode($results));
			}
		
		$user_model = M ( 'User' );
		$user_model->save_user (array ('phone' => $mobile ), array ('password' => md5($password)));
		
		D('Sms_by_code')->data(array('is_use' => '1'))->where(array('mobile' => $mobile, 'type' => 'forget', 'code' => $code))->save();
		exit(json_encode($results));
		
	}
	
	
	
	
	
	
	
	
	public function get_sms() {
	$mobile=$_REQUEST['mobile'];
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
	$now_date_time=strtotime("Y-m-d");
	
		$counts = D('Sms_by_code')->where("type=reg and mobile = '".$mobile."') and timestamp > ".$now_date_time)->field("count(id) counts")->find();

		if($counts['counts'] >= 10) {
			$results['result']='1';
			$results['msg']='对不起您的手机号今日发送已达上限！！';
			exit(json_encode($results));
		}
		$record_sms = D('Sms_by_code')->where(array('mobile' => $mobile, 'type' => 'forget'))->order("id desc")->limit(1)->find();
		if(time() - $record_sms['timestamp']<=300) {
		    $results['msg']='短信验证码已发送至手机，请及时操作！';
			exit(json_encode($results));
		}
		
		$return = M('Sms_by_code')->send($mobile,'forget');
		if($return['code_return']=='0') {
			$results['msg']='短信验证码已发送至手机，请及时操作！';
			exit(json_encode($results));
			}else{
			$results['result']='1';
			$results['msg']='发送失败';
			exit(json_encode($results));
			} 
		
		
		
	}
	
	
	
	
	
		/**
	 * 用户注册
	 */
	private function register($phone) {
	    $results = array('result'=>'0','data'=>array(),'msg'=>'');
		$nickname = $password = $phone;
		
		if (empty($phone)) {
			$results['result']='1';
			$results['msg']='请填写手机号';
			exit(json_encode($results));
		}
		
		if (!preg_match("/^[0-9]{5,12}$/i", $phone)) {
		
			$results['result']='1';
			$results['msg']='手机号格式不正确';
			exit(json_encode($results));
		}
	
		
		$user = D('User')->where(array('phone' => $phone))->find();
		if (!empty($user)) {
		     $results['data']=$user['phone'];
			return $results;
		}
		
		$data = array();
		$data['nickname'] = $nickname;
		$data['phone'] = $phone;
		$data['password'] = md5($password);
		$return = M('User')->add_user($data);
		if ($return['err_code']) {
		
			$results['result']='1';
		
			return $results;
		} else {
		 $user = D('User')->where(array('uid' => $return['err_msg']['uid']))->find();
	
		$results['data']=$user['phone'];
		return $results;
		}
		
	}
	
	
	
	
	
	
	
}
?>