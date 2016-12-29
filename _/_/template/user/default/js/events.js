/**
 * Created by ediancha on 2016/8/9.
 */
function location_page(mark, dom) {
	var mark_arr = mark.split('/');
	switch (mark_arr[0]) {
		case '#add':
			load_page('.app__content', load_url, {
				page: 'add'
			}, '', function() {
				$('.third-header-inner li a').html('新增茶会');
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
		case '#edit':
			load_page('.app__content', load_url, {
				page: 'edit',
				pigcms_id: mark_arr[1]
			}, '', function() {
				$('.third-header-inner li a').html('编辑茶会');
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
		case '#result':
			load_page('.app__content', load_url, {
				page: 'edit',
				pigcms_id: mark_arr[1]
			}, '', function() {
				$('.third-header-inner li a').html('报名情况');
			});
			break;
		case '#list':
			load_page('.app__content', load_url, {
				page: 'list'
			}, '',function () {
				$('.third-header-inner li a').html('茶会列表');
			});
			break;
		default:
			$('.js-app-nav.info').addClass('active').siblings('.js-app-nav').removeClass('active');
			load_page('.app__content', load_url, {
				page: 'list'
			}, '',function () {
				$('.third-header-inner li a').html('茶会列表');
			});
	}
}
$(function(){
	$("#pages a").live("click", function () {
		var pages = $(this).data("page-num");
		load_page('.app__content', load_url, {
				page: 'list',
				pages: pages
			}, '',function () {
				$('.third-header-inner li a').html('茶会列表');
			});
	});
	//开始时间
	$('#js-start-time').live('focus', function() {
		var options = {
			numberOfMonths: 2,
			dateFormat: "yy-mm-dd",
			timeFormat: "HH:mm",
			minDate: "0",
			showSecond: false,
			onSelect: function() {
				if ($('#js-start-time').val() != '') {
					$('#js-end-time').datepicker('option', 'minDate', new Date());
				}
			},
			onClose: function() {
				var flag = options._afterClose($(this).datepicker('getDate'), $('#js-end-time').datepicker('getDate'));
				if (!flag) {
					$(this).datepicker('setDate', $('#js-end-time').datepicker('getDate'));
				}
			},
			_afterClose: function(date1, date2) {
				var starttime = 0;
				if (date1 != '' && date1 != undefined) {
					starttime = new Date(date1).getTime();
				}
				var endtime = 0;
				if (date2 != '' && date2 != undefined) {
					endtime = new Date(date2).getTime();
				}
				if (endtime > 0 && endtime < starttime) {
					alert('无效的时间段');
					return false;
				}
				return true;
			}
		};
		$('#js-start-time').datetimepicker(options);
	})
	
	//结束时间
	$('#js-end-time').live('focus', function(){
		var options = {
			numberOfMonths: 2,
			dateFormat: "yy-mm-dd",
			minDate: "0",
			timeFormat: "HH:mm",
			showSecond: false,
			onSelect: function() {
				if ($('#js-end-time').val() != '') {
					$('#js-start-time').datepicker('option', 'maxDate', new Date($('#js-end-time').val()));
				}
			},
			onClose: function() {
				var flag = options._afterClose($('#js-start-time').datepicker('getDate'), $(this).datepicker('getDate'));
				if (!flag) {
					$(this).datepicker('setDate', $('#js-start-time').datepicker('getDate'));
				}
			},
			_afterClose: function(date1, date2) {
				var starttime = 0;
				if (date1 != '' && date1 != undefined) {
					starttime = new Date(date1).getTime();
				}
				var endtime = 0;
				if (date2 != '' && date2 != undefined) {
					endtime = new Date(date2).getTime();
				}
				if (starttime > 0 && endtime < starttime) {
					alert('无效的时间段');
					return false;
				}
				return true;
			}
		};
		$('#js-end-time').datetimepicker(options);
	})
	

	// 取消
	$(".js-btn-quit").live("click", function () {
		location_page('');
	})
	
	// 添加茶会
	$(".js-add-present").live("click", function () {
		$(".js-select-goods-list").show();
		loadProduct();
	});
	
	// 类型切换
	$(".js-search-type").live('change', function () {
		$(".js-title").attr("placeholder", $(".js-title").attr("data-goods-" + $(this).val()));
	})
	
	// 搜索添加茶会
	$(".js-search").live('click', function () {
		var group_id = $(".js-goods-group").val();
		var type = $(".js-search-type").val();
		var title = $(".js-title").val();
		loadProduct(group_id, type, title, 1);
	})
	
	// 搜索商品切换
	$(".js-product_list_page a").live('click', function () {
		var page = $(this).attr("data-page-num");
		var group_id = $(".js-goods-group").val();
		var type = $(".js-search-type").val();
		var title = $(".js-title").val();
		loadProduct(group_id, type, title, page);
	});
	
	
	// 分页
	$(".js-present_list_page a").live("click", function () {
		var p = $(this).data("page-num");
		var keyword = $('.js-present-keyword').val();
		var type = window.location.hash.substring(1);
		
		$('.app__content').load(load_url, {page : page_content, 'keyword' : keyword, 'type' : type, 'p' : p}, function(){
		});
	})


	// 删除茶会
	$('.js-delete').live("click", function(e){
		var pigcms_id = $(this).attr('data-id');
        button_box($(this), e, 'left', 'confirm', '确定删除？', function(){
            $.post(events_del_url, {'pigcms_id': pigcms_id}, function(data){
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

	//回车提交搜索
	$(window).keydown(function(event){
		if (event.keyCode == 13 && $('.js-present-keyword').is(':focus')) {
			var keyword = $('.js-present-keyword').val();
			var type = window.location.hash.substring(1);
			
			$('.app__content').load(load_url, {page : page_content, 'keyword' : keyword, 'type' : type}, function(){
			});
		}
	})
})

function loadProduct(group_id, type, title, page) {
	load_page(".js_select_goods_loading", load_url, {"page" : page_product_list, "group_id" : group_id, "type" : type, "title" : title, "p" : page}, '', function() {
		checkProductStatus();
	});
}

// 检查已经设置为茶会，更改状态
function checkProductStatus() {
	var product_id = '';
	$(".js-show-present").find(".current-present").each(function () {
		product_id = $(this).data('product_id');
		try {
			$("#js-add-reward-" + product_id).html("已设为茶会");
			$("#js-add-reward-" + product_id).removeClass("btn-primary");
		} catch (e) {
			
		}
	});
}

// 
function msg_hide() {
	$('.notifications').html('');
	clearTimeout(t);
}

function allnumLimit(obj) {
	obj.value = obj.value.replace(/[^0-9]/g, '');
}
var t;
$(function() {
	location_page(location.hash);
	$('a.js-load-page').live('click', function() {
		try {
			var mark_arr = $(this).attr("href").split("#");
			location_page("#" + mark_arr[1]);
		} catch (e) {
			location_page(location.hash);
		}
	});

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


		$.post(events_add_url, formObj, function(result) {
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
		$.post(events_edit_url, formObj, function(result) {
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
})

function msg_hide() {
	$('.notifications').html('');
	clearTimeout(t);
}