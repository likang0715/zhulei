/**
 * Created by ediancha on 2016/8/9.
 */
function location_page(location_type,mark, page){
	var mark_arr = mark.split('/');
	switch(location_type){
		
		case 'tag':
				switch(mark_arr[0]){
				case '#create':
					load_page('.app__content', load_url,{page:'tag_create'}, '');
					break;
				case "#edit":
					if(mark_arr[1]){
						load_page('.app__content', load_url,{page:'tag_edit',id:mark_arr[1]},'',function(){

						});
					}else{
						layer.alert('非法访问！');
						location.hash = '#list';
						location_page('');
					}
					break;

					
				default:
					load_page('.app__content', load_url,{page:'tag_content',"type": 'all', "p" : page}, '');
				}				
			break;
			
		case 'points':
				switch(mark_arr[0]){
				case '#create':
					load_page('.app__content', load_url,{page:'points_create'}, '');
					break;
				case "#edit":
					if(mark_arr[1]){
						load_page('.app__content', load_url,{page:'points_edit',id:mark_arr[1]},'',function(){

						});
					}else{
						layer.alert('非法访问！');
						location.hash = '#list';
						location_page('');
					}
					break;	
				default:
					load_page('.app__content', load_url,{page:'points_content',"type": 'all', "p" : page}, '');
				}					
			break;
	
	}

}
$(function() {
   // load_page('.app__content', load_url, {page:'coupon_index'}, '');
})


$(function() {
	location_page(location_type,location.hash, 1);

	$(".js-list-filter-region a").live('click', function () {
		var action = $(this).attr("href");
		location_page(location_type,action, 1)
	});

	$(".js-page-list a").live("click", function () {
		var page = $(this).data("page-num");
		location_page(location_type,window.location.hash, page);
	});




	$('a').live('click',function(){
		if($(this).attr('href') && $(this).attr('href').substr(0,1) == '#') location_page(location_type,$(this).attr('href'),$(this));
	});

	//下载tag csv	
	$(".downloadtag").live("click",function(){

		$.post(page_downloadcsv,"",function(){
			
			
			
		})		
		
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
		var p = $(this).attr('data-page-num');
		location_page(location_type,window.location.hash, p);

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
		
		switch(location_type) {
		
		case 'tag':
			
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
			//等级有效期
			var degree_month = $("input[name='degree_month']").val();
			//积分抵现上限 （每单） 
			var points_discount_toplimit = $("input[name='points_discount_toplimit']").val();
			//积分在订单金额抵现比例
			var points_discount_ratio = $("input[name='points_discount_ratio']").val();
			
			var chk_value =[]; 
			$('input[name="power"]:checked').each(function(){
				chk_value.push($(this).val());
			}); 
			
			//折扣选中
			if(jQuery.inArray("check_discount", chk_value)>=0) {
				if(discount == "10.0" || discount == "0" || discount =='10' || discount == '0.0'){
						clear_error_tips($("input[name='discount']"));
					} else if(!(/^[0-9]{1}[\.]?[0-9]{0,1}$/.test(discount))) {
						is_exists_err = true;
						error_tips($("input[name='discount']"), '请输入一个数字,且最多只可包含一位小数');
					} else {
						clear_error_tips($("input[name='discount']"));
				}
			} else {
				clear_error_tips($("input[name='discount']"));
			}

			//包邮选中
			if(jQuery.inArray("check_is_postage_free", chk_value)>=0) {
				
			}

			//积分抵现上限 （每单） 
			if(jQuery.inArray("check_points_discount_toplimit", chk_value)>=0) {
				
				if(!(/^(\+|-)?\d+$/.test( points_discount_toplimit )) || points_discount_toplimit <= 0 ) {
					is_exists_err = true;
	
					error_tips($("input[name='points_discount_toplimit']"), '积分抵现上限 必须为大于0的整数哦！');
				}else{
					clear_error_tips($("input[name='points_discount_toplimit']"));
				}
			}

			//积分在订单金额抵现比例
			if(jQuery.inArray("check_points_discount_ratio", chk_value)>=0) {
				if(!(/^(\+|-)?\d+$/.test( points_discount_ratio )) || points_discount_ratio <= 0 || points_discount_ratio >= 100) {
					is_exists_err = true;
					error_tips($("input[name='points_discount_ratio']"), '积分在订单抵现比例需是小于100的整数！');
				}else{
					clear_error_tips($("input[name='points_discount_ratio']"));
				}
			}

			if(!(/^(\+|-)?\d+$/.test( degree_month )) || degree_month <= 0 ) {
				is_exists_err = true;
				error_tips($("input[name='degree_month']"), '等级有效期需是大于0的整数哦！');
			} else {
				clear_error_tips($("input[name='degree_month']"));
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
			
			
			break;
		
		//积分表单验证
		case 'points':
			var points = $("input[name='give_points']").val();
			var type = $("input[name='item_checkbox']:checked").val();
			var trade_limit = $("input[name='trade_limit']").val();
			var amount_limit = $("input[name='amount_limit']").val();
			var is_call_to_fans = $("input[name='is_call_to_fans']").val();
				
			switch(input_name) {
				case 'give_points':
					if(!(/^(\+|-)?\d+$/.test( points )) || points < 0 || points== '' || points> 9999) {
						error_tips( $("input[name='give_points']"),'积分必须是一个小于9999整数');
					} else {
						clear_error_tips($("input[name='give_points']"));
					}
					break;
					
				case 'item_checkbox':
				case 'trade_limit':	
				case 'amount_limit':	
					var type_arr = [ '1' , '2' , '3' ];
					if(jQuery.inArray(type, type_arr) == -1) {
						error_tips($("input[name='item_checkbox']").closest('.controlss'), '选一个奖励条件吧！')	
					} else {
						clear_error_tips($("input[name='item_checkbox']").closest('.controlss'));
					}
					if(input_name == 'item_checkbox') {
						clear_error_tips($("input[name='trade_limit']"));
						clear_error_tips($("input[name='amount_limit']"));
					} else {
						if(!(/^(\+|-)?\d+$/.test( type )) || type < 0 || type== '') {
							if(input_name == 'trade_limit') {
								if(type == '2')	error_tips($("input[name='item_checkbox']").closest('.control-group'), '交易笔数不能为空！')
							} else {
								if(type == '3')	error_tips($("input[name='item_checkbox']").closest('.control-group'), '购买金额不能为空！')	
							}
						}	
					}
					break;
				}
			break;
		}	
	}
	
	

	//表单提交验证
	function check_form() {
		
		var is_exists_err = false;
		switch(location_type) {
			
			case 'tag':
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
				//等级有效期
				var degree_month = $("input[name='degree_month']").val();
				//积分抵现上限 （每单） 
				var points_discount_toplimit = $("input[name='points_discount_toplimit']").val();
				//积分在订单金额抵现比例
				var points_discount_ratio = $("input[name='points_discount_ratio']").val();
				
				var chk_value =[]; 
				$('input[name="power"]:checked').each(function(){
					chk_value.push($(this).val());
				}); 
				
				//折扣选中
				if(jQuery.inArray("check_discount", chk_value)>=0) {
					if(discount == "10.0" || discount == "0" || discount =='10' || discount == '0.0'){
							clear_error_tips($("input[name='discount']"));
						} else if(!(/^[0-9]{1}[\.]?[0-9]{0,1}$/.test(discount))) {
							//alert('aa')
							is_exists_err = true;
							error_tips($("input[name='discount']"), '请输入一个数字,且最多只可包含一位小数');
						} else {
							clear_error_tips($("input[name='discount']"));
					}
				} else {
					clear_error_tips($("input[name='discount']"));
				}

				//包邮选中
				if(jQuery.inArray("check_is_postage_free", chk_value)>=0) {
					
				}

				//积分抵现上限 （每单） 
				if(jQuery.inArray("check_points_discount_toplimit", chk_value)>=0) {
					
					if(!(/^(\+|-)?\d+$/.test( points_discount_toplimit )) || points_discount_toplimit <= 0 ) {
						is_exists_err = true;
						//alert('bb')
						error_tips($("input[name='points_discount_toplimit']"), '积分抵现上限 必须为大于0的整数哦！');
					}else{
						clear_error_tips($("input[name='points_discount_toplimit']"));
					}
				}

				//积分在订单金额抵现比例
				if(jQuery.inArray("check_points_discount_ratio", chk_value)>=0) {
					if(!(/^(\+|-)?\d+$/.test( points_discount_ratio )) || points_discount_ratio <= 0 || points_discount_ratio >= 100) {
						is_exists_err = true;
						//alert('cc')
						error_tips($("input[name='points_discount_ratio']"), '积分在订单抵现比例需是小于100的整数！');
					}else{
						clear_error_tips($("input[name='points_discount_ratio']"));
					}
				}

				if(!(/^(\+|-)?\d+$/.test( degree_month )) || degree_month <= 0 ) {
					is_exists_err = true;
					//alert('dd')
					error_tips($("input[name='degree_month']"), '等级有效期需是大于0的整数哦！');
				} else {
					clear_error_tips($("input[name='degree_month']"));
				}
				
				
				//选择的ico图标
				var list_size = $('.js-ico-list li .selected-style').size();
				if(list_size) {
					clear_error_tips($('.js-ico-list'));
				} else {
					is_exists_err = true;
					//alert('ee')
					error_tips($('.js-ico-list li'), '请选择等级图标！')
				}
				
				
				if(rule_type == 5) {
					if(!rule_name) {
						is_exists_err = true;
						//alert('ff')
						error_tips($("input[name='rule_name']"), '标签名称不能为空')
					}else {
						clear_error_tips($("input[name='rule_name']"));
					}
				} else {
					var arr_rule_type = ['1', '2', '3', '4' ];
					if(jQuery.inArray(rule_type, arr_rule_type) == '-1') {
						//alert('gg')
						error_tips($("input[name='rule_name']"), '会员类别请选择！')
					} else {
						clear_error_tips($("input[name='rule_name']"));
					}
				}
				
				if(trade_limit) {
					if(!(/^(\+|-)?\d+$/.test( trade_limit )) || trade_limit < 0 ) {
						is_exists_err = true;
						//alert('hh')
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
						//alert('ii')
						error_tips($("input[name='level_num']"), '等级值需是整数')
					}else{
						clear_error_tips($("input[name='level_num']"));
					}			
				} else{
					error_tips($("input[name='level_num']"), '等级值必须大于0')
				}
				
				if(amount_limit) {
					if(!(/^(\+|-)?\d+$/.test( amount_limit )) || amount_limit < 0 ) {
						is_exists_err = true;
						//alert('jj')
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
						//alert('kk')
						error_tips($("input[name='points_limit']"), '累计积分必须大于等于0')
					}else{
						clear_error_tips($("input[name='points_limit']"));
					}
				}else{
					//clear_error_tips($("input[name='points_limit']"));
					is_exists_err = true;
					//alert('ll')
					error_tips($("input[name='points_limit']"), '累计积分必须大于等于0')
				}
					
				if(!description) {
					is_exists_err = true;
					//alert('mm')
					error_tips($("textarea[name='description']"), '使用须知不能为空！')
				} else {
					clear_error_tips($("textarea[name='description']"));
				}
					
				
				break;
			
			//积分表单验证
			case 'points':
				var points = $("input[name='give_points']").val();
				var type = $("input[name='item_checkbox']:checked").val();
				var trade_limit = $("input[name='trade_limit']").val();
				var amount_limit = $("input[name='amount_limit']").val();
				var is_call_to_fans = $("input[name='is_call_to_fans']").val();
				
				var type_arr = [ '1' , '2' , '3' ];

				
				if(!(/^(\+|-)?\d+$/.test( points )) || points < 0 || points== '') {
					is_exists_err = true;
					error_tips($("input[name='give_points']"), '积分必须是一个整数')
				} 
				
				if(jQuery.inArray(type, type_arr) == -1) {
					is_exists_err = true;
					error_tips($("input[name='item_checkbox']").closest('.controlss'), '选一个奖励条件吧！')	
				
				}
				
				if(type == '2') {
					if(!(/^(\+|-)?\d+$/.test( trade_limit )) || trade_limit < 0 || trade_limit== '') {
						is_exists_err = true;
						error_tips($("input[name='trade_limit']"), '交易笔数不能为空！')	
					}
				}				
					
				if(type == '3') {
					if(!(/^(\+|-)?\d+$/.test( amount_limit )) || amount_limit < 0 || amount_limit== '') {
						is_exists_err = true;
						error_tips($("input[name='amount_limit']"), '购买金额不能为空！')	
					}
				}	
				break;
		
		}
		
		return is_exists_err;
	}
	




	
	
	//返回列表页
	$(".js-btn-quit").live("click", function () {
		switch(location_type) {
			case 'tag':
					location.href = "user.php?c=fans&a=tag";
				break;
				
			case 'points':
					location.href = "user.php?c=fans&a=points";
				break;
		}	
	})
	
	
	//添加-保存
	$(".js-btn-add-save").live('click',function(){
		var is_exists_err1 = false;
		switch(location_type) {
			//标签添加保存	
			case 'tag':
				//验证表单
			 	if(check_form()){return false;}	

				var trade_limit = $("input[name='trade_limit']").val();
				var amount_limit = $("input[name='amount_limit']").val();
				var points_limit =  $("input[name='points_limit']").val();
				//折扣
				var discount = $("input[name='discount']").val();
					dsicount = discount ? discount : '0';
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
					var level_pic = $('.js-ico-list li .selected-style img').attr('src');
				} else {
					is_exists_err1 = true;
					error_tips($('.js-ico-list li'), '请选择等级图标！')
				}
				
				//等级有效期
				var degree_month = $("input[name='degree_month']").val();
				    degree_month = degree_month ? degree_month : '0';
				//积分抵现上限 （每单） 
				var points_discount_toplimit = $("input[name='points_discount_toplimit']").val();
					points_discount_toplimit = points_discount_toplimit ? points_discount_toplimit : '0';
				//积分在订单金额抵现比例
				var points_discount_ratio = $("input[name='points_discount_ratio']").val();
					points_discount_ratio = points_discount_ratio ? points_discount_ratio : '0';
				
				var chk_value =[]; 
				$('input[name="power"]:checked').each(function(){
					chk_value.push($(this).val());
				}); 
				
				//折扣选中
				if(jQuery.inArray("check_discount", chk_value)>=0) {
					if(discount == "10.0" || discount == "0" || discount =='10' || discount == '0.0'){
							clear_error_tips($("input[name='discount']"));
						} else if(!(/^[0-9]{1}[\.]?[0-9]{0,1}$/.test(discount))) {
							is_exists_err = true;
							error_tips($("input[name='discount']"), '请输入一个数字,且最多只可包含一位小数');
						} else {
							clear_error_tips($("input[name='discount']"));
					}
				} else {
					clear_error_tips($("input[name='discount']"));
				}

				//包邮选中
				if(jQuery.inArray("check_is_postage_free", chk_value)>=0) {
					
				}

				//积分抵现上限 （每单） 
				if(jQuery.inArray("check_points_discount_toplimit", chk_value)>=0) {
					if(!(/^(\+|-)?\d+$/.test( points_discount_toplimit )) || points_discount_toplimit <= 0 ) {
						is_exists_err = true;
						error_tips($("input[name='points_discount_toplimit']"), '积分抵现上限 必须为大于0的整数哦！');
					} else{
						clear_error_tips($("input[name='points_discount_toplimit']"));
					}
				}

				//积分在订单金额抵现比例
				if(jQuery.inArray("check_points_discount_ratio", chk_value)>=0) {
					if(!(/^(\+|-)?\d+$/.test( points_discount_ratio )) || points_discount_ratio <= 0 || points_discount_ratio >= 100) {
						is_exists_err = true;
						error_tips($("input[name='points_discount_ratio']"), '积分在订单抵现比例需是小于100的整数！');
					} else{
						clear_error_tips($("input[name='points_discount_ratio']"));
					}
				}

				if(!(/^(\+|-)?\d+$/.test( degree_month )) || degree_month <= 0 ) {
					is_exists_err = true;
					error_tips($("input[name='degree_month']"), '等级有效期需是大于0的整数哦！');
				} else {
					clear_error_tips($("input[name='degree_month']"));
				}				
				

				

				//是否包邮
				var is_postage_free =0;
				if($("#is_postage_free").is(':checked')) {
					is_postage_free = 1;
				}
		

				
				if(rule_type == 5) {
					if(!rule_name) {
						is_exists_err1 = true;
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
						is_exists_err1 = true;
						error_tips($("input[name='trade_limit']"), '累计成功交易笔数必须大于等于0')
					}else{
						clear_error_tips($("input[name='trade_limit']"));
					}
				}else{
					clear_error_tips($("input[name='trade_limit']"));
				}
				
				if(level_num) {
					if(!(/^(\+|-)?\d+$/.test( level_num )) || level_num < 0 ) {
						is_exists_err1 = true;
						error_tips($("input[name='level_num']"), '等级值需是整数')
					}else{
						clear_error_tips($("input[name='level_num']"));
					}			
				} else{
					error_tips($("input[name='level_num']"), '等级值必须大于0')
				}
				

				
				if(amount_limit) {
					if(!(/^(\+|-)?\d+$/.test( amount_limit )) || amount_limit < 0 ) {
						is_exists_err1 = true;
						error_tips($("input[name='amount_limit']"), '累计购买金额必须大于等于0')
					}else{
						clear_error_tips($("input[name='amount_limit']"));
					}
				}else{
					clear_error_tips($("input[name='amount_limit']"));
				}
				
				if(points_limit) {
					if(!(/^(\+|-)?\d+$/.test( points_limit )) || points_limit < 0 ) {
						is_exists_err1 = true;
						error_tips($("input[name='points_limit']"), '累计积分必须大于等于0')
					}else{
						clear_error_tips($("input[name='points_limit']"));
						
					}
				}else{
					//clear_error_tips($("input[name='points_limit']"));
					is_exists_err1 = true;
					error_tips($("input[name='points_limit']"), '累计积分必须大于等于0')
				}
					
				if(!description) {
					is_exists_err1 = true;
					error_tips($("textarea[name='description']"), '使用须知不能为空！')
				} else {
					clear_error_tips($("textarea[name='description']"));
				}	 	

				if(is_exists_err1) return false;
				
				$.post(load_url, {"page" : page_create,"power":chk_value,"degree_month":degree_month,"points_discount_toplimit":points_discount_toplimit,"points_discount_ratio":points_discount_ratio, "is_postage_free":is_postage_free, "level_pic":level_pic, "discount":discount, "level_num":level_num, "rule_name" : rule_name, "rule_type" : rule_type,"description" : description, "trade_limit" : trade_limit, "amount_limit" : amount_limit, "points_limit" : points_limit, "is_submit" : "submit"}, function (data) {

					if (data.err_code == '0') {
						layer_tips(0, data.err_msg);
						
						var t = setTimeout(returnurl(), 2000);
						return;
					} else {
						layer_tips(1, data.err_msg);
						return;
					}
				});
				
				
				break;
				
			//积分添加保存	
			case 'points':
					//验证表单
				 	if(check_form()){return false;}	
					var points = $("input[name='give_points']").val();
					var type = $("input[name='item_checkbox']:checked").val();
					var trade_limit = $("input[name='trade_limit']").val();
					var amount_limit = $("input[name='amount_limit']").val();
					//var is_call_to_fans = $("input[name='is_call_to_fans']").val();
					var is_call_to_fans ="0";
					var money_or_trade = "";
					switch(type) {
						case '1':
								if($("#call_weixin").is(":checked")) {
									is_call_to_fans =1;
								}
							break;
							
						case '2':
								if($("#call_trade").is(":checked")) {
									is_call_to_fans =1;
								}	
								if(!(/^(\+|-)?\d+$/.test( trade_limit )) || trade_limit < 0 || trade_limit== '') {
									is_exists_err = true;
									error_tips($("input[name='trade_limit']"), '交易笔数不能为空！');
									return false;
								}
							
								money_or_trade = trade_limit;
							break;
						
						case '3':
								if($("#call_amount").is(":checked")) {
									is_call_to_fans =1;
								}	
								if(!(/^(\+|-)?\d+$/.test( amount_limit )) || amount_limit < 0 || amount_limit== '') {
									is_exists_err = true;
									error_tips($("input[name='amount_limit']"), '购买金额不能为空！');
									return false;
								}
								money_or_trade = amount_limit;
							break;
					}
					
				$.post(load_url, {"page" : page_create, "type":type, "points" : points, "money_or_trade" : money_or_trade, "is_call_to_fans":is_call_to_fans, "is_submit" : "submit"}, function (data) {

					if (data.err_code == '0') {
						layer_tips(0, data.err_msg);
						var t = setTimeout(returnurl(), 2000);
						return;
					} else {
						layer_tips(1, data.err_msg);
						return;
					}
				});
				break;
		
		}
		
	
		
	})

	//点击标签 ico图标
	$(".controls .ico li").live('click',function(){
				clear_error_tips($('.js-ico-list'));
				$(".controls .ico li .checkico").removeClass("selected-style").removeClass("no-selected-style").addClass("no-selected-style");
				$(this).find(".checkico").removeClass("no-selected-style").addClass("selected-style")
	})
	
	//修改-保存
	$(".js-btn-edit-save").live('click',function(){
		
		switch(location_type) {
			//标签修改保存	
			case 'tag':
				//验证表单
				if(check_form()){return false;}	
	
			 	var id = $("#tag").val();
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
					var level_pic = $('.js-ico-list li .selected-style img').attr('src');
				} else {
					is_exists_err1 = true;
					error_tips($('.js-ico-list li'), '请选择等级图标！')
				}
				

				//等级有效期
				var degree_month = $("input[name='degree_month']").val();
				    degree_month = degree_month ? degree_month : '0';
				//积分抵现上限 （每单） 
				var points_discount_toplimit = $("input[name='points_discount_toplimit']").val();
					points_discount_toplimit = points_discount_toplimit ? points_discount_toplimit : '0';
				//积分在订单金额抵现比例
				var points_discount_ratio = $("input[name='points_discount_ratio']").val();
					points_discount_ratio = points_discount_ratio ? points_discount_ratio : '0';
				
				//var points_exchange_type = $("input[name='points_exchange_type']:checked").val();
				var degree_month = $("input[name='degree_month']").val();
					
				var chk_value =[]; 
				$('input[name="power"]:checked').each(function(){
					chk_value.push($(this).val());
				}); 
				
				//折扣选中
				if(jQuery.inArray("check_discount", chk_value)>=0) {
					if(discount == "10.0" || discount == "0" || discount =='10' || discount == '0.0'){
							clear_error_tips($("input[name='discount']"));
						} else if(!(/^[0-9]{1}[\.]?[0-9]{0,1}$/.test(discount))) {
							is_exists_err = true;
							error_tips($("input[name='discount']"), '请输入一个数字,且最多只可包含一位小数');
						} else {
							clear_error_tips($("input[name='discount']"));
					}
				} else {
					clear_error_tips($("input[name='discount']"));
				}

				//包邮选中
				if(jQuery.inArray("check_is_postage_free", chk_value)>=0) {
					
				}

				//积分抵现上限 （每单） 
				if(jQuery.inArray("check_points_discount_toplimit", chk_value)>=0) {
					
					if(!(/^(\+|-)?\d+$/.test( points_discount_toplimit )) || points_discount_toplimit <= 0 ) {
						is_exists_err = true;
		
						error_tips($("input[name='points_discount_toplimit']"), '积分抵现上限 必须为大于0的整数哦！');
					}else{
						clear_error_tips($("input[name='points_discount_toplimit']"));
					}
				}

				//积分在订单金额抵现比例
				if(jQuery.inArray("check_points_discount_ratio", chk_value)>=0) {
					if(!(/^(\+|-)?\d+$/.test( points_discount_ratio )) || points_discount_ratio <= 0 || points_discount_ratio >= 100) {
						is_exists_err = true;
						error_tips($("input[name='points_discount_ratio']"), '积分在订单抵现比例需是小于100的整数！');
					}else{
						clear_error_tips($("input[name='points_discount_ratio']"));
					}
				}

				if(!(/^(\+|-)?\d+$/.test( degree_month )) || degree_month <= 0 ) {
					is_exists_err = true;
					error_tips($("input[name='degree_month']"), '等级有效期需是大于0的整数哦！');
				} else {
					clear_error_tips($("input[name='degree_month']"));
				}

				//是否包邮
				var is_postage_free =0;
				if($("#is_postage_free").is(':checked')) {
					is_postage_free = 1;
				}
		
				if(rule_type == 5) {
					if(!rule_name) {
						is_exists_err1 = true;
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
						is_exists_err1 = true;
						error_tips($("input[name='trade_limit']"), '累计成功交易笔数必须大于等于0')
					}else{
						clear_error_tips($("input[name='trade_limit']"));
					}
				}else{
					clear_error_tips($("input[name='trade_limit']"));
				}
				
				if(level_num) {
					if(!(/^(\+|-)?\d+$/.test( level_num )) || level_num < 0 ) {
						is_exists_err1 = true;
						error_tips($("input[name='level_num']"), '等级值需是整数')
					}else{
						clear_error_tips($("input[name='level_num']"));
					}			
				} else{
					error_tips($("input[name='level_num']"), '等级值必须大于0')
				}
				

				
				
				if(amount_limit) {
					if(!(/^(\+|-)?\d+$/.test( amount_limit )) || amount_limit < 0 ) {
						is_exists_err1 = true;
						error_tips($("input[name='amount_limit']"), '累计购买金额必须大于等于0')
					}else{
						clear_error_tips($("input[name='amount_limit']"));
					}
				}else{
					clear_error_tips($("input[name='amount_limit']"));
				}
				
				if(points_limit) {
					if(!(/^(\+|-)?\d+$/.test( points_limit )) || points_limit < 0 ) {
						is_exists_err1 = true;
						error_tips($("input[name='points_limit']"), '累计积分必须大于等于0')
					}else{
						clear_error_tips($("input[name='points_limit']"));
						
					}
				}else{
					//clear_error_tips($("input[name='points_limit']"));
					is_exists_err1 = true;
					error_tips($("input[name='points_limit']"), '累计积分必须大于等于0')
				}
					
				if(!description) {
					is_exists_err1 = true;
					error_tips($("textarea[name='description']"), '使用须知不能为空！')
				} else {
					clear_error_tips($("textarea[name='description']"));
				}	 	


				$.post(load_url, {"page" : page_edit,"power":chk_value,"degree_month":degree_month,"points_discount_toplimit":points_discount_toplimit,"points_discount_ratio":points_discount_ratio,"id":id, "is_postage_free":is_postage_free,"level_pic":level_pic, "discount":discount, "level_num":level_num, "rule_name" : rule_name, "rule_type" : rule_type,"description" : description,  "trade_limit" : trade_limit, "amount_limit" : amount_limit, "points_limit" : points_limit, "is_submit" : "submit"}, function (data) {

					if (data.err_code == '0') {
						layer_tips(0, data.err_msg);
						var t = setTimeout(returnurl(), 2000);
						return;
					} else {
						layer_tips(1, data.err_msg);
						return;
					}
				});
				
				
				break;
				
			//积分修改保存	
			case 'points':
					//验证表单
				 	if(check_form()){return false;}	
					var points = $("input[name='give_points']").val();
					var type = $("input[name='item_checkbox']:checked").val();
					var trade_limit = $("input[name='trade_limit']").val();
					var amount_limit = $("input[name='amount_limit']").val();
					//var is_call_to_fans = $("input[name='is_call_to_fans']").val();
					var is_call_to_fans ="0";
					var money_or_trade = "";
					var id=$("#points").val();
					if(!id){
						layer_tips('8',"缺少必要参数！")
						return false;
					}	
					switch(type) {
						case '1':
								if($("#call_weixin").is(":checked")) {
									is_call_to_fans =1;
								}
							break;
							
						case '2':
								if($("#call_trade").is(":checked")) {
									is_call_to_fans =1;
								}	
								if(!(/^(\+|-)?\d+$/.test( trade_limit )) || trade_limit < 0 || trade_limit== '') {
									is_exists_err = true;
									error_tips($("input[name='trade_limit']"), '交易笔数不能为空！');
									return false;
								}
							
								money_or_trade = trade_limit;
							break;
						
						case '3':
								if($("#call_amount").is(":checked")) {
									is_call_to_fans =1;
								}	
								if(!(/^(\+|-)?\d+$/.test( amount_limit )) || amount_limit < 0 || amount_limit== '') {
									is_exists_err = true;
									error_tips($("input[name='amount_limit']"), '购买金额不能为空！');
									return false;
								}
								money_or_trade = amount_limit;
							break;
					}
					
					
					
				
				$.post(load_url, {"page" : page_edit,"id":id, "type":type, "points" : points, "money_or_trade" : money_or_trade, "is_call_to_fans":is_call_to_fans, "is_submit" : "submit"}, function (data) {

					if (data.err_code == '0') {
						layer_tips(0, data.err_msg);
						var t = setTimeout(returnurl(), 2000);
						return;
					} else {
						layer_tips(1, data.err_msg);
						return;
					}
				});
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


	// 删除
	$('.js_degree_delete').live("click", function(e){
		var delete_obj = $(this);
		var id = $(this).attr('data');
		$('.js-delete').addClass('active');
		
		var confrm_tips = "确认删除，<br><span style='#f00' class='red'>您只能删除未被用户占用的等级哦！</span>";
		
		button_box($(this), e, 'left', 'confirm', confrm_tips, function(){
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
					
				$('.js-ico-list .sort:last').after('<li class="sort"><div class="spans"><span class="checkico no-selected-style"><i class="icon-ok icon-white"></i><img class="avatar" src="'+pic_list[i]+'"></span><a class="js-delete-picture close-modal small hide">×</a></div></li>');
				
				
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


	//启用会员等级提升是否消耗积分
	$('.member_degree  .ui-switch-off').live('click', function(e) {
		var obj = this;
		$.post(degree_exchange_type_url, {'status':1}, function(data){
			if (data) {
				$(obj).removeClass('ui-switch-off').addClass('ui-switch-on');
			}
		});
	});

	//关闭会员等级提升是否消耗积分
	$('.member_degree  .ui-switch-on').live('click', function(e){
		var obj = this;
		$.post(degree_exchange_type_url, {'status':2}, function(data){
			if (data) {
				$(obj).removeClass('ui-switch-on').addClass('ui-switch-off');
			}
		});
	});



// 积分规则失效
	$(".js-disabled").live("click", function (e) {
        var disabled_obj = $(this);
        var js_disabled_index = $(".js-disabled").index($(this));
        var jf_id = disabled_obj.closest("td").attr("data");
        
        button_box($(this), e, 'left', 'confirm', '确定让这组积分规则失效?<br><span class="red">失效后将导致该规则无法在客户进行交易中产生积分变更！</span>', function(){
            $.get(disabled_url, {"id" : jf_id}, function (data) {
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
    var jf_id = disabled_obj.closest("td").attr("data");

    button_box($(this), e, 'left', 'confirm', '确定让这组积分规则开启?', function(){
        $.get(able_url, {"id" : jf_id}, function (data) {
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