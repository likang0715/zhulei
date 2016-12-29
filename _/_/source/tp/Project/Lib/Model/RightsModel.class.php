<?php
/**
 * 维权model
*/
class RightsModel extends Model{
	/**
	 * 统计维权数量
	 */
	public function getCount($where = 0) {
		return $this->where($where)->count('id');
	}
	/**
	 * 维权列表
	 */
	public function getList($where = '', $limit = 0, $offset = 0) {
		if (empty($where)) {
			return array();
		}
		
		$db_prefix = C('DB_PREFIX');
		
		$this->table($db_prefix . 'rights as r');
		$this->join($db_prefix . 'rights_product as rp on r.id = rp.rights_id', 'left');
		$this->join($db_prefix . 'product as p on rp.product_id = p.product_id', 'left');
		$this->join($db_prefix . 'user as u on r.uid = u.uid', 'left');
		$this->join($db_prefix . 'store as s on s.store_id = r.store_id', 'left');
		$this->where($where);
		$this->field('r.*, s.name as store_name, s.tel as store_tel, s.linkman, rp.rights_id, rp.order_product_id, rp.product_id, rp.sku_id, rp.sku_data, rp.pro_num, rp.pro_price, rp.supplier_id, rp.original_product_id, p.image, p.name, u.nickname, u.phone');
		$this->order('r.status asc, r.id DESC');
		if (!empty($limit)) {
			$this->limit($offset . ',' . $limit);
		}
		$return_list = $this->select();

		foreach ($return_list as &$value) {
			$value['image'] = getAttachmentUrl($value['image']);
			$value['type_txt'] = $this->rightsType($value['type']);
			$value['status_txt'] = $this->rightsStatus($value['status']);
			$tmp_images = unserialize($value['images']);
			if (is_array($tmp_images)) {
				foreach ($tmp_images as &$tmp_image) {
					$tmp_image = getAttachmentUrl($tmp_image);
				}

				$value['images'] = $tmp_images;
			}
		}

		return $return_list;
	}

	/**
	 * 获取单个维权
	 */
	public function getById($id = 0) {
		if (empty($id)) {
			return array();
		}
		
		$db_prefix = C('DB_PREFIX');
		$this->table($db_prefix . 'rights as r');
		$this->join($db_prefix . 'rights_product as rp on r.id = rp.rights_id', 'left');
		$this->join($db_prefix . 'product as p on rp.product_id = p.product_id', 'left');
		$this->join($db_prefix . 'user as u on r.uid = u.uid', 'left');
		$this->where("r.id = '" . $id . "'");
		$this->field('r.*, rp.rights_id, rp.order_product_id, rp.product_id, rp.sku_id, rp.sku_data, rp.pro_num, rp.pro_price, rp.supplier_id, rp.original_product_id, p.image, p.name, u.nickname');

		$rights = $this->find();

		if (empty($rights)) {
			return array();
		}

		$rights['image'] = getAttachmentUrl($rights['image']);
		$rights['type_txt'] = $this->rightsType($rights['type']);
		$rights['status_txt'] = $this->rightsStatus($rights['status']);
		$tmp_images = unserialize($rights['images']);

		if (is_array($tmp_images)) {
			foreach ($tmp_images as &$tmp_image) {
				$tmp_image = getAttachmentUrl($tmp_image);
			}

			$rights['images'] = $tmp_images;
		}

		if ($rights['address']) {
			$address = unserialize($rights['address']);
			import('area');
			$areaClass = new area();
			$rights['province_txt'] = $areaClass->get_name($address['province_id']);
			$rights['city_txt'] 	= $areaClass->get_name($address['city_id']);
			$rights['area_txt'] 	= $areaClass->get_name($address['area_id']);
		}

		return $rights;
	}

	/**
	 * 维权后，每一级分销商的利润
	 */
	public function getProfit($rights) {
		//D('Return')->where("user_return_id = '" . $return['user_return_id'] . "' or id = '" . $return['user_return_id'] . "'")->select();
		$db_prefix = C('DB_PREFIX');
		$this->table($db_prefix . "rights AS r");
		$this->join($db_prefix . "rights_product AS rp ON r.id = rp.rights_id", "LEFT");
		$this->join($db_prefix . "store AS s ON r.store_id = s.store_id", "LEFT");
		if ($rights['user_rights_id']) {
			$this->where("r.user_rights_id = '" . $rights['user_rights_id'] . "' or r.id = '" . $rights['user_rights_id'] . "'");
		} else {
			$this->where("r.id = '" . $rights['id'] . "' or r.user_rights_id = '" . $rights['id'] . "'");
		}
		$rights_list = $this->select();
		
		$data = array();
		foreach ($rights_list as $key => $rights) {
			$tmp = array();
			$tmp['order_id'] = $rights['order_id'];
			$tmp['store_id'] = $rights['store_id'];
			$tmp['name'] = $rights['name'];
			if ($rights['logo']) {
				$tmp['logo'] = getAttachmentUrl($rights['logo']);
			} else {
				$tmp['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
			}
				
			$tmp['linkman'] = $rights['linkman'];
			$tmp['service_tel'] = $rights['service_tel'];
			$tmp['profit'] = $rights['pro_price'] * $rights['pro_num'];
				
			$tmp['is_fx'] = $rights['is_fx'];
			if (isset($rights_list[$key + 1])) {
				$tmp['profit'] = $rights['pro_price'] * $rights['pro_num'] - $rights_list[$key + 1]['pro_price'] * $rights_list[$key + 1]['pro_num'];
			}
			$tmp['drp_level'] = $rights['drp_level'];
				
			$data[] = $tmp;
		}

		return $data;
	}


	/**
	 * 维权类型
	 */
	public function rightsType($type = 0) {
		$type_arr = array(1 => '商品质量问题', 2 => '未到货品', 3 => '其它');
		if (empty($type)) {
			return $type_arr;
		}

		return $type_arr[$type];
	}

	/**
	 * 维权状态
	 */
	public function rightsStatus($status = 0) {
		$status_arr = array(1 => '申请中', 2 => '维权中', 3 => '维权完成', 10 => '取消维权');

		if (empty($status)) {
			return $status_arr;
		}

		return $status_arr[$status];
	}
}
?>