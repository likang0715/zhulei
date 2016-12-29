<?php
/**
 * 退货表
 */
class ReturnModel extends Model{
	/**
	 * 统计退货数量
	 */
	public function getCount($where = 0) {
		return $this->where($where)->count('id');
	}
	/**
	 * 退货列表
	 */
	public function getList($where = '', $limit = 0, $offset = 0) {
		if (empty($where)) {
			return array();
		}
		
		$db_prefix = C('DB_PREFIX');
		
		$this->table($db_prefix . 'return as r');
		$this->join($db_prefix . 'return_product as rp on r.id = rp.return_id', 'left');
		$this->join($db_prefix . 'product as p on rp.product_id = p.product_id', 'left');
		$this->join($db_prefix . 'user as u on r.uid = u.uid', 'left');
		$this->join($db_prefix . 'store as s on s.store_id = r.store_id', 'left');
		$this->where($where);
		$this->field('r.*, s.name as store_name, s.tel as store_tel, s.linkman, rp.return_id, rp.order_product_id, rp.product_id, rp.sku_id, rp.sku_data, rp.pro_num, rp.pro_price, rp.supplier_id, rp.original_product_id, p.image, p.name, u.nickname, u.phone');
		$this->order('r.status asc, r.id DESC');
		if (!empty($limit)) {
			$this->limit($offset . ',' . $limit);
		}
		
		$return_list = $this->select();
		foreach ($return_list as &$value) {
			$value['image'] = getAttachmentUrl($value['image']);
			$value['type_txt'] = $this->returnType($value['type']);
			$value['status_txt'] = $this->returnStatus($value['status']);
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
	 * 获取单个退货
	 */
	public function getById($id = 0) {
		if (empty($id)) {
			return array();
		}
		
		$db_prefix = C('DB_PREFIX');
		
		$this->table($db_prefix . 'return as r');
		$this->join($db_prefix . 'return_product as rp on r.id = rp.return_id', 'left');
		$this->join($db_prefix . 'product as p on rp.product_id = p.product_id', 'left');
		$this->join($db_prefix . 'user as u on r.uid = u.uid', 'left');
		$this->where("r.id = '" . $id . "'");
		$this->field('r.*, rp.return_id, rp.order_product_id, rp.product_id, rp.sku_id, rp.sku_data, rp.pro_num, rp.pro_price, rp.supplier_id, rp.original_product_id, p.image, p.name, u.nickname');
		
		$return = $this->find();
		
		if (empty($return)) {
			return array();
		}
		
		$return['image'] = getAttachmentUrl($return['image']);
		$return['type_txt'] = $this->returnType($return['type']);
		$return['status_txt'] = $this->returnStatus($return['status']);
		$tmp_images = unserialize($return['images']);
		
		if (is_array($tmp_images)) {
			foreach ($tmp_images as &$tmp_image) {
				$tmp_image = getAttachmentUrl($tmp_image);
			}
		
			$return['images'] = $tmp_images;
		}
		
		if ($return['address']) {
			$address = unserialize($return['address']);
			import('area', './source/class/');
			$areaClass = new area();
			$return['province_txt'] = $areaClass->get_name($address['province_id']);
			$return['city_txt'] 	= $areaClass->get_name($address['city_id']);
			$return['area_txt'] 	= $areaClass->get_name($address['area_id']);
		}
		
		return $return;
	}
	
	/**
	 * 退货后，每一级分销商的利润
	 */
	public function getProfit($return) {
		$db_prefix = C('DB_PREFIX');
		$this->table($db_prefix . "return AS r");
		$this->join($db_prefix . "return_product AS rp ON r.id = rp.return_id", "LEFT");
		$this->join($db_prefix . "store AS s ON r.store_id = s.store_id", "LEFT");
		if ($return['user_return_id']) {
			$this->where("r.user_return_id = '" . $return['user_return_id'] . "' or r.id = '" . $return['user_return_id'] . "'");
		} else {
			$this->where("r.id = '" . $return['id'] . "' or r.user_return_id = '" . $return['id'] . "'");
		}
		$return_list = $this->select();
		
		$data = array();
		foreach ($return_list as $key => $return) {
			$tmp = array();
			$tmp['order_id'] = $return['order_id'];
			$tmp['store_id'] = $return['store_id'];
			$tmp['name'] = $return['name'];
			if ($return['logo']) {
				$tmp['logo'] = getAttachmentUrl($return['logo']);
			} else {
				$tmp['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
			}
			
			$tmp['linkman'] = $return['linkman'];
			$tmp['service_tel'] = $return['service_tel'];
			$tmp['profit'] = $return['pro_price'] * $return['pro_num'];
			
			$tmp['is_fx'] = $return['is_fx'];
			if (isset($return_list[$key + 1])) {
				$tmp['profit'] = $return['pro_price'] * $return['pro_num'] - $return_list[$key + 1]['pro_price'] * $return_list[$key + 1]['pro_num'];
			}
			$tmp['drp_level'] = $return['drp_level'];
			
			$data[] = $tmp;
		}
		
		return $data;
	}
	
	
	/**
	 * 退货类型
	 */
	public function returnType($type = 0) {
		$type_arr = array(1 => '买/卖双方协商一致', 2 => '买错/多买/不想要', 3 => '商品质量问题', 4 => '未到货品', 5 => '其它');
		if (empty($type)) {
			return $type_arr;
		}
		
		return $type_arr[$type];
	}
	
	/**
	 * 退货状态
	 */
	public function returnStatus($status = 0) {
		$status_arr = array(1 => '申请中', 2 => '商家审核不通过', 3 => '商家审核通过', 4 => '等待收货', 5 => '退货完成', 6 => '取消退货');
		
		if (empty($status)) {
			return $status_arr;
		}
		
		return $status_arr[$status];
	}

	/**
	 * 退款状态
	 * @param int $status
	 */
	public function refundStatus($status = null)
	{
		$status_arr = array(
			0 => '待退款',
			1 => '已退款',
			2 => '已取消'
		);
		return !empty($status_arr[$status]) ? $status_arr[$status] : $status_arr;
	}
}