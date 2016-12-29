<?php 
/**
 * 优惠券
 */
class coupon_controller extends base_controller {
	// 店铺优惠券页
	public function index() {
		$store_id = $_REQUEST['store_id'];
		$coupon_id = $_REQUEST['coupon_id'];
		$page = max(1, $_REQUEST['page']);
		$time = time();
		$limit = 10;
		
		if (empty($store_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		$store = M('Store')->getStore($store_id);
		if (empty($store)) {
			json_return(1000, '未找到相应的店铺');
		}
		// 分销商向上级找到供货商
		if ($store['drp_level'] > 0 && $store['root_supplier_id'] > 0) {
			$supplier_store = M('Store')->getStore($store['root_supplier_id']);
			if (empty($supplier_store)) {
				json_return(1000, '未找到相应的店铺');
			}
			$store_id = $supplier_store['store_id'];
		}
		
		$where = array();
		$where['store_id'] = $store_id;
		if ($coupon_id > 0) {
			$where['id'] = $coupon_id;
		}
		$where['status'] = 1;
		$where['type'] = 1;
		$where['total_amount'] = array('>', 0);
		$where['start_time'] = array('<', $time);
		$where['end_time'] = array('>=', $time);
		
		$offset = ($page - 1) * $limit;
		$order_by = '';
		$coupon_list = M('Coupon')->getList($where, $order_by, $limit, $offset);
		
		foreach ($coupon_list as &$coupon) {
			$coupon['coupon_id'] = $coupon['id'];
			$coupon['desc'] = $coupon['description'];
			unset($coupon['id']);
			unset($coupon['description']);
		}
		
		$return = array();
		$return['store'] = array('name' => $store['name'], 'store_id' => $store['store_id']);
		$return['coupon_list'] = $coupon_list;
		$return['next_page'] = true;
		
		if (count($coupon_list) < $limit) {
			$return['next_page'] = false;
		}
		
		json_return(0, $return);
	}
	
	// 用户领取优惠券
	public function collect() {
		$coupon_id = $_REQUEST['coupon_id'];
		$time = time();
		
		if (empty($coupon_id)) {
			json_return('1000', '缺少最基本的参数');
		}
		
		$coupon = D('Coupon')->where(array('id' => $coupon_id))->find();
		if (empty($coupon)) {
			json_return(1000, '未找到相应的优惠券');
		}
		
		// 查看是否已经领取
		if ($coupon['total_amount'] <= $coupon['number']) {
			json_return('1000','该优惠券已经全部发放完了');
		}
		
		if ($coupon['status'] == '0') {
			json_return('1000','该优惠券已失效!');
		}
		
		if ($time > $coupon['end_time'] || $time < $coupon['start_time']) {
			json_return('1000','该优惠券未开始或已结束!');
		}
		
		if ($coupon['type'] == '2') {
			json_return('1000','不可领取赠送券!');
		}
		
		$user_coupon = D('User_coupon')->where(array('uid' => $this->user['uid'], 'coupon_id' => $coupon_id))->field("count(id) as count")->find();
		// 查看当前用户是否达到最大领取限度
		if ($coupon['most_have'] != '0') {
			if ($user_coupon['count'] >= $coupon['most_have']) {
				json_return('1000','您已达到该优惠券允许的最大单人领取限额!');
			}
		}
		
		// 领取
		if (M('User_coupon')->add($this->user['uid'], $coupon)) {
			//修改优惠券领取信息
			unset($where);unset($data);
		
			$where = array('id' => $coupon_id);
			D('Coupon')->where($where)->setInc('number', 1);
			json_return('0', '领取成功!');
		} else {
			json_return('1000','领取失败!');
		}
	}
	
	// 我的优惠券
	public function all() {
		$type = $_REQUEST['type'];
		$page = max(1, $_REQUEST['page']);
		$store_id = $_REQUEST['store_id'];
		
		if (!in_array($type, array('all', 'unuse', 'use'))) {
			$type = 'all';
		}
		
		if (!empty($store_id)) {
			$store = M('Store')->getStore($store_id, true);
			
			if (empty($store)) {
				json_return(1000, '未找到相应的店铺');
			}
			
			if ($store['top_supplier_id']) {
				$store_id = $store['top_supplier_id'];
			}
		}
		
		$time = time();
		$where = array();
		switch ($type) {
			case 'unuse':
				$where['is_use'] = 0;
				$where['end_time'] = array('>', $time);
				break;
			case 'use':
				$where['is_use'] = 1;
				break;
			case 'expired':
				$where['is_use'] = 0;
				$where['end_time'] = array('<', $time);
				break;
			default:
				break;
		}
		$where['delete_flg'] = '0';
		$where['uid'] = $this->user['uid'];
		$where['is_valid'] = 1;
		
		$limit = 10;
		$offset = ($page - 1) * $limit;
		$order_by = 'id DESC';
		$coupon_list = M('User_coupon')->getList($where, $order_by, $limit, $offset);
		
		foreach ($coupon_list as &$coupon) {
			$coupon['coupon_id'] = $coupon['id'];
			$coupon['desc'] = $coupon['description'];
			
			unset($coupon['id']);
			unset($coupon['description']);
		}
		
		$return = array();
		$return['coupon_list'] = $coupon_list;
		$return['next_page'] = true;
		
		if (count($coupon_list) < $limit) {
			$return['next_page'] = false;
		}
		
		json_return(0, $return);
	}
}
?>