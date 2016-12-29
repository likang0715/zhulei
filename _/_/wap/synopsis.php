<?php
/**
 * 分销用户中心
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

$now_store = D('Store')->where(array('store_id'=>$store['store_id']))->find();
$user = $_SESSION['wap_user'];


$supplier_chain = D('Store_supplier')->field('supply_chain')->where(array('seller_id'=>$now_store['store_id']))->find();
$supplier_ids = explode(',', $supplier_chain['supply_chain']);
$supplier_id = $supplier_ids['1'];

//获取供货商信息
$supplier_info = D('Store')->where(array('store_id'=>$supplier_id))->find();

//所属公司
$company_info = D('Company')->where(array('uid'=>$supplier_info['uid']))->find();

//主营类目-父
$category_f = D('Sale_category')->where(array('cat_id'=>$supplier_info['sale_category_fid']))->find();

//主营类目-子
$category_c = D('Sale_category')->where(array('cat_id'=>$supplier_info['sale_category_id']))->find();

include display('synopsis');
echo ob_get_clean();
