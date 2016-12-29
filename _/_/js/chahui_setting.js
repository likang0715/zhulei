/**
 * Created by pigcms_21 on 2015/2/5.
 */

function allnumLimit(obj) {
	obj.value = obj.value.replace(/[^0-9]/g, '');
}
var t;
$(function() {
	location_page(location.hash);
	$('li.dianpu a').live('click', function() {
		try {
			var mark_arr = $(this).attr("href").split("#");
			location_page("#" + mark_arr[1]);
		} catch (e) {
			location_page(location.hash);
		}
	});

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
				$(".dianpu_left .list").addClass("active").siblings().removeClass("active");
				$('.js-app-nav.list').addClass('active').siblings('.js-app-nav').removeClass('active');
				load_page('.app__content', load_url, {
					page: 'list_content'
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
					var ue = new window.UE.ui.Editor({
						toolbars: [
							["bold", "italic", "underline", "strikethrough", "forecolor", "backcolor", "justifyleft", "justifycenter", "justifyright", "|", "insertunorderedlist", "insertorderedlist", "blockquote"],
							["emotion", "uploadimage", "insertvideo", "link", "removeformat", "|", "rowspacingtop", "rowspacingbottom", "lineheight", "paragraph", "fontsize"],
							["inserttable", "deletetable", "insertparagraphbeforetable", "insertrow", "deleterow", "insertcol", "deletecol", "mergecells", "mergeright", "mergedown", "splittocells", "splittorows", "splittocols"]
						],
						autoClearinitialContent: false,
						autoFloatEnabled: true,
						wordCount: true,
						elementPathEnabled: false,
						maximumWords: 10000,
						initialFrameWidth: 458,
						initialFrameHeight: 600,
						focus: false
					});
					ue.render($('#editor_add')[0]);
				});
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
					var ue = new window.UE.ui.Editor({
						toolbars: [
							["bold", "italic", "underline", "strikethrough", "forecolor", "backcolor", "justifyleft", "justifycenter", "justifyright", "|", "insertunorderedlist", "insertorderedlist", "blockquote"],
							["emotion", "uploadimage", "insertvideo", "link", "removeformat", "|", "rowspacingtop", "rowspacingbottom", "lineheight", "paragraph", "fontsize"],
							["inserttable", "deletetable", "insertparagraphbeforetable", "insertrow", "deleterow", "insertcol", "deletecol", "mergecells", "mergeright", "mergedown", "splittocells", "splittorows", "splittocols"]
						],
						autoClearinitialContent: false,
						autoFloatEnabled: true,
						wordCount: true,
						textarea:"description",
						elementPathEnabled: false,
						maximumWords: 10000,
						initialFrameWidth: 458,
						initialFrameHeight: 600,
						focus: false
					});
					ue.render($('#editor')[0]);
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

	$('.js-add-physical-picture').live('click', function() {
		upload_pic_box(1, true, function(pic_list) {
			if (pic_list.length > 0) {
				for (var i in pic_list) {
					var list_size = $('.js-img-list li').size();
					$('.js-img-list').html('<li class="upload-preview-img"><a href="' + pic_list[i] + '" target="_blank"><img src="' + pic_list[i] + '"></a><a class="js-delete-picture close-modal small hide">×</a></li>');
				}
			}
		}, 1);
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
					if (value == '' || value.length > 60) {
						layer_tips(1, '茶会名称必填且必须小于60个字符');
						$('input[name="name"]').focus();
						return false;
					}
					break;
				case 'start_time':
					if (value.length < 16) {
						layer_tips(1, '开始时间未填写或格式不正确');
						$('input[name="start_time"]').focus();
						return false;
					}
					break;
				case 'end_time':
					if (value.length < 16) {
						layer_tips(1, '结束时间未填写或格式不正确');
						$('input[name="end_time"]').focus();
						return false;
					}
					break;
				case 'descs':
					if (value.length == 0) {
						layer_tips(1, '茶会描述未填写');
						$('textarea[name="descs"]').focus();
						return false;
					}
					break;
				case 'province':
				case 'city':
				case 'county':
					if (!/^\d+$/.test(value)) {
						layer_tips(1, '举办地址 区域 未选择');
						$('input[name="address"]').focus();
						return false;
					}
					break;
				case 'address':
					if (value.length == 0) {
						layer_tips(1, '详细举办地址未填写');
						$('input[name="address"]').focus();
						return false;
					}
					break;
				case 'map_lat':
				case 'map_long':
					if (value.length == 0) {
						layer_tips(1, '请标注在地图中的位置');
						$('input[name="address"]').focus();
						return false;
					}
					break;
				case 'zt':
					if (value.length == 0) {
						layer_tips(1, '请选择茶会主题');
						$('input[name="renshu"]').focus();
						return false;
					}
					break;
				case 'renshu':
					if (value.length == 0) {
						layer_tips(1, '请填写限制人数,不限制请填写0');
						$('input[name="renshu"]').focus();
						return false;
					}
					break;
			}
		}
		formObj['images'] = [];
		$.each($('.js-img-list li a img'), function(i, item) {
			formObj['images'][i] = $(item).attr('src');
		});
		nowDom.prop('disabled', true).html('添加中...');


		$.post(store_physical_add_url, formObj, function(result) {
			if (typeof(result) == 'object') {
				if (result.err_code) {
					nowDom.prop('disabled', false).html('添加');
					layer_tips(1, result.err_msg.replace('门店照片', '茶会海报'));
				} else {
					window.location.href = window.location.protocol + '//' + window.location.host + '/user.php?c=events&a=index';
					// window.location.reload();
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
					if (value == '' || value.length > 60) {
						layer_tips(1, '茶会名称必填且必须小于60个字符');
						$('input[name="name"]').focus();
						return false;
					}
					break;
				case 'province':
				case 'city':
				case 'county':
					if (!/^\d+$/.test(value)) {
						layer_tips(1, '举办地址 区域 未选择');
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
						layer_tips(1, '请标注在地图中的位置');
						$('input[name="address"]').focus();
						return false;
					}
					break;
				case 'zt':
					if (value.length == 0) {
						layer_tips(1, '请选择茶会主题');
						$('input[name="renshu"]').focus();
						return false;
					}
					break;
				case 'descs':
					if (value.length == 0) {
						layer_tips(1, '茶会描述未填写');
						$('textarea[name="descs"]').focus();
						return false;
					}
					break;
				case 'renshu':
					if (value.length == 0) {
						layer_tips(1, '请填写限制人数,不限制请填写0');
						$('input[name="renshu"]').focus();
						return false;
					}
					break;
			}
		}
		formObj['images'] = [];
		$.each($('.js-img-list li a img'), function(i, item) {
			formObj['images'][i] = $(item).attr('src');
		});
		nowDom.prop('disabled', true).html('保存中...');
		$.post(store_physical_edit_url, formObj, function(result) {
			if (typeof(result) == 'object') {
				if (result.err_code) {
					nowDom.prop('disabled', false).html('保存');
					layer_tips(1, result.err_msg);
				} else {
					window.location.href = window.location.protocol + '//' + window.location.host + '/user.php?c=events&a=index';
					// window.location.reload();
					layer_tips(0, result.err_msg);
				}
			} else {
				nowDom.prop('disabled', false).html('保存');
				layer_tips('系统异常，请重试提交');
			}
		});
	});
	// $('.physical_list .js-delete').live('click',function(e){
	// 	alert(1)
	// 	var pigcms_id = $(this).attr('data-id');
	// 	button_box($(this), e, 'left', 'confirm', '确定删除？', function(){
	// 		$.post(store_physical_del_url, {'pigcms_id': pigcms_id}, function(data){
	// 			if (!data.err_code) {
	// 				$('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
	// 				window.location.reload();
	// 			} else {
	// 				$('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
	// 			}
	// 			t = setTimeout('msg_hide()', 3000);
	// 			close_button_box();
	// 		});
	// 	});
	// });
})

function msg_hide() {
	$('.notifications').html('');
	clearTimeout(t);
}