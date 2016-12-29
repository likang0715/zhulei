<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>找人代付 - <?php echo $store_session['name']; ?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
		<meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/appmarket.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/wx_sidebar.css" type="text/css" rel="stylesheet"/>
		<link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>css/jquery.ui.css" />
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
		<!--script type="text/javascript" src="<?php echo STATIC_URL;?>js/echart/echarts.js"></script-->
		<script type="text/javascript" src="/static/js/date/WdatePicker.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.validate.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		
		<script type="text/javascript">
			var load_url = "<?php dourl('load');?>";
			var content_url = "<?php dourl('peerpay:content') ?>";
			var fetchtxt_delete_url = "<?php dourl('peerpay:delete') ?>";
			var pay_agent_url = "<?php dourl('peerpay:pay_agent') ?>";
			var setting_save_url = "<?php dourl('peerpay:setting_save') ?>";
		</script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/peerpay.js"></script>
	</head>
	<body class="font14 usercenter">
		<?php include display('public:header');?>
		<div class="wrap_1000 clearfix container">
			<?php include display('public:yx_sidebar');?>
			<div class="app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="clearfix"></div>
						<div class="js-logistics">
							<div class="js-logistics-board">
								<div class="widget-app-board ui-box">
									<div class="widget-app-board-info">
										<h3>找人代付功能</h3>
										<div>
											<p>
												启用代付功能后，代付发起人（买家）下单后，可将订单分享给小伙伴（朋友圈、微信群、微信好友），请他帮忙付款。<br />
												注意：代送订单有效期15天，逾期后未完成，进入全额退款流程；若有超额支付，则超付部分进入退款流程；<br />
											</p>
										</div>
									</div>
									<div class="widget-app-board-control">
										<label class="js-switch js-pay_agent-status ui-switch <?php if ($store['pay_agent']) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?> right"></label>
									</div>
								</div>
							</div>
						</div>
						<div>
							<nav class="ui-nav-table clearfix">
								<ul class="pull-left js-list-filter-region">
									<li id="js-list-nav-all" class="active" >
										<a href="#list">发起人配置</a>
									</li>
									<li id="js-list-nav-end" >
										<a href="#setting">代付配置</a>
									</li>
								</ul>
							</nav>
						</div>
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