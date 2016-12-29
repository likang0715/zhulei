<?php
/**
 *  商品搜索
 */
require_once dirname(__FILE__).'/global.php';

$store_id = isset($_GET['store_id']) ? $_GET['store_id'] : pigcms_tips('您输入的网址有误','none');
$now_store_id = $store_id;
$subject_id = $_GET['subject_id'];
$page_url = 'subinfo.php?store_id=' . $store_id."&subject_id=".$subject_id;
$pinlun_url = 'subinfo_pinlun.php?store_id=' . $store_id."&subject_id=".$subject_id;

$page = max(1, $_REQUEST['page']);
$limit = 2;
//店铺资料
$now_store = M('Store')->wap_getStore($store_id);

if (!empty($now_store['top_supplier_id']) && empty($now_store['drp_diy_store'])) {
	$tmp_store_id = $now_store['top_supplier_id'];
} else {
	$tmp_store_id = $store_id;
}
//供货商
$top_store_id = $tmp_store_id;

$top_store = array();
if (!$store_id) {
	$tmp_store_id = intval(trim($store_id));
	$top_store = D('Store')->where(array('store_id'=>$store_id))->find();
} else {
	$tmp_store_id = $store_id;
}
$dianzan_url = 'subject_ajax.php?type=dianzan&store_id= '. $store_id . '&subject_id='.$subject_id."&top_store_id=".$top_store_id;

if(empty($now_store)) pigcms_tips('您访问的店铺不存在','none');
//当前搜索词
$key = $_GET['q'];
//当前分页
if($page < 1) $page=1;

//商品搜索

//获取指定专题内容
$subtype_model = M('Subtype');
$subject_model = M('Subject');
$subject_comment_model = M('Subject_comment');

$subject_info = M('Subject')->get(array('id'=>$subject_id));
$subject_product_model = M('Subject_product');

//获取用户是否已经点赞
if(D('User_collect')->where(array('user_id'=>$wap_user[uid],'dataid'=>$subject_id,'store_id'=>$store_id,'type'=>3))->find()) {
	$dz_status = 1;
} else {
	$dz_status = 0;
}

//获取该店铺 该专题点赞总数
$store_dz = D('Store_subject_data')->where(array('store_id'=>$store_id,'subject_id'=>$subject_id))->find();
$dz_count = $store_dz['dz_count'] ? $store_dz['dz_count']:0;
$share_count = $store_dz['share_count'] ? $store_dz['share_count'] : 0;
//专题评论数
//$where1 = "sc.store_id='".$store_id."' and sc.subject_id = '".$subject_id."'";
//$subject_comment_count = $subject_comment_model->getCount($where1);
$subject_comment_count = $store_dz['pinlun_count'] ? $store_dz['pinlun_count']:0;;


////////////

$where = " sp.subject_id = '".$subject_id."'";

$offset = 0;
$count = $subject_product_model->getCount($where);
$drp_level           = $now_store['drp_level']; //当前分销级别
$max_store_drp_level = option('config.max_store_drp_level'); //最大分销级别,0或空为无限级分销
$seller_drp_level    = $drp_level + 1; //下级分销商级别

$order_by = "";
if ($count > 0) {
	$page = min($page, ceil($count / $limit));
	$offset = ($page - 1) * $limit;
	
	//$orderList = D('Order')->where($where_sql)->order('order_id desc')->limit($offset . ', ' . $limit)->select();	
	$subject_product_list = $subject_product_model->getList($where,$order_by,$limit,$offset,true);
	if($_REQUEST['ajax'] == '1') {
		$json_return['count'] = $count;
		$json_return['now_store_id'] = $store_id;
		
		foreach($subject_product_list as $k=>&$v) {
			$maxPrice = 0;
			$minPrice = $v['price'];
			if (!empty($v['unified_price_setting']) && empty($now_store['drp_diy_store']) && $v['is_fx']) { //分销商的价格
				$minPrice = ($v['drp_level_' . ($now_store['drp_level'] <= 3 ? $now_store['drp_level'] : 3) . '_price'] > 0) ? $v['drp_level_' . ($now_store['drp_level'] <= 3 ? $now_store['drp_level'] : 3) . '_price'] : $v['price'];
				$minPrice = $minPrice;
			} 
			//三级分润
			if ($seller_drp_level > 3) {
				$seller_drp_level = 3;
			}
			$v['now_price'] = ($maxPrice!=0 && $minPrice!=$maxPrice) ? $minPrice.'-'.$maxPrice : $minPrice;
		}
		$json_return['list'] = $subject_product_list;

		if(count($subject_product_list) < $limit){
			$json_return['noNextPage'] = true;
		}
		$json_return['max_page'] = ceil($count / $limit);
		json_return(0, $json_return);
	}
		
	// 分页
	import('source.class.user_page');
	$user_page = new Page($count, $limit, $page);
	$pages = $user_page->show();

} else {
	if($_REQUEST['ajax'] == '1') {
		$json_return['count'] = "0";
		$json_return['list'] = array();

		if(count($subject_product_list) < $limit) {
			$json_return['noNextPage'] = true;
		}
		$json_return['max_page'] = ceil($count / $limit);
		json_return(0, $json_return);	
	}
}



//当前页面的地址
//$now_url = $config['wap_site_url'].'/subtype.php?id='.$now_store['store_id'].'&sid='.$sid.'&q='.urlencode($key).'&page='.$page;
$now_url = $config['wap_site_url'].'/subinfo.php?store_id='.$store_id."&subject_id=".$subject_id;

//店铺导航
if($now_store['open_nav'] && !empty($now_store['use_nav_pages'])){
	$useNavPagesArr = explode(',',$now_store['use_nav_pages']);
	if(in_array('5',$useNavPagesArr)){
		$storeNav = M('Store_nav')->getParseNav($tmp_store_id, $store_id, $now_store['drp_diy_store']);
	}
}

//分享配置 start
$share_conf 	= array(
	'title' 	=> $subject_info['name'], // 分享标题
	'desc' 		=> str_replace(array("\r","\n"), array('',''), $subject_info['description']), // 分享描述
	'link' 		=> $now_url, // 分享链接
	'uid' 		=> $wap_user[uid],
	'store_id'	=> $store_id,
	'types'		=> 'subject',		
	'data_id'   =>  $subject_id,	//操作的对象id
	'imgUrl' 	=> $subject_info[pic] ? $subject_info[pic]: $now_store['logo'], // 分享图片链接
	'type'		=> '', // 分享类型,music、video或link，不填默认为link
	'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);
//分享配置 end

include display('subinfo');

echo ob_get_clean();
?>