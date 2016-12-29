<!DOCTYPE html>
<html lang="zh-CN"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>我的充值金额</title>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<meta name="format-detection" content="telephone=no">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="default">
		<meta name="applicable-device" content="mobile">
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>index_style/css/my.css">
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/order_list.css">
		<script src="<?php echo STATIC_URL;?>js/fastclick.js"></script>
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script src="<?php echo TPL_URL;?>index_style/js/base.js"></script>
		<script>var page_url = 'my_margin.php?action=index&store_id=<?php echo $store['store_id']; ?>&ajax=1', page_type = '<?php echo $action;?>', label = '充值金额';</script>
		<script src="<?php echo TPL_URL;?>js/my_point.js"></script>
		<script>var point_alias = "", type = <?php if (isset($type)) { ?>'<?php echo $type; ?>'<?php } else { ?>undefined<?php } ?>, target = '';</script>
	</head>
	<body>
		<div class="promote">
			<div class="hd">
				<ul class="flex">
					<li class="on">
						<a href="./my_margin.php?action=index&store_id=<?php echo $store['store_id']; ?><?php if (isset($type)) { echo "&type=" . $type; } ?>">商家充值金额</a>
					</li>
					<!--<li>
						<a  href="./my_point.php?action=store_point&store_id=<?php /*echo $store['store_id']; */?>">商家积分</a>
					</li>-->
				</ul>
			</div>
			<div class="bd">
				<div class="row">
					<div class="secttion0">
						<ul class="flex">
							<li>
								<span><?php echo $store['margin_total']; ?></span>
								<p>充值总额</p>
							</li>
							<li>
								<span><?php echo $store['margin_balance']; ?></span>
								<p>剩余充值金额</p>
							</li>
							<li>
								<span><?php echo $store['margin_used']; ?></span>
								<p>已使用充值金额</p>
							</li>
						</ul>
					</div>

					<div class="secttion2">
						<ul>

						</ul>
					</div>
					<div class="wx_loading2"></div>
					<div class="empty-list list-finished" style="padding-top:60px;display: none;">
						<div>
							<h4>居然还没有充值金额</h4>
							<p class="font-size-12">加油！加油！……  (/ □ \)</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>