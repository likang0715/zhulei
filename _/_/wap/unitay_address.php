<?php

/**
 * 用户地址管理
 * User: pigcms_21
 * Date: 2015/4/24
 * Time: 10:57
 */
require_once dirname(__FILE__) . '/global.php';

$action = !empty($_GET['action']) ? $_GET['action'] : '';

$user = $_SESSION['wap_user'];
$address_id = !empty($_GET['address_id']) ? $_GET['address_id'] : '';

if(!empty($address_id)){
  $user_address = D('User_address')->where(array('address_id'=>$address_id,'uid'=>$user['uid']))->find();
}

if($action == 'update'){
    $data['name'] = !empty($_POST['user_name']) ? $_POST['user_name'] : '';
    $address_id = !empty($_POST['address_id']) ? $_POST['address_id'] : '';
    $data['tel'] = !empty($_POST['tel']) ? $_POST['tel'] : '';
    $data['province'] = !empty($_POST['province']) ? $_POST['province'] : '';
    $data['city'] = !empty($_POST['city']) ? $_POST['city'] : '';
    $data['area'] = !empty($_POST['area']) ? $_POST['area'] : '';
    $data['address'] = !empty($_POST['address']) ? $_POST['address'] : '';
    $data['zipcode'] = !empty($_POST['zipcode']) ? $_POST['zipcode'] : '';
    $data['add_time'] = time();

    $result = D('User_address')->where(array('uid'=>$user['uid'],'address_id'=>$address_id))->data($data)->save();
    if($result){
        $data = json_return('0','更新成功');
    }else{
        $sql = D('User_address')->last_sql;
        $data = json_return('1001',$sql);
    }
}else if($action == 'add'){

    $data['name'] = !empty($_POST['user_name']) ? $_POST['user_name'] : '';
    $data['tel'] = !empty($_POST['tel']) ? $_POST['tel'] : '';
    $data['province'] = !empty($_POST['province']) ? $_POST['province'] : '';
    $data['city'] = !empty($_POST['city']) ? $_POST['city'] : '';
    $data['area'] = !empty($_POST['area']) ? $_POST['area'] : '';
    $data['address'] = !empty($_POST['address']) ? $_POST['address'] : '';
    $data['zipcode'] = !empty($_POST['zipcode']) ? $_POST['zipcode'] : '';
    $data['uid'] = $user['uid'];
    $data['add_time'] = time();

    $result = D('User_address')->data($data)->add();
    if(!D('User_address')->where(array('uid'=>$user['uid'],'default'=>1))->find()){
        D('User_address')->where(array('address_id'=>$result))->data(array('default'=>1))->save();
    }

    if ($result){
        $data = json_return('0', '添加成功');
    }else {
        $data = json_return('1001', '添加失败');
    }
}else if($action == 'delete'){
    $address_id = $_POST['address_id'];

    $result = D('User_address')->where(array('address_id'=>$address_id))->delete();

    if ($result){
        $data = json_return('0', '删除成功');
    }else {
        $data = json_return('1001', '删除失败');
    }
}else if($action == 'default'){
    $address_id = $_POST['address_id'];
    $addInfo = D('User_address')->where(array('address_id'=>$address_id))->find();
    if (empty($addInfo['default'])) {

        D('User_address')->where(array('uid'=>$user['uid'],'default'=>1))->data(array('default'=>0))->save();

        $result = D('User_address')->where(array('address_id'=>$address_id))->data(array('default'=>1))->save();
        if ($result){
            json_return('0', '更新成功');
        }else {
            json_return('1001', '更新失败');
        }
    } else {
        json_return('0', '更新成功');
    }
}

include display('unitay_address');
echo ob_get_clean();