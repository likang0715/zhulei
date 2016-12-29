<?php
/**
 * 订单打印机模型
 * User: pigcms-s
 * Date: 2015/11/25
 * Time: 16:58
 */
	class store_orderprint_machine_model extends base_model{
	
		//查看某个店铺的所有订单打印机
		public function getOrderprntMachineByStoreid($storeid){
			$return = $this->db->where(array('store_id'=>$storeid))->select();
			return $return;
		}
				
		//创建订单打印机
		public function create($data) {
			
			if($data['store_id']) {
				$exists_machine = $this->db->where(array('terminal_number' => $data['terminal_number'] , 'store_id' => $data['store_id']))->find();
				if($exists_machine) {
					return array('err_code' => 5000,'err_msg' => '您的店铺已存在相同的终端号，请核对！');
				}
			}

			if($this->db->data($data)->add()){
				return array('err_code' => 0,'err_msg' => $data);
			} else {
				return array('err_code' => 4000,'err_msg' => '订单打印机创建失败');
			}
		}
		
		
		//修改订单打印机
		public function save($data, $where) {
			$this->db->data($data)->where($where)->save();	
		}

		
		//删除订单打印机
		public function delete($id,$store_id) {
			return $this->db->where(array('store_id' => $store_id,'id'=>$id))->delete();
		}
		
		
		public function get($id,$store_id) {
			$oprint = $this->db->where(array('id' => $id,'store_id'=>$store_id))->find();
			return $oprint;
		}
		
		
		/**
		 * 获取满足条件的打印机记录数
		 */
		public function getCount($where) {
			$oprint_count = $this->db->field('count(1) as count')->where($where)->find();
			return $oprint_count['count'];
		}
		
		/**
		 * 根据条件获到订单打印机列表
		 * 当limit与offset都为0时，表示不行限制
		 */
		public function getList($where, $order_by = '', $limit = 0, $offset = 0) {
			$this->db->where($where);
			if (!empty($order_by)) {
				$this->db->order($order_by);
			}
		
			if (!empty($limit)) {
				$this->db->limit($offset . ',' . $limit);
			}
		
			$oprint_list = $this->db->select();
			return $oprint_list;
		}
		
		
				
	}