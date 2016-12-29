<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>找回密码 - <?php echo $config['site_name'];?></title>
		<meta name="Keywords" content="<?php echo $config['seo_keywords'];?>">
		<meta name="description" content="<?php echo $config['seo_description'];?>">
		<link href="<?php echo TPL_URL;?>css/forget.css" type="text/css" rel="stylesheet">
			
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>  
	 	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.form.min.js"></script> 
	 	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script> 
	 	<script type="text/javascript" src="<?php echo TPL_URL;?>js/common.js" type="text/css" rel="stylesheet"></script>
	</head>
	<body id="index1000" class="index1000">
		<!-- user head start -->
		<div class="head_bg">
			<div class="header">
				<div class="logo clearfix">
					<div class="logocon">
						<a href="<?php echo $config['site_url'];?>"><img src="<?php echo $config['site_logo'];?>" width="235" height="70"></a>
					</div>
					<p class="head_tip">
						找回密码
					</p>
					<noscript>
						<h1 class="head_notice_tips">您的浏览器禁用了javascript脚本，导致登录功能无法使用，请您先开启以后再使用找回密码功能。</h1>
					</noscript>
					<p class="head_notice_tips" style="display: none;">
						您的浏览器禁用了cookie，开启Cookie之后才能找回密码，
						<a href="javascript:void(0)" id="howEnableCookie" style="color:rgb(3, 189, 252);">
							如何开启?
						</a>
					</p>
				</div>
			</div>
		</div>
		<!-- user head end -->
		<!-- user center_reg start -->
		<div class="allWrap">
			<div class="main_top clearfix">
				<div class="main_top_l">
				</div>
				<div class="main_top_r">已有账号了？<a rel="nofollow" target="_self" href="<?php echo url("account:login");?>">登录</a></div>
			</div>
			<div id="user-reg" class="user-reg">
	<div id="bg_div" class="bg_div" style="display:none;">
	</div>
	<div id="reg-field">
		<div class="a_title title_oneStep clearfix">
			<a class="page_phone page_cur" href="javascript:void(0);" style="width:100%">
				<span>密码找回</span>
				<span class="poptip-arrow poptip-arrow-top">▼</span>
			</a>
		</div>
		<div class="veri_step">
			<div class="veri_step_pic veri_step_pic1">
			</div>
			<ul class="clearfix">
				<li class="light">验证身份</li>
				<li>重置密码</li>
				<li>完成</li>
			</ul>
		</div>
		<div id="reg-wrap" class="reg-wrap">
			<div id="mainPart" class="mainPart clearfix">
				<form method="post" id="forgetForm" autocomplete="off" onsubmit="return false;" action="<?php echo url("forget:password_find",array('step'=>'two'));?>">
					<div class="main_item">
						<ul class="mainCon">
							<li>
								<div class="input">
									<label>账户名：</label>
									<input tabindex="1" name="username" autocomplete="off" style="ime-mode:disabled" class="txt-m" placeholder="请输入手机号码或者邮箱" maxlength="32" type="text">
								</div>
								<div class="input-tip" id="tel-tip">
									<div class="input-tip-inner">
										<span>
										</span>
									</div>
								</div>
							</li>
							<!-- 验证码 -->
							<li class="identify_box">
								<div class="input">
									<label>验证码：</label>
									<input class="txt-m" id="identify" name="identify" placeholder="不区分大小写" maxlength="4" tabindex="2" type="text">
									<span style=" display: inline-block;">
										<img style="cursor: pointer;margin: -2px 0 0 -59px;vertical-align: middle;*margin-top: -15px" alt="如验证码无法辨别，点击即可刷新。" id="identify_img" src="<?php echo url("forget:verify") ;?>" onclick='document.getElementById("identify_img").src = "<?php echo TPL_URL;?>images/ico/load_small.gif";document.getElementById("identify_img").src = "<?php echo url('forget:verify')?>&time=" + (new Date().getTime() + Math.random());' >
									</span>
								</div>
								<div class="input-tip wd350" id="codeTip1">
									<div class="input-tip-inner">
										<span id="code_err" class="hide">
										</span>
										<span style="margin-top:10px;">
											看不清，<a class="green" href="javascript:void(0);" onclick='document.getElementById("identify_img").src = "<?php echo TPL_URL;?>images/ico/load_small.gif";document.getElementById("identify_img").src = "<?php echo url('forget:verify')?>&time=" + (new Date().getTime() + Math.random());'>换一张</a>
										</span>
									</div>
								</div>
							</li>
						</ul>
						<div class="reg-check">
							<input value="下一步" tabindex="9" class="login_btn register_btn" name="info_submit" id="info_submit" type="submit">
						</div>
					</div>
				</form>
				<!--手机注册第一步结束-->
				<input name="errorMsg" value="" type="hidden">
				<input name="errorType" value="" type="hidden">
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(function() {
	var checkDelay, oldValue;
	//填写默认的用户名
	var cookieArr = document.cookie.split(";");
	var defaultUsername = "";
	var oldUsername = "";
	var checkTimeout;
	var errType = $("[name='errorType']").val();
	var errorMsg = $("[name='errorMsg']").val();
	var identifyFlag = false,
		usernameFlag = false;
	for (var i = 0; i < cookieArr.length; i++) {
		if (cookieArr[i].match("login_user_name")) {
			defaultUsername = cookieArr[i].split("=")[1];
		}
	}
	if (errorMsg) {
		if (errType == 1) {
			$("#tel-tip").addClass("err");
			$("#tel-tip").show().html(errorMsg);
		} else {
			$("#codeTip1").addClass("err");
			$("#code_err").show().html("请输入正确的验证码&#12288;&#12288;");
		}
	}
	$("[name='username']").focus(function() {
		$("#tel-tip").removeClass("err");
		$("#tel-tip").hide().html("");
	}).blur(function() {
		if (defaultUsername == this.value && errorMsg && errType == 1) {
			$("#tel-tip").addClass("err");
			$("#tel-tip").show().html(errorMsg);
		}
		$(this).trigger("input", 'blur');
	}).on("input",
		function(e, blur) {
			var value = this.value;
			if (blur != 'blur' && oldUsername && value == oldUsername) {
				return;
			}
			oldUsername = value;
			var self = this;
			if (checkTimeout) {
				clearTimeout(checkTimeout);
			}
			checkTimeout = setTimeout(function() {
				if (value && new RegExp(/(?=^.{5,255}$)(^([\w\!\#\$\%\&\'\*\+\-\.\/\?\^\_\`\{\|\}\~]+)@([a-zA-Z0-9\-]+\.)+([a-zA-Z0-9\-]+)$)/).test(value)) {
					usernameFlag = false;
					var url = "/register/isEmailAvailable";
					$("#tel-tip").addClass("err");
					$("#tel-tip").show().html("检查中...");
					$.ajax({
						url: url,
						data: {
							email: value
						},
						type: 'post',
						success: function(json) {
							if( json.status == "-20"){
								$("#tel-tip").addClass("err");
								$("#tel-tip").show().html("服务器遛弯鸟，请稍后再试");
								usernameFlag = false;
							} else if (!json.success) {
								$("#tel-tip").removeClass("err");
								$("#tel-tip").hide().html("");
								usernameFlag = true;
							} else {
								$("#tel-tip").addClass("err");
								$("#tel-tip").show().html("该用户未注册，不能找回密码。您可以<a class='green' href='<?php echo url("account:register")?>'>立即注册</a>");
								usernameFlag = false;
							}
						}
					});
				} else if (value && value.length == 11 && new RegExp("^((13[0-9])|(15[0-9])|(18[0-9])|14[0-9]|17[0-9])[0-9]{8,8}$").test(value)) {
					var url = "<?php echo url('forget:checkaccount');?>";
					$("#tel-tip").show().html("检查中...");
					$("#tel-tip").addClass("err");
					$.ajax({
						url: url,
						data: {
							mobile:value
						},
						dataType:'json',
						type: 'post',
						success: function(json) { 

							if(parseInt(json.status) > 0) {
								$("#tel-tip").addClass("err");
								$("#tel-tip").show().html(json.msg);
								return false;
							}

							
							if( json.errno == "-20"){
								$("#tel-tip").addClass("err");
								$("#tel-tip").show().html("服务器遛弯鸟，请稍后再试");
								usernameFlag = false;
							} else if (!json.success) {
								$("#tel-tip").removeClass("err");
								$("#tel-tip").hide().html("");
								usernameFlag = true;
							} else{
								$("#tel-tip").addClass("err");
								$("#tel-tip").show().html("该用户未注册，不能找回密码。您可以<a class='green' href='<?php echo url("account:register")?>'>立即注册</a>");
								usernameFlag = false;
							}
						}
					});
				} else {
					usernameFlag = false;
					$("#tel-tip").addClass("err");
					$("#tel-tip").show().html("用户名不正确，请输入手机号码或者邮件");
				}
			}, 300);
		});
	if (defaultUsername) {
		$("[name='username']").val(decodeURIComponent(defaultUsername)).trigger("input");
	}
	$("#identify").blur(function(){
        $(this).trigger("input", 'blur');
	}).on("input",
		function(e, blur) {
			if (blur != 'blur' && oldValue && this.value == oldValue) {
				return;
			}
			identifyFlag = false;
			oldValue = this.value;
			var self = this;
			if (self.value && self.value.length == 4 && new RegExp("^([0-9a-zA-Z])+$").test(self.value)) {
				clearTimeout(checkDelay);
				checkDelay = setTimeout(function() {
					$.ajax({
						url: "<?php echo url('forget:checkCaptcha');?>",
						data: {
							verify:self.value
						},
						dataType:'json',
						type: "GET",
						success: function(json) {
							
							if (json.status!='0') {
								//$(ele).focus();
								$("#codeTip1").addClass("err");
								$("#code_err").show().html("请输入正确的验证码&#12288;&#12288;");
							} else {
								identifyFlag = true;
								$("#codeTip1").removeClass("err");
								$("#code_err").hide().html("");
							}
						}
					});
				}, 300);
			} else {
				$("#codeTip1").addClass("err");
				$("#code_err").show().html("请输入正确的验证码&#12288;&#12288;");
			}
		}).focus(function() {
		$("#codeTip1").removeClass("err");
		$("#code_err").hide().html("");
	});
	$("#info_submit").click(function() {
		if (!identifyFlag || !usernameFlag) {
			$("#identify").trigger("input");
			$("[name='username']").trigger("input");
			return;
		}
		$("#forgetForm")[0].submit();
	});
});</script>
		</div>
	
	<script type="text/javascript">
	if (!window.navigator.cookieEnabled) {
	$("#howEnableCookie").parent().show();
	$("#howEnableCookie").click(function() {
		$.layer({
			type: 1,
			title: "如何启动COOKIE",
			time: 0,
			shadeClose: true,
			maxHeight: 200,
			page: {
				html: "<div style='padding:10px'><p style='font-size: 18px;font: 20px/47px 'microsoft yahei';'>1. ie浏览器：点击浏览器<b>“工具”</b>——<b>“internet选项”</b>——<b>“隐私”</b>——将<b>“阻止所有cookie”</b>调低级别——点击<b>“保存”</b>——重启浏览器即可正常登录。<br><br>2. chrome浏览器：点击浏览器<b>“设置”</b>——<b>“显示高级设置”</b>——<b>“隐私设置”</b>——<b>“内容设置”</b>——取消<b>“阻止第三方cookie和网站数据”</b>——选择<b>“允许设置本地数据（推荐）”</b>——点击<b>“完成”</b>——重启浏览器即可正常登录。<br><br>3. 火狐浏览器：点击浏览器<b>“选项”</b>——选择<b>“隐私”</b>——<b>“自定义历史记录设置”</b>，取消<b>“始终使用隐私浏览模式”</b>，勾选<b>“接受来自站点的cookie”</b>——点击<b>“确定”</b>——重启浏览器即可生效。</p></div>"
			},
			offset: ["200px", ""],
			area: ["700px", "320px"]
		})
	})
};</script>
</body></html>