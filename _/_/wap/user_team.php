<?php

/**
 * 分销商
 * User: pigcms_21
 * Date: 2015/4/24
 * Time: 10:57
 */
require_once dirname(__FILE__) . '/global.php';

if ($_SESSION['wap_drp_store']) {
    $now_store = $_SESSION['wap_drp_store'];
} else {
    redirect('./ucenter.php?id=' . intval(trim($_COOKIE['wap_store_id'])));
}

$drp_team = M('Drp_team');

/* 获取当前店铺的一级分销商 */
if($now_store['drp_level'] == 1){
    $fx_one = $now_store;
}elseif($now_store['drp_level'] > 1){
    $fx_one = D('Store')->where(array('root_supplier_id'=>$now_store['root_supplier_id'], 'drp_level'=>1))->find();
}


if(empty($now_store['drp_team_id'])){
    /*所有者*/
    $auth = $team_info = $now_store;

    /* 成员数量 */
    $numbers = M('Store_supplier')->getSubSellers($fx_one['store_id']);
    $num = !empty($numbers) ? count($numbers) : 1;

    /* 团队排名 */
    $team_num = $drp_team->getTeamRank($team_info['pigcms_id']);

    /* 直属成员总数、总销售额、总订单数 */
    $directly_members = $drp_team->getMemberCountByLevel($now_store['store_id'],$now_store['drp_level']+1,true,true);

    /* 二级成员总数、总销售额、总订单数 */
    $second_members = $drp_team->getMemberCountByLevel($now_store['store_id'],$now_store['drp_level']+2,true,true);

    /* 下下级分销供货商 */
    $fxSupplierInfo = D('Store')->where(array('drp_supplier_id'=>$now_store['store_id'],'drp_level'=>$now_store['drp_level']+2))->find();

    /* 成员标签别名 */
    $member_lable = D('Drp_team_member_label')->where(array('team_id'=>$team_info['pigcms_id']))->select();

}else{

    /* 成员数量 */
    $numbers = M('Store_supplier')->getSubSellers($fx_one['store_id']);
    $num = !empty($numbers) ? count($numbers) : 1;

    $team_info = D('Drp_team')->where(array('pigcms_id'=>$now_store['drp_team_id']))->find();

    /*所有者*/
    $auth = D('Store')->field('name')->where(array('store_id'=>$team_info['store_id']))->find();

    /* 团队排名 */
    $team_num = $drp_team->getTeamRank($team_info['pigcms_id']);

    /* 直属成员总数、总销售额、总订单数 */
    $directly_members = $drp_team->getMemberCountByLevel($now_store['store_id'],$now_store['drp_level']+1,true,true);

    /* 二级成员总数、总销售额、总订单数 */
    $second_members = $drp_team->getMemberCountByLevel($now_store['store_id'],$now_store['drp_level']+2,true,true);
    /* 下下级分销供货商 */
    $fxSupplierInfo = D('Store')->where(array('drp_supplier_id'=>$now_store['store_id'],'drp_level'=>$now_store['drp_level']+2))->find();

    /* 成员标签别名 */
    $member_lable = D('Drp_team_member_label')->where(array('team_id'=>$team_info['pigcms_id']))->select();
}

include display('user_team');
echo ob_get_clean();




