<?php $select_sidebar=isset($select_sidebar)?$select_sidebar:ACTION_NAME;?>
<style type="text/css">
    .ui-sidebar ul li a i.warn {font-size: 12px; height:16px;color:#fff;line-height:16px;border-radius:8px;background:#f00;padding-left:5px;padding-right:5px;font-style: normal;}
</style>
<aside class="ui-sidebar sidebar" style="min-height: 500px;">
    <nav>
    <?php if ($user_session['type'] == 0): ?>
	<!-- 店主 -->
        <?php if(in_array(16, $rbac_val) || $package_id == 0):?>
        <h4>门店仓库管理</h4>
        <?php endif;?>
        <ul>
            <?php if(in_array(PackageConfig::getRbacId(16,'substore','store_list'), $rbac_result) || $package_id == 0){?>
            <li <?php if ($select_sidebar == 'store_list') { ?>class="active"<?php } ?>><a href="<?php dourl('substore:store_list'); ?>">门店管理</a></li>
            <?php } ?>
            
            <?php if(in_array(PackageConfig::getRbacId(16,'substore','set_admin'), $rbac_result) || $package_id == 0){?>
            <li <?php if ($select_sidebar == 'set_admin') { ?>class="active"<?php } ?>><a href="<?php dourl('substore:set_admin'); ?>">门店管理员</a></li>
            <?php } ?>

            
            <?php if(in_array(PackageConfig::getRbacId(16,'goods','create'), $rbac_result) || $package_id == 0){?>
            <li><a href="<?php dourl('goods:create');?>" target="_blank">发布商品</a></li>
            <?php } ?>

            
            <?php if(in_array(PackageConfig::getRbacId(16,'substore','set_stock'), $rbac_result) || $package_id == 0){?>
            <li <?php if ($select_sidebar == 'set_stock') { ?>class="active"<?php } ?>><a href="<?php dourl('substore:set_stock'); ?>">商品库存</a></li>
            <?php } ?>

            <?php if(in_array(PackageConfig::getRbacId(16,'substore','warn_stock'), $rbac_result) || $package_id == 0){?>
            <li <?php if ($select_sidebar == 'warn_stock') { ?>class="active"<?php } ?>>
                <a href="<?php dourl('substore:warn_stock'); ?>">
                    库存报警
                    <?php if ($warn_stock > 0) { ?>
                    <i class="warn"><?php echo $warn_stock; ?></i>
                    <?php } ?>
                </a></li>
             <?php } ?>

            
            <?php if(in_array(PackageConfig::getRbacId(16,'substore','statistic'), $rbac_result) || $package_id == 0){?>
            <li <?php if ($select_sidebar == 'statistic') { ?>class="active"<?php } ?>><a href="<?php dourl('substore:statistic'); ?>">销售统计</a></li>
            <?php } ?>

        </ul>
        <?php if(in_array(17, $rbac_val) || $package_id == 0):?>
        <h4>物流配送管理</h4>
        <?php endif;?> 
        <ul>
        <?php if(in_array(PackageConfig::getRbacId(17,'substore','order'), $rbac_result) || $package_id == 0){?>
            <li <?php if ($select_sidebar == 'order') { ?>class="active"<?php } ?>><a href="<?php dourl('substore:order'); ?>">订单</a></li>
        <?php } ?>
        <?php if(in_array(PackageConfig::getRbacId(17,'substore','courier'), $rbac_result) || $package_id == 0){?>
            <li <?php if ($select_sidebar == 'courier') { ?>class="active"<?php } ?>><a href="<?php dourl('substore:courier'); ?>">配送员管理</a></li>
        <?php } ?>
        <?php if(in_array(PackageConfig::getRbacId(17,'substore','logistic_config'), $rbac_result) || $package_id == 0){?>
            <li <?php if ($select_sidebar == 'logistic_config') { ?>class="active"<?php } ?>><a href="<?php dourl('substore:logistic_config'); ?>">物流配置</a></li>
        <?php } ?>
        <?php if(in_array(PackageConfig::getRbacId(17,'substore','delivery'), $rbac_result) || $package_id == 0){?>
            <li <?php if ($select_sidebar == 'delivery') { ?>class="active"<?php } ?>><a href="<?php dourl('substore:delivery'); ?>">物流工具</a></li>
        <?php } ?>
        <?php if(in_array(PackageConfig::getRbacId(17,'substore','wxbind'), $rbac_result) || $package_id == 0){?>
            <li <?php if ($select_sidebar == 'wxbind') { ?>class="active"<?php } ?>><a href="<?php dourl('substore:wxbind'); ?>">微信绑定</a></li>
        <?php } ?>

        </ul>
    <?php else: ?>
    <!-- 门店管理员 -->
        <h4>门店仓库管理</h4>
        <ul>
            <li <?php if ($select_sidebar == 'store_config') { ?>class="active"<?php } ?>><a href="<?php dourl('substore:store_config'); ?>">门店配置</a></li>
            <li <?php if ($select_sidebar == 'stock') { ?>class="active"<?php } ?>><a href="<?php dourl('substore:stock'); ?>">商品库存</a></li>
            <li <?php if ($select_sidebar == 'statistic') { ?>class="active"<?php } ?>><a href="<?php dourl('substore:statistic'); ?>">销售统计</a></li>
            <li <?php if ($select_sidebar == 'warn_stock') { ?>class="active"<?php } ?>>
                <a href="<?php dourl('substore:warn_stock'); ?>">
                    库存报警
                    <?php if ($warn_stock > 0) { ?>
                    <i class="warn"><?php echo $warn_stock; ?></i>
                    <?php } ?>
                </a></li>
        </ul>
        <h4>物流配送管理</h4>
        <ul>
            <li <?php if ($select_sidebar == 'store_order') { ?>class="active"<?php } ?>><a href="<?php dourl('substore:store_order'); ?>">本店订单</a></li>
            <li <?php if ($select_sidebar == 'package_list') { ?>class="active"<?php } ?>><a href="<?php dourl('substore:package_list'); ?>">本店包裹</a></li>
            <li <?php if ($select_sidebar == 'courier') { ?>class="active"<?php } ?>><a href="<?php dourl('substore:courier'); ?>">配送员管理</a></li>
        </ul>
    <?php endif; ?>
    </nav>
</aside>