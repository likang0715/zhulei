<?php
/**
 * 快递公司数据模型
 * User: pigcms_21
 * Date: 2015/3/13
 * Time: 20:20
 */

class express_model extends base_model
{
    public function getExpress()
    {
        $express = $this->db->select();
        return $express;
    }
} 