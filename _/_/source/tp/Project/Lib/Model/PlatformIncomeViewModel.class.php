<?php

/**
 * Created by PhpStorm.
 * User: pigcms_21
 * Date: 2015/12/22
 * Time: 15:43
 */
class PlatformIncomeViewModel extends ViewModel
{
    public $viewFields = array(
        'PlatformIncome' => array('*'),
        'Store' => array('name' => 'store' , '_on' => 'PlatformIncome.store_id = Store.store_id'),
    );
}