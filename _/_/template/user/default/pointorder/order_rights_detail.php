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

	
});
</script>
<div class="section" style="background-color:#FFF;">
	<h2 class="section-title clearfix">
		维权详情
	</h2>
	<div class="section-detail clearfix">
		<div>
			<table>
				<tbody>
					<tr>
						<td align="right">状态：</td>
						<td>
							<?php echo $rights['status_txt'] ?>
						</td>
					</tr>
					<tr>
						<td align="right">下单用户：</td>
						<td><?php echo htmlspecialchars($rights['nickname']) ?> <?php echo $rights['phone'] ?></td>
					</tr>
					<tr>
						<td align="right">维权类型：</td>
						<td><?php echo htmlspecialchars($rights['type_txt']) ?></td>
					</tr>
					<tr>
						<td align="right">维权理由：</td>
						<td>
							<?php echo htmlspecialchars($rights['content']) ?>
						</td>
					</tr>
					<tr>
						<td align="right">图片：</td>
						<td>
							<?php 
							if ($rights['images']) {
								foreach ($rights['images'] as $image) {
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
	<h2 class="section-title clearfix">
		平台处理信息
	</h2>
	<div class="section-detail clearfix">
		<div>
			<table>
				<tbody>
					<?php 
					if ($rights['complete_dateline']) {
					?>
						<tr>
							<td>完成时间：</td>
							<td><?php echo date('Y-m-d H:i', $rights['complete_dateline']) ?></td>
						</tr>
						<tr>
							<td>处理结果：</td>
							<td><?php echo nl2br(htmlspecialchars($rights['platform_content'])) ?></td>
						</tr>
					<?php 
					} else {
					?>
						<tr>
							<td></td>
							<td>暂无处理信息</td>
						</tr>
					<?php
					}
					?>
					
				</tbody>
			</table>
		</div>
	</div>
	<?php 
	if ($rights_list) {
	?>
		<h2 class="section-title clearfix">
			供货商、分销商利润列表&nbsp;&nbsp;(不包含邮费)
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
				$count = count($rights_list);
				if (isset($rights_list[$count - 2]) && $rights_list[$count - 2]['drp_level'] == 0) {
					$is_wholesale = true;
				}
				$all_profit = 0;
				foreach ($rights_list as $key => $tmp) {
					if ($key >= 1) {
						$is_edit_money = false;
					}
					$profit += $tmp['profit'];
					$tmp_profit = $tmp['profit'];
						
					if ($rights['is_fx'] == 0 && $is_wholesale && $key < $count - 2) {
						$all_profit += $tmp['profit'];
						continue;
					}
						
					if ($rights['is_fx'] == 0 && $is_wholesale && $key == $count - 2) {
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
							} else if ($tmp['drp_level'] == 0 && $key == count($rights_list) - 2) {
								$level_str = '经销商';
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
							<td>金额合计：</td>
							<td class="js-profit" data-profit="<?php echo $profit ?>" data-edit="<?php echo $is_edit_money ? '1' : '0' ?>">￥<?php echo sprintf('%.2f', $profit) ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	<?php 
	}
	?>
	
	<h2 class="section-title clearfix">
		维权商品信息
	</h2>
	<div class="ui-box">
		<table class="ui-table ui-table-list" style="padding: 0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal" style="position: static; top: 0px; margin-top: 0px; left: 601.5px; z-index: 1; width: 850px;">
				<tr>
					<th class="checkbox cell-35" colspan="2" style="min-width: 200px; max-width: 200px;">
						产品信息
					</th>
					<th class="cell-8 text-center" style="min-width: 68px; max-width: 68px;">
						维权类型
					</th>					
					<th class="cell-10 text-center" style="min-width: 112px; max-width: 112px;">
						维权状态
					</th>
					<th class="cell-8 text-center" style="min-width: 95px; max-width: 200px;">
						维权数量
					</th>
					<th class="cell-12 text-center" style="min-width: 150px; max-width: 95px;">
						维权时间
					</th>
					<th class="cell-12 text-center" style="min-width: 95px; max-width: 95px;">
						买家
					</th>
				</tr>
			</thead>
			<tr>
				<td width="70">
					<img src="<?php echo $rights['image'] ?>" style="width:60px; height:60px;"/>
				</td>					
				<td class="goods-meta">
					<p class="goods-title">
						<?php echo htmlspecialchars($rights['name']) ?>
						<?php 
						if ($rights['sku_data']) {
							$sku_data = unserialize($rights['sku_data']);
							foreach ($sku_data as $tmp) {
								echo '<br />' . $tmp['name'] . ':' . $tmp['value'];
							}
						}
						if ($rights['is_fx']) {
						?>
							<span class="platform-tag">分销</span>
						<?php
						}
						?>
					</p>
					
				</td>
				<td>
					<?php echo $rights['type_txt'] ?>
				</td>
				<td class="text-center">
					<?php echo $rights['status_txt'] ?>
				</td>
				<td class="text-center"><?php echo $rights['pro_num'] ?></td>
				<td class="text-center"><?php echo date('Y-m-d H:i', $rights['dateline']) ?></td>
				<td class="text-center">
					<?php echo htmlspecialchars($rights['nickname'])  ?><br />
					<?php echo $rights['phone'] ?>
				</td>
			</tr>
		</table>
	</div>
	
	
</div>
<h2 class="section-title clearfix">
	订单信息 <a href="<?php dourl('order:detail', array('id' => $rights['order_id'])) ?>">查看订单详情</a>
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
	<?php $start_package = false; //订单已经有商品开始打包?>
	<?php
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
			<td class="tb-price"><?php echo $product['pro_price']; ?></td>
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
						<span>优惠金额:<i><?php echo $order_data['discount_money'] ?>元</i></span>
					</td>
				</tr>
			<?php 
			}
			?>
			<tr>
				<td>应收款：</td>
				<td><span class="ui-money-income">￥<span class="order-total"><?php echo $order['total']; ?></span></span></td>
			</tr>
			</tbody>
		</table>
	</div>
</div>
