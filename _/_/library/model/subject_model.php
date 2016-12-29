<?php
/**
 * 专题模型
 */
class subject_model extends base_model{
	
	/**
	 * 获取某个专题列表
	 */
	public function get($where) {
		$subjects = $this->db->where($where)->find();
		if($subjects['pic']) $subjects['pic'] = getAttachmentUrl($subjects['pic']);
		return $subjects;
	}	
	

	/**
	 * 获取满足条件的专题记录数
	 */
	public function getCount($where) {
		$subjects_count = $this->db->field('count(id) as count')->where($where)->find();
		return $subjects_count['count'];
	}

	/**
	 * 根据条件获到专题列表
	 * 当limit与offset都为0时，表示不行限制
	 */
	public function getList($where, $order_by = '', $limit = 0, $offset = 0,$show_dz_count = false) {
		$this->db->where($where);
		if (!empty($order_by)) {
			$this->db->order($order_by);
		}

		if (!empty($limit)) {
			$this->db->limit($offset . ',' . $limit);
		}
		
		$subjects_list = $this->db->select();
		foreach($subjects_list as $k=>&$v) {
			$v['pic'] = getAttachmentUrl($v['pic']);
			if($show_dz_count) {
				$store_subject_data = D('Store_subject_data')->where(array("store_id"=>$v['store_id'],'subject_id'=>$v['id']))->find();
				$v['dz_count'] = $store_subject_data['dz_count'] ? $store_subject_data['dz_count'] : 0;
			}
		}
		return $subjects_list;
	}	
	
	
	/**
	 * 更改专题,条件一般指的是ID
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