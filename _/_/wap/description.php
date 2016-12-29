<?php
/**
 * 分销用户中心
 * User: pigcms_21
 * Date: 2015/4/18
 * Time: 14:35
 */
require_once dirname(__FILE__).'/global.php';

if ($_SESSION['wap_drp_store']) {
    $store = $_SESSION['wap_drp_store'];
} else {
    redirect('./ucenter.php?id=' . intval(trim($_COOKIE['wap_store_id'])));
}

include display('description');
echo ob_get_clean();
