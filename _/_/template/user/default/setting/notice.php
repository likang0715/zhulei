<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8"/> 
	<title>通知管理 - <?php echo $store_session['name']; ?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
	<meta name="description" content="<?php echo $config['seo_description'];?>">
	<meta name="copyright" content="<?php echo $config['site_url'];?>"/>
	<meta name="renderer" content="webkit">
	<meta name="referrer" content="always">
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<!-- ▼ Base CSS -->
	<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
	<link href="<?php echo STATIC_URL;?>css/jquery.ui.css" type="text/css" rel="stylesheet" />
	<!-- ▲ Base CSS -->
	<!-- ▼ Notice CSS -->
	<link href="<?php echo TPL_URL;?>css/freight.css" type="text/css" rel="stylesheet"/>
	<link href="<?php echo TPL_URL;?>css/notice.css" type="text/css" rel="stylesheet"/>
	<!-- ▲ Notice CSS -->
	<!-- ▼ Constant JS -->
	<script type="text/javascript">
		var load_url="<?php dourl('load');?>", 
		store_notice_setting_url="<?php dourl('store_notice_setting'); ?>"; 
		store_name_check_url = "<?php dourl('store_name_check'); ?>",
		store_setting_url="<?php dourl('store'); ?>",
		static_url="<?php echo TPL_URL;?>",
		shop_notice_url="<?php dourl('setting:set_shop_notice'); ?>",
		set_notice_time_url="<?php dourl('setting:set_notice_time') ?>";
		sms_recharge_url = "<?php dourl('setting:sms_list') ?>";
		sms_send_url = "<?php dourl('setting:send_list') ?>";
		sms_buy_url = "<?php dourl('account:buysms') ?>";
		sms_code_url = "<?php dourl('recognition:see_tmp_qrcode');?>";
		sms_check_url = "<?php dourl('account:smsorder_check');?>";
		sms_details_url = "<?php dourl('account:smsorder_detail_post');?>";
	</script>
	<!-- ▲ Constant JS -->
	<!-- ▼ Base JS -->
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui-timepicker-addon.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/swiper.jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
	<!-- ▲ Base JS -->
	<script type="text/javascript">
		page = getUrlParam('page');
		type = getUrlParam('type');
		stime = getUrlParam('stime');
		stime = getUrlParam('stime');
	</script>
	<!-- ▼ Notice JS -->
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/setting_notice.js"></script>
	<!-- ▲ Notice JS --> 
	<!-- <link href="<?php echo TPL_URL;?>css/store.css" type="text/css" rel="stylesheet"/> -->
	<script>
    //套餐权限初始化判断
    $(function(){
    	var p_hash = location.hash;
    	if(p_hash){
    		p_hash = p_hash.split('#');
    		p_hash = p_hash[1];
    	}
    	if(p_hash == 'notice_switch' || p_hash == 'notice_recipient' || p_hash == 'notice_sms'){
    		if($('.'+p_hash).html() == undefined){
    			layer.alert('非法访问！');
    			location.href='user.php?c=setting&a=notice';
    		}  
    	}
    });
    </script>
</head>
<body class="font14 usercenter">
	<?php include display('public:first_sidebar');?>
	<?php include display('sidebar');?>
	<!-- ▼ Container-->
	<div id="container" class="clearfix container right-sidebar">
		<div id="container-left">
			<!-- ▼ Third Header -->
			<div id="third-header" class="notice-nav">
				<ul class="third-header-inner">
					<li class="js-app-nav notice_switch active">
						<a href="#notice_switch">通知开关</a>
					</li>
					<li class="js-app-nav notice_recipient">
						<a href="#notice_recipient">接收人设置</a>
					</li>
					<li class="js-app-nav notice_sms">
						<a href="#notice_sms">短信管理</a>
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
			<!-- ▲ Container App -->
		</div>
	</div>
	<!-- ▲ Container -->
	<?php include display('public:footer');?>
</body>
</html>
