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
			<a href="#create" class="ui-btn ui-btn-primary js-create">新增活动</a>
			<span style="color: red;">注意：众筹项目开始后不能再编辑</span>
			<!-- <div class="js-list-search ui-search-box" data-type="<?php echo $type ?>" data-keyword="<?php echo htmlspecialchars($keyword) ?>">
				<input class="txt js-tuan-keyword" type="text" placeholder="搜索" value="<?php echo htmlspecialchars($keyword) ?>"/>
			</div> -->
		</div>
	</div>
</div>

<div class="ui-box">
	<?php if ($wzc_list) { ?>
		<table class="ui-table ui-table-list" style="padding:0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal">
				<tr>
					<th class="cell-15">名称</th>
					<th class="cell-15">缩略图</th>
					<th class="cell-15">添加时间</th>
					<th class="cell-25" style="width:120px;">活动状态</th>
					<th class="cell-15 pl100">已筹资金额</th>
					<th class="cell-15 pl100">参与人数</th>
					<th class="cell-25 text-right">操作</th>
				</tr>
			</thead>
			<tbody class="js-list-body-region">
				<?php $time = time(); ?>
				<?php foreach($wzc_list as $k=> $wzc) { ?>
					<tr class="js-present-detail">
						<td>
							<?php echo $wzc['productName'] ?>
						</td>
						<td>
							<a href="javascript:;" target="_blank">
								<img src="<?php echo getAttachmentUrl($wzc['productFirstImg']); ?>" style="max-width: 60px; max-height: 60px;" />
							</a>
						</td>
						<td><?php echo date('Y-m-d H:i:s', $wzc['time']) ?></td>
						<td>
						<?php
							switch ($wzc['status']) {
								case '0':
									echo '<span style="color:green">草稿中</span>';
									break;
								case '1':
									echo '<span style="color:green">申请中</span>';
									break;
								case '2':
									echo '<span style="color:green">预热中</span>';
									break;
								case '3':
									echo '<span style="color:green">审核拒绝</span>';
									break;
								case '4':
									echo '<span style="color:green">融资中</span>';
									break;
								case '6':
									echo '<span style="color:green">融资成功</span>';
									break;
								case '7':
									echo '<span style="color:green">融资失败</span>';
									break;
								default:
									echo '<span style="color:red">未知状态</span>';
									break;
							}
						?>
						</td>
						<td><?php echo $wzc['collect'].'元'; ?></td>
						<td><?php echo $wzc['people_number']; ?></td>
						<td class="text-right js-operate" data-product_id="<?php echo $wzc['product_id'] ?>">
							<?php if($wzc['status']==0){ ?>
							<a href="javascript:void(0);" class="js-start-link" data-id="<?php echo $wzc['product_id'] ?>" repayNub="">开始路演</a>
							<span>-</span>
							<a href="#repaylist/<?php echo $wzc['product_id']; ?>" class="js-repay-list">回报设置</a>
							<?php } ?>
							<?php if($wzc['status']==2){ ?>
							<a href="javascript:void(0);" class="js-start-collect" data-id="<?php echo $wzc['product_id'] ?>" repayNub="">开始筹资</a>
							<span>-</span>
							<?php } ?>
							<?php if($wzc['status']==2||$wzc['status']==4){ ?>
							<a href="javascript:void(0);" class="js-copy-link" data-id="<?php echo $wzc['product_id'] ?>">链接</a>
							<span>-</span>
							<a href="javascript:;" class="js_show" url="?c=wzc&a=toCode&id=<?php echo $wzc['product_id'] ?>">手机预览</a>
							<?php } ?>

							<?php if ($wzc['status'] == 0) { ?>
								<span>-</span>
								<a href="#edit/<?php echo $wzc['product_id'] ?>" class="js-edit">编辑</a>
								<span>-</span>
								<a href="javascript:void(0);" class="js-delete">删除</a>
							<?php } ?>

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