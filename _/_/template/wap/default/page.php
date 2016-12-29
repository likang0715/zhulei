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
		<title><?php echo $nowPage['page_name'];?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<?php if($is_mobile){ ?>
			<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase.css"/>
			<script type="text/javascript" src="<?php echo TPL_URL;?>js/rem.js"></script>
		<?php }else{ ?>
			<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase_admin.css"/>
		<?php } ?>
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script src="<?php echo STATIC_URL;?>js/jquery.waterfall.js"></script>
		<script src="<?php echo STATIC_URL;?>js/idangerous.swiper.min.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/index.js"></script>

		<script>var dianzan_url = '<?php echo $dianzan_url?>';</script>
<!--  		
		<link href="<?php echo TPL_URL;?>css/new/base.css" rel="stylesheet">
		<link href="<?php echo TPL_URL;?>css/new/index.css" rel="stylesheet">
		<link rel="stylesheet" href="css/swiper.min.css" type="text/css">
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/new/mui.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/new/app.css" />
-->
		
		
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script src="<?php echo TPL_URL;?>js/sku.js"></script>
				<?php if($is_mobile){ ?>
			<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase.css"/>
			<script>var is_mobile = true;</script>
		<?php }else{ ?>
			<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase_admin.css"/>
			<script>var is_mobile = false;</script>
		<?php } ?>
		<script src="<?php echo TPL_URL;?>js/drp_notice.js"></script>

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

		<style>
		.custom-tag-list .custom-tag-list-menu-block .custom-tag-list-side-menu{background:#e6e6e6}

/* 测试样式 */

.top_sidebars { position: relative; overflow: hidden; width: 100%; }
.top_sidebars menu { margin:0;padding:0 ; position: relative; width:100%;background:#fff; border-top: 1px solid #d9d9d9; border-bottom: 2px solid #d9d9d9; height: 1.8rem;}
.top_sidebars menu > span {width:1.5rem;height:1.5rem;position: absolute;right: 0;display:inline-block; background:#fff; z-index:90}
.top_sidebars menu > span i {background: url(<?php echo TPL_URL;?>css/new_images/abc_ic_go_search_api_holo_light.png) ;background-size:0.8rem ;   margin: 0.5rem;width:0.8rem; height:0.8rem;display:inline-block}
/*
.top_sidebars menu > span.active i {background: none ;background-size:0.8rem ; }
*/
.top_sidebars menu .menu_list ul li.active a, menu ul li:hover a{ color:#fa4345 }
.top_sidebars .menu { width:100%; height:100%; background:#fff; top:0; left:0; z-index:89; position:fixed; display:none}
.top_sidebars .menu .menu_titel { width:100%;  border: 1px solid #d9d9d9;}
.top_sidebars .menu .menu_titel span { width:49%; display:inline-block; text-align:center; line-height:1.5rem;}
.top_sidebars .menu .menu_titel span:nth-child(1) { font-size:0.65rem; color:#383838;}
.top_sidebars .menu .menu_titel span:nth-child(2) { font-size:0.6rem; color:#fe5842;}
.top_sidebars .menu ul { font-size:0.7rem;}
.top_sidebars .menu ul li { margin: 0.3rem; padding: 0 0.55rem; border: 1px solid #d9d9d9; border-radius: 0.15rem; float: left; font-size: 0.6rem;}
/* menu TODO */
.top_sidebars menu .menu_list ul { width: 100%; height: 2rem; overflow: hidden; }
.top_sidebars menu .menu_list ul li{ width:3rem;float:left;font-size:0.95rem;color:#4f4f4f;line-height:1.8rem;height:1.8rem;border-bottom:2px solid transparent;margin-bottom:-2px}

.top_sidebars menu .menu_list { overflow:auto; }
.top_sidebars .mui-slider-indicator.mui-segmented-control {position: relative; bottom: auto }
.top_sidebars .mui-segmented-control.mui-segmented-control-inverted {width: 100%; border: 0; border-radius: 0; }
.top_sidebars .mui-slider-indicator {position: absolute; bottom: 8px; width: 100%; text-align: center; background: 0 0 }
.top_sidebars .mui-segmented-control {font-size: 15px; font-weight: 400; position: relative; display: table; overflow: hidden; width: 100%; table-layout: fixed; border: 1px solid #007aff; border-radius: 3px; background-color: transparent; -webkit-touch-callout: none }
.top_sidebars .mui-segmented-control .mui-control-item {font-size:0.7rem;display: inline-block; overflow: hidden; width: 100%; text-align: center; white-space: nowrap; text-overflow: ellipsis; }
.top_sidebars .mui-segmented-control .mui-control-item:first-child {border-left-width: 0 }
.top_sidebars .mui-segmented-control.mui-segmented-control-inverted .mui-control-item {color: inherit; border: 0 }
.top_sidebars .mui-segmented-control.mui-segmented-control-inverted .mui-control-item.mui-active {color: #fa4345; border-bottom: 2px solid #fa4345; background: 0 0 }

/* 测试样式 */
/*.hasFixTop .share-mp-info { padding: 31px 105px 1px 1px; }
.hasFixTop .share-mp-info .links {position: absolute; top: 36px; right: 10px; display: inline-block; }*/
.show_list .show_title { margin: 2px 4px; padding: 0 4px; border-left: 2px solid #fd4d4f; line-height: 19px; font-size: 14px; color: #676767;}
.clearfix:before, .clearfix:after {display: table; content: "";line-height: 0;}
.show_list .show_title span { float: left;}
.show_list .show_title i { float: right;font-size: 13px; color: #eeae28;}
.show_list .show_title i em { background: url(<?php echo TPL_URL;?>css/new_images/time_article.png); vertical-align: middle; margin-top: -4px; margin-right: 4px; background-size: 16px; width: 16px;height: 16px; display: inline-block;}
.clearfix:after { clear: both;}
.clearfix:before, .clearfix:after {display: table; content: ""; line-height: 0;}
.show_list .product_show li { overflow: hidden;margin: 0.5rem 0.5rem 0;/*   padding: 0 0.5rem; */ position: relative;height:8.5rem;
background-position:center;/*  background-size: 100% 100%  */}
.mui-slider .mui-slider-group .mui-slider-item img {/* width: 100%; */}
.show_list .product_show li img {/*width: 100%;*/max-height:8.5rem;border-radius: 0.15rem; vertical-align:middle;}
.show_list .product_show li i { position: absolute; right: 0.8rem; top: 0.8rem; padding: 0 0.25rem; height: 0.9rem; line-height: 0.9rem; color: #fff; font-size: 0.5rem; background: rgba(0,0,0,0.5); border-radius: 0.9rem;display: inline-block;}
.show_list .product_show li i em { background: url(<?php echo TPL_URL;?>css/new_images/ic_small_heart_normal.png); background-size: 0.8rem; width: 0.83rem; height: 0.67rem;display: inline-block;margin: -0.1rem 0.1rem 0 0;vertical-align: middle;}
.show_list .product_show li i.dianzan_selected em {background: url(<?php echo TPL_URL;?>css/new_images/ic_small_heart_selected.png);background-size: 0.82rem;}
.show_list .product_show li p { padding: 0.2rem 0.5rem; font-size: 0.7rem; color: #fff; position: absolute;bottom: 0;  line-height: 1.0rem; text-align: center;width: 14rem;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;background-color: rgba(0,0,0,.5);}
.show_list .product_show li p b { width: 0.75rem; height: 0.75rem;display: inline-block;border: 1px solid #fff; line-height: 0.75rem;font-size: 0.6rem;border-radius: 50%;margin-left: 0.2rem;}
.show_list > li { margin-top: 0.3rem; border-top: 1px solid #e6e6e8;border-bottom: 1px solid #e6e6e8;background: #fff;/*   height:8.5rem; */}
input, img {vertical-align: middle;}


.top_sidebars, .menu div,.menu span,.menu ul,.menu li{-webkit-box-sizing:border-box}
.top_sidebars .menu .menu_titel span{text-align:left}
.top_sidebars .menu ul li{width:25%;float:left;margin:0;padding:0;border:0;}
.top_sidebars .menu ul li .li_class{border:1px solid #d9d9d9;width:87%;text-align:center;display:block; margin: 0.3rem;padding: 0.38rem 0.40rem; border-radius: 0.15rem;text-align:center}
.top_sidebars .menu .menu_titel span{padding:0 0.4rem}
.iss_span {width: 1.5rem;height: 1.5rem; position: absolute; right: 0;display: inline-block;background: #fff;z-index: 90;}
.iss { background: url(<?php echo TPL_URL;?>css/new_images/abc_ic_go_search_api_holo_light.png);background-size: 0.8rem; margin: 0.5rem;width: 0.8rem;height: 0.8rem;display: inline-block;}



</style>

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
								<!-- <li>
								   <a href="<?php echo $now_url;?>&ps=800" class="js-no-follow<?php if($_GET['ps'] == '800') echo ' active';?>">PC版</a>
								</li> -->
							</ul>
						</div>
						<div class="headerbar-reedit">
							<a href="<?php dourl('user:store:wei_page',array(),true);?>#edit/<?php echo $nowPage['page_id']?>" class="js-no-follow">重新编辑</a>
						</div>
					</div>
				</div>
				<?php } ?>
				<!-- ▼顶部通栏 -->
				<?php if($nowPage['show_head']) {?>
				<div class="js-mp-info share-mp-info">
					<a class="page-mp-info" href="<?php echo $now_store['url'];?>">
						<img class="mp-image" width="24" height="24" src="<?php echo $now_store['logo'];?>" alt="<?php echo $now_store['name'];?>"/>
						<i class="mp-nickname"><?php echo $now_store['name'];?></i>
					</a>
					<div class="links">
						<a class="mp-homepage" href="<?php echo $now_store['ucenter_url'];?>">会员中心</a>
					</div>
				</div>
				<?php }?>
				<!-- ▲顶部通栏 -->
			</div>
			<div class="content" <?php if($nowPage['bgcolor']){ ?>style="background-color:<?php echo $nowPage['bgcolor'];?>;"<?php } ?>>
				<div class="content-body">
					<?php if($pageHasAd && $pageAdPosition == 0 && $pageAdFieldCon){ echo $pageAdFieldCon;}?>
					<?php 
						if($homeCustomField){
//							echo "<pre>";
//							print_r($homeCustomField);
							foreach($homeCustomField as $value){
								echo $value['html'];
							}
//							echo '123';
						} 
					?>
					<?php if($pageHasAd && $pageAdPosition == 1 && $pageAdFieldCon){ echo $pageAdFieldCon;}?>
					<!-- test -->
					<!-- <div class="top_sidebars">
						<menu> 
							<span><i></i></span> 
							<div class="menu" style="overflow: hidden; display: none;"> 
								<div class="menu_titel">
									<span>切换频道</span>
									<span>排序或删除</span>
								</div> 
								<ul>
									<li>这是1-1 </li>
									<li>1-2 </li>
								</ul> 
							</div> 
							<div class="mui-slider-indicator mui-segmented-control mui-segmented-control-inverted menu_list" id="sliderSegmentedControl"> 
								<ul class="clearfix"> 
									<li><a hrefs="#item0mobile" href="/wap/subtype.php?id=1&amp;sid=2" class="mui-control-item mui-active">这是1-1</a> </li> 
									<li><a hrefs="#item1mobile" href="/wap/subtype.php?id=1&amp;sid=3" class="mui-control-item">1-2</a> </li> 
								</ul> 
							</div> 
							<div class="mui-slider-progress-bar mui-col-xs-4" id="sliderProgressBar"></div> 
						</menu> 
					</div> -->
					<!-- test -->
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
									<img width="158" height="158" src="<?php echo $config['site_url'];?>/source/qrcode.php?type=page&id=<?php echo $nowPage['page_id'];?>&store_id=<?php echo $now_store['store_id'];?>">
								</p>
							</div>
						</div>
					</div>
				<?php } ?>
				<?php if(!empty($storeNav)){ echo $storeNav;}?>
			</div>
			<?php if($nowPage['show_footer']) {?>
				<?php include display('footer');?>
			<?php }?>
		</div>
		<?php echo $shareData;?>

		<script>




$(function () {
	$(".js-tabber-tags a").click(function () {
		var index = $(".js-tabber-tags a").index($(this));
		$(this).siblings().removeClass("active");
		$(this).addClass("active");

		$(".js-goods-list").hide();
		$(".js-goods-list").eq(index).show();
	});

	//$('.custom-tag-list-side-menu li a').each(function(i){
		$(".custom-tag-list-side-menu li a").click(function(){
			$(".custom-tag-list-side-menu li a").css('background','');
			$(this).css('background','#fff');

		});
	//});
});

$(function(){
	
	$(window).scroll(function () {
		$(".custom-tag-list").each(function(){
			
			var x = $(this).offset().top;
			var scrollTop = $(window).scrollTop();
			var scrollBtm = $(document).height() - $(window).scrollTop() - $(this).height();
			var  height_left = $(this).find('.custom-tag-list-goods').height();
			//var  height_right = ParseInt(height_left)+25;
			$(this).find(".custom-tag-list-menu-block").css("height",height_left)
			//$(this).find(".custom-tag-list-goods").css("height",height_right);
			 if (x < scrollTop) {
				//手机顶部 接触 左侧顶部
				//position: fixed; top: 0px;
				$(this).find(".custom-tag-list-side-menu").css({"position":"fixed","top":"0px"})
				
			 } else {
				 $(this).find(".custom-tag-list-side-menu").css({"position":"relative","top":"0px"})
			 }
			 
			 //该商品分组 位于底部的位置

			 //右侧滚动到底部，左侧一起滚
			
			 var x1 =  x + $(this).find(".custom-tag-list-goods-list").height();
			 if (x1 <= scrollTop) {
				 //position: absolute; bottom: 0px;
				$(this).find(".custom-tag-list-side-menu").css({"position":"absolute","top":"0px"})
			 }
			
		})	
		
	})
			
	
})
	
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
<?php Analytics($now_store['store_id'], 'wei_page', '微页面' . ' - ' . $nowPage['page_name'], $_GET['id']); ?>