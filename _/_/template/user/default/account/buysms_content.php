<style type="text/css">
	.get-web-img-input {
		height: 30px!important;
	}
</style>
<div>
	<form class="form-horizontal">
		<fieldset>

			<div class="control-group">
				<label class="control-label">短信价格：</label>

				<div class="controls">
					<input type="text" data-price="<?php echo $sms_price;?>" readonly="readonly" value="<?php echo $sms_price;?>分/条" name="sms_price" maxlength="15" />
				</div>
			</div>
			<div class="control-group">&#12288;</div>
			<div class="control-group">
				<label class="control-label">购买条数：</label>

				<div class="controls">
					<input type="text" value="1000" name="sms_amount" maxlength="6" /> 条 （1000条起订）
				</div>
			</div>
			<div class="control-group">&#12288;</div>
			<div class="control-group">
				<label class="control-label">价格合计：</label>

				<div class="controls">
					90元
				</div>
			</div>
			<div class="control-group">&#12288;</div>
			<div class="control-group control-action">
				<div class="controls">
					<button class="btn btn-large btn-primary js-btn-submit" type="button" data-loading-text="正在提交...">确认购买</button>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="<?php dourl('store:select'); ?>">取消</a>
				</div>
			</div>

		</fieldset>
	</form>
</div>