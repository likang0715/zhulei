<?php
/**
 *  支付同步通知
 */
require_once dirname(__FILE__).'/global.php';

$orderno = isset($_GET['orderno']) ? $_GET['orderno'] : pigcms_tips('非法访问！','none');

include display('paycallback');

echo ob_get_clean();
?>