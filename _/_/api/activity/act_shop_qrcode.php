<?php
/**
 * api活动接口 获取参数二维码/公众号二维码
 * POST
 * @param intval modelId 活动id
 * @param string model 活动类型
 * @param string title 活动标题
 * @param string info 活动介绍
 * @param string image 活动图片
 * @param string token 绑定token
 * 
 * @return array 带参数二维码地址
 *              未认证公众号二维码图片地址
 *              快速关注公众号地址
 */
define('PIGCMS_PATH', dirname(__FILE__).'/../../');
require_once PIGCMS_PATH.'source/init.php';
require_once '../functions.php';

if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {

    $sign_key = $_POST['sign_key'];
        unset($_POST['sign_key']);

    $data = array();
    $data['modelId'] = $_POST['modelId'];
    $data['model'] = $_POST['model'];
    $data['title'] = $_POST['title'];
    $data['info'] = $_POST['info'];
    $data['image'] = $_POST['image'];
    $data['token'] = $_POST['token'];
    $data['keyword'] = $_POST['keyword'];

    $_POST['salt'] = SIGN_SALT;

    if (!_checkSign($sign_key, $_POST)) {
        $error_code = 1003;
        $error_msg = '签名无效';

    } else {

        // 取新表记录
        // 无或过期则创建/修改
        $returnData = M('Activity_spread')->getShopQcode($data);
        $error_code = $returnData['error_code'];
        $error_msg = $returnData['error_msg'];

        $actData['qcode'] = $returnData['qcode'];
        $actData['hurl'] = $returnData['hurl'];
        // dump($data);exit;

    }

} else {
    $error_code = 1001;
    $error_msg = '请求失败';

}
echo json_encode(array('error_code' => $error_code, 'error_msg' => $error_msg, 'data' => $actData));
exit;