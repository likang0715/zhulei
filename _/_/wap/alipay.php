<?php

/*
 * 支付宝支付
 */
require_once dirname(__FILE__) . '/global.php';
/*
  import('source.class.pay.Alipay');
  $payClass = new Alipay($nowOrder, $payMethodList[$payType]['config'], $wap_user);
  $payClass->pay();
 * 
 */

$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

if ($_GET['status']) {
    import('source.class.pay.Alipay');

    $nowOrder = M('Order')->find($_REQUEST['orderNo']);
    if (empty($nowOrder['total'])) {
        json_return(1006, '订单异常，请稍后再试');
    }
    $trade_no = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
    if ($nowOrder['status'] > 1 && $nowOrder['payment_method'] == 'codpay') {
        json_return(1008, './order.php?orderid=' . $nowOrder['order_id']);
    }
    if ($nowOrder['status'] > 1) {
        json_return(1007, '该订单已支付或关闭<br/>不再允许付款');
    }
    
    // 支付前重新判断库存
    foreach ($nowOrder['proList'] as $product) {
        $product_tmp = D('Product')->where("product_id = '" . $product['product_id'] . "'")->find();
        // 查找库存
        if ($product_tmp['has_property'] == 0) {
            if ($product_tmp['quantity'] < $product['pro_num']) {
                json_return(1010, $product_tmp['name'] . '的库存不足');
                exit;
            }
        } else {
            $sku = D('Product_sku')->where(array('sku_id' => $product['sku_id']))->find();
            if ($sku['quantity'] < $product['pro_num']) {
                json_return(1010, $product['name'] . '的库存不足');
                exit;
            }
        }
        
        // 限购，支付时，也做限制判断
        if ($product_tmp['buyer_quota']) {
            $buy_quantity = 0;
            $user_type = 'uid';
            $uid = $_SESSION['wap_user']['uid'];
            if (empty($_SESSION['wap_user'])) { //游客购买
                $session_id = session_id();
                $uid = $session_id;
                $user_type = 'session';
                //购物车
                $cart_number = D('User_cart')->field('sum(pro_num) as pro_num')->where(array('product_id' => $nowProduct['product_id'], 'session_id' => $session_id))->find();
                if (!empty($cart_number)) {
                    $buy_quantity += $cart_number['pro_num'];
                }
            } else {
                //购物车
                $cart_number = D('User_cart')->field('sum(pro_num) as pro_num')->where(array('product_id' => $nowProduct['product_id'], 'uid' => $uid))->select();
                if (!empty($cart_number)) {
                    $buy_quantity += $cart_number['pro_num'];
                }
            }
            
            // 再加上订单里已经购买的商品
            $buy_quantity += M('Order_product')->getBuyNumber($uid, $product_tmp['product_id'], $user_type);
        
            if ($buy_quantity > $product_tmp['buyer_quota']) {
                json_return(1010, '您购买的产品：' . $product['name'] . '超出了限购');
            }
        }
    }
    
    $offline_payment = false;
    if (empty($nowOrder['status'])) {
        if (empty($nowOrder['order_id'])) {
            json_return(1008, '该订单不存在');
        }
            
        $store = M('Store')->wap_getStore($nowOrder['store_id']);
        if ($store['offline_payment']) {
            $offline_payment = true;
        }
    
        $condition_order['order_id'] = $nowOrder['order_id'];
        if ($wap_user['uid']) {
            $condition_order['uid'] = $wap_user['uid'];
        } else {
            $condition_order['session_id'] = session_id();
        }
        if ($_POST['shipping_method'] == 'selffetch') {
            $selffetch_id = $_POST['selffetch_id'];
            $selffetch = array();
            if (strpos($selffetch_id, 'store')) {
                $store_contace = M('Store_contact')->get($nowOrder['store_id']);
                if (!empty($store_contace)) {
                    $store = M('Store')->getStore($nowOrder['store_id']);
                    $selffetch['tel'] = ($store_contace['phone1'] ? $store_contace['phone1'] . '-' : '') . $store_contace['phone2'];
                    $selffetch['business_hours'] = '';
                    $selffetch['name'] = $store['name'];
                    $selffetch['physical_id'] = 0;
                    $selffetch['store_id'] = $nowOrder['store_id'];
                }
            } else {
                $selffetch = M('Store_physical')->getOne($selffetch_id);
                if (!empty($selffetch) && $selffetch['store_id'] != $nowOrder['store_id']) {
                    $selffetch = '';
                } else if (!empty($selffetch)) {
                    $selffetch['tel'] = ($selffetch['phone1'] ? $selffetch['phone1'] . '-' : '') . $selffetch['phone2'];
                    $selffetch['physical_id'] = $selffetch_id;
                    $selffetch['store_id'] = $nowOrder['store_id'];
                }
            }
    
            //$selffetch = M('Trade_selffetch')->get_selffetch($_POST['selffetch_id'],$nowOrder['store_id']);
            if (empty($selffetch)) {
                json_return(1009, '该门店不存在');
            }
            $data_order['postage'] = '0';
            //$data_order['total'] = $nowOrder['sub_total'];
            $data_order['shipping_method'] = 'selffetch';
            $data_order['address_user'] = $_POST['selffetch_name'];
            $data_order['address_tel'] = $_POST['selffetch_phone'];
            $data_order['address'] = serialize(array(
                    'name' => $selffetch['name'],
                    'address' => $selffetch['address'],
                    'province' => $selffetch['province_txt'],
                    'province_code' => $selffetch['province'],
                    'city' => $selffetch['city_txt'],
                    'city_code' => $selffetch['city'],
                    'area' => $selffetch['county_txt'],
                    'area_code' => $selffetch['county'],
                    'tel' => $selffetch['tel'],
                    'long' => $selffetch['long'],
                    'lat' => $selffetch['lat'],
                    'business_hours' => $selffetch['business_hours'],
                    'date' => $_POST['selffetch_date'],
                    'time' => $_POST['selffetch_time'],
                    'store_id' => $selffetch['store_id'],
                    'physical_id' => $selffetch['physical_id'],
            ));
    
            // 到自提点将邮费设置为0
            $nowOrder['postage'] = 0;
            // 将所有供货商的运费全部改为空
            $_POST['postage_list'] = '';
        } else if ($_POST['shipping_method'] == 'friend') {
            $friend_name = $_POST['friend_name'];
            $friend_phone = $_POST['friend_phone'];
            $province = $_POST['province'];
            $city = $_POST['city'];
            $county = $_POST['county'];
            $friend_address = $_POST['friend_address'];
            $friend_date = $_POST['friend_date'];
            $friend_time = $_POST['friend_time'];
    
            if (empty($friend_name)) {
                json_return(1009, '朋友姓名没有填写');
            }
            if (!preg_match("/\d{9,13}$/", $friend_phone)) {
                json_return(1009, '请填写正确的手机号');
            }
            if (empty($province)) {
                json_return(1009, '请选择省份');
            }
            if (empty($city)) {
                json_return(1009, '请选择城市');
            }
            if (empty($county)) {
                json_return(1009, '请选择区县');
            }
    
            import('source.class.area');
            $area_class = new area();
            $province_txt = $area_class->get_name($province);
            $city_txt = $area_class->get_name($city);
            $county_txt = $area_class->get_name($county);
    
            if (empty($province_txt) || empty($city_txt)) {
                json_return(1009, '该地址不存在');
            }
    
            //$data_order['total'] = $nowOrder['sub_total'];
            $data_order['shipping_method'] = 'friend';
            $data_order['address_user'] = $friend_name;
            $data_order['address_tel'] = $friend_phone;
            $data_order['address'] = serialize(array(
                    'address' => $friend_address,
                    'province' => $province_txt,
                    'province_code' => $province,
                    'city' => $city_txt,
                    'city_code' => $city,
                    'area' => $county_txt,
                    'area_code' => $county,
                    'date' => $friend_date,
                    'time' => $friend_time,
            ));
        } else {
            $address = M('User_address')->getAdressById(session_id(), $wap_user['uid'], $_POST['address_id']);
            if (empty($address))
                json_return(1009, '该地址不存在');
            $data_order['shipping_method'] = 'express';
            $data_order['address_user'] = $address['name'];
            $data_order['address_tel'] = $address['tel'];
            $data_order['address'] = serialize(array(
                    'address' => $address['address'],
                    'province' => $address['province_txt'],
                    'province_code' => $address['province'],
                    'city' => $address['city_txt'],
                    'city_code' => $address['city'],
                    'area' => $address['area_txt'],
                    'area_code' => $address['area'],
            ));
        }
        $data_order['status'] = '1';
        if (!empty($_POST['msg'])) {
            $data_order['comment'] = $_POST['msg'];
        }
        $data_order['trade_no'] = $trade_no;
        if (!D('Order')->where($condition_order)->data($data_order)->save()) {
            json_return(1010, '订单信息保存失败');
        }
            
        // 抽出可以享受的优惠信息与优惠券
        import('source.class.Order');
        $order_data = new Order($nowOrder['proList']);
        // 不同供货商的优惠、满减、折扣、包邮等信息
        $order_data = $order_data->all();
            
        // 保存满减，优惠券信息
        // 优惠活动
        $product_id_arr = array();
        $discount_money = 0;
        $product_price_arr = array();
        foreach ($nowOrder['proList'] as $product) {
            $discount = 10;
            if ($product['wholesale_supplier_id']) {
                $discount = $order_data['discount_list'][$product['wholesale_supplier_id']];
                $product_price_arr[$product['wholesale_supplier_id']] += $product['pro_price'] * $product['pro_num'];
            } else {
                $discount = $order_data['discount_list'][$product['store_id']];
                $product_price_arr[$product['store_id']] += $product['pro_price'] * $product['pro_num'];
            }
    
            if ($discount != 10 && $discount > 0) {
                $discount_money += $product['pro_num'] * $product['pro_price'] * (10 - $discount) / 10;
            }
    
            // 多供货商不支付货到付款
            if ($product['wholesale_supplier_id'] != '0') {
                $offline_payment = false;
            }
    
            $product_id_arr[] = $product['product_id'];
        }
            
        // 用户享受的优惠券
        $money = 0;
        $pro_num = 0;
        $pro_count = 0;
        if ($wap_user['uid']) {
            if (isset($order_data['reward_list']) && is_array($order_data['reward_list'])) {
                foreach ($order_data['reward_list'] as $tmp_store_id => $reward_list) {
                    foreach ($reward_list as $key => $reward) {
                        if ($key === 'product_price_list') {
                            continue;
                        }
        
                        // 积分
                        if ($reward['score'] > 0) {
                            M('Store_user_data')->changePoint($tmp_store_id, $wap_user['uid'], $reward['score']);
                            //增加积分日志
                            $data_point_record = array(
                                    'uid' => $wap_user['uid'],
                                    'store_id' => $tmp_store_id,
                                    'points' => $reward['score'],
                                    'order_id' =>  $nowOrder['order_id'],
                                    'is_call_to_fans' => 0,
                                    'type' => '5',                      //满减送
                                    'is_available'=> 0,                 //不可用
                                    'timestamp' => time(),
                            );
                            M('User_points_record')->add($data_point_record);
                        }
        
                        // 送赠品
                        if (is_array($reward['present']) && count($reward['present']) > 0) {
                            foreach ($reward['present'] as $present) {
                                $data_order_product = array();
                                $data_order_product['order_id'] = $nowOrder['order_id'];
                                $data_order_product['product_id'] = $present['product_id'];
        
                                // 是否有属性，有则随机挑选一个属性
                                if ($present['has_property']) {
                                    $sku_arr = M('Product_sku')->getRandSku($present['product_id']);
                                    $data_order_product['sku_id'] = $sku_arr['sku_id'];
                                    $data_order_product['sku_data'] = $sku_arr['propertiey'];
                                }
        
                                $data_order_product['pro_num'] = 1;
                                $data_order_product['pro_price'] = 0;
                                $data_order_product['is_present'] = 1;
        
                                $pro_num++;
                                if (!in_array($present['product_id'], $product_id_arr)) {
                                    $pro_count++;
                                }
        
                                D('Order_product')->data($data_order_product)->add();
                                unset($data_order_product);
                            }
                        }
        
                        // 送优惠券
                        if ($reward['coupon']) {
                            $data_user_coupon = array();
                            $data_user_coupon['uid'] = $wap_user['uid'];
                            $data_user_coupon['store_id'] = $reward['coupon']['store_id'];
                            $data_user_coupon['coupon_id'] = $reward['coupon']['id'];
                            $data_user_coupon['card_no'] = String::keyGen();
                            $data_user_coupon['cname'] = $reward['coupon']['name'];
                            $data_user_coupon['face_money'] = $reward['coupon']['face_money'];
                            $data_user_coupon['limit_money'] = $reward['coupon']['limit_money'];
                            $data_user_coupon['start_time'] = $reward['coupon']['start_time'];
                            $data_user_coupon['end_time'] = $reward['coupon']['end_time'];
                            $data_user_coupon['is_expire_notice'] = $reward['coupon']['is_expire_notice'];
                            $data_user_coupon['is_share'] = $reward['coupon']['is_share'];
                            $data_user_coupon['is_all_product'] = $reward['coupon']['is_all_product'];
                            $data_user_coupon['is_original_price'] = $reward['coupon']['is_original_price'];
                            $data_user_coupon['description'] = $reward['coupon']['description'];
                            $data_user_coupon['timestamp'] = time();
                            $data_user_coupon['type'] = 2;
                            $data_user_coupon['give_order_id'] = $nowOrder['order_id'];
        
                            D('User_coupon')->data($data_user_coupon)->add();
                        }
        
                        $reward['store_id'] = $tmp_store_id;
                        $data = array();
                        $data['order_id'] = $nowOrder['order_id'];
                        $data['uid'] = $wap_user['uid'];
                        $data['rid'] = $reward['rid'];
                        $data['name'] = $reward['name'];
                        $data['content'] = serialize($reward);
                        $money += $reward['cash'];
                        D('Order_reward')->data($data)->add();
                    }
                }
            }
    
            // 用户使用的优惠券
            $coupon_id = $_POST['user_coupon_id'];
            if (isset($order_data['user_coupon_list']) && is_array($order_data['user_coupon_list'])) {
                foreach ($order_data['user_coupon_list'] as $tmp_store_id => $user_coupon_list) {
                    foreach ($user_coupon_list as $user_coupon) {
                        if (in_array($user_coupon['id'], $coupon_id)) {
                            $data = array();
                            $data['order_id'] = $nowOrder['order_id'];
                            $data['uid'] = $wap_user['uid'];
                            $data['store_id'] = $tmp_store_id;
                            $data['coupon_id'] = $user_coupon['coupon_id'];
                            $data['name'] = $user_coupon['cname'];
                            $data['user_coupon_id'] = $user_coupon['id'];
                            $data['money'] = $user_coupon['face_money'];
        
                            $money += $user_coupon['face_money'];
                            D('Order_coupon')->data($data)->add();
        
                            // 将用户优惠券改为已使用
                            $data = array();
                            $data['is_use'] = 1;
                            $data['use_time'] = time();
                            $data['use_order_id'] = $nowOrder['order_id'];
                            D('User_coupon')->where(array('id' => $user_coupon['id']))->data($data)->save();
                            break;
                        }
                    }
                }
            }
        }
            
        // 折扣、包邮
        if (isset($order_data['discount_list'])) {
            $postage_free_list = $order_data['postage_free_list'];
            $postage_list = $_POST['postage_list'];
            if (!empty($postage_list)) {
                $postage_list = unserialize($postage_list);
            }
    
            foreach ($order_data['discount_list'] as $tmp_store_id => $discount) {
                if (($discount != 0 && $discount != 10) || !empty($postage_free_list[$tmp_store_id])) {
                    $order_discount_data = array();
                    $order_discount_data['order_id'] = $nowOrder['order_id'];
                    $order_discount_data['uid'] = $wap_user['uid'];
                    $order_discount_data['store_id'] = $tmp_store_id;
                    $order_discount_data['discount'] = $discount;
                    $order_discount_data['is_postage_free'] = $postage_free_list[$tmp_store_id];
                    $order_discount_data['postage_money'] = 0;
    
                    if (isset($postage_list[$tmp_store_id])) {
                        $order_discount_data['postage_money'] = $postage_list[$tmp_store_id];
                    }
    
                    D('Order_discount')->data($order_discount_data)->add();
                }
            }
        }
            
        // 更改订单金额
        $total = max(0, $nowOrder['sub_total'] + $nowOrder['postage'] + $nowOrder['float_amount'] - $money - $discount_money);
        $pro_count = $nowOrder['pro_count'] + $pro_count;
        $pro_num = $nowOrder['pro_num'] + $pro_num;
    
        $data = array();
        $data['total'] = $total;
        $data['pro_count'] = $pro_count;
        $data['pro_num'] = $pro_num;
        $data['status'] = 1;
        if ($_POST['payType'] == 'offline' && $offline_payment) {
            $data['status'] = 2;
            $data['payment_method'] = 'codpay';
        } else if ($_POST['payType'] == 'peerpay') {
            $data['payment_method'] = 'peerpay';
        }
    
        D('Order')->where(array('order_id' => $nowOrder['order_id']))->data($data)->save();
        $nowOrder['total'] = $total;
    } else {
        $store = M('Store')->wap_getStore($nowOrder['store_id']);
        if ($store['offline_payment']) {
            $offline_payment = true;
        }
        foreach ($nowOrder['proList'] as $product) {
            // 分销商品不参与满赠和使用优惠券
            if ($product['source_product_id'] != '0') {
                $offline_payment = false;
                break;
            }
        }
    
        $data_order = array();
        if ($_POST['payType'] == 'offline' && $offline_payment) {
            $data_order['status'] = 2;
            $data_order['payment_method'] = 'codpay';
        } else if ($_POST['payType'] == 'peerpay') {
            $data_order['payment_method'] = 'peerpay';
        }
    
        $condition_order['order_id'] = $nowOrder['order_id'];
        $data_order['trade_no'] = $trade_no;
        if (!D('Order')->where($condition_order)->data($data_order)->save())
            json_return(1010, '订单信息保存失败');
    }
    
    $nowOrder['trade_no'] = $trade_no;
    $payType = $_REQUEST['payType'];
    
    if ($nowOrder['total'] <= 0) {
        // 使用优惠后，不需要付款，直接更改订单状态
        D('Order')->where(array('order_id' => $nowOrder['order_id']))->data(array('status' => 2, 'paid_time' => time()))->save();
        // 更改优惠券可用
        M('User_coupon')->save(array('is_valid' => 1), array('give_order_id' => $nowOrder['order_id']));
    
        $database_product = D('Product');
        $database_product_sku = D('Product_sku');
        foreach ($nowOrder['proList'] as $value) {
            if ($value['sku_id']) {
                $condition_product_sku['sku_id'] = $value['sku_id'];
                $database_product_sku->where($condition_product_sku)->setInc('sales', $value['pro_num']);
                $database_product_sku->where($condition_product_sku)->setDec('quantity', $value['pro_num']);
            }
            $condition_product['product_id'] = $value['product_id'];
            $database_product->where($condition_product)->setInc('sales', $value['pro_num']);
            $database_product->where($condition_product)->setDec('quantity', $value['pro_num']);
        }
        json_return(0, 'order.php?orderid=' . $nowOrder['order_id']);
    }

    if ($_POST['payType'] == 'offline' && !$offline_payment) {
        json_return(1012, '对不起，订单不支付货到付款');
    } else if ($_POST['payType'] == 'offline' && $offline_payment) {
        json_return(0, '/wap/order.php?orderid=' . $nowOrder['order_id']);
    } else if ($_POST['payType'] == 'peerpay') {
        if ($store['pay_agent'] != '1') {
            json_return(1012, '您选择的支付方式不存在<br/>请更新支付方式aaa');
        } else {
            json_return(0, '/wap/order_share.php?orderid=' . $_REQUEST['orderNo']);
        }
    }

    $payMethodList = M('Config')->get_pay_method();

    if (empty($payMethodList[$payType])) {
        json_return(1012, '您选择的支付方式不存在<br/>请更新支付方式');
    }
    $nowOrder['order_no_txt'] = option('config.orderid_prefix') . $nowOrder['order_no'];
    unset($_SESSION['float_amount']);
    unset($_SESSION['float_postage']); 
    $payClass = new Alipay($nowOrder, $payMethodList[$payType]['config'], $wap_user);
    $payInfo = $payClass->pay();
//    if ($payInfo['err_code']) {
//        json_return(1013, $payInfo['err_msg']);
//    } else {
//        //json_return(0, $payInfo['url']);
//    }
} else {
    include display('alipay_iframe_pay');
}
?>
