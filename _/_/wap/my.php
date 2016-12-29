<?php
/**
 *  微网站首页
 */
require_once dirname(__FILE__).'/global.php';

if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));

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


//回调地址
$redirect_uri = $config['wap_site_url'];
//退出登录
switch($_GET['action']) {
	case 'quit':
		
			unset($_SESSION['wap_user']);
			unset($_SESSION['oauth_user']);
			if(option('config.ucenter_setting')){
				$res = uc_user_synlogout();
				echo $res.'<script>window.location.href="'.$redirect_uri.'";</script>';
				exit;
			}
			redirect($redirect_uri);exit;
		break;
	case 'checkpassword':
			$passwd = md5($_POST['passwd']);
			if($passwd == $wap_user['password']){
				echo 1;exit;
			}
			echo 0;exit;
		break;
}
	
	
$now_hour = date('H',$_SERVER['REQUEST_TIME']);
if($now_hour>22 || $now_hour<4){
	$time_tip = '午夜好';
}else if($now_hour < 9){
	$time_tip = '早上好';
}else if($now_hour < 12){
	$time_tip = '上午好';
}else if($now_hour < 19){
	$time_tip = '下午好';
}else{
	$time_tip = '晚上好';
}

$stores = D('Store')->where(array('uid' => $wap_user['uid']))->select();
if (!empty($stores)) {
	foreach ($stores as &$store) {
		$store['logo'] = !empty($store['logo']) ? getAttachmentUrl($store['logo']) : '../static/images/default_shop.png';
	}
}

$user_info = D('User')->where("uid='".$wap_user['uid']."'")->find();

$setting = D('Credit_setting')->find();

//分享配置 start  
$share_conf 	= array(
	'title' 	=> option('config.site_name').'-用户中心', // 分享标题
	'desc' 		=> str_replace(array("\r","\n"), array('',''),   option('config.seo_description')), // 分享描述
	'link' 		=> 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], // 分享链接
	'imgUrl' 	=> option('config.site_logo'), // 分享图片链接
	'type'		=> '', // 分享类型,music、video或link，不填默认为link
	'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);
//分享配置 end

$avatar_tmp = M('User')->getAvatarById($wap_user['uid']);
$avatar = !empty($avatar_tmp) ? getAttachmentUrl($avatar_tmp) : getAttachmentUrl('images/touxiang.png', false);
$point_shop = D('Store')->where(array('is_point_mall'=>1,'status'=>1))->find();

//读取是否开启我的账号密码确认配置项
$allow_account_pwd_confirm = option('config.allow_account_pwd_confirm');

include display('index_my');

echo ob_get_clean();
?>