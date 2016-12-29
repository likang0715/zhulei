<?php
/**
 * webapp 接口
 */
class zc_controller extends base_controller{
        //我发起的
        public function productAdd(){
		$uid=$_SESSION['wap_user']['uid'];
		if(empty($uid)){
			json_return(1002, '请先登录');
		}
	    	$store_id = intval($_REQUEST['store_id']);
		if (empty($store_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		$status = intval($_GET['status']);
		$status = !empty($status) ? $status : 0;
		$where = '`store_id=`'.$store_id.' AND `uid`='.intval($uid);
		switch ($status) {
			case 0:
				$where .= "  AND (`status` = 4 OR `status` = 6 OR `status`=7)";
				break;
			case 4:
				$where .= "  AND `status` = 4";
				break;
			case 6:
				$where .= "  AND `status` = 6";
				break;
			case 7:
				$where .= "  AND `status` = 7";
				break;
			default:
				$where .= "  AND (`status` = 4 OR `status` = 6 OR `status`=7)";
				break;
		}
		$count=D('Zc_product')->where($where)->count('product_id');
		$page=!empty($_GET['page']) ? intval($_GET['page']) : 1;
		$page_nub = 12;
		$firstRows=($page-1)*$page_nub;
		$productList = D('Zc_product')->where($where)->order("product_id DESC")->limit($firstRows.','.$page_nub)->select();
		foreach($productList as $k=>$v){
			$productList[$k]['count_topic']        = D('Zc_product_topic')->where(array('product_id'=>$v['product_id']))->count('topic_id');
			$productList[$k]['productThumImage']   = getAttachmentUrl($v['productThumImage']);
			$productList[$k]['productListImg']     = getAttachmentUrl($v['productListImg']);
			$productList[$k]['productFirstImg']    = getAttachmentUrl($v['productFirstImg']);
			$productList[$k]['productImage']       = getAttachmentUrl($v['productImage']);
			$productList[$k]['productImageMobile'] = getAttachmentUrl($v['productImageMobile']);
		}
		$productList = !empty($productList)  ? $productList  : array();
		$isTrue      = !empty($productList)  ? true          : false;
		$arr = array();
		$arr['product_list']=$productList;
		$arr['page_count'] = $count;
		$arr['next_page'] = $isTrue;
		json_return(0,$arr);
        }
        //我支持的订单
        public function productSupport(){
		$uid=$_SESSION['wap_user']['uid'];
		if(empty($uid)){
			json_return(1002, '请先登录');
		}
	    	$store_id = intval($_REQUEST['store_id']);
		if (empty($store_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		$where_order = "`uid`=".intval($uid)." AND `is_delete` = 0 AND `order_type` = 2";
		$order_status = intval($_GET['status']);
		$order_status = !empty($order_status) ? $order_status : '0';
		switch ($order_status) {
			case '0':
				break;
			case '1':
				$where_order  .= "  AND `order_status` = 1";
				break;
			case '2':
				$where_order  .= "  AND `order_status` = 2";
				break;
		}
		$page=!empty($_GET['page']) ? intval($_GET['page']) : 1;
		$page_nub = 12;
		$firstRows=($page-1)*$page_nub;
		$where_id = '`store_id`='.$store_id.' AND (`status`=4 OR `status`=6 OR `status`=7)';
		$product_list=D('Zc_product')->where($where_id)->field('product_id,productName,productImageMobile,classname')->select();
		$pro_list=$id_arr=$arr=$order_list=array();
		if(!empty($product_list)){
			foreach ($product_list as $k => $v) {
				array_push($id_arr, $v['product_id']);
				$pro_list[$v['product_id']]=$v;
			}
			$order_list = D('Invest_order')->where($where_order)->limit($firstRows.','.$page_nub)->field('id,project_id,pay_money,zcpay_no,order_status')->select();
			$order_list = !empty($order_list) ? $order_list : array();
			foreach ($order_list as $k => $v) {
				if(in_array($v['project_id'],$id_arr)){//是这个店铺的订单
					$order_list[$k]['productName'] = $pro_list[$v['project_id']]['productName'];
					$order_list[$k]['productImageMobile'] = getAttachmentUrl($pro_list[$v['project_id']]['productImageMobile']);
					$order_list[$k]['classname'] =$pro_list[$v['project_id']]['classname'];
				}
			}
		}
		$isTrue      		= !empty($order_list) ? true          : false;
		$arr['order_list']      =  $order_list;
		$arr['next_page']	=  $isTrue;
		json_return(0,$arr);
        }
        //假删除
        public function productDelete(){
        	$uid=$_SESSION['wap_user']['uid'];
        	if(empty($uid)){
        		json_return(1201,'请先登录');
        	}
        	$id=intval($_GET['id']);
        	if(empty($id)){
        		json_return(1200,'参数错误');
        	}
        	$info_order=D('Invest_order')->where(array('uid'=>$uid,'id'=>$id))->find();
        	if(empty($info_order)){
        		json_return(1211,'订单不存在');
        	}
		$effId = D('Invest_order')->where(array('uid'=>$uid,'id'=>$id))->data(array('is_delete'=>1))->save();
		if(!empty($effId)){
			json_return(0,'订单删除成功');
		}else{
			json_return(1212,'订单删除失败请重试');
		}
        }


}

 ?>