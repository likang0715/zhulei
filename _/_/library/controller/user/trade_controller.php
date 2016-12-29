<?php

/*
 * 物流相关
 */

class trade_controller extends base_controller{

    public function __construct() {
        parent::__construct();
        if (empty($this->store_session))
            redirect(url('index:index'));
        $this->checkRbac();
    }

    // 检查门店管理员登录下权限
    private function checkRbac () {

        $controller = MODULE_NAME;
        $action = ACTION_NAME;
        $rbacActionModel = M('Rbac_action');
        // $uid = $this->user_session['uid'];
        if ($this->user_session['type'] == 1) {     //门店管理员登录

	        $uid = $this->user_session['physical_uid'];
            // 禁止使用方法配置到该数组
            $rbacBanMethod = array();
            if (!empty($rbacBanMethod) && in_array($action, $rbacBanMethod)) { 
                $this->rbacError();
            }

            $rbacArray = option('physical.rbac');
            $checkRbacMethod = (isset($rbacArray[$controller]) && !empty($rbacArray[$controller])) ? array_flip($rbacArray[$controller]) : array();
            $method = $rbacActionModel->getMethod($uid, $controller, $action);

            if (in_array($action, $checkRbacMethod) && !$method) {
                $this->rbacError();
            }

        }
    }

    protected function addQuote($string){
        return '\''.$string.'\'';
    }

    // 门店管理rbac权限报错
    private function rbacError () {
        header("Content-type: text/html;charset=utf-8");
        if (IS_AJAX) {
            if (IS_GET) {
                json_return(0, '您没有操作权限');
            } elseif (IS_POST) {
                json_return(0, '您没有操作权限');
            }
        } else if (IS_POST) {
            pigcms_tips('您没有操作权限！', 'none');
        } else {
            pigcms_tips('您没有操作权限！', 'none');
        }
        exit;
    }

	public function index(){
		$this->display();
	}
	public function _empty(){
		include display();
	}
	public function delivery(){
		$this->display();
	}
	public function delivery_load(){
		if(empty($_POST['page'])) pigcms_tips('非法访问！','none');
		if($_POST['page'] == 'delivery_list'){
			$postage = M('Postage_template')->get_tpl_list($this->store_session['store_id']);
			$this->assign('postage_list',$postage);
		}else if($_POST['page'] == 'delivery_edit'){
			$tpl_id = !empty($_POST['tpl_id']) ? $_POST['tpl_id'] : pigcms_tips('请携带运费模板ID');
			$postage = M('Postage_template')->get_tpl($tpl_id,$this->store_session['store_id']);
			if(empty($postage)) pigcms_tips('该运费模板不存在');
			$this->assign('postage',$postage);
		}else if($_POST['page'] == 'setting_content'){
			$setting = M('Trade_setting')->get_setting($this->store_session['store_id']);
			$this->assign('setting',$setting);
		}else if($_POST['page'] == 'selffetch_content'){
			//$selffetch = M('Trade_selffetch')->get_list($this->store_session['store_id']);
			//$this->assign('selffetch',$selffetch);
			$store_physical = D('Store_physical')->where(array('store_id'=>$this->store_session['store_id']))->select();
			$this->assign('store_physical',$store_physical);
			//买家上门自提状态
			$store = M('Store')->getStore($this->store_session['store_id']);
			$selfFetchStatus = $store['buyer_selffetch'];
			$this->assign('selfFetchStatus', $selfFetchStatus);
			$this->assign('store', $store);
		} else if ($_POST['page'] == 'pay_agent_content') {

			//找人代付
			$store = M('Store');
			$payAgentStatus = $store->getPayAgentStatus($this->store_session['store_id']);
			$this->assign('payAgentStatus', $payAgentStatus);
		} else if ($_POST['page'] == 'income_content') { //我的收入
			$this->_income_content();
		} else if ($_POST['page'] == 'waitsettled_content') { //待结算
			$this->_waitsettled_content();
		} else if ($_POST['page'] == 'inoutdetail_content') { //收支明细
			$this->_inoutdetail_content();
		} else if ($_POST['page'] == 'withdraw_content') { //提现记录
			$this->_withdraw_content();
		} else if ($_POST['page'] == 'settingwithdrawal_content') { //设置提现账号
			$this->_settingwithdrawal_content();
		} else if ($_POST['page'] == 'editwithdrawal_content') {
			$this->_editwithdrawal_content();
		} else if ($_POST['page'] == 'applywithdrawal_content') { //申请提现
			$this->_applywithdrawal_content();
		} else if ($_POST['page'] == 'dividends_withdrawal_content') { //申请分红
			$this->_dividends_withdrawal_content();
		} else if ($_POST['page'] == 'trade_content') { //交易记录
			$this->_trade_content();
		} else if ($_POST['page'] == 'wholesale_content') { //批发盈利
			$this->_wholesale_content();
		} else if ($_POST['page'] == 'drp_content') {
			$this->_drp_content();
		} else if ($_POST['page'] == 'seller_withdraw_content') {
            $this->_seller_withdraw_content();
        } else if ($_POST['page'] == 'dealer_withdraw_content') {
			$this->_dealer_withdraw_content();
		} else if ($_POST['page'] == 'platform_margin_content') {
			$this->_platform_margin_content();
		} else if ($_POST['page'] == 'margin_recharge_content') {
			$this->_margin_recharge_content();
		} else if ($_POST['page'] == 'margin_details_content') {
			$this->_margin_details_content();
		} else if ($_POST['page'] == 'point_details_content') {
			$this->_point_details_content();
		} else if ($_POST['page'] == 'point_exchange_content') {
			$this->_point_exchange_content();
		} else if ($_POST['page'] == 'dividends_mx_content') {
			$this->_dividends_mx_content();
		} else if ($_POST['page'] == 'my_dividends_content') {
			$this->_my_dividends_content();
		} else if ($_POST['page'] == 'margin_return_content') {
			$this->_margin_return_content();
		}

		$this->display($_POST['page']);
	}
	public function delivery_modify(){
		if(IS_POST){
			$data_postage_template['store_id'] = $this->store_session['store_id'];
			$data_postage_template['tpl_name'] = !empty($_POST['name']) ? $_POST['name'] : json_return(4091,'模板名称不能为空');
			$area = !empty($_POST['area']) ? $_POST['area'] : json_return(4092,'至少要有一个配送区域');
			$area_arr = explode(';',$area);
			foreach($area_arr as $key=>$value){
				if($value != ''){
					$area_content_arr = explode(',',$value);
					$province = rtrim($area_content_arr[0],'&');
					$new_area_arr[] = $province.','.$area_content_arr[1].','.$area_content_arr[2].','.$area_content_arr[3].','.$area_content_arr[4];
				}
			}
			$data_postage_template['tpl_area'] = !empty($new_area_arr) ? implode(';',$new_area_arr) : json_return(4093,'配送区域解析失败');
			$data_postage_template['last_time'] = $_SERVER['REQUEST_TIME'];
			$database_postage_template = D('Postage_template');
			if($database_postage_template->data($data_postage_template)->add()){
				json_return(0,'添加成功');
			}else{
				json_return(4094,'添加失败！请重试。');
			}
		}else{
			json_return(999,'非法访问！');
		}
	}
	public function delivery_copy(){
		if(IS_POST){
			$condition_postage_template['tpl_id'] = $_POST['tpl_id'];
			$condition_postage_template['store_id'] = $this->store_session['store_id'];
			$database_postage_template = D('Postage_template');
			$postage_template = $database_postage_template->where($condition_postage_template)->find();
			if(!empty($postage_template)){
				$postage_template['copy_id'] = $postage_template['tpl_id'];
				$postage_template['last_time'] = $_SERVER['REQUEST_TIME'];
				unset($postage_template['tpl_id']);
				if($database_postage_template->data($postage_template)->add()){
					json_return(0,'复制成功');
				}else{
					json_return(4097,'复制失败，请重试');
				}
			}else{
				json_return(4096,'该运费模板不存在');
			}
		}else{
			json_return(999,'非法访问！');
		}
	}
	public function delivery_amend(){
		if(IS_POST){
			$condition_postage_template['tpl_id'] = $_POST['tpl_id'];
			$condition_postage_template['store_id'] = $this->store_session['store_id'];
			$data_postage_template['tpl_name'] = !empty($_POST['name']) ? $_POST['name'] : json_return(4091,'模板名称不能为空');
			$area = !empty($_POST['area']) ? $_POST['area'] : json_return(4092,'至少要有一个配送区域');
			$area_arr = explode(';',$area);
			foreach($area_arr as $key=>$value){
				if($value != ''){
					$area_content_arr = explode(',',$value);
					$province = rtrim($area_content_arr[0],'&');
					if(!empty($area_content_arr[2]) && $area_content_arr[2] != '0.00' && empty($area_content_arr[1])){
						json_return(4095,'您设置了首重运费，首重数不能填 0');
					}
					if(!empty($area_content_arr[4]) && $area_content_arr[2] != '0.00' && empty($area_content_arr[3])){
						json_return(4095,'您设置了续重运费，续重数不能填 0');
					}
					$new_area_arr[] = $province.','.$area_content_arr[1].','.$area_content_arr[2].','.$area_content_arr[3].','.$area_content_arr[4];
				}
			}
			$data_postage_template['tpl_area'] = !empty($new_area_arr) ? implode(';',$new_area_arr) : json_return(4093,'配送区域解析失败');
			$data_postage_template['last_time'] = $_SERVER['REQUEST_TIME'];
			$data_postage_template['copy_id'] = '0';
			$database_postage_template = D('Postage_template');
			if($database_postage_template->where($condition_postage_template)->data($data_postage_template)->save()){
				json_return(0,'修改成功');
			}else{
				json_return(4094,'修改失败！请重试。');
			}
		}else{
			json_return(999,'非法访问！');
		}
	}
	public function delivery_delete(){
		if(IS_POST){
			if (empty($this->store_session['store_id'])) {
				json_return(999,'非法访问！');
			}
			
			$condition_postage_template['tpl_id'] = $_POST['tpl_id'];
			$condition_postage_template['store_id'] = $this->store_session['store_id'];
			$database_postage_template = D('Postage_template');
			
			if($database_postage_template->where($condition_postage_template)->delete()){
				// 删除运费模板后，将相关运用此运费模板的产品改为固定运费，并将固定运费改为0
				$data = array();
				$data['postage_type'] = 0;
				$data['postage'] = 0;
				$data['postage_template_id'] = 0;
				D('Product')->where(array('store_id' => $this->store_session['store_id']))->data($data)->save();
				
				json_return(0,'删除成功');
			}else{
				json_return(4095,'删除失败！请重试。');
			}
		}else{
			json_return(999,'非法访问！');
		}
	}
	
	/*交易物流通知*/
	public function setting(){
		$this->display();
	}
	public function setting_amend(){
		$condition_trade_setting['store_id'] = $this->store_session['store_id'];
		$data_trade_setting['pay_cancel_time'] = intval($_POST['pay_cancel_time']);
		$data_trade_setting['pay_alert_time'] = intval($_POST['pay_alert_time']);
		$data_trade_setting['sucess_notice'] = intval($_POST['sucess_notice']);
		$data_trade_setting['send_notice'] = intval($_POST['send_notice']);
		//$data_trade_setting['complain_notice'] = intval($_POST['complain_notice']);  //维权通知必须开启
		$data_trade_setting['last_time'] = $_SERVER['REQUEST_TIME'];
		if(D('Trade_setting')->where($condition_trade_setting)->data($data_trade_setting)->save()){
			json_return(0,'保存成功');
		}else{
			json_return(4098,'保存失败！请重试。');
		}
	}
	
	/*买家上门自提*/
	public function selffetch(){
		$this->display();
	}
	public function selffetch_modify(){
		$data_trade_selffetch['store_id'] = $this->store_session['store_id'];
		$data_trade_selffetch['name'] = $_POST['name'];
		$data_trade_selffetch['province'] = intval($_POST['province']);
		$data_trade_selffetch['city'] = intval($_POST['city']);
		$data_trade_selffetch['county'] = intval($_POST['county']);
		$data_trade_selffetch['address'] = $_POST['address_detail'];
		$data_trade_selffetch['tel'] = $_POST['tel'];
		$data_trade_selffetch['last_time'] = $_SERVER['REQUEST_TIME'];
		if(D('Trade_selffetch')->data($data_trade_selffetch)->add()){
			json_return(0,'保存成功');
		}else{
			json_return(4099,'保存失败！请重试');
		}
	}
	public function selffetch_get(){
		$selffetch = M('Trade_selffetch')->get_selffetch($_POST['pigcms_id'],$this->store_session['store_id']);
		if($selffetch){
			json_return(0,$selffetch);
		}else{
			json_return(4099,'查询失败！请重试');
		}
	}
	public function selffetch_amend(){
		$condition_trade_selffetch['pigcms_id'] = $_POST['pigcms_id'];
		$condition_trade_selffetch['store_id'] = $this->store_session['store_id'];
		$data_trade_selffetch['name'] = $_POST['name'];
		$data_trade_selffetch['province'] = intval($_POST['province']);
		$data_trade_selffetch['city'] = intval($_POST['city']);
		$data_trade_selffetch['county'] = intval($_POST['county']);
		$data_trade_selffetch['address'] = $_POST['address_detail'];
		$data_trade_selffetch['tel'] = $_POST['tel'];
		$data_trade_selffetch['last_time'] = $_SERVER['REQUEST_TIME'];
		if(D('Trade_selffetch')->where($condition_trade_selffetch)->data($data_trade_selffetch)->save()){
			json_return(0,'保存成功');
		}else{
			json_return(4099,'保存失败！请重试');
		}
	}

	public function selffetch_status()
	{
		$status = intval(trim($_POST['status']));
		$store_id = $this->store_session['store_id'];

		$store = M('Store');
		$result = $store->setSelfFetchStatus($status, $store_id);
		if ($result) {
			json_return(0, '保存成功！');
		} else {
			json_return(4099, '保存失败，请重试！');
		}
	}

	//自提点删除
	public function selffetch_delete()
	{
		$pigcms_id = intval(trim($_POST['pigcms_id']));
		$store_id = $this->store_session['store_id'];
		if (D('Trade_selffetch')->where(array('pigcms_id' => $pigcms_id, 'store_id' => $store_id))->delete()) {
			json_return(0, '删除成功！');
		} else {
			json_return(1001, '删除失败，请重试！');
		}
	}
	
	/**
	 * 货到付款
	 */
	public function offline_payment(){
		$this->display();
	}
	
	public function offline_payment_load() {
		if(empty($_POST['page'])) pigcms_tips('非法访问！','none');
		if($_POST['page'] == 'offline_payment_content'){
			$store = M('Store')->getStore($this->store_session['store_id']);
			$this->assign('store',$store);
		}
		
		$this->display($_POST['page']);
	}
	
	public function offline_payment_status() {
		$status = intval(trim($_POST['status']));
		$store_id = $this->store_session['store_id'];

		$result = D('Store')->where(array('store_id' => $store_id))->data(array('offline_payment' => $status))->save();
		if ($result) {
			json_return(0, '保存成功！');
		} else {
			json_return(4099, '保存失败，请重试！');
		}
	}
	
	/**
	 * 找人代付
	 */
	public function pay_agent()
	{
		$this->display();
	}
	
	/**
	 * 找人代付状态
	 */
	public function pay_agent_status()
	{
		$status = intval(trim($_POST['status']));
		$store_id = $this->store_session['store_id'];

		$store = M('Store');
		$result = $store->setPayAgentStatus($status, $store_id);
		if ($result) {
			json_return(0, '保存成功！');
		} else {
			json_return(4099, '保存失败，请重试！');
		}
	}

	/**
	 * 找人代付发起人
	 */
	public function pay_agent_content_buyer()
	{
		$help = M('Store_pay_agent');
		$helps = $help->getBuyerHelps($this->store_session['store_id']);

		$this->assign('helps', $helps);
		$this->display();
	}

	/**
	 * 找人代付代付人
	 */
	public function pay_agent_content_payer()
	{
		$comment = M('Store_pay_agent');
		$comments = $comment->getPayerComments($this->store_session['store_id']);

		$this->assign('comments', $comments);
		$this->display();
	}

	/**
	 * 找人代付-发起人求助/代付人留言添加
	 */
	public function pay_agent_content_add()
	{
		$pay_agent = M('Store_pay_agent');

		$data = array();
		$data['store_id'] = $this->store_session['store_id'];
		$data['type']	 = intval($_POST['type']);
		$data['nickname'] = trim($_POST['nickname']);
		$data['content']  = trim($_POST['content']);

		if ($pay_agent->add($data))
		{
			json_return(0, '保存成功！');
		} else {
			json_return(4099, '保存失败，请重试！');
		}
	}

	/**
	 * 找人代付-发起人求助/代付人留言修改
	 */
	public function pay_agent_content_edit()
	{
		$pay_agent = M('Store_pay_agent');

		$where = array();
		$data = array();
		$where['agent_id'] = intval(trim($_GET['agent_id']));
		$where['store_id'] = $this->store_session['store_id'];
		$data['type']	 = intval($_POST['type']);
		$data['nickname'] = trim($_POST['nickname']);
		$data['content']  = trim($_POST['content']);

		if ($pay_agent->edit($data, $where))
		{
			json_return(0, '保存成功！');
		} else {
			json_return(4099, '保存失败，请重试！');
		}
	}
	/**
	 * 找人代付-发起人求助/代付人留言删除
	 */
	public function pay_agent_content_del()
	{
		$pay_agent = M('Store_pay_agent');

		$where = array();
		$where['agent_id'] = intval(trim($_GET['agent_id']));
		$where['store_id'] = $this->store_session['store_id'];

		if ($pay_agent->del($where))
		{
			json_return(0, '删除成功！');
		} else {
			json_return(4099, '删除失败，请重试！');
		}
	}

	/**
	 * 收入提现
	 */
	public function income()
	{
		$to = '';
		if (!empty($_GET['to']) && $_GET['to'] == 'supplier') { //经销商向供货商提现
			if (empty($_GET['supplier_id'])) {
				pigcms_tips('参数有误');
			}
			$to = 'supplier';
			$supplier_id = intval(trim($_GET['supplier_id']));
			if (!D('Supp_dis_relation')->where(array('distributor_id' => $this->store_session['store_id'], 'supplier_id' => $supplier_id))->count('id')) {
				pigcms_tips('参数有误');
			}
		} else if (!empty($_GET['to']) && $_GET['to'] == 'platform') { //供货商向平台提现
			$to = 'platform';
		}
		//积分兑换可提现余额
		$withdrawal = !empty($_GET['withdrawal']) ? strtolower($_GET['withdrawal']) : '';
		$where = array();
		$where['store_id'] = $this->store_session['store_id'];
		//类型
		if (isset($_REQUEST['type'])) {
			$type = intval(trim($_REQUEST['type']));
			$where['type'] = $type;
			$this->assign('type', $type);
		}
		//状态
		if (isset($_REQUEST['status'])) {
			$status = intval(trim($_REQUEST['status']));
			$this->assign('status', $status);
		}
		//本店提现记录
		$my_withdrawal_count = D('Store_withdrawal')->where($where)->count('pigcms_id');

		//分销商提现记录
		$where = array();
		$where['supplier_id'] = $this->store_session['store_id'];
		if (!empty($_GET['seller_id'])) {
			$seller_id = intval(trim($_GET['seller_id']));
		}
		$where['status']      = 1;
		$where['type']        = 0;
		$seller_withdrawal_count = D('Store_withdrawal')->where($where)->count('pigcms_id');

		//是否显示经销商提现
		$show_dealer_withdrawal = false;
		//经销商提现记录数
		$dealer_withdrawal_count = 0;
		if (empty($this->store_session['drp_supplier_id'])) {
			$dealer_count = D('Supp_dis_relation')->where(array('supplier_id' => $this->store_session['store_id']))->count('id');
			if ($dealer_count > 0) {
				$show_dealer_withdrawal = true;

				//经销商提现记录
				$where = array();
				$where['supplier_id'] = $this->store_session['store_id'];
				if (!empty($_GET['seller_id'])) {
					$seller_id = intval(trim($_GET['seller_id']));
				}
				$where['status']      = 1;
				$where['type']        = 2;
				$dealer_withdrawal_count = D('Store_withdrawal')->where($where)->count('pigcms_id');
			}
		}

		//是否开启平台保证金
		import('source.class.Margin');
		$open_margin_recharge = Margin::check();

		//充值返还记录
		$platform_margin_return_count = D('Platform_margin_log')->where(array('store_id' => $this->store_session['store_id'], 'type' => 1, 'status' => 1))->count('pigcms_id');

		$this->assign('my_withdrawal_count', $my_withdrawal_count);
        $this->assign('seller_withdrawal_count', $seller_withdrawal_count);
		$this->assign('to', $to);
		$this->assign('seller_id', $seller_id);
		$this->assign('supplier_id', $supplier_id);
		$this->assign('show_dealer_withdrawal', $show_dealer_withdrawal);
		$this->assign('dealer_withdrawal_count', $dealer_withdrawal_count);
		$this->assign('open_margin_recharge', $open_margin_recharge);
		$this->assign('withdrawal', $withdrawal);
		$this->assign('platform_margin_return_count', $platform_margin_return_count);
		$this->display();
	}

	private function _income_content()
	{
		$store = M('Store');
		$financial_record  = M('Financial_record');
		$supp_dis_relation = M('Supp_dis_relation');
		$store_withdrawal  = M('Store_withdrawal');

		$store_id = $this->store_session['store_id'];
		$store = $store->getStore($store_id);

		//七日收入、分润、提现统计
		$days = array();
		for ($i = 6; $i >= 0; $i--) {
			$day = date("Y-m-d", strtotime('-' . $i . 'day'));
			$days[] = $day;
		}
		$tmp_days = array();
		$days_7_income = array(); //七日收入
		$days_7_outlay = array(); //七日支出
		$days_7_profit = array(); //七日利润
		$days_7_withdrawal = array(); //七日提现记录
		foreach ($days as $day) {
			//开始时间
			$start_time = strtotime($day . ' 00:00:00');
			//结束时间
			$stop_time = strtotime($day . ' 23:59:59');

			//七日收入
			if (empty($store['drp_supplier_id'])) {
				$where = array();
				$where['store_id'] = $store_id;
				$where['_string']  = "add_time >= '" . $start_time . "' AND add_time <= '" . $stop_time . "'";
				$orders = D('Order')->where($where)->select();
				$income = 0;
				if ($orders) {
					foreach ($orders as $order) {
						$where = array();
						$where['order_id'] = $order['order_id'];
						if ($order['status'] != 4) {
							$where['type'] = array('!=', 3);
						}
						$income += D('Financial_record')->where($where)->sum('income');
					}
				}
				$days_7_income[] = number_format($income, 2, '.', '');

				//七日支出
				//分销支出
				$where = array();
				$where['supplier_id'] = $store_id;
				$where['status']      = 3;
				$where['type']        = 0;
				$where['_string']     = "add_time >= '" . $start_time . "' AND add_time <= '" . $stop_time . "'";
				$outlay = $store_withdrawal->getWithdrawalAmount($where);
				$days_7_outlay[] = number_format($outlay, 2, '.', '');

				//提现记录
				$where = array();
				$where['store_id']   = $store_id;
				$where['status']     = array('in', array(1,2,3));
				$where['type']       = 1;
				$where['_string']    = "add_time >= '" . $start_time . "' AND add_time <= '" . $stop_time . "'";
				$withdrawal = $store_withdrawal->getWithdrawalAmount($where);
				$days_7_withdrawal[] = number_format($withdrawal, 2, '.', '');
			} else {
				//销售额
				$where = array();
				$where['store_id']      = $store_id;
				$where['user_order_id'] = 0;
				$where['status']        = array('in', array(2,3,4,6,7));
				$where['_string']       = "paid_time >= '" . $start_time . "' AND paid_time <= '" . $stop_time . "'";
				$sales = D('Order')->where($where)->sum('total');
				//累计退货
				$sql = "SELECT SUM(r.product_money + r.postage_money + (r.platform_point / o.point2money_rate)) AS return_total FROM " . option('system.DB_PREFIX') . "return r, " . option('system.DB_PREFIX') . "order o WHERE o.order_id = r.order_id AND o.store_id = '" . $store_id . "' AND o.user_order_id = 0 AND o.status IN (2,3,4,6,7) AND o.paid_time >= '" . $start_time . "' AND o.paid_time <= '" . $stop_time . "'";
				$return = D('')->query($sql);
				$return_total = !empty($return[0]['return_total']) ? $return[0]['return_total'] : 0;
				$sales -= $return_total;
				$days_7_income[] = number_format($sales, 2, '.', '');

				//七日利润(纯利润)
				$where = array();
				$where['store_id'] = $store_id;
				$where['_string']  = "add_time >= '" . $start_time . "' AND add_time <= '" . $stop_time . "'";
				$my_profit = $financial_record->getTotal($where);
				$days_7_profit[] = number_format($my_profit, 2, '.', '');

				//提现记录
				$where = array();
				$where['store_id']   = $store_id;
				$where['status']     = array('in', array(1,2,3));
				$where['_string']    = "add_time >= '" . $start_time . "' AND add_time <= '" . $stop_time . "'";
				$withdrawal = $store_withdrawal->getWithdrawalAmount($where);
				$days_7_withdrawal[] = number_format($withdrawal, 2, '.', '');
			}

			$tmp_days[] = "'" . $day . "'";
		}
		$days = '[' . implode(',', $tmp_days) . ']';

		$days_7_income_total     = array_sum($days_7_income);
		if (!empty($days_7_outlay)) {
			$days_7_outlay_total = array_sum($days_7_outlay);
			$days_7_outlay       = '[' . implode(',', $days_7_outlay) . ']';
		}
		$days_7_profit_total     = array_sum($days_7_profit);
		$days_7_withdrawal_total = array_sum($days_7_withdrawal);

		$days_7_income     = '[' . implode(',', $days_7_income) . ']';
		$days_7_profit     = '[' . implode(',', $days_7_profit) . ']';
		$days_7_withdrawal = '[' . implode(',', $days_7_withdrawal) . ']';

		if (!empty($store['bank_id']) && !empty($store['bank_card'])) {
			$this->assign('bind_bank_card', true);
		} else {
			$this->assign('bind_bank_card', false);
		}

		if (empty($store['drp_supplier_id'])) {
			//待支出分润
			$sql = "SELECT SUM(s.balance + s.unbalance) AS wait_outlay_profit FROM " . option('system.DB_PREFIX') . "store s, " . option('system.DB_PREFIX') . "store_supplier ss WHERE s.store_id = ss.seller_id AND FIND_IN_SET(" . $store_id . ", ss.supply_chain)";
			$sellers = D('')->query($sql);
			$wait_outlay_profit = !empty($sellers[0]['wait_outlay_profit']) ? $sellers[0]['wait_outlay_profit'] : 0;
			//申请提现未处理
			$withdrawal_pending = $store_withdrawal->getWithdrawalAmount(array('supplier_id' => $store_id, 'status' => 1));
			$store['wait_outlay_profit'] = number_format($wait_outlay_profit + $withdrawal_pending, 2, '.', '');

			//已支付给供货商金额
			$paid_amount = $supp_dis_relation->getPaid($store_id);
			$store['paid_amount'] = number_format($paid_amount, 2, '.', '');

			//未支付欠供货商金额
			$not_paid_amount = $supp_dis_relation->getNotPaid($store_id);
			$store['not_paid_amount'] = number_format($not_paid_amount, 2, '.', '');

			//退货欠供货商金额
			$retrn_owe_amount = $supp_dis_relation->getReturnOwe($store_id);
			$store['return_owe_amount'] = number_format($retrn_owe_amount, 2, '.', '');

			//保证金余额
			$bond_balance = $supp_dis_relation->getBondBalance($store_id);
			$store['bond_balance'] = number_format($bond_balance, 2, '.', '');

			$this->assign('days_7_outlay', $days_7_outlay);
			$this->assign('days_7_outlay_total', number_format($days_7_outlay_total, 2, '.', ''));

		} else { //分销商
			//累计销售额
			$where = array();
			$where['store_id']      = $store_id;
			$where['user_order_id'] = 0;
			$where['status']        = array('in', array(2,3,4,6,7));
			$sales_total = D('Order')->where($where)->sum('total');
			//累计退货
			$sql = "SELECT SUM(r.product_money + r.postage_money + (r.platform_point / o.point2money_rate)) AS return_total FROM " . option('system.DB_PREFIX') . "return r, " . option('system.DB_PREFIX') . "order o WHERE o.order_id = r.order_id AND o.store_id = '" . $store_id . "' AND o.user_order_id = 0 AND o.status IN (2,3,4,6,7)";
			$return = D('')->query($sql);
			$return_total = !empty($return[0]['return_total']) ? $return[0]['return_total'] : 0;
			$store['sales_total'] = number_format($sales_total - $return_total, 2, '.', '');
			$store['return_total'] = number_format($return_total, 2, '.', '');
		}

		$sended_dividends = D('Dividends_send_log')->where(array('supplier_id'=>$store_id))->sum('amount');

		if(!$sended_dividends){
			$sended_dividends = '0.00';
		}

        $is_change_bankcard_open = D('Config')->where(array('name'=>'is_change_bankcard_open'))->field('value')->find();

		$this->assign('days', $days);
		$this->assign('days_7_income', $days_7_income);
		$this->assign('days_7_profit', $days_7_profit);
		$this->assign('days_7_withdrawal', $days_7_withdrawal);
		$this->assign('days_7_income_total', number_format($days_7_income_total, 2, '.', ''));
		$this->assign('days_7_profit_total', number_format($days_7_profit_total, 2, '.', ''));
		$this->assign('days_7_withdrawal_total', number_format($days_7_withdrawal_total, 2, '.', ''));
		$this->assign('store', $store);
		$this->assign('sended_dividends', $sended_dividends);
		$this->assign('is_change_bankcard_open', $is_change_bankcard_open['value']);
	}

	//待结算
	private function _waitsettled_content()
	{

	}

	//收支明细
	private function _inoutdetail_content()
	{
		$order = M('Order');
		$financial_record = M('Financial_record');

		$where = array();
		$where['store_id'] = $this->store_session['store_id'];
		if (!empty($_POST['order_no'])) {
			$where['order_no'] = trim($_POST['order_no']);
		}
		if (!empty($_POST['type'])) {
			$where['type'] = trim($_POST['type']);
		}
		if (!empty($_POST['status'])) {
			$where['status'] = trim($_POST['status']);
		}
		if (!empty($_POST['start_time']) && !empty($_POST['stop_time'])) {
			$where['_string'] = "add_time >= '" . strtotime(trim($_POST['start_time'])) . "' AND add_time <= '" . strtotime(trim($_POST['stop_time'])) . "'";
		} else if (!empty($_POST['start_time'])) {
			$where['add_time'] = array('<=', strtotime(trim($_POST['start_time'])));
		} else if (!empty($_POST['stop_time'])) {
			$where['add_time'] = array('>=', strtotime(trim($_POST['stop_time'])));
		}
		$record_total = $financial_record->getRecordCount($where);
		import('source.class.user_page');
		$page = new Page($record_total, 20);
		$records = $financial_record->getRecords($where, $page->firstRow, $page->listRows);

		if (!empty($records)) {
			foreach ($records as &$record) {
				if ($record['income'] > 0 && $record['profit'] <= 0) {
					$record['real_profit'] = $record['income'];
				} else {
					$record['real_profit'] = $record['profit'];
				}
				$record['real_profit'] = $financial_record->getOrderProfit($record['order_id']);
			}
		}

		//订单类型
		$record_types = $financial_record->getRecordTypes();
		//支付方式
		$payment_methods = $order->getPaymentMethod();

		$this->assign('records', $records);
		$this->assign('page', $page->show());
		$this->assign('record_types', $record_types);
		$this->assign('payment_methods', $payment_methods);
	}

	//批发盈利
	private function _wholesale_content()
	{
		if (!empty($this->store_session['drp_supplier_id'])) {
			json_return(1001, 'Sorry, page not found!');
		}

		$order = M('Order');

		//支付方式
		$payment_methods = $order->getPaymentMethod();

		$where = array();
		$condition = array();
		if (!empty($_POST['order_no'])) {
			$where['order_no']     = trim($_POST['order_no']);
			$condition['order_no'] = trim($_POST['order_no']);
		}
		$where['store_id']     = $this->store_session['store_id'];
		$condition['store_id'] = $this->store_session['store_id'];
		$where['type']         = 6;
		$where['income'] = array('<', 0);
		$condition['type']     = 6;
		$condition['income'] = array('<', 0);
		if (!empty($_POST['type']) && $_POST['type'] == 1) { //未分佣
			$where['status']     = array('!=', 4);
			$condition['status'] = array('!=', 4);
		} else if (!empty($_POST['type']) && $_POST['type'] == 2) { //已分佣
			$where['status']     = 4;
			$condition['status'] = 3;
		}

		if (!empty($_POST['start_time']) && !empty($_POST['stop_time'])) {
			$where['_string']     = "`add_time` >= " . strtotime($_POST['start_time']) . " AND `add_time` <= " . strtotime($_POST['stop_time']);
			$condition['_string'] = "`add_time` >= " . strtotime($_POST['start_time']) . " AND `add_time` <= " . strtotime($_POST['stop_time']);
		} else if (!empty($_POST['start_time'])) {
			$where['add_time']     = array('>=', strtotime($_POST['start_time']));
			$condition['add_time'] = array('>=', strtotime($_POST['start_time']));
		} else if (!empty($_POST['stop_time'])) {
			$where['add_time']     = array('<=', strtotime($_POST['stop_time']));
			$condition['add_time'] = array('<=', strtotime($_POST['stop_time']));
		}

		//批发利润总计
		$profit_total = D('Financial_record')->where($condition)->sum('profit');

		$record_count = D('Financial_record')->where($where)->count('pigcms_id');
		import('source.class.user_page');
		$page = new Page($record_count, 15);
		$records = D('Financial_record')->where($where)->order('order_id DESC')->limit($page->firstRow . ',' . $page->listRows)->select();
		$profit_sub_total = 0;
		foreach ($records as &$record) {
			$supplier = D('Store')->where(array('store_id' => $record['supplier_id']))->find();
			$record['supplier'] = $supplier['name'];
			$record['income'] = number_format(abs($record['income']), 2, '.', '');

			$order = D('Order')->field('third_id')->where(array('order_id' => $record['order_id']))->find();
			$record['third_id'] = $order['third_id'];

			$profit_sub_total += $record['profit'];
		}

		$this->assign('profit_sub_total', number_format($profit_sub_total, 2, '.', ''));
		$this->assign('profit_total', number_format($profit_total, 2, '.', ''));
		$this->assign('records', $records);
		$this->assign('payment_methods', $payment_methods);
		$this->assign('page', $page->show());
	}

	//分销盈利
	private function _drp_content()
	{
		if (empty($this->store_session['drp_supplier_id'])) {
			json_return(1001, 'Sorry, page not found!');
		}

		$order = M('Order');

		//支付方式
		$payment_methods = $order->getPaymentMethod();

		$where = array();
		$condition = array();
		if (!empty($_POST['order_no'])) {
			$where['order_no']     = trim($_POST['order_no']);
			$condition['order_no'] = trim($_POST['order_no']);
		}
		$where['store_id']     = $this->store_session['store_id'];
		$condition['store_id'] = $this->store_session['store_id'];
		$where['type']         = 3;
		$condition['type']     = array('in', array(3, 5));
		if (!empty($_POST['type']) && $_POST['type'] == 1) { //未分佣
			$where['status']     = array('!=', 4);
			$condition['status'] = array('!=', 4);
		} else if (!empty($_POST['type']) && $_POST['type'] == 2) { //已分佣
			$where['status']     = 4;
			$condition['status'] = 3;
		}
		$where['paid_time'] = array('>', 0);

		if (!empty($_POST['start_time']) && !empty($_POST['stop_time'])) {
			$where['_string']     = "`add_time` >= " . strtotime($_POST['start_time']) . " AND `add_time` <= " . strtotime($_POST['stop_time']);
			$condition['_string'] = "`add_time` >= " . strtotime($_POST['start_time']) . " AND `add_time` <= " . strtotime($_POST['stop_time']);
		} else if (!empty($_POST['start_time'])) {
			$where['add_time']     = array('>=', strtotime($_POST['start_time']));
			$condition['add_time'] = array('>=', strtotime($_POST['start_time']));
		} else if (!empty($_POST['stop_time'])) {
			$where['add_time']     = array('<=', strtotime($_POST['stop_time']));
			$condition['add_time'] = array('<=', strtotime($_POST['stop_time']));
		}

		//分销利润总计
		$profit_total = D('Financial_record')->where($condition)->sum('income');

		$orderby = '`order_id` DESC';

		$order_total = $order->getOrderTotal($where);
		import('source.class.user_page');
		$page = new Page($order_total, 15);
		$orders = $order->getOrders($where, $orderby, $page->firstRow, $page->listRows);
		$profit_sub_total = 0;
		foreach ($orders as &$order) {
			$profit = D('Financial_record')->where(array('order_id' => $order['order_id'], 'type' => array('in', array(3, 5))))->sum('income');
			$order['profit'] = number_format($profit, 2, '.', ''); //利润

			$profit_sub_total += $order['profit'];
		}
		$this->assign('profit_sub_total', number_format($profit_sub_total, 2, '.', ''));
		$this->assign('profit_total', number_format($profit_total, 2, '.', ''));
		$this->assign('orders', $orders);
		$this->assign('payment_methods', $payment_methods);
		$this->assign('page', $page->show());
	}

	//
	public function settingwithdrawal()
	{
		$store = M('Store');

		if (IS_POST) {
			/*if (empty($_POST['verify_code']) || empty($_POST['tel']) || empty($_SESSION['captcha'][$_POST['tel']]) || $_SESSION['captcha'][$_POST['tel']] != md5(trim($_POST['verify_code']))) {
				json_return(1000, '短信验证码错误');
			}*/
            $is_change_bankcard_open = D('Config')->where(array('name'=>'is_change_bankcard_open'))->field('value')->find();
            $bank = D('Store')->where(array('store_id'=>$this->store_session['store_id']))->field('bank_card')->find();

            if($is_change_bankcard_open['value'] || $bank['bank_card']==''){
                $data = array();
                $data['withdrawal_type'] = isset($_POST['withdrawal_type']) ? intval(trim($_POST['withdrawal_type'])) : 0;
                $data['bank_id'] = isset($_POST['bank_id']) ? intval(trim($_POST['bank_id'])) : 0;
                $data['opening_bank'] = isset($_POST['opening_bank']) ? trim($_POST['opening_bank']) : '';
                $data['bank_card'] = isset($_POST['bank_card']) ? trim($_POST['bank_card']) : '';
                $data['bank_card_user'] = isset($_POST['bank_card_user']) ? trim($_POST['bank_card_user']) : '';
                $data['last_edit_time'] = time();
                $where = array();
                $where['store_id'] = $this->store_session['store_id'];
                if ($store->settingWithdrawal($where, $data)) {
                    unset($_SESSION['captcha'][$_POST['tel']]);
                    json_return(0, '设置成功');
                } else {
                    json_return(1001, '设置失败');
                }
            }else{
                json_return(1002, '设置失败');
            }
		}
	}

	//设置提现账号
	private function _settingwithdrawal_content()
	{
		if($_SESSION['user']['group']>0){
	        die('您没有操作权限！');
	    }
		
		
		
		$bank = M('Bank');
		$banks = $bank->getEnableBanks();

		$this->assign('store', $this->store_session);
		$this->assign('banks', $banks);

		$is_dividends = trim($_POST['is_dividends']);

		if($is_dividends){
			$this->assign('is_dividends', $is_dividends);
		}
	}

	//修改提现账号
	private function _editwithdrawal_content()
	{
	
	   if($_SESSION['user']['group']>0){
	     die('您没有操作权限！');
	    }
	
	
	
	
		$bank = M('Bank');
		$store = M('Store');

		$banks = $bank->getEnableBanks();
		$store = $store->getStore($this->store_session['store_id']);
        $is_change_bankcard_open = D('Config')->where(array('name'=>'is_change_bankcard_open'))->field('value')->find();

		$this->assign('param', !empty($_POST['param']) ? $_POST['param'] : '');
		$this->assign('store', $store);
		$this->assign('banks', $banks);
		$this->assign('withdrawal_type', $store['withdrawal_type']);
		$this->assign('bank_id', $store['bank_id']);
		$this->assign('opening_bank', $store['opening_bank']);
		$this->assign('bank_card', $store['bank_card']);
		$this->assign('bank_card_user', $store['bank_card_user']);

		$is_dividends = trim($_POST['is_dividends']);

		if($is_dividends){
			$this->assign('is_dividends', $is_dividends);
		}

        $this->assign('is_change_bankcard_open', $is_change_bankcard_open['value']);
	}

	//添加提现申请
	public function applywithdrawal()
	{
        $store_id = $this->store_session['store_id'];

        $store_info = D('Store')->field('drp_supplier_id,balance,point2money_balance,sales_ratio')->where(array('store_id' => $store_id))->find();
        $supplier_id = M('Store_supplier')->getSupplierId($store_id);
		if (IS_POST) {
			$store = M('Store');
			$store_withdrawal = M('Store_withdrawal');

			$to = !empty($_POST['to']) ? strtolower(trim($_POST['to'])) : '';
			$amount = isset($_POST['amount']) ? floatval(trim($_POST['amount'])) : 0;
			$withdrawal = !empty($_POST['withdrawal']) ? strtolower(trim($_POST['withdrawal'])) : '';

			if ($withdrawal == 'margin') { //平台保证金余额提现
				import('source.class.Margin');
				Margin::init($this->store_session['store_id']);
				$result = Margin::consume($amount, 1, '充值现金余额返还', 1);
				if ($result) {
					json_return(0, '充值现金余额返还申请成功');
				} else {
					json_return(1001, '充值现金余额返还申请失败');
				}
			} else { //普通提现、积分兑现提现
				$data = array();
				$data['supplier_id']     = isset($supplier_id) && $supplier_id != $store_id ? $supplier_id : 0;
				$data['trade_no']		 = date('YmdHis',$_SERVER['REQUEST_TIME']).mt_rand(100000,999999);
				$data['uid']			 = $this->user_session['uid'];
				$data['store_id']		 = $this->store_session['store_id'];
				$data['bank_id']		 = isset($_POST['bank_id']) ? intval(trim($_POST['bank_id'])) : 0;
				$data['opening_bank']	 = isset($_POST['opening_bank']) ? trim($_POST['opening_bank']) : '';
				$data['bank_card']	     = isset($_POST['bank_card']) ? trim($_POST['bank_card']) : '';
				$data['bank_card_user']  = isset($_POST['bank_card_user']) ? trim($_POST['bank_card_user']) : '';
				$data['withdrawal_type'] = isset($_POST['withdrawal_type']) ? intval(trim($_POST['withdrawal_type'])) : 0;
				$data['status']		     = 1;
				$data['channel']         = 0;
				$data['add_time']		 = time();
				$data['amount']		     = $amount;
				if ($to == 'platform') { //向平台提现
					$data['type']        = 1;
				
				  	$data['sales_ratio'] = ($store_info['sales_ratio'] > 0)?$store_info['sales_ratio']:option('config.sales_ratio');
                    
					//$data['sales_ratio'] = option('config.sales_ratio');
				
				} else if ($to == 'supplier') {
					$data['type']  = 2;
				}
				$save_data = array();
				if ($withdrawal == 'point2money') { //积分兑换提现
					$data['type'] = 3;
					$data['channel'] = 1;

					//余额
					$balance = $store_info['point2money_balance'] - $amount;
					$balance = ($balance > 0) ? $balance : 0;
					$save_data['point2money_balance'] = $balance;
				} if ($to == 'platform') {
					//余额
					$balance = $store_info['balance'] - $amount;
					$balance = ($balance > 0) ? $balance : 0;
					$save_data['balance'] = $balance;
				}
				if ($store_withdrawal->add($data)) {
					//向平台提现
					if ($to == 'platform') { //供货商向平台提现
						D('Store')->where(array('store_id' => $data['store_id']))->data($save_data)->save();
						if ($withdrawal == 'point2money') { //积分兑换提现
							import('source.class.Margin');
							Margin::init($this->store_session['store_id']);
							Margin::cash_provision_log($amount, 2, 0, '提现扣除备付金');
						}
					} else {
						$store->applywithdrawal($data['store_id'], $data['amount']);
					}
					json_return(0, '提现申请成功');
				} else {
					json_return(1001, '提现申请失败');
				}
			}
		}
	}

	//申请提现
	private function _applywithdrawal_content()
	{
		$bank = M('Bank');
		$store = M('Store');
		$to = !empty($_POST['to']) ? strtolower(trim($_POST['to'])) : '';
		$withdrawal = !empty($_POST['withdrawal']) ? strtolower($_POST['withdrawal']) : '';

		$store = $store->getStore($this->store_session['store_id']);
		$bank = $bank->getBank($store['bank_id']);

		$supplier_name = '';

		//最低提现额度限制
		$withdrawal_amount_min = 0;
		if (empty($store['drp_supplier_id'])) {
			$withdrawal_amount_min = option('config.withdrawal_min_amount');
			$withdrawal_amount_min = !empty($withdrawal_amount_min) ? $withdrawal_amount_min : 0;
		} else {
			import('source.class.Drp');
			$withdrawal_amount_min = Drp::withdrawal_min($store['root_supplier_id']);
		}

		//向平台提现（积分兑换可提现余额）
		if ($withdrawal == 'point2money') {
			import('source.class.Margin');
			$point_alias = Margin::point_alias();

			$balance = number_format($store['point2money_balance'], 2, '.', '');
			$store['balance'] = $balance;

			$this->assign('point_alias', $point_alias);
		} else if ($withdrawal == 'margin') {
			import('source.class.Margin');
			Margin::init($this->store_session['store_id']);
			$withdrawal_amount_min = Margin::setting('margin_withdrawal_amount_min');
			$balance = number_format($store['margin_balance'], 2, '.', '');
			$store['balance'] = $balance;
		} else {
			$balance = number_format($store['balance'], 2, '.', '');
		}


		//可提现金额
		$sales_ratio = 0;
		if ($to == 'platform') { //供货商向平台提现
			
			$sales_ratio = ($store['sales_ratio'] > 0)?$store['sales_ratio']:option('config.sales_ratio');

			//$sales_ratio = option('config.sales_ratio');
			

			$sales_ratio = !empty($sales_ratio) ? number_format($sales_ratio, 2, '.', '') : 0;
			$sales_ratio_100 = (1 - ($sales_ratio / 100));
			$balance = $sales_ratio_100 * $store['balance'];
		}

		$this->assign('withdrawal_amount_min', number_format($withdrawal_amount_min, 2, '.', ''));
		$this->assign('supplier_name', $supplier_name);
		$this->assign('balance', number_format($store['balance'], 2, '.', ''));
		$this->assign('real_balance', number_format($balance, 2, '.', ''));
		$this->assign('bank', $bank['name']);
		$this->assign('store', $store);
		$this->assign('sales_ratio', number_format($sales_ratio, 2, '.', ''));
		$this->assign('to', $to);
		$this->assign('withdrawal', $withdrawal);
	}


	//添加分红提现申请
	public function dividendswithdrawal()
	{
        $store_id = $this->store_session['store_id'];

        $store_info = D('Store')->field('drp_supplier_id,balance')->where(array('store_id' => $store_id))->find();
        if (!empty($store_info['drp_supplier_id'])) {
            $supplier_info = D('Store_supplier')->field('supply_chain')->where(array('seller_id' => $store_id, 'type' => 1))->find();
            $supply_chain = explode(',', $supplier_info['supply_chain']);
            $suplier_id = $supply_chain[1];
        } else if (!empty($_POST['supplier_id'])) {
			$suplier_id = intval(trim($_POST['supplier_id']));
		}
		if (IS_POST) {
			$store = M('Store');
			$store_withdrawal = M('Store_withdrawal');

			$to     = !empty($_POST['to']) ? strtolower(trim($_POST['to'])) : '';
			$amount = isset($_POST['amount']) ? floatval(trim($_POST['amount'])) : 0;
			$data = array();
            $data['supplier_id']     = isset($suplier_id) ? $suplier_id : '0';
			$data['trade_no']		 = date('YmdHis',$_SERVER['REQUEST_TIME']).mt_rand(100000,999999);
			$data['uid']			 = $this->user_session['uid'];
			$data['store_id']		 = $this->store_session['store_id'];
			$data['bank_id']		 = isset($_POST['bank_id']) ? intval(trim($_POST['bank_id'])) : 0;
			$data['opening_bank']	 = isset($_POST['opening_bank']) ? trim($_POST['opening_bank']) : '';
			$data['bank_card']	     = isset($_POST['bank_card']) ? trim($_POST['bank_card']) : '';
			$data['bank_card_user']  = isset($_POST['bank_card_user']) ? trim($_POST['bank_card_user']) : '';
			$data['withdrawal_type'] = isset($_POST['withdrawal_type']) ? intval(trim($_POST['withdrawal_type'])) : 0;
			$data['status']		     = 1;
			$data['add_time']		 = time();
			$data['amount']		     = $amount;
				
			//分红提现类型
		    $data['type'] = '2';
		    $data['bak'] = '分红';

			if ($store_withdrawal->add($data)) {
				//减分红余额
           		D('Store')->where(array('store_id' => $data['store_id']))->setDec('dividends', $data['amount']);
				json_return(0, '提现申请成功');
			} else {
				json_return(1001, '提现申请失败');
			}
		}
	}

	//申请分红
	function _dividends_withdrawal_content(){

		$bank = M('Bank');
		$store = M('Store');

		$to = !empty($_POST['to']) ? strtolower(trim($_POST['to'])) : '';

		$store = $store->getStore($this->store_session['store_id']);
		$bank = $bank->getBank($store['bank_id']);

		//可提现分红
		
		$dividends = $store['dividends'];
			
		$this->assign('dividends', number_format($dividends, 2, '.', ''));
		$this->assign('bank', $bank['name']);
		$this->assign('store', $store);
		$this->assign('to', $to);
	}



	//删除提现账号
	public function delwithdrawal()
	{
		$store = M('Store');

		if ($store->delwithdrawal($this->store_session['store_id'])) {
			json_return(0, '删除成功');
		} else {
			json_return(1001, '删除失败');
		}
	}

	//提现记录
	private function _withdraw_content()
	{
        $withdrawal = M('Store_withdrawal');

		$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
        $store_id = $this->store_session['store_id'];
        $store_info = D('Store')->field('drp_level')->where(array('store_id'=>$store_id))->find();

        $where = array();
        $where['sw.store_id'] = $this->store_session['store_id'];
        if(!empty($store_info['drp_supplier_id'])) {
            $where['sw.supplier_id'] = 0;
        }
		if (!empty($_REQUEST['type'])) {
			$where['sw.type'] = $_POST['type'];
		}
		if (!empty($_POST['status'])) {
			$where['sw.status'] = $_POST['status'];
		}
		if (!empty($_POST['start_time']) && !empty($_POST['stop_time'])) {
			$where['_string'] = "sw.add_time >= '" . strtotime(trim($_POST['start_time'])) . "' AND sw.add_time <= '" . strtotime(trim($_POST['stop_time'])) . "'";
		} else if (!empty($_POST['start_time'])) {
			$where['_string'] = "sw.add_time >= '" . strtotime(trim($_POST['start_time'])) . "'";
		} else if (!empty($_POST['stop_time'])) {
			$where['_string'] = "sw.add_time <= '" . strtotime(trim($_POST['stop_time'])) . "'";
		}
		$withdrawal_count = $withdrawal->getWithdrawalCount($where);
		import('source.class.user_page');
		$page = new Page($withdrawal_count, 20);
		$withdrawals = $withdrawal->getWithdrawals($where, $page->firstRow, $page->listRows);
		foreach ($withdrawals as &$tmp_withdrawal) {
			$tmp_withdrawal['real_amount'] = number_format($tmp_withdrawal['amount'] * (1 - ($tmp_withdrawal['sales_ratio'] / 100)), 2, '.', '');
		}

		$status = $withdrawal->getWithdrawalStatus();

		$this->assign('withdrawals', $withdrawals);
		$this->assign('page', $page->show());
		$this->assign('status', $status);
	}


	//奖金记录
	private function _my_dividends_content()
	{
        if (!empty($_POST['start_time']) && !empty($_POST['stop_time'])) {
			$where['_string'] = "add_time >= '" . strtotime(trim($_POST['start_time'])) . "' AND add_time <= '" . strtotime(trim($_POST['stop_time'])) . "'";
		} else if (!empty($_POST['start_time'])) {
			$where['_string'] = "add_time >= '" . strtotime(trim($_POST['start_time'])) . "'";
		} else if (!empty($_POST['stop_time'])) {
			$where['_string'] = "add_time <= '" . strtotime(trim($_POST['stop_time'])) . "'";
		}

		if (!empty($_POST['type'])) {
			$where['dividends_type'] = trim($_POST['type']);
		}

		$where['store_id'] = $this->store_session['store_id'];;

		//获取记录

	    $dividends_send_log_count = D('Dividends_send_log')->where($where)->count('pigcms_id');
	
		import('source.class.user_page');
		$page = new Page($dividends_send_log_count, 20);

		$dividends_send_log =  D('Dividends_send_log')->where($where)->order('pigcms_id desc')->limit($page->firstRow.','.$page->listRows)->select();

		$dividends_type_arr = array(2=>'团队分红',3=>'独立奖金');

		$this->assign('my_dividends', $dividends_send_log);
		$this->assign('page', $page->show());
		$this->assign('dividends_type_arr', $dividends_type_arr);
	
	}



	//交易记录
// 	private function _trade_content()
// 	{
// 		$status = array(
// 			1 => '进行中',
// 			2 => '退款',
// 			3 => '成功',
// 			4 => '失败'
// 		);

// 		$status_text = array(
// 			1 => '进行中',
// 			2 => '退款',
// 			3 => '交易完成',
// 			4 => '交易失败'
// 		);
// 		$order = M('Order');
// 		$financial_record = M('Financial_record');

// 		$where = array();
// 		$where['store_id'] = $this->store_session['store_id'];
// 		if (!empty($_POST['order_no'])) {
// 			$where['order_no'] = trim($_POST['order_no']);
// 		}
// 		if (!empty($_POST['status'])) {
// 			$where['status'] = trim($_POST['status']);
// 		} else if (!empty($_POST['param'])) {
// 			$where['status'] = trim($_POST['param']);
// 		}
// 		if (!empty($_POST['start_time']) && !empty($_POST['stop_time'])) {
// 			$where['_string'] = "add_time >= '" . strtotime(trim($_POST['start_time'])) . "' AND add_time <= '" . strtotime(trim($_POST['stop_time'])) . "'";
// 		} else if (!empty($_POST['start_time'])) {
// 			$where['add_time'] = array('<=', strtotime(trim($_POST['start_time'])));
// 		} else if (!empty($_POST['stop_time'])) {
// 			$where['add_time'] = array('>=', strtotime(trim($_POST['stop_time'])));
// 		}
// 		$record_total = $financial_record->getRecordCount($where);
// 		import('source.class.user_page');
// 		$page = new Page($record_total, 15);
// 		$records = $financial_record->getRecords($where, $page->firstRow, $page->listRows);

// 		$this->assign('records', $records);
// 		$this->assign('page', $page->show());
// 		$this->assign('status', $status);
// 		$this->assign('status_text', $status_text);
// 	}
        
	private function _trade_content()
	{
		import('source.class.user_page');
		$status = array(
			1 => '已付款未发货',
			2 => '已付款未收货',
			3 => '已收货未过退货期',
			4 => '未点击交易完成'
		);

		$status_text = array(
			1 => '已付款未发货',
			2 => '已付款未收货',
			3 => '已收货未过退货期',
			4 => '未点击交易完成',
		);

		if (!empty($_POST['param'])) {
			$_POST['status'] = trim($_POST['param']);
 		}

		$sql='select count(f.pigcms_id) as financial_record_count from '. option('system.DB_PREFIX') . 'financial_record f,'. option('system.DB_PREFIX') . 'order o where o.order_id=f.order_id and f.store_id='.$this->store_session['store_id'];
		$sql2='select f.*,o.status as order_status,o.delivery_time,o.sent_time,o.total,o.sale_total from '. option('system.DB_PREFIX') . 'financial_record f,'. option('system.DB_PREFIX') . 'order o where o.order_id=f.order_id and f.store_id='.$this->store_session['store_id'];

		if (!empty($_POST['order_no'])) {
			$sql .= " AND f.order_no = '" . $_POST['order_no'] . "'";
			$sql2 .= " AND f.order_no = '" . $_POST['order_no'] . "'";
		}

		if (!empty($_POST['status'])) {
			switch($_POST['status']){
				case 1:
					$sql.=' AND o.status=2 ';
					$sql2.=' AND o.status=2 ';
					break;
				case 2:
					$sql.=' AND o.status=3';
					$sql2.=' AND o.status=3';
					break;
				case 3:
					$sql.=' AND o.status=7 AND (('.time().' <=(o.delivery_time+'.(option('config.order_return_date')*24*3600).')) OR ('.time().'<=(o.sent_time+'.(option('config.order_complete_date')*24*3600).')))';
					$sql2.=' AND o.status=7 AND (('.time().' <=(o.delivery_time+'.(option('config.order_return_date')*24*3600).')) OR ('.time().'<=(o.sent_time+'.(option('config.order_complete_date')*24*3600).')))';
					break;
				case 4:
					$sql.=' AND o.status=7 AND (('.time().' >=(o.delivery_time+'.(option('config.order_return_date')*24*3600).')) AND ('.time().'>=(o.sent_time+'.(option('config.order_complete_date')*24*3600).')))';
					$sql2.=' AND o.status=7 AND (('.time().' >=(o.delivery_time+'.(option('config.order_return_date')*24*3600).')) AND ('.time().'>=(o.sent_time+'.(option('config.order_complete_date')*24*3600).')))';
					break;
			}
		}

		if (!empty($_POST['start_time']) && !empty($_POST['stop_time'])) {
			$sql .= " AND f.add_time >= " . strtotime($_POST['start_time']) . " AND f.add_time <= " . strtotime($_POST['stop_time']);
			$sql2 .= " AND f.add_time >= " . strtotime($_POST['start_time']) . " AND f.add_time <= " . strtotime($_POST['stop_time']);
		} else if (!empty($_POST['start_time'])) {
			$sql .= " AND f.add_time >= " . strtotime($_POST['start_time']);
			$sql2 .= " AND f.add_time >= " . strtotime($_POST['start_time']);
		} else if (!empty($_POST['stop_time'])) {
			$sql .= " AND f.add_time <= " . strtotime($_POST['stop_time']);
			$sql2 .= " AND f.add_time <= " . strtotime($_POST['stop_time']);

		}
		$financial_record_count = D('Financial_record')->query($sql);
		$financial_record_count = !empty($financial_record_count[0]['financial_record_count']) ? $financial_record_count[0]['financial_record_count'] : 0;
		$page = new Page($financial_record_count, 15);
		$sql2 .= " ORDER BY f.pigcms_id DESC LIMIT " . $page->firstRow . "," . $page->listRows;

		$records = D('Financial_record')->query($sql2);
		if (!empty($records)) {
			foreach ($records as &$record) {
				if ($record['income'] > 0 && $record['profit'] <= 0) {
					$record['real_profit'] = $record['income'];
				} else {
					$record['real_profit'] = $record['profit'];
				}
				$record['profit'] = number_format($record['profit'], 2, '.', '');
			}
		}

		$this->assign('records', $records);
		$this->assign('page', $page->show());
		$this->assign('status', $status);
		$this->assign('status_text', $status_text);
	}
        
	public function buyer_selffetch_name() {
		$buyer_selffetch_name = $_POST['buyer_selffetch_name'];
		$result = D('Store')->where(array('store_id' => $this->store_session['store_id']))->data(array('buyer_selffetch_name' => $buyer_selffetch_name))->save();
		
		json_return(0, '操作成功');
	}

    public function update_income()
    {
        $supplier_id = $this->store_session['store_id'];
		$status      = isset($_POST['status']) ? intval(trim($_POST['status'])) : 0;
        $pigcms_id   = !empty($_POST['id']) ? $_POST['id'] : '0';
		$update      = !empty($_POST['update']) ? $_POST['update'] : '';
		$bak         = !empty($_POST['bak']) ? $_POST['bak'] : '';

		$withdrawal  = D('Store_withdrawal')->where(array('pigcms_id' => $pigcms_id, 'supplier_id' => $supplier_id))->find();

		if (!empty($update)) {
			if (strtolower($update) != 'bak') {
				json_return(1001, '提现处理失败');
			}
			if (empty($withdrawal) || $withdrawal['type'] == 1) {
				json_return(1002, '提现记录不存在');
			}
			if (D('Store_withdrawal')->where(array('pigcms_id' => $pigcms_id))->data(array('bak' => $bak))->save()) {
				json_return(0, '提现处理备注保存成功');
			} else {
				json_return(1001, '提现处理备注保存失败');
			}
		}

		if (empty($withdrawal)) {
			echo false;
			exit;
		} else if ($withdrawal['type'] == 1) { //供货商提现(只能平台处理)
			echo false;
			exit;
		}
		$data = array();
		$data['status'] = $status;
		if ($status == 3 || $status == 4) {
			$data['complate_time'] = time();
		}
		$result = D('Store_withdrawal')->where(array('pigcms_id' => $pigcms_id))->data($data)->save();
        if ($result) {
			if ($status == 3) { //提现成功
				if (empty($withdrawal['type'])) { //分销商提现
					//更新分销商提现总额
					D('Store')->where(array('store_id' => $withdrawal['store_id']))->setInc('withdrawal_amount', $withdrawal['amount']);
				}
			} else if ($status == 4) { //提现失败
				if (empty($withdrawal['type'])) { //分销商提现
					//退回提现金额到分销商余额
					D('Store')->where(array('store_id' => $withdrawal['store_id']))->setInc('balance', $withdrawal['amount']);
				}
			}
            echo true;
        } else {
            echo false;
        }
		exit;
    }

	//分销商提现
    private function _seller_withdraw_content()
    {
        $withdrawal = M('Store_withdrawal');

		$store_id = $this->store_session['store_id'];
        $seller_id = !empty($_POST['seller_id']) ? intval(trim($_POST['seller_id'])) : 0;

        $where = array();

		if (!empty($seller_id)) {
			$where['sw.store_id'] = $seller_id;
		}
        $where['sw.supplier_id'] = $store_id;
		$where['sw.type'] = 0;
        if (!empty($_POST['status'])) {
            $where['sw.status'] = $_POST['status'];
        }
        if (!empty($_POST['start_time']) && !empty($_POST['stop_time'])) {
            $where['_string'] = "sw.add_time >= '" . strtotime(trim($_POST['start_time'])) . "' AND sw.add_time <= '" . strtotime(trim($_POST['stop_time'])) . "'";
        } else if (!empty($_POST['start_time'])) {
            $where['_string'] = "sw.add_time >= '" . strtotime(trim($_POST['start_time'])) . "'";
        } else if (!empty($_POST['stop_time'])) {
            $where['_string'] = "sw.add_time <= '" . strtotime(trim($_POST['stop_time'])) . "'";
        }
        $withdrawal_count = $withdrawal->getWithdrawalCount($where);
        import('source.class.user_page');
        $page = new Page($withdrawal_count, 20);
        $withdrawals = $withdrawal->getWithdrawals($where, $page->firstRow, $page->listRows);

        $status = $withdrawal->getWithdrawalStatus();

        $this->assign('withdrawals', $withdrawals);
        $this->assign('page', $page->show());
        $this->assign('status', $status);
    }

	//经销商提现
	private function _dealer_withdraw_content()
	{
		$withdrawal = M('Store_withdrawal');

		$store_id = $this->store_session['store_id'];
		$seller_id = !empty($_POST['seller_id']) ? intval(trim($_POST['seller_id'])) : 0;

		$where = array();

		if (!empty($seller_id)) {
			$where['sw.store_id'] = $seller_id;
		}
		$where['sw.supplier_id'] = $store_id;
		$where['sw.type'] = 2;
		if (!empty($_POST['status'])) {
			$where['sw.status'] = $_POST['status'];
		}
		if (!empty($_POST['start_time']) && !empty($_POST['stop_time'])) {
			$where['_string'] = "sw.add_time >= '" . strtotime(trim($_POST['start_time'])) . "' AND sw.add_time <= '" . strtotime(trim($_POST['stop_time'])) . "'";
		} else if (!empty($_POST['start_time'])) {
			$where['_string'] = "sw.add_time >= '" . strtotime(trim($_POST['start_time'])) . "'";
		} else if (!empty($_POST['stop_time'])) {
			$where['_string'] = "sw.add_time <= '" . strtotime(trim($_POST['stop_time'])) . "'";
		}
		$withdrawal_count = $withdrawal->getWithdrawalCount($where);
		import('source.class.user_page');
		$page = new Page($withdrawal_count, 20);
		$withdrawals = $withdrawal->getWithdrawals($where, $page->firstRow, $page->listRows);

		$status = $withdrawal->getWithdrawalStatus();

		$this->assign('withdrawals', $withdrawals);
		$this->assign('page', $page->show());
		$this->assign('status', $status);
	}

	//平台保证金
	private function _platform_margin_content()
	{
		import('source.class.user_page');

		//是否开启平台保证金
		Margin::init($this->store_session['store_id']);
		$open_margin_recharge = Margin::check();
		$open_margin_withdrawal = Margin::setting('open_margin_withdrawal');
		$point_alias = Margin::point_alias();
		$this->assign('point_alias', $point_alias);
		$this->assign('open_margin_withdrawal', $open_margin_withdrawal);

		$store = D('Store')->where(array('store_id' => $this->store_session['store_id']))->find();
		//保证金总额
		$store['margin_total'] = number_format($store['margin_total'], 2, '.', '');
		//保证金余额
		$store['margin_balance'] = number_format($store['margin_balance'], 2, '.', '');
		//积分总额
		$store['point_total'] = number_format($store['point_total'], 2, '.', '');
		//积分余额
		$store['point_balance'] = number_format($store['point_balance'], 2, '.', '');
		//积分兑现服务费
		$store['point2money_service_fee'] = number_format($store['point2money_service_fee'], 2, '.', '');
		//返还的总额
		$margin_return_total = D('Platform_margin_log')->where(array('store_id' => $this->store_session['store_id'], 'type' => 1, 'status' => array('in', array(1, 2))))->sum('amount');
		$margin_return_total = !empty($margin_return_total) ? abs($margin_return_total) : 0;
		//已消耗的充值金额 = 总额 - 余额 - 返还
		$store['margin_used'] = $store['margin_total'] - $store['margin_balance'] - $margin_return_total;
		$store['margin_used'] = number_format($store['margin_used'], 2, '.', '');
		//已充值返还金额
		$margin_return_total = $store['margin_withdrawal'];
		$store['margin_returned'] = number_format($margin_return_total, 2, '.', '');
		//商家积分转做单，商家积分抵做单服务费（保证金额服务费）
		$point2service_fee = D('Store_point_log')->where(array('store_id' => $this->store_session['store_id'], 'order_offline_id' => array('>', 0)))->sum('point');
		$point2service_fee = !empty($point2service_fee) ? $point2service_fee : 0;
		$store['point2service_fee'] = number_format(abs($point2service_fee), 2, '.', '');
		//累计已兑现现金(已提现)
		$store['point2money_withdrawal'] = $store['point2money_total'] - $store['point2money_balance'];
		$store['point2money_withdrawal'] = number_format($store['point2money_withdrawal'], 2, '.', '');
		//累计转可兑现现金
		$store['point2money_total'] += $store['point2money_service_fee'];
		$store['point2money_total'] = number_format($store['point2money_total'], 2, '.', '');

		$where = array();
		$where['store_id'] = $this->store_session['store_id'];
		$where['status'] = 4;
		$where['type'] = array('<', 5);
		$order_count = M('Order')->getOrderCount($where);
		$page = new Page($order_count, 20);
		$orders = M('Order')->getOrders($where, 'order_id DESC', $page->firstRow, $page->listRows);
		if (!empty($orders)) {
			foreach ($orders as &$order) {
				$user_order_id = $order['order_id'];
				$order_id = $user_order_id;
				$order_no = $order['order_no'];

				if (!empty($order['user_order_id'])) {
					$user_order_id = $order['user_order_id'];
				}
				$user_order = D('Order')->where(array('order_id' => $user_order_id))->find();
				$order['cash_point'] = $user_order['cash_point'];
				$order['return_point'] = $user_order['return_point'];
				$order['pay_money'] = $user_order['pay_money'];
				$order['total'] = $user_order['total'];
				if (empty($order['uid'])) {
					$user = D('User')->field('nickname')->where(array('uid' => $order['uid']))->find();
					$order['user'] = $user['nickname'];
				}
				if (empty($order['user'])) {
					$order['user'] = $order['address_user'];
				}
				$service_fee = D('Platform_margin_log')->where(array('order_id' => $user_order_id, 'store_id' => $this->store_session['store_id'], 'type' => array('in', array(2, 3))))->sum('amount');
				$service_fee = !empty($service_fee) ? abs($service_fee) : 0;
				$order['service_fee'] = number_format($service_fee, 2, '.', '');
				$order['order_id'] = $order_id;
				$order['order_no'] = $order_no;

				if (!empty($order['is_offline'])) {
					$order['channel'] = '线下';
				} else {
					$order['channel'] = '线上';
				}
			}
		}

		$this->assign('open_margin_recharge', $open_margin_recharge);
		$this->assign('open_margin_withdrawal', $open_margin_withdrawal);
		$this->assign('store', $store);
		$this->assign('orders', $orders);
		$this->assign('page', $page->show());
	}

	//平台保证金充值
	public function margin_recharge()
	{
		//是否开启平台保证金
		$open_margin_recharge = Margin::check();

		if (IS_AJAX) {
			if (empty($open_margin_recharge)) {
				json_return(1001, '您访问的页面不存在');
			}
			$recharge_min_amount = option('config.recharge_min_amount');
			$amount = !empty($_POST['amount']) ? trim($_POST['amount']) : 0;
			$payment_method = !empty($_POST['method']) ? trim($_POST['method']) : '';
			if (empty($amount)) {
				json_return(1002, '无效的充值金额');
			}
			if (!empty($recharge_min_amount) && is_numeric($recharge_min_amount) && $recharge_min_amount > $amount) {
				json_return(1003, '充值金额小于最低限额');
			}
			if (empty($payment_method)) {
				json_return(1005, '没有选择支付方式');
			}
			$payment_methods = M('Config')->getPlatformPayMethod();
			if (empty($payment_methods[$payment_method])) {
				json_return(1006, '无效的支付方式');
			}
			$payConfig = $payment_methods['allinpay']['config'];
			foreach($payConfig as $key_config => $item_config){
				$count_arrs = explode(',', $item_config);
				if(count($count_arrs)>1){
					$payConfig[$key_config] = $count_arrs[1];
				}else{
					$payConfig[$key_config] = $count_arrs[0];
				}
			}
			$pay_config['pay_allinpay_merchantid']  = $payConfig['pay_allinpay_merchantid'];
			$pay_config['pay_allinpay_merchantkey'] = $payConfig['pay_allinpay_merchantkey'];
			
			import('source.class.Margin');
			Margin::init($this->store_session['store_id']);
			$order_no = Margin::log($amount, 0, time(), 0, '', '充值保证金');
			if (!$order_no) {
				json_return(1007, '保证金充值失败');
			}

			switch ($payment_method) {
				case 'allinpay':
					import('source.class.pay.Allinpay');
					$callback_url = option('config.site_url') . '/user.php?c=trade&a=margin_recharge_callback&pay_type=allinpay';
					$notify_url = option('config.site_url') . '/api/margin_recharge_notify.php?pay_type=allinpay';
					$payClass = new Allinpay(array('order_no' => $order_no,'total' => $amount, 'pro_num' => 1, 'product_name' => '保证金充值'), $pay_config, array('uid' => $this->store_session['uid'], 'nickname' => $this->store_session['name']), 0, $callback_url, $notify_url);
					$payInfo = $payClass->pay();
					if ($payInfo['err_code']) {
						json_return(10000, $payInfo['err_msg']);
					} else {
						json_return(0, $payInfo['form']);
					}
					break;
				case 'platform_weixin':
					
				case 'platform_alipay':
					json_return(0, $order_no, option('config.site_url') . '/source/qrcode.php?type=qrcodePay&id=platform&url=' . urlencode(option('config.wap_site_url') . '/pay_platform.php?order_no=' . $order_no));
					break;
			}
			exit;
		}

		if (empty($open_margin_recharge)) {
			pigcms_tips('您访问的页面不存在');
		}

		$this->display();
	}

	private function _margin_recharge_content()
	{
		$payment_methods = M('Config')->getPlatformPayMethod();
		
		//最低充值额度
		$recharge_min_amount = option('credit.cash_min_amount');
		$recharge_min_amount = is_numeric($recharge_min_amount) ? intval($recharge_min_amount) : 0;


		$this->assign('payment_methods', $payment_methods);
		$this->assign('recharge_min_amount', number_format($recharge_min_amount, 2, '.', ''));
	}

	//充值二维码
	public function margin_recharge_qrcode() {
		$order_no = $_POST['order_no'];
		if (empty($order_no)) {
			json_return(1000, '缺少参数');
		}
		$where = array();
		$where['order_no'] = $order_no;
		$where['store_id'] = $this->store_session['store_id'];
		
		$i = 0;
		while(true) {
			$platform_margin_log = D('Platform_margin_log')->where($where)->find();
			if (empty($platform_margin_log)) {
				json_return(1000, '未找到相应的订单');
			}
			if ($platform_margin_log['status'] == 2) {
				json_return(0, '支付完成');
			}
			
			$i++;
			if ($i >= 5) {
				json_return(10, '重新请求');
			}
			
			sleep(1);
		}
	}

	//支付回调
	public function margin_recharge_callback()
	{
		$payment_method = !empty($_REQUEST['pay_type']) ? $_REQUEST['pay_type'] : '';
		$payment_methods = M('Config')->get_pay_method();
		$payConfig = $payment_methods['allinpay']['config'];
		foreach($payConfig as $key_config => $item_config){
			$count_arrs = explode(',', $item_config);
			if(count($count_arrs)>1){
				$payConfig[$key_config] = $count_arrs[1];
			}else{
				$payConfig[$key_config] = $count_arrs[0];
			}
		}
		$pay_config['pay_allinpay_merchantid']  = $payConfig['pay_allinpay_merchantid'];
		$pay_config['pay_allinpay_merchantkey'] = $payConfig['pay_allinpay_merchantkey'];
		
		
		if (IS_POST) {
			if (strtolower($payment_method) == 'allinpay') {
				import('source.class.pay.Allinpay');
				$payClass = new Allinpay(array(), $pay_config, array(), 0);
				$payInfo = $payClass->return_url();
				$status = 2; //已处理

				if ($payInfo['err_code'] == 0) {
					Margin::init($this->store_session['store_id']);
					Margin::recharge($payInfo['order_param']['order_no'], $payInfo['order_param']['third_id'], $payInfo['order_param']['pay_money'], $payInfo['order_param']['pay_type'], $status);
				}
			}
		}
		if ($payInfo['err_code'] == 0) {
			redirect(url('margin_recharge') . '#success');
		} else {
			redirect(url('margin_recharge') . '#faild');
		}
	}

	//平台保证金流水
	public function margin_details()
	{
		$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
		$this->assign('type', $type);

		$this->display();
	}

	private function _margin_details_content()
	{
		$margin_log = M('Platform_margin_log');
		import('source.class.user_page');

		$types = $margin_log->getTypes();
		$status = $margin_log->getStatus();

		$where = array();
		$where['store_id'] = $this->store_session['store_id'];
		if (isset($_POST['type']) && is_numeric($_POST['type'])) {
			$where['type'] = intval($_POST['type']);
		}
		if (!empty($_POST['payment_method']) && $_POST['payment_method'] != '*') {
			$where['payment_method'] = $_POST['payment_method'];
		}
		if (!empty($_POST['start_time']) && !empty($_POST['stop_time'])) {
			$where['_string'] = "add_time >= '" . strtotime(trim($_POST['start_time'])) . "' AND add_time <= '" . strtotime(trim($_POST['stop_time'])) . "'";
		} else if (!empty($_POST['start_time'])) {
			$where['_string'] = "add_time >= '" . strtotime(trim($_POST['start_time'])) . "'";
		} else if (!empty($_POST['stop_time'])) {
			$where['_string'] = "add_time <= '" . strtotime(trim($_POST['stop_time'])) . "'";
		}
		if (!empty($_POST['order_no'])) {
			if (!empty($where['_string'])) {
				$where['_string'] .= "(order_no like '%" . trim($_POST['order_no']) . "%' OR trade_no like '%" . trim($_POST['order_no']) . "%')";
			} else {
				$where['_string'] = "(order_no like '%" . trim($_POST['order_no']) . "%' OR trade_no like '%" . trim($_POST['order_no']) . "%')";;
			}
		}
		$margin_log_count = $margin_log->getLogCount($where);
		$page = new Page($margin_log_count, 20);
		$margin_logs = $margin_log->getLogs($where, 'pigcms_id DESC', $page->firstRow, $page->listRows);

		//支付方式
		$payment_methods = M('Config')->getPlatformPayMethod(false, false);

		$this->assign('payment_methods', $payment_methods);
		$this->assign('types', $types);
		$this->assign('status', $status);
		$this->assign('margin_logs', $margin_logs);
		$this->assign('page', $page->show());
	}

	//店铺积分流水
	public function point_details()
	{
		$this->display();
	}

	private function _point_details_content()
	{
		$point_log = M('Store_point_log');
		import('source.class.user_page');

		$types = $point_log->getTypes();
		$status = $point_log->getStatus();
		$channels = $point_log->getChannels();

		$where = array();
		$where['store_id'] = $this->store_session['store_id'];
		if (!empty($_POST['order_no'])) {
			$where['order_no'] = trim($_POST['order_no']);
		}
		if (isset($_POST['type']) && is_numeric($_POST['type'])) {
			$where['type'] = intval($_POST['type']);
		}
		if (isset($_POST['channel']) && is_numeric($_POST['channel'])) {
			$where['channel'] = intval($_POST['channel']);
		}
		if (!empty($_POST['start_time']) && !empty($_POST['stop_time'])) {
			$where['_string'] = "add_time >= '" . strtotime(trim($_POST['start_time'])) . "' AND add_time <= '" . strtotime(trim($_POST['stop_time'])) . "'";
		} else if (!empty($_POST['start_time'])) {
			$where['_string'] = "add_time >= '" . strtotime(trim($_POST['start_time'])) . "'";
		} else if (!empty($_POST['stop_time'])) {
			$where['_string'] = "add_time <= '" . strtotime(trim($_POST['stop_time'])) . "'";
		}
		$point_log_count = $point_log->getLogCount($where);
		$page = new Page($point_log_count, 20);
		$point_logs = $point_log->getLogs($where, 'pigcms_id DESC', $page->firstRow, $page->listRows);

		$this->assign('types', $types);
		$this->assign('status', $status);
		$this->assign('channels', $channels);
		$this->assign('point_logs', $point_logs);
		$this->assign('page', $page->show());
	}

	//店铺积分兑换金额
	public function point_exchange()
	{
		if (IS_POST) {

			$store = D('Store')->field('point_balance,sales_ratio')->where(array('store_id' => $this->store_session['store_id']))->find();

			//计算提现金额
			if (strtolower($_POST['type']) == 'calculate') {
				$point = !empty($_POST['point']) ? floatval(trim($_POST['point'])) : 0;
				$sync_withdrawal = !empty($_POST['sync_withdrawal']) ? intval(trim($_POST['sync_withdrawal'])) : 0;

				//平台服务费
				$service_fee = option('credit.storecredit_to_money_charges');
				$service_fee = !empty($service_fee) ? $service_fee / 100 : 0;
				//积分兑换率
				$exchange_rate = option('credit.platform_credit_use_value');
				$exchange_rate = !empty($exchange_rate) ? $exchange_rate : 1;
				//提现服务费
				
				$sales_ratio = ($store['sales_ratio'] > 0)?$store['sales_ratio']:option('config.sales_ratio');

				//$sales_ratio = option('config.sales_ratio');
				$sales_ratio = !empty($sales_ratio) ? $sales_ratio / 100 : 0;
				//金额
				$money = 0;
				if ($point > 0) {
					$money = ($point * (1 - $service_fee) * (1 / $exchange_rate));
				} else {
					$money = 0;
				}
				//提现服务费
				if ($sync_withdrawal) {
					$money *= (1 - $sales_ratio);
				}
				echo number_format($money, 2, '.', '');
				exit;
			}

			import('source.class.Margin');

			$point = !empty($_POST['point']) ? floatval(trim($_POST['point'])) : 0;
			$sync_withdrawal = !empty($_POST['sync_withdrawal']) ? intval(trim($_POST['sync_withdrawal'])) : 0;
			$target = !empty($_POST['target']) ? intval(trim($_POST['target'])) : 0;

			//$store = D('Store')->field('point_balance')->where(array('store_id' => $this->store_session['store_id']))->find();


			if (empty($point) || $point <= 0) {
				json_return(1001, '兑换积分填写有误');
			}
			if ($point > $store['point_balance']) {
				json_return(1002, '可兑换积分余额不足');
			}

			if (empty($target)) {
				Margin::init($this->store_session['store_id']);
				Margin::store_point_log(0 - $point, 1, 2, '积分变现', 0, '', '', 0, false, true, $sync_withdrawal);
				json_return(0, '积分兑换成功');
			} else {
				Margin::init($this->store_session['store_id']);
				Margin::store_point_log(0 - $point, 1, 5, '兑换用户积分', 0, '', '', 0, false, true);
				json_return(0, '店铺积分兑换用户积分成功');
			}
		}
		$this->display();
	}

	private function _point_exchange_content()
	{
		$bank = D('Bank');
		$store = D('Store')->field('point_balance,point2money,point2user,bank_id,bank_card,bank_card_user,opening_bank,sales_ratio')->where(array('store_id' => $this->store_session['store_id']))->find();
		$store['point2money'] = number_format($store['point2money'], 2, '.', '');
		$store['point_balance'] = number_format($store['point_balance'], 2, '.', '');

		//平台服务费
		$service_fee = option('credit.storecredit_to_money_charges');
		$service_fee = !empty($service_fee) ? $service_fee : 0;
		//积分兑换率
		$exchange_rate = option('credit.platform_credit_use_value');
		$exchange_rate = !empty($exchange_rate) ? $exchange_rate : 1;

		//提现信息
		$sync_withdrawal = true;
		if (empty($store['bank_id']) || empty($store['bank_card']) || empty($store['bank_card_user'])) {
			$sync_withdrawal = false;
		}
		$bank_info = $bank->where(array('bank_id' => $store['bank_id']))->find();
		$store['bank'] = !empty($bank_info['name']) ? $bank_info['name'] : '';
		
		
		//$store['sales_ratio'] = option('config.sales_ratio');
		
		$store['sales_ratio'] = ($store['sales_ratio'] > 0)?$store['sales_ratio']:option('config.sales_ratio');

		if (!empty($store['sales_ratio'])) {
			$store['sales_ratio'] = number_format($store['sales_ratio'], 2, '.', '');
		}

		$this->assign('store', $store);
		$this->assign('service_fee', number_format($service_fee, 2, '.', ''));
		$this->assign('exchange_rate', $exchange_rate);
		$this->assign('sync_withdrawal', $sync_withdrawal);
	}


	private function _dividends_mx_content(){
		
		$dividends_send_log = M('Dividends_send_log');
		
		$where = array();
		$where['sl.supplier_id'] = $this->store_session['store_id'];
		if (!empty($_POST['store'])) {
			$where['s.name'] = trim($_POST['store']);
		}
		if (!empty($_POST['type'])) {
			$where['sl.dividends_type'] = trim($_POST['type']);
		}
		
		if (!empty($_POST['start_time']) && !empty($_POST['stop_time'])) {
            $start_time = strtotime($_POST['start_time']);
            $stop_time  = strtotime($_POST['stop_time']);
            $where['_string'] = "add_time >= " . $start_time . " AND add_time <= " . $stop_time;
        } else if (!empty($_POST['start_time'])) {
            $start_time = strtotime($_POST['start_time']);
            $where['add_time'] = array('>=', $start_time);
        } else if (!empty($_POST['stop_time'])) {
            $stop_time = strtotime($_POST['stop_time']);
            $where['add_time'] = array('<=', $stop_time);
        }

		
		$record_total = $dividends_send_log->getLogCount($where);

		import('source.class.user_page');
		$page = new Page($record_total, 20);
		
		$records = $dividends_send_log->getLogs($where, $page->firstRow, $page->listRows);		

		$dividends_type_arr = array(1=>'经销商',2=>'分销团队',3=>'独立分销商');
		
		$this->assign('page', $page->show());
		$this->assign('list', $records);
		$this->assign('dividends_type_arr', $dividends_type_arr);
	}


	//判断当前是否满足发放分红对应的规则

	public function bonus_send_prepare(){
		if(IS_POST){

			import('source.class.Dividends');	

			//1.判断该供货商是否设置了奖励规则

			$store_id =  $_SESSION['store']['store_id'];

			$dividends_rules = Dividends::is_set_rules($store_id);
			
			if(!$dividends_rules){
				json_return(1001,'尚未设置分红规则');
			}

			$is_auto = Dividends::is_auto($store_id);

			if($is_auto){
				json_return(1002,'未设置手动发放规则');
			}

			//2.获取需要发放的对象

			$return_arr = Dividends::get_send_obj($dividends_rules);
			json_return(0,$return_arr);
			
		}else{
			json_return(999,'非法访问！');
		}
	}


	//发放过程(总)
	public function bonus_send(){
		set_time_limit(0);
		usleep(500000);
		if(IS_POST){
		 
			 import('source.class.Dividends');

			 $store_id =  $_SESSION['store']['store_id'];
					
			 $pigcms_id = !empty($_POST['handle_id']) ? intval($_POST['handle_id']) : 0; 

			 if(!$pigcms_id){
				json_return(1001,'未知的规则id');
			 }

			 $status = Dividends::one_send($pigcms_id,$store_id);

		}else{
			json_return(999,'非法访问！');
		}
	}

	//充值返还
	private function _margin_return_content()
	{
		import('source.class.Margin');
		import('source.class.user_page');

		if (!Margin::check()) {
			pigcms_tips('您访问的页面不存在');
		}

		$store_id = $this->store_session['store_id'];
		$status = isset($_REQUEST['status']) ? $_REQUEST['status'] :  1;
		$this->assign('default_status', $status);

		$store = D('Store')->field('store_id,uid,withdrawal_type,bank_id,bank_card,opening_bank,bank_card_user,tel')->where(array('store_id' => $store_id))->find();
		$user = D('User')->field('nickname')->where(array('uid' => $store['uid']))->find();
		$bank = M('Bank')->getBank($store['bank_id']);

		$where = array();
		$where['store_id'] = $store_id;
		$where['type'] = 1;
		if ($status > 0) {
			$where['status'] = $status;
		}
		if (!empty($_POST['start_time']) && !empty($_POST['stop_time'])) {
			$where['_string'] = "add_time >= '" . strtotime(trim($_POST['start_time'])) . "' AND add_time <= '" . strtotime(trim($_POST['stop_time'])) . "'";
		} else if (!empty($_POST['start_time'])) {
			$where['add_time'] = array('<=', strtotime(trim($_POST['start_time'])));
		} else if (!empty($_POST['stop_time'])) {
			$where['add_time'] = array('>=', strtotime(trim($_POST['stop_time'])));
		}
		$margin_return_count = D('Platform_margin_log')->where($where)->count('pigcms_id');
		$page = new Page($margin_return_count, 15);
		$margin_returns = D('Platform_margin_log')->where($where)->order('pigcms_id DESC')->limit($page->firstRow . ',' . $page->listRows)->select();

		$status = M('Platform_margin_log')->getStatus();

		$this->assign('page', $page->show());
		$this->assign('store', $store);
		$this->assign('user', $user);
		$this->assign('bank', $bank);
		$this->assign('margin_returns', $margin_returns);
		$this->assign('status', $status);
	}
}
?>