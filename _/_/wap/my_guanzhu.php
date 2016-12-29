<?php

/*
 * 我的关注
 */
require_once dirname(__FILE__) . '/global.php';

if (empty($wap_user)) {
    redirect('./login.php?referer=' . urlencode($_SERVER['REQUEST_URI']));
}

$action = isset($_GET['action']) ? $_GET['action'] : 'goods';

$where['user_id'] = $_SESSION['wap_user']['uid'];
$product_id_arr = array();
if ($action == 'goods') {
    $where['data_type'] = 1;

    if ($_GET['store_id']) {
        $where['store_id'] = $_GET['store_id'] + 0;
    }

    $attention_list = D('User_attention')->where($where)->select();
    foreach ($attention_list as $v) {
        $product_id_arr[] = $v['data_id'];
    }

    if ($product_id_arr) {
        if (is_array($product_id_arr)) {
            $Map['product_id'] = array('in', $product_id_arr);
        } else {
            $Map['product_id'] = $product_id_arr;
        }

        $product_list = M('Product')->getSelling($Map, 'sort', 'desc', 0, 1000);
        $new_product_list = array();
        foreach ($product_list as $k => $v) {
            $new_product_list[$v['product_id']] = $v;
        }
    }
} else if ($action == 'store') {
    $where['data_type'] = 2;
    $attention_list = D('User_attention')->where($where)->select();
    $new_attention_list = array();
    foreach ($attention_list as $v) {
        $product_id_arr[] = $v['data_id'];
        $new_attention_list[$v['data_id']] = $v;
    }

    if ($product_id_arr) {
        if (is_array($product_id_arr)) {
            $Map['store_id'] = array('in', $product_id_arr);
                //$product_id_arr = implode(",",$product_id_arr);
                //$Map = "s.store_id in (".$product_id_arr.")";
        } else {
            $Map['store_id'] = $product_id_arr;
            //$Map = "s.store_id in (".$product_id_arr.")";
        }

        $store_list = M('Store')->getlist($Map);
    }
} else if ($action == 'attention_cancel') {
    if (empty($_SESSION['wap_user'])) {
        echo json_encode(array('status' => false, 'msg' => '请先登录'));
        exit;
    }

    $data_id = $_GET['id'];
    $data_type = $_GET['type'];
    $store_id = $_GET['store_id'];


    if (empty($data_id)) {
        echo json_encode(array('status' => false, 'msg' => '缺少最基本的参数'));
        exit;
    }

    if (!in_array($data_type, array(1, 2))) {
        echo json_encode(array('status' => false, 'msg' => '关注类型错误'));
        exit;
    }

    if ($data_type == 1) {
        $data = D('Product')->where(array('product_id' => $data_id, 'status' => 1))->find();
        if (empty($data)) {
            echo json_encode(array('status' => false, 'msg' => '未找到关注的产品'));
            exit;
        }
    } else {
        $data = D('Store')->where(array('store_id' => $data_id, 'status' => 1))->find();
        if (empty($data)) {
            echo json_encode(array('status' => false, 'msg' => '未找到关注的店铺'));
            exit;
        }
    }

    // 查看是否已经收藏过
    $user_attention = D('User_attention')->where(array('user_id' => $_SESSION['wap_user']['uid'], 'data_type' => $data_type, 'data_id' => $data_id, 'store_id' => $store_id))->find();
    if (empty($user_attention)) {
        echo json_encode(array('status' => false, 'msg' => '未找到您的关注'));
        exit;
    }

    M('User_attention')->cancel($_SESSION['wap_user']['uid'], $data_id, $data_type, $store_id);
    echo json_encode(array('status' => true, 'msg' => '取消关注成功', 'data' => array('nexturl' => 'refresh')));
    exit;
}






//分享配置 start
$share_conf = array(
    'title' => $_SESSION['store']['name'] . '-商品收藏与关注', // 分享标题
    'desc' => str_replace(array("\r", "\n"), array('', ''), $_SESSION['store']['intro']), // 分享描述
    'link' => 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], // 分享链接
    'imgUrl' => option('config.site_logo'), // 分享图片链接
    'type' => '', // 分享类型,music、video或link，不填默认为link
    'dataUrl' => '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share = new WechatShare();
$shareData = $share->getSgin($share_conf);
//分享配置 end

include display('my_guanzhu');

echo ob_get_clean();
?>
