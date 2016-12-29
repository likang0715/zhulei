<?php

/**
 * Created by PhpStorm.
 * User: pigcms_21
 * Date: 2015/12/22
 * Time: 13:48
 */
class PlatformIncomeModel extends Model
{
    public function getServiceFee($store_id = null)
    {
        $where = array();
        if (!is_null($store_id)) {
            $where['store_id'] = $store_id;
        }
        $where['type'] = 1;
        $income = $this->where($where)->sum('income');
        return ($income > 0) ? $income : 0;
    }
}