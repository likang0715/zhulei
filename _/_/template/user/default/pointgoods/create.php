<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>发布积分商品 - <?php echo $store_session['name'];?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
		<meta name="author" content="小猪CMS"/>
		<meta name="generator" content="小猪CMS微店程序"/>
		<meta name="copyright" content="pigcms.com"/>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/store_ucenter.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo STATIC_URL;?>css/jquery.ui.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/goods_create.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
		<?php
		include display('public:custom_header');
		?>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript">
		//赋值
		var is_sync_user = "<?php echo $_SESSION['sync_store'];?>";
		var load_url="<?php dourl('goods_load');?>",get_product_property_url="<?php dourl('get_product_property_list');?>",get_property_value_url="<?php dourl('get_property_value');?>",get_sys_property_value_url="<?php dourl('get_system_property_list');?>",get_trade_delivery_url="<?php dourl('get_trade_delivery');?>",save_url="<?php dourl('create');?>",add_goodsCategory_url="<?php dourl('category');?>#create",get_propertyvaluebyid_url="<?php dourl('get_propertyvaluebyid');?>",get_goodsCategory_url="<?php dourl('get_goodsCategory');?>";
		var property_value_img = "<?php dourl('property_value_img') ?>";
        var fx_url="<?php dourl('goods_fx_setting');?>";
        var fx_setting_url="<?php dourl('fx:goods_fx_setting');?>";
        var wholesale_setting_url = "<?php dourl('fx:goods_wholesale_setting');?>";
        var goods_index_url = "<?php echo dourl('index'); ?>";
        var version = "<?php echo option('config.weidian_version');?>";
		</script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/pointgoods_create.js?time=<?php echo time()?>"></script>
	</head>
	<body class="font14 usercenter">
		<?php include display('public:header');?>
		<div class="wrap_1000 clearfix container">
			<?php include display('sidebar');?>
			<div class="app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="app__content js-app-main"></div>
					</div>
				</div>
			</div>
		</div>
		<?php include display('public:footer');?>
		<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
	</body>
</html>