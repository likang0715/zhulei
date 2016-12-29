<?php 
    $rbac = option('physical.rbac'); 
    $rbacLink = option('physical.link');
?>
<style type="text/css">
    .form-horizontal {background-color: #fff; padding-top: 20px;border: 1px solid #ddd;}
    .control-group {-webkit-user-select:none; -moz-user-select:none; -ms-user-select:none; user-select:none;} 
    .controls .ipt-box > .checkbox:first-child {margin-right: 15px;}
    .checkbox.inline + .checkbox.inline {margin-left: 0; margin-right: 15px;} 
    .ipt-box {margin-right: 60px; padding: 0 0 5px 10px; border-radius: 4px; border: 1px solid #ccc;position: relative;}
    .ipt-checkAll {position: absolute; top: 0; right: -50px;}
    .ipt-checkAll label { vertical-align: middle;}
    .ipt-checkAll label input {margin-top: 0;}
    .ipt-box .link-color {color:#07d;}
    .warn-tip {background:#fefbe4;border:1px solid #f3ecb9;color:#993300;padding:10px;font-size:12px;margin-top:5px;}
    .warn-tip .warn-label {color:#f00;font-weight:700}
</style>
<div class="warn-tip">
    <font class="warn-label">温馨提示：</font> 
    【蓝色选项】为左侧菜单浏览权限，【黑色选项】为操作项权限
</div>
<form class="form-horizontal" style="">
    <div class="control-group">
        <label class="control-label">
            <em class="required">*</em>
            用户名：
        </label>
        <div class="controls">
            <input type="text" name="nickname" placeholder="请输入您的昵称"  value="">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">
            <em class="required">*</em>
            手机号码：
        </label>
        <div class="controls">
            <input type="text" name="phone" placeholder="请输入您的手机号码" value="" autocomplete="off" disableautocomplete >
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">
            <em class="required">*</em>
            密码：
        </label>
        <div class="controls">
            <input type="password" name="password" placeholder="请输入您的密码" value="">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">
            <em class="required">*</em>所属门店：
        </label>
        <div class="controls ui-regions js-regions-wrap">
            <span>
                <select name="item_store" id="store_id" style="width:220px;">
                    <option value=0>选择店铺</option>
                    <?php foreach($store_physical as $store_name):?>
                    <option value="<?php echo $store_name['pigcms_id'];?>"><?php echo $store_name['name'];?></option>
                    <?php endforeach;?>
                </select>
            </span>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">
            <em class="required"></em>
            商品管理：
        </label>
        <div class="controls js-goods-tip">
            <div class="ipt-box">
            <?php foreach ($rbac['goods'] as $method => $nameTxt) { ?>
                <label class="checkbox inline <?php if (in_array($method, $rbacLink['goods'])) echo 'link-color'; ?>">
                    <input type="checkbox" class="js-not-autoup" name="goods[]" value="<?php echo $method ?>"><?php echo $nameTxt ?>
                </label>
            <?php } ?>
                <div class="ipt-checkAll">
                    <label>
                        <input type="checkbox" class="checkAll"> 全选
                    </label>
                </div>
            </div>

        </div>
    </div>

    <div class="control-group">
        <label class="control-label">
            <em class="required"></em>
            订单管理：
        </label>
        <div class="controls js-order-tip">
            <div class="ipt-box">
            <?php foreach ($rbac['order'] as $method => $nameTxt) { ?>
                <label class="checkbox inline <?php if (in_array($method, $rbacLink['order'])) echo 'link-color'; ?>">
                    <input type="checkbox" class="js-not-autoup" name="order[]" value="<?php echo $method ?>"><?php echo $nameTxt ?>
                </label>
            <?php } ?>
                <div class="ipt-checkAll">
                    <label>
                        <input type="checkbox" class="checkAll"> 全选
                    </label>
                </div>
            </div>

        </div>
    </div>

    <div class="control-group">
        <label class="control-label">
            <em class="required"></em>
            物流管理：
        </label>
        <div class="controls js-express-tip">
            <div class="ipt-box">
            <?php foreach ($rbac['trade'] as $method => $nameTxt) { ?>
                <label class="checkbox inline <?php if (in_array($method, $rbacLink['trade'])) echo 'link-color'; ?>">
                    <input type="checkbox" class="js-not-autoup" name="trade[]" value="<?php echo $method ?>"><?php echo $nameTxt ?>
                </label>
            <?php } ?>
                <div class="ipt-checkAll">
                    <label>
                        <input type="checkbox" class="checkAll"> 全选
                    </label>
                </div>
            </div>

        </div>
    </div>
	<!--yfz@20160603 增加订座权限 -->
	<div class="control-group">
        <label class="control-label">
            <em class="required"></em>
            订座管理：
        </label>
        <div class="controls js-express-tip">
            <div class="ipt-box">
            <?php foreach ($rbac['meaz'] as $method => $nameTxt) { ?>
                <label class="checkbox inline <?php if (in_array($method, $rbacLink['meaz'])) echo 'link-color'; ?>">
                    <input  type="checkbox" class="js-not-autoup" name="meaz[]" <?php echo in_array($method, $methodList['meaz']) ? 'checked' : '';?> value="<?php echo $method ?>"><?php echo $nameTxt ?>
                </label>
            <?php } ?>
                <div class="ipt-checkAll">
                    <label>
                        <input type="checkbox" class="checkAll"> 全选
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions" style="margin-top:50px">
        <button type="button" id="sub-button" class="ui-btn ui-btn-primary js-physical-submit">添加</button>
    </div>
</form>

<script>
    $(function(){

        //check all
        $(".ipt-checkAll input.checkAll").each(function(){
            var self = $(this);
            var box = self.parents(".controls:first");
            var itemIpts = $(".ipt-box", box).find("input.js-not-autoup");
            self.on("click", function(){

                if($(this).data('check') == 1){
                    $(this).data('check', 0);
                    itemIpts.prop('checked', false);
                }else{
                    $(this).data('check', 1);
                    itemIpts.prop('checked', true);
                }
            });
        });

        $('#sub-button').click(function(){

            layer.closeAll();

            var nowDom = $(this);
            var formObj = $('.form-horizontal').serialize();
            var iptNickname = $("input[name='nickname']");
            var iptPhone = $("input[name='phone']");
            var iptPassword = $("input[name='password']");
            var selectPhysical = $("select[name=item_store]");

            if(iptNickname.val() == '')
            {
                iptNickname.parents('.controls').addClass('error');
                iptNickname.next('.error-message').remove();
                iptNickname.after('<p class="help-block error-message">用户昵称不能为空</p>');
            }else {
                iptNickname.parents('.controls').removeClass('error');
                iptNickname.next('.error-message').remove();
            }

            var mobile = iptPhone.val();
            if (!/^1[0-9]{10}$/.test(mobile)) {
                iptPhone.parents('.controls').addClass('error');
                iptPhone.next('.error-message').remove();
                iptPhone.after('<p class="help-block error-message">请正确填写手机号</p>');
            }else {
                iptPhone.parents('.controls').removeClass('error');
                iptPhone.next('.error-message').remove();
            }

            if(iptPassword.val() == '' || $("input[name='password']").val()<6)
            {
                iptPassword.parents('.controls').addClass('error');
                iptPassword.next('.error-message').remove();
                iptPassword.after('<p class="help-block error-message">密码不能小于六位数</p>');
            }else{
                iptPassword.parents('.controls').removeClass('error');
                iptPassword.next('.error-message').remove();
            }

            var item_store = selectPhysical.val();
            if (item_store == 0) {
                selectPhysical.parents('.controls').addClass('error');
                selectPhysical.next('.error-message').remove();
                selectPhysical.after('<p class="help-block error-message">请选择一个门店</p>');
            } else {
                selectPhysical.parents('.controls').addClass('error');
                selectPhysical.next('.error-message').remove();
            }

            if ($('.error-message').length == 0) {
                nowDom.prop('disabled',true).html('添加中...');

                $.post(add_admin,formObj,function(result){
                    if(typeof(result) == 'object'){
                        if(result.err_code){
                            nowDom.prop('disabled',false).html('添加');
                            layer_tips(1,result.err_msg);
                        }else{
                            window.location.hash = 'list';
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