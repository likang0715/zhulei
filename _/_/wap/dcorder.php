<?php
/**
 *  订单信息
 */
require_once dirname(__FILE__).'/global.php';
if(!empty($_GET['del_id'])){
	if(empty($wap_user)) json_return(1000,'您尚未登录');
	$condition_order['order_id'] = intval($_GET['del_id']);
	$condition_order['uid'] = $wap_user['uid'];
	$condition_order['status'] = array('<','2');
	$database_order = D('Meal_order');
	$nowOrder = $database_order->field('`order_id`,`store_id`,`store_uid`,`status`')->where($condition_order)->find();
	if(empty($nowOrder)) redirect('./dcorder.php?id='.$nowOrder['store_id'].'&action=all');
	$condition_save_order['order_id'] = $nowOrder['order_id'];
	$data_save_order['status'] = '4';
	$data_save_order['use_time'] = $_SERVER['REQUEST_TIME'];
	if($database_order->where($condition_save_order)->data($data_save_order)->save()){
				redirect('./dcorder.php?id='.$nowOrder['store_uid'].'&action=all');
	}else{
		redirect('./dcorder.php?id='.$nowOrder['store_id'].'&action=all');
	}
}else{
	if(empty($wap_user)) redirect('./login.php');
	$store_id = $_GET['id'];
	$page = max(1, $_GET['page']);
	$limit = 5;
	//店铺资料
	
	
	$action = isset($_GET['action']) ? $_GET['action'] : 'all';
	$uid = $wap_user['uid'];
	
	$where = array();
	$where['uid'] = $uid;
	if($store_id){
	$now_store = M('Store')->wap_getStore($store_id);
	if(empty($now_store)) pigcms_tips('您访问的店铺不存在','none');
	$where['store_uid'] = $store_id;
	$page_url = 'dcorder.php?id=' . $store_id . '&action=' . $action;
	}else{
	$page_url = 'dcorder.php?action=' . $action.'&platform=1';
	}
	switch($action){
		case 'dsh':
			$pageTitle = '待审核的预约';
			$where['status'] = 1;
			break;
		case 'dxf':
			$pageTitle = '待消费的预约';
			$where['status'] = 2;
			break;
    	case 'suc':
			$pageTitle = '已完成的预约';
			$where['status'] = 3;
			break;
		case 'cancel':
			$pageTitle = '已取消的预约';
			$where['status'] = 4;
			break;
		default:
			$where['status'] = array('<', 5);
			$pageTitle = '全部预约';
	}
	
	$count = D('Meal_order')->where($where)->count('order_id');
	
	$orderList = array();
	$pages = '';
	if ($count > 0) {
		$page = min($page, ceil($count / $limit));
		$offset = ($page - 1) * $limit;
		
		$orderList = D('Meal_order')->where($where)->order('order_id desc')->limit($offset . ', ' . $limit)->select();

			
			 foreach ($orderList as $key => $value)
        {
         	

		   $physical =  D('Store_physical')->where(array('pigcms_id'=>$value['physical_id']))->find();
			
			
            $orderList[$key]['store_name'] = $physical['name'];
			$orderList[$key]['images'] = $physical['images'];
        }

		// 分页
		import('source.class.user_page');
		$user_page = new Page($count, $limit, $page);
		$pages = $user_page->show();
	}

	//分享配置 start
	$share_conf 	= array(
		'title' 	=> $now_store['name'].'-点茶预约', // 分享标题
		'desc' 		=> str_replace(array("\r","\n"), array('',''),  $now_store['intro']), // 分享描述
		'link' 		=> 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], // 分享链接
		'imgUrl' 	=> $now_store['logo'], // 分享图片链接
		'type'		=> '', // 分享类型,music、video或link，不填默认为link
		'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
	);
	import('WechatShare');
	$share 		= new WechatShare();
	$shareData 	= $share->getSgin($share_conf);
	//分享配置 end
$noFooterLinks =1 ;
	// dump($orderList);
	include display('dcorder');
}

echo ob_get_clean();
?>