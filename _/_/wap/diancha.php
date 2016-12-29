<?php

require_once dirname(__FILE__) . '/global.php';


$store_id = (isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误', 'none'));
$pigcms_id = isset($_GET['fid']) ? $_GET['fid'] : '';
$bid = isset($_GET['bid']) ? $_GET['bid'] : '';
$now_store = M('Store')->wap_getStore($store_id);
if (empty($now_store)) {
	pigcms_tips('您访问的店铺不存在', 'none');
}

setcookie('wap_store_id', $now_store['store_id'], $_SERVER['REQUEST_TIME'] + 10000000, '/');
$now_url = $config['wap_site_url'] . '/physical.php?id=' . $now_store['store_id'];
$store_physical = M('Store_physical')->getList($now_store['store_id']);
$where = array();
if (!empty($pigcms_id)) {
	//当前门店
	$store_xq = M('Store_physical')->getOne($pigcms_id);
 $where['physical_id'] = $pigcms_id;
} else {
foreach($store_physical as $value){
$store_xq = M('Store_physical')->getOne($value['pigcms_id']);
$where['physical_id'] = $value['pigcms_id'];
break;
}
}


$list = D('pigcms_meal_cz')->where($where)->order('`cz_id` DESC')->select();
//店铺导航
if($now_store['open_nav'] && !empty($now_store['use_nav_pages'])){
		$storeNav = M('Store_nav')->getParseNav($store_id, $store_id, $now_store['drp_diy_store']);
}
include display('diancha');
echo ob_get_clean();

?>
