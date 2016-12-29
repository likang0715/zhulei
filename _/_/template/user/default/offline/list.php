<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<style type="text/css">
	.page-margin .header {
		font-size: 14px;
		color: #333;
		background: #f8f8f8;
		height: 40px;
		line-height: 40px;
		padding-left: 12px;
		border-bottom: 1px solid #e5e5e5;
	}
	.service-fee {
		color: gray;
		font-weight: normal;
		font-style: italic;
	}
</style>
<div>
	<div class="page-margin">
		<div class="ui-box">
			<div class="header">线下做单列表</div>

			<div class="widget-list-filter clearfix">
				<form class="form-horizontal list-filter-form" onsubmit="return false;">
					<div class="control-group">
						<label class="control-label">时间：</label>
						<div class="controls">
							<input type="text" name="stime" class="js-stime" id="js-stime">
							<span>至</span>
							<input type="text" name="etime" class="js-etime" id="js-etime">
							<span class="date-quick-pick" data-days="7">最近7天</span>
							<span class="date-quick-pick" data-days="30">最近30天</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">单号：</label>
						<div class="controls">
							<input type="text" name="order_no" class="span4" style="width: 283px;" placeholder="订单号" />
							<span style="margin-left: 18px;">审核状态：</span>
							<select name="type" class="js-check_status">
								<option value="*">全部</option>
								<option value="-1">未审核</option>
								<option value="1">审核通过</option>
								<option value="2">审核未通过</option>
							</select>&nbsp;&nbsp;&nbsp;
							<button class="ui-btn ui-btn-primary js-filter" style="margin-left: 0;height: auto" data-loading-text="正在筛选...">筛选</button>
						</div>
					</div>
				</form>
			</div>
			<?php 
			if (!empty($order_offline_list)) {
			?>
				<table class="ui-table ui-table-list" style="padding: 0px;margin-top:15px">
					<thead class="js-list-header-region tableFloatingHeaderOriginal">
						<tr class="widget-list-header">
							<th class="cell-15">订单号 | 商品</th>
							<th class="cell-10 text-center">会员用户</th>
							<th class="cell-10 text-right">订单金额</th>
							<th class="cell-10 text-center">服务费</th>
							<th class="cell-10 text-center">平台保证金</th>
							<th class="cell-10">
								<span style="color: green;">商家可用<?php echo option('credit.platform_credit_name') ?></span> / <br />
								<span style="color: red;">商家<?php echo option('credit.platform_credit_name') ?></span>
							</th>
							<th class="cell-10 text-center">添加时间</th>
							<th class="cell-10 text-right">送<?php echo option('credit.platform_credit_name') ?></th>
							<th class="cell-10 text-right">审核状态</th>
							<th class="cell-25 text-right">备注</th>
							<th class="cell-25 text-right">操作</th>
						</tr>
					</thead>
					<tbody class="js-list-body-region">
						<?php 
						foreach ($order_offline_list as $order_offline) {
						?>
							<tr class="widget-list-item">
								<td>
									<?php echo $order_offline['order_no'] ?><br />
									<?php echo htmlspecialchars($order_offline['product_name']) ?>
								</td>
								<td><?php echo $offline_users[$order_offline['uid']] ?></td>
								<td><?php echo $order_offline['total'] ?></td>
								<td><?php echo $order_offline['service_fee'] ?></td>
								<td><?php echo $order_offline['cash'] ?></td>
								<td>
									<span style="color: green;"><?php echo $order_offline['store_user_point'] ?></span> / <br /> 
									<span style="color: red;"><?php echo $order_offline['store_point'] ?></span>
								</td>
								<td><?php echo date('Y-m-d H:i', $order_offline['dateline']) ?></td>
								<td>
									<?php echo $order_offline['return_point'] ?><br />
									<?php 
									if ($order_offline['status'] == 1) {
										echo '<span style="color: green;">已发放</span>';
									} else {
										echo '<span style="color: red;">未发放</span>';
									}
									?>
								</td>
								<td>
									<?php 
									if ($order_offline['check_status'] == 1) {
										echo '<span style="color: green;">审核通过</span>';
									} else if ($order_offline['check_status'] == 2) {
										echo '<span style="color: red;">审核不通过</span>';
									} else {
										echo '未审核';
									}
									?>
								</td>
								<td><?php echo htmlspecialchars($order_offline['bak']) ?></td>
								<td>
									<?php 
									if ($order_offline['check_status'] == 1 && $order_offline['status'] == 0) {
									?>
										<a href="javascript:" data-order_id="<?php echo $order_offline['id'] ?>" class="js-complete">交易完成</a>
									<?php 
									} else {
										echo '-';
									}
									?>
								</td>
							</tr>
						<?php 
						}
						?>
					</tbody>
				</table>
				<div class="js-list-footer-region ui-box">
					<div class="widget-list-footer js-page" data-start_time="<?php echo $start_time ?>" data-end_time="<?php echo $end_time ?>" data-order_no="<?php echo htmlspecialchars($order_no) ?>" data-check_status="<?php echo $check_status ?>">
						<div class="pagenavi"><?php echo $page; ?></div>
					</div>
				</div>
			<?php 
			} else {
			?>
				<div class="js-list-empty-region">
					<div>
						<div class="no-result widget-list-empty">还没有相关数据。</div>
					</div>
				</div>
			<?php 
			}
			?>
		</div>
	</div>
</div>