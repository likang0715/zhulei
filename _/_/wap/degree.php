<?php
/**
 *  订单信息
 */
require_once dirname(__FILE__).'/global.php';

$store_id = $_GET['id'];
$page = max(1, $_GET['page']);
$limit = 5;

//店铺资料
$now_store = M('Store')->wap_getStore($store_id);

if(empty($now_store)) pigcms_tips('您访问的店铺不存在','none');
//查询该店铺的 供货商
if($now_store['drp_supplier_id']!='0') {
    //顶级供货商店铺id
    $store_supplier = M('Store_supplier')->getSeller(array( 'seller_id'=> $store_id, 'type'=>'1' ));
    if($store_supplier['supply_chain']){
        $seller_store_id_arr = explode(',',$store_supplier['supply_chain']);
        $store_id = $seller_store_id_arr[1];
        $now_store = M('Store')->wap_getStore($store_id);
        if(empty($now_store)) pigcms_tips('您访问的店铺不存在','none');
    }
}

//获取用户在该店铺已经拥有的积分
$uid = $wap_user['uid'];
$user_point_info = D('Store_user_data')->where(array('uid'=>$uid,'store_id'=>$store_id))->find();

//会员到期剩余
if(strtotime(trim($user_point_info['degree_date']))) {
    $user_point_info['sytime'] = ceil( (strtotime(trim($user_point_info['degree_date'])) - time())/86400);
} else {
    $user_point_info['sytime'] = "0";
}

$avator = M('User')->getAvatarById($uid);

$avator = $avator ? $avator : option('config.site_url') . '/static/images/default_shop_2.jpg';

//是否兑换过积分
$exchange = D('User_points')->where(array('uid'=>$uid,'store_id'=>$store_id,'type'=>11))->find();

//判断用户在该店铺的会员等级
//$userDegree = M('User_degree')->getUserDegree($uid,$store_id);
$userDegree = M('Store_user_data')->getUserData($store_id, $wap_user['uid']);
/*if($userDegree['level_pic']) {
	if(preg_match('/^images\//',$userDegree['level_pic'])) {
		$userDegree['level_pic'] = getAttachmentUrl($userDegree['level_pic']);	
	} else {
		$userDegree['level_pic'] = option('config.site_url').'/'.$userDegree['level_pic'];
	}
} else {
	
}*/

$where_sql = '';
if ($uid) {
    $where_sql .= "(`uid` = '$uid' )";
}






//顶级供应商 会员等级标签
$tag = M('User_degree');
$where_sql = array('store_id'=>$store_id);
$count =  M('User_degree')->getCount($where_sql);
$store_tag_list = $tag->getList($where_sql);



$orderList = array();
$pages = '';
$physical_list = array();
$store_contact_list = array();
if ($count > 0) {
    $limit  = "10";
    $page = min($page, ceil($count / $limit));
    $offset = ($page - 1) * $limit;
    $store_tag_list = $tag->getList($where_sql,	"level_num desc",	$limit,	  $offset );

    // 分页
    import('source.class.user_page');
    $user_page = new Page($count, $limit, $page);
    $pages = $user_page->show();
}
//echo "<pre>";
//print_r($store_tag_list);exit;

//分享配置 start
$share_conf 	= array(
    'title' 	=> option('config.site_name').'-用户中心', // 分享标题
    'desc' 		=> str_replace(array("\r","\n"), array('',''),  option('config.seo_description')), // 分享描述
    'link' 		=> 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], // 分享链接
    'imgUrl' 	=> option('config.site_logo'), // 分享图片
    'type'		=> '', // 分享类型,music、video或link，不填默认为link
    'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);
//分享配置 end

include display('degree');
echo ob_get_clean();
?>