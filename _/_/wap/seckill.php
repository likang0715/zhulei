<?php
/**
 * 秒杀活动
 * User: pigcms_21
 * Date:
 * Time:
 */
require_once dirname(__FILE__) . '/global.php';

$seckill_id = intval(!empty($_GET['seckill_id'])) ? $_GET['seckill_id'] : '';

/* 秒杀详细 */
$seckillInfo = D('Seckill')->where(array('pigcms_id'=>$seckill_id))->find();

if (empty($_SESSION['wap_user'])){
    $wap_user = M('Store')->wap_getStore($seckillInfo['store_id']);
}else if(!empty($_SESSION['wap_user'])){
    $wap_user = $_SESSION['wap_user'];
}

//活动是否开启关注
if($seckillInfo['is_subscribe'] == 1){
	/* 是否需要关注公众号 */
	$act_type = 'seckill';
	//店铺是否绑定认证服务号，并且能正常生产二维码
	$qrcode = M('Store')->concernRelationship(800000000, $wap_user['uid'], $seckillInfo['store_id'], 2, $act_type, $seckillInfo['pigcms_id']);
	if ($qrcode['error_code'] == 0) {
		/* 判读是否已经关注过商家 */
		$is_subscribe = D('Subscribe_store')->where(array('store_id'=>$seckillInfo['store_id'],'uid'=>$wap_user['uid'],'is_leave'=>0))->find();
	}
}

/* 秒杀活动商品详细 */
if(!empty($seckillInfo['sku_id'])){
    $sql = "select * from ".option('system.DB_PREFIX')."product as pro,".option('system.DB_PREFIX')."product_sku as sku where pro.product_id=sku.product_id and pro.product_id={$seckillInfo['product_id']} and sku.sku_id={$seckillInfo['sku_id']}";

    $productInfo = D('Product')->query($sql);
    $productInfo = $productInfo[0];
}else if(empty($seckillInfo['sku_id'])){
    $productInfo = D('Product')->where(array('product_id'=>$seckillInfo['product_id']))->find();
}

/* 秒杀活动用户排名 */
$userNum = M('Seckill')->getUserNum($wap_user['uid'], $seckill_id);

/* 获取帮助用户列表 */
$shareUser = M('Seckill_share_user')->getUserList($seckill_id, $wap_user['uid']);

/* 我的提前时间 */
$seckill_user = D('Seckill_user')->field('preset_time')->where(array('seckill_user_id'=>$wap_user['uid'], 'seckill_id'=>$seckill_id))->find();
$my_start = empty($seckill_user['preset_time']) ?  $seckillInfo['start_time'] : $seckillInfo['start_time'] - $seckill_user['preset_time'];

include display('seckill');
echo ob_get_clean();
