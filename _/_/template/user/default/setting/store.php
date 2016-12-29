<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>店铺信息 - <?php echo $store_session['name']; ?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
    <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
    <link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
    <link href="<?php echo TPL_URL;?>css/freight.css" type="text/css" rel="stylesheet"/>
    <link href="<?php echo TPL_URL;?>css/store.css" type="text/css" rel="stylesheet"/>
    <link href="<?php echo TPL_URL;?>css/setting_store.css" type="text/css" rel="stylesheet"/>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
    <script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
    <script type="text/javascript">
    var load_url="<?php dourl('load');?>", 
    store_notice_setting_url="<?php dourl('store_notice_setting'); ?>"; 
    store_name_check_url = "<?php dourl('store_name_check'); ?>",
    store_setting_url="<?php dourl('store'); ?>",
    store_contact_url="<?php dourl('contact'); ?>",
    store_physical_add_url="<?php dourl('physical_add'); ?>",
    edit_admin="<?php dourl('edit_admin'); ?>",
    add_admin="<?php dourl('add_admin'); ?>",
    del_admin="<?php dourl('del_admin'); ?>",
    store_physical_add_url="<?php dourl('physical_add'); ?>",
    store_physical_edit_url="<?php dourl('physical_edit'); ?>",
    store_physical_del_url="<?php dourl('substore:physical_del'); ?>",
    static_url="<?php echo TPL_URL;?>",
    shop_notice_url="<?php dourl('setting:set_shop_notice'); ?>",
    set_notice_time_url="<?php dourl('setting:set_notice_time') ?>";
    </script>
    <script type="text/javascript" src="<?php echo TPL_URL;?>js/store_setting.js"></script>
    <script type="text/javascript" src="<?php echo TPL_URL;?>js/store_notice_setting.js"></script>
    <script>
    //套餐权限初始化判断
        $(function(){
            var p_hash = location.hash;
            if(p_hash){
                p_hash = p_hash.split('#');
                p_hash = p_hash[1];
            }
            if(p_hash == 'info' || p_hash == 'contact' || p_hash == 'notice_list'){
               if($('.'+p_hash).html() == undefined){
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
                <div id="third-header" class="dianpu">
                    <ul class="third-header-inner">
                        <?php if(in_array(PackageConfig::getRbacId(5,'setting','store#info'), $rbac_result) || $package_id == 0){?>
                        <li class="js-app-nav active info">
                            <a href="#info">店铺信息</a>
                        </li>
                        <?php }?>

                        <?php if(in_array(PackageConfig::getRbacId(5,'setting','store#contact'), $rbac_result) || $package_id == 0){?>
                        <?php if(empty($store_session['drp_level'])) {?>
                        <li class="js-app-nav contact">
                            <a href="#contact">联系我们</a>
                        </li>
                        <?php }?>
                        <?php }?>
                        <li class="js-app-nav list">
                            <a href="#list">线下门店</a>
                        </li>
						<?php if(empty($_SESSION['user']['group'])){?>   
                        <li class="js-app-nav admin">
                            <a href="#admin_list">门店管理员</a>
                        </li>
						 <?php }?>
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


    <script>

    </script>
<?php include display('public:footer');?>
</body>
</html>