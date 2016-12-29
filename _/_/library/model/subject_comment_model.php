<?php
class subject_comment_model extends base_model{

	
	public function getBysubject($id) {
		$list = $this->db->where(array("subject_id"=>$id))->select();
		foreach($list as $k=> &$v) {
			$v['piclist'] = explode("^",$v['piclist']);
			if(is_array($v['piclist'])) {
				foreach($v['piclist'] as $k1=>$v1) {
					$v['piclist'][$k1] = getAttachmentUrl($v1);
				}
			}
		}
		return $list;
	}
	
	/**
	 * 根据条件获到专题产品列表
	 * 当limit与offset都为0时，表示不行限制
	 */
	public function getList($where, $order_by = '', $limit = 0, $offset = 0,$getDetail = false) {
		$db_prefix = option('system.DB_PREFIX');
		if(false === $getDetail) {
			$this->db->where($where);
			if (!empty($order_by)) {
				$this->db->order($order_by);
			}
			if (!empty($limit)) {
				$this->db->limit($offset . ',' . $limit);
			}
			$list = $this->db->select();
		} else {
			if(is_array($where)) $where = implode(" AND ", $where);
			if($order_by) $where = $where ." order by ".$order_by;
			if($limit)$where = $where ." limit ".$offset.",".$limit." ";
			
			$sql = "SELECT sc.*,u.avatar,u.nickname,u.last_time FROM " . $db_prefix . "subject_comment AS sc left join " . $db_prefix . "user AS u ON u.uid=sc.uid WHERE  " . $where;
			$list = $this->db->query($sql);
		}
		
		foreach($list as $k=> &$tmp) {
			$tmp['nickname'] = $tmp['nickname'] ? $tmp['nickname'] : '匿名用户';
			if ($tmp['avatar']) {
				$tmp['avatar'] = getAttachmentUrl($tmp['avatar']);
			} else {
				$tmp['avatar'] = getAttachmentUrl('images/touxiang.png', false);
			}
		}
		return $list;
	}

	public function get($id) {
		return $this->db->where(array('id'=>$id))->find();
	}
	public function getArr($idarr) {
		return $this->db->where(array('id'=>array('in',$idarr)))->select();
	}
	public function save($data, $where) {
		$this->db->data($data)->where($where)->save();
	}

	public function delete($where) {
		$this->db->where($where)->delete();
	}	
	
	public function edit($where, $data) {
		return $this->db->where($where)->data($data)->save();
	}	
	
	
	public function getCount($where) {
		//$count = $this->db->field('count(1) as count')->where($where)->find();
		$count = D('')->table('Subject_comment sc')->field('count(1) as count')->where($where)->find();
		return $count['count'];
	}
	


}