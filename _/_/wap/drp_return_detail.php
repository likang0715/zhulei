<?php
/**
 * 退货管理详情
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
$type = !empty($_GET['type']) ? $_GET['type'] : 1;

switch($action){
    case 'detail' :
        if($type == 'return'){
            $id = $_GET['id'];
            $order_no = $_GET['order_no'];
            $pigcms_id = $_GET['pigcms_id'];
            $store_id = $_SESSION['wap_drp_store']['store_id'];

            if (empty($id) && (empty($order_no) || empty($pigcms_id))) {
                pigcms_tips('缺少最基本的参数');
                exit;
            }

            $return = array();
            if (!empty($id)) {
                $return = M('Return')->getById($id);
            } else {
                $order_no = trim($order_no, option('config.orderid_prefix'));
                $where = "r.order_no = '" . $order_no . "' AND rp.order_product_id = '" . $pigcms_id . "'";
                $return_list = M('Return')->getList($where);

                if ($return_list) {
                    $return = $return_list[0];
                }
            }

            if (empty($return)) {
                pigcms_tips('未找到相应的退货申请');
                exit;
            }

            if (empty($id) && !empty($order_no) && !empty($pigcms_id)) {
                echo json_encode(array('status' => true, 'msg' => $return['id']));
                exit;
            }

            if ($return['store_id'] != $store_id) {
                pigcms_tips('您无权查看此退货申请');
                exit;
            }
            // 查找订单
            $order = D('Order')->where("(order_id = '" . $return['order_id'] . "' or user_order_id = '" . $return['order_id'] . "') and store_id = '" . $store_id . "'")->find();

            if (empty($order)) {
                pigcms_tips('未查到相应的订单');
                exit;
            }

            $order = M('Order')->find(option('config.orderid_prefix') . $order['order_no']);

            include display('drp_return_detail');
            echo ob_get_clean();
        }else if($type == 'right'){
            $id = $_GET['id'];
            $order_no = $_GET['order_no'];
            $pigcms_id = $_GET['pigcms_id'];
            $store_id = $_SESSION['wap_drp_store']['store_id'];

            if (empty($id) && (empty($order_no) || empty($pigcms_id))) {
                pigcms_tips('缺少最基本的参数');
                exit;
            }

            $return = array();
            if (!empty($id)) {
                $rights = M('Rights')->getById($id);
            } else {
                $order_no = trim($order_no, option('config.orderid_prefix'));
                $where = "r.order_no = '" . $order_no . "' AND rp.order_product_id = '" . $pigcms_id . "'";
                $rights_list = M('Rights')->getList($where);

                if ($rights_list) {
                    $rights = $rights_list[0];
                }
            }

            if (empty($rights)) {
                pigcms_tips('未找到相应的维权');
                exit;
            }

            if (empty($id) && !empty($order_no) && !empty($pigcms_id)) {
                echo json_encode(array('status' => true, 'msg' => $return['id']));
                exit;
            }

            if ($rights['store_id'] != $store_id) {
                pigcms_tips('您无权查看此退货申请');
                exit;
            }
            // 查找订单
            $order = D('Order')->where("(order_id = '" . $rights['order_id'] . "' or user_order_id = '" . $rights['order_id'] . "') and store_id = '" . $store_id . "'")->find();

            if (empty($order)) {
                pigcms_tips('未查到相应的订单');
                exit;
            }
            $order = M('Order')->find(option('config.orderid_prefix') . $order['order_no']);

            include display('drp_rights_detail');
            echo ob_get_clean();
        }
}