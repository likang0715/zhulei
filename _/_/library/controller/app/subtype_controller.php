<?php 
/**
 * 专题分类相关
 */
class subtype_controller extends base_controller {
	// 专题导航
	public function subtype() {
		$store_id = $_REQUEST['store_id'];
		$sid = $_REQUEST['sid'];
		
		if (empty($store_id) || empty($sid)) {
			json_return(1000, '缺少参数');
		}
		
		$store = M('Store')->getStore($store_id, true);
		if (empty($store)) {
			json_return(1000, '未找到相应的店铺');
		}
		
		$tmp_store_id = $store_id;
		if (!empty($store['top_supplier_id']) && empty($store['drp_diy_store'])) {
			$tmp_store_id = $store['top_supplier_id'];
			
			$top_store = M('Store')->getStore($tmp_store_id);
			if (empty($top_store)) {
				json_return(1000, '未找到相应的店铺');
			}
		}
		
		$subtype_where = array('status' => 1, 'store_id' => $tmp_store_id, 'topid' => array('>', 0));
		$subtype_list_tmp = M('Subtype')->getLists($subtype_where, false, 'px ASC');
		
		$subtype_list = array();
		$title = '';
		foreach ($subtype_list_tmp as $subtype) {
			$tmp = array();
			$tmp['sid'] = $subtype['id'];
			$tmp['store_id'] = $subtype['store_id'];
			$tmp['typename'] = $subtype['typename'];
			$tmp['type_name'] = $subtype['typename'];
			
			if ($subtype['id'] == $sid) {
				$title = $subtype['typename'];
			}
			
			$subtype_list[] = $tmp;
		}
		
		if (empty($title)) {
			$title = '专题分类';
		}
		
		// 返回专题分类
		$return = array();
		$return['title'] = $title;
		$return['subtype_list'] = $subtype_list;
		json_return(0, $return);
	}
	
	// 专题列表
	public function subject_list() {
		$store_id = $_REQUEST['store_id'];
		$sid = $_REQUEST['sid'];
		$page = max(1, $_REQUEST['page']);
		$limit = 3;
		
		if (empty($store_id) || empty($sid)) {
			json_return(1000, '缺少参数');
		}
		
		$store = M('Store')->getStore($store_id, true);
		if (empty($store)) {
			json_return(1000, '未找到相应的店铺');
		}
		
		$tmp_store_id = $store_id;
		if (!empty($store['top_supplier_id']) && empty($store['drp_diy_store'])) {
			$tmp_store_id = $store['top_supplier_id'];
			$top_store = M('Store')->getStore($tmp_store_id);
			if (empty($top_store)) {
				json_return(1000, '未找到相应的店铺');
			}
		}
		
		$offset = ($page - 1) * $limit;
		$where = array('store_id' => $tmp_store_id, 'subject_typeid' => $sid);
		$subject_list = M('Subject')->getList($where, '', $limit, $offset, true);
		foreach($subject_list as &$subject) {
			$subject['subject_id'] = $subject['id'];
			$subject['desc'] = $subject['description'];
			$user_collect = D("User_collect")->where(array('type' => 3, 'store_id' => $store_id, 'user_id' => $this->user['uid'], 'dataid' => $subject['id']))->find();
			if ($user_collect) {
				$subject['is_dianzan'] = 1;
			} else {
				$subject['is_dianzan'] = 0;
			}
			
			unset($subject['id']);
			unset($subject['show_index']);
			unset($subject['subject_typeid']);
			unset($subject['px']);
			unset($subject['timestamp']);
			unset($subject['description']);
		}
		
		// 返回值
		$return['subject_list'] = $subject_list;
		$return['next_page'] = true;
		if((count($subject_list) < $limit)){
			$return['next_page'] = false;
		}
		
		json_return(0, $return);
	}
	
	// 点赞
	public function dianzan() {
		$store_id = $_REQUEST['store_id'];
		$subject_id = $_REQUEST['subject_id'];
		$uid = $this->user['uid'];
		
		if(empty($store_id) || empty($subject_id)) {
			json_return('1000', '缺少参数！');
		}
		
		$where = array('user_id' => $uid, 'dataid' => $subject_id, 'store_id' => $store_id, 'type' => 3);
		$user_collect = D('User_collect')->where($where)->find();
		
		if (empty($user_collect)) {
			$data = array(
					'store_id' => $store_id,
					'type' => 3,
					'dataid' => $subject_id,
					'add_time' => time(),
					'user_id' => $uid
			);
			D('User_collect')->data($data)->add();
			
			if(D('Store_subject_data')->where(array('subject_id' => $subject_id, 'store_id' => $store_id))->find()) {
				D('Store_subject_data')->where(array('subject_id' => $subject_id, 'store_id' => $store_id))->setInc('dz_count');
			} else {
				D('Store_subject_data')->data(array('subject_id' => $subject_id, 'store_id' => $store_id, 'dz_count' => 1))->add();
			}
			
			json_return('0', '专题点赞成功');
		} else {
			D('User_collect')->where($where)->delete();
			D('Store_subject_data')->where(array('subject_id' => $subject_id, 'store_id' => $store_id))->setDec('dz_count');
			json_return('0',"专题取消点赞成功！");
		}
	}
	
	// 专题详情页
	public function detail() {
		$store_id = $_REQUEST['store_id'];
		$subject_id = $_REQUEST['subject_id'];
		
		if (empty($subject_id)) {
			json_return(1000, '缺少参数');
		}
		
		$subject = M('Subject')->get(array('id' => $subject_id));
		if (empty($subject)) {
			json_return(1000, '未找到相应的专题');
		}
		$subject['sid'] = $subject['id'];
		$subject['desc'] = $subject['description'];
		unset($subject['id']);
		unset($subject['show_index']);
		unset($subject['subject_typeid']);
		unset($subject['px']);
		unset($subject['timestamp']);
		unset($subject['description']);
		
		if (empty($store_id)) {
			$store_id = $subject['store_id'];
		}
		
		$store = M('Store')->getStore($store_id, true);
		if (empty($store)) {
			json_return(1000, '未找到相应的店铺');
		}
		
		$tmp_store_id = $store_id;
		$top_store = array();
		if (!empty($store['top_supplier_id']) && empty($store['drp_diy_store'])) {
			$tmp_store_id = $store['top_supplier_id'];
			$top_store = M('Store')->getStore($tmp_store_id);
			if (empty($top_store)) {
				json_return(1000, '未找到相应的店铺');
			}
		}
		
		// 当前用户是否已点赞
		$user_collect = D("User_collect")->where(array('type' => 3, 'store_id' => $store_id, 'user_id' => $this->user['uid'], 'dataid' => $subject['id']))->find();
		if ($user_collect) {
			$subject['is_dianzan'] = 1;
		} else {
			$subject['is_dianzan'] = 0;
		}
		
		// 专题的相关数据
		$store_subject_data = D('Store_subject_data')->where(array('store_id' => $store_id, 'subject_id' =>$subject_id))->find();
		$subject['dz_count'] = $store_subject_data['dz_count'] + 0;
		$subject['share_count'] = $store_subject_data['share_count'] + 0;
		$subject['pinlun_count'] = $store_subject_data['pinlun_count'] + 0;
		
		// 查找相应商品
		$level = $store['drp_level'] > 3 ? 3 : $store['drp_level'];
		$product_list_tmp = M('Subject_product')->getList("sp.subject_id = '" . $subject_id . "'", '', 0, 0, true);
		$product_list = array();
		foreach ($product_list_tmp as $product) {
			$tmp = array();
			$tmp['product_id'] = $product['product_id'];
			$tmp['pic_list'] = $product['piclist'];
			$tmp['name'] = $product['name'];
			$tmp['collect'] = $product['collect'];
			$tmp['price'] = $level > 0 && $product['is_fx'] > 0 ? $product['drp_level_' . $level . '_price'] : $product['price'];
			
			$product_list[] = $tmp;
		}
		
		$return = array();
		$return['subject'] = $subject;
		$return['product_list'] = $product_list;
		
		json_return(0, $return);
	}
}
?>