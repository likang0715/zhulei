<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>会员概况 - <?php echo $store_session['name']; ?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="description" content="<?php echo $config['seo_description'];?>">
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
        <meta name="renderer" content="webkit">
        <meta name="referrer" content="always">
        <meta name="format-detection" content="telephone=no">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
        <!-- ▼ Base CSS -->
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>css/jquery.ui.css" />
        <!-- ▲ Base CSS -->
        <!-- ▼ Member CSS -->
		<link href="<?php echo TPL_URL;?>css/coupon.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/order.css" type="text/css" rel="stylesheet"/>
        <!-- ▲ Member CSS -->
        <!-- ▼ Constant JS -->
		<script type="text/javascript">
			var load_url="<?php dourl('load');?>";
		</script>
        <!-- ▲ Constant JS -->
        <!-- ▼ Base JS -->
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/echart/echarts.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
        <!-- ▲ Base JS -->
        <!-- ▼ Member JS -->
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/fans_statistic.js"></script>
        <!-- ▲ Member JS -->
		<style type="text/css">
			/* 用户统计-基本概览/会员增减 */
			.ui-nav, .ui-nav2 { border: none; }
			.ui-nav li.active a { font-size: 16px; line-height: 40px; }
			.ui-nav-table li.active a { border-color: #ccc; }

			.dash-bar {background:rgba(255,255,255,1); padding: 10px 20px; zoom: 1; margin-bottom: 20px; }
			.dash-bar {margin-bottom: 12px; padding: 5px 7px 8px 0; }
			.clearfix:before, .clearfix:after {display: table; content: ""; line-height: 0; }
			.dash-bar .dash-todo__body {float: left; padding: 11px 0 10px 0; }
			.dash-bar .info-group {display: inline-block; height: 51px; text-align: center; padding: 0 18px; border-left: 1px dotted #ccc; vertical-align: top; }
			.dash-bar .info-group {padding: 0 32px; }
			.dash-bar .info-group:first-of-type {border-left: none; }
			.dash-bar .info-group__inner {line-height: 1.4; }
			.dash-bar .info-group .h4 {font-size: 20px; display: block; }
			.dash-bar .info-group .h4 {font-size: 22px; }

			.clearfix:after {clear: both; }
			.clearfix:before, .clearfix:after {display: table; content: ""; line-height: 0; }
			.widget {margin-bottom: 15px; }
			.widget .widget-head {position: relative; height: 20px; padding: 10px; padding-bottom: 30px; line-height: 20px; background:rgba(255,255,255,1); } 
			.widget .widget-head .widget-title {display: inline-block; margin: 0 12px 0 0; padding: 0 0 0 10px; font-size: 14px; font-weight: bold; line-height: 20px; }
			.widget .widget-nav {font-size: 12px; display: inline-block; vertical-align: baseline; }
			.widget .widget-head .help {position: absolute; top: 10px; right: 14px; }
			.widget .widget-head .help a {display: inline-block; width: 16px; height: 16px; line-height: 18px; border-radius: 8px; font-size: 12px; text-align: center; background: #D5CD2F; color: #fff; }
			.widget .widget-head .help a:after {content: "?"; }
			.hide {display: none; }

			.widget .widget-body {background:rgba(255,255,255,1); min-height: 150px; padding-bottom: 10px; }
			/*.widget .widget-body .chart-pie-box { width: 33.2%; height: 280px; background: #f7f7f7; float: left; }*/
			.widget .widget-body .chart-pie-box { width: 266px; height: 270px; margin-left: 10px; float: left; }
			.widget .widget-body .chart-pie-box:last-child {  }

			.widget .widget-body .chart-line-box { height: 280px; }

			/* 地图 */
			.widget .chart-map-box { width: 600px; height: 400px; margin: 10px 0 0 10px; float: left; background-color: #f7f7f7; }
			.widget .chart-rank { width: 220px; float: right; }
			.chart-rank .ui-tTable { padding: 10px; }
			.chart-rank .ui-tTable .ui-trTop { padding: 6px 10px; background-color: #f1f1f1; border: 1px solid #e3e3e3; }
			.chart-rank .ui-tTable .ui-trTop .ui-th { width: 58px; float: left; font-size: 14px; font-weight: bold; color: #333; }
			.chart-rank .ui-tTable .ui-tr { padding: 10px; background-color: #fff; border-bottom: 1px solid #e3e3e3; border-left: 1px solid #e3e3e3; border-right: 1px solid #e3e3e3; }
			/*.chart-rank .ui-tTable .ui-tr:nth-of-type(odd) { background-color: #fff; }*/
			.chart-rank .ui-tTable .ui-tr .ui-td { width: 58px; float: left; font-size: 14px; color: #333; text-overflow: ellipsis; }
			.chart-rank .ui-tTable .ui-trTop .ui-th:nth-child(1) { width: 28px; }
			.chart-rank .ui-tTable .ui-tr .ui-td:nth-child(1) { width: 28px; }
			.chart-rank .ui-tTable .ui-trTop .ui-th:nth-child(2) { width: 88px; }
			.chart-rank .ui-tTable .ui-tr .ui-td:nth-child(2) { width: 88px; }

			.ui-block-head { /*background-color: #fff;*/ padding: 10px 0 10px 10px; }
			.ui-block-head .block-title {  padding: 0 10px; }
			.filter-wrap { background-color: #fff; margin-bottom: 12px; }
		</style>
	</head>
	<body class="font14 usercenter">
		<?php include display('public:first_sidebar');?>
		<?php include display('sidebar');?>
		<!-- ▼ Container-->
		<div id="container" class="clearfix container right-sidebar">
			<div id="container-left">
				<!-- ▼ Third Header -->
				<div id="third-header">
				    <ul class="third-header-inner pull-left js-title-list">
						<li class="active">
							<a href="#statistic_basic">基本概览</a>
						</li>
						<li>
							<a href="#statistic_fans">会员增减</a>
						</li>
					</ul>
				</div>
				<!-- ▲ Third Header -->
				<!-- ▼ Container App -->
				<div class="container-app">
					<div class="app-inner clearfix">
						<div class="app-init-container">
							<div class="nav-wrapper--app"></div>
							<div class="app__content"></div>
						</div>
					</div>
				</div>
				<!-- ▲ Container App -->
			</div>
		</div>
		<!-- ▲ Container -->
		<?php include display('public:footer');?>
		<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
	</body>
</html>