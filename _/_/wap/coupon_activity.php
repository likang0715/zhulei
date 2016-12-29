<?php
/**
 * Created by pigcms_89.
 * Date: 2016/05/12
 * Time: 15:26
 * descrption: 领取店铺优惠券 用于优惠接力
 */
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user))  {
	redirect('./login.php?referer=' . urlencode($_SERVER['REQUEST_URI']));
}



//ajax 领取 用于优惠接力
function get_coupon_yousetdiscount ($wap_user) {

	$uid = $wap_user['uid'];

	if (empty($uid)) {
		json_return('1', '请先登录!');
	}

	$id = isset($_POST['coupon_id']) ? intval($_POST['coupon_id']) : 0;
	$yid = isset($_POST['yid']) ? intval($_POST['yid']) : 0;
	$did = isset($_POST['did']) ? intval($_POST['did']) : 0;
	$time = time();

	if (empty($id) || empty($yid)) {
		json_return('1001','缺少参数');
	}

	$ydiscount = D('Yousetdiscount')->where(array('id'=>$yid))->find();
	if (empty($ydiscount)) {
		json_return('1001','不存在该活动');
	}

	// 关闭活动过期领取限制
	// if ($time > $ydiscount['enddate']) {
	// 	json_return('1001','该活动已经过期');
	// }

	$yuser = D('Yousetdiscount_users')->where(array('yid'=>$yid, 'uid'=>$wap_user['uid']))->find();
	if (empty($yuser)) {
		json_return('1001','请先获取分数');
	}

	if ($yuser['state'] == 1) {
		json_return('1001','已领取过，请勿重复领取');
	}

	// 是否设置该优惠
	$direction = D('Yousetdiscount_direction')->where(array('yid'=>$yid, 'id'=>$did, 'coupon_id'=>$id))->find();
	if (empty($direction)) {
		json_return('1001','该活动没有此等级优惠劵');
	}

	// 分值检测
	if ($direction['at_least'] > $yuser['discount']) {
		json_return('1001','该优惠劵需要'.$direction['at_least'].'，您的分数'.$yuser['discount'].'不足');
	}

	$coupon = D('Coupon')->where(array('id' => $id))->find();

	//查看是否已经领取
	if ($coupon['total_amount'] <= $coupon['number']) {
		json_return('1002','该优惠券已经全部发放完了');
	}

	if ($coupon['status'] == '0') {
		json_return('1003','该优惠券已失效!');
	}

	// if ($time > $coupon['end_time'] || $time < $coupon['start_time']) {
	// 	json_return('1004','该优惠券未开始或已结束!');
	// }

	if ($coupon['type'] == '2') {
		json_return('1005','不可领取赠送券!');
	}

	$user_coupon = D('User_coupon')->where(array('uid' => $uid, 'coupon_id' => $id))->field("count(id) as count")->find();

	//查看当前用户是否达到最大领取限度
	if ($coupon['most_have'] != '0') {
		if ($user_coupon['count'] >= $coupon['most_have']) {
			json_return('1006','您已达到该优惠券允许的最大单人领取限额，无法领取!');
		}
	}

	//领取
	if (M('User_coupon')->add($uid,$coupon)) {
		//修改优惠券领取信息
		unset($where);
		unset($data);

		$where = array('id'=>$id);
		D('Coupon')->where($where)->setInc('number', 1);
		D('Yousetdiscount_users')->where(array('yid'=>$yid, 'uid'=>$wap_user['uid']))->data(array('did'=>$did,'coupon_id'=>$id,'state'=>1))->save();
		json_return(0, '领取成功');
	} else {
		json_return('1111','领取失败，请刷新页面重试!');
	}

}


/********************控制*************************/
$action = isset($_GET['action']) ? $_GET['action']:'';

switch($action){

	case 'yousetdiscount':
		get_coupon_yousetdiscount($wap_user);
		break;

	default:
		break;

}

echo ob_get_clean();
?>