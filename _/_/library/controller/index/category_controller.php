<?php

/**
 * Created by PhpStorm.
 * User: pigcms-s
 * Date: 2015/5/15
 * Time: 17:17
 */
class category_controller extends base_controller {

	public function __construct() {

		parent::__construct();
		$cate_id = $_GET['id'];
		if (!$cate_id) {
			pigcms_tips('非法访问！', 'none');
		}

		$this->cate_id = $cate_id;


		$this->assign('cid', $cate_id);
	}

	public function index() {
		// 获取参数
		$prop = $_GET['prop'];
		$start_price = $_GET['start_price'] + 0;
		$end_price = $_GET['end_price'] + 0;
		$page = max(1, $_GET['page']);
		$order = $_GET['order'];
		$sort = $_GET['sort'];
		$limit = 50;
		// 筛选属性ID集合
		$prop_arr = array();
		if (!empty($prop)) {
			$prop_arr = explode('_', $prop);
		}

		// url条件，价格在后面
		$param['id'] = $this->cate_id;
		$param['page'] = $page;
		$param['order'] = $order;
		$param['sort'] = $sort;

		// 修正价格和排序
		//$order_arr = array('sort', 'sales', 'price', 'collect', 'distance');
		$order_arr = array('sort', 'sales', 'price', 'collect','distance');
		$sort_arr = array('desc', 'asc');

		if (!in_array($order, $order_arr)) {
			$order = 'sort';
		}

		if (!in_array($sort, $sort_arr)) {
			$sort = 'desc';
		}

		/* if ($order == 'sort' || $order == 'sales') {
		  $sort = 'desc';
		  } */

		if (!empty($start_price) && !empty($end_price) && $start_price > $end_price) {
			$tmp_price = $start_price;
			$start_price = $end_price;
			$end_price = $tmp_price;
		}

		$product_category_model = M('Product_category');
		if (!empty($this->cate_id)) {
			// 顶级分类和子分类
			$category_detail = $product_category_model->getCategory($this->cate_id);


			// 目前产品分类只支持两级
			$cid = $category_detail['cat_id'];

			// 当访问的不是首分类时，修正为父级分类ID
			if ($category_detail['cat_fid'] != 0) {
				$cid = $category_detail['cat_fid'];
			}

			// 父类分类
			$f_category = array();
			$s_category = array();
			// 搜索分类id
			$search_cat_id_arr = array();

			
			$s_category = D('Product_category')->where(array('cat_fid' => $cid, 'cat_status' => 1))->order('cat_sort ASC, cat_id ASC')->select();
			if ($cid == $category_detail['cat_id']) {
				$f_category = $category_detail;

				foreach ($s_category as $tmp) {
					$search_cat_id_arr[] = $tmp['cat_id'];
				}
				$search_cat_id_arr[] = $cid;
			} else {
				$f_category = $product_category_model->getCategory($cid);
			}
		} else {
			$s_category = D('Product_category')->where(array('cat_fid' => $cid, 'cat_status' => 1))->order('cat_sort ASC, cat_id ASC')->select();
		}

		$property_list = array();
		if (!empty($category_detail)) {
			$property_list = M('System_product_property')->getPropertyAndValue($category_detail['filter_attr']);
		}


		// 查询属性条件
		$is_prop = false;
		$product_id_str = '';
		if (!empty($prop_arr)) {
			$product_id_str = M('System_product_to_property_value')->getProductIDByVid($prop_arr);
			$is_prop = true;
		}


		// 查找满足条件产品的数量
		//$where_sql = '`status` = 1';
		$where_sql[] = "p.status = 1";
		
		if (!empty($start_price)) {
			$where_sql[] = "p.price >=". $start_price . "'";
			$param['start_price'] = $start_price;
		}
		if (!empty($end_price)) {
			$where_sql[] = "  p.`price` <= '" . $end_price . "'";
			$param['end_price'] = $end_price;
		}

		if (!empty($this->cate_id)) {
			if (empty($search_cat_id_arr)) {
				$where_sql[]= "  `p`.`category_id` = '" . $this->cate_id . "'";
			} else {
				if($_GET['id']!=99999){
					 $where_sql[] = "  `p`.`category_id` in (" . join(',', $search_cat_id_arr) . ")";
				}
			}
		}

		// 不出现分销
		$where_sql[] = " p.`supplier_id` = '0' and p.`public_display` = '1' and p.is_present=0";
		
		if($order != 'distance') {
			////
			if ($is_prop && $product_id_str) {
				$where_sql[] = " `p`.`product_id` in (" . $product_id_str . ")";
				if($where_sql) $where_sql = implode(" and ",$where_sql);
				$count = M('Product')->getSellingCount_new($where_sql);
				
			} else if ($is_prop) {
				$count = 0;
			} else {
				$count = M('Product')->getSellingCount_new($where_sql);

			}
		} else {	
			if ($is_prop && $product_id_str) {
				$where_sql[] = " `p`.`product_id` in (" . $product_id_str . ")";
				if($where_sql) $where_sql = implode(" and ",$where_sql);
				

				$count = M('Product')->getSellingBydistanceCount_new($where_sql);

			} else if ($is_prop) {
				$count = 0;
			} else {

				if($where_sql) $where_sql = implode(" and ",$where_sql);
				$count = M('Product')->getSellingBydistanceCount_new($where_sql);
				
			}	
		}

		
		$product_list = array();
		$store_list = array();
		$pages = '';
		$total_pages = ceil($count / $limit);

		if ($count > 0) {
			$page = min($page, $total_pages);
			$offset = ($page - 1) * $limit;
			if($order == 'distance') {
				$orders = "juli";
				
				$product_list = M('Product')->getSellingBydistance_new($where_sql, $orders, $sort, $offset, $limit);
			} else {
				$product_list = M('Product')->getSelling_new($where_sql, $order, $sort, $offset, $limit); 
			}


			$store_id_list = array();
			foreach ($product_list as &$product) {
				$store_id_list[$product['store_id']] = $product['store_id'];
				
				$wheres = array(
						'ss.supplier_id' => $product['store_id'],
						's.status' => array('>',0),
				);
				$count_user1 = M('Store_supplier')->seller_count($wheres);
				
				$sellerList =M('Store_supplier')->getNextSellers($product['store_id'], 'all');
				if (count($sellerList) > 0) {
					$sellerIdLists = array();
					foreach ($sellerList as $sellerId) {
						$sellerIdLists[] = $sellerId['seller_id'];
					}
					
					$sellerIdList = rtrim(implode(',', $sellerIdLists), ',');
				}
				if($sellerIdList) {
					$where1['ss.supplier_id'] = array ('in' => $sellerIdList);
					$count_user2 = M('Store_supplier')->seller_count($where1);
				} else {
					$count_user2 = "0";
				}
				$count_user = $count_user1 + $count_user2;
				$product['drp_seller_qty'] = $count_user;
			}

			$store_list = M('Store')->getStoreName($store_id_list);
			$store_contact_info = M('store_contact')->get_store_contact_info($store_id_list);
			// 分页
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		} else {
			$page = 0;
			$_GET['page'] = 0;
		}

		$search_sort = $sort == 'asc' ? 'desc' : 'asc';

		if (empty($this->cate_id)) {
			//unset($param['id']);
		}

		// 排序
		$search_param = $param;
		unset($search_param['page']);
		if (empty($search_param['order'])) {
			unset($search_param['order']);
		}

		if (empty($search_param['sort'])) {
			unset($search_param['sort']);
		}

		if (!empty($prop)) {
			$search_param['prop'] = 'prop_' . $prop;
		}

		// 热销url条件
		$hot_param = $param;
		$hot_param['order'] = 'sales';
		$hot_param['sort'] = $search_sort;
		$hot_param['sort'] = ($order == 'sales') ? ($search_sort == 'desc' ? 'desc': 'asc'): 'desc';
		
		if (!empty($prop)) {
			$hot_param['prop'] = 'prop_' . $prop;
		}

		unset($hot_param['page']);

		// 价格排序url条件
		$price_param = $param;
		$price_param['order'] = 'price';
		$price_param['sort'] = $search_sort;
		$price_param['sort'] = ($order == 'price')? ($search_sort == 'desc' ? 'desc': 'asc'): 'desc';
		
		if (!empty($prop)) {
			$price_param['prop'] = 'prop_' . $prop;
		}
		unset($price_param['page']);

		//人气排序url条件
		$collect_param = $param;
		$collect_param['order'] = 'collect';
		$collect_param['sort'] = $search_sort;
		$collect_param['sort'] = ($order == 'collect')? ($search_sort == 'desc' ? 'desc': 'asc'): 'desc';

		if (!empty($prop)) {
			$collect_param['prop'] = 'prop_' . $prop;
		}
		unset($collect_param['page']);

 		//距离排序url条件
		$distance_param = $param;
		$distance_param['order'] = 'distance';
		$distance_param['sort'] = $search_sort;
		$distance_param['sort'] = ($order == 'distance')? ($search_sort == 'desc' ? 'desc': 'asc'): 'desc';
		
		if (!empty($prop)) {
			$distance_param['prop'] = 'prop_' . $prop;
		}
		unset($distance_param['page']); 

		
		
		// 默认排序url条件
		$default_param = $param;
		if (!empty($prop)) {
			$default_param['prop'] = 'prop_' . $prop;
		}
		unset($default_param['page']);
		unset($default_param['order']);
		unset($default_param['sort']);

		//导航栏
		//$categoryList = parent::nav_list();
	   // $this->assign('categoryList', $categoryList);

		//获取当前位置
		$cookie_location = show_distance();
		
		
		// 积分赠送
		import('source.class.Margin');
		$open_margin_recharge = Margin::check();
		
		$credit_setting = D('Credit_setting')->find();
		$platform_credit_name = $credit_setting['platform_credit_name'] ;
		$platform_credit_name = $platform_credit_name ? $platform_credit_name : "平台币";
		$this->assign('open_margin_recharge',$open_margin_recharge);
		$this->assign('platform_credit_name',$platform_credit_name);
		
		
		
		$this->assign('prop_arr', $prop_arr);
		$this->assign('category_detail', $category_detail);	 //当前的产品类别id
		$this->assign('f_category', $f_category);
		$this->assign('s_category', $s_category);
		$this->assign('product_list', $product_list);
		$this->assign('store_list', $store_list);
		$this->assign('search_url', $search_url);
		$this->assign('search_sort', $search_sort);
		$this->assign('pages', $pages);
		$this->assign('search_param', $search_param);
		$this->assign('default_param', $default_param);
		$this->assign('hot_param', $hot_param);
		$this->assign('price_param', $price_param);
		$this->assign('collect_param', $collect_param);
		$this->assign('distance_param', $distance_param);
		$this->assign('page_arr', array('current_page' => $page, 'total_pages' => $total_pages));
		$this->assign('property_list', $property_list);
		$this->assign('store_contact_info', $store_contact_info);
		//获取全部的顶级分类
		$top_cate_list = D('Product_category')->where(array('cat_fid' => 0))->field('cat_id,cat_name')->order('cat_sort ASC, cat_id ASC')->select();
		$this->assign('top_cate_list', $top_cate_list);
                $this->assign('product_count', $count);
		$this->display();
	}

}