<!-- ▼ Main container -->
<nav class="ui-nav-table clearfix">
	<ul class="pull-left js-list-filter-region">
		<li id="js-list-nav-all" <?php echo $type == 'all' ? 'class="active"' : '' ?>>
			<a href="#all">所有拼团</a>
		</li>
		<li id="js-list-nav-future" <?php echo $type == 'future' ? 'class="active"' : '' ?>>
			<a href="#future">未开始</a>
		</li>
		<li id="js-list-nav-on" <?php echo $type == 'on' ? 'class="active"' : '' ?>>
			<a href="#on">进行中</a>
		</li>
		<li id="js-list-nav-end" <?php echo $type == 'end' ? 'class="active"' : '' ?>>
			<a href="#end">已结束</a>
		</li>
	</ul>
</nav>

<div class="widget-list">
	<div class="js-list-filter-region clearfix ui-box" style="position:relative;">
		<div>
			<a href="#create" class="ui-btn ui-btn-primary js-create">添加拼团</a>
			<div class="js-list-search ui-search-box" data-type="<?php echo $type ?>" data-keyword="<?php echo htmlspecialchars($keyword) ?>">
				<input class="txt js-tuan-keyword" type="text" placeholder="搜索" value="<?php echo htmlspecialchars($keyword) ?>"/>
			</div>
		</div>
	</div>
</div>

<div class="ui-box">
	<table class="ui-table ui-table-list" style="padding:0px;">
		<thead class="js-list-header-region tableFloatingHeaderOriginal">
			<tr>
				<th class="cell-15">拼团名称</th>
				<th class="cell-15">拼团产品</th>
				<th class="cell-25">有效时间</th>
				<th class="cell-15">购买数量</th>
			</tr>
			<tr>
				<td><?php echo htmlspecialchars($tuan['name']) ?></td>
				<td>
					<img src="<?php echo $product['image'] ?>" style="max-width: 60px; max-height: 60px;" />
					<?php echo htmlspecialchars($product['name']) ?>
				</td>
				<td>
					<?php echo date('Y-m-d H:i:s', $tuan['start_time']) ?>~<?php echo date('Y-m-d H:i:s', $tuan['end_time']) ?>
					<?php 
					if ($tuan['tuan_config_id'] == -1) {
					?>
						<br /><span style="color: red;">拼团失败</span>
					<?php 
					}
					?>
				</td>
				<td>
					<?php echo array_sum($count_list) ?><br />
					人缘开团：<?php echo $count_list[0] ?><br />
					最优开团：<?php echo $count_list[1] ?>
				</td>
			</tr>
		</thead>
	</table>
	<br />
	拼团设置：
	<table class="ui-table ui-table-list" style="padding:0px;">
		<thead class="js-list-header-region tableFloatingHeaderOriginal">
			<tr>
				<th class="cell-15">级别</th>
				<th class="cell-15">购买数</th>
				<th class="cell-15">折扣</th>
				<th class="cell-15">参团数据</th>
			</tr>
			<?php 
			$item_count  = 0;
			foreach ($tuan_config_list as $key => $tuan_config) {
				// 此级是否达标
				$item_level = 0;
				$item_count += $count_list[$tuan_config['id']] + 0;
			?>
				<tr>
					<td><?php echo $key + 1 ?>级达标</td>
					<td><?php echo $tuan_config['number'] ?></td>
					<td><?php echo $tuan_config['discount'] ?></td>
					<td>
						<?php 
						if ($tuan['operation_dateline'] > 0) {
						?>
							成功：<?php echo $tuan_config['success_count'] ?><br />
							失败：<?php echo $tuan_config['fail_count'] ?><br />
						<?php 
						} else {
						?>
							开团数：<?php echo $tuan_config['count'] ?>
						<?php 
						}
						?>
					</td>
				</tr>
			<?php 
			}
			?>
		</thead>
	</table>
	<br />
	开团列表：<a href="javascript:" class="js-team_order" data-team_id="0">查看所有订单</a>
	<?php 
	if ($tuan['operation_dateline'] == 0 && $tuan['start_time'] < time() && $tuan['end_time'] < time()) {
	?>
		<a href="javascript:" class="js-tuan_over" data-tuan_id="<?php echo $tuan['id'] ?>">完成拼团</a>
	<?php 
	}
	?>
	<table class="ui-table ui-table-list js-tuan_team_list" style="padding:0px;">
		
	</table>
	<div class="tuan_order_list">
		<br />
		<div class="js-list-empty-region">
			<div>
				<div class="no-result widget-list-empty">还没有相关订单数据。</div>
			</div>
		</div>
	</div>
</div>
<div class="js-list-footer-region ui-box"></div>
<div class="js-tuan_id" data-tuan_id="<?php echo $tuan['id'] ?>"></div>