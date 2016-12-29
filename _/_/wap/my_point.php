<?php
/**
 *  平台币
 */
require_once dirname(__FILE__).'/global.php';

if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));

$action = $_REQUEST['action'] ? $_REQUEST['action'] : 'pingtai';
$user_info = D('User')->where("uid='" . $wap_user['uid'] . "'")->find();

//获取套餐信息 
import('source.class.PackageConfig');
$package_id = $user_info['package_id'];

if($package_id > 0){

	$package_val = D('Rbac_package')->where(array('pid'=>$package_id))->find();
	$rbac_val_arr = explode(',',$package_val['rbac_val']);
	//检查是否有线下做单权限
	$access_offline_index_id = PackageConfig::chk_offline_access('offline','offline_index');
	$access_offline_list_id =  PackageConfig::chk_offline_access('offline','offline_list');

	$access_offline_index = in_array($access_offline_index_id, $rbac_val_arr)?1:0;
	$access_offline_list = in_array($access_offline_list_id, $rbac_val_arr)?1:0;

}else{
	$access_offline_index = 1;
	$access_offline_list = 1;
}




$setting = D('Credit_setting')->find();
$platform_credit_name = $setting['platform_credit_name'] ? $setting['platform_credit_name'] : '平台币';

import('source.class.Margin');
$point_alias = Margin::point_alias();

$platform_credit_open = $setting['platform_credit_open'];

//模板
$display = 'index_mypoint';
switch($action) {
	//用户平台积分详细
	case 'udetaiil':

		$allow_num = 6;

		$where['_string'] = " upl.uid=".$wap_user['uid'];

		//类型
		if (isset($_REQUEST['type'])) {
			$type = trim($_REQUEST['type']);
			$where['_string'] .= " AND upl.type IN (" . $type . ")";
		}

		if (!empty($_POST['start_time']) && !empty($_POST['stop_time'])) {
            $start_time = strtotime($_POST['start_time']);
            $stop_time  = strtotime($_POST['stop_time']);
            $where['_string'] .= " AND upl.add_time >= " . $start_time . " AND upl.add_time <= " . $stop_time;
            $count_where['_string'] = "add_time >= " . $start_time . " AND add_time <= " . $stop_time;
        } else if (!empty($_POST['start_time'])) {
            $start_time = strtotime($_POST['start_time']);  
            $where['_string'] .= " AND upl.add_time >= " . $start_time;
            $count_where['add_time'] = array('>=', $start_time);
        } else if (!empty($_POST['stop_time'])) {
            $stop_time = strtotime($_POST['stop_time']);
            $where['_string'] .= " AND upl.add_time <= " . $stop_time;
            $count_where['add_time'] = array('<=', $stop_time);
        }

        if (!empty($_REQUEST['channel'])) {
			$channel = $_REQUEST['channel'];
           	if ($channel == 1) {
				$where['_string'] .= " AND upl.channel = 0";
           	 	$count_where['channel'] = '0';
           	} else if($channel == 2) {
           	 	$where['_string'] .= " AND upl.channel = 1";
           	 	$count_where['channel'] = '1';
           	} else if ($channel == 3) { //用户积分抵现订单金额
				$where['_string'] .= " AND upl.order_offline_id = 0";
				$count_where['order_offline_id'] = 0;
			} else if ($channel == 4) { //商家用户积分抵保证金
				$where['_string'] .= " AND upl.channel = 1 AND upl.order_offline_id > 0";
				$count_where['channel'] = '1';
				$count_where['order_offline_id'] = array('>', 0);
			}
        }

        $count_where['uid'] = $wap_user['uid'];


		$log_count = D('User_point_log')->where($count_where)->count('pigcms_id');
	    if($log_count > $allow_num){
	        $has_more = 1;
	    }else{
	        $has_more = 0;
	    }


	    if($_REQUEST['ajax'] == '1') {
		     $allow_num = intval($_POST['allow_num']);
		     $start_num = intval($_POST['start_log_num']);
		     $limit = $start_num.','.$allow_num;
		}else{
			 $limit = $allow_num;
		}
		
	    if($log_count) {
	    	
			$user_point_log_list = D('') -> table('User_point_log upl')
			-> join("Order o On upl.order_id = o.order_id","LEFT")
			-> where(array('uid'=>$wap_user['uid']))
			-> where($where)
			-> field("upl.*,o.order_no,upl.order_no as order_no2")
			-> order('upl.pigcms_id DESC')
			-> limit($limit)
			-> select();
		}

		if (!empty($user_point_log_list)) {
			foreach ($user_point_log_list as &$user_point_log) {
				if (empty($user_point_log['order_no'])) {
					$user_point_log['order_no'] = $user_point_log['order_no2'];
				}
			}
		}
		
		$point_type_arr = array(
				'消费获赠积分',
				'消费抵现积分',
				'退货返还积分',
				'取消订单返还积分',
				'商家积分转可用积分',
				'积分赠他人',
				'他人赠积分',
				'平台发放积分',
			);

		if($_REQUEST['ajax'] == '1') {
			$return_arr = array('user_point_log_list'=>$user_point_log_list,'has_more'=>$has_more,'record_count'=>count($user_point_log_list),'log_count'=>$log_count);
			json_return(0,$return_arr);
		}

		$display = 'my_point_udetail';
		$page_url = 'my_point.php?action=' . $action . '&ajax=1';

		$record_count = count($user_point_log_list);

		break;

	//赠送积分
	case 'give':

		$check_give_point = Margin::check_give_point();
		//服务费
		$give_point_service_fee = option('credit.give_point_service_fee');
		//扫码场景
		$scan_qrcode_scenario = strtonumber(option('config.site_url') . '/card');

		if (IS_AJAX) {
			//搜索用户
			if ($_POST['type'] == 'search_user') {
				$phone = !empty($_POST['phone']) ? trim($_POST['phone']) : '';
				$uid = !empty($_POST['uid']) ? trim($_POST['uid']) : 0;
				if (empty($phone) && empty($uid)) {
					json_return(1001, '请先使用手机号或扫一扫选择获赠用户');
				}
				if (!empty($phone)) {
					$where['phone'] = $phone;
				}
				if (!empty($uid)) {
					if ($_POST['card'] != 1 && $_POST['card'] != 2) {
						json_return(1005, '扫一扫只能扫描用户的会员卡的条形码或二维码');
					}
					if ($scan_qrcode_scenario != $_POST['scene']) {
						json_return(1006, '扫码场景有误，请扫描本站其它用户的会员卡');
					}
					$where['uid'] = $uid;
				}
				$user = D('User')->field('uid,nickname,phone,point_unbalance')->where($where)->order('uid DESC')->find();
				if (empty($user)) {
					json_return(1002, '选择的获赠用户不存在');
				}
				//赠送与获赠是同一用户
				if ($user['uid'] == $user_info['uid']) {
					json_return(1003, '无效获赠用户');
				}

				json_return(0, $user);

			} else if ($_POST['type'] == 'give_point') { //赠送积分
				$give_uid = !empty($_POST['give_uid']) ? intval(trim($_POST['give_uid'])) : 0;
				$give_point = !empty($_POST['give_point']) ? floatval(trim($_POST['give_point'])) : 0;
				$get_user = !empty($_POST['get_user']) ? $_POST['get_user'] : '';
				$card = !empty($_POST['card']) ? $_POST['card'] : '';
				$scene = !empty($_POST['scene']) ? $_POST['scene'] : '';

				if (empty($give_uid)) {
					json_return(1001, '请先使用手机号或扫一扫选择获赠用户');
				}
				if ($get_user == 'scan') {
					if ($card != 1 && $card != 2) {
						json_return(1007, '扫一扫只能扫描用户的会员卡的条形码或二维码');
					}
					if ($scan_qrcode_scenario != $scene) {
						json_return(1008, '扫码场景有误，请扫描本站其它用户的会员卡');
					}
				}
				//获赠用户
				$give_user = D('User')->field('uid,nickname,point_balance,point_unbalance')->where(array('uid' => $give_uid))->find();
				if (empty($give_user)) {
					json_return(1002, '选择的获赠用户不存在');
				}
				//赠送与获赠是同一用户
				if ($give_user['uid'] == $user_info['uid']) {
					json_return(1003, '无效获赠用户');
				}
				if ($give_point > $user_info['point_unbalance']) {
					json_return(1006, '可赠送的' . $point_alias . '不足');
				}
				// 检查获获赠用户现有平台积分是否大于限赠额
				if (option('credit.platform_credit_open') && option('config.user_point_total') > 0 && $give_user['point_balance'] + $give_user['point_unbalance'] >= option('config.user_point_total')) {
					json_return(1000, '获赠用户的积分过多，暂停赠送');
				}
				
				//用户名
				$give_user['nickname'] = !empty($give_user['nickname']) ? $give_user['nickname'] : '他人';
				$user_info['nickname'] = !empty($user_info['nickname']) ? $user_info['nickname'] : '他人';
				//计算服务费
				$give_point_service_fee = $give_point * ($give_point_service_fee / 100);
				$give_point_service_fee = number_format($give_point_service_fee, 2, '.', '');
				//实际赠送积分
				$real_give_point = $give_point - $give_point_service_fee;
				$real_give_point = number_format($real_give_point, 2, '.', '');

				//更新用户积分池剩余
				Margin::user_point_log($user_info['uid'], 0, 0, (0 - $give_point), 1, 5, '赠' . $give_user['nickname'] . '积分', 0, '', false, false, true, false, true, false);
				Margin::user_point_log($give_uid, 0, 0, $real_give_point, 1, 6, $user_info['nickname'] . '赠积分', 0, '', true, false, true, false, false, true);
				//更新平台积分收入
				if ($give_point_service_fee > 0) {
					Margin::platform_point_log($give_point_service_fee, 1, 2, '积分互赠服务费', 0, 0, '', true);
				}

				json_return(0, '我的' . $point_alias . '已赠送成功');
			}

			json_return(1005, '缺少访问参数');
		}

		if (empty($check_give_point)) {
			pigcms_tips('访问的页面不存在');
		}

		$user = $user_info;
		$avatar = $wap_user['avatar'] ? $wap_user['avatar']:getAttachmentUrl('images/touxiang.png', false);

		$display = 'my_point_give';
		break;

	//平台积分兑换
	case 'exchange':
		import('source.class.Margin');

		$store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
		Margin::init($store_id);
		$point_alias = Margin::point_alias();

		if (IS_POST) {
			$point = !empty($_POST['point']) ? floatval($_POST['point']) : 0;
			$type = !empty($_POST['type']) ? strtolower(trim($_POST['type'])) : '';
			if (empty($point)) {
				json_return(1001, '输入的积分无效');
			}
			if (empty($type)) {
				json_return(1002, '缺少必要的参数');
			}
			$store = D('Store')->field('store_id,uid,point_balance')->where(array('store_id' => $store_id))->find();
			if (empty($store)) {
				json_return(1003, '店铺不存在');
			}
			if ($point > $store['point_balance']) {
				json_return(1005, '店铺' . $point_alias . '不足');
			}
			if ($type == 'exchange') { //积分兑换
				//兑换店铺积分
				Margin::store_point_log(0 - $point, 1, 2, '积分变现', 0, '', '', 0, false, true, false);
				json_return(0, '兑换成功');
			} else if ($type == 'transfer') { //积分转移
				//转移店铺积分
				Margin::store_point_log(0 - $point, 1, 5, '兑换用户积分', 0, '', '', 0, false, true);

				json_return(0, '转移成功');
			} else {
				json_return(1002, '缺少必要的参数');
			}
		}

		//变现服务费
		$point2money_rate = option('credit.storecredit_to_money_charges');
		$point2money_rate = number_format($point2money_rate, 2, '.', '');

		$user = D('User')->field('point_balance')->where(array('uid' => $store['uid']))->find();

		$display = 'my_point_exchange';
		break;

	case 'release': //释放用户平台积分流水
		if (IS_POST) {
			$page = max(1, $_REQUEST['page']);
			$limit = 6;

			$where = array();
			$where['uid'] = $user_info['uid'];
			if (!empty($_POST['start_time']) && !empty($_POST['end_time'])) {
				$start_time = strtotime($_POST['start_time'] . ' 00:00:00');
				$end_time = strtotime($_POST['end_time'] . ' 23:59:59');
				$where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $end_time . "'";
			} else if (!empty($_POST['start_time'])) {
				$start_time = strtotime($_POST['start_time'] . ' 00:00:00');
				$where['_string'] = "add_time >= '" . $start_time . "'";
			} else if (!empty($_POST['end_time'])) {
				$end_time = strtotime($_POST['end_time'] . ' 23:59:59');
				$where['_string'] = "add_time <= '" . $end_time . "'";
			}

			$release_count = D('Release_point_log')->where($where)->count('pigcms_id');
			$page = min($page, ceil($release_count / $limit));
			$offset = abs(($page - 1) * $limit);
			$releases = D('Release_point_log')->where($where)->order('pigcms_id DESC')->limit($offset . ',' . $limit)->select();

			if (!empty($releases)) {
				foreach ($releases as &$release) {
					$release['add_time'] = date('m-d H:i:s', $release['add_time']);
					$release['send_point'] = number_format($release['send_point'], 2, '.', '');
				}
			}
			$json_return = array();
			$json_return['noNextPage'] = true;
			$json_return['list'] = $releases;
			$json_return['max_page'] = ceil($release_count / $limit);
			json_return(0, $json_return);
		}
		$display = 'my_point_release';
		break;

	case 'store_point': //店铺平台积分
		import('source.class.Margin');

		$store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
		$store = D('Store')->field('store_id,name,point_balance,margin_balance,point2user,point2money')->where(array('store_id' => $store_id))->find();

		if (IS_AJAX) {
			if ($_GET['ajax'] == 1) {
				if (empty($store)) {
					json_return(1001, '店铺不存在');
				}

				$page = max(1, $_REQUEST['page']);
				$limit = 6;
				$log_count = D('Store_point_log')->where(array('store_id' => $store_id))->count('pigcms_id');
				$page = min($page, ceil($log_count / $limit));
				$offset = abs(($page - 1) * $limit);

				$store_point_logs = D('Store_point_log')->where(array('store_id' => $store_id))->order('pigcms_id DESC')->limit($offset . ',' . $limit)->select();
				if (!empty($store_point_logs)) {
					foreach ($store_point_logs as &$store_point_log) {
						$store_point_log['add_time'] = date('Y-m-d H:i:s', $store_point_log['add_time']);
					}
				}

				$json_return = array();
				$json_return['noNextPage'] = true;
				$json_return['list'] = array();
				$json_return['max_page'] = ceil($log_count / $limit);
				json_return(0, $json_return);
			}

			json_return(1002, '缺少访问参数');
		}

		if (empty($store)) {
			pigcms_tips('店铺不存在');
		}

		$point_alias = Margin::point_alias();

		$display = 'my_store_point';
		break;

	case 'store_point_used': //店铺平台积分
		import('source.class.Margin');

		$store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
		$store = D('Store')->field('store_id,name,point_balance,margin_balance,point2user,point2money')->where(array('store_id' => $store_id))->find();

		if (isset($_REQUEST['type'])) {
			$type = intval(trim($_REQUEST['type']));
		}

		if (isset($_REQUEST['target'])) {
			$target = trim($_REQUEST['target']);
		}

		if (IS_AJAX) {
			if ($_GET['ajax'] == 1) {
				if (empty($store)) {
					json_return(1001, '店铺不存在');
				}

				$where = array();
				$where['store_id'] = $store_id;
				if (isset($type)) {
					$type_arr = array($type);
					$where['type'] = array('in', array($type));
				} else {
					$where['type'] = array('in', array(0,2,4,5));
					$where['point'] = array('<', 0);
				}


				//商家用户积分抵服务费
				if ($target == 'service_fee' && $type == 0) {
					$where['order_offline_id'] = array('>', 0);
				}

				$page = max(1, $_REQUEST['page']);
				$limit = 6;
				$log_count = D('Store_point_log')->where($where)->count('pigcms_id');
				$page = min($page, ceil($log_count / $limit));
				$offset = abs(($page - 1) * $limit);

				$store_point_logs = D('Store_point_log')->where($where)->order('pigcms_id DESC')->limit($offset . ',' . $limit)->select();
				if (!empty($store_point_logs)) {
					foreach ($store_point_logs as &$store_point_log) {
						$store_point_log['add_time'] = date('Y-m-d H:i:s', $store_point_log['add_time']);
					}
				}

				$json_return = array();
				$json_return['noNextPage'] = true;
				$json_return['list'] = $store_point_logs;
				$json_return['max_page'] = ceil($log_count / $limit);
				json_return(0, $json_return);
			}

			json_return(1002, '缺少访问参数');
		}

		if (empty($store)) {
			pigcms_tips('店铺不存在');
		}

		$point_alias = Margin::point_alias();

		$title = '已消耗商家积分流水';
		if ($type == 2 && $target == 'point') {
			$title = '累计转可用积分';
		} else if ($type == 2 && $target == 'amount') {
			$title = '累计转可提现金额';
		} else if ($type == 2 && $target == 'service_fee') {
			$title = '累计已扣兑现服务费';
		} else if ($type == 0 && $target == 'service_fee') {
			$title = '累计商家积分转做单';
		}
		$display = 'my_store_point_used';
		break;

	case 'user_point': //用户平台积分
		import('source.class.Margin');

		$store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
		$store = D('Store')->field('uid,store_id,name,point_balance,margin_balance,point2user,point2money')->where(array('store_id' => $store_id))->find();

		if (IS_AJAX) {
			if ($_GET['ajax'] == 1) {
				if (empty($store)) {
					json_return(1001, '店铺不存在');
				}

				$page = max(1, $_REQUEST['page']);
				$limit = 6;
				$log_count = D('User_point_log')->where(array('uid' => $store['uid']))->count('pigcms_id');
				$page = min($page, ceil($log_count / $limit));
				$offset = abs(($page - 1) * $limit);

				$user_point_logs = D('User_point_log')->where(array('uid' => $store['uid']))->order('pigcms_id DESC')->limit($offset . ',' . $limit)->select();
				if (!empty($user_point_logs)) {
					foreach ($user_point_logs as &$user_point_log) {
						$user_point_log['add_time'] = date('Y-m-d H:i:s', $user_point_log['add_time']);
					}
				}

				$json_return = array();
				$json_return['noNextPage'] = true;
				$json_return['list'] = $user_point_logs;
				$json_return['max_page'] = ceil($log_count / $limit);
				json_return(0, $json_return);
			}

			json_return(1002, '缺少访问参数');
		}

		if (empty($store)) {
			pigcms_tips('店铺不存在');
		}

		$point_alias = Margin::point_alias();

		$user = D('User')->field('point_balance,point_unbalance,point_used')->where(array('uid' => $store['uid']))->find();

		$display = 'my_user_point';
		break;

	//平台积分
	case 'pingtai':
		import('source.class.Margin');

		$page_url = 'my_point.php?action=' . $action . '&ajax=1';
		
		
		$page = max(1, $_REQUEST['page']);
		$limit = 6;
		$count = D('User_point_log')->where(array('uid'=>$wap_user['uid']))->count('pigcms_id');
		
		$page = min($page, ceil($count / $limit));
		$offset = ($page - 1) * $limit;
		$user_point_log = array();
		$user_point_log_list = array();
		if($count) {
			$user_point_log_list = D('') -> table('User_point_log upl')
			-> join("Order o On upl.order_id = o.order_id","LEFT")
			-> where(array('uid'=>$wap_user['uid']))
			-> where("upl.uid =".$wap_user['uid'])
			-> field("upl.*,o.order_no,upl.order_no as order_no2")
			-> order('upl.pigcms_id DESC')
			-> limit($offset, $limit)
			-> select();
		}

		if (!empty($user_point_log_list)) {
			foreach ($user_point_log_list as &$user_point_log) {
				if (empty($user_point_log['order_no'])) {
					$user_point_log['order_no'] = $user_point_log['order_no2'];
				}
			}
		}

		if($_REQUEST['ajax'] == '1') {
		
			if(count($user_point_log_list) < $limit){
				$json_return['noNextPage'] = true;
			}
			$json_return['list'] = $user_point_log_list;
			$json_return['max_page'] = ceil($count / $limit);
			json_return(0, $json_return);
		
		
		}
		
		$point_log = D('Pigcms_release_point_log')->where(array('uid'=>$wap_user['uid']))->find();

		$check_give_point = Margin::check_give_point();
		
		$share_conf = array(
				'title'    => $user_info['nickname'], // 分享标题
				'desc'     => str_replace(array("\r", "\n"), array('', ''), $user_info['nickname']), // 分享描述
				'link'     => $config['wap_site_url'] . '/my_point.php', // 分享链接
				'imgUrl'   => '', // 分享图片链接
				'type'     => '', // 分享类型,music、video或link，不填默认为link
				'dataUrl'  => '', // 如果type是music或video，则要提供数据链接，默认为空
				'store_id' => '',
				'uid'      => ''
		);
		
		import('WechatShare');
		$share = new WechatShare();
		$share_data = $share->getSgin($share_conf);
		
		$scene = strtonumber(option('config.site_url') . '/card');
		break;
		
	//推广积分（平台）
	case 'tuiguang':
		
		//Platform_user_points_log
		$page_url = 'my_point.php?action=tuiguang&ajax=1';
		
		$page = max(1, $_REQUEST['page']);
		$limit = 6;
		$count = D('Platform_user_points_log')->where(array('user_id'=>$wap_user['uid']))->field("count('id') count")->find();
		$count = $count['count'] ? $count['count'] : 0;

		$page = min($page, ceil($count / $limit));
		$offset = ($page - 1) * $limit;
		$user_point_log = array();
		if($count) {
			$user_point_log_list = D('') -> table('Platform_user_points_log ppl')
			-> where(array('user_id'=>$wap_user['uid']))
			-> field("ppl.*")
			-> limit($offset, $limit)
			-> select();
			
			$order_id_arr = array();
			$order_arr = array();
			foreach($user_point_log_list as $k => $v) {
				if($v['type'] == 3) {
					$order_id_arr[] = $v['order_id'];
				}
			}
			
			if(count($order_id_arr)) {
				$order_arr_info = D('Order')->where(array('order_id'=>array('in',$order_id_arr)))->select();
				foreach($order_arr_info as $k=>$v) {
					$order_arr[$v['order_id']] = $v;
				}
			}
			
		}
		
		if($_REQUEST['ajax'] == '1') {

			if(count($user_point_log_list) < $limit){
				$json_return['noNextPage'] = true;
			}
			$json_return['list'] = $user_point_log_list;
			$json_return['order_list'] = $order_arr;
			$json_return['max_page'] = ceil($count / $limit);
			json_return(0, $json_return);


		}
		
		$point_log = D('Pigcms_release_point_log')->where(array('uid'=>$wap_user['uid']))->find();		
		
		$display = 'my_point_tuiguang';
		break;

}


$avatar = $wap_user['avatar'] ? $wap_user['avatar']:getAttachmentUrl('images/touxiang.png', false);

$now = date('Y-m-d H:i:s');

$store_id = intval($_GET['store_id']);

$my_stores = D('Store')->where(array('uid' => $wap_user['uid'],'root_supplier_id'=>0))->select();

if(!empty($store_id)){
	$store = D('Store')->where(array('uid' => $wap_user['uid'],'store_id'=>$store_id,'root_supplier_id'=>0))->order('store_id ASC')->find();
}else{
	$store = D('Store')->where(array('uid' => $wap_user['uid'],'root_supplier_id'=>0))->order('store_id ASC')->find();
}

if($store){
	$store_id = $store['store_id'];
	$store['point2money_total'] = number_format($store['point2money_total'] + $store['point2money_service_fee'], 2, '.', '');
	$store['point_balance'] = number_format($store['point_balance'], 2, '.', '');

	//已提现
	$store['withdrawal_amount'] = number_format($store['withdrawal_amount'], 2, '.', '');


	//已使用积分 = 已变现积分 + 转用户积分 + 线下做单代扣积分
	$store['point_used'] = $store['point2money'] + $store['point2user'] + $store['cash_point'];
	$store['point_used'] = number_format($store['point_used'], 2, '.', '');
	//今日新增店铺积分
	$start_time = strtotime(date('Y-m-d') . '00:00:00');
	$end_time = time();
	$where = array();
	$where['store_id'] = $store['store_id'];
	$where['status'] = 1;
	$where['_string'] = "add_time >= " . $start_time . " AND add_time <= " . $end_time;
	$today_point = D('Store_point_log')->where($where)->sum('point');
	$today_point = ($today_point > 0) ? $today_point : 0;
	$store['today_point'] = number_format($today_point, 2, '.', '');
	//已消耗充值金额
	$margin_used = $store['margin_total'] - $store['margin_balance'];
	$margin_used = ($margin_used > 0) ? $margin_used : 0;
	$store['margin_used'] = number_format($margin_used, 2, '.', '');

	$store['logo'] = !empty($store['logo']) ? getAttachmentUrl($store['logo'], false) : option('config.site_url') . '/static/images/default_shop.png';

	//累计商家积分转做单
	$store_point_order = D('Store_point_log')->where(array('store_id' => $store['store_id'], 'order_offline_id' => array('>', 0)))->sum('point');
	$store_point_order = !empty($store_point_order) ? abs($store_point_order) : 0;
	$store['store_point_order'] = number_format($store_point_order, 2, '.', '');

	//用户可用积分已做单（商家）
	$offline_order_point = D('User_point_log')->where(array('uid' => $store['uid'], 'order_offline_id' => array('>', 0), 'point' => array('<', 0)))->sum('point');
	$offline_order_point = !empty($offline_order_point) ? abs($offline_order_point) : 0;
	$store['offline_order_point'] = number_format($offline_order_point, 2, '.', '');

	//商家转可用积分
	$store['point2user'] = number_format($store['point2user'], 2, '.', '');
}

//用户可用平台积分总额
$point_balance_total = $user_info['point_balance'] + $user_info['point_used'];
$user_info['point_balance_total'] = number_format($point_balance_total, 2, '.', '');
//用户今天新增平台积分
$today_user_point = D('User_point_log')->where(array('uid' => $wap_user['uid'],'type'=>array('in',array(0,2,3,4,6)), 'status' => 1,'add_date'=>date('Ymd')))->sum('point');
$today_user_point = ($today_user_point > 0) ? $today_user_point : 0;
$user_info['today_user_point'] = number_format($today_user_point, 2, '.', '');

//用户平台积分今日发放点数
$where = array();
$where['uid'] = $wap_user['uid'];
$where['add_date'] = date('Ymd');
$today_send_point = D('Release_point_log')->where($where)->order('pigcms_id DESC')->find();
$today_send_point = !empty($today_send_point) ? $today_send_point['send_point'] : 0;
$user_info['today_send_point'] = number_format($today_send_point, 2, '.', '');

//今日新增可用平台积分(用户)
$where = array();
$where['uid'] = $wap_user['uid'];
$where['add_date'] = date('Ymd');
$today_point_balance = D('Release_point_log')->where($where)->sum('point');
$today_point_balance = ($today_point_balance > 0) ? $today_point_balance : 0;
$user_info['today_point_balance'] = number_format($today_point_balance, 2, '.', '');

//累计已释放消费积分
$user_info['release_point'] = D('Release_point_log')->where(array('uid' => $user_info['uid'], 'add_time' => array('<=', time())))->sum('point');
$user_info['release_point'] = number_format($user_info['release_point'], 2, '.', '');

//可用积分已兑换商品
$user_info['point2product'] = $user_info['point_used'];
if (!empty($store['offline_order_point'])) {
	$user_info['point2product'] -= $store['offline_order_point'];
}
$user_info['point2product'] = ($user_info['point2product'] > 0) ? number_format($user_info['point2product'], 2, '.', '') : '0.00';

//购物返积分总额
$user_info['shopping_point_total'] = number_format($user_info['point_total'] - $user_info['point_received'], 2, '.', '');

//分享配置 start  
$share_conf 	= array(
	'title' 	=> option('config.site_name').'-'.$platform_credit_name, // 分享标题
	'desc' 		=> str_replace(array("\r","\n"), array('',''),   option('config.seo_description')), // 分享描述
	'link' 		=> 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], // 分享链接
	'imgUrl' 	=> option('config.site_logo'), // 分享图片链接
	'type'		=> '', // 分享类型,music、video或link，不填默认为link
	'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);
//分享配置 end

include display($display);

echo ob_get_clean();
?>