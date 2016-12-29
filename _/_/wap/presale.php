<?php

/**
 * 预售
 * User: pigcms-s
 * Date: 2016/02/20
 * Time: 18:11
 */
require_once dirname(__FILE__) . '/global.php';
$id = $_REQUEST["id"];
$time = time();



/*
$order = 'sales desc';
$team_list = D('Drp_team')->where(array('supplier_id'=>$now_store['root_supplier_id']))->order($order)->select();
$drp_team = M('Drp_team');
$where = array();
$where['drp_team_id'] = $now_store['drp_team_id'];
$team_members = $drp_team->getMembers($where);
*/
$action = $_GET['action'];
switch($action) {
	
	case 'order':
		$pages = $_GET['page'];
		$page = max(1, $_GET['page'] + 0);
			
		if (empty($id)) {
			echo json_encode(array('status' => false, 'msg' => '参数错误'));
			exit;
		}
		
		$presale_info = D('') -> table("Product p")
							  -> join("Presale pre On p.product_id=pre.product_id","LEFT")
							  -> where("p.quantity > 0 and p.status=0 and p.soldout=0 and pre.is_open=1 and pre.id=".$id)
							  -> field("pre.*,p.name,p.info,p.intro,p.price,p.original_price,p.image")
							  -> find();		

		$counts = D('Order')->where("type=7 and order_id!=presale_order_id and data_id='".$id."'")->field("count(order_id) counts")->find();
		$count = $counts['counts'] ? $counts['counts'] : 0;
	
		$order_list = array();
		//$pages = '';
		$limit = 5;
		$total_page = ceil($count / $limit);
		if ($count > 0) {
			$page = min($page, ceil($count / $limit));
			$offset = ($page - 1) * $limit;
			//$order_product_list = $Order_product_model->getProductBuyList($product_id, $limit, $offset, true);
				
			$order_list = D('') -> table("Order o")
								-> join("User u On o.uid = u.uid","LEFT") 
								-> limit($offset.",".$limit)
								-> where("o.type=7 and o.order_id!=o.presale_order_id and o.data_id='".$id."'")
								-> select();

						  
			foreach($order_list as $k=>&$v) {
				if($v['nickname']) {
					$v['nickname'] = anonymous($user['nickname']);
				}  else {
					$v['nickname'] = "匿名";
				}
				if ($v['avatar']) {
					$v['avatar'] = getAttachmentUrl($v['avatar']);
				} else {
					$v['avatar'] = getAttachmentUrl('images/touxiang.png', false);
				}

			}
			
		}

		$json_return['list'] = $order_list;
		$json_return['count'] = $count;
		$json_return['maxpage'] = ceil($count / $limit);
			
		$json_return['noNextPage'] = false;
		if( (count($json_return['list']) < $limit)|| ($total_page <= $pages)){
			$json_return['noNextPage'] = true;
		}
			
		json_return(0, $json_return);
		break;
}


//

if(!$id) {
	pigcms_tips('您输入的网址有误','none');
}

$presale_info = D('')-> table("Product p")
					 -> join("Presale pre On p.product_id=pre.product_id","LEFT")
					// -> where("p.quantity > 0 and p.status=0 and p.soldout=0 and pre.is_open=1 and pre.id=".$id)
					 -> where("pre.id=".$id)
					 -> field("pre.*,p.name as product_name,p.info,p.intro,p.price as product_price,p.original_price,p.image,p.soldout,p.quantity")
					 -> find();
					
if($presale_info['image']) {
	$presale_info['image'] = getAttachmentUrl($presale_info['image']);
}
$store_id = $presale_info['store_id'];
//店铺资料
$now_store = M('Store')->wap_getStore($store_id);

if(empty($now_store)) pigcms_tips('您访问的店铺不存在','none');
	
$product_id = $presale_info['product_id'];
$nowProduct = D('Product')->where(array('product_id' => $presale_info['product_id']));
//$now_store = D('Store')->where(array('store_id'=>$presale_info['store_id']))->find();
if(!$presale_info) {
	pigcms_tips('该预售已下架！','none');
}

//预售特权
$power = array();
if($presale_info['privileged_cash']) {
	$power['cash'] = $presale_info['privileged_cash'];
}
if($presale_info['privileged_coupon']){
	
	$coupon_where = array(
		'id'=>$presale_info['privileged_coupon'],
		'type'=>2,
		'status'=>1,
		'start_time'=>array('<',$time),
		'end_time'=>array('>',$time),
	);

	$coupon = D('Coupon')->where($coupon_where)->find();
	if($coupon) {
		$power['coupon'] = $coupon;
	}
}
if($presale_info['privileged_present']) {
	
	$present = D('Present')->where(array('id'=>$presale_info['privileged_present'],'start_time'=>array('<',$time),'end_time'=>array('>',$time),'status'=>1))->find();
	if($present) {
		$power['present'] = $present;
	}
	
}





//var_dump($team_members);
include display('presale_index');
echo ob_get_clean();