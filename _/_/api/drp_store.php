<?php
/**
 *  分销店铺对帐
 */
define('PIGCMS_PATH', dirname(__FILE__).'/../');
require_once PIGCMS_PATH.'source/init.php';
require_once 'functions.php';

if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
    $order = M('Order');
    $order_product = M('Order_product');
    $user = M('User');
    $now = time();
    $timestamp = $_POST['request_time'];
    $sign_key = $_POST['sign_key'];
    unset($_POST['request_time']);
    unset($_POST['sign_key']);
    //$_POST['salt'] = SIGN_SALT;
	$_POST['salt'] = 'pigcms';
    /*if (!_checkSign($sign_key, $_POST)) {
        $error_code = 1003;
        $error_msg = '签名无效';
        $return_url = '';
    } else {*/
        $site_url = trim($_POST['site_url']);
        //处理同一域名是否有www
        if (stripos('://wwww.', $site_url) !== false) {
            $site_url2 = str_replace('://wwww.', '', $site_url);
        } else if (stripos('://wwww.', $site_url) === false) {
            $site_url2 = str_replace('://', '://www.', $site_url);
        }
        
        //$suppliers=$_POST['suppliers']
        //$store_id = $_POST['store_id'];
        //$where['store_id'] =$store_id;
        //$checked = $_POST['check_status'];
        $where['store_id'] =trim($_POST['store_id']);
        //$suppliers = trim($_POST['suppliers']);
        //$checked = 'in (1,2)';
        $store_info = D('Store')->field('store_id,name,linkman,tel,date_added')->where($where)->find();
		
		$supplier = D('Store_supplier')->where(array('seller_id'=>$_POST['store_id']))->find();
	
		if($supplier['supply_chain']){
			$supplier = explode(',', $supplier['supply_chain']);
		}
		$suppliers = $supplier[1];
		
        $store_info['date_added']=$store_info['date_added']? date('Y-m-d H:i:s',$store_info['date_added']) : 0;
        
        
        //分销对帐start
        $store_id = $store_info['store_id'];

		//$sql = "SELECT COUNT(o1.order_id) AS order_count FROM " . option('system.DB_PREFIX') . "order o1 WHERE o1.suppliers = '" . $suppliers . "' AND o1.status = 4 AND o1.is_fx = 0 AND o1.type = 3 AND (o1.user_order_id in (SELECT order_id FROM " . option('system.DB_PREFIX') . "order o2 WHERE o2.order_id = o1.user_order_id AND o2.is_check in (1,2) AND o2.status = 4 AND o1.store_id != o2.store_id) OR o1.user_order_id in (SELECT user_order_id FROM " . option('system.DB_PREFIX') . "order o2 WHERE o2.user_order_id = o1.user_order_id AND o2.is_check in (1,2) AND o2.status = 4 AND o1.store_id != o2.store_id AND o2.order_id < o1.order_id)) ORDER BY order_id DESC";
		
        //$sql = "SELECT COUNT(o1.order_id) AS order_count FROM " . option('system.DB_PREFIX') . "order o1 WHERE o1.suppliers = '" . $suppliers . "'AND store_id !='". $suppliers . "' AND o1.status = 4 AND o1.is_fx = 0 AND o1.type = 3 AND (o1.user_order_id in (SELECT order_id FROM " . option('system.DB_PREFIX') . "order o2 WHERE o2.order_id = o1.user_order_id AND o2.is_check in (1,2) AND o2.status = 4 AND o1.store_id != o2.store_id) OR o1.user_order_id in (SELECT user_order_id FROM " . option('system.DB_PREFIX') . "order o2 WHERE o2.user_order_id = o1.user_order_id AND o2.is_check in (1,2) AND o2.status = 4 AND o1.store_id != o2.store_id AND o2.order_id < o1.order_id)) ORDER BY order_id DESC";
		//if($_POST['new_status']){
			$sql = "SELECT COUNT(o1.order_id) AS order_count FROM " . option('system.DB_PREFIX') . "order o1 WHERE o1.store_id = '" . $store_id . "' AND o1.status = 4 AND  o1.type = 3 AND (o1.user_order_id in (SELECT order_id FROM " . option('system.DB_PREFIX') . "order o2 WHERE o2.order_id = o1.user_order_id AND o2.is_check in (1,2) AND o2.status = 4 AND o1.store_id != o2.store_id) OR o1.user_order_id in (SELECT user_order_id FROM " . option('system.DB_PREFIX') . "order o2 WHERE o2.user_order_id = o1.user_order_id AND o2.is_check in (1,2) AND o2.status = 4 AND o1.store_id != o2.store_id AND o2.order_id < o1.order_id)) ORDER BY order_id DESC";
		//}


                $order_count = D('Order')->query($sql);
                if (!empty($order_count)) {
                    $order_count = $order_count[0]['order_count'];
                } else {
                    $order_count = 0;
                }
                
                import('source.class.user_page');
                $page = new Page($order_count, 15);

                $sql = "SELECT * FROM " . option('system.DB_PREFIX') . "order o1 WHERE suppliers = '" . $suppliers . "'AND store_id='".$store_id."' AND status = 4 AND type = 3  AND is_check in(1,2) ORDER BY order_id DESC LIMIT " . ($p ==1 ? $page->firstRow : $p * $page_size) . ',' . $page->listRows;
                $tmp_orders = D('Order')->query($sql);
             foreach ($tmp_orders as &$order) {
                $tmp_order = array();
                if (empty($order['user_order_id'])) {
                    $user_order_id = $order['order_id'];
                    $tmp_order['store_id'] = $order['store_id'];
                } else {
                    $user_order_id = $order['user_order_id'];
                    $tmp_order = D('Order')->field('store_id,order_id,total,payment_method')->where(array('order_id' => $user_order_id))->find();
                    $order['total'] = $tmp_order['total'];
                }

                //$order['original_order_id'] = $user_order_id;
                $order_id = $order['order_id'];


                //主订单商品
                $products = $order_product->getProducts($user_order_id);
                foreach ($products as $key => $product) {

                    //退货商品
                    $return_products = D('Return_product')->field('pro_num')->where(array('order_id' => $user_order_id, 'order_product_id' => $product['pigcms_id']))->select();
                    if (!empty($return_products)) {
                        foreach ($return_products as $return_product) {
                            $products[$key]['return_quantity'] += $return_product['pro_num'];
                        }
                    }
                }
                $order['products'] = $products;

                //分销商
                if ($tmp_order['store_id'] == $store_id) {
                    $order['seller'] = '本店';
                } else {
                    $seller = D('Store')->field('name')->where(array('store_id' => $tmp_order['store_id']))->find();
                    $order['seller'] = $seller['name'];
                }


                //支付方式
                if (!empty($tmp_order['payment_method'])) {
                    $order['payment_method'] = $tmp_order['payment_method'];
                }

                //$sql = "SELECT o.order_id,o.store_id FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = ss.seller_id AND  FIND_IN_SET(" . $suppliers . ", ss.supply_chain) AND o.order_id < '" . $order_id . "' AND (o.order_id = '" . $user_order_id . "' OR o.user_order_id = '" . $user_order_id . "')";
                //}
				
				$sql = "SELECT o.order_id,o.store_id FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = ss.seller_id AND  FIND_IN_SET(" . $suppliers . ", ss.supply_chain) AND o.order_id = '" . $order_id . "' AND (o.order_id = '" . $user_order_id . "' OR o.user_order_id = '" . $user_order_id . "')";
                $fx_orders = D('')->query($sql);

                //待对账金额
                $order['check_amount'] = 0;
                $order['sellers'] = array();
                foreach ($fx_orders as $fx_order) {
                    //分销商分销利润
                    $income = M('Financial_record')->getOrderProfit($fx_order['order_id']);
                    $order['check_amount'] += $income;
                    $seller = D('Store')->field('store_id,name,drp_level')->where(array('store_id' => $fx_order['store_id']))->find();
                    $order['sellers'][] = array(
                        'store_id'     => $seller['store_id'],
                        'name'         => $seller['name'],
                        'check_amount' => $income,
                        'drp_level'    => $seller['drp_level']
                    );
                }
                array_multisort($order['sellers'], SORT_ASC, SORT_NUMERIC);

                
                //$order['check_amount'] = M('Financial_record')->getOrderProfit($order['order_id']);
                $order['check_amount'] = number_format($order['check_amount'], 2, '.', '');
            }
            
            foreach($tmp_orders as $tmp_order){
                $products = $order_product->getProducts($tmp_order['order_id']);
            
            foreach($products as $k=>$v){
                $products[$k]['sku_data']=  unserialize($v['sku_data']);
            }
            
            $tmp_order['products'] = $products;
            if (empty($tmp_order['uid'])) {
                $tmp_order['is_fans'] = false;
                $tmp_order['buyer'] = '';
            } else {
                $tmp_order['is_fans'] = true;
                $user_info = $user->checkUser(array('uid' => $tmp_order['uid']));
                $tmp_order['buyer'] = $user_info['nickname'];
            }
            $is_supplier = false;
            if (!empty($tmp_order['suppliers'])) { //订单供货商
                $suppliers = explode(',', $tmp_order['suppliers']);
                if (in_array($store_info['store_id'], $suppliers)) {
                    $is_supplier = true;
                }
            }
            $tmp_order['is_supplier'] = $is_supplier;
            $has_my_product = false;
            foreach ($products as &$product) {
                $product['image'] = getAttachmentUrl($product['image']);
                    if (empty($product['is_fx'])) {
                        $has_my_product = true;
                    }
                }

                $tmp_order['products'] = $products;
                $tmp_order['has_my_product'] = $has_my_product;
                if (!empty($tmp_order['user_order_id'])) {
                    $order_info = D('Order')->field('store_id')->where(array('order_id' => $tmp_order['user_order_id']))->find();
                    $seller = D('Store')->field('name')->where(array('store_id' => $order_info['store_id']))->find();
                    $tmp_order['seller'] = $seller['name'];
                }

                $tmp_address=unserialize($tmp_order['address']);
                $tmp_order['address']='';
                if(!in_array($tmp_address['province'],array('北京市','天津市','上海市','重庆市'))){
                    $tmp_order['address'] .= $tmp_address['province'];
                }
                $tmp_order['address'] .= $tmp_address['city'].' '.$tmp_address['area'].' '.$tmp_address['address'];
                $tmp_order['add_time'] = $tmp_order['add_time']?date('Y-m-d H:i:s',$tmp_order['add_time']) : 0;
                $tmp_order['paid_time'] = $tmp_order['paid_time']?date('Y-m-d H:i:s',$tmp_order['paid_time']) : 0;
                $tmp_order['sent_time'] = $tmp_order['sent_time']?date('Y-m-d H:i:s',$tmp_order['sent_time']) : 0;
                $tmp_order['delivery_time'] = $tmp_order['delivery_time']?date('Y-m-d H:i:s',$tmp_order['delivery_time']) : 0;
                $tmp_order['cancel_time'] = $tmp_order['cancel_time']?date('Y-m-d H:i:s',$tmp_order['cancel_time']) : 0;
                $tmp_order['complate_time'] = $tmp_order['complate_time']?date('Y-m-d H:i:s',$tmp_order['complate_time']) : 0;
                unset($tmp_order['fx_postage']);
                $orders[] = $tmp_order;
            }
			
			if(!$orders){
				$orders='';
			}

        //分销对帐end
        
        if (!empty($store_info)) {
            $error_code = 0;
            $error_msg = '请求成功';
            $return_url = '';
        } else {
            $stores = '';
            $error_code = 1004;
            $error_msg = '店铺不存在';
            $return_url = '';
        }
    }
/*}else {
    $error_code = 1001;
    $error_msg = '请求失败';
    $return_url = '';
    $stores = '';
}*/

echo json_encode(array('error_code' =>$error_code , 'error_msg' => $error_msg, 'store' => $store_info,'orders'=>$orders,'page_total'=>$order_count));
exit;