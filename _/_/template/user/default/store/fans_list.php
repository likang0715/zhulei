<style type="text/css">
	.list-filter-form.form-horizontal .control-label {
		width: 75px!important;
	}
	.list-filter-form.form-horizontal .controls {
		margin-left: 75px!important;
	}
</style>
<div class="widget-list-filter">
	<form class="form-horizontal ui-box list-filter-form" onsubmit="return false;">
		<div class="clearfix">
			<div class="filter-groups">
				<div class="control-group">
					<label class="control-label">昵称：</label>
					<div class="controls">
						<input type="text" name="nickname" style="width: 140px" />
					</div>
				</div>
			</div>
			<div class="pull-left">
				<div class="time-filter-groups clearfix">
					<div class="control-group">
						<label class="control-label">时间：</label>
						<div class="controls">
							<input type="text" name="start_time" id="js-start-time" class="js-start-time" value="">
							<span>至</span>
							<input type="text" name="end_time" id="js-end-time" class="js-end-time" value="">
							<span class="date-quick-pick" data-days="7">最近7天</span> <span class="date-quick-pick" data-days="30">最近30天</span> </div>
					</div>
				</div>
			</div>
			<div class="pull-left" style="margin-left: 20px;">
				<div class="ui-btn-group"> <a href="javascript:;" class="ui-btn ui-btn-primary js-filter" data-loading-text="正在筛选...">筛选</a> </div>
			</div>
		</div>
	</form>
</div>

<div class="app-preview">
	<div class="ui-box">
		<?php if($fans_list){ ?>
		<table class="ui-table ui-table-list" style="padding:0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal">
				<tr>
					<th class="text-left" width="50"><a href="javascript:;" data-orderby="feature_count">头像</a></th>
					<th class="cell-40"><a href="javascript:;" data-orderby="feature_count">昵称</a></th>
					<th class="text-center"><a href="javascript:;" data-orderby="feature_count">时间</a></th>
					<th class="text-right"><a href="javascript:;" data-orderby="feature_count">订单数</a></th>
					<th class="text-right"><a href="javascript:;" data-orderby="feature_count">积分余额</a></th>
					<th class="text-right"><a href="javascript:;" data-orderby="feature_count">消费金额</a></th>
				</tr>
			</thead>
			<tbody class="js-list-body-region">
				<?php foreach($fans_list as $fans){?>
				<tr cat-id="<?php echo $fans['uid']?>">
					<td>
						<div style="border-radius: 3rem;overflow:hidden;width: 40px;height: 40px;"><img src="<?php echo $fans['avatar']; ?>" width="40" height="40" /></div></td>
					<td><?php echo $fans['nickname']; ?></td>
					<td class="text-center"><?php echo $fans['add_time'] ? date('Y-m-d H:i:s', $fans['add_time']) : ''; ?></td>
					<td class="text-right"><?php echo $fans['orders']; ?></td>
					<td class="text-right"><?php echo $fans['point']; ?></td>
					<td class="text-right"><?php echo $fans['money']; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php }else{ ?>
		<div class="js-list-empty-region"></div>
		<?php } ?>
	</div>
	<div class="js-list-footer-region ui-box"><div><div class="pagenavi"><?php echo $page; ?></div></div></div>
</div>
