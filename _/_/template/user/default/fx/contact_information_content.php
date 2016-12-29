<form class="form-horizontal" style="">
    <div class="control-group">
        <label class="control-label">
            <em class="required">*</em>
            客服电话：
        </label>
        <div class="controls">
          <input type="text" name="mobile" placeholder="请输入客服电话"  value="<?php echo $information['service_tel'];?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">
            <em class="required">*</em>
            客服 QQ：
        </label>
        <div class="controls">
            <input type="text" name="qq" placeholder="请输入客服QQ" value="<?php echo $information['service_qq'];?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">

            客服微信：
        </label>
        <div class="controls">
            <input type="text" name="weixin" placeholder="请输入您的微信号" value="<?php echo $information['service_weixin'];?>">
        </div>
    </div>    
    <div class="form-actions" style="margin-top:25px">
        <button type="button" id="sub-button" class="ui-btn ui-btn-primary js-physical-submit">添加</button>
    </div>
</form>
<script>
          
    $(function(){

        $('.js-physical-submit').live('click', function(){
            var tel = $("input[name='mobile']").val();
            var qq = $("input[name='qq']").val();
            var weixin = $("input[name='weixin']").val();

            var telReg    = /^[0-9]{3,4}-[0-9]{7,8}$/;//验证电话号码
            var phoneReg  = /^1[1-9][0-9]{9}$/;//验证手机号码
            var qqReg 	  = /^[1-9]*[1-9][0-9]*$/;

            if( !(telReg.test(tel) || phoneReg.test(tel))){
                layer_tips(1,'请填写正确的电话');
                flag 	= false;
                return flag;
            }

            if(!qqReg.test(qq)){
                layer_tips(1,'请填写正确的qq号码');
                flag 	= false;
                return flag;
            }

            $.post(information_url, {'type': 'add', 'tel': tel, 'qq': qq, 'weixin': weixin}, function(data){
            if (data.err_code == 0) {
                $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                $('.modal').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow",function(){
                    $('.modal-backdrop,.modal').remove();
                });
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
                t = setTimeout('msg_hide()', 1500);
            })
        })

    });
</script>
