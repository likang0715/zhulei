<!-- ▼ Select card -->
<div id="app-card" class="app-card order-select">
	<form class="ui-box js-search-form" onSubmit="return false">
		<div class="clearfix">
			<div class="control-group">
				<label class="control-label select">
					<select name="search_type">
						<option value="1">预订人姓名</option>
						<option value="2">预订人手机</option>
					</select>
				</label>
				<div class="controls">
					<input type="text" name="keywords" value="<?php echo $_GET['keywords'];?>">
				</div>
			</div>
			<div class="control-group time">
				<label class="control-label">到店时间：</label>
				<div class="controls">
					<input type="text" name="stime" value="<?php echo $_GET['start_time'];?>" class="js-start-time" id="js-start-time" readonly>
					<span>至</span>
					<input type="text" name="etime" value="<?php echo $_GET['end_time'];?>" class="js-end-time" id="js-end-time" readonly>
					<span class="date-quick-pick" data-days="3">最近3天</span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">预约渠道：</label>
				<div class="controls">
					<select name="source" class="js-type-select">
						<option value="0">全部</option>
						<option value="1">微信预约</option>
						<option value="2">电话预约</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">预约状态：</label>
				<div class="controls">
					<select name="status">
						<option value="0">全部</option>
						<option value="1">待确认</option>
						<option value="2">待消费</option>
						<option value="3">已完成</option>
						<option value="4">已取消</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<a href="javascript:;" class="ui-btn ui-btn-primary js-filter" data-loading-text="正在筛选...">筛选</a>
				</div>
			</div>
		</div>
	</form>
</div>
<!-- ▲ Select card -->