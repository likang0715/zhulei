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
    <title>修改预留信息</title>
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
    .personal-block.order-title{
        background:none;
        margin:0;
        margin-top:10px;
        text-align:center;
        font-size:18px;
    }
    .personal-block.order-title h4{
        line-height:48px;
        height:48px;
        color: #666;
        margin:0;
    }
    .personal-block.order-submit{
        background:none;
    }
    .personal-block label{
        width: 80px;
        line-height: 28px;
        padding: 10px 0;
        display: table-cell;
    }
    .personal-block input.js-txt-order{
        border: 0;
        box-shadow: none;
        margin: 0;
        padding: 10px 0;
        display: table-cell;
    }
    .personal-block input.js-txt-order:focus{
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
    .personal-block.order-code .order-send{
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
    .personal-block.order-msg{
        background:none;
    }
    .personal-block.order-msg p{
        font-size:14px;
        color: #999;
        line-height:18px;
    }
    </style>
    <script type="text/javascript">
    var url = "./drp_ucenter.php?a=order";
    function saveBtn () {
        var name = $(".js-txt-order-name").val().trim();
		var tel = $(".js-txt-order-tel").val().trim();
        if (name == "") {
            motify.log("昵称不能为空");
            return;
        }
        $.post(url, {'order_name': name, 'order_tel': tel}, function(data){
            console.log(data)
            if (data == 0) {
                motify.log("昵称修改成功");
                setTimeout(backPage, 1500)
            } else {
                motify.log("昵称修改失败");
            }
        })
    }
    function backPage(){
     window.history.go(-1);
 }
 </script>
</head>
<body class="body-gray">
    <div class="personal-block order-title">
        <h4>修改预留信息</h4>
    </div>
    <div class="personal-block order-input">
        <label>姓名</label>
        <input type="text" name="order_name" value="<?php echo $user['order_name'] ? $user['order_name'] : '' ;?>" autocomplete="off" maxlength="10" class="js-txt-order js-txt-order-name personal-order" placeholder="请输入姓名">
    </div>
    <div class="personal-block order-code">
        <label>手机号</label>
        <input type="text" name="order_tel" value="<?php echo $user['order_tel'] ? $user['order_tel'] : '' ;?>" autocomplete="off" maxlength="11" class="js-txt-order js-txt-order-tel personal-order" placeholder="请输入手机号">
    </div>
    <div class="personal-block order-submit">
        <button type="submit" class="personal-submit js-order-submit" onClick="saveBtn ();">确认提交</button>
        <button type="button" class="personal-cancel js-order-cancel" onClick="window.history.go(-1);">返回</button>
    </div>
    <div class="personal-block order-msg">
        <p>* 预留信息将会在茶馆包厢预订和茶会报名时自动填写</p>
    </div>
    <?php echo $shareData;?>
</body>
</html>