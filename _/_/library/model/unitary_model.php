<?php
/**
 * 夺宝活动
 * User: pigcms_89
 * Date: 2016/03/08
 * Time: 10:40
 */

class unitary_model extends base_model
{

	// 统计数量
	public function getCount ($where) {
		$count = $this->db->field('count(1) as count')->where($where)->find();
		return $count['count'];
	}

	// 店铺夺宝活动 列表
	public function getList ($where, $order_by = '', $limit = 0, $offset = 0) {
		$this->db->where($where);
		if (!empty($order_by)) {
			$this->db->order($order_by);
		}
		
		if (!empty($limit)) {
			$this->db->limit($offset . ',' . $limit);
		}
		
		$list = $this->db->select();
		
		return $list;
	}

	// 获取排序方式数组
	public function getSort ($on_name = 'proportion') {

		$sort = array(
			array(
				'name' => 'proportion',
				'txt' => '即将揭晓',
				'on' => 0,
			),
			array(
				'name' => 'renqi',
				'txt' => '人气',
				'on' => 0,
			),
			array(
				'name' => 'priceup',
				'txt' => '价格(由高到低)',
				'on' => 0,
			),
			array(
				'name' => 'pricedown',
				'txt' => '价格(由低到高)',
				'on' => 0,
			),
			array(
				'name' => 'addtime',
				'txt' => '最新',
				'on' => 0,
			),
		);

		foreach ($sort as &$val) {
			if ($val['name'] == $on_name) {
				$val['on'] = 1;
			}
		}

		return $sort;
	}

	// 获取一条夺宝记录
	public function getUnitary ($unitary_id = 0, $is_anonymous = false) {

		$find_unitary = $this->db->where(array('id'=>$unitary_id))->find();

		if ($find_unitary['state'] == 2) {

			$where = array(
				'unitary_id' => $find_unitary['id'],
				'store_id' => $find_unitary['store_id'],
				'state' => 1,
			);
			$find_lucknum = D('Unitary_lucknum')->where($where)->find();

			// 数据残缺 unitary lucknum缺少
			if (!empty($find_lucknum)) {

				if ($find_unitary['lucknum'] != $find_lucknum['lucknum']) {
					D('Unitary')->where(array('id'=>$find_unitary['id']))->data(array('lucknum'=>$find_lucknum['lucknum']))->save();
				}

				$find_user = D('User')->where(array('uid'=>$find_lucknum['uid']))->find();

				if ($is_anonymous) {
					$find_unitary['user_name'] = !empty($find_user['nickname']) ? anonymous(htmlspecialchars($find_user['nickname'])) : '匿名用户';
				} else {
					$find_unitary['user_name'] = !empty($find_user['nickname']) ? $find_user['nickname'] : '匿名用户';
				}

			}


		}

		return $find_unitary;
	}

	// 获取活动已经购买的数额
	public function getPayCount ($unitary_id = 0) {

		$where_lucknum['unitary_id'] = $unitary_id;
		$pay_count = D('Unitary_lucknum')->where($where_lucknum)->count('id');

		return $pay_count;

	}

	// 获取活动已经购买金额
	public function getPayMoney ($unitary_id = 0) {

		$where_lucknum['unitary_id'] = $unitary_id;
		$pay_count = D('Unitary_lucknum')->where($where_lucknum)->count();

		$find_unitary = $this->getUnitary($unitary_id);

		return $pay_count*$find_unitary['item_price'];

	}

	// 获取活动的图片数组
	public function getPics ($find_unitary = array()) {

		$images = M('Product_image')->getImages($find_unitary['product_id']);

		$unitary_pic = array();
		if (!empty($images)) {
			foreach ($images as $val) {
				$unitary_pic[] = $val['image'];
			}
		}
		
		return $unitary_pic;

	}

	// 获取参与活动的所有用户 数组 $is_all = true 取所有，false 只取失败者的
	public function getBuyUser ($unitary_id = 0, $is_all = true) {

		$where = ($is_all) ? array('unitary_id'=>$unitary_id) : array('unitary_id'=>$unitary_id, 'state'=>0);
		$lucknum_list = D('Unitary_lucknum')->where($where)->select();

		$uid_array = array();
		foreach ($lucknum_list as $val) {
			$uid_array[$val['uid']] = $val['uid'];
		}

		return $uid_array;
	}

	// 获取店铺中用户中奖次数
	public function getLuckCount ($uid = 0, $store_id = 0) {
		$where = array('uid'=>$uid, 'state'=>1);
		if (!empty($store_id)) {
			$where = array_merge($where, array('store_id'=> $store_id));
		}
		$count = D('Unitary_lucknum')->where($where)->count("id");
		return $count;
	}

	// 获取用户 在店铺中中奖的夺宝ID数组
	public function getLuckUnitaryArr ($uid = 0, $store_id = 0) {

		$where_lucknum = array(
			'uid' => $uid,
			'state' => 1,
		);

		if (!empty($store_id)) {
			$where_lucknum = array_merge($where_lucknum, array('store_id' => $store_id));
		}

		$luck_unitary_ids = array();
		$lucknum_list = D('Unitary_lucknum')->where($where_lucknum)->select();
		foreach ($lucknum_list as $val) {
			$luck_unitary_ids[] = $val['unitary_id'];
		}

		return $luck_unitary_ids;

	}

	// 生成幸运号码时调用，构造订单到order表
	function unitaryAddOrder ($unitary_id = 0) {

		if (empty($unitary_id) || !$find_unitary = D('Unitary')->where(array('id'=>$unitary_id))->find()) {
			return false;
			// return 1;exit;
		}

		$find_lucknum = D('Unitary_lucknum')->where(array('state'=>1, 'unitary_id'=>$unitary_id))->find();
		if (empty($find_lucknum) || !$find_order = D('Unitary_order')->where(array('pigcms_id'=>$find_lucknum['order_id']))->find()) {
			return false;
			// return 2;exit;
		}

		// 已经生成了对应的unitary订单，则退出
		if ($store_order = D('Order')->where(array('activity_id'=>$find_unitary['id'], 'activity_type'=>'unitary'))->find()) {
			return false;
			// return 3;exit;
		}

		$uid = $find_lucknum['uid'];

		$nowStore = D('Store')->where(array('store_id' => $find_unitary['store_id']))->find();

		//验证商品
		$nowProduct = D('Product')->field('`product_id`,`store_id`,`price`,`after_subscribe_discount`,`after_subscribe_price`,`has_property`,`status`,`supplier_id`,`buyer_quota`,`weight`,`is_fx`,`unified_price_setting`,`drp_level_1_price`,`drp_level_2_price`,`drp_level_3_price`, `send_other`, `wholesale_product_id`, `open_return_point`, `return_point`')->where(array('product_id' => $find_unitary['product_id']))->find();
		if (empty($nowProduct) || empty($nowProduct['status'])) {
			// json_return(1000, '商品不存在');
			return false;
			// return 4;exit;
		}

		$weight = $nowProduct['weight'];

		if (empty($nowProduct['has_property'])) {
			// 无商品属性
			$skuId = 0;
			$propertiesStr = '';
		} else {

			// 有商品属性
			$skuId = $find_unitary['sku_id'];

			//判断库存是否存在
			$nowSku = D('Product_sku')->field('`sku_id`,`product_id`,`properties`,`price`,`after_subscribe_price`, `weight`,`drp_level_1_price`,`drp_level_2_price`,`drp_level_3_price`')->where(array('sku_id' => $skuId))->find();
			
			if ($nowSku['weight']) {
				$weight = $nowSku['weight'];
			}
			$tmpPropertiesArr = explode(';', $nowSku['properties']);
			$properties = $propertiesValue = $productProperties = array();
			foreach ($tmpPropertiesArr as $value) {
				$tmpPro = explode(':', $value);
				$properties[] = $tmpPro[0];
				$propertiesValue[] = $tmpPro[1];
			}
			if (count($properties) == 1) {
				$findPropertiesArr = D('Product_property')->field('`pid`,`name`')->where(array('pid' => $properties[0]))->select();
				$findPropertiesValueArr = D('Product_property_value')->field('`vid`,`value`')->where(array('vid' => $propertiesValue[0]))->select();
			} else {
				$findPropertiesArr = D('Product_property')->field('`pid`,`name`')->where(array('pid' => array('in', $properties)))->select();
				$findPropertiesValueArr = D('Product_property_value')->field('`vid`,`value`')->where(array('vid' => array('in', $propertiesValue)))->select();
			}
			foreach ($findPropertiesArr as $value) {
				$propertiesArr[$value['pid']] = $value['name'];
			}
			foreach ($findPropertiesValueArr as $value) {
				$propertiesValueArr[$value['vid']] = $value['value'];
			}
			foreach ($properties as $key => $value) {
				$productProperties[] = array('pid' => $value, 'name' => $propertiesArr[$value], 'vid' => $propertiesValue[$key], 'value' => $propertiesValueArr[$propertiesValue[$key]]);
			}
			$propertiesStr = serialize($productProperties);

		}

		if (strpos($find_order['trade_no'], 'DBPAY') !== false) {
			//立即购买
			// $trade_no = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
			$trade_no = trim($find_order['trade_no'], 'DBPAY_');
			$data_order['store_id'] = $find_unitary['store_id'];
			$data_order['order_no'] = $trade_no;
			$data_order['trade_no'] = $trade_no;

			$data_order['activity_id'] = $find_unitary['id'];
			$data_order['activity_type'] = 'unitary';
			$data_order['activity_orderid'] = $find_order['orderid'];

		} else {
			return false;
			// return 5;exit;
		}

		$order_no = $data_order['order_no'];
		$data_order['order_no'] = $data_order['trade_no'] = $order_no;
		$data_order['uid'] = $find_order['uid'];
		
		$data_order['pro_num'] = 1;
		$data_order['pro_count'] = 1;

		$data_order['payment_method'] = $find_order['paytype'];
		// $data_order['bak'] = $_POST['bak'] ? serialize($_POST['bak']) : '';
		// $data_order['activity_data'] = serialize($find_unitary);
		$data_order['add_time'] = $_SERVER['REQUEST_TIME'];

		$quantity = 1;
		$product_price = $find_unitary['item_price'] * $find_unitary['total_num'];
		$data_order['sub_total'] = $data_order['total'] = $product_price;
		$data_order['order_pay_point'] = 0;
		$data_order['is_point_order'] = 0;

		$data_order['address'] = $find_order['address'];
		$data_order['address_user'] = $find_order['address_user'];
		$data_order['address_tel'] = $find_order['address_tel'];
		$data_order['status'] = 2;
		$data_order['type'] = 51; //用于活动类型 50砍价、51夺宝、52秒杀
		$order_id = D('Order')->data($data_order)->add();
		$nowOrder = array_merge($data_order, array('order_id'=>$order_id));

		if (empty($order_id)) {
			// 生成订单失败
			return false;
			// return 6;exit;
		}

		$data_order_product['order_id'] = $order_id;
		$data_order_product['product_id'] = $nowProduct['product_id'];
		$data_order_product['sku_id']	 = $skuId;
		$data_order_product['sku_data']   = $propertiesStr;
		$data_order_product['pro_num']	= $quantity;
		$data_order_product['pro_price']  = $product_price;
		$data_order_product['comment']	= '夺宝自动生成订单';
		$data_order_product['pro_weight'] = $weight;

		$product_info = D('Product')->field('is_fx,product_id,store_id,original_product_id,supplier_id,wholesale_product_id,name, check_give_points, check_degree_discount, give_points')->where(array('product_id' => $nowProduct['product_id']))->find();
		if ($product_info['store_id'] == $nowStore['store_id'] && empty($product_info['supplier_id'])) { //店铺自营商品
			$supplier_id		 = 0;
			$original_product_id = 0;
			$data_order_product['is_fx']			   = 0;
			$data_order_product['supplier_id']		   = $supplier_id;
			$data_order_product['original_product_id'] = $original_product_id;
		} else {
			// 非自营商品报错
			return false;
			// return 7;exit;
		}

		$data_order_product['user_order_id']	   = $order_id;

		// 添加$data_order_product、
		if (D('Order_product')->data($data_order_product)->add()) {

			// 产生提醒
			// import('source.class.Notify');
			// Notify::createNoitfy($nowStore['store_id'], option('config.orderid_prefix') . $order_no);

			//////////////////////////////////////////////////////////////////////////////////////////////////
			// $uid = $find_order['uid'];
			// $first_product_name = $product_info ? msubstr($product_info['name'],0,11) : "";
			
			// //产生提醒-已生成订单
			// import('source.class.Notice');
			// Notice::sendOut($uid, $nowOrder,$first_product_name);

			//////////////////////////////////////////////////////////////////////////////////////////////////	
			// json_return(0, $config['orderid_prefix'] . $order_no);
			import('source.class.OrderPay');
	        $pay = new OrderPay();
	        $result = $pay->pay_callback(
	        	$order_no, 
	        	$find_order['total'], 
	        	$find_order['paytype'], 
	        	$find_order['third_id'], 
	        	$find_order['third_data']
	        );

			return true;

		} else {
			D('Order')->where(array('order_id' => $order_id))->delete();
			return false;
			// return 8;exit;
			// json_return(1005, '订单产生失败，请重试');
		}
	}

	// 通过key获取各个分类的 夺宝活动列表
	public function getListByKey ($cat_key = '', $set_limit = 0, $is_pc = true) {

		static $cat_key_arr;
		$cat_id = 0;
		if (isset($cat_key_arr[$cat_key])) {
			$cat_id = $cat_key_arr[$cat_key]['cat_id'];
			if (!empty($cat_key_arr[$cat_key]['cat_num'])) {
				$limit = $cat_key_arr[$cat_key]['cat_num'];
			}
		} else {
			$activity_home_category_list = D('Activity_home_category')->select();
			foreach ($activity_home_category_list as $activity_home_category) {
				$cat_key_arr[$activity_home_category['cat_key']] = $activity_home_category;
				
				if ($activity_home_category['cat_key'] == $cat_key) {
					$cat_id = $activity_home_category['cat_id'];
					if (!empty($activity_home_category['cat_num'])) {
						$limit = $activity_home_category['cat_num'];
					}
				}
			}
		}

		$limit = !empty($set_limit) ? intval($set_limit) : $limit;

		$unitary_list = array();
		$recommend_list = D('Activity_home')->where(array('cat_id'=>$cat_id, 'status'=>1))->limit($limit)->select();
		foreach ($recommend_list as &$val) {
			$find_unitary = D('Unitary')->where(array('id'=>$val['activity_id']))->find();
			$find_unitary['proportion'] = round($find_unitary['proportion'], 2);

			if ($find_unitary['state'] != 2) {
				$find_unitary['pay_count'] = D('Unitary_lucknum')->where(array('unitary_id'=>$val['activity_id']))->count('id');
				$find_unitary['left_count'] = $find_unitary['total_num'] - $find_unitary['pay_count'];
			} else {
				$find_unitary['pay_count'] = $find_unitary['total_num'];
				$find_unitary['left_count'] = 0;
			}

			if ($find_unitary['state'] != 1) {
				continue;
			}
			$unitary_list[] = $find_unitary;
				
		}

		return $is_pc ? $unitary_list : $recommend_list;

	}

	// PC首页 获取最热商品
	public function getWebHot ($limit = 8) {

		$unitary_list = $this->getListByKey('pc_indiana_hot', $limit);
		$left_count = $limit - count($unitary_list);
		if ($left_count == 0) {
			return $unitary_list;
		}

		$has_ids = array();
		foreach ($unitary_list as $val) {
			$has_ids[] = $val['id'];
		}

		if (!empty($has_ids)) {
			$sql = "select * from ".option('system.DB_PREFIX')."unitary where `state` = 1 and `id` not in (".implode(',', $has_ids).") order by rand() limit $left_count";
		} else {
			$sql = "select * from ".option('system.DB_PREFIX')."unitary where `state` = 1 order by rand() limit $left_count";
		}

		// 数量不足
		$unitary_list_more = D('')->query($sql);
		foreach ($unitary_list_more as &$val) {
			$val['proportion'] = round($val['proportion'], 2);
			if ($val['state'] != 2) {
				$val['pay_count'] = D('Unitary_lucknum')->where(array('unitary_id'=>$val['id']))->count('id');
				$val['left_count'] = $val['total_num'] - $val['pay_count'];
			} else {
				$val['pay_count'] = $val['total_num'];
				$val['left_count'] = 0;
			}
		}

		$unitary_list = empty($unitary_list_more) ? $unitary_list : array_merge($unitary_list, $unitary_list_more);
		$left_null = $limit - count($unitary_list);
		if ($left_null > 0) {
			$null_array = array();
			for ($i = 0;$i < $left_null;$i++) {
				$null_array[] = array(); 
			}

			$unitary_list = array_merge($unitary_list, $null_array);
		}

		return $unitary_list;

	}

	// wap首页 获取最热商品
	public function getWapHot ($limit = 16) {

		$unitary_list = $this->getListByKey('wap_indiana_list', $limit);
		$left_count = $limit - count($unitary_list);
		if ($left_count == 0) {
			return $unitary_list;
		}

		// 数量不足
		$unitary_list_more = D('')->query("select * from ".option('system.DB_PREFIX')."unitary where `state` = 1 order by rand() limit $left_count");
		foreach ($unitary_list_more as &$val) {
			$val['proportion'] = round($val['proportion'], 2);
			if ($val['state'] != 2) {
				$val['pay_count'] = D('Unitary_lucknum')->where(array('unitary_id'=>$val['id']))->count('id');
				$val['left_count'] = $val['total_num'] - $val['pay_count'];
			} else {
				$val['pay_count'] = $val['total_num'];
				$val['left_count'] = 0;
			}
		}

		$unitary_list = empty($unitary_list_more) ? $unitary_list : array_merge($unitary_list, $unitary_list_more);

		return $unitary_list;

	}

	// 首页 获取最新揭晓的
	public function getLastFinish ($limit = 8) {

		$unitary_list = D('Unitary')->where(array('state'=>2))->order('endtime DESC')->limit($limit)->select();
		foreach ($unitary_list as &$val) {
			$find_lucknum = D('Unitary_lucknum')->where(array('unitary_id'=>$val['id'], 'state'=>1))->find();
			$find_user = D('User')->where(array('uid'=>$find_lucknum['uid']))->find();
			$val['user_name'] = !empty($find_user['nickname']) ? $find_user['nickname'] : '匿名用户';
			$val['lucknum'] = 1000000 + $val['lucknum'];

		}

		return $unitary_list;

	}

	// wap首页 获取最新揭晓的
	public function getWapLastFinish ($limit = 8) {

		$unitary_list = D('Unitary')->where(array('state'=>2))->order('endtime DESC')->limit($limit)->select();

		$time = time();

		foreach ($unitary_list as &$val) {
			$find_lucknum = D('Unitary_lucknum')->where(array('unitary_id'=>$val['id'], 'state'=>1))->find();
			$find_user = D('User')->field('nickname,uid')->where(array('uid'=>$find_lucknum['uid']))->find();
			$val['user_name'] = !empty($find_user['nickname']) ? $find_user['nickname'] : '匿名用户';
			$val['lucknum'] = 1000000 + $val['lucknum'];
			$val['proportion'] = round($val['proportion'], 2);
			$countdown_time = $val['endtime'] - $time;
			if ($countdown_time > 0) {
				$val['is_countdown'] = 1;
				$val['countdown_time'] = $countdown_time;
			} else {
				$val['is_countdown'] = 0;
				$val['countdown_time'] = 0;
			}
		}

		return $unitary_list;
	}

	// 首页 获取自定义分类活动
	public function getAdverList () {

		// 父级类
		$custom_category = D('Activity_home_category')->where(array('cat_key'=>'wap_indiana_define'))->find();
		if (empty($custom_category)) {
			return array();
		}

		// 下面的所有分类
		$custom_category_list = D('Activity_home_category')->where(array('fid'=>$custom_category['cat_id'], 'cat_type'=>2))->select();
		if (empty($custom_category_list)) {
			return array();
		}

		$category_list = array();
		$cate_ids = array();
		foreach ($custom_category_list as $val) {
			$category_list[$val['cat_id']] = $val;
			$category_list[$val['cat_id']]['list'] = array();
			$cate_ids[] = $val['cat_id'];
		}

		$custom_unitary_all = D('Activity_home')->where(array('cat_id'=>array('in', $cate_ids), 'status'=>1))->select();

		foreach ($custom_unitary_all as $val) {

			$find_unitary = D('Unitary')->where(array('id'=>$val['activity_id']))->find();
			if ($find_unitary['state'] != 1) {
				continue;
			}

			if ($find_unitary['state'] == 1) {
				$find_unitary['pay_count'] = D('Unitary_lucknum')->where(array('unitary_id'=>$val['activity_id']))->count('id');
				$find_unitary['left_count'] = $find_unitary['total_num'] - $find_unitary['pay_count'];
			}

			$category_list[$val['cat_id']]['list'][] = $find_unitary;

		}

		$limit = 5;
		foreach ($category_list as &$val) {

			$has_ids = array();
			$left_count = $limit - count($val['list']);
			foreach ($val['list'] as $v) {
				$has_ids[] = $v['id'];
			}

			if (!empty($has_ids)) {
				$sql = "select * from ".option('system.DB_PREFIX')."unitary where `cat_fid` = ".$val['product_category']." and `state` = 1 and `id` not in (".implode(',', $has_ids).") order by rand() limit $left_count";
			} else {
				$sql = "select * from ".option('system.DB_PREFIX')."unitary where `cat_fid` = ".$val['product_category']." and `state` = 1 order by rand() limit $left_count";
			}

			// 数量不足
			$unitary_list_more = D('')->query($sql);
			foreach ($unitary_list_more as $k => $v) {
				$unitary_list_more[$k]['pay_count'] = D('Unitary_lucknum')->where(array('unitary_id'=>$v['id']))->count('id');
				$unitary_list_more[$k]['left_count'] = $v['total_num'] - $v['pay_count'];
			}

			$val['list'] = empty($unitary_list_more) ? $val['list'] : array_merge($val['list'], $unitary_list_more);
			$left_null = $limit - count($val['list']);
			if ($left_null > 0) {
				$null_array = array();
				for ($i = 0;$i < $left_null;$i++) {
					$null_array[] = array(); 
				}

				$val['list'] = array_merge($val['list'], $null_array);
			}

			krsort($val['list']);
			$val['custom'] = array_pop($val['list']);
			ksort($val['list']);

			// 从product_category中取新增的分类图片
			$find_category = M('Product_category')->getCategory($val['product_category']);
			$val['cat_indiana_adver'] = !empty($find_category['cat_indiana_adver']) ? getAttachmentUrl($find_category['cat_indiana_adver']) : '';

		}

		return $category_list;

	}

	// 获取夺宝商品图片
	public function getImages ($product_id, $limit = 4) {
        $images = D('Product_image')->field('`image`')->where(array('product_id' => $product_id))->order('sort ASC')->limit(5)->select();
		foreach($images as &$value){
			$value['image'] = getAttachmentUrl($value['image']);
		}
        return $images;
    }

    // 获取开启的夺宝专区数组
    public function getArea ($type = 'id') {

    	$area_array = array();
    	$area_list = D('Activity_icon')->where(array('type'=>1, 'status'=>1))->select();
    	foreach ($area_list as $val) {
    		$area_array[$val['key']] = getAttachmentUrl($val['imgurl']);
    	}

    	if (empty($area_array)) {
    		return array();
    	}

    	return $area_array;

    }

    // 最新揭晓的活动
    public function getLastEndList ($limit = 18) {

    	$limit = ($limit < 100) ? $limit : 100;

    	$time = time();
    	$unitaryList = D('Unitary')->where(array('state'=>2))->order('endtime DESC')->limit($limit)->select();
    	foreach ($unitaryList as &$val) {

			$val['pay_count'] = M('Unitary')->getPayCount($val['id']);
			$val['left_count'] = $val['total_num'] - $val['pay_count'];

			$count_down_time = $val['endtime'] - $time;
			if ($count_down_time > 30) {
				$val['is_countdown'] = 1;
				$val['countdown_time'] = $count_down_time;
			} else {
				$val['is_countdown'] = 0;
				$val['countdown_time'] = 0;
			}

			$where = array(
				'unitary_id' => $val['id'],
				'store_id' => $val['store_id'],
				'state' => 1,
			);
			$find_lucknum = D('Unitary_lucknum')->where($where)->find();

			// 数据残缺 unitary lucknum缺少
			if (!empty($find_lucknum)) {
				if ($find_unitary['lucknum'] != $find_lucknum['lucknum']) {
					D('Unitary')->where(array('id'=>$val['id']))->data(array('lucknum'=>$find_lucknum['lucknum']))->save();
				}

				$find_user = D('User')->field('nickname,uid,avatar,province,city')->where(array('uid'=>$find_lucknum['uid']))->find();
				$find_user['nickname'] = !empty($find_user['nickname']) ? $find_user['nickname'] : '匿名用户';
				$find_user['avatar'] = !empty($find_user['avatar']) ? $find_user['avatar'] : option('config.site_url').'/static/images/avatar.png';
				$find_user['address'] = !empty($find_user['province']) ? $find_user['province'].$find_user['city'] : '';

				$val['lucknum'] = 100000 + $val['lucknum'];
				$val['luck_user'] = $find_user;

			}

		}

		return $unitaryList;

    }

    // 参加比例最高的活动
    public function getFastList ($limit = 20) {

    	$limit = ($limit < 100) ? $limit : 100;

    	$unitaryList = D('Unitary')->where(array('state'=>1))->order('proportion DESC')->limit($limit)->select();
    	foreach ($unitaryList as &$val) {
			$val['pay_count'] = M('Unitary')->getPayCount($val['id']);
			$val['left_count'] = $val['total_num'] - $val['pay_count'];
		}

		return $unitaryList;

    }

    // 格式化microtime时间戳
    public function micro_date ($microtime, $type = 1) {
    	
    	$time = substr($microtime, 0, strlen($microtime)-3);
    	$last = intval(substr($microtime, strlen($microtime)-3,3));

    	if ($type == 2) {
    		$data_str = date("H:i:s", $time).'.'.$last;
    	} else {		
	    	$data_str = date("Y-m-d H:i:s", $time).'.'.$last;
    	}

    	return $data_str;
    }

    // 店铺详情中使用，获取关联的lucknum数组
    public function getLucknumArr ($where) {

    	if (empty($where)) {
    		return array();
    	}

    	$lucknumList = D('Unitary_lucknum')->where($where)->select();
    	if (empty($lucknumList)) {
    		return array();
    	}

    	$lucknumArray = array();
    	foreach ($lucknumList as $val) {
    		$lucknumArray[] = 100000 + $val['lucknum'];
    	}

    	return $lucknumArray;

    }

    // 获取一个结束活动的 参与计算的所有记录
    public function getJoinList ($unitary_id = 0) {

    	if (empty($unitary_id) || !$find_unitary = D('Unitary')->where(array('id'=>$unitary_id))->find()) {
    		return array();
    	}

    	if ($find_unitary['state'] != 2 || empty($find_unitary['lasttime']) || empty($find_unitary['lastnum'])) {
    		return array();
    	}

    	// $lucknumList = D('Unitary_lucknum')->where(array('id'=>array('<=', $find_unitary['lasttime'])))->order('addtime desc, id desc')->limit($find_unitary['lastnum'])->select();
    	$lucknumList = D('Unitary_lucknum')->where(array('unitary_id'=> $find_unitary['id']))->order('addtime desc')->limit($find_unitary['lastnum'])->select();
    	// dump($lucknumList);exit;
    	$time_total = 0;
    	foreach ($lucknumList as &$val) {

    		$thistime = floor($val['addtime']/1000);
			$ms = substr($val['addtime'],-3);
			$sum = date('H',$thistime).date('i',$thistime).date('s',$thistime).$ms;

			$time_total = $time_total + $sum;

    		//拆分日期
    		$val['date_left'] = date('Y-m-d', $thistime);
    		$val['date_right'] = date('H:i:s', $thistime).'.'.$ms;
    		$val['date_plus'] = $sum;

    		$find_user = D('User')->field('nickname')->where(array('uid'=>$val['uid']))->find();
			$val['nickname'] = !empty($find_user['nickname']) ? $find_user['nickname'] : '匿名用户';

			$find_unitary = D('Unitary')->field('name')->where(array('id'=>$val['unitary_id']))->find();
			$val['unitary_name'] = $find_unitary['name'];

    	}


    	$data = array();
    	$data['list'] = $lucknumList;
    	$data['time_total'] = $time_total;

    	$last_time = $lucknumList[0]['addtime'];
    	$data['last_date'] = date('Y-m-d H:i:s', floor($last_time/1000)).'.'.substr($last_time,-3);

    	return $data;

    }

    // 获取用户参与的活动数量
    public function getMyJoin ($uid = 0, $time, $store_id = 0) {

    	$where_all = " j.uid = $uid ";
    	$where_ing = " j.uid = $uid and u.state = 1 ";
    	$where_end = " j.uid = $uid and u.state = 2 and u.endtime <= $time ";
    	$where_reveal = " j.uid = $uid and u.state = 2 and u.endtime > $time ";
    	$where_luck = " uid = ".$uid." and state = 1 ";

    	if (!empty($store_id)) {
    		$where_all .= " and j.store_id = $store_id ";
			$where_ing .= " and j.store_id = $store_id ";
			$where_end .= " and j.store_id = $store_id ";
			$where_reveal .= " and j.store_id = $store_id ";
			$where_luck .= " and store_id = $store_id ";
    	}

    	$num_arr['all'] = D('')->table('Unitary as u')
				->join("Unitary_join as j On u.id=j.unitary_id")
				->where($where_all)
				->count('u.id');

    	$num_arr['ing'] = D('')->table('Unitary as u')
				->join("Unitary_join as j On u.id=j.unitary_id")
				->where($where_ing)
				->count('u.id');

		$num_arr['end'] = D('')->table('Unitary as u')
				->join("Unitary_join as j On u.id=j.unitary_id")
				->where($where_end)
				->count('u.id');

		$num_arr['reveal'] = D('')->table('Unitary as u')
				->join("Unitary_join as j On u.id=j.unitary_id")
				->where($where_reveal)
				->count('u.id');

		$num_arr['luck'] = D('Unitary_lucknum')
				->where($where_luck)
				->count('id');

		return $num_arr;

    }

    // 重新添加参与活动的关联 // M('Unitary')->reset_join();
    public function reset_join () {

    	$order_list = D('Unitary_order')->where(array('paid'=>1))->select();
    	foreach ($order_list as $val) {
    		$this->updateUserJoin($val['pigcms_id']);
    	}

    	// 更新unitary的cat_fid
    	$unitary_list = D('Unitary')->select();
    	foreach ($unitary_list as $val) {
    		$this->updateUnitaryCat($val['id'], $val['product_id']);
    	}

    }

    // 添加修改活动后，修改关联产品的大分类category_id到活动表
    public function updateUnitaryCat ($unitary_id, $product_id) {
    	$find_product = D('Product')->field('category_fid,product_id')->where(array('product_id'=>$product_id))->find();
    	D('Unitary')->where(array('id'=>$unitary_id))->data(array('cat_fid'=>$find_product['category_fid']))->save();
    }

    // 支付后调用，增加关联的活动购买记录
    public function updateUserJoin ($unitary_orderid) {

    	$unitary_orderid = intval($unitary_orderid);
    	if (empty($unitary_orderid) || !$find_order = D('Unitary_order')->where(array('pigcms_id'=>$unitary_orderid, 'paid'=>1))->find()) {
    		return;
    	}
    	$cart_list = D('Unitary_cart')->where(array('order_id'=>$unitary_orderid))->select();

    	foreach ($cart_list as $val) {

    		$find_join = D('Unitary_join')->where(array('uid'=>$val['uid'],'unitary_id'=>$val['unitary_id']))->find();
    		if (empty($find_join)) {
    			$add = array(
					'uid' => $val['uid'],
					'unitary_id' => $val['unitary_id'],
					'store_id' => $val['store_id'],
					'addtime' => $val['addtime'],
				);
    			$result = D('Unitary_join')->data($add)->add();
    		}

    	}

    }

    // 获取全站最新的一元传奇用户
    public function getLuckDog ($limit = 30) {
    	$sql = 'select * from '.option('system.DB_PREFIX').'unitary_lucknum group by unitary_id having count(*) = 1 and state = 1 limit 0, '.$limit;

    	$lucknum_list = D('')->query($sql);

    	$user_list = array();
    	foreach ($lucknum_list as $val) {
    		$tmp_user = array();
    		$find_unitary = D('Unitary')->where(array('id'=>$val['unitary_id']))->find();

    		$find_user = D('User')->field('nickname,avatar')->where(array('uid'=>$val['uid']))->find();

    		if (empty($find_unitary) || empty($find_user)) {
    			continue;
    		}

    		$tmp_user['name'] = $find_unitary['name'];
    		$tmp_user['unitary_id'] = $val['unitary_id'];
    		$tmp_user['total_num'] = $find_unitary['total_num'];

    		$tmp_user['nickname'] = !empty($find_user['nickname']) ? $find_user['nickname'] : '匿名用户';
			$tmp_user['avatar'] = !empty($find_user['avatar']) ? $find_user['avatar'] : option('config.site_url').'/static/images/avatar.png';
    		$tmp_user['uid'] = $val['uid'];
    		$tmp_user['addtime'] = floor($val['addtime']/1000);

    		$user_list[] = $tmp_user;
    	}

    	return $user_list;

    }


} 