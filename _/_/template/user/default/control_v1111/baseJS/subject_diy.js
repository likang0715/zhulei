/**
 * Created by pigcms-s on 2015/09/11.
 */
var p=1;
var sub_add_tip = "";
$(function() {
	location_page(location_type,location.hash, 1);

	function reloads() {
		window.location.reload();
	}
	
  //专题管理 关联产品上传
	function load_widget_lin_box() {
		
		
		$('.module-goods-list .sort .js-delete-goods').live("click",function(){
			obj_sort = $(this).closest(".js-ico-lists");
			if(obj_sort.find(".sort").size() == 1) {
				$(this).closest('.js-ico-lists').remove();
			}
			$(this).closest('.sort').remove();
			//var good_data = domHtml.data('goods');
			//delete good_data[$(this).data('id')];

		});
		
		widget_link_box($('.js-add-sub-product'),'good_only_pic&only=1',function(result){

			var domHtml = $(".app__content").find(".form-forms");
			var good_data = '';
			if(good_data){
				//$.merge(good_data,result);
			}else{
				good_data = result;
			}


			var html = '';
			for(var i in good_data){
				var item = good_data[i];
				titles = item.title;
				len = 6;
					
				if(titles.length>len) {
					titles = titles.substr(0,len)+'..';
				}	
					
					
				html += "<div><ul class='ico app-image-list js-ico-lists' style='display:inline-block'>";
				html += '	<li style="background:none;width:90px;line-height:41px;border:0px;">' +titles+ '</li>';
				for(var j in item.piclist) {
					html += '<li class="sort" data-id="'+i+'"><img data-id="'+i+'" src="'+item.piclist[j]+'" ><a class="close-modal js-delete-goods small hide" data-id="'+i+'" title="删除">×</a></li>';
				}

				html += " </ul></div>";
			}

			$('.module-goods-list').prepend(html);
			
			
			
		});
		
	}
	
	$('a').live('click',function(){
		if($(this).closest(".widget-image").size()) {
			
		} else {
			if($(this).attr('href') && $(this).attr('href').substr(0,1) == '#')  {
				
				location_page(location_type,$(this).attr('href'),$(this));
			}
		}
	});
	function location_page(location_type,mark, page) {
		var mark_arr = mark.split('/');
		
			
			
				switch(mark_arr[0]){
					case '#create':
						//load_page('.app__content', load_url,{page:'subtype_create',type:'subtype'}, '');
						break;
					
					case "#edit":
						if(mark_arr[1]){
							subtype_edit(mark_arr[1]);

							//load_page('.app__content', load_url,{page:'subtype_edit',type:'subtype',id:mark_arr[1]},'',function(){
	
							//});
						}else{
							layer.alert('非法访问！');
							location.hash = '#list';
							location_page('');
						}
						break;
	
						default:
							load_page('.app__content', load_url,{page:'subject_diy_content', "type": 'subtype', "p" : page}, '');
					}
					
			
				

				
	}




		
	//专题搜索
	$(".subject_search_botton").live("click",function(){
		var keyword = $('.js-coupon-keyword').val();
		var type = window.location.hash.substring(1);

		
		var keyword = $(".subject_search input[name='titles']").val();
		var start_time = $(".subject_search input[name='start_time']").val();
		var end_time = $(".subject_search input[name='end_time']").val();
		var subtype1 = $(".subject_search select[name='subtype1']").val();
		var subtype2 = $(".subject_search select[name='subtype2']").val();
		if(subtype2) {
			subtype = subtype2;
		} else {
			subtype = subtype1;
		}
		$('.app__content').load(load_url, {"is_search":1, "page" : page_content, "title" : keyword, "start_time" : start_time,  "end_time":end_time, "subtype" : subtype}, function(){
			
		});		
		
		
		
	})
	

	//搜索框动画
	$('.ui-search-box :input').live('focus', function(){
		$(this).animate({width: '180px'}, 100);
	})
	$('.ui-search-box :input').live('blur', function(){
		$(this).animate({width: '70px'}, 100);
	})

	//分页
	$('.pagenavi > a').live('click', function(e){
		if($(this).closest(".widget-image").size()) {
		} else {
			var p = $(this).attr('data-page-num');
			location_page(location_type,window.location.hash, p);
		}
	});


	
	//失焦事件
	$(".app__content input").live("blur",function(){
		var input_name = $(this).attr("name");
		check_form_blur(input_name);
	})	
	
	//表单失焦
	function check_form_blur(input_name) {}
	
	

	//表单提交验证
	function check_form() {}
	




	
	
	//返回列表页
	$(".js-btn-quit").live("click", function () {
		switch(location_type) {
			case 'subject':
					location.href = "user.php?c=goods&a=subject";
				break;
				
			case 'subtype':
					location.href = "user.php?c=goods&a=subtype";
				break;
		}	
	})
	
	
	
	function returnurl() {		
		location.href= page_list_url;
	}
	

	
	$("input[name='range_type']").live("change",function(){
		var range_type = $(this).val();
		if(range_type == 'part') {$(".js-add-goods,.js_add_goods_from_edit").show();$(".js-goods-list,.js_add_goods_from_edit1").show();} else {$(".js-add-goods,.js_add_goods_from_edit").hide();$(".js-goods-list,.js_add_goods_from_edit1").hide();}
	})

	//限制文本框输入的字数
	$("textarea[name='description']").live("keydown",function(){
		var textObj = $("textarea[name='description']");

		var curLength= textObj.val().length;
		strLenCalc(textObj,'syzs',200);
	})

	function strLenCalc(obj, checklen, maxlen) {
		$(".controls_syzs").show();
		var v = obj.val(), charlen = 0, maxlen = !maxlen ? 200 : maxlen, curlen = maxlen, len = v.length;
		for(var i = 0; i < v.length; i++) {
			if(v.charCodeAt(i) < 0 || v.charCodeAt(i) > 255) {
				curlen -= 1;
			}
		}

		if(curlen >= len) {
			$("#"+checklen).html(" "+Math.floor((curlen-len)/2)+" ").css('color', '');
		} else {
			var contents = obj.val().substr(0,200);
			obj.val(contents);
			$("#"+checklen).html(" "+Math.ceil((len-curlen)/2)+" ").css('color', '#FF0000');

		}
	}





	// 删除
	$('.js-delete').live("click", function(e){
		var delete_obj = $(this);
		var id = $(this).attr('data');
		$('.js-delete').addClass('active');
		button_box($(this), e, 'left', 'confirm', '确认删除？', function(){
			$.get(delete_url, {'id': id}, function(data) {
				close_button_box();
				t = setTimeout('msg_hide()', 3000);
				if (data.err_code == 0) {
					$('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
					load_page('.app__content',load_url,{page: page_content},'');
				} else {
					$('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
				}
			})
		});
	});




	//添加图文专题内容
	var is_close_tip2 = true;
	$(".js-btn-add-save-subject").live("click", function() {
		if(!is_close_tip2) return false;
		is_close_tip2 = false;
		
		var subject_title = $("input[name='subject_title']").val();
		var top_typeid = $(".select_toptype").val();
		var son_typeid = $(".select_sontype").val();
		var subject_description = $(".description").val();
		var subject_pic = "";
		var list_size = $('.js-subject-ico img').size();
		var is_show = $('input[name="is_show"]:checked').val();

		var product_id_arr = [];
		var product_image_arr = [];
		$(".module-goods-list .sort img").each(function(i,item) {
			var product_id = $(item).attr("data-id");

			product_image_arr.push($(item).attr("src"));
			product_id_arr.push($(item).attr("data-id"));
		})
		
		if(!subject_title) {
			layer.alert("攻略标题不能为空！");
			is_close_tip2 = true;
			return;
		}
		
		if(list_size > 0) {
			var subject_pic = $('.js-subject-ico img').attr('src');	
		} else {
			layer.alert("专题图片不能为空！")
			is_close_tip2 = true;
			return;
		}
		
		if(!top_typeid) {
			layer.alert("请选择攻略分类");
			is_close_tip2 = true;
			return;
		}
		
		if(!subject_description) {
			layer.alert("攻略内容不能为空!");
			is_close_tip2 = true;
			return;
		}

		$.post(
			load_url,
			{'page':'subject_create','is_ajax':1,'product_image_arr':product_image_arr,'product_id_arr':product_id_arr,'top_typeid':top_typeid,"son_typeid":son_typeid,'title':subject_title,'pic':subject_pic,'description':subject_description,'is_show':is_show},	
			function(obj) {
				is_close_tip2 = true;
				
				if(obj.err_code == '0') {
					layer.msg("添加成功!");
					var t = setTimeout(returnurl('subject_list'), 2000);
				} else {
					layer.msg(obj.err_msg);
				}
			})
	})
	
	
	
	$(".js-btn-save").live("click",function(){
		
		var fields = $(".contents input").serializeArray();
		//jQuery.each( fields, function(i, field){
		//  $("#results").append(field.value + " ");
		//});
		
		$.post(
			load_url,
			{'page':'subject_diy_edit','is_ajax':1,'fields':fields},	
			function(obj) {
				is_close_tip2 = true;
					
				if(obj.err_code == '0') {
					layer.alert('修改成功', 9, !1);
					var t = setTimeout(returnurl('subject_list'), 2000);
				} else {
					layer.msg(obj.err_msg);
				}
			}
		)

	})
	
	
	function returnurl(typs) {
		
		switch(typs) {
		
			case 'subject_list' : 
				location.href = page_list_url;
				break;
		} 
		
	}
	
	


	
	$(".show_new_select_toptype").live("click",function() {
		$(".old_select_toptype").hide();
		$(".select_toptype").show();
		
	})
	
	//回车提交搜索
	$(window).keydown(function(event){
		if (event.keyCode == 13 && $('.js-coupon-keyword').is(':focus')) {
			var keyword = $('.js-coupon-keyword').val();
			var type = window.location.hash.substring(1);
			$('.app__content').load(load_url, {page : page_content, 'keyword' : keyword, 'type' : type}, function(){
			});
		}
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




//删除图片
$('.js-delete-picture').live('click', function(){
	$(this).closest('li').remove();
})

//标签列表 显示详细
$(".show_more").live("click",function(){
	var show_more_data = $(this).attr("data");
	layer.alert("使用须知 ：" +show_more_data,'1','使用须知');
})

/*
	$('.js-delete').live("click", function(e){
		var delete_obj = $(this);
		var id = $(this).attr('data');
		$('.js-delete').addClass('active');
		button_box($(this), e, 'left', 'confirm', '确认删除？', function(){
			$.get(delete_url, {'id': id}, function(data) {
				close_button_box();
				t = setTimeout('msg_hide()', 3000);
				if (data.err_code == 0) {
					$('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
					load_page('.app__content',load_url,{page: page_content},'');
				} else {
					$('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
				}
			})
		});
	});
*/


//专题评论全选
$(".js-check-all-subject_pinlun").live("click",function(){
	if ($(this).is(':checked')) {
		$('.js-check-toggle').attr('checked', true);
	} else {
		$('.js-check-toggle').attr('checked', false);
	}
})

//专题评论单个隐藏
$(".js-subject_pinlun-disabled").live("click",function(e){
	var disabled_obj = $(this);
	var js_disabled_index = $(".js-disabled").index($(this));
	var plid = disabled_obj.closest("tr").data("plid");
	
	button_box($(this), e, 'left', 'confirm', '确定隐藏这组专题评论?<br><span class="red">隐藏后将导致该专题评论无法在微信端专题评论中不显示！</span>', function(){
		$.get(subject_pinlun_disabled_url, {"id" : plid}, function (data) {
			close_button_box();
			if(data.err_code == '8888') {
				disabled_obj.closest("tr").find(".zt").html("<font color='#f00'>已隐藏</font>");
				disabled_obj.html("使显示");
				layer_tips(0, data.err_msg);
				
			} else if(data.err_code == '9999') {
				disabled_obj.closest("tr").find(".zt").html("<font color='#f00'>已显示</font>");
				disabled_obj.html("使隐藏");
				layer_tips(0, data.err_msg);
			} else {
				layer_tips(1, data.err_msg);
			}
		})
	});	
})

//专题评论单个删除
$(".js-subject_pinlun-delete").live("click",function(e){
	var disabled_obj = $(this);
	var plid = disabled_obj.closest("tr").data("plid");

	button_box($(this), e, 'left', 'confirm', '确定删除这组的专题评论?<br><span class="red">删除后将导致该专题评论无法在微信及商家中心端专题评论中无法显示！</span>', function(){
		$.post(all_subject_pinlun_delete_url, {'id_str': plid}, function (data) {
			close_button_box();
			if (data.err_code == "0") {
				load_page('.app__content', load_url,{page:'subject_pinlun_content', "type": 'subject_pinlun', "p" : p}, '');
				layer_tips(0, data.err_msg);
			} else {
				layer_tips(1, data.err_msg);
			}
		})
	});	
})

//批量删除
$(".js-subject-batch_pinlun-delete").live("click",function(e){
	var disabled_obj = $(this);
	var js_disabled_index = $(".js-disabled").index($(this));
	var jf_id = disabled_obj.closest("td").attr("data");

	if ($('.js-check-toggle:checked').length == 0) {
		layer.alert("请选择需要删除的专题评价！");
		return false;
	}	
    var comment_id = [];
    $('.js-check-toggle:checked').each(function(i){
        comment_id[i] = $(this).val();
    })
    
	button_box($(this), e, 'right', 'confirm', '确定批量删除勾选的专题评论?<br><span class="red">删除后将导致以选择的专题评论无法在微信及商家中心端专题评论中无法显示！</span>', function(){
		$.post(all_subject_pinlun_delete_url, {'id_str': comment_id}, function (data) {
			close_button_box();
			if (data.err_code == "0") {
				load_page('.app__content', load_url,{page:'subject_pinlun_content', "type": 'subject_pinlun', "p" : p}, '');
	
				layer_tips(0, data.err_msg);
				
			} else {
				layer_tips(1, data.err_msg);
			}
		})
	});	
})

//批量隐藏
$(".js-subject-batch_pinlun-disabled").live("click",function(e){
	var disabled_obj = $(this);
	var js_disabled_index = $(".js-disabled").index($(this));

	if ($('.js-check-toggle:checked').length == 0) {
		layer.alert("请选择需要隐藏的专题评价！");
		return false;
	}	
    var comment_id = [];
    $('.js-check-toggle:checked').each(function(i){
        comment_id[i] = $(this).val();
    })
	button_box($(this), e, 'right', 'confirm', '确定批量隐藏勾选的专题评论?<br><span class="red">隐藏后将导致已选择的专题评论无法在微信端专题评论中不显示！</span>', function(){
		$.get(all_subject_pinlun_disabled_url, {'id_str': comment_id}, function (data) {
			close_button_box();
			if (data.err_code == "0") {
				disabled_obj.closest("tr").find(".zt").html("<font color='#f00'>已隐藏</font>");
				$(".js-disabled").eq(js_disabled_index).removeClass("js-disabled").addClass("js-able").html("使显示")
				layer_tips(0, data.err_msg);
			} else {
				layer_tips(1, data.err_msg);
			}
		})
	});	
})

$(function(){
	
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

	//最近7天或30天
	$('.date-quick-pick').live('click', function(){
		$(this).siblings('.date-quick-pick').removeClass('current');
		$(this).addClass('current');
		var tmp_days = $(this).attr('data-days');
		$('.js-start-time').val(changeDate(tmp_days).begin);
		$('.js-end-time').val(changeDate(tmp_days).end);
	})	
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
})