//评论分页开始
var pinlunPage = 1;
var pinlunIsAjax = false;
var pinlunSort = 'default';
var pinlunShowRows = false;
var hrefs2 = '#pl_goods';
var load_arr = [];
var load_buy_history = false;

$(function(){

	$('.js-buy-it').click(function(){
		if (!is_logistics && !is_selffetch) {
			motify.log('商家未设置配送方式，暂时不能购买');
			return;
		}

		var nowDom = $(this);
		if(nowDom.attr('disabled')){
			motify.log('提交中,请稍等..');
			return false;
		}
		nowDom.attr('disabled',true).html('<i></i>提交中');
		skuBuy(product_id,1,function(){
			nowDom.attr('disabled',false).html('<i></i>自己买');
		});
	});
	$('.js-add-cart').click(function(){
		if (!is_logistics && !is_selffetch) {
			motify.log('商家未设置配送方式，暂时不能购买');
			return;
		}

		var nowDom = $(this);
		if(nowDom.attr('disabled')){
			motify.log('提交中,请稍等..');
			return false;
		}
		nowDom.attr('disabled',true).html('<i></i>正在提交中');
		skuBuy(product_id,2,function(){
			nowDom.attr('disabled',false).html('<i></i>加入购物车');
		});
	});
	
	// 找人送
	$(".js-peerpay").click(function () {
		if (!is_logistics) {
			motify.log('商家未设置配送方式，暂时不能购买');
			return;
		}

		var nowDom = $(this);
		if (nowDom.attr('disabled')) {
			motify.log('提交中,请稍等..');
			return false;
		}
		nowDom.attr('disabled',true).html('<i></i>提交中');
		skuBuy(product_id, 4, function() {
			nowDom.attr('disabled',false).html('<i></i>找人送');
		});
	});
	
	// 送他人
	$(".js-send_other").click(function () {
		if (!is_logistics) {
			motify.log('商家未设置配送方式，暂时不能购买');
			return;
		}

		var nowDom = $(this);
		if(nowDom.attr('disabled')){
			motify.log('提交中,请稍等..');
			return false;
		}
		nowDom.attr('disabled',true).html('<i></i>提交中');
		skuBuy(product_id, 3, function(){
			nowDom.attr('disabled',false).html('<i></i>送他人');
		});
	});
	
	if(showBuy===true && motify.checkMobile()===true){
		$('.js-buy-it').trigger('click');
	}

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

	// 滚动显示评论
	$(window).scroll(function(){
		if($(".js-content-detail").eq(2).is(":visible") == true) {
			var tab_index = $(".js-comment-tab li").index($(".js-comment-tab li.on"));
			var type = $("#list_comments .list_comments").eq(tab_index).data("type");
			
			if (load_arr[tab_index] == true) {
				return false;
			}
			
			if (type == "default") {
				return false;
			}

			var next = $("#list_comments .list_comments").eq(tab_index).attr("next");
			if (next == "false") {
				return false;
			}

			if ($(window).scrollTop()/($('body').height() -$(window).height()) >= 0.95) {
				load_arr[tab_index] = true;
				var page = $("#list_comments .list_comments").eq(tab_index).data("page");
				getComment(tab_index, page);
			}
		} else if($(".js-content-detail").eq(1).is(":visible") == true) {
			if (load_buy_history == true) {
				return false;
			}
			
			var type = $(".js-buy_history").data("type");
			if (type == "default") {
				return false;
			}

			var next = $(".js-buy_history").attr("next");
			if (next == "false") {
				return false;
			}

			if ($(window).scrollTop()/($('body').height() -$(window).height()) >= 0.95) {
				load_buy_history = true;
				var page = $(".js-buy_history").data("page");
				getBuyHistory(page);
			}
		}
	});

	$(".js-comment-tab li").click(function () {
		$(this).closest("div").find("li").removeClass("on");
		$(this).addClass("on");

		var tab_index = $(this).closest("ul").find("li").index($(this));
		var tab = $(this).data("tab");
		if ($("#list_comments .list_comments").eq(tab_index).data("type") == "default") {
			// 未加载评论
			getComment(tab, 1);
		}

		$("#list_comments .list_comments").hide();
		$("#list_comments .list_comments").eq(tab_index).show();
	});
})

$(".promote-item").live("click",function(){
	$(".promote-item").removeClass("curr_li");
   $(this).addClass("curr_li");
	$(".promote-item .p_card,.promote-item .p_card2").hide();
	$(this).find(".p_card,.p_card2").show();

})

function getComment(index, page) {
	var product_id = $(".section_body").attr("data-product-id");
	if(!product_id) {
		return false;
	}

	var tab = "HAO";
	switch(index) {
		case 0 :
			tab = "HAO";
			break;
		case 1 :
			tab = "ZHONG";
			break;
		case 2 :
			tab = "CHA";
			break;
		case 3 :
			tab = "IMAGE";
			break;
		default :
			index = 0;
			tab = "HAO";
	}
	
	$(".js-load-comment").show();
	var url = "comment.php?type=PRODUCT&tab=" + tab + "&id=" + product_id + "&page=" + page + "&action=get_pinlun_list";
	$.get(url, function (result) {
		var plHtml = "";
		var comments_index='';

		for(var i in result.err_msg.list){
			var ii = 0;
			var first_attachment_image = "";
			var pinlun = result.err_msg.list[i];
			var users = result.err_msg.userlist[pinlun.uid];
			var comment_attachment_list = result.err_msg.list[i].attachment_list;


			if(pinlun.content){
				var miaoshu = pinlun.content;
			} else {
				var miaoshu = "暂无描述";
			}
			if(users.avatar){
				var touxiang = users.avatar;
			} else {
				var touxiang = "";
			}
			if(users.nickname){
				var nickname = users.nickname;
			} else {
				var nickname = "匿名";
			}
			var dateline = new Date((pinlun.dateline)*1000);
			var score = "好评";
			if (parseInt(pinlun.score) >= 4) {
				score = "好评";
			} else if (parseInt(pinlun.score) >= 3) {
				score = "中评";
			} else {
				score = "差评";
			}

			plHtml += '<li>';
			plHtml += '<div class="avatar"> <a href="##"> <img src="' + touxiang + '"> </a> <em>' + score + '</em> </div>';
			plHtml += '<div class="commentDetail">';
			plHtml += '	<div class="topInfo">';
			plHtml += '		<time>' + formatDate(dateline) + '</time>';
			plHtml += '		<h3>' + nickname + '</h3>';
			plHtml += '	</div>';
			plHtml += '	<div class="textAndImg">';
			plHtml += '		<p>' + miaoshu + '</p>';
			plHtml += '		<ol class="js-goods-view-images" data-id="' + result.err_msg.list[i].id + '">';
			for (var j in comment_attachment_list) {
				plHtml += '		<li><a href="' + comment_attachment_list[j].file + '" rel="comment_' + result.err_msg.list[i].id + '"> <img src="' + comment_attachment_list[j].file + '"/> </a> </li>';
			}
			plHtml += '		</ol>';
			
			plHtml += '	</div>';
			plHtml += '</div>';
			plHtml += '</li>';
		}
		
		page = parseInt(page) + 1;

		$("#list_comments .list_comments").hide();
		$("#list_comments .list_comments").eq(index).show().append(plHtml);
		$("#list_comments .list_comments").eq(index).data("type", "value");
		$("#list_comments .list_comments").eq(index).data("page", page);

		if (result.err_msg.noNextPage) {
			$("#list_comments .list_comments").eq(index).show().append('<li><div class="noData" style="display: block;">已无更多评价！</div></li>');
			$("#list_comments .list_comments").eq(index).attr("next", "false");
		}
		$(".js-load-comment").hide();
		load_arr[index] = false;
		// 绑定显示图片
		bindViweImage();
	});
}

function getBuyHistory(page) {
	$(".js-buy_history").find(".noData").show();
	var product_id = $(".section_body").attr("data-product-id");
	if(!product_id) {
		return false;
	}
	
	$(".js-buy_history").find(".noData").html("努力加载中！");
	$(".js-buy_history").find(".noData").show();
	
	var url = "goods_ajax.php?product_id=" + product_id + "&page=" + page + "&action=buy_list";
	$.get(url, function (result) {
		var html = "";
		var comments_index='';

		for(var i in result.err_msg.list){
			var order_product = result.err_msg.list[i];
			var users = result.err_msg.userlist[order_product.uid];
			var nickname = "";
			if(users.nickname){
				nickname = users.nickname;
			} else {
				nickname = "匿名";
			}
			
			html += '<tr>';
			html += '	<td>' + order_product.add_time + '</td>';
			html += '	<td>' + order_product.pro_num + '</td>';
			html += '	<td><div class="avatar"> <img src="' + users.avatar + '" /> <em>' + nickname + '</em> </div></td>';
			html += '</tr>';
		}
		
		page = parseInt(page) + 1;
		$(".js-buy_history").find(".noData").hide();
		$(".js-buy_history_list").append(html);
		$(".js-buy_history").data("type", "value");
		$(".js-buy_history").data("page", page);

		if (result.err_msg.noNextPage) {
			$(".js-buy_history").find(".noData").html("已无更多购买记录！");
			$(".js-buy_history").find(".noData").show();
			$(".js-buy_history").attr("next", "false");
		}
		
		load_buy_history = false;
	});
}

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