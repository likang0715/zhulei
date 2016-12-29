<script type="text/javascript">
	var comment_groups_json = '<?php echo $comment_groups_json; ?>';
</script>
<style type="text/css">
	.red {
		color: red;
	}
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
</style>
<div class="goods-list">
	<div class="js-list-filter-region clearfix ui-box" style="position: relative;">
		<div>
			<h3 class="list-title js-goods-list-title">退货申请列表</h3>
		</div>
	</div>
	<div class="ui-box">
		<table class="ui-table ui-table-list" style="padding: 0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal" style="position: static; top: 0px; margin-top: 0px; left: 601.5px; z-index: 1; width: 850px;">
			<?php
			if (!empty($return_list)) {
			?>
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
					<th class="cell-15 text-center" style="min-width: 95px; max-width: 95px;">操作</th>
				</tr>
			<?php
			}
			?>
			</thead>
			<tbody class="js-list-body-region">
			<?php 
			if(is_array($return_list)) {
				foreach ($return_list as $return) {
			?>
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
								if ($return['is_fx'] == 2) {
								?>
									<span class="platform-tag" style="background-color:#07d;">批发</span>
								<?php
								} else if ($return['is_fx'] == 1) {
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
							<?php echo $return['status_txt'] ?><br />
							<a href="<?php dourl('order:detail', array('id' => $return['order_id'])) ?>">订单详情</a>
						</td>
						<td class="text-center"><?php echo $return['pro_num'] ?></td>
						<td class="text-center"><?php echo date('Y-m-d H:i', $return['dateline']) ?></td>
						<td class="text-center">
							<?php echo htmlspecialchars($return['nickname'])  ?><br />
							<?php echo $return['phone'] ?>
						</td>
						<td class="text-center">
							<a href="#detail/<?php echo $return['id'] ?>" class="js-return-detail">查看退货</a><br />
						</td>
					</tr>
			<?php
				}
			}
			?>
			</tbody>
		</table>
		<?php
		if (empty($return_list)) {
		?>
			<div class="js-list-empty-region"><div><div class="no-result">还没有相关数据。</div></div></div>
		<?php
		}
		?>
	</div>
</div>