<?php
/**
 * 用户积分流水视图模型 
 * @author
 * @version 1.0
 */

class UserPointLogViewModel extends ViewModel
{
    protected $viewFields = array(
        'UserPointLog' => array('*'),
        //'Store' => array('name' => 'store','_on' => 'UserPointLog.store_id = Store.store_id'),
        'User' => array('nickname' => 'nickname','_on' => 'UserPointLog.uid = User.uid'),
    );
} 

