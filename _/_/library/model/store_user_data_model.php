<?php
class store_user_data_model extends base_model{
	/*得到一个用户的店铺数据*/
	public function getUserData($store_id,$uid){
		if(empty($store_id) || empty($uid)) return array();
		$store_user_data = $this->db->where(array('store_id'=>$store_id,'uid'=>$uid))->find();
		if(empty($store_user_data)) {
			$data_store_user_data['store_id'] = $store_id;
			$data_store_user_data['uid'] 	  = $uid;
			$data_store_user_data['degree_date'] = date('Ymd', strtotime('+1 year'));
			$data_store_user_data['last_time'] = time();
			$data_store_user_data['add_time'] = time();
			if($this->db->data($data_store_user_data)->add()){
				return $this->getUserData($store_id,$uid);
			}else{
				return array();
			}
		} else {
			if(date('Ymd', $store_user_data['last_time']) < date('Ymd')) {
				$this->updateData($store_id, $uid);
			}

			//获取的店铺积分 为： 供货商店铺积分
			$store = M('Store')->getStore($store_id);
			if (!empty($store['drp_supplier_id'])) {
				//顶级供货商店铺id
				$store_supplier = M('Store_supplier')->getSeller(array('seller_id'=> $store_id, 'type'=>'1'));
				
				if($store_supplier['supply_chain']){
					$seller_store_id_arr = explode(',' , $store_supplier['supply_chain']);
					$store_id = $seller_store_id_arr[1];
					$store = M('Store')->getStore($store_id);
				}
				
				$supplier_store_user_data = $this->getUserData($store_id, $uid);
				
				$store_user_data['point'] = $supplier_store_user_data['point'];
				$store_user_data['point_count'] = $supplier_store_user_data['point_count'];
				$store_user_data['store_point'] = $supplier_store_user_data['store_point'];
				$store_user_data['store_point_count'] = $supplier_store_user_data['store_point_count'];
				$store_user_data['sign_days'] = $supplier_store_user_data['sign_days'];
				$store_user_data['sign_date'] = $supplier_store_user_data['sign_date'];
				$store_user_data['degree_id'] = $supplier_store_user_data['degree_id'];
				$store_user_data['degree_date'] = $supplier_store_user_data['degree_date'];
				$store_user_data['degree_update_date'] = $supplier_store_user_data['degree_update_date'];
			}

			if ($store['degree_exchange_type'] == 2) {
				// 自动更等级，当等级到期后，自动更新等级，可以降级，如果等级未到期，等级只升不降
				if ($store_user_data['degree_date'] < date('Ymd')) {
					$user_degree = D('User_degree')->where(array('store_id' => $store_id, 'points_limit' => array('<=', $store_user_data['point'])))->order("points_limit desc")->find();
					$month = 12;
					if ($user_degree['degree_month']) {
						$month = $user_degree['degree_month'];
					}
					$data = array();
					$data['degree_date'] = date('Ymd', strtotime('+' . $month . ' month'));
					$data['degree_update_date'] = date('Ymd');
					
					if (!empty($user_degree['id'])) {
						$data['degree_id'] = $user_degree['id'];
						$store_user_data['degree_id'] = $user_degree['id'];
					} else {
						$data['degree_id'] = 0;
						$store_user_data['degree_id'] = 0;
					}
					$this->db->where(array('store_id' => $store_id, 'uid' => $uid))->data($data)->save();
					$store_user_data['degree_date'] = $data['degree_date'];
				} else if ($store_user_data['degree_update_date'] < date('Ymd')) {
					$user_degree = D('User_degree')->where(array('store_id' => $store_id, 'points_limit' => array('<=', $store_user_data['point'])))->order("points_limit desc")->find();
					$user_degree_current = D('User_degree')->where(array('store_id' => $store_id, 'id' => $store_user_data['degree_id']))->find();
					
					$data = array();
					if ($user_degree['level_num'] > $user_degree_current['level_num']) {
						$month = 12;
						if ($user_degree['degree_month']) {
							$month = $user_degree['degree_month'];
						}
						
						$data['degree_date'] = date('Ymd', strtotime('+' . $month . '月'));
						$data['degree_id'] = $user_degree['id'];
						
						$store_user_data['degree_id'] = $user_degree['id'];
						$store_user_data['degree_date'] = $data['degree_date'];
					}
					
					$data['degree_update_date'] = date('Ymd');
					$this->db->where(array('store_id' => $store_id, 'uid' => $uid))->data($data)->save();
				}
			} else if ($store['degree_exchange_type'] == 1 && $store_user_data['degree_date'] < date('Ymd')) {
				// 到期不升级，自动变为0
				$store_user_data['degree_id'] = 0;
				$store_user_data['degree_date'] = date('Ymd');
			}
			
			// 此刻等级及会员图标
			if (empty($store_user_data['degree_id'])) {
				$store_user_data['degree_name'] = '默认等级';
				$store_user_data['degree_logo'] = '';
			} else {
				$user_degree = D('User_degree')->where(array('id' => $store_user_data['degree_id']))->find();
				
				if (empty($user_degree)) {
					$store_user_data['degree_name'] = '默认等级';
					$store_user_data['degree_logo'] = '';
				} else {
					$store_user_data['degree_name'] = $user_degree['name'];
					
					if(preg_match('/^images\//', $user_degree['level_pic'])) {
						$store_user_data['degree_logo'] = getAttachmentUrl($user_degree['level_pic']);
					} else {
						$store_user_data['degree_logo'] = option('config.site_url') . '/' . $user_degree['level_pic'];
					}
				}
			}

			return $store_user_data;
		}
	}
	
	
	/*检测是否需要更新数据*/
	private function _checkUpdate($store_id,$uid) {

		$store_user_info = $this->db->where(array('store_id'=>$store_id, 'uid'=>$uid))->find();
		
		//每7天更新一次统计表
		if(($store_user_info['last_time'] ) < time()) {
			$this->updateData($store_id,$uid);
		}
	}

	/**
	 * 统计用户对应店铺的数据，并更新到表中
	 * @param $store_id
	 * @param $uid
	 * @param bool|false $no_exist_add 如果不存在是否新增
	 * @return array
	 */
	public function updateData($store_id, $uid, $no_exist_add = false) {

		$userData = $this->db->where(array('store_id'=>$store_id, 'uid'=>$uid))->find();
		if (empty($userData)) {
			if (empty($no_exist_add)) {
				return array('err_code'=>1000,'err_msg'=>'没得到数据');
			} else {
				$last_id = $this->db->data(array('store_id' => $store_id, 'uid' => $uid, 'last_time' => time(), 'add_time' => time()))->add();
				if (!empty($last_id)) {
					$userData = $this->db->where(array('pigcms_id' => $last_id))->find();
				} else {
					return array('err_code'=>1000,'err_msg'=>'没得到数据');
				}
			}
		}

		$database_order = D('Order');
		$condition_order['store_id'] = $condition_save_order['store_id'] = $store_id;
		$condition_order['uid'] = $condition_save_order['uid'] = $uid;
		$condition_order['user_order_id'] = 0;
		
		//未付款
		$condition_order['status'] = '1';
		$data_save_order['order_unpay'] = $database_order->where($condition_order)->count('`order_id`');
		//未发货
		$condition_order['status'] = '2';
		$data_save_order['order_unsend'] = $database_order->where($condition_order)->count('`order_id`');
		//已发货 
		$condition_order['status'] = '3';
		$data_save_order['order_send'] = $database_order->where($condition_order)->count('`order_id`');
		//已完成
		$condition_order['status'] = array('in',array('4','7'));
		$data_save_order['order_complete'] = $database_order->where($condition_order)->count('`order_id`');
		
		$data_save_order['last_time'] = $_SERVER['REQUEST_TIME'];
		if(D('Store_user_data')->where($condition_save_order)->data($data_save_order)->save()){
			
			return array('err_code'=>0,'err_msg'=>'更新成功');
		}else{
			return array('err_code'=>0,'err_msg'=>'更新失败');
		}
	}

    public function updateData2($store_id,$uid){
        $userData = $this->getUserData($store_id,$uid);
        if(empty($userData)){
            return array('err_code'=>1000,'err_msg'=>'没得到数据');
        }
        $database_order = D('Order');
        $condition_order['store_id'] = $store_id;
        $condition_order['uid'] = $uid;
        //未付款
        $condition_order['status'] = '1';
        $data_save_order['order_unpay'] = $database_order->where($condition_order)->count('`order_id`');
        //未发货
        $condition_order['status'] = '2';
        $data_save_order['order_unsend'] = $database_order->where($condition_order)->count('`order_id`');
        //已发货
        $condition_order['status'] = '3';
        $data_save_order['order_send'] = $database_order->where($condition_order)->count('`order_id`');
        //已完成
        // $condition_order['status'] = '4';
		$condition_order['status'] = array('in',array('4','7'));
        $data_save_order['order_complete'] = $database_order->where($condition_order)->count('`order_id`');
        $condition_order = array();
        $condition_order['store_id'] = $store_id;
        $condition_order['uid'] = $uid;
        $data_save_order['last_time'] = $_SERVER['REQUEST_TIME'];
        if(D('Store_user_data')->where($condition_order)->data($data_save_order)->save()){
            return array('err_code'=>0,'err_msg'=>'更新成功');
        }else{
            return array('err_code'=>0,'err_msg'=>'更新失败');
        }
    }

	public function upUserData($store_id,$uid,$type, $value = 1){
		$userData = $this->getUserData($store_id,$uid);
		if(empty($userData)){
			return array('err_code'=>1000,'err_msg'=>'没得到数据');
		}
		$condition['pigcms_id'] = $userData['pigcms_id'];
		switch($type){
			case 'unpay':
				$data['order_unpay'] 	= $userData['order_unpay']+1;
				break;
			case 'unsend':
				if($userData['order_unpay']>0) $data['order_unpay']   = $userData['order_unpay']-1;
				$data['order_unsend'] 	= $userData['order_unsend']+1;
				break;
			case 'send':
				if($userData['order_unsend']>0) $data['order_unsend'] = $userData['order_unsend']-1;
				$data['order_send'] 	= $userData['order_send']+1;
				break;
			case 'complete':
				if($userData['order_send']>0) $data['order_send']     = $userData['order_send']-1;
				$data['order_complete'] = $userData['order_complete']+1;
				break;
			case 'point':
				$data['point'] = $userData['point'] + $value;
				break;
			case 'money':
				$data['money'] = $userData['money'] + $value;
				break;
			default:
				return array('err_code'=>1001,'err_msg'=>'非法数据');
		}
		
		$data['last_time'] = $_SERVER['REQUEST_TIME'];
		if($this->db->where($condition)->data($data)->save()){
			return array('err_code'=>0,'err_msg'=>'保存成功');
		}else{
			return array('err_code'=>1002,'err_msg'=>'保存失败');
		}
	}
	public function editUserData($store_id,$uid,$mintype,$plustype=''){
		$userData = $this->getUserData($store_id,$uid);
		if(empty($userData)){
			return array('err_code'=>1000,'err_msg'=>'没得到数据');
		}
		$condition['pigcms_id'] = $userData['pigcms_id'];
		switch($mintype){
			case 'unpay':
				if($userData['order_unpay']>0) $data['order_unpay'] 	= $userData['order_unpay']-1;
				break;
			case 'unsend':
				if($userData['order_unsend']>0) $data['order_unsend']   = $userData['order_unsend']-1;
				break;
			case 'send':
				if($userData['order_send']>0) $data['order_send']   = $userData['order_send']-1;
				break;
			case 'complete':
				if($userData['order_complete']>0) $data['order_complete']   = $userData['order_complete']-1;
				break;
			default:
				return array('err_code'=>1001,'err_msg'=>'非法数据');
		}
		switch($plustype){
			case 'unpay':
				$data['order_unpay'] 	= $userData['order_unpay']+1;
				break;
			case 'unsend':
				$data['order_unsend'] 	= $userData['order_unsend']+1;
				break;
			case 'send':
				$data['order_send'] 	= $userData['order_send']+1;
				break;
			case 'complete':
				$data['order_complete'] = $userData['order_complete']+1;
				break;
		}
		if($this->db->where($condition)->data($data)->save()){
			return array('err_code'=>0,'err_msg'=>'保存成功');
		}else{
			return array('err_code'=>1002,'err_msg'=>'保存失败');
		}
	}

	/**
	 * @param $store_id
	 * @param $uid
	 * @param $point
	 * @param bool|false $is_fx
	 * @param bool|true $sync_degree 是否同步用户等级
	 * @return array|void
	 */
	public function changePoint($store_id, $uid, $point, $is_fx = false, $sync_degree = true) {
		if (empty($point) || empty($store_id) || empty($uid)) {
			return;
		}

		$userData = $this->getUserData($store_id, $uid);
		if(empty($userData)){
			return array('err_code'=>1000,'err_msg'=>'没得到数据');
		}

		$condition['pigcms_id'] = $userData['pigcms_id'];
		$data = array();
		$data['point'] = $userData['point'] + $point;
		$data['point_count'] = $userData['point_count'] + $point;
		if ($is_fx) {
			$data['store_point'] = $userData['store_point'] + $point;
			$data['store_point_count'] = $userData['store_point_count'] + $point;
		}
		$data['degree_update_date'] = 0;
		if($this->db->where($condition)->data($data)->save()){
			$this->getUserData($store_id, $uid);
			return array('err_code'=>0,'err_msg'=>'保存成功');
		}else{
			return array('err_code'=>1002,'err_msg'=>'保存失败');
		}
	}
	
	// 增加店铺积分
	public function changeStorePoint($store_id, $uid, $point, $sync_degree = true) {
		if (empty($point) || empty($store_id) || empty($uid)) {
			return;
		}

		import('source.class.Points');

		$store_user_data = $this->getUserData($store_id, $uid);
		if(empty($store_user_data)){
			return array('err_code'=>1000,'err_msg'=>'没得到数据');
		}
		
		$condition['pigcms_id'] = $store_user_data['pigcms_id'];
		$data = array();
		$data['store_point'] = $store_user_data['store_point'] + $point;
		if ($point > 0) {
			$data['store_point_count'] = $store_user_data['store_point_count'] + $point;
		}
	
		if($this->db->where($condition)->data($data)->save()){
			if ($sync_degree) {
				//店铺积分有变动同步分销商等级
				Points::drpDegree($store_id, true, $uid);
			}
			return array('err_code'=>0,'err_msg'=>'保存成功');
		}else{
			return array('err_code'=>1002,'err_msg'=>'保存失败');
		}
	}
	
	
	//获取用户 在 店铺的积分数
	public function getpoints_by_storeid($uid,$store_id) {
		//获取的店铺积分 为： 供货商店铺积分
		$now_store = M('Store')->getStore($store_id);
		if($now_store['drp_supplier_id']!='0') {
			//顶级供货商店铺id
			$store_supplier = M('Store_supplier')->getSeller(array( 'seller_id'=> $store_id, 'type'=>'1' ));
			
			if($store_supplier['supply_chain']){
				$seller_store_id_arr = explode(',',$store_supplier['supply_chain']);
				$store_id = $seller_store_id_arr[1];
				//$now_store = M('Store')->wap_getStore($store_id);
			}
		}		
		
		$where = array(
			'uid' => $uid,			
			'store_id' => $store_id		//理论上是顶级供货商id
		);
		
		
		$return = $this->db->where($where)->find();
		return $return;
		
	}	
	
	
	//更新买家 在店铺的积分
	public function updatePoints($uid, $store_id,$order_id) {
		$return = false;
		//统计该订单全部可用的积分
		$points = M('User_points_record')->getUserPointByOneOrderAvailable($order_id, $uid);

		$where = array(
			'uid' => $uid,
			'store_id' => $store_id,
		);
		
		$user_point_old = $this->db->where($where)->find();
		if($user_point_old) {
			if($this->db->where('uid='.$uid.' and store_id='.$store_id)->setInc( 'point', $points )) {
				$return = true;
			}	
		} else {
			$data = array(
				'uid' => $uid,
				'store_id' => $store_id,
				'point' => $points			
			);
			if($this->db->data($data)->add()){
				$return = true;
			}
		}

		if($return) {
			return array('err_code' => 0,'err_msg' => '用户积分更新成功');
		} else {
			return array('err_code' => 1,'err_msg' => '用户积分更新失败');
		}		
		
	} 
	
	// 获取用户连继签到天数
	public function getUserSignDay($store_id, $uid) {
		$store_user_data = $this->getUserData($store_id, $uid);
		
		if ($store_user_data['sign_days'] == 0) {
			return 0;
		}
		
		if ($store_user_data['sign_date'] == date('Ymd', strtotime('-1 day'))) {
			return $store_user_data['sign_days'];
		} else if ($store_user_data['sign_date'] < date('Ymd', strtotime('-1 day'))) {
			return 0;
		} else {
			return false;
		}
	}
	
	// 更改用户连续签到天数
	public function setUserSignDay($store_id, $uid) {
		$store_user_data = $this->getUserData($store_id, $uid);
		
		$data = array();
		if ($store_user_data['sign_days'] == 0) {
			$data['sign_days'] = 1;
			$data['sign_date'] = date('Ymd');
		}
		
		if ($store_user_data['sign_date'] == date('Ymd', strtotime('-1 day'))) {
			$data['sign_days'] = $store_user_data['sign_days'] + 1;
			$data['sign_date'] = date('Ymd');
		}
		
		if ($store_user_data['sign_date'] < date('Ymd', strtotime('-1 day'))) {
			$data['sign_days'] = 1;
			$data['sign_date'] = date('Ymd');
		}
		
		if (!empty($data)) {
			$this->db->where(array('store_id' => $store_id, 'uid' => $uid))->data($data)->save();
			return;
		}
	}

	// 获取店铺会员
	public function getMembers($where, $offset, $limit, $order_by = 'pigcms_id DESC')
	{
		if (empty($where['store_id'])) {
			return array('err_code' => 1001, 'err_msg' => '未指定店铺');
		}
		$members = $this->db->where($where)->order($order_by)->limit($offset . ',' . $limit)->select();
		return !empty($members) ? $members : array();
	}

	// 获取店铺会员数
	public function getMemberCount($where)
	{
		if (empty($where['store_id'])) {
			return array('err_code' => 1001, 'err_msg' => '未指定店铺');
		}
		$members = $this->db->where($where)->count('pigcms_id');
		return !empty($members) ? $members : 0;
	}
}
?>