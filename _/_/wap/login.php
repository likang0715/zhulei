<?php
/**
 *  用户登录
 */

require_once dirname(__FILE__) . '/global.php';

if (option('config.ucenter_setting')) {
    //include_once PIGCMS_PATH.'config.inc.php';
    // 加载ucenter配置
    define('UC_DBHOST', option('config.ucenter_dbhost'));            // UCenter 数据库主机
    define('UC_DBUSER', option('config.ucenter_dbuser'));                // UCenter 数据库用户名
    define('UC_DBPW', option('config.ucenter_pwd'));                    // UCenter 数据库密码
    define('UC_DBNAME', option('config.ucenter_dbname'));                // UCenter 数据库名称
    define('UC_DBCHARSET', option('config.ucenter_dbcharset'));                // UCenter 数据库字符集
    define('UC_DBTABLEPRE', option('config.ucenter_dbtablepre'));            // UCenter 数据库表前缀

    define('UC_DBCONNECT', '0');

    //通信相关
    define('UC_KEY', option('config.ucenter_key'));                // 与 UCenter 的通信密钥, 要与 UCenter 保持一致
    define('UC_API', option('config.ucenter_api'));    // UCenter 的 URL 地址, 在调用头像时依赖此常量
    define('UC_CHARSET', option('config.ucenter_charset'));                // UCenter 的字符集
    define('UC_IP', option('config.ucenter_dbip'));                    // UCenter 的 IP, 当 UC_CONNECT 为非 mysql 方式时, 并且当前应用服务器解析域名有问题时, 请设置此值
    define('UC_APPID', option('config.ucenter_appid'));                    // 当前应用的 ID
    define('UC_PPP', '20');

    $dbhost = option('config.ucenter_dbhost');            // 数据库服务器
    $dbuser = option('config.ucenter_dbuser');            // 数据库用户名
    $dbpw = option('config.ucenter_pwd');                // 数据库密码
    $dbname = option('config.ucenter_dbname');            // 数据库名
    $pconnect = 0;                // 数据库持久连接 0=关闭, 1=打开
    $tablepre = option('config.ucenter_dbtablepre');        // 表名前缀, 同一数据库安装多个论坛请修改此处
    $dbcharset = option('config.ucenter_dbcharset');


    include_once PIGCMS_PATH . 'include/db_mysql.class.php';

    $db = new dbstuff;
    $db->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
    unset($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
    include_once PIGCMS_PATH . 'uc_client/client.php';
}

// 操作后的回调
$redirect_uri = $_GET['referer'] ? $_GET['referer'] : ($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : ($_COOKIE['wap_store_id'] ? './home.php?id=' . $_COOKIE['wap_store_id'] : $config['site_url']));

//判定wap站是否开启了 短信功能
if (!$_G['config']['sms_topdomain'] || !$_G['config']['sms_price'] || !$_G['config']['sms_sign'] || !$_G['config']['sms_open'] || $_G['config']['is_open_wap_login_sms_check'] == '0') {
    $is_used_sms = '0'; //关闭使用
} else {
    $is_used_sms = '1'; //开启使用
}
if ($_REQUEST['location_qrcode_id']) {
    $_SESSION['location_qrcode_id'] = $_REQUEST['location_qrcode_id'];
}
if ($_REQUEST['login_qrcode_id']) {
    $_SESSION['login_qrcode_id'] = $_REQUEST['login_qrcode_id'];
}


//回调地址
$redirect_uri = $_GET['referer'] ? $_GET['referer'] : ($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : ($_COOKIE['wap_store_id'] ? './home.php?id=' . $_COOKIE['wap_store_id'] : $config['site_url']));
if (IS_POST) {
    //检测
    $openid = $_SESSION['oauth_openid'];

    $action = isset($_GET['action']) ? $_GET['action'] : 'login';

    //店铺id
    $store_id = intval($_POST['store_id']);

    // 用户名、密码、邮箱
    $username = trim($_POST['phone']);
    $password = trim($_POST['pwd']);
    $email = time() . rand(1, 99) . '@sia.com';
    switch ($action) {
        //绑定手机
        case 'bind':
            if (empty($_POST['phone'])) json_return(10, '请填写您的手机号码');
            if (empty($_POST['pwd'])) json_return(10, '请填写您的密码');

            $database_user = M('User');
            $get_result = $database_user->get_user('phone', $_POST['phone']);
            $get_result2 = $database_user->get_user('openid', $openid);

            if (empty($get_result['user']) && empty($get_result2['user'])) {
                json_return(10, '您在平台尚无账号，请注册绑定！');
            }

            if ($get_result['user']['openid']) {
                json_return(10, '您输入的手机号已绑定其他微信账号，无法登录');
            }

            if ($get_result['err_code'] != 0) {
                json_return(10, $get_result['err_msg']);
            }

            if (empty($get_result['user']['phone'])) {
                json_return(10, '您还没有账号，请注册');
            }

            if ($get_result['user'] && ($get_result['user']['password'] != md5($_POST['pwd']))) {
                json_return(10, '密码不正确');
            }


            ///////////////////////////////////////////////
            if ($get_result['user']) {
                if ($get_result['user']['status'] != 1) json_return(0, '该账号禁止登录');
            }

            if ($get_result2['user']) {
                if ($get_result2['user']['phone']) {
                    json_return(10, '您的微信已经绑定了手机');
                }
            }

            if ($is_used_sms == '1') {
                if (!preg_match('/[0-9]{4}/', $_POST['code'])) {
                    json_return(10, '请正确填写短信验证码');
                }

                //检测验证码是否正确 300秒
                $record_sms = D('Sms_by_code')->where(array('mobile' => $_POST['phone'], 'timestamp' => array('>', time() - 300)))->order("id desc")->limit(1)->find();
                if (trim($_POST['code']) != $record_sms['code']) {
                    json_return(10, '手机验证码错误或过期');
                }
            }


            $save_user_data = array('phone' => $_POST['phone'], 'login_count' => $get_result2['user']['login_count'] + 1, 'last_time' => $_SERVER['REQUEST_TIME'], 'last_ip' => ip2long($_SERVER['REMOTE_ADDR']));
            if ($openid) {
                $save_user_data['openid'] = $openid;
                $save_user_data['avatar'] = $_SESSION['oauth_user']['avatar'];
                $save_user_data['nickname'] = $_SESSION['oauth_user']['name'];
                $save_user_data['sex'] = $_SESSION['oauth_user']['sex'];
                $save_user_data['province'] = $_SESSION['oauth_user']['province'];
                $save_user_data['city'] = $_SESSION['oauth_user']['city'];
				$save_user_data['unionid'] = $_SESSION['oauth_user']['unionid'];
            }

            if ($get_result['user']) {
                $wheres = array('uid' => $get_result['user']['uid']);
            } else if ($get_result2['user']) {
                $wheres = array('uid' => $get_result2['user']['uid']);
            }
            if (!$wheres) json_return(0, '系统内部错误，请重试');
            $save_result = $database_user->save_user($wheres, $save_user_data);
            D('User')->where($wheres)->data(array('weixin_bind' => 2))->save();
            unset($wheres);
            if ($save_result['err_code'] < 0) json_return(10, '系统内部错误，请重试');
            if ($save_result['err_code'] > 0) json_return(10, $save_result['err_msg']);
            $_SESSION['wap_user'] = $get_result['user'];
            $_SESSION['openid'] = $openid;
            if ($_SESSION['location_qrcode_id']) {
                D('Location_qrcode')->where(array('id' => $_SESSION['location_qrcode_id']))->data(array('status' => 2, 'uid' => $get_result['user']['uid'], 'phone' => $data['phone'], 'openid' => $openid))->save();
            }
            if ($_SESSION['login_qrcode_id']) {
                D('login_qrcode')->where(array('id' => $_SESSION['login_qrcode_id']))->data(array('uid' => $get_result['user']['uid'], 'phone' => $data['phone']))->save();
            }

            mergeSessionUserInfo(session_id(), $get_result['user']['uid'], $store_id);

            setcookie('LOGIN_' . option('config.wechat_appid'), $openid, time() + 60 * 60 * 24 * 30);

            // 注册到UCenter
            if (option('config.ucenter_setting')) {
                // 同步登录
                list($uid, $username, $password, $email) = uc_user_login($username, $password);
                if ($uid <= 0) {
                    $uid = uc_user_register($username, $password, $email);
                    //if($uid <= 0){
                    //	pigcms_tips('注册到UCenter失败');
                    //}
                }
                //$ucsynlogin = uc_user_synlogin($uid);
                //$referer = $_POST['referer'];
                //echo $ucsynlogin.'<script>window.location.href="'.$referer.'";</script>';
                //exit;
            }


            json_return(0, '绑定成功');
            break;

        case 'reg':
            if (empty($_POST['phone'])) json_return(1010, '请填写您的手机号码');
            if (empty($_POST['pwd'])) json_return(1011, '请填写您的密码');
            $database_user = D('User');
            if ($database_user->field('`uid`')->where(array('phone' => $_POST['phone']))->find()) {
                json_return(1014, '手机号码已注册试试绑定？');
            }

            $get_result2 = M('User')->get_user('openid', $openid);
            if ($get_result2['user']) {
                if ($get_result2['user']['phone']) {
                    json_return(1022, '您的微信已经绑定了手机');
                }
                if ($get_result2['user']['status'] != 1) json_return(1009, '该账号禁止登录');
            }

            if ($is_used_sms == '1') {
                if (!preg_match('/[0-9]{4}/', $_POST['code'])) {
                    json_return(1012, '请正确填写短信验证码');
                }

                //检测验证码是否正确 300秒
                $record_sms = D('Sms_by_code')->where(array('mobile' => $_POST['phone'], 'timestamp' => array('>', time() - 300)))->order("id desc")->limit(1)->find();
                if (trim($_POST['code']) != $record_sms['code']) {
                    json_return(1013, '手机验证码错误或过期');
                }
            }

            $data = array('login_count' => $get_result2['user']['login_count'] + 1, 'last_time' => $_SERVER['REQUEST_TIME'], 'last_ip' => ip2long($_SERVER['REMOTE_ADDR']));
            if (empty($get_result2['user'])) {
                $data = array();

                $data['phone'] = trim($_POST['phone']);
                $data['avatar'] = $_SESSION['oauth_user']['avatar'];
                $data['nickname'] = $_SESSION['oauth_user']['name'];
                $data['password'] = md5(trim($_POST['pwd']));
                $data['sex'] = $_SESSION['oauth_user']['sex'];
                $data['province'] = $_SESSION['oauth_user']['province'];
                $data['city'] = $_SESSION['oauth_user']['city'];
                $data['check_phone'] = 1;
                $data['login_count'] = 1;
                $data['openid'] = $openid;
                $data['unionid'] = $_SESSION['oauth_user']['unionid'];
                $add_result = M('User')->add_user($data);

            } else {
                $data['phone'] = trim($_POST['phone']);
                $data['avatar'] = $_SESSION['oauth_user']['avatar'];
                $data['nickname'] = $_SESSION['oauth_user']['name'];
                $data['password'] = md5(trim($_POST['pwd']));
                $data['sex'] = $_SESSION['oauth_user']['sex'];
                $data['province'] = $_SESSION['oauth_user']['province'];
                $data['city'] = $_SESSION['oauth_user']['city'];
                $data['check_phone'] = 1;
                $data['login_count'] = 1;
                $data['openid'] = $openid;
                $data['unionid'] = $_SESSION['oauth_user']['unionid'];   

                $res = D('User')->where(array('uid' => $get_result2['user']['uid']))->data($data)->save();

                if ($res) {
                    $data['uid'] = $get_result2['user']['uid'];
                    $add_result = array(
                        'err_code' => 0,
                        'err_msg' => $data,
                    );
                } else {
                    $add_result = array(
                        'err_code' => 1014,
                        'err_msg' => '注册失败',
                    );
                }


            }

            if ($add_result['err_code'] == 0) {
                $get_result = M('User')->get_user('openid', $openid);
                $_SESSION['wap_user'] = $get_result['user'];
                $_SESSION['openid'] = $openid;
                mergeSessionUserInfo(session_id(), $add_result['err_msg']['uid'], $store_id);
                if ($_SESSION['location_qrcode_id']) {
                    D('Location_qrcode')->where(array('id' => $_SESSION['location_qrcode_id']))->data(array('status' => 2, 'uid' => $add_result['user']['uid'], 'phone' => $data['phone'], 'openid' => $openid))->save();
                }
                if ($_SESSION['login_qrcode_id']) {
                    D('login_qrcode')->where(array('id' => $_SESSION['login_qrcode_id']))->data(array('uid' => $add_result['user']['uid'], 'phone' => $data['phone']))->save();
                }
                setcookie('LOGIN_' . option('config.wechat_appid'), $openid, time() + 60 * 60 * 24 * 30);
                D('User')->where(array('uid' => $add_result['err_msg']['uid']))->data(array('weixin_bind' => 2))->save();
                // 注册到UCenter
                if (option('config.ucenter_setting')) {
                    $uid = uc_user_register($username, $password, $email);
                    if ($uid <= 0) {
                        json_return(1, '注册失败');
                    }
                }

                json_return(0, '注册成功');
            } else {
                json_return(1, $add_result['err_msg']);
            }
            break;

        //用微信登录无需绑定
        case 'weixin_nobind':
            if (empty($openid)) {
                json_return(2001, '授权失败');
            }

            $user = D('User')->where(array('openid' => $openid))->find();
            $data = array('login_count' => $user['user']['login_count'] + 1, 'last_time' => $_SERVER['REQUEST_TIME'], 'last_ip' => ip2long($_SERVER['REMOTE_ADDR']));
            if ($user) {
                $data['nickname'] = $_SESSION['oauth_user']['name'];
                $data['avatar'] = $_SESSION['oauth_user']['avatar'];
                $data['sex'] = $_SESSION['oauth_user']['sex'];
                $data['province'] = $_SESSION['oauth_user']['province'];
                $data['city'] = $_SESSION['oauth_user']['city'];
                $data['weixin_bind'] = 2;
				$data['unionid'] = $_SESSION['oauth_user']['unionid'];
                D('User')->where(array('openid' => $openid))->data($data)->save();
            } else {
                $data['nickname'] = $_SESSION['oauth_user']['name'];
                $data['avatar'] = $_SESSION['oauth_user']['avatar'];
                $data['sex'] = $_SESSION['oauth_user']['sex'];
                $data['province'] = $_SESSION['oauth_user']['province'];
                $data['city'] = $_SESSION['oauth_user']['city'];
                $data['check_phone'] = 1;
                $data['login_count'] = 1;
                $data['openid'] = $openid;
                $data['weixin_bind'] = 2;
				$data['unionid'] = $_SESSION['oauth_user']['unionid'];
                D('User')->data($data)->add();
            }
            $get_result = M('User')->get_user('openid', $openid);
            if ($_SESSION['location_qrcode_id']) {
                D('Location_qrcode')->where(array('id' => $_SESSION['location_qrcode_id']))->data(array('status' => 2, 'uid' => $get_result['user']['uid'], 'phone' => $data['phone'], 'openid' => $openid))->save();
            }
            if ($_SESSION['login_qrcode_id']) {
                D('login_qrcode')->where(array('id' => $_SESSION['login_qrcode_id']))->data(array('uid' => $get_result['user']['uid'], 'phone' => $data['phone']))->save();
            }
            $_SESSION['wap_user'] = $get_result['user'];
            $_SESSION['openid'] = $openid;
            mergeSessionUserInfo(session_id(), $get_result['user']['uid'], $store_id);
            setcookie('LOGIN_' . option('config.wechat_appid'), $openid, time() + 60 * 60 * 24 * 30);
            json_return(0, '登录成功');
            break;

        case 'checkuser':
            if ($is_used_sms == '1') {
                if ($_POST['is_ajax'] == 1) {

                    $mobile = trim($_POST['mobile']);

                    if (empty($mobile)) {
                        echo json_encode(array('status' => '3', 'msg' => '手机号为空'));
                        exit;
                    }

                    if (!preg_match("/^1[3|5|7|8|9]{1}[0-9]{9}$/i", $mobile)) {
                        echo json_encode(array('status' => '2', 'msg' => '该手机号不正确'));
                        exit;
                    }


                    //判定用户是绑定 或者 注册新账户
                    if ($_POST['check_type'] == 'bind') {
                        $user = D('User')->where(array('phone' => $mobile))->find();
                        if ($user) {
                            if ($user['openid']) {
                                echo json_encode(array('status' => '4', 'msg' => '该手机号已经绑定微信帐号啦'));
                                exit;
                            }
                            if ($user['status'] != 1) {
                                echo json_encode(array('status' => '4', 'msg' => '该手机账号被禁止'));
                            }
                        } else {
                            echo json_encode(array('status' => '5', 'msg' => '该手机号尚未注册，咋绑定'));
                            exit;
                        }

                    } elseif ($_POST['check_type'] == 'reg') {
                        $user = D('User')->where(array('phone' => $mobile))->find();
                        if ($user) {
                            echo json_encode(array('status' => '6', 'msg' => '对不起该手机号已注册，试试绑定？'));
                            exit;
                        } else {
                            $user2 = D('User')->where(array('openid' => $openid))->find();
                            if ($user2['phone']) {
                                echo json_encode(array('status' => '6', 'msg' => '该账号已绑定存在，咋还注册？'));
                                exit;
                            }

                        }
                    } else {
                        echo json_encode(array('status' => '7', 'msg' => '类型错误'));
                        exit;
                    }


                    $record_sms = D('Sms_by_code')->where(array('mobile' => $mobile, 'type' => 'reg'))->order("id desc")->limit(1)->find();
                    if (time() - $record_sms['timestamp'] <= 300) {

                        echo json_encode(array('status' => '4', 'code' => $record_sms['code'], 'msg' => '短信验证码已发送至手机，请及时操作'));
                        exit;
                    }
                }

                //发送验证码
                $return = M('Sms_by_code')->send($mobile, 'reg');
                if ($return['code_return'] == '0') {
                    echo json_encode(array('status' => '0', 'code' => $record_sms['code'], 'msg' => '该手机号可以注册'));
                    exit;
                } else {
                    switch ($return['code_return']) {
                        case '4085':
                            echo json_encode(array('status' => '4085', 'msg' => '该手机号验证码短信每天只能发五个'));
                            exit;
                            break;
                        case '4084':
                            echo json_encode(array('status' => '4084', 'msg' => '该手机号验证码短信每天只能发四个'));
                            exit;
                            break;
                        case '4030':
                            echo json_encode(array('status' => '4030', 'msg' => ' 手机号码已被列入黑名单 '));
                            exit;
                            break;
                        case '408':
                            echo json_encode(array('status' => '408', 'msg' => '您的帐户疑被恶意利用，已被自动冻结，如有疑问请与客服联系'));
                            exit;
                            break;
                        default:
                            echo json_encode(array('status' => '9999', 'msg' => '该手机号操作异常'));
                            exit;
                            break;
                    }
                }
            } else {
                echo json_encode(array('status' => '9998', 'msg' => '系统未开启短信功能'));
                exit;
            }

            break;
        case 'complete_info':
            if (empty($_POST['phone'])) json_return(1010, '请填写您的手机号码');
            if (empty($_POST['password'])) json_return(1011, '请填写您的密码');
            $database_user = D('User');
            $database_store = D('Store');
            if ($database_user->field('`uid`')->where(array('phone' => $_POST['phone']))->find()) json_return(1014, '手机号码已注册请重新填写');
            $where['store_id'] = $_POST['store_id'];
            $store_info = D('Store')->field('uid')->where($where)->find();
            if ($store_info) {
                $user_info = $database_user->where(array('uid' => $store_info['uid']))->find();
                if ((!$user_info['phone']) && (!$user_info['password'])) {
                    $data['phone'] = $_POST['phone'];
                    $data['password'] = md5($_POST['password']);
                    $result = $database_user->where(array('uid' => $store_info['uid']))->data($data)->save();
                    if ($result) {
                        json_return(0, '信息补全成功');
                    }
                } else {
                    json_return(1011, '数据异常');
                }
            } else {
                json_return(1011, '数据异常');
            }
            break;
    }
} else {
    //回调地址
    $redirect_uri = $_GET['referer'] ? $_GET['referer'] : ($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : ($_COOKIE['wap_store_id'] ? './home.php?id=' . $_COOKIE['wap_store_id'] : $config['site_url']));
    if (strpos($redirect_uri, '&amp;')) {
        $redirect_uri = str_replace('&amp;', '&', $redirect_uri);
    }

    //店铺id
    $store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : (!empty($_SESSION['tmp_store_id']) ? $_SESSION['tmp_store_id'] : $_COOKIE['wap_store_id']);

    //退出登录
    switch ($_GET['action']) {
        case 'quit':
            unset($_SESSION['wap_user']);
            unset($_SESSION['oauth_user']);
            setcookie('LOGIN_' . option('config.wechat_appid'), '', time() - 3600);
            redirect($redirect_uri);
            exit;
            break;
    }

    $status = login_oauth();

    if ($openid) {
        $_SESSION['oauth_openid'] = $openid;
    }

    $openid = $_SESSION['oauth_openid'];

    $get_result = M('User')->get_user('openid', $openid);
    if ($status['is_oauth'] && $status['is_bind'] || ($get_result['user'] && $get_result['user']['weixin_bind'] == 2)) {
        if ($_SESSION['location_qrcode_id']) {
            D('Location_qrcode')->where(array('id' => $_SESSION['location_qrcode_id']))->data(array('status' => 2, 'uid' => $get_result['user']['uid'], 'openid' => $openid))->save();
        }
        if ($_SESSION['login_qrcode_id']) {
            D('login_qrcode')->where(array('id' => $_SESSION['login_qrcode_id']))->data(array('uid' => $get_result['user']['uid'], 'phone' => $data['phone']))->save();
        }

        $login = M('User')->autologin('openid', $openid);
        if ($login['err_code'] == 0) {
            $_SESSION['wap_user'] = $login['user'];
            $_SESSION['openid'] = $openid;

            mergeSessionUserInfo(session_id(), $login['user']['uid'], $store_id);
            redirect($redirect_uri);
        } else {
            pigcms_tips($login['err_msg']);
        }


    }

    include display('login');
    echo ob_get_clean();
}

function login_oauth()
{

    $appid = option('config.wechat_appid');
    $is_weixin = is_weixin();

    if (!empty($_SESSION['oauth_openid'])) {
        $user_info = M('User')->get_user('openid', $_SESSION['oauth_openid']);

        if ($user_info['user']['phone'] != '') {
            $result = array('is_oauth' => 1, 'is_bind' => 1);
        } else {
            $result = array('is_oauth' => 1, 'is_bind' => 0);
        }
    }

    if ($is_weixin && empty($_SESSION['oauth_openid']) && empty($_SESSION['oauth_user'])) {

        $customeUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        //判断店铺是否绑定过认证服务号
        if (empty($_GET['code'])) {

            $_SESSION['weixin']['state'] = md5(uniqid());
            $oauthUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . option('config.wechat_appid') . '&redirect_uri=' . urlencode($customeUrl) . '&response_type=code&scope=snsapi_userinfo&state=' . $_SESSION['weixin']['state'] . '#wechat_redirect';
            redirect($oauthUrl);
            exit;

        } else if (isset($_GET['code']) && isset($_GET['state']) && ($_GET['state'] == $_SESSION['weixin']['state'])) {

            import('Http');
            $http = new Http();

            $tokenUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . option('config.wechat_appid') . '&secret=' . option('config.wechat_appsecret') . '&code=' . $_GET['code'] . '&grant_type=authorization_code';


            $return = $http->curlGet($tokenUrl);
            $jsonrt = json_decode($return, true);

            if ($jsonrt['errcode']) {
                $error_msg_class = new GetErrorMsg();
                $result = array('is_oauth' => 0, 'is_bind' => 0);
            }

            if ($jsonrt['openid']) { //微信中打开直接登录
                $url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $jsonrt['access_token'] . '&openid=' . $jsonrt['openid'] . '&lang=zh_CN';
                $wxuser = $http->curlGet($url);
                $wxuser = json_decode($wxuser, true);

                $_SESSION['oauth_openid'] = $jsonrt['openid'];
                $_SESSION['oauth_user']['name'] = $wxuser['nickname'];
                $_SESSION['oauth_user']['sex'] = $wxuser['sex'];
                $_SESSION['oauth_user']['province'] = $wxuser['province'];
                $_SESSION['oauth_user']['city'] = $wxuser['city'];
                $_SESSION['oauth_user']['avatar'] = $wxuser['headimgurl'];
				$_SESSION['oauth_user']['unionid'] = $wxuser['unionid'];
                $user_info = M('User')->get_user('openid', $jsonrt['openid']);
				$err=array();
				$err['sess']= $_SESSION['oauth_user'];
				$err['user']= $user_info;
             
                if (empty($user_info['user']['unionid'])) {
                    //更新unionid
                 D('User')->where(array('openid' => $jsonrt['openid']))->data(array('unionid' => $wxuser['unionid']))->save();
			                
                }

                if (!empty($user_info['user']['phone'])) {
                    //更新头像
                    $updata = D('User')->where(array('openid' => $jsonrt['openid']))->data(array('avatar' => $_SESSION['oauth_user']['avatar']))->save();
                    if ($updata) { //不再自动更新头像
                        //$_SESSION['wap_user']['avatar'] 	= $_SESSION['oauth_user']['avatar'];
                    }
                    $result = array('is_oauth' => 1, 'is_bind' => 1);
                } else {
                    $result = array('is_oauth' => 1, 'is_bind' => 0);
                }
            }

            unset($_SESSION['weixin']);

        }

    }

    return $result;

}

?>