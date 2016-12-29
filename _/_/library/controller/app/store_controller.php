<?php
class store_controller extends base_controller{
	public function index() {
		$store_id = $_REQUEST['id'];
		
		if (empty($store_id)) {
			json_return(1000, '缺少参数');
		}
		
		if ($_REQUEST['app'] != 'app') {
			$url = option('config.wap_site_url') . '/home.php?id=' . $store_id;
			header('location: ' . $url);
			exit;
		}
		
		$store = M('Store')->getStore($store_id, true);
		if (empty($store)) {
			json_return(1000, '未找到相应的店铺');
		}
		
		// 查找供货商店铺ID
		$supplier_id = $store_id;
		if (!empty($store['top_supplier_id']) && empty($store['drp_diy_store'])) {
			$supplier_id = $store['top_supplier_id'];
		}
		
		// 查找供货商的店铺主页面
		$wei_page = D('Wei_page')->where(array('is_home' => 1, 'store_id' => $supplier_id))->find();
		if (empty($wei_page)) {
			json_return(1000, '您访问的店铺没有首页');
		}
		
		// 微杂志的自定义字段
		if ($wei_page['has_custom']) {
			$custom_field_list = M('Custom_field')->getFields($supplier_id, 'page', $wei_page['page_id'], $store_id, $store['drp_level'], $store['drp_diy_store']);
		}
		
		// 判断是否有广告
		$page_has_ad = false;
		$custom_field_ad_list = array();
		if ($store['open_ad'] && !empty($store['use_ad_pages'])) {
			$user_ad_pages_arr = explode(',', $store['use_ad_pages']);
			if (in_array('5', $user_ad_pages_arr)) {
				$custom_field_ad_list = M('Custom_field')->getFields($supplier_id, 'common_ad', $supplier_id, $store_id, $store['drp_level'], $store['drp_diy_store']);
				
				if (!empty($custom_field_ad_list)) {
					$page_has_ad = true;
				}
			}
		}
		
		$data = array();
		$data['custom_field_list'] = $custom_field_list;
		$data['page_has_ad'] = $page_has_ad;
		if ($page_has_ad) {
			$data['custom_field_ad_list'] = $custom_field_ad_list;
			$data['ad_position'] = $store['ad_position'];
		}
		
		json_return(0, $data);
	}
	
	// 附近店铺
	public function near() {
		$page = max($_REQUEST['page'], 1);
		$limit = $_REQUEST['limit'];
		$long = $_REQUEST['long'];
		$lat = $_REQUEST['lat'];
		$is_product = $_REQUEST['is_product'];
		
		if ($limit <= 0) {
			$limit = 5;
		}
		
		$offset = ($page - 1) * $limit;
		
		if (empty($long) || empty($lat)) {
			json_return(1000, '获取位置失败');
		}
		
		import('Http');
		$http_class = new Http();
		$callback = $http_class->curlGet('http://api.map.baidu.com/geoconv/v1/?coords=' . $long . ',' . $lat . '&from=1&to=5&ak=4c1bb2055e24296bbaef36574877b4e2');
		$callback_arr = json_decode($callback, true);
		if(empty($callback_arr['result']) || !empty($callback_arr['status'])){
			json_return(1000, '地理位置解析错误，请重试！');
		}else{
			$long = $callback_arr['result'][0]['x'];
			$lat = $callback_arr['result'][0]['y'];
		}
		
		$database_store_contact = D('Store_contact');
		$database_product = D('Product');
		$store_list = D('')->table(array('Store_contact'=>'sc', 'Store'=>'s'))->field("`s`.`store_id`,`s`.`name`, `s`.`logo`, `s`.`intro`, `s`.`collect`, `s`.`attention_num`, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli")->where("`sc`.`store_id`=`s`.`store_id` AND s.drp_supplier_id = '0' AND `s`.`status`='1' AND `s`.`public_display`='1'")->order("`juli` ASC")->limit($offset . ',' . $limit)->select();
		$store_model = M('Store');
		
		$condition_product = array();
		$condition_product['status'] = 1;
		$condition_product['quantity'] = array('>', 0);
		foreach ($store_list as &$store) {
			$store['url'] = url('store:index', array('id' => $store['store_id']));
			
			if(empty($store['logo'])) {
				$store['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
			} else {
				$store['logo'] = getAttachmentUrl($store['logo']);
			}
			$sale_category = $store_model->getSaleCategory($store['store_id'], $store['uid']);
			$store['category'] = $sale_category;
			
			if ($is_product) {
				$condition_product['store_id'] = $store['store_id'];
				$store['product_list'] = $database_product->field('`product_id`,`name`,`image`,`price`')->where($condition_product)->order('`sort` DESC, `product_id` DESC')->limit(3)->select();
				foreach($store['product_list'] as &$product_value){
					$product_value['price'] = floatval($product_value['price']);
					$product_value['image'] = getAttachmentUrl($product_value['image']);
					$product_value['url'] = option('config.wap_site_url') . '/good.php?id=' . $product_value['product_id'] . '&store_id=' . $store['store_id'] . '&platform=1';
				}
			}
		}
		
		json_return(0, $store_list);
	}
	
	// 推荐微店
	public function recommend() {
		$cat_id = intval($_REQUEST['cat_id']);
		
		if($cat_id){
			$where = array('cat_id' => $cat_id);
		}
		$sale_category_list = M('Sale_category')->getAllCategory($where);
		$store_model = M('Store');
		$son_cat_store_list = array();
		foreach ($sale_category_list as $key => $value) {
			if (empty($value['stores'])) {
				unset($sale_category_list[$key]);
			} else if (empty($value['cat_list'])) {
				$tmp_store_list = $store_model->getWeidianStoreListBySaleCategoryId($value['cat_id'], 6, true);
				if (empty($tmp_store_list)) {
					unset($sale_category_list[$key]);
				} else {
					$sale_category_list[$key]['store_list'] = $tmp_store_list;
					unset($sale_category_list[$key]['parent_id']);
					unset($sale_category_list[$key]['status']);
					unset($sale_category_list[$key]['order_by']);
					unset($sale_category_list[$key]['path']);
					unset($sale_category_list[$key]['level']);
					unset($sale_category_list[$key]['parent_status']);
					unset($sale_category_list[$key]['stores']);
					unset($sale_category_list[$key]['parent_status']);
				}
			} else {
				unset($sale_category_list[$key]['parent_id']);
				unset($sale_category_list[$key]['status']);
				unset($sale_category_list[$key]['order_by']);
				unset($sale_category_list[$key]['path']);
				unset($sale_category_list[$key]['level']);
				unset($sale_category_list[$key]['parent_status']);
				unset($sale_category_list[$key]['stores']);
				unset($sale_category_list[$key]['parent_status']);
				$is_have_son = false;
				foreach ($value['cat_list'] as $son_cat_key => $son_cat_value) {
					unset($sale_category_list[$key]['cat_list'][$son_cat_key]['parent_id']);
					unset($sale_category_list[$key]['cat_list'][$son_cat_key]['status']);
					unset($sale_category_list[$key]['cat_list'][$son_cat_key]['order_by']);
					unset($sale_category_list[$key]['cat_list'][$son_cat_key]['path']);
					unset($sale_category_list[$key]['cat_list'][$son_cat_key]['level']);
					unset($sale_category_list[$key]['cat_list'][$son_cat_key]['parent_status']);
					unset($sale_category_list[$key]['cat_list'][$son_cat_key]['stores']);
					unset($sale_category_list[$key]['cat_list'][$son_cat_key]['parent_status']);
					
					if (empty($son_cat_value['stores'])) {
						unset($sale_category_list[$key]['cat_list'][$son_cat_key]);
					} else {
						$tmp_store_list = $store_model->getWeidianStoreListBySaleCategoryId($son_cat_value['cat_id'],6);
						if (empty($tmp_store_list)) {
							unset($sale_category_list[$key]['cat_list'][$son_cat_key]);
						} else {
							$sale_category_list[$key]['cat_list'][$son_cat_key]['store_list'] = $tmp_store_list;
							$son_cat_store_list[$son_cat_value['cat_id']] = $tmp_store_list;
							$is_have_son = true;
						}
					}
				}
				
				if ($is_have_son) {
					$sale_category_list[$key]['cat_list'] = array_values($sale_category_list[$key]['cat_list']);
				} else {
					unset($sale_category_list[$key]);
				}
			}
		}
		
		echo json_encode(array_values($sale_category_list));
		exit;
	}
	
	// 门店
	public function physical() {
		$store_id = $_REQUEST['store_id'];
		
		if (empty($store_id)) {
			json_return(1000, '缺少参数');
		}
		
		$store = M('Store')->getStore($store_id);
		if (empty($store) || !empty($store['drp_supplier_id'])) {
			json_return(1000, '未找到相应的店铺');
		}
		
		//门店列表
		$store_physical_list = M('Store_physical')->getList($store['store_id']);
		foreach ($store_physical_list as &$store_physical) {
			$store_physical['desc'] = str_replace(array("\r\n", "\r", "\n", '"', "'"), '', $store_physical['description']);
			unset($store_physical['description']);
		}
		
		json_return(0, array('store_physical_list' => $store_physical_list));
	}
	
	// 搜索
	public function search() {
		$name = $_REQUEST['name'];
		$cfid = $_REQUEST['cfid'];
		$cid = $_REQUEST['cid'];
		$province_id = $_REQUEST['provice_id'];
		$city_id = $_REQUEST['city_id'];
		$area_id = $_REQUEST['area_id'];
		$tag_id = $_REQUEST['tag_id'];
		$sort = $_REQUEST['sort'];
		$page = max(1, $_REQUEST['page']);
		$limit = 10;
		
		// 修正sort,date默认时间，collect收藏数（人气），sales销售额
		if (!in_array($sort, array('date', 'collect', 'sales'))) {
			$sort = 'date';
		}
		
		$where = '1';
		if (!empty($name)) {
			$where .= " AND s.name like '%" . $name . "%'";
		}
		if (!empty($cfid)) {
			$where .= " AND s.sale_category_fid = '" . $cfid . "'"; 
		}
		if (!empty($cid)) {
			$where .= " AND s.sale_category_id = '" . $cid . "'";
		}
		if (!empty($province_id)) {
			$where .= " AND sc.province = '" . $province_id . "'";
		}
		if (!empty($city_id)) {
			$where .= " AND sc.city = '" . $city_id . "'";
		}
		if (!empty($area_id)) {
			$where .= " AND sc.county = '" . $area_id . "'";
		}
		if (!empty($tag_id)) {
			$where .= " AND s.tag_id = '" . $tag_id . "'";
		}
		$order_by = 's.date_added DESC';
		if ($sort == 'collect') {
			$order_by = 's.collect DESC';
		} else if ($sort == 'sales') {
			$order_by = 's.sales DESC';
		}
		
		$offset = ($page - 1) * $limit;
		$store_list_tmp = D('Store AS s')->join('Store_contact AS sc ON s.store_id = sc.store_id')->where($where)->order($order_by)->limit($offset . ', ' . $limit)->select();
		
		import('area');
		$areaClass = new area();
		
		$store_list = array();
		foreach ($store_list_tmp as $store) {
			$tmp = array();
			$tmp['store_id'] = $store['store_id'];
			$tmp['name'] = $store['name'];
			$tmp['logo'] = $store['logo'] ? getAttachmentUrl($store['logo']) :  getAttachmentUrl('images/default_shop_2.jpg', false);
			$tmp['long'] = $store['long'];
			$tmp['lat'] = $store['lat'];
			$tmp['tel'] = ($store['phone1'] ? $store['phone1'] . '-' : '') . $store['phone2'];
			
			$comment = M('Comment')->getCountList(array('delete_flg' => 0, 'relation_id' => $store['store_id'], 'type' => 'STORE'));
			if ($comment['total'] == 0) {
				$tmp['comment'] = '100%';
			} else {
				$tmp['comment'] = ceil($comment['t3'] / $comment['total'] * 100) . '%';
			}
			
			$tmp['address'] = $store['address'];
			if ($store['province'] && $store['city'] && $store['county']) {
				$tmp['address'] = $areaClass->get_name($store['province']) . $areaClass->get_name($store['city']) . $areaClass->get_name($store['county']) . $store['address'];
			}
			
			$store_list[] = $tmp;
		}
		
		$return = array();
		$return['store_list'] = $store_list;
		$return['next_page'] = true;
		if (count($store_list) < $limit) {
			$return['next_page'] = false;
		}
		
		if ($page == 1) {
			$product_category_list = M('Product_category')->getAllCategory('', true);
			$return['product_category_list'] = $product_category_list;
			
			$store_tag_list = D('Store_tag')->where(array('status' => 1))->order('order_by ASC')->select();
			$return['store_tag_list'] = $store_tag_list;
		}
		
		json_return(0, $return);
	}
}
?>