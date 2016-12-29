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
		<title>待付款的订单</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/trade.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>/css/offline_shop.css">
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script src="<?php echo TPL_URL;?>js/pay_platform.js?time=<?php echo time() ?>"></script>
		<script>
		var order_no = "<?php echo $platform_margin_log['order_no']; ?>";
		var noCart = true;
		</script>
		<style>
			.qrcodepay {display:none;margin:0 10px 10px 10px;}
			.qrcodepay .item1{background:#fff;border:1px solid #e5e5e5;}
			.qrcodepay .title{margin:0 10px;padding:10px 0;border-bottom:1px solid #efefef;}
			.qrcodepay .info{text-align:center;line-height:25px;font-size:12px;}
			.qrcodepay .qrcode{margin-bottom:10px;}
			.qrcodepay .qrcode img{width:200px;height:200px;}		
			.qrcodepay .item2 {background:#fff;border:1px solid #e5e5e5;margin:10px 0;line-height:40px;text-align:center;}
			.qrcodepay .item2 a{display:block;height:100%;width:100%;}
		</style>
	</head>
	<body>
		<div class="container js-page-content wap-page-order">
			<div class="content confirm-container">
				<div class="app app-order">
					<div class="app-inner inner-order" id="js-page-content">
						<!-- 通知 -->
						<!-- 商品列表 -->
						<div class="block block-order block-border-top-none" data-id="<?php echo $nowOrder['order_id']; ?>" data-float-amount="<?php echo $nowOrder['float_amount']; ?>">
							<div class="header">
								<span>店铺：<?php echo $store['name'];?></span>
								<span class="c-orange">平台保证金充值订单</span>
							</div>
							<hr class="margin-0 left-10"/>
							<div class="bottom js-sub_total">充值金额：<span class="c-orange pull-right">￥<?php echo $platform_margin_log['amount']?></span></div>
						</div>
						
						<!-- 支付 -->
						<div class="js-step-topay <?php if($platform_margin_log['amount'] == '0.00' && $platform_margin_log['status'] == 2){ ?>hide<?php }?>">
							<div class="block">
								<div class="js-order-total block-item order-total">
									<strong class="js-real-pay c-orange js-real-pay-temp">需付：￥<span id="js-total"><?php echo number_format(($platform_margin_log['amount'] ), 2, '.', ''); ?></span></strong>
								</div>
							</div>
							<div class="action-container sss" id="confirm-pay-way-opts">
								<?php
								if($payment_methods_list){
									$i = 1;
									foreach($payment_methods_list as $key => $value){
								?>
										<div style="margin-bottom:10px;">
											<button type="button" data-pay-type="<?php echo $value['type'];?>" class="btn-pay btn btn-block btn-large btn-peerpay <?php echo $i == 1 ? 'btn-green' : 'btn-white'; ?>"><?php echo $value['name']?></button>
										</div>
								<?php
										$i++;
									}
								}
								?>
							</div>
							<div class="app-inner inner-order qrcodepay ddd" id="confirm-qrcode-pay">
								<div class="item1">
									<ul class="round" id="cross_pay">
										<li class="title mb" style="text-align:center">
											<span class="none">微信扫码支付</span>
										</li>
										<li class="info">遇到跨号支付？请使用扫码支付完成付款</li>
										<li class="qrcode">
											<table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
												<tr>
													<td style="text-align:center" >
														<img src="" id="pay-qrcode">
													</td>
												</tr>
												<tr>
													<td style="padding-top:10px;text-align:center">长按图片[识别二维码]付款</td>
												</tr>
											</table>
										</li>
									</ul>
								</div>
								<div class="item2"><a class="other-pay" href="./pay.php?id=<?php echo $nowOrder['order_no_txt'];?>" >其他支付方式</a></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="js-self-fetch-modal" class="modal order-modal"></div>
			<?php $noFooterLinks=true; include display('footer');?>
		</div>
	</body>
</html>
<?php Analytics($platform_margin_log['store_id'], 'pay_platform', '订单支付', $platform_margin_log['order_id']); ?>