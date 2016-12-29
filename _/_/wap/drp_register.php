<?php
/**
 *  分销商注册
 */
require_once dirname(__FILE__).'/global.php';
import('source.class.Drp');

$store = M('Store');
if (IS_POST && $_POST['type'] == 'check_store') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    if ($store->checkStoreExist(array('name' => $name, 'status' => 1))) {
        echo false;
    } else {
        echo true;
    }
    exit;
} else if (IS_POST && $_POST['type'] == 'check_phone') {
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $user = M('User');
    if ($user->checkUser(array('phone' => trim($_POST['phone']), 'uid' => array('!=', $_SESSION['wap_user']['uid'])))) {
        echo false;
    } else {
        echo true;
    }
    exit;
}

$store_id = isset($_GET['id']) ? intval(trim($_GET['id'])) : '';

//未登陆
if (empty($_SESSION['wap_user'])) {
    redirect('./login.php');
}

if (empty($now_store)) {
    $now_store = $store->wap_getStore($store_id);
}

$seller_disabled     = false; //分销商禁用
//判断是否开启分销
$allow_drp           = option('config.open_store_drp');
$max_store_drp_level = option('config.max_store_drp_level'); //最大分销级别

Drp::init();
$visitor = Drp::checkID($store_id, $_SESSION['wap_user']['uid']);
if (empty($visitor)) {
    pigcms_tips('抱歉，您访问的页面不存在！');
} else if (empty($visitor['code'])) {
    pigcms_tips($visitor['msg']);
} else if (!empty($visitor['data']['drp_limit_buy'])) {
    pigcms_tips($visitor['data']['drp_limit_msg']);
}
if (!empty($visitor['data']['store_id']) && !empty($visitor['data']['allow_drp_manage'])) {
    redirect('./ucenter.php?id=' . $store_id . '#promotion');
} else if (empty($visitor['data']['allow_drp_register'])) {
    pigcms_tips('抱歉，申请失败！<br/><span style=\"color:gray\">您访问的店铺不允许注册分销商。</span>');
}

//店铺套餐增加分销商数限制
$supplier_id = ($now_store['root_supplier_id'] > 0)?$now_store['root_supplier_id']:$now_store['store_id'];
$seller_count = $store->seller_count($where, $supplier_id);

$temp_arr = D('')->table("Store as s")
        ->join('User as u ON s.uid=u.uid','LEFT')
        ->join('Package as p ON u.package_id=p.pigcms_id','LEFT')
        ->where("`s`.`store_id`=".$supplier_id)
        ->field("`u`.uid,`s`.store_id,`s`.name,`s`.openid,`u`.package_id,`p`.distributor_nums " )
        -> find();

$p_distributor_nums = $temp_arr['distributor_nums'];
    
if(!empty($p_distributor_nums)){
    if($p_distributor_nums != '0'){
        if ($seller_count >= $p_distributor_nums) {
            //发送模板消息告知供货商
            if($temp_arr['openid']) {
                import('source.class.ShopNotice');
                ShopNotice::fxsLimitResultNotice($temp_arr['store_id'],$temp_arr['openid'],$temp_arr['name']);

            }
             pigcms_tips('该商家分销商数量已达上限，请联系供货商扩展数量<a href="./ucenter.php?id=' . $store_id . '">返回个人中心</a>','none');
        }
    }
}


//分销协议
$agreement = option('config.readme_content');

//判断用户是否设置密码
$user = M('User');
$userinfo = $user->getUserById($_SESSION['wap_user']['uid']);
$has_password = true;
if (empty($userinfo['password'])) {
    $has_password = false;
}

//是否审核
$open_drp_approve = false;
if (!empty($now_store['open_drp_approve'])) {
    $open_drp_approve = true;
}

$nickname = !empty($userinfo['nickname']) ? $userinfo['nickname'] : '';

$open_drp_subscribe      = 0;
$open_drp_subscribe_auto = 0;

if (empty($now_store['drp_supplier_id'])) {

    $open_drp_subscribe      = $now_store['open_drp_subscribe'];
    $open_drp_subscribe_auto = $now_store['open_drp_subscribe_auto'];

    if ($open_drp_subscribe || $open_drp_subscribe_auto) {
        $weixin_bind = M('Weixin_bind')->get_access_token($store_id);
        if (!empty($weixin_bind)) {
            //关注时间等于0为静态授权，非关注
            $is_subscribed = D('Subscribe_store')->where(array('openid' => $_SESSION['STORE_OPENID_' . $store_id],'store_id'=>$store_id, 'subscribe_time' => array('>', 0),'is_leave'=>0))->count('sub_id');
            if ($is_subscribed <= 0) { //未关注
                if (!empty($open_drp_subscribe) || !empty($open_drp_subscribe_auto)) {
                    $qrcode = M('Recognition')->get_drp_tmp_qrcode(200000000 + $_SESSION['wap_user']['uid'], $store_id);
                }
            }
        }
    }
}

//来源，注册完成后会跳转回去
$referer = !empty($_GET['referer']) ? urlencode(trim($_GET['referer'])) : '';

include display('drp_register');

echo ob_get_clean();