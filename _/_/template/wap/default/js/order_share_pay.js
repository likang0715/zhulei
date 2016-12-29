$(function(){
	$(".btn-clear").click(function () {
		$(".js-money").val("");
		$(".js-money").focus();
	});
	
	
	$(".btn-peerpay").click(function () {
		var name = $(".js-name").val();
		var content = $(".js-content").val();
		var money = $(".js-money").val();
		var orderid = $(this).data("order-id");
		
		if (name.length == 0) {
			motify.log("请填写我的姓名");
			return;
		}
		
		if (content.length == 0) {
			motify.log("请填写留言");
			return;
		}
		
		if (isNaN(money)) {
			motify.log("请填写有效金额");
			return;
		} else if ($.trim(money) == '') {
			motify.log("请填写有效金额");
			return;
		}
		
		if (parseFloat(money) < 0.01) {
			motify.log("最少请支付0.01元");
			return;
		}
		
		if (pay_type == 1 && parseFloat(money) != parseFloat($(".js-money").data("max"))) {
			motify.log("请支付" + parseFloat($(".js-money").data("max")).toFixed(2) + "元");
			return;
		}
		
		$.post("order_share_weixin.php", {order_id : orderid, name : name, content : content, money : money}, function (result) {
			if (result.err_code == 0) {
				if(window.WeixinJSBridge){
					window.WeixinJSBridge.invoke("getBrandWCPayRequest", result.err_msg, function(res){
						WeixinJSBridge.log(res.err_msg);
						if(res.err_msg=="get_brand_wcpay_request:ok"){
							window.location.href = './order_share_paid.php?peerid=' + result.err_dom;
						}else{
							if(res.err_msg == "get_brand_wcpay_request:cancel"){
								var err_msg = "您取消了微信支付";
							}else if(res.err_msg == "get_brand_wcpay_request:fail"){
								var err_msg = "微信支付失败<br/>错误信息：" + res.err_desc;
							}else{
								var err_msg = res.err_msg + "<br/>" + res.err_desc;
							}
							motify.log(err_msg);
						}
					});
				}else{
					window.location.href = result.err_msg;
				}
			} else {
				motify.log(result.err_msg);
			}
		});
	});
	
	$(".js-money").blur(function () {
		var money = $(this).val();
		if ($.trim(money) == '') {
			return;
		} else if (isNaN(money)) {
			motify.log("请填写有效金额");
			return;
		}
		
		if (parseFloat(money) > $(this).data("max")) {
			$(this).val($(this).data("max"));
		}
		
		$(this).val(parseFloat($(this).val()).toFixed(2));
	});
	
	$(".js-open-share").click(function () {
		$("#js-share-guide").removeClass("hide");
	});
	
	$("#js-share-guide").click(function () {
		$("#js-share-guide").addClass("hide");
	});
});