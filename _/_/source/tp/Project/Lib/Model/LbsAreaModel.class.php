<?php
/**
 * @description:  总后台权限组
 * User: pigcms-s
 * Date: 2016/02/17
 * Time: 10:34
 */

class LbsAreaModel extends Model {

	// 批量 replace
	public function addAlls ($datas) {
		if(!is_array($datas)) return;

			$this->addAll($datas,array(),true);

	}

	

} 