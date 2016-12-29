<?php
/**
 * 商品自定义字段数据模型
 * User: pigcms_21
 * Date: 2015/2/12
 * Time: 11:47
 */
    class product_custom_field_model extends base_model
    {
        public function add($product_id, $fields)
        {
            foreach ($fields as $field) {
                $this->db->data(array('product_id' => $product_id, 'field_name' => $field['name'], 'field_type' => $field['type'], 'multi_rows' => $field['multi_rows'], 'required' => $field['required']))->add();
            }
        }

        public function delete($product_id)
        {
            $this->db->where(array('product_id' => $product_id))->delete();
            return true;
        }

        public function getFields($product_id)
        {
            $fields = $this->db->where(array('product_id' => $product_id))->select();
            return $fields;
        }
    }