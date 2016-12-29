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
    <title>修改手机号</title>
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
        position: relative;
    }
    .personal-block.pwd-title{
        background:none;
        margin:0;
        margin-top:10px;
        text-align:center;
        font-size:18px;
    }
    .personal-block.pwd-title h4{
        line-height:48px;
        height:48px;
        color: #666;
        margin:0;
    }
    .personal-block.pwd-submit{
        background:none;
    }
    .personal-block label{
        width: 80px;
        line-height: 28px;
        padding: 10px 0;
        display: table-cell;
    }
    .personal-block input.js-txt-pwd{
        border: 0;
        box-shadow: none;
        margin: 0;
        padding: 10px 0;
        display: table-cell;
    }
    .personal-block input.js-txt-pwd:focus{
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
    .personal-block.pwd-code .pwd-send{
        position: absolute;
        top: 8px;
        right: 10px;
        height: 32px;
        line-height: 32px;
        padding-left: 6px;
        padding-right: 6px;
        font-weight: normal;
        width: 78px;
        font-size: 12px;
        color: #06bf04;
        border-color: #0c3;
        background: white;
    }
    </style>
    <script type="text/javascript">
    $(document).ready(function() {
        var mobile = "<?php echo $user['phone'] ? $user['phone'] : '' ;?>";
        if (mobile.trim().length < 11) {
            motify.log("请先绑定手机号");
            setTimeout('backPage("./drp_ucenter.php?&a=mobile")', 2000)
        };
    });
    var url = "./drp_ucenter.php?&a=pwd";
    function saveBtn () {
        var value = $(".js-txt-pwd").val().trim();
        if (value == "") {
            motify.log("昵称不能为空");
        }
        $.post(url, {'type': 'phone', 'phone': value}, function(data){
            console.log(data)
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
    <div class="personal-block pwd-title">
        <h4>修改密码</h4>
    </div>
    <div class="personal-block pwd-mobile">
        <label>手机号</label>
        <input type="text" name="phone" value="<?php echo $user['phone'] ? $user['phone'] : '' ;?>" autocomplete="off" maxlength="10" class="js-txt-pwd personal-pwd" readonly>
    </div>
    <div class="personal-block pwd-code">
        <label>验证码</label>
        <input type="text" name="phone" value="" autocomplete="off" maxlength="11" class="js-txt-pwd personal-pwd" placeholder="请输入短信验证码">
        <button type="button" class="js-send-msg pwd-send">获取验证码</button>
    </div>
    <div class="personal-block pwd-input">
        <label>新密码</label>
        <input type="text" name="phone" value="" autocomplete="off" maxlength="10" class="js-txt-pwd personal-pwd" placeholder="请输入8-20位数字和字母组合">
    </div>
    <div class="personal-block pwd-submit">
        <button type="submit" class="personal-submit js-pwd-submit" onclick="saveBtn ();">确认提交</button>
        <button type="button" class="personal-cancel js-pwd-cancel" onclick="window.history.go(-1);">返回</button>
    </div>
    <?php echo $shareData;?>
</body>
</html>