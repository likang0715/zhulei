<?php
class chahuizt_controller extends base_controller{
public $config;
	public $_G;
	
	public function __construct(){
		global $_G;
		$this->_G = $_G;
		$this->arrays['config'] = $this->config = $_G['config'];
	}
	public function index() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
	$category = D('Chahui_category')->field('`cat_id`,`cat_name`')->where(array('cat_status' => 1))->order('cat_sort DESC,cat_id DESC')->select();
	
	$results['data']=$category;

	exit(json_encode($results));
    }
	
	
	
}
?>