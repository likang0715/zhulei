<?php
/**
 * 退货表
 */
class return_model extends base_model{
	/**
	 * 统计退货数量
	 */
	public function getCount($where = 0) {
		return $this->db->where($where)->count('id');
	}
	/**
	 * 退货列表
	 */
	public function getList($where = '', $limit = 0, $offset = 0) {
		if (empty($where)) {
			return array();
		}
		$this->db->table('Return as r');
		$this->db->join('Return_product as rp on r.id = rp.return_id', 'left');
		$this->db->join('Product as p on rp.product_id = p.product_id', 'left');
		$this->db->join('User as u on r.uid = u.uid', 'left');
		$this->db->where($where);
		$this->db->field('r.*, if(r.status=2, 5 , r.status) as new_status, rp.return_id, rp.order_product_id, rp.product_id, rp.sku_id, rp.sku_data, rp.pro_num, rp.pro_price, rp.supplier_id, rp.original_product_id, rp.discount, p.image, p.name, p.wholesale_product_id, u.nickname');
		$this->db->order('new_status asc, r.id DESC');
		if (!empty($limit)) {
			$this->db->limit($offset . ',' . $limit);
		}
		
		$return_list = $this->db->select();

		foreach ($return_list as &$value) {
			$value['sku_data_arr'] = array();
			if (!empty($value['sku_data'])) {
				$value['sku_data_arr'] = unserialize($value['sku_data']);
			}
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
			
			if ($value['address']) {
				$address = unserialize($value['address']);
				import('area');
				$areaClass = new area();
				$value['province_txt'] = $areaClass->get_name($address['province_id']);
				$value['city_txt'] = $areaClass->get_name($address['city_id']);
				$value['area_txt'] = $areaClass->get_name($address['area_id']);
				$value['address_txt'] = $address['address'];
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
		$this->db->table('Return as r');
		$this->db->join('Return_product as rp on r.id = rp.return_id', 'left');
		$this->db->join('Product as p on rp.product_id = p.product_id', 'left');
		$this->db->join('User as u on r.uid = u.uid', 'left');
		$this->db->where("r.id = '" . $id . "'");
		$this->db->field('r.*, rp.return_id, rp.order_product_id, rp.product_id, rp.sku_id, rp.sku_data, rp.pro_num, rp.pro_price, rp.supplier_id, rp.original_product_id, rp.discount, p.image, p.name, p.wholesale_product_id, u.nickname');
		
		$return = $this->db->find();

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
			import('area');
			$areaClass = new area();
			$return['province_txt'] = $areaClass->get_name($address['province_id']);
			$return['city_txt'] = $areaClass->get_name($address['city_id']);
			$return['area_txt'] = $areaClass->get_name($address['area_id']);
			$return['address_txt'] = $address['address'];
		}
		
		return $return;
	}
	
	/**
	 * 退货后，每一级分销商的利润
	 */
	public function getProfit($return) {
		//D('Return')->where("user_return_id = '" . $return['user_return_id'] . "' or id = '" . $return['user_return_id'] . "'")->select();
		
		$this->db->table("Return AS r");
		$this->db->join("Return_product AS rp ON r.id = rp.return_id", "LEFT");
		$this->db->join("Store AS s ON r.store_id = s.store_id", "LEFT");
		$this->db->field("*, r.id as r_id");
		
		if ($return['user_return_id']) {
			$this->db->where("r.user_return_id = '" . $return['user_return_id'] . "' or r.id = '" . $return['user_return_id'] . "'");
		} else {
			$this->db->where("r.id = '" . $return['id'] . "' or r.user_return_id = '" . $return['id'] . "'");
		}
		$this->db->order('r.id ASC');
		$return_list = $this->db->select();
		$data = array();
		foreach ($return_list as $key => $return) {
			$tmp = array();
			$tmp['id'] = $return['r_id'];
			$tmp['order_id'] = $return['order_id'];
			$tmp['store_id'] = $return['store_id'];
			$tmp['name'] = $return['name'];
			$tmp['user_return_id'] = $return['user_return_id'];
			$tmp['return_id'] = $return['return_id'];
			if ($return['logo']) {
				$tmp['logo'] = getAttachmentUrl($return['logo']);
			} else {
				$tmp['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
			}
			
			$tmp['linkman'] = $return['linkman'];
			$tmp['service_tel'] = $return['service_tel'];
			$tmp['profit'] = $return['pro_price'] * $return['pro_num'] + $return['postage_money'];
			
			$tmp['is_fx'] = true;
			if (isset($return_list[$key + 1])) {
				$tmp['profit'] = $return['pro_price'] * $return['pro_num'] - $return_list[$key + 1]['pro_price'] * $return_list[$key + 1]['pro_num'];
			} else {
				$tmp['is_fx'] = false;
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
	 * 订单退货总金额（包含运费）
	 * @param $order_id
	 */
	public function getOrderReturnAmount($order_id)
	{
		$amount = $this->db->where(array('order_id' => $order_id, 'status' => 5))->sum('product_money + postage_money');
		return !empty($amount) ? $amount : 0;
	}

	/**
	 * 退货中的订单(含：申请中、商家审核通过、退货物流)
	 * @param $order_id
	 */
	public function getOrderReturning($order_id)
	{
		$returning = $this->db->where(array('order_id' => $order_id, 'status' => array('in', array(1,3,4))))->select();
		return !empty($returning) ? $returning : array();
	}

	/**
	 * 退货列表
	 * @param $order_id
	 * @param $status
	 */
	public function getReturns($order_id, $status = array())
	{
		$where = array();
		$where['order_id'] = $order_id;
		if (!empty($status)) {
			$where['status'] = array('in', $status);
		}
		$returns = $this->db->where($where)->select();
		return !empty($returns) ? $returns : array();
	}
}