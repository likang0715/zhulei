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
			<a href="javascript:">添加订单</a>
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
							</div>
						</div>
					</div>
					
					<div class="js-product-container" style="display: none;">
						<h3 class="present-sub-title">
							选择商品 
							<a href="javascript:;" data-id="4" class="btn btn-small js-select-order" style="padding:4px 7px;">选择商品</a>
							<a href="javascript:;" data-id="4" class="btn btn-small js-scan-select-order" style="padding:4px 7px;">扫码选择商品</a>
						</h3>
					
						<div class="goods-list-wrap">
							<!--已选产品开始-->
							<div class="js-selected-goods-list-region js-goods-list-tab" style="display: ;">
								<div class="widget-list">
									<div class="ump-select-box js-select-goods-list">
										<div class="ump-goods-wrap">
											<div class="ump-select-goods ump-waitting-select ump-goods-list">
												<div class=" loading">
													<table class="ui-table ui-table-list" style="padding: 0px;">
														<thead class="js-list-header-region tableFloatingHeaderOriginal">
															<tr class="widget-list-header">
																<th>商品信息</th>
																<th class="text-center cell-20">价格</th>
																<th class="text-center cell-20">购买数量</th>
																<th class="text-center cell-20">操作</th>
															</tr>
														</thead>
														<tbody class="js-product-list-selected">
															<tr class="js-no-product">
																<td colspan="4" style="text-align:center; height:100px;">还没有相关数据。</td>
															</tr>
														</tbody>
													</table>
													<div class="js-list-empty-region"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--已选产品结束-->
						</div>
					</div>
					
					<style>
					.control-group td {height:35px; padding-left:10px;}
					.control-group .txt {border:1px solid #CCC; height:24px; border-radius:4px;}
					.control-group select {width:auto;}
					.logistics-type .btn {background:white; color:#999; border:1px solid #e5e5e5}
					.logistics-type .orange {color:#f60; border:1px solid #f60}
					.pay-type .btn {background:white; color:#999; border:1px solid #e5e5e5}
					.pay-type .orange {color:#f60; border:1px solid #f60}
					</style>
					<div class="control-group js-logistics-container" style="display: none;">
						<h3 class="present-sub-title js-logistics-type-list logistics-type">
							配送方式
							<?php 
							$is_show = false;
							if ($store['buyer_selffetch'] && !empty($selffetch_list)) {
								$is_show = true;
							?>
								<a href="javascript:;" data-type="selffetch" class="btn btn-small orange" style="padding:4px 7px;"><?php echo $store['buyer_selffetch_name'] ? $store['buyer_selffetch_name'] : '上门自提' ?></a>
							<?php 
							}
							if ($store['open_logistics']) {
							?>
								<a href="javascript:;" data-type="logistics" class="btn btn-small <?php echo $is_show ? '' : 'orange' ?>" style="padding:4px 7px;">物流配送</a>
							<?php 
								$is_show = true;
							}
							if ($store['open_friend'] && $store['open_logistics']) {
							?>
								<!--<a href="javascript:;" data-type="friend" class="btn btn-small <?php echo $is_show ? '' : 'orange' ?>" style="padding:4px 7px;">送朋友</a>-->
							<?php 
							}
							
							$is_show = false;
							?>
						</h3>
						<!-- 物流配送开始 -->
						<style>
						.js-address-table tr {cursor: pointer;}
						.js-selffetch_list tr {cursor: pointer;}
						.js-coupon-table tr {cursor: pointer;}
						.red {color:red;}
						</style>
						<div class="js-logistics-content-list">
							<!-- 到店自提开始 -->
							<div class="js-selffetch content-deteil <?php if ($store['buyer_selffetch'] && !$is_show) { $is_show = true; } else { echo 'hide'; } ?>">
								<div class="reward-table-wrap js-selffetch_list">
									<table class="reward-table">
										<?php 
										foreach ($selffetch_list as $key => $selffetch) {
										?>
											<tr class="js-selffetch_detail">
												<td class="center_tds" style="width:70%; padding-left:15px; height:30px;">
													<input type="radio" value="<?php echo $selffetch['pigcms_id'] ?>" <?php echo $key == 0 ? 'checked="checked"' : '' ?> />
													<?php echo htmlspecialchars($selffetch['name']) ?> <span style="color:gray;"><?php echo htmlspecialchars($selffetch['address']) ?></span>
												</td>
												<td style="width:20%">
													<?php echo $selffetch['tel'] ?>
												</td>
											</tr>
										<?php 
										}
										?>
									</table>
								</div>
								
								<div class="reward-table-wrap js-selffetch-info">
									<table class="reward-table">
										<tr>
											<td style="width:100px;"><span class="red">*</span>收件人:</td>
											<td><input type="text" class="txt js-name" style="width:200px;" /></td>
										</tr>
										<tr>
											<td><span class="red">*</span>联系电话:</td>
											<td><input type="text" class="txt js-tel" style="width:200px;" /></td>
										</tr>
										<tr>
											<td><span class="red">*</span>预约时间</td>
											<td>
												<input type="text" class="txt js-date" style="width:150px;" readonly="readonly" value="<?php echo date('Y-m-d H:i:00') ?>" min-date="<?php echo date('Y-m-d H:i:00') ?>" />
											</td>
										</tr>
									</table>
								</div>
							</div>
							<!-- 到店自提结束 -->
						
							<div class="js-logistics content-deteil <?php if ($store['open_logistics']) { $is_show = true; } else { echo 'hide'; } ?>" >
								<div class="reward-table-wrap">
									<table class="reward-table js-address-table">
										<tbody class="js-address_list">
										</tbody>
										<tr>
											<td class="center_tds" style="width:70%; padding-left:15px; height:30px;" colspan="4">
												<input type="radio" name="address_detail" value="0" />
												使用新地址
											</td>
										</tr>
									</table>
								</div>
								
								<div class="reward-table-wrap js-address-form" style="display:none;">
									<table class="reward-table">
										<tr>
											<td style="width:100px;"><span class="red">*</span>所在地:</td>
											<td>
												<select name="province" id="provinceId_m" data-province="">
													<option>省份</option>
												</select>
												<select name="city" id="cityId_m" data-city="">
													<option>城市</option>
												</select>
												<select name="area" id="areaId_m" data-area="">
													<option>区县</option>
												</select>
											</td>
										</tr>
										<tr>
											<td><span class="red">*</span>所在街道:</td>
											<td><input id="jiedao" class="txt js-jiedao" style="width: 400px;" placeholder="不需要重复填写省市区，必须大于1个字，小于120个字" maxlength="120" /></td>
										</tr>
										<tr>
											<td><span class="red">*</span>收件人:</td>
											<td><input type="text" class="txt js-name" style="width:200px;" /></td>
										</tr>
										<tr>
											<td><span class="red">*</span>联系电话:</td>
											<td><input type="text" class="txt js-tel" style="width:200px;" /></td>
										</tr>
										<tr>
											<td></td>
											<td>
												<input type="hidden" class="js-default" value="0" />
												<input type="hidden" class="js-address_id" value="0" />
												<a href="javascript:;" data-id="4" class="btn btn-small js-address_bnt" style="padding:4px 7px;">确定</a>
											</td>
										</tr>
									</table>
								</div>
							</div>
							<!-- 物流配送结束 -->
							
							<!-- 送朋友开始 -->
							<div class="js-friend content-deteil <?php if ($store['open_friend'] && !$is_show) { $is_show = true; } else { echo 'hide'; } ?>">
								<div class="reward-table-wrap js-friend-form" style="display:;">
									<table class="reward-table">
										<tr>
											<td style="width:100px;">朋友所在地:</td>
											<td type="false">
												<select name="province" id="provinceId_friend" data-province="">
													<option>省份</option>
												</select>
												<select name="city" id="cityId_friend" data-city="">
													<option>城市</option>
												</select>
												<select name="area" id="areaId_friend" data-area="">
													<option>区县</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>朋友所在街道:</td>
											<td><input id="jiedao" class="txt js-jiedao" style="width: 400px;" placeholder="不需要重复填写省市区，必须大于1个字，小于120个字" maxlength="120" /></td>
										</tr>
										<tr>
											<td>朋友姓名:</td>
											<td><input type="text" class="txt js-name" style="width:200px;" /></td>
										</tr>
										<tr>
											<td>朋友手机:</td>
											<td><input type="text" class="txt js-tel" style="width:200px;" /></td>
										</tr>
										<tr>
											<td>预约时间:</td>
											<td>
												<input type="text" class="txt js-friend_date" style="width:150px;" readonly="readonly" value="<?php echo date('Y-m-d H:i:00') ?>" min-date="<?php echo date('Y-m-d H:i:00') ?>" />
											</td>
										</tr>
									</table>
								</div>
							</div>
							<!-- 送朋友结束 -->
						</div>
					</div>
					
					<div class="control-group js-pay-container" style="display: none;">
						<h3 class="present-sub-title js-pay-type-list pay-type">
							支付方式
							<a href="javascript:;" data-type="cash" class="cash btn btn-small orange" style="padding:4px 7px;">现金支付</a>
							<?php 
							foreach ($pay_list as $pay) {
							?>
								<a href="javascript:;" data-type="<?php echo $pay['type'] ?>" class="<?php echo $pay['type'] ?> btn btn-small" style="padding:4px 7px;"><?php echo $pay['name'] ?></a>
							<?php 
							}
							?>
						</h3>
					</div>
					
					<!-- 优惠满减开始 -->
					<div class="control-group js-reward-container" style="display: none;">
						<h3 class="present-sub-title">
							满减
						</h3>
						<div class="content-deteil">
							<div class="reward-table-wrap">
								<table class="reward-table js-reward-table">
									<!-- 
									<tr>
										<td style="line-height: 24px; padding-left: 15px;">
											商品金额
										</td>
									</tr>
									 -->
								</table>
							</div>
						</div>
					</div>
					
					<div class="control-group js-coupon-container" style="display: none;">
						<h3 class="present-sub-title">
							优惠券
						</h3>
						<div class="content-deteil">
							<div class="reward-table-wrap">
								<table class="reward-table js-coupon-table">
									<!-- 
									<tr>
										<td style="line-height: 24px; padding-left: 15px;">
											<input type="radio" name="user_coupon_id" value="0" data-money="0" />不使用优惠券
										</td>
									</tr>
									 -->
								</table>
							</div>
						</div>
					</div>
					<!-- 优惠满减结束 -->
					
					<div class="control-group js-point-container"  data-point="0" data-point_money="0" style="display: none;">
						<h3 class="present-sub-title">
							积分抵扣
						</h3>
						<div class="content-deteil">
							<div class="reward-table-wrap">
								<table class="reward-table">
									<tr>
										<td style="line-height: 24px; padding-left: 15px;">
											<input type="radio" name="point" value="0" id="point_0" /><label for="point_0" style="display: inline;">不使用积分</label>
										</td>
									</tr>
									<tr>
										<td style="line-height: 24px; padding-left: 15px;">
											<input type="radio" name="point" value="1" checked="checked" id="point_1" /><label for="point_1" style="display: inline;"><span class="js-point_content">加载中</span></label>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
					
					<div class="control-group js-money-container" style="display: none;">
						<h3 class="present-sub-title">
							订单金额
						</h3>
						<div class="content-deteil">
							<div class="reward-table-wrap">
								<table class="reward-table">
									<tr>
										<td style="text-align: center; font-size:16px; line-height:24px;padding:10px 0px;">
											商品金额:￥<span id="js-sub_total">0.00</span> + ￥<span id="js-postage">0.00</span>运费
											- ￥<span id="js-reward">0.00</span>满减
											- ￥<span id="js-user_coupon">0.00</span>优惠券
											- ￥<span id="js-discount_money">0.00</span>元折扣
											<span style="display: none;">- 减免￥<span id="js-float_amount">0.00</span></span>
											- ￥<span id="js-point_money">0.00</span>元积分抵扣<br/>
											<strong class="js-real-pay orange">需付：￥<span id="js-total">0.00</span></strong>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</form>

			<div class="app-design js-submit-container" style="display: none;">
				<div class="app-actions">
					<div class="form-actions text-center">
						<input class="btn btn-primary js-btn-save" type="button" value="创建订单" data-loading-text="创建订单..." />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>