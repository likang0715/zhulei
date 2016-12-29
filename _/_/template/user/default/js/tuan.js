/**
 * Created by ediancha on 2016/8/9.
 */
function location_page(mark) {
	var mark_arr = mark.split('/');
	switch(mark_arr[0]){
		case '#create' :
			load_page('.app__content', load_url, {page : 'create'}, '', function() {
				
			});
			break;
		case '#edit' :
			var tuan_id = mark_arr[1];
			load_page('.app__content', load_url, {page : 'edit', tuan_id : tuan_id}, '', function() {
				
			});
			break;
		case '#info' :
			var tuan_id = mark_arr[1];
			load_page('.app__content', load_url, {page : 'info', tuan_id : tuan_id}, '', function() {
				load_page('.js-tuan_team_list', load_url, {page : 'team', tuan_id : tuan_id}, '', function () {
					if ($(".js-tuan_team_list .js-tuan_team").size() > 0) {
						var team_id = $(".js-tuan_team_list .js-tuan_team").eq(0).data("team_id");
						load_page('.tuan_order_list', load_url, {page: 'order', tuan_id: tuan_id, team_id: team_id}, '', function () {
							
						});
					}
				});
			});
			break;
		default :
			var type = mark.substr(1);
			load_page('.app__content', load_url, {page : 'tuan_list', type : type}, '', function() {
				
			});
			break;
	}
}
var hash;
$(function() {
	var is_reload = true;
	location_page(location.hash);
	$('.ui-nav-table a').live('click',function(){
		$(".ui-nav-table li").removeClass("active");
		$(this).closest("li").addClass("active");
		
		if($(this).attr('href') && $(this).attr('href').substr(0, 1) == '#') {
			hash = $(this).attr('href');
			
			if (is_reload) {
				location_page($(this).attr('href'));
				is_reload = false;
			}
		}
	});
	
	$(window).bind('hashchange', function() {
		location_page(location.hash);
	})
	
	
	$(".js-list_page a").live("click", function () {
		var page = $(this).data("page-num");
		var keyword = $(".js-list-search").data("keyword");
		var type = $(".js-list-search").data("type");
		
		load_page('.app__content', load_url, {page : 'tuan_list', type : type, keyword : keyword, p : page}, '', function() {
			
		});
	});
	
	$(window).keydown(function(event){
		if (event.keyCode == 13 && $('.ui-search-box .txt').is(':focus')) {
			var keyword = $(".js-tuan-keyword").val();
			var type = $(".js-list-search").data("type");
			
			load_page('.app__content', load_url, {page : 'tuan_list', type : type, keyword : keyword}, '', function() {
				is_reload = true;
			});
		}
	})
	
	// 复制链接
	$(".js-copy-link").live("click", function (e) {
		var tuan_id = $(this).data("id");
		button_box($(this),e,'left','copy', tuan_wap_url + "details/" + tuan_id, function(){
			layer_tips(0,'复制成功');
		});
	});
	
	$(".js-team_link").live("click", function (e) {
		var tuan_id = $(this).data("tuan_id");
		var type = $(this).data("type");
		var item_id = $(this).data("item_id");
		var team_id = $(this).data("team_id");
		
		button_box($(this),e,'left','copy', tuan_wap_url + "detailinfo/" + tuan_id + "/" + type + "/" + item_id + "/" + team_id, function(){
			layer_tips(0,'复制成功');
		});
	});
	
	$(".js_show_ewm").live("click",function(e) {
		event.stopPropagation();
		var dom = $(this);
		var dom_offset = dom.offset();
		
		var id = dom.data("id");
		var qrcode_url = tuan_qrcode_url + "tuan&id=" + id;
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
		
		$('.popover').css({top: dom_offset.top+dom.height()-3, left: dom_offset.left - (popover_width/2) + (dom.width()/2)});
		
		$('.popover').click(function(e) {
			e.stopPropagation();
		});
		
		$('body').bind('click',function() {
			$(".popover").remove();
		});
	});
	
	$(".js_team_show_ewm").live("click", function () {
		event.stopPropagation();
		var dom = $(this);
		var dom_offset = dom.offset();
		
		var team_id = dom.data("team_id");
		var qrcode_url = tuan_qrcode_url + "tuan_team&id=" + team_id;
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
		
		$('.popover').css({top: dom_offset.top+dom.height()-3, left: dom_offset.left - (popover_width/2) + (dom.width()/2)});
		
		$('.popover').click(function(e) {
			e.stopPropagation();
		});
		
		$('body').bind('click',function() {
			$(".popover").remove();
		});
	});
	
	$(".js-disabled").live("click", function (e) {
		var tuan_id = $(this).closest("td").data("tuan_id");
		button_box($(this), e, 'left', 'confirm', '此操作将会将已产生的订单改为退货，<br />确认将此团购改为失效吗？', function(){
			$.get(tuan_disabled_url, {tuan_id : tuan_id}, function (result) {
				if (result.err_code == 0) {
					layer_tips(0, "操作完成");
					location.reload();
				} else {
					layer_tips(1, result.err_message);
				}
			});
		});
	});
	
	
	$(".js-create").live("click", function () {
		if($(this).attr('href') && $(this).attr('href').substr(0, 1) == '#') {
			//location_page($(this).attr('href'));
		}
	});
	
	$(".js-edit").live("click", function () {
		if($(this).attr('href') && $(this).attr('href').substr(0, 1) == '#') {
			//location_page($(this).attr('href'));
		}
	});
	
	// 删除选择的商品
	$(".js-delete-picture").live("click", function () {
		$(this).closest("li").remove();
		$(".js-product").data("product_id", 0);
	});
	
	
	//开始时间
	$('#js-start-time').live('focus', function() {
		var options = {
			numberOfMonths: 2,
			dateFormat: "yy-mm-dd",
			timeFormat: "HH:mm:ss",
			showSecond: true,
			beforeShow: function() {
				if ($('#js-end-time').val() != '') {
					$(this).datepicker('option', 'maxDate', new Date($('#js-end-time').val()));
				}
			},
			onSelect: function() {
				if ($('#js-start-time').val() != '') {
					$('#js-end-time').datepicker('option', 'minDate', new Date($('#js-start-time').val()));
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
			timeFormat: "HH:mm:ss",
			showSecond: true,
			beforeShow: function() {
				if ($('#js-start-time').val() != '') {
					$(this).datepicker('option', 'minDate', new Date($('#js-start-time').val()));
				}
			},
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
	
	$('.js-delete').live("click", function(e){
		var delete_obj = $(this);
		var id = $(this).closest("td").data('tuan_id');
		button_box($(this), e, 'left', 'confirm', '确认删除？', function(){
			$.get(tuan_delete_url, {'id': id}, function(result) {
				close_button_box();
				layer_tips(0, result.err_msg);
				
				location.reload();
			})
		});
	});
	
	$(".js-number").live("blur", function () {
		var number = $(this).val();
		
		if (number.length > 0 && !/^[0-9]*[1-9][0-9]*$/.test(number)) {
			layer_tips(1, '请正确填写达标购买数量！');
			$(this).val('');
			$(this).focus();
		}
	});
	
	$(".js-discount").live("blur", function () {
		var discount = $(this).val();
		if (discount.length == 0) {
			return;
		}
		
		if (discount.length > 0 && !(/^[0-9]{1}[\.]?[0-9]{0,1}$/.test(discount))) {
			layer_tips(1, '请正确填写团购折扣！');
			$(this).val('');
			$(this).focus();
		}
		
		if (discount == 0) {
			layer_tips(1, '请正确填写团购折扣！');
			$(this).val('');
			$(this).focus();
		}
		
		if (discount > 10) {
			layer_tips(1, '请正确填写团购折扣！');
			$(this).val('');
			$(this).focus();
		}
	});
	
	$(".js-start_number").live("blur", function () {
		var start_number = $(this).val();
		
		if (start_number != "0" && start_number.length > 0 && !/^[0-9]*[1-9][0-9]*$/.test(start_number)) {
			layer_tips(1, '请正确填写达标购买数量！');
			$(this).val('');
			$(this).focus();
		}
	});
	
	// 添加团购条件
	var number_arr = [];
	var discount_arr = [];
	var start_number_arr = [];
	$(".js-condition-add").live("click", function () {
		var number = $("input[name='number']").val();
		var discount = $("input[name='discount']").val();
		var start_number = 0;// $("input[name='start_number']").val();
		
		if (number.length == 0) {
			layer_tips(1, '请填写达标购买数量！');
			$("input[name='number']").focus();
			return;
		}
		
		var re = /^[0-9]*[1-9][0-9]*$/; 
		if (!re.test(number)) {
			layer_tips(1, '请正确填写达标购买数量！');
			$("input[name='number']").val('');
			$("input[name='number']").focus();
			return;
		}
		
		var number_is_exists = false;
		$(".js-condition-detail").each(function () {
			if ($(this).find("td").html() == number) {
				number_is_exists = true;
				return false;
			}
		});
		
		if (number_is_exists) {
			layer_tips(1, '此团购规格已经存在');
			$("input[name='number']").focus();
			return;
		}
		
		if (discount.length == 0) {
			layer_tips(1, '请填写团购折扣！');
			$("input[name='discount']").focus();
			return;
		}
		
		if (!/^\d+(\.\d+)?$/.test(discount)) {
			layer_tips(1, '请正确填写团购折扣！');
			$("input[name='discount']").val('');
			$("input[name='discount']").focus();
			return;
		}
		
		/*if (start_number.length == 0) {
			start_number = 0;
			$("input[name='start_number']").val("0");
		} else {
			if (start_number == "0") {
				
			} else if (!/^[0-9]*[1-9][0-9]*$/.test(start_number)) {
				layer_tips(1, '请正确填写参团开始人数！aa');
				$("input[name='start_number']").val('');
				$("input[name='start_number']").focus();
				return;
			}
			
			if (parseInt(start_number) > parseInt(number)) {
				layer_tips(1, '参团开始人数不能大于参团人数！');
				$("input[name='start_number']").focus();
				return;
			}
		}*/
		
		if ($(".js-condition-detail").size() >= 8) {
			layer_tips(1, '开团设置最多可设置8级！');
			return;
		}
		
		
		number_arr[number] = number;
		discount_arr[number] = discount;
		//start_number_arr[number] = start_number;
		
		var html = '';
		html += '<tr class="js-condition js-condition-detail" style="text-align: center;">';
		html += '<td>' + number + '</td>';
		html += '<td>' + discount + '</td>';
		//html += '<td>' + start_number + '</td>';
		html += '<td><a href="javascript:" class="js-condition-delete" data-number="' + number + '">删除</a></td>';
		html += '</tr>';
		
		$(".js-condition-table").append(html);
		
		$("input[name='number']").val("");
		$("input[name='discount']").val("");
		//$("input[name='start_number']").val("");
	});
	
	// 删除团购条件
	$(".js-condition-delete").live("click", function () {
		var number = $(this).data("number");
		$(this).closest("tr").remove();
		delete number_arr[number];
		delete discount_arr[number];
		// delete start_number_arr[number];
	});
	
	widget_link_box1($(".js-add-picture"), 'do_selfgood', function(result){
		var  good_data = pic_list;
		$('.js-goods-list .sort').remove();
		for (var i in result) {
			item = result[i];
			var pic_list = "";
			var list_size = $('.js-product .sort').size();
			if(list_size > 0){
				layer_tips(1, '团购活动商品一次仅能选择一个！');
				return false;
			}
			
			$(".js-product").prepend('<li class="sort" data-pid="' + item.id+'"><a href="' + item.url + '" target="_blank"><img data-pid="' + item.id + '" alt="' + item.title + '" title="' + item.title + '" src="' + item.image + '"></a><a class="js-delete-picture close-modal small hide">×</a></li>');
			$(".js-product").data("product_id", item.id);
		}
	});
	
	// 保存
	$(".js-create-save").live("click", function () {
		var name = $("#name").val();
		var product_id = $(".js-product").data("product_id");
		var start_time = $("#js-start-time").val();
		var end_time = $("#js-end-time").val();
		var description = $("#description").val();
		
		if (name.length == 0) {
			layer_tips(1, "请填写团购名称");
			$("#name").focus();
			return;
		}
		
		if (product_id == "0") {
			layer_tips(1, "请选择团购商品");
			return;
		}
		
		if (start_time.length == 0) {
			layer_tips(1, "请选择开团开始时间");
			return;
		}
		
		if (end_time.length == 0) {
			layer_tips(1, "请选择开团结束时间");
			return;
		}
		
		if ($(".js-condition-detail").size() <= 1) {
			layer_tips(1, "请至少增加一个开团设置");
			$(".js-number").focus();
			return;
		}
		
		var condition = [];
		$(".js-condition-detail").each(function () {
			// condition.push($(this).find("td").eq(0).html() + "_" + $(this).find("td").eq(1).html() + "_" + $(this).find("td").eq(2).html());
			condition.push($(this).find("td").eq(0).html() + "_" + $(this).find("td").eq(1).html());
		});
		
		var data = {name : name, product_id : product_id, start_time : start_time, end_time : end_time, description : description, condition : condition};
		var post_url = tuan_add_url;
		
		if ($("#tuan_id").size() > 0) {
			post_url = tuan_edit_url;
			data.tuan_id = $("#tuan_id").val();
		}
		
		$.post(post_url, data, function (result) {
			if (result.err_code == 0) {
				layer_tips(0, "操作完成");
				location.href = result.err_msg;
			} else {
				layer_tips(1, result.err_msg);
			}
		});
	});
	
	// 取消
	$(".js-btn-quit").live("click", function () {
		location.href = index_url;
	});
	
	/**
	 * 团购订单详情页js
	 */
	$(".js-order_list_page a").live("click", function () {
		var page = $(this).data("page-num");
		var tuan_id = $(".js-tuan_id").data("tuan_id");
		var team_id = $(".js-order_list_page").data("team_id");
		load_page('.tuan_order_list', load_url, {page : 'order', tuan_id : tuan_id, team_id: team_id, p : page}, '', function () {
			
		});
	});
	
	$(".js-team_order").live("click", function () {
		var tuan_id = $(".js-tuan_id").data("tuan_id");
		var team_id = $(this).data("team_id");
		
		load_page('.tuan_order_list', load_url, {page: 'order', tuan_id: tuan_id, team_id: team_id}, '', function () {
			
		});
	});
	
	$(".js-team_list_page a").live("click", function () {
		var page = $(this).data("page-num");
		var tuan_id = $(".js-tuan_id").data("tuan_id");
		load_page('.js-tuan_team_list', load_url, {page : 'team', tuan_id : tuan_id, p : page}, '', function () {
			
		});
	});
	
	// 设置团购未达标
	$(".js-tuan_cancel").live("click", function (e) {
		var tuan_id = $(this).data("tuan_id");
		button_box($(this), e, 'right', 'confirm', '您即将取消此团购，此团所有订单<br />自动进入退货流程,确定此操作吗？', function() {
			$.post(tuan_over_url, {tuan_id: tuan_id, type: 'cancel'}, function (data) {
				close_button_box();
				if (data.err_code == "0") {
					layer_tips(0, data.err_msg);
					location_page(location.hash);
				} else {
					layer_tips(1, data.err_msg);
				}
			}, "json");
		});
	})
	
	$(".js-set_tuan_item").live("click", function (e) {
		var tuan_id = $(this).data("tuan_id");
		var tuan_config_id = $(this).data("tuan_config_id");
		button_box($(this), e, 'left', 'confirm', '操作提示：此级之后的最优开团将自动进入退货流程，<br />小于此级别及人缘开团，可能会产生部分金额退款', function() {
			$.post(tuan_over_url, {tuan_id: tuan_id, tuan_config_id: tuan_config_id}, function (data) {
				close_button_box();
				if (data.err_code == "0") {
					layer_tips(0, data.err_msg);
					location_page(location.hash);
				} else {
					layer_tips(1, data.err_msg);
				}
			}, "json");
		});
	});
	
	$(".js-tuan_over").live("click", function (e) {
		var tuan_id = $(this).data("tuan_id");
		$.post(tuan_over_url, {tuan_id: tuan_id}, function (data) {
			if (data.err_code == "0") {
				layer_tips(0, data.err_msg);
				location_page(location.hash);
			} else {
				layer_tips(1, data.err_msg);
			}
		}, "json");
	});
	
	$(".js-return_order").live("click", function () {
		var order_no = $(this).data("order_no");
		var pigcms_id = $(this).data("pigcms_id");

		$.post(order_load_url, {page: 'order_return_detail', 'order_no': order_no, 'pigcms_id' : pigcms_id}, function(data){
			try {
				if (data.status == true) {
					location.href = "user.php?c=order&a=order_return#detail/" + data.msg;
				}
			} catch(e) {
				layer_tips(1, data);
			}
		}, "json");
	});
	
	// 关闭浮动窗口
	$(".close").live("click", function () {
		$('.modal').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow",function(){
			$('.modal-backdrop,.modal').remove();
		});
	});
});


$(function(){
	// 确认收款
	$(".js-receive-order").live("click", function (e) {
		var order_id = $(this).attr('data-id');
		button_box($(this), e, 'left', 'confirm', '确定收到货款了？', function(){
			$.post(receive_time_url , {'order_id': order_id}, function(data){
				if (!data.err_code) {
					$('.notifications').html('<div class="alert in fade alert-success">确认收款成功</div>');
				} else {
					$('.notifications').html('<div class="alert in fade alert-error">确认收款成功</div>');
				}
				close_button_box();
				$('.ui-nav > ul > .active > a').trigger('click');
			})
		})
	});
	
	//js post
	function js_post(URL, PARAMS) {
		var temp = document.createElement("form");
		temp.target = "_blank";
		temp.action = URL;
		temp.method = "post";
		temp.style.display = "none";
		for (var x in PARAMS) {
		var opt = document.createElement("textarea");
		opt.name = x;
		opt.value = PARAMS[x];
		temp.appendChild(opt);
		}
		document.body.appendChild(temp);
		temp.submit();
	}


	$('.js-stared-it').live('hover', function(){
		if (event.type == 'mouseover') {
			$(this).closest('.m-opts').hide();
			$(this).closest('.m-opts').next('.raty-action').show();
		}
	})

	$('.js-express-goods').live('click', function(){
		$(this).addClass('express-active');
		var order_id = $(this).attr('data-id');
		var address_id = $(this).data('address_id');
		createPackage(order_id, address_id);
	});
	
	// 切换发送收货地址
	$(".js-friend_address").live("change", function () {
		var order_id = $(this).data("order_id");
		var address_id = $(this).val();
		$(".modal-body").html("加载中");
		$(".modal-footer").hide();
		createPackage(order_id, address_id);
	});


	$('.js-company').live('click', function(){
		if ($(this).hasClass('select2-dropdown-open')) {
			$(this).removeClass('select2-dropdown-open');
			$('.select2-display-none').hide();
		} else {
			$(this).addClass('select2-dropdown-open');
			//设置选中状态
			var express_id  = $(this).find('.select2-chosen').attr('data-id');
			$('.select2-results > .select2-results-dept-' + express_id).addClass('select2-highlighted');

			var top = $(this).offset().top + $(this).height() - 2;
			var left = $(this).offset().left;
			$('.select2-display-none').css({'top': top, 'left': left});
			$('.select2-display-none').show();
			$('.select2-input').focus();
		}
	})

	$("input[name='no_express']").live('change', function(){
		if($(this).val() == 1) {
			$('.js-express-info').hide();
			$('.js-physical-info').hide();
		} else if ($(this).val() == 2) {
			$('.js-express-info').hide();
			$('.js-physical-info').show();
		} else {
			$('.js-express-info').show();
			$('.js-physical-info').hide();
		}
	})

	$("select[name='js-physical-select']").live('change', function(){

		var class_name = 'physical_'+$(this).val();
		$(".physical_quantity").hide();
		$("."+class_name+"").show();

		if ($(this).val() != 0) {
			$(this).parents(".control-group:first").removeClass("error");
		}

	});

	$('.select2-results > li').live('hover', function(){
		if (event.type == 'mouseover') {
			$(this).siblings('li').removeClass('select2-highlighted');
			$(this).addClass('select2-highlighted');
		} else {
			$(this).removeClass('select2-highlighted');
		}
	});

	$('.js-check-all').live('click', function(){
		if ($(this).is(':checked')) {
			$('.js-check-item').attr('checked', true);
		} else {
			$('.js-check-item').attr('checked', false);
		}
	});

	$('.js-check-item').live('click', function(){
		if ($(this).is(":checked") && $('.js-check-item').not(':checked').length == 0) {
			$('.js-check-all').attr('checked', true);
		} else {
			$('.js-check-all').attr('checked', false);
		}
	});
	
	$('body').click(function(e){
		var _con = $('.select2-container');	// 设置目标区域
		var _con2 = $('.select2-drop-active');
		if((!_con.is(e.target) && _con.has(e.target).length === 0) && (!_con2.is(e.target) && _con2.has(e.target).length === 0)){ // Mark 1
			$('.js-company').removeClass('select2-dropdown-open');
			$('.select2-display-none').hide();
		}
	})

	//选择快递公司
	$('.select2-results > li').live('click', function(){
		var express_company = $(this).children('.select2-result-label').text();
		var express_id = $(this).attr('data-id');
		if (express_id != 0 && $('.help-desc').next('.error-message').length > 0) {
			$('.help-desc').next('.error-message').remove();
			$('.select2-choice > .select2-chosen').closest('.control-group').removeClass('error');
		}
		$('.select2-choice > .select2-chosen').attr('data-id', express_id);
		$('.select2-choice > .select2-chosen').text(express_company);
		$('.js-company').removeClass('select2-dropdown-open');
		$('.select2-display-none').hide();
	})

	//上下键选择快递公司
	$(".select2-search input").live('keyup', function(e){
		if (event.keyCode == 38 && $('.js-company').hasClass('select2-dropdown-open')) { //向上
			if ($('.select2-highlighted').prev('.select2-result').length > 0) {
				var index = $('.select2-highlighted').index('.select2-result');
				$('.select2-result').eq(index).removeClass('select2-highlighted');
				$('.select2-result').eq(index).prev('.select2-result').addClass('select2-highlighted');
			}
			var scrollTop = $('.select2-results').scrollTop();
			var top = $('.select2-highlighted').position().top;
			if (top == -25) {
				$('.select2-results').scrollTop(scrollTop - 25);
			}
		}
		if (event.keyCode == 40 && $('.js-company').hasClass('select2-dropdown-open')) { //向下
			if ($('.select2-highlighted').next('.select2-result').length > 0) {
				var index = $('.select2-highlighted').index('.select2-result');
				$('.select2-result').eq(index).removeClass('select2-highlighted');
				$('.select2-result').eq(index).next('.select2-result').addClass('select2-highlighted');
			}
			var scrollTop = $('.select2-highlighted').position().top + $('.select2-results').scrollTop();
			if (scrollTop > 175) {
				$('.select2-results').scrollTop((scrollTop - 175));
			}
		}
	})

	$(window).keydown(function(event){
		if (event.keyCode == 13 && $('.select2-highlighted').length && $('.js-company').hasClass('select2-dropdown-open')) {
			var express_id = $('.select2-highlighted').attr('data-id');
			var express_company = $('.select2-highlighted > .select2-result-label').text();
			$('.select2-choice > .select2-chosen').attr('data-id', express_id);
			$('.select2-choice > .select2-chosen').text(express_company);
			$('.js-company').removeClass('select2-dropdown-open');
			$('.select2-display-none').hide();
		}
	})

	//创建包裹
	$('.js-save').live('click', function(){
		if ($('.js-check-item:checked').length == 0) {
			$('.notifications').html('<div class="alert in fade alert-error"><a href="javascript:;" class="close pull-right">×</a>请选择商品</div>');
			t = setTimeout('msg_hide()', 3000);
			return false;
		}
		
		// 检测是否已经有门店配送
		var has_physical_send = false;
		$('.js-check-item:checked').each(function(i){

			var physical_name = $(this).parents("tr:first").find(".physical_name");
			if (physical_name.length > 0) {
				has_physical_send = true;
			}

		});

		if (has_physical_send) {
			$('.notifications').html('<div class="alert in fade alert-error"><a href="javascript:;" class="close pull-right">×</a>不能选择已经分配门店的订单商品</div>');
			t = setTimeout('msg_hide()', 3000);
			flag = false;
			return false;
		}

		var flag			= true;
		var products		= [];
		var order_products  = [];
		var sku_data		= [];
		var express_id	  = '';
		var express_company = '';
		var express_no	  = '';
		// var physical_id = 0;

		if ($(this).data('id') != undefined && $(this).data('id') != null && $(this).data('id') != '') {
			var order_id = $(this).data('id');
		} else {
			var order_id = $('.express-active').attr('data-id');
		}

		if ($("input:radio[name='no_express']:checked").val() == 0) { //需要物流
			$('.help-desc').next('.error-message').remove();
			if ($('.select2-choice > .select2-chosen').attr('data-id') == 0) {
				$('.select2-choice > .select2-chosen').closest('.control-group').addClass('error');
				$('.help-desc').after('<p class="help-block error-message">请选择一个物流公司</p>');
				flag = false;
			} else {
				$('.select2-choice > .select2-chosen').closest('.control-group').removeClass('error');
				express_id = $('.select2-choice > .select2-chosen').attr('data-id');
				express_company = $('.select2-choice > .select2-chosen').text();
			}
			$('.js-express-number').next('.error-message').remove();
			if ($('.js-express-number').val() == '') {
				$('.js-express-number').closest('.control-group').addClass('error');
				$('.js-express-number').after('<p class="help-block error-message">请填写快递单号</p>');
				flag = false;
			} else {
				$('.js-express-number').closest('.control-group').removeClass('error');
				express_no = $('.js-express-number').val();
			}
		}

		var courier = 0;
		if ($("select[name='js-courier-select']").length > 0) {
			var courier_select = $("select[name='js-courier-select']");
			courier = courier_select.val();
			if (courier == 0) {
				courier_select.closest(".control-group").addClass("error");
				courier_select.after('<p class="help-block error-message">请选择配送员</p>');
				flag = false;
			}
		}

		if (flag) {
			$('.js-check-item:checked').each(function(i){
				products[i]		= $(this).val();
				order_products[i] = $(this).data('order-product-id');
				sku_data[i]		= $(this).data('sku-data');
			})
			var address_id = $(this).data("address_id");
			var url = create_package_url;
			
			$.post(url, {'order_id': order_id, 'express_id': express_id, 'express_company': express_company, 'express_no': express_no, 'courier': courier, 'products': products.toString(), 'order_products': order_products.toString(), 'sku_data': sku_data, 'address_id' : address_id}, function(data) {
				if (!data.err_code) {
					
					$('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
					$('.modal').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow",function(){
						$('.modal-backdrop,.modal').remove();
					});
					
					var tuan_id = $(".js-tuan_id").data("tuan_id");
					load_page('.tuan_order_list', load_url, {page : 'order', tuan_id : tuan_id}, '', function () {
						
					});
				} else {
					$('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
				}
				$('.js-express-goods').removeClass('express-active');
				t = setTimeout('msg_hide()', 3000);
			})
		}
	})

	//快递单号
	$('.js-number').live('blur', function(){
		if ($(this).val() != '') {
			$(this).next('.error-message').remove();
			$(this).closest('.control-group').removeClass('error');
		}
	})

	$('.alert-error > .close').live('click', function(){
		$('.notifications').html('');
	})

	var post = false;
	//交易完成
	$('.js-complate-order').live('click', function(){
		$('.notifications').html('<div class="alert in fade alert-success">数据保存中...</div>');
		if (post) {
			return false;
		} else {
			post = true;
		}
		var order_id = $(this).data('id');
		$.post(complate_status_url, {'order_id': order_id}, function(data){
			post = false;
			if (!data.err_code) {
				$('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
				var tuan_id = $(".js-tuan_id").data("tuan_id");
				load_page('.tuan_order_list', load_url, {page : 'order', tuan_id : tuan_id}, '', function () {
					
				});
			} else {
				$('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
			}
			t = setTimeout('msg_hide()', 3000);
		})
	})

	// 到店消费，更改已经提货
	$(".js-selffetch-order").live("click", function () {
		if ($(this).attr("disabled") == "disabled") {
			return;
		}
		var selffetch_order_obj = $(this);

		$(this).attr("disabled", "disabled");
		var order_id = $(this).data("id");
		var url = selffetch_status_url + "&order_id=" + order_id;

		$.get(url, function (data) {
			if (data.err_code == "0") {
				layer_tips(0, data.err_msg);
				selffetch_order_obj.closest("p").html(selffetch_order_obj.html());
			} else {
				layer_tips(1, data.err_msg);
				selffetch_order_obj.removeAttr("disabled");
			}
		});
	});

	// 查看维权
	$(".js-rights_order").live("click", function () {
		var order_no = $(this).data("order_no");
		var pigcms_id = $(this).data("pigcms_id");

		$.post(load_url, {page: 'order_rights_detail', 'order_no': order_no, 'pigcms_id' : pigcms_id}, function(data){
			try {
				if (data.status == true) {
					location.href = "user.php?c=order&a=order_rights#detail/" + data.msg;
				}
			} catch(e) {
				layer_tips(1, data);
			}
		}, "json");
	});


	$('.ui-table-order > tbody').live('mouseover', function(e) {
		$(this).addClass('bgcolor');
	})

	$('.ui-table-order > tbody').live('mouseout', function(e) {
		$(this).removeClass('bgcolor');
	})
	

	// 查看物流
	$('.js-express-detail').live('click', function(){
		express_company = $(this).data("express_company");
		express_type = $(this).data("type");
		express_no = $(this).data("express_no");
		
		var express_title = "物流查询-" + express_company + ' 物流单号：' + express_no;
		if ($(".js-express-detail").size() > 1) {
			var select_html = '<select class="js-express_select">';
			$(".js-express-detail").each(function () {
				var t_company = $(this).data("express_company");
				var t_type = $(this).data("type");
				var t_express_no = $(this).data("express_no");
				
				var t_str = t_company + "," + t_type + "," + t_express_no;
				
				if (t_express_no == express_no) {
					select_html += '	<option value="' + t_str + '" selected="selected">' + t_express_no + '</option>';
				} else {
					select_html += '	<option value="' + t_str + '">' + t_express_no + '</option>';
				}
			});
			select_html += "</select>";
			
			express_title = "物流查询-" + select_html;
		}
		
		var html = '<div class="modal-backdrop in"></div><div class="modal hide widget-express in" aria-hidden="false" style="display: block; margin-top: -1000px;">';
		html += '		<div class="modal-header ">';
		html += '			<a class="close" data-dismiss="modal">×</a>';
		html += '			<h3 class="title">' + express_title + '</h3>';
		html += '		</div>';
		html += '		<div class="modal-body">';
		html += '			<div class="control-group">';
		html += '				<label class="control-label"></label>';
		html += '				<div class="controls">';
		html += '					<div class="control-action js-express-message">努力查询中...</div>';
		html += '				</div>';
		html += '			</div>';
		html += '		</div>'
		html += '		<div class="modal-footer">';
		html += '			<a href="javascript:;" class="ui-btn ui-btn-primary js-express-close">关闭</a>';
		html += '			<div class="final js-footer text-left pull-left js-physical-info"><div>';
		html += '			</div></div>';
		html += '		</div>';
		html += '	</div>';
		
		$('body').append(html);
		$('.modal').animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow");
		
		getExpress();
	});
	
	// 修改包裹物流信息
	$(".js-change-express").live("click", function(){

		var package_id = $(this).attr('data-package-id');

		$.post(package_info_url, {'package_id': package_id}, function(data){
			
			if (data.err_code) {
				layer_tips(data.err_code, data.err_msg);
				return false;
			}

			var data = $.parseJSON(data);

			var html = '<div class="modal-backdrop in"></div><div class="modal hide widget-express in" aria-hidden="false" style="display: block; margin-top: -1000px;">';
			html += 	'<div class="modal-header ">';
			html += 		'<a class="close" data-dismiss="modal">&times;</a>';
			html += 		'<h3 class="title">修改物流信息</h3>';
			html += 	'</div>';
			html += 	'<div class="modal-body">';
			html += 	'<form onsubmit="return false;" class="form-horizontal">';
			html += 		'<div class="control-group">';
			html += 			'<label class="control-label">物流公司：</label>';
			html += 			'<div class="controls">';
			html += 				'<div class="control-action">' + data.order_package.express_company + '</div>';
			html += 			'</div>';
			html += 		'</div>';
			html += 		'<div class="control-group">';
			html += 			'<label class="control-label">快递单号：</label>';
			html += 			'<div class="controls">';
			html += 				'<div class="control-action">' + data.order_package.express_no + '</div>';
			html += 			'</div>';
			html += 		'</div>';
			html += 		'<div class="control-group">';
			html += 			'<label class="control-label">修改快递：</label>';
			html += 			'<div class="controls">';
			html += 			'<select name="express_code">';
			for (i in data.express) {
				if (data.express[i].code == data.order_package.express_code) {
					html += 		'<option value="' + data.express[i].code + '" selected=selected>' + data.express[i].name + '</option>';
				} else {
					html += 		'<option value="' + data.express[i].code + '">' + data.express[i].name + '</option>';
				}
			}
			html += 			'</select>';
			html += 			'</div>';
			html += 		'</div>';
			html += 		'<div class="control-group">';
			html += 			'<label class="control-label">修改单号：</label>';
			html += 			'<div class="controls">';
			html += 			'<input type="text" name="express_no" value="' + data.order_package.express_no + '" />';
			html += 			'</div>';
			html += 		'</div>';
			html += 	'</form>';
			html += 	'</div>';
			html += 	'<div class="modal-footer">';
			html += 		'<a href="javascript:;" class="ui-btn ui-btn-primary js-save-package" data-package-id="' + data.order_package.package_id + '">确定</a>';
			html += 	'</div>';
			html += '</div>';

			$('body').append(html);
			$('.modal').animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow");
		});

	});

	// 修改包裹物流信息
	$('.js-save-package').live("click", function () {

		var self = $(this);
		var package_id = self.attr("data-package-id");
		var express_code = $.trim($("select[name='express_code']").val());
		var express_name = $("select[name='express_code']").find('option:selected').text();
		var express_no = $("input[name='express_no']").val();
		var flag = true;

		if (express_no.length == 0) {
			flag = false;
			$("input[name='express_no']").closest(".control-group").addClass("error");
			$('.notifications').html('<div class="alert in fade alert-error"><a href="javascript:;" class="close pull-right">×</a>快递单号不能为空</div>');
			t = setTimeout('msg_hide()', 3000);
			return false;
		}

		if (flag) {
			$.post(edit_package_url, {'package_id': package_id, 'express_code': express_code, 'express_name': express_name, 'express_no': express_no}, function(data) {
				if (!data.err_code) {
					$('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
					$('.modal').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow",function(){
						$('.modal-backdrop,.modal').remove();
					});
					window.location.reload();
				} else {
					$('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
				}
				t = setTimeout('msg_hide()', 3000);
			});
		}

	});

	$(".js-express_select").live("change", function () {
		var v = $(this).val();
		var v_arr = v.split(",");
		try {
			express_company = v_arr[0];
			express_type = v_arr[1];
			express_no = v_arr[2];
			
			getExpress();
		} catch (e) {
		}
	});
	
	$(".js-express-close").live("click", function () {
		$('.modal').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow",function(){
			$('.modal-backdrop,.modal').remove();
		});
	})
})
var express_company, express_type, express_no;
function getExpress() {
	var default_html = '<div class="control-group">';
	default_html += '	<label class="control-label"></label>';
	default_html += '	<div class="controls">';
	default_html += '		<div class="control-action js-express-message">努力查询中...</div>';
	default_html += '	</div>';
	default_html += '</div>';
	$(".modal-body").html(default_html);
	$.getJSON("wap/express.php", {type : express_type, express_no : express_no}, function (data) {
		if (data.status == false) {
			$(".js-express-message").html("查询失败，<a href='javascript:getExpress()'>重试</a>");
		} else {
			var html = "<table><tr><td>时间</td><td>地点和跟踪进度</td></tr>";
			for(var i in data.data.data) {
				html += '	<tr>';
				html += '		<td style="padding-right:10px; height:18px; line-height:18px;">' + data.data.data[i].time + '</td>';
				html += '		<td>' + data.data.data[i].context + '</td>';
				html += '</tr>';
			}
			html += "</table>"
			
			$(".modal-body").html(html);
		}
	});
}

function changeDate(days){
	var today=new Date(); // 获取今天时间
	var begin;
	var endTime;
	if(days == 3){
		today.setTime(today.getTime()-3*24*3600*1000);
		begin = today.format('yyyy-MM-dd');
		today = new Date();
		today.setTime(today.getTime()-1*24*3600*1000);
		end = today.format('yyyy-MM-dd');
	}else if(days == 7){
		today.setTime(today.getTime()-7*24*3600*1000);
		begin = today.format('yyyy-MM-dd');
		today = new Date();
		today.setTime(today.getTime()-1*24*3600*1000);
		end = today.format('yyyy-MM-dd');
	}else if(days == 30){
		today.setTime(today.getTime()-30*24*3600*1000);
		begin = today.format('yyyy-MM-dd');
		today = new Date();
		today.setTime(today.getTime()-1*24*3600*1000);
		end = today.format('yyyy-MM-dd');
	}
	return {'begin': begin + ' 00:00:00', 'end': end + ' 23:59:59'};
}

//格式化时间
Date.prototype.format = function(format){
	var o = {
		"M+" : this.getMonth()+1, //month
		"d+" : this.getDate(),	//day
		"h+" : this.getHours(),	//hour
		"m+" : this.getMinutes(), //minute
		"s+" : this.getSeconds(), //second
		"q+" : Math.floor((this.getMonth()+3)/3),  //quarter
		"S" : this.getMilliseconds() //millisecond
	}
	if(/(y+)/.test(format)) {
		format=format.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));
	}
	for(var k in o) {
		if(new RegExp("("+ k +")").test(format)) {
			format = format.replace(RegExp.$1, RegExp.$1.length==1 ? o[k] : ("00"+ o[k]).substr((""+ o[k]).length));
		}
	}
	return format;
}

function msg_hide() {
	$('.notifications').html('');
	clearTimeout(t);
}

function getQueryString(name) {
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
	var r = window.location.search.substr(1).match(reg);
	if (r != null) return unescape(r[2]); return null;
}

function winresize() {
	if ($('.js-company').length) {
		$('.select2-display-none').css({
			'top': $('.js-company').offset().top + $('.js-company').height() - 2,
			'left': $('.js-company').offset().left
		});
	}
}

function createPackage(order_id, address_id) {
	$.post(package_product_url, {'order_id': order_id, 'order_friend_address_id' : address_id}, function(data){
		if (data.err_code) {
			layer_tips(data.err_code, data.err_msg);
			return false;
		}
		
		var data = $.parseJSON(data);
		
		var html_address_select = '';
		if (data.send_other == true) {
			var order_friend_address_list = data.order_friend_address_list;
			html_address_select = '&nbsp;&nbsp;选择收货地址：<select name="friend_address" class="js-friend_address" data-order_id="' + order_id + '" style="width: 200px;">';
			var is_have_address = false;
			for (var i in order_friend_address_list) {
				if (order_friend_address_list[i].package_id > 0) {
					continue;
				}
				is_have_address = true;
				var selected = '';
				if (order_friend_address_list[i].id == data.friend_address.id) {
					selected = ' selected="selected"';
				}
				
				html_address_select += '	<option value="' + order_friend_address_list[i].id + '"' + selected + '>' + order_friend_address_list[i].name + '-' + order_friend_address_list[i].phone + '</option>';
			}
			html_address_select += '</select>'
			
			if (!is_have_address) {
				html_address_select = '';
			}
			address_id = data.friend_address.id;
		}
		
		var have_modal = false;
		if ($(".modal").size() > 0) {
			have_modal = true;
		}
		
		var html = '';
		if (!have_modal) {
			html = '<div class="modal-backdrop in"></div><div class="modal hide widget-express in" aria-hidden="false" style="display: block; margin-top: -1000px;">';
		}
		html += '		<div class="modal-header ">';
		html += '			<a class="close" data-dismiss="modal">×</a>';
		html += '			<h3 class="title">商品发货' + html_address_select + '</h3>';
		html += '		</div>';
		html += '		<div class="modal-body">';
		html += '			<table class="ui-table">';
		html += '				<thead>';
		html += '					<tr>';
		html += '						<th class="text-right cell-5">';
		html += '							<input type="checkbox" checked="true" value="1" class="js-check-all" />';
		html += '						</th>';
		html += '						<th class="cell-35">商品</th>';
		html += '						<th class="cell-10">数量</th>';
		html += '						<th class="cell-20">物流公司</th>';
		html += '						<th class="cell-30">快递单号</th>';
		html += '					</tr>';
		html += '				</thead>';
		html += '				<tbody>';
		if (data.products != '' && data.products.length > 0) {
			for (i in data.products) {
				var pro_num = '-';
				if (data.products[i]['pro_num']) {
					pro_num = data.products[i]['pro_num'];
				}
				html += '					<tr>';
				html += '						<td class="text-right">';
				html += '							<input type="checkbox" class="js-check-item" checked="true" value="' + data.products[i]['product_id'] + '" data-order-product-id="' + data.products[i]['order_product_id'] + '" data-sku-data=\'' + data.products[i]['sku_data'] + '\' />';
				html += '						</td>';
				html += '						<td>';
				html += '							<div>';
				html += '								<a href="" class="new-window" target="_blank">' + data.products[i]['name'] + '</a>';
				html += '							</div>';
				html += '							<div>';
				html += '								<span class="c-gray">';
				for (j in data.products[i].skus) {
					html += data.products[i].skus[j]['value'] + '&nbsp;';
				}
				html += '								</span>';
				html += '							</div>';
				html += '						</td>';
				html += '						<td>' + pro_num + '</td>';
				
				if (typeof data.products[i]['physical'] != 'undefined' && data.products[i]['physical'].length > 0) {
					html += '						<td class="physical_name">【门店】' + data.products[i]['physical'] + '</td>';
				} else {
					html += '						<td></td>';
				}

				html += '						<td></td>';
				html += '					</tr>';
			}
		}
		html += '				</tbody>';
		html += '			</table>';
		if (data.address.name) {
			html += '			<form onsubmit="return false;" class="form-horizontal">';
			html += '			<div class="control-group">';
			html += '				<label class="control-label">收货人：</label>';
			html += '				<div class="controls">';
			html += '					<div class="control-action">' + data.address.name + '</div>';
			html += '				</div>';
			html += '			</div>';
			html += '			<div class="control-group">';
			html += '				<label class="control-label">联系电话：</label>';
			html += '				<div class="controls">';
			html += '					<div class="control-action">' + data.address.tel + '</div>';
			html += '				</div>';
			html += '			</div>';
			html += '			<div class="control-group">';
			html += '				<label class="control-label">收货地址：</label>';
			html += '				<div class="controls">';
			html += '					<div class="control-action">' + data.address.province + ' ' + data.address.city + ' ' + data.address.area + ' ' + data.address.address + '</div>';
			html += '				</div>';
			html += '			</div>';
			html += '			<div class="control-group">';
			html += '				<label class="control-label">发货方式：</label>';
			html += '				<div class="controls">';
			html += '					<label class="radio inline"><input type="radio" name="no_express" value="0" checked="true" data-validate="no" style="width:auto;height:auto;" />需要物流</label>';
			html += '					<label class="radio inline"><input type="radio" name="no_express" value="1" data-validate="no" style="width:auto;height:auto;" />无需物流</label>';
			html += '				</div>';
			html += '			</div>';
			html += '			<div class="clearfix control-2-col js-express-info">';
			html += '				<div class="control-group">';
			html += '					<label class="control-label">物流公司：</label>';
			html += '					<div class="controls">';
			html += '						<div class="select2-container js-company select2-container-active" id="s2id_autogen1" style="width: 200px;">';
			html += '							<a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">';
			html += '								<span class="select2-chosen" data-id="0">请选择一个物流公司</span>';
			html += '								<abbr class="select2-search-choice-close"></abbr>';
			html += '								<span class="select2-arrow"><b></b></span>';
			html += '							</a>';
			html += '							<input class="select2-focusser select2-offscreen" type="text" id="s2id_autogen2" disabled="" />';
			html += '						</div>';
			html += '						<select class="js-company select2-offscreen" name="express_id" tabindex="-1">';
			html += '							<option value="0">请选择一个物流公司</option>';
			for (i in data.express) {
				html += '							<option value="' + data.express[i]['code'] + '">' + data.express[i]['name'] + '</option>';
			}
			html += '						</select>';
			html += '						<!--<div class="help-desc">*发货后，10分钟内可修改一次物流信息</div>-->';
			html += '					</div>';
			html += '				</div>';
			html += '				<div class="control-group">';
			html += '					<label class="control-label">快递单号：</label>';
			html += '					<div class="controls"><input type="text" class="input js-express-number" name="express_no" value="" /></div>';
			html += '				</div>';
			html += '			</div>';
			html += '		</form>';
		} else {
			html += '			<div class="control-group" style="padding: 5px;">';
			html += '				<label class="control-label">无收货地址</label>';
			html += '			</div>';
		}
		// 送他人，已经发货收货地址列表
		
		if (data.send_other == true) {
			var order_friend_address_list = data.order_friend_address_list;
			var send_friend_address_html = "";
			for (var i in order_friend_address_list) {
				if (order_friend_address_list[i].package_id == "0") {
					continue;
				}
				
				send_friend_address_html += '<tr>';
				send_friend_address_html += '	<td>' + order_friend_address_list[i].name + '</td>';
				send_friend_address_html += '	<td>' + order_friend_address_list[i].phone + '</td>';
				send_friend_address_html += '	<td>' + order_friend_address_list[i].address.province + order_friend_address_list[i].address.city + order_friend_address_list[i].address.area + order_friend_address_list[i].address.address + '</td>';
				send_friend_address_html += '	<td>' + order_friend_address_list[i].package_dateline + '</td>';
				send_friend_address_html += '<tr>';
			}
			
			if (send_friend_address_html.length > 0) {
				html += '<div class="control-group" style="padding:5px;"><h3>已发货地址列表：</h3></div>';
				html += '<table class="ui-table">';
				html += '	<thead>';
				html += '		<tr>';
				html += '			<th>姓名</th>';
				html += '			<th>电话</th>';
				html += '			<th>地址</th>';
				html += '			<th>创建时间</th>';
				html += '		</tr>';
				html += '	</thead>';
				html += '	<tbody>' + send_friend_address_html + '</tbody></table>';
			}
		}
		
		html += '		</div>'
		html += '		<div class="modal-footer">';
		if (data.address.name) {
			html += '			<a href="javascript:;" class="ui-btn ui-btn-primary js-save" data-id="' + order_id + '" data-address_id="' + address_id + '">确定</a>';
		}
		html += '		<div class="final js-footer text-left pull-left js-physical-info hide"><div>';
		if ($.isEmptyObject(data.baidu_map)) {
			html += '<p class="price-color">未能检测出收货地址坐标</p>';
		} else {
			html += '				<p>检测收货地址: <span class="price-color">' + data.baidu_map.name + '</span> - 门店距离排序</p>';
			for (l in data.physicals_desc) {
				html += '<p>距离 <span class="price-color">' + data.physicals_desc[l].physical_name + '</span>: <span class="decrease-color">' + data.physicals_desc[l].juli + '</span>米</p>';
			}
		}
		html += '			</div></div>';
		html += '		</div>';
		
		if (!have_modal) {
			html += '	</div>';
			
			$('body').append(html);
			$('.modal').animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow");
			var html = '<div class="select2-drop select2-display-none select2-with-searchbox select2-drop-active" style="top: 0px; left: 0px; width: 200px; display: none;">';
			html += '       <div class="select2-search">';
			html += '           <input type="text" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" />';
			html += '       </div>';
			html += '       <ul class="select2-results">';
			html += '           <li class="select2-results-dept-0 select2-result select2-result-selectable select2-highlighted" data-id="0"><div class="select2-result-label"><span class="select2-match"></span>请选择一个物流公司</div></li>';
			for (i in data.express) {
				html += '           <li class="select2-results-dept-' + data.express[i]['code'] + ' select2-result select2-result-selectable" data-id="' + data.express[i]['code'] + '"><div class="select2-result-label"><span class="select2-match"></span>' + data.express[i]['name'] + '</div></li>';
			}
			html += '       </ul>';
			html += '   </div>';
			$('body').append(html);
		} else {
			$(".modal").html(html);
		}
	})
}