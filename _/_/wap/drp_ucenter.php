<?php
/**
 * 分销用户中心
 * User: pigcms_21
 * Date: 2015/4/18
 * Time: 14:35
 */
require_once dirname(__FILE__).'/global.php';

//dump($_REQUEST);exit;
if(empty($_GET['a']) && empty($_POST)) {
    redirect('./ucenter.php?id=' . intval(trim($_COOKIE['wap_store_id']))."#promotion");
}

if(IS_GET && $_GET['a'] != 'profile' && $_GET['a'] != 'username' && $_GET['a'] != 'mobile' && $_GET['a'] != 'reserved' && $_GET['a'] != 'pwd'){
    if ($_SESSION['wap_drp_store']) {
        $store = $_SESSION['wap_drp_store'];
    } else {
        redirect('./ucenter.php?id=' . intval(trim($_COOKIE['wap_store_id'])));
    }
}

if (IS_GET && $_GET['a'] == 'personal') {
    $store_model = M('Store');

    $drp_approve = true;
    //供货商
    if (!empty($store['drp_supplier_id'])) {
        $supplier = $store_model->getStore($store['drp_supplier_id']);
        $store = $store_model->getStore($store['store_id']);
        $store['supplier'] = $supplier['name'];

        if (!empty($supplier['open_drp_approve']) && empty($store['drp_approve'])) { //需要审核，但未审核
            $drp_approve = false;
        }
    }

    include display('drp_ucenter_personal');
    echo ob_get_clean();
}else if ($_GET['a'] == 'username') {
    $user_model = M('User');
    $user = $_SESSION['wap_user'];
    if ($_POST['type'] == 'nickname') {
        $nickname = trim($_POST['nickname']);
        if ($user_model->setField(array('uid' => $user['uid']), array('nickname' => $nickname))) {
            $_SESSION['wap_user']['nickname'] = $nickname;
            echo 0;
			 exit;
        } else {
            echo 1;
			 exit;
        }
    }
    include display('drp_ucenter_username');
    exit;
}else if ($_GET['a'] == 'order') {
    $user_model = M('User');
    $user = $_SESSION['wap_user'];
    $order_tel = $_POST['order_tel'];
	$order_name = $_POST['order_name'];
        if ($user_model->setField(array('uid' => $user['uid']), array('order_name' => $order_name,'order_tel' => $order_tel))) {
                   echo 0;
			 exit;
        } else {
            echo 1;
			 exit;
        }
}
else if ($_GET['a'] == 'mobile') {
    $user_model = M('User');
    $user = $_SESSION['wap_user'];
    include display('drp_ucenter_mobile');
    exit;
}
elseif($_GET['a'] == 'smscode'){
    $mobile=$_REQUEST['mobile'];
    $post_type=$_REQUEST['post_type'];
	$code=$_REQUEST['sms_code'];
	$results = array('err_code'=>'0','err_msg'=>'');
	$now_date_time=strtotime("Y-m-d");
	if($post_type==1){
	
	    $user = D('User')->where(array('phone'=>$mobile))->find();
				if($user) {
			
			$results['err_code']='1';
			$results['err_msg']='对不起该手机号已绑定';
			exit(json_encode($results));
				}
	
		$counts = D('Sms_by_code')->where("type=reg and mobile = '".$mobile."') and timestamp > ".$now_date_time)->field("count(id) counts")->find();

		if($counts['counts'] >= 10) {
			$results['err_code']='1';
			$results['err_msg']='对不起您的手机号今日发送已达上限！！';
			exit(json_encode($results));
		}
		$record_sms = D('Sms_by_code')->where(array('mobile' => $mobile, 'type' => 'reg'))->order("id desc")->limit(1)->find();
		if(time() - $record_sms['timestamp']<=300) {
		    $results['err_code']='2';
		    $results['err_msg']='短信验证码已发送至手机，请及时操作！';
			exit(json_encode($results));
		}
		
		$return = M('Sms_by_code')->send($mobile,'reg');
		if($return['code_return']=='0') {
		    $results['err_code']='2';
			$results['err_msg']='短信验证码已发送至手机，请及时操作！';
			exit(json_encode($results));
			}else{
			$results['err_code']='1';
			$results['err_msg']='发送失败';
			exit(json_encode($results));
			} 
	}else{
	$record_sms = D('Sms_by_code')->where(array('mobile'=>$mobile,'timestamp'=>array('>',time()-300)))->order("id desc")->limit(1)->find();
	$user_model = M('User');
         	if(empty($code)) {
			
			$results['err_code']='1';
			$results['err_msg']='请正确填写手机验证码';
			exit(json_encode($results));
				}
	
			if (trim($code) != $record_sms['code']) {
				
			$results['err_code']='1';
			$results['err_msg']='手机验证码错误或过期';
			exit(json_encode($results));
				}
			if ($user_model->checkUser(array('phone' => $mobile))) {
			
			$results['err_code']='1';
			$results['err_msg']='此手机号已经绑定过了';
			exit(json_encode($results));
			}	
		$user = $_SESSION['wap_user'];	
		$user_model->setField(array('uid' => $user['uid']), array('phone' => $mobile));	
		$_SESSION['wap_user']['phone'] = $mobile;
		$results['err_code']='2';
		$results['err_msg']='绑定成功！';
		exit(json_encode($results));	
	}	
}
else if ($_GET['a'] == 'reserved') {
    $user_model = M('User');
    $user = $_SESSION['wap_user'];
	$r=D('User')->where(array('uid'=>$user['uid']))->find();
	$user['order_name']=$r['order_name'];
	$user['order_tel']=$r['order_tel'];
    include display('drp_ucenter_reserved');
    exit;
}else if ($_GET['a'] == 'pwd') {
    $user_model = M('User');
    $user = $_SESSION['wap_user'];
    include display('drp_ucenter_pwd');
    exit;
} else if ($_GET['a'] == 'profile') {
    $user_model = M('User');
    $user = $_SESSION['wap_user'];
	$r=D('User')->where(array('uid'=>$user['uid']))->find();
	$user['order_name']=$r['order_name'];
    if ($_POST['type'] == 'truename') {
        $nickname = trim($_POST['truename']);
        if ($user_model->setField(array('uid' => $user['uid']), array('nickname' => $nickname))) {
            $_SESSION['wap_user']['nickname'] = $nickname;
            echo 0;
            exit;
        } else {
            echo 1;
            exit;
        }
        exit;
    } else if ($_POST['type'] == 'password') {
        $password = md5(trim($_POST['newpassword']));
        if ($user_model->setField(array('uid' => $user['uid']), array('password' => $password))) {
            // 同步修改ucenter
            // 加载ucenter配置
            if(option('config.ucenter_setting')){
                define('UC_DBHOST', option('config.ucenter_dbhost'));           // UCenter 数据库主机
                define('UC_DBUSER', option('config.ucenter_dbuser'));               // UCenter 数据库用户名
                define('UC_DBPW', option('config.ucenter_pwd'));                    // UCenter 数据库密码
                define('UC_DBNAME', option('config.ucenter_dbname'));               // UCenter 数据库名称
                define('UC_DBCHARSET', option('config.ucenter_dbcharset'));             // UCenter 数据库字符集
                define('UC_DBTABLEPRE', option('config.ucenter_dbtablepre'));           // UCenter 数据库表前缀

                define('UC_DBCONNECT', '0');

                //通信相关
                define('UC_KEY', option('config.ucenter_key'));             // 与 UCenter 的通信密钥, 要与 UCenter 保持一致
                define('UC_API', option('config.ucenter_api')); // UCenter 的 URL 地址, 在调用头像时依赖此常量
                define('UC_CHARSET', option('config.ucenter_charset'));             // UCenter 的字符集
                define('UC_IP', option('config.ucenter_dbip'));                 // UCenter 的 IP, 当 UC_CONNECT 为非 mysql 方式时, 并且当前应用服务器解析域名有问题时, 请设置此值
                define('UC_APPID', option('config.ucenter_appid'));                 // 当前应用的 ID
                define('UC_PPP', '20');

                $dbhost = option('config.ucenter_dbhost');          // 数据库服务器
                $dbuser = option('config.ucenter_dbuser');          // 数据库用户名
                $dbpw = option('config.ucenter_pwd');               // 数据库密码
                $dbname = option('config.ucenter_dbname');          // 数据库名
                $pconnect = 0;              // 数据库持久连接 0=关闭, 1=打开
                $tablepre = option('config.ucenter_dbtablepre');        // 表名前缀, 同一数据库安装多个论坛请修改此处
                $dbcharset = option('config.ucenter_dbcharset');

                include_once PIGCMS_PATH.'include/db_mysql.class.php';
                $db = new dbstuff;
                $db->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
                unset($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
                include_once PIGCMS_PATH.'uc_client/client.php';
                $phone = $_SESSION['wap_user']['phone'];
                $oldpwd = $_SESSION['wap_user']['password'];
                $newpwd = $_POST['newpassword'];
                $res = uc_user_edit($phone,$oldpwd,$newpwd,false,1);
            }
            echo 0;
        } else {
            echo 1;
        }
        exit;
    }

    include display('drp_ucenter_profile');
    echo ob_get_clean();

} else if (IS_POST && $_POST['type'] == 'check_pwd') {
    $user_model = M('User');
    $user = $_SESSION['wap_user'];
    $password = !empty($_POST['password']) ? md5(trim($_POST['password'])) : '';
    $userinfo = $user_model->checkUser(array('uid' => $user['uid'], 'password' => $password));
    if (!empty($userinfo)) {
        echo 0;
    } else {
        echo 1;
    }
    exit;
} else {
    $store_model      = M('Store');
    $order            = M('Order');
    $fx_order         = M('Fx_order');
    $store_supplier   = M('Store_supplier');
    $financial_record = M('Financial_record');

    if (!empty($_GET['id'])) {
        $store_info = $store_model->getUserDrpStore($_SESSION['wap_user']['uid'], intval(trim($_GET['id']), 0));
        if (!empty($store_info)) {
            $store = $_SESSION['wap_drp_store'] = $store_info;
        }
    } else {
        $store = $store_model->getStore($store['store_id']);
    }
    $store_id = $store['store_id'];

    //店铺销售额
    $sales = $order->getSales(array('store_id' => $store['store_id'], 'is_fx' => 1, 'status' => array('in', array(2,3,4,7))));
    $store['sales'] = number_format($sales, 2, '.', '');
    //佣金总额
    $balance = !empty($store['income']) ? $store['income'] : 0;
    $store['balance'] = number_format($balance, 2, '.', '');

    $drp_approve = true;
    //供货商
    if (!empty($store['drp_supplier_id'])) {
        $supplier = $store_model->getStore($store['drp_supplier_id']);
        $store['supplier'] = $supplier['name'];

        if (!empty($supplier['open_drp_approve']) && empty($store['drp_approve'])) { //需要审核，但未审核
            $drp_approve = false;
        }
    }

    //最大分销级别
    $max_store_drp_level = option('config.max_store_drp_level');
    //当前分销商级别
    $seller = $store_supplier->getSeller(array('seller_id' => $store_id));
    if($max_store_drp_level>0 && !empty($seller['level'])) {
        $current_drp_level = $seller['level'];
        $sub_drp_level = $max_store_drp_level - $current_drp_level;
    } else {
        $current_drp_level = 3;
        $sub_drp_level = 2;
    }
    $level_alias = array(
        1 => '一',
        2 => '二',
        3 => '三',
        4 => '四',
        5 => '五',
        6 => '六',
        7 => '七',
        8 => '八',
        9 => '九',
        10 => '十'
        );
    $sub_drp_levels = array();
    if ($sub_drp_level > 0) {
        for ($i=1; $i <= $sub_drp_level; $i++) {
            $sub_drp_levels[$i] = $level_alias[$i];
        }
    }

    //店铺
    $uid = $store['uid'];
    $stores = $store_model->getUserDrpStores($uid);

    include display('drp_ucenter');
    echo ob_get_clean();
}