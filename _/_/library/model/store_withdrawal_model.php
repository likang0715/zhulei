<?php
/**
 * 店铺提现数据模型
 * User: pigcms_21
 * Date: 2015/3/16
 * Time: 21:24
 */

class store_withdrawal_model extends base_model
{
    public function add($data)
    {
        return $this->db->data($data)->add();
    }

    public function getWithdrawalCount($where)
    {
        $sql = "SELECT COUNT(sw.pigcms_id) AS count FROM " . option('system.DB_PREFIX') . "store_withdrawal sw, " . option('system.DB_PREFIX') . "user u, " . option('system.DB_PREFIX') . "store s WHERE sw.uid = u.uid AND sw.store_id = s.store_id";
        if ($where) {
            foreach ($where as $key => $value) {
                if ($key == '_string') {
                    $sql .= " AND " . $value;
                } else {
                    $sql .= " AND " . $key . " = '" . $value . "'";
                }
            }
        }
        $result = $this->db->query($sql);
        return !empty($result[0]['count']) ? $result[0]['count'] : 0;
    }

    public function getWithdrawals($where, $offset, $limit)
    {
        $sql = "SELECT sw.*,u.nickname,s.tel,s.name AS store FROM " . option('system.DB_PREFIX') . "store_withdrawal sw, " . option('system.DB_PREFIX') . "user u, " . option('system.DB_PREFIX') . "store s WHERE sw.uid = u.uid AND sw.store_id = s.store_id";
        if ($where) {
            foreach ($where as $key => $value) {
                if ($key == '_string') {
                    $sql .= " AND " . $value;
                } else {
                    $sql .= " AND " . $key . " = '" . $value . "'";
                }
            }
        }
        $sql .= " ORDER BY sw.pigcms_id DESC LIMIT " . $offset . ", " . $limit;
        $withdrawals = $this->db->query($sql);
        if (!empty($withdrawals)) {
            foreach ($withdrawals as &$withdrawal) {
                $bank = D('Bank')->where(array('bank_id' => $withdrawal['bank_id']))->find();
                $withdrawal['bank'] = $bank['name'];
            }
        }
        return $withdrawals;
    }

    //提现记录状态
    public function getWithdrawalStatus($key = null)
    {
        $status = array(
            1 => '申请中',
            2 => '银行处理中',
            3 => '提现成功',
            4 => '提现失败'
        );
        if (is_null($key)) {
            return $status;
        } else {
            return $status[$key];
        }
    }

    //提现渠道
    public function getWithdrawalChannel($key = null)
    {
        $status = array(
            0 => '交易收益',
            1 => '兑现收益',
        );
        if (is_null($key)) {
            return $status;
        } else {
            return $status[$key];
        }
    }

    //统计提现金额
    public function getWithdrawalAmount($where)
    {
        $amount = $this->db->where($where)->sum('amount');
        return !empty($amount) ? $amount : 0;
    }
} 