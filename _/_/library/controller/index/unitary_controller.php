<?php
// 夺宝综合页面
class unitary_controller extends base_controller {

	public $area_ids;
	public $area_icons;
	public $now_url;

	private function getNowUrl () {

		if (!empty($_SERVER['REQUEST_URI'])) {
			return 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		}

		return 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
	}

	public function __construct() {
		parent::__construct();

		if (empty($this->user_session)) {
			redirect(url('user:user:login',array('referer'=>urlencode($this->getNowUrl())),true));
		}

		// nav列表
		$navList = F('pc_indiana_nav');
		if (empty($navList)) {
			$navList = M('Slider')->get_slider_by_key('pc_indiana_nav', 7);
			F('pc_indiana_nav', $navList);
		}

		// 夺宝购物车数量
		$unitary_cart['cart_count'] = M('Unitary_cart')->getCount(array('uid'=>$this->user_session['uid'], 'state'=>0));

		// 产品分类进行缓存
        $categoryList = F('pc_product_category_all');
        $categoryList = array();
        if (empty($categoryList)) {
            $categoryList = M('Product_category')->getAllCategory(13, true);

            if (!$categoryList) {
                $categoryList = array();
            }
            F('pc_product_category_all', $categoryList);
        }

        $this->area_icons = M('Unitary')->getArea();
        $this->area_ids =  array_flip($this->area_icons);

       	$this->now_url = $this->getNowUrl();

        $this->assign('area_icons', $this->area_icons);
        $this->assign('area_ids', $this->area_ids);

        $this->assign('now_url', $this->now_url);
		$this->assign('navList', $navList);
		$this->assign('unitary_cart', $unitary_cart);
		$this->assign('categoryList', $categoryList);
	}
	
	// 夺宝首页
	public function index() {

		// banner
		$adverTop = M('Adver')->get_adver_by_key('pc_indiana_adver', 8);

		// 头部最新揭晓
		$unitaryTopNew = M('Unitary')->getLastFinish(6);

		// 头部推荐夺宝
		$unitaryFirst = M('Unitary')->getListByKey('pc_indiana_today', 1); 
		$unitaryFirst = !empty($unitaryFirst) ? array_pop($unitaryFirst) : array();

		// 新品推荐
		$unitaryNewRecommend = M('Unitary')->getListByKey('pc_indiana_newcmd', 3);

		// 最热
		$unitaryHot = M('Unitary')->getListByKey('pc_indiana_hot', 8);
		// dump($unitaryHot);exit;
		// 自定义广告活动
		$unitaryCustom = M('Unitary')->getAdverList();

		// 底部最新上架
		$unitaryNew = M('Unitary')->getListByKey('pc_indiana_new', 8);

		// 一元传奇
		$oneLuckDog = M('Unitary')->getLuckDog();

		// dump($unitaryCustom);exit;
		$this->assign('adverTop', $adverTop);
		$this->assign('unitaryTopNew', $unitaryTopNew);
		$this->assign('unitaryFirst', $unitaryFirst);
		$this->assign('unitaryNewRecommend', $unitaryNewRecommend);
		$this->assign('unitaryHot', $unitaryHot);
		$this->assign('unitaryCustom', $unitaryCustom);
		$this->assign('unitaryNew', $unitaryNew);
		$this->assign('oneLuckDog', $oneLuckDog);
		$this->display();
	}
	
	// 详情页面
	public function detail () {

		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		if (empty($id) || !$find_unitary = D('Unitary')->where(array('id'=>$id))->find()) {
			redirect(url('unitary:index'));
		}

		$jonList = array();

		// 活动详情
		$find_user = array();
		$find_lucknum = array();
		$taLucknum = '';

		if ($find_unitary['state'] != 2) {
			$find_unitary['pay_count'] = D('Unitary_lucknum')->where(array('unitary_id'=>$val['activity_id']))->count('id');
			$find_unitary['left_count'] = $find_unitary['total_num'] - $find_unitary['pay_count'];
		} else {
			$find_unitary['pay_count'] = $find_unitary['total_num'];
			$find_unitary['left_count'] = 0;

			$where_lucknum = array(
				'unitary_id' => $find_unitary['id'],
				'state' => 1,
				'lucknum' => $find_unitary['lucknum'],
			);
			$find_lucknum = D('Unitary_lucknum')->where($where_lucknum)->find();
			$find_user = D('User')->where(array('uid'=>$find_lucknum['uid']))->find();

			$find_user['name'] = !empty($find_user['nickname']) ? $find_user['nickname'] : '匿名用户';
			$find_user['avatar'] = !empty($find_user['avatar']) ? $find_user['avatar'] : option('config.site_url').'/static/images/avatar.png';

			$find_user['get_time'] = $find_lucknum['addtime'];
			$find_user['get_date'] = M('Unitary')->micro_date($find_lucknum['addtime']);

			$countdown_time = $find_unitary['endtime'] - time();
			if ($countdown_time > 0) {
				$find_unitary['is_countdown'] = 1;
				$find_unitary['countdown_time'] = $countdown_time;
			} else {
				$find_unitary['is_countdown'] = 0;
				$find_unitary['countdown_time'] = 0;
			}

			$find_unitary['lucknum'] = 100000 + $find_unitary['lucknum'];

			// TA的夺宝号码
			$lucknumArray = M('Unitary')->getLucknumArr(array('uid'=>$find_lucknum['uid'],'unitary_id'=>$find_unitary['id']));
			$taLucknum = implode(' ', $lucknumArray);

			// 获取计算结果
			$jonList = M('Unitary')->getJoinList($id);
		}

		$find_product = M('Product')->get(array('product_id' => $find_unitary['product_id'], 'status' => 1));

		// 查找产品的图片
		$product_image_list = M('Unitary')->getImages($find_product['product_id']);
		$product_image_list[] = array('image'=>$find_unitary['logopic']);
		$product_image_list = array_reverse($product_image_list);

		$product_category = M('Product_category')->getOneCategoryTree($find_product['category_id']);

		$this->assign('unitary', $find_unitary);
		$this->assign('product', $find_product);
		$this->assign('find_user', $find_user);
		$this->assign('find_lucknum', $find_lucknum);
		$this->assign('taLucknum', $taLucknum);
		$this->assign('jonList', $jonList);
		$this->assign('product_category', $product_category);
		$this->assign('product_image_list', $product_image_list);
		$this->display();

	}

	// 获取夺宝详情页中的参与记录
	public function buy_list () {

		// $unitary_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$unitary_id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
		$page = max(1, $_REQUEST['page']);

		if (empty($unitary_id) || !$find_unitary = D('Unitary')->where(array('id'=>$unitary_id))->find()) {
			json_return(1000, '缺少参数，或未找到活动');
		}

		$limit = 50;
		$offset = ($page - 1) * $limit;
		$pages = "";

		$where_cart = array(
			'state' => 1,
			'unitary_id' => $unitary_id,
		);
		$count = D("Unitary_cart")->where($where_cart)->count("id");
		$cartList = M('Unitary_cart')->getList($where_cart, 'addtime DESC', $limit, $offset);

		if (count($cartList) > 0) {

			foreach ($cartList as &$val) {
				// 参与者
				$find_user = D('User')->field('nickname,uid,avatar,last_ip')->where(array('uid'=>$val['uid']))->find();
				$find_user['nickname'] = !empty($find_user['nickname']) ? $find_user['nickname'] : '匿名用户';
				$find_user['avatar'] = !empty($find_user['avatar']) ? $find_user['avatar'] : option('config.site_url').'/static/images/avatar.png';
				$find_user['last_ip'] = !empty($find_user['last_ip']) ? long2ip($find_user['last_ip']) : '未获取到IP';

				$val['user'] = $find_user;
			}

			// 分页
			import('source.class.unitary_page');
			$page = new Page($count, $limit, $page);
			$pages = $page->show();

		}

		$this->assign('pages', $pages);
		$this->assign('cartList', $cartList);
		$this->display();
	}

	// 点击获取购物记录中参与的lucknum数组
	public function get_lucknum_ajax () {

		$cart_id = isset($_REQUEST['cart_id']) ? intval($_REQUEST['cart_id']) : 0;

		if (empty($cart_id)) {
			json_return(1000, '缺少参数');
		}

		$lucknum_list = M('Unitary')->getLucknumArr(array('cart_id'=>$cart_id));
		if (empty($lucknum_list)) {
			json_return(1000, '参数错误');
		}

		$data = array();
		$data['lucknum_list'] = $lucknum_list;

		json_return(0, $data);

	}

	// 分类页面
	public function category () {

		$cat_id = isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;

		$selectOrderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : 'renqi';
		switch ($selectOrderBy) {
			case 'new':
				$order = 'u.addtime DESC';
				break;

			case 'total_asc':
				$order = 'u.total_num ASC';
				break;

			case 'total_desc':
				$order = 'u.total_num DESC';
				break;
			
			default:
				$order = 'u.renqi DESC';
				break;
		}

		// 基本参数设定
		$page = max(1, $_GET['page']);
		$limit = 20;

		$where = "";
		$selectCat = D('Product_category')->where(array('cat_id'=>$cat_id, 'cat_fid'=>0))->find();
		if (!empty($selectCat)) {
			$where = " u.state = 1 AND p.category_fid = ".$selectCat['cat_id'];
		} else { // 查全部
			$where = " u.state = 1";
		}

		$count = D('')->table('Unitary as u')
			->join("Product as p On u.product_id=p.product_id")
			->where($where)
			->count('u.id');

		$pages = '';
		if ($count > 0) {
			$total_pages = ceil($count / $limit);
			$page = min($page, $total_pages);
			$offset = ($page - 1) * $limit;

			$unitaryList = D('')->table('Unitary as u')
				->field('u.*')
				->join("Product as p On u.product_id=p.product_id")
				->where($where)
				->order($order)
				->limit($offset . ',' . $limit)
				->select();

			foreach ($unitaryList as &$val) {
				$val['pay_count'] = M('Unitary')->getPayCount($val['id']);
				$val['left_count'] = $val['total_num'] - $val['pay_count'];
			}

			// 分页
			import('source.class.unitary_page');

			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}

		// 全部活动分类
        $categoryListFull = F('pc_product_category_full');
        $categoryListFull = array();
        if (empty($categoryListFull)) {
            $categoryListFull = M('Product_category')->getAllCategory(99, true);

            if (!$categoryListFull) {
                $categoryListFull = array();
            }
            F('pc_product_category_full', $categoryListFull);
        }

		$this->assign('count', $count);
		$this->assign('pages', $pages);
		$this->assign('selectOrderBy', $selectOrderBy);
		$this->assign('unitaryList', $unitaryList);
		$this->assign('categoryListFull', $categoryListFull);
		$this->assign('selectCat', $selectCat);
		$this->display();

	}
	
	// 多元专区
	public function num_area () {

		$search_num = isset($_GET['area']) ? intval($_GET['area']) : 10;

		if (!in_array($search_num, $this->area_ids)) {
			redirect(url('unitary:category'));
		}

		// 基本参数设定
		$page = max(1, $_GET['page']);
		$limit = 20;

		$pages = '';
		$where = array();
		$where['state'] = 1;
		$where['item_price'] = $search_num;

		$count = D('Unitary')->where($where)->count('id');
		if ($count > 0) {
			$total_pages = ceil($count / $limit);
			$page = min($page, $total_pages);
			$offset = ($page - 1) * $limit;

			$unitaryList = D('Unitary')->where($where)->order('addtime DESC')->limit($offset . ',' . $limit)->select();
			foreach ($unitaryList as &$val) {
				$val['pay_count'] = M('Unitary')->getPayCount($val['id']);
				$val['left_count'] = $val['total_num'] - $val['pay_count'];
			}

			// 分页
			import('source.class.unitary_page');

			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}

		$this->assign('areaNum', $search_num);
		$this->assign('pages', $pages);
		$this->assign('unitaryList', $unitaryList);
		$this->display();

	}

	// 即将揭晓
	public function last_result () {

		// 最新结束的18条记录
		$unitaryEndList = M('Unitary')->getLastEndList(18);

		// 参与比例最大的记录
		$unitaryFastList = M('Unitary')->getFastList(8);

		// dump($unitaryEndList);exit;

		$this->assign('endList', $unitaryEndList);
		$this->assign('fastList', $unitaryFastList);
		$this->display();
	}


	// 购物车
	public function cart () {

		$where_cart = array(
			'uid' => $this->user_session['uid'],
			'state' => 0,
		);
		$count = D('Unitary_cart')->where($where_cart)->count('id');
		$cart_list = D('Unitary_cart')->where($where_cart)->select();

		$total = 0;	// 数量
		$sum = 0;	// 参与的活动数量
		$unitary = array();
		$unitary_ycount = array();

		foreach ($cart_list as $vo) {

			$total = $total + $vo['count'];
			$sum++;

			$unitary_ycount[$vo['id']] = M('Unitary_cart')->getLeftCount($vo['unitary_id']);
			// 重设购物车数量
			if ($unitary_ycount[$vo['id']] <= 0) {
				$del_cart = D('Unitary_cart')->where(array('id'=>$vo['id'], 'store_id'=>$vo['store_id']))->delete();
				$sum = $sum - 1;
				$total = $total - $vo['count'];

			} elseif ($unitary_ycount[$vo['id']] < $vo['count']) {
				$update_cart = D('Unitary_cart')->where(array('id'=>$vo['id']))->save(array('count'=>$unitary_ycount[$vo['id']]));
				$cha = $vo['count'] - $unitary_ycount[$vo['id']];
				$total = $total - $cha;

			}

		}

		// 重新获取未支付购物车记录
		$cart_list = array();
		$cart_list3 = D('Unitary_cart')->where($where_cart)->select();
		foreach ($cart_list3 as $val) {

			$find_unitary = M('Unitary')->getUnitary($val['unitary_id']);
			$find_unitary['pay_count'] = M('Unitary')->getPayCount($val['unitary_id']);
			$find_unitary['left_count'] = $find_unitary['total_num'] - $find_unitary['pay_count'];

			$tmp_cart = $val;
			$tmp_cart['unitary'] = $find_unitary;
			$cart_list[$val['store_id']]['list'][] = $tmp_cart;

			$cart_list[$val['store_id']]['shop'] = D('Store')->field('name,store_id')->where(array('store_id'=>$val['store_id']))->find();
		}

		$this->assign('cart_list', $cart_list);

		$this->assign('total', $total);
		$this->assign('sum', $sum);
		$this->assign('ycount', $unitary_ycount);
		$this->display();
	}

	// 操作购物车 (ajax)
	public function cartajax () {

		$type = isset($_POST['type']) ? trim($_POST['type']) : '';
		// $store_id = isset($_POST['store_id']) ? intval($_POST['store_id']) : 0;

		if (empty($type)) {
			json_return(1000, '缺少参数');
		}

		switch ($type) {

			case 'click_cart_count':	//点击购物车输入框 - 提示活动状态、删除15分钟未支付订单

				$where_cart['id'] = isset($_POST['cart_id']) ? intval($_POST['cart_id']) : 0;

				if (empty($where_cart['id'])) {
					json_return(1000, '缺少参数');
				}

				$find_cart = D('Unitary_cart')->where($where_cart)->find();
				if (empty($find_cart)) {
					json_return(1000, '购物记录已经过期，请重新下单');
				}

				$unitary_ycount = M('Unitary_cart')->getLeftCount($find_cart['unitary_id']);

				if ($unitary_ycount == 0) {
					$del_cart = D('Unitary_cart')->where($where_cart)->delete();
					json_return(1000, "此商品已结束");
				} else {
					if (empty($find_cart)) {
						json_return(1000, "此商品已结束");
					} else {
						json_return(0, array('ycount'=>$unitary_ycount));	//剩余数量
					}
				}

				break;

			case 'cart_count_change':		// 购物车输入框数值发生变化时调用 修改该购物车数量、删除15分钟未支付订单

				$count = $point_count = isset($_POST['cart_count']) ? abs(intval($_POST['cart_count'])) : 0;
				$where_cart['id'] = isset($_POST['cart_id']) ? intval($_POST['cart_id']) : 0;
				$where_cart['state'] = 0;
				$where_cart['uid'] = $this->user_session['uid'];

				if (empty($where_cart['id'])) {
					json_return(1000, '网络错误');
				}

				$find_cart = D('Unitary_cart')->where($where_cart)->find();
				if (empty($find_cart)) {
					json_return(1000, '购物记录已经过期');
				}

				$where_unitary = array('id'=>$find_cart['unitary_id']);
				$find_unitary = D('Unitary')->where($where_unitary)->find();

				$unitary_ycount = M('Unitary_cart')->getLeftCount($find_cart['unitary_id']);

				if ($count > 10000) {
					$count = 10000;
					$save_cart['count'] = $count;
					$yiwan = "yes";
				} elseif (($count - floor($count)) > 0) {
					$count = floor($count);
					$save_cart['count'] = $count;
					$xiaoshu = "yes";
				} elseif ($count > $unitary_ycount) {
					$count = $unitary_ycount;
					$save_cart['count'] = $count;
					$dale = "yes";
				} else {
					$save_cart['count'] = $count;
				}

				$update_cart = D('Unitary_cart')->where($where_cart)->data($save_cart)->save();
				$where_cart3 = array(
					'uid' => $this->user_session['uid'],
					'state' => 0,
				);
				$cart_list2 = D('Unitary_cart')->where($where_cart3)->select();
				$total_price = 0;
				foreach ($cart_list2 as $vo) {
					$find_unitary = M('Unitary')->getUnitary($vo['unitary_id']);
					$total_price = $total_price + $vo['count']*$find_unitary['item_price'];
				}

				$find_cart = D('Unitary_cart')->where($where_cart)->find();
				if (empty($find_cart) || $unitary_ycount == 0) {
					if ($unitary_ycount == 0) {
						$del_cart = D('Unitary_cart')->where($where_cart)->delete();
					}

					json_return(1000, "此商品已结束");

				} else {
					if (empty($point_count)) {
						$error_code = 1000;
						$data['cart_count'] = "";
						$data['msg'] = "请填写数字";
						$data['total_price'] = $total_price;
						$data['ycount'] = $unitary_ycount;
						json_return($error_code, $data['msg']);

					} else {
						if ($yiwan == "yes") {
							$error_code = 1000;
							$data['msg'] = "单次购买不可超过1万";
							json_return($error_code, $data['msg']);
						} elseif ($xiaoshu == "yes") {
							$error_code = 1000;
							$data['msg'] = "不能是小数";
							json_return($error_code, $data['msg']);
						} elseif ($dale == "yes") {
							$error_code = 1000;
							$data['msg'] = "不能超过".$unitary_ycount."人次";
							json_return($error_code, $data['msg']);
						} else {
							$error_code = 0;
						}

						$data['cart_count'] = $count;
						$data['total_price'] = $total_price;
						$data['ycount'] = $unitary_ycount;

					}

					json_return($error_code, $data);
				}

				break;

			case 'cart_del':					// 删除一条购物记录，返回购物车种类、总数量

				$where_cart['id'] = isset($_POST['cart_id']) ? intval($_POST['cart_id']) : 0;

				if (empty($where_cart['id'])) {
					json_return(1000, "缺少参数");
				}
				
				$where_cart['uid'] = $this->user_session['uid'];
				$where_cart['state'] = 0;
				$del_cart = D('Unitary_cart')->where($where_cart)->delete();

				if ($del_cart > 0) {
					$where_cart2 = array(
						'uid' => $this->user_session['uid'],
						'state' => 0,
					);
					$cart_list = D('Unitary_cart')->where($where_cart2)->select();
					$total_price = 0;
					$count = 0;
					foreach ($cart_list as $vo) {
						$find_unitary = M('Unitary')->getUnitary($vo['unitary_id']);
						$total_price = $total_price + $vo['count']*$find_unitary['item_price'];
						$count++;
					}

					$error_code = 0;
					$data['total_price'] = $total_price;	// 购物车总价
					$data['count'] = $count;				// 购物车数量
				} else {
					$error_code = 1000;
					$data = '删除错误';
				}

				json_return($error_code, $data);
				break;

			case 'del_all':		// 清空购物车
				
				$where_cart['uid'] = $this->user_session['uid'];
				$where_cart['state'] = 0;
				$del_cart = D('Unitary_cart')->where($where_cart)->delete();

				if ($del_cart > 0) {
					json_return(0, '删除成功');
				}

				json_return(1000, '删除失败');

				break;

		}
	}

	// ajax获取购物记录
	public function ajax_cartlist () {

		$where_cart = array(
			'uid' => $this->user_session['uid'],
			'state' => 0,
		);
		$count = D('Unitary_cart')->where($where_cart)->count('id');
		$cart_list = D('Unitary_cart')->where($where_cart)->select();

		$total = 0;	// 数量
		$sum = 0;	// 参与的活动数量
		$unitary = array();
		$unitary_ycount = array();
		$data = array();
		$total_price = 0;

		foreach ($cart_list as $vo) {

			$total = $total + $vo['count'];
			$sum++;

			$unitary_ycount[$vo['id']] = M('Unitary_cart')->getLeftCount($vo['unitary_id']);
			// 重设购物车数量
			if ($unitary_ycount[$vo['id']] <= 0) {
				$del_cart = D('Unitary_cart')->where(array('id'=>$vo['id'], 'store_id'=>$vo['store_id']))->delete();
				$sum = $sum - 1;
				$total = $total - $vo['count'];

			} elseif ($unitary_ycount[$vo['id']] < $vo['count']) {
				$update_cart = D('Unitary_cart')->where(array('id'=>$vo['id']))->save(array('count'=>$unitary_ycount[$vo['id']]));
				$cha = $vo['count'] - $unitary_ycount[$vo['id']];
				$total = $total - $cha;

			}

		}

		// 重新获取未支付购物车记录 不按店铺分组
		$cart_list = array();
		$cart_list3 = D('Unitary_cart')->where($where_cart)->select();
		foreach ($cart_list3 as $val) {

			$find_unitary = M('Unitary')->getUnitary($val['unitary_id']);
			$find_unitary['pay_count'] = M('Unitary')->getPayCount($val['unitary_id']);
			$find_unitary['left_count'] = $find_unitary['total_num'] - $find_unitary['pay_count'];

			$tmp_cart = $val;
			$tmp_cart['unitary'] = $find_unitary;

			$total_price = $total_price + $val['count']*$find_unitary['item_price'];

			$cart_list[] = $tmp_cart;

		}

		$data['total'] = $count;
		$data['sum'] = $sum;
		$data['total_price'] = $total_price;
		$data['ycount'] = $unitary_ycount;
		$data['list'] = $cart_list;

		json_return(0, $data);

	}

	// 取随机数据 (ajax)
	public function round_list () {

		$unitary_list = D('')->query("select * from ".option('system.DB_PREFIX')."unitary where `state` = 1 order by rand() limit 5");
		if (!empty($unitary_list)) {

			foreach ($unitary_list as &$val) {
				$val['url'] = option('config.site_url').'/index.php?c=unitary&a=detail&id='.$val['id'];
			}

			json_return(0, $unitary_list);
		}

		json_return(0, '错误');

	}

	// 加入购物车
	public function add_cart () {

		$unitary_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$count = isset($_POST['count']) ? intval($_POST['count']) : 1;

		$where_cart = array(
			'uid' => $this->user_session['uid'],
			'unitary_id' => $unitary_id,
			'state' => 0,
		);
		$find_cart = D('Unitary_cart')->where($where_cart)->find();

		$find_unitary = M('Unitary')->getUnitary($unitary_id);
		if ($find_unitary['state'] != 1) {
			json_return(1000, '活动失效');
		}

		$find_unitary['pay_count'] = M('Unitary')->getPayCount($unitary_id);
		$find_unitary['left_count'] = $find_unitary['total_num'] - $find_unitary['pay_count'];

		$count = ($count > $find_unitary['left_count']) ? $find_unitary['left_count'] : $count;

		if (empty($find_cart)) {
			$add_cart = array(
				'uid' => $this->user_session['uid'],
				'unitary_id' => $unitary_id,
				'addtime' => time(),
				'count' => $count,
				'state' => 0,
				'store_id' => $find_unitary['store_id'],
			);
			$result_cart = D('Unitary_cart')->data($add_cart)->add();

		} else {
			$add_count = $find_cart['count'] + $count;
			$save_cart['count'] = ($add_count > $find_unitary['left_count']) ? $find_unitary['left_count'] : $add_count;
			if ($save_cart['count'] == $find_cart['count']) {
				json_return(1000, '添加购物车超限，请修改购买数量');
			}

			$result_cart = D('Unitary_cart')->where($where_cart)->data($save_cart)->save();
		}

		if ($result_cart) {
			json_return(0, '添加购物车成功');
		}

		json_return(1000, '添加购物车失败，请刷新后再试');

	}

	// 显示结算页面(确认订单)
	public function cart_balance () {

		$where_cart['store_id'] = isset($_GET['store_id']) ? intval($_GET['store_id']) : 0;
		$where_cart['uid'] = $this->user_session['uid'];
		$where_cart['state'] = 0;

		$cart_list = D('Unitary_cart')->where($where_cart)->select();
		if (empty($cart_list)) {
			redirect(url('unitary:cart'));
		}

		$total_price = 0;
		foreach ($cart_list as &$val) {
			$find_unitary = D('Unitary')->where(array('id'=>$val['unitary_id']))->find();
			$val['unitary'] = $find_unitary;
			$total_price += $val['unitary']['item_price']*$val['count'];
		}

		$this->assign('total_price', $total_price);
		$this->assign('cart_list', $cart_list);
		$this->display();

	}

	// 夺宝个人中心
	public function account () {

		$type = isset($_GET['type']) ? trim($_GET['type']) : 'list';

		$this->assign('now_page', $type);
		$this->display();

	}

	public function account_list () {

		$page = max(1, $_REQUEST['page']);
		$status = isset($_REQUEST['status']) ? trim($_REQUEST['status']) : 'all';

		$time = time();

		$limit = 10;
		$offset = ($page - 1) * $limit;
		$pages = "";

		$where = array();
    	$where[] = " j.uid = ".$this->user_session['uid']." ";

    	switch ($status) {
			case 'ing':
				$where[] = " u.state = 1 ";
				break;

			case 'end':
				$where[] = " u.state = 2 and u.endtime <= $time ";
				break;
			
			case 'reveal':
				$where[] = " u.state = 2 and u.endtime > $time ";
				break;

			default:
				break;
		}

    	$where_str = implode(' and ', $where);
    	$count = D('')->table('Unitary as u')
				->join("Unitary_join as j On u.id=j.unitary_id")
				->where($where_str)
				->count('u.id');

		$unitary_list = D('')->table('Unitary as u')
				->join("Unitary_join as j On u.id=j.unitary_id")
				->where($where_str)
				->field("u.*")
				->order("j.addtime desc")
				->limit($offset . ',' . $limit)
				->select();

		// 用户参与的活动 数量
		$num_arr = M('Unitary')->getMyJoin($this->user_session['uid'], $time);

		if (count($unitary_list) > 0) {

			foreach ($unitary_list as &$val) {
				// 中奖用户
				$lucknum = D('Unitary_lucknum')->where(array('state'=>1, 'unitary_id'=>$val['id']))->find();

				$find_user = D('User')->field('nickname,uid')->where(array('uid'=>$lucknum['uid']))->find();
				$val['luck_uid'] = $lucknum['uid'];
				$val['luck_name'] = !empty($find_user['nickname']) ? $find_user['nickname'] : '匿名用户';
				$val['user_count'] = D('Unitary_lucknum')->where(array('uid'=>$lucknum['uid'], 'unitary_id'=>$val['id']))->count('id');
				$val['lucknum'] = $lucknum['lucknum'];
				$val['is_countdown'] = ($val['endtime'] - time() > 0) ? 1 : 0;

				// 自己的参与数量
				$lucknum_list = M('Unitary')->getLucknumArr(array('unitary_id'=>$val['id']));

				$val['my_count'] = count($lucknum_list);
				$val['my_lucknum_str'] = implode(' ', $lucknum_list);

				if ($val['state'] == 1) {
					$val['pay_count'] = D('Unitary_lucknum')->where(array('unitary_id'=>$val['id']))->count('id');
					$val['left_count'] = $val['total_num'] - $val['pay_count'];					
				}
			}

			// 分页
			import('source.class.unitary_page');
			$page = new Page($count, $limit, $page);
			$pages = $page->show();
		}


		$this->assign('cart_list', $unitary_list);
		$this->assign('status', $status);
		$this->assign('pages', $pages);
		$this->assign('num_arr', $num_arr);
		$this->display();
	}

	public function account_luck () {

		$page = max(1, $_REQUEST['page']);

		$limit = 5;
		$offset = ($page - 1) * $limit;
		$pages = "";

		$where_lucknum = array(
			'uid' => $this->user_session['uid'],
			'state' => 1,
		);
		$count = D('Unitary_lucknum')->where($where_lucknum)->count('id');
		$lucknum_list = D('Unitary_lucknum')->where($where_lucknum)->order('addtime desc')->limit($offset . ',' . $limit)->select();

		if (count($lucknum_list) > 0) {

			foreach ($lucknum_list as &$val) {

				$find_unitary = D('Unitary')->field('name,logopic,total_num,endtime')->where(array('id'=>$val['unitary_id']))->find();

				$order = D('Order')->field('order_no,status')->where(array('type'=>51, 'activity_id'=>$val['unitary_id']))->find();
				$val['order_no'] = option('config.orderid_prefix').$order['order_no'];
				$val['order_status'] = M('Order')->status($order['status']);

				$val['my_count'] = D('Unitary_lucknum')->where(array('unitary_id'=>$val['unitary_id'], 'uid'=>$this->user_session['uid']))->count('id');
				$val['add_date'] = M('Unitary')->micro_date($val['addtime']);
				$val['name'] = $find_unitary['name'];
				$val['logopic'] = $find_unitary['logopic'];
				$val['total_num'] = $find_unitary['total_num'];
				$val['endtime'] = $find_unitary['endtime'];

			}

			// 分页
			import('source.class.unitary_page');
			$page = new Page($count, $limit, $page);
			$pages = $page->show();
		}

		$this->assign('pages', $pages);
		$this->assign('lucknum_list', $lucknum_list);
		$this->display();
	}

	public function reset_join () {

	}

}