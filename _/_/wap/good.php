<?php
/**
 *  店铺主页
 */
//引入文件
require_once dirname(__FILE__) . '/global.php';
import('source.class.Margin');
import('source.class.Drp');

//获取商品ID
$product_id = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误', 'none');

// 预览切换
if (!$is_mobile && $_SESSION['user'] && option('config.synthesize_store')) {
    if (isset($_GET['ps']) && $_GET['ps'] == '800') {
        $config = option('config');

        //PC端
        $url = $config['site_url'] . '/index.php?c=goods&a=index&id=' . $product_id . '&is_preview=1';
        echo redirect($url);
        exit;
    }
}

$allow_platform_drp = option('config.open_platform_drp');
$allow_store_drp = option('config.open_store_drp');

//商品默认展示
$nowProduct = D('Product')->where(array('product_id' => $product_id))->find();

if($nowProduct['is_present'] == 1) {
	$tip = "积分商品";
	$is_present_product = 1;
	$allow_drp = false;	//不允许分销
} else {
	$tip = "商品";
	$is_present_product = 0;
}

if (empty($nowProduct)) {
	pigcms_tips('您访问的'.$tip.'不存在', 'none');
}

if ($nowProduct['status'] != '1') {
	pigcms_tips('您访问的'.$tip.'未上架或已删除', 'none');
}


// 批发商品时，需要对送他人、找人送功能单独处理
$product_original = $nowProduct;
if ($nowProduct['wholesale_product_id']) {
	$product_original = D('Product')->where(array('product_id' => $nowProduct['wholesale_product_id']))->find();
	if (empty($product_original) || $product_original['status'] != '1') {
		pigcms_tips('您访问的'.$tip.'不存在或未上架或已删除', 'none');
	}
	$store_original = D('Store')->where(array('store_id' => $product_original['store_id']))->find();

	if (empty($store_original)) {
		pigcms_tips('您访问的店铺不存在', 'none');
	}
}

$store_id = $nowProduct['store_id'];
//获取供货商信息
$top_store = array();
if (!empty($_GET['store_id'])) {
    $tmp_store_id = intval(trim($_GET['store_id']));
	$top_store = D('Store')->where(array('store_id' => $store_id))->find();
} else {
    $tmp_store_id = $store_id;
}
//店铺资料
$now_store = M('Store')->wap_getStore($tmp_store_id);
if($top_store['tel']){
	if($top_store['is_show_drp_tel']==1){
        $now_store['tel'] = $top_store['tel'];
	}
}

$store_contace = M('Store_contact')->get($now_store['store_id']);
$now_store['tel'] = ($store_contace['phone1'] ? $store_contace['phone1'] . '-' : '') . $store_contace['phone2'];
//增加套餐是否开启线上交易

$package_uid = $now_store['uid'];
$temp_arr = D('')->table("User as u")
        ->join('Package as p ON u.package_id=p.pigcms_id','LEFT')
        ->where("`u`.`uid`=".$package_uid)
        ->field("`u`.uid,`u`.package_id,`p`.store_online_trade " )
        -> find();
if($temp_arr['package_id']){
	$store_online_trade = $temp_arr['store_online_trade'];
}else{
	$store_online_trade = 1;
}


//保证金不足，商品暂停出售
$constraint_sold_out = false;
if (Margin::pre_recharge()) {
    Margin::init($now_store['store_id']);
    //商品赠送的积分
    $return_point = Margin::productPoint($nowProduct['product_id']);
    //平台保证金服务费
    $service_fee = Margin::service_fee($return_point);
    if (!Margin::check_balance($service_fee)) {
        $constraint_sold_out = true;
    }
}

//非店铺自营商品
if ($store_id != $tmp_store_id) {
    //与当前店铺无关的商品无法销售
    if ($store_id != $now_store['root_supplier_id']) {
        $nowProduct['quantity'] = 0;
    }
}

		
//平台币 自定义
$credit_setting = D('Credit_setting')->find();
$platform_credit_name = $credit_setting['platform_credit_name'] ;
$platform_credit_name = $platform_credit_name ? $platform_credit_name : "平台币";

/* 20160215 首次购物关注供货商公众号 */
$wap_user = !empty($_SESSION['wap_user']) ? $_SESSION['wap_user'] : array();

//判断是否关注店铺(关注后享受关注折扣)
$store_bind     = M('Store')->get_subscribe_qrcode($now_store['store_id'],$nowProduct);
if ($store_bind['error_code'] == 0) {
    $follow = M('Store')->is_subscribe_store($_SESSION['wap_user']['uid'],$now_store['store_id']);
}

if (empty($allow_platform_drp) && !empty($nowProduct['wholesale_product_id'])) {
    $nowProduct['quantity'] = 0;
}
if (empty($allow_store_drp) && !empty($nowProduct['is_fx']) && $nowProduct['store_id'] != $tmp_store_id) {
    $nowProduct['quantity'] = 0;
}

if (empty($now_store))
	pigcms_tips('您访问的店铺不存在', 'none');
setcookie('wap_store_id', $tmp_store_id, $_SERVER['REQUEST_TIME'] + 10000000, '/');


if ($nowProduct['image_size'] == '0') {
    $nowProduct['image_size'] = array();
} else if ($nowProduct['image_size']) {
    $nowProduct['image_size'] = unserialize($nowProduct['image_size']);
} else {
    $nowProduct['image_size'] = D('Attachment')->field('`width`,`height`')->where(array('file' => $nowProduct['image']))->find();
    D('Product')->where(array('product_id' => $product_id))->data(array('image_size' => serialize($nowProduct['image_size'])))->save();
}
$nowProduct['image'] = getAttachmentUrl($nowProduct['image']);
$nowProduct['images'] = M('Product_image')->getImages($product_id, true);
$nowProduct['images_num'] = count($nowProduct['images']);

if ($nowProduct['has_property']) {
    //库存信息
    if($nowProduct['after_subscribe_discount'] >=1){
        $skuList = D('Product_sku')->field('`sku_id`,`properties`,`quantity`,`after_subscribe_price`,`drp_level_1_price`,`drp_level_2_price`,`drp_level_3_price`,`drp_level_1_cost_price`,`drp_level_2_cost_price`,`drp_level_3_cost_price`')->where(array('product_id' => $product_id))->order('`sku_id` ASC')->select();
    }else{
        $skuList = D('Product_sku')->field('`sku_id`,`properties`,`quantity`,`price`,`drp_level_1_price`,`drp_level_2_price`,`drp_level_3_price`,`drp_level_1_cost_price`,`drp_level_2_cost_price`,`drp_level_3_cost_price`')->where(array('product_id' => $product_id))->order('`sku_id` ASC')->select();
    }

    //如果有库存信息并且有库存，则查库存关系表
    if (!empty($skuList)) {
        $skuPriceArr = $skuPropertyArr = array();
        foreach ($skuList as $value) {
            if (!empty($nowProduct['unified_price_setting']) && !empty($nowProduct['is_fx'])) { //分销商的价格
                $value['price'] = ($value['drp_level_' . ($now_store['drp_level'] <= 3 ? $now_store['drp_level'] : 3) . '_price'] > 0) ? $value['drp_level_' . ($now_store['drp_level'] <= 3 ? $now_store['drp_level'] : 3) . '_price'] : $value['price'];
            }
            $skuPriceArr[] = $value['price'];
            $skuPropertyArr[$value['properties']] = true;
        }
        if (!empty($skuPriceArr)) {
            $minPrice = min($skuPriceArr);
            $maxPrice = max($skuPriceArr);
        } else {
            $nowProduct['quantity'] = 0;
        }
        $tmpPropertyList = D('')->field('`pp`.`pid`,`pp`.`name`')->table(array('Product_to_property' => 'ptp', 'Product_property' => 'pp'))->where("`ptp`.`product_id`='$product_id' AND `pp`.`pid`=`ptp`.`pid`")->order('`ptp`.`pigcms_id` ASC')->select();
        if (!empty($tmpPropertyList)) {
            $tmpPropertyValueList = D('')->field('`ppv`.`vid`,`ppv`.`value`,`ppv`.`pid`')->table(array('Product_to_property_value' => 'ptpv', 'Product_property_value' => 'ppv'))->where("`ptpv`.`product_id`='$product_id' AND `ppv`.`vid`=`ptpv`.`vid`")->order('`ptpv`.`pigcms_id` ASC')->select();
            if (!empty($tmpPropertyValueList)) {
                foreach ($tmpPropertyValueList as $value) {
                    $propertyValueList[$value['pid']][] = array(
                        'vid' => $value['vid'],
                        'value' => $value['value'],
                    );
                }
                foreach ($tmpPropertyList as $value) {
                    $newPropertyList[] = array(
                        'pid' => $value['pid'],
                        'name' => $value['name'],
                        'values' => $propertyValueList[$value['pid']],
                    );
                }
                if (count($newPropertyList) == 1) {
                    foreach ($newPropertyList[0]['values'] as $key => $value) {
                        $tmpKey = $newPropertyList[0]['pid'] . ':' . $value['vid'];
                        if (empty($skuPropertyArr[$tmpKey])) {
                            unset($newPropertyList[0]['values'][$key]);
                        }
                    }
                }
            }
        }
        if ($minPrice) {
        	$nowProduct['price'] = $minPrice;
        }
    }
} else {
    $maxPrice = 0;
    $minPrice = $nowProduct['price'];
    if (!empty($nowProduct['unified_price_setting']) && !empty($nowProduct['is_fx'])) { //分销商的价格
        $minPrice = ($nowProduct['drp_level_' . ($now_store['drp_level'] <= 3 ? $now_store['drp_level'] : 3) . '_price'] > 0) ? $nowProduct['drp_level_' . ($now_store['drp_level'] <= 3 ? $now_store['drp_level'] : 3) . '_price'] : $nowProduct['price'];
    }
}

if ($product_original['postage_type']) {
    $postage_template = M('Postage_template')->get_tpl($product_original['postage_template_id'], $product_original['store_id']);
    if ($postage_template['area_list']) {
        foreach ($postage_template['area_list'] as $value) {
            if (!isset($min_postage)) {
                $min_postage = $max_postage = $value[2];
            } else if ($value[2] < $min_postage) {
                $min_postage = $value[2];
            } else if ($value[2] > $max_postage) {
                $max_postage = $value[2];
            }
        }
    }
    if ($min_postage == $max_postage) {
        $nowProduct['postage'] = $min_postage;
    } else {
        $nowProduct['postage_tpl'] = array('min' => $min_postage, 'max' => $max_postage);
    }
} else {
	$nowProduct['postage'] = $product_original['postage'];
}

//扫码优惠
if (!empty($_GET['activity'])) {
	$nowActivity = M('Product_qrcode_activity')->getActivityById($_GET['activity']);

	if (empty($nowActivity) || $nowActivity['product_id'] != $nowProduct['product_id']) {
		unset($nowActivity);
	}
}

//当前页面的地址
$now_url = $config['wap_site_url'] . '/good.php?id=' . $nowProduct['product_id'] . '&store_id=' . $tmp_store_id;

//商品的自定义字段
if ($nowProduct['has_custom']) {
	$homeCustomField = M('Custom_field')->getParseFields($nowProduct['store_id'], 'good', $nowProduct['product_id'], $tmp_store_id, $now_store['drp_level'], $now_store['drp_diy_store']);
}

//公共广告判断
$pageHasAd = false;
if ($now_store['open_ad'] && !empty($now_store['use_ad_pages'])) {
	$useAdPagesArr = explode(',', $now_store['use_ad_pages']);
	if (in_array('2', $useAdPagesArr)) {
		$pageAdFieldArr = M('Custom_field')->getParseFields($nowProduct['store_id'], 'common_ad', $nowProduct['store_id'], $tmp_store_id, $now_store['drp_level'], $now_store['drp_diy_store']);
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

$good_history = $_COOKIE['good_history'];
if (empty($good_history)) {
    $new_history = true;
} else {
    $good_history = json_decode(stripslashes($good_history), true);
    if (!is_array($good_history)) {
        $new_history = true;
    } else {
        $new_good_history = array();
        foreach ($good_history as &$history_value) {
            if ($history_value['id'] != $nowProduct['product_id']) {
                $new_good_history[] = $history_value;
            }
        }
        if (!empty($new_good_history)) {
            array_push($new_good_history, array('id' => $nowProduct['product_id'], 'name' => $nowProduct['name'], 'image' => $nowProduct['image'], 'price' => $nowProduct['price'], 'url' => $now_url, 'time' => $_SERVER['REQUEST_TIME']));
        } else {
            $new_history = true;
        }
    }
}
if ($new_history) {
    $new_good_history[] = array(
        'id' => $nowProduct['product_id'],
        'name' => $nowProduct['name'],
        'image' => $nowProduct['image'],
        'price' => $nowProduct['price'],
        'url' => $now_url,
        'time' => $_SERVER['REQUEST_TIME']
    );
}
setcookie('good_history', json_encode($new_good_history), $_SERVER['REQUEST_TIME'] + 86400 * 365, '/');

//限购
$buyer_quota = false;
if (!empty($nowProduct['buyer_quota'])) {
	$buy_quantity = 0;
	$user_type = 'uid';
	$uid = $_SESSION['wap_user']['uid'];
	if (empty($_SESSION['wap_user'])) { //游客购买
		$session_id = session_id();
		$uid = $session_id;
		$user_type = 'session';
		//购物车
		$cart_number = D('User_cart')->field('sum(pro_num) as pro_num')->where(array('product_id' => $nowProduct['product_id'], 'session_id' => $session_id))->find();
		if (!empty($cart_number)) {
			$buy_quantity += $cart_number['pro_num'];
		}
	} else {
		//购物车
		$cart_number = D('User_cart')->field('sum(pro_num) as pro_num')->where(array('product_id' => $nowProduct['product_id'], 'uid' => $uid))->find();
		if (!empty($cart_number)) {
			$buy_quantity += $cart_number['pro_num'];
		}
	}

	// 再加上订单里已经购买的商品
	$buy_quantity += M('Order_product')->getBuyNumber($uid, $nowProduct['product_id'], $user_type);
	if ($buy_quantity >= $nowProduct['buyer_quota']) {
		$buyer_quota = true;
	}
}

// 查看本产品是否参与活动
$reward = '';
if (empty($nowProduct['supplier'])) {
    $reward = M('Reward')->getRewardByProduct($nowProduct);
}

$drp_button = '';
$allow_drp = false;
$is_sub_seller = false; //是否是当前店铺下级分销商
if (!empty($nowProduct['is_fx'])) {
    $avatar = M('User')->getAvatarById($_SESSION['wap_user']['uid']);
    $visitor = Drp::checkID($tmp_store_id, $_SESSION['wap_user']['uid']);
    if ($visitor['data']['store_id'] == $tmp_store_id && empty($visitor['data']['drp_supplier_id'])) {
        $avatar = getAttachmentUrl($visitor['data']['logo']);
        $allow_drp = true;
        $msg = '亲爱的 <span class="nickname">' . $_SESSION['wap_user']['nickname'] . '</span>，此商品已经设置为可分销！';
    } else if (!empty($visitor['data']['allow_drp_manage'])) {
        $allow_drp = $visitor['data']['allow_drp'];
        $drp_level = ($visitor['data']['drp_level'] > 3) ? 3 : $visitor['data']['drp_level'];
        $drp_register_url = './drp_product_share.php?id=' . $nowProduct['product_id'] . '&store_id=' . $visitor['data']['store_id'];
        $msg = "分销此商品您可赚取 <span class='profit'>{min_profit} ~ {max_profit}</span>元 佣金！";
        $drp_button = '去赚佣金';
    } else if (!empty($visitor['data']['allow_drp_register'])) {
        $allow_drp = true;
        $drp_register_url = './drp_register.php?id=' . $tmp_store_id . "&referer=" . urlencode(option('config.wap_site_url') . "/drp_product_share.php?id=" . $nowProduct['product_id'] . "&store_id=");
        $msg = '亲爱的 <span class="nickname">' . $_SESSION['wap_user']['nickname'] . '</span>，申请分销即可分销赚佣金！';
        $drp_button = '我要分销';
    }

    $zx_profit = array(); //直销利润
    $fx_profit = array(); //分销利润
    if (!empty($skuList)) {
        foreach ($skuList as $sku) {
            $zx_profit[] = $sku['drp_level_3_price'] - $sku['drp_level_3_cost_price'];
            $fx_profit[] = $sku['drp_level_' . ($drp_level + 1) . '_cost_price'] - $sku['drp_level_' . $drp_level . '_cost_price'];
        }
    } else {
        //3级利润
        $zx_profit[] = $nowProduct['drp_level_3_price'] - $nowProduct['drp_level_3_cost_price'];
        $fx_profit[] = $nowProduct['drp_level_' . ($drp_level + 1) . '_price'] - $nowProduct['drp_level_' . $drp_level . '_cost_price'];
    }
    if (!empty($nowProduct['unified_profit'])) {
        $min_profit = number_format(min($zx_profit), 2, '.', '');
        $max_profit = number_format(max($zx_profit), 2, '.', '');
    } else {
        $min_profit = number_format(min($fx_profit), 2, '.', '');
        $max_profit = number_format(max($fx_profit), 2, '.', '');
    }
    if ($min_profit != $max_profit) {
        $msg = str_replace(array("{min_profit}", "{max_profit}"), array($min_profit, $max_profit), $msg);
    } else {
        $msg = str_replace("{min_profit} ~ {max_profit}", $min_profit, $msg);
    }
}

//判断是否显示评价按钮
$is_comment = M('Order_product')->isComment($product_id, false);

//是否开启平台保证金
import('source.class.Margin');
$open_margin_recharge = Margin::check();

$imUrl = getImUrl($_SESSION['wap_user']['uid'], $tmp_store_id);
//分享配置 start
$share_conf = array(
    'title' => $nowProduct['name'], // 分享标题
    'desc' => str_replace(array("\r", "\n"), array('', ''), !empty($nowProduct['intro']) ? $nowProduct['intro'] : $nowProduct['name']), // 分享描述
    'link' => 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], // 分享链接
    'imgUrl' => $nowProduct['image'], // 分享图片链接
    'type' => '', // 分享类型,music、video或link，不填默认为link
    'dataUrl' => '', // 如果type是music或video，则要提供数据链接，默认为空
);

//有分销商
if (!empty($visitor['drp_supplier_id'])) {
    $supply_chain = D('Store_supplier')->field('supply_chain,level')->where(array('seller_id' => $visitor['store_id'], 'type' => 1))->find();
    if (!empty($supply_chain)) {
        $chain = explode(',', $supply_chain['supply_chain']);
        if (in_array($tmp_store_id, $chain)) { //是当前店铺的下级分销商
            $is_sub_seller = true;
        }
    }
}

//分享限制标识
$share_limit_flag = true;
if (!empty($visitor) && empty($visitor['data']['allow_drp_register'])) {
    //未达到限制分销条件
    $share_limit_flag = false;
}

//分享自动成为分销商标识
$flag = false;
//开启分享 并且 达到分销限制条件
if($now_store['is_fanshare_drp'] && $share_limit_flag){
	$flag = true;
}

// 是否喜欢(收藏)
$is_collect = D('User_collect')->where(array('user_id' => $_SESSION['wap_user']['uid'], 'type' => 1,'store_id' => $tmp_store_id, 'dataid' => $product_id))->find();

if(!empty($is_sub_seller)){
	$share_conf = array(
			'title'    => $nowProduct['name'], // 分享标题
			'desc'     => str_replace(array("\r", "\n"), array('', ''), $nowProduct['intro']), // 分享描述
			'link'     => $config['wap_site_url'] . '/good.php?id=' . $product_id . '&store_id=' . $visitor['data']['store_id'], // 分享链接
			'imgUrl'   => getAttachmentUrl($nowProduct['image']), // 分享图片链接
			'type'     => '', // 分享类型,music、video或link，不填默认为link
			'dataUrl'  => '', // 如果type是music或video，则要提供数据链接，默认为空
			'store_id' => '',
			'uid'      => ''
	);
}else if($flag){
	$share_conf['store_id'] = $tmp_store_id;
	$share_conf['uid']      = $_SESSION['wap_user']['uid'];
}

$comment_data = M('Comment')->getCountList(array('relation_id' => $product_id));

import('WechatShare');
$share = new WechatShare();
$shareData = $share->getSgin($share_conf);
//分享配置 end


//商品活动标签
$product_activity = M('Product_activity');
$product_activity_where = array();
$product_activity_where['product_id'] = $product_id;

$product_activitys = $product_activity->getOne($product_activity_where);

$color = array();
$color['1'] = 'red';
$color['2'] = 'yellow';
$color['3'] = 'purple';


include display('good');
echo ob_get_clean();
?>