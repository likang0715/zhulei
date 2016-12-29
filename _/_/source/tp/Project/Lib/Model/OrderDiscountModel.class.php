<?php

/**
 * Created by PhpStorm.
 * User: pigcms_21
 * Date: 2015/11/20
 * Time: 15:01
 */
class OrderDiscountModel extends Model
{
    // 根据订单号查询订单折扣
    public function getByOrderId($order_id) {
        if (empty($order_id)) {
            return array();
        }

        $where = array();
        $where['order_id'] = $order_id;

        $order_discount_list = $this->where($where)->select();
        return $order_discount_list;
    }
}