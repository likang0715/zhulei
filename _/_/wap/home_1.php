<?php

/**
 *  店铺主页
 */
require_once dirname(__FILE__) . '/global.php';
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


//粉丝分享默认成为分销商
if ($_GET['uid']) {
    $store_supplier = M('Store_supplier');
    $getAllSellerList = $store_supplier->getAllSellerId($store_id);
    $new_seller_arr = array();
    foreach ($getAllSellerList as $v) {
	$new_seller_arr[] = $v['seller_id'];
    }

    $_condition['store_id'] = array('in', $new_seller_arr);
    $store_list = D('Store')->where($_condition)->select();

    $user_list = array();
    foreach ($store_list as $v) {
	$user_list[] = $v['uid'];
    }
    if (!in_array($_GET['uid'], $user_list)) {
	$uid = $_GET['uid'];
	$common_data = M('Common_data');
	$sale_category = M('Sale_category');

	$user = D('User')->field('uid,nickname,avatar')->where(array('uid' => $_GET['uid']))->find();
	$store = D('Store')->field('store_id,name,open_drp_approve,sale_category_id,sale_category_fid,open_nav,drp_level,open_drp_subscribe_auto,drp_subscribe_tpl,open_drp_subscribe,reg_drp_subscribe_tpl,reg_drp_subscribe_img,drp_subscribe_img')->where(array('store_id' => $store_id))->find();
	$supplier_id = $store_id;
	$name = !empty($user['nickname']) ? $user['nickname'] : $store['name'] . '分店';
	$linkname = $user['nickname'];
	$avatar = $user['avatar'];
	$drp_level = ($store['drp_level'] + 1); //分销级别

	$data = array();
	$data['uid'] = $uid;
	$data['name'] = $name;
	$data['sale_category_id'] = $store['sale_category_id'];
	$data['sale_category_fid'] = $store['sale_category_fid'];
	$data['linkman'] = $linkname;
	$data['tel'] = '';
	$data['status'] = 1;
	$data['qq'] = '';
	$data['drp_supplier_id'] = $supplier_id;
	$data['date_added'] = time();
	$data['drp_level'] = $drp_level;
	$data['logo'] = $avatar;
	$data['open_nav'] = $store['open_nav'];
	$data['bind_weixin'] = 0;
	$data['open_drp_diy_store'] = 0;
	$data['drp_diy_store'] = 0;
	if (!empty($store['open_drp_approve'])) {
	    $data['drp_approve'] = 0; //需要审核
	}

	$store['drp_subscribe_img'] = !empty($store['drp_subscribe_img']) ? $store['drp_subscribe_img'] : getAttachmentUrl('images/drp_ad_01.png');

	$result = M('Store')->create($data);
	if (!empty($result['err_code'])) { //店铺添加成功
	    $common_data->setStoreQty();

	    $store_id2 = $result['err_msg']['store_id']; //分销商id
	    //用户店铺数加1
	    M('User')->setStoreInc($uid);
	    //设置为卖家
	    M('User')->setSeller($uid, 1);

	    //主营类目店铺数加1
	    $sale_category->setStoreInc($store['sale_category_id']);
	    $sale_category->setStoreInc($store['sale_category_fid']);

	    $current_seller = $store_supplier->getSeller(array('seller_id' => $store_id2));
	    if ($current_seller['supplier_id'] != $supplier_id) {
		$seller = $store_supplier->getSeller(array('seller_id' => $supplier_id)); //获取上级分销商信息
		if (empty($seller['type'])) { //全网分销的分销商
		    $seller['supply_chain'] = 0;
		    $seller['level'] = 0;
		}
		$seller['supply_chain'] = !empty($seller['supply_chain']) ? $seller['supply_chain'] : 0;
		$seller['level'] = !empty($seller['level']) ? $seller['level'] : 0;
		$supply_chain = !empty($supplier_id) ? $seller['supply_chain'] . ',' . $supplier_id : 0;
		$level = $seller['level'] + 1;
		$store_supplier->add(array('supplier_id' => $supplier_id, 'seller_id' => $store_id2, 'supply_chain' => $supply_chain, 'level' => $level, 'type' => 1)); //添加分销关联关系
	    }

	    $common_data->setDrpSellerQty();

	    $return = array();
	    $store['drp_subscribe_tpl'] = !empty($store['drp_subscribe_tpl']) ? $store['drp_subscribe_tpl'] : '尊敬的 {$nickname}, 您已成为 {$store} 第 {$num} 位分销商，点击管理店铺。';

	    if (stripos($store['drp_subscribe_tpl'], '{$num}') !== false) {
		$sellers = $store_supplier->getSubSellers($supplier_id);
		$seller_num = count($sellers);
		$content = str_replace(array('{$nickname}', '{$store}', '{$num}'), array($user['nickname'], $store['name'], $seller_num), $store['drp_subscribe_tpl']);
	    } else if (preg_match('/\{\$num=(\d+)\}/i', $store['drp_subscribe_tpl'])) {
		$sellers = $store_supplier->getSubSellers($supplier_id);
		global $global_seller_num;
		$global_seller_num = count($sellers);
		$content = str_replace(array('{$nickname}', '{$store}'), array($user['nickname'], $store['name']), $store['drp_subscribe_tpl']);
		$content = preg_replace_callback('/\{\$num=(\d+)\}/i', function($num) {
		    global $global_seller_num;
		    $num[1] = !empty($num[1]) ? $num[1] : 0;
		    return $num[1] + $global_seller_num;
		}, $content);
	    }
	    //$return[] = array($content, '', $store['drp_subscribe_img'], option('config.wap_site_url') . '/home.php?id=' . $store_id);
	    //dump($return);
	    //return array($return, 'news');
	}
    }
}

$fans_forever_uid = $_SESSION['wap_user']['uid'] ? $_SESSION['wap_user']['uid'] : $_SESSION['user']['uid'];

//粉丝终身制start
if ($fans_forever_uid != $now_store['uid']&&$_GET['new_status']) {
    echo 1111;exit;
    $_where['uid'] = $fans_forever_uid;
    $sub_info = D('Subscribe_store')->where($_where)->order('subscribe_time asc')->find();
    if (!$sub_info && $now_store['setting_fans_forever']) {
	$_condition['uid'] = $fans_forever_uid;
	$result = D('Subscribe_store')->where($_condition)->find();
	$store_list = D('Store')->where($_condition)->select();
	$new_storeId_arr = array();
	foreach ($store_list as $v) {
	    $new_storeId_arr[] = $v['store_id'];
	}
	if (!$result) {
	    $data['uid'] = $fans_forever_uid;
	    if (strpos($_SERVER['PHP_SELF'], 'home.php') !== false) {
		if (!in_array($_GET['id'], $new_storeId_arr)) {
		    $data['store_id'] = $_GET['id'];
		}
	    } else if (strpos($_SERVER['PHP_SELF'], 'good.php') !== false) {
		$product_info = D('Product')->getOne($_GET['id']);
		$data['store_id'] = $product_info['store_id'];
	    }

	    $data['subscribe_time'] = time();
	    D('Subscribe_store')->data($data)->add();
	}
    } else {
	if (strpos($_SERVER['PHP_SELF'], 'home.php') !== false) {
	    if ($_GET['id'] != $sub_info['store_id']) {
		$url = $config['site_url'] . '/wap/home.php?id=' . $sub_info['store_id'];
		echo redirect($url);
		exit;
	    }
	} else if (strpos($_SERVER['PHP_SELF'], 'good.php') !== false) {
	    if ($_GET['store_id'] != $sub_info['store_id']) {
		$url = $config['site_url'] . '/wap/home.php?id=' . $sub_info['store_id'];
		echo redirect($url);
		exit;
	    }
	}
    }
}
//粉丝终身制end


if (empty($now_store)) {
    pigcms_tips('您访问的店铺不存在', 'none');
}


if (!empty($now_store['top_supplier_id']) && empty($now_store['drp_diy_store'])) {

    $tmp_store_id = $now_store['top_supplier_id'];
} else {

    $tmp_store_id = $store_id;
}


//首页的微杂志
$homePage = D('Wei_page')->where(array('is_home' => 1, 'store_id' => $tmp_store_id))->find();

if (empty($homePage)) {
    pigcms_tips('您访问的店铺没有首页', 'none');
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
$drp_notice = false;
$is_seller = false; //是否是分销商
$drp_register_url = '';
$seller_name = ''; //分销商
if (!empty($_SESSION['wap_user']['uid']) && !empty($now_store['open_drp_guidance']) && $_SESSION['wap_user']['uid'] != $now_store['uid']) {
    $user = M('User');
    $avatar = $user->getAvatarById($_SESSION['wap_user']['uid']);
    //判断是否开启分销
    $allow_drp = option('config.open_store_drp');

    $supply_chain = D('Store_supplier')->field('supply_chain')->where(array('seller_id' => $store_id, 'type' => 1))->find();
    $supply_chain = explode(',', $supply_chain['supply_chain']);
    $stores = D('Store')->where(array('uid' => $_SESSION['wap_user']['uid']))->select();
    $user_stores = array();
    $supply_chain2 = array();
    if (!empty($stores)) {
	foreach ($stores as $tmp_store) {
	    $tmp_supply_chain2 = D('Store_supplier')->field('supply_chain')->where(array('seller_id' => $tmp_store['store_id']))->find();
	    $tmp_supply_chain2 = explode(',', $tmp_supply_chain2['supply_chain']);
	    if (in_array($tmp_store['store_id'], $supply_chain)) { //当前店铺上级
		$supplier_id = $tmp_store['store_id'];
		//$allow_drp = false;
		break;
	    }
	    $supply_chain2[$tmp_store['store_id']] = $tmp_supply_chain2;
	}
	if (!empty($supply_chain2)) {
	    foreach ($supply_chain2 as $tmp_seller_id => $tmp_supply_chain2) {
		if (in_array($store_id, $tmp_supply_chain2)) { //当前店铺下级
		    $supplier_id = $tmp_seller_id;
		    //$allow_drp = false;
		    break;
		}
	    }
	}
    }

    if ($allow_drp) {
	$store_supplier = M('Store_supplier');
	//最大分销级别
	$max_store_drp_level = option('config.max_store_drp_level'); //最大分销级别
	if ($now_store['uid'] != $_SESSION['wap_user']['uid']) { //他人店铺
	    //判断是否已经是分销商
	    $seller_store = D('Store')->where(array('drp_supplier_id' => $store_id, 'uid' => $_SESSION['wap_user']['uid'], 'status' => 1))->find();
	    $seller = $store_supplier->getSeller(array('seller_id' => $store_id, 'type' => 1));
	    if (!empty($seller_store)) {
		$seller_info = D('Store')->field('store_id,name')->where(array('store_id' => $seller_store['store_id']))->find();
		$seller_name = $seller_info['name'];
		$is_seller = true;
		$drp_notice = true;
		$drp_register_url = './drp_register.php?id=' . $seller_store['store_id'];
	    } else if (((!empty($seller) && $seller['level'] <= $max_store_drp_level) || empty($seller)) && empty($seller_store)) { //在最大分销级别内
		$drp_notice = true;
		$drp_register_url = './drp_register.php?id=' . $store_id;
	    }
	} else {//自己店铺
	    //判断是否已经是分销商
	    $seller_store = D('Store')->where(array('drp_supplier_id' => $store_id, 'uid' => $_SESSION['wap_user']['uid'], 'status' => 1))->find();
	    if (!empty($seller_store)) {
		$seller_info = D('Store')->field('store_id,name')->where(array('store_id' => $seller_store['store_id']))->find();
		$seller_name = $seller_info['name'];
		$is_seller = true;
		$drp_notice = true;
		$drp_register_url = './drp_register.php?id=' . $seller_store['store_id'];
	    }
	}

	if (!empty($supplier_id) && empty($is_seller)) {
	    $seller_info = D('Store')->field('store_id,name')->where(array('store_id' => $supplier_id))->find();
	    $seller_name = $seller_info['name'];
	    $is_seller = true;
	    $drp_notice = true;
	    $drp_register_url = './drp_register.php?id=' . $seller_info['store_id'];
	}

	if (!empty($now_store['open_drp_limit']) && !empty($now_store['drp_limit_buy'])) {
	    $msg = '亲爱的 <span style="color:#26CB40">' . $_SESSION['wap_user']['nickname'] . '</span>，在本店消费满 <span style="color:red">' . $now_store['drp_limit_buy'] . '</span> 元，即可申请分销！';
	} else {
	    $msg = '亲爱的 <span style="color:#26CB40">' . $_SESSION['wap_user']['nickname'] . '</span>，申请分销即可分销赚佣金！';
	}

	if ($now_store['setting_canal_qrcode']) {
	    $msg = '由分销商' . $now_store['name'] . '推荐，' . $_SESSION['wap_user']['nickname'] . '成为粉丝';
	}
    }
}

//分享配置 start
$share_conf = array(
    'title' => $now_store['name'], // 分享标题
    'desc' => str_replace(array("\r", "\n"), array('', ''), !empty($now_store['intro']) ? $now_store['intro'] : $now_store['name']), // 分享描述
    'link' => $now_store['url'], // 分享链接
    'imgUrl' => $now_store['logo'], // 分享图片链接
    'type' => '', // 分享类型,music、video或link，不填默认为link
    'dataUrl' => '', // 如果type是music或video，则要提供数据链接，默认为空
);

if ($now_store['is_fanshare_drp']) {
    $share_conf['link'] .= '&uid=' . $_SESSION['wap_user']['uid'];
}


import('WechatShare');
$share = new WechatShare();
$shareData = $share->getSgin($share_conf);


//分享配置 end

include display('home');

echo ob_get_clean();
?>