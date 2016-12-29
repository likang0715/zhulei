<?php
/**
 * 线下做单model
 */
class order_offline_model extends base_model {
	/**
	 * 获取数量
	 */
	public function getCount($where) {
		$count = $this->db->where($where)->count('id');
		
		return $count;
	}


	/**
	 * 根据条件获取列表
	 * 当limit与offset都为0时，表示不行限制
	 */
	public function getList($where, $order_by = '', $limit = 0 , $offset = 0) {
		$this->db->where($where);
		if (!empty($order_by)) {
			$this->db->order($order_by);
		}
		
		if (!empty($limit)) {
			$this->db->limit($offset . ',' . $limit);
		}
		
		$order_offline_list = $this->db->select();
		return $order_offline_list;
	}
}