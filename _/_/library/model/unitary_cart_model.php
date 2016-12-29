<?php
/**
 * 夺宝购物记录
 * User: pigcms_89
 * Date: 2016/03/08
 * Time: 13:26
 */

class unitary_cart_model extends base_model
{
	// 统计数量
	public function getCount ($where) {
		$count = $this->db->field('count(1) as count')->where($where)->find();
		return $count['count'];
	}

	// 获取购物记录
	public function getList ($where, $order_by = '', $limit = 0, $offset = 0) {
		$this->db->where($where);
		if (!empty($order_by)) {
			$this->db->order($order_by);
		}
		
		if (!empty($limit)) {
			$this->db->limit($offset . ',' . $limit);
		}
		
		$list = $this->db->select();
		
		return $list;
	}

	// 计算购物车中购买数量
	public function addCartTmpCount ($cart_list = array()) {

		$cart = array();							// 所有购物记录
		$tmparr = array();
		foreach ($cart_list as $k => $vo) {
			if (array_key_exists($vo['unitary_id'], $tmparr)) {
				$tmpk = $tmparr[$vo['unitary_id']];
				$cart[$tmpk]['count'] = $cart[$tmpk]['count'] + $vo['count'];
			} else {	
				$tmparr[$vo['unitary_id']] = $k;
				$cart[$k] = $vo;
			}
		}

		return $cart;
	}

	// 获取活动真实可购买数量
	public function getLeftCount ($unitary_id = 0) {

		$find_unitary = D('Unitary')->where(array('id'=>$unitary_id))->find();

		if (empty($find_unitary) || $find_unitary['state'] != 1) {
			return 0;
		}

		$where_cart2 = array(
			'state' => 1,
			'unitary_id' => $unitary_id,
		);
		$cart_list = D('Unitary_cart')->where($where_cart2)->select();

		$pay_count = 0;
		foreach ($cart_list as $vo) {
			$this_order = D('Unitary_order')->where(array('pigcms_id'=>$vo['order_id']))->find();
			if ($this_order['paid'] != 1 && $vo['addtime'] < (time()-($this->overTime))) {
				D('Unitary_cart')->where(array('id'=>$vo['id']))->delete();
			} else {
				$pay_count = $pay_count + $vo['count'];
			}
		}

		$unitary_ycount = $find_unitary['total_num'] - $pay_count;

		return $unitary_ycount;

	}
}