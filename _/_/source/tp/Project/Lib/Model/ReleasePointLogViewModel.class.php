<?php
/**
 * 积分发放流水视图模型 
 * @author HZ <2881362320@qq.com> 
 * @version 1.0
 */

class ReleasePointLogViewModel extends ViewModel
{
    protected $viewFields = array(
        'ReleasePointLog' => array('*'),
        'User' => array('nickname' => 'nickname','_on' => 'ReleasePointLog.uid = User.uid'),
    );
} 

