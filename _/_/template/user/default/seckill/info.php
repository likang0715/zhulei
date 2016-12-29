<!-- ▼ Main container -->
<nav class="ui-nav-table clearfix">
	<ul class="pull-left js-list-filter-region">
		<li id="js-list-nav-all" <?php echo $type == 'all' ? 'class="active"' : '' ?>>
			<a href="#all">所有团购</a>
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
			<a href="#create" class="ui-btn ui-btn-primary js-create">添加团购</a>
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
				<th class="cell-15">团购名称</th>
				<th class="cell-15">团购产品</th>
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
						<br /><span style="color: red;">团购失败</span>
					<?php 
					}
					?>
				</td>
				<td>
					<?php echo $count ?><br />
					人缘开团：<?php echo $count_ry ?><br />
					最优开团：<?php echo $count - $count_ry ?>
				</td>
			</tr>
		</thead>
	</table>
	<br />
	各项团购进度：<span style="display: <?php echo ($tuan['tuan_config_id'] != 0 || $tuan['start_time'] < time()) ? 'none;' : '' ?>"><a href="javascript:" class="hide js-tuan_cancel" data-tuan_id="<?php echo $tuan['id'] ?>">设置团购失败</a></span>
	<table class="ui-table ui-table-list" style="padding:0px;">
		<thead class="js-list-header-region tableFloatingHeaderOriginal">
			<tr>
				<th class="cell-15">级别</th>
				<th class="cell-15">团购项规格</th>
				<th class="cell-15">达标情况</th>
				<th class="cell-15">
					操作
				</th>
			</tr>
			<?php 
			$item_count  = 0;
			foreach ($tuan_config_list as $key => $tuan_config) {
				// 此级是否达标
				$item_level = 0;
				$item_count += $count_list[$tuan_config['id']] + 0;
			?>
				<tr>
					<td>
						<?php echo $key + 1 ?>级达标
					</td>
					<td>
						参团数：<?php echo $tuan_config['number'] ?><br />
						折　扣：<?php echo $tuan_config['discount'] ?><br />
						开始数：<?php echo $tuan_config['start_number'] ?>
					</td>
					<td>
						最优开团购买数：<?php echo $count_list[$tuan_config['id']] + 0 ?><br />
						达到此级购买数：<?php echo $item_count + $count_ry + $tuan_config['start_number'] ?>
						<?php 
						if (empty($tuan['tuan_config_id'])) {
							if ($item_count + $count_ry + $tuan_config['start_number'] >= $tuan_config['number']) {
								$item_level = 1;
						?>
								<span style="color: green;">已达标</span>
						<?php 
							} else {
						?>
								<span style="color: red;">未达标</span>
						<?php 
							}
						}
						?>
					</td>
					<td class="js-item_level" data-level="<?php echo $item_level ?>">
						<?php 
						if ($tuan['end_time'] < $_SERVER['REQUEST_TIME'] && empty($tuan['tuan_config_id'])) {
						?>
							<a href="javascript:" class="js-set_tuan_item" data-tuan_config_id="<?php echo $tuan_config['id'] ?>" data-tuan_id="<?php echo $tuan['id'] ?>">设置此级达标</a>
						<?php 
						} else if ($tuan['tuan_config_id']) {
							if ($tuan['tuan_config_id'] == $tuan_config['id']) {
						?>
								<span style="color: green;">此级达标</span>
						<?php 
							} else {
								echo '-';
							}
						} else {
							echo '-';
						}
						?>
					</td>
				</tr>
			<?php 
			}
			?>
		</thead>
	</table>
	<div class="tuan_order_list">
		
	</div>
</div>
<div class="js-list-footer-region ui-box"></div>