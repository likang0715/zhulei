<?php
/**
 * 商品数据视图
 * User: pigcms_21
 * Date: 2015/3/21
 * Time: 17:53
 */

class ProductViewModel extends ViewModel
{
    protected $viewFields = array(
        'Product' => array('*', '_type' => 'LEFT'),
        'ProductCategory' => array('cat_name' => 'category', '_on' => 'Product.category_id = ProductCategory.cat_id', '_type' => 'LEFT'),
        'Store' => array('name' => 'store', '_on' => 'Product.store_id = Store.store_id', '_type' => 'LEFT')
    );
}