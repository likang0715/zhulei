<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>分配门店库存 - <?php echo $store_session['name']; ?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
    <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
    <link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
    <link href="<?php echo TPL_URL;?>css/freight.css" type="text/css" rel="stylesheet"/>
    <link href="<?php echo TPL_URL;?>css/store.css" type="text/css" rel="stylesheet"/>
    <!-- <link href="<?php echo TPL_URL;?>css/setting_store.css" type="text/css" rel="stylesheet"/> -->
    <link href="<?php echo TPL_URL;?>css/goods.css" type="text/css" rel="stylesheet"/>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
    <script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
    <script type="text/javascript">
        var load_url="<?php dourl('load');?>", 
            page_content="assign_quantity",
            assign_json_url = "<?php dourl('assign_quantity_json'); ?>",
            set_physical_quantity = "<?php dourl('quantity_set'); ?>",
            // store_name_check_url = "<?php dourl('store_name_check'); ?>",
            // store_setting_url="<?php dourl('store'); ?>",
            // store_contact_url="<?php dourl('contact'); ?>",
            // add_admin="<?php dourl('add_admin'); ?>",
            // store_admin_edit="<?php dourl('store_edit'); ?>",
            // store_admin_del="<?php dourl('store_admin_del'); ?>",
            // change_select="<?php dourl('change_unique');?>",
            static_url="<?php echo TPL_URL;?>",
            uid="<?php echo $_GET['uid'];?>";
    </script>
    <script type="text/javascript" src="<?php echo TPL_URL;?>js/setting_stock.js"></script>

</head>
<body class="font14 usercenter">
<?php include display('public:header');?>
<div class="wrap_1000 clearfix container">
    <?php include display('store:sidebar');?>
    <div class="app">
        <div class="app-inner clearfix">
            <div class="app-init-container">
                <div class="ui-nav dianpu">
                    <ul>
                        <li class="js-app-nav list active">
                            <a href="#product">分配门店库存</a>
                        </li>
                    </ul>
                </div>
                <div class="nav-wrapper--app"></div>
                <div class="app__content"></div>
            </div>
        </div>
    </div>
</div>


<script>

</script>
<?php include display('public:footer');?>
<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
</body>
</html>