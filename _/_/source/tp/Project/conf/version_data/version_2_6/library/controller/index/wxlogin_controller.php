<?php
/**
 * 微信登录
 */
class wxlogin_controller extends base_controller{
	
	
	public function ajax_weixin_bind_login(){
		session_write_close();
		for ($i = 0; $i < 8; $i++) {
			$database_login_qrcode = D('Login_qrcode');
			$condition_login_qrcode['id'] = $_GET['qrcode_id'];
			$now_qrcode = $database_login_qrcode->where($condition_login_qrcode)->find();
			if (!empty($now_qrcode['uid'])) {
				//$database_login_qrcode->where($condition_login_qrcode)->delete();
				$result = M('User')->autologin('uid',$now_qrcode['uid']);
	
				if(empty($result['err_code'])){
					if($result['user']) {
						if($result['user']['status']!=1) {
							exit('no_power_to_login');
						}
					} else {
						exit('no_user');
					}
					
					if((!empty($result['user']['phone']) && !empty($result['user']['openid'])) || (!empty($result['user']['openid']) && $result['user']['weixin_bind'] == 2)) {
						session_start();
						$_SESSION['user'] = $result['user'];
						if($now_qrcode['lng']) {
							//写入cookie
							$lbs_distance_limit = option("config.lbs_distance_limit");
							$lbs_distance_limit = $lbs_distance_limit ? $lbs_distance_limit:0;
							$cookie_arr = array(
									'long' => $now_qrcode['lng'],
									'lat' => $now_qrcode['lat'],
									'lbs_distance_limit' => $lbs_distance_limit,
									'timestamp' => time()
							);
							
							setcookie("Web_user", json_encode($cookie_arr), time() + 3600 * 24 * 365);
						}
						$database_login_qrcode->where($condition_login_qrcode)->delete();
						exit('true');
					} else {
						//exit('to_mobile_bind');
						sleep(1);
						continue;
					}
					

				}else if($result['err_code'] == 1001){
					sleep(1);
					continue;
				}else if($result['err_code']){
					exit('false');
				}
			}
				
			sleep(1);
		}
	
		exit('no_power_to_logins');
	}
	
	
	//查看是否关注
	public function ajax_weixin_subscribe() {
		session_write_close();	
		
		$database_sub_qrcode = D('Plat_sub_qrcode');
		$condition_sub_qrcode['id'] = $_GET['qrcode_id'];
		$now_qrcode = $database_sub_qrcode->where($condition_sub_qrcode)->find();
		if($now_qrcode['openid']) {
			exit('to_reg');
		} else {
			sleep(2);
			exit('waiting');
		}	
	}
	
	//登录 / 注册 绑定用户信息
	public function ajax_weixin_bind_register(){
		session_write_close();
		for ($i = 0; $i < 8; $i++) {
			$database_login_qrcode = D('Login_qrcode');
			$condition_login_qrcode['id'] = $_GET['qrcode_id'];
			$now_qrcode = $database_login_qrcode->where($condition_login_qrcode)->find();
			if (!empty($now_qrcode['phone'])) {
				//$database_login_qrcode->where($condition_login_qrcode)->delete();
				$result = M('User')->autologin('phone',$now_qrcode['phone']);
				
				if(empty($result['err_code'])){
					if($result['user']) {
						if($result['user']['status']!=1) {
							exit('no_power_to_login');
						}
					} else {
						exit('no_user');
					}
					session_start();
					$_SESSION['user'] = $result['user'];
					if($now_qrcode['lng']) {
						//写入cookie
						$cookie_arr = array(
								'long' => $now_qrcode['lng'],
								'lat' => $now_qrcode['lat'],
								'timestamp' => time()
						);
						setcookie("Web_user", json_encode($cookie_arr), time() + 3600 * 24 * 365);
					}
					$database_login_qrcode->where($condition_login_qrcode)->delete();
					exit('true');
				}else if($result['err_code'] == 1001){
					sleep(1);
					continue;
				}else if($result['err_code']){
					exit('false');
				}
			}
			
			sleep(1);
		}
		
		exit('no_power_to_logins');
	}
		
	//老 备份  (废弃)
	public function ajax_weixin_login(){
		session_write_close();
		for($i=0;$i<8;$i++){
			$database_login_qrcode = D('Login_qrcode');
			$condition_login_qrcode['id'] = $_GET['qrcode_id'];
			$now_qrcode = $database_login_qrcode->field('`uid`')->where($condition_login_qrcode)->find();
			if(!empty($now_qrcode['uid'])){
				if($now_qrcode['uid'] == -1){
					$data_login_qrcode['uid'] = 0;
					$database_login_qrcode->where($condition_login_qrcode)->data($data_login_qrcode)->save();
					exit('reg_user');
				}
				$database_login_qrcode->where($condition_login_qrcode)->delete();
				$result = M('User')->autologin('uid',$now_qrcode['uid']);
				if(empty($result['error_code'])){
					session_start();
					if($result['user']['status']!=1) {
						exit('no_power_to_login');
					}
					$_SESSION['user'] = $result['user'];
					if($now_qrcode['lng']) {		
						//写入cookie
						$cookie_arr = array(
							'long' => $now_qrcode['lng'],
							'lat' => $now_qrcode['lat'],
							'timestamp' => time()
						);
						setcookie("Web_user", json_encode($cookie_arr), time() + 3600 * 24 * 365);		
					}
					
					
					
					exit('true');
				}else if($result['error_code'] == 1001){
					exit('no_user');
				}else if($result['error_code']){
					exit('false');
				}
			}
			if($i==7){
				exit('false');
			}
			sleep(3);
		}
	}
}