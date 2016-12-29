<?php

/*
 * 我的关注
 */
require_once dirname(__FILE__) . '/global.php';

if (empty($wap_user)) {
    redirect('./login.php?referer=' . urlencode($_SERVER['REQUEST_URI']));
}

$action = isset($_GET['action']) ? $_GET['action'] : 'shoucang';
$where['user_id'] = $_SESSION['wap_user']['uid'];
$product_id_arr = array();
if ($action == 'goods') {
    $where['type'] = 1;
    $attention_list = D('User_collect')->where($where)->select();
    foreach ($attention_list as $v) {
        $product_id_arr[] = $v['dataid'];
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
    $where['type'] = 2;
    $attention_list = D('User_collect')->where($where)->select();
    $new_attention_list = array();
    foreach ($attention_list as $v) {
        $product_id_arr[] = $v['dataid'];
        $new_attention_list[$v['dataid']] = $v;
    }

    if ($product_id_arr) {
        if (is_array($product_id_arr)) {
            $Map['store_id'] = array('in', $product_id_arr);
        } else {
            $Map['store_id'] = $product_id_arr;
        }

        $store_list = M('Store')->getlist($Map);
    }
} else if ($action == 'chahui') {
    $where['type'] = 3;
    $attention_list = D('User_collect')->where($where)->select();
    $new_attention_list = array();
    foreach ($attention_list as $v) {
        $product_id_arr[] = $v['dataid'];
		$new_attention_list[$v['dataid']] = $v;
    }

    if ($product_id_arr) {
        if (is_array($product_id_arr)) {
            $Map['pigcms_id'] = array('in', $product_id_arr);
        } else {
            $Map['pigcms_id'] = $product_id_arr;
        }

        $chahui_list = M('Chahui')->getlist($Map);
    }
} else if ($action == 'collect_cancel') {
    if (empty($_SESSION['wap_user'])) {
        echo json_encode(array('status' => false, 'msg' => '请先登录'));
        exit;
    }

    $dataid = $_GET['id'];
    $type = $_GET['type'];
    $store_id = $_GET['store_id'];


    if (empty($dataid)) {
        echo json_encode(array('status' => false, 'msg' => '缺少最基本的参数'));
        exit;
    }

    if (!in_array($type, array(1, 2,3))) {
        echo json_encode(array('status' => false, 'msg' => '收藏类型错误'));
        exit;
    }

    if ($type == 1) {
        $data = D('Product')->where(array('product_id' => $dataid, 'status' => 1))->find();
        if (empty($data)) {
            echo json_encode(array('status' => false, 'msg' => '未找到收藏的产品'));
            exit;
        }
    } elseif ($type == 2) {
        $data = D('Store')->where(array('store_id' => $dataid, 'status' => 1))->find();
        if (empty($data)) {
            echo json_encode(array('status' => false, 'msg' => '未找到收藏的店铺'));
            exit;
        }
    }

    // 查看是否已经收藏过
    $user_collect = D('User_collect')->where(array('user_id' => $_SESSION['wap_user']['uid'], 'type' => $type, 'dataid' => $dataid))->find();
    if (empty($user_collect)) {
        echo json_encode(array('status' => false, 'msg' => '未找到您的收藏'));
        exit;
    }

    M('User_collect')->cancel($_SESSION['wap_user']['uid'], $dataid, $type,$store_id);
    echo json_encode(array('status' => true, 'msg' => '取消收藏成功', 'data' => array('nexturl' => 'refresh')));
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

include display('my_shoucang');

echo ob_get_clean();
?>
