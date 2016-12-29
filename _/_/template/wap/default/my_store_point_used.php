<!DOCTYPE html>
<html lang="zh-CN"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title><?php echo $title; ?></title>
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
		<script>var page_url = 'my_point.php?action=store_point_used&store_id=<?php echo $store['store_id']; ?>&ajax=1', page_type = '<?php echo $action;?>', label = '店铺';</script>
		<script src="<?php echo TPL_URL;?>js/my_point.js"></script>
		<script>var point_alias = "<?php echo $point_alias; ?>", type = <?php echo isset($type) ? $type : 'undefined'; ?>, target = "<?php echo isset($target) ? $target : 'undefined'; ?>";</script>
	</head>
	<body>
		<div class="promote">
			<div class="hd">
				<ul class="flex">
					<li class="on">
						<a href=""><?php echo $title; ?></a>
					</li>
				</ul>
			</div>
			<div class="bd">
				<div class="row">
					<div class="secttion0">
						<?php if ($type == 2) { ?>
						<ul class="flex">
							<li>
								<span><?php echo $store['point2money'];?></span>
								<p>已转可用积分</p>
							</li>
							<li>
								<span><?php echo $store['point2money_balance']?></span>
								<p>已转可提现金额</p>
							</li>
							<li>
								<span><?php echo $store['point2money_service_fee']; ?></span>
								<p>已扣兑现服务费</p>
							</li>
						</ul>
						<?php } else { ?>
						<ul class="flex">
							<li>
								<span><?php echo $store['point_balance'];?></span>
								<p>可用<?php echo $point_alias; ?></p>
							</li>
							<li>
								<span><?php echo $store['point2money']?></span>
								<p>已提现<?php echo $point_alias; ?></p>
							</li>
							<li>
								<span><?php echo $store['point2user']; ?></span>
								<p>已转移<?php echo $point_alias; ?></p>
							</li>
						</ul>
						<?php } ?>
					</div>

					<div class="secttion2">
						<ul>

						</ul>
					</div>
					<div class="wx_loading2"></div>
					<div class="empty-list list-finished" style="padding-top:60px;display: none;">
						<div>
							<h4>居然还没有店铺<?php echo $point_alias;?></h4>
							<p class="font-size-12">加油！加油！……  (/ □ \)</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>