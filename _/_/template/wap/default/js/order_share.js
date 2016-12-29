$(function(){
	$(".js-show-message").click(function () {
		var comment_obj = $(this).data("comment");
		var comment_html = '';
		
		for(var i in comment_obj) {
			comment_html += "<li><span>" + comment_obj[i].name + ":</span>" + comment_obj[i].value + "</li>";
		}
		
		var product_content = $(this).closest(".js-product-detail").html();
		product_content_obj = $("<div>" + product_content + "</div>");
		product_content_obj.find(".js-show-message").remove();
		product_content = product_content_obj.html();
		
		var comment_html = '<div class="modal order-modal active">\
								<div class="block block-order block-border-top-none">\
									<div class="block block-list block-border-top-none block-border-bottom-none">\
										<div class="block-item name-card name-card-3col clearfix">' + product_content + '</div>\
									</div>\
								</div>\
								<div class="block express" id="js-logistics-container">\
									<div class="block-item logistics">\
										<h4 class="block-item-title">留言信息</h4>\
									</div>\
									<div class="js-logistics-content logistics-content js-express">\
										<div>\
											<div class="block block-form block-border-top-none block-border-bottom-none">\
												<div class="js-order-address express-panel" style="padding-left:0;">\
													<ul>' + comment_html + '</ul>\
												</div>\
											</div>\
										</div>\
									</div>\
								</div>\
								<div class="action-container"><button type="button" class="js-cancel btn btn-block">查看订单</button></div>\
							</div>';
		
		
		var comment_obj = $(comment_html);
		
		$('body').append(comment_obj);
		
		comment_obj.find('.js-cancel').click(function(){
			comment_obj.remove();
		});
	});
	
	$(".js-type-selector button").click(function () {
		$(this).closest("div").find("button").removeClass("active");
		$(this).addClass("active");
		$(this).blur();
		
		$(this).closest("div").find("button").each(function () {
			if ($(this).hasClass("active")) {
				$(".js-" + $(this).data("type")).removeClass("hide");
			} else {
				$(".js-" + $(this).data("type")).addClass("hide");
			}
		});
	});
	
	$(".btn-peerpay").click(function () {
		var peerpay_content = $("#peerpay_content").val();
		if (peerpay_content.length == 0) {
			motify.log("请填写求助的内容");
			return;
		}
		
		var type = $(".js-type-selector").find(".active").data("type");
		$.post('', {peerpay_content : peerpay_content, 'type' : type, 'is_ajax' : 1}, function (data) {
			if (data.err_code == 0) {
				location.href = data.err_msg;
			} else {
				motify.log(data.err_msg);
			}
		})
	});
	
	$(".js-cancel").click(function () {
		location.href = "order.php?orderid=" + $(this).data("orderid");
	});
});