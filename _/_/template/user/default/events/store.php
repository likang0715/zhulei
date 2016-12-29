<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>茶会信息 - <?php echo $store_session['name']; ?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
	<meta name="copyright" content="<?php echo $config['site_url'];?>"/>
	<link href="./css/base.css" type="text/css" rel="stylesheet"/>
	<link href="./css/freight.css" type="text/css" rel="stylesheet"/>
	<link href="./css/store.css" type="text/css" rel="stylesheet"/>
	<link href="./css/setting_store.css" type="text/css" rel="stylesheet"/>
	<link rel="stylesheet" href="./skin/css/font-awesome.min.css">
	<link rel="stylesheet" href="./skin/css/jquery-ui.css">
	<link rel="stylesheet" href="./skin/css/jquery-ui.min.css">
	<link rel="stylesheet" href="./skin/css/ace-fonts.css">
	<link rel="stylesheet" href="./skin/css/ace.min.css" id="main-ace-style">
	<link rel="stylesheet" href="./skin/css/ace-skins.min.css">
	<link rel="stylesheet" href="./skin/css/ace-rtl.min.css">
	<link rel="stylesheet" href="./skin/css/global.css">
	<link rel="stylesheet" href="./skin/css/hint.css">
	<link rel="stylesheet" href="./skin/css/jquery-ui-timepicker-addon.css">
	<script type="text/javascript" src="./static/js/jquery.min.js"></script>
	<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
	<script type="text/javascript" src="./static/js/area/area.min.js"></script>
	<script type="text/javascript" src="./js/base.js"></script>
	<script type="text/javascript">var load_url="<?php dourl('load');?>", store_name_check_url = "<?php dourl('store_name_check'); ?>",store_setting_url="<?php dourl('index'); ?>",store_contact_url="<?php dourl('contact'); ?>",store_physical_add_url="<?php dourl('physical_add'); ?>",store_physical_edit_url="<?php dourl('physical_edit'); ?>",store_physical_del_url="<?php dourl('physical_del'); ?>",static_url="./";</script>
	<script type="text/javascript" src="./js/chahui_setting.js"></script>
	<script type="text/javascript" src="./static/js/date/WdatePicker.js"></script>
	<script type="text/javascript" src="./static/js/plugin/jquery-ui.js"></script>
	<script type="text/javascript" src="./static/js/plugin/jquery-ui-timepicker-addon.js"></script>
	<script type="text/javascript" src="./js/chahui.js"></script>
	<script type="text/javascript" charset="utf-8" src="/static/js/ueditor/ueditor.config.js"></script>
	<script type="text/javascript" charset="utf-8" src="/static/js/ueditor/ueditor.all.js"></script>
	<script src="/static/js/ueditor/lang/zh-cn/zh-cn.js" type="text/javascript" defer="defer"></script>
	<link href="/static/js/ueditor/themes/default/css/ueditor.css" type="text/css" rel="stylesheet">
	<script src="/static/js/ueditor/third-party/codemirror/codemirror.js" type="text/javascript" defer="defer"></script>
	<link rel="stylesheet" type="text/css" href="/static/js/ueditor/third-party/codemirror/codemirror.css">

</head>
<body class="font14 usercenter">
	<?php include display('public:header');?>
	<div class="wrap_1000 clearfix container">
		<?php include display('events:sidebar');?>
		<div class="app">
			<div class="app-inner clearfix">
				<div class="app-init-container">
					<div class="nav-wrapper--app"></div>
					<div class="app__content"></div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
	$(document).ready(function() {
		$(".events_results_b_list ul").click(function() {
			$(this).next(".events_results_b_list_more").toggle()
		});
	});
	</script>
	<?php include display('public:footer');?>
	<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
</body>
</html>