<?php

/**
 *  店铺主页
 */
require_once dirname(__FILE__) . '/global.php';
import('source.class.Drp');
//setcookie('pigcms_sessionid','',$_SERVER['REQUEST_TIME']-10000000,'/');
//$_SESSION = null;
//session_destroy();

//$now_store = M('Store')->wap_getStore($store_id);
$store_id = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误', 'none');
// 预览切换
if (!$is_mobile && $_SESSION['user'] && option('config.synthesize_store')) {
    if (isset($_GET['ps']) && $_GET['ps'] == '800') {
		$config = option('config');

		$url = $config['site_url'] . '/index.php?c=store&a=index&id=' . $store_id . '&is_preview=1';
		echo redirect($url);
		exit;
    }

}

//店铺资料
$now_store = M('Store')->wap_getStore($store_id);
//供货商id
$root_supplier_id = $now_store['root_supplier_id'];

//粉丝终身制
if ($now_store['setting_fans_forever']) {

}


if (empty($now_store)) {
    pigcms_tips('您访问的店铺不存在', 'none');
}


if (!empty($now_store['root_supplier_id'])) {
    $tmp_store_id = $now_store['root_supplier_id'];
} else {
    $tmp_store_id = $store_id;
}
$dianzan_url = 'subject_ajax.php?type=dianzan&store_id= '. $store_id .'&top_store_id='.$tmp_store_id;

//首页的微杂志
$homePage = D('Wei_page')->where(array('is_home' => 1, 'store_id' => $tmp_store_id))->find();

if (empty($homePage)) {
	pigcms_tips('您访问的店铺没有首页', 'none');
}

//分享得积分
if (!empty($_GET['key'])) {
	M('Share_record')->addPoints($_GET['key']);
}

//新增活动主页跳转
switch($homePage['type']) {
	
	//团购
	case '1':
			$url = $config['site_url'] . '/webapp/groupbuy/#/main/'.$tmp_store_id;
			echo redirect($url);
		break;
	
	//一元夺宝
	case '2':
			//$url = "";
			//echo redirect($url);
		break;
}


setcookie('wap_store_id', $now_store['store_id'], $_SERVER['REQUEST_TIME'] + 10000000, '/');

//当前页面的地址
$now_url = $config['wap_site_url'] . '/home.php?id=' . $now_store['store_id'];

//微杂志的自定义字段
if ($homePage['has_custom']) {
    $homeCustomField = M('Custom_field')->getParseFields($tmp_store_id, 'page', $homePage['page_id'], $store_id, $now_store['drp_level'], $now_store['drp_diy_store']);
}

//公共广告判断
$pageHasAd = false;
if ($now_store['open_ad'] && !empty($now_store['use_ad_pages'])) {
    $useAdPagesArr = explode(',', $now_store['use_ad_pages']);
    if (in_array('5', $useAdPagesArr)) {
	    $pageAdFieldArr = M('Custom_field')->getParseFields($tmp_store_id, 'common_ad', $tmp_store_id, $store_id, $now_store['drp_level'], $now_store['drp_diy_store']);
        if (!empty($pageAdFieldArr)) {
            $pageAdFieldCon = '';
            foreach ($pageAdFieldArr as $value) {
                $pageAdFieldCon .= $value['html'];
            }
            $pageHasAd = true;
        }
	    $pageAdPosition = $now_store['ad_position'];
    }
}

//店铺导航
if ($now_store['open_nav'] && !empty($now_store['use_nav_pages'])) {
    $useNavPagesArr = explode(',', $now_store['use_nav_pages']);
    if (in_array('1', $useNavPagesArr)) {
		$storeNav = M('Store_nav')->getParseNav($tmp_store_id, $store_id, $now_store['drp_diy_store']);
    }
}

//会员头像
$avatar = M('User')->getAvatarById($_SESSION['wap_user']['uid']);

$drp_register_url    = '';
//判断是否开启分销
$allow_drp           = false;
$allow_drp_register = false;
$allow_drp_manage = false;
$drp_button = '';
$is_sub_seller = false; //是否是当前店铺下级分销商
Drp::init(); //初始化
$visitor = Drp::checkID($store_id, $_SESSION['wap_user']['uid']);
if ($visitor['data']['store_id'] == $store_id) {
	$allow_drp = $visitor['data']['allow_drp'];
	$msg = '亲爱的 <span class="nickname">' . $_SESSION['wap_user']['nickname'] . '</span>，欢迎回来。';
	if (!empty($now_store['drp_supplier_id'])) {
		$drp_button = '分销管理';
		$drp_register_url = './drp_register.php?id=' . $store_id;
	}
} else if (!empty($visitor) && !empty($visitor['data']['allow_drp_register'])) {
	$msg = $visitor['msg'];
	$allow_drp = $visitor['data']['allow_drp'];
	$allow_drp_register = $visitor['data']['allow_drp_register'];
	$drp_button = '立即申请';
	$drp_register_url = './drp_register.php?id=' . $store_id;
	//不满足分销限制条件
	if (!empty($visitor['data']['drp_limit_buy'])) {
		$drp_button = '';
	}
} else if (!empty($visitor) && !empty($visitor['data']['allow_drp_manage'])) {
	$msg = $visitor['msg'];
	$allow_drp = $visitor['data']['allow_drp'];
	$allow_drp_manage = true;
	if ($store_id != $visitor['data']['store_id']) {
		$drp_button = '返回店铺';
		$drp_register_url = './home.php?id=' . $visitor['data']['store_id'];
	} else {
		$drp_button = '分销管理';
		$drp_register_url = './drp_register.php?id=' . $visitor['data']['store_id'];
	}
	$avatar = $visitor['data']['logo'];
} else if (!empty($visitor) && $visitor['data']['status'] == 1) {
	if ($visitor['data']['drp_approve'] != 1) {
		$msg = "亲爱的 <span class='nickname'>" . $visitor['data']['name'] . "</span>， " . $visitor['msg'];
		$allow_drp = $visitor['data']['allow_drp'];
		$avatar = $visitor['data']['logo'];
	}
}

if($now_store['is_point_mall'] || empty($visitor['data']['drp_guidance'])) {
	$allow_drp = false;
}

//分享配置 start
$share_conf = array(
		'title'    => $now_store['name'], // 分享标题
		'desc'     => str_replace(array("\r", "\n"), array('', ''), !empty($now_store['intro']) ? $now_store['intro'] : $now_store['name']), // 分享描述
		'link'     => $now_store['url'], // 分享链接
		'imgUrl'   => $now_store['logo'], // 分享图片链接
		'type'     => '', // 分享类型,music、video或link，不填默认为link
		'dataUrl'  => '', // 如果type是music或video，则要提供数据链接，默认为空
);
//分享配置 end


//有分销商
if (!empty($visitor['drp_supplier_id'])) {
	$supply_chain = D('Store_supplier')->field('supply_chain,level')->where(array('seller_id' => $visitor['store_id'], 'type' => 1))->find();
	if (!empty($supply_chain)) {
		$chain = explode(',', $supply_chain['supply_chain']);
		if (in_array($store_id, $chain)) { //是当前店铺的下级分销商
			$is_sub_seller = true;
		}
	}
}


//分享限制标识
$share_limit_flag 	= true;
if (!empty($visitor) && empty($visitor['data']['allow_drp_register'])) {
	//未达到限制分销条件
	$share_limit_flag 	= false;
}


//分享自动成为分销商标识
$flag = false;
//开启分享 并且 达到分销限制条件
if($now_store['is_fanshare_drp'] && $share_limit_flag){
	$flag = true;
}

//已经是分销商 分销自己的分销店铺
if(!empty($is_sub_seller)){
	$share_conf = array(
			'title'    => $visitor['data']['name'], // 分享标题
			'desc'     => str_replace(array("\r", "\n"), array('', ''), !empty($visitor['data']['intro']) ? mb_substr($visitor['data']['intro'], 0, 20, 'UTF-8') : $visitor['data']['name']), // 分享描述
			'link'     => option('config.wap_site_url') . '/home.php?id=' . $visitor['data']['store_id'], // 分享链接
			'imgUrl'   => $visitor['data']['logo'], // 分享图片链接
			'type'     => '', // 分享类型,music、video或link，不填默认为link
			'dataUrl'  => '', // 如果type是music或video，则要提供数据链接，默认为空
			'store_id' => '',
			'uid'      => ''
	);
}else if($flag){
	$share_conf['store_id'] = $store_id;
	$share_conf['uid']      = $_SESSION['wap_user']['uid'];
}

import('WechatShare');
$share = new WechatShare();
$shareData = $share->getSgin($share_conf);

include display('home');

echo ob_get_clean();
?>