<?php
class zc_product_model extends base_model{
	// 开始筹资
	public function startCollect($product_id){
		$product_info=$this->db->where(array('product_id'=>$product_id))->find();
		$info['start_time'] = $_SERVER['REQUEST_TIME'];
		$info['endtime']    = $product_info['raiseType']==1 ? 0 : ($info['start_time']+($product_info['collectDays']*86400));
		$info['status']     = 4;
		$effId = D('Zc_product')->where(array('product_id'=>$product_id))->data($info)->save();
		return $effId;
	}
	// 计划任务
	public function jihua($product_id=''){
		if(empty($product_id)){
	            	// 筹资中 结束时间小于当前时间 筹资天数普通
	            	$where='`status`=4 AND `endtime`<'.$_SERVER['REQUEST_TIME'].' AND `raiseType`=0';
	            	$proList=$this->db->where($where)->field('`product_id`,`status`,`amount`,`raiseType`,`collect`')->order('`product_id` DESC')->select();
	            	$proList=!empty($proList) ? $proList : array();
	            	$id_success=$id_error=array();
	            	foreach ($proList as $k => $v) {
	                	$v['collect']<$v['amount'] ? array_push($id_error, $v['product_id']) : array_push($id_success, $v['product_id']);
	            	}
	            	if(!empty($id_error)){
	                	$where_error='product_id in ('.implode(',', $id_error).')';
	                	$this->db->where($where_error)->data(array('status'=>7))->save();
	            	}
	            	if(!empty($id_success)){
	                	$where_error='product_id in ('.implode(',', $id_success).')';
	                	$this->db->where($where_error)->data(array('status'=>6))->save();
	            	}
		}else{
			$product_id  = intval($product_id);
			$where='`product_id`='.$product_id.' AND `status`=4 AND `endtime`<'.$_SERVER['REQUEST_TIME'].' AND `raiseType`=0';
			$product_info=$this->db->where(array('product_id'=>$product_id))->field('`product_id`,`endtime`,`status`,`amount`,`raiseType`,`collect`')->find();
			if(empty($product_info)){
				return;
			}else{
				if($product_info['collect']<$product_info['amount']){
					$this->db->where(array('product_id'=>$product_id))->data(array('status'=>7))->save();
				}else{
					$this->db->where(array('product_id'=>$product_id))->data(array('status'=>6))->save();
				}
			}
		}
	}




}




 ?>