<?php if (!defined('PIGCMS_PATH')) exit('deny access!'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta charset="utf-8"/>
	<meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
	<meta name="apple-mobile-web-app-capable" content="yes"/>
	<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
	<meta name="format-detection" content="telephone=no"/>
	<title>退货管理 </title>
	<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/foundation.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/common.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/person.css"/>
	<link rel="stylesheet" href="<?php echo STATIC_URL;?>css/fancybox.css"/>
	<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script src="<?php echo STATIC_URL;?>js/jquery.fancybox-1.3.1.pack.js"></script>
	<style type="text/css">
		tr {
			border: 1px solid #ebebeb;;
		}
		.left {
			float: none!important;
		}
		*,
		*:before,
		*:after {
		  -webkit-box-sizing: content-box;
		  -moz-box-sizing: content-box;
		  box-sizing: content-box; }
	</style>
	<script>
	$(function () {
		$("a[rel=show_img]").fancybox({
			'titlePosition' : 'over',
			'cyclic'		: false,
			'titleFormat'	: function(title, currentArray, currentIndex, currentOpts) {
				return '';
			}
		});
	})
	</script>
</head>
<body class="body-gray">
	<div class="fixed tab-bar">
		<section class="left-small">
			<a class="menu-icon" onclick="window.history.go(-1)"><span></span></a>
		</section>
		<section class="middle tab-bar-section">
			<h1 class="title">退货详情</h1>
		</section>
	</div>
	<div class="order-detail mt-45">
		<section class="order-detail-infor">
			<div class="order-detail-sum clear">
				<div class="sum-l order-detail-l">
					<i class="icon-orders-small"></i>
				</div>
				<div class="sum-r order-detail-r">
					<ul class="sum-r-ul">
						<li><span class="label">退货状态：</span><span class="value"><?php echo $return['status_txt'] ?></span></li>
						<li><span class="label">退货用户：</span><span class="value"><?php echo htmlspecialchars($return['nickname']) ?> <?php echo $return['phone'] ?></span></li>
						<li><span class="label">退货类型：</span><span class="value"><?php echo htmlspecialchars($return['type_txt']) ?></span></li>
						<li><span class="label">退货时间：</span><span class="value"><?php echo date('Y-m-d H:i', $return['dateline']) ?></span></li>
						<li><span class="label">退货理由：</span><span class="value"><?php echo htmlspecialchars($return['content']) ?></span></li>
						<li>
							<span class="label">图　　片：</span>
							<span class="value">
								<?php 
								if ($return['images']) {
									foreach ($return['images'] as $image) {
								?>
										<a href="<?php echo $image ?>" rel="show_img"><img src="<?php echo $image ?>" style="max-width:60px; max-height:60px;" title="点击查看大图" /></a>
								<?php 
									}
								} else {
									echo '无';
								}
								?>
							</span>
						</li>
					</ul>
				</div>
			</div>
		</section>
		<section class="order-detail-address">
			<div class="address-out clear">
				<div class="address-l order-detail-l">
					<i class="icon-talks-small"></i>
				</div>
				<div class="address-r order-detail-r">
					<ul class="address-r-ul">
						<li><span class="status">审核信息</span></li>
						<?php 
						if ($return['cancel_dateline']) {
						?>
							<li>
								<span class="label">不同意说明：</span>
								<span><?php echo htmlspecialchars($return['store_content']) ?></span>
							</li>
						<?php
						}
						if (!empty($return['address_user'])) {
							$address = unserialize($return['address']);
						?>
							<li>
								<span class="label">收货信息：</span>
								<span><?php echo htmlspecialchars($return['address_user']) ?> <?php echo $return['address_tel'] ?></span>
							</li>
							<li>
								<span class="label">收货地址：</span>
								<span><?php echo $address['province_txt'] . $address['city_txt'] . $address['area_txt'] . $address['address'] ?></span>
							</li>
							<li>
								<span class="label">退货金额：</span>
								<span>￥<?php echo sprintf('%.2f', $return['product_money'] + $return['postage_money']) ?> = 退货产品金额：<?php echo $return['product_money'] ?> + 退货物流金额：<?php echo $return['postage_money'] ?></span>
							</li>
						<?php 
						}
						if (empty($return['cancel_dateline']) && empty($return['address_user'])) {
						?>
							<li>
								<span></span>
								<span>暂无审核信息</span>
							</li>
						<?php
						}
						?>
					</ul>
				</div>
			</div>
		</section>
		<div class="list-myorder">
			<ul class="ul-product">
				<li>
					<span class="pic">
						<a href="good.php?id=<?php echo $return['product_id'] ?>&store_id=<?php echo $store_id ?>"><img src="<?php echo $return['image'] ?>" style="width:60px; height:60px;"/></a>
					</span>
					<div class="text">
						<span class="pro-name">
							<a href="good.php?id=<?php echo $return['product_id'] ?>&store_id=<?php echo $store_id ?>"><?php echo htmlspecialchars($return['name']) ?></a>
						</span>
						<div class="pro-pec">
							<?php 
							if ($return['sku_data']) {
								$sku_data = unserialize($return['sku_data']);
								foreach ($sku_data as $tmp) {
									echo '<span>' . $tmp['name'] . ':' . $tmp['value'] . '</span>';
								}
								echo '<br />';
							}
							?>
							<span>退货数量:<?php echo $return['pro_num'] ?></span>
						</div>
						<div class="pro-return"></div>
					</div>
				</li>
			</ul>
		</div>
	</div>
</body>
</html>
