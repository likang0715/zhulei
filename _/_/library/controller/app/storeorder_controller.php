<?php
/**
 * 订单控制器
 */
class storeorder_controller extends base_controller{

	 /**
     * 订单列表
     */
    public function order_list() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
       

     	$page = max(1, $_REQUEST['page']);
		$limit = max(1, $_REQUEST['size']);
		
	    $data['status']=isset($_REQUEST['status'])?$_REQUEST['status']:'*';
        $order = M('Order');
        $order_product = M('Order_product');
        $user = M('User');

        if (M('Drp_team')->checkDrpTeam($this->store_id, true) && empty($this->drp_supplier_id)) {
            $drp_teams = M('Drp_team')->getDrpTeams(array('dt.supplier_id' => $this->store_id), 'dt.pigcms_id DESC', 0, 0);
             // $results['drp_teams']=$drp_teams;
        }

   
        $where = array();
        $where['store_id'] = $this->store_id;
        if ($data['status'] != '*') {
            $where['status'] = intval($data['status']);
        } else { //所有订单（不包含临时订单）
            $where['status'] = array('>', 0);
        }
        if ($data['third_id']) {
            $where['third_id'] = $data['third_id'];
        }
        if ($data['order_no']) {
            $where['order_no'] = $data['order_no'];
        }
        if ($data['trade_no']) {
            $where['trade_no'] = $data['trade_no'];
        }
        if (!empty($data['user'])) {
            $where['address_user'] = $data['user'];
        }
        if (!empty($data['tel'])) {
            $where['address_tel'] = $data['tel'];
        }
        if (!empty($data['payment_method'])) {
            $where['payment_method'] = $data['payment_method'];
        }
        if (!empty($data['shipping_method'])) {
            $where['shipping_method'] = $data['shipping_method'];
        }

        $data['is_show_activity_data'] = '0';	//不显示 活动订单
        if(!$data['is_show_activity_data']) {
        	$where['activity_data'] = array('is_null', "is_null");
        }

        if (!empty($data['drp_team_id'])) {
            $where['drp_team_id'] = $data['drp_team_id'];
        }

        // 活动订单
        if (!empty($data['activity_type'])) {
            $where['type'] = $data['activity_type'];
        }

        $field = '';
        if (!empty($data['time_type'])) {
            $field = $data['time_type'];
        }
        if (!empty($data['start_time']) && !empty($data['stop_time']) && !empty($field)) {
            $where['_string'] = "`" . $field . "` >= " . strtotime($data['start_time']) . " AND `" . $field . "` <= " . strtotime($data['stop_time']);
        } else if (!empty($data['start_time']) && !empty($field)) {
            $where[$field] = array('>=', strtotime($data['start_time']));
        } else if (!empty($data['stop_time']) && !empty($field)) {
            $where[$field] = array('<=', strtotime($data['stop_time']));
        }

        //排序
        if (!empty($data['orderbyfield']) && !empty($data['orderbymethod'])) {
            $orderby = "`{$data['orderbyfield']}` " . $data['orderbymethod'];
        } else {
            $orderby = '`order_id` DESC';
		}

        $tmp_types = array();
       
        if (is_numeric($data['type'])) {
            $where['type'] = $data['type'];
        }
   
		$count = $order->getOrderTotal($where);

       
        $pages=ceil($count / $limit);
		$offset=($page - 1) * $limit;
       
        $tmp_orders = $order->getOrders($where, $orderby, $offset, $limit);
        $orders = array();
        $tuan_id_arr = array();
        foreach ($tmp_orders as $tmp_order) {

            $user_order = $tmp_order;
            $user_order_id = !empty($user_order['user_order_id']) ? $user_order['user_order_id'] : $user_order['order_id'];
            if (!empty($tmp_order['user_order_id'])) {
                $user_order = D('Order')->where(array('order_id' => $tmp_order['user_order_id']))->find();
                //订单实付金额
                $tmp_order['pay_amount'] = $user_order['total'];
            }

            if ($tmp_order['type'] != 5) {
                $user_order = D('Order')->where(array('order_id' => $user_order_id))->find();
                $tmp_order['cash_point'] = $user_order['cash_point'];
                $tmp_order['return_point'] = $user_order['return_point'];
                $tmp_order['pay_money'] = $user_order['total'];
                $tmp_order['cash_money'] = number_format($user_order['cash_point'] / $user_order['point2money_rate'], 2, '.', '');
            }
			if($tmp_order['type'] == 7) {
				if($tmp_order['presale_order_id']) {
					$other_order = D('Order')->where('order_id="'.$tmp_order['presale_order_id'].'"')->find();
					$tmp_order['pre_order_no'] = $other_order['order_no'];
				}
			}

            $products = $order_product->getProducts($tmp_order['order_id']);
            $tmp_order['products'] = $products;
			$tmp_order['buyer'] = '';
			if (!empty($tmp_order['uid'])) {
                $user_info = D('User')->field('nickname,phone')->where(array('uid' => $tmp_order['uid']))->find();
				$tmp_order['buyer'] = $user_info['nickname'];
				if (empty($tmp_order['address_tel'])) {
					$tmp_order['address_tel'] = $user_info['phone'];
				}
            }

            // 是否有退货未完成的申请，有未完成的申请，暂时不给完成订单
            if ($tmp_order['status'] == 7) {
                $count = D('Return')->where("order_id = '" . $tmp_order['order_id'] . "' AND status IN (1, 3, 4)")->count('id');
                $tmp_order['returning_count'] = $count;
            }

			if (!empty($user_order) && empty($user_order['useStorePay'])) {
				if (D('Return')->where(array('order_id' => $tmp_order['order_id'], 'status' => array('in', array(1,3,4))))->count('id') > 0) {
					$tmp_order['returning'] = true;
				} else if (D('Return')->where(array('order_id' => $tmp_order['order_id'], 'status' => 5, 'refund_status' => 0))->count('id') > 0) {
					$tmp_order['refunding'] = true;
				}
			}

            $is_supplier = false;
            $is_packaged = false;
            if (!empty($tmp_order['suppliers'])) { //订单供货商
                $suppliers = explode(',', $tmp_order['suppliers']);
                if (in_array($this->store_id, $suppliers)) {
                    $is_supplier = true;
                }
            }
            if (empty($tmp_order['suppliers'])) {
                $is_supplier = true;
            }

            $has_my_product = false;
            foreach ($products as &$product) {
                $product['image'] = getAttachmentUrl($product['image']);
                if (empty($product['is_fx'])) {
                    $has_my_product = true;
                }

                //自营商品
                if (empty($product['supplier_id']) && $product['store_id'] == $this->store_id) {
                    $is_supplier = true;
                }

                //商品来源
                if (empty($product['supplier_id']) && $product['store_id'] == $this->store_id) { //本店商品
                    $from = '本店商品';
                } else if (!empty($product['supplier_id']) && $product['store_id'] == $this->store_id && !empty($product['wholesale_product_id'])) { //批发商品
                    $from = '批发商品';
                    $product['is_ws'] = 1;
					$tmp_order['is_ws'] = 1;
                } else { //分销商品
                    $from = '分销商品';
                }
                $product['from'] = $from;

                //向后兼容利润计算
                $no_profit = false;
                if ($product['profit'] == 0) {
                    $fx_order = D('Fx_order')->field('fx_order_id')->where(array('order_id' => $tmp_order['order_id']))->find();
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
                    $product['profit'] = $product['pro_price'];
                    $product['cost_price'] = 0;
                }

                $product['profit'] = number_format($product['profit'], 2, '.', '');
                $product['cost_price'] = number_format($product['cost_price'], 2, '.', '');

                //零售价
                if (!empty($tmp_order['user_order_id'])) {
                    if ($tmp_order['type'] == 3) {
                        $tmp_order_product = D('Order_product')->field('pro_price')->where(array('order_id' => $tmp_order['user_order_id'], 'product_id' => $product['product_id']))->find();
                        $product['sale_price'] = $tmp_order_product['pro_price'];
                    } else if ($tmp_order['type'] == 5) {
                        $tmp_order_product = D('Order_product')->field('pro_price')->where(array('order_id' => $tmp_order['user_order_id'], 'original_product_id' => $product['product_id']))->find();
                        $product['sale_price'] = $tmp_order_product['pro_price'];
                    }
                }

                //退货商品
				$product['return_quantity'] = M('Return_product')->getReturnQty($tmp_order['order_id'], $product['pigcms_id']);

                //关注店铺公众号折扣
                $product['subscribed_discount'] = number_format($product['subscribed_discount'], 1, '.', '');
            }

            if (!empty($user_order['suppliers']) && in_array($this->store_id, explode(',', $user_order['suppliers']))) {
                //退货的分销利润
                $return_profit = 0;
                //和当前订单相关的退货
                $return_products = D('Return_product')->field('product_id,pro_num')->where(array('order_id' => $tmp_order['order_id']))->select();
                if (!empty($return_products)) {
                    foreach ($return_products as $return_product) {
                        $order_return_product = D('Order_product')->field('profit')->where(array('product_id' => $return_product['product_id'], 'user_order_id' => $tmp_order['user_order_id']))->find();
                        $return_profit += $order_return_product['profit'] * $return_product['pro_num'];
                    }
                }
                $tmp_order['return_profit'] = number_format($return_profit, 2, '.', '');
            }

            if (!empty($tmp_order['user_order_id'])) {
                $order_info = D('Order')->field('store_id')->where(array('order_id' => $tmp_order['user_order_id']))->find();
                $seller = D('Store')->field('name')->where(array('store_id' => $order_info['store_id']))->find();
                $tmp_order['seller'] = $seller['name'];
            } else {
                $tmp_order['seller'] = '本店';
            }

            $un_package_selfsale_products = $order_product->getUnPackageProducts(array('op.order_id' => $tmp_order['order_id'], 'p.store_id' => $this->store_id, 'p.supplier_id' => 0));
            if (count($un_package_selfsale_products) == 0) {
                $is_packaged = true;
            }

            $profit = M('Financial_record')->getTotal(array('order_id' => $tmp_order['order_id']));
            $cost = M('Financial_record')->getTotal(array('order_id' => $tmp_order['order_id'], 'type' => array('!=', 3), 'income' => array('<', 0)));
            $cost = abs($cost);
            if ($cost <= 0) {
                //$cost = $profit;
            }

            $tmp_order['products'] = $products;
            $tmp_order['has_my_product'] = $has_my_product;
            $tmp_order['is_supplier'] = $is_supplier;
            $tmp_order['is_packaged'] = $is_packaged;
            $tmp_order['profit'] = number_format($profit, 2, '.', '');
            //$tmp_order['cost'] = number_format($cost, 2, '.', '');
            $tmp_order['cost'] = $tmp_order['total'] - $tmp_order['postage'] - $tmp_order['profit'];
            $tmp_order['cost'] = number_format($tmp_order['cost'], 2, '.', '');

            $return = D('Return')->where(array('order_id' => $tmp_order['order_id']))->sum('product_money + postage_money');
            $tmp_order['return'] = ($return > 0) ? number_format($return, 2, '.', '') : 0;

			//订单收款方
            if (!empty($tmp_order['useStorePay'])) {
                $tmp_order['marketed_channel'] = '订单收款方：店铺收款';
				if ($tmp_order['storePay'] == $this->store_id) {
					$tmp_order['marketed_channel'] = '订单收款方：本店收款';
				}
            } else {
                $tmp_order['marketed_channel'] = '订单收款方：平台收款';
            }
			//保证扣款
			if (!empty($tmp_order['use_deposit_pay'])) {
				$tmp_order['marketed_channel'] .= " (保证金)";
			}

            if ($tmp_order['type'] != 5 && empty($this->drp_supplier_id)) {
                //查看是否有未支付的供货商订单
                $not_paid_orders = M('Order')->getNotPaidSupplierOrders($tmp_order['order_id']);
                //未支付供货商订单总额
                $not_paid_total = 0;
                if (!empty($not_paid_orders)) {
                    foreach ($not_paid_orders as $not_paid_order) {
                        $not_paid_total += $not_paid_order['total'];
                    }
                }
                $tmp_order['not_paid_total'] = number_format($not_paid_total, 2, '.', '');
                $tmp_order['not_paid_orders'] = $not_paid_orders;

                //查看保证金支付的供货商订单
                $bond_pay_orders = M('Order')->getBondPaySupplierOrders($tmp_order['order_id']);
                //保证金支付供货商订单总额
                $bond_pay_total = 0;
                if (!empty($bond_pay_orders)) {
                    foreach ($bond_pay_orders as $bond_pay_order) {
                        $bond_pay_total += $bond_pay_order['total'];
                    }
                }
                $tmp_order['bond_pay_total'] = number_format($bond_pay_total, 2, '.', '');
                $tmp_order['bond_pay_orders'] = $bond_pay_orders;
            }

            if (!empty($tmp_order['drp_team_id']) && !empty($drp_teams)) {
                $drp_team = M('Drp_team')->getDrpTeam(array('pigcms_id' => $tmp_order['drp_team_id']));
                $tmp_order['drp_team'] = $drp_team['name'];
            }

            $orders[] = $tmp_order;
            if ($tmp_order['type'] == 6) {
            	$tuan_id_arr[$tmp_order['data_id']] = $tmp_order['data_id'];
            }
        }
        
		// 检查团购订单是否结束，如果结束，可以走正常发货
		$tuan_list = array();
		if (!empty($tuan_id_arr)) {
			$tuan_list_tmp = D('Tuan')->where(array('id' => array('in', $tuan_id_arr)))->select();
			foreach ($tuan_list_tmp as $tuan) {
				$tuan_list[$tuan['id']] = $_SERVER['REQUEST_TIME'] >= $tuan['end_time'] && $tuan['operation_dateline'] > 0 ? true : false;
			}
		}

        // $results['tuan_list']=$tuan_list;
        //订单状态
        $order_status = $order->status();

        //订单状态别名
        $ws_alias_status = $order->ws_alias_status();

        //支付方式
        $payment_method = $order->getPaymentMethod();

	   // $results['ws_alias_status']=$ws_alias_status;
	   // $results['payment_method']=$payment_method;
	   // $results['status']=$order_status;
	   $orders_list=array();
	   foreach($orders as $key=>$r){
	   $orders_list[$key]['order_id']=$r['order_id'];
	   $orders_list[$key]['order_no']=$r['order_no'];
	   $orders_list[$key]['sub_total']=$r['sub_total'];
	   $orders_list[$key]['postage']=$r['postage'];
	   $orders_list[$key]['pay_money']=$r['pay_money'];
	   $orders_list[$key]['total']=$r['total'];
	   $orders_list[$key]['pro_count']=$r['pro_count'];
	   $orders_list[$key]['pro_num']=$r['pro_num'];
	   $orders_list[$key]['send_other_type']=$r['send_other_type'];
	   $orders_list[$key]['shipping_method']=$r['shipping_method'];
	   $orders_list[$key]['payment_method']=$r['payment_method'];
	   $orders_list[$key]['type']=$r['type'];
	   $orders_list[$key]['type']=$r['type'];
	   $orders_list[$key]['cancel_method']=$r['cancel_method'];
	   $orders_list[$key]['add_time']=date('Y-m-d H:i:s',$r['add_time']);
	   $orders_list[$key]['paid_time']=!empty($r['paid_time'])?  date('Y-m-d H:i:s',$r['paid_time']) :'';
	   $orders_list[$key]['status']=$r['status'];
	   foreach($r['products'] as $k=>$v){
	  $goods[$k]['product_id']=$v['product_id'];
	  $goods[$k]['name']=$v['name'];
	  $goods[$k]['image']=$v['image'];
	  $goods[$k]['pro_num']=$v['pro_num'];
	  $goods[$k]['sku_data']=$v['sku_data'];
	  $goods[$k]['pro_price']=$v['pro_price'];
	  $goods[$k]['return_status']=$v['return_status'];
	   }
	   $orders_list[$key]['products']=$goods;
	   
	   $kk=array();
	   $packages = D('Order_package')->where(array('order_id' => $r['order_id']))->select();
	   foreach($packages as $k=>$rr){
	    $kk[$k]['express_company']=$rr['express_company'];
	    $kk[$k]['express_code']=$rr['express_code'];
	    $kk[$k]['express_no']=$rr['express_no'];
	   }
	     
	   
	   $orders_list[$key]['packages']=$kk;
	   
	   
	   
	   }
	   
	   
		$results['page_count']=(string)$pages;
		$results['page_index']=(string)$page;
		$results['data']=$orders_list;
		exit(json_encode($results));
		
    }









    //取消订单
public function cancel_status()
{
    $results = array('result'=>'0','data'=>array(),'msg'=>'');
    $order = M('Order');

    $store_id = $this->store_id;
    $order_id = isset($_REQUEST['order_id']) ? intval(trim($_REQUEST['order_id'])) : 0;
    $time = time();

    $order_detail = $order->get(array('store_id' => $store_id, 'order_id' => $order_id));
    if (empty($order_detail)) {

	 $results['result']='1';
		$results['msg']='未找到相应的订单，不能取消';
		exit(json_encode($results));
 }
        //非货到付款，只有临时订单可以取消
 if ($order_detail['payment_method'] != 'codpay') {
    if ($order_detail['status'] > 1) {

		$results['result']='1';
		$results['msg']='此订单状态不正确，不能取消';
		exit(json_encode($results));
		
    }
        //货到付款订单 收货前可以取消
} else {
    if ($order_detail['status'] > 3) {
       $results['result']='1';
		$results['msg']='此订单状态不正确，不能取消';
		exit(json_encode($results));
    }
}

if ($order->cancelOrder($order_detail, 1)) {
    exit(json_encode($results));
} else {
        $results['result']='1';
		$results['msg']='取消失败';
		exit(json_encode($results));
}
}



public function save_bak()
{ $results = array('result'=>'0','data'=>array(),'msg'=>'');
    $order = M('Order');

    $order_id = isset($_REQUEST['order_id']) ? $_REQUEST['order_id'] : 0;
    $bak = isset($_REQUEST['bak']) ? trim($_REQUEST['bak']) : '';

    if ($order->setBak($order_id, $bak)) {
        exit(json_encode($results));
    } else {
   
		 $results['result']='1';
		$results['msg']='保存失败';
		exit(json_encode($results));
    }
}

   
   
  public function create_package()
   {
   
   $results = array('result'=>'0','data'=>array(),'msg'=>'');
   $store_id = $this->store_id;
    $order = M('Order');
    $fx_order = M('Fx_order');
    $order_product = M('Order_product');
    $order_package = M('Order_package');
    $sku_data = isset($_REQUEST['sku_data']) ? $_REQUEST['sku_data'] : array();
    $sku_data = join("','", $sku_data);

    $data = array();
    $data['store_id'] = $this->store_id;
    $data['order_id'] = isset($_REQUEST['order_id']) ? intval(trim($_REQUEST['order_id'])) : 0;
    $data['products'] = isset($_REQUEST['products']) ? trim($_REQUEST['products']) : 0;
    $data['express_company'] = isset($_REQUEST['express_company']) ? trim($_REQUEST['express_company']) : '';
    $data['express_no'] = isset($_REQUEST['express_no']) ? trim($_REQUEST['express_no']) : '';
    $data['express_code'] = isset($_REQUEST['express_id']) ? trim($_REQUEST['express_id']) : '';
        $data['status'] = 1; //已发货
        $data['add_time'] = time();
        $data['order_products'] = isset($_REQUEST['order_products']) ? trim($_REQUEST['order_products']) : '';

        //门店打包到配送员
        $data['physical_id'] = $this->item_store_id;
        $data['courier_id'] = isset($_REQUEST['courier']) ? intval($_REQUEST['courier']) : 0;

        if (!empty($data['products'])) {
            $data['products'] = explode(',', $data['products']);
            $data['products'] = array_unique($data['products']);
            $data['products'] = implode(',', $data['products']);
        }

        if ($data['courier_id']) {
            $whereCourier = array('order_id' => $data['order_id']);
            $order->editStatus($whereCourier, array('has_physical_send' => 1));
        }

        $tmp_product_list = explode(',', $data['products']);
        $store = D("Store")->where(array("store_id"=>$data['store_id']))->find();

        // 门店管理员 物流发货检测门店库存
        if ($this->type == 1 && $store['open_local_logistics'] == 0) {
            // echo 1;exit;
            foreach ($tmp_product_list as $key => $tmp_product_id) {
                $sku_data_arr = explode("','", $sku_data);

                if (!empty($sku_data_arr[$key])) {
                    $tmp_order_product = D('Order_product')->field('pigcms_id,pro_num,sku_id')->where(array('order_id' => $data['order_id'], 'product_id' => $tmp_product_id, 'sku_data' => $sku_data_arr[$key]))->find();
                } else {
                    $tmp_order_product = D('Order_product')->field('pigcms_id,pro_num,sku_id')->where(array('order_id' => $data['order_id'], 'product_id' => $tmp_product_id))->find();
                }

                // 判断门店库存是否足够
                $wherePq = array(
                    'store_id' => $this->drp_store_id,
                    'physical_id' => $this->item_store_id,
                    'product_id' => $tmp_product_id,
                    'sku_id' => $tmp_order_product['sku_id'],
                    );
                $temp_physical_quantity = D("Store_physical_quantity")->where($wherePq)->find();
                if (empty($temp_physical_quantity) || $temp_physical_quantity['quantity'] < $tmp_order_product['pro_num']) {
        
		$results['result']='1';
		$results['msg']='部分选中商品，本店库存不足，请补充库存后发货！';
		exit(json_encode($results));
                }

            }

        }

        if (empty($data['order_id']) || empty($data['store_id'])) {

		$results['result']='1';
		$results['msg']='参数有误，包裹创建失败！';
		exit(json_encode($results));
        }

        $order_info = $order->getOrder($data['store_id'], $data['order_id']);

        if (empty($order_info)) {
        $results['result']='1';
		$results['msg']='参数有误，包裹创建失败！';
		exit(json_encode($results));
        }
        
        if ($order_info['shipping_method'] == 'send_other' && $order_info['send_other_type'] != '2') {
        $results['result']='1';
		$results['msg']='参数有误，包裹创建失败！';
		exit(json_encode($results));
        }
        $data['user_order_id'] = !empty($order_info['user_order_id']) ? $order_info['user_order_id'] : $order_info['order_id'];
        //分销商和供货商的订单
        $where = array();
        $where['_string'] = "order_id = '" . $data['user_order_id'] . "' OR user_order_id = '" . $data['user_order_id'] . "'";
        $orders = D('Order')->field('order_id,suppliers,user_order_id,uid')->where($where)->select();

        //是否有物流
        if (!empty($_REQUEST['express_id'])) {
            $result = $order_package->add($data); //添加包裹
        } else {
            $result = true;
        }

        if ($result) {
            //货到付款同步库存
            if (strtolower($order_info['payment_method']) == 'codpay' && !empty($data['products'])) {
                $tmp_product_list = explode(',', $data['products']);
                foreach ($tmp_product_list as $key => $tmp_product_id) {
                    $sku_data_arr = explode("','", $sku_data);

                    $properties = '';
                    if (!empty($sku_data_arr[$key])) {
                        $properties = $this->_getProperty2Str($sku_data_arr[$key]);
                    }
                    if (!empty($sku_data_arr[$key])) {
                        $tmp_order_product = D('Order_product')->field('pigcms_id,pro_num')->where(array('order_id' => $data['order_id'], 'product_id' => $tmp_product_id, 'sku_data' => $sku_data_arr[$key]))->find();
                    } else {
                        $tmp_order_product = D('Order_product')->field('pigcms_id,pro_num')->where(array('order_id' => $data['order_id'], 'product_id' => $tmp_product_id))->find();
                    }
                    //退货数量
                    $return_quantity = M('Return_product')->returnNumber($data['order_id'], $tmp_order_product['pigcms_id'], true);
                    //实际购买数量
                    $quantity = $tmp_order_product['pro_num'] - $return_quantity;

                    if ($quantity <= 0) {
                        continue;
                    }

                    //更新库存
                    D('Product')->where(array('product_id' => $tmp_product_id))->setDec('quantity', $quantity);
                    if (!empty($properties)) { //更新商品属性库存
                        D('Product_sku')->where(array('product_id' => $tmp_product_id, 'properties' => $properties))->setDec('quantity', $quantity);
                    }
                    //更新销量
                    D('Product')->where(array('product_id' => $tmp_product_id))->setInc('sales', $quantity); //更新销量
                    if (!empty($properties)) { //更新商品属性销量
                        D('Product_sku')->where(array('product_id' => $tmp_product_id, 'properties' => $properties))->setInc('sales', $quantity);
                    }
                    //同步批发商品库存、销量
                    $wholesale_products = D('Product')->field('product_id')->where(array('wholesale_product_id' => $tmp_product_id))->select();
                    if (!empty($wholesale_products)) {
                        foreach ($wholesale_products as $wholesale_product) {
                            //更新库存
                            D('Product')->where(array('product_id' => $wholesale_product['product_id']))->setDec('quantity', $quantity);
                            if (!empty($properties)) { //更新商品属性库存
                                D('Product_sku')->where(array('product_id' => $wholesale_product['product_id'], 'properties' => $properties))->setDec('quantity', $quantity);
                            }
                            //更新销量
                            D('Product')->where(array('product_id' => $wholesale_product['product_id']))->setInc('sales', $quantity); //更新销量
                            if (!empty($properties)) { //更新商品属性销量
                                D('Product_sku')->where(array('product_id' => $wholesale_product['product_id'], 'properties' => $properties))->setInc('sales', $quantity);
                            }
                        }
                    }
                }
            }

            // 门店管理员 物流发货消减 门店库存
            if ($this->type == 1 && $store['open_local_logistics'] == 0) {
                // echo 2;exit;
                foreach ($tmp_product_list as $key => $tmp_product_id) {
                    $sku_data_arr = explode("','", $sku_data);

                    if (!empty($sku_data_arr[$key])) {
                        $tmp_order_product = D('Order_product')->field('pigcms_id,pro_num,sku_id')->where(array('order_id' => $data['order_id'], 'product_id' => $tmp_product_id, 'sku_data' => $sku_data_arr[$key]))->find();
                    } else {
                        $tmp_order_product = D('Order_product')->field('pigcms_id,pro_num,sku_id')->where(array('order_id' => $data['order_id'], 'product_id' => $tmp_product_id))->find();
                    }

                    // 判断门店库存是否足够
                    $wherePq = array(
                        'store_id' => $this->drp_store_id,
                        'physical_id' => $this->item_store_id,
                        'product_id' => $tmp_product_id,
                        'sku_id' => $tmp_order_product['sku_id'],
                        );
                    $temp_physical_quantity = D("Store_physical_quantity")->where($wherePq)->find();
                    D('Store_physical_quantity')->where($wherePq)->setDec('quantity', $tmp_order_product['pro_num']);

                }

            }

            $where = array();
            if (!empty($sku_data)) {
                $where['_string'] = "order_id = '" . $data['order_id'] . "' AND (product_id in (" . $data['products'] . ") OR original_product_id in (" . $data['products'] . ")) AND sku_data in ('" . $sku_data . "')";
            } else {
                $where['_string'] = "order_id = '" . $data['order_id'] . "' AND (product_id in (" . $data['products'] . ") OR original_product_id in (" . $data['products'] . "))";
            }
            $result = $order_product->setPackageInfo($where, array('is_packaged' => 1, 'in_package_status' => 1));
            if ($result) {
                //订单中含有此商品的均设置为已打包
                $where = array();
                if (!empty($sku_data)) {
                    $where['_string'] = "(order_id = '" . $data['user_order_id'] . "' OR user_order_id = '" . $data['user_order_id'] . "') AND (product_id in (" . $data['products'] . ") OR original_product_id in (" . $data['products'] . ")) AND sku_data in ('" . $sku_data . "')";
                } else {
                    $where['_string'] = "(order_id = '" . $data['user_order_id'] . "' OR user_order_id = '" . $data['user_order_id'] . "') AND (product_id in (" . $data['products'] . ") OR original_product_id in (" . $data['products'] . "))";
                }
                D('Order_product')->where($where)->data(array('is_packaged' => 1, 'in_package_status' => 1))->save();
            }

            //获取当前订单未打包的商品
            $un_package_products = $order_product->getUnPackageProducts(array('op.order_id' => $data['order_id'], 'p.store_id' => $this->store_id));
            $un_package_products = count($un_package_products);
            if ($un_package_products == 0) { //已全部打包发货
                $time = time();
                $where = array();
                $where['order_id'] = $data['order_id'];
                $where['status'] = 2;
                //当订单中的所有商品均打包，设置订单状态为已发货
                $order->editStatus($where, array('status' => 3, 'sent_time' => $time));
                //设置订单商品状态为已打包
                foreach ($orders as $tmp_order_info) {
                    //含有当前店铺发布的商品(自营或供货商商品)的订单
                    if (!empty($tmp_order_info['suppliers']) && in_array($this->store_id, explode(',', $tmp_order_info['suppliers']))) {
                        $where = array();
                        if (!empty($sku_data)) {
                            $where['_string'] = "order_id = '" . $tmp_order_info['order_id'] . "' AND (product_id in (" . $data['products'] . ") OR original_product_id in (" . $data['products'] . ")) AND sku_data in ('" . $sku_data . "')";
                        } else {
                            $where['_string'] = "order_id = '" . $tmp_order_info['order_id'] . "' AND (product_id in (" . $data['products'] . ") OR original_product_id in (" . $data['products'] . "))";
                        }

                        $order_product->setPackageInfo($where, array('is_packaged' => 1, 'in_package_status' => 1));
                    }

                    if ($tmp_order_info['user_order_id'] == 0) {
                        $main_user_info = D('User')->where(array('uid' => $tmp_order_info['uid']))->field('openid,phone')->find();
                    }
                }
                $un_package_products = $order_product->getUnPackageProducts(array('op.user_order_id' => $data['user_order_id']));
                $un_package_products = count($un_package_products);
                //所有相关订单均打包
                if ($un_package_products == 0) {
                    $where = array();
                    $where['_string'] = "(order_id = '" . $data['user_order_id'] . "' OR user_order_id = '" . $data['user_order_id'] . "') AND status = 2";
                    $order->editStatus($where, array('status' => 3, 'sent_time' => $time));

                    $fx_order->setStatus(array('user_order_id' => $data['user_order_id']), array('status' => 3, 'supplier_sent_time' => time()));

                    if ($order->getOrderCount(array('order_id' => $data['user_order_id'], 'status' => array('in', array(3, 4))))) {
                        $user_order_info = $order->get(array('order_id' => $data['user_order_id']));
                        M('Store_user_data')->upUserData($user_order_info['store_id'], $user_order_info['uid'], 'send'); //修改已发货订单数
                    }
                }
                if (!empty($order_info['fx_order_id'])) {
                    $fx_order->setPackaged($order_info['fx_order_id']); //设置分销订单状态为已打包
                }
            } else {
                //更新本店订单状态（店铺自营商品全部发货）
                /*$un_package_selfsale_products = $order_product->getUnPackageProducts(array('op.order_id' => $data['order_id'], 'p.store_id' => $this->store_id, 'p.supplier_id' => 0, 'product_id' => array('not in' , $data['products'])));
                if (count($un_package_selfsale_products) == 0) {
                    $time = time();
                    $where = array();
                    $where['order_id'] = $data['order_id'];
                    $where['status']   = 2;
                    //当订单中的所有商品均打包，设置订单状态为已发货
                    $order->editStatus($where, array('status' => 3, 'sent_time' => $time));
                }*/
            }

			//////////////////////////////////////////////////////////////////////////////////////////////////
			//产生提醒-已发货
            import('source.class.Notice');
            $express_company = $data['express_company'] ? $data['express_company'] : "";
            $express_no = $data['express_no'] ? $data['express_no']:"";
            Notice::OrderShipped($order_info, $this->store_id, $express_company, $express_no); 
			//////////////////////////////////////////////////////////////////////////////////////////////////


            //发送买家消息通知end
        exit(json_encode($results));
        } else {
        $results['result']='1';
		$results['msg']='包裹创建失败！';
		exit(json_encode($results));
        }
    }



public function express() {
      $results = array('result'=>'0','data'=>array(),'msg'=>'');
      $express = D('Express')->field('code,name')->where("status = '1'")->select();
	  $results['data']=$express;
	  exit(json_encode($results));
    }


	
   private function _getProperty2Str($sku_data)
{
    $tmp_properties = '';
    if (!empty($sku_data)) {
        $sku_data = unserialize($sku_data);
        $skus = array();
        if (is_array($sku_data)) {
            foreach ($sku_data as $sku) {
                $skus[] = $sku['pid'] . ':' . $sku['vid'];
            }
        }
        $tmp_properties = implode(';', $skus);
    }
    return $tmp_properties;
}
   
   
public function kuaidi() {
         $results = array('result'=>'0','data'=>array(),'msg'=>'');
		$type = $_REQUEST['type'];
		$express_no = $_REQUEST['express_no'];
		
		if (empty($type) || empty($express_no)) {
		
		$results['result']='1';
		$results['msg']='缺少参数！';
		exit(json_encode($results));
		
		}
		
		$express = D('Express')->where(array('code' => $type))->find();
		if (empty($express)) {
		
		$results['result']='1';
		$results['msg']='未找到相应的物流公司！';
		exit(json_encode($results));
		}
		
		$url = 'http://www.kuaidi100.com/query?type=' . $type . '&postid=' . $express_no . '&id=1&valicode=&temp=' . time() . rand(100000, 999999);
		import('class.Express');
		//$content = Http::curlGet($url);
		$content = Express::kuadi100($url);
		$content_arr = json_decode($content, true);
		
		if ($content_arr['status'] != '200') {
		
		$results['result']='1';
		$results['msg']='物流查看失败，请稍后重试！';
		exit(json_encode($results));
		
		} else {
			
		$results['data']=$content_arr['data'];
		exit(json_encode($results));
		}
	}   
   
   
       //订单详细页面
public function detail() {

$results = array('result'=>'0','data'=>array(),'msg'=>'');
    $order = M('Order');
    $order_product = M('Order_product');
    $user = M('User');
    $package = M('Order_package');

    $order_id = isset($_REQUEST['order_id']) ? intval(trim($_REQUEST['order_id'])) : 0;
	
    $order = $order->getOrder($this->store_id, $order_id);
		//预售 读取 （定金订单  或 尾款订单）
    if($order['type'] == 7) {
       if(($order['presale_order_id'] == 0) || $order['presale_order_id'] != $order['order_id'] ) {
				//当前为：定金订单 读尾款订单
        if($order['presale_order_id']) {
        $results['result']='1';
		$results['msg']='定金订单或尾款订单，暂不支持请PC端操作！';
		exit(json_encode($results));
     }
 } else {
				//当前为：尾款订单 读定金订单
    $presale_order = D('Order')->where("presale_order_id = '".$order_id ."' and type=7 and presale_order_id != order_id")->find();
				//echo D('Order')->last_sql;

}
$presale_products = $order_product->getProducts($presale_order['order_id']);
//$this->assign('presale_products', $presale_products);
//$this->assign('presale_order', $presale_order);
}
$user_order_id = !empty($order['user_order_id']) ? $order['user_order_id'] : $order['order_id'];
$user_order = D('Order')->where(array('order_id' => $user_order_id))->find();
if ($order['type'] != 5) {
            //抵现积分
    $order['cash_point'] = $user_order['cash_point'];
            //返还积分
    $order['return_point'] = $user_order['return_point'];
            //平台服务费
    $service_fee = D('Platform_margin_log')->where(array('order_id' => $user_order_id, 'type' => array('in', array(2, 3))))->sum('amount');
    $order['service_fee'] = !empty($service_fee) ? number_format(abs($service_fee), 2, '.', '') : '0.00';
}

$products = $order_product->getProducts($order_id);
$is_supplier = false;
        if (!empty($order['suppliers'])) { //订单供货商
            $suppliers = explode(',', $order['suppliers']);
            if (in_array($this->store_id, $suppliers)) {
                $is_supplier = true;
            }
        } else if (empty($order['suppliers'])) {
        	$is_supplier = true;
        }
        $order['is_supplier'] = $is_supplier;

        $comment_count = 0;
        $product_count = 0;
        $tmp_products = array();
        $is_print = false;
        foreach ($products as $product) {
            if (!empty($product['comment'])) {
                $comment_count++;
            }
            $product_count++;
            if ($product['original_product_id']) {
                $tmp_products[] = $product['original_product_id'];
            } else {
                $tmp_products[] = $product['product_id'];
            }

            if ($product['store_id'] == $this->store_id) {
                $is_print = true;
            }

            $product['subscribed_discount'] = number_format($product['subscribed_discount'], 2, '.', '');
        }

        if (empty($user_order['uid'])) {
            $order_info['buyer'] = $user_order['address_user'];
        } else {
            $user_info = M('User')->checkUser(array('uid' => $user_order['uid']));
            $order_info['buyer'] = !empty($user_info['nickname']) ? $user_info['nickname'] : $user_order['address_user'];
        }

        $status = M('Order')->status();
        $payment_method = M('Order')->getPaymentMethod();

        if (empty($order['address'])) {
            $status[0] = '未填收货地址';
        } else {
            $status[1] = '已填收货地址';
        }
        $where = array();
        $where['user_order_id'] = $user_order_id;
        $tmp_packages = $package->getPackages($where);
        $packages = array();
        foreach ($tmp_packages as $package) {
            $package_products = explode(',', $package['products']);
            if (array_intersect($package_products, $tmp_products)) {
                // 由门店配送
                if (!empty($package['physical_id'])) {
                    $physical_info = M('Store_physical')->getOne($package['physical_id']);
                    $package['physical_name'] = $physical_info["name"];
                }

                // 配送员信息
                if (!empty($package['courier_id'])) {
                    $courier_info = D("Store_physical_courier")->where(array('courier_id'=>$package['courier_id']))->find();
                    $package['courier_name'] = $courier_info["name"];
                }

                if ($package['status'] == 1) {
                    $package['status_txt'] = '未配送';
                } else if ($package['status'] == 2) {
                    $package['status_txt'] = '配送中';
                } else if ($package['status'] == 3) {
                    $package['status_txt'] = '已送达';
                }

                $packages[] = $package;
            }
        }
        import('source.class.Order');
        $order_data = Order::orderDiscount($order, $products);

        // 代付订单
        if ($order['payment_method'] == 'peerpay') {
            $order_peerpay_list = D('Order_peerpay')->where(array('order_id' => $order['order_id'], 'status' => 1))->select();
            $this->assign('order_peerpay_list', $order_peerpay_list);
        }
        // 订单来源
        if(empty($order['user_order_id'])) {
            $seller['name'] = '本店';
        } else {
            $order_info = D('Order')->field('store_id')->where(array('order_id' => $order['user_order_id']))->find();
            $seller = D('Store')->field('name')->where(array('store_id' => $order_info['store_id']))->find();
        }

		// 送他人订单
        $orderFriendCount = 0;
        $orderFriendAddress = array();
        if ($order['shipping_method'] == 'send_other') {
           $where_sql = "(`order_id` = " . $order['order_id'] . " OR `order_id` = " . $order['user_order_id'] . ")";
           $orderFriendCount = D('Order_friend_address')->where($where_sql." AND `default` = 0")->count('id');
           $orderFriendAddress = D('Order_friend_address')->where($where_sql)->select();
           foreach ($orderFriendAddress as $key => $val) {
            $addressArr = unserialize($val['address']);
            $orderFriendAddress[$key]['address'] = $addressArr;
        }
    }

		// 团购订单
    if ($order['type'] == 6) {
       $tuan = D('Tuan')->where(array('id' => $order['data_id']))->find();
       $this->assign('tuan_end', $_SERVER['REQUEST_TIME'] >= $tuan['end_time'] ? true : false);
   }



       $address['address_user']=$order['address_user'] ? $order['address_user'] :'';
       $address['address_tel']=$order['address_tel'] ? $order['address_tel'] :'';    
	   $address['address_address']=$order['address'] ? unserialize($order['address']) : array("address"=>"","province"=>"","province_code"=>"","city"=>"","city_code"=>"","area"=>"","area_code"=>"");   


	   $orders['order_id']=$order['order_id'];
	   $orders['order_no']=$order['order_no'];
	   $orders['sub_total']=$order['sub_total'];
	   $orders['postage']=$order['postage'];
	   $orders['pay_money']=$order['pay_money'];
	   $orders['total']=$order['total'];
	   $orders['pro_count']=$order['pro_count'];
	   $orders['pro_num']=$order['pro_num'];
	   $orders['send_other_type']=$order['send_other_type'];
	   $orders['shipping_method']=$order['shipping_method'];
	   $orders['payment_method']=$order['payment_method'];
	   $orders['comment']=$order['comment'];     
	   $kk=array();
	 //  $packages = D('Order_package')->where(array('order_id' => $order['order_id']))->select();
	   foreach($packages as $k=>$rr){
	    $kk[$k]['express_company']=$rr['express_company'];
	    $kk[$k]['express_code']=$rr['express_code'];
	    $kk[$k]['express_no']=$rr['express_no'];
	   }
	                        
       $orders['status']=$status[$order['status']];
	  
	   $step['add_time']=date('Y-m-d H:i:s',$order['add_time']);

	   $step['paid_time']=!empty($order['paid_time'])?date('Y-m-d H:i:s',$order['paid_time']) :'';
	   $step['sent_time']=!empty($order['sent_time'])?date('Y-m-d H:i:s',$order['sent_time']) :'';
	   $step['delivery_time']=!empty($order['delivery_time'])?  date('Y-m-d H:i:s',$order['delivery_time']) :'';
	   $step['receive_time']=!empty($order['receive_time'])?  date('Y-m-d H:i:s',$order['receive_time']) :'';
	   $step['cancel_time']=!empty($order['cancel_time'])?  date('Y-m-d H:i:s',$order['cancel_time']) :'';
	   $step['complate_time']=!empty($order['complate_time'])?  date('Y-m-d H:i:s',$order['complate_time']) :'';
	   $step['refund_time']=!empty($order['refund_time'])?  date('Y-m-d H:i:s',$order['refund_time']) :'';
	   
	   
	 
	   
	   foreach($products as $k=>$v){
	  $goods[$k]['product_id']=$v['product_id'];
	  $goods[$k]['name']=$v['name'];
	  $goods[$k]['image']=$v['image'];
	  $goods[$k]['pro_num']=$v['pro_num'];
	  $goods[$k]['sku_data']=$v['sku_data'];
	  $goods[$k]['pro_price']=$v['pro_price'];
	  $goods[$k]['return_status']=$v['return_status'];
	   }


        $results['data']['address']=$address;  
		$results['data']['order']=$orders;
		$results['data']['packages']=$kk;
		$results['data']['step']=$step; 
		$results['data']['products']=$goods;
		
		exit(json_encode($results));
   
}
   
   
   
}
