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
    .personal-block.mobile-title{
        background:none;
        margin:0;
        margin-top:10px;
        text-align:center;
        font-size:18px;
    }
    .personal-block.mobile-title h4{
        line-height:48px;
        height:48px;
        color: #666;
        margin:0;
    }
    .personal-block.mobile-submit{
        background:none;
    }
    .personal-block label{
        width: 80px;
        line-height: 28px;
        padding: 10px 0;
        display: table-cell;
    }
    .personal-block input.personal-mobile{
        border: 0;
        box-shadow: none;
        margin: 0;
        padding: 10px 0;
        display: table-cell;
    }
    .personal-block input.personal-mobile:focus{
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
    .personal-block.mobile-code .mobile-send{
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
    var url = "./drp_ucenter.php?&a=mobile";
    var codeStatus = true;
    var codeTime = 120 ;
    $(document).ready(function() {
        $(".js-send-msg").click(function(event) {
            event.stopPropagation();
            var mobile = $(".js-txt-mobile").val();
            var mobile_reg = /^0?1[3|4|5|7|8][0-9]\d{8}$/;
            if(!mobile_reg.test(mobile)) {
                motify.log("手机号格式不正确");
                return false;
            }
            $.post('drp_ucenter.php?a=smscode', {"post_type": "1","mobile": mobile},function(data) {
                var returndata= $.parseJSON(data);
                if (returndata.err_code == 1) {
                    motify.log(returndata.err_msg);
                    return false;
                }
                if (returndata.err_code == 2) {
                    motify.log("短信验证码已发送");
                }
                if (returndata.err_code == 0) {
                    codeTime = returndata.err_msg;
                };
            });
        });
    });
    function saveBtn () {
        var mobile = $(".js-txt-mobile").val();
        var sms_code = $(".js-code-mobile").val();
        var mobile_reg = /^0?1[3|4|5|7|8][0-9]\d{8}$/;
        if (mobile == "") {
            motify.log("手机号不能为空");
            return;
        }
        if(!mobile_reg.test(mobile)) {
            motify.log("手机号格式不正确");
            return false;
        }
        if (sms_code == "") {
            motify.log("短信验证码不能为空");
            return;
        }
        $.post('drp_ucenter.php?a=smscode', {"post_type": "2","mobile": mobile,"sms_code": sms_code},function(data) {
            var returndata= $.parseJSON(data);
            if (returndata.err_code == 1) {
                motify.log(returndata.err_msg);
                return false;
            }
            if (returndata.err_code == 2) {
                motify.log("手机号绑定成功");
                setTimeout('backPage("./drp_ucenter.php?a=profile")',2000)
            }
        });
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
    <div class="personal-block mobile-title">
        <h4>修改手机号</h4>
    </div>
    <div class="personal-block mobile-input">
        <label>新手机号</label>
        <input type="text" name="phone" value="" autocomplete="off" maxlength="11" class="js-txt-mobile personal-mobile" placeholder="请输入新手机号">
    </div>
    <div class="personal-block mobile-code">
        <label>验证码</label>
        <input type="text" name="code" value="" autocomplete="off" maxlength="11" class="js-code-mobile personal-mobile" placeholder="请输入短信验证码">
        <button type="button" class="js-send-msg mobile-send">获取验证码</button>
    </div>
    <div class="personal-block mobile-submit">
        <button type="submit" class="personal-submit js-mobile-submit" onclick="saveBtn ();">确认绑定</button>
        <button type="button" class="personal-cancel js-mobile-cancel" onclick="window.history.go(-1);">返回</button>
    </div>
    <?php echo $shareData;?>
</body>
</html>