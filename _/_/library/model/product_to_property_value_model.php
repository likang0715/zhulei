<?php

/**
 * 商品属性值关联数据模型
 * User: pigcms_21
 * Date: 2015/2/11
 * Time: 16:37
 */
class product_to_property_value_model extends base_model {

    public function add($data) {
        $result = $this->db->data($data)->add();
        return $result;
    }

    /**
     * @param $store_id
     * @param $product_id
     * @param $pid
     */
    public function getVids($store_id, $product_id, $pid, $fields = 'vid') {
        $vids = $this->db->field($fields)->where(array('pid' => $pid, 'product_id' => $product_id, 'store_id' => $store_id))->order('order_by ASC')->select();
        return $vids;
    }

    public function getPropertyValues($store_id, $product_id) {
        return $this->db->where(array('store_id' => $store_id, 'product_id' => $product_id))->select();
    }

    public function get_product_property_value($product_id) {
        if (!$product_id) {
            return false;
        }
        $where['product_id'] = $product_id;
        $result = $this->db->where($where)->select();
        $product_property_arr = array();
        foreach ($result as $v) {
            $product_property_arr1[] = $v['pid'];
            $product_property_arr2[] = $v['vid'];
        }
        if ($product_property_arr1 && $product_property_arr2) {
            $Map['pid'] = array('in', array_unique($product_property_arr1));
            $Map['vid'] = array('in', array_unique($product_property_arr2));
            $product_property_arr_list = M('Product_property_value')->getList($Map);

            $new_product_property_arr_list = array();
            $system_product_property_arr = array();
            foreach ($product_property_arr_list as $v) {
                if (!array_key_exists($v['pid'], array_keys($new_product_property_arr_list))) {
                    $new_product_property_arr_list[$v['pid']][] = $v;
                }
            }
            return $new_product_property_arr_list;
        }
    }

}