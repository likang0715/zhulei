<?php
/**
 * 商品-活动模型
 */
class product_activity_model extends base_model{

    public function getOne($where){
        $product_activitys = $this->db->where($where)->select();
        return $product_activitys;
    }

}