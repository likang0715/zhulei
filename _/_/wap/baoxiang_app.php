<?php
/**
 *  订单信息
 */
require_once dirname(__FILE__).'/global.php';

$cz_id = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误','none');

$where=array();
$where['cz_id'] = $cz_id;
$meal = D('Meal_cz')->where($where)->find();

include display('baoxiang_app');

echo ob_get_clean();
?>