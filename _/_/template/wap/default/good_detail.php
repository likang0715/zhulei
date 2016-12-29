<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport"/>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="applicable-device" content="mobile">
    <link href="<?php echo TPL_URL;?>css/bargain/base.css" rel="stylesheet">
    <link href="<?php echo TPL_URL;?>css/bargain/index.css" rel="stylesheet">
    <link href="<?php echo TPL_URL;?>css/bargain/media.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/swiper.min.css" type="text/css">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <script src="<?php echo TPL_URL;?>js/jquery-1.7.2.js"></script>
    <script src="<?php echo TPL_URL;?>js/swiper.min.js"></script>
    <title><?php echo $bargain['name'];?></title>
</head>

<body>

<div class="list" style="text-align:left">
    <div class="list_title" style="text-align:center">
        <div class="go_top" onclick="location.href='<?php echo $config['site_url'].'/wap/bargain.php?action=detail&id='.$bargain['pigcms_id'].'&store_id='.$bargain['store_id'];?>'">返回</div>
        <?php echo $bargain['name'];?>
    </div>
    <?php echo $product['info'];?>
</div>
<?php
$share_conf     = array(
    'title'     => $bargain['wxtitle'], // 分享标题
    'desc'      => $bargain['wxinfo'], // 分享描述
    'link'      => $config['site_url'].'/wap/bargain.php?action=detail&id='.$bargain['pigcms_id'], // 分享链接
    'imgUrl'    => $bargain['wxpic'], // 分享图片链接
    'type'      => '', // 分享类型,music、video或link，不填默认为link
    'dataUrl'   => '', // 如果type是music或video，则要提供数据链接，默认为空
);

import('WechatShare');
$share      = new WechatShare();
$shareData  = $share->getSgin($share_conf);
echo $shareData;
?>
</body>
</html>
