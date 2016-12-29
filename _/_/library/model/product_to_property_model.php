<?php
/**
 * 商品属性关联数据模型
 * User: pigcms_21
 * Date: 2015/2/11
 * Time: 16:29
 */
    class product_to_property_model extends base_model
    {

        public function add($data)
        {
            $result = $this->db->data($data)->add();
            return $result;
        }

        //获取商品属性id
        public function getPids($store_id, $product_id, $fields = 'pid')
        {
            $pids = $this->db->field($fields)->where(array('store_id' => $store_id, 'product_id' => $product_id))->order('order_by ASC')->select();
            return $pids;
        }

        public function getPropertyNames($store_id, $product_id)
        {
            return $this->db->where(array('store_id' => $store_id, 'product_id' => $product_id))->select();
        }
    }