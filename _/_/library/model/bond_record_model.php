<?php
/**
 * 保证金扣除记录表
 */
class bond_record_model extends base_model
{

    /**
     * 添加保证金记录
     * @param $data
     * @return mixed
     */
    public function add($data)
    {
        return $this->db->data($data)->add();
    }


    public function getBondRecord($where = array(),$supplier_id,$wholesale_id, $offset = 0, $limit = 0)
    {
        $sql = "select * from " . option('system.DB_PREFIX') . "bond_record where supplier_id = {$supplier_id} and wholesale_id={$wholesale_id}";
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

        $sql .= ' order by add_time DESC';
        if ($limit) {
            $sql .= ' LIMIT ' . $offset . ',' . $limit;
        }
        $bondRecord = $this->db->query($sql);

        return $bondRecord;

    }

    public function getBondRecordCount($where = array(),$supplier_id,$wholesale_id)
    {
        $sql = "select count('bond_id') as bondId from " . option('system.DB_PREFIX') . "bond_record where supplier_id = {$supplier_id} and wholesale_id={$wholesale_id}";
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

        $bondRecord = $this->db->query($sql);

        return !empty($bondRecord[0]['bondId']) ? $bondRecord[0]['bondId'] : 0;

    }


}
?>