<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title><?php echo $store['name']; ?> - 我的店铺</title>
		<meta name="format-detection" content="telephone=no"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"  />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="default" />
		<meta name="applicable-device" content="mobile"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>index_style/css/my.css"/>
		<script src="<?php echo STATIC_URL;?>js/fastclick.js"></script>
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script src="<?php echo TPL_URL;?>index_style/js/base.js"></script>
		<style type="text/css">
			.userMoreInfo{text-align:right}
			.my-store > a:before {
				content: normal;
				display: block;
			}
		</style>
	</head>
	<body style="padding-bottom:70px;">
		<div class="wx_wrap">
			
			<div class="my_head">
				<div class="userAvatr">
					<div class="avatarImg">
						<img src="<?php echo $store['logo']; ?>" />
					</div>
					<div class="userDesc"><?php echo $store['name']; ?></div>
				</div>
				<div class="userMoreInfo">
					<ul>
						<li>店铺<?php echo $point_alias; ?><a href="my_point.php?action=store_point&store_id=<?php echo $store['store_id']; ?>"><em><?php echo $store['point_balance']; ?></em></a></li>
						<li>充值现金<a href="my_margin.php?action=index&store_id=<?php echo $store['store_id']; ?>"><em><?php echo $store['margin_balance']; ?></em></a></li>
						<li><a href="./home.php?id=<?php echo $store['store_id']; ?>">访问店铺<em><i class="rightArrow">&nbsp;&nbsp;&nbsp;</i></em></a></li>
					</ul>
				</div>
			</div>


			<!-- S 入口菜单 -->
			<div class="my_menu">
				<ul>
					<li class="tiao">
						<a href="./order.php?id=<?php echo $store['store_id']; ?>" class="menu_1">全部订单</a>
					</li>
					<li class="tiao">
						<a href="./order.php?id=<?php echo $store['store_id']; ?>&action=unpay" class="menu_2">待付款</a>
					</li>
					<li class="tiao">
						<a href="./order.php?id=<?php echo $store['store_id']; ?>&action=unsend" class="menu_4">待发货</a>
					</li>
					<li class="tiao">
						<a href="./order.php?id=<?php echo $store['store_id']; ?>&action=send" class="menu_3">已发货</a>
					</li>

				</ul>
			</div>
			<!-- E 入口菜单 -->

			<!-- S 入口列表 -->
			<ul class="my_list"> 
				<li class="tiao"><a href="my_offline.php?store_id=<?php echo $store['store_id'] ?>">线下做单</a></li>
				<li class="tiao"><a href="my_offline_list.php?store_id=<?php echo $store['store_id'] ?>">线下做单管理</a></li>
				<li class="hr"></li>
				<li class="tiao"><a href="./my_point.php?action=exchange&store_id=<?php echo $store['store_id']; ?>"><?php echo $point_alias; ?>转移</a></li>
			</ul>
			<!-- E 入口列表 -->
			<!--div class="my_links">
				<a href="tel:4006560011" class="link_tel">致电客服</a>
				<a href="#" class="link_online">在线客服</a>
			</div-->
		</div>
		<div class="wx_nav">
			<a href="./index.php" class="nav_index">首页</a>
			<a href="./category.php" class="nav_search">分类</a>
			<a href="./weidian.php" class="nav_shopcart">店铺</a>
			<a href="./my.php" class="nav_me on">个人中心</a></div>
		<?php echo $shareData;?>
	</body>
</html>