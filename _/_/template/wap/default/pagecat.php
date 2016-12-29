<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js admin <?php if($_GET['ps']<=320){echo ' responsive-320';}elseif($_GET['ps']>=540){echo ' responsive-540';} if($_GET['ps']>540){echo ' responsive-800';} ?>" lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<meta name="HandheldFriendly" content="true"/>
		<meta name="MobileOptimized" content="320"/>
		<meta name="format-detection" content="telephone=no"/>
		<meta http-equiv="cleartype" content="on"/>
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title><?php echo $nowCategory['cat_name'];?> - <?php echo $now_store['name'];?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<?php if($is_mobile){ ?>
			<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase.css"/>
		<?php }else{ ?>
			<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase_admin.css"/>
		<?php } ?>
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script src="<?php echo STATIC_URL;?>js/jquery.waterfall.js"></script>
		<script src="<?php echo STATIC_URL;?>js/idangerous.swiper.min.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script src="<?php echo TPL_URL;?>js/sku.js"></script>
		<!-- 活动模块 -->
		<link rel="stylesheet" href="<?php echo TPL_URL;?>/weidian_files/style.css">
		<script src="<?php echo TPL_URL;?>/weidian_files/iscroll.js"></script>
		<script type="text/javascript">
			$(function () {
				$(".scroller").each(function (i) {
					var li = $(this).find("li");
					var liW = li.width() + 18;
					var liLen = li.length;
					$(this).width(liW * liLen);
					
					var class_name = $(this).parent().attr("class");
					new IScroll("." + class_name, { scrollX: true, scrollY: false, mouseWheel: false, click: true });
				});
			});
		</script>
		<!-- 活动模块-->
	</head>
	<body style="padding-bottom:45px;">
		<div class="container">
			<div class="header">
				<?php if(!$is_mobile && $_SESSION['user']){ ?>
				<div class="headerbar">
					<div class="headerbar-wrap clearfix">
						<div class="headerbar-preview">
							<span>预览：</span>
							<ul>
								<li>
								   <a href="<?php echo $now_url;?>&ps=320" class="js-no-follow<?php if(empty($_GET['ps']) || $_GET['ps'] == '320') echo ' active';?>">iPhone版</a>
								</li>
								<li>
								   <a href="<?php echo $now_url;?>&ps=540" class="js-no-follow<?php if($_GET['ps'] == '540') echo ' active';?>">三星Note3版</a>
								</li>
								<li>
								   <a href="<?php echo $now_url;?>&ps=800" class="js-no-follow<?php if($_GET['ps'] == '800') echo ' active';?>">PC版</a>
								</li>
							</ul>
						</div>
						<div class="headerbar-reedit">
							<a href="<?php dourl('user:store:wei_page_category',array(),true);?>#edit/<?php echo $nowCategory['cat_id']?>" class="js-no-follow">重新编辑</a>
						</div>
					</div>
				</div>
				<?php } ?>
				<!-- ▼顶部通栏 -->
				<div class="js-mp-info share-mp-info">
					<a class="page-mp-info" href="<?php echo $now_store['url'];?>">
						<img class="mp-image" width="24" height="24" src="<?php echo $now_store['logo'];?>" alt="<?php echo $now_store['name'];?>"/>
						<i class="mp-nickname"><?php echo $now_store['name'];?></i>
					</a>
					<div class="links">
						<a class="mp-homepage" href="<?php echo $now_store['ucenter_url'];?>">会员中心</a>
					</div>
				</div>
				<!-- ▲顶部通栏 -->
			</div>
			<div class="content">
				<div class="content-body">
					<?php if($pageHasAd && $pageAdPosition == 0 && $pageAdFieldCon){ echo $pageAdFieldCon;}?>
					<div class="custom-title">
						<h2 class="title"><?php echo $nowCategory['cat_name'];?></h2>
					</div>
					<div class="custom-richtext"><?php echo $nowCategory['cat_desc'];?></div>
					<ul class="custom-nav custom-nav-noicon clearfix">
						<?php 
							if($pageList){
								foreach($pageList as $value){
						?>
						<li>
							<a class="clearfix relative arrow-right" href="<?php echo $config['wap_site_url'];?>/page.php?id=<?php echo $value['page_id']?>&store_id=<?php echo $store_id; ?>" target="_blank">
								<span class="custom-nav-title"><?php echo $value['page_name']?></span>
							</a>
						</li>
						<?php 
								}
							}
						?>
					</ul>
					<?php
						if($homeCustomField){
							foreach($homeCustomField as $value){
								echo $value['html'];
							}
						} 
					?>
					<?php if($pageHasAd && $pageAdPosition == 1 && $pageAdFieldCon){ echo $pageAdFieldCon;}?>
				</div>
				<?php if(!$is_mobile){ ?>
					<div class="content-sidebar">
						<a href="<?php echo $now_store['url'];?>" class="link">
							<div class="sidebar-section shop-card">
								<div class="table-cell">
									<img src="<?php echo $now_store['logo'];?>" width="60" height="60" class="shop-img" alt="<?php echo $now_store['name'];?>"/>
								</div>
								<div class="table-cell">
									<p class="shop-name"><?php echo $now_store['name'];?></p>
								</div>
							</div>
						</a>
						<div class="sidebar-section qrcode-info">
							<div class="section-detail">
								<p class="text-center shop-detail"><strong>手机扫码访问</strong></p>
								<p class="text-center weixin-title">微信“扫一扫”分享到朋友圈</p>
								<p class="text-center qr-code">
									<img width="158" height="158" src="<?php echo $config['site_url'];?>/source/qrcode.php?type=page_cat&id=<?php echo $nowCategory['cat_id'];?>">
								</p>
							</div>
						</div>
					</div>
				<?php } ?>
				<?php if(!empty($storeNav)){ echo $storeNav;}?>
			</div>
			<?php include display('footer');?>
		</div>
		<?php echo $shareData;?>
		<script>
	$('.custom-tag-list-side-menu li a').each(function(i){
	$(this).click(function(){
		$('.custom-tag-list-side-menu li a').each(function(){
			$(this).css('background','');
		});
		$('.custom-tag-list-goods').hide();
		$(this).css('background','#fff');
		$('.custom-tag-list-goods').eq(i).show();
	});
});

$('.js-tabber-tags a').each(function(i){
	$(this).click(function(){
		$('.js-tabber-tags a').each(function(){
			$(this).removeClass('active');
		});
		$('.js-goods-list').each(function(){
			$(this).hide();
		});
		$('.js-tabber-tags a').eq(i).addClass('active');
		$('.js-goods-list').eq(i).show();
	});
});

	
	function speed_shop(product_id){
		skuBuy(product_id,1,function(){
		});
	}
	
	$('.js-goods-buy').click(function(){
		return;
		var product_id=$(this).attr('data-id');
		$(this).parents('a').removeAttr('href');
		speed_shop(product_id,1,function(){return;})
	});
		</script>
	</body>
</html>
<?php Analytics($_GET['id'], 'wei_page_category', '微页面分类' . ' - ' . $nowCategory['cat_name'], $_GET['id']); ?>