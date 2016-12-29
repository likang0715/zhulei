<?php

/**
 * Created by PhpStorm.
 * User: pigcms_21
 * Date: 2015/11/27
 * Time: 10:34
 */
class FinancialRecordModel extends Model
{
    public function getOrderProfit($order_id, $status = array(1,2,3))
    {
        $profit = $this->where(array('order_id' => $order_id, 'status' => array('in', $status)))->sum('income');
        return !empty($profit) ? $profit : 0;
    }
}