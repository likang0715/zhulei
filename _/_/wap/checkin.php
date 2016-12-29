<?php
/**
 *  签到页面
 */

require_once dirname(__FILE__).'/global.php';

	$act = isset($_GET['act']) ? trim($_GET['act']) : 'checkin';
	if (empty($act)) {
		pigcms_tips('非法访问', 'none');
	}

	switch ($act) {

		case 'checkin':

			if (empty($wap_user)) {
				redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
			}

			$store_id = $_GET['store_id'];
			// if (empty($store_id) || !$storeInfo = D('Store')->where(array('drp_supplier_id'=>0, 'store_id'=>$store_id))->find()) {
			if (empty($store_id) || !$storeInfo = D('Store')->where(array('store_id'=>$store_id))->find()) {
				wap_error('不存在该店铺');
				// pigcms_tips('不存在该店铺', 'none');
			}

			// 分销商
			if ($storeInfo['root_supplier_id'] != 0) {	// 获取供货商店铺
				$store_id = $storeInfo['root_supplier_id'];
				$storeInfo = D('Store')->where(array('drp_supplier_id'=>0 , 'store_id'=>$store_id))->find();
			}

			// 获取今日积分配置
			$storePointsConfig = D('Store_points_config')->where(array('store_id'=>$store_id))->find();
			if (empty($storePointsConfig)) {
				wap_error('该店铺尚未做积分配置');
				// pigcms_tips('该店铺尚未做积分配置', 'none');
			}

			if (empty($storePointsConfig['sign_set'])) {
				wap_error('该店铺未开启签到');
				// pigcms_tips('该店铺未开启签到', 'none');
			}

			$maxSignPoint = 0;
			if ($storePointsConfig['sign_type'] == 1) {
				$maxSignPoint = $storePointsConfig['sign_plus_start'] + $storePointsConfig['sign_plus_addition']*($storePointsConfig['sign_plus_day'] - 1);
			}

			// 是否是该店铺分销商
			// $drpResult = M('Share_record')->is_drp_store($wap_user['uid'], $store_id);
			// $data['is_drp'] = $drpResult['is_drp'];
			// $data['seller_id'] = $drpResult['seller_id'];
			// if (!$data['is_drp']) {
			// 	pigcms_tips('你不是该店铺的分销商', 'none');
			// }

			// 查找今天是否已签到
			$time = time();
			$timestamp = strtotime(date('Y-m-d 00:00:00', $time));
			$whereSigned = array();
			$whereSigned['store_id'] = $store_id;
			$whereSigned['uid'] = $wap_user['uid'];
			$whereSigned['type'] = 5;
			$whereSigned['timestamp'] = array('>=', $timestamp);

			$data['is_checkin'] = 0;

			$user_points = D('User_points')->where($whereSigned)->find();
			if (!empty($user_points)) {
				$data['is_checkin'] = 1;
				$data['points'] = $user_points['points'];
			} else {

				$time = time();
				// 查找今天是否已送
				$timestamp = strtotime(date('Y-m-d 00:00:00', $time));
				$where = array();
				$where['store_id'] = $store_id;
				$where['uid'] = $uid;
				$where['type'] = 5;
				$where['timestamp'] = array('>=', $timestamp);

				$count = D('User_points')->where($where)->count('id');
				if ($count > 0) {
					return false;
				}

				// 今日积分数
				if ($storePointsConfig['sign_type'] == 0) {
					// 每日固定值增加
					$data['points'] = $storePointsConfig['sign_fixed_point'];
				} else if ($storePointsConfig['sign_type'] == 1) {
					// 不固定逻辑处理
					$store_user_data = M('Store_user_data')->getUserData($store_id, $wap_user['uid']);

					$days = $days = M('Store_user_data')->getUserSignDay($store_id, $wap_user['uid']);
					if ($days >= $storePointsConfig['sign_plus_day']) {
						$days = $storePointsConfig['sign_plus_day'] - 1;
					}
					$data['points'] = $storePointsConfig['sign_plus_start'] + ($days * $storePointsConfig['sign_plus_addition']);
				}

			}

			// 分享链接
			$data['share_link'] = M('Share_record')->createLink($store_id, $wap_user['uid']);
			include display('points_checkin');
			echo ob_get_clean();
			break;

		case 'single':					// 个人推广中心

			if (empty($wap_user)) {
				redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
			}

			$store_id = $_GET['store_id'];

			// if (empty($store_id) || !$storeInfo = D('Store')->where(array('drp_supplier_id'=>0, 'store_id'=>$store_id))->find()) {
			if (empty($store_id) || !$storeInfo = D('Store')->where(array('store_id'=>$store_id))->find()) {
				wap_error('不存在该店铺');
				// pigcms_tips('不存在该店铺', 'none');
			}

			// 获取供货商店铺
			if ($storeInfo['root_supplier_id'] != 0) {
				$store_id = $storeInfo['root_supplier_id'];
				$storeInfo = D('Store')->where(array('drp_supplier_id'=>0 , 'store_id'=>$store_id))->find();
			}

			/*// 获取今日积分配置
			$storePointsConfig = D('Store_points_config')->where(array('store_id'=>$store_id))->find();
			if (empty($storePointsConfig)) {
				wap_error('该店铺尚未做积分配置');
				// pigcms_tips('该店铺尚未做积分配置', 'none');
			}

			if (empty($storePointsConfig['sign_set'])) {
				wap_error('该店铺未开启签到');
				// pigcms_tips('该店铺未开启签到', 'none');
			}*/
            //echo $store_id;exit;
			// 是否是该店铺分销商
			$drpResult = M('Share_record')->is_drp_store($wap_user['uid'], $store_id);
			$data['is_drp'] = $drpResult['is_drp'];
			$data['seller_id'] = $drpResult['seller_id'];
			/*if (!$data['is_drp']) {
				wap_error('你不是该店铺的分销商');
				// pigcms_tips('你不是该店铺的分销商', 'none');
			}*/

			// 分享链接
			$data['share_link'] = M('Share_record')->createLink($store_id, $wap_user['uid']);

			include display('points_single');
			echo ob_get_clean();
			break;

		case 'ajax_checkin':		// 签到
			$store_id = isset($_POST['store_id']) ? intval($_POST['store_id']) : 0;
			
			if (empty($store_id)) {
				json_return(1, '缺少参数');
			}

			$uid = $wap_user['uid'];
			$drpResult = M('Share_record')->is_drp_store($uid, $store_id);

			//是否开启签到开关
			$storePointsConfig = D('Store_points_config')->where(array("store_id"=>$store_id))->find();
			if ($storePointsConfig['sign_set'] == 0) {
				json_return(1, '该店铺未开启签到');
			}

			//判断当前用户是否是该供货商的分销商
			if ($drpResult['is_drp']) {
				$checkResult = Points::sign($uid, $store_id, $drpResult['seller_id']);
			} else {
				$checkResult = Points::sign($uid, $store_id);
			}

			if ($checkResult === false) {
				json_return(1, '签到失败');
			}

			json_return(0, '签到成功');
			break;

		default:
			wap_error('非法访问');
			// pigcms_tips('非法访问', 'none');
			break;
	}



?>