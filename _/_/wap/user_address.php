<?php
/**
 * 分销用户中心
 * User: pigcms_21
 * Date: 2015/4/18
 * Time: 14:35
 */
require_once dirname(__FILE__).'/global.php';

/*if ($_SESSION['wap_drp_store']) {
    $store = $_SESSION['wap_drp_store'];
} else {
    redirect('./ucenter.php?id=' . intval(trim($_COOKIE['wap_store_id'])));
}*/

$wap_user = $_SESSION['wap_user'];

$address_list = M('User_address')->db->where(array('uid'=>$wap_user['uid']))->order('`default` DESC,`address_id` ASC')->select();
if(!empty($address_list)){
    import('area');
    $areaClass = new area();
    foreach($address_list as &$value){
        $value['province_txt'] = $areaClass->get_name($value['province']);
        $value['city_txt'] 	= $areaClass->get_name($value['city']);
        $value['area_txt'] 	= $areaClass->get_name($value['area']);
    }
}
/*var_dump($address_list);*/
include display('user_address');
echo ob_get_clean();
