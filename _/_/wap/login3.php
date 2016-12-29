<?php
/**
 *  用户登录
 */
require_once dirname(__FILE__).'/global.php';

//回调地址
$redirect_uri = $_GET['referer'] ? $_GET['referer'] : ($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : ($_COOKIE['wap_store_id'] ? './home.php?id='.$_COOKIE['wap_store_id'] : $config['site_url']));
if ($redirect_uri == 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) {
	$redirect_uri = option('config.wap_site_url');
}
if(IS_POST){
	// ucenter
	//include_once PIGCMS_PATH.'config.inc.php';
	// 加载ucenter配置
	if(option('config.ucenter_setting')){
		define('UC_DBHOST', option('config.ucenter_dbhost'));			// UCenter 数据库主机
		define('UC_DBUSER', option('config.ucenter_dbuser'));				// UCenter 数据库用户名
		define('UC_DBPW', option('config.ucenter_pwd'));					// UCenter 数据库密码
		define('UC_DBNAME', option('config.ucenter_dbname'));				// UCenter 数据库名称
		define('UC_DBCHARSET', option('config.ucenter_dbcharset'));				// UCenter 数据库字符集
		define('UC_DBTABLEPRE', option('config.ucenter_dbtablepre'));			// UCenter 数据库表前缀

		define('UC_DBCONNECT', '0');

		//通信相关
		define('UC_KEY', option('config.ucenter_key'));				// 与 UCenter 的通信密钥, 要与 UCenter 保持一致
		define('UC_API', option('config.ucenter_api'));	// UCenter 的 URL 地址, 在调用头像时依赖此常量
		define('UC_CHARSET', option('config.ucenter_charset'));				// UCenter 的字符集
		define('UC_IP', option('config.ucenter_dbip'));					// UCenter 的 IP, 当 UC_CONNECT 为非 mysql 方式时, 并且当前应用服务器解析域名有问题时, 请设置此值
		define('UC_APPID', option('config.ucenter_appid'));					// 当前应用的 ID
		define('UC_PPP', '20');

		$dbhost = option('config.ucenter_dbhost');			// 数据库服务器
		$dbuser = option('config.ucenter_dbuser');			// 数据库用户名
		$dbpw = option('config.ucenter_pwd');				// 数据库密码
		$dbname = option('config.ucenter_dbname');			// 数据库名
		$pconnect = 0;				// 数据库持久连接 0=关闭, 1=打开
		$tablepre = option('config.ucenter_dbtablepre');   		// 表名前缀, 同一数据库安装多个论坛请修改此处
		$dbcharset = option('config.ucenter_dbcharset');


		include_once PIGCMS_PATH.'include/db_mysql.class.php';
		$db = new dbstuff;
		$db->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
		unset($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
		include_once PIGCMS_PATH.'uc_client/client.php';	
	}
	
	$username = $_POST['phone'];
	$password = $_POST['pwd'];
	$email = time().rand(1,99).'@sia.com';
	$action = isset($_GET['action']) ? $_GET['action'] : 'login';
	switch($action){
		case 'login':
			if(empty($_POST['phone'])) json_return(1000,'请填写您的手机号码');
			if(empty($_POST['pwd'])) json_return(1001,'请填写您的密码');
			// 如果开启到ucenter中登录
			if(option('config.ucenter_setting')){
				// 到ucenter中验证用户
				list($uid, $username, $password, $email) = uc_user_login($username, $password);
				if($uid <= 0){
					pigcms_tips('用户不存在.');
				}
				$ucsynlogin = uc_user_synlogin($uid);
				$referer = $_POST['referer'];
				echo $ucsynlogin.'<script>window.location.href="'.$referer.'";</script>';
				exit;
			}
			// 否则使用本地登录功能
			$database_user = M('User');
			$get_result = $database_user->get_user('phone',$username);
			if($get_result['err_code'] != 0) pigcms_tips($get_result['err_msg']);
			if(empty($get_result['user'])) pigcms_tips('用户不存在');
			if($get_result['user']['password'] != md5($_POST['pwd'])) pigcms_tips('密码不正确');
			
			$save_user_data = array('login_count'=>$get_result['user']['login_count']+1,'last_time'=>$_SERVER['REQUEST_TIME'],'last_ip'=>ip2long($_SERVER['REMOTE_ADDR']));
			$get_result['user']['openid'] = 'fsdfdsfdsfdsfdsffdsf';
			if(!empty($_SESSION['openid'])){
				array_push($save_user_data,array('openid'=>$_SESSION['openid']));
			}
			$save_result = $database_user->save_user(array('uid'=>$get_result['user']['uid']),$save_user_data);
			if($save_result['err_code'] < 0) pigcms_tips('系统内部错误，请重试');
			if($save_result['err_code'] > 0) pigcms_tips($save_result['err_msg']);

			$_SESSION['wap_user'] = $get_result['user'];
			mergeSessionUserInfo(session_id(),$get_result['user']['uid']);
			header('Location: ' . option('config.wap_site_url'));
			exit;
			break;
		case 'reg':
			if(empty($username)) json_return(1010,'请填写您的手机号码');
			if(empty($password)) json_return(1011,'请填写您的密码');
			//if(empty($_POST['code'])) json_return(1012,'请填写6位短信验证码');
			//if($_POST['code'] != $_SESSION['wap_reg_code']) json_return(1013,'短信验证码填写错误');
			$database_user = D('User');
			if($database_user->field('`uid`')->where(array('phone'=>$_POST['phone']))->find()) json_return(1014,'手机号码已存在');
			if(option('config.ucenter_setting')){
				$uid = uc_user_register($username, $password, $email);
				if($uid <= 0){
					json_return(1,'注册失败');
				}
			}
			$data = array();
			$data['phone']       = trim($_POST['phone']);
			$data['nickname']    = '';
			$data['password']    = md5(trim($_POST['pwd']));
			$data['check_phone'] = 1;
			$data['login_count'] = 1;
			if(!empty($_SESSION['openid'])){
				$data['openid'] = $_SESSION['openid'];
			}
			$add_result = M('User')->add_user($data);
			if($add_result['err_code'] == 0){
				$_SESSION['wap_user'] = $add_result['err_msg'];
				mergeSessionUserInfo(session_id(),$add_result['err_msg']['uid']);
				json_return(0,'注册成功');
			}else{
				json_return(1,$add_result['err_msg']);
			}
	}
}else{
    if (!empty($_SESSION['wap_user'])) {
        redirect($redirect_uri);
    }
	include display('login3');
	echo ob_get_clean();
}
?>