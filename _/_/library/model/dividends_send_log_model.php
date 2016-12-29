<?php
/**
 * 分红数据模型
 * User: HZ
 * Date: 2016/3/3
 * Time: 10:51
 */

class dividends_send_log_model extends base_model
{

    public function getLogs($where, $offset, $limit)
    {

       $sql = "SELECT sl.*,s.name AS store FROM " . option('system.DB_PREFIX') . "dividends_send_log sl," . option('system.DB_PREFIX') . "store s WHERE sl.store_id = s.store_id";
       if (!empty($where)) {
            if (is_string($where)) {
                $sql .= " AND " . $where;
            } else if (is_array($where)) {
                foreach ($where as $field => $value) {
                    if (is_array($value) && strtolower($value[0]) == 'like') {
                        $sql .= " AND " . $field . " LIKE '" . $value[1] . "'";
                    } else if (strtolower($field) == '_string') {
                        $sql .= " AND " . $value;
                    } else if (is_array($value)) {
                        $sql .= " AND " . $field . " " . $value[0] . " '" . $value[1] . "'";
                    } else if (is_string($value)) {
                        $sql .= " AND " . $field . " = '" . $value . "'";
                    }
                }
            }
        }
        $sql .= " ORDER BY sl.pigcms_id DESC LIMIT " . $offset . ", " . $limit;
        $sendLogs = $this->db->query($sql);
        return $sendLogs;    

    }

     public function getLogCount($where)
    {
       $sql = "SELECT COUNT(sl.pigcms_id) AS count FROM " . option('system.DB_PREFIX') . "dividends_send_log sl, " . option('system.DB_PREFIX') . "store s WHERE sl.store_id = s.store_id";
       if (!empty($where)) {
            if (is_string($where)) {
                $sql .= " AND " . $where;
            } else if (is_array($where)) {
                foreach ($where as $field => $value) {
                    if (is_array($value) && strtolower($value[0]) == 'like') {
                        $sql .= " AND " . $field . " LIKE '" . $value[1] . "'";
                    } else if (strtolower($field) == '_string') {
                        $sql .= " AND " . $value;
                    } else if (is_array($value)) {
                        $sql .= " AND " . $field . " " . $value[0] . " '" . $value[1] . "'";
                    } else if (is_string($value)) {
                        $sql .= " AND " . $field . " = '" . $value . "'";
                    }
                }
            }
        }
       
        $result = $this->db->query($sql);
        return !empty($result[0]['count']) ? $result[0]['count'] : 0;   
    }

    //经销商获取分红记录
    public function getLogsByJxs($where, $offset, $limit)
    {

       $sql = "SELECT sl.*,s.name AS store FROM " . option('system.DB_PREFIX') . "dividends_send_log sl," . option('system.DB_PREFIX') . "store s WHERE sl.supplier_id = s.store_id";
       if (!empty($where)) {
            if (is_string($where)) {
                $sql .= " AND " . $where;
            } else if (is_array($where)) {
                foreach ($where as $field => $value) {
                    if (is_array($value) && strtolower($value[0]) == 'like') {
                        $sql .= " AND " . $field . " LIKE '" . $value[1] . "'";
                    } else if (strtolower($field) == '_string') {
                        $sql .= " AND " . $value;
                    } else if (is_array($value)) {
                        $sql .= " AND " . $field . " " . $value[0] . " '" . $value[1] . "'";
                    } else if (is_string($value)) {
                        $sql .= " AND " . $field . " = '" . $value . "'";
                    }
                }
            }
        }
        $sql .= " ORDER BY sl.pigcms_id DESC LIMIT " . $offset . ", " . $limit;

        $sendLogs = $this->db->query($sql);
        return $sendLogs;    

    }


    public function getLogsByJxsCount($where)
    {
       $sql = "SELECT COUNT(sl.pigcms_id) AS count FROM " . option('system.DB_PREFIX') . "dividends_send_log sl, " . option('system.DB_PREFIX') . "store s WHERE sl.supplier_id = s.store_id";
       if (!empty($where)) {
            if (is_string($where)) {
                $sql .= " AND " . $where;
            } else if (is_array($where)) {
                foreach ($where as $field => $value) {
                    if (is_array($value) && strtolower($value[0]) == 'like') {
                        $sql .= " AND " . $field . " LIKE '" . $value[1] . "'";
                    } else if (strtolower($field) == '_string') {
                        $sql .= " AND " . $value;
                    } else if (is_array($value)) {
                        $sql .= " AND " . $field . " " . $value[0] . " '" . $value[1] . "'";
                    } else if (is_string($value)) {
                        $sql .= " AND " . $field . " = '" . $value . "'";
                    }
                }
            }
        }
        
        $result = $this->db->query($sql);
        return !empty($result[0]['count']) ? $result[0]['count'] : 0;   
    }


    //奖金累计
    public function getAmountTotal($where)
    {
        $total = $this->db->where($where)->sum('amount');
        return !empty($total) ? $total : 0;
    }


   

}