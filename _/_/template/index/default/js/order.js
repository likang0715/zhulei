// 邮费
var address_msg = '';
var is_click = false;
var is_first = true;
var postage_money = 0;
var friend_postage_money = 0;
var point_money = 0.00;
var supplier_postage_money = 0.00;
var supplier_reward_money = 0.00;
var supplier_coupon_money = 0.00;

function getPostage(province_id) {
	var address_id = '';
	var pid = 0;
	if (typeof province_id == "undefined") {
		var address_id = $(".order_add_list_ul").find(".order_curn").data("address_id");
		if (typeof address_id == 'undefined') {
			$("#postage").val(0);
			return;
		}
	} else {
		if (province_id.length == 0) {
			return;
		}
		pid = province_id;
	}

	var order_id = $("#order_no").val();
	var url = '/wap/address.php?action=postage';
	$.post(url, {'address_id' : address_id, 'province_id' : pid, 'orderNo' : order_id}, function (data) {
		if (data.err_code != "0") {
			if (data.err_code == '1009') {
				address_msg = '很抱歉，该地区暂不支持配送。';
				if (!is_first) {
					tusi('很抱歉，该地区暂不支持配送。');
				}
			} else {
				address_msg = data.err_msg;
				if (!is_first) {
					tusi(data.err_msg);
				}
			}

			is_first = false;
			if (pid != 0) {
				$("#postage_friend").val(0);
			} else {
				$("#postage").val(0);
			}
			
			return;
		} else {
			if (typeof data.err_msg != 'undefined') {
				$("#J_postage").html(data.err_msg);
				
				if ($("#J_reward_postage_money").length > 0) {
					$("#J_reward_postage_money").html(data.err_msg);
				}
				
				if (pid != "0") {
					friend_postage_money = data.err_msg;
				} else {
					postage_money = data.err_msg;
				}
				
				$("input[name='postage_list']").val(data.err_dom.postaage_list);
				supplier_postage_money = data.err_dom.supllier_postage;
				resetMoney();
			}
			if (pid != 0) {
				$("#postage_friend").val(1);
			} else {
				$("#postage").val(1);
			}
			is_first = false;
		}
	}, 'json');
	
}

$(function () {
	try {
		supplier_reward_money = parseFloat($(".js-point-container").data("supplier_reward_money"));
		supplier_coupon_money = parseFloat($(".js-point-container").data("supplier_coupon_money"));
	} catch (e) {
		
	}
	
	
	if ($(".js-friend").size() > 0) {
		getProvinces('provinceId_friend','','省份');
		$('#provinceId_friend').change(function(){
			if($(this).val() != ''){
				getPostage($(this).val());
				getCitys('cityId_friend','provinceId_friend','','城市');
			}else{
				$("#J_postage").html(0);
				$('#cityId_friend').html('<option value="">城市</option>');
			}
			$('#areaId_friend').html('<option value="">区县</option>');
			resetMoney();
		});
		$('#cityId_friend').change(function(){
			if($(this).val() != ''){
				getAreas('areaId_friend','cityId_friend','','区县');
			}else{
				$('#areaId_friend').html('<option value="">区县</option>');
			}
		});
	}
	
	getPostage();
	resetMoney();
	
	$(".js-tab li").click(function () {
		if ($(this).hasClass("off")) {
			return;
		}
		
		$(this).addClass("off");
		$(this).siblings().removeClass("off");
		
		if ($(this).data("for") == "friend") {
			if ($(".js-payment_list").size() > 0) {
				$(".js-payment_list span").eq(1).hide();
			}
		} else {
			$(".js-payment_list span").show();
		}
		
		var index = $(".js-tab li").index($(this));
		
		$(".js_address_detail").eq(index).show();
		$(".js_address_detail").eq(index).siblings().hide();
		
		var data_for = $(this).data("for");
		if (data_for == "buyerInfo") {
			$("#J_postage").html(postage_money);
		} else if (data_for == "friend") {
			$("#J_postage").html(friend_postage_money);
		} else {
			$("#J_postage").html(0);
		}
		
		resetMoney();
	});
	
	$(".payment_list span").click(function () {
		if ($(this).hasClass("selected")) {
			return;
		}
		
		var payment = $(this).data("payment");
		$("#payment_method").val(payment);
		
		$(this).addClass("selected");
		$(this).siblings().removeClass("selected");
		
		if ($(this).data("payment") == "peerpay") {
			$(".js-peerpay").show();
		} else {
			$(".js-peerpay").hide();
		}
		
	});
	
	$("#J_AddressList input[name='defaultRadio']").change(function () {
		getPostage();
	});

	$('#cart_add_form').ajaxForm({
		beforeSubmit: cart_add_form,
		success: showAddressResponse,
		dataType: 'json'
	});
	
	$(".js-express-address-list li").live("click", function (event) {
		var has_class = $(this).hasClass("order_curn");
		
		var v = $(this).data("address_id");
		$(this).addClass("order_curn");
		$(this).siblings().removeClass("order_curn");
		
		if (v == 'default') {
			document.getElementById("address_add").reset();
			$("#address_id").val("");
			$("#J_AddressEditContainer").show();
		} else {
			$("#address_id").val(v);
			$("#J_AddressEditContainer").hide();
		}
		
		if (has_class == false && v != "default") {
			getPostage();
		}
		event.stopPropagation(); 
	});
	

	// 自提地址li点击
	$(".js-self-address-list li").live("click", function (event) {
		$(this).addClass("order_curn");
		$(this).siblings().removeClass("order_curn");
	});
	
	// 更改优惠券
	$(".js-youhui").click(function () {
		var dom = $(this).closest(".user_coupon_group");
		
		dom.find(".js-youhui span").removeClass("order_curn");
		$(this).find(".order_tongji_left span").addClass("order_curn");
		
		var coupon_money = 0.0;
		var coupon_id_arr = [];
		$(".user_coupon_group").each(function () {
			coupon_money += parseFloat($(this).find(".js-youhui .order_curn").closest(".js-youhui").find(".js-coupon-money").html());
			coupon_id_arr.push($(this).find(".js-youhui .order_curn").closest(".js-youhui").data("coupon_id"));
			
			if ($(this).find(".js-youhui .order_curn").closest(".js-youhui").hasClass("supplier")) {
				supplier_coupon_money = parseFloat($(this).find(".js-youhui .order_curn").closest(".js-youhui").find(".js-coupon-money").html());
			}
		});
		
		if ($("#J_coupon_money").length > 0) {
			$("#J_coupon_money").html(coupon_money.toFixed(2));
		}
		
		$("#coupon_id").val(coupon_id_arr.toString());
		resetMoney();
	});
	
	// 更改积分
	$(".js-point").click(function () {
		var dom = $(this).closest(".user_point_group");
		
		dom.find(".js-point span").removeClass("order_curn");
		$(this).find(".order_tongji_left span").addClass("order_curn");
		
		resetMoney();
	});
	
	$(".js-platform_point_container").click(function () {
		if ($(this).find("span").hasClass("current")) {
			$(this).find("span").removeClass("current").addClass("normal");
		} else {
			$(this).find("span").removeClass("normal").addClass("current");
		}
		
		resetMoney();
	});

	$('#js-time').live('focus', function() {
		var options = {
			numberOfMonths: 1,
			dateFormat: "yy-mm-dd",
			timeFormat: "HH:mm:ss",
			showSecond: false,
			minDate : date_time
		};
		$('#js-time').datetimepicker(options);
	});
	
	$('#js-friend-time').live('focus', function() {
		var options = {
			numberOfMonths: 1,
			dateFormat: "yy-mm-dd",
			timeFormat: "HH:mm:ss",
			showSecond: false,
			minDate : date_time
		};
		$('#js-friend-time').datetimepicker(options);
	});
	
	// 优惠券
	$("#J_user_coupon tr").click(function () {
		$(this).find("input").prop("checked", true);
		
		$("#coupon_id").val($(this).find("input").val());
		$("#J_coupon_money").html($(this).find("span").html());
		resetMoney();
	});
	
	$("#J_user_coupon tr").hover(function () {
		$(this).css("background", "#e9e9e9");
		$(this).css("cursor", "pointer");
	}, function () {
		$(this).css("background", "white");
	});
});

function cart_add_form() {
	var address_id = $("#address_id").val();
	var postage = $("#postage").val();
	var postage_friend = $("#postage_friend").val();
	$("#cart_add_submit").html("确认收货信息");
	
	if ($(".js-tab").length > 0 && $(".js-tab").find(".off").data("for") == "buyerInfo") {
		if (postage != "1") {
			if (address_msg.length > 0) {
				tusi(address_msg);
			} else {
				tusi("请选择收货地址");
			}
			$("#cart_add_submit").html("确认收货信息");
			is_click = false;
			return false;
		}
	} else if ($(".js-tab").length > 0 && $(".js-tab").find(".off").data("for") == "friend") {
		if (postage_friend != "1") {
			if (address_msg.length > 0) {
				tusi(address_msg);
			} else {
				tusi("请选择收货地址");
			}
			$("#cart_add_submit").html("确认收货信息");
			is_click = false;
			return false;
		}
	}
	
	return true;
}

function showAddressResponse(data) {
	if (data.err_code == 0) {
		var result = {'status' : true, 'msg' : '确认收货地址成功', 'data' : {'nexturl' : data.err_msg}};
		showResponse(result);
	} else {
		$("#cart_add_submit").html("确认收货信息");
		is_click = false;
		if (data.err_msg != '') {
			tusi(data.err_msg);
		}
	}
}

// 计算价格
function resetMoney() {
	setPoint();
	var total_money = parseFloat($("#J_payTotalFee").html());
	var postage = parseFloat($("#J_postage").html());
	var t_money = parseFloat(total_money) + parseFloat(postage);
	var reward_money = 0;
	var reward_postage = 0;
	var coupon_money = 0;
	var float_money = 0;
	var discount_money = 0;
	var point_money = 0;
	var platform_point_money = 0;
	
	if ($("#J_reward_money").length > 0) {
		reward_money = parseFloat($("#J_reward_money").html());
	}
	
	if ($("#J_reward_postage_money").length > 0) {
		$("#J_reward_postage_money").html(postage);
		reward_postage = parseFloat(postage);
	}
	
	if ($("#J_coupon_money").length > 0) {
		coupon_money = parseFloat($("#J_coupon_money").html());
	}

	if ($("#J_float_money").length > 0) {
		float_money = parseFloat($("#J_float_money").html());
	}
	
	if ($("#J_discount_money").length > 0) {
		discount_money = parseFloat($("#J_discount_money").html());
	}
	
	if ($("#J_point_money").length > 0) {
		point_money = parseFloat($("#J_point_money").html());
	}
	
	if ($("#J_platform_point_money").length > 0) {
		platform_point_money = parseFloat($("#J_platform_point_money").html());
	}
	
	t_money = t_money - reward_money - reward_postage - coupon_money - float_money - discount_money - point_money - platform_point_money;
	t_money = parseFloat(t_money).toFixed(2);
	if (t_money < 0) {
		t_money = 0;
	}
	
	$("#J_total_money").html(t_money);
}

function setPoint() {
	var supplier_money = parseFloat($("#J_total_money").data("supplier_money")) - supplier_reward_money - supplier_coupon_money + supplier_postage_money;
	
	if (is_point && supplier_money > 0 && $("#point_1").hasClass("order_curn")) {
		var point_money = parseFloat(points_data.point) / parseFloat(points_data.price);
		var point = points_data.point;
		
		if (point_money > supplier_money) {
			point_money = supplier_money;
			point = Math.ceil(point_money * parseFloat(points_data.price));
		}
		
		if (points_data.is_percent == "1" && supplier_money * parseFloat(points_data.percent) / 100 < point_money) {
			point_money = supplier_money * parseFloat(points_data.percent) / 100;
			point = Math.ceil(point_money * parseFloat(points_data.price));
		}
		
		if (points_data.is_limit == "1" && point_money > parseFloat(points_data.offset_limit)) {
			point_money = parseFloat(points_data.offset_limit);
			point = Math.ceil(point_money * parseFloat(points_data.price));
		}
		
		if ($("#point_1").size() > 0) {
			$("#point_1").closest("div").find("i").html("您可以使用" + point + "积分，抵" + point_money.toFixed(2) + "元");
			$("#J_point_money").html(point_money.toFixed(2));
			
			$("input[name='point']").val(point);
			$("input[name='point_money']").val(point_money);
			
			$("#J_point").show();
			$(".js-point-container").show();
		}
	} else {
		$("#J_point_money").html('0.00');
		$("input[name='point']").val(0);
		$("input[name='point_money']").val(0);
	}
	
	if (is_platform_point && $(".js-platform_point_container").find("span").hasClass("current")) {
		platformPointInit();
	} else {
		$("#platform_point").html(0);
		$("#platform_point_money").html(0);
		$("#J_platform_point_money").html(0);
		$("input[name='platform_point']").val(0);
		$("input[name='platform_point_money']").val(0);
	}
}

function platformPointInit() {
	// 积分没有价值
	if (credit_setting.platform_credit_use_value == '0') {
		$("#platform_point").html(0);
		$("#platform_point_money").html(0);
		$("#J_platform_point_money").html(0);
		$("input[name='platform_point']").val(0);
		$("input[name='platform_point_money']").val(0);
		return;
	}
	
	var user_point_balance = parseFloat($(".js-user_point_balance").html());
	if (user_point_balance <= 0) {
		$("#platform_point").html(0);
		$("#platform_point_money").html(0);
		$("#J_platform_point_money").html(0);
		$("input[name='platform_point']").val(0);
		$("input[name='platform_point_money']").val(0);
		return;
	}
	
	var sub_total = parseFloat($("#J_payTotalFee").html());
	var postage1 = parseFloat($("#J_postage").html());
	var reward = 0;
	var user_coupon = 0;
	var float_amount = 0;
	var discount_money = 0;
	var point_money_t = 0;
	
	if ($("#J_reward_money").length > 0) {
		reward = parseFloat($("#J_reward_money").html());
	}

	if ($("#J_coupon_money").length > 0) {
		user_coupon = parseFloat($("#J_coupon_money").html());
	}

	if ($("#J_float_money").length > 0) {
		float_amount = parseFloat($("#J_float_money").html());
	}
	
	if ($("#J_discount_money").length > 0) {
		discount_money = parseFloat($("#J_discount_money").html())
	}
	
	if ($("#J_point_money").length > 0) {
		point_money_t = parseFloat($("#J_point_money").html());
	}
	
	var money = sub_total + postage1 - reward - user_coupon - float_amount - discount_money - point_money_t;
	if (money < 0) {
		$("#platform_point").html(0);
		$("#platform_point_money").html(0);
		$("#J_platform_point_money").html(0);
		$("input[name='platform_point']").val(0);
		$("input[name='platform_point_money']").val(0);
		return;
	}
	
	if (parseFloat(credit_setting.platform_credit_use_value) * money > user_point_balance) {
		$("#platform_point").html(0);
		$("#platform_point_money").html(0);
		$("#J_platform_point_money").html(0);
		$("input[name='platform_point']").val(0);
		$("input[name='platform_point_money']").val(0);
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
	
	$("#platform_point").html(platform_point.toFixed(2));
	$("#platform_point_money").html((platform_point / credit_setting.platform_credit_use_value).toFixed(2));
	$("#J_platform_point_money").html((platform_point / credit_setting.platform_credit_use_value).toFixed(2));
	$("input[name='platform_point']").val(platform_point.toFixed(2));
	$("input[name='platform_point_money']").val((platform_point / credit_setting.platform_credit_use_value).toFixed(2));
}
