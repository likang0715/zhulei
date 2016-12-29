$(function(){
	$('.taba .slide').css({'left':$('.taba .active').offset().left,'width':$('.taba .active').width()});
	$(window).resize(function(){
		$('.taba .slide').css({'left':$('.taba .active').offset().left,'width':$('.taba .active').width()});
	});
	
	$("input").focus(function(){
		 // $("#tips").hide();
	});
	
	$('#login-form').submit(function(){
		var dom = $(this);
		var phone = $.trim($('#login_phone').val());
		$('#login_phone').val(phone);
		if(phone.length == 0){
			layer.open({
				content: '请输入正确的手机号码',
				btn: ['确定']
			});
			return false;
		}
		if(!/^[0-9]{11}$/.test(phone)){
			layer.open({
				content: '请输入11位数字的手机号码',
				btn: ['确定']
			});
			return false;
		}
		
		var password = $('#login_password').val();
		if(password.length == 0){
			layer.open({
				content: '请输入密码',
				btn: ['确定']
			});
			return false;
		}
		
		var sms_code = '111';
		if(is_open_sms == '1') {
			sms_code = $('#bind-sms').val();
			if(sms_code.length < 4){
				layer.open({
					content: '请输入短信验证码',
					btn: ['确定']
				});
				return false;
			}
		}
		
			$.ajaxSetup({async:false}); 
			$.ajax({
                url: "login.php?action=bind",
                type: "post",
				dataType:"json",
                data: {'phone':phone,'pwd':password,'code':sms_code},
                success: function (results) {
					console.log(results);
					if(results.err_code == 0){
						layer.open({content: '绑定成功，正在跳转！', time:3});
						window.location.href = dom.attr('referer');
					}else{
						if(results.err_code == '1111') {
							layer.open({content: results.err_msg, time:3});
							window.location.href = "./index.php";
						}
						layer.open({
							content: results.err_msg,
							btn: ['确定']
						});
					}
				}
            });
			
			

		
		return false;
	});
	
	$('.taban li').click(function(){
		$(this).addClass('active').siblings('li').removeClass('active');
		$('#'+$(this).attr('tab-target')).show().siblings('form').hide();
		
		$('.taba .slide').css({'left':$('.taba .active').offset().left,'width':$('.taba .active').width()});
	});
	
	$('#reg-form').submit(function(){//alert(33);
		var dom = $(this);
		var phone = $.trim($('#reg_phone').val());
		$('#reg_phone').val(phone);
		if(phone.length == 0){
			layer.open({
				content: '请输入手机号码',
				btn: ['确定']
			});
			return false;
		}
		if(!/^[0-9]{11}$/.test(phone)){
			layer.open({
				content: '请输入正确的手机号码。',
				btn: ['确定']
			});
			return false;
		}

		var readme = $('#readme:checked').val();

		if(readme != 1){
			layer.open({
				content: '请阅读并同意用户注册协议',
				btn: ['确定']
			});
			return false;
		}

		var password_type = $('#reg_password_type').val();
		if(password_type === '0'){
			var password = $('#reg_pwd_password').val();
		}else{
			var password = $('#reg_txt_password').val();
		}
		if(password.length < 6){
			layer.open({
				content: '请输入6位以上的密码。',
				btn: ['确定']
			});
			return false;
		}
		var sms_code = '';
		if(is_open_sms == '1') {
			sms_code = $('#reg-sms').val();
			if(sms_code.length < 4){
				layer.open({
					content: '请输入短信验证码',
					btn: ['确定']
				});
				return false;
			}
		}
		

		$.ajaxSetup({async:false}); 
			$.ajax({
                url: "login.php?action=reg",
                type: "post",
				dataType:"json",
                data: {phone:phone,pwd:password,code:sms_code},success: function (result) {
					if(result.err_code == 0){
						layer.open({content: '注册成功，正在跳转！', time:3});
						window.location.href = dom.attr('action');
					}else{
						if(result.err_code == '1111') {
							layer.open({content: result.err_msg, time:3});
							window.location.href = "./index.php";
						}
						layer.open({
							content: result.err_msg,
							btn: ['确定']
						});
					}
				}
            });		
		return false;
	});
	
	
	$('#reg_changeWord').click(function(){
		if($(this).html() == '显示明文'){
			$('#reg_txt_password').val($('#reg_pwd_password').val()).show();
			$('#reg_pwd_password').hide();
			$(this).html('显示密文');
			$('#reg_password_type').val(1);
		}else{
			$('#reg_pwd_password').val($('#reg_txt_password').val()).show();
			$('#reg_txt_password').hide();
			$(this).html('显示明文');
			$('#reg_password_type').val(0);
		}
	});
});