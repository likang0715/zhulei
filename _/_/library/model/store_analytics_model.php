<?php
/**
 * 店铺访问统计
 * User: pigcms_21
 * Date: 2015/3/24
 * Time: 17:13
 */

class store_analytics_model extends base_model
{
    public function add($data)
    {
        return $this->db->data($data)->add();
    }

    public function getTotal($where, $distinct = false)
    {
        return $this->db->distinct($distinct)->field('visited_ip')->where($where)->count('visited_ip');
    }

    public function getList($where)
    {
        $sql = "SELECT *,COUNT('pigcms_id') AS pv, COUNT(DISTINCT('module')) AS uv FROM " . option('system.DB_PREFIX') . "store_analytics WHERE store_id = '" . $where['store_id'] . "'";
        if (!empty($where['_string'])) {
            $sql .= ' AND ' . $where['_string'];
        }
        $sql .= " GROUP BY module ORDER BY pv DESC, uv DESC";
        return $this->db->query($sql);
    }
} 