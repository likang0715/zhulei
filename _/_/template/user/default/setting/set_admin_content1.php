<?php
  $goodesMenu = array(
      '发布商品','出售中的商品','已售罄的商品','仓库中的商品','商品分组','商品评价','店铺评价'
  );

  $ordersMenu = array(
    '订单概况','所有订单','到店自提订单','货到付款订单','加星订单','收入/提现','未对帐/已对账'
  );
?>
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
            <input type="text" name="phone" placeholder="请输入您的手机号码" value="">
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
            <em class="required">*</em>
            所属区域：
        </label>
        <div class="controls ui-regions js-regions-wrap">
            <span>
                <select name="item_store" id="store_id">
                    <option value="">选择店铺</option>
                    <?php foreach($store_physical as $store_name):?>
                    <option value="<?php echo $store_name['pigcms_id'];?>"><?php echo $store_name['name'];?></option>
                    <?php endforeach;?>
                </select>
            </span>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">
            <em class="required">*</em>
            商品管理应用：
        </label>
        <div class="controls">
            <input type="hidden" class="js-not-autoup" name="goods_control" value="goods">
            <label class="checkbox inline">
                <input type="checkbox" class="js-not-autoup" name="goods[]" value="create">发布商品/新增
            </label>
            <label class="checkbox inline">
                <input  type="checkbox" class="js-not-autoup" name="goods[]" value="index">出售中商品
            </label>
            <label class="checkbox inline">
                <input  type="checkbox" class="js-not-autoup" name="goods[]" value="stockout">已售罄的商品
            </label>
            <label class="checkbox inline">
                <input type="checkbox" class="js-not-autoup" name="goods[]" value="soldout">仓库中的商品
            </label>
            <label class="checkbox inline">
                <input  type="checkbox" class="js-not-autoup" name="goods[]" value="category">商品分组
            </label>
            <label class="checkbox inline">
                <input  type="checkbox" class="js-not-autoup" name="goods[]" value="product_comment">商品评价
            </label>
            <label class="checkbox inline">
                <input  type="checkbox" class="js-not-autoup" name="goods[]" value="store_comment">店铺评价
            </label>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">
            <em class="required">*</em>
            商品管理动作：
        </label>
        <div class="controls">
            <label class="checkbox inline">
                <input  type="checkbox" class="js-not-autoup" name="goods[]" value="edit">出售已售仓库商品分组中商品/编辑
            </label>
            <label class="checkbox inline">
                <input  type="checkbox" class="js-not-autoup" name="goods[]" value="del_product">出售已售仓库商品分组中商品/删除
            </label>
            <label class="checkbox inline">
                <input  type="checkbox" class="js-not-autoup" name="goods[]" value="get_qrcode_activity">出售已售仓库中商品/推广商品
            </label>
            <label class="checkbox inline">
                <input  type="checkbox" class="js-not-autoup" name="goods[]"  value="checkoutProduct">导出商品
            </label>			
         </div>
    </div>

    <div class="control-group">
        <label class="control-label">
            <em class="required">*</em>
            订单管理应用：
        </label>
        <div class="controls">
            <input type="hidden" class="js-not-autoup" name="order_control" value="order">
            <label class="checkbox inline">
                <input type="checkbox" class="js-not-autoup" name="order[]" value="dashboard">订单概况
            </label>
            <label class="checkbox inline">
                <input  type="checkbox" class="js-not-autoup" name="order[]" value="all">所有订单
            </label>
            <label class="checkbox inline">
                <input  type="checkbox" class="js-not-autoup" name="order[]" value="selffetch">到店自提订单
            </label>
            <label class="checkbox inline">
                <input type="checkbox" class="js-not-autoup" name="order[]" value="codpay">货到付款订单
            </label>
            <label class="checkbox inline">
                <input  type="checkbox" class="js-not-autoup" name="order[]" value="star">加星订单
            </label>
            <label class="checkbox inline">
                <input  type="checkbox" class="js-not-autoup" name="order[]" value="create">新增
            </label>
            <label class="checkbox inline">
                <input type="checkbox" class="js-not-autoup" name="order[]" value="check">未对帐/已对账
            </label>
            <label class="checkbox inline">
                <input type="checkbox" class="js-not-autoup" name="order[]"  value="order_checkout_csv">导出订单
            </label>				
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">
            <em class="required">*</em>
            物流管理应用：
        </label>
        <div class="controls">
            <input type="hidden" class="js-not-autoup" name="trade_control" value="trade">
            <label class="checkbox inline">
                <input type="checkbox" class="js-not-autoup" name="trade[]" value="delivery">物流工具
            </label>
            <label class="checkbox inline">
                <input  type="checkbox" class="js-not-autoup" name="trade[]" value="income">收入提现
            </label>
        </div>
    </div>
    <div class="form-actions" style="margin-top:50px">
        <button type="button" id="sub-button" class="ui-btn ui-btn-primary js-physical-submit">添加</button>
    </div>
</form>

<script>
    $(function(){
        // 模拟checkbox
        $(".checkbox").click(function(){

            if($(this).hasClass('active')) {
                $(this).find('input').removeAttr('checked').parent().removeClass('active');
            }else {
                $(this).find('input').attr('checked','checked').parent().addClass('active');
            }
        });

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
			
			
            if($("select[name='item_store']").val() == '')
            {
                $("select[name='item_store']").parents('.controls').addClass('error');
                $("select[name='item_store']").next('.error-message').remove();
                $("select[name='item_store']").after('<p class="help-block error-message">所属区域必须选择</p>');
            }else{
                $("select[name='item_store']").parents('.controls').removeClass('error');
                $("select[name='item_store']").next('.error-message').remove();
            }

            var goodeMenu = 0;
            $(".js-not-autoupdate").each(function (){
                if ($(this).is(':checked')){
                    goodeMenu += 1;
                }
            });

            if(goodeMenu == 0)
            {
                $("#goodsMenu").parents('.controls').addClass('error');
                $("#goods").next('.error-message').remove();
                $("#goods").after('<p class="help-block error-message">必须选择一个商品菜单</p>');
            }else{
                $("#goodsMenu").parents('.controls').removeClass('error');
                $("#goods").next('.error-message').remove();
            }
            var orderMenu = 0;
            $(".js-not-autoup").each(function (){
                if ($(this).is(':checked')){
                    orderMenu += 1;
                }
            });

            if(orderMenu == 0)
            {
                $("#orderMenu").parents('.controls').addClass('error');
                $("#orders").next('.error-message').remove();
                $("#orders").after('<p class="help-block error-message">必须选择一个订单菜单</p>');
            }else{
                $("#orderMenu").parents('.controls').removeClass('error');
                $("#orders").next('.error-message').remove();
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