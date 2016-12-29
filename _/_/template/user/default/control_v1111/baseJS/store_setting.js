/**
 * Created by pigcms_21 on 2015/2/5.
 */
 var t;
 $(function() {
 	location_page(location.hash);
 	$('.dianpu_left a').live('click', function() {
 		try {
 			var mark_arr = $(this).attr("href").split("#");
 			if (mark_arr[1]) {
 				location_page("#" + mark_arr[1]);
 			}
 		} catch (e) {
 			location_page(location.hash);
 		}
 	});
	//用户中心左侧菜单专用
	$(".dianpu a").live('click', function() {
		var marks2 = $(this).attr('href').split('#');
		if (marks2[1]) {
			if ($(this).attr('href')) location_page("#" + marks2[1], $(this));
		}
	})


	function location_page(mark, dom) {
		var mark_arr = mark.split('/');
		switch (mark_arr[0]) {
			case '#contact':
			$('.js-app-nav.contact').addClass('active').siblings('.js-app-nav').removeClass('active');

			$(".dianpu_left .contact").addClass("active").siblings().removeClass("active");
			load_page('.app__content', load_url, {
				page: 'contact_content'
			}, '', function() {
				if ($('.js-regions-wrap').data('province') == '') {
					getProvinces('s1', '');
				} else {
					getProvinces('s1', $('.js-regions-wrap').data('province'));
					getCitys('s2', 's1', $('.js-regions-wrap').data('city'));
					getAreas('s3', 's2', $('.js-regions-wrap').data('county'));
				}
				$.getScript(static_url + 'js/bdmap.js');
			});
			break;
			case '#list':
			$(".dianpu_left .list:eq(0)").addClass("active").siblings().removeClass("active");
			$('.js-app-nav.list').addClass('active').siblings('.js-app-nav').removeClass('active');
			load_page('.app__content', load_url, {
				page: 'list_content'
			}, '');
			break;
			case '#notice_list':
			$(".dianpu_left .list").removeClass("active");
			$('.js-app-nav.notice_list').addClass('active').siblings('.js-app-nav').removeClass('active');
			load_page('.app__content', load_url, {
				page: 'notice_list'
			}, '');
			break;
			case '#physical_store':
			$('.js-app-nav.list').addClass('active').siblings('.js-app-nav').removeClass('active');
			load_page('.app__content', load_url, {
				page: 'physical_add_content'
			}, '', function() {
				if ($('.js-regions-wrap').data('province') == '') {
					getProvinces('s1', '');
				} else {
					getProvinces('s1', $('.js-regions-wrap').data('province'));
					getCitys('s2', 's1', $('.js-regions-wrap').data('city'));
					getAreas('s3', 's2', $('.js-regions-wrap').data('county'));
				}
				$.getScript(static_url + 'js/bdmap.js');
			});
			break;
			case '#shop_notice': // 店铺订单消息配置

			$('.js-app-nav.shop_notice').addClass('active').siblings('.js-app-nav').removeClass('active');

			load_page('.app__content', load_url, {
				page: 'shop_mall'
			}, '');
			break;
			case '#physical_store_edit':
			$('.js-app-nav.list').addClass('active').siblings('.js-app-nav').removeClass('active');
			load_page('.app__content', load_url, {
				page: 'physical_edit_content',
				pigcms_id: mark_arr[1]
			}, '', function() {
				if ($('.js-regions-wrap').data('province') == '') {
					getProvinces('s1', '');
				} else {
					getProvinces('s1', $('.js-regions-wrap').data('province'));
					getCitys('s2', 's1', $('.js-regions-wrap').data('city'));
					getAreas('s3', 's2', $('.js-regions-wrap').data('county'));
				}
				$.getScript(static_url + 'js/bdmap.js');
			});
			break;
			default:
			$(".dianpu_left .info").addClass("active").siblings().removeClass("active");
			$('.js-app-nav.info').addClass('active').siblings('.js-app-nav').removeClass('active');
			load_page('.app__content', load_url, {
				page: 'store_content'
			}, '');

		}
	}
	$('#s1').live('change', function() {
		if ($(this).val() != '') {
			getCitys('s2', 's1', '');
		} else {
			$('#s2').html('<option value="">选择城市</option>');
		}
		$('#s3').html('<option value="">选择地区</option>');
	});
	$('#s2').live('change', function() {
		if ($(this).val() != '') {
			getAreas('s3', 's2', '');
		} else {
			$('#s3').html('<option value="">选择地区</option>');
		}
	});

	$('.js-app-nav').live('click', function() {
		$(this).addClass('active').siblings('.js-app-nav').removeClass('active');
	});

	$('.js-team-name-edit').live('click', function() {
		$('.js-team-name-input').removeClass('hide');
		$('.js-team-name-text').addClass('hide');
	})

	//上传店铺Logo
	$('.js-add-picture').live('click', function() {
		upload_pic_box(1, true, function(pic_list) {
			if (pic_list.length > 0) {
				for (var i in pic_list) {
					$('.avatar-img').attr('src', pic_list[i]);
				}
			}
		}, 1);
	});

	//店铺名唯一性检测
	$("input[name='team_name']").live('blur', function() {
		if ($("input[name='team_name']").val() != $("input[name='team_name']").attr('data')) {
			$.post(store_name_check_url, {
				'name': $.trim($("input[name='team_name']").val())
			}, function(data) {
				if (!data) {
					$("input[name='team_name']").closest('.control-group').addClass('error');
					$("input[name='team_name']").next('.error-message').html('店铺名称已存在');
				} else {
					$("input[name='team_name']").closest('.control-group').removeClass('error');
					$("input[name='team_name']").next('.error-message').html('店铺名称只能修改一次，请您谨慎操作');
				}
			})
		}
	})

	//店铺配置
	$('.js-btn-submit').live('click', function() {
		if ($("input[name='team_name']").val() == '') {
			$("input[name='team_name']").closest('.control-group').addClass('error');
			$("input[name='team_name']").next('.error-message').html('店铺名称不能为空');
			return false;
		}
		var name = $("input[name='team_name']").val();
		var logo = $('.avatar-img').attr('src');
		var intro = $('.input-intro').val();
		var price = $('.input-price').val();
		var linkman = $('.contact-name').val();
		var legal_person = $('.legal-person').val();
		var qq = $('.qq').val();
		var mobile = $(".js-mobile").val();
		var open_service = $('.open_service:checked').val();
		var is_show_drp_tel = $("select[name='is_show_drp_tel']").val();
		var sale_category_id = $("input[name='sale_category_id']").val();
		var sale_category_fid = $("input[name='sale_category_fid']").val();

		if (/^1[0-9]{10}$/.test(mobile) || (/^[0]?[0-9]{2,3}[\-]{1}[0-9]{5,8}$/.test(mobile)) || (/^[0-9]{1,4}[\-]{1}[0-9]{2,4}[\-]{1}[0-9]{2,4}$/.test(mobile))) {

		} else {
			layer_tips(1, "请正确填写手机/电话号码！");
			return false;
		}
		/*
        if (!/^1[0-9]{10}$/.test(mobile)) {
        	layer_tips(1, "请正确填写手机号码");
        	return false;
        }
        */
        /* 判断二级分类 */
        if ($(".set-cate-block .scb-li:eq(1) .scb-label:visible").length > 0 && $(".set-cate-block .scb-li:eq(1) .selected").length == 0) {
        	layer_tips(1, "请选择二级分类");
        	return false;
        }

        if (!$('.error').length) {
        	$.post(store_setting_url, {
        		'name': name,
        		'sale_category_id': sale_category_id,
        		'sale_category_fid': sale_category_fid,
        		'logo': logo,
        		'intro': intro,
        		'price': price,
        		'linkman': linkman,
        		'legal_person': legal_person,
        		'qq': qq,
        		'mobile': mobile,
        		'open_service': open_service,
        		"is_show_drp_tel": is_show_drp_tel
        	}, function(data) {
        		if (!data.err_code) {
        			$('.notifications').html('<div class="alert in fade alert-success">店铺配置成功</div>');
        			t = setTimeout('msg_hide()', 2000);
        			window.location.href = data.err_msg;
        		} else {
        			$('.notifications').html('<div class="alert in fade alert-error">店铺配置失败</div>');
        			t = setTimeout('msg_hide()', 2000);
        		}
        	})
        } else {
        	return false;
        }
    });

	// 店铺订单消息
	$('.js-btn-notice').live('click', function() {

		var order_notice_time = $('input[name="order_notice_time"]').val();

		if (order_notice_time == '') {
			layer_tips(1, '请填写消息提示持续时间');
			return;
		}

		if (!/^\d+(\.\d+)?$/.test(order_notice_time)) {
			layer_tips(1, '不允许输入非数字符串或负值');
			$('input[name="order_notice_time"]').focus();
			return;
		}

		$.post(set_notice_time_url, {
			order_notice_time: order_notice_time
		}, function(result) {
			if (typeof(result) == 'object') {
				if (result.err_code) {
					layer_tips(1, result.err_msg);
				} else {
					layer_tips(0, result.err_msg);
					setTimeout(function() {
						window.location.reload();
					}, 500);
				}
			} else {
				layer_tips(1, '系统异常，请重试提交');
			}
		});

	});

	$(".js-btn-notice-quit").live("click", function() {
		window.location.reload();
	});

	$(".js-mobile").live("focus", function() {
		$(this).closest(".control-group").removeClass("error");
		$(this).closest(".control-group").find(".js-mobile-message").remove();
	});

	$(".js-mobile").live('blur', function() {

		var mobile = $(".js-mobile").val();
		if (/^1[0-9]{10}$/.test(mobile) || (/^[0]?[0-9]{2,3}[\-]{1}[0-9]{6,8}$/.test(mobile)) || (/^[0-9]{1,4}[\-]{1}[0-9]{2,4}[\-]{1}[0-9]{2,4}$/.test(mobile))) {

		} else {
			$(this).parent().append('<span class="error-message js-mobile-message">手机或电话号码格式不正确</span>');
			$(this).closest(".control-group").addClass("error");
		}
		/*
		if (!/^1[0-9]{10}$/.test(mobile)) {
			$(this).parent().append('<span class="error-message js-mobile-message">手机号码格式不正确</span>');
			$(this).closest(".control-group").addClass("error");
		}*/
	});

	$('.js-contact-submit').live('click', function() {
		layer.closeAll();
		var formObj = {};
		var form = $('.form-horizontal').serializeArray();
		$.each(form, function(i, field) {
			formObj[field.name] = field.value;
		});
		for (var i in formObj) {
			var value = formObj[i];
			switch (i) {
				case 'name':
				if (value == '' || value.length > 20) {
					layer_tips(1, '门店名称必填且必须小于20个字符');
					$('input[name="name"]').focus();
					return false;
				}
				break;
				case 'phone1':
				if (value != '' && !/^\d+$/.test(value)) {
					layer_tips(1, '区号为数字');
					$('input[name="phone1"]').focus();
					return false;
				}
				break;
				case 'phone2':
				if (!/^\d+$/.test(value)) {
					layer_tips(1, '电话为数字');
					$('input[name="phone2"]').focus();
					return false;
				}
				break;
				case 'business_hours':
				if (value.length == 0) {
					layer_tips(1, '运营时间未填写');
					$('input[name="business_hours"]').focus();
					return false;
				}
				break;
				case 'mobile':
				if (/^1[0-9]{10}$/.test(value) || (/^[0]?[0-9]{2,3}[\-]{1}[0-9]{6,8}$/.test(value)) || (/^[0-9]{1,4}[\-]{1}[0-9]{2,4}[\-]{1}[0-9]{2,4}$/.test(value))) {
				} else {
					layer_tips(1, '手机号码格式不正确');
					$('input[name="mobile"]').focus();
					return false;
				}
				break;
				case 'province':
				case 'city':
				case 'county':
				if (!/^\d+$/.test(value)) {
					layer_tips(1, '联系地址 区域 未选择');
					$('input[name="address"]').focus();
					return false;
				}
				break;
				case 'address':
				if (value.length == 0) {
					layer_tips(1, '详细地址未填写');
					$('input[name="address"]').focus();
					return false;
				}
				break;
				case 'map_lat':
				case 'map_long':
				if (value.length == 0) {
					layer_tips(1, '请点击地图、在地图中标识地理位置');
					return false;
				}
				break;
			}
		}
		$.post(store_contact_url, formObj, function(result) {
			if (typeof(result) == 'object') {
				if (result.err_code) {
					layer_tips(1, result.err_msg);
				} else {
					layer_tips(0, result.err_msg);
				}
			} else {
				layer_tips('系统异常，请重试提交');
			}
		});
	});

$('.js-add-physical-picture').live('click', function() {
	upload_pic_box(1, true, function(pic_list) {
		if (pic_list.length > 0) {
			for (var i in pic_list) {
				$('.js-img-list').html('<li class="upload-preview-img"><a href="' + pic_list[i] + '" target="_blank"><img src="' + pic_list[i] + '"></a><a class="js-delete-picture close-modal small hide">×</a></li>');
			}
		}
	}, 1);
});
$('.js-add-pic').live('click', function() {
	if ($('.js-pic-list li').size() >= 5) {
		layer_tips(1, '商品图片最多支持 5 张');
		return false;
	} else {
		upload_pic_box(1, true, function(pic_list) {
			if (pic_list.length > 0) {
				for (var i in pic_list) {
					var list_size = $('.js-pic-list li').size();
					if (list_size > 5) {
						layer_tips(1, '商品图片最多支持 5 张');
						return false;
					} else {
						$('.js-pic-list').append('<li class="upload-preview-pic"><a href="' + pic_list[i] + '" target="_blank"><img src="' + pic_list[i] + '"></a><a class="js-delete-picture close-modal small hide">×</a></li>');
					}
				}
			}
		}, 5 - $('.js-pic-list li').size());
	}
});
$('.js-delete-picture').live('click', function() {
	$(this).closest('li').remove();
});
$('.js-physical-submit').live('click', function() {
	var nowDom = $(this);
	layer.closeAll();
	var formObj = {};
	var form = $('.form-horizontal').serializeArray();
	$.each(form, function(i, field) {
		formObj[field.name] = field.value;
	});
	for (var i in formObj) {
		var value = formObj[i];
		switch (i) {
			case 'name':
			if (value == '' || value.length > 20) {
				layer_tips(1, '门店名称必填且必须小于20个字符');
				$('input[name="name"]').focus();
				return false;
			}
			break;
			case 'phone1':
			if (value != '' && !/^\d+$/.test(value)) {
				layer_tips(1, '区号为数字');
				$('input[name="phone1"]').focus();
				return false;
			}
			break;
			case 'phone2':
			if (!/^\d+$/.test(value)) {
				layer_tips(1, '电话为数字');
				$('input[name="phone2"]').focus();
				return false;
			}
			break;
			case 'mobile':
			if (/^1[0-9]{10}$/.test(value) || (/^[0]?[0-9]{2,3}[\-]{1}[0-9]{6,8}$/.test(value)) || (/^[0-9]{1,4}[\-]{1}[0-9]{2,4}[\-]{1}[0-9]{2,4}$/.test(value))) {
			} else {
				layer_tips(1, '手机号码格式不正确');
				$('input[name="mobile"]').focus();
				return false;
			}
			break;
			case 'business_hours':
			if (value.length == 0) {
				layer_tips(1, '运营时间未填写');
				$('input[name="business_hours"]').focus();
				return false;
			}
			break;
			case 'province':
			case 'city':
			case 'county':
			if (!/^\d+$/.test(value)) {
				layer_tips(1, '联系地址 区域 未选择');
				$('input[name="address"]').focus();
				return false;
			}
			break;
			case 'address':
			if (value.length == 0) {
				layer_tips(1, '详细地址未填写');
				$('input[name="address"]').focus();
				return false;
			}
			break;
			case 'price':
			if (value.length == 0) {
				layer_tips(1, '平均价位未填写');
				$('input[name="price"]').focus();
				return false;
			}
			break;
			case 'map_lat':
			case 'map_long':
			if (value.length == 0) {
				layer_tips(1, '请点击地图、在地图中标识地理位置');
				return false;
			}
			break;
		}
	}
	if ($('.js-img-list li a img').size() == 0) {
		layer_tips(1, '请上传门店LOGO');
		return false;
	}
	if ($('.js-pic-list li a img').size() == 0) {
		layer_tips(1, '请上传门店照片,最多5张');
		return false;
	}
	formObj['images'] = $('.js-img-list li a img').eq(0).attr('src');
	formObj['pics'] = [];
	$.each($('.js-pic-list li a img'), function(i, item) {
		formObj['pics'][i] = $(item).attr('src');
	});
	nowDom.prop('disabled', true).html('添加中...');
	$.post(store_physical_add_url, formObj, function(result) {
		if (typeof(result) == 'object') {
			if (result.err_code) {
				nowDom.prop('disabled', false).html('添加');
				layer_tips(1, result.err_msg);
			} else {
				window.location.hash = 'list';
				window.location.reload();
				layer_tips(0, result.err_msg);
			}
		} else {
			nowDom.prop('disabled', false).html('添加');
			layer_tips(1, '系统异常，请重试提交');

		}
	});
});

$('.js-physical-edit-submit').live('click', function() {
	var nowDom = $(this);
	layer.closeAll();
	var formObj = {};
	var form = $('.form-horizontal').serializeArray();
	$.each(form, function(i, field) {
		formObj[field.name] = field.value;
	});
	for (var i in formObj) {
		var value = formObj[i];
		switch (i) {
			case 'name':
			if (value == '' || value.length > 20) {
				layer_tips(1, '门店名称必填且必须小于20个字符');
				$('input[name="name"]').focus();
				return false;
			}
			break;
			case 'phone1':
			if (value != '' && !/^\d+$/.test(value)) {
				layer_tips(1, '区号为数字');
				$('input[name="phone1"]').focus();
				return false;
			}
			break;
			case 'phone2':
			if (!/^\d+$/.test(value)) {
				layer_tips(1, '电话为数字');
				$('input[name="phone2"]').focus();
				return false;
			}
			break;
			case 'province':
			case 'city':
			case 'county':
			if (!/^\d+$/.test(value)) {
				layer_tips(1, '联系地址 区域 未选择');
				$('input[name="address"]').focus();
				return false;
			}
			break;
			case 'address':
			if (value.length == 0) {
				layer_tips(1, '详细地址未填写');
				$('input[name="address"]').focus();
				return false;
			}
			break;
			case 'price':
			if (value.length == 0) {
				layer_tips(1, '平均价位未填写');
				$('input[name="price"]').focus();
				return false;
			}
			break;
			case 'map_lat':
			case 'map_long':
			if (value.length == 0) {
				layer_tips(1, '请点击地图、在地图中标识地理位置');
				return false;
			}
			break;
		}
	}
	if ($('.js-img-list li a img').size() == 0) {
		layer_tips(1, '请上传门店LOGO');
		return false;
	}
	if ($('.js-pic-list li a img').size() == 0) {
		layer_tips(1, '请上传门店照片,最多5张');
		return false;
	}
	formObj['images'] = $('.js-img-list li a img').eq(0).attr('src');
	formObj['pics'] = [];
	$.each($('.js-pic-list li a img'), function(i, item) {
		formObj['pics'][i] = $(item).attr('src');
	});
	nowDom.prop('disabled', true).html('保存中...');
	$.post(store_physical_edit_url, formObj, function(result) {
		if (typeof(result) == 'object') {
			if (result.err_code) {
				nowDom.prop('disabled', false).html('保存');
				layer_tips(1, result.err_msg);
			} else {
				window.location.reload();
				layer_tips(0, result.err_msg);
			}
		} else {
			nowDom.prop('disabled', false).html('保存');
			layer_tips('系统异常，请重试提交');
		}
	});
});
$('.physical_list .js-delete').live('click', function(e) {
	var pigcms_id = $(this).attr('data-id');
	button_box($(this), e, 'left', 'confirm', '确定删除？', function() {
		$.post(store_physical_del_url, {
			'pigcms_id': pigcms_id
		}, function(data) {
			if (!data.err_code) {
				$('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
				window.location.reload();
			} else {
				$('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
			}
			t = setTimeout('msg_hide()', 3000);
			close_button_box();
		});
	});
});

	// 店铺订单提示开关
	$('.js-shop-notice').live('click', function() {
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
		$.post(shop_notice_url, {
			'status': status
		}, function(data) {
			if (!data.err_code) {
				$(obj).removeClass(oldClassName);
				$(obj).addClass(className);
				if (status) {
					layer_tips(0, '开启完毕');
				} else {
					layer_tips(1, '关闭成功');
				}
			}
		})
	});

})

function msg_hide() {
	$('.notifications').html('');
	clearTimeout(t);
}