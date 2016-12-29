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

//当前登录分销商详情
$store_detail = $_SESSION['wap_drp_store'];
$product_id = $_GET['product_id'];

//获取商品详情
$product_detail = D('Product')->where(array('product_id'=>$product_id))->find();
$price      = ($product_detail['drp_level_' . $drp_level . '_price'] > 0) ? $product_detail['drp_level_' . $drp_level . '_price'] : $product_detail['price'];
import('source.class.ProductDrpDegree');
$productDrpDegree = new ProductDrpDegree;
$profit = $productDrpDegree->productDegree($store_detail['store_id'],$product_id);

include display('drp_product_detail');

echo ob_get_clean();