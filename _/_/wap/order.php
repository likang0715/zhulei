<?php
/**
 *  订单信息
 */
require_once dirname(__FILE__).'/global.php';

if(!empty($_GET['orderno'])){
	
	if (strpos(trim($_GET['orderno']), 'SMSPAY') !== FALSE) {
		$order_no = $_GET['orderno'];
		$nowOrder = M('Order_sms')->getOne(array('smspay_no'=>$order_no));
		if(empty($nowOrder)) {
				pigcms_tips('该订单不存在','none');
		} else {
			if($nowOrder['status']!=1) {
				redirect('./pay_by_sms.php?id='.$nowOrder['smspay_no']);
			} else {
				$nowOrder['order_no_txt'] = $nowOrder['smspay_no'];
				$nowOrder['pay_type_txt'] = "微信支付";
				include display('order_sms_paid');exit;
			}
		}
	}

	import('source.class.Margin');
	Margin::init($nowOrder['store_id']);
	$point_alias = Margin::point_alias();

	$nowOrder = M('Order')->findSimple($_GET['orderno']);
	if(empty($nowOrder)) pigcms_tips('该订单不存在','none');
	
	//店铺资料
	$now_store = M('Store')->wap_getStore($nowOrder['store_id']);
	if(empty($now_store)) pigcms_tips('您访问的店铺不存在','none');
	
	//if((!empty($nowOrder['session_id']) && $nowOrder['session_id']!=session_id()) || (!empty($nowOrder['uid']) && $nowOrder['uid'] != $wap_user['uid'])) redirect($now_store['url']);
	
	// 送他人订单，并且不是送公益，出来分享按钮
	if ($nowOrder['shipping_method'] == 'send_other' && $nowOrder['send_other_type'] != 2) {
		$product_list = M('Order_product')->orderProduct($nowOrder['order_id']);
		$product_image = $product_list[0]['image'];
		
		//分享配置 start
		$share_conf 	= array(
				'title' 	=> '小伙伴快来领礼品', // 分享标题
				'desc' 		=> str_replace(array("\r","\n", "'"), array('','', ''),  $nowOrder['send_other_comment']), // 分享描述
				'link' 		=> option('config.wap_site_url') . '/order_friend_share.php?order_id=' . $nowOrder['order_no_txt'], // 分享链接
				'imgUrl' 	=> $product_image, // 分享图片链接
				'type'		=> '', // 分享类型,music、video或link，不填默认为link
				'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
		);
		import('WechatShare');
		$share 		= new WechatShare();
		$shareData 	= $share->getSgin($share_conf);
	}
	
	// 团购出来分享按钮
	if ($nowOrder['type'] == 6) {
		$product_list = M('Order_product')->orderProduct($nowOrder['order_id']);
		$product_image = $product_list[0]['image'];
		
		$tuan_team = D('Tuan_team')->where(array('team_id' => $nowOrder['data_item_id']))->find();
		//分享配置 start
		$share_conf 	= array(
				'title' => '宝贝正在优惠中，速来参团。', // 分享标题
				'desc' => str_replace(array("\r","\n", "'"), array('','', ''), $product_list[0]['name']), // 分享描述
				'link' => option('config.site_url') . '/webapp/groupbuy/#/detailinfo/' . $tuan_team['tuan_id'] . '/' . $tuan_team['type'] . '/' . $tuan_team['item_id'] . '/' . $tuan_team['team_id'], // 分享链接
				'imgUrl' => $product_image, // 分享图片链接
				'type' => '', // 分享类型,music、video或link，不填默认为link
				'dataUrl' => '', // 如果type是music或video，则要提供数据链接，默认为空
		);
		import('WechatShare');
		$share 		= new WechatShare();
		$shareData 	= $share->getSgin($share_conf);
	}
	
	include display('order_paid');
}else if(!empty($_GET['orderid'])){
	if(empty($wap_user)) redirect('./login.php');
	
	if (strpos(trim($_GET['orderid']), 'SMSPAY') !== FALSE) {
		$orderid = strtolower($_GET['orderid']);
		$order_id = str_replace("smspay_","",$orderid);
		
		$nowOrder = M('Order_sms')->getOne(array('sms_order_id'=>$order_id));
		if($nowOrder) {
			include display('order_sms_detail');
		}
	}
	
	$nowOrder = M('Order')->findOrderById($_GET['orderid']);
	if(empty($nowOrder) || $nowOrder['user_order_id'] > 0 || $nowOrder['uid'] != $_SESSION['wap_user']['uid']) {
		pigcms_tips('该订单不存在','none');
	}
	
	//店铺资料
	$now_store = M('Store')->wap_getStore($nowOrder['store_id']);
	if(empty($now_store)) pigcms_tips('您访问的店铺不存在','none');
	
	// 查看满减送
	$order_data['order_ward_list'] = M('Order_reward')->getByOrderId($nowOrder['order_id']);
	// 使用优惠券
	$order_data['order_coupon_list'] = M('Order_coupon')->getList($nowOrder['order_id']);
	// 查看使用的折扣
	$order_discount_list = M('Order_discount')->getByOrderId($nowOrder['order_id']);
	// 查看使用积分
	$order_point = D('Order_point')->where(array('order_id' => $nowOrder['order_id']))->find();
	
	foreach ($order_discount_list as $order_discount) {
		$order_data['discount_list'][$order_discount['store_id']] = $order_discount['discount'];
	}
	
	$order_peerpay_list = array();
	if ($nowOrder['payment_method'] == 'peerpay') {
		$order_peerpay_list = D('Order_peerpay')->where(array('order_id' => $nowOrder['order_id'], 'status' => 1))->select();
	}
	
	// 送他人地址
	$order_friend_address_list = array();
	if ($nowOrder['shipping_method'] == 'send_other' && $nowOrder['send_other_type'] != 2) {
		$order_friend_address_list = D('Order_friend_address')->where(array('order_id' => $nowOrder['order_id']))->select();
		
		$product_list = M('Order_product')->orderProduct($nowOrder['order_id']);
		$product_image = $product_list[0]['image'];
		
		//分享配置 start
		$share_conf 	= array(
				'title' 	=> '小伙伴快来领礼品', // 分享标题
				'desc' 		=> str_replace(array("\r","\n", "'"), array('','', ''),  $nowOrder['send_other_comment']), // 分享描述
				'link' 		=> option('config.wap_site_url') . '/order_friend_share.php?order_id=' . $nowOrder['order_no_txt'], // 分享链接
				'imgUrl' 	=> $product_image, // 分享图片链接
				'type'		=> '', // 分享类型,music、video或link，不填默认为link
				'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
		);
		import('WechatShare');
		$share 		= new WechatShare();
		$shareData 	= $share->getSgin($share_conf);
	}
	
	// 团购出来分享按钮
	$tuan_team = array();
	if ($nowOrder['type'] == 6) {
		$product_list = M('Order_product')->orderProduct($nowOrder['order_id']);
		$product_image = $product_list[0]['image'];
		
		$tuan_team = D('Tuan_team')->where(array('team_id' => $nowOrder['data_item_id']))->find();
		$tuan = D('Tuan')->where(array('id' => $tuan_team['tuan_id']))->find();
		
		//分享配置 start
		$share_conf 	= array(
				'title' => '宝贝正在优惠中，速来参团。', // 分享标题
				'desc' => str_replace(array("\r","\n", "'"), array('','', ''), $product_list[0]['name']), // 分享描述
				'link' => option('config.site_url') . '/webapp/groupbuy/#/detailinfo/' . $tuan_team['tuan_id'] . '/' . $tuan_team['type'] . '/' . $tuan_team['item_id'] . '/' . $tuan_team['team_id'], // 分享链接
				'imgUrl' => $product_image, // 分享图片链接
				'type' => '', // 分享类型,music、video或link，不填默认为link
				'dataUrl' => '', // 如果type是music或video，则要提供数据链接，默认为空
		);
		import('WechatShare');
		$share 		= new WechatShare();
		$shareData 	= $share->getSgin($share_conf);
	}
	
	// 用户线下做单模拟商品
	if ($nowOrder['is_offline'] && empty($nowOrder['proList'])) {
		$product_debug = array();
		$product_debug['product_id'] = 0;
		$product_debug['name'] = '手工做单虚拟商品';
		$product_debug['image'] = getAttachmentUrl('images/default_shop.png', true);
		$product_debug['pro_price'] = $nowOrder['sub_total'];
		$product_debug['pro_num'] = 1;
		$product_debug['supplier_id'] = 0;
		$product_debug['wholesale_product_id'] = 0;
		
		$nowOrder['proList'][] = $product_debug;
	}
	
	// 预售订单出现付尾款
	$presale_pay_btn = true;
	if ($nowOrder['type'] == 7 && $nowOrder['order_id'] != $nowOrder['presale_order_id']) {
		$presale = D('Presale')->where(array('id' => $nowOrder['data_id']))->find();
		if ($presale['final_paytime'] < time()) {
			$presale_pay_btn = false;
		} else {
			if ($nowOrder['presale_order_id'] > 0) {
				$order_presale = D('Order')->where(array('order_id' => $nowOrder['presale_order_id']))->find();
				if ($order_presale['status'] > 1) {
					$presale_pay_btn = false;
				}
			}
		}
	} else if ($nowOrder['type'] == 7 && $nowOrder['order_id'] == $nowOrder['presale_order_id']) {
		$presale_pay_btn = false;
	}
	
	include display('order_detail');
}else if(!empty($_GET['del_id'])){
	if(empty($wap_user)) {
		json_return(1000,'您尚未登录');
	}
	
	$condition_order['order_id'] = intval($_GET['del_id']);
	$condition_order['uid'] = $wap_user['uid'];
	$condition_order['status'] = array('<','2');
	$database_order = D('Order');
	$nowOrder = $database_order->where($condition_order)->find();
	
	if(empty($nowOrder)) {
		json_return(1001, '该订单不存在或已关闭');
	}
	
	if(M('Order')->cancelOrder($nowOrder, 2)){
		if($nowOrder['status'] == 1 && !empty($wap_user['uid'])) {
			M('Store_user_data')->editUserData($nowOrder['store_id'],$wap_user['uid'],'unpay','');
		}
		json_return(0,'关闭订单成功');
	}else{
		json_return(1001,'关闭订单失败');
	}
} else if (strtolower($_GET['action']) == 'complate' && !empty($_GET['order_no'])) {
	import('source.class.Order');

	$order_no = trim($_GET['order_no']);
	$order = D('Order')->where(array('order_no' => $order_no, 'status' => array('in', array(2, 3, 7))))->find();
	
	if (empty($order)) {
		json_return(1001, '订单不存在');
	} else if ($order['status'] != 7) {
		json_return(1000, '订单状态不正确，暂不能交易完成');
	} else if ($order['uid'] != $wap_user['uid']) {
		json_return(1000, '请操作自己的订单');
	}

	$result = Order::complate2($order['order_id']);
	if (!empty($result['err_code'])) {
		json_return($result['err_code'], $result['err_msg']);
	} else {
		json_return(0, '订单交易完成');
	}
} else if (strtolower($_GET['action']) == 'order_send' && !empty($_GET['order_no'])) {
	$store_id = $_GET['store_id'];
	
	if (empty($store_id)) {
		json_return(1000, '缺少最基本的参数');
	}
	
	$store = M('Store')->getStore($store_id);
	if ($store['uid'] != $wap_user['uid']) {
		json_return(1000, '请操作自己的订单');
	}
	
	$order_no = trim($_GET['order_no']);
	$order = D('Order')->where(array('order_no' => $order_no, 'store_id' => $store_id))->find();
	
	if (empty($order)) {
		json_return(1001, '订单不存在');
	}
	
	if (!in_array($order['status'], array(2, 3))) {
		json_return(1000, '订单状态不正确，不能确认自提');
	}
	
	if (D('Order')->where(array('order_id' => $order['order_id']))->data(array('status' => 7, 'delivery_time' => time()))->save()) {
		json_return(0, '订单确认收货完成');
	} else {
		json_return(1000, '操作失败');
	}
} else{
	if(empty($wap_user)) redirect('./login.php');
	$store_id = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误','none');
	$page = max(1, $_REQUEST['page']);
	$limit = 10;
	//店铺资料
    $now_store = D('Store')->where(array('store_id'=>$store_id))->find();
	if(empty($now_store)) pigcms_tips('您访问的店铺不存在','none');

	$now_store['url'] = option('config.wap_site_url').'/home.php?id='.$store_id;
	if(empty($now_store['logo'])) {
		$now_store['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
	} else if (stripos($now_store['logo'], 'http://') === false && stripos($now_store['logo'], 'https://') === false) {
		$now_store['logo'] = getAttachmentUrl($now_store['logo']);
	}
	$now_store['ucenter_url'] = option('config.wap_site_url').'/ucenter.php?id=' . $store_id;
	$now_store['physical_url'] = option('config.wap_site_url').'/physical.php?id=' . $store_id;

	$action = isset($_GET['action']) ? $_GET['action'] : 'all';
	$uid = $wap_user['uid'];
	$where = array();
	$where['uid'] = $uid;
	$where['store_id'] = $store_id;
	$where['user_order_id']  = 0; //排除分销订单
	$page_url = 'order.php?id=' . $store_id . '&action=' . $action;
	switch($action){
		case 'unpay':
			$pageTitle = '待付款的订单';
			$where['status'] = 1;
			break;
		case 'unsend':
			$pageTitle = '待发货的订单';
			$where['status'] = 2;
			break;
		case 'send':
			$pageTitle = '已发货的订单';
			$where['status'] = 3;
			break;
		case 'complete':
			$pageTitle = '已完成的订单';
			$where['status'] = array('in',array('4','7'));
			break;
		default:
			$pageTitle = '全部订单';
			$where['status'] = array('!=', 5);
	}
	
	$count = D('Order')->where($where)->count('order_id');

	$orderList = array();
	$pages = '';
	if ($count > 0) {
		$page = min($page, ceil($count / $limit));
		$offset = ($page - 1) * $limit;
		
		$orderList = D('Order')->where($where)->order('order_id desc')->limit($offset . ', ' . $limit)->select();
		$order_id_arr = array();
		$store_id_arr = array();
		$physical_id_arr = array();
		
		$config_order_return_date = option('config.order_return_date');
		$config_order_complete_date = option('config.order_complete_date');
		
		$product_debug = array();
		$product_debug['product_id'] = 0;
		$product_debug['name'] = '手工做单虚拟商品';
		$product_debug['image'] = getAttachmentUrl('images/default_shop.png', true);
		$product_debug['pro_price'] = 0;
		$product_debug['pro_num'] = 1;
		$product_debug['supplier_id'] = 0;
		$product_debug['wholesale_product_id'] = 0;
		$product_debug['debug'] = 1;
		
		foreach ($orderList as &$value) {
			
			//预售订单处理
			if($value['type'] == 7) {
				$presale_id = $value['data_id'];
				$presale = D('Presale')->where(array('id' => $presale_id))->find();
				
				if ($presale['final_paytime'] < time()) {
					// 过期后不用支付
					$value['show_pay_button'] = 'no';
				} else {
					if($value['order_id'] != $value['presale_order_id']) {
						if($value['presale_order_id']) {
							$order_info = D('Order')->where(array('order_id'=>$value['presale_order_id']))->find();
							if($order_info['status']>1) {
								//定金订单 不显示付款
								$value['show_pay_button'] = 'no';
							} else {
								$value['show_pay_button'] = 'yes';
							}
						} else {
							$value['show_pay_button'] = 'yes';
						}
					}  else {
						if($value['status']>1) {
							//定金订单 不显示付款
							$value['show_pay_button'] = 'no';
						} else {
							$value['show_pay_button'] = 'yes';
						}
					}
				}
			}
			if ($value['comment']) {
				$value['comment_arr'] = unserialize($value['comment']);
			}
			
			$value['address'] = unserialize($value['address']);
			$value['order_no_txt'] = option('config.orderid_prefix').$value['order_no'];
			
			if ($value['status'] < 2) {
				$value['url'] = './pay.php?id='.$value['order_no_txt'];
			} else {
				$value['url'] = './order.php?orderid='.$value['order_id'];
			}
			

			
//////////////////////////////
			if ($value['type'] == 6) {
				if ($value['status'] > 1) {
					$tuan_team = D('Tuan_team')->where(array('tuan_id' => $value['data_id'], 'team_id' => $value['data_item_id']))->find();
					if (empty($tuan_team)) {
						$value['product_url'] = option('config.site_url') . '/webapp/groupbuy/#/details/' . $value['data_id'];
					} else {
						$value['product_url'] = option('config.site_url') . '/webapp/groupbuy/#/detailinfo/' . $tuan_team['tuan_id'] . '/' . $tuan_team['type'] . '/' . $tuan_team['item_id'] . '/' . $tuan_team['team_id'];
					}
				} else {
					$value['product_url'] = option('config.site_url') . '/webapp/groupbuy/#/details/' . $value['data_id'];
				}
			}
			$order_id_arr[$value['order_id']] = $value['order_id'];
				
			if ($value['shipping_method'] == 'selffetch') {
				if ($value['address']['physical_id']) {
					$physical_id_arr[$value['address']['physical_id']] = $value['address']['physical_id'];
				} else if ($value['address']['store_id']) {
					$store_id_arr[$value['address']['store_id']] = $value['address']['store_id'];
				}
			}
				
			$is_return = false;
			if ($value['status'] == '7') {
				if ($value['delivery_time'] + $config_order_return_date * 24 * 3600 >= time()) {
					$is_return = true;
				}
			} else if ($value['status'] == '3') {
				if ($value['send_time'] + $config_order_complete_date * 24 * 3600 >= time()) {
					$is_return = true;
				}
			} else if ($value['status'] == 2) {
				$is_return = true;
			}
				
			$is_rights = false;
			if (in_array($value['status'], array(2, 3, 4, 7)) && $value['add_time'] + 5 * 24 * 3600 < time()) {
				$is_rights = true;
			}
				
			$value['is_return'] = $is_return;
			$value['is_rights'] = $is_rights;
			$value['order_product_list'] = M('Order_product')->orderProduct($value['order_id']);
				
			if ($value['is_offline'] && empty($value['order_product_list'])) {
				$product_debug['pro_price'] = $value['sub_total'];
				$value['order_product_list'][] = $product_debug;
			}
			
			//退货
			$value['returning'] = false;
			if (D('Return')->where(array('order_id' => $value['order_id'], 'status' => array('!=', 5)))->count('id')) {
				$value['returning'] = true;
			}
		
/////////////////////////////////
		}
		
		$physical_list = array();
		$store_contact_list = array();
		if (!empty($store_id_arr)) {
			$store_contact_list = M('Store_contact')->storeContactList($store_id_arr);
		}
		
		if (!empty($physical_id_arr)) {
			$physical_list = M('Store_physical')->getListByIDList($physical_id_arr);
		}
		
		// 分页
		import('source.class.user_page');
		$user_page = new Page($count, $limit, $page);
		$pages = $user_page->show();
	}
	/*$orderList = D('')->field('`o`.`order_id`,`o`.`order_no`,`o`.`total`,`o`.`sub_total`,`o`.`pro_count`,`o`.`status`,`o`.`float_amount`,`op`.`pro_num`,`op`.`pro_price`,`op`.`sku_data`,`p`.`image`,`p`.`name`')->table(array('Order'=>'o','Order_product'=>'op','Product'=>'p'))->where($condition_order)->order('`o`.`order_id` DESC')->select();

	foreach($orderList as &$value){
		if($value['sku_data']){
			$value['sku_data_arr'] = unserialize($value['sku_data']);
		}
		if($value['comment']){
			$value['comment_arr'] = unserialize($value['comment']);
		}
		$value['order_no_txt'] = option('config.orderid_prefix').$value['order_no'];
		$value['image'] = getAttachmentUrl($value['image']);
		if($value['status'] < 2){
			$value['url'] = './pay.php?id='.$value['order_no_txt'];
		}else{
			$value['url'] = './order.php?orderid='.$value['order_id'];
		}
	}*/

	
	if($_REQUEST['ajax'] == '1') {
		$json_return['count'] = $count;	
		$json_return['list'] = $orderList;	
		$comment_url = 'comment.php?action=comment_by_order&id=' . $store_id;
		$complate_url = 'order.php?action=complate';
		
		$json_return['url'] = array(
			'comment_url' => $comment_url,
			'complate_url' => $complate_url
		);
		
		$json_return['physical_list'] = $physical_list;
		$json_return['store_contact_list'] = $store_contact_list;
		if(count($orderList) < $limit){
			$json_return['noNextPage'] = true;
		}
		$json_return['max_page'] = ceil($count / $limit);
		json_return(0, $json_return);
	}

	//分享配置 start
	$share_conf 	= array(
		'title' 	=> $now_store['name'].'-店铺订单', // 分享标题
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

	 
	include display('order');
}
	
echo ob_get_clean();
?>