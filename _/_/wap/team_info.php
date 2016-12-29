<?php
/**
 * 分销用户中心
 * User: pigcms_21
 * Date: 2015/4/18
 * Time: 14:35
 */
require_once dirname(__FILE__).'/global.php';

if ($_SESSION['wap_drp_store']) {
    $store = $_SESSION['wap_drp_store'];
} else {
    redirect('./ucenter.php?id=' . intval(trim($_COOKIE['wap_store_id'])));
}

$user_model = M('User');
$user = $_SESSION['wap_user'];
if ($_POST['type'] == 'truename') {
    $nickname = trim($_POST['truename']);
    if ($user_model->setField(array('uid' => $user['uid']), array('nickname' => $nickname))) {
        $_SESSION['wap_user']['nickname'] = $nickname;
        echo 0;
    } else {
        echo 1;
    }
    exit;
} else if ($_POST['type'] == 'password') {
    $password = md5(trim($_POST['newpassword']));
    if ($user_model->setField(array('uid' => $user['uid']), array('password' => $password))) {
        echo 0;
    } else {
        echo 1;
    }
    exit;
}else if($_GET['action'] == 'upload'){
    $data['logo'] = !empty($_POST['logo']) ? $_POST['logo'] : '';
    $data['date_edited'] = time();
    $store_id = $store['store_id'];

    $result = D('Store')->where(array('store_id'=>$store_id))->data($data)->save();
    if($result){
        $_SESSION['wap_drp_store']['logo'] = $data['logo'];
        $data = json_return('0','更新成功');
    }

}

include display('team_info');
echo ob_get_clean();