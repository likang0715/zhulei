<?php

/**
 * 账号
 * User: pigcms_21
 * Date: 2015/3/3
 * Time: 14:41
 */
class account_controller extends base_controller {

	public function __construct() {
		parent::__construct();
		$user = M('User')->getUserById($this->user_session['uid']);
		$user['last_ip']=  long2ip($user['last_ip']);

		
		if (option('credit.platform_credit_open')) {

			//用户今天新增平台积分
			$today_user_point = D('User_point_log')->where(array('uid' => $user['uid'],'type'=>array('in',array(0,2,3,4,6)), 'status' => 1,'add_date'=>date('Ymd')))->sum('point');
			$today_user_point = ($today_user_point > 0) ? $today_user_point : 0;
			$user['today_user_point'] = number_format($today_user_point, 2, '.', '');

			//今日新增可用平台积分(用户)
			$where = array();
			$where['uid'] = $user['uid'];
			$where['add_date'] = date('Ymd');
			$today_point_balance = D('Release_point_log')->where($where)->sum('point');
			$today_point_balance = ($today_point_balance > 0) ? $today_point_balance : 0;
			$user['today_point_balance'] = number_format($today_point_balance, 2, '.', '');

		}


		$this->assign('user', $user);

		// 加载ucenter配置
		if(option('config.ucenter_setting')){
			define('UC_DBHOST', option('config.ucenter_dbhost'));			// UCenter 数据库主机
			define('UC_DBUSER', option('config.ucenter_dbuser'));				// UCenter 数据库用户名
			define('UC_DBPW', option('config.ucenter_pwd'));					// UCenter 数据库密码
			define('UC_DBNAME', option('config.ucenter_dbname'));				// UCenter 数据库名称
			define('UC_DBCHARSET', option('config.ucenter_dbcharset'));				// UCenter 数据库字符集
			define('UC_DBTABLEPRE', option('config.ucenter_dbtablepre'));			// UCenter 数据库表前缀

			define('UC_DBCONNECT', '0');

			//通信相关
			define('UC_KEY', option('config.ucenter_key'));				// 与 UCenter 的通信密钥, 要与 UCenter 保持一致
			define('UC_API', option('config.ucenter_api'));	// UCenter 的 URL 地址, 在调用头像时依赖此常量
			define('UC_CHARSET', option('config.ucenter_charset'));				// UCenter 的字符集
			define('UC_IP', option('config.ucenter_dbip'));					// UCenter 的 IP, 当 UC_CONNECT 为非 mysql 方式时, 并且当前应用服务器解析域名有问题时, 请设置此值
			define('UC_APPID', option('config.ucenter_appid'));					// 当前应用的 ID
			define('UC_PPP', '20');

			$dbhost = option('config.ucenter_dbhost');			// 数据库服务器
			$dbuser = option('config.ucenter_dbuser');			// 数据库用户名
			$dbpw = option('config.ucenter_pwd');				// 数据库密码
			$dbname = option('config.ucenter_dbname');			// 数据库名
			$pconnect = 0;				// 数据库持久连接 0=关闭, 1=打开
			$tablepre = option('config.ucenter_dbtablepre');   		// 表名前缀, 同一数据库安装多个论坛请修改此处
			$dbcharset = option('config.ucenter_dbcharset');	

			include_once PIGCMS_PATH.'include/db_mysql.class.php';
			$db = new dbstuff;
			$db->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
			unset($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
			include_once PIGCMS_PATH.'uc_client/client.php';
		}



	}
	
	
	/**
	 * 检测用户是否已经注册
	 */
	public function checkuser() {
		if($this->is_used_sms == '1') {
		if($_POST['is_ajax'] == 1) {
			
			$mobile = trim($_POST['mobile']);
			
			if(empty($mobile)) {
				echo json_encode(array('status' => '3', 'msg' => '手机号为空！'));
				exit;
			}
			
			if (!preg_match("/^1[3|5|7|8|9]{1}[0-9]{9}$/i", $mobile)) {
				echo json_encode(array('status' => '2', 'msg' => '该手机号不正确！'));
				exit;
			}
			
			//图形验证码
			if (($_SESSION ['verify'] != md5 ( $_POST['verify'] )) || !$_SESSION['verify'] ) {
				echo json_encode ( array ('status' => '5','msg' => '验证码填写错误！' ) );
				exit();
			}
						
			$user = D('User')->where(array('phone'=>$mobile))->find();
			if($user) {
				echo json_encode(array('status' => '1', 'msg' => '对不起该手机号已存在！'));
				exit;
			}
		}
		
		//验证ip 最多10条
		$ip_long = ip2long(get_client_ip());
		$now_date_time = strtotime("Y-m-d");
		$counts = D('Sms_by_code')->where("type=reg and (mobile = '".$mobile."' or last_ip = '".$ip_long."') and timestamp > ".$now_date_time)->field("count(id) counts")->find();

		if($counts['counts'] >= 10) {
			echo json_encode(array('status' => '5', 'msg' => '对不起您的手机号今日发送已达上限！！'));
			exit;
		}
		
		$record_sms = D('Sms_by_code')->where(array('mobile' => $mobile, 'type' => 'reg'))->order("id desc")->limit(1)->find();
		if(time() - $record_sms['timestamp']<=300) {
		
			echo json_encode(array('status' => '4','code'=>$record_sms['code'] , 'msg' => '短信验证码已发送至手机，请及时操作！'));exit;
		}
		
		
			//发送验证码
			$return = M('Sms_by_code')->send($mobile,'reg');
			if($return['code_return']=='0') {
				echo json_encode(array('status' => '0','code'=>$record_sms['code'] , 'msg' => '该手机号可以注册'));
				exit;
			} else {
				switch($return['code_return']) {
					case '4085':
							echo json_encode(array('status' => '4085','msg' => '该手机号验证码短信每天只能发五个！'));exit;
						break;
					case '4084':
							echo json_encode(array('status' => '4084','msg' => '该手机号验证码短信每天只能发四个！'));exit;
						break;
					case '4030':
							echo json_encode(array('status' => '4030','msg' => ' 手机号码已被列入黑名单 ！'));exit;
						break;
					case '408':
							echo json_encode(array('status' => '408','msg' => '您的帐户疑被恶意利用，已被自动冻结，如有疑问请与客服联系！'));exit;
						break;
					default:
							echo json_encode(array('status' => '9999','code'=> $return['code_return'],'msg' => '该手机号操作异常！'));exit;
						break;
							
				}
			
			}
		} else {
			echo json_encode(array('status' => '9998','msg' => '系统未开启短信功能'));exit;
		}	
		
		}
		

	/**
	 * 会员帐号首页
	 */
	function index() {
		if (empty($this->user_session)) {
			$referer = url('account:index');
			redirect(url('account:login', array('referer' => $referer)));
			exit;
		}

		if (IS_POST) {
			$data = array();
			// 有上传图片时进行图片处理
			if (!empty($_FILES['file']) && $_FILES['file']['error'] != 4) {
				$img_path_str = '';
				
				// 会员店铺侧用的是商铺的id,作为目录，此处如果没有店铺id,则用会员uid
				if (isset($this->store_session['store_id'])) {
					$img_path_str = sprintf("%09d", $this->store_session['store_id']);
				} else {
					$img_path_str = sprintf("%09d", $this->user_session['uid']);
				}
				
				// 产生目录结构
				$rand_num = 'images/' . substr($img_path_str, 0, 3) . '/' . substr($img_path_str, 3, 3) . '/' . substr($img_path_str, 6, 3) . '/' . date('Ym', $_SERVER['REQUEST_TIME']) . '/';

				$upload_dir = './upload/' . $rand_num;
				if (!is_dir($upload_dir)) {
					mkdir($upload_dir, 0777, true);
				}
				
				// 进行上传图片处理
				import('UploadFile');
				$upload = new UploadFile();
				$upload->maxSize = 1 * 1024 * 1024;
				$upload->allowExts = array('jpg', 'jpeg', 'png', 'gif');
				$upload->allowTypes = array('image/png', 'image/jpg', 'image/jpeg', 'image/gif');
				$upload->savePath = $upload_dir;
				$upload->saveRule = 'uniqid';
				if ($upload->upload()) {
					$uploadList = $upload->getUploadFileInfo();
					$add_result = $this->attachment_add($uploadList[0]['name'], $rand_num . $uploadList[0]['savename'], $uploadList[0]['size']);
					if ($add_result['err_code']) {
						unlink($upload_dir . $uploadList[0]['name']);
					} else {
						$data['avatar'] = $rand_num . $uploadList[0]['savename'];

						$attachment_upload_type = option('config.attachment_upload_type');
						// 上传到又拍云服务器
						if ($attachment_upload_type == '1') {
							import('source.class.upload.upyunUser');
							upyunUser::upload('./upload/' . $data['avatar'], '/' . $rand_num . $uploadList[0]['savename']);
						}
					}
				}
			}

			$nickname = $_POST['nickname'];

			if (empty($nickname)) {
				echo json_encode(array('status' => false, 'msg' => '请填写昵称'));
				exit;
			}

			$data['nickname'] = $nickname;
			$data['intro'] = $_POST['intro'];
			M('User')->save_user(array('uid' => $this->user_session['uid']), $data);
			
			// 更新session数据
			$_SESSION['user']['nickname'] = $nickname;
			$_SESSION['user']['intro'] = $_POST['intro'];
			if (!empty($data['avatar'])) {
				$_SESSION['user']['avatar'] = getAttachmentUrl($data['avatar']);
			}
			

			echo json_encode(array('status' => true, 'msg' => '操作完成', 'data' => array('nexturl' => 'refresh')));
			exit;
		}

		//$user = M('User')->getUserById($this->user_session['uid']);
		//$this->assign('user', $user);
		$this->display();
	}

	/**
	 * 订单管理
	 */
	function order() {
		if (empty($this->user_session)) {
			$referer = url('account:order');
			redirect(url('account:login', array('referer' => $referer)));
			exit;	
		}

		// 基本参数设定
		$page = max(1, $_GET['page']);
		$limit = 10;

		// 实例化模型
		$order_model = M('Order');

		// 获取订单总数
		$count = $order_model->getOrderTotal(array('uid' => $this->user_session['uid'], 'user_order_id' => '0'));

		// 修正页码
		$total_pages = ceil($count / $limit);
		$page = min($page, $total_pages);
		$offset = ($page - 1) * $limit;

		$order_list = array();
		$pages = '';
		if ($count > 0) {
			$order_list = $order_model->getOrders(array('uid' => $this->user_session['uid'], 'user_order_id' => '0'), 'order_id desc, status asc', $offset, $limit);

			// 将相应的产品放到订单数组里
			foreach ($order_list as &$order) {
				$order_product_list = M('Order_product')->orderProduct($order['order_id']);
				$order['product_list'] = $order_product_list;
			}

			import('source.class.user_page');

			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}

		// 分配变量并显示模板
		$this->assign('order_list', $order_list);
		$this->assign('pages', $pages);
		$this->display();
	}

	/**
	 * 取消订单
	 */
	function cancl_order() {
		if (empty($this->user_session)) {
			echo json_encode(array('status' => true, 'msg' => '请先登录', 'data' => array('nexturl' => 'refresh')));
			exit;
		}

		$order_id = $_GET['order_id'];

		if (empty($order_id)) {
			echo json_encode(array('status' => false, 'msg' => '参数错误'));
			exit;
		}

		// 实例化order_model
		$order_model = M('Order');
		$order = $order_model->find($order_id);

		// 权限判断是否可以取消订单
		if ($order['uid'] != $this->user_session['uid']) {
			echo json_encode(array('status' => false, 'msg' => '您无权操作'));
			exit;
		}

		if ($order['status'] > 1) {
			echo json_encode(array('status' => false, 'msg' => '此订单不能取消'));
			exit;
		}

		// 更改订单状态
		$order_model->cancelOrder($order);

		echo json_encode(array('status' => true, 'msg' => '订单取消完成', 'data' => array('nexturl' => 'refresh')));
		exit;
	}

	/**
	 * 更改密码
	 */
	function password() {
		if (empty($this->user_session)) {
			$referer = url('account:password');
			redirect(url('account:login', array('referer' => $referer)));
			exit;
		}

		// post，进行更改密码
		if (IS_POST) {
			$old_password = $_POST['old_password'];
			$password1 = $_POST['password1'];
			$password2 = $_POST['password2'];

			// 实例化user_model
			$user_model = M('User');

			$user = $user_model->getUserById($_SESSION['user']['uid']);

			// 判断原密码是否正确
			if ($user['password'] != md5($old_password)) {
				echo json_encode(array('status' => false, 'msg' => '原密码不正确'));
				exit;
			}

			if ($password1 != $password2) {
				echo json_encode(array('status' => false, 'msg' => '两次新密码不一样'));
				exit;
			}

			$user_model->save_user(array('uid' => $_SESSION['user']['uid']), array('password' => md5($password1)));


			echo json_encode(array('status' => true, 'msg' => '修改成功', 'data' => array('nexturl' => 'refresh')));
			exit;
		}

		$this->display();
	}

	/**
	 * 收货地址
	 */
	function address() {
		if (empty($this->user_session)) {
			$referer = url('account:address');
			redirect(url('account:login', array('referer' => $referer)));
			exit;
		}

		// 实例化user_address_model
		$user_address_model = M('User_address');

		// 添加新收货地址
		if (IS_POST) {
			$name = $_POST['name'];
			$tel = $_POST['tel'];
			$province = $_POST['province'];
			$city = $_POST['city'];
			$area = $_POST['area'];
			$address = $_POST['address'];
			$default = $_POST['default'] + 0;

			if (empty($name)) {
				echo json_encode(array('status' => false, 'msg' => '收货人没有填写'));
				exit;
			}

			if (empty($tel) || !preg_match("/1[3458]{1}\d{9}$/", $tel)) {
				echo json_encode(array('status' => false, 'msg' => '手机号码格式不正确'));
				exit;
			}

			if (empty($province)) {
				echo json_encode(array('status' => false, 'msg' => '省份没有选择'));
				exit;
			}

			if (empty($city)) {
				echo json_encode(array('status' => false, 'msg' => '城市没有选择'));
				exit;
			}

			if (empty($area)) {
				echo json_encode(array('status' => false, 'msg' => '地区没有选择'));
				exit;
			}

			if (empty($address)) {
				echo json_encode(array('status' => false, 'msg' => '街道没有填写'));
				exit;
			}


			// 更新数据库操作，当有address_id时做更新操作，没有时做添加操作
			$data = array();
			$data['uid'] = $this->user_session['uid'];
			$data['name'] = $name;
			$data['tel'] = $tel;
			$data['province'] = $province;
			$data['city'] = $city;
			$data['area'] = $area;
			$data['address'] = $address;
			$data['default'] = $default;

			$address_id = $_POST['address_id'];
			$msg = '添加成功';
			if (!empty($address_id)) {
				$msg = '修改成功';
				// 更改记录条件
				$condition = array();
				$condition['uid'] = $this->user_session['uid'];
				$condition['address_id'] = $address_id;

				$user_address_model->save_address($condition, $data);
			} else {
				$data['add_time'] = time();
				$address_id = $user_address_model->add($data);
			}


			// 设置默认收货地址
			if ($default == 1) {
				$user_address_model->canelDefaultAaddress($this->user_session['uid'], $address_id);
			}


			import('area');
			$areaClass = new area();

			$data['province_txt'] = $areaClass->get_name($data['province']);
			$data['city_txt'] = $areaClass->get_name($data['city']);
			$data['area_txt'] = $areaClass->get_name($data['area']);
			$data['address_id'] = $address_id;

			echo json_encode(array('status' => true, 'msg' => $msg, 'data' => array('nexturl' => 'refresh', 'address' => $data)));
			exit;
		}



		$address_list = $user_address_model->getMyAddress($this->user_session['uid']);
		$this->assign('address_list', $address_list);
		$this->display();
	}


	public function point_give() {
		//服务费
		$give_point_service_fee = option('credit.give_point_service_fee');

		$this->assign('give_point_service_fee', $give_point_service_fee);

		$this->display();
	}

	public function point_log(){
		if (empty($this->user_session)) {
			$referer = url('account:point_log');
			redirect(url('account:login', array('referer' => $referer)));
			exit;	
		}

		// 基本参数设定
		$page = max(1, $_GET['page']);
		$limit = 10;

		
		//$where['_string'] =$this->user_session['uid'];
		$where['_string'] = " upl.uid = " . $this->user_session['uid'] . "";
		$count_where['_string'] = " uid = " . $this->user_session['uid'] . "";

		//获取搜索条件

		$dosearch = trim($_REQUEST['dosearch']);
		
		if(!empty($dosearch)){

			if (!empty($_REQUEST['order_no'])) {
				$order_no = trim($_REQUEST['order_no']);
				$where['_string'] .= " AND upl.order_no = ('" . $order_no . "')";
				$count_where['_string'] .= " AND order_no = ('" . $order_no . "')";
			}

			//类型
			if (isset($_REQUEST['type']) && $_REQUEST['type'] != '*') {
				$type = trim($_REQUEST['type']);
				$where['_string'] .= " AND upl.type IN (" . $type . ")";	
				$count_where['_string'] .= " AND type IN (" . $type . ")";	
			}

			if (!empty($_REQUEST['stime']) && !empty($_REQUEST['etime'])) {
	            $start_time = strtotime($_REQUEST['stime']);
	            $stop_time  = strtotime($_REQUEST['etime']);
	            $where['_string'] .= " AND upl.add_time >= " . $start_time . " AND upl.add_time <= " . $stop_time;
	            $count_where['_string'] .= " AND add_time >= " . $start_time . " AND add_time <= " . $stop_time;
	        } else if (!empty($_REQUEST['stime'])) {
	            $start_time = strtotime($_REQUEST['stime']);  
	            $where['_string'] .= " AND upl.add_time >= " . $start_time;
	            $count_where['_string'] .= " AND add_time >= " . $start_time;
	        } else if (!empty($_REQUEST['etime'])) {
	            $stop_time = strtotime($_REQUEST['etime']);
	            $where['_string'] .= " AND upl.add_time <= " . $stop_time;
	            $count_where['_string'] .= " AND add_time <= " . $stop_time;
	        }

		}
		
		
		// 获取总数	

		$count = D('User_point_log')->where($count_where)->count('pigcms_id');


		// 修正页码
		$total_pages = ceil($count / $limit);
		$page = min($page, $total_pages);
		$offset = ($page - 1) * $limit;

		$log_list = array();
		$pages = '';
		if ($count > 0) {

			//$log_list = D('User_point_log')-> where($where)-> limit($limit)->order('pigcms_id DESC')-> select();

			$log_list = D('') -> table('User_point_log upl')
			-> join("Store s On upl.store_id = s.store_id","LEFT")
			-> where($where)
			-> field("upl.*,s.name")
			-> order('upl.pigcms_id DESC')
			-> limit($offset.','.$limit)
			-> select();

		

			import('source.class.user_page');

			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}

		$point_type_arr = array(
				'消费获赠积分',
				'消费抵现积分',
				'退货返还积分',
				'取消订单返还积分',
				'商家积分转可用积分',
				'积分赠他人',
				'他人赠积分',
				'平台发放积分',
			);


		// 分配变量并显示模板
		$this->assign('log_list', $log_list);
		$this->assign('is_point_log', 1);
		$this->assign('pages', $pages);
		$this->assign('point_type_arr', $point_type_arr);
		$this->display();
	}

	public function point_give_ajax(){
		
		import('source.class.Margin');

		$check_give_point = Margin::check_give_point();
		
		//服务费
		$give_point_service_fee = option('credit.give_point_service_fee');

		//扫码场景
		$scan_qrcode_scenario = strtonumber(option('config.site_url') . '/card');


		if(IS_AJAX){


			//搜索用户
			if ($_POST['type'] == 'search_user') {
				$phone = !empty($_POST['phone']) ? trim($_POST['phone']) : '';
				$uid = !empty($_POST['uid']) ? trim($_POST['uid']) : 0;
				if (empty($phone) && empty($uid)) {
					json_return(1001, '请先使用手机号选择获赠用户');
				}
				if (!empty($phone)) {
					$where['phone'] = $phone;
				}
				if (!empty($uid)) {
					if ($_POST['card'] != 1 && $_POST['card'] != 2) {
						json_return(1005, '扫一扫只能扫描用户的会员卡的条形码或二维码');
					}
					if ($scan_qrcode_scenario != $_POST['scene']) {
						json_return(1006, '扫码场景有误，请扫描本站其它用户的会员卡');
					}
					$where['uid'] = $uid;
				}
				$user = D('User')->field('uid,nickname,phone,point_unbalance')->where($where)->order('uid DESC')->find();
				if (empty($user)) {
					json_return(1002, '选择的获赠用户不存在');
				}
				//赠送与获赠是同一用户
				if ($user['uid'] == $this->user_session['uid']) {
					json_return(1003, '无效获赠用户');
				}

				json_return(0, $user);

			} else if ($_POST['type'] == 'give_point') { //赠送积分
				$give_uid = !empty($_POST['give_uid']) ? intval(trim($_POST['give_uid'])) : 0;
				$give_point = !empty($_POST['give_point']) ? floatval(trim($_POST['give_point'])) : 0;
				$get_user = !empty($_POST['get_user']) ? $_POST['get_user'] : '';
				$card = !empty($_POST['card']) ? $_POST['card'] : '';
				$scene = !empty($_POST['scene']) ? $_POST['scene'] : '';

				if (empty($give_uid)) {
					json_return(1001, '请先使用手机号选择获赠用户');
				}
				if ($get_user == 'scan') {
					if ($card != 1 && $card != 2) {
						json_return(1007, '扫一扫只能扫描用户的会员卡的条形码或二维码');
					}
					if ($scan_qrcode_scenario != $scene) {
						json_return(1008, '扫码场景有误，请扫描本站其它用户的会员卡');
					}
				}
				//获赠用户
				$give_user = D('User')->field('uid,nickname,point_balance,point_unbalance')->where(array('uid' => $give_uid))->find();
				if (empty($give_user)) {
					json_return(1002, '选择的获赠用户不存在');
				}
				//赠送与获赠是同一用户
				if ($give_user['uid'] == $this->user_session['uid']) {
					json_return(1003, '无效获赠用户');
				}



				if ($give_point > $this->user_session['point_unbalance']) {
					json_return(1006, '可赠送的消费积分不足');
				}

				if ($give_point < 0) {
					json_return(1007, '赠送数值不能为负数');
				}


				// 检查获获赠用户现有平台积分是否大于限赠额
				if (option('credit.platform_credit_open') && option('config.user_point_total') > 0 && $give_user['point_balance'] + $give_user['point_unbalance'] >= option('config.user_point_total')) {
					json_return(1000, '获赠用户的积分过多，暂停赠送');
				}
				
				//用户名
				$give_user['nickname'] = !empty($give_user['nickname']) ? $give_user['nickname'] : '他人';
				$this->user_session['nickname'] = !empty($this->user_session['nickname']) ? $this->user_session['nickname'] : '他人';
				//计算服务费
				$give_point_service_fee = $give_point * ($give_point_service_fee / 100);
				$give_point_service_fee = number_format($give_point_service_fee, 2, '.', '');
				//实际赠送积分
				$real_give_point = $give_point - $give_point_service_fee;
				$real_give_point = number_format($real_give_point, 2, '.', '');

				//更新用户积分池剩余
				Margin::user_point_log($this->user_session['uid'], 0, 0, (0 - $give_point), 1, 5, '赠' . $give_user['nickname'] . '积分', 0, '', false, false, true, false, true, false);
				Margin::user_point_log($give_uid, 0, 0, $real_give_point, 1, 6, $this->user_session['nickname'] . '赠积分', 0, '', true, false, true, false, false, true);
				//更新平台积分收入
				if ($give_point_service_fee > 0) {
					Margin::platform_point_log($give_point_service_fee, 1, 2, '积分互赠服务费', 0, 0, '', true);
				}

				json_return(0, '我的消费积分已赠送成功');
			}

			json_return(1005, '缺少访问参数');
		

		}


	}

	/**
	 * 设置默认收货地址
	 */
	function default_address() {
		if (empty($this->user_session)) {
			echo json_encode(array('status' => true, 'msg' => '请先登录', 'data' => array('nexturl' => 'refresh')));
			exit;
		}

		$id = $_GET['id'];

		M('User_address')->canelDefaultAaddress($this->user_session['uid'], $id);

		echo json_encode(array('status' => true, 'msg' => '设置完成', 'data' => array('nexturl' => 'refresh')));
		exit;
	}

	/**
	 * 删除收货地址
	 */
	function delete_address() {
		if (empty($this->user_session)) {
			echo json_encode(array('status' => true, 'msg' => '请先登录', 'data' => array('nexturl' => 'refresh')));
			exit;
		}
		$id = $_GET['id'];

		M('User_address')->deleteAddress(array('address_id' => $id, 'uid' => $this->user_session['uid']));

		echo json_encode(array('status' => true, 'msg' => '删除完成', 'data' => array('nexturl' => 'refresh')));
		exit;
	}

	/**
	 * 登录页面
	 */
	function login() {
		if (!empty($this->user_session)) {
			$referer = $_GET['referer'] ? urldecode($_GET['referer']) : ($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : $this->config['site_url']);
			redirect($referer);
		}


		// 登录处理
		if (IS_POST) {
			
			$username = $_POST['phone'];
			$password = $_POST['password'];
			$email = time().rand(1,99).'@sia.com';

			$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
			$password = isset($_POST['password']) ? trim($_POST['password']) : '';
			$referer = isset($_REQUEST['referer']) ? trim($_REQUEST['referer']) : '';

			if (empty($phone) || empty($password)) {
				echo json_encode(array('status' => false, 'msg' => '手机号或密码不能为空'));
				exit;
			}

			$data = array();
			$data['phone'] = $phone;
			$data['password'] = md5($password);

			$user = D('User')->where($data)->find();

			if (empty($user)) {
				echo json_encode(array('status' => false, 'msg' => '手机号或密码错误'));
				exit;
			}
			if($user['status']!=1) {
				echo json_encode(array('status' => false, 'msg' => '该账户已被禁止登陆！'));
				exit;
			}
			// 如果开启到ucenter中登录
			if(option('config.ucenter_setting')){
				// 到ucenter中验证用户
				list($uid, $username, $password, $email) = uc_user_login($username, $password);
				if($uid <= 0){
					pigcms_tips('用户不存在');
				}
				$ucsynlogin = uc_user_synlogin($uid);
				$referer = '/index.php';
				//echo $ucsynlogin.'<script>window.location.href="'.$referer.'";</script>';
				//exit;
				echo json_encode(array('status' => true, 'msg' => '登录成功', 'data' => array('nexturl' => $referer),'ucsynlogin'=>$ucsynlogin.'<script>window.location.href="'.$referer.'";</script>'));
				exit;
			}
			// 否则使用本地登录功能
			// 设置登录成功session
			$_SESSION['user'] = $user;


			$database_user = M('User');
			$save_result = $database_user->save_user(array('uid' => $user['uid']), array('login_count' => $user['login_count'] + 1, 'last_time' => $_SERVER['REQUEST_TIME'], 'last_ip' => ip2long(get_client_ip())));
			if ($save_result['err_code'] < 0) {
				json_encode(array('status' => false, 'msg' => '系统内部错误！请重试'));
			}
			if ($save_result['err_code'] > 0) {
				json_encode(array('status' => false, 'msg' => $save_result['err_msg']));
			}

			if (empty($referer)) {
				$referer = option('config.site_url');
			}
			unset($_SESSION['forget_info']);
			echo json_encode(array('status' => true, 'msg' => '登录成功', 'data' => array('nexturl' => $referer)));
			exit;
		}

		$referer = $_GET['referer'] ? urldecode($_GET['referer']) : ($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : $this->config['site_url']);
		$this->assign('referer', $referer);

		// 判断是否已经登录，登录就进入主页
		/**/

		
		  // 分配变量
		  $adver = M('adver');
		  $ad = $adver->get_adver_by_key('pc_login_pic', 1);		  
		  $this->assign('ad', $ad['0']);
			

		$this->assign('type', 'login');
                if($_GET['type'] == 'zc'){
                    $this->display('zclogin');
                }  else {
                    $this->display();
                }
		
	}

	/**
	 * ajax login
	 */
	function ajax_login() {
		if (IS_POST) {
			$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
			$password = isset($_POST['password']) ? trim($_POST['password']) : '';

			if (empty($phone) || empty($password)) {
				echo json_encode(array('status' => false, 'msg' => '手机号或密码不能为空'));
				exit;
			}

			$data = array();
			$data['phone'] = $phone;
			$data['password'] = md5($password);

			$user = D('User')->where($data)->find();

			if (empty($user)) {
				echo json_encode(array('status' => false, 'msg' => '手机号或密码错误'));
				exit;
			}

			// 设置登录成功session
			$_SESSION['user'] = $user;
			//登录后的地理位置存入cookie
			//$long = "117.22895";
			//$lat = "31.866208";



			$database_user = M('User');
			$save_result = $database_user->save_user(array('uid' => $user['uid']), array('login_count' => $user['login_count'] + 1, 'last_time' => $_SERVER['REQUEST_TIME'], 'last_ip' => ip2long(get_client_ip())));
			if ($save_result['err_code'] < 0) {
				json_encode(array('status' => false, 'msg' => '系统内部错误！请重试'));
			}
			if ($save_result['err_code'] > 0) {
				json_encode(array('status' => false, 'msg' => $save_result['err_msg']));
			}
			
			unset($_SESSION['forget_info']);
			echo json_encode(array('status' => true, 'msg' => '登录成功', 'data' => array('nickname' => $user['nickname'])));
			exit;
		}

		echo json_encode(array('status' => false, 'msg' => ''));
	}

	/**
	 * 注册页面
	 */
	function register() {
		if (!empty($this->user_session)) {
			$referer = $_GET['referer'] ? urldecode($_GET['referer']) : ($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : $this->config['site_url']);
			redirect($referer);
		}
		
		

		// 提交注册
		if (IS_POST) {
			// 实例化user_model
			$user_model = M('User');
			$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
			$nickname = isset($_POST['nickname']) ? trim($_POST['nickname']) : '';
			$password = isset($_POST['password']) ? $_POST['password'] : '';
			$code = isset($_POST['code']) ? $_POST['code'] : '';

			if (empty($phone) || empty($nickname) || empty($password)) {
				echo json_encode(array('status' => false, 'msg' => '请完整填写注册信息'));
				exit;
			}
			if (($_SESSION ['verify'] != md5 ( $_POST['verify'] )) || !$_SESSION['verify'] ) {
				echo json_encode ( array ('status' => 'false','msg' => '验证码填写错误！' ) );
				exit();
			}
			// 注册暂时不使用注册码
			if($this->is_used_sms == '1') {
				//检测验证码是否正确 300秒
				$record_sms = D('Sms_by_code')->where(array('mobile'=>$phone,'timestamp'=>array('>',time()-300)))->order("id desc")->limit(1)->find();
				if(empty($code)) {
					echo json_encode(array('status' => false, 'msg' => '请正确填写手机验证码！'));
					exit;
				}
				
				if (trim($code) != $record_sms['code']) {
					echo json_encode(array('status' => false, 'msg' =>  '手机验证码错误或过期！'));
					exit;
				}
			}	
			
			if ($user_model->checkUser(array('phone' => $phone))) {
				echo json_encode(array('status' => false, 'msg' => '此手机号已经注册了'));
				exit;
			}
			

			/* if ($user_model->checkUser(array('nickname' => $nickname))) {
			  echo json_encode(array('status' => false, 'msg' => '此昵称已经注册了'));
			  exit;
			  } */
			if(option('config.ucenter_setting')){
				$email = time().rand(1,99).'@sia.com';
				$uid = uc_user_register($phone, $password, $email);
				if($uid <= 0){
					echo json_encode(array('status' => false, 'msg' => '注册失败'));
					exit;
				}
			}




			$data = array();
			$data['nickname'] = $nickname;
			$data['phone'] = $phone;
			$data['password'] = md5($password);

			$user = $user_model->add_user($data);

			if ($user['err_code'] != 0) {
				echo json_encode(array('status' => false, 'msg' => '注册失败'));
				exit;
			}

			$user = $user_model->getUserById($user['err_msg']['uid']);
			$_SESSION['user'] = $user;
			unset($_SESSION['forget_info']);
			echo json_encode(array('status' => true, 'msg' => '注册成功', 'data' => array('nexturl' => option('config.site_url'))));
			exit;
		}

		$referer = $_GET['referer'] ? urldecode($_GET['referer']) : ($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : $this->config['site_url']);
		$this->assign('referer', $referer);

		//读取广告图
        $adver = M('adver');
        $ad = $adver->get_adver_by_key('pc_login_pic', 1);
        $this->assign('ad', $ad['0']);

		$mobile = $_COOKIE['reg_mobile'] ? $_COOKIE['reg_mobile'] : '';
		
		$record_sms = D('Sms_by_code')->where(array('mobile'=>$mobile))->order("id desc")->limit(1)->find();

		$this->assign('type', 'register');
		$this->assign('sms_register', $record_sms);
		$this->display('login');
	}
	
	
	//手机号注册 ajax检测
	public function ajax_register_check() {
			
			
			// 实例化user_model
			$user_model = M('User');
			$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
			$nickname = isset($_POST['nickname']) ? trim($_POST['nickname']) : '';
			$password = isset($_POST['password']) ? $_POST['password'] : '';
			$code = isset($_POST['code']) ? $_POST['code'] : '';

			if (empty($phone) || empty($nickname) || empty($password)) {
				echo json_encode(array('status' => false,'code'=>1000, 'msg' => '请完整填写注册信息'));
				exit;
			}

			if ($user_model->checkUser(array('phone' => $phone))) {
				echo json_encode(array('status' => false,'code'=>1001, 'msg' => '此手机号已经注册了'));
				exit;
			}
			
			// 注册暂时不使用注册码
			if($this->is_used_sms == '1') {
				//检测验证码是否正确 300秒
				$record_sms = D('Sms_by_code')->where(array('mobile'=>$phone,'timestamp'=>array('>',time()-300)))->order("id desc")->limit(1)->find();
				if(empty($code)) {
					echo json_encode(array('status' => false,'code'=>1002, 'msg' => '请正确填写手机验证码！'));
					exit;
				}
				
				if (trim($code) != $record_sms['code']) {
					echo json_encode(array('status' => false,'code'=>1003, 'msg' =>  '手机验证码错误或过期！'));
					exit;
				}
			}
			echo json_encode(array('status' => true, 'msg' =>  '验证通过！'));
	}

	/**
	 * 用户退出登录
	 */
	function logout() {
		unset($_SESSION['user']);
		//清除cookie
		setcookie("Web_user","",time()-3600);
		$referer = $_SERVER['HTTP_REFERER'];
		if (empty($referer)) {
			$referer = url('index:index');
		}
		if(option('config.ucenter_setting')){
			$res = uc_user_synlogout();
			echo $res.'<script>window.location.href="'.$referer.'";</script>';
			exit;
		}
		redirect($referer);
	}
	


	/**
	 * 插入会员素材图片
	 */
	public function attachment_add($name, $file, $size, $from = 0, $type = 0) {
		$data['uid'] = $this->user_session['uid'];
		$data['name'] = $name;
		$data['from'] = $from;
		$data['type'] = $type;
		$data['file'] = $file;
		$data['size'] = $size;
		$data['add_time'] = $_SERVER['REQUEST_TIME'];
		$data['ip'] = get_client_ip(1);
		$data['agent'] = $_SERVER['HTTP_USER_AGENT'];

		if ($type == 0) {
			list($data['width'], $data['height']) = getimagesize('./upload/' . $file);
		}
		if ($pigcms_id = D('Attachment_user')->data($data)->add()) {
			return array('err_code' => 0, 'pigcms_id' => $pigcms_id);
		} else {
			return array('err_code' => 1001, 'err_msg' => '图片添加失败！请重试');
		}
	}

	//收藏店铺
	public function collect_store() {
		if (empty($this->user_session)) {
			$referer = url('account:collect_store');
			redirect(url('account:login', array('referer' => $referer)));
			exit;
		}

		// 基本参数设定
		$page = max(1, $_GET['page']);
		$limit = 20;

		$count = D('')->table(array('User_collect' => 'uc', 'Store' => 's'))->where("`uc`.`type` = '2' AND `uc`.`user_id` = '" . $this->user_session['uid'] . "' AND `uc`.`dataid` = `s`.`store_id`")->count("`uc`.`collect_id`");

		$store_list = array();
		$pages = '';
		if ($count > 0) {
			$total_pages = ceil($count / $limit);
			$page = min($page, $total_pages);
			$offset = ($page - 1) * $limit;


			$store_list = D('')->table(array('User_collect' => 'uc', 'Store' => 's'))->where("`uc`.`type` = '2' AND `uc`.`user_id` = '" . $this->user_session['uid'] . "' AND `uc`.`dataid` = `s`.`store_id`")->order("`uc`.`collect_id` DESC")->limit($offset . ',' . $limit)->select();
			foreach ($store_list as &$store) {
				if (empty($store['logo'])) {
					$store['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
				} else {
					$store['logo'] = getAttachmentUrl($store['logo']);
				}
			}

			// 分页
			import('source.class.user_page');

			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}

		$this->assign('store_list', $store_list);
		$this->assign('pages', $pages);
		$this->display();
	}

	//收藏的商品
	public function collect_goods() {
		if (empty($this->user_session)) {
			$referer = url('account:collect_goods');
			redirect(url('account:login', array('referer' => $referer)));
			exit;
		}

		// 基本参数设定
		$page = max(1, $_GET['page']);
		$limit = 20;

		//$count = D('User_collect')->where(array('type' => 1, 'user_id' => $this->user_session['uid']))->count('collect_id');
		$count = D('')->table(array('User_collect' => 'uc', 'Product' => 'p'))->where("`uc`.`type` = '1' AND `uc`.`user_id` = '" . $this->user_session['uid'] . "' AND `uc`.`dataid` = `p`.`product_id`")->count("`uc`.`collect_id`");

		$product_list = array();
		$pages = '';
		if ($count > 0) {
			$total_pages = ceil($count / $limit);
			$page = min($page, $total_pages);
			$offset = ($page - 1) * $limit;


			$product_list = D('')->table(array('User_collect' => 'uc', 'Product' => 'p'))->where("`uc`.`type` = '1' AND `uc`.`user_id` = '" . $this->user_session['uid'] . "' AND `uc`.`dataid` = `p`.`product_id`")->order("`uc`.`collect_id` DESC")->limit($offset . ',' . $limit)->select();

			foreach ($product_list as &$product) {
				$product['image'] = getAttachmentUrl($product['image']);
			}
			// 分页
			import('source.class.user_page');

			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}


		$this->assign('product_list', $product_list);
		$this->assign('pages', $pages);
		$this->display();
	}

	//用户优惠券
	public function coupon() {
		if (empty($this->user_session)) {
			$referer = url('account:coupon');
			redirect(url('account:login', array('referer' => $referer)));
			exit;
		}	
		$page = max(1, $_GET['page']);
		$type = $_GET['type'];
		$order = $_GET['order'];
		$sort = $_GET['sort'];
		$coupon_type = $_GET['coupon_type'];
		$limit = 10;
		$time = time();
		$keyword = $_GET['keyword'];
		$param_search = array();
		$param_search['keyword'] = $keyword;

		//券的不同状态  (未使用，已使用，已过期, 全部)
		$type_arr = array('not_used', 'used', 'expired', 'all');
		if (!in_array($type, $type_arr)) {
			$type = 'not_used';
		}
		$coupon_type_arr = array('0', '1', '2');  //0代表全部类型
		if (!in_array($coupon_type, $coupon_type_arr)) {
			$coupon_type = '0';
		}
		// 默认url条件
		$param['type'] = $type;
		$param['order'] = $order;
		$param['sort'] = $sort;
		$param['coupon_type'] = $coupon_type;


		// 修正排序
		$order_arr = array('end_time', 'face_money');
		$sort_arr = array('desc', 'asc');

		if (!in_array($order, $order_arr)) {
			$order = 'end_time';
		}

		if (!in_array($sort, $sort_arr)) {
			$sort = 'asc';
		}
		// 更改下次排序
		$sort = $sort == 'asc' ? 'desc' : 'asc';

		unset($where);

		switch ($type) {
			case 'not_used':
				$where['is_use'] = 0;
				$where['end_time'] = array('>', $time);
				break;

			case 'used':
				$where['is_use'] = 1;
				break;

			case 'expired':
				$where['is_use'] = 0;
				$where['end_time'] = array('<', $time);
				break;

			default:

				break;
		}
		if ($coupon_type == '0') {
			
		} else {

			$where['type'] = $coupon_type;
		}
		$where['delete_flg'] = '0';
		$where['uid'] = $this->user_session['uid'];
		$where['is_valid'] = '1';

		// 过期时间
		$param_expired_time = $param;
		$param_expired_time['order'] = 'end_time';
		$param_expired_time['sort'] = $sort;
		$param_expired_time['type'] = $type;
		//优惠金额
		$param_money = $param;
		$param_money['order'] = 'face_money';
		$param_money['sort'] = $sort;
		$param_money['type'] = $type;

		//当前搜索的
		// 排序
		$search_param = $param;

		$count = D('User_coupon')->where($where)->count('id');

		$order_by = $order . ' ' . $sort;

		$pages = '';
		$total_pages = 0;
		if ($count > 0) {
			$total_pages = ceil($count / $limit);
			$page = min($page, $total_pages);
			$offset = ($page - 1) * $limit;

			$coupon_list = M('User_coupon')->getList($where, $order_by, $limit, $offset);
			$store_id_list = array();
			foreach ($coupon_list as $coupon) {
				$store_id_list[$coupon['store_id']] = $coupon['store_id'];
			}
			$store_list = M('Store')->getStoreName($store_id_list);
			// 分页
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}

		$this->assign('type', $type);
		$this->assign('coupon_list', $coupon_list);
		$this->assign('store_list', $store_list);
		$this->assign('coupon_type', $coupon_type);  //优惠券类型
		$this->assign('order', $order);
		$this->assign('pages', $pages);
		$this->assign('page_arr', array('current_page' => $page, 'total_pages' => $total_pages));
		$this->assign('param_end_time', $param_expired_time);
		$this->assign('param_money', $param_money);
		$this->assign('search_param', $search_param);
		$this->display();
	}

	//用户优惠券对应的产品list
	function productbycoupon() {
		$id = $_GET['id'];
		$page = max(1, $_GET['page']);
		$limit = 15;
		$coupon_to_prodcut = M("Coupon_to_product");
		if (empty($this->user_session)) {
			$referer = url('account:index');
			redirect(url('account:login', array('referer' => $referer)));
			exit;
		}
		if (empty($id)) {
			echo json_encode(array('status' => false, 'msg' => '参数错误'));
			exit;
		}

		//获取用户领取的优惠券信息
		$where = array('id' => $id, 'delete_flg' => 0);
		$coupon_detail = M('User_coupon')->getOneCouponInfo($where);
		$store_id_list[$coupon_detail['store_id']] = $coupon_detail['store_id'];
		$store_list = M('Store')->getStoreName($store_id_list);
		$store_name = $store_list[$coupon_detail['store_id']];
		if (!$coupon_detail['id']) {
			$referer = $_GET['referer'] ? urldecode($_GET['referer']) : ($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : $this->config['site_url']);
			redirect($referer);
		}
		$product = M('Product');
		//只显示自己名下 且数量大 的非分销商品
		unset($where);
		//dump($coupon_detail);
		if ($coupon_detail['is_all_product'] == '0') {
			//全店通用（自营商品）

			$where['quantity'] = array('>', 0);
			$where['store_id'] = $coupon_detail['store_id'];
			$where['supplier_id'] = 0;
			//商品数量
			$count = $product->getSellingTotal($where);
			if ($count > 0) {
				$order_by_field = "product_id";
				$order_by_method = "desc";
				$total_pages = ceil($count / $limit);
				$page = min($page, $total_pages);
				$offset = ($page - 1) * $limit;

				$product_list = $product->getSelling($where, $order_by_field, $order_by_method, $offset, $limit);
				import('source.class.user_page');
				$user_page = new Page($count, $limit, $page);
				$pages = $user_page->show();
			}
		} else {

			$where = "p.quantity > 0 and p.store_id = '" . $coupon_detail['store_id'] . "' and p.supplier_id = 0 ";
			//商品数量
			$count = $coupon_to_prodcut->getSellingCouponProductTotal($where);

			if ($count > 0) {
				$order_by_field = "p.product_id";
				$order_by_method = "desc";
				$total_pages = ceil($count / $limit);
				$page = min($page, $total_pages);
				$offset = ($page - 1) * $limit;

				$product_list = $coupon_to_prodcut->getSellingCouponProduct($where, $order_by_field, $order_by_method, $offset, $limit);
				import('source.class.user_page');
				$user_page = new Page($count, $limit, $page);
				$pages = $user_page->show();
			}
		}

		$param_search = array('id' => $id);

		$this->assign('store_name', $store_name);
		$this->assign('coupon', $coupon_detail);
		$this->assign('param_search', $param_search);
		$this->assign('product_list', $product_list);
		$this->assign('pages', $pages);
		$this->display();
	}

	//ajax删除用户的优惠券
	function deluserCoupon() {
		$id = $_GET['id'];
		if (empty($this->user_session)) {
			echo json_encode(array('status' => false, 'msg' => '请先登录', 'data' => array('nexturl' => 'refresh')));
			exit;
		}
		if (empty($id)) {
			echo json_encode(array('status' => false, 'msg' => '参数错误'));
			exit;
		}

		$data = array('delete_flg' => 1);
		$where = array(
			'uid' => $this->user_session['uid'],
			'id' => $id
		);
		if (D('User_coupon')->where($where)->data($data)->save()) {
			echo json_encode(array('status' => true, 'msg' => '操作完成', 'data' => array('nexturl' => url("account:coupon"))));
			exit;
		} else {
			echo json_encode(array('status' => false, 'msg' => '删除失败'));
			exit;
		}
	}

	//验证密码
	public function chk_password() {
		if (!IS_AJAX) {
			return false;
		}
		$old_password = $_POST['password'];
		$password = $_SESSION['user']['password'];

		if (md5($old_password) != $password) {
			echo json_encode(array('status' => false, 'msg' => '密码不一致'));
		} else {
			echo json_encode(array('status' => true, 'msg' => '密码一致'));
		}
	}

	public function chk_newpwd() {
		if (!IS_AJAX) {
			return false;
		}
		$password1 = $_POST['password'];
		if (strlen($password1) < 6 || strlen($password1) > 16) {
			echo json_encode(array('status' => false, 'msg' => '密码不能小于六位或大于十六位'));
		} else {
			echo json_encode(array('status' => true, 'msg' => '密码通过'));
		}
	}
	
	
	//关注的店铺
	public function attention_store() {
		
		if (empty($this->user_session)) {
			$referer = url('account:collect_store');
			redirect(url('account:login', array('referer' => $referer)));
			exit;
		}

		// 基本参数设定
		$page = max(1, $_GET['page']);
		$limit = 10;

		$count = D('')->table(array('User_attention' => 'ua', 'Store' => 's'))->where("`ua`.`data_type` = '2' AND `ua`.`user_id` = '" . $this->user_session['uid'] . "' AND `ua`.`data_id` = `s`.`store_id`")->count("`ua`.`id`");
		
		$store_list = array();
		$pages = '';
		
		
		if ($count > 0) {
			$total_pages = ceil($count / $limit);
			$page = min($page, $total_pages);
			$offset = ($page - 1) * $limit;

			$product_model = M('Product');
			$store_list = D('')->table(array('User_attention' => 'ua', 'Store' => 's'))->where("`ua`.`data_type` = '2' AND `ua`.`user_id` = '" . $this->user_session['uid'] . "' AND `ua`.`data_id` = `s`.`store_id`")->order("`ua`.`id` DESC")->limit($offset . ',' . $limit)->select();

			
			
			
			
			foreach ($store_list as &$store) {
				if (empty($store['logo'])) {
					$store['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
				} else {
					$store['logo'] = getAttachmentUrl($store['logo']);
				}
				//每个店铺获取 10个热销商品 10个新品
				// 店铺热销个产品
				$store['hot_list'] = $product_model->getSelling(array('store_id' => $store['store_id'], 'status' => 1), 'sales', 'desc', 0, 9);
				$store['hot_list_count'] = count($store['hot_list']);
				
				/*新品*/
				$store['news_list'] = $product_model->getSelling(array('store_id' => $store['store_id'], 'status' => 1), '', '', 0, 9);
				$store['news_list_count'] = count($store['news_list']);
				
				// 评论满意，一般，不满意数量，以及满意百分比
				$where = array();
				$where['type'] = 'STORE';
				$where['relation_id'] = $store['store_id'];
				$comment_type_count = M('Comment')->getCountList($where);
				$satisfaction_pre = '100%';
				if ($comment_type_count['total'] > 0) {
					$satisfaction_pre = round($comment_type_count['t3'] / $comment_type_count['total'] * 100) . '%';
				}
				$store['satisfaction_pre'] = $satisfaction_pre;				
				
				$store['imUrl'] = getImUrl($_SESSION['user']['uid'],$store['store_id']);
			}
			
			
			// 分页
			import('source.class.user_page');

			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}

		$record_sms = D('Sms_by_code')->where(array('mobile'=>$mobile))->order("id desc")->limit(1)->find();
		
		$this->assign('record_sms', $record_sms);
		$this->assign('store_list', $store_list);
		$this->assign('pages', $pages);
		$this->display();
	}
        
        //关注商品
        public function attention_goods(){
            if (empty($this->user_session)) {
			$referer = url('account:attention_goods');
			redirect(url('account:login', array('referer' => $referer)));
			exit;
		}

		// 基本参数设定
		$page = max(1, $_GET['page']);
		$limit = 20;

		$count = D('')->table(array('User_attention' => 'ua', 'Product' => 'p'))->where("`ua`.`data_type` = '1' AND `ua`.`user_id` = '" . $this->user_session['uid'] . "' AND `ua`.`data_id` = `p`.`product_id`")->count("`ua`.`id`");

		$product_list = array();
		$pages = '';
		if ($count > 0) {
			$total_pages = ceil($count / $limit);
			$page = min($page, $total_pages);
			$offset = ($page - 1) * $limit;


			$product_list = D('')->table(array('User_attention' => 'ua', 'Product' => 'p'))->where("`ua`.`data_type` = '1' AND `ua`.`user_id` = '" . $this->user_session['uid'] . "' AND `ua`.`data_id` = `p`.`product_id`")->order("`ua`.`id` DESC")->limit($offset . ',' . $limit)->select();

			foreach ($product_list as &$product) {
				$product['image'] = getAttachmentUrl($product['image']);
			}
			// 分页
			import('source.class.user_page');

			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}


		$this->assign('product_list', $product_list);
		$this->assign('pages', $pages);
		$this->display();
	}
	
	/**
	 * 确认收货
	 */
	public function delivery_order() {
		if (empty($this->user_session)) {
			echo json_encode(array('status' => true, 'msg' => '请先登录', 'data' => array('nexturl' => 'refresh')));
			exit;
		}
		
		$order_id = $_GET['order_id'];
		
		if (empty($order_id)) {
			echo json_encode(array('status' => false, 'msg' => '参数错误'));
			exit;
		}
		
		// 实例化order_model
		$order_model = M('Order');
		$order = $order_model->find($order_id);
		
		// 权限判断是否可以取消订单
		if ($order['uid'] != $this->user_session['uid']) {
			echo json_encode(array('status' => false, 'msg' => '您无权操作'));
			exit;
		}
		
		if ($order['status'] != 3) {
			echo json_encode(array('status' => false, 'msg' => '订单状态错误'));
			exit;
		}
		
		$data = array();
		$data['status'] = 7;
		$data['delivery_time'] = time();
		$result = D('Order')->where("order_id = '" . $order['order_id'] . "' OR user_order_id = '" . $order['order_id'] . "'")->data($data)->save();
		
		if ($result) {
			D('Order_product')->where("order_id = '" . $order['order_id'] . "' OR user_order_id = '" . $order['order_id'] . "'")->data(array('in_package_status' => 3))->save();
			echo json_encode(array('status' => true, 'msg' => '确认收货成功'));
			exit;
		} else {
			echo json_encode(array('status' => false, 'msg' => '订单状态错误'));
			exit;
		}
	}
	
	/**
	 * 退单列表
	 */
	public function return_order() {
		$page = max(1, $_GET['page']);
		$limit = 10;
		
		$return_model = M('Return');
		$count = $return_model->getCount(array('uid' => $this->user_session['uid'], 'user_return_id' => 0));
		
		$return_list = array();
		$pages = '';
		if ($count > 0) {
			$page = min($page, ceil($count / $limit));
			$offset = ($page - 1) * $limit;
			
			$return_list = M('Return')->getList("r.uid = '" . $this->user_session['uid'] . "' AND r.user_return_id = 0", $offset, $limit);
			
			// 分页
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}
		$this->assign('pages', $pages);
		$this->assign('return_list', $return_list);
		$this->display();
	}
	
	/**
	 * 取消退货
	 */
	public function cancl_return() {
		$id = $_GET['id'];
		if (empty($id)) {
			echo json_encode(array('status' => false, 'msg' => '缺少参数'));
			exit;
		}
		$return = M('Return')->getById($id);
		
		if (empty($return)) {
			echo json_encode(array('status' => false, 'msg' => '未找到相应的退货'));
			exit;
		}
		
		if ($return['uid'] != $this->user_session['uid']) {
			echo json_encode(array('status' => false, 'msg' => '请操作自己的退货申请'));
			exit;
		}
		
		if ($return['status'] >= 4) {
			echo json_encode(array('status' => false, 'msg' => '不能取消退货申请'));
			exit;
		}
		
		$data = array();
		$data['status'] = 6;
		$data['user_cancel_dateline'] = time();
		$result = D('Return')->where("user_return_id = '" . $id . "' or id = '" . $id . "'")->data($data)->save();
		
		if ($result) {
			// 审核不通过更改订单产品表退货状态
			import('source.class.ReturnOrder');
			ReturnOrder::checkReturnStatus($return);
			
			echo json_encode(array('status' => true, 'msg' => '取消退货成功',  'data' => array('nexturl' => 'refresh')));
			exit;
		} else {
			echo json_encode(array('status' => false, 'msg' => '取消退货失败'));
			exit;
		}
	}
	
	/**
	 * 退货订单详情
	 */
	public function return_detail() {
		$id = $_GET['id'];
		$order_no = $_GET['order_no'];
		$pigcms_id = $_GET['pigcms_id'];
		if (empty($id) && (empty($order_no) || empty($pigcms_id))) {
			pigcms_tips('缺少参数！', 'none');
		}
		
		$return = array();
		if (!empty($id)) {
			$return = M('Return')->getById($id);
		} else {
			$order_no = trim($order_no, option('config.orderid_prefix'));
			$where = "r.order_no = '" . $order_no . "' AND rp.order_product_id = '" . $pigcms_id . "'";
			$return_list = M('Return')->getList($where);
			
			if ($return_list) {
				$return = $return_list[0];
			}
		}
		
		if (empty($return)) {
			pigcms_tips('未找到相应的退货！', 'none');
		}
		
		if ($return['uid'] != $this->user_session['uid']) {
			pigcms_tips('请查看自己的退货申请！', 'none');
		}
		
		if ($return['status'] == 3) {
			$express_list = D('Express')->select();
			$this->assign('express_list', $express_list);
		}
		
		$order = M('Order')->findOrderById($return['order_id']);
		
		$store = M('Store')->getStore($order['store_id']);
		// 相关折扣、满减、优惠
		import('source.class.Order');
		$order_data = Order::orderDiscount($order);
		
		$this->assign('return', $return);
		$this->assign('order', $order);
		$this->assign('store', $store);
		$this->assign('order_data', $order_data);
		$this->display();
	}
	
	/**
	 * 添加退货快递信息
	 */
	public function return_express() {
		$id = $_POST['id'];
		$express_code = $_POST['express_code'];
		$express_no = $_POST['express_no'];
		
		if (empty($id) || empty($express_code) || empty($express_no)) {
			echo json_encode(array('status' => false, 'msg' => '缺少参数'));
			exit;
		}
		$return = M('Return')->getById($id);
		
		if (empty($return)) {
			echo json_encode(array('status' => false, 'msg' => '未找到相应的退货'));
			exit;
		}
		
		if ($return['uid'] != $this->user_session['uid']) {
			echo json_encode(array('status' => false, 'msg' => '请操作自己的退货申请'));
			exit;
		}
		
		if ($return['status'] != 3) {
			echo json_encode(array('status' => false, 'msg' => '退货状态不正确'));
			exit;
		}
		
		$express = D('Express')->where("code = '" . $express_code . "'")->find();
		if (empty($express)) {
			echo json_encode(array('status' => false, 'msg' => '未找到相应的快递公司'));
			exit;
		}
		
		
		$data = array();
		$data['status'] = 4;
		$data['shipping_method'] = 'express';
		$data['express_code'] = $express_code;
		$data['express_company'] = $express['name'];
		$data['express_no'] = $express_no;
		$result = D('Return')->where("user_return_id = '" . $id . "' or id = '" . $id . "'")->data($data)->save();
		
		if ($result) {
			echo json_encode(array('status' => true, 'msg' => '操作成功',  'data' => array('nexturl' => 'refresh')));
			exit;
		} else {
			echo json_encode(array('status' => false, 'msg' => '操作失败'));
			exit;
		}
	}
	
	/**
	 * 维权列表
	 */
	public function rights_order() {
		$page = max(1, $_GET['page']);
		$limit = 10;
	
		$rights_model = M('Rights');
		$count = $rights_model->getCount(array('uid' => $this->user_session['uid'], 'user_rights_id' => 0));
	
		$rights_list = array();
		$pages = '';
		if ($count > 0) {
			$page = min($page, ceil($count / $limit));
			$offset = ($page - 1) * $limit;
				
			$rights_list = M('Rights')->getList("r.uid = '" . $this->user_session['uid'] . "' AND r.user_rights_id = 0", $offset, $limit);
				
			// 分页
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}
		
		$this->assign('pages', $pages);
		$this->assign('rights_list', $rights_list);
		$this->display();
	}
	
	/**
	 * 取消维权
	 */
	public function cancl_rights() {
		$id = $_GET['id'];
		if (empty($id)) {
			echo json_encode(array('status' => false, 'msg' => '缺少参数'));
			exit;
		}
		$rights = M('Rights')->getById($id);
	
		if (empty($rights)) {
			echo json_encode(array('status' => false, 'msg' => '未找到相应的维权'));
			exit;
		}
	
		if ($rights['uid'] != $this->user_session['uid']) {
			echo json_encode(array('status' => false, 'msg' => '请操作自己的维权申请'));
			exit;
		}
	
		if ($return['status'] >= 3) {
			echo json_encode(array('status' => false, 'msg' => '不能取消维权申请'));
			exit;
		}
	
		$data = array();
		$data['status'] = 10;
		$data['user_cancel_dateline'] = time();
		$result = D('Rights')->where("user_rights_id = '" . $id . "' or id = '" . $id . "'")->data($data)->save();
	
		if ($result) {
			echo json_encode(array('status' => true, 'msg' => '取消维权成功',  'data' => array('nexturl' => 'refresh')));
			exit;
		} else {
			echo json_encode(array('status' => false, 'msg' => '取消维权失败'));
			exit;
		}
	}
	
	public function rights_detail() {
		$id = $_GET['id'];
		$order_no = $_GET['order_no'];
		$pigcms_id = $_GET['pigcms_id'];
		if (empty($id) && (empty($order_no) || empty($pigcms_id))) {
			pigcms_tips('缺少参数！', 'none');
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
			pigcms_tips('未找到相应的维权！', 'none');
		}
		
		if ($rights['uid'] != $this->user_session['uid']) {
			pigcms_tips('请查看自己的维权申请！', 'none');
		}
	
		$order = M('Order')->findOrderById($rights['order_id']);
		
		$store = M('Store')->getStore($order['store_id']);
		// 相关折扣、满减、优惠
		import('source.class.Order');
		$order_data = Order::orderDiscount($order);
		
		$this->assign('rights', $rights);
		$this->assign('order', $order);
		$this->assign('store', $store);
		$this->assign('order_data', $order_data);
		$this->display();
	}
	
	
	/**
	 * 积分列表
	 */
	public function point() {
		$page = max(1, $_GET['page']);
		$limit = 10;
	
		$user_points_record_model = M('User_points_record');
		$count = $user_points_record_model->getCount(array('uid' => $this->user_session['uid'], 'is_available' => 1));
		

		$rights_list = array();
		$pages = '';
		if ($count > 0) {
			$page = min($page, ceil($count / $limit));
			$offset = ($page - 1) * $limit;

			$orderby = " timestamp desc, id desc ";
			
			$points_record = $user_points_record_model->getUserData($this->user_session['uid'],$limit,$offset,array(),$orderby);

			// 分页
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}
	
		$this->assign('pages', $pages);
		$this->assign('points_record', $points_record);
		$this->display();
	}


	public function readme() {
		$this->display();
	}

    public function forget_password(){

        $this->display();
    }
	
	// 团购
	public function tuan() {
		$type = $_GET['type'];
		$page = max(1, $_GET['page']);
		$limit = 10;
		$offset = ($page - 1) * $limit;
		
		// 条件
		$where = "tt.team_id = o.data_item_id AND tt.tuan_id = t.id AND t.product_id = p.product_id AND o.uid = '" . $this->user_session['uid'] . "' AND o.type = 6 AND (o.status = 2 OR o.status = 3 OR o.status = 4 OR o.status = 6 OR o.status = 7)";
		if ($type == '1') {
			$where .= " AND tt.status = 0";
		} else if ($type == '2') {
			$where .= " AND tt.status = 1";
		} else if ($type == '3') {
			$where .= " AND tt.status = 2";
		}
		
		// 查询表
		$table_arr = array();
		$table_arr['Order'] = 'o';
		$table_arr['Tuan_team'] = 'tt';
		$table_arr['Tuan'] = 't';
		$table_arr['Product'] = 'p';
		
		$count = D('')->table($table_arr)->field($field)->where($where)->count('t.id');
		$order_list = array();
		if ($count > 0) {
			// 所需字段
			$field = "o.order_id, o.order_no, o.total, o.pro_num, o.status as o_status, o.paid_time, o.data_money, tt.team_id, tt.tuan_id, tt.uid, tt.type, tt.item_id, tt.status, t.product_id, p.name, p.image";
			$order_list = D('')->table($table_arr)->field($field)->where($where)->limit($offset . ', ' . $limit)->order('o.order_id DESC')->select();
			
			foreach ($order_list as &$order) {
				if ($order['uid'] == $this->user_session['uid']) {
					$order['is_leader'] = true;
				} else {
					$order['is_leader'] = false;
				}
				$order['order_no'] = option('config.orderid_prefix') . $order['order_no'];
				$order['image'] = getAttachmentUrl($order['image']);
				$order['order_url'] = option('config.wap_site_url') . '/order.php?orderid=' . $order['order_id'];
				$order['tuan_url'] = $url = option('config.site_url') . '/webapp/groupbuy/#/detailinfo/' . $order['tuan_id'] . '/' . $order['type'] . '/' . $order['item_id'] . '/' . $order['team_id'];
			}
			
			// 分页
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
			$this->assign('pages', $pages);
		}
		
		$this->assign('type', $type);
		$this->assign('order_list', $order_list);
		$this->display();
	}

	// 夺宝综合页面
	public function unitary () {

		$this->display();
	}

	// 夺宝加载
	public function unitary_load () {

		$action = strtolower(trim($_POST['page']));
		if (empty($action)) {
			pigcms_tips('非法访问！', 'none');
		}

		switch ($action) {

			case 'unitary_order':
				$this->_unitary_order();
				break;

			case 'unitary_list':
				$this->_unitary_list();
				break;

			default:
				break;
		}

		$this->display($action);

	}

	public function _unitary_order () {

		if (empty($this->user_session)) {
			$referer = url('account:order');
			redirect(url('account:login', array('referer' => $referer)));
			exit;	
		}

		// 基本参数设定
		$page = max(1, $_REQUEST['p']);
		$limit = 10;

		// 实例化模型
		$order_model = M('Order');

		// 获取订单总数
		$count = $order_model->getOrderTotal(array('uid' => $this->user_session['uid'], 'user_order_id' => '0', 'type' => 51));

		// 修正页码
		$total_pages = ceil($count / $limit);
		$page = min($page, $total_pages);
		$offset = ($page - 1) * $limit;

		$order_list = array();
		$pages = '';
		if ($count > 0) {
			$order_list = $order_model->getOrders(array('uid' => $this->user_session['uid'], 'user_order_id' => '0', 'type' => 51), 'order_id desc', $offset, $limit);

			// 将相应的产品放到订单数组里
			foreach ($order_list as &$order) {
				$order_product_list = M('Order_product')->orderProduct($order['order_id']);
				$order['product_list'] = $order_product_list;
			}

			import('source.class.user_page');

			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}

		// 分配变量并显示模板
		$this->assign('order_list', $order_list);
		$this->assign('pages', $pages);

	}

	// 夺宝参与记录列表
	public function _unitary_list () {

		$page = max(1, $_REQUEST['p']);
		$status = isset($_REQUEST['status']) ? trim($_REQUEST['status']) : 'all';

		$time = time();

		$limit = 10;
		$offset = ($page - 1) * $limit;
		$pages = "";

		$where = array();
    	$where[] = " j.uid = ".$this->user_session['uid']." ";

    	switch ($status) {
			case 'ing':
				$where[] = " u.state = 1 ";
				break;

			case 'end':
				$where[] = " u.state = 2 and u.endtime <= $time ";
				break;
			
			case 'reveal':
				$where[] = " u.state = 2 and u.endtime > $time ";
				break;

			default:
				break;
		}

    	$where_str = implode(' and ', $where);
    	$count = D('')->table('Unitary as u')
				->join("Unitary_join as j On u.id=j.unitary_id")
				->where($where_str)
				->count('u.id');

		$unitary_list = D('')->table('Unitary as u')
				->join("Unitary_join as j On u.id=j.unitary_id")
				->where($where_str)
				->field("u.*")
				->order("j.addtime desc")
				->limit($offset . ',' . $limit)
				->select();

		// 用户参与的活动 数量
		$num_arr = M('Unitary')->getMyJoin($this->user_session['uid'], $time);

		if (count($unitary_list) > 0) {

			foreach ($unitary_list as &$val) {
				// 中奖用户
				$lucknum = D('Unitary_lucknum')->where(array('state'=>1, 'unitary_id'=>$val['id']))->find();

				$find_user = D('User')->field('nickname,uid')->where(array('uid'=>$lucknum['uid']))->find();
				$val['luck_uid'] = $lucknum['uid'];
				$val['luck_name'] = !empty($find_user['nickname']) ? $find_user['nickname'] : '匿名用户';
				$val['user_count'] = D('Unitary_lucknum')->where(array('uid'=>$lucknum['uid'], 'unitary_id'=>$val['id']))->count('id');
				$val['lucknum'] = $lucknum['lucknum'];
				$val['is_countdown'] = ($val['endtime'] - time() > 0) ? 1 : 0;

				// 自己的参与数量
				$lucknum_list = M('Unitary')->getLucknumArr(array('unitary_id'=>$val['id'], 'uid'=>$this->user_session['uid']));

				$val['my_count'] = count($lucknum_list);
				$val['my_lucknum_str'] = implode(' ', $lucknum_list);

				if ($val['state'] == 1) {
					$val['pay_count'] = D('Unitary_lucknum')->where(array('unitary_id'=>$val['id']))->count('id');
					$val['left_count'] = $val['total_num'] - $val['pay_count'];					
				}
			}

			// 分页
			import('source.class.user_page');
			$page = new Page($count, $limit, $p);
			$pages = $page->show();
		}

		$this->assign('cart_list', $unitary_list);
		$this->assign('status', $status);
		$this->assign('pages', $pages);
		$this->assign('num_arr', $num_arr);

	}

	public function unitary_html () {
		$this->display();
	}

}