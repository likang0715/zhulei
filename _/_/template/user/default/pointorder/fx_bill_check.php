<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>分销对账 - <?php echo $config['site_name'];?>分销平台 | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/order.css" type="text/css" rel="stylesheet"/>
        <link href="<?php echo STATIC_URL;?>css/jquery.ui.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
        <script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript">var load_url="<?php dourl('load');?>",page_content="fx_bill_check_content", bill_check_url = "<?php dourl('fx_bill_check'); ?>", store_id = "<?php echo $store_id; ?>";</script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/fx_bill_check.js"></script>
        <style type="text/css">
            .popover-inner {
                padding: 1px;
                background-color: #e5e5e5;
                -webkit-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
            }
        </style>
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
        </style>
	</head>

	<body class="font14 usercenter">
		<?php include display('public:header');?>
		<div class="wrap_1000 clearfix container">
			<?php include display('sidebar');?>
			<div class="app">
                <div class="dash-bar clearfix" style="margin-top: 15px">
                    <div class="js-cont">
                        <?php if (empty($_SESSION['store']['drp_supplier_id'])) { ?>
                        <div class="info-group">
                            <div class="info-group__inner">
                                <span class="h4">
                                    <a href="<?php echo dourl('fx:seller'); ?>"><?php echo $seller_count; ?></a>
                                </span>
                                <span class="info-description">未对账分销商</span>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="info-group">
                            <div class="info-group__inner">
                                <span class="h4">
                                    <a href="<?php echo dourl('fx:seller'); ?>">￥<?php echo $uncheck_amount; ?></a>
                                </span>
                                <span class="info-description">未对账金额</span>
                            </div>
                        </div>
                        <div class="info-group">
                            <div class="info-group__inner">
                                <span class="h4">
                                    <a href="<?php echo dourl('fx:seller'); ?>">￥<?php echo $check_amount; ?></a>
                                </span>
                                <span class="info-description">已对账金额</span>
                            </div>
                        </div>
                        <div class="info-group">
                            <div class="info-group__inner">
                                <span class="h4">
                                    <a href="<?php echo dourl('fx_bill_check'); ?>#uncheck"><?php echo $order_count; ?></a>
                                </span>
                                <span class="info-description">未对账订单</span>
                            </div>
                        </div>
                        <div class="info-group">
                            <div class="info-group__inner">
                                <span class="h4">
                                    <a href="<?php echo dourl('trade:income'); ?>">￥<?php echo $seller_sales; ?></a>
                                </span>
                                <span class="info-description">销售额</span>
                                <span class="block-help">
                                    <a href="javascript:void(0);" class="js-help-notes"></a>
                                    <div class="js-notes-cont hide">
                                        <p><strong>销售额：</strong><?php if (empty($_SESSION['store']['drp_supplier_id'])) { ?>只统计分销店铺销售的订单。<?php } else { ?>只统计本店销售的订单<?php } ?></p>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="app-inner clearfix">
					<div class="app-init-container">
                        <nav class="ui-nav clearfix">
                            <ul class="pull-left">
                                <li class="active" data-checked="1"><a href="#uncheck">未对账订单</a></li>
                                <li data-checked="2"><a href="#checked">已对账订单</a></li>
                                <?php if (empty($_SESSION['store']['drp_supplier_id'])) { ?>
                                <?php if (empty($store_id)) { ?>
                                <li data-checked="0"><a href="#seller">未对账分销商</a></li>
                                <?php } ?>
                                <?php } ?>
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