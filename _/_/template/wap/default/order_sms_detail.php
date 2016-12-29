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
		<title><?php if ($nowOrder['status'] == 1) { echo '已支付';} else if ($nowOrder['status'] == 0) {echo '未支付';}?>的订单</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/trade.css"/>
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script>var orderNo='<?php echo $nowOrder['order_no_txt'];?>';</script>
		<script src="<?php echo TPL_URL;?>js/order_paid.js"></script>
	</head>
	<body>
		<div class="container js-page-content wap-page-order">
			<div class="content confirm-container">
				<div class="app app-order">
					<div class="app-inner inner-order" id="js-page-content">
                        <!-- 订单状态 -->
						<div class="important-message">
							<!-- 客户看 -->
							<h3>
								订单状态：
								<?php 
								
									if ($nowOrder['status'] == 1) {
										echo '已支付';
									} else if ($nowOrder['status'] == 0) {
										echo '未支付';
									} else {
										echo $nowOrder['status_txt'];
									}
								
								?>
								
									&#12288;支付方式：微信支付
								
						
								<a href="javascript:;" class="js-open-share c-blue pull-right hide">分享</a>
							</h3>
							<hr/>
						
						</div>

                        <!-- 商品列表 -->

						<!-- 物流信息 -->

						<!-- 满减送优惠信息 -->

						<!-- 支付 -->
						<div class="block block-bottom-0">
							<div class="js-order-total block-item order-total">
								
								<strong class="js-real-pay c-orange js-real-pay-temp">实付：￥<?php echo $nowOrder['money'];?></strong>
								<p>下单时间：<?php echo date('Y-m-d H:i:s',$nowOrder['dateline']);?></p>
							</div>
							<?php if($nowOrder['status'] == 1){ ?>
								<div class="block-item paid-time">
									<div class="paid-time-inner">
										<p>订单号：<?php echo $nowOrder['smspay_no'];?></p>
											<p class="c-gray"><?php echo date('Y-m-d H:i:s',$nowOrder['pay_dateline']);?><br/>完成付款</p>
									</div>
								</div>
							<?php } ?>
							<?php 
							if ($nowOrder['status'] < 2 && $nowOrder['payment_method'] == 'peerpay') {
							?>
								<div class="action-container" id="confirm-pay-way-opts" style="margin-top:20px;margin-bottom:20px;">
									<a href="./order_share_pay.php?orderid=<?php echo $nowOrder['order_no_txt'] ?>" class="btn btn-block btn-large btn-green">去付款</a>
								</div>
							<?php
							}
							?>
						</div>
						
				
							<style>
							.peerpay_list td {border-bottom:1px dashed #d9d9d9; height:24px; line-height:24px; }
							</style>
							<div class="block block-form" style="margin-top:5px; margin-bottom:5px;">
								<!-- 快递 -->
								<div class="block-item peerpay_list" style="padding:20px 0;">
									<table style="width:100%;">
										<tr>
											<td align="center">购买条数</td>
											<td align="center">付款时间</td>
											<td align="center">付款金额</td>
										</tr>
										<?php 
										if ($nowOrder) {
											
										?>
												<tr>
													<td align="center"><?php echo htmlspecialchars($nowOrder['sms_num']) ?>条</td>
													<td align="center"><?php echo date('Y-m-d H:i', $nowOrder['pay_dateline']) ?></td>
													<td align="center">￥<?php echo $nowOrder['money'] ?></td>
												</tr>
												
										<?php
										} else {
										?>
											<tr style="height:40px; text-align:center;">
												<td colspan="3">暂无代付</td>
											</tr>
										<?php
										}
										?>
									</table>
								</div>
							</div>
				
						<div class="block block-top-0 block-border-top-none center">
							<div class="center action-tip js-pay-tip">支付完成后，若短信功能未生效请凭订单号联系平台</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>

		<?php echo $shareData;?>
	</body>
</html>