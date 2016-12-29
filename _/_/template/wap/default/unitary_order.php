<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js" lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<meta name="HandheldFriendly" content="true"/>
		<meta name="MobileOptimized" content="320"/>
		<meta name="format-detection" content="telephone=no"/>
		<meta http-equiv="cleartype" content="on"/>
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title>夺宝订单</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/trade.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>/css/offline_shop.css">
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript">
			var noCart=true,
			orderid='<?php echo $nowOrder['orderid'];?>',
			pay_no='<?php echo $nowOrder['orderid'];?>',
			unitary_total='<?php echo $nowOrder['price'];?>',
			pay_redirect='<?php echo option('config.site_url').'/webapp.php?c=unitary&a=payend&orderid='.$nowOrder['orderid']; ?>',
			isLogin=!<?php echo intval(empty($wap_user));?>;
		</script>
		<script src="<?php echo TPL_URL;?>js/unitary_order_pay.js?id=<?php echo time();?>"></script>
		<script src="http://api.map.baidu.com/api?v=1.2" type="text/javascript"></script>
		<script type="text/javascript">
		var postage = '<?php echo $nowOrder['postage'] ?>';
		var is_logistics = true;
		var is_selffetch = false;
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
								<span>来自店铺【<?php echo $now_store['name']; ?>】的夺宝活动订单</span>
							</div>
							<!-- 增加活动名称列表 + 对应的购买数量 -->
							<hr class="margin-0 left-10"/>
							<div class="block block-list block-border-top-none block-border-bottom-none">
								<?php foreach ($cart_list as $val) { ?>
								<div class="block-item name-card name-card-3col clearfix js-product-detail">
									<a href="javascript:;" class="thumb">
										<img class="js-view-image" src="<?php echo $val['unitary']['logopic'] ?>" alt="<?php echo $val['unitary']['name'] ?>">
									</a>
									<div class="detail">
										<a href="javascript:void(0);"><h3><?php echo $val['unitary']['name']; ?></h3></a>
									</div>
									<div class="right-col">
										<div class="price">单价 ￥<span><?php echo $val['unitary']['item_price']; ?></span></div>
										<div class="num">
											×<span class="num-txt"><?php echo $val['count']; ?></span>
										</div>
									</div>
								</div>
								<?php } ?>
							</div>
							<hr class="margin-0 left-10"/>
						</div>
						<!-- 物流 -->
						<div class="block express" id="js-logistics-container">
							<?php if($nowOrder['paid'] < 1){ ?>
								<div class="js-logistics-content logistics-content js-express">
									<?php if($userAddress && $now_store['open_logistics']){ ?>
										<div>
											<div class="block block-form block-border-top-none block-border-bottom-none">
												<div class="js-order-address express-panel" style="padding-left:0;">
													<?php if($nowOrder['paid'] == 0){ ?>
														<div class="opt-wrapper">
															<a href="javascript:;" class="btn btn-xxsmall btn-grayeee butn-edit-address js-edit-address">修改</a>
														</div>
													<?php } ?>
													<ul>
														<li><span><?php echo $userAddress['name']; ?></span>, <?php echo $userAddress['tel']; ?></li>
														<li><?php echo $userAddress['province_txt']; ?> <?php echo $userAddress['city_txt']; ?> <?php echo $userAddress['area_txt']; ?></li>
														<li><?php echo $userAddress['address']; ?></li>
													</ul>
												</div>
											</div>
											<div class="js-logistics-tips logistics-tips font-size-12 c-orange hide">很抱歉，该地区暂不支持配送。</div>
										</div>
									<?php } else { ?>
										<div>
											<div class="js-order-address express-panel">
												<?php 
												if ($now_store['open_logistics']) {
												?>
													<div class="js-edit-address address-tip"><span>添加收货地址</span></div>
												<?php 
												} else if ($is_all_selfproduct && $now_store['buyer_selffetch'] && $selffetch_list) {
												?>
													<div class="js-selffetch-address address-tip"><span>选择门店</span></div>
												<?php 
												}
												?>
												
											</div>
										</div>
									<?php } ?>
								</div>
								<div class="js-logistics-content logistics-content js-self-fetch hide"></div>
								<input type="hidden" name="address_id" id="address_id" value="<?php echo intval($userAddress['address_id']); ?>"/>
								<input type="hidden" name="selffetch_id" id="selffetch_id" value="0"/>
							<?php 
								}else{
							?>
										<div>
											<div class="block block-form block-border-top-none block-border-bottom-none">
												<div class="js-order-address express-panel" style="padding-left:0;">
													<ul>
														<li><span><?php echo $nowOrder['address_user']; ?></span>, <?php echo $nowOrder['address_tel']; ?></li>
														<li><?php echo $nowOrder['address']['province'];?> <?php echo $nowOrder['address']['city'];?> <?php echo $nowOrder['address']['area'];?></li>
														<li><?php echo $nowOrder['address']['address'];?></li>
													</ul>
												</div>
											</div>
											<div class="js-logistics-tips logistics-tips font-size-12 c-orange hide">很抱歉，该地区暂不支持配送。</div>
										</div>
							<?php
								}
							?>
						</div>
						<!-- 支付 -->
						<div class="js-step-topay <?php if($nowOrder['sms_total'] == '0.00' && $nowOrder['status']==0){ ?>hide<?php }?>">
							<div class="block">
								<div class="js-order-total block-item order-total">
									<strong class="js-real-pay c-orange js-real-pay-temp">需付：￥<span id="js-total"><?php echo $nowOrder['margin_amount']; ?></span></strong>
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
				</div>
			</div>
			<div id="js-self-fetch-modal" class="modal order-modal"></div>
			<?php $noFooterLinks=true; include display('footer');?>
		</div>
	</body>
</html>
<?php Analytics($nowOrder['store_id'], 'pay', '订单支付', $nowOrder['order_id']); ?>