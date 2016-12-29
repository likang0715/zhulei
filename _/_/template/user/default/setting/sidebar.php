<?php $select_sidebar=isset($select_sidebar)?$select_sidebar:ACTION_NAME;?>
<!-- ▼ Second Sidebar -->
<aside class="ui-second-sidebar second-sidebar" id="second-sidebar">
    <div class="second-sidebar-title">
        设置
    </div>
    <nav class="second-sidebar-nav" id="second-sidebar-nav">
        <ul>
            <li <?php if (in_array($select_nav,array('setting')) && $select_sidebar == 'store') { ?>class="active"<?php } ?>><a href="<?php echo dourl('setting:store'); ?>">店铺信息</a></li>
              
	        <li <?php if ($select_sidebar == 'config') { ?>class="active"<?php } ?>><a href="<?php dourl('setting:config'); ?>#logistics"  >物流配置</a></li>
            <li <?php if ($select_sidebar == 'notice') { ?>class="active"<?php } ?>><a href="<?php dourl('setting:notice'); ?>#notice_switch"  >通知管理</a></li>
			<?php if(empty($_SESSION['user']['group'])){?>   
            <li class="<?php if($select_nav == 'weixin') echo 'active';?>"><a href="<?php echo dourl('weixin:info'); ?>">微信设置</a></li>
            <li class="<?php if($select_nav == 'payment') echo 'active';?>"><a href="<?php echo dourl('payment:index'); ?>">支付设置</a></li> 
			<?php } ?>
            <li class="<?php if($select_nav == 'account') echo 'active';?>"><a href="<?php echo dourl('account:personal'); ?>">帐号资料</a></li>
        </ul>
    </nav>
</aside>
<!-- ▲ Second Sidebar -->
