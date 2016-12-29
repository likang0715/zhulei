<?php
/**
 * 
 * User: pigcms_16
 * Date: 2015/10/17
 * Time: 20:28
 */

class store_physical_courier_model extends base_model{

	public function add ($data) {
		return $this->db->data($data)->add();
	}

	public function edit ($where, $data) {
		return $this->db->where($where)->data($data)->save();
	}

}