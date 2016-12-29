<!DOCTYPE>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link href="<?php echo TPL_URL;?>ucenter/css/base.css" rel="stylesheet">
    <link href="<?php echo TPL_URL;?>ucenter/css/index.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>ucenter/css/swiper.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>ucenter/css/usercenter.css" type="text/css">
    <title>优礼库-我的名片</title>
    <script src="<?php echo TPL_URL;?>ucenter/js/jquery-1.7.2.js"></script>
    <script src="<?php echo TPL_URL;?>ucenter/js/swiper.min.js"></script>
    <script src="<?php echo TPL_URL;?>ucenter/js/rem.js"></script>
</head>
<style>
    .card-avatar img {
        width: 8rem;
        margin-top: 11px;
    }
</style>
<body>
<div class="card">
    <div class="card-avatar">
        <img src="<?php echo !empty($avatar) ? $avatar : option('config.site_url') . '/static/images/avatar.png'; ?>" alt="<?php echo $now_store['name'];?>"/>
    </div>
    <h3>我是<em><?php echo !empty($_SESSION['wap_user']['nickname']) ? $_SESSION['wap_user']['nickname'] : ''; ?></em></h3>
    <p>欢迎你加入我的分销团队</p>
</div>
<div class="card-qrcode">
    <small></small>
    <img src="<?php echo rtrim(option('config.site_url'), '/')."/source/qrcode.php?type=home&id=".$store_id.""?>"/>
    <p>长按此图 识别图中二维码</p>
</div>

</body>
</html>
