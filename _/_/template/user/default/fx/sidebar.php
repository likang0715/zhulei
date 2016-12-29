<?php $select_sidebar=isset($select_sidebar)?$select_sidebar:ACTION_NAME;?>
<?php $version  = option('config.weidian_version');?>
<aside class="ui-sidebar sidebar" style="min-height: 500px;">
<nav>
    <?php if ($_SESSION['store']['drp_level'] >= 1) { //分销商显示?>
    <ul><li><h4>我是分销商</h4></li></ul>
    <ul>
        <li <?php if ($select_sidebar == 'index') { ?>class="active"<?php } ?>><a href="<?php dourl('fx:index'); ?>">分销概况</a></li>
        <li <?php if ($select_sidebar == 'next_seller') { ?>class="active"<?php } ?>><a href="<?php dourl('fx:next_seller'); ?>">下级分销商</a></li>
        <li <?php if ($select_sidebar == 'goods') { ?>class="active"<?php } ?>><a href="<?php dourl('fx:goods'); ?>">已分销商品</a></li>
        <li <?php if ($select_sidebar == 'orders') { ?>class="active"<?php } ?>><a href="<?php dourl('fx:orders'); ?>">分销订单</a></li>
        <?php if ($open_drp_team) { ?>
        <li <?php if ($select_sidebar == 'my_team') { ?>class="active"<?php } ?>><a href="<?php dourl('fx:my_team'); ?>">我的团队</a></li>
        <?php } ?>
        <li <?php if ($select_sidebar == 'supplier') { ?>class="active"<?php } ?>><a href="<?php dourl('fx:supplier'); ?>">我的供货商</a></li>
        <li <?php if ($select_sidebar == 'contact_information') { ?>class="active"<?php } ?>><a href="<?php dourl('fx:contact_information'); ?>">联系我们</a></li>
		<li <?php if ($select_sidebar == 'seller_setting') { ?>class="active"<?php } ?>><a href="<?php dourl('fx:seller_setting'); ?>">分销配置</a></li>
		<li <?php if ($select_sidebar == 'fx_obtain_tpl') { ?>class="active"<?php } ?>><a href="<?php dourl('fx:fx_obtain_tpl'); ?>">获取证书</a></li>
        <!--<li <?php if ($select_sidebar == 'shop_promotion') { ?>class="active"<?php } ?>><a href="<?php dourl('fx:shop_promotion'); ?>">推广配置</a></li>-->
    </ul>
    <?php }else if ($_SESSION['store']['drp_level'] == 0) { // 供货商显示?>
    <ul>
        <li><h4>我是供货商</h4></li>
    </ul>
    <ul>
      <?php if(in_array(PackageConfig::getRbacId(14,'fx','distribution_index'), $rbac_result) || $package_id == 0){?>
        <li <?php if ($select_sidebar == 'distribution_index') { ?>class="active"<?php } ?>><a href="<?php dourl('fx:distribution_index'); ?>">分销统计</a></li>
      <?php } ?> 
      <?php if(in_array(PackageConfig::getRbacId(14,'fx','distribution'), $rbac_result) || $package_id == 0){?>   
        <li <?php if ($select_sidebar == 'distribution') { ?>class="active"<?php } ?>><a href="<?php dourl('fx:distribution'); ?>">分销/团队排名</a></li>
      <?php } ?>

      <?php if(in_array(PackageConfig::getRbacId(14,'fx','seller_order'), $rbac_result) || $package_id == 0){?>
        <li <?php if ($select_sidebar == 'seller_order') { ?>class="active"<?php } ?>><a href="<?php dourl('fx:seller_order'); ?>">分销商订单</a></li>
      <?php } ?>  

      <?php if(in_array(PackageConfig::getRbacId(14,'fx','wholesale_order'), $rbac_result) || $package_id == 0){?>
        <?php if(empty($version) && !empty($allow_platform_drp)){?>
        <li <?php if ($select_sidebar == 'wholesale_order') { ?>class="active"<?php } ?>><a href="<?php dourl('fx:wholesale_order'); ?>">经销商订单</a></li>
        <?php } ?>
      <?php } ?> 
        
      <?php if(in_array(PackageConfig::getRbacId(14,'fx','my_team'), $rbac_result) || $package_id == 0){?>
        <?php if ($open_drp_team) { ?>
        <li <?php if ($select_sidebar == 'my_team') { ?>class="active"<?php } ?>><a href="<?php dourl('fx:my_team'); ?>">我的团队</a></li>
        <?php } ?>
      <?php } ?>
       
      <?php if(in_array(PackageConfig::getRbacId(14,'fx','seller'), $rbac_result) || $package_id == 0){?> 
        <li <?php if ($select_sidebar == 'seller') { ?>class="active"<?php } ?>><a href="<?php dourl('fx:seller'); ?>">我的分销商</a></li>
      <?php } ?> 

      <?php if(in_array(PackageConfig::getRbacId(14,'fx','agency'), $rbac_result) || $package_id == 0){?> 
        <?php if(empty($version) && !empty($allow_platform_drp)){?>
        <li <?php if ($select_sidebar == 'agency') { ?>class="active"<?php } ?>><a href="<?php dourl('agency'); ?>">我的经销商</a></li>
        <?php } ?>
      <?php } ?>
        
      <?php if(in_array(PackageConfig::getRbacId(14,'fx','supplier_market'), $rbac_result) || $package_id == 0){?> 
        <li <?php if ($select_sidebar == 'supplier_market') { ?>class="active"<?php } ?>><a href="<?php dourl('fx:supplier_market'); ?>">本店商品</a></li>
      <?php } ?> 

      <?php if(in_array(PackageConfig::getRbacId(15,'fx','whole_setting'), $rbac_result) || $package_id == 0){?> 
        <?php if(empty($version) && !empty($allow_platform_drp)){?>
            <li <?php if ($select_sidebar == 'whole_setting') { ?>class="active"<?php } ?>><a href="<?php dourl('fx:whole_setting'); ?>">批发配置</a></li>
        <?php }?>
      <?php } ?>
        
      <?php if(in_array(PackageConfig::getRbacId(14,'fx','degree'), $rbac_result) || $package_id == 0){?>
        <?php if (option('config.open_drp_degree')) { ?>
        <li <?php if ($select_sidebar == 'degree') { ?>class="active"<?php } ?>><a href="<?php dourl('fx:degree'); ?>">分销等级</a></li>
        <?php } ?>
      <?php } ?>
        
    <?php if(in_array(PackageConfig::getRbacId(14,'fx','setting'), $rbac_result) || $package_id == 0){?>
        <li <?php if ($select_sidebar == 'setting') { ?>class="active"<?php } ?>><a href="<?php dourl('fx:setting'); ?>">分销配置</a></li>
    <?php } ?>

    <?php if(in_array(PackageConfig::getRbacId(14,'fx','contact_information'), $rbac_result) || $package_id == 0){?>
        <li <?php if ($select_sidebar == 'contact_information') { ?>class="active"<?php } ?>><a href="<?php dourl('fx:contact_information'); ?>">联系我们</a></li>
    <?php } ?>

    <?php if(in_array(PackageConfig::getRbacId(14,'fx','dividends_setting'), $rbac_result) || $package_id == 0){?>
        <li <?php if ($select_sidebar == 'dividends_setting') { ?>class="active"<?php } ?>><a href="<?php dourl('fx:dividends_setting'); ?>">奖金分红设置</a></li>
    <?php } ?>
    <?php if(in_array(PackageConfig::getRbacId(14,'fx','aptitude_tpl'), $rbac_result) || $package_id == 0){?>
            <li <?php if ($select_sidebar == 'aptitude_tpl') { ?>class="active"<?php } ?>><a href="<?php dourl('fx:aptitude_tpl'); ?>">资质模板</a></li>
    <?php } ?>

    </ul>
        <?php if(empty($version) && !empty($allow_platform_drp)){ // v.meihua 不显示 我是经销商?>
       
        <?php if(in_array(15, $rbac_val) || $package_id == 0):?>
          <ul>
              <li><h4>我是经销商</h4></li>
          </ul>
        <?php endif;?>
        <ul>
            
    <?php if(in_array(PackageConfig::getRbacId(15,'fx','wholesale_market'), $rbac_result) || $package_id == 0){?>
            <li <?php if ($select_sidebar == 'wholesale_market') { ?>class="active"<?php } ?>><a href="<?php dourl('fx:wholesale_market'); ?>">批发市场</a></li>
    <?php } ?>
    <?php if(in_array(PackageConfig::getRbacId(15,'fx','my_wholesale'), $rbac_result) || $package_id == 0){?>
            <li <?php if ($select_sidebar == 'my_wholesale') { ?>class="active"<?php } ?>><a href="<?php dourl('fx:my_wholesale'); ?>">我卖的商品</a></li>
    <?php } ?>
    <?php if(in_array(PackageConfig::getRbacId(15,'fx','my_supplier'), $rbac_result) || $package_id == 0){?>
            <li <?php if ($select_sidebar == 'my_supplier') { ?>class="active"<?php } ?>><a href="<?php dourl('fx:my_supplier'); ?>">我的供货商</a></li>
    <?php } ?>
    <?php if(in_array(PackageConfig::getRbacId(15,'fx','my_order'), $rbac_result) || $package_id == 0){?>
            <li <?php if ($select_sidebar == 'my_order') { ?>class="active"<?php } ?>><a href="<?php dourl('fx:my_order'); ?>">我的订单</a></li>
    <?php } ?>
        </ul>
        <?php }?>
    <?php } ?>
    <ul>
        <li><h4>推广管理</h4></li>
    </ul>
    <ul>
    <?php if(in_array(PackageConfig::getRbacId(14,'fx','shop_promotion'), $rbac_result) || $package_id == 0){?>
        <li <?php if ($select_sidebar == 'shop_promotion') { ?>class="active"<?php } ?>><a href="<?php dourl('promotional:index'); ?>">推广海报设置</a></li>
    <?php } ?>
</nav>
</aside>