<?php
class substore_controller extends base_controller {

	public $store_id;

	public function __construct () {

		parent::__construct();
		if (empty($this->store_session)) {
			redirect(url('index:index'));
		}

		$this->store_id = $this->store_session['store_id'];
		$controller = MODULE_NAME;
		$action = ACTION_NAME;
		$exclude = array('load', 
				'store_config', 
				'store_config_edit', 
				'statistic', 
				'stock', 
				'store_order', 
				'courier',
				'physical_quantity_edit', 
				'package_list', 
				'courier_create', 
				'courier_update', 
				'courier_del', 
				'bind_qrcode', 
				'courier_package',
				'warn_stock',
			); //排除验证方法列表

		if ($this->user_session['type'] == 1) {     // 门店管理员
			if (!in_array($action, $exclude)) {
				header("Content-type: text/html;charset=utf-8");
				if (IS_AJAX) {
					if (IS_GET) {
						json_return(1, '您没有操作权限');
					} elseif (IS_POST) {
						json_return(1, '您没有操作权限');
					}
				} else if (IS_POST) {
					pigcms_tips('您没有操作权限！', 'none');
				} else {
					pigcms_tips('您没有操作权限！', 'none');
				}
			}
		}

		$this->assign("warn_stock", $this->warnStockCount());
	}

	// 门店库存报警检测
	private function warnStockCount () {
		$store_info = M('Store')->getStore($this->store_id);
		$physical_id = $this->user_session['item_store_id'];

		if ($store_info['warn_sp_quantity'] <= 0) {
			return 0;
		}

		if ($this->user_session['type'] == 0) {     //店主

			$spq_where = array(
				'store_id' => $this->store_id,
				'quantity' => array('<', $store_info['warn_sp_quantity']),
			);
			$warn_total = D("Store_physical_quantity")->where($spq_where)->count("pigcms_id");

		} elseif ($this->user_session['type'] == 1 && !empty($physical_id)) {   //门店管理员

			$spq_where = array(
				'store_id' => $this->store_id,
				'quantity' => array('<', $store_info['warn_sp_quantity']),
				'physical_id' => $physical_id,
			);
			$warn_total = D("Store_physical_quantity")->where($spq_where)->count("pigcms_id");
			
		}

		return $warn_total;
	}

	public function load () {
		$action = strtolower(trim($_POST['page']));
		if (empty($action)) {
			pigcms_tips('非法访问！', 'none');
		}

		switch ($action) {
			case 'list_content':            //门店管理
				$this->_list_content();
				break;
			case 'physical_edit_content':   //门店管理-编辑
				$this->_physical_edit_content();
				break;
			case 'list_admin_content':      //门店管理员-列表
				$this->_list_admin_content();
				break;
			case 'set_admin_content':       //门店管理员-新建
				$this->set_admin_content();
				break;
			case 'store_admin_edit':        //门店管理员-编辑
				$this->store_admin_edit();
				break;
			case 'assign_quantity':         //分配门店库存
				$this->_assign_quantity();
				break;
			case 'warn_stock_list':         //门店报警库存
				$this->_warn_stock_list();
				break;
			case 'quantity_warn':         //门店库存报警
				$this->_quantity_warn();
				break;
			case 'store_content':           //门店管理员-门店信息
				$this->_store_content();
				break;
			case 'stock_content':           //门店库存列表
				$this->_stock_goods_list();
				break;
			case 'package_content':           //门店包裹列表
				$this->_package_content();
				break;
			case 'statistic_line':           //门店销售统计 折线
				$this->_statistic_line();
				break;
			case 'statistic_percent':           //门店销售统计 饼状
				$this->_statistic_percent();
				break;
			case 'courier_list':           //配送员列表
				$this->_courier_list();
				break;
			case 'courier_create':         //配送员创建
				$this->_courier_create();
				break;
			case 'courier_edit':            //配送员编辑
				$this->_courier_edit();
				break;
			case 'wxbind_content':           //微信绑定
				$this->_wxbind_content();
				break;
			case 'courier_package_content':  //配送员包裹列表
				$this->_courier_package_content();
				break;
			default:
				break;
		}

		$this->display($_POST['page']);
	}

	/**
	 * 店主
	 */
	// 门店列表
	public function store_list () {
		$this->display();
	} 

	// 门店列表
	private function _list_content () {
		$store_physical = D('Store_physical')->where(array('store_id'=>$this->store_id))->select();
		$this->assign('store_physical', $store_physical);
	}

	// 门店编辑
	private function _physical_edit_content () {
		$pigcms_id = isset($_POST['pigcms_id']) ? intval($_POST['pigcms_id']) : 0;
		if (empty($pigcms_id)) {
			echo '缺少参数';
			exit;
		}

		$store_physical = D('Store_physical')->where(array('store_id'=>$this->store_id, 'pigcms_id'=>$pigcms_id))->find();
		if (empty($store_physical)) {
			echo '门店不存在或无权限！';
			exit;
		}
		
		$store_physical['images_arr'] = explode(',', $store_physical['images']);
		foreach ($store_physical['images_arr'] as &$physical_value) {
			$physical_value = getAttachmentUrl($physical_value);
		}

		$this->assign('store_physical', $store_physical);
	}

	// 门店添加
	public function physical_add () {
		if (IS_POST) {
			$data_store_physical['store_id'] = $this->store_id;
			$data_store_physical['name'] = $_POST['name'];
			$data_store_physical['phone1'] = $_POST['phone1'];
			$data_store_physical['phone2'] = $_POST['phone2'];
			$data_store_physical['province'] = $_POST['province'];
			$data_store_physical['city'] = $_POST['city'];
			$data_store_physical['county'] = $_POST['county'];
			$data_store_physical['address'] = $_POST['address'];
			$data_store_physical['long'] = $_POST['map_long'];
			$data_store_physical['lat'] = $_POST['map_lat'];
			$data_store_physical['last_time'] = $_SERVER['REQUEST_TIME'];
			
			if (is_array($_POST['images'])) {
				foreach($_POST['images'] as &$images_value){
					$images_value = getAttachment($images_value);
				}
				$data_store_physical['images'] = implode(',', $_POST['images']);
			} else {
				json_return(1, '门店照片不存在，添加失败');
			}
			
			$data_store_physical['business_hours'] = $_POST['business_hours'];
			$data_store_physical['description'] = $_POST['description'];
				
			$database_store_physical = D('Store_physical');
			if ($database_store_physical->data($data_store_physical)->add()) {
				D('Store')->where(array('store_id'=>$this->store_id))->setInc('physical_count');
				json_return(0, '添加成功');
			} else {
				json_return(1, '添加失败');
			}

		} else {
			json_return(1, '非法访问！');
		}
	}

	//门店编辑
	public function physical_edit () {
		if (IS_POST) {
			$condition_store_physical['pigcms_id'] = $_POST['pigcms_id'];   
			$condition_store_physical['store_id'] = $this->store_id;
			$data_store_physical['name'] = $_POST['name'];
			$data_store_physical['phone1'] = $_POST['phone1'];
			$data_store_physical['phone2'] = $_POST['phone2'];
			$data_store_physical['province'] = $_POST['province'];
			$data_store_physical['city'] = $_POST['city'];
			$data_store_physical['county'] = $_POST['county'];
			$data_store_physical['address'] = $_POST['address'];
			$data_store_physical['long'] = $_POST['map_long'];
			$data_store_physical['lat'] = $_POST['map_lat'];
			$data_store_physical['last_time'] = $_SERVER['REQUEST_TIME'];

			$store_physical_info = D('Store_physical')->where(array('pigcms_id'=>$condition_store_physical['pigcms_id'], 'store_id'=>$this->store_id))->find();
			if (empty($store_physical_info)) {
				json_return(1, '门店不存在或无操作权限，请重试');
			}

			if (is_array($_POST['images'])) {
				foreach($_POST['images'] as &$images_value){
					$images_value = getAttachment($images_value);
				}
				$data_store_physical['images'] = implode(',', $_POST['images']);
			} else {
				json_return(1, '门店照片不存在，修改失败');
			}
			
			$data_store_physical['images'] = implode(',', $_POST['images']);
			$data_store_physical['business_hours'] = $_POST['business_hours'];
			$data_store_physical['description'] = $_POST['description'];
				
			$database_store_physical = D('Store_physical');
			if ($database_store_physical->where($condition_store_physical)->data($data_store_physical)->save()) {
				json_return(0, '修改成功');
			} else {
				json_return(1, '修改失败');
			}

		} else {
			json_return(1, '非法访问！');
		}
	}

	//门店删除
	public function physical_del () {
		if (IS_POST) {
			$physical_id = isset($_POST['pigcms_id']) ? intval($_POST['pigcms_id']) : 0;
			$database_store_physical = D('Store_physical');
			$condition_store_physical['pigcms_id'] = $physical_id;
			$condition_store_physical['store_id']  = $this->store_id;

			if (empty($physical_id)) {
				json_return(2, '缺少参数，稍后再试');
			}

			$store_physical_info = D('Store_physical')->where(array('pigcms_id'=>$physical_id, 'store_id'=>$this->store_id))->find();
			if (empty($store_physical_info)) {
				json_return(1, '门店不存在或无操作权限，请重试');
			}

			$py_admin = D('User')->where(array('item_store_id'=>$physical_id))->find();
			if (!empty($py_admin)) {
				json_return(2, '该门店下有门店管理员，无法删除');
			}

			$py_courier = D('Store_physical_courier')->where(array('physical_id'=>$physical_id))->find();
			if (!empty($py_courier)) {
				json_return(2, '该门店下有配送员，无法删除');
			}

			$py_order_product = D('Order_product')->where(array('sp_id'=>$physical_id))->find();
			if (!empty($py_order_product)) {
				json_return(2, '该门店已关联订单商品，无法删除');
			}

			D('Store_physical_quantity')->where(array('physical_id'=>$physical_id))->delete();  //删关联库存
			if ($database_store_physical->where($condition_store_physical)->delete()) {
				json_return(0, '删除成功');
			} else {
				json_return(1, '删除失败');
			}

		} else {
			json_return(1, '非法访问！');
		}
	}

	// 门店管理员列表
	public function set_admin () {
		$store_physical = D('Store_physical')->where(array('store_id'=>$this->store_id))->select();
		$this->assign('store_physical', $store_physical);
		$this->display();
	}

	// 添加店铺管理员
	public function add_admin () {
		if (IS_POST) {
			$user_model = M('User');
			$rbac_model = M('Rbac_action');
			$data_user['nickname'] = $_POST['nickname'];
			$data_user['phone'] = $_POST['phone'];
			$data_user['password'] = md5($_POST['password']);
			$data_user['drp_store_id'] = $this->store_id; //用户所属店铺id
			$data_user['item_store_id'] = $_POST['item_store']; //用户管理门店id
			$data_user['type'] = 1; //管理员类型 0 店铺总管理员 1 门店管理员

			$rbacData['goods'] = !empty($_POST['goods']) ? $_POST['goods'] : array();
			$rbacData['order'] = !empty($_POST['order']) ? $_POST['order'] : array();
			$rbacData['trade'] = !empty($_POST['trade']) ? $_POST['trade'] : array();

			if ($user_model->checkUser(array('phone' => $data_user['phone']))) {
			   json_return(3, '此手机号已经注册了');
			}

			$userReturn = $user_model->add_user($data_user);

			if ($userReturn['err_code'] == 0) {

				foreach ($rbacData as $controller => $actionArr) {

					if (count($actionArr) > 0) {
						foreach ($actionArr as $val) {
							$tmp_data = array(
								'uid' => $userReturn['err_msg']['uid'],
								'action' => $val,
							);
							$rbac_model->add_rbac($tmp_data, $controller);
						}
					}

				}

				json_return(0, '添加成功');
			} else {

				json_return(1, '添加失败');
			}
		}

	}

	// 门店管理员列表
	private function _list_admin_content () {
		$store_admin_list = D('User')->where(array(
			'drp_store_id'=>$this->store_id,
			'type' => 1
		))->select();
		foreach ($store_admin_list as $admin) {
			$store_physical_name[$admin['uid']] = D('Store_physical')->where(array('pigcms_id'=>$admin['item_store_id']))->find();
		}

		$this->assign('store_admin_list', $store_admin_list);
		$this->assign('store_physical_name', $store_physical_name);
	}

	// 门店管理员添加页面
	private function set_admin_content () {
		$store_physical = D('Store_physical')->where(array('store_id'=>$this->store_id))->select();
		if (empty($store_physical)) {
			echo '请先添加门店！';
			exit;
		}

		$this->assign('store_physical', $store_physical);
	}

	// 门店管理员修改页面
	private function store_admin_edit () {
		$uid = intval($_POST['uid']);
		if (empty($uid)) {
			echo '缺少参数';
			exit;
		}

		$physicalUserStoreId = D('User')->where(array('uid'=>$uid))->field("drp_store_id")->find();
		$physicalUserStoreId = $physicalUserStoreId['drp_store_id'];
		if ($this->store_id != $physicalUserStoreId) {
			echo '非本店铺门店管理员，无操作权限';
			exit;
		}

		$goodsMethod = D('Rbac_action')->where(array(
			'uid'=>$uid,
		))->select();

		$userInfo= D('User')->where(array(
			'uid'=>$uid,
		))->find();

		$methodList = array();
		foreach ($goodsMethod as $method) {
			$methodList[$method['controller_id']][] = $method['action_id'];
		}

		$store_physical_name = D('Store_physical')->where(array('pigcms_id'=>$userInfo['item_store_id']))->find();
		$store_physical = D('Store_physical')->where(array('store_id'=>$this->store_id))->select();
		$this->assign('store_physical', $store_physical);
		$this->assign('userInfo', $userInfo);
		$this->assign('store_physical_name', $store_physical_name);
		$this->assign('methodList', $methodList);
	}

	// 门店管理员编辑
	public function store_edit () {
		if (IS_POST) {
			$user_model = M('User');
			$rbac_model = M('Rbac_action');

			$data_user['uid'] = $_POST['uid'];
			$data_user['nickname'] = $_POST['nickname'];
			$data_user['phone'] = $_POST['phone'];

			$data_user['drp_store_id'] = $this->store_id; //用户所属店铺id
			$data_user['item_store_id'] = $_POST['item_store']; //用户管理门店id
			$data_user['type'] = 1; //管理员类型 0 店铺总管理员 1 门店管理员

			$rbacData['goods'] = !empty($_POST['goods']) ? $_POST['goods'] : array();
			$rbacData['order'] = !empty($_POST['order']) ? $_POST['order'] : array();
			$rbacData['trade'] = !empty($_POST['trade']) ? $_POST['trade'] : array();

			$physicalUserStoreId = D('User')->where(array('uid'=>$data_user['uid']))->field("drp_store_id")->find();
			$physicalUserStoreId = $physicalUserStoreId['drp_store_id'];
			if ($this->store_id != $physicalUserStoreId) {
				json_return(1, '非本店铺门店管理员，无操作权限');
			}

			// 去重
			$whereQ = "`phone` = ".$data_user['phone']." AND `uid` != ".$data_user['uid'];
			if (D('User')->where($whereQ)->find()) {
			   json_return(3, '此手机号已经注册了');
			}

			$user = $user_model->edit_user($data_user);

			if($user['err_code'] == 0){

				foreach ($rbacData as $controller => $actionArr) {

					$delCondition = array(
							'uid' => $data_user['uid'],
							'controller_id' => $controller,
						);
					$rbac_model->delete_action($delCondition);

					if (count($actionArr) > 0) {
						foreach ($actionArr as $val) {
							$tmp_data = array(
								'uid' => $data_user['uid'],
								'action' => $val,
							);
							$rbac_model->add_rbac($tmp_data, $controller);
						}
					}

				}

				json_return(0, '修改成功');
			}else{
				json_return(1, '修改失败');
			}
		}
	}

	// 门店管理员删除
	public function store_admin_del () {
		if (IS_POST) {
			$user = D('User');
			$uid = intval($_POST['uid']);
			$store_id = $this->store_id;
			$type = $this->user_session['type'];

			if (empty($uid)) {
				json_return(1, '缺少参数');
			}

			$physicalUserStoreId = D('User')->where(array('uid'=>$uid))->field("drp_store_id")->find();
			$physicalUserStoreId = $physicalUserStoreId['drp_store_id'];
			if ($store_id != $physicalUserStoreId) {
				json_return(1, '非本店铺门店管理员，无操作权限');
			}

			$condition_store_admin = array(
				'uid' => $uid,
				'type' => 1,
			);

			if ($user->where($condition_store_admin)->delete()) {
				json_return(0, '删除成功');
			} else {
				json_return(1, '删除失败');
			}
			
		} else {
			json_return(1, '非法访问！');
		}
	}

	// 商品库存列表
	public function set_stock () {
		$this->display();
	} 

	//分配库存
	private function _assign_quantity () {

		$keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
		$group_id = isset($_POST['group_id']) ? intval($_POST['group_id']) : 0;
		$physical_id = isset($_POST['physical_id']) ? intval($_POST['physical_id']) : 0;
		$order_by_field = isset($_POST['orderbyfield']) ? $_POST['orderbyfield'] : '';
		$order_by_method = isset($_POST['orderbymethod']) ? $_POST['orderbymethod'] : '';

		$store_id = $this->store_id;

		$where = array(
				'store_id' => $store_id,
				'quantity' => array('>', 0),
				'soldout' => 0,
				'wholesale_product_id' => 0,
			);
		if ($keyword) {
			$where['name'] = array('like', '%' . $keyword . '%');
		}

		if ($group_id) {
			$products = M('Product_to_group')->getProducts($group_id);
			$product_ids = array();
			if (!empty($products)) {
				foreach ($products as $item) {
					$product_ids[] = $item['product_id'];
				}
			}
			$where['product_id'] = array('in', $product_ids);
		}

		$productResult = M('Store_physical_quantity')->getStockProduct($where, $order_by_field, $order_by_method, $store_id);
		$page = $productResult['page'];
		$products = $productResult['data'];

		$store_physical = D('Store_physical')->where(array('store_id'=>$store_id))->select();
		$product_groups = M('Product_group')->get_all_list($store_id);

		$this->assign('store_physical', $store_physical);
		$this->assign('product_groups', $product_groups);
		$this->assign('product_groups_json', json_encode($product_groups));
		$this->assign('physical_id', $physical_id);
		$this->assign('page', $page->show());
		$this->assign('products', $products);
	}

	// 门店库存报警
	public function _quantity_warn () {
		$store_info = M('Store')->getStore($this->store_id);
		$this->assign('store_info', $store_info);
	}

	// 设置门店库存报警
	public function set_warn_quantity () {
		if (IS_POST) {
			$quantity = (isset($_POST['warn_sp_quantity']) && $_POST['warn_sp_quantity'] > 0) ? intval($_POST['warn_sp_quantity']) : 0;
			D('Store')->where(array('store_id'=>$this->store_id))->data(array('warn_sp_quantity'=>$quantity))->save();

			json_return(0, '修改成功！');
		} else {
			json_return(1, '非法访问！');
		}
	}

	//ajax 弹层获取门店列表
	public function assign_quantity_json () {
		$data = array();
		$product_id = $data['product_id'] = !empty($_POST['product_id']) ? intval(trim($_POST['product_id'])) : 0;
		$sku_id = $data['sku_id'] = !empty($_POST['sku_id']) ? intval(trim($_POST['sku_id'])) : 0;

		if (empty($product_id) && empty($sku_id)) {
			json_return(1, '缺少参数，稍后再试');
		}

		$where = array('product_id'=>$product_id);
		if (!empty($sku_id)) {
			$where = array('sku_id'=>$sku_id);
		}

		$store_physical = D('Store_physical')->where(array('store_id'=>$this->store_id))->select();

		if (empty($store_physical)) {
			json_return(1, '请先添加门店');
		}

		$data['store_physical'] = $store_physical;

		//被分配的商品
		if (!empty($sku_id)) {
			$data['product_info'] = D('Product_sku')->where($where)->find();
		} else {
			$data['product_info'] = M('Product')->get($where);
		}

		//已经分配的
		$data['physical_quantity'] = M('Store_physical_quantity')->getQuantityByPid($where);
		
		echo json_encode($data, true);
		exit;
	}

	// 保存分配库存
	public function quantity_set () {

		$store_id = $this->store_id;

		$sku_id = !empty($_POST['sku_id']) ? intval(trim($_POST['sku_id'])) : 0;
		$product_id = !empty($_POST['product_id']) ? intval(trim($_POST['product_id'])) : 0;

		$nums = !empty($_POST['nums']) ? $_POST['nums'] : array();
		$physical_ids_new = !empty($_POST['physical_ids']) ? $_POST['physical_ids'] : array();

		if (empty($nums) || empty($physical_ids_new) || count($nums) != count($physical_ids_new)) {
			json_return(0, '数据错误，稍后再试');
		}

		$quantity_total = array_sum($nums);
		// dump($total);exit;

		if (!empty($sku_id)) {
			$where = array('sku_id'=>$sku_id);
			$product_tmp = D('Product_sku')->where($where)->find();
		} else {
			$where = array('product_id'=>$product_id);
			$product_tmp = D('Product')->where($where)->find();
		}

		// 该产品总库存
		if (empty($product_tmp)) {
			json_return(0, '参数错误！');
		}

		if ($product_tmp['quantity'] < $quantity_total) {
			json_return(1, '可分配库存不足');
		}

		$num_physical = array_combine($physical_ids_new, $nums);

		//该产品分配过的门店array
		$physical_ids_old = M('Store_physical_quantity')->getPhysicalByPid($where);
		$physical_arr = array_diff($physical_ids_new, $physical_ids_old);

		//新增
		foreach ($physical_arr as $val) {
			$data = array(
				'store_id' => $store_id,
				'product_id' => $product_id,
				'sku_id' => $sku_id,
				'physical_id' => $val,
				'quantity' => $num_physical[$val],
			);
			$return = M('Store_physical_quantity')->add($data);
		}

		//修改
		foreach ($physical_ids_old as $val) {
			$where = array_merge($where, array('physical_id'=>$val));
			$data = array('quantity'=>$num_physical[$val]);
			$return = M('Store_physical_quantity')->edit($where, $data);
		}

		json_return(0, '修改成功');
	}

	// 物流配置
	public function logistic_config () {
		$this->display();
	} 

	// 订单
	public function order () {
		$this->assign('is_substore', 'is_substore');
		$this->display();
	}

	// 物流工具
	public function delivery () {
		$this->display();
	} 

	/**
	 * 门店管理员
	 */
	// 门店配置
	public function store_config () {
		$this->display();
	}

	private function _store_content () {
		$store_physical = D('Store_physical')->where(array('store_id'=>$this->store_id, 'pigcms_id'=>$this->user_session['item_store_id']))->find();
		if (empty($store_physical)) {
			echo '该门店不存在，或者无权限！';
			exit;
		}
		
		import('area');
		$areaClass = new area();

		$store_physical['province_txt'] = $areaClass->get_name($store_physical['province']);
		$store_physical['city_txt'] = $areaClass->get_name($store_physical['city']);
		$store_physical['area_txt'] = $areaClass->get_name($store_physical['county']);

		$store_physical['images_arr'] = explode(',', $store_physical['images']);
		foreach($store_physical['images_arr'] as &$physical_value){
			$physical_value = getAttachmentUrl($physical_value);
		}

		$this->assign('store_physical', $store_physical);
	}

	//门店编辑 - 名称
	public function store_config_edit () {
		if (IS_POST) {
			$condition_store_physical['pigcms_id'] = $this->user_session['item_store_id'];   
			$condition_store_physical['store_id'] = $this->store_id;
			$data_store_physical['name'] = $_POST['name'];
			$database_store_physical = D('Store_physical');
			if ($database_store_physical->where($condition_store_physical)->data($data_store_physical)->save()) {
				json_return(0, '修改成功');
			} else {
				json_return(1, '修改失败');
			}
		} else {
			json_return(1, '非法访问！');
		}
	}

	// 商品库存
	public function stock () {
		$this->display();
	}

	// 门店库存
	private function _stock_goods_list () {
		$product = M('Product');
		$product_sku = M('Product_sku');
		$product_group = M('Product_group');
		$product_to_group = M('Product_to_group');
		$store_physical_quantity = M('Store_physical_quantity');

		$order_by_field = isset($_POST['orderbyfield']) ? $_POST['orderbyfield'] : '';
		$order_by_method = isset($_POST['orderbymethod']) ? $_POST['orderbymethod'] : '';
		$keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';

		$store_id = $this->store_id;
		$item_store_id = $this->user_session['item_store_id'];

		$where = array();
		$where['store_id'] = $store_id;
		$where['quantity'] = array('>', 0);
		$where['soldout'] = 0;
		if ($keyword) {
			$where['name'] = array('like', '%' . $keyword . '%');
		}

		// 门店有库存
		// if ($item_store_id) {
		//     $products = $store_physical_quantity->getProducts(array('physical_id' => $item_store_id));
		//     $product_ids = array();
		//     if (!empty($products)) {
		//         foreach ($products as $item) {
		//             $product_ids[] = $item['product_id'];
		//         }
		//     }
		//     $where['product_id'] = array('in', $product_ids);
		// }

		$product_total = $product->getSellingTotal($where);
		$product_groups = $product_group->get_all_list($store_id);
		import('source.class.user_page');
		$page = new Page($product_total, 15);
		$products = $product->getSelling($where, $order_by_field, $order_by_method, $page->firstRow, $page->listRows);

		//库存
		foreach ($products as $key => $val) {

			if (empty($val['has_property'])) {
				$products[$key]['sku'] = array();

				//单产品门店库存
				$stock_where = array(
					'product_id' => $val['product_id'],
					'physical_id' => $item_store_id,
					'sku_id' => 0
				);
				$stock = D('Store_physical_quantity')->where($stock_where)->find();
				$products[$key]['_physical_quantity'] = !empty($stock) ? $stock['quantity'] : 0;

				continue;
			}

			$val_sku = $product_sku->getSkus($val['product_id']);

			foreach ($val_sku as $k => $v) {

				//判断是否有库存
				$stock_where = array(
					'product_id' => $v['product_id'],
					'physical_id' => $item_store_id,
					'sku_id' => $v['sku_id'],
						// 'quantity'=>array('gt', 0)
				);
				$stock = D('Store_physical_quantity')->where($stock_where)->find();
				if (!$stock) {
					// unset($val_sku[$k]);
					// continue;
					$val_sku[$k]['_physical_quantity'] = 0;
				} else {
					$val_sku[$k]['_physical_quantity'] = !empty($stock) ? $stock['quantity'] : 0;
				}

				$tmpPropertiesArr = explode(';', $v['properties']);
				$properties = $propertiesValue = $productProperties = array();
				foreach ($tmpPropertiesArr as $v) {
					$tmpPro = explode(':', $v);
					$properties[] = $tmpPro[0];
					$propertiesValue[] = $tmpPro[1];
				}
				if (count($properties) == 1) {
					$findPropertiesArr = D('Product_property')->field('`pid`,`name`')->where(array('pid' => $properties[0]))->select();
					$findPropertiesValueArr = D('Product_property_value')->field('`vid`,`value`,`image`')->where(array('vid' => $propertiesValue[0]))->select();
				} else {
					$findPropertiesArr = D('Product_property')->field('`pid`,`name`')->where(array('pid' => array('in', $properties)))->select();
					$findPropertiesValueArr = D('Product_property_value')->field('`vid`,`value`,`image`')->where(array('vid' => array('in', $propertiesValue)))->select();
				}
				foreach ($findPropertiesArr as $v) {
					$propertiesArr[$v['pid']] = $v['name'];
				}
				foreach ($findPropertiesValueArr as $v) {
					$propertiesValueArr[$v['vid']] = $v['value'];
				}
				foreach ($properties as $kk => $v) {
					$productProperties[] = array('pid' => $v, 'name' => $propertiesArr[$v], 'vid' => $propertiesValue[$kk], 'value' => $propertiesValueArr[$propertiesValue[$kk]], 'image' => getAttachmentUrl($findPropertiesValueArr[$kk]['image']));
				}

				$val_sku[$k]['_property'] = $productProperties;
			}

			$products[$key]['sku'] = $val_sku;
		}

		$this->assign('product_groups', $product_groups);
		$this->assign('product_groups_json', json_encode($product_groups));
		$this->assign('page', $page->show());
		$this->assign('products', $products);
	}

	// 管理员单个修改门店库存信息
	public function physical_quantity_edit_admin () {
		if (IS_POST) {
			if ($this->user_session['type'] == 1) {
				json_return(1,'非法访问！');
			}

			$data['pigcms_id'] = isset($_POST['pigcms_id']) ? intval($_POST['pigcms_id']) : 0;
			$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

			$quantity_tmp = D('Store_physical_quantity')->where($data)->find();

			// 获取库存总数
			if (!empty($quantity_tmp['sku_id'])) {
				$product_tmp = D('Product_sku')->where(array('sku_id'=>$quantity_tmp['sku_id']))->find();
			} else {
				$product_tmp = D('Product')->where(array('product_id'=>$quantity_tmp['product_id']))->find();
			}

			if (empty($product_tmp)) {
				json_return(1, '参数错误');
			}

			$quantity_total = 0;
			$physicals = D('Store_physical_quantity')->where("`sku_id` = '".$quantity_tmp['sku_id']."' AND `product_id` = '".$quantity_tmp['product_id']."' AND `pigcms_id` != '".$data['pigcms_id']."'")->select();
			foreach ($physicals as $val) {
				$quantity_total += intval($val['quantity']);
			}

			if ($product_tmp['quantity'] == 0 || $quantity_total >= $product_tmp['quantity']) {		//其他库存
				json_return(1, '总库存或者剩余库存不足，无法设置该店库存');
			}

			$leave_quantity = $product_tmp['quantity'] - $quantity_total;
			if ($leave_quantity < $quantity) {
				json_return(1, '剩余库存只有'.$leave_quantity.'件，无法设置超出该数值库存');
			}

			D('Store_physical_quantity')->where($data)->data(array('quantity'=>$quantity))->save();
			json_return(0, '修改成功');

		} else {
			json_return(1, '非法访问！');
		}
	}

	// 门店管理员修改/添加库存
	public function physical_quantity_edit () {

		if (IS_POST) {

			if ($this->user_session['type'] != 1 || !$this->user_session['item_store_id']) {
				json_return(1,'非法访问！');
			}

			$data['store_id'] = $this->store_id;
			$data['physical_id'] = $this->user_session['item_store_id'];
			$data['product_id'] = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
			$data['sku_id'] = isset($_POST['sku_id']) ? intval($_POST['sku_id']) : 0;
			$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

			if (D('Store_physical_quantity')->where($data)->find()) {   //修改
				D('Store_physical_quantity')->where($data)->data(array('quantity'=>$quantity))->save();
			} else {    //添加
				$data['quantity'] = $quantity;
				M('Store_physical_quantity')->add($data);
			}

			json_return(0, '修改成功');

		} else {
			json_return(1, '非法访问！');
		}
	}

	// 销售统计
	public function statistic () {
		$this->display();
	}

	// 销售统计-折线图
	private function _statistic_line () {

		$physicals = array();
		$data['start_time'] = isset($_POST['start_time']) ? trim($_POST['start_time']) : '';
		$data['stop_time'] = isset($_POST['stop_time']) ? trim($_POST['stop_time']) : '';
		$product_id = isset($_POST['product_id']) ? trim($_POST['product_id']) : 0;
		$store_id = $this->store_id;

		if ($this->user_session['type'] == 0) { //店主
			$physical_id = isset($_POST['physical_id']) ? trim($_POST['physical_id']) : 0;
			$physicals = M('Store_physical')->getList($this->store_id);
		} else {
			$physical_id = $this->user_session['item_store_id'];
		}

		$product = M('Product');
		$order_product = M('Order_product');

		$where = array();
		$where['store_id'] = $this->store_id;
		$where['soldout'] = 0;
		$where['wholesale_product_id'] = 0;
		$products = $product->getSelling($where, '', '', 0, 9999);

		$days = array();
		if (empty($data['start_time']) && empty($data['stop_time'])) {
			for ($i = 7; $i >= 1; $i--) {
				$day = date("Y-m-d", strtotime('-' . $i . 'day'));
				$days[] = $day;
			}
		} else if (!empty($data['start_time']) && !empty($data['stop_time'])) {
			$start_unix_time = strtotime($data['start_time']);
			$stop_unix_time = strtotime($data['stop_time']);
			$tmp_days = round(($stop_unix_time - $start_unix_time) / 3600 / 24);
			$days = array($data['start_time']);
			if ($data['stop_time'] > $data['start_time']) {
				for ($i = 1; $i < $tmp_days; $i++) {
					$days[] = date("Y-m-d", strtotime($data['start_time'] . ' +' . $i . 'day'));
				}
				$days[] = $data['stop_time'];
			}
		} else if (!empty($data['start_time'])) { //开始时间到后6天的数据
			$stop_time = date("Y-m-d", strtotime($data['start_time'] . ' +7 day'));
			$days = array($data['start_time']);
			for ($i = 1; $i <= 6; $i++) {
				$day = date("Y-m-d", strtotime($data['start_time'] . ' +' . $i . 'day'));
				$days[] = $day;
			}
		} else if (!empty($data['stop_time'])) { //结束时间前6天的数据
			$start_time = date("Y-m-d", strtotime($data['stop_time'] . ' -6 day'));
			$days = array($start_time);
			for ($i = 1; $i <= 6; $i++) {
				$day = date("Y-m-d", strtotime($start_time . ' +' . $i . 'day'));
				$days[] = $day;
			}
		}

		$days_7_products = array();
		$tmp_days = array();
		foreach ($days as $day) {
			//开始时间
			$start_time = strtotime($day . ' 00:00:00');
			//结束时间
			$stop_time = strtotime($day . ' 23:59:59');

			$where = " o.add_time >= ".$start_time." AND o.add_time <= ".$stop_time." AND o.store_id = ".$store_id;
			if ($product_id) {
				$where .= " AND op.product_id = ".$product_id;
			}

			if ($physical_id) {
				$where .= " AND op.sp_id = ".$physical_id;
			}

			$days_7_products[] = $order_product->getOrderProductCount($where);
			$tmp_days[] = "'" . $day . "'";
		}

		$days = !empty($tmp_days) ? '['.implode(",", $tmp_days).']' : '[]';
		$days_7_products = !empty($days_7_products) ? '['.implode(",", $days_7_products).']' : '[]';

		$this->assign('days', $days);
		$this->assign('products', $products);
		$this->assign('physicals', $physicals);
		$this->assign('physical_id', $physical_id);
		$this->assign('days_7_products', $days_7_products);
	}

	// 销售统计 饼图+柱状图
	private function _statistic_percent () {

		$physicals = array();
		$data['start_time'] = isset($_POST['start_time']) ? trim($_POST['start_time']) : '';
		$data['stop_time'] = isset($_POST['stop_time']) ? trim($_POST['stop_time']) : '';

		$store_id = $this->store_id;
		if ($this->user_session['type'] == 0) { //店主
			$physical_id = isset($_POST['physical_id']) ? trim($_POST['physical_id']) : 0;
			$physicals = M('Store_physical')->getList($store_id);
		} else {
			$physical_id = $this->user_session['item_store_id'];
		}

		$product = M('Product');
		$order_product = M('Order_product');

		$where = array();
		$where['store_id'] = $store_id;
		$where['soldout'] = 0;
		$where['wholesale_product_id'] = 0;

		$products = $product->getSelling($where, '', '', 1, 99);

		if (empty($data['start_time']) && empty($data['stop_time'])) {
			$start_time = date("Y-m-d", strtotime('-7 day'));
			$stop_time = date("Y-m-d", strtotime('-1 day'));

			$start_time = strtotime($start_time . ' 00:00:00');
			$stop_time = strtotime($stop_time . ' 23:59:59');

		} else if (!empty($data['start_time']) && !empty($data['stop_time'])) {
			if ($data['stop_time'] > $data['start_time']) {
				$start_time = strtotime($data['start_time'] . ' 00:00:00');
				$stop_time = strtotime($data['stop_time'] . ' 23:59:59');
			}

		} else if (!empty($data['start_time'])) { //开始时间到后6天的数据
			$stop_time = date("Y-m-d", strtotime($data['start_time'] . ' +7 day'));
			$start_time = strtotime($data['start_time'] . ' 00:00:00');
			$stop_time = strtotime($stop_time . ' 23:59:59');

		} else if (!empty($data['stop_time'])) { //结束时间前6天的数据
			$start_time = date("Y-m-d", strtotime($data['stop_time'] . ' -6 day'));
			$start_time = strtotime($start_time . ' 00:00:00');
			$stop_time = strtotime($data['stop_time'] . ' 23:59:59');

		}

		$tmp_products = array();
		$tmp_has_null = false;
		foreach ($products as $product) {
			// $name = "'".$product['product_id'].'_'.$product['name']."'";
			$tmp_name = "'".$product['name']."'";

			$name = "name:".$tmp_name;

			$where = " o.add_time >= ".$start_time." AND o.add_time <= ".$stop_time." AND o.store_id = ".$store_id." AND op.product_id = ".$product['product_id'];
			if ($physical_id) {
				$where .= " AND op.sp_id = ".$physical_id;
			}

			$count = $order_product->getOrderProductCount($where);
			$value = "value:".$count;

			if ($count == 0) {
				$tmp_has_null = true;
				continue;
			}

			$tmp_products[] = $tmp_name;
			$value_products[] = "{".$value.",".$name."}";
			$histogram[] = $count;
		}

		if ($tmp_has_null) {
			$tmp_products[] = "'其他'";
			$value_products[] = "{value:0,name:'其他'}";
			$histogram[] = '0';
		}


		$tmp_products = !empty($products) ? '['.implode(",", $tmp_products).']' : '[]';
		$tmp_value_products = !empty($products) ? '['.implode(",", $value_products).']' : '[]';

		$tmp_histogram = !empty($products) ? '['.implode(",", $histogram).']' : '[]';

		$this->assign('physicals', $physicals);
		$this->assign('products', $tmp_products);
		$this->assign('physical_id', $physical_id);
		$this->assign('days_7_value_name', $tmp_value_products);

		$this->assign('tmp_histogram', $tmp_histogram);

	}

	// 本店订单
	public function store_order () {
		$this->display();
	}

	// 配送员管理
	public function courier () {
		$this->display();
	}

	// 配送员列表
	private function _courier_list () {

		$store_id = $this->store_id;
		$physical_id = $this->user_session['item_store_id'];
		$where = "openid !='' AND store_id = ".$store_id." AND physical_id = ".$physical_id;

		if ($this->user_session['type'] == 0) { //店主
			$physical_id = isset($_POST['physical_id']) ? intval($_POST['physical_id']) : 0;
			if (empty($physical_id)) {
				$where = "openid !='' AND store_id = ".$store_id;
			}
			
		}

		$courier_list = D('Store_physical_courier')->where($where)->order('courier_id DESC')->select();
		$store_physical = D('Store_physical')->where(array('store_id'=>$store_id))->select();
		foreach ($store_physical as $key => $physical) {
			$store_physical_name[$physical['pigcms_id']] = $physical['name'];
		}

		$this->assign('courier_list', $courier_list);
		$this->assign('store_physical_name', $store_physical_name);

	}

	// 配送员编辑
	private function _courier_edit () {

		$store_id = $this->store_id;
		$courier_id = isset($_POST['courier_id']) ? intval($_POST['courier_id']) : 0;

		$info = D('Store_physical_courier')->where(array("courier_id"=>$courier_id))->find();
		$physicals_data = D('Store_physical')->where(array('store_id'=>$store_id))->select();

		if (empty($physicals_data)) {
			echo '请先添加门店！';
			exit;
		}

		foreach ($physicals_data as $key => $physical) {
			$physicals[$physical['pigcms_id']] = $physical['name'];
		}

		$this->assign('info', $info);
		$this->assign('physicals', $physicals);

	}

	// 创建一个配送员
	public function courier_create () {
		if (IS_POST) {
			$store_id = $this->store_id; //用户所属店铺id
			$physical_id = $this->user_session['item_store_id'];
			$courier_id = isset($_POST['courier_id']) ? intval($_POST['courier_id']) : 0;

			$data['name'] = isset($_POST['name']) ? trim($_POST['name']) : '';
			$data['sex'] = isset($_POST['sex']) ? intval($_POST['sex']) : 0;
			$data['avatar'] = isset($_POST['avatar']) ? trim($_POST['avatar']) : '';
			$data['tel'] = isset($_POST['tel']) ? trim($_POST['tel']) : '';

				
			$where = "store_id = ".$store_id." AND courier_id = ".$courier_id;
			$courier_info = D('Store_physical_courier')->where($where)->find();

			if (empty($courier_info)) {
				json_return(1, '参数错误');
			}

			if ($this->user_session['type'] == 0) { //店主
				$physical_id = isset($_POST['physical_id']) ? intval($_POST['physical_id']) : 0; 
				if (empty($physical_id))
					json_return(1, '请选择门店');

				//如果非第一次补全 检测配送员是否已经有包裹
				if (!empty($courier_info['name'])) {
					$cr_package = D('Order_package')->where(array('courier_id'=>$courier_id))->find();
					if (!empty($cr_package) && $courier_info['physical_id'] != $physical_id) {
						json_return(1, '该配送员已经分配有包裹，无法修改所属门店');
					}
				}
			}

			$data['physical_id'] = $physical_id;
			$data['status'] = 1;
			if (D('Store_physical_courier')->where($where)->data($data)->save()) {
				json_return(0, '修改成功');
			} else {
				json_return(1, '修改失败');
			}

		}
	}

	// 配送员删除
	public function courier_del () {
		if (IS_POST) {
			$store_id = $this->store_id;
			$courier_id = isset($_POST['courier_id']) ? $_POST['courier_id'] : 0;

			if (empty($courier_id)) {
				json_return(1, '非法访问！');
			}
			
			if ($this->user_session['type'] == 0) {             // 店主 权限判断

				$courierWhere = array('store_id'=>$store_id, 'courier_id'=>$courier_id);
				$courierInfo = D('Store_physical_courier')->where($courierWhere)->find();
				if (empty($courierInfo)) {
					json_return(1, '该配送员不存在或者缺少权限');
				}

			} else {                                            // 门店管理员 权限判断

				$courierWhere = array('store_id'=>$store_id, 'courier_id'=>$courier_id, 'physical_id'=>$this->user_session['item_store_id']);
				$courierInfo = D('Store_physical_courier')->where($courierWhere)->find();
				if (empty($courierInfo)) {
					json_return(1, '该配送员不存在或者缺少权限');
				}

			}

			// 判断是否有包裹
			$cr_package = D('Order_package')->where(array('courier_id'=>$courier_id))->find();
			if (!empty($cr_package)) {
				json_return(2, '配送员已经分配包裹，无法删除');
			}

			$where = "store_id = $store_id AND courier_id = " . $courier_id;
			if (D('Store_physical_courier')->where($where)->delete()) {
				json_return(0, '删除成功');
			} else {
				json_return(1, '删除失败');
			}
		} else {
			json_return(1, '非法访问！');
		}
	}

	// 查看配送员包裹
	public function courier_package () {
		$courier_id = isset($_GET['courier_id']) ? trim($_GET['courier_id']) : 0; //配送员

		if (empty($courier_id)) {
			pigcms_tips('非法访问！', 'none');
		}

		$this->assign('courier_id', $courier_id);
		$this->display();
	}

	// 配送员包裹列表
	private function _courier_package_content () {
		$data['page'] = isset($_POST['p']) ? intval(trim($_POST['p'])) : 1;
		$data['courier_id'] = isset($_POST['courier_id']) ? intval($_POST['courier_id']) : 0; //配送员
		$data['status'] = isset($_POST['status']) ? trim($_POST['status']) : ''; //订单状态
		$data['orderbyfield'] = isset($_POST['orderbyfield']) ? trim($_POST['orderbyfield']) : '';
		$data['orderbymethod'] = isset($_POST['orderbymethod']) ? trim($_POST['orderbymethod']) : '';

		$order_package = M('Order_package');

		$store_id = $this->store_id;
		if (empty($data['courier_id'])) {
			echo '非法访问！';
			exit;
		}

		if ($this->user_session['type'] == 0) {             // 店主 权限判断

			$courierWhere = array('store_id'=>$store_id, 'courier_id'=>$data['courier_id']);
			$courierInfo = D('Store_physical_courier')->where($courierWhere)->find();
			if (empty($courierInfo)) {
				echo '该配送员不存在或缺少权限！';
				exit;
			}

		} else {                                            // 门店管理员 权限判断

			$courierWhere = array('store_id'=>$store_id, 'courier_id'=>$data['courier_id'], 'physical_id'=>$this->user_session['item_store_id']);
			$courierInfo = D('Store_physical_courier')->where($courierWhere)->find();
			if (empty($courierInfo)) {
				echo '该配送员不存在或缺少权限！';
				exit;
			}

		}

		//排序
		if (!empty($data['orderbyfield']) && !empty($data['orderbymethod'])) {
			$orderby = "`{$data['orderbyfield']}` " . $data['orderbymethod'];
		} else {
			$orderby = '`add_time` DESC';
		}

		if ($data['status'] != '*') {
			$where['status'] = intval($data['status']);
		} else { //所有订单（不包含临时订单）
			$where['status'] = array('>', 0);
		}

		//配送员
		$where['courier_id'] = intval($data['courier_id']);

		$total = $order_package->getPackageTotal($where);

		import('source.class.user_page');
		$page = new Page($total, 15);
		$packages = $order_package->getPackageList($where, $orderby, $page->firstRow, $page->listRows);

		foreach ($packages as $key => $package) {
			$order_product_ids = explode(",", $package["order_products"]);
			foreach ($order_product_ids as $op_id) {
				$packages[$key]['order_product'][] = M('Order_product')->getImageProduct($op_id);
			}
			$tmp_order = M("Order")->getOrder($this->store_id, $package['order_id']);
			$tmp_order['address'] = unserialize($tmp_order['address']);
			$packages[$key]['order'] = $tmp_order;

			$courier = D('Store_physical_courier')->where(array("courier_id"=>$package['courier_id']))->find();
			$packages[$key]['courier'] = !empty($courier) ? $courier['name'] : '';
		}


		$this->assign('packages', $packages);
		$this->assign('page', $page->show());
		$this->assign('status', $data['status']);
		$this->assign('courier_id', $courier_id);
	}

	// 门店包裹
	public function package_list () {
		$this->display();
	}

	// 门店包裹列表
	private function _package_content () {

		$data['page'] = isset($_POST['p']) ? intval(trim($_POST['p'])) : 1;
		$data['orderbyfield'] = isset($_POST['orderbyfield']) ? trim($_POST['orderbyfield']) : '';
		$data['orderbymethod'] = isset($_POST['orderbymethod']) ? trim($_POST['orderbymethod']) : '';
		$data['courier'] = isset($_POST['courier']) ? intval($_POST['courier']) : ''; //配送员
		$data['status'] = isset($_POST['status']) ? trim($_POST['status']) : ''; //订单状态

		$physical_id = $this->user_session['item_store_id'];
		$order_package = M('Order_package');

		if ($this->user_session['type'] == 0) {
			echo '没有查看权限！';
			exit;
		}

		//获取包裹+order_product
		$where['physical_id'] = $physical_id;

		if ($data['status'] != '*') {
			$where['status'] = intval($data['status']);
		} else { //所有订单（不包含临时订单）
			$where['status'] = array('>', 0);
		}

		//配送员
		if ($data['courier']) {
			$where['courier_id'] = intval($data['courier']);
		}

		//排序
		if (!empty($data['orderbyfield']) && !empty($data['orderbymethod'])) {
			$orderby = "`{$data['orderbyfield']}` " . $data['orderbymethod'];
		} else {
			$orderby = '`add_time` DESC';
		}

		$total = $order_package->getPackageTotal($where);

		import('source.class.user_page');
		$page = new Page($total, 15);
		$packages = $order_package->getPackageList($where, $orderby, $page->firstRow, $page->listRows);

		foreach ($packages as $key => $package) {
			$order_product_ids = explode(",", $package["order_products"]);
			foreach ($order_product_ids as $op_id) {
				$packages[$key]['order_product'][] = M('Order_product')->getImageProduct($op_id);
			}
			$tmp_order = M("Order")->getOrder($this->store_id, $package['order_id']);
			$tmp_order['address'] = unserialize($tmp_order['address']);
			$packages[$key]['order'] = $tmp_order;

			$courier = D('Store_physical_courier')->where(array("courier_id"=>$package['courier_id']))->find();
			$packages[$key]['courier'] = !empty($courier) ? $courier['name'] : '';
		}

		$couriers = D('Store_physical_courier')->where(array(
			'physical_id'=>$this->user_session['item_store_id'],
			// 'status' => 1
		))->select();

		$this->assign('packages', $packages);
		$this->assign('couriers', $couriers);
		$this->assign('page', $page->show());
		$this->assign('status', $data['status']);
	}

	// 库存报警
	public function warn_stock () {
		$this->display();
	}

	// 门店报警库存列表
	public function _warn_stock_list () {

		$store_id = $this->store_id;

		// 初始化门店库存记录 (防止新创建门店、新商品未添加门店库存记录)
		M("Store_physical_quantity")->checkInit($store_id);

		// 门店库存下限
		$store_info = M('Store')->getStore($store_id);
		$spq_where['store_id'] = $store_id;
		if ($store_info['warn_sp_quantity'] > 0) {
			$spq_where['quantity'] = array('<', $store_info['warn_sp_quantity']);
		} else {
			$spq_where['quantity'] = array('<', 0);
		}

		if ($this->user_session['type'] == 1) {
			$spq_where['physical_id'] = $this->user_session['item_store_id'];
		}

		$total = D("Store_physical_quantity")->where($spq_where)->count("pigcms_id");

		import('source.class.user_page');
		$page = new Page($total, 15);

		$warn_list = D("Store_physical_quantity")->where($spq_where)->limit($page->firstRow . ',' . $page->listRows)->order("product_id DESC")->select();
		foreach ($warn_list as $key => $val) {
			$warn_list[$key]['product'] = M("Product")->get(array("product_id"=>$val['product_id']));
			$warn_list[$key]['sku'] = M("Product_sku")->decodeSkuInfo($val['sku_id']);
			$warn_list[$key]['physical'] = M("Store_physical")->getOne($val["physical_id"]);
		}

		$this->assign('page', $page->show());
		$this->assign("warn_list", $warn_list);
	}

	// 微信绑定 店主 + 门店管理员
	public function wxbind () {
		$this->display();
	}

	// 为店铺绑定接收通知用openid 
	public function _wxbind_content () {
		$store_id = $this->store_id;
		$store_info = D("Store")->where(array("store_id"=>$store_id))->find();

		$qrcode_id = $store_id + 400000000;
		$qrcode_return = M('Recognition')->get_bind_tmp_qrcode($qrcode_id, $store_id);

		$this->assign('qrcode_return', $qrcode_return);
		$this->assign("store_info", $store_info);
	}

	// 绑定配送员二维码
	public function bind_qrcode () {
		$store_id = $this->store_id;
		$qrcode_id = $store_id + 300000000;
		$qrcode_return = M('Recognition')->get_bind_tmp_qrcode($qrcode_id, $store_id);
		if ($qrcode_return['error_code']) {
			echo '<html><head></head><body>' . $qrcode_return['msg'] . '<br/><br/><font color="red">请关闭此窗口再打开重试XD。</font></body></html>';
		} else {
			$this->assign($qrcode_return);
			$this->display();
		}
	}

	public function del_bind () {
		$store_id = intval($_POST['store_id']);
		if (D('Store')->where(array('store_id'=>$store_id))->data(array('openid'=>''))->save()) {
			json_return(0, '取消绑定成功');
		}
	}

}