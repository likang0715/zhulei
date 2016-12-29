<?php $select_sidebar=isset($select_sidebar)?$select_sidebar:ACTION_NAME;?>
<?php $version  = option('config.weidian_version');?>
<?php if (empty($store_session['drp_level'])) { ?>
<!-- ▼ Second Sidebar -->
<aside class="ui-second-sidebar second-sidebar" id="second-sidebar">
    <div class="second-sidebar-title">
        店铺管理
    </div>
    <nav class="second-sidebar-nav" id="second-sidebar-nav">
        <ul>
        <?php if(in_array(1, $rbac_result) || $package_id == 0){?>
            <li <?php if ($select_sidebar == 'index') { ?>class="active"<?php } ?>><a href="<?php dourl('store:index'); ?>">概况</a></li>
        <?php } ?>
        <?php if(empty($user_session['type'])){?>
        <?php if(in_array(2, $rbac_result) || $package_id == 0){?>
        <?php if(in_array(PackageConfig::getRbacId(2,'store','wei_page'), $rbac_result) || $package_id == 0){?> 
            <li <?php if ($select_sidebar == 'wei_page') { ?>class="active"<?php } ?>><a href="<?php dourl('store:wei_page'); ?>"><?php if($_SESSION['user']['admin_id']){?>微页面<?php }else{?>微页面<?php } ?></a></li>
        <?php } ?>

        <?php if(in_array(PackageConfig::getRbacId(2,'store','wei_page_category'), $rbac_result) || $package_id == 0 ){?> 
            <li <?php if ($select_sidebar == 'wei_page_category') { ?>class="active"<?php } ?>><a href="<?php dourl('store:wei_page_category'); ?>"><?php if($_SESSION['user']['admin_id']){?>页面分类<?php }else{?>页面分类<?php } ?></a></li>
        <?php } ?>
        
        <?php if(in_array(PackageConfig::getRbacId(2,'store','storenav'), $rbac_result) || $package_id == 0){?>
            <li <?php if ($select_sidebar == 'storenav') { ?>class="active"<?php } ?>><a href="<?php dourl('store:storenav'); ?>">店铺导航</a></li>
        <?php } ?>
        <?php } ?>
        <?php if(in_array(3, $rbac_result) || $package_id == 0 ){?>
            <?php if(in_array(PackageConfig::getRbacId(3,'case','ad'), $rbac_result) || $package_id == 0){?>
            <li <?php if ($select_sidebar == 'ad') { ?>class="active"<?php } ?>><a href="<?php dourl('case:ad'); ?>">公共广告</a></li>
            <?php } ?>

            <?php if(in_array(PackageConfig::getRbacId(3,'case','page'), $rbac_result) || $package_id == 0){?>
            <li <?php if ($select_sidebar == 'page') { ?>class="active"<?php } ?>><a href="<?php dourl('case:page'); ?>">自定义模块</a></li>
            <?php } ?>

            <?php if(in_array(PackageConfig::getRbacId(3,'case','attachment'), $rbac_result) || $package_id == 0){?>
            <li class="divider<?php if ($select_sidebar == 'attachment') { ?> active<?php } ?>"><a href="<?php dourl('case:attachment'); ?>">我的文件</a></li>
            <?php } ?>
        <?php } ?>

        <?php if(in_array(4, $rbac_result) || $package_id == 0){?>
            <?php if (!empty($_SESSION['sync_store'])) { ?>
            <?php if(in_array(PackageConfig::getRbacId(4,'store','service'), $rbac_result) || $package_id == 0){?>
                <!--去掉上方感叹号 <li <?php if ($select_sidebar == 'service') { ?>class="active"<?php } ?>><a href="<?php dourl('store:service'); ?>">客服列表</a></li> -->
            <?php } ?>
            <?php } ?>
        <?php } ?>
        <?php }?>
        </ul>
    </nav>
</aside>
<!-- ▲ Second Sidebar -->
<?php }?>
