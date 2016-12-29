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
		<title>找人代付</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/trade.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>/css/offline_shop.css">
		<link rel="stylesheet" href="<?php echo TPL_URL;?>/css/order_share.css">
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script src="<?php echo TPL_URL;?>js/order_share_pay.js?time=<?php echo time() ?>"></script>
		<script>
		var pay_type = "<?php echo $nowOrder['peerpay_type'] ?>";
		</script>
	</head>
	<body>
		<div class="container js-page-content wap-page-order">
			<div class="content confirm-container">
				<div class="app app-order  peerpay-gift ">
					<div id="peerpay-content-container">
						<div class="message-container center" style="<?php echo $peerpay_custom_field['img'] ? 'background-image:url(' . $peerpay_custom_field['img'] . ');background-repeat: no-repeat; background-position: center center; background-size: cover;' : '' ?>">
							<div class="wrapper">
								<div class="outer-wrapper">
									<div class="table-wrapper">
										<div class="table-cell-wrapper message">
											<span class="time-line-title" id="wxdesc" style="color:#3917b0;">
												<?php echo $nowOrder['peerpay_content'] ? $nowOrder['peerpay_content'] : '' ?>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="avatar avatar-peerpay center">
								<img class="circular" src="<?php echo TPL_URL;?>/images/avatar2.png">
								<p class="js-counter-msg">
									<span class="txt-status" style="color:#3917b0;">
										等待真爱路过...
									</span>
								</p>
							</div>
							<div class="bottom-arrow"></div>
						</div>
						<div class="block progress">
							<div class="progress-bar shine">
								<span style="width: <?php echo $peerpay_money_per ?>;"></span>
							</div>
							<div class="progress-txt">
								<span class="pull-left">已完成：<em><?php echo $peerpay_money_per ?></em></span>
								<span class="pull-right">
									还差：<em><?php echo $money_cha ?>元</em>
								</span>
							</div>
						</div>
						<h2>来自小伙伴的代付订单</h2>
						<div class="block block-list block-list-peerpay">
							
							<?php
							foreach($nowOrder['proList'] as $value) {
							?>
								
								<div class="block-item name-card clearfix">
									<a href="./good.php?id=<?php echo $value['product_id'] ?>" class="thumb">
										<img src="<?php echo $value['image'];?>" alt="<?php echo $value['name'];?>" />
									</a>
									<div class="detail clearfix no-price detail-peerpay">
										<h3>
											<a class="ellipsis" href="./good.php?id=<?php echo $value['product_id'] ?>">
												<?php echo $value['name'] ?>
											</a>
										</h3>
										<?php
											if($value['sku_data_arr']){
												foreach($value['sku_data_arr'] as $v){
										?>
													<p class="c-gray ellipsis"><?php echo $v['name'];?>：<?php echo $v['value'];?></p>
										<?php 
												}
											}
										?>
										<p class="ellipsis c-orange">￥<?php echo number_format($value['pro_num']*$value['pro_price'],2) ?></p>
									</div>
									<a href="./good.php?id=<?php echo $value['product_id'] ?>" class="btn btn-goods-link">查看商品</a>
								</div>
							<?php
							}
							?>
						</div>
						<!-- 代付人信息 -->
						<?php 
						if ($is_pay_btn && !$order_over) {
						?>
							<h2>付款人信息</h2>
							<ul class="block block-form">
								<li class="block-item clearfix">
									<label>我的姓名</label>
									<input class="txt txt-black ellipsis js-name" placeholder="请输入您的姓名" value="">
								</li>
								<li class="block-item clearfix">
									<label>给他留言</label>
									<textarea class="txt txt-black js-content" placeholder="说点什么吧？" maxlength="200"></textarea>
								</li>
							</ul>
							<ul class="block block-form" style="margin-top:10px;">
								<li class="block-item clearfix relative">
									<label>付款金额</label>
									<div class="price-container clearfix">
										<span class="price" style="width:20px;">￥</span>
										<input class="txt txt-black js-money price clearfix" placeholder="最多可代付<?php echo $money_max ?>元" data-max="<?php echo $money_max ?>" value="<?php echo $money_fu ?>" <?php echo $nowOrder['peerpay_type'] == 1 ? 'readonly="readonly"' : ''?> />
									</div>
									<?php 
									if ($nowOrder['peerpay_type'] != 1) {
									?>
										<button class="btn btn-clear">修改</button>
									<?php 
									}
									?>
								</li>
							</ul>
						<?php 
						}
						?>
						<div class="action-container" id="confirm-pay-way-opts" style="margin-top:20px;margin-bottom:20px;">
							<?php 
							if ($nowOrder['total'] - $peerpay_money > 0 && $is_pay_btn && !$order_over) {
							?>
								<button type="button" data-pay-type="weixin_peerpay" class="btn-pay btn btn-block btn-large btn-peerpay btn-green" data-order-id="<?php echo $order_id ?>">微信支付</button>
							<?php 
							}
							?>
							<a href="./good.php?id=<?php echo $value['product_id'] ?>" class="btn btn-block btn-large btn-white">我也要去玩</a>
							<?php 
							if ($nowOrder['total'] - $peerpay_money > 0 && !$order_over) {
							?>
								<button style="margin-top:0; type=" button"="" class="btn btn-block btn-large btn-white js-open-share">找小伙伴帮TA付款</button>
							<?php 
							}
							?>
						</div>
					</div>
				</div>
			</div>
			<?php $noFooterLinks=true; include display('footer');?>
		</div>
		<div id="js-share-guide" class="js-fullguide fullscreen-guide hide" style="font-size: 16px; line-height: 35px; color: #fff; text-align: center;"><span class="js-close-guide guide-close">×</span><span class="guide-arrow"></span><div class="guide-inner">请点击右上角<br>通过【发送给朋友】功能<br>或【分享到朋友圈】功能<br>把消息告诉小伙伴哟～</div></div>
		<?php echo $shareData ?>
	</body>
</html>
<?php Analytics($nowOrder['store_id'], 'pay', '订单支付', $nowOrder['order_id']); ?>