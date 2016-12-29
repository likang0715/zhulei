<div class="notice_sms">
	<div class="sms_help"></div>
	<div class="sms_con">
		<!-- ▼ App card -->
		<div id="app-card" class="app-card">
			<div class="app-card-inner">
				<h3>短信通知</h3>
				<div>
					<p>短信通知功能可以让您通过短信，给买家和店铺负责人推送交易和预订相关的提醒消息，包括商品订单通知、茶桌预订通知、茶会报名通知等，便于您及时处理用户的订单，以提升用户的消费体验，吸引更多的用户到店消费。</p>
				</div>
			</div>
		</div>
		<!-- ▲ App card -->
		<?php if($user['smscount']<100){?>
		<div id="app-tips" class="app-tips">
			<div class="app-tips-inner">
				温馨提示：您的短信仅剩<?php echo $user['smscount'];?> 条啦，赶快去充值吧！<a href="javascript:;" onclick="$('.js-recharge-layer').click()" style="color: #07d;">立即充值</a>
			</div>
		</div>
		<? }?>
		<!-- ▼ Fourth Header -->
		<div id="fourth-header" class="fourth-header unselect">
			<div class="fourth-header-menu sms-menu">
				<ul class="fourth-header-inner fourth-header-wrapper">
					<li class="active fourth-header-silde" data-main="overview"><a href="#notice_sms/0">短信概览</a></li>
					<li class="fourth-header-silde" data-main="recharge"><a href="#notice_sms/1">充值记录</a></li>
					<li class="fourth-header-silde" data-main="send"><a href="#notice_sms/2">发送记录</a></li>
				</ul>
			</div>
		</div>
		<!-- ▲ Fourth Header -->
		<div class="sms_main">
			<div class="sms_overview sms_page_item">
				<div class="overview_amin">
					<ul>
						<li class="overview_item">
							<h4 class="js-sms-balance"><a href="#notice_sms/1"><?php echo $user['smscount'];?></a></h4>
							<span>短信余额</span>
						</li>
						<li class="overview_item">
							<h4 class="js-today-send"><a href="#notice_sms/2&time=today"><?php echo $todaysms;?></a></h4>
							<span>今日发送</span>
						</li>
						<li class="overview_item">
							<h4 class="js-all-send"><a href="#notice_sms/2"><?php echo $smsnum;?></a></h4>
							<span>总发送量</span>
						</li>
						<li class="overview_item">
							<span class="js-recharge-layer">短信充值</span>
							<div class="recharge-layer-main hide">
								<div class="modal-body-main clearfix">
									<div class="pay-info">
										<dl class="clearfix">
											<dt>当前剩余：</dt>
											<dd><?php echo $user['smscount'];?>条</dd>
										</dl>
										<?php echo !empty($user_session['phone']) ? '<dl><dt>充值账号：</dt><dd>'.$user_session['phone'].'</dd></dl>' : ''; ?>
										<dl class="clearfix">
											<dt>充值金额：</dt>
											<dd>
												<ul class="choose-money clearfix">
													<li>
														<input type="radio" value="1" id="money-01" class="regular-radio" name="choose_money">
														<label for="money-01"><i class="sms_num">1000条</i><i class="sms_money">80元</i><i class="sms_price">(0.08元/条)</i></label>
													</li>
													<li>
														<input type="radio" value="2" id="money-02" class="regular-radio" name="choose_money" checked="checked">
														<label for="money-02"><i class="sms_num">6000条<span style="font-size:12px;">(推荐)</span></i><i class="sms_money">360元</i><i class="sms_price">(0.06元/条)</i></label>
													</li>
													<li>
														<input type="radio" value="3" id="money-03" class="regular-radio" name="choose_money">
														<label for="money-03"><i class="sms_num">10000条</i><i class="sms_money">500元</i><i class="sms_price">(0.05元/条)</i></label>
													</li>
												</ul>
											</dd>
										</dl>
										<dl>
											<dt>充值条数：</dt>
											<dd id="smsNum">6000条</dd>
										</dl>
										<dl>
											<dt>应付金额：</dt>
											<dd id="smsMoney"style="color: #D26838;font-weight: bold;">360元</dd>
										</dl>
										<dl>
											<dt>支付方式：</dt>
											<dd>微信扫码支付</dd>
										</dl>
										<dl>
											<dt></dt>
											<dd>
												<span class="read-agreement">
													阅读并同意<a href="#" target="_blank">《E点茶短信充值协议》</a>
												</span>
											</dd>
										</dl>
										<dl>
											<dt></dt>
											<dd>
												<a href="javascript:;" target="_blank" class="pay-submit js-sms-pay">充 值</a>
											</dd>
										</dl>
									</div>
								</div>
							</div>
							<div class="recharge-layer-pay hide">
								<div class="modal-body-main clearfix">
									<div class="pay-info">
										<dl>
											<dt>订单编号：</dt>
											<dd id="orderNo"></dd>
										</dl>
										<?php echo !empty($user_session['phone']) ? '<dl><dt>充值账号：</dt><dd>'.$user_session['phone'].'</dd></dl>' : ''; ?>
										<dl>
											<dt>充值条数：</dt>
											<dd id="orderNum"></dd>
										</dl>
										<dl>
											<dt>应付金额：</dt>
											<dd id="orderMoney"style="color: #D26838;font-weight: bold;"></dd>
										</dl>
										<dl>
											<dt>支付方式：</dt>
											<dd>微信扫码支付</dd>
										</dl>
										<dl>
											<dt>扫码支付：</dt>
											<dd>
												<span class="weixin-code" id="sms-pay-code">
												</span>
											</dd>
										</dl>
									</div>
								</div>
							</div>
						</li>
					</ul>
					<div class="sms_recharge_send clearfix">
						<div class="recharge-main">
							<div class="recharge-head">
								<h3 class="recharge-head-title">充值记录</h3>
							</div>
							<div class="recharge-table">
								<div class="recharge-table-container" style="">
									<table class="ui-table">
										<thead class="table-head">
											<tr>
												<th>充值时间</th>
												<th>充值金额</th>
												<th>充值条数</th>
												<th>充值状态</th>
											</tr>
										</thead>
										<tbody>
											<?php 
											if(count($sms_list) > 0) {
												foreach($sms_list as $sms){ ?>
												<tr data-id="<?php echo $sms['sms_order_id'];?>">
													<td class="time"><?php echo date("Y-m-d",$sms['dateline']);?></td>
													<td class="money"><?php echo $sms['money'];?></td>
													<td class="num"><?php echo $sms['sms_num'];?></td>
													<td><?php	if($sms['status'] == '0') {?>
														<?php if(time() - $sms['dateline']<86400){?>
														<a class="unpay js-order-pay" href="javascript:;" data-pay-no="<?php echo $sms['smspay_no'];?>" style="color:#07d;">去支付</a>
														<?php }else{?>
														已过期
														<?php }?>
														<?php } elseif($sms['status'] == '1') {?>
														<b style='font-weight: normal;'>已支付</b>
														<?php }?></td>
													</tr>

													<?php }
												} else {
													?>
													<tr>
														<td colspan="4">暂无充值记录</td>
													</tr>
													<?php }	?>

												</tbody>
											</table>
										</div>
										<div class="recharge-table-pagination ">
											<a href="#notice_sms/1" class="recharge_send_more">查看更多&gt;&gt;</a>
										</div>
									</div>
								</div>
								<div class="recharge-main">
									<div class="recharge-head">
										<h3 class="recharge-head-title">发送记录</h3>
									</div>
									<div class="recharge-table">
										<div class="recharge-table-container" style="">
											<table class="ui-table" style="table-layout:fixed;">
												<thead class="table-head">
													<tr>
														<th class="time">发送时间</th>
														<th class="text">发送内容</th>
														<th class="status">发送状态</th>
														<th class="mobile">手机号</th>
													</tr>
												</thead>
												<tbody>
													<?php 
													if(count($send_list) > 0) {
														foreach($send_list as $send){ ?>
														<tr>
															<td class="time"><?php echo date("Y-m-d",$send['time']);?></td>
															<td class="text"><div class="two-line" title="<?php echo $send['text'];?>"><?php echo $send['text'];?></div></td>

															<td class="status"><?php	if($send['status'] == '0') {?>
																发送成功
																<?php }else{?>
																发送失败
																<?php }?>
															</td>
															<td class="mobile"><?php echo $send['mobile'];?></td>
														</tr>

														<?php }
													} else {
														?>
														<tr>
															<td colspan="4">暂无充值记录</td>
														</tr>
														<?php }	?>

													</tbody>
												</table>
											</div>
											<div class="recharge-table-pagination ">
												<a href="#notice_sms/2" class="recharge_send_more">查看更多&gt;&gt;</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="sms_recharge sms_page_item hide" data-type="recharge">
							<div class="recharge-main">
								<div class="recharge-head">
									<h3 class="recharge-head-title">充值记录</h3>
								</div>

								<!-- ▼ App card -->
								<div id="app-card" class="app-card record-select">
									<form class="ui-box js-sms-form">
										<div class="clearfix">
											<div class="control-group time">
												<label class="control-label">充值时间：</label>
												<div class="controls">
													<input type="text" name="start_time" value="<?php echo $_GET['start'];?>" class="js-start-time js-start-time1" id="js-start-time" readonly>
													<span>至</span>
													<input type="text" name="end_time" value="<?php echo $_GET['end'];?>" class="js-end-time js-end-time1" id="js-end-time" readonly>
													<span class="date-quick-pick" data-days="3">最近3天</span>
													<span class="date-quick-pick" data-days="7">最近7天</span>
												</div>
											</div>
											<div class="control-group submit">
												<div class="controls">
													<a href="javascript:;" class="ui-btn ui-btn-primary js-filter-recharge">筛选</a>
												</div>
											</div>
										</div>
									</form>
								</div>
								<!-- ▲ App card -->
								<div class="recharge-table">
									<div class="recharge-table-container">
										<table class="ui-table">
											<thead class="table-head">
												<tr>
													<th>充值时间</th>
													<th>充值金额</th>
													<th>充值条数</th>
													<th>充值状态</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if(count($sms_list_page) > 0) {
													foreach($sms_list_page as $sms){ ?>
													<tr data-id="<?php echo $sms['sms_order_id'];?>">
														<td class="time"><?php echo date("Y-m-d H:i:s",$sms['dateline']);?></td>
														<td class="money"><?php echo $sms['money'];?></td>
														<td class="num"><?php echo $sms['sms_num'];?></td>
														<td><?php	if($sms['status'] == '0') {?>
															未支付
															<?php if(time() - $sms['dateline']<86400){?>
															（<a class="unpay js-order-pay" href="javascript:;" data-pay-no="<?php echo $sms['smspay_no'];?>" style="color:#07d;">去支付</a>）
															<?php }else{?>
															（已过期）
															<?php }?>
															<?php } elseif($sms['status'] == '1') {?>
															<b style='font-weight: normal;'>已支付</b>
															<?php }?></td>
														</tr>

														<?php }
													} else {
														?>
														<tr>
															<td colspan="4" style="text-align:center">暂无充值记录</td>
														</tr>
														<?php }	?>
													</tbody>
												</table>
											</div>
											<table align="center">
												<thead class="js-list-header-region tableFloatingHeaderOriginal">
													<tr>
														<td colspan="5">
															<div class="pagenavi js-page-list" id="recharge-pages">
																<?php echo $sms_pages;?>
															</div>
														</td>
													</tr>
												</thead>
											</table>
										</div>
									</div>
								</div>
								<div class="sms_send sms_page_item hide" data-type="send">
									<div class="send-main">
										<div class="recharge-head">
											<h3 class="recharge-head-title">发送记录</h3>
										</div>
										<!-- ▼ App card -->
										<div id="app-card" class="app-card record-select">
											<form class="ui-box js-sms-form">
												<div class="clearfix">
													<div class="control-group time">
														<label class="control-label">发送时间：</label>
														<div class="controls">
															<input type="text" name="start_time" value="<?php echo $_GET['start'];?>" class="js-start-time js-start-time2" readonly>
															<span>至</span>
															<input type="text" name="end_time" value="<?php echo $_GET['end'];?>" class="js-end-time js-end-time2" readonly>
															<span class="date-quick-pick" data-days="3">最近3天</span>
															<span class="date-quick-pick" data-days="7">最近7天</span>
														</div>
													</div>
													<div class="control-group submit">
														<div class="controls">
															<a href="javascript:;" class="ui-btn ui-btn-primary js-filter-send">筛选</a>
														</div>
													</div>
												</div>
											</form>
										</div>
										<!-- ▲ App card -->
										<div class="recharge-table">
											<div class="recharge-table-container" style="">
												<table class="ui-table">
													<thead class="table-head">
														<tr>
															<th class="time">发送时间</th>
															<th class="text">发送内容</th>
															<th class="status">发送状态</th>
															<th class="mobile">手机号</th>
														</tr>
													</thead>
													<tbody>
														<?php 
														if(count($send_list_page) > 0) {
															foreach($send_list_page as $send){ ?>
															<tr>
																<td class="time"><?php echo date("Y-m-d H:i:s",$send['time']);?></td>
																<td class="text"><div class="two-line" title="<?php echo $send['text'];?>"><?php echo $send['text'];?></div></td>

																<td class="status"><?php	if($send['status'] == '0') {?>
																	发送成功
																	<?php }else{?>
																	发送失败
																	<?php }?>
																</td>
																<td class="mobile"><?php echo $send['mobile'];?></td>
															</tr>

															<?php }
														} else {
															?>
															<tr>
																<td colspan="4" style="text-align:center">暂无充值记录</td>
															</tr>
															<?php }	?>
														</tbody>
													</table>
												</div>
												<table align="center">
													<thead class="js-list-header-region tableFloatingHeaderOriginal">
														<tr>
															<td colspan="5">
																<div class="pagenavi js-page-list" id="send-pages">
																	<?php echo $send_pages;?>
																</div>
															</td>
														</tr>
													</thead>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<script>
						store_recharge_layer = $(".recharge-layer-main").html();
						store_recharge_pay = $(".recharge-layer-pay").html();
						$(document).ready(function() {
							$(".recharge-layer-main").remove();
							$(".recharge-layer-pay").remove();
							$(".js-recharge-layer").click(function() {
								teaLayer(1,store_recharge_layer,"短信充值",function(){
									$(".recharge-layer-main").remove();
								})
							});
						});
						</script>