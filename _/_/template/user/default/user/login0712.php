<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>登录/注册-<?php echo $config['site_name'];?></title>
	<meta name="Keywords" content="<?php echo $config['seo_keywords'];?>">
	<meta name="description" content="<?php echo $config['seo_description'];?>">
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>  
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.form.min.js"></script> 
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/common.js" type="text/css" rel="stylesheet"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
	<link href="<?php echo TPL_URL;?>css/style.css" type="text/css" rel="stylesheet">
	<link href="<?php echo TPL_URL;?>css/index.css" type="text/css" rel="stylesheet">
	<link href="<?php echo TPL_URL;?>css/login.css" type="text/css" rel="stylesheet">
	<style type="text/css">
	.content{width:auto;}
	.cent_link a {width: auto;}
	.login-content{right:135px;}
	.xubox_main .xubox_iframe{position:static;}
	</style>	
</head>	

<body id="index1200" class="index1200">

	<!-- common header start -->
	<div class="header">
		<div class="header_common">
			<div class="header_inner">
				<div class="site_logo">
					<a href="<?php echo $config['site_url'];?>"  >
						<img src="<?php echo $config['site_logo'];?>" width="235" height="70">
					</a>
				</div>
			</div>
		</div>  
	</div>

<div id="loginWrap" class="wrap" 
	<?php if($ad['pic']) {?>	
		style="background-image:url(<?php echo $ad['pic'];?>)"
	<?php } else{?>
		style="background-image:url(<?php echo TPL_URL;?>images/ico/1yuan_2.jpg)"
	<?php }?>
>
	<div id="content" class="content">
		<div id="cent_link" class="cent_link">
			<a id="link_1" 
			<?php if($ad['url']) {?>
				href="<?php echo $ad['url'];?>"
			<?php }else{?>
				href="javascript:void(0)"
			<?php }?>
			style="display:block;"></a>
		</div>
		<input id="errLoginType" value="P-N" type="hidden">
		<input id="errLoginMsg" value="" type="hidden">

<div id="login-content" class="login-content" style="background-color: #fff;">
	<div id="login-box" class="login-box-inner">
		<ul id="login-tab" class="login-tab">
			<li id="login-tab-user" <?php if($type!= 'register') {?>class="cur"<?php }?>>会员登录<b></b></li>
			<li <?php if($type=='register') {?>class="cur"<?php }?> id="login-tab-pass">会员注册<b></b></li>
		</ul>
		
		<div>
		
	   
			<div  <?php if($type != 'register') {?><?php }else{?>style="display: none;"<?php }?>  class="login-tab-content" id="login-tab-content0">
			<?php if($config['web_login_show'] != 2){ ?>
			<form id="login" action="<?php echo url('user:login') ?>" method="post" onsubmit="return checkLogin()">
			
			<input name="login_type" id="login_type" value="P-N" type="hidden">
				<table class="login-table">
					<tbody>
					<tr>
						<td class="login-tip">
							<div id="login_error" class="error login_error" style="display: none;"></div>
						</td>
					</tr>
					<tr id="line_4" class="line_4">
						<td>
							<div class="input_div">

   								<span class="span">&nbsp;</span>
    							<input name="phone" id="phone" autocomplete="off" tabindex="1" class="txt txt-m txt-focus cgrey2" style="font-size:12px;" placeholder="请输入手机号" type="text">
							</div>
						</td>
					</tr>
					<tr id="line_2" class="line_2">
						<td>
							<div class="input_div">
								<span class="span">&nbsp;</span>
								<input name="password" autocomplete="off" tabindex="2" class="txt txt-m" id="password" type="password">
							</div>
						</td>
					</tr>
                    <tr class="line_4">
                        <td class="cgrey2 line2" style="height:33px">
                            <a target="_blank" href="javascript:void(0);" class="search_psw forget_pw">忘记密码？</a>
                        </td>
                    </tr>
					<?php if($is_used_sms) {?>
					 <!-- <tr class="line_4">
					 						<td class="cgrey2 line2" style="height:33px">
					 							
					 							<a target="_blank" href="<?php echo url('forget:password_find') ;?>" class="search_psw">忘记密码？</a>
					 						</td>
					 					</tr> -->
					<?php }?>
					
					<tr>
						<td class="line2">
							<input type="hidden" name="referer" value="<?php echo $referer ?>" />
							<input name="current_login_url" value="" type="hidden">
							<input value="登录" name="submit_login" tabindex="5" id="J_Login" class="sub" type="submit">
						</td>
					</tr>
				</tbody></table>
			
		</form>
		
		<?php if($config['web_login_show'] != 1) { ?>
		<div class="partner-login">
			<div class="oauth-wrapper">
				<h3 class="title-wrapper"><span class="title">用手机微信扫码登录</span></h3>
				<div class="oauth cf">
					<a href="javascript:void(0);" id="wx_login" class="oauth__link oauth__link--weixin"></a>
				</div>   
			</div>				
		</div>	
		<?php }?>
		<?php }else{ ?>
					<iframe src="./index.php?c=recognition&a=see_login_qrcode&mt=none&referer=<?php echo urlencode($referer);?>" style="border:none;height:420px;"></iframe>
		<?php } ?>		
		</div>

		<!--注册-- start-->
			<div <?php if($type == 'register') {?><?php }else{?>style="display: none;"<?php }?> class="login-tab-content " id="login-tab-content1">
			
			<?php if($config['web_login_show'] != 2){ ?>
			<form name="form_register" class="form_register" id="register" action="<?php echo url('user:register') ?>" method="post" <?php if(($config['is_need_sub_register'] == '1') || in_array($config['web_login_show'],array('2','3'))){ ?> style="display:none"<?php }?>>
				<input name="login_type" value="P-M" type="hidden">			
				<table class="login-table">
					<tbody>
					<tr>
						<td class="login-tip">
							<div id="login_error" class="error login_error" style="display: none;"></div>
						</td>
					</tr>
					<tr id="line_4" class="line_4">
						<td>
							<div class="input_div">
							<span class="span">&nbsp;</span>
								<input name="phone" id="phone1" autocomplete="off" value="<?php echo $sms_register['mobile'];?>" tabindex="1" class="txt txt-m txt-focus cgrey2" style="font-size:12px;" placeholder="请输入手机号码" type="text">
							</div>
						</td>
					</tr>
					<tr id="line_1" class="line_1">
						<td>
							<div class="input_div">
							<span class="span">&nbsp;</span>
								<input name="nickname" id="nickname1" autocomplete="off" tabindex="2" class="txt txt-m txt-focus cgrey2" placeholder="请输入昵称" type="text">
							</div>
						</td>
					</tr>
					<tr id="line_2" class="line_2">
						<td>
							<div class="input_div">
							<span class="span">&nbsp;</span>
								<input id="password1" name="password"  autocomplete="off" tabindex="2" class="txt txt-m" type="password">
							</div>
						</td>
					</tr>
					
					<!-- 是否开启邀请码填写 -->
					<?php if ($config['allow_agent_invite'] == 1) { ?>
					<tr id="line_7" class="line_7">
						<td>
							<div class="input_div">
							<span class="span">&nbsp;</span>
								<input name="agent_code" id="agent_code" autocomplete="off" tabindex="2" class="txt txt-m txt-focus cgrey2" placeholder="请输入邀请码" type="text" value="<?php echo $agent_code ?>">
							</div>
						</td>
					</tr>
					<?php } ?>

<style>

#sendMobileCode {
    margin-right: 0;
}
a:link, a:visited {
    color: #333;
    text-decoration: none;
}
.btn, .btn-comm {
    background: #f4f4f4 none repeat scroll 0 0;
    border: 1px solid #dddddd;
    color: #333;
    display: inline-block;
    height: 36px;
    line-height: 36px;
    margin-left: 10px;
    margin-top: 0;
    padding: 0;
    text-align: center;
    text-decoration: none;
    width: 106px;
}
.login-table td{height:55px;}			
</style>					
					
			<tr id="line_2" class="line_2">
				<td>
					<div style="height:38px;display:inline-block;line-height:38px;color:#999;">
						验&nbsp;&nbsp;&nbsp;&nbsp;证&nbsp;&nbsp;&nbsp;&nbsp;码：
					</div>
					
					<div class="input_div" style="width:120px;display:inline-block">
						<input style="width:120px;padding-left:0px;padding-right:0px" name="verify" id="verify" autocomplete="off" tabindex="2" class="txt txt-m txt-focus cgrey2" placeholder=" 请输入验证码" type="text">
					</div>
					
					<div class="input_div btn" style="border:0px;background:none;width:100px;display:inline-block;">
					<a   href="javascript:void(0);" class="b">
						<span><img style="cursor: pointer;width:85px;height:34px;margin-top:-4px;vertical-align: middle;*margin-top: -15px" alt="如验证码无法辨别，点击即可刷新。" id="identify_img" src="<?php echo url("user:verify") ;?>" onclick='document.getElementById("identify_img").src = "<?php echo TPL_URL;?>images/ico/load_small.gif";document.getElementById("identify_img").src = "<?php echo url('user:verify')?>&time=" + (new Date().getTime() + Math.random());' ></span>
					</a>
					</div>
				</td>
			</tr>					
			<?php if($is_used_sms) {?>
				   <tr id="line_1" class="line_1">
						<td>
							<div style="height:32px;display:inline-block;line-height:32px;color:#999;">
								短信验证码：
							</div>
							
							<div class="input_div" style="width:120px;display:inline-block">
								<input style="width:110px;" name="code" id="code" autocomplete="off" tabindex="2" class="txt txt-m txt-focus cgrey2" placeholder="验证手机" type="text">
							</div>
							
							<div class="input_div btn" style="width:100px;display:inline-block;">
							<a id="sendMobileCode"  href="javascript:void(0);" class="btns">
								<span id="dyMobileButton">获取短信验证码</span>
							</a>
							</div>
						</td>
					</tr>	
				
					<?php }?>
					<!--
					 <tr class="line_4">
						<td class="cgrey2 line2">
							<label style="vertical-align:middle"><input class="remember_me" tabindex="4" name="remember_me" id="rememberme2" value="1" style="vertical-align:middle" type="checkbox">&nbsp;两周内自动登录</label>
							<a target="_blank" href="" class="search_psw">忘记密码？</a>
						</td>
					</tr>-->
					<tr class="line_4" >
						<td class="cgrey2 line2" colspan="2" align="left" style="height:35px;" >
							<label ><input class="js-readme" tabindex="4" name="readme" id="readme" value="1"  type="checkbox" checked="checked" >&nbsp;我已阅读并同意<a style="color:#07d;" href="<?php echo url("account:readme") ;?>" target="_blank">《用户注册协议》</a></label>
						</td>
					</tr>
					<tr>
						<td class="line2">
							<input name="current_login_url" value="" type="hidden">
							<input type="hidden" name="referer" value="<?php echo $referer ?>" />
							<input class="sub" tabindex="5" onclick="" name="submit_login" value="注册" type="submit">
						</td>
					</tr>
				</tbody></table>
				</form>
				<?php } else {?>
					<iframe src="./index.php?c=recognition&a=see_register_qrcode&mt=none&referer=<?php echo urlencode($referer);?>" style="border:none;height:460px;"></iframe>				
				
				<?php }?>
						
				<?php if($config['is_need_sub_register']== 1) {?>
					<iframe src="./index.php?c=recognition&a=see_attention_qrcode&mt=none&referer=<?php echo urlencode($referer);?>" style="border:none;height:460px;"></iframe>
				<?php } ?>
			</div>
		

		<!--注册--end-->
	</div>
</div>
</div>
</div>






<!--start foot-->
   <?php include display('public:footer_login');?>
<!--end foot-->

<!-- common footer end -->

<script>
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
	
	function showRequest1() {
		var phone1 = $("#phone1").val();
		var password1 = $("#password1").val();
		var nickname1 = $("#nickname1").val();
		var code = $("#code").val();
		
		if (phone1.length == 0 && password1.length == 0) {
			tusi("请填写手机号和密码");
			return false;
		}

		if (!checkMobile(phone1)) {
			tusi("请正确填写您的手机号");
			return false;
		}
		if (nickname1.length==0) {
			tusi("昵称不能为空，请正确填写");
			return false;
		}
		if (password1.length < 6) {
			tusi("密码不能少于六位，请正确填写");
			return false;
		}
		/*
		if(code.length == 0) {
			tusi("请正确填写手机验证码");
			return false;
		}*/
		return true;
	}
	
	function checkLogin() {
		var res = showRequest();
		if(res==false){
			return;
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
				return;
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
	
		$(function(){
			/*$('#login').submit(function() {
				$(this).ajaxSubmit({
					beforeSubmit: showRequest,
					success: showResponse,
					dataType: 'json'
				});
				return false;
			});*/
			/*$('#login').ajaxForm({
				beforeSubmit: showRequest,
				success: showResponse,
				dataType: 'json'
			});*/
			/*$('#register').ajaxForm({
				beforeSubmit: showRequest1,
				success: showResponse,
				dataType: 'json'
			});*/
			$('#register').submit(function() {
				$(this).ajaxSubmit({
					beforeSubmit: showRequest1,
					success: showResponse,
					dataType: 'json'
				});
				return false;
			});

			$("#login-tab li").click(function(){
				var index_li = $("#login-tab li").index($(this));
				$("#login-tab li").removeClass("cur");
				$(".login-tab-content").hide().eq(index_li).show();
				$(this).addClass("cur");
			})

			// 如果链接有代理商邀请码 agent_code 则显示注册界面
			if ($("#agent_code").length > 0 && $("#agent_code").val().length > 0) {
				$("#login-tab li:eq(1)").trigger("click");
			}

			$("#wx_login").click(function(){
				$.layer({
					type: 2,
					title: false,
					shadeClose: true,
					shade: [0.4, '#000'],
					area: ['330px','430px'],
					border: [0],
					iframe: {src:'./index.php?c=recognition&a=see_login_qrcode&referer=<?php echo urlencode($referer);?>'}
				}); 
				
			})

            $(".forget_pw").click(function(){
                $.layer({
                    type: 2,
                    title: false,
                    shadeClose: true,
                    shade: [0.4, '#000'],
                    area: ['230px','270px'],
                    border: [0],
                    iframe: {src:'./user.php?c=user&a=forget_password'}
                });

            })

		
		})	
</script>
<script type="text/javascript">
var check_register_url = "<?php echo url('user:checkuser') ?>";
var returns;

$(function(){

	//获取短信验证码
	var validCode3 = true;
	//刷新页面 获取时间
		//从sms_register 获取的时间戳
		var time1 = "<?php echo $sms_register['timestamp']?$sms_register['timestamp']:0;?>";
		var time2 = "<?php echo time();?>";
		var sysj = parseInt(time1)-parseInt(time2)+120; 	//剩余时间
		if(sysj<0) {

		} else {
			$(".btns").find("#dyMobileButton").html(sysj+"秒后重新获取");
			var code1=$(".btns").find("#dyMobileButton");
			if (validCode3) {
				validCode3=false;
				code1.addClass("msgs1");
				var t1=setInterval(function  () {
					sysj--;
				code1.html(sysj+"秒后重新获取");
				if (sysj==0) {
					clearInterval(t1);
					code1.html("获取短信验证码");
					validCode3=true;
					//validCode1=true;
				code1.removeClass("msgs1");

				}
			},1000)
			}
			
		}
		
})




$(function  () {
	//防刷新 验证码重获
	//getCookie("register_mobile_code");


/////////////////	
	//获取短信验证码
	var validCode=true;
	//标识是否已经点击
	var validCode1=true;

	$(".btns").click(function(event) {
		
		event.stopPropagation();

		var time=120;
		var code=$(this).find("#dyMobileButton");
		if(validCode1) {
			
			//检测是否已经注册
			var mobile = $("#phone1").val();
			var verify = $("#verify").val();
			if(!mobile) {
				tusi("请正确填写您的手机号,再获取验证码");
				return true;
			}
			if(!verify) {
				tusi("请正确填写图形验证码！");
				return true;
			}
			if(document.form_register.phone.value.match(/^(1)[0-9]{10}$/ig)==null) {
				document.form_register.phone.focus();
				tusi("手机号码输入错误，请返回重新输入");
				return false;
			}
		
			if(!validCode) return false;
			$.post(check_register_url,{'is_ajax':'1','mobile':mobile,'verify':verify},function(data){

				
					if(data.status>0) {
						tusi(data.msg);
						returns = '0';
					} else {
						//可以注册
						//alert('可以注册')
						returns = '1';
						validCode1 = false;

							if (validCode) {
								try{
									clearInterval(t1);
								}catch(e){

								}
								validCode=false;
								code.addClass("msgs1");
								var t=setInterval(function  () {
								time--;
								code.html(time+"秒后重新获取");
								if (time==0) {
									clearInterval(t);
								code.html("获取短信验证码");
									validCode=true;
									validCode1=true;
								code.removeClass("msgs1");
				
								}
							},1000)
							}
					}
				},
				'json'
			)










			

		}	
	})




//检测是否已经注册
function checkregister(mobile,verify) {
	returns = 0;
	$.post(check_register_url,{'is_ajax':'1','mobile':mobile,'verify':verify},function(data){

			if(data.status>0) {
				layer.tips(data.msg);
				 returns = '0';
			} else {
				//可以注册
				//alert('可以注册')
				 returns = '1';
				 validCode1 = false;
				layer.tips('可以注册');
				return true;
				
			}
	},
	'json'
	)
	return true;
}




})

</script>
</body>
</html>