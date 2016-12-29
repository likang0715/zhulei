<?php
/**
 *  商品搜索
 */
require_once dirname(__FILE__).'/global.php';

$store_id = isset($_GET['store_id']) ? $_GET['store_id'] : pigcms_tips('您输入的网址有误','none');

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
$limit = 7;
//当前分页
$page = intval($_GET['page']);
if($page < 1) $page=1;


//当前页面的地址
$now_url = $config['wap_site_url'].'/guanzhu.php?store_id='.$now_store['store_id'].'&ajax=1&page='.$page;

$types = $_GET['types'];
if($types == '') {
	$store_id = $store_id;	
	$type=2;
} else{
	$store_id = $store_id;
	$data_type=2;
	
}

$page_url = "guanzhu.php?store_id=".$store_id."&ajax=1";
//$where = array('data_type' => $data_type, 'data_id' => $store_id);
$where = "ua.data_type='".$data_type."' and ua.data_id='".$store_id."'";

if($_REQUEST['ajax']=='1') {
	if($types == 'shoucang') {
		$where = "ua.type='2' and ua.dataid='".$store_id."'";
		$counts = D('')->table('User_collect as ua')->field('count(1) as count')->where($where)->find();
		D('Store')->data(array('collect'=>$counts['count']))->where("store_id = '".$store_id."'")->save();
	
		$count = $counts['count'];
		// 分页
		$total_page = ceil($count / $limit);
		$offset = ($page - 1) * $limit;
	
		$guanzhu_list2 = D('')->table("User_collect as ua")->join("User as u on ua.user_id=u.uid","left")->where($where)->field("ua.*,u.nickname,u.avatar,u.last_time")->limit($offset . ', ' . $limit)->select();
	} else {
		$count = D('Subscribe_store')->where(array('store_id' => $store_id))->count();
		D('Store')->data(array('attention_num'=>$count))->where("store_id = '" . $store_id . "'")->save();
	
		// 分页
		$total_page = ceil($count / $limit);
		$offset = ($page - 1) * $limit;
	
		$guanzhu_list2 = D('Subscribe_store AS ss')->join("User as u on ss.uid = u.uid")->where("ss.store_id = '" . $store_id . "'")->field("ss.user_subscribe_time as add_time, u.nickname,u.avatar,u.last_time")->limit($offset . ', ' . $limit)->select();
	}
	
	foreach($guanzhu_list2 as $k=>$v) {
		$guanzhu_list2[$k]['nickname'] = anonymous($v['nickname']);
		$guanzhu_list2[$k]['avatar'] = $v['avatar']?$v['avatar']:$config['site_url'].'/upload/images/touxiang.png';
	}
	$json_return['count'] = $count;
	$json_return['sql'] = $sqls;
	$json_return['list'] = $guanzhu_list2;
	//$json_return['userlist'] = $user_list;
	$comment_url = 'comment.php?action=comment_by_order&id=' . $store_id;
	
	$json_return['url'] = array(
		'comment_url' => $comment_url,
	);
	
	if(count($guanzhu_list2) < $limit){
		$json_return['noNextPage'] = true;
	} 
 	if(ceil($count / $limit) == $page) {
		$json_return['noNextPage'] = true;
	} 
	$json_return['max_page'] = ceil($count / $limit);
	json_return(0, $json_return);
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

include display('guanzhu');

echo ob_get_clean();
?>