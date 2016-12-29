<?php

/**
 * 订单数据模型
 */
class order_model extends base_model{
	/*得到一个订单信息,包含订单里的商品*/
	public function find($order_no){
		$nowOrder = $this->findSimple($order_no);

		if(!empty($nowOrder)){
//			添加Order_product表
			$nowOrder['proList'] = M('Order_product')->orderProduct($nowOrder['order_id']);
//			echo "<pre>";
//			print_r($nowOrder['proList']);
//			exit;
//			成功返回
			return $nowOrder;
		}else{
			return array();
		}
	}
	/*得到一个订单信息*/
	public function findSimple($order_no){
	
		$orderid_prefix = option('config.orderid_prefix');
		if ($orderid_prefix) {
		
			$order_no = preg_replace('#'.option('config.orderid_prefix').'#','',$order_no,1,$count);
				if($count == 0) return array();
		}
	
		$nowOrder = $this->db->where(array('order_no'=>$order_no))->find();
	
		if(!empty($nowOrder)){
			$nowOrder['order_no_txt'] = option('config.orderid_prefix').$nowOrder['order_no'];
			if($nowOrder['payment_method']) $nowOrder['pay_type_txt'] = $this->get_pay_name($nowOrder['payment_method']);
//			成功返回
			return $nowOrder;
		}else{
			return array();
		}
	}
	public function get_pay_name($pay_type){
		switch($pay_type){
			case 'alipay':
				$pay_type_txt = '支付宝';
				break;
			case 'tenpay':
				$pay_type_txt = '财付通';
				break;
			case 'yeepay':
				$pay_type_txt = '易宝支付';
				break;
			case 'allinpay':
				$pay_type_txt = '通联支付';
				break;
			case 'chinabank':
				$pay_type_txt = '网银在线';
				break;
			case 'weixin':
				$pay_type_txt = '微信支付';
				break;
			case 'offline':
				$pay_type_txt = '货到付款';
				break;
            case 'CardPay':
				$pay_type_txt = '会员卡支付';
				break;
			case 'point':
				$pay_type_txt = '积分支付';
				break;
			default:
				$pay_type_txt = '余额支付';
				break;
		}
		return $pay_type_txt;
	}

    public function getPaymentMethod($key = '')
    {
        $payment_methods = array(
            'alipay'    => '支付宝',
            'tenpay'    => '财付通',
            'yeepay'    => '易宝支付',
            'allinpay'  => '通联支付',
            'chinabank' => '网银在线',
            'weixin'    => '微信支付',
            'offline'   => '货到付款',
            'balance'   => '余额支付',
            'CardPay'   => '会员卡支付',
        	'cash'      => '现金收款',
            'test'      => '测试支付',
			'point'     => '积分支付',
			'other'     => '其它'
        );
        if (!empty($key) && array_key_exists($key, $payment_methods)) {
            return $payment_methods[$key];
        } else {
            return $payment_methods;
        }
    }

    public function status($status = -1)
    {
		$order_status = array(
			0 => '临时订单',
			1 => '等待买家付款',
			2 => '等待卖家发货',
			3 => '卖家已发货',
			4 => '交易完成',
			5 => '订单关闭',
			6 => '退货中',
			7 => '确认收货'
		);
		if($status == -1){
			return $order_status;
		}else{
			return $order_status[$status];
		}
    }

	public function ws_alias_status($status = -1)
	{
		$ws_alias_status = array(
			0 => '临时订单',
			1 => '等待经销商付款',
			2 => '等待供货商发货',
			3 => '供货商已发货',
			4 => '交易完成',
			5 => '订单关闭',
			6 => '退款中',
			7 => '确认收货'
		);
		if($status == -1){
			return $ws_alias_status;
		}else{
			return $ws_alias_status[$status];
		}
	}

    public function getOrders($where, $orderby="", $offset="0", $limit="0")
    {	
    	if($orderby)$this->db->order($orderby);
    	if($limit) $this->db->limit($offset . ',' . $limit);
        $orders = $this->db->where($where)->select();
        foreach ($orders as $key => $value) {
        	$userInfo 	= D('User')->field('uid,nickname')->where(array('uid'=>$value['uid']))->find();
        	$orders[$key]['nickname'] 	= $userInfo['nickname'];
        }
        return $orders;
    }

    /* 批发订单 */
    public function getWholeale($where, $orderby, $offset="", $limit="")
    {
        $sql = "SELECT * FROM " . option('system.DB_PREFIX') . "order s, " . option('system.DB_PREFIX') . 'fx_order ss WHERE s.fx_order_id = ss.fx_order_id';
        if (!empty($where)) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    if (array_key_exists('like', $value)) {
                        $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                    } else if (array_key_exists('in', $value)) {
                        $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                    } else{
                            $sql .=" AND " .$key . "$value[0]" . "'" . $value[1] . "'";
                    }
                }else if($key == '_string'){
                    $sql .= "AND " . $value;
                }else if($key != '_string'){
                    $sql .= " AND " . $key . "=" . "'".$value."'";
                }
            }
        }

        


        if ($orderby) {
            $sql .= ' ORDER BY ' . $orderby;
        } else {
        	$sql .= ' ORDER BY s.fx_order_id DESC';
        }
        
        if ($limit) {
        	$sql .= ' LIMIT ' . $offset . ',' . $limit;
        }
        
        $ordersList = $this->db->query($sql);

        return $ordersList;
    }

    public function getWholealeCount($where)
    {
        $sql = "SELECT count('s.fx_order_id') as fxOrderId FROM " . option('system.DB_PREFIX') . "order s, " . option('system.DB_PREFIX') . 'fx_order ss WHERE s.fx_order_id = ss.fx_order_id';
        if (!empty($where)) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    if (array_key_exists('like', $value)) {
                        $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                    } else if (array_key_exists('in', $value)) {
                        $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                    } else{
                        $sql .=" AND " .$key . "$value[0]" . "'" . $value[1] . "'";
                    }
                }else if($key == '_string'){
                    $sql .= "AND " . $value;
                }else if($key != '_string'){
                    $sql .= " AND " . $key . "=" . "'".$value."'";
                }
            }
        }
        $ordersCount = $this->db->query($sql);
        return !empty($ordersCount[0]['fxOrderId']) ? $ordersCount[0]['fxOrderId'] : 0;
    }

    public function getOrder($store_id, $order_id)
    {
        $order = $this->db->where(array('order_id' => $order_id, 'store_id' => $store_id))->find();
        return $order;
    }

    public function getOrderTotal($where)
    {
        $order_count = $this->db->where($where)->count('order_id');
        return $order_count;
    }

    //添加备注
    public function setBak($order_id, $bak)
    {
        return $this->db->where(array('order_id' => $order_id))->data(array('bak' => $bak))->save();
    }

    //加星
    public function addStar($order_id, $star)
    {
        return $this->db->where(array('order_id' => $order_id))->data(array('star' => $star))->save();
    }

    //设置订单状态
    public function setOrderStatus($store_id, $order_id, $data)
    {
        return $this->db->where(array('order_id' => $order_id, 'store_id' => $store_id))->data($data)->save();
    }

    public function setFields($store_id, $order_id, $data)
    {
        return $this->db->where(array('store_id' => $store_id, 'order_id' => $order_id))->data($data)->save();
    }

    public function getOrderCount($where)
    {
        return $this->db->where($where)->count('order_id');
    }

    public function getOrderAmount($where)
    {
        return $this->db->where($where)->sum('total');
    }


    //标识为分销订单（订单中包含分销商品）
    public function setFxOrder($store_id, $order_id)
    {
        return $this->db->where(array('order_id' => $order_id, 'store_id' => $store_id))->data(array('is_fx' => 1))->save();
    }

    public function add($data)
    {
        return $this->db->data($data)->add();
    }

    public function setStatus($store_id, $order_id, $status)
    {
        return $this->db->where(array('order_id' => $order_id, 'store_id' => $store_id))->data(array('status' => $status))->save();
    }

    public function editStatus($where, $data)
    {
        return $this->db->where($where)->data($data)->save();
    }
	
	public function findOrderById($orderid){
		$nowOrder = $this->db->where(array('order_id'=>$orderid))->find();
		if(!empty($nowOrder)){
			$nowOrder['status_txt'] = $this->status($nowOrder['status']);
			$nowOrder['order_no_txt'] = option('config.orderid_prefix').$nowOrder['order_no'];
			if($nowOrder['payment_method']) $nowOrder['pay_type_txt'] = $this->get_pay_name($nowOrder['payment_method']);
			//地址
			if($nowOrder['address']){
				$nowOrder['address_arr'] = array(
					'address' => unserialize($nowOrder['address']),
					'user'    => $nowOrder['address_user'],
					'tel'    => $nowOrder['address_tel'],
				);
			}
			//包裹
			if($nowOrder['sent_time']){
				$nowOrder['package_list'] = M('Order_package')->getPackages(array('user_order_id' => $nowOrder['order_id']));
			}
			$nowOrder['proList'] = M('Order_product')->orderProduct($nowOrder['order_id']);
			return $nowOrder;
		}else{
			return array();
		}
	}

    //获取分销商订单
    public function getSellerOrder($seller_uid, $fx_order_id)
    {
        $order = $this->db->where(array('uid' => $seller_uid, 'fx_order_id' => $fx_order_id))->find();
        return $order;
    }

    public function getOrdersByStatus($where, $offset = 0, $limit = 0, $order = 'order_id DESC')
    {
        $orders = $this->db->where($where)->order($order)->limit($offset . ',' . $limit)->select();
        return $orders;
    }

    public function getOrderCountByStatus($where)
    {
        return $this->db->where($where)->count('order_id');
    }

    public function get($where)
    {
        $order = $this->db->where($where)->find();
        return $order;
    }

    public function getAllOrders($where, $order_by = '')
    {
        if (!empty($order_by)) {
			$orders = $this->db->where($where)->order($order_by)->select();
		} else {
			$orders = $this->db->where($where)->select();
		}
        return $orders;
    }

	/**
	 * 根据订单取消订单
	 * 删除送给用户的积分和优惠券
	 * $cancel_mothod 订单取消方式 0过期自动取消 1卖家手动取消 2买家手动取消
	 */
	public function cancelOrder($order, $cancel_mothod = 2) {
		// 订单禁止取消
		if ($cancel_mothod != 1 && $cancel_mothod != 2) {
			return;
		}
		
		// 查看满减送
		$order_ward_list = M('Order_reward')->getByOrderId($order['order_id']);

		$score = 0;
		$uid = $order['uid'];
		foreach ($order_ward_list as $order_ward) {
			$score += $order_ward['content']['score'];
		}

		// 用户减相应的积分
		if ($score) {
			$score = -1 * $score;
			M('Store_user_data')->changePoint($order['store_id'], $uid, $score);
			//修改积分记录
			M('User_points_record')->changePointStatus($order['order_id'],$order['store_id'], $uid, '0','0');
		}

		// 退还使用过的优惠券
		$order_coupon = M('Order_coupon')->getByOrderId($order['order_id']);
		if (!empty($order_coupon)) {
			$where = array();
			$where['id'] = $order_coupon['user_coupon_id'];
			$data = array();
			$data['is_use'] = 0;
			$data['use_time'] = 0;
			$data['use_order_id'] = 0;
			$data['is_valid'] = 1;
			$data['delete_flg'] = 0;

			M('User_coupon')->save($data, $where);
		}

		// 更改此订单获得的优惠券,手机端游客下订单，是没有积分
		if (!empty($uid)) {
			M('User_coupon')->invaild(array('store_id' => $order['store_id'], 'uid' => $uid, 'give_order_id' => $order['order_id']));
		}
		
		// 退还订单使用的积分
		Points::returnPoint($order);
		
		// 货到付款时，订单状态为已发货，更改库存与销量
		if ($order['payment_method'] == 'codpay' && $order['status'] == 3) {
			$order_product_list = M('Order_product')->orderProduct($order['order_id'], false);
			foreach ($order_product_list as $key => $order_product) {
				//退货数量
				$return_quantity = M('Return_product')->returnNumber($order['order_id'], $order_product['pigcms_id'], true);
				//实际购买数量
				$quantity = $order_product['pro_num'] - $return_quantity;
				
				if ($quantity <= 0) {
					continue;
				}
				
				$properties = getPropertyToStr($order_product['sku_data']);
				$tmp_product_id = $order_product['product_id'];
				
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
		}
		
		// 退还平台积分
		if ($order['cash_point']) {
			if ($order['is_offline'] == 1 && $order['offline_type'] == 2) {
				// 订单使用店铺用户平台积分，退还店铺用户平台积分
				$store = D('Stroe')->where(array('store_id' => $order['store_id']))->field('uid')->find();
				$uid = $store['uid'];
				
				Margin::user_point_log($uid, $order['order_id'], $order['store_id'], $order['cash_point'], 1, 2, '订单取消退还', '', '', false, true);
			} else if ($order['is_offline'] == 1 && $order['offline_type'] == 1) {
				Margin::init($order['store_id']);
				Margin::store_point_log($order['cash_point'], 1, 3, '订单取消退还', 1, $order['order_id'], '', 0, false, true);
			} else {
				Margin::user_point_log($order['uid'], $order['order_id'], $order['store_id'], $order['cash_point'], 1, 2, '订单取消退还', '', '', false, true);
			}
		}
		
		// 更改订单状态
		return $this->editStatus(array('order_id' => $order['order_id']), array('status' => 5, 'cancel_time' => time(), 'cancel_method' => $cancel_mothod));
	}

	//计算订单总额
	public function getSales($where)
	{
		$sales = $this->db->where($where)->sum('total');
		return !empty($sales) ? $sales : 0;
	}
	
	/*
	 * @description: 根据订单id  获取用户真实订单
	 * */
	public function getUserTrueOrder($order_id, $field="*") {
		
		$order_info = $this->db->where(array('order_id'=>$order_id))->find();
	
		if($order_info['user_order_id']) {
			
			$order_info = $this->db->where(array('order_id'=>$order_info['user_order_id']))->field($field)->find();
		}
		return $order_info;
	}

	/**
	 * 未支付的供货商订单
	 * @param $order_id 经销商订单号
	 */
	public function getNotPaidSupplierOrders($order_id)
	{
		$order = $this->db->field('user_order_id')->where(array('order_id' => $order_id))->find();
		$user_order_id = !empty($order['user_order_id']) ? $order['user_order_id'] : $order_id;

		$orders = $this->db->where(array('user_order_id' => $user_order_id, 'type' => 5, 'status' => 1))->select();

		return !empty($orders) ? $orders : array();
	}

	/**
	 * 获取批发订单供货商
	 * @param $order_id 经销商订单号
	 */
	public function getSuppliers($order_id)
	{
		$order = $this->db->field('user_order_id')->where(array('order_id' => $order_id))->find();
		$user_order_id = !empty($order['user_order_id']) ? $order['user_order_id'] : $order_id;

		$suppliers = D('')->field('s.store_id,s.name')->table('Store AS s')->join('Order AS o ON o.store_id = s.store_id', 'left')->where(array('user_order_id' => $user_order_id, 'type' => 5))->select();
		return !empty($suppliers) ? $suppliers : array();
	}

	/**
	 * 获取保证金支付的供货商订单
	 * @param $order_id
	 */
	public function getBondPaySupplierOrders($order_id)
	{
		$order = $this->db->field('user_order_id')->where(array('order_id' => $order_id))->find();
		$user_order_id = !empty($order['user_order_id']) ? $order['user_order_id'] : $order_id;

		$orders = $this->db->field('o.order_id,br.deduct_bond AS total,br.supplier_id')->table('Order AS o')->join('Bond_record AS br ON o.order_id = br.order_id', 'inner')->where("o.user_order_id = '" . $user_order_id. "' AND o.type = 5 AND o.status IN (2,3,4,6,7)")->select();
		return !empty($orders) ? $orders : array();
	}

	/**
	 * 已支付的供货商订单
	 * @param $order_id
	 */
	public function getPaidSupplierOrders($order_id)
	{
		$order = $this->db->field('user_order_id')->where(array('order_id' => $order_id))->find();
		$user_order_id = !empty($order['user_order_id']) ? $order['user_order_id'] : $order_id;

		$orders = $this->db->where(array('user_order_id' => $user_order_id, 'type' => 5, 'use_deposit_pay' => 0, 'status' => array('in', array(2,3,4,6,7))))->select();
		return !empty($orders) ? $orders : array();
	}
	
	/**
	 * 统计团购、预售购买记录
	 * param $type 类型，6：团购，7：预售
	 * param $data_id 团购、预售ID
	 * param $data_item_id 团购时，团队ID
	 * param $status 查询类型，默认只抽取状态为2，3，4，6，7
	 */
	public function getActivityOrderCount($type, $data_id, $data_item_id = 0, $status = '') {
		if (empty($status)) {
			$status = array(2, 3, 4, 6, 7);
		}
		
		$where = array();
		$where['type'] = $type;
		$where['data_id'] = $data_id;
		if (!empty($data_item_id)) {
			$where['data_item_id'] = $data_item_id;
		}
		
		if (is_array($status)) {
			$where['status'] = array('in', $status);
		}
		
		return $this->db->where($where)->count('order_id');
	}
	
	/**
	 * 团购、预售列表
	 * param $type 类型，6：团购，7：预售
	 * param $data_id 团购、预售ID
	 * param $data_item_id 团购时，团队ID
	 * param $limit 
	 * param $offset
	 * param $is_anonymous 是否是匿名
	 * param $status 查询类型，默认只抽取状态为2，3，4，6，7
	 */
	public function getActivityOrderList($type, $data_id, $data_item_id = 0, $limit = 6, $offset = 0, $is_anonymous = true, $status = '') {
		if (empty($status)) {
			$status = array(2, 3, 4, 6, 7);
		}
		
		$tuan_team_list = array();
		if ($type == 6) {
			$tuan_team_list_tmp = D('Tuan_team')->where(array('tuan_id' => $data_id, 'pay_status' => 1))->select();
			foreach ($tuan_team_list_tmp as $tuan_team) {
				$tuan_team_list[$tuan_team['order_id']] = $tuan_team['order_id'];
			}
		}
		
		$where = array();
		$where['type'] = $type;
		$where['data_id'] = $data_id;
		if (!empty($data_item_id)) {
			$where['data_item_id'] = $data_item_id;
		}
		if (is_array($status)) {
			$where['status'] = array('in', $status);
		}
		
		$field = 'order_id, uid, pro_num, type, data_id, data_type, data_item_id, data_money, status, add_time, delivery_time, sent_time';
		if (!$is_anonymous) {
			$field .= ', order_no, trade_no, third_id, pay_type, total, postage, address_user, address_tel, payment_method';
		}
		
		$order_list = $this->db->where($where)->field($field)->limit($offset . ', ' . $limit)->order('order_id DESC')->select();
		
		
		
		
		$uid_arr = array();
		foreach ($order_list as &$order) {
			$uid_arr[$order['uid']] = $order['uid'];
			
			if ($type == 6) {
				if (isset($tuan_team_list[$order['order_id']])) {
					$order['is_leader'] = true;
				} else {
					$order['is_leader'] = false;
				}
			}
		}
		
		$user_list = array();
		if (!empty($uid_arr)) {
			$user_list_tmp = M('User')->getList(array('uid' => array('in', $uid_arr)));
			
			foreach ($user_list_tmp as $user) {
				$tmp = array();
				$tmp['avatar'] = $user['avatar'];
				if ($is_anonymous) {
					$tmp['nickname'] = anonymous($user['nickname'] ? $user['nickname'] : $user['phone']);
				} else {
					$tmp['nickname'] = $user['nickname'] ? $user['nickname'] : $user['phone'];
				}
				
				$user_list[$user['uid']] = $tmp;
			}
		}
		
		return array('order_list' => $order_list, 'user_list' => $user_list);
	}

	//自营商品分销利润
	public function getSelfSellerProfit($where)
	{
		$seller_profit = 0;
		$order_products = D('Order_product')->where($where)->select();
		foreach ($order_products as $order_product) {
			if (!empty($order_product['original_product_id']) && $order_product['original_product_id'] != $order_product['product_id']) {
				continue;
			}
			$seller_profit += $order_product['profit'];
		}
		return number_format($seller_profit, 2, '.', '');
	}

	//批发商品分销利润
	public function getWsSellerProfit($where)
	{
		$where['original_product_id'] = array('>', 0);
		$order_products = D('Order_product')->where($where)->select();
		$profits = array();
		if (!empty($order_products)) {
			foreach ($order_products as $order_product) {
				if ($order_product['product_id'] == $order_product['original_product_id']) {
					continue;
				}
				$product = D('Product')->field('store_id')->where(array('product_id' => $order_product['original_product_id']))->find();
				if (!empty($product)) {
					$profits[$product['store_id']] += $order_product['profit'];
				}
			}
		}
		return $profits;
	}
}
?>