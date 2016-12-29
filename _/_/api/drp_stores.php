<?php
/**
 *  店铺对帐
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
        $error_code = 1003;
        $error_msg = '签名无效';
        $return_url = '';
    } else {
        $site_url = trim($_POST['site_url']);
        //处理同一域名是否有www
        if (stripos('://wwww.', $site_url) !== false) {
            $site_url2 = str_replace('://wwww.', '', $site_url);
        } else if (stripos('://wwww.', $site_url) === false) {
            $site_url2 = str_replace('://', '://www.', $site_url);
        }
        $where=array();
        //$where['_string']="token = '" . trim($_POST['token']) . "' AND (source_site_url = '" . $site_url . "' OR source_site_url = '" . $site_url2 . "')";
        $where['store_id']=$_POST['store_id'];
        $store_info = D('Store')->where($where)->field('store_id,name,linkman,tel,date_added,drp_supplier_id')->find();
        $Map['drp_supplier_id']=$store_info['store_id'];
		$Map['status']=1;
        $stores = D('Store')->where($Map)->field('store_id,name,linkman,tel,date_added,drp_supplier_id')->select();
        
        $page_size = !empty($_POST['page_size']) ? intval(trim($_POST['page_size'])) : 20;
        $p = !empty($_POST['p']) ? intval(trim($_POST['p'])) : 0;
        import('source.class.user_page');
        $page = new Page(count($stores), $page_size);
        //$stores = M('Store')->getStoreList($Map,'store_id,name,linkman,tel,date_added','store_id DESC', $p ==1 ? $page->firstRow : $p * $page_size , $page->listRows);
	$sql = "SELECT s.store_id,s.name,s.linkman,s.tel,s.date_added, (SELECT SUM(o.total) FROM " . option('system.DB_PREFIX') . "order o WHERE o.store_id = s.store_id AND o.is_fx = 1 AND o.status in (2,3,4,7)) AS sales FROM " . option('system.DB_PREFIX') . "store s, " . option('system.DB_PREFIX') . "store_supplier ss WHERE s.store_id = ss.seller_id AND FIND_IN_SET(" . $store_info['store_id'] . ", ss.supply_chain) AND s.drp_approve = 1";
	$stores=D('Store')->query($sql);
	
        //未对账金额
        $sql = "SELECT SUM(income) AS income FROM " . option('system.DB_PREFIX') . "financial_record WHERE order_id IN (SELECT order_id FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = ss.seller_id AND ss.type = 1 AND o.status = 4 AND o.is_check = 1 AND FIND_IN_SET(" . $store_info['store_id'] . ", ss.supply_chain)) AND status IN (1,2,3)";

        $incomes = D('Financial_record')->query($sql);
        $uncheck_amount = 0;
        if (!empty($incomes[0]['income'])) {
            $uncheck_amount = $incomes[0]['income'];
        }
        $uncheck_amount = number_format($uncheck_amount, 2, '.', '');

        //已对账金额
        $sql = "SELECT SUM(income) AS income FROM " . option('system.DB_PREFIX') . "financial_record WHERE order_id IN (SELECT order_id FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = ss.seller_id AND ss.type = 1 AND o.status = 4 AND o.is_check = 2 AND FIND_IN_SET(" . $store_info['store_id'] . ", ss.supply_chain)) AND status IN (1,2,3)";
        $incomes = D('Financial_record')->query($sql);
        $check_amount = 0;
        if (!empty($incomes[0]['income'])) {
            $check_amount = $incomes[0]['income'];
        }
        $check_amount = number_format($check_amount, 2, '.', '');
        
        
        //未对账订单
        $sql = "SELECT COUNT(o.order_id) AS orders FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = ss.seller_id AND ss.type = 1 AND o.status = 4 AND o.is_check = 1 AND FIND_IN_SET(" . $store_info['store_id'] . ", ss.supply_chain)";
        $orders = D('Order')->query($sql);
        $order_count = 0;
        if (!empty($orders[0]['orders'])) {
            $order_count = $orders[0]['orders'];
        }
        
        
        //未对帐分销商数量
        $sql = "SELECT o.store_id AS sellers FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = ss.seller_id AND ss.type = 1 AND o.status = 4 AND o.is_check = 1 AND FIND_IN_SET(" . $store_info['store_id'] . ", ss.supply_chain) GROUP BY o.store_id";
            $sellers = D('Order')->query($sql);
            $seller_count = 0;
            if (!empty($sellers)) {
                foreach ($sellers as $seller) {
                    $seller_count += 1;
                }
            }
            
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
} else {
    $error_code = 1001;
    $error_msg = '请求失败';
    $return_url = '';
    $stores = '';
}

echo json_encode(array('error_code' =>$error_code , 'error_msg' => $error_msg, 'stores' => $stores,'uncheck_amount'=>$uncheck_amount,'check_amount'=>$check_amount,'order_count'=>$order_count,'seller_count'=>$seller_count, 'return_url' => $return_url));
exit;