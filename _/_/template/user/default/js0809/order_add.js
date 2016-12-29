var address_list;
var uid = 0;
var postage_free = false;
var logistics_postage = {"money" : 0, "error" : false, "reload" : false};
var friend_postage = {"money" : 0, "error" : false, "reload" : false};
var weixin_bind;
var is_point = false;
var points_data;
var platform_point = 0.00;
var point_money = 0.00;
var postage_money = 0.00;
var reward_money = 0.00;
var coupon_money = 0.00;
var login_qrcode_id = 0;
var is_load_login_scan = false;
var max_platform_point = 0;

$(function() {
	load_page('.app__content', load_url, {page : 'order_add'}, '', function () {
		//load_widget_link_box();
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
				
				load_widget_link_box();
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
	
	$(".js-product_delete").live("click", function () {
		$(this).closest("tr").remove();
		
		if ($(".js-product-list-selected").find("tr").size() == 0) {
			var html = '<tr class="js-no-product"><td colspan="4" style="text-align:center; height:100px;">还没有相关数据。</td></tr>';
			$(".js-product-list-selected").html(html);
		}
		
		// 运费需要重新计算
		logistics_postage.reload = true;
		friend_postage.reload = true;
		
		point_init = true;
		productMoney();
	});
	
	// 配送方式选择
	$(".js-logistics-type-list a").live("click", function () {
		if ($(this).hasClass("orange")) {
			return;
		}
		
		$(this).siblings().removeClass("orange");
		$(this).addClass("orange");
		
		var type = $(this).data("type");
		$(".js-logistics-content-list .content-deteil").hide();
		$(".js-logistics-content-list .js-" + type).show();
		
		// 送朋友，隐藏货到付款
		if (type == "friend") {
			$(".js-pay-type-list .offline").hide();
			if ($("#provinceId_friend").closest("td").attr("type") == "false") {
				changeArea("provinceId_friend", "cityId_friend", "areaId_friend");
				$("#provinceId_friend").closest("td").attr("type", "true").show();
			}
		} else {
			$(".js-pay-type-list .offline").show();
		}
		
		if (type == "logistics") {
			if (logistics_postage.reload == true) {
				var data = getProductData();
				if (data) {
					getPostage(data);
				}
			} else {
				if (logistics_postage.error == true) {
					layer_tips(1, "不支持此收货地址");
					$("#js-postage").html("0.00");
					$(".js-btn-save").attr("disabled", "disabled");
				} else {
					$("#js-postage").html(logistics_postage.money);
					$(".js-btn-save").removeAttr("disabled");
				}
			}
		} else if (type == "friend") {
			if (friend_postage.reload == true) {
				var data = getProductData();
				if (data) {
					getPostage(data);
				}
			} else {
				if (friend_postage.error == true) {
					layer_tips(1, "不支持此收货地址");
					$("#js-postage").html("0.00");
					$(".js-btn-save").attr("disabled", "disabled");
				} else {
					$("#js-postage").html(friend_postage.money);
					$(".js-btn-save").removeAttr("disabled");
				}
			}
		} else {
			$("#js-postage").html("0.00");
			$(".js-btn-save").removeAttr("disabled");
		}
		
		point_init = true;
		resetPrice();
	});
	
	// 积分抵扣选择
	$(".js-point-type-list a").live("click", function () {
		if ($(this).hasClass("orange")) {
			return;
		}
		
		var point_type = $(this).data("type");
		$(this).addClass("orange").siblings().removeClass("orange");
		
		if (point_type == "user") {
			if ($(".js-reward-table").data("has_reward") == "1") {
				$(".js-reward-container").show();
			}
			
			if ($(".js-coupon-table").data("has_coupon") == "1") {
				$(".js-coupon-container").show();
			}
			
			if ($(".js-point-container").data("point") > 0 && $(".js-point-container").data("point_money") > 0) {
				$(".js-store_point_container").show();
			}
			
			$(".js-platform_point_container").show();
			$(".js-store_platform_point_container").hide();
			$(".js-user_platform_point_container").hide();
		} else if (point_type == 'platform') {
			$(".js-coupon-container").hide();
			$(".js-reward-container").hide();
			$(".js-store_point_container").hide();
			$(".js-platform_point_container").hide();
			$(".js-user_platform_point_container").hide();
			$(".js-store_platform_point_container").show();
		} else if (point_type == 'user_platform') {
			$(".js-coupon-container").hide();
			$(".js-reward-container").hide();
			$(".js-store_point_container").hide();
			$(".js-platform_point_container").hide();
			$(".js-store_platform_point_container").hide();
			$(".js-user_platform_point_container").show();
		}
		
		resetPrice();
	});
	
	$(".js-address-edit").live("click", function (event) {
		event.stopPropagation();
		var tr_obj = $(this).closest("tr");
		var province = tr_obj.data("province");
		var city = tr_obj.data("city");
		var area = tr_obj.data("area");
		var address = tr_obj.data("address");
		var address_id = tr_obj.data("address_id");
		var is_default = tr_obj.data("default");
		var name = tr_obj.data("name");
		var tel = tr_obj.data("tel");
		
		$(".js-address-form").show();
		
		$("#provinceId_m").attr("data-province", province);
		$("#cityId_m").attr("data-city", city);
		$("#areaId_m").attr("data-area", area);
		$(".js-address-form .js-jiedao").val(address);
		$(".js-address-form .js-name").val(name);
		$(".js-address-form .js-tel").val(tel);
		$(".js-address-form .js-address_id").val(address_id);
		$(".js-address-form .js-default").val(is_default);
		
		changeArea();
	});
	
	// 绑定收货地址点击选择
	$(".js-address-table tr").live("click", function () {
		if ($(this).find("input").prop("checked")) {
			return;
		}
		
		$(".js-address-table").find("input").prop("checked", false);
		$(this).find("input").prop("checked", true);
		
		if ($(this).find("input").val() == "0") {
			$("#provinceId_m").attr("data-province", "");
			$("#cityId_m").attr("data-city", "");
			$("#areaId_m").attr("data-area", "");
			$(".js-address-form .js-jiedao").val("");
			$(".js-address-form .js-name").val("");
			$(".js-address-form .js-tel").val("");
			$(".js-address-form .js-address_id").val("0");
			
			changeArea();
			$(".js-address-form").show();
			$("#provinceId_m").closest("td").show();
		} else {
			$(".js-address-form").hide();
			// 重新计算运费
			var product = [];
			$(".js-product-list-selected tr").each(function (i) {
				if ($(this).hasClass("js-no-product")) {
					return;
				}
				product.push($(this).attr("data-product_id") + "_" + $(this).attr("data-sku_id") + "_" + $(this).attr("data-number"));
			});
			
			if (product.length > 0 && uid) {
				var data = {};
				data.product_list = product;
				data.uid = uid;
				
				getPostage(data);
			}
		}
	});
	
	// 送朋友，更改收货地址，计算运费
	$("#provinceId_friend").live("change", function () {
		var product = [];
		$(".js-product-list-selected tr").each(function (i) {
			if ($(this).hasClass("js-no-product")) {
				return;
			}
			product.push($(this).attr("data-product_id") + "_" + $(this).attr("data-sku_id") + "_" + $(this).attr("data-number"));
		});
		
		if (product.length > 0 && uid) {
			var data = {};
			data.product_list = product;
			data.uid = uid;
			
			getPostage(data);
		}
	})
	
	$(".js-address_bnt").live("click", function () {
		var province = $("#provinceId_m").val();
		var city = $("#cityId_m").val();
		var area = $("#areaId_m").val();
		var jiedao = $(".js-address-form .js-jiedao").val();
		var name = $(".js-address-form .js-name").val();
		var tel = $(".js-address-form .js-tel").val();
		var address_id = $(".js-address-form .js-address_id").val();
		var address_default = $(".js-address-form .js-default").val();
		
		if (province.length <= 0) {
			layer_tips(1, "请选择省份");
			$("#provinceId_m").focus();
			return false;
		}

		if (city.length <= 0) {
			layer_tips(1, "请选择城市");
			$("#cityId_m").focus();
			return false;
		}

		if (area.length <= 0) {
			layer_tips(1, "请选择地区");
			$("#areaId_m").focus();
			return false;
		}
		
		if (name.length == 0) {
			layer_tips(1, "请填写收货人姓名");
			$(".js-address-form .js-name").focus();
			return false;
		}

		if (tel.length == 0) {
			layer_tips(1, '请填写手机号码');
			$(".js-address-form .js-tel").focus();
			return false;
		}
		var regMobile = /^\d{5,12}$/;//手机,简单判断
		
		if (!regMobile.test(tel)) {
			layer_tips(1, "请正确填写手机号");
			$(".js-address-form .js-tel").focus();
			return false;
		}
		
		if (jiedao.length < 1) {
			layer_tips(1, '街道地址不能少于1个字');
			$(".js-address-form .js-jiedao").focus();
			return false;
		}

		if (jiedao.length　> 120) {
			layer_tips(1, '街道地址不能多于120个字');
			$(".js-address-form .js-jiedao").focus();
			return false;
		}
		
		var data = {};
		data.province = province;
		data.city = city;
		data.area = area;
		data.name = name;
		data.jiedao = jiedao;
		data.tel = tel;
		data.address_id = address_id;
		data.uid = uid;
		
		$.post(user_address_url, data, function (result) {
			try {
				if (result.err_code > 0) {
					layer_tips(1, result.err_msg);
				} else {
					address_id = result.err_msg.address_id;
					var province_txt = result.err_msg.province_txt;
					var city_txt = result.err_msg.city_txt;
					var area_txt = result.err_msg.area_txt;
					
					if ($(".js-address_detail_" + address_id).size() > 0) {
						var tr_obj = $(".js-address_detail_" + address_id);
						tr_obj.attr("data-province", province);
						tr_obj.attr("data-city", city);
						tr_obj.attr("data-area", area);
						tr_obj.attr("data-address", jiedao);
						tr_obj.attr("data-address_id", address_id);
						tr_obj.attr("data-name", name);
						tr_obj.attr("data-tel", tel);
						
						tr_obj.find("td").eq(0).find("span").html(province_txt + city_txt + area_txt + jiedao);
						tr_obj.find("td").eq(1).html(name);
						tr_obj.find("td").eq(2).html(tel);
					} else {
						var html = '';
						html += '<tr class="js-address_dateil js-address_detail_' + address_id + '"  data-province="' + province + '" data-city="' + city + '" data-area="' + area + '" data-address="' + jiedao + '" data-address_id="' + address_id + '" data-default="0" data-name="' + name + '" data-tel="' + tel + '">';
						html += '	<td class="center_tds" style="width:60%; padding-left:15px; height:30px;">';
						html += '		<input type="radio" name="address_detail" checked="checked" value="' + address_id + '" />';
						html += '		<span>' + province_txt + city_txt + area_txt + jiedao + '</span>';
						html += '	</td>';
						html += '	<td style="width:15%">';
						html += '		' + name;
						html += '	</td>';
						html += '	<td style="width:15%">';
						html += '		' + tel;
						html += '	</td>';
						html += '	<td align="center" class="js-edit-td" ><a href="javascript:;" data-type="friend" class="btn btn-small js-address-edit" style="padding:4px 7px;">编辑</a></td>';
						html += '</tr>';
						
						$(".js-address_list").append(html);
					}
					
					var product_data = getProductData()
					getPostage(product_data);
					$(".js-address-form").hide();
				}
			} catch (e) {
				
			}
		});
	});
	
	$(".js-selffetch_detail").live("click", function () {
		$(this).siblings().find("input").prop("checked", false);
		$(this).find("input").prop("checked", true);
	});
	
	$('.js-date').live('focus', function() {
		var options = {
			numberOfMonths: 1,
			dateFormat: "yy-mm-dd",
			timeFormat: "HH:mm:ss",
			showSecond: true,
			beforeShow: function() {
				if ($('.js-date').val() != '') {
					$(this).datepicker('option', 'minDate', new Date($('.js-date').attr('min-date')));
				}
			},
			onSelect: function() {
				if ($('.js-date').attr('min-date') != '') {
					$('.js-date').datepicker('option', 'minDate', new Date($('.js-date').attr('min-date')));
				}
			}
		};
		$('.js-date').datetimepicker(options);
	});
	
	$('.js-friend_date').live('focus', function() {
		var options = {
			numberOfMonths: 1,
			dateFormat: "yy-mm-dd",
			timeFormat: "HH:mm:ss",
			showSecond: true,
			beforeShow: function() {
				if ($('.js-friend_date').val() != '') {
					$(this).datepicker('option', 'minDate', new Date($('.js-friend_date').attr('min-date')));
				}
			},
			onSelect: function() {
				if ($('.js-friend_date').attr('min-date') != '') {
					$('.js-friend_date').datepicker('option', 'minDate', new Date($('.js-friend_date').attr('min-date')));
				}
			}
		};
		$('.js-friend_date').datetimepicker(options);
	});
	
	// 支付方式
	$(".js-pay-type-list a").live("click", function () {
		$(this).siblings().removeClass("orange");
		$(this).addClass("orange");
	});
	
	// 优惠券选择
	$(".js-coupon-table tr").live("click", function () {
		$(this).siblings().find("input").prop("checked", false);
		$(this).find("input").prop("checked", true);
		
		$("#js-user_coupon").html($(this).find("input").attr("data-money"));
		point_init = true;
		resetPrice();
	});
	
	$("input[name='point']").live("click", function () {
		point_init = true;
		resetPrice();
	});
	
	// 更改平台积分
	$(".js-platform_point_input").live("click", function () {
		if ($(this).prop("checked")) {
			$(".js-platform_point_money span").html($(".js-platform_point_use_money").html());
			$(".js-platform_point_money").show();
			
			$("input[name='platform_point']").prop("disabled", false);
		} else {
			$(".js-platform_point_money span").html("0.00");
			$(".js-platform_point_money").hide();
			
			$("input[name='platform_point']").prop("disabled", true);
		}
		
		resetPrice();
	});
	
	// 更改使用平台积分
	$("input[name='platform_point']").live("blur", function () {
		if ($(this).val().length == 0) {
			$(".js-platform_point_money span").html("0.00");
			$(".js-platform_point_use_money").html('0');
		} else {
			var point = $(this).val();
			if(!/^\d+(\.\d+)?$/.test(point)){
				layer_tips(1, credit_setting.platform_credit_name + ",请输入合法的数字");
				$(this).val($(this).attr("old-value"));
				$(this).focus();
				return;
			}else if(parseFloat(point) < 0.01) {
				layer_tips(1, credit_setting.platform_credit_name + ',最小为 0.01');
				$(this).val($(this).attr("old-value"));
				$(this).focus();
				return;
			}
			
			// 是否大于最多使用的积分
			if (parseFloat(point) > parseFloat($(".js-platform_point_max").html())) {
				layer_tips(1, '最多只能使用' + $(".js-platform_point_max").html() + "个" + credit_setting.platform_credit_name);
				$(this).val($(this).attr("old-value"));
				$(this).focus();
				return;
			}
			
			$(this).attr("old-value", $(this).val());
			
			$(".js-platform_point_use_money").html((parseFloat(point) / credit_setting.platform_credit_use_value - 0.0049).toFixed(2));
			$(".js-platform_point_money span").html((parseFloat(point) / credit_setting.platform_credit_use_value - 0.0049).toFixed(2));
			
			resetPrice();
		}
	});
	
	// 更改平台积分
	$("#point_3").live("click", function () {
		if ($(this).prop("checked")) {
			$(".js-platform_point_money span").html($(".js-store_platform_point_use_money").html());
			$(".js-platform_point_money").show();
			
			$("input[name='store_platform_point']").prop("disabled", false);
		} else {
			$(".js-platform_point_money span").html("0.00");
			$(".js-platform_point_money").hide();
			
			$("input[name='store_platform_point']").prop("disabled", true);
		}
		
		resetPrice();
	});
	
	// 更改店铺用户平台积分
	// 更改平台积分
	$("#point_4").live("click", function () {
		if ($(this).prop("checked")) {
			$(".js-platform_point_money span").html($(".js-user_platform_point_use_money").html());
			$(".js-platform_point_money").show();
			
			$("input[name='user_platform_point']").prop("disabled", false);
		} else {
			$(".js-platform_point_money span").html("0.00");
			$(".js-platform_point_money").hide();
			
			$("input[name='user_platform_point']").prop("disabled", true);
		}
		
		resetPrice();
	});
	
	// 更改使用店铺平台积分
	$("input[name='store_platform_point']").live("blur", function () {
		if ($(this).val().length == 0) {
			$(".js-platform_point_money span").html("0.00");
			$(".js-platform_point_use_money").html('0');
		} else {
			var point = $(this).val();
			if(!/^\d+(\.\d+)?$/.test(point)){
				layer_tips(1, credit_setting.platform_credit_name + ",请输入合法的数字");
				$(this).val($(this).attr("old-value"));
				$(this).focus();
				return;
			}else if(parseFloat(point) < 0.01) {
				layer_tips(1, credit_setting.platform_credit_name + ',最小为 0.01');
				$(this).val($(this).attr("old-value"));
				$(this).focus();
				return;
			}
			
			// 是否大于最多使用的积分
			if (parseFloat(point) > parseFloat($(".js-store_platform_point_max").html())) {
				layer_tips(1, '最多只能使用' + $(".js-store_platform_point_max").html() + "个" + credit_setting.platform_credit_name);
				$(this).val($(this).attr("old-value"));
				$(this).focus();
				return;
			}
			
			$(this).attr("old-value", $(this).val());
			
			$(".js-store_platform_point_use_money").html((parseFloat(point) / credit_setting.platform_credit_use_value - 0.0049).toFixed(2));
			$(".js-platform_point_money span").html((parseFloat(point) / credit_setting.platform_credit_use_value - 0.0049).toFixed(2));
			
			resetPrice();
		}
	});
	
	// 更改使用店铺用户平台积分
	$("input[name='user_platform_point']").live("blur", function () {
		if ($(this).val().length == 0) {
			$(".js-platform_point_money span").html("0.00");
			$(".js-platform_point_use_money").html('0');
		} else {
			var point = $(this).val();
			if(!/^\d+(\.\d+)?$/.test(point)){
				layer_tips(1, credit_setting.platform_credit_name + ",请输入合法的数字");
				$(this).val($(this).attr("old-value"));
				$(this).focus();
				return;
			}else if(parseFloat(point) < 0.01) {
				layer_tips(1, credit_setting.platform_credit_name + ',最小为 0.01');
				$(this).val($(this).attr("old-value"));
				$(this).focus();
				return;
			}
			
			// 是否大于最多使用的积分
			if (parseFloat(point) > parseFloat($(".js-user_platform_point_max").html())) {
				layer_tips(1, '最多只能使用' + $(".js-user_platform_point_max").html() + "个" + credit_setting.platform_credit_name);
				$(this).val($(this).attr("old-value"));
				$(this).focus();
				return;
			}
			
			$(this).attr("old-value", $(this).val());
			
			$(".js-user_platform_point_use_money").html((parseFloat(point) / credit_setting.platform_credit_use_value - 0.0049).toFixed(2));
			$(".js-platform_point_money span").html((parseFloat(point) / credit_setting.platform_credit_use_value - 0.0049).toFixed(2));
			
			resetPrice();
		}
	});
	
	// 提交订单
	$(".js-btn-save").live("click", function () {
		var data = {};
		if (uid == 0) {
			$("#phone").focus();
			$(".js-check_phone").show();
			layer_tips(1, "请选择用户");
			return;
		}
		
		data.uid = uid;
		
		var product = [];
		$(".js-product-list-selected tr").each(function (i) {
			if ($(this).hasClass("js-no-product")) {
				return;
			}
			product.push($(this).attr("data-product_id") + "_" + $(this).attr("data-sku_id") + "_" + $(this).attr("data-number") + "_" + $(this).attr("data-price"));
		});
		
		if (product.length == 0) {
			layer_tips(1, "请选择商品");
			return;
		}
		
		data.product_list = product;
		
		var logistics_type = $(".js-logistics-type-list").find(".orange").attr("data-type");
		data.logistics_type = logistics_type;
		if (logistics_type == "logistics") {
			data.address_id = $(".js-address-table").find("input:checked").val();
			if (data.address_id == "0") {
				layer_tips(1, "请选择收货地址");
				return;
			}
		} else if (logistics_type == "selffetch") {
			data.selffetch_id = $(".js-selffetch_list").find("input:checked").val();
			data.selffetch_name = $(".js-selffetch-info").find(".js-name").val();
			if (data.selffetch_name.length == 0) {
				layer_tips(1, "请填写收件人");
				$(".js-selffetch-info").find(".js-name").focus();
				return;
			}
			
			data.selffetch_tel = $(".js-selffetch-info").find(".js-tel").val();
			if (data.selffetch_tel.length == 0) {
				layer_tips(1, '请填写手机号码');
				$(".js-selffetch-info").find(".js-tel").focus();
				return;
			}
			
			var regMobile = /^\d{5,12}$/;//手机,简单判断
			if (!regMobile.test(data.selffetch_tel)) {
				layer_tips(1, "请正确填写手机号");
				$(".js-selffetch-info").find(".js-tel").focus();
				return;
			}
			
			data.selffetch_date = $(".js-selffetch-info").find(".js-date").val();
			if (data.selffetch_date.length == 0) {
				layer_tips(1, "请选择预约时间");
				$(".js-selffetch-info").find(".js-tel").focus();
				return;
			}
		} else if (logistics_type == "friend") {
			data.friend_province_id = $("#provinceId_friend").val();
			data.friend_city_id = $("#cityId_friend").val();
			data.friend_area_id = $("#areaId_friend").val();
			data.friend_jiedao = $(".js-friend-form").find(".js-jiedao").val();
			data.friend_name = $(".js-friend-form").find(".js-name").val();
			data.friend_tel = $(".js-friend-form").find(".js-tel").val();
			data.friend_date = $(".js-friend-form").find(".js-friend_date").val();
			
			if (data.friend_province_id.length == 0) {
				layer_tips(1, "请选择省份");
				$("#provinceId_friend").focus();
				return;
			}
			
			if (data.friend_city_id.length == 0) {
				layer_tips(1, "请选择城市");
				$("#cityId_friend").focus();
				return;
			}
			
			if (data.friend_area_id.length == 0) {
				layer_tips(1, "请选择地区");
				$("#areaId_friend").focus();
				return;
			}
			
			if (data.friend_jiedao.length == 0) {
				layer_tips(1, "请填写朋友所在街道");
				$(".js-friend-form").find(".js-jiedao").focus();
				return;
			}
			
			if (data.friend_jiedao.length > 120) {
				layer_tips(1, "朋友所在街道最多能填写120个字符");
				$(".js-friend-form").find(".js-jiedao").focus();
				return;
			}
			
			if (data.friend_name.length == 0) {
				layer_tips(1, "请填写朋友姓名");
				$(".js-friend-form").find(".js-name").focus();
				return;
			}
			
			if (data.friend_tel.length == 0) {
				layer_tips(1, "请填写朋友手机");
				$(".js-friend-form").find(".js-tel").focus();
				return;
			}
			
			var regMobile = /^\d{5,12}$/;//手机,简单判断
			
			if (!regMobile.test(data.friend_tel)) {
				layer_tips(1, "请正确填写朋友手机号");
				$(".js-friend-form").find(".js-tel").focus();
				return;
			}
		}
		
		if ($(".js-pay-type-list").find(".orange").css("display") == "none") {
			layer_tips(1, "请选择支付方式");
			return;
		}
		
		data.pay_type = $(".js-pay-type-list").find(".orange").attr("data-type");
		if (data.pay_type.length == 0 || typeof data.pay_type == "undefined") {
			layer_tips(1, "请选择支付方式");
			return;
		}
		
		data.coupon_id = $(".js-coupon-table").find("input:checked").val();
		data.session_key = session_key;
		
		if ($(".js-point-type-list a").eq(2).hasClass("orange")) {
			data.platform_point_type = 0;
			if ($("#point_1").prop("checked")) {
				data.point = $(".js-point-container").data("point");
				data.point_money = $(".js-point-container").data("point_money");
			}
			
			if ($("#point_2").prop("checked") && $("input[name='platform_point']").val().length > 0) {
				data.platform_point = $("input[name='platform_point']").val();
				data.platform_point_money = $(".js-platform_point_money span").html();
			}
		} else if ($(".js-point-type-list a").eq(0).hasClass("orange")) {
			data.platform_point_type = 1;
			if ($("#point_3").prop("checked") && $("input[name='store_platform_point']").val().length > 0) {
				data.platform_point = $("input[name='store_platform_point']").val();
				data.platform_point_money = $(".js-platform_point_money span").html();
			}
		} else if ($(".js-point-type-list a").eq(1).hasClass("orange")) {
			data.platform_point_type = 2;
			if ($("#point_4").prop("checked") && $("input[name='user_platform_point']").val().length > 0) {
				data.platform_point = $("input[name='user_platform_point']").val();
				data.platform_point_money = $(".js-platform_point_money span").html();
			}
		}
		
		var bak = $(".js-bak").val();
		data.bak = bak;
		
		$(".js-btn-save").attr("disabled", "disabled");
		$(".js-btn-save").val($(".js-btn-save").attr("data-loading-text"));
		$.post("", data, function (result) {
			if (result.err_code > 0) {
				layer_tips(1, result.err_msg);
				$(".js-btn-save").removeAttr("disabled");
				$(".js-btn-save").val("创建订单");
			} else {
				layer_tips(0, result.err_msg);
				location.href = result.err_dom;
				return;
				load_page('.app__content', load_url, {page : 'order_add'}, '', function () {
					load_widget_link_box();
				});
			}
		});
	});
})


function changeArea(province_id, city_id, area_id) {
	if (typeof province_id == "undefined") {
		province_id = "provinceId_m";
	}
	
	if (typeof city_id == "undefined") {
		city_id = "cityId_m";
	}
	
	if (typeof area_id == "undefined") {
		area_id = "areaId_m";
	}
	
	getProvinces(province_id, $('#' + province_id).attr('data-province'), '省份');
	getCitys(city_id, province_id, $('#' + city_id).attr('data-city'), '城市');
	getAreas(area_id, city_id,$('#' + area_id).attr('data-area'), '区县');
	$('#' + province_id).change(function(){
		if($(this).val() != ''){
			getCitys(city_id, province_id,'','城市');
		}else{
			$('#' + city_id).html('<option value="">城市</option>');
		}
		$('#' + area_id).html('<option value="">区县</option>');
	});
	$('#' + city_id).change(function(){
		if($(this).val() != ''){
			getAreas(area_id, city_id, '', '区县');
		}else{
			$('#' + area_id).html('<option value="">区县</option>');
		}
	});
}

// 产品的金额
function productMoney() {
	var money = 0;
	var data = {};
	var product = [];
	$(".js-product-list-selected tr").each(function (i) {
		if ($(this).hasClass("js-no-product")) {
			return;
		}
		money += parseFloat($(this).attr("data-price")) * parseFloat($(this).attr("data-number"));
		product.push($(this).attr("data-product_id") + "_" + $(this).attr("data-sku_id") + "_" + $(this).attr("data-number") + "_" + $(this).attr("data-price"));
	});
	
	$("#js-sub_total").html(money);
	$("#js-total").html(money);
	
	if (product.length > 0 && uid) {
		data.product_list = product;
		data.uid = uid;
		
		getReward(data);
		getPostage(data);
	} else {
		$(".js-point-container").hide();
		$(".js-reward-container").hide();
		$(".js-coupon-container").hide();
		
		$("#js-reward").html("0.00");
		$("#js-user_coupon").html("0.00");
		$("#js-discount_money").html("0.00");
		$(".js-platform_point_money span").html("0.00");
	}
	
	$(".js-change-number").find("span").fadeOut(3000);
	
}

// 计算优惠折扣等内容
function getReward(data) {
	data.session_key = session_key;
	$.post(order_reward_url, data, function (result) {
		if (result.err_code == 0) {
			if (result.err_msg.coupon_list.length > 0) {
				var coupon_list = result.err_msg.coupon_list;
				var html = '<tr><td style="line-height: 24px; padding-left: 15px;"><input type="radio" name="user_coupon_id" value="0" data-money="0" />不使用优惠券</td></tr>';
				var j = 0;
				var checked = "";
				var coupon_money = 0;
				for (var i in coupon_list) {
					checked = "";
					if (j == 0) {
						checked = 'checked="checked"';
						coupon_money = coupon_list[i].money;
					}
					html += '<tr>';
					html += '	<td style="line-height: 24px; padding-left: 15px;">';
					html += '		<input type="radio" name="user_coupon_id" value="' + coupon_list[i].id + '" ' + checked + ' data-money="' + coupon_list[i].money + '" />' + coupon_list[i].cname + ' 优惠券金额：￥' + coupon_list[i].money;
					html += '	</td>';
					html += '</tr>';
					j++;
				}
				
				$("#js-user_coupon").html(coupon_money);
				$(".js-coupon-table").html(html);
				$(".js-coupon-table").data("has_coupon", 1);
				$(".js-coupon-container").show();
			} else {
				$(".js-reward-table").html("");
				$("#js-user_coupon").html("0.00");
				$(".js-coupon-table").data("has_coupon", 0);
				$(".js-coupon-container").hide();
			}
			
			if (result.err_msg.reward_list.length > 0) {
				var reward_list = result.err_msg.reward_list;
				var html = "";
				for (var i in reward_list) {
					html += '<tr>';
					html += '	<td style="line-height: 24px; padding-left: 15px;">';
					html += '		' + reward_list[i];
					html += '	</td>';
					html += '</tr>';
				}
				
				$("#js-reward").html(result.err_msg.reward_money);
				$(".js-reward-table").html(html);
				$(".js-reward-table").data("has_reward", 1);
				$(".js-reward-container").show();
			} else {
				$("#js-reward").html("0.00");
				$(".js-reward-table").html("");
				$(".js-reward-table").data("has_reward", 0);
				$(".js-reward-container").hide();
			}
			
			// 每个商品单独计算折扣
			var discount_money = 0.00;
			var product_discount = result.err_msg.product_discount;
			$(".js-product-list-selected tr").each(function () {
				var product_price = parseFloat($(this).data("price"));
				var product_number = parseFloat($(this).attr("data-number"));
				var product_id = $(this).data("product_id");
				
				var discount = parseFloat(result.err_msg.discount);
				if (typeof product_discount[product_id] != "undefined") {
					discount = parseFloat(product_discount[product_id]);
				}
				
				if (discount < 10.0) {
					discount_money += product_price * product_number * (10.0 - discount) / 10;
				}
			})
			
			if (discount_money > 0) {
				$("#js-discount_money").html(discount_money.toFixed(2));
			}
			
			postage_free = result.err_msg.postage_free;
			
			if (postage_free) {
				$("#js-postage").html("0.00");
			}
			
			max_platform_point = result.err_msg.max_platform_point;
			
			resetPrice();
		} else {
			$("#js-reward").html("0.00");
			$("#js-user_coupon").html("0.00");
			$("#js-discount_money").html("0.00");
		}
	})
}

// 统一获取产品列表
function getProductData() {
	var data = {};
	var product = [];
	$(".js-product-list-selected tr").each(function (i) {
		if ($(this).hasClass("js-no-product")) {
			return;
		}
		product.push($(this).attr("data-product_id") + "_" + $(this).attr("data-sku_id") + "_" + $(this).attr("data-number"));
	});
	
	if (product.length > 0 && uid) {
		data.product_list = product;
		data.uid = uid;
		
		return data;
	}
	return false;
}

// 获取邮费
function getPostage(data) {
	var type = $(".js-logistics-type-list").find(".orange").data("type");
	var address_id;
	var province_id;
	if (type == "logistics") {
		address_id = $(".js-address-table").find("input:checked").val();
		if (address_id == "0") {
			return;
		}
	} else if (type == "friend") {
		province_id = $("#provinceId_friend").val();
		if (province_id.length == 0) {
			return;
		}
	} else {
		return;
	}
	
	data.address_id = address_id;
	data.province_id = province_id;
	data.session_key = session_key;
	
	$.post(order_postage_url, data, function (result) {
		if (result.err_code > 0) {
			layer_tips(1, "不支持此收货地址");
			$(".js-btn-save").attr("disabled", "disabled");
			
			if (type == "logistics") {
				logistics_postage.money = "0.00";
				logistics_postage.error = true;
				logistics_postage.reload = false;
			} else {
				friend_postage.money = "0.00";
				friend_postage.error = true;
				friend_postage.reload = false;
			}
		} else {
			if (typeof result.err_msg != "undefined") {
				$("#js-postage").html(result.err_msg);
			} else {
				$("#js-postage").html("0.00");
			}
			
			point_init = true;
			resetPrice();
			$(".js-btn-save").removeAttr("disabled");
			
			if (type == "logistics") {
				logistics_postage.money = result.err_msg;
				logistics_postage.error = false;
				logistics_postage.reload = false;
			} else {
				friend_postage.money = result.err_msg;
				friend_postage.error = false;
				friend_postage.reload = false;
			}
		}
	})
}

// 计算价格
function resetPrice() {
	setPoint();
	var postage1 = parseFloat($("#js-postage").html());
	var sub_total = parseFloat($("#js-sub_total").html());
	var reward = 0;
	var user_coupon = 0;
	var float_amount = 0;
	var discount_money = 0;
	var point_money = 0;
	var platform_money = 0;
	
	if ($(".js-point-type-list a").eq(2).hasClass("orange")) {
		$("#js-reward_span").show();
		$("#js-user_coupon_span").show();
		$("#js-discount_money_span").show();
		$("#js-reward_span").show();
		$("#js-point_money_span").show();
		
		if ($("#js-reward").length > 0) {
			reward = parseFloat($("#js-reward").html());
		}

		if ($("#js-user_coupon").length > 0) {
			user_coupon = parseFloat($("#js-user_coupon").html());
		}

		if ($("#js-float_amount").length > 0) {
			float_amount = parseFloat($("#js-float_amount").html());
		}
		
		if ($("#js-discount_money").length > 0) {
			discount_money = parseFloat($("#js-discount_money").html());
		}
		
		if ($("#js-point_money").length > 0) {
			point_money = parseFloat($("#js-point_money").html());
		}
	} else if ($(".js-point-type-list a").eq(0).hasClass("orange")) {
		$(".js-platform_point_container").hide();
		$("#js-reward_span").hide();
		$("#js-user_coupon_span").hide();
		$("#js-discount_money_span").hide();
		$("#js-reward_span").hide();
		$("#js-point_money_span").hide();
		$(".js-store_point_container").hide();
		$(".js-store_platform_point_container").show();
	} else if ($(".js-point-type-list a").eq(1).hasClass("orange")) {
		$(".js-platform_point_container").hide();
		$("#js-reward_span").hide();
		$("#js-user_coupon_span").hide();
		$("#js-discount_money_span").hide();
		$("#js-reward_span").hide();
		$("#js-point_money_span").hide();
		$(".js-store_point_container").hide();
		$(".js-store_platform_point_container").hide();
		$(".js-user_platform_point_container").show();
	}
	
	if ($(".js-platform_point_money span").length > 0) {
		if ($(".js-point-type-list a").size() == 0 || $(".js-point-type-list a").eq(2).hasClass("orange")) {
			if ($("#point_2").prop("checked") && parseFloat($(".js-platform_point_use_money").html()) > 0) {
				$(".js-platform_point_money span").html($(".js-platform_point_use_money").html())
				$(".js-platform_point_money").show();
			} else {
				$(".js-platform_point_money span").html(0)
				$(".js-platform_point_money").hide();
			}
		} else if ($(".js-point-type-list a").eq(0).hasClass("orange")) {
			if ($("#point_3").prop("checked") && parseFloat($(".js-store_platform_point_use_money").html()) > 0) {
				$(".js-platform_point_money span").html($(".js-store_platform_point_use_money").html())
				$(".js-platform_point_money").show();
			} else {
				$(".js-platform_point_money span").html(0)
				$(".js-platform_point_money").hide();
			}
		} else if ($(".js-point-type-list a").eq(1).hasClass("orange")) {
			if ($("#point_4").prop("checked") && parseFloat($(".js-user_platform_point_use_money").html()) > 0) {
				$(".js-platform_point_money span").html($(".js-user_platform_point_use_money").html())
				$(".js-platform_point_money").show();
			} else {
				$(".js-platform_point_money span").html(0)
				$(".js-platform_point_money").hide();
			}
		}
		
		platform_money = parseFloat($(".js-platform_point_money span").html());
	}
	
	var money = sub_total + postage1 - reward - user_coupon - float_amount - discount_money - point_money - platform_money;
	if (money < 0) {
		money = 0;
	}
	
	$("#js-total").html(money.toFixed(2));
}

function load_widget_link_box() {
	widget_link_box($(".js-select-order"), "goods_by_sku&uid=" + uid, function (result) {
		try {
			var html = "";
			var is_html = false;
			for (var i in result) {
				is_html = true;
				var price = parseFloat(result[i].price) * 100;
				var tr_obj = $('#product_' + result[i].product_id + '_' + price + '_'  + result[i].sku_id);
				if (tr_obj.size() > 0) {
					if (parseInt(tr_obj.data("quantity")) < parseInt(tr_obj.attr("data-number")) + parseInt(result[i].number)) {
						tr_obj.find(".js-product-number").html(parseInt(tr_obj.attr("data-number")) + "<span style='padding-left: 5px; color: red; font-weight: bold; float: right;position: absolute;right: 20px;'>库存不足</span>");
					} else {
						tr_obj.find(".js-product-number").html(parseInt(tr_obj.attr("data-number")) + parseInt(result[i].number) + "<span style='padding-left: 5px; color: red; font-weight: bold; float: right;position: absolute;right: 45px;'>+" + result[i].number + "</span>");
						tr_obj.attr("data-number", parseInt(tr_obj.attr("data-number")) + parseInt(result[i].number));
					}
					tr_obj.find(".js-product-number").addClass("js-change-number");
					continue;
				}
				
				var url = "wap/good.php?id=" + result[i].product_id;
				html += '<tr id="product_' + result[i].product_id + '_' + price + '_'  + result[i].sku_id + '" data-price="' + result[i].price + '" data-number="' + result[i].number + '" data-product_id="' + result[i].product_id + '" data-sku_id="' + result[i].sku_id + '" data-quantity="' + result[i].quantity + '">';
				html += '	<td>';
				html += '		<a href="' + url + '" target="_blank"><img src="' + result[i].image + '" style="max-width:80px; max-height:80px; float:left; padding-right:5px; border:0px;" /></a>';
				html += '		<a href="' + url + '" target="_blank">' + result[i].title + '</a>';
				if (result[i].sku_data.length > 0) {
					html += '		<br />' + result[i].sku_data;
				}
				html += '	</td>';
				html += '	<td class="text-center cell-20 js-product-price">' + result[i].price + '</td>';
				html += '	<td class="text-center cell-20 js-product-number" style="text-decoration:blink; position: relative;">' + result[i].number + '</td>';
				html += '	<td class="text-center cell-20">';
				html += '		<a href="javascript:;" class="btn btn-small js-product_delete" style="padding:4px 7px;">删除</a>';
				html += '	</td>';
				html += '</tr>';
			}
			
			if (is_html) {
				$(".js-product-list-selected").find(".js-no-product").remove();
				$(".js-product-list-selected").append(html);
				
				// 支付方式、配送方式显示
				$(".js-logistics-container").show();
				$(".js-pay-container").show();
				$(".js-reward-container").show();
				$(".js-money-container").show();
				$(".js-submit-container").show();
				
				// 运费需要重新计算
				logistics_postage.reload = true;
				friend_postage.reload = true;
			}
			point_init = true;
			productMoney();
		} catch(e) {
			
		}
	});
	
	widget_link_box($(".js-scan-select-order"), "goods_by_scan&uid=" + uid, function (result) {
		try {
			var html = "";
			var is_html = false;
			for (var i in result) {
				is_html = true;
				var price = parseFloat(result[i].price) * 100;
				var tr_obj = $('#product_' + result[i].product_id + '_' + price + '_'  + result[i].sku_id);
				if (tr_obj.size() > 0) {
					if (parseInt(tr_obj.data("quantity")) < parseInt(tr_obj.attr("data-number")) + parseInt(result[i].number)) {
						tr_obj.find(".js-product-number").html(parseInt(tr_obj.attr("data-number")) + "<span style='padding-left: 5px; color: red; font-weight: bold; float: right;position: absolute;right: 20px;'>库存不足</span>");
					} else {
						tr_obj.find(".js-product-number").html(parseInt(tr_obj.attr("data-number")) + parseInt(result[i].number) + "<span style='padding-left: 5px; color: red; font-weight: bold; float: right;position: absolute;right: 45px;'>+" + result[i].number + "</span>");
						tr_obj.attr("data-number", parseInt(tr_obj.attr("data-number")) + parseInt(result[i].number));
					}
					tr_obj.find(".js-product-number").addClass("js-change-number");
					continue;
				}
				
				var url = "wap/good.php?id=" + result[i].product_id;
				html += '<tr id="product_' + result[i].product_id + '_' + price + '_' + result[i].sku_id + '" data-price="' + result[i].price + '" data-number="' + result[i].number + '" data-product_id="' + result[i].product_id + '" data-sku_id="' + result[i].sku_id + '" data-quantity="' + result[i].quantity + '">';
				html += '	<td>';
				html += '		<a href="' + url + '" target="_blank"><img src="' + result[i].image + '" style="max-width:80px; max-height:80px; float:left; padding-right:5px; border:0px;" /></a>';
				html += '		<a href="' + url + '" target="_blank">' + result[i].title + '</a>';
				if (result[i].sku_data.length > 0) {
					html += '		<br />' + result[i].sku_data;
				}
				html += '	</td>';
				html += '	<td class="text-center cell-20 js-product-price">' + result[i].price + '</td>';
				html += '	<td class="text-center cell-20 js-product-number" style="text-decoration:blink; position: relative;">' + result[i].number + '</td>';
				html += '	<td class="text-center cell-20">';
				html += '		<a href="javascript:;" class="btn btn-small js-product_delete" style="padding:4px 7px;">删除</a>';
				html += '	</td>';
				html += '</tr>';
			}
			
			if (is_html) {
				$(".js-product-list-selected").find(".js-no-product").remove();
				$(".js-product-list-selected").append(html);
				
				// 支付方式、配送方式显示
				$(".js-logistics-container").show();
				$(".js-pay-container").show();
				$(".js-reward-container").show();
				$(".js-money-container").show();
				$(".js-submit-container").show();
				
				// 运费需要重新计算
				logistics_postage.reload = true;
				friend_postage.reload = true;
			}
			point_init = true;
			productMoney();
		} catch(e) {
			
		}
	});
}

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

function setPoint() {
	var postage_money = parseFloat($("#js-postage").html());
	var reward_money = parseFloat($("#js-reward").html());
	var user_coupon_money = parseFloat($("#js-user_coupon").html());
	var discount_money = parseFloat($("#js-discount_money").html());
	
	
	var supplier_money = parseFloat($("#js-sub_total").html()) + postage_money - reward_money + user_coupon_money - discount_money;
	
	if (is_point && supplier_money > 0 && $("#point_1").prop("checked")) {
		var point_money = parseFloat(points_data.point) / parseFloat(points_data.price);
		var point = points_data.point;
		
		if (point_money > supplier_money) {
			point_money = supplier_money;
			point = Math.ceil(point_money * parseFloat(points_data.price));
		}
		
		if (points_data.is_percent == "1" && supplier_money * parseFloat(points_data.percent) / 100 < point_money) {
			point_money = (supplier_money * parseFloat(points_data.percent) / 100 - 0.005).toFixed(2);
			point = Math.ceil(point_money * parseFloat(points_data.price));
		}
		
		if (points_data.is_limit == "1" && point_money > parseFloat(points_data.offset_limit)) {
			point_money = parseFloat(points_data.offset_limit).toFixed(2);
			point = Math.ceil(point_money * parseFloat(points_data.price));
		}
		
		if ($("#point_1").size() > 0) {
			$(".js-point_content").html("您可以使用" + point + "积分，抵" + point_money + "元");
			$("#js-point_money").html(point_money);
			
			$("#point_1").val(point_money);
			$(".js-point-container").data("point", point);
			$(".js-point-container").data("point_money", point_money);
			if ($(".js-point-type-list a").size() == 0 || $(".js-point-type-list a").eq(2).hasClass("orange")) {
				$(".js-point-container").show();
				$(".js-store_point_container").show();
			}
		}
	} else {
		$("#js-point_money").html("0.00");
	}
	
	// 用户有积分时，显示积分兑换
	$(".js-point-container").show();
	$(".js-platform_point_container").show();
	
	if (is_platform_point && point_init) {
		platformPointInit();
		point_init = false;
	}
}

var point_init = true;
//平台积分使用
function platformPointInit() {
	$(".js-platform_point_container").hide();
	return;
	// 积分没有价值
	if (credit_setting.platform_credit_use_value == '0') {
		$(".js-platform_point_max").html(0);
		$("input[name='platform_point']").val(0);
		$("input[name='platform_point']").prop("disabled", true);
		$(".js-platform_point_money").html(0);
		return;
	}
	
	// 店铺的平台积分
	platformStorePointInit();
	// 店铺用户的平台积分
	platformUserPointInit();
	
	var user_point_balance = parseFloat($(".js-user_point_balance").html());
	if (user_point_balance <= 0 && 0) {
		$(".js-platform_point_max").html(0);
		$("input[name='platform_point']").val(0);
		$("input[name='platform_point']").prop("disabled", true);
		$(".js-platform_point_money").html(0);
		return;
	}
	
	var postage1 = parseFloat($("#js-postage").html());
	var sub_total = parseFloat($("#js-sub_total").html());
	var reward = 0;
	var user_coupon = 0;
	var float_amount = 0;
	var discount_money = 0;
	var point_money_t = 0;
	
	if ($("#js-reward").length > 0) {
		reward = parseFloat($("#js-reward").html());
	}

	if ($("#js-user_coupon").length > 0) {
		user_coupon = parseFloat($("#js-user_coupon").html());
	}

	if ($("#js-float_amount").length > 0) {
		float_amount = parseFloat($("#js-float_amount").html());
	}
	
	if ($("#js-discount_money").length > 0) {
		discount_money = parseFloat($("#js-discount_money").html())
	}
	
	if ($("#js-point_money").length > 0) {
		point_money_t = parseFloat($("#js-point_money").html());
	}
	
	var money = sub_total + postage1 - reward - user_coupon - float_amount - discount_money - point_money_t;
	if (money < 0) {
		$(".js-platform_point_max").html(0);
		$("input[name='platform_point']").val(0);
		$("input[name='platform_point']").prop("disabled", true);
		$(".js-platform_point_money").html(0);
		return;
	}
	
	// 现金比例
	var offline_trade_money = parseFloat(credit_setting.offline_trade_money);
	if (offline_trade_money > 0) {
		money = money - money * offline_trade_money / 100;
	}
	
	// 最多可使用平台积分抵扣的钱
	if (money <= 0) {
		$(".js-platform_point_max").html(0);
		$("input[name='platform_point']").val(0);
		$("input[name='platform_point']").prop("disabled", true);
		$(".js-platform_point_money span").html(0);
		return;
	}
	
	// 所需要的积分
	var platform_point = money * parseFloat(credit_setting.platform_credit_use_value);
	if (user_point_balance < platform_point) {
		platform_point = user_point_balance;
	}
	
	if (max_platform_point + postage1 * parseFloat(credit_setting.platform_credit_use_value) < platform_point) {
		platform_point = max_platform_point + postage1 * parseFloat(credit_setting.platform_credit_use_value);
	}
	
	if (platform_point > 0) {
		platform_point = platform_point - 0.0049;
	}
	
	$(".js-platform_point_max").html(platform_point.toFixed(2));
	$("input[name='platform_point']").val(platform_point.toFixed(2));
	$("input[name='platform_point']").prop("disabled", false);
	$("input[name='platform_point']").attr("old-value", platform_point.toFixed(2));
	$(".js-platform_point_use_money").html((platform_point / credit_setting.platform_credit_use_value).toFixed(2));
	$(".js-platform_point_money span").html((platform_point / credit_setting.platform_credit_use_value).toFixed(2));
	$(".js-platform_point_money").show();
}

// 店铺平台积分逻辑处理
function platformStorePointInit() {
	// 积分没有价值
	if (credit_setting.platform_credit_use_value == '0') {
		$(".js-platform_point_max").html(0);
		$("input[name='platform_point']").val(0);
		$("input[name='platform_point']").prop("disabled", true);
		$(".js-platform_point_money").html(0);
		return;
	}
	
	var store_point_balance = parseFloat($(".js-store_point_balance").html());
	if (store_point_balance <= 0) {
		$(".js-store_platform_point_max").html(0);
		$("input[name='store_platform_point']").val(0);
		$("input[name='store_platform_point']").prop("disabled", true);
		$(".js-store_platform_point_use_money").html(0);
		return;
	}
	
	var postage1 = parseFloat($("#js-postage").html());
	var sub_total = parseFloat($("#js-sub_total").html());
	
	var money = sub_total + postage1;
	if (money < 0) {
		$(".js-store_platform_point_max").html(0);
		$("input[name='store_platform_point']").val(0);
		$("input[name='store_platform_point']").prop("disabled", true);
		$(".js-store_platform_point_use_money").html(0);
		return;
	}
	
	// 现金比例
	var offline_trade_money = parseFloat(credit_setting.offline_trade_money);
	if (offline_trade_money > 0) {
		money = money - money * offline_trade_money / 100;
	}
	
	// 最多可使用平台积分抵扣的钱
	if (money <= 0) {
		$(".js-store_platform_point_max").html(0);
		$("input[name='store_platform_point']").val(0);
		$("input[name='store_platform_point']").prop("disabled", true);
		$(".js-store_platform_point_use_money").html(0);
		return;
	}
	
	// 所需要的积分
	var platform_point = money * parseFloat(credit_setting.platform_credit_use_value);
	if (store_point_balance < platform_point) {
		platform_point = store_point_balance;
	}
	
	if (max_platform_point + postage1 * parseFloat(credit_setting.platform_credit_use_value) < platform_point) {
		platform_point = max_platform_point + postage1 * parseFloat(credit_setting.platform_credit_use_value);
	}
	
	if (platform_point <= 0) {
		$(".js-store_platform_point_max").html(0);
		$("input[name='store_platform_point']").val(0);
		$("input[name='store_platform_point']").prop("disabled", true);
		$(".js-store_platform_point_use_money").html(0);
		return;
	}
	
	platform_point = platform_point - 0.0049;
	
	$(".js-store_platform_point_max").html(platform_point.toFixed(2));
	$("input[name='store_platform_point']").val(platform_point.toFixed(2));
	$("input[name='store_platform_point']").prop("disabled", false);
	$("input[name='store_platform_point']").attr("old-value", platform_point.toFixed(2));
	$(".js-store_platform_point_use_money").html((platform_point / credit_setting.platform_credit_use_value).toFixed(2));
}

//店铺平台积分逻辑处理
function platformUserPointInit() {
	// 积分没有价值
	if (credit_setting.platform_credit_use_value == '0') {
		$(".js-user_platform_point_max").html(0);
		$("input[name='user_platform_point']").val(0);
		$("input[name='user_platform_point']").prop("disabled", true);
		$(".js-user_platform_point_use_money").html(0);
		return;
	}
	
	var store_point_balance = parseFloat($(".js-user_store_point_balance").html());
	if (store_point_balance <= 0) {
		$(".js-user_platform_point_max").html(0);
		$("input[name='user_platform_point']").val(0);
		$("input[name='user_platform_point']").prop("disabled", true);
		$(".js-user_platform_point_use_money").html(0);
		return;
	}
	
	var postage1 = parseFloat($("#js-postage").html());
	var sub_total = parseFloat($("#js-sub_total").html());
	
	var money = sub_total + postage1;
	if (money < 0) {
		$(".js-user_platform_point_max").html(0);
		$("input[name='user_platform_point']").val(0);
		$("input[name='user_platform_point']").prop("disabled", true);
		$(".js-user_platform_point_use_money").html(0);
		return;
	}
	
	// 现金比例
	var offline_trade_money = parseFloat(credit_setting.offline_trade_money);
	if (offline_trade_money > 0) {
		money = money - money * offline_trade_money / 100;
	}
	
	// 最多可使用平台积分抵扣的钱
	if (money <= 0) {
		$(".js-user_platform_point_max").html(0);
		$("input[name='user_platform_point']").val(0);
		$("input[name='user_platform_point']").prop("disabled", true);
		$(".js-user_platform_point_use_money").html(0);
		return;
	}
	
	// 所需要的积分
	var platform_point = money * parseFloat(credit_setting.platform_credit_use_value);
	if (store_point_balance < platform_point) {
		platform_point = store_point_balance;
	}
	
	if (max_platform_point + postage1 * parseFloat(credit_setting.platform_credit_use_value) < platform_point) {
		platform_point = max_platform_point + postage1 * parseFloat(credit_setting.platform_credit_use_value);
	}
	
	if (platform_point <= 0) {
		$(".js-user_platform_point_max").html(0);
		$("input[name='user_platform_point']").val(0);
		$("input[name='user_platform_point']").prop("disabled", true);
		$(".js-user_platform_point_use_money").html(0);
		return;
	}
	
	platform_point = platform_point - 0.0049;
	
	$(".js-user_platform_point_max").html(platform_point.toFixed(2));
	$("input[name='user_platform_point']").val(platform_point.toFixed(2));
	$("input[name='user_platform_point']").prop("disabled", false);
	$("input[name='user_platform_point']").attr("old-value", platform_point.toFixed(2));
	$(".js-user_platform_point_use_money").html((platform_point / credit_setting.platform_credit_use_value).toFixed(2));
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
			
			load_widget_link_box();
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