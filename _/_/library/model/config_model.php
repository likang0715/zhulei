<?php
class config_model extends base_model{
	public function get_gid_config($gid){
		$condition_config['gid'] = $gid;
		$config = $this->db->where($condition_config)->select();
		
		return $config;
	}
    public function get_pay_method(){
		$tmp_config_list = $this->get_gid_config(7);
		foreach($tmp_config_list as $key=>$value){
			$payMethodList[$value['tab_id']]['name'] = $value['tab_name'];
			$payMethodList[$value['tab_id']]['type'] = $value['tab_id'];
			$payMethodList[$value['tab_id']]['config'][$value['name']] = $value['value'];
		}
		//剔除已关闭的支付
		foreach($payMethodList as $key=>$value){
			$pigcms_key = 'pay_'.$key.'_open';
			if(empty($value['config'][$pigcms_key])){
				unset($payMethodList[$key]);
			}
		}
                
                
		return $payMethodList;
	}
	
	public function getPlatformPayMethod($paynotice = false, $required_open = true) {
		// 通联
		$tmp_config_list = $this->get_gid_config(7);
		$pay_method_list = array();
		$type_arr = array('allinpay', 'platform_alipay', 'platform_weixin');
		
		foreach($tmp_config_list as $key => $config) {
			if (!$paynotice) {
				if (!in_array($config['tab_id'], $type_arr)) {
					continue;
				}
			}
				
			$pay_method_list[$config['tab_id']]['name'] = $config['tab_name'];
			$pay_method_list[$config['tab_id']]['type'] = $config['tab_id'];
			$pay_method_list[$config['tab_id']]['config'][$config['name']] = $config['value'];
		}
		
		$tmp_config_list = $this->get_gid_config(16);
		foreach($tmp_config_list as $key => $config) {
			if (!in_array($config['tab_id'], $type_arr)) {
				continue;
			}
			
			$pay_method_list[$config['tab_id']]['name'] = $config['tab_name'];
			$pay_method_list[$config['tab_id']]['type'] = $config['tab_id'];
			$pay_method_list[$config['tab_id']]['config'][$config['name']] = $config['value'];
		}

		if ($required_open) {
			//剔除已关闭的支付
			foreach($pay_method_list as $key => $value){
				$pigcms_key = 'pay_'.$key.'_open';
				$pigcms_key2 = $key . '_open';
				if(empty($value['config'][$pigcms_key]) && empty($value['config'][$pigcms_key2])){
					unset($pay_method_list[$key]);
				}
			}
		}
		
		return $pay_method_list;
	}
}