<!-- ▼ Main container -->
<style type="text/css">
.user_avatar { width: 50px; height: 50px; border-radius: 50%; border: 5px solid #fff; }
</style>
<nav class="ui-nav-table clearfix">
	<ul class="pull-left js-list-filter-region">
		<li id="js-list-nav-all" <?php echo $type == 'all' ? 'class="active"' : '' ?>>
			<a href="#all">所有</a>
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
			<a href="javascript:void(0)" class="ui-btn ui-btn-primary js-create">活动 (<?php echo $unitary['name']; ?>) 订单</a>
		</div>
	</div>
</div>

<div class="ui-box">
	<?php if ($lucknum_list) { ?>
		<table class="ui-table ui-table-list" style="padding:0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal">
				<tr>
					<th class="cell-15">昵称</th>
					<th class="cell-15">电话</th>
					<!-- <th class="cell-25">地址</th> -->
					<th class="cell-25">状态</th>
					<th class="cell-25">幸运号码</th>
					<th class="cell-15">购买时间</th>
					<th class="cell-25 text-right">操作</th>
				</tr>
			</thead>
			<tbody class="js-list-body-region">
				<?php foreach($lucknum_list as $lucknum) { ?>
					<tr class="js-present-detail">
						<td>
							<img src="<?php echo $lucknum['avatar']; ?>" class="user_avatar">
							<br>
							<?php echo $lucknum['name'] ?>
						</td>
						<td>
							<?php echo $lucknum['phone'] ?>
						</td>
						<td>
						<?php

							if ($unitary['state'] == 2) {
								//1 开始 2 结束 0关闭
								if ($lucknum['state'] == 1) {
									echo '<span style="color:red">中奖</span>';
								} else {
									echo '未中';
								}

							} else {
								echo '等待揭晓';
							}

						?>
						</td>
						<td><?php echo $lucknum['lucknum'] + 100000; ?></td>
						<td><?php echo date('Y-m-d H:i:s', $lucknum['addtime']/1000) ?></td>
						<td class="text-right">
						<?php if ($lucknum['state'] == 1) { ?>
							<a href="<?php dourl('order:all') ?>" target="_blank">去查看订单</a>
						<?php } ?>
						</td>
					</tr>
				<?php } ?>
				<?php if ($page) { ?>
					<thead class="js-list-header-region tableFloatingHeaderOriginal">

						<tr>
							<td colspan="7">
								<div class="pagenavi js-order_page"><?php echo $page ?></div>
							</td>
						</tr>
					</thead>
				<?php } ?>
			</tbody>
		</table>
	<?php } else { ?>
		<div class="js-list-empty-region">
			<div>
				<div class="no-result widget-list-empty">还没有相关数据。</div>
			</div>
		</div>
	<?php } ?>
</div>
<div class="js-list-footer-region ui-box"></div>