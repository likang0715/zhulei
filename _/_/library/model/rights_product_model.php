<?php
/**
 * 维权产品model
 */
class rights_product_model extends base_model{
	/**
	 * 返回某个订单里某个产品已经退货的数量
	 */
	public function rightsNumber($order_id, $order_product_id) {
		if (empty($order_id) || empty($order_product_id)) {
			return 0;
		}
		
		$this->db->table('Rights as r');
		$this->db->join('Rights_product as rp on r.id = rp.rights_id', 'left');
		$this->db->where("r.order_id = '" . $order_id . "' AND rp.order_product_id = '" . $order_product_id . "' AND r.status != 10 AND r.is_fx = 0");
		$this->db->field('sum(rp.pro_num) as num');
		$rights_number = $this->db->find();
		
		return $rights_number['num'] + 0;
	}
}