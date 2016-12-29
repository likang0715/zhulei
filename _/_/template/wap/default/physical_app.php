<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js admin <?php if($_GET['ps']<=320){ ?>responsive-320<?php }elseif($_GET['ps']>=540){ ?>responsive-540<?php }?> <?php if($_GET['ps']>540){ ?> responsive-800<?php } ?>" lang="zh-CN">
<head>
	<meta charset="utf-8"/>
	<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
	<meta name="description" content="<?php echo $config['seo_description'];?>" />
	<title><?php echo $store_physical['name'];?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
	<meta name="renderer" content="webkit">
	<meta name="format-detection" content="telephone=no" />
	<meta name="format-detection" content="email=no" />
	<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css?time=<?php echo time()?>" />
	<?php if($is_mobile){ ?>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase.css" />
	<script>var is_mobile = true;</script>
	<?php }else{ ?>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase_admin.css" />
	<script>var is_mobile = false;</script>
	<?php } ?>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>/diancha/css/reset.css">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>/diancha/css/shop_details.css">
	<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script src="<?php echo STATIC_URL;?>js/idangerous.swiper.min.js"></script>
	<script src="<?php echo TPL_URL;?>js/base.js?time=<?php echo time()?>"></script>
</head>
<body class="shop_details FastClick">

		<div class="shop_desc c_main">
			<span class="desc_text"><?php echo $store_physical['description'];?></span>
		</div>
	
	
</body>
</html>
