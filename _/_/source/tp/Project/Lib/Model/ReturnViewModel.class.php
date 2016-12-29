<?php

/**
 * 商品退货数据视图
 * User: pigcms_21
 * Date: 2016/5/12
 * Time: 14:19
 */
class ReturnViewModel extends ViewModel
{
    protected $viewFields = array(
        'Return' => array('*', '_as' => 'r'),
        'Order' => array('useStorePay', 'storePay', 'payment_method', 'third_id', 'address_user', 'address_tel', '_on' => 'o.order_id = r.order_id', '_as' => 'o'),
        'ReturnProduct' => array('product_id', 'sku_id', 'sku_data', 'pro_num', 'pro_price', 'supplier_id', '_on' => 'rp.return_id = r.id', '_as' => 'rp'),
        'User' => array('nickname' , '_on' => 'u.uid = r.uid', '_as' => 'u')
    );
}