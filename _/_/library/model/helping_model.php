<?php
/**
 * 应用营销助力模型
 * User: gerrant
 * Date: 2016/02/17
 * Time: 10:06
 */
class helping_model extends base_model{

    // 商品兑奖
    function prize_product($store_id,$product_id,$sku_id){
        $order_no = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
        $data_order['store_id'] = $store_id;
        $data_order['order_no'] = $data_order['trade_no'] = $order_no;
        $data_order['uid'] = $_SESSION['wap_user']['uid'];
        $data_order['pro_num'] = 1;
        $data_order['pro_count'] = '1';
        $data_order['type'] = 58;
        $data_order['bak'] = '助力活动订单';
        $data_order['activity_data'] = '';
        $data_order['add_time'] = $_SERVER['REQUEST_TIME'];
        $data_order['sub_total'] = 0;
        $data_order['order_pay_point'] = 0;
        $data_order['is_point_order'] = 0;
        $data_order['status'] = 2;	// 已支付的订单状态
        // 用户信息
        $user_address = D('User_address')->where(array('uid'=>$_SESSION['wap_user']['uid']))->find();
        $data_order['address_user'] = $user_address['name'];
        $data_order['address_tel']=trim($user_address['tel']);
        $address = M('User_address')->getAdressById(session_id(), $_SESSION['wap_user']['uid'],$user_address['address_id']);


        $data_order['address'] = serialize(array(
            'address' => $address['address'],
            'province' => $address['province_txt'],
            'province_code' => $address['province'],
            'city' => $address['city_txt'],
            'city_code' => $address['city'],
            'area' => $address['area_txt'],
            'area_code' => $address['area'],
        ));
        $data_order['shipping_method'] = 'express';



        $order_id = D('Order')->data($data_order)->add();
        $data_order_product['order_id'] = $order_id;
        $data_order_product['product_id'] = $product_id;
        $data_order_product['sku_id']	 = $sku_id;
        $data_order_product['sku_data']   = '';
        $data_order_product['pro_num']	= 1;
        $data_order_product['pro_price']  = 0;
        $data_order_product['comment']	= '';
        $data_order_product['pro_weight'] = 0;
        $data_order_product['pro_price'] = 0;
        $data_order_product['is_fx']			   = 0;
        $data_order_product['supplier_id']		   = 0;
        $data_order_product['original_product_id'] = 0;
        $data_order_product['user_order_id']	   = $order_id;
        D('Order_product')->data($data_order_product)->add();

        // 更新实际库存
        $database_product = D('Product');
        $database_product_sku = D('Product_sku');
        if ($sku_id) {
            $condition_product_sku['sku_id'] = $sku_id;
            $database_product_sku->where($condition_product_sku)->setInc('sales', 1);
            $database_product_sku->where($condition_product_sku)->setDec('quantity', 1);
        }
        $condition_product['product_id'] = $product_id;
        $database_product->where($condition_product)->setInc('sales', 1);
        $database_product->where($condition_product)->setDec('quantity', 1);


        // 产生提醒
        import('source.class.Notify');
        Notify::createNoitfy($store_id, option('config.orderid_prefix') . $order_no);

        //////////////////////////////////////////////////////////////////////////////////////////////////
        // $uid = $_SESSION['wap_user']['uid'];
        // $first_product_name = $product_info ? msubstr($product_info[name],0,11) : "";

        //产生提醒-已生成订单
        //import('source.class.Notice');
        //Notice::sendOut($uid, $nowOrder,$first_product_name);
        return $order_id;
    }

    // 兑奖 优惠券
    function prize_coupon($coupon_id){
        $time = time();
        $uid = $_SESSION['wap_user']['uid'];
        $coupon = D('Coupon')->where(array('id' => $coupon_id))->find();
        //查看是否已经领取
        if ($coupon['total_amount'] <= $coupon['number']) {
            return array('err_code'=>1002,'err_msg'=>'该优惠券已经全部发放完了');
        }

        if ($coupon['status'] == '0') {
            return array('err_code'=>1003,'err_msg'=>'该优惠券已失效!');
        }

        if ($time > $coupon['end_time'] || $time < $coupon['start_time']) {
            return array('err_code'=>1004,'err_msg'=>'该优惠券未开始或已结束!');
        }

        if ($coupon['type'] == '2') {
            return array('err_code'=>1005,'err_msg'=>'不可领取赠送券!');
        }
        $user_coupon = D('User_coupon')->where(array('uid' => $uid, 'coupon_id' => $coupon_id))->field("count(id) as count")->find();

        //查看当前用户是否达到最大领取限度
        if ($coupon['most_have'] != '0') {
            if ($user_coupon['count'] >= $coupon['most_have']) {
                // 领奖环节若已领满，则通知用户领取成功，实际不予发放。
                return array('err_code'=>0,'err_msg'=>'领取成功!');
            }
        }
        //领取
        if(M('User_coupon')->add($uid,$coupon)){
            //修改优惠券领取信息
            unset($where);unset($data);

            $where = array('id'=>$coupon_id);
            D('Coupon')->where($where)->setInc('number',1);
            return array('err_code'=>0,'err_msg'=>'领取成功!');
        } else{
            return array('err_code'=>1111,'err_msg'=>'领取失败!');
        }
    }
}
