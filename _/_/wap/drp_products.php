<?php
/**
 * 分销商品
 * User: pigcms_21
 * Date: 2015/4/17
 * Time: 16:32
 */
require_once dirname(__FILE__).'/global.php';

if (empty($_SESSION['wap_drp_store'])) {
    pigcms_tips('您没有权限访问，<a href="./home.php?id=' . $_COOKIE['wap_store_id'] . '">返回首页</a>','none');
}

import('source.class.ProductDrpDegree');

$store = D('Store')->where(array('store_id'=>$_SESSION['wap_drp_store']['store_id']))->find();

$action = $_REQUEST['action'] ? $_REQUEST['action'] : 'index';
/*
$product = M('Product');
//获取顶级供货商
if($store['drp_level'] > 0 ){
    $root_supplier_id = $store['root_supplier_id'];
}

$where = array();
$where = array('store_id' => $root_supplier_id, 'is_fx' => 1, 'status' => 1);
$drp_level = $store['drp_level']; //分销商级别

$page = max(1, $_REQUEST['page']);
$limit = 6;

$product_count = $product->supplierFxProductCount($where);

$page = min($page, ceil($product_count / $limit));
$offset = abs(($page - 1) * $limit);
$products = $product->supplierFxProducts($where, $offset, $limit);

$productDrpDegree = new ProductDrpDegree;

   $productDrpDegree = new ProductDrpDegree;
   $reward = $productDrpDegree->reckonProductProfit($store['store_id'],$products);

exit;*/
$productDrpDegree = new ProductDrpDegree;
$reward = $productDrpDegree->reckonProductProfit($store['store_id'],$products);
list($fxDegreeName,$icoPath) = $productDrpDegree->getStoreDegree($store['store_id']);

switch($action){
    case 'index' :
        if (IS_AJAX) {
            if ($_GET['ajax'] == 1) {
                $product = M('Product');
                //获取顶级供货商
                if($store['drp_level'] > 0 ){
                    $root_supplier_id = $store['root_supplier_id'];
                }

                $where = array();
                $where = array('store_id' => $root_supplier_id, 'is_fx' => 1, 'status' => 1);
                $drp_level = $store['drp_level']; //分销商级别

                $page = max(1, $_REQUEST['page']);
                $limit = 15;

                $product_count = $product->supplierFxProductCount($where);

                $page = min($page, ceil($product_count / $limit));
                $offset = abs(($page - 1) * $limit);
                $products = $product->supplierFxProducts($where, $offset, $limit);
                $productDrpDegree = new ProductDrpDegree;
                $reward = $productDrpDegree->reckonProductProfit($store['store_id'],$products);
                $json_return = array();
                $json_return['noNextPage'] = true;
                $json_return['drp_level'] = $drp_level;
                $json_return['list'] = $reward;
                $json_return['max_page'] = ceil($product_count / $limit);
                json_return(0, $json_return);
            }
               json_return(1002, '缺少访问参数');
        }
    }

include display('drp_products');
echo ob_get_clean();
