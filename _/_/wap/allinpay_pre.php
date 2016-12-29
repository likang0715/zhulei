<?php
require_once dirname(__FILE__) . '/global.php';

$url = 'http://' . $_SERVER['HTTP_HOST'] . '/wap/allinpay.php?'.$_SERVER['QUERY_STRING'];
//exit($url);
// 使用iframe尝试在微信内完成支付

$html = '<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
<meta content="application/xhtml+xml;charset=UTF-8"	http-equiv="Content-Type" />
<meta content="no-cache,must-revalidate" http-equiv="Cache-Control" />
<meta content="no-cache" http-equiv="pragma" />
<meta content="0" http-equiv="expires" />
<meta content="telephone=no, address=no" name="format-detection" />
<meta name="apple-mobile-web-app-capable" content="yes" />';
$html.= '<body style="height:100%">';
$html .= "<iframe width=100% height=98% name=aa frameborder=0 src=".$url."></iframe>";
$html .= '</body>';
exit($html);