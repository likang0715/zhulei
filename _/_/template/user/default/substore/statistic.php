<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>门店销售统计 - <?php echo $store_session['name']; ?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
    <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
	<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
	<link href="<?php echo STATIC_URL;?>css/jquery.ui.css" type="text/css" rel="stylesheet" />
	<link href="<?php echo TPL_URL;?>css/order.css" type="text/css" rel="stylesheet"/>
	<link href="<?php echo TPL_URL;?>css/freight.css" type="text/css" rel="stylesheet"/>
	<link href="<?php echo TPL_URL;?>css/store.css" type="text/css" rel="stylesheet"/>
	<link href="<?php echo TPL_URL;?>css/setting_store.css" type="text/css" rel="stylesheet"/>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/echart/echarts.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui-timepicker-addon.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
	<script type="text/javascript">
	var load_url = "<?php dourl('load') ?>";
	</script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/substore_statistic.js"></script>
	<style type="text/css">
	.filter-wrap { background: #fff; }
	</style>
</head>
<body class="font14 usercenter">
<?php include display('public:header');?>
<div class="wrap_1000 clearfix container">
	<?php include display('substore:sidebar');?>
	<div class="app">
		<div class="app-inner clearfix">
			<div class="app-init-container">
				<div class="ui-nav dianpu">
					<ul>
						<li class="js-app-nav line">
							<a href="#line">销售走势</a>
						</li>
						<li class="js-app-nav percent">
							<a href="#percent">销售百分比</a>
						</li>
					</ul>
				</div>
				<div class="nav-wrapper--app"></div>
				<div class="app__content"></div>
			</div>
		</div>
	</div>
</div>
<?php include display('public:footer');?>
<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
</body>
</html>