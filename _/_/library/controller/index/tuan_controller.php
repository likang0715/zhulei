<?php
/**
 * 团购
 */
class tuan_controller extends base_controller {
	public function __construct() {
		parent::__construct();
		
		$navList = F('pc_tuan_nav');
		if (empty($navList)) {
			$navList = M('Slider')->get_slider_by_key('pc_tuan_nav', 7);
			F('pc_tuan_nav', $navList);
		}
		
		$this->assign('navList', $navList);
		
		// 团购搜索关键词
		$search_hot = F('pc_tuan_search_hot');
		if (empty($search_hot)) {
			$search_hot = D('Search_hot')->where(array('cat_type' => 2))->order("sort asc ,id desc")->limit(7)->select();
			F('pc_tuan_search_hot', $search_hot);
		}
		$this->assign('search_hot', $search_hot);
	}
	
	/**
	 * 团购首页
	 */
	public function index() {
		// banner广告
		$adver_list = M('Adver')->get_adver_by_key('pc_tuan_adver', 8);
		
		// 今日主推
		$tuan_today_recomment = M('Tuan')->getListByKey('pc_today_order');
		if (!empty($tuan_today_recomment)) {
			$tuan_today_recomment = $tuan_today_recomment[0];
		}
		
		// 新品推荐
		$tuan_new_recomment_list = M('Tuan')->getListByKey('pc_save_order');
		
		// 火爆拼团
		$tuan_hot_list = M('Tuan')->getListByKey('pc_hot_tuan');
		
		// 今日新单
		$tuan_new_list = M('Tuan')->getListByKey('pc_new_order');
		
		// 今日团长
		$tuan_team_list_tmp = M('Tuan')->getListByKey('pc_tuan_leader');
		$tuan_team_list = array();
		if (!empty($tuan_team_list_tmp)) {
			$tuan_id_arr = array(0);
			foreach ($tuan_team_list_tmp as $tuan) {
				$tuan_id_arr[] = $tuan['tuan_id'];
			}
			
			$tuan_team_list = M('Tuan')->getListByTeam('', "t.id in (" . join(',', $tuan_id_arr) . ")", 'tt.team_id DESC', 0, 12);
		}
		//print_r($tuan_team_list);
		// 填充变量
		$this->assign('adver_list', $adver_list);
		$this->assign('tuan_today_recomment', $tuan_today_recomment);
		$this->assign('tuan_new_recomment_list', $tuan_new_recomment_list);
		$this->assign('tuan_hot_list', $tuan_hot_list);
		$this->assign('tuan_new_list', $tuan_new_list);
		$this->assign('tuan_team_list', $tuan_team_list);
		$this->display();
	}
	
	// 团购列表
	public function tuan_list() {
		$cate_id = $_GET['id'];
		$keyword = $_GET['keyword'];
		$product_category_nav_list = D('Product_category')->where(array('cat_fid' => $cate_id))->field('cat_id, cat_name')->order('cat_sort ASC, cat_id ASC')->select();
		
		// 顶级产品分类
		$top_cate_list = array();
		$product_category = array();
		if ($cate_id != 0) {
			$product_category = M('Product_category')->getCategory($cate_id);
			$top_cate_list = D('Product_category')->where(array('cat_fid' => 0))->field('cat_id, cat_name')->order('cat_sort ASC, cat_id ASC')->select();
		} else {
			$top_cate_list = $product_category_nav_list;
		}
		
		if ($product_category['cat_level'] == 2) {
			$s_category = D('Product_category')->where(array('cat_fid' => $product_category['cat_fid'], 'cat_status' => 1))->order('cat_sort ASC, cat_id ASC')->select();
			$this->assign("s_category", $s_category);
		}
		
		$category_first_href = '<a href="' . url('tuan:tuan_list') . '">全部</a>';
		$cate_id = $product_category['cat_fid'] ? $product_category['cat_fid'] : $cate_id;
		foreach ($top_cate_list as $tmp) {
			if ($cate_id == $tmp['cat_id']) {
				$category_first_href = '<a href="' . url('tuan:tuan_list', array('id' => $cate_id)) . '">' . $tmp['cat_name'] . '</a>';
				break;
			}
		}
		
		// 团购搜索
		$price1 = max(0, $_GET['price1']);
		$price2 = max(0, $_GET['price2']);
		$p = max(1, $_GET['p']);
		$order = strtolower($_GET['order']);
		$sort = strtolower($_GET['sort']);
		$limit = 50;
		
		// 价格搜索条件
		$where = '1';
		
		if ($price1 && $price2) {
			$where = " AND t.start_price >= '" . $price1 . "' AND t.start_price <= '" . $price2 . "'";
		} else if ($price1) {
			$where = " AND t.start_price >= '" . $price1 . "'";
		} else if ($price2) {
			$where = " AND t.start_price <= '" . $price2 . "'";
		}
		
		if ($keyword) {
			$where .= " AND t.name LIKE '%" . $keyword . "%'";
		}
		
		// 排序条件
		if (!in_array($order, array('time', 'hot', 'price'))) {
			$order = 'id';
		}
		
		if (!in_array($sort, array('asc', 'desc'))) {
			$sort = 'desc';
		}
		
		$order_by = 't.id';
		if ($order == 'time') {
			$order_by = 't.end_time';
		} else if ($order == 'hot') {
			$order_by = 't.count';
		} else if ($order == 'price') {
			$order_by = 't.start_price';
		}
		$order_by .= ' ' . $sort;
		
		$count = M('Tuan')->getCountByCategory($_GET['id'], $where);
		$tuan_list = array();
		$total_pages = ceil($count / $limit);
		if ($count > 0) {
			$p = min($p, $total_pages);
			$offset = ($p - 1) * $limit;
			$tuan_list = M('Tuan')->getListByCategory($_GET['id'], $where, $order_by, $offset, $limit);
			
			import('source.class.user_page');
			$page = new Page($count, $limit, $p);
			$this->assign('pages', $page->show());
		}
		
		// 默认、结束时间、拼团人气、拼团价格排序条件
		$param_defalut = array();
		if ($_GET['id']) {
			$param_defalut['id'] = $_GET['id'];
		}
		if ($price1) {
			$param_defalut['price1'] = $price1;
		}
		if ($price2) {
			$param_defalut['price2'] = $price2;
		}
		if ($keyword) {
			$param_defalut['keyword'] = $keyword;
		}
		
		$param_time = $param_defalut;
		$param_time['order'] = 'time';
		$param_time['sort'] = $order == 'time' && $sort == 'desc' ? 'asc' : 'desc';
		
		$param_hot = $param_defalut;
		$param_hot['order'] = 'hot';
		$param_hot['sort'] = $order == 'hot' && $sort == 'desc' ? 'asc' : 'desc';
		
		$param_price = $param_defalut;
		$param_price['order'] = 'price';
		$param_price['sort'] = $order == 'price' && $sort == 'desc' ? 'asc' : 'desc';
		
		$param_current = $param_defalut;
		if ($order != 'id') {
			$param_current['order'] = $order;
			$param_current['sort'] = $sort;
		}
		
		$this->assign('product_category', $product_category);
		$this->assign('category_first_href', $category_first_href);
		$this->assign('product_category_nav_list', $product_category_nav_list);
		$this->assign('top_cate_list', $top_cate_list);
		$this->assign('count', $count);
		$this->assign('p', $p);
		$this->assign('sort', $sort);
		$this->assign('order', $order);
		$this->assign('total_pages', $total_pages);
		$this->assign('tuan_list', $tuan_list);
		$this->assign('param_default', $param_defalut);
		$this->assign('param_time', $param_time);
		$this->assign('param_hot', $param_hot);
		$this->assign('param_price', $param_price);
		$this->assign('param_current', $param_current);
		$this->display();
	}
	
	// 团长
	public function team() {
		$cate_id = $_GET['id'];
		$product_category_nav_list = D('Product_category')->where(array('cat_fid' => $cate_id))->field('cat_id, cat_name')->order('cat_sort ASC, cat_id ASC')->select();
		
		// 顶级产品分类
		$top_cate_list = array();
		$product_category = array();
		if ($cate_id != 0) {
			$product_category = M('Product_category')->getCategory($cate_id);
			$top_cate_list = D('Product_category')->where(array('cat_fid' => 0))->field('cat_id, cat_name')->order('cat_sort ASC, cat_id ASC')->select();
		} else {
			$top_cate_list = $product_category_nav_list;
		}
		
		if ($product_category['cat_level'] == 2) {
			$s_category = D('Product_category')->where(array('cat_fid' => $product_category['cat_fid'], 'cat_status' => 1))->order('cat_sort ASC, cat_id ASC')->select();
			$this->assign("s_category", $s_category);
		}
		
		$category_first_href = '<a href="' . url('tuan:team') . '">全部</a>';
		$cate_id = $product_category['cat_fid'] ? $product_category['cat_fid'] : $cate_id;
		foreach ($top_cate_list as $tmp) {
			if ($cate_id == $tmp['cat_id']) {
				$category_first_href = '<a href="' . url('tuan:tuan_list', array('id' => $cate_id)) . '">' . $tmp['cat_name'] . '</a>';
				break;
			}
		}
		
		// 团购搜索
		$price1 = max(0, $_GET['price1']);
		$price2 = max(0, $_GET['price2']);
		$p = max(1, $_GET['p']);
		$order = strtolower($_GET['order']);
		$sort = strtolower($_GET['sort']);
		$type = $_GET['type'];
		$limit = 50;
		
		// 价格搜索条件
		$where = '1';
		if ($price1 && $price2) {
			$where .= " AND tt.price >= '" . $price1 . "' AND tt.price <= '" . $price2 . "'";
		} else if ($price1) {
			$where .= " AND tt.price >= '" . $price1 . "'";
		} else if ($price2) {
			$where .= " AND tt.price <= '" . $price2 . "'";
		}
		
		if ($type == 1 || $type == 2) {
			$where .= " AND tt.type = " . ($type - 1);
		}
		
		// 排序条件
		if (!in_array($order, array('complete', 'hot', 'price'))) {
			$order = 'id';
		}
		
		if (!in_array($sort, array('asc', 'desc'))) {
			$sort = 'desc';
		}
		
		$order_by = 'tt.team_id';
		if ($order == 'complete') {
			$order_by = '(tt.order_number / tt.number)';
		} else if ($order == 'hot') {
			$order_by = 'tt.order_number';
		} else if ($order == 'price') {
			$order_by = 'tt.price';
		}
		$order_by .= ' ' . $sort;
		
		$count = M('Tuan')->getCountByTeam($_GET['id'], $where);
		$tuan_list = array();
		$total_pages = ceil($count / $limit);
		if ($count > 0) {
			$p = min($p, $total_pages);
			$offset = ($p - 1) * $limit;
			$tuan_list = M('Tuan')->getListByTeam($_GET['id'], $where, $order_by, $offset, $limit);
				
			import('source.class.user_page');
			$page = new Page($count, $limit, $p);
			$this->assign('pages', $page->show());
		}
		
		// 默认、结束时间、拼团人气、拼团价格排序条件
		$param_defalut = array();
		if ($_GET['id']) {
			$param_defalut['id'] = $_GET['id'];
		}
		if ($price1) {
			$param_defalut['price1'] = $price1;
		}
		if ($price2) {
			$param_defalut['price2'] = $price2;
		}
		if ($type == 1 || $type == 2) {
			$param_defalut['type'] = $type;
		}
		
		$param_complete = $param_defalut;
		$param_complete['order'] = 'complete';
		$param_complete['sort'] = $order == 'complete' && $sort == 'desc' ? 'asc' : 'desc';
		
		$param_hot = $param_defalut;
		$param_hot['order'] = 'hot';
		$param_hot['sort'] = $order == 'hot' && $sort == 'desc' ? 'asc' : 'desc';
		
		$param_price = $param_defalut;
		$param_price['order'] = 'price';
		$param_price['sort'] = $order == 'price' && $sort == 'desc' ? 'asc' : 'desc';
		
		$param_current = $param_defalut;
		if ($order != 'id') {
			$param_current['order'] = $order;
			$param_current['sort'] = $sort;
		}
		
		$this->assign('product_category', $product_category);
		$this->assign('category_first_href', $category_first_href);
		$this->assign('product_category_nav_list', $product_category_nav_list);
		$this->assign('top_cate_list', $top_cate_list);
		$this->assign('count', $count);
		$this->assign('p', $p);
		$this->assign('sort', $sort);
		$this->assign('order', $order);
		$this->assign('total_pages', $total_pages);
		$this->assign('tuan_list', $tuan_list);
		$this->assign('param_default', $param_defalut);
		$this->assign('param_complete', $param_complete);
		$this->assign('param_hot', $param_hot);
		$this->assign('param_price', $param_price);
		$this->assign('param_current', $param_current);
		$this->display();
	}
}