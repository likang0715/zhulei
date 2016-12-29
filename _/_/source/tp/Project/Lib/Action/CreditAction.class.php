<?php
/**
 * 积分配置类
 * @author
 * @version 1.0
 */
class CreditAction extends BaseAction{

	public function _initialize() {
		parent::_initialize();

		$map['key'] =  array(array('eq','margin'),array('eq','promotion_reward'),array('eq','income'), 'or');
		$common_data = M('common_data')->where($map)->select();
		
		$commons_data = array();
		foreach($common_data as $k=>$v) {
			$commons_data[$v['key']] = $v;
		}
		$this->commons_data = $commons_data;
		$this->common_data = $common_data;

		//未处理的返还提现数量
		$this->unprocessed = M('PlatformMarginLog')->where(array('type' => 1, 'status' => 1))->count('pigcms_id');
		$this->assign('unprocessed', $this->unprocessed);
	}


	public function index() {

		//获取发送积分的用户
		$this->user_count = M('user')->where(array('status'=>1))->count();

		$this->user_point_balance = M('user')->where(array('status'=>1))->sum('point_balance');
		
		$this->user_point_pool = M('user')->where(array('status'=>1))->sum('point_unbalance');;

		$this->store_point_balance = M('store')->sum('point_balance');

		$this->store_point2money = M('store')->sum('point2money');

		//每日平台服务费流水
		$this->day_platform_service_fee = M('day_platform_service_fee')->where(array('add_date'=>date('Ymd',strtotime('-1 day'))))->getField('amount');

		$this->info = $credit_setting = M('credit_setting')->find();

		$credit_weight = (!empty($credit_setting['credit_weight'])) ? $credit_setting['credit_weight'] : 500; 

		//用户分享积分总额
		$this->user_share_point_max = M('user')->where(array('status'=>1))->sum('point_gift');

		//是否需要发放积分

		$this->release_count = M('release_point')->where(array('add_date'=>date('Ymd'),'status'=>1))->count();

		//当前剩余备付金
		$this->cash_provision_balance_now = M('common_data')->where(array('key'=>'cash_provision_balance'))->getField('value');

		//昨日备付金总额（单日）
		$this->cash_provision_balance_yestoday = M('cash_provision_log')->where(array('add_date'=>date('Ymd',strtotime('-1 day')),'type'=>'0'))->sum('amount');
		
		//截止昨日备付金剩余 （时间小于今天的最后一次统计）今日新增 （时时的）
		$this->cash_provision_balance_until_yestoday = M('cash_provision_log')->where(' type=0 and add_date <'.date('Ymd'))->order('pigcms_id desc')->getField('cash_provision_balance + amount');

		
		$this->cash_provision_balance_today =  M('cash_provision_log')->where(array('add_date'=>date('Ymd'),'type'=>'0'))->sum('amount');

		
		//获取计算的权数 

		$point_weight_arr = $this->getRealCreditWeight($credit_weight,$this->cash_provision_balance_yestoday);

		$this->real_point_weight = $point_weight_arr['point_weight'];

		//今日需发放积分点数最大值
		//$this->today_send_point_max = floor($this->user_point_pool / $credit_weight);
		$this->today_send_point_max = $point_weight_arr['day_send_all_points'];
		
		$this->display();
	}

	public function sendLog() {

		$condition = array();

		if ($this->_get('start_time', 'trim') && $this->_get('end_time', 'trim')) {
			
			$condition['_string'] = "ReleasePointLog.add_time >= '" . strtotime($this->_get('start_time', 'trim')) . "' AND ReleasePointLog.add_time <= '" . strtotime($this->_get('end_time')) . "'";
		
		} else if ($this->_get('start_time', 'trim')) {
		
			$condition['ReleasePointLog.add_time'] = array('egt', strtotime($this->_get('start_time', 'trim')));
		
		} else if ($this->_get('end_time', 'trim')) {
		
			$condition['ReleasePointLog.add_time'] = array('elt', strtotime($this->_get('end_time', 'trim')));
		
		}

		$release_point_log_model = D('ReleasePointLogView');

		$list_count = $release_point_log_model->where($condition)->count();

		import('@.ORG.system_page');

		$page = new Page($list_count, 10);

		$this->list = $release_point_log_model->where($condition)->order("ReleasePointLog.pigcms_id DESC")->limit($page->firstRow . ',' . $page->listRows)->select();

		$this->page = $page->show();

		$this->display();

	}


	public function cashProvisionLog(){

		$condition = array();

		$store = empty($store) ? $this->_get('store', 'trim') : trim($store);

		$type =  empty($type)  ? $this->_get('type', 'trim,intval') : intval(trim($type));

		$order_no = empty($order_no) ? $this->_get('order_no', 'trim') : trim($order_no);

		if ($this->_get('start_time', 'trim') && $this->_get('end_time', 'trim')) {
			
			$condition['_string'] = "CashProvisionLog.add_time >= '" . strtotime($this->_get('start_time', 'trim')) . "' AND CashProvisionLog.add_time <= '" . strtotime($this->_get('end_time')) . "'";
		
		} else if ($this->_get('start_time', 'trim')) {
		
			$condition['CashProvisionLog.add_time'] = array('egt', strtotime($this->_get('start_time', 'trim')));
		
		} else if ($this->_get('end_time', 'trim')) {
		
			$condition['CashProvisionLog.add_time'] = array('elt', strtotime($this->_get('end_time', 'trim')));
		
		}

		$cash_provision_log_model = D('CashProvisionLogView');

		if($store) {
			$condition['Store.name'] = array('like', '%' . $store . '%');
		}

		if(!empty($type)) {
			if($type == 1) {
				$condition['CashProvisionLog.type'] = 0;
			}else if($type == 2) {
				$condition['CashProvisionLog.type'] = 2;
			}
		}


		if($order_no) {
  			$condition['CashProvisionLog.order_no'] = $order_no;
  		}


		$list_count = $cash_provision_log_model->where($condition)->count();

		import('@.ORG.system_page');

		$page = new Page($list_count, 10);

		$this->list = $cash_provision_log_model->where($condition)->order("CashProvisionLog.pigcms_id DESC")->limit($page->firstRow . ',' . $page->listRows)->select();

		$this->page = $page->show();

		$this->display();

	}



	public function chgStatus() {

		$id = $this->_post('id', 'trim,intval');
	
		$name = $this->_post('name', 'trim');
	
		$status = $this->_post('status', 'trim,intval');		
		
		if($name == 'platform_credit_open' || $name == 'store_credit_open' || $name == 'force_use_platform_credit' || $name == 'recharge_notice_open' || $name == 'open_user_give_point' || $name == 'open_margin_withdrawal') {

			M('credit_setting')->where(array('id' => $id))->save(array($name => $status));
		
		}
		 
	}

	public function chgTodayCreditWeight() {

		$id = $this->_post('id', 'trim,intval');
		
		$today_credit_weight = $this->_post('today_credit_weight', 'trim');

		//权数只能为小于等于1的数值

		/*
		if ($today_credit_weight > 1) {
			$today_credit_weight = 1;
		} else if ($today_credit_weight <= 0) {
			$today_credit_weight = 0.01;
		}*/

		$today_credit_weight = ($today_credit_weight > 1) ? 1 : $today_credit_weight;

		M('credit_setting')->where(array('id' => $id))->save(array('today_credit_weight' => $today_credit_weight));

	}

	/**
	 * 充值现金余额最低限额
	 */
	public function chgMinMarginBalance()
	{
		$id = $this->_post('id', 'trim,intval');
		$min_margin_balance = $this->_post('min_margin_balance', 'trim');

		M('credit_setting')->where(array('id' => $id))->save(array('min_margin_balance' => $min_margin_balance));
	}

	/**
	 * 单日最大通知次数(保证充值)
	 */
	public function chgDayNoticeMaxcount()
	{
		$id = $this->_post('id', 'trim,intval');
		$recharge_notice_maxcount = $this->_post('recharge_notice_maxcount', 'trim');

		M('credit_setting')->where(array('id' => $id))->save(array('recharge_notice_maxcount' => $recharge_notice_maxcount));
	}

	/**
	 * 充值现金余额提现最低额度
	 */
	public function chgMarginWithdrawalAmountMin()
	{
		$id = $this->_post('id', 'trim,intval');
		$margin_withdrawal_amount_min = $this->_post('margin_withdrawal_amount_min', 'trim');

		M('credit_setting')->where(array('id' => $id))->save(array('margin_withdrawal_amount_min' => $margin_withdrawal_amount_min));
	}

	/**
	 * 用户积分互赠服务费
	 */
	public function chgGivePointServiceFee()
	{
		$id = $this->_post('id', 'trim,intval');
		$give_point_service_fee = $this->_post('give_point_service_fee', 'trim');

		M('credit_setting')->where(array('id' => $id))->save(array('give_point_service_fee' => $give_point_service_fee));
	}

	//获取真实今日积分权数/当日发放积分数点数总值
	private function getRealCreditWeight($credit_weight,$cash_provision_balance='') {
		
		
		//平台服务费
		/*
		$platform_service_charge = M('day_platform_service_fee')->where(array('add_date'=>date('Ymd',strtotime('-1 day'))))->getField('amount');*/
		
		/*
		//昨日用户池总值
			$yestoday_user_pool = M('day_platform_point')->where(array('add_date'=>date('Ymd',strtotime('-1 day'))))->getField('point');
		*/

		//当日发放积分数点数总值 new
	  
		// $condition['_string'] = "add_date < " . date('Ymd') . " AND type = 0 ";

		// $sub_query = M('user_point_log')->field('max(pigcms_id)')->where($condition)->group('uid')->buildSql();

		// //截止昨日用户累计积分总值
		// $yestoday_user_pool = M('user_point_log')->where('pigcms_id in '.$sub_query.' and point_total >='.$credit_weight)->sum('point_total + point');


		//当日发放积分数点数总值 new2

		$condition['_string'] = "add_date < " . date('Ymd') . " AND type in(0, 5, 6, 7) ";

		$temp_ids_arr = M('user_point_log')->field('max(pigcms_id)')->where($condition)->group('uid')->getField('max(pigcms_id),uid');

		//截止昨日用户累计积分总值(基数)
		$yestoday_user_pool = M('user_point_log')->where('pigcms_id in ('.join(',',array_keys($temp_ids_arr)).') and point_send_base >='.$credit_weight)->sum('point_send_base');

		//当日发放积分数点数总值
		$day_send_all_points = floor($yestoday_user_pool / $credit_weight);

		//获取昨日提现备付金
		if(!$cash_provision_balance){
			$cash_provision_balance = M('cash_provision_log')->where(array('add_date'=>date('Ymd',strtotime('-1 day')),'type'=>'0'))->sum('amount');
		}

		$point_weight = $cash_provision_balance / $day_send_all_points;

		$point_weight = number_format($point_weight, 2, '.', '');

		return array('point_weight'=>$point_weight,'day_send_all_points'=>$day_send_all_points);
	
	}


	public function prepareSend() {

		$credit_setting = M('credit_setting')->find();

		//满 xx 就可以获得一个积分点数(积分权数值 后台设置)
		$credit_weight = (!empty($credit_setting['credit_weight'])) ? $credit_setting['credit_weight'] : 500; 

		//获取平台积分权数(优先读取配置)
		$point_weight = $credit_setting['today_credit_weight']; 


		if(!$point_weight || $point_weight == '0.00') {
			
			$point_weight = $this->getRealCreditWeight($credit_weight); //获取计算的权数

			$point_weight = $point_weight['point_weight'];

			$point_weight = ($point_weight > 1) ? 1 : $point_weight;

		}

		//权数最小值为0.01
		if ($point_weight <= 0) {
			$point_weight = 0.01;
		}

		//添加平台释放积分统计

		$release_id = M('release_point')->where(array('add_date'=>date('Ymd')))->getField('pigcms_id');

		if(!$release_id) {
			$release_id = M('release_point')->data(array('add_time'=>time(),'add_date'=>date('Ymd')))->add();
		}
		
		$sdata = array(
				'credit_weight'=>$credit_weight,
				'point_weight'=>$point_weight,
				'release_id'=>$release_id,
			);

		$return = array('code'=>'0','sdata'=>$sdata);
		
		echo json_encode($return);exit;
   

	}



	public function sendPoints() {
		set_time_limit(0);
		usleep(500000);
		$page = $this->_post('page', 'trim,intval',1);
		$persend = $this->_post('persend', 'trim,intval',500);
		$start = ($page-1) * $persend;
		$user_list = M('user')->field('uid,point_balance,point_unbalance,point_total')->where(array('status'=>1))->order("uid DESC")->limit($start . ',' . $persend)->select();

		$credit_weight = $this->_post('credit_weight', 'trim');

		$users_count = $this->_post('users_count', 'trim');
		
		$points_count = $this->_post('points_count', 'trim');
		
		$point_weight = $this->_post('point_weight', 'trim');
		
		$release_id = $this->_post('release_id', 'trim,intval');


		foreach ($user_list as $key => $value) {
			
			//获取用户当天释放日志记录 如果有 则不发放
			$user_send_data = M('release_point_log')->field('uid,point,add_date')->where(array('add_date'=>date('Ymd'),'uid'=>$value['uid']))->find();

			if(!$user_send_data) {

				//获取用户发放积分点数

				//$yestoday_point_total = M('user_point_log')->where('uid='.$value['uid'].' and type=0 and add_date <'.date('Ymd'))->order('pigcms_id desc')->getField('point_total + point');

				//获取用户发放积分基数
				$yestoday_point_total = M('user_point_log')->where('uid='.$value['uid'].' and type in(0, 5, 6, 7) and add_date <'.date('Ymd'))->order('pigcms_id desc')->getField('point_send_base');

				$day_send_point = floor($yestoday_point_total / $credit_weight);

				$day_send_points = $day_send_point * $point_weight;

				$day_send_points = number_format($day_send_points, 2, '.', '');

				//获取用户当前消费积分余额

				$now_user_point_unbalance = $value['point_unbalance'];

				if($day_send_points > 0 && $now_user_point_unbalance >= $day_send_point ) {

					//在积分池中减去 所发放的积分点数
					M('user')->where('uid='.$value['uid'])->setDec('point_unbalance',$day_send_point);

					//发送积分
					M('user')->where('uid='.$value['uid'])->setInc('point_balance',$day_send_points);
							

					//基数变动

					$point_unbalance = (($value['point_unbalance'] - $day_send_point) > 0) ? ($value['point_unbalance'] - $day_send_point) : 0;

					$tmp_log = M('user_point_log')->field('point_send_base')->where(array('uid' => $value['uid'], 'type' => array('in' , array(0, 5, 6, 7))))->order('pigcms_id DESC')->find();
	                
	                //生成新的基数
	                import('SendPoints','./source/class');
					$point_send_base = SendPoints::getCardinalNumber($tmp_log['point_send_base'], $point_unbalance, $credit_weight);


					//记录
					$record_data = array(
							'release_id'=>$release_id,
							'uid'=>$value['uid'],
							'point'=>$day_send_points,
							'add_time'=>time(),
							'add_date'=>date('Ymd'),
							'send_point'=>$day_send_point,
							'point_weight'=>$point_weight,
							'user_point_balance'=>$value['point_balance'],
							'user_point_total'=>$value['point_total'],
							'point_send_base'=>$point_send_base,
						);
				   
					M('release_point_log')->data($record_data)->add();

					

					//发放扣除不可用积分流水

					$dec_data = array();
			       
			        $dec_data['uid'] = $value['uid'];
			        $dec_data['point'] = $day_send_point * -1;
			        $dec_data['status'] = 1;
			        $dec_data['type'] = 8; //发放扣除不可用积分
			        $dec_data['channel'] = 0;
			        $dec_data['bak'] = '扣除发放的消费积分';
			        $dec_data['add_time'] = time();
			        $dec_data['add_date'] = date('Ymd');
			        $dec_data['point_total'] = $value['point_total'];
			        $dec_data['point_balance'] = $value['point_balance'];
			        $dec_data['point_unbalance'] = $value['point_unbalance'];
			        $dec_data['point_send_base'] = $point_send_base;

					M('User_point_log')->data($dec_data)->add();



					//添加用户积分流水

				 	$log_data = array();
			       
			        $log_data['uid'] = $value['uid'];
			        $log_data['point'] = $day_send_points;
			        $log_data['status'] = 1;
			        $log_data['type'] = 7; //发放获得积分
			        $log_data['channel'] = 0;
			        $log_data['bak'] = '获得可用积分';
			        $log_data['add_time'] = time();
			        $log_data['add_date'] = date('Ymd');
			        $log_data['point_total'] = $value['point_total'];
			        $log_data['point_balance'] = $value['point_balance'];
			        $log_data['point_unbalance'] = $value['point_unbalance'];
			        $log_data['point_send_base'] = $point_send_base;


			        M('User_point_log')->data($log_data)->add();

					$users_count += 1;
					$points_count += $day_send_points;

				 }
			
			}else{
				 $users_count += 1;
				 $points_count += $user_send_data['point'];
			}

			
		}

		$return = array('code'=>'0','users_count'=>$users_count,'points_count'=>$points_count);
		
		echo json_encode($return);exit;
	}

	public function afterSend() {

		$data['users'] = $this->_post('users_count', 'trim');
		
		$data['point_total'] = $this->_post('points_count', 'trim');

		$data['pigcms_id'] = $this->_post('release_id', 'trim,intval');

		$data['status'] = 1;


		//获取当前的备付金

		//$data['cash_provision_balance_before'] = M('common_data')->where(array('key'=>'cash_provision_balance'))->getField('value');

		//减去总积分

		//M('common_data')->where(array('key'=>'cash_provision_balance'))->setDec('value',$data['point_total']);

		//$data['cash_provision_balance'] = $data['cash_provision_balance_before'] - $data['point_total'];

		M('release_point')->save($data);

		//生成备付金流水
		//M('cash_provision_log')->data(array('amount'=>$data['point_total'],'point'=>$data['point_total'],'type'=>1,'add_time'=>time(),'add_date'=>date('Ymd'),'cash_provision_balance'=>$data['cash_provision_balance']))->add();

		$id = $this->_post('id', 'intval');

	   //每次发放完毕 清空今日配置
		M('credit_setting')->where(array('id' =>$id))->save(array('today_credit_weight' => '0'));


		$return = array('code'=>'0');

		echo json_encode($return);exit;

	}
	
	public function rules() {
		
		$this->info = M('credit_setting')->find();
		
		$this->display();

	}

	public function upRules() {

		if(IS_POST) {

			if($_POST['id']) {

				$status	 = M('credit_setting')->data($_POST)->save();
			
			}else{

				$status	 = M('credit_setting')->data($_POST)->add();
				
			}
			if($status) {
				//清除配置文件缓存
				import('ORG.Util.Dir');
				Dir::delDirnotself('./cache');
				$this->success('修改成功！');
			
			}else{
				
				$this->error('修改失败！请检查是否有过修改后重试~');
			
			}
		}else{

			$this->error('非法提交,请重新提交~');
		}

	}

	public function depositRecord() {

		$searchcontent = $this->_request('searchcontent','trim,urldecode');
		$searchtype = $this->_request('searchtype','intval',0);
		if(!empty($searchcontent)) {
			parse_str($searchcontent,$data_arr);
			extract($data_arr);
		}

		$store = empty($store) ? $this->_get('store', 'trim') : trim($store);
		$type =  empty($type)  ? $this->_get('type', 'trim,intval') : intval(trim($type));
		$status =  empty($status)  ? $this->_get('status', 'trim,intval') : intval(trim($status));
		$order_no = empty($order_no) ? $this->_get('order_no', 'trim') : trim($order_no);
		$start_time = empty($start_time) ? $this->_get('start_time', 'trim') : trim($start_time);
		$end_time = empty($end_time) ? $this->_get('end_time', 'trim') : trim($end_time);
		$payment_method = empty($payment_method) ? $this->_get('payment_method', 'trim') : trim($payment_method);
		
		$province = empty($province) ? $this->_get('province', 'trim') : trim($province);
		$city = empty($city) ? $this->_get('city', 'trim') : trim($city);
		$county = empty($county) ? $this->_get('county', 'trim') : trim($county);
		
		$plat_form_margin_log_model = D('PlatformMarginLogView');

		if($store) {
			$where['Store.name'] = array('like', '%' . $store . '%');
		}
		if($province) {
			$where['sc.province'] = $province;
			$this->province = $province;
		}
		if($city) {
			unset($where['sc.province']);
			$where['sc.city'] = $city;
			$this->city = $city;
		}
		if($county) {
			unset($where['sc.city']);
			$where['sc.county'] = $county;
			$this->county = $county;
		}

		if(!empty($type)) {
			if($type == 1) {
				$where['PlatformMarginLog.type'] = 0;
			}else if($type == 2) {
				$where['PlatformMarginLog.type'] = 2;
			}else if($type == 3) {
				$where['PlatformMarginLog.type'] = 1;
			}else if($type == 4) {
				$where['PlatformMarginLog.type'] = 3;
			}
		}


		if(!empty($status)) {
			if($status == 1) {
				$where['PlatformMarginLog.status'] = 0;
			}else if($status == 2) {
				$where['PlatformMarginLog.status'] = 1;
			}else if($status == 3) {
				$where['PlatformMarginLog.status'] = 2;
			}
		}

		if (!empty($payment_method)) {
			$where['PlatformMarginLog.payment_method'] = $payment_method;
		}

  		if($order_no) {
  			$where['PlatformMarginLog.order_no'] = $order_no;
  		}
		
		if ($start_time && $end_time) {

			$where['_string'] = "PlatformMarginLog.add_time >= '" . strtotime($start_time) . "' AND PlatformMarginLog.add_time <= '" . strtotime($end_time) . "'";
		
		} else if ($start_time) {
		
			$where['PlatformMarginLog.add_time'] = array('egt', strtotime($start_time));
		
		} else if ($end_time) {
		
			$where['PlatformMarginLog.add_time'] = array('elt', strtotime($end_time));
		
		}

		// 区域管理员 只能查看自己区域的店铺
		if ($this->admin_user['type'] == 2) {
			$store_ids = D('Admin')->getAreaStoreIds($this->admin_user);
			if (!empty($store_ids)) {
				$where['PlatformMarginLog.store_id'] = array('in', $store_ids);
			} else {
				$where['PlatformMarginLog.store_id'] = false;
			}
		} else if ($this->admin_user['type'] == 3) {	// 代理商 只能查看自己关联用户的店铺
			$store_ids = D("Admin")->getAgentStoreIds($this->admin_user);
			if (!empty($store_ids)) {
				$where['PlatformMarginLog.store_id'] = array('in', $store_ids);
			} else {
				$where['PlatformMarginLog.store_id'] = false;
			}
		}	

		
		$download = $this->_get('download','intval');

		if($download == 1) {

			if($searchtype == 1) {
				$list = D('PlatformMarginLogView')->where()->order("PlatformMarginLog.pigcms_id DESC")->select();
			}else if($searchtype == 2) {
				$list = D('PlatformMarginLogView')->where($where)->order("PlatformMarginLog.pigcms_id DESC")->select();
			}

			//区域管理员 代理商

			foreach($list as $k => $v) {
				
				$tmp_store_id = $v['store_id'];

				$store = D("Store")->field('uid')->where(array('store_id' => $tmp_store_id))->find();

				
				$user = D("User")->where(array('uid' => $store['uid']))->find();

				
				$database_admin = D("Admin");

		        // 代理商
		        if ($user['invite_admin'] != 0 && $agent_admin = $database_admin->where(array('id' => $user['invite_admin']))->find()) {
		           
		          $list[$k]['invite_admin'] =  $agent_admin['account'];
		        }

		        //区域管理

		        $store_area_record = D("Store_area_record")->where(array('store_id' => $tmp_store_id, 'status' => 1))->find();

		        $where_qy['_string'] = "(county = " . $store_area_record['county'] . " AND type = 2 AND area_level = 3) OR (city = " . $store_area_record['city'] . " AND type = 2 AND area_level = 2) OR (province = " . $store_area_record['province'] . " AND type = 2 AND area_level = 1)";
	            $area_admin = $database_admin->where($where_qy)->order('area_level desc')->find();
	            
	            $list[$k]['area_admin'] =  $area_admin['account'];


			}

			
			$this->_download_csv($list);
		
		}else{
			switch ($searchtype) {
				case '1':
					$list_count = $plat_form_margin_log_model->where()->count();
					$return = array('code'=>'0','msg'=>$list_count);
					echo json_encode($return);exit;
					break;
				case '2':
					$list_count = $plat_form_margin_log_model->where($where)->count();
					$return = array('code'=>'0','msg'=>$list_count);
					echo json_encode($return);exit;
					break;		
				default:
					$list_count = $plat_form_margin_log_model->where($where)->count();
					break;
			}
		}
		
		import('@.ORG.system_page');

		$page = new Page($list_count, 10);

		$list = $plat_form_margin_log_model->where($where)->order("PlatformMarginLog.pigcms_id DESC")->limit($page->firstRow . ',' . $page->listRows)->select();
		
		
		//区域管理员 代理商

		foreach($list as $k => $v) {
			
			$tmp_store_id = $v['store_id'];

			$store = D("Store")->field('uid')->where(array('store_id' => $tmp_store_id))->find();

			
			$user = D("User")->where(array('uid' => $store['uid']))->find();

			
			$database_admin = D("Admin");

	        // 代理商
	        if ($user['invite_admin'] != 0 && $agent_admin = $database_admin->where(array('id' => $user['invite_admin']))->find()) {
	           
	          $list[$k]['invite_admin'] =  $agent_admin['account'];
	        }

	        //区域管理

	        $store_area_record = D("Store_area_record")->where(array('store_id' => $tmp_store_id, 'status' => 1))->find();

	        $where_qy['_string'] = "(county = " . $store_area_record['county'] . " AND type = 2 AND area_level = 3) OR (city = " . $store_area_record['city'] . " AND type = 2 AND area_level = 2) OR (province = " . $store_area_record['province'] . " AND type = 2 AND area_level = 1)";
            $area_admin = $database_admin->where($where_qy)->order('area_level desc')->find();
            
            $list[$k]['area_admin'] =  $area_admin['account'];


		}

		$this->list = $list;

		/*$lists = array();
		foreach($list as $k => $v) {
			$store_id_arr[] = $v['store_id'];
		}
		$profit_admin = array();
		foreach($store_id_arr as $v) {
			$profit = D("AdminBonusConfig")->getProfitAdmins($v);
			if(is_array($profit)) {
				foreach($profit as $k=>$vs) {
					$profit_admin[$v][$vs['type']][] = $vs;
				}
			}
			
		}*/
		//$this->profit_admin = $profit_admin;
	
		$wheres = array();$wheres2 = array();$wheres3 = array();
		//当前搜索结果的充入，平台扣除统计
		
		$wheres = array(
			'PlatformMarginLog.amount' => array('GT',0),
			'PlatformMarginLog.status' => 2,
		);
		if($where) {
			$where_tmp = $where;
			unset($where_tmp['PlatformMarginLog.status']);
			//如状态为取消则修改类型
			if($status == 3){
				$where_tmp['PlatformMarginLog.type'] = 1;
			}
			$wheres = array_merge($wheres,$where_tmp);
		}
		$get_margin_count = $plat_form_margin_log_model->where($wheres)->field()->sum('amount');
		unset($wheres);
		$wheres2 = array(
			'PlatformMarginLog.amount' => array('LT',0),
			'PlatformMarginLog.status' => 2,
		);
		if($where) {
			$where_tmp = $where;
			unset($where_tmp['PlatformMarginLog.status']);
			//如状态为取消则修改类型
			if($status == 3){
				$where_tmp['PlatformMarginLog.type'] = 1;
			}
			$wheres2 = array_merge($wheres2,$where_tmp);
		}

		$out_margin_count = $plat_form_margin_log_model->where($wheres2)->field()->sum('amount');

		unset($wheres2);
		$wheres3 = array(
			'PlatformMarginLog.type' => 1,
			'PlatformMarginLog.status' => 2,
		);
		if($where) {
			$where_tmp = $where;
			unset($where_tmp['PlatformMarginLog.type']);
			unset($where_tmp['PlatformMarginLog.status']);
			$wheres3 = array_merge($wheres3,$where_tmp);
		}
		
		$return_margin_count = $plat_form_margin_log_model->where($wheres3)->field()->sum('amount');
		
		unset($wheres3);

		$this->payment_methods = D('Config')->get_margin_payment();
		$payment_methods = array();
		foreach ($this->payment_methods as $key => $payment_method) {
			unset($this->payment_methods[$key]);
			$payment_methods[str_replace('platform_', '', $key)] = $payment_method;
		}
		$this->payment_methods = $payment_methods;

		$this->return_margin_count = ($return_margin_count == 0) ? 0:abs($return_margin_count);
		$this->get_margin_count = ($get_margin_count == 0) ? 0:abs($get_margin_count);
		$this->out_margin_count = ($out_margin_count == 0) ? 0:abs($out_margin_count);

		$this->page = $page->show();
		$this->nowtype = $type;
		$this->selected_payment_method = $payment_method;
		$this->typelist = array('全部','充值','扣除','返还','退单');

		$this->display();

	}

	// 代理商/客户经理 管辖的店铺充值记录
	public function myDepositRecord () {

		$searchcontent = $this->_request('searchcontent','trim,urldecode');
		$searchtype = $this->_request('searchtype','intval',0);
		if(!empty($searchcontent)) {
			parse_str($searchcontent,$data_arr);
			extract($data_arr);
		}

		$store = empty($store) ? $this->_get('store', 'trim') : trim($store);
		$status =  empty($status)  ? $this->_get('status', 'trim,intval') : intval(trim($status));
		$order_no = empty($order_no) ? $this->_get('order_no', 'trim') : trim($order_no);
		$start_time = empty($start_time) ? $this->_get('start_time', 'trim') : trim($start_time);
		$end_time = empty($end_time) ? $this->_get('end_time', 'trim') : trim($end_time);
		$payment_method = empty($payment_method) ? $this->_get('payment_method', 'trim') : trim($payment_method);
		
		$province = empty($province) ? $this->_get('province', 'trim') : trim($province);
		$city = empty($city) ? $this->_get('city', 'trim') : trim($city);
		$county = empty($county) ? $this->_get('county', 'trim') : trim($county);
		
		$plat_form_margin_log_model = D('PlatformMarginLogView');

		if($store) {
			$where['Store.name'] = array('like', '%' . $store . '%');
		}
		if($province) {
			$where['sc.province'] = $province;
			$this->province = $province;
		}
		if($city) {
			unset($where['sc.province']);
			$where['sc.city'] = $city;
			$this->city = $city;
		}
		if($county) {
			unset($where['sc.city']);
			$where['sc.county'] = $county;
			$this->county = $county;
		}

		// 只查询充值记录
		$where['PlatformMarginLog.type'] = 0;

		if(!empty($status)) {
			if($status == 1) {
				$where['PlatformMarginLog.status'] = 0;
			}else if($status == 2) {
				$where['PlatformMarginLog.status'] = 2;
			}else if($status == 3) {
				$where['PlatformMarginLog.status'] = 3;
			}
		}

		if (!empty($payment_method)) {
			$where['PlatformMarginLog.payment_method'] = $payment_method;
		}

  		if($order_no) {
  			$where['PlatformMarginLog.order_no'] = $order_no;
  		}
		
		if ($start_time && $end_time) {

			$where['_string'] = "PlatformMarginLog.add_time >= '" . strtotime($start_time) . "' AND PlatformMarginLog.add_time <= '" . strtotime($end_time) . "'";
		
		} else if ($start_time) {
		
			$where['PlatformMarginLog.add_time'] = array('egt', strtotime($start_time));
		
		} else if ($end_time) {
		
			$where['PlatformMarginLog.add_time'] = array('elt', strtotime($end_time));
		
		}

		if ($this->admin_user['type'] != 2 && $this->admin_user['type'] != 3) {
        	$this->frame_error_tips("仅允许客户经理(代理商)和区域管理员访问");
        }

		// 区域管理员 只能查看自己区域的店铺
		if ($this->admin_user['type'] == 2) {
			$store_ids = D('Admin')->getAreaStoreIds($this->admin_user);
			if (!empty($store_ids)) {
				$where['PlatformMarginLog.store_id'] = array('in', $store_ids);
			} else {
				$where['PlatformMarginLog.store_id'] = false;
			}
		} else if ($this->admin_user['type'] == 3) {	// 代理商 只能查看自己关联用户的店铺
			$store_ids = D("Admin")->getAgentStoreIds($this->admin_user);
			if (!empty($store_ids)) {
				$where['PlatformMarginLog.store_id'] = array('in', $store_ids);
			} else {
				$where['PlatformMarginLog.store_id'] = false;
			}
		}

		$list_count = $plat_form_margin_log_model->where($where)->count();

		import('@.ORG.system_page');
		$page = new Page($list_count, 10);
		$list = $plat_form_margin_log_model->where($where)->order("PlatformMarginLog.pigcms_id DESC")->limit($page->firstRow . ',' . $page->listRows)->select();
		
		//区域管理员 代理商
		foreach($list as $k => $v) {
			
			$tmp_store_id = $v['store_id'];
			$store = D("Store")->field('uid')->where(array('store_id' => $tmp_store_id))->find();
			$user = D("User")->where(array('uid' => $store['uid']))->find();
			$database_admin = D("Admin");

	        // 代理商
	        if ($user['invite_admin'] != 0 && $agent_admin = $database_admin->where(array('id' => $user['invite_admin']))->find()) {
	       		$list[$k]['invite_admin'] =  $agent_admin['account'];
	        }

	        //区域管理
	        $store_area_record = D("Store_area_record")->where(array('store_id' => $tmp_store_id, 'status' => 1))->find();

	        $where_qy['_string'] = "(county = " . $store_area_record['county'] . " AND type = 2 AND area_level = 3) OR (city = " . $store_area_record['city'] . " AND type = 2 AND area_level = 2) OR (province = " . $store_area_record['province'] . " AND type = 2 AND area_level = 1)";
            $area_admin = $database_admin->where($where_qy)->order('area_level desc')->find();
            
            $list[$k]['area_admin'] =  $area_admin['account'];

		}

		$this->list = $list;

		$wheres = array();$wheres2 = array();$wheres3 = array();
		//当前搜索结果的充入，平台扣除统计
		
		$wheres = array(
			'PlatformMarginLog.amount' => array('GT',0),
			'PlatformMarginLog.status' => 2,
		);
		if($where) {
			$where_tmp = $where;
			unset($where_tmp['PlatformMarginLog.status']);
			//如状态为取消则修改类型
			if($status == 3){
				$where_tmp['PlatformMarginLog.type'] = 1;
			}
			$wheres = array_merge($wheres,$where_tmp);
		}
		$get_margin_count = $plat_form_margin_log_model->where($wheres)->field()->sum('amount');
		unset($wheres);
		$wheres2 = array(
			'PlatformMarginLog.amount' => array('LT',0),
			'PlatformMarginLog.status' => 2,
		);
		if($where) {
			$where_tmp = $where;
			unset($where_tmp['PlatformMarginLog.status']);
			//如状态为取消则修改类型
			if($status == 3){
				$where_tmp['PlatformMarginLog.type'] = 1;
			}
			$wheres2 = array_merge($wheres2,$where_tmp);
		}

		$out_margin_count = $plat_form_margin_log_model->where($wheres2)->field()->sum('amount');

		unset($wheres2);
		$wheres3 = array(
			'PlatformMarginLog.type' => 1,
			'PlatformMarginLog.status' => 2,
		);
		if($where) {
			$where_tmp = $where;
			unset($where_tmp['PlatformMarginLog.type']);
			unset($where_tmp['PlatformMarginLog.status']);
			$wheres3 = array_merge($wheres3,$where_tmp);
		}
		
		$return_margin_count = $plat_form_margin_log_model->where($wheres3)->field()->sum('amount');
		
		unset($wheres3);

		$this->payment_methods = D('Config')->get_pay_method();


		$this->return_margin_count = ($return_margin_count == 0) ? 0:abs($return_margin_count);
		$this->get_margin_count = ($get_margin_count == 0) ? 0:abs($get_margin_count);
		$this->out_margin_count = ($out_margin_count == 0) ? 0:abs($out_margin_count);

		$this->page = $page->show();
		$this->nowtype = $type;
		$this->selected_payment_method = $payment_method;
		$this->typelist = array('全部','充值','扣除','返还','退单');
		$this->display();

	}

	public function marginDetail(){

		$type = $this->_get('type','trim,intval');
		$order_id = $this->_get('order_id','trim,intval');
		$order_no = $this->_get('order_no','trim');
		$order_offline_id = $this->_get('order_offline_id','trim,intval');
		$status = $this->_get('status','trim,intval');
		$add_time = $this->_get('add_time','trim,intval');
		$amount = $this->_get('amount','trim');
		$bank_id = $this->_get('bank_id','intval');
		$bank_card = $this->_get('bank_card','trim');
		$bank = M('Bank')->where(array('bank_id' =>$bank_id ))->getField('name');

		if($order_id > 0){
			//$order_info = M('order')->where(array('order_id'=>$order_id))->find();
			$order_info =  D('OrderView')->where(array('StoreOrder.order_id' => $order_id))->find();
			$this->assign('order_amount',$order_info['total']);
			$this->assign('order_no',$order_info['order_no']);
			//$statusArr = array('临时订单','未支付','未发货','已发货','已完成','已取消','退款中');
			$order_status = D('OrderView')->status();
			$this->assign('order_status',$order_status);
			$this->assign('order',$order_info);
		}	

		if($order_offline_id > 0){
			$order_info = M('order_offline')->where(array('id'=>$order_offline_id))->find();
			$this->assign('order_amount',$order_info['total']);
			$this->assign('order_no',$order_info['order_no']);
			$order_status = array('未审核','审核通过','审核未通过');
			$this->assign('order_status',$order_status);
			$this->assign('order',$order_info);
		}

		$this->assign('order_id',$order_id);
		$this->assign('record_order_no',$order_no);
		$this->assign('status',$status);
		$this->assign('add_time',$add_time);
		$this->assign('type',$type);
		$this->assign('amount',$amount);
		$this->assign('bank',$bank);
		$this->assign('bank_card',$bank_card);
		$this->display();

	}


	public function _download_csv($list) {

			$filename = date("保证金流水_YmdHis",time()).'.xls';

			header ( 'Content-Type: application/vnd.ms-excel' );
			header ( "Content-Disposition: attachment;filename=$filename" );	
			header ( 'Cache-Type: charset=gb2312');

			$payment_methods = D('Config')->get_pay_method();

			echo "\xEF\xBB\xBF<style>table td{border:1px solid #ccc;}</style>";
			echo "<table>";

			echo '	<tr>';
			echo ' 		<th><b> 订单号 | 支付流水号 </b></th>';
			echo ' 		<th><b> 店铺名称 </b></th>';
			echo ' 		<th><b> 金额 </b></th>';
			echo ' 		<th><b> 客户经理(代理商) </b></th>';
			echo ' 		<th><b> 区域管理员 </b></th>';
			echo ' 		<th><b> 类型 </b></th>';
			echo ' 		<th><b> 时间 </b></th>';
			echo ' 		<th><b> 状态 </b></th>';

			echo '	</tr>';

			// 计数器 

			$cnt = 0;

			// 每隔$limit行，刷新一下输出buffer，节约资源 

			$limit = 50000;

			
			foreach ($list as $key => $value) {

				$cnt ++;

				if ($limit == $cnt) { //刷新一下输出buffer，防止由于数据过多造成问题 

					ob_flush();

					flush();

					usleep(100);

					$cnt = 0;

				}

				echo '	<tr>';
				echo ' 		<td align="left">'.$value['order_no'].'<br/><span style="color:gray;">' . $value['trade_no'] . '</span><br/>' . (!empty($payment_methods[$value['payment_method']]['name']) ? $payment_methods[$value['payment_method']]['name'] : '') . '</td>';
				echo ' 		<td align="center">'.$value['store'].'</td>';
				echo ' 		<td align="center">'.$value['amount'].'</td>';
				echo ' 		<td align="center">'.$value['invite_admin'].'</td>';
				echo ' 		<td align="center">'.$value['area_admin'].'</td>';
				echo ' 		<td align="center">'.$value['bak'].'</td>';
				echo ' 		<td align="center">'.date('Y-m-d H:i:s',$value['add_time']).'</td>';
		
                if($value['type'] == 0){
                    if($value['status'] == 2){
                        echo '<td align="center">已处理</td>';
                    }else if($value['status'] == 1){
                        echo '<td align="center">未处理</td>';
                    }else{
                        echo '<td align="center">未支付</td>';
                    }
                }else{
                    echo '<td></td>';
                }     
                       
				echo '	</tr>';
			}


			echo '</table>';

			exit;

	}


	public function record() {

	   //可用有效积分数
		$this->user_point_balance = M('user')->where(array('status'=>1))->sum('point_balance');
		
		$this->store_point_balance = M('store')->sum('point_balance');
	   
	   //用户积分池积分总额
		$this->user_point_pool_sum = M('user')->where(array('status'=>1))->sum('point_unbalance');

		$this->record_type = $this->_get('record_type','trim,intval',1);



	   switch ($this->record_type) {
		   case 1:
			   $this->_userCreditRecord(); //用户积分流水
			   break;
		   case 2:
			   $this->_storeCreditRecord(); //店铺积分流水
			   break;
		   case 3:
			   $this->_platformCreditRecord(); //平台积分流水
			   break;
		   
		   default:
			   $this->record_type = 1;
			   $this->_userCreditRecord();
			   break;
	   }

	  $this->credit_config = array(
		   
			1 => '用户积分流水',
		   
			2 => '店铺积分流水',
		   
			3 => '平台积分收入流水',
		
		);


	   $this->display();

	}

	//用户积分流水
	public function _userCreditRecord() {

		$searchcontent = $this->_request('searchcontent','trim,urldecode');

		if(!empty($searchcontent)) {
            parse_str($searchcontent,$data_arr);
            extract($data_arr);
        }

		$condition = array();


		$ktype = empty($ktype) ? $this->_get('ktype', 'trim') : trim($ktype);
        $keyword = empty($keyword) ? $this->_get('keyword', 'trim') : trim($keyword);
       
        $channel = !in_array($channel, array('1','2')) ? $this->_get('channel', 'trim') : trim($channel);


        $type = !in_array($type, array('1','2')) ? $this->_get('type', 'trim') : trim($type);

        $start_time = empty($start_time) ? $this->_get('start_time', 'trim') : trim($start_time);
		$end_time = empty($end_time) ? $this->_get('end_time', 'trim') : trim($end_time);

		//$ktype = $this->_get('ktype', 'trim');
	   
		//$keyword = $this->_get('keyword', 'trim');

		//$channel = $this->_get('channel','trim,intval',0);

		//$type = $this->_get('type','trim,intval',0);


		if (!empty($ktype) && !empty($keyword)) {
			if($ktype == 'order') {
				$condition['UserPointLog.order_no'] = $keyword;
			}else if($ktype == 'user') {
				$condition['User.nickname'] = array('like', '%' . $keyword . '%');
			}else if($ktype == 'uid') {
				$condition['User.uid'] = $keyword;
			}else if($ktype == 'phone') {
				$condition['User.phone'] = array('like', '%' . $keyword . '%');
			}
		}

		if(!empty($channel)) {
			if($channel == 1) {
				$condition['UserPointLog.channel'] = 0;
			}else if($channel == 2) {
				$condition['UserPointLog.channel'] = 1;
			}
		}


		if(!empty($type)) {
			if($type == 1) {
				$condition['UserPointLog.type'] = 1;
			}else if($type == 2) {
				$condition['UserPointLog.type'] = 0;
			}
		}

		// 区域管理员 只能查看自己区域的店铺
		if ($this->admin_user['type'] == 2) {
			$store_ids = D('Admin')->getAreaStoreIds($this->admin_user);
			if (!empty($store_ids)) {
				$condition['UserPointLog.store_id'] = array('in', $store_ids);
			} else {
				$condition['UserPointLog.store_id'] = false;
			}
		} else if ($this->admin_user['type'] == 3) {	// 代理商 只能查看自己关联用户的店铺
			$store_ids = D("Admin")->getAgentStoreIds($this->admin_user);
			if (!empty($store_ids)) {
				$condition['UserPointLog.store_id'] = array('in', $store_ids);
			} else {
				$condition['UserPointLog.store_id'] = false;
			}
		}

		if ($start_time && $end_time) {
			
			$condition['_string'] = "UserPointLog.add_time >= '" . strtotime($start_time) . "' AND UserPointLog.add_time <= '" . strtotime($end_time) . "'";
		
		} else if ($start_time) {
		
			$condition['UserPointLog.add_time'] = array('egt', strtotime($start_time));
		
		} else if ($end_time) {
		
			$condition['UserPointLog.add_time'] = array('elt', strtotime($end_time));
		
		}

		$user_point_log_model = D('UserPointLogView');

		$list_count = $user_point_log_model->where($condition)->count();

		$download = $this->_get('download','intval',0);

        if(!$download && !empty($searchcontent)){
            $return = array('code'=>'0','msg'=>$list_count);
            echo json_encode($return);exit;
        }


        if($download == 1) {
            
             $datalist = $user_point_log_model->where($condition)->order("UserPointLog.pigcms_id DESC")->select();
       
             import('Xls','./source/class');
             $filename = '用户积分流水记录';
             $fields = array('订单号','用户','积分','渠道','内容','时间');
             $data = array();  
             foreach ($datalist as $key => $value) {
             	
             	if($value['point'][0] != '-'){
             		$tmp_point = '+'.$value['point'];
             	}else{
             		$tmp_point = $value['point'];
             	}

             	if($value['channel'] == 1){
             		$tmp_channel = '线下';
             	}else{
             		$tmp_channel = '线上';
             	}

                $data[$key] =  array('`'.$value['order_no'].'`',$value['nickname'],$tmp_point,$tmp_channel,$value['bak'],date('Y-m-d H:i:s',$value['add_time']));
             }

             Xls::download_csv($filename,$fields,$data); 

        }


		import('@.ORG.system_page');

		$page = new Page($list_count, 10);

		$this->list = $user_point_log_model->where($condition)->order("UserPointLog.pigcms_id DESC")->limit($page->firstRow . ',' . $page->listRows)->select();

		$this->page = $page->show();

	}

	//店铺积分流水
	public function _storeCreditRecord() {

		// $condition = array();
	   
		// $ktype = $this->_get('ktype', 'trim');
	   
		// $keyword = $this->_get('keyword', 'trim');

		// $channel = $this->_get('channel','trim,intval',0);

		// $type = $this->_get('type','trim,intval',0);

		$searchcontent = $this->_request('searchcontent','trim,urldecode');

		if(!empty($searchcontent)) {
            parse_str($searchcontent,$data_arr);
            extract($data_arr);
        }

		$condition = array();


		$ktype = empty($ktype) ? $this->_get('ktype', 'trim') : trim($ktype);
        $keyword = empty($keyword) ? $this->_get('keyword', 'trim') : trim($keyword);
       
        $channel = !in_array($channel, array('1','2')) ? $this->_get('channel', 'trim') : trim($channel);


        $type = !in_array($type, array('1','2')) ? $this->_get('type', 'trim') : trim($type);

        $start_time = empty($start_time) ? $this->_get('start_time', 'trim') : trim($start_time);
		$end_time = empty($end_time) ? $this->_get('end_time', 'trim') : trim($end_time);



		if (!empty($ktype) && !empty($keyword)) {
			if($ktype == 'order') {
				$condition['StorePointLog.order_no'] = $keyword;
			}else if($ktype == 'store') {
				$condition['Store.name'] = array('like', '%' . $keyword . '%');
			}
		}

		if(!empty($channel)) {
			if($channel == 1) {
				$condition['StorePointLog.channel'] = 0;
			}else if($channel == 2) {
				$condition['StorePointLog.channel'] = 1;
			}
		}


		if(!empty($type)) {
			if($type == 1) {
				$condition['StorePointLog.type'] = 0;
			}else if($type == 2) {
				$condition['StorePointLog.type'] = 2;
			}
		}

		// 区域管理员 只能查看自己区域的店铺
		if ($this->admin_user['type'] == 2) {
			$store_ids = D('Admin')->getAreaStoreIds($this->admin_user);
			if (!empty($store_ids)) {
				$condition['StorePointLog.store_id'] = array('in', $store_ids);
			} else {
				$condition['StorePointLog.store_id'] = false;
			}
		} else if ($this->admin_user['type'] == 3) {	// 代理商 只能查看自己关联用户的店铺
			$store_ids = D("Admin")->getAgentStoreIds($this->admin_user);
			if (!empty($store_ids)) {
				$condition['StorePointLog.store_id'] = array('in', $store_ids);
			} else {
				$condition['StorePointLog.store_id'] = false;
			}
		}

		if ($start_time && $end_time) {
			
			$condition['_string'] = "StorePointLog.add_time >= '" . strtotime($start_time) . "' AND StorePointLog.add_time <= '" . strtotime($end_time) . "'";
		
		} else if ($start_time) {
		
			$condition['StorePointLog.add_time'] = array('egt', strtotime($start_time));
		
		} else if ($end_time) {
		
			$condition['StorePointLog.add_time'] = array('elt', strtotime($end_time));
		
		}

		$store_point_log_model = D('StorePointLogView');

		$list_count = $store_point_log_model->where($condition)->count();


		$download = $this->_get('download','intval',0);

        if(!$download && !empty($searchcontent)){
            $return = array('code'=>'0','msg'=>$list_count);
            echo json_encode($return);exit;
        }


        if($download == 1) {
            
             $datalist = $store_point_log_model->where($condition)->order("StorePointLog.pigcms_id DESC")->select();

             import('Xls','./source/class');
             $filename = '店铺积分流水记录';
            
             $fields = array('订单号','店铺','积分','渠道','内容','时间');
             
             $data = array();  
             foreach ($datalist as $key => $value) {
             	
             	if($value['point'][0] != '-'){
             		$tmp_point = '+'.$value['point'];
             	}else{
             		$tmp_point = $value['point'];
             	}

             	if($value['channel'] == 1){
             		$tmp_channel = '线下';
             	}else{
             		$tmp_channel = '线上';
             	}

                $data[$key] =  array('`'.$value['order_no'].'`',$value['store'],$tmp_point,$tmp_channel,$value['bak'],date('Y-m-d H:i:s',$value['add_time']));
             }

             Xls::download_csv($filename,$fields,$data); 

        }
		
		import('@.ORG.system_page');

		$page = new Page($list_count, 10);

		$this->list = $store_point_log_model->where($condition)->order("StorePointLog.pigcms_id DESC")->limit($page->firstRow . ',' . $page->listRows)->select();


		$this->page = $page->show();
		
	}

	//平台收入积分流水
	public function _platformCreditRecord() {

		// $condition = array();
	   
		// $ktype = $this->_get('ktype', 'trim');
	   
		// $keyword = $this->_get('keyword', 'trim');

		// $channel = $this->_get('channel','trim,intval',0);

		// $type = $this->_get('type','trim,intval',0);


		$searchcontent = $this->_request('searchcontent','trim,urldecode');

		if(!empty($searchcontent)) {
            parse_str($searchcontent,$data_arr);
            extract($data_arr);
        }

		$condition = array();


		$ktype = empty($ktype) ? $this->_get('ktype', 'trim') : trim($ktype);
        $keyword = empty($keyword) ? $this->_get('keyword', 'trim') : trim($keyword);
       
        $channel = !in_array($channel, array('1','2')) ? $this->_get('channel', 'trim') : trim($channel);


        $type = !in_array($type, array('1','2')) ? $this->_get('type', 'trim') : trim($type);

        $start_time = empty($start_time) ? $this->_get('start_time', 'trim') : trim($start_time);
		$end_time = empty($end_time) ? $this->_get('end_time', 'trim') : trim($end_time);



		if (!empty($ktype) && !empty($keyword)) {
			if($ktype == 'order') {
				$condition['PlatformPointLog.order_no'] = $keyword;
			}else if($ktype == 'store') {
				$condition['Store.name'] = array('like', '%' . $keyword . '%');
			}
		}

		if(!empty($channel)) {
			if($channel == 1) {
				$condition['PlatformPointLog.channel'] = 0;
			}else if($channel == 2) {
				$condition['PlatformPointLog.channel'] = 1;
			}
		}


		if(!empty($type)) {
			if($type == 1) {
				$condition['PlatformPointLog.type'] = 1;
			}else if($type == 2) {
				$condition['PlatformPointLog.type'] = 0;
			}
		}

		// 区域管理员 只能查看自己区域的店铺
		if ($this->admin_user['type'] == 2) {
			$store_ids = D('Admin')->getAreaStoreIds($this->admin_user);
			if (!empty($store_ids)) {
				$condition['PlatformPointLog.store_id'] = array('in', $store_ids);
			} else {
				$condition['PlatformPointLog.store_id'] = false;
			}
		} else if ($this->admin_user['type'] == 3) {	// 代理商 只能查看自己关联用户的店铺
			$store_ids = D("Admin")->getAgentStoreIds($this->admin_user);
			if (!empty($store_ids)) {
				$condition['PlatformPointLog.store_id'] = array('in', $store_ids);
			} else {
				$condition['PlatformPointLog.store_id'] = false;
			}
		}

		if ($start_time && $end_time) {
			
			$condition['_string'] = "PlatformPointLog.add_time >= '" . strtotime($start_time) . "' AND PlatformPointLog.add_time <= '" . strtotime($end_time) . "'";
		
		} else if ($start_time) {
		
			$condition['PlatformPointLog.add_time'] = array('egt', strtotime($start_time));
		
		} else if ($end_time) {
		
			$condition['PlatformPointLog.add_time'] = array('elt', strtotime($end_time));
		
		}

		$platform_point_log_model = D('PlatformPointLogView');

		$list_count = $platform_point_log_model->where($condition)->count();


		$download = $this->_get('download','intval',0);

        if(!$download && !empty($searchcontent)){
            $return = array('code'=>'0','msg'=>$list_count);
            echo json_encode($return);exit;
        }


        if($download == 1) {
            
            $datalist = $platform_point_log_model->where($condition)->order("PlatformPointLog.pigcms_id DESC")->select();

             import('Xls','./source/class');
             $filename = '平台积分收入流水';
            
             $fields = array('订单号','店铺','积分','渠道','内容','时间');
             
             $data = array();  
             foreach ($datalist as $key => $value) {
             	
             	if($value['point'][0] != '-'){
             		$tmp_point = '+'.$value['point'];
             	}else{
             		$tmp_point = $value['point'];
             	}

             	if($value['channel'] == 1){
             		$tmp_channel = '线下';
             	}else{
             		$tmp_channel = '线上';
             	}

                $data[$key] =  array('`'.$value['order_no'].'`',$value['store'],$tmp_point,$tmp_channel,$value['bak'],date('Y-m-d H:i:s',$value['add_time']));
             }

             Xls::download_csv($filename,$fields,$data); 

        }


		
		import('@.ORG.system_page');

		$page = new Page($list_count, 10);

		$this->list = $platform_point_log_model->where($condition)->order("PlatformPointLog.pigcms_id DESC")->limit($page->firstRow . ',' . $page->listRows)->select();

		$this->page = $page->show();
		
	}

	//积分统计汇总
	public function statistics(){

		//1.累计从消费积分释放的【可用积分】总数（=B*W）
		$this->release_point = M('release_point_log')->sum('point');

		//B.累计已释放消费积分总数=(1+2)
		$this->release_send_point = M('release_point_log')->sum('send_point');

		//2.累计已释放消费积分耗损总数(=B-1)：
		$this->release_point_lose = $this->release_send_point - $this->release_point;
		
		//3.累计商家积分转【可用积分】总数
		$this->store_to_point_balance_total = M('store')->sum('point2user');
		//$this->store_to_point_balance_total = M('user_point_log')->where(array('type'=>4))->sum('point');

		//4.累计【可用积分】总数（=1+3)
		
		//5.累计消耗可用积分（=6+7）
		
		//6.累计商家用于【补单】的可用积分总数 
		//$offline_user_point_balance_total + $offline_store_point_balance_total_new
		//用户
		/*
		$condition_5['channel'] = 1;
		// $condition_5['type'] = 1;
		// $condition_5['status'] = 0;
		$condition_5['type'] = array('in', array(1,2));
		$condition_5['status'] = 1;
		$condition_5['order_offline_id'] = array('gt',0);
		$offline_user_point_balance_total = M('user_point_log')->where($condition_5)->sum('point');
		$this->offline_user_point_balance_total = abs($offline_user_point_balance_total);
		*/

		/*$condition_5['u.channel'] = 1;
		// $condition_5['type'] = 1;
		// $condition_5['status'] = 0;
		$condition_5['u.type'] = array('in', array(1,2));
		$condition_5['u.status'] = 1;
		$condition_5['o.status'] = 1;
		$condition_5['o.check_status'] = 1;
		$condition_5['u.order_offline_id'] = array('gt',0);
		
		$prefix = C('DB_PREFIX');
		$offline_user_point_balance_total = D('user_point_log')->alias('u')->join($prefix.'order_offline as o ON u.order_offline_id = o.id ')->where($condition_5)->sum('u.point');
		
		$this->offline_user_point_balance_total = abs($offline_user_point_balance_total);*/
		//#select sum(`store_user_point`) from pigcms_order_offline where check_status in(0,1);
		$condition_5['check_status'] = array('in', array(0,1));
		$this->offline_user_point_balance_total = M('order_offline')->where($condition_5)->sum('store_user_point');
		

		//店铺 abs type:1 channel 1 order_offline_id > 0
		
		//商家做单产生积分
		/*$condition_5p['type'] = 0; 
		$condition_5p['channel'] = 1; 
		$condition_5p['status'] = 2;
		$condition_5p['order_offline_id'] = array('gt',0);
		
		$offline_store_point_balance_total_new = M('store_point_log')->where($condition_5p)->sum('point');
		
		$this->offline_store_point_balance_total_new = abs($offline_store_point_balance_total_new);
		*/

		$this->offline_store_point_balance_total_new = M('order_offline')->where($condition_5)->sum('store_point');

		//7.累计（兑换商品）转为【商家积分】的可用积分总数：
		//$condition_6['channel'] = array('in', array(0,1));
		//$condition_6['channel'] = 0;

		/*
		$condition_6['u.type'] = array('in', array(1,2,3));
		$condition_6['u.status'] = 1;
		$condition_6['u.order_offline_id'] = 0;
		//$condition_6['o.status'] = 4;
		$condition_6['o.status'] = array('not in', array(0,5));
		$prefix = C('DB_PREFIX');
		$order_user_point_balance_total = D('user_point_log')->alias('u')->join($prefix.'order as o ON u.order_id = o.order_id ')->where($condition_6)->sum('u.point');
		
		$this->order_user_point_balance_total = abs($order_user_point_balance_total);

		*/
		
		$condition_6['status'] = array('not in', array(0,5));
		$this->order_user_point_balance_total = M('order')->where($condition_6)->sum('cash_point');
		
		
		//8.累计可用积分总余额（=4-5)（=4-6-7）：
		$this->user_point_balance_total = M('user')->where(array('status'=>1))->sum('point_balance');
		

		//9.累计可用积分兑换商品转为商家积分火耗A（积分状态转换服务费)=7*10%
		//$this->store_margin_used = M('store')->sum('margin_used');
		//$this->store_margin_used = M('platform_point_log')->where(array('type'=>0,'status'=>1))->sum('point');
		$tmp_store_margin_used = M('order')->where(array('status'=>4))->sum('cash_point');

		$tmp_store_margin_used = ($tmp_store_margin_used * 10) / 100;

		$this->store_margin_used =number_format($tmp_store_margin_used, 2, '.', '');


		//10.累计商家积分总数=累计可用积分已兑换为【商家积分】的总数（=7-9）
		//$this->store_point_total = M('store')->sum('point_total');
		$tmp_store_point_total = M('order')->where(array('status'=>4))->sum('cash_point');
		$this->store_point_total = $tmp_store_point_total - $this->store_margin_used;
		//11.累计商家积分总余额（=10-12）
		$this->store_point_balance_total = M('store')->sum('point_balance');

		//12.累计消耗的商家积分（=13+14+15）：

		//13.累计用于补单的商家积分 //offline_store_point_balance_total_new

		//14.累计转可用积分的商家积分：
		$condition_15['type'] = 5;
		$store_to_user_balance_points = M('store_point_log')->where($condition_15)->sum('point');
		$this->store_to_user_balance_points = abs($store_to_user_balance_points);

		//15.累计转可兑现现金的商家积分：
		$condition_16['type'] = 2;
		$store_point2money = M('store_point_log')->where($condition_16)->sum('point');
		$this->store_point2money = abs($store_point2money);

		//16.累计转兑现现金火耗B(兑现服务费)=15*6%
		$this->store_withdrawal_lose = M('store')->where(array('status'=>1))->sum('point2money_service_fee');

		//17.累计已转可兑现现金总额（=15-16）：
		//$this->store_point2money_total = M('store')->sum('point2money_total + point2money_service_fee');
		$this->store_point2money_total = M('store')->sum('point2money_total');
		

		//18.累计商家可兑现现金账总余额(=17-19)
		$this->store_point2money_balance = M('store')->where(array('status'=>1))->sum('point2money_total - point2money_withdrawal');

		//19.累计已兑现现金总额
		$this->store_withdrawal = M('store')->where(array('status'=>1))->sum('point2money_withdrawal');
		//$this->store_withdrawal = M('store_withdrawal')->where(array('type'=>3,'channel'=>1,'status'=>3))->sum('amount');
		
		
		//B.累计已释放消费积分总数=(1+2)  $this->release_send_point
		//C."待释放消费积分余额(=A-B)或（A-B-EA)"
		$this->wait_release_point = M('user')->where(array('status'=>1))->sum('point_unbalance');
		
		//A.累计赠送消费积分总数（=B+C)(=1+2+C)
		//$this->user_point_total = M('user')->where(array('status'=>1))->sum('point_total');
		$this->user_point_total = $this->release_send_point + $this->wait_release_point;
		//D.前一日发送积分总数(不包含积分做单部分)*10%
		$this->yes_release_send_point = M('release_point_log')->where(array('add_date'=>date('Ymd',strtotime('-1 day'))))->sum('send_point');
		//今日应释放消费积分总数
		
		$credit_weight = M('credit_setting')->getField('credit_weight');

		$credit_weight = (!empty($credit_weight)) ? $credit_weight : 500; 

		$evaluate_today_release_send_point = M('user_point_log')->where('type in(0, 5, 6, 7) and point_send_base > '.$credit_weight.' and add_date <'.date('Ymd'))->order('add_date desc')->group('add_date')->sum('point_send_base');
		
		

		$this->evaluate_today_release_send_point = floor($evaluate_today_release_send_point / $credit_weight);
		//今日已释放消费积分总数
		$this->today_release_send_point = M('release_point_log')->where(array('add_date'=>date('Ymd')))->sum('send_point');
		//F.累计赠送积分总数(不包含积分做单赠送的消费积分部分) = A
		//累计赠送积分总数(不包含积分做单赠送的消费积分部分)*10%      (====备付金总额)
		//G.累计积分服务费收入 "=累计发放消费积分（不包含积分做单赠送消费积分部分)*16%"  ===累计服务费总额
		//SELECT SUM(service_fee) AS tp_sum FROM pigcms_order_offline  WHERE  status = 1 and check_status = 1  LIMIT 1
		//$this->platform_service_charge = M('day_platform_service_fee')->sum('amount');
		$this->platform_service_charge = M('order_offline')->where(array('check_status'=>1,'status'=>1))->sum('cash');

		//H.累计商家充值现金总额
		$this->margin_total = M('platform_margin_log')->where(array('type'=>0,'status'=>2))->sum('amount');

		//前一日申请充值返还的金额

		$condition_k['type'] = 1;
		
		$condition_k['_string'] = "add_time >= '" . (strtotime(date('Y-m-d'))-86400) . "' AND add_time <= '" . strtotime(date('Y-m-d')) . "'";

		$this->yes_margin_back = M('platform_margin_log')->where($condition_k)->sum('amount');
		//累计充值返还已提现总额
		$condition_l['type'] = 1;
		$condition_l['status'] = 2;
		$margin_back = M('platform_margin_log')->where($condition_l)->sum('amount');
		$this->margin_back = abs($margin_back);
		
		//K.商家充值现金总余额(=H-G)  =============={pigcms{$common_data[1]['value']|default="0"}

		$this->margin_balance_now = $this->margin_total - $this->margin_back - $this->platform_service_charge;
		//$this->margin_balance_now += $this->offline_user_point_balance_total + $this->offline_store_point_balance_total_new;


		////L. 累计保证金扣除(线上发放消费积分的服务费)
		$condition_n['type'] = 2;
		$condition_n['order_id'] = array('gt',0);
		$condition_n['order_offline_id'] = 0;
		$condition_n['status'] = 2;
		$store_online_cash_provision = M('platform_margin_log')->where($condition_n)->sum('amount');
		$this->store_online_cash_provision = abs($store_online_cash_provision);

		//M.累计店铺线下做单扣除的服务费(线下做单的服务费但不包含积分做单服务费)
		$condition_o['platform_margin_log.type'] = 2;
		$condition_o['platform_margin_log.order_id'] = 0;
		$condition_o['platform_margin_log.status'] = 2;
		$condition_o['platform_margin_log.order_offline_id'] = array('gt',0);
		$condition_o['oo.check_status'] = 1;
		$prefix = C('DB_PREFIX');
		$store_offline_cash_provision = D('platform_margin_log')->alias('platform_margin_log')->join($prefix.'order_offline as oo ON platform_margin_log.order_offline_id = oo.id ')->where($condition_o)->sum('oo.cash');
		$this->store_offline_cash_provision = abs($store_offline_cash_provision);
		//累计服务费(=L+M)（=G)(=O+S) $this->platform_service_charge
		//O.累计存管金(10%)(=N-S)  $this->cash_provision_total
		$this->cash_provision_total = M('cash_provision_log')->where(array('type'=>0))->sum('amount');
		//P.存管金余额（=O-Q)
		

		//$this->cash_provision_balance_now = M('common_data')->where(array('key'=>'cash_provision_balance'))->getField('value');
		$this->cash_provision_balance_now = $this->cash_provision_total - $this->store_withdrawal;

		//待处理金额

		$this->store_withdrawal_handle = M('store_withdrawal')->where(array('type'=>3,'channel'=>1,'status'=>array('in',array(1,2))))->sum('amount');


		//累计已兑现金额 $this->store_withdrawal
		//前日申请兑现金额
		$condition_t['type'] = 3;
		$condition_t['channel'] = 1;
		$condition_t['status'] = 3;
		$condition_t['_string'] = "add_time >= '" . (strtotime(date('Y-m-d'))-86400) . "' AND add_time <= '" . strtotime(date('Y-m-d')) . "'";
		$this->yes_apply_store_withdrawal = M('store_withdrawal')->where(array($condition_t))->sum('amount');
		//累计平台运营费(6%)
		$cash_provisions = M('credit_setting')->getField('cash_provisions');
		$temp_percent = (100 - $cash_provisions) * 0.01;
		$this->platform_operating_cost = $this->platform_service_charge * $temp_percent;
		//累计区域总奖金（1.7%）
		$this->_reward_total = M('admin')->sum('reward_total');
		//累计区域经理总奖金（1.2%）
		$this->area_reward_total = M('admin')->where(array('type'=>2))->sum('reward_total');
		//累计客户经理总奖金（05%）
		$this->agent_reward_total = M('admin')->where(array('type'=>3))->sum('reward_total');
		
		//准商家积分=7*0.9+12
		//准货款=X*0.94=【（7*0.9+12）*0.94】
		//准存管金余额=P-18-Y
		//消费积分含金量=Z/C

		//昨日备付金总额（单日）
		$this->cash_provision_balance_yestoday = M('cash_provision_log')->where(array('add_date'=>date('Ymd',strtotime('-1 day')),'type'=>'0'))->sum('amount');

		//权数=D/E

		$point_weight_arr = $this->getRealCreditWeight($credit_weight,$this->cash_provision_balance_yestoday);

		$this->real_point_weight = $point_weight_arr['point_weight'];

		//今日需发放积分点数最大值
		$this->today_send_point_max = $point_weight_arr['day_send_all_points'];

		$this->display();
	}

	//保证返还
	public function returnRecord()
	{
		$platform_margin_log_model = D('PlatformMarginLogView');
		import('@.ORG.system_page');
		$where = array();

		$searchcontent = $this->_request('searchcontent','trim,urldecode');

		if(!empty($searchcontent)) {
            parse_str($searchcontent,$data_arr);
            extract($data_arr);
        }

        $type = empty($type) ? $this->_get('type', 'trim') : trim($type);
        $keyword = empty($keyword) ? $this->_get('keyword', 'trim') : trim($keyword);
        $bank = empty($bank) ? $this->_get('bank', 'trim') : trim($bank);
 
        $status = !in_array($status, array('0','1','2','3')) ? $this->_get('status', 'trim') : trim($status);

        $start_time = empty($start_time) ? $this->_get('start_time', 'trim') : trim($start_time);
		$end_time = empty($end_time) ? $this->_get('end_time', 'trim') : trim($end_time);




		if (!isset($status) && $this->unprocessed > 0) {
			$where['PlatformMarginLog.status'] = 1;
		} else if ($status > 0) {
			$where['PlatformMarginLog.status'] = $status;
		}
		if (!empty($keyword)) {
			if ($type == 'order_no') {
				$where['PlatformMarginLog.order_no'] = array('like', '%' . trim($keyword) . '%');
			} else if ($type == 'bank_account') {
				$where['Store.bank_card'] = array('like', '%' . trim($keyword) . '%');
			} else if ($type == 'user') {
				$where['User.nickname'] = array('like', '%' . trim($keyword) . '%');
			} else if ($type == 'tel') {
				$where['Store.tel'] = array('like', '%' . trim($keyword) . '%');
			}
		}
		if (!empty($start_time) && !empty($end_time)) {
			$start_time = strtotime($start_time);
			$end_time = strtotime($end_time);
			$where['_string'] = "PlatformMarginLog.add_time >= " . $start_time . " AND PlatformMarginLog.add_time <= " . $end_time;
		} else if (!empty($start_time)) {
			$start_time = strtotime($start_time);
			$where['PlatformMarginLog.add_time'] = array('egt', $start_time);
		} else if (!empty($end_time)) {
			$end_time = strtotime($end_time);
			$where['PlatformMarginLog.add_time'] = array('elt', $end_time);
		}
		if (!empty($bank)) {
			$where['Store.bank_id'] =  $bank;
		}
		$where['PlatformMarginLog.type'] = 1;
		$platform_margin_log_count = $platform_margin_log_model->where($where)->count('pigcms_id');
		

		$download = $this->_get('download','intval',0);

        if(!$download && !empty($searchcontent)){
            $return = array('code'=>'0','msg'=>$platform_margin_log_count);
            echo json_encode($return);exit;
        }


        if($download == 1) {
         	 $platform_margin_logs = $platform_margin_log_model->where($where)->order('PlatformMarginLog.pigcms_id DESC')->select();
             import('Xls','./source/class');
             $filename = '提现记录';
             $fields = array('编号','单号','申请时间','银行账户','店铺名称','返还金额(元)','可用余额(元)','申请人','联系方式','状态','备注');
             $data = array();  
             foreach ($platform_margin_logs as $key => $value) {
                
                $bank = M('Bank')->field('name')->where(array('bank_id' => $value['bank_id']))->find();
				$tmp_bank = $bank['name'];
				$tmp_amount = number_format(abs($value['amount']), 2, '.', '');

                if($value['status'] == 1){
                	$tmp_status = '待处理';
                }elseif ($value['status'] == 2) {
                	$tmp_status = '已处理';
                }elseif ($value['status'] == 3) {
                	$tmp_status = '已取消';
                }  
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
  
                $data[$key] = array($value['pigcms_id'],'`'.$value['order_no'].'`',date('Y-m-d H:i:s',$value['add_time']),$tmp_str,$value['store'],$tmp_amount,$value['margin_balance'],$value['nickname'],$value['tel'],$tmp_status,$value['bak']);
             }

             Xls::download_csv($filename,$fields,$data); 

        }


		$page = new Page($platform_margin_log_count, 15);
		$platform_margin_logs = $platform_margin_log_model->where($where)->order('PlatformMarginLog.pigcms_id DESC')->limit($page->firstRow . ',' . $page->listRows)->select();

		if (!empty($platform_margin_logs)) {
			foreach ($platform_margin_logs as &$platform_margin_log) {
				$bank = M('Bank')->field('name')->where(array('bank_id' => $platform_margin_log['bank_id']))->find();
				$platform_margin_log['bank'] = $bank['name'];
				$platform_margin_log['amount'] = number_format(abs($platform_margin_log['amount']), 2, '.', '');
			}
		}

		//银行
		$banks = M('Bank')->where(array('status' => 1))->select();
		//状态
		$status = $platform_margin_log_model->getStatus();

		$this->assign('platform_margin_logs', $platform_margin_logs);
		$this->assign('page', $page->show());
		$this->assign('banks', $banks);
		$this->assign('status', $status);
		$this->display();
	}

	//返还处理状态
	public function chgReturnStatus()
	{
		$id = $this->_post('id', 'trim,intval');
		$status = $this->_post('status', 'trim,intval');
		if (!in_array($status, array(2,3))) {
			echo json_encode(array('error' => 0, 'message' => '状态修改失败'));
			exit;
		}
		$where = array();
		$where['pigcms_id'] = $id;
		$log = D('PlatformMarginLog')->where(array('pigcms_id' => $id))->find();
		if (empty($log)) {
			echo json_encode(array('error' => 0, 'message' => '状态修改失败'));
			exit;
		}
		if (M('PlatformMarginLog')->where($where)->data(array('status' => $status))->save()) {
			if ($status == 2) { //已处理
				M('Store')->where(array('store_id' => $log['store_id']))->setInc('margin_withdrawal', abs($log['amount']));
				D('CommonData')->setData(array('key' => 'margin_withdrawal'), abs($log['amount']));
			} else if ($status == 3) { //已取消
				M('Store')->where(array('store_id' => $log['store_id']))->setInc('margin_balance', abs($log['amount']));
			}
			echo json_encode(array('error' => 1, 'message' => '状态修改成功'));
		} else {
			echo json_encode(array('error' => 0, 'message' => '状态修改失败'));
		}
		exit;
	}

}