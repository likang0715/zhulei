<?php
/**
 * User: pigcms_89
 * Date: 2016/05/23
 * Time: 14:43
 * descrption: 店铺消息提示ajax
 */
require_once dirname(__FILE__).'/global.php';

//cookie拆串
function explodeCookie ($cookie_data) {

	if (empty($cookie_data)) {
		return array();
	}

	$cookie_arr = array();
	$cookie_data = explode('|', $cookie_data);
	foreach ($cookie_data as $val) {
		$tmp = explode(',', $val);
		$cookie_arr[$tmp[0]] = $tmp[1];
	}

	return $cookie_arr;
}

//cookie拼串
function implodeCookie ($cookie_arr) {

	if (empty($cookie_arr)) {
		return '';
	}

	$cookieNew = array();
	foreach ($cookie_arr as $key => $val) {
		$cookieNew[] = $key.','.$val;
	}

	return implode('|', $cookieNew);
}

// 秒转换为时间串
function getLeftTime ($time) {
	$value = array(
	      "years" => 0, "days" => 0, "hours" => 0,
	      "minutes" => 0, "seconds" => 0,
    );
    $t = '';
    if($time >= 31556926){
      $value["years"] = floor($time/31556926);
      $time = ($time%31556926);
      $t = $value["years"] ."年";
      return $t;
    }
    if($time >= 86400){
      $value["days"] = floor($time/86400);
      $time = ($time%86400);
      $t = $value["days"] ."天";
      return $t;
    }
    if($time >= 3600){
      $value["hours"] = floor($time/3600);
      $time = ($time%3600);
      $t = $value["hours"] ."小时";
      return $t;
    }
    if($time >= 60){
      $value["minutes"] = floor($time/60);
      $time = ($time%60);
      $t = $value["minutes"] ."分";
      return $t;
    }
    $value["seconds"] = floor($time);
    $t = $value["seconds"]."秒";
    return $t;
}

//ajax 领取
function getStoreNotice ($cookie_data, $store_id) {

	if (empty($store_id)) {
		json_return(1000, '缺少参数');
	}

	$where['store_id'] = $store_id;
	$where['status'] = array('>', 1);
	$where['paid_time'] = array('>', 0);

	$cookie_arr = array();
	$cookie_str = $cookie_data;

	$cookie_arr = explodeCookie($cookie_data);
	if (!empty($cookie_arr) && isset($cookie_arr[$store_id])) {
		$where['order_id'] = array('>', $cookie_arr[$store_id]);
	}

	$time = time();
	$paidTime = $time - 24*3600;	// 24小时内
	$where['paid_time'] = array('>', $paidTime);
	$order_info = D('Order')->field('order_id,store_id,uid,paid_time')->where($where)->order('order_id DESC')->find();

	if ($order_info) {
		$buyer = D('User')->field('avatar,nickname')->where(array('uid'=>$order_info['uid']))->find();
		$order_info['avatar'] = !empty($buyer['avatar']) ? $buyer['avatar'] : option('config.site_url').'/template/user/default/images/avatar.png';
		$order_info['nickname'] = !empty($buyer['nickname']) ? $buyer['nickname'] : '匿名';
		// 多少时间之前
		$disTime = $time - $order_info['paid_time'];

		$order_info['dis_time'] = getLeftTime($disTime);
	}

	if ($order_info) {	// 替换store_id对应最后提示order_id

		$cookie_arr[$store_id] = $order_info['order_id'];
		foreach ($cookie_arr as $k => &$v) {
			$v = $k.','.$v;
		}

		$cookie_str = implode('|', $cookie_arr);
	}

	$cookie_json = array(
		'cookie_str' => $cookie_str,
		'order_info' => $order_info,
	);

	json_return(0, $cookie_json);
}

/* action */
$action = isset($_GET['action']) ? $_GET['action'] : '';
$store_id = isset($_POST['store_id']) ? $_POST['store_id'] : 0;
$cookie_data = isset($_POST['cookie_data']) ? $_POST['cookie_data'] : '';

switch ($action) {
	case 'get':
		getStoreNotice($cookie_data, $store_id);
		break;
	default:
		json_return(1000, '非法访问');
		break;
}

echo ob_get_clean();
?>