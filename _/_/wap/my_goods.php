<?php

/*
 * 店铺关注与收藏
 */
require_once dirname(__FILE__) . '/global.php';

if (empty($wap_user)) {
    redirect('./login.php?referer=' . urlencode($_SERVER['REQUEST_URI']));
}

$action = isset($_GET['action']) ? $_GET['action'] : 'guangzhu';

$where['user_id'] = $_SESSION['user']['uid'];
$product_id_arr = array();
if ($action == 'guanzhu') {
    $where['data_type'] = 1;
    $attention_list = D('User_attention')->where($where)->select();
    foreach ($attention_list as $v) {
        $product_id_arr[] = $v['data_id'];
    }
} else if ($action == 'shoucang') {
    $where['type'] = 1;
    $collect_list = D('User_collect')->where($where)->select();
    foreach ($collect_list as $v) {
        $product_id_arr[] = $v['dataid'];
    }
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

include display('my_goods');

echo ob_get_clean();
?>
