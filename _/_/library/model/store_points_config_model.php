<?php

/**
 * 积分配置
 * User: pigcms_89
 * Date: 2016/01/11
 * Time: 15:08
 */
class store_points_config_model extends base_model
{
    public function getConfig($store_id)
    {
        $config = $this->db->where(array('store_id' => $store_id))->find();
        return !empty($config) ? $config : array();
    }
}
