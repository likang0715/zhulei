<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>我的经销商 - <?php echo $config['site_name'];?>分销平台 | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/fx.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/order.css" type="text/css" rel="stylesheet"/>
        <link href="<?php echo STATIC_URL;?>css/jquery.ui.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
        <script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript">var load_url="<?php dourl('load');?>", store_id = "<?php echo intval(trim($_GET['store_id'])); ?>", remove_whitelist_url = "<?php dourl('fx:ws_store_info', array('store_id' => intval(trim($_GET['store_id'])))); ?>", update_income_url = "<?php dourl('trade:update_income'); ?>";</script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/ws_store_info.js"></script>
		<style type="text/css">
			.page-content, .app__content {
				width: auto;
			}
			.sidebar {
				margin-top: auto;
			}
			.ui-nav {
				border: none;
				background: none;
				position: relative;
				border-bottom: 1px solid #e5e5e5;
				margin-bottom: 15px;
				margin-top: 23px;
			}
			.red {
				color:red;
			}
			.pull-left {
				float: left;
			}
			.ui-nav ul {
				zoom: 1;
				margin-bottom: -1px;
				margin-left: 1px;
			}
			.ui-nav li {
				float: left;
				margin-left: -1px;
			}
			.ui-nav li a {
				display: inline-block;
				padding: 0 12px;
				line-height: 32px;
				color: #333;
				border: 1px solid #e5e5e5;
				background: #f8f8f8;
				min-width: 80px;
				text-align: center;
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-sizing: border-box;
			}
			.ui-nav li.active a {
				font-size: 100%;
				border-bottom-color: #fff;
				background: #fff;
				margin:0px;
				line-height: 32px;
			}

			.account-info .account-info-meta label {
				display: inline;
				color: #999;
				cursor: text;
			}
			.account-info img {
				float: left;
				width: 80px;
				height: 80px;
				margin-right:8px;
			}
			.account-info {
				padding: 20px 20px 20px 20px;
				background: rgba(255,255,255,0.3);
				zoom: 1;
			}
			.account-info .account-info-meta {
				width:29%;
				float:left;
			}

			.account-info .info-item {
				margin-top: 7px;
			}

			.help {
				display: inline-block;
				width: 16px;
				height: 16px;
				line-height: 18px;
				border-radius: 8px;
				font-size: 12px;
				text-align: center;
				background: #D5CD2F;
				color: #fff;
				cursor: pointer;
			}
			.help:after {
				content: "?";
			}
			.help a {
				display: inline-block;
				width: 16px;
				height: 16px;
				line-height: 18px;
				border-radius: 8px;
				font-size: 12px;
				text-align: center;
				background: #D5CD2F;
				color: #fff;
			}
			.intro {
				margin-top:5px;
				padding:5px;
				background-color: white;
			}
			.page-settlement .balance {
				padding: 10px 0;
				border-top: 1px solid #e5e5e5;
				background: rgba(255, 255, 255, 0.4);
				zoom: 1;
			}
			.page-settlement .balance .balance-info {
				float: left;
				width: 33.33%;
				margin-left: -1px;
				padding: 0 20px;
				border-left: 1px solid #e5e5e5;
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-sizing: border-box;
			}
			.page-settlement .balance .balance-info {
				width: 24.33%;
			}
			.page-settlement .balance .balance-info .balance-title {
				font-size: 14px;
				color: #000;
				margin-bottom: 10px;
			}
			.page-settlement .balance .balance-info .balance-content span, .page-settlement .balance .balance-info .balance-content a {
				vertical-align: baseline;
				line-height: 28px;
			}
			.page-settlement .balance .balance-info .balance-content .money {
				font-size: 25px;
				color: #f60;
			}
			.page-settlement .balance .balance-info .balance-content span, .page-settlement .balance .balance-info .balance-content a {
				vertical-align: baseline;
				line-height: 28px;
			}
			.page-settlement .balance .balance-info .balance-content .unit {
				font-size: 12px;
				color: #666;
			}
			.popover-help-notes.bottom:not(.center) .popover-inner, .popover-intro.bottom:not(.center) .popover-inner {
				margin-left: auto;
			}
			.income-total .arrow {
				left: 16%!important;
			}
			.not-paid .arrow {
				left: 22%!important;
			}
			.return-owe .arrow {
				left: 20%!important;
			}
			.margin-balance .arrow {
				left: 57%!important;
			}
		</style>
	</head>
	<body class="font14 usercenter">
		<?php include display('public:header');?>
		<div class="wrap_1000 clearfix container">
			<?php include display('sidebar');?>
			<div class="app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="settlement-info">
							<?php if(!empty($supplier_store_info['is_required_margin'])) {?>
								<h3 style="background: #F2F2F2;height:23px;padding:5px;margin-bottom:2px;">
									<p style="color:orange;">批发本店商品需要批发商审核，并在审核通过后交纳<span style="color:#f00">￥<?php echo $supplier_store_info['bond']?>元</span>保证金方可批发。</p>
								</h3>
							<?php }?>
							<div class="account-info">
								<img class="logo" src="<?php echo $store_info['logo']; ?>" />
								<div class="account-info-meta">
									<div class="info-item">
										<label>店铺名：</label>
										<span><?php echo $store_info['name']; ?></span>
									</div>
									<div class="info-item">
										<label>联系人：</label>
										<span><?php echo !empty($store_info['linkman']) ? $store_info['linkman'] : '无'; ?></span>
									</div>
									<div class="info-item">
										<label>手机号：</label>
										<span><?php echo !empty($store_info['tel']) ? $store_info['tel'] : '无'; ?></span>
									</div>

								</div>
								<div class="account-info-meta">
									<div class="info-item">
										<label>QQ：</label>
										<span><?php echo !empty($store_info['qq']) ? $store_info['qq'] : '无'; ?></span>
									</div>
									<div class="info-item">
										<label>收款账户：</label>
										<span><?php echo !empty($ws_relation['bank_card_user']) ? $ws_relation['bank_card_user'] : '无'; ?></span>
									</div>
									<div class="info-item">
										<label>银行卡号：</label>
										<span><?php echo !empty($ws_relation['bank_card']) ? $ws_relation['bank_card'] : '无'; ?></span>
									</div>

								</div>
								<div class="account-info-meta">
									<div class="info-item">
										<label>加盟时间：</label>
										<span><?php echo date('Y-m-d H:i:s', $ws_relation['add_time']); ?></span>
									</div>
								</div>
								<div style="clear:both"></div>
							</div>
							<div class="page-settlement">
								<div class="balance">
									<div class="balance-info income-total" style="border-left: none; position:relative">
										<div class="balance-title">累计收益
											<div class="help"></div>
											<div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 40px; display: none;">
												<div class="arrow"></div>
												<div class="popover-inner">
													<div class="popover-content">
														<p><strong>累计收益:</strong> 批发本店商品获得的收益。</p>
													</div>
												</div>
											</div>
										</div>
										<div class="balance-content">
											<span class="money"><?php echo $ws_relation['income']; ?></span>
											<span class="unit">元</span>
										</div>
									</div>

									<div class="balance-info not-paid" style="position:relative">
										<div class="balance-title">未支付金额
											<div class="help"></div>
											<div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 37px; display: none;">
												<div class="arrow"></div>
												<div class="popover-inner">
													<div class="popover-content">
														<p><strong>未支付金额:</strong> 未向供货商支付的订单金额。</p>
													</div>
												</div>
											</div>
										</div>
										<div class="balance-content">
											<span class="money"><?php echo $ws_relation['not_paid']; ?></span>
											<span class="unit">元</span>
										</div>
									</div>
									<div class="balance-info return-owe" style="position: relative">
										<div class="balance-title">退货欠款
											<div class="help"></div>
											<div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 31px; display: none;">
												<div class="arrow"></div>
												<div class="popover-inner">
													<div class="popover-content">
														<p><strong>退货欠款:</strong> 因退货欠供货商的金额。</p>
													</div>
												</div>
											</div>
										</div>
										<div class="balance-content">
											<span class="money"><?php echo $ws_relation['return_owe']; ?></span>
											<span class="unit">元</span>
											<span><a href="<?php dourl('order:clear_return_owe'); ?>&dealer_id=<?php echo $_GET['store_id']; ?>">销账</a></span>
										</div>
									</div>
									<div class="balance-info margin-balance" style="position:relative">
										<div class="balance-title">保证金余额
											<div class="help"></div>
											<div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: -66px; display: none;">
												<div class="arrow"></div>
												<div class="popover-inner">
													<div class="popover-content">
														<p><strong>保证金余额:</strong> 缴纳的保证金剩余金额。</p>
													</div>
												</div>
											</div>
										</div>
										<div class="balance-content">
											<span class="money"><?php echo number_format($ws_relation['bond'], 2, '.', ''); ?></span>
											<span class="unit">元</span>
										</div>
									</div>
									<div style="clear: both"></div>
								</div>
							</div>
							<div class="intro">
								<label style="display: inline-block">店铺简介：</label>
            <span>
                <?php echo !empty($store_info['intro']) ? $store_info['intro'] : '无'; ?>
            </span>
							</div>
						</div>
						<nav class="ui-nav clearfix">
							<ul class="pull-left">
								<li data-content="_ws_order" data-checked="1" class="active"><a href="#not-paid">未支付订单</a></li>
								<li data-content="_ws_order" data-checked="2"><a href="#paid">已支付订单</a></li>
								<li data-content="_bond_expend" data-checked="3"><a href="#bond-expend">保证金扣款</a></li>
								<li data-content="_bond_recharge" data-checked="4"><a href="#bond-recharge">保证金充值</a></li>
								<li data-content="_wholesale_product" data-checked="5"><a href="#wholesale-product">批发的商品</a></li>
								<li data-content="_whitelist_product" data-checked="6"><a href="#whitelist-product">白名单商品</a></li>
								<li data-content="_approve_data" data-checked="6"><a href="#approve-data">认证资料</a></li>
							</ul>
						</nav>
						<div class="nav-wrapper--app"></div>
						<div class="app__content"></div>
					</div>
				</div>
			</div>
		</div>
		<?php include display('public:footer');?>
		<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
	</body>
</html>