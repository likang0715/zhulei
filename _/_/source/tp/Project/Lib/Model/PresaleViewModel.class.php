<?php
/**
 * 预售数据视图
 * User: pigcms_21
 * Date: 2016/05/03
 * Time: 13:11
 */

class PresaleViewModel extends ViewModel {
	public $viewFields = array(
							'Presale' => array('*', '_as' => 'p', '_type' => 'LEFT'),
							'Store' => array('s.name' => 's_name', '_as' => 's', '_on' => 'p.store_id = s.store_id'),
						);
}