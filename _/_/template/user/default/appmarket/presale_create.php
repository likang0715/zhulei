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
</style>

<nav class="ui-nav-table clearfix">
	<ul class="pull-left js-list-filter-region">
		<li id="js-list-nav-all" <?php echo $type == 'all' ? 'class="active"' : '' ?>>
			<a href="#all">所有预售</a>
		</li>
		<li id="js-list-nav-future" <?php echo $type == 'future' ? 'class="active"' : '' ?>>
			<a href="#future">未开始</a>
		</li>
		<li id="js-list-nav-on" <?php echo $type == 'on' ? 'class="active"' : '' ?>>
			<a href="#on">进行中</a>
		</li>
		<li id="js-list-nav-end" <?php echo $type == 'end' ? 'class="active"' : '' ?>>
			<a href="#end">已结束</a>
		</li>
	</ul>
</nav>
					
<nav class="ui-nav clearfix">
	<ul class="pull-left">
		<li id="js-list-nav-all" class="active">
			<a href="javascript:">添加预售</a>
		</li>
	</ul>
</nav>
<div class="app-design-wrap">
	<div class="page-presale clearfix">
		<div class="app-presale app-reward">
			<form class="form-horizontal" id="myformaaaaaaa">
				<div class="presale-info">
					<div class="js-basic-info-region">
					
 						<div class="control-group">
							<label class="control-label">
								<em class="required"> * </em>预售标题：
							</label>
							<div class="controls">
								<input type="text" name="name" value="" id="name" placeholder="请填写预售标题" validate="required:true" class="validate[required]" />
								<em class="error-message"></em>
							</div>
						</div> 
						
						<div class="control-group">
							<label class="control-label">
								<em class="required"> *</em>选择预售商品：
							</label>
							<div class="controls">
							<ul class="ico app-image-list js-ico-list">
								<li>  <a href="javascript:;" class="add-goods js-add-picture">+加图</a>  </li>
							</ul>
							
							</div>
						</div>
						
						
					<div class="yuanjia control-group" style="display:none">
							<label class="control-label">
								<em class="required"> * </em>商品原价：
							</label>
							<div class="controls">
								<div class="input-prepend">
									<span class="add-on">￥</span><input readonly="readonly" type="text" maxlength="10"  name="yuanjia" value="" class=" input-small input-0">
									<br/>
										（注意：上述商品原价为：商品不同规格间的最低售价，在生成该条预售信息时已保存，不受后期 商品价格修改而变更！）
								</div>
							</div>
					</div>


					<div class="quantity control-group" style="display:none">
							<label class="control-label">
								<em class="required"> * </em>商品原库存：
							</label>
							<div class="controls">
								<div class="input-prepend">
									<span class="add-on">￥</span><input readonly="readonly" type="text" maxlength="10"  name="quantity" value="<?php echo $presale['quantity'];?>" class=" input-small input-0">
									<br/>
									（注意：上述商品库存为：商品不同规格间的库存的总和，在生成该条预售信息时已保存，不受后期 商品库存修改而变更！）
								</div>
							</div>
					</div>	
					
					<div class="control-group">
							<label class="control-label">
								<em class="required"> * </em>定金：
							</label>
							<div class="controls">
								<div class="input-prepend">
									<span class="add-on">￥</span><input type="text" maxlength="10"  name="dingjin" value="" class="dingjin input-small input-0">
								</div>
							</div>
					</div>
					</div>
					
					<div class="control-group">
					
							<label class="control-label">预售特权：</label>
						
						<div class="reward-table-wrap">
							<table class="reward-table">
								<thead>
									<tr>
										<th width="100%" class="pl100">优惠方式</th>
										
									</tr>
								</thead>
								<!-- 默认的优惠条件，增加层级用 -->
								<tr class="js-default-reward-condition" style="">
									
									<td>
										<ul class="tequan">
											<li class="control-group reward-setting first-reward">
												<div class="controls">
													<label class="checkbox inline reward-label js-trigger-label">
														<input type="checkbox" class="checked-status js-cash" name="cash_required" />
														<span class="origin-status ">减现金</span>
														<span class="replace-status js-response-label ">
															减 <input type="text" name="cash" value="" class="span1 js-valid-input" /> 元
															<em class="error-message"></em>
														</span>
													</label>
												</div>
											</li>
	
											<li class="control-group reward-setting">
												<div class="controls">
													<label class="checkbox inline reward-label js-trigger-label">
														<input type="checkbox" class="checked-status" name="coupon_required" />
														<span class="origin-status ">送优惠</span>
														<span class="replace-status js-response-label ">
														
														
														
														
														送
															<select class="js-reward-coupon" name="coupon" style="">
																<?php 
																	if(is_array($coupon_list)) {
																	foreach ($coupon_list as $coupon) {
																?>
																	<option value="<?php echo $coupon['id'] ?>"><?php echo htmlspecialchars($coupon['name']) ?></option>
																<?php 
																	} }if (empty($coupon_list)) {
																?>
																	<option value="0">尚未创建赠送券</option>
																<?php
																	}
																?>
															</select>

															<a href="javascript:;" class="js-refresh-coupon">刷新</a>
															<span class="c-gray">|</span>
															<a href="<?php dourl('preferential:coupon') ?>#create" class="new-window" target="_blank">新建</a>
														</span>
													</label>
												</div>
											</li>

											<li class="control-group reward-setting last-reward">
												<div class="controls">
													<label class="checkbox inline reward-label js-trigger-label">
														<input type="checkbox" class="checked-status" name="present_required" />
														<span class="origin-status ">送赠品</span>
														<span class="replace-status js-present-label">
															送
															<select class="js-reward-present" name="present" style="">
																<?php 
																if(is_array($present_list)) {
																foreach ($present_list as $presale) {
																?>
																	<option value="<?php echo $presale['id'] ?>"><?php echo htmlspecialchars($presale['name']) ?></option>
																<?php 
																}}
																if (empty($present_list)) {
																?>
																	<option value="0">尚未创建赠品</option>
																<?php
																}
																?>
															</select>
															<a href="javascript:;" class="js-refresh-present">刷新</a>
															<span class="c-gray">|</span>
															<a href="<?php dourl('appmarket:present') ?>#create" class="new-window" target="_blank">新建</a>
														</span>
													</label>
												</div>
											</li>
										</ul>
									</td>
								</tr>
							
							</table>
						</div>
					</div>
					
					
					<div class="js-basic-info-region">
						<div class="control-group">
							<label class="control-label">
								<em class="required"> * </em>初始预售人数：
							</label>
							<div class="controls">
								<div class="input-append renshu">
										<input type="text" class="presale_person" id="presale_person" name="presale_person" value="" placeholder="请填写预售人数" style="width:85px;"><span class="add-on">人</span>
									</div>
								<em class="error-message"></em>
							</div>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label">
							<em class="required"> *</em>预售时间段：
						</label>
						<div class="controls">
							<input type="text" name="start_time" value="" class="js-start-time Wdate" id="js-start-time" readonly style="cursor:default; background-color:white" />
							<span>至 </span>
							<input type="text" name="end_time" value="" class="js-end-time Wdate" id="js-end-time" readonly style="cursor:default; background-color:white" />
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">
							<em class="required"> *</em>尾款支付截止时间：
						</label>
						<div class="controls">
							<input type="text" name="start_time" value="" class="js-pay-time Wdate" id="js-pay-time" readonly style="cursor:default; background-color:white" />
						</div>
					</div>

					<div class="js-basic-info-region">
						<div class="control-group">
							<label class="control-label">
								<em class="required">  </em>真实购买商品数量：
							</label>
							<div class="controls">
								<div class="input-append renshu">
									<input type="text" class="buy_count" id="buy_count" name="buy_count" value="<?php echo $presale['buy_count'] ? $presale['buy_count'] : 0;?>" disabled placeholder="真实购买商品数量：" style="width:85px;"><span class="add-on">个</span>
									<br/>
									<font color="#f00">（注意：只要支付定金成功，购买商品数即增加！）</font>
									<br/>
								</div>
							</div>
							<em class="error-message"></em>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label">
							<em class="required"> * </em>预售数量限制：
						</label>
						<div class="controls">
							<input type="text" name="presale_amount" value="" id="presale_amount" placeholder="请填写预售数量" validate="required:true" class="validate[required]" />
							<br/>
							（注意：预售数量是指最多允许被预订多少个商品。计算方式为：<font color="#f00">真实购买商品数量 <= 预售数量限制！</font>）
							<em class="error-message"></em>
						</div>
					</div>
						
		
					
					<div class="control-group">
						<label class="control-label">
							<em class="required"> * </em>预售说明：
						</label>
						<div class="controls">
							<textarea rows="5" cols="55" style="width:65%" name="shuoming" id="shuoming" class="shuoming"></textarea>
							<em class="error-message"></em>
						</div>
					</div>
					<!---------------------->
				</div>
			</form>

			<div class="app-design">
				<div class="app-actions">
					<div class="form-actions text-center">
						<input class="btn js-btn-quit" type="button" value="取 消" />
						<input class="btn btn-primary js-btn-save" type="button" value="保 存" data-loading-text="保 存..." />
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<script type="text/javascript">
$(function() {
	$('.js-help-notes').hover(function() {
		var content = $(this).next('.js-notes-cont').html();
		$('.popover-help-notes').remove();
		var html = '<div class="js-intro-popover popover popover-help-notes right" style="display: none; top: ' + ($(this).offset().top - 27) + 'px; left: ' + ($(this).offset().left + 16) + 'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content"><p>' + content + '</p> </div></div></div>';
		$('body').append(html);
		$('.popover-help-notes').show();
	},
	function() {
		t = setTimeout('hide()', 200);
	})
	$('.popover-help-notes').live('hover', function(event) {
		if (event.type == 'mouseenter') {
			clearTimeout(t);
		} else {
			clearTimeout(t);
			hide();
		}
	})
})
function hide() {
	$('.popover-help-notes').remove();
}
</script>