<?php
/**
 *  商品搜索
 */
require_once dirname(__FILE__).'/global.php';

$store_id = isset($_GET['store_id']) ? $_GET['store_id'] : pigcms_tips('您输入的网址有误','none');
$now_store_id = $store_id;
$subject_id = $_GET['subject_id'];
$page_url = 'subinfo_pinlun.php?store_id=' . $store_id."&subject_id=".$subject_id;


$page = max(1, $_REQUEST['page']);
$limit = 10;
//店铺资料
$now_store = M('Store')->wap_getStore($store_id);

if (!empty($now_store['top_supplier_id']) && empty($now_store['drp_diy_store'])) {
	$tmp_store_id = $now_store['top_supplier_id'];
} else {
	$tmp_store_id = $store_id;
}
//供货商
$top_store_id = $tmp_store_id;
$add_pinlun_url = 'subject_ajax.php?type=pinlun&top_store_id='.$top_store_id.'&store_id=' . $store_id."&subject_id=".$subject_id;
$top_store = array();
if (!$store_id) {
	$tmp_store_id = intval(trim($store_id));
	$top_store = D('Store')->where(array('store_id'=>$store_id))->find();
} else {
	$tmp_store_id = $store_id;
}

if(empty($now_store)) pigcms_tips('您访问的店铺不存在','none');
//当前搜索词
$key = $_GET['q'];
//当前分页
if($page < 1) $page=1;
//商品搜索

//获取指定专题内容
$subtype_model = M('Subtype');
$subject_model = M('Subject');

$subject_info = M('Subject')->get(array('id'=>$subject_id));

$subject_comment_model = M('Subject_comment');
//$subtype_info = $subtype_model->get($store_id);

$where = "sc.store_id='".$top_store_id."' and sc.subject_id = '".$subject_id."' and sc.is_show=1";

$offset = 0;
$count = $subject_comment_model->getCount($where);

$drp_level           = $now_store['drp_level']; //当前分销级别
$max_store_drp_level = option('config.max_store_drp_level'); //最大分销级别,0或空为无限级分销
$seller_drp_level    = $drp_level + 1; //下级分销商级别

$order_by = "sc.timestamp desc,sc.id desc";
if ($count > 0) {
	$page = min($page, ceil($count / $limit));
	$offset = ($page - 1) * $limit;
	
	//$orderList = D('Order')->where($where_sql)->order('order_id desc')->limit($offset . ', ' . $limit)->select();	
	

		$subject_comment_list = $subject_comment_model->getList($where,$order_by,$limit,$offset,true);
		if($_REQUEST['ajax'] == '1') {		
			$json_return['count'] = $count;
			$json_return['now_store_id'] = $store_id;
			$json_return['list'] = $subject_comment_list;

			if(count($subject_comment_list) < $limit){
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
	
		if(count($subject_comment_list) < $limit){
			$json_return['noNextPage'] = true;
		}
		$json_return['max_page'] = ceil($count / $limit);
		json_return(0, $json_return);	
	}
}



//当前页面的地址
$now_url = $config['wap_site_url'].'/subtype.php?id='.$now_store['store_id'].'&sid='.$sid.'&q='.urlencode($key).'&page='.$page;

//店铺导航
if($now_store['open_nav'] && !empty($now_store['use_nav_pages'])){
	$useNavPagesArr = explode(',',$now_store['use_nav_pages']);
	if(in_array('5',$useNavPagesArr)){
		$storeNav = M('Store_nav')->getParseNav($tmp_store_id, $store_id, $now_store['drp_diy_store']);
	}
}

//分享配置 start
$share_conf 	= array(
	'title' 	=> $now_store['name'], // 分享标题
	'desc' 		=> str_replace(array("\r","\n"), array('',''), $now_store['intro']), // 分享描述
	'link' 		=> option('config.wap_site_url').'/home.php?id=' . $now_store['store_id'], // 分享链接
	'imgUrl' 	=> $now_store['logo'], // 分享图片链接
	'type'		=> '', // 分享类型,music、video或link，不填默认为link
	'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);
//分享配置 end

include display('subinfo_pinlun');

echo ob_get_clean();
?>