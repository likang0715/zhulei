<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>供货商对账详情 - <?php echo $store_session['name'];?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
        <link href="<?php echo STATIC_URL;?>css/jquery.ui.css" type="text/css" rel="stylesheet" />
		<link href="<?php echo TPL_URL;?>css/order.css" type="text/css" rel="stylesheet"/>
        <link href="<?php echo TPL_URL;?>css/order_detail.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
        <script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui.js"></script>
        <script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript">
			var load_url="<?php dourl('load');?>";
			var page_content = "supplier_check_content";
		</script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/supplier_check.js"></script>
		<style type="text/css">
			.ui-nav {
				border: none;
				background: none;
				position: relative;
				border-bottom: 1px solid #e5e5e5;
				margin-bottom: 15px;
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
			.page-settlement .balance {
				padding: 10px 0;
				border-top: 1px solid #e5e5e5;
				background: rgba(255,255,255,0.4);
				zoom: 1;
			}
			.page-settlement .balance .balance-info {
				float: left;
				width: 24.33%;
				margin-left: -1px;
				padding: 0 20px;
				border-left: 1px solid #e5e5e5;
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-sizing: border-box;
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
		</style>
	</head>
	<body class="font14 usercenter">
		<?php include display('public:header');?>
		<div class="wrap_1000 clearfix container">
			<?php include display('sidebar');?>
			<div class="app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="page-settlement">
							<div class="ui-box settlement-info">
								<div class="balance">

									<div class="balance-info" style="border-left: none; position:relative">
										<div class="balance-title">获得收益<div class="help"></div></div>
										<div class="balance-content">
											<span class="money"><?php echo $income_balance; ?></span>
											<span class="unit">元</span>
										</div>
									</div>

									<div class="balance-info" style="position:relative">
										<div class="balance-title">待支付<div class="help"></div></div>
										<div class="balance-content">
											<span class="money"><?php echo $unpay_total; ?></span>
											<span class="unit">元</span>
										</div>
									</div>

									<div class="balance-info" style="position:relative">
										<div class="balance-title">退货欠<div class="help"></div></div>
										<div class="balance-content">
											<span class="money"><?php echo $return_owe; ?></span>
											<span class="unit">元</span>
										</div>
									</div>

									<div class="balance-info" style="position:relative">
										<div class="balance-title">供货商<div class="help"></div></div>
										<div class="balance-content">
											<span class="money"><?php echo $supplier_count; ?></span>
											<span class="unit">家</span>
										</div>
									</div>

									<div style="clear: both"></div>
								</div>
							</div>
						</div>
						<nav class="ui-nav clearfix">
							<ul class="pull-left">
								<li class="active" data-checked="1"><a href="#bond-pay">保证金供货商</a></li>
								<li data-checked="2"><a href="#cash-pay">现付供货商</a></li>
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