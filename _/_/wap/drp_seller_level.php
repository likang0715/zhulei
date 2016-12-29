<?php
/**
 * 分销商品
 * User: pigcms_21
 * Date: 2015/4/17
 * Time: 16:32
 */
require_once dirname(__FILE__) . '/global.php';

if ($_SESSION['wap_user']){
    $user = M('User');
    $wap_user = $_SESSION['wap_user'];
    $avatar = $user->getAvatarById($_SESSION['wap_user']['uid']);
}

if ($_SESSION['wap_drp_store']) {
    $store = $_SESSION['wap_drp_store'];
} else {
    pigcms_tips('您没有权限访问，<a href="./home.php?id=' . $_COOKIE['wap_store_id'] . '">返回首页</a>','none');
}

$now_store = D('Store')->where(array('store_id'=>$store['store_id']))->find();

//获取分销商等级
$sql = "SELECT pp.name as degree_name, s.drp_degree_id, pp.icon FROM " . option('system.DB_PREFIX') . "store s,".option('system.DB_PREFIX')."platform_drp_degree as pp,". option('system.DB_PREFIX') ."drp_degree as ppp WHERE s.drp_degree_id = ppp.pigcms_id and pp.pigcms_id = ppp.is_platform_degree_name and s.store_id =".$store['store_id'];
$degree = M('Store')->db->query($sql);
//获取供货商id
$supplier_chain = D('Store_supplier')->field('supply_chain')->where(array('seller_id'=>$now_store['store_id']))->find();
$supplier_ids = explode(',', $supplier_chain['supply_chain']);
$supplier_id = $supplier_ids['1'];

//供货商是否开启分销等级
$open_drp_degree = option('config.open_drp_degree');  //平台是否开启分销等级

if(!empty($open_drp_degree)){
    $supplier_open_drp_degree = D('Store')->field('open_drp_degree')->where(array('store_id'=>$supplier_id))->find();
    if(!empty($supplier_open_drp_degree)){
        $drp_degree = M("Drp_degree");

        $drp_degree_list = $drp_degree->getDrpDegrees(array('store_id'=>$supplier_id));
    }
}else{

}
//获取当前分销商下一级别
$degree_value = D('Drp_degree')->field('value')->where(array('is_platform_degree_name'=>$degree[0]['drp_degree_id']))->find();

$where = array();
$where['store_id'] = $supplier_id;
$where['value'] = array('>', $degree_value['value']);
$next_degree = M('Drp_degree')->getDrpDegree($where, 'value ASC');

$next_degree = array();
foreach ($drp_degree_list as $key => $tmp_degree) {
    if ($tmp_degree['pigcms_id'] == $now_store['drp_degree_id'] && !empty($drp_degree_list[$key + 1])) {
        $next_degree = $drp_degree_list[$key + 1];
        break;
    }
}

//获取当前店铺积分
$storePointcount = D('Store_user_data')->field('store_point_count')->where(array('store_id'=>$supplier_id,'uid'=>$wap_user['uid']))->find();

$storeUserData = $storePointcount['store_point_count'];

//当前店铺积分记录
$where = array();
$where['store_id']= $supplier_id;
$where['uid']= $wap_user['uid'];
$order = ' timestamp desc';
$points_record = D('Store_points')->order($order)->where($where)->select();

$store_supplier = M('Store_supplier');
$store_model    = M('Store');
$now_level = $now_store['drp_level'];

//同级分销商
$sql_one = "select * from " . option('system.DB_PREFIX') . "store s ," . option('system.DB_PREFIX') . "store_supplier ss where s.store_id = ss.seller_id and FIND_IN_SET({$supplier_id},supply_chain) AND ss.level =" .$now_level. " order by s.income desc";
$sellerBroth = $store_model->db->query($sql_one);
foreach($sellerBroth as $key => $seller){
    if($key == 0){
        $borth_max_income = $seller['income'];
    }
}

//下级分销
$sql_two = "select * from " . option('system.DB_PREFIX') . "store s ," . option('system.DB_PREFIX') . "store_supplier ss where s.store_id = ss.seller_id and FIND_IN_SET({$supplier_id},supply_chain) AND ss.level >" .$now_level. " order by s.income desc";
$sellerOther = $store_model->db->query($sql_two);
foreach($sellerOther as $key => $seller){
    if($key == 0){
        $other_max_income = $seller['income'];
    }
}

include display('drp_seller_level');

echo ob_get_clean();
