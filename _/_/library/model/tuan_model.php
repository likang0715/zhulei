<?php
/**
 * 团购model
 */
class tuan_model extends base_model{
	/**
	 * 获取满足条件的录数
	 */
	public function getCount($where) {
		$tuan_count = $this->db->field('count(1) as count')->where($where)->find();
		return $tuan_count['count'];
	}
	
	/**
	 * 根据条件获到列表
	 * 当limit与offset都为0时，表示不行限制
	 */
	public function getList($where, $order_by = '', $limit = 0, $offset = 0) {
		$this->db->where($where);
		if (!empty($order_by)) {
			$this->db->order($order_by);
		}
		
		if (!empty($limit)) {
			$this->db->limit($offset . ',' . $limit);
		}
		
		$tuan_list = $this->db->select();
		
		return $tuan_list;
	}
	
	/**
	 * 根据分组获取团购数量
	 * 严格判断产品是否上架，删除等
	 * param $store_id 店铺ID
	 * param $group_id 分组ID
	 */
	public function getCountByGroup($store_id = 0, $group_id = 0) {
		$time = $_SERVER['REQUEST_TIME'];
		$where = "t.start_time <= '" . $time . "' AND t.end_time >= '" . $time . "' AND t.status = 1 AND t.delete_flg = 0 AND p.status = 1";
		if ($store_id) {
			$where .= " AND t.store_id = '" . $store_id . "'";
		}
		
		if (empty($group_id)) {
			return D('Tuan AS t')->join('Product AS p ON t.product_id = p.product_id')->where($where)->count('t.id');
		} else {
			$where .= " AND pg.group_id = '" . $group_id . "'";
			return D('Tuan AS t')->join('Product as p ON t.product_id = p.product_id')->join('Product_to_group AS pg ON pg.product_id = p.product_id')->where($where)->count('t.id');
		}
	}
	
	/**
	 * 根据分组获取团购
	 * 严格判断产品是否上架，删除等
	 * param $store_id 店铺ID
	 * param $group_id 分组ID
	 * param $limit 条数
	 * param $offset 偏移量
	 */
	public function getListByGroup($store_id = 0, $group_id = 0, $limit = 0, $offset = 0) {
		$time = $_SERVER['REQUEST_TIME'];
		$where = "t.start_time <= '" . $time . "' AND t.end_time >= '" . $time . "' AND t.status = 1 AND t.delete_flg = 0 AND p.status = 1";
		if ($store_id) {
			$where .= " AND t.store_id = '" . $store_id . "'";
		}
		
		$tuan_list = array();
		if (empty($group_id)) {
			$tuan_list = D('Tuan AS t')->join('Product AS p ON t.product_id = p.product_id')->where($where)->field('t.*, p.price, p.image, p.name, p.has_property')->limit($offset . ', ' . $limit)->select();
		} else {
			$where .= " AND pg.group_id = '" . $group_id . "'";
			$tuan_list = D('Tuan AS t')->join('Product as p ON t.product_id = p.product_id')->join('Product_to_group AS pg ON pg.product_id = p.product_id')->where($where)->field('t.*, p.price, p.image, p.name, p.has_property')->limit($offset . ', ' . $limit)->select();
		}
		
		foreach ($tuan_list as &$tuan) {
			$tuan['tuan_id'] = $tuan['id'];
			$tuan['info'] = $tuan['description'];
			unset($tuan['id']);
			
			$tuan_config = D('Tuan_config')->where(array('tuan_id' => $tuan['tuan_id']))->field('number, discount')->order('id DESC')->find();
			
			$config_1 = $tuan_config;
			$config_2 = $tuan_config;
			$config_1['discount'] = round($config_1['discount'] * $tuan['price'] / 10, 2);
			
			$tuan['image'] = getAttachmentUrl($tuan['image']);
			$tuan['config_1'] = $config_1;
			$tuan['config_2'] = $config_2;
		}
		
		return $tuan_list;
	}
	
	/**
	 * 团购首页团购项
	 * param $cat_id 分类ID 1:pc端首页，2：wap端首页
	 */
	public function getListByHome($cat_id = 2, $offset = 0, $limit = 8) {
		$time = time();
		$where = "t.start_time <= '" . $time . "' AND t.end_time >= '" . $time . "' AND t.status = 1 AND t.delete_flg = 0 AND p.status = 1 AND ah.cat_id = '" . $cat_id . "'";
		
		
		$tuan_list = D('Activity_home AS ah')->join('Tuan AS t ON ah.activity_id = t.id')->join('Product as p ON t.product_id = p.product_id')->where($where)->field('t.*, p.name, p.image, p.price')->order('ah.sort ASC, t.id DESC')->limit($offset . ',' . $limit)->select();
		
		foreach ($tuan_list as &$tuan) {
			$tuan['tuan_id'] = $tuan['id'];
			$tuan['info'] = $tuan['description'];
			unset($tuan['id']);
				
			$tuan['image'] = getAttachmentUrl($tuan['image']);
			$tuan_config = D('Tuan_config')->where(array('tuan_id' => $tuan['tuan_id']))->field('number, discount')->order('discount ASC')->find();
		
			$tuan_config = $tuan_config;
			$tuan_config['price'] = round($tuan_config['discount'] * $tuan['price'] / 10, 2);
		
			$tuan['image'] = getAttachmentUrl($tuan['image']);
			$tuan['config'] = $tuan_config;
		}
		
		return $tuan_list;
	}
	
	/**
	 * 获取某个产品分类正在进行中的团购数量
	 * param $cat_id 产品分类ID
	 * param $where 搜索条件
	 */
	public function getCountByCategory($cat_id = 0, $where = '') {
		$time = time();
		if (!empty($where)) {
			$where .= " AND t.start_time <= '" . $time . "' AND t.end_time >= '" . $time . "' AND t.status = 1 AND t.delete_flg = 0 AND p.status = 1";
		} else {
			$where = "t.start_time <= '" . $time . "' AND t.end_time >= '" . $time . "' AND t.status = 1 AND t.delete_flg = 0 AND p.status = 1";
		}
		if (!empty($cat_id)) {
			$where .= " AND (p.category_fid = '" . $cat_id . "' OR p.category_id = '" . $cat_id . "')";
		}
		
		$count = D('Tuan AS t')->join('Product as p ON t.product_id = p.product_id')->where($where)->count('t.id');
		return $count;
	}
	
	/**
	 * 获取某个产品分类正在理行中的团购信息
	 * param $cat_id 产品分类ID
	 * param $where 搜索条件
	 * param $order 排序
	 * param $limit 
	 * param $offset 
	 */
	public function getListByCategory($cat_id = 0, $where = '', $order = '', $offset = 0, $limit = 6) {
		$time = time();
		if (!empty($where)) {
			$where .= " AND t.start_time <= '" . $time . "' AND t.end_time >= '" . $time . "' AND t.status = 1 AND t.delete_flg = 0 AND p.status = 1";
		} else {
			$where = "t.start_time <= '" . $time . "' AND t.end_time >= '" . $time . "' AND t.status = 1 AND t.delete_flg = 0 AND p.status = 1";
		}
		if (!empty($cat_id)) {
			$where .= " AND (p.category_fid = '" . $cat_id . "' OR p.category_id = '" . $cat_id . "')";
		}
		
		$tuan_list = D('Tuan AS t')->join('Product as p ON t.product_id = p.product_id')->where($where)->field('t.*, t.name as t_name, p.name, p.image, p.price')->order($order)->limit($offset . ',' . $limit)->select();
		
		foreach ($tuan_list as &$tuan) {
			$tuan['tuan_id'] = $tuan['id'];
			$tuan['info'] = $tuan['description'];
			unset($tuan['id']);
			
			$tuan['image'] = getAttachmentUrl($tuan['image']);
			$tuan_config = D('Tuan_config')->where(array('tuan_id' => $tuan['tuan_id']))->field('number, discount')->order('discount ASC')->find();
				
			$tuan_config = $tuan_config;
			$tuan_config['price'] = round($tuan_config['discount'] * $tuan['price'] / 10, 2);
				
			$tuan['image'] = getAttachmentUrl($tuan['image']);
			$tuan['config'] = $tuan_config;
		}
		
		return $tuan_list;
	}
	
	/**
	 * 获取正在开团的数量
	 * param $cat_id 产品分类ID
	 */
	public function getCountByTeam($cat_id = 0, $where = '') {
		$time = time();
		if (empty($where)) {
			$where = " tt.status = 0 AND tt.pay_status = 1 AND t.start_time <= '" . $time . "' AND t.end_time >= '" . $time . "' AND t.status = 1 AND t.delete_flg = 0 AND p.status = 1";
		} else {
			$where = $where . " AND tt.status = 0 AND tt.pay_status = 1 AND t.start_time <= '" . $time . "' AND t.end_time >= '" . $time . "' AND t.status = 1 AND t.delete_flg = 0 AND p.status = 1";
		}
		
		if (!empty($cat_id)) {
			$where .= " AND (p.category_fid = '" . $cat_id . "' OR p.category_id = '" . $cat_id . "')";
		}
		
		$count = D('Tuan_team AS tt')->join('Tuan AS t ON t.id = tt.tuan_id')->join('Product as p ON t.product_id = p.product_id')->where($where)->count('tt.team_id');
		return $count;
	}
	
	/**
	 * 获取正在开团的列表
	 * param $cat_id 产品分类ID
	 * param $order 排序
	 * param $offset
	 * param $limit
	 * param $is_anonymous 是否为匿名
	 */
	public function getListByTeam($cat_id = 0, $where = '', $order = '', $offset = 0, $limit = 6, $is_anonymous = true) {
		$time = time();
		if (empty($where)) {
			$where = " tt.status = 0 AND tt.pay_status = 1 AND t.start_time <= '" . $time . "' AND t.end_time >= '" . $time . "' AND t.status = 1 AND t.delete_flg = 0 AND p.status = 1";
		} else {
			$where = $where . " AND tt.status = 0 AND tt.pay_status = 1 AND t.start_time <= '" . $time . "' AND t.end_time >= '" . $time . "' AND t.status = 1 AND t.delete_flg = 0 AND p.status = 1";
		}
		
		if (!empty($cat_id)) {
			$where .= " AND (p.category_fid = '" . $cat_id . "' OR p.category_id = '" . $cat_id . "')";
		}
		
		$field = 't.*, t.name as t_name, p.name, p.image, p.price, tt.team_id, tt.uid AS team_uid, tt.type, tt.item_id, tt.order_number';
		$tuan_list_tmp = D('Tuan_team AS tt')->join('Tuan AS t ON t.id = tt.tuan_id')->join('Product as p ON t.product_id = p.product_id')->field($field)->where($where)->order($order)->limit($offset . ',' . $limit)->select();
		
		$tuan_list = array();
		$user_arr = array();
		$tuan_config_arr = array();
		foreach ($tuan_list_tmp as $tuan) {
			$tuan['image'] = getAttachmentUrl($tuan['image']);
			$tuan['tuan_id'] = $tuan['id'];
			unset($tuan['id']);
			
			// 查找团长信息
			if (!isset($user_arr[$tuan['team_uid']])) {
				$user = D('User')->where(array('uid' => $tuan['team_uid']))->find();
				if (!empty($user)) {
					if ($is_anonymous) {
						$user_arr[$tuan['team_uid']] = $user['nickname'] ? anonymous($user['nickname']) : anonymous($user['phone']);
					} else {
						$user_arr[$tuan['team_uid']] = $user['nickname'] ? $user['nickname'] : $user['phone'];
					}
				} else {
					$user_arr[$tuan['team_uid']] = '匿名';
				}
			}
			
			// 查找团购项
			if (!isset($tuan_config_arr[$tuan['item_id']])) {
				$tuan_config_list_tmp = D('Tuan_config')->where(array('tuan_id' => $tuan['tuan_id']))->select();
				$tuan_config_list = array();
				foreach ($tuan_config_list_tmp as $tuan_config) {
					$tuan_config_list[$tuan_config['id']] = $tuan_config;
				}
				
				$tuan_config_arr = $tuan_config_list;
			}
			
			$tuan_config = $tuan_config_arr[$tuan['item_id']];
			
			$tuan['tuan_number'] = $tuan_config['number'];
			$tuan['tuan_discount'] = $tuan_config['discount'];
			$tuan['tuan_price'] = $tuan['price'] * $tuan_config['discount'] / 10;
			$tuan['team_nickname'] = $user_arr[$tuan['team_uid']];
			
			// 查找订单数
			// $order_count = D('Order')->where("`store_id`='" . $tuan['store_id'] . "' AND `type`='6' AND `status` IN(2,3,4,7) AND `data_id`='" . $tuan['tuan_id'] . "' AND `data_item_id`='" . $tuan['team_id'] . "'")->sum('pro_num');
			
			$tuan['order_count'] = $tuan['order_number'];
			$tuan_list[] = $tuan;
		}
		
		return $tuan_list;
	}
	
	/**
	 * 根据团购首页分类标识
	 * param $cat_key 标识
	 * param $offset
	 * param $limit
	 */
	public function getListByKey($cat_key = '', $offset = 0, $limit = 8) {
		static $cat_key_arr;
		$cat_id = 0;
		if (isset($cat_key_arr[$cat_key])) {
			$cat_id = $cat_key_arr[$cat_key]['cat_id'];
			if (!empty($cat_key_arr[$cat_key]['cat_num'])) {
				$limit = $cat_key_arr[$cat_key]['cat_num'];
			}
		} else {
			$activity_home_category_list = D('Activity_home_category')->select();
			foreach ($activity_home_category_list as $activity_home_category) {
				$cat_key_arr[$activity_home_category['cat_key']] = $activity_home_category;
				
				if ($activity_home_category['cat_key'] == $cat_key) {
					$cat_id = $activity_home_category['cat_id'];
					if (!empty($activity_home_category['cat_num'])) {
						$limit = $activity_home_category['cat_num'];
					}
				}
			}
		}
		
		$time = time();
		$where = "t.start_time <= '" . $time . "' AND t.end_time >= '" . $time . "' AND t.status = 1 AND t.delete_flg = 0 AND p.status = 1 AND ah.cat_id = '" . $cat_id . "'";
	
	
		$tuan_list = D('Activity_home AS ah')->join('Tuan AS t ON ah.activity_id = t.id')->join('Product as p ON t.product_id = p.product_id')->where($where)->field('t.*, t.name as t_name, p.name, p.image, p.price')->order('ah.sort ASC, t.id DESC')->limit($offset . ',' . $limit)->select();
	
		foreach ($tuan_list as &$tuan) {
			$tuan['tuan_id'] = $tuan['id'];
			$tuan['info'] = $tuan['description'];
			unset($tuan['id']);
	
			$tuan['image'] = getAttachmentUrl($tuan['image']);
			$tuan_config = D('Tuan_config')->where(array('tuan_id' => $tuan['tuan_id']))->field('number, discount')->order('discount ASC')->find();
	
			$tuan_config = $tuan_config;
			$tuan_config['price'] = round($tuan_config['discount'] * $tuan['price'] / 10, 2);
	
			$tuan['image'] = getAttachmentUrl($tuan['image']);
			$tuan['config'] = $tuan_config;
		}
		
		return $tuan_list;
	}
}