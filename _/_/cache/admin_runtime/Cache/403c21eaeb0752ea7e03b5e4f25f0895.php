<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/html"><head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo C('DEFAULT_CHARSET');?>" />
		<title>网站后台管理 Powered by pigcms.com</title>
		<script type="text/javascript">
			<!--if(self==top){window.top.location.href="<?php echo U('Index/index');?>";}-->
			var kind_editor=null,static_public="<?php echo ($static_public); ?>",static_path="<?php echo ($static_path); ?>",system_index="<?php echo U('Index/index');?>",choose_province="<?php echo U('Area/ajax_province');?>",choose_city="<?php echo U('Area/ajax_city');?>",choose_area="<?php echo U('Area/ajax_area');?>",choose_circle="<?php echo U('Area/ajax_circle');?>",choose_map="<?php echo U('Map/frame_map');?>",get_firstword="<?php echo U('Words/get_firstword');?>",frame_show=<?php if($_GET['frame_show']): ?>true<?php else: ?>false<?php endif; ?>;
		</script>
		<link rel="stylesheet" type="text/css" href="<?php echo ($static_path); ?>css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo ($static_path); ?>css/jquery.ui.css" />
		<script type="text/javascript" src="<?php echo C('JQUERY_FILE');?>"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/plugin/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.form.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.validate.js"></script>
		<script type="text/javascript" src="/static/js/date/WdatePicker.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.colorpicker.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/common.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/date.js"></script>
			<?php if($withdrawal_count > 0): ?><script type="text/javascript">
					$(function(){
						$('#nav_4 > dd > #leftmenu_Order_withdraw', parent.document).html('提现记录 <label style="color:red">(' + <?php echo ($withdrawal_count); ?> + ')</label>')
					})
				</script><?php endif; ?>
			<?php if($unprocessed > 0): ?><script type="text/javascript">
					$(function(){
						if ($('#leftmenu_Credit_returnRecord', parent.document).length > 0) {
							var menu_html = $('#leftmenu_Credit_returnRecord', parent.document).html();
							menu_html = menu_html.split('(')[0];
							menu_html += ' <label style="color:red">(<?php echo ($unprocessed); ?>)</label>';
							$('#leftmenu_Credit_returnRecord', parent.document).html(menu_html);
						}
					})
				</script><?php endif; ?>
		</head>
		<body width="100%" 
		<?php if($bg_color): ?>style="background:<?php echo ($bg_color); ?>;"<?php endif; ?>
> 
<link rel="stylesheet" type="text/css" href="<?php echo ($static_path); ?>css/main.css" />
	<div class="mainbox">
		<div class="info_block">
			<div id="Profile" class="list">
				<h1><b>个人信息</b><span>Profile&nbsp; Info</span></h1>
				<ul>
					<li><span>会员名:</span><?php echo ($system_session["account"]); ?></li>
					<li><span>会员类型:</span><?php echo ($admin_user["type_name"]); ?></li>
					<li><span>最后登陆时间:</span><?php echo (date('Y-m-d H:i:s',$system_session["last_time"])); ?></li>
					<li><span>最后登陆IP/地址:</span><?php echo (long2ip($system_session["last_ip"])); ?> / <?php echo ($system_session["last"]["country"]); ?> <?php echo ($system_session["last"]["area"]); ?></li>
					<li><span>登陆次数:</span><?php echo ($system_session["login_count"]); ?></li>
					<?php if($admin_user['type'] == 2 || $admin_user['type'] == 3): ?><li style="color:green"><span>我的累计奖金:</span><?php echo ($admin_user['reward_total']); ?></li>
						<li style="color:green"><span>未发放:</span><?php echo ($admin_user['reward_balance']); ?></li>
						<li style="color:red">
							<span>已发放:</span><?php echo ($admin_user['un_reward']); ?>
							<a href="javascript:void(0)" onclick="window.top.show_other_frame('Order','myPromotionRecord')" style="margin-left: 20px">查看明细</a>
						</li><?php endif; ?>
				</ul>
			</div>
			<?php if ($showMainInfo) { ?>
			<div id="sitestats">
				<h1><b>网站统计</b><span>Site &nbsp; Stats</span></h1>
				<div>
					<ul>
						<li style="background:#457CB5;line-height:44px;color:white;font-weight:bold;">会员</li>
						<li><b>用户总数</b><br><span><?php echo (($website_user_count)?($website_user_count):0); ?></span></li>
						<li><b>商户总数</b><br><span><?php echo (($website_merchant_count)?($website_merchant_count):0); ?></span></li>
						<li><b>店铺总数</b><br><span><?php echo (($website_merchant_store_count)?($website_merchant_store_count):0); ?></span></li>
	                    <li><b>昨日新增用户</b><span><?php echo (($yesterday_add_user_count)?($yesterday_add_user_count):0); ?></span></li>
	                    <li><b>昨日新增店铺</b><span><?php echo (($yesterday_add_store_count)?($yesterday_add_store_count):0); ?></span></li>
	                    <li style="background:#3A6EA5;line-height:44px;color:white;font-weight:bold;">订单</li>
	                    <li><b>订单总数</b><span><?php echo (($website_merchant_order_count)?($website_merchant_order_count):0); ?></span></li>
	                    <li><b>未付款订单</b><br><span><?php echo (($not_paid_order_count)?($not_paid_order_count):0); ?></span></li>
	                    <li><b>未发货订单</b><br><span><?php echo (($not_send_order_count)?($not_send_order_count):0); ?></span></li>
	                    <li><b>已发货订单</b><br><span><?php echo (($send_order_count)?($send_order_count):0); ?></span></li>
	                    <li><b>昨日新增订单</b><span><?php echo (($yesterday_ordered_count)?($yesterday_ordered_count):0); ?></span></li>
	                    <li style="background:#FF658E;line-height:44px;color:white;font-weight:bold;">商品</li>
	                    <li><b>商品总数</b><br><span><?php echo (($website_merchant_goods_count)?($website_merchant_goods_count):0); ?></span></li>
	                    <li><b>在售商品数</b><br><span><?php echo (($selling_product_count)?($selling_product_count):0); ?></span></li>
	                    <li><b>昨日新增商品</b><br><span><?php echo (($yesterday_add_product_count)?($yesterday_add_product_count):0); ?></span></li>
	                    <li><b></b><span></span></li>
	                    <li><b></b><span></span></li>
					</ul>
				</div>
			</div>	
			<?php } ?>
		</div>
		<?php if ($showMainInfo) { ?>
		<div class="info_block">
			<div id="system"  class="list">
				<h1><b>系统信息</b><span>System&nbsp; Info</span></h1>
				<ul>
					<?php if(is_array($server_info)): $i = 0; $__LIST__ = $server_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><span><?php echo ($key); ?>:</span><?php echo ($vo); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>
			<div id="system"  class="list">
				<h1><b>官方动态</b><span>Soft &nbsp; Update</span></h1>
				<ul id="official_news">
					<li>加载中...</li>
				</ul>
			</div>
		</div>
		<?php } ?>
	</div>
	<!--script type="text/javascript" src="http://up.pigcms.cn/softupdate.php?soft_version=<?php echo PigCms_VERSION;?>&domain=<?php echo ($_SERVER["SERVER_NAME"]); ?>"></script-->
	</body>
</html>