<?php
/**
 *  订单信息
 */
require_once dirname(__FILE__).'/global.php';

$pigcms_id = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误','none');

//门店列表
$store_physical = M('Store_physical')->getOne($pigcms_id);

$now_store = M('Store')->wap_getStore($store_physical['store_id']);

setcookie('wap_store_id',$now_store['store_id'],$_SERVER['REQUEST_TIME']+10000000,'/');

//当前页面的地址
$now_url = $config['wap_site_url'].'/physical_detail.php?id='.$now_store['store_id'];
$where['physical_id'] = $pigcms_id;
$list = D('pigcms_meal_cz')->where($where)->order('`cz_id` DESC')->select();
foreach($list as $key => $r){
$list[$key]['url']=$config['wap_site_url'].'/baoxiang.php?id='.$r['cz_id'];
 }

include display('physical_show');

echo ob_get_clean();
?>