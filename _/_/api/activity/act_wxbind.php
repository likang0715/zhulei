<?php
/**
 * 该token店铺是否绑定公众号
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

    $_POST['salt'] = SIGN_SALT;
    if (!_checkSign($sign_key, $_POST)) {
        $error_code = 1003;
        $error_msg = '签名无效';
        $return_url = '';
        $isWxbind = 0;
    } else {

        $whereStore['pigcmsToken'] = trim($postToken);
        $storeInfo = D('Store')->where($whereStore)->find();

        if (empty($storeInfo)) {
            $error_msg = '无此店铺';
            $error_code = 1004;
            $isWxbind = 0;
        } else {
            $wxbind = D('Weixin_bind')->where(array('store_id'=>$storeInfo['store_id']))->find();
            if (!empty($wxbind)) {
                $error_msg = '店铺已经绑定微信';
                $error_code = 0;
                $isWxbind = 1;
            } else {
                $error_msg = '店铺未绑定微信';
                $error_code = 1005;
                $isWxbind = 0;
            }
        }

    }
} else {
    $error_code = 1001;
    $error_msg = '请求失败';
    $isWxbind = 0;
}
echo json_encode(array('error_code' => $error_code, 'error_msg' => $error_msg, 'is_bind' => $isWxbind));
exit;