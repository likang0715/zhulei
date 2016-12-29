<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<html class="no-js" lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="HandheldFriendly" content="true">
<meta name="MobileOptimized" content="320">
<meta name="format-detection" content="telephone=no">
<meta http-equiv="cleartype" content="on">
<title>送他人-待付款的订单</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
<link rel="stylesheet" href="<?php echo TPL_URL;?>css/trade.css"/>
<link rel="stylesheet" href="<?php echo TPL_URL;?>/css/offline_shop.css">
<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
<script src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
<script src="<?php echo STATIC_URL;?>js/layer_mobile/layer.m.js"></script>
<script src="<?php echo TPL_URL;?>js/base.js"></script>
<script>var noCart=true,orderNo='<?php echo $order['order_no_txt'];?>',sub_total=<?php echo $order['sub_total'] + 0?>,isLogin=!<?php echo intval(empty($wap_user));?>,selffetchList='<?php echo $selffetch_list ? json_encode($selffetch_list) : '';?>';</script>
<script src="<?php echo TPL_URL;?>js/order_friend_pay.js"></script>
<script>
var postage = '<?php echo $order['postage'] ?>';
var is_logistics = <?php echo ($store['open_logistics'] || $is_all_supplierproduct) ? 'true' : 'false' ?>;
var is_selffetch = <?php echo ($store['buyer_selffetch'] && $is_all_selfproduct) ? 'true' : 'false' ?>;
var is_point = <?php echo $points_data ? 'true' : 'false' ?>;
var points_data = <?php echo json_encode($points_data) ?>;
var is_edit = <?php echo $order['status'] >= 1 ? 'false' : 'true' ?>;
var send_other_type = "<?php echo $type ?>";
var commonweal_address_list = <?php echo json_encode($commonweal_address_list) ?>;
</script>
<style>
.qrcodepay {
	display: none;
	margin: 0 10px 10px 10px;
}
.qrcodepay .item1 {
	background: #fff;
	border: 1px solid #e5e5e5;
}
.qrcodepay .title {
	margin: 0 10px;
	padding: 10px 0;
	border-bottom: 1px solid #efefef;
}
.qrcodepay .info {
	text-align: center;
	line-height: 25px;
	font-size: 12px;
}
.qrcodepay .qrcode {
	margin-bottom: 10px;
}
.qrcodepay .qrcode img {
	width: 200px;
	height: 200px;
}
.qrcodepay .item2 {
	background: #fff;
	border: 1px solid #e5e5e5;
	margin: 10px 0;
	line-height: 40px;
	text-align: center;
}
.qrcodepay .item2 a {
	display: block;
	height: 100%;
	width: 100%;
}
.reduce {cursor: pointer;}
.plus {cursor: pointer;}
</style>
</head>
<body>
<div class="container js-page-content wap-page-order">
	<div class="content confirm-container" style="min-height: 736px;">
		<div class="app app-order">
			<div class="app-inner inner-order" id="js-page-content"> 
				<div class="important-message">
					<h3>
						送他人类型：<?php echo $type == 1 ? '送单人' : ($type == 2 ? '送公益' : '送多人') ?>
					</h3>
				</div>
				<!-- 商品列表 -->
				<div class="block block-order block-border-top-none" data-id="<?php echo $order['order_id']; ?>" data-float-amount="<?php echo $order['float_amount']; ?>">
					<div class="header">
						<span>店铺：<?php echo $store['name'];?></span> 
					</div>
					<hr class="margin-0 left-10">
					<div class="block block-list block-border-top-none block-border-bottom-none">
						<?php 
						$product_number = 0;
						$supplier_money = 0;
						foreach ($order['proList'] as $value) {
							$product_number = $value['pro_num'];
						?>
						<div class="block-item name-card name-card-3col clearfix js-product-detail">
							<a href="javascript:;" class="thumb">
								<img class="js-view-image" src="<?php echo $value['image'] ?>" alt="<?php echo $value['name'] ?>"/>
							</a>
							<div class="detail">
								<a href="./good.php?id=<?php echo $value['product_id'] ?>&store_id=<?php echo $tmp_store_id; ?>"><h3><?php echo $value['name'] ?></h3></a>
								<?php
								if ($value['sku_data_arr']) {
									foreach ($value['sku_data_arr'] as $v){
								?>
										<p class="c-gray ellipsis"><?php echo $v['name'] ?>：<?php echo $v['value'] ?></p>
								<?php 
									}
								}
								?>
							</div>
							<div class="right-col">
								<div class="price">￥<span><?php echo number_format($value['pro_price'], 2) ?></span></div>
								<div class="num">
									<?php
									$discount = 10; 
									if ($value['wholesale_supplier_id']) {
										$discount = $order_data['discount_list'][$value['wholesale_supplier_id']];
									} else {
										$discount = $order_data['discount_list'][$value['store_id']];
									}
									
									if ($value['discount'] > 0 && $value['discount'] <= 10) {
										$discount = $value['discount'];
									}
									
									if ($discount != 10 && $discount > 0) {
										$discount_money += $value['pro_num'] * $value['pro_price'] * (10 - $discount) / 10;
										if (empty($value['wholesale_supplier_id'])) {
											$supplier_money += $value['pro_num'] * $value['pro_price'] * $discount / 10;
										}
									?>
										<span style="padding:0px 5px; background:#f60; color:white; border-radius:3px;"><?php echo $discount ?>折</span>
									<?php
									} else if (empty($value['wholesale_supplier_id'])) {
										$supplier_money += $value['pro_num'] * $value['pro_price'];
									}
									?>
									×<span class="num-txt js-product-number"><?php echo $value['pro_num'] ?></span>
								</div>
								<?php 
								if ($value['comment_arr']) {
								?>
									<a class="link pull-right message js-show-message" data-comment='<?php echo json_encode($value['comment_arr']) ?>' href="javascript:;">查看留言</a>
								<?php 
								}
								?>
							</div>
						</div>
						<?php 
						}
						?>
					</div>
					<hr class="margin-0 left-10 js-sub_total" data-supplier_money="<?php echo $supplier_money ?>">
					<?php 
					if ($order['status'] == 0) {
					?>
						<div class="order-message clearfix" id="js-order-message">
							<textarea class="js-msg-container font-size-12" placeholder="给卖家留言..."></textarea>
						</div>
					<?php 
					} else {
					?>
						<div class="order-message">
							<span class="font-size-12">买家留言：</span><p class="message-content font-size-12"><?php echo $order['comment'] ? $order['comment'] : '无'?></p>
						</div>
						<hr class="margin-0 left-10"/>
					<?php 
					}
					?>
				</div>
				<!-- 物流 -->
				<?php 
				if ($type != 2) {
				?>
					<section class="order ">
						<div class="order_list">
							<ul class="order_list_li">
								<?php 
								if ($type == 3) {
								?>
									<li>
										<div class="shopping clearfix">
											<div class="shopping_text">礼包赠送人数</div>
											<ul class="clearfix ">
												<?php 
												if ($order['status'] == 0) {
												?>
													<li class="reduce js-reduce" data-type="send_other_number">-</li>
												<?php 
												}
												?>
												<li class="number">
													<input value="<?php echo max(1, $order['send_other_number'] ? $order['send_other_number'] : $product_number) ?>" class="js-send_other_number" readonly="readonly" />
												</li>
												<?php 
												if ($order['status'] == 0) {
												?>
													<li class="plus js-plus" data-type="send_other_number">+</li>
												<?php 
												}
												?>
											</ul>
										</div>
									</li>
									<li>
										<div class="shopping clearfix">
											<div class="shopping_text">每人领取数量</div>
											<ul class="clearfix">
												<?php 
												if ($order['status'] == 0) {
												?>
													<li class="reduce js-reduce" data-type="send_other_per_number">-</li>
												<?php 
												}
												?>
												
												<li class="number">
													<input value="<?php echo max(1, $order['send_other_per_number'] ? $order['send_other_per_number'] : 1) ?>" class="js-send_other_per_number" readonly="readonly" />
												</li>
												<?php 
												if ($order['status'] == 0) {
												?>
													<li class="plus js-plus" data-type="send_other_per_number">+</li>
												<?php 
												}
												?>
											</ul>
										</div>
									</li>
								<?php 
								}
								?>
								<li>
									<div class="shopping clearfix">
										<div class="shopping_text">领取有效时间(小时)</div>
										<ul class="clearfix">
											<?php 
											if ($order['status'] == 0) {
											?>
												<li class="reduce js-hour-reduce" >-</li>
											<?php 
											}
											?>
											<li class="number">
												<input value="<?php echo max(1, $order['send_other_hour']) ?>" class="js-send_other_hour" readonly="readonly" />
											</li>
											<?php 
											if ($order['status'] == 0) {
											?>
												<li class="plus js-hour-plus">+</li>
											<?php 
											}
											?>
										</ul>
									</div>
								</li>
							</ul>
						</div>
					</section>
					<section class="ordedr_confirm">
						<div class="ordedr_confirm_title">赠言</div>
						<textarea placeholder="一点心意希望你喜欢" class="js-send_other_comment"><?php echo htmlspecialchars($order['send_other_comment']) ?></textarea>
						<p>*有效期内没有领完,我们会发送到默认地址</p>
						<p>*送他人不支持退货</p>
					</section>
				<?php 
				}
				?>
				<div class="block express" id="js-logistics-container">
					<div class="block-item logistics">
						<h4 class="block-item-title">默认地址</h4>
						<?php 
						if ($type == 2 && $order['status'] == 0) {
							echo '<span style="color: red;">注意修改送公益收货地址</span>';
						}
						?>
					</div>
					<?php 
					if ($order['status'] < 1) {
					?>
						<div class="js-logistics-content logistics-content js-express">
							<?php 
							if ($user_address && $store['open_logistics']) {
							?>
								<div>
									<div class="block block-form block-border-top-none block-border-bottom-none">
										<div class="js-order-address express-panel" style="padding-left:0;">
											<?php 
											if ($order['status'] == 0) {
											?>
												<div class="opt-wrapper">
													<?php 
													if ($type == 2) {
													?>
														<a href="javascript:;" class="btn btn-xxsmall btn-grayeee butn-edit-address js-change-address">切换</a>
													<?php 
													} else {
													?>
														<a href="javascript:;" class="btn btn-xxsmall btn-grayeee butn-edit-address js-edit-address">修改</a>
													<?php 
													}
													?>
												</div>
											<?php 
											}
											?>
											<ul>
												<li><span><?php echo $user_address['name']; ?></span>, <?php echo $user_address['tel']; ?></li>
												<li><?php echo $user_address['province_txt']; ?> <?php echo $user_address['city_txt']; ?> <?php echo $user_address['area_txt']; ?></li>
												<li><?php echo $user_address['address']; ?></li>
											</ul>
										</div>
									</div>
									<div class="js-logistics-tips logistics-tips font-size-12 c-orange hide">很抱歉，该地区暂不支持配送。</div>
								</div>
							<?php 
							} else {
							?>
								<div>
									<div class="js-order-address express-panel">
										<?php 
										if ($store['open_logistics']) {
										?>
											<div class="js-edit-address address-tip"><span>添加收货地址</span></div>
										<?php 
										}
										?>
										
									</div>
								</div>
							<?php 
							}
							?>
						</div>
						<div class="js-logistics-content logistics-content js-self-fetch hide"></div>
						<input type="hidden" name="address_id" id="address_id" value="<?php echo intval($user_address['address_id']); ?>"/>
						<input type="hidden" name="selffetch_id" id="selffetch_id" value="0"/>
					<?php 
					} else {
					?>
							<div>
								<div class="block block-form block-border-top-none block-border-bottom-none">
									<div class="js-order-address express-panel" style="padding-left:0;">
										<ul>
											<li><span><?php echo $order['address_user']; ?></span>, <?php echo $order['address_tel']; ?></li>
											<li><?php echo $order['address']['province'];?> <?php echo $order['address']['city'];?> <?php echo $order['address']['area'];?></li>
											<li><?php echo $order['address']['address'];?></li>
										</ul>
									</div>
								</div>
								<div class="js-logistics-tips logistics-tips font-size-12 c-orange hide">很抱歉，该地区暂不支持配送。</div>
							</div>
					<?php
					}
					?>
				</div>
				<!-- 满减送 -->
				<?php 
				$supplier_reward_money = 0;
				$supplier_coupon_money = 0;
				if ($order_data['reward_list']) {
				?>
					<div class="block" style="display: none;">
						<div class="js-order-total block-item order-total reward_list" style="text-align:left;">
							<?php
							$reward_money = 0;
							foreach ($order_data['reward_list'] as $store_id => $reward_list) {
								foreach ($reward_list as $key => $reward) {
									if ($key === 'product_price_list') {
										continue;
									}
									if (isset($reward['content'])) {
										$reward = $reward['content'];
									}
									$reward_money += $reward['cash'];
									if ($store['store_id'] == $store_id || $store['top_supplier_id'] == $store_id) {
										$supplier_reward_money += $reward['cash'];
									}
							?>
									<p><span style="padding:0px 5px; background:#f60; color:white; border-radius:3px;">满减</span><?php echo getRewardStr($reward) ?></p>
							<?php
								}
							}
							?>
						</div>
						<script>
							$(function() {
								var reward_list = $('.reward_list');
								if($.trim(reward_list.html()) != ''){
									reward_list.parent('.block').css('display', 'block');
								}
							});
						</script>
					</div>
				<?php
				}
				if ($order_data['user_coupon_list']) {
				?>
					<div>
						<div class="block js-card-container">
							<h4 class="list-title">使用优惠券：</h4>
							<div class="js-user_coupon block-item order-total" style="text-align:left;">
								<?php
								$user_coupon_money = 0;
								$i = 0;
								foreach ($order_data['user_coupon_list'] as $store_id => $user_coupon_list) {
									if ($i > 0) {
										echo '<hr />';
									}
									$i++;
								?>
									<p><input type="radio" class="js-user_coupon_input" name="user_coupon_id_<?php echo $store_id ?>" value="0" id="user_coupon_default_<?php echo $store_id ?>" /> <label for="user_coupon_default_<?php echo $store_id ?>" style="cursor:pointer;">不使用优惠券 <span style="display:none;">0</span></label></p>
								<?php
									foreach ($user_coupon_list as $key => $user_coupon_tmp) {
										$checked = '';
										if ($key == '0') {
											$checked = 'checked="checked"';
											$user_coupon_money += $user_coupon_tmp['face_money'];
										}
										
										if ($store['store_id'] == $store_id || $store['top_supplier_id'] == $store_id) {
											$supplier_coupon_money += $user_coupon_tmp['face_money'];
										}
								?>
										<p><input type="radio" class="js-user_coupon_input" name="user_coupon_id_<?php echo $store_id ?>" value="<?php echo $user_coupon_tmp['id'] ?>" <?php echo $checked ?> id="user_coupon_<?php echo $user_coupon_tmp['id'] ?>" /> <label for="user_coupon_<?php echo $user_coupon_tmp['id'] ?>" style="cursor:pointer;"><?php echo htmlspecialchars($user_coupon_tmp['cname']) ?> 优惠券金额：￥<span><?php echo $user_coupon_tmp['face_money'] ?></span></label></p>
								<?php
									}
								}
								?>
							</div>
						</div>
					</div>
				<?php
				}
				if ($order['status'] > 0 && $user_coupon_list) {
				?>
					<div>
						<div class="block js-card-container">
							<h4 class="list-title">使用优惠券：</h4>
							<div class="js-user_coupon block-item order-total" style="text-align:left;">
								<?php 
								foreach ($user_coupon_list as $user_coupon) {
									$user_coupon_money += $user_coupon['money'];
								?>
									<p> 优惠券金额：￥<span><?php echo $user_coupon['money'] ?></span></label></p>
								<?php 
								}
								?>
							</div>
						</div>
					</div>
				<?php
				}
				?>
				<div class="js-point" style="display: none;" data-point="0" data-point_money="0" data-supplier_reward_money="<?php echo $supplier_reward_money ?>" data-supplier_coupon_money="<?php echo $supplier_coupon_money ?>">
					<div class="block js-card-container">
						<h4 class="list-title">积分兑换：</h4>
						<div class="js-user_coupon block-item order-total" style="text-align:left;">
							<p><input type="radio" class="js-point_input" name="point" value="0" id="point_0" /><label for="point_0" style="cursor:pointer;">不使用积分</label></p>
							<p><input type="radio" class="js-point_input" name="point" value="0" id="point_1" checked="checked" /><label for="point_1" style="cursor:pointer;" class="js-point_content">加载中</label></p>
						</div>
					</div>
				</div>
				<?php 
				if ($order_point) {
				?>
					<div class="js-point" >
						<div class="block js-card-container">
							<div class="js-user_coupon block-item order-total" style="text-align:left;">
								<p>使用<?php echo $order_point['point'] ?>个积分，抵扣<?php echo $order_point['money'] ?>元</p>
							</div>
						</div>
					</div>
				<?php 
				}
				?>
				<!-- 支付 -->
				<div class="js-step-topay ">
					<div class="block">
						<div class="js-order-total block-item order-total">
							<p>
								￥<span id="js-sub_total"><?php echo $order['sub_total'];?></span> + ￥<span id="js-postage"><?php echo number_format($order['postage'], 2, '.', '');?></span>运费
								<span style="<?php echo $reward_money ? '' : 'display: none;' ?>">
									- ￥<span id="js-reward"><?php echo number_format($reward_money, 2, '.', '') ?></span>满减优惠
								</span>
								<span style="<?php echo $user_coupon_money ? '' : 'display: none;' ?>">
									- ￥<span id="js-user_coupon"><?php echo number_format($user_coupon_money, 2, '.', '') ?></span>优惠券
								</span>
								<span style="<?php echo $discount_money ? '' : 'display: none;' ?>">
									- ￥<span id="js-discount_money"><?php echo number_format($discount_money, 2, '.', '') ?></span>元折扣
								</span>
								<span class="js-point_money">
									 - ￥<span><?php echo number_format($order_point['money'], 2, '.', '') ?></span>元积分抵扣
								</span>
							</p>
							<?php
							if (!empty($order['float_amount']) && $order['float_amount'] < 0) {
							?>
								<strong class="js-real-pay c-red js-real-pay-temp" style="display: none;">减免：￥<span id="js-float_amount"><?php echo number_format(abs($order['float_amount']), 2, '.', '') ?></span><br/></strong>
							<?php 
							}
							?>
							<strong class="js-real-pay c-orange js-real-pay-temp">需付：￥<span id="js-total"><?php echo number_format(($order['sub_total'] + $order['postage'] - $reward_money - $user_coupon_money - $discount_money), 2, '.', ''); ?></span></strong>
						</div>
					</div>
					<div class="action-container sss" id="confirm-pay-way-opts">
						<input type="hidden" name="postage_list" value="" />
						<input type="hidden" name="type" value="<?php echo $type ?>" class="js-type" />
						<?php 
						if (!empty($sync_user)) {
						?>
							<div style="margin-bottom:10px;">
								<button type="button" data-pay-type="<?php echo $value['type'];?>" class="btn-pay btn btn-block btn-large btn-peerpay btn-green go-pay">去付款</button>
							</div>
						<?php
						} else {
							if ($pay_list) {
								$i=1;
								foreach ($pay_list as $value) {
									if ($value['type'] == 'offline' && $order['shipping_method'] == 'friend') {
										continue;
									}
						?>
									<div style="margin-bottom:10px;">
										<button type="button" data-pay-type="<?php echo $value['type'];?>" class="btn-pay btn btn-block btn-large btn-peerpay <?php echo $i == 1 ? 'btn-green' : 'btn-white' ?>"><?php echo $value['name']?></button>
									</div>
						<?php
									$i++;
								}
							}else{
								$i=1;
								foreach($pay_method_list as $value){
									if ($value['type'] == 'offline') {
										continue;
									}
						?>
									<div style="margin-bottom:10px;">
										<button type="button" data-pay-type="<?php echo $value['type'];?>" class="btn-pay btn btn-block btn-large btn-peerpay <?php echo $i == 1 ? 'btn-green' : 'btn-white' ?>"><?php echo $value['name']?></button>
									</div>
						<?php
									$i++;
								}
							}
						}
						?>
					</div>
					<div class="app-inner inner-order qrcodepay ddd" id="confirm-qrcode-pay">
						<div class="item1">
							<ul class="round" id="cross_pay">
								<li class="title mb" style="text-align:center"> <span class="none">微信扫码支付</span> </li>
								<li class="info">遇到跨号支付？请使用扫码支付完成付款</li>
								<li class="qrcode">
									<table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
										<tbody>
											<tr>
												<td style="text-align:center"><img src="" id="pay-qrcode"></td>
											</tr>
											<tr>
												<td style="padding-top:10px;text-align:center">长按图片[识别二维码]付款</td>
											</tr>
										</tbody>
									</table>
								</li>
							</ul>
						</div>
						<div class="item2"><a class="other-pay" href="./order_friend_pay.php?order_id=<?php echo $order['order_no_txt'] ?>">其他支付方式</a></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>