<?php
/**
 * 收藏控制器
 */
class collect_controller extends base_controller{
	// 添加收藏
	public function add() {
		$uid = $this->user['uid'];
		
		$dataid = intval($_REQUEST['dataid']);
		$type = intval($_REQUEST['type']);
		$store_id = intval($_REQUEST['store_id']);
		
		if (empty($dataid)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		if (!in_array($type, array(1, 2, 3))) {
			json_return(1000, '收藏类型错误');
		}
		
		if ($type == 1) {
			$data = D('Product')->where(array('product_id' => $dataid, 'status' => 1))->find();
			if (empty($data)) {
				json_return(1000, '产品不存在');
			}
		} else {
			$data = D('Store')->where(array('store_id' => $dataid, 'status' => 1))->find();
			if (empty($data)) {
				json_return(1000, '店铺不存在');
			}
		}
		
		// 查看是否已经收藏过
		$user_collect = D('User_collect')->where(array('user_id' => $uid, 'type' => $type, 'dataid' => $dataid,'store_id' => $store_id))->find();
		if (!empty($user_collect)) {
			json_return(1000, '已经收藏过了');
		}
		
		$result = M('User_collect')->add($uid, $dataid, $type, $store_id);
		if ($result) {
			json_return(0, '收藏成功');
		}
		
		json_return(1000, '收藏失败');
	}
	
	// 取消收藏
	public function cancel() {
		$uid = $this->user['uid'];
		
		$dataid = intval($_REQUEST['dataid']);
		$type = intval($_REQUEST['type']);
		$store_id = intval($_REQUEST['store_id']);
		
		if (empty($dataid)) {
			json_return(1000, '缺少最基本的参数');
		}
		
		if (!in_array($type, array(1, 2, 3))) {
			json_return(1000, '收藏类型错误');
		}
		
		if ($type == 1) {
			$data = D('Product')->where(array('product_id' => $dataid, 'status' => 1))->find();
			if (empty($data)) {
				json_return(1000, '产品不存在');
			}
		} else {
			$data = D('Store')->where(array('store_id' => $dataid, 'status' => 1))->find();
			if (empty($data)) {
				json_return(1000, '店铺不存在');
			}
		}
		
		// 查看是否已经收藏过
		$user_collect = D('User_collect')->where(array('user_id' => $uid, 'type' => $type, 'dataid' => $dataid, 'store_id' => $store_id))->find();
		if (empty($user_collect)) {
			json_return(0, '取消收藏成功');
		}
		
		$result = M('User_collect')->cancel($uid, $dataid, $type, $store_id);
		if ($result) {
			json_return(0, '取消收藏成功');
		}
		
		json_return(1000, '取消收藏失败');
	}
}
?>