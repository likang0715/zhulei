<div class="ui-box orders">
	<style type="text/css">
		.ui-table-order {
			width: 100%;
		}
		.text-right {
			text-align: right;
		}
		.text-center {
			text-align: center;
		}
		.text-left {
			text-align: left;
		}
	</style>
	<?php if (!empty($logs)) { ?>
	<table class="ui-table-order">
		<thead class="js-list-header-region">
		<tr>
			<th class="text-left">ID</th>
			<th class="text-right">销账金额(元)</th>
			<th class="text-center">添加时间</th>
			<th class="text-left">备注</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($logs as $log) { ?>
		<tr>
			<td class="text-left"><?php echo $log['pigcms_id']; ?></td>
			<td class="text-right" style="color: #55BD47;font-weight: bold;"><?php echo $log['amount']; ?></td>
			<td class="text-center"><?php echo date('Y-m-d H:i:s', $log['add_time']); ?></td>
			<td class="text-left"><?php echo $log['bak']; ?></td>
		</tr>
		<?php } ?>
		</tbody>
	</table>
	<?php } else { ?>
		<div class="js-list-empty-region"><div><div class="no-result">还没有相关数据。</div></div></div>
	<?php } ?>
</div>

<div class="js-list-footer-region ui-box"><div><div class="pagenavi"><?php echo $page; ?></div></div></div>