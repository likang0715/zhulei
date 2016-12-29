<?php
/**
 *  订单信息
 */
require_once dirname(__FILE__).'/global.php';

if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
$package_id = isset($_GET['package_id']) ? intval($_GET['package_id']) : 0;

if (empty($order_id)) {
	pigcms_tips('缺少参数', 'none');
}

$nowOrder = M('Order')->findOrderById($order_id);
if(empty($nowOrder)) pigcms_tips('该订单不存在','none');

// 获取包裹列表
$myPackages = D("Order_package")->where("order_id = ".$order_id." AND courier_id != 0")->order("package_id DESC")->select();

if (empty($myPackages)) {
	pigcms_tips('订单尚未打包', 'none');
}

$nowPackage = array();
foreach ($myPackages as $key => $val) {
	if ($package_id == $val['package_id']) {
		$nowPackage = $val;
	}
}

if (empty($nowPackage)) {
	$nowPackage = $myPackages[0];
	$package_id = $nowPackage['package_id'];
}

// 当前包裹所属门店信息
$nowPhysical = M('Store_physical')->getOne($nowPackage['physical_id']);
$nowPhysical['phone'] = !empty($nowPhysical['phone1']) ? $nowPhysical['phone1'].$nowPhysical['phone2'] : $nowPhysical['phone2'];

$nowCourier = D('Store_physical_courier')->where(array('courier_id'=>$nowPackage['courier_id']))->find();

// dump($nowPhysical);
// dump($nowCourier);exit;
// dump($nowOrder);
// dump($nowPackage);
// dump($myPackages);exit;

$uid = $wap_user['uid'];

include display('my_package');

echo ob_get_clean();
?>