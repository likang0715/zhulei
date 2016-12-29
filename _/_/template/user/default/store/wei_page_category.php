<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>微页面分类 - <?php echo $store_session['name'];?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="description" content="<?php echo $config['seo_description'];?>">
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
        <meta name="renderer" content="webkit">
        <meta name="referrer" content="always">
        <meta name="format-detection" content="telephone=no">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<!-- ▼ Base CSS -->
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo STATIC_URL;?>css/jquery.ui.css" type="text/css" rel="stylesheet"/>
        <!-- ▲ Base CSS -->
        <!-- ▼ Wei_page_category CSS -->
		<link href="<?php echo TPL_URL;?>css/store_ucenter.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/store_wei_page_category.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/customField.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/app-preview.css" type="text/css" rel="stylesheet"/>
        <!-- ▲ Wei_page_category CSS -->
        <!-- ▼ Base JS -->
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" charset="utf-8" src="/static/js/ueditor/ueditor.config.js"></script>
		<script type="text/javascript" charset="utf-8" src="/static/js/ueditor/ueditor.all.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
        <!-- ▲ Base JS -->
        <!-- ▼ Constant JS -->
		<script type="text/javascript">
		var is_sync_user = "<?php echo $_SESSION['sync_store'];?>";
		var load_url="<?php dourl('load');?>",
		set_home_url="<?php dourl('set_home');?>",
		update_storelogo_url="<?php dourl('update_store_logo'); ?>",
		add_url="<?php dourl('wei_page_add');?>",
		edit_url="<?php dourl('wei_page_edit');?>",
		delete_url="<?php dourl('wei_page_delete');?>",
		add_pageCategory_url="<?php dourl('wei_page_category');?>#create",
		get_pageCategory_url="<?php dourl('get_pageCategory');?>";
		var siteurl = "<?php echo option('config.site_url');?>";
			<?php if($_SESSION['user']['admin_id']) {?>
			var is_adminuser = 1;
			<?php }else {?>
			var is_adminuser = 0;
			<?php }?>
			var show_subject = 1;
			var is_point_mall = "<?php echo $store_session['is_point_mall']?>";
		var is_show_activity="<?php echo $show_activity;?>";
		var wap_home_url="<?php echo $config['wap_site_url'];?>/home.php?id=<?php echo $store_session['store_id']?>",
			wap_ucenter_url="<?php echo $config['wap_site_url'];?>/ucenter.php?id=<?php echo $store_session['store_id']?>",               
			wap_subject_type_url="<?php echo $config['wap_site_url'];?>/store_subject_type.php?id=<?php echo $store_session['store_id']?>",
			wap_diancha_url="<?php echo $config['wap_site_url'];?>/diancha.php?id=<?php echo $store_session['store_id']?>",
			wap_chahui_url="<?php echo $config['wap_site_url'];?>/chahui.php?id=<?php echo $store_session['store_id']?>",
			wap_tuan_url = "<?php echo $config['site_url'];?>/webapp/groupbuy/#/main/<?php echo $store_session['store_id'];?>,"
			wap_yydb_url = "http://www.baidu.com",
			upload_url="<?php echo $config['site_url'];?>/upload/",store_name="<?php echo $store_session['name']?>",
			store_logo="<?php echo $store_session['logo'];?>",
			checkin_url="<?php echo $config['wap_site_url'];?>/checkin.php?act=checkin&store_id=<?php echo $store_session['store_id']?>";
		wap_cat_url="<?php echo $config['wap_site_url'];?>/pagecat.php"
		</script>
        <!-- ▲ Constant JS -->
        <!-- ▼ Wei_page_category JS -->
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.sortable1.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/customField.js"></script>
		<?php if($_SESSION['user']['admin_id']) {?>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/store_wei_page_category.js"></script>
		<?php }else{ ?>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/store_wei_page_category_old.js"></script>
		<?php } ?>
        <!-- ▲ Wei_page_category JS -->
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
	                    <li class="js-list-index active"><a href="#list">微页面分类</a></li>
				    </ul>
				</div>
				<!-- ▲ Third Header -->
				<!-- ▼ Container App -->
				<div class="container-app">
					<div class="app-inner clearfix">
						<div class="app-init-container">
							<div class="nav-wrapper--app"></div>
							<div class="app__content js-app-main"></div>
						</div>
					</div>
				</div>
				<!-- ▲ Container App -->
			</div>
		</div>
		<!-- ▲ Container-->
		<?php include display('public:footer');?>
		<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
	</body>
</html>