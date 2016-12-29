<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>绑定帐号</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="apple-mobile-web-app-capable" content="yes"/>
	<meta name='apple-touch-fullscreen' content='yes'/>
	<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
	<meta name="format-detection" content="telephone=no"/>
	<meta name="format-detection" content="address=no"/>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/login.css?time='<?php echo time();?>'"/>
	<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script>var is_open_sms = "<?php echo $is_used_sms;?>"</script>
	<script src="<?php echo TPL_URL;?>js/weixin_back.js?time='<?php echo time();?>'"></script>
	<script src="<?php echo STATIC_URL;?>js/layer_mobile/layer.m.js"></script>
<style>
/*#login{margin: 0.5rem 0.2rem;}*/
html {font-size: 312.5%;-webkit-tap-highlight-color: transparent;height: 100%;min-width: 320px;overflow-x: hidden;}		
body {margin: 0;}
body {font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;font-size: .28em;line-height: 1;color: #333;background-color: #f0efed;}		
input, button, select, textarea {font-family: inherit;font-size: inherit;line-height: inherit;}
.h1, .h2, .h3, h1, h2, h3{margin:0px;}
.btn-wrapper{margin:.28rem 0;}
dl.list{border-bottom:0;border:1px solid #ddd8ce;}
dl.list:first-child{border-top:1px solid #ddd8ce;}
dl.list dd dl{padding-right:0.2rem;}
dl.list dd dl {margin: 0; margin-bottom: -1px; padding-left: .2rem; border: 0;}		
dl.list dd dl>.dd-padding, dl.list dd dl dd>.react, dl.list dd dl>dt{padding-right:0;}
.nav{text-align: center;}
.subline{margin:.28rem .2rem;}
.subline li{display:inline-block;}
.captcha img{margin-left:.2rem;}
.captcha .btn{margin-top:-.15rem;margin-bottom:-.15rem;margin-left:.2rem;}
.navbar{background:#06bf04}
.btn{background:#06bf04}
.btn-weak{color:#fff;border-color:#fff;}
.navbar {border-bottom: 1px solid #06bf04;}
a {color: #FF658E;text-decoration: none;outline: 0;}
.home{background:url('<?php echo TPL_URL;?>css/img/homepage@2x.png') no-repeat scroll center center;text-indent:-10000px}
.navbar {height: 1.01rem;color: #fff;border-bottom: 1px solid #06bf04;background: #06bf04;display: -webkit-box;display: -ms-flexbox;position: relative;}
.navbar .nav-wrap-left {height: 1.01rem;line-height: 1.01rem;}
a.react, label.react {display: block;color: inherit;height: 100%;}
.nav-wrap-left a.back {height: 1rem;width: --.45rem;line-height: 1rem;padding: 0 .3rem;}
.text-icon {font-family: base_icon;display: inline-block;vertical-align: middle;font-style: normal;}
.text-icon.icon-back {width: .45rem;height: .45rem;vertical-align: middle;position: relative;}
.text-icon.icon-back:before {content: '';display: block;position: absolute;left: .07rem;top: 0;width: .4rem;height: .4rem;border-bottom: .04rem solid #fff;border-left: .04rem solid #fff;-webkit-transform: scaleY(0.7) rotateZ(45deg);-moz-transform: scaleY(0.7) rotateZ(45deg);-ms-transform: scaleY(0.7) rotateZ(45deg);}
.text-icon.icon-back:after {content: '';display: block;position: absolute;top: .2rem;left: .03rem;border-top: .04rem solid #fff;height: 0;width: .45rem;}
.navbar h1.nav-header {-webkit-box-flex: 1;-ms-flex: 1;font-size: .36rem;font-weight: lighter;text-align: center;line-height: 1rem;margin: 0;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;}
.navbar .nav-wrap-right {height: 100%;}
.nav-wrap-right a { display: inline-block; height: 100%;line-height: 1rem;text-align: center; width: .94rem;}
.nav-wrap-right a:last-child {margin-right: .04rem;}
#tips {display: none;font-size: .26rem;background-color: #FFF6E0;/* color: #D78900; */color:#ff0000;border-bottom: 1px solid #FFEBC8;text-align: center;padding: .2rem;line-height: 1.4;}
dl.list:first-child {margin: 0;border-top: 0;}
dl.list dt, dl.list dd {margin: 0;border-bottom: 1px solid #e5e5e5;overflow: hidden;font-size: inherit;font-weight: 400;position: relative;}
dl.list dt, dl.list dd {margin: 0;border-bottom: 1px solid #e5e5e5;overflow: hidden;font-size: inherit;font-weight: 400;position: relative;}
dl.list .dd-padding, dl.list dt, dl.list dd>.react { padding: .28rem .2rem;}
dl.list dd dl>.dd-padding, dl.list dd dl dd>.react, dl.list dd dl>dt {padding-left: 0;}
input, button, select, textarea {font-family: inherit;font-size: inherit;line-height: inherit;}
input.input-weak, textarea.input-weak {border: 0;height: .6rem;margin: -.15rem 0;text-indent: .1rem;line-height: 1;font-size: .3rem;border-radius: .06rem;}
dl.list dd>.btn {margin-top: -.15rem;margin-bottom: -.15rem;}
.kv-line-r>.kv-v, .kv-line-r>p {display: block;}
.kv-line-r>h6, .kv-line-r>.kv-k {-webkit-box-flex: 1;-moz-box-flex: 1;-ms-flex: 1;font-size: inherit;font-weight: 400;margin-right: .2rem;display: block;}
dl.list dd>.input-weak {width: 100%;display: block;}
.btn {display: inline-block;margin: 0;text-align: center;height: .6rem;padding: 0 .32rem;border-radius: .06rem;color: #fff;border: 0;background-color: #06bf04;font-size: .28rem;vertical-align: middle;line-height: .6rem;box-sizing: border-box;cursor: pointer;-webkit-user-select: none;}
.btn-block {display: block;width: 100%;}
.btn-larger {height: .94rem;line-height: .94rem;font-size: .4rem;}
ul {margin: 0;padding: 0;list-style-type: none;}
.taba {display: -webkit-box;display: -ms-flexbox;position: relative;border-bottom: .08rem solid #ddd8ce;}
.taba li {display: block;text-align: center;-webkit-box-flex: 1;-ms-flex: 1;position: relative;}
.taba li a.react {padding-top: .28rem;padding-bottom: .2rem;}
.taba .slide {position: absolute;bottom: -.08rem;border-bottom: .08rem solid #06bf04;-webkit-transition: left .2s ease-in;}
</style>
</head>
<body id="index" data-com="pagecommon">
		<div id="container">
			<div id="login">
				<dl class="list">
					<dd class="nav">
						<ul class="taba taban noslide" data-com="tab">
							<li class="active" tab-target="login-form"><a class="react">绑定帐号</a>
							</li><li tab-target="reg-form"><a class="react">注册新帐号</a>
						</li><div class="slide" style="left:0px;width:0px;"></div>
						</ul>
					</dd>
				</dl>
				<form id="login-form"  name="login_form" autocomplete="off" method="POST" action="login.php?action=bind" referer="<?php echo $redirect_uri;?>">
					<dl class="list list-in">
						<dd>
							<dl>
								<dd class="dd-padding">
									<input id="login_phone" class="input-weak input_phone" type="tel" placeholder="手机号" name="phone" value="" />
								</dd>
								<dd class="dd-padding">
									<input id="login_password" class="input-weak" type="password" placeholder="请输入您的密码" name="pwd" />
								</dd>
								<?php if($is_used_sms == '1') {?>		
								<dd class="kv-line-r dd-padding dd-sms" >
									<input id="bind-sms" class="pwd_password input-weak kv-k js-register-code" type="text"  maxlength="4" placeholder="输入短信验证码"/>
									<input type="hidden" class="password_type" value="0"/>
									<button id="changeWord" type="button" class="changeWord btn btn-weak kv-v sendToPhone get-code">发送短信</button>
								</dd>
								<?php }?>
								<dd>
									
								</dd>
							</dl>
						</dd>
					</dl>
					<!-- <a href="javascript:void(0)" style="line-height: 40px;padding:0 10px;float:right;" id="unneed_bind">跳过绑定?</a> -->
					<div class="btn-wrapper">
						<input type="hidden" name="store_id" value="<?php echo $store_id; ?>" />
						<button type="submit" class="js-submit btn btn-larger btn-block">绑定※登录</button>
					</div>
				</form>
				
				
				<form id="reg-form" name="reg_form"	 autocomplete="off" 	method="GET"	action="<?php echo $redirect_uri;?>"	style="display:none;">
					<dl class="list list-in">
						<dd>
							<dl>
								<dd class="dd-padding">
									<input id="reg_phone" class="input-weak input_phone" type="tel" placeholder="手机号" name="phone" value="" />
								</dd>
								<dd class="kv-line-r dd-padding">
									<input id="reg_pwd_password" class="input-weak kv-k" type="password" placeholder="6位以上的密码"/>
									<input id="reg_txt_password" class="input-weak kv-k" type="text" placeholder="6位以上的密码" style="display:none;"/>
									<input type="hidden" id="reg_password_type" value="0"/>
									<button id="reg_changeWord" type="button" class="btn btn-weak kv-v">显示明文</button>
								</dd>
								<?php if($is_used_sms == '1') {?>		
								<dd class="kv-line-r dd-padding dd-sms" >
			            			<input id="reg-sms" class="pwd_password input-weak kv-k js-register-code" type="text"  maxlength="4" placeholder="输入短信验证码"/>
			            			
			            			<button id="changeWord" type="button" class="changeWord btn btn-weak kv-v sendToPhone get-code">发送短信</button>
			            		</dd>
								<?php }?>
								<dd class="dd-padding">
									<input id="readme" type="checkbox"  name="readme" value="1" />
									&nbsp;我已阅读并同意<a class="js-readme" style="color:#07d;" href="javascript:;">《用户注册协议》</a>
								</dd>
							</dl>
						</dd>
					</dl>
					<div class="btn-wrapper">
						<input type="hidden" name="store_id" value="<?php echo $store_id; ?>" />
						<button type="submit" class="js-submit btn btn-larger btn-block">注册并绑定</button>
					</div>
				</form>
			</div>
		</div>

		<div class="js-readme_content" style="display: none;">
			<?php echo nl2br($config['reg_readme_content']);?>
		</div>
		
	</body>
</html>



<script type="text/javascript">
$(function(){
	var openid 	= '<?php echo $openid;?>';
	var is_weixin 	= '<?php echo $is_weixin;?>';

	if(is_weixin == ''){
		layer.open({
			content: '请在微信端打开此页面',
			btn: ['确定']
		});
	}else if(openid == ''){
		layer.open({
			content: '授权错误，暂时无法注册',
			btn: ['确定']
		});
	}else{
		layer.open({
			//content: '授权成功，请绑定您的手机账号',
			content: '当前微信帐号尚未绑定手机，请绑定！',
			btn: ['确定']
		});
	}
	
	$("#unneed_bind").click(function(){
		layer.open({
			title:['提醒：','background-color:#8DCE16;color:#fff;'],
			content:'跳过绑定将无法收到短信通知，无法同步PC端账号，确认跳过绑定么',
			btn: ['取消', '确定'],
			shadeClose: false,
			no: function(){
				$.ajaxSetup({async:false}); 
				$.ajax({
	                url: "login.php?action=weixin_nobind",
	                type: "post",
					dataType:"json",
	                data: {},
	                success: function (result) {
						if(result.err_code == 0){
							layer.open({content: '登录成功！', time:2});
							window.location.href = $('#login-form').attr('action');
						} else {
							layer.open({content: result.err_msg, time:2});
						}
					}
	            });	
			}
		});
		return false;
	})
	var reg_readme_content = $('.js-readme_content').html();
	$('.js-readme').click(function(){
		layer.open({
		    //btn: ['关闭'],
		     title: [
		        '用户注册协议',
		    ],
		    content:reg_readme_content,
		    style:'height:100%;overflow:auto;'
		     
			   // style: 'position:fixed; left:0; top:0; width:100%; border:none;'
		})

	});
})


		
var checkuser_url = "./login.php?action=checkuser";
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
			$(".get-code").html(sysj+"秒后重新获取");
			var code1=$(".get-code");
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

	$(".get-code").click(function(event) {
		var index_get_code = $(".get-code").index($(this));
		event.stopPropagation();
		var time=120;
		var code=$(this);
		if(index_get_code == '0') {
			var checktype = "bind";
		}else if(index_get_code == '1') {
			var checktype = "reg";
		}else{
			layer.open({
				content: '请正确填写手机号',
				btn: ['确定']
			});
			return false;
		}
		
		if(validCode1) {
			//检测是否已经注册
			var mobile = $(".input_phone").eq(index_get_code).val();
			if(!mobile) {
				layer.open({
					content: '请填写手机号',
					btn: ['确定']
				});
				return true;
			}
			
			if(mobile.match(/^(1)[0-9]{10}$/ig)==null) {
				if(index_get_code == '1') {
					document.login_form.phone.focus();
				} else {
					document.reg_form.phone.focus();
				}
			
				layer.open({
					content: '手机号码格式不正确',
					btn: ['确定']
				});
				return false;
			}
		
			if(!validCode) return false;
			
			$.post(checkuser_url,{'check_type':checktype,'is_ajax':'1','mobile':mobile},function(data) {
					if(data.status>0) {
						layer.open({
							content: data.msg,
							btn: ['确定']
						});
						returns = '0';
					} else {
						//可以注册或绑定
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
								code.attr("disabled",true);
								if (time==0) {
									clearInterval(t);
									code.html("获取短信验证码");
									code.attr("disabled",false);
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




})
</script>