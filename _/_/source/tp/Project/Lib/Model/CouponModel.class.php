<?php

/**
 * Created by PhpStorm.
 * User: pigcms_21
 * Date: 2015/11/20
 * Time: 14:15
 */
class CouponModel extends Model
{
    /**
     * 获取某个优惠券
     */
    public function getCoupon($where) {
        $coupon = $this->where($where)->find();
        return $coupon;
    }

    /**
     * 根据id，返回有效的优惠券
     */
    public function getValidCoupon($id, $uid) {
        $time = time();
        $where = array();
        $where['id'] = $id;
        $where['type'] = 2;
        $where['status'] = 1;
        $where['start_time'] = array('<=', $time);
        $where['end_time'] = array('>=', $time);
        $where['total_amount'] = array('>=', 'number');

        $coupon = $this->getCoupon($where);

        // 当赠送券有领取限制时进行处理
        if ($coupon['most_have'] != '0' && empty($uid)) {
            $where = array();
            $where['uid'] = $uid;
            $where['coupon_id'] = $coupon['id'];
            $where['delete_flg'] = 0;

            $user_coupon_count = M('User_coupon')->getCount($where);
            if ($user_coupon_count >= $coupon['most_have']) {
                return array();
            }
        }

        return $coupon;
    }
}