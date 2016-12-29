<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>收入/提现 - <?php echo $store_session['name'];?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="description" content="<?php echo $config['seo_description'];?>">
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
        <meta name="renderer" content="webkit">
        <meta name="referrer" content="always">
        <meta name="format-detection" content="telephone=no">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
        <!-- ▼ Base CSS -->
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet" />
        <link href="<?php echo STATIC_URL;?>css/jquery.ui.css" type="text/css" rel="stylesheet" />
        <!-- ▲ Base CSS -->
        <!-- ▼ Trade CSS -->
		<link href="<?php echo TPL_URL;?>css/income.css" type="text/css" rel="stylesheet" />
        <!-- ▲ Trade CSS -->
        <!-- ▼ Constant JS -->
		<script type="text/javascript">
			var load_url="<?php dourl('delivery_load');?>",add_url="<?php dourl('selffetch_modify');?>",get_url="<?php dourl('selffetch_get');?>",edit_url="<?php dourl('selffetch_amend');?>";status_url="<?php dourl('selffetch_status');?>", settingwithdrawal_url = "<?php dourl('settingwithdrawal'); ?>", applywithdrawal_url = "<?php dourl('applywithdrawal'); ?>", delwithdrawal_url="<?php dourl('delwithdrawal'); ?>", update_income_url="<?php dourl('update_income'); ?>", to = '<?php echo $to; ?>', seller_id = '<?php echo $seller_id; ?>', supplier_id = '<?php echo $supplier_id; ?>', dividendswithdrawal_url = "<?php dourl('dividendswithdrawal'); ?>", withdrawal = '<?php echo $withdrawal; ?>', platform_margin_url = "<?php dourl('trade:income'); ?>#platform_margin";
			var type = "<?php echo isset($type) ? $type : ''; ?>";
			var status = "<?php echo isset($status) ? $status: ''; ?>"
		</script>
        <!-- ▲ Constant JS -->
        <!-- ▼ Base JS -->
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
        <script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui.js"></script>
        <script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/echart/echarts.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
        <!-- ▲ Base JS -->
        <!-- ▼ Trade JS -->
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/income.js"></script>
        <!-- ▲ Trade JS -->
	</head>
	<body class="font14 usercenter">
		<?php $version = option('config.weidian_version'); ?>
		<?php include display('public:first_sidebar');?>
			<?php include display('sidebar');?>
		<!-- ▼ Container-->
		<div id="container" class="clearfix container right-sidebar">
			<div id="container-left">
				<!-- ▼ Third Header -->
				<div id="third-header" class="income-nav">
				    <ul class="third-header-inner">
                        <li id="js-nav-settlement-income" class="active">
                            <a href="#income">我的收入</a>
                        </li>
                        <li id="js-nav-settlement-trade">
                            <a href="#trade">交易记录</a>
                        </li>
                        <li id="js-nav-settlement-inoutdetail">
                            <a href="#inoutdetail">收支明细</a>
                        </li>
						<?php if (empty($_SESSION['store']['drp_supplier_id']) && !empty($allow_platform_drp) && empty($version)) { ?>
						<!-- <li id="js-nav-settlement-wholesale">
							<a href="#wholesale">批发盈利</a>
						</li> -->
						<?php } ?>
						<?php if (!empty($_SESSION['store']['drp_supplier_id']) && !empty($allow_store_drp)) { ?>
                        <!-- <li id="js-nav-settlement-drp">
							<a href="#drp">分销盈利</a>
						</li> -->
						<?php } ?>
						<!-- <li id="js-nav-settlement-my_dividends">
                            <a href="#my_dividends">分红奖金记录</a>
                        </li> -->
						<li id="js-nav-settlement-withdraw">
                            <a href="#withdraw">提现记录<span style="color:red;">(<?php echo $my_withdrawal_count;?>)</span></a>
                        </li>
                        <?php if(empty($store_session['drp_supplier_id'])) {?>
                        <!-- <li id="js-nav-settlement-seller_withdraw">
                            <a href="#seller_withdraw">分销商提现<span style="color:red;">(<?php echo $seller_withdrawal_count;?>)</span></a>
                        </li> -->
                        <?php }?>
						<?php if (empty($store_session['drp_supplier_id']) && !empty($open_margin_recharge)) { ?>
						<!-- <li id="js-nav-settlement-platform_margin">
							<a href="#platform_margin">充值账户</a>
						</li>
						<li id="js-nav-settlement-margin_return">
							<a href="#margin_return">充值返还记录<span style="color:red;">(<span class="margin-return-count"><?php echo $platform_margin_return_count; ?></span>)</span></a>
						</li> -->
						<?php } ?>
                    </ul>
				</div>
				<!-- ▲ Third Header -->
				<!-- ▼ Container App -->
				<div class="container-app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="nav-wrapper--app"></div>
						<div class="app__content"></div>
					</div>
				</div>
				</div>
			</div>
		</div>
		<?php include display('public:footer');?>
		<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
	</body>
</html>