<?php
/**
 * 平台保证金流水视图模型 
 * @version 1.0
 */

class PlatformMarginLogViewModel extends ViewModel {
	
	protected $viewFields = array(
		'PlatformMarginLog' => array('*','_type'=>'LEFT'),
		'Store' => array('name' => 'store', 'uid', 'tel', 'bank_id', 'bank_card', 'bank_card_user', 'opening_bank', '_on' => 'PlatformMarginLog.store_id = Store.store_id', '_type'=>'LEFT'),
		'StoreContact' => array('_as'=>'sc','address' => 'store_address','province','city','county','_on' => "Store.store_id=sc.store_id"),
		'User' => array('nickname', '_on' => 'Store.uid = User.uid')
	);

	public function getStatus($key = '')
	{
		$status = array(
			1 => '未处理',
			2 => '已处理',
			3 => '已取消'
		);
		if (!empty($key) && array_key_exists($key, $status)) {
			return $status[$key];
		} else {
			return $status;
		}
	}
}

