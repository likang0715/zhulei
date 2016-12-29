<?php

/**
 * Created by PhpStorm.
 * User: pigcms_21
 * Date: 2015/11/20
 * Time: 13:35
 */
class OrderCouponModel extends Model
{
    // 根据订单查询使用的优惠券
    public function getList($order_id) {
        if (empty($order_id)) {
            return array();
        }

        $where = array();
        $where['order_id'] = $order_id;

        $order_reward = $this->where($where)->select();

        return $order_reward;
    }
}