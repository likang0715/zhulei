<?php
/**
 * Created by PhpStorm.
 * User: pigcms-s
 * Date: 2015/5/29
 * Time: 13:48
 */
class public_controller extends base_controller{


	function __construct() {
		parent::__construct();
		$action =  ACTION_NAME;
		$require_login =array('dologin');
/*
		if(in_array($action,$require_login)) {
			//必须登录 才能操作
			if (empty($this->user_session)) {
				redirect(url('account:login'));
				exit;
			}
		}
*/
	}

	//全pc 弹窗登陆
	public function dologin() {

		$return_url = $_GET['return_url'];
		$url = $_SERVER['HTTP_REFERER'];
		$url = $return_url?$return_url:$url;


		$this->display();
	}
	
	public function checkLogin(){
		if (empty($this->user_session)) {
			json_return(1,'noLogin');
			exit;
		}else{
			json_return(0,'logined');
			exit;
		}
	}

}
