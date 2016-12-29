<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js" lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<meta name="HandheldFriendly" content="true"/>
		<meta name="MobileOptimized" content="320"/>
		<meta name="format-detection" content="telephone=no"/>
		<meta http-equiv="cleartype" content="on"/>
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title>收货地址-收礼物</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/trade.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>/css/offline_shop.css">
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script src="<?php echo TPL_URL;?>js/order_friend_share.js"></script>
		<script>
		var orderNo = "<?php echo $order_id ?>";
		</script>
	</head>
	<body>
		<div class="container wap-page-order">
			<div class="content confirm-container">
				<div class="app app-order">
					<div class="app-inner inner-order">
						<div class="block block-order block-border-top-none">
							<div class="header">
								<span>店铺：<a href="./home.php?id=<?php echo $store['store_id'] ?>"><?php echo $store['name'] ?></a></span>
							</div>
							<hr class="margin-0 left-10"/>
							<div class="block block-list block-border-top-none block-border-bottom-none">
								<?php 
								foreach($order['proList'] as $value){
								?>
									<div class="block-item name-card name-card-3col clearfix js-product-detail">
										<a href="javascript:;" class="thumb">
											<img class="js-view-image" src="<?php echo $value['image'];?>" alt="<?php echo $value['name'];?>"/>
										</a>
										<div class="detail">
											<a href="./good.php?id=<?php echo $value['product_id'];?>&store_id=<?php echo $store['store_id'] ?>"><h3><?php echo $value['name'];?></h3></a>
											<?php
												if($value['sku_data_arr']){
													foreach($value['sku_data_arr'] as $v){
											?>
														<p class="c-gray ellipsis"><?php echo $v['name'];?>：<?php echo $v['value'];?></p>
											<?php 
													}
												}
											?>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
						<div>
							<div class="block js-card-container">
								<div class="js-user_coupon block-item order-total" style="text-align:left;">
									赠言：
									<p style="text-indent: 2em;"><?php echo htmlspecialchars($order['send_other_comment']) ?></p>
								</div>
							</div>
						</div>
						<div>
							<div class="block js-card-container">
								<div class="js-user_coupon block-item order-total" style="text-align:left;">
									有效期：<?php echo date('Y-m-d H:i:s', $order['paid_time'] + $order['send_other_hour'] * 3600) ?>之前
									<?php 
									if (time() - $order['paid_time'] > $order['send_other_hour'] * 3600) {
										echo '<span style="color: red;">已过期</span>';
									}
									?>
									<br />
									领取数：总共<?php echo $order['send_other_number'] ?>份，已领取<?php echo $count ?>份，还剩<?php echo $order['send_other_number'] - $count ?>份
								</div>
							</div>
						</div>
						
						<?php 
						if ($order_friend_address || $share_valid) {
						?>
							<div id="js-logistics-container" class="block express">
								<div class="block-item logistics">
									<h4 class="block-item-title">
										收货地址 <?php echo $order_friend_address ? '<span style="color: red;">您已领取</span>领取时间：' . date('Y-m-d H:i:s', $order_friend_address['dateline']) : '' ?>
									</h4>
								</div>
								<div class="js-logistics-content logistics-content">
									<div>
										<div class="block block-form block-border-top-none block-border-bottom-none">
											<?php 
											if ($order_friend_address) {
											?>
												<div class="clearfix block-item self-fetch-info-show">
													<label>收货人姓名：</label><span><?php echo $order_friend_address['name'] ?></span>
												</div>
												<div class="clearfix block-item self-fetch-info-show ">
													<label>联系方式：</label><span><?php echo $order_friend_address['phone'] ?></span>
												</div>
												<div class="clearfix block-item self-fetch-info-show ">
													<label>地址：</label>
													<span>
														<?php 
														$address = unserialize($order_friend_address['address']);
														echo $address['province'] . $address['city'] . $address['area'] . $address['address'];
														?>
													</span>
												</div>
											<?php 
											} else {
											?>
												<div class="clearfix block-item self-fetch-info-show">
													<label>收货人姓名：</label>
													<input placeholder="姓名" class="txt txt-black ellipsis js-name" value="" >
												</div>
												<div class="clearfix block-item self-fetch-info-show ">
													<label>联系方式：</label>
													<input type="text" value="" placeholder="手机号码" class="txt txt-black ellipsis js-phone">
												</div>
												<div class="clearfix block-item self-fetch-info-show ">
													<label>选择地区：</label>
													<span>
														<select style="width:80px; margin:0px;" class="address-province" name="province" id="province">
															<option value="">
																省
															</option>
														</select>
													</span>
													<span>
														<select style="width:80px; margin:0px;" class="address-city" name="city" id="city">
															<option>
																城市
															</option>
														</select>
													</span>
													<span>
														<select style="width:80px; margin:0px;" class="address-county" name="county" id="county">
															<option>
																区县
															</option>
														</select>
													</span>
												</div>
												<div class="clearfix block-item self-fetch-info-show ">
													<label>详细地址：</label>
													<input type="text" value="" placeholder="详细地址,最多120个字符" class="txt txt-black ellipsis js-address" max-length="120" />
												</div>
											<?php 
											}
											?>
										</div>
										<div class="js-logistics-tips logistics-tips font-size-12 c-orange hide">
											很抱歉，该地区暂不支持配送。
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php 
					}
					?>
					
					<div class="app-inner inner-order peerpay-gift" style="display:;">
						<div class="action-container">
							<?php 
							if ($share_valid) {
							?>
								<button class="btn btn-green btn-block js-save">确认收货地址</button>
							<?php 
							}
							if (time() - $order['paid_time'] < $order['send_other_hour'] * 3600) {
							?>
								<button class="btn btn-white btn-block js-open-share">分享给小伙伴</button>
							<?php 
							}
							?>
						</div>
					</div>
				</div>
			</div>
			<div id="js-share-guide" class="js-fullguide fullscreen-guide hide" style="font-size: 16px; line-height: 35px; color: #fff; text-align: center;"><span class="js-close-guide guide-close">×</span><span class="guide-arrow"></span><div class="guide-inner">请点击右上角<br>通过【发送给朋友】功能<br>或【分享到朋友圈】功能<br>把礼物分享给小伙伴哟～</div></div>
			<?php $noFooterLinks=true; include display('footer');?>
		</div>
		<?php echo $shareData ?>
	</body>
</html>