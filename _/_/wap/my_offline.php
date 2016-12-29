<?php
/**
 *  订单信息
 */
require_once dirname(__FILE__).'/global.php';

if(empty($wap_user)) {
	redirect('./login.php?referer=' . urlencode($_SERVER['REQUEST_URI']));
}

// 当前用户登录UID
$current_uid = $wap_user['uid'];
$store_id = $_GET['store_id'];

if (empty($store_id)) {
	if (IS_AJAX) {
		json_return(1000, '缺少参数');
	} else {
		pigcms_tips('缺少参数');
	}
}

$store = M('Store')->getStoreById($store_id, $current_uid);
if (empty($store)) {
	if (IS_AJAX) {
		json_return(1000, '未找到相应店铺');
	} else {
		pigcms_tips('未找到相应店铺');
	}
}

// 操作分类
$action = $_GET['action'];
$action_arr = array('add', 'default');
if (!in_array($action, $action_arr)) {
	$action = 'default';
}

if ($action == 'default') {
	// 商品类别，直接用大分类
	$product_category_list_tmp = M('Product_category')->getAllCategory('', true);
	$product_category_list = array();
	foreach ($product_category_list_tmp as $product_category) {
		$tmp = array();
		$tmp['cat_id'] = $product_category['cat_id'];
		$tmp['cat_name'] = $product_category['cat_name'];
		$tmp['son_data'] = array();
		
		if (is_array($product_category['larray'])) {
			$son_product_category_arr = array();
			foreach ($product_category['larray'] as $son_product_category) {
				$son_tmp = array();
				$son_tmp['cat_id'] = $son_product_category['cat_id'];
				$son_tmp['cat_name'] = $son_product_category['cat_name'];
				
				$son_product_category_arr[] = $son_tmp;
			}
			
			$tmp['son_data'] = $son_product_category_arr;
		}
		
		$product_category_list[] = $tmp;
	}
	
	// 店铺用户
	$user = M('User')->getUserById($store['uid']);
	
	$share_conf = array(
			'title'    => $store['name'], // 分享标题
			'desc'     => str_replace(array("\r", "\n"), array('', ''), $nowProduct['intro']), // 分享描述
			'link'     => $config['wap_site_url'] . '/my_offline.php?store_id=' . $store['store_id'], // 分享链接
			'imgUrl'   => getAttachmentUrl($store['logo']), // 分享图片链接
			'type'     => '', // 分享类型,music、video或link，不填默认为link
			'dataUrl'  => '', // 如果type是music或video，则要提供数据链接，默认为空
			'store_id' => '',
			'uid'      => ''
	);
	
	import('WechatShare');
	$share = new WechatShare();
	$share_data = $share->getSgin($share_conf);
	
	$scan_qrcode_scenario = strtonumber(option('config.site_url') . '/card');
	include display('my_offline');
	echo ob_get_clean();
} else if ($action == 'add') {
	$uid = $_POST['uid'];
	$total = $_POST['total'];
	$cash = $_POST['cash'];
	$platform_point = $_POST['platform_point'];
	$cat_id = $_POST['cat_id'];
	$product_name = $_POST['product_name'];
	$number = max(1, $_POST['number']);
	$bak = $_POST['bak'];
	
	if (empty($uid) || empty($total) || empty($cat_id) || empty($product_name)) {
		json_return(1000, '缺少最基本的参数');
	}
	
	if ($uid == $wap_user['uid']) {
		json_return(1000, '不能给自己手工做单');
	}

	$package_id = $wap_user['package_id'];

	if($package_id > 0){ //店铺套餐--店铺每日做单限额 判断
		$package_store_point_total = D('Package')->where(array('pigcms_id'=>$package_id))->find();
		$package_store_point_total = $package_store_point_total['store_point_total'];
		if($package_store_point_total > 0 && option('credit.platform_credit_open')){
			$start_time = strtotime(date('Y-m-d 00:00:00'));
			$end_time = strtotime(date('Y-m-d 23:59:59'));
			$return_point = D('Order_offline')->where("store_id = '" . $store_id . "' AND check_status != 2 AND dateline >= '" . $start_time . "' AND dateline <= '" . $end_time . "'")->sum('return_point');
			
			$platform_credit_rule =  option('credit.platform_credit_rule');

			$tmp_return_point = $total * $platform_credit_rule;

			if ($return_point > $package_store_point_total || $tmp_return_point > $package_store_point_total || ($tmp_return_point+$return_point) > $package_store_point_total) {
				json_return(1000, '尊敬的用户,您今日做单额度已达上限，无法再次做单');
			}	
		}
	}else{
		// 检查是否超过今天限额
		if (option('config.store_point_total') > 0 && option('credit.platform_credit_open')) {
			$start_time = strtotime(date('Y-m-d 00:00:00'));
			$end_time = strtotime(date('Y-m-d 23:59:59'));
			
			$return_point = D('Order_offline')->where("store_id = '" . $store_id . "' AND check_status != 2 AND dateline >= '" . $start_time . "' AND dateline <= '" . $end_time . "'")->sum('return_point');

			$platform_credit_rule =  option('credit.platform_credit_rule');

			$tmp_return_point = $total * $platform_credit_rule;
					
			if ($return_point > option('config.store_point_total') || $tmp_return_point > option('config.store_point_total') || ($tmp_return_point+$return_point) > option('config.store_point_total') ) {
				json_return(1000, '尊敬的用户,您今日做单额度已达上限，无法再次做单');
			}
		}
	}
	
	$result = Offline::add($store_id, $uid, $total, $cash, $platform_point, $cat_id, $product_name, $number, $bak);
	
	json_return(0, $result['err_msg']);
	exit;
}
