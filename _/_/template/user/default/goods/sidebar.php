<?php 
$select_sidebar=isset($select_sidebar) ? $select_sidebar : ACTION_NAME;
$uid = $user_session['physical_uid'];
if ($user_session['type'] == 1) {
    function checkIsShow($action_id, $uid){

        $physicalRbac = M("Rbac_action")->getControlArr($uid, MODULE_NAME);
        if (in_array($action_id, $physicalRbac)) return true;

        return false;
    }
} else {
    function checkIsShow(){
        return true;
    }
}
?>
<aside class="ui-second-sidebar second-sidebar" id="second-sidebar">
    <div class="second-sidebar-title">
        商品管理
    </div>
    <nav class="second-sidebar-nav" id="second-sidebar-nav">
        <ul>
        <?php if (!empty($_SESSION['drp_diy_store'])) { ?>
        <?php if(in_array(7, $rbac_result) || $package_id == 0){?>
        <?php if (checkIsShow('index', $uid)) { ?>
        <li <?php if($select_sidebar == 'index' || $select_sidebar == 'stockout' || $select_sidebar == 'soldout' || $select_sidebar == 'edit') echo 'class="active"';?>>
            <a href="<?php dourl('index'); ?>">全部商品</a>
        </li>
        <?php } ?>
        <?php } ?>
        <?php if(in_array(PackageConfig::getRbacId(7,'goods','category'), $rbac_result) || $package_id == 0){?>
        <?php if (checkIsShow('category', $uid)) { ?>
        <li <?php if($select_sidebar == 'category') echo 'class="active"';?>>
            <a href="<?php dourl('category'); ?>">商品分组</a>
        </li>
        <?php } ?>
        <?php } ?>
        <?php } ?>
        </ul>
    </nav>
</aside>