<?php
/**
 * 积分保证金流水视图模型 
 * @author HZ <2881362320@qq.com> 
 * @version 1.0
 */

class CreditDepositFlowViewModel extends ViewModel
{
    protected $viewFields = array(
        'CreditDepositFlow' => array('*'),
        'Store' => array('name' => 'store','_on' => 'CreditDepositFlow.store_id = Store.store_id'),
    );
} 

