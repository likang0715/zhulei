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
			<a href="#addprize_good/<?php echo $id; ?>" class="ui-btn ui-btn-primary js-create">添加实物奖品</a>
			<a href="#addprize_fictitiou/<?php echo $id; ?>" class="ui-btn ui-btn-primary js-create">添加虚拟奖品</a>
			<a href="#lottery_list" class="ui-btn ui-btn-primary js-create">返回列表</a>
			<span style="color: red;"></span>
		</div>
	</div>
</div>

<div class="ui-box">
	<?php if ($prizelist) { ?>
		<table class="ui-table ui-table-list" style="padding:0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal">
				<tr>
					<th class="cell-15">序号</th>
					<th class="cell-15">奖品名称</th>
					<th class="cell-15">奖品图片</th>
					<th class="cell-15">奖品数量</th>
					<th class="cell-15">奖品剩余数量</th>
					<th class="cell-15">奖品类型</th>
					<th class="cell-25 text-right">操作</th>
				</tr>
			</thead>
			<tbody class="js-list-body-region">
				<?php $time = time(); ?>
				<?php foreach($prizelist as $k=> $wzc) { ?>
					<tr class="js-present-detail">
						<td><?php echo $wzc['id']; ?></td>
						<td><?php echo $wzc['prizename']; ?></td>
						<td>
						<a href="javascript:;" target="_blank">
						<?php if($wzc['prize_type']==1){ ?>
						<img src="<?php echo getAttachmentUrl($wzc['prizeimg']);  ?>" style="max-width: 60px; max-height: 60px;">
						<?php }elseif($wzc['prize_type']==2){ ?>
						<img src="<?php echo option("config.site_url").'/template/wap/default/images/shakelottery/youhuiquan.jpg';  ?>" style="max-width: 60px; max-height: 60px;">
						<?php }elseif($wzc['prize_type']==3){ ?>
						<img src="<?php echo option("config.site_url").'/template/wap/default/images/shakelottery/jifen.jpg';  ?>" style="max-width: 60px; max-height: 60px;">
						<?php }?>
						</a>
						</td>
						<td><?php echo $wzc['prizenum']; ?></td>
						<td><?php echo intval($wzc['prizenum'] - $wzc['expendnum']);?></td>
						<td><?php echo $wzc['prize_type']==1 ? '实物奖品' : '虚拟奖品';?></td>
						<td class="text-right js-operate" data-good_id="<?php echo $wzc['id'] ?>">
							<?php if($wzc['prize_type']==1){ ?>
							<a href="#editprize_good/<?php echo $wzc['id'] ?>" class="js-edit">编辑奖品</a>
							<?php }else{  ?>
							<a href="#editprize_fictitiou/<?php echo $wzc['id'] ?>" class="js-edit">编辑奖品</a>
							<?php	} ?>
							<span>-</span>
							<a href="javascript:void(0);" class="js-delete-good" goodId="<?php echo $wzc['id'] ?>">删除奖品</a>
						</td>
					</tr>
				<?php } ?>
				<?php if ($page) { ?>
					<thead class="js-list-header-region tableFloatingHeaderOriginal">
						<tr>
							<td colspan="8">
								<div class="pagenavi js-list_page_prize"><?php echo $page ?></div>
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
	<input  type="hidden" name="active_id" value="<?php echo $id;  ?>" id="active_id">
</div>
<div class="js-list-footer-region ui-box"></div>