var addressList={};//,postage=0.00;
var l_express = true;
var l_friend = true;
var selffetch_obj = {};
var friend_obj = {};
var is_app = false;
var app_type = '';
var data_app_json = "";
var app_result = false;
var layer_load;
var point_money = 0.00;
var supplier_postage_money = 0.00;
var supplier_reward_money = 0.00;
var supplier_coupon_money = 0.00;

$(function(){
	try {
		supplier_reward_money = parseFloat($(".js-point").data("supplier_reward_money"));
		supplier_coupon_money = parseFloat($(".js-point").data("supplier_coupon_money"));
	} catch (e) {
		
	}
	
	resetPrice();
	
	// 减少
	$(".js-reduce").click(function () {
		var type = $(this).data("type");
		if (type == "send_other_number") {
			if (parseInt($(".js-send_other_number").val()) == 1) {
				return;
			}
			$(".js-send_other_number").val(parseInt($(".js-send_other_number").val()) - 1);
		} else {
			if (parseInt($(".js-send_other_per_number").val()) == 1) {
				return;
			}
			$(".js-send_other_per_number").val(parseInt($(".js-send_other_per_number").val()) - 1);
		}
		
		layer_load = layer.open({type: 2, shadeClose: false});
		changeProduct(type);
	});
	
	// 增加
	$(".js-plus").click(function () {
		var type = $(this).data("type");
		if (type == "send_other_number") {
			$(".js-send_other_number").val(parseInt($(".js-send_other_number").val()) + 1);
		} else {
			$(".js-send_other_per_number").val(parseInt($(".js-send_other_per_number").val()) + 1);
		}
		
		layer_load = layer.open({type: 2, shadeClose: false});
		changeProduct(type);
	});
	
	// 减少时间
	$(".js-hour-reduce").click(function () {
		if (parseInt($(".js-send_other_hour").val()) == 1) {
			return;
		}
		
		$(".js-send_other_hour").val(parseInt($(".js-send_other_hour").val()) - 1);
	});
	
	// 增加时间
	$(".js-hour-plus").click(function () {
		$(".js-send_other_hour").val(parseInt($(".js-send_other_hour").val()) + 1);
	});
	
	var changeProduct = function (type) {
		var send_other_number = $(".js-send_other_number").val();
		var send_other_per_number = $(".js-send_other_per_number").val();
		
		$.post("./order_ajax.php?action=goods_change", {order_id : orderNo, send_other_number : send_other_number, send_other_per_number : send_other_per_number}, function (result) {
			layer.close(layer_load);
			if (result.err_code == "0") {
				$(".js-product-number").html(parseInt($(".js-send_other_number").val()) * parseInt($(".js-send_other_per_number").val()));
				$("#js-sub_total").html(result.err_msg.total_money.toFixed(2));
				$("#js-discount_money").html(result.err_msg.discount_money.toFixed(2));
				
				resetPrice();
				if (type == "send_other_number") {
					getPostage();
				}
			} else {
				layer.open({
					content: result.err_msg,
					time: 2
				});
			}
		});
	};

	/*查看留言*/
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


	/*收货地址*/
	var editAdress = function(callbackObj, address_id){
		var addAdressDom = $('<div id="addAdress" class="modal order-modal active"><div><form class="js-address-fm address-ui address-fm"><div class="block" style="margin-bottom:10px;"><div class="block-item"><label class="form-row form-text-row"><em class="form-text-label">收货人</em><span class="input-wrapper"><input type="text" name="user_name" class="form-text-input" value="" placeholder="名字"></span></label></div><div class="block-item"><label class="form-row form-text-row"><em class="form-text-label">联系电话</em><span class="input-wrapper"><input type="tel" name="tel" class="form-text-input" value="" placeholder="手机或固话"></span></label></div><div class="block-item"><div class="form-row form-text-row"><em class="form-text-label">选择地区</em><div class="input-wrapper input-region js-area-select"><span><select id="province" name="province" class="address-province"></select></span><span><select id="city" name="city" class="address-city"><option>城市</option></select></span><span><select id="county" name="county" class="address-county"><option>区县</option></select></span></div></div></div><div class="block-item"><label class="form-row form-text-row"><em class="form-text-label">详细地址</em><span class="input-wrapper"><input type="text" name="address" class="form-text-input" value="" placeholder="街道门牌信息"></span></label></div><div class="block-item"><label class="form-row form-text-row"><em class="form-text-label">邮政编码</em><span class="input-wrapper"><input type="tel" maxlength="6" name="zipcode" class="form-text-input" value="" placeholder="邮政编码"></span></label></div></div><div><div class="action-container"><a class="js-address-save btn btn-block btn-blue">保存</a><a class="js-address-cancel btn btn-block">取消</a></div></div></form></div></div>');
		$('body').append(addAdressDom);
		getProvinces('province','','省份');
		addAdressDom.find('#province').change(function(){
			if($(this).val() != ''){
				getCitys('city','province','','城市');
			}else{
				$('#city').html('<option>城市</option>');
			}
			$('#county').html('<option>区县</option>');
		});
		addAdressDom.find('#city').change(function(){
			if($(this).val() != ''){
				getAreas('county','city','','区县');
			}else{
				$('#county').html('<option>区县</option>');
			}
		});
		addAdressDom.find('.js-address-cancel').click(function(){
			if(confirm('确定要放弃此次编辑吗？')){
				addAdressDom.removeClass('active').remove();
			}
		});
		addAdressDom.find('.js-address-save').click(function(){
			if($(this).attr('disabled')){
				motify.log('提交中,请稍等...');
				return false;
			}
			//收货人
			var nameDom = addAdressDom.find('input[name="user_name"]');
			var name = $.trim(nameDom.val());
			if(name.length == 0){
				motify.log('请填写名字');
				nameDom.focus();
				return false;
			}
			//联系电话
			var telDom = addAdressDom.find('input[name="tel"]');
			var tel = $.trim(telDom.val());
			if(tel.length == 0){
				motify.log('请填写联系电话');
				telDom.focus();
				return false;
			}else if(!/^0[0-9\-]{10,13}$/.test(tel) && !/^((\+86)|(86))?(1)\d{10}$/.test(tel)){
				motify.log('请填写正确的<br />手机号码或电话号码');
				telDom.focus();
				return false;
			}
			//地区
			var province = parseInt(addAdressDom.find('select[name="province"]').val());
			var city = parseInt(addAdressDom.find('select[name="city"]').val());
			var area = parseInt(addAdressDom.find('select[name="county"]').val());
			if(isNaN(province) || isNaN(city) || isNaN(area)){
				motify.log('请选择地区');
				return false;
			}
			//详细地址
			var addressDom = addAdressDom.find('input[name="address"]');
			var address = $.trim(addressDom.val());
			if(address.length == 0){
				motify.log('请填写详细地址');
				addressDom.focus();
				return false;
			}
			//邮政编码
			var zipcodeDom = addAdressDom.find('input[name="zipcode"]');
			var zipcode = $.trim(zipcodeDom.val());
			if(zipcode.length > 0 && !/^\d{6}$/.test(zipcode)){
				motify.log('邮政编码格式不正确');
				zipcodeDom.focus();
				return false;
			}
			var nowDom = $(this);
			nowDom.html('保存中...').attr('disabled',true);
			var post_data = {name:name,tel:tel,province:province,city:city,area:area,address:address,zipcode:zipcode};
			if(address_id){
				var post_url = 'address.php?action=edit';
				post_data.address_id = address_id;
			}else{
				var post_url = 'address.php?action=add';
			}
			$.post(post_url,post_data,function(result){
				if(result.err_code){
					motify.log(result.err_msg);
				}else{
					var data = result.err_msg;
					var area_text = '';
					if (__alldiv[area][0] != '市辖区' && __alldiv[area][0] != '县') {
						area_text = __alldiv[area][0];
					}
					$('.js-logistics-content').html('<div><div class="block block-form block-border-top-none block-border-bottom-none"><div class="js-order-address express-panel" style="padding-left:0;"><div class="opt-wrapper"><a href="javascript:;" class="btn btn-xxsmall btn-grayeee butn-edit-address js-edit-address">修改</a></div><ul><li><span>'+data.name+'</span>, '+data.tel+'</li><li>'+__alldiv[province][0]+' '+__alldiv[city][0]+' '+area_text+' </li><li>'+data.address+'</li></ul></div></div><div class="js-logistics-tips logistics-tips font-size-12 c-orange hide">很抱歉，该地区暂不支持配送。</div></div>');
					$('#address_id').val(data.address_id);
					addAdressDom.removeClass('active').remove();
					getPostage();
					refreshAdress();
				}
			});
		});
		if(callbackObj) callbackObj();
	}
	$('.js-order-address > .js-edit-address').live('click',function(){
		editAdress();
	});
	
	$(".js-change-address").live("click", function () {
		var address_list_html = '<div class="modal order-modal active"><div class="js-scene-address-list "><div class="address-ui address-list"><div class="block"><div class="js-address-container address-container">';
		for(var i in commonweal_address_list){
			var commonweal_address = commonweal_address_list[i];
			address_list_html += '<div class="block block-order">';
			address_list_html += '	<div class="store-header header">';
			address_list_html += '		<span>收货人姓名：' + commonweal_address.name + '</span>&nbsp;&nbsp;<button type="button" class="js-address-item btn btn-green" data-id="' + i + '">选择此公益地址</button>';
			address_list_html += '	</div>';
			address_list_html += '	<hr class="margin-0 left-10"/>';
			address_list_html += '	<div class="name-card name-card-3col name-card-store clearfix">';
			address_list_html += '		<a href="tel:' + commonweal_address.tel + '"><div class="phone"></div></a>';
			address_list_html += '			<h3>' + commonweal_address.province_txt + commonweal_address.city_txt + commonweal_address.area_txt + commonweal_address.address + '</h3>';
			address_list_html += '	</div>';
			address_list_html += '</div>';
		}
		address_list_html += '</div></div><div class="action-container"><button type="button" class="js-cancel btn btn-block">返回</button></div></div></div>';
		var address_list_dom = $(address_list_html);
		
		$('body').append(address_list_dom);
		
		// 返回
		address_list_dom.find('.js-cancel').click(function(){
			address_list_dom.remove();
		});
		
		// 选择
		address_list_dom.find('.js-address-item').click(function(){
			var commonweal_address = commonweal_address_list[$(this).data('id')];
			
			$('.js-logistics-content').html('<div><div class="block block-form block-border-top-none block-border-bottom-none"><div class="js-order-address express-panel" style="padding-left:0;"><div class="opt-wrapper"><a href="javascript:;" class="btn btn-xxsmall btn-grayeee butn-edit-address js-change-address">切换</a></div><ul><li><span>' + commonweal_address.name + '</span>, ' + commonweal_address.tel + '</li><li>' + commonweal_address.province_txt + ' ' + commonweal_address.city_txt + ' ' + commonweal_address.area_txt + ' </li><li>' + commonweal_address.address + '</li></ul></div></div><div class="js-logistics-tips logistics-tips font-size-12 c-orange hide">很抱歉，该地区暂不支持配送。</div></div>');
			$('#address_id').val(commonweal_address.id);
			getPostage();
			
			address_list_dom.remove();
		});
		
	});
	
	
	var getPostage = function(type){
		var address_id = 0;
		var send_other_number = 1;
		if ($(".js-send_other_number").size() > 0) {
			send_other_number = $(".js-send_other_number").val();
		}
		if (!is_logistics) {
			return false;
		}
		if($('#address_id').size() == 0){
			return false;
		}
		address_id = $('#address_id').val();
		
		$.post('address.php?action=postage', {orderNo : orderNo, address_id : address_id, pay_type : "send_other", send_other_number : send_other_number, send_other_type: send_other_type}, function (result) {
			if (typeof(result) == 'object') {
				if (result.err_msg == undefined || result.err_msg == null || result.err_msg == ''){
					result.err_msg = 0;
				}
				if (result.err_code == 1001) {
					window.location.reload();
				} else if(result.err_code == 1009){
					$('.js-step-topay').addClass('hide');
					$('.js-logistics-tips').removeClass('hide');
					
					if (typeof type == "undefined") {
						l_express = false;
					} else {
						l_friend = false;
					}
				}else if(result.err_code){
					$('.js-step-topay').removeClass('hide');
					alert('无法获取该订单支付信息\r\n错误提示：'+result.err_msg);
					
					if (typeof type == "undefined") {
						l_express = false;
					} else {
						l_friend = false;
					}
				}else{
					postage = parseFloat(result.err_msg);
					$("#js-postage").html(postage.toFixed(2));
					
					$("input[name='postage_list']").val(result.err_dom.postaage_list);
					supplier_postage_money = result.err_dom.supllier_postage;
					resetPrice();
					
					$('.js-step-topay').removeClass('hide');
					$('.js-logistics-tips').addClass('hide');
					if (typeof type == "undefined") {
						l_express = true;
					} else {
						l_friend = true;
					}
				}
			}else{
				motify.log('访问异常，请重试');
			}
		});
	}
	var refreshAdress = function(){
		$.post('address.php?action=list',function(result){
			if(typeof(result) == 'object'){
				if(result.err_code == 0){
					addressList = result.err_msg;
				}
			}else{
				motify.log('访问异常，请重试');
			}
		});
	}
	
	$('.js-order-address .opt-wrapper .js-edit-address').live('click',function(){
		var nowAdress = addressList[$('#address_id').val()];
		editAdress(function(){
			$('#addAdress input[name="user_name"]').val(nowAdress.name);
			$('#addAdress input[name="tel"]').val(nowAdress.tel);
			$('#addAdress input[name="address"]').val(nowAdress.address);
			$('#addAdress input[name="zipcode"]').val(nowAdress.zipcode);
			
			getProvinces('province',nowAdress.province);
			getCitys('city','province',nowAdress.city,'城市');
			getAreas('county','city',nowAdress.area,'区县');
		},nowAdress.address_id);
	});
	
	//页面初始化
	if($('.js-order-address > .js-edit-address').size()){
		if (is_logistics) {
			$('.js-order-address > .js-edit-address').trigger('click');
		}
	}else{
		getPostage();
		refreshAdress();
	}

	$('.js-msg-container').focus(function(){
		$(this).addClass('two-rows');
	}).blur(function(){
		$(this).removeClass('two-rows');
	});
	var nowScroll=0;
	var payShowAfter = function(){
		$('html').css({'overflow':'visible','height':'auto','position':'static'});
		$('body').css({'overflow':'visible','height':'auto','padding-bottom':'45px'});
		$(window).scrollTop(nowScroll);
	}
	$('#confirm-pay-way-opts .btn-pay').click(function(){
		if (!is_logistics) {
			motify.log('商家未设置配送方式，暂时不能购买');
			return;
		}
		
		var payType = $(this).data('pay-type');
		var post_data = {payType : payType, orderNo : orderNo, msg : $('.js-msg-container').val(), is_app : is_app};
		if ($("#point_1").prop("checked")) {
			post_data.point = $(".js-point").data("point");
			post_data.point_money = $(".js-point").data("point_money");
		}
		if($('#address_id').size() > 0){
			if(parseInt($('#address_id').val()) < 1){
				motify.log('请选择收货地址');
				return false;
			}else{
				post_data.address_id = $('#address_id').val();
			}
		}
		
		if ($(".js-send_other_comment").size() > 0 && $(".js-send_other_comment").val().trim() == "") {
			motify.log('请填写赠言');
			$(".js-send_other_comment").focus();
			return false;
		}

		try {
			if ($(".js-user_coupon_input").length > 0) {
				var user_coupon_arr = [];
				$(".js-user_coupon_input").each(function () {
					if ($(this).prop("checked") && $(this).val() != "0") {
						user_coupon_arr.push($(this).val());
					}
				});
				
				post_data.user_coupon_id = user_coupon_arr;
			}
		} catch(e) {
			
		}
		
		post_data.send_other_number = 1;
		if ($(".js-send_other_number").size() > 0) {
			post_data.send_other_number = $(".js-send_other_number").val();
		}
		
		if ($(".js-send_other_per_number").size() > 0) {
			post_data.send_other_per_number = $(".js-send_other_per_number").val();
		}
		
		if ($(".js-send_other_hour").size() > 0) {
			post_data.send_other_hour = $(".js-send_other_hour").val();
		}
		
		if ($(".js-send_other_comment").size() > 0) {
			post_data.send_other_comment = $(".js-send_other_comment").val();
		}
		
		post_data.postage_list = $("input[name='postage_list']").val();
		post_data.send_other_type = $(".js-type").val();
		post_data.shipping_method = "send_other";
		if ($("#point_1").prop("checked")) {
			post_data.point = $(".js-point").data("point");
			post_data.point_money = $(".js-point").data("point_money");
		}

		var loadingCon = $('<div style="overflow:hidden;visibility:visible;position:absolute;z-index:1100;transition:opacity 300ms ease;-webkit-transition:opacity 300ms ease;opacity:1;top:'+(($(window).height()-100)/2)+'px;left:'+(($(window).width()-200)/2)+'px;"><div class="loader-container"><div class="loader center">处理中</div></div></div>');
		var loadingBg = $('<div style="height:100%;position:fixed;top:0px;left:0px;right:0px;z-index:1000;opacity:1;transition:opacity 0.2s ease;-webkit-transition:opacity 0.2s ease;background-color:rgba(0,0,0,0.901961);"></div>');
		$('html').css({'position':'relative','overflow':'hidden','height':$(window).height()+'px'});
		$('body').css({'overflow':'hidden','height':$(window).height()+'px','padding':'0px'}).append(loadingCon).append(loadingBg);
		nowScroll = $(window).scrollTop();

		//本地测试使用
		if (payType == 'test') {
			$.post('saveorder.php?action=test_pay', post_data, function(result){
				if (!result.err_code) {
					window.location.href = result.err_msg;
				} else {
					motify.log(result.err_msg);
				}
			})
			return true;
		}

		if ($(this).hasClass('go-pay')) {
			$.post('saveorder.php?action=go_pay',post_data,function(result){
				if (!result.err_code) {
					window.location.href = result.err_msg;
				} else {
					motify.log(result.err_msg);
				}
			})
			return true;
		}
		$.post('saveorder.php?action=pay',post_data,function(result){
			payShowAfter();
			loadingBg.css('opacity', 0);
			setTimeout(function(){
				loadingCon.remove();loadingBg.remove();
			},200);
			if(typeof(result) == 'object'){
				if(result.err_code == 0){
					if (is_app == true) {
						data_app_json = '{"body":"' + result.err_msg.body + '", "out_trade_on":"' + result.err_msg.out_trade_no + '","total_fee":"' + result.err_msg.total_fee + '","notify_url":"' + result.err_msg.notify_url + '","attach":"' + result.err_msg.attach + '","return_url":"' + result.err_msg.return_url + '"}';
						
						try {
							if (app_type == 'ios') {
								app_result = true;
								return;
							} else {
								window.SysClientJs.weiXinPay(data_app_json);
							}
						} catch(e) {
							motify.log("调用微信支付失败，请重试");
						}
						return;
					}
					if(payType == 'weixin' && window.WeixinJSBridge){
						if (typeof result.err_dom != "undefined" && result.err_dom == "not_pay") {
							window.location.href = result.err_msg;
							return;
						}
						
						window.WeixinJSBridge.invoke("getBrandWCPayRequest",result.err_msg,function(res){
							WeixinJSBridge.log(res.err_msg);
							if(res.err_msg=="get_brand_wcpay_request:ok"){
								window.location.href = './order.php?orderno='+orderNo;
							}else{
								if(res.err_msg == "get_brand_wcpay_request:cancel"){
									var err_msg = "您取消了微信支付";
								}else if(res.err_code == 3){
									var err_msg = "您正在进行跨号支付<br/>正在为您转入扫码支付......";
								}else if(res.err_msg == "get_brand_wcpay_request:fail"){
									var err_msg = "微信支付失败<br/>错误信息："+res.err_desc + obj2String(result);
								}else{
									var err_msg = res.err_msg +"<br/>"+res.err_desc + obj2String(result);
								}
								motify.log(err_msg);
								if(res.err_code == 3){
									wx_qrcode_pay(post_data);
								}
							}
						});
					}else{
						window.location.href = result.err_msg;
					}
				}else{
					if(result.err_code == 1008){
						motify.log("此订单为货到付款，现在无须支付");
						window.location.href = result.err_msg;
						return;
					}
					
					if (result.err_code == 10000 && is_edit) {
						motify.log(result.err_msg);
						window.location.reload();
						return;
					}
					
					motify.log(result.err_msg);
					if(result.err_code == 1007){
						window.location.href = './order.php?orderno='+orderNo;
					}
				}
			}else{
				motify.log(result.err_msg);
				// motify.log('访问异常，请重试');
			}
		});
	});

	// 更改优惠券
	$(".js-user_coupon_input").click(function () {
		var user_coupon = 0;
		$(".js-user_coupon_input").each(function () {
			if ($(this).prop("checked")) {
				var coupon = parseFloat($(this).closest("p").find("span").html());
				user_coupon += coupon;
			}
		});
		
		if ($("#js-user_coupon").length > 0) {
			$("#js-user_coupon").html(user_coupon.toFixed(2));
		}
		resetPrice();
	});

	// 更改积分兑换
	$(".js-point_input").click(function () {
		$(".js-point_money span").html(parseFloat($(this).val()).toFixed(2));
		resetPrice();
	});
});

function wx_qrcode_pay(post_data){
	$.post('saveorder.php?action=pay&qrcode_pay=1',post_data,function(result){
		if(result.err_code == 0){
			$('#pay-qrcode').attr('src',result.err_msg);
			$('#confirm-pay-way-opts').css('display','none');
			$('#confirm-qrcode-pay').css('display','block');
		}
	});
}

function setPoint() {
	var supplier_money = parseFloat($(".js-sub_total").data("supplier_money")) - supplier_reward_money - supplier_coupon_money + supplier_postage_money;
	if (is_point && supplier_money > 0 && $("#point_1").prop("checked") && points_data.price > 0) {
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
		
		point_money = point_money.toFixed(2);
		point = (point_money * parseFloat(points_data.price)).toFixed(2);
		
		if ($("#point_1").size() > 0) {
			$(".js-point_content").html("您可以使用" + point + "积分，抵" + point_money + "元");
			$(".js-point_money").find("span").html(point_money);
			
			$("#point_1").val(point_money);
			$(".js-point").data("point", point);
			$(".js-point").data("point_money", point_money);
			$(".js-point").show();
		}
	}
}

function resetPrice() {
	setPoint();
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
	
	if ($(".js-point_money span").length > 0) {
		point_money_t = parseFloat($(".js-point_money span").html());
	}
	
	var money = sub_total + postage1 - reward - user_coupon - float_amount - discount_money - point_money_t;
	if (money < 0) {
		money = 0;
	}
	
	var rand_str = Math.random();
	$("#js-total").html("<span class='" + rand_str + "'>" + money.toFixed(2) + "</span>");
}

function appFromAndroid() {
	is_app = true;
	app_type = "android";
}

function appFromIOS() {
	is_app = true;
	app_type = "ios";
}

var obj2String = function(_obj) {
	var t = typeof(_obj);
	if (t != 'object' || _obj === null) {
		if (t == 'string') {
			_obj = '"' + _obj + '"';
		}
		return String(_obj);
	} else {
		if (_obj instanceof Date) {
			return _obj.toLocaleString();
		}
		// recurse array or object
		var n, v, json = [],
		arr = (_obj && _obj.constructor == Array);
		for (n in _obj) {
			v = _obj[n];
			t = typeof(v);
			if (t == 'string') {
				v = '"' + v + '"';
			} else if (t == "object" && v !== null) {
				v = this.obj2String(v);
			}
			json.push((arr ? '': '"' + n + '":') + String(v));
		}
		return (arr ? '[': '{') + String(json) + (arr ? ']': '}');
	}
};