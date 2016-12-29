<!-- ▼ Main container -->
<nav class="ui-nav-table clearfix">
	<ul class="pull-left js-list-filter-region">
		<li id="js-list-nav-all" <?php   echo $type == 'all' ? 'class="active"' : '' ?>>
			<a href="#lottery_list/all">所有</a>
		</li>
		<li id="js-list-nav-start" <?php echo $type == 'open' ? 'class="active"' : '' ?>>
			<a href="#lottery_list/open">开启</a>
		</li>
		<li id="js-list-nav-end" <?php   echo $type == 'close' ? 'class="active"' : '' ?>>
			<a href="#lottery_list/close">关闭</a>
		</li>
	</ul>
</nav>

<div class="widget-list">
	<div class="js-list-filter-region clearfix ui-box" style="position:relative;">
		<div>
			<a href="#create" class="ui-btn ui-btn-primary js-create">新增活动</a>
			<span style="color: red;"></span>
			<!-- <div class="js-list-search ui-search-box" data-type="<?php echo $type ?>" data-keyword="<?php echo htmlspecialchars($keyword) ?>">
				<input class="txt js-tuan-keyword" type="text" placeholder="搜索" value="<?php echo htmlspecialchars($keyword) ?>"/>
			</div> -->
		</div>
	</div>
</div>

<div class="ui-box">
	<?php if ($lottery_list) { ?>
		<table class="ui-table ui-table-list" style="padding:0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal">
				<tr>
					<th class="cell-15">活动名称</th>
					<th class="cell-15">活动开始时间</th>
					<th class="cell-15">活动结束时间</th>
					<th class="cell-25" style="width:120px;">转发数</th>
					<th class="cell-15 pl100">活动状态</th>
					<th class="cell-15 pl100">是否开启</th>
					<th class="cell-25 text-right">操作</th>
				</tr>
			</thead>
			<tbody class="js-list-body-region">
				<?php $time = time(); ?>
				<?php foreach($lottery_list as $k=> $wzc) { ?>
					<tr class="js-present-detail">
						<td><?php echo $wzc['action_name'] ?></td>
						<td><?php echo date('Y-m-d H:i:s', $wzc['starttime']); ?></td>
						<td><?php echo date('Y-m-d H:i:s', $wzc['endtime']); ?></td>
						<td><?php echo $wzc['share_count'];  ?></td>
						<td>
						<?php
						$time = $_SERVER['REQUEST_TIME'];
						if($time<$wzc['starttime']){
							echo '活动还未开始';
						}elseif($time>$wzc['endtime']){
							echo '活动已过期';
						}elseif($time<=$wzc['endtime'] && $time>=$wzc['starttime']){
							echo '活动进行中';
						}
						unset($time);
						?>
						</td>
						<td><?php echo $wzc['status']==1  ? '已开启' : '已关闭'; ?></td>
						<td class="text-right js-operate" data-product_id="<?php echo $wzc['id'] ?>">
							<a href="#prizelist/<?php echo $wzc['id']; ?>" class="js-repay-list">摇奖奖品</a>
							<span>-</span>
							<a href="#recordlist/<?php echo $wzc['id']; ?>" class="js-repay-list">摇奖记录</a>
							<span>-</span>
							<a href="javascript:void(0);" class="js-copy-link" >链接</a>
							<span>-</span>
							<a href="javascript:;" class="js_show" url="?c=shakelottery&a=toCode&id=<?php echo $wzc['id'] ?>">手机预览</a>
							<span>-</span>
							<a href="#edit/<?php echo $wzc['id'] ?>" class="js-edit">编辑</a>
							<span>-</span>
							<a href="javascript:void(0);" class="js-delete">删除</a>

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