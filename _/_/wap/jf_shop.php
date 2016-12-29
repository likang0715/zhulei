<?php
/**
 *  商品商城 地址转换
 */
require_once dirname(__FILE__).'/global.php';

$point_shop = D('Store')->where(array('is_point_mall'=>1,'status'=>1))->find();
if(!$point_shop) {
	pigcms_tips('您访问的积分商城尚未开启！','none');
}

$url = "./home.php?id=".$point_shop['store_id'];
header("Location:".$url);
exit();