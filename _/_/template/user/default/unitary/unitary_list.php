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
			<span style="color: red;">注意：夺宝开始后不能再编辑</span>
			<div class="js-list-search ui-search-box" data-type="<?php echo $type ?>" data-keyword="<?php echo htmlspecialchars($keyword) ?>">
				<input class="txt js-unitary-keyword" type="text" placeholder="搜索" value="<?php echo htmlspecialchars($keyword) ?>"/>
			</div>
		</div>
	</div>
</div>

<div class="ui-box">
	<?php if ($unitary_list) { ?>
		<table class="ui-table ui-table-list" style="padding:0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal">
				<tr>
					<th class="cell-15">名称/总价</th>
					<th class="cell-15">产品</th>
					<th class="cell-15">添加时间</th>
					<th class="cell-25" style="width:120px;">活动状态</th>
					<th class="cell-15 pl100">购买单价</th>
					<th class="cell-15 pl100">参与人次/总人次</th>
					<th class="cell-25 text-right">操作</th>
				</tr>
			</thead>
			<tbody class="js-list-body-region">
				<?php $time = time(); ?>
				<?php foreach($unitary_list as $unitary) { ?>
					<tr class="js-present-detail">
						<td>
							<?php echo $unitary['name'] ?>
							<br>
							￥<?php echo $unitary['price'] ?>
						</td>
						<td>
							<a href="<?php echo $unitary['product_url']; ?>" target="_blank">
								<img src="<?php echo getAttachmentUrl($unitary['logopic']); ?>" style="max-width: 60px; max-height: 60px;" />
								<br>
								<?php echo $unitary['product_name'] ?>
							</a>
						</td>
						<td><?php echo date('Y-m-d H:i:s', $unitary['addtime']) ?></td>
						<td>
						<?php 
							//1 进行中 2 结束 0关闭
							if ($unitary['state'] == 1) {	
								echo '<span style="color:green">进行中</span>';
							} else if ($unitary['state'] == 2) {
								echo '已结束';
							} else {
								echo '关闭';
							}

							// 是否正在倒计时
							if ($unitary['state'] == 2 && $unitary['endtime'] > $time) {

								echo '<br><span style="color:green;">【揭晓中】</span>';
								
								// $opentime = $unitary['endtime'] - $time;
								// $opentime_min = floor($opentime/60);
								// $opentime_s = $opentime%60;
								// echo '<br>剩余'.$opentime_min.'分'.$opentime_s.'秒';;
							}
						?>
						</td>
						<td><?php echo $unitary['item_price'] ?></td>
						<td><?php echo $unitary['pay_count'].'/'.$unitary['total_num'] ?></td>
						<td class="text-right js-operate" data-unitary_id="<?php echo $unitary['id'] ?>">

							<a href="javascript:void(0);" class="js-copy-link" data-id="<?php echo $unitary['id'] ?>">链接</a>
							<span>-</span>
							<a href="javascript:void(0);" class="js_show_ewm" data-id="<?php echo $unitary['id'] ?>">预览</a>

							<?php if ($unitary['state'] == 0) { ?>
								<span>-</span>
								<a href="javascript:void(0);" class="js-start">开始</a>
								<span>-</span>
								<a href="javascript:void(0);" class="js-delete">删除</a>
								<span>-</span>
								<a href="#edit/<?php echo $unitary['id'] ?>" class="js-edit">编辑</a>
							<?php } ?>

							<?php if ($unitary['state'] == 1) { ?>
								<span>-</span>
								<a href="javascript:void(0);" class="js-disabled">使失效</a>
							<?php } ?>

							<?php if ($unitary['state'] == 2) { ?>
								<span>-</span>
								<a href="javascript:void(0);" class="js-delete">删除</a>
							<?php }  ?>

							<span>-</span>
							<a href="#order/<?php echo $unitary['id'] ?>" class="js-edit">查看订单</a>

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