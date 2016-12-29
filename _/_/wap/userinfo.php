<?php
/**
 *  用户资料
 */
require_once dirname(__FILE__).'/global.php';


$action = isset($_GET['action']) ? $_GET['action'] : 'checkPhone';
if($action == 'checkPhone'){
    if(IS_POST){
        if(empty($_POST['phone'])) json_return(1000,'请输入手机号码');

        $get_result = M('User')->get_user('phone',$_POST['phone']);
        if($get_result['err_code'] != 0) json_return($get_result['err_code'],$get_result['err_msg']);
        if(!empty($get_result['user'])){
            json_return(0,array('uid'=>$get_result['user']['uid']));
        }else{
            json_return(0,array('uid'=>0));
        }
    }
}elseif($action == 'modifyPassword'){
    $database_user = D('User');

    if(!isset($_SESSION['oauth_openid'])){
        $status 	= login_oauth();
    }
    //检测
    $openid 	= $_SESSION['oauth_openid'];

    if(IS_POST){
        $newPassword = md5($_POST['password']);
        $where['openid'] = $openid;
        $where['phone'] = $_POST['phone'];
        $data['password'] = $newPassword;

        $rs = $database_user->where($where)->data($data)->save();

        if($rs){
            json_return(0,'密码修改成功');
        }else{
            json_return(1001,'密码修改失败');
        }
    }

    if(isset($openid)){
        unset($where);
        $where['openid'] = $openid;
        $user_result = $database_user->where($where)->field('nickname,phone')->find();

        if(!empty($user_result)){
            include display('userinfo_modifypassword');

            echo ob_get_clean();
        }else{
            pigcms_tips('该用户账号没有绑定微信，无法使用该功能', 'none');
        }

    }else{
        pigcms_tips('微信授权不成功', 'none');
    }


}

function login_oauth(){
    $appid 	= option('config.wechat_appid');
    $is_weixin = is_weixin();

    if($is_weixin && !isset($_SESSION['oauth_openid'])){

        //用户未登录 调用授权获取openid, 通过openid查找用户，如果已经存在，设置登录，如果不存在，添加一个新用户和openid关联
        if (empty($_SESSION['wap_user'])) {

            $customeUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

            if(empty($_GET['code'])){

                $oauthUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.option('config.wechat_appid').'&redirect_uri='.urlencode($customeUrl).'&response_type=code&scope=snsapi_userinfo&state='.$_SESSION['weixin']['state'].'#wechat_redirect';
                redirect($oauthUrl);exit;

            } else if(isset($_GET['code']) && isset($_GET['state']) && ($_GET['state'] == $_SESSION['weixin']['state'])){

                unset($_SESSION['weixin']);
                import('Http');
                $http = new Http();
                $tokenUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.option('config.wechat_appid').'&secret='.option('config.wechat_appsecret').'&code='.$_GET['code'].'&grant_type=authorization_code';


                $return = $http->curlGet($tokenUrl);
                $jsonrt = json_decode($return,true);



                if($jsonrt['errcode']){
                    $error_msg_class = new GetErrorMsg();
                    exit('授权发生错误：'.$jsonrt['errcode']);
                }

                if($jsonrt['openid']){ //微信中打开直接登陆
                    $url 	= 'https://api.weixin.qq.com/sns/userinfo?access_token='.$jsonrt['access_token'].'&openid='.$jsonrt['openid'].'&lang=zh_CN';
                    $wxuser 	= $http->curlGet($url);
                    $wxuser = json_decode($wxuser, true);

                    $_SESSION['oauth_openid'] = $jsonrt['openid'];
                }
            }

        }

    }

}

?>
