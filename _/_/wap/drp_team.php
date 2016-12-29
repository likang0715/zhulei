<?php
/**
 * 分销团队
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

$drp_team_model = M('Drp_team');
/* 当前登录用户的分销店铺信息 */
$store_info = D('Store')->where(array('store_id'=>$store['store_id']))->find();

/* 获取一级分销商信息 */
if($store_info['drp_level']>1){
    $fx_supplier_info = D('Store_supplier')->where(array('root_supplier_id'=>$store_info['root_supplier_id'],'seller_id'=>$store_info['store_id']))->find();
    $fx_store_id = explode(',',$fx_supplier_info['supply_chain']);
    $fx_one_info = D('Store')->where(array('store_id'=>$fx_store_id[2]))->find();

}else if($store_info['drp_level'] == 1){
    $fx_one_info = $store_info;
}

//团队
$drp_team = $drp_team_model->getDrpTeam(array('store_id' => $fx_one_info['store_id']));

//下属团队别名
$where = array();
$where['team_id'] = $drp_team['pigcms_id'];
$where['store_id'] = $store_info['store_id'];
$team_lable = M('Drp_team_member_label')->getMemberLabels($where);

if(empty($drp_team) && $store_info['drp_level'] == 1 || $drp_team){
    if($_GET['action'] == 'upload'){
        $logo = !empty($_POST['logo']) ? $_POST['logo'] : '';
        $_SESSION['drp_team'] = isset($_SESSION['drp_team']) ? $_SESSION['drp_team'] : array ();
        if (!empty($logo)) {
            if (!empty($drp_team)){
                $result = D('Drp_team')->where(array ('pigcms_id' => $drp_team['pigcms_id'],'store_id'=>$fx_one_info['store_id']))->data(array ('logo' => $logo))->save();
                if($result){
                    M('Drp_team')->setMembers($result);
                    $_SESSION['drp_team']['logo'] = $logo;
                    json_return(0, '团队logo上传成功');
                }
            }else if(empty($drp_team)){
                $data['logo'] = !empty($_POST['logo']) ? $_POST['logo'] : '';
                $data['store_id'] = $store_info['store_id'];
                $data['name'] = $store_info['name'];
                $data['supplier_id'] = $store_info['root_supplier_id'];
                $data['add_time'] = time();
                $result = D('Drp_team')->data($data)->add();
                if($result){
                    M('Drp_team')->setMembers($result);
                    $_SESSION['wap_drp_store']['drp_team_id'] = $result;
                    $_SESSION['wap_drp_store']['logo'] = $data['logo'];
                    json_return('0','添加成功');
                }
            }
        }else{
            json_return(1001, '团队logo上传失败');
        }
    }else if($_GET['action'] == 'edit'){
        $store_name = !empty($_POST['store_name']) ? $_POST['store_name'] : '';
        $intro = !empty($_POST['intro']) ? $_POST['intro'] : '';

        /* 更新店铺名 简介 */
        if($store_name || $intro){
            $result = D('Store')->where(array ('store_id' => $store_info['store_id']))->data(array ('name' => $store_name, 'intro' => $intro, 'date_edited' => time()))->save();
        }

        $seller_id = $store['store_id'];
        $data = array();
        if (!empty($_POST['team_name'])) {
            $name = trim($_POST['team_name']);
            $data['name'] = $name;
        }
        if (!empty($_POST['logo'])) {
            $logo = trim($_POST['logo']);
            $data['logo'] = $logo;
        }

        $team_id = intval(trim($_POST['team_id']));
        $member_labels = !empty($_POST['member_labels']) ? $_POST['member_labels'] : '';

        //供货商id
        $supplier_id = M('Store_supplier')->getSupplierId($seller_id);
        //团队基本信息
        if (isset($name) || isset($logo)) {
            if (empty($team_id)) { //新增
                $data['store_id'] = $seller_id;
                $data['supplier_id'] = $supplier_id;
                $data['add_time'] = time();
                $result = D('Drp_team')->data($data)->add();
                $team_id = $result;
                if ($team_id) {
                    $_SESSION['store']['drp_team_id'] = $team_id;
                    $result = D('Store')->where(array('store_id' => $store['store_id']))->data(array('drp_team_id' => $team_id))->save();
                    M('Drp_team')->setMembers($team_id);
                }
            } else { //更新
                $result = D('Drp_team')->where(array('pigcms_id' => $team_id))->data($data)->save();
            }
        }

        //成员标签
        if (!empty($member_labels)) {
            $drp_level = $store['drp_level'];
            foreach ($member_labels as $level => $member_label) {
                if (!empty($member_label)) {
                    if ($label = D('Drp_team_member_label')->where(array('team_id' => $team_id, 'store_id' => $store['store_id'], 'drp_level' => ($drp_level + $level)))->find()) {
                        $temp_result = D('Drp_team_member_label')->where(array('pigcms_id' => $label['pigcms_id']))->data(array('name' => $member_label))->save();
                    } else {
                        $temp_result = D('Drp_team_member_label')->data(array('team_id' => $team_id, 'store_id' => $store['store_id'], 'name' => $member_label, 'drp_level' => ($drp_level + $level)))->add();
                    }
                    if ($temp_result) {
                        $result2 = $temp_result;
                    }
                }
            }
        }

        if($result2 || $result || empty($result)){
            json_return('0', '保存成功');
        }
    }
} else {
    //
}


include display('drp_team_manage');
echo ob_get_clean();
