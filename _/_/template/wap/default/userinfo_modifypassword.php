<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>密码重置</title>
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/passres.css">
    <script src="<?php echo TPL_URL;?>js/jquery-1.7.2.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
</head>
<body>
<p class="passres-tit">本页密码重置适用于：绑定微信号后忘记手机注册用户重置密码</p>
<section class="pass-con">
    <div class="pass-con-div pass-con-div-first">
        <div class="fl pass-con-lin pass-con-lin-le">昵称</div>
        <div class="fl pass-con-lin pass-con-lin-ri"><?php echo $user_result['nickname'];?></div>
        <div class="clear"></div>
    </div>
    <div class="pass-con-div">
        <div class="fl pass-con-lin pass-con-lin-le">手机号码</div>
        <input type="hidden" name="phone" value="<?php echo $user_result['phone'];?>"/>
        <div class="fl pass-con-lin  pass-con-lin-ri"><?php echo $user_result['phone'];?></div>
        <div class="clear"></div>
    </div>
</section>
<section class="pass-con">
    <div class="pass-con-div pass-con-div-first">
        <div class="fl pass-con-lin pass-con-lin-le">重置帐号密码</div>
        <input type="password" name="password1" class="pass-con-lin  pass-con-lin-ri" placeholder="请输入新的密码">
        <div class="clear"></div>
    </div>
    <div class="pass-con-div">
        <div class="fl pass-con-lin pass-con-lin-le">确认帐号密码</div>
        <input type="password" name="password2" class="pass-con-lin  pass-con-lin-ri" placeholder="请输入新的密码">
        <div class="clear"></div>
    </div>
</section>
<div class="btn">保存</div>
<script type="text/javascript">
    function layer_tips(msg_type,msg_content){
        layer.closeAll();
        var time = msg_type==0 ? 3 : 4;
        var type = msg_type==0 ? 1 : (msg_type != -1 ? 0 : -1);
        if(type == 0){
            msg_content = '<font color="red">'+msg_content+'</font>';
        }
        $.layer({
            title: false,
            offset: ['80px',''],
            closeBtn:false,
            shade:[0],
            time:time,
            dialog:{
                type:type,
                msg:msg_content
            }
        });
    };
    $(function(){
        $(".btn").click(function(){
            var passwd1 = $('input[name="password1"]').val();
            var passwd2 = $('input[name="password2"]').val();
            var phone = $('input[name="phone"]').val();
            if(passwd1=='' || passwd2==''){
                layer_tips(1,"输入密码不能为空");
                return false;
            }
            if(passwd1==passwd2){
                $.post("",{password : passwd1,phone : phone}, function (data) {
                        if (data.err_code == '0') {
                            layer_tips(0,data.err_msg);
                        } else {
                            layer_tips(1,data.err_msg);
                        }
                });
            }else{
                layer_tips(1,"两次输入密码不一致");
            }
        });
    })
</script>
</body>
</html>