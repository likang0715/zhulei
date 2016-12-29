<?php

/**
 * Created by PhpStorm.
 * User: pigcms_21
 * Date: 2016/1/10
 * Time: 13:12
 */
class platform_drp_degree_model extends base_model
{
    public function getDrpDegree($degree_id)
    {
        $degree = $this->db->where(array('pigcms_id' => $degree_id))->find();
        return $degree;
    }
}