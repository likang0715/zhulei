<div>
	<div class="js-list-filter-region clearfix">
		<div>
			<?php include display('_search'); ?>
			<!-- ▼ Fourth Header -->
			<div id="fourth-header" class="fourth-header unselect">
				<div class="fourth-header-menu order-status-menu">
					<ul class="fourth-header-inner fourth-header-wrapper">
						<li><a href="javascript:;" class="all" data="*">全部</a></li>
						<li><a href="javascript:;" class="wait-paid status-1" data="1">待付款</a></li>
						<li><a href="javascript:;" class="wait-send status-2" data="2">待发货</a></li>
						<li><a href="javascript:;" class="shipped status-3" data="3">已发货</a></li>
						<li><a href="javascript:;" class="success status-4" data="4">已完成</a></li>
						<li><a href="javascript:;" class="success status-7" data="7">已收货</a></li>
						<li><a href="javascript:;" class="canceled status-5" data="5">已关闭</a></li>
						<li><a href="javascript:;" class="refunding status-6" data="6">退款中</a></li>
						<!-- <li><a href="javascript:" class="temp status-0" data="0">临时单</a></li> -->
					</ul>
				</div>
			</div>
			<!-- ▲ Fourth Header -->
			<div class="ui-nav2 ico_all_f" style="background-color: #f8f8f8;border:none">
				<ul style="display:inline-block;">
					<li><a href="javascript:;"  data="2*"><input class="print_all" type="checkbox"><span>全选</span></a></li>
					<!-- <li><a href="javascript:;" class="do_ico_all_print2 status-1" data="1"><span style="margin:-5px 0px" class="ico_all2 ico_all_print2"></span> 订单打印</a></li> -->
					<!-- <li class="print_style"><a href="javascript:;" class=" status-1" data="1"><span style="margin:-5px 0px" class="ico_all2  ico_all_print_style2"></span> 订单打印样式</a></li> -->
				</ul>
				
				<ul style="display:inline-block;float:right">
					<li>
						<span>
							<select id="select_checkout_type" style="margin-bottom: 0px;height: auto;line-height: normal;width: auto;font-size: 12px;font-family: Helvetica,STHeiti,'Microsoft YaHei',Verdana,Arial,Tahoma,sans-serif;">
								<option value="now">导出当前查询筛选出的订单</option>
								<option value="check">导出当前已勾选出的订单</option>
								<option value="all">导出全部订单</option>
								<option value="1">导出全部待付款订单</option>
								<option value="2">导出全部待发货订单</option>
								<option value="3">导出全部已完成订单</option>
								<option value="4">导出全部已发货订单</option>
								<option value="5">导出全部已关闭订单</option>
								<option value="6">导出全部退款中订单</option>
							</select>
							<a style="background:#006cc9;color:#fff;" href="javascript:;" class="checkout_orders status-1" data="1"> <span style="margin:-5px 0px" class="ico_all2 "></span> 导出订单</a>
						</span>
					</li>	
				</ul>	
			</div>

		</div>
	</div>
	<div class="ui-box orders">
		<?php include display('_list'); ?>
		<?php if (empty($orders)) { ?>
		<?php include display('_empty'); ?>
		<?php } ?>
	</div>
	<div class="js-list-footer-region ui-box"><div><div class="pagenavi"><?php echo $page; ?></div></div></div></div>