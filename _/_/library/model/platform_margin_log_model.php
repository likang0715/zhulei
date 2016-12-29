<?php

/**
 * Created by PhpStorm.
 * User: pigcms_21
 * Date: 2016/2/21
 * Time: 17:10
 */
class platform_margin_log_model extends base_model
{
    public function getLogCount($where)
    {
        $log_count = $this->db->where($where)->count('pigcms_id');
        return !empty($log_count) ? $log_count : 0;
    }

    public function getLogs($where, $order_by = 'pigcms_id DESC', $offset = 0, $limit = 20)
    {
        $logs = $this->db->where($where)->order($order_by)->limit($offset . ',' . $limit)->select();
        return !empty($logs) ? $logs : array();
    }

    public function getTypes($key = '')
    {
        $types = array(
            0 => '充值',
            1 => '提现',
            2 => '扣除',
            3 => '退货/取消'
        );
        if (!empty($key) && array_key_exists($key, $types)) {
            return $types[$key];
        }
        return $types;
    }

    public function getStatus($key = '')
    {
        $status = array(
            0 => '未支付',
            1 => '未处理',
            2 => '已处理',
        );
        if (!empty($key) && array_key_exists($key, $status)) {
            return $status[$key];
        }
        return $status;
    }
}