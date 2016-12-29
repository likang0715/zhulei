<?php
/**
 * 平台个人中心控制器
 */
class home_controller extends base_controller {
	// 平台个人中心首页
	public function index() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
	    $uid = $_REQUEST['uid'];
		$token = $_REQUEST['token'];
		$tokens = D('Users_token')->where(array('uid' => $uid))->find();
		if ($token!=$tokens['token']) {
		     $results['result']='1';
			$results['msg']='token不正确';
			exit(json_encode($results));
		}
		$user = D('User')->field('nickname,phone,avatar,point_balance,sex,intro')->where(array('uid' => $uid))->find();
		$user['avatar'] = $user['avatar'] ? getAttachmentUrl($user['avatar']) : getAttachmentUrl('images/touxiang.png', false);
		
		
		
		
		
		
		
		
		 $slide 	= M('Adver')->get_adver_by_key('app_home',1);
    
		 foreach($slide as $key=>$r){
	
		 $user['ad']	=  $r['pic'];
		
		 }
	
		 
		
		$results['data']=$user;
		
		
	    exit(json_encode($results));
	}



	public function profile() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
	    $uid = $_REQUEST['uid'];
		$token = $_REQUEST['token'];
		$tokens = D('Users_token')->where(array('uid' => $uid))->find();
		if ($token!=$tokens['token']) {
		     $results['result']='1';
			$results['msg']='token不正确';
			exit(json_encode($results));
		}
    	if (empty($uid)) {
		     $results['result']='1';
			$results['msg']='uid不正确';
			exit(json_encode($results));
		}
	
		$user = D('User')->where(array('uid' => $uid))->field('phone, nickname, password')->find();
		
		if ($_REQUEST['action'] == 'password') {
			$old_password = $_POST['old_password'];
			$new_password = $_POST['new_password'];
			
			if (empty($old_password)) {
				
				$results['result']='1';
				$results['msg']='原密码不能为空';
				exit(json_encode($results));
			}
			
			if (empty($new_password)) {
				
				$results['result']='1';
				$results['msg']='新密码不能为空';
				exit(json_encode($results));
			}
			
			if (md5($old_password) != $user['password']) {
				
				$results['result']='1';
				$results['msg']='原密码不正确';
				exit(json_encode($results));
			}
			
			D('User')->where(array('uid' => $uid))->data(array('password' => md5($new_password)))->save();
			$results['data']='修改完成';
			exit(json_encode($results));
		} else if ($_REQUEST['action'] == 'content') {
			$nickname = $_REQUEST['nickname'];
			
			if (!empty($nickname)) {
			D('User')->where(array('uid' => $uid))->data(array('nickname' => $nickname))->save();
			}
			
			$sex = $_REQUEST['sex'];
			
			if (!empty($sex)) {
		
			D('User')->where(array('uid' => $uid))->data(array('sex' => $sex))->save();
			}
			
			$avatat = $_REQUEST['avatat'];
			
			if (!empty($avatat)) {
			D('User')->where(array('uid' => $uid))->data(array('avatat' => $avatat))->save();
			}
			
			$intro = $_REQUEST['intro'];
			
			if (!empty($intro)) {
		
			D('User')->where(array('uid' => $uid))->data(array('intro' => $intro))->save();
			}
			
			$_SESSION['app_user']['nickname'] = $nickname;
			$results['msg']='修改完成';
			exit(json_encode($results));
		}
		
	}



	// 购物车
	public function cart() {
		$store_id = $_REQUEST['store_id'];
		
		$cart_where = "`uc`.`store_id`=`s`.`store_id` AND `uc`.`product_id`=`p`.`product_id`";
		$cart_where .= " AND `uc`.`uid`='" . $uid."'";
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
			$qrcode = M('Recognition')->get_platform_limit_scene_qrcode('limit_scene_' . $uid);
			
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
					'link' => option('config.wap_site_url').'?uid=' . $uid,
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
			$where_sql = "r.uid = '" . $uid . "' AND r.user_return_id = 0";
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
			$where_sql = "r.uid = '" . $uid . "' AND r.user_rights_id = 0";
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
		$user = D('User')->where(array('uid' => $uid))->field('uid, nickname, avatar, point_balance')->find();
		$user['avatar'] = $user['avatar'] ? getAttachmentUrl($user['avatar']) : getAttachmentUrl('images/touxiang.png', false);
		$user['ewm'] = url('qrcode:ewm', array('uid' => $uid));
		
		json_return(0, array('user' => $user));
	}
	
	// 我的收藏产品、店铺
	public function collect() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
	    $uid = $_REQUEST['uid'];
		$token = $_REQUEST['token'];
		$tokens = D('Users_token')->where(array('uid' => $uid))->find();
		if ($token!=$tokens['token']) {
		     $results['result']='1';
			$results['msg']='token不正确';
			exit(json_encode($results));
		}
		
		$type = $_REQUEST['type'];
		$page = max(1, $_REQUEST['page']);
		$limit =  max(1, $_REQUEST['size']);
		$offset = ($page - 1) * $limit;
		
		// 1:产品，2：店铺
		if (!in_array($type, array(1, 2, 3,4))) {
			$results['result']='1';
			$results['msg']='参数错误';
			exit(json_encode($results));
		}
		
		
		
		if ($type == 1) {
		$count = D('User_collect AS uc')->join('Product AS p ON p.product_id = uc.dataid')->where("uc.type = 1 and p.status = 1 and uc.user_id = '$uid'")->field('uc.store_id, uc.add_time, p.product_id as dataid, p.name, p.image, p.price')->order('uc.collect_id DESC')->count();
			$product_list = D('User_collect AS uc')->join('Product AS p ON p.product_id = uc.dataid')->where("uc.type = 1 and p.status = 1 and uc.user_id = '$uid'")->field('uc.store_id, uc.add_time, p.product_id as dataid, p.name, p.image, p.price')->order('uc.collect_id DESC')->limit($offset . ', ' . $limit)->select();
			
			//$sql=D('User_collect AS uc')->last_sql;
		
			foreach ($product_list as &$product) {
				$product['images'] = getAttachmentUrl($product['image']);
			}
			
			$return = array();
			$store_list = $product_list;
			
			$return['next_page'] = '1';
			if (count($product_list) < $limit) {
				$return['next_page'] = '0';
			}
			$results['data']=$store_list;
			$total_pages = ceil($count / $limit);
		
		} elseif ($type == 2)  {
		$count = D('User_collect AS uc')->join('Store_physical AS s ON s.pigcms_id = uc.dataid')->where("uc.type = 2 and uc.user_id = '$uid'")->field('s.pigcms_id as dataid, s.name, s.images')->order('uc.collect_id DESC')->count();
			$store_list = D('User_collect AS uc')->join('Store_physical AS s ON s.pigcms_id = uc.dataid')->where("uc.type = 2 and uc.user_id = '$uid'")->field('s.pigcms_id as dataid, s.name, s.images')->order('uc.collect_id DESC')->limit($offset . ', ' . $limit)->select();
			
			foreach ($store_list as &$store) {
				$store['images'] = getAttachmentUrl($store['images']);
				$stores = D('Store_contact')->where("store_id = '$store[store_id]'")->find();
				$store['address'] = $stores['address'];
			}
				
			$return = array();
			$return['store_list'] = $store_list;
			$return['next_page'] = '1';
			if (count($store_list) < $limit) {
				$return['next_page'] = '0';
			}
			$results['data']=$store_list;
		
			$total_pages = ceil($count / $limit);
		} elseif ($type == 3)  {
		$count = D('User_collect AS uc')->join('Chahui AS s ON s.pigcms_id = uc.dataid')->where("uc.type = 3 and s.status = 1 and uc.user_id = '$uid'")->field('uc.store_id, uc.add_time, s.name, s.images, s.pigcms_id as dataid, s.sttime, s.price, s.address')->order('uc.collect_id DESC')->count();
			$store_list = D('User_collect AS uc')->join('Chahui AS s ON s.pigcms_id = uc.dataid')->where("uc.type = 3 and s.status = 1 and uc.user_id = '$uid'")->field('uc.store_id, uc.add_time, s.name, s.images, s.pigcms_id as dataid, s.sttime, s.price, s.address')->order('uc.collect_id DESC')->limit($offset . ', ' . $limit)->select();
			foreach ($store_list as &$store) {
			if($store['price']>0){
		     $store['price']=$store['price'];
	       	}else{
		     $store['price']='免费';
		    }
				$store['images'] = getAttachmentUrl($store['images']);
				$store['sttime'] = date('m/s H:i',$store['sttime']);
				$store['add_time'] = date('Y-m-s H:i:s',$store['add_time']);
			
			}
				
			$return = array();
			$return['chahui_list'] = $store_list;
			$return['next_page'] = '1';
			if (count($store_list) < $limit) {
				$return['next_page'] = '0';
			}
			
		$results['data']=$store_list;
		$total_pages = ceil($count / $limit);
		} elseif ($type == 4)  {
		$count = D('User_collect AS uc')->join('Meal_cz AS s ON s.cz_id = uc.dataid')->where("uc.type = 4 and s.status = 1 and uc.user_id = '$uid'")->field('uc.add_time, s.name, s.image, s.cz_id, s.price')->order('uc.collect_id DESC')->count();
			$store_list = D('User_collect AS uc')->join('Meal_cz AS s ON s.cz_id = uc.dataid')->where("uc.type = 4 and s.status = 1 and uc.user_id = '$uid'")->field('uc.add_time, s.name, s.image as images, s.cz_id as dataid, s.price')->order('uc.collect_id DESC')->limit($offset . ', ' . $limit)->select();
			foreach ($store_list as &$store) {
			if($store['price']>0){
		     $store['price']=$store['price'];
	       	}else{
		     $store['price']='免费';
		    }
				$store['images'] = getAttachmentUrl($store['images']);
				$store['sttime'] = date('m/s H:i',$store['sttime']);
				$store['add_time'] = date('Y-m-s H:i:s',$store['add_time']);
			
			}
				
			$return = array();
		
			$return['next_page'] = '1';
			if (count($store_list) < $limit) {
				$return['next_page'] = '0';
			}
			
			$total_pages = ceil($count / $limit);
			
		$results['data']=$store_list;
		
		}
		 $page_info['page_count'] =  (string)$total_pages;;
	$page_info['page_index'] =  (string)$page;
	$results['page_info'] =  $page_info;
		exit(json_encode($results));
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
	
	
	public function send_list () {

  $results = array('result'=>'0','data'=>array(),'msg'=>'');
 
 
  $where=array();

 $where['type'] = 999;

$send_list=array();
  $list = D('Sms_jpush')->where($where)->order('time DESC')->limit(10)->select();

  foreach($list as $key=>$r){
    $send_list[$key]['id']=$r['id'];
    $send_list[$key]['time']=date('Y-m-d H:i:s',$r['time']);
    $send_list[$key]['text']=$r['text'];
  }



$results['data']=$send_list;
exit(json_encode($results));

}


}
?>