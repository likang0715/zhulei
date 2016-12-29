<?php

/**
 * Created by PhpStorm.
 * User: pigcms_21
 * Date: 2015/12/6
 * Time: 15:33
 */
class profit_detail_model extends base_model
{
    public function add($data)
    {
        return $this->db->data($data)->add();
    }
}