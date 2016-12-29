<?php
$select_sidebar=isset($select_sidebar) ? $select_sidebar : ACTION_NAME;
$uid = $user_session['uid'];

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

?>
<?php $select_sidebar=isset($select_sidebar)?$select_sidebar:ACTION_NAME;?>
<!-- ▼ Second Sidebar -->
<aside class="ui-second-sidebar second-sidebar" id="second-sidebar">
    <div class="second-sidebar-title">
        财务管理
    </div>
    <nav class="second-sidebar-nav" id="second-sidebar-nav">
        <ul>
            <li <?php if($select_sidebar == 'income') echo 'class="active"';?>><a href="<?php dourl('trade:income');?>">账务概况</a></li>
            <?php if (empty($_SESSION['store']['drp_supplier_id'])) { ?>
            <li <?php if($select_sidebar == 'check') echo 'class="active"';?>><a href="<?php dourl('order:check'); ?>">平台对账</a></li>
            <!-- <li <?php if($select_sidebar == 'seller_check') echo 'class="active"';?>><a href="<?php dourl('order:seller_check');?>">分销商对账</a></li>
            <li <?php if($select_sidebar == 'supplier_check') echo 'class="active"';?>><a href="<?php dourl('order:supplier_check');?>">供货商对账</a></li>
            <li <?php if($select_sidebar == 'dealer_check') echo 'class="active"';?>><a href="<?php dourl('order:dealer_check'); ?>">经销商对账</a></li>
            <?php } ?>
            <?php if (!empty($_SESSION['store']['drp_supplier_id'])) { ?>
            <li <?php if($select_sidebar == 'profit_check') echo 'class="active"';?>><a href="<?php dourl('order:profit_check'); ?>">分佣对账</a></li>
            <?php } ?> -->
            <?php ?>
        </ul>
    </nav>
</aside>