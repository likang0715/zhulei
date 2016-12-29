<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js" lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<meta name="HandheldFriendly" content="true"/>
		<meta name="MobileOptimized" content="320"/>
		<meta name="format-detection" content="telephone=no"/>
		<meta http-equiv="cleartype" content="on"/>
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title>出错了</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<style type="text/css">
		.error_wrap {  }
		.error_wrap .error_img { padding-top: 120px; width: 50%; margin: 0 auto; }
		.error_wrap .error_img img { width: 100%; }
		.error_wrap .error_p { width: 50% margin: 0 auto; padding-top: 20px; text-align: center; }
		.error_wrap .error_p .error_top { font-size: 16px; font-weight: bold; color: #333; }
		.error_wrap .error_p .error_bot { color: #333; font-size: 14px; padding-top: 10px; }
		.error_wrap .error_p .error_bot a { color: #45a5cf; }
		</style>
	</head>
	<body style="padding-bottom:50px;background-color:#eee;min-width:320px;max-width:640px;margin:0 auto;">
		<div class="error_wrap">
			<div class="error_img"><img src="<?php echo TPL_URL;?>images/404.png"></div>
			<div class="error_p">
				<div class="error_top"><?php echo $error_msg; ?></div>
				<div class="error_bot">请您重新刷新页面或者 <a href="<?php echo $redirect_url ?>">返回</a></div>
			</div>
		</div>
	</body>
</html>