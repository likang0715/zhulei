<?php
$version      = option('config.weidian_version');
$select_sidebar=isset($select_sidebar) ? $select_sidebar : ACTION_NAME;
$uid = $user_session['physical_uid'];

if ($user_session['type'] == 1) {

    function checkIsShow($action_id, $uid, $controller_id = MODULE_NAME){

        if ($action_id == 'create') return false;

        $physicalRbac = M("Rbac_action")->getControlArr($uid, $controller_id);
        if (in_array($action_id, $physicalRbac)) return true;

        return false;
    }

} else {
    function checkIsShow(){
        return true;
    }
}
//
?>
<aside class="ui-sidebar sidebar">
<nav>
    <ul>
        <?php if(in_array(8, $rbac_result) || $package_id == 0){?>
        
            <?php if (checkIsShow('dashboard', $uid, 'order')) { ?>
            <li <?php if(in_array($select_sidebar,array('dashboard','statistics'))) echo 'class="active"';?>>
                <a href="<?php dourl('order:dashboard');?>">订单概况</a>
            </li>
            <?php } ?>
            <?php if (checkIsShow('all', $uid, 'order')) { ?>
            <li <?php if($select_sidebar == 'all') echo 'class="active"';?>>
                <a href="<?php dourl('order:all');?>">所有订单</a>
            </li>
            <?php } ?>
            <?php if (!empty($_SESSION['drp_diy_store'])) { ?>

                <?php if (checkIsShow('selffetch', $uid, 'order')) { ?>
                <li <?php if($select_sidebar == 'selffetch') echo 'class="active"';?>>
                    <a href="<?php dourl('order:selffetch'); ?>"><?php echo $store_session['buyer_selffetch_name'] ? $store_session['buyer_selffetch_name'] : '到店自提' ?>订单</a>
                </li>
                <?php } ?>
                
                <?php if(empty($version) && empty($_SESSION['sync_store'])){?>
                <?php if (checkIsShow('codpay', $uid, 'order')) { ?>
                <li <?php if($select_sidebar == 'codpay') echo 'class="active"';?>>
                    <a href="<?php dourl('order:codpay'); ?>">货到付款订单</a>
                </li>
                <?php } ?>
                <?php } ?>
            <?php } ?>
            <?php if (checkIsShow('order_return', $uid, 'order')) { ?>
            <li <?php if($select_sidebar == 'order_return') echo 'class="active"';?>>
                <a href="<?php dourl('order:order_return'); ?>">退货列表</a>
            </li>
            <?php } ?>
            
            <?php if (checkIsShow('order_rights', $uid, 'order')) { ?>
            <li <?php if($select_sidebar == 'order_rights') echo 'class="active"';?>>
                <a href="<?php dourl('order:order_rights'); ?>">维权列表</a>
            </li>
            <?php } ?>
        <?php } ?>
        
        <?php if(in_array(PackageConfig::getRbacId(8,'order','star'), $rbac_result) || $package_id == 0){?>
            <?php if (checkIsShow('star', $uid, 'order')) { ?>
            <li <?php if($select_sidebar == 'star') echo 'class="active"';?>>
                <a href="<?php dourl('order:star'); ?>">加星订单</a>
            </li>
            <?php } ?>
        <?php } ?>

        <?php if(in_array(PackageConfig::getRbacId(8,'order','activity'), $rbac_result) || $package_id == 0){?>
            <?php if (checkIsShow('activity', $uid, 'order')) { ?>
            <li <?php if($select_sidebar == 'activity') echo 'class="active"';?>>
                <a href="<?php dourl('order:activity'); ?>">活动订单</a>
            </li>
            <?php } ?>
        <?php } ?>
    </ul>
    <ul>
    <?php if(in_array(8, $rbac_result) || $package_id == 0){?>
        <?php if (checkIsShow('delivery', $uid, 'trade')) { ?>
            <?php if (!empty($_SESSION['drp_diy_store'])) { ?>
                <li <?php if($select_sidebar == 'delivery') echo 'class="active"';?>>
                    <a href="<?php dourl('trade:delivery');?>">物流工具</a>
                </li>
            <?php } ?>
        <?php } ?>
    <?php } ?>
    </ul>
    <ul>
    <?php if(in_array(PackageConfig::getRbacId(8,'order','add'), $rbac_result) || $package_id == 0){?>
        <?php if (checkIsShow('add', $uid, 'order')) { ?>
            <?php if (!empty($_SESSION['drp_diy_store'])) { ?>
                <li <?php if(in_array($select_sidebar,array('add'))) echo 'class="active"';?>><a href="<?php dourl('order:add');?>">添加订单</a></li>
            <?php } ?>
        <?php } ?>
    <?php } ?>
    </ul>
    <ul>
    <?php if(option('credit.platform_credit_open') && (in_array(8, $rbac_result) || $package_id == 0)){?>
        <?php if (checkIsShow('add', $uid, 'order')) { ?>
            <?php if (!empty($_SESSION['drp_diy_store'])) { ?>
                
                
                <?php if(in_array(PackageConfig::getRbacId(8,'offline','offline_list'), $rbac_result)){?>
                <li <?php if(in_array($select_sidebar, array('offline_list'))) echo 'class="active"';?>><a href="<?php dourl('offline:offline_list');?>">商家做单管理</a></li>
                <?php } ?>
                <?php if(in_array(PackageConfig::getRbacId(8,'offline','offline_index'), $rbac_result)){?>
                <li <?php if(in_array($select_sidebar, array('offline_index'))) echo 'class="active"';?>><a href="<?php dourl('offline:offline_index');?>">商家线下做单</a></li>
                <?php } ?>

            <?php } ?>
        <?php } ?>
    <?php } ?>
    </ul>
    <ul>
    <?php if(in_array(PackageConfig::getRbacId(8,'order','orderprint'), $rbac_result) || $package_id == 0){?>
        <?php if (checkIsShow('orderprint', $uid)) { ?>
            <?php if (!empty($_SESSION['drp_diy_store'])) { ?>
                <li <?php if(in_array($select_sidebar,array('orderprint'))) echo 'class="active"';?>><a href="<?php dourl('order:orderprint');?>">订单打印机</a></li>
            <?php } ?>
        <?php } ?>
    <?php } ?>
    </ul>
    <?php if(in_array(9, $rbac_result) || $package_id == 0){?>
    <h4>账务管理</h4>
    <?php } ?>
    <ul>
        
    <?php if(in_array(PackageConfig::getRbacId(9,'trade','income'), $rbac_result) || $package_id == 0){?>
        <li <?php if($select_sidebar == 'income') echo 'class="active"';?>><a href="<?php dourl('trade:income');?>">账务概况</a></li>
    <?php } ?>

        <?php if (empty($_SESSION['store']['drp_supplier_id'])) { ?>
            
            <?php if(in_array(PackageConfig::getRbacId(9,'order','check'), $rbac_result) || $package_id == 0){?>
            <li <?php if($select_sidebar == 'check') echo 'class="active"';?>><a href="<?php dourl('order:check');?>">平台对账</a></li>
            <?php } ?>

             <?php if(in_array(PackageConfig::getRbacId(9,'order','seller_check'), $rbac_result) || $package_id == 0){?>
                <?php if (!empty($allow_store_drp)) { ?>
                <li <?php if($select_sidebar == 'seller_check') echo 'class="active"';?>><a href="<?php dourl('order:seller_check');?>">分销商对账</a></li>
                <?php } ?>
             <?php } ?>


            <?php if (empty($version) && !empty($allow_platform_drp)) { ?>
            
             <?php if(in_array(PackageConfig::getRbacId(9,'order','supplier_check'), $rbac_result) || $package_id == 0){?>
                <li <?php if($select_sidebar == 'supplier_check') echo 'class="active"';?>><a href="<?php dourl('order:supplier_check');?>">供货商对账</a></li>
             <?php } ?>

            <?php if(in_array(PackageConfig::getRbacId(9,'order','dealer_check'), $rbac_result) || $package_id == 0){?>
                 <li <?php if($select_sidebar == 'dealer_check') echo 'class="active"';?>><a href="<?php dourl('order:dealer_check'); ?>">经销商对账</a></li>
            <?php } ?>


            <?php } ?>
        <?php } ?>

        <?php if (!empty($_SESSION['store']['drp_supplier_id'])) { ?>
        <li <?php if($select_sidebar == 'profit_check') echo 'class="active"';?>><a href="<?php dourl('order:profit_check'); ?>">分佣对账</a></li>
        <?php } ?>
    </ul>
</nav>
</aside>