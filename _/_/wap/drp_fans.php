<?php

/**
 * 分销商
 * User: pigcms_21
 * Date: 2015/4/24
 * Time: 10:57
 */
require_once dirname(__FILE__) . '/global.php';

if ($_SESSION['wap_drp_store']) {
    $current_store = $_SESSION['wap_drp_store'];
} else {
    redirect('./ucenter.php?id=' . intval(trim($_COOKIE['wap_store_id'])));
}

import('source.class.user_page');

$store_id = $current_store['store_id'];
$store = D('Store')->field('store_id,name,logo,root_supplier_id')->where(array('store_id' => $store_id, 'uid' => $_SESSION['wap_user']['uid']))->find();
//供货商id
$root_supplier_id = !empty($store['root_supplier_id']) ? $store['root_supplier_id'] : $store_id;

//粉丝总数
$where = array();
$where['store_id'] = $store_id;
$fans_count = M('Store_user_data')->getMemberCount($where);

$page = new Page($fans_count, 6);
//最大页码
$max_page = $page->totalPage;

$fans_list = M('Store_user_data')->getMembers($where, $page->firstRow, $page->listRows);
if (!empty($fans_list)) {
    foreach ($fans_list as $key => $fans) {
        $user = D('User')->field('nickname,avatar')->where(array('uid' => $fans['uid']))->find();
        $sql = "SELECT seller_id FROM " . option('system.DB_PREFIX') . "store_supplier WHERE root_supplier_id = '" . $root_supplier_id . "' AND FIND_IN_SET(" . $store_id . ", supply_chain) AND seller_id IN (SELECT store_id FROM " . option('system.DB_PREFIX') . "store WHERE uid = '" . $fans['uid'] . "')";
        $seller = D('')->query($sql);
        $seller_id = !empty($seller[0]['seller_id']) ? $seller[0]['seller_id'] : 0;
        $fans_list[$key]['nickname'] = !empty($user['nickname']) ? $user['nickname'] : '匿名会员';
        $fans_list[$key]['avatar'] = !empty($user['avatar']) ? getAttachmentUrl($user['avatar']) : getAttachmentUrl('./images/avatar.png');
        $fans_list[$key]['add_time'] = date('Y.m.d', $fans['add_time']);
        $fans_list[$key]['money'] = number_format($fans['money'], 2, '.', '');
        $fans_list[$key]['seller_id'] = $seller_id;
    }
}

if (!empty($_GET['ajax'])) {
    $json_return['fans_list'] = $fans_list;
    $json_return['max_page'] = $max_page;
    if(count($fans_list) < $limit){
        $json_return['noNextPage'] = true;
    }
    json_return(0, $json_return);
}

//今日新增粉丝
$start_time = strtotime(date('Y-m-d') . ' 00:00:00');
$end_time = strtotime(date('Y-m-d') . ' 23:59:59');
$where = array();

$where['store_id'] = $store['store_id'];
$where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $end_time . "'";
$today_fans = M('Store_user_data')->getMemberCount($where);

//昨日新增粉丝
$start_time = strtotime(date("Y-m-d", strtotime("-1 day")) . ' 00:00:00');
$end_time = strtotime(date("Y-m-d", strtotime("-1 day")) . ' 23:59:59');
$where = array();
$where['store_id'] = $store['store_id'];
$where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $end_time . "'";
$yesterday_fans = M('Store_user_data')->getMemberCount($where);

$days = array ();
$dayss = array ();
$tmp_days = array ();
$tmp_dayss = array ();
for ($i = 5; $i >= 0; $i--) {
    $day = date("Y-m-d", strtotime('-' . $i . 'day'));
    $days[] = $day;
}

for ($i = 5; $i >= 0; $i--) {
    $fan_days = date("m-d", strtotime('-' . $i . 'day'));
    $dayss[] = $fan_days;
}

foreach ($days as $day){
    //开始时间
    $start_time = strtotime($day . ' 00:00:00');
    //结束时间
    $stop_time = strtotime($day . ' 23:59:59');

    //七日粉丝流量
    $where = array();
    $where['store_id'] = $store['store_id'];
    $where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $stop_time . "'";
    $every_fans = M('Store_user_data')->getMemberCount($where);
    $data[] = $every_fans;

    $tmp_days[] = "'" . $day . "'";
}

foreach ($dayss as $days){
    $tmp_dayss[] = "'" . $days . "'";
}

//最大刻度
$max = max($data) * 10;

$datas = '[' . implode(',', $data) . ']';
$days = '[' . implode(',', $tmp_dayss) . ']';

//分享配置 start
$share_conf = array(
    'title'    => $store['name'], // 分享标题
    'desc'     => str_replace(array("\r", "\n"), array('', ''), !empty($store['intro']) ? $store['intro'] : $store['name']), // 分享描述
    'link'     => option('config.wap_site_url') . 'home.php?id=' . $store_id, // 分享链接
    'imgUrl'   => getAttachmentUrl($store['logo']), // 分享图片链接
    'type'     => '', // 分享类型,music、video或link，不填默认为link
    'dataUrl'  => '', // 如果type是music或video，则要提供数据链接，默认为空
);
//分享配置 end

import('WechatShare');
$share = new WechatShare();
$shareData = $share->getSgin($share_conf);

include display('drp_fans');
echo ob_get_clean();
