<!-- ▼ Main container -->
<nav class="ui-nav-table clearfix">
	<ul class="pull-left js-list-filter-region">
		<li id="js-list-nav-all" <?php   echo $type == 'win' ? 'class="active"' : '' ?>>
			<a href="#recordlist/<?php echo $aid;  ?>/win">中奖记录</a>
		</li>
		<li id="js-list-nav-start" <?php echo $type == 'lose' ? 'class="active"' : '' ?>>
			<a href="#recordlist/<?php echo $aid;  ?>/lose">未中奖记录</a>
		</li>
		<li id="js-list-nav-start" <?php echo $type == 'all' ? 'class="active"' : '' ?>>
			<a href="#recordlist/<?php echo $aid;  ?>/all">全部</a>
		</li>
		<input type="hidden" name="type" id="type" value="<?php echo $type; ?>" />

	</ul>
</nav>

<div class="widget-list">
	<div class="js-list-filter-region clearfix ui-box" style="position:relative;">
		<div>
			<a href="#lottery_list" class="ui-btn ui-btn-primary js-create">返回列表</a>
			<span style="color: red;"></span>
			<!-- <div class="js-list-search ui-search-box" data-type="<?php echo $type ?>" data-keyword="<?php echo htmlspecialchars($keyword) ?>">
				<input class="txt js-tuan-keyword" type="text" placeholder="搜索" value="<?php echo htmlspecialchars($keyword) ?>"/>
			</div> -->
		</div>
	</div>
</div>

<div class="ui-box">
	<?php if ($recordList) { ?>
		<table class="ui-table ui-table-list" style="padding:0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal">
				<tr>
					<th class="cell-15">序号</th>
					<th class="cell-15">奖品名称</th>
					<th class="cell-15">用户名称</th>
					<th class="cell-15">手机号</th>
					<th class="cell-15">摇奖时间</th>
					<th class="cell-25" style="width:120px;">是否中奖</th>
					<th class="cell-25" style="width:120px;">是否领取</th>
					<th class="cell-15 pl100">领取时间</th>
					<th class="cell-25 text-center" style="width:180px;">操作</th>
				</tr>
			</thead>
			<tbody class="js-list-body-region">
				<?php $time = time(); ?>
				<?php foreach($recordList as $k=> $wzc) { ?>
					<tr class="js-present-detail">
						<td><?php echo $wzc['id']; ?></td>
						<td><?php echo $wzc['prizename']; ?></td>
						<td><?php echo $wzc['wecha_name']; ?></td>
						<td><?php echo $wzc['phone']; ?></td>
						<td><?php echo date('Y-m-d H:i:s', $wzc['shaketime']); ?></td>
						<td><?php echo $wzc['iswin']==0  ? '未中奖' : '已中奖';  ?></td>
						<td><?php echo $wzc['iswin']==1  ? ($wzc['isaccept']==0  ? '未领取' : '已领取') :'---';  ?></td>
						<td><?php echo !empty($wzc['accepttime']) ? date('Y-m-d H:i:s', $wzc['accepttime']) : '---'; ?></td>
						<td class="text-center js-operate" data-product_id="<?php echo $wzc['id'] ?>">
							<?php if($wzc['iswin']==1){ ?>
							<!-- <a href="#edit_record/<?php echo $wzc['id'] ?>" class="js-edit">编辑领取状态</a>
							<span>-</span> -->
							<?php } ?>
							<?php if($wzc['prize_type']==1 && $wzc['isaccept']==1){  ?>
							<a href="#order_info/<?php echo $wzc['id'] ?>"     >查看订单状态</a>
							<span>-</span>
							<?php } ?>
							<a href="javascript:void(0);" class="js-delete-record">删除</a>

						</td>
					</tr>
				<?php } ?>
				<?php if ($page) { ?>
					<thead class="js-list-header-region tableFloatingHeaderOriginal">
						<tr>
							<td colspan="8">
								<div class="pagenavi js-list_page_record"><?php echo $page ?></div>
							</td>
						</tr>
					</thead>
				<?php } ?>
			</tbody>
		</table>
		<input type="hidden" name="activeid" id="activeid" value="<?php echo $aid; ?>" />
	<?php } else { ?>
		<div class="js-list-empty-region">
			<div>
				<div class="no-result widget-list-empty">还没有相关数据。</div>
			</div>
		</div>
	<?php } ?>
</div>
<div class="js-list-footer-region ui-box"></div>