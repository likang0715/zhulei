<?php
/**
 * 用户积分模型
 * User: pigcms-s
 * Date: 2015/09/15
 * Time: 13:38
 */

class user_points_record_model extends base_model {

	/*得到一个店铺的积分记录*/
	public function getStoreData($store_id, $limit="10",  $offset="0" , $where=array(), $orderby="") {
		if(empty($store_id)) return array();
		if($orderby) $this->db->order($orderby);
		if($limit) $this->db->limit($offset . ',' . $limit);
		$where2 = array('store_id'=>$store_id);
		$wheres = array_merge($where2, $where);
		
		
		$store_points_record = $this->db->where($wheres)->select();
		return $store_points_record;
	}
	
	/*得到一个买家的积分记录*/
	public function getUserData($uid, $limit="10", $offset="0", $where=array(), $orderby="") {
		if(empty($uid)) return array();
		if($orderby) $this->db->order($orderby);
		if($limit) $this->db->limit($offset . ',' . $limit);
		$where2 = array('uid'=>$uid);
		$wheres = array_merge($where2, $where);
	
	
		$buyer_points_record = $this->db->where($wheres)->select();
		return $buyer_points_record;
	}
		
	/*得到一个买家在一个指定店铺的积分记录*/
	public function getUserbyStoreData($uid,$store_id, $limit="10",  $offset="0", $where=array(), $orderby="") {
		if(empty($store_id)) return array();
		if($orderby) $this->db->order($orderby);
		if($limit) $this->db->limit($offset . ',' . $limit);
		$where2 = array('uid'=>$uid,'store_id'=>$store_id);
		$wheres = array_merge($where2, $where);
	
	
		$buyer_points_record = $this->db->where($wheres)->select();
		return $buyer_points_record;
	}
	
	/*获取单条积分记录*/
	public function getOne($where){
		$order = $this->db->where($where)->find();
	}
		
	
	//增加积分日志记录
	public function add($data) {
		$user_points_id = $this->db->data($data)->add();
		return $user_points_id;
	}
	
	
	//更新积分记录
/* 	public function changePoint($order_id,$store_id,$uid,$point) {
		if(empty($point)) {
			return false;
		}
		//$getOne = $this->getOne(array('order_id'=>$order_id,'store_id'=>$store_id,'uid'=>$uid));
		$condition = array('order_id'=>$order_id,'store_id'=>$store_id,'uid'=>$uid);
		$data = array();

		$data['point'] = $getOne['point'] + $point;		
		
		if($this->db->where($condition)->data($data)->save()){
			return array('err_code'=>0,'err_msg'=>'保存成功');
		}else{
			return array('err_code'=>1002,'err_msg'=>'保存失败');
		}
	
	} */
	
	
	/*
	 * @description: 更新积分可用状态
	 * @fanwei: 更改的范围： 0 代表全部， 1:关注我的微信；2:成功交易数量；3:购买金额达到多少,5:满减送送的积分 
	 * @is_available: 是否可以使用： (如：满减送 订单完成 ，更改)
	 */
	
	public function changePointStatus($order_id,	$store_id,	$uid, $fanwei="0",	$is_available='1') {
		
		if(empty($order_id) || empty($store_id) || empty($uid)) {
			return false;
		}
		$conditions = array();
		if($fanwei>0) {
			$conditions = array('type'=>$fanwei);
		}
		$condition = array('order_id'=>$order_id,'store_id'=>$store_id,'uid'=>$uid);
		$condition = array_merge($condition, $conditions);
		$data = array('is_available' => $is_available);
		if($this->db->where($condition)->data($data)->save()){
			return array('err_code'=>0,'err_msg'=>'保存成功');
		}else{
			return array('err_code'=>1002,'err_msg'=>'保存失败');
		}
	}
	
	
	//查询某个某个用户某个订单的可用的积分总和
	public function getUserPointByOneOrderAvailable($order_id, $userid) {
		
		//统计该订单全部可用的积分
		$points = $this->db->where("order_id = '".$order_id."' and uid = '".$userid."' and is_available=1")->sum('points');

		return $points;
	}
	
	
	//获取指定条件下的 积分记录总数
	public function getCount($where = array()) {
		if(!is_array($where)) return false;
		
		$counts = $this->db->where($where)->count("id");
	
		return $counts;
		
	}

	//
	public function getOrderPoint($where)
	{
		$points = $this->db->where($where)->sum('points');
		return !empty($points) ? $points : 0;
	}

}