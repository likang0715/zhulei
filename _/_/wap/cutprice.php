<?php
/**
 * 活动：降价拍
 */
require_once dirname(__FILE__) . '/global.php';

$action = $_GET['action']?$_GET['action']:'index';
if(function_exists($action)){
	// 强制用户登录
	if(empty($_SESSION['wap_user'])) {
		if (!IS_AJAX) {
			redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
		} else {
			json_return(1000, '请登录');
		}
	}
	$action();
}else{
	pigcms_tips('方法不存在');
}

/**
 * 降价拍首页
 */
function index(){
	$where = array();
	$cutprice_list = D('Cutprice')->where($where)->order("addtime desc")->select();
	if($cutprice_list){
		foreach($cutprice_list as $key => $item){
			// 加载对应的商品
			$product_info = D('Product')->where(array('product_id'=>$item['product_id']))->field('price,image')->find();
			if($item['sku_id']){
				$product_sku = D('Product_sku')->where(array('sku_id'=>$item['sku_id']))->field('sku_id,product_id,quantity,price')->find();
				$product_info['price'] = $product_sku['price'];
			}
			$cutprice_list[$key]['product_info'] = $product_info;
		}
	}
	//exit(print_r($cutprice_list));
	include display('cutprice_list');
	echo ob_get_clean();
}

/**
 * 降价拍详情
 */
function detail(){
	$where['pigcms_id'] = (int)$_GET['id'];
	$cutprice = D('Cutprice')->where($where)->find();
	if(!$cutprice){
		pigcms_tips('该商品不存在');
	}
	// 检测是否需要关注公众号
/*	if($cutprice['state_subscribe']==0){
		$wap_user = $_SESSION['wap_user'];
		$subscribe = D('Subscribe_store')->field('sub_id')->where(array('uid'=>$wap_user['uid'],'store_id'=>$cutprice['store_id'],'is_live'=>0))->find();
		if(!$subscribe){
			pigcms_tips('您必须先关注本店的公众号');
		}
	}
*/	
	$wap_user = $_SESSION['wap_user'];
	//活动是否开启关注
	if($cutprice['state_subscribe']==0){
		/* 是否需要关注公众号 */
		$act_type = 'cutprice';
		//店铺是否绑定认证服务号，并且能正常生产二维码
		$_result = M('Store')->concernRelationship(800000000, $wap_user['uid'], $cutprice['store_id'], 2, $act_type, $where['pigcms_id']);
		if ($qrcode['error_code'] == 0) {
			/* 判读是否已经关注过商家 */
			$subscribe = D('Subscribe_store')->field('sub_id')->where(array('uid'=>$wap_user['uid'],'store_id'=>$cutprice['store_id'],'is_leave'=>0))->find();
		}
	}

	// 店铺信息
	$store_info = D('Store')->field('store_id,name')->where(array('store_id'=>$cutprice['store_id']))->find();
	// 商品主图
	$pruduct_main = D('Product')->where(array('product_id'=>$cutprice['product_id']))->field('product_id,name,image,info')->find();
	// 商品图片
	$product_imgs = D('Product_image')->where(array('product_id'=>$cutprice['product_id']))->select();
	$cutprice['images'] = $product_imgs;
	
	$cha = time() - $cutprice['starttime'];
	if($cha < 0){
		$state = 'wait';
		$cutprice['nowprice'] = $cutprice['startprice'];
	}elseif($cha >= 0){
		$chaprice = (floor($cha/60/$cutprice['cuttime']))*$cutprice['cutprice'];
		if($cutprice['inventory'] > 0 && ($cutprice['startprice'] - $chaprice) > $cutprice['stopprice']){
			$state = 'start';
			$cutprice['nowprice'] = $cutprice['startprice'] - $chaprice;
			$cutprice['min'] = $cutprice['cuttime'] - 1 - ((floor($cha/60))%$cutprice['cuttime']);
			$cutprice['sec'] = 59 - ($cha%60);
		}else{
			$state = 'stop';
			D('Cutprice')->where(array('pigcms_id'=>$cutprice['pigcms_id']))->data(array('state'=>2))->save();
		}
	}
	include display('cutprice');
	echo ob_get_clean();
}

// 检查收货地址
function checkAddress(){
	$wap_user = $_SESSION['wap_user'];
	$user_address = D('User_address')->field('address_id,uid')->where(array('uid'=>$wap_user['uid']))->find();
	if($user_address){
		json_return(0,'ok');
	}else{
		json_return(1,'err');
	}
}

// 检查活动状态
function check_cutprice(){
	$id = (int)$_GET['id'];
	$cutprice = D('Cutprice')->where(array('pigcms_id'=>$id))->find();
	if(!$cutprice){
		json_return(1,'活动不存在');
	}
	if($cutprice['status']>0){
		json_return(1,'活动不在进行中');
	}
	if($cutprice['endtime']<time()){
		json_return(1,'活动已结束');
	}
	json_return(0,'ok');
}

// 我的收货地址
function myaddress(){
	$pigcms_id = (int)$_GET['pigcms_id'];
	$return_url = "/wap/cutprice.php?action=detail&id=".$pigcms_id;
	include display('myaddress');
	echo ob_get_clean();
}

//我的订单
function myorder(){
	$where_order['token'] = $this->token;
	$where_order['wecha_id'] = $this->wecha_id;
	switch($_GET['type']){
		case 'nobuy':
			$where_order['paid'] = 0;
			break;
		case 'wfahuo':
			$where_order['paid'] = 1;
			$where_order['fahuo'] = 0;
			break;
		case 'yfahuo':
			$where_order['paid'] = 1;
			$where_order['fahuo'] = 1;
			break;
		case 'over':
			$where_order['paid'] = 1;
			$where_order['fahuo'] = 2;
			break;
	}
	$order_list = $this->m_order->where($where_order)->order("addtime desc")->select();
	foreach($order_list as $k=>$v){
		$where['token'] = $this->token;
		$where['pigcms_id'] = $v['cid'];
		$cutprice = $this->m_cutprice->where($where)->find();
		$order_list[$k]['goods_name'] = $cutprice['name'];
		$order_list[$k]['goods_img'] = $cutprice['logoimg1'];
		if($v['paid'] == 0){
			$order_list[$k]['type'] = 'nobuy';
		}elseif($v['fahuo'] == 0){
			$order_list[$k]['type'] = 'wfahuo';
		}elseif($v['fahuo'] == 1){
			$order_list[$k]['type'] = 'yfahuo';
		}elseif($v['fahuo'] == 2){
			$order_list[$k]['type'] = 'over';
		}
	}
	$this->assign("order_list",$order_list);
	$this->display();
}
//删除订单
function delorder(){
	$where_order['token'] = $this->token;
	$where_order['pigcms_id'] = $_GET['orderid']*1;
	$order = $this->m_order->where($where_order)->find();
	$where['token'] = $this->token;
	$where['pigcms_id'] = $_GET['id']*1;
	$cutprice = $this->m_cutprice->where($where)->find();
	$save['inventory'] = $cutprice['inventory'] + $order['num'];
	$update = $this->m_cutprice->where($where)->save($save);
	$delorder = $this->m_order->where($where_order)->delete();
	$this->success("删除成功",U("Wap/Cutprice/myorder",array("token"=>$this->token)));
}
//未支付订单支付
function dopay(){
	$where_order['token'] = $this->token;
	$where_order['pigcms_id'] = $_GET['orderid']*1;
	$order = $this->m_order->where($where_order)->find();
	if($order == ''){
		$this->error("此订单已失效",U("Wap/Cutprice/my",array("token"=>$token)));
	}else{
		$this->redirect("Alipay/pay",array("token"=>$this->token,"price"=>$order['price'],"wecha_id"=>$this->wecha_id,"from"=>"Cutprice","orderid"=>$order['orderid'],'single_orderid'=>$order['orderid'],'notOffline'=>1));
	}
}
//确认收货
function shouhuo(){
	$where_order['token'] = $this->token;
	$where_order['pigcms_id'] = $_GET['orderid']*1;
	$save_order['fahuo'] = 2;
	$update = $this->m_order->where($where_order)->save($save_order);
	$this->success("确认收货成功",U("Wap/Cutprice/myorder",array("token"=>$this->token)));
}
//ajax
function ajax(){
	// inventory($_POST['token']);
	switch($_POST['type']){
		case 'inventory':
			$_POST['token'] && $where['token'] = $_POST['token'];
			$where['pigcms_id'] = $_POST['id'];
			$cutprice = D('Cutprice')->where($where)->find();
			$data['inventory'] = $cutprice['inventory'];
			echo json_encode($data);
			break;
		case 'buyers':
			$active_id = $_POST['id'];
			$cutprice = D('Cutprice')->field('pigcms_id,product_id,sku_id,store_id')->where(array('pigcms_id'=>$active_id))->find();
			$cutprice_order_record = D('Cutprice_record')->where(array('cutprice_id'=>$cutprice['pigcms_id']))->select();
			
			if(!$cutprice_order_record){
				echo json_encode(array());
				return;
			}
			$order_ids = array();
			foreach($cutprice_order_record as $item){
				if(!in_array($item['order_id'], $order_ids)){
					$order_ids[] = $item['order_id'];
				}
			}
			$where_order['type'] = 55;
			$where_order['status'] = array('>',1);
			$where_order['store_id'] = $cutprice['store_id'];
			$where_order['order_id'] = array('in',$order_ids);
			$order_list = D('Order')->where($where_order)->select();
			$data['buyers'] = '';
			foreach($order_list as $vo){
				$where_userinfo['uid'] = $vo['uid'];
				$userinfo = D('User')->where($where_userinfo)->find();
				$data['buyers'].='<div class=\'buyer\'><div class=\'buyerinfo\'>'.$userinfo['nickname'].'</div><div class=\'buyerinfo\'>'.substr($userinfo['phone'],0,3)."****".substr($userinfo['phone'],7,11).'</div><div class=\'buyerinfo\'>￥'.$vo['sub_total']/$vo['pro_num'].' x '.$vo['pro_num'].'</div></div>';
			}
			echo json_encode($data);
			break;
	}
}
//整理库存（降价拍略去，改为在下单是处理）。
function inventory($token){
	$where_order['token'] = $token;
	$where_order['paid'] = 0;
	$where_order['endtime'] = array('lt',time());
	$order_list = $this->m_order->where($where_order)->select();
	foreach($order_list as $vo){
		$where['token'] = $token;
		$where['pigcms_id'] = $vo['cid'];
		$cutprice = $this->m_cutprice->where($where)->find();
		$save['inventory'] = $cutprice['inventory'] + $vo['num'];
		$update = $this->m_cutprice->where($where)->save($save);
	}
	$del_order = $this->m_order->where($where_order)->delete();
}