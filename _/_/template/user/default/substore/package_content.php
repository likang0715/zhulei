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
	.control-action {
		padding-top: 5px;
	}


 	.popover-inner {
		padding: 3px;
		width: 320px;
		overflow: hidden;
		background: #000000;
		background: rgba(0, 0, 0, 0.8);
		border-radius: 4px;
		-webkit-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
		box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
	}
	.popover.bottom .arrow {
		/* left: 50%; */
		margin-left: 105px;
		border-left: 5px solid transparent;
		border-right: 5px solid transparent;
		border-bottom: 5px solid #000000;
	}
	.popover.bottom .arrow:after {
		top: 1px;
		border-bottom-color: #ffffff;
		border-top-width: 0;
	}
	.team-opt-wrapper .block-help>a:hover {
		background: #4b0;
		color:#fff
	}


	.block-help>a {
	  display: inline-block;
	  width: 16px;
	  height: 16px;
	  line-height: 18px;
	  border-radius: 8px;
	  font-size: 12px;
	  text-align: center;
	  background: #bbb;
	  color: #fff;
	}
	.block-help>a:after {
	  content: "?";
	}
	.hide{display:none}
	.bgcolor{
		background-color: lightblue;
	}
	.ui-table-order .content-row {
		border-bottom: 1px solid lightblue;
	}
	.order-no {
		color:#FF6600;
	}
	.cost-price {
		color:red;
	}
	.profit {
		color: green;
	}
</style>
<div>
    <div class="ui-nav dianpu">
        <ul>
            <li><a href="javascript:;" class="all" data="*">全部</a></li>
            <li><a href="javascript:;" class="shipped status-1" data="1">未配送</a></li>
            <li><a href="javascript:;" class="shipped status-2" data="2">配送中</a></li>
            <li><a href="javascript:;" class="arrived status-3" data="3">已送达</a></li>
        </ul>
    </div>
    <div class="js-list-filter-region clearfix ui-box" style="position: relative;">
        <div>
            <h3 class="list-title js-goods-list-title" style="line-height: 28px; font-size: 14px;">&nbsp;</h3>
            <div class="" style="position: absolute; left: 0; top: 0;">
                <select name="courier">
                    <option value="0">所有包裹</option>
                    <?php foreach ($couriers as $courier) { ?>
                    <option value="<?php echo $courier['courier_id'] ?>"><?php echo $courier['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
	<div class="ui-box orders">
	<?php if (!empty($packages)) { ?>
		<table class="ui-table-order">
			<thead class="js-list-header-region tableFloatingHeaderOriginal">
				<tr>
					<th class="" colspan="2">商品</th>
					<th class="price-cell">单价/数量</th>
					<th class="customer-cell">收货人</th>
					<th class="time-cell">
						<a href="javascript:;" class="orderby orderby_add_time" data-orderby="add_time">包裹创建时间<span class="orderby-arrow desc"></span></a>
					</th>
					<th class="aftermarket-cell">配送员</th>
					<th class="state-cell">包裹状态</th>
					<th class="pay-price-cell">操作</th>
				</tr>
			</thead>
			<?php foreach ($packages as $package) { ?>
			<tbody>
				<tr class="header-row">
					<td colspan="6">
						<div>
							<b class="order-no">订单号: <?php echo $package['order']['order_no'] ?></b>
						</div>
						<div class="clearfix">
							<div style="margin-top: 4px;margin-right: 20px;" class="pull-left">
								外部订单号: <span class="c-gray"><?php echo $package['order']['trade_no'] ?></span>
							</div>
						</div>
						<div class="clearfix">
							<div style="margin-top: 4px;margin-right: 20px;" class="pull-left">
								收货地址: 
								<span class="c-gray">
									<?php 
										echo $package['order']['address']['province'];
										echo ' ';
										echo $package['order']['address']['city'];
										echo ' ';
										echo $package['order']['address']['area'];
										echo ' ';
										echo $package['order']['address']['address'];
									?>
								</span>
							</div>
						</div>
					</td>
					<td colspan="2" class="text-right">
						<div class="order-opts-container">
							<div class="js-memo-star-container memo-star-container">
								<div class="opts">
									<div class="td-cont message-opts">
										<div class="m-opts">
											<a href="<?php dourl('order:detail', array('id' => $package['order']['order_id'])); ?>" class="js-order-detail new-window" target="_blank">查看详情</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<?php foreach ($package['order_product'] as $key => $product) { ?>
				<tr class="content-row">
					<td class="image-cell">
						<img src="<?php echo $product['image'] ?>">
					</td>
					<td class="title-cell">
						<p class="goods-title">
							<a href="<?php echo $config['wap_site_url'];?>/good.php?id=<?php echo $product['product_id'];?>&store_id=<?php echo $package['store_id']; ?>" target="_blank" class="new-window" title="<?php echo $product['name']; ?>">
								<?php echo $product['name']; ?>
							</a>
						</p>
						<p>
							<?php $skus = !empty($product['sku_data']) ? unserialize($product['sku_data']) : ''; ?>
							<?php if ($skus) { ?>
								<?php foreach ($skus as $sku) { ?>
									<span class="goods-sku"><?php echo $sku['value']; ?></span>
								<?php } ?>
							<?php } ?>
							<?php if ($product['is_fx']) { ?><span class="platform-tag">分销</span><?php } ?>
						</p>
						<!-- <p>商品来源：<?php echo $product['from']; ?></p> -->
					</td>
					<td class="price-cell">
						<p><?php echo $product['pro_price']; ?></p>
						<p>(<?php echo $product['pro_num']; ?>件)</p>
					</td>
					<?php if (count($package['order_product']) > 0 && $key == 0) { ?>
					<td class="customer-cell" rowspan="<?php echo count($package['order_product']) ?>">
						<?php if (!empty($package['order']['address_user'])) { ?>
							<p class="user-name"><?php echo $package['order']['address_user']; ?></p>
							<?php echo $package['order']['address_tel']; ?>
						<?php } else { ?>
							<p><?php echo $package['order']['buyer']; ?></p>
						<?php } ?>
					</td>
					<td class="time-cell" rowspan="<?php echo count($package['order_product']) ?>">
						<div class="td-cont">
							<?php echo date('Y-m-d H:i:s', $package['order']['add_time']); ?>
						</div>
					</td>
					<td class="aftermarket-cell" rowspan="<?php echo count($package['order_product']) ?>">
						<?php echo $package['courier'] ?>
					</td>
					<td class="state-cell" rowspan="<?php echo count($package['order_product']) ?>">
						<div class="td-cont">
							<p class="js-order-state">
							<?php if ($package['status'] == 1) {
								echo '未配送';
							} else if ($package['status'] == 2) {
								echo '配送中';
							} else if ($package['status'] == 3) {
								echo '已送达';
							} ?>
							</p>					
						</div>
					</td>
					<td class="pay-price-cell" rowspan="<?php echo count($package['order_product']) ?>">
						<div class="td-cont text-center">
							<div>
								<p>
									<!-- <a href="javascript:;" class="btn btn-small">分配送员</a> -->
								</p>
							</div>
						</div>
					</td>
					<?php } ?>
				</tr>
				<?php } ?>
			</tbody>
			<?php } ?>
		</table>
	<?php } ?>
	<?php if (empty($packages)) { ?>
		<div class="js-list-empty-region"><div><div class="no-result">还没有相关数据。</div></div></div>
	<?php } ?>
	</div>
	<div class="js-list-footer-region ui-box"><div><div class="pagenavi"><?php echo $page; ?></div></div></div>
</div>