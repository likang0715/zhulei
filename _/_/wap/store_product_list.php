<?php
/**
 *  微网站首页
 */
require_once dirname(__FILE__).'/global.php';
$keyword = $_GET['keyword'];
$store_id = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误','none');
//店铺资料
$now_store = M('Store')->wap_getStore($store_id);
$store_subjet_type_url = 'store_subject_type.php?id=' . $store_id;
$store_product_search_url = 'search.php?store_id='.$store_id;;

//店铺导航
if ($now_store['open_nav'] && !empty($now_store['use_nav_pages'])) {
	$useNavPagesArr = explode(',', $now_store['use_nav_pages']);
	if (in_array('6', $useNavPagesArr)) {
		$storeNav = M('Store_nav')->getParseNav($tmp_store_id, $store_id, $now_store['drp_diy_store']);
	}
}

//store_subject_type.php?id=1
$diy_keywords = D('Subject_diy_keywords')->where(array('store_id'=>$store_id))->find();
if($diy_keywords['content']) {
	$arr_diy_keywords = unserialize($diy_keywords['content']);
} else {
	$arr_diy_keywords = array();
}

$cat_list = M('Product_category')->getAllCategory();
$cat_list = array_values($cat_list);


foreach($cat_list as  $k=>&$v) {
	
	$v['cat_pic'] = getAttachmentUrl($v['cat_pic']);
}

// 查找当前店铺，不能直接用session中的值,session并同步数据库中的值
$store = M('Store')->getStore($store_id);

//分享配置 start
$share_conf 	= array(
	'title' 	=> option('config.site_name'), // 分享标题
	'desc' 		=> str_replace(array("\r","\n"), array('',''), option('config.seo_description')), // 分享描述
	'link' 		=> 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], // 分享链接
	'imgUrl' 	=> option('config.site_logo'), // 分享图片
	'type'		=> '', // 分享类型,music、video或link，不填默认为link
	'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);
//分享配置 end

if(empty($keyword)){
	include display('store_product_list');
}else{
	$key_id = intval($_GET['id']);

	// 顶级分类和子分类
	$product_category_model = M('Product_category');
	$category_detail = $product_category_model->getCategory($key_id);

	$property_list = array();
	if (!empty($category_detail)) {
		$property_list = M('System_product_property')->getPropertyAndValue($category_detail['filter_attr']);
	}

	include display('index_category_detail');
}
echo ob_get_clean();
?>