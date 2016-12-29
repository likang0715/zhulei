<?php
/**
 *  分享 相关ajax
 */

require_once dirname(__FILE__).'/global.php';

$type = $_POST['types'];
$uid = $_POST['uid'];
$store_id = $_POST['store_id'];
$data_id = $_POST['data_id'];	//被分享的操作id


switch($type) {
	//分享专题
	case 'subject':
			if(!$uid || !$store_id || !$data_id) {
				return false;
			} else {
				if(D('Store_subject_data')->where(array('subject_id' => $data_id,'store_id'=>$store_id))->find()) {
					D('Store_subject_data')->where(array('subject_id' => $data_id,'store_id'=>$store_id))->setInc('share_count');
				} else {
					D('Store_subject_data')->data(array('subject_id'=>$data_id,'store_id'=>$store_id,'share_count'=>1))->add();
				}
			}
		break;
	// 分享摇一摇抽奖
	case 'shakelottery':
		if(empty($uid) || empty($store_id) || empty($data_id)){
			return false;
		}else{
			D('Shakelottery')->where(array('id'=>$data_id,'store_id'=>$store_id))->data('`share_count`=`share_count`+1')->save();
		}
		break;


}