var load_url;
if (page_content == 'luck') {
    var load_url = account_luck_url;
} else {
    var load_url = account_list_url;
}

$(function(){



    load_page('#account_con', load_url, {}, '', function(){});
    
    // 我的购买记录分页
	$(".js-my-list a").live("click", function(){
	    var page = $(this).attr("data-page-num");
        var status = $(".i-item-active").data('status');
	    load_page('#account_con', load_url, {page:page, status:status}, '', function(){});
	    return;
	});

    // 记录nav
    $(".js-list-nav .i-item").live("click", function(){
        var self = $(this);
        load_page('#account_con', load_url, {status:self.data('status')}, '', function(){});
        return;
    });

    // 我的幸运记录分页
    $(".js-my-luck a").live("click", function(){
        var page = $(this).attr("data-page-num");
        load_page('#account_con', load_url, {page:page}, '', function(){});
        return;
    });

    // 查看夺宝号码
    $(".js-viewCode").live("click", function(){
        var self = $(this);
        var count = self.data('count');
        var lucknum_str = '<p style="text-align:left">您本期共参与了</p>'+count+'人次 <br><hr>'+self.data("lucknum");
        dialog.init(function(){}, '', lucknum_str);

    });

});