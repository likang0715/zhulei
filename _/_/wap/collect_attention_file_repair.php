<?php

require_once dirname(__FILE__) . '/global.php';
$user_attention_list = D('User_attention')->select();
$user_collect_list = D('User_collect')->select();


foreach ($user_attention_list as $v) {
    if ($v['data_type'] == 1 && $v['store_id'] == 0) {
        $where['prodcut_id'] = $v['data_id'];
        $product_info = D('Product')->where($where)->find();
        if ($product_info) {
            $Map['id'] = $v['id'];
            D('User_attention')->where($Map)->data(array('store_id' => $product_info['store_id']))->save();
        }
    } else if ($v['data_type'] == 2) {
        $Map['id'] = $v['id'];
        D('User_attention')->where($Map)->data(array('store_id' => $v['data_id']))->save();
    }
}
unset($Map,$where);

foreach ($user_collect_list as $v) {
    if ($v['type'] == 1 && $v['store_id'] == 0) {
        $where['prodcut_id'] = $v['dataid'];
        $product_info = D('Product')->where($where)->find();
        if ($product_info) {
            $Map['id'] = $v['collect_id'];
            D('User_attention')->where($Map)->data(array('store_id' => $product_info['store_id']))->save();
        }
    } else if ($v['type'] == 2) {
        $Map['collect_id'] = $v['collect_id'];
        D('User_collect')->where($Map)->data(array('store_id' => $v['dataid']))->save();
    }
}

echo '修复成功！';
?>
