<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1" />
    <title>微店-秒杀帮助列表</title>
    <link rel="stylesheet" href="<?php echo TPL_URL;?>/seckill/css/style.css"/>
</head>

<body style="background-color:#efefef;">

<!--<div class="banner" style="height:150px;overflow:hidden;width:100%;">
    <img src="" width="100%" alt="" />
</div>-->

<div class="countdown">
    <h1><?php echo $preset_time;?></h1>
    <h2>恭喜您，您已经成功提前了<span style="color:#288b26;"><?php echo $seckill_user['preset_time']?>秒</span><br/>
        快去邀请朋友帮你赢取提前抢购的时间</h2>
</div>
<?php if($my_start > time()) {?>
<a href="./seckill_shop_invite.php?seckill_id=<?php echo $seckillInfo['pigcms_id']?>"><div class="askhelp">邀请好友帮忙</div></a>
<?php }?>
<div class="help">
    <h1>帮助过您的好友</h1>
    <?php if(!empty($userList)) {?>
    <?php foreach($userList as $user) {?>
        <div>
            <img src="<?php echo !empty($user['avatar']) ? $user['avatar'] : option('config.site_url') . '/static/images/default_shop_2.jpg'; ?>" width="100%">
            <?php echo !empty($user['nickname']) ? $user['nickname'] : 'nickname';?>&nbsp;帮您提前&nbsp;<?php echo $user['preset_time']?>秒
            <h2>
                <span style=" font-weight:bold;">-<?php echo $user['preset_time']?></span>秒
            </h2>
        </div>
    <?php }?>
    <?php }?>
</div>
</body>
</html>
