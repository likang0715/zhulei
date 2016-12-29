<?php
/*
 * 订餐管理
 *
 * @  Writers    Jaty
 * @  BuildTime  2014/11/18 11:21
 * 
 */

class SmsAction extends BaseAction{
    public function index(){
		$Sms = D('Sms_tpl');
		$tp_list = $Sms->order('type ASC,id DESC')->select();
		$this->assign('tp_list',$tp_list);

		
		$this->display();
    }
	public function cat_add(){
		$this->assign('bg_color','#F3F3F3');
		$this->display();
	}
	public function cat_modify(){
		if(IS_POST){
			$database_meal_category = D('Sms_tpl');
			if($database_meal_category->data($_POST)->add()){
				$this->success('添加成功！');
			}else{
				$this->error('添加失败！请重试~');
			}
		}else{
			$this->error('非法提交,请重新提交~');
		}
	}
	public function sms_edit(){
		$this->assign('bg_color','#F3F3F3');
		
		$database_meal_category = D('Sms_tpl');
		$condition_now_meal_category['id'] = intval($_GET['id']);
		$now_category = $database_meal_category->field(true)->where($condition_now_meal_category)->find();
		if(empty($now_category)){
			$this->frame_error_tips('没有找到该信息！');
		}
		$this->assign('now_tpl',$now_category);
		$this->display();
	}
	public function tpl_amend(){
		if(IS_POST){
			$database_meal_category = D('Sms_tpl');
			if($database_meal_category->data($_POST)->save()){
				$this->success('编辑成功！');
			}else{
				$this->error('编辑失败！请重试~');
			}
		}else{
			$this->error('非法提交,请重新提交~');
		}
	}
	public function cat_del(){
		if(IS_POST){
			$database_meal_category = D('Meal_store_category');
			$condition_now_meal_category['cat_id'] = intval($_POST['cat_id']);
			if($database_meal_category->where($condition_now_meal_category)->delete()){
				$database_meal_category_relation = D('Meal_category_relation');
				$condition_meal_category_relation['cat_id'] = intval($_POST['cat_id']);
				$database_meal_category_relation->where($condition_meal_category_relation)->delete();
				$this->success('删除成功！');
			}else{
				$this->error('删除失败！请重试~');
			}
		}else{
			$this->error('非法提交,请重新提交~');
		}
	}
	
	public function order()
	{
		$count = D("Meal_order")->where(array('paid' => 1))->count();
		import('@.ORG.merchant_page');
		$p = new Page($count, 20);
		$list = D("Meal_order")->where(array('paid' => 1))->order("order_id DESC")->limit($p->firstRow . ',' . $p->listRows)->select();
		$mer_ids = $store_ids = array();
		foreach ($list as &$l) {
			$mer_ids[] = $l['mer_id'];
			$store_ids[] = $l['store_id'];
		}
		$store_temp = $mer_temp = array();
		if ($mer_ids) {
			$merchants = D("Merchant")->where(array('mer_id' => array('in', $mer_ids)))->select();
			foreach ($merchants as $m) {
				$mer_temp[$m['mer_id']] = $m;
			}
		}
		if ($store_ids) {
			$merchant_stores = D("Merchant_store")->where(array('store_id' => array('in', $store_ids)))->select();
			foreach ($merchant_stores as $ms) {
				$store_temp[$ms['store_id']] = $ms;
			}
		}
		foreach ($list as &$li) {
			$li['info'] = unserialize($li['info']);
			$li['merchant_name'] = isset($mer_temp[$li['mer_id']]['name']) ? $mer_temp[$li['mer_id']]['name'] : '';
			$li['store_name'] = isset($store_temp[$li['store_id']]['name']) ? $store_temp[$li['store_id']]['name'] : '';
		}
		$this->assign('order_list', $list);
		
		$pagebar = $p->show();
		
		$this->assign('pagebar', $pagebar);

		$this->display();
		
	}
	
	public function order_detail(){
		$this->assign('bg_color','#F3F3F3');
		
		$database_meal_order = D('Meal_order');
		$where['order_id'] = intval($_GET['order_id']);
		$order = $database_meal_order->field(true)->where($where)->find();
		if(empty($order)){
			$this->frame_error_tips('没有找到该订单的信息！');
		}
		$order['info'] = unserialize($order['info']);
		$this->assign('order', $order);
		$this->display();
	}
}