<?php
/**
 * 提现记录数据视图
 * User: pigcms_21
 * Date: 2015/3/19
 * Time: 21:18
 */

class StoreWithdrawalViewModel extends ViewModel
{
    protected $viewFields = array(
        'StoreWithdrawal' => array('*'),
        'Store' => array('name' => 'store', 'tel' => 'mobile', 'balance', '_on' => 'StoreWithdrawal.store_id = Store.store_id'),
        'User' => array('nickname', 'phone' => 'tel', '_on' => 'StoreWithdrawal.uid = User.uid'),
        'Bank' => array('name' => 'bank', '_on' => 'StoreWithdrawal.bank_id = Bank.bank_id')
    );

    //提现记录状态
    public function getWithdrawalStatus()
    {
        return array(
            '1' => '申请中',
            '2' => '银行处理中',
            '3' => '提现成功',
            '4' => '提现失败'
        );
    }

    /**
     * 提现金额
     * @param $where
     * @return int
     */
    public function getAmount($where)
    {
        $amount = $this->where($where)->sum('amount');
        return ($amount > 0) ? $amount : 0;
    }

    /**
     * 获取提现服务费
     * @param $where
     * @return int
     */
    public function getServiceFee($where)
    {
        $where['sales_ratio'] = array('gt', 0);
        $service_fee = $this->where($where)->sum('amount * (sales_ratio/100)');
        return !empty($service_fee) ? $service_fee : 0;
    }

    public function getWithdrawal($where)
    {
        return $this->where($where)->find();
    }
} 