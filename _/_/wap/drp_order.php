<?php
/**
 * 分销订单
 * User: pigcms_21
 * Date: 2015/4/22
 * Time: 18:13
 */
require_once dirname(__FILE__).'/global.php';

if (empty($_SESSION['wap_drp_store'])) {
    pigcms_tips('您没有权限访问，<a href="./home.php?id=' . $_COOKIE['wap_store_id'] . '">返回首页</a>','none');
}

if (IS_GET && $_GET['a'] == 'index') { //本店订单
    $order = M('Order');
    $fx_order = M('Fx_order');

    $store = $_SESSION['wap_drp_store'];

    //未分佣订单数
    $uncomplated_orders = $order->getOrderCountByStatus(array('store_id' => $store['store_id'], 'status' => array('in', array(2,3,6,7))));
    //已分佣订单数
    $complated_orders = $order->getOrderCountByStatus(array('store_id' => $store['store_id'], 'status' => 4));

    include display('drp_order_index');
    echo ob_get_clean();

} else if (IS_POST && $_POST['type'] == 'get') {
    $order = M('Order');
    $fx_order = M('Fx_order');
    $user = M('User');

    $store = $_SESSION['wap_drp_store'];
    $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : '';
    $page_size = isset($_POST['pagesize']) ? intval(trim($_POST['pagesize'])) : 10;
    if ($status == 1) {
        $status = array('in', array(2,3,6,7));
    } else if ($status == 2) {
        $status = 4;
    }
    $order_count = $order->getOrderCountByStatus(array('store_id' => $store['store_id'], 'status' => $status));
    import('source.class.user_page');
    $page = new Page($order_count, $page_size);
    $orders = $order->getOrdersByStatus(array('store_id' => $store['store_id'], 'status' => $status), $page->firstRow, $page->listRows);
    $html = '';
    foreach ($orders as $order) {
        //订单来源
        if (!empty($order['is_fx'])) {
            $seller = array('store_id' => $store['store_id'], 'name' => '本店');
        } else {
            $tmp_seller = D('Fx_order')->field('store_id')->where(array('fx_order_id' => $order['fx_order_id']))->find();
            $seller_id = $tmp_seller['store_id'];
            $seller = D('Store')->field('store_id,name')->where(array('store_id' => $seller_id))->find();
        }

        if (!empty($order['address_user'])) {
            $fans = $order['address_user'];
        } else if (!empty($order['uid'])) {
            $userinfo = $user->getUserById($order['uid']);
            $fans = !empty($userinfo['nickname']) ? $userinfo['nickname'] : '匿名';
        } else {
            $fans = '游客';
        }

        //利润
        $profit = M('Financial_record')->getTotal(array('order_id' => $order['order_id']));

        $html .= '<tr style="border: none">';
        $html .= '    <td colspan="4"><span style="display: inline-block;float: left; width: 120px;white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">来源: <a href="home.php?id=' . $seller['store_id'] . '">' . $seller['name'] . '</a></span> <span style="display: inline-block;float: right">佣金(元): <span style="color:green">+' . $profit . '</span>&nbsp; <a href="drp_order.php?a=detail&id=' . $order['order_id'] . '">详细>></a></span></td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '    <td class="left">' . $order['order_id'] . '</td>';
        $html .= '    <td class="left">' . $fans .'</td>';
        $html .= '    <td class="right">' . number_format($order['total'], 2, '.', '') . '</td>';
        $html .= '    <td align="center">' . date('Y-m-d', $order['add_time']) . '</td>';
        $html .= '</tr>';
    }
    echo json_encode(array('count' => count($orders), 'data' => $html));
} else if (IS_GET && $_GET['a'] == 'detail') {

    $order = M('Order');
    $order_product = M('Order_product');
    $package = M('Order_package');
    $fx_order = M('Fx_order');

    $store = $_SESSION['wap_drp_store'];

    $order_id = isset($_GET['id']) ? intval(trim($_GET['id'])) : 0;
    if (empty($order_id)) {
        pigcms_tips('抱歉，订单不存在！');
    }

    $order_detail = $order->getOrder($store['store_id'], $order_id);
    $order_detail['order_no'] = option('config.orderid_prefix') . $order_detail['order_no'];
    $order_detail['add_time'] = date('Y-m-d H:i:s', $order_detail['add_time']);
    $order_detail['address']  = unserialize($order_detail['address']);
    $order_detail['address']  = $order_detail['address']['province'] . ' ' . $order_detail['address']['city'] . ' ' . $order_detail['address']['area'] . ' ' . $order_detail['address']['address'];

    //供货商
    $fx_order = $fx_order->getSellerOrder($store['store_id'], $order_id);
    $supplier = D('Store')->field('name')->where(array('store_id' => $fx_order['supplier_id']))->find();
    $order_detail['supplier'] = $supplier['name'];

    //订单来源
    if (empty($order_detail['fx_order_id'])) {
        $order_detail['from'] = '本店';
    } else {
        $fx_order = D('Fx_order')->field('store_id')->where(array('fx_order_id' => $order_detail['fx_order_id']))->find();
        $seller   = D('Store')->field('name')->where(array('store_id' => $fx_order['store_id']))->find();
        $order_detail['from'] = $seller['name'];
    }

    //利润
    $profit = M('Financial_record')->getTotal(array('order_id' => $order_id));
    $order_detail['profit'] = $profit;

    //订单状态
    $order_status = $order->status();

    $products = $order_product->getProducts($order_id);

    $tmp_products = array();
    foreach ($products as $key => $product) {
        $products[$key]['image'] = getAttachmentUrl($product['image']);
        if (!empty($product['sku_data'])) {
            $sku_data = unserialize($product['sku_data']);
            foreach ($sku_data as $key2 => $sku) {
                $products[$key]['skus'][$key2] = array('name' => $sku['name'], 'value' => $sku['value']);
            }
        }
        //向后兼容利润计算
        $no_profit = false;
        if ($product['profit'] == 0) {
            $fx_order = D('Fx_order')->field('fx_order_id')->where(array('order_id' => $order_detail['order_id']))->find();
            $fx_order_product = D('Fx_order_product')->field('cost_price')->where(array('fx_order_id' => $fx_order['fx_order_id'], 'source_product_id' => $product['product_id']))->find();
            $product['cost_price'] = $fx_order_product['cost_price'];
            $product['profit'] = $product['pro_price'] - $product['cost_price'];
            if ($product['profit'] <= 0) {
                $product['profit'] = 0;
                $no_profit = true;
            }
        }

        $product['cost_price'] = ($product['pro_price'] - $product['profit'] > 0) ? $product['pro_price'] - $product['profit'] : 0;
        if ($product['profit'] == 0 && empty($product['supplier_id']) && empty($no_profit)) {
            $product['profit']     = $product['pro_price'];
        }
        $products[$key]['profit']     = number_format($product['profit'], 2, '.', '');
        $products[$key]['cost_price'] = number_format($product['cost_price'], 2, '.', '');
        $tmp_products[] = $product['original_product_id'];
    }

    //包裹
    $where = array();
    $where['user_order_id'] = array('in', array($order_detail['order_id'], $order_detail['user_order_id'] + 0));
    $tmp_packages = $package->getPackages($where);
    $packages = array();
    foreach ($tmp_packages as $package) {
        $package_products = explode(',', $package['products']);
        if (array_intersect($package_products, $tmp_products)) {
            $packages[] = $package;
        }
    }

    include display('drp_order_detail');
    echo ob_get_clean();
}