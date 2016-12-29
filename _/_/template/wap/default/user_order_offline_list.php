<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<title>用户做单列表-<?php echo option('config.site_name') ?></title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/my_offline.css">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/font-awesome.min.css">
	<style>
	.motify{
		display:none;
		position:fixed;
		top:35%;
		left:50%;
		width:220px;
		padding:0;
		margin:0 0 0 -110px;
		z-index:9999;
		background:rgba(0, 0, 0, 0.8);
		color:#fff;
		font-size:14px;
		line-height:1.5em;
		border-radius:6px;
		-webkit-box-shadow:0px 1px 2px rgba(0, 0, 0, 0.2);
		box-shadow:0px 1px 2px rgba(0, 0, 0, 0.2);
		@-webkit-animation-duration 0.15s;
		@-moz-animation-duration 0.15s;
		@-ms-animation-duration 0.15s;
		@-o-animation-duration 0.15s;
		@animation-duration 0.15s;
		@-webkit-animation-fill-mode both;
		@-moz-animation-fill-mode both;
		@-ms-animation-fill-mode both;
		@-o-animation-fill-mode both;
		@animation-fill-mode both;
	}
	.motify .motify-inner{
		padding:10px 10px;
		text-align:center;
		word-wrap:break-word;
	}
	.motify p{
		margin:0 0 5px;
	}
	.motify p:last-of-type{
		margin-bottom:0;
	}
	@-webkit-keyframes motifyFx{
		0%{-webkit-transform-origin:center center;-webkit-transform:scale(1);opacity:1;}
		100%{-webkit-transform-origin:center center;-webkit-transform:scale(0.85);}
	}
	@-moz-keyframes motifyFx{
		0%{-moz-transform-origin:center center;-moz-transform:scale(1);opacity:1;}
		100%{-moz-transform-origin:center center;-moz-transform:scale(0.85);}
	}
	@keyframes motifyFx{
		0%{-webkit-transform-origin:center center;-moz-transform-origin:center center;transform-origin:center center;-webkit-transform:scale(1);-moz-transform:scale(1);transform:scale(1);opacity:1;}
		100%{-webkit-transform-origin:center center;-moz-transform-origin:center center;transform-origin:center center;-webkit-transform:scale(0.85);-moz-transform:scale(0.85);transform:scale(0.85);}
	}
	.motifyFx{@-webkit-animation-name motifyFx;@-moz-animation-name motifyFx;@-ms-animation-name motifyFx;@-o-animation-name motifyFx;@animation-name motifyFx;}
	<?php 
	if (!empty($store)) {
	?>
		.managenav li {width: 33%; }
	<?php 
	} else {
	?>
		.managenav li {width: 50%; }
	<?php 
	}
	?>
	</style>
	<script>
	var store_id = "<?php echo $store['store_id'] ?>";
	var category_list = <?php echo json_encode($product_category_list) ?>;
	var noCart = true;
	</script>
	<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script src="<?php echo STATIC_URL;?>js/fastclick.js"></script>
	<script src="<?php echo TPL_URL;?>js/user_order_offline_list.js"></script>
	<script src="<?php echo TPL_URL;?>js/base.js"></script>
</head>
<body>
<ul class="nav managenav js-nav_list">
	<li class=" fl navli js-store_order">我的商家做单</li>
	<li class="nav-active fl navli">用户做单</li>
	<!--！！！！！！！！！！！！-->
	<!-- 现在的箭头是向上的，如果向下的话将 icon-caret-up 改成 icon-caret-down -->
	<li class="fl navshop navli js-status_list"><b class="txt" style="font-weight: normal;">订单状态</b><span class="navicon icon-caret-up"></span>
		<div class="nav-son" style="display: none;">
			<div class="nav-son-triangular"></div>
			<div class="nav-son-bj managenav-bj"></div>
			<div class="nav-son-con managenav-con" data-status="0">
				<div data-status="0" class="js-status">全部</div>
				<div data-status="1" class="js-status">未完成</div>
				<div data-status="2" class="js-status">完成</div>
			</div>
		</div>
	</li>
</ul>

<section class="shoplist manage-con js-order_list">
	<ul class="shoplist-ul manage-shopul">
		
	</ul>
</section>

<div class="js-loading" style="display: none;">
	<div class="spinner" style="margin: 20px auto;">
		<div class="spinner-container container1">
			<div class="circle1"></div>
			<div class="circle2"></div>
			<div class="circle3"></div>
			<div class="circle4"></div>
		</div>
		<div class="spinner-container container2">
			<div class="circle1"></div>
			<div class="circle2"></div>
			<div class="circle3"></div>
			<div class="circle4"></div>
		</div>
		<div class="spinner-container container3">
			<div class="circle1"></div>
			<div class="circle2"></div>
			<div class="circle3"></div>
			<div class="circle4"></div>
		</div>
	</div>
</div>
</body>
<script>
	$(function() {
		// 设置子导航的height
		$(".nav-son-bj").height($(".nav-son-con div").length * 35 + 5)
	});
</script>
</html>