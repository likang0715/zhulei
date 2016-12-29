<?php
/**
 *  订单信息
 */
require_once dirname(__FILE__).'/global.php';

 import('Http');
 $http = new Http();



$physical=explode('-',$_REQUEST['physical']);
$pigcms_id=$physical['1'];
$store_id=$physical['0'];
$now_store = M('Store')->wap_getStore($store_id);
$now_store['logo'] = getAttachmentUrl($now_store['logo']);

 $weixin_bind_info = D('Weixin_bind')->where(array('store_id'=>$store_id))->find();
 
if(empty($weixin_bind_info) || empty($weixin_bind_info['wxpay_mchid']) || empty($weixin_bind_info['wxpay_key'])){
			$openid = $_SESSION['oauth_openid'];

if(empty($openid)){
$code=$_GET['code'];
$tokenUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . option('config.wechat_appid') . '&secret=' . option('config.wechat_appsecret') . '&code=' . $_GET['code'] . '&grant_type=authorization_code';
$return = $http->curlGet($tokenUrl);
$jsonrt = json_decode($return, true);

$openid= $jsonrt['openid'];
}
$type = '1';
				}else{
			import('Http');
			$component_access_token_arr = M('Weixin_bind')->get_access_token($store_id, TRUE);
			
			if ($component_access_token_arr['errcode']) {
				pigcms_tips('与微信通信失败，请重试。');
			}
			
	       	$result = Http::curlGet('https://api.weixin.qq.com/sns/oauth2/component/access_token?appid=' . $weixin_bind_info['authorizer_appid'] . '&code=' . $_GET['code'] . '&grant_type=authorization_code&component_appid=' . option('config.wx_appid') . '&component_access_token=' . $component_access_token_arr['component_access_token']);
			$result = json_decode($result, TRUE);
		
			if ($result['errcode']) {
				pigcms_tips('微信返回系统繁忙，请稍候再试。微信错误信息：' . $result['errmsg']);
			}
			$openid = $result['openid'];
			$type = '2';	
				}

	



$info=array();
$userinfo = D('User')->where(array('openid'=>$openid))->find();
if($userinfo){
$info['name'] = $userinfo['nickname'];
$info['uid'] = $userinfo['uid'];
}
$info['store_id'] = $store_id;
$info['physical_id'] = $pigcms_id;
$info['dateline'] = time();
$info['pay_no'] = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
$info['openid'] = $openid;
$info['type'] = $type;
$cashier_id=D('Order_cashier')->data($info)->add();
include display('paymoney');

echo ob_get_clean();
?>