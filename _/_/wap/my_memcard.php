<?php
/**
 *  会员卡
 */
require_once dirname(__FILE__).'/global.php';

if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));

$action = $_REQUEST['action'];
switch($action) {

	//条形码
	case 'txm':

		import('source.class.scanCode');
		$code = $wap_user['uid'];
		if(!$code) return false;
		//应用场景
		$scene = strtonumber(option('config.site_url') . '/card');
		//条形码文本
		$code_text = sprintf("%010d", $code);
		//条形码内容
		$code_value = '1-' . $scene . '-' . $code;
		$code_value = sprintf("%010s", $code_value);
		$barcode = new scanCode($code_value, $code_text);
		$barcode->createBarCode();
		return;
		break;
		
	case 'ewm':
		import('phpqrcode');
		//应用场景
		$scene = strtonumber(option('config.site_url') . '/card');
		$code = $wap_user['uid'];
		$code = '2-' . $scene . '-' . $code;
		QRcode::png(urldecode($code),false,2,7,2);
		return;
		break;
	case 'store_ewm':
		import('phpqrcode');
		//应用场景
		$scene = strtonumber(option('config.site_url') . '/card');
		$code = $_GET['store_id'];
		$code = '2-' . $scene . '-' . $code;
		QRcode::png(urldecode($code),false,2,7,2);
		return;
		break;
}


$avatar = $wap_user['avatar'] ? $wap_user['avatar']:getAttachmentUrl('images/touxiang.png', false);
$wap_user['point_balance'] = !empty($wap_user['point_balance']) ? $wap_user['point_balance'] : 0;

//分享配置 start  
$share_conf 	= array(
	'title' 	=> option('config.site_name').'-会员卡', // 分享标题
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

include display('index_memcard');

echo ob_get_clean();
?>