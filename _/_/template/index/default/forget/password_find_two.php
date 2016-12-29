<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>找回密码 - <?php echo $config['site_name'];?></title>
		<meta name="Keywords" content="<?php echo $config['seo_keywords'];?>">
		<meta name="description" content="<?php echo $config['seo_description'];?>">
 		<link href="<?php echo TPL_URL;?>css/forget.css" type="text/css" rel="stylesheet">
 		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>  
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>  		

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
					<p class="head_tip">找回密码</p>
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
					已有账号了？
					<a rel="nofollow" target="_self" href="<?php echo url("account:login");?>">
						登录
					</a>
				</div>
			</div>

	<div id="user-reg" class="user-reg">
    <div class="a_title title_oneStep clearfix">
            <a class="page_phone page_cur" href="javascript:void(0);" style="width:100%">
                <span>密码找回</span>
                <span class="poptip-arrow poptip-arrow-top">▼</span>
            </a>
        </div>
	<div class="common_div">
		<div class="veri_box">
		    <div>您正在为账户 <span class="yh f16"><?php echo substr_replace($user['phone'],'****',3,4);?></span>找回密码，请选择找回方式：</div>
			<ul class="style_list">
			    				<li class="clearfix">
					<span class="veri_icon icon_phone fl">
					</span>
					<div class="fl">
						<p class="s1">
							通过手机验证
						</p>
						<p class="s2">
							如果原手机号码<?php echo substr_replace($user['phone'],'****',3,4);?>接收短信验证码，请选择此方式
						</p>
					</div>
					<div class="fr">
						<input onclick="window.location.href='<?php echo url("forget:password_find",array('step'=>'two_getbytel'));?>';" class="veri_btn veri_yellow_btn" value="立即验证" type="button">
					</div>
				</li>
				
				<!--  
				<li class="clearfix">
					<span class="veri_icon icon_email fl">
					</span>
					<div class="fl">
						<p class="s1">
							通过邮箱验证
						</p>
						<p class="s2">
							如果您的1119*****@qq.com邮箱可正常使用，请选择此方式
						</p>
					</div>
					<div class="fr">
						<input class="veri_btn veri_yellow_btn" onclick="window.location.href='/forget/getByEmail';" value="立即验证" type="button">
					</div>
				</li>
				
				
				<li class="clearfix">
					<span class="veri_icon icon_people fl">
					</span>
					<div class="fl">
						<p class="s1">
							通过人工服务
						</p>
						<p class="s2">
							如您遇到问题，请拨打客服热线 400-xxx-xxx
						</p>
					</div>
				</li>-->
			</ul>
		</div>
	</div>
</div>		</div>
	
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