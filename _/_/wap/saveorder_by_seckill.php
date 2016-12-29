<?php
/**
 *  处理秒杀订单
 */
require_once dirname(__FILE__) . '/global.php';

//判断关注
$wap_user = !empty($_SESSION['wap_user']) ? $_SESSION['wap_user'] : array();

//默认add
$action = isset($_GET['action']) ? $_GET['action'] : 'add';

switch ($action) {
    case 'add':
        $product_id = !empty($_POST['product_id']) ? $_POST['product_id'] : '';
        $seckill_id = !empty($_POST['seckill_id']) ? $_POST['seckill_id'] : '';
        $sku_id = !empty($_POST['sku_id']) ? $_POST['sku_id'] : '';
        //活动详细
        $seckill_info = D('Seckill')->where(array('pigcms_id'=>$seckill_id))->find();

        //商品详细
        if($seckill_info['sku_id']){
            $product_info = D('Product')->table("Product as pro")->join('product_sku AS sku ON pro.product_id=sku.product_id','LEFT')
                ->where(array('sku_id'=>$sku_id))
                ->field("sku.*,pro.postage as postage,pro.status as status,pro.store_id as store_id")
                ->find();
        }else if(empty($seckill_info['sku_id'])){
            $product_info = D("Product")->where(array('product_id'=>$seckill_info['product_id']))->find();
        }

        if (empty($product_info['status'])) {
            json_return(1000, '商品不存在');
        }

        if ($sku_id) {
            $propertiesStr = '';
            // 有商品属性
            //判断库存是否存在
            $nowSku = D('Product_sku')->field('`sku_id`,`product_id`,`properties`,`price`,`return_point`,`after_subscribe_price`, `weight`,`drp_level_1_price`,`drp_level_2_price`,`drp_level_3_price`')->where(array('sku_id' => $sku_id))->find();

            $tmpPropertiesArr = explode(';', $nowSku['properties']);
            $properties = $propertiesValue = $productProperties = array();
            foreach ($tmpPropertiesArr as $value) {
                $tmpPro = explode(':', $value);
                $properties[] = $tmpPro[0];
                $propertiesValue[] = $tmpPro[1];
            }
            if (count($properties) == 1) {
                $findPropertiesArr = D('Product_property')->field('`pid`,`name`')->where(array('pid' => $properties[0]))->select();
                $findPropertiesValueArr = D('Product_property_value')->field('`vid`,`value`')->where(array('vid' => $propertiesValue[0]))->select();
            } else {
                $findPropertiesArr = D('Product_property')->field('`pid`,`name`')->where(array('pid' => array('in', $properties)))->select();
                $findPropertiesValueArr = D('Product_property_value')->field('`vid`,`value`')->where(array('vid' => array('in', $propertiesValue)))->select();
            }
            foreach ($findPropertiesArr as $value) {
                $propertiesArr[$value['pid']] = $value['name'];
            }
            foreach ($findPropertiesValueArr as $value) {
                $propertiesValueArr[$value['vid']] = $value['value'];
            }
            foreach ($properties as $key => $value) {
                $productProperties[] = array('pid' => $value, 'name' => $propertiesArr[$value], 'vid' => $propertiesValue[$key], 'value' => $propertiesValueArr[$propertiesValue[$key]]);
            }

            $propertiesStr = serialize($productProperties);
        }


        $trade_no = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999); //订单
        $data_order['order_no'] = $trade_no;
        $data_order['trade_no'] = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
        $data_order['store_id'] = (int)$product_info['store_id'];  //店铺id
        $data_order['activity_id'] = $seckill_id;                  //活动id
        $data_order['activity_type'] = 'seckill';                  //活动类型(秒杀)

        $data_order['type'] = '53';                                //秒杀
        $data_order['postage'] = $product_info['postage']; //邮费
        $data_order['sub_total'] = !empty($seckill_info['seckill_price']) ? $seckill_info['seckill_price'] : $product_info['price']; //商品总额(不含邮费)
        $data_order['total'] = $product_info['postage'] + $data_order['sub_total']; //订单总额(含邮费)
        $data_order['pro_count'] = 1; //商品数量
        $data_order['pro_num'] = 1; //商品数量

        if (!empty($wap_user['uid'])) {
            $data_order['uid'] = $wap_user['uid'];
        } else {
            $data_order['session_id'] = session_id();
        }
        $data_order['add_time'] = $_SERVER['REQUEST_TIME'];

        $order_id = D('Order')->data($data_order)->add();
        if (empty($order_id)) {
            json_return(1004, '订单产生失败，请重试');
        }

        $data_order_product['order_id'] = $order_id;
        $data_order_product['pro_num'] = 1;
        $data_order_product['sku_data']   = $propertiesStr;
        $data_order_product['product_id'] = $product_id;
        $data_order_product['sku_id']	 = $sku_id;
        $data_order_product['pro_price']  = !empty($seckill_info['seckill_price']) ? $seckill_info['seckill_price'] : $product_info['price'];
        $data_order_product['comment']	= !empty($_POST['custom']) ? serialize($_POST['custom']) : '';
        $data_order_product['pro_weight'] = $product_info['weight'];

        $order_no 	= $data_order['order_no'];
        $product_order_id = D('Order_product')->data($data_order_product)->add();
        json_return(0, $config['orderid_prefix'] . $order_no);
        break;
    case 'pay':
        import('source.class.OrderPay');
        $order_pay = new OrderPay();
        $order_pay->pay();
        break;
    case 'cart_count':
        if (empty($_COOKIE['wap_store_id']))
            json_return(1014, '访问异常');
        if ($wap_user['uid']) {
            $condition_user_cart['uid'] = $wap_user['uid'];
        } else {
            $condition_user_cart['session_id'] = session_id();
        }
        $condition_user_cart['store_id'] = $_COOKIE['wap_store_id'];
        $return['count'] = D('User_cart')->where($condition_user_cart)->count('pigcms_id');
        $return['store_id'] = $_COOKIE['wap_store_id'];
        //返回count、store_id
        json_return(0, $return);
    case 'test_pay':
        import('source.class.OrderPay');
        $order_pay = new OrderPay();
        $order_pay->test();
        break;
    case 'go_pay':
        import('source.class.OrderPay');
        $order_pay = new OrderPay();
        $order_pay->go_pay();
}
?>