<?php
/**
 *  店铺主页
 */
//引入文件
require_once dirname(__FILE__) . '/global.php';
import('source.class.Margin');
import('source.class.Drp');

//获取商品ID
$product_id = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误', 'none');


$allow_platform_drp = option('config.open_platform_drp');
$allow_store_drp = option('config.open_store_drp');

//商品默认展示
$nowProduct = D('Product')->where(array('product_id' => $product_id))->find();






include display('good_app');
echo ob_get_clean();
?>