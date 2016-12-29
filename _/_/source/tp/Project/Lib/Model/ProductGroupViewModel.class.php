<?php
/**
 * 商品分组数据视图
 * User: pigcms_21
 * Date: 2014/12/29
 * Time: 13:11
 */

class ProductGroupViewModel extends ViewModel
{
    public $viewFields = array(
        'ProductGroup' => array('*'),
        'Store' => array('name' => 'store' , '_on' => 'ProductGroup.store_id = Store.store_id'),
    );
}