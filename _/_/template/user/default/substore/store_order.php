<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>门店订单 - <?php echo $store_session['name'];?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
        <link href="<?php echo STATIC_URL;?>css/jquery.ui.css" type="text/css" rel="stylesheet" />
		<link href="<?php echo TPL_URL;?>css/order.css" type="text/css" rel="stylesheet"/>
        <link href="<?php echo TPL_URL;?>css/order_detail.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
        <script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui.js"></script>
        <script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript">
			var load_url="<?php dourl('order:load');?>", 
			save_bak_url = "<?php dourl('order:save_bak'); ?>", 
			image_path = "<?php echo TPL_URL; ?>", 
			add_star_url = "<?php dourl('order:add_star'); ?>", 
			cancel_status_url = "<?php dourl('order:cancel_status'); ?>", 
			complate_status_url = "<?php dourl('order:complate_status'); ?>", 
			detail_json_url = "<?php dourl('order:detail_json'); ?>", 
			float_amount_url = "<?php dourl('order:float_amount'); ?>", 
			page_content = "physical_order_content", 
			package_product_url = "<?php dourl('order:package_product'); ?>", 
			create_package_url = "<?php dourl('order:create_package'); ?>", 
			package_assign_url = "<?php dourl('order:package_product_physical'); ?>", 
			package_product_phy_url = "<?php dourl('order:package_product_phy'); ?>", 
			create_package_phy_url = "<?php dourl('order:create_package_phy'); ?>", 
			package_assign_save_url = "<?php dourl('order:product_physical_save'); ?>",
			order_download_url="<?php dourl('order:order_download_csv');?>";
		</script>
        <script type="text/javascript" src="<?php echo TPL_URL;?>js/order_common.js"></script>
        <script type="text/javascript" src="<?php echo TPL_URL;?>js/order_physical.js"></script>
	</head>
	<body class="font14 usercenter">
		<?php include display('public:header');?>
		<div class="wrap_1000 clearfix container">
			<?php include display('sidebar');?>
			<div class="app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
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