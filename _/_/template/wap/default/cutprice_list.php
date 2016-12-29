<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
		<title>降价拍</title>
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<link href="<?php echo TPL_URL;?>index_style/cutprice/css/base.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo TPL_URL;?>index_style/cutprice/css/showcase.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo TPL_URL;?>index_style/cutprice/css/auction.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript">
		</script>
	</head>
	<body class=" " style="padding: 0px 0px 46px; overflow: visible; height: auto;">
		<div class="container ">
			<volist name="cutprice_list" id="vo">
			<?php foreach($cutprice_list as $cutprice){?>
			<ul class="js-goods-list sc-goods-list pic clearfix size-2 " data-size="2" data-showtype="card" style="visibility: visible;">
			<li class="js-goods-card goods-card goods-list big-pic card ">
			<a href="/wap/cutprice.php?action=detail&id=<?php echo $cutprice['pigcms_id']?>" class="js-goods link clearfix" data-goods-id="6781004" title="222">
			<div class="photo-block" data-width="1024" data-height="768" style="background-color: rgb(255, 255, 255);">
			<img class="goods-photo js-goods-lazy" data-src="/upload/<?php echo $cutprice['product_info']['image']?>" src="/upload/<?php echo $cutprice['product_info']['image']?>">
			</div>
			<div class="info clearfix info-no-title info-price btn1">
			<p class=" goods-title "><?php echo $cutprice['active_name']?></p>
			<p class="goods-sub-title c-black hide"></p>
			<p class="goods-price">        
			<em>￥<?php echo $cutprice['startprice']?></em>
			</p>
			<p class="goods-price-taobao ">原价：￥<?php echo $cutprice['product_info']['price']?></p>   
			</div>

			</a>
			</li>
			</ul>
			<?php }?>
			<div class="js-navmenu js-footer-auto-ele shop-nav nav-menu nav-menu-1 has-menu-3">
			
			<div class="nav-item" style="width:50%">
			<a class="mainmenu js-mainmenu" href="">
			<span class="mainmenu-txt">全部商品</span>
			</a>
			<!-- 子菜单 -->
			</div>
			<div class="nav-item" style="width:50%">
			<a class="mainmenu js-mainmenu" href="{pigcms::U('Wap/Cutprice/my',array('token'=>$token))}">
			<span class="mainmenu-txt">我的订单</span>
			</a>
			<!-- 子菜单 -->
			</div>
			</div>
		</div>
		<script type="text/javascript">
		window.shareData = {  
			"moduleName":"Cutprice",
			"moduleID":0,
			"imgUrl": "",
			"sendFriendLink": "{pigcms:$f_siteUrl}{pigcms::U('Cutprice/index',array('token'=>$token))}",
			"tTitle": "降价拍",
			"tContent": ""
		};
		</script>
		{pigcms:$shareScript}
	</body>
</html>