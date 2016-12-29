<?php
/**
 * 订单数据视图
 * User: pigcms_21
 * Date: 2014/12/29
 * Time: 13:11
 */

class TuanViewModel extends ViewModel {
	public $viewFields = array(
							'Tuan' => array('*', '_as' => 't', '_type' => 'LEFT'),
							'Store' => array('s.name' => 's_name', '_as' => 's', '_on' => 't.store_id = s.store_id'),
						);
}