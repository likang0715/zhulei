<?php
/**
 * 收藏控制器
 */
class shoucang_controller extends base_controller{
	// 添加收藏
	public function add() {
		$results = array('result'=>'0','data'=>array(),'msg'=>'');
		$uid = $_REQUEST['uid'];
		$token = $_REQUEST['token'];
		$dataid = intval($_REQUEST['dataid']);
		$type = intval($_REQUEST['type']);
		$store_id = intval($_REQUEST['store_id']);
		
		$tokens = D('Users_token')->where(array('uid' => $uid))->find();
		if ($token!=$tokens['token']) {
		     $results['result']='1';
			$results['msg']='token不正确';
			exit(json_encode($results));
		}
		if (empty($dataid)) {
			$results['result']='1';
			$results['msg']='缺少最基本的参数';
			exit(json_encode($results));
		}
		
		if (!in_array($type, array(1, 2, 3, 4))) {
			
			$results['result']='1';
			$results['msg']='收藏类型错误';
			exit(json_encode($results));
		}
		
		if ($type == 1) {
			$data = D('Product')->where(array('product_id' => $dataid, 'status' => 1))->find();
			if (empty($data)) {
			
			$results['result']='1';
			$results['msg']='产品不存在';
			exit(json_encode($results));
			}
		} elseif ($type == 2) {
			$data = D('Store')->where(array('store_id' => $dataid, 'status' => 1))->find();
			if (empty($data)) {
			$results['result']='1';
			$results['msg']='店铺不存在';
			exit(json_encode($results));
			}
		} elseif ($type == 3) {
			$data = D('Chahui')->where(array('pigcms_id' => $dataid, 'status' => 1))->find();
			if (empty($data)) {
			$results['result']='1';
			$results['msg']='茶会不存在';
			exit(json_encode($results));
			}
		} elseif ($type == 4) {
			$data = D('Meal_cz')->where(array('cz_id' => $dataid))->find();
			if (empty($data)) {
			$results['result']='1';
			$results['msg']='包厢不存在';
			exit(json_encode($results));
			}
		}
		if ($type == 2) {
		// 查看是否已经收藏过
		$user_collect = D('User_collect')->where(array('user_id' => $uid, 'type' => $type, 'dataid' => $dataid,'store_id' => $store_id))->find();
		}else{
		$user_collect = D('User_collect')->where(array('user_id' => $uid, 'type' => $type, 'dataid' => $dataid))->find();
		
		}
		if (!empty($user_collect)) {
		
			$results['result']='1';
			$results['msg']='已经收藏过了';
			exit(json_encode($results));
			
		}
		
		$result = M('User_collect')->add($uid, $dataid, $type, $store_id);
		if ($result) {
			$results['msg']='收藏成功';
			exit(json_encode($results));
		}
		
	
		$results['result']='1';
		$results['msg']='收藏失败';
		exit(json_encode($results));
	}
	
	
	
	public function find() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
	    $uid = $_REQUEST['uid'];
		$token = $_REQUEST['token'];
		$dataid = intval($_REQUEST['dataid']);
		$type = intval($_REQUEST['type']);
		$store_id = intval($_REQUEST['store_id']);
	
	if (empty($dataid)) {
			$results['result']='1';
			$results['msg']='缺少最基本的参数';
			exit(json_encode($results));
		}
		
		if (!in_array($type, array(1, 2, 3, 4))) {
			
			$results['result']='1';
			$results['msg']='收藏类型错误';
			exit(json_encode($results));
		}
	
	
	if ($type == 2) {
		// 查看是否已经收藏过
		$user_collect = D('User_collect')->where(array('user_id' => $uid, 'type' => $type, 'dataid' => $dataid,'store_id' => $store_id))->find();
		}else{
		$user_collect = D('User_collect')->where(array('user_id' => $uid, 'type' => $type, 'dataid' => $dataid))->find();
		
		}

		if (!empty($user_collect)) {
		
			$results['result']='1';
			$results['msg']='已经收藏过了';
			exit(json_encode($results));
			
		}
		exit(json_encode($results));
	}
	
	// 取消收藏
	public function cancel() {
		$results = array('result'=>'0','data'=>array(),'msg'=>'');
		$uid = $_REQUEST['uid'];
		$token = $_REQUEST['token'];
		$dataid = intval($_REQUEST['dataid']);
		$type = intval($_REQUEST['type']);
		$store_id = intval($_REQUEST['store_id']);
		
		if (empty($dataid)) {
			
			$results['result']='1';
			$results['msg']='缺少最基本的参数';
			exit(json_encode($results));
		}
		
		if (!in_array($type, array(1, 2, 3, 4))) {
		
			$results['result']='1';
			$results['msg']='收藏类型错误';
			exit(json_encode($results));
		}
		
		if ($type == 1) {
			$data = D('Product')->where(array('product_id' => $dataid, 'status' => 1))->find();
			if (empty($data)) {
				$results['result']='1';
			$results['msg']='产品不存在';
			exit(json_encode($results));
			}
		} elseif ($type == 2) {
			$data = D('Store')->where(array('store_id' => $dataid, 'status' => 1))->find();
			if (empty($data)) {
			$results['result']='1';
			$results['msg']='店铺不存在';
			exit(json_encode($results));
			}
		} elseif ($type == 3) {
			$data = D('Chahui')->where(array('pigcms_id' => $dataid, 'status' => 1))->find();
			if (empty($data)) {
			$results['result']='1';
			$results['msg']='茶会不存在';
			exit(json_encode($results));
			}
		} elseif ($type == 4) {
			$data = D('Meal_cz')->where(array('cz_id' => $dataid))->find();
			if (empty($data)) {
			$results['result']='1';
			$results['msg']='包厢不存在';
			exit(json_encode($results));
			}
		}
		
		// 查看是否已经收藏过
		$user_collect = D('User_collect')->where(array('user_id' => $uid, 'type' => $type, 'dataid' => $dataid))->find();
		if (empty($user_collect)) {
		$results['msg']='取消收藏成功';
		exit(json_encode($results));
		}
	
		
		$result = M('User_collect')->cancel($uid, $dataid, $type, $store_id);
		
		if ($result) {
		
		$results['msg']='取消收藏成功';
		exit(json_encode($results));
		}
		
		$results['result']='1';
		$results['msg']='取消收藏失败';
		exit(json_encode($results));
	}
}
?>