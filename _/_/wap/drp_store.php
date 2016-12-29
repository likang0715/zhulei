<?php
/**
 * 分销店铺
 * User: pigcms_21
 * Date: 2015/4/18
 * Time: 9:01
 */

require_once dirname(__FILE__).'/global.php';

if (IS_GET && $_GET['a'] == 'edit') {
    if (empty($_SESSION['wap_drp_store'])) {
        pigcms_tips('您没有权限访问，<a href="./home.php?id=' . $_COOKIE['wap_store_id'] . '">返回首页</a>','none');
    }
    $store = $_SESSION['wap_drp_store'];

    if (!empty($store['source_site_url'])) {
        $store_info = $store;
    } else {
        $store_info = M('Store')->getStore($store['store_id']);
    }

    //查询供货商信息。
    $is_allow_edit_store_info  = true;

    //获取当前分销店铺的供货商
    if($store_info['drp_level'] > 0) {
        $supplier_chain = D('Store_supplier')->field('supply_chain')->where(array('seller_id'=>$store_info['store_id']))->find();
        $supplier_ids = explode(',', $supplier_chain['supply_chain']);
        $supplier_id = $supplier_ids['1'];
        $supplier_info = D('Store')->where(array('store_id'=>$supplier_id))->field('store_id,update_drp_store_info')->find();
        if($supplier_info['update_drp_store_info'] == 0){
            $is_allow_edit_store_info   = false;
        }
    }

    include display('drp_store_edit');
    echo ob_get_clean();
} else if (IS_POST && $_POST['type'] == 'edit') { //修改分销店铺
    if (empty($_SESSION['wap_drp_store'])) {
        json_return(1001, '店铺编辑失败');
    }
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $intro = isset($_POST['intro']) ? trim($_POST['intro']) : '';
    $data = array();
    $data['name'] = $name;
    $data['intro'] = $intro;
    $data['last_edit_time'] = time();
    if ($_SESSION['wap_drp_store']['name'] != $name) {
        $data['edit_name_count'] = $_SESSION['wap_drp_store']['edit_name_count'] + 1; //店铺名称修改次数
    }
    if (!empty($_SESSION['wap_drp_store'])) {
        if (D('Store')->where(array('store_id' => $_SESSION['wap_drp_store']['store_id']))->data($data)->save()) {
            if (isset($_SESSION['wap_drp_store']['name'])) {
                if ($_SESSION['wap_drp_store']['name'] != $name) {
                    $_SESSION['wap_drp_store']['edit_name_count'] += 1; //店铺名称修改次数
                }
                $_SESSION['wap_drp_store']['name'] = $name;
            }
            if (isset($_SESSION['wap_drp_store']['intro'])) {
                $_SESSION['wap_drp_store']['intro'] = $intro;
            }
            json_return(0, './drp_ucenter.php');
        } else {
            json_return(1001, '店铺编辑失败');
        }
    } else { //没有登录分销
        json_return(1000, './login.php');
    }
} else if (IS_POST && $_POST['type'] == 'add') { //添加分销店铺
    $product = M('Product');
    $product_image = M('Product_image');
    $product_sku = M('Product_sku');
    $product_group = M('Product_group');
    $product_to_group = M('Product_to_group');
    $product_to_property = M('Product_to_property');
    $product_to_property_value = M('Product_to_property_value');
    $product_qrcode_activity = M('Product_qrcode_activity');
    $product_custom_field = M('Product_custom_field');
    $store = M('Store');
    $store_supplier = M('Store_supplier');
    $user = M('User');
    $sale_category = M('Sale_category');
    $common_data = M('Common_data');

    $supplier_id = isset($_POST['store_id']) ? intval(trim($_POST['store_id'])) : 0;
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $pids = isset($_POST['pids']) ? explode(',', trim($_POST['pids'])) : array();
    $linkname = isset($_POST['truename']) ? trim($_POST['truename']) : '';
    $tel = isset($_POST['tel']) ? trim($_POST['tel']) : '';
    $qq = isset($_POST['qq']) ? trim($_POST['qq']) : '';
    $uid = $_SESSION['wap_user']['uid'];
    $open_drp_approve = !empty($_POST['open_drp_approve']) ? intval(trim($_POST['open_drp_approve'])) : 0; //是否开启分销商审核
    //即将申请的分销店铺的上级
    $supplier_store = $store->getStore($supplier_id);
    //获取顶级供货商
    $top_store_info = $store->getSuppliers($supplier_id);
    //商家（供货商店铺所有者）
    $tmp_user = D('User')->field('openid,phone')->where(array('uid' => $top_store_info['uid']))->find();
    $supplier_wecha_id = !empty($tmp_user['openid']) ? $tmp_user['openid'] : ''; //供货商的openid(发送模板消息)
    //分销商
    $seller_wecha_id = !empty($_SESSION['wap_user']['openid']) ? $_SESSION['wap_user']['openid'] : $_SESSION['openid'];
    //获取供货商分销级别
    $drp_level = !empty($supplier_store['drp_level']) ? $supplier_store['drp_level'] : 0;
    $avatar = $user->getAvatarById($_SESSION['wap_user']['uid']);
    $user_info = $user->getUserById($uid);
    $drp_level = ($drp_level + 1);//分销级别
    $data = array();
    $data['uid']               = $uid;
    $data['name']              = $name;
    $data['sale_category_id']  = $supplier_store['sale_category_id'];
    $data['sale_category_fid'] = $supplier_store['sale_category_fid'];
    $data['linkman']           = $linkname;
    $data['tel']               = $tel;
    $data['status']            = 1;
    $data['qq']                = $qq;
    $data['drp_supplier_id']   = $supplier_id;
    $data['date_added']        = time();
    $data['drp_level']         = $drp_level;
    $data['logo']              = $avatar;
    $data['open_nav']          = $supplier_store['open_nav'];
    $data['open_ad']           = $supplier_store['open_ad'];
    $data['open_ad']           = $supplier_store['open_ad'];
    $data['nav_style_id']      = $supplier_store['nav_style_id'];
    $data['use_nav_pages']     = $supplier_store['use_nav_pages'];
    $data['has_ad']            = $supplier_store['has_ad'];

    //兼容未更新root_supplier_id字段
    $root_supplier_id = 0;
    if (isset($supplier_store['root_supplier_id'])) { //root_supplier_id字段已更新
        if (!empty($supplier_store['root_supplier_id'])) { //上级有顶级供货商id
            $data['root_supplier_id'] = $supplier_store['root_supplier_id'];
            $root_supplier_id = $supplier_store['root_supplier_id'];
        } else if (empty($supplier_store['root_supplier_id']) && !empty($supplier_store['drp_supplier_id'])) { //上级是分销商，但没有顶级供货商id
            $data['root_supplier_id'] = $top_store_info['store_id'];
            $root_supplier_id = $top_store_info['store_id'];
        } else if (empty($supplier_store['root_supplier_id']) && empty($supplier_store['drp_supplier_id'])) { //上级是供货商，下级的顶级供货商id就是上级供货商id
            $data['root_supplier_id'] = $supplier_store['store_id'];
            $root_supplier_id = $supplier_store['store_id'];
        }
    }

    //对接店铺
    if (!empty($_SESSION['sync_user'])) {
        $data['bind_weixin'] = 1; //已绑定微信
    }
    if ($open_drp_approve) {
        $data['drp_approve'] = 0; //需要审核
    }

    $data['drp_diy_store'] = 0; //不允许分销商装修店铺


    if (!empty($_SESSION['registered']) && $_SESSION['registered'] == $name) {
        //json_return(0, './drp_ucenter.php');
    }

    //检测是否可用分销团队，如果有则加入
    if (M('Drp_team')->checkDrpTeam($supplier_id, true)) {
        //一级分销商（团队所有者）
        $first_seller_id = M('Store_supplier')->getFirstSeller($supplier_id);
        $first_seller = D('Store')->field('drp_team_id')->where(array('store_id' => $first_seller_id))->find();
        if (!empty($first_seller['drp_team_id'])) {
            $data['drp_team_id'] = $first_seller['drp_team_id'];
        }
    }

    $result = $store->create($data);
    if (!empty($result['err_code'])) { //店铺添加成功

        $store_id = $result['err_msg']['store_id']; //分销商id

        //平台店铺数+1
        $common_data->setStoreQty();
        //分销商数+1
        $common_data->setDrpSellerQty();

        $_SESSION['wap_drp_store'] = M('Store')->getStore($store_id);

        if (empty($user_info['password']) && empty($user_info['phone'])) { //未设置密码
            //对接用户首次分销设置登录密码为手机号
            if ($user->setField(array('uid' => $uid), array('phone' => $tel, 'password' => md5($tel)))) {
                $_SESSION['wap_user']['phone'] = $tel;
            }
        }

        $_SESSION['registered'] = $name;

        //对接店铺
        if (!empty($_SESSION['sync_user'])) { //更新source_site_url,payment_url,notify_url,oauth_url,is_seller,app_id,stores
            $tmp_data = array();
            $tmp_data['source_site_url'] = $supplier_store['source_site_url'];
            $tmp_data['payment_url']     = $supplier_store['payment_url'];
            $tmp_data['notify_url']      = $supplier_store['notify_url'];
            $tmp_data['oauth_url']       = $supplier_store['oauth_url'];
            $tmp_data['token']           = $supplier_store['token'];
            D('Store')->where(array('store_id' => $store_id))->data($tmp_data)->save();
        }

        //团队成员数+1
        if (!empty($data['drp_team_id'])) {
            M('Drp_team')->setMembersInc($data['drp_team_id']);
        }
        //用户店铺数+1
        $user->setStoreInc($_SESSION['wap_user']['uid']);
        //设置为卖家
        $user->setSeller($_SESSION['wap_user']['uid'], 1);
        //主营类目店铺数加1
        $sale_category->setStoreInc($supplier_store['sale_category_id']);
        $sale_category->setStoreInc($supplier_store['sale_category_fid']);

        $current_seller = $store_supplier->getSeller(array('seller_id' => $store_id));
        if ($current_seller['supplier_id'] != $supplier_id) {
            $seller = $store_supplier->getSeller(array('seller_id' => $supplier_id)); //获取上级分销商信息
            if (empty($seller['type'])) { //全网分销的分销商
                $seller['supply_chain'] = 0;
                $seller['level'] = 0;
            }
            $seller['supply_chain'] = !empty($seller['supply_chain']) ? $seller['supply_chain'] : 0;
            $seller['level'] = !empty($seller['level']) ? $seller['level'] : 0;
            $supply_chain = !empty($supplier_id) ? $seller['supply_chain'] . ',' . $supplier_id : 0;
            $level = $seller['level'] + 1;
            $data = array();
            $data['supplier_id']  = $supplier_id;
            $data['seller_id']    = $store_id;
            $data['supply_chain'] = $supply_chain;
            $data['level']        = $level;
            $data['type']         = 1;
            if (!empty($root_supplier_id)) {
                $data['root_supplier_id'] = $root_supplier_id; //统一供货商id
            }
            $store_supplier->add($data);//添加分销关联关系
        }

        if (!empty($supplier_wecha_id) || !empty($seller_wecha_id)) {
            if ($open_drp_approve) {
                $remark = '待审核分销商';
            } else {
                $remark = '正式分销商';
            }
        }

        //添加分销用户
        if (!D('Store_user_data')->where(array('store_id' => $top_store_info['store_id'], 'uid' => $uid))->count('pigcms_id')) {
            D('Store_user_data')->data(array('store_id' => $top_store_info['store_id'], 'uid' => $uid))->add();
        }

        //已关注过店铺公众号
        if (M('Subscribe_store')->subscribed($uid, $top_store_info['store_id'])) {
            import('source.class.Points');
            Points::subscribe($uid, $top_store_info['store_id'], $store_id, true);
        } else {
            //普通注册送积分
            import('source.class.Points');
            Points::drpStore($uid, $top_store_info['store_id'], $store_id);
        }

		///////////////////////////////////////////////
        //产生提醒-分销商申请成功通知
        import('source.class.Notice');
        Notice::FxStoreApplication($supplier_store,$top_store_info, $tmp_user , $remark, $tel, $name);
        ///////////////////////////////////////////////
        ob_clean();

        $redirect = './drp_ucenter.php';
        if (!empty($_POST['referer'])) {
            $redirect = html_entity_decode(urldecode($_POST['referer']) . $store_id);
        }

        json_return(0, $redirect);

    } else {
        json_return(1001, '店铺创建失败');
    }
} else if (IS_GET && $_GET['a'] == 'view' && isset($_GET['level'])) {
    if (empty($_SESSION['wap_drp_store'])) {
        redirect('./ucenter.php?id=' . intval(trim($_COOKIE['wap_store_id'])));
    }
    $store_supplier = M('Store_supplier');
    $store_model    = M('Store');
    $order          = M('Order');
    $fx_order       = M('Fx_order');

    $level     = isset($_GET['level']) ? trim(trim($_GET['level'])) : 1;
    $levels    = array(1 => '一', 2 => '二');
    $store     = $_SESSION['wap_drp_store'];
    $store_url = option('config.wap_site_url') . '/home.php?id=' . $store['store_id'];

    //当前分销商级别
    $store_id     = $store['store_id'];
    $seller       = $store_supplier->getSeller(array('seller_id' => $store_id));
    $seller_level = $seller['level'];
    $sub_level    = $seller_level + $level;

    $where = array();
    $where['level'] = $sub_level;
    $where['_string'] = 'FIND_IN_SET(' . $store_id . ', supply_chain)';
    $tmp_sub_sellers = $store_supplier->getSellers($where);
    $sellers = count($tmp_sub_sellers);

    include display('drp_store_level_view');
    echo ob_get_clean();

} else if (IS_POST && $_GET['a'] == 'seller') {

    $store_supplier = M('Store_supplier');
    $store_model    = M('Store');
    $order          = M('Order');

    $level     = isset($_POST['level']) ? trim(trim($_POST['level'])) : 1;
    $page_size = !empty($_POST['pagesize']) ? intval(trim($_POST['pagesize'])) : 10;
    $store     = $_SESSION['wap_drp_store'];

    //当前分销商级别
    $store_id     = $store['store_id'];
    $seller       = $store_supplier->getSeller(array('seller_id' => $store_id));
    $seller_level = $seller['level'];
    $sub_level    = $seller_level + $level;

    $where = array();
    $where['level'] = $sub_level;
    $where['_string'] = 'FIND_IN_SET(' . $store_id . ', supply_chain)';

    $sub_seller_count = $store_supplier->getSellerCount($where);
    import('source.class.user_page');
    $page = new Page($sub_seller_count, $page_size);
    $tmp_sub_sellers = $store_supplier->getSellers($where, $page->firstRow, $page->listRows);
    foreach ($tmp_sub_sellers as $tmp_sub_seller) {
        $store_info = D('Store')->field('store_id,name,income')->where(array('store_id' => $tmp_sub_seller['seller_id']))->find();
        $sales = $order->getSales(array('store_id' => $tmp_sub_seller['seller_id'], 'is_fx' => 1, 'status' => array('in', array(2,3,4,7))));
        //退货
        $sql = "SELECT (r.product_money + r.postage_money) AS return_total FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "return r WHERE o.order_id = r.order_id AND r.status = 5 AND o.store_id = '" . $tmp_sub_seller['seller_id'] . "' AND o.is_fx = 1 AND o.status IN (2,3,4,7)";
        $return_total = D('')->query($sql);
        $return_total = !empty($return_total[0]['return_total']) ? $return_total[0]['return_total'] : 0;
        $sales -= $return_total;

        $html .= '<tr>';
        $html .= '    <td class="left"><a href="home.php?id=' . $tmp_sub_seller['seller_id'] . '">' . $store_info['name'] . '</a></td>';
        if ($sales > 0) {
            $html .= '    <td class="right"><a href="drp_store.php?a=sales&store_id=' . $tmp_sub_seller['seller_id'] . '">' . number_format($sales, 2, '.', '') . '</a></td>';
        } else {
            $html .= '    <td class="right">' . number_format($sales, 2, '.', '') . '</td>';
        }
        if ($store_info['income'] > 0) {
            $html .= '    <td align="right"><a href="drp_commission.php?a=statistics&store_id=' . $tmp_sub_seller['seller_id'] . '">' . number_format($store_info['income'], 2, '.', '') . '</a></td>';
        } else {
            $html .= '    <td align="right">' . number_format($store_info['income'], 2, '.', '') . '</td>';
        }
        $html .= '</tr>';
    }
    $sellers = count($tmp_sub_sellers);
    echo json_encode(array('count' => $sellers, 'data' => $html));
    exit;

} else if (IS_GET && isset($_GET['level'])) { //下级分销店铺
    if (empty($_SESSION['wap_drp_store'])) {
        redirect('./ucenter.php?id=' . intval(trim($_COOKIE['wap_store_id'])));
    }
    $store_supplier = M('Store_supplier');
    $order          = M('Order');
    $user           = M('User');
    $fx_order       = M('Fx_order');
    $product        = M('Product');

    $level = isset($_GET['level']) ? trim(trim($_GET['level'])) : 1;

    $store = $_SESSION['wap_drp_store'];
    $levels = array(1 => '一', 2 => '二');
    //当前分销商级别
    $store_id     = $store['store_id'];
    $seller       = $store_supplier->getSeller(array('seller_id' => $store_id));
    $seller_level = $seller['level'];
    $sub_level    = $seller_level + $level;
    $where = array();
    $where['level'] = $sub_level;
    $where['_string'] = 'FIND_IN_SET(' . $store_id . ', supply_chain)';
    $sub_sellers = $store_supplier->getSellers($where);

    $order_count   = 0; //订单数量（已支付，只统计分销主订单）
    $fans_count    = 0; //粉丝数量
    $order_total   = 0; //订单总额（已支付，只统计分销主订单）
    $product_count = 0; //店铺商品
    $profit_from_seller = 0; //来源下级分销商的利润
    foreach ($sub_sellers as $sub_seller) {

        $tmp_order_total = $order->getSales(array('store_id' => $sub_seller['seller_id'], 'is_fx' => 1, 'status' => array('in', array(2,3,4,7))));
        //退货
        $sql = "SELECT (r.product_money + r.postage_money) AS return_total FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "return r WHERE o.order_id = r.order_id AND r.status = 5 AND o.store_id = '" . $sub_seller['seller_id'] . "' AND o.is_fx = 1 AND o.status IN (2,3,4,7)";
        $return_total = D('')->query($sql);
        $return_total = !empty($return_total[0]['return_total']) ? $return_total[0]['return_total'] : 0;
        $tmp_order_total -= $return_total;
        $order_total += $tmp_order_total;

        //给上级分销商的利润
        $orders = D('Order')->where(array('store_id' => $sub_seller['seller_id'], 'is_fx' => 1, 'status' => array('in', array(2,3,4,7))))->select();
        if (!empty($orders)) {
            foreach ($orders as $tmp_order) {
                $user_order_id = $tmp_order['user_order_id'];
                $sql = "SELECT SUM(fr.income) AS profit FROM " . option('system.DB_PREFIX') . "financial_record fr, " . option('system.DB_PREFIX') . "order o WHERE fr.order_id = o.order_id AND o.user_order_id = '" . $tmp_order['order_id'] . "' AND o.store_id = '" . $store_id . "'";
                $profit = D('')->query($sql);
                $profit = !empty($profit[0]['profit']) ? $profit[0]['profit'] : 0;
                $profit_from_seller += $profit;
            }
            $order_count += count($orders);
        }
    }
    $sub_sellers = count($sub_sellers);
    $profit_from_seller = number_format($profit_from_seller, 2, '.', '');

    include display('drp_store_level');
    echo ob_get_clean();

}  else if ($_GET['a'] == 'sales') {
    if (empty($_SESSION['wap_drp_store'])) {
        redirect('./ucenter.php?id=' . intval(trim($_COOKIE['wap_store_id'])));
    }
    $fx_order = M('Fx_order');
    $order = M('Order');
    $store = $_SESSION['wap_drp_store'];

    //有分销商id
    if (!empty($_GET['store_id'])) {
        $store['store_id'] = intval(trim($_GET['store_id']));
        $seller = D('Store')->field('name')->where(array('store_id' => $store['store_id']))->find();
        $seller = $seller['name'];
        $store['name'] = $seller;
    }

    $type = !empty($_GET['type']) ? trim($_GET['type']) : '';
    if (strtolower($type) == 'today'){ //今日销售额
        //今日销售额 00:00-6:00 6:00-12:00 12:00-18:00 18:00-24:00
        //00:00-6:00
        $starttime = strtotime(date('Y-m-d') . ' 00:00:00');
        $stoptime  = strtotime(date('Y-m-d') . ' 06:00:00');
        $sql = "SELECT SUM(total) AS sales FROM " . option('system.DB_PREFIX') . "order WHERE is_fx = 1 AND store_id = '" . $store['store_id'] . "' AND status IN (2,3,4,7) AND paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $todaysaletotal_0_6 = D('')->query($sql);
        $todaysaletotal_0_6 = !empty($todaysaletotal_0_6[0]['sales']) ? $todaysaletotal_0_6[0]['sales'] : 0;
        //6:00-12:00
        $starttime = strtotime(date('Y-m-d') . ' 06:00:00');
        $stoptime  = strtotime(date('Y-m-d') . ' 12:00:00');
        $sql = "SELECT SUM(total) AS sales FROM " . option('system.DB_PREFIX') . "order WHERE is_fx = 1 AND store_id = '" . $store['store_id'] . "' AND status IN (2,3,4,7) AND paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $todaysaletotal_6_12 = D('')->query($sql);
        $todaysaletotal_6_12 = !empty($todaysaletotal_6_12[0]['sales']) ? $todaysaletotal_6_12[0]['sales'] : 0;
        //12:00-18:00
        $starttime = strtotime(date('Y-m-d') . ' 12:00:00');
        $stoptime  = strtotime(date('Y-m-d') . ' 18:00:00');
        $sql = "SELECT SUM(total) AS sales FROM " . option('system.DB_PREFIX') . "order WHERE is_fx = 1 AND store_id = '" . $store['store_id'] . "' AND status IN (2,3,4,7) AND paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $todaysaletotal_12_18 = D('')->query($sql);
        $todaysaletotal_12_18 = !empty($todaysaletotal_12_18[0]['sales']) ? $todaysaletotal_12_18[0]['sales'] : 0;
        //18:00-24:00
        $starttime = strtotime(date('Y-m-d') . ' 18:00:00');
        $stoptime  = strtotime(date('Y-m-d') . ' 23:59:59');
        $sql = "SELECT SUM(total) AS sales FROM " . option('system.DB_PREFIX') . "order WHERE is_fx = 1 AND store_id = '" . $store['store_id'] . "' AND status IN (2,3,4,7) AND paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $todaysaletotal_18_24 = D('')->query($sql);
        $todaysaletotal_18_24 = !empty($todaysaletotal_18_24[0]['sales']) ? $todaysaletotal_18_24[0]['sales'] : 0;

        $todaysaletotal = "[" . number_format($todaysaletotal_0_6, 2, '.', '') . ',' . number_format($todaysaletotal_6_12, 2, '.', '') . ',' . number_format($todaysaletotal_12_18, 2, '.', '') . ',' . number_format($todaysaletotal_18_24, 2, '.', '') ."]";
        echo $todaysaletotal;
        exit;
    } else if (strtolower($type) == 'yesterday') { //昨日销售额
        //昨日销售额 00:00-6:00 6:00-12:00 12:00-18:00 18:00-24:00
        $date = date('Y-m-d' , strtotime('-1 day'));
        //00:00-6:00
        $starttime = strtotime($date . ' 00:00:00');
        $stoptime  = strtotime($date . ' 06:00:00');
        $sql = "SELECT SUM(total) AS sales FROM " . option('system.DB_PREFIX') . "order WHERE is_fx = 1 AND store_id = '" . $store['store_id'] . "' AND status IN (2,3,4,7) AND paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $yesterdaysaletotal_0_6 = D('')->query($sql);
        $yesterdaysaletotal_0_6 = !empty($yesterdaysaletotal_0_6[0]['sales']) ? $yesterdaysaletotal_0_6[0]['sales'] : 0;
        //6:00-12:00
        $starttime = strtotime($date . ' 06:00:00');
        $stoptime  = strtotime($date . ' 12:00:00');
        $sql = "SELECT SUM(total) AS sales FROM " . option('system.DB_PREFIX') . "order WHERE is_fx = 1 AND store_id = '" . $store['store_id'] . "' AND status IN (2,3,4,7) AND paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $yesterdaysaletotal_6_12 = D('')->query($sql);
        $yesterdaysaletotal_6_12 = !empty($yesterdaysaletotal_6_12[0]['sales']) ? $yesterdaysaletotal_6_12[0]['sales'] : 0;

        //12:00-18:00
        $starttime = strtotime($date . ' 12:00:00');
        $stoptime  = strtotime($date . ' 18:00:00');
        $sql = "SELECT SUM(total) AS sales FROM " . option('system.DB_PREFIX') . "order WHERE is_fx = 1 AND store_id = '" . $store['store_id'] . "' AND status IN (2,3,4,7) AND paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $yesterdaysaletotal_12_18 = D('')->query($sql);
        $yesterdaysaletotal_12_18 = !empty($yesterdaysaletotal_12_18[0]['sales']) ? $yesterdaysaletotal_12_18[0]['sales'] : 0;
        //18:00-24:00
        $starttime = strtotime($date . ' 18:00:00');
        $stoptime  = strtotime($date . ' 23:59:59');
        $sql = "SELECT SUM(total) AS sales FROM " . option('system.DB_PREFIX') . "order WHERE is_fx = 1 AND store_id = '" . $store['store_id'] . "' AND status IN (2,3,4,7) AND paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $yesterdaysaletotal_18_24 = D('')->query($sql);
        $yesterdaysaletotal_18_24 = !empty($yesterdaysaletotal_18_24[0]['sales']) ? $yesterdaysaletotal_18_24[0]['sales'] : 0;

        $yesterdaysaletotal = "[" . number_format($yesterdaysaletotal_0_6, 2, '.', '') . ',' . number_format($yesterdaysaletotal_6_12, 2, '.', '') . ',' . number_format($yesterdaysaletotal_12_18, 2, '.', '') . ',' . number_format($yesterdaysaletotal_18_24, 2, '.', '') ."]";
        echo $yesterdaysaletotal;
        exit;
    } else if (strtolower($type) == 'week') {
        $date = date('Y-m-d');  //当前日期
        $first = 1; //$first =1 表示每周星期一为开始日期 0表示每周日为开始日期
        $w = date('w',strtotime($date));  //获取当前周的第几天 周日是 0 周一到周六是 1 - 6
        $now_start = date('Y-m-d',strtotime("$date -".($w ? $w - $first : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天
        $now_end = date('Y-m-d',strtotime("$now_start +6 days"));  //本周结束日期

        //周一销售额
        $starttime = strtotime($now_start . ' 00:00:00');
        $stoptime  = strtotime($now_start . ' 23:59:59');
        $sql = "SELECT SUM(o.total) AS sales FROM " . option('system.DB_PREFIX') . "order WHERE is_fx = 1 AND store_id = '" . $store['store_id'] . "' AND status IN (2,3,4,7) AND paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $weeksaletotal_1 = D('')->query($sql);
        $weeksaletotal_1 = !empty($weeksaletotal_1[0]['sales']) ? $weeksaletotal_1[0]['sales'] : 0;
        //周二销售额
        $starttime = strtotime(date("Y-m-d",strtotime($now_start . "+1 day")) . ' 00:00:00');
        $stoptime  = strtotime(date("Y-m-d",strtotime($now_start . "+1 day")) . ' 23:59:59');
        $sql = "SELECT SUM(total) AS sales FROM " . option('system.DB_PREFIX') . "order WHERE is_fx = 1 AND store_id = '" . $store['store_id'] . "' AND status IN (2,3,4,7) AND paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $weeksaletotal_2 = D('')->query($sql);
        $weeksaletotal_2 = !empty($weeksaletotal_2[0]['sales']) ? $weeksaletotal_2[0]['sales'] : 0;
        //周三销售额
        $starttime = strtotime(date("Y-m-d",strtotime($now_start . "+2 day")) . ' 00:00:00');
        $stoptime  = strtotime(date("Y-m-d",strtotime($now_start . "+2 day")) . ' 23:59:59');
        $sql = "SELECT SUM(total) AS sales FROM " . option('system.DB_PREFIX') . "order WHERE is_fx = 1 AND store_id = '" . $store['store_id'] . "' AND status IN (2,3,4,7) AND paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $weeksaletotal_3 = D('')->query($sql);
        $weeksaletotal_3 = !empty($weeksaletotal_3[0]['sales']) ? $weeksaletotal_3[0]['sales'] : 0;
        //周四销售额
        $starttime = strtotime(date("Y-m-d",strtotime($now_start . "+3 day")) . ' 00:00:00');
        $stoptime  = strtotime(date("Y-m-d",strtotime($now_start . "+3 day")) . ' 23:59:59');
        $sql = "SELECT SUM(total) AS sales FROM " . option('system.DB_PREFIX') . "order WHERE is_fx = 1 AND store_id = '" . $store['store_id'] . "' AND status IN (2,3,4,7) AND paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $weeksaletotal_4 = D('')->query($sql);
        $weeksaletotal_4 = !empty($weeksaletotal_4[0]['sales']) ? $weeksaletotal_4[0]['sales'] : 0;
        //周五销售额
        $starttime = strtotime(date("Y-m-d",strtotime($now_start . "+4 day")) . ' 00:00:00');
        $stoptime  = strtotime(date("Y-m-d",strtotime($now_start . "+4 day")) . ' 23:59:59');
        $sql = "SELECT SUM(total) AS sales FROM " . option('system.DB_PREFIX') . "order WHERE is_fx = 1 AND store_id = '" . $store['store_id'] . "' AND status IN (2,3,4,7) AND paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $weeksaletotal_5 = D('')->query($sql);
        $weeksaletotal_5 = !empty($weeksaletotal_5[0]['sales']) ? $weeksaletotal_5[0]['sales'] : 0;
        //周六销售额
        $starttime = strtotime(date("Y-m-d",strtotime($now_start . "+5 day")) . ' 00:00:00');
        $stoptime  = strtotime(date("Y-m-d",strtotime($now_start . "+5 day")) . ' 23:59:59');
        $sql = "SELECT SUM(total) AS sales FROM " . option('system.DB_PREFIX') . "order WHERE is_fx = 1 AND store_id = '" . $store['store_id'] . "' AND status IN (2,3,4,7) AND paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $weeksaletotal_6 = D('')->query($sql);
        $weeksaletotal_6 = !empty($weeksaletotal_6[0]['sales']) ? $weeksaletotal_6[0]['sales'] : 0;
        //周日销售额
        $starttime = strtotime(date("Y-m-d",strtotime($now_start . "+6 day")) . ' 00:00:00');
        $stoptime  = strtotime(date("Y-m-d",strtotime($now_start . "+6 day")) . ' 23:59:59');
        $sql = "SELECT SUM(total) AS sales FROM " . option('system.DB_PREFIX') . "order WHERE is_fx = 1 AND store_id = '" . $store['store_id'] . "' AND status IN (2,3,4,7) AND paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $weeksaletotal_7 = D('')->query($sql);
        $weeksaletotal_7 = !empty($weeksaletotal_7[0]['sales']) ? $weeksaletotal_7[0]['sales'] : 0;

        $weeksaletotal = "[" . number_format($weeksaletotal_1, 2, '.', '') . ',' . number_format($weeksaletotal_2, 2, '.', '') . ',' . number_format($weeksaletotal_3, 2, '.', '') . ',' . number_format($weeksaletotal_4, 2, '.', '') . ',' . number_format($weeksaletotal_5, 2, '.', '') . ',' . number_format($weeksaletotal_6, 2, '.', '') . ',' . number_format($weeksaletotal_7, 2, '.', '') ."]";
        echo $weeksaletotal;
        exit;
    } else if (strtolower($type) == 'month') { //当月销售额
        $month = date('m');
        $year = date('Y');
        //1-7日
        $starttime = strtotime($year . '-' . $month . '-01' . ' 00:00:00');
        $stoptime  = strtotime($year . '-' . $month . '-07' . ' 00:00:00');

        $sql = "SELECT SUM(total) AS sales FROM " . option('system.DB_PREFIX') . "order WHERE is_fx = 1 AND store_id = '" . $store['store_id'] . "' AND status IN (2,3,4,7) AND paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $monthsaletotal_1_7 = D('')->query($sql);
        $monthsaletotal_1_7 = !empty($monthsaletotal_1_7[0]['sales']) ? $monthsaletotal_1_7[0]['sales'] : 0;
        //7-14日
        $starttime = strtotime($year . '-' . $month . '-07' . ' 00:00:00');
        $stoptime  = strtotime($year . '-' . $month . '-14' . ' 00:00:00');
        $sql = "SELECT SUM(total) AS sales FROM " . option('system.DB_PREFIX') . "order WHERE is_fx = 1 AND store_id = '" . $store['store_id'] . "' AND status IN (2,3,4,7) AND paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $monthsaletotal_7_14 = D('')->query($sql);
        $monthsaletotal_7_14 = !empty($monthsaletotal_7_14[0]['sales']) ? $monthsaletotal_7_14[0]['sales'] : 0;
        //14-21日
        $starttime = strtotime($year . '-' . $month . '-14' . ' 00:00:00');
        $stoptime  = strtotime($year . '-' . $month . '-21' . ' 00:00:00');
        $sql = "SELECT SUM(total) AS sales FROM " . option('system.DB_PREFIX') . "order WHERE is_fx = 1 AND store_id = '" . $store['store_id'] . "' AND status IN (2,3,4,7) AND paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $monthsaletotal_14_21 = D('')->query($sql);
        $monthsaletotal_14_21 = !empty($monthsaletotal_14_21[0]['sales']) ? $monthsaletotal_14_21[0]['sales'] : 0;
        //21-本月结束
        //当月最后一天
        $lastday   = date('t',time());
        $starttime = strtotime($year . '-' . $month . '-21' . ' 00:00:00');
        $stoptime  = strtotime($year . '-' . $month . '-' . $lastday . ' 23:59:59');
        $sql = "SELECT SUM(total) AS sales FROM " . option('system.DB_PREFIX') . "order WHERE is_fx = 1 AND store_id = '" . $store['store_id'] . "' AND status IN (2,3,4,7) AND paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $monthsaletotal_21_end = D('')->query($sql);
        $monthsaletotal_21_end = !empty($monthsaletotal_21_end[0]['sales']) ? $monthsaletotal_21_end[0]['sales'] : 0;

        $data = array();
        $monthsaletotal = "[" . number_format($monthsaletotal_1_7, 2, '.', '') . ',' . number_format($monthsaletotal_7_14, 2, '.', '') . ',' . number_format($monthsaletotal_14_21, 2, '.', '') . ',' . number_format($monthsaletotal_21_end, 2, '.', '') ."]";
        $data['monthsaletotal'] = $monthsaletotal;
        $data['lastday'] = $lastday;
        echo json_encode(array('data' => $data));
        exit;
    }

    //店铺销售额
    $sales = $order->getSales(array('store_id' => $store['store_id'], 'is_fx' => 1, 'status' => array('in', array(2,3,4,7))));
    $store['sales'] = number_format($sales, 2, '.', '');

    include display('drp_store_sales');
    echo ob_get_clean();

} else if (strtolower($_GET['a']) == 'select') {
    if (empty($_SESSION['wap_drp_store'])) {
        redirect('./ucenter.php?id=' . intval(trim($_COOKIE['wap_store_id'])));
    }

    $store    = $_SESSION['wap_drp_store'];
    $store_id = $store['store_id'];
    $store_model      = M('Store');
    $order            = M('Order');
    $store_supplier   = M('Store_supplier');
    $financial_record = M('Financial_record');

    if (!empty($_GET['id'])) {
        $store_info = $store_model->getUserDrpStore($store['uid'], intval(trim($_GET['id'])), 0);
        if ($store_info = $store_model->getUserDrpStore($store['uid'], intval(trim($_GET['id'])), 0)) { //已有分销店铺，跳转到分销管理页面
            $_SESSION['wap_drp_store'] = $store_info;
            redirect('./drp_ucenter.php');
        } else {
            redirect('./drp_ucenter.php');
        }
    }

    //店铺销售额
    $sales = $order->getSales(array('store_id' => $store['store_id'], 'is_fx' => 1, 'status' => array('in', array(2,3,4,7))));
    $store['sales'] = number_format($sales, 2, '.', '');
    //佣金总额
    $balance = !empty($store['income']) ? $store['income'] : 0;
    $store['balance'] = number_format($balance, 2, '.', '');

    $drp_approve = true;
    //供货商
    if (!empty($store['drp_supplier_id'])) {
        $supplier = $store_model->getStore($store['drp_supplier_id']);
        $store['supplier'] = $supplier['name'];

        if (!empty($supplier['open_drp_approve']) && empty($store['drp_approve'])) { //需要审核，但未审核
            $drp_approve = false;
        }
    }

    $store_detail = $store;

    $uid = $store['uid'];
    $stores = $store_model->getUserDrpStores($uid, 0, 0);

    foreach ($stores as &$store) {
        if (empty($store['logo'])) {
            $store['logo'] = 'images/default_shop.png';
        }
        $store['logo'] = getAttachmentUrl($store['logo']);
    }
    include display('drp_store_select');
    echo ob_get_clean();

} else if ($_GET['a'] == 'account') {
    if (empty($_SESSION['wap_drp_store'])) {
        redirect('./ucenter.php?id=' . intval(trim($_COOKIE['wap_store_id'])));
    }

    $store    = $_SESSION['wap_drp_store'];
    $store_id = $store['store_id'];
    $store_model      = M('Store');
    $order            = M('Order');
    $store_supplier   = M('Store_supplier');
    $financial_record = M('Financial_record');
    $user             = M('User');

    $store_info = $store_model->getStore($store_id);

    //店铺销售额
    $sales = $order->getSales(array('store_id' => $store['store_id'], 'is_fx' => 1, 'status' => array('in', array(2,3,4,7))));
    $store['sales'] = number_format($sales, 2, '.', '');
    //佣金总额
    $balance = !empty($store['income']) ? $store['income'] : 0;
    $store['balance'] = number_format($balance, 2, '.', '');

    $drp_approve = true;
    //供货商
    if (!empty($store['drp_supplier_id'])) {
        $supplier = $store_model->getStore($store['drp_supplier_id']);
        $store['supplier'] = $supplier['name'];

        if (!empty($supplier['open_drp_approve']) && empty($store['drp_approve'])) { //需要审核，但未审核
            $drp_approve = false;
        }
    }
    $uid = $store['uid'];
    $user_info = $user->checkUser(array('uid' => $uid));

    $phone = $user_info['phone'];
    $password = false;
    if (md5($phone) != $user_info['password']) {
        $password = true; //有新密码
    }


    $admin_url = '';
    //对接用户
    if (!empty($store_info['source_site_url'])) {
        $admin_url = $store_info['source_site_url']  . '/api/weidian.php';
    } else {
        $admin_url = option('config.site_url') . '/user.php?c=user&a=login';
    }

    include display('drp_store_account');
    echo ob_get_clean();
} else if (IS_POST && $_POST['type'] == 'check_store') { //店铺名检测
    $store = M('Store');
    $where = array();
    if (!empty($_SESSION['wap_drp_store'])) {
        $where['store_id'] = array('!=', $_SESSION['wap_drp_store']['store_id']);
    }
    $where['name'] = isset($_POST['name']) ? trim($_POST['name']) : '';
    $where['status'] = 1;
    if ($store->checkStoreExist($where)) {
        echo false;
    } else {
        echo true;
    }
    exit;
} else if (strtolower($_GET['a']) == 'reset_pwd') { //重置为初始密码
    if (empty($_SESSION['wap_drp_store'])) {
        pigcms_tips('您没有权限访问，<a href="./home.php?id=' . $_COOKIE['wap_store_id'] . '">返回首页</a>','none');
    }
    $user = M('User');

    $store = $_SESSION['wap_drp_store'];
    $user_info = $user->checkUser(array('uid' => $store['uid']));
    if (D('User')->where(array('uid' => $user_info['uid']))->data(array('password' => md5($user_info['phone'])))->save()) {
        redirect('./drp_ucenter.php');
    } else {
        redirect('./drp_store.php?a=account');
    }
} else if (IS_GET && $_GET['a'] == 'logout') {
    $store_id = $_SESSION['wap_drp_store']['store_id'];
    unset($_SESSION['wap_drp_store']);
    redirect('./ucenter.php?id=' . $store_id);
} else {
    
    //其他分销扩展功能
    redirect('./change_store.php');

}