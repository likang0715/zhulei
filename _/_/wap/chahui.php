<?php

require_once dirname(__FILE__) . '/global.php';

$store_id = isset($_GET['id']) ? $_GET['id'] : '';
$pigcms_id = isset($_GET['pigcmsid']) ? $_GET['pigcmsid'] : '';
if($store_id){
$now_store = M('Store')->wap_getStore($store_id);
}
setcookie('wap_store_id', $now_store['store_id'], $_SERVER['REQUEST_TIME'] + 10000000, '/');

$where =' 1=1 ';
$price=$_POST['price'];

switch($price)
	{
		case '1':
			$where .= ' AND price >0 AND price < 200 ';
			break;
		case '2':
			$where .= ' AND price >=200 AND price < 500 ';
			break;
		case '3':
			$where .= ' AND price >=500 AND price < 1000 ';
			break;
		case '4':
		
			$where .= "  AND price >= 1000 ";
			break;
	}
$time=$_REQUEST['time'];	

$y = date("Y");
$m = date("m");
$d = date("d");
$nowtime=mktime(0,0,0,$m,$d,$y);
switch($time)
	{
		case 'week':
		   $weektime=$nowtime+86400*7;
			$where .= " AND sttime >='$nowtime'   AND sttime <='$weektime'";
			break;
		case 'month':
		    $monthtime=$nowtime+86400*30;
			$where .= " AND sttime >='$nowtime'   AND sttime <='$monthtime'";
			break;
		case 'today':
		    $today=$nowtime+86400;
			$where .= " AND sttime >='$nowtime'   AND sttime <='$today'";
			break;
		case 'tomorrow':
		$today=$nowtime+86400;
		$tomorrow=$nowtime+86400*2;
		   $where .= " AND sttime >='$today'   AND sttime <='$tomorrow'";
			break;
		case 'weekend':
		   $where .= "  AND week = 1 ";
			break;
	}	
if($store_id){
$where .= ' AND store_id = '.$store_id;
}
$zt=$_REQUEST['zt'];
if($zt){
$where .= ' AND zt = '.$zt;
}
if($pigcms_id){
$where .= ' AND physical_id = '.$pigcms_id;
}

$page = max(1, $_GET['page']);
	
	   $limit = 6;
	   $count = D('Chahui')->where($where)->count('pigcms_id');
	   if ($count > 0) {
	    $pages = '';
		$total_pages = ceil($count / $limit);
		
		$page = min($page, $total_pages);
		$offset = ($page - 1) * $limit;
$list = D('Chahui')->where($where)->order('`sttime` DESC')->limit($offset.','.$limit)->select();
foreach($list as $key =>$r){
$store = M('Store')->wap_getStore($r['store_id']);
$list[$key]['logo']=$store['logo'];
$list[$key]['time']=date('m/d H:i',$r['sttime']);
$list[$key]['url']=$config['wap_site_url'] . '/chahui_show.php?id=' . $r['pigcms_id'];
}

		}
$category = D('Chahui_category')->where(array('cat_status' => 1))->select();
$sort='';
if($price){
$sort.='&price='.$price;
}
if($time){
$sort.='&time='.$time;
}
if($zt){
$sort.='&zt='.$zt;
}

//店铺导航
if($now_store['open_nav'] && !empty($now_store['use_nav_pages'])){

$storeNav = M('Store_nav')->getParseNav($store_id, $store_id, $now_store['drp_diy_store']);

}
include display('chahui');
echo ob_get_clean();

?>
