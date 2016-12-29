<?php

/**
 * 店铺模型
 * User: pigcms-s
 * Date: 2015/07/03
 * Time: 14:02
 */
class store_contact_model extends base_model {
	// 根据store_id返回店铺的联系信息
	public function get($store_id) {
		$store_contact = $this->db->where(array('store_id' => $store_id))->find();
		if (!empty($store_contact)) {
			import('area');
			$areaClass = new area();
			$store_contact['province_txt'] = $areaClass->get_name($store_contact['province']);
			$store_contact['city_txt'] 	= $areaClass->get_name($store_contact['city']);
			$store_contact['county_txt'] 	= $areaClass->get_name($store_contact['county']);
		}
		
		return $store_contact;
	}
	

	//根据坐标获取离你最近的商铺
	function nearshops($long, $lat, $limit = "") {
		$limit = $limit ? $limit : '12';
		
		$where = "`sc`.`store_id`=`s`.`store_id` AND `s`.`status`='1' and `s`.`public_display`='1' and `s`.`is_point_mall`='0'";
		$field = "`s`.`qcode`,`s`.`store_id`, `s`.`name`, `s`.`logo`, `s`.`intro`,`sc`.`long`,`sc`.`lat`, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli";
		$WebUserInfo = show_distance();
		if($WebUserInfo['long']) {
			if(option('config.lbs_distance_limit')) {
				$where = $where ." HAVING juli <=".option('config.lbs_distance_limit')*1000;
			} 
		} else {
			if($WebUserInfo['city_name']) {
				$where = $where . " sc.city='".$WebUserInfo['city_code']."'";
			}
		}
		$near_store_list = $this->db->table("Store_contact sc")
								 ->join("Store s On s.store_id=sc.store_id","LEFT")
								  ->where($where)
								  ->field($field)
								  ->order("`juli` ASC")
								  ->limit($limit)
								  ->select();		
		//echo $this->db->last_sql;					  
		foreach ($near_store_list as $key => $value) {
			$value['url'] = option('config.wap_site_url') . '/home.php?id=' . $value['store_id'] . '&platform=1';
			$value['pcurl'] = url_rewrite('store:index', array('id' => $value['store_id']));

			if (empty($value['logo'])) {
				$value['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
			} else {
				$value['logo'] = getAttachmentUrl($value['logo']);
			}
			//本地化二维码$near_store_list[$key]['qcode']  = $value['qcode'] ?  getAttachmentUrl($value['qcode']) : option('config.site_url')."/source/qrcode.php?type=home&id=".$value['store_id'];
			$near_store_list[$key]['qcode']  = $value['qcode'] ?  $value['qcode'] : option('config.site_url')."/source/qrcode.php?type=home&id=".$value['store_id'];	//微信端临时二维码
			$near_store_list[$key]['logo'] = $value['logo'];
			$near_store_list[$key]['url'] = $value['url'];
			$near_store_list[$key]['pcurl'] = $value['pcurl'];
		}
		return $near_store_list;
	}

	//获取商品坐标数据
	public function get_store_contact_info($store_id_list) {
		if (!$store_id_list) {
			return false;
		}
		$where['store_id'] = array('in', $store_id_list);
		$list = D('Store_contact')->where($where)->field("`store_id`,`long`,`lat`,`city`")->select();

		if (!$list) {
			return false;
		}

		import('area');
		$areaClass = new area();
		
		$list_arr = array();

		foreach ($list as $k => $v) {
			$v['city_txt'] = $areaClass->get_name($v['city']);
			$list_arr[$v['store_id']] = $v;
		}
		
		return $list_arr;
	}
	

	//

	//距离排序处理
	/*
	public function store_contact_distance($long, $lat, $list) {
		if (!$long || !$lat || !$list) {
			return false;
		}

		$store_arr = array();
		foreach ($list as $v) {
			$store_arr[] = $v['store_id'];
		}
		$where = '`s`.`store_id` IN(' . implode(',', $store_arr) . ')';

		$near_store_list = D('')->table(array('Store_contact' => 'sc', 'Store' => 's'))->field("`s`.`store_id`, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli")->where($where)->order("`juli` ASC")->select();
		$distance_arr = array();
		foreach ($near_store_list as $v) {
			foreach ($list as $val) {
				if ($val['store_id'] == $v['store_id']) {
					array_push($distance_arr, $val);
				}
			}
		}
		
		return $distance_arr;
	}
	 * */

	// 获取店铺联系信息，并按store_id数据返回数据
	public function storeContactList($store_id_arr) {
		if (empty($store_id_arr) || !is_array($store_id_arr)) {
			return array();
		}
		
		$store_contact_list = D('')->table(array('Store' => 's', 'Store_contact' => 'sc'))->where("`s`.`store_id` IN (" . join(',', $store_id_arr) . ") AND `s`.`store_id` = `sc`.`store_id`")->field('sc.*, s.name,s.buyer_selffetch_name')->select();
		
		import('area');
		$areaClass = new area();
		$return_data = array();
		foreach ($store_contact_list as $value) {
			$value['province_txt'] = $areaClass->get_name($value['province']);
			$value['city_txt'] = $areaClass->get_name($value['city']);
			$value['county_txt'] = $areaClass->get_name($value['county']);
			$value['logo'] = getAttachmentUrl($value['logo']);
			$return_data[$value['store_id']] = $value;
		}
		
		return $return_data;
	}

	// 添加区域关系 用于区域管理员关联
	public function setAreaRelation ($store_id = 0, $data = array()) {

		if (empty($store_id) || empty($data) || empty($data['province']) || empty($data['city']) || empty($data['county'])) {
			return false;
		}

		$store_contact = D('Store_contact')->where(array('store_id'=>$store_id))->find();
		if (!empty($store_contact) && ($store_contact['province'] == $data['province']) && ($store_contact['city'] == $data['city']) && ($store_contact['county'] == $data['county'])) {
			return false;
		}

		$area_data = array(
				'store_id' => $store_id,
				'province' => $data['province'],
				'city' => $data['city'],
				'county' => $data['county'],
				'add_time' => time(),
			);

		$area_record = D('Store_area_record')->where(array('store_id'=>$store_id))->find();
		if (empty($area_record)) {
			$area_data['status'] = 1;
		}

		if (D('Store_area_record')->data($area_data)->add()) {
			return true;
		}

		return false;

	}

}