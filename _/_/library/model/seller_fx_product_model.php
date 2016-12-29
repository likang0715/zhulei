<?php
/**
 * 分销商品数据模型
 * User: pigcms_21
 * Date: 2015/2/2
 * Time: 22:00
 */
    class seller_fx_product_model extends base_model
    {
        public function add($data)
        {
            return $this->db->data($data)->add();
        }
    }