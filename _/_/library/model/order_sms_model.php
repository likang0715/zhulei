<?php
/**
 * 订单短信数据模型
 */
class order_sms_model extends base_model{
	
	
	public function add($data) {
		return $this->db->data($data)->add();
	}
	
	public function getOne($where) {
		if(!$where) return;
		$order = $this->db->where($where)->find();	
		return $order;
	}
	
	//检测当前用户是否有未处理且未过期的订单
	public function check_unpay_order($uid) {
		$time = time();
		$time1 = $time-24*64*60;
		
		$where = "uid='".$uid."' and status=0 and dateline > '".$time1."'";
		
		$order_count = $this->db->where($where)->count('sms_order_id');

		return $order_count;
		
	}
	
	
	//获得指定条件短信订单记录总数
	public function getSmsTotal($where)
	{
		$order_count = $this->db->where($where)->count('sms_order_id');
		//echo $this->db->last_sql;
		return $order_count;
	}
	
	
	
	/**
	 * 根据条件获到优惠券对应的用户列表
	 * 当limit与offset都为0时，表示不行限制
	 */
	public function getsmsList($where, $order_by = '', $limit = 0, $offset = 0) {
	
		$arr = $this->db->where($where)
						->limit($offset . ',' . $limit)
						->order($order_by)
						->select();
		return $arr;
	
	}







	
	 
	
	
	

}
