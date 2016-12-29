<?php
/**
 *  订单信息
 */
require_once dirname(__FILE__).'/global.php';

setcookie('wap_store_id',$now_store['store_id'],$_SERVER['REQUEST_TIME']+10000000,'/');
$store_id=$_REQUEST['store_id'];
$pigcms_id=$_REQUEST['pid'];
//当前页面的地址
$physical=$store_id.'-'.$pigcms_id;
$customeUrl = $config['wap_site_url'].'/paymoney.php?physical='.$physical;


$weixin_bind_info = D('Weixin_bind')->where(array('store_id'=>$store_id))->find();
if(empty($weixin_bind_info) || empty($weixin_bind_info['wxpay_mchid']) || empty($weixin_bind_info['wxpay_key'])){
			$appid=option('config.wechat_appid');
			$oauthUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri=' . urlencode($customeUrl) . '&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect';
				}else{
$_SESSION['store_weixin_state'] = md5(uniqid());
$oauthUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $weixin_bind_info['authorizer_appid'] . '&redirect_uri=' . urlencode($customeUrl) . '&response_type=code&scope=snsapi_base&state=' . $_SESSION['store_weixin_state'] . '&component_appid=' . option('config.wx_appid') . '#wechat_redirect';	
		
				}

			//代店铺发起获取openid
$type=$_REQUEST['type'];
if($type){

redirect($oauthUrl);
}else{

$url = str_replace('&amp;', '&', $oauthUrl);

import('phpqrcode');
ob_end_clean();
QRcode::png(urldecode($url),false,2,7,2);
include display('shoukuan');
}
?>