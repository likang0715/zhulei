<?php
/**
 * 跨域跳转调用父级方法【砍价 订单列表】
 * POST
 */
define('PIGCMS_PATH', dirname(__FILE__).'/../../');
require_once PIGCMS_PATH.'source/init.php';
require_once '../functions.php';

include display('api_redirect');
echo ob_get_clean();