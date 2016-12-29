<?php
/**
 * 店铺线下门店
 */

class store_physical_model extends base_model{
	public function getOne($pigcms_id){
        $store_physical = $this->db->where(array('pigcms_id'=>$pigcms_id))->find();
		
		import('source.class.area');
		$area_class = new area();
		
		$store_physical['images_arr'] = explode(',',$store_physical['images']);
		foreach($store_physical['images_arr'] as &$image_value){
			$image_value = getAttachmentUrl($image_value);
		}

		$store_physical['province_txt'] = $area_class->get_name($store_physical['province']);
		$store_physical['city_txt'] = $area_class->get_name($store_physical['city']);
		$store_physical['county_txt'] = $area_class->get_name($store_physical['county']);

		return $store_physical;
    }
    public function getList($store_id){
        $store_physical = $this->db->where(array('store_id'=>$store_id))->select();
		
		import('source.class.area');
		$area_class = new area();
		
		foreach($store_physical as &$physical_value){
			$physical_value['images_arr'] = explode(',',$physical_value['images']);
			foreach($physical_value['images_arr'] as &$image_value){
				$image_value = getAttachmentUrl($image_value);
			}

			$physical_value['province_txt'] = $area_class->get_name($physical_value['province']);
			$physical_value['city_txt'] = $area_class->get_name($physical_value['city']);
			$physical_value['county_txt'] = $area_class->get_name($physical_value['county']);
		}
		return $store_physical;
	}
	
	// 根据id列表返回门店信息
	public function getListByIDList($physical_id_list) {
		if (empty($physical_id_list) || !is_array($physical_id_list)) {
			return array();
		}
		
		//$store_physical_list = $this->db->where(array('pigcms_id' => array('in', $physical_id_list)))->select();
		
		$store_physical_list = D('')->field("`s`.`buyer_selffetch_name`, `sp`.*")->table(array('Store' => 's', 'Store_physical' => 'sp'))->where("`s`.`store_id` = `sp`.`store_id` AND `sp`.`pigcms_id` in (" . join(',', $physical_id_list) . ")")->select();
		
		import('source.class.area');
		$area_class = new area();
		$return_data = array();
		foreach ($store_physical_list as $value) {
			$value['images_arr'] = explode(',',$value['images']);
			foreach ($value['images_arr'] as &$image_value) {
				$image_value = getAttachmentUrl($image_value);
			}
			
			$value['province_txt'] = $area_class->get_name($value['province']);
			$value['city_txt'] = $area_class->get_name($value['city']);
			$value['county_txt'] = $area_class->get_name($value['county']);
			
			$return_data[$value['pigcms_id']] = $value;
		}
		
		return $return_data;
	}
	//根据坐标获取坐标最近的门店
	function nearshops($long, $lat, $store_id = 0, $limit = "") {
		$limit = $limit ? $limit : '12';

		$where = "";
		if (!empty($store_id)) {
			$where = "AND `s`.`store_id`=".$store_id;
		}

		$near_store_list = D('')->table(array('Store_physical' => 'sp', 'Store' => 's'))->field("`s`.`qcode`,`s`.`store_id`, `s`.`name`, `s`.`logo`, `s`.`intro`, `sp`.`name` as physical_name, `sp`.`pigcms_id` as physical_id, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sp`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sp`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sp`.`long`*PI()/180)/2),2)))*1000) AS juli")->where("`sp`.`store_id`=`s`.`store_id` AND `s`.`status`='1'".$where)->order("`juli` ASC")->limit($limit)->select();

		foreach ($near_store_list as $key => $value) {
			$value['url'] = option('config.wap_site_url') . '/home.php?id=' . $value['store_id'] . '&platform=1';
			$value['pcurl'] = url_rewrite('store:index', array('id' => $value['store_id']));

			if (empty($value['logo'])) {
				$value['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
			} else {
				$value['logo'] = getAttachmentUrl($value['logo']);
			}
			//本地化二维码$near_store_list[$key]['qcode']  = $value['qcode'] ?  getAttachmentUrl($value['qcode']) : option('config.site_url')."/source/qrcode.php?type=home&id=".$value['store_id'];
			$near_store_list[$key]['qcode']  = $value['qcode'] ?  $value['qcode'] : option('config.site_url')."/source/qrcode.php?type=home&id=".$value['store_id'];	//微信端临时二维码
			$near_store_list[$key]['logo'] = $value['logo'];
			$near_store_list[$key]['url'] = $value['url'];
			$near_store_list[$key]['pcurl'] = $value['pcurl'];
		}
		return $near_store_list;
	}

    // 收银台api获取门店
    // {
    //     "totalcount": 100,
    //     "listdata": [
    //         {
    //             "store_id": 1,
    //             "storename": "门店名称",
    //             "branchname": "分店名(没有可不填)",
    //             "telephone": "电话",
    //             "longitude": "经度",
    //             "latitude": "纬度",
    //             "open_time": "8:00-21:00",
    //             "categories": "美食,浙江菜",
    //             "province": "安徽",
    //             "city": "合肥市",
    //             "district": "蜀山区",
    //             "avg_price": "50",
    //             "address": "祁门路新地中心C座",
    //             "photo_list": [
    //                 {
    //                     "photo_url": "http: ...."
    //                 },
    //                 {
    //                     "photo_url": "http: ...."
    //                 }
    //             ],
    //             "introduction": "商户简介描述",
    //             "recommend": "推荐品描述",
    //             "special": "特色服务描述",
    //             "status": "0,1 表示系统错误、2 表示审核中、3 审核通过、4 审核未通过",
    //             "thirdmid": "商家id(o2o为mid)"
    //         }
    //     ]
    // }
    public function cashGetList($store_id, $pg=1, $pgsize=50) {

        $start = ($pg - 1)*50;
        $store_physical = $this->db->where(array('store_id'=>$store_id))->limit($start.','.$pgsize)->select();
        $total = $this->db->where(array('store_id'=>$store_id))->count('pigcms_id');
        
        import('source.class.area');
        $area_class = new area();
        
        $cashStoreList = array();
        foreach ($store_physical as $key => $val) {

            $val['images_arr'] = explode(',', $val['images']);
            $photo_list = array();
            foreach($val['images_arr'] as $vImg){
                $photo_list[] = array('photo_url' => getAttachmentUrl($vImg));
            }

            $cashStoreList[] = array(
                'store_id' => $val['pigcms_id'],
                'storename' => $val['name'],
                'branchname' => '',                     //分店名(没有可不填)
                'telephone' => !empty($val['phone1']) ? $val['phone1'].'-'.$val['phone2'] : $val['phone2'],
                'longitude' => $val['long'],
                'latitude' => $val['lat'],
                'open_time' => $val['business_hours'],
                'categories' => '',                     //分类名,分类名
                'province' => $area_class->get_name($val['province']),
                'city' => $area_class->get_name($val['city']),
                'district' => $area_class->get_name($val['county']),
                'avg_price' => 0,                       //价格？
                'address' => $val['address'],
                'photo_list' => $photo_list,
                'introduction' => $val['description'],
                'recommend' => '',                      //推荐品描述
                'special' => '',                        //特色服务描述
                'status' => 3,                          //0,1 表示系统错误、2 表示审核中、3 审核通过、4 审核未通过
                'thirdmid' => $val['store_id'],
            );
        }

        return array('totalcount'=>$total, 'listdata'=>$cashStoreList);
    }

    // 收银台api获取门店管理员
    // {
    //     "totalcount": 100,
    //     "listdata": [
    //         {
    //             "account": "账号",
    //             "store_id": "1",
    //             "username": "员工名称",
    //             "password": "密码md5后的字符串",
    //             "salt": "md5加密盐（没有传空值）",
    //             "status": "账号状态1正常0不可用",
    //             "phone": "手机电话",
    //             "email": "邮箱（没有传空）"
    //         }
    //     ]
    // }
    public function cashGetUserList($store_id, $pg=1, $pgsize=50)
    {
        $start = ($pg - 1)*50;
        $where = array(
                    'drp_store_id' => $store_id,
                    'type' => 1,
                );
        $totalCount = D("User")->where($where)->count('uid');
        $listData = D("User")->where($where)->limit($start.','.$pgsize)->select();


        $pwd_set = '123456';
        $salt = '';
        $cashUserList = array();
        foreach ($listData as $val) {
            $cashUserList[] = array(
                'account' => $val['phone'],
                'store_id' => $val['item_store_id'],
                'username' => $val['nickname'],
                'password' => $val['password'],
                'password' => md5(md5($pwd_set.'_'.$salt).$salt),
                'salt' => $salt,
                'status' => $val['status'],
                'phone' => $val['phone'],
                'email' => '',
            );
        }

        return array('totalcount'=>$totalCount, 'listdata'=>$cashUserList);
    }

    // {
    //     "error": 0,
    //     "msg": "ok",
    //     "data": {
    //         "orderidd": "订单号",
    //         "store_id": "1",
    //         "ispay": "0未支付1已支付",
    //         "goodsid": "订单表自增id",
    //         "goodsname": "商品名",
    //         "euid": "员工id",
    //         "goods_type": "商品类型",
    //         'mprice': 56.25
    //     }
    // }
    // 收银台获取支付订单信息
    public function cashGetOrder ($cashUid, $order_no) {

        $order = M('Order')->find(option('config.orderid_prefix').$order_no);
        if (empty($order)) {
            return array('error' => 1, 'msg' => "error", 'data' => array() ); 
        }

        $goodsName = array();
        $orderProduct = M('Order_product')->orderProduct($order['order_id']);
        foreach ($orderProduct as $val) {
            $goodsName[] = $val['name'];
        }
        $goodsName = implode(';', array_unique($goodsName));

        $is_pay = ($order['status'] > 1) ? 1 : 0;
        $data = array(
                'orderidd' => $order['order_no'],
                'store_id' => $order['store_id'],       //线下门店id
                'ispay' => $is_pay,
                'goodsid' => $order['order_id'],        //订单表id
                'goodsname' => $goodsName,
                'euid' => $cashUid,
                'goods_type' => 0,
                'mprice'=>$order['sub_total'],          //线下[生成订单]->无邮费
            );

        return array('error' => 0, 'msg' => "ok", 'data' => $data );
    }

    // 收银台 订单支付完成
    // $postData = 
    // array('orderidd'=>$o2oorder,             //订单号
    //     'store_id'=>$data['storeid'],        //门店Id
    //     'euid'=>$data['eid'],                //员工id
    //     'realprice'=>$data['goods_price'],   //实际支付金额
    //     'ispay'=>1,                          //支付状态 1已支付
    //     'pay_way'=>'weixin',                 //支付方式
    //     'wxtransaction_id'=>$transaction_id, //微信订单号
    //     'openid'=>$tmpopenid,                //支付用户openid
    //     'mprice'=>$data['mprice'],           //原来金额
    // );
    // orderidd订单号，store_id 门店Id ，euid员工id，realprice实际支付金额 ，mprice原来金额
    // ispay 支付状态 1已支付，pay_way支付方式：weixin（微信支付），wxtransaction_id 微信订单号
    // openid 支付用户openid
    // {"error":0,"msg":"ok"}
    public function cashOrderPaySuccess ($postData) {
        // 修改状态
        // $order = M('Order')->find(option('config.orderid_prefix').$postData['orderiddf']);

        // Order:
        //     |- 订单状态修改
        //         third_id
        //         payment_method
        //         pay_money
        //         paid_time
        //         status

        // Store:
        //     |- 店铺【收益/不可用余额】增加

        // Financial_record:
        //     |- 收入记录 增加

        // Product:
        //     |- sales 销售记录 + 
        //     |- quantity 库存  -

        // Product_sku:
        //     |- sales 销售记录 + 
        //     |- quantity 库存  -

        // function sync_sku() 
        //     |- 同步库存

        // |- 已自提：
        //     http://www.weidian.com/user.php?c=order&a=selffetch_status&order_id=671
        //     |- sent_time
        //     |- delivery_time
        //     |- status
        //     |- shipping_method = selffetch

    }

    /**
     * [assignOrderToPhysical 自动分配订单到门店
     * 订单有任何一个产品所有门店无法满足配送条件，则该单不分配并发送警告]
     * @param    [int/array] $order_ids [可以为单个order_id或者包含多个order_id的数组]
     * @return   [bool] true
     * @Auther   pigcms_89
     * @DateTime 2015-12-16T13:48:10+0800
     */
    public function assignOrderToPhysical($order_ids) {

        if (empty($order_ids)) {
            return false;
        }

        if (!is_array($order_ids)) {
            $order_ids = array($order_ids);
        }
        $order_product = M('Order_product');
        $store_physical = M('Store_physical');
        $store_physical_quantity = M('Store_physical_quantity');

        foreach ($order_ids as $order_id) {

            $order_id = intval($order_id);

            $order_info = D('Order')->where(array('order_id'=>$order_id))->find();
            if (empty($order_info) || $order_info['status'] != 2 || $order_info['is_assigned'] > 1) {
                // return false;
                continue;
            }

            // 判断是否为 自提订单/货到付款订单
            if ($order_info['shipping_method'] == 'selffetch' || $order_info['payment_method'] == 'codpay') {

                continue;
            }

            $store_id = $order_info['store_id'];
            //$store = M('Store')->getStore($store_id);
			$store = M('Store')->getStoreBySub($store_id);

			
			// 是否使用门店物流 || 开启自动分配
			if ($store['open_local_logistics'] == 0 || $store['open_autoassign'] == 0 ) {
                // return false;
                continue;
            }

            // 是否有门店
            $physicals = M("Store_physical")->getList($store_id);
            if (empty($physicals)) {
                // return false;
                continue;
            }

            // 过滤已经分配的订单商品
            $tmp_products = $order_product->getUnPackageSkuProducts($order_id);
            if (empty($tmp_products)) {
                // return false;
                continue;
            }

            // //获取收货地址 坐标 baiduapi搜索 
            $address = unserialize($order_info['address']);
            $address = str_replace(' ', '', $address);
            import('Http');
            $http_class = new Http();
            $url = "http://api.map.baidu.com/place/v2/search?q=".$address['address']."&region=".$address['city']."&output=json&ak=4c1bb2055e24296bbaef36574877b4e2";
            $map_json = $http_class->curlGet($url);
            $address_map = json_decode($map_json, true);
            $near_physical = array();
            if ($map_json && !empty($address_map['results'])) {
                reset($address_map['results']) & $first = current($address_map['results']);
                $store_list = $store_physical->nearshops($first['location']['lng'],$first['location']['lat'],$store_id);
                foreach ($store_list as $val) {
                    $near_physical[] = $val['physical_id'];
                }
            }

            $msgInfo = array();
            $products = array();
			// $log = array();
			foreach ($tmp_products as $tmp_product) {
				$physical_where = array('product_id'=>$tmp_product['product_id'], 'sku_id'=>$tmp_product['sku_id']);

				//获取该商品库库存足够的 && 有一样缺货，则不分配订单 检测该订单所有缺货项
				$physical_ids = $store_physical_quantity->getPhysicalIds($physical_where, $tmp_product['pro_num']);
				if (empty($physical_ids)) {
					// 本订单缺货报警
					$sku_info = M("Product_sku")->decodeSkuInfo($tmp_product['sku_id']);

					// if (!empty($sku_info['_property'])) {   //有sku
					//     $sku_str = '';
					//     foreach ($sku_info['_property'] as $v) {
					//         $sku_str .= $v['name'].$v['value'];
					//     }

					//     $log[] = $order_info['order_no'].":".$tmp_product['product_id'].":".$tmp_product['name'].":".$sku_str.":".$tmp_product['pro_num'];
					// } else {
					//     $log[] = $order_info['order_no'].":".$tmp_product['product_id'].":".$tmp_product['name'].":".$tmp_product['pro_num'];
					// }

					if (empty($store['sub_openid'])) {
						continue 2;
					}
                   
                    

					//当前订单 需要通知 的 库存不足产品集合
					$products[] = $tmp_product;
					//短信/通知 提醒 => 供货商审核通过通知
					import('source.class.ShopNotice');
					ShopNotice::Updatekucun($order_info,$products,$store);
					
                    continue 2;
                }

                //获取距离最近的门店id
                $nears = (!empty($near_physical) && !empty($physical_ids)) ? array_intersect($near_physical, $physical_ids) : $physical_ids;
                $nears = array_values($nears);

                $products[] = array(
                    // 'name' => $tmp_product['name'],
                    'product_id' => $tmp_product['product_id'],
                    'sku_id' => $tmp_product['sku_id'],
                    'pro_num' => $tmp_product['pro_num'],
                    'physical_id' => $nears[0],
                    'order_product_id' => $tmp_product['order_product_id'],
                );
            }

            // if (!empty($log)) {
            //     file_put_contents('assign_log.txt', "\r\n", FILE_APPEND);
            //     foreach ($log as $val) {
            //         file_put_contents('assign_log.txt', "\r\n".$val, FILE_APPEND);
            //     }
            //     return false;
            // }
            // if (!empty($msgInfo)) {
            //     file_put_contents('assign_log.txt', "\r\n", FILE_APPEND);
            //     foreach ($msgInfo as $val) {
            //         file_put_contents('assign_log.txt', "\r\n".serialize($val), FILE_APPEND);
            //     }
            //     // return false;
            //     // continue;
            // }

            //分包到门店 + 消减库存
            foreach ($products as $key => $val) {

                $has_save = D('Order_product')->where(array('pigcms_id'=>$val['order_product_id']))->find();
                if (empty($has_save['sp_id'])) {
                    //////D('Order_product')->where(array('pigcms_id'=>$val['order_product_id']))->data(array('sp_id'=>$val['physical_id']))->save();
                    //消减库存
                    //////D('Store_physical_quantity')->where(array('product_id'=>$val['product_id'], 'sku_id'=>$val['sku_id'], 'physical_id'=>$val['physical_id']))->setDec('quantity', $val['pro_num']);

                    // 检测该商品消减库存后，是否触发库存不足报警
                    // $this->checkQuantity($store_id, $val['product_id'], $val['sku_id'], $val['physical_id']);
                }

            }

            // 修改订单分配状态
            $ops = M('Order_product')->getUnPackageSkuProducts($order_id);
            $op_all = M('Order_product')->orderProduct($order_id, false);
            if (count($ops) == 0) {     
                M('Order')->editStatus(array("order_id"=>$order_id), array("is_assigned"=>2));
            } else if (count($ops) > 0 && count($ops) < count($op_all)) {
                M('Order')->editStatus(array("order_id"=>$order_id), array("is_assigned"=>1));
            }
        }

        return true;

    }
} 