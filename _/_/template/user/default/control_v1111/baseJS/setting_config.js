/**
 * Created by pigcms_21 on 2015/2/6.
 */
$(function(){
	var hash_arr = location.hash.split("/");
	var current_index = 0;
	switch (hash_arr[0]) {
		case "#selffetch" :
			current_index = 1;
			break;
		case "#friend" :
			current_index = 2;
			break;
		case "#offline_payment" :
			current_index = 3;
			break;
		case "#local_logistic" :
			current_index = 4;
			break;
		default :
			current_index = 0;
			break;
	}
	
	$(".js-app-nav").removeClass("active");
	$(".js-app-nav").eq(current_index).addClass("active");
	
	location_page(location.hash);
	$(".js-app-nav a").live("click", function () {
		$(this).closest("ul").find("li").removeClass("active");
		$(this).closest("li").addClass("active");
		location_page($(this).attr("href"));
	});
	
	function location_page(mark, page){
		var mark_arr = mark.split('/');
		switch(mark_arr[0]){
			case "#selffetch":
				load_page('.app__content', trade_selffetch_url, {page : "selffetch_content"}, '');
				break;
			case "#offline_payment" :
				load_page('.app__content', trade_load_url, {page : "offline_payment_content"}, '');
				break;
			case "#friend" :
				if (mark_arr[1] == "add") {
					load_page('.app__content', load_url, {page : "address_add"}, '', function () {
						getProvinces('provinceId_m','','省份');
						$('#provinceId_m').change(function(){
							if($(this).val() != ''){
								getCitys('cityId_m','provinceId_m','','城市');
							}else{
								$('#cityId_m').html('<option value="">城市</option>');
							}
							$('#areaId_m').html('<option value="">区县</option>');
						});
						$('#cityId_m').change(function(){
							if($(this).val() != ''){
								getAreas('areaId_m','cityId_m','','区县');
							}else{
								$('#areaId_m').html('<option value="">区县</option>');
							}
						});
					});
				} else if (mark_arr[1] == "edit") {
					if (typeof mark_arr[2] == "undefined" || mark_arr[2].length == 0) {
						load_page('.app__content', load_url, {page : "friend_content"}, '');
						return;
					}
					load_page('.app__content', load_url, {page : "address_edit", "id" : mark_arr[2]}, '', function () {
						changeArea();
					});
				} else {
					load_page('.app__content', load_url, {page : "friend_content"}, '');
				}
				break;
			case "#address_add" :
				
				break;
			case "#local_logistic" :
				load_page('.app__content', local_logistic_url, {page : "local_logistic"}, '');
				break;
			default :
				load_page('.app__content', logistics_url, '', '');
		}
	};
	
	function changeArea() {
		getProvinces('provinceId_m',$('#provinceId_m').attr('data-province'),'省份');
		getCitys('cityId_m','provinceId_m',$('#cityId_m').attr('data-city'),'城市');
		getAreas('areaId_m','cityId_m',$('#areaId_m').attr('data-area'),'区县');
		$('#provinceId_m').change(function(){
			if($(this).val() != ''){
				getCitys('cityId_m','provinceId_m','','城市');
			}else{
				$('#cityId_m').html('<option value="">城市</option>');
			}
			$('#areaId_m').html('<option value="">区县</option>');
		});
		$('#cityId_m').change(function(){
			if($(this).val() != ''){
				getAreas('areaId_m','cityId_m','','区县');
			}else{
				$('#areaId_m').html('<option value="">区县</option>');
			}
		});
	}
	
	$(".js-friend-address").live("click", function () {
		location_page($(this).attr("href"));
	});
	
	// 货到付款
	$('.js-offline_payment').live('click', function(){
		var obj = this;
		if ($(this).hasClass('ui-switch-off')) {
			var status = 1;
			var oldClassName = 'ui-switch-off';
			var className = 'ui-switch-on';
		} else {
			var status = 0;
			var oldClassName = 'ui-switch-on';
			var className = 'ui-switch-off';
		}
		$.post(offline_payment_status_url, {'status': status}, function(data){
			if(!data.err_code) {
				$(obj).removeClass(oldClassName);
				$(obj).addClass(className);
			}
		})
	});
	
	$(".js-selffetch_payment").live("click", function (event) {
		var obj = this;
		if ($(this).hasClass('ui-switch-off')) {
			var status = 1;
			var oldClassName = 'ui-switch-off';
			var className = 'ui-switch-on';
		} else {
			var status = 0;
			var oldClassName = 'ui-switch-on';
			var className = 'ui-switch-off';
		}
		$.post(selffetch_status_url, {'status': status}, function(data){
			if(!data.err_code) {
				$(obj).removeClass(oldClassName);
				$(obj).addClass(className);
			}
		})
	});
	
	$(".js-friend-status").live("click", function (event) {
		var obj = this;
		if ($(this).hasClass('ui-switch-off')) {
			var status = 1;
			var oldClassName = 'ui-switch-off';
			var className = 'ui-switch-on';
		} else {
			var status = 0;
			var oldClassName = 'ui-switch-on';
			var className = 'ui-switch-off';
		}
		$.post(friend_status_url, {'status': status}, function(data){
			if(!data.err_code) {
				$(obj).removeClass(oldClassName);
				$(obj).addClass(className);
			}
		})
	});
	
	$(".js-logistics-status").live("click", function () {
		var obj = this;
		if ($(this).hasClass('ui-switch-off')) {
			var status = 1;
			var oldClassName = 'ui-switch-off';
			var className = 'ui-switch-on';
		} else {
			var status = 0;
			var oldClassName = 'ui-switch-on';
			var className = 'ui-switch-off';
		}
		
		$.post(logistics_status_url, {'status': status}, function(data){
			if(!data.err_code) {
				$(obj).removeClass(oldClassName);
				$(obj).addClass(className);
			}
		})
	});

	$(".js-local_logistic-status").live("click", function () {
		var obj = this;
		if ($(this).hasClass('ui-switch-off')) {
			var status = 1;
			var oldClassName = 'ui-switch-off';
			var className = 'ui-switch-on';
		} else {
			var status = 0;
			var oldClassName = 'ui-switch-on';
			var className = 'ui-switch-off';
		}
		$.post(local_logistic_status_url, {'status': status}, function(data){
			if(!data.err_code) {
				$(obj).removeClass(oldClassName);
				$(obj).addClass(className);
			}
		})
	});

	$(".js-buyer_selffetch_name").live("click", function () {
		var buyer_selffetch_name = $("input[name='buyer_selffetch_name']").val();
		if ($.trim(buyer_selffetch_name).length == 0) {
			layer_tips(1, '自提点前台显示名没有填写');
			return false;
		}
		
		$.post(buyer_selffetch_name_url, {buyer_selffetch_name : buyer_selffetch_name}, function (result) {
			if(result.err_code == 0){
				layer_tips(0, result.err_msg);
				location.reload();
			}else{
				layer.alert(result.err_msg, 0);
			}
		})
	});
	
	
	/**
	 * 送朋友收货地址
	 */
	$(".js-address-edit").live("click", function () {
		var href = $(this).attr("href");
		location_page(href);
	});
	
	$(".js-delete-edit").live("click", function (e) {
		var address_id = $(this).data("id");
		var delete_obj = $(this);
		button_box($(this), e, 'left', 'confirm', '确定删除吗？', function(){
			$.post(commonweal_address_delete_url, {"id" : address_id}, function (result) {
				close_button_box();
				if (result.err_code == 0) {
					layer_tips(0, "删除成功");
					delete_obj.closest("tr").remove();
				} else {
					layer_tips(1, result.err_msg);
				}
			});
		});
	});
	
	$(".js-address-submit").live("click", function () {
		var title = $("input[name='title']").val();
		var name = $("input[name='name']").val();
		var tel = $("input[name='tel']").val();
		var province = $("select[name='province']").val();
		var city = $("select[name='city']").val();
		var area = $("select[name='county']").val();
		var address = $("input[name='address']").val();
		var zipcode = $("input[name='zipcode']").val();
		var is_default = $("input[name='default']").prop("checked");
		var address_id = $("input[name='address_id']").val();
		
		if (name.length == 0) {
			layer_tips(1, "请填写收货人姓名");
			$("input[name='name']").focus();
			return;
		}
		
		if (tel.length == 0) {
			layer_tips(1, "请填写联系电话");
			$("input[name='tel']").focus();
			return;
		}
		
		if (!/^\d{5,12}$/.test(tel)) {
			layer_tips(1, "请正确填写联系电话");
			$("input[name='tel']").focus();
			return;
		}
		
		if (province.length == 0) {
			layer_tips(1, "请选择省份");
			$("select[name='province']").focus();
			return;
		}
		
		if (city.length == 0) {
			layer_tips(1, "请选择城市");
			$("select[name='city']").focus();
			return;
		}
		
		if (area.length == 0) {
			layer_tips(1, "请选择地区");
			$("select[name='county']").focus();
			return;
		}
		
		if (address.length == 0) {
			layer_tips(1, "请填写详细地址");
			$("input[name='address']").focus();
			return;
		}
		
		var data = {title: title, name: name, tel: tel, province: province, city: city, area: area, address:address, zipcode: zipcode, is_default: is_default, address_id: address_id};
		$.post(commonweal_address_url, data, function (result) {
			if (result.err_code == "0") {
				layer_tips(0, result.err_msg);
				location.href = setting_config_url + "#friend";
				location_page("#friend");
			} else {
				layer_tips(1, result.err_msg);
			}
		});
	});
})


// 
function msg_hide() {
	$('.notifications').html('');
	clearTimeout(t);
}