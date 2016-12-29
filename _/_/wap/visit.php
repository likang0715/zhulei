<?php
/**
 * Created by PhpStorm.
 * User: pigcms_21
 * Date: 2016/4/29
 * Time: 13:21
 */
require_once dirname(__FILE__).'/global.php';

if (IS_AJAX) {
    if (strtolower($_POST['module']) == 'goods') {
        $data = array();
        $data['uid'] = $_POST['uid'];
        $data['store_id'] = $_POST['store_id'];
        $data['product_id'] = $_POST['page_id'];
        $where = $data;
        $visit = D('Product_visited')->where($where)->find();
        if (empty($visit)) {
            $data['visits'] = 1;
            $data['duration_time'] = $_POST['duration']; //页面停留时间
            $data['last_time_visited'] = time();
            $data['last_ip_visited'] = bindec(decbin(ip2long($_SERVER['REMOTE_ADDR'])));
            $result = D('Product_visited')->data($data)->add();
        } else {
            $data = array();
            $data['visits'] = ($visit['visits'] + 1);
            $data['duration_time'] = ($visit['duration_time'] + $_POST['duration']); //页面累计停留时间
            $data['last_time_visited'] = time();
            $data['last_ip_visited'] = bindec(decbin(ip2long($_SERVER['REMOTE_ADDR'])));
            $result = D('Product_visited')->where($where)->data($data)->save();
        }
        if (!empty($result)) {
            D('Store_analytics')->where(array('pigcms_id' => $_POST['visit_id']))->data(array('duration_time' => $_POST['duration']))->save();
            json_return(0, '访问信息记录成功');
        } else {
            json_return(0, '访问信息记录失败');
        }
    } else if (!empty($_POST['visit_id']) && !empty($_POST['duration'])){
        $result = D('Store_analytics')->where(array('pigcms_id' => $_POST['visit_id']))->data(array('duration_time' => $_POST['duration']))->save();
        if (!empty($result)) {
            json_return(0, '访问信息记录成功');
        } else {
            json_return(0, '访问信息记录失败');
        }
    }
}