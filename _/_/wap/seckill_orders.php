<?php
/**
 * 秒杀活动
 * User: pigcms_21
 * Date:
 * Time:
 */
require_once dirname(__FILE__) . '/global.php';


if (empty($_SESSION['wap_user'])){
    redirect('./login.php?referer=' . urlencode($_SERVER['REQUEST_URI']));
}else if(!empty($_SESSION['wap_user'])){
    $wap_user = $_SESSION['wap_user'];
}

$where = array();
$where['type'] = 53;
$where['activity_type'] = 'seckill';
$where['uid'] = $wap_user['uid'];
$where['status'] = array('!=',5);

//活动订单
$orders = D("Order")->where($where)->order('order_id DESC')->select();
$ordersCount = D('Order')->where($where)->count('order_id');

$orderList = array();
foreach($orders as $order){

    $order_product = D('Order_product')->where(array('order_id'=>$order['order_id']))->find();
    /* 订单商品详细 */
    if(!empty($order_product['sku_id'])){
        $sql = "select * from ".option('system.DB_PREFIX')."product as pro,".option('system.DB_PREFIX')."product_sku as sku where pro.product_id=sku.product_id and pro.product_id={$order_product['product_id']} and sku.sku_id={$order_product['sku_id']}";

        $productInfo = D('Product')->query($sql);
        $nowProduct = $productInfo[0];
    }else if(empty($order_product['sku_id'])){
        $nowProduct = D('Product')->where(array('product_id'=>$order_product['product_id']))->find();
    }

    $orderList[] = array(
        'order_id' => $order['order_id'],
        'order_no' => $order['order_no'],
        'sub_total' => $order['sub_total'],
        'status' => $order['status'],

        'product_id' => $nowProduct['product_id'],
        'product_image' => getAttachmentUrl($nowProduct['image'],FALSE),
        'product_name' => $nowProduct['name'],
    );
}

include display('seckill_orders');
echo ob_get_clean();
