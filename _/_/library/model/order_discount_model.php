<?php
/**
 * 订单折扣模型
 */
class order_discount_model extends base_model{
	// 根据订单号查询订单折扣
	public function getByOrderId($order_id) {
		if (empty($order_id)) {
			return array();
		}
		
		$where = array();
		$where['order_id'] = $order_id;
		
		$order_discount_list = $this->db->where($where)->select();
		return $order_discount_list;
	}
}
?>