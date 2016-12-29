<?php include display( 'public:person_header');?>
<script>
$(function () {
	$("#pages a").click(function () {
		var page = $(this).attr("data-page-num");
		location.href = "<?php echo url('account:return_order') ?>&page=" + page;
	});

	$(".cancl_return").click(function () {
		if (confirm('真的要取消退货吗？')) {
			var id = $(this).attr('data-id');
			$.getJSON("<?php echo url('account:cancl_return') ?>&id=" + id, function (data) {
				showResponse(data);
			});
		}
	});
	
	// 确认收货
	$(".over_order").click(function () {
		if (confirm('您确定已经收到货了？')) {
			var order_id = $(this).attr('data-id');
			$.getJSON("<?php echo url('account:over_order') ?>&order_id=" + order_id, function (data) {
				showResponse(data);
			});
		}
	});

	$(".js-order_return").click(function () {
		var order_id = $(this).attr("data-id");
		var pigcms_id = $(this).data("pigcms_id");
		var url = "<?php echo url('order:return_apply') ?>&order_id=" + order_id + "&pigcms_id=" + pigcms_id;
		location.href = url;
	});
});	
</script>
<div class="menudiv">
	<div id="con_one_1" style="display: block;">
		<div class="danye_content_title">
			<div class="danye_suoyou"><a href="javascript:"><span>退货列表</span></a></div>
		</div>
		<?php 
		if ($return_list) {
		?>
			<ul class="order_list_head clearfix">
				<li class="head_1">退货产品</li>
				<li class="head_2">数量</li>
				<li class="head_4">退货类型</li>
				<li class="head_4">退货状态</li>
				<li class="head_5">退货时间 </li>
				<li class="head_6">操作</li>
			</ul>
			<?php 
			foreach ($return_list as $return) {
			?>
				<div class="order_list">
					<ul class="order_list_list">
						<li class="head_1">
							<dl>
								<dd>
									<div class="order_list_img"><img src="<?php echo $return['image'] ?>"></div>
									<div class="order_list_txt" style="text-align: left;">
										<a href="<?php echo url_rewrite('goods:index', array('id' => $return['product_id'])) ?>"><?php echo htmlspecialchars($return['name']) ?></a>
										<?php 
										if ($return['sku_data']) {
											echo '<br />';
											$sku_data = unserialize($return['sku_data']);
											foreach ($sku_data as $sku) {
												echo $sku['name'] . ':' . $sku['value'];
											}
										}
										?>
									</div>
								</dd>
							</dl>
						</li>
						<li class="head_2">
							<?php echo $return['pro_num'] ?>
						</li>
						<li class="head_4">
							<?php echo $return['type_txt'] ?>
						</li>
						<li class="head_4">
							<?php echo $return['status_txt'] ?>
						</li>
						<li class="head_5">
							<?php echo date('Y-m-d H:i', $return['dateline']) ?>
						</li>
						<li class="head_6">
							<?php 
							if ($return['status'] < 4) {
							?>
								<p><a href="javascript:" data-id="<?php echo $return['id'] ?>" class="cancl_return">取消退货</a></p>
							<?php
							}
							?>
							<p><a target="_blank" href="<?php echo url('account:return_detail&id=' . $return['id']) ?>">查看详情</a></p>
							
						</li>
						<div style="clear:both;"></div>
					</ul>
				</div>
			<?php
			}if ($pages) {
			?>
				<style>
				.page_list dl a {float:;}
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
			<div style="line-height:30px; padding-top:30px; font-size:16px;">暂无退货</div>
		<?php 
		}
		?>
	</div>
	<div id="con_one_2" style="display: none;">
		<section class="server">
			<div class="section_title">
				<div class="section_txt">商家动态</div>
				<div class="section_border"> </div>
				<div style="clear:both"></div>
			</div>
		</section>
	</div>
	<div id="con_one_3" style="display: none;">
		<section class="server">
			<div class="section_title">
				<div class="section_txt">市场活动</div>
				<div class="section_border"> </div>
				<div style="clear:both"></div>
			</div>
		</section>
	</div>
	
	<div id="con_one_5" style="display: none;">
		<section class="server">
			<div class="section_title">
				<div class="section_txt">公司新闻</div>
				<div class="section_border"> </div>
				<div style="clear:both"></div>
			</div>
		</section>
	</div>
</div>
			
<?php include display( 'public:person_footer');?>
				