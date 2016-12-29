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
<aside class="ui-sidebar sidebar">
<nav>
    <?php if (!empty($_SESSION['drp_diy_store'])) { ?>
        
        <?php if(in_array(7, $rbac_result) || $package_id == 0){?>
            <?php if (checkIsShow('create', $uid)) { ?>
            <ul>
                <li>
                    <a class="ui-btn ui-btn-success" href="<?php dourl('create');?>">发布商品</a>
                </li>
            </ul>
            <?php } ?>
        
            <h4>商品管理</h4>
        <?php } ?>
        <ul>
        <?php if(in_array(7, $rbac_result) || $package_id == 0){?>
            <?php if (checkIsShow('index', $uid)) { ?>
            <li <?php if($select_sidebar == 'index') echo 'class="active"';?>>
                <a href="<?php dourl('index');?>">出售中的商品</a>
            </li>
            <?php } ?>

            <?php if (checkIsShow('stockout', $uid)) { ?>
            <li <?php if($select_sidebar == 'stockout') echo 'class="active"';?>>
                <a href="<?php dourl('stockout'); ?>">已售罄的商品</a>
            </li>
            <?php } ?>

            <?php if (checkIsShow('soldout', $uid)) { ?>
            <li <?php if($select_sidebar == 'soldout') echo 'class="active"';?>>
                <a href="<?php dourl('soldout'); ?>">仓库中的商品</a>
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
        </ul>
        <?php if(in_array(PackageConfig::getRbacId(7,'goods','product_comment'), $rbac_result) || $package_id == 0 || in_array(PackageConfig::getRbacId(7,'goods','store_comment'), $rbac_result)){?>
        <h4>评论管理</h4>
        <?php } ?>

        <ul>
        <?php if(in_array(PackageConfig::getRbacId(7,'goods','product_comment'), $rbac_result) || $package_id == 0){?>
            <?php if (checkIsShow('product_comment', $uid)) { ?>
            <li <?php if($select_sidebar == 'product_comment') echo 'class="active"';?>>
                <a href="<?php dourl('product_comment');?>">商品评价</a>
            </li>
            <?php } ?>
        <?php } ?>
        
        <?php if(in_array(PackageConfig::getRbacId(7,'goods','store_comment'), $rbac_result) || $package_id == 0){?>
            <?php if(($wd_version == 8 || $wd_version == 4) || (empty($_SESSION['sync_store']) && empty($version))){?>

                <?php if (checkIsShow('store_comment', $uid)) { ?>
                <li <?php if($select_sidebar == 'store_comment') echo 'class="active"';?>>
                    <a href="<?php dourl('store_comment'); ?>">店铺评价</a>
                </li>
                <?php } ?>
            <?php } ?>
        <?php } ?>
        </ul>
        
        <?php if(in_array(PackageConfig::getRbacId(7,'goods','subject'), $rbac_result) || $package_id == 0){?>

        <h4>导购管理</h4>
        <?php if (checkIsShow('subject', $uid)) { ?>
        <li <?php if($select_sidebar == 'subject' || $select_sidebar == 'subtype' || $select_sidebar == 'subject_pinlun' || $select_sidebar == 'subject_diy') echo 'class="active"';?>>
             <a href="<?php dourl('subject'); ?>">导购专题</a>
        </li>
        <?php } ?>

        <?php } ?>
        


        <?php if($user_session['type']==1): ?>
        <!-- <h4>门店管理</h4>
        <ul>
            <li <?php if($select_sidebar == 'physical_stock') echo 'class="active"';?>>
                <a href="<?php dourl('physical_stock');?>">库存</a>
            </li>
        </ul> -->
        <?php endif; ?>
    <?php } ?>
</nav>
</aside>