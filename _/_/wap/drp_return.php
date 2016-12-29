<?php
/**
 * 退货维权管理
 * User: pigcms_21
 * Date: 2015/10/8
 * Time: 14:13
 */
require_once dirname(__FILE__).'/global.php';

if (empty($_SESSION['wap_drp_store'])) {
	pigcms_tips('您没有权限访问，<a href="./home.php?id=' . $_COOKIE['wap_store_id'] . '">返回首页</a>','none');
}

$store = $_SESSION['wap_drp_store'];

$action = !empty($_GET['a']) ? $_GET['a'] : 'return';
$tab_num = !empty($_GET['tab_num']) ? $_GET['tab_num'] : 1;
$type = !empty($_GET['type']) ? $_GET['type'] : 1;

switch($action){
    case 'return':
        if (IS_AJAX && $tab_num == 1) {
            if ($_GET['ajax'] == 1) {
                $return_model = M('Return');

                $page = max(1, $_REQUEST['page']);
                $limit = 6;
                $count = $return_model->getCount("store_id = '" . $store['store_id'] . "'");
                $page = min($page, ceil($count / $limit));
                $offset = abs(($page - 1) * $limit);

                $return_list = $return_model->getList("r.store_id = '" . $store['store_id'] . "'", $limit, $offset);

                $json_return = array();
                $json_return['noNextPage'] = true;
                $json_return['list'] = $return_list;
                $json_return['max_page'] = ceil($count / $limit);
                json_return(0, $json_return);
            }
            json_return(1002, '缺少访问参数');
        }
    case 'rights' :
        if (IS_AJAX && $tab_num == 2) {
            if ($_GET['ajax'] == 1) {
                $rights_model = M('Rights');

                $page = max(1, $_REQUEST['page']);
                $limit = 6;
                $count = $rights_model->getCount("store_id = '" . $store['store_id'] . "'");
                $page = min($page, ceil($count / $limit));
                $offset = abs(($page - 1) * $limit);

                $return_list = $rights_model->getList("r.store_id = '" . $store['store_id'] . "'", $limit, $offset);

                $json_return = array();
                $json_return['noNextPage'] = true;
                $json_return['list'] = $return_list;
                $json_return['max_page'] = ceil($count / $limit);
                json_return(0, $json_return);
            }
            json_return(1002, '缺少访问参数');
        }
}
include display('drp_return_index');
echo ob_get_clean();
