<?php
/**
 * 判断用户openid是否关注活动token所属店铺
 * POST
 * @param string token 对接活动token
 * @param string openid 平台openid
 * @return intval 是否关注 1是 0否
 */
define('PIGCMS_PATH', dirname(__FILE__).'/../../');
require_once PIGCMS_PATH.'source/init.php';
require_once '../functions.php';

if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {

    $sign_key = $_POST['sign_key'];
        unset($_POST['sign_key']);

    $postToken = $_POST['token'];
    $postOpenid = $_POST['openid'];

    $_POST['salt'] = SIGN_SALT;
    if (!_checkSign($sign_key, $_POST)) {
        $error_code = 1003;
        $error_msg = '签名无效';
        $return_url = '';
        $isBind = 0;
    } else {

        $isAttention = M('Activity_spread')->isSubscribe(trim($postToken), trim($postOpenid));

        $error_code = 0;
        $error_msg = '请求成功';
        $isBind = $isAttention ? 1 : 0;

    }
} else {
    $error_code = 1001;
    $error_msg = '请求失败';
    $isBind = 0;
}
echo json_encode(array('error_code' => $error_code, 'error_msg' => $error_msg, 'is_bind' => $isBind));
exit;