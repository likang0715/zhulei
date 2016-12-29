<?php
/**
 * 订单包裹数据模型
 * User: pigcms_21
 * Date: 2015/3/18
 * Time: 14:31
 */

class OrderPackageModel extends Model
{
    public function getPackages($where)
    {
        $packages = $this->where($where)->select();
        return $packages;
    }
} 