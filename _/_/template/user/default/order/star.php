<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>加星订单 - <?php echo $store_session['name'];?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
       <meta name="description" content="<?php echo $config['seo_description'];?>">
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
        <meta name="renderer" content="webkit">
        <meta name="referrer" content="always">
        <meta name="format-detection" content="telephone=no">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
        <!-- ▼ Base CSS -->
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
        <link href="<?php echo STATIC_URL;?>css/jquery.ui.css" type="text/css" rel="stylesheet" />
        <!-- ▲ Base CSS -->
        <!-- ▼ Order CSS -->
		<link href="<?php echo TPL_URL;?>css/order.css" type="text/css" rel="stylesheet"/>
        <link href="<?php echo TPL_URL;?>css/order_detail.css" type="text/css" rel="stylesheet"/>
        <!-- ▲ Order CSS -->
        <!-- ▼ Constant JS -->
		<script type="text/javascript">
		var load_url="<?php dourl('load');?>", page_content = "star_content", detail_json_url = "<?php dourl('detail_json'); ?>", image_path = "<?php echo TPL_URL; ?>", save_bak_url = "<?php dourl('save_bak'); ?>", float_amount_url = "<?php dourl('float_amount'); ?>", add_star_url = "<?php dourl('add_star'); ?>", complate_status_url = "<?php dourl('complate_status'); ?>", cancel_status_url = "<?php dourl('cancel_status'); ?>", package_product_url = "<?php dourl('package_product'); ?>", create_package_url = "<?php dourl('create_package'); ?>";
		var receive_time_url = "<?php dourl('receive_time') ?>";
		var create_package_friend_url = "<?php dourl('create_package_friend') ?>";
		</script>
        <!-- ▲ Constant JS -->
        <!-- ▼ Base JS -->
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
        <script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui.js"></script>
        <script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
        <!-- ▲ Base JS -->
        <!-- ▼ Order JS -->
        <script type="text/javascript" src="<?php echo TPL_URL;?>js/order_star.js"></script>
        <script type="text/javascript" src="<?php echo TPL_URL;?>js/order_common.js"></script>
        <!-- ▲ Order JS -->
    </head>
	<body class="font14 usercenter">
		<?php include display('public:first_sidebar');?>
			<?php include display('sidebar');?>
		<!-- ▼ Container-->
		<div id="container" class="clearfix container right-sidebar">
			<div id="container-left">
				<!-- ▼ Third Header -->
				<div id="third-header">
				    <ul class="third-header-inner">
				        <li class="active">
				            <a href="javascript:;">加星订单管理</a>
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
		<?php include display('public:footer');?>
		<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
	</body>
</html>