<?php
/**
 *  商品搜索
 */
require_once dirname(__FILE__).'/global.php';

$store_id = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误','none');
$sid = $_GET['sid'];
$page_url = 'subtype.php?id=' . $store_id."&sid=".$sid;

$page = max(1, $_REQUEST['page']);
$post_page = $page;
$limit = 3;

//店铺资料
$now_store = M('Store')->wap_getStore($store_id);
if(empty($now_store)) pigcms_tips('您访问的店铺不存在','none');

if (!empty($now_store['top_supplier_id']) && empty($now_store['drp_diy_store'])) {
	$tmp_store_id = $now_store['top_supplier_id'];
} else {
	$tmp_store_id = $store_id;
}

//当前搜索词
$key = $_GET['q'];
$dianzan_url = 'subject_ajax.php?type=dianzan&store_id= '. $store_id."&top_store_id=".$tmp_store_id;

//店铺导航
if ($now_store['open_nav'] && !empty($now_store['use_nav_pages'])) {
	$useNavPagesArr = explode(',', $now_store['use_nav_pages']);
	if (in_array('1', $useNavPagesArr)) {
		$storeNav = M('Store_nav')->getParseNav($tmp_store_id, $store_id, $now_store['drp_diy_store']);
	}
}


//获取指定专题内容
$subtype_model = M('Subtype');
$subject_model = M('Subject');
$subtype_where = array('status'=>1,store_id=>$tmp_store_id,'topid'=>array('>',0));
$subtype_info = M('Subtype')->getLists($subtype_where,false,'px asc');
//echo "<pre>";
//print_r($subtype_info);
//专题分类信息
$subtype_infos = D('Subtype')->where(array('id'=>$sid))->find();

$where = array('store_id'=>$tmp_store_id,'subject_typeid'=>$sid);
$count = $subject_model->getCount($where);


if ($count > 0) {
	$page = min($page, ceil($count / $limit));
	$offset = ($page - 1) * $limit;
	
	//$orderList = D('Order')->where($where_sql)->order('order_id desc')->limit($offset . ', ' . $limit)->select();	
	

		$subject_list = $subject_model->getList($where,$order_by,$limit,$offset,true);
		foreach($subject_list as $k=>&$v) {
			$user_collect = D("User_collect")->where(array('type'=>3,'store_id'=>$store_id,'user_id'=>$_SESSION['wap_user']['uid'],'dataid'=>$v[id]))->find();
			if($user_collect) {
				$v['is_dianzan'] = 1;
			} else {
				$v['is_dianzan'] = 0;
			}
		}
		if(is_array($subject_arr)) {
			//D("User_collect")->where(array('type'=>3,'store_id'=>$store_id,'user_id'=>$uid,'dataid'=>array('')))
		}
		if($_REQUEST['ajax'] == '1') {		
			$json_return['count'] = $count;
			$json_return['other_info'] = $count;
			$json_return['list'] = $subject_list;
			$json_return['now_store_id'] = $store_id;
			if((count($subject_list) < $limit) || (ceil($count / $limit) == $post_page)){
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
		$json_return['now_store_id'] = $store_id;
		
		if(count($subject_list) < $limit){
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

include display('subtype');

echo ob_get_clean();
?>