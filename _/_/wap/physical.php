<?php
/**
 *  订单信息
 */
require_once dirname(__FILE__).'/global.php';

$store_id = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误','none');

//店铺资料
$now_store = M('Store')->wap_getStore($store_id);
if(empty($now_store)) pigcms_tips('您访问的店铺不存在','none');

setcookie('wap_store_id',$now_store['store_id'],$_SERVER['REQUEST_TIME']+10000000,'/');

//当前页面的地址
$now_url = $config['wap_site_url'].'/physical.php?id='.$now_store['store_id'];

//门店列表
$store_physical = M('Store_physical')->getList($now_store['store_id']);
foreach($store_physical as $key => $r){
$store_physical[$key]['linkurl']=$config['wap_site_url'].'/physical_show.php?id='.$r['pigcms_id'];
 }

include display('physical');

echo ob_get_clean();
?>