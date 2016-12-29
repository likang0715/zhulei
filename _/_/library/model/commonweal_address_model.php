<?php
class commonweal_address_model extends base_model{
	/*查找一条记录*/
	public function find($store_id){
		$condition['store_id'] = $store_id;
		
		$address = $this->db->where($condition)->order('`default` DESC,`id` ASC')->find(); 
		if(!empty($address)){
			import('area');
			$areaClass = new area();
			$address['province_txt'] = $areaClass->get_name($address['province']);
			$address['city_txt'] 	= $areaClass->get_name($address['city']);
			$address['area_txt'] 	= $areaClass->get_name($address['area']);
		}
		return $address;
	}
	
	/*查找一条记录*/
	public function getAdressById($store_id, $address_id){
		$condition['store_id'] = $store_id;
		$condition['id'] = $address_id;
		$address = $this->db->where($condition)->find(); 
		if(!empty($address)){
			import('area');
			$areaClass = new area();
			$address['province_txt'] = $areaClass->get_name($address['province']);
			$address['city_txt'] 	= $areaClass->get_name($address['city']);
			$address['area_txt'] 	= $areaClass->get_name($address['area']);
		}
		return $address;
	}
	
	/*查找用户记录*/
	public function select($store_id){
		$commonweal_address_list = $this->db->where(array('store_id' => $store_id))->field('*, id as address_id')->order('`default` DESC, `id` ASC')->select();
		if(!empty($commonweal_address_list)){
			import('area');
			$areaClass = new area();
			foreach($commonweal_address_list as &$value){
				$value['province_txt'] = $areaClass->get_name($value['province']);
				$value['city_txt'] 	= $areaClass->get_name($value['city']);
				$value['area_txt'] 	= $areaClass->get_name($value['area']);
			}	
		}
		return $commonweal_address_list;
	}


	/* 微信 所有省份 用于会员地域统计 */
	public function get_province () {
		$province = array('广东省', '青海省', '四川省', '海南省', '陕西省', '甘肃省', '云南省', '湖南省', '湖北省', '黑龙江省', '贵州省', '山东省', '江西省', '河南省', '河北省', '山西省', '安徽省', '福建省', '浙江省', '江苏省', '吉林省', '辽宁省', '台湾省', '新疆维吾尔自治区', '广西壮族自治区', '宁夏回族自治区', '内蒙古自治区', '西藏自治区', '北京市', '天津市', '上海市', '重庆市', '香港', '澳门');
		return $province;
	}
}
?>