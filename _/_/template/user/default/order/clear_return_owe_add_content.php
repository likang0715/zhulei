<div class="js-list-filter-region clearfix ui-box" style="position: relative;">
	<div class="widget-list-filter">
		<div class="js-list-filter-region clearfix">
			<form class="form-horizontal ui-box list-filter-form" onsubmit="return false;">
				<div class="control-group">
					<label class="control-label"><span class="required">*</span>金额：</label>
					<div class="controls">
						<input type="text" class="input-large amount" data-max-return-owe="<?php echo $dealer['return_owe']; ?>" name="amount" placeholder="待销账金额<?php echo $dealer['return_owe']; ?>" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">备注：</label>
					<div class="controls">
						<textarea name="bak" class="bak" style="width: auto;height: auto;" placeholder="输入销账备注"></textarea>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<a href="javascript:;" class="ui-btn ui-btn-primary btn-save" data-loading-text="正在保存...">保 存</a>
						<input type="reset" value="重 置" class="ui-btn ui-btn-primary" style="background:#009adb;border-color:#009adb;height: auto;width: auto;margin-top: -4px;" />
					</div>
				</div>
			</form>
		</div>
	</div>
</div>