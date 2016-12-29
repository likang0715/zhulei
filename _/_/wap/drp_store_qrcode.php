<?php

/**
 * 店铺二维码
 * User: pigcms_21
 * Date: 2015/4/24
 * Time: 10:57
 */
require_once dirname(__FILE__) . '/global.php';

import('source.class.Drp');
$store_id = $_REQUEST['store_id'] + 0;
$now_store = D('Store')->where(array('store_id'=>$store_id))->find();
$wap_user = !empty($_SESSION['wap_user']) ? $_SESSION['wap_user'] : array();

$action = $_POST['act'];
$store_url = option('config.wap_site_url') . '/home.php?id='.$store_id;

/*获取供货商信息*/
if($now_store['drp_level']>0){
    $supplier_id = $now_store['root_supplier_id'];
} else {
    $supplier_id = $now_store['store_id'];
    //获取当前用户在此供货商下的分销店铺
    //$result = Drp::checkID($store_id,$wap_user['uid']);

    //$store_id = $result['data']['store_id'];
    //if(empty($result['data']['store_id'])){
        $store_id = $now_store['store_id'];
   // }
}
if (empty($now_store)) {
    pigcms_tips('您访问的店铺不存在', 'none');
}

//推广信息
$promote = D('Store_promote_setting')->where(array('store_id'=>$store_id,'type'=>1,'status'=>1,'owner'=>1))->find();
if (empty($promote)) {
    $promote = D('Store_promote_setting')->where(array('store_id'=>$supplier_id,'type'=>1,'status'=>1,'owner'=>1))->find();
}
if($action == 'down'){

    $qrcode = M('Store')->concernRelationship(700000000, $wap_user['uid'], $store_id, $type = '1');
    $result = M('Store_promote_setting')->createImage($promote,$qrcode,$wap_user,$now_store);

    if($qrcode['error_code'] > 1001){
        exit(json_encode(array('error_code'=>$qrcode['error_code'],'message'=>$qrcode['msg'])));
    } elseif (empty($promote)){
        exit(json_encode(array('error_code'=>1001,'message'=>'尚未设置店铺推广')));
    } else {
        exit(json_encode(array('error_code'=>0,'message'=>$result[0])));
    }
}

//分享配置 start
$share_conf = array(
    'title'     => $_SESSION['wap_drp_store']['name'], // 分享标题
    'desc'      => str_replace(array("\r", "\n"), array('', ''), $_SESSION['wap_drp_store']['intro']), // 分享描述
    'link'      => $store_url, // 分享链接
    'imgUrl'    => $_SESSION['wap_drp_store']['logo'], // 分享图片链接
    'type'      => '', // 分享类型,music、video或link，不填默认为link
    'dataUrl'   => '', // 如果type是music或video，则要提供数据链接，默认为空
);

import('WechatShare');
$share = new WechatShare();
$shareData = $share->getSgin($share_conf);
//分享配置 end

include display('drp_store_qrcode');
echo ob_get_clean();




