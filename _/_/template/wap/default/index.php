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
		<title><?php echo $config['site_name'];?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>index_style/css/index.css"/>
		<script src="<?php echo STATIC_URL;?>js/fastclick.js"></script>
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script src="<?php echo STATIC_URL;?>js/jquery.waterfall.js"></script>
		<script src="<?php echo STATIC_URL;?>js/idangerous.swiper.min.js"></script>
		<script>var noCart=true;</script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
        <script src="<?php echo TPL_URL;?>js/common.js"></script>
		<script src="<?php echo TPL_URL;?>index_style/js/index.js"></script>
	</head>
	<body style="padding-bottom:50px;background-color:#f7f7f7;min-width:320px;max-width:640px;margin:0 auto;">
		<div class="wx_wrap">
			<div class="WX_search" id="mallHead">
				<div class="WX_bar_cate">
					<a href="./category.php" id="__cate"></a>
				</div>
				<form action="" method="get" class="WX_search_frm" onsubmit="return false;">
					<input type="search" class="WX_search_txt" id="topSearchTxt" placeholder="搜索全部商品"/>
					<a class="WX_search_clear" href="javascript:;" id="topSearchClear" style="display:none;">x</a>
				</form>
				<div class="WX_me">
					<a href="javascript:" id="topSearchbtn" class="WX_search_btn_blue" style="display:none;">搜索</a>
					<a href="javascript:" id="topSearchCbtn" class="WX_search_btn" style="display:none;">取消</a>
				</div>
			</div>
			<div class="container" style="background-color:<?php if($homePage['bgcolor']){ echo $homePage['bgcolor']; }else{ echo '#f3f3f3'; }?>;">
				<div class="content" style="margin-top:0px;margin-bottom:0px;width:auto;min-width:320px;max-width:640px;">
					<div class="content-body" style="width:auto;min-width:320px;max-width:640px;border:none;">
						<?php if($homeCustomField){ foreach($homeCustomField as $value){echo $value['html'];} } ?>
					</div>
				</div>
			</div>
			<div class="wx_nav">
				<a href="./index.php" class="nav_index on">首页</a>
				<a href="./category.php" class="nav_search">分类</a>
				<a href="./weidian.php" class="nav_shopcart">店铺</a>
				<a href="./my.php" class="nav_me">个人中心</a>
			</div>
		</div>
	</body>
</html>