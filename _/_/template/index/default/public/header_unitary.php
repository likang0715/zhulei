<script type="text/javascript">
	var add_cart_url = "<?php echo dourl('unitary:add_cart') ?>";
	var cart_url = "<?php echo dourl('unitary:cart') ?>";
	var img_url = "<?php echo STATIC_URL;?>unitary/images";
</script>
<div class="g-header" module="header/Header" id="pro-view-0" module-id="module-1" module-launched="true">
	<div class="m-toolbar" module="toolbar/Toolbar" id="pro-view-4" module-id="module-4" module-launched="true">
		<div class="g-wrap f-clear">
			<div class="m-toolbar-l">
				<?php if(empty($user_session)){?>
				Hi，欢迎来 <?php echo option('config.site_name');?>&nbsp;<a class="link-login style-red" target="_top" href="<?php echo url('account:login') ?>">请登录</a>&nbsp;&nbsp;
				<a class="link-regist style-red"  target="_top" href="<?php echo url('account:register') ?>" >免费注册</a>
				<?php }else{?>
				你好，<a class="link-login" href="<?php echo url('account:index') ?>" ><?php echo $user_session['nickname'];?>&nbsp;&nbsp;</a>
				<a class="link-regist style-red" target="_top" href="<?php echo url('account:logout') ?>">退出</a>
				<?php }?>
			</div>
			<ul class="m-toolbar-r">
				<!-- <li class="m-toolbar-myBonus"><a href="<?php dourl('index:index') ?>">返回主电商</a><var>|</var></li> -->
				<li class="m-toolbar-myDuobao">
					<a class="m-toolbar-myDuobao-btn" href="<?php echo dourl('unitary:account') ?>">
						我的夺宝 <i class="ico ico-arrow-gray-s ico-arrow-gray-s-down"></i>
					</a>
					<ul class="m-toolbar-myDuobao-menu">
						<li><a href="<?php echo dourl('unitary:account') ?>">夺宝记录</a></li>
						<li class="m-toolbar-myDuobao-menu-win"><a href="<?php echo dourl('unitary:account', array('type'=>'luck')) ?>">幸运记录</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<div class="m-header">
		<div class="g-wrap f-clear">
			<div class="m-header-logo">
				<h1><a class="m-header-logo-link" href="<?php echo dourl('unitary:index') ?>">一元夺宝</a></h1>
			</div>
			<div class="w-miniCart js-miniCart" module="minicart/MiniCart" id="pro-view-13" module-id="module-6" module-launched="true">
				<a class="w-miniCart-btn" href="<?php echo dourl('unitary:cart') ?>">
					<i class="ico ico-miniCart"></i>
					清 单
					<b class="w-miniCart-count">
						<i class="ico ico-arrow-white-solid ico-arrow-white-solid-l"></i>
						<?php echo $unitary_cart['cart_count'] ?>
					</b>
				</a>

				<div class="w-layer w-miniCart-layer js-miniCart-layer" id="pro-view-15" style="display: none"></div>
			</div>
		</div>
	</div>
	<div class="m-nav" module="nav/Nav" id="pro-view-1" module-id="module-2" module-launched="true">
		<div class="g-wrap f-clear">
			<div class="m-catlog <?php if (ACTION_NAME == 'index') { echo 'm-catlog-normal'; } else { echo 'm-catlog-fold'; } ?>">
				<div class="m-catlog-hd" style="padding-left:30px;cursor:pointer">
					<h2>商品分类<i class="ico ico-arrow ico-arrow-white ico-arrow-white-down"></i></h2>
				</div>
				<div class="m-catlog-wrap" style="height: 354px;">
					<div class="m-catlog-bd">
						<ul class="m-catlog-list">
							<?php foreach ($categoryList as $val) { ?>
							<li><a href="<?php echo dourl('unitary:category', array('cat_id'=>$val['cat_id'])) ?>"><?php echo $val['cat_name'] ?></a></li>
							<?php } ?>
							<li><a href="<?php echo dourl('unitary:category', array('cat_id'=>9999)) ?>">全部商品</a></li>
						</ul>
					</div>
					<div class="m-catlog-ft"></div>
				</div>
			</div>
			<div class="m-menu" pro="menu">
				<ul class="m-menu-list">
					<li class="m-menu-list-item <?php if (ACTION_NAME == 'index') { echo 'selected'; } ?>">
						<a class="m-menu-list-item-link" href="<?php echo dourl('unitary:index') ?>">首页</a>
					</li>
					<?php foreach ($navList as $val) { ?>
					<li class="m-menu-list-item <?php if (strstr($now_url, $val['url'])) { echo 'selected'; } ?>">
						<var>|</var>
						<a class="m-menu-list-item-link" href="<?php echo $val['url'] ?>"><?php echo $val['name'] ?></a>
					</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(function(){
	menushow.init($(".js-miniCart"), $(".js-miniCart-layer"));
})
</script>