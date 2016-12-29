<?php
/**
 * 检查二维码
 */

require_once dirname(__FILE__).'/global.php';

switch ($_GET['action']) {
	case 'store_scan':
		$store_id = $_POST['store_id'];
		$card = $_POST['card'];
		$scene = $_POST['scene'];
		
		if (empty($store_id) || empty($card) || empty($scene)) {
			json_return(1000, '扫一扫参数错误');
		}
		
		$check_scene = strtonumber(option('config.site_url') . '/card');
		if ($card != 2) {
			json_return(1000, '扫一扫只能扫描店铺做单二维码');
		}
		
		if ($scene != $check_scene) {
			json_return(1000, '扫码场景有误，请扫描本站的店铺做单二维码');
		}
		
		$store = D('Store')->where(array('store_id' => $store_id))->find();
		if (empty($store) || $store['status'] != 1) {
			json_return(1000, '未找到相应的店铺');
		}
		
		if ($store['drp_level'] > 0) {
			json_return(1000, '此店铺不支持扫一扫手工做单');
		}
		
		json_return(0, $store_id);
		exit;
		break;
	
}
