/**
 * Created by ediancha on 2016/8/9.
 */
function location_page(mark, page){
	var mark_arr = mark.split('/');

	switch(mark_arr[0]){
		case '#create':
			load_page('.app__content', load_url,{page:'orderprint_create'}, '');
			break;
		case '#edit':
			load_page('.app__content', load_url,{page:'orderprint_edit',id:mark_arr[1]},'',function(){});
			break;
		default:
			load_page('.app__content', load_url,{page:'orderprint_index',"type": 'all', "p" : page}, '');
	}
}
var all_printtype = [1,2];	//1:只打印付过款的；2:无论是否付款都打印
var is_exists_err = false;
var submit_tips = false;
var submit_tips2 = false;

$(function() {
	location_page(location.hash, 1);

	$(".js-list-filter-region a").live('click', function () {
		var action = $(this).attr("href");
		location_page(action, 1)
	});

	$(".js-page-list a").live("click", function () {
		var page = $(this).data("page-num");
		location_page(window.location.hash, page);
	});


	$('a').live('click',function(){
		if($(this).attr('href') && $(this).attr('href').substr(0,1) == '#') location_page($(this).attr('href'),$(this));
	});
	
	
	$(".had_zdh").live("click",function(){
		
		$.layer({
		    type: 2,
		    shadeClose: true,
		    title: false,
		    closeBtn: [0, '#000'],
		    shade: [0.8, '#000'],
		    border: [0],
		    offset: ['30px',''],
		    area: ['800px', ($(window).height() - 150) +'px'],
		    iframe: {src: had_zdh_url}
		}); 
	})

	$(".no_had_zdh").live("click",function(){
		
		$.layer({
		    type: 2,
		    shadeClose: true,
		    title: false,
		    closeBtn: [0, '#000'],
		    shade: [0.8, '#000'],
		    border: [0],
		    offset: ['30px',''],
		    area: ['800px', ($(window).height() - 150) +'px'],
		    iframe: {src: no_had_zhd_url}
		});		
	})	
	
	$(".js-btn-return").live("click",function(){
		
		location.href=printlist_url;
	})
	
	function checkform() {
		is_exists_err = false;
		var mobile = $("input[name='mobile']").val();
		var username = $("input[name='username']").val();
		var terminal_number = $("input[name='terminal_number']").val();
		var keys = $("input[name='keys']").val();
		var counts = $.trim($("input[name='counts']").val());
		var print_type = $("input[name='print_type']:checked").val();
		

		if(mobile) {
			if(!(/^1[0-9]{10}$/.test(mobile))) {
				error_tips($("input[name='mobile']"),"请正确填写绑定的手机号！");
				is_exists_err = true;
			} else{
				clear_error_tips($("input[name='mobile']"));
			}
		} else {
			clear_error_tips($("input[name='mobile']"));
		}
		
		if(!(/^[0-9]+$/.test(counts))) {
			error_tips($("input[name='counts']"),"请正确填写打印份数！");
			is_exists_err = true;
		} else {
			clear_error_tips($("input[name='counts']"));
		}

		if(print_type == '1' || print_type == '2') {
			clear_error_tips($("input[name='print_type']"));
		} else {
			error_tips($("input[name='print_type']"),"打印类型尚未选择！");
			is_exists_err = true;			
		}

		return is_exists_err;
	}
	
	
	// 添加保存
	$(".js-btn-save").live("click",function(){
		var return_err = checkform();
		if(true === return_err) {
			return false;
		} 
		if(submit_tips) {return false;}
		submit_tips = true;
		
		var mobiles = $("input[name='mobile']").val();
		var usernames = $("input[name='username']").val();
		var terminal_number = $("input[name='terminal_number']").val();
		var keys = $("input[name='keys']").val();
		var counts = $.trim($("input[name='counts']").val());
		var types = $("input[name='print_type']:checked").val();
		

		$.post(load_url, {"page" : add_save_url, "mobile" : mobiles, "username" : usernames , "terminal_number": terminal_number ,"keys":keys,"counts":counts, "type" : types,"is_submit" : "submit"}, function (data) {
			submit_tips = false;
			if (data.err_code == '0') {
				layer_tips(0,"添加成功");
				setTimeout(function(){
					location.href = printlist_url;
				},1000);
				return;
			} else {
				layer_tips(1, data.err_msg);
				return;
			}
		});
		
		return;
	})
	
	//修改保存
	$(".js-btn-edit-save").live("click",function(){
		var return_err = checkform();
		if(true === return_err) {
			return false;
		} 

		if(submit_tips2) {return false;}
		submit_tips2 = true;
		var mobiles = $("input[name='mobile']").val();
		var usernames = $("input[name='username']").val();
		var terminal_number = $("input[name='terminal_number']").val();
		var keys = $("input[name='keys']").val();
		var counts = $.trim($("input[name='counts']").val());
		var types = $("input[name='print_type']:checked").val();
		var ids = $("input[name='oid']").val();
		if(!ids) {
			layer.alert("缺失参数！");
			return false;
		}

		$.post(load_url, {"id":ids, "page" : edit_save_url, "mobile" : mobiles, "username" : usernames , "terminal_number": terminal_number ,"keys":keys,"counts":counts, "type" : types,"is_submit" : "submit"}, function (data) {
			submit_tips2 = false;
			if (data.err_code == '0') {
				layer_tips(0,"修改成功");
				setTimeout(function(){
					location.href = printlist_url;
				},1000);
				return;
			} else {
				layer_tips(1, data.err_msg);
				return;
			}
		});		
		
		
		
	})
	
	
	
	//分页
	$('.pagenavi > a').live('click', function(e){
		var p = $(this).attr('data-page-num');

		location_page(window.location.hash, p);

	});

//格式化时间
	Date.prototype.format = function(format){
		var o = {
			"M+" : this.getMonth()+1, //month
			"d+" : this.getDate(),	//day
			"h+" : this.getHours(),   //hour
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

	//开始时间
	$('#js_start_time').live('focus', function() {
		var options = {
			numberOfMonths: 2,
			dateFormat: "yy-mm-dd",
			timeFormat: "HH:mm:ss",
			showSecond: true,
			beforeShow: function() {
				if ($('#js_end_time').val() != '') {
					$(this).datepicker('option', 'maxDate', new Date($('#js_end_time').val()));
				}
			},
			onSelect: function() {
				if ($('#js_start_time').val() != '') {
					$('#js_end_time').datepicker('option', 'minDate', new Date($('#js_start_time').val()));
				}
			},
			onClose: function() {
				var flag = options._afterClose($(this).datepicker('getDate'), $('#js_end_time').datepicker('getDate'));
				if (!flag) {
					$(this).datepicker('setDate', $('#js_end_time').datepicker('getDate'));
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
		$('#js_start_time').datetimepicker(options);
	})


	//结束时间
	$('#js_end_time').live('focus', function(){
		var options = {
			numberOfMonths: 2,
			dateFormat: "yy-mm-dd",
			timeFormat: "HH:mm:ss",
			showSecond: true,
			beforeShow: function() {
				if ($('#js_start_time').val() != '') {
					$(this).datepicker('option', 'minDate', new Date($('#js_start_time').val()));
				}
			},
			onSelect: function() {
				if ($('#js_end_time').val() != '') {
					$('#js_start_time').datepicker('option', 'maxDate', new Date($('#js_end_time').val()));
				}
			},
			onClose: function() {
				var flag = options._afterClose($('#js_start_time').datepicker('getDate'), $(this).datepicker('getDate'));
				if (!flag) {
					$(this).datepicker('setDate', $('#js_start_time').datepicker('getDate'));
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
		$('#js_end_time').datetimepicker(options);
	})

	//面值checkbox 触发事件
	$(".js-is-random").live('change', function(){
		  if($(this).find("input[name='is_random']").is(':checked') == true){
		   $(".js-random").show();
	   } else {
			$(".js-random").hide();
	   }
	})



	//错误提示设定
	function error_tips(obj,message){
		obj.closest(".control-group").addClass('error');
		obj.closest(".control-group").find(".error-message").remove();
		var err_message = '<p class="help-block error-message">'+message+'</p>';
		obj.closest(".controls").append(err_message);
	}
	//清除错误提示设定
	function clear_error_tips(obj){
		obj.closest(".control-group").removeClass('error');
		obj.closest(".control-group").find(".error-message").remove();
	}
















	//失焦事件
	$(".app-sidebar-inner input").live("blur",function(){
		var input_name = $(this).attr("name");
		check_form_blur(input_name);
	})




	// 使订单打印机失效
	$(".js-disabled").live("click", function (e) {
		var disabled_obj = $(this);
		var service_id = disabled_obj.closest(".server_id").attr("service_id");
		button_box($(this), e, 'left', 'confirm', '确定让这组打印机设备失效?<br><span class="red">失效后将导致该打印机设备无法打印订单和编辑</span>', function(){
			$.get(disabled_url, {"id" : service_id,"is_open":'0'}, function (data) {
				close_button_box();
				if (data.err_code == "0") {
					disabled_obj.closest("tr").find(".js-disabled").html("已关闭");
					disabled_obj.closest("tr").find(".zuangtai").removeClass("orderprint_black").removeClass("orderprint_red").text("已关闭").addClass("orderprint_red");
					disabled_obj.closest("tr").find(".edit_span").hide();
					disabled_obj.closest("tr").find(".js-disabled").addClass("js-able").removeClass("js-disabled")
					layer_tips(0, data.err_msg);
				} else {
					layer_tips(1, data.err_msg);
				}
			})
		});
	});
	
	// 使订单打印机恢复使用
	$(".js-able").live("click", function (e) {
		var disabled_obj = $(this);
		var service_id = disabled_obj.closest(".server_id").attr("service_id");
		button_box($(this), e, 'left', 'confirm', '确定让这组打印机设备恢复使用?', function(){
			$.get(disabled_url, {"id" : service_id,"is_open":'1'}, function (data) {
				close_button_box();
				if (data.err_code == "0") {
					disabled_obj.closest("tr").find(".js-able").html("已开启");
					disabled_obj.closest("tr").find(".zuangtai").removeClass("orerprint_black").removeClass("orderprint_red").text("已开启").addClass("orderprint_black");
					disabled_obj.closest("tr").find(".js-able").addClass("js-disabled").removeClass("js-able")
					layer_tips(0, data.err_msg);
				} else {
					layer_tips(1, data.err_msg);
				}
			})
		});
	});
	
	
	// 删除订单打印机
	$('.js-delete').live("click", function(e){
		var delete_obj = $(this);
		var service_id = delete_obj.closest(".server_id").attr("service_id");
		$('.js-delete').addClass('active');
		button_box($(this), e, 'left', 'confirm', '确认删除？', function(){
			$.get(delete_url, {'id': service_id}, function(data) {
				close_button_box();
				t = setTimeout('msg_hide()', 3000);
				if (data.err_code == 0) {
					$('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
					load_page('.app__content',load_url,{page: 'orderprint_index'},'');
				} else {
					$('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
				}
			})
		});
	});


	// 删除可用商品
	$(".js-delete-goods").live("click",function(){
		var goods_obj = $(this);
		var tables_obj = $(this).closest("table");
		if($(this).closest("table").hasClass("js-goods-list")) {
		   // var pid_arr_str2 = $(".js-goods-list").attr("pid_arr");
		} else {
		 //   var pid_arr_str2 = $(".js-goods-lists").attr("pid_arr");
		}
		//   var pid_arr_arr2 = pid_arr_str2.split("-");

		button_box($(this), event, 'left', 'confirm', '确认删除？', function(){
			  var pid_this =  goods_obj.closest("tr").attr("data-pid");
				goods_obj.closest("tr").remove();
			//	var arr3=$.grep(pid_arr_arr2,function(n,i){
			 //	   return n!=pid_this;
			//	});

		   //	  var str3 =  arr3.join("-");
		   //	  tables_obj.attr("pid_arr",str3);
				 close_button_box();
		})

	})


	// 编辑资料
	$(".js-edit").live("click", function () {
		location_page($(this).attr("href"));
	});



	//回车提交搜索
	$(window).keydown(function(event){
		if (event.keyCode == 13 && $('.js-orderprint-keyword').is(':focus')) {
			var keyword = $('.js-orderprint-keyword').val();
			var type = window.location.hash.substring(1);
			$('.app__content').load(load_url, {page : 'orderprint_index', 'keyword' : keyword, 'type' : type}, function(){
			});
		}
	})

	// 取消
	$(".js-btn-quit").live("click", function () {
		location.href = "user.php?c=preferential&a=coupon";
	})

	//
	function msg_hide() {
		$('.notifications').html('');
		clearTimeout(t);
	}

	$(".js-link").live('click',function(e){

	   // button_box($(this),e,'left','copy',wap_coupon_url+'?id='+$(this).closest('tr').attr('service_id'),function(){
		button_box($(this),e,'left','copy',wap_coupon_url+'?id='+$(this).closest('tr').attr('data-store-id')+"&couponid="+$(this).closest('tr').attr('service_id'),function(){
			layer_tips(0,'复制成功');
		});
	})





})


//
function msg_hide() {
	$('.notifications').html('');
	clearTimeout(t);
}










