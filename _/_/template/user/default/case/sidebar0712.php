		
		<?php $select_sidebar=isset($select_sidebar)?$select_sidebar:ACTION_NAME;?>
<?php $version  = option('config.weidian_version');?>
<?php if (empty($store_session['drp_level'])) { ?>
<aside class="ui-sidebar sidebar" style="min-height: 500px;">
    <nav>
        <?php if(in_array(1, $rbac_result) || $package_id == 0){?>
        <ul>
            <li <?php if ($select_sidebar == 'index') { ?>class="active"<?php } ?>><a href="<?php dourl('store:index'); ?>">微店铺概况</a></li>
        </ul>
        <?php } ?>
        <?php if(empty($user_session['type'])){?>
        
        <?php if(in_array(2, $rbac_result) || $package_id == 0){?>
        <h4>页面管理</h4>
        <ul>
        <?php if(in_array(PackageConfig::getRbacId(2,'store','wei_page'), $rbac_result) || $package_id == 0){?> 
            <li <?php if ($select_sidebar == 'wei_page') { ?>class="active"<?php } ?>><a href="<?php dourl('store:wei_page'); ?>"><?php if($_SESSION['user']['admin_id']){?>微页面模板<?php }else{?>微页面/杂志<?php } ?></a></li>
        <?php } ?>

        <?php if(in_array(PackageConfig::getRbacId(2,'store','wei_page_category'), $rbac_result) || $package_id == 0 ){?> 
            <li <?php if ($select_sidebar == 'wei_page_category') { ?>class="active"<?php } ?>><a href="<?php dourl('store:wei_page_category'); ?>"><?php if($_SESSION['user']['admin_id']){?>行业分类<?php }else{?>微页面分类<?php } ?></a></li>
        <?php } ?>

        <?php if(in_array(PackageConfig::getRbacId(2,'store','ucenter'), $rbac_result) || $package_id == 0){?> 
            <li <?php if ($select_sidebar == 'ucenter') { ?>class="active"<?php } ?>><a href="<?php dourl('store:ucenter'); ?>">会员主页</a></li>
        <?php } ?>
        
        <?php if(in_array(PackageConfig::getRbacId(2,'store','storenav'), $rbac_result) || $package_id == 0){?>
            <li <?php if ($select_sidebar == 'storenav') { ?>class="active"<?php } ?>><a href="<?php dourl('store:storenav'); ?>">店铺导航</a></li>
        <?php } ?>

        </ul>
        <?php } ?>


        <?php if(in_array(3, $rbac_result) || $package_id == 0 ){?>
        <h4>通用模块</h4>
        <ul>
            <?php if(in_array(PackageConfig::getRbacId(3,'case','ad'), $rbac_result) || $package_id == 0){?>
            <li <?php if($select_sidebar == 'ad') echo 'class="active"';?>><a href="<?php dourl('case:ad'); ?>">公共广告设置</a></li>
            <?php } ?>

            <?php if(in_array(PackageConfig::getRbacId(3,'case','banner'), $rbac_result) || $package_id == 0){?>
            <li <?php if($select_sidebar == 'banner') echo 'class="active"';?>><a href="<?php dourl('case:banner'); ?>">店铺广告管理</a></li>
            <?php } ?>

            <?php if(in_array(PackageConfig::getRbacId(3,'case','page'), $rbac_result) || $package_id == 0){?>
            <li <?php if($select_sidebar == 'page') echo 'class="active"';?>><a href="<?php dourl('case:page'); ?>">自定义页面模块</a></li>
            <?php } ?>

            <?php if(in_array(PackageConfig::getRbacId(3,'case','attachment'), $rbac_result) || $package_id == 0){?>
            <li <?php if($select_sidebar == 'attachment') echo 'class="active"';?>><a href="<?php dourl('case:attachment'); ?>">我的文件</a></li>
            <?php } ?>

            <?php if(in_array(PackageConfig::getRbacId(3,'article','index'), $rbac_result) || $package_id == 0){?>
            <li><a href="<?php dourl('article:index'); ?>">店铺动态</a></li>
            <?php } ?>
        
        </ul>
        <?php } ?>

        <?php if(in_array(4, $rbac_result) || $package_id == 0){?>
            <?php if (empty($_SESSION['sync_store'])) { ?>
            <h4>店铺服务</h4>
            <ul>
            <?php if(in_array(PackageConfig::getRbacId(4,'store','service'), $rbac_result) || $package_id == 0){?>
                <li <?php if ($select_sidebar == 'service') { ?>class="active"<?php } ?>><a href="<?php dourl('store:service'); ?>">客服列表</a></li>
            <?php } ?>
            <?php /* if(in_array(PackageConfig::getRbacId(4,'store','business_hours'), $rbac_result) || $package_id == 0){?>
    			<!--<li <?php if ($select_sidebar == 'business_hours') { ?>class="active"<?php } ?>><a href="<?php dourl('store:business_hours'); ?>">营业时间</a></li>-->
            <?php } */ ?>
            <?php if(in_array(PackageConfig::getRbacId(4,'store','certification'), $rbac_result) || $package_id == 0){?>
    			<li <?php if ($select_sidebar == 'certification') { ?>class="active"<?php } ?>><a href="<?php dourl('store:certification'); ?>">店铺认证</a></li>
            <?php } ?>
            </ul>
            <?php } ?>
        <?php } ?>
        
        <?php if(in_array(5, $rbac_result) || $package_id == 0){?>
		<h4>店铺设置</h4>
		<ul class="dianpu_left">
			<?php if(in_array(PackageConfig::getRbacId(5,'setting','store#info'), $rbac_result) || $package_id == 0){?>
            <li class="<?php if ($select_sidebar == 'info') { ?>active<?php } ?> info"><a href="<?php dourl('setting:store'); ?>#info">店铺信息</a></li>
			<?php } ?>
            
            <?php if(in_array(PackageConfig::getRbacId(5,'setting','store#contact'), $rbac_result) || $package_id == 0){?>
            <li class="<?php if ($select_sidebar == 'contact') { ?>active<?php } ?> contact"><a href="<?php dourl('setting:store'); ?>#contact">联系我们</a></li>
            <?php } ?>
			
            <?php if (in_array(6, $rbac_result) || $package_id == 0) { ?>
            <?php if (!empty($_SESSION['drp_diy_store'])) { ?>
			<li <?php if ($select_sidebar == 'config') { ?>class="active"<?php } ?>><a href="<?php dourl('setting:config'); ?>">物流配置</a></li>
            <?php } ?>
			<?php } ?>
			
            <?php if(in_array(PackageConfig::getRbacId(5,'setting','store#notice_list'), $rbac_result) || $package_id == 0){?>
            <li <?php if ($select_sidebar == 'store') { ?>class="active"<?php } ?>><a href="<?php dourl('setting:store'); ?>#notice_list"  >消息/通知管理</a></li>
            <?php } ?>
            <?php if(empty($version) && empty($_SESSION['sync_store'])){?>
                <?php if(in_array(PackageConfig::getRbacId(5,'cashier','index'), $rbac_result) || $package_id == 0){?>
                <li class="hidFunc <?php if ($select_sidebar == 'cashier') { ?>active<?php } ?>">
                    <a href="<?php dourl('user:cashier:index') ?>" target="_blank">独立收银台</a>
                </li>
                <?php }?>
            <?php }?>
        </ul>
        <?php } ?>
        <?php }?>
    </nav>
</aside>
<?php }?>

