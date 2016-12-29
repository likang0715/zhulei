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

$store    = $_SESSION['wap_drp_store'];
$store_id = $store['store_id'];
$store_model      = M('Store');

if (!empty($_GET['id'])) {
    $store_info = $store_model->getUserDrpStore($store['uid'], intval(trim($_GET['id'])), 0);
    if ($store_info = $store_model->getUserDrpStore($store['uid'], intval(trim($_GET['id'])), 0)) { //已有分销店铺，跳转到分销管理页面
        $_SESSION['wap_drp_store'] = $store_info;
        redirect('./home.php?id='.$store_info['root_supplier_id'].'');
    } else {
        redirect('./home.php?id='.$store_info['root_supplier_id'].'');
    }
}

$drp_approve = true;
//供货商
if (!empty($store['drp_supplier_id'])) {
    $supplier = $store_model->getStore($store['drp_supplier_id']);
    $store['supplier'] = $supplier['name'];

    if (!empty($supplier['open_drp_approve']) && empty($store['drp_approve'])) { //需要审核，但未审核
        $drp_approve = false;
    }
}

$store_detail = $store;

$uid = $store['uid'];
$user = D('User')->field('phone,password')->where(array('uid' => $uid))->find();

$login_url = option('config.site_url') . '/user.php?c=user&a=login';

$stores = $store_model->getUserDrpStores($uid, 0, 0);

foreach ($stores as &$store) {
    if (empty($store['logo'])) {
        $store['logo'] = 'images/default_shop.png';
    }
    $store['logo'] = getAttachmentUrl($store['logo']);

    if (!empty($store['drp_supplier_id'])) {
        $supplier = $store_model->getStore($store['drp_supplier_id']);
        $store['supplier'] = $supplier['name'];
    }
}
include display('change_store');
echo ob_get_clean();
