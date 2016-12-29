<?php

/**
 * 平台二维码
 * User: pigcms_21
 * Date: 2015/4/24
 * Time: 10:57
 */
require_once dirname(__FILE__) . '/global.php';

$user_info = !empty($_SESSION['wap_user']) ? $_SESSION['wap_user'] : array();
if(empty($user_info)){
    redirect('./login.php');
}

$action = $_POST['act'];

//平台数据
$promote_array = array();
$promote_array['name'] = option('config.site_name');
$promote_array['logo'] = option('config.site_logo');

//推广信息
$promote = D('Store_promote_setting')->where(array('type'=>1,'status'=>1,'owner'=>2))->find();

//获取平台推广二维码
$qrcode = M('Recognition')->get_platform_limit_scene_qrcode('limit_scene_'.$user_info['uid']);

if($action == 'down'){

    $result = M('Store_promote_setting')->createImage($promote,$qrcode,$user_info,$promote_array);
    if($qrcode['error_code'] == 1001){
        exit(json_encode(array('error_code'=>1001,'message'=>$qrcode['msg'])));
    } elseif (empty($promote)){
        exit(json_encode(array('error_code'=>1001,'message'=>'未设置平台推广')));
    } else {
        exit(json_encode(array('error_code'=>0,'message'=>$result[0])));
    }

}

$store_url = option('config.wap_site_url').'?uid='.$user_info['uid'].'';

//分享配置 start
$share_conf = array(
    'title'     => $promote_array['site_name'], // 分享标题
    'desc'      => str_replace(array("\r", "\n"), array('', ''), $promote['content']), // 分享描述
    'link'      => $store_url, // 分享链接
    'imgUrl'    => $promote_array['logo'], // 分享图片链接
    'type'      => '', // 分享类型,music、video或link，不填默认为link
    'dataUrl'   => '', // 如果type是music或video，则要提供数据链接，默认为空
);

import('WechatShare');
$share = new WechatShare();
$shareData = $share->getSgin($share_conf);
//分享配置 end

include display('promotion_platform');
echo ob_get_clean();




