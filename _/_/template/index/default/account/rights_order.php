<?php include display( 'public:person_header');?>
<script>
$(function () {
	$("#pages a").click(function () {
		var page = $(this).attr("data-page-num");
		location.href = "<?php echo url('account:rights_order') ?>&page=" + page;
	});

	$(".cancl_rights").click(function () {
		if (confirm('真的要取消维权吗？')) {
			var id = $(this).attr('data-id');
			$.getJSON("<?php echo url('account:cancl_rights') ?>&id=" + id, function (data) {
				showResponse(data);
			});
		}
	});
});	
</script>
<div class="menudiv">
	<div id="con_one_1" style="display: block;">
		<div class="danye_content_title">
			<div class="danye_suoyou"><a href="javascript:"><span>维权列表</span></a></div>
		</div>
		<?php 
		if ($rights_list) {
		?>
			<ul class="order_list_head clearfix">
				<li class="head_1">维权产品</li>
				<li class="head_2">维权数量</li>
				<li class="head_4">维权类型</li>
				<li class="head_4">维权状态</li>
				<li class="head_5">维权时间 </li>
				<li class="head_6">操作</li>
			</ul>
		<?php 
			foreach ($rights_list as $rights) {
		?>
				<div class="order_list">
					<ul class="order_list_list">
						<li class="head_1">
							<dl>
								<dd>
									<div class="order_list_img"><img src="<?php echo $rights['image'] ?>"></div>
									<div class="order_list_txt" style="text-align: left;">
										<a href="<?php echo url_rewrite('goods:index', array('id' => $rights['product_id'])) ?>"><?php echo htmlspecialchars($rights['name']) ?></a>
										<?php 
										if ($rights['sku_data']) {
											echo '<br />';
											$sku_data = unserialize($rights['sku_data']);
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
							<?php echo $rights['pro_num'] ?>
						</li>
						<li class="head_4">
							<?php echo $rights['type_txt'] ?>
						</li>
						<li class="head_4">
							<?php echo $rights['status_txt'] ?>
						</li>
						<li class="head_5">
							<?php echo date('Y-m-d H:i', $rights['dateline']) ?>
						</li>
						<li class="head_6">
							<?php 
							if ($rights['status'] < 3) {
							?>
								<p><a href="javascript:" data-id="<?php echo $rights['id'] ?>" class="cancl_rights">取消退货</a></p>
							<?php
							}
							?>
							<p><a target="_blank" href="<?php echo url('account:rights_detail&id=' . $rights['id']) ?>">查看详情</a></p>
							
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
			<div style="line-height:30px; padding-top:30px; font-size:16px;">暂无维权</div>
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
				