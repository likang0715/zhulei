<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>会员主页 - <?php echo $ucenters['tab_name'];?><?php echo $store_session['name'];?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/customField.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/store_ucenter.css" type="text/css" rel="stylesheet"/>
        <link href="<?php echo TPL_URL;?>css/xxoo.css" type="text/css" rel="stylesheet"/>
		
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
		
		<?php include display('public:global_header');?>
		<?php include display('public:custom_header');?>
		
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript">
			var is_notshow_activity_module = true;
            var tab_name ='<?php echo $ucenter['tab_name'];?>';
            var consumption_field = '<?php echo $ucenter['consumption_field'];?>';
            var promotion_field = '<?php echo $ucenter['promotion_field'];?>';
            var member_content = '<?php echo $ucenter['member_content'];?>';
            var promotion_content = '<?php echo $ucenter['promotion_content'];?>'; var is_sync_user = "<?php echo $_SESSION['sync_store'];?>";var load_url="<?php dourl('load');?>",post_url="<?php dourl('store:ucenter_save');?>",ucenter_page_title="<?php echo $ucenter['page_title'];?>",ucenter_bg_pic="<?php echo $ucenter['bg_pic'];?>",ucenter_show_level=!!<?php echo $ucenter['show_level'];?>,ucenter_show_point=!!<?php echo $ucenter['show_point'];?>,ucenter_customField='<?php echo $customField?>',store_id=<?php echo $store_session['store_id']?>,wap_site_url='<?php echo $config['wap_site_url'];?>';</script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/store_ucenter.js"></script>
    </head>
	<body class="font14 usercenter">
		<?php include display('public:header');?>
		<div class="wrap_1000 clearfix container">
			<?php include display('sidebar');?>
			<div class="app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="nav-wrapper--app"></div>
						<div class="app__content js-app-main"></div>
					</div>
				</div>
			</div>
		</div>
		<?php include display('public:footer');?>
		<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
	<div style="display:none;" id="edit_custom_subject_menu" subject-menu-field='<?php echo $subtype;?>'></div>
	</body>
</html>
