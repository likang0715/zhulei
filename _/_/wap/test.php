<?php
/**
 *  分享接口
 */
require_once dirname(__FILE__) . '/global.php';

// 分享
import('WechatShare');
$share = new WechatShare();
$share_data = $share->getSgin('', true);
$return['share_data'] = $share_data;

json_return(0, $return);
?>