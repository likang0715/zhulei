$(function(){

	var tabClass = "w-tabs-tab-item-selected pro-tabs-tab-item-selected";

    // 商品详情
    $("#introTab").click(function(){
        $(".w-tabs-tab-item").removeClass(tabClass);
        $(this).addClass(tabClass);
        $(".w-tabs-panel-item").hide();
        $("#introPanel").show();
    });

    // 计算结果
    $("#resultTab").click(function(){
        $(".w-tabs-tab-item").removeClass(tabClass);
        $(this).addClass(tabClass);
        $(".w-tabs-panel-item").hide();
        $("#resultPanel").show();
    });

    // 参与记录
    $("#recordTab").click(function(){

        $(".w-tabs-tab-item").removeClass(tabClass);
        $(this).addClass(tabClass);
        $(".w-tabs-panel-item").hide();
        $("#recordPanel").show();

		if ($(".content", $("#recordPanel")).length < 1) {
			load_page('#recordPanel', buy_list_url, {'id': unitary_id}, '', function(){});
		}

    });

    // 购买记录分页
	$(".js-buyList-page a").live("click", function(){
	    var page = $(this).attr("data-page-num");
	    load_page('#recordPanel', buy_list_url, {'id': unitary_id, page:page}, '', function(){});
	    return false;
	});

    // 调用夺宝与购物
    $("#typeOne").setAddCart({
        "buyClass":"#quickBuy",
        "addClass":"#addToCart",
        "redirect": cart_url,
        "addCartUrl": add_cart_url,
    });

    // 查看TA的夺宝号码
    $("#btnWinnerCodes").click(function(){
        var self = $(this);
        var lucknum_str = self.data("lucknum");

        dialog.init(function(){},'',lucknum_str);

    });


    var timer = setInterval(function() {
        var $el = $("#countdownNum");
        var nowtime = $el.attr("data-countdown");
        if(nowtime == 0) location.href = location.href;
        $el.attr("data-countdown", parseInt($el.attr("data-countdown")) - 1 )
        $el.text(runtime.formatSeconds(nowtime));
    },1000)

});