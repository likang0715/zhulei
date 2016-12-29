<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>维权详情-<?php echo $config[ 'site_name'];?></title>
<meta name="keywords" content="<?php echo $config['seo_keywords'] ?>" />
<meta name="description" content="<?php echo $config['seo_description'] ?>" />
<link type="text/css" rel="stylesheet" href="<?php echo TPL_URL;?>css/style.css" />
<link type="text/css" rel="stylesheet" href="<?php echo TPL_URL;?>css/index.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $config['site_url'] ?>/static/css/jquery.ui.css" />
<link href="<?php echo TPL_URL;?>css/fancybox.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
<script src="<?php echo TPL_URL;?>/js/jquery.fancybox-1.3.1.pack.js"></script>
<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery.zclip.min.js"></script>
<link href=" " type="text/css" rel="stylesheet" id="sc">
<script src="<?php echo TPL_URL;?>js/index2.js"></script>
<script src="<?php echo TPL_URL;?>js/common.js"></script>
<style>
.box{position:relative; float:left;}
.zclip {left:258px; top:36px;}
</style>
<!--[if lt IE 9]>
<script src="js/html5shiv.min-min.v01cbd8f0.js"></script>
<![endif]-->
<!--[if IE 6]>
<script  src="js/DD_belatedPNG_0.0.8a.js" mce_src="js/DD_belatedPNG_0.0.8a.js"></script>
<script type="text/javascript">DD_belatedPNG.fix('*');</script>
<style type="text/css"> 
body{ behavior:url("csshover.htc");}
</style>
<![endif]-->
<script>
var content = '';
$(function () {
	$("a[rel=show_img]").fancybox({
		'titlePosition' : 'over',
		'cyclic'		: false,
		'titleFormat'	: function(title, currentArray, currentIndex, currentOpts) {
			return '';
		}
	});
});
</script>
</head>
<body>
<?php include display( 'public:header_order');?>
<div class="order_content ">
	<div class="Breadcrumbs"> 您的位置：<a href="/">首页</a> &gt; <a href="<?php echo url('account:index') ?>">会员中心</a> &gt; <a href="<?php echo url('account:rights_order') ?>" class="current">维权</a> </div>
	<div class="order_zhuangtai clearfix">
		<div class="order_zhuangtai_txt">
			维权状态:<span><?php echo $rights['status_txt'] ?></span>
		</div>
	</div>
	<diiv class="order_contetn_add">
		<div class="order_order">
			<div class="order_add_titele clearfix"><i>维权信息</i> </div>
			<div  class="order_info_list">
				<div class="order_info_title">
					申请信息
				</div>
				<ul>
					<li>申请时间：<?php echo date('Y-m-d H:i', $rights['dateline']) ?></li>
					<li>维权类型：<?php echo $rights['type_txt'] ?></li>
					<li>手机号码：<?php echo $rights['phone'] ?></li>
					<li>维权说明：<?php echo htmlspecialchars($rights['content']) ?></li>
					<?php 
					if ($rights['images']) {
					?>
						<li>
							维权图片：
							<?php 
							foreach ($rights['images'] as $image) {
							?>
								<a href="<?php echo $image ?>" rel="show_img"><img src="<?php echo $image ?>" style="max-width:60px; max-height:60px;" /></a>
							<?php
							}
							?>
						</li>
					<?php
					}
					?>
				</ul>
				
				<?php 
				if ($rights['status'] == 3) {
				?>
					<div class="order_info_title">
						维权结果
					</div>
					<ul>
						<li>完成时间：<?php echo date('Y-m-d H:i', $rights['complete_dateline']) ?></li>
						<li>处理结果：<?php echo htmlspecialchars($rights['platform_content']) ?></li>
					</ul>
				<?php
				}
				?>
			</div>
			<div  class="order_info_list">
				<div class="order_info_title">维权产品</div>
			</div>
			<ul class="order_add_table">
				<li class="order_product_title clearfix">
					<div class="product_1">商品</div>
					<div class="product_2">购买单价(元)</div>
					<div class="product_3">维权数量</div>
					<div class="product_4">小计(元)</div>
				</li>
				<li>
					<dl>
						<dd class="clearfix">
							<div class="product_1 clearfix">
								<div class="order_product_img" style="height:78px;">
									<a href="<?php echo url_rewrite('goods:index', array('id' => $rights['product_id'])) ?>"><img src="<?php echo $rights['image'] ?>"></a>
								</div>
								<div class="order_product_txt">
									<div class="order_product_txt_name"><a href="<?php echo url_rewrite('goods:index', array('id' => $rights['product_id'])) ?>"><?php echo htmlspecialchars($rights['name']) ?></a></div>
									<?php 
									if ($rights['sku_data_arr']) {
										$sku_data_arr = unserialize($rights['sku_data']);
									?>
										<div class="order_product_txt_dec clearfix">
									<?php
											foreach ($sku_data_arr as $sku_data) {
									?>
												<div class="order_product_txt_dec_l"><?php echo $sku_data['name'] ?>:<span><?php echo $sku_data['value'] ?>&nbsp;</span></div>
									<?php 
										}
									?>
										</div>
									<?php
									}
									?>
								</div>
							</div>
							<div class="product_2"><?php echo $rights['pro_price'] ?></div>
							<div class="product_3"><?php echo $rights['pro_num'] ?></div>
							<div class="product_4">
								<?php echo sprintf('%.2f', $rights['pro_price'] * $rights['pro_num']) ?>
							</div>
						</dd>
					</dl>
				</li>
			</ul>
		</div>
	</div>
	
	<div class="order_contetn_add">
		<div class="order_order">
			<div class="order_add_titele clearfix"><i>订单信息</i> </div>
			<div  class="order_info_list">
				<div class="order_info_title">
					收货信息
					<?php 
					if ($order['shipping_method'] == 'selffetch') {
						if ($store['buyer_selffetch_name']) {
							echo ' <span>' . $store['buyer_selffetch_name'] . '</span>';
						} else {
							echo ' <span>到店自提</span>';
						}
					} else if ($order['shipping_method'] == 'friend') {
						echo '<span>送朋友订单</span>';
					}
					?>
				</div>
				<ul>
					<?php 
					if ($order['shipping_method'] == 'selffetch') {
						$address = unserialize($order['address']);
					?>
						<li>门店信息：<span><?php echo htmlspecialchars($address['name']) ?> <?php echo $address['tel'] ?></span> <?php echo $address['business_hours'] ? '营业时间：' . $address['business_hours'] : '' ?></li>
						<li>
							门店地址：<span><?php echo $address['province'] . $address['city'] . $address['area'] . $address['address'] ?></span>
						</li>
						<li class="ziti">联系信息：<span><?php echo htmlspecialchars($order['address_user']) ?> <?php echo $order['address_tel'] ?></span></li>
						<li class="ziti">预约时间：<span><?php echo $address['date'] . ' ' . $address['time'] ?></span></li>
					<?php
					} else {
					?>
						<li>联系信息：<?php echo htmlspecialchars($order['address_user']) ?><span><?php echo $order['address_tel'] ?></span></li>
						<li>
							收货地址：
							<?php 
							$address = unserialize($order['address']);
							echo $address['province'] . $address['city'] . $address['area'] . $address['address'];
							?>
						</li>
					<?php
					}
					if ($order['comment']) {
					?>
						<li>备注:<span><?php echo htmlspecialchars($order['comment']) ?></span></li>
					<?php 
					}
					?>
				</ul>
			</div>
			<div  class="order_info_list">
				<div class="order_info_title">店铺信息</div>
				<ul>
					<li>店铺名称：<?php echo $store['name'] ?></li>
				</ul>
			</div>
			<div  class="order_info_list">
				<div class="order_info_title">宝贝信息</div>
				<ul>
					<li>
						<div class="order_nub"><span>订单号:</span><span><?php echo option('config.orderid_prefix') . $order['order_no'] ?></span><span>下单时间：<?php echo date('Y-m-d H:i:s', $order['add_time']) ?></span></div>
					</li>
				</ul>
			</div>
			<ul class="order_add_table">
				<li class="order_product_title clearfix">
					<div class="product_1">商品</div>
					<div class="product_2">单价(元)</div>
					<div class="product_3">数量</div>
					<div class="product_4">小计(元)</div>
				</li>
				<li>
					<dl>
						<!-- <dt>
							<div class="order_dec">店铺:<a href="###"><span>钱来小铺</span></a></div>
						</dt> -->
						<?php 
						$product_name_list = array();
						foreach ($order['proList'] as $product) {
							$product_name_list[$product['product_id']] = $product['name'];
							$total_price += $product['pro_num'] * $product['pro_price'];
						?>
							<dd class="clearfix">
								<div class="product_1 clearfix">
									<div class="order_product_img" style="height:78px;">
										<a href="<?php echo url_rewrite('goods:index', array('id' => $product['product_id'])) ?>"><img src="<?php echo getAttachmentUrl($product['image']) ?>"></a>
									</div>
									<div class="order_product_txt">
										<div class="order_product_txt_name"><a href="<?php echo url_rewrite('goods:index', array('id' => $product['product_id'])) ?>"><?php echo htmlspecialchars($product['name']) ?></a></div>
										<?php 
										if (is_array($product['sku_data_arr'])) {
										?>
											<div class="order_product_txt_dec clearfix">
										<?php
												foreach ($product['sku_data_arr'] as $sku_data) {
										?>
													<div class="order_product_txt_dec_l"><?php echo $sku_data['name'] ?>:<span><?php echo $sku_data['value'] ?>&nbsp;</span></div>
										<?php 
											}
										?>
											</div>
										<?php
										}
										?>
									</div>
								</div>
								<div class="product_2">
									<?php echo $product['pro_price'] ?>
									<?php
									$discount = 10;
									if ($product['wholesale_product_id']) {
										$discount = $order_data['order_discount_list'][$product['wholesale_supplier_id']];
									} else {
										$discount = $order_data['order_discount_list'][$product['store_id']];
									}
									
									if ($discount != 10 && $discount > 0) {
										$discount_money += $product['pro_num'] * $product['pro_price'] * (10 - $discount) / 10;
									?>
										<span style="padding:0px 5px; background:#f60; color:white; border-radius:3px;"><?php echo $discount ?>折</span>
									<?php
									}
									?>
								</div>
								<div class="product_3"><?php echo $product['pro_num'] ?></div>
								<div class="product_4">
									<?php echo number_format($product['pro_price'] * $product['pro_num'], 2) ?>
									<?php 
									if ($product['is_present'] == '1') {
										echo '(赠品)';
									}
									?>
								</div>
							</dd>
						<?php 
						}
						?>
						<dt>备注: <span><?php echo htmlspecialchars($order['comment']) ?></span> </dt>
					</dl>
				</li>
			</ul>
		</div>
		<div class="order_tijiao order_mannde">
			<div  class="order_info_list">
				<ul>
					<?php
					$money = 0;
					if ($order_data['order_ward_list']) {
						foreach ($order_data['order_ward_list'] as $order_ward_list) {
							foreach ($order_ward_list as $order_ward) {
								$money += $order_ward['content']['cash'];
					?>
								<li>满减：<?php echo getRewardStr($order_ward['content']) ?></li>
					<?php 
							}
						}
					}
					if ($order_data['order_coupon_list']) {
						foreach ($order_data['order_coupon_list'] as $order_coupon) {
							$money += $order_coupon['money'];
					?>
							<li><span>优惠券：<i><?php echo $order_coupon['name'] ?></i></span><span>优惠金额:<i><?php echo number_format($order_coupon['money'], 2) ?>元</i></span></li>
					<?php 
						}
					}
					if ($order_data['discount_money']) {
						$money += $order_data['discount_money'];
					?>
						<li><span>折扣金额：<i><?php echo number_format($order_data['discount_money'], 2) ?>元</i></span></li>
					<?php
					}
					?>
					<li>
						<div class="tijiao_txt">
							<div class="tijiao_txt_l">实付款:</div>
							<div class="tijiao_txt_c">￥<span><?php echo number_format($order['total'], 2) ?></span></div>
							<div class="tijiao_txt_r">
								其中运费：<?php echo number_format($order['postage'], 2) ?>
								<?php 
								if ($money) {
									echo ',优惠金额:' . number_format($money, 2) . '元';
								}
								if ($order['float_amount'] < 0) {
									echo ',减免:' . number_format(abs($order['float_amount']), 2) . '元';
								}
								?>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<?php 
	if ($order['payment_method'] == 'peerpay') {
	?>
		<style>
		.order_gengzong_list_l td {border-bottom:1px dashed #d9d9d9; }
		</style>
		<div class="order_order order_gengzong">
			<div class="order_add_titele ">代付列表</div>
			<div  class="order_gengzong_list">
				<div class="order_gengzong_list_l clearfix">
					<table style="width:100%; font-size:12px;">
						<tr style="height:40px; color:#23cc9e">
							<td>代付人姓名</td>
							<td>代付人留言</td>
							<td>代付金额</td>
							<td>代付时间</td>
							<td>退款金额</td>
							<td>退款时间</td>
						</tr>
						<tbody class="peerpay_list">
							<?php 
							if ($order_peerpay_list) {
								$peerpay_money = 0;
								foreach ($order_peerpay_list as $order_peerpay) {
									$peerpay_money += $order_peerpay['money'];
									if ($order_peerpay['untread_status']) {
										$peerpay_money -= $order_peerpay['untread_money'];
									}
							?>
									<tr style="line-height: 24px;">
										<td><?php echo htmlspecialchars($order_peerpay['name']) ?></td>
										<td><?php echo htmlspecialchars($order_peerpay['content']) ?></td>
										<td><?php echo $order_peerpay['money'] ?></td>
										<td><?php echo date('Y-m-d H:i', $order_peerpay['pay_dateline']) ?></td>
										<td><?php echo $order_peerpay['untread_status'] ? $order_peerpay['untread_money'] : '0.00' ?></td>
										<td><?php echo $order_peerpay['untread_status'] ? date('Y-m-d H:i', $order_peerpay['untread_dateline']) : '-' ?></td>
									</tr>
							<?php 
								}
							} else {
							?>
								<tr style="height:40px;">
									<td colspan="6" style="text-align:center;">暂无代付</td>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>
					<?php 
					if ($order_peerpay_list) {
					?>
						<div style="width:98%; text-align:right;">
							代付总额：￥<?php echo $peerpay_money ?>
						</div>
					<?php 
					}
					?>
				</div>
			</div>
		</div>
	<?php
	}
	?>
</div>
<?php include display( 'public:footer');?>
</body>
</html>