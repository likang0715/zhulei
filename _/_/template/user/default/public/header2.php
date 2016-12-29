<?php $select_nav   = isset($select_nav)?$select_nav:MODULE_NAME;?>
<?php $version      = option('config.weidian_version');?>
<?php $wd_version   = option('config.weidian_version_type');?>
<style type="text/css">
/*全隐藏*/
.usertips-store {
    width: 90px;
    display:inline-block;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
    text-align: right;
}
.mycenter {
    display: inline-block;
}
.usertips-setting {
    display: inline-block;
    overflow: hidden;
}
</style>
<?php if($_SESSION['store']['is_point_mall']!=1) {?>
<div id="hd" class="wrap rel">
    <div class="wrap_1000 clearfix">
        <h1 id="hd_logo" class="abs" title="<?php echo $config['site_name'];?>">
            <a href="<?php dourl('store:select');?>">
                <img src="../images/logo_white.png" height="50" alt="<?php echo $config['site_name'];?>" style="height:50px;width:auto;max-width:none;"/>
            </a>
        </h1>
        <nav class="ui-header-nav">
            <ul class="clearfix">
                <?php if(in_array(1, $rbac_val) || $package_id == 0):?>
                <li <?php if(in_array($select_nav,array('case','store', 'setting'))) echo 'class="active"';?>>
                    <a href="<?php dourl('store:index');?>">店铺</a>
                </li>
                <li class="divide">|</li>
            <?php endif;?>

            <?php if(in_array(7, $rbac_val) || $package_id == 0):?>
            <?php if (!empty($_SESSION['drp_diy_store'])) { ?>
            <li <?php if($select_nav == 'goods') echo 'class="active"';?>>
                <a href="<?php dourl('goods:index');?>">商品</a>
            </li>
            <li class="divide">|</li>
            <?php } ?>
        <?php endif;?>
        <li <?php if(in_array($select_nav,array('meal','index'))) echo 'class="active"';?> ><a href="<?php dourl('meal:index'); ?>">订座</a></li>
        <li class="divide">|</li>
        <li <?php if(in_array($select_nav,array('events','index'))) echo 'class="active"';?> ><a href="<?php dourl('events:index'); ?>">茶会</a></li>
        <li class="divide">|</li>

        <?php if(in_array(8, $rbac_val) || $package_id == 0):?>
        <li <?php if(in_array($select_nav,array('order','trade'))) echo 'class="active"';?> >
            <a href="<?php echo dourl('order:dashboard'); ?>">财务/订单</a>
        </li>
        <li class="divide">|</li>
    <?php endif;?>

    <?php if(in_array(10, $rbac_val) || $package_id == 0):?>
    <?php if (!empty($_SESSION['drp_diy_store'])) { ?>
    <?php if(empty($version) && empty($_SESSION['sync_store'])){?>
    <li class="<?php if(in_array($select_nav,array('fans'))) echo 'active';?>" >
        <a href="<?php echo dourl('fans:member'); ?>">会员管理</a>
    </li>
    <li class="divide">|</li>
    <?php }?>
    <?php }?>
<?php endif;?>


<?php if($user_session['type']!=1):?>
    <?php if (!empty($_SESSION['drp_diy_store'])) { ?>
    <?php if(empty($version) && empty($_SESSION['sync_store'])){?>

    <?php if(in_array(11, $rbac_val) || in_array(12, $rbac_val) || $package_id == 0):?>
    <li <?php if(in_array($select_nav,array('appmarket','reward','preferential','wxapp'))) echo 'class="active"';?> >
        <?php if($package_id == 0): ?>
        <a href="<?php echo dourl('appmarket:present'); ?>">应用营销</a>
    <?php else:?>
    <a href="<?php echo PackageConfig::setDefaultLink(array(11,12),$rbac_val); ?>">应用营销</a>
<?php endif;?>
</li>
<li class="divide">|</li>
<?php endif;?>


<?php if(in_array(13, $rbac_val) || $package_id == 0):?>
    <li class="js-weixin-notify <?php if($select_nav == 'weixin') echo 'active';?>">
        <a href="<?php echo dourl('weixin:info'); ?>">微信</a>
    </li>
    <!-- <li class="divide">|</li> -->
<?php endif;?>
<?php } ?>
<?php } ?>

<?php endif;?>
<li class="usertips">
    <a href="javascript:void(0)" class="mycenter" title="<?php echo $store_session['name']; ?>">
        <span class="usertips-store"><?php echo $store_session['name']; ?></span> <span class="usertips-setting">- 设置</span></a>
        <div class="downmenu1">
            <ul class="userlinks">
                <li><a href="<?php echo dourl('store:select'); ?>" class="links1">切换店铺</a></li>
                <?php if (!empty($store_session['update_drp_store_info']) && $store_session['drp_level'] >0 || $store_session['drp_level'] == 0){?>
                <li><a href="<?php echo dourl('setting:store'); ?>" class="links2">店铺设置</a></li>
                <li><a href="<?php echo dourl('account:company'); ?>" class="links3">公司设置</a></li>
                <?php } ?>
                <li><a href="<?php echo dourl('account:personal'); ?>" class="links4">帐号设置</a></li>
                <?php if(empty($version) && empty($_SESSION['sync_store'])){?>
                <li class="divide"></li>
                <li><a href="<?php echo dourl('user:logout'); ?>">退出登录</a></li>
                <?php } ?>
            </ul>
        </div>
    </li>
</ul>
</nav>
</div>
</div>
<?php } else {?>
<div id="hd" class="wrap rel">
    <div class="wrap_1000 clearfix">
        <h1 id="hd_logo" class="abs" title="<?php echo $config['site_name'];?>">
            <?php if($config['pc_shopercenter_logo'] != ''){?>
            <a href="<?php dourl('store:select');?>">
                <img src="<?php echo $config['pc_shopercenter_logo'];?>" height="35" alt="<?php echo $config['site_name'];?>" style="height:35px;width:auto;max-width:none;"/>
            </a>
            <?php }?>
        </h1>

        <nav class="ui-header-nav">
            <ul class="clearfix">
                <?php if($user_session['type']!=1):?>
                <li <?php if(in_array($select_nav,array('case','store', 'setting'))) echo 'class="active"';?>>
                    <a href="<?php dourl('store:index');?>">店铺</a>
                </li>   
            <?php endif;?>

            <?php if (!empty($_SESSION['drp_diy_store'])) { ?>
            <li class="divide">|</li>
            <li <?php if($select_nav == 'pointgoods') echo 'class="active"';?>>
                <a href="<?php dourl('pointgoods:index');?>">礼物/商品</a>
            </li> 
            <?php } ?>

            <li class="divide">|</li>
            <li <?php if(in_array($select_nav,array('pointorder','trade'))) echo 'class="active"';?> >
               <a href="<?php echo dourl('pointorder:dashboard'); ?>">财务/订单</a>
           </li>

           <li class="usertips">
            <a href="javascript:void(0)" class="mycenter"><?php echo $store_session['name']; ?> - 设置</a>
            <div class="downmenu1">
                <ul class="userlinks">
                    <li><a href="<?php echo dourl('store:select'); ?>" class="links1">切换店铺</a></li>
                    <?php if (!empty($store_session['update_drp_store_info']) && $store_session['drp_level'] >0 || $store_session['drp_level'] == 0){?>
                    <li><a href="<?php echo dourl('setting:store'); ?>" class="links2">店铺设置</a></li>
                    <li><a href="<?php echo dourl('account:company'); ?>" class="links3">公司设置</a></li>
                    <?php } ?>
                    <li><a href="<?php echo dourl('account:personal'); ?>" class="links4">帐号设置</a></li>
                    <?php if(empty($version) && empty($_SESSION['sync_store'])){?>
                    <li class="divide"></li>
                    <li><a href="<?php echo dourl('user:logout'); ?>">退出登录</a></li>
                    <?php } ?>
                </ul>
            </div>
        </li>
    </ul>
</nav>
</div>
</div>
<?php }?>
<script type="text/javascript">
$(function() {
    if ("<?php echo !empty($open_store) ? $open_store : ''; ?>" == '') {
        window.location.href = '<?php echo $store_select; ?>';
    }
})
</script>