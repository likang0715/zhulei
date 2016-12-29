
<li <?php if($select_sidebar == 'info'){ ?>class="active"<?php } ?>>
	<a href="<?php dourl('info'); ?>">公众号信息</a>
</li>
<li <?php if (in_array($select_sidebar, array('index', 'one', 'multi'))) { ?>class="active"<?php } ?>>
	<a href="<?php dourl('index'); ?>">图文素材</a>
</li>
<li <?php if (in_array($select_sidebar, array('auto', 'tail', 'auto_reply'))) { ?>class="active"<?php } ?>>
	<a href="<?php dourl('auto'); ?>">自动回复</a>
</li>
<li <?php if ($select_sidebar == 'menu') { ?>class="active"<?php } ?>>
	<a href="<?php dourl('menu'); ?>">自定义菜单</a>
</li>
<?php if($weixin_bind_info['verify_type_info'] > -1){ ?>
<li <?php if ($select_sidebar == 'sendall') { ?>class="active"<?php } ?>>
	<a href="<?php dourl('sendall'); ?>">群发微信</a>
</li>
<?php } ?>
<?php if($weixin_bind_info['service_type_info'] == 2 && $weixin_bind_info['verify_type_info'] != '-1'){ ?>
<li <?php if ($select_sidebar == 'wxpay') { ?>class="active"<?php } ?>>
	<a href="<?php dourl('wxpay'); ?>">微信支付</a>
</li>
<?php } ?>

<?php if($weixin_bind_info['service_type_info'] == 2 && $weixin_bind_info['verify_type_info'] != '-1'){ ?>
<li <?php if ($select_sidebar == 'template_msg') { ?>class="active"<?php } ?>>
	<a href="<?php dourl('template_msg'); ?>">模板消息</a>
</li>
<?php } ?>
<li <?php if (in_array($select_sidebar, array('cashier', 'cashier_add', 'cashier_list'))) { ?>class="active"<?php } ?>>
	<a href="<?php dourl('cashier'); ?>">微信收银台</a>
</li>
<li <?php if (in_array($select_sidebar, array('qrcode', 'qrcode_add', 'qrcode_list'))) { ?>class="active"<?php } ?>>
	<a href="<?php dourl('qrcode'); ?>">定制二维码</a>
</li>