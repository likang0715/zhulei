<?php
/**
 * 秒杀活动
 * User: pigcms_21
 * Date:
 * Time:
 */
require_once dirname(__FILE__) . '/global.php';

if (empty($_SESSION['wap_user'])){
    M('Store')->wap_getStore($store_id);
}else if(!empty($_SESSION['wap_user'])){
    $wap_user = $_SESSION['wap_user'];
}

$seckill_id = intval($_GET['seckill_id']);

/* 秒杀详细 */
$seckillInfo = D('Seckill')->where(array('pigcms_id'=>$seckill_id))->find();

/* 秒杀活动商品详细 */
$productInfo = D('Product')->where(array('product_id'=>$seckillInfo['product_id']))->find();

/* 我的提前时间 */
$seckill_user = D('Seckill_user')->field('preset_time')->where(array('seckill_user_id'=>$wap_user['uid'], 'seckill_id'=>$seckill_id))->find();
$my_start = empty($seckill_user['preset_time']) ?  $seckillInfo['start_time'] : $seckillInfo['start_time'] - $seckill_user['preset_time'];

/* 格式化后的时间 */
$preset_time = M('Seckill')->secToTime($seckill_user['preset_time']);

/* 帮助过我的好友 */
$userList = M('Seckill_share_user')->getUserList($seckill_id, $wap_user['uid']);

include display('seckill_see_invite');
echo ob_get_clean();
