<?php
/**
 * 积分模型
 */
class points_model extends base_model{
	
	/**
	 * 获取某个积分列表
	 */
	public function getPoints($where) {
		$points = $this->db->where($where)->find();
		return $points;
	}	
	
	
	/**
	 *  获取当前订单应送多少 积分
	
	 */
	public function getPoint($order_id) {
		// *  type其中： 1：关注微信送积分，2: 购买多少笔送积分  3：购买多少钱送积分*/
		$type = "3";	//目前只开放 3
	
		$order_info = D('Order')->where(array('order_id' => $order_id))->find();
	
		$where = " type='".$type."' and (trade_or_amount < ".$order_info['sub_total'] ." or trade_or_amount = ".$order_info['sub_total'].")";
	
		$point_info = $this->db->where($where)->order("trade_or_amount desc")->limit(1)->find();
		return $point_info;
	}	
	
	/**
	 * 获取满足条件的积分记录数
	 */
	public function getCount($where) {
		$points_count = $this->db->field('count(id) as count')->where($where)->find();
		return $points_count['count'];
	}

	/**
	 * 根据条件获到积分列表
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
		
		$points_list = $this->db->select();
		//echo $this->db->last_sql;
		return $points_list;
	}	
	
	
	/**
	 * 更改积分,条件一般指的是ID
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
	
	/**
	 * 修改
	 */
	public function edit($where, $data) {
		return $this->db->where($where)->data($data)->save();
	}
    
}