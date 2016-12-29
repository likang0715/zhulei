<?php

/**
 * Created by PhpStorm.
 * User: pigcms_21
 * Date: 2015/11/20
 * Time: 13:54
 */
class StoreSupplierModel extends Model
{
    //获取符合条件的单个分销商
    public function getSeller($where)
    {
        $seller = $this->where($where)->find();

        return $seller;
    }

    //获取符合条件的单个供货商
    public function getSupplier($where)
    {
        $supplier = $this->where($where)->find();

        return $supplier;
    }
}