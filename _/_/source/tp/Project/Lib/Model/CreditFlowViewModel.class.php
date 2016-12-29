<?php
/**
 * 积分流水视图模型 
 * @author HZ <2881362320@qq.com> 
 * @version 1.0
 */

class CreditFlowViewModel extends ViewModel
{
    protected $viewFields = array(
        'CreditFlow' => array('*'),
        'Store' => array('name' => 'store','_on' => 'CreditFlow.store_id = Store.store_id'),
        'User' => array('nickname' => 'nickname','_on' => 'CreditFlow.uid = User.uid'),
    );
} 

