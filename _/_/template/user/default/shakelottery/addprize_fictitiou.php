<style>
.error-message {color:#b94a48;}
.hide {display:none;}
.error{color:#b94a48;}
.ui-timepicker-div .ui-widget-header {margin-bottom:8px; }
.ui-timepicker-div dl {text-align:left; }
.ui-timepicker-div dl dt {height:25px;margin-bottom:-25px; }
.ui-timepicker-div dl dd {margin:0 10px10px65px; }
.ui-timepicker-div td {font-size:90%; }
.ui-tpicker-grid-label {background:none;border:none;margin:0;padding:0; }
.controls .ico li .checkico {width: 50px;height: 54px;display: block;}
.controls .ico li .avatar {width: auto; height: auto;max-height: 50px;max-width: 50px;display: inline-block;}
.no-selected-style i {display: none;}
.icon-ok {background-position: -288px 0;}
.module-goods-list li img, .app-image-list li img {height: 100%;width: 100%;}
.tequan {width: 100%;min-height: 60px;line-height: 60px;}
.controls .input-prepend .add-on { margin-top: 5px;}
.controls .input-prepend input {border-radius:0px 5px 5px 0px}
.control-group table.reward-table{width:85%;}
.tequan li{float:left;width:30%;text-align:left;margin-left:3%;}
.form-horizontal .control-label{width:150px;}
.form-horizontal .controls{margin-left:0px;}
.controls  .renshu .add-on{margin-left:-3px;border-radius:0 4px 4px 0;}
.js-condition {height:35px;}

.controls .chose-label { height: 28px; line-height: 28px; float: left; margin-right: 20px; }
</style>

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
<nav class="ui-nav clearfix">
	<ul class="pull-left">
		<li id="js-list-nav-all" class="active">
			<a href="javascript:">设置虚拟奖品</a>
		</li>
	</ul>
</nav>
<div class="app-design-wrap">
	<div class="page-presale clearfix">
		<div class="app-presale app-reward">
			<form class="form-horizontal" id="myformaaaaaaa">
				<div class="presale-info">
					<input type="hidden" name="sku_id" value="0">
					<input type="hidden" name="aid" value="<?php echo $activeId; ?>">
					<input type="hidden" name="prizename" value="">
					<input type="hidden" name="prize_id" value="0">
					<div class="control-group">
						<label class="control-label" style="">
							<em class="required"> *</em>选择虚拟奖品类型：
						</label>
						<div class="controls">
							<select id="prize_types" name="prize_types" >
								<option value="0">选择奖品</option>
								<option value="2">优惠券</option>
								<option value="3">店铺积分</option>
							</select>
						</div>
					</div>
					<div class="control-group" style="display:none ;" id="coupon_select" >
						<label class="control-label" style="">
							<em class="required"> *</em>选择优惠券：
						</label>
						<div class="controls">
							<select id="coupon_value" name="coupon_value" >
								<option value="0">选择优惠券</option>
								<?php foreach ($coupon_list as $coupon) {  ?>
								<option value="<?php echo $coupon['id']; ?>"  ku="<?php echo $coupon['total_amount']-$coupon['number']; ?>"  ><?php echo $coupon['name']; ?></option>
								<?php  } ?>
							</select>
							<!-- <input type="text" name="coupon_nub" style="width: 60px;" value="0" id="coupon_nub" />&nbsp;张 -->
						</div>
					</div>
					<div class="control-group coupon ku-fictitiou" style="display: none;">
						<label class="control-label">
							<em class="required"> *</em>库存数量：
						</label>
						<div class="controls">
							<input type="text" name="ku" style="width: 100px;" disabled="" value="0" />
							<span style="padding-top: 5px; color: red;">
								禁止修改
							</span>
						</div>
					</div>
					<div class="control-group sku" style="display:none ;" id="integral_write">
						<label class="control-label">
							<em class="required"> *</em>积分数：
						</label>
						<div class="controls">
							<input type="text" name="integral" style="width: 100px;" value="0" id="integral" />
							<span style="padding-top: 5px; color: red;">
							</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> *</em>奖品总数：
						</label>
						<div class="controls">
							<input type="text" name="prizenum" value="0" style="width: 100px;" />
							<span style="padding-top: 5px; color: red;">
							</span>
						</div>
					</div>
				</div>
			</form>

			<div class="app-design">
				<div class="app-actions">
					<div class="form-actions text-center">
						<input class="btn js-btn-quit-prize" type="button" value="取 消" />
						<input class="btn btn-primary js-create-save-fictitiou" type="button" value="保 存" data-loading-text="保 存..." />
					</div>
				</div>
			</div>
		</div>
	</div>

</div>