$(function() {
	FastClick.attach(document.body);
	var is_search = false;
	$(".js-searchbtn").click(function () {
		if (is_search) {
			motify.log("搜索中，请稍等");
			return;
		}
		is_search = true;
		$(".js-shop_list").html('<li><div class="fl shopname">搜索中，请稍等</div><div class="fr"></div><div class="clear"></div></li>');
		var phone = $(".js-phone").val();
		if (phone.length == 0) {
			motify.log("请输入商家手机号");
			$(".js-phone").focus();
		}
		
		$.get("", {"action": "search", "phone": phone}, function (result) {
			is_search = false;
			if (result.err_code == "0") {
				if (result.err_msg.store_list.length > 0) {
					var html = "";
					var store_list = result.err_msg.store_list;
					for (var i in store_list) {
						html += '<li class="js-shop" data-store_id="' + store_list[i].store_id + '"><div class="fl shopname">' + store_list[i].name + '</div><div class="fr"></div><div class="clear"></div></li>';
					}
					$(".js-shop_list").html(html);
				} else {
					var html = '<li><div class="fl shopname">该帐号下没有店铺</div><div class="fr"></div><div class="clear"></div></li>';
					$(".js-shop_list").html(html);
				}
			} else {
				motify.log(result.err_msg);
			}
		});
	});
	
	$(".js-shop").live("click", function () {
		var store_id = $(this).data("store_id");
		
		location.href = "user_offline.php?store_id=" + store_id;
	});
});
