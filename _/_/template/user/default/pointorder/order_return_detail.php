<style type="text/css">
	.platform-tag {
		display: inline-block;
		vertical-align: middle;
		padding: 3px 7px 3px 7px;
		background-color: #f60;
		color: #fff;
		font-size: 12px;
		line-height: 14px;
		border-radius: 2px;
	}
	.ui-btn-primary-no {
	  color: #666666;
	  background: #E3E3EB;
	  border-color: #E5E5E9;
	}
	.popover.right .arrow {
		top: 50%;
		left: -11px;
		margin-top: -5px;
		border-top: 5px solid transparent;
		border-bottom: 5px solid transparent;
		border-right: 5px solid #000000;
	}
	.popover.right .arrow:after {
		bottom: -10px;
		left: 1px;
		border-right-color: #ffffff;
		border-left-width: 0;
	}
</style>
<link href="<?php echo TPL_URL;?>css/fancybox.css" type="text/css" rel="stylesheet" />
<script src="<?php echo TPL_URL;?>/js/jquery.fancybox-1.3.1.pack.js"></script>
<script>
$(function () {
	$("a[rel=show_img]").fancybox({
		'titlePosition' : 'over',
		'cyclic'		: false,
		'titleFormat'	: function(title, currentArray, currentIndex, currentOpts) {
			return '';
		}
	});
	
	$(".js-express").click(function () {
		if ($(".js-express_detail").data("type") != "default") {
			return;
		}
		
		var express_code = $(this).data("express_code");
		var express_no = $(this).data("express_no");
		var order_no = "user";

		$(".js-express_detail").html("tr><td></td><td>努力查询中,请稍等</td></tr>");
		var url = "index.php?c=order&a=express&type=" + express_code + "&order_no=" + order_no + "&express_no=" + express_no + "&" + Math.random();
		$.getJSON(url, function(data) {
			try {
				if (data.status == true) {
					html = '';
					for(var i in data.data.data) {
						html += '<tr>';
						html += '	<td style="text-align:right; padding-right:10px; height:24px; line-height:24px;">' + data.data.data[i].time + '</td>';
						html += '	<td>' + data.data.data[i].context + '</td>'
						html += '</tr>';
					}
					$(".js-express_detail").html(html);
					$(".js-express_detail").data("type", "data");
				} else {
					html += "tr><td></td><td>查询失败</td></tr>";
					$(".js-express_detail").html(html);
				}
			}catch(e) {
				html += "tr><td></td><td>查询失败</td></tr>";
				$(".js-express_detail").html(html);
			}
		});
	});
	
});
</script>
<div class="section" style="background-color:#FFF;">
	<h2 class="section-title clearfix">
		退货申请
	</h2>
	<div class="section-detail clearfix">
		<div>
			<table>
				<tbody>
					<tr>
						<td>状态：</td>
						<td>
							<?php echo $return['status_txt'] ?>
							<?php 
							if ($return['is_fx'] == '0' && $return['status'] == 4) {
							?>
								<button class="js-return-over" style="width:80px; height:24px;" data-id="<?php echo $return['id'] ?>" data-type="default">退货完成</button>
							<?php
							}
							?>
						</td>
					</tr>
					<tr>
						<td>退货用户：</td>
						<td><?php echo htmlspecialchars($return['nickname']) ?> <?php echo $return['phone'] ?></td>
					</tr>
					<tr>
						<td>退货类型：</td>
						<td><?php echo htmlspecialchars($return['type_txt']) ?></td>
					</tr>
					<tr>
						<td>退货理由：</td>
						<td>
							<?php echo htmlspecialchars($return['content']) ?>
						</td>
					</tr>
					<tr>
						<td>图片：</td>
						<td>
							<?php 
							if ($return['images']) {
								foreach ($return['images'] as $image) {
							?>
									<a href="<?php echo $image ?>" rel="show_img"><img src="<?php echo $image ?>" style="max-width:60px; max-height:60px;" title="点击查看大图" /></a>
							<?php 
								}
							} else {
								echo '无';
							}
							?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<h2 class="section-title clearfix" style="height:30px; line-height:30px;">
		
		<?php 
		if ($return['status'] != 6 && $return['is_fx'] == 0 && empty($return['cancel_dateline']) && $return['product_money'] == 0) {
		?>
			<span style="padding-right:10px; float:right;"><a href="javascript:" class="ui-btn ui-btn-primary js-apply-check" data-id="<?php echo $return['id'] ?>" data-order_status="<?php echo $order['status'] ?>">添加审核信息</a></span>
		<?php
		}
		?>
		审核信息
	</h2>
	<div class="section-detail clearfix">
		<div>
			<table>
				<tbody>
					<?php 
					if ($return['cancel_dateline']) {
					?>
						<tr>
							<td>不同意说明</td>
							<td><?php echo htmlspecialchars($return['store_content']) ?></td>
						</tr>
					<?php
					}
					if (!empty($return['address_user'])) {
					?>
						<tr>
							<td>收货信息</td>
							<td><?php echo htmlspecialchars($return['address_user']) ?> <?php echo $return['address_tel'] ?></td>
						</tr>
						<tr>
							<td>收货地址</td>
							<td><?php echo $return['province_txt'] . $return['city_txt'] . $return['area_txt'] . $return['address_txt'] ?></td>
						</tr>
					<?php 
					}
					if ($return['product_money'] > 0) {
					?>
						<tr>
							<td>退货金额</td>
							<td>￥<?php echo sprintf('%.2f', $return['product_money'] + $return['postage_money']) ?> = 退货产品金额：<?php echo $return['product_money'] ?> + 退货物流金额：<?php echo $return['postage_money'] ?></td>
						</tr>
					<?php 
					}
					if (empty($return['cancel_dateline']) && $return['product_money'] <= 0) {
					?>
						<tr>
							<td></td>
							<td>
								<span style="color:red; font-size:14px;">退货未审核</span>
							</td>
						</tr>
					<?php
					}
					?>
					
				</tbody>
			</table>
		</div>
	</div>
	<?php 
	if ($return['express_no']) {
	?>
		<h2 class="section-title clearfix">
			物流信息
		</h2>
		<div class="section-detail clearfix">
			<div>
				<table>
					<tbody>
						<tr>
							<td style="width:150px; text-align:right;">物流公司：</td>
							<td>
								<?php echo $return['express_company'] ?>&nbsp;&nbsp;&nbsp;&nbsp;物流单号：<?php echo $return['express_no'] ?>
								<button class="js-express" data-express_no="<?php echo $return['express_no'] ?>" data-express_code="<?php echo $return['express_code'] ?>">查看物流</button>
							</td>
						</tr>
					</tbody>
					<tbody class="js-express_detail" data-type="default">
					</tbody>
				</table>
			</div>
		</div>
	<?php 
	}
	if ($return_list) {
	?>
		<h2 class="section-title clearfix">
			供货商、分销商利润列表
		</h2>
		<div class="ui-box">
			<table class="ui-table ui-table-list" style="padding: 0px;">
				<thead class="js-list-header-region tableFloatingHeaderOriginal" style="position: static; top: 0px; margin-top: 0px; left: 601.5px; z-index: 1; width: 850px;">
					<tr>
						<th>店铺图片</th>
						<th>店铺名称</th>
						<th>联系人</th>
						<th>联系电话</th>
						<th>利润</th>
					</tr>
				</thead>
				<?php
				$profit = 0;
				$is_edit_money = true;

				// 查看是否有批发商，如果有批发商，批发商以下的分销商不显示出来
				$is_wholesale = false;
				$count = count($return_list);
				if (isset($return_list[$count - 2]) && $return_list[$count - 2]['drp_level'] == 0) {
					$is_wholesale = true;
				}
				$all_profit = 0;
				foreach ($return_list as $key => $tmp) {
					if ($key >= 1) {
						$is_edit_money = false;
					}
					$profit += $tmp['profit'];
					$tmp_profit = $tmp['profit'];

					if ($return['is_fx'] == 0 && $is_wholesale && $key < $count - 2) {
						$all_profit += $tmp['profit'];
						continue;
					}

					if ($return['is_fx'] == 0 && $is_wholesale && $key == $count - 2) {
						$tmp_profit += $all_profit;
					}
				?>
					<tr>
						<td>
							<img src="<?php echo $tmp['logo'] ?>" style="max-width:75px; max-height:75px;" />
						</td>
						<td>
							<?php echo htmlspecialchars($tmp['name']) ?><br />
							<?php
							$level_str = '';
							$style_str = '';
							if ($tmp['drp_level']) {
								$level_str = $tmp['drp_level'] . '级分销商';
							} else if ($tmp['drp_level'] == 0 && $key == count($return_list) - 2) {
								$level_str = '批发商';
								$style_str = 'style="background-color:#07d;"';
							} else {
								$level_str = '供货商';
							}
							?>
							<span class="platform-tag" <?php echo $style_str ?>><?php echo $level_str ?></span>
						</td>
						<td><?php echo htmlspecialchars($tmp['linkman']) ?></td>
						<td><?php echo $tmp['service_tel'] ?> </td>
						<td><?php echo sprintf('%.2f', $tmp_profit) ?></td>
					</tr>
				<?php
				}
				?>
			</table>
		</div>
		
		<div class="clearfix section-final" style="background-color:#FFF;">
			<div class="pull-right text-right">
				<table>
					<tbody>
						<tr>
							<td>退款产品总额：</td>
							<td class="js-profit" data-profit="<?php echo $profit ?>" data-edit="<?php echo $is_edit_money ? '1' : '0' ?>" data-discount_money="<?php echo $discount_money ?>">￥<?php echo sprintf('%.2f', $profit) ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	<?php 
	}
	?>
	
	<h2 class="section-title clearfix">
		退货商品信息
	</h2>
	<div class="ui-box">
		<table class="ui-table ui-table-list" style="padding: 0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal" style="position: static; top: 0px; margin-top: 0px; left: 601.5px; z-index: 1; width: 850px;">
				<tr>
					<th class="checkbox cell-35" colspan="2" style="min-width: 200px; max-width: 200px;">
						产品信息
					</th>
					<th class="cell-8 text-center" style="min-width: 68px; max-width: 68px;">
						退货类型
					</th>					
					<th class="cell-10 text-center" style="min-width: 112px; max-width: 112px;">
						退货状态
					</th>
					<th class="cell-8 text-center" style="min-width: 95px; max-width: 200px;">
						退货数量
					</th>
					<th class="cell-12 text-center" style="min-width: 150px; max-width: 95px;">
						退货时间
					</th>
					<th class="cell-12 text-center" style="min-width: 95px; max-width: 95px;">
						买家
					</th>
				</tr>
			</thead>
			<tr>
				<td width="70">
					<img src="<?php echo $return['image'] ?>" style="width:60px; height:60px;"/>
				</td>					
				<td class="goods-meta">
					<p class="goods-title">
						<?php echo htmlspecialchars($return['name']) ?>
						<?php 
						if ($return['sku_data']) {
							$sku_data = unserialize($return['sku_data']);
							foreach ($sku_data as $tmp) {
								echo '<br />' . $tmp['name'] . ':' . $tmp['value'];
							}
						}
						if ($return['is_fx']) {
						?>
							<span class="platform-tag">分销</span>
						<?php
						}
						?>
					</p>
					
				</td>
				<td>
					<?php echo $return['type_txt'] ?>
				</td>
				<td class="text-center">
					<?php 
					if ($return['status'] == '1') {
						echo '申请退货中';
					} else if ($return['status'] == '2') {
						echo '审核不通过';
					} else if ($return['status'] == '3') {
						echo '审核通过';
					} else if ($return['status'] == '4') {
						echo '发货中';
					} else if ($return['status'] == '5') {
						echo '退货完成';
					} else if ($return['status'] == '6') {
						echo '取消退货';
					}
					?>
				</td>
				<td class="text-center"><?php echo $return['pro_num'] ?></td>
				<td class="text-center"><?php echo date('Y-m-d H:i', $return['dateline']) ?></td>
				<td class="text-center">
					<?php echo htmlspecialchars($return['nickname'])  ?><br />
					<?php echo $return['phone'] ?>
				</td>
			</tr>
		</table>
	</div>
	
	
</div>
<h2 class="section-title clearfix">
	订单信息
</h2>
<table class="table order-goods" style="background-color:#FFF;">
	<thead>
	<tr>
		<th class="tb-thumb"></th>
		<th class="tb-name">商品名称</th>
		<th class="tb-price">单价（元）</th>
		<!--<th class="tb-price">商品优惠</th>-->
		<th class="tb-num">数量</th>
		<th class="tb-total">小计（元）</th>
		<th class="tb-postage">运费（元）</th>
	</tr>
	</thead>
	<tbody>
	<?php 
	$start_package = false; //订单已经有商品开始打包
	$return_discount = 10;
	foreach ($order['proList'] as $key => $product) {
		$skus = !empty($product['sku_data']) ? unserialize($product['sku_data']) : ''; 
		$comments = !empty($product['comment']) ? unserialize($product['comment']) : '';
	?>
		<tr data-order-id="<?php echo $order['order_id']; ?>">
			<td class="tb-thumb" <?php if (!empty($comments)) { ?>rowspan="2"<?php } ?>>
				<img src="<?php echo $product['image']; ?>" width="60" height="60" />
			</td>
			<td class="tb-name">
				<a href="<?php echo $config['wap_site_url'];?>/good.php?id=<?php echo $product['product_id'];?>" class="new-window" target="_blank"><?php echo $product['name']; ?></a>
				<?php 
				if ($product['is_present']) {
					echo '<span style="color:#f60;">赠品</span>';
				}
				?>
				<?php
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
			<td class="tb-price">
				<?php echo number_format($product['pro_price'], 2) ?>
				<?php
				$discount = 10;
				if ($product['wholesale_product_id']) {
					$discount = $order_data['order_discount_list'][$product['wholesale_supplier_id']];
				} else {
					$discount = $order_data['order_discount_list'][$product['store_id']];
				}
				
				if ($product['discount'] > 0 && $product['discount'] <= 10) {
					$discount = $product['discount'];
				}
				
				if ($discount != 10 && $discount > 0) {
					$discount_money += $product['pro_num'] * $product['pro_price'] * (10 - $discount) / 10;
					if ($return['product_id'] == $product['product_id']) {
						$return_discount = $discount;
					}
				?>
					<span style="padding:0px 5px; background:#f60; color:white; border-radius:3px;"><?php echo $discount ?>折</span>
				<?php
				}
				?>
			</td>
			<td class="tb-num"><?php echo $product['pro_num']; ?></td>
			<td class="tb-total"><?php echo number_format($product['pro_num'] * $product['pro_price'], 2, '.', ''); ?></td>
			<?php 
			if ($key == 0) {
			?>
				<td class="tb-postage" rowspan="<?php echo count($order['proList']) ?>">
					<?php echo $order['postage']; ?>
				</td>
			<?php 
			}
			?>
		</tr>
	<?php
		if (!empty($comments)) {
			foreach ($comments as $comment) {
	?>
			<tr class="msg-row">
				<td colspan="5"><?php echo $comment['name']; ?>：<?php echo $comment['value']; ?><br></td>
			</tr>
	<?php
			}
		}
	 }
	 ?>
	</tbody>
</table>
<div class="clearfix section-final" style="background-color:#FFF;">
	<div class="pull-right text-right">
		<table>
			<tbody>
			<tr>
				<td>商品小计：</td>
				<td>￥<?php echo $order['sub_total']; ?></td>
			</tr>
			<tr>
				<td>运费：</td>
				<td>￥<span class="order-postage"><?php echo $order['postage']; ?></span></td>
			</tr>
			<?php if (!empty($order['float_amount']) && $order['float_amount'] != '0.00') { ?>
			<tr>
				<td>卖家改价：</td>
				<?php if ($order['float_amount'] > 0) { ?>
				<td>+￥<?php echo $order['float_amount']; ?></td>
				<?php } else { ?>
					<td>-￥<?php echo number_format(abs($order['float_amount']), 2, '.', ''); ?></td>
				<?php } ?>
			</tr>
			<?php } ?>
			<?php
			$money = 0;
			if ($order_data['order_ward_list']) {
				foreach ($order_data['order_ward_list'] as $order_ward_list) {
					foreach ($order_ward_list as $order_ward) {
						$money += $order_ward['content']['cash'];
			?>
						<tr>
							<td>满减：</td>
							<td><?php echo getRewardStr($order_ward['content']) ?></td>
						</tr>
			<?php 
					}
				}
			}
			if ($order_data['order_coupon_list']) {
				foreach ($order_data['order_coupon_list'] as $order_coupon) {
					$money += $order_coupon['money'];
			?>
					<tr>
						<td>优惠券:</td>
						<td>
							<span><i><?php echo $order_coupon['name'] ?></i></span>
							<span>优惠金额:<i><?php echo $order_coupon['money'] ?>元</i></span>
						</td>
					</tr>
			<?php 
				}
			}
			if ($order_data['discount_money']) {
			?>
				<tr>
					<td>折扣:</td>
					<td>
						<span>优惠金额:<i><?php echo $order_data['discount_money'] ?></i>元</span>
					</td>
				</tr>
			<?php 
			}
			if (!empty($order_data['order_point'])) {
			?>
				<tr>
					<td>积分抵扣:</td>
					<td>
						<span>抵扣金额:<i><?php echo $order_data['order_point']['money'] ?></i>元</span>
					</td>
				</tr>
			<?php 
			}
			?>
			<tr>
				<td>应收款：</td>
				<td><span class="ui-money-income">￥<span class="order-total js-discount_money" data-product_discount_money="<?php echo $profit * (10 - $return_discount) / 10 ?>"><?php echo $order['total']; ?></span></span></td>
			</tr>
			</tbody>
		</table>
	</div>
</div>
