<?php

class subscribe_store_model extends base_model {

    //获取店铺粉丝数量
    public function getFansCount($where) {
        $sql = "SELECT COUNT(uid) AS count FROM " . option('system.DB_PREFIX') . 'subscribe_store u';
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

    //记录粉丝信息
    public function getFansRecord($uid) {
        if (!$uid) {
            return false;
        }


        $where['uid'] = $uid;
        $result = $this->db->where($where)->find();

        if (!$result) {
            $data['uid'] = $uid;
            $data['store_id'] = $_SESSION['tmp_store_id'];
            $data['subscribe_time'] = time();
            $insert_id = $this->db->data($data)->add();
            if ($insert_id) {
                return $insert_id;
            } else {
                return false;
            }
        }
    }

    public function getFans($where, $offset, $limit, $order = '') {
        //$sql = "SELECT u.uid,u.nickname,u.phone,(SELECT COUNT(fx_order_id) FROM " . option('system.DB_PREFIX') . "fx_order fo1 WHERE fo1.uid = u.uid AND fo1.store_id = '" . $_SESSION['wap_drp_store']['store_id'] . "') AS order_count, (SELECT SUM(total) FROM " . option('system.DB_PREFIX') . "fx_order fo2  WHERE fo2.uid = u.uid AND fo2.store_id = '" . $_SESSION['wap_drp_store']['store_id'] . "') AS order_total FROM " . option('system.DB_PREFIX') . "user u";
        
        $sql = "SELECT *  FROM " . option('system.DB_PREFIX') . "subscribe_store u";
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
            $order = 'u.uid DESC';
        }
        $order = ' ORDER BY ' . $order;
        $sql .= $order;
        $sql .= ' LIMIT ' . $offset . ',' . $limit;
        $fans = $this->db->query($sql);
        return $fans;
    }

    
    public function getFansPage($where, $orderby='sub_id desc', $offset, $limit)
    {
    	$orders = $this->db->where($where)->order($orderby)->limit($offset . ',' . $limit)->select();
    	return $orders;
    }
    
    
    public function getOne($where) {
	
		$array = $this->db->where($where)->find();
		return $array;
	}

	/* 获取某个店铺的粉丝 or 关注者
	 * @store_id: store_id
	 * @uid_array: array()  查出被指定uid的用户集合，为空 即忽略这一参数
	 * @param:show_type:0 全部; 1:仅为粉丝； 2:仅为店铺微信关注者
	 */
	public function getFansByStore($store_id,$uid_array = array(),$show_type="0",$offset="o", $limit="0",$order='') {
		
		$where = array();
		if(is_array($uid_array)) {
			if(count($uid_array))	$where['uid'] = array('in',$uid_array);
		} else {
			if($uid_array) $where['uid'] = $uid_array;
		}
		if(!in_array($show_type,array('0','1','2'))) {
			return false;
		}
		
		$where['store_id'] = $store_id;
		if($show_type == '1') {
			$where['openid'] = array('=','');
		}
		if($show_type == '2') {
			$where['openid'] = array('!=','');
		}
		if($limit) $this->db->limit($offset . ',' . $limit);
		if($order) $this->db->order($order);
		
		$list = $this->db->where($where)->select();

		return $list;
		
	}

    /**
     * 是否已关注
     * @param $uid
     * @param $store_id
     * @return bool
     */
    public function subscribed($uid, $store_id)
    {
        if ($this->db->where(array('uid' => $uid, 'store_id' => $store_id, 'openid' => array('!=', ''),'subscribe_time' =>array('>',0)))->count('sub_id')) {
            return true;
        } else {
            return false;
        }
    }

}
