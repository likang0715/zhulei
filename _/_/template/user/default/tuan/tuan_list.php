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
			<span style="color: red;">注意：拼团开始后不能再编辑</span>
			<div class="js-list-search ui-search-box" data-type="<?php echo $type ?>" data-keyword="<?php echo htmlspecialchars($keyword) ?>">
				<input class="txt js-tuan-keyword" type="text" placeholder="搜索" value="<?php echo htmlspecialchars($keyword) ?>"/>
			</div>
		</div>
	</div>
</div>

<div class="ui-box">
	<?php
	if($tuan_list) {
	?>
		<table class="ui-table ui-table-list" style="padding:0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal">
				<tr>
					<th class="cell-15">拼团名称</th>
					<th class="cell-15">拼团产品</th>
					<th class="cell-25">有效时间</th>
					<th class="cell-15">活动状态</th>
					<th class="cell-15">开团次数</th>
					<th class="cell-15 pl100">参与人次</th>
					<th class="cell-25 text-right">操作</th>
				</tr>
			</thead>
			<tbody class="js-list-body-region">
				<?php
				foreach($tuan_list as $tuan) {
				?>
					<tr class="js-present-detail js-id-<?php echo $tuan['id'] ?>" service-id="<?php echo $tuan['id']?>">
						<td>
							<p style="width: 100px; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;" title="<?php echo htmlspecialchars($tuan['name'])?>">
								<?php echo htmlspecialchars($tuan['name']) ?>
							</p>
						</td>
						<td>
							<a href="<?php echo $product_list[$tuan['product_id']]['url'] ?>" target="_blank">
								<img src="<?php echo $product_list[$tuan['product_id']]['image']?>" style="max-width: 60px; max-height: 60px;" />
								<?php echo $product_list[$tuan['product_id']]['name'] ?>
							</a>
						</td>
						<td align="center">
							<?php echo date('Y-m-d H:i:s', $tuan['start_time']) ?><br/>
							至<br/>
							<?php echo date('Y-m-d H:i:s', $tuan['end_time']) ?></td>
						<td><?php echo $tuan['status'] == 1 ? getTimeType($tuan['start_time'], $tuan['end_time']) : '已结束' ?></td>
						<td>
							<?php echo $tuan['count'] ?>
							<?php 
							if ($tuan['operation_dateline'] > 0) {
							?>
								<br />
								<span style="color: green;">成功数：</span><?php echo $tuan['tuan_team_list'][1] ?>
								<br />
								<span style="color: red;">失败数：</span><?php echo $tuan['tuan_team_list'][2] ?>
							<?php 
							}
							?>
						</td>
						<td><?php echo $tuan['number'] ?></td>
						<td class="text-right js-operate" data-tuan_id="<?php echo $tuan['id'] ?>">
							<?php 
							if ($tuan['operation_dateline'] == 0 && $tuan['start_time'] < time() && $tuan['end_time'] < time()) {
							?>
								<a href="javascript:" class="js-tuan_over" data-tuan_id="<?php echo $tuan['id'] ?>">完成拼团</a>
							<?php 
							}
							?>
							<a href="#info/<?php echo $tuan['id'] ?>" class="js-edit">查看订单</a><span>-</span>
							<?php 
							if ($tuan['status'] == 1) {
							?>
								<a href="javascript:void(0);" class="js-copy-link" data-id="<?php echo $tuan['id'] ?>">复制链接</a>
								<a href="javascript:void(0);" class="js_show_ewm" data-id="<?php echo $tuan['id'] ?>">手机预览</a>
								<?php 
								if ($tuan['end_time'] > time()) {
								?>
									<a href="javascript:" class="js-disabled">使失效</a>
								<?php 
								}
								if ($tuan['start_time'] > time()) {
								?>
									<a href="#edit/<?php echo $tuan['id']?>" class="js-edit">编辑资料</a>
									<span>-</span>
									<a href="javascript:void(0);" class="js-delete">删除</a>
							<?php 
								}
							} else {
							?>
								已失效
							<?php
							}
							?>
						</td>
					</tr>
				<?php
				}
				if ($pages) {
				?>
					<thead class="js-list-header-region tableFloatingHeaderOriginal">
						<tr>
							<td colspan="7">
								<div class="pagenavi js-list_page">
									<span class="total"><?php echo $pages ?></span>
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