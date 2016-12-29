<!-- ▼ Main container -->
<div class="widget-list">
	<div class="js-list-filter-region clearfix ui-box" style="position:relative;">
		<div>
			<a href="#create" class="ui-btn ui-btn-primary">添加抽奖活动</a>
			<a href="javascript:history.go(-1);" class="ui-btn ui-btn-primary">返回列表</a>
		</div>
	</div>
</div>

<div class="ui-box">
	<?php
	if($lottery_record) {
	?>
		<table class="ui-table ui-table-list" style="padding:0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal">
				<tr>
					<th class="cell-15">序号</th>
					<th class="cell-15">奖品名称</th>
					<th class="cell-25">用户名称</th>
					<th class="cell-15">手机号</th>
					<th class="cell-15">摇奖时间</th>
					<th class="cell-15">是否中奖</th>
					<th class="cell-15">是否领取</th>
					<th class="cell-15">领取时间</th>
					<th class="cell-25 text-right">操作</th>
				</tr>
			</thead>
			<tbody class="js-list-body-region">
				<?php
				foreach($lottery_record as $record) {
				?>
					<tr class="js-present-detail" service-id="<?php echo $record['id']?>">
						<td><?php echo $record['id']?></td>
						<td><?php echo htmlspecialchars($lottery_prizes[$record['prize_id']]['product_name']) ?></td>
						<td><?php echo htmlspecialchars($users[$record['user_id']]['nickname'])?></td>
						<td><?php echo $users[$record['user_id']]['phone']?></td>
						<td><?php echo date('Y-m-d H:i:s',$record['dateline']) ?></td>
						<td><?php echo $record['prize_id']>0?'已中奖':'未中奖'; ?></td>
						<td><?php if($record['prize_id']>0){echo $record['status']==1?'已领取':'未领取';}?></td>
						<td><?php echo $record['prize_time']>0?date('Y-m-d H:i:s',$record['prize_time']):'';?></td>
						<td class="text-right js-operate" data-record_id="<?php echo $record['id'] ?>">
							<!-- 奖品为商品时才显示兑奖订单 -->
							<?php if($lottery_prizes[$record['prize_id']]['prize']==1){?>
							<a href="/user.php?c=order&a=detail&id=<?php echo $record['order_id']?>" target="_blank">兑奖订单</a>
							<span>-</span>
							<?php }?>
							<a href="javascript:void(0);" class="js-prize-order-delete" active_id="<?php echo $lottery['id']?>">删除</a>
						</td>
					</tr>
				<?php
				}
				if ($pages) {
				?>
					<thead class="js-list-header-region tableFloatingHeaderOriginal">
						<tr>
							<td colspan="5">
								<div class="pagenavi js-data_list_page">
									<span class="total" data-id="<?php echo $lottery['id']?>"><?php echo $pages ?></span>
								</div>
							</td>
						</tr>
					</thead>
				<?php
				}
				?>
			</tbody>
		</table>
	<?php
	}else{
	?>
		<div class="js-list-empty-region">
			<div>
				<div class="no-result widget-list-empty">还没有相关数据。</div>
			</div>
		</div>
	<?php
	}
	?>
</div>
<div class="js-list-footer-region ui-box"></div>