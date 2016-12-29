<?php
/**
 *  订单信息
 */
require_once dirname(__FILE__).'/global.php';

$cz_id = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误','none');
import('source.class.Margin');
import('source.class.Drp');
// 预览切换
if (!$is_mobile && $_SESSION['user'] && option('config.synthesize_store')) {
    if (isset($_GET['ps']) && $_GET['ps'] == '800') {
        $config = option('config');

        //PC端
        $url = $config['site_url'] . '/index.php?c=meaz&a=baoxiang&id=' . $cz_id . '&is_preview=1';
        echo redirect($url);
        exit;
    }
}

$allow_platform_drp = option('config.open_platform_drp');
$allow_store_drp = option('config.open_store_drp');




$where=array();
$where['cz_id'] = $cz_id;
$meal = D('Meal_cz')->where($where)->find();
$orderwhere=array();
$orderwhere['tableid'] = $cz_id;
$meal_order = D('Meal_order')->where($orderwhere)->select();
foreach($meal_order as $key=>$r){
$users = M('User')->getUserById($r['uid']);
$meal_order[$key]['avatar']=$users['avatar'];
$meal_order[$key]['nickname']=$users['nickname'];
}
$now_store = M('Store')->wap_getStore($meal['seller_id']);
$store_contace = M('Store_contact')->get($now_store['store_id']);
$now_store['tel'] = ($store_contace['phone1'] ? $store_contace['phone1'] . '-' : '') . $store_contace['phone2'];
setcookie('wap_store_id',$now_store['store_id'],$_SERVER['REQUEST_TIME']+10000000,'/');

//当前页面的地址
$now_url = $config['wap_site_url'].'/physical_detail.php?id='.$now_store['store_id'];

//分享配置 start
	$share_conf 	= array(
		'title' 	=> $meal['name'].'-'.$now_store['name'].'-包厢', // 分享标题
		'desc' 		=> str_replace(array("\r","\n"), array('',''),  $meal['description']), // 分享描述
		'link' 		=> 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], // 分享链接
		'imgUrl' 	=> $meal['image'], // 分享图片链接
		'type'		=> '', // 分享类型,music、video或link，不填默认为link
		'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
	);
	import('WechatShare');
	$share 		= new WechatShare();
	$shareData 	= $share->getSgin($share_conf);
	//分享配置 end
	
$is_collect = D('User_collect')->where(array('user_id' => $_SESSION['wap_user']['uid'], 'type' => 4, 'dataid' => $cz_id))->find();
include display('baoxiang');

echo ob_get_clean();
?>