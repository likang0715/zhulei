<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js admin <?php if($_GET['ps']<=320){ ?>responsive-320<?php }elseif($_GET['ps']>=540){ ?>responsive-540<?php }?> <?php if($_GET['ps']>540){ ?> responsive-800<?php } ?>" lang="zh-CN">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="renderer" content="webkit">
	<meta name="format-detection" content="telephone=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="format-detection" content="email=no">
	<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
	<meta name="apple-mobile-web-app-title" content="<?php echo $config['site_name'];?>">
	<title><?php echo $chahui['name'];?></title>
	<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
	<meta name="description" content="<?php echo $config['seo_description'];?>" />
	<!-- ▼ Base CSS -->
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css?time=<?php echo time()?>" />
	<link rel="stylesheet" href="<?php echo TPL_URL;?>diancha/css/reset.css">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>diancha/css/jquery-weui.css">
	<!-- ▲ Base CSS -->
	<!-- ▼ Page CSS -->
	<link rel="stylesheet" href="<?php echo TPL_URL;?>/diancha/css/event_details.css">
	<!-- ▲ Page CSS -->
	<!-- ▼ Base JS -->
	<script src="<?php echo TPL_URL;?>/diancha/js/jquery-1.11.0.min.js"></script>
	<script src="<?php echo TPL_URL; ?>js/base.js"></script>
	<!-- ▲ Base JS -->
	<!-- ▼ Page JS -->
	<script src="<?php echo TPL_URL;?>/diancha/js/Validform_v5.3.2_min.js"></script>
	<!-- ▲ Page JS -->
</head>
<body class="event_details FastClick" style="max-width:640px;margin:0 auto;padding-bottom:45px;">

	<div class="event_con c_main">
		<?php echo $chahui['description'];?>
	</div>

	
	
	
</body>
</html>
