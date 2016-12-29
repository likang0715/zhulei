<?php
/**
 * 系统TAGmodel
 */
class system_tag_model extends base_model{
	/**
	 * 返回相应TAG name列表
	 */
	public function geNameList($where) {
		$where['status'] = 1;
		$system_list = $this->db->where($where)->select();
		
		$data = array();
		foreach ($system_list as $tmp) {
			$data[$tmp['id']] = $tmp['name'];
		}
		
		return $data;
	}
	
	//根据商品分类id 获取商品标签
	public function getNameListByPid($product_categoryid_arr) {
		if(is_array($product_categoryid_arr)) {
				//$product_categoryid_str = implde(",",$product_categoryid_arr);
				
				//$this->db->where(array('cat_id' => $category_id))->find();
				
				$tag_list_by_product = D('Product_category')->where(array('cat_id' => array('in',$product_categoryid_arr)))->group("cat_id")->select();
				//D('Product_category')->where(array('cat_id' => array('in',$product_categoryid_arr)))->select();
				//dump($tag_list_by_product);
				foreach($tag_list_by_product as $k=>$v) {
					if(!empty($v['tag_str'])) {
						$where = array();
						$where['id'] = array('in', explode(',', $v['tag_str']));
						$tag_list[$v['cat_id']] = M('System_tag')->geNameList($where);
					}
					
				}
				return $tag_list;
		} else {
			
			return false;
		}
		
		
	}	
	/**
	 * 更改评论,条件一般指的是ID
	 */
	public function save($data, $where) {
		$this->db->data($data)->where($where)->save();
	}
	
	/**
	 * 添加
	 */
	public function add ($data) {
		$this->db->data($data)->add();
	}
}