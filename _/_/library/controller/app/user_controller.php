<?php
class user_controller extends base_controller{
	public function index() {
		
	}
	
	/**
	 * 通过手机号和密码登录
	 */
	public function check_login() {
		$phone = $_POST['phone'];
		$password = $_POST['password'];
		$type = $_POST['type'];
		if (empty($phone)) {
			json_return(1000, '请填写手机号');
		}
		
		if (empty($password)) {
			json_return(1000, '请填写密码');
		}
		
		$user = D('User')->where(array('phone' => $phone, 'password' => md5($password)))->find();
		if (empty($user)) {
			json_return(1000, '手机号或密码不正确');
		}
		
		$_SESSION['app_user'] = $user;
		
		$data = array();
		$data['uid'] = $user['uid'];
		$data['openid'] = $user['app_openid'] ? $user['app_openid'] : 'pigcms';
		
		$data['time'] = time();
		$data['sign'] = $this->get_sign($data);
		
		json_return(0, array('url' => option('config.wap_site_url') . '/auto_login.php?' . http_build_query($data)));
		// json_return(0, '登录成功');
	}
	
	/**
	 * 用户注册
	 */
	public function register() {
		$phone = $_POST['phone'];
		$password = $_POST['password'];
		
		if (empty($phone)) {
			json_return(1000, '请填写手机号');
		}
		
		if (empty($password)) {
			json_return(1000, '请填写密码');
		}
		
		if (!preg_match("/^[0-9]{5,12}$/i", $phone)) {
			json_return(1000, '手机号格式不正确');
		}
		
		$user = D('User')->where(array('phone' => $phone))->find();
		if (!empty($user)) {
			json_return(1000, '此手机号已注册');
		}
		
		$data = array();
		$data['nickname'] = '';
		$data['phone'] = $phone;
		$data['password'] = md5($password);
		$return = M('User')->add_user($data);
		if ($return['err_code']) {
			json_return(1000, $return['err_msg']);
		} else {
			json_return(0, $return['err_msg']);
		}
	}
	
	public function login() {
		$openid = $_REQUEST['openid'];
		$referer = $_REQUEST['referer'];
		if (empty($openid)) {
			json_return(1000, '缺少参数');
		}
		
		$user = D('User')->where(array('app_openid' => $openid))->find();
		if (empty($user)) {
			json_return(40000);
		}
		
		if (empty($user['phone'])) {
			json_return(40000);
		}
		
		$data = array();
		$data['uid'] = $user['uid'];
		$data['openid'] = $openid;
		$data['type'] = 'APP';
		$data['time'] = time();
		$data['sign'] = $this->get_sign($data);
		$data['referer'] = $referer;
		
		json_return(0, array('url' => option('config.wap_site_url') . '/auto_login.php?' . http_build_query($data)));
	}
	
	public function bind() {
		$openid = $_REQUEST['openid'];
		$phone = $_REQUEST['phone'];
		$nickname = $_REQUEST['nickname'];
		$avatar = $_REQUEST['avatar'];
		$sex = $_REQUEST['sex'];
		$province = $_REQUEST['province'];
		$city = $_REQUEST['city'];
		
		if (empty($openid)) {
			json_return(1000, '缺少参数');
		}
		
		if (empty($phone) || !preg_match("/\d{5,12}$/", $phone)) {
			json_return(1000, '手机号码格式不正确');
		}
		
		$user = D('User')->where(array('phone' => $phone))->find();
		
		if (!empty($user) && $user['app_openid'] == $openid) {
			json_return(0, '绑定成功');
		} else if (!empty($user) && !empty($user['app_openid']) && $user['app_openid'] != $openid) {
			json_return(1000, '手机号已经存在');
		} else if (!empty($user)) {
			$result = D('User')->where(array('uid' => $user['uid']))->data(array('app_openid' => $openid))->save();
			if ($result) {
				json_return(0, '绑定成功');
			} else {
				json_return(0, '绑定失败');
			}
		} else {
			$user = D('User')->where(array('app_openid' => $openid))->find();
			if (!empty($user)) {
				$result = D('User')->where(array('uid' => $user['uid']))->data(array('phone' => $phone))->save();
				
				if ($result) {
					json_return(0, '绑定成功');
				} else {
					json_return(0, '绑定失败');
				}
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
				json_return(0, '绑定成功');
			} else {
				json_return(0, '绑定失败');
			}
		}
	}
	
	/**
	 * 生成跳转到web登录的url参数
	 * $data = array('uid' => 10000, 'openid' => 'openid', 'type' => 'APP', 'time' => time())
	 */
	private function get_sign($data) {
		$sign_salt = option('config.weidian_key') ? option('config.') : 'pigcms';
		
		ksort($data);
		$sign_key = sha1(http_build_query($data));
		
		return $sign_key;
	}
}
?>