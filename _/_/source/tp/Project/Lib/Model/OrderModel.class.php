<?php
class OrderModel extends Model{

	//获取指定条件下的订单总数
    public function getOrderTotal($where) {
    
        $order_count = $this->where($where)->count('order_id');
        return $order_count;
    }

    public function getOrderAmount($where)
    {
        $amount = $this->where($where)->sum('pay_money');
        return !empty($amount) ? $amount : 0;
    }
}

?>