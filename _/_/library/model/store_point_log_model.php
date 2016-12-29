<?php

/**
 * 店铺积分（平台）
 * User: pigcms_21
 * Date: 2016/2/1
 * Time: 18:24
 */
class store_point_log_model extends base_model
{
    public function getLog($where)
    {
        $log = $this->db->where($where)->find();
        return !empty($log) ? $log : array();
    }

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
            0 => '消费产生积分',
            1 => '消费返还积分',
            2 => '积分变现',
            3 => '退货返还积分',
            4 => '积分流转服务费'
        );
        if (!empty($key) && array_key_exists($key, $types)) {
            return $types[$key];
        }
        return $types;
    }

    public function getStatus($key = '')
    {
        $status = array(
            0 => '未处理',
            1 => '已处理'
        );
        if (!empty($key) && array_key_exists($key, $status)) {
            return $status[$key];
        }
        return $status;
    }

    public function getChannels($key = '')
    {
        $channels = array(
            0 => '线上',
            1 => '线下'
        );
        if (!empty($key) && array_key_exists($key, $channels)) {
            return $channels[$key];
        }
        return $channels;
    }
}