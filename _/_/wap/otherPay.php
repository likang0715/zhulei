<?php
	require_once dirname(__FILE__).'/global.php';

	$condition = authArray($_GET['source']);
	$store = D('Store')->where($condition)->field('store_id')->find();
	if(!$store){
		pigcms_tips('该店铺没有开启任何活动！','none');
	}
	$_GET['orderid']	= empty($_GET['orderid'])?$_GET['single_orderid']:$_GET['orderid'];//对接订单号兼容。
	$orderData = json_encode(array(
		'quantity'      => 1,
		'isAddCart'     => 0,
		'store_id'      => $store['store_id'],
		'price'         => (float)$_GET['price'],
		'activity_data' => bakData(htmlspecialchars($_GET['source'])),
		'type'          => 4,
		'skuId'         => intval($_GET['sku_id']),
		'proId'         => intval($_GET['product_id']),
		'wecha_id'		=> htmlspecialchars($_GET['wecha_id']),
		'actId'         => intval($_GET['id']),		//活动id
		'order_id'      => $_GET['true_orderid']?intval($_GET['true_orderid']):$_GET['orderid'],		//活动id
		'actType'       => htmlspecialchars(strtolower($_GET['from'])),		//活动id
	));
	// dump($_GET);exit;
	// dump(json_decode($orderData));exit;
	$orderName = htmlspecialchars($_GET['orderName']);
	function bakData($type){
		$return = array();
		switch($type){
			case 'pigcms':
			$return = array(
				'token'=>htmlspecialchars($_GET['token']),
				'wecha_id'=>htmlspecialchars($_GET['wecha_id']),
				'orderid'=>htmlspecialchars($_GET['orderid']),
				'from'=>'pigcms_'.htmlspecialchars($_GET['from']),
			);
		}
		return $return;
	}
	function authArray($source){
		$condition = array();
		switch($source){
			case 'pigcms':
				$condition['pigcmsToken'] = htmlspecialchars($_GET['token']);
				break;
		}
		return $condition;
	}

	include display('otherPay');
	echo ob_get_clean();
?>
