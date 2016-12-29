<?php

/**
 *  活动列表
 */
require_once dirname(__FILE__) . '/global.php';

$type = isset($_POST['table_name']) ? trim($_POST['table_name']) : '';
$type = in_array($type, array('bargain' ,'seckill' ,'crowdfunding' ,'unitary' ,'cutprice', 'seckill_action', 'lottery')) ? $type : 'all';

// $orderBy = isset($_POST['order']) ? trim($_POST['order']) : '';
// $page_num = isset($_POST['page']) ? intval($_POST['page']) : 1;
// $pagesize = 10;

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$pagesize = isset($_POST['pagesize']) ? intval($_POST['pagesize']) : 10;
$orderBy = isset($_POST['order']) ? htmlspecialchars($_POST['order']) : 'asc';

$page = max(1, $page);
$start = ($page - 1) * $pagesize;

$order = 'id DESC';
if ($orderBy == 'asc') {
	$order = 'id ASC';
}

// $where = "`model` = $type";
if ($type == 'lottery') {
	$where = "type > 0";
} else if ($type == 'all') {
	$where = true;
} else {
	$where = array('model' => $type);
}
// echo $where;
$total = D('Activity_recommend')->where($where)->count('id');
$list = D('Activity_recommend')->where($where)->order($order)->limit($start.','.$pagesize)->select();

// $page = count($list) < $pagesize ? 0 : ($page + 1);
$page = ($start + $pagesize) < $total ? ($page + 1) : 0;

$tmp_list = array();
foreach ($list as $key => $val) {
	$activityTmp = M('Activity')->getActivityDetail($val['id']);
	$activityTmp['pic'] = $val['image'];
	$tmp_list[$key] = $activityTmp;
}


$json_return = array(
			'data' => $tmp_list,
			'page' => $page,
			'errcode' => 0,
		);

if(!headers_sent()) header('Content-type:application/json');
exit(json_encode($json_return, true));

echo ob_get_clean();
?>