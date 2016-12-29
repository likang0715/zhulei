<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>添加订单 - <?php echo $store_session['name']; ?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
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
        <!-- ▼ Order CSS -->
		<link href="<?php echo TPL_URL;?>css/appmarket.css" type="text/css" rel="stylesheet"/>
        <!-- ▲ Order CSS -->
        <!-- ▼ Constant JS -->
		<script>
		var user_check_url = "<?php echo url('user:order_check_user') ?>";
		var user_search_url = "<?php echo url('user:user_search') ?>";
		var goods_url = "<?php echo url('widget:goods_by_sku') ?>";
		var user_address_url = "<?php echo url('user:user_address') ?>";
		var user_weixinbind_url = "<?php echo url('user:weixin_bind') ?>";
		var order_reward_url = "<?php echo url('order:order_reward') ?>";
		var order_postage_url = "<?php echo url('order:order_postage') ?>";
		var user_weixin_scan_url = "<?php echo url('user:weixin_scan') ?>";
		var user_weixin_login_url = "<?php echo url('user:weixin_login') ?>";
		var add_user_url = "<?php echo url('user:add_user') ?>";
		var credit_setting = <?php echo json_encode($credit_setting) ?>;
		var session_key = "<?php echo $session_key ?>";
		var is_platform_point = <?php echo option('credit.platform_credit_open') ? 'true' : 'false' ?>;
		</script>
		<script type="text/javascript">var load_url="<?php dourl('load');?>";</script>
        <!-- ▲ Constant JS -->
        <!-- ▼ Base JS -->
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
		<script type="text/javascript" src="/static/js/date/WdatePicker.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
        <!-- ▲ Base JS -->
        <!-- ▼ Order JS -->
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/order_add.js"></script>
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
				            <a href="javascript:;">添加订单</a>
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