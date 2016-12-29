<?php
/**
 * 物流信息
 */
require_once dirname(__FILE__).'/global.php';

$type = $_GET['type'];
$express_no = $_GET['express_no'];

if (empty($type) || empty($express_no)) {
	echo json_encode(array('status' => false));
	exit;
}

$express = D('Express')->where(array('code' => $type))->find();
if (empty($express)) {
	echo json_encode(array('status' => false));
	exit;
}

$url = 'http://www.kuaidi100.com/query?type=' . $type . '&postid=' . $express_no . '&id=1&valicode=&temp=' . time() . rand(100000, 999999);
import('class.Express');
//$content = Http::curlGet($url);
$content = Express::kuadi100($url);
$content_arr = json_decode($content, true);

if ($content_arr['status'] != '200') {
	echo json_encode(array('status' => false));
	exit;
} else {
	echo json_encode(array('status' => true, 'data' => $content_arr));
	exit;
}

echo ob_get_clean();
