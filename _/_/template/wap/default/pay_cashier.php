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
		<script src="<?php echo TPL_URL;?>js/pay_cashier.js?time=<?php echo time() ?>"></script>
		<script>
		var order_no = "<?php echo $nowOrder['order_id']; ?>";
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
						<div class="block block-order block-border-top-none" data-id="<?php echo $nowOrder['order_id']; ?>" data-float-amount="<?php echo $nowOrder['price']; ?>">
							<div class="header">
								<span><a href="./home.php?id=<?php echo $store['store_id'];?>">
                        <img class="circular" src="<?php echo $store['logo'];?>" alt="<?php echo $store['name'];?>">
                    </a><br/>
								门店：<?php echo $store['name'];?></span>
								<span class="c-orange">扫码支付订单</span>
								
							</div>
							<hr class="margin-0 left-10"/>
							<div class="bottom js-sub_total">订单编号：<span class="c-orange pull-right"><?php echo $cashierOrder['trade_no']?></span></div>
							<div class="bottom js-sub_total">支付金额：<span class="c-orange pull-right">￥<?php echo $cashierOrder['price']?></span></div>
							
						</div>
					
			        </div>
			  </div>	
			<div id="js-self-fetch-modal" class="modal order-modal"></div>
			<?php $noFooterLinks=true; include display('footer');?>
		</div>
	</div>	
	</body>
</html>
<?php Analytics($platform_margin_log['store_id'], 'pay_platform', '订单支付', $platform_margin_log['order_id']); ?>