<?php
/**
 * 应用营销
 * User: pigcms_21
 * Date: 2015/6/15
 * Time: 10:42
 */
class appmarket_controller extends base_controller {
	//加载
	public function load() {
		$action = strtolower(trim($_POST['page']));
		if (empty($action)) pigcms_tips('非法访问！', 'none');

		switch ($action) {
			case 'dashboard_content': //应用营销概况
				$this->_index_content();
				break;
			case 'present_index':
				$this->_present_index();
				break;
			case 'present_create':
				$this->_present_create();
				break;
			case 'present_edit':
				$this->_present_edit();
				break;
			case 'product_list':
				$this->_product_list();
				break;
			//满减/送
			case 'reward_index':
				$this->_reward_index();
				break;
			case 'reward_create':
				$this->_reward_create();
				break;	
			//预售	
			case 'presale_index':
				$this->_presale_index();
				break;
			case 'presale_create':
				$this->_presale_create();
				break;
			case 'presale_edit':
				$this->_presale_edit();
				break;
				
			default:

				break;
		}

		$this->display($_POST['page']);
	}

	public function dashboard() {
		$this->display();
	}

	public function present() {
		$this->display();
	}

	public function reward() {
		$this->display();
	}



	public function _index_content(){


	}

	//赠品
	private function _present_index() {
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
			$where = "`uid` = '" . $uid . "' AND `store_id` = '" . $store_id . "' AND (`end_time` < '" . $time . "' OR `status` = '0')";
		}

		$present_model = M('Present');
		$count = $present_model->getCount($where);

		$present_list = array();
		$pages = '';
		if ($count > 0) {
			$page = min($page, ceil($count / $limit));
			$offset = ($page - 1) * $limit;

			$present_list = $present_model->getList($where, 'id DESC', $limit, $offset);

			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}

		$this->assign('type', $type);
		$this->assign('pages', $pages);
		$this->assign('present_list', $present_list);
	}


	//添加赠品
	private function _present_create() {
		if (IS_POST && isset($_POST['is_submit'])) {
			$name = $_POST['name'];
			$start_time = $_POST['start_time'];
			$end_time = $_POST['end_time'];
			$expire_date = $_POST['expire_date'] + 0;
			$expire_number = $_POST['expire_number'] + 0;
			$product_id = $_POST['product_id'];

			if (empty($name)) {
				json_return(1001, '赠品名称没有填写，请填写');
			}

			if (empty($start_time)) {
				json_return(1001, '请选择赠品开始时间');
			}

			if (empty($end_time)) {
				json_return(1001, '请选择赠品结束时间');
			}

			if (empty($product_id)) {
				json_return(1001, '请至少选择一个产品作为赠品');
			}

			$product_id_arr = explode(',', $product_id);
			$where = array();
			$where['status'] = 1;
			$where['product_id'] = array('in', $product_id_arr);
			$where['store_id'] = $_SESSION['store']['store_id'];
			$where['quantity'] = array('>', 0);

			$product_list = D('Product')->where($where)->select();
			if (empty($product_list)) {
				json_return(1001, '您选择的产品不能作为赠品');
			}

			// 有效期修正
			$start_time = strtotime($start_time);
			$end_time = strtotime($end_time);
			if ($start_time > $end_time) {
				$tmp = $end_time;
				$end_time = $start_time;
				$start_time = $tmp;
			}

			// 插入数据库
			$data = array();
			$data['name'] = $name;
			$data['dateline'] = time();
			$data['uid'] = $_SESSION['store']['uid'];
			$data['store_id'] = $_SESSION['store']['store_id'];
			$data['start_time'] = $start_time;
			$data['end_time'] = $end_time;
			$data['expire_date'] = $expire_date;
			$data['expire_number'] = $expire_number;

			$pid = D('Present')->data($data)->add();
			if ($pid) {
				foreach ($product_list as $product) {
					unset($data);
					$data['pid'] = $pid;
					$data['product_id'] = $product['product_id'];

					D('Present_product')->data($data)->add();
				}
				json_return(0, '添加成功');
			} else {
				json_return(1001, '添加失败，请重新');
			}
		}


		$product_group_list = M('Product_group')->get_all_list($_SESSION['store']['store_id']);
		$this->assign('product_group_list', $product_group_list);
	}

	// 编辑
	private function _present_edit() {
		$id = $_REQUEST['id'] + 0;

		if (empty($id)) {
			json_return(1001, '缺少最基本的参数ID');
			exit;
		}

		$present_model = M('Present');
		$where = array();
		$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['id'] = $id;
		$present = $present_model->getPresent($where);

		if (empty($present)) {
			json_return(1001, '未找到相应的赠品');
			exit;
		}

		if (IS_POST && isset($_POST['is_submit'])) {
			$name = $_POST['name'];
			$start_time = $_POST['start_time'];
			$end_time = $_POST['end_time'];
			$expire_date = $_POST['expire_date'] + 0;
			$expire_number = $_POST['expire_number'] + 0;
			$product_id = $_POST['product_id'];

			if (empty($name)) {
				json_return(1001, '赠品名称没有填写，请填写');
			}

			if (empty($start_time)) {
				json_return(1001, '请选择赠品开始时间');
			}

			if (empty($end_time)) {
				json_return(1001, '请选择赠品结束时间');
			}

			if (empty($product_id)) {
				json_return(1001, '请至少选择一个产品作为赠品');
			}

			$product_id_arr = explode(',', $product_id);
			$where = array();
			$where['status'] = 1;
			$where['product_id'] = array('in', $product_id_arr);
			$where['store_id'] = $_SESSION['store']['store_id'];
			$where['quantity'] = array('>', 0);

			$product_list = D('Product')->where($where)->select();
			if (empty($product_list)) {
				json_return(1001, '您选择的产品不能作为赠品');
			}

			// 有效期修正
			$start_time = strtotime($start_time);
			$end_time = strtotime($end_time);
			if ($start_time > $end_time) {
				$tmp = $end_time;
				$end_time = $start_time;
				$start_time = $tmp;
			}

			// 插入数据库
			$data = array();
			$data['name'] = $name;
			$data['uid'] = $_SESSION['store']['uid'];
			$data['store_id'] = $_SESSION['store']['store_id'];
			$data['start_time'] = $start_time;
			$data['end_time'] = $end_time;
			$data['expire_date'] = $expire_date;
			$data['expire_number'] = $expire_number;

			D('Present')->data($data)->where(array('id' => $id))->save();

			$present_model = M('Present_product');
			$present_model->delete(array('pid' => $id));

			foreach ($product_list as $product) {
				unset($data);
				$data['pid'] = $id;
				$data['product_id'] = $product['product_id'];

				D('Present_product')->data($data)->add();
			}
			json_return(0, '修改成功');
		}


		$present_product_list = M('Present_product')->getProductListByPid($id);
		$product_group_list = M('Product_group')->get_all_list($_SESSION['store']['store_id']);

		$this->assign('product_group_list', $product_group_list);
		$this->assign('present', $present);
		$this->assign('present_product_list', $present_product_list);
	}


	// 使失效
	public function disabled() {
		$id = $_GET['id'] + 0;

		if (empty($id)) {
			json_return(1001, '缺少最基本的参数ID');
		}

		$present_model = M('Present');

		$where = array();
		$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['id'] = $id;
		$present = $present_model->getPresent($where);

		if (empty($present)) {
			json_return(1001, '未找到相应的赠品');
		}

		$data = array();
		$data['status'] = 0;
		$present_model->save($data, array('id' => $present['id']));
		json_return(0, '操作完成');
	}

	// 删除
	public function delete() {
		$id = $_GET['id'] + 0;

		if (empty($id)) {
			json_return(1001, '缺少最基本的参数ID');
		}

		$present_model = M('Present');

		$where = array();
		$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['id'] = $id;
		$present = $present_model->getPresent($where);

		if (empty($present)) {
			json_return(1001, '未找到相应的赠品');
		}

		$present_model->delete(array('id' => $present['id']));
		json_return(0, '操作完成');
	}

	// 搜索产品
	private function _product_list() {
		$group_id = $_REQUEST['group_id'] + 0;
		$type = $_REQUEST['type'];
		$title = $_REQUEST['title'];
		$page = max(1, $_REQUEST['p']);
		$limit = 6;

		$type_arr = array('title', 'no');
		if (!in_array($type, $type_arr)) {
			$type = 'title';
		}

		$product_model = M('Product');

		// 设置搜索条件
		$where = array();
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['status'] = 1;
		$where['quantity'] = array('>', 0);
		$where['source_product_id'] = 0;
		$where['wholesale_product_id'] = 0;
		if (!empty($group_id)) {
			$where['group_id'] = $group_id;
		}
		if (!empty($title)) {
			if ($type == 'title') {
				$where['name'] = array('like', '%' . $title . '%');
			} else {
				$where['code'] = array('like', '%' . $title . '%');
			}
		}

		$count = $product_model->getSellingTotal($where);

		$pages = '';
		$product_list = array();
		if ($count > 0) {
			$offset = ($page - 1) * $limit;
			$product_list = $product_model->getSelling($where, '', '', $offset, $limit);

			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}

		$this->assign('pages', $pages);
		$this->assign('product_list', $product_list);
	}



	//满减/送
	public function _reward_index(){



	}

	//添加赠品
	public function _reward_create() {

	}





	//预售
	public function presale() {
		$this->display();
	}
	
	
	//开启/关闭
	public function presale_disabled() {
		
		$id = $_GET['id'] + 0;
		
		if (empty($id)) {
			json_return(1001, '缺少最基本的参数ID');
		}
		
		$presale_model = M('Presale');
		
		$where = array();
		$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['id'] = $id;
		$presale = $presale_model->getPresale($where);
		
		if (empty($presale)) {
			json_return(1001, '未找到相应的预售');
		}
		
		
		$data = array();
		$data['is_open'] = $presale['is_open'] ? '0':'1';
		$presale_model->save($data, array('id' => $presale['id']));
		json_return(0, '操作完成');
				
	}
	
	// 删除
	public function presale_delete() {
		$id = $_GET['id'] + 0;
	
		if (empty($id)) {
			json_return(1001, '缺少最基本的参数ID');
		}
	
		$presale_model = M('Presale');
	
		$where = array();
		$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['id'] = $id;
		$presale = $presale_model->getPresale($where);
	
		if (empty($presale)) {
			json_return(1001, '未找到相应的预售信息');
		}
		
		$presale_model->delete(array('id' => $presale['id']));
		json_return(0, '操作完成');
	}

	
	public function _presale_index() {
		
		$page = $_REQUEST['p'] + 0;
		$page = max(1, $page);
		$type = $_REQUEST['type'];
		$keyword = $_REQUEST['keyword'];
		$limit = 15;
		

		$type_arr = array('future', 'on', 'end', 'all');
		if (!in_array($type, $type_arr)) {
			$type = 'all';
		}

		$uid = $_SESSION['store']['uid'];
		$store_id = $_SESSION['store']['store_id'];

		$where = array();
		$where['uid'] = $uid;
		$where['store_id'] = $store_id;

		if (!empty($keyword)) {
			$where['name'] = array('like', '%' . $keyword . '%');
		}

		$time = time();
		if ($type == 'future') {
			$where['starttime'] = array('>', $time);
		} else if ($type == 'on') {
			$where['starttime'] = array('<', $time);
			$where['endtime'] = array('>', $time);
		} else if ($type == 'end') {
			$where = "`uid` = '" . $uid . "' AND `store_id` = '" . $store_id . "' AND (`endtime` < '" . $time . "')";
		}

		$presale_model = M('Presale');
		$count = $presale_model->getCount($where);

		$present_list = array();
		$pages = '';
		if ($count > 0) {
			$page = min($page, ceil($count / $limit));
			$offset = ($page - 1) * $limit;

			$presale_list = $presale_model->getList($where,$limit,$offset);
			if(is_array($presale_list)) {
				foreach($presale_list as $k=>$v) {
					$presale_id_arr[] = $v['id'];
					$product_id_by_presale[] = $v['product_id']; 
					$present_id_by_presale[] = $v['privileged_present'];
					$coupon_id_by_presale[] = $v['privileged_coupon'];
				}
			}
			//预售产品信息产品调取
			if(is_array($product_id_by_presale)) {
				$prodcut_arr_presale1 = D('Product')->where(array('product_id'=>array('in',$product_id_by_presale)))->select();
				if(is_array($prodcut_arr_presale1)) {
					foreach($prodcut_arr_presale1 as $k=>$v) {
						$v['image'] = getAttachmentUrl($v['image']);
						$v ['link'] = url_rewrite('goods:index', array(
							'id' => $v ['product_id']
						));
						$v['wap_url'] = 'wap/good.php?id='.$v['product_id'].'&store_id='.$store_id;
						$prodcut_arr_presale[$v['product_id']] = $v;
					}
				}
			}
			
			//预售产品信息赠送券调取
			if(is_array($coupon_id_by_presale)) {
				$coupon_arr_presale1 = D('Coupon')->where(array('type'=>2,'id'=>array('in',$coupon_id_by_presale)))->select();
				if(is_array($coupon_arr_presale1)) {
					foreach($coupon_arr_presale1 as $k=>$v) {
						//$v['image'] = getAttachmentUrl($v['image']);
						$v ['link'] = url('preferential:coupon')."#edit/".$v['id'];

						$coupon_arr_presale[$v['id']] = $v;
					}
				}
			}
						
			//预售产品信息赠品调取
			if(is_array($present_id_by_presale)) {
				$present_arr1 = D('Present')->where(array('id'=>array('in',$present_id_by_presale)))->select();
				if(is_array($present_arr1)) { 
					foreach($present_arr1 as $k=>$v) {
						$v['link'] =  url('appmarket:present', array(
							'id' => $v ['id']
						));
						$present_arr[$v['id']] = $v; 
					}
				}
			}
			
			
			//预售对应订单查询
			if(is_array($presale_id_arr)) {
				//待付尾款
				$order_complate = array();
				$order_unendpay = array();
				
				$order_unendpays = D('Order')->where(array('type'=>7,'presale_order_id'=>0,'data_id'=>array('in',$presale_id_arr)))->group("data_id")->field("data_id,count(order_id) counts")->select();
				foreach($order_unendpays as $k=>$v) {
					$order_unendpay[$v['data_id']] = $v;
				}
				
				//已完成交易
				$presale_str = implode(",",$presale_id_arr);
				$order_complates = D('Order')->where("type=7 and presale_order_id = order_id and data_id in(".$presale_str.")")->group("data_id")->field("data_id,count(order_id) counts")->select();
				foreach($order_complates as $k=>$v) {
					$order_complate[$v['data_id']] = $v;
				}
		
				foreach($presale_list as $k=>&$v) {
					if($order_unendpay[$v['id']]) {
						$v['order_unendpay'] = $order_unendpay[$v['id']]['counts'];
					} else {
						$v['order_unendpay'] =  0;
					}
					
					if($order_complate[$v['id']]) {
						$v['order_complate'] =  $order_complate[$v['id']]['counts'];
					} else {
						$v['order_complate'] =  0;
					}
					
				}
			}
			
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}
		
	
		$this->assign('type', $type);
		$this->assign('pages', $pages);
		$this->assign('prodcut_arr_presale', $prodcut_arr_presale);
		$this->assign('present_arr', $present_arr);
		$this->assign('coupon_arr_presale', $coupon_arr_presale);
		$this->assign('presale_list', $presale_list);
		
	}

	//添加预售
	private function _presale_create() {
		if (IS_POST && isset($_POST['is_submit'])) {
			$name = $_POST['name'];
			$product_id = $_POST['product_id'];
			$dingjin = $_POST['dingjin'];
			$cash = $_POST['cash'];
			$coupon = $_POST['coupon'];
			$present = $_POST['present'];
			$price = $_POST['price'];
			$product_quantity = $_POST['product_quantity'];
			$presale_person = $_POST['presale_person'];
			$start_time = $_POST['start_time'];
			$end_time = $_POST['end_time'];
			$pay_time = $_POST['pay_time'];
			$presale_amount = $_POST['presale_amount'];
			$shuoming = $_POST['shuoming'];
			
			if(empty($product_id)) {
				json_return(1001, '请至少选择一个产品作为预售商品！');
			}
			if(empty($name)) {
				json_return(1000,"预售标题名称不能为空");
			}
			if($cash) {
				if(!preg_match('/^[0-9]{1,5}[\.]?[0-9]{0,2}$/',$cash)) {
					json_return(1002, '特权减现金填写错误！');
				}
			}
			if($coupon) {
				if(!preg_match('/^[\d]{1,}/',$coupon)) {
					json_return(1003, '特权优惠券填写错误！');
				}
			}
			if($present) {
				if(!preg_match('/^[\d]{1,}/',$present)) {
					json_return(1004, '特权赠品填写错误！');
				}
			}
			if (empty($dingjin)) {
				json_return(1005, '请正确填写所需定金！');
			}
			if(($dingjin > $price) || (!$price)) {
				json_return(1006,"定金不应大于商品原价");
			}
			
			if (empty($start_time)) {
				json_return(1006, '请选择预售开始时间！');
			}

			if (empty($end_time)) {
				json_return(1007, '请选择预售结束时间！');
			}
			
			if (empty($pay_time)) {
				json_return(1008, '请选择尾款支付截止时间！');
			}			

			if (empty($presale_person)) {
				json_return(1009, '请正确填写预售人数！');
			}
			
			if (empty($presale_amount)) {
				json_return(1010, '请正确填写预售数量限制！');
			}
			
			if(($presale_amount > $product_quantity) || (!$product_quantity)) {
				json_return(1011,"预售数量不应大于商品库存");
			}
			
			if (empty($shuoming)) {
				json_return(1012, '预售说明不能为空！');
			}
			
			//检测 赠品
/* 			if($present) {
				$where = array();
				$where['status'] = 1;
				$where['product_id'] = $present;
				$where['store_id'] = $_SESSION['store']['store_id'];
				$where['quantity'] = array('>', 0);
	
				$product_list = D('Product')->where($where)->select();
				if (empty($product_list)) {
					json_return(1012, '您选择的产品不能作为赠品！');
				}
			} 
*/
			// 有效期修正
			$start_time = strtotime($start_time);
			$end_time = strtotime($end_time);
			if ($start_time > $end_time) {
				$tmp = $end_time;
				$end_time = $start_time;
				$start_time = $tmp;
			}
			
			if(empty($start_time) || empty($end_time)) {
				json_return(1013,"预售时间段填写不完整！");
			}
			
			$pay_time = strtotime($pay_time);
			if($pay_time <= $end_time) {
				json_return(1014, '尾款截止时间应大于预售的结束时间哦！');
			}

			// 插入数据库
			$data = array(
				'name' 		=> $name,
				'product_id'=> $product_id,
				'uid'		=> $_SESSION['store']['uid'],
				'store_id'	=> $_SESSION['store']['store_id'],
				'dingjin'	=> $dingjin,
				'price'		=> $price,
				'product_quantity'	=> $product_quantity,
				'privileged_cash' => $cash,
				'privileged_coupon' => $coupon,
				'privileged_present' => $present,
				'presale_person'=> $presale_person,
				'starttime'	=>  $start_time,
				'endtime'	=>  $end_time,
				'final_paytime' => $pay_time,
				'presale_amount' => $presale_amount,
				'description'	=> $shuoming,
				'timestamp'	=> time()
			);

			$presale_id = D('Presale')->data($data)->add();
			if ($presale_id) {
				json_return(0, '添加成功');
			} else {
				json_return(1015, '添加失败，请重新');
			}
		}


		$time = time();
		
		$where = array();
		$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['status'] = 1;
		$where['type'] = 2;
		$where['start_time'] = array('<=', $time);
		$where['end_time'] = array('>=', $time);
		// 优惠券
		$coupon_list = M('Coupon')->getList($where);
		
		// 店铺赠品
		unset($where['type']);
		$present_list = M('Present')->getList($where);
		$this->assign('coupon_list', $coupon_list);
		$this->assign('present_list', $present_list);
	}
	
	
	
	public function _presale_edit() {
		
		$presale_id = $_REQUEST['id'] + 0;
		$allow_edit = true; 	//可以编辑
		if (empty($presale_id)) {
			json_return(1001, '缺少最基本的参数ID');
			exit;
		}
		
		$presale_model = M('Presale');
		$where = array();
		$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['id'] = $presale_id;
		$presale = $presale_model->getPresale($where);
		$time = time();

		//检测是否有权限修改
		$order_unendpay = D('Order')->where(array('type'=>7,'presale_order_id'=>0,'data_id'=> $presale_id ))->field("count(order_id) counts")->find();
		//已完成交易
		$order_complate = D('Order')->where("type=7 and presale_order_id = order_id and data_id = '".$presale_id."'")->field("count(order_id) counts")->find();
		
		if($order_unendpay['counts'] || $order_complate['counts']) {
			$allow_edit = false;
		}
		
		if (empty($presale)) {
			json_return(1002, '未找到相应的预售信息');
			exit;
		}
		
		if (IS_POST && isset($_POST['is_submit'])) {
			
			//检测是否有权限修改
			if (!$allow_edit ) {
				json_return(1022, '即将修改的此条预售信息已有用户下单，不可变更！');
				exit;
			}				

			$name = $_POST['name'];
			$product_id = $_POST['product_id'];
			$presale_id = $_POST['presale_id'];
			$price 		= $_POST['price'];
			$product_quantity = $_POST['product_quantity'];
			$dingjin = $_POST['dingjin'];
			$cash = $_POST['cash'];
			$coupon = $_POST['coupon'];
			$present = $_POST['present'];
			$presale_person = $_POST['presale_person'];
			$start_time = $_POST['start_time'];
			$end_time = $_POST['end_time'];
			$pay_time = $_POST['pay_time'];
			$presale_amount = $_POST['presale_amount'];
			$shuoming = $_POST['shuoming'];
			
			if(empty($presale_id)) {
				json_return(1000,"修改的预售信息错误！");
			}
			if(empty($name)) {
				json_return(1000,"预售标题不能为空");
			}
			
			if(empty($product_id)) {
				json_return(1001, '请至少选择一个产品作为预售商品！');
			}

			if($cash) {
				if(!preg_match('/^[0-9]{1,5}[\.]?[0-9]{0,2}$/',$cash)) {
					json_return(1002, '特权减现金填写错误！');
				}
			}
			if($coupon) {
				if(!preg_match('/^[\d]{1,}/',$coupon)) {
					json_return(1003, '特权优惠券填写错误！');
				}
			}
			if($present) {
				if(!preg_match('/^[\d]{1,}/',$present)) {
					json_return(1004, '特权赠品填写错误！');
				}
			}
			if (empty($dingjin)) {
				json_return(1005, '请正确填写所需定金！');
			}
			if(($dingjin > $price) || (!$price)) {
				json_return(1006,"定金不应大于商品原价");
			}
			if (empty($start_time)) {
				json_return(1006, '请选择预售开始时间！');
			}

			if (empty($end_time)) {
				json_return(1007, '请选择预售结束时间！');
			}
			
			if (empty($pay_time)) {
				json_return(1008, '请选择尾款支付截止时间！');
			}			

			if (empty($presale_person)) {
				json_return(1009, '请正确填写预售人数！');
			}
			
			if (empty($presale_amount)) {
				json_return(1010, '请正确填写预售数量限制！');
			}
			if(($presale_amount > $product_quantity) || (!$product_quantity)) {
				json_return(1011,"预售数量不应大于商品库存");
			}
			if (empty($shuoming)) {
				json_return(1012, '预售说明不能为空！');
			}
			
			//检测 赠品
/* 			if($present) {
				$where = array();
				$where['status'] = 1;
				$where['product_id'] = $present;
				$where['store_id'] = $_SESSION['store']['store_id'];
				$where['quantity'] = array('>', 0);
	
				$product_list = D('Product')->where($where)->select();
				if (empty($product_list)) {
					json_return(1012, '您选择的产品不能作为赠品！');
				}
			} 
*/
			// 有效期修正
			$start_time = strtotime($start_time);
			$end_time = strtotime($end_time);
			if ($start_time > $end_time) {
				$tmp = $end_time;
				$end_time = $start_time;
				$start_time = $tmp;
			}
			
			if(empty($start_time) || empty($end_time)) {
				json_return(1013,"预售时间段填写不完整！");
			}
			
			$pay_time = strtotime($pay_time);
			if($pay_time <= $end_time) {
				json_return(1014, '尾款截止时间应大于预售的结束时间哦！');
			}

			// 插入数据库
			$data = array(
				'name' => $name,
				'product_id'=> $product_id,
				'dingjin'	=> $dingjin,
				'price'		=> $price,
				'product_quantity'	=> $product_quantity,
				'privileged_cash' => $cash,
				'privileged_coupon' => $coupon,
				'privileged_present' => $present,
				'presale_person'=> $presale_person,
				'starttime'	=>  $start_time,
				'endtime'	=>  $end_time,
				'final_paytime' => $pay_time,
				'presale_amount' => $presale_amount,
				'description'	=> $shuoming,
			);
			
			

			D('Presale')->data($data)->where(array('id' => $presale_id))->save();
			
			if ($presale_id) {
				json_return(0, '修改成功');
			} else {
				json_return(1015, '修改失败，请重新');
			}
		}
		
		$presale_product = M('Product')->get(array('product_id'=>$presale['product_id']));

		
		$where = array();
		$where['uid'] = $_SESSION['store']['uid'];
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['status'] = 1;
		$where['type'] = 2;
		$where['start_time'] = array('<=', $time);
		$where['end_time'] = array('>=', $time);
		// 优惠券
		$coupon_list = M('Coupon')->getList($where);
		// 店铺赠品
		unset($where['type']);
		$present_list = M('Present')->getList($where);	
		//dump($presale);	
		$this->assign('allow_edit',$allow_edit);
		$this->assign('presale', $presale);
		$this->assign('presale_product', $presale_product);
		$this->assign('coupon_list', $coupon_list);
		$this->assign('present_list', $present_list);
	}
	
	

}