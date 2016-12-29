<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>打印商品订单</title>
<style type="text/css" media="print">
.noprint{display:none}
</style>
<style type="text/css">
td{
	font-size:9pt;
	font-family: Arial, Helvetica, sans-serif;
}
.table_style {
	border-collapse: collapse;
}
.hr_style {
	color: #000000;
}
.td01 {
	font-size: 14pt;
}
.font01 {
	font-size: medium;
}
.font02 {
	font-size: 11pt;
}
.font03 {
	font-size: 11pt;
	text-align: center;
}
.font04 {
	line-height: 150%;
}
#divTest{
	position: absolute;
	z-index: 1000;
	background-color: #D5ECF1;
	width: 100%;
	height:30px;
	left: 0%;
	bottom:0px;
	padding-top:10px;
	text-align:center;
}
</style>
</head>

<body style="margin: 0">
<table align="center" cellpadding="0" cellspacing="0" class="table_style" style="width: 90%">
<tr>
	<td height="70">
		<table cellpadding="0" cellspacing="0" class="table_style" style="width: 100%">
			<tr>
				<td class="td01"><strong>商品订单</strong></td>
				<td align="right"><img width="120" height="120" src="<?php echo $store['qcode']?>"/></td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td><hr class="hr_style" noshade="noshade" /></td>
</tr>
<tr>
	<td>
		<table style="width: 100%" cellpadding="0" cellspacing="0" class="table_style">
			<tr>
				<td class="font02"><strong class="font02">订单号：<?php echo $order['order_no']; ?></strong></td>
				<td class="font02" align="right"><strong>客户下单日期：<?php echo date("Y-m-d H:i:s",$order['add_time']); ?></strong></td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td><hr class="hr_style" noshade="noshade" /></td>
</tr>
<tr>
	<td align="center">
		<table style="width: 98%" cellpadding="5" cellspacing="0" class="table_style">
			<tr>
				<td class="font02"><strong>订购商品名称</strong></td>
				<?php if($order['is_point_order']!=1) {?>
				<td class="font02"><strong>单价(元)</strong></td>
				<?php } else {?>
				<td class="font02"><strong>单价(积分)</strong></td>
				<?php }?>
				<td class="font02"><strong>数量</strong></td>
				<td class="font02"><strong>小计</strong></td>
				<!-- <td class="font02"><strong>状态</strong></td> -->
			</tr>
		<?php 
		$start_package = false; //订单已经有商品开始打包
		$total_money = 0;
		$discount_money = 0;
		foreach ($products as $key => $product) {
			if (!$start_package && $product['is_packaged']) {
				$start_package = true; 
			}
			$skus = !empty($product['sku_data']) ? unserialize($product['sku_data']) : ''; 
			$comments = !empty($product['comment']) ? unserialize($product['comment']) : '';
			$total_money += $product['pro_num'] * $product['pro_price'];
		?>
			<tr>
				<td>
					<?php 
					echo $product['name'];
					if ($product['is_present']) {
						echo '<span style="color:#f60;">赠品</span>';
					}
					if ($product['is_fx']) {
					?>
						<span class="platform-tag">分销</span>
					<?php 
					}
					if ($skus) {
					?>
						<p>
							<span class="goods-sku">
								<?php 
								foreach ($skus as $sku) {
								?>
									<?php echo $sku['name']; ?>: <?php echo $sku['value']; ?>&nbsp;
								<?php 
								}
								?>
							</span>
						</p>
					<?php
					}
					?>
				</td>
				<?php if($order['is_point_order']!=1) {?>
				<td><?php echo $product['pro_price']; ?></td>
				<?php } else {?>
				<td><?php echo (int)$product['pro_price']; ?></td>
				<?php }?>
				
				<td><?php echo $product['pro_num']; ?></td>

				<?php if($order['is_point_order']!=1) {?>
					<td><?php echo number_format($product['pro_num'] * $product['pro_price'], 2, '.', ''); ?></td>
				<?php } else {?>
					<td><?php echo (int)($product['pro_num'] * $product['pro_price']); ?></td>
				<?php }?>
				
				
				
				
				<!-- <td>
					<?php
					if ($product['is_packaged'] || $start_package) {
						if ($product['in_package_status'] == 0) {
					?>
						待发货
					<?php
						} else if ($product['in_package_status'] == 1) {
					?>
							已发货
					<?php
						} else if ($product['in_package_status'] == 2) {
					?>
							已到店
					<?php
						} else if ($product['in_package_status'] == 3) {
					?>
						已签收
					<?php
						}
					} else {
						if ($order['shipping_method'] == 'selffetch' && $order['status'] != 4 && $order['status'] != 7) {
							echo '未' . ($store_session['buyer_selffetch_name'] ? $store_session['buyer_selffetch_name'] : '上门自提');
						} else if ($order['shipping_method'] == 'selffetch' && ($order['status'] == 4 || $order['status'] == 7)) {
							echo '已' . ($store_session['buyer_selffetch_name'] ? $store_session['buyer_selffetch_name'] : '上门自提');
						} else {
					?>
							未打包
					<?php
						}
					}
					?>
				</td> -->
			</tr>
		<?php
			if (!empty($comments)) {
				foreach ($comments as $comment) {
		?>
					<tr class="msg-row">
						<td colspan="6"><?php echo $comment['name']; ?>：<?php echo $comment['value']; ?><br></td>
					</tr>
		<?php
				}
			}
		}
		?>
		</table>
	</td>
</tr>
<tr>
	<td><hr class="hr_style" noshade="noshade" /></td>
</tr>
<tr>
	<td>
	<table cellpadding="3" cellspacing="0" class="table_style" style="width: 100%">
		<tr>
			<?php
			if($order['comment'] || 1) {
			?>
				<td valign="top">买家留言：<span ><?php echo $order['comment']; ?></span></td>
			<?php
			}
			?>
			<td style="width:300px;text-align:right" valign="top" class="font04">
				<table cellpadding="3" cellspacing="0" class="table_style" style="width: 100%">
					<tr>
						<td valign="top">&nbsp;</td>
						<?php if($order['is_point_order']==1) {?>
							<td style="width: 300px;text-align:right" valign="top"><span class="font04">商品积分小计：<span class="point_ico"></span><?php echo $total_money ?></span></td>
						<?php } else {?>
							<td style="width: 300px;text-align:right" valign="top"><span class="font04">商品小计：￥<?php echo $total_money ?></span></td>
						<?php }?>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td style="width: 300px;text-align:right" valign="top">运费：￥<span class="order-postage"><?php echo $order['postage']; ?></span></td>
					</tr>
					<?php
					$address = !empty($order['address']) ? unserialize($order['address']) : array();
					if (!empty($order['float_amount']) && $order['float_amount'] != '0.00') {
						$discount_money -= $order['float_amount'];
					?>
						<tr>
							<td>&nbsp;</td>
							<?php if ($order['float_amount'] > 0) { ?>
								<td style="width: 300px;text-align:right" valign="top">卖家改价：+￥<?php echo $order['float_amount']; ?></td>
							<?php } else { ?>
								<td>卖家改价：-￥<?php echo number_format(abs($order['float_amount']), 2, '.', ''); ?></td>
							<?php } ?>
						</tr>
					<?php
					}
					if ($order_data['order_ward_list']) {
						foreach ($order_data['order_ward_list'] as $order_ward_list) {
							foreach ($order_ward_list as $order_ward) {
								$discount_money += $order_ward['content']['cash'];
					?>
								<tr>
									<td>&nbsp;</td>
									<td style="width: 300px;text-align:right" valign="top">满减：<?php echo getRewardStr($order_ward['content']) ?></td>
								</tr>
					<?php 
							}
						}
					}
					if ($order_data['order_coupon_list']) {
						foreach ($order_data['order_coupon_list'] as $order_coupon) {
							$discount_money += $order_coupon['money'];
					?>
							<tr>
								<td>&nbsp;</td>
								<td style="width: 300px;text-align:right" valign="top">
									优惠券:
									<span><i><?php echo $order_coupon['name'] ?></i></span>
									<span>优惠金额:<i><?php echo number_format($order_coupon['money'], 2) ?>元</i></span>
								</td>
							</tr>
					<?php 
						}
					}
					if ($order_data['discount_money']) {
						$discount_money += $order_data['discount_money'];
					?>
						<tr>
							<td>&nbsp;</td>
							<td style="width: 300px;text-align:right" valign="top">
								<span>折扣优惠:<i><?php echo number_format($order_data['discount_money'], 2) ?>元</i></span>
							</td>
						</tr>
					<?php
					}
					?>
				</table>
		</td>
		</tr>
	</table>
	</td>
</tr>
<tr>
	<td><hr class="hr_style" noshade="noshade" /></td>
</tr>
<tr>
	<td>
		<table cellpadding="3" cellspacing="0" class="table_style" style="width: 100%">
			<tr>
				<td></td>
				<td style="width: 300px;text-align:right" valign="top">
					<?php if($order['is_point_order']!=1) {?>
					<span class="font02"><strong>应收款：<span class="ui-money-income">￥</span><span class="order-total"><?php echo number_format($total_money + $order['postage'] - $discount_money, 2) ?></span></strong></span>
					<?php } else {?>
					<span class="font02"><strong>应收款：<span class="ui-money-income">￥</span><span class="order-total"><?php echo number_format($order['postage'] - $discount_money, 2) ?></span></strong></span><br/>
					<span class="font02"><strong>应扣积分：<span class="ui-money-income"></span><span class="order-total"><?php echo $order['order_pay_point']; ?></span></strong></span>
					<?php }?>
				</td>
			</tr>		
		</table>
	</td>
</tr>
<tr>
	<td><hr class="hr_style" noshade="noshade" /></td>
</tr>

<tr>
	<td>
		<table cellpadding="3" cellspacing="0" class="table_style" style="width: 100%">
			<tr>
				<td class="font04">
					客户姓名：<?php echo $order['address_user']; ?><br />
					客户地址：<?php echo $address['province']; ?> <?php echo $address['city']; ?> <?php echo $address['area']; ?> <?php echo $address['address']; ?> 
					<br />
					<?php
					if($order['address_tel']) {
					?>
						联系电话：<?php echo $order['address_tel']; ?>
					<?php
					}
					?>
				</td>
				<td valign="top">&nbsp;</td>
			</tr>
		</table>
	</td>
</tr>
</table>
<div id="divTest" class=noprint>
<OBJECT classid="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2" height="0" id="wb" name="wb" width="0" VIEWASTEXT></OBJECT>
<input type=button name=button_show value="打印预览" class="noprint" onclick="javascript:wb.execwb(7,1);"> 
<input type=button name=button_show value="打印设置" class="noprint" onclick="javascript:wb.execwb(8,1);"> <input type="button" id="datasubmit" value="确认打印" name="submit" onclick="javascrīpt:window.print()"></div>
<script type="text/javascript">
var rootel=document.documentElement; //XHTMl
var bto=document.getElementById('divTest');
function bt(){
	bto.style.top=(rootel.clientHeight-bto.offsetHeight)+rootel.scrollTop+'px';
}
bt();
</script>

</body>
</html>
