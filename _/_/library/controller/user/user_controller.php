<?php
/**
 * 账号
 * User: pigcms-s
 * Date: 2015/09/07
 * Time: 13:41
 */
class user_controller extends controller{

		
	public function __construct(){	//显示声明一个构造方法且带参数
		parent::__construct();
		
		 //判定pc站是否开启了 短信功能
		if (!option("config.sms_topdomain") || !option("config.sms_price") || !option("config.sms_sign") || !option("config.sms_open")) {
			$is_used_sms = '0'; //关闭使用
		} else {
			$is_used_sms = '1'; //开启使用
		}
		$this->is_used_sms = $is_used_sms;
		$this->assign('is_used_sms', $is_used_sms);

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
					
				$record_sms = D('Sms_by_code')->where(array('mobile' => $mobile, 'type' => 'reg'))->order("id desc")->limit(1)->find();
				if(time() - $record_sms['timestamp']<=300) {
	
					echo json_encode(array('status' => '4','code'=>$record_sms['code'] , 'msg' => '短信验证码已发送至手机，请及时操作！'));exit;
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
			//发送验证码
			$return = M('Sms_by_code')->send($mobile,'reg');
			if($return['code_return']=='0') {
				echo json_encode(array('status' => '0','code'=>$record_sms['code'] , 'msg' => '该手机号可以注册'));exit;
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
						echo json_encode(array('status' => '9999','msg' => '该手机号操作异常！'));exit;
						break;		
				}		
			}
		} else {
			echo json_encode(array('status' => '9998','msg' => '系统未开启短信功能'));exit;
		}
	}

	// 验证码
	public function verify() {
		import ( 'source.class.Image' );
		Image::buildImageVerify();
	}	
	
	//登陆
	public function login() {
		if (!empty($this->user_session)) {
			$referer = $_GET['referer'] ? urldecode($_GET['referer']) : ($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : $this->config['site_url']);
			redirect($referer);
		}

		// 登录处理
		if (IS_POST) {
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
				list($uid, $username, $password, $email) = uc_user_login($phone, $password);
				if($uid <= 0){
					pigcms_tips('用户不存在'.$uid);
				}
				$ucsynlogin = uc_user_synlogin($uid);
				$referer = '/index.php';
				echo json_encode(array('status' => true, 'msg' => '登录成功', 'data' => array('nexturl' => $referer),'ucsynlogin'=>$ucsynlogin.'<script>window.location.href="'.$referer.'";</script>'));
				exit;
			}


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
			

			$referer = url('store:select');
			// 门店管理员直接跳到门店管理 
			if ($user['type'] == '1' && $user['item_store_id']) {
				$store_physical = D('Store_physical')->where(array('pigcms_id' => $user['item_store_id']))->find();
				$store = M('Store')->getStore($store_physical['store_id']);
				

				if (!empty($store)) {
					$_SESSION['tmp_store_id'] = $store['store_id'];
					$_SESSION['store'] = $store;

					$_SESSION['user']['uid'] = $store['uid'];
					$_SESSION['user']['physical_uid'] = $user['uid'];

					$referer = url('store:index');
				}
			}

			unset($_SESSION['forget_info']);
			echo json_encode(array('status' => true, 'msg' => '登录成功', 'data' => array('nexturl' => $referer)));
			exit;
		}
		
		$referer = $_GET['referer'] ? urldecode($_GET['referer']) : ($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : $this->config['site_url']);
		$this->assign('referer', $referer);

		$agent_code = isset($_GET['agent_code']) ? $_GET['agent_code'] : '';
		$this->assign('agent_code', $agent_code);

		// 分配变量
		$adver = M('adver');
		$ad = $adver->get_adver_by_key('pc_login_pic', 1);
		$this->assign('ad', $ad['0']);
					
		
		$this->display();exit;
	}
	
	
	/**
	 * 注册页面
	 */
	public function register() {
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
			$agent_code = isset($_POST['agent_code']) ? $_POST['agent_code'] : '';
	
			if (empty($phone) || empty($nickname) || empty($password)) {
				echo json_encode(array('status' => false, 'msg' => '请完整填写注册信息'));
				exit;
			}
			if (($_SESSION ['verify'] != md5 ( $_POST['verify'] )) || !$_SESSION['verify'] ) {
				echo json_encode ( array ('status' => 'false','msg' => '验证码填写错误！' ) );
				exit();
			}				
			//注册暂时不使用注册码
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

			if(option('config.ucenter_setting')){
				$email = time().rand(1,99).'@sia.com';
				$uid = uc_user_register($phone, $password, $email);
				if($uid <= 0){
					echo json_encode(array('status' => false, 'msg' => '注册失败'));
					exit;
				}
			}		
			
			$data = array();
	
			// 有邀请码则增加关联
			if (true && !empty($agent_code)) {
				$admin = M("Admin")->getAdminByInvite($agent_code);
				if (empty($admin)) {
					echo json_encode(array('status' => false, 'msg' => '邀请码错误，请重新填写或不填！'));
					exit;
				} else {
					$data['invite_admin'] = $admin['id'];
				}
			}
	
			/* if ($user_model->checkUser(array('nickname' => $nickname))) {
			 echo json_encode(array('status' => false, 'msg' => '此昵称已经注册了'));
			 exit;
			 } */
	
			$data['nickname'] = $nickname;
			$data['phone'] = $phone;
			$data['password'] = md5($password);

			$user = $user_model->add_user($data);
	
			if ($user['err_code'] != 0) {
				echo json_encode(array('status' => false, 'msg' => '注册失败'));
				exit;
			}
	
			// 邀请码关联 添加推广记录
			if (!empty($admin)) {
				$agent_record = array(
						'uid' => $user['err_msg']['uid'],
						'admin_id' => $admin['id'],
						'type' => 1,
						'add_time' => time(),
					);
				$agent_add = D("Agent_invite")->data($agent_record)->add();
			}

			$user = $user_model->getUserById($user['err_msg']['uid']);
			$_SESSION['user'] = $user;
			unset($_SESSION['forget_info']);
			//$referer =  option('config.site_url');
			$referer = url('store:select');
			
			echo json_encode(array('status' => true, 'msg' => '注册成功', 'data' => array('nexturl' => $referer)));
			exit;
		}
	
		$referer = $_GET['referer'] ? urldecode($_GET['referer']) : ($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : $this->config['site_url']);
		$this->assign('referer', $referer);
	
		// 判断是否已经登录，登录就进入主页
		/*
		 $adver = M('adver');
		 $ad = $adver->get_adver_by_key('pc_login_pic', 1);
		 // 分配变量
		 $this->assign('ad', $ad['0']);
		*/
		$mobile = $_COOKIE['reg_mobile'] ? $_COOKIE['reg_mobile'] : '';
	
		$record_sms = D('Sms_by_code')->where(array('mobile'=>$mobile))->order("id desc")->limit(1)->find();
	
		$this->assign('type', 'register');
		$this->assign('sms_register', $record_sms);
		$this->display('login');
	}
	
	
	public function com_register() {
		  
	
		// 提交注册
		if (IS_POST) {
		
			// 实例化user_model
			$user_model = M('User');
			$phone = isset($_POST['mobile']) ? trim($_POST['mobile']) : '';
			$nickname = isset($_POST['mobile']) ? trim($_POST['mobile']) : '';
			$password = isset($_POST['password']) ? $_POST['password'] : '';
		
	
			if (empty($phone) || empty($nickname) || empty($password)) {
				echo json_encode(array('status' => false, 'msg' => '请完整填写注册信息'));
				exit;
			}
					
			
			if ($user_model->checkUser(array('phone' => $phone))) {
				echo json_encode(array('status' => false, 'msg' => '此手机号已经注册了'));
				exit;
			}

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
            $data['status'] = 0;
			$user = $user_model->add_user($data);
	       
			if ($user['err_code'] != 0) {
				echo json_encode(array('status' => false, 'msg' => '注册失败'));
				exit;
			}
			
			$data = array();
            $data['uid'] = $user['err_msg']['uid'];
            $data['name'] = trim($_POST['store_name']);
            $data['sale_category_id'] = intval($_POST['sale_category_id']);
            $data['sale_category_fid'] = intval($_POST['sale_category_fid']);
            $data['linkman'] = trim($_POST['contacts_name']);
            $data['legal_person'] = trim($_POST['legal_person']); // 店铺法人
            $data['tel'] = trim($_POST['contacts_phone']);
            $data['qq'] = trim($_POST['qq']);
            $data['date_added'] = time();
			$data['status'] = 2;
            $data['drp_supplier_id'] = 0;
			 $store = M('Store');
			$result = $store->create($data);
			
			
			
			if (!empty($result['err_code'])) {

                $data['company'] = trim($_POST['company_name']);
                $data['province'] = trim($_POST['province']);
                $data['city'] = trim($_POST['city']);
                $data['area'] = trim($_POST['area']);
                $data['address'] = trim($_POST['address']);
				
				
				//店铺 设置 区域
				$newid = $_POST['newid'];
				D('Attachment_rz')->where(array('uid'=>$newid))->delete();
				
				
				$datas = array(
					'province' => $_POST['province'],
					'city'	   => $_POST['city'],
					'county'   => $_POST['area'],
					'long'	   => $_POST['map_long'],
					'lat'	   => $_POST['map_lat'],
					'yyzz'	   => $_POST['cert'],
					'email'	   => $_POST['email'],
					'qtzl'	   => $_POST['other'],
					'zzno'	   => $_POST['business_licence_number'],
					'yxqtime'	   => $_POST['zzsttime'].'-'.$_POST['zzendtime']
				);
				$store_contact_data = array_merge($datas,array('store_id'=>$result['err_msg']['store_id'],'address'=>$_POST['address']));
				D('Store_contact')->data($store_contact_data)->add();
				
				
				$data = array(
					'province' => $_POST['province'],
					'city'	   => $_POST['city'],
					'county'   => $_POST['area']
				
				);
				$store_area_data = array_merge($data,array('store_id'=>$result['err_msg']['store_id'],'status'=>1,'add_time'=>time()));
				D('Store_area_record')->data($store_area_data)->add();
				
				
				import('MessageFactory');
				$admin_list = M('Admin')->getAreaAdminByCode($_POST['province'], $_POST['city'], $_POST['area']);
				if(count($admin_list) && option('config.ischeck_store')) {
					foreach($admin_list as $k=>$v) {
						if($v['phone']) {
							$params['mobile'] 	= $v['phone'];
							$params['token'] 	= 'to_area_user';				
							$params['content']  = '尊敬的区域管理员，您下属区域 新增商家 【'.$_POST["store_name"].'】 需要审核，请及时处理！';
							$params['sendType'] = 1;	
							MessageFactory::method($params, array('SmsMessage'));	
						}
					}
				}
				
				
              $users = M('User');
              $sale_category = M('Sale_category');
				//用户店铺数加1
                $users->setStoreInc($user['err_msg']['uid']);
				
				
				
				//设置为卖家
                $users->setSeller($user['err_msg']['uid'], 1);
				
				//主营类目店铺数加1
                $sale_category->setStoreInc($data['sale_category_id']);
                $sale_category->setStoreInc($data['sale_category_fid']);
                
              
				//添加默认消息
                $database_page = D('Wei_page');
                $data_page['store_id'] = $result['err_msg']['store_id'];
                $data_page['page_name'] = '这是您的第一篇微杂志';
                $data_page['is_home'] = 1;
                $data_page['add_time'] = $_SERVER['REQUEST_TIME'];
                $data_page['has_custom'] = 1;
                if ($page_id = $database_page->data($data_page)->add()) {
                    $database_custom_field = D('Custom_field');
                    $data_custom_field['store_id'] = $result['err_msg']['store_id'];
                    $data_custom_field['module_name'] = 'page';
                    $data_custom_field['module_id'] = $page_id;
                    $data_custom_field['field_type'] = 'title';
                    $data_custom_field['content'] = serialize(array('title' => '初次认识微杂志', 'sub_title' => date('Y-m-d H:i', $_SERVER['REQUEST_TIME'])));
                    $database_custom_field->data($data_custom_field)->add();
                    $data_custom_field['field_type'] = 'rich_text';
                    $data_custom_field['content'] = serialize(array('content' => '<p>感谢您使用' . $this->config['site_name'] . '，在' . $this->config['site_name'] . '里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择' . $this->config['site_name'] . '！</p>'));
                    $database_custom_field->data($data_custom_field)->add();
                }


            }
	
	
       	$sms = D('Sms_tpl')->where(array('id'=>'4','status'=>'1'))->find();
				
				if($sms){
			 import('source.class.SendSms');
			 
			 $storename=$_POST['store_name']; 
			 $mobile=$_POST['mobile']; 
			 $address=$_POST['address'];
		     $str=$sms['text'];
			 $str=str_replace('{storename}',$storename,$str); 
			 $str=str_replace('{mobile}',$mobile,$str); 
			 $str=str_replace('{address}',$address,$str);
		
		 	 $return	= SendSms::send($mobile,$str);
	//	exit(json_encode(array('error' => 0, 'message' => $return)));
			if($return==0){
			$data = array(
						'uid' 	=> 5,
						'store_id' 	=> 0,
						'price' 	=> 0,
						'mobile' 	=> $mobile,
						'text'		=> $str,
						'status'	=> 0,
						'type'	=> 4,
						'time' => time(),
						'last_ip'	=> ip2long(get_client_ip())
				);
			D('Sms_record')->data($data)->add();
				}
				}
	
	        
			
		
			$referer = url('index:index');
			echo json_encode(array('status' => true, 'msg' => '注册成功', 'data' => array('nexturl' => $referer)));
			exit;
			
		}
	
		$referer = $_GET['referer'] ? urldecode($_GET['referer']) : ($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : $this->config['site_url']);
		$this->assign('referer', $referer);
	
		// 判断是否已经登录，登录就进入主页
		/*
		 $adver = M('adver');
		 $ad = $adver->get_adver_by_key('pc_login_pic', 1);
		 // 分配变量
		 $this->assign('ad', $ad['0']);
		*/
		$mobile = $_COOKIE['reg_mobile'] ? $_COOKIE['reg_mobile'] : '';
	
		
	     $tmp_categories = M('Sale_category')->getCategoriesValid(0);
	     $categories = array();
            foreach ($tmp_categories as $tmp_category) {
                $children = M('Sale_category')->getCategoriesValid($tmp_category['cat_id']);
                $categories[$tmp_category['cat_id']] = array(
                    'cat_id' => $tmp_category['cat_id'],
                    'name' => $tmp_category['name'],
                    'children' => $children
                );
            }
			
		
        $this->assign('json_categories', json_encode($categories));
	   
	    $newid = rand(1,999999);
	    $this->assign('newid', $newid);
		$this->assign('type', 'register');
		$this->assign('sms_register', $record_sms);
		$this->display('register');
	}
	
	public function logout() {
		unset($_SESSION['user']);
		setcookie('session','',time()-3600);
		session_destroy();
		$referer = url('user:login');
		redirect($referer);
	}

	
	public function sycn_timeout() {
		$this->display();
	}
	
	// 店铺后台添加订单时，用户检测
	public function order_check_user() {
		/*$phone = $_POST['phone'];
		
		if(empty($phone) &&!preg_match("/\d{5,12}$/", $phone)){
			json_return(1000, '请正确填写手机号');
		}*/
		$nickname = $_POST['nickname'];
		$type = $_POST['type'];
		$uid = $_POST['uid'];
		$weixin_bind = $_POST['weixin_bind'];
		$store_id = $_SESSION['store']['store_id'];
		
		if (empty($nickname)) {
			json_return(1000, '请填写用户昵称');
		}
		
		$user = array();
		if ($type == 'uid') {
			$user = D('User')->where(array('uid' => $nickname))->find();
		} else {
			if (!empty($uid)) {
				$user = D('User')->where(array('uid' => $uid))->find();
			} else {
				$user = D('User')->where("nickname = '" . $nickname . "' OR phone = '" . $nickname . "'")->find();
			}
		}
		$is_weixin = false;
		$weixin_qr_image = '';
		$user_address_list = array();
		$uid = 0;
		if (empty($user)) {
			json_return(1000, '未找到相应的用户');
			
			$data = array();
			$data['phone'] = $phone;
			$data['password'] = md5($phone);
			$data['reg_time'] = time();
			$data['reg_ip'] = get_client_ip(1);
			
			$user_model = D('User');
			$result = $user_model->data($data)->add();
			
			if ($result) {
				$uid = $user_model->lastInsID;
			} else {
				json_return(1000, '操作失败请重试');
			}
		} else {
			if ($user['uid'] == $_SESSION['store']['uid']) {
				json_return(1000, '不能给自己手工做单');
			}
			/*$store_user_data = D('Store_user_data')->where(array('store_id' => $store_id, 'uid' => $user['uid']))->find();
			if (empty($store_user_data)) {
				json_return(1000, '未找到相应的用户');
			}*/
			
			if ($user['openid']) {
				$is_weixin = true;
			}
			$uid = $user['uid'];
			$user_address_list = M('User_address')->select('', $user['uid']);
		}
		
		if (!$is_weixin && $weixin_bind) {
			$appid = option('config.wechat_appid');
			$appsecret = option('config.wechat_appsecret');
			
			if(empty($appid) || empty($appsecret)){
				$is_weixin = true;
			} else {
				// 后台添加订单二维码绑定，数值从1000000000
				$start_number = 1000000000;
				$qrcode_id = $start_number + $uid;
				
				import('Http');
				$http = new Http();
				
				//微信授权获得access_token
				import('WechatApi');
				$tokenObj = new WechatApi(array('appid' => $appid, 'appsecret' => $appsecret));
				$access_token = $tokenObj->get_access_token();
				
				$qrcode_url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $access_token['access_token'];
				$post_data['expire_seconds'] = 604800;
				$post_data['action_name'] = 'QR_SCENE';
				$post_data['action_info']['scene']['scene_id'] = $qrcode_id;
				
				$json = $http->curlPost($qrcode_url, json_encode($post_data));
				
				if (!$json['errcode']){
					$weixin_qr_image = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($json['ticket']);
				}else{
					$is_weixin = true;
				}
			}
		} else {
			$is_weixin = true;
		}
		
		// 用户积分抵扣
		$points_data = Points::getPointConfig($uid, $store_id);
		
		$return = array();
		$return['uid'] = $uid;
		$return['nickname'] = $user['nickname'] ? $user['nickname'] : ($user['phone'] ? $user['phone'] : $user['uid']);
		$return['phone'] = $user['phone'];
		$return['is_weixin'] = $is_weixin;
		$return['weixin_qr_image'] = $weixin_qr_image;
		$return['user_address_list'] = $user_address_list;
		$return['is_point'] = false;
		$return['point_balance'] = 0;
		if (option('credit.platform_credit_open')) {
			$return['point_balance'] = $user['point_balance'];
		}
		
		if (!empty($points_data)) {
			$return['is_point'] = true;
		}
		$return['points_data'] = $points_data;
		
		json_return(0, $return);
	}
	
	public function user_search () {
		$nickname = $_POST['nickname'];
		$store_id = $_SESSION['store']['store_id'];
		
		if (empty($nickname)) {
			json_return(1000);
		}
		
		// $user_list = D('User as u')->join('Store_user_data as sud ON U.uid = sud.uid', 'LEFT')->where("sud.store_id = '" . $store_id . "' AND u.status = 1 AND (u.nickname like '%" . $nickname . "%' OR u.phone like '%" . $nickname . "%')")->field('u.*')->limit(10)->select();
		$user_list = D('User')->where("uid != '" . $_SESSION['store']['uid'] . "' AND status = 1 AND (nickname like '%" . $nickname . "%' OR phone like '%" . $nickname . "%')")->limit(8)->select();
		$json_data = array();
		if (empty($user_list)) {
			json_return(1000);
		}
		
		foreach ($user_list as $user) {
			$tmp = array();
			$tmp['uid'] = $user['uid'];
			$tmp['nickname'] = $user['nickname'] ? $user['nickname'] : ($user['phone'] ? $user['phone'] : $user['uid']);
			$json_data[] = $tmp;
		}
		
		json_return(0, $json_data);
	}
	
	// 用户收货地址
	public function user_address() {
		$uid = $_POST['uid'];
		$province = $_POST['province'];
		$city = $_POST['city'];
		$area = $_POST['area'];
		$name = $_POST['name'];
		$tel = $_POST['tel'];
		$address_id = $_POST['address_id'];
		$jiedao = $_POST['jiedao'];
		
		if (empty($uid)) {
			json_return(1000, '请选择用户');
		}
		
		$user = D('User')->where(array('uid' => $uid))->find();
		if (empty($user)) {
			json_return(1000, '未找到用户');
		}
		
		if (!empty($address_id)) {
			$user_address = D('User_address')->where(array('uid' => $uid, 'address_id' => $address_id))->find();
			if (empty($user_address)) {
				json_return(1000, '未找到要修改的收货地址');
			}
		}
		
		if (empty($province)) {
			json_return(1000, '省份没有选择');
		}
		
		if (empty($city)) {
			json_return(1000, '城市没有选择');
		}
		
		if (empty($area)) {
			json_return(1000, '地区没有选择');
		}
		
		if (empty($jiedao)) {
			json_return(1000, '街道没有填写');
		}
		
		if (empty($name)) {
			json_return(1000, '收货人没有填写');
		}
		
		if (empty($tel) || !preg_match("/\d{5,12}$/", $tel)) {
			json_return(1000, '手机号码格式不正确');
		}
		
		$data = array();
		$data['uid'] = $uid;
		$data['name'] = $name;
		$data['tel'] = $tel;
		$data['province'] = $province;
		$data['city'] = $city;
		$data['area'] = $area;
		$data['address'] = $jiedao;
		
		if (empty($address_id)) {
			$data['add_time'] = time();
			$address_id = D('User_address')->data($data)->add();
		} else {
			D('User_address')->where(array('address_id' => $address_id))->data($data)->save();
		}
		
		import('source.class.area');
		$areaClass = new area();
		
		$data['province_txt'] = $areaClass->get_name($data['province']);
		$data['city_txt'] = $areaClass->get_name($data['city']);
		$data['area_txt'] = $areaClass->get_name($data['area']);
		$data['address_id'] = $address_id;
		
		json_return(0, $data);
	}

	// 微信绑定
	public function weixin_bind() {
		$uid = $_POST['uid'];
		
		if (empty($uid)) {
			json_return(1000, '参数错误');
		}
		
		$user = D('User')->where(array('uid' => $uid))->find();
		if (empty($user)) {
			json_return(1000, '未找到用户');
		}
		
		if ($user['openid']) {
			json_return(0, '绑定成功');
		}
		
		json_return(1000, '');
	}
	
	// 微信扫描
	public function weixin_scan() {
		$appid = option('config.wechat_appid');
		$appsecret = option('config.wechat_appsecret');
		
		if (empty($appid) || empty($appsecret)) {
			json_return(1000, '请联系管理员，添加微信配置');
		}
		
		// 插入二维码临时表
		$data = array();
		$data['ticket'] = 'weixin_scan_order';
		$data['uid'] = 0;
		$data['add_time'] = time();
		$id = D('Login_qrcode')->data($data)->add();
		
		if (empty($id)) {
			json_return(1000, '二维码生成失败');
		}
		
		// 后台二维码扫描，数值从1100000000  (1000000000+100000000(login_qrcode自增id) )
		$start_number = 1000000000;
		$qrcode_id = $start_number + $id;
		
		import('Http');
		$http = new Http();
		
		//微信授权获得access_token
		import('WechatApi');
		$tokenObj = new WechatApi(array('appid' => $appid, 'appsecret' => $appsecret));
		$access_token = $tokenObj->get_access_token();
		
		if ($access_token['errcode']) {
			json_return(1000, $access_token['errmsg']);
		}
		
		$qrcode_url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $access_token['access_token'];
		$post_data['expire_seconds'] = 604800;
		$post_data['action_name'] = 'QR_SCENE';
		$post_data['action_info']['scene']['scene_id'] = $qrcode_id;
		
		$json = $http->curlPost($qrcode_url, json_encode($post_data));
		
		if (!$json['errcode']) {
			$weixin_qr_image = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($json['ticket']);
			
			$return = array();
			$return['weixin_qr_image'] = $weixin_qr_image;
			$return['id'] = $id;
			
			json_return(0, $return);
		}else{
			json_return(1000, '二维码生成失败');
		}
	}
	
	public function weixin_login() {
		/**
		 * json_return第一个参数值说明
		 * 1000 有错，但是前台不报错
		 * 100 有错，前台需要打印出报错信息
		 * 10 重新请求
		 */
		$id = $_GET['id'];
		$store_id = $_SESSION['store']['store_id'];
		if (empty($id) || empty($store_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		$login_qrcode = D('Login_qrcode')->where(array('id' => $id))->find();
		if (empty($login_qrcode)) {
			json_return(1000, '未找到相应的扫码信息');
		}
		
		// 需要用户创建用户
		if ($login_qrcode['other_info']) {
			json_return(20);
		}
		
		if ($login_qrcode['uid']) {
			$user = D('User')->where(array('uid' => $login_qrcode['uid']))->field('`uid`, `nickname`, `phone`')->find();
			if (empty($user)) {
				json_return(100, '未找到相应的用户');
			}
			
			if ($user['uid'] == $_SESSION['store']['uid']) {
				json_return(1000, '不能给自己手工做单');
			}
			
			$this->_weixin_login_data($user, $store_id);
			exit;
		}
		sleep(1);
		
		$i = 0;
		while ($i < 4) {
			$login_qrcode = D('Login_qrcode')->where(array('id' => $id))->find();
			if ($login_qrcode['uid']) {
				$user = D('User')->where(array('uid' => $login_qrcode['uid']))->field('`uid`, `nickname`, `phone`')->find();
				if (empty($user)) {
					json_return(100, '未找到相应的用户');
				}
				
				$this->_weixin_login_data($user, $store_id);
				exit;
			}
			
			$i++;
			sleep(1);
		}
		
		json_return(10);
	}

	public function add_user() {

		$phone = $_POST['phone'];
		$password = $_POST['password'];
		$login_qrcode_id = $_POST['login_qrcode_id'];
		
		if (empty($phone)) {
			json_return(1000, '请填写手机号');
		}
		
		if (!preg_match("/^[0-9]{5,12}$/i", $phone)) {
			json_return(1000, '请填写手机号');
		}
		
		if (empty($password)) {
			json_return(1000, '请填写密码');
		}
		
		$password = md5($password);
		
		// 查找手机号是否已注册
		$user = D('User')->where(array('phone' => $phone))->find();
		if (!empty($user)) {
			json_return(1000, '此手机号已经被注册');
		}
		
		$openid = '';
		$is_weixin = 0;
		$login_qrcode = array();
		if ($login_qrcode_id) {
			$login_qrcode = D('Login_qrcode')->where(array('id' => $login_qrcode_id))->find();
			$openid = $login_qrcode['other_info'];
			if (!empty($login_qrcode['other_info'])) {
				$is_weixin = 1;
			}
		}
		
		$data = array();
		$data['phone'] = $phone;
		$data['password'] = $password;
		$data['openid'] = $openid;
		$data['is_weixin'] = $is_weixin;
		$data['type'] = 0;

		//用户初始套餐
		$package_info = D('Package')->where(array('is_default'=>1))->find();
		$package_id = $package_info['pigcms_id'];
		if($package_id > 0){
			$data['package_id'] = $package_id;
		}
		

		$uid = D('User')->data($data)->add();
		if ($uid) {
			if ($login_qrcode) {
				D('Login_qrcode')->where(array('id' => $login_qrcode_id))->data(array('uid' => $uid))->save();
			}
			json_return(0, $uid);
		} else {
			json_return(1000, '添加失败');
		}
	}
	
	// 统一返回用户数据
	private function _weixin_login_data($user, $store_id) {
		$user_address_list = M('User_address')->select('', $user['uid']);
		// 用户积分抵扣
		$points_data = Points::getPointConfig($user['uid'], $store_id);
		
		$return = array();
		$return['uid'] = $user['uid'];
		$return['nickname'] = $user['nickname'] ? $user['nickname'] : $user['phone'];
		$return['phone'] = $user['phone'];
		$return['user_address_list'] = $user_address_list;
		$return['is_point'] = false;
		if (!empty($points_data)) {
			$return['is_point'] = true;
		}
		$return['points_data'] = $points_data;
		
		json_return(0, $return);
	}

	public function test () {
		$admin_list = M('Admin')->getAreaAdminByCode(340000, 340100, 340186);
		//dump($admin_list);
	}

	public function readme() {
		$this->display();
	}

	public function forget_password(){
        $this->display();
    }
}