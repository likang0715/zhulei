<?php

class recognition_controller extends base_controller{
	public function see_login_qrcode(){
		$qrcode_return = M('Recognition')->get_login_qrcode();
		if($qrcode_return['error_code']){
			echo '<html><head></head><body>'.$qrcode_return['msg'].'<br/><br/><font color="red">请关闭此窗口再打开重试。</font></body></html>';
		}else{
			$this->assign($qrcode_return);
			$this->display();
		}
	}
	public function see_register_qrcode(){

		
		$qrcode_return = M('Recognition')->get_login_qrcode();
		if($qrcode_return['error_code']){
			echo '<html><head></head><body>'.$qrcode_return['msg'].'<br/><br/><font color="red">请关闭此窗口再打开重试。</font></body></html>';
		}else{
			$this->assign($qrcode_return);
			$this->display();
		}
	}

	//仅关注
	public function see_attention_qrcode(){
	
		$qrcode_return = M('Recognition')->get_attention_qrcode();
		if($qrcode_return['error_code']){
			echo '<html><head></head><body>'.$qrcode_return['msg'].'<br/><br/><font color="red">请关闭此窗口再打开重试。</font></body></html>';
		}else{
			$this->assign($qrcode_return);
			$this->display();
		}
	}
	
	//注册绑定用户
	public function see_register_bind_qrcode(){
		

		$nickname = $_GET['nickname'];
		$password = $_GET['password'];
		$code = $_GET['code'];
		$phone = $_GET['phone'];
		
		if(empty($phone) || empty($nickname) || empty($password) || empty($code)) {
			echo '<html><head></head><body>绑定的手机信息填写不完整！<br/><br/><font color="red">请关闭此窗口再打开重试。</font></body></html>';
			EXIT;
		}
		
		$info = array(
				'phone' => $phone,
				'nickname' => $nickname,
				'password' => $password
		);
		
		$qrcode_return = M('Recognition')->get_login_qrcode($info);
		//dump($qrcode_return);
		if($qrcode_return['error_code']){
			echo '<html><head></head><body>'.$qrcode_return['msg'].'<br/><br/><font color="red">请关闭此窗口再打开重试。</font></body></html>';
		}else{
			$this->assign($qrcode_return);
			$this->display();
		}
	}	
	public function see_tmp_qrcode(){
		if(empty($_GET['qrcode_id'])){
			json_return(1,'无法得到二维码图片！');
		}
		$qrcode_return = M('Recognition')->get_tmp_qrcode($_GET['qrcode_id']);
		json_return(0,$qrcode_return);
	}
}