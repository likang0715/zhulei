<?php
class subtype_model extends base_model{

	
	/*@param: getTree 是否以树形展示*/
	public function getLists($where,$getTree = true, $orderby="", $offset="0", $limit="0") {
		/* $orderby = "" . $orderby;
		if($orderby)$this->db->order("cat_");
		if($limit) $this->db->limit($offset . ',' . $limit);
		$array = $this->db->where($where)->select();
		//if($getTree) $array = $this->getTree($array);
		return $array; */
		
		$orderby = 'topid ASC,`px` asc,`id` ASC';
		$list = $this->db->where($where)->order($orderby)->select();
		if($getTree) {
			
			
			foreach($list as $k=>$v) {
				if($v['typepic'])  $v['typepic'] = getAttachmentUrl($v['typepic']);
				if($v[topid]==0) {
					$arr2[$v[id]] = $v;
				}else {
					$arr2[$v[topid]]['childArray'][$v['px'].$k] = $v;
				}
			}
			if(is_array($arr2)) {
				foreach($arr2 as $k=>$v) {
					if(is_array($v['childArray'])) ksort($v['childArray'],SORT_NUMERIC);
					$arr2[$k] = $v;
				}
			}
			
		} else {
			$arr2 = $list;
		}
		
		
		//echo "<pre>";
		//print_r($arr2);exit;
		
		
		return $arr2;
	}
	
	
	/**
	 * 获取单个分类的专题树  （向上）
	 */
	public function getOneTree($sub_typeid,$store_id) {
		$this_subtype = $this->db->where(array('store_id'=>$store_id,'id'=>$sub_typeid))->find();
		if($this_subtype['topid']) {
			$this_subtype['father'] = $this->db->where(array('store_id' => $store_id,'id' => $this_subtype['topid']))->find();
		}

		return $this_subtype;
	}
	
	
	
	
	public function get($id) {
		$subtype =  $this->db->where(array('id'=>$id))->find();
		if($subtype['typepic']) $subtype['typepic'] = getAttachmentUrl($subtype['typepic']);
		return $subtype;
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
	
	/*
	 * @param ： type:(difficult: 显示 子分类及其数组，  simple：仅 显示自分类id的数组)
	 * */
	public function getSonList($topid,$type='difficult') {
		
		if($type == 'difficult') {
			$where = array('topid'=>$topid,'status'=>1);
			return $this->db->where($where)->select();
		} else if($type == 'simple') {
			$where = array('topid'=>$topid,'status'=>1);
			$array = $this->db->where($where)->select();
			$arr = array();
			foreach($array as $k=>$v) {
				$arr[] = $v['id'];
			}
			return $arr;
		}
	}
	
	public function getCount($where) {
		$count = $this->db->field('count(1) as count')->where($where)->find();
		return $count['count'];
	}
	
	
	/*S树形变换*/
	function getTree($typearray, $id = 'id', $upid = 'upid', $child = 'childArray', $root = 0) {
		$treeArray = array();
		if (is_array($typearray)) {
			$array = array();
			foreach ($typearray as $key => $item) {
				$array[$item[$id]] = & $typearray[$key];
			}
			foreach ($typearray as $key => $item) {
				$parentId = $item[$upid];
				if ($root == $parentId) {
					$treeArray[] = &$typearray[$key];
				} else {
					if (isset($array[$parentId])) {
						$parent = &$array[$parentId];
						$parent[$child][] = &$typearray[$key];
					}
				}
			}
		}
		return $treeArray;
	}

}