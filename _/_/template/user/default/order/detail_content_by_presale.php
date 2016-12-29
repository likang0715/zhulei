<table class="table order-goods">
	<thead>
	<?php if(($presale_order['type'] == 7) && ($presale_order['order_id'] != $presale_order['presale_order_id'])) {?>
	<tr>
		<td colspan="7" style="background:#999;padding-left:10px;color:#fff;font-weight:700">
			预售定金支付订单&#12288;(定金支付订单号：<?php echo $presale_order['order_no'];?>)
		</td>
	</tr>
	<?php }?>
	<tr>
		<th class="tb-thumb"></th>
		<th class="tb-name">商品名称</th>
		<th class="tb-price">单价（元）</th>
		<!--<th class="tb-price">商品优惠</th>-->
		<th class="tb-num">数量</th>
		<th class="tb-total">小计（元）</th>
		<th class="tb-state">状态</th>
		<th class="tb-postage">运费（元）</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$start_package = false; //订单已经有商品开始打包
	// 折扣金额
	$discount_money = 0;
	// 判断是否有自营产品
	$have_self_product = false;
	foreach ($presale_products as $key => $product) {
		if (!$start_package && $product['is_packaged']) {
			$start_package = true;
		}
		$skus = !empty($product['sku_data']) ? unserialize($product['sku_data']) : '';
		$comments = !empty($product['comment']) ? unserialize($product['comment']) : '';
		
		if ($product['wholesale_product_id'] == 0 && $product['store_id'] == $presale_order['store_id']) {
			$have_self_product = true;
		}
	?>
	<tr data-order-id="<?php echo $presale_order['order_id']; ?>">
		<td class="tb-thumb" <?php if (!empty($comments)) { ?>rowspan="2"<?php } ?>>
			<?php if ($product['is_fx']) { ?>
				<?php if (!$product['is_packaged']) { ?><span style="color:red">卖家未发货</span><br/><?php } ?>
			<?php } ?>
			<img src="<?php echo $product['image']; ?>" width="60" height="60" />
		</td>
		<td class="tb-name">
			<a href="<?php echo $config['wap_site_url'];?>/good.php?id=<?php echo $product['product_id'] ?>&store_id=<?php echo $_SESSION['store']['store_id'] ?>" class="new-window" target="_blank"><?php echo $product['name']; ?></a>
			<?php 
			if ($product['is_present']) {
				echo '<span style="color:#f60;">赠品</span>';
			}
			?>
			<?php if ($product['is_fx']) { ?>
				<span class="platform-tag">分销</span>
			<?php } ?>
			<?php if ($skus) { ?>
			<p>
				<span class="goods-sku"><?php foreach ($skus as $sku) { ?><?php echo $sku['name']; ?>: <?php echo $sku['value']; ?>&nbsp;<?php } ?></span>
			</p>
			<?php } ?>
		</td>
		<td class="tb-price">
			<?php echo $product['pro_price']; ?>
			<?php
			$discount = 10;
			if ($product['wholesale_product_id']) {
				$discount = $order_data['order_discount_list'][$product['supplier_id']];
			} else {
				$discount = $order_data['order_discount_list'][$product['store_id']];
			}
			
			if ($product['discount'] > 0 && $product['discount'] <= 10) {
				$discount = $product['discount'];
			}
			
			if ($discount != 10 && $discount > 0) {
				$discount_money += $product['pro_num'] * $product['pro_price'] * (10 - $discount) / 10;
			?>
				<span style="padding:0px 5px; background:#f60; color:white; border-radius:3px;"><?php echo $discount ?>折</span>
			<?php
			}
			?>
		</td>
		<!--<td class="tb-price"></td>-->
		<td class="tb-num"><?php echo $product['pro_num']; ?></td>
		<td class="tb-total"><?php echo number_format($product['pro_num'] * $product['pro_price'], 2, '.', ''); ?></td>
		<td class="tb-state" <?php if (!empty($comments)) { ?>rowspan="2"<?php } ?>>
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
				if ($presale_order['shipping_method'] == 'selffetch' && $presale_order['status'] != 4 && $presale_order['status'] != 7) {
					echo '未' . ($store_session['buyer_selffetch_name'] ? $store_session['buyer_selffetch_name'] : '上门自提');
				} else if ($presale_order['shipping_method'] == 'selffetch' && ($presale_order['status'] == 4 || $presale_order['status'] == 7)) {
					echo '已' . ($store_session['buyer_selffetch_name'] ? $store_session['buyer_selffetch_name'] : '上门自提');
				}else {
			?>
					未打包
			<?php
				}
			}
			?>
		</td>
		<?php  if (count($comment_count) > 0 && $key == 0) { ?>
		<td class="tb-postage" rowspan="<?php echo $rows; ?>">
			<?php echo $presale_order['postage']; ?>
			<?php if (in_array($presale_order['status'], array(0,1)) && $presale_order['type'] != 5) { ?>
                <?php if($store_session['drp_level'] == 0 ){?>
			<p class="text-center">
				<a href="javascript:;" class="js-change-price" data-id="<?php echo $presale_order['order_id']; ?>">修改价格</a>
			</p>
               <?php }?>
			<?php } ?>
		</td>
		<?php } ?>
	</tr>
	<?php if (!empty($comments)) { ?>
	<?php foreach ($comments as $comment) { ?>
	<tr class="msg-row">
		<td colspan="5"><?php echo $comment['name']; ?>：<?php echo $comment['value']; ?><br></td>
	</tr>
	<?php } ?>
	<?php } ?>
	<?php } ?>
	</tbody>
</table>