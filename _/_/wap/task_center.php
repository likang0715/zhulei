<?php
/**
 *  积分明细页面
 */

require_once dirname(__FILE__).'/global.php';

if (empty($wap_user)) {
    redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
}

$store_id = $_GET['store_id'];

$storeInfo = D('Store')->where(array('store_id'=>$store_id))->find();

if (empty($store_id) || !$storeInfo) {
    pigcms_tips('不存在该店铺', 'none');
}
/*
if(empty($storeInfo['drp_supplier_id'])){

    //用户在当前供货商店铺的积分列表
    $user_points_list = D('User_points')->where(array('uid'=>$_SESSION['wap_user']['uid'],'store_id'=>$store_id))->select();

    //用户在当前供货商店铺的总积分
    $user_points_count = D('Store_user_data')->field('store_point')->where(array('uid'=>$_SESSION['wap_user']['uid'],'store_id'=>$store_id))->find();
}else if(!empty($storeInfo['drp_supplier_id'])){
    //用户在当前供货商店铺的积分列表
    $user_points_list = D('User_points')->where(array('uid'=>$_SESSION['wap_user']['uid'],'store_id'=>$storeInfo['root_supplier_id']))->select();

    //用户在当前供货商店铺的总积分
    $user_points_count = D('Store_user_data')->field('store_point')->where(array('uid'=>$_SESSION['wap_user']['uid'],'store_id'=>$storeInfo['root_supplier_id']))->find();
}*/

// 分享链接
$data['share_link'] = M('Share_record')->createLink($store_id, $wap_user['uid']);

include display('task_center');
echo ob_get_clean();

?>