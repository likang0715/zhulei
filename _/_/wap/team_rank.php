<?php

/**
 * 分销商
 * User: pigcms_21
 * Date: 2015/4/24
 * Time: 10:57
 */
require_once dirname(__FILE__) . '/global.php';

if ($_SESSION['wap_drp_store']) {
    $store = $_SESSION['wap_drp_store'];
} else {
    redirect('./ucenter.php?id=' . intval(trim($_COOKIE['wap_store_id'])));
}

$now_store = D('Store')->where(array('store_id'=>$store['store_id']))->find();

/* 获取分销团队 */
$order = 'sales desc';
$limit = '20';
$team_list = D('Drp_team')->where(array('supplier_id'=>$now_store['root_supplier_id']))->order($order)->limit($limit)->select();

/* 获取当前店铺所在团队的所有成员 */
$drp_team = M('Drp_team');
if(empty($now_store['drp_team_id'])){
    $team_members = $drp_team->getMembersByLevel($now_store['store_id'], 0);
}else {
    $where = array();
    $where['drp_team_id'] = $now_store['drp_team_id'];
    $order_by = 'sales desc';
    $team_member = $drp_team->getMembers($where, $order_by);
    $team_members = array();
    $is_owen = false;
    foreach($team_member as $team){
        if($now_store['store_id'] == $team['store_id']){
            $is_owen = true;
        }
        $team_members[] = array(
            'store_id' => $team['store_id'],
            'name' => $team['name'],
            'logo' => $team['logo'],
            'sales' => $team['sales'],
        );
    }
}
include display('team_rank');
echo ob_get_clean();