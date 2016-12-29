/**
 * Created by pigcms-s on 2015/09/11.
 */
   var page = 1; //页码 
$(function() {
   // load_page('.app__content', load_url, {page:'coupon_index'}, '');

})


$(function() {
	
	location_page(location.hash, 1);



	$(".js-page-list a").live("click", function () {
        var start_point = $('input[name="start_point"]').val();
        var end_point =$('input[name="end_point"]').val();
		var page = $(this).data("page-num");
        load_page('.app__content', load_url,{page:'member_content',"type": 'all',"start_point":start_point,"end_point":end_point, "p" : page}, '');
	});

	function location_page(mark, page){
		var mark_arr = mark.split('/');

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
						load_page('.app__content', load_url,{page:'member_content',"type": 'all', "p" : page}, '');
					}				


	}

	//搜索框动画
	$('.ui-search-box :input').live('focus', function(){
		$(this).animate({width: '180px'}, 100);
	})
	$('.ui-search-box :input').live('blur', function(){
		$(this).animate({width: '70px'}, 100);
	})

	//失焦事件
	$(".app__content input").live("blur",function(){
		var input_name = $(this).attr("name");
	//	check_form_blur(input_name);
	})	
	

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
						error_tips($("input[name='points_discount_toplimit']"), '1积分抵现上限 必须为大于0的整数哦！');
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
				
				var points_exchange_type = $("input[name='points_exchange_type']:checked").val();
				
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
						error_tips($("input[name='points_discount_toplimit']"), '1积分抵现上限 必须为大于0的整数哦！');
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
				
				$.post(load_url, {"page" : page_create,"power":chk_value,'points_exchange_type':points_exchange_type,"degree_month":degree_month,"points_discount_toplimit":points_discount_toplimit,"points_discount_ratio":points_discount_ratio, "is_postage_free":is_postage_free, "level_pic":level_pic, "discount":discount, "level_num":level_num, "rule_name" : rule_name, "rule_type" : rule_type,"description" : description, "trade_limit" : trade_limit, "amount_limit" : amount_limit, "points_limit" : points_limit, "is_submit" : "submit"}, function (data) {

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
				
				var points_exchange_type = $("input[name='points_exchange_type']:checked").val();
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
		
						error_tips($("input[name='points_discount_toplimit']"), '1积分抵现上限 必须为大于0的整数哦！');
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
				////alert("修改保存禁止");return;
				


				$.post(load_url, {"page" : page_edit,"power":chk_value,'points_exchange_type':points_exchange_type,"degree_month":degree_month,"points_discount_toplimit":points_discount_toplimit,"points_discount_ratio":points_discount_ratio,"id":id, "is_postage_free":is_postage_free,"level_pic":level_pic, "discount":discount, "level_num":level_num, "rule_name" : rule_name, "rule_type" : rule_type,"description" : description,  "trade_limit" : trade_limit, "amount_limit" : amount_limit, "points_limit" : points_limit, "is_submit" : "submit"}, function (data) {

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
	
	//显示用户条形码
	$(".js_show_txm").live("click",function(e) {
		
		edit_html  = "<div style='width:300px;display:block'><p>积分：<input style='width:50px;' type='text'></p>";
		edit_html += "<p>理由：<input type='text'></p>";
		edit_html += "</div>";		
		button_box_self($(this),e,'bottom','txm',edit_html,function(){
			
			
		})
	})


	//修改积分
	$(".js_edit_jifen").live("click",function(e) {
		var edit_jifen_obj = $(this);
		delete_url2 = "";
		var edit_this = $(".js_edit_jifen").index($(this));
		edit_html  = "<div style='width:300px;display:block'><p>积分：<input style='width:50px;' type='text'></p>";
		edit_html += "<p>理由：<input type='text'></p>";
		edit_html += "</div>";
		$("#jf_change").val("");
		$("#liyou").val("");
		

		
		
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
	})


	
	//查看会员
	$(".js-show-user").live("click",function(){
		var html_loading;
		var obj_this = $(this);
		html_loading += '<td colspan="6" height="28"><center>';
		html_loading += '	<img src="/template/user/default/images/loading-0.gif">';
		html_loading += '</center></td>';
		
		$(this).closest("tr").after("<tr class='user_info_tr'>"+html_loading+"</tr>");
		var uid = $(this).closest("tr").data("uid");
		
		$(".li_img").removeClass("li_img_hide li_img_show").addClass("li_img_show")
		//当前点击的用户已显示 即隐藏
		if($(".show_more_uid_"+uid).size()){
			$(".user_info_tr").empty().detach();
			
			$(this).find(".li_img").removeClass("li_img_hide li_img_show").addClass("li_img_show");
			return false;
		}
		

		var this_obj = $(this);
		
		$.ajax({
			  url: show_userdetail_url,
			  data: {"uid":uid},
			//  async: false,
			//  cache: false,
			  type: 'POST',
			  dataType:'json',
			  success: function (objs) {
				//alert(obj)
				var obj = objs.err_msg;
				if(obj.nickname) {
					nickname = obj.nickname;
				} else {
					nickname = "匿名用户";
				}
				
				if(obj.phone) {
					phone = obj.phone;
				} else {
					phone = "无手机账号";
				}
				if(obj.point) {
					points = obj.point;
				} else {
					points = "0";
				}
				if(obj.point_count) {
					points_count = obj.point_count;
				} else {
					points_count = "0";
				}
				if(obj.order_pay_acount) {
					order_pay_acount = "￥"+obj.order_pay_acount;
				} else {
					order_pay_acount = "暂未统计";
				}
				if(obj.order_complete) {
					order_complete = obj.order_complete+"笔";
				} else {
					order_complete = "暂未统计";
				}
				if(obj.order_unsend) {
					order_unsend = obj.order_unsend+"笔";
				} else {
					order_unsend = "暂未统计";
				}
				if(obj.order_send) {
					order_send = obj.order_send+"笔";
				} else {
					order_send = "暂未统计";
				}				
				var htmls="";	
					
					
					
				htmls += '		<td colspan="7">';
				htmls += '			<table width="100%" class="user_info_table">';
				htmls += '				<tr>';
				htmls += '					<td class="tright w20">昵称：</td>';
				htmls += '					<td class="tleft w30" >'+nickname+' </td>';
				htmls += '					<td class="tright w20">联系电话：</td>';
				htmls += '					<td class="tleft w30">'+phone+' </td>';
				htmls += '				</tr>';
				htmls += '				<tr>';
				htmls += '					<td class="tright">会员id：</td>';
				htmls += '					<td class="tleft">'+obj.uid+' </td>';
				htmls += '					<td class="tright">成为会员时间：</td>';
				htmls += '					<td class="tleft">'+obj.reg_time+' </td>';
				htmls += '				</tr>';
				htmls += '				<tr>';
				htmls += '					<td class="tright">当前店铺积分：</td>';
				htmls += '					<td class="tleft"">'+points+' </td>';
				htmls += '					<td class="tright">成长值：</td>';
				htmls += '					<td class="tleft">'+points_count+' </td>';
				htmls += '				</tr>';
				htmls += '				<tr>';
				htmls += '					<td class="tright">本店累计消费金额：</td>';
				htmls += '					<td class="tleft">'+order_pay_acount+' </td>';
				htmls += '					<td class="tright">本店交易完成订单数：</td>';
				htmls += '					<td class="tleft">'+order_complete+' </td>';
				htmls += '				</tr>';
				htmls += '				<tr>';
				htmls += '					<td class="tright">未发货订单数：</td>';
				htmls += '					<td class="tleft">'+order_unsend+' </td>';
				htmls += '					<td class="tright">已发货订单数：</td>';
				htmls += '					<td class="tleft">'+order_send+' </td>';
				htmls += '				</tr>';			
				htmls += '			</table>';
				htmls += '		</td>';
				//htmls += '	</tr>';

				$(".user_info_tr").empty().detach();
			
				obj_this.find(".li_img").removeClass("li_img_hide li_img_show").addClass("li_img_hide");	
				this_obj.closest("tr").after("<tr class='user_info_tr show_more_uid_"+uid+"'>"+htmls+"</tr>");	
				

				
			}
		})
		
		
		
		

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


//删除图片
$('.js-delete-picture').live('click', function(){
    $(this).closest('li').remove();
})

//标签列表 显示详细
$(".show_more").live("click",function(){
	var show_more_data = $(this).attr("data");
	layer.alert("使用须知 ：" +show_more_data,'1','使用须知');
})






//搜索查询操作
$(".js_search").live("click",function() {
	
	
	var select_type = $(".select_type option:selected") .val();
	var input_type = $("input[name='input_type']").val();
	var select_degree = $("select[name='select_degree'] option:selected").val();
	
	var start_point = $("input[name='start_point']").val();
	var end_point = $("input[name='end_point']").val();
	
	var select_time_type = $("select[name='time_type'] option:selected").val();
	
	var start_time = $("input[name='start_time']").val();
	var end_time = $("input[name='end_time']").val();
	
	load_page('.app__content', now_content_url, { 'status': status, 'p': page,'select_type':select_type,'input_type':input_type,'select_degree':select_degree,'start_point':start_point,'end_point':end_point,'select_time_type':select_time_type,'start_time':start_time,'end_time':end_time}, '', function(){
		
		//赋值
		$(".select_type").find("option[value='"+select_type+"']").attr("selected",true);
		$("input[name='input_type']").val(input_type);
		$("select[name='select_degree']").find("option[value='"+select_degree+"']").attr("selected",true);
		
		$("input[name='start_point']").val(start_point);
		$("input[name='end_point']").val(end_point);
		
		$("select[name='time_type']").find("option[value='"+select_time_type+"']").attr("selected",true);
		$("input[name='start_time']").val(start_time);
		$("input[name='end_time']").val(end_time);		
		
	})	
	
	
})





$(".check_all").live("click",function(){
	if($(this).is(":checked")) {
		$(".array_checkbox").attr("checked",true);
	} else {
		$(".array_checkbox").attr("checked",false);
	}
	
})





//导出会员
$(".checkout_orders").live("click",function(){
	var loadi =layer.load('正在查询', 10000000000000);
		var checkout_type = $("#select_checkout_type").val();

		//赋值
		var select_type = $(".select_type option:selected") .val();
		var input_type = $("input[name='input_type']").val();
		var select_degree = $("select[name='select_degree'] option:selected").val();
			
		var start_point = $("input[name='start_point']").val();
		var end_point = $("input[name='end_point']").val();
			
		var select_time_type = $("select[name='time_type'] option:selected").val();
			
		var start_time = $("input[name='start_time']").val();
		var end_time = $("input[name='end_time']").val();
			
		var uid_arr = [];
		var is_xuznze = false;
		$(".array_checkbox").each(function(){
			
			if($(this).is(":checked")) {
				uid_arr.push($(this).val());
				is_xuznze = true;
			}
			
			
		})
		if(checkout_type == 'check') {
			if(!is_xuznze) {
				layer.alert('尚未勾选要导出的会员哦！', 8); 
				return;
			}
		}
		
			
		$.post(
			member_checkout_url,
			{'show_count':true,'uid_arr':uid_arr,'check_type': checkout_type, 'p': page,'select_type':select_type,'input_type':input_type,'select_degree':select_degree,'start_point':start_point,'end_point':end_point,'select_time_type':select_time_type,'start_time':start_time,'end_time':end_time},
			function(obj) {
				layer.close(loadi);
				if(obj.err_msg>0) {
					layer.confirm('该指定条件下有会员信息  '+obj.err_msg+' 条，确认导出？',function(index){
						layer.close(index);
							var url = member_checkout_url+'&uid_arr='+uid_arr+'&check_type='+checkout_type+'&p='+page+'&select_type='+select_type+'&input_type='+input_type+'&select_degree='+select_degree+'&start_point='+start_point+'&end_point='+end_point+'&select_time_type='+select_time_type+'&start_time='+start_time+'&end_time='+end_time;

						location.href=url;
					});
				} else {
					layer.alert('该搜索条件下没有会员数据，无需导出！', 8); 
				}		
			},
			'json'
		)						
		
})
	

/*
	$.post(
		member_checkout_url,
		{"check_type": checkout_type},
		function(obj) {
			layer.close(loadi);
			if(obj.err_msg>0) {
				layer.confirm('该指定条件下有 订单  '+obj.err_msg+' 条，确认导出？',function(index){
					layer.close(index);
					var url=order_checkout_url+'&check_type='+checkout_type;
					location.href=url;
				});
			} else {
				layer.alert('该搜索条件下没有订单数据，无需导出！', 8); 
			}		
		},
		'json'
	)			
*/		
		
		
		
	


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







	/*
 * 	var keyup_jf = $("#jf_change").val();
		alert(keyup_jf)
	if (re.test(keyup_jf)) {alert("满足")
		keyup_jf = parseInt(keyup_jf)-1;
		$("#keyup_jf").val(keyup_jf);
	} else {
		//不满足
		alert("不满足")
	}
	
 **/

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
			var ids = dom.closest("tr").data("uid");
			
			var htmls = "";
				htmls += '<div class="popover '+position+'" style="left:-'+($(window).width()*5)+'px;top:'+$(window).scrollTop()+($(window).height()/2)+'px;">';
				htmls += '	<div class="arrow"></div>';
				htmls += '	<div style="width:190px;" class="popover-inner">';
				htmls += '		<div class="popover-content">';
				htmls += '			<div class="form-inline">';
				//htmls += '				<div class="input-append"><input type="text" class="txt js-url-placeholder url-placeholder" readonly="" value="'+content+'"/><button type="button" class="btn js-btn-copy">复制</button></div>';
				//alert(show_txm)
				htmls += '				<div class="input-append"><img src='+show_txm+'&uid='+ids+'></div>';
				
				
				
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
			tanchu += '								<input id="jf_change" value="0" type="text" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" id="s2id_autogen26" tabindex="-1" maxlength="5" size="5" style="width:40px;backgroun-image:-webkit-gradient(linear, 0% 0%, 0% 100%, color-stop(1%, #eee), color-stop(15%, #fff));border:1px solid #aaa;">';
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
		
		var re = /^(\+|\-)?[1-9][0-9]*$/;
		var re1 = /(^\+)?[1-9][0-9]*$/;
		var re2 = /(^\-){1}[1-9][0-9]*$/;
		$(".show_point_log").show();
		$("#jf_change").live("keyup",function(){
		var keyup_jf = $(this).val();
		var jf_length = keyup_jf.length;
			

			
			if (re.test(keyup_jf)) {
				
				if(re2.test(keyup_jf)) {
					var show_length = 5;
					if(jf_length > show_length) {
						var keyup_jf = keyup_jf.substr(0,show_length);
						
						$(this).val(keyup_jf);
						$("#jf_change").val(keyup_jf);//alert(jf_length)
					}
					$("#show_point_log").text("减少积分："+ $(this).val())
				} else if(re1.test(keyup_jf)) {
					var show_length = 4;
						if(jf_length > show_length) {
						var keyup_jf = keyup_jf.substr(0,show_length);
						$(this).val(keyup_jf);
						$("#jf_change").val(keyup_jf);
					}			
					$("#show_point_log").text("增加积分："+ $(this).val())
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
		
		/*
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
		*/
		
	}

}