<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>店铺导航 - <?php echo $store_session['name']; ?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
    <meta name="description" content="<?php echo $config['seo_description'];?>">
    <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
    <meta name="renderer" content="webkit">
    <meta name="referrer" content="always">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <!-- ▼ Base CSS -->
    <link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
    <link href="<?php echo TPL_URL;?>css/freight.css" type="text/css" rel="stylesheet"/>
    <!-- ▲ Base CSS -->
    <!-- ▼ Store_nav CSS -->
    <link href="<?php echo TPL_URL;?>css/store_nav.css" type="text/css" rel="stylesheet"/>
    <!-- ▲ Store_nav CSS -->
    <!-- ▼ Base JS -->
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/static/js/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/static/js/ueditor/ueditor.all.js"></script>
    <script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
    <!-- ▲ Base JS -->
    <!-- ▼ Constant JS -->
    <script type="text/javascript">var load_url="<?php dourl('load');?>", store_name_check_url = "<?php dourl('store_name_check'); ?>",open_nav_url="<?php dourl('open_nav'); ?>", store_nav_url="<?php dourl('storenav'); ?>", allow_store_drp = "<?php echo $allow_store_drp; ?>";</script>
    <script>
    var is_sync_user = "<?php echo $_SESSION['sync_store'];?>";
    </script>
    <!-- ▲ Constant JS -->
    <!-- ▼ Store_nav JS -->
    <script type="text/javascript" src="<?php echo TPL_URL;?>js/store_nav.js"></script>
    <!-- ▲ Store_nav JS -->
</head>
    <body class="font14 usercenter">
        <?php include display('public:first_sidebar');?>
        <?php include display('store:sidebar');?>
        <div id="container" class="clearfix container right-sidebar">
            <div id="container-left">
                <!-- ▼ Third Header -->
                <div id="third-header">
                    <ul class="third-header-inner">
                        <li class="js-list-index active"><a href="#list">店铺导航</a></li>
                    </ul>
                </div>
                <!-- ▲ Third Header -->
                <!-- ▼ Container App -->
                <div class="container-app">
                    <div class="app-inner clearfix">
                        <div class="app-init-container">
                            <div class="app__content js-app-main"></div>
                        </div>
                    </div>
                </div>
                <!-- ▲ Container App -->
            </div>
        <!-- ▲ Container-->
        </div>
        <?php include display('public:footer');?>
        <div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
    </body>
</html>