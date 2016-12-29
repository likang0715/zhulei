<?php

/**
 * Created by PhpStorm.
 * User: pigcms_21
 * Date: 2015/11/20
 * Time: 13:49
 */
class StoreUserDataModel extends Model
{
    //获取用户 在 店铺的积分数
    public function getpoints_by_storeid($uid,$store_id) {
        //获取的店铺积分 为： 供货商店铺积分
        $now_store = D('Store')->getStore($store_id);
        if(!empty($now_store['drp_supplier_id'])) {
            //顶级供货商店铺id
            $store_supplier = D('StoreSupplier')->getSeller(array( 'seller_id'=> $store_id, 'type'=>'1' ));

            if($store_supplier['supply_chain']){
                $seller_store_id_arr = explode(',',$store_supplier['supply_chain']);
                $store_id = $seller_store_id_arr[1];
            }
        }

        $where = array(
            'uid' => $uid,
            'store_id' => $store_id		//理论上是顶级供货商id
        );


        $return = $this->where($where)->find();
        return $return;

    }
}