<?php if (!defined('PIGCMS_PATH')) exit('deny access!'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta charset="utf-8"/>
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="format-detection" content="telephone=no"/>
    <title>个人资料</title>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/foundation.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/normalize.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/common.css"/>
    <script src="<?php echo TPL_URL; ?>js/jquery.js"></script>
    <script src="<?php echo TPL_URL; ?>js/drp_foundation.js"></script>
    <meta class="foundation-data-attribute-namespace"/>
    <meta class="foundation-mq-xxlarge"/>
    <meta class="foundation-mq-xlarge"/>
    <meta class="foundation-mq-large"/>
    <meta class="foundation-mq-medium"/>
    <meta class="foundation-mq-small"/>
    <script src="<?php echo TPL_URL; ?>js/foundation.alert.js"></script>
    <script src="<?php echo TPL_URL; ?>js/drp_common.js"></script>
</head>
<body class="body-gray">
<div data-alert="" class="alert-box alert" style="display: none;" id="errerMsg"><a href="#" class="close">×</a></div>
<div class="personal-block">
    <div class="personal-center" id="divInfo" style="margin-top:0">
        <ul class="side-nav" id="list">
            <li>
                <a href="drp_ucenter.php?a=username">
                    <div class="title user-position"><span class="text" tage="loginname">昵称</span></div>
                    <div class="cont-value"><i class="arrow"></i><span class="value"><?php echo $user['nickname'] ? $user['nickname'] : '未填写' ;?></span></div>
                </a>
            </li>
            <li>
                <a href="drp_ucenter.php?a=mobile">
                    <div class="title"><span class="text" tage="mobilephone">绑定手机</span></div>
                    <div class="cont-value"><i class="arrow"></i><span class="value" id="mobilephone"><?php echo $user['phone'] ? $user['phone'] : '未绑定' ;?></span></div>
                </a>
            </li>
            <li>
                <a href="drp_ucenter.php?a=reserved">
                    <div class="title"><span class="text" tage="truename">预留信息</span></div>
                    <div class="cont-value"><i class="arrow"></i><span class="value" id="truename"><?php echo $user['order_name'] ? $user['order_name'] : '未填写' ;?></span>
                    </div>
                </a>
            </li>
            <li>
                <a href="drp_ucenter.php?a=pwd">
                    <div class="title"><span class="text" tage="password">修改密码</span></div>
                    <div class="cont-value"><i class="arrow"></i><span class="value">&nbsp;</span></div>
                </a>
            </li>
        </ul>
    </div>
</div>
<?php echo $shareData;?>
</body>
</html>