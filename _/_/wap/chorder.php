<?php
/**
 *  订单信息
 */
require_once dirname(__FILE__).'/global.php';
if(!empty($_GET['del_id'])){
	if(empty($wap_user)) json_return(1000,'您尚未登录');
	$condition_order['id'] = intval($_GET['del_id']);
	$condition_order['uid'] = $wap_user['uid'];
	$condition_order['status'] = array('<','2');
	$database_order = D('Chahui_bm');
	$nowOrder = $database_order->field('`id`,`store_id`,`uid`,`status`')->where($condition_order)->find();
	if(empty($nowOrder)) redirect('./chorder.php?id='.$nowOrder['store_id'].'&action=all');
	$condition_save_order['id'] = $nowOrder['id'];
	$data_save_order['status'] = '4';
	$data_save_order['use_time'] = $_SERVER['REQUEST_TIME'];
	if($database_order->where($condition_save_order)->data($data_save_order)->save()){
				redirect('./chorder.php?id='.$nowOrder['store_uid'].'&action=all');
	}else{
		redirect('./chorder.php?id='.$nowOrder['store_id'].'&action=all');
	}
}else{
	if(empty($wap_user)) redirect('./login.php');
	$store_id = $_GET['id'];
	$page = max(1, $_GET['page']);
	$limit = 5;
	//店铺资料
	
	$action = isset($_GET['status']) ? $_GET['status'] : '';
	$uid = $wap_user['uid'];
	
	$where = array();
	$where['uid'] = $uid;
	if($store_id){
	$now_store = M('Store')->wap_getStore($store_id);
	if(empty($now_store)) pigcms_tips('您访问的店铺不存在','none');
	$where['store_id'] = $store_id;
	$page_url = 'chorder.php?id=' . $store_id . '&status=' . $action;
	
	}else{
	$page_url = 'chorder.php?status=' . $action.'&platform=1';
	
	}
	switch($action){
		case '1':
			$pageTitle = '待审核的报名';
			$where['status'] = 1;
			break;
		case '2':
			$pageTitle = '未通过的报名';
			$where['status'] = 2;
			break;
    	case '3':
			$pageTitle = '已通过的报名';
			$where['status'] = 3;
			break;
		default:
			$where['status'] = array('<', 4);
			$pageTitle = '全部预约';
	}
	
	$count = D('Chahui_bm')->where($where)->count('id');
	
	$orderList = array();
	$pages = '';
	if ($count > 0) {
		$page = min($page, ceil($count / $limit));
		$offset = ($page - 1) * $limit;
		
		$orderList = D('Chahui_bm')->where($where)->order('id desc')->limit($offset . ', ' . $limit)->select();

			
			 foreach ($orderList as $key => $value)
        {
	
		    $chahui = D('Chahui')->where(array('pigcms_id'=>$value['cid']))->find();
            $orderList[$key]['ch_name'] = $chahui['name'];
			$orderList[$key]['images'] = $chahui['images'];
			$orderList[$key]['address'] = $chahui['address'];
			$orderList[$key]['sttime']=date('Y-m-d H:i:s',$chahui['sttime']);
			$orderList[$key]['endtime']=date('Y-m-d H:i:s',$chahui['endtime']);
			$store = D('Store')->where(array('store_id'=>$chahui['store_id']))->find();
			$orderList[$key]['store_name'] = $store['name'];
        }

		// 分页
		import('source.class.user_page');
		$user_page = new Page($count, $limit, $page);
		$pages = $user_page->show();
	}

	//分享配置 start
	$share_conf 	= array(
		'title' 	=> $now_store['name'].'-茶会', // 分享标题
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
	include display('chorder');
}
echo ob_get_clean();
?>