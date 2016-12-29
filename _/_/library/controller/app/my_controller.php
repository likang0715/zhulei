<?php
/**
 * 平台个人中心控制器
 */
class my_controller extends base_controller {
	// 平台个人中心首页
	public function index() {
		$user = D('User')->where(array('uid' => $this->user['uid']))->find();
		$user['avatar'] = $user['avatar'] ? getAttachmentUrl($user['avatar']) : getAttachmentUrl('images/touxiang.png', false);
		
		$credit_setting_tmp = option('credit');
		
		$credit_setting = array();
		$credit_setting['platform_credit_open'] = $credit_setting_tmp['platform_credit_open'];
		$credit_setting['platform_credit_name'] = $credit_setting_tmp['platform_credit_name'] ? $credit_setting_tmp['platform_credit_name'] : '平台币';
		
		$point_shop = D('Store')->where(array('is_point_mall' => 1, 'status' => 1))->field('store_id')->find();
		
		$return_user = array();
		$return_user['uid'] = $user['uid'];
		$return_user['nickname'] = $user['nickname'];
		$return_user['avatar'] = $user['avatar'];
		$return_user['point_balance'] = $user['point_balance'];
		$return_user['point_gift'] = $user['point_gift'];
		
		$return = array();
		$return['credit_setting'] = $credit_setting;
		$return['user'] = $return_user;
		$return['point_store_id'] = isset($point_shop['store_id']) ? $point_shop['store_id'] : 0;
		
		json_return(0, $return);
	}

	// 购物车
	public function cart() {
		$store_id = $_REQUEST['store_id'];
		
		$cart_where = "`uc`.`store_id`=`s`.`store_id` AND `uc`.`product_id`=`p`.`product_id`";
		$cart_where .= " AND `uc`.`uid`='" . $this->user['uid']."'";
		$cart_list = D('')->field('`s`.`store_id`,`s`.`name` AS `store_name`,`uc`.`pigcms_id`,`uc`.`product_id`,`uc`.`pro_num`,`uc`.`pro_price`,`uc`.`sku_id`,`uc`.`sku_data`,`p`.`name`,`p`.`image`,`p`.`quantity`,`p`.`status`')->table(array('User_cart'=>'uc','Product'=>'p','Store'=>'s'))->where($cart_where)->order('`pigcms_id` DESC')->select();
		
		$store_cart_list = array();
		foreach($cart_list as $value){
			$value['sku_num'] = 0;
			if($value['sku_id'] && $value['quantity'] && $value['status'] == 1){
				$product_sku = D('Product_sku')->field('`quantity`')->where(array('sku_id'=>$value['sku_id']))->find();
				$value['sku_num'] = $product_sku['quantity'];
			}else if($value['quantity']){
				$value['sku_num'] = $value['quantity'];
			}
			
			if ($value['sku_data']) {
				$value['sku_data'] = unserialize($value['sku_data']);
			} else {
				$value['sku_data'] = array();
			}
			$value['image'] = getAttachmentUrl($value['image']);
			
			$store_cart_list[$value['store_id']]['store_id'] = $value['store_id'];
			$store_cart_list[$value['store_id']]['store_name'] = $value['store_name'];
			$store_cart_list[$value['store_id']]['cart_list'][] = $value;
		}
		
		$store_cart = array();
		if (isset($_REQUEST['store_id']) && !empty($store_cart_list[$_REQUEST['store_id']])) {
			$store_cart = $store_cart_list[$_REQUEST['store_id']];
			unset($store_cart_list[$_REQUEST['store_id']]);
		} else {
			$store_cart = array_shift($store_cart_list);
		}
		
		// key连续方式重新索引
		$cart_list = array_merge($store_cart_list);
		
		$return = array();
		$return['store_cart'] = $store_cart;
		$return['store_cart_list'] = $cart_list;
		
		json_return(0, $return);
	}
	
	// 平台推广
	public function promotion() {
		$action = $_REQUEST['action'];
		// 平台数据
		$promote_array = array();
		$promote_array['name'] = option('config.site_name');
		$promote_array['logo'] = option('config.site_logo');
		
		// 推广信息
		$store_promote_setting = D('Store_promote_setting')->where(array('type' => 1, 'status' => 1, 'owner' => 2))->find();
		
		if ($action == 'down') {
			// 获取平台推广二维码
			$qrcode = M('Recognition')->get_platform_limit_scene_qrcode('limit_scene_' . $this->user['uid']);
			
			if ($qrcode['error_code']) {
				json_return(1000, $qrcode['msg']);
			} elseif (empty($store_promote_setting)) {
				json_return(1000, '未设置平台推广');
			} else {
				$result = M('Store_promote_setting')->createImage($store_promote_setting, $qrcode, $this->user, $promote_array);
				json_return(0, $result['0']);
			}
		}
		
		// 推广作用
		$desc_arr = array();
		$desc_arr[] = '分销商推广自己的名片可获得更多的下级用户';
		$desc_arr[] = '分销商也可引入更多的流量';
		$desc_arr[] = '帮助供货商销售更多的商品，获得更多的分润';
		$desc_arr[] = '用户也可给平台推广，可获得平台提供的奖励';
		
		$return = array();
		$return['nickname'] = $this->user['nickname'];
		$return['site_name'] = $promote_array['name'];
		$return['desc_arr'] = $desc_arr;
		$return['image'] = in_array($promote['poster_type'], array(1, 2, 3)) ? option('config.site_url') . '/template/wap/default/img/' . $promote['poster_type'] . '.png' : option('config.site_url') . '/template/wap/default/img/1.png';
		
		// 分享
		if ($this->is_app) {
			$share_conf = array(
					'title' => $promote_array['name'], // 分享标题
					'desc' => str_replace(array("\r", "\n"), array('', ''), $store_promote_setting['content']), // 分享描述
					'link' => option('config.wap_site_url').'?uid=' . $this->user['uid'],
					'imgUrl' => $promote_array['logo'],
			);
			$return['share_conf'] = $share_conf;
		} else {
			$url = urldecode($_REQUEST['url']);
			// 分享
			import('WechatShare');
			$share = new WechatShare();
			$share_data = $share->getSgin('', true, $url);
			$return['share_data'] = $share_data;
		}
		
		json_return(0, $return);
	}
	
	// 退货、维权售后服务
	public function service() {
		$page = max(1, $_REQUEST['page']);
		$type = strtolower($_REQUEST['type']);
		$limit = 10;
		$offset = ($page - 1) * $limit;
		
		if (!in_array($type, array('return', 'rights'))) {
			json_return(1000, '参数错误');
		}
		
		if ($type == 'return') {
			$where_sql = "r.uid = '" . $this->user['uid'] . "' AND r.user_return_id = 0";
			$return_list = M('Return')->getList($where_sql, $limit, $offset);
			
			foreach ($return_list as &$value) {
				$value['return_id'] = $value['id'];
				
				unset($value['id']);
			}
			
			$return = array();
			$return['return_list'] = $return_list;
			$return['next_page'] = true;
			if (count($return_list) < $limit) {
				$return['next_page'] = false;
			}
			
			json_return(0, $return);
		} else {
			$where_sql = "r.uid = '" . $this->user['uid'] . "' AND r.user_rights_id = 0";
			$rights_list = M('Rights')->getList($where_sql, $limit, $offset);
			
			foreach ($rights_list as &$rights) {
				$rights['rights_id'] = $rights['id'];
				$rights['sku_data_arr'] = array();
				if ($rights['sku_data']) {
					$rights['sku_data_arr'] = unserialize($rights['sku_data']);
				}
				unset($rights['id']);
			}
			
			$return = array();
			$return['rights_list'] = $rights_list;
			$return['next_page'] = true;
			if (count($rights_list) < $limit) {
				$return['next_page'] = false;
			}
			
			json_return(0, $return);
		}
		
	}
	
	// 浏览历史记录
	public function history() {
		$action = $_REQUEST['action'];
		if ($action == 'clean') {
			setcookie('good_history', '', $_SERVER['REQUEST_TIME'] - 86400 * 365, '/');
			json_return(0, '清除成功');
		}
		
		$good_history = $_COOKIE['good_history'];
		$url = option('config.wap_site_url');
		if (!empty($good_history)) {
			$good_history_arr = json_decode(stripslashes($good_history),true);
			if (is_array($good_history_arr)) {
				$product_list = array();
				foreach($good_history_arr as $value) {
					if ($_SERVER['REQUEST_TIME'] - $value['time'] > 7 * 86400) {
						continue;
					}
		
					$product = D('Product')->where(array('product_id' => $value['id'], 'status' => 1))->field('product_id, name, image, price')->find();
					if (empty($product)) {
						continue;
					}
		
					$product['image'] = getAttachmentUrl($product['image']);
					$product['time_txt'] = getHumanTime($_SERVER['REQUEST_TIME'] - $value['time']) . '前';
					$product['url'] = $url . '/good.php?product_id=' . $value['id'] . '&store_id=' . $value['store_id'];
					
					$product_list[] = $product;
				}
					
				$good_history_arr = $product_list;
			}
		}
		
		json_return(0, array('product_list' => $good_history_arr));
	}
	
	// 我的会员卡
	public function card() {
		$user = D('User')->where(array('uid' => $this->user['uid']))->field('uid, nickname, avatar, point_balance')->find();
		$user['avatar'] = $user['avatar'] ? getAttachmentUrl($user['avatar']) : getAttachmentUrl('images/touxiang.png', false);
		$user['ewm'] = url('qrcode:ewm', array('uid' => $this->user['uid']));
		
		json_return(0, array('user' => $user));
	}
	
	// 我的收藏产品、店铺
	public function collect() {
		$type = $_REQUEST['type'];
		$page = max(1, $_REQUEST['page']);
		$limit = 10;
		$offset = ($page - 1) * $limit;
		
		// 1:产品，2：店铺
		if (!in_array($type, array(1, 2))) {
			json_return(1000, '参数错误');
		}
		
		if ($type == 1) {
			$product_list = D('User_collect AS uc')->join('Product AS p ON p.product_id = uc.dataid')->where("p.status = 1")->field('uc.store_id, uc.add_time, p.product_id, p.name, p.image, p.price')->order('uc.collect_id DESC')->limit($offset . ', ' . $limit)->select();
			foreach ($product_list as &$product) {
				$product['image'] = getAttachmentUrl($product['image']);
			}
			
			$return = array();
			$return['product_list'] = $product_list;
			$return['next_page'] = true;
			if (count($product_list) < $limit) {
				$return['next_page'] = false;
			}
			
			json_return(0, $return);
		} else {
			$store_list = D('User_collect AS uc')->join('Store AS s ON s.store_id = uc.dataid')->where("s.status = 1")->field('uc.store_id, uc.add_time, s.name, s.logo')->order('uc.collect_id DESC')->limit($offset . ', ' . $limit)->select();
			foreach ($store_list as &$store) {
				$store['logo'] = getAttachmentUrl($store['logo']);
			}
				
			$return = array();
			$return['store_list'] = $store_list;
			$return['next_page'] = true;
			if (count($store_list) < $limit) {
				$return['next_page'] = false;
			}
			
			json_return(0, $return);
		}
	}
	
	// 我的关注店铺
	public function subscribe() {
		$page = max(1, $_REQUEST['page']);
		$limit = 10;
		$offset = ($page - 1) * $limit;
		
		$store_list = D('Subscribe_store AS ss')->join('Store AS s ON s.store_id = ss.store_id')->where("s.status = 1")->field('ss.store_id, ss.user_subscribe_time as add_time, s.name, s.logo')->order('ss.sub_id DESC')->limit($offset . ', ' . $limit)->select();
		foreach ($store_list as &$store) {
			$store['logo'] = getAttachmentUrl($store['logo']);
		}
		
		$return = array();
		$return['store_list'] = $store_list;
		$return['next_page'] = true;
		if (count($store_list) < $limit) {
			$return['next_page'] = false;
		}
			
		json_return(0, $return);
	}
}
?>