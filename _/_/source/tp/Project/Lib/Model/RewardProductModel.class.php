<?php

/**
 * Created by PhpStorm.
 * User: pigcms_21
 * Date: 2015/11/20
 * Time: 14:07
 */
class RewardProductModel extends Model
{
    /**
     * 根据条件获到赠品产品列表
     * 当limit与offset都为0时，表示不行限制
     */
    public function getList($where, $order_by = '', $limit = 0, $offset = 0) {
        $this->where($where);
        if (!empty($order_by)) {
            $this->order($order_by);
        }

        if (!empty($limit)) {
            $this->limit($offset . ',' . $limit);
        }

        $present_list = $this->select();

        return $present_list;
    }
}