<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<?php $version  = option('config.weidian_version');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8"/> 
	<title>物流配置 - <?php echo $store_session['name'];?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
	<meta name="description" content="<?php echo $config['seo_description'];?>">
	<meta name="copyright" content="<?php echo $config['site_url'];?>"/>
	<meta name="renderer" content="webkit">
	<meta name="referrer" content="always">
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<!-- ▼ Base CSS -->
	<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
	<link href="<?php echo TPL_URL;?>css/freight.css" type="text/css" rel="stylesheet"/>
	<link href="<?php echo TPL_URL;?>css/store_ucenter.css" type="text/css" rel="stylesheet"/>
	<link href="<?php echo STATIC_URL;?>css/jquery.ui.css" type="text/css" rel="stylesheet"/>
	<!-- ▲ Base CSS -->
	<!-- ▼ Goods CSS -->
	<link href="<?php echo TPL_URL;?>css/store.css" type="text/css" rel="stylesheet"/>
	<link href="<?php echo TPL_URL;?>css/setting_store.css" type="text/css" rel="stylesheet"/>
	<!-- ▲ Goods CSS -->
	<!-- ▼ Base JS -->
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
	<!-- ▲ Base JS -->
	<!-- ▼ Constant JS -->
	<script type="text/javascript">
	var setting_config_url = "<?php dourl('config') ?>";
	var load_url = "<?php dourl('load') ?>";
	var trade_load_url = "<?php dourl('trade:offline_payment_load') ?>";
	var offline_payment_status_url = "<?php dourl('trade:offline_payment_status') ?>";
	var trade_selffetch_url = "<?php dourl('trade:delivery_load') ?>";
	var selffetch_status_url = "<?php dourl('trade:selffetch_status') ?>";
	var buyer_selffetch_name_url = "<?php dourl('trade:buyer_selffetch_name') ?>";
	var local_logistic_url = "<?php dourl('setting:local_logistic') ?>";
	var local_logistic_status_url = "<?php dourl('setting:set_local_logistic') ?>";
	var logistics_url = "<?php dourl('setting:logistics') ?>";
	var logistics_status_url = "<?php dourl('setting:logistics_status') ?>";
	var friend_status_url = "<?php dourl('setting:friend_status') ?>";
	var assign_url = "<?php dourl('setting:assign_auto') ?>";
	var assign_status_url = "<?php dourl('setting:assign_status') ?>";
	var commonweal_address_url = "<?php dourl('setting:commonweal_address') ?>";
	var commonweal_address_delete_url = "<?php dourl('setting:commonweal_address_delete') ?>";
	</script>
	<!-- ▲ Constant JS -->
	<!-- ▼ Setting JS -->
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/setting_config.js"></script>
	<!-- ▲ Setting JS -->

	<script>
    //套餐权限初始化判断
    $(function(){
    	var p_hash = location.hash;
    	if(p_hash){
    		p_hash = p_hash.split('#');
    		p_hash = p_hash[1];
    	}
    	if(p_hash == 'selffetch' || p_hash == 'friend' || p_hash == 'offline_payment' || p_hash == 'local_logistic'){
    		if($('.p_'+p_hash).html() == undefined){
    			layer.alert('非法访问！');
    			location.href='user.php?c=store&a=index';
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
			<div id="third-header">
				<ul class="third-header-inner">
					<li class="js-app-nav active info">
						<a href="#logistics">物流开关</a>
					</li>
					<?php if(empty($version)){?>
					
					<?php if(in_array(PackageConfig::getRbacId(6,'setting','config#selffetch'), $rbac_result) || $package_id == 0){?>
					<li class="js-app-nav contact p_selffetch">
						<a href="#selffetch" id="buyer_selffetch_name_txt"><?php echo $store_session['buyer_selffetch_name'] ? $store_session['buyer_selffetch_name'] : '上门自提' ?></a>
					</li>
					<?php } ?>
					
					<?php if(in_array(PackageConfig::getRbacId(6,'setting','config#friend'), $rbac_result) || $package_id == 0){?>
					<li class="js-app-nav contact p_friend">
						<a href="#friend">送朋友开关</a>
					</li>
					<?php } ?>
					
					<?php if(in_array(PackageConfig::getRbacId(6,'setting','config#offline_payment'), $rbac_result) || $package_id == 0){?>
					<li class="js-app-nav list p_offline_payment">
						<a href="#offline_payment">货到付款</a>
					</li>
					<?php } ?>
					<?php if(in_array(PackageConfig::getRbacId(6,'setting','config#local_logistic'), $rbac_result) || $package_id == 0){?>
					<li class="js-app-nav local p_local_logistic">
						<a href="#local_logistic">开启本地物流</a>
					</li>
					<?php } ?>
					<?php } ?>
				</ul>
			</div>
			<!-- ▲ Third Header -->
			<!-- ▼ Container App -->
			<div class="container-app app-sidebars">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="app__content"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include display('public:footer');?>
	<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
</body>
</html>