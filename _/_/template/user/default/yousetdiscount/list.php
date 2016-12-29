<!-- ▼ Main container -->
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
			<a href="#create" class="ui-btn ui-btn-primary js-create">新增活动</a>
			<div class="js-list-search ui-search-box" data-type="<?php echo $type ?>" data-keyword="<?php echo htmlspecialchars($keyword) ?>">
				<input class="txt js-keyword" type="text" placeholder="搜索" value="<?php echo htmlspecialchars($keyword) ?>"/>
			</div>
		</div>
	</div>
</div>

<div class="ui-box">
	<?php if ($list) { ?>
		<table class="ui-table ui-table-list" style="padding:0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal">
				<tr>
					<th class="cell-15">活动名称</th>
					<th class="cell-15">关联优惠劵【已领取/总数量】</th>
					<th class="cell-15">开始/结束时间</th>
					<th class="cell-25" style="width:120px;">开关/状态</th>
					<th class="cell-15 pl100">参与人数</th>
					<th class="cell-15 pl100">未领取人数</th>
					<th class="cell-15 pl100">领取人数</th>
					<th class="cell-25 text-right">操作</th>
				</tr>
			</thead>
			<tbody class="js-list-body-region">
				<?php $time = time(); ?>
				<?php foreach($list as $val) { ?>
					<tr class="js-present-detail">
						<td><?php echo $val['name'] ?></td>
						<td>
						<?php foreach ($val['coupon_list'] as $v) { ?>
							<p>价值<?php echo $v['face_money'] ?>元优惠劵【<?php echo $v['number'].'/'.$v['total_amount'] ?>】</p>
						<?php } ?>
						</td>
						<td><?php echo date('Y-m-d H:i:s', $val['startdate']).'<br>'.date('Y-m-d H:i:s', $val['enddate']) ?></td>
						<td>
							<?php 
								echo $val['is_open'] ? '<span style="color:red">关闭</span>' : '<span style="color:green">开启</span>';
								echo '<br>';
								if ($val['time_status'] == 'end') {
									echo '<span style="color:red">结束</span>';
								} else if ($val['time_status'] == 'ing') {
									echo '<span style="color:#07d">进行中</span>';
								} else if ($val['time_status'] == 'future') {
									echo '<span style="color:#ff6624">尚未开始</span>';
								}
							?>
						</td>
						<td><?php echo $val['allcount']; //参与人数 总 ?></td>
						<td><?php echo $val['wdhcount']; //未领取数 ?></td>
						<td><?php echo $val['ydhcount']; //已领取数 ?></td>
						<td class="text-right" data-id="<?php echo $val['id'] ?>">

							<?php if ($val['is_open'] == 0) { ?>
							<a href="javascript:void(0);" class="js-copy-link" data-id="<?php echo $val['id'] ?>" data-store_id="<?php echo $val['store_id'] ?>" data-url="<?php echo $val['url'] ?>">链接</a>
							<span>-</span>
							<a href="javascript:void(0);" class="js_show_ewm" data-id="<?php echo $val['id'] ?>" data-store_id="<?php echo $val['store_id'] ?>">预览</a>
							<span>-</span>
							<?php } ?>

							<a href="#edit/<?php echo $val['id'] ?>" class="js-edit">编辑</a>

							<span>-</span>
							<?php if ($val['is_open'] == 1) { ?>
								<a href="javascript:void(0);" class="js-start">开启</a>
							<?php } else { ?>
								<a href="javascript:void(0);" class="js-disabled">关闭</a>
							<?php } ?>

							<span>-</span>
							<a href="javascript:void(0);" class="js-delete">删除</a>

							<span>-</span>
							<a href="#record/<?php echo $val['id'] ?>" class="js-edit">参与记录</a>
						</td>
					</tr>
				<?php } ?>
				<?php if ($page) { ?>
					<thead class="js-list-header-region tableFloatingHeaderOriginal">
						<tr>
							<td colspan="8">
								<div class="pagenavi js-list_page"><?php echo $page ?></div>
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