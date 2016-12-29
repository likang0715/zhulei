<?php
/**
 *  店铺主页
 */
//引入文件
require_once dirname(__FILE__) . '/global.php';


if (empty($_SESSION['wap_user'])){

}else if(!empty($_SESSION['wap_user'])){
    $wap_user = $_SESSION['wap_user'];
}

$action = !empty($_GET['action']) ? $_GET['action'] : '';

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

if ($nowProduct['postage_type']) {
    $postage_template = M('Postage_template')->get_tpl($nowProduct['postage_template_id'], $nowProduct['store_id']);
    if ($postage_template['area_list']) {
        foreach ($postage_template['area_list'] as $value) {
            if (!isset($min_postage)) {
                $min_postage = $max_postage = $value[2];
            } else if ($value[2] < $min_postage) {
                $min_postage = $value[2];
            } else if ($value[2] > $max_postage) {
                $max_postage = $value[2];
            }
        }
    }
    if ($min_postage == $max_postage) {
        $nowProduct['postage'] = $min_postage;
    } else {
        $nowProduct['postage_tpl'] = array('min' => $min_postage, 'max' => $max_postage);
    }
} else {
    $nowProduct['postage'] = $product_original['postage'];
}

$now_store = M('Store')->wap_getStore($nowProduct['store_id']);
//$now_store = D('Store')->where(array('store_id'=>$nowProduct['store_id']))->find();

if($action == 'check'){
    $is_check = D('Order')->where(array('uid'=>$wap_user['uid'],'activity_id'=>$_POST['seckill_id']))->count('order_id');

    json_return('0',$is_check);
}
include display('seckill_shop');
echo ob_get_clean();
?>