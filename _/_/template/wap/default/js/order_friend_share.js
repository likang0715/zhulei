var address_valid = false;
var address_message = "请选择省份";
$(function(){
	$(".js-open-share").click(function () {
		$("#js-share-guide").removeClass("hide");
	});
	
	$("#js-share-guide").click(function () {
		$("#js-share-guide").addClass("hide");
	});
	
	if ($("#province").size() > 0) {
		getProvinces('province','','省份');
		$('#province').change(function() {
			if ($(this).val() != '') {
				getCitys('city','province','','城市');
			} else {
				$('#city').html('<option>城市</option>');
			}
			$('#county').html('<option>区县</option>');
			
			var address_id = $(this).val();
			if (address_id.length > 0) {
				getPostage(address_id);
			}
		});
		$('#city').change(function(){
			if ($(this).val() != '') {
				getAreas('county','city','','区县');
			} else {
				$('#county').html('<option>区县</option>');
			}
		});
	}
	
	$(".js-save").click(function () {
		if (!address_valid) {
			motify.log(address_message);
			return;
		}
		
		var name = $(".js-name").val();
		var phone = $(".js-phone").val();
		var province = $("#province").val();
		var city = $("#city").val();
		var county = $("#county").val();
		var address = $(".js-address").val();
		
		if (name.length == 0) {
			motify.log("请填写收货人姓名");
			$(".js-name").focus();
			return;
		}
		
		if (phone.length == 0) {
			motify.log("请填写联系方式");
			$(".js-phone").focus();
			return;
		}
		
		if (!/^1[0-9]{5,12}$/.test(phone)) {
			motify.log("联系方式请正确填写");
			$(".js-phone").focus();
			return;
		}
		
		if (province.length == 0) {
			motify.log("请选择省份");
			$("#province").focus();
			return;
		}
		
		if (city.length == 0) {
			motify.log("请选择城市");
			$("#city").focus();
			return;
		}
		
		if (county.length == 0) {
			motify.log("请选择地区");
			$("#county").focus();
			return;
		}
		
		if (address.length == 0) {
			motify.log("请填写详细收货地址");
			$("#address").focus();
			return;
		}
		
		var post_data = {};
		post_data.name = name;
		post_data.phone = phone;
		post_data.province = province;
		post_data.city = city;
		post_data.county = county;
		post_data.address = address;
		
		$.post("", post_data, function (result) {
			motify.log(result.err_msg);
			if (result.err_code == "0") {
				window.location.reload()
			}
		});
	});
	
	var getPostage = function(address_id){
		$.post('address.php?action=friend_share_postage', {orderNo : orderNo, province_id : address_id},function(result){
			if(typeof(result) == 'object'){
				if (result.err_msg == undefined || result.err_msg == null || result.err_msg == ''){
					result.err_msg = 0;
				}
				if(result.err_code == 1009){
					address_valid = false;
					address_message = "很抱歉，该地区暂不支持配送。";
					motify.log(address_message);
					$('.js-save').addClass('hide');
					$('.js-logistics-tips').removeClass('hide');
				}else if(result.err_code){
					address_valid = false;
					address_message = "无法获取该订单支付信息\r\n错误提示：" + result.err_msg;
					motify.log(address_message);
					$('.js-save').addClass('hide');
					$('.js-logistics-tips').removeClass('hide');
				}else{
					address_valid = true;
					$('.js-save').removeClass('hide');
					$('.js-logistics-tips').addClass('hide');
				}
			}else{
				motify.log('访问异常，请重试');
			}
		});
	}
});