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

.js-drop-dia ul {padding: 0px; margin: 0px; list-style: none;}
.js-drop-dia li {height:20px; line-height:20px; padding:2px 5px; overflow: hide; cursor: pointer;}
.js-drop-dia .current {background: #E0E0E0;}
</style>
<nav class="ui-nav clearfix">
	<ul class="pull-left">
		<li id="js-list-nav-all" class="active">
			<a href="javascript:">添加订单(专属<?php echo option('credit.platform_credit_name'); ?>做单)</a>
		</li>
	</ul>
</nav>
<div class="app-design-wrap">
	<div class="page-present clearfix">
		<div class="app-present app-reward">
			<form class="form-horizontal" id="myformaaaaaaa">
				<div class="present-info">
					<div class="js-basic-info-region">
						<h3 class="present-sub-title">用户信息</h3>
						<div class="control-group">
							<label class="control-label">
								<em class="required"> * </em>用户昵称：
							</label>
							<div class="controls" style="position:relative;">
								<input type="text" name="phone" value="" id="phone" class="js-nickname" placeholder="请填写会员昵称或手机号进行搜索" data-type="nickname" autocomplete="off" disableautocomplete old-data="" style="cursor: auto;" />
								<a href="javascript:;" class="btn btn-small js-check_phone" style="padding:4px 7px;">下一步</a>
								绑定微信：<input type="checkbox" name="weixin_bind" id="weixin_bind" value="1" />
								<div style="position:absolute; top:30px; left:0px; border:2px solid #ccc; width:215px; max-height:200px; overflow-y:scroll; background:#FFF; display: none;" class="js-drop-dia">
									<ul>
									</ul>
								</div>
								<em class="error-message"></em>
								<a href="javascript:;" class="btn btn-small js-user-scan" style="padding:4px 7px;">用户扫码</a>
								<a href="javascript:;" class="btn btn-small js-scan-user" style="padding:4px 7px;">扫会员卡</a>
								<a href="javascript:;" class="btn btn-small js-user-add" style="padding:4px 7px;">手动添加会员</a>
							</div>
						</div>
					</div>
					
					<div style="display: ;">
						<h3 class="present-sub-title js-platform_point" data-platform_point="<?php echo $user['point_balance'] + $store['point_balance'] ?>" data-margin_balance="<?php echo $store['margin_balance'] ?>">
							店铺财务信息
						</h3>
						<div class="ump-select-box">
							<table class="ui-table ui-table-list" style="padding: 0px;">
								<thead class="js-list-header-region tableFloatingHeaderOriginal">
									<tr class="widget-list-header">
										<th class="text-center cell-20" style="width: 33.3%;">
											商家可用<?php echo option('credit.platform_credit_name') ?><br />
											<?php echo $user['point_balance'] ?>
										</th>
										<th class="text-center cell-20" style="width: 33.3%;">
											商家<?php echo option('credit.platform_credit_name') ?><br />
											<?php echo $store['point_balance'] ?>
										</th>
										<th class="text-center cell-20">
											充值现金<br />
											<?php echo $store['margin_balance'] ?>
										</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					
					<div style="display: ;">
						<h3 class="present-sub-title">
							订单信息
						</h3>
						<div class="ump-select-box">
							<table class="reward-table">
								<tr>
									<td style="line-height: 24px; padding-left: 15px;">
										<span style="padding-right: 20px; width: 100px; display: inline-block;"><em class="required"> * </em>本单金额</span>
										<span style="padding-left: 10px;">
											<input type="text" name="total" style="width: 220px;" value="" old-value="" placeholder="请填写订单金额" />
										</span>
									</td>
								</tr>
								<tr>
									<td style="line-height: 24px; padding-left: 15px;">
										<span style="padding-right: 20px; width: 100px; display: inline-block;">本单需支付服务费</span>
										<span style="padding-left: 10px;" class="js-service_fee">0.00</span>元,
										赠送<?php echo option('credit.platform_credit_name') ?><span class="js-send_platform_point">0</span>
									</td>
								</tr>
								<tr>
									<td style="line-height: 24px; padding-left: 15px;">
										<span style="padding-right: 20px; width: 100px; display: inline-block;"><em class="required"> * </em>现金</span>
										<span style="padding-left: 10px;">
											<input type="text" name="cash" style="width: 220px;" value="0" old-value="" />
										</span>
									</td>
								</tr>
								<tr>
									<td style="line-height: 24px; padding-left: 15px;">
										<span style="padding-right: 20px; width: 100px; display: inline-block;"><em class="required"> * </em><?php echo option('credit.platform_credit_name') ?></span>
										<span style="padding-left: 10px;">
											<input type="text" name="platform_point" style="width: 100px;" value="0" old-value="" <?php echo option('credit.platform_credit_use_value') > 0 ? '' : 'readonly="readonly"' ?> />
										</span>
										您有个<?php echo $user['point_balance'] + $store['point_balance'] ?><?php echo option('credit.platform_credit_name') ?>，最多可抵用<span id="platform_point_max">0</span>元
									</td>
								</tr>
							</table>
						</div>
					</div>
					
					<div style="display: ;">
						<h3 class="present-sub-title">
							订单产品信息
						</h3>
						<div class="ump-select-box">
							<table class="reward-table">
								<tr>
									<td style="line-height: 24px; padding-left: 15px;">
										<span style="padding-right: 20px; width: 100px; display: inline-block;"><em class="required"> * </em>商品类别</span>
										<span style="padding-left: 10px;">
											<select class="js-product_category" style="width: auto;">
												<option value="0">请选择</option>
											</select>
										</span>
										<span class="js-product_category_container">
											
										</span>
									</td>
								</tr>
								<tr>
									<td style="line-height: 24px; padding-left: 15px;">
										<span style="padding-right: 20px; width: 100px; display: inline-block;"><em class="required"> * </em>商品名称</span>
										<span style="padding-left: 10px;">
											<input type="text" name="product_name" style="width: 300px;" value="" placeholder="请填写商品名称" />
										</span>
									</td>
								</tr>
								<tr>
									<td style="line-height: 24px; padding-left: 15px;">
										<span style="padding-right: 20px; width: 100px; display: inline-block;"><em class="required"> * </em>商品数量</span>
										<span style="padding-left: 10px;">
											<input type="text" name="number" style="width: 220px;" value="1" old-value="1" />
										</span>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</form>

			<div class="app-design js-submit-container" style="display: ;">
				<div class="control-group">
					<h3 class="present-sub-title">
						备注 <input type="text" class="js-bak" style="width:80%; " maxlength="500" placeholder="请填写备注" />
					</h3>
				</div>
				<div class="app-actions">
					<div class="form-actions text-center">
						<input class="btn btn-primary js-btn-save" type="button" value="创建订单" data-loading-text="创建订单..." />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>