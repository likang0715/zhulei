<!-- ▼ Main container -->
<nav class="ui-nav-table clearfix">
	<ul class="pull-left js-list-filter-region">
		<li id="js-list-nav-all" <?php echo $type == 'all' ? 'class="active"' : '' ?>>
			<a href="#all">所有</a>
		</li>
		<li id="js-list-nav-apply" <?php echo $type == 'apply' ? 'class="active"' : '' ?>>
			<a href="#apply">申请中</a>
		</li>
		<li id="js-list-nav-future" <?php echo $type == 'future' ? 'class="active"' : '' ?>>
			<a href="#future">预热中</a>
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
			<a href="#create_repay/<?php echo $productInfo['product_id']; ?>" class="ui-btn ui-btn-primary js-create-repay">新增回报设置</a>
			<span style="color: red;">注意：在众筹项目开始后，回报设置不能再编辑</span>
		</div>
	</div>
</div>

<div class="ui-box">
	<?php if ($repay_list) { ?>
		<table class="ui-table ui-table-list" style="padding:0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal">
				<tr>
					<th class="cell-15">ID</th>
					<th class="cell-15">支付金额</th>
					<th class="cell-15">名额</th>
					<th class="cell-15" width="550">回报内容</th>
					<th class="cell-15 pl100">回报时间</th>
					<th class="cell-15 pl100">运费</th>
					<th class="cell-25 text-right">操作</th>
				</tr>
			</thead>
			<tbody class="js-list-body-region">
				<?php $time = time(); ?>
				<?php foreach($repay_list as $k=> $repay) { ?>
					<tr class="js-present-detail">
						<td>
							<?php echo ($k+1); ?>
						</td>
						<td>
							<?php echo $repay['amount'] ?>
						</td>
						<td>
							<?php echo $repay['limits'] ?>
						</td>
						<td><?php echo $repay['redoundContent']; ?></td>
						<td><?php echo '项目结束后'.$repay['redoundDays'].'天'; ?></td>
						<td><?php echo $repay['freight'].'元'; ?></td>
						<td class="text-right js-operate" data-unitary_id="<?php echo $repay['id'] ?>">
							<?php if ($productInfo['status'] == 0) { ?>
								<a href="#edit_repay/<?php echo $repay['repay_id'] ?>" class="js-edit-repay">编辑</a>
								<span>-</span>
								<a href="javascript:;" class="js-delete-repay" repayId="<?php echo $repay['repay_id'];  ?>">删除</a>
								<!-- <a href="javascript:void(0);" class="js-flush">刷新</a> -->
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
				<?php if ($page) { ?>
					<thead class="js-list-header-region tableFloatingHeaderOriginal">
						<tr>
							<td colspan="8">
								<div class="pagenavi js-repay_page"><?php echo $page ?></div>
							</td>
						</tr>
					</thead>
				<?php } ?>
			</tbody>
		</table>
		<input type="hidden" name="product_id" value="<?php echo $productInfo['product_id']; ?>" id="product_id">
	<?php } else { ?>
		<div class="js-list-empty-region">
			<div>
				<div class="no-result widget-list-empty">还没有相关数据。</div>
			</div>
		</div>
	<?php } ?>
</div>
<div class="js-list-footer-region ui-box"></div>