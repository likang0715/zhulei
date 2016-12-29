<?php
/**
 * 用户积分流水模型
 * User: pigcms-s
 * Date: 2016/1/19
 * Time: 10:38
 */

class user_points_model extends base_model {

    /*得到一个店铺的积分记录*/
    public function getStoreData($where, $offset = 0, $limit = 0)
    {
        $sql = "SELECT * FROM " . option('system.DB_PREFIX') . "user ss, " . option('system.DB_PREFIX') . "user_points s WHERE s.uid = ss.uid";
        if (!empty($where)) {
            //var_dump($where);
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    if (array_key_exists('like', $value)) {
                        $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                    } else if (array_key_exists('in', $value)) {
                        $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                    }else{
                        $sql .= " AND " . $key . $value[0] . $value[1];
                    }
                }else if($key == '_string'){
                    $sql .= " AND " . $value;
                }else if($key != '_string'){
                    $sql .= " AND " . $key . "=" . "'".$value."'";
                }
            }
        }

        $sql .= ' ORDER BY s.timestamp DESC';
        if ($limit) {
            $sql .= ' LIMIT ' . $offset . ',' . $limit;
        }

        $points = $this->db->query($sql);
        return $points;
    }

    public function getPoints($where)
    {
        $sql = "SELECT count(s.store_id) as store_id FROM " . option('system.DB_PREFIX') . "user ss, " . option('system.DB_PREFIX') . "user_points s WHERE s.uid = ss.uid";
        if (!empty($where)) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    if (array_key_exists('like', $value)) {
                        $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                    } else if (array_key_exists('in', $value)) {
                        $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                    }else{
                        $sql .= " AND " . $key . $value[0] . $value[1];
                    }
                }else if($key == '_string'){
                    $sql .= " AND " . $value;
                }else if($key != '_string'){
                    $sql .= " AND " . $key . "=" . "'".$value."'";
                }
            }
        }

        $points = $this->db->query($sql);
        return !empty($points[0]['store_id']) ? $points[0]['store_id'] : 0;

    }


}