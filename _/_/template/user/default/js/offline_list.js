$(function() {
	load_page('.app__content', load_url, {page : 'list'}, '', function () {
	
	});
	
	// 交易完成
	$(".js-complete").live("click", function () {
		var order_id = $(this).data("order_id");
		$.get(order_offline_complete_url, {"order_id": order_id}, function (result) {
			if (result.err_code == "0") {
				layer_tips(0, "操作成功");
				var start_time = $(".js-stime").val();
				var end_time = $(".js-etime").val();
				var order_no = $("input[name='order_no']").val();
				var check_status = $(".js-check_status").val();
				
				var data = {};
				data.page = "list";
				data.start_time = start_time;
				data.end_time = end_time;
				data.order_no = order_no;
				data.check_status = check_status;
				
				load_page('.app__content', load_url, data, '', function () {
					
				});
			} else {
				layer_tips(1, result.err_msg);
			}
		});
	});
	
	//开始时间
	$('#js-stime').live('focus', function() {
		var options = {
			numberOfMonths: 2,
			dateFormat: "yy-mm-dd",
			timeFormat: "HH:mm:ss",
			showSecond: true,
			beforeShow: function() {
				if ($('#js-etime').val() != '') {
					$(this).datepicker('option', 'maxDate', new Date($('#js-etime').val()));
				}
			},
			onSelect: function() {
				if ($('#js-stime').val() != '') {
					$('#js-etime').datepicker('option', 'minDate', new Date($('#js-stime').val()));
				}
			},
			onClose: function() {
				var flag = options._afterClose($(this).datepicker('getDate'), $('#js-etime').datepicker('getDate'));
				if (!flag) {
					$(this).datepicker('setDate', $('#js-etime').datepicker('getDate'));
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
		$('#js-stime').datetimepicker(options);
	})

	//结束时间
	$('#js-etime').live('focus', function(){
		var options = {
			numberOfMonths: 2,
			dateFormat: "yy-mm-dd",
			timeFormat: "HH:mm:ss",
			showSecond: true,
			beforeShow: function() {
				if ($('#js-stime').val() != '') {
					$(this).datepicker('option', 'minDate', new Date($('#js-stime').val()));
				}
			},
			onSelect: function() {
				if ($('#js-etime').val() != '') {
					$('#js-stime').datepicker('option', 'maxDate', new Date($('#js-etime').val()));
				}
			},
			onClose: function() {
				var flag = options._afterClose($('#js-stime').datepicker('getDate'), $(this).datepicker('getDate'));
				if (!flag) {
					$(this).datepicker('setDate', $('#js-stime').datepicker('getDate'));
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
		$('#js-etime').datetimepicker(options);
	})

	//最近7天或30天
	$('.date-quick-pick').live('click', function(){
		$(this).addClass('current');
		$(this).siblings('.date-quick-pick').removeClass('current');

		var tmp_days = $(this).attr('data-days');
		$('.js-stime').val(changeDate(tmp_days).begin);
		$('.js-etime').val(changeDate(tmp_days).end);
	});
	
	// 条件筛选
	$(".js-filter").live("click", function () {
		var start_time = $(".js-stime").val();
		var end_time = $(".js-etime").val();
		var order_no = $("input[name='order_no']").val();
		var check_status = $(".js-check_status").val();
		
		var data = {};
		data.page = "list";
		data.start_time = start_time;
		data.end_time = end_time;
		data.order_no = order_no;
		data.check_status = check_status;
		
		load_page('.app__content', load_url, data, '', function () {
			
		});
	});
	
	// 分页
	$(".js-page a").live("click", function () {
		var obj = $(this).closest(".js-page");
		var start_time = obj.data("start_time");
		var end_time = obj.data("end_time");
		var order_no = obj.data("order_no");
		var check_status = obj.data("check_status");
		var p = $(this).data("page-num");
		
		var data = {page: "list", start_time: start_time, end_time: end_time, order_no: order_no, check_status: check_status, p: p};
		load_page('.app__content', load_url, data, '', function () {
			
		});
	});
});

function changeDate(days){
	var today=new Date(); // 获取今天时间
	var begin;
	var endTime;
	if(days == 3){
		today.setTime(today.getTime()-2*24*3600*1000);
		begin = today.format('yyyy-MM-dd');
		today = new Date();
		today.setTime(today.getTime());
		end = today.format('yyyy-MM-dd');
	}else if(days == 7){
		today.setTime(today.getTime()-6*24*3600*1000);
		begin = today.format('yyyy-MM-dd');
		today = new Date();
		today.setTime(today.getTime());
		end = today.format('yyyy-MM-dd');
	}else if(days == 30){
		today.setTime(today.getTime()-29*24*3600*1000);
		begin = today.format('yyyy-MM-dd');
		today = new Date();
		today.setTime(today.getTime());
		end = today.format('yyyy-MM-dd');
	}
	return {'begin': begin + ' 00:00:00', 'end': end + ' 23:59:59'};
}


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
