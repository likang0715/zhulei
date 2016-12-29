<?php
/**
 * 代付数据模型
 * User: pigcms_21
 * Date: 2015/8/18
 * Time: 13:48
 */

class order_peerpay_model extends base_model {
	/**
	 * 返回代付金额
	 */
	public function sumMoney($order_id) {
		if (empty($order_id)) {
			return 0;
		}
		
		$order_peerpay = $this->db->where(array('order_id' => $order_id, 'status' => 1))->field("sum(money) as money, sum(IF(untread_status = 1, untread_money, 0)) as untread_money")->find();
		
		if (empty($order_peerpay)) {
			return 0;
		}
		
		return $order_peerpay['money'] - $order_peerpay['untread_money'];
	}
} 