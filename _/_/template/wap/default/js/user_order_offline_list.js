$(function() {
	var page = 1;
	var status = "0";
	var next_page = true;
	var is_loading = false;
	
	FastClick.attach(document.body);
	
	var url = "user_order_offline_list.php?store_id=" + store_id;
	getOrder();
	
	$(".js-store_order").click(function () {
		location.href = "my_offline_list.php?store_id=" + store_id;
	});
	
	// 订单类型
	$(".js-status_list").click(function () {
		if ($(this).find(".nav-son").is(":hidden")) {
			$(this).find("span").removeClass("icon-caret-down").addClass("icon-caret-up");
			$(this).find(".nav-son").show();
		} else {
			$(".js-status_list span").removeClass("icon-caret-up").addClass("icon-caret-down");
			$(".js-status_list .nav-son").hide();
		}
	});
	
	// 审核类型切换
	$(".js-status").click(function () {
		if ($(this).data("status") == $(this).closest(".nav-son-con").data("status")) {
			return;
		}
		status = $(this).data("status");
		page = 1;
		
		if (status == "0") {
			$(".js-status_list .txt").html("订单状态");
		} else {
			$(".js-status_list .txt").html($(this).html());
		}
		
		$(this).closest(".nav-son-con").data("status", status);
		$(this).addClass("orange").siblings().removeClass("orange");
		// 加载项
		$(".js-order_list").html($(".js-loading").html());
		getOrder();
	});
	
	$(document).live("click", function(e) {
		e = window.event || e;
		obj = $(e.srcElement || e.target);
		if ($(obj).is(".js-status_list") || $(obj).is(".txt")) {
			
		} else {
			$(".js-status_list .nav-son").hide();
		}
	});
	
	$(window).scroll(function() {
		if (!is_loading && next_page && $(window).scrollTop() / ($('body').height() - $(window).height()) >= 0.95){
			getOrder();
		}
	});
	
	function getOrder() {
		is_loading = true;
		var random = Math.random();
		
		$.post(url + "&random=" + random, {"status": status, "page": page, "ajax": 1}, function (result) {
			if (result.err_code == "0") {
				var order_list = result.err_msg.order_list;
				next_page = result.err_msg.next_page;
				
				var html = "";
				for (var i in order_list) {
					var category_str = "";
					try {
						category_str = category_list[order_list[i].cat_id].cat_name;
						var cat_id = category_list[order_list[i].cat_id].cat_fid;
						
						if (cat_id != 0) {
							category_str = category_list[cat_id].cat_name + '-' + category_str;
						}
					} catch (e) {
						
					}
					
					html += '<li>\
								<div class="shoplisttit manage-shoplisttit">\
									<span class="fl shoplisttit-left">订单号:' + order_list[i].order_no + '</span>\
									<span class="fr shoplisttit-right orange js-order_status">' + order_list[i].status_txt + '</span>\
									<div class="clear"></div>\
								</div>';
					
					
					html += '	<div>\
									<div class="fl shoplist-img"><img src="' + order_list[i].product_image + '" alt=""></div>\
									<div class="fl shoplist-con manage-shoplist-con">\
									<p class="shoplist-con-tit manage-shopname">' + order_list[i].product_name + '</p>';
					
					html += '		<p class="manage-shoplist-color">' + category_str + '</p>';
					
					html += '			<div class="shoplist-con-bottom">\
											<!--<span class="fl shoplist-con-num">总价：<span class="orange">￥' + order_list[i].total + '</span></span>-->\
											<div class="clear"></div>\
											</div>\
											</div>\
											<div class="clear"></div>\
											</div>';
					
					html += '	<div class="btn-price">';
					html += '		<div class="fl order-all-price">订单总价<span class="orange">￥' + order_list[i].total + '</span> 送积分:' + order_list[i].return_point + '</div>';
					if (order_list[i].status == "7") {
						html += '		<span class="fr shoplist-del manage-shoplist-order logistics-btn js-order_complate" data-url="order.php?action=complate&order_no=' + order_list[i].order_no + '" style="background: #ff7216; color: #fff; border: 0px;" data-order_no="' + order_list[i].order_no + '">交易完成</span>';
					} else if (order_list[i].status == "4") {
						
					} else {
						html += '		<span class="fr shoplist-del manage-shoplist-order logistics-btn js-order_send" data-url="order.php?action=order_send&order_no=' + order_list[i].order_no + '" style="background: #ff7216; color: #fff; border: 0px;" data-order_no="' + order_list[i].order_no + '">确认自提</span>';
					}
					
					html += '	</div>';
					html += '</li>';
				}
				
				if (order_list.length == 0) {
					html += '<li><div style="text-align: center; padding-bottom: 10px;">无更多相关订单</div></li>';
				} else if (next_page == false) {
					html += '<li><div style="text-align: center; padding-bottom: 10px;">无更多相关订单</div></li>';
				}
				
				if ($(".js-order_list").find("ul").size() > 0) {
					$(".js-order_list").find("ul").append(html);
				} else {
					$(".js-order_list").html('<ul class="shoplist-ul manage-shopul">' + html + '</ul>');
				}
				page++;
				is_loading = false;
			} else {
				motify.log("数据异常");
				is_loading = false;
			}
		});
	};
	
	$(".js-order_send").live("click", function () {
		var obj = $(this);
		var order_no = obj.data("order_no");
		var order_send_url = $(this).data('url') + "&store_id=" + store_id;
		$.get(order_send_url, "", function(data){
			if (data.err_code != 0) {
				motify.log(data.err_msg, 0);
			} else {
				motify.log(data.err_msg, 0);
				var complete_url = "order.php?action=complate&order_no=" + order_no;
				obj.data("url", complete_url);
				obj.html("交易完成");
				obj.removeClass("js-order_send").addClass("js-order_complate");
			}
		});
	});
	
	$('.js-order_complate').live('click', function(e) {
		var obj = $(this);
		var complate_url = $(this).data('url') + "&store_id=" + store_id;
		$.get(complate_url, "", function(data){
			if (data.err_code != 0) {
				motify.log(data.err_msg, 0);
			} else {
				motify.log(data.err_msg, 0);
				obj.closest("li").find(".js-order_status").html("已完成，积分已发放");
				obj.remove();
			}
		});
	});
});

