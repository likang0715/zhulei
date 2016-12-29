/**
 * Created by pigcms-s on 2015/06/16.
 */
var reward_condition_html = "";
$(function() {
	location_page(location.hash);
	$('.ui-nav-table a').live('click',function(){
		$(".ui-nav-table li").removeClass("active");
		$(this).closest("li").addClass("active");
		
		if($(this).attr('href') && $(this).attr('href').substr(0,1) == '#') {
			location_page($(this).attr('href'));
		}
	});

	function location_page(mark, page) {
		var mark_arr = mark.split('/');
		switch(mark_arr[0]){
			case '#setting':
				$(".js-list-filter-region").find("li").removeClass("active");
				$(".js-list-filter-region").find("li").eq(1).addClass("active");
				load_page('.app__content', load_url , {page : 'setting'}, '', function () {
					
				});
				break;
			default :
				load_page('.app__content', load_url, {page : 'content_list'}, '', function() {
					
				});
				break;
		}
	}
	
	$(".js-pay_agent-status").click(function () {
		var obj = $(this);
		if ($(this).hasClass('ui-switch-off')) {
			var status = 1;
			var oldClassName = 'ui-switch-off';
			var className = 'ui-switch-on';
		} else {
			var status = 0;
			var oldClassName = 'ui-switch-on';
			var className = 'ui-switch-off';
		}
		
		$.post(pay_agent_url, {'status': status}, function(data){
			if(!data.err_code) {
				$(obj).removeClass(oldClassName);
				$(obj).addClass(className);
			}
		})
	});
	
	$(".js-fetchtxt-add").live("click", function () {
		var html = '<div class="modal-backdrop fade in"></div>';
		html += '<div class="js-modal modal fade hide in" aria-hidden="false" style="margin-top: -1000px; display: block;">\
					<form class="js-form form-horizontal" novalidate="novalidate" method="post">\
						<div class="modal-header">\
							<a class="close" data-dismiss="modal">×</a>\
							<h3 class="title">添加</h3>\
						</div>\
						<div class="modal-body">\
						  <div class="control-group">\
								<label class="control-label">发起人的求助：</label>\
								<div class="controls">\
									<textarea name="content" cols="20" rows="2" class="span6" placeholder="最多可支持200个字" maxlength="200" style="height:120px; width:360px;"></textarea>\
								</div>\
							</div>\
						</div>\
						<div class="modal-footer">\
							<div class="pull-left" style="margin-left: 130px;">\
								<button type="button" class="ui-btn ui-btn-primary js-save">保存</button>\
							</div>\
						</div>\
					</form>\
				</div>';
		$('body').append(html);
		$("textarea[name='content']").focus();
		$('.modal').animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow");
	});
	
	$('.modal-header > .close').live('click', function(){
		$('.modal').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow",function(){
			$('.modal-backdrop,.modal').remove();
		});
	})
	
	$(".js-save").live("click", function () {
		var content = $("textarea[name='content']").val();
		if (content.length == 0) {
			$("textarea[name='content']").focus();
			layer_tips(1, "请输入发起人的求助内容。");
			return;
		}
		
		var id = $("input[name='id']").val();
		$.post(content_url, {"id" : id, "content" : content}, function (result) {
			if (result.err_code == "0") {
				$('.modal').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow",function(){
					$('.modal-backdrop,.modal').remove();
				});
				
				layer_tips(0, result.err_msg);
				if (typeof id == "undefined") {
					id = result.err_dom;
					var html = '<tr class="js-peerpay_fetchtxt-detail js-id-' + id + '" data-id="' + id + '">\
									<td>' + content + '</td>\
									<td class="text-right js-operate" data-id="' + id + '">\
										<a href="javascript:void(0)" class="js-edit">编辑资料</a>\
										<span>-</span>\
										<a href="javascript:void(0);" class="js-delete">删除</a>\
									</td>\
								</tr>';
					$(".js-list-body-region").prepend(html);
				} else {
					var html = '<td>' + content + '</td>\
								<td class="text-right js-operate" data-id="' + id + '">\
									<a href="javascript:void(0)" class="js-edit">编辑资料</a>\
									<span>-</span>\
									<a href="javascript:void(0);" class="js-delete">删除</a>\
								</td>';
					$(".js-id-" + id).html(html);
				}
			} else {
				layer_tips(1, result.err_msg);
			}
		})
	});
	
	$(".js-edit").live("click", function () {
		var id = $(this).closest("tr").data("id");
		var content = $(this).closest("tr").find("td").html();
		var html = '<div class="modal-backdrop fade in"></div>';
		html += '<div class="js-modal modal fade hide in" aria-hidden="false" style="margin-top: -1000px; display: block;">\
					<form class="js-form form-horizontal" novalidate="novalidate" method="post">\
						<div class="modal-header">\
							<a class="close" data-dismiss="modal">×</a>\
							<h3 class="title">修改</h3>\
						</div>\
						<div class="modal-body">\
						  <div class="control-group">\
								<label class="control-label">发起人的求助：</label>\
								<div class="controls">\
									<textarea name="content" cols="20" rows="2" class="span6" placeholder="最多可支持200个字" maxlength="200" style="height:120px; width:360px;">' + content + '</textarea>\
								</div>\
							</div>\
						</div>\
						<div class="modal-footer">\
							<div class="pull-left" style="margin-left: 130px;">\
								<input type="hidden" name="id" value="' + id  + '" />\
								<button type="button" class="ui-btn ui-btn-primary js-save">保存</button>\
							</div>\
						</div>\
					</form>\
				</div>';
		$('body').append(html);
		$("textarea[name='content']").focus();
		$('.modal').animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow");
	});
	
	$('.js-delete').live("click", function(e){
		var delete_obj = $(this);
		var id = $(this).closest("tr").data('id');
		$('.js-delete').addClass('active');
		button_box($(this), e, 'left', 'confirm', '确认删除？', function(){
			$.get(fetchtxt_delete_url, {'id': id}, function(result) {
				close_button_box();
				layer_tips(0, result.err_msg);
				
				$(".js-id-" + id).remove();
			})
		});
	});
	
	$(".js-modify-img").live("click", function () {
			upload_pic_box(1,true,function(pic_list){
				if(pic_list.length > 0){
					for(var i in pic_list){
						$(".js-set-img").attr("src", pic_list[i]);
						$(".js-set-img").css("display", "block");
						
						$(".page-peerpay").css("background-image", "url(" + pic_list[i] + ")");
						$(".page-peerpay").css({"background-repeat" : "no-repeat", "background-position" : "center center", "background-size" : "cover"});
						break;
					}
					
					$(".set-img").html('<a href="javascript:void(0)" class="font-size-12 js-modify-img">选择图片</a>');
				}
			}, 1);
	});
	
	$(".js-delete-img").live("click", function () {
		$(".js-set-img").attr("src", "");
		$(".js-set-img").css("display", "none");
		
		$(".page-peerpay").attr("style", "");
		$(".page-peerpay").attr("style", "background-color:#a0bf54");
		
		$(".set-img").html('<a href="javascript:void(0)" class="font-size-12 js-modify-img">修改</a> | <a href="javascript:void(0)" class="font-size-12 js-delete-img">删除</a>');
	});
	
	$(".js-reset-color").live("click", function () {
		$(".js-change-color").val("#000000");
		$(".js-change-color").trigger("change");
	});
	
	$(".js-change-color").live("change", function () {
		var color = $(this).val();
		$(".get-pay-text").css("color", color);
		$(".watting-text").css("color", color);
	});
	
	$(".js-btn-save").live("click", function () {
		var img = $(".js-set-img").attr("src");
		var color = $(".js-change-color").val();
		
		$.post(setting_save_url, {img : img, color : color}, function (result) {
			if (result.err_code == "0") {
				layer_tips(0, result.err_msg);
			} else {
				layer_tips(1, result.err_msg);
			}
		})
	})
});
