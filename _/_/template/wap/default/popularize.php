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
    <title>分销店铺-推广</title>

    <script src="<?php echo TPL_URL;?>ucenter/js/jquery-1.7.2.js"></script>
    <script src="<?php echo TPL_URL;?>ucenter/js/swiper.min.js"></script>
    <script src="<?php echo TPL_URL;?>ucenter/js/rem.js"></script>
</head>
<body>
<?php
   $level = array(
       '1' => '一',
       '2' => '二',
       '3' => '三',
       '4' => '四',
       '5' => '五',
       '6' => '六',
       '7' => '七',
       '8' => '八',
       '9' => '九',
   );
?>
<div class="spread">
    <div class="spreadWarp">
        <div class="spread-box">
            <h3>我的分销店铺信息推广分享</h3>
            <p>点击微信右上角分享按钮，将以下我的分销店铺信息分享给好友或者朋友圈</p>
            <div class="userAvatar clearfix">
                <div class="fl userAvatar">
                    <a href="##">
                        <img src="<?php echo !empty($now_store['logo']) ? $now_store['logo'] : option('config.site_url') . '/static/images/default_shop_2.jpg';?>">
                    </a>
                </div>
                <div class="userInfo">
                    <h3><?php echo !empty($_SESSION['wap_user']['nickname']) ? $_SESSION['wap_user']['nickname'] : ''; ?></h3>
                    <small class="num"><?php echo $level[$now_store['drp_level']];?>级分销商</small>
                </div>
            </div>
            <div class="spread-form">
                <input type="text" name='share' value="" placeholder="说点什么吧" />
            </div>

            <!--<div class="spread-btn clearfix">
                <button class="fr">分享到微信</button>
                <button class="fl">分享到新浪微博</button>
            </div>-->
        </div>
        <div class="spread-url">
            <h3>我的分销店铺信息推广分享</h3>
            <!--<p>长按一下虚线框，复制链接地址发送给好友！</p>-->
            <textarea class="urlAdd"><?php echo rtrim(option('config.site_url'), '/')."/wap/home.php?id=".$now_store['store_id'].""?></textarea>
        </div>
    </div>
</div>
<?php echo $shareData;?>
<script type="text/javascript" src="<?php echo TPL_URL; ?>js/weixinShare.js"></script>
</body>
</html>
