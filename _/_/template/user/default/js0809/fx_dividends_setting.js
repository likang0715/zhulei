// add by HZ 2016.2.26
$(function(){
  
  location_page(location.hash);

  $('a').live('click',function(){
		if($(this).attr('href') && $(this).attr('href').substr(0,1) == '#'){
			if($(this).attr('href') == '#1' || $(this).attr('href') == '#2' || $(this).attr('href') == '#3'){
					var tmp_status = $(this).attr('href').substr(1,1);
					$('.status-' + tmp_status).addClass('active').siblings('li').removeClass('active');					
					$('#dt_'+tmp_status).trigger("click");
			}else{
				location_page($(this).attr('href'),$(this));
			}
			
		} 
  });


  function location_page(mark) {
		var mark_arr = mark.split('/');

		switch(mark_arr[0]) {
			case '#create':
				if(mark_arr[1] < 3){
					load_page('.app__content', load_url,{page:create_content}, '');
				}else{
					layer.alert('最多只能添加3条规则！');
					location.hash = '#list';
					location_page('');
				}
				break;
			case "#edit":
				if(mark_arr[1]){
					load_page('.app__content', load_url,{page:edit_content,id:mark_arr[1]},'',function(){
					});
				}else{
					layer.alert('非法访问！');
					location.hash = '#list';
					location_page('');
				}
				break;
			case "#sendrules":
					load_page('.app__content', load_url,{page:sendrules_content},'',function(){
					});
				break;

				default:
					load_page('.app__content', load_url, {page:page_content}, '');
		}
	}


   //返回
	$(".js-btn-quit").live("click", function () {
		returnurl();
	})

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


  //分销团队 对应规则3 改变
  $("input[name='dividends_type']").live('click',function(){
	  	if($(this).val() == 2){
	  		var html = '<li><input type="radio" name="rule_type" data-type="" value="3">&nbsp;规则3: &nbsp; <input type="text" id="rule3_month" name="rule3_month" placeholder="数字" style="width:25px;"> 月 新增分销商 <input type="text" id="rule3_seller_1" name="rule3_seller_1" placeholder="数字" style="width:30px;"> 个</li>';	
	  		$('#is_team_dividend').attr('checked',true);
	  		$('.jjgz_team_desc').show();
	  		$('.jjgz_team').show();
	  	}else{
	  		var html = '<li><input type="radio" name="rule_type" data-type="" value="3">&nbsp;规则3: &nbsp; <input type="text" id="rule3_month" name="rule3_month" placeholder="数字" style="width:25px;"> 月 发展下一级分销商 <input type="text" id="rule3_seller_1" name="rule3_seller_1" placeholder="数字" style="width:30px;"> 个  发展下二级分销商 <input type="text" id="rule3_seller_2" name="rule3_seller_2" placeholder="数字" style="width:30px;">个</li>';
	  		$('#is_team_dividend').attr('checked',false);
	  		$('.jjgz_team_desc').hide();
	  		$('.jjgz_team').hide();
	  	}

	  	$('.dbgz').find('li').eq(2).html(html);
  });


  //奖金规则改变

   $("input[name='rule_type']").live('click',function(){
   		var dividends_type = $("input[name='dividends_type']:checked").val();
   		var is_check_str = '';
   		if(dividends_type == 2){
   			is_check_str = 'checked="checked" style="display: none;"';
   		}
	  	if($(this).val() == 3 && dividends_type == 2){
	  		var html = '<input type="checkbox" name="is_team_dividend" id="is_team_dividend" class="js-check-toggle" value="1" '+is_check_str+'  disabled="disabled"  >团队所有者获取总奖金 100<input type="hidden" id="team_owner_percentage" name="team_owner_percentage" placeholder="数字" style="width:25px;" value="100" >% <span class="help-desc">该规则只针对分销团队</span>';
	  	}else{
	  		var html = '<input type="checkbox" name="is_team_dividend" id="is_team_dividend" class="js-check-toggle" value="1" '+is_check_str+' disabled="disabled" >团队所有者获取总奖金 <input type="text" id="team_owner_percentage" name="team_owner_percentage" placeholder="数字" style="width:25px;">% 剩余由团队成员 交易额比例分成 &nbsp;&nbsp;&nbsp;<span class="help-desc">该规则只针对分销团队</span>';
	  	}

	  	$('.jjgz').find('li').eq(2).html(html);
  });


  //添加-保存
	$(".js-btn-add-save").live('click',function(){

			    //验证表单
				
				is_exists_err = false;

				var err_msg = '<span style="font-size:12px;">';
				
				var dividends_type = $("input[name='dividends_type']:checked").val();
				var arr_dividends_type = ['1', '2', '3'];
				if(jQuery.inArray(dividends_type, arr_dividends_type) == '-1') {
					is_exists_err = true;
					err_msg += '请选择依据对象！<br />';
				} 

				var rule_type = $("input[name='rule_type']:checked").val();

				var arr_rule_type = ['1', '2', '3'];
				if(jQuery.inArray(rule_type, arr_rule_type) == '-1') {
					is_exists_err = true;
					err_msg += '请选择达标规则！<br />';	
				} 

				var is_bind = 0;

				if(rule_type == 1){
					
					var rule1_month = $('#rule1_month').val();

					if(rule1_month) {
						if(!(/^(\+|-)?\d+$/.test( rule1_month )) || rule1_month <= 0 ) {
							is_exists_err = true;
							err_msg += '规则1:月份必须是大于0的整数！<br />';
						}			
					} else{
						is_exists_err = true;
						err_msg += '规则1:请填写月份！<br />';
					}

					var rule1_money = $('#rule1_money').val();

					if (isNaN(rule1_money) || rule1_money == '' || rule1_money == undefined || parseFloat(rule1_money) <= 0) {
						is_exists_err = true;
						err_msg += '规则1:金额必须是大于0的数字<br />';	
					}			
					
					var rule1_is_bind = $('#rule1_is_bind').is(':checked');
					
					if(rule1_is_bind == true){
						is_bind = 1;
					}
				}

				if(rule_type == 2){
					
					var rule2_money = $('#rule2_money').val();

					if (isNaN(rule2_money) || rule2_money == '' || rule2_money == undefined || parseFloat(rule2_money) <= 0) {
						is_exists_err = true;
						err_msg += '规则2:金额必须是大于0的数字<br />';
					}

					var rule2_month = $('#rule2_month').val();

					if(rule2_month) {
						if(!(/^(\+|-)?\d+$/.test( rule2_month )) || rule2_month <= 0 ) {
							is_exists_err = true;
							err_msg += '规则2:月份必须是大于0的整数<br />';
						}		
					} else{
						is_exists_err = true;
						err_msg += '规则2:请填写月份<br />';
					}



					var rule2_is_bind = $('#rule2_is_bind').is(':checked');
					if(rule2_is_bind == true){
						is_bind = 1;
					}
				}



				if(rule_type ==3 || is_bind == 1){

					if(dividends_type == 1){
						is_exists_err = true;
						err_msg += '经销商无需关联规则3<br />';	
					}else{
						var rule3_month = $('#rule3_month').val();

						if(rule3_month) {
							if(!(/^(\+|-)?\d+$/.test( rule3_month )) || rule3_month <= 0 ) {
								is_exists_err = true;
								err_msg += '规则3:月份必须是大于0的整数<br />';
							}			
						} else{
							is_exists_err = true;
							err_msg += '规则3:请填写月份<br />';
						}

						var rule3_seller_1 = $('#rule3_seller_1').val();

						if(rule3_seller_1) {
							if(!(/^(\+|-)?\d+$/.test( rule3_seller_1 )) || rule3_seller_1 <= 0 ) {
								is_exists_err = true;
								err_msg += '规则3:人数是必须大于0的整数<br />';
							}		
						} else{
							is_exists_err = true;
							err_msg += '规则3:必须填写人数<br />';
						}


						if(dividends_type != 2){
							var rule3_seller_2 = $('#rule3_seller_2').val();

							if(rule3_seller_2) {
								if(!(/^(\+|-)?\d+$/.test( rule3_seller_2 )) || rule3_seller_2 <= 0 ) {
									is_exists_err = true;
									err_msg += '规则3:人数是必须大于0的整数<br />';
								}		
							} else{
								is_exists_err = true;
								err_msg += '规则3:必须填写人数<br />';
							}
						}
						
						
					
					}

				}

				var percentage_or_fix = $("input[name='percentage_or_fix']:checked").val();
				var percentage_or_fix_type = ['1', '2'];
				if(jQuery.inArray(percentage_or_fix, percentage_or_fix_type) == '-1') {
					is_exists_err = true;
					err_msg += '请选择奖金规则！<br />';	
				} 



				
				if(percentage_or_fix == 1){
					
					if(rule_type == 3){
						is_exists_err = true;
						err_msg += '只选规则3则奖金规则必须绑定固定值<br />';
					}else{
						var percentage = $('#percentage').val();

						if(percentage) {
							if(!(/^(\+|-)?\d+$/.test( percentage )) || percentage <= 0 || percentage > 100 ) {
								is_exists_err = true;
								err_msg += '比例必须在0-100之间<br />';
							}		
						} else{
							is_exists_err = true;
							err_msg += '必须填写比例<br />';
						}
					}

				}




				if(percentage_or_fix == 2){
					
					var fixed_amount = $('#fixed_amount').val();
					
					if (isNaN(fixed_amount) || fixed_amount == '' || fixed_amount == undefined || parseFloat(fixed_amount) <= 0) {
						is_exists_err = true;
						err_msg += '金额必须是大于0的数字<br />';
					}

				}

				
				var is_limit = $('#is_limit').is(':checked');

				if(is_limit == true){
					var upper_limit = $('#upper_limit').val();
					if (isNaN(upper_limit) || upper_limit == '' || upper_limit == undefined || parseFloat(upper_limit) < 0) {
						is_exists_err = true;
						err_msg += '金额必须是整数<br />';
					}
				}

				
				var is_team_dividend = $('#is_team_dividend').is(':checked');
				if(is_team_dividend == true){
					if(dividends_type != 2){
						is_exists_err = true;
						err_msg += '经销商和独立分销商没有这条规则(团队所有者获取总奖金比)<br />';
					}else{
						var team_owner_percentage = $('#team_owner_percentage').val();
						if(team_owner_percentage) {
							if(!(/^(\+|-)?\d+$/.test( team_owner_percentage )) || team_owner_percentage < 0  || team_owner_percentage > 100 ) {
								is_exists_err = true;
								err_msg += '比例必须在0-100之间<br />';
							}		
						} else{
							is_exists_err = true;
							err_msg += '必须填写比例<br />';
						}
					}			
				}
				 err_msg += '</span>';			
				 if(is_exists_err) {
				 	layer.alert(err_msg);
				 	return false;
				 }
				

				$.post(load_url, {
						"page" : create_content,
						"dividends_type" :dividends_type,
						"rule_type":rule_type,
						"rule1_month":rule1_month,
						"rule1_money":rule1_money,
						"rule1_is_bind":rule1_is_bind,
						"rule2_money":rule2_money,
						"rule2_month":rule2_month,
						"rule2_is_bind":rule2_is_bind,
						"rule3_month":rule3_month,
						"rule3_seller_1":rule3_seller_1,
						"rule3_seller_2":rule3_seller_2,
						"percentage_or_fix":percentage_or_fix,
						"percentage":percentage,
						"fixed_amount":fixed_amount,
						"is_limit":is_limit,
						"upper_limit":upper_limit,
						"is_team_dividend":is_team_dividend,
						"team_owner_percentage":team_owner_percentage,
						 "is_submit" : "submit"
					}, function (data) {
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



  //修改-保存
	$(".js-btn-edit-save").live('click',function(){

			    //验证表单
				
				is_exists_err = false;

				var err_msg = '';
				
				var dividends_type = $("input[name='dividends_type']:checked").val();
				var arr_dividends_type = ['1', '2', '3'];
				if(jQuery.inArray(dividends_type, arr_dividends_type) == '-1') {
					is_exists_err = true;
					err_msg += '请选择依据对象！<br />';
				} 

				var rule_type = $("input[name='rule_type']:checked").val();

				var arr_rule_type = ['1', '2', '3'];
				if(jQuery.inArray(rule_type, arr_rule_type) == '-1') {
					is_exists_err = true;
					err_msg += '请选择达标规则！<br />';	
				} 

				var is_bind = 0;

				if(rule_type == 1){
					
					var rule1_month = $('#rule1_month').val();

					if(rule1_month) {
						if(!(/^(\+|-)?\d+$/.test( rule1_month )) || rule1_month <= 0 ) {
							is_exists_err = true;
							err_msg += '规则1:月份必须是大于0的整数！<br />';
						}			
					} else{
						is_exists_err = true;
						err_msg += '规则1:请填写月份！<br />';
					}

					var rule1_money = $('#rule1_money').val();

					if (isNaN(rule1_money) || rule1_money == '' || rule1_money == undefined || parseFloat(rule1_money) <= 0) {
						is_exists_err = true;
						err_msg += '规则1:金额必须是大于0的数字<br />';	
					}			
					
					var rule1_is_bind = $('#rule1_is_bind').is(':checked');
					
					if(rule1_is_bind == true){
						is_bind = 1;
					}
				}

				if(rule_type == 2){
					
					var rule2_money = $('#rule2_money').val();

					if (isNaN(rule2_money) || rule2_money == '' || rule2_money == undefined || parseFloat(rule2_money) <= 0) {
						is_exists_err = true;
						err_msg += '规则2:金额必须是大于0的数字<br />';
					}

					var rule2_month = $('#rule2_month').val();

					if(rule2_month) {
						if(!(/^(\+|-)?\d+$/.test( rule2_month )) || rule2_month <= 0 ) {
							is_exists_err = true;
							err_msg += '规则2:月份必须是大于0的整数<br />';
						}		
					} else{
						is_exists_err = true;
						err_msg += '规则2:请填写月份<br />';
					}



					var rule2_is_bind = $('#rule2_is_bind').is(':checked');
					if(rule2_is_bind == true){
						is_bind = 1;
					}
				}



				if(rule_type ==3 || is_bind == 1){

					if(dividends_type == 1){
						is_exists_err = true;
						err_msg += '经销商无需关联规则3<br />';	
					}else{
						var rule3_month = $('#rule3_month').val();

						if(rule3_month) {
							if(!(/^(\+|-)?\d+$/.test( rule3_month )) || rule3_month <= 0 ) {
								is_exists_err = true;
								err_msg += '规则3:月份必须是大于0的整数<br />';
							}			
						} else{
							is_exists_err = true;
							err_msg += '规则3:请填写月份<br />';
						}

						var rule3_seller_1 = $('#rule3_seller_1').val();

						if(rule3_seller_1) {
							if(!(/^(\+|-)?\d+$/.test( rule3_seller_1 )) || rule3_seller_1 <= 0 ) {
								is_exists_err = true;
								err_msg += '规则3:人数是必须大于0的整数<br />';
							}		
						} else{
							is_exists_err = true;
							err_msg += '规则3:必须填写人数<br />';
						}


						if(dividends_type != 2){
							var rule3_seller_2 = $('#rule3_seller_2').val();

							if(rule3_seller_2) {
								if(!(/^(\+|-)?\d+$/.test( rule3_seller_2 )) || rule3_seller_2 <= 0 ) {
									is_exists_err = true;
									err_msg += '规则3:人数是必须大于0的整数<br />';
								}		
							} else{
								is_exists_err = true;
								err_msg += '规则3:必须填写人数<br />';
							}
						}
						

					}

				}

				var percentage_or_fix = $("input[name='percentage_or_fix']:checked").val();
				var percentage_or_fix_type = ['1', '2'];
				if(jQuery.inArray(percentage_or_fix, percentage_or_fix_type) == '-1') {
					is_exists_err = true;
					err_msg += '请选择奖金规则！<br />';	
				} 



				if(percentage_or_fix == 1){

					if(rule_type == 3){
						is_exists_err = true;
						err_msg += '只选规则3则奖金规则必须绑定固定值<br />';
					}else{
						var percentage = $('#percentage').val();

						if(percentage) {
							if(!(/^(\+|-)?\d+$/.test( percentage )) || percentage <= 0 || percentage > 100 ) {
								is_exists_err = true;
								err_msg += '比例必须在0-100之间<br />';
							}		
						} else{
							is_exists_err = true;
							err_msg += '必须填写比例<br />';
						}
					}

				}


				if(percentage_or_fix == 2){
					
					var fixed_amount = $('#fixed_amount').val();
					
					if (isNaN(fixed_amount) || fixed_amount == '' || fixed_amount == undefined || parseFloat(fixed_amount) <= 0) {
						is_exists_err = true;
						err_msg += '金额必须是大于0的数字<br />';
					}

				}

				
				
				var is_limit = $('#is_limit').is(':checked');

				if(is_limit == true){
					var upper_limit = $('#upper_limit').val();
					if (isNaN(upper_limit) || upper_limit == '' || upper_limit == undefined || parseFloat(upper_limit) < 0) {
						is_exists_err = true;
						err_msg += '金额必须是整数<br />';
					}
				}

				
				var is_team_dividend = $('#is_team_dividend').is(':checked');
				if(is_team_dividend == true){
					if(dividends_type != 2){
						is_exists_err = true;
						err_msg += '<span style="font-size:12px;">经销商和独立分销商没有这条规则(团队所有者获取总奖金比)</span><br />';
					}else{
						var team_owner_percentage = $('#team_owner_percentage').val();
						if(team_owner_percentage) {
							if(!(/^(\+|-)?\d+$/.test( team_owner_percentage )) || team_owner_percentage < 0  || team_owner_percentage > 100 ) {
								is_exists_err = true;
								err_msg += '比例必须在0-100之间<br />';
							}		
						} else{
							is_exists_err = true;
							err_msg += '必须填写比例<br />';
						}
					}
					
				}
				
				 			
				 if(is_exists_err) {
				 	layer.alert(err_msg);
				 	return false;
				 }
				
				var id = $("#rules_id").val();

				$.post(load_url, {
						"id":id,
						"page" : edit_content,
						"dividends_type" :dividends_type,
						"rule_type":rule_type,
						"rule1_month":rule1_month,
						"rule1_money":rule1_money,
						"rule1_is_bind":rule1_is_bind,
						"rule2_money":rule2_money,
						"rule2_month":rule2_month,
						"rule2_is_bind":rule2_is_bind,
						"rule3_month":rule3_month,
						"rule3_seller_1":rule3_seller_1,
						"rule3_seller_2":rule3_seller_2,
						"percentage_or_fix":percentage_or_fix,
						"percentage":percentage,
						"fixed_amount":fixed_amount,
						"is_limit":is_limit,
						"upper_limit":upper_limit,
						"is_team_dividend":is_team_dividend,
						"team_owner_percentage":team_owner_percentage,
						 "is_submit" : "submit"
					}, function (data) {
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

	$('.js-add-message').live('click',function(){
		$('.js-message-container').append('<div class="message-item">每月 <input type="text" name="rules3_day" value="" class="input-mini message-input rules3_day" maxlength="2"> 号 发放 <input type="text" name="rules3_percent" value="" class="input-mini message-input rules3_percent" maxlength="3"> %<a href="javascript:;" class="js-remove-message remove-message">删除</a></div>');
	});
	
	$('.js-remove-message').live('click',function(){
		$(this).closest('.message-item').remove();
	});	

	$('.js-btn-rulesedit-save').live('click',function(){
		
		var err_msg = '';

		var send_rules_type = $("input[name='send_rules_type']:checked").val();

		var send_rules_type_arr = ['1', '2'];

		if(jQuery.inArray(send_rules_type, send_rules_type_arr) == '-1') {
			layer_tips(1,'请选择发放规则！');
			return false;
		} 

		/*
		if(send_rules_type == 2){

			var rules2_value = $('#rules2_value').val();

			if(rules2_value) {
				if(!(/^(\+|-)?\d+$/.test( rules2_value )) || rules2_value <= 0 ) {
					layer_tips(1,'规则2:日期必须是大于0的整数');
					return false;
				}			
			} else{
				layer_tips(1,'规则2:请填写日期');
				return false;
			}
		}
		

		if(send_rules_type == 3){

			//批次判断
	        var fields = [];
	        var flag = true;

	        if ($('.js-message-container > .message-item').length > 0) {
	            $('.js-message-container > .message-item').each(function(i){
	                

	            	var rules3_percent = $(this).children('.rules3_percent').val();
	               

	                if(rules3_percent) {
						if(!(/^(\+|-)?\d+$/.test( rules3_percent )) || rules3_percent < 0  || rules3_percent > 100 ) {
							layer_tips(1,'比例必须在0-100之间');
		                    $(this).children('.rules3_percent').focus();
		                    flag = false;
						}		
					} else{
						layer_tips(1,'比例不能为空');
	                    $(this).children('.rules3_percent').focus();
	                    flag = false;
					}

	                var rules3_day = $(this).children('.rules3_day').val();
	                
	                if(rules3_day) {
						if(!(/^(\+|-)?\d+$/.test( rules3_day )) || rules3_day <= 0 || rules3_day > 31 ) {
							layer_tips(1,'规则3:日期必须在0-31之间');
		                    $(this).children('.rules3_day').focus();
		                    flag = false;
						}			
					} else{
						layer_tips(1,'规则3:发放日期不能为空');
	                    $(this).children('.rules3_day').focus();
	                    flag = false;
					}

	              

	                fields[i] = {'rules3_day': rules3_day,'rules3_percent':rules3_percent};
	            })
	        }else{
	        	layer_tips(1,'至少添加一项批次规则');
	        	flag = false;
	        }
	        if (!flag) {
	            return false;
	        }

		}
		*/

		$.post(load_url, {
						"page" : sendrules_content,
						"send_rules_type" :send_rules_type,
						//"rules2_value":rules2_value,
						//"fields":fields,
						"is_submit" : "submit"
					}, function (data) {
					if (data.err_code == '0') {
						layer_tips(0, data.err_msg);
						var t = setTimeout(location.href= page_list_url+'#sendrules', 3000);
						return;
					} else {
						layer_tips(1, data.err_msg);
						return;
					}
				});

	});

});


function returnurl() {		
		location.href= page_list_url;
}
