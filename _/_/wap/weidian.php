<?php
/**
 *  微网站首页
 */
require_once dirname(__FILE__).'/global.php';

$cat_id 	= intval($_GET['cat_id']);
$keyword = $_GET['keyword'];
$tag_id = intval($_GET['tag_id']);

if($cat_id){
	$where 	= array('cat_id'=>$cat_id);
}
$category_list = $sale_category_list = M('Sale_category')->getAllCategory($where);

$model_store = M('Store');

$son_cat_store_list = array();
foreach($sale_category_list as $key=>$value){

	if(empty($value['stores'])){
		unset($sale_category_list[$key]);
	
	}else if(empty($value['cat_list'])){
		$tmp_store_list = $model_store->getWeidianStoreListBySaleCategoryId_location_new($value['cat_id'],6,true);
	    	if(empty($tmp_store_list)){
			unset($sale_category_list[$key]);
		}else{
			$sale_category_list[$key]['store_list'] = $tmp_store_list;
		}
	}else{
	
		$is_have_son = false;
		foreach($value['cat_list'] as $son_cat_key=>$son_cat_value){
		
			if(empty($son_cat_value['stores'])){

				unset($sale_category_list[$key]['cat_list'][$son_cat_key]);
			}else{
				$tmp_store_list = $model_store->getWeidianStoreListBySaleCategoryId_location_new($son_cat_value['cat_id'],6);
				if(empty($tmp_store_list)){
					unset($sale_category_list[$key]['cat_list'][$son_cat_key]);
				}else{
					$is_have_son = true;
					$sale_category_list[$key]['cat_list'][$son_cat_key]['store_list'] = $tmp_store_list;
					$son_cat_store_list[$son_cat_value['cat_id']] = $tmp_store_list;
				}
			}
		}
		if ($is_have_son) {
			$sale_category_list[$key]['cat_list'] = array_values($sale_category_list[$key]['cat_list']);
		} else {
			unset($sale_category_list[$key]);
		}
	}
}

//店铺特色类目
$store_tags_arr = array();
$store_tags = D('Store_tag')->where(array('status'=>1))->order('order_by asc')->select();
foreach ($store_tags as $key => $value) {
	$store_tags_arr[$value['tag_id']] = $value['name'];
}

//统计特殊类目店铺数
//$store_tags_count_tmp_arr = D('Store')->field('tag_id,count(*) as tag_count')->where('tag_id in('.join(',',array_keys($store_tags_arr)).')')->group('tag_id')->select();

$where_tag = " `s`.`status` = 1 AND `s`.`public_display` = '1' AND `s`.`drp_level`=0 and s.is_point_mall=0 AND `s`.`tag_id` in(".join(',',array_keys($store_tags_arr)).")";

$WebUserInfo = show_distance();

if($where_tag) $where_tag = $where_tag ." AND ";

if($WebUserInfo['city_name']) {
   
    $where_tag .= "sc.city=".$WebUserInfo['city_code'];
 
    if($WebUserInfo['area_name']) {
        $where_tag .= " AND sc.county=".$WebUserInfo['area_code'];
    }
     
}

$store_tags_count_tmp_arr = D('')->table("Store s")->field('s.tag_id,count(s.store_id) as tag_count')->join("Store_contact sc On s.store_id=sc.store_id","LEFT")->where($where_tag)->group('s.tag_id')->select();

$store_tags_count_arr = array();
foreach ($store_tags_count_tmp_arr as $key => $value) {
	$store_tags_count_arr[$value['tag_id']] = $value['tag_count'];
}
$store_id = $_GET['id'];
$page = max(1, $_GET['page']);
$limit = 5;

 $where=' 1=1 ';
	if($store_id){
	$now_store = M('Store')->wap_getStore($store_id);
	if(empty($now_store)) pigcms_tips('您访问的店铺不存在','none');
	 $where.= " and store_id = ".$store_id;
	$page_url = 'weidian.php?id=' . $store_id . '&action=' . $action;
	}else{
	$page_url = 'weidian.php?platform=1';
	}
        $where .= " and status = 1";
        $where .= " and public_display = 1";
        $where .= " and drp_level=0";
        $where .= " and is_point_mall=0";
 
  if($_REQUEST['cat_id']){
   $sale_category_id=$_REQUEST['cat_id'];
   $where .= " and ( sale_category_fid = ".$sale_category_id." or sale_category_id = " .$sale_category_id." )";
			}
	
$count = D('Store')->where($where)->count('store_id');	

$pages = '';
	if ($count > 0) {
		$page = min($page, ceil($count / $limit));
		$offset = ($page - 1) * $limit;
		
		$hot_physical = D('Store')->where($where)->order('is_hot DESC,store_id DESC')->limit($offset . ', ' . $limit)->select();
foreach($hot_physical as $key=>$value){
	$hot_physical[$key]['url'] = $config['wap_site_url'].'/home.php?id='.$value['store_id'];
     $tuan = D('Tuan')->field('`name`')->where("store_id = ".$value['store_id'])->order('`id` DESC')->limit(1)->select();
	 foreach($tuan as $k=>$r){
	 $hot_physical[$key]['tuan'] = $r['name'];
	 }
	
     $hui= D('Reward')->field('`name`')->where("store_id = ".$value['store_id'])->order('`id` DESC')->limit(1)->select();
	  foreach($hui as $k=>$r){
	 $hot_physical[$key]['hui'] = $r['name'];
	 }
      }
		
		// 分页
		import('source.class.user_page');
		$user_page = new Page($count, $limit, $page);
		$pages = $user_page->show();
	}



//分享配置 start
$share_conf 	= array(
	'title' 	=> option('config.site_name'), // 分享标题
	'desc' 		=> str_replace(array("\r","\n"), array('',''), option('config.seo_description')), // 分享描述
	'link' 		=> option('config.wap_site_url').'/weidian.php', // 分享链接
	'imgUrl' 	=> option('config.site_logo'), // 分享图片链接
	'type'		=> '', // 分享类型,music、video或link，不填默认为link
	'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);
$noFooterLinks =1 ;
//分享配置 end
if(empty($keyword) && empty($tag_id)) {
	include display('index_weidian');
} else {
	
	include display('index_weidian_detail');
}
echo ob_get_clean();
?>