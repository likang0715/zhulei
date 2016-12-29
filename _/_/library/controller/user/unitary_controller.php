<?php
class unitary_controller extends base_controller {
	
	public function __construct() {
		parent::__construct();
	}

	// 加载
	public function load () {
		$action = strtolower(trim($_POST['page']));
		if (empty($action)) pigcms_tips('非法访问！', 'none');
		
		switch ($action) {
			case 'unitary_list' :
				$this->_unitary_list();
				break;
			case 'edit' :
				$this->_edit();
				break;
			case 'order' :
				$this->_order();
			case 'create' :
				$this->_create();
			default:
				break;
		}
		
		$this->display($_POST['page']);
	}

	public function unitary_index () {
		$this->display();
	}
	
	public function _unitary_list () {

		$type = $_REQUEST['type'];
		$keyword = $_REQUEST['keyword'];

		$type_arr = array('future', 'on', 'end', 'all');
		if (!in_array($type, $type_arr)) {
			$type = 'all';
		}

		switch ($type) {
			case 'on':
				$where_unitary['state'] = 1;	//进行中
				break;
			case 'end':
				$where_unitary['state'] = 2;	//结束
				break;
			case 'future':	
				$where_unitary['state'] = 0;	//未开始
				break;
		}

		if (!empty($keyword)) {
			$where_unitary['name'] = array('like', '%' . $keyword . '%');
		}

		$unitary_database = D("Unitary");
		$lucknum_database = D("Unitary_lucknum");
		$product_database = D("Product");

		$where_unitary['store_id'] = $this->store_session['store_id'];
		$count = $unitary_database->where($where_unitary)->count('id');

		import('source.class.user_page');
		$page = new Page($count, 10);
		$show = $page->show();

		$unitary_list = $unitary_database->where($where_unitary)->order("addtime desc")->limit($page->firstRow.','.$page->listRows)->select();
		foreach ($unitary_list as $k => $vo) {

			$pay_count = M('Unitary')->getPayCount($vo['id']);
			$unitary_list[$k]['pay_count'] = $pay_count;

			// 关联商品
			$where_product = array(
				'product_id' => $vo['product_id'],
			);
			$product = $product_database->where($where_product)->field('`product_id`, `name`, `image`')->find();

			$unitary_list[$k]['product_name'] = $product['name'];
			$unitary_list[$k]['product_image'] = getAttachmentUrl($product['image']);
			$unitary_list[$k]['product_url'] = option('config.wap_site_url') . '/good.php?id=' . $product['product_id'];
		}

		$this->assign('type', $type);
		$this->assign("page", $show);
		$this->assign("keyword", $keyword);
		$this->assign("unitary_list", $unitary_list);

	}

	public function create () {

		if (IS_POST) {

			$unitary_database = D("Unitary");

			$data['name'] = trim($_POST['name']);
			$data['logopic'] = trim($_POST['logopic']);
			$data['price'] = ceil($_POST['price']) > 0 ? ceil($_POST['price']) : 0;
			$data['product_id'] = intval($_POST['product_id']);
			$data['sku_id'] = intval($_POST['sku_id']);
			$data['opentime'] = ceil($_POST['opentime']) > 0 ? ceil($_POST['opentime']) : 0;
			$data['item_price'] = ceil($_POST['item_price']) > 0 ? ceil($_POST['item_price']) : 0;

			$data['descript'] = $_POST['descript'];

			if (empty($data['name'])) {
				json_return(1000, '缺少活动名称');
			}

			if (empty($data['logopic'])) {
				json_return(1000, '缺少活动logo');
			}

			if ($data['price'] < 1) {
				json_return(1000, '商品价格必须为正整数');
			}

			if ($data['item_price'] < 1) {
				json_return(1000, '夺宝价格必须为正整数');
			}

			if ($data['item_price'] > $data['price']) {
				json_return(1000, '夺宝价格不能超过商品价格');
			}

			if (empty($data['product_id'])) {
				json_return(1000, '缺少关联产品');
			}

			if (empty($data['opentime'])) {
				$data['opentime'] = 0;
			}

			$data['store_id'] = $this->store_session['store_id'];
			$data['opentime'] = $data['opentime']*60;
			$data['total_num'] = ceil($data['price']/$data['item_price']);
			$data['addtime'] = time();
			$add_id = $unitary_database->data($data)->add();
			if ($add_id) {
				M('Unitary')->updateUnitaryCat($add_id, $data['product_id']);
				json_return(0, url('unitary:unitary_index'));
			} else {
				json_return(1, '添加失败，稍后再试');
			}

		}
	}

	// 显示添加页
	public function _create () {
		$group_list = M('Product_group')->get_all_list($this->store_session['store_id']);
		$this->assign('group_list', $group_list);
	}

	// 修改
	public function _edit () {

		$unitary_database = D("Unitary");

		$store_id = $this->store_session['store_id'];
		$unitary_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$unitary = $unitary_database->where(array('id'=>$unitary_id, 'store_id'=>$store_id))->find();

		if (empty($unitary)) {
			pigcms_tips("参数错误", "none");
		}

		$unitary['opentime'] = $unitary['opentime']/60;

		$product = D("Product")->where(array('product_id'=>$unitary['product_id']))->field('`product_id`, `name`, `image`')->find();
		$product['image'] = getAttachmentUrl($product['image']);
		$product['url'] = option('config.wap_site_url') . '/good.php?id=' . $product['product_id'];

		$group_list = M('Product_group')->get_all_list($this->store_session['store_id']);
		$this->assign('group_list', $group_list);
		$this->assign("product", $product);
		$this->assign("unitary", $unitary);

	}

	// 更新
	public function doupdate () {

		$unitary_database = D("Unitary");
		$where_unitary['id'] = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$where_unitary['store_id'] = $this->store_session['store_id'];

		$find_unitary = $unitary_database->where($where_unitary)->find();
		if (empty($find_unitary)) {
			pigcms_tips("无效操作", "none");
		}

		if ($find_unitary['state'] == 1) {
			pigcms_tips("活动中无法编辑", "none");
		}

		$unitary_database = D("Unitary");

		$data['name'] = trim($_POST['name']);
		$data['logopic'] = trim($_POST['logopic']);
		$data['price'] = ceil($_POST['price']) > 0 ? ceil($_POST['price']) : 0;
		$data['product_id'] = intval($_POST['product_id']);
		$data['sku_id'] = intval($_POST['sku_id']);
		$data['opentime'] = ceil($_POST['opentime']) > 0 ? ceil($_POST['opentime']) : 0;
		$data['item_price'] = ceil($_POST['item_price']) > 0 ? ceil($_POST['item_price']) : 0;

		$data['descript'] = $_POST['descript'];

		if (empty($data['name'])) {
			json_return(1000, '缺少活动名称');
		}

		if (empty($data['logopic'])) {
			json_return(1000, '缺少活动logo');
		}

		if ($data['price'] < 1) {
			json_return(1000, '商品价格必须为正整数');
		}

		if ($data['item_price'] < 1) {
			json_return(1000, '夺宝价格必须为正整数');
		}

		if ($data['item_price'] > $data['price']) {
			json_return(1000, '夺宝价格不能超过商品价格');
		}

		if (empty($data['product_id'])) {
			json_return(1000, '缺少关联产品');
		}

		if (empty($data['opentime'])) {
			$data['opentime'] = 0;
		}

		$data['opentime'] = $data['opentime']*60;
		$data['total_num'] = ceil($data['price']/$data['item_price']);

		$update_unitary = $unitary_database->where($where_unitary)->data($data)->save();
		if ($update_unitary) {
			M('Unitary')->updateUnitaryCat($find_unitary['id'], $data['product_id']);
			json_return(0, url('unitary:unitary_index'));
		} else {
			json_return(1, '请修改后再提交');
		}
	}

	// 参与者订单
	public function _order () {
		
		$user_database = D("User");
		$cart_database = D("Unitary_cart");
		$lucknum_database = D("Unitary_lucknum");
		$unitary_database = D("Unitary");

		$unitary_id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

		$where_unitary['id'] = $unitary_id;
		$where_unitary['store_id'] = $this->store_session['store_id'];

		$find_unitary = $unitary_database->where($where_unitary)->find();
		$this->assign("unitary", $find_unitary);
		$where_lucknum['store_id'] = $this->store_session['store_id'];
		$where_lucknum['unitary_id'] = $unitary_id;
		$count = $lucknum_database->where($where_lucknum)->count('id');

		import('source.class.user_page');
		$page = new Page($count, 20);
		$show = $page->show();

		$lucknum_list = $lucknum_database->where($where_lucknum)->order("state desc,addtime desc")->limit($page->firstRow.','.$page->listRows)->select();

		import('source.class.area');
		foreach($lucknum_list as $k => $vo){

			$find_user = $user_database->where(array('uid'=>$vo['uid']))->find();

			$lucknum_list[$k]['name'] = $find_user['nickname'];
			$lucknum_list[$k]['phone'] = $find_user['phone'];
			$lucknum_list[$k]['avatar'] = !empty($find_user['avatar']) ? $find_user['avatar'] : option('config.site_url').'/static/images/avatar.png';

			// $area_class = new area();

			// $address = array();
			// $address['province_txt'] = $area_class->get_name($find_address['province']);
			// $address['city_txt'] = $area_class->get_name($find_address['city']);
			// $address['area_txt'] = $area_class->get_name($find_address['area']);

			// $lucknum_list[$k]['address'] = $address['province_txt']." ".$address['city_txt']." ".$address['area_txt']." ".$where_address['address'];
			$lucknum_list[$k]['order'] = array();
			if ($vo['state'] == 1) {
				$find_order = D('Order')->where(array('type'=>51,'store_id'=>$this->store_session['store_id'], 'activity_id'=>$vo['unitary_id']))->find();
				$lucknum_list[$k]['order'] = $find_order;
			}
		}

		// dump($lucknum_list);exit;
		$this->assign("page", $show);
		$this->assign("lucknum_list", $lucknum_list);
	}

	// 操作
	public function operate () {

		$unitary_database = D("Unitary");
		$type = $_POST['type'];
		$where_unitary['id'] = isset($_POST['unitary_id']) ? intval($_POST['unitary_id']) : 0;
		$where_unitary['store_id'] = $this->store_session['store_id'];

		if (empty($where_unitary['id']) || empty($where_unitary['store_id'])) {
			json_return(1, '缺少参数');
			exit;
		}

		$find_unitary = $unitary_database->where($where_unitary)->find();

		switch($type){

			case 'del':

				$del_unitary = $unitary_database->where($where_unitary)->delete();
				if ($del_unitary > 0) {
					json_return(0, '操作成功');
				}

				break;

			case 'stop':

				$unitary_id = $_GET['unitaryid'];
				$save_unitary['state'] = 0;
				$update_unitary = $unitary_database->where($where_unitary)->data($save_unitary)->save();

				$m_unitary_cart = D("Unitary_cart");
				$where_unitary_cart['unitary_id'] = $unitary_id;
				$where_unitary_cart['state'] = 0;

				$del_cart = $m_unitary_cart->where($where_unitary_cart)->delete();	//清空该活动购物车

				if ($update_unitary > 0) {
					json_return(0, '操作成功');
				}

				break;

			case 'start':

				$save_unitary['state'] = 1;
				$update_unitary = $unitary_database->where($where_unitary)->data($save_unitary)->save();
				if ($update_unitary > 0) {
					json_return(0, '操作成功');
				}
				break;

		}

		json_return(1, '操作失败，稍后再试');
		exit;

	}

	// 夺宝活动参与记录
	public function order () {

		// $lucknum_database = M("Unitary_lucknum");
		// $unitary_database = M("Unitary");
		// $user_database = M("User");
		// $address_database = M("User_address");
		// $unitary_id = isset($_GET['unitaryid']) ? intval($_GET['unitaryid']) : 0;

		// $where_unitary['id'] = $unitary_id;
		// $where_unitary['store_id'] = $this->store_session['store_id'];
		// $find_unitary = $unitary_database->where($where_unitary)->find();
		// $this->assign("unitary", $find_unitary);

		// $where_lucknum['store_id'] = $this->store_session['store_id'];
		// $where_lucknum['unitary_id'] = $unitary_id;
		// $count = $lucknum_database->where($where_lucknum)->count();

		// $Page = new Page($count,20);
		// $show = $Page->show();
		// $lucknum_list = $lucknum_database->where($where_lucknum)->order("state desc,addtime desc")->limit($Page->firstRow.','.$Page->listRows)->select();
		// foreach ($lucknum_list as $k => $vo) {

		// 	$where_user['uid'] = $vo['uid'];
		// 	$find_user = $user_database->where($where_user)->find();

		// 	$where_address['store_id'] = $this->store_session['store_id'];
		// 	$where_address['uid'] = $vo['uid'];
		// 	$where_address['default'] = 1;
		// 	$unitary_address = $address_database->where($where_address)->find();

		// 	$lucknum_list[$k]['name'] = $find_user['name'];
		// 	$lucknum_list[$k]['phone'] = $find_user['phone'];
		// 	$lucknum_list[$k]['avatar'] = !empty($find_user['avatar']) ? getAttachmentUrl($find_user['avatar']) : getAttachmentUrl('images/touxiang.png', false);
		// 	$lucknum_list[$k]['address'] = $unitary_address;
		// }

		// $this->assign("page", $show);
		// $this->assign("lucknum_list", $lucknum_list);
		$this->display();
	}

	// 夺宝订单发货
	public function paifa () {

		$user_database = M("User");

		$lucknum_database = M("Unitary_lucknum");
		$unitary_database = M("Unitary");

		$where_lucknum['id'] = isset($_GET['lucknumid']) ? intval($_GET['lucknumid']) : 0;
		$where_lucknum['store_id'] = $this->user_session['store_id'];
		$find_lucknum = $lucknum_database->where($where_lucknum)->find();

		$where_unitary['token'] = $this->token;
		$where_unitary['id'] = $find_lucknum['unitary_id'];
		$find_unitary = $unitary_database->where($where_unitary)->find();

		$model = new templateNews();
		if ($find_lucknum['paifa'] == 1) {
			//$model->sendTempMsg('TM00820', array('href' => U('Unitary/goodswhere',array('token' => $this->token, 'unitaryid' => $find_lucknum['unitary_id'])), 'wecha_id' => $find_lucknum['wecha_id'], 'first' => '一元夺宝奖品发货通知', 'keynote1' => '商家取消发货', 'keynote2' => date("Y年m月d日H时i分s秒"), 'remark' => '您在一元夺宝中获得的【'.$find_unitary['name'].'】被取消发货'));
			$save_lucknum['paifa'] = 0;
		} elseif ($find_lucknum['paifa'] == 0) {
			// $model->sendTempMsg('OPENTM200565259', array('href' => $this->siteUrl.U('Wap/Unitary/goodswhere',array('token' => $this->token, 'unitaryid' => $find_lucknum['unitary_id'])), 'wecha_id' => $find_lucknum['wecha_id'], 'first' => '一元夺宝奖品发货通知', 'keyword1' => '恭喜您在一元夺宝中获得的【'.$find_unitary['name'].'】已发货', 'keyword2' => '无', 'keyword3' => '无', 'remark' => date("Y年m月d日H时i分s秒")));
			$save_lucknum['paifa'] = 1;
		}
		
		$update_lucknum = $lucknum_database->where($where_lucknum)->save($save_lucknum);
		if ($update_lucknum > 0) {
			$this->redirect("Unitary/data",array("token"=>$this->token,"unitaryid"=>$find_lucknum['unitary_id']));
		}

	}

}
?>