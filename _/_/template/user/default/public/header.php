<?php $select_nav   = isset($select_nav)?$select_nav:MODULE_NAME;?>
<?php $version      = option('config.weidian_version');?>
<?php $wd_version   = option('config.weidian_version_type');?>
<?php if($_SESSION['store']['is_point_mall']!=1) {?>
<!-- ▼ First Sidebar -->
<script type="text/javascript" src="<?php echo STATIC_URL;?>/prettify/prettify.js"></script>
<script type="text/javascript" src="<?php echo STATIC_URL;?>/prettify/jquery.slimscroll.js"></script>
<script type="text/javascript">
function sidebarScroll () {
    $('#second-sidebar-nav').slimscroll({height: 'auto',size: '0px',railVisible: false,opacity: .2,wheelStep: 5, });
    $('#sidebar-con').slimscroll({height: 'auto',size: '0px',railVisible: false,opacity: .2,wheelStep: 5, color: '#fff', });
}
$(document).ready(function() {
    sidebarScroll ();
    $(window).on("resize",sidebarScroll);
});
</script>
<div id="first-sidebar" class="rel unselect">
    <div class="clearfix" style="height: 100%;">
        <h1 id="sidebar_logo" title="<?php echo $config['site_name'];?>">
            <a href="/">
                <img src="../images/logo_white.png" alt="<?php echo $config['site_name'];?>"/>
            </a>
        </h1>
        <div class="first-sidebar-box">
            <nav class="ui-header-nav" id="sidebar-con">
                <ul class="clearfix">
                    <li <?php if(in_array($select_nav,array('case','index', 'index'))) echo 'class="active"';?>>
                        <a href="<?php dourl('index:index');?>">
                            <i class="sidebar-icon sidebar-icon-index"></i>
                            <span>概览</span>
                        </a>
                    </li>
                    <?php if(in_array(1, $rbac_val) || $package_id == 0):?>
                    <li <?php if(in_array($select_nav,array('case','store'))) echo 'class="active"';?>>
                        <a href="<?php dourl('store:index');?>">
                            <i class="sidebar-icon sidebar-icon-store"></i>
                            <span>店铺</span>
                        </a>
                    </li>
                    <?php endif;?>

                    <?php if(in_array(7, $rbac_val) || $package_id == 0):?>
                    <?php if (!empty($_SESSION['drp_diy_store'])) { ?>
                    <li <?php if($select_nav == 'goods') echo 'class="active"';?>>
                        <a href="<?php dourl('goods:index');?>">
                            <i class="sidebar-icon sidebar-icon-goods"></i>
                            <span>商品</span>
                        </a>
                    </li>
                    <?php } ?>
                    <?php endif;?>

                    <li <?php if(in_array($select_nav,array('meal','index'))) echo 'class="active"';?> >
                        <a href="<?php dourl('meal:index');?>">
                            <i class="sidebar-icon sidebar-icon-meal"></i>
                            <span>订座</span>
                        </a>
                    </li>

                    <li <?php if(in_array($select_nav,array('events','index'))) echo 'class="active"';?> >
                        <a href="<?php dourl('events:index');?>">
                            <i class="sidebar-icon sidebar-icon-events"></i>
                            <span>茶会</span>
                        </a>
                    </li>

                    <?php if(in_array(8, $rbac_val) || $package_id == 0):?>
                    <li <?php if(in_array($select_nav,array('order'))) echo 'class="active"';?> >
                        <a href="<?php dourl('order:dashboard');?>">
                            <i class="sidebar-icon sidebar-icon-order"></i>
                            <span>订单</span>
                        </a>
                    </li>
                    <?php endif;?>
                    <li <?php if(in_array($select_nav,array('trade'))) echo 'class="active"';?> >
                        <a href="<?php dourl('trade:income');?>">
                            <i class="sidebar-icon sidebar-icon-trade"></i>
                            <span>财务</span>
                        </a>
                    </li>
                    <?php if(in_array(10, $rbac_val) || $package_id == 0):?>
                    <?php if (!empty($_SESSION['drp_diy_store'])) { ?>
                    <?php if(empty($version) && empty($_SESSION['sync_store'])){?>
                    <li class="<?php if(in_array($select_nav,array('fans'))) echo 'active';?>" >
                        <a href="<?php echo dourl('fans:statistic'); ?>">
                            <i class="sidebar-icon sidebar-icon-vip"></i>
                            <span>会员</span>
                        </a>
                    </li>
                    <?php }?>
                    <?php }?>
                    <?php endif;?>

                    <?php if($user_session['type']!=1):?>
                    <?php if (!empty($_SESSION['drp_diy_store'])) { ?>
                    <?php if(empty($version) && empty($_SESSION['sync_store'])){?>
                    <?php if(in_array(11, $rbac_val) || in_array(12, $rbac_val) || $package_id == 0):?>
                    <li <?php if(in_array($select_nav,array('appmarket','reward','preferential','wxapp'))) echo 'class="active"';?> >
                        <?php if($package_id == 0): ?>
                        <a href="<?php echo dourl('appmarket:present'); ?>">
                            <i class="sidebar-icon sidebar-icon-marketing"></i>
                            <span>营销</span>
                        </a>
                        <?php else:?>
                        <a href="<?php echo PackageConfig::setDefaultLink(array(11,12),$rbac_val); ?>">
                            <i class="sidebar-icon sidebar-icon-marketing"></i>
                            <span>营销</span>
                        </a>
                        <?php endif;?>
                    </li>
                    <?php endif;?>
                    <li <?php if(in_array($select_nav,array('setting','account'))) echo 'class="active"';?> >
                        <a href="<?php echo dourl('setting:store'); ?>">
                            <i class="sidebar-icon sidebar-icon-setting"></i>
                            <span>设置</span>
                        </a>
                    </li>
                    <li class="usertips" style="display:none">
                        <a href="javascript:void(0)" class="mycenter" title="<?php echo $store_session['name']; ?>">
                            <span class="usertips-store"><?php echo $store_session['name']; ?></span> <span class="usertips-setting">- 设置</span>
                        </a>
                        <div class="downmenu1">
                            <ul class="userlinks">
                                <?php if(in_array(13, $rbac_val) || $package_id == 0):?>
                                    <li>
                                        <a href="<?php echo dourl('store:select'); ?>" class="links1">微信设置</a>
                                    </li>
                                <?php endif;?>
                                <?php } ?>
                                <?php } ?>
                                <?php endif;?>
                                <?php if (!empty($store_session['update_drp_store_info']) && $store_session['drp_level'] >0 || $store_session['drp_level'] == 0){?>
                                <li><a href="<?php echo dourl('setting:store'); ?>" class="links2">店铺设置</a></li>
                                <li><a href="<?php echo dourl('account:company'); ?>" class="links3">公司设置</a></li>
                                <?php } ?>
                                <li><a href="<?php echo dourl('account:personal'); ?>" class="links4">帐号设置</a></li>
                                
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<!-- ▲ First Sidebar1 -->
<!-- ▼ Top Bar -->
<div id="top_bar">
    <div class="user_info">
        <i class="user_line"></i>
        <i class="user-icon user-icon-name"></i>
        <div class="user_box usertips">
            <a href="javascript:void(0)" class="mycenter" title="<?php echo $store_session['name']; ?>">
                <span class="usertips-store"><?php echo $store_session['name']; ?></span>
            </a>
            <ul class="downmenu1">
                <li><a href="<?php echo dourl('account:personal'); ?>">帐号资料</a></li>
                <li><a href="<?php echo dourl('store:select'); ?>">切换店铺</a></li>
                <?php if(empty($version) && empty($_SESSION['sync_store'])){?>
                <li><a href="<?php echo dourl('user:logout'); ?>">退出登录</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="shortcut_info">
        <ul>
            <li>
                <a href="#">旧版的</a>
            </li>
            <li>
                <a href="#">旧版的</a>
            </li>
        </ul>
    </div>
</div>
<!-- ▲ Top Bar -->
<?php } else {?>
<!-- ▼ Sidebar -->
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
<!-- ▲ Sidebar -->
<?php }?>
<script type="text/javascript">
$(function() {
    if ("<?php echo !empty($open_store) ? $open_store : ''; ?>" == '') {
        window.location.href = '<?php echo $store_select; ?>';
    }
})
</script>