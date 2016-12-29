<?php
/**
 * 商品额外折扣特权
 * User: pigcms-s
 * Date: 2016/01/11
 * Time: 14:01
 */

class product_discount_model extends base_model {

	public function get($product_id) {
		return $this->db->where(array('product_id'=>$product_id))->find();
	}
	
	public function add($array) {
		 $this->db->data($array)->add();
	}
	
	/*where 一般指 store_id*/
	public function getByStoreList ($where, $order_by = '', $limit = 0, $offset = 0) {
		$this->db->where($where);
		if (!empty($order_by)) {
			$this->db->order($order_by);
		}

		if (!empty($limit)) {
			$this->db->limit($offset . ',' . $limit);
		}
		
		$discount_list = $this->db->select();
		return $discount_list;
		
	}

	/**
	 * 更改,条件一般指的是ID
	 */
	public function save($data, $where) {
		$this->db->data($data)->where($where)->save();
	}
	
	/**
	 * 更新商品特权
	 */
	public function updating($where,$data) {
		
		if($this->db->where($where)->find()) {
			$this->save($data,$where);
		} else {
			$this->add($data);
		}
		
	}
	
	/*
	 * 批量更新商品特权
	 * $data 为二维数组
	*/
	public function updatingall($where,$data) {
		
		if(is_array($data)) {
			foreach($data as $k=>$v) {
				if($v['degree_id']) {
					$where = array_merge($where,array('degree_id'=>$v['degree_id']));
					if($this->db->where($where)->find()) {
						$this->save($v,$where);
					} else {
						$this->add($v);
					}
				}
			}
		}

	}
	
	/**
	 * 删除
	 */
	public function delete($store_id,$product_id) {
		
		$where = array();
        $where ['store_id'] = $store_id;
        if (is_array($product_id)) {
            $where ['product_id'] = array(
                'in',
                $product_id
            );
        } else {
            $where ['product_id'] = $product_id;
        }
		
		$this->db->where($where)->delete();
	}
	
	/**
	 * 返回产品的特权积分和折扣
	 * param $product 产品
	 * param $uid 用户ID
	 */
	public function getPointDiscount($product, $uid) {
		static $user_level_arr = array();
		
		$return = array();
		if ($product['wholesale_product_id']) {
			$supplier_product = D('Product')->where(array('product_id' => $product['wholesale_product_id']))->find();
			// 用户特权积分
			if ($supplier_product['check_give_points'] && $supplier_product['give_points'] > 0) {
				$return['point'] = $supplier_product['give_points'];
			}
			
			if (!isset($user_level_arr[$uid . '_' . $supplier_product['store_id']])) {
				$store_user_data = M('Store_user_data')->getUserData($supplier_product['store_id'], $uid);
				$user_level_arr[$uid . '_' . $supplier_product['store_id']] = $store_user_data['degree_id'];
			}
			
			// 用户特权折扣
			if ($supplier_product['check_degree_discount'] && $user_level_arr[$uid . '_' . $supplier_product['store_id']]) {
				$product_discount = D('Product_discount')->where(array('product_id' => $supplier_product['product_id']))->find();
				if (!empty($product_discount) && $product_discount['discount'] > 0 && $product_discount['discount'] <= 10) {
					$return['discount'] = $product_discount['discount'];
				}
			}
		} else {
			// 用户特权积分
			if ($product['check_give_points'] && $product['give_points'] > 0) {
				$return['point'] = $product['give_points'];
			}
				
			if (!isset($user_level_arr[$uid . '_' . $product['store_id']])) {
				$store_user_data = M('Store_user_data')->getUserData($product['store_id'], $uid);
				$user_level_arr[$uid . '_' . $product['store_id']] = $store_user_data['degree_id'];
			}
				
			// 用户特权折扣
			if ($product['check_degree_discount'] && $user_level_arr[$uid . '_' . $product['store_id']]) {
				$product_discount = D('Product_discount')->where(array('product_id' => $product['product_id'], 'degree_id' => $user_level_arr[$uid . '_' . $product['store_id']]))->find();
				if (!empty($product_discount) && $product_discount['discount'] > 0 && $product_discount['discount'] <= 10) {
					$return['discount'] = $product_discount['discount'];
				}
			}
		}
		
		return $return;
	}
} 