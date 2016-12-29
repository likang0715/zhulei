<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="en" style="background: #fff;">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title>我的活动</title>
		<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/my_offline.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/font-awesome.min.css"/>
		<style type="text/css">
		.myactivityul { background-color: #eee; }
		.myactivityul li { background-color: #fff; }
		.myactivityul li:nth-child(2) { margin-bottom: 10px; }
		</style>
	</head>
	<body>
	    <ul class="myactivityul">
	        <li><a href="<?php echo option('config.site_url').'/webapp/groupbuy/#/mybuy/'.$store_id; ?>">
	            <div class="fl"><img class="fl" src="<?php echo TPL_URL;?>css/images/icon-d.png" alt="">
	                <span class="myactivityul-left fl">拼团记录</span>
	                <div class="clear"></div></div>
	            <div class="fr myactivityul-right"><span class="fl"><?php echo $count['tuan'] ?></span><span class="icon-angle-right icon-2x fl"></span></div>
	            <div class="clear"></div>
	            </a>
	        </li>
	        <li>
	        	<?php if (empty($store_id)) { ?>
		        	<a href="<?php echo option('config.site_url').'/webapp/snatch/#/orderinfo/0'; ?>">
	        	<?php } else { ?>
		        	<a href="<?php echo option('config.site_url').'/webapp/snatch/#/orderinfo/'.$store_id; ?>">
	        	<?php } ?>
	            <div class="fl"><img class="fl" src="<?php echo TPL_URL;?>css/images/icon-e.png" alt=""><span class="myactivityul-left">夺宝记录</span><div class="clear"></div></div>
	            <div class="fr myactivityul-right"><span class="fl"><?php echo $count['unitary'] ?></span><span class="icon-angle-right icon-2x fl"></span></div>
	            <div class="clear"></div>
	        </a>
	        </li>
	        <!-- 
	        <li><a href="#">
	            <div class="fl"><img class="fl" src="<?php echo TPL_URL;?>css/images/icon-f.png" alt=""><span class="myactivityul-left">预定商品</span><div class="clear"></div></div>
	            <div class="fr myactivityul-right"><span class="fl">x</span><span class="icon-angle-right icon-2x fl"></span></div>
	            <div class="clear"></div>
	        </a>
	        </li>
	        <li><a href="#">
	            <div class="fl"><img class="fl" src="<?php echo TPL_URL;?>css/images/icon-g.png" alt=""><span class="myactivityul-left">砍价商品</span><div class="clear"></div></div>
	            <div class="fr myactivityul-right"><span class="fl">x</span><span class="icon-angle-right icon-2x fl"></span></div>
	            <div class="clear"></div>
	        </a>
	        </li>
	        <li><a href="#">
	            <div class="fl"><img class="fl" src="<?php echo TPL_URL;?>css/images/icon-h.png" alt=""><span class="myactivityul-left">砍价商品</span><div class="clear"></div></div>
	            <div class="fr myactivityul-right"><span class="fl">x</span><span class="icon-angle-right icon-2x fl"></span></div>
	            <div class="clear"></div>
	        </a>
	        </li>
	        <li><a href="#">
	            <div class="fl"><img class="fl" src="<?php echo TPL_URL;?>css/images/icon-i.png" alt=""><span class="myactivityul-left">降价抢拍</span><div class="clear"></div></div>
	            <div class="fr myactivityul-right"><span class="fl">x</span><span class="icon-angle-right icon-2x fl"></span></div>
	            <div class="clear"></div>
	        </a>
	        </li>
	        <li><a href="#">
	            <div class="fl"><img class="fl" src="<?php echo TPL_URL;?>css/images/icon-j.png" alt=""><span class="myactivityul-left">众筹商品</span><div class="clear"></div></div>
	            <div class="fr myactivityul-right"><span class="fl">x</span><span class="icon-angle-right icon-2x fl"></span></div>
	            <div class="clear"></div>
	        </a>
	        </li>
			-->
	    </ul>
	</body>
</html>