<?php

/**
 * 店铺通知/短信 权限管理
 * User: pigcms-s
 * Date: 2015/11/27
 * Time: 17:44
 */
class Store_notice_manage_model extends base_model {
	

	// 根据store_id返回店铺拥有的权限信息
	public function get($store_id) {
		
		$power_info = $this->db->where(array('store_id' => $store_id))->find();
		
		if($power_info['has_power']) {
			$has_power_arr = explode( "|", $power_info['has_power']);
			if(count($has_power_arr)) {
				foreach($has_power_arr as $k=>$v) {
					$has_power_arr1 = explode("^",$v);
					$has_powers = explode(",",$has_power_arr1[1]);
					$arr[$has_power_arr1[0]] = $has_powers;
					$arr[$has_power_arr1[0]]['qx_list'] = $has_power_arr1[1];
				}
			}
		}
		$power_info['has_power_arr'] = $arr;
		return $power_info;
	}
	

	
	//[系统]根据模板id 或 编号  获取是否拥有权限
	public function getStorePowerByTpl($store_id,$tpl_no) {
		if(empty($store_id) || empty($tpl_no)) {
			return false;
		}
		$array = array('allow_mobile_msg'=>0,'allow_weixin_msg'=>0);
		//检查微信模板是否开启
		$store_wx_info = M('Weixin_bind')->getByStoreid($store_id);
		if($store_wx_info['authorizer_appid']) {
			$token = $store_wx_info['authorizer_appid'];
		}
		
		$tempmsg_info = D('Tempmsg')->where(array( 'token' => $token, 'tempkey'=>$tpl_no,'status'=>1))->find();
		if($tempmsg_info['status'] == '1') {
			$store_had_power = $this->get($store_id);
			if($store_had_power['has_power_arr'][$tempmsg_info['id']]){
				$store_power_detail = $store_had_power['has_power_arr'][$tempmsg_info['id']];
				if(in_array(1,$store_power_detail)){
					//拥有短信权限
					$array['allow_mobile_msg'] = 1;
				}
	
				if(in_array(2,$store_power_detail)){
					//拥有微信模板消息权限
					$array['allow_weixin_msg'] = 1;
				}
			}
		}
		return $array;
	}
	
		
}