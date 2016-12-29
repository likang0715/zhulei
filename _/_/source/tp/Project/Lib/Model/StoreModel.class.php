<?php

/**
 * Created by PhpStorm.
 * User: pigcms_21
 * Date: 2015/11/20
 * Time: 13:52
 */
class StoreModel extends Model
{
    //用店铺ID获取一个店铺
    public function getStore($store_id, $status = 1){
        $where = array();
        $where['store_id'] = $store_id;
        if (!is_null($status)) {
            if (is_array($status)) {
                $where['status']   = array('IN',  $status);
            } else {
                $where['status']   = $status;
            }
        }
        $store = $this->where(array('store_id'=>$store_id,'status'=>1))->find();
        return $store;
    }

    //由分销store_id 调取供货商
    public function getSupplier($seller_id)
    {
        $store_supplier = D('StoreSupplier')->getSupplier(array('seller_id' => $seller_id));
        $supply_chain = $store_supplier['supply_chain'];
        $supply_chain = explode(',', $supply_chain);
        $supplier_id = !empty($supply_chain[1]) ? $supply_chain[1] : $store_supplier['supplier_id'];
        $supplier = $this->getStore($supplier_id, null);
        return $supplier;
    }
}