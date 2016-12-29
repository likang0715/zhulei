<?php
/**
 * 维权控制器
 */
class rights_controller extends base_controller{
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
		
		if (!in_array($order['status'], array(2, 3, 4, 7))) {
			json_return(1000, '订单状态错误');
		}
		
		$order_product = D('')->table('Order_product AS op')->join('Product AS p ON p.product_id = op.product_id', 'left')->where("op.pigcms_id = '" . $pigcms_id . "'")->find();
		
		if (empty($order_product)) {
			json_return(1000, '未找到要维权的产品');
		}
		
		if ($order_product['rights_status'] == 2) {
			json_return(1000, '此产品已经申请维权了');
		}
		
		$type_arr = M('Rights')->rightsType();
		// 根据退货数量，判断是否可以退货
		$rights_number = M('Rights_product')->rightsNumber($order['order_id'], $pigcms_id);
		
		$return_order = array();
		$return_order['name'] = $order_product['name'];
		$return_order['pro_price'] = $order_product['pro_price'];
		$return_order['pro_num'] = $order_product['pro_num'];
		$return_order['order_no_txt'] = option('config.orderid_prefix') . $order['order_no'];
		$return_order['add_time'] = $order['add_time'];
		
		$rights_type_arr = array();
		foreach ($type_arr as $key => $type) {
			$tmp = array();
			$tmp['type_id'] = $key;
			$tmp['name'] = $type;
			$rights_type_arr[] = $tmp;
		}
		
		$return = array();
		$return['order'] = $return_order;
		$return['type_arr'] = $rights_type_arr;
		$return['rights_number'] = $rights_number;
		
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
		
		if (empty($order_no) || empty($pigcms_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		if (empty($number)) {
			json_return(1000, '请至少维权一件商品');
		}
		
		if (strlen($content) == 0) {
			json_return(1000, '请填写维权说明');
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
		
		if (!in_array($order['status'], array(2, 3, 4, 7))) {
			json_return(1000, '订单状态错误');
		}
		
		$order_product = D('')->table('Order_product AS op')->join('Product AS p ON p.product_id = op.product_id', 'left')->where("op.pigcms_id = '" . $pigcms_id . "'")->find();
		if (empty($order_product)) {
			json_return(1000, '未找到要维权的产品');
		}
		
		if ($order_product['rights_status'] == 2) {
			json_return(1000, '此产品已经申请维权了');
		}
		
		if (!in_array($type, array(1, 2, 3))) {
			$type = 3;
		}
		
		// 根据退货数量，判断是否可以退货
		$rights_number = M('Rights_product')->rightsNumber($order['order_id'], $pigcms_id);
		if ($order_product['pro_num'] < $rights_number + $number) {
			json_return(1000, '维权数量超出购买数量');
		}
		
		import('source.class.RightsOrder');
		$data = array();
		$data['pigcms_id'] = $pigcms_id;
		$data['type'] = $type;
		$data['phone'] = $phone;
		$data['content'] = $content;
		$data['images'] = $image_list;
		$data['number'] = $number;
		$result = RightsOrder::apply($order, $data);
		
		if ($result) {
			$return = array();
			$return['message'] = '维权申请提交成功，请处理';
			$return['rights_id'] = $result;
			json_return(0, $return);
		} else {
			json_return(1000, '维权申请失败，请重试');
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
		
		$rights = array();
		if (!empty($id)) {
			$rights = M('Rights')->getById($id);
		} else {
			$order_no = trim($order_no, option('config.orderid_prefix'));
			$where = "r.order_no = '" . $order_no . "' AND rp.order_product_id = '" . $pigcms_id . "'";
			$rights_list = M('Rights')->getList($where);
		
			if ($rights_list) {
				$rights = $rights_list[0];
			}
		}
		
		if (empty($rights)) {
			json_return(1000, '未找到相应的维权！');
		}
		
		if ($rights['uid'] != $this->user['uid']) {
			json_return(1000, '请查看自己的维权申请！');
		}
		
		$rights['rights_id'] = $rights['id'];
		unset($rights['id']);
		$rights['sku_data'] = unserialize($rights['sku_data']);
		
		$json_return = array();
		$json_return['rights'] = $rights;
		
		json_return(0, $json_return);
	}

	// 维权列表
	public function all() {
		$store_id = $_REQUEST['store_id'];
		$page = max(1, $_REQUEST['page']);
		$limit = 5;
		$offset = ($page - 1) * $limit;
		
		$where_sql = "r.uid = '" . $this->user['uid'] . "' AND r.user_rights_id = 0";
		if ($store_id) {
			$where_sql .= " AND r.store_id = '" . $store_id . "'";
		}
		$rights_list = M('Rights')->getList($where_sql, $limit, $offset);
		foreach ($rights_list as &$rights) {
			$rights['rights_id'] = $rights['id'];
			$rights['sku_data'] = unserialize($rights['sku_data']);
			unset($rights['id']);
		}
		
		$return['rights_list'] = $rights_list;
		$return['next_page'] = true;
		if (count($rights_list) < $limit) {
			$return['next_page'] = false;
		}
		
		json_return(0, $return);
	}
}
