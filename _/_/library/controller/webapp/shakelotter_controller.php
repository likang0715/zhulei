<?php
/**
 * webapp 接口
 */
class shakelottery_controller extends base_controller{
	public function __construct(){
		parent::__construct();
		if(empty($_SESSION['wap_user'])){
			json_return(101,'未登陆或登陆超时');
		}
	}
        // 产品 - 产品列表
	public function product(){
	    	$store_id = intval($_REQUEST['store_id']);
		if (empty($store_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		$where = '`store_id=`'.$store_id.' AND (`status` = 2 OR `status` = 4 OR `status` = 6) ';
		$page = intval($_GET['page']);
		$page=!empty($page) ? $page : 1;
		$count=D('Zc_product')->where($where)->count('product_id');
		$page_nub = 12;//分页数
		$firstRows=($page-1)*$page_nub;
		$productList=D('Zc_product')->where($where)->order('`product_id` DESC')->limit($firstRows.','.$page_nub)->select();
		foreach($productList as $k=>$v){
			$productList[$k]['productThumImage'] = getAttachmentUrl($v['productThumImage']);
			$productList[$k]['productListImg'] = getAttachmentUrl($v['productListImg']);
			$productList[$k]['productFirstImg'] = getAttachmentUrl($v['productFirstImg']);
			$productList[$k]['productImage'] = getAttachmentUrl($v['productImage']);
			$productList[$k]['productImageMobile'] = getAttachmentUrl($v['productImageMobile']);
		}
		$productList = !empty($productList) ? $productList : array();
		$isTrue      = !empty($productList) ? true         : false;
		$arr=array();
		$arr['project_list'] = $productList;
		$arr['page_count']   = $count;
		$arr['next_page']    = $isTrue;
		json_return(0,$arr);
	}
	// 产品详情
        public function productDetails(){
		$databases_zc_product = D('Zc_product');
		$databases_zc_product_topic = D('Zc_product_topic');
		$databases_zc_product_repay = D('Zc_product_repay');
		$databases_zc_product_load = D('Zc_product_load');
		$id = intval($_GET['id']);
		if(empty($id)){
			json_return(122,'参数错误');
		}
		$where = '`product_id` ='.$id.'  AND (`status`= 2 OR `status`= 4 OR `status`= 6)';
		$productInfo = $databases_zc_product->where($where)->find();
		if(empty ($productInfo)){
			json_return(121,'没有查询到此产品');
		}
		$productInfo['productThumImage'] = getAttachmentUrl($productInfo['productThumImage']);
		$productInfo['productListImg'] = getAttachmentUrl($productInfo['productListImg']);
		$productInfo['productFirstImg'] = getAttachmentUrl($productInfo['productFirstImg']);
		$productInfo['productImage'] = getAttachmentUrl($productInfo['productImage']);
		$productInfo['productImageMobile'] = getAttachmentUrl($productInfo['productImageMobile']);

		if($productInfo['raiseType']==0 && $productInfo['status']==4){
			$endtime=$productInfo['start_time']+($productInfo['collectDays']*86400);
			if($endtime<$_SERVER['REQUEST_TIME']){
				json_return(124,'该产品已经结束');
			}
		}
		$topicInfo = $databases_zc_product_topic->where(array('product_id'=>$id))->select();
		$repayInfo = $databases_zc_product_repay->where(array('product_id'=>$id))->select();
		foreach($repayInfo as $k=>$v){
			$productInfo[$k]['images'] = getAttachmentUrl($v['images']);
		}
		$loadInfo = $databases_zc_product_load->where(array('product_id'=>$id))->select();
		$productUser = D('User')->field('`nickname`')->where(array('uid'=>$productInfo['uid']))->find();
		$productInfo['nickname'] =  $productUser['nickname'];
		foreach($topicInfo as $k=>$v){
			$userInfo = D('User')->where(array('uid'=>$v['uid']))->find();
			$topicInfo[$k]['avatar'] = getAttachmentUrl($userInfo['avatar']);
			$topicInfo[$k]['nickname'] = $userInfo['nickname'];
		}
		$arr = array();
		$arr['productInfo'] = $productInfo;
		$arr['topicList']   = $topicInfo;
		$arr['repayList']   = $repayInfo;
		$arr['loadList']    = $loadInfo;
		json_return(0,$arr);
        }
        //我发起的
        public function myAddProduct(){
		$status = intval($_GET['status']);
		$status = !empty($status) ? $status : 'all';
		switch ($status) {
			case 'all':
				$where = "`uid`=".$_SESSION['wap_user']['uid']."  AND (`status` = 4 OR `status` = 6 OR `status`=7)";
				break;
			case 4:
				$where = "`uid`=".$_SESSION['wap_user']['uid']."  AND `status` = 4";
				break;
			case 6:
				$where = "`uid`=".$_SESSION['wap_user']['uid']."  AND `status` = 6";
				break;
			case 7:
				$where = "`uid`=".$_SESSION['wap_user']['uid']."  AND `status` = 7";
				break;
			default:
				$where = "`uid`=".$_SESSION['wap_user']['uid']."  AND (`status` = 4 OR `status` = 6 OR `status`=7)";
				break;
		}
		$page = intval($_GET['page']);
		$count=D('Zc_product')->where($where)->count('product_id');
		$page=!empty($page) ? $page : 1;
		$page_nub = 12;
		$firstRows=($page-1)*$page_nub;
		$productList = D('Zc_product')->where($where)->order("product_id DESC")->limit($firstRows.','.$page_nub)->select();
		foreach($productList as $k=>$v){
			$productList[$k]['topic_count'] = D('Zc_product_topic')->where(array('product_id'=>$v['product_id']))->count('topic_id');
			$productList[$k]['productThumImage'] = getAttachmentUrl($v['productThumImage']);
			$productList[$k]['productListImg']   = getAttachmentUrl($v['productListImg']);
			$productList[$k]['productFirstImg']  = getAttachmentUrl($v['productFirstImg']);
			$productList[$k]['productImage']     = getAttachmentUrl($v['productImage']);
			$productList[$k]['productImageMobile'] = getAttachmentUrl($v['productImageMobile']);
		}
		$productList = !empty($productList)  ? $productList  : array();
		$isTrue      = !empty($productList)  ? true          : false;
		$arr = array();
		$arr['productList']=$productList;
		$arr['page_count'] = $count;
		$arr['next_page'] = $isTrue;
		json_return(0,$arr);
        }
        //我支持的项目
        public function myProduct(){
		$where = "`uid` = ".$_SESSION['wap_user']['uid']." AND `is_delete` = 0 AND `order_type` = 2";
		$order_status = intval($_GET['status']);
		$order_status = !empty($order_status) ? $order_status : 'all';
		if($order_status == 2){
		   $where  .= " AND `order_status` = 2";
		}elseif($order_status == 1){
		    $where .= " AND `order_status` = 1";
		}
		$page = intval($_GET['page']);
		$count=D('Invest_order')->where($where)->count('id');
		$page=!empty($page) ? $page : 1;
		$page_nub = 12;
		$firstRows=($page-1)*$page_nub;
		$order_list = D('Invest_order')->where($where)->limit($firstRows.','.$page_nub)->select();
		foreach($order_list as $k=>$v){
			$productInfo = D('Zc_product')->where(array('product_id'=>$v['project_id']))->find();
			$order_list[$k]['product_id'] = $productInfo['product_id'];
			$order_list[$k]['productName'] = $productInfo['productName'];
			$order_list[$k]['productListImg'] = getAttachmentUrl($productInfo['productListImg']);
			$order_list[$k]['collect'] = $productInfo['collect'];
			$order_list[$k]['amount'] = $productInfo['amount'];
			$order_list[$k]['raiseType'] = $productInfo['raiseType'];
			$order_list[$k]['status'] = $productInfo['status'];
			$order_list[$k]['classname'] = $productInfo['classname'];
			unset($productInfo);
		}
		$order_list  = !empty($order_list) ? $order_list   : array();
		$isTrue      = !empty($order_list) ? true          : false;
		$arr=array();
		$arr['order_list']=$order_list;
		$arr['next_page']=$isTrue;
		json_return(0,$arr);
        }
        //订单详情
        public function orderDetails(){
		$databases_invest_order = D('Invest_order');
		$databases_product = D('Zc_product');
		$databases_load = D('Zc_product_load');
		$databases_user = D('User');
		$databases_repay = D('Zc_product_repay');
		$orderInfo = $databases_invest_order->where(array('id'=>$_GET['id']))->find();
		$productInfo = $databases_product->where(array('product_id'=>$orderInfo['project_id']))->find();
		$repayInfo = $databases_repay->where(array('repay_id'=>$orderInfo['repay_id']))->field('`redoundContent`')->find();
		$productInfo['productListImg'] = getAttachmentUrl($productInfo['productListImg']);
		$tmp='{
			"err_code":0,
			"err_msg" :{
				"orderInfo":'.json_encode($orderInfo).',
		        "productInfo":'.json_encode($productInfo).',
				"repayInfo":'.json_encode($repayInfo).'
			}
		}';
		echo $tmp;die;
        }
        public function orr(){
        	$s=D('Invest_order')->where(1)->find();
        	var_dump($s);
        }


}

 ?>