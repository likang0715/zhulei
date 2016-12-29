<?php
/**
 * 预售model
 */
class Presale_model extends base_model{
	/**
	 * 获取某个预售
	 */
	public function getPresale($where) {
		$Presale = $this->db->where($where)->find();

		return $Presale;
	}
	
	/**
	 * 获取预售记录数
	 */
	public function getCount($where) {
		$Presale_count = $this->db->field('count(1) as count')->where($where)->find();
//		echo $this->db->last_sql;
		return $Presale_count['count'];
	}
	
	/**
	 * 获到预售列表
	 * 当limit与offset都为0时，表示不行限制
	 */
	public function getList($where, $limit = 0, $offset = 0,  $order_by = '') {

		$this->db->where($where);

		if (!empty($order_by)) {
			$this->db->order($order_by);
		}
		if (!empty($limit)) {
			$this->db->limit($offset . ',' . $limit);
		}
		
		$Presale_list = $this->db->select();
		
		return $Presale_list;
	}
	
	/**
	 * 更改预售,条件一般指的是ID
	 */
	public function save($data, $where) {
		$this->db->data($data)->where($where)->save();
	}
	
	/**
	 * 删除
	 */
	public function delete($where) {
		$this->db->where($where)->delete();
	}
	

}