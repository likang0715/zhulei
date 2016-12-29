<html>
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="renderer" content="webkit"/>
	<title id="js-meta-title">个人账号设置 - <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
	<meta name="copyright" content="<?php echo $config['site_url'];?>"/>
	<link rel="icon" href="./favicon.ico" />
	<link rel="stylesheet" href="<?php echo TPL_URL; ?>css/base.css" />
	<link rel="stylesheet" href="<?php echo TPL_URL; ?>css/app_team.css" />
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL; ?>js/base.js"></script>
	<script type="text/javascript">var load_url="<?php dourl('load');?>", personal_url="<?php dourl('personal'); ?>", select_url="<?php dourl('store:select'); ?>";</script>
	<script type="text/javascript" src="<?php echo TPL_URL; ?>js/account.js"></script>
</head>
<body>
	<?php include display('public:first_sidebar');?>
	<?php include display('setting:sidebar');?>
	<!-- ▼ Container-->
	<div id="container" class="clearfix container right-sidebar">
		<div id="container-left">
			<!-- ▼ Third Header -->
			<div id="third-header">
				<ul class="third-header-inner">
					<li>个人账号设置</li>
				</ul>
			</div>
			<!-- ▲ Third Header -->
			<!-- ▼ Container App -->
			<div class="container-app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="app__content" id="content">
						</div>
						<?php $show_footer_link = false; include display('public:footer');?>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>