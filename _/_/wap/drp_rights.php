<?php
/**
 * 维权管理
 * User: pigcms_21
 * Date: 2015/10/9
 * Time: 14:13
 */
require_once dirname(__FILE__).'/global.php';

if (empty($_SESSION['wap_drp_store'])) {
	pigcms_tips('您没有权限访问，<a href="./home.php?id=' . $_COOKIE['wap_store_id'] . '">返回首页</a>','none');
}

$a = $_GET['a'];
$a_arr = array('index', 'list', 'detail');
if (!in_array($a, $a_arr)) {
	$a = 'index';
}

if ($a == 'index') {
	
	redirect('./drp_return.php');
	return;
	
	$store_id = $_SESSION['wap_drp_store']['store_id'];
	$rights_model = M('Rights');
	$count = $rights_model->getCount("store_id = '" . $store_id . "'");
	
	include display('drp_rights_index');
	echo ob_get_clean();
} else if ($a == 'list') {
	$store_id = $_SESSION['wap_drp_store']['store_id'];
	$rights_model = M('Rights');
	$count = $rights_model->getCount("store_id = '" . $store_id . "'");
	$page_size = isset($_GET['pagesize']) ? intval(trim($_GET['pagesize'])) : 10;
	$page = max(1, $_GET['p']);
	
	import('source.class.user_page');
	$page = new Page($count, $page_size, $page);
	
	$rights_list = $rights_model->getList("r.store_id = '" . $store_id . "'", $page->listRows, $page->firstRow);
	$html = '';
	
	foreach ($rights_list as $rights) {
		/*$sku_html = '';
		if ($rights['sku_data']) {
			$sku_data = unserialize($rights['sku_data']);
			foreach ($sku_data as $tmp) {
				$sku_html .= '<br />' . $tmp['name'] . ':' . $tmp['value'];
			}
		}*/
		$html .= '<tr>';
		$html .= '	<td class="left"><a href="good.php?id=' . $rights['product_id'] . '&store_id=' . $store_id . '"><img src="' . $rights['image'] . '" style="width:60px; height:60px;" /></a></td>';
		//$html .= '	<td class="left">' . $rights['type_txt'] .'</td>';
		$html .= '	<td>' . $rights['status_txt'] . '</td>';
		$html .= '	<td align="center">' . date('Y-m-d', $rights['dateline']) . '</td>';
		$html .= '	<td align="center"><a href="drp_rights.php?a=detail&id=' . $rights['id'] . '">详情</a></td>';
		$html .= '</tr>';
	}
	echo json_encode(array('count' => count($rights_list), 'data' => $html));
	exit;
} else if ($a == 'detail') {
	$id = $_GET['id'];
	$order_no = $_GET['order_no'];
	$pigcms_id = $_GET['pigcms_id'];
	$store_id = $_SESSION['wap_drp_store']['store_id'];
	
	if (empty($id) && (empty($order_no) || empty($pigcms_id))) {
		pigcms_tips('缺少最基本的参数');
		exit;
	}
	
	$return = array();
	if (!empty($id)) {
		$rights = M('Rights')->getById($id);
	} else {
		$order_no = trim($order_no, option('config.orderid_prefix'));
		$where = "r.order_no = '" . $order_no . "' AND rp.order_product_id = '" . $pigcms_id . "'";
		$rights_list = M('Rights')->getList($where);
	
		if ($rights_list) {
			$rights = $rights_list[0];
		}
	}
	
	if (empty($rights)) {
		pigcms_tips('未找到相应的维权');
		exit;
	}
	
	if (empty($id) && !empty($order_no) && !empty($pigcms_id)) {
		echo json_encode(array('status' => true, 'msg' => $return['id']));
		exit;
	}
	
	if ($rights['store_id'] != $store_id) {
		pigcms_tips('您无权查看此退货申请');
		exit;
	}
	// 查找订单
	$order = D('Order')->where("(order_id = '" . $rights['order_id'] . "' or user_order_id = '" . $rights['order_id'] . "') and store_id = '" . $store_id . "'")->find();
	
	if (empty($order)) {
		pigcms_tips('未查到相应的订单');
		exit;
	}
	$order = M('Order')->find(option('config.orderid_prefix') . $order['order_no']);
	
	// 相关折扣、满减、优惠
	//import('source.class.Order');
	//$order_data = Order::orderDiscount($order);
	include display('drp_rights_detail');
	echo ob_get_clean();
}