<?php
/**
 * 
 * User: pigcms_16
 * Date: 2015/9/25
 * Time: 15:50
 */

class order_product_physical_model extends base_model{

	public function add ($data) {
		return $this->db->data($data)->add();
	}

	public function getList($where = '') {
		if (empty($where)) return array();
		return  $this->db->where($where)->select();
	}

}