<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>微众筹 - <?php echo $store_session['name']; ?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
		<meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/appmarket.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/wx_sidebar.css" type="text/css" rel="stylesheet"/>
		<link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>css/jquery.ui.css" />
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
		<script type="text/javascript" src="./static/js/date/WdatePicker.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.validate.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
        <script type="text/javascript" charset="utf-8" src="./static/js/ueditor/ueditor.config.js"></script>
        <script type="text/javascript" charset="utf-8" src="./static/js/ueditor/ueditor.all.min.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/wzc.js"></script>
		<script type="text/javascript">
			var index_url = "<?php dourl('wzc:wzc_index') ?>";
			var load_url = "<?php dourl('load');?>";
			var pro_update_url = "<?php dourl('wzc:doupdate') ?>";
			var repay_update_url = "<?php dourl('wzc:setrepay') ?>";
			var repay_del_url  ="<?php dourl('wzc:repaydel'); ?>";
			var wzc_del_url  ="<?php dourl('wzc:wzcdel'); ?>";
			var wzc_start_url  ="<?php dourl('wzc:dostart'); ?>";
			var wzc_start_collect_url  ="<?php dourl('wzc:dostartcollect'); ?>";
			var wzc_product_url = "<?php echo option('config.site_url') ?>/webapp/chanping/index.html#/view/";
			var repaylist_url = "<?php echo dourl('wzc:wzc_index').'#repaylist/';  ?>";

			$.getScript('<?php echo STATIC_URL;?>js/webuploader/webuploader.js',function(){
				$(".js-add-image").data("type", "load");
				console.log(WebUploader);
				return;
				if(!WebUploader.Uploader.support()){
					alert( '您的浏览器不支持上传功能！如果你使用的是IE浏览器，请尝试升级 flash 播放器');
					$('.widget-image,.modal-backdrop').remove();
				}
			});
		</script>
	</head>
	<body class="font14 usercenter">
		<?php include display('public:header');?>
		<div class="wrap_1000 clearfix container">

			<?php include display('public:yx_sidebar');?>

			<div class="app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="clearfix"></div>
						<!-- ▼ Main container -->
						<div class="nav-wrapper--app"></div>
						<div class="app__content"></div>
					</div>
				</div>
			</div>
		</div>

		<?php include display('public:footer');?>
		<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
	</body>
</html>