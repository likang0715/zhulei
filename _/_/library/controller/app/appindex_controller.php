<?php
class appindex_controller extends base_controller{
public $arrays=array();
	public $config;
	public $_G;
	public function __construct(){
		global $_G;
		$this->_G = $_G;
		$this->arrays['config'] = $this->config = $_G['config'];
	}
	public function index() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
		//首页幻灯片
		$adver_list = M('Adver')->get_adver_by_key('wap_index_slide_top', 5);
		foreach ($adver_list as &$adver) {
	
			unset($adver['id']);
			unset($adver['store_id']);
			unset($adver['bg_color']);
			unset($adver['cat_id']);
			unset($adver['status']);
			unset($adver['last_time']);
			unset($adver['description']);
			unset($adver['sort_order']);
		
		}
		
		//首页自定义导航
		$slider_nav_list = M('Slider')->get_slider_by_key('wap_index_nav', 16);
		foreach ($slider_nav_list as &$slider_nav) {
			$slider_nav['slider_id'] = $slider_nav['id'];
			unset($slider_nav);
		}
		
	 //yfz@20160620首页推荐茶馆
	$hot_physical 	= D('Store')->field('store_id,name,logo,price')->where("is_hot = 1")->order('store_id DESC')->limit('3')->select();
	foreach($hot_physical as $key=>$value){

      $Store_contact=D('Store_contact')->where('store_id='.$value['store_id'])->find();
	  $hot_physical[$key]['address'] = $Store_contact['address'];
     $tuan = D('Tuan')->field('`name`')->where("store_id = ".$value['store_id'])->order('`id` DESC')->limit(1)->select();
	 foreach($tuan as $k=>$r){
	 $hot_physical[$key]['tuan'] = $r['name'];
	 }
	
     $hui= D('Reward')->field('`name`')->where("store_id = ".$value['store_id'])->order('`id` DESC')->limit(1)->select();
	  foreach($hui as $k=>$r){
	 $hot_physical[$key]['hui'] = $r['name'];
	 }
      }

//yfz@20160620首页推荐茶会
    $chahui = D('Chahui')->field('pigcms_id,store_id,name,sttime,price,images')->where("tj = 1")->order('`sttime` DESC')->limit(3)->select();
foreach($chahui as $key =>$r){
$chahui[$key]['images']=getAttachmentUrl($r['images']);
$chahui_store = M('Store')->wap_getStore($r['store_id']);
$chahui[$key]['logo']=$chahui_store['logo'];
$chahui[$key]['time']=date('m/d H:i',$r['sttime']);
unset($chahui[$key]['sttime']);

}

		$hot_brand_slide = M('Adver')->get_adver_by_key('wap_index_brand',5);
	    foreach ($hot_brand_slide as &$adver) {
	
			unset($adver['id']);
			unset($adver['store_id']);
			unset($adver['bg_color']);
			unset($adver['cat_id']);
			unset($adver['status']);
			unset($adver['last_time']);
			unset($adver['description']);
			unset($adver['sort_order']);
		
		}
		$json_data = array();
		$json_data['lb_list'] = $adver_list;
	//	$json_data['slider_nav_list'] = $slider_nav_list;
		$json_data['ad_list'] = $hot_brand_slide;
		$json_data['store_list'] = $hot_physical;
		$json_data['chahui_list'] = $chahui;
		
	$results['data']=$json_data;

	exit(json_encode($results));
	}

}
?>