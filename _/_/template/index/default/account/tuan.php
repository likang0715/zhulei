<?php include display( 'public:person_header');?>
<style type="text/css">
.qiehuan span a { display: block; width: 100px; }
.shiyong_on span a { color: #fff }

</style>
<script>
var tuan_qrcode_url = "/source/qrcode.php?type=";
$(function () {
	$("#pages a").click(function () {
		var page = $(this).attr("data-page-num");
		<?php 
		$param = array();
		if ($type) {
			$param['type'] = $type;
		}
		?>
		var url = "<?php echo url("account:tuan", $param) ?>&page=" + page;
		location.href = url;
	});
	
	$(function(){
		$('.youhui_select').change(function(){
			var coupon_type=$('option:selected ').val();
			if(coupon_type==-1){
				location.href='<?php echo url('account:coupon', array('type'=>$type)); ?>';
			}else if(coupon_type==0){
				location.href='<?php echo url('account:coupon', array('type'=>$type,'coupon_type'=>'1')); ?>';
			}else if(coupon_type==1){
				location.href='<?php echo url('account:coupon', array('type'=>$type,'coupon_type'=>'2')); ?>';
			}
		});
	});

	$(".js_show_ewm").click(function(event) {
		event.stopPropagation();
		var dom = $(this);
		var dom_offset = dom.offset();
		
		var id = dom.data("id");
		var qrcode_url = tuan_qrcode_url + "tuan&id=" + id;
		var htmls = "";
			htmls += '<div class="popover bottom" style="position: absolute;">';
			htmls += '	<div class="arrow"></div>';
			htmls += '	<div style="width:120px;" class="popover-inner">';
			htmls += '		<div class="popover-content">';
			htmls += '			<div class="form-inline">';
			htmls += '				<div class="input-append"><img width="100" height="100" src="' + qrcode_url + '"></div>';
			htmls += '			</div>';
			htmls += '		</div>';
			htmls += '	</div>';
			htmls += '</div>';
		$('body').append(htmls);
		
		var popover_height = $('.popover').height();
		var popover_width = $('.popover').width();
		
		$('.popover').css({top: dom_offset.top+dom.height()-3, left: dom_offset.left - (popover_width/2) + (dom.width()/2)});
		
		$('.popover').click(function(e) {
			e.stopPropagation();
		});
		
		$('body').bind('click',function() {
			$(".popover").remove();
		});
	});
});
</script>

<div id="con_one_7"> 
	<div class="danye_content_title">
		<div class="danye_suoyou shiyong1"><a href="###"><span>我的拼团</span></a></div>
	</div>
	<div class="danye_youhi">
		<div class="youuhiquan_qiehuan clearfix">
			<div class="shiyong1 qiehuan <?php if(!in_array($type, array(1, 2, 3))) { ?> shiyong_on<?php }?>" onClick="location.href='<?php echo url('account:tuan'); ?>'"> <span><a  href="javascript:void(0)" >全部</a></span> </div>
			<div class="shiyong2 qiehuan <?php if($type == '1'){ ?> shiyong_on<?php }?>" onClick="location.href='<?php echo url('account:tuan', array('type'=>'1')); ?>'"> <span><a  href="javascript:void(0)" >拼团中</a></span> </div>
			<div class="shiyong3 qiehuan <?php if($type == '2'){ ?> shiyong_on<?php }?>" onClick="location.href='<?php echo url('account:tuan', array('type'=>'2')) ?>'"><span><a  href="javascript:void(0)" >拼团失败</a></span> </div>
			<div class="shiyong3 qiehuan <?php if($type == '3'){ ?> shiyong_on<?php }?>" onClick="location.href='<?php echo url('account:tuan', array('type'=>'3')) ?>'"><span><a  href="javascript:void(0)" >拼团成功</a></span> </div>
		</div>
		<div class="yuuhuiquan">
			<div class="youhuiquan_list youhui1" style="display:block;">
				<?php 
				if ($order_list) {
				?>
					<ul class="order_list_head clearfix">
						<li class="head_1">宝贝信息</li>
						<li class="head_2">数量</li>
						<li class="head_4">总价</li>
						<li class="head_4">订单状态</li>
						<li class="head_5">类型 </li>
						<li class="head_6">操作</li>
					</ul>
					<?php
					foreach ($order_list as $order) {
					?>
						<div class="order_list">
							<div class="order_list_title">
								<span class="mr20">订单编号：<a href="###"><?php echo option('config.orderid_prefix') . $order['order_no'] ?></a></span>
								<span class="mr20">支付时间：<?php echo date('Y-m-d H:i:s', $order['paid_time']) ?></span>
								<span>支付方式：<?php echo $order['payment_method'] == 'codpay' ? '货到付款' : ($order['payment_method'] == 'peerpay' ? '找人代付' : '在线支付') ?></span>
							</div>
							<ul class="order_list_list">
									<li class="head_1">
										<dl>
											<dd>
												<div class="order_list_img">
													<a href="<?php echo url_rewrite('goods:index', array('id' => $order['product_id'])) ?>" target="_blank">
														<img src="<?php echo $order['image'] ?>" />
													</a>
												</div>
												<div class="order_list_txt">
													<a href="<?php echo url_rewrite('goods:index', array('id' => $order['product_id'])) ?>" target="_blank">
														<?php echo htmlspecialchars($order['name']) ?>
													</a>
												</div>
											</dd>
										</dl>
									</li>
									<li class="head_2">
										<?php echo $order['pro_num'] ?>
									</li>
									<li class="head_3" style="width:50px;">
										<?php echo $order['total'] ?>
									</li>
									<li class="head_4">
										<span>
											<?php
											if ($order['o_status'] < 2) {
												echo '未支付';
											} else if ($order['o_status'] == 2) {
												echo '未发货';
											} else if ($order['o_status'] == 3) {
												echo '已发货';
											} else if ($order['o_status'] == 4) {
												echo '已完成';
											} else if ($order['o_status'] == 5) {
												echo '已取消';
											} else if ($order['o_status'] == 6) {
												echo '退款中';
											} else if ($order['o_status'] == 7) {
												echo '已收货';
											}
											?>
										</span>
									</li>
									<li class="head_5 js-status">
										<?php 
										if ($order['type'] == 1) {
											echo '最优开团';
										} else {
											echo '人缘开团';
										}
										if ($order['is_leader']) {
											echo '<br /><span>团长</span>';
										}
										?>
									</li>
									<li class="head_6">
										<a href="<?php echo url('order:detail', array('order_id' => $order['order_no'])); ?>">订单详情</a><br />
										<a href="javascript:void(0);" class="js_show_ewm" data-id="<?php echo $order['tuan_id']; ?>">手机预览</a>
									</li>
									<div style="clear:both;"></div>
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
				
			</div>
		</div>
	</div>
</div>
<?php include display( 'public:person_footer');?>