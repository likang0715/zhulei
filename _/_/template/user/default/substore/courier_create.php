<?php
  $goodesMenu = array(
      '发布商品','出售中的商品','已售罄的商品','仓库中的商品','商品分组','商品评价','店铺评价'
  );

  $ordersMenu = array(
    '订单概况','所有订单','到店自提订单','货到付款订单','加星订单','收入/提现','未对帐/已对账'
  );
?>
<form class="form-horizontal" onsubmit="return false;">
    <div class="control-group">
        <label class="control-label">
            <em class="required">*</em>
            用户名：
        </label>
        <div class="controls">
            <input type="text" name="nickname" placeholder="请输入配送员的昵称"  value="">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">
            <em class="required">*</em>
            手机号码：
        </label>
        <div class="controls">
            <input type="text" name="phone" placeholder="请输入配送员的手机号码" value="">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">
            <em class="required">*</em>
            密码：
        </label>
        <div class="controls">
            <input type="password" name="password" placeholder="请输入配送员的密码" value="">
        </div>
    </div>

    <?php if ($user_session['type'] == 0) { ?>
    <div class="control-group">
        <label class="control-label">
            <em class="required">*</em>
            所属门店：
        </label>
        <div class="controls ui-regions js-regions-wrap">
            <span>
                <select name="physical_id" id="store_id">
                    <option>选择店铺</option>
                    <?php foreach($store_physical as $store_name):?>
                    <option value="<?php echo $store_name['pigcms_id'];?>"><?php echo $store_name['name'];?></option>
                    <?php endforeach;?>
                </select>
            </span>
        </div>
    </div>
    <?php } ?>

    <div class="form-actions" style="margin-top:50px">
        <button type="button" id="sub-button" class="ui-btn ui-btn-primary js-physical-submit">添加</button>
    </div>
</form>

<script>
    $(function(){

        $('#sub-button').click(function(){

            var nowDom = $(this);
            layer.closeAll();
            var formObj = $('.form-horizontal').serialize();

            if($("input[name='nickname']").val() == '')
            {
                $("input[name='nickname']").parents('.controls').addClass('error');
                $("input[name='nickname']").next('.error-message').remove();
                $("input[name='nickname']").after('<p class="help-block error-message">用户昵称不能为空</p>');
            }else {
                $("input[name='nickname']").parents('.controls').removeClass('error');
                $("input[name='nickname']").next('.error-message').remove();
            }

            var mobile = $("input[name='phone']").val();
            if (!/^1[0-9]{10}$/.test(mobile)) {
                $("input[name='phone']").parents('.controls').addClass('error');
                $("input[name='phone']").next('.error-message').remove();
                $("input[name='phone']").after('<p class="help-block error-message">请正确填写手机号</p>');
            }else {
                $("input[name='phone']").parents('.controls').removeClass('error');
                $("input[name='phone']").next('.error-message').remove();
            }

            if($("input[name='password']").val() == '' || $("input[name='password']").val()<6)
            {
                $("input[name='password']").parents('.controls').addClass('error');
                $("input[name='password']").next('.error-message').remove();
                $("input[name='password']").after('<p class="help-block error-message">密码不能小于六位数</p>');
            }else{
                $("input[name='password']").parents('.controls').removeClass('error');
                $("input[name='password']").next('.error-message').remove();
            }

            if ($('.error-message').length == 0) {
                nowDom.prop('disabled',true).html('添加中...');

                $.post(courier_add,formObj,function(result){
                    if(typeof(result) == 'object'){
                        if(result.err_code){
                            nowDom.prop('disabled',false).html('添加');
                            layer_tips(1,result.err_msg);
                        }else{
                            window.location.hash = 'courier_list';
                            window.location.reload();
                            layer_tips(0,result.err_msg);
                        }
                    }else{
                        nowDom.prop('disabled',false).html('添加');
                        layer_tips(1,'系统异常，请重试提交');

                    }
                });
            }
        });
    })
</script>