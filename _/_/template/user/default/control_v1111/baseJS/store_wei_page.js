/**
 * Created by pigcms_21 on 2015/2/6.
 */
var pageCategory = {};
var subtype_used_id = [];
var tmp_subtype_selected_id = [];

$(function() {
	refresh_pageCategory();
	location_page(location.hash);
	$('a').live('click', function() {
		if ($(this).attr('href') && $(this).attr('href').substr(0, 1) == '#') location_page($(this).attr('href'), $(this));
	});
	//微页面封面图
	$('.js-choose-bg').live('click', function() {
		var dom = $(this);
		upload_pic_box(1, true, function(pic_list) {
			for (var i in pic_list) {
				dom.siblings('img').attr('src', pic_list[i]);
				$('.custom-level-img').attr('src', pic_list[i]);
				defaultFieldObj.data('thumb', pic_list[i]);
			}
		}, 1);
	});

	function location_page(mark, dom) {
		var mark_arr = mark.split('/');
		switch (mark_arr[0]) {
			case '#create':
				load_page('.app__content', load_url, {
					page: 'wei_page_create',
					page_id: mark_arr[1]
				}, '', function() {
					if (mark_arr[1] > 0) {
						var editDataDom = $('#edit_data');
						$('.js-config-region .app-field').data({
							'page_id': editDataDom.attr('page-id'),
							'page_name': editDataDom.attr('page-name'),
							'page_desc': editDataDom.attr('page-desc'),
							'show_head': editDataDom.attr('show_head'),
							'show_footer': editDataDom.attr('show_footer'),
							'bgcolor': editDataDom.attr('bgcolor'),
							'cat_ids': editDataDom.attr('cat-ids')
						});
						$('.js-config-region h1 span').html(editDataDom.attr('page-name'));
						page_create(0, 0);
						customField.setHtml($('#edit_custom').attr('custom-field'));
						$('#edit_data,#edit_custom').remove();
					} else {
						page_create(1, 0);
					}
				});
				break;
			case "#edit":
				load_page('.app__content', load_url, {
					page: 'wei_page_edit',
					page_id: mark_arr[1]
				}, '', function() {
					var editDataDom = $('#edit_data');
					$('.js-config-region .app-field').data({
						'page_id': editDataDom.attr('page-id'),
						'page_name': editDataDom.attr('page-name'),
						'page_desc': editDataDom.attr('page-desc'),
						'show_head': editDataDom.attr('show_head'),
						'show_footer': editDataDom.attr('show_footer'),
						'bgcolor': editDataDom.attr('bgcolor'),
						'thumb': editDataDom.attr('thumb'),
						'cat_ids': editDataDom.attr('cat-ids')
					});
					$('.js-config-region h1 span').html(editDataDom.attr('page-name'));
					page_create(0, 1);
					customField.setHtml($('#edit_custom').attr('custom-field'));
					$('#edit_data,#edit_custom').remove();
				});
				break;
			default:
				load_page('.app__content', load_url, {
					page: 'wei_page_content'
				}, '');
		}
	}

	//刷新微页面分类
	function refresh_pageCategory() {
		$.post(get_pageCategory_url, function(result) {
			if (result.err_code == 0) {
				pageCategory = result.err_msg;
			}
			//console.log(get_pageCategory_url);
		});
	}

	function page_create(emptyData, save) {
		defaultFieldObj = $('.js-config-region .app-field');
		if (emptyData == 1) defaultFieldObj.data({
			'page_id': '0',
			'page_name': '微页面标题',
			'page_desc': '',
			'show_head': '1',
			'show_footer': '1',
			'bgcolor': '',
			'thumb': '',
			'cat_ids': ''
		});
		defaultFieldObj.click(function() {
			$('.app-entry .app-field').removeClass('editing');
			$(this).addClass('editing');
			//var rightHtml = $('<div><form class="form-horizontal"><div class="control-group"><label class="control-label"><em class="required">*</em>页面名称：</label><div class="controls"><input class="input-xxlarge" type="text" name="title" value="微页面标题"/></div></div><div class="control-group"><label class="control-label">页面描述：</label><div class="controls"><input class="input-xxlarge" type="text" name="description" value="" placeholder="用户通过微信分享给朋友时，会自动显示页面描述"></div></div><div class="control-group"><label class="control-label">分类：</label><div class="controls"><div class="chosen-container chosen-container-multi" style="width:220px;"><ul class="chosen-choices"><li class="search-field"><input type="text" value="选择微页面分类" class="default" autocomplete="off" style="width:0px;"/></li></ul><div class="chosen-drop"><ul class="chosen-results"></ul></div></div>&nbsp;&nbsp;<p class="help-inline"><a class="js-refresh-category" href="javascript:void(0);">刷新</a>&nbsp;<span>|</span>&nbsp;<a class="new_window" target="_blank" href="'+add_pageCategory_url+'">+新建</a></p></div></div><div class="control-group"><label class="control-label">背景颜色：</label><div class="controls"><input type="color" value="#f9f9f9" name="color"/> <button class="btn js-reset-bg" type="button">重置</button><p class="help-desc">背景颜色只在手机端显示。</p></div></div></form></div>');

			var rightHtmls = '<div><form class="form-horizontal">';
			rightHtmls += '<div class="control-group">';
			rightHtmls += '	<label class="control-label"><em class="required">*</em>页面名称：</label>';
			rightHtmls += '	<div class="controls"><input class="input-xxlarge" type="text" name="title" value="微页面标题"/></div>';
			rightHtmls += '</div>';
			rightHtmls += '<div class="control-group">';
			rightHtmls += '	<label class="control-label">页面描述：</label>';
			rightHtmls += '	<div class="controls"><input class="input-xxlarge" type="text" name="description" value="" placeholder="用户通过微信分享给朋友时，会自动显示页面描述"></div>';
			rightHtmls += '</div>';
			rightHtmls += '<div class="control-group">';
			rightHtmls += '	<label class="control-label">显示设置：</label>';
			rightHtmls += '	<div class="controls"><input class="input-xxlarge" type="checkbox" name="show_head" checked="checked" value="1"> 显示头部&#12288;&#12288;<input class="input-xxlarge" type="checkbox" checked="checked" name="show_footer" value="1"> 显示底部</div>';
			rightHtmls += '</div>';
			if (is_adminuser == 1) {
				rightHtmls += '<div class="control-group">'
				rightHtmls += '	<label class="control-label">封面图：</label>'
				rightHtmls += '	<div class="controls">'
				rightHtmls += '		<img class="page_thumb" src="../images/demo_thumb.jpg" width="120" height="160">&nbsp;&nbsp;&nbsp;'
				rightHtmls += '		<a class="js-choose-bg control-action" href="javascript: void(0);">修改封面图</a>'
				rightHtmls += '		<p class="help-block">建议尺寸：240 x 320 像素</p>'
				rightHtmls += '	</div>'
				rightHtmls += '</div>'
			}
			rightHtmls += '<div class="control-group">';
			rightHtmls += '	<label class="control-label">分类：</label>';
			rightHtmls += '	<div class="controls"><div class="chosen-container chosen-container-multi" style="width:220px;"><ul class="chosen-choices"><li class="search-field"><input type="text" value="选择微页面分类" class="default" autocomplete="off" style="width:100%;"/></li></ul><div class="chosen-drop"><ul class="chosen-results"></ul></div></div>&nbsp;&nbsp;<p class="help-inline"><a class="js-refresh-category" href="javascript:void(0);">刷新</a>&nbsp;<span>|</span>&nbsp;<a class="new_window" target="_blank" href="' + add_pageCategory_url + '">+新建</a></p></div>';
			rightHtmls += '</div>';

			rightHtmls += '<div class="control-group"><label class="control-label">背景颜色：</label><div class="controls"><input type="color" value="#f9f9f9" name="color"/> <button class="btn js-reset-bg" type="button">重置</button><p class="help-desc">背景颜色只在手机端显示。</p></div></div></form></div>';

			var rightHtml = $(rightHtmls);

			//分类名
			rightHtml.find('input[name="title"]').val(defaultFieldObj.data('page_name')).blur(function() {
				var val = $(this).val();
				if (val.length == 0 || val.length > 50) {
					layer_tips(1, '页面名称不能少于一个字或者多于50个字');
				}
				if (val.length == 0) {
					defaultFieldObj.data('page_name', '');
					$('.js-config-region h1 span').empty();
				} else {
					defaultFieldObj.data('page_name', val);
					$('.js-config-region h1 span').html(val);
				}
			});
			//页面描述
			rightHtml.find('input[name="description"]').val(defaultFieldObj.data('page_desc')).blur(function() {
				defaultFieldObj.data('page_desc', $(this).val());
			});
			// 封面图
			rightHtml.find('.controls img.page_thumb').attr('src', defaultFieldObj.data('thumb')?defaultFieldObj.data('thumb'):'../images/demo_thumb.jpg');
			if (defaultFieldObj.data('show_head') == 1) {
				rightHtml.find('input[name="show_head"]').attr("checked", true);
			} else {
				rightHtml.find('input[name="show_head"]').attr("checked", false);
			}

			if (defaultFieldObj.data('show_footer') == 1) {
				rightHtml.find('input[name="show_footer"]').attr("checked", true);
			} else {
				rightHtml.find('input[name="show_footer"]').attr("checked", false);
			}

			//显示头部配置
			rightHtml.find('input[name="show_head"]').val(defaultFieldObj.data('show_head')).change(function() {

				if ($(this).is(":checked")) {
					val_show_head = 1;
				} else {
					val_show_head = 0;
				}
				defaultFieldObj.data('show_head', val_show_head);
			});
			//显示尾部位置
			rightHtml.find('input[name="show_footer"]').val(defaultFieldObj.data('show_footer')).change(function() {
				if ($(this).is(":checked")) {
					var_show_footer = 1;
				} else {
					var_show_footer = 0;
				}
				defaultFieldObj.data('show_footer', var_show_footer);
			});

			rightHtml.find('input[name="color"]').val((defaultFieldObj.data('bgcolor') == '' ? '#ffffff' : defaultFieldObj.data('bgcolor'))).change(function() {
				defaultFieldObj.data('bgcolor', $(this).val());
			});
			rightHtml.find('.js-reset-bg').click(function() {
				$(this).siblings('input[name="color"]').val('#ffffff');
				defaultFieldObj.data('bgcolor', '');
			});
			if (defaultFieldObj.data('cat_ids') != '') {
				var catIdArr = defaultFieldObj.data('cat_ids').split(',');
				var chosen_results = '';
				$.each(pageCategory, function(i, item) {
					if ($.inArray(item.cat_id, catIdArr) != -1) {
						chosen_results += '<li class="search-choice" data-id="' + item.cat_id + '"><span>' + item.cat_name + '</span><a class="search-choice-close"></a></li>';
					}
				});
				rightHtml.find('.chosen-container-multi .chosen-choices').prepend(chosen_results);
			}
			//选择分类
			rightHtml.find('.chosen-container-multi').click(function(event) {
				event.stopPropagation();
				$(this).addClass('chosen-with-drop chosen-container-active').find('.search-field .default').val('');
				var chosen_results = '';
				var choice_has_arr = [];
				$.each($(this).find('.search-choice'), function(i, item) {
					choice_has_arr.push($(item).attr('data-id'));
				});
				$.each(pageCategory, function(i, item) {
					if ($.inArray(item.cat_id, choice_has_arr) == -1) {
						chosen_results += '<li class="active-result" data-id="' + item.cat_id + '">' + item.cat_name + '</li>';
					}
				});
				$(this).find('.chosen-results').html(chosen_results).find('li:first').addClass('highlighted');

				$(this).find('.chosen-results .active-result').click(function() {
					var choicesDom = $(this).closest('.chosen-container').find('.chosen-choices');
					var choiceHtml = '<li class="search-choice" data-id="' + ($(this).attr('data-id')) + '"><span>' + ($(this).html()) + '</span><a class="search-choice-close"></a></li>';
					if (choicesDom.find('.search-choice').size() > 0) {
						choicesDom.find('.search-choice:last').after(choiceHtml);
					} else {
						choicesDom.html(choiceHtml);
					}
					var cat_ids = '';
					$.each($(this).closest('.chosen-container').find('.search-choice'), function(i, item) {
						cat_ids += $(item).attr('data-id') + ',';
					});
					defaultFieldObj.data('cat_ids', cat_ids);
				});
				$(this).find('.search-choice-close').click(function(ee) {
					ee.stopPropagation();
					var box = $(this).closest('.chosen-choices');
					$(this).closest('li').remove();
					var cat_ids = '';
					$.each(rightHtml.find('.search-choice'), function(i, item) {
						cat_ids += $(item).attr('data-id') + ',';
					});
					defaultFieldObj.data('cat_ids', cat_ids);
					if (box.find('.search-choice').size()==0) {
						box.html('<li class="search-field"><input type="text" value="选择微页面分类" class="default" autocomplete="off" style="width: 100%;color: #666!important;"></li>')
					};
					box.closest('.chosen-container-multi').click()
				});

				$('body').bind('click', function() {
					rightHtml.find('.chosen-container-multi').removeClass('chosen-with-drop chosen-container-active');
				});
			});
			rightHtml.find('.js-refresh-category').click(function() {
				refresh_pageCategory();
			});
			$('.js-sidebar-region').html(rightHtml);
			$('.app-sidebar').css('margin-top', $(this).offset().top - $('.js-app-main').offset().top);
		});
		defaultFieldObj.trigger('click');
		customField.init();

		$('.form-actions .btn-save').live('click', function() {
			var post_data = {};
			post_data.page_id = defaultFieldObj.data('page_id');
			post_data.page_name = defaultFieldObj.data('page_name');
			if (post_data.page_name.length == 0 || post_data.page_name.length > 50) {
				layer_tips(1, '页面名称不能少于一个字或者多于50个字');
				defaultFieldObj.trigger('click');
				return false;
			}
			post_data.show_head = defaultFieldObj.data('show_head');
			post_data.show_footer = defaultFieldObj.data('show_footer');
			post_data.page_desc = defaultFieldObj.data('page_desc');
			post_data.bgcolor = defaultFieldObj.data('bgcolor');
			post_data.thumb = defaultFieldObj.data('thumb');
			post_data.cat_ids = defaultFieldObj.data('cat_ids');
			post_data.custom = customField.checkEvent();
			for (var i in post_data.custom) {
				if (post_data.custom[i].type == "coupons" && obj2String(post_data.custom[i].coupon_arr) == "{}") {
					layer_tips(1, '请填加优惠券');
					return;
				}
				if (post_data.custom[i].type == "activity_module" && obj2String(post_data.custom[i].activity_arr) == "{}") {
					layer_tips(1, '请添加活动');
					return;
				}
				if (post_data.custom[i].type == "new_activity_module" && obj2String(post_data.custom[i].activity_arr) == "{}") {
					layer_tips(1, '您的微页面中存在一个空的活动板块，请填充或删除后再保存！');
					return;
				}
				if (post_data.custom[i].type == "article" && obj2String(post_data.custom[i].activity_arr) == "{}") {
					layer_tips(1, '您的微页面中存在一个空的店铺动态板块，请填充或删除后再保存！');
					return;
				}
				if (post_data.custom[i].type == "article") {
					var article_count = 0;
					var article_data = post_data.custom[i];
					if ('activity_arr' in article_data) {
						$.each(article_data.activity_arr, function(ii, vv) {
							article_count = article_count + 1;
						});
					} else {
						article_count = article_data.length;
					}
					if (article_count > 6) {
						layer_tips(1, '最多只能添加6条动态');
						return;
					}
				}
				//微页面头部 替换店铺logo
				if (post_data.custom[i].type == "tpl_shop" || post_data.custom[i].type == "tpl_shop1") {
					if (post_data.custom[i].shop_head_logo_img) {
						var post_logo = post_data.custom[i].shop_head_logo_img;
						if (typeof(update_storelogo_url) == "undefined") {
							layer_tips(1, '操作异常');
							return;
						}
						$.post(update_storelogo_url, {
							'store_logo': post_logo
						}, function(result) {});
					}
				}

			}

			if (post_data.custom.length == 0) {
				layer_tips(1, '请给页面先添加一些内容再保存嘛');
				return false;
			}
			console.log(post_data.custom)
			var cat_post_url = save == 0 ? add_url : edit_url;
			$.post(cat_post_url, post_data, function(result) {
				if (result.err_code == 0) {
					layer_tips(0, result.err_msg);
					if (save == 0) {
						location.hash = '#list';
					}
					location.reload();
				} else {
					layer_tips(1, result.err_msg);
				}
			});
		});
	}

	var defaultHtmlObj = function() {
		return '<div><form class="form-horizontal"><div class="control-group"><label class="control-label"><em class="required">*</em>页面名称：</label><div class="controls"><input class="input-xxlarge" type="text" name="title" value="微页面标题"/></div></div><div class="control-group"><label class="control-label">页面描述：</label><div class="controls"><input class="input-xxlarge" type="text" name="description" value="" placeholder="用户通过微信分享给朋友时，会自动显示页面描述"></div></div><div class="control-group"><label class="control-label">分类：</label><div class="controls"><div class="chosen-container chosen-container-multi" style="width:220px;"><ul class="chosen-choices"><li class="search-field"><input type="text" value="选择微页面分类" class="default" autocomplete="off" style="width:0px;"/></li></ul><div class="chosen-drop"><ul class="chosen-results"></ul></div></div>&nbsp;&nbsp;<p class="help-inline"><a class="js-refresh-category" href="javascript:void(0);">刷新</a>&nbsp;<span>|</span>&nbsp;<a class="new_window" target="_blank" href="' + add_pageCategory_url + '">+新建</a></p></div></div><div class="control-group"><label class="control-label">背景颜色：</label><div class="controls"><input type="color" value="#f9f9f9" name="color"/> <button class="btn js-reset-bg" type="button">重置</button><p class="help-desc">背景颜色只在手机端显示。</p></div></div></form></div>';
	};

	$('.homepage-box .js-copy-link').live('click', function(e) {
		var dom = $(this);
		button_box(dom, e, 'left', 'copy', dom.attr('copy-link'));
	});

	$('.js-list-body-region .js-delete').live('click', function(e) {
		var dom = $(this);
		button_box(dom, e, 'left', 'confirm', '确定删除？', function() {
			$.post(delete_url, {
				page_id: dom.closest('tr').attr('page-id')
			}, function(result) {
				if (result.err_code == 0) {
					layer_tips(0, result.err_msg);
					dom.closest('tr').remove();
				} else {
					layer_tips(1, result.err_msg);
				}
			});
			close_button_box();
		});
	});

	//预览
	$(".js-list-body-region .js_show_ewm").live("click", function(e) {
		event.stopPropagation();
		var dom = $(this);
		var dom_offset = dom.offset();
		var ewm_type = dom.data("ewm_type");
		var qrcode_url = "";
		var id = dom.data("store_id");
		if (ewm_type) {
			qrcode_url = siteurl + "/source/qrcode.php?type=" + ewm_type + "&id=" + id;
		}

		var htmls = "";
		htmls += '<div class="popover bottom" style="">';
		htmls += '	<div class="arrow"></div>';
		htmls += '	<div style="width:120px;" class="popover-inner">';
		htmls += '		<div class="popover-content">';
		htmls += '			<div class="form-inline">';
		htmls += '				<div class="input-append"><img width="100" height="100" src="' + qrcode_url + '"></div>';
		htmls += '			</div>';
		htmls += '		</div>';
		htmls += '	</div>';
		htmls += '</div>';
		$('body').append(htmls);

		var popover_height = $('.popover').height();
		var popover_width = $('.popover').width();

		$('.popover').css({
			top: dom_offset.top + dom.height() - 3,
			left: dom_offset.left - (popover_width / 2) + (dom.width() / 2)
		});

		$('.popover').click(function(e) {
			e.stopPropagation();
		});

		$('body').bind('click', function() {
			$(".popover").remove();
		});
	})

	//选择专题
	$('.area-editor-list-title').live('click', function() {
		if ($(this).hasClass('area-editor-list-select')) {
			$(this).removeClass('area-editor-list-select');
		} else {
			$(this).addClass('area-editor-list-select');
		}
	});

	$('.js-list-body-region .js-copy-link').live('click', function(e) {
		var dom = $(this);
		button_box(dom, e, 'left', 'copy', dom.attr('copy-link'));
	});
	$('.js-list-body-region .js-set-as-homepage').live('click', function(e) {
		$.post(set_home_url, {
			page_id: $(this).closest('tr').attr('page-id')
		}, function(result) {
			if (result.err_code == 0) {
				layer_tips(0, result.err_msg);
				load_page('.app__content', load_url, {
					page: 'wei_page_content',
					p: $('.js-page-list .active').attr('data-page-num')
				}, '');
			} else {
				layer_tips(1, result.err_msg);
			}
		});
	});

	var qrcode_timer = null;
	$('.js-help-notes').live('mouseenter mouseleave', function(e) {
		if (e.type == 'mouseenter') {
			if ($('.js-intro-popover.homepage-qrcode').size() > 0) {
				$('.js-intro-popover.homepage-qrcode').show();
			} else {
				$('body').append('<div class="js-intro-popover popover popover-intro bottom center homepage-qrcode" style="display:top;top:' + ($('.js-help-notes').offset().top + $('.js-help-notes').height() + 5) + 'px;left:' + ($('.js-help-notes').offset().left + ($('.js-help-notes').width() / 2) - 95) + 'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content">' + ($('.js-notes-cont').html()) + '</div></div></div>');
			}
		} else {
			qrcode_timer = setTimeout(function() {
				$('.js-intro-popover.homepage-qrcode').hide();
			}, 100);
		}
	});
	$('.js-intro-popover.homepage-qrcode').live('mouseenter mouseleave', function(e) {
		if (e.type == 'mouseenter') {
			clearTimeout(qrcode_timer);
		} else {
			$(this).hide();
		}
	});

	$('.js-page-list a').live('click', function(e) {
		if (!$(this).hasClass('active')) {
			load_page('.app__content', load_url, {
				page: 'wei_page_content',
				p: $(this).attr('data-page-num')
			}, '');
		}
	});
})