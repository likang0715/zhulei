<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>发布商品 - <?php echo $store_session['name'];?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
		<meta name="description" content="<?php echo $config['seo_description'];?>">
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
        <meta name="renderer" content="webkit">
        <meta name="referrer" content="always">
        <meta name="format-detection" content="telephone=no">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
        <!-- ▼ Base CSS -->
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/store_ucenter.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo STATIC_URL;?>css/jquery.ui.css" type="text/css" rel="stylesheet"/>
        <!-- ▲ Base CSS -->
        <!-- ▼ Goods CSS -->
		<link href="<?php echo TPL_URL;?>css/goods_create.css" type="text/css" rel="stylesheet"/>
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
		<script type="text/javascript">
			var is_notshow_activity_module = true;
			var is_sync_user = "<?php echo $_SESSION['sync_store'];?>";
			var load_url="<?php dourl('goods_load');?>",
				get_product_property_url="<?php dourl('get_product_property_list');?>",
				get_property_value_url="<?php dourl('get_property_value');?>",
				get_sys_property_value_url="<?php dourl('get_system_property_list');?>",
				get_trade_delivery_url="<?php dourl('get_trade_delivery');?>",
				save_url="<?php dourl('create');?>",
				add_goodsCategory_url="<?php dourl('category');?>#create",
				get_propertyvaluebyid_url="<?php dourl('get_propertyvaluebyid');?>",
				get_goodsCategory_url="<?php dourl('get_goodsCategory');?>";
			var property_value_img = "<?php dourl('property_value_img') ?>";
			var fx_url="<?php dourl('goods_fx_setting');?>";
			var fx_setting_url="<?php dourl('fx:goods_fx_setting');?>";
			var wholesale_setting_url = "<?php dourl('fx:goods_wholesale_setting');?>";
			var goods_index_url = "<?php echo dourl('index'); ?>";
			var version = "<?php echo option('config.weidian_version');?>";
			var hasbind = "<?php echo $hasbind; ?>";
		</script>
        <!-- ▲ Constant JS -->
        <!-- ▼ Goods JS -->
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/customField.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/goods_create.js?time=<?php echo time()?>"></script>
        <!-- ▲ Goods JS -->
		<style type="text/css">
			.control-group.error .control-label, .control-group.error .help-block {
				color: #b94a48;
			}
		</style>
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
				        <li style="padding-left:10px">
                            全部商品&nbsp;/&nbsp;发布商品
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
			</div>
		</div>
		<?php include display('public:footer');?>
		<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
	</body>
</html>