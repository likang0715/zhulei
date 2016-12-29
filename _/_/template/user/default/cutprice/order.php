<?php
$config_order_return_date = option('config.order_return_date');
$config_order_complete_date = option('config.order_complete_date');
$version = option('config.weidian_version');

if($order_list) {
?>
	<br />
	<table class="ui-table ui-table-list" style="padding:0px;" >
		<thead class="js-list-header-region tableFloatingHeaderOriginal">
			<tr>
				<th class="cell-15">订单信息</th>
				<th class="cell-15">购买数量</th>
				<th class="cell-15">买家/收货</th>
				<th class="cell-25">下单时间</th>
				<th class="cell-25">订单状态</th>
				<th class="cell-25">实付金额</th>
				<th class="cell-25">操作</th>
			</tr>
		</thead>
		<tbody class="js-list-body-region">
			<?php
			foreach($order_list as $order) {
			?>
				<tr>
					<td>
						订单号：<?php echo $order['order_no'] ?><br />
						交易号：<?php echo $order['trade_no'] ?>
						<?php 
						if ($order['third_id']) {
						?>
							<br />支付流水号：<?php echo $order['third_id'] ?>
						<?php 
						}
						?>
					</td>
					<td>
						<?php echo $order['pro_num'] ?>
					</td>
					<td>
						<?php echo $order['address_user'] ?><br />
						<?php echo $order['address_tel'] ?>
					</td>
					<td>
						<?php echo date('Y-m-d H:i:s', $order['add_time']) ?>
					</td>
					<td>
						<?php echo $status_arr[$order['status']] ?>
						<?php 
						if (empty($order['return_quantity']) && $order['status'] < 3) {
						?>
							<p>
								<a href="javascript:;" class="btn btn-small js-express-goods js-express-goods-<?php echo $order['order_id'] ?>" data-id="<?php echo $order['order_id'] ?>" data-type="send_other">发&nbsp;&nbsp;货</a>
							</p>
						<?php 
						} else if (empty($order['return_quantity']) && $order['status'] == 3 && $order['sent_time'] + $config_order_complete_date * 24 * 3600 >= time()) {
						?>
							<p>
								<a href="javascript:;" class="btn btn-small" style="background-color: #bbb;cursor: no-drop">等待收货</a>
							</p>
						<?php 
						}
						// 货到付款增加确认收款
						$codpay_status = true;
						if ($order['payment_method'] == 'codpay' && in_array($order['status'], array(3, 7)) && $order['receive_time'] == 0) {
							$codpay_status = false;
						?>
							<p>
								<a href="javascript:;" data-id="<?php echo $order['order_id']; ?>" class="btn btn-small js-receive-order">确认收款</a>
							</p>
						<?php
						}
						if ($codpay_status && empty($order['return_quantity']) && (($order['status'] == 7 && ($order['delivery_time'] + $config_order_return_date * 24 * 3600 < time() || $order['sent_time'] + $config_order_complete_date * 24 * 3600 < time())) || ($order['status'] == 3 && $order['sent_time'] + $config_order_complete_date * 24 * 3600 < time()))) {
						?>
							<p>
								<a href="javascript:;" data-id="<?php echo $order['order_id']; ?>" class="btn btn-small js-complate-order">交易完成</a>
							</p>
						<?php
						} else if ($codpay_status && ($order['status'] == 7 && ($order['delivery_time'] + $config_order_return_date * 24 * 3600 > time() || $order['sent_time'] + $config_order_complete_date * 24 * 3600 > time())) || ($order['status'] == 3 && $order['sent_time'] + $config_order_complete_date * 24 * 3600 > time())) {
						?>
							<p>
								<a href="javascript:;" class="btn btn-small js-complater" disabled="disabled">交易完成</a>
							</p>
						<?php
						}
						if ($order['status'] == 6) {
						?>
							<p>
								<a href="javascript:;" data-id="<?php echo $order['order_id']; ?>" class="btn btn-small js-complate-order">交易完成</a>
							</p>
						<?php
						}
						?>
					</td>
					<td>
						<?php echo $order['total'] ?><br />
						<span class="c-gray">(含运费: <?php echo $order['postage'] ?>)</span>
						<?php 
						if ($order['data_money'] > 0) {
						?>
							<br /><span style="color: green; font-weight: bold;">(<?php echo $order['status'] == '4' ? '已退' : '需退' ?>：<?php echo $order['data_money'] ?>)</span>
						<?php 
						}
						?>
					</td>
					<td>
						<a href="<?php echo url('order:detail', array('id' => $order['order_id'])) ?>" target="_blank">查看详情</a>
					</td>
				</tr>
			<?php
			}
			if ($pages) {
			?>
				<thead class="js-list-header-region tableFloatingHeaderOriginal">
					<tr>
						<td colspan="9">
							<div class="pagenavi js-order_list_page" data-team_id="<?php echo $team_id ?>">
								<span class="total"><?php echo $pages ?></span>
							</div>
						</td>
					</tr>
				</thead>
			<?php
			}
			?>
		</tbody>
	</table>
<?php
}else{
?>
	<br />
	<div class="js-list-empty-region">
		<div>
			<div class="no-result widget-list-empty">还没有相关订单数据。</div>
		</div>
	</div>
<?php
}
?>
