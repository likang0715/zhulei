<?php
/**
 * 订单商品数据模型
 */
class order_product_model extends base_model{
	/*得到一个订单的商品信息*/
	public function orderProduct($order_id,$getPro=true){
		if($getPro){
			$orderProduct = D('')->table(array('Product'=>'p','Order_product'=>'op'))->field('*,p.supplier_id AS wholesale_supplier_id')->where("`op`.`order_id`='$order_id' AND `op`.`product_id`=`p`.`product_id`")->order('`op`.`pigcms_id` ASC')->select();
		}else{
			$orderProduct = $this->db->where(array('order_id'=>$order_id))->order('`pigcms_id` ASC')->select();
		}
		foreach($orderProduct as &$value){
			if($value['sku_id']){
				$value['sku_data_arr'] = unserialize($value['sku_data']);
			}
			if($value['comment']){
				$value['comment_arr'] = unserialize($value['comment']);
			}

			$value['image'] = getAttachmentUrl($value['image']);
		}
		return $orderProduct;
	}

	/**
	 * 获取一个产品，用户购买此产品的历史数量
	 * 主要用于限购
	 */
	public function getProductPronum($product_id, $uid) {
		if (empty($product_id) || empty($uid)) {
			return 0;
		}

		$db_prefix = option('system.DB_PREFIX');
		$sql = "SELECT SUM(op.pro_num) as pro_num FROM " . $db_prefix . "order_product as op left join " . $db_prefix . "order AS o ON op.order_id = o.order_id WHERE o.uid = '" . $uid . "' AND op.product_id = '" . $product_id . "' AND o.status in (0, 1, 2, 3, 4, 7)";
		$pro_num = $this->db->query($sql);

		return $pro_num[0]['pro_num'];
	}

	public function getProducts($order_id) {

		$products = $this->db->query("SELECT p.is_wholesale,p.wholesale_price,p.drp_level_1_price,p.drp_level_2_price,p.drp_level_3_price, p.drp_level_1_cost_price,p.drp_level_2_cost_price,p.drp_level_3_cost_price, p.product_id,p.name,p.image,p.supplier_id,p.store_id,p.wholesale_product_id,op.pigcms_id,op.pro_num,op.pro_price,op.sku_id,op.sku_data,op.comment,op.is_packaged,op.in_package_status,op.is_fx,op.original_product_id,op.is_present,op.return_status,op.rights_status,op.profit,op.point,op.discount,op.drp_degree_profit,op.return_point,op.subscribed_discount FROM " . option('system.DB_PREFIX') . "order_product op, " . option('system.DB_PREFIX') . "product p WHERE op.product_id = p.product_id AND op.order_id = '" . $order_id . "'");

		foreach ($products as &$value) {
			$value['image'] = getAttachmentUrl($value['image']);
		}

		return $products;
	}

	/**
	 * 获取订单中属于本门店的产品
	 */
	public function getProductsPhysical($order_id, $physical_id=0){
		$products = $this->db->query("SELECT p.product_id,p.name,p.image,p.supplier_id,p.store_id,p.wholesale_product_id,op.pigcms_id,op.pro_num,op.pro_price,op.sku_id,op.sku_data,op.comment,op.is_packaged,op.in_package_status,op.is_fx,op.original_product_id,op.is_present,op.return_status,op.rights_status,op.profit FROM " . option('system.DB_PREFIX') . "order_product op, " . option('system.DB_PREFIX') . "product p WHERE op.product_id = p.product_id AND op.order_id = '" . $order_id . "' AND op.sp_id = " . $physical_id);

		foreach($products as &$value){
			$value['image'] = getAttachmentUrl($value['image']);
		}

		return $products;
	}

	/**
	 * 查看用户对产品是否未评论
	 */
	public function isComment($product_id, $is_pc = true,$order_id = "", $pigcms_id = "") {
		if (empty($product_id)) {
			return false;
		}
		$wheres = "";
		
		if ($is_pc) {
			$uid = $_SESSION['user']['uid'];
		} else {
			$uid = $_SESSION['wap_user']['uid'];
		}
		if($order_id) {
			$wheres = " and o.order_id = '".$order_id."'";
		}
		if ($pigcms_id) {
			$wheres .= " and op.pigcms_id = '" . $pigcms_id . "'";
		}
		
		$db_prefix = option('system.DB_PREFIX');
		$sql = "SELECT op.* FROM " . $db_prefix . "order_product op, " . $db_prefix . "order o WHERE op.order_id = o.order_id AND o.uid = '" . $uid . "' AND op.product_id = '" . $product_id . "' AND o.status in(4,7) AND op.return_status != 2 AND op.is_comment = 0 ".$wheres." LIMIT 1";
		$order_product = $this->db->query($sql);

		if (empty($order_product)) {
			return false;
		} else {
			return $order_product[0];
		}
	}

    //主订单分销商品
    public function getFxProducts($order_id, $fx_order_id, $supplier = false)
    {
        $sql = "SELECT DISTINCT op.*,fop.cost_price AS price FROM " . option('system.DB_PREFIX') . "order_product op," . option('system.DB_PREFIX') . "fx_order_product fop WHERE op.product_id = fop.source_product_id AND op.sku_id = fop.sku_id AND op.order_id = '" . $order_id . "' AND fop.fx_order_id = '" . $fx_order_id . "'";
        if (!$supplier) {
            $sql .= ' AND op.is_fx = 1';
        }
        $products = $this->db->query($sql);
        return $products;
    }

    //设置包裹信息
    public function setPackageInfo($where, $data)
    {
        return $this->db->where($where)->data($data)->save();
    }

    //未打包商品 未分配门店商品 加获取sku_id
    public function getUnPackageSkuProducts($order_id)
    {	
        $products = $this->db->query("SELECT p.product_id,p.name,p.image,op.pigcms_id as order_product_id,op.pro_num,op.pro_price,op.sku_data,op.comment,op.is_packaged,op.in_package_status,op.sku_id FROM " . option('system.DB_PREFIX') . "order_product op, " . option('system.DB_PREFIX') . "product p WHERE op.product_id = p.product_id AND op.order_id = '" . $order_id . "' AND op.is_packaged = 0 AND op.is_fx = 0 AND op.sp_id = 0");
        return $products;
    }

    //获取订单商品中该门店 未分配(打包)的
    public function getUnAssignProducts($order_id, $physical_id)
    {
    	if (empty($order_id) || empty($physical_id))
    		return array();

    	$products = $this->db->query("SELECT p.product_id,p.name,p.image,op.pigcms_id as order_product_id,op.pro_num,op.pro_price,op.sku_data,op.comment,op.is_packaged,op.in_package_status,op.sku_id FROM " . option('system.DB_PREFIX') . "order_product op, " . option('system.DB_PREFIX') . "product p WHERE op.product_id = p.product_id AND op.order_id = '" . $order_id . "' AND op.sp_id = '" . $physical_id . "' AND op.is_packaged = 0 AND op.is_fx = 0");

        // 过滤退货的商品，主要在订单未发货状态，发生过退货
        $product_list = array();
        foreach ($products as $product) {
        	if ($product['return_status'] == 2) {
        		continue;
        	} else if ($product['return_status'] == 1) {
        		$count = M('Return_product')->returnNumber($product['order_id'], $product['order_product_id'], true);
        		$product['pro_num'] = $product['pro_num'] - $count;
        
        		if ($product['pro_num'] > 0) {
        			$product_list[] = $product;
        		}
        	} else {
        		$product_list[] = $product;
        	}
        }
        
        return $product_list;

    }

    //未打包的商品(不包括分销商品)
    public function getUnPackageProducts($params)
    {
		$where = '';
		foreach ($params as $field => $param) {
			$where .= " AND " . $field . " = " . "'" . $param . "'";
		}
		$products = $this->db->query("SELECT op.pigcms_id as order_product_id, op.order_id, p.product_id,p.name,p.image,op.pro_num,op.pro_price,op.sku_id,op.sku_data,op.comment,op.is_packaged,op.in_package_status,op.return_status,op.sp_id FROM " . option('system.DB_PREFIX') . "order_product op, " . option('system.DB_PREFIX') . "product p WHERE op.product_id = p.product_id " . $where . " AND op.is_packaged = 0 AND op.is_fx = 0");
		
		// 过滤退货的商品，主要在订单未发货状态，发生过退货
		$product_list = array();
		foreach ($products as $product) {
			if ($product['return_status'] == 2) {
				continue;
			} else if ($product['return_status'] == 1) {
				$count = M('Return_product')->returnNumber($product['order_id'], $product['order_product_id'], true);
				$product['pro_num'] = $product['pro_num'] - $count;
				
				if ($product['pro_num'] > 0) {
					$product_list[] = $product;
				}
			} else {
				$product_list[] = $product;
			}
		}
		
		return $product_list;
	}

    //未打包的商品（）
    public function getUnPackageProductCount($where)
    {
        $count = $this->db->where($where)->count('product_id');
        return $count;
    }

    //获取订单商品的总数 physical_id / product_id + pro_num
    public function getOrderProductCount($where)
    {
    	$where = !empty($where) ? ' AND '.$where : '';
    	$sql = "SELECT SUM(op.pro_num) AS num FROM " . option('system.DB_PREFIX') . "order_product op, " . option('system.DB_PREFIX') . "order o WHERE op.order_id = o.order_id " . $where;
        $count = $this->db->query($sql);
        return !empty($count[0]['num']) ? $count[0]['num'] : 0;
    }

    //获取订单商品的总价格 physical_id / product_id + pro_num
    // public function getOrderProductCount($where)
    // {
    // 	$where = !empty($where) ? ' AND '.$where : '';
    // 	$sql = "SELECT SUM(op.pro_num*) AS num FROM " . option('system.DB_PREFIX') . "order_product op, " . option('system.DB_PREFIX') . "order o WHERE op.order_id = o.order_id " . $where;
    //     $count = $this->db->query($sql);
    //     return !empty($count[0]['num']) ? $count[0]['num'] : 0;
    // }

    public function add($data)
    {
        return $this->db->data($data)->add();
    }

    //店铺自有商品
    public function getStoreProduct($order_id)
    {
        $products = $this->db->where(array('order_id' => $order_id, 'is_fx' => 0))->select();
        return $products;
    }

    //店铺自有商品金额
    public function getStoreProductAmount($order_id)
    {
        $amount = $this->db->where(array('order_id' => $order_id, 'is_fx' => 0))->sum('pro_price * pro_num');
        return !empty($amount) ? $amount : 0;
    }

	/**
	 * 获取订单商品
	 * @param $where
	 */
	public function getProduct($order_product_id)
	{
		$products = $this->db->query("SELECT op.*,o.store_id FROM " . option('system.DB_PREFIX') . "order_product op, " . option('system.DB_PREFIX') . "order o WHERE op.order_id = o.order_id AND op.pigcms_id = '" . $order_product_id . "'");
		return !empty($products[0]) ? $products[0] : array();
	}

	/**
	 *
	 * @param $order_product_id
	 */
	public function getImageProduct($order_product_id)
	{
		$products = $this->db->query("SELECT p.product_id,p.name,p.image,p.supplier_id,p.store_id,p.wholesale_product_id,op.pigcms_id,op.pro_num,op.pro_price,op.sku_id,op.sku_data,op.comment,op.is_packaged,op.in_package_status,op.is_fx,op.original_product_id,op.is_present,op.return_status,op.rights_status,op.profit FROM " . option('system.DB_PREFIX') . "order_product op, " . option('system.DB_PREFIX') . "product p WHERE op.product_id = p.product_id AND op.pigcms_id = '" . $order_product_id . "'");

		$product = !empty($products[0]) ? $products[0] : array();
		if (!empty($product)) {
			$product['image'] = getAttachmentUrl($product['image']);
		}

		return $product;
	}

	/**
	 * @param $physical_id
	 */
	public function getOrderByPhysical($physical_id)
	{
		$order_ids = array();
		if (empty($physical_id)) { 
			return $order_ids; 
		}
		$sql = "SELECT DISTINCT `order_id` FROM " . option('system.DB_PREFIX') . "order_product WHERE sp_id = ".$physical_id;
		$order_data = $this->db->query($sql);
		if (empty($order_data)) {
			return $order_ids;
		}
		foreach ($order_data as $val) {
			$order_ids[] = $val['order_id'];
		}
		return $order_ids;
	}

	/**
	 * 获取一个订单里，自营的产品列表
	 * 主要用来打印订单
	 */
	public function getProductOwn($params) {
		$where = '';
		foreach ($params as $field => $param) {
			$where .= " AND " . $field . " = " . "'" . $param . "'";
		}
		$product_list = $this->db->query("SELECT p.wholesale_price,p.drp_level_1_price,p.drp_level_2_price,p.drp_level_3_price, p.drp_level_1_cost_price,p.drp_level_2_cost_price,p.drp_level_3_cost_price, p.product_id,p.name,p.image,p.supplier_id,p.store_id,p.wholesale_product_id,op.pigcms_id,op.pro_num,op.pro_price,op.sku_id,op.sku_data,op.comment,op.is_packaged,op.in_package_status,op.is_fx,op.original_product_id,op.is_present,op.return_status,op.rights_status,op.profit,op.in_package_status,op.return_status FROM " . option('system.DB_PREFIX') . "order_product op, " . option('system.DB_PREFIX') . "product p WHERE op.product_id = p.product_id " . $where . " AND op.is_fx = 0");
		
		return $product_list;
	}
	
	/**
	 * 获取用户购买某个产品的数量
	 * 退货的会考虑进去
	 */
	public function getBuyNumber($uid, $product_id, $user_type = 'uid') {
		if ($user_type == 'uid') {
			$where_sql = "o.uid = '" . $uid . "' AND o.status != 5 AND op.product_id = '" . $product_id . "'";
		} else {
			// 游客购买只能不计算完全退货
			$where_sql = "o.session_id = '" . $uid . "' AND o.status != 5 AND op.product_id = '" . $product_id . "' AND op.return_status != 2";
		}
		
		$number = D('')->table('Order AS o')->join('Order_product AS op ON o.order_id = op.order_id')->where($where_sql)->field("sum(op.pro_num) as number")->find();
		
		if ($number['number'] == 0) {
			return 0;
		}
		
		if ($user_type != 'uid') {
			return $number['number'] + 0;
		}
		
		$return_count = D('')->table('Return_product AS rp')->join('Return AS r ON r.id = rp.return_id')->where("r.status in (3, 4, 5) AND r.uid = '" . $uid . "' AND r.user_return_id = 0 AND rp.product_id = '" . $product_id . "'")->count('r.id');
		
		$return = 0;
		// 防止退货机制有问题，出现负数
		if ($number['number'] > $return_count) {
			$return = $number['number'] - $return_count;
		}
		
		return $return;
	}
	
	/**
	 * 统计商购买的记录
	 * 统计订单状态为3、4或7，没有全部退货的购买记录
	 */
	public function getProductBuyCount($product_id) {
		if (empty($product_id)) {
			return 0;
		}
		
		$count = D('Order_product AS op')->join('Order AS o ON o.order_id = op.order_id', 'LEFT')->where("op.product_id = '" . $product_id . "' AND op.return_status != 2 AND o.status in (3, 4, 7)")->count('o.order_id');
		return $count;
	}
	
	/**
	 * 统计商购买的记录
	 * 统计订单状态为3、4或7，没有全部退货的购买记录
	 */
	public function getProductBuyList($product_id, $limit = 10, $offset = 0, $is_user = false) {
		if (empty($product_id)) {
			return 0;
		}
	
		$order_product_list = D('Order_product AS op')->join('Order AS o ON o.order_id = op.order_id', 'LEFT')->field('op.pro_num, op.return_status, o.uid, o.add_time')->where("op.product_id = '" . $product_id . "' AND op.return_status != 2 AND o.status in (3, 4, 7)")->limit($offset . ', ' . $limit)->order('op.pigcms_id DESC')->select();
		
		$return_order_product_list = array();
		$uid_arr = array();
		foreach ($order_product_list as $order_product) {
			if ($order_product['return_status'] > 0) {
				$return_count = D('')->table('Return_product AS rp')->join('Return AS r ON r.id = rp.return_id')->where("r.status in (3, 4, 5) AND r.uid = '" . $order_product['uid'] . "' AND r.user_return_id = 0 AND rp.product_id = '" . $product_id . "'")->count('r.id');
				if ($return_count >= $order_product['pro_num']) {
					continue;
				}
				
				$order_product['pro_num'] -= $return_count;
			}
			$order_product['add_time'] = date('Y-m-d H:i', $order_product['add_time']);
			$uid_arr[] = $order_product['uid'];
			$return_order_product_list[] = $order_product;
		}
		
		$user_list = array();
		if ($uid_arr) {
			$where = array();
			$where['uid'] = array('in', $uid_arr);
			$user_list = M('User')->getList($where);
		}
		
		return array('order_product_list' => $return_order_product_list, 'user_list' => $user_list);
	}
}
?>