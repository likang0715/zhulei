<?php
/**
 * 收支明细数据视图
 * User: pigcms_21
 * Date: 2015/3/19
 * Time: 21:18
 */

class FinancialRecordViewModel extends ViewModel
{
    protected $viewFields = array(
        'FinancialRecord' => array('*'),
        'Store' => array('name' => 'store', 'tel' => 'mobile', 'balance', '_on' => 'FinancialRecord.store_id = Store.store_id')
    );
} 