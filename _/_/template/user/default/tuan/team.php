<thead class="js-list-header-region tableFloatingHeaderOriginal">
	<tr>
		<th class="cell-15">团长</th>
		<th class="cell-15">开团模式</th>
		<th class="cell-15">级别</th>
		<th class="cell-15">开团时间</th>
		<th class="cell-15">购买数量</th>
		<th class="cell-15">状态</th>
		<th class="cell-15">
			操作
		</th>
	</tr>
	<?php 
	$item_count  = 0;
	foreach ($tuan_team_list as $key => $tuan_team) {
	?>
		<tr class="js-tuan_team" data-team_id="<?php echo $tuan_team['team_id'] ?>">
			<td><?php echo $tuan_team['nickname'] ? $tuan_team['nickname'] : '匿名' ?></td>
			<td><?php echo $tuan_team['type'] == 1 ? '最优开团' : '人缘开团' ?></td>
			<td><?php echo $tuan_config_arr[$tuan_team['item_id']] ?></td>
			<td><?php echo date('Y-m-d H:i', $tuan_team['dateline']) ?></td>
			<td>
				<?php echo $tuan_team['number'] ?>
				<?php 
				if ($tuan_team['status'] == 0 && $tuan_team['number'] >= $tuan_config_list[$tuan_team['item_id']]['number']) {
					echo '<span style="color: green;">已达标</span>';
				} else if ($tuan_team['status'] == 0) {
					echo '<span style="color: red;">暂未达标</span>';
				}
				?>
			</td>
			<td><?php echo $tuan_team['status'] == 1 ? '<span style="color: green;">成功</span>' : ($tuan_team['status'] == 2 ? '<span style="color: red;">失败</span>' : ($tuan['end_time'] < time() ? '未审核' : '进行中')) ?></td>
			<td>
				<a href="javascript:" data-team_id="<?php echo $tuan_team['team_id'] ?>" class="js-team_order">查看此团订单</a>
				<a href="javascript:" data-tuan_id="<?php echo $tuan_team['tuan_id'] ?>" data-type="<?php echo $tuan_team['type'] ?>" data-item_id="<?php echo $tuan_team['item_id'] ?>" data-team_id="<?php echo $tuan_team['team_id'] ?>" class="js-team_link">查看此团链接</a>
				<a href="javascript:" data-team_id="<?php echo $tuan_team['team_id'] ?>" class="js_team_show_ewm">手机预览</a>
			</td>
		</tr>
	<?php 
	}
	if ($pages) {
	?>
		<tr class="js-tuan_team" data-team_id="<?php echo $tuan_team['team_id'] ?>">
			<td colspan="7">
				<div class="pagenavi js-team_list_page">
					<?php echo $pages ?>
				</div>
			</td>
		</tr>
	<?php 
	}
	?>
</thead>