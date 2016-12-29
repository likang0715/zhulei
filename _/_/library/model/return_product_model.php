<?php
/**
 * 退货产品表
 */
class return_product_model extends base_model{
	/**
	 * 返回某个订单里某个产品已经退货的数量
	 * param $return_complete 是否统计退货完成数量
	 */
	public function returnNumber($order_id, $order_product_id, $return_complete = false) {
		if (empty($order_id) || empty($order_product_id)) {
			return 0;
		}
		
		$this->db->table('Return as r');
		$this->db->join('Return_product as rp on r.id = rp.return_id', 'left');
		if ($return_complete == false) {
			$this->db->where("r.order_id = '" . $order_id . "' AND rp.order_product_id = '" . $order_product_id . "' AND r.status != 2 AND r.status != 6");
		} else {
			$this->db->where("r.order_id = '" . $order_id . "' AND rp.order_product_id = '" . $order_product_id . "' AND r.status = 5");
		}
		$this->db->field('sum(rp.pro_num) as num');
		$return_number = $this->db->find();
		
		return $return_number['num'] + 0;
	}

	/**
	 * 用户订单所有退货商品
	 * @param $return_id
	 * @return array
	 */
	public function getReturnProducts($returns) {
		$products = $this->db->where(array('user_return_id' => array('in', $returns)))->select();
		return !empty($products) ? $products : array();
	}

	/**
	 * 购买商品退货数量
	 * @param $order_id
	 * @param $order_product_id
	 */
	public function getReturnQty($order_id, $order_product_id, $status = array(1, 3, 4, 5))
	{
		$sql = "SELECT SUM(rp.pro_num) AS return_qty FROM " . option('system.DB_PREFIX') . "return_product rp, " . option('system.DB_PREFIX') . "return r WHERE r.id = rp.return_id AND rp.order_id = '" . $order_id . "' AND rp.order_product_id = '" . $order_product_id . "'";
		if (!empty($status)) {
			$sql .= " AND r.status IN (" . implode(',', $status) . ")";
		}
		$products = $this->db->query($sql);
		return !empty($products[0]['return_qty']) ? $products[0]['return_qty'] : 0;
	}
}