<?php
/**
 * 店铺积分流水视图模型 
 * @author
 * @version 1.0
 */

class StorePointLogViewModel extends ViewModel
{
    protected $viewFields = array(
        'StorePointLog' => array('*'),
        'Store' => array('name' => 'store', '_on' => 'StorePointLog.store_id = Store.store_id'),
        //'User' => array('nickname' => 'nickname','_on' => 'StorePointLog.uid = User.uid'),
    );
} 

