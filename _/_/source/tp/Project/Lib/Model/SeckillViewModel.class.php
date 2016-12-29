<?php
/**
 * 秒杀数据视图
 * User: pigcms_21
 * Date: 2016/05/03
 * Time: 13:11
 */

class SeckillViewModel extends ViewModel {
	public $viewFields = array(
							'Seckill' => array('*', '_as' => 'a', '_type' => 'LEFT'),
							'Store' => array('s.name' => 's_name', '_as' => 's', '_on' => 'a.store_id = s.store_id'),
						);
}