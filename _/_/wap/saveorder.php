<?php
/**
 *  处理订单
 */
require_once dirname(__FILE__) . '/global.php';

//		判断关注
$wap_user = !empty($_SESSION['wap_user']) ? $_SESSION['wap_user'] : array();


//关注折扣判断
$follow = M('Store')->is_subscribe_store($wap_user['uid'], $_POST['storeId']);

//默认add
$action = isset($_GET['action']) ? $_GET['action'] : 'add';

switch ($action) {
	case 'add':
		//活动类型
		if ( $_POST['type'] == 4 ) {
			$product_price = (float) $_POST['price'];

			//店铺
			$nowStore = D('Store')->where(array('store_id' => $_POST['store_id']))->find();
			$drp_level = $nowStore['drp_level'];
			if ($drp_level > 3) {
				$drp_level = 3;
			}

			// 去重
			$conditionOrder = array('activity_orderid'=>$_POST['order_id'], 'activity_id'=>$_POST['actId'], 'activity_type'=>$_POST['actType']);
			$nowOrder = D('Order')->where($conditionOrder)->find();
			if (!empty($nowOrder)) {

				//如果有价格变动，以最新的为准
				if($nowOrder['sub_total'] != ((float) $_POST['price'])){
					D('Order')->where($conditionOrder)->data(array('sub_total'=>(float)$_POST['price'],'total'=>(float)$_POST['price']))->save();
					D('Order_product')->where(array('order_id'=>$nowOrder['order_id'],'product_id'=>$_POST['proId']))->data(array('pro_price'=>(float)$_POST['price']))->save();
				}

				json_return(0, $config['orderid_prefix'] . $nowOrder['order_no']);
			}

			// 验证商品 暂时过滤bargain之外的活动订单支付
			if ($_POST['actType'] == 'bargain') {

				$nowProduct = D('Product')->where(array('product_id' => $_POST['proId']))->find();

				if (empty($nowProduct) || empty($nowProduct['status'])) {
					json_return(1000, '商品不存在');
				}

				if (empty($nowProduct['has_property'])) {
				//无商品属性
					$skuId = 0;
					$propertiesStr = '';
					$product_price = $nowProduct['price'];
				} else {
					//有商品属性
					$skuId = !empty($_POST['skuId']) ? intval($_POST['skuId']) : json_return(1001, '请选择商品属性');
					$nowSku = D('Product_sku')->field('`sku_id`,`product_id`,`properties`,`price`,`after_subscribe_price`, `weight`,`drp_level_1_price`,`drp_level_2_price`,`drp_level_3_price`')->where(array('sku_id' => $skuId))->find();

					if ($nowProduct['product_id'] != $nowSku['product_id']){
						json_return(1002, '商品属性选择错误');
					}

				}

			}
			//对接价格以实际传递价格为准
			$product_price = (float) $_POST['price'];
		} elseif( $_POST['type'] == 50 ){
            $price = (float) $_POST['price'];

            //店铺
            $nowStore = D('Store')->where(array('store_id' => $_POST['storeId']))->find();
            if (empty($nowStore)) {
                json_return(1000, '没有该店铺');
            }
            $skuId = !empty($_POST['skuId']) ? intval($_POST['skuId']) : '';

            // 验证商品
            $nowProduct = D('Product')->field('`product_id`, `uid`,`store_id`,`price`,`after_subscribe_discount`,`after_subscribe_price`,`has_property`,`status`,`supplier_id`,`buyer_quota`,`weight`,`unified_price_setting`,`drp_level_1_price`,`drp_level_2_price`,`drp_level_3_price`')->where(array('product_id' => $_POST['proId']))->find();
            if (empty($nowProduct) || empty($nowProduct['status'])) {
                json_return(1000, '商品不存在');
            }
            
			if ($nowProduct['uid'] == $wap_user['uid']) {
				json_return(1000, '不能购买自己的商品');
			}

            //获取砍价活动商品信息
            $where = array();
            $where['pigcms_id'] = $_POST['activityId'];
            $where['product_id'] = $_POST['proId'];
            $bargain = D('Bargain')->where($where)->find();
            $where = "(token='".$wap_user['openid']."' and friend='' and bargain_id='".$_POST['activityId']."') or (friend='".$wap_user['openid']."' and bargain_id='".$_POST['activityId']."')";
            $bargain['myqprice'] = D('Bargain_kanuser')->where($where)->sum('dao');

            $sub_total = $bargain['myqprice']<$bargain['original']-$bargain['minimum']?($bargain['original']-$bargain['myqprice'])/100:$bargain['minimum']/100;

            //查询重复订单
            $conditionOrder = "uid='".$wap_user['uid']."' and activity_id='".$bargain['pigcms_id']."' and sub_total='".$sub_total."' and status!=5";
            $nowOrder = D('Order')->where($conditionOrder)->find();
            if (!empty($nowOrder)) {
                json_return(2, $config['orderid_prefix'] . $nowOrder['order_no']);
            }

            if($price == $sub_total){
                $product_price = $price;
            }else{
                json_return(1000, '商品价格异常');
            }
            
            if ($skuId) {
            	// 有商品属性
            	//判断库存是否存在
            	$nowSku = D('Product_sku')->field('`sku_id`,`product_id`,`properties`,`price`,`return_point`,`after_subscribe_price`, `weight`,`drp_level_1_price`,`drp_level_2_price`,`drp_level_3_price`')->where(array('sku_id' => $skuId))->find();
            	$nowProduct['return_point'] = $nowSku['return_point'];
            	
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
            	if ($nowProduct['product_id'] != $nowSku['product_id']) {
            		json_return(1002, '商品属性选择错误');
            	}
            }
            

        }elseif($_POST['type'] == 55){		// 降价拍活动
        	$pigcms_id = (int)$_POST['pigcms_id'];
        	$product_id = (int)$_POST['proId'];
        	$goods_num = (int)$_POST['quantity'];
        	$nowprice = trim($_POST['nowprice']);
        	$cutprice_item = D('Cutprice')->field('pigcms_id,product_id,sku_id,inventory,store_id,onebuynum')->where(array('pigcms_id'=>$pigcms_id))->find();
			
        	if(!$cutprice_item){
        		json_return(1001,'该活动不存在');
        	}
        	if($cutprice_item['product_id']!=$product_id){
        		json_return(1001,'商品信息错误');
        	}
        	if($cutprice_item['inventory']<=0){
        		json_return(1002,'很遗憾，您来迟一步');
        	}
        	if($goods_num>$cutprice_item['inventory']){
        		json_return(1003,'库存不足');
        	}
        	if($cutprice_item['sku_id']){
        		$sku_info = D('Product_sku')->field('sku_id,product_id,quantity')->where(array('sku_id'=>$cutprice_item['sku_id'],'product_id'=>$product_id))->find();
        		if($goods_num>$sku_info['quantity']){
        			json_return(1003,'库存不足');
        		}
        		$nowSku = D('Product_sku')->field('`sku_id`,`product_id`,`properties`,`price`,`return_point`,`after_subscribe_price`, `weight`,`drp_level_1_price`,`drp_level_2_price`,`drp_level_3_price`')->where(array('sku_id' => $sku_info['sku_id']))->find();
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
				// sku_data
				$propertiesStr = serialize($productProperties);
        	}
        	
        	// 验证商品
        	$nowProduct = D('Product')->field('`product_id`, `uid`,`store_id`,`price`,`after_subscribe_discount`,`after_subscribe_price`,`has_property`,`status`,`supplier_id`,`buyer_quota`,`weight`,`unified_price_setting`,`drp_level_1_price`,`drp_level_2_price`,`drp_level_3_price`')->where(array('product_id' => $_POST['proId']))->find();
        	if (empty($nowProduct) || empty($nowProduct['status'])) {
        		json_return(1000, '商品不存在');
        	}
        	
        	if ($nowProduct['uid'] == $wap_user['uid']) {
        		json_return(1000, '不能购买自己的商品');
        	}
        	
        	// 检测购买数量是否已超标
        	$myorder = false;
        	$cutprice_order_record = D('Cutprice_record')->where(array('cutprice_id'=>$cutprice_item['pigcms_id']))->select();
        	if($cutprice_order_record){
        		$product_order_ids = array();
        		foreach($cutprice_order_record as $item){
        			if(!in_array($item['order_id'], $product_order_ids)){
        				$product_order_ids[] = $item['order_id'];
        			}
        		}
        		$where_product['order_id'] = array('in',$product_order_ids);
        	}else{
        		$where_product['pigcms_id'] = -1;
        	}
        	
        	if($cutprice_item['sku_id']){
        		$where_product['sku_id'] = $cutprice_item['sku_id'];
        	}else{
        		$where_product['product_id'] = $cutprice_item['product_id'];
        	} 
        	$myorder_products = D('Order_product')->field('order_id,pro_num')->where($where_product)->select();
        	if($myorder_products){
        		$order_product_ids = array();
        		foreach($myorder_products as $order_product){
        			if(!in_array($order_product['order_id'],$order_product_ids)){
        				$order_product_ids[] = $order_product['order_id'];
        			}
        		}
        	}

        	$myorder_products && $myorder = D('Order')->field('pro_num')->where(array('type'=>55,'uid'=>$_SESSION['wap_user']['uid'],'order_id'=>array('in',$order_product_ids),'status'=>array('in',array(0,1,2,3,4))))->select();
        	$pro_count = 0;
        	if($myorder){
        		foreach($myorder as $_order){
        			$pro_count += $_order['pro_num'];
        		}
        	}
        	if($cutprice_item['onebuynum']>0 && ($pro_count+$goods_num)>$cutprice_item['onebuynum']){
        		json_return(1001,'您最多只能购买'.$cutprice_item['onebuynum'].'个');
        	}
        	
        	// 保存订单，减库存
        	$data = 'inventory=inventory-'.$goods_num;
        	D('Cutprice')->data($data)->where(array('pigcms_id'=>$pigcms_id))->save();
			
        } else {
//			店铺
			$nowStore = D('Store')->where(array('store_id' => $_POST['storeId']))->find();
			$drp_level = $nowStore['drp_level'];
			if ($drp_level > 3) {
				$drp_level = 3;
			}

			//验证商品
			$nowProduct = D('Product')->field('`product_id`,`uid`, `store_id`,`price`,`after_subscribe_discount`,`after_subscribe_price`,`has_property`,`status`,`supplier_id`,`buyer_quota`,`weight`,`is_fx`,`unified_price_setting`,`drp_level_1_price`,`drp_level_2_price`,`drp_level_3_price`, `send_other`, `wholesale_product_id`, `open_return_point`, `return_point`')->where(array('product_id' => $_POST['proId']))->find();
			if (empty($nowProduct) || empty($nowProduct['status'])) {
				json_return(1000, '商品不存在');
			}
			
			if ($nowProduct['uid'] == $wap_user['uid']) {
				json_return(1000, '不能购买自己的商品');
			}
			
			// 送他人，代付物流相关判断
			if ($nowProduct['wholesale_product_id']) {
				// 批发商品id
				$product_original = D('Product')->where(array('product_id' => $nowProduct['wholesale_product_id']))->find();
				if (empty($product_original) || $product_original['status'] != '1') {
					json_return(1000, '您访问的商品不存在或未上架或已删除');
				}
				$store_original = D('Store')->where(array('store_id' => $product_original['store_id']))->find();
				
				if (empty($store_original)) {
					json_return(1000, '您访问的店铺不存在');
				}
				
				if ($_POST['send_other'] == '1' && $product_original['send_other'] != '1' && $store_original['open_logistics'] != '1' && $store_original['open_friend'] != '1') {
					json_return(1000, '商品不能送他人');
				}
			} else {
				if ($nowProduct['store_id'] != $_POST['storeId']) {
					$store_original = D('Store')->where(array('store_id' => $nowProduct['store_id']))->find();
					$nowStore['open_logistics'] = $store_original['open_logistics'];
					$nowStore['open_friend'] = $store_original['open_friend'];
				}
				
				if ($_POST['send_other'] == '1' && $nowProduct['send_other'] != '1' && $nowStore['open_logistics'] != '1' && $nowStore['open_friend'] != '1') {
					json_return(1000, '商品不能送他人');
				}
				
			}
			
			//限购
			$buy_quantity = 0;
			$weight = $nowProduct['weight'];
			if (!empty($nowProduct['buyer_quota'])) {
				$user_type = 'uid';
				$uid = $_SESSION['wap_user']['uid'];
				if (empty($_SESSION['wap_user'])) { //游客购买
					$user_type = 'session';
					$session_id = session_id();
					$uid = session_id();
					
					// 查找购物车里相同产品的数量
					$user_cart_sum = D('User_cart')->where(array('session_id' => $uid, 'product_id' => $nowProduct['product_id']))->field('sum(pro_num) AS number')->find();
					$buy_quantity += $user_cart_sum['number'] + 0;
				} else {
					// 查找购物车里相同产品的数量
					$user_cart_sum = D('User_cart')->where(array('uid' => $uid, 'product_id' => $nowProduct['product_id']))->field('sum(pro_num) AS number')->find();
					$buy_quantity += $user_cart_sum['number'] + 0;
				}
				$tmp_quantity = intval(trim($_POST['quantity']));
				
				$buy_quantity += M('Order_product')->getBuyNumber($uid, $nowProduct['product_id'], $user_type);
				if (($buy_quantity + $tmp_quantity) > $nowProduct['buyer_quota']) { //限购
					json_return(1001, '商品限购，请修改购买数量');
				}
			}

			if (empty($nowProduct['has_property'])) {
//				无商品属性
				$skuId = 0;
				$propertiesStr = '';
				if (!empty($nowProduct['unified_price_setting']) && !empty($nowProduct['is_fx'])) { //分销商的价格
					$product_price = ($nowProduct['drp_level_' . $drp_level . '_price'] > 0) ? $nowProduct['drp_level_' . $drp_level . '_price'] : $nowProduct['price'];
				} else {
					$product_price = $nowProduct['price'];
				}
			} else {
//				有商品属性
				$skuId = !empty($_POST['skuId']) ? intval($_POST['skuId']) : json_return(1001, '请选择商品属性');
				//判断库存是否存在
				$nowSku = D('Product_sku')->field('`sku_id`,`product_id`,`properties`,`price`,`return_point`,`after_subscribe_price`, `weight`,`drp_level_1_price`,`drp_level_2_price`,`drp_level_3_price`')->where(array('sku_id' => $skuId))->find();
				$nowProduct['return_point'] = $nowSku['return_point'];
				
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
				if ($nowProduct['product_id'] != $nowSku['product_id'])
					json_return(1002, '商品属性选择错误');
				if (!empty($nowProduct['unified_price_setting']) && !empty($nowProduct['is_fx'])) {
					//分销商的价格
					$product_price = ($nowSku['drp_level_' . ($drp_level <= 3 ? $drp_level : 3) . '_price'] > 0) ? $nowSku['drp_level_' . ($drp_level <= 3 ? $drp_level : 3) . '_price'] : $nowSku['price'];
				} else {
					$product_price = $nowSku['price'];
				}
			}

			//关注后的价格
			if($nowProduct['after_subscribe_discount'] >= 1 && $nowProduct['after_subscribe_discount'] < 10 && !empty($follow)){
				$product_price *= ($nowProduct['after_subscribe_discount'] / 10);
			}

			if ($_POST['activityId']) {
				$nowActivity = M('Product_qrcode_activity')->getActivityById($_POST['activityId']);
				if ($nowActivity['product_id'] == $nowProduct['product_id']) {
					if ($nowActivity['type'] == 0) {
						$product_price = round($product_price * $nowActivity['discount'] / 10, 2);
					} else {
						$product_price = $product_price - $nowActivity['price'];
					}
				}
			}
		}

		$quantity = intval($_POST['quantity']) > 0 ? intval($_POST['quantity']) : json_return(1003, '请输入购买数量');

//----------------------------

		if (empty($_POST['isAddCart'])) {
			//立即购买
			$trade_no = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
			if ($_POST['type'] == 4) {	// 营销系统对接
				$data_order['store_id'] = (int)$_POST['store_id'];
				$data_order['activity_id'] = $_POST['actId'];
				$data_order['activity_type'] = $_POST['actType'];
				$data_order['activity_orderid'] = $_POST['order_id'];
				$data_order['order_no'] = $_POST['order_id'];
				$data_order['trade_no'] = $trade_no;
			} else {
				$data_order['store_id'] = intval(trim($_POST['storeId']));
				$data_order['order_no'] = $data_order['trade_no'] = $trade_no;
			}
			$order_no 	= $data_order['order_no'];
			$data_order['order_no'] = $data_order['trade_no'] = $order_no;
			if (!empty($wap_user['uid'])) {
				$data_order['uid'] = $wap_user['uid'];
			} else {
				$data_order['session_id'] = session_id();
			}
			
			$data_order['pro_num'] = $quantity;
			$data_order['pro_count'] = '1';
			$data_order['type'] = $_POST['type'] ? (int) $_POST['type'] : 0;
			$data_order['bak'] = $_POST['bak'] ? serialize($_POST['bak']) : '';
			$data_order['activity_data'] = $_POST['activity_data'] ? serialize($_POST['activity_data']) : '';
			$data_order['add_time'] = $_SERVER['REQUEST_TIME'];
			if ($_POST['send_other'] == '1') {
				$data_order['shipping_method'] = 'send_other';
			}
			//订单所属团队
			if (!empty($nowStore['drp_team_id']) && !empty($nowStore['drp_supplier_id'])) {
				if (M('Drp_team')->checkDrpTeam($nowStore['store_id'], true)) {
					$data_order['drp_team_id'] = $nowStore['drp_team_id'];
				}
			}
			//分销商的等级
			if (!empty($nowStore['drp_supplier_id'])) {
				import('source.class.Points');
				$data_order['drp_degree_id'] = Points::drpDegree($nowStore['store_id'], true);
			}
			//积分商城订单
			if($nowStore['is_point_mall'] == '1') {
				$data_order['sub_total'] = 0;
				$data_order['order_pay_point'] = intval(($product_price * 100) * $quantity / 100);
				$data_order['is_point_order'] = 1;
			} else {
				$data_order['sub_total'] = ($product_price * 100) * $quantity / 100;
				$data_order['order_pay_point'] = 0;
				$data_order['is_point_order'] = 0;
				if($_POST['type']==55){
					$data_order['sub_total'] = $_POST['nowprice'] * $_POST['quantity'];
				}
			}

			$order_id = D('Order')->data($data_order)->add();
			$nowOrder = array_merge($data_order,array('order_id'=>$order_id));
			if (empty($order_id)) {
				json_return(1004, '订单产生失败，请重试');
			}

			$data_order_product['order_id'] = $order_id;
			$data_order_product['product_id'] = $nowProduct['product_id'];
			$data_order_product['sku_id']	 = (int)$_POST['skuId'];
			$data_order_product['sku_data']   = $propertiesStr;
			$data_order_product['pro_num']	= $quantity;
			$data_order_product['pro_price']  = $product_price;
			$data_order_product['comment']	= !empty($_POST['custom']) ? serialize($_POST['custom']) : '';
			$data_order_product['pro_weight'] = $weight;
			
			if($_POST['type'] == 55){
				$data_order_product['pro_price'] = $_POST['nowprice'];
				// 添加降价拍订单记录
				D('Cutprice_record')->data(array('cutprice_id'=>$_POST['pigcms_id'],'order_id'=>$order_id))->add();
			}
			//平台开启保证金
			if (option('credit.platform_credit_open')) {
				if (!empty($nowProduct['open_return_point'])) {
					$data_order_product['return_point'] = !empty($nowProduct['return_point']) ? $nowProduct['return_point'] : 0;
				} else {
					import('source.class.Margin');
					Margin::init($nowStore['store_id']);
					//现金兑积分
					$data_order_product['return_point'] = Margin::convert($product_price, 'point');
				}
			}

			$product_info = D('Product')->field('is_fx,product_id,store_id,original_product_id,supplier_id,wholesale_product_id,name, check_give_points, check_degree_discount, give_points')->where(array('product_id' => $nowProduct['product_id']))->find();
			if ($product_info['store_id'] == $nowStore['store_id'] && empty($product_info['supplier_id'])) { //店铺自营商品
				$supplier_id		 = 0;
				$original_product_id = 0;
				$data_order_product['is_fx']			   = 0;
				$data_order_product['supplier_id']		   = $supplier_id;
				$data_order_product['original_product_id'] = $original_product_id;
			} else if ($product_info['store_id'] == $nowStore['store_id'] && !empty($product_info['wholesale_product_id'])) { //店铺批发商品
				$supplier_id		 = $product_info['supplier_id'];
				$original_product_id = $product_info['wholesale_product_id'];
				$data_order_product['is_fx']			   = 0;
				$data_order_product['supplier_id']		   = $supplier_id;
				$data_order_product['original_product_id'] = $original_product_id;
			} else if ($product_info['store_id'] != $nowStore['store_id'] && !empty($product_info['is_fx']) && empty($product_info['wholesale_product_id'])) { //分销供货商自营商品
				$supplier_id		 = $product_info['store_id'];
				$original_product_id = $product_info['product_id'];
				$data_order_product['is_fx']			   = 1;
				$data_order_product['supplier_id']		   = $nowStore['drp_supplier_id'];
				$data_order_product['original_product_id'] = $original_product_id;
			} else if ($product_info['store_id'] != $nowStore['store_id'] && !empty($product_info['is_fx']) && !empty($product_info['wholesale_product_id'])) { //分销供货商批发商品
				$supplier_id		 = $product_info['supplier_id'];
				$original_product_id = $product_info['wholesale_product_id'];
				$data_order_product['is_fx']			   = 1;
				$data_order_product['supplier_id']		   = $nowStore['drp_supplier_id'];
				$data_order_product['original_product_id'] = $original_product_id;
			} else if ($product_info['store_id'] != $nowStore['store_id'] && empty($product_info['is_fx']) && empty($product_info['wholesale_product_id'])) { //分销供货商未设置分销的自营商品
				$supplier_id		 = $product_info['store_id'];
				$original_product_id = $product_info['product_id'];
				$data_order_product['is_fx']			   = 1;
				$data_order_product['supplier_id']		   = $nowStore['drp_supplier_id'];
				$data_order_product['original_product_id'] = $original_product_id;
			} else if ($product_info['store_id'] != $nowStore['store_id'] && empty($product_info['is_fx']) && !empty($product_info['wholesale_product_id'])) { //分销供货商未设置分销的批发商品
				$supplier_id		 = $product_info['supplier_id'];
				$original_product_id = $product_info['wholesale_product_id'];
				$data_order_product['is_fx']			   = 1;
				$data_order_product['supplier_id']		   = $nowStore['drp_supplier_id'];
				$data_order_product['original_product_id'] = $original_product_id;
			}
			$data_order_product['user_order_id']	   = $order_id;
			if($_POST['type']==55){
				$data_order_product['is_fx'] = 0;
			}
			// 产品额外特权
			if (!empty($_SESSION['wap_user'])) {
				$product_discount = M('Product_discount')->getPointDiscount($product_info, $_SESSION['wap_user']['uid']);
				if (!empty($product_discount['point'])) {
					$data_order_product['point'] = $product_discount['point'];
				}
				if (!empty($product_discount['discount'])) {
					$data_order_product['discount'] = $product_discount['discount'];
				}
			}

			//关注后的价格
			if($nowProduct['after_subscribe_discount'] >= 1 && $nowProduct['after_subscribe_discount'] < 10 && !empty($follow)){
				$data_order_product['subscribed_discount'] = $nowProduct['after_subscribe_discount'];
			}

//			添加$data_order_product、
			if (D('Order_product')->data($data_order_product)->add()) {
				if (!empty($wap_user['uid'])) {
					M('Store_user_data')->upUserData($nowProduct['store_id'], $wap_user['uid'], 'unpay');
				}
				if (!empty($supplier_id)) { //修改订单，设置分销商
					$data = array();
					$data['suppliers'] = $supplier_id;
					if (!empty($supplier_id) && ($supplier_id != $nowStore['store_id'])) {
						$data['is_fx'] = 1;
						$data['type']  = 3;
						if($_POST['type'] == 55){
							$data['type'] = 55;// 降价拍不打折
						}
					}
					D('Order')->where(array('order_id' => $order_id))->data($data)->save();
					$nowOrder = array_merge($nowOrder,$data);
				}

				// 产生提醒
				import('source.class.Notify');
				Notify::createNoitfy($nowStore['store_id'], option('config.orderid_prefix') . $order_no);

				//////////////////////////////////////////////////////////////////////////////////////////////////
				$uid = $_SESSION['wap_user']['uid'];
				$first_product_name = $product_info ? msubstr($product_info[name],0,11) : "";
				
				//产生提醒-已生成订单
				import('source.class.Notice');
				Notice::sendOut($uid, $nowOrder,$first_product_name);

				//////////////////////////////////////////////////////////////////////////////////////////////////	
				json_return(0, $config['orderid_prefix'] . $order_no);
			} else {
				D('Order')->where(array('order_id' => $order_id))->delete();
				json_return(1005, '订单产生失败，请重试');
			}
		} else {
//			购物车购买
			if (!empty($wap_user['uid'])) {
				$data_user_cart['uid'] = $wap_user['uid'];

				// 查找购物车里相同产品的数量
				$user_cart = D('User_cart')->field('pigcms_id')->where(array('uid' => $data_user_cart['uid'], 'product_id' => $nowProduct['product_id'], 'sku_id' => $skuId, 'pro_price' => $product_price))->find();
				if (!empty($user_cart['pigcms_id'])) {
					if (D('User_cart')->where(array('pigcms_id' => $user_cart['pigcms_id']))->setInc('pro_num', $quantity)) {
						break;
					}
				}
			} else {
				$data_user_cart['session_id'] = session_id();

				// 查找购物车里相同产品的数量
				$user_cart = D('User_cart')->field('pigcms_id')->where(array('session_id' => $data_user_cart['session_id'], 'product_id' => $nowProduct['product_id'], 'sku_id' => $skuId, 'pro_price' => $product_price))->find();
				if (!empty($user_cart['pigcms_id'])) {
					if (D('User_cart')->where(array('pigcms_id' => $user_cart['pigcms_id']))->setInc('pro_num', $quantity)) {
						break;
					}
				}
			}
			$data_user_cart['product_id'] = $nowProduct['product_id'];
			$data_user_cart['store_id']   = intval(trim($_POST['storeId']));
			$data_user_cart['sku_id']	  = $skuId;
			$data_user_cart['sku_data']   = $propertiesStr;
			$data_user_cart['pro_num']	  = $quantity;
//			$data_user_cart['pro_price']  = 1;
//			判断是否关注
//			if($nowProduct['after_subscribe_discount'] >= 1){
//				$data_user_cart['pro_price'] = $nowProduct['after_subscribe_price'];
//			}else {
				$data_user_cart['pro_price'] = $product_price;
//			}
			$data_user_cart['add_time']   = $_SERVER['REQUEST_TIME'];
			$data_user_cart['comment']	  = !empty($_POST['custom']) ? serialize($_POST['custom']) : '';

			$product_info = D('Product')->field('is_fx,product_id,store_id,original_product_id,supplier_id,wholesale_product_id,name')->where(array('product_id' => $nowProduct['product_id']))->find();
			if ($product_info['store_id'] == $nowStore['store_id'] && empty($product_info['supplier_id'])) { //店铺自营商品
				$supplier_id			 = 0;
				$data_user_cart['is_fx'] = 0;
			} else if ($product_info['store_id'] == $nowStore['store_id'] && !empty($product_info['wholesale_product_id'])) { //店铺批发商品
				$supplier_id			 = $product_info['supplier_id'];
				$data_user_cart['is_fx'] = 0;
			} else if ($product_info['store_id'] != $nowStore['store_id'] && !empty($product_info['is_fx']) && empty($product_info['wholesale_product_id'])) { //分销供货商自营商品
				$supplier_id			 = $product_info['store_id'];
				$data_user_cart['is_fx'] = 1;
			} else if ($product_info['store_id'] != $nowStore['store_id'] && !empty($product_info['is_fx']) && !empty($product_info['wholesale_product_id'])) { //分销供货商批发商品
				$supplier_id			 = $product_info['supplier_id'];
				$data_user_cart['is_fx'] = 1;
			} else if ($product_info['store_id'] != $nowStore['store_id'] && empty($product_info['is_fx']) && empty($product_info['wholesale_product_id'])) { //分销供货商未设置分销的自营商品
				$supplier_id			 = $product_info['store_id'];
				$data_user_cart['is_fx'] = 1;
			} else if ($product_info['store_id'] != $nowStore['store_id'] && empty($product_info['is_fx']) && !empty($product_info['wholesale_product_id'])) { //分销供货商未设置分销的批发商品
				$supplier_id			 = $product_info['supplier_id'];
				$data_user_cart['is_fx'] = 1;
			}

			if (D('User_cart')->data($data_user_cart)->add()) {
				json_return(0, '添加成功');
			} else {
				json_return(1005, '订单产生失败，请重试');
			}
		}
		break;
	case 'pay':
		import('source.class.OrderPay');
		$order_pay = new OrderPay();
		$order_pay->pay();
		break;
	case 'cart_count':
		if (empty($_COOKIE['wap_store_id']))
			json_return(1014, '访问异常');
		if ($wap_user['uid']) {
			$condition_user_cart['uid'] = $wap_user['uid'];
		} else {
			$condition_user_cart['session_id'] = session_id();
		}
		$condition_user_cart['store_id'] = $_COOKIE['wap_store_id'];
		$return['count'] = D('User_cart')->where($condition_user_cart)->count('pigcms_id');
		$return['store_id'] = $_COOKIE['wap_store_id'];
//		返回count、store_id
		json_return(0, $return);
	case 'test_pay':
		import('source.class.OrderPay');
		$order_pay = new OrderPay();
		$order_pay->test();
		break;
	case 'go_pay':
		import('source.class.OrderPay');
		$order_pay = new OrderPay();
		$order_pay->go_pay();
		break;
	case 'pay_platform':
		import('source.class.OrderPay');
		$order_pay = new OrderPay();
		$order_pay->pay_platform();
		break;
}
?>