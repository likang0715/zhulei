<?php
class unitary_controller extends base_controller {

	public $overTime = 900;	// 15分钟过期设置

	public function __construct(){
		parent::__construct();
        if(!in_array(ACTION_NAME, array('payReturn','payend','nopayover','doOutOrder','indexajax','cartajax','goodsajax'))){
			$this->doOutOrder();
			$this->nopayover();
		}
	}

	// 检测开奖和幸运号计算
	public function doOutOrder () {

		$unitary_id = isset($_REQUEST['unitary_id']) ? intval($_REQUEST['unitary_id']) : 0;

		if (!empty($unitary_id)) {

			$unitary = M('Unitary')->getUnitary($unitary_id);

			if ($unitary['state'] != 2) {

				$pay_count = M('Unitary')->getPayCount($unitary_id);

				if ($pay_count < $unitary['total_num']) {
					// echo '$pay_count < $unitary["total_num"]';exit;
					D('Unitary_lucknum')->where(array('unitary_id'=>$unitary_id))->data(array('state'=>0))->save();

				} else {		//计算发送幸运号

					$lucknum_all_count = D('Unitary_lucknum')->count('id');
					if ($lucknum_all_count < 100) {
						$save_unitary['lastnum'] = $lucknum_all_count;
					} else {
						$save_unitary['lastnum'] = 100;
					}
					$lucknum_all = D('Unitary_lucknum')->order('addtime desc, id desc')->limit($save_unitary['lastnum'])->select();
					$save_unitary['lasttime'] = $lucknum_all[0]['id'];
					$sum = 0;
					foreach ($lucknum_all as $avo) {
						$thistime = floor($avo['addtime']/1000);
						$ms = substr($avo['addtime'],-3);
						$sum = $sum + (date('H',$thistime).date('i',$thistime).date('s',$thistime).$ms);
					}
					$lucknum = fmod($sum, $unitary['total_num']);
					
					$save_unitary['lucknum'] = $lucknum;
					$save_unitary['state'] = 2;
					$save_unitary['endtime'] = time() + $unitary['opentime'];
					$save_unitary['proportion'] = 100;
					
					$where_cart3 = array(
						'state' => 0,
						'unitary_id' => $unitary_id,
					);
					$del_cart3 = D('Unitary_cart')->where($where_cart3)->delete();
					
					$update_unitary = D('Unitary')->where(array('id'=>$unitary_id))->data($save_unitary)->save();

					$where_lucknum2 = array(
						'unitary_id' => $unitary_id,
						'lucknum' => $lucknum,
						'state' => 0,
					);
					$update_lucknum2 = D('Unitary_lucknum')->where($where_lucknum2)->data(array('state'=>1))->save();

					$find_lucknum2 = D('Unitary_lucknum')->where(array('state'=>1))->find();

					// 构造订单到 order 表中
					$create_order = M('Unitary')->unitaryAddOrder($unitary_id);

					// 生成发送信息 未测试 TODO 
					$fail_uid_arr = M('Unitary')->getBuyUser($unitary_id, false);
					$noticeResult = ShopNotice::yydbResultNotice($find_lucknum2['uid'], $fail_uid_arr, $unitary_id);

				}
			}
		}
	}

	//微信支付没有点击完成处理
	public function nopayover () {

		$myorder = D('Unitary_order')->where(array('uid'=>$this->user['uid'],'paid'=>1,'addtime'=>array('gt',1444663403)))->order('addtime desc')->find();
		if (!empty($myorder))  {
			redirect("unitary:payend",array("orderid"=>$myorder['pigcms_id'],'unitary_id'=>$_REQUEST['unitary_id']));
		}

	}

	// 店铺所有夺宝
	public function index () {

		$store_id = isset($_REQUEST['store_id']) ? intval($_REQUEST['store_id']) : 0;
		$group_id = isset($_REQUEST['group_id']) ? intval($_REQUEST['group_id']) : 0;
		$order_by = !empty($_REQUEST['order_by']) ? trim($_REQUEST['order_by']) : 'proportion';
		$page = max(1, $_REQUEST['page']);

		$limit = 10;
		$offset = ($page - 1) * $limit;

		if (empty($store_id) || !$store = M('Store')->getStore($store_id)) {
			json_return(1000, '缺少参数、或未找到店铺');
		}
		
		// 分组
		$group_list = M('Product_group')->get_all_list($store_id);

		$unitary_where = array();
		$unitary_where['store_id'] = $store_id;


		if (!empty($group_id)) {

			$product_ids = array();
			$products = M('Product_to_group')->getProducts($group_id);

			foreach ($products as $val) {
				$product_ids[] = $val['product_id'];
			}

			if (!empty($product_ids)) {
				$unitary_where['product_id'] = array('in', $product_ids);
			}

			// $unitary_where['type'] = $group_id;

		}

		$group_list = array_merge(array(array('group_id'=>0, 'group_name'=>'全部分类')), $group_list) ;

		foreach ($group_list as $key => $val) {
			if ($val['group_id'] == $group_id) {
				$group_list[$key]['on'] = 1;
			} else {
				$group_list[$key]['on'] = 0;
			}
		}

		// 排序
		$order_by_arr = M('Unitary')->getSort($order_by);
		switch ($order_by) {
			case 'proportion':
				$order_by = "proportion desc";
				break;
			case 'renqi':
				$order_by = "renqi desc";
				break;
			case 'priceup':
				$order_by = "price desc";
				break;
			case 'pricedown':
				$order_by = "price";
				break;
			case 'addtime':
				$order_by = "addtime desc";
				break;
			default:
				$order_by = "proportion desc";
		}

		$unitary_where['state'] = 1;

		$count = M('Unitary')->getCount($unitary_where);
		$list = M('Unitary')->getList($unitary_where, $order_by, $limit, $offset);

		foreach ($list as $key => $val) {
			// 参与者
			$pay_count = M('Unitary')->getPayCount($val['id']);
			$list[$key]['pay_count'] = $pay_count;
			// 剩余
			$list[$key]['left_count'] = $val['total_num'] - $pay_count;
		}

		$next_page = true;
		if (count($list) < $limit) {
			$next_page = false;
		} else if ($offset >= $count) {
			$next_page = false;
		} else if ($offset + $limit == $count) {
			$next_page = false;
		}

		$cart_count = M('Unitary_cart')->getCount(array('uid'=>$this->user['uid'], 'store_id'=>$store_id, 'state'=>0));

		$return = array();
		$return['list'] = $list;
		$return['order_by_list'] = $order_by_arr;
		$return['product_group_list'] = $group_list;
		$return['cart_count'] = $cart_count;
		$return['next_page'] = $next_page;

		json_return(0, $return);

	}

	// 夺宝购物车 改版
	public function cart () {

		// $store_id = isset($_REQUEST['store_id']) ? intval($_REQUEST['store_id']) : 0;
		// if (!empty($store_id)) {
		// 	$this->cart_shop();
		// } else {
		// 	$this->cart_all();
		// }
		// $this->cart_shop();

		$this->cart_all();
	}

	// 购物车全部
	public function cart_all () {

		$store_id = isset($_REQUEST['store_id']) ? intval($_REQUEST['store_id']) : 0;

		$where_cart = array(
			'uid' => $this->user['uid'],
			'state' => 0,
		);

		if (!empty($store_id)) {
			$where_cart = array_merge($where_cart, array('store_id'=>$store_id));
		}

		$count = D('Unitary_cart')->where($where_cart)->count('id');
		$cart_list = D('Unitary_cart')->where($where_cart)->select();

		$total = 0;	// 数量
		$sum = 0;	// 参与的活动数量
		$unitary = array();
		$unitary_ycount = array();

		foreach ($cart_list as $vo) {

			$total = $total + $vo['count'];
			$sum++;

			$unitary_ycount[$vo['id']] = M('Unitary_cart')->getLeftCount($vo['unitary_id']);
			// 重设购物车数量
			if ($unitary_ycount[$vo['id']] <= 0) {
				$del_cart = D('Unitary_cart')->where(array('id'=>$vo['id'], 'store_id'=>$vo['store_id']))->delete();
				$sum = $sum - 1;
				$total = $total - $vo['count'];

			} elseif ($unitary_ycount[$vo['id']] < $vo['count']) {
				$update_cart = D('Unitary_cart')->where(array('id'=>$vo['id']))->save(array('count'=>$unitary_ycount[$vo['id']]));
				$cha = $vo['count'] - $unitary_ycount[$vo['id']];
				$total = $total - $cha;

			}

		}

		// 重新获取未支付购物车记录
		$cart_list = array();
		$cart_list3 = D('Unitary_cart')->where($where_cart)->select();
		foreach ($cart_list3 as $val) {

			$find_unitary = M('Unitary')->getUnitary($val['unitary_id']);
			$find_unitary['pay_count'] = M('Unitary')->getPayCount($val['unitary_id']);
			$find_unitary['left_count'] = $find_unitary['total_num'] - $find_unitary['pay_count'];

			$tmp_cart = $val;
			// $tmp_cart['unitary'] = $find_unitary;
			$unitary[$val['id']] = $find_unitary;

			$cart_list[$val['store_id']]['shop'] = D('Store')->field('name,store_id')->where(array('store_id'=>$val['store_id']))->find();

			$cart_list[$val['store_id']]['list'][] = $tmp_cart;

		}

		$return = array();

		$return['cart_list'] = $cart_list;
		$return['unitary'] = $unitary;
		$return['ycount'] = $unitary_ycount;
		$return['total'] = $total;
		$return['sum'] = $sum;

		json_return(0, $return);
	}

	// 夺宝购物车
	public function cart_shop () {

		$store_id = isset($_REQUEST['store_id']) ? intval($_REQUEST['store_id']) : 0;
		$page = max(1, $_REQUEST['page']);

		$limit = 10;
		$offset = ($page - 1) * $limit;

		$where_cart = array(
			'uid' => $this->user['uid'],
			'store_id' => $store_id,
			'state' => 0,
		);
		$count = D('Unitary_cart')->where($where_cart)->count('id');
		$cart_list = D('Unitary_cart')->where($where_cart)->select();

		$total = 0;	// 数量
		$sum = 0;	// 参与的活动数量
		$unitary = array();
		$unitary_ycount = array();
		foreach ($cart_list as $vo) {

			$find_unitary = M('Unitary')->getUnitary($vo['unitary_id']);
			$unitary[$vo['id']] = $find_unitary;

			$total = $total + $vo['count'];
			$sum++;

			// $pay_count = 0;
			// $pay_count = M('Unitary')->getPayCount($vo['unitary_id']);
			// $unitary_ycount[$vo['id']] = $find_unitary['total_num'] - $pay_count;

			$unitary_ycount[$vo['id']] = M('Unitary_cart')->getLeftCount($vo['unitary_id']);
			// 重设购物车数量
			if ($unitary_ycount[$vo['id']] <= 0) {
				$del_cart = D('Unitary_cart')->where(array('id'=>$vo['id'], 'store_id'=>$vo['store_id']))->delete();
				$sum = $sum - 1;
				$total = $total - $vo['count'];

			} elseif ($unitary_ycount[$vo['id']] < $vo['count']) {
				$update_cart = D('Unitary_cart')->where(array('id'=>$vo['id']))->save(array('count'=>$unitary_ycount[$vo['id']]));
				$cha = $vo['count'] - $unitary_ycount[$vo['id']];
				$total = $total - $cha;

			}

		}

		// 重新获取未支付购物车记录
		$cart_list3 = D('Unitary_cart')->where($where_cart)->limit($offset . ',' . $limit)->select();

		$next_page = true;
		if (count($cart_list3) < $limit) {
			$next_page = false;
		} else if ($offset >= $count) {
			$next_page = false;
		} else if ($offset + $limit == $count) {
			$next_page = false;
		}

		$return = array();
		$return['cart_list'] = $cart_list3;
		$return['unitary'] = $unitary;
		$return['total'] = $total;
		$return['sum'] = $sum;
		$return['ycount'] = $unitary_ycount;
		$return['next_page'] = $next_page;

		json_return(0, $return);

	}

	// 操作购物车
	public function cartajax () {

		$type = isset($_REQUEST['type']) ? trim($_REQUEST['type']) : '';
		$store_id = isset($_REQUEST['store_id']) ? intval($_REQUEST['store_id']) : 0;

		switch ($type) {

			case 'delorder':	// 删除15分钟内未支付订单
				
				$where_order = array(
					'uid' => $this->user['uid'],
					'paid' => 0,
				);
				$order_list = D('Unitary_order')->where($where_order)->select();
				
				$where_order2['paid'] = 0;
				$time = time() - ($this->overTime);
				$where_order2['addtime'] = array('lt', $time);
				$order_list2 = D('Unitary_order')->where($where_order2)->select();
				foreach ($order_list2 as $vo2) {
					$where_cart2 = array(
						'uid' => $vo2['uid'],
						'order_id' => $vo2['pigcms_id'],
					);
					$update_cart2 = D('Unitary_cart')->where($where_cart2)->delete();
				}

				$del_order2 = D('Unitary_order')->where($where_order2)->delete();
				
				if (!empty($order_list)) {
					foreach ($order_list as $vo) {
						$where_cart = array(
							'uid' => $this->user['uid'],
							'order_id' => $vo['pigcms_id'],
						);
						$update_cart = D('Unitary_cart')->where($where_cart)->delete();
					}
					$del_order = D('Unitary_order')->where($where_order)->delete();

					json_return(0, '删除成功');
				} else {
					json_return(0, '删除成功');
				}

				$return = array();
				json_return($error_code, $return);

				break;

			case 'click_cart_count':	//点击购物车输入框 - 提示活动状态、删除15分钟未支付订单

				$where_cart['id'] = isset($_REQUEST['cart_id']) ? intval($_REQUEST['cart_id']) : 0;

				if (empty($where_cart['id'])) {
					json_return(1000, '缺少参数');
				}

				$find_cart = D('Unitary_cart')->where($where_cart)->find();
				if (empty($find_cart)) {
					json_return(1000, '购物记录已经过期，请重新下单');
				}

				// $unitary_id = $find_cart["unitary_id"];
				// $find_unitary = D('Unitary')->where(array('id'=>$unitary_id))->find();
				// $where_cart2 = array(
				// 	'unitary_id' => $unitary_id,
				// 	'state' => 1,
				// );
				// $cart_list = D('Unitary_cart')->where($where_cart2)->select();

				// $pay_count = 0;
				// foreach ($cart_list as $vo) {
				// 	$this_order = D('Unitary_order')->where(array('pigcms_id'=>$vo['order_id']))->find();
				// 	if ($this_order['paid'] != 1 && $vo['addtime'] < (time()-($this->overTime))) {
				// 		D('Unitary_cart')->where(array('id'=>$vo['id']))->delete();
				// 	} else {
				// 		$pay_count = $pay_count + $vo['count'];
				// 	}
				// }
				// $unitary_ycount = $find_unitary['total_num'] - $pay_count;

				$unitary_ycount = M('Unitary_cart')->getLeftCount($find_cart['unitary_id']);

				if ($unitary_ycount == 0) {
					$del_cart = D('Unitary_cart')->where($where_cart)->delete();
					json_return(1000, "此商品已结束");
				} else {
					if (empty($find_cart)) {
						json_return(1000, "此商品已结束");
					} else {
						json_return(0, array('ycount'=>$unitary_ycount));	//剩余数量
					}
				}

				break;

			case 'cart_count_change':		// 购物车输入框数值发生变化时调用 修改该购物车数量、删除15分钟未支付订单

				$count = $point_count = isset($_REQUEST['cart_count']) ? abs(intval($_REQUEST['cart_count'])) : 0;
				$where_cart['id'] = isset($_REQUEST['cart_id']) ? intval($_REQUEST['cart_id']) : 0;

				if (empty($where_cart['id'])) {
					json_return(1000, '缺少参数');
				}

				$find_cart = D('Unitary_cart')->where($where_cart)->find();
				if (empty($find_cart)) {
					json_return(1000, '购物记录已经过期，请重新下单');
				}


				$where_unitary = array('id'=>$find_cart['unitary_id']);
				$find_unitary = D('Unitary')->where($where_unitary)->find();

				// $where_cart2 = array(
				// 	'state' => 1,
				// 	'unitary_id' => $unitary_id,
				// );
				// $cart_list = D('Unitary_cart')->where($where_cart2)->select();
				// $pay_count = 0;
				// foreach ($cart_list as $vo) {
				// 	$this_order = D('Unitary_order')->where(array('pigcms_id'=>$vo['order_id']))->find();
				// 	if ($this_order['paid'] != 1 && $vo['addtime'] < (time()-($this->overTime))) {
				// 		D('Unitary_cart')->where(array('id'=>$vo['id']))->delete();
				// 	} else {
				// 		$pay_count = $pay_count + $vo['count'];
				// 	}
				// }

				// $unitary_ycount = $find_unitary['total_num'] - $pay_count;

				$unitary_ycount = M('Unitary_cart')->getLeftCount($find_cart['unitary_id']);

				if ($count > 10000) {
					$count = 10000;
					$save_cart['count'] = $count;
					$yiwan = "yes";
				} elseif (($count - floor($count)) > 0) {
					$count = floor($count);
					$save_cart['count'] = $count;
					$xiaoshu = "yes";
				} elseif ($count > $unitary_ycount) {
					$count = $unitary_ycount;
					$save_cart['count'] = $count;
					$dale = "yes";
				} else {
					$save_cart['count'] = $count;
				}

				$update_cart = D('Unitary_cart')->where($where_cart)->data($save_cart)->save();
				$where_cart3 = array(
					'uid' => $this->user['uid'],
					'state' => 0,
				);

				if (!empty($store_id)) {
					$where_cart3 = array_merge($where_cart3, array('store_id' => $store_id));
				}

				$cart_list2 = D('Unitary_cart')->where($where_cart3)->select();
				$total_price = 0;
				foreach ($cart_list2 as $vo) {
					$find_unitary = M('Unitary')->getUnitary($vo['unitary_id']);
					$total_price = $total_price + $vo['count']*$find_unitary['item_price'];
				}

				$find_cart = D('Unitary_cart')->where($where_cart)->find();
				if (empty($find_cart) || $unitary_ycount == 0) {
					if ($unitary_ycount == 0) {
						$del_cart = D('Unitary_cart')->where($where_cart)->delete();
					}

					json_return(1000, "此商品已结束");

				} else {
					if (empty($point_count)) {
						$error_code = 1000;
						$data['cart_count'] = "";
						$data['msg'] = "请填写数字";
						$data['total_price'] = $total_price;
						$data['ycount'] = $unitary_ycount;
						json_return($error_code, $data['msg']);

					} else {
						if ($yiwan == "yes") {
							$error_code = 1000;
							$data['msg'] = "单次购买不可超过1万";
							json_return($error_code, $data['msg']);
						} elseif ($xiaoshu == "yes") {
							$error_code = 1000;
							$data['msg'] = "不能是小数";
							json_return($error_code, $data['msg']);
						} elseif ($dale == "yes") {
							$error_code = 1000;
							$data['msg'] = "不能超过".$unitary_ycount."人次";
							json_return($error_code, $data['msg']);
						} else {
							$error_code = 0;
						}

						$data['cart_count'] = $count;
						$data['total_price'] = $total_price;
						$data['ycount'] = $unitary_ycount;

					}

					// json_return($error_code, $data);
					json_return($error_code, $data);
				}

				break;

			case 'cart_del':					// 删除一条购物记录，返回购物车种类、总数量

				$where_cart['id'] = isset($_REQUEST['cart_id']) ? intval($_REQUEST['cart_id']) : 0;

				if (empty($where_cart['id'])) {
					json_return(1000, "缺少参数");
				}

				$where_cart['state'] = 0;
				$del_cart = D('Unitary_cart')->where($where_cart)->delete();
				if ($del_cart > 0) {

					$where_cart2 = array(
						'uid' => $this->user['uid'],
						'state' => 0,
					);
					if (!empty($store_id)) {
						$where_cart2 = array_merge($where_cart2, array('store_id' => $store_id));
					}

					$cart_list = D('Unitary_cart')->where($where_cart2)->select();
					$total_price = 0;
					$count = 0;
					foreach ($cart_list as $vo) {
						$find_unitary = M('Unitary')->getUnitary($vo['unitary_id']);
						$total_price = $total_price + $vo['count']*$find_unitary['item_price'];
						$count++;
					}

					$error_code = 0;
					$data['total_price'] = $total_price;	// 购物车总价
					$data['count'] = $count;				// 购物车数量
				} else {
					$error_code = 1000;
					$data = '删除错误';
				}

				json_return($error_code, $data);
				break;

			case 'buy':		// 购买一条

				$cnum = isset($_REQUEST['cnum']) ? intval($_REQUEST['cnum']) : 0;

				$find_user = D('User')->where(array('uid'=>$this->user['uid']))->find();
				if (empty($find_user)) {
					$error_code = 2;
					json_return($error_code, '参数错误，请稍后重试');
					exit;
				}

				$where_cart = array(
					'uid' => $this->user['uid'],
					'state' => 0,
				);
				$cart_count = D('Unitary_cart')->where($where_cart)->count();
				if ($cart_count != $cnum) {
					$error_code = 1;
					$data['text'] = "商品有变动";
				} else {
					$cart_list = D('Unitary_cart')->where($where_cart)->select();
					$is_error = false;
					foreach ($cart_list as $vo) {
						$find_unitary = D('Unitary')->where(array('id'=>$vo['unitary_id']))->find();
						$where_cart2 = array(
							'state' => 1,
							'unitary_id' => $vo['unitary_id'],
						);
						$cart_list2 = D('Unitary_cart')->where($where_cart2)->select();
						$pay_count = 0;
						foreach ($cart_list2 as $vo2) {
							$this_order = D('Unitary_order')->where(array('pigcms_id'=>$vo2['order_id']))->find();
							if ($this_order['paid'] != 1 && $vo2['addtime'] < (time()-($this->$overTime))) {
								D('Unitary_cart')->where(array('id'=>$vo2['id']))->delete();
							} else {
								$pay_count = $pay_count + $vo2['count'];
							}
						}

						$unitary_ycount = $find_unitary['total_num'] - $pay_count;
						if ($vo['count'] > $unitary_ycount || $unitary_ycount == 0) {
							if ($unitary_ycount == 0) {
								$del_cart = D('Unitary_cart')->where(array("id"=>$vo['id']))->delete();
							}
							
							json_return(1000, $data);
							$is_error = false;
						} else {
							$is_error = true;
						}
					}

					if ($is_error) {
						if ($cnum > 10000) {
							$error_code = 1;
							$data['text'] = "单次购买不可超过1万";
						} else {
							$error_code = 0;
						}
					} else {
						$error_code = 1;
						$data['text'] = "商品有变动";
					}
				}

				json_return($error_code, $data);
				break;
		}
	}

	// 活动商品详情
	public function goods () {

		$unitary_id = isset($_REQUEST['unitary_id']) ? intval($_REQUEST['unitary_id']) : 0;

		$find_unitary = M('Unitary')->getUnitary($unitary_id);

		if (empty($unitary_id) || !$find_unitary = M('Unitary')->getUnitary($unitary_id)) {

			$find_unitary = D('Unitary')->order('renqi DESC')->limit(1)->find();
			if (empty($find_unitary)) {
				json_return(1000, '缺少参数，或未找到该活动');
			} else {
				json_return(1000, '缺少参数，或未找到该活动', array('store_id'=>$find_unitary['store_id']));
			}

		}

		$save_unitary['renqi'] = $find_unitary['renqi'] + 1;
		$update_unitary = D('Unitary')->where(array('id'=>$unitary_id))->data($save_unitary)->save();

		// switch ($find_unitary['state']) {
		// 	case "":
		// 		json_return(1000, '此商品已删除', array('store_id'=>$find_unitary['store_id']));
		// 		// $this->error("此商品已删除",U('Unitary/index',array('token'=>$this->token)));
		// 		exit;
		// 		break;
		// 	case '0':
		// 		json_return(1000, '此商品已暂停', array('store_id'=>$find_unitary['store_id']));
		// 		// $this->error("此商品已暂停",U('Unitary/index',array('token'=>$this->token)));
		// 		exit;
		// 		break;
		// 	case 2:
		// 		json_return(1000, '此商品已经结束', array('store_id'=>$find_unitary['store_id']));
		// 		// $this->redirect("Unitary/goodsover",array("token"=>$this->token,"unitaryid"=>$_GET['unitaryid']));
		// 		exit;
		// 		break;
		// }

		$unitary_pic = M('Unitary')->getPics($find_unitary);

		$pay_count = M('Unitary')->getPayCount($unitary_id);
		$cart_count = M('Unitary_cart')->getCount(array('uid'=>$this->user['uid'], 'store_id'=>$find_unitary['store_id'], 'state'=>0));

		$return = array();
		$return['unitary'] = $find_unitary;
		$return['unitary_pic'] = $unitary_pic;
		$return['pay_count'] = $pay_count;
		$return['cart_count'] = $cart_count;
		$return['left_count'] = $find_unitary['total_num'] - $pay_count;


		$return_url = urldecode($_REQUEST['url']);

		import('WechatShare');
		$share = new WechatShare();
		$share_data = $share->getSgin("", true, $return_url);

		$share_data['title'] = $find_unitary['name'];

		$share_data['content'] = '我正在参加【'.$find_unitary['name'].'】夺宝活动，快来一起夺宝吧';

		$share_data['logo'] = $find_unitary['logopic'];

		$return['share_data'] = $share_data;

		json_return(0, $return);

	}

	// 活动关联商品的html详情展示
	public function goodsinfo () {

		$unitary_id = isset($_REQUEST['unitary_id']) ? intval($_REQUEST['unitary_id']) : 0;

		if (empty($unitary_id) || !$find_unitary = M('Unitary')->getUnitary($unitary_id)) {
			json_return(1000, '缺少参数，或未找到该活动');
		}

		$product = M('Product')->get(array('store_id' => $find_unitary['store_id'], 'product_id' => $find_unitary['product_id'], 'status' => 1), 'info');

		$return = array();
		$return['info'] = $product['info'];

		json_return(0, $return);

	}

	// 添加到购物车
	public function goodsajax () {

		$type = isset($_REQUEST['type']) ? trim($_REQUEST['type']) : '';
		$is_platform = isset($_REQUEST['is_platform']) ? intval($_REQUEST['is_platform']) : 0;

		switch ($type) {
			case 'docart':
				$unitary_id = isset($_REQUEST['unitary_id']) ? intval($_REQUEST['unitary_id']) : 0;
				$where_cart = array(
					'uid' => $this->user['uid'],
					'unitary_id' => $unitary_id,
					'state' => 0,
				);
				$find_cart = D('Unitary_cart')->where($where_cart)->find();

				$find_unitary = M('Unitary')->getUnitary($unitary_id);
				if ($find_unitary['state'] != 1) {
					json_return(1000, '该活动已经结束或者关闭');
				}


				if (empty($find_cart)) {
					$add_cart = array(
						'uid' => $this->user['uid'],
						'unitary_id' => $unitary_id,
						'addtime' => time(),
						'count' => 1,
						'state' => 0,
						'store_id' => $find_unitary['store_id'],
					);
					$id_cart = D('Unitary_cart')->data($add_cart)->add();

				} else {
					$save_cart['count'] = $find_cart['count'] + 1;
					$update_cart = D('Unitary_cart')->where($where_cart)->data($save_cart)->save();
				}

				if ($is_platform == 0) {
					$where_cart2 = array(
						'uid' => $this->user['uid'],
						'state' => 0,
						'store_id' => $find_unitary['store_id'],
					);
				} else {
					$where_cart2 = array(
						'uid' => $this->user['uid'],
						'state' => 0,
					);
				}

				$cart_count = D('Unitary_cart')->where($where_cart2)->count('id');
				$data['count'] = $cart_count;

				json_return(0, $data);
				break;
		}

	}

	// 直接购买
	public function buygoods () {

		$unitary_id = isset($_REQUEST['unitary_id']) ? intval($_REQUEST['unitary_id']) : 0;

		if (empty($unitary_id) || !$find_unitary = M('Unitary')->getUnitary($unitary_id)) {
			json_return(1000, "缺少参数");
		}

		$where_cart = array(
			'uid' => $this->user['uid'],
			'unitary_id' => $unitary_id,
			'state' => 0,
			'store_id' => $find_unitary['store_id'],
		);
		$find_cart = D('Unitary_cart')->where($where_cart)->find();
		if (empty($find_cart)) {
			$add_cart = array(
				'uid' => $this->user['uid'],
				'unitary_id' => $unitary_id,
				'store_id' => $find_unitary['store_id'],
				'addtime' => time(),
				'count' => 1,
				'state' => 0,
			);
			$id_cart = D('Unitary_cart')->data($add_cart)->add();
			if ($id_cart > 0) {
				// 跳转到购物车
				json_return(0, "成功加入购物车");	//跳转到购物车地址
			} else {
				json_return(1, '直接购买失败，稍后再试');
			}

		} else {
			$save_cart['count'] = $find_cart['count'] + 1;
			$save_cart['count'] = $save_cart['count'] > 10000 ? 10000 : $save_cart['count'];
			$update_cart = D('Unitary_cart')->where($where_cart)->data($save_cart)->save();
			// 跳转到购物车
			json_return(0, "成功加入购物车"); //跳转到购物车地址
		}

	}

	// 分享点击方法
	public function goodswhere () {

		$unitary_id = isset($_REQUEST['unitary_id']) ? intval($_REQUEST['unitary_id']) : 0;
		$where_unitary['id'] = $unitary_id;
		$find_unitary = D('Unitary')->where($where_unitary)->find();

		$save_unitary['renqi'] = $find_unitary['renqi'] + 1;
		$update_unitary = D('Unitary')->where($where_unitary)->data($save_unitary)->save();
		$state = intval($find_unitary['state']);
		switch ($state) {
			case 0:	//此商品已被暂停
				redirect(option('config.site_url') . '/webapp/snatch/#/shoplist/'.$find_unitary['store_id']);
				break;
			case 1:		//此商品进行中
				redirect(option('config.site_url') . '/webapp/snatch/#/main/'.$unitary_id);
				break;
			case 2:		//此商品已结束 TODO
				redirect(option('config.site_url') . '/webapp/snatch/#/orderend/'.$unitary_id.'/'.$find_unitary['store_id']);
				break;
			default:
				redirect(option('config.site_url') . '/webapp/snatch/#/shoplist/'.$find_unitary['store_id']);
		}

	}

	// 进行中的活动显示
	public function goodsing () {

		$unitary_id = isset($_REQUEST['unitary_id']) ? intval($_REQUEST['unitary_id']) : 0;
		$page = max(1, $_REQUEST['page']);

		$limit = 10;
		$offset = ($page - 1) * $limit;

		if (empty($unitary_id)) {
			json_return(1000, '缺少活动ID unitary_id');
		}

		$find_unitary = M('Unitary')->getUnitary($unitary_id);
		if (empty($find_unitary)) {
			json_return(1000, '缺少活动ID unitary_id');
		}

		if ($find_unitary['state'] != 1) {
			json_return(1000, '活动已经结束或者尚未开始');
		}

		$find_unitary['pay_count'] = M('Unitary')->getPayCount($unitary_id);
		$find_unitary['left_count'] = $find_unitary['total_num'] - $find_unitary['pay_count'];

		$return = array();
		$return['unitary'] = $find_unitary;

		// 获取活动的所有抽奖记录
		$where_lucknum = array('unitary_id'=>$unitary_id);
		$lucknum_list = D('Unitary_lucknum')->where($where_lucknum)->limit($offset . ',' . $limit)->order('id DESC')->select();
		$count = D('Unitary_lucknum')->where($where_lucknum)->count('id');
		// foreach ($lucknum_list as &$v) {
		// 	$v['addtime'] = substr($v['addtime'], -3);
		// }

		$next_page = true;
		if (count($lucknum_list) < $limit) {
			$next_page = false;
		} else if ($offset >= $count) {
			$next_page = false;
		} else if ($offset + $limit == $count) {
			$next_page = false;
		}

		foreach ($lucknum_list as &$val) {
			$val['lucknum'] = 100000 + $val['lucknum'];
		}

		$return['lucknum'] = $lucknum_list;
		$return['cart_count'] = M('Unitary_cart')->getCount(array('uid'=>$this->user['uid'], 'store_id'=>$find_unitary['store_id'], 'state'=>0));
		$return['next_page'] = $next_page;

		json_return(0, $return);

	}

	// 结束的活动显示
	public function goodsover () {

		$unitary_id = isset($_REQUEST['unitary_id']) ? intval($_REQUEST['unitary_id']) : 0;
		$page = max(1, $_REQUEST['page']);

		$limit = 10;
		$offset = ($page - 1) * $limit;

		if (empty($unitary_id)) {
			json_return(1000, '缺少活动ID unitary_id');
		}

		$find_unitary = M('Unitary')->getUnitary($unitary_id);

		if (empty($find_unitary)) {
			json_return(1000, '缺少活动ID unitary_id');
		}

		if ($find_unitary['state'] == 0) {
			json_return(1000, '活动状态错误');
		}

		$time = time();
		if ($time < $find_unitary['endtime']) {		// 活动结束，倒计时内

			$opentime = $find_unitary['endtime'] - $time;
			$opentime_min = floor($opentime/60);
			$opentime_s = $opentime%60;

			// $unitary_pic = M('Unitary')->getPics($find_unitary);
			$pay_count = M('Unitary')->getPayCount($unitary_id);
			
			$return = array();
			$return['min'] = $opentime_min;
			$return['s'] = $opentime_s;
			$return['unitary'] = $find_unitary;
			// $return['unitary_pic'] = $unitary_pic;
			// $return['pay_count'] = $pay_count;

		} else {								// 活动结束并超出结束时间

			$where_lucknum = array(
				'unitary_id' => $find_unitary['id'],
				'state' => 1,
				'lucknum' => $find_unitary['lucknum'],
			);
			$find_lucknum = D('Unitary_lucknum')->where($where_lucknum)->find();

			$find_user = D('User')->where(array('uid'=>$find_lucknum['uid']))->find();

			$find_lucknum['name'] = !empty($find_user['nickname']) ? $find_user['nickname'] : '匿名用户';
			$find_lucknum['pic'] = !empty($find_user['avatar']) ? $find_user['avatar'] : option('config.site_url').'/static/images/avatar.png';

			$pay_count = M('Unitary')->getPayCount($unitary_id);

			$return = array();
			$return['unitary'] = $find_unitary;
			$return['lucker'] = $find_lucknum;
			// $return['pay_count'] = $pay_count;

		}
		
		$return['cart_count'] = M('Unitary_cart')->getCount(array('uid'=>$this->user['uid'], 'store_id'=>$find_unitary['store_id'], 'state'=>0));

		// 获取活动的所有抽奖记录
		$where_lucknum = array('unitary_id'=>$unitary_id);
		$lucknum_list = D('Unitary_lucknum')->where($where_lucknum)->limit($offset . ',' . $limit)->order('id DESC')->select();
		$count = D('Unitary_lucknum')->where($where_lucknum)->count('id');

		$next_page = true;
		if (count($lucknum_list) < $limit) {
			$next_page = false;
		} else if ($offset >= $count) {
			$next_page = false;
		} else if ($offset + $limit == $count) {
			$next_page = false;
		}

		foreach ($lucknum_list as &$val) {
			$val['lucknum'] = 100000 + $val['lucknum'];
		}

		$return['lucknum'] = $lucknum_list;
		$return['next_page'] = $next_page;

		json_return(0, $return);

	}

	// 个人中心
	public function my () {

		$user_info = D('User')->where(array('uid'=>$this->user['uid']))->find();

		$return = array();
		$return['name'] = $user_info['nickname'];
		$return['phone'] = $user_info['phone'];
		$return['avatar'] = !empty($user_info['avatar']) ? $user_info['avatar'] : option('config.site_url').'/static/images/avatar.png';

		json_return(0, $return);
	}

	// 购买记录 增加分页
	public function mypay () {

		$type = isset($_REQUEST['type']) ? trim($_REQUEST['type']) : '';
		$store_id = isset($_REQUEST['store_id']) ? intval($_REQUEST['store_id']) : 0;

		$page = max(1, $_REQUEST['page']);

		$limit = 10;
		$offset = ($page - 1) * $limit;

		// if (empty($store_id)) {
		// 	json_return(0, '缺少店铺ID');
		// }

		// 在该店铺中奖的活动ID数组
		$luck_unitary_arr = M('Unitary')->getLuckUnitaryArr($this->user['uid'], $store_id);

		$return = array();

		$time = time();
		if (!empty($store_id)) {
			$num_arr = M('Unitary')->getMyJoin($this->user['uid'], $time, $store_id);
		} else {
			$num_arr = M('Unitary')->getMyJoin($this->user['uid'], $time);
		}

		$return['cart_count_all'] = $num_arr['all'];
		$return['cart_count_ing'] = $num_arr['ing'];
		$return['cart_count_end'] = $num_arr['end'];
		$return['luck_count'] = $num_arr['luck'];

		// 当前购物车数量
		$where_cart_count = array('uid'=>$this->user['uid'], 'state'=>0);
		if (!empty($store_id)) {
			$where_cart_count = array_merge($where_cart_count, array('store_id'=>$store_id));
		}
		$return['cart_count'] = M('Unitary_cart')->getCount($where_cart_count);

		switch ($type) {

			case 'ing':

				$untiary = array();
				$where = array();
		    	$where[] = " j.uid = ".$this->user['uid']." ";
		    	$where[] = " u.state = 1 ";
		    	if (!empty($store_id)) {
		    		$where[] = " u.store_id = ".$store_id." ";
		    	}

		    	$where_str = implode(' and ', $where);
		    	$count = D('')->table('Unitary as u')
						->join("Unitary_join as j On u.id=j.unitary_id")
						->where($where_str)
						->count('u.id');

				$list = D('')->table('Unitary as u')
						->join("Unitary_join as j On u.id=j.unitary_id")
						->where($where_str)
						->field("u.*")
						->order("j.addtime desc")
						->limit($offset . ',' . $limit)
						->select();

				foreach ($list as $key => &$vo3) {
					$vo3['proportion'] = round($vo3['proportion'], 2);
					$vo3['count'] = D('Unitary_lucknum')->where(array('unitary_id'=>$vo3['id'], 'uid'=>$this->user['uid']))->count('id');
					$vo3['pay_count'] = M('Unitary')->getPayCount($vo3['id']);
					$vo3['is_luck'] = in_array($vo3['id'], $luck_unitary_arr) ? 1 : 0;
				}

				$return['unitary'] = $list;
				break;

			case 'end':

				$untiary = array();
				$where = array();
		    	$where[] = " j.uid = ".$this->user['uid']." ";
		    	$where[] = " u.state = 2 ";
		    	if (!empty($store_id)) {
		    		$where[] = " u.store_id = ".$store_id." ";
		    	}

		    	$where_str = implode(' and ', $where);
		    	$count = D('')->table('Unitary as u')
						->join("Unitary_join as j On u.id=j.unitary_id")
						->where($where_str)
						->count('u.id');

				$list = D('')->table('Unitary as u')
						->join("Unitary_join as j On u.id=j.unitary_id")
						->where($where_str)
						->field("u.*")
						->order("j.addtime desc")
						->limit($offset . ',' . $limit)
						->select();

				foreach ($list as $key => &$vo3) {

					$vo3['pay_count'] = M('Unitary')->getPayCount($vo3['id']);
					$vo3['is_luck'] = in_array($vo3['id'], $luck_unitary_arr) ? 1 : 0;

					if ($vo3['state'] == 2) {
						$where_lucknum = array(
							'unitary_id' => $vo3['id'],
							'lucknum' => $vo3['lucknum'],
						);
						$find_lucknum = D('Unitary_lucknum')->where($where_lucknum)->find();
						$find_user = D('User')->where(array('uid'=>$find_lucknum['uid']))->find();
						// $vo3['lucker'] = $find_user;
						$vo3['user_name'] = !empty($find_user['nickname']) ? anonymous(htmlspecialchars($find_user['nickname'])) : '匿名用户';
						$vo3['state'] = ($time < intval($vo3['endtime'])) ? 3 : $vo3['state'];
					}
				}

				$return['unitary'] = $list;
				break;

			case 'myluck':

				$luck = array();
				$cart_list = array();
				$unitary = array();
				$where_lucknum = array(
					'uid' => $this->user['uid'],
					'state' => 1,
				);
				if (!empty($store_id)) {
					$where_lucknum = array_merge($where_lucknum, array('store_id'=>$store_id));
				}
				$count = D('Unitary_lucknum')->where($where_lucknum)->count('id');
				$lucknum_list = D('Unitary_lucknum')->where($where_lucknum)->order('addtime desc')->limit($offset . ',' . $limit)->select();
				foreach ($lucknum_list as $key => $vo) {
					$find_unitary = M('Unitary')->getUnitary($vo['unitary_id']);
					$unitary[$key] = $find_unitary;
					if ($time > $find_unitary['endtime']) {
						$unitary[$key]['is_luck'] = in_array($vo['unitary_id'], $luck_unitary_arr) ? 1 : 0;
						$unitary[$key]['lucknum'] = 100000 + $find_unitary['lucknum'];
						// $unitary[$key]['pay_count'] = M('Unitary')->getPayCount($vo['unitary_id']);
					}
				}

				$return['unitary'] = $unitary;
				break;

			default:

				$untiary = array();
				$where = array();
		    	$where[] = " j.uid = ".$this->user['uid']." ";
		    	if (!empty($store_id)) {
		    		$where[] = " u.store_id = ".$store_id." ";
		    	}

		    	$where_str = implode(' and ', $where);

		    	$count = D('')->table('Unitary as u')
						->join("Unitary_join as j On u.id=j.unitary_id")
						->where($where_str)
						->count('u.id');

				$list = D('')->table('Unitary as u')
						->join("Unitary_join as j On u.id=j.unitary_id")
						->where($where_str)
						->field("u.*")
						->order("j.addtime desc")
						->limit($offset . ',' . $limit)
						->select();

				foreach ($list as $key => &$vo3) {
					
					$vo3['proportion'] = round($vo3['proportion'], 2);
					$vo3['count'] = D('Unitary_lucknum')->where(array('unitary_id'=>$vo3['id'], 'uid'=>$this->user['uid']))->count('id');
					$vo3['pay_count'] = M('Unitary')->getPayCount($vo3['id']);
					$vo3['is_luck'] = in_array($vo3['id'], $luck_unitary_arr) ? 1 : 0;

					if ($vo3['state'] == 2) {
						$where_lucknum = array(
							'unitary_id' => $vo3['id'],
							'lucknum' => $vo3['lucknum'],
						);
						$find_lucknum = D('Unitary_lucknum')->where($where_lucknum)->find();
						$find_user = D('User')->where(array('uid'=>$find_lucknum['uid']))->find();
						$vo3['lucknum'] = 100000 + $vo3['lucknum'];
						// $vo3['lucker'] = $find_user;
						$vo3['user_name'] = !empty($find_user['nickname']) ? anonymous(htmlspecialchars($find_user['nickname'])) : '匿名用户';
						$vo3['state'] = $vo3['state'] = ($time < intval($vo3['endtime'])) ? 3 : $vo3['state'];
					}

				}

				$return['unitary'] = $list;
				break;
		}

		$next_page = true;
		if (count($return['unitary']) < $limit) {
			$next_page = false;
		} else if ($offset >= $count) {
			$next_page = false;
		} else if ($offset + $limit == $count) {
			$next_page = false;
		}

		$return['next_page'] = $next_page;

		json_return(0, $return);

	}

	// 额外添加支付回调代替 POST payend
	public function payend () {

		$orderid = intval($_REQUEST['orderid']);
		// $uintary_id = intval($_REQUEST['unitary_id']);

		$myorder = D('Unitary_order')->where(array('pigcms_id'=>$orderid))->find();

		if (!empty($myorder['addtime'])) {		// 支付成功则修改为0
			ini_set("memory_limit","-1");
			$cart_list = D('Unitary_cart')->where(array('state'=>1,'order_id'=>$orderid))->order('id')->select();
			if (empty($cart_list)) {
				D('Unitary_order')->where(array('pigcms_id'=>$orderid))->delete();
			}

			foreach ($cart_list as $key => $val) {

				$unitary = D('Unitary')->where(array('id'=>$val['unitary_id']))->find();
				
				$lucknum_array = S('LUCKNUM_ARRAY_'.$val['unitary_id']);
				if (empty($lucknum_array) || count($lucknum_array) != (D('Unitary_lucknum')->where(array('unitary_id'=>$val['unitary_id']))->count('id'))) {
					$lucknum_array = array();
					$lucknum_list = D('Unitary_lucknum')->where(array('unitary_id'=>$val['unitary_id']))->field('lucknum')->select();
					foreach ($lucknum_list as $lv) {
						$lv['lucknum'] = $lv['lucknum'] ? $lv['lucknum'] : 0;
						$lucknum_array[] = intval($lv['lucknum']);
					}
					S('LUCKNUM_ARRAY_'.$val['unitary_id'], $lucknum_array);
				}
				
				$lucknum_cart_count = D('Unitary_lucknum')->where(array('uid'=>$myorder['uid'],'order_id'=>$orderid,'cart_id'=>$val['id'],'unitary_id'=>$val['unitary_id']))->count('id');
				$val['count_s'] = $val['count'] - $lucknum_cart_count;
				
				if (count($lucknum_array) < $unitary['total_num']) {
				
					$lucknum_qc = S('LUCKNUM_QC_'.$val['unitary_id']);
					if(empty($lucknum_qc) || count($lucknum_qc) != $unitary['total_num'] - count($lucknum_array)){
						$unitary_price_array = range(0,($unitary['total_num']-1));		//TODO 逻辑??
						$lucknum_qc = array_diff_fast($unitary_price_array,$lucknum_array);
						$lucknum_qc = $lucknum_qc ? $lucknum_qc : $unitary_price_array;
						S('LUCKNUM_QC_'.$val['unitary_id'], $lucknum_qc);
					}
				
				} else {
					$lucknum_qc = range($unitary['total_num']+1, $unitary['total_num']*2);	//TODO 逻辑??
				}
				
				
				$this_lucknum_array = null;
				$add_all_lucknum = null;
				if (intval($val['count_s']) > 0) {
					if ($val['count_s'] == 1) {
						$this_lucknum_array[] = array_rand($lucknum_qc, $val['count_s']);
					} else {
						$this_lucknum_array = array_rand($lucknum_qc, $val['count_s']);
					}

					foreach ($this_lucknum_array as $tlak => $tlav) {
						$add_all_lucknum[$tlak]['store_id'] = $myorder['store_id'];
						$add_all_lucknum[$tlak]['uid'] = $myorder['uid'];
						$add_all_lucknum[$tlak]['order_id'] = $orderid;
						$add_all_lucknum[$tlak]['cart_id'] = $val['id'];
						$add_all_lucknum[$tlak]['unitary_id'] = $val['unitary_id'];
						list($s1, $s2) = explode(' ', microtime());
						$mtime = (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
						$add_all_lucknum[$tlak]['addtime'] = $mtime;
						if (count($lucknum_qc) > 0) {
							$add_all_lucknum[$tlak]['lucknum'] = $tlav;
							unset($lucknum_qc[$add_all_lucknum[$tlak]['lucknum']]);
							$lucknum_array[] = intval($add_all_lucknum[$tlak]['lucknum']);
						} else {
							$max_lucknum = D('Unitary_lucknum')->where(array('unitary_id'=>$val['unitary_id']))->order('lucknum desc')->find();
							$add_all_lucknum[$tlak]['lucknum'] = $max_lucknum['lucknum'] + 1;
							$lucknum_array[] = intval($add_all_lucknum[$tlak]['lucknum']);
						}
						$add_all_lucknum[$tlak]['state'] = 0;
					}

					if (count($add_all_lucknum) > 1000) {
						$add_all_lucknum_chunk = array_chunk($add_all_lucknum,1000);
						foreach ($add_all_lucknum_chunk as $add_all_val) {
							$allid = D('Unitary_lucknum')->data($add_all_val)->addAll();
						}
					} else {
						D('Unitary_lucknum')->data($add_all_lucknum)->addAll();
					}
					
					S('LUCKNUM_ARRAY_'.$val['unitary_id'], $lucknum_array);
					S('LUCKNUM_QC_'.$val['unitary_id'], $lucknum_qc);
						
						$pay_count = D('Unitary_lucknum')->where(array('unitary_id'=>$val['unitary_id']))->count('id');
						$save_unitary2['proportion'] = $pay_count/$unitary['total_num']*100;
						$update_unitary2 = D('Unitary')->where(array('id'=>$val['unitary_id']))->data($save_unitary2)->save();
						if ($pay_count >= $unitary['total_num'] && $unitary['state'] != 2) {

							$where_lucknum_all['store_id'] = $myorder['store_id'];
							$lucknum_all_count = D('Unitary_lucknum')->where($where_lucknum_all)->count('id');
							if($lucknum_all_count < 100){
								$save_unitary['lastnum'] = $lucknum_all_count;
							}else{
								$save_unitary['lastnum'] = 100;
							}
							
							$lucknum_all = D('Unitary_lucknum')->where($where_lucknum_all)->order('addtime desc')->limit($save_unitary['lastnum'])->select();
							$save_unitary['lasttime'] = $lucknum_all[0]['id'];
							$sum = 0;
							foreach ($lucknum_all as $avo) {
								$thistime = floor($avo['addtime']/1000);
								$ms = substr($avo['addtime'],-3);
								$sum = $sum + (date('H',$thistime).date('i',$thistime).date('s',$thistime).$ms);
								D('Unitary_lucknum_caculate')->data(array(
									'lucknum_id' => $avo['id'],
									'lucknum' => $avo['lucknum'],
									'addtime' => $avo['addtime'],
									'unitary_id' => $avo['unitary_id'],
									'uid' => $avo['uid'],
									'store_id' => $avo['store_id'],
								))->add();
							}
							$lucknum = fmod($sum,$unitary['total_num']);
							$save_unitary['lucknum'] = $lucknum;
							$save_unitary['state'] = 2;
							$save_unitary['endtime'] = time()+$unitary['opentime'];
							
							$where_cart3['state'] = 0;
							$where_cart3['unitary_id'] = $val['unitary_id'];
							$del_cart3 = D('Unitary_cart')->where($where_cart3)->delete();
							$save_unitary['proportion'] = 100;
							$update_unitary = D('Unitary')->where(array('id'=>$val['unitary_id']))->data($save_unitary)->save();
							$where_lucknum2['unitary_id'] = $val['unitary_id'];
							$where_lucknum2['store_id'] = $myorder['store_id'];
							$where_lucknum2['lucknum'] = $lucknum;
							$where_lucknum2['state'] = 0;
							$save_lucknum2['state'] = 1;
							$update_lucknum2 = D('Unitary_lucknum')->where($where_lucknum2)->data($save_lucknum2)->save();
							$where_lucknum2['state'] = 1;
							$find_lucknum2 = D('Unitary_lucknum')->where($where_lucknum2)->find();

						}
						
						$up_save = array('addtime'=>0, 'paid'=>1);
						$update_order = D('Unitary_order')->where(array('pigcms_id'=>$orderid))->data($up_save)->save();

					
				}else{
					$up_save = array('addtime'=>0, 'paid'=>1);
					$update_order = D('Unitary_order')->where(array('pigcms_id'=>$orderid))->data($up_save)->save();
					
				}

				M('Unitary')->updateUserJoin($orderid);	// 更新关联关系到 unitary_join表

				// 触发构造活动订单
				$create_order = M('Unitary')->unitaryAddOrder($val['unitary_id']);
			}
			
			// $return_url = option('config.site_url').'/webapp.php?c=unitary&a=db_order_paid&orderid='.$myorder['orderid'];
			$return_url = option('config.site_url').'/wap/db_order_paid.php?orderid='.$myorder['orderid'];
			redirect($return_url);

		} else {	// 该单已经支付

			M('Unitary')->updateUserJoin($myorder['orderid']);	// 更新关联关系到 unitary_join表
			// $return_url = option('config.site_url').'/webapp.php?c=unitary&a=db_order_paid&orderid='.$myorder['orderid'];
			$return_url = option('config.site_url').'/wap/db_order_paid.php?orderid='.$myorder['orderid'];
			redirect($return_url);

		}

	}


	// 购买
	public function dobuy () {

		// $store_id = isset($_REQUEST['store_id']) ? intval($_REQUEST['store_id']) : 0;
		// if (empty($store_id)) {
		// 	json_return(1000, "缺少参数");
		// }

		$cart_ids = isset($_REQUEST['cart_ids']) ? $_REQUEST['cart_ids'] : array();
		// $cart_ids = json_decode($cart_ids);

		if (empty($cart_ids)) {
			pigcms_tips('需要提交参数');
		}

		$where_cart = array(
			'uid' => $this->user['uid'],
			'state' => 0,
			'id' => array('in', $cart_ids)
		);
		$cart_list = D('Unitary_cart')->where($where_cart)->select();
		
		// 判断并过滤，不属于同一店铺的记录，并获取 store_id
		$store_ids = array();
		foreach ($cart_list as $val) {
			$store_ids[$val['store_id']] = $val['store_id'];
		}
		
		if (count($store_ids) != 1) {
			pigcms_tips('只允许提交同一店铺的购物记录');
		}

		$store_id = array_pop($store_ids);


		// 清除该店铺 该用户 所有无关联订单的 购物state=1记录
		$where_order = array(
			'store_id' => $store_id,
			'uid' => $this->user['uid'],
			'paid' => 0,
		);
		$order_list = D('Unitary_order')->where($where_order)->select();
		if (!empty($order_list)) {
			foreach ($order_list as $val) {
				D('Unitary_cart')->where(array('order_id'=>$val['pigcms_id'], 'state'=>1, 'uid'=>$this->user['uid']))->delete();
			}
			$del_order = D('Unitary_order')->where(array('pigcms_id'=>$val['pigcms_id'], 'paid'=>0, 'uid'=>$this->user['uid']))->delete();
		}

		// 原始逻辑 只删除订单
		// $where_order = array(
		// 	'store_id' => $store_id,
		// 	'uid' => $this->user['uid'],
		// 	'paid' => 0,
		// );
		// $del_order = D('Unitary_order')->where($where_order)->delete();

		$total = 0;
		$total_price = 0;
		foreach ($cart_list as $vo) {
			if ($vo['count'] > 10000) {
				$vo['count'] = 10000;
				D('Unitary_cart')->where(array('store_id'=>$store_id,'id'=>$vo['id']))->data(array('count'=>$vo['count']))->save();
			}

			$find_unitary = M('Unitary')->getUnitary($vo['unitary_id']);

			$total = $total + $vo['count'];

			$price = $price + $vo['count']*$find_unitary['item_price'];

			$where_cart2 = array(
				'unitary_id' => $vo['unitary_id'],
				'store_id' => $store_id,
				'state' => 1,
			);
			$cart_list2 = D('Unitary_cart')->where($where_cart2)->select();
			$pay_count = 0;
			foreach ($cart_list2 as $cvo) {
				$this_order = D('Unitary_order')->where(array('store_id'=>$store_id,'pigcms_id'=>$cvo['order_id']))->find();
				if ($this_order['paid'] != 1 && $vo['addtime'] < (time()-($this->overTime))) {
					D('Unitary_cart')->where(array('store_id'=>$store_id,'id'=>$cvo['id']))->delete();
				} else {
					$pay_count = $pay_count + $cvo['count'];
				}
			}

			$unitary_ycount[$vo['id']] = $find_unitary['total_num'] - $pay_count;
			if ($unitary_ycount[$vo['id']] < $vo['count']) {
				$cha = $vo['count'] - $unitary_ycount[$vo['id']];
				$total = $total - $cha;
				$price = $price - $cha*$find_unitary['item_price'];
				$where_save_cart = array(
					'id' => $vo['id'],
					'store_id' => $store_id,
				);
				$update_cart = D('Unitary_cart')->where($where_save_cart)->data(array('count'=>$unitary_ycount[$vo['id']]))->save();
			}
		}
		if ($total <= 0) {
			pigcms_tips('商品被抢，请重新下单');
		}

		$add_order = array(
			'store_id' => $store_id,
			'uid' => $this->user['uid'],
			'price' => $price,
			'addtime' => time(),
		);
		
		$id_order = D('Unitary_order')->data($add_order)->add();
		
		$randnum = rand(1000,9999);
		$save_order['orderid'] = $id_order."UNITARY".time().$randnum;
		$update_order = D('Unitary_order')->where(array('pigcms_id'=>$id_order))->data($save_order)->save();
		if ($id_order > 0) {
			$save_cart = array(
				'state' => 1,
				'order_id' => $id_order,
				'addtime' => time(),
			);
			$update_cart = D('Unitary_cart')->where($where_cart)->data($save_cart)->save();
			if ($update_cart > 0) {

				$params = array(
					"store_id" => $store_id,
					"price" => $total,
					"uid" => $this->user['uid'],
					"from" => "Unitary",
					"orderid" => $save_order['orderid'],
					"single_orderid" => $save_order['orderid'],
					"notOffline" => 1,
				);
				
				// 跳转支付，选择收货地址
				$redirect = option('config.site_url').'/wap/unitary_order.php?orderid='.$save_order['orderid'];

				// redirect($redirect);
				json_return(0, array('url'=>$redirect));

			}

			json_return(1000, '参数错误，请重新下单。');
		}

		json_return(1000, '参数错误，请重新下单');
	}

	// 购物车追加
	public function zhuijia () {

		$unitary_id = isset($_REQUEST['unitary_id']) ? intval($_REQUEST['unitary_id']) : 0;
		$buynum = abs(intval($_REQUEST['buynum']));

		if (empty($unitary_id) || !$find_unitary = M('Unitary')->getUnitary($unitary_id)) {
			json_return(1000, '缺少参数');
		}

		if (empty($buynum)) {
			json_return(1000, "数量请填写正整数");
		}

		$mycart = D('Unitary_cart')->where(array('uid'=>$this->user['uid'], 'unitary_id'=>$unitary_id, 'state'=>0))->find();
		if (empty($mycart)) {
			$add_cart = array(
				'uid' => $this->user['uid'],
				'count' => $buynum,
				'store_id' => $find_unitary['store_id'],
				'addtime' => time(),
			);

			$add_cart['count'] = $add_cart['count'] > 9999 ? 10000 : $add_cart['count'];
			$add_cart['unitary_id'] = $unitary_id;
			$id_cart = D('Unitary_cart')->data($add_cart)->add();
		} else {
			$upcart = D('Unitary_cart')->where(array('id'=>$mycart['id']))->data(array('count'=>($mycart['count'] + $buynum)))->save();
		}


		$where_cart2 = array(
			'uid' => $this->user['uid'],
			'state' => 0,
			'store_id' => $find_unitary['store_id'],
		);
		$cart_count = D('Unitary_cart')->where($where_cart2)->count('id');

		json_return(0, array('count'=>$cart_count));

	}

	// 某活动的参与记录
	public function buyres () {

		$unitary_id = isset($_REQUEST['unitary_id']) ? intval($_REQUEST['unitary_id']) : 0;
		$store_id = isset($_REQUEST['store_id']) ? intval($_REQUEST['store_id']) : 0;

		$page = max(1, $_REQUEST['page']);

		$limit = 10;
		$offset = ($page - 1) * $limit;

		if (empty($unitary_id)) {
			json_return(1000, '缺少参数');
		}


		$where_cart = array(
			'state' => 1,
			'unitary_id' => $unitary_id,
		);
		$count = D('Unitary_cart')->where($where_cart)->count('id');
		$cart_list = M('Unitary_cart')->getList($where_cart, '', $limit, $offset);

		foreach ($cart_list as $k => $vo) {

			$find_user = D('User')->where(array('uid'=>$vo['uid']))->find();
			$cart_list[$k]['pic'] = !empty($find_user['avatar']) ? $find_user['avatar'] : option('config.site_url')."/template/index/default/images/avatar.png";
			$cart_list[$k]['user_name'] = !empty($find_user['nickname']) ? $find_user['nickname'] : '匿名用户';

			$where_lucknum = array(
				'uid' => $vo['uid'],
				'unitary_id' => $unitary_id,
				'order_id' => $vo['order_id'],
			);
			$cart_list[$k]['count'] = D('Unitary_lucknum')->where($where_lucknum)->count();
			$this_order = D('Unitary_order')->where(array('pigcms_id'=>$vo['order_id']))->find();

			// 数据结构错误
			if (!empty($this_order)) {

				if ($this_order['paid'] != 1 && $vo['addtime'] < (time()-($this->$overTime))) {
					D('Unitary_order')->where(array('id'=>$vo['id']))->delete();
				}

				if ($this_order['paid'] == 1) {
					$tishi = '';
				} else {
					$tishi = '(未付款)';
				}

				$cart_list[$k]['count'] = $cart_list[$k]['count'] ? $cart_list[$k]['count'] : $vo['count'].$tishi;

			} else {

				$cart_list[$k]['count'] = $cart_list[$k]['count'] ? $cart_list[$k]['count'] : $vo['count'];

			}

			
		}

		$next_page = true;
		if (count($cart_list) < $limit) {
			$next_page = false;
		} else if ($offset >= $count) {
			$next_page = false;
		} else if ($offset + $limit == $count) {
			$next_page = false;
		}

		$return = array();
		$return['cart_list'] = $cart_list;

		$whereCount = array('uid'=>$this->user['uid'], 'state'=>0);
		if (!empty($store_id)) {
			$whereCount = array_merge($whereCount, array('store_id'=>$store_id));
		}
	
		$cart_count = M('Unitary_cart')->getCount($whereCount);
		$return['cart_count'] = $cart_count;
		$return['next_page'] = $next_page;
		$return['store_id'] = $store_id;
		// dump($return);exit;
		json_return(0, $return);

	}

	// 计算结果
	public function goodsresult () {

		$where_unitary['id'] = isset($_REQUEST['unitary_id']) ? intval($_REQUEST['unitary_id']) : 0;

		$return = array();
		$find_unitary = D('Unitary')->where($where_unitary)->find();
		$return['unitary'] = $find_unitary;

		switch ($find_unitary['state']) {
			case "":
				$this->error("此商品已删除",U('Unitary/index',array('token'=>$this->token)));
				exit;
				break;
			case 0:
				$this->error("此商品已删除",U('Unitary/index',array('token'=>$this->token)));
				exit;
				break;
			case 1:
				$this->success("此商品还在进行中",U('Unitary/goodswhere',array('token'=>$this->token,'unitaryid'=>$_GET['unitaryid'])));
				exit;
				break;
		}
		$where_lucknum1['id'] = array("gt", $find_unitary['lasttime']);
		$lucknum_list1 = D('Unitary_lucknum')->where($where_lucknum1)->order("id desc")->limit(5)->select();
		$i1 = 0;
		foreach ($lucknum_list1 as $vo1) {
			$where_userinfo['token'] = $this->token;
			$where_userinfo['wecha_id'] = $vo1['wecha_id'];
			$find_userinfo = $this->m_userinfo->where($where_userinfo)->find();
			$find_user = $this->m_user->where($where_userinfo)->find();
			if($find_user['name'] == null){
				$lucknum_list1[$i1]['name'] = $find_userinfo['wechaname'];
			}else{
				$lucknum_list1[$i1]['name'] = $find_user['name'];
			}
			$i1++;
		}
		$this->assign("list1",$lucknum_list1);
		$where_lucknum2['id'] = array("elt",$find_unitary['lasttime']);
		$where_lucknum2['token'] = $this->token;
		$lucknum_list2 = D('Unitary_lucknum')->where($where_lucknum2)->order("id desc")->limit($find_unitary['lastnum'])->select();
		$i2 = 0;
		foreach($lucknum_list2 as $vo2){
			$where_userinfo['token'] = $this->token;
			$where_userinfo['wecha_id'] = $vo2['wecha_id'];
			$find_userinfo = $this->m_userinfo->where($where_userinfo)->find();
			$find_user = $this->m_user->where($where_userinfo)->find();
			if($find_user['name'] == null){
				$lucknum_list2[$i2]['name'] = $find_userinfo['wechaname'];
			}else{
				$lucknum_list2[$i2]['name'] = $find_user['name'];
			}
			$i2++;
		}
		
		$sum = 0;
		foreach($lucknum_list2 as $vo){
			$thistime = floor($vo['addtime']/1000);
			$ms = substr($vo['addtime'],-3);
			$sum = $sum + (date('H',$thistime).date('i',$thistime).date('s',$thistime).$ms);
		}
		$lucknum = fmod($sum,$find_unitary['price']);
		if($lucknum != $find_unitary['lucknum']){
			$lucknum_error = $lucknum - $find_unitary['lucknum'];
			$sum = $sum - $lucknum_error;
			$lucknum_list2[(count($lucknum_list2)-1)]['addtime'] = $lucknum_list2[(count($lucknum_list2)-1)]['addtime'] - $lucknum_error;
			$lucknum = $lucknum - $lucknum_error;
		}
		$this->assign("list2",$lucknum_list2);
		$this->assign("sum",$sum);
		$this->assign("lucknum",$lucknum);
		$where_lucknum3['id'] = array("lt", $lucknum_list2[$find_unitary['lastnum']-1]['id']);
		$where_lucknum3['token'] = $this->token;
		$lucknum_list3 = D('Unitary_lucknum')->where($where_lucknum3)->order("id desc")->limit(5)->select();
		$i3 = 0;
		foreach ($lucknum_list3 as $vo3) {
			$where_userinfo['token'] = $this->token;
			$where_userinfo['wecha_id'] = $vo2['wecha_id'];
			$find_userinfo = $this->m_userinfo->where($where_userinfo)->find();
			$find_user = $this->m_user->where($where_userinfo)->find();
			if($find_user['name'] == null){
				$lucknum_list3[$i3]['name'] = $find_userinfo['wechaname'];
			}else{
				$lucknum_list3[$i3]['name'] = $find_user['name'];
			}
			$i3++;
		}
		$this->assign("list3",$lucknum_list3);

	}

	// 用户的收货地址列表
	public function listaddress () {

		$user_address = M('User_address')->getMyAddress($this->user['uid']);

		$return = array();
		$return['address_list'] = $user_address;

		json_return(0, $return);

	}

	// 移动端首页
	public function home () {

		// 幻灯图
		$adverTop = M('Adver')->get_adver_by_key('wap_indiana_adver', 8);

		// 最新揭晓
		$topNew = M('Unitary')->getWapLastFinish(3);

		// 上架新品
		$unitaryNew = M('Unitary')->getListByKey('wap_indiana_order', 3);

		// 今日热门
		$unitaryHot = M('Unitary')->getWapHot(16);

		// 增加专区icon
		$area_icons = M('Unitary')->getArea();
        $area_ids =  array_flip($area_icons);
		foreach ($unitaryHot as &$val) {
			if (in_array($val['item_price'], $area_ids)) {
				$val['has_icon'] = 1;
				$val['icon'] = $area_icons[$val['item_price']];
			} else {
				$val['has_icon'] = 0;
				$val['icon'] = '';
			}
		}

		// 购物车数量
		$where_cart2 = array('uid'=>$this->user['uid'], 'state'=>0);
		$cart_count = D('Unitary_cart')->where($where_cart2)->count('id');

		$return = array();
		$return['adver'] = $adverTop;
		$return['last_end'] = $topNew;
		$return['new'] = $unitaryNew;
		$return['hot'] = $unitaryHot;
		$return['count'] = $cart_count;

		json_return(0, $return); 
	}

	// 分类页面
	public function catelist () {

		$cat_id = isset($_REQUEST['cat_id']) ? intval($_REQUEST['cat_id']) : 0;

		$order_by = !empty($_REQUEST['order_by']) ? trim($_REQUEST['order_by']) : 'renqi';
		$page = max(1, $_REQUEST['page']);

		$limit = 10;
		$offset = ($page - 1) * $limit;

		// 分类 + 当前分类
        $categoryListFull = F('pc_product_category_full');
        $categoryListFull = array();
        if (empty($categoryListFull)) {
            $categoryListFull = M('Product_category')->getAllCategory(99, true);

            if (!$categoryListFull) {
                $categoryListFull = array();
            }
            F('pc_product_category_full', $categoryListFull);
        }

        $filterList = array();
        $cat_all['cat_id'] = 0;
        $cat_all['cat_name'] = '全部';
        $cat_all['on'] = ($cat_id == 0) ? 1 : 0;
        $filterList[] = $cat_all;
        foreach ($categoryListFull as $val) {
        	$tmp_list['cat_name'] = $val['cat_name'];
        	$tmp_list['cat_id'] = $val['cat_id'];
        	$tmp_list['on'] = ($cat_id == $val['cat_id']) ? 1 : 0;
        	$filterList[] = $tmp_list;
        }

        $return = array();
        $return['cat_list'] = $filterList;

        // 当前排序方式
        // $order_by_arr = M('Unitary')->getSort($order_by);
		switch ($order_by) {
			case 'renqi':
				$order_by = "renqi desc";
				break;
			case 'proportion':
				$order_by = "proportion desc";
				break;
			case 'priceup':
				$order_by = "price desc";
				break;
			case 'pricedown':
				$order_by = "price";
				break;
			case 'addtime':
				$order_by = "addtime desc";
				break;
			default:
				$order_by = "renqi desc";
		}

		// 排序方式 无需再传回 排序方式列表
		// $return['order_by_list'] = $order_by_arr;
        
		// 列表
		$unitary_where['state'] = 1;
		if (!empty($cat_id)) {
			$unitary_where['cat_fid'] = $cat_id;
		}

		$count = M('Unitary')->getCount($unitary_where);
		$list = M('Unitary')->getList($unitary_where, $order_by, $limit, $offset);

		// 增加专区icon
		$area_icons = M('Unitary')->getArea();
        $area_ids =  array_flip($area_icons);

		foreach ($list as $key => $val) {
			// 参与者
			$pay_count = M('Unitary')->getPayCount($val['id']);
			$list[$key]['pay_count'] = $pay_count;
			// 剩余
			$list[$key]['left_count'] = $val['total_num'] - $pay_count;
			$list[$key]['proportion'] = round($list[$key]['proportion'], 2);

			if (in_array($val['item_price'], $area_ids)) {
				$list[$key]['has_icon'] = 1;
				$list[$key]['icon'] = $area_icons[$val['item_price']];
			} else {
				$list[$key]['has_icon'] = 0;
				$list[$key]['icon'] = '';
			}
		}

		$return['list'] = $list;

		$next_page = true;
		if (count($list) < $limit) {
			$next_page = false;
		} else if ($offset >= $count) {
			$next_page = false;
		} else if ($offset + $limit == $count) {
			$next_page = false;
		}
		$return['next_page'] = $next_page;

		$where_cart2 = array('uid'=>$this->user['uid'], 'state'=>0);
		$cart_count = D('Unitary_cart')->where($where_cart2)->count('id');

		$return['count'] = $cart_count;

        json_return(0, $return); 
	}

	// 搜索列表
	public function search () {

		$keyword = isset($_REQUEST['keyword']) ? trim($_REQUEST['keyword']) : '';
		if (empty($keyword)) {
			json_return(1000, '请输入搜索内容');
		}

		$page = max(1, $_REQUEST['page']);

		$limit = 10;
		$offset = ($page - 1) * $limit;

		// 增加专区icon
		$area_icons = M('Unitary')->getArea();
        $area_ids =  array_flip($area_icons);

		$unitary_where['state'] = 1;
        $unitary_where['_string'] = " `name` LIKE '%" . $keyword . "%'";

		$count = M('Unitary')->getCount($unitary_where);
		$list = M('Unitary')->getList($unitary_where, 'id desc', $limit, $offset);

		foreach ($list as $key => $val) {

			// 参与者
			$pay_count = M('Unitary')->getPayCount($val['id']);
			$list[$key]['pay_count'] = $pay_count;
			// 剩余
			$list[$key]['left_count'] = $val['total_num'] - $pay_count;
			$list[$key]['proportion'] = round($list[$key]['proportion'], 2);

			if (in_array($val['item_price'], $area_ids)) {
				$list[$key]['has_icon'] = 1;
				$list[$key]['icon'] = $area_icons[$val['item_price']];
			} else {
				$list[$key]['has_icon'] = 0;
				$list[$key]['icon'] = '';
			}

		}

		$return = array();
		$return['list'] = $list;
		$return['list_total'] = $count;
		$return['keyword'] = $keyword;

		$next_page = true;
		if (count($list) < $limit) {
			$next_page = false;
		} else if ($offset >= $count) {
			$next_page = false;
		} else if ($offset + $limit == $count) {
			$next_page = false;
		}
		$return['next_page'] = $next_page;

		// 购物车数量
		$where_cart2 = array('uid'=>$this->user['uid'], 'state'=>0);
		$cart_count = D('Unitary_cart')->where($where_cart2)->count('id');
		$return['count'] = $cart_count;

		json_return(0, $return);
	}

}
?>