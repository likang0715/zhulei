<?php
/**
 * 线下做单
 */
class offline_controller extends base_controller {
	public function load() {
		$action = strtolower(trim($_POST['page']));
		
		switch ($action) {
			case 'offline_add':
				$this->_offline_add();
				break;
			case 'list':
				$this->_list();
				break;
		}
		
		$this->display($_POST['page']);
	}
	
	public function offline_list() {
		$this->display();
	}
	
	public function offline_index() {
		// 商品类别，直接用大分类
		$product_category_list_tmp = M('Product_category')->getAllCategory('', true);
		$product_category_list = array();
		foreach ($product_category_list_tmp as $product_category) {
			$tmp = array();
			$tmp['cat_id'] = $product_category['cat_id'];
			$tmp['cat_name'] = $product_category['cat_name'];
			$tmp['son_data'] = array();
				
			if (is_array($product_category['larray'])) {
				$son_product_category_arr = array();
				foreach ($product_category['larray'] as $son_product_category) {
					$son_tmp = array();
					$son_tmp['cat_id'] = $son_product_category['cat_id'];
					$son_tmp['cat_name'] = $son_product_category['cat_name'];
						
					$son_product_category_arr[] = $son_tmp;
				}
		
				$tmp['son_data'] = $son_product_category_arr;
			}
				
			$product_category_list[] = $tmp;
		}
		
		$this->assign('product_category_list', $product_category_list);
		$this->display();
	}
	
	// 订单添加
	public function add() {
		$uid = $_POST['uid'];
		$total = $_POST['total'];
		$cash = $_POST['cash'];
		$platform_point = $_POST['platform_point'];
		$cat_id = $_POST['cat_id'];
		$product_name = $_POST['product_name'];
		$number = max(1, $_POST['number']);
		$bak = $_POST['bak'];
		
		if (empty($uid) || empty($total) || empty($cat_id) || empty($product_name)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		if ($uid == $this->store_session['uid']) {
			json_return(1000, '不能给自己手工做单');
		}
		
		$store_id = $this->store_session['store_id'];	

		$package_id = $this->user_session['package_id'];

		if($package_id > 0){ //店铺套餐--店铺每日做单限额 判断
			$package_store_point_total = D('Package')->where(array('pigcms_id'=>$package_id))->find();
			$package_store_point_total = $package_store_point_total['store_point_total'];
			if($package_store_point_total > 0 && option('credit.platform_credit_open')){
				$start_time = strtotime(date('Y-m-d 00:00:00'));
				$end_time = strtotime(date('Y-m-d 23:59:59'));
				$return_point = D('Order_offline')->where("store_id = '" . $store_id . "' AND check_status != 2 AND dateline >= '" . $start_time . "' AND dateline <= '" . $end_time . "'")->sum('return_point');

				$platform_credit_rule =  option('credit.platform_credit_rule');

				$tmp_return_point = $total * $platform_credit_rule;

				if ($return_point > $package_store_point_total || $tmp_return_point > $package_store_point_total || ($tmp_return_point+$return_point) > $package_store_point_total ) {
					json_return(1000, '尊敬的用户,您今日做单额度已达上限，无法再次做单');
				}	
			}
		}else{
			// 检查是否超过今天限额
			if (option('config.store_point_total') > 0 && option('credit.platform_credit_open')) {
				$start_time = strtotime(date('Y-m-d 00:00:00'));
				$end_time = strtotime(date('Y-m-d 23:59:59'));
				
				$return_point = D('Order_offline')->where("store_id = '" . $store_id . "' AND check_status != 2 AND dateline >= '" . $start_time . "' AND dateline <= '" . $end_time . "'")->sum('return_point');

				$platform_credit_rule =  option('credit.platform_credit_rule');

				$tmp_return_point = $total * $platform_credit_rule;
				
				
				if ($return_point > option('config.store_point_total') || $tmp_return_point > option('config.store_point_total') || ($tmp_return_point+$return_point) > option('config.store_point_total') ) {
				
					json_return(1000, '尊敬的用户,您今日做单额度已达上限，无法再次做单');
				}
			}
		}

		
		
		$result = Offline::add($store_id, $uid, $total, $cash, $platform_point, $cat_id, $product_name, $number, $bak);
		json_return(0, $result['err_msg']);
	}
	
	// 完成
	public function complete() {
		$order_id = $_GET['order_id'];
		if (empty($order_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		$order_offline = D('Order_offline')->where(array('id' => $order_id, 'store_id' => $this->store_session['store_id']))->find();
		if (empty($order_offline)) {
			json_return(1000, '未找到相应的订单');
		}
		
		if (empty($order_offline['check_status'])) {
			json_return(1000, '请等待审核');
		}
		
		if ($order_offline['check_status'] == 2) {
			json_return(1000, '订单未审核通过');
		}
		
		if (!empty($order_offline['status'])) {
			json_return(1000, '订单已完成，不须再次操作');
		}
		
		Offline::complete($order_offline);
		json_return(0, '操作成功');
	}
	
	private function _list() {
		$start_time = $_POST['start_time'];
		$end_time = $_POST['end_time'];
		$order_no = $_POST['order_no'];
		$check_status = $_POST['check_status'];
		$p = max(1, $_POST['p']);
		
		$where = array();
		$where['store_id'] = $this->store_session['store_id'];
		
		if (!empty($start_time) && !empty($end_time)) {
			$where['_string'] = "`dateline` >= '" . strtotime($start_time) . "' AND `dateline` <= '" . strtotime($end_time) . "'";
		} else if (!empty($start_time)) {
			$where['dateline'] = array('>=', strtotime($start_time));
		} else if (!empty($end_time)) {
			$where['dateline'] = array('<=', strtotime($end_time));
		}
		
		if (!empty($order_no)) {
			$where['order_no'] = $order_no;
		}
		
		if (!empty($check_status) && $check_status != '*') {
			$where['check_status'] = max(0, $check_status);
		}
		
		// 商品分类
		$product_category_list_tmp = D('Product_category')->where(array('cat_status' => 1))->select();
		$product_category_list = array();
		foreach ($product_category_list_tmp as $product_category) {
			$tmp = array();
			$tmp['cat_id'] = $product_category['cat_id'];
			$tmp['cat_name'] = $product_category['cat_name'];
			$tmp['cat_fid'] = $product_category['cat_fid'];
			$product_category_list[$tmp['cat_id']] = $tmp;
		}
		
		$count = M('Order_offline')->getCount($where);
		$order_offline_list = array();
		if ($count > 0) {
			$limit = 10;
			$p = min($p, ceil($count / $limit));
			$offset = ($p - 1) * $limit;
			
			$order_offline_list = M('Order_offline')->getList($where, 'id DESC', $limit, $offset);
			foreach ($order_offline_list as &$order_offline) {
				
			}
			
			//增加用户名显示 by hz

			$tmp_uids = array_map(function($v){
				return $v['uid'];
			}, $order_offline_list);

			$offline_users_arr = D('User')->field('uid,nickname')->where(array('uid'=>array('in',array(join(',',$tmp_uids)))))->select();
			
			foreach ($offline_users_arr as $key => $value) {
				$offline_users[$value['uid']] = $value['nickname'];
			}

			$this->assign('offline_users', $offline_users);
			
			import('source.class.user_page');
			$page = new Page($count, $limit, $p);
			$this->assign('page', $page->show());
		}
		
		$this->assign('start_time', $start_time);
		$this->assign('end_time', $end_time);
		$this->assign('order_no', $order_no);
		$this->assign('check_status', $check_status);
		$this->assign('order_offline_list', $order_offline_list);
	}
	
	private function _offline_add() {
		$store = D('Store')->where(array('store_id' => $this->store_session['store_id']))->find();
		if (empty($store)) {
			pigcms_tips('未找到相应的店铺');
		}
		$user = D('User')->where(array('uid' => $store['uid']))->find();
		if (empty($user)) {
			pigcms_tips('未找到相应的店铺用户');
		}
		
		$this->assign('store', $store);
		$this->assign('user', $user);
	}
}