<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>积分使用 - <?php echo $store_session['name']; ?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
    <meta name="description" content="<?php echo $config['seo_description'];?>">
    <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
    <meta name="renderer" content="webkit">
    <meta name="referrer" content="always">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <!-- ▼ Base CSS -->
    <link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="./static/css/jquery.ui.css" />
    <!-- ▲ Base CSS -->
    <!-- ▼ Member CSS -->
    <link href="<?php echo TPL_URL;?>css/coupon.css" type="text/css" rel="stylesheet"/>
    <!-- ▲ Member CSS -->
    <!-- ▼ Constant JS -->
    <script type="text/javascript">
        var load_url="<?php dourl('load');?>";
        var page_create = "tag_create";
        var page_edit = "tag_edit";
        var page_list_url = "<?php echo url("member")?>";
        var delete_url = "<?php dourl('delete',array('type'=>'member')) ?>";
        var page_content = "member_content";
        var page_downloadcsv = "<?php dourl('load',array('page'=>'tag_download_by_csv')) ?>";
        var now_content_url = "<?php dourl('load',array('page'=>'member_content')) ?>";
        var member_checkout_url = "<?php echo dourl('member_checkout_csv');?>";
        var change_user_jf_url =  "<?php echo dourl('change_user_point');?>";
        var page_product_list = "product_list";
        var disabled_url = "<?php dourl('disabled') ?>";
        var show_userdetail_url = "<?php dourl('show_userdetail');?>";
        var show_txm = "<?php dourl('get_txcode');?>";
    </script>
    <!-- ▲ Constant JS -->
    <!-- ▼ Base JS -->
    <script type="text/javascript" src="./static/js/jquery.min.js"></script>
    <script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
    <script type="text/javascript" src="./static/js/plugin/jquery-ui.js"></script>
    <script type="text/javascript" src="./static/js/plugin/jquery-ui-timepicker-addon.js"></script>
    <script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
    <!-- ▲ Base JS -->
    <!-- ▼ Member JS -->
    <script type="text/javascript" src="<?php echo TPL_URL;?>js/points_apply.js"></script>
    <!-- ▲ Member JS -->
</head>
<body class="font14 usercenter">
<?php include display('public:first_sidebar');?>
        <?php include display('sidebar');?>
        <!-- ▼ Container-->
        <div id="container" class="clearfix container right-sidebar">
            <div id="container-left">
                <!-- ▼ Third Header -->
                <div id="third-header">
                    <ul class="third-header-inner js-title-list">
                        <li class="active" data-points="1">
                            <a href="#points_create">积分生成</a>
                        </li>
                        <li data-points="2">
                            <a href="#points_apply">积分消耗</a>
                        </li>
                    </ul>
                </div>
                <!-- ▲ Third Header -->
                <!-- ▼ Container App -->
                <div class="container-app">
                <div class="app-inner clearfix">
                    <div class="app-init-container">
                        <div class="nav-wrapper--app"></div>
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