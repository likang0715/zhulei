<?php

/**
 * 分销商品对应分销等级利润
 * User: pigcms_21
 * Date: 2016/1/12
 * Time: 11:21
 */
class product_drp_degree_model extends base_model
{
    public function getDrpDegree($where)
    {
        $drp_degree = $this->db->where($where)->find();
        return !empty($drp_degree) ? $drp_degree : '';
    }
}