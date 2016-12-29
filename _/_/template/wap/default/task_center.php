<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link href="<?php echo TPL_URL;?>css/base.css" rel="stylesheet">
    <link href="<?php echo TPL_URL;?>css/index.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>ucenter/css/jiefen.css" type="text/css">
    <title>积分明细 - <?php echo $storeInfo['name']; ?></title>
    <script src="<?php echo TPL_URL;?>js/rem.js"></script>
    <script src="<?php echo TPL_URL;?>js/jquery-1.7.2.js"></script>
    <script src="<?php echo TPL_URL;?>js/index.js"></script>
</head>
<body>
<style rel="stylesheet">
    body{background: #fff}
</style>
<div class="signCell">
    <div class="cell">
        <a href="./checkin.php?act=checkin&store_id=<?php echo $storeInfo['store_id'] ?>">
            <i class="arrow"></i>
            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/i0.png"></i>每日签到</span>
        </a>
    </div>
    <div class="cell">
        <a href="./home.php?id=<?php echo $storeInfo['store_id'];?>">
            <i class="arrow"></i>
            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/i1.png"></i>去购物</span>
        </a>
    </div>
    <div class="cell">
        <a href="./checkin.php?act=single&store_id=<?php echo $storeInfo['store_id'];?>">
            <i class="arrow"></i>
            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/i2.png"></i>关注/推广公众号</span>
        </a>
    </div>
    <!--<div class="cell">
        <a href="##">
            <i class="arrow"></i>
            <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/i3.png"></i>抽奖逆袭</span>
        </a>
    </div>-->
    <p class="needMore"><a href="#">更多请关注店铺积分活动</a> </p>
</div>
</body>
</html>
