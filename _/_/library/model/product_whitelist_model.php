<?php

/**
 * 商品白名单
 * User: pigcms_21
 * Date: 2015/11/25
 * Time: 16:37
 */
class product_whitelist_model extends base_model {

    public function add($data) {
        $result = $this->db->data($data)->add();
        return $result;
    }

}