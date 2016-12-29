<?php $select_sidebar=isset($select_sidebar)?$select_sidebar:ACTION_NAME;?>
<aside class="ui-second-sidebar second-sidebar" id="second-sidebar">
	<div class="second-sidebar-title">
		茶会管理
	</div>
	<nav class="second-sidebar-nav" id="second-sidebar-nav">
		<ul>
			<li class="ui-box">
				<a class="ui-btn ui-btn-success js-load-page" href="#add">发布茶会</a>
			</li>
			<li class="active">
				<a class="js-load-page" href="#list">茶会管理</a>
			</li>
			<!-- <li <?php if($select_sidebar == 'list') echo 'class="active"';?>>
				<a href="<?php dourl('events:index');?>&status=2">未发布茶会</a>
			</li> -->
		</ul>		
	</nav>
</aside>