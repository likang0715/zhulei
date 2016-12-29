$(function(){
//切换选项卡
	$(".xuanxiangka").click(function(){
		$(".xuanxiangka").removeClass("on");
		$(this).addClass("on");
		var xxk_index = $(".xuanxiangka").index($(this));

		$(".js-content-detail").hide();
		$(".js-content-detail").eq(xxk_index).show();

		if (xxk_index == 2) {
			if ($("#list_comments .list_comments").eq(0).data("type") == "default") {
				getComment(0, 1);
			}
		} else if (xxk_index == 1) {
			if ($(".js-buy_history").data("type") == "default") {
				getBuyHistory(1);
			}
		}
	});
})


function formatDate(now)   {
	var year=now.getFullYear();
	var month=now.getMonth()+1;
	var date=now.getDate();
	var hour=now.getHours();
	var minute=now.getMinutes();
	var second=now.getSeconds();
	return year + "-" + month + "-" + date;
}

function bindViweImage() {
	$(".js-goods-view-images").each(function () {
		var rel = $(this).data("id");
		$("a[rel=comment_" + rel + "]").fancybox({
			'titlePosition' : 'over',
			'cyclic'		: false
		});
	});
}