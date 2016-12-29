<?php

/*
 * 我的活动记录
 */
require_once dirname(__FILE__) . '/global.php';

if (empty($wap_user)) {
    redirect('./login.php?referer=' . urlencode($_SERVER['REQUEST_URI']));
}

// 店铺只允许供货商
$store_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// $where_tuan = array('store_id'=>$store_id, 'uid'=>$wap_user['uid'], 'type'=>6,'status'=>array('in', array(2,3,4,6,7)));
// $count['tuan'] = D("Order")->where($where_tuan)->count("order_id");

$where_tuan = "tt.team_id = o.data_item_id AND tt.tuan_id = t.id AND t.product_id = p.product_id AND o.uid = '" . $wap_user['uid'] . "' AND o.type = 6 AND (o.status = 2 OR o.status = 3 OR o.status = 4 OR o.status = 6 OR o.status = 7)";
$where_unitary = array('uid'=>$wap_user['uid']);

if (!empty($store_id)) {
	$where_tuan .= " AND o.store_id = '" . $store_id . "'";
	$where_unitary = array_merge($where_unitary, array('store_id'=>$store_id));
}

$count['tuan'] = D('')->table(array(
	'Order'=>'o',
	'Tuan_team'=>'tt',
	'Tuan'=>'t',
	'Product'=>'p'
))->where($where_tuan)->count('o.order_id');


$count['unitary'] = D('Unitary_join')->where($where_unitary)->count("id");

include display('my_activity');

echo ob_get_clean();
?>
