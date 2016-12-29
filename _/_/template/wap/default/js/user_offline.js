$(function() {
	FastClick.attach(document.body);
	
	$(".js-total").blur(function () {
		var money = $(this).val();
		if (money.length == 0) {
			$(".js-platform_point").val(0);
			$(".js-platform_point").attr("old-value", 0);
			$(".js-platform_point_max").html(0);
			return;
		}
		
		if (!/^\d+(\.\d+)?$/.test(money)) {
			motify.log("请输入合法的数字");
			$(this).val($(this).attr("old-value"));
			$(this).focus();
			return;
		}else if(parseFloat(money) <= 0.00) {
			motify.log('最小为 0.01');
			$(this).val($(this).attr("old-value"));
			$(this).focus();
			return;
		}
		
		$(this).attr("old-value", $(this).val());
		
		// 积分没有价值
		if (credit_setting.platform_credit_use_value == '0') {
			$(".js-platform_point").val(0);
			$(".js-platform_point").attr("old-value", 0);
			//$(".js-platform_point").prop("disabled", true);
			$(".js-platform_point_max").html(0);
			return;
		}
		
		var user_point_balance = parseFloat($(".js-user_point_balance").html());
		if (user_point_balance <= 0) {
			$(".js-platform_point").val(0);
			$(".js-platform_point").attr("old-value", 0);
			//$(".js-platform_point").prop("disabled", true);
			$(".js-platform_point_max").html(0);
			return;
		}
		
		if (money < 0) {
			$(".js-platform_point").val(0);
			$(".js-platform_point").attr("old-value", 0);
			//$(".js-platform_point").prop("disabled", true);
			$(".js-platform_point_max").html(0);
			return;
		}
		
		// 订单只能全部使用积分或者不用
		if (parseFloat(credit_setting.platform_credit_use_value) <= 0) {
			$(".js-platform_point").val(0);
			$(".js-platform_point").attr("old-value", 0);
			//$(".js-platform_point").prop("disabled", true);
			$(".js-platform_point_max").html(0);
			return;
		}
		
		var platform_point = money * parseFloat(credit_setting.platform_credit_use_value);
		if (platform_point > parseFloat($(".js-user_point_balance").html())) {
			$(".js-platform_point").val(0);
			$(".js-platform_point").attr("old-value", 0);
			//$(".js-platform_point").prop("disabled", true);
			$(".js-platform_point_max").html(0);
			return;
		}
		
		$(".js-platform_point").val(platform_point.toFixed(2));
		$(".js-platform_point").attr("old-value", 0);
		//$(".js-platform_point").prop("disabled", true);
		$(".js-platform_point_max").html(platform_point.toFixed(2));
		return;
		
		
		// 现金比例
		var offline_trade_money = parseFloat(credit_setting.offline_trade_money);
		if (offline_trade_money > 0) {
			money = money - money * offline_trade_money / 100;
		}
		
		// 最多可使用平台积分抵扣的钱
		if (money <= 0) {
			$(".js-platform_point").val(0);
			$(".js-platform_point").attr("old-value", 0);
			$(".js-platform_point").prop("disabled", true);
			$(".js-platform_point_max").html(0);
			return;
		}
		
		// 所需要的积分,相当于舍弃第三位小数
		var platform_point = money * parseFloat(credit_setting.platform_credit_use_value);
		
		if (user_point_balance < platform_point) {
			platform_point = user_point_balance;
		}
		
		platform_point = platform_point - 0.0049;
		if (platform_point < 0) {
			platform_point = 0.00;
		}
		
		$(".js-platform_point").val(platform_point.toFixed(2));
		$(".js-platform_point").attr("old-value", platform_point.toFixed(2));
		$(".js-platform_point").prop("disabled", false);
		$(".js-platform_point_max").html(platform_point.toFixed(2));
	});
	
	// 积分抵扣
	$(".js-platform_point").blur(function () {
		var platform_point = $(this).val();
		
		if (platform_point.length == 0) {
			return;
		}
		
		if (!/^\d+(\.\d+)?$/.test(platform_point)) {
			motify.log("请输入合法的数字");
			$(this).val($(this).attr("old-value"));
			$(this).focus();
			return;
		}
		
		if (parseFloat(platform_point) > parseFloat($(".js-platform_point_max").html())) {
			motify.log("最多只能使用" + $(".js-platform_point_max").html() + "个");
			$(this).val($(this).attr("old-value"));
			$(this).focus();
			return;
		}
		
		$(this).attr("old-value", $(this).val());
	});
	
	
	$(".js-next_btn").click(function () {
		var total = $(".js-total").val();
		var comment = $(".js-comment").val();
		var platform_point = $(".js-platform_point").val();
		
		if (!/^\d+(\.\d+)?$/.test(total)) {
			motify.log("请输入合法的数字");
			$(this).val($(this).attr("old-value"));
			$(this).focus();
			return;
		}else if(parseFloat(total) <= 0.00) {
			motify.log('最小为 0.01');
			$(this).val($(this).attr("old-value"));
			$(this).focus();
			return;
		}
		
		$.post("user_offline.php?action=add&store_id=" + store_id, {"total": total, "platform_point": platform_point, "comment": comment}, function (result) {
			if (result.err_code == "0") {
				motify.log("订单创建成功");
				location.href = result.err_msg;
			} else {
				motify.log(result.err_msg);
			}
		});
	});
});
