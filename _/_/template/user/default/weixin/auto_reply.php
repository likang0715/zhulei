<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>关注后自动回复 - <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script type="text/javascript">var load_url="<?php dourl('auto_reply_load');?>";</script>
		<script type="text/javascript">var home_url = '<?php echo $home_url;?>', member_url = '<?php echo $member_url;?>';</script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/auto.js"></script>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/image_text.css" type="text/css" rel="stylesheet"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/app_weixin.css"/>
		<style type="text/css">
		.popover{
			display: block;
		}
		</style>
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
						<li <?php if($select_sidebar == 'auto'){ ?>class="active"<?php } ?>>
							<a href="/user.php?c=weixin&a=auto">关键词自动回复</a>
						</li>
						<li <?php if($select_sidebar == 'auto_reply'){ ?>class="active"<?php } ?>>
							<a href="/user.php?c=weixin&a=auto_reply">关注后自动回复</a>
						</li>
						<li <?php if($select_sidebar == 'tail'){ ?>class="active"<?php } ?>>
							<a href="/user.php?c=weixin&a=tail">小尾巴</a>
						</li>
                    </ul>
                </div>
                <!-- ▲ Third Header -->
                <!-- ▼ Container App -->
                <div class="container-app">
					<div class="app-inner clearfix">
						<div class="app-init-container">
							<div class="app__content"></div>
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