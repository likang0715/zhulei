<?php
/**
 *  微页面
 */
require_once dirname(__FILE__).'/global.php';

//微页面id
$page_id = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误','none');

//微页面
$nowPage = D('Wei_page')->where(array('page_id'=>$page_id))->find();
//echo "<pre>";
//print_r($nowPage);
//exit;
if(empty($nowPage)) {
	pigcms_tips('您访问的微杂志不存在','none');
}


//新增活动主页跳转(粉丝终身制？no？)
switch($nowPage['type']) {

	//团购
	case '1':
		$url = $config['site_url'] . '/webapp/groupbuy/#/main/'.$nowPage['store_id'];
		echo redirect($url);
		break;

		//一元夺宝
	case '2':
		//$url = "";
		//echo redirect($url);
		break;
}

//店铺id
if (!empty($_GET['store_id'])) {
	$store_id = intval(trim($_GET['store_id']));
} else {
	$store_id = $nowPage['store_id'];
}

//点赞
$dianzan_url = 'subject_ajax.php?type=dianzan&store_id= '. $nowPage['store_id']."&top_store_id=".$store_id;


//店铺资料
$now_store = M('Store')->wap_getStore($store_id);
//echo "<pre>";
//print_r($now_store);
//exit;

if(empty($now_store)){
	pigcms_tips('您访问的店铺不存在','none');
}

//保存
D('Wei_page')->where(array('page_id' => $page_id))->data(array('hits' => $nowPage['hits'] + 1))->save();





//设置wap_store_id值
setcookie('wap_store_id',$now_store['store_id'],$_SERVER['REQUEST_TIME']+10000000,'/');

//当前页面的地址
if (!empty($_GET['store_id'])) {
	$now_url = $config['wap_site_url'].'/page.php?id='.$nowPage['page_id'] . '&store_id=' . intval(trim($_GET['store_id']));
} else {
	$now_url = $config['wap_site_url'].'/page.php?id='.$nowPage['page_id'];
}


//微杂志的自定义字段
if($nowPage['has_custom']){
	$homeCustomField = M('Custom_field')->getParseFields($nowPage['store_id'],'page',$nowPage['page_id'], $store_id, $now_store['drp_level'], $now_store['drp_diy_store']);
}

//echo "<pre>";
//print_r($nowPage['page_id']);
//exit;

//公共广告判断
$pageHasAd = false;
if($now_store['open_ad'] && !empty($now_store['use_ad_pages'])){
//	echo '123';
	$useAdPagesArr = explode(',',$now_store['use_ad_pages']);
	if(in_array('0',$useAdPagesArr)){
		$pageAdFieldArr = M('Custom_field')->getParseFields($nowPage['store_id'],'common_ad',$nowPage['store_id'], $store_id, $now_store['drp_level'], $now_store['drp_diy_store']);
		if(!empty($pageAdFieldArr)){
			$pageAdFieldCon = '';
			foreach($pageAdFieldArr as $value){
				$pageAdFieldCon .= $value['html'];
			}
			$pageHasAd = true;
//			print_r($pageAdFieldCon);
		}
		$pageAdPosition = $now_store['ad_position'];
	}
}

//店铺导航
if($now_store['open_nav'] && !empty($now_store['use_nav_pages'])){
	$useNavPagesArr = explode(',',$now_store['use_nav_pages']);
	if(in_array('3',$useNavPagesArr)){
		$storeNav = M('Store_nav')->getParseNav($nowPage['store_id'], $store_id, $now_store['drp_diy_store']);
	}
}

//分享配置 start  
$share_conf 	= array(
	'title' 	=> $nowPage['page_name'].'-微页面', // 分享标题
	'desc' 		=> str_replace(array("\r","\n"), array('',''),  $nowPage['page_desc']), // 分享描述
	'link' 		=> $now_url, // 分享链接
	'imgUrl' 	=> $now_store['logo'], // 分享图片链接
	'type'		=> '', // 分享类型,music、video或link，不填默认为link
	'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);
//分享配置 end

include display('page');

echo ob_get_clean();
?>