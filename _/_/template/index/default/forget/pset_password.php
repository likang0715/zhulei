<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>找回密码 - <?php echo $config['site_name'];?></title>
		<meta name="Keywords" content="<?php echo $config['seo_keywords'];?>">
		<meta name="description" content="<?php echo $config['seo_description'];?>">
			
		<meta http-equiv="Cache-Control" content="no-cache,no-store, must-revalidate">
		<meta http-equiv="pragma" content="no-cache"> 
		<meta http-equiv="expires" content="0">
		
 		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>  
 		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.form.min.js"></script> 
 		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script> 
 		<script type="text/javascript" src="<?php echo TPL_URL;?>js/common.js" type="text/css" rel="stylesheet"></script>
 		<link href="<?php echo TPL_URL;?>css/forget.css" type="text/css" rel="stylesheet">
 		
	</head>
	<body id="index1000" class="index1000">
		<!-- user head start -->
		<div class="head_bg">
			<div class="header">
				<div class="logo clearfix">
					<div class="logocon">
						<a href="<?php echo $config['site_url'];?>">
								<img src="<?php echo $config['site_logo'];?>" width="235" height="70">
						</a>
					</div>
					<p class="head_tip">
						找回密码
					</p>
					<noscript>
						<h1 class="head_notice_tips">
							您的浏览器禁用了javascript脚本，导致登录功能无法使用，请您先开启以后再使用找回密码功能。
						</h1>
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
				<div class="main_top_r">
					已有账号了？<a rel="nofollow" target="_self" href="<?php echo url("account:login");?>">登录</a>
				</div>
			</div>
			<div id="user-reg" class="user-reg">
	<div id="reg-field">
		<div class="a_title title_oneStep clearfix">
			<a class="page_phone page_cur" href="javascript:void(0);" style="width:100%">
				<span>密码找回</span>
				<span class="poptip-arrow poptip-arrow-top">▼</span>
			</a>
		</div>
		<div class="veri_step">
			<div class="veri_step_pic veri_step_pic2">
			</div>
			<ul class="clearfix">
				<li>
					验证身份
				</li>
				<li class="light">
					重置密码
				</li>
				<li>
					完成
				</li>
			</ul>
		</div>
		<div id="reg-wrap" class="reg-wrap">
		    <input id="username" value="13856905308" type="hidden">
			<form method="post" id="registerFrm" autocomplete="off" onsubmit="return false;">
				<div id="mainPart" class="mainPart clearfix">
					<!--邮箱注册第二步开始-->
					<div class="main_item">
						<ul class="input-list mainCon">
							<li class="password_li">
								<div class="input">
									<label for="password">登录密码：</label>
									<input id="password" tabindex="5" name="password" autocomplete="off" style="ime-mode:disabled;" class="txt-m" maxlength="20" type="password">
								</div>
								<div class="input-tip" id="password-tip">
									<div class="input-tip-inner">
										<span class="mes_pass">
										</span>
									</div>
								</div>
								<div id="password-state" class="password-state">
									<div class="input-tip-inner">
										<span class="mes_pass">
										</span>
									</div>
								</div>
							</li>
							<li>
								<div class="input">
									<label for="password-confirm">确认密码：</label>
									<input tabindex="6" name="passwordagain" id="passwordagain" style="ime-mode:disabled;" class="txt-m" value="" maxlength="20" type="password">
								</div>
								<div class="input-tip " id="passwordagain-tip">
									<div class="input-tip-inner">
										<span class="mes_passagain">
										</span>
									</div>
								</div>
							</li>
						</ul>
						<div class="reg-check">
							<input value="下一步" id="submit" class="login_btn submit_btn" type="button">
						</div>
					</div>
					<input id="pwd_s" value="" name="pwd_s" type="hidden">
					
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">$(function() {
    function showDialog(msg) {
        $.layer({
            title: 0,
            closeBtn: 0,
            time: 3,
            shadeClose: true,
            dialog: {
                type: 1,
                msg: msg
            },
            offset: ['90px', '']
        });
    }
	$("#submit").click(function() {
		if ($(this).attr("disabled")) {
			return;
		}
		var password = $("#password").val(),
			passwordagain = $("#passwordagain").val();
		if (!password.length || !passwordagain.length) {
			showDialog("密码不能为空，且最少为6位。");
			return false;
		}
		if (password.length < 6 || passwordagain.length < 6) {
			showDialog("密码长度不正确，最少为6位。");
			return false;
		} else if (password !== passwordagain) {
			showDialog("两次输入密码不一致，请重新输入");
			return false;
		} else {
			$(this).attr("disabled", true);
			$.ajax({
				type: "POST",
				url: "<?php echo url("forget:password_find",array('step'=>'pset_password'));?>",
				dataType:"json",
				data: {
					username: $("#username").val(),
					password: password,
					passwordagain: passwordagain
				},
				success: function(json) {
					if (json.status=='0') {
						showDialog('重置成功');
						setTimeout(function() {
							window.location.href = '<?php echo url("index:index");?>';
						}, 2000);
					} else {
						$("#submit").removeAttr("disabled");
						showDialog(json.msg);
					}
				}
			});
		}
	});
	var passwordFlag = false;
	$("[name='password']").on("input", function() {
		var value = this.value;
		if (!value || value.length < 6) {
			$("#password-state").hide();
			$("#password-tip").addClass("err").show();
			$("#password-tip span").html("请输入正确的密码（密码长度最少6位以上）");
		} else {
			$("#password-state").show();
			var pass = $.trim(value);
			var level_score = 0;
			var rating = 0;
			var numericTest = /[0-9]/;
			var lowerCaseAlphaTest = /[a-z]/;
			var upperCaseAlphaTest = /[A-Z]/;
			var symbolsTest = /[\\.,!@#$%^&*()}{:<>|]/;
			if (numericTest.test(pass)) {
				level_score++
			}
			if (lowerCaseAlphaTest.test(pass) || upperCaseAlphaTest.test(pass)) {
				level_score++
			}
			if (symbolsTest.test(pass)) {
				level_score++
			}
			if (pass.length > 0 && pass.length < 6) {
				rating = 1
			} else {
				if (level_score < 3 && pass.length >= 6) {
					rating = 2
				} else {
					if (level_score = 3 && pass.length >= 6) {
						rating = 3
					}
				}
			}
			if (rating == 1) {
				document.getElementById("pwd_s").value = 1;
				$("#password-state .input-tip-inner span").attr("class", "");
				$("#password-state .input-tip-inner span").addClass("reg_mes mes_pass_weak")
			} else {
				if (rating == 2) {
					$("#password-state .input-tip-inner span").attr("class", "");
					$("#password-state .input-tip-inner span").addClass("reg_mes mes_pass_in");
					document.getElementById("pwd_s").value = 2
				} else {
					if (rating == 3) {
						$("#password-state .input-tip-inner span").attr("class", "");
						$("#password-state .input-tip-inner span").addClass("reg_mes mes_pass_strong");
						document.getElementById("pwd_s").value = 3
					}
				}
			}
			$("#password-tip").removeClass("err").hide();
			$("#password-tip span").html("");
		}
	});
	$("[name='passwordagain']").on("input", function() {
		var ele = this;
		if (!ele.value || ele.value.length < 6) {
			$("#passwordagain-tip").addClass("err").show();
			$("#passwordagain-tip span").html("请输入正确的密码（密码长度最少6位以上）");
			passwordFlag = false;
		} else {
			if (ele.value != $("#password").val()) {
				$("#passwordagain-tip").addClass("err").show();
				$("#passwordagain-tip span").html("两次输入的密码不一致");
				passwordFlag = false;
			} else {
				$("#passwordagain-tip").removeClass("err").hide();
				$("#passwordagain-tip span").html("");
				passwordFlag = true;
			}
		}
	});
});</script>		</div>
	
	<script type="text/javascript">if (!window.navigator.cookieEnabled) {
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