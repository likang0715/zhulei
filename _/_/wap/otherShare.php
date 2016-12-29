<?php
/**
 *  分享接口
 */
require_once dirname(__FILE__) . '/global.php';

import('WechatShare');
$share 		= new WechatShare();
$shareData 	= $share->getSynShare();

echo json_encode( $shareData );
?>