<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>收银台对账</title>
	<meta name="copyright" content="<?php echo $config['site_url']; ?>"/>
	<script type="text/javascript" src="./static/js/jquery.min.js"></script>
	<script type="text/javascript" src="./js/base.js"></script>
	<script type="text/javascript" src="./js/meaz.js"></script>
	<script type="text/javascript">var load_url="<?php  dourl('weixin:cashier_list',array('physical_id'=>$_GET['physical_id'],'action'=>$_GET['action']));?>";</script>
	<link href="<?php echo TPL_URL;?>css/cashier_list.css" type="text/css" rel="stylesheet">
	<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet">
</head>
<body class="font14 usercenter">
	<?php include display('public:first_sidebar');?>
	<?php include display('sidebar');?>
	<!-- ▼ Container-->
	<div id="container" class="clearfix container right-sidebar">
		<div id="container-left">
			<!-- ▼ Third Header -->
			<div id="third-header">
				<ul class="third-header-inner">
					<li <?php if($select_sidebar == 'cashier'){ ?>class="active"<?php } ?>>
						<a href="<?php dourl('cashier')?>" data-is="3">二维码列表</a>
					</li>
					<li <?php if($select_sidebar == 'cashier_list'){ ?>class="active"<?php } ?>>
						<a href="<?php dourl('cashier_list') ?>" data-is="1">收银台对账</a>
					</li>
				</ul>
			</div>
			<!-- ▲ Third Header -->
			<!-- ▼ Container App -->
			<div class="container-app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="nav-wrapper--app">
							<div class="app__content cashier_list">
								<!-- 内容头部 -->
								<div class="cashier_list_main">
									<div class="col-xs-12">
										<table class="cashier_list_main_table">
											<thead>
												<tr>
													<th>订单号</th>
													<th>收款门店</th>
													<th>收款金额</th>
													<th>支付金额</th>
													<th>支付时间</th>
													<th>下单时间</th>
													<th>订单状态</th>
												</tr>
											</thead>
											<tbody>

												<?php if(!empty($order_list)){ ?>
												<?php foreach($order_list as $value){ ?>
												<tr class="cashier_list_main_table_tr">
													<td><?php echo $value['pay_no'];?></td>
													<td><?php echo $value['physical_name'];?></td>
													<td><?php echo $value['price'];?></td>
													<td><?php echo $value['money'];?></td>
													<td><?php if($value['pay_dateline']>0) { echo date('m-d H:i:s', $value['pay_dateline']); }  ?></td>
													<td><?php echo date('m-d H:i:s', $value['dateline']); ?></td>
													<td><?php echo $value['status'];?></td>

												</tr>
												<?php } ?>
												<?php }else{ ?>
												<tr class="odd"><td class="button-column" colspan="11" >暂时没有订单...</td></tr>
											</tbody>
										</table>
										<?php } ?>

										<?php

										if ($pages) {
											?>
											<table align="center">
												<thead class="js-list-header-region tableFloatingHeaderOriginal">
													<tr>
														<td colspan="5">
															<div class="pagenavi js-present_list_page" id="pages">
																<span class="total"><?php echo $pages ?></span>

															</div>
														</td>
													</tr>
												</thead>
											</table>
											<?php
										}
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>