<?php
/**
 * 平台积分流水视图模型 
 * @author HZ <2881362320@qq.com> 
 * @version 1.0
 */

class PlatformPointLogViewModel extends ViewModel
{
    protected $viewFields = array(
        'PlatformPointLog' => array('*'),
        'Store' => array('name' => 'store','_on' => 'PlatformPointLog.store_id = Store.store_id'),
    );
} 

