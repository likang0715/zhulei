<?php
/**
 * 账号
 * User: pigcms_21
 * Date: 2015/3/3
 * Time: 14:41
 */
class account_controller extends base_controller{
	public function load(){
		$action = strtolower(trim($_POST['page']));
		if (empty($action)) pigcms_tips('非法访问！', 'none');
		switch($action){
			case 'personal_content':
				$this->_personal_content();
				break;
			case 'company_content':
				$this->_company_content();
				break;
			case 'password_content':
				$this->_password_content();
				break;
			case 'buysms_content':
				$this->_buysms_content();
				break;
			case 'sms_record_content':
				$this->_sms_record_content();
				break;
			case 'dobuysms_content':
				$this->_dobuysms_content();
				break;	
			case 'smsorder_edit':
				$this->_smsorder_edit();
				break;
			default:
				break;
		}
		$this->display($action);
	}
	
	private function _smsorder_edit() {

		$order_sms = M('Order_sms');
		$time = time();
		
		if($_POST['do_sms_amount']) {
		//修改	
			$user = M('User');
			$sms_order_id = $_GET['sms_order_id'];
			$sms_amount = $_POST['do_sms_amount'];
			$user = $user->getUserById($this->user_session['uid']);
			
			if(empty($sms_order_id) || ($sms_amount<1000)) {
				
				json_return("1","参数出错或未达到最低购买量！");
			}
			if(!$this->user_session['uid']){
				json_return("2","未登录");
			}
			$wheres = array('sms_order_id' => $sms_order_id);
			$order_sms = $order_sms->getOne($wheres);			
			if($time-$order_sms['dateline']>86400) {
				//大于一天不予购买
				json_return("4","亲！这个短信购买订单已经过期啦！");
			}
			
			$where = array(
				'uid' => $this->user_session['uid'],
				'sms_order_id' => $sms_order_id,
				'status'=> '0'		
			);
			$money = $order_sms['sms_price']*$sms_amount*1/100;
			$data = array(
				'sms_num' => $sms_amount,
				'money' => 	$money	
			);
			$result = D('Order_sms')->data($data)->where($where)->save();
			if(false !== $result) {
				//$aa =  D('Order_sms')->last_sql;
				json_return("0","修改成功");
			} else {
				json_return("3","修改失败");
			}
			
			
		} else {
		//显示

			$smspay_no = $_POST['sms_no'];
	
			$where = array('smspay_no' => $smspay_no);
			$order_sms = $order_sms->getOne($where);
			
			if($order_sms['status'] == '1') {		
				redirect(url('account:sms_record'));
			}
			
			$this->assign('order_sms',$order_sms);
		}
		//$this->display();
	}	
	
	
	//购买记录
	public function sms_record() {
		$user = M('User');
		$user = $user->getUserById($this->user_session['uid']);
		
		$this->assign("user",$user);
		$this->display();
	}
	
	//短信购买检测
	public function smsorder_check() {
		
		$order_sms = M('Order_sms');
		$sms_order_id = $_REQUEST['sms_order_id'] + 0;

		if(!$sms_order_id) {return;}
		
		$order_sms = $order_sms -> getOne(array('sms_order_id'=>$sms_order_id));
		if($order_sms['status'] == '1') {
			json_return(0, 'ok');	//已支付
		} else {
			json_return(1, '未支付');
		}		
		
	}
	
	
	public function smsorder_detail() {
		$order_sms = M('Order_sms');
		$sms_order_id = $_REQUEST['sms_order_id'] + 0;
		if(!$sms_order_id) {return;}
		
		$order_sms = $order_sms -> getOne(array('sms_order_id'=>$sms_order_id));
		
		$user = M('User');
		$user = $user->getUserById($this->user_session['uid']);
		
		$this->assign("user",$user);	

		//dump($user);
		
		$this->display();
			
		
	}

	public function smsorder_detail_post() {
		$order_sms = M('Order_sms');

		$sms_order_id = $_REQUEST['sms_order_id'] + 0;
		if (!$sms_order_id) pigcms_tips('非法访问！', 'none');
		if(IS_POST){
			$order_sms = $order_sms -> getOne(array('sms_order_id'=>$sms_order_id));
			$user = M('User');
			$user = $user->getUserById($this->user_session['uid']);
			$this->assign("user",$user);	

			//dump($user);
			json_return(0, $order_sms);
			// $this->display();
		}else{
			pigcms_tips('非法访问！', 'none');
		}
		
	}

	
	//购买短信 show
	public function buysms(){
		$sms_price = option('config.sms_price');
		$sms_sign = option('config.sms_sign');
		$sms_key = option('config.sms_key');
		$sms_topdomain = option('config.sms_topdomain');
		$sms_open = option('config.sms_open');
		
		if(!is_numeric($sms_price) || !$sms_sign || !$sms_key || !$sms_topdomain || !$sms_open)	{
			if(IS_POST) {
				json_return(3,'平台尚未开启短信操作！');
			}else {
				pigcms_tips('平台尚未开启短信操作！');
			}
		}
		
		if(IS_POST) {
			
			if(empty($this->user_session)) {
				json_return(1,'请登陆后操作！');
			}

			if (empty($_POST['type']) || empty($_POST['t'])) {
				json_return(1,'请求类型错误！');
			}
			
			//检测是否有未过期的订单，有则返回
			$unpay_count = M('Order_sms')->check_unpay_order($this->user_session['uid']);
			
			// if($unpay_count!='0') {
			// 	json_return(1,'亲，还有未支付的购买订单，请优先处理！');
			// }

			if ($_POST['type']==1) {
				$data['sms_amount']= 1000;
				$sms_count_price = 80;
				$sms_price_new = 8;
			}elseif ($_POST['type']==2) {
				$data['sms_amount']= 6000;
				$sms_count_price = 360;
				$sms_price_new = 6;
			}elseif ($_POST['type']==3) {
				$data['sms_amount']= 10000;
				$sms_count_price = 500;
				$sms_price_new = 5;
			}else{
				json_return(1,'充值类型错误！');
			}
			
			$order_no = 'SMS_' . date('YmdHis') . mt_rand(100000,999999);

			// 产生未支付的短信订单
			$data_order = array(
				'dateline' => time(),
				'smspay_no' => $order_no,
				'uid' => $this->user_session['uid'],
				'money' => $sms_count_price,
				// 未启用平台设置短信价格
				// 'sms_price'=> $sms_price,
				'sms_price'=> $sms_price_new,
				'sms_num' => $data['sms_amount'],
			);
			
			$sms_order_id = D('Order_sms')->data($data_order)->add();	
			
			if(empty($sms_order_id)){
				//echo D('Order_sms')->last_sql;
				json_return(4,'订单产生失败，请重试！');
			}
			$this->_pay($data_order,$data['sms_amount'],array('weixin'));
			//json_return(0, '设置成功');
			$return_data['order_no'] =$order_no;
			$return_data['order_id'] =$sms_order_id;
			json_return(0,$return_data);
			
		} else {
			$user = M('User');
			if(empty($this->user_session)) redirect('./user.php');
			
			// $create_store_status = true;
			// $user = $user->getUserById($this->user_session['uid']);
	
			// $this->assign('sms_price',$sms_price);
			// $this->assign('user',$user);
			// $this->display();
			pigcms_tips('非法访问！', 'none');
		}	
	}	
	
	

	
	/*@param: sms_amount 购买短信条数
	 *@param: 选择的支付类型  string  
	 *@author: simon  
	 */
	private function _pay($data,$sms_amount,$payType="" ) {
		$user = M('User')->getUserById($this->user_session['uid']);
		if($sms_amount < 1000) {
			$return = array('msg'=>'购买条数不够','code'=>'5');
			return $return;	
		} 
		
		if(is_array($payType) || count($payType)=='0') {
			$return = array('msg'=>'支付类型选择错误','code'=>'6');
			return $return;
		}
		
		$payMethodList = M('Config')->get_pay_method();
		if (empty($payMethodList[$payType])) {
			json_return(1012, '您选择的支付方式不存在<br/>请更新支付方式');
		}
		
		
		$nowOrder['order_no_txt'] = option('config.orderid_prefix') . $nowOrder['order_no'];
		
		$nowOrder = array(
				'order_no_txt' => option('config.orderid_prefix') . $data['smspay_no'],
				'trade_no' => $data['smspay_no'],
				'total' => $data['money']
				
		);
		
		switch($payType) {
			//微信支付
			case 'weixin':
					import('source.class.pay.Weixin');
					//支付入平台				
					$openid = $_SESSION['openid'];
					
					$payClass = new Weixin($nowOrder, $payMethodList[$payType]['config'], $user, $openid);
					$payInfo = $payClass->pay();
					if ($payInfo['err_code']) {
						return '242';
						json_return(1013, $payInfo['err_msg']);
					} else {
						return '111';
						json_return(0, json_decode($payInfo['pay_data']));
					}
				break;
			
			default:
					$return = array('msg'=>'支付类型选择错误','code'=>'5');
					return $return;
				break;
		}
		
		
	}
	
	
	//购买的内容内容页面
	private function _buysms_content(){
	
			$user = M('User')->getUserById($this->user_session['uid']);
			$sms_price = option('config.sms_price');
			$sms_sign = option('config.sms_sign');
			$sms_key = option('config.sms_key');
			$sms_topdomain = option('config.sms_topdomain');
				
			$this->assign('sms_price',$sms_price);
			$this->assign('user', $user);				
	}
	
	
	private function _sms_record_content() {
		$page = $_REQUEST['p'] + 0;
		$page = max(1, $page);
		$limit = 5;
		$order_sms_model = M('Order_sms');
				
		$user = M('User')->getUserById($this->user_session['uid']);
		$sms_price = option('config.sms_price');
		$sms_sign = option('config.sms_sign');
		$sms_key = option('config.sms_key');
		$sms_topdomain = option('config.sms_topdomain');
		
		
		//查询账户购买记录
		$where = array(
			'uid' => $this->user_session['uid']
		);
		
		$count = $order_sms_model->getSmsTotal($where);
		
		if($count > 0) {
			$page = min($page, ceil($count / $limit));
			$offset = ($page - 1) * $limit;
			$order_by = "sms_order_id desc";	
			$sms_list = $order_sms_model->getsmsList($where,$order_by,$limit,$offset);
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();			
		}
		
		
		$this->assign('pages', $pages);
		//dump($sms_list);
		$this->assign('sms_list', $sms_list);		
		
		$this->assign('sms_price',$sms_price);
		$this->assign('user', $user);
	}
	
	
	
	public function dobuysms() {
		$order_no = $_GET['order_no'];

		if (empty($order_no)) {
			pigcms_tips('缺少最基本的参数');
		}
		$sms_order = D('Order_sms')->where(array('smspay_no'=>$order_no))->find();
		if (empty($sms_order)) {
				pigcms_tips('未找到要付款的订单');
		}
		if ($sms_order['status'] == 1 ) {
			pigcms_tips('此订单无需支付');
		}
		
		$user = M('User');
		$user = $user->getUserById($this->user_session['uid']);
		
		$this->assign("user",$user);
		
		$this->assign('sms_order', $sms_order);
		$this->display();
	}
	
	
	//二维码购买的内容内容页面
	private function _dobuysms_content(){
	
		$user = M('User')->getUserById($this->user_session['uid']);
		$sms_price = option('config.sms_price');
		$sms_sign = option('config.sms_sign');
		$sms_key = option('config.sms_key');
		$sms_topdomain = option('config.sms_topdomain');

		$this->assign('order', $order);
		$this->assign('sms_price',$sms_price);
		$this->assign('user', $user);
	
	}
	

	//个人资料
	public function personal(){
		if(IS_POST){
			$data = array();
			$data['nickname'] = isset($_POST['nickname']) ? trim($_POST['nickname']) : '';
			$data['avatar'] = isset($_POST['avatar']) ? trim($_POST['avatar']) : '';
			$data['intro'] = isset($_POST['intro']) ? trim($_POST['intro']) : '';

			M('User')->save_user(array('uid' => $this->user_session['uid']), $data);
            $_SESSION['user']['nickname'] = $data['nickname'];
			json_return(0, '设置成功');
		}else{
			if(empty($this->store_session)){
				$condition_store['uid'] = $this->user_session['uid'];
				$store = D('Store')->where($condition_store)->order('`store_id` DESC')->find();
				if($store){
					if(empty($store['logo'])) $store['logo'] = 'default_shop_2.jpg';
					$_SESSION['store'] = $store;
				}else{
					pigcms_tips('您需要先创建一个店铺',url('store:select'));
				}
			}
		}
		$this->display();
	}

	//个人资料详细
	private function _personal_content(){
		$user = M('User')->getUserById($this->user_session['uid']);
		$this->assign('user', $user);
	}

	//公司信息
	public function company(){
		if (IS_POST) {
			$company = M('Company');
			$data = array();
			$data['name']     = isset($_POST['name']) ? trim($_POST['name']) : '';
			$data['province'] = isset($_POST['province']) ? trim($_POST['province']) : '';
			$data['city']     = isset($_POST['city']) ? trim($_POST['city']) : '';
			$data['area']     = isset($_POST['area']) ? trim($_POST['area']) : '';
			$data['address']  = isset($_POST['address']) ? trim($_POST['address']) : '';

			$where = array();
			$where['uid'] = $this->user_session['uid'];
            $company_info = $company->get($where['uid']);
            if (!empty($company_info)) {
                $result = $company->edit($where, $data);
            } else {
                $data['uid'] = $this->user_session['uid'];
                $result = $company->create($data);
                if (!empty($result['err_code'])) {
                    $result = true;
                } else {
                    $result = false;
                }
            }
			if ($result) {
				json_return(0, '公司修改成功');
			} else {
				json_return(1001, '公司修改失败');
			}
		}

		$user = M('User');
		$avatar = $user->getAvatarById($this->user_session['uid']);

		$this->assign('avatar', $avatar);
		$this->display();
	}

	//公司信息设置
	private function _company_content(){
		$company = M('Company');

		$company = $company->getCompanyByUid($this->user_session['uid']);

		$this->assign('company', $company);
	}

	//密码
	public function password(){
		if (IS_POST) {
			$user = M('User');

			$old_password = isset($_POST['old_password']) ? trim($_POST['old_password']) : '';
			$new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';

			$user_info = $user->getUserById($this->user_session['uid']);
			if (empty($old_password) || empty($new_password) || $user_info['password'] != md5($old_password)) {
				json_return(1001, '修改失败');
			} else {
				if ($user->setField(array('uid' => $this->user_session['uid']), array('password' => md5($new_password)))) {
					unset($_SESSION['user']);
					session_destroy();
					json_return(0, '修改成功');
				} else {
					json_return(1001, '修改失败');
				}
			}
		}
		$this->display();
	}

	//密码修改
	private function _password_content() {

	}

	//密码检测
	public function check_password(){
		$user = M('User');

		$password = isset($_POST['password']) ? trim($_POST['password']) : '';

		if (!empty($password)) {
			$user = $user->getUserById($this->user_session['uid']);
			if ($user['password'] == md5($password)) {
				json_return(0, '密码正确');
			} else {
				json_return(1001, '密码有误');
			}
	   } else {
			json_return(1001, '密码有误');
		}
	}
}