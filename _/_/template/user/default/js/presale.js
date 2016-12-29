/**
 * Created by ediancha on 2016/8/9.
 */
function location_page(mark, page){
	var mark_arr = mark.split('/');
	
	switch(mark_arr[0]){
		case '#create':
			load_page('.app__content', load_url, {page : page_presale_create}, '');
			break;
		case "#edit":
			if(mark_arr[1]){
				load_page('.app__content', load_url,{page:'presale_edit', id : mark_arr[1]},'',function(){
					
				});
			}else{
				layer.alert('非法访问！');
				location.hash = '#list';
				location_page('');
			}
			break;
		case "#show":
			if(mark_arr[1]){
				load_page('.app__content', load_url,{page:'presale_edit', id : mark_arr[1]},'',function(){
					
				});
			}else{
				layer.alert('非法访问！');
				location.hash = '#list';
				location_page('');
			}
			break;				
		case "#future" :
			action = "future";
			load_page('.app__content', load_url, {page : page_content, "type" : action, "p" : page}, '');
			break;
		case "#on" :
			action = "on";
			load_page('.app__content', load_url, {page : page_content, "type" : action, "p" : page}, '');
			break;
		case "#end" :
			action = "end";
			load_page('.app__content', load_url, {page : page_content, "type" : action, "p" : page}, '');
			break;
		default :
			action = "all";
			load_page('.app__content', load_url, {page : page_content, "type" : action, "p" : page}, '');
	}
}
  var page = 1; //页码 
$(function(){
	location_page(location.hash, 1);
	
	$(".js-list-filter-region a").live('click', function () {
		var action = $(this).attr("href");
		location_page(action, 1)
	});
	
	$(window).bind('hashchange', function() {
		location_page(location.hash);
	})
	
	$(".js-page-list a").live("click", function () {
		var page = $(this).data("page-num");
		location_page(window.location.hash, page);
	});
	// 复制链接
	$(".js-copy-link").live("click", function (e) {
		var presale_id = $(this).data("id");
		button_box($(this),e,'left','copy', presale_wap_url + "?id="+presale_id, function(){
			layer_tips(0,'复制成功');
		});
	});	
	
	//显示用户条形码
	$(".js_show_ewm").live("click",function(e) {
		
		edit_html  = "<div style='width:300px;display:block'><p>积分：<input style='width:50px;' type='text'></p>";
		edit_html += "<p>理由：<input type='text'></p>";
		edit_html += "</div>";		
		button_box_self($(this),e,'bottom','txm',edit_html,function(){
			
			
		})
	})
	
	
	/*
	button_box_self($(this), e, 'bottom', 'multi_txt', edit_html, function(){
		
		var uid  = $(".ui-box .widget-list-item").eq(edit_this).attr("data-uid");
		var desc = $("#liyou").val();
		var old_jf = $(".ui-box .widget-list-item").eq(edit_this).find(".td_jf").text();
		old_jf = $.trim(old_jf);
		var change_jf = $("#jf_change").val();
		if(!change_jf) {
			layer.alert("积分填写错误！");
			return;
		}
		$(this).closest("tr").find(".td_jf").text();
		if(!desc) {
			layer.alert("总得写点理由吧！");
			return;
		}
		$.get(change_user_jf_url, {'uid': uid,'desc':desc,'change_jf':change_jf}, function(data) {
			close_button_box();
			
			var new_jf = parseInt(old_jf)+parseInt(change_jf);
			$(".ui-box .widget-list-item").eq(edit_this).find(".td_jf").text(new_jf)
			t = setTimeout('msg_hide()', 3000);
			if (data.err_code == 0) {
				$('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
				
				load_page('.app__content',load_url,{page: page_content},'');
			} else {
				$('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
			}
		})
	});		
*/
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
	
	//尾款支付截止时间
	$('#js-pay-time').live('focus', function(){
		var options = {
			numberOfMonths: 2,
			dateFormat: "yy-mm-dd",
			timeFormat: "HH:mm:ss",
			showSecond: true,
			beforeShow: function() {
				if ($('#js-start-time').val() != '') {
					$(this).datepicker('option', 'minDate', new Date($('#js-end-time').val()));
				}
			},
			onSelect: function() {
				if ($('#js-pay-time').val() != '') {
					$('#js-end-time').datepicker('option', 'maxDate', new Date($('#js-pay-time').val()));
				}
			},
			onClose: function() {
				var flag = options._afterClose($('#js-end-time').datepicker('getDate'), $(this).datepicker('getDate'));
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
				if (starttime > 0 && endtime < starttime) {
					alert('无效的时间段');
					return false;
				}
				return true;
			}
		};
		$('#js-pay-time').datetimepicker(options);
	})
	
	
	// 取消
	$(".js-btn-quit").live("click", function () {
		location_page('');
	})
	
	// 添加赠品
	$(".js-add-presale").live("click", function () {
		$(".js-select-goods-list").show();
		loadProduct();
	});
	
	// 类型切换
	$(".js-search-type").live('change', function () {
		$(".js-title").attr("placeholder", $(".js-title").attr("data-goods-" + $(this).val()));
	})
	
	// 搜索添加赠品
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
	
	// 设置为赠品
	$(".js-add-reward").live('click', function () {
		var product_id = $(this).data('product_id');
		
		var is_exists = false;
		$(".js-show-presale").find(".current-presale").each(function () {
			if (product_id == $(this).data("product_id")) {
				is_exists = true;
				//alert("此产品已经在赠品里，无须重复添加");
				return false;
			}
		});
		
		if (is_exists) {
			$(this).removeClass("btn-primary");
			return;
		}
		
		var img_url = $(this).parent().parent().find(".js-goods-image").html();
		var title_url = $(this).parent().parent().find(".goods-title").html();
		var quantity = $(this).parent().parent().find(".js-quantity").html();
		
		var html = '<div class="current-presale clearfix" data-product_id="' + product_id + '">' + img_url;
		html += '	<div class="current-presale-tips">' + title_url;
		html += '		<p>库存： ' + quantity + '</p>\
									</div>\
									<a class="ui-btn ui-btn-success add-presale modify-presale js-modify-presale" href="javascript:void(0)">删除此赠品</a>\
								</div>';
		
		$(".js-show-presale").append(html);
		$(this).removeClass("btn-primary");
		$(this).html("已设为赠品");
	});
	
	// 删除赠品
	$(".js-modify-presale").live("click", function () {
		var product_id = $(this).parent().data("product_id");
		$("#js-add-reward-" + product_id).addClass("btn-primary");
		$("#js-add-reward-" + product_id).html("设置为赠品");
		$(this).parent().remove();
	});
	
	// 分页
	$(".js-presale_list_page a").live("click", function () {
		var p = $(this).data("page-num");
		var keyword = $('.js-presale-keyword').val();
		var type = window.location.hash.substring(1);
		
		$('.app__content').load(load_url, {page : page_content, 'keyword' : keyword, 'type' : type, 'p' : p}, function(){
		});
	})
	
	
		//优惠方式选择
	$(".reward-setting input[type='checkbox']").live('click',function(event) {
		var controls = $(this).closest(".controls");

		if($(this).next(".origin-status").text()!='免邮'){
			if($(this).attr("checked")){
				$(this).closest(".controls").find(".origin-status").hide();
				$(this).closest(".controls").find(".replace-status").show();
			} else{
				$(this).closest(".controls").find(".origin-status").show();
				if($(this).attr("name")=='cash_required') {
					$(this).closest(".controls").find(".origin-status").text("减现金");
				}
				if($(this).attr("name")=='coupon_required') {
					$(this).closest(".controls").find(".origin-status").text("送优惠");
				}
				if($(this).attr("name")=='present_required') {
					$(this).closest(".controls").find(".origin-status").text("送赠品");
				}
				
				$(this).closest(".controls").find(".replace-status").hide();
			}
		}
	})
	// 刷新优惠券列表
	$(".js-refresh-coupon").live("click", function () {
		$.getJSON("user.php?c=reward&a=coupon_option", function (data) {
			try {
				var option_html = '';
				for (i in data) {
					option_html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
				}
				$(".js-reward-coupon").html(option_html);
			} catch(e) {
			}
		});
	});
	
	// 刷新赠品列表
	$(".js-refresh-present").live("click", function () {
		$.getJSON("user.php?c=reward&a=present_option", function (data) {
			try {
				var option_html = '';
				for (i in data) {
					option_html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
				}
				$(".js-reward-present").html(option_html);
			} catch(e) {
			}
		});
	});	
	// 添加保存
	$(".js-btn-save").live("click", function () {
		var name = $("#name").val();
		
		var dingjin = $(".dingjin").val();
		var presale_person = $(".presale_person").val();
		var start_time = $("#js-start-time").val();
		var end_time = $("#js-end-time").val();
		var pay_time = $("#js-pay-time").val();
		var presale_amount = $("#presale_amount").val();
		var buy_count = $("#buy_count").val();		
		var shuoming = $("#shuoming").val();		
		var expire_number = $("#expire_number").val();
		var product_price = $("input[name='yuanjia']").val();
		var product_quantity = $("input[name='quantity']").val();
		
		var cash="";	var coupon="";	var present="";
		var is_ok=true;
		if($(".js-ico-list").find(".sort").size() == 1) {
			var product_id = $(".js-ico-list").find(".sort").data("pid");
		} else {
			layer_tips(1, '请至少选择一个产品作为预售产品！');
			return;
		}
		if(!name) {
			layer_tips(1, '预售标题不能为空！');
			$("#name").focus();
			return;
		}

		if(!(/^(\+|-)?\d+[\.]?[0-9]{0,2}$/.test( dingjin )) || dingjin <= 0 ) {
			layer_tips(1, '请正确填写购买预售商品所需定金！');
			$(".dingjin").focus();
			return;
		}
		
		if((parseFloat(dingjin) >= parseFloat(product_price)) || (!product_price)) {
			layer_tips(1, '定金不能大于商品原价！');
			$(".dingjin").focus();
			return;
		}
		
		if((parseInt(buy_count) > parseInt(product_quantity)) || (!product_quantity)) {
			layer_tips(1, '预售数量不能大于商品库存总量,或已均被预订！');
			$(".presale_amount").focus();
			return;
		}		

		if(!(/^(\+)?\d+$/.test( presale_person )) || presale_person <= 0 ) {
			layer_tips(1, '请正确填写初始预售人数！'+presale_person);
			$(".presale_person").focus();
			return;
		}
		
		if (start_time.length == 0) {
			layer_tips(1, '请选择预售开始时间！');
			$("#js-start-time").focus();
			return;
		}
		
		if (end_time.length == 0) {
			layer_tips(1, '请选择预售结束时间！');
			$("#js-end-time").focus();
			return;
		}
		if (pay_time.length == 0) {
			layer_tips(1, '请选择尾款支付截止时间！');
			$("#js-pay-time").focus();
			return;
		}	
		
		if(!(/^(\+)?\d+$/.test( presale_amount )) || presale_amount <= 0 ) {
			layer_tips(1, '请正确填写预售数量限制！');
			$(".presale_amount").focus();
			return;
		}	
		
		if(!shuoming) {
			layer_tips(1, '预售描述不能为空哦！');
			$(".shuoming").focus();
			return;
		}
		tr_obj = $(".reward-table-wrap");
		// 检查每个优惠方式
		if(tr_obj.find("input[name='cash_required']").prop("checked")) {
			cash = tr_obj.find("input[name='cash']").val();
			if (cash == "") {
				layer_tips(1, '勾选的特权，减现金不能为空');
				tr_obj.find("input[name='cash']").focus();
				is_ok = false;
				return false;
			} else if (isNaN(cash)) {
				layer_tips(1, '特权减现金，请输入有效的金额');
				tr_obj.find("input[name='cash']").focus();
				is_ok = false;
				return false;
			}
		}
		
		if(tr_obj.find("input[name='score_required']").prop("checked")) {
			var score = tr_obj.find("input[name='score']").val();
			if (score == "") {
				layer_tips(1, '请输入积分');
				tr_obj.find("input[name='score']").focus();
				is_ok = false;
				return false;
			}
			
			if(!(/^(\+|-)?\d+$/.test(score)) || score < 0) {
				layer_tips(1, '请输入正整数的积分');
				tr_obj.find("input[name='score']").focus();
				is_ok = false;
				return false;
			}
		}
		
		if(tr_obj.find("input[name='coupon_required']").prop("checked")) {
			var coupon = tr_obj.find("select[name='coupon']").val();
			if (!coupon) {
				layer_tips(1, '勾选的特权，请先选择或创建一个可用的优惠');
				tr_obj.find("select[name='coupon']").focus();
				is_ok = false;
				return false;
			}
			
		} 
		
		if(tr_obj.find("input[name='present_required']").prop("checked")) {
			var present = tr_obj.find("select[name='present']").val();
			if (!present) {
				layer_tips(1, '勾选的特权，请先选择或创建一个可用的赠品');
				tr_obj.find("select[name='present']").focus();
				is_ok = false;
				return false;
			}
			
		}
		
		if(!is_ok)  return false;

		$.post(load_url, {"name":name,"cash":cash,"product_quantity":product_quantity,"price":product_price,"coupon":coupon,"present":present,"page" : page_presale_create, "product_id" : product_id, "start_time" : start_time, "end_time" : end_time,"pay_time" : pay_time, "dingjin" : dingjin, "presale_person" : presale_person, "presale_amount" : presale_amount,"shuoming":shuoming, "is_submit" : "submit"}, function (data) {
			if (data.err_code == '0') {
				layer_tips(0, data.err_msg);
				var t = setTimeout(presaleList(), 2000);
				return;
			} else {
				layer_tips(1, data.err_msg);
				return;
			}
		});
	});
	
	// 修改保存
	$(".js-btn-edit-save").live("click", function () {
		var name = $("#name").val();
		var presale_id = $(".presale_edit_id").val();
		var dingjin = $(".dingjin").val();
		var product_price = $("input[name='yuanjia']").val();
		var product_quantity = $("input[name='quantity']").val();
		
		var presale_person = $(".presale_person").val();
		var start_time = $("#js-start-time").val();
		var end_time = $("#js-end-time").val();
		var pay_time = $("#js-pay-time").val();
		var presale_amount = $("#presale_amount").val();
		var buy_count = $("#buy_count").val();
		var shuoming = $("#shuoming").val();		
		var expire_number = $("#expire_number").val();
		var cash="";	var coupon="";	var present="";
		var is_ok=true;
		if($(".js-ico-list").find(".sort").size() == 1) {
			var product_id = $(".js-ico-list").find(".sort").data("pid");
		} else {
			layer_tips(1, '请至少选择一个产品作为预售产品！');
			return;
		}
		if(!name) {
			layer_tips(1, '预售标题不能为空！');
			$("#name").focus();
			return;
		}
		
		if(!presale_id) {
			layer_tips(1, '缺少需要修改的对象！');
			return;
		}
		
		if(!(/^(\+|-)?\d+[\.]?[0-9]{0,2}$/.test( dingjin )) || dingjin <= 0 ) {
			layer_tips(1, '请正确填写购买预售商品所需定金！');
			$(".dingjin").focus();
			return;
		}
		if((parseFloat(dingjin) >= parseFloat(product_price)) || (!product_price)) {
			layer_tips(1, '定金不能大于商品原价！');
			$(".dingjin").focus();
			return;
		}	
		
		if((parseInt(buy_count) > parseInt(product_quantity)) || (!product_quantity)) {
			layer_tips(1, '预售数量不能大于商品库存总量,或已均被预订！');
			$(".dingjin").focus();
			return;
		}			
		
		//alert(product_price);
		//return;
		if(!(/^(\+)?\d+$/.test( presale_person )) || presale_person <= 0 ) {
			layer_tips(1, '请正确填写初始预售人数！'+presale_person);
			$(".presale_person").focus();
			return;
		}
		
		if (start_time.length == 0) {
			layer_tips(1, '请选择预售开始时间！');
			$("#js-start-time").focus();
			return;
		}
		
		if (end_time.length == 0) {
			layer_tips(1, '请选择预售结束时间！');
			$("#js-end-time").focus();
			return;
		}
		if (pay_time.length == 0) {
			layer_tips(1, '请选择尾款支付截止时间！');
			$("#js-pay-time").focus();
			return;
		}	
		
		if(!(/^(\+)?\d+$/.test( presale_amount )) || presale_amount <= 0 ) {
			layer_tips(1, '请正确填写预售数量限制！');
			$(".presale_amount").focus();
			return;
		}	
		
		if(!shuoming) {
			layer_tips(1, '预售描述不能为空哦！');
			$(".shuoming").focus();
			return;
		}
		tr_obj = $(".reward-table-wrap");
		// 检查每个优惠方式
		if(tr_obj.find("input[name='cash_required']").prop("checked")) {
			cash = tr_obj.find("input[name='cash']").val();
			if (cash == "") {
				layer_tips(1, '勾选的特权，减现金不能为空');
				tr_obj.find("input[name='cash']").focus();
				is_ok = false;
				return false;
			} else if (isNaN(cash)) {
				layer_tips(1, '特权减现金，请输入有效的金额');
				tr_obj.find("input[name='cash']").focus();
				is_ok = false;
				return false;
			}
		}
		
		if(tr_obj.find("input[name='score_required']").prop("checked")) {
			var score = tr_obj.find("input[name='score']").val();
			if (score == "") {
				layer_tips(1, '请输入积分');
				tr_obj.find("input[name='score']").focus();
				is_ok = false;
				return false;
			}
			
			if(!(/^(\+|-)?\d+$/.test(score)) || score < 0) {
				layer_tips(1, '请输入正整数的积分');
				tr_obj.find("input[name='score']").focus();
				is_ok = false;
				return false;
			}
		}
		
		if(tr_obj.find("input[name='coupon_required']").prop("checked")) {
			var coupon = tr_obj.find("select[name='coupon']").val();
			if (!coupon) {
				layer_tips(1, '勾选的特权，请先选择或创建一个可用的优惠');
				tr_obj.find("select[name='coupon']").focus();
				is_ok = false;
				return false;
			}
			
		} 
		
		if(tr_obj.find("input[name='present_required']").prop("checked")) {
			var present = tr_obj.find("select[name='present']").val();
			if (!present) {
				layer_tips(1, '勾选的特权，请先选择或创建一个可用的赠品');
				tr_obj.find("select[name='present']").focus();
				is_ok = false;
				return false;
			}
			
		}
		
		if(!is_ok)  return false;

		$.post(load_url, {"name":name,"id":presale_id,"product_quantity":product_quantity,"price":product_price,"presale_id":presale_id,"cash":cash,"coupon":coupon,"present":present,"page" : page_presale_edit, "product_id" : product_id, "start_time" : start_time, "end_time" : end_time,"pay_time" : pay_time, "dingjin" : dingjin, "presale_person" : presale_person, "presale_amount" : presale_amount,"shuoming":shuoming, "is_submit" : "submit"}, function (data) {
			if (data.err_code == '0') {
				layer_tips(0, data.err_msg);
				var t = setTimeout(presaleList(), 2000);
				return;
			} else {
				layer_tips(1, data.err_msg);
				return;
			}
		});
	});
	
	// 使赠品失效
	$(".js-disabled").live("click", function (e) {
		var disabled_obj = $(this);
		var presale_id = disabled_obj.parent().data("presale_id");
		button_box($(this), e, 'left', 'confirm', '确认失效？<br />失效后预售将不能用', function(){
			$.get(disabled_url, {"id" : presale_id}, function (data) {
				close_button_box();
				t = setTimeout('msg_hide()', 3000);
				if (data.err_code == "0") {
				//	disabled_obj.closest("tr").find(".open_status").html("已结束");
				//	disabled_obj.html("使开启");
					layer_tips(0, data.err_msg);
					load_page('.app__content', load_url, {page : page_content, "type" : action, "p" : page}, '');
				} else {
					layer_tips(1, data.err_msg);
				}
			})
		})
	});
	
	// 删除赠品
	$('.js-delete').live("click", function(e){
		var delete_obj = $(this);
		var presale_id = $(this).parent().data('presale_id');
		$('.js-delete').addClass('active');
		button_box($(this), e, 'left', 'confirm', '确认删除？', function(){
			$.get(delete_url, {'id': presale_id}, function(data) {
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
	
	// 编辑资料
	$(".js-edit").live("click", function () {
		location_page($(this).attr("href"));
	});
	
	// 编辑资料
	$(".js-show").live("click", function () {
		location_page($(this).attr("href"));
	});	
	
	//会选择预售商品
	 var good_datas=[];var arrs=[];var strs;
	widget_link_box1($(".js-add-picture"),'do_self_soldout_good',function(result){
		console.log(result)
		var  good_data = pic_list;
		$('.js-goods-list .sort').remove();
		//html = '<tr><th class="cell-30">商品名称</th> <th class="cell-50">商品名称</th> <th class="cell-20">操作</th></tr>';
/*		for(var i in good_data) {
			var item = good_data[i];
			if($.inArray(item.id, arrs)>=0){
			}else{
				html += '<tr class="sort" data-pid="'+item.id+'"><td><a classs="aaa" href="' + item.url + '"  target="_blank"><img src="' + item.image + '"  alt="' + item.title + '" title="' + item.title + '" width="50" height="50"></a </td><td><a href="' + item.url + '" class="aaa">' + item.title + item.title + item.title + '</a></td> <td><a class=" js-delete-goods" href="javascript:void(0)" data-id="0" title="删除">×</a></td> </tr>';
				arrs.push(item.id);
				strs= arrs.join("-")
				$(".js-goods-list").attr("pid_arr",strs);
			}
		}
*/

		for(var i in result){
			item = result[i];
			var pic_list="";
			var list_size = $('.js-ico-list .sort').size();
			if(list_size > 0){
				layer_tips(1,'预售活动商品一次仅能选择一个！');
				return false;
			}				
			if($.inArray(item.id, arrs)>=0){
			
			}else{
				$('.js-ico-list').prepend('<li class="sort" data-pid="'+item.id+'"><a href="'+item.url+'" target="_blank"><img data-pid="'+item.id+'" alt="'+item.title+'" title="'+item.title+'" src="'+item.image+'"></a><a class="js-delete-picture close-modal small hide">×</a></li>');
				if(item.price > 0) {
					$(".yuanjia").show();
					$("input[name='yuanjia']").val(item.price);
				}
				
				if(item.quantity > 0) {
					$(".quantity").show();
					$("input[name='quantity']").val(item.quantity);
				}
				
				arrs.push(item.id);
				strs= arrs.join("-")
				$(".js-ico-list").attr("pid_arr",strs);
			}
		}
		

		

		//删除选取的商品
		$('.js-add-goods').find('.module-goods-list .sort .js-delete-goods').click(function(){
			$(this).closest('.sort').remove();
			var good_data = domHtml.data('goods');
			delete good_data[$(this).data('id')];
			domHtml.data('goods',good_data);
		});
	})
	
	$(".js-ico-list").find(".sort .js-delete-picture").live("click",function(){
		$(".yuanjia").hide();arrs=[];
		$(".quantity").hide();
		$("input[name='yuanjia']").val(0);		
		$("input[name='quantity']").val(0);		
		$(this).closest('.sort').remove();
	})
	//回车提交搜索
	$(window).keydown(function(event){
		if (event.keyCode == 13 && $('.js-presale-keyword').is(':focus')) {
			var keyword = $('.js-presale-keyword').val();
			var type = window.location.hash.substring(1);
			
			$('.app__content').load(load_url, {page : page_content, 'keyword' : keyword, 'type' : type}, function(){
			});
		}
	})
})

function presaleList() {
	location.href = "user.php?c=appmarket&a=presale";
}

function loadProduct(group_id, type, title, page) {
	load_page(".js_select_goods_loading", load_url, {"page" : page_product_list, "group_id" : group_id, "type" : type, "title" : title, "p" : page}, '', function() {
		checkProductStatus();
	});
}



// 检查已经设置为赠品，更改状态
function checkProductStatus() {
	var product_id = '';
	$(".js-show-presale").find(".current-presale").each(function () {
		product_id = $(this).data('product_id');
		try {
			$("#js-add-reward-" + product_id).html("已设为赠品");
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



/*
 * 小的弹出层
 *
 * param dom	  弹出层的ID 使用 $(this);
 * param e	      弹出层的ID点击返回事件 	使用 event;
 * param position 方向  					left,top,right,bottom
 * param type     弹出层的类别  			copy,edit_txt,delete,confirm,multi_txt,radio,input,url,module
 * param content  内容
 * param ok_obj   点击确认键的回调方法
 * param placeholder 点位符
 */
function button_box_self(dom,event,position,type,content,ok_obj,placeholder){
	var cancel_obj = arguments[7];
	event.stopPropagation();
	var left=0,top=0,width=0,height=0;
	var dom_offset = dom.offset();
	$('.popover').remove();
	if(type=='edit_txt'){
		$('body').append('<div class="popover '+position+'" style="left:-'+($(window).width()*5)+'px;top:'+$(window).scrollTop()+'px;"><div class="arrow"></div><div class="popover-inner popover-rename"><div class="popover-content"><div class="form-horizontal"><div class="control-group"><div class="controls"><input type="text" class="js-rename-placeholder" maxlength="256"/> <button type="button" class="btn btn-primary js-btn-confirm">确定</button> <button type="reset" class="btn js-btn-cancel">取消</button></div></div></div></div></div></div>');
		$('.js-rename-placeholder').attr('placeholder', content).focus();
		button_box_after();
	}  else if(type=='txm') {
		
			//$('body').append('<div class="popover '+position+'" style="left:-'+($(window).width()*5)+'px;top:'+$(window).scrollTop()+($(window).height()/2)+'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content"><div class="form-inline"><div class="input-append"><input type="text" class="txt js-url-placeholder url-placeholder" readonly="" value="'+content+'"/><button type="button" class="btn js-btn-copy">复制</button></div></div></div></div></div>');
			var ids = dom.data("id");

			var htmls = "";
				htmls += '<div class="popover '+position+'" style="left:-'+($(window).width()*5)+'px;top:'+$(window).scrollTop()+($(window).height()/2)+'px;">';
				htmls += '	<div class="arrow"></div>';
				htmls += '	<div style="width:120px;" class="popover-inner">';
				htmls += '		<div class="popover-content">';
				htmls += '			<div class="form-inline">';
				//htmls += '				<div class="input-append"><input type="text" class="txt js-url-placeholder url-placeholder" readonly="" value="'+content+'"/><button type="button" class="btn js-btn-copy">复制</button></div>';
				//alert(show_txm)
				//var ewm_url = '<?php echo option("config.site_url")."/source/qrcode.php?type=home&id=".$store_session['store_id'];?>';
				var ewm_url = presale_ewm_url+"&id="+ids;
				htmls += '				<div class="input-append"><img width="100" height="100" src="'+ewm_url+'"></div>';
				
				
				
				htmls += '			</div>';
				htmls += '		</div>';
				htmls += '	</div>';
				htmls += '</div>';
			
			$('body').append(htmls);
			
			/*
			$('.popover .js-btn-copy').zclip({
				path:'./static/js/plugin/ZeroClipboard.swf',
				copy:function(){
					return content;
				},
				afterCopy:function(){
					$('.popover').remove();
					layer_tips(0,'复制成功');
				}
			});
			*/
			// multi_choose_obj();
			button_box_after();
		
	}else if(type=='multi_txt') {
       // $('body').append('<div class="popover ' + position + '" style="left:-' + ($(window).width() * 5) + 'px;top:' + $(window).scrollTop() + 'px;"><div class="arrow"></div><div class="popover-inner popover-chosen"><div class="popover-content"><div class="select2-container select2-container-multi js-select2 select2-dropdown-open" style="width:242px;display:inline-block;"><ul class="select2-choices"><li class="select2-search-field">    <input type="text" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" id="s2id_autogen26" tabindex="-1" style="width:192px;"></li></ul></div> <button type="button" class="btn btn-primary js-btn-confirm" data-loading-text="确定">确定</button> <button type="reset" class="btn js-btn-cancel">取消</button></div></div></div>');
       // $('.popover-chosen .select2-input').attr('placeholder', content).focus();
		
		
		//$('body').append('<div class="popover ' + position + '" style="left:-' + ($(window).width() * 5) + 'px;top:' + $(window).scrollTop() + 'px;"><div class="arrow"></div><div class="popover-inner popover-chosen"><div class="popover-content"><div style="clear:both;width:100%" class="select2-container select2-container-multi js-select2 select2-dropdown-open" style="width:242px;display:inline-block;"><ul class="select2-choices" style="border:0px;background:none;"><li  class="select2-search-field" style="width:100%;height:40px;line-height:40px;">积分：    <div style="width:75%;display:inline-block;float:right"><input type="button" value="-" style="display:inline-block;width:20px;margin-right:8px;border:1px solid #a5a5a5;"><input type="text" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" id="s2id_autogen26" tabindex="-1" maxlength="4" size="4" style="width:50px;backgroun-image:-webkit-gradient(linear, 0% 0%, 0% 100%, color-stop(1%, #eee), color-stop(15%, #fff));border:1px solid #aaa;"><input type="button" value="+" style="border:1px solid #a5a5a5;display:inline-block;width:20px;margin-left:8px"></div></li></ul><ul class="select2-choices" style="border:0px;background:none;"><li class="select2-search-field" style="width:100%;height:40px;line-height:40px;">33理由：    <div style="width:75%;display:inline-block;float:right"><input type="text" maxlength="30" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" id="s2id_autogen26" tabindex="-1" style="width:192px;backgroun-image:-webkit-gradient(linear, 0% 0%, 0% 100%, color-stop(1%, #eee), color-stop(15%, #fff));border:1px solid #aaa;"></div></li></ul></div> <div style="padding-top:10px;text-align:center;width:100%"><button type="button" class="btn btn-primary js-btn-confirm" data-loading-text="确定">确定</button> <button type="reset" class="btn js-btn-cancel">取消</button></div></div></div></div>');
       // $('.popover-chosen .select2-input').attr('placeholder', content).focus();
			now_jf = dom.closest("tr").find(".td_jf").text();
		var tanchu  = '<div class="popover ' + position + '" style="left:-' + ($(window).width() * 5) + 'px;top:' + $(window).scrollTop() + 'px;">';
			tanchu += '	<div class="arrow"></div>';
			tanchu += '		<div class="popover-inner popover-chosen">';
			tanchu += '			<div class="popover-content">';
			tanchu += '				<div style="clear:both;width:100%" class="select2-container select2-container-multi js-select2 select2-dropdown-open" style="width:242px;display:inline-block;">';
			tanchu += '					<ul class="select2-choices" style="border:0px;background:none;">';
			tanchu += '						<li  class="select2-search-field" style="width:100%;height:40px;line-height:40px;">积分：    <div style="width:75%;display:inline-block;float:right">';
			
			tanchu += '							<input id="jf_before" type="button"  value="-" style="text-align:center;cursor:pointer;display:inline-block;width:20px;margin-right:8px;border:1px solid #a5a5a5;">';
			tanchu += '								<input id="jf_change" value="0" type="text" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" id="s2id_autogen26" tabindex="-1" maxlength="4" size="4" style="width:40px;backgroun-image:-webkit-gradient(linear, 0% 0%, 0% 100%, color-stop(1%, #eee), color-stop(15%, #fff));border:1px solid #aaa;">';
			tanchu += '							<input id="jf_after" type="button" value="+" style="text-align:center;border:1px solid #a5a5a5;display:inline-block;width:20px;margin-left:8px">';
			
			tanchu += '							<font style="color:#aaaaaa;font-size:11px;">当前拥有积分：'+now_jf+'</font>';
			tanchu +='						</div></li>';
			
			tanchu += '						<li  class="select2-search-field show_point_log" style="display:none;width:100%;height:22px;line-height:15px;"><div><p style="text-align:left;float:right;width:75%"><font id="show_point_log" style="font-size:10px;color:#f00;"> </font></p></div></li>';
			
			
			tanchu += '					</ul>';
			
			//tanchu += '<div><p style="text-align:left;float:right;width:75%">(*<font style="font-size:10px;color:#f00;"> 理由最多填写30字！</font>)</p></div>';
			
			tanchu += '					<ul class="select2-choices" style="border:0px;background:none;">';
			tanchu += '						<li class="select2-search-field" style="width:100%;height:40px;line-height:40px;">理由：    <div style="width:75%;display:inline-block;float:right"><input id="liyou" type="text" maxlength="30" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" id="s2id_autogen26" tabindex="-1" style="width:192px;backgroun-image:-webkit-gradient(linear, 0% 0%, 0% 100%, color-stop(1%, #eee), color-stop(15%, #fff));border:1px solid #aaa;"></div></li>';
			tanchu += '					</ul>';
			
			tanchu += '<div><p style="text-align:left;float:right;width:75%">(*<font style="font-size:10px;color:#f00;"> 理由最多填写30字！</font>)</p></div>';
			
			tanchu += '				</div>';
			tanchu += '				<div style="padding-top:10px;text-align:center;width:100%">';
			tanchu += '					<button type="button" class="btn btn-primary js-btn-confirm" data-loading-text="确定">确定</button>';
			tanchu += '					<button type="reset" class="btn js-btn-cancel">取消</button>';
			tanchu += '				</div>';
			tanchu += '			</div>';
			tanchu += '		</div>';
			tanchu += '</div>';
		
			$('body').append(tanchu);
        multi_choose_obj();
        button_box_after();
    }
 
	
	function button_box_after(){
		
		$('.popover .js-btn-cancel').one('click',function(){
			if (cancel_obj != undefined) {
				cancel_obj();
			} else {
				close_button_box();
			}
		});
		$('.popover .js-btn-confirm').one('click',function(){
			if(ok_obj){
				ok_obj();
			} else {
				close_button_box();
			}
		});
		$('.popover').click(function(e){
			e.stopPropagation();
		});
		if (cancel_obj == undefined) {
			$('body').bind('click',function(){
				close_button_box();
			});
		}

		var popover_height = $('.popover').height();
		var popover_width = $('.popover').width();
		switch(position){
			case 'left':
				$('.popover').css({top:dom_offset.top-(popover_height+10-dom.height())/2,left:dom_offset.left-popover_width-14});
				break;
            case 'right':
                $('.popover').css({top:dom_offset.top-(popover_height+10-dom.height())/2,left:dom_offset.left+dom.width() + 27});
                $('.popover-confirm').css('margin-left', '0');
                break;
            case 'top':
                $('.popover').css({top:(dom_offset.top - dom.height() - 40),left:dom_offset.left - (popover_width/2) + (dom.width()/2)});
                break;
			case 'bottom':
				$('.popover').css({top:dom_offset.top+dom.height()-3,left:dom_offset.left - (popover_width/2) + (dom.width()/2)});
				break;
		}
	}
	//添加商品添加规格专用方法
	function multi_choose_obj(){
		
		var re = /(^\+|^\-)?[1-9][0-9]*$/;
		var re1 = /(^\+)?[1-9][0-9]*$/;
		var re2 = /(^\-){1}[1-9][0-9]*$/;
		$(".show_point_log").show();
		$("#jf_change").live("keyup",function(){
			var keyup_jf = $(this).val();
			if (re.test(keyup_jf)) {
				if(re1.test(keyup_jf)) {
					
					$("#show_point_log").text("增加积分："+ $(this).val())
				} 
				if(re2.test(keyup_jf)) {
					$("#show_point_log").text("减少积分："+ $(this).val())
				}
			} else {
				$("#show_point_log").text("参数不合法！")
			}

		})

		$("#jf_before").click(function(){
			var keyup_jf = $("#jf_change").val();
			if(keyup_jf == '0') {
				keyup_jf = parseInt(keyup_jf)-1;
				$("#jf_change").val(keyup_jf);
				$("#show_point_log").text("减少积分："+ keyup_jf)
			} else {
				if (re.test(keyup_jf)) {
					
					
					keyup_jf = parseInt(keyup_jf)-1;
					$("#jf_change").val(keyup_jf);
					
					if(keyup_jf>0) {
						$("#show_point_log").text("增加积分："+ keyup_jf)
					} else if(keyup_jf < 0) {
						$("#show_point_log").text("减少积分："+ keyup_jf)
					} else {
						$("#show_point_log").text("");
					}
					
					
				} else {
					//不满足
					$("#show_point_log").text("积分填写异常")
				}
			}	
		})
		
		$("#jf_after").click(function(){
			var keyup_jf = $("#jf_change").val();
			if(keyup_jf == '0') {
				keyup_jf = parseInt(keyup_jf)+1;
				$("#jf_change").val(keyup_jf);
				$("#show_point_log").text("增加积分："+ keyup_jf)
			} else {
				if (re.test(keyup_jf)) {
					
					
					keyup_jf = parseInt(keyup_jf)+1;
					$("#jf_change").val(keyup_jf);
					
					if(keyup_jf>0) {
						$("#show_point_log").text("增加积分："+ keyup_jf)
					} else if(keyup_jf < 0) {
						$("#show_point_log").text("减少积分："+ keyup_jf)
					} else {
						$("#show_point_log").text("");
					}
					
					
				} else {
					//不满足
					$("#show_point_log").text("积分填写异常")
				}
			}	
		})
		
		$('.popover-chosen .select2-input').keyup(function(event){
			var input_select2 = $.trim($(this).val());
			if(event.keyCode == 13 && input_select2.length != 0){
				var html = $('<li class="select2-search-choice"><div>'+input_select2+'</div><a href="#" class="select2-search-choice-close" tabindex="-1" onclick="$(this).closest(\'li\').remove();$(\'.popover-chosen .select2-input\').focus();"></a></li>');
				if($('.popover-chosen .select2-choices .select2-search-choice').size() > 0){
					var has_li = false;
					$.each($('.popover-chosen .select2-choices .select2-search-choice'),function(i,item){
						if($(item).find('div').html() == input_select2){
							has_li = true;
							return false;
						}
					});
					if(has_li === false){
						$('.popover-chosen .select2-choices .select2-search-choice:last').after(html);
					}else{
						layer_tips(1,'已经存在相同的规格');
						$(this).val('').focus();
						return;
					}
				}else{
					$('.popover-chosen .select2-choices').prepend(html);
				}
				
				var r = getRandNumber();
				html.attr('data-vid', r);
				html.attr('check-data-vid', r);
				
				$.post(get_property_value_url,{pid:dom.closest('.sku-sub-group').find('.js-sku-name').attr('data-id'),txt:input_select2},function(result){
					if(result.err_code == 0){
						html.attr('data-vid',result.err_msg);
						
						if ($("#r_" + r).size() > 0) {
							$("#r_" + r).attr("atom-id", result.err_msg);
						}
					}else{
						layer_tips(result.err_msg);
						html.remove();
					}
				});
				$(this).removeAttr('placeholder').val('').focus();
			}
		});
	}

}