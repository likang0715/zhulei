<?php
/**
 * 退货控制器
 */
class return_controller extends base_controller{
	// 退货申请
	public function apply() {
		$order_no = $_REQUEST['order_no'];
		$pigcms_id = $_REQUEST['pigcms_id'];
		
		if (empty($order_no) || empty($pigcms_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		// 只能查看自己的订单
		$order_model = M('Order');
		$order = $order_model->find($order_no);
		
		if (empty($order)) {
			json_return(1000, '未找到相应的订单');
		}
		
		if ($order['uid'] != $this->user['uid']) {
			json_return(1000, '您无权查看此订单');
		}
		
		if (($order['status'] != 7 && $order['status'] != 2) || $order['is_offline'] == 1) {
			json_return(1000, '此订单状态不能退货');
		}
		
		$order_product = D('')->table('Order_product AS op')->join('Product AS p ON p.product_id = op.product_id', 'left')->field('p.name, op.pro_price, op.pro_num, op.return_status')->where("op.pigcms_id = '" . $pigcms_id . "'")->find();
		
		if (empty($order_product)) {
			json_return(1000, '未找到要退货的产品');
		}
		
		if ($order_product['return_status'] == 2) {
			json_encode(array('status' => false, 'msg' => '此产品已经申请退货了'));
		}
		
		$order_product['order_no_txt'] = option('config.orderid_prefix') . $order['order_no'];
		
		$type_arr = M('Return')->returnType();
		
		// 根据退货数量，判断是否可以退货
		$return_number = M('Return_product')->returnNumber($order['order_id'], $pigcms_id);
		
		$return_order = array();
		$return_order['name'] = $order_product['name'];
		$return_order['pro_price'] = $order_product['pro_price'];
		$return_order['pro_num'] = $order_product['pro_num'];
		$return_order['order_no_txt'] = option('config.orderid_prefix') . $order['order_no'];
		$return_order['add_time'] = $order['add_time'];
		
		$return_type_arr = array();
		foreach ($type_arr as $key => $type) {
			$tmp = array();
			$tmp['type_id'] = $key;
			$tmp['name'] = $type;
			$return_type_arr[] = $tmp;
		}
		
		$return = array();
		$return['order'] = $return_order;
		$return['type_arr'] = $return_type_arr;
		$return['return_number'] = $return_number;
		
		json_return(0, $return);
	}
	
	// 退货保存
	public function save() {
		$order_no = $_REQUEST['order_no'];
		$pigcms_id = $_REQUEST['pigcms_id'];
		$type = $_REQUEST['type'];
		$phone = $_REQUEST['phone'];
		$content = trim($_REQUEST['content']);
		$image_list = $_REQUEST['images'];
		$number = max(0, $_REQUEST['number'] + 0);
		
		if (!in_array($type, array(1, 2, 3, 4, 5))) {
			$type = 5;
		}
		
		if (empty($order_no) || empty($pigcms_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		if (empty($number)) {
			json_return(1000, '请至少退一件商品');
		}
		
		if (strlen($content) == 0) {
			json_return(1000, '请填写退货说明');
		}
		
		// 只能查看自己的订单
		$order_model = M('Order');
		$order = $order_model->find($order_no);
		
		if (empty($order)) {
			json_return(1000, '未找到相应的订单');
		}
		
		if ($order['uid'] != $this->user['uid']) {
			json_return(1000, '您无权查看此订单');
		}
		
		if (($order['status'] != 7 && $order['status'] != 2) || $order['is_offline'] == 1) {
			json_return(1000, '此订单状态不能退货');
		}
		
		$order_product = D('')->table('Order_product AS op')->join('Product AS p ON p.product_id = op.product_id', 'left')->field('p.name, op.pro_num, op.pro_price, return_status')->where("op.pigcms_id = '" . $pigcms_id . "'")->find();
		
		if (empty($order_product)) {
			json_return(1000, '未找到要退货的产品');
		}
		
		if ($order_product['return_status'] == 2) {
			json_return(1000, '此产品已经申请退货了');
		}
		
		// 根据退货数量，判断是否可以退货
		$return_number = M('Return_product')->returnNumber($order['order_id'], $pigcms_id);
		if ($order_product['pro_num'] < $return_number + $number) {
			json_return(1000, '退货数量超出购买数量');
		}
		
		import('source.class.ReturnOrder');
		$data = array();
		$data['pigcms_id'] = $pigcms_id;
		$data['type'] = $type;
		$data['phone'] = $phone;
		$data['content'] = $content;
		$data['images'] = $image_list;
		$data['number'] = $number;
		
		$result = ReturnOrder::apply($order, $data);
		if ($result) {
			//短信/通知 提醒 => 退货申请提醒通知
			import('source.class.ShopNotice');
			ShopNotice::ReturnApply($this->user['uid'], $order_product, $order, $pigcms_id, $result);
			
			$return = array();
			$return['message'] = '退货申请提交成功，请等待商家处理';
			$return['return_id'] = $result;
			json_return(0, $return);
		} else {
			json_return(1000, '退货申请失败，请重试');
		}
	}
	
	// 退货详情
	public function detail() {
		$id = $_REQUEST['id'];
		$order_no = $_REQUEST['order_no'];
		$pigcms_id = $_REQUEST['pigcms_id'];
		if (empty($id) && (empty($order_no) || empty($pigcms_id))) {
			json_return(1000, '缺少参数');
		}
		
		$return = array();
		if (!empty($id)) {
			$return = M('Return')->getById($id);
			
			$where = "r.order_no = '" . $return['order_no'] . "' AND rp.order_product_id = '" . $return['order_product_id'] . "' AND r.id != '" . $return['id'] . "'";
			$return_list = M('Return')->getList($where);
		} else {
			$order_no = trim($order_no, option('config.orderid_prefix'));
			$where = "r.order_no = '" . $order_no . "' AND rp.order_product_id = '" . $pigcms_id . "'";
			$return_list = M('Return')->getList($where);
			
			if ($return_list) {
				$return = $return_list[0];
				unset($return_list[0]);
			}
		}
		
		if (empty($return)) {
			json_return(1000, '未找到相应的退货');
		}
		
		if ($return['uid'] != $this->user['uid']) {
			json_return(1000, '请查看自己的退货申请！');
		}
		
		// 商品规格处理
		$return['sku_data'] = unserialize($return['sku_data']);
		if (empty($return['sku_data'])) {
			$return['sku_data'] = array();
		}
		
		$express_list = array();
		if ($return['status'] == 3) {
			$express_list = D('Express')->select();
		}
		
		$store_id = $return['store_id'];
		if (!empty($_GET['store_id'])) {
			$tmp_store_id = intval(trim($_GET['store_id']));
		} else {
			$tmp_store_id = $store_id;
		}
		
		$return['return_id'] = $return['id'];
		unset($return['id']);
		
		$json_return_list = array();
		foreach ($return_list as $tmp_return) {
			$tmp = array();
			$tmp['return_id'] = $tmp_return['id'];
			$tmp['dateline'] = $tmp_return['dateline'];
			$tmp['status_txt'] = $tmp_return['status_txt'];
			
			$json_return_list[] = $tmp;
		}
		
		$json_return = array();
		$json_return['return_detail'] = $return;
		$json_return['return_list'] = $json_return_list;
		if (!empty($express_list)) {
			$json_return['express_lit'] = $express_list;
		}
		
		json_return(0, $json_return);
	}

	// 维权列表
	public function all() {
		$store_id = $_REQUEST['store_id'];
		$page = max(1, $_REQUEST['page']);
		$limit = 5;
		$offset = ($page - 1) * $limit;
		
		$where_sql = "r.uid = '" . $this->user['uid'] . "' AND r.user_return_id = 0";
		if ($store_id) {
			$where_sql .= " AND r.store_id = '" . $store_id . "'";
		}
		$return_list = M('Return')->getList($where_sql, $limit, $offset);
		
		$return['return_list'] = $return_list;
		$return['next_page'] = true;
		if (count($return_list) < $limit) {
			$return['next_page'] = false;
		}
		
		json_return(0, $return);
	}
	
	// 退货填写物流信息
	public function express() {
		$id = $_REQUEST['return_id'];
		$express_code = $_POST['express_code'];
		$express_no = $_POST['express_no'];
		
		if (empty($id) || empty($express_code) || empty($express_no)) {
			json_return(1000, '缺少参数');
		}
		$return = M('Return')->getById($id);
		
		if (empty($return)) {
			json_return(1000, '未找到相应的退货');
		}
		
		if ($return['uid'] != $this->user['uid']) {
			json_return(1000, '请操作自己的退货申请');
		}
		
		if ($return['status'] != 3) {
			json_return(1000, '退货状态不正确');
			exit;
		}
		
		$express = D('Express')->where("code = '" . $express_code . "'")->find();
		if (empty($express)) {
			json_return(1000, '未找到相应的快递公司');
		}
		
		
		$data = array();
		$data['status'] = 4;
		$data['shipping_method'] = 'express';
		$data['express_code'] = $express_code;
		$data['express_company'] = $express['name'];
		$data['express_no'] = $express_no;
		$result = D('Return')->where("user_return_id = '" . $id . "' or id = '" . $id . "'")->data($data)->save();
		
		if ($result) {
			json_return(0, '操作成功');
		} else {
			json_return(1001, '操作失败');
		}
	}
	
	// 取消退货
	public function cancel() {
		$id = $_REQUEST['return_id'];
		if (empty($id)) {
			json_return(1000, '缺少参数');
		}
		$return = M('Return')->getById($id);
		
		if (empty($return)) {
			json_return(1000, '未找到相应的退货');
		}
		
		if ($return['uid'] != $this->user['uid']) {
			json_return(1000, '请操作自己的退货申请');
		}
		
		if ($return['status'] >= 4) {
			json_return(1000, '不能取消退货申请');
		}
		
		$data = array();
		$data['status'] = 6;
		$data['user_cancel_dateline'] = time();
		$result = D('Return')->where("user_return_id = '" . $id . "' or id = '" . $id . "'")->data($data)->save();
		
		if ($result) {
			// 审核不通过更改订单产品表退货状态
			import('source.class.ReturnOrder');
			ReturnOrder::checkReturnStatus($return);
			
			json_return(0, '取消退货成功');
		} else {
			json_return(1000, '取消退货失败');
		}
	}
}
