$(function(){

    // 统计更新
    function cart_change () {
        // 更改单个产品小计
        var cart_total = 0;
        var cart_money = 0;

        // 店铺所属的变空，删除店铺组
        $("ul.js-cart-shop").each(function(){
            var self = $(this);
            if (self.find(".js-checkbox-item").length == 0) {
                self.remove();
            }
        });

        // 全空，显示空内容
        if ($(".js-checkbox-item").length == 0) {
            $(".js-cart-null").show();
        }

        $("input.js-checkbox-item").each(function () {

            var self = $(this);
            var numIpt = self.closest(".m-cart-list-items").find("input.w-number-input");
            var num = numIpt.val();
            var itemPrice = parseInt(self.data("item_price")*100)*0.01;
            var itemTotal = itemPrice*num;

            // 小计
            self.closest(".m-cart-list-items").find(".js-cart-amount").text(itemTotal);
            if (self.attr("checked") == "checked") {
                cart_money += itemTotal;
            }

        });
        
        // 总价
        $("#totalAmount").text(cart_money);
        
    }

    // 店铺全选
    $(".js-checkbox-shop").click(function(){

        var store_id = $(this).val();
        if ($(this).attr("checked") == "checked") {
            $(".js-checkbox-item[data-store_id="+store_id+"]").attr("checked", true);
            $(this).closest(".m-cart-list").siblings().find("input[type='checkbox']").attr("checked", false);
        } else {
            $(".js-checkbox-item[data-store_id="+store_id+"]").attr("checked", false);
        }
        
        cart_change();

    });

    // 单选
    $(".js-checkbox-item").click(function(){

        if ($(this).prop("checked")) {
            $(this).closest(".m-cart-list").siblings().find("input[type='checkbox']").attr("checked", false);
        }

        cart_change();

    });

    // 删除
    $(".js-delete-item").on("click", function() {

        var self = $(this);
        var cart_id = self.closest(".m-cart-list-items").find(".js-checkbox-item").val();

        dialog.init(function(){

            $.post(miniUrls.catrdelurl, { type:"cart_del", cart_id:cart_id }, function(data){
                if (data.err_code == 0) {
                    self.closest(".m-cart-list-items").remove();
                    cart_change();
                } else {
                    dialog.init(function(){}, '', data.err_msg);
                }

            },'json');

        });
    });

    // 清空购物车
    $(".js-delete-all").click(function(){

        if ($(".js-checkbox-item").length == 0) {
            dialog.init(function(){}, '', '购物车已经清空！');
            return;
        }

        dialog.init(function(){

            $.post(cart_ajax_url, { type:"del_all" }, function(data){
                if (data.err_code == 0) {
                    window.location.reload();
                } else {
                    dialog.init(function(){}, '', '请刷新页面重试');
                }

            },'json');

        }, '', '确定要清空购物车吗？');


    });

    // 减数量
    $(".js-cart-minus").click(function(){
        var self = $(this);
        var cartIpt = self.closest(".m-cart-list-items").find(".js-checkbox-item");
        var num = self.parent().find(".js-cart-num").val();

        num = parseInt(num) - 1;
        changeItemNum(cartIpt, num);

    });

    // 加数量
    $(".js-cart-plus").click(function(){
        var self = $(this);
        var cartIpt = self.closest(".m-cart-list-items").find(".js-checkbox-item");
        var num = self.parent().find(".js-cart-num").val();

        num = parseInt(num) + 1;
        changeItemNum(cartIpt, num);

    });

    // 失去焦点
    $(".js-cart-num").blur(function(){

        var self = $(this);
        var cartIpt = self.closest(".m-cart-list-items").find(".js-checkbox-item");
        var num = self.val();
        changeItemNum(cartIpt, num);

    });

    // 购物记录修改 传相关 checkbox input
    function changeItemNum (obj, changeNum) {

        var cartIpt = obj;
        var itemLi = cartIpt.closest(".m-cart-list-items");
        var cart_id = cartIpt.val();
        var numIpt = itemLi.find(".js-cart-num");
        var resetNum = parseInt(cartIpt.closest(".m-cart-list-items").find(".js-rest-num").text());

        if (cartIpt.length == 0 || itemLi.length == 0) {
            return;
        }

        // 数量范围控制
        if (changeNum < 1) {
            changeNum = 1;
            numIpt.val(changeNum);
            cart_change();
            return;
        } else if (changeNum > resetNum) {
            changeNum = resetNum;
            numIpt.val(changeNum);
            cart_change();
            return;
        }

        $.post(cart_ajax_url, { type:"cart_count_change", cart_id:cart_id, cart_count:changeNum }, function(data){
            if (data.err_code == 0) {
                numIpt.val(changeNum);
                cart_change();
            } else {
                if (!confirm(data.err_msg+',请刷新页面重试。')) {
                    return;
                }
                window.location.reload();
            }

        },'json');

    }

    // 购物车底部随机获取数据
    $(".js-pswitch").click(function(){
        roundBottomList();
    });

    function roundBottomList () {

        var box = $(".js-goods-list");
        var nullTip = '<div class="w-loading js-cart-loading"><b class="w-loading-ico"></b><span class="w-loading-txt">正在努力加载……</span></div>';
        box.html(nullTip);
        $.post(cart_ajax_round, {}, function(data){

            if (data.err_code == 0) {
                
                if (data.err_msg != '' && data.err_msg.length > 0) {
                    var unitaryList = data.err_msg;
                    var htm = '';
                    for (i in unitaryList) {
                        htm += '<li class="w-goodsList-item">';
                        htm +=     '<div class="w-goods w-goods-brief">';
                        htm +=         '<div class="w-goods-pic">';
                        htm +=             '<a href="'+unitaryList[i].url+'" title="'+unitaryList[i].name+'" target="_blank">';
                        htm +=                 '<img width="200" height="200" alt="'+unitaryList[i].name+'" src="'+unitaryList[i].logopic+'">';
                        htm +=             '</a>';
                        htm +=         '</div>';
                        htm +=         '<p class="w-goods-title f-txtabb">';
                        htm +=             '<a title="'+unitaryList[i].name+'" href="'+unitaryList[i].url+'" target="_blank">'+unitaryList[i].name+'</a>';
                        htm +=         '</p>';
                        htm +=         '<p class="w-goods-price">总需：'+unitaryList[i].total_num+'人次</p>';
                        htm +=     '</div>';
                        htm += '</li>';
                    }

                    box.html(htm);
                }

            } else {
                if (!confirm('网络错误，请刷新页面重试。')) {
                    return;
                }
                window.location.reload();
            }

        },'json');

    }

    // 去结算
    $("#balanceBtn").click(function(){

        var store_checkbox = $(".js-checkbox-shop:checked");
        var item_checkbox = $(".js-checkbox-item:checked");
        if (store_checkbox.length == 0 || item_checkbox.length == 0) {
            dialog.init(function(){}, '', '请选择商品');
            return;
        }

        if ($(".js-agreementchk").attr("checked") != "checked") {
            dialog.init(function(){}, '', '请先阅读并同意《服务协议》！');
            return;
        }

        var store_id = store_checkbox.data("store_id");
        window.location.href = cart_balance_url+'&store_id='+store_id;

    });

    // 初始化，默认选中第一个店铺的所有商品
    if ($(".js-cart-shop:eq(0)").length > 0) {
        $(".js-cart-shop:eq(0)").find("input[type=checkbox]").attr("checked", true);
        cart_change();
    }

    // 初始化，底部随机推荐
    roundBottomList();

    // 支付页面
    $(".show-code-box").css({height:0,overflow:"hidden"});
    $(".w-button-xl").click(function(){
        $(".show-code-box").animate({height:300}, 300);
    });
});