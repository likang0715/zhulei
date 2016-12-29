<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8"/> 
	<title>支付设置 - <?php echo $store_session['name']; ?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>E点茶<?php } ?></title>
	<meta name="description" content="<?php echo $config['seo_description'];?>">
	<meta name="copyright" content="<?php echo $config['site_url'];?>"/>
	<meta name="renderer" content="webkit">
	<meta name="referrer" content="always">
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<!-- ▼ Base CSS -->
	<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
	<link href="<?php echo STATIC_URL;?>css/jquery.ui.css" type="text/css" rel="stylesheet" />
	<!-- ▲ Base CSS -->
	<!-- ▼ Payment CSS -->
	<link href="<?php echo TPL_URL;?>css/payment.css" type="text/css" rel="stylesheet"/>
	<!-- ▲ Payment CSS -->
	<!-- ▼ Constant JS -->
	<script type="text/javascript">
	var load_url="<?php dourl('load');?>";
	var wxpayText = '<div class="wxpay-alert-body js-content-region"><h4>请根据您的实际情况，选择一种方式：</h4><div class="wxpay-section"><h4>情况1：店铺已绑定“认证服务号”，且已向微信申请开通“微信支付权限”</h4><p class="description">您可以在此配置，使用自己的微信支付。货款直接入账至您的微信账户，由微信自动扣除每笔0.6%-2.0%交易手续费。</p><div class="action"><a href="javascript:;"class="ui-btn ui-btn-blue wxpay-btn-bind js-wxpay-change" data-set-wxpay-type="bind">立即启用</a></div></div><div class="wxpay-section"><h4>情况2：无论店铺是否绑定了微信公众号</h4><p class="description">您的店铺可以使用E点茶微信支付完成交易，并由您发起提现申请与E点茶结算相应收入。</p><p class="description">提现人工审核周期：当天18点前申请提现，当天审核完成，实际到账时间以银行入账时间为准。</p><div class="action"><a href="javascript:;"class="ui-btn ui-btn-blue wxpay-btn-unbind js-wxpay-change" data-set-wxpay-type="unbind">立即启用</a></div></div></div>';
	var wxpayBind = <?php if($weixin_bind_info['wxpay_key'] && $weixin_bind_info['wxpay_mchid']){?>true<?php }else{ ?>false<?php } ?>;
	var wxpayType = "<?php if($weixin_bind_info['wxpay_key'] && $weixin_bind_info['wxpay_mchid']){?>bind<?php }else{ ?>unbind<?php } ?>"
	</script>
	<!-- ▲ Constant JS -->
	<!-- ▼ Base JS -->
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
	<!-- ▲ Base JS -->
	<!-- ▼ Payment JS -->
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/wxpay.js"></script>
	<!-- ▲ Payment JS -->	
	<style type="text/css">
	.popover{
		display: block;
	}
	</style>
</head>
<body class="font14 usercenter">
	<?php include display('public:first_sidebar');?>
	<?php include display('setting:sidebar');?>
	<!-- ▼ Container-->
	<div id="container" class="clearfix container right-sidebar">
		<div id="container-left">
			<!-- ▼ Third Header -->
			<div id="third-header">
				<ul class="third-header-inner">
					<li>支付设置</li>
				</ul>
			</div>
			<!-- ▲ Third Header -->
			<!-- ▼ Container App -->
			<div class="container-app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="app__content js-app-main">
							<div class="page-payment">
								<div class="payment-block-wrap js-payment-block-wrap js-wxpay-region open">
									<div class="payment-block">
										<div class="payment-block-header js-wxpay-header-region">
											<h3>微信支付</h3>
											<label class="ui-switcher ui-switcher-small js-switch pull-right ui-switcher-<?php if($wxpay){?>on<?php }else{ ?>off<?php } ?>"></label>
										</div>
										<div class="payment-block-body js-wxpay-body-region">
											<!-- ▼ 代销微信支付 -->
											<div class="payment-type-body js-wxpay-dx <?php if($weixin_bind_info['wxpay_key'] && $weixin_bind_info['wxpay_mchid']){?>hide<?php } ?>">
												<form id="dx_form">
													<h4>E点茶微信支付（代销账户），您的店铺可以使用E点茶微信支付完成交易，并由您发起提现申请与E点茶结算相应收入。</h4>
													<div class="form-horizontal">
														<div class="control-group">
															<div class="controls">
																<p class="ui-message-warning pay-test-status">
																	注意：您正在使用E点茶微信支付账号。 用户的扫码支付，在线购买商品等所有交易，可以通过E点茶微信支付付款。
																</p>
															</div>
														</div>
														<div class="control-group">
															<label class="control-label">当前微信支付：</label>
															<div class="controls">
																<label class="text inline">
																	<span>微信支付 - 代销</span>
																	<a href="javascript:;" class="js-change-wxpay-type" data-wxpay-type="unbind">修改</a>
																</label>
															</div>
														</div>
														<div class="control-group">
															<label class="control-label">提现时间：</label>
															<div class="controls" style="padding-top: 5px;">
																提现审核周期为5个工作日，实际到账时间以银行入账时间为准
															</div>
														</div>
														<div class="control-group">
															<label class="control-label">交易手续费：</label>
															<div class="controls" style="padding-top: 5px;">
																平台服务费3.00%
															</div>
														</div>
														<!-- <div class="control-group">
															<label class="control-label">微信支付代销协议：</label>
															<div class="controls">
																<label class="checkbox inline">
																	<input name="wx_agreement" value="1" type="checkbox" checked="checked"/>
																	<a href="javascript:;">微信支付代销协议</a>
																</label>
															</div>
														</div> -->
													</div>
												</form>
											</div>
											<!-- ▲ 代销微信支付 -->	
											<!-- ▼ 自有微信支付 -->
											<div class="payment-type-body js-wxpay-zy <?php if($weixin_bind_info['wxpay_key'] && $weixin_bind_info['wxpay_mchid']){?><?php }else{?>hide<?php } ?>">
												<form id="zy_form">
													<h4>设置自有微信支付，买家使用微信支付购买商品时，货款将直接进入您微信支付对应的微信账户。</h4>
													<div class="form-horizontal">
														<div class="control-group">
															<div class="controls">
																<p class="ui-message-warning pay-test-status">
																	注意：使用自有微信支付，货款直接入账至您的微信账户，由微信自动扣除每笔0.6%-2.0%交易手续费。
																	订单如需退款，请自行通过微信商户后台手动完成退款操作，并在订单中做“标记退款”。
																</p>
															</div>
														</div>
														<div class="control-group">
															<label class="control-label">当前微信支付：</label>
															<div class="controls">
																<label class="text inline">
																	<span>微信支付 - 自有</span>
																	<a href="javascript:;" class="js-change-wxpay-type" data-wxpay-type="bind">修改</a>
																</label>
															</div>
														</div>
														<div class="control-group">
															<label class="control-label"><em class="required">*</em>商户号：</label>
															<div class="controls">
																<input class="span4" type="text" name="wxpay_mchid" value="<?php echo $weixin_bind_info['wxpay_mchid']?>" maxlength="10"/>
															</div>
														</div>
														<div class="control-group">
															<label class="control-label"><em class="required">*</em>密钥：</label>
															<div class="controls">
																<input class="span4" type="text" name="wxpay_key" value="<?php echo $weixin_bind_info['wxpay_key']?>" maxlength="32"/>
															</div>
														</div>
														<div class="control-group">
															<label class="control-label">微信支付状态：</label>
															<div class="controls">
																<label class="radio inline">
																	<input type="radio" name="wxpay_test" value="0" <?php if($weixin_bind_info['wxpay_test'] == 0){ ?>checked="checked"<?php } ?>/>全网支付已发布
																</label>
																<label class="radio inline">
																	<input type="radio" name="wxpay_test" value="1" <?php if($weixin_bind_info['wxpay_test'] == 1){ ?>checked="checked"<?php } ?>/>测试支付中
																</label>
																<p class="ui-message-warning pay-test-status js-pay-all">由于微信支付流程限制，该选项需由您进行设置。如您的微信支付已通过微信的审核并开通，请选择“全网支付已发布”状态，以保证粉丝能够在你的店铺正常使用微信支付进行交易。否则，请选择“测试支付中”；</p>
															</div>
														</div>
														<div class="control-group">
															<label class="control-label">微信网页授权：</label>
															<div class="controls">
																<label class="checkbox inline">
																	<input name="wx_domain_auth" value="1" type="checkbox" checked=""/>授权回调页面域名已设置为 “<?php echo getUrlDomain($config['site_url']);?>”
																</label>
															</div>
														</div>
														<div class="control-group">
															<div class="controls">
																<a href="javascript:;" class="ui-btn ui-btn-primary js-save">保存</a>
															</div>
														</div>
													</div>
												</form>
											</div>
											<!-- ▲ 自有微信支付 -->	
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include display('public:footer');?>
</body>
</html>