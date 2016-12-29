<script type="text/javascript">
// 分页
function changePage(page_type, status, p) {

    if (p.length == 0) {
        return;
    }

    var re = /^[0-9]*[1-9][0-9]*$/;
    if (!re.test(p)) {
        alert("请填写正确的页数");
        return;
    }

    load_page('.unitary_con', load_url, {'page':page_type, 'status':status, 'p':p }, '', function(){});
}

$(function () {

    var select_tab = $(".js-tab-list .tab-act");

    if (select_tab.data('status') == 'order') {
        var page_content = 'unitary_order';
        var status = '';
    } else if (select_tab.data('status') == 'reveal' || select_tab.data('status') == 'ing' || select_tab.data('status') == 'end' || select_tab.data('status') == 'all') {
        var page_content = 'unitary_list';
        var status = select_tab.data('status');
    }

    $("#pages a").click(function(){
        var p = $(this).attr("data-page-num");
        // console.log(status);
        changePage(page_content , status, p);
    });

	
	// 确认收货
	$(".js-delivery").click(function () {
		var delivery_obj = $(this);
		if (delivery_obj.data("type") == "submit") {
			tusi("提交中，请稍等");
			return;
		}
		
		if (confirm('您确定已经收到货了？')) {
			delivery_obj.data("type", "submit");
			delivery_obj.html("确认收货中");
			var order_id = $(this).attr('data-id');
			$.getJSON("<?php echo url('account:delivery_order') ?>&order_id=" + order_id, function (data) {
				if (data.status == true) {
					delivery_obj.closest("ul").find(".js-status").html("<span>已收货</span>");
					delivery_obj.closest("p").remove();
					tusi(data.msg);
				} else {
					tusi(data.msg);
					delivery_obj.data("type", "default");
					delivery_obj.html("确认收货");
				}
			});
		}
	});

});	
</script>
<?php 
$config_order_return_date = option('config.order_return_date');
$config_order_complete_date = option('config.order_complete_date');
if ($order_list) {
?>
	<ul class="order_list_head clearfix">
		<li class="head_1">宝贝信息</li>
		<li class="head_2"> 单价(元) </li>
		<li class="head_3">数量</li>
		<li class="head_4">合计</li>
		<li class="head_5"> 交易状态 </li>
		<li class="head_6">操作</li>
	</ul>
	<?php
	foreach ($order_list as $order) {
	?>
		<div class="order_list">
			<div class="order_list_title">
				<span class="mr20">订单编号：<a href="###"><?php echo option('config.orderid_prefix') . $order['order_no'] ?></a></span>
				<span class="mr20">预订时间：<?php echo date('Y-m-d H:i:s', $order['add_time']) ?></span>
				<span>支付方式：<?php echo $order['payment_method'] == 'codpay' ? '货到付款' : ($order['payment_method'] == 'peerpay' ? '找人代付' : '在线支付') ?></span>
			</div>
			<ul class="order_list_list">
				<?php 
				foreach ($order['product_list'] as $key => $product) {
					$is_return = false;
					if ($order['status'] == '7') {
						if ($order['delivery_time'] + $config_order_return_date * 24 * 3600 >= time()) {
							$is_return = true;
						}
					} else if ($order['status'] == '3') {
						if ($order['send_time'] + $config_order_complete_date * 24 * 3600 >= time()) {
							$is_return = true;
						}
					} else if ($order['status'] == 2) {
						$is_return = true;
					}
				?>
					<li class="head_1">
						<dl>
							<dd>
								<div class="order_list_img">
									<a href="<?php echo url_rewrite('goods:index', array('id' => $product['product_id'])) ?>" target="_blank">
										<img src="<?php echo $product['image'] ?>" />
									</a>
								</div>
								<div class="order_list_txt">
									<a href="<?php echo url_rewrite('goods:index', array('id' => $product['product_id'])) ?>" target="_blank">
										<?php echo htmlspecialchars($product['name']) ?>
									</a>
									<?php 
									if ($product['is_present']) {
										echo '<span style="color:#f60;">赠品</span>';
									}
									?>
								</div>
							</dd>
						</dl>
					</li>
					<li class="head_2">
						<?php echo $product['pro_price'] ?>
					</li>
					<li class="head_3" style="width:50px;">
						<?php echo $product['pro_num'] ?>
					</li>
					<?php if($key) { ?>
						<div style="clear:both;"></div>
					<?php } ?>
					<?php
					if(!$key) {
					?>
						<li class="head_4">
						<?php 
						if (!empty($order['total'])) {
						?>
							¥<?php echo $order['total'] ?>
						<?php 
						} else {
						?>
							¥<?php echo $order['sub_total'] ?>
						<?php
						}
						?>
						</li>
						<li class="head_5 js-status">
							<span>
								<?php
								if ($order['status'] < 2) {
									echo '未支付';
								} else if ($order['status'] == 2) {
									if ($order['shipping_method'] == 'selffetch') {
										echo '到店自提';
									} else {
										echo '未发货';
									}
								} else if ($order['status'] == 3) {
									echo '已发货';
								} else if ($order['status'] == 4) {
									echo '已完成';
								} else if ($order['status'] == 5) {
									echo '已取消';
								} else if ($order['status'] == 6) {
									echo '退款中';
								} else if ($order['status'] == 7) {
									echo '已收货';
								}
								?>
							</span>
						</li>
						<li class="head_6">
							<?php 
							if ($order['status'] == 3) {
							?>
								<p><a href="javascript:" data-id="<?php echo option('config.orderid_prefix') . $order['order_no'] ?>" class="js-delivery" data-type="default">确认收货</a></p>
							<?php
							}
							?>
							<p><a target="_blank" href="<?php echo url('order:detail&order_id=' . option('config.orderid_prefix') . $order['order_no']) ?>">查看详情</a></p>
						</li>
						<div style="clear:both;"></div>
				<?php
					}
				}
				?>
			</ul>
		</div>
	<?php
	}
	if ($pages) {
	?>
		<style>
		.page_input {border: 1px solid #00bb88; width: 20px; height: 38px; float: left; margin-right: 5px; padding: 0 15px;}
		</style>
		<div class="page_list" id="pages">
			<dl>
				<?php echo $pages ?>
			</dl>
		</div>
<?php 
	}
} else {
?>
		<div style="line-height:30px; padding-top:30px; font-size:16px;">暂无订单</div>
	<?php 
	}

?>