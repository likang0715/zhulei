<!DOCTYPE html>
<!-- saved from url=(0032)http://dd2.pigcms.com/wap/my.php -->
<html lang="zh-CN"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title>我的会员卡</title>
		<meta name="format-detection" content="telephone=no">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="default">
		<meta name="applicable-device" content="mobile">
		<link rel="stylesheet" href="<?php echo TPL_URL;?>index_style/css/my.css">
		<script src="<?php echo STATIC_URL;?>js/fastclick.js"></script>
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script src="<?php echo TPL_URL;?>index_style/js/base.js"></script>
		<style>
			body{background: #fff}
		</style>
	</head>
	<body>
		<div class="wx_wrap">
			<div class="my_head">
				<div class="userAvatr">
					<div class="avatarImg">
						<img src="<?php echo $avatar;?>"/>
					</div>
					<div class="userDesc" style="width: auto;"><?php echo $wap_user['nickname'];?><p style="padding: 5px 0px">可用平台积分：<?php echo number_format($wap_user['point_balance'], 2, '.', ''); ?></p></div>
				</div>
			</div>

			<div class="codeSection" style="margin-top: 30px;border: none;">
				<div class="codeImg">
					<!--  
						<img src="img/code.png" width="322.5" height="345"/>
					-->
					
					<!--<img src="./my_memcard.php?action=txm" />-->
					<img src="./my_memcard.php?action=ewm" style="width: 300px;height: 300px" />
				</div>
			</div>
		</div>

</body></html>