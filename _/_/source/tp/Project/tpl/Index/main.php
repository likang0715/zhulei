<include file="Public:header" />
<link rel="stylesheet" type="text/css" href="{pigcms{$static_path}css/main.css" />
	<div class="mainbox">
		<div class="info_block">
			<div id="Profile" class="list">
				<h1><b>个人信息</b><span>Profile&nbsp; Info</span></h1>
				<ul>
					<li><span>会员名:</span>{pigcms{$system_session.account}</li>
					<li><span>会员类型:</span>{pigcms{$admin_user.type_name}</li>
					<li><span>最后登陆时间:</span>{pigcms{$system_session.last_time|date='Y-m-d H:i:s',###}</li>
					<li><span>最后登陆IP/地址:</span>{pigcms{$system_session.last_ip|long2ip=###} / {pigcms{$system_session.last.country} {pigcms{$system_session.last.area}</li>
					<li><span>登陆次数:</span>{pigcms{$system_session.login_count}</li>
					<if condition="$admin_user['type'] eq 2 || $admin_user['type'] eq 3">
						<li style="color:green"><span>我的累计奖金:</span>{pigcms{$admin_user['reward_total']}</li>
						<li style="color:green"><span>未发放:</span>{pigcms{$admin_user['reward_balance']}</li>
						<li style="color:red">
							<span>已发放:</span>{pigcms{$admin_user['un_reward']}
							<a href="javascript:void(0)" onclick="window.top.show_other_frame('Order','myPromotionRecord')" style="margin-left: 20px">查看明细</a>
						</li>
					</if>
				</ul>
			</div>
			<?php if ($showMainInfo) { ?>
			<div id="sitestats">
				<h1><b>网站统计</b><span>Site &nbsp; Stats</span></h1>
				<div>
					<ul>
						<li style="background:#457CB5;line-height:44px;color:white;font-weight:bold;">会员</li>
						<li><b>用户总数</b><br><span>{pigcms{$website_user_count|default=0}</span></li>
						<li><b>商户总数</b><br><span>{pigcms{$website_merchant_count|default=0}</span></li>
						<li><b>店铺总数</b><br><span>{pigcms{$website_merchant_store_count|default=0}</span></li>
	                    <li><b>昨日新增用户</b><span>{pigcms{$yesterday_add_user_count|default=0}</span></li>
	                    <li><b>昨日新增店铺</b><span>{pigcms{$yesterday_add_store_count|default=0}</span></li>
	                    <li style="background:#3A6EA5;line-height:44px;color:white;font-weight:bold;">订单</li>
	                    <li><b>订单总数</b><span>{pigcms{$website_merchant_order_count|default=0}</span></li>
	                    <li><b>未付款订单</b><br><span>{pigcms{$not_paid_order_count|default=0}</span></li>
	                    <li><b>未发货订单</b><br><span>{pigcms{$not_send_order_count|default=0}</span></li>
	                    <li><b>已发货订单</b><br><span>{pigcms{$send_order_count|default=0}</span></li>
	                    <li><b>昨日新增订单</b><span>{pigcms{$yesterday_ordered_count|default=0}</span></li>
	                    <li style="background:#FF658E;line-height:44px;color:white;font-weight:bold;">商品</li>
	                    <li><b>商品总数</b><br><span>{pigcms{$website_merchant_goods_count|default=0}</span></li>
	                    <li><b>在售商品数</b><br><span>{pigcms{$selling_product_count|default=0}</span></li>
	                    <li><b>昨日新增商品</b><br><span>{pigcms{$yesterday_add_product_count|default=0}</span></li>
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
					<volist name="server_info" id="vo">
						<li><span>{pigcms{$key}:</span>{pigcms{$vo}</li>
					</volist>
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
	<!--script type="text/javascript" src="http://up.pigcms.cn/softupdate.php?soft_version={pigcms{:PigCms_VERSION}&domain={pigcms{$_SERVER.SERVER_NAME}"></script-->
<include file="Public:footer"/>