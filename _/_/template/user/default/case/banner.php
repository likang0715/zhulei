<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>店铺横幅广告管理 - <?php echo $store_session['name'];?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/customField.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/store_ucenter.css" type="text/css" rel="stylesheet"/>
        <link href="<?php echo TPL_URL;?>css/custom_page.css" type="text/css" rel="stylesheet"/>
		
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
		
		<?php include display('public:global_header');?>
		<?php include display('public:custom_header');?>
		
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript">
			var is_sync_user = "<?php echo $_SESSION['sync_store'];?>";
			var load_url="<?php dourl('case_load');?>";
		</script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/case_banner.js"></script>
    </head>
	<body class="font14 usercenter">
		<?php include display('public:header');?>
		<div class="wrap_1000 clearfix container">
			<?php include display('sidebar');?>
			<div class="app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="nav-wrapper--app"></div>
						<div class="app__content js-app-main"></div>
					</div>
				</div>
			</div>
		</div>
		<?php include display('public:footer');?>
		<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
	</body>
</html>
