<?php $select_sidebar=isset($select_sidebar)?$select_sidebar:ACTION_NAME;?>
<aside class="ui-second-sidebar second-sidebar" id="second-sidebar">
    <div class="second-sidebar-title">
        订座管理
    </div>
    <nav class="second-sidebar-nav" id="second-sidebar-nav">
		<ul>
			<li <?php if($select_sidebar == 'dashboard') echo 'class="active"';?>>
				<a href="<?php echo dourl('meal:dashboard'); ?>#index/<?php echo $frist_sore; ?>">订座概况</a>
			</li>
			<li <?php if($select_sidebar == 'table' ||$select_sidebar == 'table_edit'||$select_sidebar == 'table_add') echo 'class="active"';?>>
				<a href="<?php echo dourl('meal:table'); ?>">茶桌管理</a>
			</li>
			<li <?php if($select_sidebar == 'order' ||$select_sidebar == 'order_edit'||$select_sidebar == 'order_add') echo 'class="active"';?>>
				<a href="<?php dourl('meal:order');?>#list/<?php echo $frist_sore; ?>">订单管理</a>
			</li>
		</ul>
	</nav>
</aside>