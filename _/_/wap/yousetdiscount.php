<?php
/**
 * 优惠接力活动
 */
require_once dirname(__FILE__) . '/global.php';

$action = $_GET['action'] ? $_GET['action'] : 'index';
if (function_exists($action)) {
	// 强制用户登录
	if (empty($_SESSION['wap_user'])) {
		if (!IS_AJAX) {
			redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
		} else {
			json_return(1000, '请登录');
		}
	}
	$wap_user = $_SESSION['wap_user'];
	$action();
} else {
	pigcms_tips('方法不存在');
}

/**
 * 公用方法
 */
function _getInfo ($id) {

	if (empty($id)) {
		pigcms_tips('缺少参数');
	}

	// $YouSetDiscount = S($id.'YouSetDiscount');
	// if (empty($YouSetDiscount)) {
	// 	$YouSetDiscount = D('Yousetdiscount')->where(array('id'=>$id, 'is_open'=>0))->find();
	// 	if (empty($YouSetDiscount)) {
	// 		pigcms_tips('活动不存在，或未开启');
	// 		exit;
	// 	} else {
	// 		S($id.'YouSetDiscount', $YouSetDiscount);
	// 	}
	// }
	
	$YouSetDiscount = D('Yousetdiscount')->where(array('id'=>$id, 'is_open'=>0))->find();
	if (empty($YouSetDiscount)) {
		pigcms_tips('活动不存在，或未开启');
	}
	$YouSetDiscount['discount_type'] = 1;
	return $YouSetDiscount;

}

function shareFilter($subject) {
	$subject = str_replace("'", "", $subject);
	$subject = str_replace("\"", "", $subject);
	$subject = str_replace("\r", "", $subject);
	$subject = str_replace("\n", "", $subject);
	$subject = str_replace("\t", " ", $subject);
	return trim($subject);
}

/**
 * 生成分享信息
 */
function _createShareData ($data, $share_type = '', $yuser, $youhuizhi) {

	$share_conf = array();

	switch ($share_type) {
		case 'game':

			$share_conf = array(
			    'imgUrl'    => $data['fxpic'],
			    'type'      => '',
			    'dataUrl'   => '',
			);

			if (!empty($data['fxtitle'])) {
				$share_conf['title'] = str_replace(array('{{活动名称}}','{{分值}}'), array($data['name'], $youhuizhi), $data['fxtitle']);
			} else {
				$share_conf['title'] = "我正在参加“".$data['name']."”活动，快来帮我拿优惠！";
			}

			if (!empty($data['fxinfo'])) {
				$share_conf['desc'] = str_replace(array('{{活动名称}}', '{{分值}}'), array($data['name'], $youhuizhi), $data['fxinfo']);
			} else {
				$share_conf['desc'] = $data['name'];
			}

			$share_conf['link'] = option('config.wap_site_url').'/yousetdiscount.php?id='.$data['id'].'&store_id='.$data['store_id'].'&share_key='.$yuser['share_key'];

			break;

		case 'fx':

			$share_conf = array(
			    'imgUrl'    => $data['fxpic'],
			    'type'      => '',
			    'dataUrl'   => '',
			);

			if (!empty($data['fxtitle2'])) {
				$share_conf['title'] = str_replace(array('{{时间}}', '{{分值}}'), array($data['playtime'], $youhuizhi), $data['fxtitle2']);
			} else {
				$share_conf['title'] = "我在".$data['playtime']."秒内获得了".$youhuizhi."的积分，手都快抽筋，你也来试试看！";
			}

			if (!empty($data['fxinfo2'])) {
				$share_conf['desc'] = str_replace(array('{{时间}}','{{分值}}'), array($data['playtime'], $youhuizhi), $data['fxinfo2']);
			} else {
				$share_conf['desc'] = $data['name'];
			}

			$share_conf['link'] = option('config.wap_site_url').'/yousetdiscount.php?id='.$data['id'].'&store_id='.$data['store_id'].'&share_key='.$yuser['share_key'];

			break;
		
		default:
			// 普通分享
			$share_conf = array(
			    'title'     => $data['name'], // 分享标题
			    'desc'      => $data['name'], // 分享描述
			    'link'      => option('config.wap_site_url').'/yousetdiscount.php?id='.$data['id'].'&store_id='.$data['store_id'],
			    'imgUrl'    => $data['fxpic'], // 分享图片链接
			    'type'      => '',
			    'dataUrl'   => '',
			);
			break;
	}

	$share_conf['title'] = shareFilter($share_conf['title']);
	$share_conf['desc'] = shareFilter($share_conf['desc']);

	import('WechatShare');
	$share 		= new WechatShare();
	$shareData 	= $share->getSgin($share_conf);

	return $shareData;
}

/**
 * 详情页面
 */
function index () {

	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	$store_id = isset($_GET['store_id']) ? intval($_GET['store_id']) : 0;
	$share_key = isset($_GET['share_key']) ? trim($_GET['share_key']) : '';
	
	if (empty($store_id)) {
		pigcms_tips('缺少参数');
	}

	$YouSetDiscount = _getInfo($id);
	$info = $YouSetDiscount;
	$wap_user = $_SESSION['wap_user'];

	$now = time();
	if ($YouSetDiscount['startdate'] > $now) {
		$is_over = 1;
	} else if ($YouSetDiscount['enddate'] < $now) {
		$is_over = 2;
	} else {
		$is_over = 0;
	}

	if (!empty($share_key)) {	// 是自己的，跳到自己
		
		$is_my = D('Yousetdiscount_users')->where(array('store_id'=>$store_id, 'yid'=>$id, 'uid'=>$wap_user['uid'], 'share_key'=>$share_key))->find();
		if (!empty($is_my)) {
			redirect('./yousetdiscount.php?action=index&id='.$id.'&store_id='.$store_id);
			exit;
		}
		
	}
		
	$my = D('Yousetdiscount_users')->where(array('yid'=>$id,'uid'=>$wap_user['uid']))->find();
	if (empty($my)) {	// 访问时生成一条自己的记录			
		$add_user = array(
			'store_id' => $store_id,
			'uid' => $wap_user['uid'],
			'yid' => $id,
			'share_key' => md5($YouSetDiscount['store_id'].$wap_user['uid'].$id.$now),
			'addtime' => $now,
		);
		$yuid = D('Yousetdiscount_users')->data($add_user)->add();
		$my = D('Yousetdiscount_users')->where(array('store_id'=>$YouSetDiscount['store_id'],'yid'=>$id,'uid'=>$wap_user['uid']))->find();
	}
	
	$act_type = 'yousetdiscount';
	$is_subscribe = D('Subscribe_store')->where(array('store_id'=>$info['store_id'], 'uid'=>$wap_user['uid'], 'is_leave'=>0))->find();

	if (!empty($share_key)) {	// 其他人访问，自己访问不会带share_key参数

		$user = D('Yousetdiscount_users')->where(array('store_id'=>$store_id, 'yid'=>$id, 'share_key'=>$share_key))->find();
		$user['userinfo'] = D('User')->where(array('uid'=>$user['uid']))->find();
		$wota = 'TA';

		// 其他人访问 用于关注后的图文消息跳转url
		if($info['is_attention'] == 1 && empty($is_subscribe)){
		    $qrcode = M('Store')->concernRelationship(800000000, $wap_user['uid'], $info['store_id'], 2, $act_type, $info['id'], $user['uid']);
		}

	} else {
		
		$user = $my;
		$user['userinfo'] = $wap_user;
		$wota = '自己';
		
		// 自己访问 用于关注后的图文消息跳转url
		if($info['is_attention'] == 1 && empty($is_subscribe)){
		    $qrcode = M('Store')->concernRelationship(800000000, $wap_user['uid'], $info['store_id'], 2, $act_type, $info['id']);
		}


	}

	$playcount = D('Yousetdiscount_helps')->field('playcount')->where(array('store_id'=>$store_id, 'yid'=>$id, 'user'=>$user['share_key'], 'help'=>$my['share_key']))->find();
	$playcount = intval($playcount['playcount']);

	// 该活动，该人的帮忙记录
	$helps = D('Yousetdiscount_helps')->where(array('store_id'=>$store_id, 'yid'=>$id, 'user'=>$user['share_key']))->order('discount desc')->select();
	foreach ($helps as $hk => $hv) {
		$help_user = D('Yousetdiscount_users')->where(array('store_id'=>$store_id, 'yid'=>$id, 'share_key'=>$hv['help']))->find();
		$helps[$hk]['userinfo'] = D('User')->where(array('uid'=>$help_user['uid']))->find();
		$helps[$hk]['helps_data'] = D('Yousetdiscount_helps_data')->where(array('store_id'=>$store_id, 'yid'=>$id, 'hid'=>$hv['id']))->select();
	}
	
	$helps_sum = D('Yousetdiscount_helps')->field('sum(discount) as sum')->where(array('store_id'=>$store_id, 'yid'=>$id, 'user'=>$user['share_key']))->find();
	$helps_sum = round($helps_sum ? $helps_sum['sum'] : 0, 2);
	
	$direction = D('Yousetdiscount_direction')->where(array('store_id'=>$store_id, 'yid'=>$id))->order('id')->select();
	foreach ($direction as &$val) { // 关联的优惠劵信息
		$find_coupon = D('Coupon')->where(array('id'=>$val['coupon_id']))->find();
		$val['name'] = $find_coupon['name'];
		$val['face_money'] = $find_coupon['face_money'];
		$val['limit_money'] = $find_coupon['limit_money'];
		$val['number'] = $find_coupon['number'];
		$val['total_amount'] = $find_coupon['total_amount'];
	}

	// 如果领取过，获取领取的优惠劵记录信息
	$coupon_txt = '';
	if ($user['state'] == 1) {
		$coupon = D('Coupon')->where(array('id'=>$user['coupon_id']))->find();
		if (!empty($coupon)) {
			$coupon_txt = '已领'.$coupon['face_money'].'元优惠劵';
		}
	}

	if ($_GET['game'] == 'go') {				// 游戏页面
		
		if ($share_key == '') {
			$shengyucishu = $YouSetDiscount['my_count'] - intval($playcount);
			$error_title = "您的次数已用完";
		} else {
			$shengyucishu = $YouSetDiscount['friends_count'] - intval($playcount);
			$error_title = "您帮TA的次数已用完";
		}
		
		if ($shengyucishu < 1 || $user['state'] == 1) {
			redirect('./yousetdiscount.php?action=index&store_id='.$store_id.'&id='.$id.'&share_key='.$share_key);
			exit;
		}
		
		include display('yousetdiscount_game');
	} elseif ($_GET['fx'] == 'go') {			// 游戏中炫耀分享页面
		include display('yousetdiscount_fx');
	} else {									// 主页面
		include display('yousetdiscount_index');
	}
	
	echo ob_get_clean();

}

/**
 * 上传分值
 */
function todiscount () {
		
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$YouSetDiscount = _getInfo($id);

	if (empty($_POST['share_key'])) {	// 自己玩
		
		$user = D('Yousetdiscount_users')->where(array('store_id'=>$YouSetDiscount['store_id'], 'yid'=>intval($_POST['id']), 'uid'=>$_POST['uid']))->find();
		$help = D('Yousetdiscount_helps')->where(array('store_id'=>$YouSetDiscount['store_id'], 'yid'=>intval($_POST['id']), 'user'=>$user['share_key'], 'help'=>$user['share_key']))->find();
		
		if ($help['playcount'] < $YouSetDiscount['my_count']) {
		
			D('Yousetdiscount_users')->where(array('store_id'=>$YouSetDiscount['store_id'], 'yid'=>intval($_POST['id']), 'uid'=>$_POST['uid']))->setInc('discount', floatval($_POST['this_discount']));	
			if (empty($help)) {
				$help_id = D('Yousetdiscount_helps')->data(array('store_id'=>$YouSetDiscount['store_id'], 'yid'=>intval($_POST['id']), 'user'=>$user['share_key'], 'help'=>$user['share_key'], 'discount'=>floatval($_POST['this_discount']), 'playcount'=>1))->add();
				D('Yousetdiscount_helps_data')->data(array('store_id'=>$YouSetDiscount['store_id'], 'yid'=>intval($_POST['id']), 'hid'=>$help_id, 'discount'=>floatval($_POST['this_discount']), 'addtime'=>time()))->add();
				
			} else {
				D('Yousetdiscount_helps')->where(array('store_id'=>$YouSetDiscount['store_id'], 'id'=>$help['id']))->data(array('discount'=>(floatval($help['discount']) + floatval($_POST['this_discount'])), 'playcount'=>($help['playcount'] + 1)))->save();
				D('Yousetdiscount_helps_data')->data(array('store_id'=>$YouSetDiscount['store_id'], 'yid'=>intval($_POST['id']), 'hid'=>$help['id'], 'discount'=>floatval($_POST['this_discount']), 'addtime'=>time()))->add();
				
			}
		
		}
		
	} else {	// 帮别人玩
		
		$user = D('Yousetdiscount_users')->where(array('store_id'=>$YouSetDiscount['store_id'], 'yid'=>intval($_POST['id']), 'uid'=>$_POST['uid']))->find();
		$help = D('Yousetdiscount_helps')->where(array('store_id'=>$YouSetDiscount['store_id'], 'yid'=>intval($_POST['id']), 'user'=>$_POST['share_key'], 'help'=>$user['share_key']))->find();
		
		if ($help['playcount'] < $YouSetDiscount['friends_count']) {
		
			D('Yousetdiscount_users')->where(array('store_id'=>$YouSetDiscount['store_id'], 'yid'=>intval($_POST['id']), 'share_key'=>$_POST['share_key']))->setInc('discount', floatval($_POST['this_discount']));
		
			if (empty($help)) {
				$help_id = D('Yousetdiscount_helps')->data(array('store_id'=>$YouSetDiscount['store_id'], 'yid'=>intval($_POST['id']), 'user'=>$_POST['share_key'], 'help'=>$user['share_key'], 'discount'=>floatval($_POST['this_discount']), 'playcount'=>1))->add();
				D('Yousetdiscount_helps_data')->data(array('store_id'=>$YouSetDiscount['store_id'], 'yid'=>intval($_POST['id']), 'hid'=>$help_id,'discount'=>floatval($_POST['this_discount']), 'addtime'=>time()))->add();
				
			} else {
				D('Yousetdiscount_helps')->where(array('store_id'=>$YouSetDiscount['store_id'], 'id'=>$help['id']))->data(array('discount'=>(floatval($help['discount']) + floatval($_POST['this_discount'])), 'playcount'=>($help['playcount'] + 1)))->save();
				D('Yousetdiscount_helps_data')->data(array('store_id'=>$YouSetDiscount['store_id'], 'yid'=>intval($_POST['id']), 'hid'=>$help['id'], 'discount'=>floatval($_POST['this_discount']),'addtime'=>time()))->add();
				
			}
		
		}
		
	}
	
	$data['error'] = 0;
	json_return(0, $data);

}

/**
 * 判断是否还有剩余次数
 */
function iscount () {
		
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$YouSetDiscount = _getInfo($id);

	if (empty($_POST['share_key'])) {
		
		$user = D('Yousetdiscount_users')->where(array('store_id'=>$YouSetDiscount['store_id'], 'yid'=>intval($_POST['id']), 'uid'=>$_POST['uid']))->find();
		$help = D('Yousetdiscount_helps')->where(array('store_id'=>$YouSetDiscount['store_id'], 'yid'=>intval($_POST['id']), 'user'=>$user['share_key'], 'help'=>$user['share_key']))->find();
		
		if ($help['playcount'] < $YouSetDiscount['my_count']) {
			json_return(0, $data);
		} else {
			json_return(1, $data);
		}
		
	} else {
		
		$user = D('Yousetdiscount_users')->where(array('store_id'=>$YouSetDiscount['store_id'], 'yid'=>intval($_POST['id']), 'wecha_id'=>$_POST['wecha_id']))->find();
		$help = D('Yousetdiscount_helps')->where(array('store_id'=>$YouSetDiscount['store_id'], 'yid'=>intval($_POST['id']), 'user'=>$_POST['share_key'], 'help'=>$user['share_key']))->find();
		
		if ($help['playcount'] < $YouSetDiscount['friends_count']) {
			json_return(0, $data);
		} else {
			json_return(1, $data);
		}
		
	}
	
}