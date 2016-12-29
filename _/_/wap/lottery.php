<?php
/**
 * 活动：投资活动合集
 */
require_once dirname(__FILE__) . '/global.php';

$action = $_GET['action']?$_GET['action']:'index';
if(function_exists($action)){
	// 强制用户登录
	if(empty($_SESSION['wap_user'])) {
		if (!IS_AJAX) {
			//redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
			$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			redirect("./login.php?referer=" . urlencode($url));
		} else {
			json_return(1000, '请登录');
		}
	}
	$action($config);
}else{
	pigcms_tips('方法不存在');
}

// 活动首页
function index(){
	
}
// 错误提示
function gettips($str = ''){
	$err_html = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>提示信息</title>
<style type="text/css">
<!--
body {
	background-color:#F7F7F7;
	font-family: Arial;
	font-size: 12px;
	line-height:150%;
}
.main {
	background-color:#FFFFFF;
	font-size: 12px;
	color: #666666;
	width:60%;
	margin:140px auto 0px;
	border-radius: 10px;
	padding:30px 10px;
	list-style:none;
	border:#DFDFDF 1px solid;
}
.main p {
	line-height: 18px;
	margin: 5px 20px;
	font-size:16px;
}
.main p a{
	text-decoration:none;
}
.copyright{
	text-align:center;
	margin-top:200px;
}
.copyright a{
	color:#999;
	text-decoration:none;
}
-->
</style>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
</head>
<body>
<div class="main">
<p>'.$str.'</p>
</div>
</body>
</html>';
	return $err_html;
}

// 活动详情
function detail($config = array()){
	//exit(date('Y-m-d H:i:s',1462463000));
	$id = (int)$_GET['id'];
	// 奖项设置
	$prize_names = array(1=>'一等奖',2=>'二等奖',3=>'三等奖',4=>'四等奖',5=>'五等奖',6=>'六等奖');
	$lottery = D('Lottery')->where(array('id'=>$id))->find();
	$lottery_prizes = D('Lottery_prize')->where(array('lottery_id'=>$lottery['id']))->order('prize_type asc')->select();
	
	if(!$lottery){
		echo gettips('活动不存在');
		return;
	}
	if($lottery['status']==1){
		echo gettips('活动已失效');
		return;
	}
	if($lottery['status']==3){
		echo gettips('活动已被删除');
		return;
	}
	if($lottery['endtime']<time()){
		echo gettips('活动已结束');
		return;
	}

	// 记录PV
	D('Lottery')->where(array('id'=>$id))->data('PV=PV+1')->save();
	// 抽奖记录
	$record = D('Lottery_record')->where(array('user_id'=>$_SESSION['wap_user']['uid'],'active_id'=>$id))->order('id desc')->select();
	// 中奖次数
	$win_num_record = 0;
	if($record){
		foreach($record as $k => $item){
			if($item['prize_id']){
				$win_num_record++;
			}
			$record[$k]['isonline'] = 1;
			foreach($lottery_prizes as $_item){
				if($item['prize_id'] == $_item['prize_type'] && $_item['prize'] == 4){
					$record[$k]['isonline'] = 0;
					break;
				}
			}
		}
	}
	
	// 是否需要关注
	/*if($lottery['need_subscribe']){
		// 检测用户是否关注公众号
		$wap_user = $_SESSION['wap_user'];
		$subscribe = D('Subscribe_store')->field('sub_id')->where(array('uid'=>$wap_user['uid'],'store_id'=>$lottery['store_id'],'is_leave'=>0))->find();
		if(!$subscribe){
			$_result = M('Store')->concernRelationship(800000000,$wap_user['uid'],$lottery['store_id'],2,'lottery',$id);
			if(!$_result['ticket']){
				echo gettips('商家没有绑定公众号');
				exit;
			}
			//echo '<div style="text-align:center;"><label>长按二维码关注本店公众号</label><br><img src="'.$_result['ticket'].'" width="100%" /></div>';
		}
	}*/
	
	$wap_user = $_SESSION['wap_user'];
	//活动是否开启关注
	if($lottery['need_subscribe']){
		/* 是否需要关注公众号 */
		$act_type = 'lottery';
		//店铺是否绑定认证服务号，并且能正常生产二维码
		$_result = M('Store')->concernRelationship(800000000, $wap_user['uid'], $lottery['store_id'], 2, $act_type, $id);
		if ($qrcode['error_code'] == 0) {
			/* 判读是否已经关注过商家 */
			$is_subscribe = D('Subscribe_store')->where(array('store_id'=>$lottery['store_id'],'uid'=>$wap_user['uid'],'is_leave'=>0))->find();
		}
	}


	// 若该活动 抽奖限制设置为：每日限制
	if($lottery['win_limit'] == 1){
		$share_setting = D('Lottery_share_setting')->where(array('user_id'=>$_SESSION['wap_user']['uid'],'active_id'=>$id))->find();
		if(!$share_setting){
			D('Lottery_share_setting')->data(array('user_id'=>$_SESSION['wap_user']['uid'],'active_id'=>$id,'num'=>$lottery['win_limit_extend']))->add();
		}
		// 是否是分享链接， 若是分享链接且后台设置分享xx次增加一次机会
		$from_uid = (int)$_GET['fromuid'];
		$isShared = D('Lottery_shared')->where(array('from_uid'=>$from_uid,'active_id'=>$lottery['id'],'to_uid'=>$_SESSION['wap_user']['uid']))->find();
		// 重复分享不予理睬
		if($from_uid && !$isShared){
			D('Lottery_shared')->data(array('from_uid'=>$from_uid,'to_uid'=>$_SESSION['wap_user']['uid'],'active_id'=>$lottery['id'],'dateline'=>time()))->add();
			$share_where = array('from_uid'=>$from_uid,'active_id'=>$lottery['id'],'status'=>0);
			$shares = D('Lottery_shared')->where($share_where)->order('id asc')->limit($lottery['win_limit_share_extend'],0)->select();
			if(count($shares)>=$lottery['win_limit_share_extend']){
				$share_ids = array();
				foreach($shares as $v){
					if(!in_array($v['id'],$share_ids)){
						$share_ids[] = $v['id'];
					}
				}
				// 分享者增加一次机会
				D('Lottery_share_setting')->where(array('user_id'=>$from_uid,'active_id'=>$lottery['id']))->data('num=num+1')->save();
				$update_where['id'] = array('in',$share_ids);
				D('Lottery_shared')->where($update_where)->data(array('status'=>1))->save();
			}
		}
	}
	$lottery_share_setting = D('Lottery_share_setting')->field('num')->where(array('user_id'=>$_SESSION['wap_user']['uid'],'active_id'=>$id))->find();
	
	// 分享
	$share_conf = array(
			'title'    => $lottery['title'], // 分享标题
			'desc'     => htmlspecialchars($lottery['active_desc']), // 分享描述
			'link'     => $config['site_url'].'/wap/lottery.php?action=detail&id='.$id.'&fromuid='.$_SESSION['wap_user']['uid'], // 分享链接
			'imgUrl'   => $lottery['backgroundThumImage'], // 分享图片链接
			'type'     => 'link', // 分享类型,music、video或link，不填默认为link
			'dataUrl'  => '' // 如果type是music或video，则要提供数据链接，默认为空
	);
	
	import('WechatShare');
	$share = new WechatShare();
	$shareData = $share->getSgin($share_conf);
	// 活动形式
	$template = '';
	switch ($lottery['type']){
		case 1 :	$template = 'lottery_dazhuanpan';break;			// 大转盘
		case 2 :	$template = 'lottery_jiugongge'; break;			// 九宫格
		case 3 : 	$template = 'lottery_guaguaka';  break;			// 刮刮卡
		case 4 : 	$template = 'lottery_shuiguoji'; break;			// 水果机
		case 5 : 	$template = 'lottery_zhajindan'; break;			// 砸金蛋
	}
	if($template==''){
		pigcms_tips('未知活动类型');
	}
	include display($template);
	echo ob_get_clean();
}

// 抽奖
function get_prize(){
	$aid = (int)$_GET['aid'];	// 活动id
	// 确定是否允许抽奖
	$lottery_helper = new lottery($aid);
	$res = $lottery_helper->is_allow();
	if($res['err_code']){
		json_return($res['err_code'],$res['err_msg']);
	}
	$response = array();
	// 确定中奖项
	$myprize = $lottery_helper->myprize();
	if($myprize == 101){
		json_return(1,'所有奖项已用完');
	}
	// 记录抽/中奖记录
	$data_prize = array('user_id'=>$_SESSION['wap_user']['uid'],'active_id'=>$lottery_helper->lottery['id'],'dateline'=>time(),'type'=>$lottery_helper->lottery['type']);
	if($myprize == 100){	// 未中奖
		$response['success'] = false;
	}else{
		$response['success'] = true;
		$response['prizetype'] = $myprize;
		$response['sn'] = 'sncode123';
		$response['aid'] = $lottery_helper->lottery['id'];
		$lottery_prize = D('Lottery_prize')->where(array('lottery_id'=>$lottery_helper->lottery['id'],'prize_type'=>$myprize))->find();
		$response['product_name'] = $lottery_prize['product_name'];
		$response['isonline'] = $lottery_prize['prize'] == 4 ? 0 : 1;	// 是否线上兑奖
		$data_prize['prize_id'] = $myprize;
		// 更新奖池
		D('Lottery_prize')->where(array('lottery_id'=>$lottery_helper->lottery['id'],'prize_type'=>$myprize))->data('product_num=product_num-1')->save();
	}
	$rid = D('Lottery_record')->data($data_prize)->add();
	$response['rid'] = $rid;
	echo json_encode($response);
}

// 用户兑奖
function cash_prize(){
	$rid = (int)$_POST['rid'];
	// 中奖记录
	$lottery_record = D('Lottery_record')->where(array('id'=>$rid))->find();
	if(!$lottery_record){
		json_return(1001,'未找到中奖记录');
	}
	if($lottery_record['prize_id'] == 0){
		json_return(1001,'您未中奖');
	}
	if($lottery_record['status'] == 1){
		json_return(1001,'您已兑过奖，请勿重复兑奖');
	}
	// 查看奖项设置
	$lottery = D('Lottery')->where(array('id'=>$lottery_record['active_id']))->find();
	$lottery_prize = D('Lottery_prize')->where(array('lottery_id'=>$lottery_record['active_id'],'prize_type'=>$lottery_record['prize_id']))->find();
	if(!lottery || !$lottery_prize){
		json_return(1001,'没有找到相关奖项');
	}
	
	$lottery_helper = new lottery($lottery['id']);
	$success_msg = '兑奖成功';
	// 奖品类型（1商品2优惠券3店铺积分4其他）
	if($lottery_prize['prize'] == 1){	// 商品
		// 直接生成已支付的订单
		$product_id = $lottery_prize['product_id'];
		$sku_id = $lottery_prize['sku_id'];
		$order_id = $lottery_helper->prize_product($lottery['store_id'],$product_id,$sku_id);
		D('Lottery_record')->where(array('id'=>$rid))->data(array('status'=>1,'order_id' => $order_id,'prize_time'=>time()))->save();
		$success_msg .= '  请到个人中心查看订单';
	}
	if($lottery_prize['prize'] == 2){	// 优惠券
		$res = $lottery_helper->prize_coupon($lottery_prize['coupon']);
		if($res['err_code'] > 0){
			json_return($res['err_code'],$res['err_msg']);
		}
		$rid = $_POST['rid'];
		D('Lottery_record')->where(array('id'=>$rid))->data(array('status'=>1,'prize_time'=>time()))->save();
		$success_msg .= '  请到个人中心查看我的优惠券';
	}
	if($lottery_prize['prize'] == 3){	// 店铺积分
		$data = array();
		$data['uid'] = $_SESSION['wap_user']['uid'];
		$data['store_id'] = $lottery['store_id'];
		$data['type'] = 14;
		$data['is_available'] = 1;
		$data['timestamp'] = time();
		$data['points'] = $lottery_prize['product_recharge'];
		$data['bak'] = '中奖积分';
		$result = D('User_points')->data($data)->add();
		if($result){
			M('Store_user_data')->changePoint($lottery['store_id'], $_SESSION['wap_user']['uid'], $data['points']);
			D('Lottery_record')->where(array('id'=>$rid))->data(array('status'=>1,'prize_time'=>time()))->save();
		}
		$success_msg .= '  请到店铺个人中心查看积分';
	}
	if($lottery_prize['prize'] == 4){	// 线下兑奖
		$password = trim($_POST['password']);
		if($password == '' || $password != $lottery['password']){
			json_return(1001,'兑奖密码不正确');
		}
		// 开始兑奖
		D('Lottery_record')->where(array('id'=>$rid))->data(array('status'=>1,'prize_time'=>time()))->save();
	}
	json_return(0,$success_msg);
}

// 检查收货地址
function check_address(){
	$wap_user = $_SESSION['wap_user'];
	$aid = (int)$_GET['aid'];
	$user_address = D('User_address')->field('address_id,uid')->where(array('uid'=>$wap_user['uid']))->find();
	if($user_address){
		json_return(0,'ok');
	}else{
		echo json_encode(array('err_code'=>1,'err_msg'=>'请填写收货地址'));
	}
}

// 我的收货地址
function myaddress(){
	$aid = (int)$_GET['aid'];
	$return_url = "/wap/lottery.php?action=detail&id=".$aid;
	include display('myaddress');
	echo ob_get_clean();
}

// 抽奖类
class lottery{
	
	var $lottery = '';
	var $lottery_record = '';
	// $aid 活动ID
	function __construct($aid){
		$this->lottery = D('Lottery')->where(array('id'=>$aid,'status'=>0))->find();
		$this->lottery_record = D('Lottery_record')->where(array('user_id'=>$_SESSION['wap_user']['uid'],'active_id'=>$aid))->select();
	}
	
	// 确定是否允许抽奖，$aid：活动ID
	function is_allow(){
		$lottery = $this->lottery;
		if(!$lottery){
			return array('err_code'=>1,'err_msg'=>'活动已结束或不存在');
		}
		// 检查抽奖记录
		$lottery_record = $this->lottery_record;
		// 今天抽奖总次数
		$today_count = 0;
		// 中奖总次数
		$prize_count = 0;
		// 今天中奖总次数
		$today_prize_count = 0;
		if($lottery_record){
			foreach($lottery_record as $record){
				if($record['dateline']<time()&&$record['dateline']>strtotime(date('Y-m-d 00:00:00'))){
					$today_count++;
				}
				if($record['prize_id']){
					$prize_count++;
					if($record['dateline']<time()&&$record['dateline']>strtotime(date('Y-m-d 00:00:00'))){
						$today_prize_count++;
					}
				}
			}
		}
		// 限制总次数
		if($lottery['win_type']==0){
			if($prize_count>=$lottery['win_type_extend']){
				return array('err_code'=>1,'err_msg'=>'超出中奖总次数');
			}
		}
		// 单日中奖限制
		if($lottery['win_type']==1){
			if($today_prize_count>=$lottery['win_type_extend']){
				return array('err_code'=>1,'err_msg'=>'超出单日中奖总次数');
			}
		}
		// 抽奖限制，0不限制 1每日限制 2分享限制 3 积分限制
		if($lottery['win_limit']==1){
			if($today_count>=$lottery['win_limit_extend']){
				$share_setting = D('Lottery_share_setting')->where(array('user_id'=>$_SESSION['wap_user']['uid'],'active_id'=>$lottery['id']))->find();
				if(!$share_setting){
					return array('err_code'=>1,'err_msg'=>'超出单日抽奖总次数');
				}
				if($share_setting && $today_count>=$share_setting['num']){
					return array('err_code'=>1,'err_msg'=>'超出单日抽奖总次数');
				}
			}
		}
		if($lottery['win_limit']==3){	// 每抽一次奖，消耗一定积分
			// 检查用户剩余积分
			$user_poins = M('Store_user_data')->getUserData($lottery['store_id'], $_SESSION['wap_user']['uid']);
			
			if($user_poins['point']<$lottery['win_limit_extend']){
				return array('err_code'=>1,'err_msg'=>'您的积分不足');
			}
			// 积分流水
			$data['uid'] = $_SESSION['wap_user']['uid'];
			$data['store_id'] = $lottery['store_id'];
			$data['type'] = 14;
			$data['is_available'] = 0;
			$data['timestamp'] = time();
			$data['points'] = -$lottery['win_limit_extend'];
			$data['bak'] = '抽奖消耗';
			$result = D('User_points')->data($data)->add();
			if($result){
				M('Store_user_data')->changePoint($lottery['store_id'], $_SESSION['wap_user']['uid'], $data['points']);
			}
		}
		return array('err_code'=>0,'err_msg'=>'OK');
	}
	
	// 确定中奖项
	function myprize(){
		$lottery_prize = D('Lottery_prize')->field('prize_type,rates')->where(array('lottery_id'=>$this->lottery['id'],'product_num'=>array('>',0)))->select();
		if(!$lottery_prize){
			return 101;	// 奖池没有奖了
		}
		// 不中奖的概率
		$no_prize_probability = 1;
		$prize_box = array();
		foreach($lottery_prize as $prize){
			$power = rand(10,100)*$prize['rates']/100;	// 计算每个奖项的权重
			$prize_box[$prize['prize_type']] = $power;
			// 不中奖
			$no_prize_probability = $no_prize_probability * (100-$prize['rates'])/100;
		}
		$prize_box[100] = $no_prize_probability * rand(10,100);		// 不中奖的权重
		arsort($prize_box);
		$_myprize = array();
		foreach($prize_box as $key =>$item){
			$_myprize['key'] = $key;
			$_myprize['value'] = $item;
			break;
		}
		// 中奖的奖项ID
		$win_prize_id =  $_myprize['key'];
		// 如果未中奖，检查是否有安慰奖
		if($_myprize['key'] == 100){
			if($this->lottery['anwei']){
				// 安慰奖是否还有剩余
				$anwei_prize = D('Lottery_prize')->where(array('lottery_id'=>$this->lottery['id'],'prize_type'=>$this->lottery['anwei']))->find();
				if($anwei_prize['product_num']){
					$win_prize_id = $this->lottery['anwei'];
				}
			}
		}
		return $win_prize_id;
	}
	
	// 兑奖环节
	// 商品兑奖
	function prize_product($store_id,$product_id,$sku_id){
		$order_no = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
		$data_order['store_id'] = $store_id;
		$data_order['order_no'] = $data_order['trade_no'] = $order_no;
		$data_order['uid'] = $_SESSION['wap_user']['uid'];
		$data_order['pro_num'] = 1;
		$data_order['pro_count'] = '1';
		$data_order['type'] = 56;	// 抽奖活动类型
		$data_order['bak'] = '抽奖活动订单';
		$data_order['activity_data'] = '';
		$data_order['add_time'] = $_SERVER['REQUEST_TIME'];
		$data_order['sub_total'] = 0;
		$data_order['order_pay_point'] = 0;
		$data_order['is_point_order'] = 0;
		$data_order['status'] = 2;	// 已支付的订单状态
		// 用户信息
		$user_address = D('User_address')->where(array('uid'=>$_SESSION['wap_user']['uid']))->find();
		$data_order['address_user'] = $user_address['name'];
		$data_order['address_tel']=trim($user_address['tel']);
		$address = M('User_address')->getAdressById(session_id(), $_SESSION['wap_user']['uid'],$user_address['address_id']);
		
		
		$data_order['address'] = serialize(array(
						'address' => $address['address'],
						'province' => $address['province_txt'],
						'province_code' => $address['province'],
						'city' => $address['city_txt'],
						'city_code' => $address['city'],
						'area' => $address['area_txt'],
						'area_code' => $address['area'],
				));
		$data_order['shipping_method'] = 'express';		
				
				
				
		$order_id = D('Order')->data($data_order)->add();
		$data_order_product['order_id'] = $order_id;
		$data_order_product['product_id'] = $product_id;
		$data_order_product['sku_id']	 = $sku_id;
		$data_order_product['sku_data']   = '';
		$data_order_product['pro_num']	= 1;
		$data_order_product['pro_price']  = 0;
		$data_order_product['comment']	= '';
		$data_order_product['pro_weight'] = 0;
		$data_order_product['pro_price'] = 0;
		$data_order_product['is_fx']			   = 0;
		$data_order_product['supplier_id']		   = 0;
		$data_order_product['original_product_id'] = 0;
		$data_order_product['user_order_id']	   = $order_id;
		D('Order_product')->data($data_order_product)->add();
		
		// 更新实际库存
		$database_product = D('Product');
		$database_product_sku = D('Product_sku');
		if ($sku_id) {
			$condition_product_sku['sku_id'] = $sku_id;
			$database_product_sku->where($condition_product_sku)->setInc('sales', 1);
			$database_product_sku->where($condition_product_sku)->setDec('quantity', 1);
		}
		$condition_product['product_id'] = $product_id;
		$database_product->where($condition_product)->setInc('sales', 1);
		$database_product->where($condition_product)->setDec('quantity', 1);
		
		
		// 产生提醒
		import('source.class.Notify');
		Notify::createNoitfy($store_id, option('config.orderid_prefix') . $order_no);
		
		//////////////////////////////////////////////////////////////////////////////////////////////////
		// $uid = $_SESSION['wap_user']['uid'];
		// $first_product_name = $product_info ? msubstr($product_info[name],0,11) : "";
		
		//产生提醒-已生成订单
		//import('source.class.Notice');
		//Notice::sendOut($uid, $nowOrder,$first_product_name);
		return $order_id;
	}
	
	// 兑奖 优惠券
	function prize_coupon($coupon_id){
		$time = time();
		$uid = $_SESSION['wap_user']['uid'];
		$coupon = D('Coupon')->where(array('id' => $coupon_id))->find();
		//查看是否已经领取
		if ($coupon['total_amount'] <= $coupon['number']) {
			return array('err_code'=>1002,'err_msg'=>'该优惠券已经全部发放完了');
		}
		
		if ($coupon['status'] == '0') {
			return array('err_code'=>1003,'err_msg'=>'该优惠券已失效!');
		}
		
		if ($time > $coupon['end_time'] || $time < $coupon['start_time']) {
			return array('err_code'=>1004,'err_msg'=>'该优惠券未开始或已结束!');
		}
		
		if ($coupon['type'] == '2') {
			return array('err_code'=>1005,'err_msg'=>'不可领取赠送券!');
		}
		$user_coupon = D('User_coupon')->where(array('uid' => $uid, 'coupon_id' => $coupon_id))->field("count(id) as count")->find();
		
		//查看当前用户是否达到最大领取限度
		if ($coupon['most_have'] != '0') {
			if ($user_coupon['count'] >= $coupon['most_have']) {
				// 领奖环节若已领满，则通知用户领取成功，实际不予发放。
				return array('err_code'=>0,'err_msg'=>'领取成功!');
			}
		}
		//领取
		if(M('User_coupon')->add($uid,$coupon)){
			//修改优惠券领取信息
			unset($where);unset($data);
		
			$where = array('id'=>$coupon_id);
			D('Coupon')->where($where)->setInc('number',1);
			return array('err_code'=>0,'err_msg'=>'领取成功!');
		} else{
			return array('err_code'=>1111,'err_msg'=>'领取失败!');
		}
	}
}

