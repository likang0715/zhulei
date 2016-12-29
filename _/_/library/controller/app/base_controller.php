<?php

/**
 * 基础类
 */
class base_controller extends controller {
	public $user;
	
	public function __construct() {
		parent::__construct();

	$results = array('result'=>'0','data'=>array(),'msg'=>'');

		$uid = $_REQUEST['uid'];
		if (empty($uid)) {
		     $results['result']='1';
			$results['msg']='uid不正确';
			exit(json_encode($results));
		}
	    $token = $_REQUEST['token'];
		if (empty($token)) {
		     $results['result']='1';
			$results['msg']='token不能为空';
			exit(json_encode($results));
		}
		$tokens = D('Users_token')->where(array('uid' => $uid))->find();
		if ($token!=$tokens['token']) {
		   // $results['result']='1';
		//	$results['msg']='token不正确';
			//exit(json_encode($results));
		}
		if ($_REQUEST['store_id']) {
		   $this->store_id = $_REQUEST['store_id'];
		}
		
     
		$this->uid = $_REQUEST['uid'];
		$User = D('User')->where(array('uid' => $uid))->find();
		$this->item_store_id = $User['item_store_id'];
		$this->type = $User['type'];
		$this->group = $User['group'];
		$this->drp_store_id = $User['drp_store_id'];
		if ($_REQUEST['store_id']) {
		if($User['item_store_id'] != $_REQUEST['store_id']){
		if($User['item_store_id']==0){
		$store = D('Store')->where(array('uid' => $User['uid']))->find();

		if($store['store_id'] != $_REQUEST['store_id']){
		 $results['result']='1';
		 $results['msg']='store_id不正确';
		 exit(json_encode($results));
		}
		
		}
		
		}
		}
		
		$this->drp_supplier_id=$User['drp_supplier_id'];
	}
}
?>