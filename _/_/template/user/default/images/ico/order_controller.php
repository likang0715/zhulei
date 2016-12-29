<?php

/**
 * 订单
 * User: pigcms_21
 * Date: 2015/2/5
 * Time: 10:42
 */
class order_controller extends base_controller {

    public function __construct() {
        parent::__construct();
        if (empty($this->store_session))
            redirect(url('index:index'));

        $this->checkRbac();
    }

    // 检查门店管理员登录下权限
    private function checkRbac () {

        $controller = MODULE_NAME;
        $action = ACTION_NAME;
        $rbacActionModel = M('Rbac_action');
        $uid = $this->user_session['uid'];
        if ($this->user_session['type'] == 1) {     //门店管理员登录

            // 禁止使用方法配置到该数组
            // $rbacBanMethod = array();
            // if (!empty($rbacBanMethod) && in_array($action, $rbacBanMethod)) {
            //     $this->rbacError();
            // }

            $rbacArray = option('physical.rbac');
            $checkRbacMethod = (isset($rbacArray[$controller]) && !empty($rbacArray[$controller])) ? array_flip($rbacArray[$controller]) : array();
            $method = $rbacActionModel->getMethod($uid, $controller, $action);
            if (in_array($action, $checkRbacMethod) && !$method) {

                // 检测默认值，空则跳转
                $rbac_link = option('physical.link');
                if ($action == 'dashboard') {
                    $where_tmp = "uid = '$uid' AND controller_id = '$controller' AND action_id IN ('".join("','", $rbac_link[$controller])."')";
                    $rbac_row = D("Rbac_action")->where($where_tmp)->order("id ASC")->find();
                    !empty($rbac_row) ? redirect(url($controller.':'.$rbac_row['action_id'])) : $this->rbacError();
                }
                $this->rbacError();
            }

        }
    }

    // 门店管理rbac权限报错
    private function rbacError () {
        header("Content-type: text/html;charset=utf-8");
        if (IS_AJAX) {
            if (IS_GET) {
                json_return(0, '您没有操作权限');
            } elseif (IS_POST) {
                json_return(0, '您没有操作权限');
            }
        } else if (IS_POST) {
            pigcms_tips('您没有操作权限！', 'none');
        } else {
            pigcms_tips('您没有操作权限！', 'none');
        }
        exit;
    }

    public function index() {
        $this->display();
    }

    public function load() {
        $action = strtolower(trim($_POST['page']));
        $status = isset($_POST['status']) ? trim($_POST['status']) : ''; //订单状态
        $shipping_method = isset($_POST['shipping_method']) ? strtolower(trim($_POST['shipping_method'])) : ''; //运送方式 快递发货 上门自提
        $payment_method = isset($_POST['payment_method']) ? strtolower(trim($_POST['payment_method'])) : ''; //支付方式
        $type = isset($_POST['type']) ? $_POST['type'] : '*'; //订单类型 普通订单 代付订单
        $orderbyfield = isset($_POST['orderbyfield']) ? trim($_POST['orderbyfield']) : '';
        $orderbymethod = isset($_POST['orderbymethod']) ? trim($_POST['orderbymethod']) : '';
        $page = isset($_POST['p']) ? intval(trim($_POST['p'])) : 1;
        $order_no = isset($_POST['order_no']) ? trim($_POST['order_no']) : '';
        $trade_no = isset($_POST['trade_no']) ? trim($_POST['trade_no']) : '';
        $user = isset($_POST['user']) ? trim($_POST['user']) : ''; //收货人
        $tel = isset($_POST['tel']) ? trim($_POST['tel']) : ''; //收货人手机
        $time_type = isset($_POST['time_type']) ? trim($_POST['time_type']) : '';
        $start_time = isset($_POST['start_time']) ? trim($_POST['start_time']) : '';
        $stop_time = isset($_POST['stop_time']) ? trim($_POST['stop_time']) : '';
        $weixin_user = isset($_POST['weixin_user']) ? trim($_POST['weixin_user']) : '';
	$activity_type = isset($_POST['activity_type']) ? trim($_POST['activity_type']) : '';
		
        $data = array(
            'status' => $status,
            'orderbyfield' => $orderbyfield,
            'orderbymethod' => $orderbymethod,
            'page' => $page,
            'order_no' => $order_no,
            'trade_no' => $trade_no,
            'user' => $user,
            'tel' => $tel,
            'time_type' => $time_type,
            'start_time' => $start_time,
            'stop_time' => $stop_time,
            'weixin_user' => $weixin_user,
            'type' => $type,
            'payment_method' => $payment_method,
            'shipping_method' => $shipping_method,
            'activity_type' => $activity_type
        );
        if (empty($action))
            pigcms_tips('非法访问！', 'none');

        switch ($action) {
            case 'dashboard_content': //订单概况
                $this->_dashboard();
                break;
            case 'statistics_content':
                $this->_statistics_content(array('start_time' => $start_time, 'stop_time' => $stop_time));
                break;
            case 'selffetch_content': //到店自提
                $this->_selffetch_content($data);
                break;
            case 'detail_content':
                $this->_detail_content();
                break;
            case 'all_content':
                $this->_all_content($data);
                break;
            case 'codpay_content':
                $this->_codpay_content($data);
                break;
            case 'buy_agent_content':
                $this->_buy_agent_content($data);
                break;
            case 'star_content':
                $this->_star_content($data);
                break;
            case 'physical_order_content':
                $this->_physical_order_content($data);
                break;
            case 'pay_agent_content':
                $this->_pay_agent_content($data);
                break;
            case 'check': case 'check_content': //对账概况
                $type_check = isset($_POST['type_check']) ? $_POST['type_check'] : 'all'; //订单类型 普通订单 代付订单
                $data['type_check'] = $type_check;
                $this->_check_content($data);
                break;
            case 'order_return_list' :
                $this->_order_return_list();
                break;
            case 'order_return_detail':
                $this->_order_return_detail();
                break;
            case 'order_rights_list' :
                $this->_order_rights_list();
                break;
            case 'order_rights_detail':
                $this->_order_rights_detail();
                break;
            default:
                break;
        }

        $this->display($_POST['page']);
    }

    //订单概况
    public function dashboard() {
        $this->display();
    }

    //订单详细
    public function detail() {
        $this->display();
    }

    //门店
    public function physical() {
        $this->display();
    }

	//订单打印
	public function print_order() {
		$order = M('Order');
		$order_product = M('Order_product');

		$order_id = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
		$order = $order->getOrder($this->store_session['store_id'], $order_id);
		
		// 重新计算邮费
		$order['postage'] = 0;
		// 取得运费值
		if ($order['fx_postage']) {
			$fx_postage_arr = unserialize($order['fx_postage']);
			if (isset($fx_postage_arr[$this->store_session['store_id']])) {
				$order['postage'] = $fx_postage_arr[$this->store_session['store_id']];
			}
		}
		
		$products = $order_product->getProductOwn(array('op.order_id' => $order_id, 'p.store_id' => $this->store_session['store_id'], 'p.supplier_id' => 0));
		//$products = $order_product->getProducts($order_id);
		
		$product_list = array();
		if ($order['user_order_id']) {
			// 有分销时，重新计算产品价格
			foreach ($products as $product) {
				$original_product_id = $product['original_product_id'];
				if (empty($product['original_product_id'])) {
					$original_product_id = $product['product_id'];
				}
				
				$product_tmp = D('Order_product')->where("order_id = '" . $order['user_order_id'] . "' AND original_product_id = '" . $original_product_id . "' AND sku_data = '" . $product['sku_data'] . "'")->field('pro_price')->order("pigcms_id ASC")->find();
				$product['pro_price'] = $product_tmp['pro_price'];
				
				$product_list[] = $product;
			}
			
			$products = $product_list;
		}
		
		// 满减/送、优惠券、折扣
		import('source.class.Order');
		$order_data = Order::orderDiscount($order, $products);
		
		//商铺二维码
		$store_id = $order['store_id'];
		$store = D('Store')->where(array('store_id' => $store_id))->find();
		if ($store) {
			$store['qcode'] = option('config.site_url') . "/source/qrcode.php?type=home&id=" . $store['store_id'];
		}

		$this->assign('order', $order);
		$this->assign('store', $store);
		$this->assign('products', $products);
		$this->assign('payment_method', $payment_method);
		$this->assign('order_data', $order_data);
		$this->display();
	}

    //订单详细页面
    private function _detail_content() {
        $order = M('Order');
        $order_product = M('Order_product');
        $user = M('User');
        $package = M('Order_package');

        $order_id = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
        $order = $order->getOrder($this->store_session['store_id'], $order_id);
        $products = $order_product->getProducts($order_id);
        if (empty($order['uid'])) {
            $order['is_fans'] = false;
            $is_fans = false;
            $order['buyer'] = '';
        } else {
            //$tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
            $order['is_fans'] = true;
            $is_fans = true;
            $user_info = $user->checkUser(array('uid' => $order['uid']));
            $order['buyer'] = $user_info['nickname'];
            $order['phone'] = $user_info['phone'];
        }

        $is_supplier = false;
        if (!empty($order['suppliers'])) { //订单供货商
            $suppliers = explode(',', $order['suppliers']);
            if (in_array($this->store_session['store_id'], $suppliers)) {
                $is_supplier = true;
            }
        }
        $order['is_supplier'] = $is_supplier;

        $comment_count = 0;
        $product_count = 0;
        $tmp_products = array();
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

        }

        $status = M('Order')->status();
        $payment_method = M('Order')->getPaymentMethod();

        if (empty($order['address'])) {
            $status[0] = '未填收货地址';
        } else {
            $status[1] = '已填收货地址';
        }
        if (!empty($order['user_order_id'])) {
            $user_order_id = $order['user_order_id'];
        } else {
            $user_order_id = $order['order_id'];
        }
        $where = array();
        $where['user_order_id'] = $user_order_id;
        $tmp_packages = $package->getPackages($where);
        // dump($tmp_packages);exit;
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
		/*
		// 查看满减送
		$order_data['order_ward_list'] = M('Order_reward')->getByOrderId($order['order_id']);
		// 使用优惠券
		$order_data['order_coupon_list'] = M('Order_coupon')->getList($order['order_id']);
		// 查看使用的折扣
		$order_discount_list = M('Order_discount')->getByOrderId($order['order_id']);
		foreach ($order_discount_list as $order_discount) {
			$order_data['order_discount_list'][$order_discount['store_id']] = $order_discount['discount'];
		}*/
		
        // 代付订单
        if ($order['payment_method'] == 'peerpay') {
            $order_peerpay_list = D('Order_peerpay')->where(array('order_id' => $order['order_id'], 'status' => 1))->select();
            $this->assign('order_peerpay_list', $order_peerpay_list);
        }
        // 订单来源
        if(empty($order['user_order_id']))
        {
            $seller['name'] = '本店';
        }
        else
        {
            $order_info = D('Order')->field('store_id')->where(array('order_id' => $order['user_order_id']))->find();
            $seller = D('Store')->field('name')->where(array('store_id' => $order_info['store_id']))->find();
        }
        // dump($packages);exit;
        $this->assign('seller', $seller['name']);
        $this->assign('is_fans', $is_fans);
        $this->assign('order', $order);
        $this->assign('products', $products);
        $this->assign('rows', $comment_count + $product_count);
        $this->assign('comment_count', $comment_count);
        $this->assign('status', $status);
        $this->assign('payment_method', $payment_method);
        $this->assign('packages', $packages);
        $this->assign('order_data', $order_data);
    }

    public function detail_json() {
        $order = M('Order');
        $order_product = M('Order_product');

        $order_id = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
        $order = $order->getOrder($this->store_session['store_id'], $order_id);
        $order['address'] = !empty($order['address']) ? unserialize($order['address']) : '';
        $tmp_products = $order_product->getProducts($order_id);
        $products = array();
        foreach ($tmp_products as $product) {
            $products[] = array(
                'product_id' => $product['product_id'],
                'name' => $product['name'],
                'price' => $product['pro_price'],
                'quantity' => $product['pro_num'],
                'skus' => !empty($product['sku_data']) ? unserialize($product['sku_data']) : '',
                'url' => $this->config['wap_site_url'] . '/good.php?id=' . $product['product_id'],
            );
        }
        $order['products'] = $products;

        // 查看满减送
        $order_ward_list = M('Order_reward')->getByOrderId($order['order_id']);
        // 使用优惠券
        $order_coupon = M('Order_coupon')->getByOrderId($order['order_id']);
        $money = 0;
        foreach ($order_ward_list as $order_ward) {
            $money += $order_ward['content']['cash'];
        }

        if (!empty($order_coupon)) {
            $money += $order_coupon['money'];
        }

        $order['reward_money'] = round($money, 2);

        echo json_encode($order);
        exit;
    }

    //订单浮动金额
    public function float_amount() {
        $order = M('Order');

        $store_id = $this->store_session['store_id'];
        $order_id = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
        $float_amoumt = isset($_POST['float_amount']) ? floatval(trim($_POST['float_amount'])) : 0;
        $postage = isset($_POST['postage']) ? floatval(trim($_POST['postage'])) : 0;
        $sub_total = isset($_POST['sub_total']) ? floatval(trim($_POST['sub_total'])) : 0;

        // 查看满减送
        $order_ward_list = M('Order_reward')->getByOrderId($order_id);
        // 使用优惠券
        $order_coupon = M('Order_coupon')->getByOrderId($order_id);
        $money = 0;
        foreach ($order_ward_list as $order_ward) {
            $money += $order_ward['content']['cash'];
        }

        if (!empty($order_coupon)) {
            $money += $order_coupon['money'];
        }

        $total = $sub_total + $postage + $float_amoumt - $money;
        $result = $order->setFields($store_id, $order_id, array('postage' => $postage, 'float_amount' => $float_amoumt, 'total' => $total));
        if ($result || $result === 0) {
            json_return(0, array('total' => $total, 'postage' => $postage));
        } else {
            json_return(1001, '修改失败！');
        }
    }

    //所有订单
    public function all() {
        $this->display();
    }

	private function _all_content($data) {
		$order = M('Order');
		$order_product = M('Order_product');
		$user = M('User');
		$where = array();
		$where['store_id'] = $this->store_session['store_id'];
		if ($data['status'] != '*') {
			$where['status'] = intval($data['status']);
		} else { //所有订单（不包含临时订单）
			$where['status'] = array('>', 0);
		}
		if ($data['order_no']) {
			$where['order_no'] = $data['order_no'];
		}
		if (is_numeric($data['type'])) {
			$where['type'] = $data['type'];
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
        $data['is_show_activity_data'] = '0';   //不显示 活动订单
        if(!$data['is_show_activity_data']) {
            $where['activity_data'] = array('is_null', "is_null");
        }
		//排序
		if (!empty($data['orderbyfield']) && !empty($data['orderbymethod'])) {
			$orderby = "`{$data['orderbyfield']}` " . $data['orderbymethod'];
		} else {
			$orderby = '`order_id` DESC';
		}
	
		
		$order_total = $order->getOrderTotal($where);
		import('source.class.user_page');
		$page = new Page($order_total, 15);
		$tmp_orders = $order->getOrders($where, $orderby, $page->firstRow, $page->listRows);
		$orders = array();
		foreach ($tmp_orders as $tmp_order) {
			$products = $order_product->getProducts($tmp_order['order_id']);
			$tmp_order['products'] = $products;
			if (empty($tmp_order['uid'])) {
				$tmp_order['is_fans'] = false;
				$tmp_order['buyer'] = '';
			} else {
				//$tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
				$tmp_order['is_fans'] = true;
				$user_info = $user->checkUser(array('uid' => $tmp_order['uid']));
				$tmp_order['buyer'] = $user_info['nickname'];
			}

			// 是否有退货未完成的申请，有未完成的申请，暂时不给完成订单
			if ($tmp_order['status'] == 7) {
				$count = D('Return')->where("order_id = '" . $tmp_order['order_id'] . "' AND status IN (1, 3, 4)")->count('id');
				$tmp_order['returning_count'] = $count;
			}


			$is_supplier = false;
            $is_packaged = false;
			if (!empty($tmp_order['suppliers'])) { //订单供货商
				$suppliers = explode(',', $tmp_order['suppliers']);
				if (in_array($this->store_session['store_id'], $suppliers)) {
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
				if (!empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id']) {
					$is_supplier = true;
				}

                //商品来源
                if (empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id']) { //本店商品
                    $from = '本店商品';
                } else if (!empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id'] && !empty($product['wholesale_product_id'])) { //批发商品
                    $from = '批发商品';
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
                    $product['profit']     = $product['pro_price'];
                    $product['cost_price'] = 0;
                }

                $product['profit']     = number_format($product['profit'], 2, '.', '');
                $product['cost_price'] = number_format($product['cost_price'], 2, '.', '');
			}

			if (!empty($tmp_order['user_order_id'])) {
				$order_info = D('Order')->field('store_id')->where(array('order_id' => $tmp_order['user_order_id']))->find();
				$seller = D('Store')->field('name')->where(array('store_id' => $order_info['store_id']))->find();
				$tmp_order['seller'] = $seller['name'];
			} else {
                $tmp_order['seller'] = '本店';
            }

			$un_package_selfsale_products = $order_product->getUnPackageProducts(array('op.order_id' => $tmp_order['order_id'], 'p.store_id' => $this->store_session['store_id'], 'p.supplier_id' => 0));
			if (count($un_package_selfsale_products) == 0) {
				$is_packaged = true;
			}

            $profit = M('Financial_record')->getTotal(array('order_id' => $tmp_order['order_id']));
            $cost = M('Financial_record')->getTotal(array('order_id' => $tmp_order['order_id'], 'income' => array('<', 0)));
            $cost = abs($cost);
            if ($cost <= 0) {
                //$cost = $profit;
            }

            $tmp_order['products']       = $products;
            $tmp_order['has_my_product'] = $has_my_product;
			$tmp_order['is_supplier']    = $is_supplier;
            $tmp_order['is_packaged']    = $is_packaged;
            $tmp_order['profit']         = number_format($profit, 2, '.', '');
            $tmp_order['cost']           = number_format($cost, 2, '.', '');
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

	//活动订单
    public function activity() {
        $this->display();
    }

	// 拷贝来自 $this->_all_content()  2016-01-04
	private function _activity_content($data) {
		$order = M('Order');
		$order_product = M('Order_product');
		$user = M('User');
		$where = array();
		$where['store_id'] = $this->store_session['store_id'];
		if ($data['status'] != '*') {
			$where['status'] = intval($data['status']);
		} else { //所有订单（不包含临时订单）
			$where['status'] = array('>', 0);
		}
		if ($data['order_no']) {
			$where['order_no'] = $data['order_no'];
		}
		if (is_numeric($data['type'])) {
			$where['type'] = $data['type'];
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
        $data['is_show_activity_data'] = '0';   //不显示 活动订单
        if(!$data['is_show_activity_data']) {
            $where['activity_data'] = array('is_null', "is_null");
        }
		
		if (!empty($data['activity_type'])) {
            $where['activity_type'] = $data['activity_type'];
        }
		
		//排序
		if (!empty($data['orderbyfield']) && !empty($data['orderbymethod'])) {
			$orderby = "`{$data['orderbyfield']}` " . $data['orderbymethod'];
		} else {
			$orderby = '`order_id` DESC';
		}
	
		
		$order_total = $order->getOrderTotal($where);
		import('source.class.user_page');
		$page = new Page($order_total, 15);
		$tmp_orders = $order->getOrders($where, $orderby, $page->firstRow, $page->listRows);
		$orders = array();
		foreach ($tmp_orders as $tmp_order) {
			$products = $order_product->getProducts($tmp_order['order_id']);
			$tmp_order['products'] = $products;
			if (empty($tmp_order['uid'])) {
				$tmp_order['is_fans'] = false;
				$tmp_order['buyer'] = '';
			} else {
				//$tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
				$tmp_order['is_fans'] = true;
				$user_info = $user->checkUser(array('uid' => $tmp_order['uid']));
				$tmp_order['buyer'] = $user_info['nickname'];
			}

			// 是否有退货未完成的申请，有未完成的申请，暂时不给完成订单
			if ($tmp_order['status'] == 7) {
				$count = D('Return')->where("order_id = '" . $tmp_order['order_id'] . "' AND status IN (1, 3, 4)")->count('id');
				$tmp_order['returning_count'] = $count;
			}


			$is_supplier = false;
            $is_packaged = false;
			if (!empty($tmp_order['suppliers'])) { //订单供货商
				$suppliers = explode(',', $tmp_order['suppliers']);
				if (in_array($this->store_session['store_id'], $suppliers)) {
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
				if (!empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id']) {
					$is_supplier = true;
				}

                //商品来源
                if (empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id']) { //本店商品
                    $from = '本店商品';
                } else if (!empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id'] && !empty($product['wholesale_product_id'])) { //批发商品
                    $from = '批发商品';
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
                    $product['profit']     = $product['pro_price'];
                    $product['cost_price'] = 0;
                }

                $product['profit']     = number_format($product['profit'], 2, '.', '');
                $product['cost_price'] = number_format($product['cost_price'], 2, '.', '');
			}

			if (!empty($tmp_order['user_order_id'])) {
				$order_info = D('Order')->field('store_id')->where(array('order_id' => $tmp_order['user_order_id']))->find();
				$seller = D('Store')->field('name')->where(array('store_id' => $order_info['store_id']))->find();
				$tmp_order['seller'] = $seller['name'];
			} else {
                $tmp_order['seller'] = '本店';
            }

			$un_package_selfsale_products = $order_product->getUnPackageProducts(array('op.order_id' => $tmp_order['order_id'], 'p.store_id' => $this->store_session['store_id'], 'p.supplier_id' => 0));
			if (count($un_package_selfsale_products) == 0) {
				$is_packaged = true;
			}

            $profit = M('Financial_record')->getTotal(array('order_id' => $tmp_order['order_id']));
            $cost = M('Financial_record')->getTotal(array('order_id' => $tmp_order['order_id'], 'income' => array('<', 0)));
            $cost = abs($cost);
            if ($cost <= 0) {
                //$cost = $profit;
            }

            $tmp_order['products']       = $products;
            $tmp_order['has_my_product'] = $has_my_product;
			$tmp_order['is_supplier']    = $is_supplier;
            $tmp_order['is_packaged']    = $is_packaged;
            $tmp_order['profit']         = number_format($profit, 2, '.', '');
            $tmp_order['cost']           = number_format($cost, 2, '.', '');
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
	
    //到店自提
    public function selffetch() {
        $this->display();
    }

    //货到付款订单 cash on delivery
    public function codpay() {
        $this->display();
    }

    //代付的订单
    public function pay_agent() {
        $this->display();
    }

    //订单概况
    public function check() {
        $this->display();
    }

    //加星订单
    public function star() {
        $this->display();
    }

    //订单概况
    private function _dashboard() {
        $order = M('Order');
        $financial_record = M('Financial_record');

        $days = array();
        for ($i = 6; $i >= 0; $i--) {
            $day = date("Y-m-d", strtotime('-' . $i . 'day'));
            $days[] = $day;
        }
        //7天下单笔数
        $where = array();
        //开始时间
        $start_time = strtotime($days[0] . ' 00:00:00');
        //结束时间
        $stop_time = strtotime($days[count($days) - 1] . '23:59:59');
        $where['store_id'] = $this->store_session['store_id'];
        $where['status'] = array('>', 0);
        $where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $stop_time . "'";
        $week_orders = $order->getOrderCount($where);

        $this->assign('start_time', date('Y-m-d H:i:s', $start_time));
        $this->assign('stop_time', date('Y-m-d H:i:s', $stop_time));

        //待付款订单数
        $not_paid_orders = $order->getOrderCount(array('store_id' => $this->store_session['store_id'], 'status' => 1));
        //待发货订单数
        $not_send_orders = $order->getOrderCount(array('store_id' => $this->store_session['store_id'], 'status' => 2));
        //已发货订单数
        $send_orders = $order->getOrderCount(array('store_id' => $this->store_session['store_id'], 'status' => 3));

        //7天收入
        $where = array();
        //开始时间
        $start_time = strtotime($days[0] . ' 00:00:00');
        //结束时间
        $stop_time = strtotime($days[count($days) - 1] . '23:59:59');
        $where['store_id'] = $this->store_session['store_id'];
        $where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $stop_time . "'";
        $days_7_income = $financial_record->getTotal($where);
        $days_7_income = number_format($days_7_income, 2, '.', '');

        //昨日下单笔数
        $where = array();
        $day = date("Y-m-d", strtotime('-1 day'));
        //开始时间
        $start_time = strtotime($day . ' 00:00:00');
        //结束时间
        $stop_time = strtotime($day . ' 23:59:59');
        $where['store_id'] = $this->store_session['store_id'];
        $where['status'] = array('>', 0);
        $where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $stop_time . "'";
        $yesterday_orders = $order->getOrderCount($where);
        $this->assign('yesterday_start_time', date('Y-m-d H:i:s', $start_time));
        $this->assign('yesterday_stop_time', date('Y-m-d H:i:s', $stop_time));

        //昨日付款订单
        $where['status'] = array('in', array(2, 3, 4));
        $where['_string'] = "paid_time >= '" . $start_time . "' AND paid_time <= '" . $stop_time . "'";
        $yesterday_paid_orders = $order->getOrderCount($where);

        //昨日发货订单
        $where['status'] = array('in', array(3, 4));
        $where['_string'] = "sent_time >= '" . $start_time . "' AND sent_time <= '" . $stop_time . "'";
        $yesterday_send_orders = $order->getOrderCount($where);

        //七天下单、付款、发货订单笔数
        $days_7_orders = array();
        $days_7_paid_orders = array();
        $days_7_send_orders = array();
        $tmp_days = array();
        foreach ($days as $day) {
            //开始时间
            $start_time = strtotime($day . ' 00:00:00');
            //结束时间
            $stop_time = strtotime($day . ' 23:59:59');
            $where = array();
            $where['store_id'] = $this->store_session['store_id'];
            $where['status'] = array('>', 0);
            $where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $stop_time . "'";
            $days_7_orders[] = $order->getOrderCount($where);

            $where = array();
            $where['store_id'] = $this->store_session['store_id'];
            $where['status'] = array('in', array(2, 3, 4));
            $where['_string'] = "paid_time >= '" . $start_time . "' AND paid_time <= '" . $stop_time . "'";
            $days_7_paid_orders[] = $order->getOrderCount($where);

            $where = array();
            $where['store_id'] = $this->store_session['store_id'];
            $where['status'] = array('in', array(3, 4));
            $where['_string'] = "sent_time >= '" . $start_time . "' AND sent_time <= '" . $stop_time . "'";
            $days_7_send_orders[] = $order->getOrderCount($where);

            $tmp_days[] = "'" . $day . "'";
        }
        $days = '[' . implode(',', $tmp_days) . ']';
        $days_7_orders = '[' . implode(',', $days_7_orders) . ']';
        $days_7_paid_orders = '[' . implode(',', $days_7_paid_orders) . ']';
        $days_7_send_orders = '[' . implode(',', $days_7_send_orders) . ']';

        $this->assign('week_orders', $week_orders);
        $this->assign('not_paid_orders', $not_paid_orders);
        $this->assign('not_send_orders', $not_send_orders);
        $this->assign('send_orders', $send_orders);
        $this->assign('yesterday_orders', $yesterday_orders);
        $this->assign('yesterday_paid_orders', $yesterday_paid_orders);
        $this->assign('yesterday_send_orders', $yesterday_send_orders);
        $this->assign('days', $days);
        $this->assign('days_7_orders', $days_7_orders);
        $this->assign('days_7_paid_orders', $days_7_paid_orders);
        $this->assign('days_7_send_orders', $days_7_send_orders);
        $this->assign('days_7_income', $days_7_income);
    }

    //到店自提
    private function _selffetch_content($data) {
        $order = M('Order');
        $order_product = M('Order_product');
        $user = M('User');
        $where = array();
        $where['store_id'] = $this->store_session['store_id'];
        $where['shipping_method'] = 'selffetch';
        if ($data['status'] != '*') {
            $where['status'] = intval($data['status']);
        } else { //所有订单（不包含临时订单）
            $where['status'] = array('>', 0);
        }
        if ($data['order_no']) {
            $where['order_no'] = $data['order_no'];
        }
        if (is_numeric($data['type'])) {
            $where['type'] = $data['type'];
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
        $order_total = $order->getOrderTotal($where);
        import('source.class.user_page');
        $page = new Page($order_total, 15);
        $tmp_orders = $order->getOrders($where, $orderby, $page->firstRow, $page->listRows);

        $orders = array();
        foreach ($tmp_orders as $tmp_order) {
            $products = $order_product->getProducts($tmp_order['order_id']);
            $tmp_order['products'] = $products;
            if (empty($tmp_order['uid'])) {
                $tmp_order['is_fans'] = false;
            } else {
                $tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
            }
            $is_supplier = false;
            if (!empty($tmp_order['suppliers'])) { //订单供货商
                $suppliers = explode(',', $tmp_order['suppliers']);
                if (in_array($this->store_session['store_id'], $suppliers)) {
                    $is_supplier = true;
                }
            }
            if (empty($tmp_order['suppliers'])) {
            	$is_supplier = true;
            }
            $tmp_order['is_supplier'] = $is_supplier;
            $has_my_product = false;
            foreach ($products as &$product) {
                $product['image'] = getAttachmentUrl($product['image']);
                if (empty($product['is_fx'])) {
                    $has_my_product = true;
                }

                //商品来源
                if (empty($product['supplier_id'])) { //本店商品
                    $from = '本店商品';
                } else if (!empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id'] && !empty($product['wholesale_product_id'])) { //批发商品
                    $from = '批发商品';
                } else { //分销商品
                    $from = '分销商品';
                }
                $product['from'] = $from;
                $product['cost_price'] = ($product['pro_price'] - $product['profit'] > 0) ? $product['pro_price'] - $product['profit'] : 0;
                if ($product['profit'] == 0 && empty($product['original_product_id'])) {
                    $product['profit']     = $product['pro_price'];
                }
                $product['cost_price'] = number_format($product['cost_price'], 2, '.', '');
            }

            $profit = M('Financial_record')->getTotal(array('order_id' => $tmp_order['order_id']));
            $cost = M('Financial_record')->getTotal(array('order_id' => $tmp_order['order_id'], 'income' => array('<', 0)));
            $cost = abs($cost);
            if ($cost <= 0) {
                $cost = $profit;
            }

            $tmp_order['products']       = $products;
            $tmp_order['has_my_product'] = $has_my_product;
            $tmp_order['profit']         = number_format($profit, 2, '.', '');
            $tmp_order['cost']           = number_format($cost, 2, '.', '');
            $orders[] = $tmp_order;
        }

        $order_status = $order->status();

        $payment_method = $order->getPaymentMethod();

        $this->assign('order_status', $order_status);
        $this->assign('status', $data['status']);
        $this->assign('payment_method', $payment_method);
        $this->assign('orders', $orders);
        $this->assign('page', $page->show());
    }

    private function _codpay_content($data) {
        $order = M('Order');
        $order_product = M('Order_product');
        $user = M('User');
        $where = array();
        $where['store_id'] = $this->store_session['store_id'];
        $where['payment_method'] = 'codpay';
        if ($data['status'] != '*') {
            $where['status'] = intval($data['status']);
        } else { //所有订单（不包含临时订单）
            $where['status'] = array('>', 0);
        }
        if ($data['order_no']) {
            $where['order_no'] = $data['order_no'];
        }
        if (is_numeric($data['type'])) {
            $where['type'] = $data['type'];
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
        $order_total = $order->getOrderTotal($where);
        import('source.class.user_page');
        $page = new Page($order_total, 15);
        $tmp_orders = $order->getOrders($where, $orderby, $page->firstRow, $page->listRows);

        $orders = array();
        foreach ($tmp_orders as $tmp_order) {
            $products = $order_product->getProducts($tmp_order['order_id']);
            $tmp_order['products'] = $products;
            if (empty($tmp_order['uid'])) {
                $tmp_order['is_fans'] = false;
                $tmp_order['buyer'] = '';
            } else {
                //$tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
                $tmp_order['is_fans'] = true;
                $user_info = $user->checkUser(array('uid' => $tmp_order['uid']));
                $tmp_order['buyer'] = $user_info['nickname'];
            }
            $is_supplier = false;
            if (!empty($tmp_order['suppliers'])) { //订单供货商
                $suppliers = explode(',', $tmp_order['suppliers']);
                if (in_array($this->store_session['store_id'], $suppliers)) {
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

                //商品来源
                if (empty($product['supplier_id'])) { //本店商品
                    $from = '本店商品';
                } else if (!empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id'] && !empty($product['wholesale_product_id'])) { //批发商品
                    $from = '批发商品';
                } else { //分销商品
                    $from = '分销商品';
                }
                $product['from'] = $from;
            }
            $tmp_order['products'] = $products;
            $tmp_order['has_my_product'] = $has_my_product;
            $orders[] = $tmp_order;
        }

        $order_status = $order->status();

        $payment_method = $order->getPaymentMethod();

        $this->assign('order_status', $order_status);
        $this->assign('status', $data['status']);
        $this->assign('payment_method', $payment_method);
        $this->assign('orders', $orders);
        $this->assign('page', $page->show());
    }

    private function _pay_agent_content($data) {
        $order = M('Order');
        $order_product = M('Order_product');
        $user = M('User');
        $where = array();
        $where['store_id'] = $this->store_session['store_id'];
        $where['type'] = 1;
        if ($data['status'] != '*') {
            $where['status'] = intval($data['status']);
        } else { //所有订单（不包含临时订单）
            $where['status'] = array('>', 0);
        }
        if ($data['order_no']) {
            $where['order_no'] = $data['order_no'];
        }
        if (is_numeric($data['type'])) {
            $where['type'] = $data['type'];
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
        $order_total = $order->getOrderTotal($where);
        import('source.class.user_page');
        $page = new Page($order_total, 15);
        $tmp_orders = $order->getOrders($where, $orderby, $page->firstRow, $page->listRows);

        $orders = array();
        foreach ($tmp_orders as $tmp_order) {
            $products = $order_product->getProducts($tmp_order['order_id']);
            $tmp_order['products'] = $products;
            if (empty($tmp_order['uid'])) {
                $tmp_order['is_fans'] = false;
                $tmp_order['buyer'] = '';
            } else {
                //$tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
                $tmp_order['is_fans'] = true;
                $user_info = $user->checkUser(array('uid' => $tmp_order['uid']));
                $tmp_order['buyer'] = $user_info['nickname'];
            }
            $is_supplier = false;
            if (!empty($tmp_order['suppliers'])) { //订单供货商
                $suppliers = explode(',', $tmp_order['suppliers']);
                if (in_array($this->store_session['store_id'], $suppliers)) {
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
            $orders[] = $tmp_order;
        }

        $order_status = $order->status();

        $payment_method = $order->getPaymentMethod();

        $this->assign('order_status', $order_status);
        $this->assign('status', $data['status']);
        $this->assign('payment_method', $payment_method);
        $this->assign('orders', $orders);
        $this->assign('page', $page->show());
    }

    private function _star_content($data) {
        $order = M('Order');
        $order_product = M('Order_product');
        $user = M('User');
        $where = array();
        $where['store_id'] = $this->store_session['store_id'];
        $where['star'] = array('>', 0);
        if ($data['status'] != '*') {
            $where['status'] = intval($data['status']);
        } else { //所有订单（不包含临时订单）
            $where['status'] = array('>', 0);
        }
        if ($data['order_no']) {
            $where['order_no'] = $data['order_no'];
        }
        if (is_numeric($data['type'])) {
            $where['type'] = $data['type'];
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
		
		// 活动订单
        if (!empty($data['activity_type'])) {
            $where['activity_type'] = $data['activity_type'];
        }
		
		// 活动订单
        if (!empty($data['activity_type'])) {
            $where['activity_type'] = $data['activity_type'];
        }
		
        //排序
        if (!empty($data['orderbyfield']) && !empty($data['orderbymethod'])) {
            $orderby = "`{$data['orderbyfield']}` " . $data['orderbymethod'];
        } else {
            $orderby = '`order_id` DESC';
        }
        $order_total = $order->getOrderTotal($where);
        import('source.class.user_page');
        $page = new Page($order_total, 15);
        $tmp_orders = $order->getOrders($where, $orderby, $page->firstRow, $page->listRows);

        $orders = array();
        foreach ($tmp_orders as $tmp_order) {
            $products = $order_product->getProducts($tmp_order['order_id']);
            $tmp_order['products'] = $products;
            if (empty($tmp_order['uid'])) {
                $tmp_order['is_fans'] = false;
                $tmp_order['buyer'] = '';
            } else {
                //$tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
                $tmp_order['is_fans'] = true;
                $user_info = $user->checkUser(array('uid' => $tmp_order['uid']));
                $tmp_order['buyer'] = $user_info['nickname'];
            }
            $is_supplier = false;
            if (!empty($tmp_order['suppliers'])) { //订单供货商
                $suppliers = explode(',', $tmp_order['suppliers']);
                if (in_array($this->store_session['store_id'], $suppliers)) {
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


                //商品来源
                if (empty($product['supplier_id'])) { //本店商品
                    $from = '本店商品';
                } else if (!empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id'] && !empty($product['wholesale_product_id'])) { //批发商品
                    $from = '批发商品';
                } else { //分销商品
                    $from = '分销商品';
                }
                $product['from'] = $from;
                $product['cost_price'] = ($product['pro_price'] - $product['profit'] > 0) ? $product['pro_price'] - $product['profit'] : 0;
                if ($product['profit'] == 0 && empty($product['supplier_id'])) {
                    $product['profit']     = $product['pro_price'];
                }
                $product['cost_price'] = number_format($product['cost_price'], 2, '.', '');
            }

            $profit = M('Financial_record')->getTotal(array('order_id' => $tmp_order['order_id']));
            $cost = M('Financial_record')->getTotal(array('order_id' => $tmp_order['order_id'], 'income' => array('<', 0)));
            $cost = abs($cost);
            if ($cost <= 0) {
                $cost = $profit;
            }

            $tmp_order['products']       = $products;
            $tmp_order['has_my_product'] = $has_my_product;
            $tmp_order['profit']         = number_format($profit, 2, '.', '');
            $tmp_order['cost']           = number_format($cost, 2, '.', '');
            $orders[] = $tmp_order;
        }

        $order_status = $order->status();

        $payment_method = $order->getPaymentMethod();

        $this->assign('order_status', $order_status);
        $this->assign('status', $data['status']);
        $this->assign('payment_method', $payment_method);
        $this->assign('orders', $orders);
        $this->assign('page', $page->show());
    }

    // 门店下 订单列表
    private function _physical_order_content($data) {

        $order = M('Order');
        $order_product = M('Order_product');
        $user = M('User');
        $where = array();
        $where['store_id'] = $this->store_session['store_id'];
        if ($data['status'] != '*') {
            $where['status'] = intval($data['status']);
        } else { //所有订单（不包含临时订单）
            $where['status'] = array('>', 0);
        }
        if ($data['order_no']) {
            $where['order_no'] = $data['order_no'];
        }
        if (is_numeric($data['type'])) {
            $where['type'] = $data['type'];
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

        //过滤为本门店
        $order_ids = M('Order_product')->getOrderByPhysical($this->user_session['item_store_id']);
        $where['order_id'] = array('in', $order_ids);

        //排序
        if (!empty($data['orderbyfield']) && !empty($data['orderbymethod'])) {
            $orderby = "`{$data['orderbyfield']}` " . $data['orderbymethod'];
        } else {
            $orderby = '`order_id` DESC';
        }
        $order_total = $order->getOrderTotal($where);
        import('source.class.user_page');
        $page = new Page($order_total, 15);
        $tmp_orders = $order->getOrders($where, $orderby, $page->firstRow, $page->listRows);
        $orders = array();

        foreach ($tmp_orders as $tmp_order) {

            $send_couriered = false;
            if ($this->user_session['type'] == 1) {         // 属于本门店的order_product
                $products = $order_product->getProductsPhysical($tmp_order['order_id'], $this->user_session['item_store_id']);

                // 门店中是否分配完
                // 该订单 该门店 是否完全打包了 order_product
                $physical_ops = $order_product->getUnAssignProducts($tmp_order['order_id'], $this->user_session['item_store_id']);
                if (empty($physical_ops)) {
                    $send_couriered = true;
                }

            } else {
                $products = $order_product->getProducts($tmp_order['order_id']);
            }

            $tmp_order['products'] = $products;
            if (empty($tmp_order['uid'])) {
                $tmp_order['is_fans'] = false;
                $tmp_order['buyer'] = '';
            } else {
                //$tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
                $tmp_order['is_fans'] = true;
                $user_info = $user->checkUser(array('uid' => $tmp_order['uid']));
                $tmp_order['buyer'] = $user_info['nickname'];
            }

            // 是否有退货未完成的申请，有未完成的申请，暂时不给完成订单
            if ($tmp_order['status'] == 7) {
                $count = D('Return')->where("order_id = '" . $tmp_order['order_id'] . "' AND status IN (1, 3, 4)")->count('id');
                $tmp_order['returning_count'] = $count;
            }

            $is_supplier = false;
            $is_packaged = false;
            if (!empty($tmp_order['suppliers'])) { //订单供货商
                $suppliers = explode(',', $tmp_order['suppliers']);
                if (in_array($this->store_session['store_id'], $suppliers)) {
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
                if (!empty($product['supplier_id']) && $product['store_id'] == $this->store_session['store_id']) {
                    $is_supplier = true;
                }
            }

            $tmp_order['products'] = $products;
            $tmp_order['has_my_product'] = $has_my_product;
            if (!empty($tmp_order['user_order_id'])) {
                $order_info = D('Order')->field('store_id')->where(array('order_id' => $tmp_order['user_order_id']))->find();
                $seller = D('Store')->field('name')->where(array('store_id' => $order_info['store_id']))->find();
                $tmp_order['seller'] = $seller['name'];
            }

            $un_package_selfsale_products = $order_product->getUnPackageProducts(array('op.order_id' => $tmp_order['order_id'], 'p.store_id' => $this->store_session['store_id'], 'p.supplier_id' => 0));
            if (count($un_package_selfsale_products) == 0) {
                $is_packaged = true;
            }
            $tmp_order['is_supplier'] = $is_supplier;
            $tmp_order['is_packaged'] = $is_packaged;
            $tmp_order['send_couriered'] = $send_couriered;
            $orders[] = $tmp_order;
        }
        // dump($orders);exit;

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

    //订单备注
    public function save_bak() {
        $order = M('Order');

        $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : 0;
        $bak = isset($_POST['bak']) ? trim($_POST['bak']) : '';

        if ($order->setBak($order_id, $bak)) {
            json_return(0, '保存成功');
        } else {
            json_return(1001, '保存失败');
        }
    }

    //订单加星
    public function add_star() {
        $order = M('Order');

        $order_id = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
        $star = isset($_POST['star']) ? intval(trim($_POST['star'])) : 0;

        if ($order->addStar($order_id, $star)) {
            json_return(0, '加星成功');
        } else {
            json_return(1001, '加星失败');
        }
    }

    //取消订单
    public function cancel_status() {
        $order = M('Order');

        $store_id = $this->store_session['store_id'];
        $order_id = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
        $time = time();

        $order_detail = $order->get(array('store_id' => $store_id, 'order_id' => $order_id));

        if ($order->cancelOrder($order_detail, 1)) {
            json_return(0, date('Y-m-d H:i:s', $time));
        } else {
            json_return(1001, date('Y-m-d H:i:s', $time));
        }
    }

    //订单统计
    public function statistics() {
        $this->display();
    }

    public function _statistics_content($data) {
        $order = M('Order');

        $days = array();
        if (empty($data['start_time']) && empty($data['stop_time'])) {
            for ($i = 7; $i >= 1; $i--) {
                $day = date("Y-m-d", strtotime('-' . $i . 'day'));
                $days[] = $day;
            }
        } else if (!empty($data['start_time']) && !empty($data['stop_time'])) {
            $start_unix_time = strtotime($data['start_time']);
            $stop_unix_time = strtotime($data['stop_time']);
            $tmp_days = round(($stop_unix_time - $start_unix_time) / 3600 / 24);
            $days = array($data['start_time']);
            if ($data['stop_time'] > $data['start_time']) {
                for ($i = 1; $i < $tmp_days; $i++) {
                    $days[] = date("Y-m-d", strtotime($data['start_time'] . ' +' . $i . 'day'));
                }
                $days[] = $data['stop_time'];
            }
        } else if (!empty($data['start_time'])) { //开始时间到后6天的数据
            $stop_time = date("Y-m-d", strtotime($data['start_time'] . ' +7 day'));
            $days = array($data['start_time']);
            for ($i = 1; $i <= 6; $i++) {
                $day = date("Y-m-d", strtotime($data['start_time'] . ' +' . $i . 'day'));
                $days[] = $day;
            }
        } else if (!empty($data['stop_time'])) { //结束时间前6天的数据
            $start_time = date("Y-m-d", strtotime($data['stop_time'] . ' -6 day'));
            $days = array($start_time);
            for ($i = 1; $i <= 6; $i++) {
                $day = date("Y-m-d", strtotime($start_time . ' +' . $i . 'day'));
                $days[] = $day;
            }
        }

        //七天下单、付款、发货订单笔数和付款金额
        $days_7_orders = array();
        $days_7_paid_orders = array();
        $days_7_send_orders = array();
        $days_7_paid_total = array();
        $tmp_days = array();
        foreach ($days as $day) {
            //开始时间
            $start_time = strtotime($day . ' 00:00:00');
            //结束时间
            $stop_time = strtotime($day . ' 23:59:59');
            $where = array();
            $where['store_id'] = $this->store_session['store_id'];
            $where['status'] = array('>', 0);
            $where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $stop_time . "'";
            $days_7_orders[] = $order->getOrderCount($where);

            $where = array();
            $where['store_id'] = $this->store_session['store_id'];
            $where['status'] = array('in', array(2, 3, 4));
            $where['_string'] = "paid_time >= '" . $start_time . "' AND paid_time <= '" . $stop_time . "'";
            $days_7_paid_orders[] = $order->getOrderCount($where);

            $where = array();
            $where['store_id'] = $this->store_session['store_id'];
            $where['status'] = array('in', array(3, 4));
            $where['_string'] = "sent_time >= '" . $start_time . "' AND sent_time <= '" . $stop_time . "'";
            $days_7_send_orders[] = $order->getOrderCount($where);

            $where = array();
            $where['store_id'] = $this->store_session['store_id'];
            $where['status'] = array('in', array(2, 3, 4));
            $where['_string'] = "paid_time >= '" . $start_time . "' AND paid_time <= '" . $stop_time . "'";
            $amount = $order->getOrderAmount($where);
            $days_7_paid_total[] = number_format($amount, 2, '.', '');

            $tmp_days[] = "'" . $day . "'";
        }
        $days = '[' . implode(',', $tmp_days) . ']';
        $days_7_orders = '[' . implode(',', $days_7_orders) . ']';
        $days_7_paid_orders = '[' . implode(',', $days_7_paid_orders) . ']';
        $days_7_send_orders = '[' . implode(',', $days_7_send_orders) . ']';
        $days_7_paid_total = '[' . implode(',', $days_7_paid_total) . ']';

        $this->assign('days', $days);
        $this->assign('days_7_orders', $days_7_orders);
        $this->assign('days_7_paid_orders', $days_7_paid_orders);
        $this->assign('days_7_send_orders', $days_7_send_orders);
        $this->assign('days_7_paid_total', $days_7_paid_total);
    }

    //商品打包
    public function package_product() {
        $order = M('Order');
        $order_product = M('Order_product');
        $express = M('Express');
        $store_physical_quantity = M('Store_physical_quantity');
        $store_physical = M('Store_physical');
        $store_id = $this->store_session['store_id'];

        //快递公司
        $express = $express->getExpress();

        $order_id = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
        $data = array();
        $order = $order->getOrder($this->store_session['store_id'], $order_id);
        $tmp_products = $order_product->getUnPackageProducts(array('op.order_id' => $order_id, 'p.store_id' => $this->store_session['store_id'], 'p.supplier_id' => 0));


        $products = array();
        foreach ($tmp_products as $tmp_product) {

            $physical = !empty($tmp_product['sp_id']) ? D('Store_physical')->where(array("pigcms_id"=>$tmp_product['sp_id']))->find() : array();
            $physical_name = !empty($physical) ? $physical['name'] : '';

            $sku_data = unserialize($tmp_product['sku_data']);
            $products[] = array(
                'order_product_id'   => $tmp_product['order_product_id'],
                'product_id'         => $tmp_product['product_id'],
                'name'               => $tmp_product['name'],
                'pro_num'            => $tmp_product['pro_num'],
                'skus'               => $sku_data,
                'physical'           => $physical_name,
                'sku_data'           => $tmp_product['sku_data']
            );
        }

        $address = unserialize($order['address']);
        $address['name'] = !empty($order['address_user']) ? $order['address_user'] : '';
        $address['tel'] = !empty($order['address_tel']) ? $order['address_tel'] : '';


        $data['address'] = $address;
        $data['products'] = $products;
        $data['express'] = $express;
        echo json_encode($data);
        exit;
    }

    //创建包裹
    public function create_package() {
        $order = M('Order');
        $fx_order = M('Fx_order');
        $order_product = M('Order_product');
        $order_package = M('Order_package');


        $sku_data                = isset($_POST['sku_data']) ? $_POST['sku_data'] : array();
        $sku_data  = join("','", $sku_data);

        $data = array();
        $data['store_id']        = $this->store_session['store_id'];
        $data['order_id']        = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
        $data['products']        = isset($_POST['products']) ? trim($_POST['products']) : 0;
        $data['express_company'] = isset($_POST['express_company']) ? trim($_POST['express_company']) : '';
        $data['express_no']      = isset($_POST['express_no']) ? trim($_POST['express_no']) : '';
        $data['express_code']    = isset($_POST['express_id']) ? trim($_POST['express_id']) : '';
        $data['status']          = 1; //已发货
        $data['add_time']        = time();
        $data['order_products']  = isset($_POST['order_products']) ? trim($_POST['order_products']) : '';

        //门店打包到配送员
        $data['physical_id']  = $this->user_session['item_store_id'];
        $data['courier_id']  = isset($_POST['courier']) ? intval($_POST['courier']) : 0;
        if (!empty($data['physical_id']) && empty($data['courier_id'])) {
            json_return(1002, '门店打包请选择配送员');
        }

        if (!empty($data['products'])) {
            $data['products'] = explode(',', $data['products']);
            $data['products'] = array_unique($data['products']);
            $data['products'] = implode(',', $data['products']);
        }

        if (empty($data['order_id']) || empty($data['store_id'])) {
            json_return(1002, '参数有误，包裹创建失败！');
        }

		$order_info = $order->getOrder($data['store_id'], $data['order_id']);

		if (empty($order_info)) {
			json_return(1002, '参数有误，包裹创建失败！');
		}

		$data['user_order_id']   = !empty($order_info['user_order_id']) ? $order_info['user_order_id'] : $order_info['order_id'];
		//分销商和供货商的订单
		$where = array();
		$where['_string'] = "order_id = '" . $data['user_order_id'] . "' OR user_order_id = '" . $data['user_order_id'] . "'";
		$orders = D('Order')->field('order_id,suppliers,user_order_id,uid')->where($where)->select();

		if ($order_package->add($data)) { //添加包裹

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

			$where = array();
			if (!empty($sku_data)) {
                $where['_string'] = "order_id = '" . $data['order_id'] . "' AND (product_id in (" . $data['products'] . ") OR original_product_id in (" . $data['products'] . ")) AND sku_data in ('" . $sku_data . "')";
            } else {
                $where['_string'] = "order_id = '" . $data['order_id'] . "' AND (product_id in (" . $data['products'] . ") OR original_product_id in (" . $data['products'] . "))";
            }

            // 打包者若为店主 则取消订单商品所属门店
            $package_data = ($this->user_session['type'] == 0) ? 
                            array('is_packaged' => 1, 'in_package_status' => 1, 'sp_id' => 0) : 
                            array('is_packaged' => 1, 'in_package_status' => 1);
            $result = $order_product->setPackageInfo($where, $package_data);

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

			$order_product->getUnPackageProducts(array('op.order_id' => $data['order_id'], 'p.store_id' => $this->store_session['store_id']));

			//获取当前订单未打包的商品
			$un_package_products = $order_product->getUnPackageProducts(array('op.order_id' => $data['order_id'], 'p.store_id' => $this->store_session['store_id']));
			$un_package_products = count($un_package_products);
			if ($un_package_products == 0) { //已全部打包发货
				$time = time();
				$where = array();
				$where['order_id'] = $data['order_id'];
				$where['status']   = 2;
				//当订单中的所有商品均打包，设置订单状态为已发货
				$order->editStatus($where, array('status' => 3, 'sent_time' => $time));
				//设置订单商品状态为已打包
				foreach ($orders as $tmp_order_info) {
					//含有当前店铺发布的商品(自营或供货商商品)的订单
					if (!empty($tmp_order_info['suppliers']) && in_array($this->store_session['store_id'], explode(',', $tmp_order_info['suppliers']))) {
						$where = array();
                        if (!empty($sku_data)) {
                            $where['_string'] = "order_id = '" . $tmp_order_info['order_id'] . "' AND (product_id in (" . $data['products'] . ") OR original_product_id in (" . $data['products'] . ")) AND sku_data in ('" . $sku_data . "')";
                        } else {
                            $where['_string'] = "order_id = '" . $tmp_order_info['order_id'] . "' AND (product_id in (" . $data['products'] . ") OR original_product_id in (" . $data['products'] . "))";
                        }
                        
                        $order_product->setPackageInfo($where, array('is_packaged' => 1, 'in_package_status' => 1));
					}
					
					if($tmp_order_info['user_order_id']==0){
						$main_user_info=D('User')->where(array('uid'=>$tmp_order_info['uid']))->field('openid,phone')->find();
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
						M('Store_user_data')->upUserData($user_order_info['store_id'],$user_order_info['uid'],'send'); //修改已发货订单数
					}
				}
				if (!empty($order_info['fx_order_id'])) {
					$fx_order->setPackaged($order_info['fx_order_id']); //设置分销订单状态为已打包
				}
			} else {
				//更新本店订单状态（店铺自营商品全部发货）
				/*$un_package_selfsale_products = $order_product->getUnPackageProducts(array('op.order_id' => $data['order_id'], 'p.store_id' => $this->store_session['store_id'], 'p.supplier_id' => 0, 'product_id' => array('not in' , $data['products'])));
				if (count($un_package_selfsale_products) == 0) {
					$time = time();
					$where = array();
					$where['order_id'] = $data['order_id'];
					$where['status']   = 2;
					//当订单中的所有商品均打包，设置订单状态为已发货
					$order->editStatus($where, array('status' => 3, 'sent_time' => $time));
				}*/
			}

            // 货单是否分配完毕
            $op_all = M('Order_product')->orderProduct($order_id, false);
            $ops = M('Order_product')->getUnPackageSkuProducts($order_id);

            if (count($ops) == 0) {     //全部分配完毕
                M('Order')->editStatus(array("order_id"=>$data['order_id']), array("is_assigned"=>2));
            } else if (count($ops) > 0 && count($ops) < count($op_all)) {
                M('Order')->editStatus(array("order_id"=>$data['order_id']), array("is_assigned"=>1));
            }
			
			if(false){
				//发送买家消息通知start
				$msg='亲，您的宝贝已发货，'.$data['express_company'].':'.$data['express_no'].'请注意查收，有问题请与本店联系！';
				$openid = $main_user_info['openid'];
				
				//发送模板消息
				import('source.class.Factory');
				import('source.class.MessageFactory');
				$template_data = array(
						'wecha_id' => $openid,
						'first'    => '亲，您的宝贝已发货,请注意查收，有问题请与本店联系！',
						'keyword1' => $order_info['order_no'],
						'keyword2' => $data['express_company'],
						'keyword3' => $data['express_no'],
						'remark'   => '状态：' . "已发货"
				);
				$params['template'] = array('template_id' => 'OPENTM200565259', 'template_data' => $template_data);
				$mobile = $order_info['address_tel'];
				$date = date('Y-m-d H:i:s', time());
				$params['sms'] = array('mobile'=>$mobile,'token'=>'test','content'=>$msg,'sendType'=>1);
				MessageFactory::method($params, array('smsMessage', 'TemplateMessage'));
				//发送买家消息通知end
			}
			
			json_return(0, '包裹创建成功');
		} else {
			json_return(1001, '包裹创建失败');
		}
	}

    //分配订单商品(包裹)到门店
    public function package_product_physical() {

        $order_id = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
        $store_id = $this->store_session['store_id'];

        $order = M('Order');
        $order_product = M('Order_product');
        $store_physical = M('Store_physical');
        $store_physical_quantity = M('Store_physical_quantity');

        $physicals = $store_physical->getList($store_id);
        if (empty($physicals)) {
            json_return(1,'请先添加门店');
        }

        $data = array();
        $order = $order->getOrder($store_id, $order_id);

        // 自提订单 货到付款订单 不分配
        if ($order['payment_method'] == 'codpay' || $order['shipping_method'] == 'selffetch') {
            json_return(1,'货到付款或自提订单不支持门店配送');
        }

        // 过滤已经分配到门店的包裹
        $tmp_products = $order_product->getUnPackageSkuProducts($order_id);

        //门店
        $data['physical'] = D('Store_physical')->where(array('store_id'=>$this->store_session['store_id']))->select();

        $products = array();
        foreach ($tmp_products as $tmp_product) {
            
            if (!empty($data['physical'])) {

                $physical = $data['physical'];

                foreach ($physical as $k => $v) {

                    $where = array(
                        'product_id'=>$tmp_product['product_id'], 
                        'sku_id'=>$tmp_product['sku_id'],
                        'physical_id'=>$v['pigcms_id'],
                    );
                    $quantity = D('Store_physical_quantity')->where($where)->find();
                    $physical[$k]['quantity'] =  !empty($quantity) ? $quantity['quantity'] : 0;

                }

            }

            $sku_data = unserialize($tmp_product['sku_data']);
            $products[] = array(
                'order_product_id'   => $tmp_product['order_product_id'],
                'product_id'         => $tmp_product['product_id'],
                'name'               => $tmp_product['name'],
                'pro_num'            => $tmp_product['pro_num'],
                'skus'               => $sku_data,
                'physical'           => $physical,
                'sku_data'           => $tmp_product['sku_data']
            );
        }

        $address = unserialize($order['address']);
        $address['name'] = !empty($order['address_user']) ? $order['address_user'] : '';
        $address['tel'] = !empty($order['address_tel']) ? $order['address_tel'] : '';

        $data['physicals_desc'] = array();
        $data['baidu_map'] = array();

        $address['address'] = str_replace(' ', '', $address['address']);

        //收货地址换取坐标
        import('Http');
        $http_class = new Http();
        $url = "http://api.map.baidu.com/place/v2/search?q=".$address['address']."&region=".$address['city']."&output=json&ak=4c1bb2055e24296bbaef36574877b4e2";
        $map_json = $http_class->curlGet($url);
        $address_map = json_decode($map_json, true);

        if ($map_json && !empty($address_map['results'])) {
            reset($address_map['results']) & $first = current($address_map['results']);
            $data['baidu_map'] = $first;
            $store_list = $store_physical->nearshops($first['location']['lng'],$first['location']['lat'],$store_id);
            $data['physicals_desc'] = $store_list;
        }

        $data['address'] = $address;
        $data['products'] = $products;
        $data['express'] = $express;
        echo json_encode($data);
        exit;
    }

    //保存分配货单到门店
    public function product_physical_save() {

        $store_id = $this->store_session['store_id'];
        $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : 0;
        $physical_id = isset($_POST['physical_id']) ? $_POST['physical_id'] : 0;

        $order_products = isset($_POST['order_products']) ? $_POST['order_products'] : array();

        if (empty($order_id) || empty($order_products)) {
            json_return(1001, '缺少参数，修改失败');
        }

        foreach ($order_products as $order_product) {
            $where = array('pigcms_id'=>$order_product, 'order_id'=>$order_id);
            M('Order_product')->setPackageInfo($where, array('sp_id'=>$physical_id));

            // 消减库存
            $op_info = M('Order_product')->getProduct($order_product);
            D('Store_physical_quantity')->where(array('product_id' => $op_info['product_id'], 'sku_id' => $op_info['sku_id'], 'physical_id' => $physical_id))->setDec('quantity', $op_info['pro_num']);
        }

        $op_all = M('Order_product')->orderProduct($order_id, false);

        $ops = M('Order_product')->getUnPackageSkuProducts($order_id);
        if (count($ops) == 0) {     //全部分配完毕
            M('Order')->editStatus(array("order_id"=>$order_id), array("is_assigned"=>2));
        } else if (count($ops) > 0 && count($ops) < count($op_all)) {
            M('Order')->editStatus(array("order_id"=>$order_id), array("is_assigned"=>1));
        }

		json_return(0, '分配订单商品到门店成功');
	}

    //ajax弹层 门店获取发货单
    public function package_product_phy() {

        //获取 order_product sp_id = physical_id项
        $order_id = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
        if ($order_id == 0) 
            json_return(1001, '缺少参数!');
        if ($this->user_session['item_store_id'] == 0)
            json_return(1001, '参数异常，请用门店管理员登录');
        
        $physical_id = $this->user_session['item_store_id'];

        $order = M('Order');
        $order_product = M('Order_product');
        $express = M('Express');


        //快递公司
        $express = $express->getExpress();

        $data = array();

        //获取配送员
        // $data['courier'] = M('User')->getList(array('type'=>2, 'item_store_id'=>$physical_id));
        $data['courier'] = D('Store_physical_courier')->where(array('physical_id'=>$physical_id, 'status'=>1))->select();
        if (empty($data['courier'])) {
            json_return(1001, '请先为本店绑定并添加配送员');
        }
        

        $order = $order->getOrder($this->store_session['store_id'], $order_id);
        $tmp_products = $order_product->getUnAssignProducts($order_id, $this->user_session['item_store_id']);
        $products = array();
        foreach ($tmp_products as $tmp_product) {
            $sku_data = unserialize($tmp_product['sku_data']);
            $products[] = array(
                'order_product_id'   => $tmp_product['order_product_id'],
                'product_id'         => $tmp_product['product_id'],
                'name'               => $tmp_product['name'],
                'pro_num'            => $tmp_product['pro_num'],
                'skus'               => $sku_data,
                'sku_data'           => $tmp_product['sku_data']
            );
        }
        $address = unserialize($order['address']);
        $address['name'] = !empty($order['address_user']) ? $order['address_user'] : '';
        $address['tel'] = !empty($order['address_tel']) ? $order['address_tel'] : '';
        $data['address'] = $address;
        $data['products'] = $products;
        $data['express'] = $express;
        echo json_encode($data);
        exit;
    }

	//交易完成
	public function complate_status() {
		if (IS_POST) {
			$order            = M('Order');
			$order_product    = M('Order_product');
			$fx_order         = M('Fx_order');
			$financial_record = M('Financial_record');
			$return           = M('Return');
			$return_product   = M('Return_product');

			$store_id   = !empty($this->store_session['store_id']) ? $this->store_session['store_id'] : 0;
			$order_id   = isset($_POST['order_id']) ? intval(trim($_POST['order_id'])) : 0;
            $offline    = false; //是否是货到付款订单
			$order_info = $order->getOrder($store_id, $order_id);

			if (empty($store_id)) {
				json_return(1001, '参数异常，店铺不存在');
			}
			if (empty($order_info)) {
				json_return(1001, '参数异常，订单不存在');
			} else if ($order_info['status'] != 7 && $order_info['status'] != 6) {
				$config_order_return_date = option('config.order_return_date');
                $config_order_complete_date = option('config.order_complete_date');
                if ((($order_info['status'] == 7 && ($order_info['delivery_time'] + $config_order_return_date * 24 * 3600 < time() || $order_info['sent_time'] + $config_order_complete_date * 24 * 3600 < time())) || ($order_info['status'] == 3 && $order_info['sent_time'] + $config_order_complete_date * 24 * 3600 < time())) && $order_info['returning_count'] == 0) {
                    
                } else {
                    json_return(1001, '订单状态不正确，交易无法完成');
                }
			}

			//退货中的订单
			$returning  = $return->getOrderReturning($order_id);
			if (!empty($returning)) {
				json_return(1001, '订单退货中，交易无法完成');
			}

            //是否是货到付款订单
            if (!empty($order_info['payment_method']) && strtolower($order_info['payment_method']) == 'offline') {
                $offline = true;
            }

			//订单下的退货列表
			$tmp_returns = $return->getReturns($order_id);
			$returns = array();
			foreach ($tmp_returns as $tmp_return) {
				$returns[] = !empty($tmp_return['user_return_id']) ? $tmp_return['user_return_id'] : $tmp_return['id'];
			}

			$now = time();
			$where = array();
			$where['order_id'] = $order_id;
			$where['store_id'] = $store_id;
			//$where['status']   = 7; //已收货
			$data = array();
			$data['status']        = 4;
			$data['complate_time'] = $now;

			//修改订单状态
			if ($order->editStatus($where, $data)) {
			//if (true) {
				//修改分销订单状态
				$fx_order->setStatus(array('fx_order_id' => $order_info['fx_order_id']), array('status' => 4, 'complate_time' => $now));

				//是否有分销订单
				$has_fx_order = false;
				if (!empty($order_info['user_order_id'])) { //分销订单
					$where = array();
					$where['_string'] = "(order_id = '" . $order_info['user_order_id'] . "' OR user_order_id = '" . $order_info['user_order_id'] . "')";
					//当前订单以及相关分销订单
					$orders = $order->getAllOrders($where, 'order_id ASC');
					$has_fx_order = true;
					$user_order_id = $order_info['user_order_id'];
				} else {
					$where = array();
					$where['order_id'] = $order_id;
					//当前订单
					$orders = $order->getAllOrders($where, 'order_id DESC');
					$user_order_id = $order_id;
				}

				if (!empty($orders)) {

					if (!$has_fx_order) { //无分销订单
						//自营商品收入
						$sub_total = D('Order_product')->where(array('order_id' => $order_id, 'original_product_id' => 0))->sum('pro_price * pro_num');
						//运费
						$postage = !empty($order_info['fx_postage']) ? unserialize($order_info['fx_postage']) : 0;
						if (!empty($postage)) {
							$postage = !empty($postage[$store_id]) ? $postage[$store_id] : 0;
						} else if (empty($postage) && ($order_info['postage'] > 0)) {
							$postage = $order_info['postage'];
						}
						//自营商品 + 运费
						$income        = $sub_total + $postage;
						$new_income    = $income;
						$return_amount = 0;

						//更新供货商店铺收入
						$this->_update_store_income($store_id, $order_id, $income, $new_income, $return_amount, $offline);

					} else { //有分销订单

						//分销商商品利润
						$seller_product_profit = 0;
						//退货商品
						$return_products = $return_product->getReturnProducts($returns);
						if (!empty($return_products)) {
							//分销商利润
							$stores_profit = array();
							foreach ($return_products as $tmp_return_product) {
								$order_product_info = $order_product->getProduct($tmp_return_product['order_product_id']);
								//分销商/经销商(减商品利润)
								if ($order_product_info['store_id'] != $store_id) {
									//单件商品利润
									if (!empty($order_product_info['profit'])) {
										$profit = $order_product_info['profit'] * $tmp_return_product['pro_num']; //利润x数量
									} else if (empty($order_product_info['original_product_id'])) {
										$profit = $order_product_info['pro_price'] * $tmp_return_product['pro_num']; //成本x数量
									}
									if ($profit > 0) {
										$stores_profit[$order_product_info['store_id']] += $profit;
										$seller_product_profit += $profit;
									}
								}
							}
						}

						foreach ($orders as $tmp_order) {

							if ($tmp_order['store_id'] == $store_id) { //当前店铺订单(供货商)

								//订单收入
                                $income = $financial_record->getOrderProfit($tmp_order['order_id']);
								//收回分销商商品利润
								if ($seller_product_profit > 0) {
									$new_income    = $income + $seller_product_profit;
									$return_amount = 0;

									//更新收支记录
									$financial_record->setOrderIncomeInc($tmp_order['order_id'], $seller_product_profit);
								} else {
									$new_income    = $income;
									$return_amount = 0;
								}
                                //更新供货商店铺收入
                                $this->_update_store_income($tmp_order['store_id'], $tmp_order['order_id'], $income, $new_income, $return_amount, $offline);
                                break;
							} else { //分销商店铺订单
								//退款金额
								$return_amount = 0;
								//退款后收入
								$new_income    = 0;
								//订单收入
								$income = $financial_record->getOrderProfit($tmp_order['order_id']);
								//订单收入 - 退货金额
								if (!empty($stores_profit[$tmp_order['store_id']]) && $stores_profit[$tmp_order['store_id']] > 0) {
									$return_amount = $stores_profit[$tmp_order['store_id']];
									$new_income    = $income - $return_amount;
								} else {
									$new_income = ($new_income > 0) ? $new_income : $income;
								}

								//供货链
								$supply_chain = D('Store_supplier')->field('supply_chain')->where(array('seller_id' => $tmp_order['store_id']))->find();
								$chain = array();
								if (!empty($supply_chain['supply_chain'])) {
									$chain = explode(',', $supply_chain['supply_chain']);
								}
								//排他分销
								if (!empty($chain) && in_array($store_id, $chain)) {
									$where = array();
									$where['order_id'] = $tmp_order['order_id'];
									$where['store_id'] = $tmp_order['store_id'];
									$where['status'] = 7; //已收货
									$data = array();
									$data['status'] = 4; //已完成
									$data['complate_time'] = $now;
									//echo $tmp_order['store_id'] . '-' . $tmp_order['order_id'] . '-' . $new_income . "\n";
									if ($order->editStatus($where, $data)) {
										$where = array();
										$where['order_id'] = $tmp_order['order_id'];
										$where['store_id'] = $tmp_order['store_id'];
										$data = array();
										$data['status'] = 3;
										$data['complate_time'] = $now;
										$fx_order->setStatus($where, $data);

										//修改分销订单状态
										$fx_order->setStatus(array('order_id' => $tmp_order['order_id']), array('status' => 4, 'complate_time' => $now));
									}
								}
                                //更新供货商店铺收入
                                $this->_update_store_income($tmp_order['store_id'], $tmp_order['order_id'], $income, $new_income, $return_amount, $offline);
							}
							//echo $tmp_order['store_id'] . '-' . $tmp_order['order_id'] . '-' . $return_amount . "\n";
						}
					}

					//修改已完成订单数
					if ($order->getOrderCount(array('order_id' => $user_order_id, 'status' => 4))) {
						$user_order_info = $order->get(array('order_id' => $user_order_id));
						M('Store_user_data')->upUserData($user_order_info['store_id'],$user_order_info['uid'],'complete');
					}

				} else {
					json_return(1001, '参数异常，订单不存在');
				}
				json_return(0, '订单交易完成');
			} else {
				json_return(1001, '订单状态修改失败');
			}
		}
	}

	/**
	 * 更新店铺收入
	 * @param $store_id
	 * @param $order_id
	 * @param $income
	 * @param $new_income
	 */
	private function _update_store_income($store_id, $order_id, $income, $new_income, $return_amount, $offline)
	{
        //货到付款不处理供货商收入
        if (!empty($offline) && $store_id == $this->store_session['store_id']) {
            return true;
        }
		//更新店铺收入
		if ($return_amount > 0) {
			D('Store')->where(array('store_id' => $store_id))->setDec('income', $return_amount);
		}
		//更新店铺不可用余额
		if ($income > 0) {
			D('Store')->where(array('store_id' => $store_id))->setDec('unbalance', $income);
		}
		//更新店铺可提现余额
		if ($new_income > 0) {
			D('Store')->where(array('store_id' => $store_id))->setInc('balance', $new_income);
		}

		//更新订单状态为已完成
		$where = array();
		$where['order_id'] = $order_id;
		$where['store_id'] = $store_id;
		$where['status']   = 1;
		$data = array();
		$data['status']    = 3; //交易完成
		M('Financial_record')->editStatus($where, $data);
        return true;
	}

	public function test1() {


		$order = M('Order');
		$order_id = "4682";
		$order_info = $order->getOrder($this->store_session['store_id'], $order_id);

		$uid = $order_info['uid'];


		//根据店铺  送积分
		$sub_total = $order_info['sub_total'];
		echo "订单金额：".$sub_total;//exit;
		$store_id = $order_info['store_id'];
		$points_model = M('Points');
		$points_detail = $points_model->getList(array('store_id' => $store_id));
		if($points_detail) {
			foreach($points_detail as $k => $v) {
				if($v['type'] == '3') {//根据店铺  送积分
					$spoints[$k] = $v['trade_or_amount'];
				}
			}
			//购买金额的金额最低限制 送积分
			$datas = array(
				'uid' => $uid,
				'store_id' => $this->store_session['store_id'],
				'timestamp' => time(),
				'order_id' => $order_id

			);

			$isSign = false;	//标记是否符合 赠送要求
			if(count($spoints) > 0) {
				$point_detail_by_amount = D('Points')->where("store_id = '".$store_id."' and type='3' and (trade_or_amount < ".$sub_total ." or trade_or_amount = ".$sub_total.")")->order("trade_or_amount desc")->limit(1)->find();
				if(count($point_detail_by_amount)) {
					$datas['points'] = $point_detail_by_amount['trade_or_amount'];
					$datas['type'] = '3';
					$datas['is_call_to_fans'] = $point_detail_by_amount['is_call_to_fans'];
					$isSign = true;
					if($point_detail_by_amount['is_call_to_fans']) $this->_sendnotice($datas);
				}
			}
			if($isSign) {
				M('User_points_record')->add($datas);
				//更新买家与商铺间积分关系
				M('User_points_by_store')->updatepoints($uid,$store_id,$datas['points']);
			}

		}
	}

	//发送通知积分
	private function _sendnotice($data) {

		if(!$data['type']) return false;

		switch($data['type']) {
			//关注微信
			case '1':	break;
			//成功交易数量
			case '2':	break;
			//购买金额达到多少
			case '3':
				$openid = "opCRPuKTtHgVy_PJOfCQt7FNqFXg";
				//发送模板消息
				import('source.class.Factory');
				import('source.class.MessageFactory');

				$template_data = array(
						'wecha_id' => $openid,
						'first'    => '这是积分发放成功，恭喜您成为 。',
						'keyword1' => "这是一个name",
						'keyword2' => "13856905308",
						'keyword3' => date('Y-m-d H:i:s', time()),
						'remark'   => '状态：' . "啥状态？"
				);
				$params['template'] = array('template_id' => 'OPENTM201752540', 'template_data' => $template_data);
				MessageFactory::method($params, array('TemplateMessage'));
				break;
		}

	}


   //订单概况
	private function _check_content($data) {
        $page = $_REQUEST['p'] + 0;
        $page = max(1, $page);
        $type = $_REQUEST['type_check'];
        $keyword = $_REQUEST['keyword'];
        $limit = 1;
        
        $order = M('Order');
        $order_product = M('Order_product');
        $user = M('User');
        $where = array();
        $where['status'] = array('in', array('4'));
        switch ($type) {

            case 'check':
                $data['is_check'] = 2;
                break;

            case 'uncheck':
                $data['is_check'] = 1;
                break;
            case 'uncomplete_order':
           		$where['status'] = array('in', array('7'));
        }

        
        $where['store_id'] = $this->store_session['store_id'];


        
        if ($data['is_check'])
            $where['is_check'] = $data['is_check'];


        if ($data['order_no']) {
            $where['order_no'] = $data['order_no'];
        }
        if (is_numeric($data['type'])) {
            $where['type'] = $data['type'];
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

        $order_total = $order->getOrderTotal($where);

        import('source.class.user_page');
        $page = new Page($order_total, 15);
        $tmp_orders = $order->getOrders($where, $orderby, $page->firstRow, $page->listRows);

        $orders = array();



        foreach ($tmp_orders as $tmp_order) {
            $products = $order_product->getProducts($tmp_order['order_id']);
            $tmp_order['products'] = $products;
            if (empty($tmp_order['uid'])) {
                $tmp_order['is_fans'] = false;
                $tmp_order['buyer'] = '';
            } else {
                //$tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
                $tmp_order['is_fans'] = true;
                $user_info = $user->checkUser(array('uid' => $tmp_order['uid']));
                $tmp_order['buyer'] = $user_info['nickname'];
            }
            $is_supplier = false;
            if (!empty($tmp_order['suppliers'])) { //订单供货商
                $suppliers = explode(',', $tmp_order['suppliers']);
                if (in_array($this->store_session['store_id'], $suppliers)) {
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



        //	$this->assign('type', $type);
        //	$this->assign('pages', $pages);
        //	$this->assign('unique_person_have', $unique_person_have);
        //	$this->assign('keyword', $keyword);
        //	$this->assign('coupon_list', $coupon_list);
    }

    /**
     * 更改到店自提状态
     */
    public function selffetch_status() {
        $order_id = $_GET['order_id'];
        if (empty($order_id)) {
            json_return(1001, '更改失败，缺少参数');
        }

        $order = M('Order')->getOrder($this->store_session['store_id'], $order_id);
        if (empty($order)) {
            json_return(1001, '未找到要更改的订单');
        }

        if ($order['shipping_method'] != 'selffetch') {
            $buyer_selffetch_name = $this->store_session['buyer_selffetch_name'] ? $this->store_session['buyer_selffetch_name'] : '到店自提';
            json_return(1001, '此订单不是' . $buyer_selffetch_name . '订单，不能更改');
        }

        if ($order['status'] != 2) {
            json_return(1001, '更改失败，订单状态不正确');
        }

        $data = array();
        $data['sent_time'] = time();
        $data['delivery_time'] = time();
        $data['status'] = 7;
        $result = D('Order')->where(array('order_id' => $order_id))->data($data)->save();
        if ($result) {
            json_return(0, '操作成功');
        } else {
            json_return(1001, '操作失败');
        }
    }

    /**
     * 退货管理
     */
    public function order_return() {
        $this->display();
    }

    /**
     * 退货列表
     */
    private function _order_return_list() {
        $store_id = $_SESSION['store']['store_id'];
        $return_model = M('Return');
        $count = $return_model->getCount("store_id = '" . $store_id . "'");
        $page = max(1, $_GET['page']);

        $return_list = array();
        $pages = '';
        if ($count > 0) {
            $limit = 15;
            $page = min($page, ceil($count / $limit));
            $offset = ($page - 1) * $limit;

            $return_list = $return_model->getList("r.store_id = '" . $store_id . "'", $limit, $offset);
            import('source.class.user_page');
            $pages = new Page($order_total, 15, $page);
        }

        $this->assign('return_list', $return_list);
        $this->assign('pages', $pages);
    }

	/**
	 * 退货详情
	 */
	private function _order_return_detail() {
		$id = $_POST['id'];
		$order_no = $_POST['order_no'];
		$pigcms_id = $_POST['pigcms_id'];
		$store_id = $_SESSION['store']['store_id'];

		if (empty($id) && (empty($order_no) || empty($pigcms_id))) {
			echo '缺少参数！';
			exit;
		}

		$return = array();
		if (!empty($id)) {
			$return = M('Return')->getById($id);
		} else {
			$order_no = trim($order_no, option('config.orderid_prefix'));
			$where = "r.order_no = '" . $order_no . "' AND rp.order_product_id = '" . $pigcms_id . "'";
			$return_list = M('Return')->getList($where);

			if ($return_list) {
				$return = $return_list[0];
			}
		}

		//$return = M('Return')->getById($id);
		if (empty($return)) {
			echo '未找到相应的退货申请';
			exit;
		}

		if (empty($id) && !empty($order_no) && !empty($pigcms_id)) {
			echo json_encode(array('status' => true, 'msg' => $return['id']));
			exit;
		}

		if ($return['store_id'] != $_SESSION['store']['store_id']) {
			echo '您无权查看此退货申请';
			exit;
		}
		// 查找订单
		$order = D('Order')->where("(order_id = '" . $return['order_id'] . "' or user_order_id = '" . $return['order_id'] . "') and store_id = '" . $store_id . "'")->find();

		if (empty($order)) {
			echo '未查到相应的订单';
			exit;
		}
		$order = M('Order')->find(option('config.orderid_prefix') . $order['order_no']);
		
		/*// 查看满减送
		$order_data['order_ward_list'] = M('Order_reward')->getByOrderId($order['order_id']);
		// 使用优惠券
		$order_data['order_coupon_list'] = M('Order_coupon')->getList($order['order_id']);
		// 查看使用的折扣
		$order_discount_list = M('Order_discount')->getByOrderId($order['order_id']);
		foreach ($order_discount_list as $order_discount) {
			$order_data['order_discount_list'][$order_discount['store_id']] = $order_discount['discount'];
		}*/
		
		// 相关折扣、满减、优惠
		import('source.class.Order');
		$order_data = Order::orderDiscount($order);
		$discount_money = 0;
		
		// 计算出每级此产品的分销利润
		if ($return['is_fx'] == 0) {
			$return_list = M('Return')->getProfit($return);
			$this->assign('return_list', $return_list);
			
			// 查看此退货商品折扣金额
			$product = D('Order_product')->where("pigcms_id = '" . $return['order_product_id'] . "'")->find();
			$tmp_order_data = Order::orderDiscount($order, array(0 => $product));
			$discount_money = $tmp_order_data['discount_money'];
		}
		
		$this->assign('order', $order);
		$this->assign('return', $return);
		$this->assign('order_data', $order_data);
		$this->assign('discount_money', $discount_money);
	}

	/**
	 * 退单
	 */
	public function return_save() {
		$id = $_POST['id'];
		$store_id = $_SESSION['store']['store_id'];
		$status = $_POST['status'];
		$store_content = $_POST['store_content'];
		$product_money = $_POST['product_money'] + 0;
		$postage_money = $_POST['postage_money'] + 0;
		$address_user = $_POST['address_user'];
		$address_tel = $_POST['address_tel'];
		$provinceId_m = $_POST['provinceId_m'];
		$cityId_m = $_POST['cityId_m'];
		$areaId_m = $_POST['areaId_m'];
		$address = $_POST['address'];

		if (!in_array($status, array(2, 3))) {
			json_return(1001, '参数错误');
		}

		$return = M('Return')->getById($id);
		if (empty($return)) {
			json_return(1001, '未找到相应的退货申请');
		}
		if ($return['store_id'] != $_SESSION['store']['store_id'] || $return['is_fx'] != '0') {
			json_return(1001, '您无权操作此退货申请');
		}
		// 查找订单
		$order = D('Order')->where("(order_id = '" . $return['order_id'] . "' or user_order_id = '" . $return['order_id'] . "') and store_id = '" . $store_id . "'")->find();

		if (empty($order)) {
			json_return(1001, '未查到相应的订单');
		}

		if ($status == '2') {
			if (empty($store_content)) {
				json_return(1001, '不同意退货理由不能为空，请填写');
			}
		} else {
			if (empty($product_money) || $product_money <= 0) {
				json_return(1001, '请正确填写退货金额');
			}

			if ($order['status'] != 2 && $order['status'] != 6) {
				if (empty($address_user)) {
					json_return(1001, '请填写收货人姓名');
				}

				if (empty($address_tel)) {
					json_return(1001, '请填写收货人电话');
				}

				if (!preg_match("/\d{5,12}$/", $address_tel)) {
					json_return(1001, '手机号格式不正确，请正确填写');
				}

				if (empty($provinceId_m) || empty($cityId_m) || empty($areaId_m)) {
					json_return(1001, '请选择省份、城市、地区信息');
				}

				if (empty($address)) {
					json_return(1001, '请填写所在街道');
				}

				if (mb_strlen($address, 'utf-8') < 1 || mb_strlen($address, 'utf-8') > 120) {
					json_return(1001, '所在街道字数范围为1-120，请正确填写');
				}
			}
		}

		if ($status == '2') {
			$data = array();
			$data['status'] = 2;
			$data['cancel_dateline'] = time();
			$data['store_content'] = $store_content;

			if ($return['user_return_id']) {
				$result = D('Return')->where("user_return_id = '" . $return['user_return_id'] . "' or id = '" . $return['user_return_id'] . "'")->data($data)->save();
			} else {
				$result = D('Return')->where("id = '" . $return['id'] . "'")->data($data)->save();
			}

			if ($result) {
/*				if(true){
					//发送买家消息通知start
					$msg='亲，您的订单：'.$order['order_no'].'，商家审核不通过，原因：'.$store_content;
					//$main_user_info=D('User')->where(array('uid'=>$order['uid']))->field('openid,phone')->find();
// 					$openid = $main_user_info['openid'];
// 					$_Map['uid']=$order['uid'];
// 					$_Map['store_id']=$store_id;
// 					$subscribe_store_info=D('Subscribe_store')->where($_Map)->find();
// 					if($subscribe_store_info){
// 						$openid=$subscribe_store_info['openid'];
// 					}
	
					//发送模板消息
					import('source.class.Factory');
					import('source.class.MessageFactory');
					$template_data = array(
							'wecha_id' => true_openid($order['uid'],$store_id),
							'first'    => $msg,
							'keyword1' =>'审核不通过',
							'keyword2' => $order['order_no'],
							'keyword3' => $order['total'],
							'keyword4' => $store_content,
							'keyword5' => date('Y-m-d H:i:s',time()),
							'remark'   => '状态：' . "退货审核不通过",
					);

					$params['template'] = array('template_id' => 'OPENTM203847595', 'template_data' => $template_data,'sendType'=>1);
					$mobile = $order['address_tel']?$order['address_tel']:$main_user_info['phone'];
					
					$params['sms'] = array('mobile'=>$mobile,'token'=>'test','content'=>$msg,'sendType'=>1);
					MessageFactory::method($params, array('smsMessage', 'TemplateMessage'));
				}*/
				
				
				// 审核不通过更改订单产品表退货状态
				import('source.class.ReturnOrder');
				ReturnOrder::checkReturnStatus($return);
				json_return(0, '操作成功');
			} else {
				json_return(1001, '操作失败，请重试');
			}
		} else {
			$tmp_address = array();
			$tmp_address['address'] = $address;
			$tmp_address['province_id'] = $provinceId_m;
			$tmp_address['city_id'] = $cityId_m;
			$tmp_address['area_id'] = $areaId_m;

			import('area');
			$areaClass = new area();
			$tmp_address['province_txt'] = $areaClass->get_name($provinceId_m);
			$tmp_address['city_txt'] = $areaClass->get_name($cityId_m);
			$tmp_address['county_txt'] = $areaClass->get_name($areaId_m);


			$data = array();
			$data['status'] = 3;
			if ($order['status'] != 2 && $order['status'] != 6) {
				$data['address'] = serialize($tmp_address);
				$data['address_user'] = $address_user;
				$data['address_tel'] = $address_tel;
			}
			$data['product_money'] = $product_money;
			$data['postage_money'] = $postage_money;

			// 同意退款，订单为货到付款，订单状态在待发货时，直接将退货状态改为退货完成
			if ($order['status'] == 2 || $order['status'] == 6) {
				$data['status'] = 5;
			}

			if ($return['user_return_id']) {
				$result = D('Return')->where("user_return_id = '" . $return['user_return_id'] . "' or id = '" . $return['user_return_id'] . "'")->data($data)->save();
			} else {
				$result = D('Return')->where("id = '" . $return['id'] . "'")->data($data)->save();
			}

			if ($result) {
				// 如果是货到付款退货，全部退完，直接将订单改为取消状态
				if ($order['status'] == 2) {
					import('source.class.ReturnOrder');
					ReturnOrder::checkOrderStatus($order);
				}
				
				// 如果订单状态为2，不是货到付款，要更改库存和外销量
				if ($order['status'] == 2 && $order['payment_method'] != 'codpay') {
					$quantity = $return['pro_num'];
					
					$properties = getPropertyToStr($return['sku_data']);
					$tmp_product_id = $return['product_id'];
					
					//更新库存
					D('Product')->where(array('product_id' => $tmp_product_id))->setInc('quantity', $quantity);
					if (!empty($properties)) { //更新商品属性库存
						D('Product_sku')->where(array('product_id' => $tmp_product_id, 'properties' => $properties))->setInc('quantity', $quantity);
					}
					//更新销量
					D('Product')->where(array('product_id' => $tmp_product_id))->setDec('sales', $quantity); //更新销量
					if (!empty($properties)) { //更新商品属性销量
						D('Product_sku')->where(array('product_id' => $tmp_product_id, 'properties' => $properties))->setDec('sales', $quantity);
					}
					//同步批发商品库存、销量
					$wholesale_products = D('Product')->field('product_id')->where(array('wholesale_product_id' => $tmp_product_id))->select();
					if (!empty($wholesale_products)) {
						foreach ($wholesale_products as $wholesale_product) {
							//更新库存
							D('Product')->where(array('product_id' => $wholesale_product['product_id']))->setInc('quantity', $quantity);
							if (!empty($properties)) { //更新商品属性库存
								D('Product_sku')->where(array('product_id' => $wholesale_product['product_id'], 'properties' => $properties))->setInc('quantity', $quantity);
							}
							//更新销量
							D('Product')->where(array('product_id' => $wholesale_product['product_id']))->setDec('sales', $quantity); //更新销量
							if (!empty($properties)) { //更新商品属性销量
								D('Product_sku')->where(array('product_id' => $wholesale_product['product_id'], 'properties' => $properties))->setDec('sales', $quantity);
							}
						}
					}
				}
				
				json_return(0, '操作成功');
			} else {
				json_return(1001, '操作失败，请重试');
			}
		}
	}

	/**
	 * 退货完成
	 */
	public function return_over() {
		$id = $_POST['id'];
		$store_id = $_SESSION['store']['store_id'];

		$return = M('Return')->getById($id);
		if (empty($return)) {
			json_return(1001, '未找到相应的退货申请');
		}
		if ($return['store_id'] != $_SESSION['store']['store_id'] || $return['is_fx'] != '0') {
			json_return(1001, '您无权操作此退货申请');
		}

		if ($return['status'] != 4) {
			json_return(1001, '操作状态不正确');
		}

		// 查找订单
		$order = D('Order')->where("(order_id = '" . $return['order_id'] . "' or user_order_id = '" . $return['order_id'] . "') and store_id = '" . $store_id . "'")->find();

		if (empty($order)) {
			json_return(1001, '未查到相应的订单');
		}

		// 计算出每级此产品的分销利润
		$return_list = D('Return')->where("user_return_id = '" . $return['user_return_id'] . "' or id = '" . $return['user_return_id'] . "'")->select();
		$return_list = M('Return')->getProfit($return);

		foreach ($return_list as $tmp) {
			$order = D('Order')->where("order_id = '" . $tmp['order_id'] . "'")->find();

			// 货到付款平台不进行扣款
			if ($order['payment_method'] == 'codpay') {
				continue;
			}

			/* $data = "income = income - " . $tmp['profit'] . ", unbalance = unbalance - " . $tmp['profit'];

			  if ($tmp['is_fx']) {
			  $data .= ", drp_profit = drp_profit - " . $tmp['profit'];
			  }

			  D('Store')->where(array('store_id' => $tmp['store_id']))->data($data)->save(); */

			$financial_record_data = array();
			$financial_record_data['store_id'] = $tmp['store_id'];
			$financial_record_data['order_id'] = $order['order_id'];
			$financial_record_data['order_no'] = $order['order_no'];
			$financial_record_data['income'] = -1 * $tmp['profit'];

			if ($tmp['drp_level'] == '0') {
				$financial_record_data['income'] = -1 * $tmp['profit'] - $tmp['postage_money'];
			}

			$financial_record_data['type'] = 3;
			$financial_record_data['trade_no'] = date('YmdHis') . rand(100000, 999999);
			$financial_record_data['add_time'] = time();
			$financial_record_data['status'] = 2;
			$financial_record_data['user_order_id'] = $order['user_order_id'];
			$financial_record_data['bak'] = '退货';

			D('Financial_record')->data($financial_record_data)->add();
		}
		if ($return['user_return_id']) {
			D('Return')->where("user_return_id = '" . $return['user_return_id'] . "' OR id = '" . $return['user_return_id'] . "'")->data(array('status' => 5))->save();
		} else {
			D('Return')->where("id = '" . $return['id'] . "'")->data(array('status' => 5))->save();
		}
		
		
		// 更改库存和销量
		$quantity = $return['pro_num'];
			
		$properties = getPropertyToStr($return['sku_data']);
		$tmp_product_id = $return['product_id'];
			
		//更新库存
		D('Product')->where(array('product_id' => $tmp_product_id))->setInc('quantity', $quantity);
		if (!empty($properties)) { //更新商品属性库存
			D('Product_sku')->where(array('product_id' => $tmp_product_id, 'properties' => $properties))->setInc('quantity', $quantity);
		}
		//更新销量
		D('Product')->where(array('product_id' => $tmp_product_id))->setDec('sales', $quantity); //更新销量
		if (!empty($properties)) { //更新商品属性销量
			D('Product_sku')->where(array('product_id' => $tmp_product_id, 'properties' => $properties))->setDec('sales', $quantity);
		}
		//同步批发商品库存、销量
		$wholesale_products = D('Product')->field('product_id')->where(array('wholesale_product_id' => $tmp_product_id))->select();
		if (!empty($wholesale_products)) {
			foreach ($wholesale_products as $wholesale_product) {
				//更新库存
				D('Product')->where(array('product_id' => $wholesale_product['product_id']))->setInc('quantity', $quantity);
				if (!empty($properties)) { //更新商品属性库存
					D('Product_sku')->where(array('product_id' => $wholesale_product['product_id'], 'properties' => $properties))->setInc('quantity', $quantity);
				}
				//更新销量
				D('Product')->where(array('product_id' => $wholesale_product['product_id']))->setDec('sales', $quantity); //更新销量
				if (!empty($properties)) { //更新商品属性销量
					D('Product_sku')->where(array('product_id' => $wholesale_product['product_id'], 'properties' => $properties))->setDec('sales', $quantity);
				}
			}
		}
		
		// 如果订单产品全部退完，更改订单状态
		import('source.class.ReturnOrder');
		ReturnOrder::checkOrderStatus($order);

		json_return(0, '操作完成');
	}

	/**
	 * 维权列表
	 */
	public function order_rights() {
		$this->display();
	}

	/**
	 * 维权列表
	 */
	private function _order_rights_list() {
		$store_id = $_SESSION['store']['store_id'];
		$rights_model = M('Rights');
		$count = $rights_model->getCount("store_id = '" . $store_id . "'");
		$page = max(1, $_GET['page']);

		$rights_list = array();
		$pages = '';
		if ($count > 0) {
			$limit = 15;
			$page = min($page, ceil($count / $limit));
			$offset = ($page - 1) * $limit;

			$rights_list = $rights_model->getList("r.store_id = '" . $store_id . "'", $limit, $offset);
			import('source.class.user_page');
			$pages = new Page($order_total, 15, $page);
		}
		$this->assign('rights_list', $rights_list);
		$this->assign('pages', $pages);
	}

	private function _order_rights_detail() {
		$id = $_POST['id'];
		$order_no = $_POST['order_no'];
		$pigcms_id = $_POST['pigcms_id'];
		$store_id = $_SESSION['store']['store_id'];

		if (empty($id) && (empty($order_no) || empty($pigcms_id))) {
			echo '缺少参数！';
			exit;
		}

		$rights = array();
		if (!empty($id)) {
			$rights = M('Rights')->getById($id);
		} else {
			$order_no = trim($order_no, option('config.orderid_prefix'));
			$where = "r.order_no = '" . $order_no . "' AND rp.order_product_id = '" . $pigcms_id . "'";
			$rights_list = M('Rights')->getList($where);

			if ($rights_list) {
				$rights = $rights_list[0];
			}
		}
		//$return = M('Return')->getById($id);
		if (empty($rights)) {
			echo '未找到相应的退货申请';
			exit;
		}

		if (empty($id) && !empty($order_no) && !empty($pigcms_id)) {
			echo json_encode(array('status' => true, 'msg' => $rights['id']));
			exit;
		}

		if ($rights['store_id'] != $_SESSION['store']['store_id']) {
			echo '您无权查看此退货申请';
			exit;
		}
		// 查找订单
		$order = D('Order')->where("(order_id = '" . $rights['order_id'] . "' or user_order_id = '" . $rights['order_id'] . "') and store_id = '" . $store_id . "'")->find();

		if (empty($order)) {
			echo '未查到相应的订单';
			exit;
		}
		$order = M('Order')->find(option('config.orderid_prefix') . $order['order_no']);
		/*// 查看满减送
		$order_ward_list = M('Order_reward')->getByOrderId($order['order_id']);
		// 使用优惠券
		$order_coupon = M('Order_coupon')->getByOrderId($order['order_id']);*/

		// 计算出每级此产品的分销利润
		if ($rights['is_fx'] == 0) {
			$rights_list = M('Rights')->getProfit($rights);
			$this->assign('rights_list', $rights_list);
		}
		
		// 相关折扣、满减、优惠
		import('source.class.Order');
		$order_data = Order::orderDiscount($order);

		$this->assign('order', $order);
		$this->assign('rights', $rights);
		//$this->assign('order_ward_list', $order_ward_list);
		//$this->assign('order_coupon', $order_coupon);
		$this->assign('order_data', $order_data);
	}

    public function order_download_csv() {
        $order = M('Order');
        $order_product = M('Order_product');
        $user = M('User');
        $where = array();
        $where['store_id'] = $this->store_session['store_id'];
//        if ($_GET['status'] != '*') {
//            $where['status'] = intval($_GET['status']);
//        } else { //所有订单（不包含临时订单）
//            $where['status'] = array('>', 0);
//        }
        if ($_GET['order_no']) {
            $where['order_no'] = $_GET['order_no'];
        }
        if (is_numeric($_GET['type'])) {
            $where['type'] = $_GET['type'];
        }
        if (!empty($_GET['user'])) {
            $where['address_user'] = $_GET['user'];
        }
        if (!empty($_GET['tel'])) {
            $where['address_tel'] = $_GET['tel'];
        }
        if (!empty($_GET['payment_method'])) {
            $where['payment_method'] = $_GET['payment_method'];
        }
        if (!empty($_GET['shipping_method'])) {
            $where['shipping_method'] = $_GET['shipping_method'];
        }
        $field = '';
        if (!empty($_GET['time_type'])) {
            $field = $_GET['time_type'];
        }
        if (!empty($_GET['start_time']) && !empty($_GET['stop_time']) && !empty($field)) {
            $where['_string'] = "`" . $field . "` >= " . strtotime($_GET['start_time']) . " AND `" . $field . "` <= " . strtotime($_GET['stop_time']);
        } else if (!empty($_GET['start_time']) && !empty($field)) {
            $where[$field] = array('>=', strtotime($_GET['start_time']));
        } else if (!empty($_GET['stop_time']) && !empty($field)) {
            $where[$field] = array('<=', strtotime($_GET['stop_time']));
        }
        //排序
        if (!empty($_GET['orderbyfield']) && !empty($_GET['orderbymethod'])) {
            $orderby = "`{$_GET['orderbyfield']}` " . $_GET['orderbymethod'];
        } else {
            $orderby = '`order_id` DESC';
        }
        $order_total = $order->getOrderTotal($where);
        import('source.class.user_page');
        $page = new Page($order_total, 15);
        $tmp_orders = $order->getOrders($where, $orderby, $page->firstRow, $page->listRows);
        $orders = array();
        foreach ($tmp_orders as $tmp_order) {
            $products = $order_product->getProducts($tmp_order['order_id']);
            $tmp_order['products'] = $products;
            if (empty($tmp_order['uid'])) {
                $tmp_order['is_fans'] = false;
                $tmp_order['buyer'] = '';
            } else {
                //$tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
                $tmp_order['is_fans'] = true;
                $user_info = $user->checkUser(array('uid' => $tmp_order['uid']));
                $tmp_order['buyer'] = $user_info['nickname'];
            }

            // 是否有退货未完成的申请，有未完成的申请，暂时不给完成订单
            if ($tmp_order['status'] == 7) {
                $count = D('Return')->where("order_id = '" . $tmp_order['order_id'] . "' AND status IN (1, 3, 4)")->count('id');
                $tmp_order['returning_count'] = $count;
            }


            $is_supplier = false;
            if (!empty($tmp_order['suppliers'])) { //订单供货商
                $suppliers = explode(',', $tmp_order['suppliers']);
                if (in_array($this->store_session['store_id'], $suppliers)) {
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
            $orders[] = $tmp_order;
        }

        //订单状态
        $order_status = $order->status();

        //支付方式
        $payment_method = $order->getPaymentMethod();
        file_put_contents('./a.txt', json_encode($orders));

        $order_status = array(
            0 => '临时订单',
            1 => '等待买家付款',
            2 => '等待卖家发货',
            3 => '卖家已发货',
            4 => '交易完成',
            5 => '订单关闭',
            6 => '退款中',
            7 => '确认收货'
        );

        include 'source/class/Classes/PHPExcel.php';
        //include 'source/class/Classes/PHPExcel/Writer/Excel2007.php';
        include 'source/class/Classes/PHPExcel/Writer/Excel5.php';
//或者include 'PHPExcel/Writer/Excel5.php'; 用于输出.xls的
        //创建一个excel
        $objPHPExcel = new PHPExcel();
        //保存excel—2007格式
        //$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); //非2007格式
        $objWriter->save("xxx.xlsx");
        //直接输出到浏览器
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check = 0, pre-check = 0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        ;
        header('Content-Disposition:attachment;filename="订单信息' . date('Y-m-d', time()) . '.xls"');
        header("Content-Transfer-Encoding:binary");



        //设置当前的sheet
        $objPHPExcel->setActiveSheetIndex(0);
        //设置sheet的name
        $objPHPExcel->getActiveSheet()->setTitle('Simple');
        //设置单元格的值
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '订单号');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '外部订单号');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', '商品信息');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', '买家');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', '订单状态');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', '收货人');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', '收货联系电话');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', '支付方式');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', '订单类型');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', '订单时间');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', '付款时间');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', '发货时间');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', '收货时间');
        $objPHPExcel->getActiveSheet()->setCellValue('N1', '取消时间');
        $objPHPExcel->getActiveSheet()->setCellValue('O1', '订单完成时间');
        $objPHPExcel->getActiveSheet()->setCellValue('P1', '退款时间');
        $objPHPExcel->getActiveSheet()->setCellValue('Q1', '买家留言');
        $objPHPExcel->getActiveSheet()->setCellValue('R1', '备注');
        $objPHPExcel->getActiveSheet()->setCellValue('S1', '实际付款金额');
        $objPHPExcel->getActiveSheet()->setCellValue('T1', '订单取消方式');
        $objPHPExcel->getActiveSheet()->setCellValue('U1', '商品供货商');
        $objPHPExcel->getActiveSheet()->setCellValue('V1', '是否对账');
        $objPHPExcel->getActiveSheet()->setCellValue('W1', '商品金额');
        $objPHPExcel->getActiveSheet()->setCellValue('X1', '订单金额');

        foreach ($orders as $k => $v) {
            $tmp_info = '';
            foreach ($v['products'] as $val) {
                $tmp_info .= "商品名称：" . $val['name'] . "  商品数量：" . $val['pro_num'] . "  商品价格：" . $val['pro_price'] . "\n";
            }
            $product_info['status'] = $order_status_info;
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($k + 2), " " . $v['order_no']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . ($k + 2), " " . $v['trade_no']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . ($k + 2), $tmp_info);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . ($k + 2), $v['buyer']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . ($k + 2), $order_status[$v['status']]);

            $objPHPExcel->getActiveSheet()->setCellValue('F' . ($k + 2), ' ' . $v['address_user']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . ($k + 2), $v['address_tel']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . ($k + 2), $payment_method[$v['payment_method']]);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . ($k + 2), $v['type'] == 0 ? '普通' : ($v['type'] == 1 ? '代付' : ($v['type'] == 2 ? '送礼' : '分销')));
            $objPHPExcel->getActiveSheet()->setCellValue('J' . ($k + 2), $v['add_time'] ? date('Y-m-d H:i:s', $v['add_time']) : '');
            $objPHPExcel->getActiveSheet()->setCellValue('K' . ($k + 2), $v['paid_time'] ? date('Y-m-d H:i:s', $v['paid_time']) : '');
            $objPHPExcel->getActiveSheet()->setCellValue('L' . ($k + 2), $v['sent_time'] ? date('Y-m-d H:i:s', $v['sent_time']) : '');
            $objPHPExcel->getActiveSheet()->setCellValue('M' . ($k + 2), $v['delivery_time'] ? date('Y-m-d H:i:s', $v['delivery_time']) : '');
            $objPHPExcel->getActiveSheet()->setCellValue('N' . ($k + 2), $v['cancel_time'] ? date('Y-m-d H:i:s', $v['cancel_time']) : '');

            $objPHPExcel->getActiveSheet()->setCellValue('O' . ($k + 2), $v['complate_time'] ? date('Y-m-d H:i:s', $v['complate_time']) : '');
            $objPHPExcel->getActiveSheet()->setCellValue('P' . ($k + 2), $v['refund_time'] ? date('Y-m-d H:i:s', $v['refund_time']) : '');
            $objPHPExcel->getActiveSheet()->setCellValue('Q' . ($k + 2), $v['comment']);
            $objPHPExcel->getActiveSheet()->setCellValue('R' . ($k + 2), $v['bak']);
            $objPHPExcel->getActiveSheet()->setCellValue('S' . ($k + 2), $v['pay_money']);
            $objPHPExcel->getActiveSheet()->setCellValue('T' . ($k + 2), $v['cancel_method'] == 0 ? '正常（过期自动取消）' : ($v['cancel_method'] == 1 ? '卖家手动取消' : '买家手动取消'));
            $store_info = M('Store')->getStore($v['suppliers']);
            $objPHPExcel->getActiveSheet()->setCellValue('U' . ($k + 2), $store_info['name']);
            $objPHPExcel->getActiveSheet()->setCellValue('V' . ($k + 2), $v['is_check'] == 1 ? '未对账' : '已对帐');
            $objPHPExcel->getActiveSheet()->setCellValue('W' . ($k + 2), $v['sub_total']);
            $objPHPExcel->getActiveSheet()->setCellValue('X' . ($k + 2), $v['total']);
        }

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(100);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(30);

        $objWriter->save('php://output');
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

    public function testAssign(){
        $order_id = !empty($_GET['order_id']) ? $_GET['order_id'] : 0;
        M('Order')->assignOrderToPhysical($order_id);
    }

    //simon
    public function order_checkout_csv() {
        $order = M('Order');
        $order_product = M('Order_product');
        $user = M('User');
    
        $where = array();
        $where['store_id'] = $this->store_session['store_id'];
        $orderby = '`order_id` DESC';
        $check_type = $_REQUEST['check_type'];
    
        switch($check_type) {
            //当前页面订单
            case 'now':
                if ($_REQUEST['order_no']) {
                    $where['order_no'] = $_REQUEST['order_no'];
                }
                    
                    
                if ($_REQUEST['status']>0) {
                    $where['status'] = $_REQUEST['status'];
    
                } else {
                    $where['status'] = array(">",0);
                }
                    
                if (is_numeric($_REQUEST['type'])) {
                    $where['type'] = $_REQUEST['type'];
                }
                if (!empty($_REQUEST['user'])) {
                    $where['address_user'] = $_REQUEST['user'];
                }
                if (!empty($_REQUEST['tel'])) {
                    $where['address_tel'] = $_REQUEST['tel'];
                }
                if (!empty($_REQUEST['payment_method'])) {
                    $where['payment_method'] = $_REQUEST['payment_method'];
                }
                if (!empty($_REQUEST['shipping_method'])) {
                    $where['shipping_method'] = $_REQUEST['shipping_method'];
                }
                $field = '';
                if (!empty($_REQUEST['time_type'])) {
                    $field = $_REQUEST['time_type'];
                }
                if (!empty($_REQUEST['start_time']) && !empty($_REQUEST['stop_time']) && !empty($field)) {
                    $where['_string'] = "`" . $field . "` >= " . strtotime($_REQUEST['start_time']) . " AND `" . $field . "` <= " . strtotime($_REQUEST['stop_time']);
                } else if (!empty($_REQUEST['start_time']) && !empty($field)) {
                    $where[$field] = array('>=', strtotime($_REQUEST['start_time']));
                } else if (!empty($_REQUEST['stop_time']) && !empty($field)) {
                    $where[$field] = array('<=', strtotime($_REQUEST['stop_time']));
                }
                    
                //排序
                if (!empty($_REQUEST['orderbyfield']) && !empty($_REQUEST['orderbymethod'])) {
                    $orderby = "`{$_REQUEST['orderbyfield']}` " . $_REQUEST['orderbymethod'];
                }
    
                break;
                    
                //全部订单
            case 'all':
                $where['status'] = array(">",0);
                break;
                //全部待付款
            case '1':
                $where['status'] = 1;
                break;
                //全部待发货
            case '2':
                $where['status'] = 2;
                break;
                //全部已完成
            case '3':
                $where['status'] = 4;
                break;
                //全部已发货
            case '4':
                $where['status'] = 3;
                break;
                //全部已关闭
            case '5':
                $where['status'] = 5;
                break;
                //全部退款中
            case '6':
                $where['status'] = 6;
                break;
        }
    
            $data['is_show_activity_data'] = '0';   //不显示 活动订单
            if(!$data['is_show_activity_data']) {
                //$where['activity_data'] = '';
                $where['activity_data'] = array('is_null',"is_null");
            }
    
        $order_total = $order->getOrderTotal($where);
    
        if(IS_POST) {
            json_return(json_encode($where),$order_total);
        }
    
        //import('source.class.user_page');
        //$page = new Page($order_total, 15);
        $tmp_orders = $order->getOrders($where, $orderby);
        $orders = array();
        foreach ($tmp_orders as $tmp_order) {
            $products = $order_product->getProducts($tmp_order['order_id']);
            $tmp_order['products'] = $products;
            if (empty($tmp_order['uid'])) {
                $tmp_order['is_fans'] = false;
                $tmp_order['buyer'] = '';
            } else {
                //$tmp_order['is_fans'] = $user->isWeixinFans($tmp_order['uid']);
                $tmp_order['is_fans'] = true;
                $user_info = $user->checkUser(array('uid' => $tmp_order['uid']));
                $tmp_order['buyer'] = $user_info['nickname'];
            }
    
            // 是否有退货未完成的申请，有未完成的申请，暂时不给完成订单
            if ($tmp_order['status'] == 7) {
                $count = D('Return')->where("order_id = '" . $tmp_order['order_id'] . "' AND status IN (1, 3, 4)")->count('id');
                $tmp_order['returning_count'] = $count;
            }
    
    
            $is_supplier = false;
            if (!empty($tmp_order['suppliers'])) { //订单供货商
                $suppliers = explode(',', $tmp_order['suppliers']);
                if (in_array($this->store_session['store_id'], $suppliers)) {
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
            $orders[] = $tmp_order;
        }
    
        //订单状态
        $order_status = $order->status();
    
        //支付方式
        $payment_method = $order->getPaymentMethod();
        //file_put_contents('./a.txt', json_encode($orders));
    
        $order_status = array(
                0 => '临时订单',
                1 => '等待买家付款',
                2 => '等待卖家发货',
                3 => '卖家已发货',
                4 => '交易完成',
                5 => '订单关闭',
                6 => '退款中',
                7 => '确认收货'
        );
    
        //
        include 'source/class/execl.class.php';
        $execl = new execl();
        $filename = date($level_cn."订单信息_YmdHis",time()).'.xls';
        header ( 'Content-Type: application/vnd.ms-excel' );
        header ( "Content-Disposition: attachment;filename=$filename" );
        header ( 'Cache-Type: charset=gb2312');
        echo "<style>table td{border:1px solid #ccc;}</style>";
        echo "<table>";
         
        echo '  <tr>';
        echo '      <td align="center"><b> 订单号 </b></td>';
        echo '      <td align="center"><b> 外部订单号 </b></td>';
        echo '      <td align="center" colspan="3" ><table><tr><td colspan="3" align="center" ><b>商品信息</b></td></tr><tr><td width="300" align="center"><b>商品名称</b></td><td align="center"><b>数量</b></td><td align="center"><b>单价</b></td></tr></table></td>';
        echo '      <td align="center"><b> 买家 </b></td>';
        echo '      <td align="center"><b> 订单状态 </b></td>';
        echo '      <td align="center"><b> 收货人 </b></td>';
        echo '      <td align="center"><b> 收货联系电话 </b></td>';
        echo '      <td align="center"><b> 支付方式 </b></td>';
        echo '      <td align="center"><b> 订单类型  </b></td>';
        echo '      <td align="center"><b> 订单时间  </b></td>';
        echo '      <td align="center"><b> 付款时间 </b></td>';
        echo '      <td align="center"><b> 发货时间  </b></td>';
        echo '      <td align="center"><b> 收货时间  </b></td>';
        echo '      <td align="center"><b> 取消时间  </b></td>';
        echo '      <td align="center"><b> 订单完成时间  </b></td>';
        echo '      <td align="center"><b> 退款时间  </b></td>';
        echo '      <td align="center"><b> 买家留言  </b></td>';
        echo '      <td align="center"><b> 备注  </b></td>';
        echo '      <td align="center"><b> 实际付款金额  </b></td>';
        echo '      <td align="center"><b> 订单取消方式  </b></td>';
        echo '      <td align="center"><b> 商品供货商 </b></td>';
        echo '      <td align="center"><b> 是否对账  </b></td>';
        echo '      <td align="center"><b> 商品金额  </b></td>';
        echo '      <td align="center"><b> 订单金额  </b></td>';
        echo '      <td align="center"><b> 订单地址  </b></td>';
        echo '  </tr>';
    
        foreach ($orders as $k => $v) {
            $tmp_info = '';

            $product_info['status'] = $order_status_info;
    
            echo '  <tr>';
            echo '      <td  style="vnd.ms-excel.numberformat:@" align="center" width="300">' . $v['order_no'] . '</td>';
            echo '      <td  style="vnd.ms-excel.numberformat:@" align="center" width="190">' . $v['trade_no'] . '</td>';
            echo '<td colspan="3"><table style="height:100%">';
            foreach($v['products'] as $val) {
                echo '<tr><td align="center">'.$val['name'].'</td><td align="center">' .$val['pro_num']. '</td><td align="center">￥'.$val['pro_price'].'</td></tr>';    
            }
            echo '</table></td>';

            echo '      <td align="center">' . $v['buyer'] . '</td>';
            echo '      <td align="center">' . $order_status[$v['status']] . '</td>';
            echo '      <td align="center">' . $v['address_user'] . '</td>';
            echo '      <td align="center">' . $v['address_tel'] . '</td>';
            echo '      <td align="center">' . $payment_method[$v['payment_method']] . '</td>';
            echo '      <td align="center">' . ($v['type'] == 0 ? '普通' : ($v['type'] == 1 ? '代付' : ($v['type'] == 2 ? '送礼' : '分销'))) . '</td>';
            echo '      <td align="center">' . ($v['add_time'] ? date('Y-m-d H:i:s', $v['add_time']) : '' ). '</td>';
            echo '      <td align="center">' . ($v['paid_time'] ? date('Y-m-d H:i:s', $v['paid_time']) : '' ). '</td>';
            echo '      <td align="center">' . ($v['sent_time'] ? date('Y-m-d H:i:s', $v['sent_time']) : '' ). '</td>';
            echo '      <td align="center">' . ($v['delivery_time'] ? date('Y-m-d H:i:s', $v['delivery_time']) : '' ). '</td>';
            echo '      <td align="center">' . ($v['cancel_time'] ? date('Y-m-d H:i:s', $v['cancel_time']) : '' ). '</td>';
            echo '      <td align="center">' . ($v['complate_time'] ? date('Y-m-d H:i:s', $v['complate_time']) : '' ). '</td>';
            echo '      <td align="center">' . ($v['refund_time'] ? date('Y-m-d H:i:s', $v['refund_time']) : '' ). '</td>';
            echo '      <td align="center">' . $v['comment'] . '</td>';
            echo '      <td align="center">' . $v['bak'] . '</td>';
            echo '      <td align="center">' . $v['pay_money'] . '</td>';
            echo '      <td align="center">' . ($v['cancel_method'] == 0 ? '正常（过期自动取消）' : ($v['cancel_method'] == 1 ? '卖家手动取消' : '买家手动取消')) . '</td>';
            $store_info = M('Store')->getStore($v['suppliers']);
            echo '      <td align="center">' . $store_info['name'] . '</td>';
            echo '      <td align="center">' . ($v['is_check'] == 1 ? '未对账' : '已对帐') . '</td>';
            echo '      <td align="center">' . $v['sub_total']. '</td>';
            echo '      <td align="center">' . $v['total'] . '</td>';
            $address=unserialize($v['address']);
            $address_str='';
            if(!in_array($address['province_code'],array(110000,310000,500000,120000))){
                $address_str.=$address['province'];
            }
            $address_str.=$address['city'].$address['area'].$address['address'];
            echo '      <td align="center">' . $address_str . '</td>';
            echo '  </tr>';
        }
        echo '</table>';
    
    
    }

}
