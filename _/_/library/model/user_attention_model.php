<?php

// +----------------------------------------------------------------------
// | 李标
// +----------------------------------------------------------------------
// | 2015.7.7
// +----------------------------------------------------------------------
// | 用户关注商品或店铺模型
// +----------------------------------------------------------------------
class user_attention_model extends base_model {

    /**
     * 关注商品添加
     * @user_id   用户ID
     * @data_id  数据ID
     * @data_type  数据类型
     * @return bool
     */
    public function add($user_id, $data_id, $data_type, $store_id = 0) {
        if (!$user_id || !$data_id || !$data_type) {
            return false;
        }

        $data['user_id'] = $user_id;
        $data['data_id'] = $data_id;
        $data['data_type'] = $data_type;
        $data['store_id'] = $store_id;
        $data['add_time'] = time();
        $result = D('User_attention')->data($data)->add();
        if ($result) {
            if ($data_type == 1) {
                $result = D('Product')->where(array('product_id' => $data_id))->setInc('attention_num');
            } else {
                $result = D('Store')->where(array('store_id' => $data_id))->setInc('attention_num');
            }
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * 取消关注功能  这功能并不做判断是否有关注
     * param $uid
     * param $id
     * param $type
     */
    public function cancel($uid, $id, $type, $store_id=0) {
        if (!in_array($type, array(1, 2))) {
            return false;
        }

        $result = D('User_attention')->where(array('user_id' => $uid, 'data_id' => $id, 'data_type' => $type, 'store_id' => $store_id))->delete();

        if ($result) {
            if ($type == 1) {
                $result = D('Product')->where(array('product_id' => $id))->setInc('attention_num', -1);
            } else {
                $result = D('Store')->where(array('store_id' => $id))->setInc('attention_num', -1);
            }

            if ($result) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }
    
    
    public function getCount($where){
        $sql = "SELECT COUNT(id) AS count FROM " . option('system.DB_PREFIX') . 'user_attention u';
        $_string = '';
        if (array_key_exists('_string', $where)) {
            $_string = ' AND ' . $where['_string'];
            unset($where['_string']);
        }
        $condition = array();
        foreach ($where as $key => $value) {
            $condition[] = $key . " = '" . $value . "'";
        }
        $where = ' WHERE ' . implode(' AND ', $condition) . $_string;
        $sql .= $where;

        $fans = $this->db->query($sql);
        if (!empty($fans)) {
            return !empty($fans[0]['count']) ? $fans[0]['count'] : 0;
        } else {
            return 0;
        }
    }
    
    
        public function getUserattention($where, $offset, $limit, $order = '') {
        $sql = "SELECT *  FROM " . option('system.DB_PREFIX') . "user_attention u";
        $_string = '';
        if (array_key_exists('_string', $where)) {
            $_string = ' AND ' . $where['_string'];
            unset($where['_string']);
        }
        $condition = array();
        foreach ($where as $key => $value) {
            $condition[] = $key . " = '" . $value . "'";
        }
        $where = ' WHERE ' . implode(' AND ', $condition) . $_string;
        $sql .= $where;
        if (empty($order)) {
            $order = 'u.id DESC';
        }
        $order = ' ORDER BY ' . $order;
        $sql .= $order;
        $sql .= ' LIMIT ' . $offset . ',' . $limit;
        $fans = $this->db->query($sql);
        return $fans;
    }

}

?>
