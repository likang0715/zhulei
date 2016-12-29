<?php
/**
 * 秒杀活动
 * User: pigcms_21
 * Date:
 * Time:
 */
require_once dirname(__FILE__).'/global.php';

if (empty($_SESSION['wap_drp_store'])) {
    pigcms_tips('您没有权限访问，<a href="./home.php?id=' . $_COOKIE['wap_store_id'] . '">返回首页</a>','none');
}

if (empty($_SESSION['wap_user'])){
    redirect('./login.php?referer=' . urlencode($_SERVER['REQUEST_URI']));
}else if(!empty($_SESSION['wap_user'])){
    $wap_user = $_SESSION['wap_user'];
}

$seckill_id = intval(!empty($_GET['seckill_id'])) ? $_GET['seckill_id'] : '';
$userAddress = M('User_address')->find(session_id(), $wap_user['uid']);

/* 秒杀详细 */
$seckillInfo = D('Seckill')->where(array('pigcms_id'=>$seckill_id))->find();

/* 秒杀活动商品详细 */
if(!empty($seckillInfo['sku_id'])){
    $sql = "select * from ".option('system.DB_PREFIX')."product as pro,".option('system.DB_PREFIX')."product_sku as sku where pro.product_id=sku.product_id and pro.product_id={$seckillInfo['product_id']} and sku.sku_id={$seckillInfo['sku_id']}";

    $productInfo = D('Product')->query($sql);
    $nowProduct = $productInfo[0];
}else if(empty($seckillInfo['sku_id'])){
    $nowProduct = D('Product')->where(array('product_id'=>$seckillInfo['product_id']))->find();
}

//var_dump($productInfo);

include display('seckill_shop111');
echo ob_get_clean();
