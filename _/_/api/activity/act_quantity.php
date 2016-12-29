<?php
/**
 * 修改库存
 * POST
 * @param intval $product_id 使用的产品id
 * @param intval $sku_id 使用的产品sku_id
 * @param intval $num 操作数量
 * @param string $type 操作类型 默认为减少 minus/plus
 * @param string $token 活动绑定token 
 *
 * @return intval 修改后库存数量
 */
define('PIGCMS_PATH', dirname(__FILE__).'/../../');
require_once PIGCMS_PATH.'source/init.php';
require_once '../functions.php';

if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {

    $sign_key = $_POST['sign_key'];
        unset($_POST['sign_key']);

    $postType = (isset($_POST['type']) && in_array(trim($_POST['type']), array('plus', 'minus'))) ? trim($_POST['type']) : 'minus';
    $postNum = intval($_POST['num']);
    $postToken = trim($_POST['token']);
    $postProductId = intval($_POST['product_id']);
    $postSkuId = intval($_POST['sku_id']);

    $_POST['salt'] = SIGN_SALT;
    if (!_checkSign($sign_key, $_POST)) {
        $error_code = 1003;
        $error_msg = '签名无效';
        $num = 0;
    } else {

        $whereStore['pigcmsToken'] = trim($postToken);
        $storeInfo = D('Store')->where($whereStore)->find();
        if (empty($storeInfo)) {
            $error_code = 1004;
            $error_msg = '店铺不存在';
            $num = 0;

            echo json_encode(array('error_code' => $error_code, 'error_msg' => $error_msg, 'data' => $num));
            exit;
        }

        if ($postSkuId) {
            $productInfo = D('Product_sku')->where(array('product_id'=>$postProductId, 'sku_id'=>$postSkuId))->find();
        } else {
            $productInfo = D('Product')->where(array('product_id'=>$postProductId))->find();
        }

        // if ($productInfo['store_id'] != $storeInfo['store_id']) {
        //     $error_code = 1004;
        //     $error_msg = '非活动店铺商品，没有权限';
        //     $num = 0;

        //     echo json_encode(array('error_code' => $error_code, 'error_msg' => $error_msg, 'data' => $num));
        //     exit;
        // }

        if ($postType == 'minus' && $num > $productInfo['quantity']) {
            $error_code = 1005;
            $error_msg = '库存扣除数量超限';
            $num = 0;

            echo json_encode(array('error_code' => $error_code, 'error_msg' => $error_msg, 'num' => $productInfo['quantity']));
            exit;
        }

        if ($postType == 'minus') {
            $newNum = $productInfo['quantity'] - $num;
        } else {
            $newNum = $productInfo['quantity'] + $num;
        }

        $upResult = D('Product')->where(array('product_id'=>$postProductId))->data(array('quantity'=>$newNum))->save();
        if ($upResult) {
            $error_code = 0;
            $error_msg = '库存修改成功';
            $num = $newNum;
        } else {
            $error_code = 1005;
            $error_msg = '库存修改失败，稍后再试';
            $num = 0;
        }

    }

} else {
    $error_code = 1001;
    $error_msg = '请求失败';
    $num = 0;
}
echo json_encode(array('error_code' => $error_code, 'error_msg' => $error_msg, 'num' => $num));
exit;