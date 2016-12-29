<?php
/**
 * 预售数据视图
 * User: pigcms_21
 * Date: 2016/05/03
 * Time: 13:11
 */

class ZcProductViewModel extends ViewModel {
	public $viewFields = array(
							'ZcProduct' => array('*', '_as' => 'a', '_type' => 'LEFT'),
							'Store' => array('s.name' => 's_name', '_as' => 's', '_on' => 'a.store_id = s.store_id'),
						);
}