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
			<div class="veri_step_pic veri_step_pic1">
			</div>
			<ul class="clearfix">
				<li class="light">验证身份</li>
				<li>重置密码</li>
				<li>完成</li>
			</ul>
		</div>
		<div class="veri_con">
			<div class="veri_input">
				<ul class="input-list">
					<li>
						<div class="input">
							<label for="email">已验证手机：</label>
							<span class="yh f16 c_333" id="tel"><?php echo substr_replace($$cmobile,'****',3,4);?></span>
						</div>
					</li>
					<!-- 验证码 
					<li>
						<div class="input">
							<label>验证码：</label>
							<input maxlength="4" placeholder="不区分大小写" name="identify" id="identify" class="txt-m  identify_code txt_grey" type="text">
							<img style="cursor: pointer;vertical-align: middle;margin-top:-3px" alt="如验证码无法辨别，点击即可刷新。" id="identify_img"  src="<?php echo url("forget:verify") ;?>"  onclick='document.getElementById("identify_img").src = "<?php echo TPL_URL;?>images/ico/load_small.gif";document.getElementById("identify_img").src = "<?php echo url('forget:verify')?>&time=" + (new Date().getTime() + Math.random());' height="32" width="81">

						</div>
						<div id="codeTip1" class="input-tip">
							<div class="input-tip-inner">
							    <span id="code_err"></span>
								<span>看不清，
									<a class="green" href="javascript:void(0);" onclick='document.getElementById("identify_img").src = "<?php echo TPL_URL;?>images/ico/load_small.gif";document.getElementById("identify_img").src = "<?php echo url('forget:verify')?>&time=" + (new Date().getTime() + Math.random());'>
										换一张
									</a></span>
							</div>
						</div>
					</li>
					-->
					<li class="last">
						<div class="input">
							<label>手机验证码：</label>
							<input placeholder="请输入4位验证码" maxlength="4" id="code" class="txt-m m-verify-code txt_grey" type="text">
							    <a  href="javascript:void(0);" class="sendToPhone get-code">获取手机验证码</a>
                                <a href="javascript:void(0);" class="sendToPhone send-code" style="display: none;"><span>0</span>秒后重新发送</a>
                                <a href="javascript:void(0);" class="sendToPhone send-code-again" style="display: none;">重新发送</a>
							<span>
								<a class="send_link" id="send_link" style="display: none;" href="javascript:void(0);">
									重新发送
								</a>
							</span>
						</div>
						<div id="codeTip" class="input-tip">
							<div class="input-tip-inner">
								<span></span>
							</div>
						</div>
					</li>
				</ul>
				<div class="ml96 mt20">
					<input id="info_submit" value="下一步" class="login_btn submit_btn" type="button">
				</div>
				<div class="ml96 mt20">
                    <a class="choose-other" href="<?php echo url("forget:password_find");?>"> 选择其他验证方式</a>
                </div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">$(function() {

	function showDialog(msg,types) {
		$.layer({
			title: 0,
			closeBtn: 0,
			time: 4,
			shadeClose: true,
			dialog: {
				type: types,
				msg: msg
			},
			offset: ['90px', '']
		});
	}
	var codeFlag, oldValue = [];
	$(".get-code").bind("click", sendCode);
	$(".input-list input:text").blur(function(){
        $(this).trigger("input", 'blur');
	}).on("input", function(e, blur) {
		var value = this.value;
		if (this.name == "identify") {
			
/*			if (blur != 'blur' && oldValue['identify'] && oldValue['identify'] == value) {
				return;
			}
			identifyCodeFlag = false;
			oldValue["identify"] = value;
			if (!value || value.length < 4 || new RegExp("^([0-9a-zA-Z])+$").test(value) == false) {
				$("#codeTip1").addClass("err");
				$("#code_err").show().html("请输入正确的验证码&#12288;&#12288;");
				return false;
			} else if (!identifyCodeFlag && value.length == 4) {
				$.ajax({
					url: "<?php echo url('forget:checkCaptcha');?>",
					data: {
						verify:value
					},
					dataType:'json',
					type: "GET",
					success: function(json) {

						if (json.status!='0') {
							identifyCodeFlag = false;
							$("#codeTip1").addClass("err");
							$("#code_err").show().html("请输入正确的验证码&#12288;&#12288;");
						} else {
							$("#codeTip1").removeClass("err");
							$("#code_err").hide().html("");
							identifyCodeFlag = true;
						}
					}
				});
			}*/
		} else if (this.id == "code") {
			if (blur != 'blur' && oldValue['code'] && oldValue['code'] == value) {
				return;
			}
			codeFlag = false;
			oldValue['code'] = value
			if (!value || value.length < 4 || new RegExp("^([0-9])+$").test(value) == false) {
				$("#codeTip").addClass("err").show();
				$("#codeTip span").html("请输入正确的手机验证码&#12288;&#12288;");
				codeFlag = false;
			} else if (value.length == 4) {
				$("#codeTip").removeClass("err").hide();
				$("#codeTip span").html("");
				codeFlag = true;
			}
		}
	});
	//手机发送动态码
	function sendCode() {
        // 暂时关闭发送动态密码前的验证码校验
			if ( 1 || identifyCodeFlag) {
				$(".get-code,.send-code-again").attr("disabled", true);
				$(".get-code,.send-code-again").unbind("click");
				var postData = {
					mobile: $("#tel").html(),
					identify_code: $("[name='identify']").val(),
					is_login: 1
				}
/* 				if (window.location.href.match("bind/weixin")) {
					postData.is_login = 0;
				} */
					
				$.post('<?php echo url("forget:password_find",array('step'=>'sendcode'));?>', postData, function(json) {

					if (json.status==0) {
						showDialog("手机验证码已发送，5分钟内有效！",'1');
						$(".get-code,.send-code-again").hide();
						intervalTime(300);
					} else {
						$(".get-code,.send-code-again").removeAttr("disabled");
						$(".get-code,.send-code-again").bind("click", sendCode);
						switch (json.status) {
							case -1:
								showDialog("请输入正确的手机号码",'2');
								return;
								break;
							case -3:
								showDialog("手机验证码发送失败，请稍候重试。",'2');
								return;
								break;

							case '1':
								$("[name='identify']").focus();
								$("#captcha").show();
								showDialog("请输入正确的验证码",'2');
								document.getElementById("identify_img").src = "";
								document.getElementById("identify_img").src = "<?php echo url('forget:verify')?>&time=" + (new Date().getTime() + Math.random());
								return;
								break;
								
							case '2':
								showDialog(json.msg,'2');
								return;
								break;	

							case '4085':
								showDialog(json.msg,'2');
								return;
								break;											
															
							default:
								showDialog("手机验证码已发送至您手机！",'1');
								break;
						}
					}
				},
				'json'
				);
			} else {
				$("#identify").trigger("input");
			}
		}
		//end

	function intervalTime(num) {
		var num = parseInt(num);
		var i = 0;
		$(".send-code").css("display", "inline-block");
		$(".send-code span").text(num);
		var inter = setInterval(function() {
			if (i < num) {
				i++;
				$('.send-code span').text(num - i);
			} else {
				clearInterval(inter);
				$(".send-code-again").css("display", "inline-block").bind("click", sendCode).removeAttr("disabled");
				$(".send-code").hide();
				$(".send-code span").text(0);
			}
		}, 1000);
	}
	//手机验证后  进入下一步
	$("#info_submit").on("click", function() {
		if (codeFlag) {
			$.ajax({
				type: "POST",
				data: {
					mobile: $("#tel").html(),
					verify: $("[name='identify']").val(),
					code: $("#code").val()
				},
				dataType:"json",
				url:"<?php echo url("forget:password_find",array('step'=>'third_vermobile'));?>",
				success: function(json) {
					if(json.status != 0) {
						document.getElementById("identify_img").src = "<?php echo TPL_URL;?>images/ico/load_small.gif";
						document.getElementById("identify_img").src = "<?php echo url('forget:verify')?>&time=" + (new Date().getTime() + Math.random());
						$("input:text").each(function(i,item){
							item.value = "";
						});
						showDialog(json.msg,'2');
					} else {
						//进入下一步
						window.location.href="<?php echo url("forget:password_find",array('step'=>'pset_password'));?>";
					}
				}
			});
		} else {
			$(".input-list input:text").each(function(i, item) {
				$(item).trigger("input");
			});
		}
	});
});</script>&gt;
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
};
</script>
</body></html>