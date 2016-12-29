<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>本店商品 - <?php echo $store_session['name'];?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
        <link href="<?php echo TPL_URL;?>css/fx.css" type="text/css" rel="stylesheet"/>
        <link href="<?php echo TPL_URL;?>css/freight.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript">
            var load_url="<?php dourl('load');?>",
                supplier_market_url = "<?php echo dourl('cancel_fx_product'); ?>",
                agency_url="<?php echo dourl('post_agency');?>",
                get_whitelist="<?php echo dourl('get_whitelist')?>",
                product_whitelist_url="<?php echo dourl('product_whitelist')?>",
                is="<?php echo !empty($_GET['is']) ? $_GET['is'] : 3;?>",
                page="<?php echo !empty($_GET['page']) ? $_GET['page'] : 1;?>",
                goods_drp_degree_url = "<?php dourl('goods_drp_degree'); ?>";
                detach_whitelist_url = "<?php dourl('detach_whitelist'); ?>";
        </script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/fx_common.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/fx_supplier_market.js"></script>
		<script type="text/javascript">layer.use('extend/layer.ext.js');</script>
		<style type="text/css">
			.xubox_layer .xubox_tab_main {text-align:center}
			.ico_all_print2_ul{width:500px;display:block;}
			.ico_all_print2_ul li{float:left;width:33%;text-align:center;padding:15px 0px;}
			.input_button{border-radius:5px; background: #369 none repeat scroll 0 0;border: 2px solid #efefef;color: #fff; cursor: pointer; font-size: 14px;font-weight: 700;height: 35px;line-height: 30px;text-align: center;width: 80px;}
			.ui-nav .ico_all_f li.active a{font-size:12px;}
		</style>
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