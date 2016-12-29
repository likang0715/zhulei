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
    <title>修改昵称</title>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/base.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/foundation.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/normalize.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/common.css"/>
    <script src="<?php echo TPL_URL; ?>js/jquery.js"></script>
    <script src="<?php echo TPL_URL; ?>js/base.js"></script>
    <style type="text/css">
    .personal-block{
        padding-left: 10px;
        padding-right: 10px;
        overflow: hidden;
        float: left;
        display: table;
        width: 100%;
        background:#fff;
        margin-bottom: 16px;
    }
    .personal-block.username-title{
        background:none;
        margin:0;
        margin-top:10px;
        text-align:center;
        font-size:18px;
    }
    .personal-block.username-title h4{
        line-height:48px;
        height:48px;
        color: #666;
        margin:0;
    }
    .personal-block.username-submit{
        background:none;
    }
    .personal-block label{
        width: 80px;
        line-height: 28px;
        padding: 10px 0;
        display: table-cell;
    }
    .personal-block input.js-txt-username{
        border: 0;
        box-shadow: none;
        margin: 0;
        padding: 10px 0;
        display: table-cell;
    }
    .personal-block input.js-txt-username:focus{
        border: 0;
        box-shadow: none;
        margin: 0;
        background:none;
    }
    .personal-block .personal-submit{
        width: 100%;
        color: #fff;
        background-color: #06bf04;
        border-color: #03b401;
        height: 40px;
        line-height: 40px;
        margin-bottom: 16px;
        font-size: 14px;
    }
    .personal-block .personal-cancel{
        border: 1px solid #e5e5e5;
        -webkit-tap-highlight-color: transparent;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        background-color: #fff;
        border-color: #e5e5e5;
        height: 40px;
        line-height: 40px;
        color:#333;
        font-size: 14px;
    }
    </style>
    <script type="text/javascript">
    var url = "./drp_ucenter.php?&a=username";
    function saveBtn () {
        var oldname = $(".js-txt-username").attr('data-old').trim();
        var value = $(".js-txt-username").val().trim();
        if (value == "") {
            motify.log("昵称不能为空");
            return;
        }
        if (value == oldname) {
            motify.log("与原昵称一致,无需修改");
            return;
        }
        $.post(url, {'type': 'nickname', 'nickname': value}, function(data){
            if (data == 0) {
                motify.log("昵称修改成功");
                setTimeout(backPage, 1500)
            } else {
                motify.log("昵称修改失败");
            }
        })
    }
    function backPage(gotourl){
        if (gotourl) {
            window.location.href =  gotourl;
        } else{
            window.history.go(-1);
        };
    }
    </script>
</head>
<body class="body-gray">
    <div class="personal-block username-title">
        <h4>修改昵称</h4>
    </div>
    <div class="personal-block username-input">
        <label>昵称</label>
        <input data-old="<?php echo $user['nickname'] ? $user['nickname'] : '' ;?>" type="text" name="nickname" value="<?php echo $user['nickname'] ? $user['nickname'] : '' ;?>" autocomplete="off" maxlength="10" class="js-txt-username personal-username" placeholder="请输入昵称">
    </div>
    <div class="personal-block username-submit">
        <button type="submit" class="personal-submit js-username-submit" onclick="saveBtn ();">确认提交</button>
        <button type="button" class="personal-cancel js-username-cancel" onclick="window.history.go(-1);">返回</button>
    </div>
    <?php echo $shareData;?>
</body>
</html>