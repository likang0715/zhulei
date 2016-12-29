<?php
/**
 * 分销商品分享
 * User: pigcms_21
 * Date: 2015/7/9
 * Time: 13:54
 */

require_once dirname(__FILE__).'/global.php';

$product_id = isset($_GET['id']) ? $_GET['id'] : pigcms_tips('您输入的网址有误','none');
$store_id   = isset($_GET['store_id']) ? intval(trim($_GET['store_id'])) : pigcms_tips('您输入的网址有误','none');

$product = M('Product');
$user    = M('User');

//当前店铺
if (empty($_SESSION['wap_user'])) {
	$nowStore = M('Store')->wap_getStore($store_id);
} else {
	$nowStore = M('Store')->getStore($store_id);
}

if (empty($nowStore)) {
	pigcms_tips('您访问的店铺不存在或已被删除', 'none');
}

$nowProduct = $product->get(array('product_id' => $product_id));
if (empty($nowProduct)) {
	pigcms_tips('您访问的商品不存在','none');
}
//供货商
$store = array();
if (!empty($nowStore['drp_supplier_id'])) {
	$store = D('Store')->field('name')->where(array('store_id' => $nowStore['drp_supplier_id']))->find();
} else {
	$store['name'] = '自己';
}

$nowStore['logo'] = !empty($nowStore['logo']) ? getAttachmentUrl($nowStore['logo']) : getAttachmentUrl('images/avatar.png', false);

if ($nowStore['store_id'] == $nowProduct['store_id']) { //自营商品
	$drp_level = 0;
} else {
	$drp_level = $nowStore['drp_level'];
	if ($drp_level > 3) {
		$drp_level = 3;
	}
	$nowProduct['price'] = ($nowProduct['drp_level_' . $drp_level . '_price'] > 0) ? $nowProduct['drp_level_' . $drp_level . '_price'] : $nowProduct['price'];
}

//获取商品分销信息
if (!empty($nowProduct['is_fx'])) {
	$nowProduct['cost_price'] = $nowProduct['drp_level_' . $drp_level . '_cost_price'];
	$nowProduct['price'] = $nowProduct['drp_level_' . $drp_level . '_price'];

	$zx_profit = array(); //直销利润
	$fx_profit = array(); //分销利润
	if (!empty($nowProduct['has_property'])) {
		$skus = D('Product_sku')->where(array('product_id' => $product_id))->select();
		foreach ($skus as $sku) {
			$zx_profit[] = $sku['drp_level_3_price'] - $sku['drp_level_3_cost_price'];
			$fx_profit[] = $sku['drp_level_' . ($drp_level + 1) . '_cost_price'] - $sku['drp_level_' . $drp_level . '_cost_price'];
		}
	} else {
		//3级利润
		$zx_profit[] = $nowProduct['drp_level_3_price'] - $nowProduct['drp_level_3_cost_price'];
		$fx_profit[] = $nowProduct['drp_level_' . ($drp_level + 1) . '_cost_price'] - $nowProduct['drp_level_' . $drp_level . '_cost_price'];
	}
	if (!empty($nowProduct['unified_profit'])) {
		$min_profit = number_format(min($zx_profit), 2, '.', '');
		$max_profit = number_format(max($zx_profit), 2, '.', '');
	} else {
		$min_profit = number_format(min($fx_profit), 2, '.', '');
		$max_profit = number_format(max($fx_profit), 2, '.', '');
	}
	$nowProduct['min_profit'] = $min_profit;
	$nowProduct['max_profit'] = $max_profit;
} else {
	$nowProduct['cost_price'] = $nowProduct['price'];
	$nowProduct['min_profit'] = '0.00';
	$nowProduct['max_profit'] = '0.00';
}

//分享配置 start
$share_conf 	= array(
	'title' 	=> $nowProduct['name'], // 分享标题
	'desc' 		=> str_replace(array("\r","\n"), array('',''), !empty($nowProduct['intro']) ? $nowProduct['intro'] : $nowProduct['name']), // 分享描述
	'link' 		=> option('config.wap_site_url') . '/good.php?id=' . $product_id . '&store_id=' . $nowStore['store_id'], // 分享链接
	'imgUrl' 	=> getAttachmentUrl($nowProduct['image']), // 分享图片链接
	'type'		=> '', // 分享类型,music、video或link，不填默认为link
	'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);

import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);
//分享配置 end

include display('drp_product_share');

echo ob_get_clean();