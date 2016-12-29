<?php
/**
 * 秒杀活动 分享
 * User: pigcms_21
 * Date:
 * Time:
 */
require_once dirname(__FILE__) . '/global.php';

$store_id = !empty($_GET['store_id']) ? $_GET['store_id'] : ''; //发布活动的店铺

if (empty($_SESSION['wap_user'])){
    $wap_user = M('Store')->wap_getStore($store_id);
}else if(!empty($_SESSION['wap_user'])){
    $wap_user = $_SESSION['wap_user'];
}

$user_id = intval(empty($_GET['uid'])) ? $wap_user['uid'] : $_GET['uid']; // 参与活动的用户
$seckill_id = intval($_GET['seckill_id']);                   // 活动ID

/* 秒杀详细 */
$seckillInfo = D('Seckill')->where(array('pigcms_id'=>$seckill_id))->find();

/* 秒杀活动商品详细 */
$productInfo = D('Product')->where(array('product_id'=>$seckillInfo['product_id']))->find();

/* 查询我参加的活动 */
$seckillUser = D('Seckill_user')->where(array('seckill_user_id'=>$user_id, 'seckill_id'=>$seckill_id))->find();

/* 获取帮助用户列表 */
$shareUser = M('Seckill_share_user')->getUserList($seckill_id, $user_id);

/* 参与活动的用户信息 */
$userInfo = D('User')->where(array('uid'=>$user_id))->find();

/* 记录秒杀帮助我的用户 */
if($user_id != $wap_user['uid']){
    if(!empty($_GET['uid'])){
        $data['seckill_user_id'] = $user_id;
        $data['user_id'] = $wap_user['uid'];
        $data['seckill_id'] = $seckill_id;
        $data['preset_time'] = $seckillInfo['preset_time'];
        $data['add_time'] = time();
        if($seckillUser){

            //查找用户是否已帮助过
            $is_help = D('Seckill_share_user')->where(array('user_id'=>$wap_user['uid']))->count('pigcms_id');
            /* 记录分享用户 */
            if($is_help == 0){
                $result = D('Seckill_share_user')->data($data)->add();
                if($result){
                    $update['preset_time'] = $data['preset_time'] + $seckillUser['preset_time'];
                    $update['update_time'] = time();
                    /* 更新秒杀用户 */
                    D('Seckill_user')->where(array('seckill_user_id'=>$_GET['uid']))->data($update)->save();
                }
            }
        } else {
            /* 记录分享用户 */
            $result = D('Seckill_share_user')->data($data)->add();
            if($result){
                $update['seckill_user_id'] = $user_id;
                $update['preset_time'] = $data['preset_time'];
                $update['add_time'] = time();
                $update['update_time'] = time();
                $update['seckill_id'] = $seckill_id;
                /* 记录秒杀用户 */
                D('Seckill_user')->data($update)->add();
            }
        }
    }
}

//分享配置 start
$share_conf = array(
    'title'     => $productInfo['name'], // 分享标题
    'desc'      => str_replace(array("\r", "\n"), array('', ''), $productInfo['name']), // 分享描述
    'link'      => option('config.wap_site_url') . '/seckill_shop_invite.php?seckill_id='.$seckill_id.'&store_id='.$seckillInfo['store_id'].'&uid='.$user_id, // 分享链接
    'imgUrl'    => getAttachmentUrl($productInfo['image']), // 分享图片链接
    'type'      => '', // 分享类型,music、video或link，不填默认为link
    'dataUrl'   => '', // 如果type是music或video，则要提供数据链接，默认为空
);
//var_dump($share_conf);
import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);
//分享配置 end

include display('seckill_shop_invite');
echo ob_get_clean();