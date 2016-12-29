<?php
class user_points_by_store_model extends base_model{
	
	//
	//获取用户 在 店铺的积分数
	public function getpoints_by_storeid($uid,$store_id) {
		//获取的店铺积分 为： 供货商店铺积分
		$now_store = M('Store')->wap_getStore($store_id);
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
			'store_id' => $store_id	
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
			if($this->db->where('uid='.$uid.' and store_id='.$store_id)->setInc( 'points', $points )) {
				$return = true;
			}	
		} else {
			$data = array(
				'uid' => $uid,
				'store_id' => $store_id,
				'points' => $points			
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
	
	
	
	
	
}





