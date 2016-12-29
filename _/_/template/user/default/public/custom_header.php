		<script type="text/javascript">
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
		</script>
		<link href="<?php echo STATIC_URL;?>css/jquery.ui.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" charset="utf-8" src="/static/js/ueditor/ueditor.config.js"></script>
		<script type="text/javascript" charset="utf-8" src="/static/js/ueditor/ueditor.all.js"></script>

		<link href="<?php echo TPL_URL;?>css/customField.css" type="text/css" rel="stylesheet"/>
	
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/customField.js"></script>

		