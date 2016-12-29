<?php
/**
 * 备付金流水视图模型 
 * @author
 * @version 1.0
 */

class CashProvisionLogViewModel extends ViewModel
{
    protected $viewFields = array(
        'CashProvisionLog' => array('*','_type'=>'LEFT'),
		'Store' => array('name' => 'store','_on' => 'CashProvisionLog.store_id = Store.store_id', '_type'=>'LEFT'),
    );
} 

