<?php

/**
 * 分销商
 * User: pigcms_21
 * Date: 2015/4/24
 * Time: 10:57
 */
require_once dirname(__FILE__) . '/global.php';

if ($_SESSION['wap_drp_store']) {
    $store = $_SESSION['wap_drp_store'];
} else {
    redirect('./ucenter.php?id=' . intval(trim($_COOKIE['wap_store_id'])));
}

$now_store = D('Store')->where(array('store_id'=>$store['store_id']))->find();

//分享配置 start
$share_conf 	= array(
    'title' 	=> $nowProduct['name'], // 分享标题
    'desc' 		=> str_replace(array("\r","\n"), array('',''), !empty($nowProduct['intro']) ? $nowProduct['intro'] : $nowProduct['name']), // 分享描述
    'link' 		=> option('config.wap_site_url') . '/home.php?id=' . $now_store['store_id'], // 分享链接
    'imgUrl' 	=> getAttachmentUrl($now_store['logo']), // 分享图片链接
    'type'		=> '', // 分享类型,music、video或link，不填默认为link
    'dataUrl'	=> '', // 如果type是music或video，则要提供数据链接，默认为空
);

import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSgin($share_conf);
//分享配置 end

include display('popularize');
echo ob_get_clean();