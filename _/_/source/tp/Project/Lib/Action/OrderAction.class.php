<?php
/**
 * 订单
 * User: pigcms_21
 * Date: 2015/3/18
 * Time: 10:32
 */

class OrderAction extends BaseAction
{
	
	public function _initialize() 
	{
		parent::_initialize();
		
		$this->check = array('1' => '未对账', '2' => '已对账');

		//未处理的提现记录

		// 区域管理员 只能查看自己区域的店铺
		$whereWithDrawal = array();
        if ($this->admin_user['type'] == 2) {
            $store_ids = D('Admin')->getAreaStoreIds($this->admin_user);
            if (!empty($store_ids)) {
                $whereWithDrawal['store_id'] = array('in', $store_ids);
            } else {
                $whereWithDrawal['store_id'] = false;
            }
        } else if ($this->admin_user['type'] == 3) {    // 代理商 只能查看自己关联用户的店铺
            $store_ids = D("Admin")->getAgentStoreIds($this->admin_user);
            if (!empty($store_ids)) {
                $whereWithDrawal['store_id'] = array('in', $store_ids);
            } else {
                $whereWithDrawal['store_id'] = false;
            }
        }

        $whereWithDrawal = !empty($whereWithDrawal) ? array_merge($whereWithDrawal, array('status' => 1,'supplier_id'=>0)) : array('status' => 1,'supplier_id'=>0);

		$withdrawal_count = M('StoreWithdrawal')->where($whereWithDrawal)->count('pigcms_id');
		$this->assign('withdrawal_count', $withdrawal_count);
	}

	//账务概况
	public function dashboard()
	{
		$common_data      = D('CommonData');
		$store_withdrawal = D('StoreWithdrawalView');
		$order = D('Order');

		//已提现总额
		$where = array();
		$where['key'] = 'withdrawal';
		$withdrawal_total = $common_data->getData($where);

		//供货商在平台的余额
		$where['drp_supplier_id']  = 0;
		$where['balance'] = array('gt', 0);
		$balance = M('Store')->where($where)->sum('balance');
		//向平台提现但未处理的金额
		$where = array();
		$where['type']   = 1;
		$where['status'] = 1;
		$withdrawal_pending_total = $store_withdrawal->getAmount($where);
		//待提现总额(供货商在平台的余额 + 向平台提现但未处理的金额)
		$unwithdrawal_total = $balance + $withdrawal_pending_total;

		//累计收入
		$where = array();
		$where['key'] = 'income';
		$platform_income = $common_data->getData($where);

		//供货商在平台的待结算余额
		$where = array();
		$where['drp_supplier_id'] = 0;
		$where['unbalance'] = array('gt', 0);
		$platform_unbalance = M('Store')->where($where)->sum('unbalance');

		//平台总资产
		$where = array();
		$where['key'] = 'total';
		$income_total = $common_data->getData($where);
		//减已提现金额
		$income_total -= $withdrawal_total;
		//加服务费
		$where = array();
		$where['type']    = 1;
		$where['status']  = 3;
		$service_fee = $store_withdrawal->getServiceFee($where);
		$income_total += $service_fee;
		$income_total = ($income_total > 0) ? $income_total : 0;

		//平台提现备付金
		$where = array();
		$where['key'] = 'cash_provision_balance';
		$cash_provision_balance = $common_data->getData($where);
		$cash_provision_balance = number_format($cash_provision_balance, 2, '.', '');

		$today = date('Y-m-d');
		$today = strtotime($today . ' 00:00:00');
		$where = array();
		$where['type'] = 0;
		$where['add_time'] = array('egt', $today);
		$today_cash_provision = M('CashProvisionLog')->where($where)->sum('amount');
		$today_cash_provision = number_format($today_cash_provision, 2, '.', '');

		//近一个月交易流水曲线
		$days = array();
		for ($i = 29; $i >= 0; $i--) {
			$day = date("Y-m-d", strtotime('-' . $i . 'day'));
			$days[] = $day;
		}
		$days_30_pay          = array();
		$days_30_income       = array();
		$days_30_unwithdrawal = array();
		$days_30_withdrawal   = array();
		foreach ($days as $day) {
			//开始时间
			//$start_time = strtotime($day . ' 00:00:00');
			//结束时间
			$stop_time = strtotime($day . ' 23:59:59');

			//平台入账(截止结束时间，累计统计)
			$where = array();
			$where['useStorePay']   = 0;
			$where['user_order_id'] = 0;
			$where['status']        = array('in', array(2,3,4,6,7));
			$where['_string']       = "add_time <= '" . $stop_time . "'";
			$tmp_days_30_pay = $order->getOrderAmount($where);
			$days_30_pay[]   = number_format($tmp_days_30_pay, 2, '.', '');

			//已提现总额(截止结束时间，累计统计)
			$where = array();
			$where['type']    = 1;
			$where['status']  = 3;
			$where['_string'] = "add_time <= '" . $stop_time . "'";
			$tmp_days_30_withdrawal = $store_withdrawal->getAmount($where);
			$days_30_withdrawal[]   = number_format($tmp_days_30_withdrawal, 2, '.', '');

			//待提现总额(截止结束时间，累计统计)
			$where = array();
			$where['useStorePay']   = 0;
			$where['user_order_id'] = 0;
			$where['status']        = 4;
			$where['_string']       = "add_time <= '" . $stop_time . "'";
			$tmp_days_30_unwithdrawal = $order->getOrderAmount($where);
			$tmp_days_30_unwithdrawal -= $tmp_days_30_withdrawal;
			$days_30_unwithdrawal[]   = number_format($tmp_days_30_unwithdrawal, 2, '.', '');

			//累计收入(截止结束时间，累计统计)
			$where = array();
			$where['type']    = 1;
			$where['status']  = 3;
			$where['_string'] = "add_time <= '" . $stop_time . "'";
			$tmp_days_30_income = $store_withdrawal->getServiceFee($where);
			$days_30_income[]   = number_format($tmp_days_30_income, 2, '.', '');

			$tmp_days[] = "'" . $day . "'";
		}
		$days                 = '[' . implode(',', $tmp_days) . ']';
		$days_30_pay          = '[' . implode(',', $days_30_pay) . ']';
		$days_30_income       = '[' . implode(',', $days_30_income) . ']';
		$days_30_unwithdrawal = '[' . implode(',', $days_30_unwithdrawal) . ']';
		$days_30_withdrawal   = '[' . implode(',', $days_30_withdrawal) . ']';

		$this->assign('income_total', number_format($income_total, 2, '.', ''));
		$this->assign('withdrawal_total', number_format($withdrawal_total, 2, '.', ''));
		$this->assign('unwithdrawal_total', number_format($unwithdrawal_total, 2, '.', ''));
		$this->assign('platform_unbalance', number_format($platform_unbalance, 2, '.', ''));
		$this->assign('platform_income', number_format($platform_income, 2, '.', ''));
		$this->assign('cash_provision_balance', $cash_provision_balance);
		$this->assign('today_cash_provision', $today_cash_provision);
		$this->assign('days', $days);
		$this->assign('days_30_pay', $days_30_pay);
		$this->assign('days_30_income', $days_30_income);
		$this->assign('days_30_unwithdrawal', $days_30_unwithdrawal);
		$this->assign('days_30_withdrawal', $days_30_withdrawal);
		$this->display();
	}

	//平台收款记录
	public function paymentRecord() {
		$order = D('OrderView');
		$common_data = D('CommonData');

		//搜索
		$condition = array();
		if(!empty($_GET['type']) && !empty($_GET['keyword'])){
			if($_GET['type'] == 'order_no'){
				$condition['StoreOrder.order_no'] = trim($_GET['keyword']);
			} else if ($_GET['type'] == 'third_id') {
				$condition['StoreOrder.third_id'] = trim($_GET['keyword']);
			} else if($_GET['type'] == 'name') {
				$condition['Store.name'] = array('like','%' . trim($_GET['keyword']) . '%');
			}
		}
		if (!empty($_GET['status']) && is_numeric($_GET['status'])) {
			$condition['StoreOrder.status'] = $_GET['status'];
		} else {
			$condition['StoreOrder.status'] = array('in', array(2,3,4,6,7));
		}
		$condition['StoreOrder.useStorePay']   = 0;
		$condition['StoreOrder.user_order_id'] = 0;

		if ($this->_get('start_time', 'trim') && $this->_get('end_time', 'trim')) {
			$condition['_string'] = "StoreOrder.paid_time >= '" . strtotime($this->_get('start_time', 'trim')) . "' AND StoreOrder.paid_time <= '" . strtotime($this->_get('end_time', 'trim')) . "'";
		} else if ($this->_get('start_time', 'trim')) {
			$condition['StoreOrder.paid_time'] = array('egt', strtotime($this->_get('start_time', 'trim')));
		} else if ($this->_get('end_time', 'trim')) {
			$condition['StoreOrder.add_time'] = array('elt', strtotime($this->_get('end_time', 'trim')));
		}

		$order_count = $order->where($condition)->count('order_id');
		import('@.ORG.system_page');
		$page = new Page($order_count, 10);
		$orders = $order->where($condition)->order("StoreOrder.order_id DESC")->limit($page->firstRow . ',' . $page->listRows)->select();

		//平台进账总额
		$where = array();
		$where['key'] = 'total';
		$income_total = $common_data->getData($where);

		//未结算进账金额
		$where = array();
		$where['drp_supplier_id'] = 0;
		$where['unbalance'] = array('gt', 0);
		$platform_unbalance = M('Store')->where($where)->sum('unbalance');

		//订单状态
		$status = $order->status();
		//支付方式
		$payment_methods = $order->getPaymentMethod();

		$this->assign('orders', $orders);
		$this->assign('status', $status);
		$this->assign('payment_methods', $payment_methods);
		$this->assign('income_total', number_format($income_total, 2, '.', ''));
		$this->assign('platform_unbalance', number_format($platform_unbalance, 2, '.', ''));
		$this->display();
	}

	//平台收益
	public function incomeRecord()
	{
		$platform_income = D('PlatformIncomeView');

		$income_count = $platform_income->count('pigcms_id');
		import('@.ORG.system_page');
		$page = new Page($income_count, 10);
		$incomes = $platform_income->order("pigcms_id DESC")->limit($page->firstRow . ',' . $page->listRows)->select();

		$this->assign('incomes', $incomes);
		$this->assign('page', $page->show());
		$this->display();
	}

	//所有订单（不含临时订单）
	public function index ()
	{
		$this->_orders();
	}

	//到店自提订单（不含临时订单）
	public function selffetch()
	{
		$this->_orders(array('StoreOrder.shipping_method' => 'selffetch'));
	}

	//货到付款订单（不含临时订单）
	public function codpay()
	{
		$this->_orders(array('StoreOrder.payment_method' => 'codpay'));
	}

	//代付的订单（不含临时订单）
	public function payagent()
	{
		$this->_orders(array('StoreOrder.payment_method' => 'peerpay'));
	}
	
	// 线下订单
	public function offline() {
		// $this->_orders(array('StoreOrder.is_offline' => 1, 'StoreOrder.offline_type' => array('gt', 0)));
		
		$searchcontent = $this->_request('searchcontent','trim,urldecode');
        if(!empty($searchcontent)) {
            parse_str($searchcontent,$data_arr);
            extract($data_arr);
        }

        $start_time = empty($start_time) ? $this->_get('start_time', 'trim') : trim($start_time);
		$end_time = empty($end_time) ? $this->_get('end_time', 'trim') : trim($end_time);
		$order_no = empty($order_no) ? $this->_get('order_no', 'trim') : trim($order_no);
		$check_status = empty($check_status) ? $this->_get('check_status', 'trim') : trim($check_status);




		$p = max(1, $this->_get('page'));
		$limit = 20;
		
		$where = array();
		if (!empty($start_time) && !empty($end_time)) {
			$where['_string'] = "`dateline` >= '" . strtotime($start_time) . "' AND `dateline` <= '" . strtotime($end_time) . "'";
		} else if (!empty($start_time)) {
			$where['dateline'] = array('egt', strtotime($start_time));
		} else if (!empty($end_time)) {
			$where['dateline'] = array('elt', strtotime($end_time));
		}
		
		if (!empty($order_no)) {
			$where['order_no'] = $order_no;
		}
		
		if (!empty($check_status) && $check_status != '*') {
			$where['check_status'] = max(0, $check_status);
		}
		
		// 区域管理员和代理商只能管理自己的店铺的做单
		if ($this->admin_user['type'] == 2) {
			$store_ids = D('Admin')->getAreaStoreIds($this->admin_user);
			if (!empty($store_ids)) {
				$condition['store_id'] = array('in', $store_ids);
			} else {
				$condition['store_id'] = 0;
			}
		} else if ($this->admin_user['type'] == 3) {    // 代理商 只能查看自己关联用户的店铺
			$store_ids = D("Admin")->getAgentStoreIds($this->admin_user);
			if (!empty($store_ids)) {
				$condition['store_id'] = array('in', $store_ids);
			} else {
				$condition['store_id'] = 0;
			}
		}
		
		$count = M('Order_offline')->where($where)->count('id');


		$download = $this->_get('download','intval',0);

        if(!$download && !empty($searchcontent)){
            $return = array('code'=>'0','msg'=>$count);
            echo json_encode($return);exit;
        }


         if($download == 1) {
           
             $order_offline_list = M('Order_offline')->where($where)->order('id DESC')->select();
       
             import('Xls','./source/class');
             $filename = '订单信息';
             $fields = array('订单号/商品','店铺名称','会员用户','订单金额','服务费','平台保证金','商家可用平台积分/商家平台积分','添加时间','送平台积分','审核状态','备注');
             $data = array();  
             $store_arr = array();
			 $user_arr = array();
             foreach ($order_offline_list as $key => $value) {

             	if (!isset($store_arr[$value['store_id']])) {
					$store = M('Store')->where(array('store_id' => $value['store_id']))->field('name')->find();
					$store_arr[$value['store_id']] = $store['name'];
				}
				
				if (!isset($user_arr[$value['uid']])) {
					$user = M('User')->where(array('uid' => $value['uid']))->field('nickname, phone')->find();
					$user_arr[$value['uid']] = $user;
				}
				$tmp_store_name = htmlspecialchars($store_arr[$value['store_id']]);
				 

				$tmp_user_name =$user_arr[$value['uid']]['nickname'] ? $user_arr[$value['uid']]['nickname'] : $user_arr[$value['uid']]['phone'] ;

              	if ($value['status'] == 1) {
						$tmp_status =  '已发放';
				} else {
					    $tmp_status = '未发放';
				}

				if ($value['check_status'] == 1) {
					$tmp_check_status =  '审核通过';
				} else if ($value['check_status'] == 2) {
					$tmp_check_status = '审核不通过';
				} else {
					$tmp_check_status = '未审核';
				}
				
            	$data[$key] = array($value['order_no'].'/'.$value['product_name'],$tmp_store_name,$tmp_user_name,$value['total'],$value['service_fee'],$value['cash'],$value['store_user_point'].'/'.$value['store_point'],date('Y-m-d H:i', $value['dateline']),$value['return_point'].'/'.$tmp_status,$tmp_check_status,$value['bak']);
             }

             Xls::download_csv($filename,$fields,$data);

        }




		$order_offline_list = array();
		$store_arr = array();
		$user_arr = array();
		if ($count > 0) {
			$limit = 20;
			$p = min($p, ceil($count / $limit));
			$offset = ($p - 1) * $limit;
				
			$order_offline_list = M('Order_offline')->where($where)->order('id DESC')->limit($offset . ',' . $limit)->select();
			foreach ($order_offline_list as $order_offline) {
				if (!isset($store_arr[$order_offline['store_id']])) {
					$store = M('Store')->where(array('store_id' => $order_offline['store_id']))->field('name')->find();
					$store_arr[$order_offline['store_id']] = $store['name'];
				}
				
				if (!isset($user_arr[$order_offline['uid']])) {
					$user = M('User')->where(array('uid' => $order_offline['uid']))->field('nickname, phone')->find();
					$user_arr[$order_offline['uid']] = $user;
				}
			}
			
			import('@.ORG.system_page');
			$page = new Page($count, $limit, $p);
			$this->assign('page', $page->show());
		}
		
		$this->assign('store_arr', $store_arr);
		$this->assign('user_arr', $user_arr);
		$this->assign('order_offline_list', $order_offline_list);
		$this->display();
	}

	// 新版线下订单审核
	public function order_offline_check() {
		$order_id = $this->_post('order_id');
		$status = $this->_post('status');
		
		if (empty($order_id) || !in_array($status, array(1, 2))) {
			$data = array();
			$data['status'] = false;
			$data['message'] = '缺少参数';
			$this->ajaxReturn($data);
		}
		
		$order_offline = M('Order_offline')->where(array('id' => $order_id))->find();
		if (empty($order_offline)) {
			$data = array();
			$data['status'] = false;
			$data['message'] = '未找到相应的店铺线下手工订单';
			$this->ajaxReturn($data);
		}
		
		if ($order_offline['check_status'] > 0) {
			$data = array();
			$data['status'] = false;
			$data['message'] = '订单已审核，无须再次审核';
			$this->ajaxReturn($data);
		}
		
		if ($this->admin_user['type'] > 0 && $order_offline['total'] > C('config.offline_money')) {
			$data = array();
			$data['status'] = false;
			$data['message'] = '对不起，您不能审核此订单';
			$this->ajaxReturn($data);
		}
		
		$store_ids = array();
		if ($this->admin_user['type'] == 2) {
			$store_ids = D('Admin')->getAreaStoreIds($this->admin_user);
		} else if ($this->admin_user['type'] == 3) {    // 代理商 只能查看自己关联用户的店铺
			$store_ids = D("Admin")->getAgentStoreIds($this->admin_user);
		}
		
		// 如果是区域、代理商管理员，要判断此管理是否有权限管理此订单
		if (($this->admin_user['type'] == 2 || $this->admin_user['type'] == 3) && !in_array($order_offline['store_id'], $store_ids)) {
			$data = array();
			$data['status'] = false;
			$data['message'] = '对不起，您不能审核此订单';
			$this->ajaxReturn($data);
		}
		
		$data = array();
		$data['check_status'] = $status;
		$data['check_dateline'] = time();
		$data['admin_id'] = $this->admin_user['id'];
		
		$result = M('Order_offline')->data($data)->where(array('id' => $order_id))->save();
		if ($result) {
			$store_id = $order_offline['store_id'];
			$store = M('Store')->where(array('store_id' => $order_offline['store_id']))->find();
			$time = time();
			
			// 审核不通过时，返还平台服务费
			if ($status == 2 && $order_offline['cash'] > 0) {
				$cash = $order_offline['cash'];
				$order_no = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
				$data = array();
				$data['order_offline_id'] = $order_id;
				$data['store_id'] = $store_id;
				$data['order_no'] = $order_no;
				$data['trade_no'] = $order_no;
				$data['amount'] = $cash;
				$data['payment_method'] = '';
				$data['type'] = 3;
				$data['status'] = 2;
				$data['add_time'] = $time;
				$data['bak'] = '审核不通过，退还店铺线下做单扣除的服务费';
				$data['margin_total'] = !empty($store['margin_total']) ? $store['margin_total'] : 0;
				$data['margin_balance'] = !empty($store['margin_balance']) ? $store['margin_balance'] : 0;
				if (M('Platform_margin_log')->data($data)->add()) {
					M('Store')->where(array('store_id' => $store_id))->setInc('margin_balance', $cash);
					
					M('Platform_margin_log')->where(array('order_offline_id' => $order_id))->data(array('status' => 2))->save();
				}
			}
			
			// 审核不通过，如果使用店铺用户积分，需要退还
			if ($status == 2 && $order_offline['store_user_point'] > 0) {
				$user_point_log = M('User_point_log')->where(array('order_offline_id' => $order_id))->find();
				$user = M('User')->where(array('uid' => $store['uid']))->find();
				if (!empty($user_point_log)) {
					$data = array();
					$data['order_offline_id'] = $order_id;
					$data['uid'] = $store['uid'];
					$data['order_no'] = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
					$data['point'] = $order_offline['store_user_point'];
					$data['status'] = 1;
					$data['type'] = 2;
					$data['store_id'] = $store_id;
					$data['supplier_id'] = $store_id;
					$data['add_time'] = time();
					$data['add_date'] = date('Ymd');
					$data['point_total'] = $user['point_total'];
					$data['point_balance'] = $user['point_balance'];
					$data['point_unbalance'] = $user['point_unbalance'];
					$data['point_send_base'] = 0;
					$data['channel'] = 2;
					$data['bak'] = '审核不通过，退还店铺线下做单使用店铺用户平台币';
					
					if (M('User_point_log')->data($data)->add()) {
						M('User')->where(array('uid' => $store['uid']))->setInc('point_balance', $order_offline['store_user_point']);
						M('User_point_log')->where(array('order_offline_id' => $order_id))->data(array('status' => 1))->save();
					}
				}
			}
			
			// 审核不通过，如果使用店铺积分，需要退还
			if ($status == 2 && $order_offline['store_point'] > 0) {
				$data = array();
				$data['store_id'] = $store_id;
				$data['order_offline_id'] = $order_id;
				$data['order_no'] = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
				$data['point'] = $order_offline['store_point'];
				$data['status'] = 2;
				$data['type'] = 1;
				$data['add_time'] = time();
				$data['point_total'] = $store['point_total'];
				$data['point_balance'] = $store['point_balance'];
				$data['channel'] = 1;
				$data['bak'] = '审核不通过，退还店铺线下做单使用平台币';
				
				if (M('Store_point_log')->data($data)->add()) {
					M('Store')->where(array('store_id' => $store_id))->setInc('point_total', $order_offline['store_point']);
					M('Store')->where(array('store_id' => $store_id))->setInc('point_balance', $order_offline['store_point']);
					M('Store_point_log')->where(array('order_offline_id' => $order_id))->data(array('status' => 2))->save();
				}
			}
			
			$data = array();
			$data['status'] = true;
			$data['message'] = '操作成功';
			$this->ajaxReturn($data);
		} else {
			$data = array();
			$data['status'] = false;
			$data['message'] = '操作失败';
			$this->ajaxReturn($data);
		}
	}
	
	// 线下订单审核
	public function offline_check() {
		$order_id = $this->_post('order_id');
		$status = $this->_post('status');
		
		if (empty($order_id) || !in_array($status, array(1, 2))) {
			$data = array();
			$data['status'] = false;
			$data['message'] = '缺少参数';
			$this->ajaxReturn($data);
		}
		
		$order = M('Order')->where(array('order_id' => $order_id))->find();
		if (empty($order)) {
			$data = array();
			$data['status'] = false;
			$data['message'] = '未找到相应的订单';
			$this->ajaxReturn($data);
		}
		
		if ($order['is_offline'] != 1 || $order['offline_type'] < 1) {
			$data = array();
			$data['status'] = false;
			$data['message'] = '此订单不需要审核';
			$this->ajaxReturn($data);
		}
		
		if ($order['offline_status'] > 0) {
			$data = array();
			$data['status'] = false;
			$data['message'] = '订单已审核，无须再次审核';
			$this->ajaxReturn($data);
		}
		
		if ($this->admin_user['type'] > 0 && $order['sub_total'] + $order['postage'] > C('config.offline_money')) {
			$data = array();
			$data['status'] = false;
			$data['message'] = '对不起，您不能审核此订单';
			$this->ajaxReturn($data);
		}
		
		$store_ids = array();
		if ($this->admin_user['type'] == 2) {
			$store_ids = D('Admin')->getAreaStoreIds($this->admin_user);
		} else if ($this->admin_user['type'] == 3) {    // 代理商 只能查看自己关联用户的店铺
			$store_ids = D("Admin")->getAgentStoreIds($this->admin_user);
		}
		
		// 如果是区域、代理商管理员，要判断此管理是否有权限管理此订单
		if (($this->admin_user['type'] == 2 || $this->admin_user['type'] == 3) && !in_array($order['store_id'], $store_ids)) {
			$data = array();
			$data['status'] = false;
			$data['message'] = '对不起，您不能审核此订单';
			$this->ajaxReturn($data);
		}
		
		$data = array();
		$data['offline_status'] = $status;
		$data['offline_dateline'] = time();
		$data['offline_admin_id'] = $this->admin_user['id'];
		if ($status == 2) {
			$data['status'] = 5;
			$data['cancel_method'] = 3;
			$data['cancel_time'] = time();
		}
		
		$result = D('Order')->data($data)->where(array('order_id' => $order_id))->save();
		if ($result) {
			$store = M('Store')->where(array('store_id' => $order['store_id']))->find();
			// 审核不通过时，需要退还使用店铺的积分
			if ($status == 2 && $order['cash_point'] > 0) {
				if ($order['offline_type'] == 1) {
					if (!empty($store)) {
						M('Store')->where(array('store_id' => $order['store_id']))->data(array('point_balance' => $store['point_balance'] + $order['cash_point']))->save();
						$data = array();
						$data['store_id'] = $order['store_id'];
						$data['order_id'] = $order['order_id'];
						$data['order_no'] = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
						$data['point'] = $order['cash_point'];
						$data['status'] = 1;
						$data['type'] = 0;
						$data['add_time'] = time();
						$data['point_total'] = $store['point_total'];
						$data['point_balance'] = $store['point_balance'];
						$data['channel'] = 1;
						$data['bak'] = '线下订单审核不通过，退还使用积分';
						
						M('Store_point_log')->data($data)->add();
						
						M('Store_point_log')->where(array('store_id' => $order['store_id'], 'order_id' => $order['order_id']))->data(array('status' => 1))->save();
					}
				} else if ($order['offline_type'] == 2) {
					$user = D('User')->where(array('uid' => $store['uid']))->find();
					if (!empty($user)) {
						M('User')->where(array('uid' => $user['uid']))->data(array('point_balance' => $user['point_balance'] + $order['cash_point']))->save();
						$data = array();
						$data['order_no'] = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);;
						$data['uid'] = $user['uid'];
						$data['order_id'] = $order['order_id'];
						$data['store_id'] = $store['store_id'];
						$data['supplier_id'] = $store['store_id'];
						$data['point'] = $order['cash_point'];
						$data['status'] = 1;
						$data['type'] = 2;
						$data['channel'] = 1;
						$data['bak'] = '线下订单审核不通过，退还使用积分';;
						$data['add_time'] = time();
						$data['add_date'] = date('Ymd');
						$data['point_total'] = $user['point_total'];
						$data['point_balance'] = $user['point_balance'];
						
						M('User_point_log')->data($data)->add();
						M('User_point_log')->where(array('uid' => $user['uid'], 'order_id' => $order['order_id']))->data(array('status' => 1))->save();
					}
				}
			}
			
			// 审核不通过时，需要退还店铺保证金
			if ($status == 2) {
				// 更改销量和库存
				if (in_array($order['status'], array(2, 3, 4, 7))) {
					$order_product_list = D('Order_product')->where(array('order_id' => $order['order_id']))->select();
					foreach ($order_product_list as $order_product) {
						// 更改库存和销量
						$tmp_product_id = $order_product['product_id'];
						$properties = $order_product['sku_data'];
						$quantity = $order_product['pro_num'];
						
						if (!empty($order_product['sku_data'])) {
							$property_arr = unserialize($order_product['sku_data']);
							if (is_array($property_arr)) {
								$properties = '';
								foreach ($property_arr as $tmp) {
									$properties .= ';' . $tmp['pid'] . ':' . $tmp['vid'];
								}
								
								$properties = trim($properties, ';');
							}
						}
						
						D('Product')->where(array('product_id' => $tmp_product_id))->setInc('quantity', $quantity);
						if (!empty($properties)) { //更新商品属性库存
							D('Product_sku')->where(array('product_id' => $tmp_product_id, 'properties' => $properties))->setInc('quantity', $quantity);
						}
						//更新销量
						D('Product')->where(array('product_id' => $tmp_product_id))->setDec('sales', $quantity); //更新销量
						if (!empty($properties)) { //更新商品属性销量
							D('Product_sku')->where(array('product_id' => $tmp_product_id, 'properties' => $properties))->setDec('sales', $quantity);
						}
						//同步批发商品库存、销量
						$wholesale_products = D('Product')->field('product_id')->where(array('wholesale_product_id' => $tmp_product_id))->select();
						if (!empty($wholesale_products)) {
							foreach ($wholesale_products as $wholesale_product) {
								//更新库存
								D('Product')->where(array('product_id' => $wholesale_product['product_id']))->setInc('quantity', $quantity);
								if (!empty($properties)) { //更新商品属性库存
									D('Product_sku')->where(array('product_id' => $wholesale_product['product_id'], 'properties' => $properties))->setInc('quantity', $quantity);
								}
								//更新销量
								D('Product')->where(array('product_id' => $wholesale_product['product_id']))->setDec('sales', $quantity); //更新销量
								if (!empty($properties)) { //更新商品属性销量
									D('Product_sku')->where(array('product_id' => $wholesale_product['product_id'], 'properties' => $properties))->setDec('sales', $quantity);
								}
							}
						}
					}
				}
				
				$platform_margin_log = M('Platform_margin_log')->where(array(array('store_id' => $order['store_id'], 'order_id' => $order['order_id'])))->find();
				if (!empty($platform_margin_log)) {
					M('Store')->where(array('store_id' => $order['store_id']))->data(array('margin_balance' => $store['margin_balance'] - $platform_margin_log['amount']))->save();
					
					$data = array();
					$data['order_id'] = $order['order_id'];
					$data['order_no'] = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
					$data['store_id'] = $order['store_id'];
					$data['amount'] = -1 * $platform_margin_log['amount'];
					$data['type'] = 3;
					$data['status'] = 2;
					$data['paid_time'] = time();
					$data['add_time'] = time();
					$data['bak'] = '线下订单审核不通过，退还保证';
					$data['margin_total'] = $store['margin_total'];
					$data['margin_balance'] = $store['margin_balance'];
					
					M('Platform_margin_log')->data($data)->add();
					M('Platform_margin_log')->where(array('store_id' => $order['store_id'], 'order_id' => $order['order_id']))->data(array('status' => 2))->save();
				}
			}
			
			$data = array();
			$data['status'] = true;
			$data['message'] = '操作成功';
			$this->ajaxReturn($data);
		} else {
			$data = array();
			$data['status'] = false;
			$data['message'] = '操作失败';
			$this->ajaxReturn($data);
		}
	}
	
	// 退款
	public function refund_peerpay() {
		$order_id = $this->_post('order_id');
		$id = $this->_post('id');
		$money = $this->_post('money');
		
		$order = M('Order')->where(array('order_id' => $order_id))->find();
		if (empty($order)) {
			$data = array();
			$data['status'] = false;
			$data['message'] = '未找到相应的订单';
			$this->ajaxReturn($data);
		}
		
		if ($order['status'] != '5') {
			$data = array();
			$data['status'] = false;
			$data['message'] = '此订单暂时不能退款';
			$this->ajaxReturn($data);
		}
		
		$order_peerpay = M('Order_peerpay')->where(array('order_id' => $order_id, 'id' => $id))->find();
		if (empty($order_peerpay)) {
			$data = array();
			$data['status'] = false;
			$data['message'] = '未找到相应的代付';
			$this->ajaxReturn($data);
		}
		
		if ($order_peerpay['status'] != 1) {
			$data = array();
			$data['status'] = false;
			$data['message'] = '未找到相应的代付';
			$this->ajaxReturn($data);
		}
		
		$peerpay_money = $order_peerpay['money'];
		if ($order_peerpay['untread_status'] == 1) {
			$peerpay_money -= $order_peerpay['untread_money'];
		}
		
		if ($peerpay_money < $money) {
			$data = array();
			$data['status'] = false;
			$data['message'] = '退款金额大于所剩金额';
			$this->ajaxReturn($data);
		}
		
		if ($money == 0) {
			$data = array();
			$data['status'] = false;
			$data['message'] = '没有退款金额';
			$this->ajaxReturn($data);
		}
		
		$third_data = unserialize($order_peerpay['third_data']);
		if (empty($third_data['transaction_id']) || empty($third_data['out_trade_no']) || empty($third_data['openid'])) {
			$data = array();
			$data['status'] = false;
			$data['message'] = '代付订单异常，不能退款';
			$this->ajaxReturn($data);
		}
		
		import('Weixin', './source/class/pay/');
		$pay_type = 'weixin';
		
		$pay_method_list = D('Config')->get_pay_method();
		if (empty($pay_method_list[$pay_type])) {
			$data = array();
			$data['status'] = false;
			$data['message'] = '请配置微信支付';
			$this->ajaxReturn($data);
		}
		
		$order_info = array();
		$order_info['transaction_id'] = $third_data['transaction_id'];
		$order_info['out_trade_no'] = $third_data['out_trade_no'];
		$order_info['out_refund_no'] = date('YmdHis') . mt_rand(1000000, 9999999);
		$order_info['total_fee'] = $order_peerpay['money'];
		$order_info['refund_fee'] = $money;
		
		$openid = $third_data['openid'];
		$payClass = new Weixin($order_info, $pay_method_list[$pay_type]['config'], '', $openid);
		$refund_peerpay = $payClass->refund(true);
		
		if ($refund_peerpay['err_code']) {
			$data = array();
			$data['status'] = false;
			$data['message'] = $refund_peerpay['err_msg'];
			$this->ajaxReturn($data);
		} else {
			$pay_data = $refund_peerpay['pay_data'];
			if ($pay_data['result_code'] == 'SUCCESS') {
				$order_peerpay_data = array();
				$order_peerpay_data['untread_money'] = $order_peerpay['untread_money'] + $money;
				$order_peerpay_data['untread_content'] = '代付过期，退款';
				$order_peerpay_data['untread_dateline'] = time();
				$order_peerpay_data['untread_status'] = 1;
				
				M('Order_peerpay')->where(array('id' => $id))->data($order_peerpay_data)->save();
				
				$data = array();
				$data['status'] = true;
				$data['date'] = date('Y-m-d H:i', $order_peerpay_data['untread_dateline']);
				$data['money'] = $order_peerpay_data['untread_money'];
				$this->ajaxReturn($data);
			} else {
				$data = array();
				$data['status'] = false;
				$data['message'] = $pay_data['err_code_des'];
				$this->ajaxReturn($data);
			}
		}
		
	}


	//提现记录
	public function withdraw() {

		$searchcontent = $this->_request('searchcontent','trim,urldecode');

		if(!empty($searchcontent)) {
            parse_str($searchcontent,$data_arr);
            extract($data_arr);
        }


		if (IS_POST && IS_AJAX && !$searchcontent) {
			//更新备注
			$id  = $this->_post('id', 'trim,intval');
			$bak = $this->_post('bak', 'trim');
			if (D('StoreWithdrawal')->where(array('pigcms_id' => $id))->save(array('bak' => $bak))) {
				echo 1;
			} else {
				echo 0;
			}
			exit;
		}

		$withdrawal  = D('StoreWithdrawalView');
		$bank_model  = M('Bank');
		$common_data = D('CommonData');


		
        

		$store_id = $this->_get('id', 'trim,intval');
		$this->checkStore($store_id);   // 区域/管理员访问权限
		$withdraw_limit = C('config.withdraw_limit');

		$where = array();
		if ($this->admin_user['type'] != 0 && $withdraw_limit) {
			$where['_string'] = "StoreWithdrawal.amount < ".$withdraw_limit;
		}

		$where['StoreWithdrawal.supplier_id'] = 0;
		if ($store_id) {
			$where['StoreWithdrawal.store_id'] = $store_id;
		} else {
			$banks = $bank_model->where(array('status' => 1))->select();
			$this->assign('banks', $banks);
		}


		$type = empty($type) ? $this->_get('type', 'trim') : trim($type);
        $keyword = empty($keyword) ? $this->_get('keyword', 'trim') : trim($keyword);
        $bank = empty($bank) ? $this->_get('bank', 'trim') : trim($bank);
 
        $status = !in_array($status, array('1','2','3','4')) ? $this->_get('status', 'trim') : trim($status);

        $start_time = empty($start_time) ? $this->_get('start_time', 'trim') : trim($start_time);
		$end_time = empty($end_time) ? $this->_get('end_time', 'trim') : trim($end_time);





		if (!empty($type) && !empty($keyword)) {
			if ($type == 'trade_no') {
				$where['StoreWithdrawal.trade_no'] = trim($keyword);
			} else if ($type == 'bank_account') {
				$where['StoreWithdrawal.bank_card'] = trim($keyword);
			} else if ($type == 'store') {
				$where['Store.name'] = array('like', '%' . trim($keyword) . '%');
			} else if ($type == 'user') {
				$where['User.name'] = array('like', '%' . trim($keyword) . '%');
			} else if ($type == 'tel') {
				$where['Store.tel'] = trim($keyword);
			}
		}
		// 列表中
		if (empty($store_id)) {
			// 区域管理员 只能查看自己区域的店铺
	        if ($this->admin_user['type'] == 2) {
	            $store_ids = D('Admin')->getAreaStoreIds($this->admin_user);
	            if (!empty($store_ids)) {
	                $where['StoreWithdrawal.store_id'] = array('in', $store_ids);
	            } else {
	                $where['StoreWithdrawal.store_id'] = false;
	            }
	        } else if ($this->admin_user['type'] == 3) {    // 代理商 只能查看自己关联用户的店铺
	            $store_ids = D("Admin")->getAgentStoreIds($this->admin_user);
	            if (!empty($store_ids)) {
	                $where['StoreWithdrawal.store_id'] = array('in', $store_ids);
	            } else {
	                $where['StoreWithdrawal.store_id'] = false;
	            }
	        }
		}
		if (is_numeric($bank) && $bank > 0) {
			$where['StoreWithdrawal.bank_id'] = $bank;
		}
		if (is_numeric($status) && $status > 0) {
			$where['StoreWithdrawal.status'] = $status;
		}
		if ($start_time && $end_time) {
			$where['_string'] = "StoreWithdrawal.add_time >= '" . strtotime($start_time) . "' AND StoreWithdrawal.add_time <= '" . strtotime($end_time) . "'";
		} else if ($start_time) {
			$where['StoreWithdrawal.add_time'] = array('egt', strtotime($start_time));
		} else if ($end_time) {
			$where['StoreWithdrawal.add_time'] = array('elt', strtotime($end_time));
		}
		$withdrawal_count = $withdrawal->where($where)->count('StoreWithdrawal.pigcms_id');
		

		$download = $this->_get('download','intval',0);

        if(!$download && !empty($searchcontent)){
            $return = array('code'=>'0','msg'=>$withdrawal_count);
            echo json_encode($return);exit;
        }


        if($download == 1) {
            
            $withdrawals = $withdrawal->where($where)->order('StoreWithdrawal.status ASC,StoreWithdrawal.pigcms_id DESC')->select();
       
             import('Xls','./source/class');
             $filename = '提现记录';
             $fields = array('编号','交易单号','申请时间','银行账户','店铺名称','提现金额(元)','平台服务费(%)','实际提现(元)','可提现余额(元)','处理完成时间','申请人','联系方式','经营人','法人','状态','处理结果');
             $data = array();  
             foreach ($withdrawals as $key => $value) {
             	//$tmp_withdrawal_type = ($value['withdrawal_type'] == 0)?'个人账户':'公司账户';
             	
				$bank = M('Bank')->field('name')->where(array('bank_id' => $value['bank_id']))->find();
				$tmp_bank = $bank['name'];

             	$tmp_str = '账户类型：';
                if($value['withdrawal_type'] == 0){
                	$tmp_str .= '个人账户';
                }else{
                	$tmp_str .= '公司账户';
                }
                $tmp_str .= '<br />收款银行：';

                $tmp_str .= $tmp_bank;

                $tmp_str .= '<br />开户银行：';
                $tmp_str .= $value['opening_bank'];

                $tmp_str .= '<br />银行帐户：';
                $tmp_str .= $value['bank_card'];

                $tmp_str .= '<br />帐户名称：';
                $tmp_str .= $value['bank_card_user'];

             

                $tmp_real_amount = number_format($value['amount'] * (1 - ($value['sales_ratio'] / 100)), 2, '.', '');

               	if($value['status'] == 1){
               		$tmp_status = '申请中';
               	}elseif ($value['status'] == 2) {
               		$tmp_status = '银行处理中';
               	}elseif ($value['status'] == 3) {
               		$tmp_status = '提现成功';
               	}elseif ($value['status'] == 4) {
               		$tmp_status = '提现失败';
               	}

               	/* 获取提现记录中店铺 法人/经营者 */
               	$store_list = array();
				if (!empty($store_list) && isset($store_list[$value['store_id']])) {
					$value['linkman'] = !empty($store_list[$value['store_id']]['linkman']) ? $store_list[$value['store_id']]['linkman'] : '无';
					$value['legal_person'] = !empty($store_list[$value['store_id']]['legal_person']) ? $store_list[$value['store_id']]['legal_person'] : '无';
				} else {
					$store_info = M('Store')->field('linkman,legal_person')->where(array('store_id'=>$value['store_id']))->find();
					if (empty($store_info)) {
						$value['linkman'] = '未找到店铺';
						$value['legal_person'] = '未找到店铺';
						continue;
					} else {
						$value['linkman'] = !empty($store_info['linkman']) ? $store_info['linkman'] : '无';
						$value['legal_person'] = !empty($store_info['legal_person']) ? $store_info['legal_person'] : '无';
					}
					$store_list[$value['store_id']] = $store_info;
				}

                $data[$key] = array($value['pigcms_id'],'`'.$value['trade_no'].'`',date('Y-m-d H:i:s',$value['add_time']),$tmp_str,$value['store'],$value['amount'],$value['sales_ratio'].'%',$tmp_real_amount,$value['balance'],date('Y-m-d H:i:s',$value['complate_time']),$value['nickname'],$value['mobile'],$value['linkman'],$value['legal_person'],$tmp_status,$value['bak']);
             }

             Xls::download_csv($filename,$fields,$data); 

        }

		import('@.ORG.system_page');
		$page = new Page($withdrawal_count, 10);
		$withdrawals = $withdrawal->where($where)->limit($page->firstRow, $page->listRows)->order('StoreWithdrawal.status ASC,StoreWithdrawal.pigcms_id DESC')->select();
		$store_list = array();
		if (!empty($withdrawals)) {
			foreach ($withdrawals as &$tmp_withdrawal) {
				$tmp_withdrawal['real_amount'] = number_format($tmp_withdrawal['amount'] * (1 - ($tmp_withdrawal['sales_ratio'] / 100)), 2, '.', '');

				/* 获取提现记录中店铺 法人/经营者 */
				if (!empty($store_list) && isset($store_list[$tmp_withdrawal['store_id']])) {
					$tmp_withdrawal['linkman'] = !empty($store_list[$tmp_withdrawal['store_id']]['linkman']) ? $store_list[$tmp_withdrawal['store_id']]['linkman'] : '无';
					$tmp_withdrawal['legal_person'] = !empty($store_list[$tmp_withdrawal['store_id']]['legal_person']) ? $store_list[$tmp_withdrawal['store_id']]['legal_person'] : '无';
				} else {
					$store_info = M('Store')->field('linkman,legal_person')->where(array('store_id'=>$tmp_withdrawal['store_id']))->find();
					if (empty($store_info)) {
						$tmp_withdrawal['linkman'] = '未找到店铺';
						$tmp_withdrawal['legal_person'] = '未找到店铺';
						continue;
					} else {
						$tmp_withdrawal['linkman'] = !empty($store_info['linkman']) ? $store_info['linkman'] : '无';
						$tmp_withdrawal['legal_person'] = !empty($store_info['legal_person']) ? $store_info['legal_person'] : '无';
					}
					$store_list[$tmp_withdrawal['store_id']] = $store_info;
				}

			}
		}

		$status = $withdrawal->getWithdrawalStatus();

		//提现处理中的金额
		$where = array();
		$where['type']   = 1;
		$where['status'] = array('in', array(1, 2));
		$withdrawal_pending = $withdrawal->getAmount($where);

		//已提现总额
		$withdrawal_total = $common_data->getData(array('key' => 'withdrawal'));

		//平台收入总额
		$platform_income = $common_data->getData(array('key' => 'income'));

		//未处理收入金额
		$where['type'] = 1;
		$where['status'] = array('in', array(1,2));
		$unwithdrawal_service_fee = $withdrawal->getServiceFee($where);

		$this->assign('withdrawals', $withdrawals);
		$this->assign('status', $status);
		$this->assign('page', $page->show());
		$this->assign('platform_income', number_format($platform_income, 2, '.', ''));
		$this->assign('withdrawal_pending', number_format($withdrawal_pending, 2, '.', ''));
		$this->assign('withdrawal_total', number_format($withdrawal_total, 2, '.', ''));
		$this->assign('unwithdrawal_service_fee', number_format($unwithdrawal_service_fee, 2, '.', ''));

		//已提现总额

		if ($store_id) {
			$this->display('withdraw');
		} else {
			$this->display('withdraws');
		}
	}

	//提现状态
	public function withdraw_status() {
		$withdrawal      = D('StoreWithdrawalView');
		$store           = M('Store');
		$common_data     = D('CommonData');
		$platform_income = M('PlatformIncome');

		$id     = $this->_post('id', 'trim');
		$status = $this->_post('status', 'trim,intval');
		$withdrawal_info = $withdrawal->getWithdrawal(array('pigcms_id' => $id));
		if (empty($withdrawal_info)) {
			echo 0;
			exit;
		}
		//提现金额
		$amount      = $withdrawal_info['amount'];
		$store_id    = $withdrawal_info['store_id'];
		$withdraw_limit = C('config.withdraw_limit');

		if ($this->admin_user['type'] != 0 && $withdraw_limit != 0) {
			if ($amount >= $withdraw_limit) {
				// $this->frame_error_tips('额度超过'.$withdraw_limit.'元，您所在用户组没有审批权限。');
				echo 2;
				exit;
			}
		}

		if ($this->admin_user['type'] == 2 || $this->admin_user['type'] == 3) {
			if ($status != 2) {
				echo 3;
				exit;
			}
		}

		//服务费率
		$sales_ratio = !empty($withdrawal_info['sales_ratio']) ? $withdrawal_info['sales_ratio'] / 100 : 0;

		$data = array();
		$data['status'] = $status;
		if ($status == 3) { // 提现成功
			$data['complate_time'] = time();
		}
		if (M('StoreWithdrawal')->where(array('pigcms_id' => $id))->save($data)) {
			if ($status == 4) { //提现失败
				//退回在平台的账户余额
				if (empty($withdrawal_info['channel'])) { //交易收益提现
					$store->where(array('store_id' => $store_id))->setInc('balance', $amount);
				} else { //积分兑换提现
					$store->where(array('store_id' => $store_id))->setInc('point2money_balance', $amount);
				}
			} else if ($status == 3) { //提现成功
				//供货商提现总额累计
				if (empty($withdrawal_info['channel'])) { //交易收益提现
					D('Store')->where(array('store_id' => $store_id))->setInc('withdrawal_amount', $amount);
				} else { //积分兑换提现
					D('Store')->where(array('store_id' => $store_id))->setInc('point2money_withdrawal', $amount);
				}

				//平台处理提现累计
				$common_data->setData(array('key' => 'withdrawal'), $amount);
				//平台服务费收益
				$service_fee = $amount * $sales_ratio;
				if ($service_fee > 0) {
					//平台收益
					$common_data->setData(array('key' => 'income'), $service_fee);
					//提现服务费
					$common_data->setData(array('key' => 'withdrawal_service_fee'), $service_fee);
					$data = array();
					$data['income']   = $service_fee;
					$data['add_time'] = time();
					$data['type']     = 1;
					$data['store_id'] = $store_id;
					$platform_income->add($data);
				}
			}
			echo 1;
		} else {
			echo 0;
		}
		exit;
	}

	//短信订单列表
	public function smspay() {
		$sms_order = D('order_sms');
		$condition = array();
		
		$type = $this->_get('type');
		$keyword = $this->_get('keyword');
		$keyword = $keyword ? trim($keyword):"";
		$status = $this->_get('status');		
		$start_time = $this->_get('start_time');
		$end_time = $this->_get('end_time');
						
		if(in_array($type,array('type_nickname','type_mobile'))) {
			
			if($keyword) {
				
				if($type == 'type_nickname') {
					$condition['u.nickname'] = array("eq",$keyword);
				} elseif($type == 'type_mobile') {
				if (!preg_match("/^[1-9]{1}[0-9]{6,10}/", $keyword)) {
					$this->error('请输入正确的查询手机号');
				}
				$condition['u.phone'] = array("eq",$keyword);
				}				
			}
		}
		
		if(in_array($status,array('0','1'))) {
			$condition['s.status'] = array("eq",$status);
		}

		if(!empty($start_time) && !empty($end_time)) {
			
			$starttime = strtotime($start_time);
			$endtime = strtotime($end_time);
			$condition['s.pay_dateline'] =  array('between',$starttime.",".$endtime);
		}		

		$order_count = $sms_order->where($condition)->count();
		//echo $sms_order->getlastsql();
		import('@.ORG.system_page');
		$page = new Page($order_count, 10);
		//$orders = $sms_order->where($condition)->order("sms_order_id desc")->limit($page->firstRow . ',' . $page->listRows)->select();
		
		$orders = $sms_order->alias("s")->field("s.*,u.nickname,u.phone,u.uid")->join(C('DB_PREFIX')."user as u on s.uid=u.uid")->where($condition)->order("s.sms_order_id desc")->limit($page->firstRow . ',' . $page->listRows)->select();
	
		
		//订单状态

		
		$this->assign('page', $page->show());
		$this->assign('sms_order', $orders);
		$this->assign('status', $status);
				
		$this->display();
	}

	
	//订单详细
	public function detail()
	{
		$order = D('OrderView');
		$order_product = D('OrderProductView');
		$package = D('OrderPackage');
		$user = D('User');

		//订单状态
		$status = $order->status();
		//支付方式
		$payment_method = $order->getPaymentMethod();

		$order_id = $this->_get('id');
		$order = $order->where(array('StoreOrder.order_id' => $order_id))->find();
		$this->checkStore($order['store_id']); 	// 区域/管理员访问权限

		$products = $order_product->getProducts($order_id);
		$comment_count = 0;
		$product_count = 0;
		foreach ($products as &$product) {
			if (!empty($product['comment'])) {
				$comment_count++;
			}
			$product_count++;

			$product['image'] = getAttachmentUrl($product['image']);
		}

		if (empty($order['uid'])) {
			$is_fans = false;
		} else {
			$is_fans = $user->isWeixinFans($order['uid']);
		}

		if (empty($order['address'])) {
			$status[0] = '未填收货地址';
		} else {
			$status[1] = '已填收货地址';
		}
		if (!empty($order['user_order_id'])) {
			$user_order_id = $order['user_order_id'];
		} else {
			$user_order_id = $order['order_id'];
		}
		//订单包裹
		$where = array();
		$where['user_order_id'] = $user_order_id;
		$tmp_packages = $package->getPackages($where);
		$packages = array();
		foreach ($tmp_packages as $package) {
			$package_products = explode(',', $package['products']);
			if (array_intersect($package_products, $tmp_products)) {
				$packages[] = $package;
			}
		}
		
		if ($order['payment_method'] == 'peerpay') {
			$order_peerpay_list = M('Order_peerpay')->where(array('order_id' => $order['order_id'], 'status' => 1))->select();
			$this->assign('order_peerpay_list', $order_peerpay_list);
		}
		
		$this->assign('is_fans', $is_fans);
		$this->assign('order', $order);
		$this->assign('products', $products);
		$this->assign('rows', $comment_count + $product_count);
		$this->assign('comment_count', $comment_count);
		$this->assign('status', $status);
		$this->assign('payment_method', $payment_method);
		$this->assign('packages', $packages);
		$this->display();
	}

	//订单数据
	private function _orders($where = array())
	{
		
		$order = D('OrderView');

		$searchcontent = $this->_request('searchcontent','trim,urldecode');
        if(!empty($searchcontent)) {
            parse_str($searchcontent,$data_arr);
            extract($data_arr);
        }

        $type = empty($type) ? $this->_get('type', 'trim') : trim($type);
        $keyword = empty($keyword) ? $this->_get('keyword', 'trim') : trim($keyword);
        $status = !in_array($status, array('0', '1','2','3','4','5','6','7')) ? $this->_get('status', 'trim') : trim($status);
        $is_check = !in_array($is_check, array('1', '2')) ? $this->_get('is_check', 'trim') : trim($is_check);

        $start_time = empty($start_time) ? $this->_get('start_time', 'trim') : trim($start_time);
		$end_time = empty($end_time) ? $this->_get('end_time', 'trim') : trim($end_time);


		//搜索
		$condition = array();
		if(!empty($type) && !empty($keyword)){
			if($type == 'order_no'){
				$condition['StoreOrder.order_no'] = $keyword;
			} else if ($type == 'third_id') {
				$condition['StoreOrder.third_id'] = $keyword;
			} else if($type == 'name') {
				$condition['Store.name'] = array('like','%'.$keyword.'%');
			} else if($type == 'linkman') {
				$condition['Store.linkman'] = array('like','%'.$keyword.'%');
			}
		}
		if (is_numeric($status)) {
			$condition['StoreOrder.status'] = $status;
		}
		if (!empty($is_check)) {
			$condition['StoreOrder.is_check'] = $is_check;
		}


		

		// 区域管理员 只能查看自己区域的店铺
		if ($this->admin_user['type'] == 2) {
			$store_ids = D('Admin')->getAreaStoreIds($this->admin_user);
			if (!empty($store_ids)) {
				$condition['Store.store_id'] = array('in', $store_ids);
			} else {
				$condition['Store.store_id'] = false;
			}
		} else if ($this->admin_user['type'] == 3) {    // 代理商 只能查看自己关联用户的店铺
            $store_ids = D("Admin")->getAgentStoreIds($this->admin_user);
            if (!empty($store_ids)) {
                $condition['Store.store_id'] = array('in', $store_ids);
            } else {
                $condition['Store.store_id'] = false;
            }
        }

		//$condition['Store.drp_level'] = 0;
		//自定义查询条件
		if (!empty($where)) {
			foreach ($where as $key => $value) {
				$condition[$key] = $value;
			}
		}


		if ($start_time && $end_time) {
			$condition['_string'] = "StoreOrder.add_time >= '" . strtotime($start_time) . "' AND StoreOrder.add_time <= '" . strtotime($end_time) . "' AND (StoreOrder.is_fx = 1 OR (StoreOrder.user_order_id = 0 AND StoreOrder.is_fx = 0))";
		} else if ($start_time) {
			$condition['StoreOrder.add_time'] = array('egt', strtotime($start_time));
			$condition['_string'] = "(StoreOrder.is_fx = 1 OR (StoreOrder.user_order_id = 0 AND StoreOrder.is_fx = 0))";
		} else if ($end_time) {
			$condition['StoreOrder.add_time'] = array('elt', strtotime($end_time));
			$condition['_string'] = "(StoreOrder.is_fx = 1 OR (StoreOrder.user_order_id = 0 AND StoreOrder.is_fx = 0))";
		} else {
			$condition['_string'] = "(StoreOrder.is_fx = 1 OR (StoreOrder.user_order_id = 0 AND StoreOrder.is_fx = 0))";
		}



		
		//不含临时订单
		$order_count = $order->where($condition)->count();


		$download = $this->_get('download','intval',0);

        if(!$download && !empty($searchcontent)){
            $return = array('code'=>'0','msg'=>$order_count);
            echo json_encode($return);exit;
        }


         if($download == 1) {
            $status_arr = $order->status();
            $orders = $order->where($condition)->order("StoreOrder.order_id DESC")->select();
       
             import('Xls','./source/class');
             $filename = '订单信息';
             $fields = array('订单号','外部交易单号','商家名称','店铺名称','收货人','电话','对账情况','下单时间','总价','状态','备注');
             $data = array();  
             foreach ($orders as $key => $value) {
       
				$tmp_is_check = ($value['is_check'] == 2)?'已对账':'未对账';
				if($value['third_id']){
					$tmp_third_id = '`'.$value['third_id'].'`';
				}else{
					$tmp_third_id = '';
				}
				//$tmp_third_id = (!empty($value['third_id']))?' `'.$value['third_id'].'`':'';
                $data[$key] = array('`'.$value['order_no'].'`',$tmp_third_id,$value['linkman'],$value['store'],$value['address_user'],$value['address_tel'],$tmp_is_check,date('Y-m-d H:i:s',$value['add_time']),$value['total'],$status_arr[$value['status']],$value['bak']);
             }

             Xls::download_csv($filename,$fields,$data);

        }


		import('@.ORG.system_page');
		$page = new Page($order_count, 10);
		$orders = $order->where($condition)->order("StoreOrder.order_id DESC")->limit($page->firstRow . ',' . $page->listRows)->select();
		
		//订单状态
		$status = $order->status();
		//unset($status[0]);
		$this->assign('page', $page->show());
		$this->assign('orders', $orders);
		$this->assign('status', $status);
	 
		$this->assign('check', $this->check);
		$this->display();
	}

	
	
	public function check() {
		
		$order = D('OrderView');
		//搜索
		$condition = array();
		if(!empty($_GET['type']) && !empty($_GET['keyword'])){
			if($_GET['type'] == 'order_no'){
				$condition['StoreOrder.order_no'] = $_GET['keyword'];
			}else if($_GET['type'] == 'name'){
				$condition['Store.name'] = array('like','%'.$_GET['keyword'].'%');
			}else if($_GET['type'] == 'linkman'){
				$condition['Store.linkman'] = array('like','%'.$_GET['keyword'].'%');
			}
		}
		if (!empty($_GET['status'])) {
			$condition['StoreOrder.status'] = $_GET['status'];
		} else {
			$condition['StoreOrder.status'] = array('gt', 0);
		}
		if (!empty($_GET['is_check'])) {
			$condition['StoreOrder.is_check'] = $_GET['is_check'];
		} else {
			$condition['StoreOrder.is_check'] = array('gt', 0);
		}
		
		//自定义查询条件
		if (!empty($where)) {
			foreach ($where as $key => $value) {
				$condition[$key] = $value;
			}
		}
		if ($this->_get('start_time', 'trim') && $this->_get('end_time', 'trim')) {
			$condition['_string'] = "StoreOrder.add_time >= '" . strtotime($this->_get('start_time', 'trim')) . "' AND StoreOrder.add_time <= '" . strtotime($this->_get('end_time')) . "'";
		} else if ($this->_get('start_time', 'trim')) {
			$condition['StoreOrder.add_time'] = array('egt', strtotime($this->_get('start_time', 'trim')));
		} else if ($this->_get('end_time', 'trim')) {
			$condition['StoreOrder.add_time'] = array('elt', strtotime($this->_get('end_time', 'trim')));
		}
		//不含临时订单
		$order_count = $order->where($condition)->count();
		import('@.ORG.system_page');
		$page = new Page($order_count, 10);
		$orders = $order->where($condition)->order("StoreOrder.order_id DESC")->limit($page->firstRow . ',' . $page->listRows)->select();
		
		//订单状态
		$status = $order->status();
		unset($status[0]);
		$this->assign('page', $page->show());
		$this->assign('orders', $orders);
		$this->assign('status', $status);
		
		$this->assign('check', $this->check);
		$this->display();
	}
	
	
	//对账日志
	public function checklog() {
		$order_check_log = D('OrderCheckLog');
		$condition = array();
		
		
		
		if(!empty($_GET['type']) && !empty($_GET['keyword'])){
			if($_GET['type'] == 'realname'){
				$condition['a.realname'] = array('like','%'.$_GET['keyword'].'%');
			}else if($_GET['type'] == 'account'){
				$condition['a.account'] = array('like','%'.$_GET['keyword'].'%');
			}
		}		
		
		
		
		
		
		
		$order_check_count = $order_check_log->alias("logs")->join(C('DB_PREFIX')."admin a ON a.id = logs.admin_uid")->where($condition)->count('logs.id');
		import('@.ORG.system_page');
		$page = new Page($order_check_count, 20);
		//$OrderCheckList = $order_check_log->where($condition)->limit($page->firstRow, $page->listRows)->order("id desc,timestamp desc")->select();
		$OrderCheckList = $order_check_log->alias("logs")->join(C('DB_PREFIX')."admin a ON a.id = logs.admin_uid")->field("logs.*,a.account,a.realname,a.last_ip")->where($condition)->limit($page->firstRow, $page->listRows)->order("logs.id desc,logs.timestamp desc")->select();
		//echo $order_check_log->getLastSql();

		
		$this->assign('page', $page->show());
		$this->assign('array',$OrderCheckList);
		$this->display();		
		
	}
	
	
	//详细对账抽成比例
	public function alert_check(){
		
		$order = D('OrderView');
		$order_product = D('OrderProductView');
		$package = D('OrderPackage');
		$user = D('User');
		
		//订单状态
		$status = $order->status();
		//支付方式
		$payment_method = $order->getPaymentMethod();
		
		$order_id = $this->_get('id');
		$order = $order->where(array('StoreOrder.order_id' => $order_id))->find();
		
		$products = $order_product->getProducts($order_id);
		$comment_count = 0;
		$product_count = 0;
		foreach ($products as &$product) {
			if (!empty($product['comment'])) {
				$comment_count++;
			}
			$product_count++;
		
			$product['image'] = getAttachmentUrl($product['image']);
		}
		
		if (empty($order['uid'])) {
			$is_fans = false;
		} else {
			$is_fans = $user->isWeixinFans($order['uid']);
		}
		
		if (empty($order['address'])) {
			$status[0] = '未填收货地址';
		} else {
			$status[1] = '已填收货地址';
		}
		if (!empty($order['user_order_id'])) {
			$user_order_id = $order['user_order_id'];
		} else {
			$user_order_id = $order['order_id'];
		}
		//订单包裹
		$where = array();
		$where['user_order_id'] = $user_order_id;
		$tmp_packages = $package->getPackages($where);
		$packages = array();
		foreach ($tmp_packages as $package) {
			$package_products = explode(',', $package['products']);
			if (array_intersect($package_products, $tmp_products)) {
				$packages[] = $package;
			}
		}
		$this->assign('is_fans', $is_fans);
		$this->assign('order', $order);
		$this->assign('products', $products);
		$this->assign('rows', $comment_count + $product_count);
		$this->assign('comment_count', $comment_count);
		$this->assign('status', $status);
		$this->assign('payment_method', $payment_method);
		$this->assign('packages', $packages);
		$this->display();
		
	} 
	
	//更改：出账状态
	public function check_status() {
		$order_id = $this->_post('order_id');
		$order_no = $this->_post('order_no');
		$is_check = $this->_post('is_check');
		$store_id = $this->_post('store_id');
		$order = D('Order');
		
		if(empty($order_id) || empty($order_no) || empty($is_check)){
			exit(json_encode(array('error' => 1,'message' =>'缺少必要参数')));
		}
		
		$where = array(
			'order_id' => $order_id,
			'order_no' => $order_no,				
		);
		$order->where($where)->save(array('is_check'=>$is_check));	
		
		$log_where = $where;
		$log_where['store_id'] = $store_id;
		
		
		$this->set_check_log($log_where);
		exit(json_encode(array('error' => 0,'message' =>'已出账')));
	}
	
	
	/*description:记录出账日志
	 * 
	 * @arr : 必须包含： order_id,order_no
	 */
	public function set_check_log($arr) {
		
		$check_log = D('OrderCheckLog');
		
		$thisUser = $this->system_session;

		if(empty($arr['order_id']) || empty($arr['order_no']) || empty($thisUser['id'])) {
			
			return false;
		}
		
		$description = "";
		
		$data = array(
			'timestamp' => time(),
			'admin_uid' => 	$thisUser['id'],
			'order_id' => $arr['order_id'],
			'order_no' => $arr['order_no'],
			'ip' => ip2long($_SERVER['REMOTE_ADDR']),
			'description' => $description
		);
		
		if($check_log->add($data)){
			return true;
		}else{
			return false;
		}
		
	}
	
	/**
	 * 退货列表
	 */
	public function return_order() {
		$order_no = $this->_get('order_no');
		$type = $this->_get('type');
		$status = $this->_get('status');
		$is_delivered = $this->_get('is_delivered');
		$receipt = $this->_get('receipt');
		$refund_status = $this->_get('refund_status');
		$start_time = $this->_get('start_time');
		$end_time = $this->_get('end_time');

		if (!empty($start_time)) {
			$start_time = strtotime($start_time);
		}
		if (!empty($end_time)) {
			$end_time = strtotime($end_time);
		}
		$where = array();
		$where['user_return_id'] = 0;
		if (!empty($order_no)) {
			$where['_string'] = "(r.order_no like '%" . $order_no . "%' OR r.return_no like '%" . $order_no . "%')";
		}
		if (!empty($type)) {
			$where['r.type'] = $type;
		}
		if (!empty($status)) {
			$where['r.status'] = $status;
		}
		if (is_numeric($is_delivered)) {
			$where['is_delivered'] = $is_delivered;
		} else {
			$is_delivered = '*';
		}
		if (is_numeric($receipt)) {
			$where['useStorePay'] = $receipt;
		} else {
			$receipt = '*';
		}
		if (is_numeric($refund_status)) {
			$where['refund_status'] = $refund_status;
		} else {
			$refund_status = '*';
		}
		if (!empty($start_time) && !empty($end_time)) {
			if (!empty($where['_string'])) {
				$where['_string'] = " AND (dateline >= '" . $start_time . "' AND dateline <= '" . $end_time . "')";
			} else {
				$where['_string'] = "dateline >= '" . $start_time . "' AND dateline <= '" . $end_time . "'";
			}
		} else if (!empty($start_time)) {
			$where['dateline'] = array('egt', $start_time);
		} else if (!empty($end_time)) {
			$where['dateline'] = array('elt', $end_time);
		}

		// 区域管理员 只能查看自己区域的店铺
		if ($this->admin_user['type'] == 2) {
			$store_ids = D('Admin')->getAreaStoreIds($this->admin_user);
			if (!empty($store_ids)) {
				$where['store_id'] = array('in', $store_ids);
			} else {
				$where['store_id'] = false;
			}
		} else if ($this->admin_user['type'] == 3) {    // 代理商 只能查看自己关联用户的店铺
			$store_ids = D("Admin")->getAgentStoreIds($this->admin_user);
			if (!empty($store_ids)) {
				$where['store_id'] = array('in', $store_ids);
			} else {
				$where['store_id'] = false;
			}
		}
		
		$type_arr = D('Return')->returnType();
		$status_arr = D('Return')->returnStatus();
		$refund_status_arr = D('Return')->refundStatus();
	
		$return_count = D('ReturnView')->where($where)->count('r.id');
		$return_list = array();
		if ($return_count > 0) {
			import('@.ORG.system_page');
			$page = new Page($return_count, 10);
			$return_list = D('ReturnView')->where($where)->order('r.status asc, r.id DESC')->limit($page->firstRow . ',' . $page->listRows)->select();
			foreach ($return_list as &$return) {
				$product = M('Product')->field('name,image')->where(array('product_id' => $return['product_id']))->find();
				$return['name'] = $product['name'];
				$return['image'] = getAttachmentUrl($product['image']);

				if (!empty($return['storePay'])) {
					$receipt = M('Store')->where(array('store_id' => $return['storePay']))->getField('name');
					$return['receipt'] = $receipt;
				} else {
					$return['receipt'] = '平台';
				}

				$return['type_txt'] = $type_arr[$return['type']];
				$return['status_txt'] = $status_arr[$return['status']];
				$return['refund_status_txt'] = $refund_status_arr[$return['refund_status']];

				//商家
				$store = M('Store')->field('name,tel')->where(array('store_id' => $return['store_id']))->find();
				$return['store'] = $store;
				//供货商
				if (!empty($return['supplier_id'])) {
					$supplier = M('Store')->field('name,tel')->where(array('store_id' => $return['supplier_id']))->find();
					$return['supplier'] = $supplier;
				}
			}

			$this->assign('page', $page->show());
		}

		$this->assign('type', $type);
		$this->assign('status', $status);
		$this->assign('type_arr', $type_arr);
		$this->assign('status_arr', $status_arr);
		$this->assign('refund_status_arr', $refund_status_arr);
		$this->assign('return_list', $return_list);
		$this->assign('is_delivered', $is_delivered);
		$this->assign('receipt', $receipt);
		$this->assign('refund_status' , $refund_status);
		$this->display();
	}
	
	public function return_detail() {
		$id = $this->_get('id');
		if (empty($id)) {
			echo '缺少参数';
			exit;
		}
		
		$return = D('Return')->getById($id);
		$store_list = D('Return')->getProfit($return);
		
		$this->assign('return', $return);
		$this->assign('store_list', $store_list);
		$this->display();
	}

	public function refund_process()
	{
		if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
			$id = intval($_POST['id']);
			if (empty($id)) {
				$data = array();
				$data['status'] = false;
				$data['message'] = '缺少参数';
				$this->ajaxReturn($data);
			}

			$return = D('Return')->getById($id);
			if ($return['status'] != 5) {
				$data = array();
				$data['status'] = false;
				$data['message'] = '商家不同意退货或退货未完成';
				$this->ajaxReturn($data);
			}

			if ($_POST['act'] == 'cancel') {
				$where = array();
				$where['_string'] = "id = '" . $id . "' OR user_return_id = '" . $id . "'";
				if (D('Return')->where($where)->data(array('refund_status' => 2, 'refund_time' => time()))->save()) {
					$data = array();
					$data['status'] = true;
					$data['message'] = '已取消退款';
					$this->ajaxReturn($data);
				} else {
					$data = array();
					$data['status'] = false;
					$data['message'] = '已取消退款';
					$this->ajaxReturn($data);
				}
			} else if ($_POST['act'] == 'refund') {
				import('Weixin', './source/class/pay/');

				$order = D('Order')->field('uid,order_no,trade_no,third_id,payment_method,pay_money,cash_point,point2money_rate')->where(array('order_id' => $return['order_id']))->find();
				//付款用户
				$user = D('User')->field('openid')->where(array('uid' => $order['uid']))->find();
				//支付方式
				$payment_method = $order['payment_method'];
				$cash_point_money = ($order['cash_point'] / $order['point2money_rate']); //抵现积分金额
				//支付金额
				$pay_money = $order['pay_money'] - $cash_point_money;
				//退款金额
				$refund_total = $return['product_money'] + $return['postage_money'];
				//支付方式
				$pay_method_list = D('Config')->get_pay_method(false, true);

				$refund_data = array();
				$refund_data['transaction_id'] = $order['third_id'];
				$refund_data['out_trade_no'] = $order['trade_no'];
				$refund_data['out_refund_no'] = $return['order_no'];
				$refund_data['total_fee'] = $pay_money;
				$refund_data['refund_fee'] = $refund_total;
				$openid = $user['openid'];

				$payClass = new Weixin($refund_data, $pay_method_list[$payment_method]['config'], '', $openid);
				$refund_result = $payClass->refund(true);

				if ($refund_result['err_code']) {
					$data = array();
					$data['status'] = false;
					$data['message'] = $refund_result['err_msg'];
					$this->ajaxReturn($data);
				} else {
					$refund_data = $refund_result['pay_data'];
					if ($refund_data['result_code'] == 'SUCCESS') {
						D('Return')->where(array('id' => $id))->data(array('refund_status' => 1, 'refund_time' => time()))->save();
						$data = array();
						$data['status'] = true;
						$data['message'] = '退款成功';
						$this->ajaxReturn($data);
					} else {
						$data = array();
						$data['status'] = false;
						$data['message'] = $refund_data['err_code_des'];
						$this->ajaxReturn($data);
					}
				}
			}

			$data = array();
			$data['status'] = false;
			$data['message'] = '参数有误';
			$this->ajaxReturn($data);
		}

		$id = intval($_GET['id']);
		if (empty($id)) {
			echo '缺少参数';
			exit;
		}

		$return = D('Return')->getById($id);
		if ($return['status'] != 5) {
			echo '商家不同意退货或退货未完成';
			exit;
		}

		//主订单id
		$order_id = $return['order_id'];

		$return['status_txt'] = '退货完成，等待退款';
		$return['total'] = $return['product_money'] + $return['postage_money'];

		//已退款
		$refund_total = D('Return')->where(array('order_id' => $order_id, 'refund_status' => 1))->sum('product_money + postage_money');

		$store_list = D('Return')->getProfit($return);

		$order = M('Order')->field('payment_method,third_id,pay_money,postage,cash_point')->where(array('order_id' => $order_id))->find();
		if ($order['payment_method'] == 'point') {
			echo '平台积分全额抵现无法退款';
			exit;
		}

		$cash_point_money = ($order['cash_point'] / $order['point2money_rate']); //抵现积分金额
		$pay_money = $order['pay_money'] - $cash_point_money;
		$order['pay_money'] = number_format($pay_money, 2, '.', '');
		$order['pay_money_balance'] = number_format($pay_money - $refund_total, 2, '.', '');

		$payment_methods = D('OrderView')->getPaymentMethod();
		$order['payment_method'] = $payment_methods[$order['payment_method']];

		$this->assign('return', $return);
		$this->assign('store_list', $store_list);
		$this->assign('order', $order);
		$this->display();
	}
	
	public function rights() {
		$order_no = $this->_get('order_no');
		$type = $this->_get('type');
		$status = $this->_get('status');
		$start_time = $this->_get('start_time');
		$end_time = $this->_get('end_time');
		
		if (!empty($start_time)) {
			$start_time = strtotime($start_time);
		}
		
		if (!empty($end_time)) {
			$end_time = strtotime($end_time);
		}
		
		$where_count = "user_rights_id = '0'";
		$where_list = "r.user_rights_id = '0'";
		if ($order_no) {
			$where_count .= " AND order_no like '%" . $order_no . "%'";
			$where_list .= " AND r.order_no like '%" . $order_no . "%'";
		}
		
		if ($type) {
			$where_count .= " AND type = '" . $type . "'";
			$where_list .= " AND r.type = '" . $type . "'";
		}
		
		if ($status) {
			$where_count .= " AND status = '" . $status . "'";
			$where_list .= " AND r.status = '" . $status . "'";
		}
		
		if ($start_time) {
			$where_count .= " AND dateline >= '" . $start_time . "'";
			$where_list .= " AND r.dateline >= '" . $start_time . "'";
		}
		
		if ($end_time) {
			$where_count .= " AND dateline >= '" . $end_time . "'";
			$where_list .= " AND r.dateline <= '" . $end_time . "'";
		}

		// 区域管理员 只能查看自己区域的店铺
		if ($this->admin_user['type'] == 2) {
			$store_ids = D('Admin')->getAreaStoreIds($this->admin_user);
			if (!empty($store_ids)) {
				$where_count .=  " AND store_id IN (".implode(',', $store_ids).")";
				$where_list .=  " AND r.store_id IN (".implode(',', $store_ids).")";
			} else {
				$where_count .= " AND store_id = false";
				$where_list .= " AND r.store_id = false";
			}
		} else if ($this->admin_user['type'] == 3) {    // 代理商 只能查看自己关联用户的店铺
            $store_ids = D("Admin")->getAgentStoreIds($this->admin_user);
            if (!empty($store_ids)) {
				$where_count .=  " AND store_id IN (".implode(',', $store_ids).")";
				$where_list .=  " AND r.store_id IN (".implode(',', $store_ids).")";
			} else {
				$where_count .= " AND store_id = false";
				$where_list .= " AND r.store_id = false";
			}
        }
		
		$rights_model = D('Rights');
		
		$type_arr = $rights_model->rightsType();
		$status_arr = $rights_model->rightsStatus();
		
		$count = $rights_model->getCount($where_count);
		
		$rights_list = array();
		if ($count > 0) {
			import('@.ORG.system_page');
			$page = new Page($count, 10);
			
			$rights_list = $rights_model->getList($where_list, $page->listRows, $page->firstRow);
			$this->assign('page', $page->show());
		}
		
		$this->assign('type', $type);
		$this->assign('status', $status);
		$this->assign('type_arr', $type_arr);
		$this->assign('status_arr', $status_arr);
		$this->assign('rights_list', $rights_list);
		$this->display();
	}
	
	public function rights_detail() {
		$id = $this->_get('id');
		if (empty($id)) {
			echo '缺少参数';
			exit;
		}
		
		$rights = D('Rights')->getById($id);
		$store_list = D('Rights')->getProfit($rights);
		
		$this->assign('rights', $rights);
		$this->assign('store_list', $store_list);
		$this->display();
	}
	
	public function rights_status() {
		$id = $this->_get('id');
		$status = $this->_get('status');
		$content = $this->_post('content');
		if (empty($id) || empty($status)) {
			echo json_encode(array('status' => false, 'msg' => '缺少参数'));
			exit;
		}
		
		if ($status != 2 && $status != 3) {
			echo json_encode(array('status' => false, 'msg' => '参数值错误'));
			exit;
		}
		
		if ($status == 3 && empty($content)) {
			echo json_encode(array('status' => false, 'msg' => '请填写处理结果'));
			exit;
		}
		
		$rights = D('Rights')->getById($id);
		
		if (empty($rights)) {
			echo json_encode(array('status' => false, 'msg' => '未找到要处理的维权'));
			exit;
		}
		
		if ($status == 2 && $rights['status'] == 2) {
			echo json_encode(array('status' => false, 'msg' => '此维权正在处理中'));
			exit;
		}
		
		if ($rights['status'] == 3) {
			echo json_encode(array('status' => false, 'msg' => '此维权已处理结束'));
			exit;
		}
		
		if ($status == 2) {
			$result = M('Rights')->where("id = '" . $id . "' or user_rights_id = '" . $id . "'")->data(array('status' => 2))->save();
			if ($result) {
				echo json_encode(array('status' => true, 'msg' => '操作完成'));
				exit;
			} else {
				echo json_encode(array('status' => false, 'msg' => '操作失败'));
				exit;
			}
		} else {
			$result = M('Rights')->where("id = '" . $id . "' or user_rights_id = '" . $id . "'")->data(array('complete_dateline' => time(), 'status' => 3, 'platform_content' => $content))->save();
			if ($result) {
				echo json_encode(array('status' => true, 'msg' => '操作完成'));
				exit;
			} else {
				echo json_encode(array('status' => false, 'msg' => '操作失败'));
				exit;
			}
		}
	}
	
	//利润分配记录
	public function promotionRecord () {

		$searchcontent = $this->_request('searchcontent','trim,urldecode');

		if(!empty($searchcontent)) {
            parse_str($searchcontent,$data_arr);
            extract($data_arr);
        }


        $type = empty($type) ? $this->_get('type', 'trim') : trim($type);
        $keyword = empty($keyword) ? $this->_get('keyword', 'trim') : trim($keyword);
        $record_type = empty($record_type) ? $this->_get('record_type', 'trim') : trim($record_type);
 
        $start_time = empty($start_time) ? $this->_get('start_time', 'trim') : trim($start_time);
		$end_time = empty($end_time) ? $this->_get('end_time', 'trim') : trim($end_time);


		$from_type = empty($from_type) ? ($_GET['from_type'] == 1) ? 1 : 0 : intval($from_type);


		// //搜索
		$condition = array();
		if (!empty($type) && !empty($keyword)) {
			if($type == 'store_id'){
				$condition['p.store_id'] = trim($keyword);
			} else if ($type == 'admin_id') {
				$condition['p.admin_id'] = trim($keyword);
			} else if ($type == 'order_no') {
				$condition['o.order_no'] = trim($keyword);
			} else if ($from_type != 1 && $type == 'trade_no') {
				$condition['o.trade_no'] = trim($keyword);
			} else if ($type == 'account') {
				$condition['a.account'] = trim($keyword);
			} else if ($type == 'store') {
				// $condition['s.name'] = array('like', '%' . trim($keyword) . '%');
				$condition['_string'] = 's.name like "%'.trim($keyword).'%"';
			}
		}

		if (!empty($record_type)) {
			if ($record_type == 'plus') {
				$condition['p.type'] = 0;
			} else if ($record_type == 'minus') {
				$condition['p.type'] = 1;
			}
		}

		// 关联订单表 order/order_offline
		$from_order = C('DB_PREFIX')."order as o on p.order_id=o.order_id";
		$from_field = "p.*,o.order_no,o.trade_no,a.account,s.name";
		$condition['p.order_offline_id'] = 0;
		if ($from_type == 1) {
			$from_order = C('DB_PREFIX')."order_offline as o on p.order_offline_id=o.id";
			$from_field = "p.*,o.order_no,a.account,s.name";
			$condition['p.order_offline_id'] = array('gt' , 0);
		}

		if ($start_time && $end_time) {
            $condition['_string'] = "p.add_time >= '" . strtotime($start_time) . "' AND p.add_time <= '" . strtotime($end_time) . "'";
        } else if ($start_time) {
            $condition['p.add_time'] = array('egt', strtotime($start_time));
        } else if ($end_time) {
            $condition['p.add_time'] = array('elt', strtotime($end_time));
        }

        if ($this->admin_user['type'] == 2 || $this->admin_user['type'] == 3) {
        	$condition['p.admin_id'] = $this->admin_user['id'];
        }

		$promotion = D("PromotionRewardLog");
		$promotion_count = $promotion->alias("p")->join(C('DB_PREFIX')."store as s on p.store_id=s.store_id")->where($condition)->count('pigcms_id');
		$download = $this->_get('download','intval',0);

        if(!$download && !empty($searchcontent)){
            $return = array('code'=>'0','msg'=>$promotion_count);
            echo json_encode($return);exit;
        }


        if($download == 1) {
            
            $promotions = $promotion->alias("p")
						->field($from_field)
						->join($from_order)
						->join(C('DB_PREFIX')."admin as a on p.admin_id=a.id")
						->join(C('DB_PREFIX')."store as s on p.store_id=s.store_id")
						->where($condition)
						->order("p.pigcms_id desc")
						->select();

			$sendPayType = D("Admin")->getPromotionType();
			$adminTypeArr = D("AdminGroup")->getAdminType(1);
		
             import('Xls','./source/class');
             $filename = '奖金记录';
         
             $fields = array('订单号','所属推广者','来自店铺','奖励(元)','发送(元)','当时奖励比率(%)','当时服务费','发送信息','备注','时间');
             $data = array();  
             foreach ($promotions as $key => $value) {
             	$admin = D("Admin")->where(array("id"=>$value["send_aid"]))->find();
				$tmp_send_aname= !empty($admin) ? $admin['account'] : "";
				$tmp_send_atype = !empty($admin) ? $adminTypeArr[$admin['type']]['name'] : "";
				$tmp_pay_type = $sendPayType[$value['send_type']]['name'];
				
				if($value['type'] == 0){
					$tmp_amount_1 = '+'.$value['amount'];
				}
				
				if($value['type'] == 1){
					$tmp_amount_2 = '-'.$value['amount'];
				}
			
				if($value['type'] == 1){
					$tmp_msg = '由'. $tmp_send_atype . $tmp_send_aname . '通过' .$tmp_pay_type .'发送'; }
	
                $data[$key] = array('`'.$value['order_no'].'`',$value['account'],$value['name'],$tmp_amount_1,$tmp_amount_2,$value['reward_rate'],$value['service_fee'],$tmp_msg,$value['bak'],date('Y-m-d H:i:s',$value['add_time']));
             }

             Xls::download_csv($filename,$fields,$data); 

        }


		import('@.ORG.system_page');
		$page = new Page($promotion_count, 10);

		$promotions = $promotion->alias("p")
		->field($from_field)
		->join($from_order)
		->join(C('DB_PREFIX')."admin as a on p.admin_id=a.id")
		->join(C('DB_PREFIX')."store as s on p.store_id=s.store_id")
		->where($condition)
		->order("p.pigcms_id desc")
		->limit($page->firstRow . ',' . $page->listRows)->select();

		$sendPayType = D("Admin")->getPromotionType();
		$adminTypeArr = D("AdminGroup")->getAdminType(1);
		foreach ($promotions as $key => $val) {
			$admin = D("Admin")->where(array("id"=>$val["send_aid"]))->find();
			$promotions[$key]['send_aname'] = !empty($admin) ? $admin['account'] : "";
			$promotions[$key]['send_atype'] = !empty($admin) ? $adminTypeArr[$admin['type']]['name'] : "";
			$promotions[$key]['pay_type'] = $sendPayType[$val['send_type']]['name'];
		}

		//推广奖励总额
		$promotion_reward = D('CommonData')->getData(array('key' => 'promotion_reward'));
		$promotion_reward = number_format($promotion_reward, 2, '.', '');

		$today = date('Y-m-d 00:00:00');
		$today = strtotime($today);

		//今日新增推广奖励
		$where = array();
		$where['type'] = 0;
		$where['add_time'] = array('egt', $today);
		$promotion_reward_today = M('PromotionRewardLog')->where($where)->sum('amount');
		$promotion_reward_today = number_format($promotion_reward_today, 2, '.', '');

		//已发放的推广奖励总额
		$promotion_reward_send = D('CommonData')->getData(array('key' => 'promotion_reward_send'));
		$promotion_reward_send = number_format($promotion_reward_send, 2, '.', '');

		//今日已发放的推广奖励
		$where = array();
		$where['type'] = 1;
		$where['add_time'] = array('egt', $today);
		$promotion_reward_send_today = M('PromotionRewardLog')->where($where)->sum('amount');
		$promotion_reward_send_today = number_format($promotion_reward_send_today, 2, '.', '');

		//平台可发放推广奖励
		$withdrawal_service_fee = D('CommonData')->getData(array('key' => 'withdrawal_service_fee'));
		$withdrawal_service_fee = number_format($withdrawal_service_fee, 2, '.', '');

		//平台积分配置
		$credit_setting = M('credit_setting')->find();

		$this->assign("from_type", $from_type);
		$this->assign("promotions", $promotions);
		$this->assign('page', $page->show());
		$this->assign('promotion_reward', $promotion_reward);
		$this->assign('withdrawal_service_fee', $withdrawal_service_fee);
		$this->assign('promotion_reward_send', $promotion_reward_send);
		$this->assign('promotion_reward_today', $promotion_reward_today);
		$this->assign('promotion_reward_send_today', $promotion_reward_send_today);
		$this->assign('platform_credit_open', $credit_setting['platform_credit_open']);

	    $this->display();
	}

	public function myPromotionRecord () {

		$from_type = ($_GET['from_type'] == 1) ? 1 : 0;

		// //搜索
		$condition = array();

		if (!empty($_GET['record_type'])) {
			if ($_GET['record_type'] == 'plus') {
				$condition['p.type'] = 0;
			} else if ($_GET['record_type'] == 'minus') {
				$condition['p.type'] = 1;
			}
		}

		// 关联订单表 order/order_offline
		$from_order = C('DB_PREFIX')."order as o on p.order_id=o.order_id";
		$from_field = "p.*,o.order_no,o.trade_no,a.account,s.name";
		$condition['p.order_offline_id'] = 0;
		if ($from_type == 1) {
			$from_order = C('DB_PREFIX')."order_offline as o on p.order_offline_id=o.id";
			$from_field = "p.*,o.order_no,a.account,s.name";
			$condition['p.order_offline_id'] = array('gt' , 0);
		}

		if ($this->_get('start_time', 'trim') && $this->_get('end_time', 'trim')) {
            $condition['_string'] = "p.add_time >= '" . strtotime($this->_get('start_time', 'trim')) . "' AND p.add_time <= '" . strtotime($this->_get('end_time')) . "'";
        } else if ($this->_get('start_time', 'trim')) {
            $condition['p.add_time'] = array('egt', strtotime($this->_get('start_time', 'trim')));
        } else if ($this->_get('end_time', 'trim')) {
            $condition['p.add_time'] = array('elt', strtotime($this->_get('end_time', 'trim')));
        }

        if ($this->admin_user['type'] == 2 || $this->admin_user['type'] == 3) {
        	$condition['p.admin_id'] = $this->admin_user['id'];
        } else {
        	$this->frame_error_tips("仅允许客户经理(代理商)和区域管理员访问");
        }

		$promotion = D("PromotionRewardLog");

		$promotion_count = $promotion->alias("p")->where($condition)->count('pigcms_id');
		import('@.ORG.system_page');
		$page = new Page($promotion_count, 10);

		$promotions = $promotion->alias("p")
		->field($from_field)
		->join($from_order)
		->join(C('DB_PREFIX')."admin as a on p.admin_id=a.id")
		->join(C('DB_PREFIX')."store as s on p.store_id=s.store_id")
		->where($condition)
		->order("p.pigcms_id desc")
		->limit($page->firstRow . ',' . $page->listRows)->select();

		$sendPayType = D("Admin")->getPromotionType();
		$adminTypeArr = D("AdminGroup")->getAdminType(1);
		foreach ($promotions as $key => $val) {
			$admin = D("Admin")->where(array("id"=>$val["send_aid"]))->find();
			$promotions[$key]['send_aname'] = !empty($admin) ? $admin['account'] : "";
			$promotions[$key]['send_atype'] = !empty($admin) ? $adminTypeArr[$admin['type']]['name'] : "";
			$promotions[$key]['pay_type'] = $sendPayType[$val['send_type']]['name'];
		}

		$this->assign("from_type", $from_type);
		$this->assign("promotions", $promotions);
		$this->assign('page', $page->show());

	    $this->display();

	}

	// 区域管理员下属的奖金记录
	public function subPromotionRecord () {

		$from_type = ($_GET['from_type'] == 1) ? 1 : 0;
		// 默认查看下属区域管理订单流水记录0， 1为查看关联的代理商订单流水记录
		$admin_type = isset($_GET['admin_type']) ? intval($_GET['admin_type']) : 0;	

		// //搜索
		$condition = array();

		if (!empty($_GET['record_type'])) {
			if ($_GET['record_type'] == 'plus') {
				$condition['p.type'] = 0;
			} else if ($_GET['record_type'] == 'minus') {
				$condition['p.type'] = 1;
			}
		}

		// 关联订单表 order/order_offline
		$from_order = C('DB_PREFIX')."order as o on p.order_id=o.order_id";
		$from_field = "p.*,o.order_no,o.trade_no,a.account,s.name";
		$condition['p.order_offline_id'] = 0;
		if ($from_type == 1) {
			$from_order = C('DB_PREFIX')."order_offline as o on p.order_offline_id=o.id";
			$from_field = "p.*,o.order_no,a.account,s.name";
			$condition['p.order_offline_id'] = array('gt' , 0);
		}

		if ($this->_get('start_time', 'trim') && $this->_get('end_time', 'trim')) {
            $condition['_string'] = "p.add_time >= '" . strtotime($this->_get('start_time', 'trim')) . "' AND p.add_time <= '" . strtotime($this->_get('end_time')) . "'";
        } else if ($this->_get('start_time', 'trim')) {
            $condition['p.add_time'] = array('egt', strtotime($this->_get('start_time', 'trim')));
        } else if ($this->_get('end_time', 'trim')) {
            $condition['p.add_time'] = array('elt', strtotime($this->_get('end_time', 'trim')));
        }

        if ($this->admin_user['type'] != 2) {
        	$this->frame_error_tips("仅允许区域管理员访问");
        }

        // 添加到过滤条件
        if ($admin_type == 0) {	// 查看下属区域管理员 admin_ids
        	$admin_ids = D('Admin')->getAreaAdminIds($this->admin_user);
            if (!empty($admin_ids)) {
                $condition['p.admin_id'] = array('in', $admin_ids);
            } else {
                $condition['p.admin_id'] = false;
            }
        } else {	// 查看关联代理商 admin_ids
        	$admin_ids = D("Admin")->getAgentAdminIds($this->admin_user);
            if (!empty($admin_ids)) {
                $condition['p.admin_id'] = array('in', $admin_ids);
            } else {
                $condition['p.admin_id'] = false;
            }
        }

        // dump($admin_ids);exit;

		$promotion = D("PromotionRewardLog");

		$promotion_count = $promotion->alias("p")->where($condition)->count('pigcms_id');
		import('@.ORG.system_page');
		$page = new Page($promotion_count, 10);

		$promotions = $promotion->alias("p")
		->field($from_field)
		->join($from_order)
		->join(C('DB_PREFIX')."admin as a on p.admin_id=a.id")
		->join(C('DB_PREFIX')."store as s on p.store_id=s.store_id")
		->where($condition)
		->order("p.pigcms_id desc")
		->limit($page->firstRow . ',' . $page->listRows)->select();

		$sendPayType = D("Admin")->getPromotionType();
		$adminTypeArr = D("AdminGroup")->getAdminType(1);
		foreach ($promotions as $key => $val) {
			$admin = D("Admin")->where(array("id"=>$val["send_aid"]))->find();
			$promotions[$key]['send_aname'] = !empty($admin) ? $admin['account'] : "";
			$promotions[$key]['send_atype'] = !empty($admin) ? $adminTypeArr[$admin['type']]['name'] : "";
			$promotions[$key]['pay_type'] = $sendPayType[$val['send_type']]['name'];
		}

		$this->assign("from_type", $from_type);
		$this->assign("admin_type", $admin_type);
		$this->assign("promotions", $promotions);
		$this->assign('page', $page->show());

	    $this->display();
	}

	//数据概览
	public function dataOverview(){
	    //平台总资产
	    
	    $this->display();
	}
} 