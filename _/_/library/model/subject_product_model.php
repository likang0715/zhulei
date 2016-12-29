<?php
class subject_product_model extends base_model{

	
	public function getBysubject($id) {
		$list = $this->db->where(array("subject_id"=>$id))->order("sort asc,id asc")->select();
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
			} else {
				$this->db->order("sp.sort asc,sp.id asc");
			}
			if (!empty($limit)) {
				$this->db->limit($offset . ',' . $limit);
			}
			$list = $this->db->select();
		} else {
			$limits = " ";
			if(is_array($where)) $where = implode(" AND ", $where);
			if($limit)$limits = " limit ".$offset.",".$limit." ";
			
			$sql = "SELECT sp.*,p.name,p.intro,p.collect,p.unified_price_setting,p.is_fx,p.original_price,p.price,p.min_fx_price,p.max_fx_price,p.cost_price,p.drp_level_1_price,p.drp_level_2_price,p.drp_level_3_price FROM " . $db_prefix . "product AS p left join " . $db_prefix . "subject_product AS sp on p.product_id=sp.product_id WHERE p.status = 1 and " . $where ." order by sp.sort asc,sp.id asc ".$limits;
			$list = $this->db->query($sql);
		}
		
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


	
	
	
	public function save($data, $where) {
		$this->db->data($data)->where($where)->save();
	}

	public function delete($where) {
		$this->db->where($where)->delete();
	}	
	
	public function edit($where, $data) {
		return $this->db->where($where)->data($data)->save();
	}	
	
	public function getSonList($topid) {
		
		$where = array('topid'=>$topid,'status'=>1);
		return $this->db->where($where)->select();
	}
	
	public function getCount($where) {
		//$count = $this->db->field('count(1) as count')->where($where)->find();
		
		$count = D('')->table('Subject_product sp')->field('count(1) as count')->where($where)->find();
		return $count['count'];
	}
	


}