<?php
/**
 * 会员等级标签模型
 * create by：Simon
 */
class tag_model extends base_model{
	
	/*
	 * 获取一个人 在 某个店铺的会员等级
	 */
	public function getUserDegree($uid,$store_id) {
		
		//获取用户积分
		$user_point_info = M('User_points_by_store')->getpoints_by_storeid($uid,$store_id);
		if($user_point_info['points']) {
			$return = $this->db->where("store_id='".$store_id."' and points_limit > '".$user_point_info['points']."' ")->order("points_limit asc")->limit(1)->find();
		}
		$return = $return?$return:array('name'=>'未有等级');
		return $return;
	}
	
	/**
	 * 获取某个标签列表
	 */
	public function getTag($where) {
		$tag = $this->db->where($where)->find();
		if($tag['level_pic']) {
			if(preg_match('/^images\//',$tag['level_pic'])) {
				$tag['new_level_pic'] = getAttachmentUrl($tag['level_pic']);
			} else {
				$tag['new_level_pic'] = $tag['level_pic'];
			}
		}
		return $tag;
	}	
	
	
	/**
	 * 获取满足条件的标签记录数
	 */
	public function getCount($where) {
		$tag_count = $this->db->field('count(id) as count')->where($where)->find();
		return $tag_count['count'];
	}

	/**
	 * 根据条件获到标签列表
	 * 当limit与offset都为0时，表示不行限制
	 */
	public function getList($where, $order_by = '', $limit = 0, $offset = 0) {
		$this->db->where($where);
		if (!empty($order_by)) {
			$this->db->order($order_by);
		}

		if (!empty($limit)) {
			$this->db->limit($offset . ',' . $limit);
		}
		
		$tag_list = $this->db->select();

		foreach($tag_list as $k=>$v) {
			if($v['level_pic']) {
				if(preg_match('/^images\//',$v['level_pic'])) {
					$tag_list[$k]['new_level_pic'] = getAttachmentUrl($v['level_pic']);	
				} else {
					$tag_list[$k]['new_level_pic'] = option('config.site_url').'/'.$v['level_pic'];
				}
			}
		}
		

		return $tag_list;
	}	
	
	
	/**
	 * 更改标签,条件一般指的是ID
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

	
}