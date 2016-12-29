<?php 
/**
 * 店铺用户中心
 */
class ucenter_controller extends base_controller {
	public function index() {
		$store_id = $_REQUEST['store_id'];
		
		if (empty($store_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		$store = M('Store')->getStore($store_id, true);
		if (empty($store)) {
			json_return(1000, '未找到相应的店铺');
		}
		
		$user = D('User')->where(array('uid' => $this->user['uid']))->find();
		if (empty($user)) {
			json_return(1000, '未找到相应的用户');
		}
		
		$user['avatar'] = $user['avatar'] ? getAttachmentUrl($user['avatar']) : getAttachmentUrl('images/touxiang.png', false);
		
		// 会员中心配置
		$root_supplier_id = $store['root_supplier_id'] ? $store['root_supplier_id'] : $store['store_id'];
		$ucenter = D('Ucenter')->where(array('store_id' => $root_supplier_id))->find();
		if (empty($ucenter)) {
			$ucenter['page_title'] = option('config.ucenter_page_title');
			$ucenter['bg_pic'] = option('config.site_url') . '/upload/images/' . option('config.ucenter_bg_pic');
		} else {
			$ucenter['bg_pic'] = getAttachmentUrl($ucenter['bg_pic']);
			$ucenter['tab_name'] = unserialize($ucenter['tab_name']);
			$ucenter['consumption_field'] = unserialize($ucenter['consumption_field']);
			$ucenter['promotion_field'] = unserialize($ucenter['promotion_field']);
			$ucenter['member_content'] = unserialize($ucenter['member_content']);
			$ucenter['promotion_content'] = unserialize($ucenter['promotion_content']);
		}
		
		// 用户在此店铺的数据
		$store_user_data = M('Store_user_data')->getUserData($store_id, $this->user['uid']);
		
		// 退货数量
		$return_count = M('Return')->getCount(array('uid' => $this->user['uid'], 'store_id' => $store_id, 'user_return_id' => 0));
		$store_user_data['return_count'] = $return_count;
		
		// 返回数据
		$return = array();
		$return['is_supplier'] = false;
		$return['is_fx'] = false;
		
		// 个人中心用户、店铺显示数据
		$return['user_data'] = $this->userFavoriteData($ucenter, $store_user_data, $root_supplier_id);
		
		if ($store['root_supplier_id'] == 0 && $store['uid'] == $this->user['uid']) {
			// 自己是供货商
			$return['is_supplier'] = true;
		} else {
			// 查找用户分销商店铺
			$store_fx = D('Store')->where(array('uid' => $this->user['uid'], 'root_supplier_id' => $root_supplier_id))->find();
			if (!empty($store_fx)) {
				$return['is_fx'] = true;
				// 是供货商店铺的分销商
				$return['store_data'] = $this->storeFavoriteData($ucenter, $store_user_data, $store_fx);
				$return['store_fx'] = array('store_id' => $store_fx['store_id'], 'name' => $store_fx['name']);
			}
		}
		
		//收藏的产品
		$product_list = D('User_collect AS c')->join('Product AS p ON c.dataid = p.product_id')->where("c.user_id = '" . $this->user['uid'] . "' AND c.type = 1 AND c.store_id = '" . $root_supplier_id . "'")->field('p.product_id, p.name, p.image, c.add_time')->order('c.add_time DESC')->limit(10)->select();
		foreach ($product_list as &$product) {
			$product['image'] = getAttachmentUrl($product['image']);
		}
		
		$subject_list = D('User_collect AS c')->join('subject AS s ON c.dataid = s.id')->where("c.user_id = '" . $this->user['uid'] . "' AND c.type = 3 AND c.store_id = '" . $root_supplier_id . "'")->field('s.id as subject_id, s.name, s.pic, c.add_time')->order('c.add_time DESC')->limit(10)->select();
		foreach ($subject_list as &$subject) {
			$subject['pic'] = getAttachmentUrl($subject['pic']);
		}
		
		$return['user'] = array('nickname' => $user['nickname'], 'avatar' => $user['avatar']);
		$return['product_list'] = $product_list;
		$return['subject_list'] = $subject_list;
		
		// 会员中心配置数据处理
		if (empty($ucenter['tab_name'])) {
			$ucenter['tab_name'] = array('消费中心', '推广中心');
		}
		unset($ucenter['promotion_content']);
		unset($ucenter['member_content']);
		unset($ucenter['promotion_field']);
		unset($ucenter['consumption_field']);
		
		$return['ucenter'] = $ucenter;
		$return['store_user_data'] = $store_user_data;
		
		$custom_field_list = array();
		if ($ucenter['has_custom']) {
			$custom_field_list = M('Custom_field')->getFields($root_supplier_id, 'ucenter', $store_id, $store['drp_level'], $store['drp_diy_store']);
		}
		
		$return['custom_field_list'] = $custom_field_list;
		
		//公共广告判断
		$ad_data = array();
		$ad_data['has_ad'] = false;
		$ad_data['ad_position'] = $store['ad_position'];
		if ($store['open_ad'] && !empty($store['use_ad_pages'])) {
			$user_ad_pages_arr = explode(',', $store['use_ad_pages']);
			if (in_array('4', $user_ad_pages_arr)) {
				$custom_field_ad_list = M('Custom_field')->getFields($root_supplier_id, 'common_ad', $store_id, $store['drp_level'], $store['drp_diy_store']);
				if (!empty($user_ad_pages_arr)) {
					$ad_data['has_ad'] = true;
					$ad_data['custom_field_ad_list'] = $custom_field_ad_list;
				}
			}
		}
		$return['ad_data'] = $ad_data;
		
		json_return(0, $return);
	}
	
	// 用户积分明细
	public function point_list() {
		$store_id = $_REQUEST['store_id'];
		$page = max(1, $_REQUEST['page']);
		$limit = 15;
		$offset = ($page - 1) * $limit;
		
		if (empty($store_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		$store = M('Store')->getStore($store_id, true);
		if (empty($store)) {
			json_return(1000, '未找到相应的店铺');
		}
		
		$user = D('User')->where(array('uid' => $this->user['uid']))->find();
		if (empty($user)) {
			json_return(1000, '未找到相应的用户');
		}
		
		$point_type_arr = array(1 => '关注公众号送', 2 => '订单满送', 3 => '消费送', 4 => '分享送', 5 => '签到送', 6 => '买特殊商品所送', 7 => '手动变更', 8 => '推广增加', 9 => '订单抵扣现金', 10=> '退货退还积分', 11=> '升级会员等级');
		
		$root_supplier_id = $store['root_supplier_id'] ? $store['root_supplier_id'] : $store_id;
		$user_points_list = D('User_points')->field('points, type, timestamp')->where(array('uid' => $this->user['uid'], 'store_id' => $root_supplier_id))->order('timestamp DESC')->limit($offset . ', ' . $limit)->select();
		foreach ($user_points_list as &$user_points) {
			$user_points['type_txt'] = $point_type_arr[$user_points['type']] ? $point_type_arr[$user_points['type']] : '其它';
		}
		
		$return = array();
		$return['user_points_list'] = $user_points_list;
		$return['next_page'] = true;
		if (count($user_points_list) < $limit) {
			$return['next_page'] = false;
		}
		
		if ($page == 1) {
			$store_user_data = D('Store_user_data')->where(array('store_id' => $root_supplier_id, 'uid' => $this->user['uid']))->find();
			$return['user_point'] = $store_user_data['point'] + 0;
		}
		
		json_return(0, $return);
	}
	
	// 会员签到中心
	public function sign() {
		$store_id = $_REQUEST['store_id'];
		
		if (empty($store_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		$store = M('Store')->getStore($store_id, true);
		if (empty($store)) {
			json_return(1000, '未找到相应的店铺');
		}
		
		$user = D('User')->where(array('uid' => $this->user['uid']))->find();
		if (empty($user)) {
			json_return(1000, '未找到相应的用户');
		}
		
		$root_supplier_id = $store['root_supplier_id'] ? $store['root_supplier_id'] : $store['store_id'];
		
		// 获取今日积分配置
		$store_points_config = D('Store_points_config')->where(array('store_id' => $root_supplier_id))->find();
		if (empty($store_points_config) || empty($store_points_config['sign_set'])) {
			json_return(1000, '店铺未开启签到');
		}
		
		$max_sign_point = 0;
		if ($store_points_config['sign_type'] == 1) {
			$max_sign_point = $store_points_config['sign_plus_start'] + $store_points_config['sign_plus_addition'] * $store_points_config['sign_plus_day'];
		}
		
		// 查找今天是否已签到
		$time = time();
		$timestamp = strtotime(date('Y-m-d 00:00:00', $time));
		$whereSigned = array();
		$whereSigned['store_id'] = $root_supplier_id;
		$whereSigned['uid'] = $this->user['uid'];
		$whereSigned['type'] = 5;
		$whereSigned['timestamp'] = array('>=', $timestamp);
		
		$return = array();
		$return['is_sign'] = false;
		$user_points = D('User_points')->where($whereSigned)->find();
		if (!empty($user_points)) {
			$return['is_sign'] = true;
		}
		
		// 用户获得积分规则内容
		$return['points_desc'] = '';
		
		// 今日积分数
		if ($store_points_config['sign_type'] == 0) {
			// 每日固定值增加
			$return['points'] = $store_points_config['sign_fixed_point'];
			$return['points_desc'] = '每日签到可得 ' . $store_points_config['sign_fixed_point'] . ' 积分';
		} else if ($store_points_config['sign_type'] == 1) {
			// 不固定逻辑处理
			$days = M('Store_user_data')->getUserSignDay($store_id, $uid);
			if ($days >= $store_points_config['sign_plus_day']) {
				$days = $store_points_config['sign_plus_day'] - 1;
			}
			$add_points = $days * $store_points_config['sign_plus_addition'];
			$return['points'] = $store_points_config['sign_plus_start'] + $add_points;
			
			$return['points_desc'] = '初次签到可得 ' . $store_points_config['sign_plus_start'] . ' 积分，连续签到每日额外增加 ' . $store_points_config['sign_plus_addition'] . ' 积分，最多为 ' . $max_sign_point . ' 积分';
		}
		
		$return['user_name'] = $this->user['nickname'];
		$return['store_name'] = $store['name'];
		
		// 分享链接
		$return['share_link'] = M('Share_record')->createLink($store_id, $this->user['uid']);
		$return['qrcode_image'] = option('config.site_url') . '/source/qrcode.php?type=pointShare&id=' . $this->user['uid']. '&url=' . urlencode($return['share_link']);
		$return['banner_image'] = option('config.site_url') . '/template/wap/default/points/images/singinbanner.png';
		
		json_return(0, $return);
	}
	
	// 签到
	public function signup() {
		$store_id = $_REQUEST['store_id'];
		
		if (empty($store_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		$store = M('Store')->getStore($store_id, true);
		if (empty($store)) {
			json_return(1000, '未找到相应的店铺');
		}
		
		$user = D('User')->where(array('uid' => $this->user['uid']))->find();
		if (empty($user)) {
			json_return(1000, '未找到相应的用户');
		}
		
		$root_supplier_id = $store['root_supplier_id'] ? $store['root_supplier_id'] : $store['store_id'];
		$drp_result = M('Share_record')->is_drp_store($this->user['uid'], $store_id);
		
		//判断当前用户是否是该供货商的分销商
		if ($drp_result['is_drp']) {
			$check_result = Points::sign($this->user['uid'], $root_supplier_id, $drp_result['seller_id']);
		} else {
			$check_result = Points::sign($this->user['uid'], $store_id);
		}
		
		if ($check_result === false) {
			json_return(1000, '签到失败');
		}
		
		json_return(0, '签到成功');
	}
	
	// 会员等级
	public function degree() {
		$store_id = $_REQUEST['store_id'];
		
		if (empty($store_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		$store = M('Store')->getStore($store_id, true);
		if (empty($store)) {
			json_return(1000, '未找到相应的店铺');
		}
		
		$user = D('User')->where(array('uid' => $this->user['uid']))->find();
		if (empty($user)) {
			json_return(1000, '未找到相应的用户');
		}
		
		// 店铺用户中心数据
		$store_user_data = M('Store_user_data')->getUserData($store_id, $this->user['uid']);
		if ($_REQUEST['action'] == 'exchange_degree') {
			if ($store['degree_exchange_type'] != '1') {
				json_return(1000, '店铺未开启手工升级');
			}
			
			$degree_id = $_REQUEST['degree_id'];
			$supplier_store_id = $store['top_supplier_id'] ? $store['top_supplier_id'] : $store_id;
			
			import('source.class.Points');
			$return = Points::upDegree($this->user['uid'], $supplier_store_id, $degree_id);
			echo json_encode($return);
			exit;
		}
		
		// 当前用户数据
		$user = array();
		$user['avatar'] = getAttachmentUrl($this->user['avator'] ? $this->user['avator'] : option('config.site_url') . '/static/images/default_shop_2.jpg');
		$user['point'] = $store_user_data['point'];
		$user['expire_day'] = max(1, ceil((strtotime(trim($store_user_data['degree_date'])) - time()) / 86400));
		$user['degree_name'] = $store_user_data['degree_name'];
		$user['degree_logo'] = $store_user_data['degree_logo'];
		
		// 等级相关
		$top_supplier_id = $store['top_supplier_id'] ? $store['top_supplier_id'] : $store['store_id'];
		$user_degree_list_tmp = M('User_degree')->getList(array('store_id' => $top_supplier_id));
		
		$user_degree_list = array();
		foreach ($user_degree_list_tmp as $user_degree) {
			$tmp = array();
			$tmp['degree_id'] = $user_degree['id'];
			$tmp['name'] = $user_degree['name'];
			$tmp['degree_logo'] = $user_degree['new_level_pic'];
			$tmp['point'] = $user_degree['level_num'];
			$tmp['degree_month'] = $user_degree['degree_month'];
			$tmp['is_points_discount_ratio'] = $user_degree['is_points_discount_ratio'];
			$tmp['points_discount_ratio'] = $user_degree['points_discount_ratio'];
			$tmp['is_discount'] = $user_degree['is_discount'];
			$tmp['discount'] = $user_degree['discount'];
			$tmp['is_postage_free'] = $user_degree['is_postage_free'];
			$tmp['is_points_discount_toplimit'] = $user_degree['is_points_discount_toplimit'];
			$tmp['points_discount_toplimit'] = $user_degree['points_discount_toplimit'];
			
			$user_degree_list[] = $tmp;
		}
		
		$return = array();
		$return['user'] = $user;
		$return['user_degree_list'] = $user_degree_list;
		$return['degree_exchange_type'] = $store['degree_exchange_type'];
		
		json_return(0, $return);
	}
	
	// 个人推广
	public function publicize() {
		$store_id = $_REQUEST['store_id'];
		
		if (empty($store_id)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		$store = M('Store')->getStore($store_id, true);
		if (empty($store)) {
			json_return(1000, '未找到相应的店铺');
		}
		
		$user = D('User')->where(array('uid' => $this->user['uid']))->find();
		if (empty($user)) {
			json_return(1000, '未找到相应的用户');
		}
		
		$return = array();
		$return['user_name'] = $this->user['nickname'];
		$return['store_name'] = $store['name'];
		
		// 分享链接
		$return['share_link'] = M('Share_record')->createLink($store_id, $this->user['uid']);
		$return['qrcode_image'] = option('config.site_url') . '/source/qrcode.php?type=pointShare&id=' . $this->user['uid']. '&url=' . urlencode($return['share_link']);
		
		json_return(0, $return);
	}
	
	// 修改个人资料
	public function profile() {
		$user = D('User')->where(array('uid' => $this->user['uid']))->field('phone, nickname, password')->find();
		
		if ($_POST['action'] == 'password') {
			$old_password = $_POST['old_password'];
			$new_password = $_POST['new_password'];
			
			if (empty($old_password)) {
				json_return(1000, '原密码不能为空');
			}
			
			if (empty($new_password)) {
				json_return(1000, '新密码不能为空');
			}
			
			if (md5($old_password) != $user['password']) {
				json_return(1000, '原密码不正确');
			}
			
			D('User')->where(array('uid' => $this->user['uid']))->data(array('password' => md5($new_password)))->save();
			json_return(0, '修改完成');
		} else if ($_POST['action'] == 'nickname') {
			$nickname = $_POST['nickname'];
			if (empty($nickname)) {
				json_return(1000, '昵称不能为空');
			}
			
			D('User')->where(array('uid' => $this->user['uid']))->data(array('nickname' => $nickname))->save();
			$_SESSION['app_user']['nickname'] = $nickname;
			json_return(0, '修改完成');
		}
		
		json_return(0, array('user' => $user));
	}
	
	// 用户个性化数据
	private function userFavoriteData($ucenter, $store_user_data, $root_supplier_id) {
		// 是否设置个性化个人中心
		$consumption_field = isset($ucenter['consumption_field']) && !empty($ucenter['consumption_field']);
		$member_content = !isset($ucenter['member_content']) && empty($ucenter['member_content']);
		
		$user_data = array();
		// 是否显示用户昵称
		if (!$consumption_field || ($consumption_field && in_array('1', $ucenter['consumption_field']))) {
			$tmp = array();
			$tmp['display'] = true;
			$tmp['icon'] = '';
			$tmp['name'] = 'top_nickname';
			$tmp['value'] = !empty($this->user['nickname']) ? $this->user['nickname'] : '';
			$user_data[] = $tmp;
		}
		
		// 是否显示用户等级
		if (!$consumption_field || ($consumption_field && in_array('3', $ucenter['consumption_field']))) {
			$tmp = array();
			$tmp['display'] = true;
			$tmp['icon'] = '';
			$tmp['name'] = 'top_degree';
			$tmp['value'] = $store_user_data['degree_name'];
			$user_data[] = $tmp;
		}
		
		// 是否显示会员积分
		if (!$consumption_field || ($consumption_field && in_array('2', $ucenter['consumption_field']))) {
			$tmp = array();
			$tmp['display'] = true;
			$tmp['icon'] = '';
			$tmp['name'] = 'top_point';
			$tmp['value'] = $store_user_data['point'] + 0;
			$user_data[] = $tmp;
		}
		
		// 是否显示用户在此店铺的消费
		if (!$consumption_field || ($consumption_field && in_array('4', $ucenter['consumption_field']))) {
			$consume = D('Order')->where(array('user_order_id' => 0, 'status' => array('in', array(2, 3, 4, 7)), 'uid' => $this->user['uid']))->sum('total');
				
			$tmp = array();
			$tmp['display'] = true;
			$tmp['icon'] = '';
			$tmp['name'] = 'top_consume';
			$tmp['value'] = $consume;
			$user_data[] = $tmp;
		}
		
		// 店铺开启签到
		$store_points_config = D('Store_points_config')->where(array('store_id' => $root_supplier_id))->find();
		if ($store_points_config['sign_set']) {
			$tmp = array();
			$tmp['display'] = true;
			$tmp['icon'] = '';
			$tmp['name'] = 'top_sign';
			$tmp['value'] = '点我签到';
			$user_data[] = $tmp;
		}
		
		$url = option('config.site_url') . '/template/wap/default/ucenter/images/';
		
		$data_arr = array(
					array(8, '1.png', 'cart', '我的购物车'),
					array(9, '16.png', 'level', '会员等级'),
					array(10, '19.png', 'point', '积分明细'),
					array(11, '17.png', 'single', '个人推广'),
					array(1, '2.png', 'order', '我的订单'),
					array(2, '3.png', 'coupon', '我的礼券'),
					array(5, '4.png', 'address', '收货地址'),
					array(6, '5.png', 'profile', '个人资料')
				);
		
		foreach ($data_arr as $data) {
			$tmp = array();
			$tmp['display'] = isset($ucenter['member_content'][$data[0]]) || !isset($ucenter['member_content']);
			$tmp['icon'] = $url . $data[1];
			$tmp['name'] = $data[2];
			$tmp['value'] = isset($ucenter['member_content'][$data[0]]) ? $ucenter['member_content'][$data[0]] : $data[3];
			$user_data[] = $tmp;
		}
		
		$tmp = array();
		$tmp['display'] = true;
		$tmp['icon'] = $url . '18.png';
		$tmp['name'] = 'activity';
		$tmp['value'] = '我的活动';
		$user_data[] = $tmp;
		
		return $user_data;
	}
	
	// 店铺个性化数据
	private function storeFavoriteData($ucenter, $store_user_data, $store) {
		$promotion_field = isset($ucenter['promotion_field']) && !empty($ucenter['promotion_field']);
		
		$store_data = array();
		// 是否显示店铺名称
		if (!$promotion_field || ($promotion_field && in_array('1', $ucenter['promotion_field']))) {
			$tmp = array();
			$tmp['display'] = true;
			$tmp['icon'] = '';
			$tmp['name'] = 'top_store_name';
			$tmp['value'] = $store['name'];
			$store_data[] = $tmp;
		}
		
		// 是否显示店铺等级
		if (!$promotion_field || ($promotion_field && in_array('2', $ucenter['promotion_field']))) {
			//分销等级
			$degree_name = '默认等级';
			if ($store['drp_degree_id']) {
				$drp_degree = D('Drp_degree')->where(array('pigcms_id' => $store['drp_degree_id']))->find();
				if ($drp_degree['degree_alias']) {
					$degree_name = $drp_degree['degree_alias'];
				} else {
					$platform_drp_degree = D('Platform_drp_degree')->field('name')->where(array('pigcms_id' => $drp_degree['is_platform_degree_name']))->find();
					if (!empty($platform_drp_degree)) {
						$degree_name = $platform_drp_degree['name'];
					}
				}
			}
			
			$tmp = array();
			$tmp['display'] = true;
			$tmp['icon'] = '';
			$tmp['name'] = 'top_degree';
			$tmp['value'] = $degree_name;
			$store_data[] = $tmp;
		}
		
		// 是否显示会员积分、收入
		if (!$promotion_field || ($promotion_field && in_array('3', $ucenter['promotion_field']))) {
			$tmp = array();
			$tmp['display'] = true;
			$tmp['icon'] = '';
			$tmp['name'] = 'top_point';
			$tmp['value'] = $store_user_data['store_point'] + 0;
			$store_data[] = $tmp;
			
			$tmp = array();
			$tmp['display'] = true;
			$tmp['icon'] = '';
			$tmp['name'] = 'top_balance';
			$tmp['value'] = M('Financial_record')->drpProfit(array('store_id' => $store['store_id']));
			$store_data[] = $tmp;
			
			// 是否显示销售额
			if (!$promotion_field || ($promotion_field && in_array('4', $ucenter['promotion_field']))) {
				$tmp = array();
				$tmp['display'] = true;
				$tmp['icon'] = '';
				$tmp['name'] = 'top_sales';
				$tmp['value'] = $store['sales'];
				$store_data[] = $tmp;
			}
		}
		
		$url = option('config.site_url') . '/template/wap/default/ucenter/images/';
		$data_arr = array(
				array(1, '6.png', 'product', '推广仓库'),
				array(2, '7.png', 'order', '推广订单'),
				array(3, '8.png', 'commission', '推广奖金'),
				array(4, '9.png', 'team', '我的团队'),
				array(5, '10.png', 'popularize', '我的推广'),
				array(6, '11.png', 'qrcode', '我的名片'),
				array(7, '12.png', 'team_manage', '团队管理'),
				array(8, '13.png', 'team_rank', '团队排名'),
				array(9, '14.png', 'info', '推广说明'),
				array(10, '15.png', 'synopsis', '企业说明'),
				array(11, '18.png', 'level', '等级积分'),
				array(13, 'qiehuan.png', 'change_store', '切换店铺'),
				array(14, 'thwq.png', 'return_rights', '退货维权'),
				array(15, '7.png', 'fans', '我的粉丝'),
		);
		
		foreach ($data_arr as $data) {
			$tmp = array();
			$tmp['display'] = isset($ucenter['promotion_content'][$data[0]]) || !isset($ucenter['promotion_content']);
			$tmp['icon'] = $url . $data[1];
			$tmp['name'] = $data[2];
			$tmp['value'] = isset($ucenter['promotion_content'][$data[0]]) ? $ucenter['promotion_content'][$data[0]] : $data[3];
			$store_data[] = $tmp;
		}
		
		
		return $store_data;
	}
}