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
		<title><?php echo $now_store['name'];?></title>
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no,minimal-ui">
		<meta name="format-detection" content="telephone=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<?php if($is_mobile){ ?>
			<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase.css"/>
		<?php }else{ ?>
			<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase_admin.css"/>
		<?php } ?>
		<script type="text/javascript">var storeId=<?php echo $now_store['store_id'];?>, dianzan_url = '<?php echo $dianzan_url?>',is_logistics = <?php echo $now_store['open_logistics'] ? 'true' : 'false' ?>,is_selffetch = <?php echo $now_store['buyer_selffetch'] ? 'true' : 'false' ?></script>
        <link rel="stylesheet" href="<?php echo TPL_URL;?>/css/drp_notice.css" />
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script src="<?php echo STATIC_URL;?>js/jquery.waterfall.js"></script>
		<script src="<?php echo STATIC_URL;?>js/idangerous.swiper.min.js"></script>
		<!--<script src="<?php echo TPL_URL;?>theme/js/swiper.min.js"></script>-->
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script src="<?php echo TPL_URL?>js/display_subject_display.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/index.js"></script>
		<script src="<?php echo TPL_URL;?>js/sku.js"></script>
		<script src="<?php echo TPL_URL;?>js/drp_notice.js"></script>
		<script type="text/javascript">
			var create_fans_supplier_store_url="<?php echo $config['site_url'] ?>/wap/create_fans_supplier_store.php";
			var uid="<?php echo $_GET['uid']?>";
			var store_id="<?php echo $_GET['id']?>";
		</script>		

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
					new IScroll("." + class_name, { scrollX: true, scrollY: false, mouseWheel: true, click: true });
				});
			});
		</script>
		<!-- 活动模块-->

		<style>
			body{ font-family:"Microsoft YaHei";-webkit-tap-highlight-color:rgba(0,0,0,0);}
			.custom-tag-list .custom-tag-list-menu-block .custom-tag-list-side-menu{background:#e6e6e6}
			/* 测试样式 */
			.top_sidebars { position: relative; overflow: hidden; width: 100%; }
			.top_sidebars menu { margin:0;padding:0 ; position: relative; width:100%;background:#fff; border-top: 1px solid #d9d9d9; border-bottom: 2px solid #d9d9d9; height: 1.8rem;}
			.top_sidebars menu > span {width:1.5rem;height:1.5rem;position: absolute;right: 0;display:inline-block; background:#fff; z-index:90}
			.top_sidebars menu > span i {background: url(<?php echo TPL_URL;?>css/new_images/abc_ic_go_search_api_holo_light.png) ;background-size:0.8rem ;   margin: 0.5rem;width:0.8rem; height:0.8rem;display:inline-block}
			/*.top_sidebars menu > span.active i {background: none ;background-size:0.8rem ; }*/
			.top_sidebars menu .menu_list ul li.active a, menu ul li:hover a{ color:#fa4345 }
			.top_sidebars .menu { width:100%; height:100%; background:#fff; top:0; left:0; z-index:89; position:fixed; display:none}
			.top_sidebars .menu .menu_titel { width:100%;  border: 1px solid #d9d9d9;}
			.top_sidebars .menu .menu_titel span { width:49%; display:inline-block; text-align:center; line-height:1.5rem;}
			.top_sidebars .menu .menu_titel span:nth-child(1) { font-size:14px; color:#383838;}
			.top_sidebars .menu .menu_titel span:nth-child(2) { font-size:14px; color:#fe5842;}
			.top_sidebars .menu ul { font-size:0.7rem;}
			.top_sidebars .menu ul li { margin: 0.3rem; padding: 0 0.55rem; border: 1px solid #d9d9d9; border-radius: 0.15rem; float: left; font-size: 0.6rem;}
			/* menu TODO */
			.top_sidebars menu .menu_list ul { width: 100%; height: 2rem; overflow: hidden; }
			.top_sidebars menu .menu_list ul li{ width:3rem;float:left;font-size:0.95rem;color:#4f4f4f;line-height:1.8rem;height:1.8rem;border-bottom:2px solid transparent;margin-bottom:-2px;padding:0px 0.2rem 0px 0px}
			.top_sidebars menu .menu_list { overflow:auto; }
			.top_sidebars .mui-slider-indicator.mui-segmented-control {position: relative; bottom: auto }
			.top_sidebars .mui-segmented-control.mui-segmented-control-inverted {width: 100%; border: 0; border-radius: 0; }
			.top_sidebars .mui-slider-indicator {position: absolute; bottom: 8px; width: 100%; text-align: center; background: 0 0 }
			.top_sidebars .mui-segmented-control {font-size: 15px; font-weight: 400; position: relative; display: table; overflow: hidden; width: 100%; table-layout: fixed; border: 1px solid #007aff; border-radius: 3px; background-color: transparent; -webkit-touch-callout: none }
			.top_sidebars .mui-segmented-control .mui-control-item {display: inline-block; overflow: hidden; width: 100%; text-align: center; white-space: nowrap; text-overflow: ellipsis; }
			.top_sidebars .mui-segmented-control .mui-control-item:first-child {border-left-width: 0 }
			.top_sidebars .mui-segmented-control.mui-segmented-control-inverted .mui-control-item {color: inherit; border: 0 }
			.top_sidebars .mui-segmented-control.mui-segmented-control-inverted .mui-control-item.mui-active {color: #fa4345; border-bottom: 2px solid #fa4345; background: 0 0 }
			/* 测试样式 */
			/*.hasFixTop .share-mp-info { padding: 31px 105px 1px 1px; }
			.hasFixTop .share-mp-info .links {position: absolute; top: 36px; right: 10px; display: inline-block; }*/
			.show_list .show_title {margin: 2px 4px;padding: 0 4px;border-left: 2px solid #fd4d4f;line-height: 19px;font-size: 13px;color: #676767;margin-top: 8px;}
			.clearfix:before, .clearfix:after {display: table;content: "";line-height: 0;}
			.show_list .show_title span {float: left;}
			.show_list .show_title i {float: right;font-size: 13px;color: #eeae28;}
			.show_list .show_title i em {background: url(<?php echo TPL_URL;?>css/new_images/time_article.png);vertical-align: middle;margin-top: -4px;margin-right: 4px;background-size: 16px;width: 16px;height: 16px;display: inline-block;}
			.clearfix:after {clear: both;}
			.clearfix:before, .clearfix:after {display: table;content: "";line-height: 0;}
			.show_list .product_show li {margin: 0.5rem 0.5rem 0; position: relative;background-position:center;border-radius:  .3rem;max-height:200px;overflow:hidden;/*  background-size: 100% 100%  */}
			.mui-slider .mui-slider-group .mui-slider-item img {/* width: 100%; */}
			.show_list .product_show li img {width: 100%; border-radius:  .3rem;vertical-align:middle;}
			.show_list .product_show li i {position: absolute;right: 0.8rem;top: 0.8rem;padding: 0 0.25rem;height: 1.2rem;line-height: 1.2rem;color: #fff;font-size: 0.8rem;background: rgba(0,0,0,0.5);border-radius: 0.9rem;display: inline-block;min-width: 3rem;}
			.show_list .product_show li i em { background: url(<?php echo TPL_URL;?>css/new_images/ic_small_heart_normal.png);background-size: 1rem; width: 1rem; height: 1rem; display: inline-block;margin: -0.05rem 0.1rem 0 0;vertical-align: middle;background-repeat:no-repeat;}
			.show_list .product_show li i.dianzan_selected em {  background: url(<?php echo TPL_URL;?>css/new_images/ic_small_heart_selected.png); background-size: 1rem; background-repeat:no-repeat;}
			.show_list .product_show li p { padding:10% 0.5rem 0.5rem 0.5rem; font-size: 0.7rem; color: #fff; position: absolute; bottom: 0; line-height: 1.0rem; text-align: center; width: 14rem; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;  background: -moz-linear-gradient(top, rgba(0,0,0,0) 0%, rgba(0,0,0,0) 3%, rgba(0,0,0,0.65) 97%, rgba(0,0,0,0.65) 100%);background: -webkit-linear-gradient(top, rgba(0,0,0,0) 0%,rgba(0,0,0,0) 3%,rgba(0,0,0,0.65) 97%,rgba(0,0,0,0.65) 100%); background: linear-gradient(to bottom, rgba(0,0,0,0) 0%,rgba(0,0,0,0) 3%,rgba(0,0,0,0.65) 97%,rgba(0,0,0,0.65) 100%);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00000000', endColorstr='#a6000000',GradientType=0 );}
			.show_list .product_show li p b { width: 0.75rem; height: 0.75rem; display: inline-block; border: 1px solid #fff;line-height: 0.75rem;font-size: 0.6rem;border-radius: 50%; margin-left: 0.2rem;}
			.show_list > li {margin-top: 0.3rem;border-top: 10px solid #e6e6e8; background: #fff;/*   height:8.5rem; */}
			input, img {vertical-align: middle;}
			.top_sidebars menu .menu_list ul li{width:3.15rem}
			.top_sidebars, .menu div,.menu span,.menu ul,.menu li{-webkit-box-sizing:border-box}
			.top_sidebars .menu .menu_titel span{text-align:left}
			.top_sidebars .menu ul li{width:25%;float:left;margin:0;padding:0;border:0;}
			.top_sidebars .menu ul li .li_class{ font-size:14px;border:1px solid #d9d9d9;width:85%;display:block; margin: 0.3rem;padding: 0.4rem 0.55rem; border-radius: 0.15rem;text-align:center}
			.top_sidebars .menu .menu_titel span{padding:0 0.4rem}
			.iss_span {width: 1.5rem;height: 1.5rem; position: absolute; right: 0;display: inline-block;background: #fff;z-index: 90;}
			.iss { background: url(<?php echo TPL_URL;?>css/new_images/abc_ic_go_search_api_holo_light.png);background-size: 0.8rem; margin: 0.5rem;width: 0.8rem;height: 0.8rem;display: inline-block;}
			.subject_display_div{ margin-top:-7px;}
			.nickname { color: #26CB40; }
			.limit-buy { color: red; }

			/* 店铺订单消息提示 */
			.orderLayer { position: fixed; left: 10px; margin-left: 0; top: 60px; line-height: 1.2rem; background: rgba(0,0,0,.4); padding: 5px; z-index: 7; width: 90%; color: #fff; font-size: .55rem; border-radius: 1.5rem; }
			.orderLayer .orderImg { display: inline-block; vertical-align: middle; overflow: hidden; }
			.orderLayer .orderImg img { vertical-align: top; width: 32px; height: 32px; border-radius: 50% }
			.orderLayer .orderInfo { display: inline-block; vertical-align: middle; margin-left: 5px; width:87% }
			.orderLayer .orderInfo i { color:#FF9E40; width: 60px; display: inline-block; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; vertical-align: middle; margin-top: -.1rem; }
			.orderLayer .orderInfo span { display:inline-block; margin-left:16px; float: right; }
		</style>
		<?php if (empty($drp_button)) { ?>
		<style type="text/css">
			#drp-notice ul .msg-li {
				margin-left: 5px;
				width: 75%;
			}
		</style>
		<?php } ?>

		<?php if($is_mobile){ ?>
			<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase.css"/>
			<script type="text/javascript">var is_mobile = true;</script>
		<?php }else{ ?>
			<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase_admin.css"/>
			<script type="text/javascript">var is_mobile = false;</script>
		<?php } ?>
</head>

	<body <?php if(!empty($storeNav)){ ?>style="padding-bottom:45px;"<?php } ?>>
        <?php if ($allow_drp) { ?>
        <div id="drp-notice">
            <ul>
                <li class="img-li"><img class="mp-image" width="24" height="24" src="<?php echo !empty($avatar) ? $avatar : option('config.site_url') . '/static/images/avatar.png'; ?>" /></li>
                <li class="msg-li"><?php echo $msg; ?></li>
				<?php if (!empty($drp_button)) { ?>
                <li class="btn-li"><a href="<?php echo $drp_register_url; ?>" class="button green"><?php echo $drp_button; ?></a></li>
				<?php } ?>
				<li class="last-li"><b class="close"></b></li>
            </ul>
        </div>
        <?php } ?>
		<div class="container">
            <?php if (!empty($now_store['drp_approve'])) { ?>
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
								<?php
								if (option('config.synthesize_store')) {
								?>
								<!-- <li>
								   <a href="<?php echo $now_url;?>&ps=800" class="js-no-follow<?php if($_GET['ps'] == '800') echo ' active';?>">PC版</a>
								</li> -->
								<?php
								}
								?>
							</ul>
						</div>
						<div class="headerbar-reedit">
							<a href="<?php dourl('user:store:wei_page',array(),true);?>#edit/<?php echo $homePage['page_id']?>" class="js-no-follow">重新编辑</a>
						</div>
					</div>
				</div>
				<?php } ?>
				
				<?php if($homePage['show_head']) {?>
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
				<?php }?>
				
			</div>
			<div class="content" <?php if($homePage['bgcolor']){ ?>style="background-color:<?php echo $homePage['bgcolor'];?>;"<?php } ?>>
				<div class="content-body">
					<?php if($pageHasAd && $pageAdPosition == 0 && $pageAdFieldCon){ echo $pageAdFieldCon;}?>
					<?php foreach($homeCustomField as $value){echo $value['html'];} ?>
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
									<img width="158" height="158" src="<?php echo $config['site_url'];?>/source/qrcode.php?type=home&id=<?php echo $now_store['store_id'];?>">
								</p>
							</div>
						</div>
					</div>
				<?php } ?>
				<?php if(!empty($storeNav)){ echo $storeNav;}?>
			</div>
            <?php } else { ?>
            <div class="header">
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
            
            <div class="approve content">
                <div class="content-body" style="color: red;text-align: center">您访问的店铺正在审核中...</div>
            </div>
            <?php } ?>
            <?php if($homePage['show_footer']) {?>
				<?php include display('footer');?>
			<?php }?>

			<?php if($config['is_show_float_menu'] && $now_store['is_show_float_menu']) {?>
			<div class="wx_aside" id="quckArea"> <a href="javascript:void(0);" id="quckIco2" class="btn_more">更多</a>
				<div class="wx_aside_item" id="quckMenu"> <a href="./index.php" class="item_index">首页</a> <a href="./category.php" class="item_fav">商品分类</a> <a href="./weidian.php" class="item_cart">微店列表</a> <a href="./my.php" class="item_uc">个人中心</a> </div>
			</div>
			<?php } ?>
		</div>

		<!-- 店铺订单消息通知 -->
		<script type="text/javascript" src="<?php echo TPL_URL; ?>js/store_notice.js"></script>
		<?php if ($is_mobile && $now_store['order_notice_open']) { ?>
		<script type="text/javascript">
		$(function(){
			$('body').shopNotice({storeId:"<?php echo $store_id; ?>",fadeoutTime:"<?php echo $now_store['order_notice_time']; ?>"});
		});
		</script>
		<?php } ?>
		
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
		</script>
	</body>
</html>
<?php Analytics($_GET['id'], 'home', $homePage['page_name'], $_GET['id']); ?>
