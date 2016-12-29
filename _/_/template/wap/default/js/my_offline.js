$(function() {
	var uid = 0;
	var is_loading = false;
	var url = "my_offline.php?store_id=" + store_id;
	var user_url = "user.php?store_id=" + store_id;
	
	FastClick.attach(document.body);
	
	// 用户搜索
	$(".js-userphone").on("keyup focus", function (event) {
		var userphone = $(this).val();
		
		if ($(this).val().length > 0 && event.type == 'focusin' && $(this).attr("old-data") == $(this).val()) {
			if ($(".js-userphone_list").find("li").size() > 0) {
				$(".js-userphone_list").show();
			}
			return;
		}
		
		if ($(this).attr("old-data") == $(this).val()) {
			return;
		}
		
		uid = 0;
		if ($(this).val().length == 0) {
			$(".js-userphone_list").hide();
			return;
		}
		
		$(this).attr("old-data", $(this).val());
		$.post(user_url + "&action=search", {nickname : $(this).val()}, function (result) {
			if (result.err_code == "0") {
				var html = "";
				var user_list = result.err_msg;
				for(var i in user_list) {
					html += '<li class="js_user_detail" uid="' + user_list[i].uid + '" data-avatar="' + user_list[i].avatar + '">' + user_list[i].nickname + '</li>';
				}
				$(".js-userphone_list").html(html);
				$(".js-userphone_list").show();
			} else {
				$(".js-userphone_list").html("");
				$(".js-userphone_list").hide();
			}
		})
	});
	
	// 用户搜索确认
	$(".js-userphone_btn").click(function () {
		var nickname = $(".js-userphone").val();
		if (nickname.length == 0) {
			return;
		}
		
		$.post(user_url + "&action=check", {nickname : nickname, "type": "phone"}, function (result) {
			if (result.err_code == "0") {
				$(".js-nowuser img").attr("src", result.err_msg.avatar);
				$(".js-nowuser span").html("当前用户为：" + result.err_msg.nickname);
				uid = result.err_msg.uid;
				$(".js-nowuser").show();
			} else {
				motify.log(result.err_msg);
			}
		});
	});
	
	// 用户扫一扫
	$(".js-scan").click(function () {
		scan_qrcode_func();
	});
	
	$(".js-userphone_list").on("click", ".js_user_detail", function () {
		$(".js-userphone").val($(this).html());
		uid = $(this).attr("uid");
		$(".js-userphone_list").hide();
		
		$(".js-nowuser img").attr("src", $(this).data("avatar"));
		$(".js-nowuser span").html("当前用户为：" + $(this).html());
		$(".js-nowuser").show();
		$(".js-product_group .nav-son").hide();
	});
	
	// 本单金额
	$("input[name='total']").blur(function () {
		var total = $(this).val();
		
		if (total.length == 0) {
			return;
		}
		
		if(!/^\d+(\.\d+)?$/.test(total)){
			motify.log("请输入合法的数字");
			$(this).val($(this).attr("old-value"));
			$(this).focus();
			return;
		}else if(parseFloat(total) < 0.01) {
			motify.log('订单金额最小为 0.01');
			$(this).val($(this).attr("old-value"));
			$(this).focus();
			return;
		}
		
		$(this).attr("old-value", total);
		
		total = parseFloat(total);
		var service_fee = (total * credit_setting.platform_credit_rule * credit_setting.credit_deposit_ratio / 100).toFixed(2);
		$(".js-send_platform_point").html(total * credit_setting.platform_credit_rule);
		$(".js-service_fee").html(service_fee);
	});
	
	// 平台服务费使用现金
	$("input[name='cash']").live("blur", function () {
		var cash = $(this).val();
		var service_fee = parseFloat($(".js-service_fee").html());
		
		if (cash.length == 0) {
			return;
		}
		
		if(!/^\d+(\.\d+)?$/.test(cash)){
			motify.log("请输入合法的数字");
			$(this).focus();
			return;
		}
		cash = parseFloat(cash);
		if (cash <= 0) {
			return;
		}
		
		if (cash > service_fee) {
			motify.log("现金不能大于本单需要支付的服务费");
			return;
		}
		
		if (credit_setting.platform_credit_use_value > 0) {
			var platform_point = parseFloat($(".js-platform_point").data("platform_point")) / parseFloat(credit_setting.platform_credit_use_value);
			
			if (platform_point < (service_fee - cash).toFixed(2)) {
				motify.log("您的" + credit_setting.platform_credit_name + "不足，请使用更多的现金");
				return;
			}
			
			if ((parseFloat(cash) / service_fee) * 100 < parseFloat(credit_setting.offline_trade_money)) {
				motify.log("现金所占比例不能少于" + credit_setting.offline_trade_money + "%");
				return;
			}
			
			$("input[name='platform_point']").val(((service_fee - cash) * parseFloat(credit_setting.platform_credit_use_value)).toFixed(2));
		}
	});
	
	// 平台服务费使用现金
	$("input[name='platform_point']").live("blur", function () {
		var platform_point = $(this).val();
		var service_fee = parseFloat($(".js-service_fee").html());
		
		if (platform_point.length == 0) {
			return;
		}
		
		if(!/^\d+(\.\d+)?$/.test(platform_point)) {
			motify.log("请输入合法的数字");
			$(this).focus();
			return;
		}
		platform_point = parseFloat(platform_point);
		
		if (platform_point > parseFloat($(".js-platform_point").data("platform_point"))) {
			motify.log("最多只能使用" + $(".js-platform_point").data("platform_point"));
			return;
		}
		
		if (credit_setting.platform_credit_use_value > 0) {
			var platform_point_money = platform_point / parseFloat(credit_setting.platform_credit_use_value);
			var cash = (service_fee - platform_point_money).toFixed(2);
			
			if (cash > parseFloat($(".js-platform_point").data("margin_balance"))) {
				motify.log("您的充值现金不足");
				return;
			}
			
			if ((parseFloat(cash) / service_fee) * 100 < parseFloat(credit_setting.offline_trade_money)) {
				motify.log("现金所占比例不能少于" + credit_setting.offline_trade_money + "%");
				return;
			}
			
			$("input[name='cash']").val(cash);
		}
	});
	
	// 商品类别选择
	$(".js-product_category").live("change", function () {
		var cat_id = $(this).val();
		if (cat_id == "0") {
			$(".js-product_category_container").html("");
		} else {
			var product_category_son = [];
			var len = product_category_list.length;
			for(var i = 0; i < len; i++) {
				if (product_category_list[i].cat_id == cat_id) {
					product_category_son = product_category_list[i].son_data;
					break;
				}
			}
			
			var product_category_son_html = '<option value="0">请选择</option>';
			var is_has = false;
			for (var i in product_category_son) {
				is_has = true;
				product_category_son_html += '<option value="' + product_category_son[i].cat_id + '">' + product_category_son[i].cat_name + '</option>'
			}
			
			product_category_son_html = '<select class="js-product_category_son" style="width: auto;">' + product_category_son_html + '</select>';
			if (is_has) {
				$(".js-product_category_container").html(product_category_son_html);
			} else {
				$(".js-product_category_container").html("");
			}
		}
	});
	
	// 提交订单
	$(".js-btn-save").click(function () {
		$(".js-btn-save").addClass("order_loading");
		$(".js-btn-save").val($(".js-btn-save").attr("data-loading-text"));
		
		var data = {};
		var total = $("input[name='total']").val();
		var cash = $("input[name='cash']").val();
		var platform_point = $("input[name='platform_point']").val();
		var cat_id = 0;
		var product_name = $("input[name='product_name']").val();
		var number = $("input[name='number']").val();
		
		if (uid == 0) {
			motify.log("请选择用户");
			resetSaveBtn();
			return;
		}
		
		if(!/^\d+(\.\d+)?$/.test(total)){
			motify.log("请输入合法的数字");
			$("input[name='total']").focus();
			resetSaveBtn();
			return;
		}
		if (parseFloat(total) < 0.01) {
			motify.log("订单金额最小为0.01");
			$("input[name='total']").focus();
			resetSaveBtn();
			return;
		}
		
		if ($(".js-product_category").size() > 0 && $(".js-product_category").val() == "0") {
			motify.log("请选择商品分类");
			resetSaveBtn();
			return;
		}
		
		cat_id = $(".js-product_category").val();
		if ($(".js-product_category_son").size() > 0 && $(".js-product_category_son").val() == "0") {
			motify.log("请选择商品分类");
			resetSaveBtn();
			return;
		} else if ($(".js-product_category_son").size() > 0) {
			cat_id = $(".js-product_category_son").val();
		}
		
		if (product_name.length == 0) {
			motify.log("请填写产品名称");
			resetSaveBtn();
			return;
		}
		
		if(!/^\d+?$/.test(number)){
			motify.log("请输入合法的数字");
			$("input[name='number']").focus();
			resetSaveBtn();
			return;
		}
		
		if (number <= 0) {
			motify.log("请输入大于0的数字");
			$("input[name='number']").focus();
			resetSaveBtn();
			return;
		}
		
		data.uid = uid;
		data.total = total;
		data.cash = cash;
		data.platform_point = platform_point;
		data.cat_id = cat_id;
		data.product_name = product_name;
		data.number = number;
		data.bak = $(".js-bak").val();
		
		$.post(url + "&action=add", data, function (result) {
			if (result.err_code == "0") {
				motify.log("订单创建成功");
				location.href = "my_offline_list.php?store_id=" + store_id;
			} else {
				motify.log(result.err_msg);
				resetSaveBtn();
			}
		});
	});
	
	function resetSaveBtn() {
		$(".js-btn-save").removeClass("order_loading");
		$(".js-btn-save").val("完成做单");
	}
});
