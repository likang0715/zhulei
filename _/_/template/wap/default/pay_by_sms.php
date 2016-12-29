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
		<title>待付款短信的订单</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/trade.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>/css/offline_shop.css">
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script>var noCart=true,orderNo='<?php echo $nowOrder['smspay_no'];?>',sms_total=<?php echo $nowOrder['money'];?>,isLogin=!<?php echo intval(empty($wap_user));?>,selffetchList='<?php echo $selffetch_list ? json_encode($selffetch_list) : '';?>';</script>
		<script src="<?php echo TPL_URL;?>js/pay_by_sms.js?id=<?php echo time();?>"></script>
		<script src="http://api.map.baidu.com/api?v=1.2" type="text/javascript"></script>
		<script>
		var postage = '<?php echo $nowOrder['postage'] ?>';
		var is_logistics = <?php echo ($now_store['open_logistics'] || $is_all_supplierproduct) ? 'true' : 'false' ?>;
		var is_selffetch = <?php echo ($now_store['buyer_selffetch'] && $is_all_selfproduct) ? 'true' : 'false' ?>;
		</script>
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
								<span>买家昵称：<?php echo $user['nickname'];?></span>
							</div>
							<hr class="margin-0 left-10"/>
							<div class="block block-list block-border-top-none block-border-bottom-none">
								<?php if(isset($_GET['orderName'])){?>
									<div class="block-item name-card name-card-3col clearfix">
										<div class="detail" style="margin-left:0px;">
											<a href="javascript:void(0)"><h3><?php echo $_GET['orderName'];?></h3></a>
										</div>
										<div class="right-col">
											<div class="price">￥<span><?php echo $nowOrder['sms_total']?></span></div>
											<div class="num">×<span class="num-txt">1</span></div>
										</div>
									</div>
								<?php } ?>

							</div>
							<hr class="margin-0 left-10"/>

							<div class="bottom">短信购买条数<span class="c-orange pull-right">￥<?php echo $nowOrder['sms_num']?></span></div>
							<div class="bottom">短信单价<span class="c-orange pull-right">￥<?php echo $nowOrder['sms_price']*1/100;?></span></div>
							<div class="bottom">总价<span class="c-orange pull-right">￥<?php echo $nowOrder['money']?></span></div>
						</div>
						<!-- 物流 -->

						<!-- 满减送 -->
						<?php
						if ($reward_list) {
						?>
							<div>
								<div class="block">
									<div class="js-order-total block-item order-total" style="text-align:left;">
										<?php
										$reward_money = 0;
										foreach ($reward_list as $key => $reward) {
											if ($key === 'product_price_list') {
												continue;
											}

											if (isset($reward['content'])) {
												$reward = $reward['content'];
											}
											$reward_money += $reward['cash'];
										?>
											<p><span style="padding:0px 5px; background:#f60; color:white; border-radius:3px;">满减</span><?php echo getRewardStr($reward) ?></p>
										<?php
										}
										?>
									</div>
								</div>
							</div>
						<?php
						}
						
						?>




						<!-- 支付 -->
						<div class="js-step-topay <?php if($nowOrder['sms_total'] == '0.00' && $nowOrder['status']==0){ ?>hide<?php }?>">
							<div class="block">
								<div class="js-order-total block-item order-total">
                                    <strong class="js-real-pay c-orange js-real-pay-temp">需付：￥<span id="js-total">3<?php echo $nowOrder['money']; ?></span></strong>
								</div>
							</div>
							<div class="action-container" id="confirm-pay-way-opts">
                                <?php if(!empty($sync_user)){ ?>
                                <div style="margin-bottom:10px;">
                                    <button type="button" data-pay-type="<?php echo $value['type'];?>" class="btn-pay btn btn-block btn-large btn-peerpay btn-green go-pay">去付款</button>
                                </div>
                                <?php }else{ ?>
                                <?php
									if($payList){
										$i=1;
										foreach($payList as $value){
											if ($value['type'] == 'offline' && $nowOrder['shipping_method'] == 'friend') {
												continue;
											}
								?>
											<div style="margin-bottom:10px;">
												<button type="button" data-pay-type="<?php echo $value['type'];?>" class="btn-pay btn btn-block btn-large btn-peerpay <?php if($i==1){echo 'btn-green';}else{echo 'btn-white';}?>"><?php echo $value['name']?></button>
											</div>
								<?php
											$i++;
										}
									}else{
										$i=1;
										foreach($payMethodList as $value){
											if ($value['type'] == 'offline' && $nowOrder['shipping_method'] == 'friend') {
												continue;
											}
								?>
											<div style="margin-bottom:10px;">
												<button type="button" data-pay-type="<?php echo $value['type'];?>" class="btn-pay btn btn-block btn-large btn-peerpay <?php if($i==1){echo 'btn-green';}else{echo 'btn-white';}?>"><?php echo $value['name']?></button>
											</div>
								<?php
											$i++;
										}
									}
								?>
                                <?php } ?>
							</div>

							<div class="center action-tip js-pay-tip">支付完成后，如需退换货请及时联系卖家</div>
						</div>
					</div>
					<div class="app-inner inner-order peerpay-gift" style="display:none;" id="sku-message-poppage">
						<div class="js-list block block-list"></div>
						<h2>备注信息</h2>
						<ul class="block block-form js-message-container"></ul>
						<div class="action-container">
							<button class="btn btn-white btn-block js-cancel">查看订单详情</button>
						</div>
					</div>
				</div>
			</div>
			<div id="js-self-fetch-modal" class="modal order-modal"></div>

			<div class="js-confirm-use-coupon confirm-use-coupon" style="display:none;">
				<span class="js-total-privilege">总优惠：¥0.00</span>
				<button type="button" class="js-confirm-coupon btn btn-blue btn-xsmall font-size-14">确定</button>
			</div>
			<?php $noFooterLinks=true; include display('footer');?>
		</div>
	</body>
</html>
<?php Analytics($nowOrder['store_id'], 'pay', '订单支付', $nowOrder['order_id']); ?>