<?php  $select_sidebar = isset($select_sidebar) ? $select_sidebar : ACTION_NAME; ?>
<aside class="ui-second-sidebar second-sidebar" id="second-sidebar">
    <div class="second-sidebar-title">
        商品管理
    </div>
    <nav class="second-sidebar-nav" id="second-sidebar-nav">
		<ul>
		<?php if(in_array(10, $rbac_result) || $package_id == 0){?>
   		<?php }?>
		    <?php if(in_array(PackageConfig::getRbacId(10,'fans','statistic'), $rbac_result) || $package_id == 0){?>
			<li <?php if($select_sidebar == 'statistic') echo 'class="active"';?>>
				<a href="<?php dourl('statistic');?>">会员数据</a>
			</li>
			<?php }?>
			<?php if(in_array(PackageConfig::getRbacId(10,'fans','tag'), $rbac_result) || $package_id == 0){?>
			<li <?php if(in_array($select_sidebar,array('tag','statistics'))) echo 'class="active"';?>>
				<a href="<?php dourl('tag');?>">会员等级</a>
			</li>
			<?php }?>
			<?php if(in_array(PackageConfig::getRbacId(10,'fans','store_points'), $rbac_result) || $package_id == 0){?>
			<li <?php if($select_sidebar == 'store_points') echo 'class="active"';?>>
				<a href="<?php dourl('store_points');?>">积分规则</a>
			</li>
			<?php }?>
			<?php if(in_array(PackageConfig::getRbacId(10,'fans','points_apply'), $rbac_result) || $package_id == 0){?>
            <li <?php if($select_sidebar == 'points_apply') echo 'class="active"';?>>
                <a href="<?php dourl('points_apply');?>">积分使用</a>
            </li>
            <?php }?>
			<?php if(in_array(10, $rbac_result) || $package_id == 0){?>
			<li <?php if($select_sidebar == 'member') echo 'class="active"';?>>
				<a href="<?php dourl('member');?>">会员管理</a>
			</li>
		<?php }?>
		</ul>
	</nav>
</aside>