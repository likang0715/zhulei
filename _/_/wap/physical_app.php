<?php
/**
 *  订单信息
 */
require_once dirname(__FILE__).'/global.php';

$pigcms_id = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误','none');

//当前茶馆
$store_physical = M('Store_physical')->getOne($pigcms_id);
$now_store = M('Store')->wap_getStore($store_physical['store_id']);
include display('physical_app');

echo ob_get_clean();
?>