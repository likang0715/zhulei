<?php
/**
 * 降价拍活动
 */
class cutprice_controller extends base_controller {
	// 加载
	public function load() {
		$action = strtolower(trim($_POST['page']));
		if (empty($action)) pigcms_tips('非法访问！', 'none');
	
		switch ($action) {
			case 'cutprice_list' :
				$this->_cutprice_list();
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
			case 'create' :
				$this->_create();
				break;
			default:
				break;
		}
		//exit($action);
		$this->display($_POST['page']);
	}
	
	// 降价拍列表
	function cutprice_index(){
		$this->display();
	}
	
	private function _cutprice_list(){
		$type = $_REQUEST['type'];
		$p = max(1,(int)$_REQUEST['p']);
		$keyword = $_REQUEST['keyword'];
		$type_arr = array('future', 'on', 'end', 'all');
		if (!in_array($type, $type_arr)) {
			$type = 'all';
		}
		
		//$where['state'] = 0;
		$where['store_id'] = $_SESSION['store']['store_id'];
		//$where['endtime'] = array('>',time());
		$order_by_field = 'pigcms_id desc';
		if (!empty($keyword)) {
			$where['active_name'] = array('like', '%' . $keyword . '%');
		}
		$time = time();
		if ($type == 'future') {
			$where['starttime'] = array('>', $time);
		} else if ($type == 'on') {
			$where['state'] = 0;
			$where['starttime'] = array('<', $time);
			$where['endtime'] = array('>', $time);
		} else if ($type == 'end') {
			$where = " store_id = '" . $_SESSION['store']['store_id'] . "' AND (`endtime` < '" . $time . "' OR `state` = '2')";
		}
		$count = D('Cutprice')->field('count(1) as count')->where($where)->find();
		import('source.class.user_page');
		$page = new Page($count['count'], 10,$p);
		
		$cutprice_list = D('Cutprice')->where($where)->order($order_by_field)->limit($page->firstRow.','.$page->listRows)->select();
		// 关联的商品
		if($cutprice_list){
			foreach($cutprice_list as $key => $item){
				$cutprice_list[$key]['product'] = D('Product')->where(array('product_id'=>$item['product_id']))->find();
				// 活动商品销量
				$cutprice_list[$key]['sales'] = 0;
				$cutprice_order_record = D('Cutprice_record')->where(array('cutprice_id'=>$item['pigcms_id']))->select();
				if(!$cutprice_order_record){
					continue;
				}
				$order_ids = array();
				foreach($cutprice_order_record as $record){
					if(!in_array($record['order_id'], $order_ids)){
						$order_ids[] = $record['order_id'];
					}
				}
				$where_order['type'] = 55;
				$where_order['status'] = array('>',1);
				$where_order['store_id'] = $item['store_id'];
				$where_order['order_id'] = array('in',$order_ids);
				$order_list = D('Order')->where($where_order)->select();
				foreach($order_list as $order){
					$cutprice_list[$key]['sales'] += $order['pro_num'];
				}
			}
		}
		$this->assign('keyword', $keyword);
		$this->assign('type', $type);
		$this->assign('pages', $page->show());
		$this->assign('cutprice_list',$cutprice_list);
	}
	
	// 显示添加页
	public function _create () {
		$group_list = M('Product_group')->get_all_list($this->store_session['store_id']);
		$this->assign('group_list', $group_list);
	}
	
	// 编辑降价拍活动
	public function _edit()
	{	
		$store_id = $_SESSION['store']['store_id'];
		$active_id = (int)$_POST['id'];
		$cutprice = D('Cutprice')->where(array('pigcms_id'=>$active_id, 'store_id'=>$store_id))->find();
		if (empty($cutprice)) {
			exit('参数错误');
		}
		$product = D("Product")->where(array('product_id'=>$cutprice['product_id']))->field('`product_id`, `name`,`image`')->find();
		$product['image'] = getAttachmentUrl($product['image']);
		$product['url'] = option('config.wap_site_url') . '/good.php?id=' . $product['product_id'];

		$group_list = M('Product_group')->get_all_list($store_id);
		$this->assign('group_list', $group_list);
		$this->assign("product", $product);
		$this->assign("cutprice", $cutprice);
	}
	
	// 保存降价拍活动
	public function save(){
		$data = $_POST['data'];
		if($data['active_name']==''){
			json_return(1001,'请先填写活动名称');
		}
		if($data['product_id']<=0){
			json_return(1001,'请先选择商品');
		}
		if($data['startprice']<=0||$data['stopprice']<=0||$data['original']<=0){
			json_return(1001,'价格不允许为零');
		}
		if($data['startprice'] > $data['original']){
			json_return(1001,'起拍价不能低于最低价，不能高于原价');
		}
		if($data['stopprice']>$data['startprice']){
			json_return(1001,'最低价不能高于起拍价');
		}
		$data['starttime'] = strtotime(trim($data['starttime']));
		$data['endtime'] = strtotime(trim($data['endtime']));
		if($data['starttime'] <=0||$data['endtime']<=0){
			json_return(1001,'请选择开始和结束时间');
		}
		if($data['starttime']>=$data['endtime']){
			json_return(1001,'开始时间不能小于结束时间');
		}
		if($data['cuttime']<=0 || $data['cutprice']<=0){
			json_return(1001,'请填写降价时间间隔和降价幅度');
		}
		if((int)$data['inventory']<=0){
			json_return(1001,'请填写参加活动的商品数量');
		}
		// 参加活动的商品数量不能大于商品的库存
		$product_info = D('Product')->where(array('product_id'=>$data['product_id']))->field('product_id,quantity,price')->find();
		if($data['sku_id']){
			$product_info = D('Product_sku')->where(array('product_id'=>$data['product_id'],'sku_id'=>$data['sku_id']))->field('sku_id,product_id,quantity')->find();
		}
		if($data['inventory'] > $product_info['quantity']){
			json_return(1001,'参加活动的商品数量不能大于库存量');
		}
		$data['store_id'] = $_SESSION['store']['store_id'];
		$data['addtime'] = time();
		$res = D('Cutprice')->data($data)->add();
		if(!$res){
			json_return(1001,'保存失败');
		}
		json_return(0,'保存成功');
	}
	
	// 使失效
	public function disabled() {
		$id = (int)$_GET['id'];
		if (!$id) {
			json_return(1001, '缺少最基本的参数ID');
		}
		// 找到对应的活动
		$cutprice = D('Cutprice')->where(array('store_id'=>$_SESSION['store']['store_id'],'pigcms_id'=>$id))->find();
		if (!$cutprice) {
			json_return(1001, '未找到对应的活动');
		}
		$data = array();
		$data['state'] = 1;	// 失效
		D('Cutprice')->where(array('pigcms_id'=>$id))->data($data)->save();
		json_return(0, '操作完成');
	}
	
	// 删除
	public function delete() {
		$id = (int)$_GET['id'];
		if (!$id) {
			json_return(1001, '缺少最基本的参数ID');
		}
		// 找到对应的活动
		$cutprice = D('Cutprice')->where(array('store_id'=>$_SESSION['store']['store_id'],'pigcms_id'=>$id))->find();
		if (!$cutprice) {
			json_return(1001, '未找到对应的活动');
		}
		if(!in_array($cutprice['state'],array(1,2)) && $cutprice['endtime']>time()){
			json_return(1001,'活动失效或结束后才可以删除');
		}
		D('Cutprice')->where(array('pigcms_id'=>$id))->delete();
		json_return(0, '操作完成');
	}
	
	// 订单
	public function _order(){
		$id = (int)$_POST['id'];
		if (!$id) {
			exit('缺少最基本的参数ID');
		}
		// 拉取订单列表
		$cutprice = D('Cutprice')->where(array('pigcms_id'=>$id))->find();
		if(!$cutprice){
			exit('未找到对应活动');
		}
		
		$cutprice_order_record = D('Cutprice_record')->where(array('cutprice_id'=>$cutprice['pigcms_id']))->select();
		if(!$cutprice_order_record){
			exit('还没有相关订单数据');
		}
		$product_order_ids = array();
		foreach($cutprice_order_record as $item){
			if(!in_array($item['order_id'], $product_order_ids)){
				$product_order_ids[] = $item['order_id'];
			}
		}
		
		$where_product['order_id'] = array('in',$product_order_ids);
		if($cutprice['sku_id']){
			$where_product['sku_id'] = $cutprice['sku_id'];
			$order_product_list = D('Order_product')->field('order_id')->where($where_product)->select();
		}else{
			$where_product['product_id'] = $cutprice['product_id'];
			$order_product_list = D('Order_product')->field('order_id')->where($where_product)->select();
		}
		if(!$order_product_list){
			exit('还没有相关订单数据');
		}
		$order_ids = array();
		foreach($order_product_list as $order_product){
			if(!in_array($order_product['order_id'],$order_ids)){
				$order_ids[] = $order_product['order_id'];
			}
		}
		$where = array();
		$where['type'] = 55;
		$where['status'] = array('>',1);
		$where['order_id'] = array('in',$order_ids);
		$order_list = D('Order')->where($where)->select();
		$this->assign('order_list',$order_list);
	}
}