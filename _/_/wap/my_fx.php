<?php
/**
 * 我的分销
 * User: pigcms_21
 * Date: 2015/4/18
 * Time: 14:35
 */
require_once dirname(__FILE__).'/global.php';

if ($_SESSION['wap_drp_store']) {
    $store = $_SESSION['wap_drp_store'];
} else {
    redirect('./ucenter.php?id=' . intval(trim($_COOKIE['wap_store_id'])));
}

$drp_team = M('Drp_team');

$supplier_id = isset($_GET['supplier_id']) ? intval($_GET['supplier_id']) : '';
$level = isset($_GET['level']) ? intval($_GET['level']) : '';

/* 当前登录用户的分销店铺信息 */
$store_info = D('Store')->where(array('store_id'=>$store['store_id']))->find();

$fx_list = $drp_team->getMembersByLevel($supplier_id, $level);



include display('my_fx');
echo ob_get_clean();
