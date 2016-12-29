<?php

/**
 *  个人中心
 */
require_once dirname(__FILE__) . '/global.php';
import('source.class.Drp');

$store_id = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误', 'none');

if (!empty($_SESSION['wap_user'])) {
    $user = M('User');
    $wap_user = $_SESSION['wap_user'];
    $now_store = D('Store')->where(array('store_id' => $store_id))->find();
    $avatar = $user->getAvatarById($_SESSION['wap_user']['uid']);
} else { //未登陆状态，调用授权
    $user = M('User');
    $now_store = M('Store')->wap_getStore($store_id);
    $wap_user = $_SESSION['wap_user'];
    $avatar = $user->getAvatarById($_SESSION['wap_user']['uid']);
}

if (empty($_SESSION['wap_user'])) {
    redirect('./login.php?referer=' . urlencode($_SERVER['REQUEST_URI']));
}
if (empty($_SESSION['wap_user']['nickname'])) {
    $_SESSION['wap_user']['nickname'] = '匿名用户';
}

setcookie('wap_store_id', $now_store['store_id'], $_SERVER['REQUEST_TIME'] + 10000000, '/');

$order = M('Order');

//是否正常显示推广中心 -1 不显示 0 可申请分销 1 正常显示 >1 状态有误
$drp_center_show = -1;
//供货商id
$root_supplier_id = $store_id;
//推广订单数量（分销订单）
$fx_order_count = 0;
//提示信息
$warning_msg = '抱歉，您还不是本店的分销商';

//初始化
Drp::init();
//访问者身份信息
$visitor = Drp::checkID($store_id, $wap_user['uid']);
if (!empty($visitor['data']['store_id']) && !empty($visitor['data']['drp_supplier_id'])) {
    $_SESSION['wap_drp_store'] = $visitor['data'];
    $root_supplier_id = $visitor['data']['root_supplier_id'];
    if (!empty($visitor['data']['allow_drp_manage'])) {
        $drp_center_show = 1; //正常
        //推广订单数量
        $fx_order_count = $order->getOrderCountByStatus(array('store_id' => $visitor['data']['store_id'], 'status' => array('in', array(2,3,4,6,7))));
    } else if ($visitor['data']['status'] != 1) {
        $drp_center_show = 2; //分销商被禁用
    } else if ($visitor['data']['drp_approve'] != 1) {
        $drp_center_show = 3; //分销商被禁用
    }
    if (empty($visitor['data']['drp_degree_name'])) {
        $visitor['data']['drp_degree_name'] = '默认等级';
    }
    $warning_msg = $visitor['msg'];
} else if (!empty($visitor['data']['allow_drp_register'])) {
    $drp_center_show = 0; //可申请分销
} else if (!empty($visitor['data']['store_id']) && empty($visitor['data']['drp_supplier_id'])) {
    $root_supplier_id = $visitor['data']['store_id'];
}


//会员在当前访问店铺的数据，第一步先实时更新
M('Store_user_data')->updateData($store_id, $wap_user['uid']);
$storeUserData = M('Store_user_data')->getUserData($store_id, $wap_user['uid']);
//所有订单
$allOrder = $storeUserData['order_send'] + $storeUserData['order_unsend'] + $storeUserData['order_unpay'] + $storeUserData['order_complete'] + D('Order')->where(array('store_id' => $store_id, 'uid' => $wap_user['uid'], 'status' => 0))->count('order_id');

//判断用户在该店铺的会员等级
$userDegree = M('User_degree')->getUserDegree($_SESSION['wap_user']['uid'], $root_supplier_id);
if($userDegree['level_pic']) {
    if(preg_match('/^images\//', $userDegree['level_pic'])) {
        $userDegree['level_pic'] = getAttachmentUrl($userDegree['level_pic']);
    } else {
        $userDegree['level_pic'] = option('config.site_url') . '/' . $userDegree['level_pic'];
    }
}
if ($visitor['data']['store_id'] == $store_id && empty($storeUserData['degree_name'])) {
    $storeUserData['degree_name'] = '店家';
}

//退换货
$where = array();
$where['uid'] = $_SESSION['wap_user']['uid'];
$where['store_id'] = $store_id;
$where['user_return_id'] = 0;
$returnProduct = M('Return')->getCount($where);

//会员中心配置
$now_ucenter = D('Ucenter')->where(array('store_id' => $root_supplier_id))->find();
if (empty($now_ucenter)) {
    $now_ucenter['page_title'] = $config['ucenter_page_title'];
    $now_ucenter['bg_pic'] = $config['site_url'] . '/upload/images/' . $config['ucenter_bg_pic'];
} else {
    $now_ucenter['bg_pic'] = trim($now_ucenter['bg_pic'], '.');

    $ucenter['bg_pic'] = $ucenter['bg_pic'];
    $now_ucenter['tab_name'] = unserialize($now_ucenter['tab_name']);
    $now_ucenter['consumption_field'] = unserialize($now_ucenter['consumption_field']);
    $now_ucenter['promotion_field'] = unserialize($now_ucenter['promotion_field']);
    $now_ucenter['member_content'] = unserialize($now_ucenter['member_content']);
    $now_ucenter['promotion_content'] = unserialize($now_ucenter['promotion_content']);
}

//会员中心的自定义字段
if ($now_ucenter['has_custom']) {
    $homeCustomField = M('Custom_field')->getParseFields($store_id, 'ucenter', $store_id);
}

//公共广告判断
$pageHasAd = false;
if ($now_store['open_ad'] && !empty($now_store['use_ad_pages'])) {
    $useAdPagesArr = explode(',', $now_store['use_ad_pages']);
    if (in_array('4', $useAdPagesArr)) {
        $pageAdFieldArr = M('Custom_field')->getParseFields($store_id, 'common_ad', $store_id);
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
    if (in_array('2', $useNavPagesArr)) {
    	$tmp_store_id = $store_id;
    	if (!empty($now_store['top_supplier_id']) && empty($now_store['drp_diy_store'])) {
    		$tmp_store_id = $now_store['top_supplier_id'];
    	}
    	$storeNav = M('Store_nav')->getParseNav($tmp_store_id, $store_id, $now_store['drp_diy_store']);
    }
}

$_SESSION['tmp_store_id'] = $store_id;

$store          = M('Store');
$store_supplier = M('Store_supplier');
$drp_link            = false;
$drp_level           = $now_store['drp_level']; //当前分销级别
$max_store_drp_level = option('config.max_store_drp_level'); //最大分销级别

//收藏的产品
$user_collect = M('User_collect');
$sql = "SELECT * FROM " . option('system.DB_PREFIX') . "user_collect c ," . option('system.DB_PREFIX') . "product p where c.dataid = p.product_id and c.user_id=" . $wap_user['uid'] . " and c.type=1 and c.store_id={$store_id} order by c.add_time desc limit 10 ";
$collects = $user_collect->db->query($sql);

//收藏的专题
$sub_sql = "SELECT * FROM " . option('system.DB_PREFIX') . "user_collect c ," . option('system.DB_PREFIX') . "meal_cz s where c.dataid = s.cz_id and c.user_id=" . $wap_user['uid'] . " and c.type=4 and c.store_id={$store_id} order by c.add_time desc limit 10";
$subjects = $user_collect->db->query($sub_sql);

//消费金额
$where = array();
$where['store_id'] = $store_id;
$where['uid'] = $wap_user['uid'];
$where['user_order_id'] = 0;
$where['_string'] = "status > 2 AND status != 5";
$consume = D('Order')->where($where)->sum('total');
$consume = number_format($consume, 2, '.', '');

//店铺积分配置(供货商)
$signStoreId = $root_supplier_id;
$signStoreInfo = D('Store')->where(array('drp_supplier_id' => 0, 'store_id' => $signStoreId))->find();
$store_points_config = D('Store_points_config')->where(array('store_id' => $signStoreInfo['store_id']))->find();

if($now_store['is_point_mall'] == 1) {
	include display('point_ucenter');	
} else {
	include display('ucenter');
}
echo ob_get_clean();
?>