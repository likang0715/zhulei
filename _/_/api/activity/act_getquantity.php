<?php
/**
 * 获取产品库存数量
 * POST
 * @param int product 产品id
 * @param int sku_id 
 * @return intval 该商品库存数量
 */
define('PIGCMS_PATH', dirname(__FILE__).'/../../');
require_once PIGCMS_PATH.'source/init.php';
require_once '../functions.php';

if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {

    $sign_key = $_POST['sign_key'];
        unset($_POST['sign_key']);

    $product_id = $_POST['product_id'];
    $sku_id = $_POST['sku_id'];

    $_POST['salt'] = SIGN_SALT;
    if (!_checkSign($sign_key, $_POST)) {
        $error_code = 1003;
        $error_msg = '签名无效';
        $return_url = '';
        $num = null;
    } else {

        if ($sku_id) {
            $productInfo = D('Product_sku')->where(array('product_id'=>$product_id, 'sku_id'=>$sku_id))->find();
        } else {
            $productInfo = D('Product')->where(array('product_id'=>$product_id))->find();
        }

        if (empty($productInfo)) {
            $error_code = 1002;
            $error_msg = '未找到该商品';
            $num = 0;
        } else {
            $error_code = 0;
            $error_msg = '请求成功';
            $num = $productInfo['quantity'];
        }

    }
} else {
    $error_code = 1001;
    $error_msg = '请求失败';
    $num = null;
}
echo json_encode(array('error_code' => $error_code, 'error_msg' => $error_msg, 'num' => $num));
exit;