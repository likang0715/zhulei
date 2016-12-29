<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1" />
    <title>微店-秒杀分享详情</title>
    <link rel="stylesheet" href="<?php echo TPL_URL;?>/seckill/css/style.css"/>
    <script type="text/javascript" src="<?php echo TPL_URL;?>ucenter/js/jquery-1.7.2.js"></script>
</head>

<body style="background-color:#efefef;">

<!--<div class="banner" style="height:150px;overflow:hidden;width:100%;">
    <img src="<?php /*echo rtrim(option('config.url'), '/').'/upload/images/default_ucenter.jpg';*/?>" width="100%" alt="" />
</div>-->

<div class="clock">
    <h1 style="font-size:12px; color:#808080; text-align:center; margin-bottom:11px;
     line-height:12px;"><span style="color:#4c4c4c"><?php echo $userInfo['nickname'];?></span>
        正在参加<span style="color:#ff0000">“<?php echo $seckillInfo['name']?>~”</span>活动</h1>
    <h1 style="font-size:12px; color:#808080; text-align:center; margin-bottom:22px;
     line-height:12px;">您的帮助将助TA赢得<span style="color:#128618">提前抢购</span>时间！</h1>


    <div id="clock_img" class="clock_img">
        <a href="javascript:;" id="seckill"> <img src="<?php echo TPL_URL;?>/seckill/images/clock.gif" width="100%"/></a>
    </div>
    <div class="share">
        <img src="<?php echo TPL_URL;?>/seckill/images/share-guide.png" style="width: 100%;">
    </div>
</div>
<?php if(empty($shareUser)){?>
    <div class="btn">暂无好友帮忙，快去邀请吧！</div>
<?php } else {?>
            <div class="help">
                <h1>帮助过"<?php echo $userInfo['nickname'];?>"的好友</h1>
                <?php foreach($shareUser as $key => $user){?>
                    <div>
                        <img src="<?php echo !empty($uset['logo']) ? $uset['logo'] : option('config.site_url') . '/static/images/default_shop_2.jpg'; ?>" width="100%">
                        <?php echo $user['nickname'] ?> 帮 <?php echo $userInfo['nickname'];?> 提前<?php echo $user['preset_time']?>秒
                        <h2><span style=" font-weight:bold;">-<?php echo $user['preset_time']?></span>秒</h2>
                    </div>
                <?php } ?>
            </div>
<?php }?>
<script>
    $(function(){
        $("#seckill").click(function() {
            $(".share").show() ;

            $(".share").click(function() {
                $(this).hide() ;
            }) ;

        });

        $(".btn").click(function() {
            $(".share").show() ;

            $(".share").click(function() {
                $(this).hide() ;
            }) ;

        });
    });
</script>
<?php echo $shareData;?>
</body>
</html>