<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>拼团 - <?php echo $store_session['name']; ?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
		<meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/appmarket.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/wx_sidebar.css" type="text/css" rel="stylesheet"/>
		<link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>css/jquery.ui.css" />
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
		<!--script type="text/javascript" src="<?php echo STATIC_URL;?>js/echart/echarts.js"></script-->
		<script type="text/javascript" src="/static/js/date/WdatePicker.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.validate.js"></script>
		<script type="text/javascript" src="/static/js/date/WdatePicker.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		
		<script type="text/javascript">
			var index_url = "<?php echo dourl('tuan:tuan_index') ?>";
			var load_url = "<?php dourl('load');?>";
			var order_load_url = "<?php dourl('order:load') ?>";
			var tuan_list_url = "<?php dourl('tuan:tuan_list') ?>";
			var package_product_url = "<?php dourl('order:package_product') ?>";
			var create_package_url = "<?php dourl('order:create_package') ?>";
			var complate_status_url = "<?php dourl('order:complate_status') ?>";
			var tuan_disabled_url = "<?php dourl('tuan:disabled') ?>";
			var tuan_add_url = "<?php dourl('tuan:add') ?>";
			var tuan_edit_url = "<?php dourl('tuan:edit') ?>";
			var tuan_delete_url = "<?php dourl('tuan:delete') ?>";
			var tuan_over_url = "<?php dourl('tuan:over') ?>";
			var tuan_wap_url = "<?php echo option('config.site_url') ?>/webapp/groupbuy/#/";
			var tuan_qrcode_url = "<?php echo option("config.site_url") ?>/source/qrcode.php?type=";
		</script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/tuan.js"></script>
	</head>
	<body class="font14 usercenter">
		<?php include display('public:header');?>
		<div class="wrap_1000 clearfix container">
			<?php include display('public:yx_sidebar');?>
			<div class="app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="clearfix"></div>
						<!-- ▼ Main container -->
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