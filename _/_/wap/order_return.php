<?php
/**
 * 退还货及维权
 */
require_once dirname(__FILE__).'/global.php';

$act = isset($_GET['active']) ? trim($_GET['active']) : 'unsend';
if (empty($act)) {
    pigcms_tips('非法访问', 'none');
}

switch ($act) {

    case 'unsend':

        if (empty($wap_user)) {
            redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
        }

        if(empty($wap_user)) redirect('./login.php');

        $store_id = $_GET['store_id'];
        $page = max(1, $_REQUEST['page']);
        $limit = 5;
        //店铺资料
        $now_store = M('Store')->wap_getStore($store_id);
        if(empty($now_store)) pigcms_tips('您访问的店铺不存在','none');
        $action = isset($_GET['action']) ? $_GET['action'] : 'all';
        $uid = $wap_user['uid'];
        $where = array();
        $where['uid'] = $uid;
        $where['store_id'] = $store_id;
        $where['user_order_id']  = 0; //排除分销订单
        $page_url = 'order.php?id=' . $store_id . '&action=' . $action;
        $where['status'] = 2;

        $count = D('Order')->where($where)->count('order_id');

        $orderList = array();
        $pages = '';
        if ($count > 0){

            $page = min($page, ceil($count / $limit));
            $offset = ($page - 1) * $limit;

            $orderList = D('Order')->where($where)->order('order_id desc')->limit($offset . ', ' . $limit)->select();

            $order_id_arr = array ();
            $store_id_arr = array ();
            $physical_id_arr = array ();
            $config_order_return_date = option('config.order_return_date');
            $config_order_complete_date = option('config.order_complete_date');

            foreach ($orderList as &$value){
                if ($value['comment']){
                    $value['comment_arr'] = unserialize($value['comment']);
                }

                $value['address'] = unserialize($value['address']);
                $value['order_no_txt'] = option('config.orderid_prefix') . $value['order_no'];

                if ($value['status'] < 2){
                    $value['url'] = './pay.php?id=' . $value['order_no_txt'];
                }else{
                    $value['url'] = './order.php?orderid=' . $value['order_id'];
                }

                $order_id_arr[$value['order_id']] = $value['order_id'];

                if ($value['shipping_method'] == 'selffetch') {
                    if ($value['address']['physical_id']){
                        $physical_id_arr[$value['address']['physical_id']] = $value['address']['physical_id'];
                    } else if ($value['address']['store_id']){
                        $store_id_arr[$value['address']['store_id']] = $value['address']['store_id'];
                    }
                }

                $is_return = FALSE;
                if ($value['status'] == '7'){
                    if ($value['delivery_time'] + $config_order_return_date * 24 * 3600 >= time()){
                        $is_return = TRUE;
                    }
                }else if ($value['status'] == '3'){
                    if ($value['send_time'] + $config_order_complete_date * 24 * 3600 >= time()){
                        $is_return = TRUE;
                    }
                }else if ($value['status'] == 2) {
                    $is_return = TRUE;
                }

                $is_rights = FALSE;
                if (in_array($value['status'], array (2, 3, 4, 7)) && $value['add_time'] + 5 * 24 * 3600 < time()){
                    $is_rights = TRUE;
                }

                $value['is_return'] = $is_return;
                $value['is_rights'] = $is_rights;
                $value['order_product_list'] = M('Order_product')->orderProduct($value['order_id']);
            }

            $physical_list = array ();
            $store_contact_list = array ();
            if (!empty($store_id_arr)){
            $store_contact_list = M('Store_contact')->storeContactList($store_id_arr);
            }

            if (!empty($physical_id_arr)){
                $physical_list = M('Store_physical')->getListByIDList($physical_id_arr);
            }

            // 分页
            import('source.class.user_page');
            $user_page = new Page($count, $limit, $page);
            $pages = $user_page->show();
        }
            // 分享链接
            $data['share_link'] = M('Share_record')->createLink($store_id, $wap_user['uid']);

            include display('order_return');
            echo ob_get_clean();
            break;

    case 'single':					// 个人推广中心

        if (empty($wap_user)) {
            redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));
        }

        $store_id = $_GET['store_id'];
        if (empty($store_id) || !$storeInfo = D('Store')->where(array('drp_supplier_id'=>0, 'store_id'=>$store_id))->find()) {
            pigcms_tips('不存在该店铺', 'none');
        }

        // 获取今日积分配置
        $storePointsConfig = D('Store_points_config')->where(array('store_id'=>$store_id))->find();
        if (empty($storePointsConfig)) {
            pigcms_tips('该店铺尚未做积分配置', 'none');
        }

        if (empty($storePointsConfig['sign_set'])) {
            pigcms_tips('该店铺未开启签到', 'none');
        }

        // 是否是该店铺分销商
        $drpResult = M('Share_record')->is_drp_store($wap_user['uid'], $store_id);
        $data['is_drp'] = $drpResult['is_drp'];
        $data['seller_id'] = $drpResult['seller_id'];
        if (!$data['is_drp']) {
            pigcms_tips('你不是该店铺的分销商', 'none');
        }

        // 分享链接
        $data['share_link'] = M('Share_record')->createLink($store_id, $wap_user['uid']);

        include display('points_single');
        echo ob_get_clean();
        break;

    case 'ajax_checkin':		// 签到

        $store_id = isset($_POST['store_id']) ? intval($_POST['store_id']) : 0;

        if (empty($store_id)) {
            json_return(1, '缺少参数');
        }

        $uid = $wap_user['uid'];
        $drpResult = M('Share_record')->is_drp_store($uid, $store_id);

        //是否开启签到开关
        $storePointsConfig = D('Store_points_config')->where(array("store_id"=>$store_id))->find();
        if ($storePointsConfig['sign_set'] == 0) {
            json_return(1, '该店铺未开启签到');
        }

        //判断当前用户是否是该供货商的分销商
        if ($drpResult['is_drp']) {
            $checkResult = Points::sign($uid, $store_id, $drpResult['seller_id']);
        } else {
            $checkResult = Points::sign($uid, $store_id);
        }

        if ($checkResult === false) {
            json_return(1, '签到失败');
        }

        json_return(0, '签到成功');
        break;

    default:
        pigcms_tips('非法访问', 'none');
        break;
}

?>


