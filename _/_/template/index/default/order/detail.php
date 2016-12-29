<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<title>订单详情-<?php echo $config[ 'site_name'];?></title>
<meta name="keywords" content="<?php echo $config['seo_keywords'] ?>" />
<meta name="description" content="<?php echo $config['seo_description'] ?>" />
<link type="text/css" rel="stylesheet" href="<?php echo TPL_URL;?>css/style.css" />
<link type="text/css" rel="stylesheet" href="<?php echo TPL_URL;?>css/index.css" />
<link type="text/css" rel="stylesheet" href="<?php echo TPL_URL;?>css/cart.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $config['site_url'] ?>/static/css/jquery.ui.css" />
<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery.zclip.min.js"></script>
<link href=" " type="text/css" rel="stylesheet" id="sc" />
<script src="<?php echo TPL_URL;?>js/index2.js"></script>
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
	$("#js_copy").zclip({
		path: '/static/js/plugin/ZeroClipboard.swf',
		copy: function () {
			return content;
		},
		afterCopy: function () {
			alert('复制成功');
		}
	});
	$("#js-pay-btn").click(function () {
		var order_id = $(this).data("order_id");
		var url = "<?php echo url('order:pay') ?>&order_id=" + order_id;
		location.href = url;
	});

	expressDetail();
});

function expressDetail() {
	if ($("#select_package").size() == 0) {
		return;
	}
	var type = $("#select_package").find("option:selected").attr("data-type");
	var order_no = $("#select_package").find("option:selected").attr("data-order_no");
	var express_no = $("#select_package").find("option:selected").attr("data-express_no");
	var product = $("#select_package").find("option:selected").attr("data-product");

	if (type.length == 0 || order_no.length == 0 || express_no.length == 0) {
		return;
	}

	content = $("#select_package").find("option:selected").attr("data-express_no");
	$("#package_product_list").html(product);
	var html = "<tr><td width='20%'>努力查询中</td><td width='80%'></td></tr>";
	$("#express_list").html(html);

	var url = "index.php?c=order&a=express&type=" + type + "&order_no=" + order_no + "&express_no=" + express_no + "&" + Math.random();
	$.getJSON(url, function(data) {
		try {
			if (data.status == true) {
				html = '';
				for(var i in data.data.data) {
					html += '<li>';
					html += '	<div class="order_genzong_left">' + data.data.data[i].time + '</div>';
					html += '	<div class="order_genzong_right">' + data.data.data[i].context + '</div>'
					html += '</li>';
				}
				$("#express_list").html(html);
				
			} else {
				html += "<li>查寻失败</li>";
				$("#express_list").html(html);
			}
		}catch(e) {
			html += "<li>查寻失败</li>";
			$("#express_list").html(html);
		}
	});
}
</script>
</head>
<body>
<?php include display( 'public:header_order');?>
<div class="order_content ">
	<div class="Breadcrumbs"> 您的位置：<a href="/">首页</a> &gt; <a href="<?php echo url('account:index') ?>">会员中心</a> &gt; <a href="<?php echo url('account:order') ?>" class="current">我的订单</a> </div>
	<div class="order_zhuangtai clearfix">
		<div class="order_zhuangtai_txt">
			订单状态:
			<span>
				<?php
				if ($order['status'] < 2) {
					echo '未支付';
				} else if ($order['status'] == 2) {
					echo '未发货';
				} else if ($order['status'] == 3) {
					echo '已发货';
				} else if ($order['status'] == 4) {
					echo '已完成';
				} else if ($order['status'] == 5) {
					echo '已取消';
				} else if ($order['status'] == 6) {
					echo '退款中';
				} else if ($order['status'] == 7) {
					echo '已收货';
				}
				?>
			</span>
			<?php 
			if ($order['payment_method'] == 'codpay') {
				echo '&#12288;支付方式：<span>货到付款</span>';
			} else if ($order['payment_method'] == 'peerpay') {
				echo '&#12288;支付方式：<span>找人代付</span>';
			}
			?>
		</div>
		<?php 
		if ($order['status'] < 2 && $order['payment_method'] != 'codpay') {
		?>
			<div  class="order_zhuangtai_button">
				<button data-order_id="<?php echo option('config.orderid_prefix') . $order['order_no'] ?>" id="js-pay-btn">去支付</button>
			</div>
		<?php 
		}
		?>
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
						<div class="order_nub"><span>订单号:</span><span><?php echo option('config.orderid_prefix') . $order['order_no'] ?></span><span><?php echo date('Y-m-d H:i:s', $order['add_time']) ?></span></div>
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
									<div class="order_product_img">
										<a href="<?php echo url_rewrite('goods:index', array('id' => $product['product_id'])) ?>"><img src="<?php echo getAttachmentUrl($product['image']) ?>" /></a>
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
									<?php echo number_format($product['pro_price'], 2) ?>
									<?php
									$discount = 10;
									if ($product['wholesale_product_id']) {
										$discount = $order_data['order_discount_list'][$product['wholesale_supplier_id']];
									} else {
										$discount = $order_data['order_discount_list'][$product['store_id']];
									}
									
									if ($product['discount'] > 0 && $product['discount'] < 10) {
										$discount = $product['discount'];
									}
									
									if ($discount != 10 && $discount > 0) {
										$discount_money += $product['pro_num'] * $product['pro_price'] * (10 - $discount) / 10;
									?>
										<span style="padding:0px 5px; background:#f60; color:white; border-radius:3px;"><?php echo $discount + 0 ?>折</span>
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
					if ($order_data['order_point']) {
						$money += $order_data['order_point']['money'];
					?>
						<li><span>积分抵扣：<i><?php echo number_format($order_data['order_point']['money'], 2) ?>元,使用<?php echo $order_data['order_point']['point'] ?>个积分</i></span></li>
					<?php 
					}
					$platform_point_money = 0;
					if ($order['cash_point'] > 0 && $order['point2money_rate'] > 0){
						$platform_point_money = $order['cash_point'] / $order['point2money_rate'];
					?>
						<li><span><?php echo option('credit.platform_credit_name') ?>抵扣：<i><?php echo number_format($platform_point_money, 2) ?>元,使用<?php echo $order['cash_point'] ?>个</i></span></li>
					<?php 
					}
					?>
					<li>
						<div class="tijiao_txt">
							<div class="tijiao_txt_l">实付款:</div>
							<div class="tijiao_txt_c">￥<span><?php echo number_format(max(0, $order['total'] - $platform_point_money), 2) ?></span></div>
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
	if (!empty($order_package)) {
	?>
		<div class="order_order order_gengzong">
			<div class="order_add_titele ">订单跟踪</div>
			<div  class="order_gengzong_list">
				<div class="order_gengzong_select clearfix">
					<div class="order_gengzong_txt">选择包裹:</div>
					<select id="select_package" onchange="expressDetail()">
						<?php 
						foreach ($order_package as $key => $package) {
							$package_product_list = explode(',', $package['products']);
							$product_name_txt = '';
							foreach ($package_product_list as $tmp) {
								$product_name_txt .= $product_name_list[$tmp];
							}
							
							$selected = '';
							if ($key == 0) {
								$selected = 'selected="selected"';
							}
						?>
							<option <?php echo $selected ?> data-product="<?php echo $product_name_txt ?>"  data-express_no="<?php echo $package['express_no'] ?>"  data-order_no="<?php echo option('config.orderid_prefix') . $order['order_no'] ?>" data-type="<?php echo $package['express_code'] ?>"><?php echo $package['express_company'] ?> - <?php echo $package['express_no'] ?></option>
						<?php 
						}
						?>
					</select>
					<button id="js_copy">复制订单</button>
				</div>
				<div class="order_gengzong_info clearfix">
					<div class="order_gengzong_txt">物流商品:</div>
					<div class="order_gengzong_info_txt" id="package_product_list"></div>
				</div>
				<div class="order_gengzong_list_l clearfix">
					<div class="order_genzong_left">处理时间</div>
					<div class="order_genzong_right">处理信息</div>
				</div>
				<ul class="gengzong_wuliu" id="express_list">
				</ul>
			</div>
		</div>
	<?php 
	}
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