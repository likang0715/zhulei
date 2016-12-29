<?php
/**
 * 营销活动获取店铺中商品
 * POST
 * @param array array(
 *      'sign_key' => ,
 *      'token' => ,
 *      'p' => 分页,
 *      'store_id' => 店铺id,
 * )
 * @return array 该店铺在售商品信息列表
 */

define('PIGCMS_PATH', dirname(__FILE__).'/../../');
require_once PIGCMS_PATH.'source/init.php';
require_once '../functions.php';

if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {

    $sign_key = $_POST['sign_key'];
        unset($_POST['sign_key']);

    $p = $_POST['p'];

    $keyword = $_POST['keyword'];
    $postToken = $_POST['token'];

    $_POST['salt'] = SIGN_SALT;

    if (!_checkSign($sign_key, $_POST)) {
        $error_code = 1003;
        $error_msg = '签名无效';
        $return_url = '';

    } else {

        $whereStore['pigcmsToken'] = trim($postToken);
        $storeInfo = D('Store')->where($whereStore)->find();

        if (!empty($keyword)) {
            $where['name'] = array('like', '%' . $keyword . '%');
        }

        $where['supplier_id'] = '0';
        $where['quantity'] = array('>', 0);
        $where['soldout'] = 0;
        $where['wholesale_product_id'] = 0;
        // $where['store_id'] = $store_id;
        $where['store_id'] = $storeInfo['store_id'];
        
        // var_dump($where);exit;
        $product_module = M('Product');
        $product_total = $product_module->getSellingTotal($where);
        import('source.class.user_page');

        $page = new Page($product_total, 5);
        $product_list = $product_module->getSelling($where, '', '', $page->firstRow, $page->listRows);

        $product_sku_module = D('Product_sku');

        $pid_arr = array();
        $vid_arr = array();
        $pid_list = array();
        $vid_list = array();   

        foreach ($product_list as &$product) {

            $imageData = M('Product_image')->getImages($product['product_id']);

            $product['image2'] = isset($imageData[1]['image']) ? getAttachmentUrl($imageData[1]['image']) : '';
            $product['image3'] = isset($imageData[2]['image']) ? getAttachmentUrl($imageData[2]['image']) : '';

            if ($product['has_property']) {
                $product_sku_list = $product_sku_module->where(array('product_id' => $product['product_id'], 'quantity' => array('>', 0)))->select();
                
                foreach ($product_sku_list as &$product_sku) {
                    $sku_arr = explode(';', $product_sku['properties']);
                    foreach ($sku_arr as $sku) {
                        $sku_tmp = explode(':', $sku);
                        if (empty($sku_tmp) || $sku_tmp[0] == 'undefined' || $sku_tmp[1] == 'undefined') {
                            //continue;
                        }
                        $pid_arr[$sku_tmp[0]] = $sku_tmp[0];
                        $vid_arr[$sku_tmp[1]] = $sku_tmp[1];

                        $product_sku['pid_arr'][] = $sku_tmp[0];
                        $product_sku['vid_arr'][] = $sku_tmp[1];
                    }
                    
                    // 查找上次购买的价格,不用考虑商家更改了商品属性
                    $order_product = D('Order_product as op')->join('Order as o ON o.order_id = op.order_id', 'LEFT')->where("op.sku_id = '" . $product_sku['sku_id'] . "' AND o.status = 4 AND o.uid = '" . $uid . "' AND op.return_status != 2 AND op.product_id = '" . $product['product_id'] . "'")->field('op.pro_price')->order('op.pigcms_id DESC')->find();
                    $product_sku['origin_price'] = $product_sku['price'];
                    if ($order_product) {
                        $product_sku['price'] = $order_product['pro_price'];
                    }
                }
                
                $product['sku_list'] = $product_sku_list;
            } else {
                // 查找上次购买的价格
                $order_product = D('Order_product as op')->join('Order as o ON o.order_id = op.order_id', 'LEFT')->where("o.status = 4 AND o.uid = '" . $uid . "' AND op.return_status != 2 AND op.product_id = '" . $product['product_id'] . "'")->field('op.pro_price')->order('op.pigcms_id DESC')->find();
                $product['origin_price'] = $product['price'];
                if ($order_product) {
                    $product['price'] = $order_product['pro_price'];
                }
            }
        }
        // dump($product_list);exit;
        if (!empty($pid_arr)) {
            $pid_arr = D('Product_property')->where("pid in ('" . join("','", $pid_arr) . "')")->select();
            $vid_arr = D('Product_property_value')->where("vid in ('" . join("','", $vid_arr) . "')")->select();
            
            foreach ($pid_arr as $tmp) {
                $pid_list[$tmp['pid']] = $tmp;
            }
            
            foreach ($vid_arr as $tmp) {
                $vid_list[$tmp['vid']] = $tmp;
            }
        }

        foreach ($product_list as $key => $tmp_product) {
            if (!$tmp_product['sku_list']) {
                continue;
            }
            foreach ($tmp_product['sku_list'] as $k => $sku) {
                $sku_arr = explode(';', $sku['properties']);
                $sku_str = array();
                foreach ($sku_arr as $sku_tmp) {
                    list($pid, $vid) = explode(':', $sku_tmp);
                    $sku_str[] = $pid_list[$pid]['name'] . ':' . $vid_list[$vid]['value'];
                }
                $product_list[$key]['sku_list'][$k]['sku_str'] = implode(';', $sku_str);
            }
        }

        $data = array();
        $data['product_list'] = $product_list;
        $data['pid_list'] = $pid_list;
        $data['vid_list'] = $vid_list;
        // $data['page'] = $page->show();
        $data['total'] = $product_total;

        if (!empty($product_list)) {
            $error_code = 0;
            $error_msg = '请求成功';
            $return_url = '';
        } else {
            $data = '';
            $error_code = 1005;
            $error_msg = '店铺不存在';
            $return_url = '';
        }

    }
} else {
    $error_code = 1001;
    $error_msg = '请求失败';
    $return_url = '';

}
echo json_encode(array('error_code' => $error_code, 'error_msg' => $error_msg, 'data' => $data, 'return_url' => $return_url));
exit;