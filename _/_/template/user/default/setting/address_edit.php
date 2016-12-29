<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<div class="js-friend">
	<div class="js-friend-board">
		<div class="widget-app-board ui-box">
			<div class="widget-app-board-info">
				<h3>送朋友功能</h3>
				<div>
					<p>
						启用送朋友功能后，用户下订单可以通过物流方式将产品配送给朋友，此功能受物流配送是否开启影响。<br />
						<span style="color:red">用户选择“送朋友”功能后，是不能使用货到付款功能</span>
					</p>
				</div>
			</div>
			<div class="widget-app-board-control">
				<label class="js-switch js-friend-status ui-switch <?php if ($store['open_friend']) { ?>ui-switch-on<?php } else { ?>ui-switch-off<?php } ?> right"></label>
			</div>
		</div>
	</div>
	
	<div class="js-selffetch-list">
		<div class="ui-box">
			<div class="ui-btn ui-btn-success"><a href="javascript:">修改公益地址</a></div>
		</div>
		<form class="form-horizontal" style="">
			<div class="control-group">
				<label class="control-label">
					名称：
				</label>
				<div class="controls">
					<input type="text" name="title" placeholder="" maxlength="256" value="<?php echo htmlspecialchars($commonweal_address['title'])?>" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">
					<em class="required">*</em>
					收货人姓名：
				</label>
				<div class="controls">
					<input type="text" name="name" placeholder="" maxlength="50" value="<?php echo htmlspecialchars($commonweal_address['name']) ?>" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">
					<em class="required">*</em>
					联系电话：
				</label>
				<div class="controls">
					<input type="text" name="tel" placeholder="" value="<?php echo $commonweal_address['tel'] ?>" maxlength="15" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">
					<em class="required">*</em>
					所在地：
				</label>
				<div class="controls ui-regions js-regions-wrap" data-province="" data-city="" data-county="">
					<span><select name="province" id="provinceId_m" data-province="<?php echo $commonweal_address['province'] ?>"><option value="">选择省份</option></select></span>
					<span><select name="city" id="cityId_m" data-city="<?php echo $commonweal_address['city'] ?>"><option value="">选择城市</option></select></span>
					<span><select name="county" id="areaId_m" data-area="<?php echo $commonweal_address['area'] ?>"><option value="">选择地区</option></select></span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">
					<em class="required">*</em>
					联系地址：
				</label>
				<div class="controls">
					<input type="text" class="span6 js-address-input" name="address" value="<?php echo htmlspecialchars($commonweal_address['address']) ?>" placeholder="请填写详细地址" maxlength="256">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">
					<em class="required"></em>
					邮编：
				</label>
				<div class="controls">
					<input type="text" class="span6 js-zipcode-input" name="zipcode" value="<?php echo htmlspecialchars($commonweal_address['zipcode']) ?>" placeholder="" maxlength="6">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">
					<em class="required"></em>
					默认收货地址：
				</label>
				<div class="controls">
					<input type="checkbox" name="default" value="1" <?php echo $commonweal_address['default'] ? 'checked' : '' ?> />
				</div>
			</div>
			<div class="form-actions" style="margin-top:50px">
				<input type="hidden" name="address_id" value="<?php echo $commonweal_address['id'] ?>" />
				<button type="button" class="ui-btn ui-btn-primary js-address-submit">修改</button>
			</div>
		</form>
	</div>
</div>