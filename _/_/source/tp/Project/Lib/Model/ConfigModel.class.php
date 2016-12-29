<?php
class ConfigModel extends Model{
	public function get_config(){
		$config = S('config');
		if(empty($config)){
			$configs = $this->field('`name`,`value`')->select();
			foreach($configs as $key=>$value){
				$config[$value['name']] = $value['value'];
			}
			$domain_array = parse_url($config['site_url']);
			$config['top_domain'] = $this->get_domain($domain_array['host']);
			S('config',$config);
		}
		return $config;
	}
	public function get_gid_config($gid){
		$condition_config['gid'] = $gid;
		$config = $this->field(true)->where($condition_config)->select();
		
		return $config;
	}
	protected function get_domain($host){
		$host = strtolower($host);
		$two_suffix = array('.com.cn','.gov.cn','.net.cn','.org.cn','.ac.cn');
		foreach($two_suffix as $key=>$value){
			preg_match('#(.*?)'.$value.'$#',$host,$match_arr);
			if(!empty($match_arr)){
				$match_array = $match_arr;
				break;
			}
		}
		$host_arr = explode('.',$host);
		if(!empty($match_array)){
			$host_arr_last1 = array_pop($host_arr);
			$host_arr_last2 = array_pop($host_arr);
			$host_arr_last3 = array_pop($host_arr);
			
			return $host_arr_last3.'.'.$host_arr_last2.'.'.$host_arr_last1;
		}else{
			$host_arr_last1 = array_pop($host_arr);
			$host_arr_last2 = array_pop($host_arr);
			return $host_arr_last2.'.'.$host_arr_last1;
		}
	}
	public function get_pay_method($is_wap = false, $all = false){
		$tmp_config_list = $this->get_gid_config(7);
		
		foreach($tmp_config_list as $key=>$value){
			$config_list[$value['tab_id']]['name'] = $value['tab_name'];
			$config_list[$value['tab_id']]['config'][$value['name']] = $value['value'];
		}
		if (empty($all)) {
			//剔除已关闭的支付
			foreach($config_list as $key=>$value){
				$pigcms_key = 'pay_'.$key.'_open';
				if(empty($value['config'][$pigcms_key]) || ($is_wap && $key == 'chinabank')){
					unset($config_list[$key]);
				}
			}
		}
		return $config_list;
	}

	public function get_margin_payment($paynotice)
	{
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

		//剔除已关闭的支付
		/*foreach($pay_method_list as $key => $value){
			$pigcms_key = 'pay_'.$key.'_open';
			$pigcms_key2 = $key . '_open';
			if(empty($value['config'][$pigcms_key]) && empty($value['config'][$pigcms_key2])){
				unset($pay_method_list[$key]);
			}
		}*/

		return $pay_method_list;
	}
}
?>