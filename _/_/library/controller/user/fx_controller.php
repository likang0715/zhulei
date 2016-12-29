<?php

class fx_controller extends base_controller
{
    public function __construct()
    {
        parent::__construct();

        if (IS_POST || IS_AJAX) {
            if (!$this->checkDrp(true)) {
                json_return(1001, '您访问的页面不存在');
            }
        } else {
            $this->checkDrp(false, true);
        }

        //是否允许设置商品再次分销
        if ((!empty($this->store_session['drp_supplier_id']) && $this->checkDrp(TRUE))) {
            $fx_again = TRUE;
        } else {
            $fx_again = FALSE;
        }
        $is_supplier = FALSE;
        if (((!empty($this->store_session['drp_supplier_id']) && $this->checkDrp(TRUE))) || empty($this->store_session['drp_supplier_id'])) {
            $is_supplier = TRUE;
        }

        //分销团队
        $open_drp_team = M('Drp_team')->checkDrpTeam($this->store_session['store_id'], true);

        //非团队所有者
        if ($this->store_session['drp_level'] > 1) {
            $first_seller_id = M('Store_supplier')->getFirstSeller($this->store_session['store_id']);
            $drp_team = M('Drp_team')->getDrpTeam(array('store_id' => $first_seller_id));
            //没有分销团队
            if (empty($drp_team)) {
                $open_drp_team = 0;
            }
        }

        $this->assign('open_drp_team', $open_drp_team);
        $this->assign('fx_again', $fx_again);
        $this->assign('is_supplier', $is_supplier);
    }

    public function load()
    {
        $action = strtolower(trim($_POST['page']));
        $start_time = isset($_POST['start_time']) ? trim($_POST['start_time']) : '';
        $stop_time = isset($_POST['stop_time']) ? trim($_POST['stop_time']) : '';
        $store_id = isset($_POST['store_id']) ? trim($_POST['store_id']) : $this->store_session['store_id'];
        if (empty($action))
        {
            pigcms_tips('非法访问！', 'none');
        }
        switch ($action)
        {
            case 'index_content':
                $this->_index_content();
                break;
            case 'market_content':
                $this->_market_content();
                break;
            case 'goods_content':
                $this->_goods_content();
                break;
            case 'orders_content':
                $this->_orders_content();
                break;
            case 'order_detail_content':
                $this->_order_detail_content();
                break;
            case 'pay_order_content':
                $this->_pay_order_content();
                break;
            case 'supplier_content':
                $this->_supplier_content();
                break;
            case 'supplier_goods_content':
                $this->_supplier_goods_content();
                break;
            case 'contact_information_content':
                $this->contact_information_content();
                break;
            case 'my_seller_detail_content':
                $this->_seller_detail_content(array ('store_id' => $store_id));
                break;
            case 'goods_fx_setting_content':
                $this->_goods_fx_setting_content();
                break;
            case 'supplier_market_content':
                $this->_supplier_market_content();
                break;
            case 'edit_goods_content':
                $this->_edit_goods_content();
                break;
            case 'seller_content':
                $this->seller_content();
                break;
            case 'next_seller_content':
                $this->_next_seller_content();
                break;
            case 'seller_order_content':
                $this->seller_order_content();
                break;
            case 'distribution_index_content':
                $this->distribution_index_content();
                break;
            case 'distribution_rank_content':
                $this->distribution_rank_content();
                break;
            case 'edit_wholesale_content':
                $this->edit_wholesale_content();
                break;
            case 'goods_wholesale_setting_content':
                $this->_goods_wholesale_setting_content();
                break;
            case 'statistics_content':
                $this->_statistics_content(array ('start_time' => $start_time, 'stop_time' => $stop_time, 'store_id' => $store_id));
                break;
            case 'setting_content':
                $this->_setting_content();
                break;
            case 'commission_detail_content':
                $this->_commission_detail_content();
                break;
            case 'my_wholesale_content':
                $this->my_wholesale_content();
                break;
            case 'my_supplier_content':
                $this->my_supplier_content();
                break;
            case 'wholesale_order_content':
                $this->wholesale_order_content();
                break;
            case 'setting_supplier_content':
                $this->_seller_setting_content();
                break;
            case 'agency_content':
                $this->_agency_content();
                break;
            case 'wholesale_market_content':
                $this->wholesale_market_content();
                break;
            case 'whole_setting_content':
                $this->whole_setting_content();
                break;
            case 'whole_detail_content':
                $this->_whole_detail_content();
                break;
            case 'recharge_content':
                $this->recharge_content();
                break;
            case 'bond_log_content':
                $this->bond_log_content();
                break;
            case 'my_bond_log_content':
                $this->my_bond_log_content();
                break;
            case 'bond_record_content':
                $this->bond_record_content();
                break;
            case 'my_order_content':
                $this->_my_order_content();
                break;
            case 'wholesale_market_product_content':
                $this->_wholesale_market_product_content();
                break;
            case '_ws_order_content':
                $this->_ws_order_content();
                break;
            case '_bond_expend_content':
                $this->_bond_expend_content();
                break;
            case '_bond_recharge_content':
                $this->_bond_recharge_content();
                break;
            case '_withdrawal_record_content':
                $this->_withdrawal_record_content();
                break;
            case '_wholesale_product_content':
                $this->_wholesale_product_content();
                break;
            case '_approve_data_content':
                $this->_approve_data_content();
                break;
            case '_whitelist_product_content':
                $this->_whitelist_product_content();
                break;
            case 'shop_promotion_content':
                $this->shop_promotion_content();
                break;
	        case 'fx_store_info_content':
		        $this->_fx_store_info_content($_POST);
                break;
	        case 'degree_content':
	        	$this->_degree_content();
	        	break;
	        case 'degree_create':
	        	$this->_degree_create();
	        	break;
			case 'degree_edit':			
				$this->_degree_edit();
				break;
            case 'my_team_content':
                $this->_my_team_content();
                break;
            case 'my_team_detail_content':
                $this->_my_team_detail_content();
                break;
            case 'dividends_setting_content':
                $this->_dividends_setting_content();
                break;
            case 'dividends_rules_create':         
                $this->_dividends_rules_create();
                break;
            case 'dividends_rules_edit':         
                $this->_dividends_rules_edit();
                break;
            case 'dividends_sendrules_edit':
                $this->_dividends_sendrules_edit();
                break;
        }
        $this->display($_POST['page']);
    }

    public function index()
    {
        $this->display();
    }

    public function seller_setting()
    {
        $this->display();
    }

    private function _index_content()
    {
        $store = M('Store');
        $product = M('Product');
        $order = M('Order');
        $financial_record = M('Financial_record');

        //当前分销等级
        $drp_level = $this->store_session['drp_level'];
        //供货商
        $root_supplier_id = $this->store_session['root_supplier_id'];

        //获取供货商分销商品
        $fx_product_count = $product->supplierFxProductCount(array ('store_id' => $root_supplier_id, 'is_fx' => 1, 'status' => 1));

        //店铺销售额
        $sales = $order->getSales(array('store_id' => $this->store_session['store_id'], 'is_fx' => 1, 'status' => array ('in', array (2, 3, 4, 7))));
        //退货
        $sql = "SELECT SUM(r.product_money + r.postage_money + (r.platform_point / o.point2money_rate)) AS return_total FROM " . option('system.DB_PREFIX') . "return r, " . option('system.DB_PREFIX') . "order o WHERE o.order_id = r.order_id AND o.store_id = '" . $this->store_session['store_id'] . "' AND o.user_order_id = 0 AND o.status IN (2,3,4,6,7)";
        $return = D('')->query($sql);
        $return_total = !empty($return[0]['return_total']) ? $return[0]['return_total'] : 0;
        $sales -= $return_total;
        $sales = ($sales > 0) ? $sales : '0.00';
        $sales = number_format($sales, 2, '.', '');

        //店铺佣金
        $store = $store->getStore($this->store_session['store_id']);
        $profit = !empty($store['balance']) ? $store['balance'] : 0;
        $profit = number_format($profit, 2, '.', '');

        //不可提现佣金
        $unbalance = !empty($store['unbalance']) ? $store['unbalance'] : 0;
        $unbalance = number_format($unbalance, 2, '.', '');

        //七天销售额、佣金
        $days_7_sales = array ();
        $days_7_profits = array ();

        $every_day_sellers = array ();
        $end_today_sellers = array ();
        $days = array ();
        $tmp_days = array ();
        for ($i = 6; $i >= 0; $i--) {
            $day = date("Y-m-d", strtotime('-' . $i . 'day'));
            $days[] = $day;
        }
        foreach ($days as $day) {
            //开始时间
            $start_time = strtotime($day . ' 00:00:00');
            //结束时间
            $stop_time = strtotime($day . ' 23:59:59');

            //七日订单
            $where = array();
            $where['store_id']      = $this->store_session['store_id'];
            $where['is_fx']         = 1;
            $where['status']        = array ('in', array (2, 3, 4, 7));
            $where['_string']       = "paid_time >= " . $start_time . ' AND paid_time <= ' . $stop_time;
            $tmp_days_7_orders = D('Order')->where($where)->select();

            //七日销售额
            $tmp_day_7_sales = 0;
            //七日佣金
            $tmp_days_7_profits = 0;
            if (!empty($tmp_days_7_orders)) {
                foreach ($tmp_days_7_orders as $tmp_days_7_order) {
                    $tmp_order = D('Order')->field('total,pro_num')->where(array('order_id' => $tmp_days_7_order['order_id']))->find();
                    $tmp_total = $tmp_order['total']; //含平台抵现积分

                    //退货金额
                    $sql = "SELECT SUM(r.product_money + r.postage_money + (r.platform_point / o.point2money_rate)) AS return_total FROM " . option('system.DB_PREFIX') . "return r, " . option('system.DB_PREFIX') . "order o WHERE o.order_id = r.order_id AND o.order_id = '" . $tmp_days_7_order['order_id'] . "' AND o.user_order_id = 0 AND o.status IN (2,3,4,6,7)";
                    $return = D('')->query($sql);
                    $return_total = !empty($return[0]['return_total']) ? $return[0]['return_total'] : 0;
                    $tmp_total = $tmp_total - $return_total;
                    $tmp_total = ($tmp_total > 0) ? $tmp_total : 0;

                    $tmp_day_7_sales += $tmp_total;

                    //佣金
                    $where = array ();
                    $where['store_id'] = $this->store_session['store_id'];
                    $where['order_id'] = $tmp_days_7_order['order_id'];
                    $tmp_days_7_profits += $financial_record->drpProfit($where);
                }
            }
            $days_7_sales[] = !empty($tmp_day_7_sales) ? number_format($tmp_day_7_sales, 2, '.', '') : 0;

            $days_7_profits[] = !empty($tmp_days_7_profits) ? number_format($tmp_days_7_profits, 2, '.', '') : 0;

            //每日新增
            $where = array ();
            $where['store_id'] = $this->store_session['store_id'];
            $where['_string'] = "s.date_added >= " . $start_time . " AND s.date_added < " . $stop_time . " AND s.drp_level <= '" . ($drp_level + 2) . "'";
            $tmp_every_day_sellers = M('Store')->getSellerCountBySales($where, $this->store_session['drp_supplier_id']);
            $every_day_sellers[] = $tmp_every_day_sellers;

            //截止今日分销商数量
            $where = array ();
            $where['store_id'] = $this->store_session['store_id'];
            $where['_string'] = "s.date_added < " . $stop_time . " AND s.drp_level <= '" . ($drp_level + 2) . "'";
            $tmp_end_today_sellers = M('Store')->getSellerCountBySales($where, $this->store_session['drp_supplier_id']);
            $end_today_sellers[] = $tmp_end_today_sellers;

            $tmp_days[] = "'" . $day . "'";
        }
        $every_day_sellers = '[' . implode(',', $every_day_sellers) . ']';
        $end_today_sellers = '[' . implode(',', $end_today_sellers) . ']';
        $days = '[' . implode(',', $tmp_days) . ']';
        $days_7_sales = '[' . implode(',', $days_7_sales) . ']';
        $days_7_profits = '[' . implode(',', $days_7_profits) . ']';

        $this->assign('fx_product_count', $fx_product_count);
        $this->assign('sales', $sales);
        $this->assign('profit', $profit);
        $this->assign('unbalance', $unbalance);
        $this->assign('days', $days);
        $this->assign('days_7_sales', $days_7_sales);
        $this->assign('days_7_profits', $days_7_profits);
        $this->assign('every_day_sellers', $every_day_sellers);
        $this->assign('end_today_sellers', $end_today_sellers);
    }

    //全网分销商品市场
    public function market()
    {
        $store = M('Store');
        $product = M('Product');
        $product_image = M('Product_image');
        $product_sku = M('Product_sku');
        $product_to_property = M('Product_to_property');
        $product_to_property_value = M('Product_to_property_value');
        $product_qrcode_activity = M('Product_qrcode_activity');
        $product_custom_field = M('Product_custom_field');
        $store_id = !empty($_POST['store_id']) ? $_POST['store_id'] : '';

        $store_supplier = M('Store_supplier');
        //批发处理
        if (IS_POST && strtolower(trim($_POST['type'])) == 'wholesale') {

            if (!$this->checkFx(true)) {
                json_return(1001, '批发失败');
            }

            $products = isset($_POST['product_ids']) ? $_POST['product_ids'] : array ();
            $address_id = 0;

            foreach ($products as $product_id) {
                $product_info = $product->get(array ('product_id' => $product_id, 'is_wholesale' => 1), '*');
                $data = $product_info;
                unset($data['product_id']);
                $data['name'] = mysql_real_escape_string($data['name']);
                $data['uid'] = $this->user_session['uid'];
                $data['store_id'] = $this->store_session['store_id'];
                $data['is_fx'] = 0;
                $data['is_wholesale'] = 0;
                $data['wholesale_product_id'] = $product_id;
                $data['status'] = 0; //仓库中
                $data['date_added'] = time();
                $data['supplier_id'] = $product_info['store_id'];
                $data['pv'] = 0;
                $data['delivery_address_id'] = $address_id;
                $data['sales'] = 0; //销量清零
                $data['source_product_id'] = 0;
                $data['original_product_id'] = 0;
                $data['is_fx_setting'] = 0;
                $data['price'] = $product_info['sale_min_price'];
                $data['wholesale_price'] = $product_info['wholesale_price'];
                $data['sale_min_price'] = $product_info['sale_min_price'];
                $data['sale_max_price'] = $product_info['sale_max_price'];

                if ($new_product_id = $product->add($data)) {
                    //商品图片
                    $tmp_images = $product_image->getImages($product_id);
                    $images = array ();
                    foreach ($tmp_images as $tmp_image) {
                        $images[] = $tmp_image['image'];
                    }
                    $product_image->add($new_product_id, $images);
                    //商品自定义字段
                    $tmp_fields = $product_custom_field->getFields($product_id);
                    $fields = array ();
                    if (!empty($tmp_fields)) {
                        foreach ($tmp_fields as $tmp_field) {
                            $fields[] = array (
                                'name' => $tmp_field['field_name'],
                                'type' => $tmp_field['field_type'],
                                'multi_rows' => $tmp_field['multi_rows'],
                                'required' => $tmp_field['required']
                            );
                        }
                        $product_custom_field->add($new_product_id, $fields);
                    }

                    //商品属性名
                    $property_names = $product_to_property->getPropertyNames($product_info['store_id'], $product_id);
                    if (!empty($property_names)) {
                        foreach ($property_names as $property_name) {
                            $product_to_property->add(array ('store_id' => $this->store_session['store_id'], 'product_id' => $new_product_id, 'pid' => $property_name['pid'], 'order_by' => $property_name['order_by']));
                        }
                    }
                    //商品属性值
                    $property_values = $product_to_property_value->getPropertyValues($product_info['store_id'], $product_id);
                    if (!empty($property_values)) {
                        foreach ($property_values as $property_value) {
                            $product_to_property_value->add(array ('store_id' => $this->store_session['store_id'], 'product_id' => $new_product_id, 'pid' => $property_value['pid'], 'vid' => $property_value['vid'], 'order_by' => $property_value['order_by']));
                        }
                    }
                    //扫码活动
                    $qrcode_activities = $product_qrcode_activity->getActivities($product_info['store_id'], $product_id);
                    if (!empty($qrcode_activities)) {
                        foreach ($qrcode_activities as $qrcode_activitiy) {
                            $product_qrcode_activity->add(array ('store_id' => $this->store_session['store_id'], 'product_id' => $new_product_id, 'buy_type' => $qrcode_activitiy['buy_type'], 'type' => $qrcode_activitiy['type'], 'discount' => $qrcode_activitiy['discount'], 'price' => $qrcode_activitiy['price']));
                        }
                    }
                    //库存信息
                    $tmp_product_skus = $product_sku->getSkus($product_id);
                    if ($tmp_product_skus) {
                        $skus = array ();

                        foreach ($tmp_product_skus as $tmp_product_sku) {
                            $tmp_product_sku['price'] = $tmp_product_sku['sale_min_price'];
                            unset($tmp_product_sku['product_id']);
                            $skus[] = $tmp_product_sku;
                        }
                        $product_sku->supplier_to_wholesale($new_product_id, $skus);
                    }
                    if (!D('Supp_dis_relation')->where(array ('supplier_id' => $store_id, 'distributor_id' => $this->store_session['store_id']))->find()) {// 添加供货商经销商关系
                        $datas['authen'] = 1;
                        $datas['add_time'] = time();
                        $datas['supplier_id'] = $store_id;
                        $datas['distributor_id'] = $this->store_session['store_id'];
                        $result = D('Supp_dis_relation')->data($datas)->add();
                    }
                    if (!$store_supplier->suppliers(array ('supplier_id' => $product_info['store_id'], 'seller_id' => $this->store_session['store_id']))) {
                        $store_supplier->add(array ('supplier_id' => $product_info['store_id'], 'seller_id' => $this->store_session['store_id']));
                    } else {
                        $current_seller = $store_supplier->getSeller(array ('seller_id' => $this->store_session['store_id'], 'supplier_id' => $product_info['store_id']));

                        $seller = $store_supplier->getSeller(array ('seller_id' => $product_info['store_id'])); //获取上级分销商信息
                        if (empty($seller['type'])) { //全网分销的分销商
                            $seller['supply_chain'] = 0;
                            $seller['level'] = 0;
                        }
                        $seller['supply_chain'] = !empty($seller['supply_chain']) ? $seller['supply_chain'] : 0;
                        $seller['level'] = !empty($seller['level']) ? $seller['level'] : 0;
                        $supply_chain = !empty($product_info['store_id']) ? $seller['supply_chain'] . ',' . $product_info['store_id'] : 0;
                        $level = $seller['level'] + 1;
                        if ($current_seller['supplier_id'] != $product_info['store_id']) {
                            $store_supplier->add(array ('supplier_id' => $product_info['store_id'], 'seller_id' => $this->store_session['store_id'], 'supply_chain' => $supply_chain, 'level' => $level, 'type' => 1));//添加分销关联关系
                            $_SESSION['store']['drp_supplier_id'] = $product_info['store_id'];
                            //供货商店铺
                            $supplier_store = $store->getStore($product_info['store_id']);
                            //获取供货商分销级别
                            $drp_level = !empty($supplier_store['drp_level']) ? $supplier_store['drp_level'] : 0;
                            D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('drp_supplier_id' => $product_info['store_id'], 'drp_level' => ($drp_level + 1)))->save();
                        }
                    }
                }
            }
            json_return(0, '批发成功');
            exit;
            // 分销处理
        } else if (IS_POST && strtolower(trim($_POST['type'])) == 'fx') {
            $store = M('Store');
            $product = M('Product');
            $product_image = M('Product_image');
            $product_sku = M('Product_sku');
            $product_to_group = M('Product_to_group');
            $product_to_property = M('Product_to_property');
            $product_to_property_value = M('Product_to_property_value');
            $product_qrcode_activity = M('Product_qrcode_activity');
            $product_custom_field = M('Product_custom_field');
            //$seller_fx_product = M('Seller_fx_product');
            $store_supplier = M('Store_supplier');

            $products = isset($_POST['product_ids']) ? $_POST['product_ids'] : array ();
            $address_id = 0;
            foreach ($products as $product_id) {
                $product_info = $product->get(array ('product_id' => $product_id, 'is_fx' => 1), '*');
                $data = $product_info;
                unset($data['product_id']);
                $data['name'] = mysql_real_escape_string($data['name']);
                $data['uid'] = $this->user_session['uid'];
                $data['store_id'] = $this->store_session['store_id'];
                $data['price'] = $product_info['min_fx_price'];
                $data['is_wholesale'] = 0;
                $data['is_fx'] = 0;
                $data['source_product_id'] = $product_id;
                $data['status'] = 0; //仓库中
                $data['date_added'] = time();
                $data['supplier_id'] = $product_info['store_id'];
                $data['pv'] = 0;
                $data['delivery_address_id'] = $address_id;
                $data['sales'] = 0; //销量清零
                $data['cost_price'] = 0;
                $data['min_fx_price'] = 0;
                $data['max_fx_price'] = 0;
                $data['drp_level_1_price'] = 0;
                $data['drp_level_2_price'] = 0;
                $data['drp_level_3_price'] = 0;
                $data['drp_level_1_cost_price'] = 0;
                $data['drp_level_2_cost_price'] = 0;
                $data['drp_level_3_cost_price'] = 0;

                if (!empty($product_info['original_product_id'])) {
                    $data['original_product_id'] = $product_info['original_product_id'];
                } else {
                    $data['original_product_id'] = $product_id;
                }
                $data['is_fx_setting'] = 0;
                if ($new_product_id = $product->add($data)) {
                    //商品图片
                    $tmp_images = $product_image->getImages($product_id);
                    $images = array ();
                    foreach ($tmp_images as $tmp_image) {
                        $images[] = $tmp_image['image'];
                    }
                    $product_image->add($new_product_id, $images);
                    //商品自定义字段
                    $tmp_fields = $product_custom_field->getFields($product_id);
                    $fields = array ();
                    if (!empty($tmp_fields)) {
                        foreach ($tmp_fields as $tmp_field) {
                            $fields[] = array (
                                'name' => $tmp_field['field_name'],
                                'type' => $tmp_field['field_type'],
                                'multi_rows' => $tmp_field['multi_rows'],
                                'required' => $tmp_field['required']
                            );
                        }
                        $product_custom_field->add($product_id, $fields);
                    }
                    //商品分组
                    /*$groups = $product_to_group->getGroups($product_id);
                    if (!empty($groups)) {
                        foreach ($groups as $group) {
                            $product_to_group->add(array('product_id' => $new_product_id, 'group_id' => $group['group_id']));
                        }
                    }*/
                    //商品属性名
                    $property_names = $product_to_property->getPropertyNames($product_info['store_id'], $product_id);
                    if (!empty($property_names)) {
                        foreach ($property_names as $property_name) {
                            $product_to_property->add(array ('store_id' => $this->store_session['store_id'], 'product_id' => $new_product_id, 'pid' => $property_name['pid'], 'order_by' => $property_name['order_by']));
                        }
                    }
                    //商品属性值
                    $property_values = $product_to_property_value->getPropertyValues($product_info['store_id'], $product_id);
                    if (!empty($property_values)) {
                        foreach ($property_values as $property_value) {
                            $product_to_property_value->add(array ('store_id' => $this->store_session['store_id'], 'product_id' => $new_product_id, 'pid' => $property_value['pid'], 'vid' => $property_value['vid'], 'order_by' => $property_value['order_by']));
                        }
                    }
                    //扫码活动
                    $qrcode_activities = $product_qrcode_activity->getActivities($product_info['store_id'], $product_id);
                    if (!empty($qrcode_activities)) {
                        foreach ($qrcode_activities as $qrcode_activitiy) {
                            $product_qrcode_activity->add(array ('store_id' => $this->store_session['store_id'], 'product_id' => $new_product_id, 'buy_type' => $qrcode_activitiy['buy_type'], 'type' => $qrcode_activitiy['type'], 'discount' => $qrcode_activitiy['discount'], 'price' => $qrcode_activitiy['price']));
                        }
                    }
                    //库存信息
                    $tmp_product_skus = $product_sku->getSkus($product_id);

                    if ($tmp_product_skus) {
                        $skus = array ();
                        foreach ($tmp_product_skus as $tmp_product_sku) {
                            $skus[] = array (
                                'properties' => $tmp_product_sku['properties'],
                                'quantity' => $tmp_product_sku['quantity'],
                                'price' => $tmp_product_sku['min_fx_price'],
                                'code' => $tmp_product_sku['code'],
                                'sales' => 0,
                                'cost_price' => 0,
                                'min_fx_price' => 0,
                                'max_fx_price' => 0
                            );
                        }
                        $product_sku->add($new_product_id, $skus);
                    }
                    if (empty($this->user_session['drp_store_id'])) {
                        if (!$store_supplier->suppliers(array ('supplier_id' => $product_info['store_id'], 'seller_id' => $this->store_session['store_id']))) {
                            $store_supplier->add(array ('supplier_id' => $product_info['store_id'], 'seller_id' => $this->store_session['store_id']));
                        }
                    } else {
                        $current_seller = $store_supplier->getSeller(array ('seller_id' => $this->store_session['store_id']));

                        $seller = $store_supplier->getSeller(array ('seller_id' => $product_info['store_id'])); //获取上级分销商信息
                        if (empty($seller['type'])) { //全网分销的分销商
                            $seller['supply_chain'] = 0;
                            $seller['level'] = 0;
                        }
                        $seller['supply_chain'] = !empty($seller['supply_chain']) ? $seller['supply_chain'] : 0;
                        $seller['level'] = !empty($seller['level']) ? $seller['level'] : 0;
                        $supply_chain = !empty($product_info['store_id']) ? $seller['supply_chain'] . ',' . $product_info['store_id'] : 0;
                        $level = $seller['level'] + 1;
                        if ($current_seller['supplier_id'] != $product_info['store_id']) {
                            $store_supplier->add(array ('supplier_id' => $product_info['store_id'], 'seller_id' => $this->store_session['store_id'], 'supply_chain' => $supply_chain, 'level' => $level, 'type' => 1));//添加分销关联关系
                            $_SESSION['store']['drp_supplier_id'] = $product_info['store_id'];
                            //供货商店铺
                            $supplier_store = $store->getStore($product_info['store_id']);
                            //获取供货商分销级别
                            $drp_level = !empty($supplier_store['drp_level']) ? $supplier_store['drp_level'] : 0;
                            D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('drp_supplier_id' => $product_info['store_id'], 'drp_level' => ($drp_level + 1)))->save();
                        }
                    }
                    json_return(0, '分销成功');
                }
            }
            exit;
        }

        $this->checkFx(false, true);

        $this->display();
    }

    private function _market_content(){
        $product = M('Product');
        $store = M('Store');

        $is = !empty($_POST['is']) ? intval($_POST['is']) : 1;
        $keyword = !empty($_POST['keyword']) ? trim($_POST['keyword']) : '';
        $store_id = !empty($_POST['store_id']) ? trim($_POST['store_id']) : '';

        $where = array ();
        //当前店铺信息
        $store_info = $store->getStore($this->store_session['store_id']);

        if ($store_info['drp_level'] == 0) {
            $type = 'wholesale';
            $where['is_wholesale'] = 1; //设置分销的商品
        } else if ($store_info['drp_level'] > 0) {
            $type = 'fx';
            $where['is_fx'] = 1;
        }

        $whilelist = D('Product_whitelist')->where(array('supplier_id'=>$store_id,'seller_id'=>$this->store_session['store_id']))->select();

        $whilelists = array();
        foreach($whilelist as $while){
            array_push($whilelists,$while['product_id']);
        }

        //供货商店铺信息
        $supplier_store_info = $store->getStore($store_id);

        //供货商帐号信息
        $margin_account = D('Margin_account')->where(array('store_id'=>$store_id))->find();

        //是否提交审核资料
        $authen = D('Certification')->where(array ('store_id' => $this->store_session['store_id'],'supplier_id'=>$store_id))->count('id');

        /**
         *判断是否已成为非排他批发商
         */
        $is_open_store_whole = false;
        $supplier_list = D('Supp_dis_relation')->field('supplier_id')->where(array('distributor_id'=>$this->store_session['store_id']))->select();
        if(!empty($supplier_list)) {
            foreach ($supplier_list as $supplier_id) {
                $open_store_whole = D('Store')->field('open_store_whole')->where(array('store_id' => $supplier_id['supplier_id']))->find();
                if (empty($open_store_whole['open_store_whole'])) {
                    $is_open_store_whole = true;
                }
            }
        }

        //是否通过审核
        $is_authen = D('Supp_dis_relation')->where(array ('supplier_id' => $store_id, 'distributor_id' => $this->store_session['store_id']))->count('id');

        //保证金余额
        $bond = D('Supp_dis_relation')->where(array ('supplier_id' => $store_id, 'distributor_id' => $this->store_session['store_id']))->find();

        $where['status'] = 1;
        $where['store_id'] = $store_id;
        if (!empty($_POST['category_id'])) {
            $where['category_id'] = intval(trim($_POST['category_id']));
        }
        if (!empty($_POST['category_fid'])) {
            $where['category_fid'] = intval(trim($_POST['category_fid']));
        }
        if (!empty($keyword)) {
            $where['name'] = array ('like' => '%'.$keyword.'%');
        }

        $product_total = $product->getMarketTotal($where, $is_authen, $store_id);
        import('source.class.user_page');
        $page = new Page($product_total, 15);

        $tmp_products = $product->getMarketProduct($where, $page->firstRow, $page->listRows,$is_authen, $store_id);
        $products = array ();
        foreach ($tmp_products as $tmp_product){
            //是否是白名单商品
            $whitelist_product = D('Product_whitelist')->where(array('product_id'=>$tmp_product['product_id']))->count('pigcms_id');

            if($whitelist_product>0) {
                $is_whitelist = 1;
            }else {
                $is_whitelist = 0;
            }

            $supplier = D('Store')->field('name,store_id')->where(array ('store_id' => $tmp_product['store_id']))->find();
            $tmp_product['supplier'] = $supplier['name'];
            $tmp_product['supplier_id'] = $supplier['store_id'];
            $tmp_product['is_whitelist'] = $is_whitelist;

            if (empty($this->store_session['drp_diy_store'])){
                $drp_level = $this->store_session['drp_level'];
                if ($drp_level > 3){
                    $drp_level = 3;
                }
                if ($store_info['drp_level'] == 0) {
                    $tmp_product['wholesale_price'] = !empty($tmp_product['wholesale_price']) ? $tmp_product['wholesale_price'] : '0';
                    $tmp_product['sale_min_price'] = !empty($tmp_product['sale_min_price']) ? $tmp_product['sale_min_price'] : '0';
                    $tmp_product['sale_max_price'] = !empty($tmp_product['sale_max_price']) ? $tmp_product['sale_max_price'] : '0';
                } else {
                    $tmp_product['cost_price'] = !empty($tmp_product['cost_price']) ? $tmp_product['cost_price'] : '0';
                    $tmp_product['min_fx_price'] = !empty($tmp_product['min_fx_price']) ? $tmp_product['min_fx_price'] : '0';
                    $tmp_product['max_fx_price'] = !empty($tmp_product['max_fx_price']) ? $tmp_product['max_fx_price'] : '0';
                }
            }
            $products[] = $tmp_product;
        }

        //商品分类
        $category = M('Product_category');
        $categories = $category->getCategories(array ('cat_status' => 1), 'cat_path ASC');

        $tmp_fx_products = $product->fxProducts($this->store_session['store_id']);

        $fx_products = array ();
        foreach ($tmp_fx_products as $tmp_fx_product){
            $fx_products[] = $tmp_fx_product['source_product_id'];
        }

        $wholesale_products = array ();
        foreach ($tmp_fx_products as $tmp_fx_product)  {
            $wholesale_products[] = $tmp_fx_product['wholesale_product_id'];
        }

        $this->assign('bond', $bond);
        $this->assign('authen', $authen);
        $this->assign('is_authen', $is_authen);
        $this->assign('supplier_store_info', $supplier_store_info);
        $this->assign('store_id', $store_id);
        $this->assign('page', $page->show());
        $this->assign('products', $products);
        $this->assign('categories', $categories);
        $this->assign('fx_products', $fx_products);
        $this->assign('wholesale_products', $wholesale_products);
        $this->assign('product_total', $product_total);
        $this->assign('type', $type);
        $this->assign('margin_account', $margin_account);
        $this->assign('whilelists', $whilelists);
        $this->assign('is_open_store_whole', $is_open_store_whole);
    }

    //已分销商品
    public function goods()
    {
        $this->display();
    }

    private function _goods_content()
    {
        $product = M('Product');
        $store = M('Store');

        $supplier_id = $this->store_session['root_supplier_id'];
        $product_count = $product->fxProductCount(array ('store_id' => $supplier_id, 'is_fx' => 1));

        import('source.class.user_page');
        $page = new Page($product_count, 15);
        $order_by_field = 'product_id';
        $order_by_method = 'DESC';
        $where = array ('status' => 1, 'is_fx' => 1, 'store_id' => $supplier_id);
        $tmp_products = $product->getSelling($where, $order_by_field, $order_by_method, $page->firstRow, $page->listRows);
        $products = array ();
        //供货商
        $supplier = $store->getStore($supplier_id);
        //分销级别
        $drp_level = $this->store_session['drp_level'];
        if ($drp_level > 3) {
            $drp_level = 3;
        }
        foreach ($tmp_products as $tmp_product) {

            $sql = "SELECT SUM(op.pro_num) AS sales FROM " . option('system.DB_PREFIX') . "order_product op, " . option("system.DB_PREFIX") . "order o WHERE op.order_id = o.order_id AND o.store_id = '" . $this->store_session['store_id'] . "' AND op.product_id = '" . $tmp_product['product_id'] . "'";
            $result = D('')->query($sql);
            $sales = !empty($result[0]['sales']) ? $result[0]['sales'] : 0;
            $sql = "SELECT SUM(rp.pro_num) AS return_num FROM " . option('system.DB_PREFIX') . "return_product rp, " . option('system.DB_PREFIX') . "return r WHERE rp.return_id = r.id AND r.store_id = '" . $this->store_session['store_id'] . "' AND rp.product_id = '" . $tmp_product['product_id'] . "' AND r.user_return_id = 0";
            $result = D('')->query($sql);
            $return_num = !empty($result[0]['return_num']) ? $result[0]['return_num'] : 0;
            //减退货
            $sales -= $return_num;

            $min_fx_price = ($tmp_product['min_fx_price'] > 0) ? $tmp_product['min_fx_price'] : $tmp_product['max_fx_price'];
            $max_fx_price = ($tmp_product['max_fx_price'] > 0) ? $tmp_product['max_fx_price'] : $tmp_product['min_fx_price'];
            //分销价
            if ($min_fx_price == $max_fx_price) {
                $fx_price = number_format($min_fx_price, 2, '.', '');
            } else {
                $fx_price = number_format($min_fx_price, 2, '.', '') . '~' . number_format($max_fx_price, 2, '.', '');
            }
            //分销利润
            if ($drp_level == 3) {
                $fx_profit = $tmp_product['drp_level_' . $drp_level . '_price'] - $tmp_product['drp_level_' . $drp_level . '_cost_price'];
            } else {
                $fx_profit = $tmp_product['drp_level_' . ($drp_level + 1) . '_cost_price'] - $tmp_product['drp_level_' . $drp_level . '_cost_price'];
            }
            $products[] = array (
                'store_id' => $tmp_product['store_id'],
                'product_id' => $tmp_product['product_id'],
                'name' => $tmp_product['name'],
                'image' => getAttachmentUrl($tmp_product['image']),
                'min_fx_price' => $tmp_product['min_fx_price'],
                'max_fx_price' => $tmp_product['max_fx_price'],
                'quantity' => $tmp_product['quantity'],
                'sales' => $sales,
                'supplier' => $supplier['name'],
                'fx_price' => $fx_price,
                'fx_profit' => number_format($fx_profit, 2, '.', '')
            );

        }

        $this->assign('drp_level', $drp_level);
        $this->assign('products', $products);
        $this->assign('page', $page->show());
    }

    //编辑分销商品
    public function edit_goods()
    {
        if (IS_POST) {
            $product = M('Product');
            $product_sku    = M('Product_sku');
            $product_id     = !empty($_POST['product_id']) ? intval(trim($_POST['product_id'])) : 0;
            $cost_price     = !empty($_POST['cost_price']) ? floatval(trim($_POST['cost_price'])) : 0;
            $min_fx_price   = !empty($_POST['min_fx_price']) ? floatval(trim($_POST['min_fx_price'])) : 0;
            $max_fx_price   = !empty($_POST['max_fx_price']) ? floatval(trim($_POST['max_fx_price'])) : 0;
            $is_recommend   = !empty($_POST['is_recommend']) ? intval(trim($_POST['is_recommend'])) : 0;
            $unified_profit = !empty($_POST['unified_profit']) ? intval(trim($_POST['unified_profit'])) : 0;
            //供货商统一设置分销
            $unified_price_setting = 1;
            $is_fx_setting = 1;
            $page = !empty($_POST['p']) ? $_POST['p'] : 1; //当前分页数
            $skus = !empty($_POST['skus']) ? $_POST['skus'] : array ();
            //分销商等级利润
            $degrees_profit = !empty($_POST['degrees_profit']) ? $_POST['degrees_profit'] : array();
            $fx_type = 0; //分销类型 0全网、1排他
            if (strtolower(trim($_GET['role'])) == 'seller' || !empty($this->store_session['drp_supplier_id'])) {
                $fx_type = 1;
            }
            //统一零售价
            $unified_price = !empty($_POST['unified_price']) ? $_POST['unified_price'] : 0;

            $data = array (
                'cost_price'            => $cost_price,
                'min_fx_price'          => $min_fx_price,
                'max_fx_price'          => $max_fx_price,
                'is_recommend'          => $is_recommend,
                'unified_profit'        => $unified_profit,
                'is_fx'                 => 1, // 1 为已分销商品
                'fx_type'               => $fx_type,
                'is_fx_setting'         => $is_fx_setting,
                'unified_price_setting' => $unified_price_setting,
                'unified_price'         => $unified_price
            );
            $product_info = M('Product')->get(array ('product_id' => $product_id, 'store_id' => $_SESSION['store']['store_id']));

            $data['cost_price'] = !empty($_POST['cost_price']) ? $_POST['cost_price'] : 0;
            $data['min_fx_price'] = !empty($_POST['min_fx_price']) ? $_POST['min_fx_price'] : 0;
            $data['max_fx_price'] = !empty($_POST['max_fx_price']) ? $_POST['max_fx_price'] : 0;
            $data['drp_level_1_cost_price'] = !empty($_POST['drp_level_1_cost_price']) ? $_POST['drp_level_1_cost_price'] : 0;
            $data['drp_level_2_cost_price'] = !empty($_POST['drp_level_2_cost_price']) ? $_POST['drp_level_2_cost_price'] : 0;
            $data['drp_level_3_cost_price'] = !empty($_POST['drp_level_3_cost_price']) ? $_POST['drp_level_3_cost_price'] : 0;
            $data['drp_level_1_price'] = !empty($_POST['drp_level_1_price']) ? $_POST['drp_level_1_price'] : 0;
            $data['drp_level_2_price'] = !empty($_POST['drp_level_2_price']) ? $_POST['drp_level_2_price'] : 0;
            $data['drp_level_3_price'] = !empty($_POST['drp_level_3_price']) ? $_POST['drp_level_3_price'] : 0;
            $data['last_edit_time']    = time();
            $data['drp_custom_setting'] = 1;

            $result = D('Product')->where(array ('product_id' => $product_id))->data($data)->save();
            if (count($skus) > 0) {
                $result_sku = $product_sku->fx_Goods_Edit($product_id, $skus, $unified_price_setting);
            }

            if ($result || $result_sku) {

                //处理商品分销等级
                $check_drp_degree = M('Drp_degree')->checkDrpDegree($this->store_session['store_id']);
                if ($check_drp_degree && !empty($degrees_profit)) {
                    foreach ($degrees_profit as $degree_id => $degree_profit) {
                        if (!empty($degree_profit) && $degree_id > 0) {
                            $product_drp_degree = M('Product_drp_degree')->getDrpDegree(array('product_id' => $product_id, 'degree_id' => $degree_id));
                            //修改
                            if (!empty($product_drp_degree)) {
                                $data = array();
                                $data['seller_reward_1'] = $degree_profit[1]; //一级分销商利润比
                                $data['seller_reward_2'] = $degree_profit[2]; //二级分销商利润比
                                $data['seller_reward_3'] = $degree_profit[3]; //三级分销商利润比
                                D('Product_drp_degree')->where(array('product_id' => $product_id, 'degree_id' => $degree_id, 'store_id' => $this->store_session['store_id']))->data($data)->save();
                            } else { //新增
                                $data = array();
                                $data['product_id']      = $product_id;
                                $data['store_id']        = $this->store_session['store_id'];
                                $data['degree_id']       = $degree_id; //分销等级id
                                $data['seller_reward_1'] = $degree_profit[1]; //一级分销商利润比
                                $data['seller_reward_2'] = $degree_profit[2]; //二级分销商利润比
                                $data['seller_reward_3'] = $degree_profit[3]; //三级分销商利润比
                                D('Product_drp_degree')->data($data)->add();
                            }
                        }
                    }
                }
                if($type == 1){
                    json_return(0,$type);
                } else if (empty($type)){
                    json_return(0, url('supplier_market',array('is'=>1,'page'=>$page)));
                }
            } else {
                json_return(1001, '保存失败');
            }
        }
        $this->display();
    }

    private function _edit_goods_content()
    {
        $product = M('Product');
        $category = M('Product_category');
        $product_property = M('Product_property');
        $product_property_value = M('Product_property_value');
        $product_to_property = M('Product_to_property');
        $product_to_property_value = M('Product_to_property_value');
        $product_sku = M('Product_sku');

        $id = isset($_POST['id']) ? intval(trim($_POST['id'])) : 0;

        $product = $product->get(array('product_id' => $id, 'store_id' => $this->store_session['store_id']));

        if (!empty($product['category_id']) && !empty($product['category_fid'])) {
            $parent_category = $category->getCategory($product['category_fid']);
            $category = $category->getCategory($product['category_id']);
            $product['category'] = $parent_category['cat_name'] . ' - ' . $category['cat_name'];
        } else if ($product['category_fid']) {
            $category = $category->getCategory($product['category_fid']);
            $product['category'] = $category['cat_name'];
        } else {
            $category = $category->getCategory($product['category_id']);
            $product['category'] = !empty($category['cat_name']) ? $category['cat_name'] : '其它';
        }

        $min_cost_price_sku = array();
        $min_sale_price_sku = array();
        $max_sale_price_sku = array();

        $pids = $product_to_property->getPids($this->store_session['store_id'], $id);
        if (!empty($pids[0]['pid']))
        {
            $pid = $pids[0]['pid'];
            $name = $product_property->getName($pid);
            $vids = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid);
            if (!empty($pids[1]['pid']) && !empty($pids[2]['pid']))
            {
                $pid1 = $pids[1]['pid'];
                $name1 = $product_property->getName($pid1);
                $vids1 = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid1);
                $pid2 = $pids[2]['pid'];
                $name2 = $product_property->getName($pid2);
                $vids2 = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid2);
                $html = '<thead>';
                $html .= '    <tr>';
                $html .= '        <th class="text-center" width="80">' . $name . '</th>';
                $html .= '        <th class="text-center" width="80">' . $name1 . '</th>';
                $html .= '        <th class="text-center" width="80">' . $name2 . '</th>';
                $html .= '        <th class="th-price" style="width: 70px;text-align: center">成本价（元）</th>';
                $html .= '        <th class="th-price" style="width: 105px;text-align: center">分销价（元）</th>';
                $html .= '    </tr>';
                $html .= '</thead>';
                $html .= '<tbody>';

                $html2 = '<thead>';
                $html2 .= '    <tr>';
                $html2 .= '        <th class="text-center" width="80">' . $name . '</th>';
                $html2 .= '        <th class="text-center" width="80">' . $name1 . '</th>';
                $html2 .= '        <th class="text-center" width="80">' . $name2 . '</th>';
                $html2 .= '        <th class="th-price" style="width: 70px;text-align: center">成本价（元）</th>';
                $html2 .= '        <th class="th-price" style="width: 105px;text-align: center">分销价（元）</th>';
                $html2 .= '    </tr>';
                $html2 .= '</thead>';
                $html2 .= '<tbody>';

                $html3 = '<thead>';
                $html3 .= '    <tr>';
                $html3 .= '        <th class="text-center" width="80">' . $name . '</th>';
                $html3 .= '        <th class="text-center" width="80">' . $name1 . '</th>';
                $html3 .= '        <th class="text-center" width="80">' . $name2 . '</th>';
                $html3 .= '        <th class="th-price" style="width: 70px;text-align: center">成本价（元）</th>';
                $html3 .= '        <th class="th-price" style="width: 105px;text-align: center">分销价（元）</th>';
                $html3 .= '    </tr>';
                $html3 .= '</thead>';
                $html3 .= '<tbody>';
                foreach ($vids as $key => $vid)
                {
                    $value = $product_property_value->getValue($pid, $vid['vid']);
                    foreach ($vids1 as $key1 => $vid1)
                    {
                        $value1 = $product_property_value->getValue($pid1, $vid1['vid']);
                        foreach ($vids2 as $key2 => $vid2)
                        {
                            $properties = $pid . ':' . $vid['vid'] . ';' . $pid1 . ':' . $vid1['vid'] . ';' . $pid2 . ':' . $vid2['vid'];
                            $sku = $product_sku->getSku($id, $properties);
                            $html .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                            $html2 .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                            $html3 .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                            $value2 = $product_property_value->getValue($pid2, $vid2['vid']);
                            if ($key1 == 0 && $key2 == 0)
                            {
                                $html .= '    <td class="text-center" rowspan="' . count($vids1) * count($vids2) . '">' . $value . '</td>';
                                $html2 .= '    <td class="text-center" rowspan="' . count($vids1) * count($vids2) . '">' . $value . '</td>';
                                $html3 .= '    <td class="text-center" rowspan="' . count($vids1) * count($vids2) . '">' . $value . '</td>';
                            }
                            if ($key2 == 0)
                            {
                                $html .= '    <td class="text-center" rowspan="' . count($vids2) . '">' . $value1 . '</td>';
                                $html2 .= '    <td class="text-center" rowspan="' . count($vids2) . '">' . $value1 . '</td>';
                                $html3 .= '    <td class="text-center" rowspan="' . count($vids2) . '">' . $value1 . '</td>';
                            }
                            $html .= '        <td class="text-center" width="50">' . $value2 . '</td>';
                            $html .= '        <td style="text-align: center"><input type="text" name="cost_sku_price" class="js-cost-price input-mini" data-min-cost-price="' . $sku['wholesale_price'] . '" data-min-sale-price="' . (($sku['sale_min_price'] > 0) ? $sku['sale_min_price'] : $sku['price']) . '" maxlength="10" value=' . $sku['drp_level_1_cost_price'] . ' ></td>';
                            $html .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price js-fx-min-price input-mini" data-min-price="' . $sku['sale_min_price'] . '" data-max-price="' . $sku['sale_max_price'] . '" maxlength="10" value=' . $sku['drp_level_1_price'] . ' ></td>';
                            $html .= '    </tr>';

                            $html2 .= '        <td class="text-center" width="50">' . $value2 . '</td>';
                            $html2 .= '        <td style="text-align: center"><input type="text" name="cost_sku_price" class="js-cost-price input-mini" data-min-cost-price="' . $sku['wholesale_price'] . '" data-min-sale-price="' . (($sku['sale_min_price'] > 0) ? $sku['sale_min_price'] : $sku['price']) . '" maxlength="10" value=' . $sku['drp_level_2_cost_price'] . ' ></td>';
                            $html2 .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price js-fx-min-price input-mini" data-min-price="' . $sku['sale_min_price'] . '" data-max-price="' . $sku['sale_max_price'] . '" maxlength="10" value=' . $sku['drp_level_2_price'] . ' ></td>';
                            $html2 .= '    </tr>';

                            $html3 .= '        <td class="text-center" width="50">' . $value2 . '</td>';
                            $html3 .= '        <td style="text-align: center"><input type="hidden" value="'.$sku['price'].'" class="hidden_cost_sku_price"><input type="text" name="cost_sku_price" class="js-cost-price input-mini" data-min-cost-price="' . $sku['wholesale_price'] . '" data-min-sale-price="' . (($sku['sale_min_price'] > 0) ? $sku['sale_min_price'] : $sku['price']) . '" maxlength="10" value=' . $sku['drp_level_3_cost_price'] . ' ></td>';
                            $html3 .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price js-fx-min-price input-mini" data-min-price="' . $sku['sale_min_price'] . '" data-max-price="' . $sku['sale_max_price'] . '" maxlength="10" value=' . $sku['drp_level_3_price'] . ' ></td>';
                            $html3 .= '    </tr>';

                            $min_cost_price_sku[] = $sku['wholesale_price'];
                            $min_sale_price_sku[] = $sku['sale_min_price'];
                            $max_sale_price_sku[] = $sku['sale_max_price'];
                        }
                    }
                }
            }
            else if (!empty($pids[1]['pid']))
            {
                $pid1 = $pids[1]['pid'];
                $name1 = $product_property->getName($pid1);
                $vids1 = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid1);
                $html = '<thead>';
                $html .= '    <tr>';
                $html .= '        <th class="text-center" width="50">' . $name . '</th>';
                $html .= '        <th class="text-center" width="50">' . $name1 . '</th>';
                $html .= '        <th class="th-price" style="text-align: center">成本价（元）</th>';
                $html .= '        <th class="th-price" style="width: 105px;text-align: center">分销价（元）</th>';
                $html .= '    </tr>';
                $html .= '</thead>';
                $html .= '<tbody>';

                $html2 = '<thead>';
                $html2 .= '    <tr>';
                $html2 .= '        <th class="text-center" width="50">' . $name . '</th>';
                $html2 .= '        <th class="text-center" width="50">' . $name1 . '</th>';
                $html2 .= '        <th class="th-price" style="text-align: center">成本价（元）</th>';
                $html2 .= '        <th class="th-price" style="width: 105px;text-align: center">分销价（元）</th>';
                $html2 .= '    </tr>';
                $html2 .= '</thead>';
                $html2 .= '<tbody>';

                $html3 = '<thead>';
                $html3 .= '    <tr>';
                $html3 .= '        <th class="text-center" width="50">' . $name . '</th>';
                $html3 .= '        <th class="text-center" width="50">' . $name1 . '</th>';
                $html3 .= '        <th class="th-price" style="text-align: center">成本价（元）</th>';
                $html3 .= '        <th class="th-price" style="width: 105px;text-align: center">分销价（元）</th>';
                $html3 .= '    </tr>';
                $html3 .= '</thead>';
                $html3 .= '<tbody>';
                foreach ($vids as $key => $vid)
                {
                    $value = $product_property_value->getValue($pid, $vid['vid']);
                    foreach ($vids1 as $key1 => $vid1)
                    {
                        $properties = $pid . ':' . $vid['vid'] . ';' . $pid1 . ':' . $vid1['vid'];
                        $sku = $product_sku->getSku($id, $properties);
                        $html .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';

                        $html2 .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';

                        $html3 .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                        $value1 = $product_property_value->getValue($pid1, $vid1['vid']);
                        if ($key1 == 0)
                        {
                            $html .= '    <td class="text-center" rowspan="' . count($vids1) . '">' . $value . '</td>';

                            $html2 .= '    <td class="text-center" rowspan="' . count($vids1) . '">' . $value . '</td>';

                            $html3 .= '    <td class="text-center" rowspan="' . count($vids1) . '">' . $value . '</td>';
                        }
                        $html .= '        <td class="text-center" width="50">' . $value1 . '</td>';
                        $html .= '        <td style="text-align: center"><input type="text" name="cost_sku_price" class="js-cost-price input-mini" data-min-cost-price="' . $sku['wholesale_price'] . '" data-min-sale-price="' . (($sku['sale_min_price'] > 0) ? $sku['sale_min_price'] : $sku['price']) . '" maxlength="10" value=' . $sku['drp_level_1_cost_price'] . ' /></td>';
                        $html .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price input-mini" data-min-price="' . $sku['sale_min_price'] . '" data-max-price="' . $sku['sale_max_price'] . '" maxlength="10" value=' . $sku['drp_level_1_price'] . ' /></td>';
                        $html .= '    </tr>';

                        $html2 .= '        <td class="text-center" width="50">' . $value1 . '</td>';
                        $html2 .= '        <td style="text-align: center"><input type="text" name="cost_sku_price" class="js-cost-price input-mini" data-min-cost-price="' . $sku['wholesale_price'] . '" data-min-sale-price="' . (($sku['sale_min_price'] > 0) ? $sku['sale_min_price'] : $sku['price']) . '" maxlength="10" value=' . $sku['drp_level_2_cost_price'] . ' /></td>';
                        $html2 .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price input-mini" data-min-price="' . $sku['sale_min_price'] . '" data-max-price="' . $sku['sale_max_price'] . '" maxlength="10" value=' . $sku['drp_level_2_price'] . ' /></td>';
                        $html2 .= '    </tr>';

                        $html3 .= '        <td class="text-center" width="50">' . $value1 . '</td>';
                        $html3 .= '        <td style="text-align: center"><input type="hidden" value="'.$sku['price'].'" class="hidden_cost_sku_price"><input type="text" name="cost_sku_price" class="js-cost-price input-mini" data-min-cost-price="' . $sku['wholesale_price'] . '" data-min-sale-price="' . (($sku['sale_min_price'] > 0) ? $sku['sale_min_price'] : $sku['price']) . '" maxlength="10" value=' . $sku['drp_level_3_cost_price'] . ' /></td>';
                        $html3 .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price input-mini" data-min-price="' . $sku['sale_min_price'] . '" data-max-price="' . $sku['sale_max_price'] . '" maxlength="10" value=' . $sku['drp_level_3_price'] . ' /></td>';
                        $html3 .= '    </tr>';

                        $min_cost_price_sku[] = $sku['wholesale_price'];
                        $min_sale_price_sku[] = $sku['sale_min_price'];
                        $max_sale_price_sku[] = $sku['sale_max_price'];
                    }
                }
            }
            else
            {
                $html = '<thead>';
                $html .= '    <tr>';
                $html .= '        <th class="text-center" width="50">' . $name . '</th>';
                $html .= '        <th class="th-price" style="text-align: center">成本价（元）</th>';
                $html .= '        <th class="th-price" style="width: 105px;text-align: center">分销价（元）</th>';
                $html .= '    </tr>';
                $html .= '</thead>';
                $html .= '<tbody>';

                $html2 = '<thead>';
                $html2 .= '    <tr>';
                $html2 .= '        <th class="text-center" width="50">' . $name . '</th>';
                $html2 .= '        <th class="th-price" style="text-align: center">成本价（元）</th>';
                $html2 .= '        <th class="th-price" style="width: 105px;text-align: center">分销价（元）</th>';
                $html2 .= '    </tr>';
                $html2 .= '</thead>';
                $html2 .= '<tbody>';

                $html3 = '<thead>';
                $html3 .= '    <tr>';
                $html3 .= '        <th class="text-center" width="50">' . $name . '</th>';
                $html3 .= '        <th class="th-price" style="text-align: center">成本价（元）</th>';
                $html3 .= '        <th class="th-price" style="width: 105px;text-align: center">分销价（元）</th>';
                $html3 .= '    </tr>';
                $html3 .= '</thead>';
                $html3 .= '<tbody>';
                foreach ($vids as $key => $vid)
                {
                    $value = $product_property_value->getValue($pid, $vid['vid']);
                    $properties = $pid . ':' . $vid['vid'];
                    $sku = $product_sku->getSku($id, $properties);
                    $html .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                    $html2 .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                    $html3 .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                    $value = $product_property_value->getValue($pid, $vid['vid']);
                    $html .= '        <td class="text-center" width="50">' . $value . '</td>';
                    $html .= '        <td style="text-align: center"><input type="text" name="cost_sku_price" class="js-cost-price input-mini" data-min-cost-price="' . $sku['wholesale_price'] . '" data-min-sale-price="' . (($sku['sale_min_price'] > 0) ? $sku['sale_min_price'] : $sku['price']) . '" maxlength="10" value=' . $sku['drp_level_1_cost_price'] . ' /></td>';
                    $html .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price input-mini" data-min-price="' . $sku['sale_min_price'] . '" data-max-price="' . $sku['sale_max_price'] . '" maxlength="10" value=' . $sku['drp_level_1_price'] . ' /></td>';
                    $html .= '    </tr>';

                    $html2 .= '        <td class="text-center" width="50">' . $value . '</td>';
                    $html2 .= '        <td style="text-align: center"><input type="text" name="cost_sku_price" class="js-cost-price input-mini" data-min-cost-price="' . $sku['wholesale_price'] . '" data-min-sale-price="' . (($sku['sale_min_price'] > 0) ? $sku['sale_min_price'] : $sku['price']) . '" maxlength="10" value=' . $sku['drp_level_2_cost_price'] . ' /></td>';
                    $html2 .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price input-mini" data-min-price="' . $sku['sale_min_price'] . '" data-max-price="' . $sku['sale_max_price'] . '" maxlength="10" value=' . $sku['drp_level_2_price'] . ' /></td>';
                    $html2 .= '    </tr>';

                    $html3 .= '        <td class="text-center" width="50">' . $value . '</td>';
                    $html3 .= '        <td style="text-align: center"><input type="hidden" value="'.$sku['price'].'" class="hidden_cost_sku_price"><input type="text" name="cost_sku_price" class="js-cost-price input-mini" data-min-cost-price="' . $sku['wholesale_price'] . '" data-min-sale-price="' . (($sku['sale_min_price'] > 0) ? $sku['sale_min_price'] : $sku['price']) . '" maxlength="10" value=' . $sku['drp_level_3_cost_price'] . ' /></td>';
                    $html3 .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price input-mini" data-min-price="' . $sku['sale_min_price'] . '" data-max-price="' . $sku['sale_max_price'] . '" maxlength="10" value=' . $sku['drp_level_3_price'] . ' /></td>';
                    $html3 .= '    </tr>';

                    $min_cost_price_sku[] = $sku['wholesale_price'];
                    $min_sale_price_sku[] = $sku['sale_min_price'];
                    $max_sale_price_sku[] = $sku['sale_max_price'];
                }
            }

            $html .= '</tbody><tfoot><tr><td colspan="6"><div class="batch-opts">批量设置： <span class="js-batch-type"><a class="js-batch-cost" href="javascript:;">成本价</a>&nbsp;&nbsp;<a class="js-batch-price" href="javascript:;">分销价</a></span><span class="js-batch-form" style="display:none;"></span></div></td></tr></tfoot>';
            $html2 .= '</tbody><tfoot><tr><td colspan="6"><div class="batch-opts">批量设置： <span class="js-batch-type"><a class="js-batch-cost" href="javascript:;">成本价</a>&nbsp;&nbsp;<a class="js-batch-price" href="javascript:;">分销价</a></span><span class="js-batch-form" style="display:none;"></span></div></td></tr></tfoot>';
            $html3 .= '</tbody><tfoot><tr><td colspan="6"><div class="batch-opts">批量设置： <span class="js-batch-type"><a class="js-batch-cost" href="javascript:;">成本价</a>&nbsp;&nbsp;<a class="js-batch-price" href="javascript:;">分销价</a></span><span class="js-batch-form" style="display:none;"></span></div></td></tr></tfoot>';
        } else {
            $min_cost_price_sku[] = $product['wholesale_price'];
            $min_sale_price_sku[] = $product['sale_min_price'];
            $max_sale_price_sku[] = $product['sale_max_price'];
        }

        //分销商等级
        $check_drp_degree = M('Drp_degree')->checkDrpDegree($this->store_session['store_id']);
        if ($check_drp_degree) {
            $drp_degrees = M('Drp_degree')->getDrpDegrees(array('store_id' => $this->store_session['store_id'], 'status' => 1));
            if (!empty($drp_degrees)) {
                foreach ($drp_degrees as &$drp_degree) {
                    $product_drp_degree = M('Product_drp_degree')->getDrpDegree(array('product_id' => $id, 'degree_id' => $drp_degree['pigcms_id']));
                    if (!empty($product_drp_degree)) {
                        $drp_degree['seller_reward_1'] = $product_drp_degree['seller_reward_1'];
                        $drp_degree['seller_reward_2'] = $product_drp_degree['seller_reward_2'];
                        $drp_degree['seller_reward_3'] = $product_drp_degree['seller_reward_3'];
                    }
                }
            }
            $this->assign('drp_degrees', $drp_degrees);
        }

        $product['min_cost_price'] = min($min_cost_price_sku);
        $product['min_sale_price'] = min($min_sale_price_sku);
        $product['max_sale_price'] = min($max_sale_price_sku);

        //统一分销利润
        //if (!empty($product['unified_price'])) {
            $product['drp_level_1_profit'] = ($product['drp_level_2_cost_price'] - $product['drp_level_1_cost_price']);
            $product['drp_level_2_profit'] = ($product['drp_level_3_cost_price'] - $product['drp_level_2_cost_price']);
            $product['drp_level_3_profit'] = ($product['drp_level_3_price'] - $product['drp_level_3_cost_price']);
            $product['drp_level_1_profit'] = ($product['drp_level_1_profit'] > 0) ? number_format($product['drp_level_1_profit'], 2, '.', '') : '0.00';
            $product['drp_level_2_profit'] = ($product['drp_level_2_profit'] > 0) ? number_format($product['drp_level_2_profit'], 2, '.', '') : '0.00';
            $product['drp_level_3_profit'] = ($product['drp_level_3_profit'] > 0) ? number_format($product['drp_level_3_profit'], 2, '.', '') : '0.00';
        //}

        //最低分销
        $fx_price_min = min($product['drp_level_1_price'], $product['drp_level_2_price'], $product['drp_level_3_price']);
        $fx_price_min = ($fx_price_min > 0) ? $fx_price_min : $product['price'];

        $this->assign('sku_content', $html);
        $this->assign('sku_content2', $html2);
        $this->assign('sku_content3', $html3);
        $this->assign('product', $product);
        $this->assign('fx_price_min', number_format($fx_price_min, 2, '.', ''));
    }

    //分销订单
    public function orders()
    {
        $this->display();
    }

    private function _orders_content()
    {
        $order = M('Order');
        $order_product = M('Order_product');
        $user = M('User');
        $where = array ();
        $where['store_id'] = $this->store_session['store_id'];

        if (is_numeric($_POST['order_no']))
        {
            $where['order_no'] = $_POST['order_no'];
        }
        if (!empty($_POST['delivery_user']))
        {
            $where['address_user'] = $_POST['delivery_user'];
        }
        if (!empty($_POST['delivery_tel']))
        {
            $where['address_tel'] = $_POST['delivery_tel'];
        }

        $field = '';
        if (!empty($data['time_type']))
        {
            $field = $data['time_type'];
        }
        if (!empty($data['start_time']) && !empty($_POST['stop_time']) && !empty($field))
        {
            $where['_string'] = "`" . $field . "` >= " . strtotime($_POST['start_time']) . " AND `" . $field . "` <= " . strtotime($_POST['stop_time']);
        }
        else if (!empty($_POST['start_time']) && !empty($field))
        {
            $where[$field] = array ('>=', strtotime($data['start_time']));
        }
        else if (!empty($_POST['stop_time']) && !empty($field))
        {
            $where[$field] = array ('<=', strtotime($_POST['stop_time']));
        }
        //排序
        if (!empty($_POST['orderbyfield']) && !empty($_POST['orderbymethod']))
        {
            $orderby = "`{$_POST['orderbyfield']}` " . $_POST['orderbymethod'];
        }
        else
        {
            $orderby = '`order_id` DESC';
        }

        $order_total = $order->getOrderTotal($where);
        import('source.class.user_page');
        $page = new Page($order_total, 15);
        $tmp_orders = $order->getOrders($where, $orderby, $page->firstRow, $page->listRows);
        $orders = array ();
        foreach ($tmp_orders as $tmp_order)
        {
            $products = $order_product->getProducts($tmp_order['order_id']);
            $tmp_order['products'] = $products;
            if (empty($tmp_order['uid']))
            {
                $tmp_order['is_fans'] = FALSE;
                $tmp_order['buyer'] = '';
            }
            else
            {
                $tmp_order['is_fans'] = TRUE;
                $user_info = $user->checkUser(array ('uid' => $tmp_order['uid']));
                $tmp_order['buyer'] = $user_info['nickname'];
            }

            // 是否有退货未完成的申请，有未完成的申请，暂时不给完成订单
            if ($tmp_order['status'] == 7)
            {
                $count = D('Return')->where("order_id = '" . $tmp_order['order_id'] . "' AND status IN (1, 3, 4)")->count('id');
                $tmp_order['returning_count'] = $count;
            }

            $is_supplier = FALSE;
            $is_packaged = FALSE;
            $is_assigned = FALSE;
            if (!empty($tmp_order['suppliers']))
            { //订单供货商
                $suppliers = explode(',', $tmp_order['suppliers']);
                if (in_array($this->store_session['store_id'], $suppliers))
                {
                    $is_supplier = TRUE;
                }
            }
            if (empty($tmp_order['suppliers']))
            {
                $is_supplier = TRUE;
            }

            $has_my_product = FALSE;
            foreach ($products as &$product)
            {
                $product['image'] = getAttachmentUrl($product['image']);
                if (empty($product['is_fx']))
                {
                    $has_my_product = TRUE;
                }

                //自营商品
                if (!empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id'])
                {
                    $is_supplier = TRUE;
                }

                //商品来源
                if (empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id'])
                { //本店商品
                    $from = '本店商品';
                }
                else if (!empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id'] && !empty($product['wholesale_product_id']))
                { //批发商品
                    $from = '批发商品';
                }
                else
                { //分销商品
                    $from = '分销商品';
                }
                $product['from'] = $from;

                //向后兼容利润计算
                $no_profit = FALSE;
                if ($product['profit'] == 0)
                {
                    $fx_order = D('Fx_order')->field('fx_order_id')->where(array ('order_id' => $tmp_order['order_id']))->find();
                    $fx_order_product = D('Fx_order_product')->field('cost_price')->where(array ('fx_order_id' => $fx_order['fx_order_id'], 'source_product_id' => $product['product_id']))->find();
                    $product['cost_price'] = $fx_order_product['cost_price'];
                    $product['profit'] = $product['pro_price'] - $product['cost_price'];
                    if ($product['profit'] <= 0)
                    {
                        $product['profit'] = 0;
                        $no_profit = TRUE;
                    }
                }

                $product['cost_price'] = ($product['pro_price'] - $product['profit'] > 0) ? $product['pro_price'] - $product['profit'] : 0;
                if ($product['profit'] == 0 && empty($product['supplier_id']) && empty($no_profit))
                {
                    $product['profit'] = $product['pro_price'];
                    $product['cost_price'] = 0;
                }

                $product['profit'] = number_format($product['profit'], 2, '.', '');
                $product['cost_price'] = number_format($product['cost_price'], 2, '.', '');
            }

            if (!empty($tmp_order['user_order_id']))
            {
                $order_info = D('Order')->field('store_id')->where(array ('order_id' => $tmp_order['user_order_id']))->find();
                $seller = D('Store')->field('name')->where(array ('store_id' => $order_info['store_id']))->find();
                $tmp_order['seller'] = $seller['name'];
            }
            else
            {
                $tmp_order['seller'] = '本店';
            }

            $un_package_selfsale_products = $order_product->getUnPackageProducts(array ('op.order_id' => $tmp_order['order_id'], 'p.store_id' => $this->store_session['store_id'], 'p.supplier_id' => 0));
            if (count($un_package_selfsale_products) == 0)
            {
                $is_packaged = TRUE;
            }

            // TODO 是否分配完毕
            $un_package_physical_products = $order_product->getUnPackageSkuProducts($tmp_order['order_id']);
            if (count($un_package_physical_products) == 0)
            {
                $is_assigned = TRUE;
            }

            $profit = M('Financial_record')->getTotal(array ('order_id' => $tmp_order['order_id']));
            $cost = M('Financial_record')->getTotal(array ('order_id' => $tmp_order['order_id'], 'income' => array ('<', 0)));
            $cost = abs($cost);
            if ($cost <= 0)
            {
                //$cost = $profit;
            }

            $tmp_order['products'] = $products;
            $tmp_order['has_my_product'] = $has_my_product;
            $tmp_order['is_supplier'] = $is_supplier;
            $tmp_order['is_packaged'] = $is_packaged;
            $tmp_order['is_assigned'] = $is_assigned;
            $tmp_order['profit'] = number_format($profit, 2, '.', '');
            $tmp_order['cost'] = number_format($cost, 2, '.', '');
            $orders[] = $tmp_order;
        }

        //订单状态
        $order_status = $order->status();

        //支付方式
        $payment_method = $order->getPaymentMethod();

        $this->assign('order_status', $order_status);
        $this->assign('status', $data['status']);
        $this->assign('payment_method', $payment_method);
        $this->assign('orders', $orders);
        $this->assign('page', $page->show());
    }

    //订单详细
    public function order_detail()
    {
        $this->display();
    }

    private function _order_detail_content()
    {
        $fx_order = M('Fx_order');
        $order = M('Order');
        $order_product = M('Order_product');
        $fx_order_product = M('Fx_order_product');
        $user = M('User');
        $product = M('Product');
        $store = M('Store');
        $package = M('Order_package');

        $store = D('Store')->where(array('store_id' => $this->store_session['store_id']))->find();
        $fx_order_id = intval(trim($_POST['order_id']));
        $fx_order_info = $fx_order->getOrder($this->store_session['store_id'], $fx_order_id);
        $order_id = $fx_order_info['order_id'];
        $order_info = $order->getOrder($this->store_session['store_id'], $order_id);
        $user_order_id = !empty($order_info['user_order_id']) ? $order_info['user_order_id'] : $order_info['order_id'];

        $fx_order_info['shipping_method'] = $order_info['shipping_method'];
        $fx_order_info['address'] = $order_info['address'];
        $fx_order_info['payment_method'] = $order_info['payment_method']; //买家付款方式
        $fx_order_info['buyer_paid_time'] = $order_info['paid_time']; //买家付款时间
        $fx_order_info['comment'] = $order_info['comment']; //买家留言

        $supplier_orders = array();
        if (!empty($store['drp_supplier_id'])) { //分销商
            $supplier_orders[] = $this->_supplier_orders($store['drp_supplier_id'], $user_order_id);
        } else {
            $suppliers = !empty($order_info['suppliers']) ? explode(',', $order_info['suppliers']) : array();
            foreach ($suppliers as $supplier_id) { //经销商/供货商
                $supplier_orders[] = $this->_supplier_orders($supplier_id, $user_order_id);
            }
        }
        $main_order = D('Order')->field('add_time')->where(array ('order_id' => $user_order_id))->find();
        $fx_order_info['add_time'] = $main_order['add_time'];
        $fx_order_info['user'] = '游客';
        if (!empty($fx_order_info['uid'])) {
            $user = D('User')->where(array('uid' => $fx_order_info['uid']))->find();
            $fx_order_info['user'] = !empty($user['nickname']) ? $user['nickname'] : '匿名';
        }
        //分销利润
        $fx_profit = number_format($fx_order_info['total'] - $fx_order_info['cost_total'], 2, '.', '');
        $fx_order_info['fx_profit'] = $fx_profit;
        $tmp_products = $fx_order_product->getFxProducts($fx_order_id);
        $products = array ();
        $comment_count = 0;
        $product_count = 0;

        foreach ($tmp_products as $tmp_product) {
            $product_info = $product->get(array ('product_id' => $tmp_product['product_id']));
            $products[] = array (
                'product_id' => $tmp_product['product_id'],
                'name' => $product_info['name'],
                'cost_price' => $tmp_product['cost_price'],
                'pro_price' => $tmp_product['price'],
                'pro_num' => $tmp_product['quantity'],
                'sku_data' => $tmp_product['sku_data'],
                'image' => $product_info['image'],
                'comment' => $tmp_product['comment'],
                'is_fx' => $tmp_product['is_fx'],
            );
            if (!empty($tmp_product['comment'])) {
                $comment_count++;
            }
            $product_count++;
        }

        $payment_method = $order->getPaymentMethod();
        $status = $fx_order->status_text();

        //获取分销商给供货商下的订单
        $seller_order_info = $order->getSellerOrder($this->user_session['uid'], $fx_order_id);
        $packages = array ();
        if (!empty($seller_order_info)) {
            //包裹
            $packages = $package->getPackages(array ('order_id' => $seller_order_info['order_id'], 'store_id' => $fx_order_info['supplier_id']));
        }

        $this->assign('order', $fx_order_info);
        $this->assign('products', $products);
        $this->assign('payment_method', $payment_method);
        $this->assign('rows', $comment_count + $product_count);
        $this->assign('comment_count', $comment_count);
        $this->assign('status', $status);
        $this->assign('supplier_orders', $supplier_orders);
        $this->assign('packages', $packages);
    }

    //获取上级订单
    private function _supplier_orders($supplier_id, $user_order_id)
    {
        $supplier = D('Store')->field('name')->where(array('store_id' => $supplier_id))->find();
        $supplier_order = D('Order')->field('order_no,payment_method,total,paid_time,use_deposit_pay')->where(array('user_order_id' => $user_order_id, 'store_id' => $supplier_id))->find();
        $payment_method = M('Order')->getPaymentMethod($supplier_order['payment_method']);
        return array(
            'order_no' => $supplier_order['order_no'],
            'supplier' => $supplier['name'],
            'payment_method' => $payment_method,
            'total' => $supplier_order['total'],
            'postage' => $supplier_order['postage'],
            'paid_time' => $supplier_order['paid_time'],
            'use_deposit_pay' => $supplier_order['use_deposit_pay']
        );
    }

    //订单付款(分销商)
    public function pay_order()
    {
        $order = M('Order');
        $order_product = M('Order_product');
        $fx_order = M('Fx_order');
        $fx_order_product = M('Fx_order_product');
        $store = M('Store');
        $financial_record = M('Financial_record');
        $store_supplier = M('Store_supplier');
        $product_model = M('Product');
        $product_sku = M('Product_sku');

        if (IS_POST)
        {
            $data = array ();
            $total = isset($_POST['total']) ? floatval($_POST['total']) : 0; //付款总金额
            $data['total'] = intval($total);
            $data['order_id'] = isset($_POST['order_id']) ? $_POST['order_id'] : '';
            $data['supplier_id'] = isset($_POST['supplier_id']) ? intval($_POST['supplier_id']) : 0;
            $data['seller_id'] = isset($_POST['seller_id']) ? intval($_POST['seller_id']) : 0;
            $data['trade_no'] = isset($_POST['trade_no']) ? trim($_POST['trade_no']) : '';
            $data['salt'] = 'pigcms-weidian-fx-order-pay-to-supplier';
            $timestamp = isset($_POST['timestamp']) ? intval($_POST['timestamp']) : 0;
            $hash = isset($_POST['hash']) ? trim($_POST['hash']) : '';
            ksort($data);
            $hash_new = sha1(http_build_query($data));
            $now = time();
            if (($now - $timestamp) > 360)
            {
                json_return(1001, '请求已过期');
            }
            else if ($hash != $hash_new)
            {
                json_return(1002, '参数无效');
            }
            else
            {
                //付款给供货商
                $fx_order_id = explode(',', $data['order_id']); //合并支付会出现多个订单ID
                $supplier = $store->getStore($data['supplier_id']); //供货商
                //如果store_supplier中的seller_id字段值中有当前供货商并且type分销类型为1，则表示当前供货商同时也是分销商，则为其供货商添加分销订单
                $seller_info = $store_supplier->getSeller(array ('seller_id' => $data['supplier_id'], 'type' => 1));
                if (!empty($seller_info))
                {
                    $is_supplier = FALSE;
                }
                else
                {
                    $is_supplier = TRUE;
                }
                $seller = $store->getStore($this->store_session['store_id']); //分销商
                if ($total > 0)
                {
                    //供货商不可用余额和收入加商品成本
                    if ($store->setUnBalanceInc($data['supplier_id'], $total) && $store->setIncomeInc($data['supplier_id'], $total))
                    {
                        foreach ($fx_order_id as $id)
                        {
                            //修改分销订单状态为等待供货商发货并且关联供货商订单id
                            $fx_order->edit(array ('fx_order_id' => $id), array ('status' => 2, 'paid_time' => time()));
                            $fx_order_info = $fx_order->getOrder($this->store_session['store_id'], $id); //分销订单详细
                            $order_id = $fx_order_info['order_id']; //主订单ID
                            //主订单分销商品
                            $fx_products = $order_product->getFxProducts($order_id, $id, $is_supplier);
                            $order_info = $order->getOrder($this->store_session['store_id'], $order_id);
                            $order_trade_no = $order_info['trade_no']; //主订单交易号
                            unset($order_info['order_id']);
                            $order_info['order_no'] = date('YmdHis', time()) . mt_rand(100000, 999999);
                            $order_info['store_id'] = $data['supplier_id'];
                            $order_info['trade_no'] = date('YmdHis', time()) . mt_rand(100000, 999999);
                            $order_info['third_id'] = '';
                            $order_info['uid'] = $this->user_session['uid']; //下单用户（分销商）
                            $order_info['session_id'] = '';
                            $order_info['postage'] = $fx_order_info['postage'];
                            $order_info['sub_total'] = $fx_order_info['cost_sub_total'];
                            $order_info['total'] = $fx_order_info['cost_total'];
                            $order_info['status'] = 2; //未发货
                            $order_info['pro_count'] = 0; //商品种类数量
                            $order_info['pro_num'] = $fx_order_info['quantity']; //商品件数
                            $order_info['payment_method'] = 'balance';
                            $order_info['type'] = 3; //分销订单
                            $order_info['add_time'] = time();
                            $order_info['paid_time'] = time();
                            $order_info['sent_time'] = 0;
                            $order_info['cancel_time'] = 0;
                            $order_info['complate_time'] = 0;
                            $order_info['refund_time'] = 0;
                            $order_info['star'] = 0;
                            $order_info['pay_money'] = $fx_order_info['cost_total'];
                            $order_info['cancel_method'] = 0;
                            $order_info['float_amount'] = 0;
                            $order_info['is_fx'] = 0;
                            $order_info['fx_order_id'] = $id; //关联分销商订单id（fx_order）
                            $order_info['user_order_id'] = $fx_order_info['user_order_id'];
                            if ($new_order_id = $order->add($order_info))
                            { //向供货商提交一个新订单
                                $suppliers = array ();
                                foreach ($fx_products as $key => $fx_product)
                                {
                                    unset($fx_product['pigcms_id']);
                                    //获取分销商品的来源
                                    $product_info = $product_model->get(array ('product_id' => $fx_product['product_id']), 'source_product_id,original_product_id');
                                    if (!empty($product_info['source_product_id']))
                                    {
                                        $fx_product['product_id'] = $product_info['source_product_id'];

                                        $properties = ''; //商品属性字符串
                                        if (!empty($fx_product['sku_data']))
                                        {
                                            $sku_data = unserialize($fx_product['sku_data']);
                                            $skus = array ();
                                            foreach ($sku_data as $sku)
                                            {
                                                $skus[] = $sku['pid'] . ':' . $sku['vid'];
                                            }
                                            $properties = implode(';', $skus);
                                        }
                                        if (!empty($properties))
                                        { //有属性
                                            $sku = $product_sku->getSku($fx_product['product_id'], $properties);
                                            $fx_product['pro_price'] = $sku['cost_price']; //分销来源商品的成本价格
                                            $fx_product['sku_id'] = $sku['sku_id'];
                                        }
                                        else
                                        { //无属性
                                            $source_product_info = $product_model->get(array ('product_id' => $fx_product['product_id']), 'price,cost_price');
                                            $fx_product['pro_price'] = $source_product_info['cost_price']; //分销来源商品的成本价格
                                        }
                                    }

                                    $fx_product['order_id'] = $new_order_id;
                                    $fx_product['pro_price'] = $fx_product['price'];
                                    $fx_product['is_packaged'] = 0;
                                    $fx_product['in_package_status'] = 0;
                                    //判断是否是店铺自有商品
                                    $super_product_info = $product_model->get(array ('product_id' => $product_info['source_product_id']), 'source_product_id,original_product_id');
                                    if (empty($seller_info) || empty($super_product_info['source_product_id']))
                                    { //供货商或商品供货商
                                        $fx_product['is_fx'] = 0;
                                    }
                                    else
                                    {
                                        $fx_product['is_fx'] = 1;
                                    }
                                    unset($fx_product['price']);
                                    $order_product->add($fx_product); //添加新订单商
                                    $fx_products[$key]['pro_price'] = $fx_product['pro_price'];
                                    $fx_products[$key]['source_product_id'] = $fx_product['product_id'];
                                    $suppliers[] = $fx_product['supplier_id'];
                                }
                                //修改订单供货商
                                $suppliers = array_unique($suppliers);
                                $suppliers = implode(',', $suppliers);
                                D('Order')->where(array ('order_id' => $new_order_id))->data(array ('suppliers' => $suppliers))->save();

                                //添加供货商财务记录（收入）
                                $data_record = array ();
                                $data_record['store_id'] = $data['supplier_id'];
                                $data_record['order_id'] = $new_order_id;
                                $data_record['order_no'] = $order_info['order_no'];
                                $data_record['income'] = $fx_order_info['cost_total'];
                                $data_record['type'] = 5; //分销
                                $data_record['balance'] = $supplier['income'];
                                $data_record['payment_method'] = 'balance';
                                $data_record['trade_no'] = $order_info['trade_no'];
                                $data_record['add_time'] = time();
                                $data_record['status'] = 1;
                                $data_record['user_order_id'] = $order_info['user_order_id'];
                                $financial_record_id = D('Financial_record')->data($data_record)->add();

                                //判断供货商，如果上级供货商是分销商，添加分销订单
                                if (!empty($seller_info))
                                {
                                    $cost_sub_total = 0;
                                    $sub_total = 0;
                                    $tmp_fx_products = array ();
                                    foreach ($fx_products as $k => $fx_product)
                                    {
                                        $properties = ''; //商品属性字符串
                                        if (!empty($fx_product['sku_data']))
                                        {
                                            $sku_data = unserialize($fx_product['sku_data']);
                                            $skus = array ();
                                            foreach ($sku_data as $sku)
                                            {
                                                $skus[] = $sku['pid'] . ':' . $sku['vid'];
                                            }
                                            $properties = implode(';', $skus);
                                        }
                                        //获取分销商品的来源
                                        $product_info = $product_model->get(array ('product_id' => $fx_product['product_id']), 'source_product_id,original_product_id');
                                        $source_product_id = $product_info['source_product_id']; //分销来源商品
                                        $original_product_id = $product_info['original_product_id'];
                                        if (empty($source_product_id) || $original_product_id == $source_product_id)
                                        { //商品供货商或商品供货商为上级分销商
                                            unset($fx_products[$k]);
                                            continue;
                                        }
                                        $tmp_fx_product = $fx_product;
                                        if (!empty($seller_info) && !empty($product_info['original_product_id']))
                                        {
                                            $product_info = $product_model->get(array ('product_id' => $source_product_id), 'source_product_id,original_product_id');
                                            $source_product_id = $product_info['source_product_id']; //分销来源商品
                                        }
                                        if (!empty($properties))
                                        { //有属性
                                            $sku = $product_sku->getSku($source_product_id, $properties);
                                            //$price = $sku['price'];
                                            $cost_price = $sku['cost_price']; //分销来源商品的成本价格
                                            $sku_id = $sku['sku_id'];
                                        }
                                        else
                                        { //无属性
                                            $source_product_info = $product_model->get(array ('product_id' => $source_product_id), 'price,cost_price');
                                            //$price = $source_product_info['price'];
                                            $cost_price = $source_product_info['cost_price']; //分销来源商品的成本价格
                                            $sku_id = 0;
                                        }
                                        $cost_sub_total += $cost_price;
                                        $sub_total += $fx_product['pro_price'];
                                        $tmp_fx_product['product_id'] = $source_product_id;
                                        $tmp_fx_product['price'] = $fx_product['pro_price'];
                                        $tmp_fx_product['cost_price'] = $cost_price;
                                        $tmp_fx_product['sku_id'] = $sku_id;
                                        $tmp_fx_product['original_product_id'] = $original_product_id;
                                        $tmp_fx_products[] = $tmp_fx_product;
                                    }
                                    if (!empty($fx_products))
                                    {
                                        $fx_order_no = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999); //分销订单号
                                        //运费
                                        $fx_postages = array ();
                                        if (!empty($order_info['fx_postage']))
                                        {
                                            $fx_postages = unserialize($order_info['fx_postage']);
                                        }
                                        $postage = !empty($fx_postages[$seller_info['supplier_id']]) ? $fx_postages[$seller_info['supplier_id']] : 0;
                                        $data2 = array (
                                            'fx_order_no' => $fx_order_no,
                                            'uid' => $order_info['uid'],
                                            'order_id' => $new_order_id,
                                            'order_no' => $order_info['order_no'],
                                            'supplier_id' => $seller_info['supplier_id'],
                                            'store_id' => $data['supplier_id'],
                                            'quantity' => $fx_order_info['quantity'],
                                            'sub_total' => $sub_total,
                                            'cost_sub_total' => $cost_sub_total,
                                            'postage' => $postage,
                                            'total' => ($sub_total + $postage),
                                            'cost_total' => ($cost_sub_total + $postage),
                                            'delivery_user' => $order_info['address_user'],
                                            'delivery_tel' => $order_info['address_tel'],
                                            'delivery_address' => $order_info['address'],
                                            'add_time' => time(),
                                            'user_order_id' => $order_info['user_order_id']
                                        );
                                        if ($fx_order_id = $fx_order->add($data2))
                                        { //添加分销商订单
                                            foreach ($tmp_fx_products as $tmp_fx_product)
                                            {
                                                if (!empty($tmp_fx_product['product_id']))
                                                {
                                                    $product_info = D('Product')->field('store_id, original_product_id')->where(array ('product_id' => $tmp_fx_product['original_product_id']))->find();
                                                    $tmp_supplier_id = $product_info['store_id'];
                                                    $fx_order_product->add(array ('fx_order_id' => $fx_order_id, 'product_id' => $tmp_fx_product['product_id'], 'source_product_id' => $tmp_fx_product['source_product_id'], 'price' => $tmp_fx_product['price'], 'cost_price' => $tmp_fx_product['cost_price'], 'quantity' => $tmp_fx_product['pro_num'], 'sku_id' => $tmp_fx_product['sku_id'], 'sku_data' => $tmp_fx_product['sku_data'], 'comment' => $tmp_fx_product['comment']));
                                                }
                                            }
                                            if (!empty($tmp_supplier_id))
                                            { //修改订单，设置分销商
                                                D('Fx_order')->where(array ('fx_order_id' => $fx_order_id))->data(array ('suppliers' => $tmp_supplier_id))->save();
                                            }
                                        }
                                        //获取分销利润
                                        if (!empty($financial_record_id) && !empty($data2['cost_total']))
                                        {
                                            $profit = $data2['total'] - $data2['cost_total'];
                                            if ($profit > 0)
                                            {
                                                D('Financial_record')->where(array ('pigcms_id' => $financial_record_id))->data(array ('profit' => $profit))->save();
                                            }
                                        }
                                    }
                                }

                                //分销商不可用余额和收入减商品成本
                                if ($store->setUnBalanceDec($this->store_session['store_id'], $fx_order_info['cost_total']) && $store->setIncomeDec($this->store_session['store_id'], $fx_order_info['cost_total']))
                                {
                                    //添加分销商财务记录（支出）
                                    $order_no = $order_info['order_no'];
                                    $data_record = array ();
                                    $data_record['store_id'] = $this->store_session['store_id'];
                                    $data_record['order_id'] = $order_id;
                                    $data_record['order_no'] = $order_no;
                                    $data_record['income'] = (0 - $fx_order_info['cost_total']);
                                    $data_record['type'] = 5; //分销
                                    $data_record['balance'] = $seller['income'];
                                    $data_record['payment_method'] = 'balance';
                                    $data_record['trade_no'] = $order_trade_no;
                                    $data_record['add_time'] = time();
                                    $data_record['status'] = 1;
                                    $data_record['user_order_id'] = $order_info['user_order_id'];
                                    D('Financial_record')->data($data_record)->add();
                                }
                                else
                                { //操作失败，记录日志文件
                                    $supplier_name = $supplier['name'];
                                    $seller_name = $seller['name'];
                                    $dir = './upload/pay/';
                                    if (!is_readable($dir))
                                    {
                                        is_file($dir) or mkdir($dir, 0777);
                                    }
                                    //file_put_contents($dir . 'error.txt', '[' . date('Y-m-d H:i:s') . '] 付款给供货商失败，订单类型：分销，订单ID：' . $order_id . '，交易单号：' . $order_trade_no . '，供货商（收款方）：' . $supplier_name . '，分销商（付款方）：' . $seller_name . '，付款金额：' . $fx_order_info['cost_total'] . '元，请手动从 ' . $seller_name . ' 账户余额中减' . $fx_order_info['cost_total'] . '元' . PHP_EOL, FILE_APPEND);
                                    json_return(1005, '付款失败，请联系客服处理，交易单号：' . $order_trade_no);
                                }
                            }
                        }
                        json_return(0, '付款成功，等待供货商发货');
                    }
                    else
                    {
                        json_return(1004, '付款失败');
                    }
                }
                else
                {
                    json_return(1003, '付款金额无效');
                }
            }
        }

        $trade_no = isset($_GET['trade_no']) ? trim($_GET['trade_no']) : '';
        if (empty($trade_no))
        {
            $html = '<div class="error-wrap"><h1>很抱歉，未找到交易号</h1><div class="description"></div><div class="error-code">错误代码： 10001</div><div class="action"><a href="javascript:window.history.go(-1);" class="ui-btn ui-btn-primary">返回</a></div></div>';
            $this->assign('trade_no_error', $html);
        }
        else if (!$fx_order->getOrderCount(array ('fx_trade_no' => $trade_no)))
        {
            $html = '<div class="error-wrap"><h1>很抱歉，未找到交易号 ' . $trade_no . ' 关联的支付信息</h1><div class="description"></div><div class="error-code">错误代码： 10002</div><div class="action"><a href="javascript:window.history.go(-1);" class="ui-btn ui-btn-primary">返回</a></div></div>';
            $this->assign('trade_no_error', $html);
        }
        $this->assign('trade_no', $trade_no);
        $this->display();
    }

    private function _pay_order_content()
    {
        $store = M('Store');
        $fx_order = M('Fx_order');
        $order_product = M('Fx_order_product');

        $trade_no = isset($_POST['trade_no']) ? trim($_POST['trade_no']) : '';
        $tmp_orders = $fx_order->getOrders(array ('fx_trade_no' => $trade_no));
        $orders = array ();
        $total = 0;
        $sub_total = 0;
        $postage = 0;
        $supplier_id = 0;
        $seller_id = 0;
        $supplier_name = '';
        $pay = TRUE;
        foreach ($tmp_orders as $tmp_order)
        {
            $supplier = $store->getStore($tmp_order['supplier_id']);
            $supplier_id = $tmp_order['supplier_id'];
            $seller_id = $tmp_order['store_id'];
            $supplier_name = $supplier['name'];
            $products = $order_product->getFxProducts($tmp_order['fx_order_id']);
            $orders[] = array (
                'fx_order_id' => $tmp_order['fx_order_id'],
                'fx_order_no' => option('config.orderid_prefix') . $tmp_order['fx_order_no'],
                'postage' => $tmp_order['postage'],
                'total' => $tmp_order['total'],
                'cost_total' => $tmp_order['cost_total'],
                'supplier' => $supplier_name,
                'products' => $products
            );
            $total += $tmp_order['cost_total'];
            if ($tmp_order['status'] != 1)
            {
                $pay = FALSE;
            }
            $postage += $tmp_order['postage'];
        }

        $this->assign('trade_no', $trade_no);
        $this->assign('orders', $orders);
        $this->assign('total', number_format($total, 2, '.', ''));
        $this->assign('supplier', $supplier_name);
        $this->assign('supplier_id', $supplier_id);
        $this->assign('seller_id', $seller_id);
        $this->assign('pay', $pay);
        $this->assign('postage', number_format($postage, 2, '.', ''));
    }

    //我的供货商
    public function supplier()
    {
//        dump($_SESSION);
        //排他分销
        $seller = D('Store_supplier')->where(array ('seller_id' => $this->store_session['store_id'], 'type' => 1))->count('pigcms_id');
        if ($seller)
        {
            $is_seller = TRUE;
        }
        else
        {
            $is_seller = FALSE;
        }

        $this->assign('is_seller', $is_seller);

        $this->display();
    }

    private function _supplier_content()
    {
        $store_supplier = M('Store_supplier');
        $store = M('Store');

        $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
        $level = isset($_POST['level']) ? trim($_POST['level']) : 1;    //供货商等级
        $sellerId = $this->store_session['store_id'];    //当前分销商id

        $where = array ();

        /* 获取当前分销商信息 */
        $sellerInfo = $store_supplier->getSeller(array (
            'seller_id' => $sellerId
        ));

        $supplyChain = explode(',', $sellerInfo['supply_chain']);
        $sellerIdList = rtrim(implode(',', $supplyChain), ',');

        $where['store_id'] = array ('in' => $sellerIdList);

        if (!empty($keyword))
        {
            $where['name'] = array ('like' => '%' . $keyword . '%');
        }

        $supplier_count = $store_supplier->supplier_count($where);

        import('source.class.user_page');
        $page = new Page($supplier_count, 15);
        $suppliers = $store_supplier->suppliers($where, $page->firstRow, $page->listRows);

        $this->assign('suppliers', $suppliers);
        $this->assign('page', $page->show());
    }

    //我的商品
    public function supplier_goods()
    {
        $this->display();
    }

    private function _supplier_goods_content()
    {
        $product = M('Product');
        $product_group = M('Product_group');
        $product_to_group = M('Product_to_group');

        $order_by_field = isset($_POST['orderbyfield']) ? $_POST['orderbyfield'] : '';
        $order_by_method = isset($_POST['orderbymethod']) ? $_POST['orderbymethod'] : '';
        $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
        $is = isset($_POST['is']) ? intval($_POST['is']) : 1;

        $where = array ();
        //$where['store_id'] = $this->store_session['store_id'];
        if ($keyword)
        {
            $where['name'] = array ('like', '%' . $keyword . '%');
        }
        $where['buy_way'] = 1; //站内商品

        if ($is == 1)
        {
            //$where['is_fx'] = 1; // 可分销
            $where['_string'] = "(`store_id` = " . $this->store_session['store_id'] . " and `is_fx` = " . 0 . ") or `wholesale_product_id` > " . '0' . " and `is_fx` = " . '0' . " and `store_id` = " . $this->store_session['store_id'];
        }
        else if ($is == 2)
        {
            $where['_string'] = "`store_id` = " . $this->store_session['store_id'] . " and`wholesale_product_id` = " . '0' . "  and `is_wholesale` = " . 0;
            // $where['is_wholesale'] = 1 ; // 可批发
        }

        $product_total = $product->getSellingTotal($where);
        import('source.class.user_page');
        $page = new Page($product_total, 15);
        $products = $product->getSelling($where, $order_by_field, $order_by_method, $page->firstRow, $page->listRows);

        $this->assign('page', $page->show());
        $this->assign('products', $products);
        $this->assign('is', $is);
    }

    //商品市场
    public function supplier_market()
    {
        $this->display();
    }

    //同步微页面商品
    private function _sync_wei_page_goods($product_id, $store_id = '')
    {
        $product_id = !is_array($product_id) ? array ($product_id) : $product_id;
        //删除微页面的商品
        if (empty($store_id))
        {
            $store_id = $this->store_session['store_id'];
        }
        $fields = D('Custom_field')->where(array ('store_id' => $store_id, 'field_type' => 'goods'))->select();
        if ($fields)
        {
            foreach ($fields as $field)
            {
                $products = unserialize($field['content']);
                if (!empty($products) && !empty($products['goods']))
                {
                    $new_products = array ();
                    foreach ($products['goods'] as $product)
                    {
                        if (!in_array($product['id'], $product_id))
                        {
                            $new_products[] = $product;
                        }
                    }
                    $products['goods'] = $new_products;
                    $content = serialize($products);
                    D('Custom_field')->where(array ('field_id' => $field['field_id']))->data(array ('content' => $content))->save();
                }
            }
        }
    }

    //递归取消商品分销
    private function _cancel_fx_product($product_id)
    {
        $products = D('Product')->where(array ('source_product_id' => $product_id))->select();
        if (!empty($products))
        {
            foreach ($products as $product)
            {
                M('Product')->edit(array ('product_id' => $product['product_id']), array ('status' => 2)); //修改状态为删除
                $this->_sync_wei_page_goods($product['product_id'], $product['store_id']);
                $this->_cancel_fx_product($product['product_id']);
            }
        }
    }

    //分销商品市场
    private function _supplier_market_content()
    {
        $product = M('Product');
        $product_group = M('Product_group');
        $product_to_group = M('Product_to_group');

        $order_by_field = 'is_fx';
        $order_by_method = 'DESC';
        $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';

        $is = isset($_POST['is']) ? intval($_POST['is']) : 3;
        $p = !empty($_POST['p']) ? intval($_POST['p']) : 1 ; //页数
        $where = array ();
        $store_id = $this->store_session['store_id'];
        $where['status'] = 1;
        $where['quantity'] = array('>',0);
        $version = option('config.weidian_version'); // 0 微店 1 v.meihua

        if ($is == 1) {
            if ($keyword) {
                $where['_string'] = " store_id = '".$store_id."' and is_fx = 1 and name like '%".$keyword."%'";
            } else {
                $where['_string'] = " store_id = '".$store_id."' and is_fx = 1";
            }
        } else if ($is == 2) {
            if ($keyword) {
                $where['_string'] = " store_id = '".$store_id."' and is_wholesale = 1 and name like '%".$keyword."%'";
            } else {
                $where['_string'] = " store_id = '".$store_id."' and is_wholesale = 1" ;
            }
        } else if ($is == 3) {
            if (empty($version)) { // 微店
                if ($keyword) {
                    $where['_string'] = " name like '%".$keyword."%' and store_id = '".$store_id."'";
                } else {
                    $where['_string'] = " store_id = '".$store_id."'";
                }
            } else { // v.meihua
                if ($keyword) {
                    $where['_string'] = " name like '%".$keyword."%' and store_id = '".$store_id."'";
                } else {
                    $where['_string'] = " store_id = '".$store_id."'";
                }
            }
        }

        if (!empty($_POST['category_id'])) {
            $where['category_id'] = intval(trim($_POST['category_id']));
        }
        if (!empty($_POST['category_fid'])) {
            $where['category_fid'] = intval(trim($_POST['category_fid']));
        }

        //未开启批发商品
        if (!$this->checkFx(true)) {
            $where['wholesale_product_id'] = 0;
        }

        $product_total = $product->getSellingTotal($where);
        import('source.class.user_page');
        $page = new Page($product_total, 15);
        $productList = $product->getSelling($where, $order_by_field, $order_by_method, $page->firstRow, $page->listRows);

        $products = array();
        foreach($productList as $product) {

            //店铺是否关闭
            $storeInfo = D('Store')->where(array('store_id'=>$product['store_id']))->find();
            if($storeInfo['status'] == 1){
                //是否是白名单商品
                $whitelist_product = D('Product_whitelist')->where(array('product_id'=>$product['product_id']))->count('pigcms_id');

                if($whitelist_product>0) {
                    $is_whitelist = 1;
                } else {
                    $is_whitelist = 0;
                }

                $products[]=array(
                    'name' => $product['name'],
                    'image' => $product['image'],
                    'quantity' => $product['quantity'],
                    'is_whitelist' => $is_whitelist,
                    'sales' => $product['sales'],
                    'pv' => $product['pv'],
                    'is_fx' => $product['is_fx'],
                    'is_wholesale' => $product['is_wholesale'],
                    'product_id' => $product['product_id'],
                    'is_recommend' => $product['is_recommend'],
                    'wholesale_product_id' => $product['wholesale_product_id'],
                    'price' => $product['price'],
                    'cost_price' => $product['cost_price'],
                    'wholesale_price' => $product['wholesale_price'],
                    'min_fx_price' => $product['min_fx_price'],
                    'sale_min_price' => $product['sale_min_price'],
                    'sale_max_price' => $product['sale_max_price'],
                    'drp_level_1_price' => $product['drp_level_1_price'],
                    'drp_level_2_price' => $product['drp_level_2_price'],
                    'drp_level_3_price' => $product['drp_level_3_price'],
                    'drp_level_1_cost_price' => $product['drp_level_1_cost_price'],
                    'drp_level_2_cost_price' => $product['drp_level_2_cost_price'],
                    'drp_level_3_cost_price' => $product['drp_level_3_cost_price'],
                    'supplier_id' => $product['supplier_id'],
                );
            }
        }
        //商品分类
        $category = M('Product_category');
        $categories = $category->getCategories(array ('cat_status' => 1), 'cat_path ASC');

        //是否开启分销商等级
        $open_drp_degree = M('Drp_degree')->checkDrpDegree($this->store_session['store_id']);
        //分销商等级
        $drp_degrees = M('Drp_degree')->getDrpDegrees(array('store_id' => $this->store_session['store_id']));

        $this->assign('page', $page->show());
        $this->assign('products', $products);
        $this->assign('categories', $categories);
        $this->assign('is', $is);
        $this->assign('p', $p);
        $this->assign('open_drp_degree', $open_drp_degree);
        $this->assign('drp_degrees', $drp_degrees);
    }

    //我的分销商
    public function seller()
    {
        $this->display();
    }

    public function seller_content()
    {
        $store = M('Store');
        $order = M('Order');
        $this->assign('open_drp_approve', $this->store_session['open_drp_approve']);

        $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';     /* 分销商 */
        $approve = isset($_POST['approve']) ? trim($_POST['approve']) : '*';    /* 审核状态 */
        $degree = isset($_POST['degree']) ? intval($_POST['degree']) : '*';     /* 分销推广等级 */
        $level = isset($_POST['level']) ? intval($_POST['level']) : '*';        /* 分销商级别 */
        $team_name = isset($_POST['team_name']) ? $_POST['team_name'] : '';        /* 团队名称 */
        $start_time = isset($_POST['start_time']) ? strtotime(trim($_POST['start_time'])) : '' ;
        $end_time = isset($_POST['end_time']) ? strtotime(trim($_POST['end_time'])) : '' ;

        //获取当前供货商下分销最高级别
        $supplier_id = $this->store_session['store_id'];
        $sql = "SELECT max(level) as max_level FROM " . option('system.DB_PREFIX') . "store_supplier WHERE FIND_IN_SET($supplier_id,supply_chain)";
        $max_level = D('Store_supplier')->query($sql);

        //供货商是否开启分销等级
        $open_drp_degree = option('config.open_drp_degree');  //平台是否开启分销等级

        if(!empty($open_drp_degree)){
            $supplier_open_drp_degree = D('Store')->field('open_drp_degree')->where(array('store_id'=>$supplier_id))->find();
            if(!empty($supplier_open_drp_degree)){
                $drp_degree = M("Drp_degree");
                $drp_degree_list = $drp_degree->getDrpDegrees(array('store_id'=>$supplier_id));
            }
        }

        $where = array ();
        if($keyword != ''){
            $where['s.name'] = array ('like' => '%' . $keyword . '%'); /* 分销商 */
        }
        if (is_numeric($approve) || $approve != '*'){
            $where['s.drp_approve'] = $approve;                        /* 审核状态 */
        }
        if($degree > 0){
            $where['dd.is_platform_degree_name'] = $degree;            /* 分销推广等级 */
        }
        if($level > 0){
            $where['s.drp_level'] = $level;                           /* 分销推广等级 */
        }
        if($team_name){
            $where['team.name'] = array ('like' => '%' . $team_name . '%');  /* 团队名称 */
        }
        if (!empty($start_time) && !empty($end_time)){
            $where['_string'] = "s.date_added >= " . $start_time . " AND s.date_added <= " . $end_time;
        }
        else if (!empty($start_time)){
            $where['s.date_added'] = array ('>=', $start_time);
        } else if (!empty($end_time)){
            $where['s.date_added'] = array ('<=', $end_time);
        }

        $seller_count = $store->seller_count($where, $supplier_id);
        import('source.class.user_page');
        $page = new Page($seller_count, 15);
        $tmp_sellers = $store->sellers($where, $page->firstRow, $page->listRows,$supplier_id);

        $sellers = array ();
        foreach ($tmp_sellers as $key => $tmp_seller) {
            $sales = $order->getSales(array ('store_id' => $tmp_seller['store_id'], 'is_fx' => 1, 'status' => array ('in', array (2, 3, 4, 7))));
            //分销商等级
            $degree_list_id = D('Drp_degree')->field('degree_alias,is_platform_degree_name')->where(array('pigcms_id'=>$tmp_seller['drp_degree_id']))->find();
            if(empty($degree_list_id['degree_alias'])){
                $degree_name = D('Platform_drp_degree')->field('name')->where(array('pigcms_id'=>$degree_list_id['is_platform_degree_name']))->find();
            }else{
                $degree_name = $degree_list_id;
            }
            $profit = $tmp_seller['income'];
            $sellers[$key] = array (
                'fx_store_id' => $tmp_seller['fx_store_id'],
                'store_name' => $tmp_seller['store_name'],
                'team_name' => $tmp_seller['team_name'],
                'store_logo' => !empty($tmp_seller['store_logo']) ? getAttachmentUrl($tmp_seller['store_logo'], FALSE) : getAttachmentUrl('images/default_shop.png', FALSE),
                'service_tel' => $tmp_seller['service_tel'],
                'service_qq' => $tmp_seller['service_qq'],
                'service_weixin' => $tmp_seller['service_weixin'],
                'tel' => $tmp_seller['tel'],
                'drp_approve' => $tmp_seller['drp_approve'],
                'date_added' => $tmp_seller['date_added'],
                'drp_level' => $tmp_seller['drp_level'],
                'store_status' => $tmp_seller['store_status'],
                'degree_name' => $degree_name['name'],
                'sales' => !empty($sales) ? number_format($sales, 2, '.', '') : '0.00',
                'profit' => !empty($profit) ? number_format($profit, 2, '.', '') : '0.00'
            );

            //未对账金额
            $sql = "SELECT SUM(income) AS income FROM " . option('system.DB_PREFIX') . "financial_record WHERE store_id = '" . $tmp_seller['fx_store_id'] . "' AND order_id IN (SELECT order_id FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = ss.seller_id AND ss.type = 1 AND o.status = 4 AND o.is_check = 1 AND FIND_IN_SET(" . $this->store_session['store_id'] . ", ss.supply_chain)) AND status IN (1,3)";
            $incomes = D('Financial_record')->query($sql);
            $uncheck_amount = 0;
            if (!empty($incomes[0]['income'])) {
                $uncheck_amount = $incomes[0]['income'];
            }
            $uncheck_amount = number_format($uncheck_amount, 2, '.', '');
            $sellers[$key]['uncheck_profit'] = $uncheck_amount;

            //未对账订单
            $sql = "SELECT COUNT(o.order_id) AS orders FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = ss.seller_id AND o.store_id = '" . $tmp_seller['fx_store_id'] . "' AND ss.type = 1 AND o.status = 4 AND o.is_check = 1 AND FIND_IN_SET(" . $this->store_session['store_id'] . ", ss.supply_chain)";
            $uncheck_order = D('Order')->query($sql);
            if (!empty($uncheck_order[0]['orders'])) {
                $uncheck_order = $uncheck_order[0]['orders'];
            } else {
                $uncheck_order = 0;
            }
            $sellers[$key]['uncheck_order'] = $uncheck_order;
        }
        $this->assign('level', $level);
        $this->assign('drp_degree_list', $drp_degree_list);
        $this->assign('max_level', $max_level[0]['max_level']); // 当前供货商最高级别
        $this->assign('sellers', $sellers);
        $this->assign('page', $page->show());
    }

    /**
     * 分销商导出
     * @return .xls 文件
     */
    public function checkout()
    {
        set_time_limit(0);
        $store = M('Store');
        $order = M('Order');
        $this->assign('open_drp_approve', $this->store_session['open_drp_approve']);
        $keyword = isset($_REQUEST['keyword']) ? trim($_REQUEST['keyword']) : '';     /* 分销商 */
        $approve = isset($_REQUEST['approve']) ? trim($_REQUEST['approve']) : '*';    /* 审核状态 */
        $degree = isset($_REQUEST['degree']) ? intval($_REQUEST['degree']) : '*';     /* 分销推广等级 */
        $level = isset($_REQUEST['level']) ? intval($_REQUEST['level']) : '*';        /* 分销商级别 */
        $team_name = isset($_REQUEST['team_name']) ? $_REQUEST['team_name'] : '';        /* 团队名称 */
        /*$start_time = isset($_REQUEST['start_time']) ? strtotime(trim($_REQUEST['start_time'])) : '' ;
        $end_time = isset($_REQUEST['end_time']) ? strtotime(trim($_REQUEST['end_time'])) : '' ;*/
        $type = $_GET['type'];

        //获取当前供货商下分销最高级别
        $supplier_id = $this->store_session['store_id'];
        $sql = "SELECT max(level) as max_level FROM " . option('system.DB_PREFIX') . "store_supplier WHERE FIND_IN_SET($supplier_id,supply_chain)";
        $max_level = D('Store_supplier')->query($sql);

        //供货商是否开启分销等级
        $open_drp_degree = option('config.open_drp_degree');  //平台是否开启分销等级
        if(!empty($open_drp_degree)){
            $supplier_open_drp_degree = D('Store')->field('open_drp_degree')->where(array('store_id'=>$supplier_id))->find();
            if(!empty($supplier_open_drp_degree)){
                $drp_degree = M("Drp_degree");
                $drp_degree_list = $drp_degree->getDrpDegrees(array('store_id'=>$supplier_id));
            }
        }
        $where = array ();
        if($keyword != ''){
            $where['s.name'] = array ('like' => '%' . $keyword . '%'); /* 分销商 */
        }

        if (is_numeric($approve) || $approve != '*'){
            $where['s.drp_approve'] = $approve;                        /* 审核状态 */
        }
        if($degree > 0){
            $where['dd.is_platform_degree_name'] = $degree;            /* 分销推广等级 */
        }
        if($level > 0){
            $where['s.drp_level'] = $level;                           /* 分销推广等级 */
        }
        if($team_name){
            $where['team.name'] = array ('like' => '%' . $team_name . '%');  /* 团队名称 */
        }
        /*if (!empty($start_time) && !empty($end_time)){
            $where['_string'] = "s.date_added >= " . $start_time . " AND s.date_added <= " . $end_time;
        }
        else if (!empty($start_time)){
            $where['s.date_added'] = array ('>=', $start_time);
        } else if (!empty($end_time)){
            $where['s.date_added'] = array ('<=', $end_time);
        }*/

        $seller_count = $store->seller_count($where, $supplier_id);
        import('source.class.user_page');
        $page = new Page($seller_count, 15);
        if ($type =='do_checkout') {
        	$tmp_sellers = $store->sellers($where, 0, 0,$supplier_id);
        } else {
        	$tmp_sellers = $store->sellers($where, $page->firstRow, $page->listRows,$supplier_id);
        }

        $sellers = array ();
        foreach ($tmp_sellers as $key => $tmp_seller) {
            $sales = $order->getSales(array ('store_id' => $tmp_seller['store_id'], 'is_fx' => 1, 'status' => array ('in', array (4))));
            //分销商等级
            $degree_list_id = D('Drp_degree')->field('degree_alias,is_platform_degree_name')->where(array('pigcms_id'=>$tmp_seller['drp_degree_id']))->find();
            if(empty($degree_list_id['degree_alias'])){
                $degree_name = D('Platform_drp_degree')->field('name')->where(array('pigcms_id'=>$degree_list_id['is_platform_degree_name']))->find();
            }else{
                $degree_name = $degree_list_id;
            }
            $profit = $tmp_seller['income'];
            $sellers[$key] = array (
                'fx_store_id' => $tmp_seller['fx_store_id'],
                'store_name' => $tmp_seller['store_name'],
                'team_name' => $tmp_seller['team_name'],
                'store_logo' => !empty($tmp_seller['store_logo']) ? getAttachmentUrl($tmp_seller['store_logo'], FALSE) : getAttachmentUrl('images/default_shop.png', FALSE),
                'service_tel' => $tmp_seller['service_tel'],
                'service_qq' => $tmp_seller['service_qq'],
                'service_weixin' => $tmp_seller['service_weixin'],
                'tel' => $tmp_seller['tel'],
                'drp_approve' => $tmp_seller['drp_approve'],
                'date_added' => $tmp_seller['date_added'],
                'drp_level' => $tmp_seller['drp_level'],
                'store_status' => $tmp_seller['store_status'],
                'degree_name' => $degree_name['name'],
                'sales' => !empty($sales) ? number_format($sales, 2, '.', '') : '0.00',
                'profit' => !empty($profit) ? number_format($profit, 2, '.', '') : '0.00'
            );

            //未对账金额
            $sql = "SELECT SUM(income) AS income FROM " . option('system.DB_PREFIX') . "financial_record WHERE store_id = '" . $tmp_seller['fx_store_id'] . "' AND order_id IN (SELECT order_id FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = ss.seller_id AND ss.type = 1 AND o.status = 4 AND o.is_check = 1 AND FIND_IN_SET(" . $this->store_session['store_id'] . ", ss.supply_chain)) AND status IN (1,3)";
            $incomes = D('Financial_record')->query($sql);
            $uncheck_amount = 0;
            if (!empty($incomes[0]['income'])) {
                $uncheck_amount = $incomes[0]['income'];
            }
            $uncheck_amount = number_format($uncheck_amount, 2, '.', '');
            $sellers[$key]['uncheck_profit'] = $uncheck_amount;

            //未对账订单
            $sql = "SELECT COUNT(o.order_id) AS orders FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = ss.seller_id AND o.store_id = '" . $tmp_seller['fx_store_id'] . "' AND ss.type = 1 AND o.status = 4 AND o.is_check = 1 AND FIND_IN_SET(" . $this->store_session['store_id'] . ", ss.supply_chain)";
            $uncheck_order = D('Order')->query($sql);
            if (!empty($uncheck_order[0]['orders'])) {
                $uncheck_order = $uncheck_order[0]['orders'];
            } else {
                $uncheck_order = 0;
            }
            $sellers[$key]['uncheck_order'] = $uncheck_order;
        }

        if($type !='do_checkout') {
            $return = array('code'=>'0','msg'=>$seller_count);
            echo json_encode($return);exit;
        } elseif ($type =='do_checkout') {
            include 'source/class/execl.class.php';
            $execl = new execl();

            $filename = date("分销商导出_YmdHis",time()).'.xls';
            header ( 'Content-Type: application/vnd.ms-excel' );
            header ( "Content-Disposition: attachment;filename=$filename" );
            header ( 'Cache-Type: charset=gb2312');
            echo "<style>table td{border:1px solid #ccc;}</style>";
            echo "<table>";
            echo '  <tr>';
            echo '      <th><b> 分销商 </b></th>';
            echo '      <th><b> 所属团队 </b></th>';
            echo '      <th><b> 推广级别 </b></th>';
            echo '      <th><b> 客服电话 </b></th>';
            echo '      <th><b> 客服QQ </b></th>';
            echo '      <th><b> 客服微信 </b></th>';
            echo '      <th><b> 状态 </b></th>';
            echo '      <th><b> 销售额（元） </b></th>';
            echo '      <th><b> 佣金（元） </b></th>';
            echo '  </tr>';

            foreach ($sellers as $k => $v) {
                echo '  <tr>';
                echo '      <td style="vnd.ms-excel.numberformat:@" align="center">' . $v['store_name'] . '</td>';
                echo '      <td align="center">' . $v['team_name'] . '</td>';
                echo '      <td align="center">' . $v['degree_name'] . '</td>';
                echo '      <td align="center">' . $v['service_qq'] . '</td>';
                echo '      <td align="center">' . $v['service_weixin']. '</td>';
                if ($v['status'] > 1) {
                    $v['zt'] = '<span style="color:gray">已禁用</span>';
                } else if ($v['status'] = 1) {
                    $v['zt'] = '<span style="color:gray">已审核</span>';
                }
                echo '      <td align="center">' . $v['zt'] . '</td>';
                echo '      <td align="center">' . $v['sales'] . '</td>';
                echo '      <td align="center">' . $v['uncheck_profit'] . '</td>';
                echo '  </tr>';
            }
            echo '</table>';
        }
    }


    /**
     * 分销商导出
     * @return .xls 文件
     */
   /* public function checkout(){
        set_time_limit(0);
        $order = M('Order');
        $status = isset($_REQUEST['status']) ? trim($_REQUEST['status']) : '';  //审核状态
        $level =   isset($_REQUEST['level']) ? trim($_REQUEST['level']) : '';    //分销级别
        $type = $_GET['type'];

        $where = array();

        //审核状态
        if($status == 2){
            $where['status'] = array('>',1);
        } elseif ($status == 1){
            $where['status'] = 1;
        }

        if(!empty($level)){
            $where['drp_level'] = $level;
        }

        $where['root_supplier_id'] = $this->store_session['store_id'];

        $result = D('Store')->where($where)->select();
        $fxUserCount = D('Store')->where($where)->count('store_id');

        if($type !='do_checkout') {
            $return = array('code'=>'0','msg'=>$fxUserCount);
            echo json_encode($return);exit;
        } elseif ($type =='do_checkout') {
            include 'source/class/execl.class.php';
            $execl = new execl();



            //$filename = date($level_cn."分销商导出_YmdHis",time()).'.xls';
            $filename = date("分销商导出_YmdHis",time()).'.xls';
            header ( 'Content-Type: application/vnd.ms-excel' );
            header ( "Content-Disposition: attachment;filename=$filename" );
            header ( 'Cache-Type: charset=gb2312');
            echo "<style>table td{border:1px solid #ccc;}</style>";
            echo "<table>";
            echo '  <tr>';
            echo '      <th><b> 分销商 </b></th>';
            echo '      <th><b> 客服电话 </b></th>';
            echo '      <th><b> 客服QQ </b></th>';
            echo '      <th><b> 客服微信 </b></th>';
            echo '      <th><b> 状态 </b></th>';
            echo '      <th><b> 销售额（元） </b></th>';
            echo '      <th><b> 佣金（元） </b></th>';
            echo '  </tr>';

            foreach ($result as $k => $v) {
                $sales = $order->getSales(array('store_id' => $v['store_id'], 'is_fx' => 1, 'status' => array('in', array(4))));
                $sales = !empty($sales) ? number_format($sales, 2, '.', '') : '0.00';
                //未对账金额
                $sql = "SELECT SUM(income) AS income FROM " . option('system.DB_PREFIX') . "financial_record WHERE store_id = '" . $v['store_id'] . "' AND order_id IN (SELECT order_id FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = ss.seller_id AND ss.type = 1 AND o.status = 4 AND o.is_check = 1 AND FIND_IN_SET(" . $this->store_session['store_id'] . ", ss.supply_chain)) AND status IN (1,3)";
                $incomes = D('Financial_record')->query($sql);
                $uncheck_amount = 0;
                if (!empty($incomes[0]['income'])) {
                    $uncheck_amount = $incomes[0]['income'];
                }
                $uncheck_amount = number_format($uncheck_amount, 2, '.', '');

                echo '  <tr>';
                echo '      <td style="vnd.ms-excel.numberformat:@" align="center">' . $v['name'] . '</td>';
                echo '      <td align="center">' . $v['service_tel'] . '</td>';
                echo '      <td align="center">' . $v['service_qq'] . '</td>';
                echo '      <td align="center">' . $v['service_weixin']. '</td>';
                if ($v['status'] > 1) {
                    $v['zt'] = '<span style="color:gray">已禁用</span>';
                } else if ($v['status'] = 1) {
                    $v['zt'] = '<span style="color:gray">已审核</span>';
                }

                echo '      <td align="center">' . $v['zt'] . '</td>';
                echo '      <td align="center">' . $sales . '</td>';
                echo '      <td align="center">' . $uncheck_amount . '</td>';
                echo '  </tr>';

            }
            echo '</table>';
        }
    }*/



    /* 下两级分销商导航 */
    public function next_seller()
    {
        $store_supplier = M('Store_supplier');

        $supplier = $store_supplier->getSeller(array (
            'seller_id' => $this->store_session['store_id']
        ));

        $this->assign('level', $supplier['level']);
        $this->display();
    }

    /* 下两级分销商列表 */
    private function _next_seller_content()
    {
        $store_supplier = M('Store_supplier');
        $fx_order = M('Fx_order');

        $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';     /* 分销商 */
        $approve = isset($_POST['approve']) ? trim($_POST['approve']) : '*';    /* 审核状态 */
        $degree = isset($_POST['degree']) ? intval($_POST['degree']) : '';     /* 分销推广等级 */
        $team_name = isset($_POST['team_name']) ? $_POST['team_name'] : '';        /* 团队名称 */
        $start_time = isset($_POST['start_time']) ? strtotime(trim($_POST['start_time'])) : '' ;
        $end_time = isset($_POST['end_time']) ? strtotime(trim($_POST['end_time'])) : '' ;

        $supplierId = $this->store_session['store_id'];
        $level = intval(isset($_POST['level']) ? trim($_POST['level']) : '1');

        $where = array ();
        $where['s.status'] = array ('>', 0);


        if($keyword != '')
        {
            $where['s.name'] = array ('like' => '%' . $keyword . '%'); /* 分销商 */
        }
        if (is_numeric($approve) || $approve != '*')
        {
            $where['s.drp_approve'] = $approve;                        /* 审核状态 */
        }
        if($degree > 0){
            $where['dd.is_platform_degree_name'] = $degree;            /* 分销推广等级 */
        }
        if($team_name){
            $where['team.name'] = array ('like' => '%' . $team_name . '%');  /* 团队名称 */
        }
        if (!empty($start_time) && !empty($end_time)){
            $where['_string'] = "s.date_added >= " . $start_time . " AND s.date_added <= " . $end_time;
        }
        else if (!empty($start_time)){
            $where['s.date_added'] = array ('>=', $start_time);
        } else if (!empty($end_time)){
            $where['s.date_added'] = array ('<=', $end_time);
        }

        /* 20160222 获取当前登录的分销商供货商的id */
        $root_supplier_id = '';
        $fx_store_info = D('Store')->where(array('store_id'=>$supplierId))->find();
        if($fx_store_info['drp_level'] > 0 && !empty($fx_store_info['root_supplier_id'])){
            $root_supplier_id = $fx_store_info['root_supplier_id'];
        }else if($fx_store_info['drp_level'] > 0 && empty($fx_store_info['root_supplier_id'])){ //兼容未更新 root_supplier_id 字段的程序
            $fx_store_chain = D('Store_supplier')->where(array('supplier_id'=>$fx_store_info['drp_supplier_id'], 'seller_id'=>$supplierId))->find();
            $supply_chain = explode(',', $fx_store_chain['supply_chain']);
            $root_supplier_id = $supply_chain[1];
        }
        //供货商是否开启分销等级
        $open_drp_degree = option('config.open_drp_degree');  //平台是否开启分销等级

        if(!empty($open_drp_degree)){
            $supplier_open_drp_degree = D('Store')->field('open_drp_degree')->where(array('store_id'=>$root_supplier_id))->find();
            if(!empty($supplier_open_drp_degree)){
                $drp_degree = M("Drp_degree");
                $drp_degree_list = $drp_degree->getDrpDegrees(array('store_id'=>$root_supplier_id));
            }
        }
        /* end */

        // 判断当前登录帐号等级
        $currentLevel = $store_supplier->getSeller(array (
            'seller_id' => $supplierId
        ));
        if ($level == 1)
        {
            $sellerList = $store_supplier->getNextSellers($supplierId, $currentLevel['level'] + 1);
        }
        else
        {
            $sellerList = $store_supplier->getNextSellers($supplierId, $level);
        }

        if (count($sellerList) > 0)
        {
            foreach ($sellerList as $sellerId)
            {
                $sellerIdList[] = $sellerId['seller_id'];
            }

            $sellerIdList = rtrim(implode(',', $sellerIdList), ',');
        }
        $where['ss.seller_id'] = array ('in' => $sellerIdList);

        $seller_count = $store_supplier->seller_count($where);
        import('source.class.user_page');
        $page = new Page($seller_count, 15);
        $tmp_sellers = $store_supplier->sellers($where, $page->firstRow, $page->listRows);
        $sellers = array ();
        foreach ($tmp_sellers as $tmp_seller)
        {
            $sales = $fx_order->getSales(array ('store_id' => $tmp_seller['store_id'], 'status' => array ('in', array (1, 2, 3, 4))));

            //分销商等级
            $degree_list_id = D('Drp_degree')->field('degree_alias,is_platform_degree_name')->where(array('pigcms_id'=>$tmp_seller['drp_degree_id']))->find();
            if(empty($degree_list_id['degree_alias'])){
                $degree_name = D('Platform_drp_degree')->field('name')->where(array('pigcms_id'=>$degree_list_id['is_platform_degree_name']))->find();
            }else{
                $degree_name = $degree_list_id;
            }

            $profit = $tmp_seller['drp_profit'];
            $sellers[] = array (
                'degree_name' => $degree_name['name'],
                'store_logo' => $tmp_seller['store_logo'],
                'store_id' => $tmp_seller['store_id'],
                'name' => $tmp_seller['store_name'],
                'tel' => $tmp_seller['tel'],
                'service_qq' => $tmp_seller['service_qq'],
                'service_weixin' => $tmp_seller['service_weixin'],
                'drp_approve' => $tmp_seller['drp_approve'],
                'drp_level' => $tmp_seller['drp_level'],
                'date_added' => $tmp_seller['date_added'],
                'status' => $tmp_seller['status'],
                'team_name' => $tmp_seller['team_name'],
                'fx_store_id' => $tmp_seller['fx_store_id'],
                'sales' => !empty($sales) ? number_format($sales, 2, '.', '') : '0.00',
                'profit' => !empty($profit) ? number_format($profit, 2, '.', '') : '0.00'
            );
        }

        $this->assign('sellerList', $sellerList);
        $this->assign('sellers', $sellers);
        $this->assign('drp_degree_list', $drp_degree_list);
        $this->assign('page', $page->show());
    }

    /* 分销订单列表 */
    public function seller_order()
    {
        $this->display();
    }

    public function seller_order_content()
    {
        $order = M('Order');
        $order_product = M('Order_product');
        $user = M('User');
        $where = array ();
        $where['store_id'] = $this->store_session['store_id'];
        $where['_string'] = 'type = 3 and user_order_id > 0';

        if (is_numeric($_POST['order_no']))
        {
            $where['order_no'] = $_POST['order_no'];
        }

        if (!empty($_POST['delivery_user']))
        {
            $where['address_user'] = $_POST['delivery_user'];
        }
        if (!empty($_POST['delivery_tel']))
        {
            $where['address_tel'] = array('like', $_POST['delivery_tel']."%");
        }

        $field = 'add_time';

        if (!empty($_POST['start_time']) && !empty($_POST['end_time']) && !empty($field))
        {
            $where['_string'] = "`" . $field . "` >= " . strtotime($_POST['start_time']) . " AND `" . $field . "` <= " . strtotime($_POST['end_time']);
        }
        else if (!empty($_POST['start_time']) && !empty($field))
        {
            $where[$field] = array ('>=', strtotime($_POST['start_time']));
        }
        else if (!empty($_POST['end_time']) && !empty($field))
        {
            $where[$field] = array ('<=', strtotime($_POST['end_time']));
        }
        //排序
        if (!empty($_POST['orderbyfield']) && !empty($_POST['orderbymethod']))
        {
            $orderby = "`{$_POST['orderbyfield']}` " . $_POST['orderbymethod'];
        }
        else
        {
            $orderby = '`order_id` DESC';
        }
        $order_total = $order->getOrderTotal($where);
        import('source.class.user_page');
        $page = new Page($order_total, 10);
        $tmp_orders = $order->getOrders($where, $orderby, $page->firstRow, $page->listRows);
        $orders = array ();
        foreach ($tmp_orders as $tmp_order)
        { //
            if (!empty($tmp_order['user_order_id']))
            {
                $products = $order_product->getProducts($tmp_order['user_order_id']);
                $order_sub_total = D('Order')->field('sub_total')->where(array ('order_id' => $tmp_order['user_order_id']))->find();
                $tmp_order['sub_total'] = number_format($order_sub_total['sub_total'], 2, '.', '');
            }
            else
            {
                $products = $order_product->getProducts($tmp_order['order_id']);
            }

            $tmp_order['products'] = $products;
            if (empty($tmp_order['uid']))
            {
                $tmp_order['is_fans'] = FALSE;
                $tmp_order['buyer'] = '';
            }
            else
            {
                $tmp_order['is_fans'] = TRUE;
                $user_info = $user->checkUser(array ('uid' => $tmp_order['uid']));
                $tmp_order['buyer'] = $user_info['nickname'];
            }

            // 是否有退货未完成的申请，有未完成的申请，暂时不给完成订单
            if ($tmp_order['status'] == 7)
            {
                $count = D('Return')->where("order_id = '" . $tmp_order['order_id'] . "' AND status IN (1, 3, 4)")->count('id');
                $tmp_order['returning_count'] = $count;
            }

            $is_supplier = FALSE;
            $is_packaged = FALSE;
            if (!empty($tmp_order['suppliers']))
            { //订单供货商
                $suppliers = explode(',', $tmp_order['suppliers']);
                if (in_array($this->store_session['store_id'], $suppliers))
                {
                    $is_supplier = TRUE;
                }
            }
            if (empty($tmp_order['suppliers']))
            {
                $is_supplier = TRUE;
            }

            $has_my_product = FALSE;
            foreach ($products as &$product)
            {
                $product['image'] = getAttachmentUrl($product['image']);
                if (empty($product['is_fx']))
                {
                    $has_my_product = TRUE;
                }

                //自营商品
                if (empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id'])
                {
                    $is_supplier = TRUE;
                }

                //商品来源
                if (empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id'])
                { //本店商品
                    $from = '本店商品';
                }
                else if (!empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id'] && !empty($product['wholesale_product_id']))
                { //批发商品
                    $from = '批发商品';
                    $product['is_ws'] = 1;
                }
                else
                { //分销商品
                    $from = '分销商品';
                }
                $product['from'] = $from;

                //向后兼容利润计算
                $no_profit = FALSE;
                if ($product['profit'] == 0)
                {
                    $fx_order = D('Fx_order')->field('fx_order_id')->where(array ('order_id' => $tmp_order['order_id']))->find();
                    $fx_order_product = D('Fx_order_product')->field('cost_price')->where(array ('fx_order_id' => $fx_order['fx_order_id'], 'source_product_id' => $product['product_id']))->find();
                    $product['cost_price'] = $fx_order_product['cost_price'];
                    $product['profit'] = $product['pro_price'] - $product['cost_price'];
                    if ($product['profit'] <= 0)
                    {
                        $product['profit'] = 0;
                        $no_profit = TRUE;
                    }
                }

                $product['cost_price'] = ($product['pro_price'] - $product['profit'] > 0) ? $product['pro_price'] - $product['profit'] : 0;
                if ($product['profit'] == 0 && empty($product['supplier_id']) && empty($no_profit))
                {
                    $product['profit'] = $product['pro_price'];
                    $product['cost_price'] = 0;
                }

                $product['profit'] = number_format($product['profit'], 2, '.', '');
                $product['cost_price'] = number_format($product['cost_price'], 2, '.', '');

                //退货商品
                $return_product = D('Return_product')->where(array ('order_id' => $tmp_order['order_id'], 'order_product_id' => $product['pigcms_id']))->find();
                if (!empty($return_product))
                {
                    $product['return_quantity'] = $return_product['pro_num'];
                }
            }

            if (!empty($tmp_order['user_order_id']))
            {
                $order_info = D('Order')->field('store_id')->where(array ('order_id' => $tmp_order['user_order_id']))->find();
                $seller = D('Store')->field('name,drp_level')->where(array ('store_id' => $order_info['store_id']))->find();
                $tmp_order['seller'] = $seller['name'];
                $tmp_order['drp_level'] = $seller['drp_level'];
            }
            else
            {
                $tmp_order['seller'] = '本店';
            }

            $un_package_selfsale_products = $order_product->getUnPackageProducts(array ('op.order_id' => $tmp_order['order_id'], 'p.store_id' => $this->store_session['store_id'], 'p.supplier_id' => 0));
            if (count($un_package_selfsale_products) == 0)
            {
                $is_packaged = TRUE;
            }

            $profit = M('Financial_record')->getTotal(array ('order_id' => $tmp_order['order_id']));
            $cost = M('Financial_record')->getTotal(array ('order_id' => $tmp_order['order_id'], 'income' => array ('<', 0)));
            $cost = abs($cost);
            if ($cost <= 0)
            {
                //$cost = $profit;
            }

            $tmp_order['products'] = $products;
            $tmp_order['has_my_product'] = $has_my_product;
            $tmp_order['is_supplier'] = $is_supplier;
            $tmp_order['is_packaged'] = $is_packaged;
            $tmp_order['profit'] = number_format($profit, 2, '.', '');
            $tmp_order['cost'] = number_format($cost, 2, '.', '');
            $tmp_order_id[] = $tmp_order['order_id'];
            $orders[] = $tmp_order;
        }
        /*************************************************************/
        if (count($tmp_order_id) > 0)
        {
            foreach ($tmp_order_id as $order_id)
            {
                $order_infos = $order->getOrder($this->store_session['store_id'], $order_id);

                $user_order_id = !empty($order_infos['user_order_id']) ? $order_infos['user_order_id'] : $order_id;
                $order_products = $order_product->getProducts($order_id);

                $where = array ();
                $where['_string'] = "(order_id = '" . $user_order_id . "' OR user_order_id = '" . $user_order_id . "')";
                if (!empty($this->store_session['drp_supplier_id']))
                {
                    if (empty($order_info['user_order_id']))
                    {
                        $tmps_order = D('Order')->field('order_id')->where(array ('order_id' => $order_id, 'order_id' => array ('>', $order_id)))->order('order_id ASC')->find();
                    }
                    else
                    {
                        $tmps_order = D('Order')->field('order_id')->where(array ('user_order_id' => $user_order_id, 'order_id' => array ('>', $order_id)))->order('order_id ASC')->find();
                    }
                    $tmp_order_id = $tmp_orders['order_id'];
                    $where['_string'] .= " AND order_id <= " . $tmp_order_id;
                }
                $commiss_orders = D('Order')->where($where)->order('order_id DESC')->select();

                $filter_postage = array ();
                $filter_order = array ();
                $filter_products = array ();
                foreach ($commiss_orders as $key => &$commiss_order)
                {
                    $is_filter = FALSE;
                    $store = D('Store')->field('store_id,name,drp_level,drp_supplier_id')->where(array ('store_id' => $commiss_order['store_id']))->find();
                    $commiss_order['seller'] = $store['name'];
                    $commiss_order['seller_drp_level'] = $store['drp_level'];
                    $commiss_order['order_key_id'] = $order_id;

                    if (empty($tmp_order['suppliers']) && empty($order_infos['suppliers']) && $commiss_order['store_id'] != $this->store_session['store_id'])
                    {
                        $filter_postage[$commiss_order['store_id']] = $commiss_order['postage'];
                        $filter_order[$commiss_order['store_id']] = $commiss_order['order_id'];
                        $is_filter = TRUE;
                        unset($orders[$key]); //过滤非当前店铺的订单
                    }

                    $suppliers = explode(',', $commiss_order['suppliers']);

                    if (!$is_filter && !empty($commiss_order['suppliers']))
                    {
                        foreach ($filter_postage as $supplier_id => $postage)
                        {
                            if (in_array($supplier_id, $suppliers))
                            {
                                $commiss_order['postage'] -= $postage;
                                $commiss_order['total'] -= $postage;
                                $commiss_order['profit'] -= $postage;

                                $filter_order_id = $filter_order[$supplier_id];
                                $tmp_filter_products = $order_product->getProducts($filter_order_id);
                                foreach ($tmp_filter_products as $tmp_product)
                                {
                                    $filter_products[] = $tmp_product['product_id'];
                                }
                            }
                        }
                    }

                    $profit = D('Financial_record')->where(array ('order_id' => $commiss_order['order_id']))->sum('income');
                    $commiss_order['profit'] = number_format($profit, 2, '.', '');

                    $commiss_order['seller_store'] = option('config.wap_site_url') . '/home.php?id=' . $commiss_order['store_id'];

                    //订单运费
                    $supplier_postage = unserialize($commiss_order['fx_postage']);
                    if (!empty($supplier_postage[$commiss_order['store_id']]))
                    {
                        $commiss_order['supplier_postage'] = $supplier_postage[$tmp_order['store_id']];
                    }
                    else if ($commiss_order['postage'] > 0 && empty($commiss_order['suppliers']))
                    {
                        $commiss_order['supplier_postage'] = $commiss_order['postage'];
                    }
                    else
                    {
                        $commiss_order['supplier_postage'] = 0;
                    }
                    $commiss_order['supplier_postage'] = number_format($commiss_order['supplier_postage'], 2, '.', '');

                    $products = $order_product->getProducts($commiss_order['order_id']);
                    $comment_count = 0;
                    $product_count = 0;
                    foreach ($products as $key2 => &$product)
                    {
                        //过滤商品.
                        if (in_array($product['original_product_id'], $filter_products) || ($product['store_id'] != $this->store_session['store_id']) && empty($product['supplier_id']) && empty($product['is_wholesale']) && !in_array($product['store_id'], $suppliers))
                        {
                            $product['profit'] = ($product['profit'] > 0) ? $product['profit'] : $product['pro_price'];
                            $commiss_order['sub_total'] -= ($product['pro_price'] * $product['pro_num']);
                            $commiss_order['total'] -= ($product['pro_price'] * $product['pro_num']);
                            $commiss_order['profit'] -= ($product['profit'] * $product['pro_num']);
                            unset($products[$key2]);
                        }
                        else
                        {
                            if (!empty($product['comment']))
                            {
                                $comment_count++;
                            }
                            $product_count++;

                            //商品来源
                            if (empty($product['supplier_id']) && $product['store_id'] == $commiss_order['store_id'])
                            { //本店商品
                                $from = '自营商品';
                            }
                            else if (!empty($product['supplier_id']) && $product['store_id'] == $commiss_order['store_id'] && !empty($product['wholesale_product_id']))
                            { //批发商品
                                $from = '批发商品';
                            }
                            else
                            { //分销商品
                                $from = '分销商品';
                            }
                            $product['from'] = $from;

                            $product['cost_price'] = ($product['pro_price'] - $product['profit'] > 0) ? $product['pro_price'] - $product['profit'] : 0;
                            if ($product['profit'] == 0 && empty($product['supplier_id']) && $commiss_order['store_id'] == $product['store_id'])
                            {
                                $product['profit'] = $product['pro_price'];
                                $product['cost_price'] = 0;
                            }
                            if ($product['cost_price'] == 0 && $from != '自营商品')
                            {
                                $product['cost_price'] = $product['pro_price'];
                            }
                            $product['cost_price'] = number_format($product['cost_price'], 2, '.', '');

                            if (!empty($product['wholesale_product_id']))
                            {
                                $commiss_order['is_wholesale'] = TRUE;
                            }
                        }
                        //退货商品
                        $return_product = D('Return_product')->where(array ('order_id' => $commiss_order['order_id'], 'order_product_id' => $product['pigcms_id']))->find();
                        if (!empty($return_product))
                        {
                            $product['return_quantity'] = $return_product['pro_num'];
                        }
                    }
                    $commiss_order['products'] = $products;
                    $commiss_order['rows'] = $comment_count + $product_count;
                    $commiss_order['comment_count'] = $comment_count;
                    if (($commiss_order['store_id'] == $this->store_session['store_id']) || empty($commiss_order['suppliers']))
                    {
                        $commiss_order['postage'] = number_format($commiss_order['postage'], 2, '.', '');
                    }
                    else
                    {
                        $commiss_order['postage'] = number_format($postage, 2, '.', '');
                    }
                }

                //收货地址
                $order_info['address'] = unserialize($order_infos['address']);

                // 订单来源
                if (empty($order_infos['user_order_id']))
                {
                    $order_infos['from'] = '本店';
                }
                else
                {
                    $tmp_order_info = D('Order')->field('uid,store_id,payment_method')->where(array ('order_id' => $order_info['user_order_id']))->find();
                    $seller = D('Store')->field('name')->where(array ('store_id' => $tmp_order_info['store_id']))->find();
                    $order_infos['from'] = $seller['name'];
                    $order_infos['payment_method'] = $tmp_order_info['payment_method'];
                    $order_infos['uid'] = $tmp_order_info['uid'];
                }
                $commission_orders[$order_id][] = $commiss_orders;
            }
        }
        //订单状态
        $order_status = $order->status();

        //订单状态别名
        $ws_alias_status = $order->ws_alias_status();

        //支付方式
        $payment_method = $order->getPaymentMethod();

        $this->assign('commission_orders', $commission_orders);
        $this->assign('order_status', $order_status);
        $this->assign('ws_alias_status', $ws_alias_status);
        $this->assign('status', $data['status']);
        $this->assign('payment_method', $payment_method);
        $this->assign('orders', $orders);
        $this->assign('page', $page->show());
    }

    //设置分销
    public function goods_fx_setting()
    {
        if (IS_POST) {
            $product = M('Product');
            $product_sku = M('Product_sku');

            $product_id     = !empty($_POST['product_id']) ? intval(trim($_POST['product_id'])) : 0;
            $cost_price     = !empty($_POST['cost_price']) ? floatval(trim($_POST['cost_price'])) : 0;
            $min_fx_price   = !empty($_POST['min_fx_price']) ? floatval(trim($_POST['min_fx_price'])) : 0;
            $max_fx_price   = !empty($_POST['max_fx_price']) ? floatval(trim($_POST['max_fx_price'])) : 0;
            $is_recommend   = !empty($_POST['is_recommend']) ? intval(trim($_POST['is_recommend'])) : 0;
            $unified_profit = !empty($_POST['unified_profit']) ? intval(trim($_POST['unified_profit'])) : 0;
            //供货商统一设置分销
            $unified_price_setting = 1;
            $is_fx_setting = 1;
            $type = !empty($_GET['type']) ? $_GET['type'] : '';
            $skus = !empty($_POST['skus']) ? $_POST['skus'] : array();
            //分销商等级利润
            $degrees_profit = !empty($_POST['degrees_profit']) ? $_POST['degrees_profit'] : array();
            $fx_type = 0; //分销类型 0全网、1排他
            if (strtolower(trim($_GET['role'])) == 'seller' || !empty($this->store_session['drp_supplier_id'])) {
                $fx_type = 1;
            }
            //统一零售价
            $unified_price = !empty($_POST['unified_price']) ? $_POST['unified_price'] : 0;
            $data = array (
                'cost_price'            => $cost_price,
                'min_fx_price'          => $min_fx_price,
                'max_fx_price'          => $max_fx_price,
                'is_recommend'          => $is_recommend,
                'unified_profit'        => $unified_profit,
                'is_fx'                 => 1, // 1 为已分销商品
                'fx_type'               => $fx_type,
                'is_fx_setting'         => $is_fx_setting,
                'unified_price_setting' => $unified_price_setting,
                'unified_price'         => $unified_price
            );
            $product_info = M('Product')->get(array ('product_id' => $product_id, 'store_id' => $_SESSION['store']['store_id']));

            //分销级别
            if (!empty($_SESSION['store']['drp_level'])) {
                $drp_level = $_SESSION['store']['drp_level'] + 1;
            } else {
                $drp_level = 1;
            }
            if ($drp_level > 3) { //超出三级分销商
                $drp_level = 3;
            }

            if (!empty($unified_price_setting) && empty($product_info['source_product_id'])) {
                $data['cost_price'] = !empty($_POST['drp_level_' . $drp_level . '_cost_price']) ? $_POST['drp_level_' . $drp_level . '_cost_price'] : 0;
                $data['min_fx_price'] = !empty($_POST['drp_level_' . $drp_level . '_price']) ? $_POST['drp_level_' . $drp_level . '_price'] : 0;
                $data['max_fx_price'] = !empty($_POST['drp_level_' . $drp_level . '_price']) ? $_POST['drp_level_' . $drp_level . '_price'] : 0;
                $data['drp_level_1_cost_price'] = !empty($_POST['drp_level_1_cost_price']) ? $_POST['drp_level_1_cost_price'] : 0;
                $data['drp_level_2_cost_price'] = !empty($_POST['drp_level_2_cost_price']) ? $_POST['drp_level_2_cost_price'] : 0;
                $data['drp_level_3_cost_price'] = !empty($_POST['drp_level_3_cost_price']) ? $_POST['drp_level_3_cost_price'] : 0;
                $data['drp_level_1_price'] = !empty($_POST['drp_level_1_price']) ? $_POST['drp_level_1_price'] : 0;
                $data['drp_level_2_price'] = !empty($_POST['drp_level_2_price']) ? $_POST['drp_level_2_price'] : 0;
                $data['drp_level_3_price'] = !empty($_POST['drp_level_3_price']) ? $_POST['drp_level_3_price'] : 0;
                $data['unified_profit'] = !empty($_POST['unified_profit']) ? intval(trim($_POST['unified_profit'])) : 0;
                $data['drp_custom_setting'] = 1;
                $result = $product->fxEdit($product_id, $data);
            } else if (!empty($product_info['unified_price_setting'])) {
                $result = D('Product')->where(array ('product_id' => $product_id))->data($data)->save();
            } else {
                $result = $product->fxEdit($product_id, $data);
            }
            if ($result) {
                if (!empty($skus)) {
                    $product_sku->fxEdit($product_id, $skus, $unified_price_setting);
                }

                //处理商品分销等级
                $check_drp_degree = M('Drp_degree')->checkDrpDegree($this->store_session['store_id']);
                if ($check_drp_degree && !empty($degrees_profit)) {
                    foreach ($degrees_profit as $degree_id => $degree_profit) {
                        if (!empty($degree_profit) && $degree_id > 0) {
                            $data = array();
                            $data['product_id']      = $product_id;
                            $data['store_id']        = $this->store_session['store_id'];
                            $data['degree_id']       = $degree_id; //分销等级id
                            $data['seller_reward_1'] = $degree_profit[1]; //一级分销商利润比
                            $data['seller_reward_2'] = $degree_profit[2]; //二级分销商利润比
                            $data['seller_reward_3'] = $degree_profit[3]; //三级分销商利润比
                            D('Product_drp_degree')->data($data)->add();
                        }
                    }
                }

                if ($type == 1) {
                    json_return(0, $type);
                } else {
                    json_return(0, url('supplier_market',array('is'=>1)));
                }
            } else {
                json_return(1001, '保存失败');
            }
        }
        $this->display();
    }

    private function _goods_fx_setting_content()
    {
        $product = M('Product');
        $category = M('Product_category');
        $product_property = M('Product_property');
        $product_property_value = M('Product_property_value');
        $product_to_property = M('Product_to_property');
        $product_to_property_value = M('Product_to_property_value');
        $product_sku = M('Product_sku');
        $id = isset($_POST['id']) ? intval(trim($_POST['id'])) : 0;
        $product = $product->get(array ('product_id' => $id, 'store_id' => $this->store_session['store_id']));
        if (!empty($product['supplier_id'])) { //分销商
            $edit_cost_price = FALSE;
            $readonly = '';
        } else { //供货商
            $edit_cost_price = TRUE;
            $readonly = '';
        }
        if (!empty($product['category_id']) && !empty($product['category_fid'])) {
            $parent_category = $category->getCategory($product['category_fid']);
            $category = $category->getCategory($product['category_id']);
            $product['category'] = $parent_category['cat_name'] . ' - ' . $category['cat_name'];
        } else if ($product['category_fid']) {
            $category = $category->getCategory($product['category_fid']);
            $product['category'] = $category['cat_name'];
        } else {
            $category = $category->getCategory($product['category_id']);
            $product['category'] = !empty($category['cat_name']) ? $category['cat_name'] : '其它';
        }

        $pids = $product_to_property->getPids($this->store_session['store_id'], $id);
        if (!empty($pids[0]['pid'])) {
            $pid = $pids[0]['pid'];
            $name = $product_property->getName($pid);
            $vids = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid);
            if (!empty($pids[1]['pid']) && !empty($pids[2]['pid'])) {
                $pid1 = $pids[1]['pid'];
                $name1 = $product_property->getName($pid1);
                $vids1 = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid1);
                $pid2 = $pids[2]['pid'];
                $name2 = $product_property->getName($pid2);
                $vids2 = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid2);
                $html2 = '<thead>';
                $html2 .= '    <tr>';
                $html2 .= '        <th class="text-center" width="80">' . $name . '</th>';
                $html2 .= '        <th class="text-center" width="80">' . $name1 . '</th>';
                $html2 .= '        <th class="text-center" width="80">' . $name2 . '</th>';
                $html2 .= '        <th class="th-price" style="width: 70px;text-align: center">成本价（元）</th>';
                $html2 .= '        <th class="th-price" style="width: 105px;text-align: center">分销价（元）</th>';
                $html2 .= '    </tr>';
                $html2 .= '</thead>';
                $html2 .= '<tbody>';
                foreach ($vids as $key => $vid) {
                    $value = $product_property_value->getValue($pid, $vid['vid']);
                    foreach ($vids1 as $key1 => $vid1) {
                        $value1 = $product_property_value->getValue($pid1, $vid1['vid']);
                        foreach ($vids2 as $key2 => $vid2) {
                            $properties = $pid . ':' . $vid['vid'] . ';' . $pid1 . ':' . $vid1['vid'] . ';' . $pid2 . ':' . $vid2['vid'];
                            $sku = $product_sku->getSku($id, $properties);
                            //$html .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                            $html2 .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                            $value2 = $product_property_value->getValue($pid2, $vid2['vid']);
                            if ($key1 == 0 && $key2 == 0)
                            {
                                //$html .= '    <td class="text-center" rowspan="' . count($vids1) * count($vids2) . '">' . $value . '</td>';
                                $html2 .= '    <td class="text-center" rowspan="' . count($vids1) * count($vids2) . '">' . $value . '</td>';
                            }
                            if ($key2 == 0)
                            {
                                //$html .= '    <td class="text-center" rowspan="' . count($vids2) . '">' . $value1 . '</td>';
                                $html2 .= '    <td class="text-center" rowspan="' . count($vids2) . '">' . $value1 . '</td>';
                            }

                            $html2 .= '        <td class="text-center" width="50">' . $value2 . '</td>';
                            $html2 .= '        <td style="text-align: center"><input type="hidden" value="'.$sku['price'].'" class="hidden_cost_sku_price"><input type="text" name="cost_sku_price" class="js-cost-price input-mini"  maxlength="10" /></td>';
                            $html2 .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price js-fx-price input-mini" maxlength="10" /></td>';
                            $html2 .= '    </tr>';
                        }
                    }
                }
            } else if (!empty($pids[1]['pid'])) {
                $pid1 = $pids[1]['pid'];
                $name1 = $product_property->getName($pid1);
                $vids1 = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid1);

                $html2 = '<thead>';
                $html2 .= '    <tr>';
                $html2 .= '        <th class="text-center" width="50">' . $name . '</th>';
                $html2 .= '        <th class="text-center" width="50">' . $name1 . '</th>';
                $html2 .= '        <th class="th-price" style="text-align: center">成本价（元）</th>';
                $html2 .= '        <th class="th-price" style="width: 105px;text-align: center">分销价（元）</th>';
                $html2 .= '    </tr>';
                $html2 .= '</thead>';
                $html2 .= '<tbody>';
                foreach ($vids as $key => $vid)
                {
                    $value = $product_property_value->getValue($pid, $vid['vid']);
                    foreach ($vids1 as $key1 => $vid1)
                    {
                        $properties = $pid . ':' . $vid['vid'] . ';' . $pid1 . ':' . $vid1['vid'];
                        $sku = $product_sku->getSku($id, $properties);
                        //$html .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                        $html2 .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                        $value1 = $product_property_value->getValue($pid1, $vid1['vid']);
                        if ($key1 == 0)
                        {
                            //$html .= '    <td class="text-center" rowspan="' . count($vids1) . '">' . $value . '</td>';
                            $html2 .= '    <td class="text-center" rowspan="' . count($vids1) . '">' . $value . '</td>';
                        }

                        $html2 .= '        <td class="text-center" width="50">' . $value1 . '</td>';
                        $html2 .= '        <td style="text-align: center"><input type="hidden" value="'.$sku['price'].'" class="hidden_cost_sku_price"><input type="text" name="cost_sku_price" class="js-cost-price input-mini" maxlength="10" />';
                        $html2 .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price js-fx-price input-mini" maxlength="10" /></td>';
                        $html2 .= '    </tr>';
                    }
                }
            }
            else
            {
                $html2 = '<thead>';
                $html2 .= '    <tr>';
                $html2 .= '        <th class="text-center" width="50">' . $name . '</th>';
                $html2 .= '        <th class="th-price" style="text-align: center">成本价（元）</th>';
                $html2 .= '        <th class="th-price" style="width: 105px;text-align: center">分销价（元）</th>';
                $html2 .= '    </tr>';
                $html2 .= '</thead>';
                $html2 .= '<tbody>';
                foreach ($vids as $key => $vid)
                {
                    $value = $product_property_value->getValue($pid, $vid['vid']);
                    $properties = $pid . ':' . $vid['vid'];
                    $sku = $product_sku->getSku($id, $properties);
                    //$html .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                    $html2 .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                    $value = $product_property_value->getValue($pid, $vid['vid']);

                    $html2 .= '        <td class="text-center" width="50">' . $value . '</td>';
                    $html2 .= '        <td style="text-align: center"><input type="hidden" value="'.$sku['price'].'" class="hidden_cost_sku_price"><input type="text" name="cost_sku_price" class="js-cost-price input-mini" maxlength="10" /></td>';
                    $html2 .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price js-fx-price input-mini" maxlength="10" /></td>';
                    $html2 .= '    </tr>';
                }
            }
            //$html .= '</tbody><tfoot><tr><td colspan="6"><div class="batch-opts">批量设置： <span class="js-batch-type"><a class="js-batch-cost" href="javascript:;">成本价</a>&nbsp;&nbsp;<a class="js-batch-price" href="javascript:;">分销价</a></span><span class="js-batch-form" style="display:none;"></span></div></td></tr></tfoot>';
            $html2 .= '</tbody><tfoot><tr><td colspan="6"><div class="batch-opts2">批量设置： <span class="js-batch-type2"><a class="js-batch-cost2" href="javascript:;">成本价</a>&nbsp;&nbsp;<a class="js-batch-price2" href="javascript:;">分销价</a></span><span class="js-batch-form2" style="display:none;"></span></div></td></tr></tfoot>';
        }

        $this->assign('edit_cost_price', $edit_cost_price);
        //$this->assign('sku_content', $html);
        $this->assign('sku_content2', $html2);
        if (!empty($product['source_product_id'])) {
            $source_product = M('Product')->get(array ('product_id' => $product['source_product_id'], 'store_id' => $product['supplier_id']));
            $min_fx_price = $source_product['min_fx_price'];
            $max_fx_price = $source_product['max_fx_price'];
            $cost_price = $source_product['cost_price'];

            if (!empty($product['unified_price_setting'])) {
                if (($_SESSION['store']['drp_level'] + 1) > 3) {
                    $next_drp_level = 3;
                } else {
                    $next_drp_level = $_SESSION['store']['drp_level'] + 1;
                }
                $cost_price = $source_product['drp_level_' . $next_drp_level . '_cost_price'];
                $min_fx_price = $source_product['drp_level_' . $next_drp_level . '_price'];
                $max_fx_price = $source_product['drp_level_' . $next_drp_level . '_price'];
            }
        } else {
            $min_fx_price = $product['min_fx_price'];
            $max_fx_price = $product['max_fx_price'];
            $cost_price = $product['cost_price'];
        }
        $this->assign('product', $product);
        $this->assign('min_fx_price', $min_fx_price);
        $this->assign('max_fx_price', $max_fx_price);
        $this->assign('cost_price', $cost_price);
        if (empty($product['supplier_id'])) {
            $is_supplier = TRUE;
        } else {
            $is_supplier = FALSE;
        }

        //分销商等级
        $check_drp_degree = M('Drp_degree')->checkDrpDegree($this->store_session['store_id']);
        if ($check_drp_degree) {
            $drp_degrees = M('Drp_degree')->getDrpDegrees(array('store_id' => $this->store_session['store_id'], 'status' => 1));
            $this->assign('drp_degrees', $drp_degrees);
        }

        $this->assign('check_drp_degree', $check_drp_degree);
        $this->assign('is_supplier', $is_supplier);
        $this->assign('drp_level', $_SESSION['store']['drp_level']);
        $this->assign('open_drp_setting_price', $this->store_session['open_drp_setting_price']);
        $this->assign('unified_price_setting', $this->store_session['unified_price_setting']);
    }

    public function delivery_address()
    {
        import('source.class.area');
        $user_address = M('User_address');

        if (IS_POST && !empty($_POST['type']))
        {
            $data = array ();
            $data['name'] = isset($_POST['name']) ? trim($_POST['name']) : '';
            $data['tel'] = isset($_POST['tel']) ? trim($_POST['tel']) : '';
            $data['province'] = isset($_POST['province']) ? intval(trim($_POST['province'])) : '';
            $data['city'] = isset($_POST['city']) ? intval(trim($_POST['city'])) : '';
            $data['area'] = isset($_POST['area']) ? intval(trim($_POST['area'])) : '';
            $data['address'] = isset($_POST['address']) ? trim($_POST['address']) : '';
            $data['zipcode'] = isset($_POST['zipcode']) ? intval(trim($_POST['zipcode'])) : '';
            $data['add_time'] = time();
            $data['uid'] = $this->user_session['uid'];
            if ($address_id = $user_address->add($data))
            {
                $address = new area();
                $address_detail = array ();
                $address_detail['address_id'] = $address_id;
                $address_detail['province'] = $address->get_name($data['province']);
                $address_detail['city'] = $address->get_name($data['city']);
                $address_detail['area'] = $address->get_name($data['area']);
                $address_detail['address'] = $data['address'];
                json_return(0, $address_detail);
            }
            else
            {
                json_return(1001, '收货地址添加失败');
            }
        }
        //收货地址
        $tmp_addresses = $user_address->getMyAddress($this->user_session['uid']);
        $addresses = array ();
        $address = new area();
        foreach ($tmp_addresses as $tmp_address)
        {
            $province = $address->get_name($tmp_address['province']);
            $city = $address->get_name($tmp_address['city']);
            $area = $address->get_name($tmp_address['area']);
            $addresses[] = array (
                'address_id' => $tmp_address['address_id'],
                'province' => $province,
                'city' => $city,
                'area' => $area,
                'address' => $tmp_address['address']
            );
        }
        echo json_encode($addresses);
        exit;
    }

    //分销经营统计
    public function statistics()
    {
        $this->display();
    }

    private function _statistics_content($data)
    {
        $order = M('Order');
        $financial_record = M('Financial_record');
        $store = M('Store');

        $store = $store->getStore($data['store_id']);

        //总销售额
        $sales = $order->getSales(array ('store_id' => $data['store_id'], 'is_fx' => 1, 'status' => array ('in', array (2, 3, 4, 7))));
        //退货
        $sql = "SELECT SUM(r.product_money + r.postage_money + (r.platform_point / o.point2money_rate)) AS return_total FROM " . option('system.DB_PREFIX') . "return r, " . option('system.DB_PREFIX') . "order o WHERE o.order_id = r.order_id AND o.store_id = '" . $this->store_session['store_id'] . "' AND o.user_order_id = 0 AND o.status IN (2,3,4,6,7)";
        $return = D('')->query($sql);
        $return_total = !empty($return[0]['return_total']) ? $return[0]['return_total'] : 0;
        $sales -= $return_total;
        $sales = ($sales > 0) ? $sales : 0;

        //总佣金
        $profit = $store['income'];

        $days = array ();
        if (empty($data['start_time']) && empty($data['stop_time'])) {
            for ($i = 6; $i >= 0; $i--) {
                $day = date("Y-m-d", strtotime('-' . $i . 'day'));
                $days[] = $day;
            }
        } else if (!empty($data['start_time']) && !empty($data['stop_time'])) {
            $start_unix_time = strtotime($data['start_time']);
            $stop_unix_time = strtotime($data['stop_time']);
            $tmp_days = round(($stop_unix_time - $start_unix_time) / 3600 / 24);
            $days = array ($data['start_time']);
            if ($data['stop_time'] > $data['start_time']) {
                for ($i = 1; $i < $tmp_days; $i++) {
                    $days[] = date("Y-m-d", strtotime($data['start_time'] . ' +' . $i . 'day'));
                }
                $days[] = $data['stop_time'];
            }
        } else if (!empty($data['start_time'])) { //开始时间到后6天的数据
            $stop_time = date("Y-m-d", strtotime($data['start_time'] . ' +7 day'));
            $days = array ($data['start_time']);
            for ($i = 1; $i <= 6; $i++) {
                $day = date("Y-m-d", strtotime($data['start_time'] . ' +' . $i . 'day'));
                $days[] = $day;
            }
        } else if (!empty($data['stop_time'])) { //结束时间前6天的数据
            $start_time = date("Y-m-d", strtotime($data['stop_time'] . ' -6 day'));
            $days = array ($start_time);
            for ($i = 1; $i <= 6; $i++) {
                $day = date("Y-m-d", strtotime($start_time . ' +' . $i . 'day'));
                $days[] = $day;
            }
        }

        //七天下单、付款、发货订单笔数和付款金额
        $tmp_days = array ();
        $days_sales = 0;
        $days_profits = 0;
        foreach ($days as $day) {
            //开始时间
            $start_time = strtotime($day . ' 00:00:00');
            //结束时间
            $stop_time = strtotime($day . ' 23:59:59');

            //订单
            $where = array();
            $where['store_id']      = $this->store_session['store_id'];
            $where['is_fx']         = 1;
            $where['status']        = array ('in', array (2, 3, 4, 7));
            $where['_string']       = "paid_time >= " . $start_time . ' AND paid_time <= ' . $stop_time;
            $tmp_days_7_orders = D('Order')->where($where)->select();

            //销售额
            $total = 0;
            //佣金
            $profit = 0;
            if (!empty($tmp_days_7_orders)) {
                foreach ($tmp_days_7_orders as $tmp_days_7_order) {
                    $tmp_order = D('Order')->field('total,pro_num')->where(array('order_id' => $tmp_days_7_order['order_id']))->find();
                    $total = $tmp_order['total'];

                    //退货金额
                    $sql = "SELECT SUM(r.product_money + r.postage_money + (r.platform_point / o.point2money_rate)) AS return_total FROM " . option('system.DB_PREFIX') . "return r, " . option('system.DB_PREFIX') . "order o WHERE o.order_id = r.order_id AND o.order_id = '" . $tmp_days_7_order['order_id'] . "' AND o.user_order_id = 0 AND o.status IN (2,3,4,6,7)";
                    $return = D('')->query($sql);
                    $return_total = !empty($return[0]['return_total']) ? $return[0]['return_total'] : 0;
                    $total = $total - $return_total;
                    $total = ($total > 0) ? $total : 0;

                    //佣金
                    $profit = $financial_record->drpProfit(array('order_id' => $tmp_days_7_order['order_id']));
                    $profit = ($profit > 0) ? $profit : 0;
                }
            }
            $days_7_sales[] = !empty($total) ? number_format($total, 2, '.', '') : '0.00';
            $days_7_profits[] = !empty($profit) ? number_format($profit, 2, '.', '') : 0;

            $tmp_days[] = "'" . $day . "'";
        }

        $days_sales = array_sum($days_7_sales);
        $days_profits = array_sum($days_7_profits);

        $days = '[' . implode(',', $tmp_days) . ']';
        $days_7_sales = '[' . implode(',', $days_7_sales) . ']';
        $days_7_profits = '[' . implode(',', $days_7_profits) . ']';

        $this->assign('sales', number_format($sales, 2, '.', ''));
        $this->assign('profit', number_format($profit, 2, '.', ''));
        $this->assign('days_sales', number_format($days_sales, 2, '.', ''));
        $this->assign('days_profits', number_format($days_profits, 2, '.', ''));
        $this->assign('days', $days);
        $this->assign('store', $store);
        $this->assign('days_7_sales', $days_7_sales);
        $this->assign('days_7_profits', $days_7_profits);
    }

    //分销配置
    public function setting()
    {
        $last_product = D('Product')->field('product_id')->where(array('store_id' => $this->store_session['store_id'], 'status' => 1))->order('product_id DESC')->find();
        $last_product['product_id'] = !empty($last_product['product_id']) ? $last_product['product_id'] : 0;
        $products = D('Product')->where(array('store_id' => $this->store_session['store_id'], 'status' => 1))->count('product_id');
        $custom_drp_last_product = D('Product')->field('product_id')->where(array('store_id' => $this->store_session['store_id'], 'status' => 1, 'drp_custom_setting' => 0))->order('product_id DESC')->find();;
        $custom_drp_last_product['product_id'] = !empty($custom_drp_last_product['product_id']) ? $custom_drp_last_product['product_id'] : 0;
        $custom_drp_products = D('Product')->where(array('store_id' => $this->store_session['store_id'], 'status' => 1, 'is_fx' => 1, 'drp_custom_setting' => 1))->count('product_id');
        $custom_drp_products = ($custom_drp_products > 0) ? $custom_drp_products : 0;

        $this->assign('last_product_id', $last_product['product_id']);
        $this->assign('products', $products);
        $this->assign('custom_drp_products', $custom_drp_products);
        $this->assign('custom_drp_last_product_id', $custom_drp_last_product['product_id']);
        $this->display();
    }

    private function _setting_content()
    {
        if (!empty($this->store_session['drp_supplier_id'])) {
            redirect(url('fx:seller_setting'));
        }
        $store = D('Store')->where(array('store_id' => $this->store_session['store_id']))->find();
        $this->assign('open_drp_approve', $store['open_drp_approve']);
        $this->assign('open_drp_guidance', $store['open_drp_guidance']);
        $this->assign('open_drp_limit', $store['open_drp_limit']);
        $this->assign('drp_limit_buy', $store['drp_limit_buy']);
        $this->assign('drp_limit_share', $store['drp_limit_share']);
        $this->assign('drp_limit_condition', $store['drp_limit_condition']);
        $this->assign('open_drp_diy_store', $store['open_drp_diy_store']);
        $this->assign('open_drp_setting_price', $store['open_drp_setting_price']);
        $this->assign('unified_price_setting', $store['unified_price_setting']);
        $this->assign('open_drp_subscribe', $store['open_drp_subscribe']);
        $this->assign('open_drp_subscribe_auto', $store['open_drp_subscribe_auto']);
        $this->assign('drp_subscribe_tpl', $store['drp_subscribe_tpl']);
        $this->assign('reg_drp_subscribe_tpl', $store['reg_drp_subscribe_tpl']);
        $this->assign('reg_drp_subscribe_img', $store['reg_drp_subscribe_img']);
        $this->assign('drp_subscribe_img', $store['drp_subscribe_img']);
        $this->assign('update_drp_store_info', $store['update_drp_store_info']);
        $this->assign('is_fanshare_drp', $store['is_fanshare_drp']);
        $this->assign('setting_fans_forever', $store['setting_fans_forever']);
        $this->assign('setting_canal_qrcode', $store['setting_canal_qrcode']);
        $this->assign('canal_qrcode_tpl', $store['canal_qrcode_tpl']);
        $this->assign('canal_qrcode_img', $store['canal_qrcode_img']);
        $this->assign('open_drp_degree_platform', option('config.open_drp_degree'));
        $this->assign('open_drp_degree_store', $store['open_drp_degree']);
        $this->assign('open_drp_team_platform', option('config.open_drp_team'));
        $this->assign('open_drp_team', $store['open_drp_team']);
        $this->assign('drp_deduct_point_month', $store['drp_deduct_point_month']);
        $this->assign('drp_deduct_point_sales', $store['drp_deduct_point_sales']);
        $this->assign('drp_deduct_point', $store['drp_deduct_point']);

        $platform_withdrawal_min = option('config.withdrawal_min_amount');
        $platform_withdrawal_min = ($platform_withdrawal_min > 0) ? $platform_withdrawal_min : 0;
        $this->assign('platform_withdrawal_min', number_format($platform_withdrawal_min, 2, '.', ''));
        $drp_withdrawal_min = ($store['drp_withdrawal_min'] > 0) ? $store['drp_withdrawal_min'] : 0;
        $this->assign('drp_withdrawal_min', number_format($drp_withdrawal_min, 2, '.', ''));

        $store_config = D('Store_config')->field('drp_profit_1,drp_profit_2,drp_profit_3,unified_profit,drp_original_setting')->where(array('store_id' => $this->store_session['store_id']))->find();
        $this->assign('store_config', $store_config);
    }

    //保存分销限制
    public function save_drp_limit()
    {
        $drp_limit_buy = !empty($_POST['drp_limit_buy']) ? floatval(trim($_POST['drp_limit_buy'])) : 0;
        $drp_limit_share = !empty($_POST['drp_limit_share']) ? intval(trim($_POST['drp_limit_share'])) : 0;
        $drp_limit_condition = !empty($_POST['drp_limit_condition']) ? intval(trim($_POST['drp_limit_condition'])) : 0;
        if (D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('drp_limit_buy' => $drp_limit_buy, 'drp_limit_share' => $drp_limit_share, 'drp_limit_condition' => $drp_limit_condition, 'last_edit_time' => time()))->save())
        {
            $_SESSION['store']['drp_limit_buy'] = $drp_limit_buy;
            $_SESSION['store']['drp_limit_share'] = $drp_limit_share;
            $_SESSION['store']['drp_limit_condition'] = $drp_limit_condition;
            json_return(0, '分销限制条件保存成功');
        }
        else
        {
            json_return(1001, '分销限制条件保存失败');
        }
    }

    //保存分销定价
    public function save_unified_price_setting()
    {
        $setting = !empty($_POST['setting']) ? trim($_POST['setting']) : 0;
        if (D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('unified_price_setting' => $setting))->save())
        {
            $_SESSION['store']['unified_price_setting'] = $setting;
            json_return(0, '分销定价保存成功');
        }
        else
        {
            json_return(1001, '分销定价保存失败');
        }
    }

    //保存分销申请关注公众号模板消息
    public function reg_drp_subscribe_tpl()
    {
        $reg_drp_subscribe_tpl = !empty($_POST['reg_drp_subscribe_tpl']) ? mysql_real_escape_string(trim($_POST['reg_drp_subscribe_tpl'])) : '';
        $reg_drp_subscribe_img = !empty($_POST['reg_drp_subscribe_img']) ? mysql_real_escape_string(trim($_POST['reg_drp_subscribe_img'])) : '';
        if (D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('reg_drp_subscribe_tpl' => $reg_drp_subscribe_tpl, 'reg_drp_subscribe_img' => $reg_drp_subscribe_img))->save())
        {
            $_SESSION['store']['reg_drp_subscribe_tpl'] = $reg_drp_subscribe_tpl;
            $_SESSION['store']['reg_drp_subscribe_img'] = $reg_drp_subscribe_img;
            json_return(0, '模板消息保存成功');
        }
        else
        {
            json_return(1001, '模板消息保存失败');
        }
    }

    public function canal_qrcode_tpl()
    {
        $canal_qrcode_tpl = !empty($_POST['canal_qrcode_tpl']) ? mysql_real_escape_string(trim($_POST['canal_qrcode_tpl'])) : '';
        $canal_qrcode_img = !empty($_POST['canal_qrcode_img']) ? mysql_real_escape_string(trim($_POST['canal_qrcode_img'])) : '';
        if (D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('canal_qrcode_tpl' => $canal_qrcode_tpl, 'canal_qrcode_img' => $canal_qrcode_img))->save())
        {
            $_SESSION['store']['canal_qrcode_tpl'] = $canal_qrcode_tpl;
            $_SESSION['store']['canal_qrcode_img'] = $canal_qrcode_img;
            json_return(0, '模板消息保存成功');
        }
        else
        {
            json_return(1001, '模板消息保存失败');
        }
    }

    //保存关注公众号模板消息
    public function drp_subscribe_tpl()
    {
        $drp_subscribe_tpl = !empty($_POST['drp_subscribe_tpl']) ? mysql_real_escape_string(trim($_POST['drp_subscribe_tpl'])) : '';
        $drp_subscribe_img = !empty($_POST['drp_subscribe_img']) ? mysql_real_escape_string(trim($_POST['drp_subscribe_img'])) : '';
        if (D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('drp_subscribe_tpl' => $drp_subscribe_tpl, 'drp_subscribe_img' => $drp_subscribe_img))->save())
        {
            $_SESSION['store']['drp_subscribe_tpl'] = $drp_subscribe_tpl;
            $_SESSION['store']['drp_subscribe_img'] = $drp_subscribe_img;
            json_return(0, '模板消息保存成功');
        }
        else
        {
            json_return(1001, '模板消息保存失败');
        }
    }

    //是否开启分销商等级
    public function drp_degree()
    {
        if (IS_POST) {
            if (strtolower($_POST['type']) == 'deduct_point_rule') {
                $drp_deduct_point_month = isset($_POST['drp_deduct_point_month']) ? intval(trim($_POST['drp_deduct_point_month'])) : 0;
                $drp_deduct_point_sales = isset($_POST['drp_deduct_point_sales']) ? intval(trim($_POST['drp_deduct_point_sales'])) : 0;
                $drp_deduct_point = isset($_POST['drp_deduct_point']) ? intval(trim($_POST['drp_deduct_point'])) : 0;
                $data = array(
                    'drp_deduct_point_month' => $drp_deduct_point_month,
                    'drp_deduct_point_sales' => $drp_deduct_point_sales,
                    'drp_deduct_point' => $drp_deduct_point
                );
                if (D('Store')->where(array('store_id' => $this->store_session['store_id']))->data($data)->save()) {
                    $_SESSION['store']['drp_deduct_point_month'] = $drp_deduct_point_month;
                    $_SESSION['store']['drp_deduct_point_sales'] = $drp_deduct_point_sales;
                    $_SESSION['store']['drp_deduct_point'] = $drp_deduct_point;
                    json_return(0, '扣除积分规则保存成功');
                } else {
                    json_return(1001, '扣除积分规则保存失败');
                }
            } else {
                $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : 0;
                $result = D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('open_drp_degree' => $status))->save();
                if ($result) {
                    $_SESSION['store']['open_drp_degree'] = $status;
                    echo true;
                } else {
                    echo false;
                }
            }
        }
    }

    //是否开启分销团队
    public function drp_team()
    {
        if (IS_POST) {
            $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : 0;
            $result = D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('open_drp_team' => $status))->save();
            if ($result) {
                $_SESSION['store']['open_drp_team'] = $status;
                echo true;
            } else {
                echo false;
            }
        }
    }

    //是否开启分销商审核/审核状态
    public function drp_approve()
    {
        $seller_id = isset($_POST['seller_id']) ? intval(trim($_POST['seller_id'])) : 0;
        if (!empty($seller_id))
        {
            //$result = D('Store')->where(array('store_id' => $seller_id, 'drp_supplier_id' => $this->store_session['store_id']))->data(array('drp_approve' => 1))->save();
            $result = D('Store')->where(array ('store_id' => $seller_id))->data(array ('drp_approve' => 1))->save();
            if ($result)
            {
                $_SESSION['store']['drp_approve'] = 1;
                json_return(0, '审核已通过');
            }
            else
            {
                json_return(1001, '审核失败，请重新审核');
            }
        }
        else
        {
            $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : 0;
            $result = D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('open_drp_approve' => $status))->save();
            if ($result)
            {
                $_SESSION['store']['open_drp_approve'] = $status;
                echo TRUE;
            }
            else
            {
                echo FALSE;
            }
        }
        exit;
    }

    //是否开启分销引导
    public function drp_guidance()
    {
        $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : 0;

        $data['open_drp_guidance'] = $status;
        if ($status) {  // 同时关闭店铺
            $data['order_notice_open'] = 0;
        }

        $result = D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data($data)->save();
        if ($result)
        {
            $_SESSION['store']['open_drp_guidance'] = $status;
            echo TRUE;
        }
        else
        {
            echo FALSE;
        }
    }

    //是否允许分销商修改店铺名称
    public function drp_update_store_info()
    {
        $supplier_store = M('Store_supplier');
        $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : 0;
        $result = D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('update_drp_store_info' => $status))->save();

        $sellerIdList = $supplier_store->getSellerList($this->store_session['store_id']);

        if (count($sellerIdList) > 0)
        {
            foreach ($sellerIdList as $id)
            {
                $results = D('Store')->where(array ('store_id' => $id['seller_id']))->data(array ('update_drp_store_info' => $status))->save();
            }
        }

        if ($result)
        {
            $_SESSION['store']['update_drp_store_info'] = $status;
            echo TRUE;
        }
        else
        {
            echo FALSE;
        }
    }

    //是否开启分销限制
    public function drp_limit()
    {
        $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : 0;
        $result = D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('open_drp_limit' => $status))->save();
        if ($result)
        {
            $_SESSION['store']['open_drp_limit'] = $status;
            echo TRUE;
        }
        else
        {
            echo FALSE;
        }
    }

    //是否设置分销商最低提现金额
    public function drp_withdrawal_min()
    {
        $drp_withdrawal_min = isset($_POST['drp_withdrawal_min']) ? intval(trim($_POST['drp_withdrawal_min'])) : 0;
        $drp_withdrawal_min = number_format($drp_withdrawal_min, 2, '.', '');
        $result = D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('drp_withdrawal_min' => $drp_withdrawal_min))->save();
        if ($result) {
            $_SESSION['store']['drp_withdrawal_min'] = $drp_withdrawal_min;
            json_return(0, '分销商最低提现金额保存成功');
        } else {
            json_return(1001, '分销商最低提现金额保存失败');
        }
    }

    //是否开启店铺装修
    public function drp_diy_store()
    {
        $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : 0;
        $result = D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('open_drp_diy_store' => $status))->save();
        if ($result)
        {
            $_SESSION['store']['open_drp_diy_store'] = $status;
            echo TRUE;
        }
        else
        {
            echo FALSE;
        }
    }

    //是否开启分销定价
    public function drp_setting_price()
    {
        $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : 0;
        $result = D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('open_drp_setting_price' => $status))->save();
        if ($result)
        {
            $_SESSION['store']['open_drp_setting_price'] = $status;
            echo TRUE;
        }
        else
        {
            echo FALSE;
        }
    }

    //禁用/启用当前分销商店铺
    public function drp_status()
    {
        $store = M('Store');
        $store_supplier = M('Store_supplier');
        $seller_id = isset($_POST['seller_id']) ? intval(trim($_POST['seller_id'])) : 0; //分销商id
        $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : 0; //状态

        if ($store->setting(array ('store_id' => $seller_id), array ('status' => $status)))
        {
            /*$sellers = $store_supplier->getSellers(array('supplier_id' => $seller_id));
            var_dump($sellers);exit;
            foreach ($sellers as $seller) {
                $store->setting(array('store_id' => $seller['seller_id']), array('status' => $status));
                $this->_seller_status($store_supplier, $store, $seller['seller_id'], $status);
            }*/
            json_return(0, '操作成功');
        }
        else
        {
            json_return(1001, '操作失败');
        }
    }

    //关注公众号
    public function drp_subscribe()
    {
        $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : 0;
        $result = D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('open_drp_subscribe' => $status))->save();
        if ($result)
        {
            $_SESSION['store']['open_drp_subscribe'] = $status;
            echo TRUE;
        }
        else
        {
            echo FALSE;
        }
    }

    //自动分销（关注公众号）
    public function drp_subscribe_auto()
    {
        $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : 0;
        $result = D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('open_drp_subscribe_auto' => $status))->save();
        if ($result)
        {
            $_SESSION['store']['open_drp_subscribe_auto'] = $status;
            echo TRUE;
        }
        else
        {
            echo FALSE;
        }
    }

    //校验密码
    public function check_password()
    {
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';
        if ($password)
        {
            $password = md5($password);
        }
        $uid = $this->user_session['uid'];
        if (D('User')->where(array ('uid' => $uid, 'password' => $password))->count('uid'))
        {
            json_return(0, '密码正确');
        }
        else
        {
            json_return(1001, '密码错误');
        }
    }

    private function _seller_status($store_supplier, $store, $seller_id, $status)
    {
        $sellers = $store_supplier->getSellers(array ('supplier_id' => $seller_id));
        if (!empty($sellers))
        {
            foreach ($sellers as $seller)
            {
                $store->setting(array ('store_id' => $seller['seller_id']), array ('status' => $status));
                $this->_seller_status($store_supplier, $store, $seller['seller_id'], $status);
            }
        }
    }

    public function distribution_index()
    {
        $this->display();
    }

    private function distribution_index_content()
    {
        $store = M('Store');
        $product = M('Product');
        $order = M('Order');
        $fx_order = M('Fx_order');
        $financial_record = M('Financial_record');
        $store_supplier = M('Store_supplier');

        $supplierId = $this->store_session['store_id'];

        //分销层级
        $levelList = array ();
        $sellerLevelList = $store_supplier->getAllSellerId($supplierId);
        foreach ($sellerLevelList as $sellerList) {
            $levelList[] = $sellerList['level'];
        }
        if (count($levelList) > 0) {
            $maxLevel = $levelList[array_search(max($levelList), $levelList)];
        } else {
            $maxLevel = 0;
        }

        //分销商数量
        $all_sellers = M('Store')->getSellerCountBySales(array('store_id' => $supplierId), $this->store_session['drp_supplier_id']);

        //七天销售额、佣金
        $days_7_sales = array ();
        $days_7_profits = array ();

        $days = array ();
        $tmp_days = array ();
        for ($i = 6; $i >= 0; $i--) {
            $day = date("Y-m-d", strtotime('-' . $i . 'day'));
            $days[] = $day;
        }
        //七日新增分销商
        $days_7_sellers = array ();
        $days_7_product_sales = 0;
        $days_7_sales_total = 0;
        $days_7_orders = array ();
        //七日新增分销商统计
        $days_7_new_sellers = 0;
        $days_7_min = min($days);
        $days_7_max = max($days);
        //开始时间
        $start_time = strtotime($days_7_min . ' 00:00:00');
        //结束时间

        $where = array ();
        $stop_time = strtotime($days_7_max . ' 23:59:59');
        $where['store_id'] = $this->store_session['store_id'];
        $where['_string']       = "date_added >= " . $start_time . ' AND date_added <= ' . $stop_time;
        $tmp_days_7_new_sellers = M('Store')->getSellerCountBySales($where, $start_time, $stop_time);
        $days_7_new_sellers = $tmp_days_7_new_sellers;
        //七日分销量（商品）
        $days_7_product_sales = 0;

        foreach ($days as $day)
        {
            //开始时间
            $start_time = strtotime($day . ' 00:00:00');
            //结束时间
            $stop_time = strtotime($day . ' 23:59:59');

            $where = array ();
            $where['store_id'] = $this->store_session['store_id'];
            $where['_string'] = "add_time >= " . $start_time . " AND add_time < " . $stop_time;
            $tmp_days_7_profits = $financial_record->drpProfit($where);
            $days_7_profits[] = !empty($tmp_days_7_profits) ? number_format($tmp_days_7_profits, 2, '.', '') : 0;

            //分销商总数
            $where = array ();
            $where['store_id']      = $this->store_session['store_id'];
            $where['_string']       = 'date_added <= ' . $stop_time;
            $tmp_every_day_sellers = M('Store')->getSellerCountBySales($where, 0, $stop_time);
            $days_7_sellers[] = $tmp_every_day_sellers;


            //七日订单量
            $where = array();
            $where['store_id']      = $this->store_session['store_id'];
            $where['user_order_id'] = array('>', 0);
            $where['type']          = array('!=', 5);
            $where['_string']       = "paid_time >= " . $start_time . ' AND paid_time <= ' . $stop_time;
            $tmp_days_7_orders = D('Order')->where($where)->select();
            $days_7_orders[] = count($tmp_days_7_orders);

            //七日分销额
            $total = 0;
            if (!empty($tmp_days_7_orders)) {
                foreach ($tmp_days_7_orders as $tmp_days_7_order) {
                    if (in_array($tmp_days_7_order['status'], array(2,3,4,7))) {
                        $tmp_order = D('Order')->field('total,pro_num,point2money_rate')->where(array('order_id' => $tmp_days_7_order['user_order_id']))->find();
                        $total += $tmp_order['total'];
                        $quantity = $tmp_order['pro_num'];

                        //退货金额
                        $return_total = D('Return')->where(array('order_id' => $tmp_days_7_order['order_id']))->sum('product_money + postage_money');
                        $total -= $return_total;
                        //退平台积分
                        $return_point = D('Return')->where(array('order_id' => $tmp_days_7_order['order_id']))->sum('platform_point');
                        $return_point_money = ($return_point / $tmp_order['point2money_rate']);
                        $total -= $return_point_money;
                        $total = ($total > 0) ? $total : 0;
                        //退货数量
                        $return_quantity = D('Return_product')->where(array('order_id' => $tmp_days_7_order['order_id']))->sum('pro_num');
                        $quantity = $quantity - $return_quantity;
                        //七日分销量（商品）
                        $days_7_product_sales += $quantity;
                    }
                }
            }
            $days_7_sales_total += $total;
            $days_7_sales[] = !empty($total) ? number_format($total, 2, '.', '') : '0.00';

            $tmp_days[] = "'" . $day . "'";
        }

        $days_7_sellers = '[' . implode(',', $days_7_sellers) . ']';
        $days_7_orders = '[' . implode(',', $days_7_orders) . ']';
        $days = '[' . implode(',', $tmp_days) . ']';
        $days_7_sales = '[' . implode(',', $days_7_sales) . ']';
        $days_7_profits = '[' . implode(',', $days_7_profits) . ']';

        $this->assign('days', $days);
        $this->assign('days_7_sales', $days_7_sales);
        $this->assign('days_7_profits', $days_7_profits);
        $this->assign('days_7_new_sellers', $days_7_new_sellers); //七日新增
        $this->assign('days_7_sellers', $days_7_sellers); //七日新增
        $this->assign('maxLevel', $maxLevel);
        $this->assign('all_sellers', $all_sellers);
        $this->assign('days_7_orders', $days_7_orders);//七日订单量
        $this->assign('days_7_product_sales', $days_7_product_sales);
        $this->assign('days_7_sales_total', number_format($days_7_sales_total, 2, '.', ''));//
    }

    public function distribution(){
        $this->display();
    }

    private function distribution_rank_content(){
        $is = !empty($_POST['is']) ? $_POST['is'] : '1';

        if($is == 1) {//分销商排名
            $store = M('Store');
            $where = array();
            $where['store_id'] = $this->store_session['store_id'];

            if (!empty($_POST['store_name'])) {
                $where['s.name'] = array('like', '%' . trim($_POST['store_name']) . '%');
            }
            if (!empty($_POST['team_name'])) {
                $where['team.name'] = array('like', '%' . trim($_POST['team_name']) . '%');
            }

            if (!empty($_POST['start_time']) && !empty($_POST['end_time'])) {
                $start_time = strtotime(trim($_POST['start_time']));
                $end_time = strtotime(trim($_POST['end_time']));
                $where['_string'] = "s.date_added >= '" . $start_time . "' AND s.date_added <= '" . $end_time . "'";
            } else if (!empty($_POST['start_time'])) {
                $start_time = strtotime(trim($_POST['start_time']));
                $where['s.date_added'] = array('>=', $start_time);
            } else if (!empty($_POST['end_time'])) {
                $end_time = strtotime(trim($_POST['end_time']));
                $where['s.date_added'] = array('<=', $end_time);
            }

            //排序
            $order_field = 's.sales';
            $order_method = 'DESC';
            if (!empty($_POST['order_field'])) {
                $order_field = 's.' . trim($_POST['order_field']);
            }
            if (!empty($_POST['order_method'])) {
                $order_method = trim($_POST['order_method']);
            }
            $order_by = $order_field . " " . $order_method;

            $sellers_count = $store->getSellerCountBySales($where);
            import('source.class.user_page');
            $page = new Page($sellers_count, 10);

            $sellerRank = $store->getSellersBySales($where, $order_by, $page->firstRow, $page->listRows);
            foreach ($sellerRank as &$seller) {
                $degree_alias = D('Drp_degree')->field('degree_icon_custom,degree_alias')->where(array('pigcms_id' => $seller['drp_degree_id']))->find();
                if (empty($degree_alias['degree_icon_custom'])) {
                    $sql = "select pla.icon,pla.name from " . option('system.DB_PREFIX') . "drp_degree as drp left join " . option('system.DB_PREFIX') . "platform_drp_degree as pla on drp.is_platform_degree_name=pla.pigcms_id where drp.pigcms_id = " . $seller['drp_degree_id'];
                    $list = D('Drp_degree')->query($sql);
                    $seller['icon'] = getAttachmentUrl($list[0]['icon']);

                    $seller['degree_name'] = $list[0]['name'];
                } else {
                    $seller['icon'] = getAttachmentUrl($degree_alias['degree_icon_custom']);
                    $seller['degree_name'] = $degree_alias['degree_alias'];
                }
                $seller['sales'] = number_format($seller['sales'], 2, '.', '');
                $seller['logo'] = getAttachmentUrl($seller['logo']);
                $seller['store_name'] = $seller['store_name'];
                $seller['team_name'] = $seller['team_name'];
                $seller['store_sales'] = $seller['store_sales'];
                $seller['store_logo'] = $seller['store_logo'];
                $seller['fx_store_id'] = $seller['fx_store_id'];
                $seller['store_status'] = $seller['store_status'];
            }
            $this->assign('sellerRank', $sellerRank);
            $this->assign('page', $page->show());
            $this->assign('is', $is);
        }else if ($is == 2){ //团队排名
            $drp_team_model = M('Drp_team');
            $is_drp_team_owner = false; //是否为团队所有者

            //供货商
            import('source.class.user_page');
            $where = array();
            $where['dt.supplier_id'] = $this->store_session['store_id'];
            if (!empty($_POST['name'])) {
                $where['dt.name'] = array('like', '%' . trim($_POST['name']) . '%');
            }
            if (!empty($_POST['owner'])) {
                $where['s.name'] = array('like', '%' . trim($_POST['owner']) . '%');
            }
            if (!empty($_POST['start_time']) && !empty($_POST['end_time'])) {
                $start_time = strtotime(trim($_POST['start_time']));
                $end_time = strtotime(trim($_POST['end_time']));
                $where['_string'] = "dt.add_time >= '" . $start_time . "' AND dt.add_time <= '" . $end_time . "'";
            } else if (!empty($_POST['start_time'])) {
                $start_time = strtotime(trim($_POST['start_time']));
                $where['dt.add_time'] = array('>=', $start_time);
            } else if (!empty($_POST['end_time'])) {
                $end_time = strtotime(trim($_POST['end_time']));
                $where['dt.add_time'] = array('<=', $end_time);
            }
            $drp_team_count = $drp_team_model->getDrpTeamCount($where);
            $page = new Page($drp_team_count, 10);
            //排序
            $order_field = 'dt.pigcms_id';
            $order_method = 'DESC';
            if (!empty($_POST['order_field'])) {
                $order_field = 'dt.' . trim($_POST['order_field']);
            }
            if (!empty($_POST['order_method'])) {
                $order_method = trim($_POST['order_method']);
            }
            $order_by = $order_field . " " . $order_method;
            $drp_teams = $drp_team_model->getDrpTeams($where, $order_by, $page->firstRow, $page->listRows);

            $this->assign('drp_teams', $drp_teams);
            $this->assign('page', $page->show());
            $this->assign('is', $is);
        }

    }

    public function my_seller_detail()
    {
        $store_supplier = M('Store_supplier');
        $supplierId = $this->store_session['store_id'];
        $where = array ();
        $where['s.status'] = array ('>', 0);

        // 判断当前登录帐号等级
        $currentLevel = $store_supplier->getSeller(array (
            'supplier_id' => $supplierId
        ));

        $this->assign('currentLevel', $currentLevel['level']);

        $this->display();
    }

    private function _seller_detail_content($data)
    {
        $store_supplier = M('Store_supplier');
        $store = M('Store');
        $order = M('Order');

        $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
        $approve = isset($_POST['approve']) ? trim($_POST['approve']) : '*';
        $level = intval(isset($_POST['level']) ? trim($_POST['level']) : '1');
        $supplierId = empty($data['store_id']) ? $_POST['store_id'] : $data['store_id'];

        //分销详情
        $fxStoreInfo = D('Store')->where(array('store_id'=>$supplierId))->find();
        $nextLevel = $fxStoreInfo['drp_level'] + 1;
        $nextLevelTwo = $fxStoreInfo['drp_level'] + 2;
        $sql = "select count(pigcms_id) as id from ".option('system.DB_PREFIX')."store_supplier where find_in_set({$supplierId},supply_chain) and level={$nextLevel}";
        $nextSellerNum = D('Store_supplier')->query($sql);

        $sql1 = "select count(pigcms_id) as id from ".option('system.DB_PREFIX')."store_supplier where find_in_set({$supplierId},supply_chain) and level={$nextLevelTwo}";
        $nextTwoSellerNum = D('Store_supplier')->query($sql1);

        $where = array ();
        $where['s.status'] = array ('>', 0);

        if ($keyword != '')
        {
            $where['s.name'] = array ('like' => '%' . $keyword . '%');
        }
        if (is_numeric($approve) || $approve != '*')
        {
            $where['s.drp_approve'] = $approve;
        }
        if (!empty($_SESSION['store_sync']))
        {
            $where['ss.type'] = 1;
        }

        /* 获取当前等级 */
        $currentLevel = $store_supplier->getSeller(array (
            'seller_id' => $supplierId
        ));

        $prevSellerNum = $currentLevel['level'] - 1;
        $sellerInfo = D('Store')->where(array('store_id'=>$supplierId))->find();    //分销商详情

        //判断当前分销商等级
        $currentSellerLevel = $store_supplier->getSeller(array (
            'seller_id' => $supplierId
        ));

        /* 上级所有分销商 */
        if ($level == '1')
        {
            $supplierSpan = $store_supplier->getSeller(array (
                'seller_id' => $supplierId
            ));

            for ($i = 0; $i < $currentSellerLevel['level']; $i++)
            {
                $supplierSpan = $store_supplier->getSeller(array (
                    'seller_id' => $supplierId
                ));

                $supplierIdList[] = $supplierSpan['supplier_id'];

                $supplierId = $supplierSpan['supplier_id'];
            }
        }
        else if ($level == '2')
        {
            $sellerList = $store_supplier->getNextSellers($supplierId, $currentSellerLevel['level'] + 1);
        }
        else if ($level == '3')
        {
            $sellerList = $store_supplier->getNextSellers($supplierId, $currentSellerLevel['level'] + 2);
        }

        if ($level == '1')
        {
            $sellerIdList = rtrim(implode(',', $supplierIdList), ',');
        }
        else
        {
            $sellerIdList = array ();
            if (count($sellerList) > 0)
            {
                foreach ($sellerList as $sellerId)
                {
                    $sellerIdList[] = $sellerId['seller_id'];
                }

                $sellerIdList = rtrim(implode(',', $sellerIdList), ',');
            }
        }

        $where['ss.seller_id'] = array ('in' => $sellerIdList);

        $seller_count = $store_supplier->seller_count($where);
        import('source.class.user_page');
        $page = new Page($seller_count, 15);
        $tmp_sellers = $store_supplier->sellers($where, $page->firstRow, $page->listRows);

        $sellers = array ();
        foreach ($tmp_sellers as $tmp_seller)
        {
            $sales = $order->getSales(array ('store_id' => $tmp_seller['store_id'], 'is_fx' => 1, 'status' => array ('in', array (2, 3, 4, 7))));
            $profit = $tmp_seller['income'];
            $sellers[] = array (
                'store_id' => $tmp_seller['store_id'],
                'name' => $tmp_seller['name'],
                'drp_level' => $tmp_seller['drp_level'],
                'service_tel' => $tmp_seller['service_tel'],
                'service_qq' => $tmp_seller['service_qq'],
                'store_logo' => !empty($tmp_seller['store_logo']) ? getAttachmentUrl($tmp_seller['store_logo'], FALSE) : getAttachmentUrl('images/default_shop.png', FALSE),
                'service_weixin' => $tmp_seller['service_weixin'],
                'drp_approve' => $tmp_seller['drp_approve'],
                'status' => $tmp_seller['status'],
                'sales' => !empty($sales) ? number_format($sales, 2, '.', '') : '0.00',
                'profit' => !empty($profit) ? number_format($profit, 2, '.', '') : '0.00'
            );
        }

        $this->assign('sellerList', $sellerList);
        $this->assign('sellers', $sellers);
        $this->assign('page', $page->show());
        $this->assign('sellerInfo', $sellerInfo);
        $this->assign('currentLevel', $currentLevel);
        $this->assign('prevSellerNum', $prevSellerNum);
        $this->assign('nextSellerNum', $nextSellerNum[0]['id']);
        $this->assign('level', $level);
        $this->assign('supplierId', $supplierId);
        $this->assign('nextTwoSellerNum', $nextTwoSellerNum[0]['id']);
    }

    //设置批发
    public function goods_wholesale_setting()
    {
        if (IS_POST) {
            if (!$this->checkFx(true)) {
                json_return(1001, '保存失败');
            }

            $product = M('Product');
            $product_sku = M('Product_sku');

            $product_id = !empty($_POST['product_id']) ? intval(trim($_POST['product_id'])) : 0;
            $cost_price = !empty($_POST['wholesale_price']) ? floatval(trim($_POST['wholesale_price'])) : 0; // 批发价
            $min_fx_price = !empty($_POST['sale_min_price']) ? floatval(trim($_POST['sale_min_price'])) : 0; //最低零售价
            $max_fx_price = !empty($_POST['sale_max_price']) ? floatval(trim($_POST['sale_max_price'])) : 0; //最高零售价
            $is_recommend = !empty($_POST['is_recommend']) ? intval(trim($_POST['is_recommend'])) : 0;
            $is_whitelist = !empty($_POST['is_whitelist']) ? intval(trim($_POST['is_whitelist'])) : 0;

            $skus = !empty($_POST['skus']) ? $_POST['skus'] : array ();
            $seller_ids = !empty($_POST['seller_id']) ? $_POST['seller_id'] : array();
//var_dump($skus);
            $fx_type = 0; //分销类型 0全网、1排他

            $data = array (
                'wholesale_price' => $cost_price,
                'sale_min_price' => $min_fx_price,
                'sale_max_price' => $max_fx_price,
                'is_recommend' => $is_recommend,
                'is_whitelist' => $is_whitelist,
                'is_wholesale' => 1,
                'fx_type' => $fx_type,
            );

            $result = D('Product')->where(array ('product_id' => $product_id))->data($data)->save();
            //批发商品
            $whole_products = D('Product')->field('product_id,has_property')->where(array('wholesale_product_id'=>$product_id,'status'=>2))->select();

            if ($result) {
                if(count($seller_ids) > 0) {
                    D('Product_whitelist')->where(array('product_id'=>$product_id,'supplier_id'=>$this->store_session['store_id']))->delete();
                    foreach($seller_ids as $seller_id) {
                        $seller_data = array (
                            'product_id' => $product_id,
                            'supplier_id' => $this->store_session['store_id'],
                            'add_time' => time(),
                            'seller_id' => $seller_id['seller_id'],
                        );
                         D('Product_whitelist')->data($seller_data)->add();
                    }
                }

                if (!empty($skus)){
                    $product_sku->wholesaleEdit($product_id, $skus);
                }
                //
                if(count($whole_products)>0){

                    foreach($whole_products as $wh_product){

                        D('Product')->where(array('product_id'=>$wh_product['product_id']))->data(array(
                            'wholesale_price' => $cost_price,
                            'sale_min_price' => $min_fx_price,
                            'price' => $min_fx_price,
                            'sale_max_price' => $max_fx_price,
                            'is_recommend' => $is_recommend,
                            'is_whitelist' => $is_whitelist,
                            'is_wholesale' => 0,
                            'fx_type' => $fx_type,
                            'status' => 1,
                        ))->save();

                        if(!empty($wh_product['has_property'])){
                            foreach($skus as $sku){
                               D('Product_sku')->where(array('wholesale_sku_id'=>$sku['sku_id']))->data(array(
                                'wholesale_price' => $sku['wholesale_price'],
                                'sale_min_price' => $sku['sale_min_price'],
                                'sale_max_price' => $sku['sale_max_price'],
                                'price' => $sku['sale_min_price'],
                            ))->save();
                            }
                        }

                    }
                }
                json_return(0, url('supplier_market',array('is'=>2)));
            } else {
                json_return(1001, '保存失败');
            }
        }

        $this->checkFx(false, true);

        $this->display();
    }

    private function _goods_wholesale_setting_content()
    {
        $product = M('Product');
        $category = M('Product_category');
        $product_property = M('Product_property');
        $product_property_value = M('Product_property_value');
        $product_to_property = M('Product_to_property');
        $product_to_property_value = M('Product_to_property_value');
        $product_sku = M('Product_sku');

        $id = isset($_POST['id']) ? intval(trim($_POST['id'])) : 0;

        $product = $product->get(array ('product_id' => $id, 'store_id' => $this->store_session['store_id']));

        if (!empty($product['supplier_id']))
        { //分销商
            $edit_cost_price = FALSE;
            $readonly = '';
        }
        else
        { //供货商
            $edit_cost_price = TRUE;
            $readonly = '';
        }
        if (!empty($product['category_id']) && !empty($product['category_fid']))
        {
            $parent_category = $category->getCategory($product['category_fid']);
            $category = $category->getCategory($product['category_id']);
            $product['category'] = $parent_category['cat_name'] . ' - ' . $category['cat_name'];
        }
        else if ($product['category_fid'])
        {
            $category = $category->getCategory($product['category_fid']);
            $product['category'] = $category['cat_name'];
        }
        else
        {
            $category = $category->getCategory($product['category_id']);
            $product['category'] = !empty($category['cat_name']) ? $category['cat_name'] : '其它';
        }

        $pids = $product_to_property->getPids($this->store_session['store_id'], $id);

        if (!empty($pids[0]['pid']))
        {
            $pid = $pids[0]['pid'];
            $name = $product_property->getName($pid);
            $vids = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid);
            if (!empty($pids[1]['pid']) && !empty($pids[2]['pid']))
            {
                $pid1 = $pids[1]['pid'];
                $name1 = $product_property->getName($pid1);
                $vids1 = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid1);
                $pid2 = $pids[2]['pid'];
                $name2 = $product_property->getName($pid2);
                $vids2 = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid2);
                $html = '<thead>';
                $html .= '    <tr>';
                $html .= '        <th class="text-center" width="80">' . $name . '</th>';
                $html .= '        <th class="text-center" width="80">' . $name1 . '</th>';
                $html .= '        <th class="text-center" width="80">' . $name2 . '</th>';
                $html .= '        <th class="th-price" style="width: 70px;text-align: center">批发价（元）</th>';
                $html .= '        <th class="th-price" style="width: 105px;text-align: center">零售价（元）</th>';
                $html .= '    </tr>';
                $html .= '</thead>';
                $html .= '<tbody>';
                $html2 = '<thead>';
                $html2 .= '    <tr>';
                $html2 .= '        <th class="text-center" width="80">' . $name . '</th>';
                $html2 .= '        <th class="text-center" width="80">' . $name1 . '</th>';
                $html2 .= '        <th class="text-center" width="80">' . $name2 . '</th>';
                $html2 .= '        <th class="th-price" style="width: 70px;text-align: center">批发价（元）</th>';
                $html2 .= '        <th class="th-price" style="width: 105px;text-align: center">零售价（元）</th>';
                $html2 .= '    </tr>';
                $html2 .= '</thead>';
                $html2 .= '<tbody>';
                foreach ($vids as $key => $vid)
                {
                    $value = $product_property_value->getValue($pid, $vid['vid']);
                    foreach ($vids1 as $key1 => $vid1)
                    {
                        $value1 = $product_property_value->getValue($pid1, $vid1['vid']);
                        foreach ($vids2 as $key2 => $vid2)
                        {
                            $properties = $pid . ':' . $vid['vid'] . ';' . $pid1 . ':' . $vid1['vid'] . ';' . $pid2 . ':' . $vid2['vid'];
                            $sku = $product_sku->getSku($id, $properties);
                            $html .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                            $html2 .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                            $value2 = $product_property_value->getValue($pid2, $vid2['vid']);
                            if ($key1 == 0 && $key2 == 0)
                            {
                                $html .= '    <td class="text-center" rowspan="' . count($vids1) * count($vids2) . '">' . $value . '</td>';
                                $html2 .= '    <td class="text-center" rowspan="' . count($vids1) * count($vids2) . '">' . $value . '</td>';
                            }
                            if ($key2 == 0)
                            {
                                $html .= '    <td class="text-center" rowspan="' . count($vids2) . '">' . $value1 . '</td>';
                                $html2 .= '    <td class="text-center" rowspan="' . count($vids2) . '">' . $value1 . '</td>';
                            }
                            $html .= '        <td class="text-center" width="50">' . $value2 . '</td>';
                            $html .= '        <td style="text-align: center"><input type="text" name="wholesale_price" class="js-cost-price-one input-mini" maxlength="10" />';
                            $html .= '        <td style="text-align: center"><input type="text" name="sale_min_price" class="js-price-two js-fx-price input-mini" maxlength="10" /> - <input type="text" name="sale_max_price" class="js-price-three js-fx-price input-mini" maxlength="10" /></td>';
                            $html .= '    </tr>';

                            $html2 .= '        <td class="text-center" width="50">' . $value2 . '</td>';
                            $html2 .= '        <td style="text-align: center"><input type="text" name="wholesale_price" class="js-cost-price-one input-mini" maxlength="10" />';
                            $html2 .= '        <td style="text-align: center"><input type="text" name="sale_min_price" class="js-price-two js-fx-price input-mini" maxlength="10" /> - <input type="text" name="sale_max_price" class="js-price-three js-fx-price input-mini" maxlength="10" /></td>';
                            $html2 .= '    </tr>';
                        }
                    }
                }
            }
            else if (!empty($pids[1]['pid']))
            {
                $pid1 = $pids[1]['pid'];
                $name1 = $product_property->getName($pid1);
                $vids1 = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid1);

                $html2 = '<thead>';
                $html2 .= '    <tr>';
                $html2 .= '        <th class="text-center" width="50">' . $name . '</th>';
                $html2 .= '        <th class="text-center" width="50">' . $name1 . '</th>';
                $html2 .= '        <th class="th-price" style="text-align: center">批发价（元）</th>';
                $html2 .= '        <th class="th-price" style="width: 105px;text-align: center">零售价（元）</th>';
                $html2 .= '    </tr>';
                $html2 .= '</thead>';
                $html2 .= '<tbody>';
                foreach ($vids as $key => $vid)
                {
                    $value = $product_property_value->getValue($pid, $vid['vid']);
                    foreach ($vids1 as $key1 => $vid1)
                    {
                        $properties = $pid . ':' . $vid['vid'] . ';' . $pid1 . ':' . $vid1['vid'];
                        $sku = $product_sku->getSku($id, $properties);
                        $html2 .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                        $value1 = $product_property_value->getValue($pid1, $vid1['vid']);
                        if ($key1 == 0)
                        {
                            $html2 .= '    <td class="text-center" rowspan="' . count($vids1) . '">' . $value . '</td>';
                        }

                        $html2 .= '        <td class="text-center" width="50">' . $value1 . '</td>';
                        $html2 .= '        <td style="text-align: center"><input type="text" name="wholesale_price" class="js-cost-price-one input-mini" maxlength="10" />';
                        $html2 .= '        <td style="text-align: center"><input type="text" name="sale_min_price" class="js-price-two js-fx-price input-mini" maxlength="10" /> - <input type="text" name="sale_max_price" class="js-price-three js-fx-price input-mini" maxlength="10" /></td>';
                        $html2 .= '    </tr>';
                    }
                }
            }
            else
            {
                $html = '<thead>';
                $html .= '    <tr>';
                $html .= '        <th class="text-center" width="50">' . $name . '</th>';
                $html .= '        <th class="th-price" style="text-align: center">批发价（元）</th>';
                $html .= '        <th class="th-price" style="width: 105px;text-align: center">零售价（元）</th>';
                $html .= '    </tr>';
                $html .= '</thead>';
                $html .= '<tbody>';

                $html2 = '<thead>';
                $html2 .= '    <tr>';
                $html2 .= '        <th class="text-center" width="50">' . $name . '</th>';
                $html2 .= '        <th class="th-price" style="text-align: center">批发价（元）</th>';
                $html2 .= '        <th class="th-price" style="width: 105px;text-align: center">零售价（元）</th>';
                $html2 .= '    </tr>';
                $html2 .= '</thead>';
                $html2 .= '<tbody>';
                foreach ($vids as $key => $vid)
                {
                    $value = $product_property_value->getValue($pid, $vid['vid']);
                    $properties = $pid . ':' . $vid['vid'];
                    $sku = $product_sku->getSku($id, $properties);
                    $html .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                    $html2 .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                    $value = $product_property_value->getValue($pid, $vid['vid']);
                    $html .= '        <td class="text-center" width="50">' . $value . '</td>';
                    $html .= '        <td style="text-align: center"><input type="text" name="cost_sku_price" class="js-cost-price input-mini" maxlength="10" /></td>';
                    $html .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price js-fx-min-price input-mini" maxlength="10" /> - <input type="text" name="sku_price" class="js-price js-fx-max-price input-mini" maxlength="10" /></td>';
                    $html .= '    </tr>';

                    $html2 .= '        <td class="text-center" width="50">' . $value . '</td>';
                    $html2 .= '        <td style="text-align: center"><input type="text" name="wholesale_price" class="js-cost-price-one input-mini" maxlength="10" />';
                    $html2 .= '        <td style="text-align: center"><input type="text" name="sale_min_price" class="js-price-two js-fx-price input-mini" maxlength="10" /> - <input type="text" name="sale_max_price" class="js-price-three js-fx-price input-mini" maxlength="10" /></td>';
                    $html2 .= '    </tr>';
                }
            }
            $html .= '</tbody><tfoot><tr><td colspan="6"><div class="batch-opts">批量设置： <span class="js-batch-type"><a class="js-batch-cost" href="javascript:;">批发价</a>&nbsp;&nbsp;<a class="js-batch-price" href="javascript:;">零售价</a></span><span class="js-batch-form" style="display:none;"></span></div></td></tr></tfoot>';
            $html2 .= '</tbody><tfoot><tr><td colspan="6"><div class="batch-opts2">批量设置： <span class="js-batch-type2"><a class="js-batch-cost2" href="javascript:;">批发价</a>&nbsp;&nbsp;<a class="js-batch-price2" href="javascript:;">零售价</a></span><span class="js-batch-form2" style="display:none;"></span></div></td></tr></tfoot>';
        }

        $this->assign('edit_cost_price', $edit_cost_price);
        $this->assign('sku_content', $html);
        $this->assign('sku_content2', $html2);
        if (!empty($product['wholesale_product_id']))
        {
            $source_product = M('Product')->get(array ('product_id' => $product['wholesale_product_id'], 'store_id' => $product['supplier_id']));
            $sale_min_price = $source_product['sale_min_price'];
            $sale_max_price = $source_product['sale_max_price'];
            $wholesale_price = $source_product['wholesale_price'];
        }
        else
        {
            $sale_min_price = $product['sale_min_price'];
            $sale_max_price = $product['sale_max_price'];
            $wholesale_price = $product['wholesale_price'];
        }

        if (empty($product['wholesale_product_id']))
        {
            $is_supplier = TRUE;
        }
        else
        {
            $is_supplier = FALSE;
        }

        $this->assign('product', $product);
        $this->assign('sale_min_price', $sale_min_price);
        $this->assign('wholesale_price', $wholesale_price);
        $this->assign('sale_max_price', $sale_max_price);

        $this->assign('is_supplier', $is_supplier);
        $this->assign('drp_level', $_SESSION['store']['drp_level']);
        $this->assign('open_drp_setting_price', $this->store_session['open_drp_setting_price']);
        $this->assign('unified_price_setting', $this->store_session['unified_price_setting']);
    }

    //客服联系方式
    public function service()
    {
        if (IS_POST && strtolower($_POST['type']) == 'check')
        {
            $store = M('Store');
            $store = $store->getStore($this->store_session['store_id']);
            if (empty($store['service_tel']) && empty($store['service_qq']) && empty($store['service_weixin']))
            {
                json_return(1001, '没有填写客服联系方式');
            }
            else
            {
                json_return(0, '客服联系方式已填写');
            }
        }
        else if (IS_POST && strtolower($_POST['type']) == 'add')
        {
            $store = M('Store');
            $data = array ();
            $data['service_tel'] = isset($_POST['tel']) ? trim($_POST['tel']) : '';
            $data['service_qq'] = isset($_POST['qq']) ? trim($_POST['qq']) : '';
            $data['service_weixin'] = isset($_POST['weixin']) ? trim($_POST['weixin']) : '';
            $where = array ();
            $where['store_id'] = $this->store_session['store_id'];
            if ($store->setting($where, $data))
            {
                json_return(0, '保存成功');
            }
            else
            {
                json_return(1001, '保存失败，请重新提交');
            }
        }
    }

    public function contact_information()
    {
        if (IS_POST)
        {
            $store = M('Store');
            $data = array ();
            $data['service_tel'] = isset($_POST['tel']) ? trim($_POST['tel']) : '';
            $data['service_qq'] = isset($_POST['qq']) ? trim($_POST['qq']) : '';
            $data['service_weixin'] = isset($_POST['weixin']) ? trim($_POST['weixin']) : '';
            $where = array ();
            $where['store_id'] = $this->store_session['store_id'];
            if ($store->setting($where, $data))
            {
                json_return(0, '保存成功');
            }
            else
            {
                json_return(1001, '保存失败，请重新提交');
            }
        }
        $this->display();
    }

    private function contact_information_content()
    {
        $store = M('Store');
        $information = $store->getStore($this->store_session['store_id']);
        $this->assign('information', $information);
    }


    public function dividends_setting()
    { 
        
        $this->checkFx(false, true);

        if (!empty($this->store_session['drp_supplier_id'])) {
            pigcms_tips('你不是供货商，无法进行相关设置!');
        }

        $this->display();
    }

    private function _dividends_setting_content(){

        $dividends_rules = D('Dividends_rules')->where(array('supplier_id'=>$this->store_session['store_id']))->select();
        $dividends_rules_count = count($dividends_rules);
        $dividends_send_rules = D('Dividends_send_rules')->where(array('supplier_id' =>$this->store_session['store_id']))->find();

        $this->assign('dividends_rules', $dividends_rules);
        $this->assign('dividends_send_rules', $dividends_send_rules);
        $this->assign('dividends_rules_count', $dividends_rules_count);
    }


    private function _dividends_rules_create(){

        $dividends_rules_model = D('Dividends_rules');

        if (IS_POST && isset($_POST['is_submit'])) {

            $data = array();
            
            $data['supplier_id'] = $_SESSION['store']['store_id'];

            if(!$data['supplier_id']) {
                json_return(1003, '登陆错误');
            }


            $data['dividends_type'] = intval($_POST['dividends_type']);

            if(!in_array($data['dividends_type'],array(1,2,3))) {
                json_return(1005, '请选择依据对象');
            }


         $dividends_type_count = $dividends_rules_model->where(array('supplier_id'=>$data['supplier_id'],'dividends_type'=>$data['dividends_type']))->count('*');

            if($dividends_type_count > 0){
                json_return(1016, '该对象已有相应规则');
            }


            $data['rule_type'] = intval($_POST['rule_type']);

            if(!in_array($data['rule_type'],array(1,2,3))) {
                json_return(1006, '请选择达标规则');
            }

            //默认数据

            $data['month'] = 0;
            $data['money'] = '0.00';
            $data['is_bind'] = 0;
            $data['rule3_month'] = 0;
            $data['rule3_seller_1'] = 0;
            $data['rule3_seller_2'] = 0;
            $data['percentage'] = 0;
            $data['fixed_amount'] = '0.00';
            $data['upper_limit'] = '0.00';
            $data['is_team_dividend'] = 0;
            $data['team_owner_percentage'] = 0;


            if($data['rule_type'] == 1){
                $data['month'] = intval($_POST['rule1_month']);
                if($data['month'] <= 0){
                    json_return(1007, '月份不能为负数');
                }
                $data['money'] = !empty($_POST['rule1_money']) ? floatval(trim($_POST['rule1_money'])) : $data['money'];
                $rule1_is_bind = ($_POST['rule1_is_bind'] == 'true')?1:0;
                if($rule1_is_bind == 1){
                    $data['is_bind'] = 1;
                }
            }

            if($data['rule_type'] == 2){
                $data['month'] = intval($_POST['rule2_month']);
                if($data['month'] <= 0){
                    json_return(1008, '月份不能为负数');
                }

                $data['money'] = !empty($_POST['rule2_money']) ? floatval(trim($_POST['rule2_money'])) : $data['money'];
                
                $rule2_is_bind = ($_POST['rule2_is_bind'] == 'true')?1:0;
                if($rule2_is_bind == 1){
                    $data['is_bind'] = 1;
                }
            }

            if($data['rule_type'] == 3 || $data['is_bind'] == 1){

                    if($data['dividends_type'] == 1){
                        json_return(1016, '经销商无需关联规则3');
                    }else{
                        $data['rule3_month'] = intval($_POST['rule3_month']);

                        if($data['rule3_month'] <= 0){
                            json_return(1009, '月份不能为负数');
                        }
                       
                        $data['rule3_seller_1'] = intval($_POST['rule3_seller_1']);

                        if($data['rule3_seller_1'] <= 0){
                            json_return(1010, '人数不能为负数');
                        }

                        if($data['dividends_type'] != 2){

                            $data['rule3_seller_2'] = intval($_POST['rule3_seller_2']);

                            if($data['rule3_seller_2'] <= 0){
                                json_return(1011, '人数不能为负数');
                            }

                        }

                       
                        
                    }
            }

            $data['percentage_or_fix'] = intval($_POST['percentage_or_fix']);

            if(!in_array($data['percentage_or_fix'],array(1,2))) {
                json_return(1012, '请选择奖金规则');
            }

            if($data['percentage_or_fix'] == 1){
                
                 if($data['rule_type'] == 3){

                    json_return(1016, '只选规则3则奖金规则必须绑定固定值');
                
                }else{  

                    $data['percentage'] = intval($_POST['percentage']);
                
                    if($data['percentage'] < 0 || $data['percentage'] > 100 ){
                        json_return(1013, '比例必须在0-100之间');
                    }
                }
               
            }  

            if($data['percentage_or_fix'] == 2){
                
                $data['fixed_amount'] =!empty($_POST['fixed_amount']) ? floatval(trim($_POST['fixed_amount'])) : 0;

                if($data['fixed_amount'] <= 0){
                    json_return(1014, '金额不能为负数');
                }
            }  
            
            
            $data['is_limit'] =($_POST['is_limit'] == 'true')?1:0;

            if($data['is_limit'] == 1){
                $data['upper_limit'] =!empty($_POST['upper_limit']) ? floatval(trim($_POST['upper_limit'])) : 0;
            }

            if($data['dividends_type'] == 2 ){

                 $data['is_team_dividend'] = ($_POST['is_team_dividend'] == 'true')?1:0;


                if($data['is_team_dividend'] == 1 ){
                    
                    $data['team_owner_percentage'] =intval($_POST['team_owner_percentage']);
                    
                    if($data['team_owner_percentage'] < 0 || $data['team_owner_percentage'] > 100 ){
                        json_return(1015, '比例必须在0-100之间');
                    }
                }
            }

            $data['add_time'] = time();            

            $result = $dividends_rules_model->data($data)->add();


            if(!$result){
                json_return(1004, '保存失败');
            }

            json_return(0, '保存成功');
    
        }

    }

    private function _dividends_rules_edit() {
        
        $dividends_rules_model = D('Dividends_rules');
        
        $id = (Int)$_POST['id'];
    
        if (empty($id)) {
            json_return(1001, '缺少最基本的参数ID');
        }
        

        $rules_info = $dividends_rules_model->where(array('pigcms_id' => $id))->find();

        if( $_SESSION['store']['store_id']!= $rules_info['supplier_id']) {
            json_return(1002, '当前规则不是该店铺的！');
        }

    
        if (IS_POST && isset($_POST['is_submit'])) {


            $data = array();
            
            $data['supplier_id'] = $_SESSION['store']['store_id'];

            if(!$data['supplier_id']) {
                json_return(1003, '登陆错误');
            }


            $data['dividends_type'] = intval($_POST['dividends_type']);

            if(!in_array($data['dividends_type'],array(1,2,3))) {
                json_return(1005, '请选择依据对象');
            }

             $dividends_type_count = $dividends_rules_model->where(array('supplier_id'=>$data['supplier_id'],'dividends_type'=>$data['dividends_type']))->count('*');

            if($dividends_type_count > 0 && $data['dividends_type'] != $rules_info['dividends_type']){
                json_return(1016, '该对象已有相应规则');
            }


            $data['rule_type'] = intval($_POST['rule_type']);

            if(!in_array($data['rule_type'],array(1,2,3))) {
                json_return(1006, '请选择达标规则');
            }

            //默认数据

            $data['month'] = 0;
            $data['money'] = '0.00';
            $data['is_bind'] = 0;
            $data['rule3_month'] = 0;
            $data['rule3_seller_1'] = 0;
            $data['rule3_seller_2'] = 0;
            $data['percentage'] = 0;
            $data['fixed_amount'] = '0.00';
            $data['upper_limit'] = '0.00';
            $data['is_team_dividend'] = 0;
            $data['team_owner_percentage'] = 0;


            if($data['rule_type'] == 1){
                $data['month'] = intval($_POST['rule1_month']);
                if($data['month'] <= 0){
                    json_return(1007, '月份不能为负数');
                }
                $data['money'] = !empty($_POST['rule1_money']) ? floatval(trim($_POST['rule1_money'])) : $data['money'];
                $rule1_is_bind = ($_POST['rule1_is_bind'] == 'true')?1:0;
                if($rule1_is_bind == 1){
                    $data['is_bind'] = 1;
                }
            }

            if($data['rule_type'] == 2){
                $data['month'] = intval($_POST['rule2_month']);
                if($data['month'] <= 0){
                    json_return(1008, '月份不能为负数');
                }

                $data['money'] = !empty($_POST['rule2_money']) ? floatval(trim($_POST['rule2_money'])) : $data['money'];
                
                $rule2_is_bind = ($_POST['rule2_is_bind'] == 'true')?1:0;
                if($rule2_is_bind == 1){
                    $data['is_bind'] = 1;
                }
            }

            if($data['rule_type'] == 3 || $data['is_bind'] == 1){
                
                if($data['dividends_type'] == 1){
                        json_return(1016, '经销商无需关联规则3');
                }else{
                        $data['rule3_month'] = intval($_POST['rule3_month']);

                        if($data['rule3_month'] <= 0){
                            json_return(1009, '月份不能为负数');
                        }
                       
                        $data['rule3_seller_1'] = intval($_POST['rule3_seller_1']);

                        if($data['rule3_seller_1'] <= 0){
                            json_return(1010, '人数不能为负数');
                        }

                        if($data['dividends_type'] != 2){
                       
                            $data['rule3_seller_2'] = intval($_POST['rule3_seller_2']);

                            if($data['rule3_seller_2'] <= 0){
                                json_return(1011, '人数不能为负数');
                            }
                        
                        }
                }

            }

            $data['percentage_or_fix'] = intval($_POST['percentage_or_fix']);

            if(!in_array($data['percentage_or_fix'],array(1,2))) {
                json_return(1012, '请选择奖金规则');
            }

            if($data['percentage_or_fix'] == 1){
            
                if($data['rule_type'] == 3){

                    json_return(1016, '只选规则3则奖金规则必须绑定固定值');
                
                }else{  

                     $data['percentage'] = intval($_POST['percentage']);
                
                     if($data['percentage'] < 0 || $data['percentage'] > 100 ){
                        json_return(1013, '比例必须在0-100之间');
                     }
                }  
         
            }  

            if($data['percentage_or_fix'] == 2){
                
                $data['fixed_amount'] =!empty($_POST['fixed_amount']) ? floatval(trim($_POST['fixed_amount'])) : 0;

                if($data['fixed_amount'] <= 0){
                    json_return(1014, '金额不能为负数');
                }
            }  
            
            
            $data['is_limit'] =($_POST['is_limit'] == 'true')?1:0;

            if($data['is_limit'] == 1){
                $data['upper_limit'] =!empty($_POST['upper_limit']) ? floatval(trim($_POST['upper_limit'])) : 0;
            }

            if($data['dividends_type'] == 2 ){

                 $data['is_team_dividend'] = ($_POST['is_team_dividend'] == 'true')?1:0;


                if($data['is_team_dividend'] == 1 ){
                    
                    $data['team_owner_percentage'] =intval($_POST['team_owner_percentage']);
                    
                    if($data['team_owner_percentage'] < 0 || $data['team_owner_percentage'] > 100 ){
                        json_return(1015, '比例必须在0-100之间');
                    }
                }
            }
            

            $result = $dividends_rules_model->where(array('pigcms_id' =>$id))->data($data)->save();

            if(!$result){
                json_return(1004, '保存失败');
            }

            json_return(0, '修改成功');
    
        }
    
       
        $this->assign('rules_info', $rules_info);
        
    }


    private function _dividends_sendrules_edit(){

         $send_rules = D('Dividends_send_rules')->where(array('supplier_id' => $_SESSION['store']['store_id']))->find();

         if (IS_POST && isset($_POST['is_submit'])) {

            $data = array();
            
            $data['supplier_id'] = $_SESSION['store']['store_id'];

            if(!$data['supplier_id']) {
                json_return(1003, '登陆错误');
             }


            $data['type'] = intval($_POST['send_rules_type']);
            
            if(!in_array($data['type'],array(1,2))) {
                json_return(1005, '请选择发放规则');
            }

           /*
            $data['rules'] = '';

            if($data['type'] == 2){
                $data['rules'] = intval($_POST['rules2_value']);
                if($data['rules'] <=0 || $data['rules'] > 31) {
                    json_return(1006, '日期必须在1-31之间');
                }
            }
            
            if($data['type'] == 3){
                $data['rules'] = serialize($_POST['fields']);
            }
            */

            if($send_rules){
                //update
                $result = D('Dividends_send_rules')->where(array('supplier_id' =>$data['supplier_id']))->data($data)->save();
            }else{
                //insert
                $result = D('Dividends_send_rules')->data($data)->add();
            }

            if(!$result){
                json_return(1007, '保存失败');
            }

            json_return(0, '保存成功');


        }

        $this->assign('send_rules', $send_rules);

    }




    public function dividends_rules_del() {
        
        $pigcms_id = $_REQUEST['pigcms_id'];
        if (empty($pigcms_id)) {
            json_return(1001, '缺少最基本的参数ID');
        }

        $rules_info = D('Dividends_rules')->where(array('pigcms_id' => $pigcms_id))->find();
        if( $_SESSION['store']['store_id']!= $rules_info['supplier_id']) {
            json_return(1002, '当前规则不是该店铺的！');
        }
        
        D('Dividends_rules')->where(array('pigcms_id' => $pigcms_id))->delete();
        json_return(0, '操作完成');
    }



    public function edit_wholesale()
    {
        if (IS_POST)
        {
            $product = M('Product');
            $product_sku = M('Product_sku');
            $product_id = !empty($_POST['product_id']) ? intval(trim($_POST['product_id'])) : 0;
            $cost_price = !empty($_POST['wholesale_price']) ? floatval(trim($_POST['wholesale_price'])) : 0; // 批发价
            $min_fx_price = !empty($_POST['sale_min_price']) ? floatval(trim($_POST['sale_min_price'])) : 0; //最低零售价
            $max_fx_price = !empty($_POST['sale_max_price']) ? floatval(trim($_POST['sale_max_price'])) : 0; //最高零售价
            $is_recommend = !empty($_POST['is_recommend']) ? intval(trim($_POST['is_recommend'])) : 0;
            $is_whitelist = !empty($_POST['is_whitelist']) ? intval(trim($_POST['is_whitelist'])) : 0;
            $unified_price_setting = !empty($_POST['unified_price_setting']) ? $_POST['unified_price_setting'] : 0;
            $page = !empty($_POST['page']) ? intval(trim($_POST['page'])) : 1; // 当前页数
            $skus = !empty($_POST['skus']) ? $_POST['skus'] : array ();

            $seller_ids = !empty($_POST['seller_id']) ? $_POST['seller_id'] : array();

            //批发商品详情
            $whole_info = D('Product')->field('product_id,has_property')->where(array ('wholesale_product_id' => $product_id))->select();

            $fx_type = 0; //分销类型 0全网、1排他
            if (strtolower(trim($_GET['role'])) == 'seller' || !empty($this->store_session['drp_supplier_id']))
            {
                $fx_type = 1;
            }
            $data = array (
                'wholesale_price' => $cost_price,
                'sale_min_price' => $min_fx_price,
                'sale_max_price' => $max_fx_price,
                'is_recommend' => $is_recommend,
                'is_whitelist' => $is_whitelist,
                'is_wholesale' => 1,
                'fx_type' => $fx_type,
                'unified_price_setting' => $unified_price_setting,
                'date_added' => time(),
            );

            $whole_data = array (
                'wholesale_price' => $cost_price,
                'sale_min_price' => $min_fx_price,
                'sale_max_price' => $max_fx_price,
                'price' => $min_fx_price,
                'is_fx' => 0,
                'cost_price' => 0,
                'min_fx_price' => 0,
                'max_fx_price' => 0,
                'drp_level_1_price' => 0,
                'drp_level_2_price' => 0,
                'drp_level_3_price' => 0,
                'drp_level_1_cost_price' => 0,
                'drp_level_2_cost_price' => 0,
                'drp_level_3_cost_price' => 0,
            );


            $result = D('Product')->where(array ('product_id' => $product_id))->data($data)->save();

            $products = D('Product')->where(array('wholesale_product_id' => $product_id))->count('product_id');

            if ($result)
            {
                if(count($seller_ids) > 0)
                {
                    D('Product_whitelist')->where(array('product_id'=>$product_id,'supplier_id'=>$this->store_session['store_id']))->delete();
                    foreach($seller_ids as $seller_id)
                    {
                        $seller_data = array (
                            'product_id' => $product_id,
                            'supplier_id' => $this->store_session['store_id'],
                            'add_time' => time(),
                            'seller_id' => $seller_id['seller_id'],
                        );
                        D('Product_whitelist')->data($seller_data)->add();
                    }
                }

                //同步经销商价格
                if($products >0){
                    D('Product')->where(array ('wholesale_product_id' => $product_id))->data($whole_data)->save();
                    foreach($whole_info as $whole_product)
                    {
                        $product_sku->wholesaleSkus($whole_product['product_id'], $skus);
                    }
                }
                if (count($skus) > 0){
                    $product_sku->wholesaleEdit($product_id, $skus);
                }

                json_return(0, url('supplier_market',array('is'=>2,'page'=>$page)));
            }
            else
            {
                json_return(1001, '保存失败');
            }
        }
        $this->display();
    }

    private function edit_wholesale_content()
    {
        $product = M('Product');
        $category = M('Product_category');
        $product_property = M('Product_property');
        $product_property_value = M('Product_property_value');
        $product_to_property = M('Product_to_property');
        $product_to_property_value = M('Product_to_property_value');
        $product_sku = M('Product_sku');
        $product_whitelist = M('Product_whitelist');

        $id = isset($_POST['id']) ? intval(trim($_POST['id'])) : 0; //商品id

        $product = $product->get(array ('product_id' => $id, 'store_id' => $this->store_session['store_id']));

        if (!empty($product['supplier_id']))
        { //分销商
            $edit_cost_price = FALSE;
            $readonly = '';
        }
        else
        { //供货商
            $edit_cost_price = TRUE;
            $readonly = '';
        }
        if (!empty($product['category_id']) && !empty($product['category_fid']))
        {
            $parent_category = $category->getCategory($product['category_fid']);
            $category = $category->getCategory($product['category_id']);
            $product['category'] = $parent_category['cat_name'] . ' - ' . $category['cat_name'];
        }
        else if ($product['category_fid'])
        {
            $category = $category->getCategory($product['category_fid']);
            $product['category'] = $category['cat_name'];
        }
        else
        {
            $category = $category->getCategory($product['category_id']);
            $product['category'] = !empty($category['cat_name']) ? $category['cat_name'] : '其它';
        }

        $pids = $product_to_property->getPids($this->store_session['store_id'], $id);

        if (!empty($pids[0]['pid'])) {
            $pid = $pids[0]['pid'];
            $name = $product_property->getName($pid);
            $vids = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid);
            if (!empty($pids[1]['pid']) && !empty($pids[2]['pid'])) {
                $pid1 = $pids[1]['pid'];
                $name1 = $product_property->getName($pid1);
                $vids1 = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid1);
                $pid2 = $pids[2]['pid'];
                $name2 = $product_property->getName($pid2);
                $vids2 = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid2);
                $html = '<thead>';
                $html .= '    <tr>';
                $html .= '        <th class="text-center" width="80">' . $name . '</th>';
                $html .= '        <th class="text-center" width="80">' . $name1 . '</th>';
                $html .= '        <th class="text-center" width="80">' . $name2 . '</th>';
                $html .= '        <th class="th-price" style="width: 70px;text-align: center">批发价（元）</th>';
                $html .= '        <th class="th-price" style="width: 105px;text-align: center">零售价（元）</th>';
                $html .= '    </tr>';
                $html .= '</thead>';
                $html .= '<tbody>';
                $html2 = '<thead>';
                $html2 .= '    <tr>';
                $html2 .= '        <th class="text-center" width="80">' . $name . '</th>';
                $html2 .= '        <th class="text-center" width="80">' . $name1 . '</th>';
                $html2 .= '        <th class="text-center" width="80">' . $name2 . '</th>';
                $html2 .= '        <th class="th-price" style="width: 70px;text-align: center">批发价（元）</th>';
                $html2 .= '        <th class="th-price" style="width: 105px;text-align: center">零售价（元）</th>';
                $html2 .= '    </tr>';
                $html2 .= '</thead>';
                $html2 .= '<tbody>';
                foreach ($vids as $key => $vid)
                {
                    $value = $product_property_value->getValue($pid, $vid['vid']);
                    foreach ($vids1 as $key1 => $vid1)
                    {
                        $value1 = $product_property_value->getValue($pid1, $vid1['vid']);
                        foreach ($vids2 as $key2 => $vid2)
                        {
                            $properties = $pid . ':' . $vid['vid'] . ';' . $pid1 . ':' . $vid1['vid'] . ';' . $pid2 . ':' . $vid2['vid'];
                            $sku = $product_sku->getSku($id, $properties);
                            $html .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                            $html2 .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                            $value2 = $product_property_value->getValue($pid2, $vid2['vid']);
                            if ($key1 == 0 && $key2 == 0)
                            {
                                $html .= '    <td class="text-center" rowspan="' . count($vids1) * count($vids2) . '">' . $value . '</td>';
                                $html2 .= '    <td class="text-center" rowspan="' . count($vids1) * count($vids2) . '">' . $value . '</td>';
                            }
                            if ($key2 == 0)
                            {
                                $html .= '    <td class="text-center" rowspan="' . count($vids2) . '">' . $value1 . '</td>';
                                $html2 .= '    <td class="text-center" rowspan="' . count($vids2) . '">' . $value1 . '</td>';
                            }
                            $html .= '        <td class="text-center" width="50">' . $value2 . '</td>';
                            $html .= '        <td style="text-align: center"><input type="text" name="wholesale_price" class="js-cost-price-one input-mini" maxlength="10" value=' . $sku['wholesale_price'] . ' /></td>';
                            $html .= '        <td style="text-align: center"><input type="text" name="sale_min_price" class="js-price-two js-fx-price input-mini" maxlength="10" value=' . $sku['sale_min_price'] . ' /> - <input type="text" name="sale_max_price" class="js-price-three js-fx-price input-mini" maxlength="10" value=' . $sku['sale_max_price'] . ' /></td>';
                            $html .= '    </tr>';

                            $html2 .= '        <td class="text-center" width="50">' . $value2 . '</td>';
                            $html2 .= '        <td style="text-align: center"><input type="text" name="wholesale_price" class="js-cost-price-one input-mini" maxlength="10" value=' . $sku['wholesale_price'] . ' /></td>';
                            $html2 .= '        <td style="text-align: center"><input type="text" name="sale_min_price" class="js-price-two js-fx-price input-mini" maxlength="10" value=' . $sku['sale_min_price'] . ' /> - <input type="text" name="sale_max_price" class="js-price-three js-fx-price input-mini" maxlength="10" value=' . $sku['sale_max_price'] . ' /></td>';
                            $html2 .= '    </tr>';
                        }
                    }
                }
            }
            else if (!empty($pids[1]['pid']))
            {
                $pid1 = $pids[1]['pid'];
                $name1 = $product_property->getName($pid1);
                $vids1 = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid1);

                $html2 = '<thead>';
                $html2 .= '    <tr>';
                $html2 .= '        <th class="text-center" width="50">' . $name . '</th>';
                $html2 .= '        <th class="text-center" width="50">' . $name1 . '</th>';
                $html2 .= '        <th class="th-price" style="text-align: center">批发价（元）</th>';
                $html2 .= '        <th class="th-price" style="width: 105px;text-align: center">零售价（元）</th>';
                $html2 .= '    </tr>';
                $html2 .= '</thead>';
                $html2 .= '<tbody>';
                foreach ($vids as $key => $vid)
                {
                    $value = $product_property_value->getValue($pid, $vid['vid']);
                    foreach ($vids1 as $key1 => $vid1)
                    {
                        $properties = $pid . ':' . $vid['vid'] . ';' . $pid1 . ':' . $vid1['vid'];
                        $sku = $product_sku->getSku($id, $properties);
                        $html2 .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                        $value1 = $product_property_value->getValue($pid1, $vid1['vid']);
                        if ($key1 == 0)
                        {
                            $html2 .= '    <td class="text-center" rowspan="' . count($vids1) . '">' . $value . '</td>';
                        }

                        $html2 .= '        <td class="text-center" width="50">' . $value1 . '</td>';
                        $html2 .= '        <td style="text-align: center"><input type="text" name="wholesale_price" class="js-cost-price-one input-mini" maxlength="10" value=' . $sku['wholesale_price'] . ' /></td> ';
                        $html2 .= '        <td style="text-align: center"><input type="text" name="sale_min_price" class="js-price-two js-fx-price input-mini" maxlength="10" value=' . $sku['sale_min_price'] . ' /> - <input type="text" name="sale_max_price" class="js-price-three js-fx-price input-mini" maxlength="10" value=' . $sku['sale_max_price'] . ' /></td>';
                        $html2 .= '    </tr>';
                    }
                }
            }
            else
            {
                $html = '<thead>';
                $html .= '    <tr>';
                $html .= '        <th class="text-center" width="50">' . $name . '</th>';
                $html .= '        <th class="th-price" style="text-align: center">批发价（元）</th>';
                $html .= '        <th class="th-price" style="width: 105px;text-align: center">零售价（元）</th>';
                $html .= '    </tr>';
                $html .= '</thead>';
                $html .= '<tbody>';

                $html2 = '<thead>';
                $html2 .= '    <tr>';
                $html2 .= '        <th class="text-center" width="50">' . $name . '</th>';
                $html2 .= '        <th class="th-price" style="text-align: center">批发价（元）</th>';
                $html2 .= '        <th class="th-price" style="width: 105px;text-align: center">零售价（元）</th>';
                $html2 .= '    </tr>';
                $html2 .= '</thead>';
                $html2 .= '<tbody>';
                foreach ($vids as $key => $vid)
                {
                    $value = $product_property_value->getValue($pid, $vid['vid']);
                    $properties = $pid . ':' . $vid['vid'];
                    $sku = $product_sku->getSku($id, $properties);
                    $html .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                    $html2 .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                    $value = $product_property_value->getValue($pid, $vid['vid']);
                    $html .= '        <td class="text-center" width="50">' . $value . '</td>';
                    $html .= '        <td style="text-align: center"><input type="text" name="cost_sku_price" class="js-cost-price input-mini" maxlength="10" value=' . $sku['wholesale_price'] . ' /></td>';
                    $html .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price js-fx-min-price input-mini" maxlength="10" value=' . $sku['sale_min_price'] . ' /> - <input type="text" name="sku_price" class="js-price js-fx-max-price input-mini" maxlength="10" value=' . $sku['sale_max_price'] . ' /></td>';
                    $html .= '    </tr>';

                    $html2 .= '        <td class="text-center" width="50">' . $value . '</td>';
                    $html2 .= '        <td style="text-align: center"><input type="text" name="wholesale_price" class="js-cost-price-one input-mini" maxlength="10" value=' . $sku['wholesale_price'] . ' />';
                    $html2 .= '        <td style="text-align: center"><input type="text" name="sale_min_price" class="js-price-two js-fx-price input-mini" maxlength="10" value=' . $sku['sale_min_price'] . ' /> - <input type="text" name="sale_max_price" class="js-price-three js-fx-price input-mini" maxlength="10" value=' . $sku['sale_max_price'] . ' /></td>';
                    $html2 .= '    </tr>';
                }
            }
            $html .= '</tbody><tfoot><tr><td colspan="6"><div class="batch-opts">批量设置： <span class="js-batch-type"><a class="js-batch-cost" href="javascript:;">批发价</a>&nbsp;&nbsp;<a class="js-batch-price" href="javascript:;">零售价</a></span><span class="js-batch-form" style="display:none;"></span></div></td></tr></tfoot>';
            $html2 .= '</tbody><tfoot><tr><td colspan="6"><div class="batch-opts2">批量设置： <span class="js-batch-type2"><a class="js-batch-cost2" href="javascript:;">批发价</a>&nbsp;&nbsp;<a class="js-batch-price2" href="javascript:;">零售价</a></span><span class="js-batch-form2" style="display:none;"></span></div></td></tr></tfoot>';
        }

        if(!empty($product['is_whitelist'])) {
            $sellerList = D('Product_whitelist')->field('seller_id')->where(array('product_id'=>$id,'supplier_id'=>$this->store_session['store_id']))->select();

            $sellerInfo = array();
            if(count($sellerList)>0) {
                foreach($sellerList as $seller) {
                    $sellerInfo[] = D('Store')->field('store_id, name')->where(array('store_id'=>$seller['seller_id']))->find();
                }
                $html3 = '';
                foreach($sellerInfo as $sellers) {
                    $html3 .= '<span agenct-name="' . $sellers['name'] .'" area-id="'.$sellers['store_id'].'" class="text-depth">'.$sellers['name'].'</span>,';
                }
                $html3 .= '<div class="right"><a href="javascript:;"  data-product="'.$id.'" class="js-edit-cost-item">编辑</a> <a href="javascript:;" class="js-delete-cost-item">删除</a></div>';
            }
        }

        $this->assign('whitelist', $html3);
        $this->assign('edit_cost_price', $edit_cost_price);
        $this->assign('sku_content', $html);
        $this->assign('sku_content2', $html2);
        if (!empty($product['wholesale_product_id'])) {
            $source_product = M('Product')->get(array ('product_id' => $product['wholesale_product_id'], 'store_id' => $product['supplier_id']));
            $sale_min_price = $source_product['sale_min_price'];
            $sale_max_price = $source_product['sale_max_price'];
            $wholesale_price = $source_product['wholesale_price'];
        } else {
            $sale_min_price = $product['sale_min_price'];
            $sale_max_price = $product['sale_max_price'];
            $wholesale_price = $product['wholesale_price'];
        }

        if (empty($product['wholesale_product_id'])) {
            $is_supplier = true;
        } else {
            $is_supplier = false;
        }

        $this->assign('product', $product);
        $this->assign('sale_min_price', $sale_min_price);
        $this->assign('wholesale_price', $wholesale_price);
        $this->assign('sale_max_price', $sale_max_price);

        $this->assign('is_supplier', $is_supplier);
        $this->assign('drp_level', $_SESSION['store']['drp_level']);
    }

    public function commission_detail()
    {
        $this->display();
    }

    private function _commission_detail_content()
    {
        $order = M('Order');
        $order_product = M('Order_product');
        $financial_record = M('Financial_record');
        $store_point_log = M('Store_point_log');

        $order_id = intval(trim($_POST['order_id']));
        $store_id = $this->store_session['store_id'];

        if (!$_POST['fx_store_id']) {
            $order_info = $order->getOrder($this->store_session['store_id'], $order_id);
        } else {
            $order_info = $order->getOrder($_POST['fx_store_id'], $order_id);
        }

        $user_order_id = !empty($order_info['user_order_id']) ? $order_info['user_order_id'] : $order_id;
        $order_products = $order_product->getProducts($order_id);

        //用户主订单
        $user_order = D('Order')->where(array ('order_id' => $user_order_id))->find();
        $order_info['pay_amount'] = $user_order['total'];

        if ($order_info['type'] != 5) {
            //抵现积分
            $order_info['cash_point'] = $user_order['cash_point'];
            //type = 2 积分流转服务费
            $log = $store_point_log->getLog(array('order_id' => $user_order_id, 'type' => 2));
            $order_info['point_trade_fee'] = !empty($log['point']) ? number_format(abs($log['point']), 2, '.', '') : '0.00';
            //返还积分
            $order_info['return_point'] = $user_order['return_point'];

            //平台服务费
            $service_fee = D('Platform_margin_log')->where(array('order_id' => $user_order_id, 'type' => array('in', array(2, 3))))->sum('amount');
            $order_info['service_fee'] = !empty($service_fee) ? number_format(abs($service_fee), 2, '.', '') : '0.00';

            //推广奖励
            $order_info['promotion_reward'] = $user_order['promotion_reward'];
        } else {
            $order_info['cash_point'] = 0;
            $order_info['point_trade_fee'] = 0;
            $order_info['return_point'] = 0;
        }

        //主订单状态
        $order_info['complated'] = ($user_order['status'] == 4) ? true : false;

        //退货减
        $return = D('Return')->where(array ('order_id' => $order_info['order_id']))->sum('product_money + postage_money');
        $order_info['return'] = ($return > 0) ? number_format($return, 2, '.', '') : 0;

        if (!empty($user_order['suppliers']) && in_array($this->store_session['store_id'], explode(',', $user_order['suppliers']))) {
            //退货的分销利润
            $return_profit = 0;
            //和当前订单相关的退货
            $return_products = D('Return_product')->field('product_id,sku_id,pro_num')->where(array('order_id' => $order_info['order_id']))->select();
            if (!empty($return_products)) {
                foreach ($return_products as $return_product) {
                    $order_return_product_profit = D('Order_product')->where(array('product_id' => $return_product['product_id'], 'sku_id' => $return_product['sku_id'], 'user_order_id' => $user_order_id))->sum('profit');
                    $return_profit += ($order_return_product_profit * $return_product['pro_num']);
                }
            }
            $order_info['return_profit'] = number_format($return_profit, 2, '.', '');
        } else {
            $where = array();
            $where['store_id'] = $store_id;
            $where['order_id'] = $order_info['order_id'];
            $where['type']     = 3;
            $return = $financial_record->getTotal($where);
            $return = abs($return);
            $order_info['my_return_profit'] = number_format($return, 2, '.', '');
        }

        $where = array ();
        $where['_string'] = "(order_id = '" . $user_order_id . "' OR user_order_id = '" . $user_order_id . "')";
        if (!empty($this->store_session['drp_supplier_id'])) {
            if (empty($order_info['user_order_id'])) {
                $tmp_order = D('Order')->field('order_id')->where(array ('order_id' => $order_id, 'order_id' => array ('>', $order_id)))->order('order_id ASC')->find();
            } else {
                $tmp_order = D('Order')->field('order_id')->where(array ('user_order_id' => $user_order_id, 'order_id' => array ('>', $order_id)))->order('order_id ASC')->find();
            }
            $tmp_order_id = $tmp_order['order_id'];
            $where['_string'] .= " AND order_id <= " . $tmp_order_id;
        }
        $orders = D('Order')->where($where)->order('order_id DESC')->select();

        $filter_postage = array ();
        $filter_order = array ();
        $filter_products = array ();
        foreach ($orders as $key => &$tmp_order) {
            $is_filter = false;
            $store = D('Store')->field('store_id,name,drp_level,drp_supplier_id')->where(array ('store_id' => $tmp_order['store_id']))->find();
            $tmp_order['seller'] = $store['name'];
            $tmp_order['seller_drp_level'] = $store['drp_level'];

            if ($order_info['type'] == 5 && $tmp_order['type'] == 5 && $tmp_order['store_id'] != $this->store_session['store_id']) {
                $filter_postage[$tmp_order['store_id']] = $tmp_order['postage'];
                $filter_order[$tmp_order['store_id']] = $tmp_order['order_id'];
                $is_filter = true;
                unset($orders[$key]); //过滤非当前店铺的订单
            }

            $suppliers = explode(',', $tmp_order['suppliers']);
            if (!$is_filter && !empty($tmp_order['suppliers'])) {
                foreach ($filter_postage as $supplier_id => $postage) {
                    if (in_array($supplier_id, $suppliers)) {
                        $tmp_order['postage'] -= $postage;
                        $tmp_order['total'] -= $postage;
                        $tmp_order['profit'] -= $postage;

                        $filter_order_id = $filter_order[$supplier_id];
                        $tmp_filter_products = $order_product->getProducts($filter_order_id);
                        foreach ($tmp_filter_products as $tmp_product) {
                            $filter_products[] = $tmp_product['product_id'];
                        }
                    }
                }
            }

            $profit = D('Financial_record')->where(array ('order_id' => $tmp_order['order_id']))->sum('income');
            $tmp_order['profit'] = number_format($profit, 2, '.', '');

            $tmp_order['seller_store'] = option('config.wap_site_url') . '/home.php?id=' . $tmp_order['store_id'];

            //订单运费
            $supplier_postage = unserialize($tmp_order['fx_postage']);
            if (!empty($supplier_postage[$tmp_order['store_id']])) {
                $tmp_order['supplier_postage'] = $supplier_postage[$tmp_order['store_id']];
            } else if ($tmp_order['postage'] > 0 && empty($tmp_order['suppliers'])) {
                $tmp_order['supplier_postage'] = $tmp_order['postage'];
            } else {
                $tmp_order['supplier_postage'] = 0;
            }
            $tmp_order['supplier_postage'] = number_format($tmp_order['supplier_postage'], 2, '.', '');

            $products = $order_product->getProducts($tmp_order['order_id']);
            $comment_count = 0;
            $product_count = 0;
            $order_drp_degree_profit = 0;
            foreach ($products as $key2 => &$product) {
                //退货商品
                $product['return_quantity'] = M('Return_product')->getReturnQty($tmp_order['order_id'], $product['pigcms_id']);

                //过滤商品
                if (in_array($product['original_product_id'], $filter_products) || ($product['store_id'] != $this->store_session['store_id']) && empty($product['supplier_id']) && empty($product['is_wholesale']) && !in_array($product['store_id'], $suppliers)) {
                    $product['profit'] = ($product['profit'] > 0) ? $product['profit'] : $product['pro_price'];
                    $tmp_order['sub_total'] -= ($product['pro_price'] * $product['pro_num']);
                    $tmp_order['total'] -= ($product['pro_price'] * $product['pro_num']);
                    $tmp_order['profit'] -= ($product['profit'] * ($product['pro_num'] - $product['return_quantity']));
                    unset($products[$key2]);
                } else {
                    if (!empty($product['comment'])) {
                        $comment_count++;
                    }
                    $product_count++;

                    //商品来源
                    if (empty($product['supplier_id']) && $product['store_id'] == $tmp_order['store_id']) { //本店商品
                        $from = '自营商品';
                    } else if (!empty($product['supplier_id']) && $product['store_id'] == $tmp_order['store_id'] && !empty($product['wholesale_product_id'])) { //批发商品
                        $from = '批发商品';
                    } else { //分销商品
                        $from = '分销商品';
                    }
                    $product['from'] = $from;

                    $product['cost_price'] = ($product['pro_price'] - $product['profit'] > 0) ? $product['pro_price'] - $product['profit'] : 0;
                    if ($product['profit'] == 0 && empty($product['supplier_id']) && $tmp_order['store_id'] == $product['store_id']) {
                        $product['profit'] = $product['pro_price'];
                        $product['cost_price'] = 0;
                    }
                    if ($product['cost_price'] == 0 && $from != '自营商品') {
                        $product['cost_price'] = $product['pro_price'];
                    }
                    $product['cost_price'] = number_format($product['cost_price'], 2, '.', '');

                    if (!empty($product['wholesale_product_id'])) {
                        $tmp_order['is_wholesale'] = TRUE;
                    }
                }

                $order_drp_degree_profit += $product['drp_degree_profit'];
            }
            $tmp_order['drp_degree_profit'] = number_format($order_drp_degree_profit, 2, '.', '');
            $tmp_order['products'] = $products;
            $tmp_order['rows'] = $comment_count + $product_count;
            $tmp_order['comment_count'] = $comment_count;
            if (($tmp_order['store_id'] == $this->store_session['store_id']) || empty($tmp_order['suppliers'])) {
                //$tmp_order['postage'] = number_format($tmp_order['postage'], 2, '.', '');
            } else {
                //$tmp_order['postage'] = number_format($postage, 2, '.', '');
            }

            //分销商等级奖励
            if (!empty($tmp_order['drp_degree_id'])) {
                $drp_degree = M('Drp_degree')->getDrpDegree(array('pigcms_id' => $tmp_order['drp_degree_id']));
                if (!empty($drp_degree)) {
                    $tmp_order['drp_degree_name'] = $drp_degree['name'];
                }
            }
        }

        //收货地址
        $order_info['address'] = unserialize($order_info['address']);

        // 订单来源
        if (empty($order_info['user_order_id'])) {
            $order_info['from'] = '本店';
        } else {
            $tmp_order_info = D('Order')->field('uid,store_id,payment_method')->where(array ('order_id' => $order_info['user_order_id']))->find();
            $seller = D('Store')->field('name')->where(array ('store_id' => $tmp_order_info['store_id']))->find();
            $order_info['from'] = $seller['name'];
            $order_info['payment_method'] = $tmp_order_info['payment_method'];
            $order_info['uid'] = $tmp_order_info['uid'];
        }

        if (empty($user_order['uid'])) {
            $order_info['buyer'] = $order_info['address_user'];
        } else {
            $user_info = M('User')->checkUser(array('uid' => $user_order['uid']));
            $order_info['buyer'] = !empty($user_info['nickname']) ? $user_info['nickname'] : $order_info['address_user'];
        }

        //支付方式
        $order_info['payment_method'] = M('Order')->getPaymentMethod($order_info['payment_method']);
        //订单状态
        $status = M('Order')->status();

        //优惠券、折扣、满减
        import('source.class.Order');
        $order_info['activities'] = Order::orderDiscount($order_info, $order_products);

        //送积分
        $order_info['points'] = M('User_points_record')->getOrderPoint(array ('order_id' => $user_order_id));

        $this->assign('status', $status);
        $this->assign('orders', $orders);
        $this->assign('order', $order_info);
        $this->assign('main_order', $order_info);
    }

    /* 我的批发商品 */
    public function my_wholesale()
    {
        $this->checkFx(false, true);

        $this->display();
    }

    private function my_wholesale_content()
    {
        $product = M('Product');
        $product_group = M('Product_group');
        $product_to_group = M('Product_to_group');

        $order_by_field = isset($_POST['orderbyfield']) ? $_POST['orderbyfield'] : '';
        $order_by_method = isset($_POST['orderbymethod']) ? $_POST['orderbymethod'] : '';
        $keyword = isset($_POST['name']) ? trim($_POST['name']) : '';
        $group_id = isset($_POST['group_id']) ? trim($_POST['group_id']) : '';
        $is = !empty($_POST['is']) ? $_POST['is'] : 1;

        $where = array ();
        $where['store_id'] = $this->store_session['store_id'];
        $where['quantity'] = array ('>', 0);
        if($is == 1){
            $where['status'] = 1;
        }else if ($is == 2){
            $where['status'] = 0;
        }
        $where['soldout'] = 0;
        $where['wholesale_product_id'] = array ('>', 0);
        $where['uid'] = array ('=', $this->user_session['uid']);
        if ($keyword) {
            $where['name'] = array ('like', '%' . $keyword . '%');
        }
        if ($group_id) {
            $products = $product_to_group->getProducts($group_id);
            $product_ids = array ();
            if (!empty($products)) {
                foreach ($products as $item) {
                    $product_ids[] = $item['product_id'];
                }
            }
            $where['product_id'] = array ('in', $product_ids);
        }

        $product_total = $product->getSellingTotal($where);
        import('source.class.user_page');
        $page = new Page($product_total, 15);
        $tmp_product = $product->getWholesale($where, $order_by_field, $order_by_method, $page->firstRow, $page->listRows);

        $products = array ();
        foreach ($tmp_product as $product) {
            /* 商品供货商 */
            $supplier_store_id = D('Product')->field('store_id')->where(array ('product_id' => $product['wholesale_product_id']))->find();
            $supplier_name = D('Store')->field('name')->where(array ('store_id' => $supplier_store_id['store_id']))->find();
            $products[] = array (
                'supplier_name' => $supplier_name['name'], // 商品供货商
                'name' => $product['name'],
                'wholesale_price' => $product['wholesale_price'], //批发价
                'quantity' => $product['quantity'], //库存
                'sale_min_price' => $product['sale_min_price'], //最低价
                'sale_max_price' => $product['sale_max_price'], //最低价
                'image' => $product['image'],
                'sales' => $product['sales'],  //销量
                'is_recommend' => $product['is_recommend'],  //是否推荐
                'status' => $product['status'],
                'product_id' => $product['product_id'],
                'supplier_id' => $product['supplier_id'],
                'store_id' => $product['store_id'],
                'wholesale_product_id' => $product['wholesale_product_id'],
                'is_fx' => $product['is_fx']
            );
        }
        $product_groups = $product_group->get_all_list($this->store_session['store_id']);

        $this->assign('product_groups', $product_groups);
        $this->assign('product_groups_json', json_encode($product_groups));
        $this->assign('page', $page->show());
        $this->assign('products', $products);
        $this->assign('is', $is);
    }

    /* 我的供货商 */
    public function my_supplier()
    {
        $this->checkFx(false, true);

        $this->display();
    }

    
    
    
    public function sql_in(){
        $list = D('Aptitude_tpl')->select();
        var_dump($list);
    }
    
    
    protected function uploadOne($img){
        $tmp=array();
        $dir_file=PIGCMS_PATH.DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR.'zc'.DIRECTORY_SEPARATOR.date('Y',$_SERVER['REQUEST_TIME']).DIRECTORY_SEPARATOR.date('md',$_SERVER['REQUEST_TIME']);
        if(!file_exists($dir_file)){
            $k=mkdir($dir_file,0777,true);
            if(!$k){
                $tmp['code']=404;
                $tmp['msg']='上传失败，无法创建目录';
                return $tmp;
            }
        }
        $path = pathinfo($img['name']);
        $new_name=md5($_SERVER['REQUEST_TIME']).'.'.$path['extension'];
        $new_path=$dir_file.DIRECTORY_SEPARATOR.$new_name;
        $path='zc/'.date('Y',$_SERVER['REQUEST_TIME']).'/'.date('md',$_SERVER['REQUEST_TIME']).'/'.$new_name;
        if( move_uploaded_file($img['tmp_name'], $new_path) ){
            // 上传到又拍云服务器
            $attachment_upload_type = option('config.attachment_upload_type');
            if ($attachment_upload_type == '1') {
                import('source.class.upload.upyunUser');
                upyunUser::upload('./upload/'.$path, '/'.$path);
            }
            $tmp['code']=200;
            $tmp['path']=getAttachmentUrl($path);
            return $tmp;
        }else{
            $tmp['code']=404;
            $tmp['msg']='上传失败，移动文件失败';
            return $tmp;
        }
    }
    
    
    function ajax_uploadImg(){
		if(IS_POST){
			$s=array();
			$img=$_FILES['myfile'];
                $path = pathinfo($img['name']);
		        $extension=$path['extension'];
		        $img_type=array('jpg','jpeg','png','gif');
		        if(!in_array($extension, $img_type)){
		            $s['code']=404;
		            $s['msg']='上传失败，不是常见的图片类型';
		            echo json_encode($s);exit;
		        }
			$s=$this->uploadOne($img);
			if($s['code']==200){
				echo json_encode($s);exit;
			}else{
				echo json_encode($s);exit;
			}
		}else{
			echo json_encode(array('code'=>404));exit;
		}
	}
    
    
    
    //资质模板
    public function aptitude_tpl(){
        
//        dump($_SESSION);
        $this->checkFx(false, true);
        $store_id = $_SESSION['store']['store_id'];
        $aptitudeTplList = D('Aptitude_tpl')->where(array('store_id'=>$store_id))->order('tpl_id desc')->select();
        foreach($aptitudeTplList as $k=>$v){
            $degree_info  = D('Drp_degree')->where(array('store_id'=>$store_id,'pigcms_id'=>$v['degree_id']))->find();
            
            if(empty ($degree_info['degree_alias'])){
                $info = D('Platform_drp_degree')->where(array('pigcms_id'=>$degree_info['is_platform_degree_name']))->find();
                $aptitudeTplList[$k]['degree_name'] = $info['name'];
            }  else {
                $aptitudeTplList[$k]['degree_name'] = $degree_info['degree_alias'];
            }
        }
        $this->assign('aptitudeTplList',$aptitudeTplList);
        $this->display();
    }
    
    public function  preview(){
        $tpl_id = $_GET['id'];
        $tpl_info = D('Aptitude_tpl')->where(array('tpl_id'=>$tpl_id))->find();
        if(!empty ($tpl_info)){
            $tpl_info['store_name_seat'] = explode(',',$tpl_info['store_name_seat']);
                $tpl_info['store_name_seat'][0] = substr($tpl_info['store_name_seat'][0],0,-2);
                $tpl_info['store_name_seat'][1] = substr($tpl_info['store_name_seat'][1],0,-2);
            $tpl_info['proposer_seat'] = explode(',',$tpl_info['proposer_seat']);
                $tpl_info['proposer_seat'][0] = substr($tpl_info['proposer_seat'][0],0,-2);
                $tpl_info['proposer_seat'][1] = substr($tpl_info['proposer_seat'][1],0,-2);
            $tpl_info['validity_time_seat'] = explode(',',$tpl_info['validity_time_seat']);
                $tpl_info['validity_time_seat'][0] = substr($tpl_info['validity_time_seat'][0],0,-2);
                $tpl_info['validity_time_seat'][1] = substr($tpl_info['validity_time_seat'][1],0,-2);
            $time = time()+$tpl_info['validity_time']*31*86400;
            $stime = date("Y.m.d ",time());
            $otime = date("Y.m.d ",$time);
            $tpl_info['validity_time'] =  $stime."\n".$otime;
            $this->assign('tpl_info',$tpl_info);
        }
        $img_name = 'tpl_'.time();
        
        $sname_left = $tpl_info['store_name_seat'][0];
        $sname_top = $tpl_info['store_name_seat'][1];
        $sname = $tpl_info['store_name'];
        
        $uname_left = $tpl_info['proposer_seat'][0];
        $uname_top = $tpl_info['proposer_seat'][1];
        $uname = $_SESSION['user']['nickname'];
        
        $time_left = $tpl_info['validity_time_seat'][0];
        $time_top = $tpl_info['validity_time_seat'][1];
        $time = $tpl_info['validity_time'];
        
        $font_zt = 'mzd';

        $dst_path = $tpl_info['tpl_img_url'];
        //创建图片的实例
        $dst = imagecreatefromstring(file_get_contents($dst_path));
        //打上文字
        $font = './static/zt/'.$font_zt.'.ttf';//字体
        $black = imagecolorallocate($dst, 0x00, 0x00, 0x00);//字体颜色
        imagefttext($dst, 20, 0, $sname_left, $sname_top, $black, $font,$sname); //店铺名称
        imagefttext($dst, 20, 0, $uname_left, $uname_top, $black, $font,$uname);//个人签名
        imagefttext($dst, 10, 0, $time_left, $time_top, $black, $font,$time);//时间
   
        //输出图片
        list($dst_w, $dst_h, $dst_type) = getimagesize($dst_path);
        switch ($dst_type) {
            case 1://GIF
                header('Content-Type: image/gif');
                imagepng($dst);
                break;
            case 2://JPG
                header('Content-Type: image/jpeg');
                imagepng($dst);
                break;
            case 3://PNG
                header('Content-Type: image/png');
                imagepng($dst);
                break;
            default:
                break;
        }
    }
    
//    添加资质模板
    public function aptitude_tpl_add(){
        $_POST['uid'] = $_SESSION['user']['uid'];
        $_POST['store_name'] = $_SESSION['store']['name'];
        $_POST['store_id'] = $_SESSION['store']['store_id'];
        
        if($_POST['status'] == 1){
            $info = D('Aptitude_tpl')->where(array('object'=>$_POST['object'],'status'=>1,'store_id'=>$_POST['store_id'],'degree_id'=>$_POST['degree_id']))->find();
            if($info){
                json_return(1003, '添加失败,请修改状态');die;
            }
        }
        
        $lid = D('Aptitude_tpl')->data($_POST)->add();
        if($lid){
            json_return(1001, '添加成功');die;
        }  else {
            json_return(1002, '添加失败');die;
        }
    }
//    修改资质模板
    public function aptitude_tpl_edit(){
        $tpl_id = $_POST['tpl_id'];
        $store_id= $_SESSION['store']['store_id'];
        $tplInfo = D('Aptitude_tpl')->where(array('tpl_id'=>$tpl_id,'store_id'=>$store_id))->find();
        $tplInfo['store_name_seat'] = explode(',',$tplInfo['store_name_seat']);
        $tplInfo['proposer_seat'] = explode(',',$tplInfo['proposer_seat']);
        $tplInfo['validity_time_seat'] = explode(',',$tplInfo['validity_time_seat']);
        echo json_encode($tplInfo);
    }
//    获取资质模板
    public function obtain_tpl(){
        $this->assign('store_id',$_GET['id']);
        $info = D('Aptitude_obtain')->where(array('store_id'=>$_SESSION['store']['store_id'],'drp_supplier_id'=>$_GET['id'],'object'=>1))->find();
        $this->assign('info',$info);
//        dump($info);
        $this->display();
    }
//    修改资质模板数据
    public function aptitude_tpl_edit_data(){
        $store_id= $_SESSION['store']['store_id'];
        
        if($_POST['status'] == 1){
            $where = "`object`=".$_POST['object']." AND `status` = 1 AND `store_id` = ".$store_id." AND `degree_id` = ".$_POST['degree_id']." AND `tpl_id` != ".$_POST['tpl_id'];
//            $info = D('Aptitude_tpl')->where(array('object'=>$_POST['object'],'status'=>1,'store_id'=>$store_id,'degree_id'=>$_POST['degree_id']))->find();
            $info = D('Aptitude_tpl')->where($where)->find();
            if($info){
                json_return(1003, '修改失败,请修改状态');die;
            }
        }
        
        
        $eid = D('Aptitude_tpl')->where(array('tpl_id'=>$_POST['tpl_id'],'store_id'=>$store_id))->data($_POST)->save();
        if($eid){
            json_return(1001, '修改成功');
        }  else {
            json_return(1002, '修改失败请重试');
        }
    }
//    获取分校等级
    public function fx_degree_data(){
        $store_id = $_SESSION['store']['store_id'];
        
        $degree_list = D('Drp_degree')->where(array('store_id'=>$store_id))->select();
        if(empty ($degree_list)){
            echo 1;die;//返回1表示该供货商没有设置等级
        }
        $html.='<option value="0">默认等级</option>';
        foreach($degree_list as $k=>$v){
            if(empty ($v['degree_alias'])){
                $info = D('Platform_drp_degree')->where(array('pigcms_id'=>$v['is_platform_degree_name']))->find();
                $html.='<option value="'.$v['pigcms_id'].'">'.$info['name'].'</option>';
            }  else {
                $html.='<option value="'.$v['pigcms_id'].'">'.$v['degree_alias'].'</option>';
            }
            
        }
        echo $html;exit;
    }
//    修改资质模板状态
    public function up_status(){
        $store_id= $_SESSION['store']['store_id'];
        if($_POST['status'] == 1){
            $_POST['status'] = 2;
        }  elseif ($_POST['status'] == 2) {
            $info = D('Aptitude_tpl')->where(array('object'=>$_POST['object'],'status'=>1,'store_id'=>$store_id,'degree_id'=>$_POST['degree_id']))->find();
            if($info){
                json_return(1003, '修改失败,请修改状态');die;
            }
            $_POST['status'] = 1;
        }
        $eid = D('Aptitude_tpl')->where(array('tpl_id'=>$_POST['tpl_id'],'store_id'=>$store_id))->data($_POST)->save();
        if($eid){
            json_return(1001, '修改成功');
        }  else {
            json_return(1002, '修改失败');
        }
    }
    
//    经销获取资质模板 生成图片
    public function img_url(){
        $store_id = $_POST['store_id'];
        $tpl_info = D('Aptitude_tpl')->where(array('status'=>1,'object'=>1,'store_id'=>$store_id))->find();
        
        if(empty ($tpl_info)){
            echo 1;//为1就是没有模板数据
            die;
        }
//        dump($store_id);
//        die;
        if(!empty ($tpl_info)){
            $tpl_info['store_name_seat'] = explode(',',$tpl_info['store_name_seat']);
                $tpl_info['store_name_seat'][0] = substr($tpl_info['store_name_seat'][0],0,-2);
                $tpl_info['store_name_seat'][1] = substr($tpl_info['store_name_seat'][1],0,-2);
            $tpl_info['proposer_seat'] = explode(',',$tpl_info['proposer_seat']);
                $tpl_info['proposer_seat'][0] = substr($tpl_info['proposer_seat'][0],0,-2);
                $tpl_info['proposer_seat'][1] = substr($tpl_info['proposer_seat'][1],0,-2);
            $tpl_info['validity_time_seat'] = explode(',',$tpl_info['validity_time_seat']);
                $tpl_info['validity_time_seat'][0] = substr($tpl_info['validity_time_seat'][0],0,-2);
                $tpl_info['validity_time_seat'][1] = substr($tpl_info['validity_time_seat'][1],0,-2);
            $time = time()+$tpl_info['validity_time']*31*86400;
            $stime = date("Y.m.d ",time());
            $otime = date("Y.m.d ",$time);
            $tpl_info['validity_time'] =  $stime."\n".$otime;
            $this->assign('tpl_info',$tpl_info);
        }
        $img_name = 'tpl_'.time();
        
        $sname_left = $tpl_info['store_name_seat'][0];
        $sname_top = $tpl_info['store_name_seat'][1];
        $sname = $tpl_info['store_name'];
        
        $uname_left = $tpl_info['proposer_seat'][0];
        $uname_top = $tpl_info['proposer_seat'][1];
        $uname = $_POST['uname'];
        
        $time_left = $tpl_info['validity_time_seat'][0];
        $time_top = $tpl_info['validity_time_seat'][1];
        $time = $tpl_info['validity_time'];
        
        $font_zt = 'mzd';

        $dst_path = $tpl_info['tpl_img_url'];
        //创建图片的实例
        $dst = imagecreatefromstring(file_get_contents($dst_path));
        //打上文字
        $font = './static/zt/'.$font_zt.'.ttf';//字体
        $black = imagecolorallocate($dst, 0x00, 0x00, 0x00);//字体颜色
        imagefttext($dst, 20, 0, $sname_left, $sname_top, $black, $font,$sname); //店铺名称
        imagefttext($dst, 20, 0, $uname_left, $uname_top, $black, $font,$uname);//个人签名
        imagefttext($dst, 10, 0, $time_left, $time_top, $black, $font,$time);//时间
   
        //输出图片
        list($dst_w, $dst_h, $dst_type) = getimagesize($dst_path);
        switch ($dst_type) {
            case 1://GIF
                header('Content-Type: image/gif');
                imagepng($dst,"./upload/tpl/".$img_name.".gif");
                $aa = "./upload/tpl/".$img_name.".gif";
                break;
            case 2://JPG
                header('Content-Type: image/jpeg');
                imagepng($dst,"./upload/tpl/".$img_name.".jpeg");
                $aa = "./upload/tpl/".$img_name.".jpeg";
                break;
            case 3://PNG
                header('Content-Type: image/png');
                imagepng($dst,"./upload/tpl/".$img_name.".png");
                $aa =  "./upload/tpl/".$img_name.".png";
                break;
            default:
                break;
        }
        
        if(empty($aa)){
            echo 2;//生成图片失败
        }  else {
            $data['drp_supplier_id'] = $_POST['store_id'];
            $data['object'] = 1;
            $data['store_id'] = $_SESSION['store']['store_id'];
            $data['img_url'] = $aa;
            $info = D('Aptitude_obtain')->where(array('store_id'=>$data['store_id'],'drp_supplier_id'=>$data['drp_supplier_id'],'object'=>1))->find();
            if($info){
                $lid = D('Aptitude_obtain')->where(array('store_id'=>$data['store_id'],'drp_supplier_id'=>$data['drp_supplier_id'],'object'=>1))->data($data)->save();
            }else{
                $id = D('Aptitude_obtain')->data($data)->add(); 
            }
            echo $aa;
        }
    }
    
    
    



//    删除资质模板
    public function aptitude_tpl_delete(){
        $tpl_id = $_POST['tpl_id'];
        D('Aptitude_tpl')->where(array("tpl_id"=>$tpl_id))->delete();
        json_return(1001, '删除成功');
    }
    
    
    
    
    
    
    
//    分销获取证书
    
    public function fx_obtain_tpl(){
        $this->display();
    }
    
    
//    分销生成图片
    public function fx_obtain_img(){
        $store_id = $_SESSION['store']['root_supplier_id'];
        $drp_degree_id = $_SESSION['store']['drp_degree_id'];
        $tpl_info = D('Aptitude_tpl')->where(array('status'=>1,'object'=>2,'store_id'=>$store_id,'degree_id'=>$drp_degree_id))->find();
        if(empty ($tpl_info)){
            echo 1;//为1就是没有模板数据
            die;
        }

        if(!empty ($tpl_info)){
            $tpl_info['store_name_seat'] = explode(',',$tpl_info['store_name_seat']);
                $tpl_info['store_name_seat'][0] = substr($tpl_info['store_name_seat'][0],0,-2);
                $tpl_info['store_name_seat'][1] = substr($tpl_info['store_name_seat'][1],0,-2);
            $tpl_info['proposer_seat'] = explode(',',$tpl_info['proposer_seat']);
                $tpl_info['proposer_seat'][0] = substr($tpl_info['proposer_seat'][0],0,-2);
                $tpl_info['proposer_seat'][1] = substr($tpl_info['proposer_seat'][1],0,-2);
            $tpl_info['validity_time_seat'] = explode(',',$tpl_info['validity_time_seat']);
                $tpl_info['validity_time_seat'][0] = substr($tpl_info['validity_time_seat'][0],0,-2);
                $tpl_info['validity_time_seat'][1] = substr($tpl_info['validity_time_seat'][1],0,-2);
            $time = time()+$tpl_info['validity_time']*31*86400;
            $stime = date("Y.m.d ",time());
            $otime = date("Y.m.d ",$time);
            $tpl_info['validity_time'] =  $stime."\n".$otime;
//            $this->assign('tpl_info',$tpl_info);
        }
        $img_name = 'tpl_'.time();
        
        $sname_left = $tpl_info['store_name_seat'][0];
        $sname_top = $tpl_info['store_name_seat'][1];
        $sname = $tpl_info['store_name'];
        
        $uname_left = $tpl_info['proposer_seat'][0];
        $uname_top = $tpl_info['proposer_seat'][1];
        $uname = $_POST['uname'];
       
        $time_left = $tpl_info['validity_time_seat'][0];
        $time_top = $tpl_info['validity_time_seat'][1];
        $time = $tpl_info['validity_time'];
         
        $font_zt = 'mzd';

        $dst_path = $tpl_info['tpl_img_url'];
        
  
        
//       die;
        //创建图片的实例
        $dst = imagecreatefromstring(file_get_contents($dst_path));
        //打上文字
        $font = './static/zt/'.$font_zt.'.ttf';//字体
        $black = imagecolorallocate($dst, 0x00, 0x00, 0x00);//字体颜色
        imagefttext($dst, 20, 0, $sname_left, $sname_top, $black, $font,$sname); //店铺名称
        imagefttext($dst, 20, 0, $uname_left, $uname_top, $black, $font,$uname);//个人签名
        imagefttext($dst, 10, 0, $time_left, $time_top, $black, $font,$time);//时间
   
        //输出图片
        list($dst_w, $dst_h, $dst_type) = getimagesize($dst_path);
        switch ($dst_type) {
            case 1://GIF
                header('Content-Type: image/gif');
                imagepng($dst,"./upload/tpl/".$img_name.".gif");
                $img_url = "./upload/tpl/".$img_name.".gif";
                break;
            case 2://JPG
                header('Content-Type: image/jpeg');
                imagepng($dst,"./upload/tpl/".$img_name.".jpeg");
                $img_url = "./upload/tpl/".$img_name.".jpeg";
                break;
            case 3://PNG
                header('Content-Type: image/png');
                imagepng($dst,"./upload/tpl/".$img_name.".png");
                $img_url =  "./upload/tpl/".$img_name.".png";
                break;
            default:
                break;
        }
//        header('Content-Type: image/png');
//        imagepng($dst);
//        die;
        if(empty ($img_url)){
            echo 2;//生成图片失败
        }else{
            $data['drp_supplier_id'] = $store_id;
            $data['object'] = 2;
            $data['store_id'] = $_SESSION['store']['store_id'];
            $data['img_url'] = $img_url;
            $info = D('Aptitude_obtain')->where(array('store_id'=>$data['store_id'],'drp_supplier_id'=>$data['drp_supplier_id'],'object'=>2))->find();
            if($info){
                $lid = D('Aptitude_obtain')->where(array('store_id'=>$data['store_id'],'drp_supplier_id'=>$data['drp_supplier_id'],'object'=>2))->data($data)->save();
            }else{
                $id = D('Aptitude_obtain')->data($data)->add(); 
            }
            echo $img_url;	
        }
    }
    
    

    private function my_supplier_content()
    {
        $store = M('Store');
        $product = M('Product');

        $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
        $distributor_id = $this->store_session['store_id'];    //当前店铺id

        $where = array ();

        if (!empty($keyword)) {
            $where['name'] = array ('like' => '%' . $keyword . '%');
        }

        $supplier_count = $store->getSupplierCount($where, $distributor_id);

        import('source.class.user_page');
        $page = new Page($supplier_count, 15);
        $supplierlist = $store->getMySupplierList($where, $page->firstRow, $page->listRows, $distributor_id);

        $suppliers = array ();
        foreach ($supplierlist as $supplier) {
            //统计每个店铺下可批发商品数量
            $product_count = $product->db->where(array ('store_id' => $supplier['store_id'], 'is_wholesale' => 1))->count('product_id');

            //获取主营类目
            $category_name = D('Sale_category')->field('name')->where(array ('cat_id' => $supplier['sale_category_id']))->find();

            //当前用户相对于此供货商的保证金余额
            $bond = D('Supp_dis_relation')->field('bond')->where(array ('distributor_id' => $this->store_session['store_id'], 'supplier_id' => $supplier['store_id']))->find();
            //当前用户相对于此供货商的保证金余额

            $suppliers[] = array (
                'open_store_whole' => $supplier['open_store_whole'],
                'bond' => $bond['bond'],
                'store_name' => $supplier['name'],
                'category_name' => $category_name['name'],
                'linkman' => $supplier['linkman'],
                'tel' => $supplier['tel'],
                'logo' => !empty($supplier['logo']) ? getAttachmentUrl($supplier['logo'], FALSE) : getAttachmentUrl('images/default_shop.png', FALSE),
                'product_count' => $product_count, //店铺商品数量
                'date_added' => $supplier['date_added'],
                'store_id' => $supplier['store_id'],
                'is_required_to_audit' => $supplier['is_required_to_audit'], //是否需要审核批发商
                'is_required_margin' => $supplier['is_required_margin'], //是否需要保证金
            );
        }
//        dump($suppliers);
        $this->assign('suppliers', $suppliers);
        $this->assign('page', $page->show());
    }

    // 分销订单
    public function wholesale_order()
    {
        if (IS_POST && strtolower($_POST['type'] == 'pay')) {
            if (!$this->checkFx(true)) {
                json_return(1001, '操作失败');
            }

            $fx_order = M('Fx_order');
            $order_id = isset($_POST['order_id']) ? trim($_POST['order_id']) : 0;
            $trade_no = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
            $where = array ();
            $where['_string'] = 'fx_order_id IN(' . $order_id . ')';
            if ($fx_order->edit($where, array ('fx_trade_no' => $trade_no))) {
                json_return(0, url('pay_order', array ('trade_no' => $trade_no)));
            } else {
                json_return(1001, '操作失败');
            }
        }

        $this->checkFx(false, true);

        $this->display();
    }

    private function wholesale_order_content()
    {
        $store = M('Store');
        $store_supplier = M('Store_supplier');
        $order = M('Order');
        $fx_order = M('Fx_order');
        $order_product = M('Fx_order_product');

        $where = array ();
        $where['type'] = 5;
        $where['s.status'] = array ('>', 0);
        $where['s.store_id'] = $this->store_session['store_id'];
        if (!empty($_POST['order_no'])) {
            $where['ss.order_no'] = $_POST['order_no'];
        }
        if (!empty($_POST['fx_order_no'])) {
            $where['ss.fx_order_no'] = $_POST['fx_order_no'];
        }
        if (!empty($_POST['delivery_user'])) {
            $where['ss.delivery_user'] = $_POST['delivery_user'];
        }
        if (!empty($_POST['supplier_id'])) {
            $where['s.supplier_id'] = $_POST['supplier_id'];
        }
        if (!empty($_POST['status'])) {
            $where['s.status'] = $_POST['status'];
        }
        if (!empty($_POST['delivery_tel'])) {
            $where['ss.delivery_tel'] = $_POST['delivery_tel'];
        }
        if (!empty($_POST['start_time']) && !empty($_POST['stop_time'])) {
            $where['_string'] = "ss.add_time >= " . strtotime($_POST['start_time']) . " AND ss.add_time <= " . strtotime($_POST['stop_time']);
        } else if (!empty($_POST['start_time'])) {
            $where['ss.add_time'] = array ('>=', strtotime($_POST['start_time']));
        } else if (!empty($_POST['stop_time'])) {
            $where['ss.add_time'] = array ('<=', strtotime($_POST['stop_time']));
        }
        $orderby = 'ss.order_id DESC';
        $order_count = $order->getWholealeCount($where);
        import('source.class.user_page');
        $page = new Page($order_count, 15);
        $tmp_orders = $order->getWholeale($where, $orderby, $page->firstRow, $page->listRows);

        $orders = array ();
        foreach ($tmp_orders as $tmp_order) {
            $supplier = $store->getStore($tmp_order['supplier_id']); //供货商
            $fx = $store->getStore($tmp_order['store_id']); //供货商

            $store_info[$tmp_order['store_id']] = $store->getStore($tmp_order['store_id']);
            $supplier_name = $supplier['name'];
            $fx_name = $fx['name'];
            $products = $order_product->getFxProducts($tmp_order['fx_order_id']);
            $orders[] = array (
                'fx_order_id' => $tmp_order['fx_order_id'],
                'fx_order_no' => $tmp_order['fx_order_no'],
                'order_no' => $tmp_order['order_no'],
                'total' => $tmp_order['cost_total'],
                'supplier_id' => $tmp_order['supplier_id'],
                'store_id' => $tmp_order['store_id'],
                'drp_level' => $fx['drp_level'],
                'supplier' => $supplier_name,
                'fx' => $fx_name,
                'products' => $products,
                'add_time' => date('Y-m-d H:i:s', $tmp_order['add_time']),
                'delivery_user' => $tmp_order['delivery_user'],
                'delivery_tel' => $tmp_order['delivery_tel'],
                'status' => $fx_order->status_text($tmp_order['status']),
                'status_id' => $tmp_order['status']
            );
        }
        $suppliers = $store_supplier->suppliers(array ('seller_id' => $this->store_session['store_id']));

        $status = $order->status();
        $this->assign('orders', $orders);
        $this->assign('page', $page->show());
        $this->assign('suppliers', $suppliers);
        $this->assign('status', $status);
        $this->assign('store_info', $store_info);
    }

    public function fans_lifelong()
    {
        $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : 0;
        $result = D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('setting_fans_forever' => $status))->save();

        if ($result)
        {
            $_SESSION['store']['setting_fans_forever'] = $status;
            echo TRUE;
        }
        else
        {
            echo FALSE;
        }
    }

    public function fanshare_drp()
    {
        $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : 0;
        $result = D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('is_fanshare_drp' => $status))->save();
        if ($result)
        {
            $_SESSION['store']['is_fanshare_drp'] = $status;
            echo TRUE;
        }
        else
        {
            echo FALSE;
        }
    }

    public function drp_supplier_forever()
    {
        $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : 0;
        $result = D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('setting_drp_supplier_forever' => $status))->save();
        if ($result)
        {
            $_SESSION['store']['setting_drp_supplier_forever'] = $status;
            echo TRUE;
        }
        else
        {
            echo FALSE;
        }
    }

    private function _seller_setting_content()
    {
        $this->assign('setting_fans_forever', $this->store_session['setting_fans_forever']);
        $this->assign('is_fanshare_drp', $this->store_session['is_fanshare_drp']);
        $this->assign('setting_drp_supplier_forever', $this->store_session['setting_drp_supplier_forever']);
        $this->assign('setting_canal_qrcode', $this->store_session['setting_canal_qrcode']);
        $this->assign('canal_qrcode_tpl', $this->store_session['canal_qrcode_tpl']);
        $this->assign('canal_qrcode_img', $this->store_session['canal_qrcode_img']);
    }

    public function setting_canal_qrcode()
    {
        $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : 0;
        $result = D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('setting_canal_qrcode' => $status))->save();
        if ($result)
        {
            $_SESSION['store']['setting_canal_qrcode'] = $status;
            echo TRUE;
        }
        else
        {
            echo FALSE;
        }
    }

    /* 我的经销商 */
    public function agency()
    {
        $this->checkFx(false, true);

        $this->display();
    }

    private function _agency_content()
    {
        $store_supplier = M('Store_supplier');
        $store_relation = M('Supp_dis_relation');
        $store_certification = M('Certification');
        $store = M('Store');

        $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
        $supplierId = $this->store_session['store_id'];    //当前供货商id
        $authen = !empty($_POST['authen']) ? $_POST['authen'] : 1;

        $where = array ();
        $store_id = $this->store_session['store_id'];
        if (!empty($keyword))
        {
            if ($authen != 3)
            {
                $where['s.name'] = array ('like' => '%' . $keyword . '%');
            }
        }

        if ($authen == 1)
        {
            $authen_count = $store_relation->getAuthenCount($where, $store_id);
			
            import('source.class.user_page');
            $page = new Page($authen_count, 15);

            $authenList = $store_relation->getAuthen($where, $store_id, $page->firstRow, $page->listRows);

            $suppliers = array ();
            foreach ($authenList as $authens)
            {
                //保证金余额
                $bond = D('Supp_dis_relation')->field('bond')->where(array ('distributor_id' => $authens['store_id']))->find();

                //未对账金额
                $sql = "select SUM(f.cost_sub_total) as unsellers  from pigcms_order o, pigcms_fx_order f where o.fx_order_id = f.`fx_order_id` and o.store_id={$supplierId} and type = 5 and f.`store_id` ={$authens['store_id']} and o.is_check = 1 and o.status = 4";
                $unsellers = D('Store')->query($sql);

                //未对账订单
                $sql = "SELECT COUNT(O.order_id) as store_id FROM pigcms_order o, pigcms_fx_order f WHERE o.fx_order_id = f.`fx_order_id` AND o.store_id={$supplierId} and f.`store_id` ={$authens['store_id']} AND TYPE = 5 AND o.is_check = 1 AND o.status = 4";
                $order = D('Store')->query($sql);
                $order_count = $order[0]['store_id'];

                //销售额
                $sql = "SELECT SUM(o.total) as income FROM pigcms_order o, pigcms_fx_order f WHERE o.fx_order_id = f.`fx_order_id` AND o.store_id={$supplierId} and f.`store_id` ={$authens['store_id']} AND TYPE = 5  AND o.status = 4";
                $unwholesale = D('Store')->query($sql);
                $income = $unwholesale[0]['income'];
                $seller_sales = number_format($income, 2, '.', '');

                //$sql = "select SUM(f.cost_sub_total) as unsellers  from pigcms_order o, pigcms_fx_order f where o.fx_order_id = f.`fx_order_id` and o.store_id={$supplierId} and type = 5 and f.`store_id` ={$authens['store_id']} and o.is_check = 1 and o.status = 4";
                //$unsellers = D('Store')->query($sql);

                $suppliers[] = array (
                    'bond' => $bond['bond'],
                    'seller' => $seller_sales,
                    'order_count' => $order_count,
                    'unseller' => $unsellers[0]['unsellers'],
                    'name' => $authens['name'],
                    'store_id' => $authens['store_id'],
                    'tel' => $authens['tel'],
                    'linkman' => $authens['linkman'],
                    'service_tel' => $authens['service_tel'],
                    'service_weixin' => $authens['service_weixin'],
                    'status' => $authens['status'],
                    'date_added' => $authens['date_added'],
                    'logo' => !empty($authens['logo']) ? getAttachmentUrl($authens['logo'], FALSE) : getAttachmentUrl('images/default_shop.png', FALSE),
                );
            }
        }
        else if ($authen == 2)//未审核的经销商
        {
            $authen_count = $store_relation->getNotAuthenCount($where, $store_id);
            import('source.class.user_page');

            $page = new Page($authen_count, 15);
            $notAuthenList = $store_relation->getNotAuthen($where, $store_id, $page->firstRow, $page->listRows);

            $suppliers = array ();
            foreach ($notAuthenList as $authenList)
            {
                $suppliers[] = array (
                    'name' => $authenList['name'],
                    'store_id' => $authenList['store_id'],
                    'tel' => $authenList['tel'],
                    'linkman' => $authenList['linkman'],
                    'service_tel' => $authenList['service_tel'],
                    'service_weixin' => $authenList['service_weixin'],
                    'status' => $authenList['status'],
                    'date_added' => $authenList['date_added'],
                    'logo' => !empty($authenList['logo']) ? getAttachmentUrl($authenList['logo'], FALSE) : getAttachmentUrl('images/default_shop.png', FALSE),
                );
            }
        }
        else if ($authen == 3)
        {
            if (!empty($keyword))
            {
                $where['name'] = array ('like' => '%' . $keyword . '%');
                $where['uid'] = array('!=' => $this->user_session['uid']);
                $authen_count = $store_relation->getAllAgencyCount($where);
                import('source.class.user_page');

                $page = new Page($authen_count, 12);
                $notAuthenList = $store_relation->getAllAagency($where, $store_id, $page->firstRow, $page->listRows);

                $suppliers = array ();
                foreach ($notAuthenList as $authenList)
                {
                    $suppliers[] = array (
                        'name' => $authenList['name'],
                        'store_id' => $authenList['store_id'],
                        'tel' => $authenList['tel'],
                        'linkman' => $authenList['linkman'],
                        'service_tel' => $authenList['service_tel'],
                        'service_weixin' => $authenList['service_weixin'],
                        'status' => $authenList['status'],
                        'date_added' => $authenList['date_added'],
                        'logo' => !empty($authenList['logo']) ? getAttachmentUrl($authenList['logo'], FALSE) : getAttachmentUrl('images/default_shop.png', FALSE),
                    );
                }
            }
        }

        $this->assign('authen', $authen);
        $this->assign('suppliers', $suppliers);
        if($authen != 3)
        {
            $this->assign('page', $page->show());
        }
    }

    /* 批发市场 */
    public function wholesale_market()
    {
        //检测是否开启全网批发
        $this->checkFx(false, true);

        $this->display();
    }

    private function wholesale_market_content()
    {
        if ($_POST['checked'] == 1) {//可批发店铺
            $store = M('Store');
            $product = M('Product');
            $store_id = $this->store_session['store_id'];
            $where = array();
            //我的供货商
            $suppliers = $store->getMySupplierList($where, 0, 0, $store_id);

            $sullierIds = array();
            foreach($suppliers as $sup){
                if($sup['open_store_whole']){
                    array_push($sullierIds,$sup['store_id']);
                }
            }
            $sullierIds = implode(',', $sullierIds);
            $where = array ();
            if (!empty($_POST['store_name'])){
                $where['s.name'] = array ('like' => '%' . $_POST['store_name'] . '%');
            }
            if (!empty($_POST['category_id'])){
                $where['s.sale_category_id'] = intval(trim($_POST['category_id']));
            }
            if (!empty($_POST['category_fid'])){
                $where['s.sale_category_fid'] = intval(trim($_POST['category_fid']));
            }

            $where['s.store_id'] = array ('!=', $this->store_session['store_id']);
            $where['s.drp_level'] = 0;
            $where['s.status'] = 1;
            $where['ss.status'] = 1;
            if($sullierIds){
                $where['s.store_id'] = array('in'=>$sullierIds);
            }

            $store_count = $store->getStoreCount($where);
            import('source.class.user_page');
            $page = new Page($store_count, 15);
            $storeList = $store->getWholeStoer($where, $page->firstRow, $page->listRows);

            $storeInfo = array ();
            foreach ($storeList as $stores) {
                //统计每个店铺下可批发商品数量
                $product_count = $product->db->where(array ('store_id' => $stores['store_id'], 'is_wholesale' => 1))->count('product_id');

                //获取主营类目
                $category_name = D('Sale_category')->field('name')->where(array ('cat_id' => $stores['sale_category_id']))->find();

                //是否已成为其他店铺供货商
                $agent = D('Supp_dis_relation')->where(array('supplier_id'=>$stores['store_id']))->count('id');

                //当前用户相对于此供货商的保证金余额
                $bond = D('Supp_dis_relation')->field('bond')->where(array ('distributor_id' => $this->store_session['store_id'], 'supplier_id' => $stores['store_id']))->find();

                if ($product_count > 0) {
                    $storeInfo[] = array (
                        'is_agent' => $agent,
                        'open_store_whole' => $stores['open_store_whole'],
                        'bond' => $bond['bond'],
                        'category_name' => $category_name['name'],
                        'store_name' => $stores['name'],
                        'store_id' => $stores['store_id'],
                        'linkman' => $stores['linkman'],//店铺联系人
                        'tel' => $stores['tel'], //联系电话
                        'approve' => $stores['approve'], //是否认正
                        'attention_num' => $stores['attention_num'], //店铺关注数
                        'product_count' => $product_count, //店铺商品数量
                        'logo' => !empty($stores['logo']) ? getAttachmentUrl($stores['logo'], FALSE) : getAttachmentUrl('images/default_shop.png', FALSE),
                        'date_added' => $stores['date_added'],
                        'is_required_to_audit' => $stores['is_required_to_audit'], //是否需要审核批发商
                        'is_required_margin' => $stores['is_required_margin'], //是否需要保证金
                    );
                }
            }
            //商品分类
            $categories = D('Sale_category')->where(array ('status' => 1))->select();
            $this->assign('categories', $categories);
            $this->assign('storeInfo', $storeInfo);
            $this->assign('store_count', $store_count);
            $this->assign('sullierIds', $sullierIds);
            $this->assign('page', $page->show());

        } else if ($_POST['checked'] == 2) {
            $store = M('Store');
            $product = M('Product');
            $is = !empty($_POST['is']) ? intval($_POST['is']) : 1;
            $keyword = isset($_POST['store_name']) ? trim($_POST['store_name']) : '';

            $where = array();
            //我的供货商
            $suppliers = $store->getMySupplierList($where, 0, 0, $this->store_session['store_id']);

            $sullierIds = array();
            foreach($suppliers as $sup){
                if($sup['open_store_whole']){
                    array_push($sullierIds,$sup['store_id']);
                }
            }

            $sullierIds = implode(',', $sullierIds);
            //当前店铺信息
            $store_info = $store->getStore($this->store_session['store_id']);

            $where = array();
            $where['uid'] = array('!=', $this->user_session['uid']);
            if ($store_info['drp_level'] == 0) {
                $type = 'wholesale';
                $where['is_wholesale'] = 1; //设置分销的商品
            }else if ($store_info['drp_level'] > 0){
                $type = 'fx';
                $where['is_fx'] = 1;
            }

            if($sullierIds){
                $where['store_id'] = array('in'=>$sullierIds);
            }
            $where['status'] = 1;
            if (!empty($_POST['category_id'])) {
                $where['category_id'] = intval(trim($_POST['category_id']));
            }
            if (!empty($_POST['category_fid'])) {
                $where['category_fid'] = intval(trim($_POST['category_fid']));
            }
            if ($keyword) {
                $where['name'] = array ('like', '%' . $keyword . '%');
            }

            $product_total = $product->supplierMarketProductCount($where);
            import('source.class.user_page');
            $page = new Page($product_total, 15);
            $tmp_products = $product->supplierMarketProducts($where, $page->firstRow, $page->listRows);
            $products = array ();
            $CategoriesArr = array ();
            $wholesale_products = array ();

            foreach ($tmp_products as $tmp_product){
                $supplier = D('Store')->field('name,store_id,open_store_whole,status')->where(array ('store_id' => $tmp_product['store_id']))->find();
                if($supplier['status'] == 1){
                    $tmp_product['supplier'] = $supplier['name'];
                    $tmp_product['open_store_whole'] = $supplier['open_store_whole'];
                    $tmp_product['supplier_id'] = $supplier['store_id'];

                    //是否已成为其他店铺供货商
                    $agent = D('Supp_dis_relation')->where(array('supplier_id'=>$tmp_product['store_id']))->count('id');

                    $tmp_product['is_agent'] = $agent;
                    $store_info = D('Store')->where(array ('store_id' => $tmp_product['store_id']))->find();
                    $tmp_product['store_category_name'] = $CategoriesArr[$store_info['sale_category_fid']]['name'];

                    $products[] = $tmp_product;
                }
            }
            //商品分类
            $category = M('Product_category');
            $categories = $category->getCategories(array ('cat_status' => 1), 'cat_path ASC');
            foreach ($categories as $v) {
                $CategoriesArr[$v['cat_id']] = $v;
            }

            //当前店铺以批发商品
            $currentWholeProducts = D('Product')->field('wholesale_product_id')->where(array('store_id'=>$this->store_session['store_id'],'wholesale_product_id'=>array('>',0)))->select();

            foreach($currentWholeProducts as $currentProduct){
                $wholesale_products[] = $currentProduct['wholesale_product_id'];
            }

            $this->assign('CategoriesArr', $CategoriesArr);
            $this->assign('page', $page->show());
            $this->assign('products', $products);
            $this->assign('categories', $categories);
            $this->assign('wholesale_products', $wholesale_products);
            $this->assign('product_total', $product_total);
            $this->assign('sullierIds', $sullierIds);
            $this->assign('type', $type);
        }
    }

    public function wholesale_market_product()
    {
        $this->display();
    }

    private function _wholesale_market_product_content()
    {
        $store = M('Store');
        $product = M('Product');
        $product_group = M('Product_group');
        $product_to_group = M('Product_to_group');
        $store_supplier = M('Store_supplier');
        $is = !empty($_POST['is']) ? intval($_POST['is']) : 1;
        $order_by_field = 'is_fx';
        $order_by_method = 'DESC';
        $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';

        //当前店铺信息
        $store_info = $store->getStore($this->store_session['store_id']);

        $seller = $store_supplier->getSeller(array ('seller_id' => $this->store_session['store_id'], 'type' => 1));
        if ($store_info['drp_level'] == 0)
        {
            $type = 'wholesale';
            $where['is_wholesale'] = 1; //设置分销的商品
        }
        else if ($store_info['drp_level'] > 0)
        {
            $type = 'fx';
            $where['is_fx'] = 1;
        }

        $where['status'] = 1;
        if (!empty($_POST['category_id']))
        {
            $where['category_id'] = intval(trim($_POST['category_id']));
        }
        if (!empty($_POST['category_fid']))
        {
            $where['category_fid'] = intval(trim($_POST['category_fid']));
        }
        if ($keyword)
        {
            $where['name'] = array ('like', '%' . $keyword . '%');
        }

        $product_total = $product->getSellingTotal($where);
        import('source.class.user_page');
        $page = new Page($product_total, 15);
        $tmp_products = $product->getSelling($where, $order_by_field, $order_by_method, $page->firstRow, $page->listRows);
        $products = array ();

        foreach ($tmp_products as $tmp_product)
        {
            $supplier = D('Store')->field('name,store_id')->where(array ('store_id' => $tmp_product['store_id']))->find();
            $tmp_product['supplier'] = $supplier['name'];
            $tmp_product['supplier_id'] = $supplier['store_id'];

            if (empty($this->store_session['drp_diy_store']))
            {
                $drp_level = $this->store_session['drp_level'];
                if ($drp_level > 3)
                {
                    $drp_level = 3;
                }
                if ($store_info['drp_level'] == 0)
                {
                    $tmp_product['wholesale_price'] = !empty($tmp_product['wholesale_price']) ? $tmp_product['wholesale_price'] : '0';
                    $tmp_product['sale_min_price'] = !empty($tmp_product['sale_min_price']) ? $tmp_product['sale_min_price'] : '0';
                    $tmp_product['sale_max_price'] = !empty($tmp_product['sale_max_price']) ? $tmp_product['sale_max_price'] : '0';
                }
                else
                {
                    $tmp_product['cost_price'] = !empty($tmp_product['cost_price']) ? $tmp_product['cost_price'] : '0';
                    $tmp_product['min_fx_price'] = !empty($tmp_product['min_fx_price']) ? $tmp_product['min_fx_price'] : '0';
                    $tmp_product['max_fx_price'] = !empty($tmp_product['max_fx_price']) ? $tmp_product['max_fx_price'] : '0';
                }
            }

            $store_info = D('Store')->where(array ('store_id' => $tmp_product['store_id']))->find();
            $tmp_product['store_category_name'] = $CategoriesArr[$store_info['sale_category_fid']]['name'];
            $products[] = $tmp_product;
        }
        //商品分类
        $category = M('Product_category');
        $categories = $category->getCategories(array ('cat_status' => 1), 'cat_path ASC');
        $CategoriesArr = array ();
        foreach ($categories as $v)
        {
            $CategoriesArr[$v['cat_id']] = $v;
        }

        $tmp_fx_products = $product->fxProducts($this->store_session['store_id']);
        $fx_products = array ();
        foreach ($tmp_fx_products as $tmp_fx_product)
        {
            $fx_products[] = $tmp_fx_product['source_product_id'];
        }

        $wholesale_products = array ();
        foreach ($tmp_fx_products as $tmp_fx_product)
        {
            $wholesale_products[] = $tmp_fx_product['wholesale_product_id'];
        }

        $this->assign('CategoriesArr', $CategoriesArr);
        $this->assign('page', $page->show());
        $this->assign('products', $products);
        $this->assign('categories', $categories);
        $this->assign('fx_products', $fx_products);
        $this->assign('wholesale_products', $wholesale_products);
        $this->assign('product_total', $product_total);
        $this->assign('type', $type);
    }

    //是否需要审核批发商
    public function is_required_to_audit()
    {
        $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : 0;
        $result = D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('is_required_to_audit' => $status))->save();
        if ($result)
        {
            $_SESSION['store']['is_required_to_audit'] = $status;
            echo TRUE;
        }
        else
        {
            echo FALSE;
        }
    }

    //是否需要保证金
    public function is_required_margin()
    {
        $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : 0;
        $result = D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('is_required_margin' => $status))->save();
        if ($result)
        {
            $_SESSION['store']['is_required_margin'] = $status;
            echo TRUE;
        }
        else
        {
            echo FALSE;
        }
    }

    public function update_store_bond()
    {
        $bond = isset($_POST['bond']) ? intval(trim($_POST['bond'])) : 0;

        //保证金是否已开启
        $store_info = D('Store')->where(array ('store_id' => $this->store_session['store_id']))->find();
        if (empty($store_info['is_required_margin']))
        {
            $is_required_margin = 1;
            $result = D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('bond' => $bond, 'is_required_margin' => $is_required_margin))->save();
        }
        else
        {
            $result = D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('bond' => $bond))->save();
        }

        if (empty($store_info['is_required_margin']))
        {
            if ($result)
            {
                $_SESSION['store']['bond'] = $bond;
                $_SESSION['store']['is_required_margin'] = $is_required_margin;
                echo TRUE;
            }
            else
            {
                echo FALSE;
            }
        }
        else
        {
            if ($result)
            {
                $_SESSION['store']['bond'] = $bond;
                echo TRUE;
            }
            else
            {
                echo FALSE;
            }
        }
    }

    public function update_margin_minimum()
    {
        $margin_minimum = isset($_POST['margin_minimum']) ? intval(trim($_POST['margin_minimum'])) : 0;

        //是否开启额度提醒
        $store_info = D('Store')->where(array ('store_id' => $this->store_session['store_id']))->find();

        if (empty($store_info['margin_amount']))
        {
            $margin_amount = 1;
            $result = D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('margin_minimum' => $margin_minimum, 'margin_amount' => $margin_amount))->save();
        }
        else
        {
            $result = D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('margin_minimum' => $margin_minimum))->save();
        }
        if (empty($store_info['margin_amount']))
        {
            if ($result)
            {
                $_SESSION['store']['margin_minimum'] = $margin_minimum;
                $_SESSION['store']['margin_amount'] = $margin_amount;
                echo TRUE;
            }
            else
            {
                echo FALSE;
            }
        }
        else
        {
            if ($result)
            {
                $_SESSION['store']['margin_minimum'] = $margin_minimum;
                echo TRUE;
            }
            else
            {
                echo FALSE;
            }
        }
    }

    public function margin_amount()
    {
        $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : 0;
        $result = D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('margin_amount' => $status))->save();
        if ($result)
        {
            $_SESSION['store']['margin_amount'] = $status;
            echo TRUE;
        }
        else
        {
            echo FALSE;
        }
    }

    /**
     * 是否开启排他批发
     */
    public function open_store_whole()
    {
        $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : 0;
        $result = D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('open_store_whole' => $status))->save();

        if ($result)
        {
            $_SESSION['store']['open_store_whole'] = $status;
            echo TRUE;
        }
        else
        {
            echo FALSE;
        }
    }

    //批发配置
    public function whole_setting()
    {
        $this->checkFx(false, true);

        $this->display();
    }

    private function whole_setting_content()
    {
        $this->assign('is_required_to_audit', $this->store_session['is_required_to_audit']);
        $this->assign('is_required_margin', $this->store_session['is_required_margin']);
        $this->assign('bond', $this->store_session['bond']);
        $this->assign('margin_amount', $this->store_session['margin_amount']);
        $this->assign('margin_minimum', $this->store_session['margin_minimum']);
        $this->assign('open_store_whole', $this->store_session['open_store_whole']);
    }

    //店铺认证资料详情
    public function whole_detail()
    {
        $this->display();
    }

    private function _whole_detail_content()
    {
        $store = M('Store');
        $store_id = $_POST['store_id'];
        //$store_info = D('Store')->where(array('store_id'=>$store_id))->find();
        //当前店铺信息
        $store_info = $store->getStore($store_id);

        //判断当前批发商是否已认证
        $is_authen = D('Supp_dis_relation')->where(array ('supplier_id' => $this->store_session['store_id'], 'distributor_id' => $store_id))->count('id');
        $certification_info = D('Certification')->where(array ('store_id' => $store_id,'supplier_id'=>$this->store_session['store_id']))->find();
//var_dump($store_id);
//var_dump($this->store_session['store_id']);
        if ($certification_info)
        {
            $this->assign('certification_info', unserialize($certification_info['certification_info']));
        }

        $this->assign('is_authen', $is_authen);
        $this->assign('supplier_id', $this->store_session['store_id']);
        $this->assign('store_info', $store_info);
    }

    public function audit_dealer()
    {
        $data['supplier_id'] = !empty($_POST['supplier_id']) ? $_POST['supplier_id'] : '';  //供货商
        $data['distributor_id'] = !empty($_POST['distributor_id']) ? $_POST['distributor_id'] : '';  //经销商
        $data['authen'] = !empty($_POST['authen']) ? $_POST['authen'] : '';
        $data['add_time'] = time();

        //供货商信息
        $supplier_info = D('Store')->where(array('store_id'=>$data['supplier_id']))->find();

        //经销商信息
        $seller_info = D('Store')->where(array('store_id'=>$data['distributor_id']))->find();
        $result = D('Supp_dis_relation')->data($data)->add();
        if ($result)
        {
            //短信/通知 提醒 => 供货商的经销商审核提醒通知
            import('source.class.ShopNotice');
            ShopNotice::AuditDealerSuccess($supplier_info,$seller_info);
            //$this->examine_notice($seller_info['openid'],$seller_info['phone'], $supplier_info['name']);
            echo TRUE;
        }
        else
        {
            echo FALSE;
        }
    }

    /**
     * 供货商审核通过通知
     * @param $seller_openid OPEN_ID
     * @param $seller_mobile 经销商手机
     * @param $supplier 供货商
     * @desc  经销商审核通过提醒
     */
    function examine_notice($seller_openid, $seller_mobile, $supplier)
    {
        //发送模板消息
        import('source.class.Factory');
        import('source.class.MessageFactory');

        $admin_url = option('config.site_url') . '/account.php';

        if (!empty($seller_openid)) {
            $params = array();
            $template_data = array(
                'wecha_id' => $seller_openid,
                'first'    => '经销商通过审核通知',
                //'keyword1' => $seller_balance,
                'keyword2' => $supplier['pre_balance'],
                'keyword3' => '不限',
                'keyword4' => '目前您在供货商【' . $supplier['name'] .' 】提交的审核资料已通过审核',
                'remark'   => '为避免失去批发资格,请您登陆' . $admin_url . '查看详情并完成后续操作'
            );
            $params['template'] = array('template_id' => 'OPENTM207814690', 'template_data' => $template_data);
            MessageFactory::method($params, array('TemplateMessage'));
        }

        if (!empty($seller_mobile)) {
            $params = array();
            $params['sms'] = array('mobile' => $seller_mobile,'store_id' => $supplier['store_id'], 'token'=>'test', 'content' => '您好，目前您在供货商【' . $supplier['name'] .' 】提交的审核资料已通过审核，为避免失去批发资格，请您登陆' . $admin_url . '查看详情并完成后续操作');
            MessageFactory::method($params, array('smsMessage'));
        }
    }

    public function recharge()
    {
        $this->display();
    }

    private function recharge_content()
    {
        $store_id = !empty($_POST['store_id']) ? $_POST['store_id'] : '';
        $id = !empty($_POST['id']) ? $_POST['id'] : '';
        //获取收款人信息
        $storeInfo = D('Store')->where(array ('store_id' => $store_id))->find();
        $marginInfo = D('Margin_account')->where(array ('store_id' => $store_id))->find();

        //查看打款人信息
        if (!empty($id)) {
            $bond_log_info = D('Margin_recharge_log')->where(array ('id' => $id))->find();
        }

        $this->assign('bond_log_info', $bond_log_info);
        $this->assign('storeInfo', $storeInfo);
        $this->assign('store_id', $store_id);
        $this->assign('marginInfo', $marginInfo);
    }

    public function update_recharge()
    {
        $id = !empty($_POST['id']) ? $_POST['id'] : '';
        $store_id = !empty($_POST['store_id']) ? $_POST['store_id'] : '';
        $data['bank_id'] = !empty($_POST['bank_id']) ? $_POST['bank_id'] : '';
        $data['opening_bank'] = !empty($_POST['opening_bank']) ? $_POST['opening_bank'] : '';
        $data['bank_card'] = !empty($_POST['bank_card']) ? $_POST['bank_card'] : '';
        $data['bank_card_user'] = !empty($_POST['bank_card_user']) ? $_POST['bank_card_user'] : '';
        $data['phone'] = !empty($_POST['phone']) ? $_POST['phone'] : '';
        $data['apply_recharge'] = !empty($_POST['apply_recharge']) ? $_POST['apply_recharge'] : '';
        $data['update_time'] = time();
        if (empty($id))
        {
            if (!D('Supp_dis_relation')->where(array ('supplier_id' => $store_id, 'distributor_id' => $this->store_session['store_id']))->find())
            {
                $data['authen'] = 1;
                $data['add_time'] = time();
                $data['supplier_id'] = $store_id;
                $data['distributor_id'] = $this->store_session['store_id'];
                $result = D('Supp_dis_relation')->data($data)->add();
            }
            else
            {
                $result = D('Supp_dis_relation')->where(array ('supplier_id' => $store_id, 'distributor_id' => $this->store_session['store_id']))->data($data)->save();
            }
            if ($result)
            {
                $log['supplier_id'] = $store_id;
                $log['bank_id'] = !empty($_POST['bank_id']) ? $_POST['bank_id'] : '';
                $log['opening_bank'] = !empty($_POST['opening_bank']) ? $_POST['opening_bank'] : '';
                $log['bank_card'] = !empty($_POST['bank_card']) ? $_POST['bank_card'] : '';
                $log['bank_card_user'] = !empty($_POST['bank_card_user']) ? $_POST['bank_card_user'] : '';
                $log['phone'] = !empty($_POST['phone']) ? $_POST['phone'] : '';
                $log['apply_recharge'] = !empty($_POST['apply_recharge']) ? $_POST['apply_recharge'] : '';
                $log['add_time'] = time();
                $log['distributor_id'] = $this->store_session['store_id'];
                $log_result = D('Margin_recharge_log')->data($log)->add();

				//短信/通知 提醒 => 经销商给供货商打款通知
				import('source.class.ShopNotice');
				$log_results = array_merge($log,array('id'=>$log_result));
				ShopNotice::UpdateRecharge($log_results);
                echo TRUE;
            }
            else
            {
                echo FALSE;
            }
        }
        else if (!empty($id))
        {
            $log['opening_bank'] = !empty($_POST['opening_bank']) ? $_POST['opening_bank'] : '';
            $log['bank_card'] = !empty($_POST['bank_card']) ? $_POST['bank_card'] : '';
            $log['bank_card_user'] = !empty($_POST['bank_card_user']) ? $_POST['bank_card_user'] : '';
            $log['phone'] = !empty($_POST['phone']) ? $_POST['phone'] : '';
            $log['apply_recharge'] = !empty($_POST['apply_recharge']) ? $_POST['apply_recharge'] : '';
            $log['add_time'] = time();
            $log_result = D('Margin_recharge_log')->where(array ('id' => $id))->data($log)->save();
            if ($log_result)
            {
                echo TRUE;
            }
            else
            {
                echo FALSE;
            }
        }
    }

    //保证金充值记录
    public function bond_log()
    {
        $this->checkFx(false, true);

        $this->display();
    }

    private function bond_log_content()
    {
        $margin_recharge_log = M('Margin_recharge_log');
        $store_id = !empty($_POST['store_id']) ? $_POST['store_id'] : '';
        $status = !empty($_POST['status']) ? $_POST['status'] : 1;

        $keyword = !empty($_POST['opening_bank']) ? $_POST['opening_bank'] : '';
        $where = array ();
        $where['supplier_id'] = $this->store_session['store_id'];
        $where['distributor_id'] = $store_id;
        $where['opening_bank'] = array ('like' => '%' . $keyword . '%');

        if ($status == 1)
        {
            $where['status'] = 1;
        }
        else if ($status == 2)
        {
            $where['status'] = 0;
        }

        $agencyBondCount = $margin_recharge_log->getAgencyBondLogCount($where);

        import('source.class.user_page');
        $page = new Page($agencyBondCount, 10);

        $agency_bond_log = $margin_recharge_log->getAgencyBondLog($where, $page->firstRow, $page->listRows);

        $bondlist = array ();
        foreach ($agency_bond_log as $bond)
        {
            // 批发商
            $whole_name = D('Store')->field('name')->where(array ('store_id' => $bond['distributor_id']))->find();
            $bondlist[] = array (
                'id' => $bond['id'],
                'whole_name' => $whole_name['name'],
                'opening_bank' => $bond['opening_bank'],
                'bank_card' => $bond['bank_card'],
                'bank_card_user' => $bond['bank_card_user'],
                'opening_bank' => $bond['opening_bank'],
                'phone' => $bond['phone'],
                'apply_recharge' => $bond['apply_recharge'],
                'add_time' => $bond['add_time'],
                'status' => $bond['status'],
            );
        }

        $this->assign('status', $status);
        $this->assign('page', $page->show());
        $this->assign('status', $status);
        $this->assign('bondlist', $bondlist);
    }

    //更新批发商账户余额
    public function update_bond()
    {
        $id = $_POST['id'];
        $status = 1;
        //充值信息

        $bond_information = D('Margin_recharge_log')->where(array ('id' => $id))->find();

		$bond_information = D('Margin_recharge_log')->where(array ('id' => $id))->find();
			

        //获取供货商余额
        $bond = D('Supp_dis_relation')->field('bond')->where(array ('supplier_id' => $bond_information['supplier_id'], 'distributor_id' => $bond_information['distributor_id']))->find();
        $data['bond'] = $bond_information['apply_recharge'] + $bond['bond'];
        $result = D('Supp_dis_relation')->where(array ('supplier_id' => $bond_information['supplier_id'], 'distributor_id' => $bond_information['distributor_id']))->data($data)->save();
        if ($result)
        {
            D('Margin_recharge_log')->where(array ('id' => $id))->data(array ('status' => $status))->save();
            echo TRUE;
        }
        else
        {
            echo FALSE;
        }
    }

    //我的保证金记录
    public function my_bond_log()
    {
        $this->checkFx(false, true);

        $this->display();
    }

    private function my_bond_log_content()
    {
        $margin_recharge_log = M('Margin_recharge_log');
        $supplier_id = !empty($_POST['store_id']) ? $_POST['store_id'] : '';
        $keyword = !empty($_POST['opening_bank']) ? $_POST['opening_bank'] : '';
        $where = array ();
        $where['supplier_id'] = $supplier_id;
        $where['distributor_id'] = $this->store_session['store_id'];
        $where['opening_bank'] = array ('like' => '%' . $keyword . '%');

        $bond_log_count = $margin_recharge_log->getBondLogCount($where);
        import('source.class.user_page');
        $page = new Page($bond_log_count, 10);
        $bond_log = $margin_recharge_log->getBondLog($where, $page->firstRow, $page->listRows);

        $my_bond_log = array ();
        foreach ($bond_log as $logs)
        {
            // 供货商
            $supplier_name = D('Store')->field('name')->where(array ('store_id' => $logs['supplier_id']))->find();
            $my_bond_log[] = array (
                'id' => $logs['id'],
                'whole_name' => $supplier_name['name'],
                'opening_bank' => $logs['opening_bank'],
                'bank_card' => $logs['bank_card'],
                'bank_card_user' => $logs['bank_card_user'],
                'opening_bank' => $logs['opening_bank'],
                'phone' => $logs['phone'],
                'apply_recharge' => $logs['apply_recharge'],
                'add_time' => $logs['add_time'],
                'status' => $logs['status'],
            );
        }
        $this->assign('supplier_id', $supplier_id);
        $this->assign('my_bond_log', $my_bond_log);
        $this->assign('page', $page->show());
    }

    public function add_agency()
    {
        $data['distributor_id'] = !empty($_POST['store_id']) ? $_POST['store_id'] : '';
        $data['supplier_id'] = $this->store_session['store_id'];
        $data['authen'] = 1;
        $data['add_time'] = time();
        /**
         *判断是否已成为排他批发商
         */
        $is_open_store_whole = false;
        $supplier_list = D('Supp_dis_relation')->field('supplier_id')->where(array('distributor_id'=>$data['distributor_id']))->select();
        if(!empty($supplier_list)) {
            foreach ($supplier_list as $supplier_id) {
                //var_dump($supplier_id['supplier_id']);
                $open_store_whole = D('Store')->field('open_store_whole')->where(array('store_id' => $supplier_id['supplier_id']))->find();
                //echo D('Stoer')->last_sql;
                if ($open_store_whole['open_store_whole']) {
                    $is_open_store_whole = true;
                }
            }
        }

        if($is_open_store_whole == false){
            $result = D('Supp_dis_relation')->data($data)->add();
            if ($result) {
                json_return(1,'添加经销商成功'); //添加经销商成功
            } else {
                json_return(0,'添加经销商失败'); //添加经销商失败
            }
        }else{
            json_return(2,'此店铺以成为排他批发商不能添加'); //不允许添加经销商
        }

    }

    //经销商订单导出
    public function wholesale_checkout_order() {

    	$store = M('Store');
    	$store_supplier = M('Store_supplier');
    	$order = M('Order');
    	$fx_order = M('Fx_order');
    	$order_product = M('Fx_order_product');
    	
    	$where = array ();
    	//$where['type'] = 5;
    	$where['s.status'] = array ('>', 0);
    	$where['s.store_id'] = $this->store_session['store_id'];
    	

    	$where1 = $where;
    	$levels_type = $_REQUEST['levels'];
    	$type = $_REQUEST['type'];
    	
    	if (!empty($_REQUEST['order_no']))
    	{
    		$where['ss.order_no'] = $_REQUEST['order_no'];
    	}
    	if (!empty($_REQUEST['fx_order_no']))
    	{
    		$where['ss.fx_order_no'] = $_REQUEST['fx_order_no'];
    	}
    	if (!empty($_REQUEST['delivery_user']))
    	{
    		$where['ss.delivery_user'] = $_REQUEST['delivery_user'];
    	}
    	if (!empty($_REQUEST['supplier_id']))
    	{
    		$where['s.supplier_id'] = $_REQUEST['supplier_id'];
    	}
    	if (!empty($_REQUEST['status']))
    	{
    		$where['s.status'] = $_REQUEST['status'];
    	}
    	if (!empty($_REQUEST['delivery_tel']))
    	{
    		$where['ss.delivery_tel'] = $_REQUEST['delivery_tel'];
    	}
    	if (!empty($_POST['start_time']) && !empty($_REQUEST['stop_time']))
    	{
    		$where['_string'] = "ss.add_time >= " . strtotime($_REQUEST['start_time']) . " AND ss.add_time <= " . strtotime($_POST['stop_time']);
    	}
    	else if (!empty($_REQUEST['start_time']))
    	{
    		$where['ss.add_time'] = array ('>=', strtotime($_REQUEST['start_time']));
    	}
    	else if (!empty($_REQUEST['stop_time']))
    	{
    		$where['ss.add_time'] = array ('<=', strtotime($_REQUEST['stop_time']));
    	}
    	$orderby = 'ss.order_id DESC';
    	
    	if($levels_type == 'all') {$where = $where1;}
    	$order_count = $order->getWholealeCount($where);
    	if ($type != 'do_checkout')
    	{
    		$return = array ('code' => '0', 'msg' => $order_count);
    		echo json_encode($return);
    		exit;
    	}    	
    	
    	//import('source.class.user_page');
    	//$page = new Page($order_count, 15);
    	$tmp_orders = $order->getWholeale($where, $orderby);
    	
    	$orders = array ();
    	foreach ($tmp_orders as $tmp_order)
    	{
    		$supplier = $store->getStore($tmp_order['supplier_id']); //供货商
    		$fx = $store->getStore($tmp_order['store_id']); //供货商
    	
    		$store_info[$tmp_order['store_id']] = $store->getStore($tmp_order['store_id']);
    		$supplier_name = $supplier['name'];
    		$fx_name = $fx['name'];
    		$products = $order_product->getFxProducts($tmp_order['fx_order_id']);
    		$orders[] = array (
    				'fx_order_id' => $tmp_order['fx_order_id'],
    				'fx_order_no' => $tmp_order['fx_order_no'],
    				'order_no' => $tmp_order['order_no'],
    				'total' => $tmp_order['cost_total'],
    				'supplier_id' => $tmp_order['supplier_id'],
    				'store_id' => $tmp_order['store_id'],
    				'drp_level' => $fx['drp_level'],
    				'supplier' => $supplier_name,
    				'fx' => $fx_name,
    				'products' => $products,
    				'add_time' => date('Y-m-d H:i:s', $tmp_order['add_time']),
    				'delivery_user' => $tmp_order['delivery_user'],
    				'delivery_tel' => $tmp_order['delivery_tel'],
    				'status' => $fx_order->status_text($tmp_order['status']),
    				'status_id' => $tmp_order['status']
    		);
    	}
    	$suppliers = $store_supplier->suppliers(array ('seller_id' => $this->store_session['store_id']));
    	
    	
    	
    	
    	/****/
    	if($type=='do_checkout') {
			
			//import('source.class.user_page');
			include 'source/class/execl.class.php';
			$execl = new execl();

			$filename = date("批发商导出_YmdHis", time()) . '.xls';
			header('Content-Type: application/vnd.ms-excel');
			header("Content-Disposition: attachment;filename=$filename");
			header('Cache-Type: charset=gb2312');
			echo "<style>table td{border:1px solid #ccc;}</style>";
			echo "<table>";
			//dump($user_arr);
			echo '	<tr>';
			echo ' 		<td style="vnd.ms-excel.numberformat:@" align="center" width="300"><b> 订单号 </b></td>';
			echo ' 		<td style="vnd.ms-excel.numberformat:@" align="center" width="300"><b> 买家订单号 </b></td>';
			echo ' 		<td align="center"><b> 订单来源  </b></td>';
			echo ' 		<td align="center" colspan="3" ><table><tr><td colspan="3" align="center" ><b>订单商品</b></td></tr><tr><td width="300" align="center"><b>商品名称</b></td><td align="center"><b>单价</b></td><td align="center"><b>数量</b></td></tr></table></td>';

			echo ' 		<td align="center"><b> 买家 </b></td>';
			echo ' 		<td align="center"><b> 下单时间 </b></td>';
			echo ' 		<td align="center"><b> 订单状态  </b></td>';
			echo ' 		<td align="center"><b> 成交额 </b></td>';
			echo '	</tr>';
			
			
			
			foreach ($orders as $k => $v)
			{
				//买家
				$maijia = " <p>". $v['delivery_user']."</p>";
                $maijia .= "<p>". $v['delivery_tel']."</p>";

				echo '	<tr>';
				echo ' 		<td  style="vnd.ms-excel.numberformat:@" align="center" width="300">' . $v['fx_order_no'] . '</td>';
				echo ' 		<td  style="vnd.ms-excel.numberformat:@" align="center" width="300">' . $v['order_no'] . '</td>';
				echo ' 		<td align="center">经销商：'. $v['fx'] .'</td>';
	
				echo '<td colspan="3"><table style="height:100%">';
				foreach($v['products'] as $key => $product) {		
					echo '<tr><td align="center">'.$product['name'].'</td><td align="center">￥' .$product['cost_price']. '</td><td align="center">'.$product['quantity'].'</td></tr>';	
				}
				echo '</table></td>';

				
				
				//订单状态
				echo ' 		<td align="center">' . $maijia . '</td>';
				echo ' 		<td align="center">' . $v['add_time'] . '</td>';
				echo ' 		<td align="center">'.$v['status']. '</td>';
				echo ' 		<td align="center">￥' . $v['total'] . '</td>';
				
				
				echo '	</tr>';
			}
			echo '</table>';exit;
						
			
			
		}
    	/****/
    	
    	
    	$status = $order->status();
    	$this->assign('orders', $orders);

    	$this->assign('suppliers', $suppliers);
    	$this->assign('status', $status);
    	$this->assign('store_info', $store_info);
    	
    }

	//分销商订单导出
	public function checkout_order()
	{

		$order = M('Order');
		$order_product = M('Order_product');
		$user = M('User');
		$where = array ();
		$where['store_id'] = $this->store_session['store_id'];
		$where['_string'] = 'type = 3 and user_order_id > 0';
		$where1 = $where;
		$levels_type = $_REQUEST['levels'];
		$type = $_REQUEST['type'];
		
		if (is_numeric($_REQUEST['order_no']))
		{
			$where['order_no'] = $_REQUEST['order_no'];
		}
		
		if (!empty($_REQUEST['delivery_user']))
		{
			$where['address_user'] = $_REQUEST['delivery_user'];
		}
		if (!empty($_REQUEST['delivery_tel']))
		{
			$where['address_tel'] = $_REQUEST['delivery_tel'];
		}
		
		$field = '';
		if (!empty($data['time_type']))
		{
			$field = $data['time_type'];
		}
		if (!empty($data['start_time']) && !empty($_REQUEST['stop_time']) && !empty($field))
		{
			$where['_string'] = "`" . $field . "` >= " . strtotime($_REQUEST['start_time']) . " AND `" . $field . "` <= " . strtotime($_REQUEST['stop_time']);
		}
		else if (!empty($_REQUEST['start_time']) && !empty($field))
		{
			$where[$field] = array ('>=', strtotime($data['start_time']));
		}
		else if (!empty($_REQUEST['stop_time']) && !empty($field))
		{
			$where[$field] = array ('<=', strtotime($_REQUEST['stop_time']));
		}
		//排序
		if (!empty($_REQUEST['orderbyfield']) && !empty($_REQUEST['orderbymethod']))
		{
			$orderby = "`{$_REQUEST['orderbyfield']}` " . $_REQUEST['orderbymethod'];
		}
		else
		{
			$orderby = '`order_id` DESC';
		}
		if($levels_type == 'all') {$where = $where1;}
		$order_total = $order->getOrderTotal($where);
		
		if ($type != 'do_checkout')
		{
			$return = array ('code' => '0', 'msg' => $order_total);
			echo json_encode($return);
			exit;
		}
		
		$tmp_orders = $order->getOrders($where, $orderby);
		$orders = array ();
		foreach ($tmp_orders as $tmp_order)
		{ //
		if (!empty($tmp_order['user_order_id']))
		{
			$products = $order_product->getProducts($tmp_order['user_order_id']);
			$order_sub_total = D('Order')->field('sub_total')->where(array ('order_id' => $tmp_order['user_order_id']))->find();
			$tmp_order['sub_total'] = number_format($order_sub_total['sub_total'], 2, '.', '');
		}
		else
		{
			$products = $order_product->getProducts($tmp_order['order_id']);
		}
		
		$tmp_order['products'] = $products;
		if (empty($tmp_order['uid']))
		{
			$tmp_order['is_fans'] = FALSE;
			$tmp_order['buyer'] = '';
		}
		else
		{
			$tmp_order['is_fans'] = TRUE;
			$user_info = $user->checkUser(array ('uid' => $tmp_order['uid']));
			$tmp_order['buyer'] = $user_info['nickname'];
		}
		
		// 是否有退货未完成的申请，有未完成的申请，暂时不给完成订单
		if ($tmp_order['status'] == 7)
		{
			$count = D('Return')->where("order_id = '" . $tmp_order['order_id'] . "' AND status IN (1, 3, 4)")->count('id');
			$tmp_order['returning_count'] = $count;
		}
		
		$is_supplier = FALSE;
		$is_packaged = FALSE;
		if (!empty($tmp_order['suppliers']))
		{ //订单供货商
		$suppliers = explode(',', $tmp_order['suppliers']);
		if (in_array($this->store_session['store_id'], $suppliers))
		{
			$is_supplier = TRUE;
		}
		}
		if (empty($tmp_order['suppliers']))
		{
			$is_supplier = TRUE;
		}
		
		$has_my_product = FALSE;
		foreach ($products as &$product)
		{
			$product['image'] = getAttachmentUrl($product['image']);
			if (empty($product['is_fx']))
			{
				$has_my_product = TRUE;
			}
		
			//自营商品
			if (empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id'])
			{
				$is_supplier = TRUE;
			}
		
			//商品来源
			if (empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id'])
			{ //本店商品
				$from = '本店商品';
			}
			else if (!empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id'] && !empty($product['wholesale_product_id']))
			{ //批发商品
				$from = '批发商品';
				$product['is_ws'] = 1;
			}
			else
			{ //分销商品
				$from = '分销商品';
			}
			$product['from'] = $from;
		
			//向后兼容利润计算
			$no_profit = FALSE;
			if ($product['profit'] == 0)
			{
				$fx_order = D('Fx_order')->field('fx_order_id')->where(array ('order_id' => $tmp_order['order_id']))->find();
				$fx_order_product = D('Fx_order_product')->field('cost_price')->where(array ('fx_order_id' => $fx_order['fx_order_id'], 'source_product_id' => $product['product_id']))->find();
				$product['cost_price'] = $fx_order_product['cost_price'];
				$product['profit'] = $product['pro_price'] - $product['cost_price'];
				if ($product['profit'] <= 0)
				{
					$product['profit'] = 0;
					$no_profit = TRUE;
				}
			}
		
			$product['cost_price'] = ($product['pro_price'] - $product['profit'] > 0) ? $product['pro_price'] - $product['profit'] : 0;
			if ($product['profit'] == 0 && empty($product['supplier_id']) && empty($no_profit))
			{
				$product['profit'] = $product['pro_price'];
				$product['cost_price'] = 0;
			}
		
			$product['profit'] = number_format($product['profit'], 2, '.', '');
			$product['cost_price'] = number_format($product['cost_price'], 2, '.', '');
		
			//退货商品
			$return_product = D('Return_product')->where(array ('order_id' => $tmp_order['order_id'], 'order_product_id' => $product['pigcms_id']))->find();
			if (!empty($return_product))
			{
				$product['return_quantity'] = $return_product['pro_num'];
			}
		}
		
		if (!empty($tmp_order['user_order_id']))
		{
			$order_info = D('Order')->field('store_id')->where(array ('order_id' => $tmp_order['user_order_id']))->find();
			$seller = D('Store')->field('name')->where(array ('store_id' => $order_info['store_id']))->find();
			$tmp_order['seller'] = $seller['name'];
		}
		else
		{
			$tmp_order['seller'] = '本店';
		}
		
		$un_package_selfsale_products = $order_product->getUnPackageProducts(array ('op.order_id' => $tmp_order['order_id'], 'p.store_id' => $this->store_session['store_id'], 'p.supplier_id' => 0));
		if (count($un_package_selfsale_products) == 0)
		{
			$is_packaged = TRUE;
		}
		
		$profit = M('Financial_record')->getTotal(array ('order_id' => $tmp_order['order_id']));
		$cost = M('Financial_record')->getTotal(array ('order_id' => $tmp_order['order_id'], 'income' => array ('<', 0)));
		$cost = abs($cost);
		if ($cost <= 0)
		{
			//$cost = $profit;
		}
		
		$tmp_order['products'] = $products;
		$tmp_order['has_my_product'] = $has_my_product;
		$tmp_order['is_supplier'] = $is_supplier;
		$tmp_order['is_packaged'] = $is_packaged;
		$tmp_order['profit'] = number_format($profit, 2, '.', '');
		$tmp_order['cost'] = number_format($cost, 2, '.', '');
		$tmp_order_id[] = $tmp_order['order_id'];
		$orders[] = $tmp_order;
		}

		if($type=='do_checkout') {
			
			//import('source.class.user_page');
			include 'source/class/execl.class.php';
			$execl = new execl();
			if ($level == 'all')
			{
				$level_cn = "全部";
			}
			else
			{
				$level_cn = $level . "级";
			}
			$filename = date($level_cn . "分销商导出_YmdHis", time()) . '.xls';
			header('Content-Type: application/vnd.ms-excel');
			header("Content-Disposition: attachment;filename=$filename");
			header('Cache-Type: charset=gb2312');
			echo "<style>table td{border:1px solid #ccc;}</style>";
			echo "<table>";
			//dump($user_arr);
			echo '	<tr>';
			echo ' 		<td style="vnd.ms-excel.numberformat:@" align="center" width="300"><b> 订单号 </b></td>';
			echo ' 		<td style="vnd.ms-excel.numberformat:@" align="center" width="300"><b> 外部订单号 </b></td>';
			echo ' 		<td align="center"><b> 订单来源  </b></td>';
			echo ' 		<td align="center" colspan="4" ><table><tr><td colspan="4" align="center" ><b>订单商品</b></td></tr><tr><td width="300" align="center"><b>商品名称</b></td><td align="center"><b>商品来源</b></td><td align="center"><b>给分销商的成本价</b></td><td align="center"><b>给分销商的零售价</b></td></tr></table></td>';
			echo ' 		<td align="center"><b> 售后 </b></td>';
			echo ' 		<td align="center"><b> 买家 </b></td>';
			echo ' 		<td align="center"><b> 下单时间 </b></td>';
			echo ' 		<td align="center"><b> 订单状态  </b></td>';
			echo ' 		<td align="center"><b> 运费 </b></td>';
			echo ' 		<td align="center"><b> 订单金额 </b></td>';
			echo '	</tr>';
			
			
			
			foreach ($orders as $k => $v)
			{
				//买家
				if (empty($v['is_fans'])) {	
					$maijia = "<p>非粉丝</p>";
				} else if (!empty($v['address_user'])) {
					$maijia = ' <p class="user-name">'. $v['address_user'] .'</p>';
				} else {
					$maijia = '<p>' .$order['buyer'] .'</p>';
				}
				//订单状态
				$order_status = M('Order')->status($v['status']);
				//售后
				if (empty($v['is_fans'])) { 
					$order_sh = "<p>非粉丝</p>";
				} else if (!empty($v['address_user'])) { 
					$order_sh = "<p class='user-name'>" .$v['address_user'] . "</p>";
					$order_sh .= $v['address_tel'];
				} else { 
					$order_sh = "<p>".$v['buyer']."</p>";
				}
								                                
				
				echo '	<tr>';
				echo ' 		<td  style="vnd.ms-excel.numberformat:@" align="center" width="300">' . $v['order_no'] . '</td>';
				echo ' 		<td  style="vnd.ms-excel.numberformat:@" align="center" width="300">' . $v['trade_no'] . '</td>';
				echo ' 		<td align="center">来自于<span style="color: red"> '.$v["drp_level"]. '</span>级分销商：'.$v["seller"].'</span></td>';
				

				
				echo '<td colspan="4"><table>';
				foreach($v['products'] as $key => $product) {		
					echo '<tr><td align="center">'.$product['name'].'</td><td align="center">' .$product['from']. '</td><td align="center">￥'.$product['cost_price'].'</td><td align="center">￥'.$product['pro_price'].'</td></tr>';	
				}
				echo '</table></td>';
				echo ' 		<td align="center">11' . $order_sh . '</td>';
				
				
				
				
				
				
				
				echo ' 		<td align="center">' . $maijia . '</td>';
				echo ' 		<td align="center">' . date("Y-m-d H:i:s",$v['add_time']) . '</td>';
				echo ' 		<td align="center">' . $order_status . '</td>';
				echo ' 		<td align="center">' . $v['postage'] . '</td>';
				echo ' 		<td align="center">' . $v['sub_total'] . '</td>';
				
				
				echo '	</tr>';
			}
			echo '</table>';
						
			
			
		}
		
		EXIT;
		
		/*************************************************************/
		if (count($tmp_order_id) > 0)
		{
			foreach ($tmp_order_id as $order_id)
			{
				$order_infos = $order->getOrder($this->store_session['store_id'], $order_id);
		
				$user_order_id = !empty($order_infos['user_order_id']) ? $order_infos['user_order_id'] : $order_id;
				$order_products = $order_product->getProducts($order_id);
		
				$where = array ();
				$where['_string'] = "(order_id = '" . $user_order_id . "' OR user_order_id = '" . $user_order_id . "')";
				if (!empty($this->store_session['drp_supplier_id']))
				{
					if (empty($order_info['user_order_id']))
					{
						$tmps_order = D('Order')->field('order_id')->where(array ('order_id' => $order_id, 'order_id' => array ('>', $order_id)))->order('order_id ASC')->find();
					}
					else
					{
						$tmps_order = D('Order')->field('order_id')->where(array ('user_order_id' => $user_order_id, 'order_id' => array ('>', $order_id)))->order('order_id ASC')->find();
					}
					$tmp_order_id = $tmp_orders['order_id'];
					$where['_string'] .= " AND order_id <= " . $tmp_order_id;
				}
				$commiss_orders = D('Order')->where($where)->order('order_id DESC')->select();
		
				$filter_postage = array ();
				$filter_order = array ();
				$filter_products = array ();
				foreach ($commiss_orders as $key => &$commiss_order)
				{
					$is_filter = FALSE;
					$store = D('Store')->field('store_id,name,drp_level,drp_supplier_id')->where(array ('store_id' => $commiss_order['store_id']))->find();
					$commiss_order['seller'] = $store['name'];
					$commiss_order['seller_drp_level'] = $store['drp_level'];
					$commiss_order['order_key_id'] = $order_id;
		
					if (empty($tmp_order['suppliers']) && empty($order_infos['suppliers']) && $commiss_order['store_id'] != $this->store_session['store_id'])
					{
						$filter_postage[$commiss_order['store_id']] = $commiss_order['postage'];
						$filter_order[$commiss_order['store_id']] = $commiss_order['order_id'];
						$is_filter = TRUE;
						unset($orders[$key]); //过滤非当前店铺的订单
					}
		
					$suppliers = explode(',', $commiss_order['suppliers']);
		
					if (!$is_filter && !empty($commiss_order['suppliers']))
					{
						foreach ($filter_postage as $supplier_id => $postage)
						{
							if (in_array($supplier_id, $suppliers))
							{
								$commiss_order['postage'] -= $postage;
								$commiss_order['total'] -= $postage;
								$commiss_order['profit'] -= $postage;
		
								$filter_order_id = $filter_order[$supplier_id];
								$tmp_filter_products = $order_product->getProducts($filter_order_id);
								foreach ($tmp_filter_products as $tmp_product)
								{
									$filter_products[] = $tmp_product['product_id'];
								}
							}
						}
					}
		
					$profit = D('Financial_record')->where(array ('order_id' => $commiss_order['order_id']))->sum('income');
					$commiss_order['profit'] = number_format($profit, 2, '.', '');
		
					$commiss_order['seller_store'] = option('config.wap_site_url') . '/home.php?id=' . $commiss_order['store_id'];
		
					//订单运费
					$supplier_postage = unserialize($commiss_order['fx_postage']);
					if (!empty($supplier_postage[$commiss_order['store_id']]))
					{
						$commiss_order['supplier_postage'] = $supplier_postage[$tmp_order['store_id']];
					}
					else if ($commiss_order['postage'] > 0 && empty($commiss_order['suppliers']))
					{
						$commiss_order['supplier_postage'] = $commiss_order['postage'];
					}
					else
					{
						$commiss_order['supplier_postage'] = 0;
					}
					$commiss_order['supplier_postage'] = number_format($commiss_order['supplier_postage'], 2, '.', '');
		
					$products = $order_product->getProducts($commiss_order['order_id']);
					$comment_count = 0;
					$product_count = 0;
					foreach ($products as $key2 => &$product)
					{
						//过滤商品.
						if (in_array($product['original_product_id'], $filter_products) || ($product['store_id'] != $this->store_session['store_id']) && empty($product['supplier_id']) && empty($product['is_wholesale']) && !in_array($product['store_id'], $suppliers))
						{
							$product['profit'] = ($product['profit'] > 0) ? $product['profit'] : $product['pro_price'];
							$commiss_order['sub_total'] -= ($product['pro_price'] * $product['pro_num']);
							$commiss_order['total'] -= ($product['pro_price'] * $product['pro_num']);
							$commiss_order['profit'] -= ($product['profit'] * $product['pro_num']);
							unset($products[$key2]);
						}
						else
						{
							if (!empty($product['comment']))
							{
								$comment_count++;
							}
							$product_count++;
		
							//商品来源
							if (empty($product['supplier_id']) && $product['store_id'] == $commiss_order['store_id'])
							{ //本店商品
								$from = '自营商品';
							}
							else if (!empty($product['supplier_id']) && $product['store_id'] == $commiss_order['store_id'] && !empty($product['wholesale_product_id']))
							{ //批发商品
								$from = '批发商品';
							}
							else
							{ //分销商品
								$from = '分销商品';
							}
							$product['from'] = $from;
		
							$product['cost_price'] = ($product['pro_price'] - $product['profit'] > 0) ? $product['pro_price'] - $product['profit'] : 0;
							if ($product['profit'] == 0 && empty($product['supplier_id']) && $commiss_order['store_id'] == $product['store_id'])
							{
								$product['profit'] = $product['pro_price'];
								$product['cost_price'] = 0;
							}
							if ($product['cost_price'] == 0 && $from != '自营商品')
							{
								$product['cost_price'] = $product['pro_price'];
							}
							$product['cost_price'] = number_format($product['cost_price'], 2, '.', '');
		
							if (!empty($product['wholesale_product_id']))
							{
								$commiss_order['is_wholesale'] = TRUE;
							}
						}
						//退货商品
						$return_product = D('Return_product')->where(array ('order_id' => $commiss_order['order_id'], 'order_product_id' => $product['pigcms_id']))->find();
						if (!empty($return_product))
						{
							$product['return_quantity'] = $return_product['pro_num'];
						}
					}
					$commiss_order['products'] = $products;
					$commiss_order['rows'] = $comment_count + $product_count;
					$commiss_order['comment_count'] = $comment_count;
					if (($commiss_order['store_id'] == $this->store_session['store_id']) || empty($commiss_order['suppliers']))
					{
						$commiss_order['postage'] = number_format($commiss_order['postage'], 2, '.', '');
					}
					else
					{
						$commiss_order['postage'] = number_format($postage, 2, '.', '');
					}
				}
		
				//收货地址
				$order_info['address'] = unserialize($order_infos['address']);
		
				// 订单来源
				if (empty($order_infos['user_order_id']))
				{
					$order_infos['from'] = '本店';
				}
				else
				{
					$tmp_order_info = D('Order')->field('uid,store_id,payment_method')->where(array ('order_id' => $order_info['user_order_id']))->find();
					$seller = D('Store')->field('name')->where(array ('store_id' => $tmp_order_info['store_id']))->find();
					$order_infos['from'] = $seller['name'];
					$order_infos['payment_method'] = $tmp_order_info['payment_method'];
					$order_infos['uid'] = $tmp_order_info['uid'];
				}
				$commission_orders[$order_id][] = $commiss_orders;
			}
		}
		//订单状态
		$order_status = $order->status();
		
		//订单状态别名
		$ws_alias_status = $order->ws_alias_status();
		
		//支付方式
		$payment_method = $order->getPaymentMethod();
		
		$this->assign('commission_orders', $commission_orders);
		$this->assign('order_status', $order_status);
		$this->assign('ws_alias_status', $ws_alias_status);
		$this->assign('status', $data['status']);
		$this->assign('payment_method', $payment_method);
		$this->assign('orders', $orders);
		$this->assign('page', $page->show());
		
		
		
	}


    //我的订单（批发）
    public function my_order()
    {
        $this->checkFx(false, true);

        $order_id = !empty($_GET['id']) ? intval(trim($_GET['id'])) : 0;
        $this->assign('order_id', $order_id);

        $this->display();
    }

    //我的订单（批发）
    public function _my_order_content()
    {
        $store_id = $this->store_session['store_id'];
        $order_id = !empty($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
        $status = !empty($_POST['status']) ? intval(trim($_POST['status'])) : 1;
        $order_no = trim($_POST['order_no']);
        $supplier_id = !empty($_POST['supplier_id']) ? intval(trim($_POST['supplier_id'])) : 0;
        $start_time = !empty($_POST['start_time']) ? trim($_POST['start_time']) : 0;
        $stop_time = !empty($_POST['stop_time']) ? trim($_POST['stop_time']) : 0;

        $user_order_id = 0;
        $my_order = array();
        if (!empty($order_id)) {
            $my_order = D('Order')->field('order_id,user_order_id')->where(array('order_id' => $order_id))->find();
            $user_order_id = !empty($my_order['user_order_id']) ? $my_order['user_order_id'] : $my_order['order_id'];
            $my_order_suppliers = M('Order')->getSuppliers($order_id);
        }

        $sql = "SELECT COUNT(o.order_id) AS order_count FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "fx_order fxo WHERE o.fx_order_id = fxo.fx_order_id AND fxo.store_id = '" . $store_id . "' AND o.status = '" . $status . "'";
        $sql2 = "SELECT *,o.paid_time AS paid_time,o.order_no,o.store_id AS supplier_id,fxo.store_id AS seller_id,o.total AS total,o.add_time AS add_time,o.status AS status,o.postage AS postage FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "fx_order fxo WHERE o.fx_order_id = fxo.fx_order_id AND fxo.store_id = '" . $store_id . "' AND o.status = '" . $status . "'";
        if (!empty($user_order_id)) {
            $sql .= " AND o.user_order_id = '" . $user_order_id . "'";
            $sql2 .= " AND o.user_order_id = '" . $user_order_id . "'";
        }
        if (!empty($order_no)) {
            $sql .= " AND o.order_no = '" . $order_no . "'";
            $sql2 .= " AND o.order_no = '" . $order_no . "'";
        }
        if (!empty($supplier_id)) {
            $sql .= " AND fxo.supplier_id = '" . $supplier_id . "'";
            $sql2 .= " AND fxo.supplier_id = '" . $supplier_id . "'";
        }
        if (!empty($start_time) && !empty($stop_time)) {
            $sql .= " AND o.add_time >= " . strtotime($start_time) . " AND o.add_time <= " . strtotime($stop_time);
            $sql2 .= " AND o.add_time >= " . strtotime($start_time) . " AND o.add_time <= " . strtotime($stop_time);
        } else if (!empty($start_time)) {
            $sql .= " AND o.add_time >= " . strtotime($start_time);
        } else if (!empty($stop_time)) {
            $sql .= " AND o.add_time <= " . strtotime($stop_time);
            $sql2 .= " AND o.add_time <= " . strtotime($stop_time);
        }
        $order_count = D('Order')->query($sql);
        $order_count = !empty($order_count[0]['order_count']) ? $order_count[0]['order_count'] : 0;

        import('source.class.user_page');
        $page = new Page($order_count, 12);
        $sql2 .= " ORDER BY o.order_id DESC LIMIT " . $page->firstRow . "," . $page->listRows;

        $orders = D('Order')->query($sql2);

        if (!empty($orders)) {
            foreach ($orders as &$order) {
                //供货商
                $supplier = D('Store')->field('name,wxpay')->where(array('store_id' => $order['supplier_id']))->find();
                $order['supplier'] = $supplier['name'];
                //供货商能否收款
                $order['wxpay'] = $supplier['wxpay'];

                //分销商
                $tmp_order = D('Order')->field('store_id,payment_method')->where(array ('order_id' => $order['user_order_id']))->find();
                $seller = D('Store')->field('store_id,name')->where(array ('store_id' => $tmp_order['store_id']))->find();
                $order['seller'] = $seller['name'];
                $order['buyer_payment_method'] = $tmp_order['payment_method'];

                $tmp_products = M('Order_product')->getProducts($order['order_id']);
                $products = array();
                if (!empty($tmp_products)) {
                    foreach ($tmp_products as $key => $product) {
                        if (!empty($product['wholesale_product_id']) && $product['supplier_id'] == $order['supplier_id']) {
                            $products[] = $product;
                        }
                    }
                }

                $order['products'] = $products;
                $order['add_time'] = date('Y-m-d:H:i:s', $order['add_time']);
                $order['payer'] = $this->store_session['store_id'];

                //经销商订单
                $where = array();
                $where['store_id'] = $this->store_session['store_id'];
                $where['_string']  = "order_id = '" . $order['user_order_id'] . "' OR user_order_id = '" . $order['user_order_id'] . "'";
                $tmp_order = D('Order')->field('order_id')->where($where)->find();
                $order['my_order_id'] = $tmp_order['order_id'];
                $weixin_bind = D('Weixin_bind')->field('wxpay_key')->where(array ('store_id' => $order['supplier_id']))->find();
                //是否店铺收款
                if (option('config.store_pay_weixin_open') && !empty($weixin_bind)) {
                    $salt = $weixin_bind['wxpay_key'];
                } else {
                    $salt = option('config.pay_weixin_key');
                }
                $order['order_no'] = option('config.orderid_prefix') . $order['order_no'];
                $sha1_data = array (
                    'order_no' => $order['order_no'],
                    'sid' => $order['supplier_id'],
                    'payer' => $this->store_session['store_id'],
                    'oid' => $tmp_order['order_id'],
                    'salt' => $salt
                );
                ksort($sha1_data);
                $paykey = sha1(http_build_query($sha1_data));
                $order['paykey'] = $paykey;
            }
        }

        //订单状态
        $order_status = M('Order')->status();

        //订单状态别名
        $ws_alias_status = M('Order')->ws_alias_status();

        //支付方式
        $payment_method = M('Order')->getPaymentMethod();

        //我的供货商
        if (!empty($my_order_suppliers)) {
            $suppliers = $my_order_suppliers;
            if (count($suppliers) == 1) {
                $supplier_id = $suppliers[0]['store_id'];
            }
        } else {
            $suppliers = M('Store')->getMySupplierList(array(), 0, 0, $this->store_session['store_id']);
        }

        $this->assign('payment_method', $payment_method);
        $this->assign('order_status', $order_status);
        $this->assign('ws_alias_status', $ws_alias_status);
        $this->assign('suppliers', $suppliers);
        $this->assign('supplier_id', $supplier_id);
        $this->assign('orders', $orders);
        $this->assign('status', $status);
        $this->assign('page', $page->show());
    }

    public function bond_record()
    {
        $this->checkFx(false, true);

        $this->display();
    }

    public function bond_record_content()
    {
        $bond_record = M('Bond_record');
        $product = M('Product');
        $wholesale_id = $this->store_session['store_id'];
        $supplier_id = !empty($_POST['store_id']) ? $_POST['store_id'] : '';

        $where = array ();
        if (!empty($_POST['order_no']))
        {
            $where['order_no'] = $_POST['order_no'];
        }
        $bond_record_count = $bond_record->getBondRecordCount($where, $supplier_id, $wholesale_id);

        import('source.class.user_page');
        $page = new Page($bond_record_count, 10);
        $bond_record = $bond_record->getBondRecord($where, $supplier_id, $wholesale_id, $page->firstRow, $page->listRows);

        $bond_records = array ();
        foreach ($bond_record as $bonds)
        {
            //供货商
            $wholesale = D('Store')->field('name')->where(array ('store_id' => $bonds['supplier_id']))->find();
            $bond_records[] = array (
                'store_name' => $wholesale['name'],
                'order_no' => $bonds['order_no'],
                'deduct_bond' => $bonds['deduct_bond'],
                'residue_bond' => $bonds['residue_bond'],
                'add_time' => $bonds['add_time'],
            );
        }

        $this->assign('bond_records', $bond_records);
        $this->assign('page', $page->show());
    }

    //分销商信息
    public function fx_store_info()
    {
        $this->display();
    }

    //分销商具体信息
    private function _fx_store_info_content($data)
    {
        $store = M('Store');
        //当前店铺信息
        $store_info = $store->getStore($data['store_id']);
        $sale_cate = D('Sale_category')->where(array ('cat_id' => $store_info['sale_category_id']))->field('name')->find();
        $f_sale_cate = D('Sale_category')->where(array ('cat_id' => $store_info['sale_category_fid']))->field('name')->find();
        $bank_name = D('Bank')->where(array ('id' => $store_info['bank_id']))->field('name')->find();
        $this->assign('store_info', $store_info);
        $this->assign('sale_cate_name', $sale_cate['name'] . '-' . $f_sale_cate['name']);
        $this->assign('bank_name', $bank_name);

        $order = M('Order');
        $order_product = M('Order_product');
        $user = M('User');
        $where['store_id'] = $store_info['store_id'];

        if ($data['status'])
        {
            $where['status'] = intval($data['status']);
        }
        else
        { //所有订单（不包含临时订单）
            $where['status'] = array ('>', 0);
        }
        if ($data['order_no'])
        {
            $where['order_no'] = $data['order_no'];
        }

        if ($data['trade_no'])
        {
            $where['trade_no'] = $data['trade_no'];
        }
        if (is_numeric($data['type']))
        {
            $where['type'] = $data['type'];
        }
        if (!empty($data['user']))
        {
            $where['address_user'] = $data['user'];
        }
        if (!empty($data['tel']))
        {
            $where['address_tel'] = $data['tel'];
        }
        if (!empty($data['payment_method']))
        {
            $where['payment_method'] = $data['payment_method'];
        }
        if (!empty($data['shipping_method']))
        {
            $where['shipping_method'] = $data['shipping_method'];
        }

        $field = '';
        if (!empty($data['time_type']))
        {
            $field = $data['time_type'];
        }

        if (!empty($data['start_time']) && !empty($data['stop_time']) && !empty($field))
        {
            $where['_string'] = "`" . $field . "` >= " . strtotime($data['start_time']) . " AND `" . $field . "` <= " . strtotime($data['stop_time']);
        }
        else if (!empty($data['start_time']) && !empty($field))
        {
            $where[$field] = array ('>=', strtotime($data['start_time']));
        }
        else if (!empty($data['stop_time']) && !empty($field))
        {
            $where[$field] = array ('<=', strtotime($data['stop_time']));
        }
        //排序
        if (!empty($data['orderbyfield']) && !empty($data['orderbymethod']))
        {
            $orderby = "`{$data['orderbyfield']}` " . $data['orderbymethod'];
        }
        else
        {
            $orderby = '`order_id` DESC';
        }

        $order_total = $order->getOrderTotal($where);
        import('source.class.user_page');
        $page = new Page($order_total, 10);
        $tmp_orders = $order->getOrders($where, $orderby, $page->firstRow, $page->listRows);
        $orders = array ();
        foreach ($tmp_orders as $tmp_order)
        {
            $products = $order_product->getProducts($tmp_order['order_id']);
            $tmp_order['products'] = $products;
            if (empty($tmp_order['uid']))
            {
                $tmp_order['is_fans'] = FALSE;
                $tmp_order['buyer'] = '';
            }
            else
            {
                //$tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
                $tmp_order['is_fans'] = TRUE;
                $user_info = $user->checkUser(array ('uid' => $tmp_order['uid']));
                $tmp_order['buyer'] = $user_info['nickname'];
            }

            // 是否有退货未完成的申请，有未完成的申请，暂时不给完成订单
            if ($tmp_order['status'] == 7)
            {
                $count = D('Return')->where("order_id = '" . $tmp_order['order_id'] . "' AND status IN (1, 3, 4)")->count('id');
                $tmp_order['returning_count'] = $count;
            }

            $is_supplier = FALSE;
            $is_packaged = FALSE;
            if (!empty($tmp_order['suppliers']))
            { //订单供货商
                $suppliers = explode(',', $tmp_order['suppliers']);
                if (in_array($store_info['store_id'], $suppliers))
                {
                    $is_supplier = TRUE;
                }
            }
            if (empty($tmp_order['suppliers']))
            {
                $is_supplier = TRUE;
            }

            $has_my_product = FALSE;
            foreach ($products as &$product)
            {
                $product['image'] = getAttachmentUrl($product['image']);
                if (empty($product['is_fx']))
                {
                    $has_my_product = TRUE;
                }

                //自营商品
                if (!empty($product['supplier_id']) && $product['store_id'] == $store_info['store_id'])
                {
                    $is_supplier = TRUE;
                }

                //商品来源
                if (empty($product['supplier_id']) && $product['store_id'] == $store_info['store_id'])
                { //本店商品
                    $from = '本店商品';
                }
                else if (!empty($product['supplier_id']) && $product['store_id'] == $store_info['store_id'] && !empty($product['wholesale_product_id']))
                { //批发商品
                    $from = '批发商品';
                }
                else
                { //分销商品
                    $from = '分销商品';
                }
                $product['from'] = $from;

                //向后兼容利润计算
                $no_profit = FALSE;
                if ($product['profit'] == 0)
                {
                    $fx_order = D('Fx_order')->field('fx_order_id')->where(array ('order_id' => $tmp_order['order_id']))->find();
                    $fx_order_product = D('Fx_order_product')->field('cost_price')->where(array ('fx_order_id' => $fx_order['fx_order_id'], 'source_product_id' => $product['product_id']))->find();
                    $product['cost_price'] = $fx_order_product['cost_price'];
                    $product['profit'] = $product['pro_price'] - $product['cost_price'];
                    if ($product['profit'] <= 0)
                    {
                        $product['profit'] = 0;
                        $no_profit = TRUE;
                    }
                }

                $product['cost_price'] = ($product['pro_price'] - $product['profit'] > 0) ? $product['pro_price'] - $product['profit'] : 0;
                if ($product['profit'] == 0 && empty($product['supplier_id']) && empty($no_profit))
                {
                    $product['profit'] = $product['pro_price'];
                    $product['cost_price'] = 0;
                }

                $product['profit'] = number_format($product['profit'], 2, '.', '');
                $product['cost_price'] = number_format($product['cost_price'], 2, '.', '');
            }

            if (!empty($tmp_order['user_order_id']))
            {
                $order_info = D('Order')->field('store_id')->where(array ('order_id' => $tmp_order['user_order_id']))->find();
                $seller = D('Store')->field('name')->where(array ('store_id' => $order_info['store_id']))->find();
                $tmp_order['seller'] = $seller['name'];
            }
            else
            {
                $tmp_order['seller'] = '本店';
            }

            $un_package_selfsale_products = $order_product->getUnPackageProducts(array ('op.order_id' => $tmp_order['order_id'], 'p.store_id' => $store_info['store_id'], 'p.supplier_id' => 0));
            if (count($un_package_selfsale_products) == 0)
            {
                $is_packaged = TRUE;
            }

            $profit = M('Financial_record')->getTotal(array ('order_id' => $tmp_order['order_id']));
            $cost = M('Financial_record')->getTotal(array ('order_id' => $tmp_order['order_id'], 'income' => array ('<', 0)));
            $cost = abs($cost);
            if ($cost <= 0)
            {
                //$cost = $profit;
            }

            $tmp_order['products'] = $products;
            $tmp_order['has_my_product'] = $has_my_product;
            $tmp_order['is_supplier'] = $is_supplier;
            $tmp_order['is_packaged'] = $is_packaged;
            $tmp_order['profit'] = number_format($profit, 2, '.', '');
            $tmp_order['cost'] = number_format($cost, 2, '.', '');
            $orders[] = $tmp_order;
        }

        //订单状态
        $order_status = $order->status();

        //支付方式
        $payment_method = $order->getPaymentMethod();

        $this->assign('order_status', $order_status);
        $this->assign('status', $data['status']);
        $this->assign('payment_method', $payment_method);
        $this->assign('orders', $orders);
        $this->assign('page', $page->show());
        //未对账分销商
        if (empty($store_info['drp_supplier_id']))
        {
            $sql = "SELECT o.store_id AS sellers FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = ss.seller_id AND ss.type = 1 AND o.status = 4 AND o.is_check = 1 AND FIND_IN_SET(" . $supplier_id . ", ss.supply_chain) GROUP BY o.store_id";
            $sellers = D('Order')->query($sql);
            $seller_count = 0;
            if (!empty($sellers))
            {
                foreach ($sellers as $seller)
                {
                    $seller_count += 1;
                }
            }

            //未对账金额
            $sql = "SELECT SUM(income) AS income FROM " . option('system.DB_PREFIX') . "financial_record WHERE order_id IN (SELECT order_id FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = ss.seller_id AND ss.type = 1 AND o.status = 4 AND o.is_check = 1 AND FIND_IN_SET(" . $supplier_id . ", ss.supply_chain)) AND status IN (1,3)";
            $incomes = D('Financial_record')->query($sql);
            $uncheck_amount = 0;
            if (!empty($incomes[0]['income']))
            {
                $uncheck_amount = $incomes[0]['income'];
            }
            $uncheck_amount = number_format($uncheck_amount, 2, '.', '');

            //已对账金额
            $sql = "SELECT SUM(income) AS income FROM " . option('system.DB_PREFIX') . "financial_record WHERE order_id IN (SELECT order_id FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = ss.seller_id AND ss.type = 1 AND o.status = 4 AND o.is_check = 2 AND FIND_IN_SET(" . $supplier_id . ", ss.supply_chain)) AND status IN (1,3)";
            $incomes = D('Financial_record')->query($sql);
            $check_amount = 0;
            if (!empty($incomes[0]['income']))
            {
                $check_amount = $incomes[0]['income'];
            }
            $check_amount = number_format($check_amount, 2, '.', '');

            //未对账订单
            $sql = "SELECT COUNT(o.order_id) AS orders FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = ss.seller_id AND ss.type = 1 AND o.status = 4 AND o.is_check = 1 AND FIND_IN_SET(" . $supplier_id . ", ss.supply_chain)";
            $orders = D('Order')->query($sql);
            $order_count = 0;
            if (!empty($orders[0]['orders']))
            {
                $order_count = $orders[0]['orders'];
            }

            //销售额
            $sql = "SELECT SUM(o.total) AS sales FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "store_supplier ss WHERE o.store_id = ss.seller_id AND ss.type = 1 AND o.status = 4 AND FIND_IN_SET(" . $supplier_id . ", ss.supply_chain)";
            $sales = D('Order')->query($sql);
            $seller_sales = 0;
            if (!empty($sales[0]['sales']))
            {
                $seller_sales = $sales[0]['sales'];
            }
            $seller_sales = number_format($seller_sales, 2, '.', '');
        }
        else
        {
            //未对账金额
            $where = array ();
            $where['_string'] = "status IN (1,3) AND order_id IN (SELECT order_id FROM " . option('system.DB_PREFIX') . "order WHERE status = 4 AND is_check = 1 AND store_id = '" . $store_info['store_id'] . "')";
            $uncheck_amount = D('Financial_record')->where($where)->sum('income');
            $uncheck_amount = number_format($uncheck_amount, 2, '.', '');

            //已对账金额
            $where = array ();
            $where['_string'] = "status IN (1,3) AND order_id IN (SELECT order_id FROM " . option('system.DB_PREFIX') . "order WHERE status = 4 AND is_check = 2 AND store_id = '" . $store_info['store_id'] . "')";
            $check_amount = D('Financial_record')->where($where)->sum('income');
            $check_amount = number_format($check_amount, 2, '.', '');

            //未对账订单
            $where = array ();
            $where['status'] = 4;
            $where['is_check'] = 1;
            $where['store_id'] = $store_info['store_id'];
            $order_count = D('Order')->where($where)->count('store_id');

            //销售额
            $where = array ();
            $where['status'] = 4;
            $where['is_fx'] = 1;
            $where['store_id'] = $store_info['store_id'];
            $seller_sales = D('Order')->where($where)->sum('total');
            $seller_sales = number_format($seller_sales, 2, '.', '');
        }

        $this->assign('uncheck_amount', $uncheck_amount);
        $this->assign('check_amount', $check_amount);
        $this->assign('order_count', $order_count);
        $this->assign('seller_sales', $seller_sales);
    }

    public function chk_bill_info()
    {
        $where['order_id'] = $_POST['order_id'];
        $data['is_check'] = 2;
        $result = D('Order')->where($where)->data($data)->save();
        if ($result)
        {
            echo TRUE;
        }
        else
        {
            echo FALSE;
        }
    }

    /* 我的经销商 添加白名单请求数据 */
    public function post_agency()
    {
        if(IS_POST)
        {
            $store_supplier = M('Store_supplier');
            $store_relation = M('Supp_dis_relation');
            $store_certification = M('Certification');
            $store = M('Store');

            $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
            $supplierId = $this->store_session['store_id'];    //当前供货商id
            $where = array ();
            $store_id = $this->store_session['store_id'];

            $authen_count = $store_relation->getAuthenCount($where, $store_id);

            import('source.class.user_page');
            $page = new Page($authen_count, 15);

            $authenList = $store_relation->getAuthen($where, $store_id, $page->firstRow, $page->listRows);

            $suppliers = array ();
            foreach ($authenList as $authens)
            {
                $suppliers[] = array (
                    'store_id' => $authens['store_id'],
                    'name' => $authens['name'],
                );
            }
            json_return( 0,$suppliers);
        }
    }

    public function get_whitelist()
    {
        if(IS_POST)
        {
            $store_supplier = M('Store_supplier');
            $store_relation = M('Supp_dis_relation');
            $store_certification = M('Certification');
            $store = M('Store');

            $product_id = !empty($_POST['product_id']) ? $_POST['product_id'] : '';
            $supplierId = $this->store_session['store_id'];
            $whitelists = D('Product_whitelist')->field('seller_id')->where(array('product_id'=>$product_id,'supplier_id'=>$supplierId))->select();

            $seller_id = array();
            foreach($whitelists as $store_id)
            {
                $seller_id[] = $store_id['seller_id'];
            }

            $store_ids = implode(',', $seller_id);
            $sql = "select name, store_id from " . option('system.DB_PREFIX') . "store where store_id in (".$store_ids.")";
            $whitelist = D('Store')->query($sql);
            json_return( 0,$whitelist);
        }
    }

    function product_whitelist()
    {
        if(IS_POST){

            $product_whitelist = M('Product_whitelist');

            $seller_ids = !empty($_POST['seller_id']) ? $_POST['seller_id'] : array();
            $product_id = !empty($_POST['product_id']) ? intval(trim($_POST['product_id'])) : 0;

            $delresult = D('Product_whitelist')->where(array('product_id'=>$product_id,'supplier_id'=>$this->store_session['store_id']))->delete();
            $result = array();
            foreach($seller_ids as $seller_id) {
                $seller_data = array (
                    'product_id' => $product_id,
                    'supplier_id' => $this->store_session['store_id'],
                    'add_time' => time(),
                    'seller_id' => $seller_id['seller_id'],
                );

                $result[] = D('Product_whitelist')->data($seller_data)->add();
            }

            if(!empty($result)){
                json_return(0, '保存成功');
            }

        }
    }

    /**
     * 取消白名单
     * @return bool
     */
    public function detach_whitelist(){
        $product_id = !empty($_POST['product_id']) ? $_POST['product_id'] : '';

        if(empty($product_id)){
            return false;
        }

        $delete_id = D('Product_whitelist')->where(array('product_id'=>$product_id))->delete();

        if($delete_id){
            json_return(0,'取消成功');
        }
    }

    //经销商店铺信息
    public function ws_store_info()
    {
        $this->checkFx(false, true);

        //经销商id
        $store_id = $_GET['store_id'];
        //供货商id
        $supplier_id = $this->store_session['store_id'];
        if (!D('Supp_dis_relation')->where(array('distributor_id' => $store_id, 'supplier_id' => $supplier_id))->count('id')) {
            if (IS_POST) {
                json_return(1001, '访问的店铺不是您的经销商');
            } else {
                pigcms_tips('访问的店铺不是您的经销商');
            }
        }
        if (IS_POST && $_POST['update'] == 'whitelist') {
            $id = intval(trim($_POST['id']));
            if (D('Product_whitelist')->where(array('pigcms_id' => $id, 'seller_id' => $store_id, 'supplier_id' => $supplier_id))->delete()) {
                json_return(0, '经销商移除商品白名单成功');
            } else {
                json_return(1002, '经销商移除商品白名单失败');
            }
        }
        $store_info = D('Store')->field('name,logo,linkman,tel,intro,qq')->where(array('store_id' => $store_id))->find();
        $store_info['logo'] = !empty($store_info['logo']) ? $store_info['logo'] : 'images/default_shop.png';
        $store_info['logo'] = getAttachmentUrl($store_info['logo'], false);

        $ws_relation = D('Supp_dis_relation')->where(array('distributor_id' => $store_id, 'supplier_id' => $supplier_id))->find();
        $ws_relation['bond'] = !empty($ws_relation['bond']) ? number_format($ws_relation['bond'], 2, '.', '') : '0.00';
        $ws_relation['income'] = !empty($ws_relation['profit']) ? number_format($ws_relation['profit'], 2, '.', '') : '0.00';
        $ws_relation['not_paid'] = !empty($ws_relation['not_paid']) ? number_format($ws_relation['not_paid'], 2, '.', '') : '0.00';
        $ws_relation['return_owe'] = !empty($ws_relation['return_owe']) ? number_format($ws_relation['return_owe'], 2, '.', '') : '0.00';

        $this->assign('store_info', $store_info);
        $this->assign('ws_relation', $ws_relation);

        $this->display();
    }

    //经销商的订单
    private function _ws_order_content()
    {
        $order_product = M('Order_product');

        $store_id    = intval(trim($_POST['store_id']));
        $supplier_id = $this->store_session['store_id'];
        $status      = intval(trim($_POST['status']));

        $sql = "SELECT COUNT(o.order_id) AS order_count FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "fx_order fxo WHERE o.fx_order_id = fxo.fx_order_id AND o.store_id = fxo.supplier_id AND o.store_id = '" . $supplier_id . "' AND fxo.store_id = '" . $store_id . "'";
        $sql2 = "SELECT o.total,o.postage,o.order_id,o.order_no,o.third_id,o.sale_total,o.user_order_id,o.use_deposit_pay,o.payment_method FROM " . option('system.DB_PREFIX') . "order o, " . option('system.DB_PREFIX') . "fx_order fxo WHERE o.fx_order_id = fxo.fx_order_id AND o.store_id = fxo.supplier_id AND o.store_id = '" . $supplier_id . "' AND fxo.store_id = '" . $store_id . "'";
        if ($status == 1) {
            $sql .= " AND o.status = 1";
            $sql2 .= " AND o.status = 1";
        } else if ($status == 2) {
            $sql .= " AND o.status IN (2,3,4,6,7)";
            $sql2 .= " AND o.status IN (2,3,4,6,7)";
        }
        $order_count = D('')->query($sql);
        $order_count = !empty($order_count[0]['order_count']) ? $order_count[0]['order_count'] : 0;
        import('source.class.user_page');
        $page = new Page($order_count, 15);

        $sql2 .= " ORDER BY o.order_id DESC LIMIT " . $page->firstRow . ',' . $page->listRows;
        $orders = D('')->query($sql2);
        if (!empty($orders)) {
            foreach ($orders as &$tmp_order) {
                $user_order_id = $tmp_order['user_order_id'];
                $products = $order_product->getProducts($tmp_order['order_id']);
                $tmp_order['products'] = $products;

                //经销商利润
                $where = array();
                $where['user_order_id'] = $user_order_id;
                $where['supplier_id']   = $supplier_id;
                $where['income']        = array('<', 0);
                $dealer_profit = D('Financial_record')->where($where)->sum('profit');
                $tmp_order['dealer_profit'] = number_format($dealer_profit, 2, '.', '');
            }
        }

        $this->assign('status', $status);
        $this->assign('orders', $orders);
        $this->assign('page', $page->show());
    }

    //保证金扣款
    private function _bond_expend_content()
    {
        $bond_record = M('Bond_record');

        $store_id    = intval(trim($_POST['store_id']));
        $supplier_id = $this->store_session['store_id'];

        $bond_expend_count = $bond_record->getBondRecordCount(array(), $supplier_id, $store_id);
        import('source.class.user_page');
        $page = new Page($bond_expend_count, 15);

        $bond_expends = $bond_record->getBondRecord(array(), $supplier_id, $store_id, $page->firstRow, $page->listRows);

        $this->assign('bond_expends', $bond_expends);
        $this->assign('page', $page->show());
    }

    //保证金充值
    private function _bond_recharge_content()
    {
        $bond_recharge = M('Margin_recharge_log');

        $store_id    = intval(trim($_POST['store_id']));
        $supplier_id = $this->store_session['store_id'];

        $where = array();
        $where['distributor_id'] = $store_id;
        $where['supplier_id']    = $supplier_id;
        $bond_recharge_count = $bond_recharge->getBondLogCount($where);
        import('source.class.user_page');
        $page = new Page($bond_recharge_count, 15);

        $bond_recharges = $bond_recharge->getBondLog($where, $page->firstRow, $page->listRows);

        $this->assign('bond_recharges', $bond_recharges);
        $this->assign('page', $page->show());
    }

    //提现记录
    private function _withdrawal_record_content()
    {
        $store_withdrawal = M('Store_withdrawal');
        $bank = M('Bank');

        $store_id    = intval(trim($_POST['store_id']));
        $supplier_id = $this->store_session['store_id'];

        $where = array();
        $where['sw.store_id']    = $store_id;
        $where['sw.supplier_id'] = $supplier_id;
        $where['sw.type']        = 2;
        $withdrawal_record_count = $store_withdrawal->getWithdrawalCount($where);
        import('source.class.user_page');
        $page = new Page($withdrawal_record_count, 15);

        $withdrawal_records =$store_withdrawal->getWithdrawals($where, $page->firstRow, $page->listRows);
        if (!empty($withdrawal_records)) {
            foreach ($withdrawal_records as &$withdrawal_record){
                $bank_info = $bank->getBank($withdrawal_record['bank_id']);
                $withdrawal_record['bank_name'] = $bank_info['name'];
            }
        }

        $status = $store_withdrawal->getWithdrawalStatus();

        $this->assign('withdrawal_records', $withdrawal_records);
        $this->assign('page', $page->show());
        $this->assign('status', $status);
    }

    //批发的商品
    private function _wholesale_product_content()
    {
        import('source.class.user_page');
        $product = D("Product");

        $supplier_id = $this->store_session['store_id'];

        $where = array();
        $where['supplier_id']          = $supplier_id;
        $where['wholesale_product_id'] = array('>', 0);
        $product_count = $product->where($where)->count('product_id');
        $page = new Page($product_count, 15);
        $products = $product->where($where)->order('product_id DESC')->limit($page->firstRow . ',' . $page->listRows)->select();
        if (!empty($products)) {
            foreach ($products as &$tmp_product) {
                $tmp_product['image'] = getAttachmentUrl($tmp_product['image'], false);
            }
        }

        $this->assign('products', $products);
        $this->assign('page', $page->show());
    }

    //白名单商品
    private function _whitelist_product_content()
    {
        import('source.class.user_page');

        $store_id    = intval(trim($_POST['store_id']));
        $supplier_id = $this->store_session['store_id'];

        $sql = "SELECT COUNT(p.product_id) AS product_count FROM " . option('system.DB_PREFIX') . "product p, " . option('system.DB_PREFIX') . "product_whitelist pw WHERE p.wholesale_product_id = pw.product_id AND pw.supplier_id = '" . $supplier_id . "' AND p.store_id = '" . $store_id . "'";
        $whitelist_product_count = D('')->query($sql);
        $whitelist_product_count = ($whitelist_product_count[0]['product_count']) ? $whitelist_product_count[0]['product_count'] : 0;
        $page = new Page($whitelist_product_count, 15);

        $sql = "SELECT p.*,pw.pigcms_id FROM " . option('system.DB_PREFIX') . "product p, " . option('system.DB_PREFIX') . "product_whitelist pw WHERE p.wholesale_product_id = pw.product_id AND pw.supplier_id = '" . $supplier_id . "' AND p.store_id = '" . $store_id . "'";
        $whitelist_products = D('')->query($sql);
        if (!empty($whitelist_products)) {
            foreach ($whitelist_products as &$tmp_product) {
                $tmp_product['image'] = getAttachmentUrl($tmp_product['image'], false);
            }
        }

        $this->assign('whitelist_product_count', $whitelist_product_count);
        $this->assign('whitelist_products', $whitelist_products);
        $this->assign('page', $page->show());
    }

    //认证资料
    private function _approve_data_content()
    {
        $certification = M('Certification');

        $store_id      = intval(trim($_POST['store_id']));
        $certification = $certification->get(array('store_id' => $store_id));

        $approve_data = array();
        if (!empty($certification['certification_info'])) {
            $approve_data = unserialize($certification['certification_info']);
        }

        $this->assign('approve_data', $approve_data);
    }


    //取消分销/批发商品
    public function cancel_fx_product()
    {
        $product = M('Product');
        $product_id = isset($_POST['product_id']) ? trim($_POST['product_id']) : '';
        $is = isset($_POST['is']) ? trim($_POST['is']) : 1;

        $product_info = D('Product')->field('has_property,wholesale_product_id,product_id,store_id')->where(array('product_id'=>$product_id))->find();

        if($is == 1) //分销
        {
            $product_data = array(
                'cost_price' => 0,
                'min_fx_price' => 0,
                'max_fx_price' => 0,
                'drp_level_1_price' => 0,
                'drp_level_2_price' => 0,
                'drp_level_3_price' => 0,
                'drp_level_1_cost_price' => 0,
                'drp_level_2_cost_price' => 0,
                'drp_level_3_cost_price' => 0,
                'is_fx' => 0,
            );

            $product_data_sku = array(
                'cost_price' => 0,
                'min_fx_price' => 0,
                'max_fx_price' => 0,
                'drp_level_1_price' => 0,
                'drp_level_2_price' => 0,
                'drp_level_3_price' => 0,
                'drp_level_1_cost_price' => 0,
                'drp_level_2_cost_price' => 0,
                'drp_level_3_cost_price' => 0,
            );
            $fx_result = D('Product')->where(array('product_id'=>$product_id))->data($product_data)->save();
            if(!empty($product_info['has_property'])) {
                $fx_result = D('Product_sku')->where(array('product_id'=>$product_id))->data($product_data_sku)->save();
            }
            if($fx_result){
                $result = D('Product_drp_degree')->where(array('product_id'=>$product_info['product_id'],'store_id'=>$product_info['store_id']))->delete();
            }

            if($fx_result) {
                json_return(0, url('supplier_market',array('is'=>1)));
            }else{
                json_return(0, url('supplier_market',array('is'=>1)));
            }
        }else if($is == 2){
            $product_data = array(
                'wholesale_price' => 0,
                'sale_min_price' => 0,
                'sale_max_price' => 0,
                'is_wholesale' => 0,
            );

            $product_data_sku = array(
                'sale_max_price' => 0,
                'sale_min_price' => 0,
                'wholesale_price' => 0,
            );
            $whole_result = D('Product')->where(array('product_id'=>$product_id))->data($product_data)->save();

            $whole_product = D('Product')->where(array('wholesale_product_id'=>$product_id))->select();

            if(!empty($product_info['has_property'])) {
                $whole_result = D('Product_sku')->field('product_id')->where(array('product_id'=>$product_id))->data($product_data_sku)->save();
            }

            if($whole_result){
                if(count($whole_product)>0){
                    //商品已设置分销
                    $if_fx_data = array(
                        'cost_price' => 0,
                        'min_fx_price' => 0,
                        'max_fx_price' => 0,
                        'drp_level_1_price' => 0,
                        'drp_level_2_price' => 0,
                        'drp_level_3_price' => 0,
                        'drp_level_1_cost_price' => 0,
                        'drp_level_2_cost_price' => 0,
                        'drp_level_3_cost_price' => 0,
                        'is_fx' => 0,
                        'status' => 2,
                    );
                    //商品未设置分销
                    $data = array(
                        'status' => 2,
                    );

                    $product_data_sku = array(
                        'cost_price' => 0,
                        'min_fx_price' => 0,
                        'max_fx_price' => 0,
                        'drp_level_1_price' => 0,
                        'drp_level_2_price' => 0,
                        'drp_level_3_price' => 0,
                        'drp_level_1_cost_price' => 0,
                        'drp_level_2_cost_price' => 0,
                        'drp_level_3_cost_price' => 0,
                    );

                    foreach($whole_product as $product)
                    {
                        if(!empty($product['is_fx'])) {
                            $up_product_id = D('Product')->where(array ('product_id' => $product['product_id']))->data($if_fx_data)->save();
                            if(!empty($product['has_property'])){
                                $up_product_id = D('Product')->where(array ('product_id' => $product['product_id']))->data($product_data_sku)->save();
                            }
                        }else{
                            $up_product_id = D('Product')->where(array ('product_id' => $product['product_id']))->data($data)->save();
                        }
                    }
                }

                json_return(0, url('supplier_market',array('is'=>2)));
            }else{
                json_return(0, url('supplier_market',array('is'=>2)));
            }
        }
    }


    //分销店铺推广配置
    public function shop_promotion()
    {
        if(IS_POST){
            $title = !empty($_POST['title']) ? $_POST['title'] : '';
            $content = !empty($_POST['content']) ? $_POST['content'] : '';
            $image = !empty($_POST['image']) ? $_POST['image'] : '';
            $description = !empty($_POST['description']) ? $_POST['description'] : '';
            $add_time = time();
            $update_time = time();
            $store_id = $this->store_session['store_id'];

            if(D("Store_promote_setting")->where(array('store_id'=>$this->store_session['store_id']))->find()){
                $data = array(
                    'title' => $title,
                    'content' => $content,
                    'image' => $image,
                    'description' => $description,
                    'update_time' => time(),
                );

                $result = D("Store_promote_setting")->where(array('store_id'=>$store_id))->data($data)->save();

            }else{
                $data = array(
                    'title' => $title,
                    'content' => $content,
                    'image' => $image,
                    'description' => $description,
                    'update_time' => time(),
                    'add_time' => time(),
                    'store_id' => $store_id,
                );
                $result = D("Store_promote_setting")->data($data)->add();
            }

            if ($result){
                json_return(0, '保存成功');
            }else{
                json_return(1001, '保存失败，请重新提交');
            }

         }
        $this->display();
    }

    private function shop_promotion_content()
    {
        $store_name = M('Store');

        $store_info = D('Store')->where(array('store_id'=>$this->store_session['store_id']))->find();

        $promote = D('Store_promote_setting')->where(array('store_id'=>$this->store_session['store_id']))->find();

        $this->assign('promote' ,$promote);
        $this->assign('store_info' ,$store_info);
    }


    //修改商品分销等级利润
    public function goods_drp_degree()
    {

        if (IS_POST) {
            if (!empty($_POST['degrees_profit'])) {
                $product_id = intval(trim($_POST['product_id']));
                $degrees_profit = $_POST['degrees_profit'];

                if (empty($product_id)) {
                    json_return(1002, '设置的分销商品不存在');
                }
                $check_drp_degree = M('Drp_degree')->checkDrpDegree($this->store_session['store_id']);
                if ($check_drp_degree && !empty($degrees_profit)) {
                    foreach ($degrees_profit as $degree_id => $degree_profit) {
                        if (!empty($degree_profit) && $degree_id > 0) {
                            $product_drp_degree = M('Product_drp_degree')->getDrpDegree(array('product_id' => $product_id, 'degree_id' => $degree_id));
                            //修改
                            if (!empty($product_drp_degree)) {
                                $data = array();
                                $data['seller_reward_1'] = $degree_profit[1]; //一级分销商利润比
                                $data['seller_reward_2'] = $degree_profit[2]; //二级分销商利润比
                                $data['seller_reward_3'] = $degree_profit[3]; //三级分销商利润比
                                D('Product_drp_degree')->where(array('product_id' => $product_id, 'degree_id' => $degree_id, 'store_id' => $this->store_session['store_id']))->data($data)->save();
                            } else { //新增
                                $data = array();
                                $data['product_id']      = $product_id;
                                $data['store_id']        = $this->store_session['store_id'];
                                $data['degree_id']       = $degree_id; //分销等级id
                                $data['seller_reward_1'] = $degree_profit[1]; //一级分销商利润比
                                $data['seller_reward_2'] = $degree_profit[2]; //二级分销商利润比
                                $data['seller_reward_3'] = $degree_profit[3]; //三级分销商利润比
                                D('Product_drp_degree')->data($data)->add();
                            }
                        }
                    }
                    json_return(0, '分销商品特权设置成功');
                } else {
                    json_return(1001, '分销商品特权设置失败');
                }
            } else {
                json_return(1001, '分销商品特权设置失败');
            }
            exit;
        }

        $product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

        $product = D('Product')->where(array('product_id' => $product_id, 'store_id' => $this->store_session['store_id']))->find();

        $check_drp_degree = M('Drp_degree')->checkDrpDegree($this->store_session['store_id']);
        $drp_degrees = array();
        if ($check_drp_degree) {
            $drp_degrees = M('Drp_degree')->getDrpDegrees(array('store_id' => $this->store_session['store_id'], 'status' => 1));
            if (!empty($drp_degrees)) {
                foreach ($drp_degrees as &$drp_degree) {
                    $product_drp_degree = M('Product_drp_degree')->getDrpDegree(array('product_id' => $product_id, 'degree_id' => $drp_degree['pigcms_id']));
                    if (!empty($product_drp_degree)) {
                        $drp_degree['seller_reward_1'] = $product_drp_degree['seller_reward_1'];
                        $drp_degree['seller_reward_2'] = $product_drp_degree['seller_reward_2'];
                        $drp_degree['seller_reward_3'] = $product_drp_degree['seller_reward_3'];
                    }
                }
            }
        }
        $product['drp_level_1_profit'] = number_format($product['drp_level_2_cost_price'] - $product['drp_level_1_cost_price'], 2, '.', '');
        $product['drp_level_2_profit'] = number_format($product['drp_level_3_cost_price'] - $product['drp_level_2_cost_price'], 2, '.', '');
        $product['drp_level_3_profit'] = number_format($product['price'] - $product['drp_level_3_cost_price'], 2, '.', '');
        $this->assign('drp_degrees', $drp_degrees);
        $this->assign('product', $product);
        $this->display();
    }

	
	//分销等级
	public  function degree() {
		
		$this->display();
		
	}
	
	//分销等级
	public function _degree_content() {
		
 		$page = $_REQUEST['p'] + 0;
		$page = max(1, $page);
		$type = $_REQUEST['type'];
		$keyword = $_REQUEST['keyword'];
		$limit = 20;
		
		$uid = $_SESSION['store']['uid'];
		$store_id = $_SESSION['store']['store_id'];
		
		$where = array();
		$where['store_id'] = $store_id;
		
		if (!empty($keyword)) {
			$where['name'] = array('like', '%' . $keyword . '%');
		}
		
		$time = time();
		
		
		$degree_model = M('Drp_degree');
		$count = $degree_model->getCount($where);
		
		if ($count > 0) {
			$page = min($page, ceil($count / $limit));
			$offset = ($page - 1) * $limit;
			$order_by = "";
		
			$degree_list = $degree_model->getList($where,$order_by,$limit,$offset);
		
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}
		
		//读取系统默认等级
		$sys_drp_degrees = D('Platform_drp_degree')->order("`value` desc")->select();
		foreach($sys_drp_degrees as $k => $v) {
			if($v['icon']) $v['icon'] = getAttachmentUrl($v['icon']);
			$sys_drp_degree[$v['pigcms_id']] = $v;
		}
		
		$this->assign('type', $type);
		$this->assign('pages', $pages);
		$this->assign('keyword', $keyword);
		$this->assign('degree_list', $degree_list); 
		$this->assign('sys_drp_degree', $sys_drp_degree);
	}
	
	
	//分销等级 开启/关闭
	public function degree_disabled() {
		
		$degree_model = M('Drp_degree');
		$store_id = $this->store_session['store_id'];
		
		$id = (Int)$_GET['id'];
		$type= $_GET['type'];
		if (empty($id)) {
			json_return(1001, '缺少最基本的参数ID');
		}
		
		
		$where['pigcms_id'] = $id;
		$degree_info = $degree_model->get($where);
		if (empty($degree_info)) {
			json_return(1003, '未找到相应的分销等级规则！');
		}
		if($store_id != $degree_info['store_id']) {
			json_return(1004, '您操作的不是当前店铺设定的分销等级信息！！');
		}
		if($_REQUEST['type'] == 'disabled') {
			$data = "status=0";
		} else if($_REQUEST['type'] == 'able') {
			$data = "status=1";
		} else {
			json_return(1005, '操作异常');
		}
		$degree_model->edit(array('pigcms_id' => $id),$data);
		
		json_return(0, '操作完成');
	}
	
	public function _degree_create() {
		$degree_model = M('Drp_degree');
		
		

		if (IS_POST && isset($_POST['is_submit'])) {
			$uid = $_SESSION['store']['uid'];
			$store_id = $_SESSION['store']['store_id'];
		
			$level_num = $_POST['level_num'];
		
			$points_limit = $_POST['points_limit']?$_POST['points_limit']:0;
			$seller_reward_1 = $_POST['seller_reward_1'] ? $_POST['seller_reward_1']:0;
			$seller_reward_2 = $_POST['seller_reward_2']?$_POST['seller_reward_2']:0;
			$seller_reward_3 = $_POST['seller_reward_3']?$_POST['seller_reward_3']:0;
			$pic_type = $_POST['pic_type'];
			$level_pic = $_POST['level_pic']; //图片
			$degree_name_typeid = $_POST['degree_id'];
			$degree_name = $_POST['degree_name'];
			$condition_point = $_POST['points_limit'];
			$description = $_POST['description'];
		
			if(!$store_id) {
				json_return(1003, '登陆错误');
			}
			$data['store_id'] = $store_id;
				
			//等级图标
			if(!$level_pic) {
				json_return(1004, '等级图标未选择！');
			}
			if(!$level_num) {
				json_return(1005,"等级值填写错误！");
			} else {
				$data['value'] = $level_num;
			}
				
			if($pic_type == 'now') {
				$data['degree_icon_custom'] = getAttachment($level_pic);
				$data['is_platform_degree_icon'] = "0";
			} else {
				$data['is_platform_degree_icon'] = $pic_type;
			}
				
			if($degree_name_typeid == 'now') {
				$data['is_platform_degree_name'] = "0";
				$data['degree_alias'] = $degree_name;
			} else {
				// 检查此等级是否已经存在
				$drp_degree = D('Drp_degree')->where(array('is_platform_degree_name' => $degree_name_typeid, 'store_id' => $store_id))->find();
				if ($drp_degree) {
					json_return(1000, '此等级已经存在');
				}
				
				$data['is_platform_degree_name'] = $degree_name_typeid;
			}
		
			if($seller_reward_1) {
				$data['seller_reward_1'] = $seller_reward_1;
				if(in_array($seller_reward_1,array('100','100.0','0','0.0'))) {
					$data['seller_reward_1'] = "0";
				} elseif(!preg_match('/^[0-9]{1,2}[\.]?[0-9]{0,1}$/',$seller_reward_1)) {
					json_return(1008, '一级分销商奖励比率填写不正确！');
				}
			}
			if($seller_reward_2) {
				$data['seller_reward_2'] = $seller_reward_2;
				if(in_array($seller_reward_2,array('100','100.0','0','0.0'))) {
					$data['seller_reward_2'] = "0";
				} elseif(!preg_match('/^[0-9]{1,2}[\.]?[0-9]{0,1}$/',$seller_reward_2)) {
					json_return(1009, '二级分销商奖励比率填写不正确！');
				}
			}
			if($seller_reward_3) {
				$data['seller_reward_3'] = $seller_reward_3;
				if(in_array($seller_reward_3,array('100','100.0','0','0.0'))) {
					$data['seller_reward_3'] = "0";
				} elseif(!preg_match('/^[0-9]{1,2}[\.]?[0-9]{0,1}$/',$seller_reward_3)) {
					json_return(1009, '三级分销商奖励比率填写不正确！');
				}
			}
				
			$data['condition_point'] = $points_limit;
			if(!preg_match('/^[0-9]{1,6}$/',$points_limit)) {
				json_return(1009, '填写积分错误！');
			}
		
		
			$data['description'] = $description;
			if(!$description) {
				json_return(1012, '使用须知不能为空');
			} else {
				$description = msubstr($description,0,"200");
			}
			
			D('Drp_degree')->data($data)->add();

		
			json_return(0, '添加成功');
		
		}		
		$where = array();
		$where['store_id'] = $_SESSION['store']['store_id'];
		$degree_infos = $degree_model->get($where);
		if($degree_infos['degree_alias']) $degree_infos['name'] = $degree_infos['degree_alias'];
		if($degree_infos['degree_icon_custom']) $degree_infos['icon'] = getAttachmentUrl($degree_infos['degree_icon_custom']);
		$degree_info['now'] = $degree_infos;
		//读取系统默认等级
		$sys_drp_degree = D('Platform_drp_degree')->where('`status`=1')->order("`value` desc")->select();
		
		if(is_array($sys_drp_degree)) {
			foreach($sys_drp_degree as $k=>&$v) {
				if($v['icon'])  $v[icon] = getAttachmentUrl($v['icon']);
			}
		}
	
		//echo "<pre>";
		//print_r($sys_drp_degree);exit;
		$this->assign('degree', $sys_drp_degree);
		$this->assign('degree_info', $degree_infos);
		//是否允许diy分销商等级
		$is_allow_diy_drp_degree = option('config.is_allow_diy_drp_degree');
		$this->assign('is_allow_diy_drp_degree',$is_allow_diy_drp_degree);
		
	}
	
	//分销等级渲染页面 及 操作
	public function _degree_edit() {
		//option('config.orderid_prefix')
		
		//是否允许diy分销商等级
		$is_allow_diy_drp_degree = option('config.is_allow_diy_drp_degree');
		
		$degree_model = M('Drp_degree');
		$id = (Int)$_POST['id'];
	
		if (empty($id)) {
			json_return(1001, '缺少最基本的参数ID');
		}
		//判断以下修改的是否是自己的
		$degree_infos = D('Drp_degree')->where(array('pigcms_id' => $id))->find();
		if( $_SESSION['store']['store_id']!= $degree_infos['store_id']) {
			json_return(1002, '当前分销等级不是该店铺的！');
		}
	
		if (IS_POST && isset($_POST['is_submit'])) {
			$uid = $_SESSION['store']['uid'];
			$store_id = $_SESSION['store']['store_id'];

			$level_num = $_POST['level_num'];

			$points_limit = $_POST['points_limit']?$_POST['points_limit']:0;
			$seller_reward_1 = $_POST['seller_reward_1'] ? $_POST['seller_reward_1']:0;
			$seller_reward_2 = $_POST['seller_reward_2']?$_POST['seller_reward_2']:0;
			$seller_reward_3 = $_POST['seller_reward_3']?$_POST['seller_reward_3']:0;
			$pic_type = $_POST['pic_type'];
			$level_pic = $_POST['level_pic']; //图片
			$degree_name_typeid = $_POST['degree_id'];
			$degree_name = $_POST['degree_name'];
			$condition_point = $_POST['points_limit'];
			$description = $_POST['description'];
	
			if(!$store_id) {
				json_return(1003, '登陆错误');
			}
			
			//等级图标
			if(!$level_pic) {
				json_return(1004, '等级图标未选择！');
			}
			if(!$level_num) {
				json_return(1005,"等级值填写错误！");
			} else {
				$data['value'] = $level_num;
			}
			
			if($pic_type == 'now') {
				$data['degree_icon_custom'] = getAttachment($level_pic);
				$data['is_platform_degree_icon'] = "0";
			} else {
				$data['is_platform_degree_icon'] = $pic_type;
			}
			
			if($degree_name_typeid == 'now') {
				$data['is_platform_degree_name'] = "0";
				$data['degree_alias'] = $degree_name;
			} else {
				// 检查此等级是否已经设置
				$drp_degree = D('Drp_degree')->where(array('is_platform_degree_name' => $degree_name_typeid, 'store_id' => $store_id, 'pigcms_id' => array('!=', $id)))->find();
				if ($drp_degree) {
					json_return(1000, '此等级已经存在');
				}
				
				$data['is_platform_degree_name'] = $degree_name_typeid;
			}
				
			if($seller_reward_1) {
				$data['seller_reward_1'] = $seller_reward_1;
				if(in_array($seller_reward_1,array('100','100.0','0','0.0'))) {
					$data['seller_reward_1'] = "0";
				} elseif(!preg_match('/^[0-9]{1,2}[\.]?[0-9]{0,1}$/',$seller_reward_1)) {
					json_return(1008, '一级分销商奖励比率填写不正确！');
				}
			}
			if($seller_reward_2) {
				$data['seller_reward_2'] = $seller_reward_2;
				if(in_array($seller_reward_2,array('100','100.0','0','0.0'))) {
					$data['seller_reward_2'] = "0";
				} elseif(!preg_match('/^[0-9]{1,2}[\.]?[0-9]{0,1}$/',$seller_reward_2)) {
					json_return(1009, '二级分销商奖励比率填写不正确！');
				}
			}			
			if($seller_reward_3) {
				$data['seller_reward_3'] = $seller_reward_3;
				if(in_array($seller_reward_3,array('100','100.0','0','0.0'))) {
					$data['seller_reward_3'] = "0";
				} elseif(!preg_match('/^[0-9]{1,2}[\.]?[0-9]{0,1}$/',$seller_reward_3)) {
					json_return(1009, '三级分销商奖励比率填写不正确！');
				}
			}			
			
			$data['condition_point'] = $points_limit;
			if(!preg_match('/^[0-9]{1,6}$/',$points_limit)) {
				json_return(1009, '填写积分错误！');
			}
				

			$data['description'] = $description;
			if(!$description) {
				json_return(1012, '使用须知不能为空');
			} else {
				$description = msubstr($description,0,"200");
			}
			
			
			D('Drp_degree')->data($data)->where(array('pigcms_id' => $id))->save();

			json_return(0, '修改成功');
	
		}
	

		
		$where = array();
		$where['store_id'] = $_SESSION['store']['store_id'];
		$where['pigcms_id'] = $id;
		$degree_infos = $degree_model->get($where);
		if($degree_infos['degree_alias']) $degree_infos['name'] = $degree_infos['degree_alias'];
		if($degree_infos['degree_icon_custom']) $degree_infos['icon'] = getAttachmentUrl($degree_infos['degree_icon_custom']);
		$degree_info['now'] = $degree_infos;
		//读取系统默认等级
		$sys_drp_degree = D('Platform_drp_degree')->where('`status`=1')->order("`value` desc")->select();
		
		if(is_array($sys_drp_degree)) {
			foreach($sys_drp_degree as $k=>&$v) {
				if($v['icon'])  $v[icon] = getAttachmentUrl($v['icon']);
			}
		}
		$degree_info = array_merge($sys_drp_degree,$degree_info);
		

		$this->assign('degree', $degree_info);
		$this->assign('is_allow_diy_drp_degree',$is_allow_diy_drp_degree);
		$this->assign('degree_info', $degree_infos);
		
	
	}
	
	
	public function degree_delete() {
		
		$pigcms_id = $_REQUEST['pigcms_id'];
		if (empty($pigcms_id)) {
			json_return(1001, '缺少最基本的参数ID');
		}
		$where['store_id'] = $_SESSION['store']['store_id'];
		$degree_info = D('Drp_degree')->where(array('pigcms_id' => $pigcms_id))->find();
		if( $_SESSION['store']['store_id']!= $degree_info['store_id']) {
			json_return(1002, '当前分销等级不是该店铺的！');
		}
		
		M('Drp_degree')->delete(array('pigcms_id' => $pigcms_id));
		json_return(0, '操作完成');
	}

    //我的团队
    public function my_team()
    {
        //检测同供货商下团队名称唯一性
        if (IS_POST && strtolower($_POST['type']) == 'check_name') {
            $seller_id = $this->store_session['store_id'];
            $name = trim($_POST['name']);
            $team_id = intval(trim($_POST['team_id']));
            if (empty($name)) {
                json_return(1001, '团队名称不能为空');
            }
            //供货商id
            $supplier_id = M('Store_supplier')->getSupplierId($seller_id);
            $where = array();
            $where['name'] = $name;
            if (!empty($team_id)) {
                $where['team_id'] = array('!=', $team_id);
            }
            $where['supplier_id'] = $supplier_id;
            if (M('Drp_team')->checkUniqueName($where)) {
                json_return(1002, '团队名称已存在');
            } else {
                json_return(0, '团队名称可用');
            }
        } else if (IS_POST && strtolower($_POST['type']) == 'save') { //保存
            $seller_id = $this->store_session['store_id'];
            $data = array();
            if (isset($_POST['name'])) {
                $name = trim($_POST['name']);
                $data['name'] = $name;
            }
            if (isset($_POST['logo'])) {
                $logo = trim($_POST['logo']);
                $data['logo'] = $logo;
            }
            if (isset($_POST['desc'])) {
                $desc = trim($_POST['desc']);
                $data['desc'] = $desc;
            }
            $team_id = intval(trim($_POST['team_id']));
            $member_labels = $_POST['member_labels'];

            //供货商id
            $supplier_id = M('Store_supplier')->getSupplierId($seller_id);

            //团队基本信息
            if (isset($name) || isset($logo) || isset($desc)) {
                if (empty($team_id)) { //新增
                    $data['store_id'] = $seller_id;
                    $data['supplier_id'] = $supplier_id;
                    $data['add_time'] = time();
                    $result = D('Drp_team')->data($data)->add();
                    $team_id = $result;
                    if ($team_id) {
                        $_SESSION['store']['drp_team_id'] = $team_id;
                        D('Store')->where(array('store_id' => $this->store_session['store_id']))->data(array('drp_team_id' => $team_id))->save();
                        M('Drp_team')->setMembers($team_id);
                    }
                } else { //更新
                    $result = D('Drp_team')->where(array('pigcms_id' => $team_id))->data($data)->save();
                }
            }

            //成员标签
            if (!empty($member_labels)) {
                $drp_level = $this->store_session['drp_level'];
                foreach ($member_labels as $level => $member_label) {
                    if (!empty($member_label)) {
                        if ($label = D('Drp_team_member_label')->where(array('team_id' => $team_id, 'store_id' => $this->store_session['store_id'], 'drp_level' => ($drp_level + $level)))->find()) {
                            $temp_result = D('Drp_team_member_label')->where(array('pigcms_id' => $label['pigcms_id']))->data(array('name' => $member_label))->save();
                        } else {
                            $temp_result = D('Drp_team_member_label')->data(array('team_id' => $team_id, 'store_id' => $this->store_session['store_id'], 'name' => $member_label, 'drp_level' => ($drp_level + $level)))->add();
                        }
                        if ($temp_result) {
                            $result2 = $temp_result;
                        }
                    }
                }
            }

            if ($result || $result2) {
                json_return(0, '团队信息保存成功');
            } else {
                json_return(1001, '团队信息保存失败');
            }
        }

        $this->display();
    }

    private function _my_team_content()
    {
        $drp_team_model = M('Drp_team');

        $drp_team = array();
        $is_supplier = false; //是否为供货商
        $is_drp_team_owner = false; //是否为团队所有者

        //供货商
        if (empty($this->store_session['drp_supplier_id'])) {
            $is_supplier = true;

            import('source.class.user_page');
            $where = array();
            $where['dt.supplier_id'] = $this->store_session['store_id'];
            if (!empty($_POST['name'])) {
                $where['dt.name'] = array('like', '%' . trim($_POST['name']) . '%');
            }
            if (!empty($_POST['owner'])) {
                $where['s.name'] = array('like', '%' . trim($_POST['owner']) . '%');
            }
            if (!empty($_POST['start_time']) && !empty($_POST['end_time'])) {
                $start_time = strtotime(trim($_POST['start_time']));
                $end_time = strtotime(trim($_POST['end_time']));
                $where['_string'] = "dt.add_time >= '" . $start_time . "' AND dt.add_time <= '" . $end_time . "'";
            } else if (!empty($_POST['start_time'])) {
                $start_time = strtotime(trim($_POST['start_time']));
                $where['dt.add_time'] = array('>=', $start_time);
            } else if (!empty($_POST['end_time'])) {
                $end_time = strtotime(trim($_POST['end_time']));
                $where['dt.add_time'] = array('<=', $end_time);
            }
            $drp_team_count = $drp_team_model->getDrpTeamCount($where);
            $page = new Page($drp_team_count, 20);
            //排序
            $order_field = 'dt.pigcms_id';
            $order_method = 'DESC';
            if (!empty($_POST['order_field'])) {
                $order_field = 'dt.' . trim($_POST['order_field']);
            }
            if (!empty($_POST['order_method'])) {
                $order_method = trim($_POST['order_method']);
            }
            $order_by = $order_field . " " . $order_method;
            $drp_teams = $drp_team_model->getDrpTeams($where, $order_by, $page->firstRow, $page->listRows);
            foreach ($drp_teams as &$drp_team) {
                if (empty($drp_team['logo'])) {
                    $tmp_store = D('Store')->field('logo')->where(array('store_id' => $drp_team['store_id']))->find();
                    $drp_team['logo'] = !empty($tmp_store['logo']) ? getAttachmentUrl($tmp_store['logo']) : getAttachmentUrl('images/default_shop.png');
                }
            }

            $this->assign('drp_teams', $drp_teams);
            $this->assign('page', $page->show());
        } else {
            $is_drp_team_owner = $drp_team_model->checkDrpTeamOwner($this->store_session['store_id'], true);

            //一级分销商id
            $first_seller_id = $this->store_session['store_id'];
            if (empty($is_drp_team_owner)) {
                $first_seller_id = M('Store_supplier')->getFirstSeller($this->store_session['store_id']);
            }
            $drp_team = $drp_team_model->getDrpTeam(array('store_id' => $first_seller_id));

            $my_members = array();
            $members_1 = array();
            $members_2 = array();
            if (!empty($drp_team)) {
                $drp_team['member_labels'] = M('Drp_team_member_label')->getMemberLabels(array('team_id' => $drp_team['pigcms_id'], 'store_id' => array('in', array($this->store_session['store_id'], $first_seller_id))));

                $members_1 = M('Drp_team')->getMemberCountByLevel($this->store_session['store_id'], $this->store_session['drp_level'] + 1, true, true);
                $members_2 = M('Drp_team')->getMemberCountByLevel($this->store_session['store_id'], $this->store_session['drp_level'] + 2, true, true);
            }
            if (empty($drp_team['logo'])) {
                $drp_team['logo'] = $this->store_session['logo'];
            }
            $drp_team['my_members'] = $my_members;
            $drp_team['members_1'] = $members_1;
            $drp_team['members_2'] = $members_2;

            //团队在供货商下的排名
            $team_rank = M('Drp_team')->getTeamRank($drp_team['pigcms_id']);
            $drp_team['rank'] = $team_rank;

            $this->assign('is_supplier', $is_supplier);
            $this->assign('is_drp_team_owner', $is_drp_team_owner);
            $this->assign('drp_team', $drp_team);
        }
    }

    //分销团队详细
    public function my_team_detail()
    {
        $team_id = intval(trim($_GET['id']));
        $team = M('Drp_team')->getDrpTeam(array('pigcms_id' => $team_id, 'supplier_id' => $this->store_session['store_id']));
        if (empty($team)) {
            pigcms_tips('访问的分销团队不存在');
        }
        $seller = D('Store')->field('name')->where(array('store_id' => $team['store_id']))->find();
        $team['owner'] = $seller['name'];

        //团队在供货商下的排名
        $team_rank = M('Drp_team')->getTeamRank($team_id);
        $team['rank'] = $team_rank;
        $team['logo'] = !empty($team['logo']) ? getAttachmentUrl($team['logo']) : getAttachmentUrl('images/default_shop.png');

        $this->assign('team', $team);
        $this->display();
    }

    private function _my_team_detail_content()
    {
        import('source.class.user_page');

        $team_id = intval(trim($_POST['team_id']));
        //排序
        $order_field = isset($_POST['order_field']) ? trim($_POST['order_field']) : 'store_id';
        $order_method = isset($_POST['order_method']) ? trim($_POST['order_method']) : 'DESC';
        $order_by = $order_field . " " . $order_method;

        $where = array();
        $where['drp_team_id'] = $team_id;
        $member_count = M('Drp_team')->getMemberCount($where);
        $page = new Page($member_count, 20);
        $members = M('Drp_team')->getMembers($where, $order_by, $page->firstRow, $page->listRows);
        if (!empty($members)) {
            foreach ($members as &$member) {
                $member['logo'] = !empty($member['logo']) ? getAttachmentUrl($member['logo']) : getAttachmentUrl('images/default_shop.png');
            }
        }

        $this->assign('members', $members);
        $this->assign('page', $page->show());
    }

    //修复库存表原库存id
    function bug_fx(){
        $sql = "select has_property,product_id,wholesale_product_id from pigcms_product where wholesale_product_id > 0";
        $resultList = D("Product")->query($sql);
        $i=0;
        foreach($resultList as $result){
            if(!empty($result['has_property'])){
                $sql = "select sku_id,properties from pigcms_product_sku where product_id = {$result['wholesale_product_id']}";
                $skuIdList = D("Product_sku")->query($sql);

                foreach($skuIdList as $skuId){

                    D('Product_sku')->where(array('product_id'=>$result['product_id'],'properties'=>$skuId['properties']))->data(array('wholesale_sku_id'=>$skuId['sku_id']))->save();
                }
                $i++;
                echo $i."<br/>";
            }
        }
    }

    //修复店铺状态不为 1 时处理还存在的商品
    function bug_fx_product(){
        //查找被删除的店铺
        $where = array();
        $where['status'] = array('!=', 1);
        $store_list = D('Store')->field('store_id')->where($where)->select();
        if($store_list){
            $i=0;
            foreach($store_list as $store){
                //查看店铺是否有商品
                $product_list = D('Product')->field('product_id')->where(array('store_id'=>$store['store_id']))->select();
                //店铺是否设置了批发商品
                $wholesale_peoduct_list = D('Product')->field('product_id')->where(array('store_id'=>$store['store_id'],'is_wholesale'=>1))->select();

                if($wholesale_peoduct_list){
                    foreach($wholesale_peoduct_list as $wholesale_product){
                        D('Product')->where(array('wholesale_product_id'=>$wholesale_product['product_id']))->data(array('status'=>2))->save();
                    }
                }
                if($product_list){
                    D('Product')->where(array('store_id'=>$store['store_id']))->data(array('status'=>2))->save();
                }
                $i++;
                echo $i."<br/>";
            }
        }
    }

    /**
     * 设置店铺保证金账户
     */
    public function setStoreMargin(){
        $type = !empty($_POST['type']) ? $_POST['type'] : '';
        $no_check = !empty($_POST['no_check']) ? $_POST['no_check'] : '';
        $data['bank_id'] = !empty($_POST['bank_id']) ? $_POST['bank_id'] : ''; //发卡银行
        $data['opening_bank'] = !empty($_POST['opening_bank']) ? $_POST['opening_bank'] : ''; //开户行
        $data['bank_card_user'] = !empty($_POST['bank_card_user']) ? $_POST['bank_card_user'] : ''; //开卡人姓名
        $data['bank_card'] = !empty($_POST['bank_card']) ? $_POST['bank_card'] : ''; //银行卡卡号
        $pigcms_id = !empty($_POST['pigcms_id']) ? $_POST['pigcms_id'] : '';

        if($type == 'check'){
            $bank = M('Bank');
            $banks = $bank->getEnableBanks();
            $check = D('Margin_account')->where(array('store_id'=>$this->store_session['store_id']))->find();
            if($check && empty($no_check)){
                exit(json_encode(array('error_code'=>0)));
            } else if(empty($check) && !empty($no_check)) {
                exit(json_encode(array('error_code'=>1001,'message'=>$banks,'check'=>$check)));
            } else if (empty($check) && empty($no_check)){
                exit(json_encode(array('error_code'=>1001,'message'=>$banks,'check'=>$check)));
            } else if($check && !empty($no_check)){
                exit(json_encode(array('error_code'=>1001,'message'=>$banks,'check'=>$check)));
            }
        } else if ($type == 'add') {
            $check = D('Margin_account')->where(array('pigcms_id'=>$pigcms_id,'store_id'=>$this->store_session['store_id']))->find();
            $data['add_time'] = time();
            $data['update_time'] = time();
            $data['store_id'] = $this->store_session['store_id'];
            if ($check) {
                D('Margin_account')->where(array('pigcms_id'=>$pigcms_id,'store_id'=>$this->store_session['store_id']))->data($data)->save();
                exit(json_encode(array ('error_code' => 0, 'message' => '修改成功')));
            } else {
                D('Margin_account')->data($data)->add();
                exit(json_encode(array ('error_code' => 0, 'message' => '添加成功')));
            }
        }
    }

    public function drp_product_setting() {

        set_time_limit(0); //无限请求超时时间
        import('source.class.Drp');
        $store_id = $this->store_session['store_id'];
        $product_id = intval(trim($_POST['product_id']));
        $time = intval(trim($_POST['time']));
        $drp_profit_1 = floatval(trim($_POST['drp_profit_1']));
        $drp_profit_2 = floatval(trim($_POST['drp_profit_2']));
        $drp_profit_3 = floatval(trim($_POST['drp_profit_3']));
        $unified_profit = !empty($_POST['unified_profit']) ? $_POST['unified_profit'] : 0;
        $save_original_setting = !empty($_POST['save_original_setting']) ? $_POST['save_original_setting'] : 0;
        $i = 0;
        while (true) {
            //sleep(3);
            usleep(500000); //0.5秒
            $i++;
            $where = array();
            $where['store_id'] = $store_id;
            $where['status'] = 1;
            if (!empty($save_original_setting)) { //保留原分销设置（自定义设置分销）
                $where['drp_custom_setting'] = 0;
            }
            $where['product_id'] = array('>', $product_id);
            $product = D('Product')->field('product_id,name,image,price,has_property,supplier_id,wholesale_price,drp_level_1_cost_price,drp_level_2_cost_price,drp_level_3_cost_price')->where($where)->order('product_id ASC')->find();
            //若得到数据则马上返回数据给客服端，并结束本次请求
            if (!empty($product)) {
                $product['drp_profit_1'] = $drp_profit_1;
                $product['drp_profit_2'] = $drp_profit_2;
                $product['drp_profit_3'] = $drp_profit_3;
                if (empty($product_id)) { //第一次请求
                    $store_config = D('Store_config')->where(array('store_id' => $store_id))->find();
                    if (empty($store_config)) {
                        $data = array();
                        $data['store_id'] = $store_id;
                        $data['drp_profit_1'] = $drp_profit_1;
                        $data['drp_profit_2'] = $drp_profit_2;
                        $data['drp_profit_3'] = $drp_profit_3;
                        $data['unified_profit'] = $unified_profit;
                        $data['drp_original_setting'] = $save_original_setting;
                        $data['last_edit_time'] = time();
                        D('Store_config')->data($data)->add();
                    } else {
                        $data = array();
                        $data['drp_profit_1'] = $drp_profit_1;
                        $data['drp_profit_2'] = $drp_profit_2;
                        $data['drp_profit_3'] = $drp_profit_3;
                        $data['unified_profit'] = $unified_profit;
                        $data['drp_original_setting'] = $save_original_setting;
                        $data['last_edit_time'] = time();
                        D('Store_config')->where(array('pigcms_id' => $store_config['pigcms_id'], 'store_id' => $store_id))->data($data)->save();
                    }
                }

                $tmp_product = Drp::setProfit($product, $unified_profit, 3);

                $product['drp_level_1_cost_price'] = $tmp_product['drp_level_1_cost_price'];
                $product['drp_level_2_cost_price'] = $tmp_product['drp_level_2_cost_price'];
                $product['drp_level_3_cost_price'] = $tmp_product['drp_level_3_cost_price'];
                $product['profit'] = number_format($product['price'] - $tmp_product['drp_level_3_cost_price'], 2, '.', '');
                if (!empty($product['supplier_id'])) {
                    $product['wholesale_profit'] = number_format($product['price'] - $product['wholesale_price'], 2, '.', '');
                }
                $product['image'] = getAttachmentUrl($product['image']);
                $product['status'] = '已处理';
                json_return(0, $product);
            }

            //服务器($_POST['time']*0.5)秒后告诉客服端无数据
            if ($i == $time) {
                json_return(1, '分销设置失败');
            }
        }
    }
}
