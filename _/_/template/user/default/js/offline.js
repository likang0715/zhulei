var uid = 0;
var login_qrcode_id = 0;

$(function() {
	load_page('.app__content', load_url, {page : 'offline_add'}, '', function () {
		if (credit_setting.platform_credit_use_value > 0) {
			$("#platform_point_max").html(($(".js-platform_point").data("platform_point") / credit_setting.platform_credit_use_value).toFixed(2));
		}
		
		var product_category_html = '<option value="0">请选择</option>';
		for (var i in product_category_list) {
			product_category_html += '<option value="' + product_category_list[i].cat_id + '">' + product_category_list[i].cat_name + '</option>';
		}
		
		$(".js-product_category").html(product_category_html);
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
	
	$(".js-nickname").live("keyup focus", function (event) {
		if ($(this).prop("readonly")) {
			return;
		}
		
		if ($(".js-scan-user").html() == "取消扫会员卡") {
			return;
		}
		
		if ($(this).val().length > 0 && event.type == 'focusin' && $(this).attr("old-data") == $(this).val()) {
			if ($(".js-drop-dia").find("li").size() > 0) {
				$(".js-drop-dia").show();
			}
			return;
		}
		
		if ($(this).attr("old-data") == $(this).val()) {
			return;
		}
		
		uid = 0;
		if ($(this).val().length == 0) {
			$(".js-drop-dia").hide();
			return;
		}
		
		$(this).attr("old-data", $(this).val());
		$.post(user_search_url, {nickname : $(this).val()}, function (result) {
			if (result.err_code == "0") {
				var html = "";
				var user_list = result.err_msg;
				for(var i in user_list) {
					html += '<li class="js_user_detail" uid="' + user_list[i].uid + '">' + user_list[i].nickname + '</li>';
				}
				$(".js-drop-dia").find("ul").html(html);
				$(".js-drop-dia").show();
			} else {
				$(".js-drop-dia").find("ul").html("");
				$(".js-drop-dia").hide();
			}
		})
	});
	
	$(".js-user-scan").live("click", function () {
		if ($(this).hasClass("disabled")) {
			return;
		}
		$(this).addClass("disabled");
		$(".js-check_phone").addClass("disabled");
		$(".js-scan-user").addClass("disabled");
		$(".js-user-add").addClass("disabled");
		
		$.get(user_weixin_scan_url, function (result) {
			if (result.err_code) {
				layer_tips(1, result.err_msg);
				$(".js-user-scan").removeClass("disabled");
				$(".js-check_phone").removeClass("disabled");
				$(".js-scan-user").removeClass("disabled");
				$(".js-user-add").removeClass("disabled");
				return;
			}
			
			var html_obj = $('<div class="modal hide fade order-price in js-user-scan-container" style="margin-top: -1000px; display: block; width:300px;" aria-hidden="false">\
					<div class="modal-header">\
						<a class="close js-scan-close" data-dismiss="modal">×</a>\
						<h3 class="title">微信扫码</h3>\
					</div>\
					<div class="modal-body js-detail-container">\
						<div>\
							<img src="' + result.err_msg.weixin_qr_image + '" style="width:180px; height:180px; padding-left:45px;" />\
						</div>\
						<div style="width:100%; color:green; text-align:center; height:20px; line-height:24px;" class="js-scan-message"></div>\
					</div>\
				</div>');

			$('body').append(html_obj);
			$('.js-user-scan-container').animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow");
			
			login_qrcode_id = result.err_msg.id;
			is_load_login_scan = true;
			userWeixinScan();
		});
	});
	
	$(".js-scan-close").live("click", function () {
		is_load_login_scan = false;
		$(".js-user-scan").removeClass("disabled");
		$(".js-check_phone").removeClass("disabled");
		$(".js-scan-user").removeClass("disabled");
		$(".js-user-add").removeClass("disabled");
	});
	
	// 扫用户虚拟会员卡
	$(".js-scan-user").live("click", function () {
		if ($(this).html() == "扫会员卡") {
			$(".js-nickname").val("");
			$(".js-nickname").focus();
			$(".js-nickname").data("type", "uid");
			$(".js-nickname").attr("placeholder", "扫用户会员卡，请将光标放到输入框内");
			$(this).html("取消扫会员卡");
		} else {
			$(".js-nickname").val("");
			$(".js-nickname").focus();
			$(".js-nickname").data("type", "nickname");
			$(".js-nickname").attr("placeholder", "请填写会员昵称或手机号进行搜索");
			$(this).html("扫会员卡");
		}
	});
	
	$(".js-user-add").live("click", function () {
		addUser();
	});
	
	$(".js-save-add-user").live("click", function () {
		var add_user_phone = $("input[name='add_user_phone']").val();
		var add_user_password  = $("input[name='add_user_password']").val();
		
		if (add_user_phone.length == 0) {
			layer_tips(1, "请填写手机号");
			return;
		}
		
		if (!/^\d{5,12}$/.test(add_user_phone)) {
			layer_tips(1, "请正确填写手机号");
			return;
		}
		
		if (add_user_password.length == 0) {
			layer_tips(1, "请填写密码");
			return;
		}
		
		var data = {};
		data.phone = add_user_phone;
		data.password = add_user_password;
		data.login_qrcode_id = login_qrcode_id;
		
		$.post(add_user_url, data, function (result) {
			if (result.err_code == 0) {
				if (login_qrcode_id > 0) {
					userWeixinScan();
				} else {
					uid = result.err_msg;
					$(".js-nickname").data("type", "uid");
					$(".js-nickname").val(uid);
					$(".js-check_phone").trigger("click");
					
					$('.modal').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow", function(){
						$('.modal').remove();
					});
				}
			} else {
				layer_tips(1, result.err_msg);
			}
		});
	});
	
	$(window).keydown(function(event){
		if (event.keyCode == 13 && $('.js-nickname').is(':focus')) {
			$(".js-check_phone").trigger("click");
		}
	});
	
	$(document).live("click", function(e) {
		e = window.event || e;
		obj = $(e.srcElement || e.target);
		if ($(obj).is(".js_user_detail")) {
			$(".js-nickname").val($(obj).html());
			uid = $(obj).attr("uid");
			$(".js-drop-dia").hide();
		} else if ($(obj).is(".js-nickname")) {
			
		} else {
			$(".js-drop-dia").hide();
		}
	});
	
	$(".js-drop-dia li").live("mouseover", function () {
		$(this).addClass("current").siblings().removeClass("current")
	});
	
	$(".js-check_phone").live("click", function () {
		if ($(this).hasClass("disabled")) {
			return;
		}
		
		var nickname = $(".js-nickname").val();
		var type = $(".js-nickname").data("type");
		
		if (nickname.length == 0) {
			layer_tips(1, "请输入用户昵称");
			$(".js-nickname").focus();
			return;
		}
		
		if (type == 'uid' && nickname.indexOf('-') >= 0) {
			var data = nickname.split('-');
			try {
				nickname = data[2];
			} catch(e) {
				
			}
		}
		
		var weixin_bind = 0;
		if ($("#weixin_bind").prop("checked")) {
			weixin_bind = 1;
		}
		
		$.post(user_check_url, {nickname : nickname, uid : uid, weixin_bind : weixin_bind, type : type}, function (data) {
			if (data.err_code != "0") {
				layer_tips(1, data.err_msg);
				return;
			} else {
				$(".js-drop-dia").hide();
				address_list = data.err_msg.user_address_list;
				uid = data.err_msg.uid;
				is_point = data.err_msg.is_point;
				points_data = data.err_msg.points_data;
				platform_point = parseFloat(data.err_msg.point_balance);
				
				$(".js-user_point_balance").html(data.err_msg.point_balance);
				
				if (!data.err_msg.is_weixin) {
					var html_obj = $('<div class="modal hide fade order-price in" style="margin-top: -1000px; display: block; width:300px;" aria-hidden="false">\
										<div class="modal-header">\
											<a class="close" data-dismiss="modal">×</a>\
											<h3 class="title">绑定微信</h3>\
										</div>\
										<div class="modal-body js-detail-container">\
											<div>\
												<img src="' + data.err_msg.weixin_qr_image + '" style="width:180px; height:180px; padding-left:45px;" />\
											</div>\
											<div style="width:100%; color:green; text-align:center; display:none; height:20px; line-height:24px;" class="js-weixinbind">绑定成功</div>\
										</div>\
										<div class="modal-footer clearfix">\
											<a href="javascript:;" class=" btn btn-primary pull-right js-close">暂不绑定</a>\
										</div>\
									</div>');
			
					$('body').append(html_obj);
					$('.modal').animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow");
					
					weixin_bind = setInterval("weixinBind()", 5000);
				}
				
				$(".js-nickname").val(data.err_msg.nickname);
				
				// 产品选择显示
				$(".js-product-container").show();
				$(".js-check_phone").hide();
				$(".js-user-scan").hide();
				$(".js-scan-user").hide();
				$(".js-user-add").hide();
				
				$(".js-address_list").empty();
				if (address_list) {
					var html = "";
					var checked = "";
					for (var i in address_list) {
						checked = "";
						if (i == 0) {
							checked = 'checked="checked"';
							$(".js-name").val(address_list[i].name);
							$(".js-tel").val(address_list[i].tel);
						}
						html += '<tr class="js-address_dateil js-address_detail_' + address_list[i].address_id + '"  data-province="' + address_list[i].province + '" data-city="' + address_list[i].city + '" data-area="' + address_list[i].area + '" data-address="' + address_list[i].address + '" data-address_id="' + address_list[i].address_id + '" data-default="0" data-name="' + address_list[i].name + '" data-tel="' + address_list[i].tel + '">';
						html += '	<td class="center_tds" style="width:60%; padding-left:15px; height:30px;">';
						html += '		<input type="radio" name="address_detail" ' + checked + ' value="' + address_list[i].address_id + '" />';
						html += '		<span>' + address_list[i].province_txt + address_list[i].city_txt + address_list[i].area_txt + address_list[i].address + '</span>';
						html += '	</td>';
						html += '	<td style="width:15%">';
						html += '		' + address_list[i].name;
						html += '	</td>';
						html += '	<td style="width:15%">';
						html += '		' + address_list[i].tel;
						html += '	</td>';
						html += '	<td align="center" class="js-edit-td" >';
						html += '		<a href="javascript:;" data-type="friend" class="btn btn-small js-address-edit" style="padding:4px 7px;">编辑</a>';
						html += '	</td>';
						html += '</tr>';
					}
					
					$(".js-address_list").append(html);
					if (html.length == 0) {
						$(".js-address-table").find("input").prop("checked", true);
						changeArea();
						$(".js-address-form").show();
						$("#provinceId_m").closest("td").show();
					} else {
						$(".js-address-form").hide();
					}
				} else {
					$(".js-name").val(data.err_msg.nickname);
					$(".js-tel").val(data.err_msg.phone);
				}
				
				$(".js-nickname").attr("readonly", "readonly");
			}
		}, "json");
		
		return false;
	});
	
	$(".close, .js-close").live("click", function () {
		$('.modal').animate({'margin-top': '-1000px'}, "slow", function () {
			$(".modal").remove();
			clearInterval(weixin_bind);
		});
	});
	
	// 本单金额
	$("input[name='total']").live("blur", function () {
		var total = $(this).val();
		
		if (total.length == 0) {
			return;
		}
		
		if(!/^\d+(\.\d+)?$/.test(total)){
			layer_tips(1, "请输入合法的数字");
			$(this).val($(this).attr("old-value"));
			$(this).focus();
			return;
		}else if(parseFloat(total) < 0.01) {
			layer_tips(1, '订单金额最小为 0.01');
			$(this).val($(this).attr("old-value"));
			$(this).focus();
			return;
		}
		
		$(this).attr("old-value", total);
		
		total = parseFloat(total);
		var service_fee = (total * credit_setting.platform_credit_rule * credit_setting.credit_deposit_ratio / 100).toFixed(2);
		$(".js-send_platform_point").html(total * credit_setting.platform_credit_rule);
		$(".js-service_fee").html(service_fee);
		return;
		// 所有积分可抵现金额
		var platform_point_money = 0;
		if (credit_setting.platform_credit_use_value > 0) {
			platform_point_money = parseFloat($(".js-platform_point").data("platform_point")) / parseFloat(credit_setting.platform_credit_use_value);
		}
		
		// 最小使用现金
		var min_cash = 0;
		var max_cash = parseFloat($(".js-platform_point").data("margin_balance"));
		if (credit_setting.offline_trade_money > 0) {
			min_cash = (total * credit_setting.credit_deposit_ratio / 100 * credit_setting.offline_trade_money / 100).toFixed(2);
			// 需要使用服务费时，最少现金为0.01
			
			if (service_fee > 0 && min_cash <= 0.01) {
				min_cash = 0.01;
			}
			if (min_cash > max_cash) {
				layer_tips(1, "您的充值现金不足");
				$(this).focus();
				return;
			}
		}
		
		// 处理最优使用配比
		var max_platform_point_money = (service_fee - min_cash).toFixed(2);
		if (max_platform_point_money > platform_point_money) {
			max_platform_point_money = platform_point_money;
		}
		
		if (service_fee - max_platform_point_money > max_cash) {
			layer_tips(1, "您的充值现金不足");
			$(this).focus();
			return;
		}
		
		max_platform_point_money = (max_platform_point_money - 0.0049).toFixed(2);
		if (max_platform_point_money < 0) {
			max_platform_point_money = 0;
		}
		
		//$("input[name='cash']").val((service_fee - max_platform_point_money).toFixed(2));
		//$("input[name='platform_point']").val((max_platform_point_money * parseFloat(credit_setting.platform_credit_use_value)).toFixed(2));
	});
	
	// 平台服务费使用现金
	$("input[name='cash']").live("blur", function () {
		var cash = $(this).val();
		var service_fee = parseFloat($(".js-service_fee").html());
		
		if (cash.length == 0) {
			return;
		}
		
		if(!/^\d+(\.\d+)?$/.test(cash)){
			layer_tips(1, "请输入合法的数字");
			$(this).focus();
			return;
		}
		cash = parseFloat(cash);
		if (cash <= 0) {
			return;
		}
		
		if (cash > service_fee) {
			layer_tips(1, "现金不能大于本单需要支付的服务费");
			return;
		}
		
		if (credit_setting.platform_credit_use_value > 0) {
			var platform_point = parseFloat($(".js-platform_point").data("platform_point")) / parseFloat(credit_setting.platform_credit_use_value);
			
			if (platform_point < (service_fee - cash).toFixed(2)) {
				layer_tips(1, "您的" + credit_setting.platform_credit_name + "不足，请使用更多的现金");
				return;
			}
			
			if ((parseFloat(cash) / service_fee) * 100 < parseFloat(credit_setting.offline_trade_money)) {
				layer_tips(1, "现金所占比例不能少于" + credit_setting.offline_trade_money + "%");
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
		
		if(!/^\d+(\.\d+)?$/.test(platform_point)){
			layer_tips(1, "请输入合法的数字");
			$(this).focus();
			return;
		}
		platform_point = parseFloat(platform_point);
		
		if (platform_point > parseFloat($(".js-platform_point").data("platform_point"))) {
			layer_tips(1, "最多只能使用" + $(".js-platform_point").data("platform_point"));
			return;
		}
		
		if (credit_setting.platform_credit_use_value > 0) {
			var platform_point_money = platform_point / parseFloat(credit_setting.platform_credit_use_value);
			var cash = (service_fee - platform_point_money).toFixed(2);
			
			if (cash > parseFloat($(".js-platform_point").data("margin_balance"))) {
				layer_tips(1, "您的充值现金不足");
				return;
			}
			
			if ((parseFloat(cash) / service_fee) * 100 < parseFloat(credit_setting.offline_trade_money)) {
				layer_tips(1, "现金所占比例不能少于" + credit_setting.offline_trade_money + "%");
				return;
			}
			
			$("input[name='cash']").val(cash);
		}
	});
	
	// 提交订单
	$(".js-btn-save").live("click", function () {
		$(".js-btn-save").attr("disabled", "disabled");
		$(".js-btn-save").val($(".js-btn-save").attr("data-loading-text"));
		
		var data = {};
		var total = $("input[name='total']").val();
		var cash = $("input[name='cash']").val();
		var platform_point = $("input[name='platform_point']").val();
		var cat_id = 0;
		var product_name = $("input[name='product_name']").val();
		var number = $("input[name='number']").val();
		
		if (uid == 0) {
			$("#phone").focus();
			$(".js-check_phone").show();
			layer_tips(1, "请选择用户");
			resetSaveBtn();
			return;
		}
		
		if(!/^\d+(\.\d+)?$/.test(total)){
			layer_tips(1, "请输入合法的数字");
			$("input[name='total']").focus();
			resetSaveBtn();
			return;
		}
		if (parseFloat(total) < 0.01) {
			layer_tips(1, "订单金额最小为0.01");
			$("input[name='total']").focus();
			resetSaveBtn();
			return;
		}
		
		if ($(".js-product_category").size() > 0 && $(".js-product_category").val() == "0") {
			layer_tips(1, "请选择商品分类");
			resetSaveBtn();
			return;
		}
		
		cat_id = $(".js-product_category").val();
		if ($(".js-product_category_son").size() > 0 && $(".js-product_category_son").val() == "0") {
			layer_tips(1, "请选择商品分类");
			resetSaveBtn();
			return;
		} else if ($(".js-product_category_son").size() > 0) {
			cat_id = $(".js-product_category_son").val();
		}
		
		if (product_name.length == 0) {
			layer_tips(1, "请填写产品名称");
			resetSaveBtn();
			return;
		}
		
		if(!/^\d+?$/.test(number)){
			layer_tips(1, "请输入合法的数字");
			$("input[name='number']").focus();
			resetSaveBtn();
			return;
		}
		
		if (number <= 0) {
			layer_tips(1, "请输入大于0的数字");
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
		
		$.post(order_offline_add_url, data, function (result) {
			if (result.err_code == "0") {
				layer_tips(0, "订单创建成功");
				location.href = "/user.php?c=offline&a=offline_list";
			} else {
				layer_tips(1, result.err_msg);
				resetSaveBtn();
			}
		});
	});
	
	function resetSaveBtn() {
		$(".js-btn-save").removeAttr("disabled");
		$(".js-btn-save").val("创建订单");
	}
})

function weixinBind() {
	$.post(user_weixinbind_url, {"uid" : uid}, function (result) {
		if (result.err_code == "0") {
			$(".js-weixinbind").show();
			clearInterval(weixin_bind);
			setTimeout(function () {
				$('.modal').animate({'margin-top': '-1000px'}, "slow", function () {
					$(".modal").remove();
				});
			}, 2000);
		}
	});
}

function userWeixinScan() {
	$.get(user_weixin_login_url, {'id': login_qrcode_id}, function (data) {
		if (!is_load_login_scan) {
			return;
		}
		
		if (data.err_code == '1000') {
			return;
		} else if (data.err_code == '100') {
			layer_tips(1, data.err_msg);
		} else if (data.err_code == '20') {
			addUser();
		} else if (data.err_code == '10') {
			userWeixinScan();
		} else {
			address_list = data.err_msg.user_address_list;
			uid = data.err_msg.uid;
			is_point = data.err_msg.is_point;
			points_data = data.err_msg.points_data;
			
			$(".js-nickname").val(data.err_msg.nickname);
			
			// 产品选择显示
			$(".js-product-container").show();
			$(".js-check_phone").hide();
			$(".js-user-scan").hide();
			
			$(".js-address_list").empty();
			
			
			$(".js-nickname").attr("readonly", "readonly");
			$(".js-scan-user").remove();
			$(".js-user-add").remove();
			
			$('.modal').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow", function(){
				$('.modal').remove();
			});
		}
	});
}

// 手工添加用户
function addUser() {
	var html_obj = $('<div class="modal hide fade order-price in" style="margin-top: -1000px; display: block;" aria-hidden="false">\
						<div class="modal-header">\
							<a class="close" data-dismiss="modal">×</a>\
							<h3 class="title">注册用户</h3>\
						</div>\
						<div class="modal-body js-detail-container">\
							<div>\
								<table class="table order-price-table">\
									<tr>\
										<td width="100">手机号:</td>\
										<td>\
											<input type="text" name="add_user_phone" />\
										</td>\
									</tr>\
										<tr>\
											<td>密码:</td>\
											<td><input type="password" name="add_user_password" value="123456" /></td>\
										</tr>\
								</table>\
							</div>\
						</div>\
						<div class="modal-footer clearfix">\
							<a href="javascript:;" class="btn btn-primary pull-right js-save-add-user" data-loading-text="确 定...">确 定</a>\
						</div>\
					</div>');
			
	$('body').append(html_obj);
	$('.modal').animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow");
}