<?php
/**
 * 跨域跳转调用父级方法【砍价 订单列表】
 * POST
 */
require_once dirname(__FILE__) . '/global.php';

include display('act_redirect');
echo ob_get_clean();