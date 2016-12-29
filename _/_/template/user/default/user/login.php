<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>登录/注册-<?php echo $config['site_name'];?></title>
	<meta name="Keywords" content="<?php echo $config['seo_keywords'];?>">
	<meta name="description" content="<?php echo $config['seo_description'];?>">
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>  
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/common.js" type="text/css" rel="stylesheet"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
	<link href="<?php echo TPL_URL;?>css/style.css" type="text/css" rel="stylesheet">
	<link href="<?php echo TPL_URL;?>css/new_login.css" type="text/css" rel="stylesheet">	
</head>	
<body class="new_login">
	<div class="login-box">
		<div class="login-logo">
			<img src="images/login-logo.png">
		</div>
		<div class="login-main-box">
			<div class="login-main-title">
				<h3>商家管理系统</h3>
			</div>
			<div class="login-main-form">
				<form id="login" action="<?php echo url('user:login') ?>" method="post" onsubmit="return checkLogin()">
					<div class="login-main-group login-username">
						<input name="phone" id="phone" autocomplete="off" class="login-username-input" placeholder="请输入手机号" type="text">
					</div>
					<div class="login-main-group login-pwd">
						<input name="password" autocomplete="off" class="login-pwd-input" id="password" type="password" placeholder="请输入密码" >
					</div>
					<div class="login-main-group login-verify">
						<div class="login-group-left">
							<input name="verify" autocomplete="off" class="login-verify-input" id="verify" type="text" placeholder="请输入验证码" >
						</div>
						<div class="login-group-right">
							<a href="javascript:void(0);" class="b">
								<span><img style="cursor: pointer;width:85px;height:34px;margin-top:-4px;vertical-align: middle;*margin-top: -15px" alt="如验证码无法辨别，点击即可刷新。" id="identify_img" src="<?php echo url("user:verify") ;?>" onclick='document.getElementById("identify_img").src = "<?php echo TPL_URL;?>images/ico/load_small.gif";document.getElementById("identify_img").src = "<?php echo url('user:verify')?>&time=" + (new Date().getTime() + Math.random());' ></span>
							</a>
						</div>
					</div>
					<div class="login-main-group login-submit">
						<input value="登录" name="submit_login" id="J_Login" class="login-submiti-input" type="submit">
					</div>
					<div class="login-main-group login-join">
						<a href="user.php?c=user&a=com_register" style="margin-left: 82px;float:left">申请入驻</a>
						<a href="user.php?c=user&a=com_register" style="margin-right: 82px;float:right">找回密码</a>
					</div>
				<input name="login_type" value="P-M" type="hidden">
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript">

	function showRequest() {

		var phone = $("#phone").val();
		var password = $("#password").val();

		if (phone.length == 0 && password.length == 0) {
			tusi("请填写手机号和密码");
			return false;
		}

		if (!checkMobile(phone)) {
			tusi("请正确填写您的手机号");
			return false;
		}

		if (password.length < 6) {
			tusi("密码不能少于六位，请正确填写");
			return false;
		}
		return true;
	}

	function checkLogin() {
		var res = showRequest();
		if(res==false){
			return false;
		}
		var login_type = $('#login_type').val();
		var phone = $('#phone').val();
		var password = $('#password').val();
		var referer = $('#h_referer').val();
		var action = $('#login').attr('action');
		$.post(action,{'login_type':login_type,'phone':phone,'password':password,'referer':referer},function(response){
			if(response.status==false){
				if(response.msg==undefined){
					tusi("页面错误，请重新登录");
				}else{
					tusi(response.msg);
				}
				return false;
			}
			if(response.ucsynlogin!=undefined){
				document.write(response.ucsynlogin);
			}else{
				showResponse(response);
			}

		},'json');


		/*try {
			$('#login').ajaxSubmit({
				beforeSubmit: showRequest,
				success: showResponse,
				dataType: 'json'
			});
		} catch(e) {
			.login-table td("页面错误，请重新登录");
			location.reload();
		}*/
		
		return false;
	}
	</script>
</body>
</html>