<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js" lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<title>用户创建订单-<?php echo option('config.site_name') ?></title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/my_offline.css">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/font-awesome.min.css">
	<style>
	.motify{
		display:none;
		position:fixed;
		top:35%;
		left:50%;
		width:220px;
		padding:0;
		margin:0 0 0 -110px;
		z-index:9999;
		background:rgba(0, 0, 0, 0.8);
		color:#fff;
		font-size:14px;
		line-height:1.5em;
		border-radius:6px;
		-webkit-box-shadow:0px 1px 2px rgba(0, 0, 0, 0.2);
		box-shadow:0px 1px 2px rgba(0, 0, 0, 0.2);
		@-webkit-animation-duration 0.15s;
		@-moz-animation-duration 0.15s;
		@-ms-animation-duration 0.15s;
		@-o-animation-duration 0.15s;
		@animation-duration 0.15s;
		@-webkit-animation-fill-mode both;
		@-moz-animation-fill-mode both;
		@-ms-animation-fill-mode both;
		@-o-animation-fill-mode both;
		@animation-fill-mode both;
	}
	.motify .motify-inner{
		padding:10px 10px;
		text-align:center;
		word-wrap:break-word;
	}
	.motify p{
		margin:0 0 5px;
	}
	.motify p:last-of-type{
		margin-bottom:0;
	}
	@-webkit-keyframes motifyFx{
		0%{-webkit-transform-origin:center center;-webkit-transform:scale(1);opacity:1;}
		100%{-webkit-transform-origin:center center;-webkit-transform:scale(0.85);}
	}
	@-moz-keyframes motifyFx{
		0%{-moz-transform-origin:center center;-moz-transform:scale(1);opacity:1;}
		100%{-moz-transform-origin:center center;-moz-transform:scale(0.85);}
	}
	@keyframes motifyFx{
		0%{-webkit-transform-origin:center center;-moz-transform-origin:center center;transform-origin:center center;-webkit-transform:scale(1);-moz-transform:scale(1);transform:scale(1);opacity:1;}
		100%{-webkit-transform-origin:center center;-moz-transform-origin:center center;transform-origin:center center;-webkit-transform:scale(0.85);-moz-transform:scale(0.85);transform:scale(0.85);}
	}
	.motifyFx{@-webkit-animation-name motifyFx;@-moz-animation-name motifyFx;@-ms-animation-name motifyFx;@-o-animation-name motifyFx;@animation-name motifyFx;}
		
	</style>
	<script>
	var store_id = "<?php echo $store['store_id'] ?>";
	var credit_setting = <?php echo json_encode(option('credit')) ?>;
	var noCart = true;
	</script>
	<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script src="<?php echo STATIC_URL;?>js/fastclick.js"></script>
	<script src="<?php echo TPL_URL;?>js/user_offline.js?time=<?php echo time() ?>"></script>
	<script src="<?php echo TPL_URL;?>js/base.js"></script>
</head>
<body>
	<div class="order-banner"><img src="<?php echo TPL_URL;?>images/orderbanner.jpg" alt=""></div>
	<div class="order-banner-con">
		<div class="order-banner-con-tit">
			<span class="fl order-con-fl">店铺名称</span>
			<span class="orange order-con-fr fl"><?php echo htmlspecialchars($store['name']) ?></span>
			<div class="clear"></div>
		</div>
		<div class="order-banner-xq">
			<span class="fl order-con-fl">订单总额</span>
			<input class="fl order-con-fr order-banner-con-inp js-total" placeholder="请输入订单总额" type="text">
			<div class="clear"></div>
		</div>

		<section class="logistics order-jf" style="display: <?php echo option('credit.platform_credit_use_value') ? '' : 'none' ?>">
			<div class="logistics-info">
				<div class="integral integral-order">
					<div class="fl">您现有<?php echo option('credit.platform_credit_name') ?>：<span class="js-user_point_balance"><?php echo $user['point_balance'] ?></span></div>
					<div class="fr">本单可用：<span class="js-platform_point_max">0</span></div>
					<div class="clear"></div>
				</div>
				<input type="text" class="integral-inp order-integral-inp js-platform_point" placeholder="使用的积分数量,全额或0" readonly="readonly" />
			</div>
		</section>

		<div class="order-banner-xq order-textarea">
			<span class="fl order-con-fl">备注信息</span>
			<textarea class="fl order-con-fr order-banner-con-textarea js-comment"  placeholder="请输入备注信息"></textarea>
			<div class="clear"></div>
		</div>
	</div>
	<div class="btn js-next_btn">下一步</div>
</html>