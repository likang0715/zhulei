<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8"/> 
	<title>粉丝列表 - <?php echo $store_session['name']; ?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>系统<?php } ?></title>
	<meta name="description" content="<?php echo $config['seo_description'];?>">
	<meta name="copyright" content="<?php echo $config['site_url'];?>"/>
	<meta name="renderer" content="webkit">
	<meta name="referrer" content="always">
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<!-- ▼ Base CSS -->
	<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
	<!-- ▲ Base CSS -->
	<!-- ▼ Store CSS -->
	<link href="<?php echo TPL_URL;?>css/store_ucenter.css" type="text/css" rel="stylesheet"/>
	<link href="<?php echo TPL_URL;?>css/store_wei_page_category.css" type="text/css" rel="stylesheet"/>
	<link href="<?php echo TPL_URL;?>css/order.css" type="text/css" rel="stylesheet"/>
	<!-- ▲ Store CSS -->
	<!-- ▼ Constant JS -->
	<script type="text/javascript">var load_url="<?php dourl('load');?>",page_content = "fans_list";</script>
	<!-- ▲ Constant JS -->
	<!-- ▼ Base JS -->
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
	<!-- ▲ Base JS -->
	<!-- ▼ Store JS -->
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/fans_common.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/fans_list.js"></script>
	<!-- ▲ Store JS -->
	<?php include display('public:custom_header');?>
</head>
<body class="font14 usercenter">
	<?php include display('public:first_sidebar');?>
	<?php if (empty($store_session['drp_supplier_id'])) { ?>
	<?php include display('sidebar');?>
	<?php } ?>
	<!-- ▼ Container-->
	<div id="container" class="clearfix container right-sidebar">
		<div id="container-left">
			<!-- ▼ Third Header -->
			<div id="third-header">
				<ul class="third-header-inner">
					<li class="active">
						<a href="javascript:;">粉丝列表</a>
					</li>
				</ul>
			</div>
			<!-- ▲ Third Header -->
			<!-- ▼ Container App -->
			<div class="container-app" <?php if (!empty($store_session['drp_supplier_id'])) { ?>style="width: 100%;"<?php } ?>>
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="app__content js-app-main">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include display('public:footer');?>
	<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
</body>
</html>