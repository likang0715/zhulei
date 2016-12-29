/**
 * Created by pigcms-s on 2015/09/11.
 */
$(function() {
   // load_page('.app__content', load_url, {page:'coupon_index'}, '');
})


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
	function location_page(mark, page) {
		var mark_arr = mark.split('/');

		switch(mark_arr[0]) {
			case '#create':
					load_page('.app__content', load_url,{page:'degree_create'}, '');
				break;
			
			case "#edit":
				if(mark_arr[1]){
					load_page('.app__content', load_url,{page:'degree_edit',id:mark_arr[1]},'',function(){
					});
				}else{
					layer.alert('非法访问！');
					location.hash = '#list';
					location_page('');
				}
				break;

				default:
					load_page('.app__content', load_url,{page:'degree_content',"type": 'all', "p" : page}, '');
		}
	}
	
	// 切换标签名称
	$(".js-degree_id").live("click", function () {
		// 不可以自定义时，名称与图标是一一对应的
		if (is_custom) {
			return;
		}
		var degree_id = $(this).val();
		$("#degree_icon_" + degree_id).closest(".js-ico-list").find("span").removeClass("selected-style").addClass("no-selected-style");
		$("#degree_icon_" + degree_id).closest("span").removeClass("no-selected-style").addClass("selected-style");
		
		// 如果没有自定义图标时，用普通等级图标
		if ($("#degree_icon_" + degree_id).size() == 0) {
			$(".js-ico-list").find("span").removeClass("selected-style").addClass("no-selected-style");
			$(".js-ico-list").find("li:last").find("span").removeClass("no-selected-style").addClass("selected-style");
		}
	});

	//搜索框动画
	$('.ui-search-box :input').live('focus', function(){
		$(this).animate({width: '180px'}, 100);
	})
	$('.ui-search-box :input').live('blur', function(){
		$(this).animate({width: '70px'}, 100);
	})

	//分页
	$('.pagenavi > a').live('click', function(e){
		var p = $(this).attr('data-page-num');
		location_page(window.location.hash, p);

	});

	//错误提示设定
	function error_tips(obj,message){
		obj.closest(".control-group").addClass('error');
		obj.closest(".control-group").find(".error-message").remove();
		if(message == '选一个奖励条件吧！'){
			var err_message = '<p class="help-block error-message" style="width:270px;text-align:right;color:#b94a48">'+message+'</p>';
		} else {
			var err_message = '<p class="help-block error-message">'+message+'</p>';
		}
		
		obj.closest(".controls").append(err_message);
	}
	
	//清除错误提示设定
	function clear_error_tips(obj){
		obj.closest(".control-group").removeClass('error');
		obj.closest(".control-group").find(".error-message").remove();
	}

	
	//失焦事件
	$(".app__content input").live("blur",function(){
		var input_name = $(this).attr("name");
		check_form_blur(input_name);
	})	
	
	//表单失焦
	function check_form_blur(input_name) {

			
			var trade_limit = $("input[name='trade_limit']").val();
			var amount_limit = $("input[name='amount_limit']").val();
			var points_limit =  $("input[name='points_limit']").val();
			//折扣
			var discount = $("input[name='discount']").val();
			//等级值
			var level_num =  $("input[name='level_num']").val();
			//会员标签类别
			var rule_type = $("input[name='rule_type']:checked").val();
			var rule_name = $("input[name='rule_name']").val();
			//使用须知
			var description = $(".description").val();
			
			if(rule_type == 5) {
				if(!rule_name) {
					is_exists_err = true;
					error_tips($("input[name='rule_name']"), '标签名称不能为空')
				}else {
					clear_error_tips($("input[name='rule_name']"));
				}
			} else {
				var arr_rule_type = ['1', '2', '3', '4' ];
				if(jQuery.inArray(rule_type, arr_rule_type) == '-1') {
					error_tips($("input[name='rule_name']"), '会员类别请选择！')
				} else {
					clear_error_tips($("input[name='rule_name']"));
				}
			}
			
			if(trade_limit) {
				if(!(/^(\+|-)?\d+$/.test( trade_limit )) || trade_limit < 0 ) {
					is_exists_err = true;
					error_tips($("input[name='trade_limit']"), '累计成功交易笔数必须大于等于0')
				}else{
					clear_error_tips($("input[name='trade_limit']"));
				}
			}else{
				clear_error_tips($("input[name='trade_limit']"));
			}
			
			if(level_num) {
				if(!(/^(\+|-)?\d+$/.test( level_num )) || level_num < 0 ) {
					is_exists_err = true;
					error_tips($("input[name='level_num']"), '等级值需是整数')
				}else{
					clear_error_tips($("input[name='level_num']"));
				}			
			} else{
				error_tips($("input[name='level_num']"), '等级值必须大于0')
			}
			
			if(discount){
				if(discount == "10.0" || discount == "0" || discount =='10' || discount == '0.0'){
					clear_error_tips($("input[name='discount']"));
				} else if(!(/^[0-9]{1}[\.]?[0-9]{0,1}$/.test(discount))) {
					is_exists_err = true;
					error_tips($("input[name='discount']"), '请输入一个数字,且最多只可包含一位小数')
				} else {
					clear_error_tips($("input[name='discount']"));
				}
			} else {
				clear_error_tips($("input[name='discount']"));
			}
			
			
			if(amount_limit) {
				if(!(/^(\+|-)?\d+$/.test( amount_limit )) || amount_limit < 0 ) {
					is_exists_err = true;
					error_tips($("input[name='amount_limit']"), '累计购买金额必须大于等于0')
				}else{
					clear_error_tips($("input[name='amount_limit']"));
				}
			}else{
				clear_error_tips($("input[name='amount_limit']"));
			}
			
			if(points_limit) {
				if(!(/^(\+|-)?\d+$/.test( points_limit )) || points_limit < 0 ) {
					is_exists_err = true;
					error_tips($("input[name='points_limit']"), '累计积分必须大于等于0')
				}else{
					clear_error_tips($("input[name='points_limit']"));
				}
			}else{
				//clear_error_tips($("input[name='points_limit']"));
				is_exists_err = true;
				error_tips($("input[name='points_limit']"), '累计积分必须大于等于0')
			}
				
			if(!description) {
				error_tips($("textarea[name='description']"), '使用须知不能为空！')
			} else {
				clear_error_tips($("textarea[name='description']"));
			}
			
			
		
		
		
	}
	
	

	//表单提交验证
	function check_form() {
		
		var is_exists_err = false;

				//验证表单
				var trade_limit = $("input[name='trade_limit']").val();
				var amount_limit = $("input[name='amount_limit']").val();
				var points_limit =  $("input[name='points_limit']").val();
				//折扣
				var discount = $("input[name='discount']").val();
				//等级值
				var level_num =  $("input[name='level_num']").val();
				//会员标签类别
				var rule_type = $("input[name='rule_type']:checked").val();
				var rule_name = $("input[name='rule_name']").val();
				//使用须知
				var description = $(".description").val();
				
				//选择的ico图标
				var list_size = $('.js-ico-list li .selected-style').size();
				if(list_size) {
					clear_error_tips($('.js-ico-list'));
				} else {
					is_exists_err = true;
					error_tips($('.js-ico-list li'), '请选择等级图标！')
				}
				
				
				if(rule_type == 5) {
					if(!rule_name) {
						is_exists_err = true;
						error_tips($("input[name='rule_name']"), '标签名称不能为空')
					}else {
						clear_error_tips($("input[name='rule_name']"));
					}
				} else {
					var arr_rule_type = ['1', '2', '3', '4' ];
					if(jQuery.inArray(rule_type, arr_rule_type) == '-1') {
						error_tips($("input[name='rule_name']"), '会员类别请选择！')
					} else {
						clear_error_tips($("input[name='rule_name']"));
					}
				}
				
				if(trade_limit) {
					if(!(/^(\+|-)?\d+$/.test( trade_limit )) || trade_limit < 0 ) {
						is_exists_err = true;
						error_tips($("input[name='trade_limit']"), '累计成功交易笔数必须大于等于0')
					}else{
						clear_error_tips($("input[name='trade_limit']"));
					}
				}else{
					clear_error_tips($("input[name='trade_limit']"));
				}
				
				if(level_num) {
					if(!(/^(\+|-)?\d+$/.test( level_num )) || level_num < 0 ) {
						is_exists_err = true;
						error_tips($("input[name='level_num']"), '等级值需是整数')
					}else{
						clear_error_tips($("input[name='level_num']"));
					}			
				} else{
					error_tips($("input[name='level_num']"), '等级值必须大于0')
				}
				
				if(discount){
					if(discount == "10.0"){
						clear_error_tips($("input[name='discount']"));
					} else if(!(/^[0-9]{1}[\.]?[0-9]{0,1}$/.test(discount))) {
						is_exists_err = true;
						error_tips($("input[name='discount']"), '请输入一个数字,且最多只可包含一位小数')
					} else {
						clear_error_tips($("input[name='discount']"));
					}
				} else {

					clear_error_tips($("input[name='discount']"));
				}
				
				
				if(amount_limit) {
					if(!(/^(\+|-)?\d+$/.test( amount_limit )) || amount_limit < 0 ) {
						is_exists_err = true;
						error_tips($("input[name='amount_limit']"), '累计购买金额必须大于等于0')
					}else{
						clear_error_tips($("input[name='amount_limit']"));
					}
				}else{
					clear_error_tips($("input[name='amount_limit']"));
				}
				
				if(points_limit) {
					if(!(/^(\+|-)?\d+$/.test( points_limit )) || points_limit < 0 ) {
						is_exists_err = true;
						error_tips($("input[name='points_limit']"), '累计积分必须大于等于0')
					}else{
						clear_error_tips($("input[name='points_limit']"));
					}
				}else{
					//clear_error_tips($("input[name='points_limit']"));
					is_exists_err = true;
					error_tips($("input[name='points_limit']"), '累计积分必须大于等于0')
				}
					
				if(!description) {
					is_exists_err = true;
					error_tips($("textarea[name='description']"), '使用须知不能为空！')
				} else {
					clear_error_tips($("textarea[name='description']"));
				}

		
		return is_exists_err;
	}
	

	
	//返回列表页
	$(".js-btn-quit").live("click", function () {
		location.href = "user.php?c=fx&a=degree";
	})
	
	
	//添加-保存
	$(".js-btn-add-save").live('click',function(){
		var is_exists_err1 = false;

				//验证表单
				//验证表单
				is_exists_err1 = false;
			 	degree_id = $("input[name='degree_id']:checked").val();
				degree_name = $("input[name='now_degree_name']").val();
			 	//等级值
				var level_num =  $("input[name='level_num']").val();
				//选择的ico图标
				var list_size = $('.js-ico-list li .selected-style').size();
				//积分达标条件
				var points_limit =  $("input[name='points_limit']").val();
				//使用须知
				var description = $(".description").val();
				//一级分销商奖励比率
				var seller_reward_1 = $("input[name='seller_reward_1']").val();
				//二级分销商奖励比率
				var seller_reward_2 = $("input[name='seller_reward_2']").val();
				//三级分销商奖励比率
				var seller_reward_3 = $("input[name='seller_reward_3']").val();
				
				
			 	if(!degree_id) {
			 		is_exists_err1 = true;
			 		error_tips($("input[name='degree_id']"), '等级类型尚未选择哦！')
			 	}
			 	
			 	if(degree_id == 'now') {
			 		if(!degree_name) {
			 			is_exists_err1 = true;
				 		error_tips($("input[name='degree_id']"), '等级名称不能为空！')
			 		}
			 	}
			 	
				if(level_num) {
					if(!(/^(\+|-)?\d+$/.test( level_num )) || level_num < 0 ) {
						is_exists_err1 = true;
						error_tips($("input[name='level_num']"), '等级值需是整数！')
					}else{
						clear_error_tips($("input[name='level_num']"));
					}			
				} else{
					error_tips($("input[name='level_num']"), '等级值必须大于0！')
				}
				
				if(list_size) {
					clear_error_tips($('.js-ico-list'));
					var pic = $('.js-ico-list li .selected-style img').attr('src');
					var pic_type = $('.js-ico-list li .selected-style img').data("type"); 
				} else {
					is_exists_err1 = true;
					error_tips($('.js-ico-list li'), '请选择等级图标！')
				}
				
				if(points_limit) {
					if(!(/^(\+|-)?\d+$/.test( points_limit )) || points_limit < 0 ) {
						is_exists_err1 = true;
						error_tips($("input[name='points_limit']"), '达标的积分必须大于等于0！')
					}else{
						clear_error_tips($("input[name='points_limit']"));
					}
				}else{
					is_exists_err1 = true;
					error_tips($("input[name='points_limit']"), '达标的积分必须大于等于0！')
				}
				
				
				if(seller_reward_1){
					if( seller_reward_1 == "0" ||  seller_reward_1 == '0.0' ||  seller_reward_1 == '00.0') {
						clear_error_tips($("input[name='seller_reward_1']"));
					} else if(!(/^[0-9]{1,2}[\.]?[0-9]{0,1}$/.test(seller_reward_1))) {
						is_exists_err1 = true;
						error_tips($("input[name='seller_reward_1']"), '请输入两个数字,且最多只可包含一位小数！')
					} else {
						clear_error_tips($("input[name='seller_reward_1']"));
					}
				} else {
					clear_error_tips($("input[name='seller_reward_1']"));
				}
				
				if(seller_reward_2){
					if( seller_reward_2 == "0" ||  seller_reward_2 == '0.0' ||  seller_reward_2 == '00.0') {
						clear_error_tips($("input[name='seller_reward_2']"));
					} else if(!(/^[0-9]{1,2}[\.]?[0-9]{0,1}$/.test(seller_reward_2))) {
						is_exists_err1 = true;
						error_tips($("input[name='seller_reward_2']"), '请输入两个数字,且最多只可包含一位小数！')
					} else {
						clear_error_tips($("input[name='seller_reward_2']"));
					}
				} else {
					clear_error_tips($("input[name='seller_reward_2']"));
				}
				
				if(seller_reward_3){
					if( seller_reward_3 == "0" ||  seller_reward_3 == '0.0' || seller_reward_3 == '00.0') {
						clear_error_tips($("input[name='seller_reward_1']"));
					} else if(!(/^[0-9]{1,2}[\.]?[0-9]{0,1}$/.test(seller_reward_3))) {
						is_exists_err1 = true;
						error_tips($("input[name='seller_reward_3']"), '请输入两个数字,且最多只可包含一位小数！')
					} else {
						clear_error_tips($("input[name='seller_reward_3']"));
					}
				} else {
					clear_error_tips($("input[name='seller_reward_3']"));
				}				
				
				
				if(!description) {
					is_exists_err1 = true;
					error_tips($("textarea[name='description']"), '使用须知不能为空！')
				} else {
					clear_error_tips($("textarea[name='description']"));
				}	
				
				if(is_exists_err1) {
					return false;
				}

		
				$.post(load_url, {"page" : page_create,"seller_reward_1":seller_reward_1,"seller_reward_2":seller_reward_2,"seller_reward_3":seller_reward_3,"pic_type":pic_type,"level_pic":pic, "level_num":level_num, "degree_id":degree_id,"degree_name" : degree_name, "description" : description,  "points_limit" : points_limit, "is_submit" : "submit"}, function (data) {

					if (data.err_code == '0') {
						layer_tips(0, data.err_msg);
						
						var t = setTimeout(returnurl(), 3000);
						return;
					} else {
						layer_tips(1, data.err_msg);
						return;
					}
				});

		
	
		
	})

	//点击标签 ico图标
	$(".controls .ico li").live('click',function(){
		// 不可以自定义时，不给修改
		if (!is_custom) {
			return;
		}
		
		clear_error_tips($('.js-ico-list'));
		$(".controls .ico li .checkico").removeClass("selected-style").removeClass("no-selected-style").addClass("no-selected-style");
		$(this).find(".checkico").removeClass("no-selected-style").addClass("selected-style")
	})
	
	//修改-保存
	$(".js-btn-edit-save").live('click',function(){
				
				//标签修改保存	
	
				//验证表单
				is_exists_err1 = false;
			 	degree_id = $("input[name='degree_id']:checked").val();
				degree_name = $("input[name='now_degree_name']").val();
			 	//等级值
				var level_num =  $("input[name='level_num']").val();
				//选择的ico图标
				var list_size = $('.js-ico-list li .selected-style').size();
				//积分达标条件
				var points_limit =  $("input[name='points_limit']").val();
				//使用须知
				var description = $(".description").val();
				//一级分销商奖励比率
				var seller_reward_1 = $("input[name='seller_reward_1']").val();
				//二级分销商奖励比率
				var seller_reward_2 = $("input[name='seller_reward_2']").val();
				//三级分销商奖励比率
				var seller_reward_3 = $("input[name='seller_reward_3']").val();
				
				
			 	if(!degree_id) {
			 		is_exists_err1 = true;
			 		error_tips($("input[name='degree_id']"), '等级类型尚未选择哦！')
			 	}
			 	
			 	if(degree_id == 'now') {
			 		if(!degree_name) {
			 			is_exists_err1 = true;
				 		error_tips($("input[name='degree_id']"), '等级名称不能为空！')
			 		}
			 	}
			 	
				if(level_num) {
					if(!(/^(\+|-)?\d+$/.test( level_num )) || level_num < 0 ) {
						is_exists_err1 = true;
						error_tips($("input[name='level_num']"), '等级值需是整数！')
					}else{
						clear_error_tips($("input[name='level_num']"));
					}			
				} else{
					error_tips($("input[name='level_num']"), '等级值必须大于0！')
				}
				
				if(list_size) {
					clear_error_tips($('.js-ico-list'));
					var pic = $('.js-ico-list li .selected-style img').attr('src');
					var pic_type = $('.js-ico-list li .selected-style img').data("type"); 
				} else {
					is_exists_err1 = true;
					error_tips($('.js-ico-list li'), '请选择等级图标！')
				}
				
				if(points_limit) {
					if(!(/^(\+|-)?\d+$/.test( points_limit )) || points_limit < 0 ) {
						is_exists_err1 = true;
						error_tips($("input[name='points_limit']"), '达标的积分必须大于等于0！')
					}else{
						clear_error_tips($("input[name='points_limit']"));
					}
				}else{
					is_exists_err1 = true;
					error_tips($("input[name='points_limit']"), '达标的积分必须大于等于0！')
				}
				
				
				if(seller_reward_1){
					if( seller_reward_1 == "0" ||  seller_reward_1 == '0.0') {
						clear_error_tips($("input[name='seller_reward_1']"));
					} else if(!(/^[0-9]{1,2}[\.]?[0-9]{0,1}$/.test(seller_reward_1))) {
						is_exists_err1 = true;
						error_tips($("input[name='seller_reward_1']"), '请输入两个数字,且最多只可包含一位小数！')
					} else {
						clear_error_tips($("input[name='seller_reward_1']"));
					}
				} else {
					clear_error_tips($("input[name='seller_reward_1']"));
				}
				
				if(seller_reward_2){
					if( seller_reward_2 == "0" ||  seller_reward_2 == '0.0') {
						clear_error_tips($("input[name='seller_reward_2']"));
					} else if(!(/^[0-9]{1,2}[\.]?[0-9]{0,1}$/.test(seller_reward_2))) {
						is_exists_err1 = true;
						error_tips($("input[name='seller_reward_2']"), '请输入两个数字,且最多只可包含一位小数！')
					} else {
						clear_error_tips($("input[name='seller_reward_2']"));
					}
				} else {
					clear_error_tips($("input[name='seller_reward_2']"));
				}
				
				if(seller_reward_3){
					if( seller_reward_3 == "0" ||  seller_reward_3 == '0.0') {
						clear_error_tips($("input[name='seller_reward_1']"));
					} else if(!(/^[0-9]{1,2}[\.]?[0-9]{0,1}$/.test(seller_reward_3))) {
						is_exists_err1 = true;
						error_tips($("input[name='seller_reward_3']"), '请输入两个数字,且最多只可包含一位小数！')
					} else {
						clear_error_tips($("input[name='seller_reward_3']"));
					}
				} else {
					clear_error_tips($("input[name='seller_reward_3']"));
				}				
				
				
				if(!description) {
					is_exists_err1 = true;
					error_tips($("textarea[name='description']"), '使用须知不能为空！')
				} else {
					clear_error_tips($("textarea[name='description']"));
				}	
				
				if(is_exists_err1) {
					return false;
				}
				
				id = $("#degree").val();
				$.post(load_url, {"id":id,"page" : page_edit,"seller_reward_1":seller_reward_1,"seller_reward_2":seller_reward_2,"seller_reward_3":seller_reward_3,"id":id,"pic_type":pic_type,"level_pic":pic, "level_num":level_num, "degree_id":degree_id,"degree_name" : degree_name, "description" : description,  "points_limit" : points_limit, "is_submit" : "submit"}, function (data) {
					if (data.err_code == '0') {
						layer_tips(0, data.err_msg);
						var t = setTimeout(returnurl(), 3000);
						return;
					} else {
						layer_tips(1, data.err_msg);
						return;
					}
				});
				
				

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
		strLenCalc(textObj,'syzs',60);
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
			var contents = obj.val().substr(0,30);
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
			$.get(delete_url, {'pigcms_id': id}, function(data) {
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



//会员标签管理 图片上传
$('.js-add-picture').live('click',function(){
	upload_pic_box(1,true,function(pic_list){
		if(pic_list.length > 0){
			for(var i in pic_list){
				var list_size = $('.js-ico-list .sort').size();
				if(list_size > 7){
					layer_tips(1,'等级图表 一次最多支持 选1张');
					return false;
				}else if(list_size > 0){
					//$('.js-ico-list .sort:last').after('<li class="sort"><a href="'+pic_list[i]+'" target="_blank"><img src="'+pic_list[i]+'"></a><a class="js-delete-picture close-modal small hide">×</a></li>');
					
				$('.js-ico-list .sort:last').after('<li class="sort"><div class="spans"><span class="checkico no-selected-style"><i class="icon-ok icon-white"></i><img data-type="now" class="avatar" src="'+pic_list[i]+'"></span><a class="js-delete-picture close-modal small hide">×</a></div></li>');
				
				
				}else{
					$('.js-ico-list').prepend('<li class="sort"><a href="'+pic_list[i]+'" target="_blank"><img src="'+pic_list[i]+'"></a><a class="js-delete-picture close-modal small hide">×</a></li>');
				}
			}
		}
	},15);
});

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
// 积分规则失效
	$(".js-disabled").live("click", function (e) {
        var disabled_obj = $(this);
        var js_disabled_index = $(".js-disabled").index($(this));
        var degree_id = disabled_obj.closest("tr").data("id");
        
        button_box($(this), e, 'left', 'confirm', '确定让这组分销等级规则失效?', function(){
            $.get(disabled_url, {"id" : degree_id,"type":'disabled'}, function (data) {
                close_button_box();
                if (data.err_code == "0") {
                    disabled_obj.closest("tr").find(".zt").html("<font color='#f00'>已失效</font>");
                    $(".js-disabled").eq(js_disabled_index).removeClass("js-disabled").addClass("js-able").html("使开启")
                    layer_tips(0, data.err_msg);
                } else {
                    layer_tips(1, data.err_msg);
                }
            })
        });
    });

//积分规则开启
$(".js-able").live("click", function (e) {
    var disabled_obj = $(this);
    var js_able_index = $(".js-able").index($(this));
    var degree_id = disabled_obj.closest("tr").data("id");

    button_box($(this), e, 'left', 'confirm', '确定让这组分销等级规则开启?', function(){
        $.get(disabled_url, {"id" : degree_id,"type":'able'}, function (data) {
            close_button_box();
            if (data.err_code == "0") {
            	 disabled_obj.closest("tr").find(".zt").html("已开启");
                 $(".js-able").eq(js_able_index).removeClass("js-able").addClass("js-disabled").html("使失效")
                layer_tips(0, data.err_msg);
            } else {
                layer_tips(1, data.err_msg);
            }
        })
    });
});