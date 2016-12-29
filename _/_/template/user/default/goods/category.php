<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>商品分组	- <?php echo $store_session['name'];?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
		<meta name="description" content="<?php echo $config['seo_description'];?>">
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
        <meta name="renderer" content="webkit">
        <meta name="referrer" content="always">
        <meta name="format-detection" content="telephone=no">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
        <!-- ▼ Base CSS -->
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="./template/user/default/css/store_ucenter.css" type="text/css" rel="stylesheet"/>
        <!-- ▲ Base CSS -->
        <!-- ▼ Goods CSS -->
		<link href="<?php echo TPL_URL;?>css/customField.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/store_wei_page_category.css" type="text/css" rel="stylesheet"/>
        <!-- ▲ Goods CSS -->
        <!-- ▼ Base JS -->
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/ueditor/ueditor.config.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/ueditor/ueditor.all.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
        <!-- ▲ Base JS -->
        <!-- ▼ Constant JS -->
		<script>
			var siteurl = "<?php echo option('config.site_url');?>";
				<?php if($_SESSION['user']['admin_id']) {?>
					var is_adminuser = 1;
				<?php }else {?>
					var is_adminuser = 0;
				<?php }?>
		</script>
		<script type="text/javascript">var is_sync_user = "<?php echo $_SESSION['sync_store'];?>";var load_url="<?php dourl('goods_load');?>",add_url="<?php dourl('goods_category_add');?>",wap_cat_url="<?php echo $config['wap_site_url'];?>/goodcat.php",edit_url="<?php dourl('goods_category_edit');?>",delete_url="<?php dourl('goods_category_delete');?>";</script>
        <!-- ▲ Constant JS -->
        <!-- ▼ Goods JS -->
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/customField.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/goods_category.js"></script>
        <!-- ▲ Goods JS -->
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
				            <a href="javascript:;">商品分组</a>
				        </li>
				    </ul>
				</div>
				<!-- ▲ Third Header -->
				<!-- ▼ Container App -->
				<div class="container-app">
					<div class="app-inner clearfix">
						<div class="app-init-container">
							<div class="app__content js-app-main"></div>
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