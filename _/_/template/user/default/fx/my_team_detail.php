<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>团队详细 - <?php echo $config['site_name'];?>分销平台 | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
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
		<script type="text/javascript">var load_url="<?php dourl('load');?>", team_id = "<?php echo intval(trim($_GET['id'])); ?>";</script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/fx_my_team_detail.js"></script>
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
			.sales {
				font-size: 18px;
				color: #f60;
			}
			.members {
				font-size: 18px;
				color: #07d;
			}
			.rank {
				float: right;
				width: 80px;
				height: 80px;
				background: url(<?php echo TPL_URL;?>/images/rank.png) no-repeat;
				cursor: pointer;
				background-position: 1px 0px
			}
			.rank-null {
				float: right;
				width: 80px;
				height: 80px;
				background: url(<?php echo TPL_URL;?>images/rank-null.png) no-repeat;
				cursor: pointer;
				background-position: 1px 0px
			}
			.rank-num {
				text-align: center;
				padding-top:16px;
				font-size: 12px;
				color:#B98E36;
				font-weight: bold;
			}
			.rank-null .rank-num {
				color: gray;
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
								<img class="logo" src="<?php echo $team['logo']; ?>" />
								<div class="account-info-meta">
									<div class="info-item">
										<label>团队名称：</label>
										<span><?php echo $team['name']; ?></span>
									</div>
									<div class="info-item">
										<label>创建者：</label>
										<span><?php echo $team['owner']; ?></span>
									</div>
									<div class="info-item">
										<label>创建时间：</label>
										<span><?php echo date('Y-m-d H:i:s', $team['add_time']); ?></span>
									</div>

								</div>
								<div class="account-info-meta">
									<div class="info-item">
										<label>销售额：</label>
										<span class="sales"><?php echo $team['sales']; ?></span>
									</div>
									<div class="info-item">
										<label>成员数：</label>
										<span class="members"><?php echo $team['members']; ?></span>
									</div>
								</div>
								<div class="account-info-meta">
									<div <?php if (!empty($team['rank'])) { ?>class="rank"<?php } else { ?>class="rank-null"<?php } ?> title="团队排名：<?php echo !empty($team['rank']) ? $team['rank'] : '排名未达标'; ?>">
										<div class="rank-num"><?php echo !empty($team['rank']) ? $team['rank'] : '未达标'; ?></div>
									</div>
								</div>
								<div style="clear:both"></div>
							</div>
							<div class="intro">
								<label style="display: inline-block;font-weight: bold;">团队简介：</label>
								<span>
									<?php echo !empty($team['desc']) ? $team['desc'] : '无'; ?>
								</span>
							</div>
						</div>
						<nav class="ui-nav clearfix">
							<ul class="pull-left">
								<li class="active"><a href="javascript:void(0);">团队成员</a></li>
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