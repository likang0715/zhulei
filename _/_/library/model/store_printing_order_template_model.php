<?php
/**
* 店铺订单打印模板模型
* User: pigcms-s
* Date: 2015/11/10
* Time: 15:07
*/
class store_printing_order_template_model extends base_model {
	
	/*
	*data is array
	*store_id 
	*tpl_id 对应的系统order模版id
	**/
	public function update_printing_order($data,$store_id,$tpl_id) {
		if(!is_array($data) || !store_id || !$tpl_id) return false;
		
		$where = array('store_id'=>$store_id,'typeid'=>$tpl_id);
		
		$store_printInfo = $this->db->where($where)->find();
		if($store_printInfo) {
			array_merge($data,array('store_id'=>$store_id,'timestamp'=>time()));
			if($data['text']) {
				$this->db->data($data)->where($where)->save(); 
				$return = 1;
			} 
			
		} else {
				array_merge($data,array('store_id'=>$store_id,'type_id'=>$tpl_id,'timestamp'=>time()));
				if($this->db->data($data)->add()) $return = 1;
		}
		
		$return = $return ? $return : '0';
		return $return;
		
	}
	
	
	
	public function getBystoreid($store_id) {
		
		if(!$store_id) return false;
		return $this->db->where(array('store_id'=>$store_id))->select();
		
	}
	
	
	public function getOneByTypeid($store_id,$typeid) {
		if(empty($store_id) || empty($typeid)) return false;
		return $this->db->where(array('store_id'=>$store_id,'typeid'=>$typeid))->find();	
	}
}