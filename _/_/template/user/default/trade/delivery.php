<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8"/> 
	<title>会员等级 - <?php echo $store_session['name']; ?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
	<meta name="description" content="<?php echo $config['seo_description'];?>">
	<meta name="copyright" content="<?php echo $config['site_url'];?>"/>
	<meta name="renderer" content="webkit">
	<meta name="referrer" content="always">
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<!-- ▼ Base CSS -->
	<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
	<link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>css/jquery.ui.css" />
	<link href="<?php echo TPL_URL;?>css/freight.css" type="text/css" rel="stylesheet"/>
	<!-- ▲ Base CSS -->
	<!-- ▼ Member CSS -->
	<link href="<?php echo TPL_URL;?>css/coupon.css" type="text/css" rel="stylesheet"/>
	<!-- ▲ Member CSS -->
	<!-- ▼ Constant JS -->
	<script type="text/javascript">var load_url="<?php dourl('delivery_load');?>",add_url="<?php dourl('delivery_modify');?>",delete_url="<?php dourl('delivery_delete');?>",copy_url="<?php dourl('delivery_copy');?>",edit_url="<?php dourl('delivery_amend');?>";</script>
	<!-- ▲ Constant JS -->
	<!-- ▼ Base JS -->
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
	<!-- ▲ Base JS -->
	<!-- ▼ Member JS -->
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/delivery.js"></script>
	<!-- ▲ Member JS -->
</head>
<body class="font14 usercenter">
	<?php include display('public:first_sidebar');?>
	<?php include display('order:sidebar');?>
	<!-- ▼ Container-->
	<div id="container" class="clearfix container right-sidebar">
		<div id="container-left">
			<!-- ▼ Third Header -->
			<div id="third-header">
				<ul class="third-header-inner pull-left js-title-list">
					<li>
						<a href="javascript:;">运费模板</a>
					</li>
				</ul>
			</div>
			<!-- ▲ Third Header -->
			<!-- ▼ Container App -->
			<div class="container-app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="app__content freight-wrap"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include display('public:footer');?>
	<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
</body>
</html>