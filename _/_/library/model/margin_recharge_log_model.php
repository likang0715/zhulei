<?php

/**
 * Class margin_recharge_log_model 充值记录模型
 */
class margin_recharge_log_model extends base_model{

    //获取当前登录经销商充值记录
    public function getBondLog($where=array(),$offset = 0, $limit = 0)
    {
        $sql = "SELECT * FROM " . option('system.DB_PREFIX') . "margin_recharge_log" . " where 1=1";

        if (!empty($where)) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    if (array_key_exists('like', $value)) {
                        $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                    } else if (array_key_exists('in', $value)) {
                        $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                    }
                } else {
                    $sql .= " AND " . $key . "=" . $value;
                }
            }
        }
        if ($limit) {
            $sql .= ' LIMIT ' . $offset . ',' . $limit;
        }

        $bond_log = $this->db->query($sql);

        return $bond_log;
    }

    //获取当前登录经销商充值记录数
    public function getBondLogCount($where=array())
    {
        $sql = "SELECT count(id) as Id FROM " . option('system.DB_PREFIX') . "margin_recharge_log" . " where 1=1";

        if (!empty($where)) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    if (array_key_exists('like', $value)) {
                        $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                    } else if (array_key_exists('in', $value)) {
                        $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                    }
                } else {
                    $sql .= " AND " . $key . "=" . $value;
                }
            }
        }

        $logCount = $this->db->query($sql);

        return !empty($logCount[0]['Id']) ? $logCount[0]['Id'] : 0;
    }

    //获取当前供货商的经销商保证金充值记录
    public function getAgencyBondLog($where=array(),$offset = 0, $limit = 0)
    {
        $sql = "SELECT * FROM " . option('system.DB_PREFIX') . "margin_recharge_log" . " where 1=1";

        if (!empty($where)) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    if (array_key_exists('like', $value)) {
                        $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                    } else if (array_key_exists('in', $value)) {
                        $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                    }
                } else {
                    $sql .= " AND " . $key . "=" . $value;
                }
            }
        }
        if ($limit) {
            $sql .= ' LIMIT ' . $offset . ',' . $limit;
        }

        $bond_log = $this->db->query($sql);

        return $bond_log;
    }

    //获取当前供货商的经销商保证金充值记录数
    public function getAgencyBondLogCount($where=array())
    {
        $sql = "SELECT count(id) as Id FROM " . option('system.DB_PREFIX') . "margin_recharge_log" . " where 1=1";

        if (!empty($where)) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    if (array_key_exists('like', $value)) {
                        $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                    } else if (array_key_exists('in', $value)) {
                        $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                    }
                } else {
                    $sql .= " AND " . $key . "=" . $value;
                }
            }
        }

        $logCount = $this->db->query($sql);

        return !empty($logCount[0]['Id']) ? $logCount[0]['Id'] : 0;
    }
}

?>