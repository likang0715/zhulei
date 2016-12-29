<?php
/**
 * 团购功能
 */
class tuan_controller extends base_controller {
	// 加载
	public function load() {
		$action = strtolower(trim($_POST['page']));
		if (empty($action)) pigcms_tips('非法访问！', 'none');
		
		switch ($action) {
			case 'tuan_list' :
				$this->_tuan_list();
				break;
			case 'edit' :
				$this->_edit();
				break;
			case 'info' :
				$this->_info();
				break;
			case 'order' :
				$this->_order();
				break;
			case 'team' :
				$this->_team();
				break;
			default:
				break;
		}
		
		$this->display($_POST['page']);
	}
	
	public function tuan_index() {
		$this->display();
	}
	
	public function add() {
		$name = $_POST['name'];
		$product_id = $_POST['product_id'];
		$start_time = $_POST['start_time'];
		$end_time = $_POST['end_time'];
		$description = $_POST['description'];
		$condition_arr = $_POST['condition'];
		
		if (empty($name)) {
			json_return(1000, '团购名称不能为空');
		}
		
		if (empty($product_id)) {
			json_return(1000, '请选择参团的产品');
		}
		
		if (empty($start_time)) {
			json_return(1000, '团购开始时间不能为空');
		}
		
		if (empty($end_time)) {
			json_return(1000, '团购结束时间不能为空');
		}
		
		$number_arr = array();
		$discount_arr = array();
		// $start_number_arr = array();
		$min_discount = 10;
		foreach ($condition_arr as $condition) {
			list($number, $discount) = explode('_', $condition);
			if ($number + 0 == 0) {
				json_return(1000, '请正确填写参团人数');
			}
			
			if ($discount + 0 == 0) {
				$discount = 10;
			} else if ($discount > 10) {
				json_return(1000, '请正确填写团购折扣，最大只能为10');
			}
			
			/*
			if ($number + 0 < $start_number + 0) {
				json_return(1000, '开始人数不能大于参团人数');
			}
			*/
			
			$min_discount = min($discount, $min_discount);
			
			$number_arr[] = $number + 0;
			$discount_arr[] = $discount + 0;
			// $start_number_arr[] = $start_number + 0;
		}
		
		$product = D('Product')->where(array('product_id' => $product_id, 'store_id' => $this->store_session['store_id'], 'status' => array('!=', 2)))->find();
		if (empty($product)) {
			json_return(1000, '未找要参团的产品');
		}
		
		$data = array();
		$data['dateline'] = time();
		$data['name'] = $name;
		$data['store_id'] = $this->store_session['store_id'];
		$data['uid'] = $this->store_session['uid'];
		$data['product_id'] = $product_id;
		$data['start_price'] = $product['price'] * $discount / 10;
		$data['start_time'] = strtotime($start_time);
		$data['end_time'] = strtotime($end_time);
		$data['description'] = $description;
		$data['status'] = 1;
		$tuan_id = D('Tuan')->data($data)->add();
		
		if (!$tuan_id) {
			json_return(1000, '添加失败，请重试');
		}
		
		foreach ($number_arr as $key => $number) {
			$data = array();
			$data['tuan_id'] = $tuan_id;
			$data['number'] = $number;
			$data['discount'] = $discount_arr[$key];
			// $data['start_number'] = $start_number_arr[$key];
			
			D('Tuan_config')->data($data)->add();
		}
		
		json_return(0, url('tuan:tuan_index'));
	}
	
	public function edit() {
		$tuan_id = $_POST['tuan_id'];
		$name = $_POST['name'];
		$product_id = $_POST['product_id'];
		$start_time = $_POST['start_time'];
		$end_time = $_POST['end_time'];
		$description = $_POST['description'];
		$condition_arr = $_POST['condition'];
		
		if (empty($name)) {
			json_return(1000, '团购名称不能为空');
		}
		
		if (empty($product_id)) {
			json_return(1000, '请选择参团的产品');
		}
		
		if (empty($start_time)) {
			json_return(1000, '团购开始时间不能为空');
		}
		
		if (empty($end_time)) {
			json_return(1000, '团购结束时间不能为空');
		}
		
		if (empty($tuan_id)) {
			json_return(1000, '缺少最基本的参数ID');
		}
		
		$tuan = D('Tuan')->where(array('id' => $tuan_id, 'store_id' => $this->store_session['store_id'], 'delete_flg' => 0))->find();
		if (empty($tuan)) {
			json_return(1000, '未找到要修改的团购');
		}
		
		if ($tuan['start_time'] < time()) {
			json_return(1000, '此团购已开始，不能修改');
		}
		
		$number_arr = array();
		$discount_arr = array();
		$start_number_arr = array();
		$min_discount = 10;
		foreach ($condition_arr as $condition) {
			list($number, $discount) = explode('_', $condition);
			if ($number + 0 == 0) {
				json_return(1000, '请正确填写参团人数');
			}
			
			if ($discount + 0 == 0) {
				$discount = 10;
			} else if ($discount > 10) {
				json_return(1000, '请正确填写团购折扣，最大只能为10');
			}
			
			/*
			if ($number + 0 < $start_number + 0) {
				json_return(1000, '开始人数不能大于参团人数');
			}
			*/
			
			$min_discount = min($discount, $min_discount);
			
			$number_arr[] = $number + 0;
			$discount_arr[] = $discount + 0;
			// $start_number_arr[] = $start_number + 0;
		}
		
		$product = D('Product')->where(array('product_id' => $product_id, 'store_id' => $this->store_session['store_id'], 'status' => array('!=', 2)))->find();
		if (empty($product)) {
			json_return(1000, '未找要参团的产品');
		}
		
		$data = array();
		$data['name'] = $name;
		$data['store_id'] = $this->store_session['store_id'];
		$data['uid'] = $this->store_session['uid'];
		$data['product_id'] = $product_id;
		$data['start_price'] = $product['price'] * $discount / 10;
		$data['start_time'] = strtotime($start_time);
		$data['end_time'] = strtotime($end_time);
		$data['description'] = $description;
		
		D('Tuan')->where(array('id' => $tuan_id))->data($data)->save();
		D('Tuan_config')->where(array('tuan_id' => $tuan_id))->delete();
		
		foreach ($number_arr as $key => $number) {
			$data = array();
			$data['tuan_id'] = $tuan_id;
			$data['number'] = $number;
			$data['discount'] = $discount_arr[$key];
			// $data['start_number'] = $start_number_arr[$key];
			
			D('Tuan_config')->data($data)->add();
		}
		
		json_return(0, url('tuan:tuan_index'));
	}
	
	// 使失效
	public function disabled() {
		$tuan_id = $_GET['tuan_id'] + 0;
		
		if (empty($tuan_id)) {
			json_return(1001, '缺少最基本的参数ID');
		}
		
		$tuan = D('Tuan')->where(array('id' => $tuan_id, 'store_id' => $this->store_session['store_id']))->find();
		if (empty($tuan)) {
			json_return(1001, '未找到相应的活动');
		}
		
		if ($tuan['status'] == 2) {
			json_return(1000, '此团购已失效，无须再次操作');
		}
		
		if ($tuan['end_time'] < time()) {
			json_return(1000, '此团购已经结束，不能进行失效操作');
		}
		
		$data = array();
		$data['status'] = 2;
		$result = D('Tuan')->where(array('id' => $tuan_id))->data(array('status' => 2, 'tuan_config_id' => -1, 'operation_dateline' => time()))->save();
		
		if ($result) {
			// 所有开团全部失败
			D('Tuan_team')->where(array('tuan_id' => $tuan_id))->data(array('status' => 2))->save();
			set_time_limit(0);
			// 已产生的订单进入退货流程
			$where = array();
			$where['store_id'] = $this->store_session['store_id'];
			$where['type'] = 6;
			$where['data_id'] = $tuan_id;
			$where['status'] = array('in', array(2, 3, 7));
			$order_list = D('Order')->where($where)->field('order_id, order_no, uid, store_id, pro_num, address_tel')->select();
				
			import('source.class.ReturnOrder');
			ReturnOrder::batchReturn($order_list);
			
			json_return(0, '操作完成');
		} else {
			json_return(1000, '操作失败');
		}
	}
	
	// 删除
	public function delete() {
		$id = $_GET['id'] + 0;
		
		if (empty($id)) {
			json_return(1001, '缺少最基本的参数ID');
		}
		
		$tuan = D('Tuan')->where(array('id' => $id, 'store_id' => $this->store_session['store_id'], 'delete_flg' => 0))->find();
		if (empty($tuan)) {
			json_return(1001, '未找到相应的团购活动');
		}
		
		if ($tuan['start_time'] < time()) {
			json_return(1000, '活动已开始，不能进行删除操作');
		}
		
		D('Tuan')->where(array('id' => $id))->data(array('delete_flg' => 1))->save();
		json_return(0, '删除完成');
	}
	
	// 团购结束
	public function over() {
		$tuan_id = $_POST['tuan_id'];
		$type = $_POST['type'];
		$tuan_config = array();
		
		if (empty($tuan_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		// 查找相应团购
		$tuan = D('Tuan')->where(array('id' => $tuan_id, 'store_id' => $this->store_session['store_id']))->find();
		if (empty($tuan)) {
			json_return(1000, '未找到相应的团购活动');
		}
		
		if ($tuan['operation_dateline'] > 0) {
			json_return(1000, '此团购已设置过了，无需再操作');
		}
		
		// 查找达标团购项
		if ($type != 'cancel') {
			if (Tuan::operate($tuan, $tuan_id)) {
				json_return(0, '操作成功');
			} else {
				json_return(0, '操作失败');
			}
			
			/*
			$tuan_config_list = D('Tuan_config')->where(array('tuan_id' => $tuan_id))->order('discount DESC')->select();
			if (empty($tuan_config_list)) {
				json_return(1000, '未找到相应的团购项');
			}
			
			$is_has = false;
			foreach ($tuan_config_list as $tmp) {
				if ($tmp['id'] == $tuan_config_id) {
					$tuan_config = $tmp;
					$is_has = true;
					break;
				}
			}
			
			if (!$is_has) {
				json_return(1000, '未找到相应的团购项');
			}
			
			// 查出人缘开团购买数量
			$where = array();
			$where['store_id'] = $this->store_session['store_id'];
			$where['type'] = 6;
			$where['data_id'] = $tuan_id;
			$where['data_type'] = 0;
			$where['status'] = array('in', array(2, 3, 4, 7));
			$count_ry = D('Order')->where($where)->sum('pro_num');
			
			$where['data_type'] = 1;
			$count_list_tmp = D('Order')->where($where)->field('data_item_id, sum(pro_num) AS count')->group('data_item_id')->select();
			$count_list = array();
			$count += $count_ry;
			foreach ($count_list_tmp as $tmp) {
				$count += $tmp['count'];
				$count_list[$tmp['data_item_id']] = $tmp['count'];
			}
			
			// 判断哪一级达标，只能操作最高级别的达标设置
			$level = -1;
			$level_arr = array();
			$tuan_config_id_arr = array();
			$start_count = $count_ry;
			foreach ($tuan_config_list as $key => $tmp) {
				$start_count += $count_list[$tmp['id']];
				$count =  + $tmp['start_number'] + $start_count;
				if ($count > $tmp['number']) {
					$level_arr[$key] = true;
				} else {
					$level_arr[$key] = false;
				}
				$tuan_config_id_arr[$key] = $tmp['id'];
				
				if ($tmp['id'] == $tuan_config_id) {
					$level = $key;
				}
			}
			
			foreach ($level_arr as $key => $val) {
				if ($val == true && $key > $level) {
					json_return(1000, '有更高级别团购项达标');
				}
			}
			
			// 处理哪些级别退货，哪些级别需要退款
			$return_money_arr = array();
			$return_arr = array();
			foreach ($tuan_config_id_arr as $key => $tmp) {
				if ($level > $key) {
					$return_money_arr[] = $tmp;
				}
				
				if ($level < $key) {
					$return_arr[] = $tmp;
				}
			}
			
			$result = D('Tuan')->where(array('id' => $tuan_id))->data(array('tuan_config_id' => $tuan_config_id, 'operation_dateline' => $_SERVER['REQUEST_TIME']))->save();
			if (!$result) {
				json_return(1000, '操作失败');
			}
			
			// 取消限时
			set_time_limit(0);
			// 未支付直接进入取消
			Tuan::cancelOrder($tuan['store_id'], $tuan_id);
			
			// 退款处理
			if (!empty($return_money_arr)) {
				Tuan::returnMoney($tuan, $tuan_config, $return_money_arr, $level);
			}
			
			// 未达标高级别最优团，自动进入退货
			if (!empty($return_arr)) {
				$where = array();
				$where['store_id'] = $this->store_session['store_id'];
				$where['type'] = 6;
				$where['data_id'] = $tuan_id;
				$where['data_type'] = 1;
				$where['data_item_id'] = array('in', $return_arr);
				$where['status'] = 2;
				$order_list = D('Order')->where($where)->field('order_id, order_no, uid, store_id, pro_num, address_tel')->select();
					
				import('source.class.ReturnOrder');
				ReturnOrder::batchReturn($order_list);
			}
			*/
		} else {
			$result = D('Tuan')->where(array('id' => $tuan_id))->data(array('tuan_config_id' => '-1', 'operation_dateline' => $_SERVER['REQUEST_TIME']))->save();
			if (!$result) {
				json_return(1000, '操作失败');
			}
			
			// 未发货状态进行自动退货
			$where = array();
			$where['store_id'] = $this->store_session['store_id'];
			$where['type'] = 6;
			$where['data_id'] = $tuan_id;
			$where['status'] = 2;
			$order_list = D('Order')->where($where)->field('order_id, order_no, uid, store_id, pro_num, address_tel')->select();
			
			if (!empty($order_list)) {
				set_time_limit(0);
				import('source.class.ReturnOrder');
				ReturnOrder::batchReturn($order_list);
			}
		}
		
		json_return(0, '操作成功');
	}
	
	private function _tuan_list() {
		$page = $_REQUEST['p'] + 0;
		$page = max(1, $page);
		$type = $_REQUEST['type'];
		$keyword = $_REQUEST['keyword'];
		$limit = 20;
		
		$type_arr = array('future', 'on', 'end', 'all');
		if (!in_array($type, $type_arr)) {
			$type = 'all';
		}
		
		$uid = $_SESSION['store']['uid'];
		$store_id = $_SESSION['store']['store_id'];
		
		$where = array();
		$where['uid'] = $uid;
		$where['store_id'] = $store_id;
		$where['delete_flg'] = 0;
		
		if (!empty($keyword)) {
			$where['name'] = array('like', '%' . $keyword . '%');
		}
		
		$time = time();
		if ($type == 'future') {
			$where['start_time'] = array('>', $time);
			$where['status'] = 1;
		} else if ($type == 'on') {
			$where['start_time'] = array('<', $time);
			$where['end_time'] = array('>', $time);
			$where['status'] = 1;
		} else if ($type == 'end') {
			$where['_string'] = "`uid` = '" . $uid . "' AND `store_id` = '" . $store_id . "' AND (`end_time` < '" . $time . "' OR `status` = '2')";
		}
		
		$tuan_model = M('Tuan');
		$count = $tuan_model->getCount($where);
		
		$tuan_list = array();
		$pages = '';
		if ($count > 0) {
			$page = min($page, ceil($count / $limit));
			$offset = ($page - 1) * $limit;
			
			$tuan_list = $tuan_model->getList($where, 'id desc', $limit, $offset);
			
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}
		
		$product_id_arr = array();
		foreach ($tuan_list as &$tuan) {
			$tuan['count'] = D('Tuan_team')->where(array('tuan_id' => $tuan['id'], 'pay_status' => 1))->count('team_id');
			$tuan['number'] = M('Order')->getActivityOrderCount(6, $tuan['id'], '');
			$product_id_arr[$tuan['product_id']] = $tuan['product_id'];
			
			// 如果团购有处理结果，查看成功与失败
			if ($tuan['operation_dateline'] > 0) {
				$tuan['tuan_team_list'] = array('1' => 0, '2' => 0);
				$tuan_team_list = D('Tuan_team')->where(array('tuan_id' => $tuan['id'], 'pay_status' => 1))->group('status')->field('status, count(status) as count')->select();
				
				foreach ($tuan_team_list as $tuan_team) {
					$tuan['tuan_team_list'][$tuan_team['status']] = $tuan_team['count'];
				}
			}
		}
		
		// 查找团购产品
		$product_list = array();
		if ($product_id_arr) {
			$product_list_tmp = D('Product')->where(array('product_id' => array('in', $product_id_arr)))->field('`product_id`, `name`, `image`')->select();
			
			foreach ($product_list_tmp as $product) {
				$product['image'] = getAttachmentUrl($product['image']);
				$product['url'] = option('config.wap_site_url') . '/good.php?id=' . $product['product_id'];
				$product_list[$product['product_id']] = $product;
			}
		}
		
		$this->assign('keyword', $keyword);
		$this->assign('type', $type);
		$this->assign('pages', $pages);
		$this->assign('product_list', $product_list);
		$this->assign('tuan_list', $tuan_list);
	}
	
	private function _edit() {
		$tuan_id = $_POST['tuan_id'];
		
		if (empty($tuan_id)) {
			echo '缺少最基本的参数ID';
			exit;
		}
		
		$tuan = D('Tuan')->where(array('id' => $tuan_id, 'store_id' => $this->store_session['store_id'], 'delete_flg' => 0))->find();
		if (empty($tuan)) {
			echo '未找到要修改的团购';
			exit;
		}
		
		if ($tuan['start_time'] < time()) {
			echo '此团购已开始，不能编辑';
			exit;
		}
		
		$product = D('Product')->where(array('product_id' => $tuan['product_id'], 'store_id' => $this->store_session['store_id'], 'status' => array('!=', 2)))->field('`product_id`, `name`, `image`')->find();
		if (!empty($product)) {
			$product['image'] = getAttachmentUrl($product['image']);
			$product['url'] = option('config.wap_site_url') . '/good.php?id=' . $product['product_id'];
		}
		
		$tuan_config_list = D('Tuan_config')->where(array('tuan_id' => $tuan_id))->order('discount DESC')->select();
		
		$this->assign('tuan', $tuan);
		$this->assign('product', $product);
		$this->assign('tuan_config_list', $tuan_config_list);
	}
	
	private function _info() {
		$tuan_id = $_POST['tuan_id'];
		
		if (empty($tuan_id)) {
			pigcms_tips('缺少最基本的参数ID');
		}
		
		$tuan = D('Tuan')->where(array('id' => $tuan_id, 'store_id' => $this->store_session['store_id'], 'delete_flg' => 0))->find();
		if (empty($tuan)) {
			pigcms_tips('未找相应的团购');
		}
		$product = M('Product')->get(array('product_id' => $tuan['product_id'], 'store_id' => $tuan['store_id']), 'product_id, name, image, price, sales');
		
		$tuan_config_list = D('Tuan_config')->where(array('tuan_id' => $tuan_id))->order('discount DESC')->select();
		foreach ($tuan_config_list as &$tuan_config) {
			if ($tuan['operation_dateline'] > 0) {
				$tuan_config['fail_count'] = D('Tuan_team')->where(array('status' => 2, 'item_id' => $tuan_config['id'], 'tuan_id' => $tuan_id, 'pay_status' => 1))->count('team_id');
				$tuan_config['success_count'] = D('Tuan_team')->where(array('status' => 1, 'real_item_id' => $tuan_config['id'], 'tuan_id' => $tuan_id, 'pay_status' => 1))->count('team_id');
			} else {
				$tuan_config['count'] = D('Tuan_team')->where(array('item_id' => $tuan_config['id'], 'tuan_id' => $tuan_id, 'pay_status' => 1))->count('team_id');
			}
		}
		
		// 查出人缘开团购买数量
		$where = array();
		$where['store_id'] = $this->store_session['store_id'];
		$where['type'] = 6;
		$where['data_id'] = $tuan_id;
		$where['status'] = array('in', array(2, 3, 4, 7));
		
		$count_list_tmp = D('Order')->where($where)->field('data_type, sum(data_type) AS count')->group('data_type')->select();
		$count_list = array(0, 0);
		foreach ($count_list_tmp as $tmp) {
			$count_list[$tmp['data_type']] = $tmp['count'];
		}
		
		$this->assign('tuan', $tuan);
		$this->assign('product', $product);
		$this->assign('tuan_config_list', $tuan_config_list);
		$this->assign('count_list', $count_list);
	}
	
	private function _order() {
		$tuan_id = $_REQUEST['tuan_id'];
		$team_id = $_REQUEST['team_id'];
		$p = max(1, $_REQUEST['p']);
		$limit = 15;
		
		if (empty($tuan_id)) {
			pigcms_tips('缺少最基本的参数ID');
		}
		
		$tuan = D('Tuan')->where(array('id' => $tuan_id, 'store_id' => $this->store_session['store_id'], 'delete_flg' => 0))->find();
		if (empty($tuan)) {
			pigcms_tips('未找相应的团购');
		}
		
		$count = M('Order')->getActivityOrderCount(6, $tuan_id, $team_id, 'ALL');
		$order_list = array();
		if ($count > 0) {
			$p = min($p, ceil($count / $limit));
			
			$offset = ($p - 1) * $limit;
			$order_list = M('Order')->getActivityOrderList(6, $tuan_id, $team_id, $limit, $offset, false, 'ALL');
			$order_list = $order_list['order_list'];
			
			$team_id_arr = array();
			foreach ($order_list as &$order) {
				$return_product = D('Return_product')->where(array('order_id' => $order['order_id']))->find();
				$order['return_quantity'] = $return_product['pro_num'];
				$order['return_product_id'] = $return_product['order_product_id'];
				
				$team_id_arr[$order['data_item_id']] = $order['data_item_id'];
			}
			
			// 查找团长
			if (!empty($team_id_arr)) {
				$tuan_team_list = D('Tuan_team AS tt')->join('User AS u ON u.uid = tt.uid')->where("tt.team_id in (" . join(',', $team_id_arr) . ")")->field('tt.team_id, u.nickname')->select();
				$nickname_arr = array();
				foreach ($tuan_team_list as $tuan_team) {
					$nickname_arr[$tuan_team['team_id']] = $tuan_team['nickname'] ? $tuan_team['nickname'] : '匿名';
				}
				$this->assign('nickname_arr', $nickname_arr);
			}
			
			import('source.class.user_page');
			$page = new Page($count, $limit, $p);
			$this->assign('pages', $page->show());
		}
		
		$this->assign('team_id', $team_id);
		$this->assign('tuan', $tuan);
		$this->assign('status_arr', M('Order')->status(-1));
		$this->assign('tuan_id', $tuan_id);
		$this->assign('order_list', $order_list);
	}
	
	private function _team() {
		$store_id = $this->store_session['store_id'];
		$tuan_id = $_POST['tuan_id'];
		$page = max(1, $_POST['p']);
		$limit = 10;
		
		$tuan = D('Tuan')->where(array('id' => $tuan_id, 'store_id' => $store_id, 'delete_flg' => 0))->find();
		if (empty($tuan)) {
			pigcms_tips('未找相应的团购');
		}
		
		$count = D('Tuan_team')->where(array('tuan_id' => $tuan_id, 'pay_status' => 1))->count('team_id');
		
		$team_list = array();
		$tuan_config_list = array();
		$tuan_config_arr = array();
		if ($count > 0) {
			$tuan_config_list_tmp = D('Tuan_config')->where(array('tuan_id' => $tuan_id))->order('discount DESC')->select();
			foreach ($tuan_config_list_tmp as $key => $tuan_config) {
				$tuan_config_list[$tuan_config['id']] = $tuan_config;
				$tuan_config_arr[$tuan_config['id']] = $key + 1;
			}
			
			$page = min($page, ceil($count / $limit));
			$offset = ($page - 1) * $limit;
			
			$tuan_team_list = D('Tuan_team AS tt')->join('User AS u ON tt.uid = u.uid')->field('tt.*, u.nickname')->where("tt.tuan_id = '" . $tuan_id . "' AND tt.pay_status = 1")->order('tt.team_id DESC')->limit($offset . ', ' . $limit)->select();
			foreach ($tuan_team_list as &$tuan_team) {
				$tuan_team['number'] = D('Order')->where(array('store_id' => $store_id, 'type' => 6, 'status' => array('in', array(2, 3, 4, 7)), 'data_id' => $tuan_id, 'data_item_id' => $tuan_team['team_id']))->sum('pro_num');
			}
			
			if ($count > $limit) {
				import('source.class.user_page');
				$page = new Page($count, $limit, $page);
				$this->assign('pages', $page->show());
			}
		}
		
		$this->assign('tuan', $tuan);
		$this->assign('tuan_team_list', $tuan_team_list);
		$this->assign('tuan_config_list', $tuan_config_list);
		$this->assign('tuan_config_arr', $tuan_config_arr);
	}
}