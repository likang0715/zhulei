
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0035)http://dd2.pigcms.com/wap/index.php -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<meta name="format-detection" content="email=no">
<meta name="apple-mobile-web-app-title" content="小猪cms">
<title><?php echo $config['seo_title'];?></title>
<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
<meta name="description" content="<?php echo $config['seo_description'];?>" />
<link href="favicon.ico"  rel="icon" />
<link rel="stylesheet" href="<?php echo TPL_URL;?>css/style.css" type="text/css">
<link rel="stylesheet" href="<?php echo TPL_URL;?>css/swiper.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo TPL_URL;?>css/index.css" type="text/css">
<link rel="stylesheet" href="<?php echo TPL_URL;?>theme/css/gonggong.css"  type="text/css">
<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
<script src="<?php echo TPL_URL;?>theme/js/swiper.min.js"></script>
<script src="<?php echo TPL_URL;?>js/common.js"></script>

<script async="" src="<?php echo TPL_URL;?>theme/js/mobile-common.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/app-m-main-common.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/mobile-download-banner.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/m-performance.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/-mod-wepp-module-event-0.2.1-wepp-module-event.js,-mod-wepp-module-overlay-0.3.0-wepp-module-overlay.js,-mod-wepp-module-toast-0.3.0-wepp-module-toast.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/mobile-common-search.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/-mod-hippo-1.2.8-hippo.js,-mod-cookie-0.2.0-cookie.js,-mod-cookie-0.1.2-cookie.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/app-m-dianping-index.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/nugget-mobile.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/swipe.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/openapp.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/app-m-style.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/util-m-monitor.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/xss.js"></script> 
<script async="" src="<?php echo TPL_URL;?>theme/js/whereami.js"></script>
<script async="" src="<?php echo TPL_URL;?>theme/js/index.js"></script>
<script async="" src="<?php echo TPL_URL;?>theme/js/iscroll.js"></script>
<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer_mobile/layer.m.js"></script>
<script type="text/javascript" src="js/example.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/bmap.css">

</head>

<body youdao="bind" cz-shortcut-listen="true">
	<!--
	<div class="areaBox">
		<div class="areaInput">
			<input placeholder="输入城市名或拼音查询" type="text"/>
		</div>
	</div>
	-->
	<div class="mapThere">
		<style>
			.iw_poi_title {color:#CC5522;font-size:14px;font-weight:bold;overflow:hidden;padding-right:13px;white-space:nowrap}
			.iw_poi_content {font:12px arial,sans-serif;overflow:visible;padding-top:4px;white-space:-moz-pre-wrap;word-wrap:break-word}
		</style>
		
		<div  style="height: 600px">
			<div class="controls address_map">
				<input type="hidden" class="span6 js-address-input" name="map_long" id="map_long" value="<?php echo $store_contact['long']?>"/>
				<input type="hidden" class="span6 js-address-input" name="map_lat" id="map_lat" value="<?php echo $store_contact['lat']?>"/>
				<div class="shop-map-container" style="height: 600px">
					<div class="left hide">
						<ul class="place-list js-place-list"></ul>
					</div>
					<div class="map js-map-container large" id="cmmap" style="height:100%"></div>
					<button type="button" class="ui-btn select-place js-select-place" style="position:absolute;top:10px;right:10px;">点击地图标注位置</button>
				</div>
			</div>	
		</div>
		
	
		
	</div>

			<script>
			static_url="<?php echo TPL_URL;?>";
			$.getScript(static_url+'js/bdmap.js');
			</script>		
</body>
</html>