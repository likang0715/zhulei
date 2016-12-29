<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8"/> 
	<title>茶会管理 - <?php echo $store_session['name']; ?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
	<meta name="description" content="<?php echo $config['seo_description'];?>">
	<meta name="copyright" content="<?php echo $config['site_url'];?>"/>
	<meta name="renderer" content="webkit">
	<meta name="referrer" content="always">
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<!-- ▼ Base CSS -->
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo STATIC_URL;?>css/jquery.ui.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo STATIC_URL;?>js/ueditor/themes/default/css/ueditor.css" type="text/css"/>
	<!-- ▲ Base CSS -->
	<!-- ▼ Order CSS -->
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/freight.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/hint.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo STATIC_URL;?>js/ueditor/third-party/codemirror/codemirror.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/events.css" type="text/css"/>
	<!-- ▲ Order CSS -->
	<!-- ▼ Constant JS -->
	<script type="text/javascript">var load_url="<?php  dourl('events:load');?>", store_name_check_url = "<?php dourl('store_name_check'); ?>",store_setting_url="<?php dourl('store'); ?>",events_add_url="<?php dourl('physical_add'); ?>",events_edit_url="<?php dourl('physical_edit'); ?>",events_del_url="<?php dourl('physical_del'); ?>",static_url="<?php echo TPL_URL;?>";</script>
	<!-- ▲ Constant JS -->
	<!-- ▼ Base JS -->
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui-timepicker-addon.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/ueditor/ueditor.config.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/ueditor/ueditor.all.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/ueditor/lang/zh-cn/zh-cn.js" defer="defer"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/ueditor/third-party/codemirror/codemirror.js" defer="defer"></script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
	<!-- ▲ Base JS -->
	<!-- ▼ Order JS -->
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/events.js"></script>
	<!-- ▲ Order JS --> 
	<!-- 茶会编辑页面JS -->	
	<script type="text/javascript" src="./js/meaz.js"></script>
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
						<a href="javascript:;">茶会列表</a>
					</li>
				</ul>
			</div>
			<!-- ▲ Third Header -->
			<!-- ▼ Container App -->
			<div class="container-app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="app__content">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include display('public:footer');?>
</body>
</html>