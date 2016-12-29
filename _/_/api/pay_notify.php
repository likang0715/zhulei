<?php
/**
 *  支付异步通知
 */

define('PIGCMS_PATH', dirname(__FILE__).'/../');
require_once PIGCMS_PATH.'source/init.php';
require_once 'functions.php';

if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
    $now = time();
    $timestamp = $_POST['request_time'];
    $sign_key = $_POST['sign_key'];
    unset($_POST['request_time']);
    unset($_POST['sign_key']);
    $_POST['salt'] = SIGN_SALT;
    if (!_checkSign($sign_key, $_POST)) {
        $error_code = 1004;
        $error_msg = '签名无效';
        $return_url = '';
    } else if (!empty($_POST['order_no'])) {
        $order_no = trim($_POST['order_no']);
        $database_order = D('Order');
        $product_model = M('Product');
        $product_sku = M('Product_sku');
        $nowOrder = M('Order')->findSimple($order_no);
        $condition_order['order_no'] = $nowOrder['order_no'];
        if($nowOrder && $nowOrder['status'] == 1){
            $pay_money = !empty($_POST['pay_money']) ? $_POST['pay_money'] : $nowOrder['total'];
            $data_order['third_id']       = $_POST['third_id'];
            $data_order['payment_method'] = !empty($_POST['payment_method']) ? $_POST['payment_method'] : $nowOrder['payment_method'];
            $data_order['pay_money']      = $pay_money; //支付金额
            $data_order['paid_time']      = $_SERVER['REQUEST_TIME'];
            $data_order['status']         = 2; //已支付
            if(D('Order')->where($condition_order)->data($data_order)->save()){
                $nowStore = D('Store')->field('`store_id`,`income`,`unbalance`,`drp_level`,`drp_supplier_id`,`drp_diy_store`')->where(array('store_id' => $nowOrder['store_id']))->find();
                $drp_level       = $nowStore['drp_level']; //当前分销商等级，非分销商为0
                $max_drp_level   = $drp_level; //当前最大分销（分销商实际等级）
                $drp_multi_level = false; //是否为多级分销
                $max_store_drp_level = option('config.max_store_drp_level');
                if ($drp_level > 3 && (empty($max_store_drp_level) || $max_store_drp_level > 3)) {
                    $drp_level = 3; //大于3级的分销商都以3级处理，并且上级分销商只取向上两级
                    $drp_multi_level = true;
                } else if (empty($nowStore['drp_diy_store'])) { //禁止装修店铺
                    $drp_multi_level = true;
                }

                $data_store['income'] = $nowStore['income'] + $pay_money; //更新收入
                $data_store['unbalance'] = $nowStore['unbalance'] + $pay_money; //更新余额
                $data_store['last_edit_time'] = time();
                //店铺收入
                if(D('Store')->where(array('store_id'=>$nowOrder['store_id']))->data($data_store)->save()){
                    $type = 1;
                    if (!empty($nowOrder['type']) && $nowOrder['type'] == 3) {
                        $type = 5; //类型：分销
                    }
                    //收入记录
                    $data_financial_record['store_id']       = $nowOrder['store_id'];
                    $data_financial_record['order_id']       = $nowOrder['order_id'];
                    $data_financial_record['order_no']       = $nowOrder['order_no'];
                    $data_financial_record['income']         = $pay_money;
                    $data_financial_record['type']           = $type;
                    $data_financial_record['balance']        = $nowStore['income'];
                    $data_financial_record['payment_method'] = !empty($_POST['payment_method']) ? $_POST['payment_method'] : $nowOrder['payment_method'];
                    $data_financial_record['trade_no']       = $nowOrder['trade_no'];
                    $data_financial_record['add_time']       = $_SERVER['REQUEST_TIME'];
                    $data_financial_record['user_order_id']  = $nowOrder['order_id'];
                    $data_financial_record['storeOwnPay']    = $nowOrder['useStorePay'];
                    $financial_record_id = D('Financial_record')->data($data_financial_record)->add();
                }

                //修改店铺未发货的订单数量
                if (!empty($nowOrder['uid'])) {
                    M('Store_user_data')->upUserData($nowOrder['store_id'], $nowOrder['uid'], 'unsend');
                }

                //减少库存 因为支付的特殊性，不处理是否有过修改
                $database_order_product = D('Order_product');
                $condition_order_product['order_id'] = $nowOrder['order_id'];
                $orderProductList = $database_order_product->where($condition_order_product)->select(); //订单商品列表
                $database_product = D('Product');
                $database_product_sku = D('Product_sku');
                //分销的商品
                $fx_product = array();
                //批发的商品
                $wholesale_products = array();
                //批发商品的供货商
                $wholesale_suppliers = array();
                foreach($orderProductList as $value){
                    //分销订单处理
                    $product = M('Product')->get(array('product_id' => $value['product_id']));
                    if (!empty($value['supplier_id'])) { //非自营商品
                        if (!empty($value['is_fx'])) { //分销商品
                            $fx_product[$value['supplier_id']][] = array(
                                'order_product_id'       => $value['pigcms_id'],
                                'product_id'             => $value['product_id'],
                                'sku_id'                 => $value['sku_id'],
                                'sku_data'               => $value['sku_data'],
                                'quantity'               => $value['pro_num'],
                                'price'                  => $value['pro_price'],
                                'cost_price'             => $product['cost_price'],
                                'postage_type'           => $product['postage_type'],
                                'postage'                => $product['postage'],
                                'postage_template_id'    => $product['postage_template_id'],
                                'source_product_id'      => !empty($product['source_product_id']) ? $product['source_product_id'] : $product['product_id'], //分销商品来源
                                'original_product_id'    => !empty($product['original_product_id']) ? $product['original_product_id'] : $product['product_id'], //分销商品原始id
                                'comment'                => $value['comment'],
                                'is_fx'                  => $value['is_fx'],
                                'unified_price_setting'  => $product['unified_price_setting'],
                                'drp_level_1_cost_price' => $product['drp_level_1_cost_price'],
                                'drp_level_2_cost_price' => $product['drp_level_2_cost_price'],
                                'drp_level_3_cost_price' => $product['drp_level_3_cost_price'],
                                'drp_level_1_price'      => $product['drp_level_1_price'],
                                'drp_level_2_price'      => $product['drp_level_2_price'],
                                'drp_level_3_price'      => $product['drp_level_3_price'],
                            );
                        }

                        if (!empty($product['wholesale_product_id'])) { //批发商品
                            $wholesale_products[$product['supplier_id'] . ',' . $product['store_id']][] = array(
                                'order_product_id'     => $value['pigcms_id'],
                                'product_id'           => $value['product_id'],
                                'sku_id'               => $value['sku_id'],
                                'sku_data'             => $value['sku_data'],
                                'quantity'             => $value['pro_num'],
                                'comment'              => $value['comment'],
                                'wholesale_price'      => $product['wholesale_price'],
                                'wholesale_product_id' => $product['wholesale_product_id'],
                                'price'                => $value['pro_price'],
                                'is_comment'           => $value['is_comment'],
                                'is_present'           => $value['is_present'],
                                'user_order_id'        => $value['user_order_id'],
                                'return_status'        => $value['return_status'],
                                'cost_price'           => $product['cost_price'],
                                'drp_level_1_cost_price' => $product['drp_level_1_cost_price'],
                            );
                            $wholesale_suppliers[] = $product['supplier_id'];
                        }

                        if (empty($nowStore['drp_diy_store']) && !empty($product['unified_price_setting'])) {
                            $product['original_product_id'] = $product['product_id'];
                        }
                        //获取分销商品(同步库存)
                        if (!empty($product['original_product_id'])) {
                            sync_sku($value['product_id'], $product['original_product_id'], $value['sku_data'], $value['pro_num']);
                        } else if (!empty($product['wholesale_product_id'])) {
                            sync_sku($value['product_id'], $product['wholesale_product_id'], $value['sku_data'], $value['pro_num']);
                        } else {
                            sync_sku($value['product_id'], $value['product_id'], $value['sku_data'], $value['pro_num']);
                        }
                    } else { //普通商品
                        if ($value['sku_id']) {
                            $condition_product_sku['sku_id'] = $value['sku_id'];
                            $database_product_sku->where($condition_product_sku)->setInc('sales', $value['pro_num']);
                            $database_product_sku->where($condition_product_sku)->setDec('quantity', $value['pro_num']);
                        }
                        $condition_product['product_id'] = $value['product_id'];
                        $database_product->where($condition_product)->setInc('sales', $value['pro_num']);
                        $database_product->where($condition_product)->setDec('quantity', $value['pro_num']);

                        if (!empty($product['is_wholesale'])) { //允许批发商品
                            sync_sku($value['product_id'], $value['product_id'], $value['sku_data'], $value['pro_num'], false);
                        }
                    }
                }
                if (!empty($fx_product) && $drp_level > 0) { //订单中有分销商品
                    $fx_order = M('Fx_order');
                    $fx_order_product = M('Fx_order_product');
                    $nowAddress = unserialize($nowOrder['address']); //默认使用用户收货地址
                    foreach ($fx_product as $key => $products) {
                        $supplier_id       = $key; //供货商
                        $fx_order_no       = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999); //分销订单号
                        $sub_total         = 0;
                        $cost_sub_total    = 0;
                        $postage           = 0;
                        $total             = 0;
                        $cost_total        = 0;
                        $quantity          = 0;
                        $hasTplPostage     = false;
                        $postage_arr       = array();
                        foreach ($products as $k => $product) {//订单商品
                            //商品属性
                            $properties = getProperty2Str($product['sku_data']);
                            $source_product_id = $product['product_id']; //分销来源商品

                            if (!empty($properties)) { //有属性
                                $sku = $product_sku->getSku($source_product_id, $properties);
                                if (!empty($product['unified_price_setting'])) { //统一定价
                                    $cost_price = ($sku['drp_level_' . $drp_level . '_cost_price'] > 0) ? $sku['drp_level_' . $drp_level . '_cost_price'] : $sku['price']; //分销来源商品的成本价格
                                } else {
                                    $cost_price = ($sku['cost_price'] > 0) ? $sku['cost_price'] : $sku['price']; //分销来源商品的成本价格
                                }
                            } else { //无属性
                                if (!empty($product['unified_price_setting'])) { //统一定价
                                    $cost_price = ($product['drp_level_' . $drp_level . '_cost_price'] > 0) ? $product['drp_level_' . $drp_level . '_cost_price'] : $product['price']; //分销来源商品的成本价格，如果未设置分销成本价默认用商品价格
                                } else {
                                    $cost_price = ($product['cost_price'] > 0) ? $product['cost_price'] : $product['price']; //分销来源商品的成本价格，如果未设置分销成本价默认用商品价格
                                }
                            }

                            if ($product['price'] - $cost_price > 0) {
                                $pro_profit = $product['price'] - $cost_price;
                                //更新单件商品利润
                                D('Order_product')->where(array('pigcms_id' => $product['order_product_id']))->data(array('profit' => $pro_profit))->save();
                            }
                            $products[$k]['cost_price'] = $cost_price;
                            $price = $product['price'];

                            $sub_total += ($price * $product['quantity']); //订单商品总金额
                            $cost_sub_total += ($cost_price * $product['quantity']); //订单商品成本总金额
                            $quantity += $product['quantity']; //订单商品总数量
                        }
                        //订单运费
                        $fx_postages = array();
                        if (!empty($nowOrder['fx_postage'])) {
                            $fx_postages = unserialize($nowOrder['fx_postage']);
                        }
                        $postage = !empty($nowOrder['postage']) ? $nowOrder['postage'] : 0; //供货商运费

                        //订单总金额
                        $total = $sub_total + $postage;
                        //订单成本总金额
                        $cost_total = $cost_sub_total + $postage;

                        $data = array(
                            'fx_order_no'      => $fx_order_no,
                            'uid'              => $nowOrder['uid'],
                            'session_id'       => $nowOrder['session_id'],
                            'order_id'         => $nowOrder['order_id'],
                            'order_no'         => $nowOrder['order_no'],
                            'fx_trade_no'      => date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999),
                            'supplier_id'      => $supplier_id,
                            'store_id'         => $nowOrder['store_id'],
                            'quantity'         => $quantity,
                            'sub_total'        => $sub_total,
                            'cost_sub_total'   => $cost_sub_total,
                            'postage'          => $postage, //分销订单运费
                            'total'            => $total,
                            'cost_total'       => $cost_total,
                            'delivery_user'    => $nowOrder['address_user'],
                            'delivery_tel'     => $nowOrder['address_tel'],
                            'delivery_address' => $nowOrder['address'],
                            'add_time'         => time(),
                            'user_order_id'    => $nowOrder['order_id'],
                            'fx_postage'       => $nowOrder['fx_postage'],
                            'status'           => 2, //已付款
                            'suppliers'        => $nowOrder['suppliers']
                        );
                        if ($fx_order_id = $fx_order->add($data)) { //添加分销商订单
                            //标识订单为分销订单（包含分销商品）
                            M('Order')->setFxOrder($nowOrder['store_id'], $nowOrder['order_id']);
                            $suppliers = array();
                            //添加订单商品
                            foreach ($products as $product) {
                                $fx_order_product->add(array('fx_order_id' => $fx_order_id, 'product_id' => $product['product_id'], 'source_product_id' => $product['product_id'], 'price' => $product['price'], 'cost_price' => $product['cost_price'], 'quantity' => $product['quantity'], 'sku_id' => $product['sku_id'], 'sku_data' => $product['sku_data'], 'comment' => $product['comment']));
                            }
                        }
                    }
                    //获取分销利润
                    if (!empty($financial_record_id) && $cost_total > 0) {
                        $profit = $total - $cost_total;
                        if ($profit > 0) {
                            D('Financial_record')->where(array('pigcms_id' => $financial_record_id))->data(array('profit' => $profit))->save();
                        }
                    }
                }
                //逐级提交订单
                $drp_level = $nowStore['drp_level']; //当前分销等级
                $suppliers = array();
                //排他分销
                $supplier_chain = D('Store_supplier')->where(array('seller_id' => $nowOrder['store_id'], 'type' => 1))->find();
                $supply_chain = $supplier_chain['supply_chain'];
                if (!empty($supplier_chain)) {
                    $suppliers = explode(',', $supply_chain);
                    sort($suppliers);
                    $suppliers = array_reverse($suppliers);
                    array_pop($suppliers);
                    if (!empty($suppliers)) {
                        if ($drp_level > 3) { //超出3级
                            $tmp_suppliers = $suppliers;
                            $suppliers = array();
                            $key = array_search($nowOrder['store_id'], $tmp_suppliers);
                            $suppliers[] = $tmp_suppliers[$key];
                            if (empty($suppliers[$key + 1])) {
                                $suppliers[] = $tmp_suppliers[$key + 1]; //2级
                            }
                            if (empty($suppliers[$key + 2])) {
                                $suppliers[] = $tmp_suppliers[$key + 2]; //1级
                            }
                        }
                        foreach ($suppliers as $i => $supplier) {
                            $fx_order_info = D('Fx_order')->where(array('supplier_id' => $supplier, 'user_order_id' => $nowOrder['order_id']))->find();
                            if (!empty($fx_order_info)) {
                                $tmp_data['trade_no'] = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
                                $tmp_data['total'] = $fx_order_info['cost_total'];
                                $tmp_data['postage'] = $fx_order_info['postage'];
                                $tmp_data['order_id'] = $fx_order_info['fx_order_id'];
                                $tmp_data['supplier_id'] = $supplier;
                                $tmp_data['seller_id'] = $fx_order_info['store_id'];
                                $tmp_data['max_drp_level'] = $max_drp_level;
                                if ($max_drp_level > 3) {
                                    if (count($suppliers) > 1) {
                                        $tmp_data['drp_level'] = (count($suppliers) - 1) - $i;
                                        $tmp_data['drp_multi_level'] = $drp_multi_level;
                                    } else {
                                        $tmp_data['drp_level'] = $drp_level;
                                        $tmp_data['drp_multi_level'] = false;
                                    }
                                }
                                if ((isset($tmp_data['drp_level']) && $tmp_data['drp_level'] > 0) || !isset($tmp_data['drp_level'])) {
                                    pay($tmp_data);
                                }
                            }
                        }
                    }
                }

                if (!empty($wholesale_products) && $drp_level == 0) {
                    foreach ($wholesale_products as $tmp_key => $tmp_wholesale_products) {
                        $keys = explode(',', $tmp_key);
                        $supplier_id = $keys[0];
                        $seller_id   = $keys[1];
                        wholesale_supplier_pay($nowOrder['order_id'], $supplier_id, $seller_id, $tmp_wholesale_products, false);
                    }
                }

                //跳转
                $error_code = 0;
                $error_msg = '订单支付成功';
            } else {
                $error_code = 1006;
                $error_msg = '订单保存失败';
            }
        } else if ($nowOrder['status'] > 1) {
            //跳转
            $error_code = 0;
            $error_msg = '订单支付成功';
        } else {
            $error_code = 1005;
            $error_msg = '订单不存在';
        }

    } else {
        $error_code = 1005;
        $error_msg = '订单不存在';
    }
    echo json_encode(array('error_code' => $error_code, 'error_msg' => $error_msg));
    exit;
}

/**
 * 向批发商品的供货商下单
 * @param $order
 * @param $supplier_id
 * @param $seller_id
 * @param $products
 */
function wholesale_supplier_pay($user_order_id, $supplier_id, $seller_id, $products, $is_seller)
{
    $sub_total = 0;
    $cost_sub_total = 0;
    $quantity = 0;
    $seller = D('Store')->field('uid,name,income')->where(array('store_id' => $seller_id))->find();
    $supplier = D('Store')->field('uid,name,income')->where(array('store_id' => $supplier_id))->find();
    if (!empty($is_seller)) {
        $order = D('Order')->where(array('store_id' => $seller_id, 'user_order_id' => $user_order_id))->find();
    } else {
        $order = D('Order')->where(array('store_id' => $seller_id, 'order_id' => $user_order_id))->find();
    }
    foreach ($products as $key => $product) {
        $properties = getProperty2Str($product['sku_data']);
        if ($properties) {
            $sku = M('Product_sku')->getSku($product['product_id'], $properties);
            $price       = $sku['price'];
            $cost_price  = $sku['wholesale_price'];
            $drp_level_1_cost_price = ($sku['drp_level_1_cost_price'] > 0) ? $sku['drp_level_1_cost_price'] : $price;
        } else {
            $price      = $product['price'];
            $cost_price = $product['wholesale_price'];
            $drp_level_1_cost_price = ($product['drp_level_1_cost_price'] > 0) ? $product['drp_level_1_cost_price'] : $price;
        }

        //单件商品利润
        if ($price - $cost_price > 0) {
            if (!empty($is_seller)) { //分销商店铺卖出
                $pro_profit = $drp_level_1_cost_price - $cost_price;
            } else { //经销商店铺卖出
                $pro_profit = $price - $cost_price;
            }
            //更新单件商品利润
            D('Order_product')->where(array('pigcms_id' => $product['order_product_id']))->data(array('profit' => $pro_profit))->save();
        }

        $products[$key]['cost_price'] = $cost_price;
        $sub_total += ($price * $product['quantity']); //订单商品总金额
        $cost_sub_total += ($cost_price * $product['quantity']); //订单商品成本总金额
        $quantity += $product['quantity']; //订单商品总数量
    }
    //订单运费
    $fx_postages = array();
    if (!empty($order['fx_postage'])) {
        $fx_postages = unserialize($order['fx_postage']);
    }
    $postage = !empty($fx_postages[$supplier_id]) ? $fx_postages[$supplier_id] : 0; //供货商运费
    //订单总金额
    $total = $sub_total + $postage;
    //订单成本总金额
    $cost_total = $cost_sub_total + $postage;
    $fx_order_no = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999); //分销订单号
    $data = array(
        'fx_order_no'      => $fx_order_no,
        'uid'              => $order['uid'],
        'session_id'       => $order['session_id'],
        'order_id'         => $order['order_id'],
        'order_no'         => $order['order_no'],
        'fx_trade_no'      => date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999),
        'supplier_id'      => $supplier_id,
        'store_id'         => $seller_id,
        'quantity'         => $quantity,
        'sub_total'        => $sub_total,
        'cost_sub_total'   => $cost_sub_total,
        'postage'          => $postage, //分销订单运费
        'total'            => $total,
        'cost_total'       => $cost_total,
        'delivery_user'    => $order['address_user'],
        'delivery_tel'     => $order['address_tel'],
        'delivery_address' => $order['address'],
        'add_time'         => time(),
        'user_order_id'    => $user_order_id,
        'fx_postage'       => $order['fx_postage'],
        'paid_time'        => time(),
        'status'           => 2 //已付款
    );
    if ($fx_order_id = M('Fx_order')->add($data)) { //添加分销商订单
        M('Order')->setFxOrder($order['store_id'], $order['order_id']);
        foreach ($products as $product) {
            M('Fx_order_product')->add(
                array(
                    'fx_order_id'       => $fx_order_id,
                    'product_id'        => $product['product_id'],
                    'source_product_id' => $product['wholesale_product_id'],
                    'price'             => $product['price'],
                    'cost_price'        => $product['cost_price'],
                    'quantity'          => $product['quantity'],
                    'sku_id'            => $product['sku_id'],
                    'sku_data'          => $product['sku_data'],
                    'comment'           => $product['comment'])
            );
        }

        //获取批发利润(经销商)
        if (($total - $cost_total > 0)) {
            $profit = $total - $cost_total;
            //分销商利润
            $seller_profit = D('Financial_record')->where(array('user_order_id' => $user_order_id, 'profit' => array('>', 0), 'store_id' => array('!=', $seller_id)))->sum('profit');
            //减分销商利润
            $profit -= $seller_profit;
            if ($profit > 0) {
                D('Financial_record')->where(array('user_order_id' => $user_order_id, 'store_id' => $seller_id, 'income' => array('>', 0)))->data(array('profit' => $profit))->save();
            }
        }

        if (M('Store')->setUnBalanceInc($supplier_id, $cost_total) && M('Store')->setIncomeInc($supplier_id, $cost_total)) {
            $fx_order_info = M('Fx_order')->getOrder($seller_id, $fx_order_id); //分销订单详细
            $order_id = $fx_order_info['order_id']; //主订单ID
            $order_info = D('Order')->where(array('order_id' => $order_id))->find();
            $order_trade_no = $order_info['trade_no']; //主订单交易号
            unset($order_info['order_id']);
            $order_info['order_no']       = date('YmdHis', time()) . mt_rand(100000, 999999);
            $order_info['store_id']       = $data['supplier_id'];
            $order_info['trade_no']       = date('YmdHis', time()) . mt_rand(100000, 999999);
            $order_info['third_id']       = '';
            $order_info['uid']            = $seller['uid']; //下单用户（分销商）
            $order_info['session_id']     = '';
            $order_info['postage']        = $fx_order_info['postage'];
            $order_info['sub_total']      = $fx_order_info['cost_sub_total'];
            $order_info['total']          = $fx_order_info['cost_total'];
            $order_info['status']         = 2; //未发货
            $order_info['pro_count']      = 0; //商品种类数量
            $order_info['pro_num']        = $fx_order_info['quantity']; //商品件数
            $order_info['payment_method'] = 'balance';
            $order_info['type']           = 5; //批发订单
            $order_info['add_time']       = time();
            $order_info['paid_time']      = time();
            $order_info['sent_time']      = 0;
            $order_info['cancel_time']    = 0;
            $order_info['complate_time']  = 0;
            $order_info['refund_time']    = 0;
            $order_info['star']           = 0;
            $order_info['pay_money']      = $fx_order_info['cost_total'];
            $order_info['cancel_method']  = 0;
            $order_info['float_amount']   = 0;
            $order_info['is_fx']          = 0;
            $order_info['fx_order_id']    = $fx_order_id; //关联分销商订单id（fx_order）
            $order_info['user_order_id']  = $fx_order_info['user_order_id'];
            $order_info['suppliers']      = 0;
            $order_info['fx_postage']     = '';
            if ($order_id = M('Order')->add($order_info)) { //向供货商提交一个新订单
                foreach ($products as $product) {
                    $properties = getProperty2Str($product['sku_data']);
                    if ($properties) {
                        $sku = M('Product_sku')->getSku($product['wholesale_product_id'], $properties);
                        $sku_id = $sku['sku_id'];
                    } else {
                        $sku_id = 0;
                    }
                    $data = array(
                        'order_id'             => $order_id,
                        'product_id'           => $product['wholesale_product_id'],
                        'sku_id'               => $sku_id,
                        'sku_data'             => $product['sku_data'],
                        'pro_num'              => $product['quantity'],
                        'pro_price'            => $product['cost_price'],
                        'pro_weight'           => $product['pro_weight'],
                        'comment'              => $product['comment'],
                        'is_packaged'          => 0,
                        'in_package_status'    => 0,
                        'is_fx'                => 0,
                        'supplier_id'          => 0,
                        'original_product_id'  => 0,
                        'user_order_id'        => $product['user_order_id'],
                        'is_present'           => $product['is_present'],
                        'is_comment'           => $product['is_comment'],
                    );
                    M('Order_product')->add($data); //添加新订单商品
                }

                //添加供货商财务记录（收入）
                $data_record = array();
                $data_record['store_id']       = $supplier_id;
                $data_record['order_id']       = $order_id;
                $data_record['order_no']       = $order_info['order_no'];
                $data_record['income']         = $fx_order_info['cost_total'];
                $data_record['type']           = 6; //分销
                $data_record['balance']        = $supplier['income'];
                $data_record['payment_method'] = 'balance';
                $data_record['trade_no']       = $order_info['trade_no'];
                $data_record['add_time']       = time();
                $data_record['status']         = 1;
                $data_record['user_order_id']  = $order_info['user_order_id'];
                $financial_record_id = D('Financial_record')->data($data_record)->add();
                if (M('Store')->setUnBalanceDec($seller_id, $fx_order_info['cost_total']) && M('Store')->setIncomeDec($seller_id, $fx_order_info['cost_total'])) {
                    //添加分销商财务记录（支出）
                    $order_no = $order_info['order_no'];
                    $data_record = array();
                    $data_record['store_id']       = $seller_id;
                    $data_record['order_id']       = $order['order_id'];
                    $data_record['order_no']       = $order_no;
                    $data_record['income']         = (0 - $fx_order_info['cost_total']);
                    $data_record['type']           = 6; //分销
                    $data_record['balance']        = $seller['income'];
                    $data_record['payment_method'] = 'balance';
                    $data_record['trade_no']       = $order_trade_no;
                    $data_record['add_time']       = time();
                    $data_record['status']         = 1;
                    $data_record['user_order_id']  = $order_info['user_order_id'];
                    D('Financial_record')->data($data_record)->add();
                }
            }
        }
    }
}


function pay($data)
{
    $order            = M('Order');
    $order_product    = M('Order_product');
    $fx_order         = M('Fx_order');
    $fx_order_product = M('Fx_order_product');
    $store            = M('Store');
    $financial_record = M('Financial_record');
    $store_supplier   = M('Store_supplier');
    $product_model    = M('Product');
    $product_sku      = M('Product_sku');

    $wholesale_products = array();
    $total            = $data['total']; //付款总金额
    $drp_level        = isset($data['drp_level']) ? $data['drp_level'] : 0; //分销商级别
    $drp_multi_level  = isset($data['drp_multi_level']) ? $data['drp_multi_level'] : false; //是否为多级分销
    $max_drp_level    = isset($data['max_drp_level']) ? $data['max_drp_level'] : 0; //当前最大分销级别
    //付款给供货商
    $fx_order_id      = explode(',', $data['order_id']); //合并支付会出现多个订单ID
    $supplier         = $store->getStore($data['supplier_id']); //供货商
    //如果store_supplier中的seller_id字段值中有当前供货商并且type分销类型为1，则表示当前供货商同时也是分销商，则为其供货商添加分销订单
    $seller_info      = $store_supplier->getSeller(array('seller_id' => $data['supplier_id'], 'type' => 1));
    if (!empty($seller_info)) {
        $is_supplier  = false;
    } else {
        $is_supplier  = true; //只是供货商
    }
    $seller = $store->getStore($data['seller_id']); //分销商
    if (empty($drp_level)) {
        $drp_level = $seller['drp_level'];
        $drp_level--;
    }
    if ($total > 0) {
        //供货商不可用余额和收入加商品成本
        if ($store->setUnBalanceInc($data['supplier_id'], $total) && $store->setIncomeInc($data['supplier_id'], $total)) {
            foreach ($fx_order_id as $id) {
                //修改分销订单状态为等待供货商发货并且关联供货商订单id
                $fx_order->edit(array('fx_order_id' => $id), array('status' => 2, 'paid_time' => time()));
                $fx_order_info  = $fx_order->getOrder($data['seller_id'], $id); //分销订单详细
                $order_id       = $fx_order_info['order_id']; //主订单ID
                //主订单分销商品
                $fx_products    = $order_product->getFxProducts($order_id, $id, $is_supplier);
                $order_info     = $order->getOrder($data['seller_id'], $order_id);
                $user_order_id  = $fx_order_info['user_order_id'];
                $order_trade_no = $order_info['trade_no']; //主订单交易号
                $order_no       = date('YmdHis', time()) . mt_rand(100000, 999999);
                unset($order_info['order_id']);
                $order_info['order_no']       = $order_no;
                $order_info['store_id']       = $data['supplier_id'];
                $order_info['trade_no']       = date('YmdHis', time()) . mt_rand(100000, 999999);
                $order_info['third_id']       = '';
                $order_info['uid']            = $seller['uid']; //下单用户（分销商）
                $order_info['session_id']     = '';
                $order_info['postage']        = $fx_order_info['postage'];
                $order_info['sub_total']      = $fx_order_info['cost_sub_total'];
                $order_info['total']          = $fx_order_info['cost_total'];
                $order_info['status']         = 2; //未发货
                $order_info['pro_count']      = 0; //商品种类数量
                $order_info['pro_num']        = $fx_order_info['quantity']; //商品件数
                $order_info['payment_method'] = 'balance';
                $order_info['type']           = 3; //分销订单
                $order_info['add_time']       = time();
                $order_info['paid_time']      = time();
                $order_info['sent_time']      = 0;
                $order_info['cancel_time']    = 0;
                $order_info['complate_time']  = 0;
                $order_info['refund_time']    = 0;
                $order_info['star']           = 0;
                $order_info['pay_money']      = $fx_order_info['cost_total'];
                $order_info['cancel_method']  = 0;
                $order_info['float_amount']   = 0;
                $order_info['is_fx']          = 0;
                $order_info['fx_order_id']    = $id; //关联分销商订单id（fx_order）
                $order_info['user_order_id']  = $fx_order_info['user_order_id'];
                $order_info['suppliers']      = $fx_order_info['suppliers'];
                if ($new_order_id = $order->add($order_info)) { //向供货商提交一个新订单
                    $suppliers = array();
                    $supplier_products = array();
                    foreach ($fx_products as $key => $fx_product) {

                        $tmp_product = $product_model->get(array('product_id' => $fx_product['product_id']), 'store_id,wholesale_product_id,wholesale_price,supplier_id,unified_price_setting,drp_level_1_cost_price,drp_level_2_cost_price,drp_level_3_cost_price,drp_level_1_price,drp_level_2_price,drp_level_3_price,cost_price');

                        unset($fx_product['pigcms_id']);
                        $properties = getProperty2Str($fx_product['sku_data']); //商品属性字符串
                        if (!empty($properties)) { //有属性
                            $sku = $product_sku->getSku($fx_product['product_id'], $properties);
                            $fx_product['sku_id']        = $sku['sku_id'];
                        } else { //无属性
                            $fx_product['sku_id']        = 0;
                        }
                        $fx_product['pro_price']         = $fx_product['price'];
                        $fx_product['order_id']          = $new_order_id;
                        $fx_product['is_packaged']       = 0;
                        $fx_product['in_package_status'] = 0;
                        $fx_product['profit']            = 0;

                        if ($tmp_product['store_id'] != $data['supplier_id']) { //分销/批发商品
                            $fx_product['supplier_id']       = $supplier['drp_supplier_id'];
                            $fx_product['is_fx']             = 1;
                            if ($drp_level == 1 && $max_drp_level > 3) {
                                $fx_product['supplier_id']       = $tmp_product['store_id'];
                            }
                        } else {
                            $fx_product['supplier_id']       = 0;
                            $fx_product['is_fx']             = 0; //自营商品
                        }
                        unset($fx_product['price']);
                        $order_product_id = $order_product->add($fx_product); //添加新订单商品


                        $fx_products[$key]['unified_price_setting']  = $tmp_product['unified_price_setting'];
                        $fx_products[$key]['drp_level_1_cost_price'] = $tmp_product['drp_level_1_cost_price'];
                        $fx_products[$key]['drp_level_2_cost_price'] = $tmp_product['drp_level_2_cost_price'];
                        $fx_products[$key]['drp_level_3_cost_price'] = $tmp_product['drp_level_3_cost_price'];
                        $fx_products[$key]['drp_level_1_price']      = $tmp_product['drp_level_1_price'];
                        $fx_products[$key]['drp_level_2_price']      = $tmp_product['drp_level_2_price'];
                        $fx_products[$key]['drp_level_3_price']      = $tmp_product['drp_level_3_price'];
                        $fx_products[$key]['cost_price']             = $tmp_product['cost_price'];
                        $fx_products[$key]['supplier_id']            = !empty($tmp_product['supplier_id']) ? $tmp_product['supplier_id'] : $tmp_product['store_id'];
                        $fx_products[$key]['source_product_id']      = $fx_product['product_id'];
                        $fx_products[$key]['wholesale_product_id']   = $tmp_product['wholesale_product_id'];
                        $fx_products[$key]['wholesale_price']        = $tmp_product['wholesale_price'];
                        $fx_products[$key]['order_product_id']       = $order_product_id;
                        if (!empty($tmp_product['wholesale_product_id'])) {
                            $fx_product[$key]['wholesale_supplier_id'] = $tmp_product['supplier_id'];
                            $wholesale_supplier_id                     = $tmp_product['supplier_id'];
                            $fx_products[$key]['store_id']             = $tmp_product['store_id'];
                        }
                        //自营商品或批发商品
                        if (!empty($tmp_product) && (empty($tmp_product['supplier_id']) || !empty($tmp_product['wholesale_product_id'])) && $data['supplier_id'] == $tmp_product['store_id']) {
                            unset($fx_products[$key]);
                            //批发的商品
                            if (!empty($wholesale_supplier_id)) {
                                $wholesale_products[$wholesale_supplier_id . ',' . $tmp_product['store_id']][] = array(
                                    'order_product_id'       => $order_product_id,
                                    'product_id'             => $fx_product['product_id'],
                                    'sku_id'                 => $fx_product['sku_id'],
                                    'wholesale_product_id'   => $tmp_product['wholesale_product_id'],
                                    'wholesale_price'        => $tmp_product['wholesale_price'],
                                    'sku_data'               => $fx_product['sku_data'],
                                    'quantity'               => $fx_product['pro_num'],
                                    'comment'                => $fx_product['comment'],
                                    'price'                  => $fx_product['pro_price'],
                                    'is_comment'             => $fx_product['is_comment'],
                                    'is_present'             => $fx_product['is_present'],
                                    'user_order_id'          => $fx_product['user_order_id'],
                                    'return_status'          => $fx_product['return_status'],
                                    'cost_price'             => $tmp_product['cost_price'],
                                    'drp_level_1_cost_price' => $tmp_product['drp_level_1_cost_price'],
                                );
                            }
                        }
                        $suppliers[] = $tmp_product['store_id'];
                    }
                    $suppliers =  array_unique($suppliers);
                    //添加供货商财务记录（收入）
                    $data_record = array();
                    $data_record['store_id']       = $data['supplier_id'];
                    $data_record['order_id']       = $new_order_id;
                    $data_record['order_no']       = $order_info['order_no'];
                    $data_record['income']         = $fx_order_info['cost_total'];
                    $data_record['type']           = 5; //分销
                    $data_record['balance']        = $supplier['income'];
                    $data_record['payment_method'] = 'balance';
                    $data_record['trade_no']       = $order_info['trade_no'];
                    $data_record['add_time']       = time();
                    $data_record['status']         = 1;
                    $data_record['user_order_id']  = $order_info['user_order_id'];
                    $financial_record_id = D('Financial_record')->data($data_record)->add();

                    //判断供货商，如果上级供货商是分销商，添加分销订单
                    if (!empty($seller_info) && !empty($suppliers)) {
                        foreach ($suppliers as $supplier_id) {
                            $cost_sub_total  = 0;
                            $sub_total       = 0;
                            $tmp_fx_products = array();
                            foreach ($fx_products as $k => $fx_product) {
                                $properties = getProperty2Str($fx_product['sku_data']); //商品属性字符串
                                $tmp_fx_product = $fx_product;
                                if (!empty($properties)) { //有属性
                                    $sku = $product_sku->getSku($fx_product['product_id'], $properties);

                                    if ($drp_multi_level || !empty($fx_product['unified_price_setting'])) {
                                        $cost_price = ($sku['drp_level_' . $drp_level . '_cost_price'] > 0) ? $sku['drp_level_' . $drp_level . '_cost_price'] : $sku['price']; //分销来源商品的成本价格
                                        if (!empty($max_drp_level) && $drp_level < $max_drp_level) {
                                            $drp_level_price          = $sku['drp_level_' . $drp_level . '_price'];
                                            $max_drp_level_price      = $sku['drp_level_' . $max_drp_level . '_price'];
                                            $drp_level_cost_price     = $sku['drp_level_' . $drp_level . '_cost_price'];
                                            $max_drp_level_cost_price = $sku['drp_level_' . $max_drp_level . '_cost_price'];
                                            if ($drp_level < 3 && $drp_level_cost_price != $max_drp_level_cost_price && ($max_drp_level_cost_price - $drp_level_cost_price) > 0) {
                                                $price = ($sku['drp_level_' . ($drp_level + 1) . '_cost_price'] > 0) ? $sku['drp_level_' . ($drp_level + 1) . '_cost_price'] : $sku['price'];
                                            } else {
                                                $price = ($sku['drp_level_' . ($drp_level + 1) . '_cost_price'] > 0) ? $sku['drp_level_' . ($drp_level + 1) . '_cost_price'] : $sku['price'] ;
                                            }
                                        } else {
                                            $price = ($sku['drp_level_' . ($drp_level + 1) . '_cost_price'] > 0) ? $sku['drp_level_' . ($drp_level + 1) . '_cost_price'] : $sku['price'];
                                        }
                                    } else {
                                        $cost_price = ($sku['cost_price'] > 0) ? $sku['cost_price'] : $sku['price']; //分销来源商品的成本价格
                                        $price      = $fx_product['pro_price'];
                                    }
                                    $sku_id = $sku['sku_id'];
                                } else { //无属性
                                    if ($drp_multi_level || !empty($fx_product['unified_price_setting'])) {
                                        $cost_price = ($fx_product['drp_level_' . $drp_level . '_cost_price'] > 0) ? $fx_product['drp_level_' . $drp_level . '_cost_price'] : $fx_product['pro_price']; //分销来源商品的成本价格
                                        if (!empty($max_drp_level) && $drp_level < $max_drp_level) {
                                            $drp_level_price          = $fx_product['drp_level_' . $drp_level . '_price'];
                                            $max_drp_level_price      = $fx_product['drp_level_' . $max_drp_level . '_price'];
                                            $drp_level_cost_price     = $fx_product['drp_level_' . $drp_level . '_cost_price'];
                                            $max_drp_level_cost_price = $fx_product['drp_level_' . $max_drp_level . '_cost_price'];
                                            if ($drp_level < 3 && $drp_level_cost_price != $max_drp_level_cost_price && ($max_drp_level_cost_price - $drp_level_cost_price) > 0) {
                                                $price = ($fx_product['drp_level_' . ($drp_level + 1) . '_cost_price'] > 0) ? $fx_product['drp_level_' . ($drp_level + 1) . '_cost_price'] : $fx_product['price'];
                                            } else {
                                                $price = ($fx_product['drp_level_' . ($drp_level + 1) . '_cost_price'] > 0) ? $fx_product['drp_level_' . ($drp_level + 1) . '_cost_price'] : $fx_product['pro_price'];
                                            }
                                        } else {
                                            $price = ($fx_product['drp_level_' . ($drp_level + 1) . '_cost_price'] > 0) ? $fx_product['drp_level_' . ($drp_level + 1) . '_cost_price'] : $sku['price'];
                                        }
                                    } else {
                                        $cost_price = ($fx_product['cost_price'] > 0) ? $fx_product['cost_price'] : $fx_product['pro_price']; //分销来源商品的成本价格
                                        $price      = $fx_product['pro_price'];
                                    }
                                    $sku_id = 0;
                                }

                                if ($price - $cost_price > 0) {
                                    //更新单件商品利润
                                    $pro_profit = $price - $cost_price;
                                    D('Order_product')->where(array('pigcms_id' => $fx_product['order_product_id']))->data(array('profit' => $pro_profit))->save();
                                }

                                $cost_sub_total += $cost_price * $fx_product['pro_num'];
                                $sub_total += $price * $fx_product['pro_num'];
                                $tmp_fx_product['product_id']          = $fx_product['product_id'];
                                $tmp_fx_product['price']               = $price;
                                $tmp_fx_product['cost_price']          = $cost_price;
                                $tmp_fx_product['sku_id']              = $sku_id;
                                $tmp_fx_product['original_product_id'] = $fx_product['product_id'];
                                $tmp_fx_products[]                     = $tmp_fx_product;
                                $fx_products[$k]['cost_price']         = $cost_price;
                            }
                            if (!empty($tmp_fx_products)) {
                                $fx_order_no = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999); //分销订单号
                                //运费
                                $fx_postages = array();
                                if (!empty($order_info['fx_postage'])) {
                                    $fx_postages = unserialize($order_info['fx_postage']);
                                }
                                $postage = !empty($order_info['postage']) ? $order_info['postage'] : 0;

                                $data2 = array(
                                    'fx_order_no'      => $fx_order_no,
                                    'uid'              => $order_info['uid'],
                                    'order_id'         => $new_order_id,
                                    'order_no'         => $order_info['order_no'],
                                    'fx_trade_no'      => $data['trade_no'],
                                    'supplier_id'      => ($drp_level == 1 && $max_drp_level > 3) ? $supplier_id : $seller_info['supplier_id'],
                                    'store_id'         => $data['supplier_id'],
                                    'quantity'         => $fx_order_info['quantity'],
                                    'sub_total'        => $sub_total,
                                    'cost_sub_total'   => $cost_sub_total,
                                    'postage'          => $postage,
                                    'total'            => ($sub_total + $postage),
                                    'cost_total'       => ($cost_sub_total + $postage),
                                    'delivery_user'    => $order_info['address_user'],
                                    'delivery_tel'     => $order_info['address_tel'],
                                    'delivery_address' => $order_info['address'],
                                    'add_time'         => time(),
                                    'user_order_id'    => $order_info['user_order_id'],
                                    'fx_postage'       => $order_info['fx_postage'],
                                    'suppliers'        => $order_info['suppliers']
                                );
                                if ($fx_order_id = $fx_order->add($data2)) { //添加分销商订单
                                    foreach ($tmp_fx_products as $tmp_fx_product) {
                                        if (!empty($tmp_fx_product['product_id'])) {
                                            $fx_order_product->add(array('fx_order_id' => $fx_order_id, 'product_id' => $tmp_fx_product['product_id'], 'source_product_id' => $tmp_fx_product['source_product_id'], 'price' => $tmp_fx_product['price'], 'cost_price' => $tmp_fx_product['cost_price'], 'quantity' => $tmp_fx_product['pro_num'], 'sku_id' => $tmp_fx_product['sku_id'], 'sku_data' => $tmp_fx_product['sku_data'], 'comment' => $tmp_fx_product['comment']));
                                        }
                                    }
                                }
                                //获取分销利润
                                if (!empty($financial_record_id) && !empty($data2['cost_total'])) {
                                    $profit = $data2['total'] - $data2['cost_total'];
                                    if ($profit > 0) {
                                        D('Financial_record')->where(array('pigcms_id' => $financial_record_id))->data(array('profit' => $profit))->save();
                                    }
                                }
                            }

                            if ($store->setUnBalanceDec($data['seller_id'], $fx_order_info['cost_total']) && $store->setIncomeDec($data['seller_id'], $fx_order_info['cost_total'])) {
                                //添加分销商财务记录（支出）
                                $order_no = $order_info['order_no'];
                                $data_record = array();
                                $data_record['store_id']       = $data['seller_id'];
                                $data_record['order_id']       = $order_id;
                                $data_record['order_no']       = $order_no;
                                $data_record['income']         = (0 - $fx_order_info['cost_total']);
                                $data_record['type']           = 5; //分销
                                $data_record['balance']        = $seller['income'];
                                $data_record['payment_method'] = 'balance';
                                $data_record['trade_no']       = $order_trade_no;
                                $data_record['add_time']       = time();
                                $data_record['status']         = 1;
                                $data_record['user_order_id']  = $order_info['user_order_id'];
                                D('Financial_record')->data($data_record)->add();
                            }

                            //多级分销，向上两级后直接向供货商下单
                            if ($drp_level == 1 && $max_drp_level > 3) {
                                $current_supplier = $store->getStore($supplier_id, 'income'); //供货商

                                $fx_order_info  = $fx_order->getOrder($data['supplier_id'], $fx_order_id); //分销订单详细
                                $order_id       = $fx_order_info['order_id']; //主订单ID
                                $order_info     = $order->getOrder($data['supplier_id'], $order_id);
                                unset($order_info['order_id']);
                                $order_info['order_no']       = date('YmdHis', time()) . mt_rand(100000, 999999);
                                $order_info['store_id']       = $supplier_id;
                                $order_info['trade_no']       = date('YmdHis', time()) . mt_rand(100000, 999999);
                                $order_info['third_id']       = '';
                                $order_info['uid']            = $supplier['uid']; //下单用户（分销商）
                                $order_info['session_id']     = '';
                                $order_info['postage']        = $fx_order_info['postage'];
                                $order_info['sub_total']      = $fx_order_info['cost_sub_total'];
                                $order_info['total']          = $fx_order_info['cost_total'];
                                $order_info['status']         = 2; //未发货
                                $order_info['pro_count']      = 0; //商品种类数量
                                $order_info['pro_num']        = $fx_order_info['quantity']; //商品件数
                                $order_info['payment_method'] = 'balance';
                                $order_info['type']           = 3; //分销订单
                                $order_info['add_time']       = time();
                                $order_info['paid_time']      = time();
                                $order_info['sent_time']      = 0;
                                $order_info['cancel_time']    = 0;
                                $order_info['complate_time']  = 0;
                                $order_info['refund_time']    = 0;
                                $order_info['star']           = 0;
                                $order_info['pay_money']      = $fx_order_info['cost_total'];
                                $order_info['cancel_method']  = 0;
                                $order_info['float_amount']   = 0;
                                $order_info['is_fx']          = 0;
                                $order_info['fx_order_id']    = $fx_order_id; //关联分销商订单id（fx_order）
                                $order_info['user_order_id']  = $fx_order_info['user_order_id'];
                                $order_info['suppliers']      = $fx_order_info['suppliers'];
                                if ($new_order_id = $order->add($order_info)) { //向供货商提交一个新订单

                                    $fx_order->edit(array('fx_order_id' => $fx_order_id), array('status' => 2, 'paid_time' => time(), 'supplier_id' => $supplier_id));

                                    foreach ($fx_products as $fx_product) {
                                        $fx_product['pro_price']         = $fx_product['cost_price'];
                                        $fx_product['order_id']          = $new_order_id;
                                        $fx_product['is_packaged']       = 0;
                                        $fx_product['in_package_status'] = 0;
                                        if (empty($fx_product['wholesale_product_id'])) {
                                            $fx_product['is_fx']       = 0;
                                            $fx_product['supplier_id'] = 0;
                                            unset($fx_product['wholesale_product_id']);
                                        } else {
                                            $fx_product['is_fx']       = 0;
                                            $fx_product['original_product_id'] = $fx_product['wholesale_product_id'];
                                        }

                                        $wholesale_product_id = !empty($fx_product['wholesale_product_id']) ? $fx_product['wholesale_product_id'] : 0;
                                        $store_id = $fx_product['store_id'];
                                        $cost_price = $fx_product['cost_price'];
                                        $drp_level_1_cost_price = $fx_product['drp_level_1_cost_price'];
                                        $wholesale_price = $fx_product['wholesale_price'];
                                        unset($fx_product['store_id']);
                                        unset($fx_product['pigcms_id']);
                                        unset($fx_product['order_product_id']);
                                        unset($fx_product['price']);
                                        unset($fx_product['profit']);
                                        unset($fx_product['unified_price_setting']);
                                        unset($fx_product['source_product_id']);
                                        unset($fx_product['wholesale_product_id']);
                                        unset($fx_product['wholesale_price']);
                                        unset($fx_product['cost_price']);
                                        unset($fx_product['drp_level_1_cost_price']);
                                        unset($fx_product['drp_level_2_cost_price']);
                                        unset($fx_product['drp_level_3_cost_price']);
                                        unset($fx_product['drp_level_1_price']);
                                        unset($fx_product['drp_level_2_price']);
                                        unset($fx_product['drp_level_3_price']);
                                        if (!empty($fx_product['wholesale_supplier_id'])) {
                                            $wholesale_supplier_id = $fx_product['wholesale_supplier_id'];
                                            unset($fx_product['wholesale_supplier_id']);
                                        }
                                        $order_product_id = $order_product->add($fx_product); //添加新订单商品

                                        //批发的商品
                                        if (!empty($wholesale_supplier_id)) {
                                            $wholesale_products[$wholesale_supplier_id . ',' . $store_id][] = array(
                                                'order_product_id'       => $order_product_id,
                                                'product_id'             => $fx_product['product_id'],
                                                'wholesale_product_id'   => $wholesale_product_id,
                                                'wholesale_price'        => $wholesale_price,
                                                'sku_id'                 => $fx_product['sku_id'],
                                                'sku_data'               => $fx_product['sku_data'],
                                                'quantity'               => $fx_product['pro_num'],
                                                'comment'                => $fx_product['comment'],
                                                'price'                  => $fx_product['pro_price'],
                                                'is_comment'             => $fx_product['is_comment'],
                                                'is_present'             => $fx_product['is_present'],
                                                'user_order_id'          => $fx_product['user_order_id'],
                                                'return_status'          => $fx_product['return_status'],
                                                'cost_price'             => $cost_price,
                                                'drp_level_1_cost_price' => $drp_level_1_cost_price,
                                            );
                                        }
                                    }
                                    if ($store->setIncomeInc($supplier_id, $fx_order_info['cost_total']) && $store->setUnBalanceInc($supplier_id, $fx_order_info['cost_total'])) {
                                        //添加供货商财务记录（收入）
                                        $data_record = array();
                                        $data_record['store_id']       = $supplier_id;
                                        $data_record['order_id']       = $new_order_id;
                                        $data_record['order_no']       = $order_info['order_no'];
                                        $data_record['income']         = $fx_order_info['cost_total'];
                                        $data_record['type']           = 5; //分销
                                        $data_record['balance']        = $current_supplier['income'];
                                        $data_record['payment_method'] = 'balance';
                                        $data_record['trade_no']       = $order_info['trade_no'];
                                        $data_record['add_time']       = time();
                                        $data_record['status']         = 1;
                                        $data_record['user_order_id']  = $order_info['user_order_id'];
                                        $financial_record_id = D('Financial_record')->data($data_record)->add();

                                        if ($financial_record_id && $fx_order_info['cost_total'] > 0) { //供货商成本
                                            D('Financial_record')->where(array('pigcms_id' => $financial_record_id))->data(array('profit' => $fx_order_info['cost_total']))->save();
                                        }

                                        if ($store->setUnBalanceDec($data['supplier_id'], $fx_order_info['cost_total']) && $store->setIncomeDec($data['supplier_id'], $fx_order_info['cost_total'])) {
                                            //添加分销商财务记录（支出）
                                            $data_record = array();
                                            $data_record['store_id']         = $data['supplier_id'];
                                            $data_record['order_id']         = $order_id;
                                            $data_record['order_no']         = $order_no;
                                            $data_record['income']           = (0 - $fx_order_info['cost_total']);
                                            $data_record['type']             = 5; //分销
                                            $data_record['balance']          = $supplier['income'];
                                            $data_record['payment_method']   = 'balance';
                                            $data_record['trade_no']         = $order_trade_no;
                                            $data_record['add_time']         = time();
                                            $data_record['status']           = 1;
                                            $data_record['user_order_id']    = $fx_order_info['user_order_id'];
                                            D('Financial_record')->data($data_record)->add();
                                        }
                                    }
                                }
                            }
                        }
                    } else if ($max_drp_level <= 3) {
                        if ($store->setUnBalanceDec($data['seller_id'], $fx_order_info['cost_total']) && $store->setIncomeDec($data['seller_id'], $fx_order_info['cost_total'])) {
                            //添加分销商财务记录（支出）
                            $order_no = $order_info['order_no'];
                            $data_record = array();
                            $data_record['store_id']       = $data['seller_id'];
                            $data_record['order_id']       = $order_id;
                            $data_record['order_no']       = $order_no;
                            $data_record['income']         = (0 - $fx_order_info['cost_total']);
                            $data_record['type']           = 5; //分销
                            $data_record['balance']        = $seller['income'];
                            $data_record['payment_method'] = 'balance';
                            $data_record['trade_no']       = $order_trade_no;
                            $data_record['add_time']       = time();
                            $data_record['status']         = 1;
                            $data_record['user_order_id']  = $order_info['user_order_id'];
                            D('Financial_record')->data($data_record)->add();
                        }
                    }
                    //向批发商品的供货商下单
                    if (!empty($wholesale_products)) {
                        foreach ($wholesale_products as $tmp_key => $tmp_wholesale_products) {
                            $keys = explode(',', $tmp_key);
                            $supplier_id = $keys[0];
                            $seller_id   = $keys[1];
                            wholesale_supplier_pay($user_order_id, $supplier_id, $seller_id, $tmp_wholesale_products, true);
                        }
                    }
                }
            }
            return array('err_code' => 0, 'err_msg' => '付款成功，等待供货商发货');
        } else {
            return array('err_code' => 1004, 'err_msg' => '付款失败');
        }
    } else {
        return array('err_code' => 1003, 'err_msg' => '付款金额无效');
    }
}


?>