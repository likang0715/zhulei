<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8"/> 
	<title>预约管理</title>
	<meta name="copyright" content="<?php echo $config['site_url']; ?>"/>
	<script type="text/javascript" src="./static/js/jquery.min.js"></script>
	<script type="text/javascript" src="./js/base.js"></script>
	<script type="text/javascript" src="./js/meaz.js"></script>
	<script type="text/javascript">var load_url="<?php  dourl('meal:order',array('physical_id'=>$_GET['physical_id'],'action'=>$_GET['action']));?>";</script>
	<link rel="stylesheet" href="./skin/css/global.css">
	<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/		
</head>
<body class="font14 usercenter">
	<?php include display('public:header');?>
	<div class="wrap_1000 clearfix container">
		<?php include display('sidebar');?>
		<div class="meal_con">
			<!-- 内容头部 -->

			<div class="ui-nav">
				<ul>
					<li><a >待发货</a></li>
					<li><a href="">带退款</a></li>
					<li><a href="">待审核订座</a></li>
					<li><a href="">待审核茶会</a></li>
				</ul>
			</div>
			<div class="meal_con_main">
				<div class="col-xs-12">
					
					
					<table class="meal_con_main_table">
						<thead>
							<tr>
								<th>订单号</th>
								<th>订单编号</th>
								<th>订单金额</th>
								<th>收件人姓名</th>
								<th>电话</th>
								<th>下单时间</th>
								<th>订单状态</th>
								<th>操作</th>
								
							</tr>
						</thead>
						<tbody>
							
							<?php if(!empty($send)){ ?>
							<?php foreach($send as $value){ ?>
							<tr class="meal_con_main_table_tr">
								<td><?php echo $value['order_id'];?></td>
								<td><?php echo $value['order_no'];?></td>
								<td><?php echo $value['total'];?></td>
								<td><?php echo $value['address_user'];?></td>
								<td><?php echo $value['address_tel'];?></td>
								<td><?php echo date('m-d H:i:s', $value['add_time']); ?></td>
								<td><?php echo $value['status'];?></td>
								<td>  
									<?php if ($order['shipping_method'] == 'selffetch') {?>
									<a href="javascript:;" data-id="<?php echo $order['order_id']; ?>"
										class="btn btn-small js-selffetch-order" style="padding:4px 7px;">
										已<?php echo $_SESSION['store']['buyer_selffetch_name'] ? $_SESSION['store']['buyer_selffetch_name'] : '自提' ?>
									</a>
									<?php 
								} else {
									
									?>
									<a href="javascript:;"
									class="btn btn-small js-express-goods js-express-goods-<?php echo $order['order_id']; ?>"
									data-id="<?php echo $order['order_id']; ?>"
									data-type="send_other">发&nbsp;&nbsp;货</a></td>
									<?php } ?>		   
									
								</tr>
								<?php foreach($value['goods'] as $product){ ?>	
								<tr class="meal_con_main_table_tr">
									<td><img src="<?php echo $product['image']; ?>"/></td>
									<td><?php echo $product['name']; ?></td>
									<td> <p><?php echo $product['pro_price']; ?></p>

										<p>(<?php echo $product['pro_num']; ?>件)</p>
										<?php if (!in_array($order['status'], array(0, 1, 5))) { ?>
										<?php if (!empty($order['is_fx']) || !empty($order['fx_order_id']) || !empty($order['user_order_id'])) { ?>
										<?php if (!empty($product['supplier_id']) || ($product['store_id'] != $_SESSION['store']['store_id'])) { ?>
										<p class="cost-price">成本价：<?php echo $product['cost_price']; ?></p>
										<?php } ?>
										<p class="profit <?php if ($product['return_status'] == 2) { ?>del-line<?php } ?>">
											利润：<?php echo $product['profit']; ?></p>
											<?php if (!empty($product['sale_price'])) { ?>
											<p class="sale-price">零售价：<?php echo $product['sale_price']; ?></p>
											<?php } ?>
											<?php } ?>
											<?php } ?></td>
											
											
										</tr>
										
										<?php } ?>	
										<?php } ?>
										<?php }else{ ?>
										<tr class="odd"><td class="button-column" colspan="11" >暂时没有订单...</td></tr>
										
										
										<?php } ?>
										
									</tbody>
								</table>
								
								
								
								
								
								
								<table class="ui-table ui-table-list" style="padding: 0px;">
									<thead class="js-list-header-region tableFloatingHeaderOriginal" style="position: static; top: 0px; margin-top: 0px; left: 601.5px; z-index: 1; width: 850px;">
										<?php
										if (!empty($return_list)) {
											?>
											<tr>
												<th class="checkbox cell-35" colspan="2" style="min-width: 200px; max-width: 200px;">
													产品信息
												</th>
												<th class="cell-8 text-center" style="min-width: 68px; max-width: 68px;">
													退货类型
												</th>					
												<th class="cell-10 text-center" style="min-width: 112px; max-width: 112px;">
													退货状态
												</th>
												<th class="cell-8 text-center" style="min-width: 95px; max-width: 200px;">
													退货数量
												</th>
												<th class="cell-12 text-center" style="min-width: 150px; max-width: 95px;">
													退货时间
												</th>
												<th class="cell-12 text-center" style="min-width: 95px; max-width: 95px;">
													买家
												</th>
												<th class="cell-15 text-center" style="min-width: 95px; max-width: 95px;">操作</th>
											</tr>
											<?php
										}
										?>
									</thead>
									<tbody class="js-list-body-region">
										<?php 
										if(is_array($return_list)) {
											foreach ($return_list as $return) {
												?>
												<tr>
													<td width="70">
														<img src="<?php echo $return['image'] ?>" style="width:60px; height:60px;"/>
													</td>					
													<td class="goods-meta">
														<p class="goods-title">
															<?php echo htmlspecialchars($return['name']) ?>
															<?php 
															if ($return['sku_data']) {
																$sku_data = unserialize($return['sku_data']);
																foreach ($sku_data as $tmp) {
																	echo '<br />' . $tmp['name'] . ':' . $tmp['value'];
																}
															}
															if ($return['is_fx'] == 2) {
																?>
																<span class="platform-tag" style="background-color:#07d;">批发</span>
																<?php
															} else if ($return['is_fx'] == 1) {
																?>
																<span class="platform-tag">分销</span>
																<?php
															}
															?>
														</p>
														
													</td>
													<td>
														<?php echo $return['type_txt'] ?>
													</td>
													<td class="text-center">
														<?php echo $return['status_txt'] ?><br />
														<a href="<?php dourl('order:detail', array('id' => $return['order_id'])) ?>">订单详情</a>
													</td>
													<td class="text-center"><?php echo $return['pro_num'] ?></td>
													<td class="text-center"><?php echo date('Y-m-d H:i', $return['dateline']) ?></td>
													<td class="text-center">
														<?php echo htmlspecialchars($return['nickname'])  ?><br />
														<?php echo $return['phone'] ?>
													</td>
													<td class="text-center">
														<a href="#detail/<?php echo $return['id'] ?>" class="js-return-detail">查看退货</a><br />
													</td>
												</tr>
												<?php
											}
										}
										?>
									</tbody>
								</table>
								
								
								
								
								
								<table class="meal_con_main_table">
									<thead>
										<tr>
											
											<th>预约人微信</th>
											<th>预约人电话</th>
											<th>茶座信息</th>
											<th>到店时间</th>
											<th>使用时长</th>
											<th>下单时间</th>
											<th>订单状态</th>
											<th>操作</th>
											
										</tr>
									</thead>
									<tbody>
										
										<?php if(!empty($seat)){ ?>
										<?php foreach($seat as $value){ ?>
										<tr class="meal_con_main_table_tr">
											
											<td><?php echo $value['name'];?></td>
											<td><?php echo $value['phone'];?></td>
											<td><?php echo $value['tablename'];?></td>
											<td><?php echo date('m-d H:i', $value['dd_time']); ?></td>
											<td><?php echo $value['sc'];?>小时</td>
											<td><?php echo date('m-d H:i:s', $value['dateline']); ?></td>
											<td><?php echo $value['status'];?></td>
											<td> <a href="<?php echo dourl('meal:order_edit'); ?>&physical_id=<?php echo $value['physical_id'];?>&order_id=<?php echo $value['order_id'];?>" class="edit">编辑</a>
												<a href="<?php echo dourl('meal:order_del'); ?>&physical_id=<?php echo $value['physical_id'];?>&order_id=<?php echo $value['order_id'];?>" class="delete">删除</a></td>
												
											</tr>
											<?php } ?>
											<?php }else{ ?>
											<tr class="odd"><td class="button-column" colspan="11" >暂时没有订单...</td></tr>
											
											
											<?php } ?>
											
										</tbody>
									</table>
									
									
									
									
									
									<table class="meal_con_main_table">
										<thead>
											<tr>
												<th>茶会名称</th>
												<th>报名人姓名</th>
												<th>手机号</th>
												<th>审核状态</th>
												<th>报名时间</th>
												<th>操作</th>
												
											</tr>
										</thead>
										<tbody>
											
											<?php if(!empty($meeting)){ ?>
											<?php foreach($meeting as $value){ ?>
											<tr class="meal_con_main_table_tr">
												<td><?php echo $value['chname'];?></td>
												<td><?php echo $value['name'];?></td>
												<td><?php echo $value['mobile'];?></td>
												<td><?php if($value['status']==1){echo '待审核';}elseif($value['status']==2){echo '审核未通过';}elseif($value['status']==3){echo '审核通过';}?></td>
												<td><?php echo date('Y-m-d',$value['addtime']);?></td>
												
												<td> <?php if($value['status']==1){?><a href="<?php echo dourl('events:bm_edit'); ?>&id=<?php echo $value['id'];?>&cid=<?php echo $_REQUEST['id'];?>&status=2" class="delete">拒绝报名</a> | <a href="<?php echo dourl('events:bm_edit'); ?>&cid=<?php echo $_REQUEST['id'];?>&id=<?php echo $value['id'];?>&status=3" class="delete">通过报名</a>
													<?php } ?>
													<?php if($value['status']==2){?><a href="<?php echo dourl('events:bm_edit'); ?>&id=<?php echo $value['id'];?>&cid=<?php echo $_REQUEST['id'];?>&status=3" class="delete">通过报名</a>
													<?php } ?></td>
													
												</tr>
												<?php } ?>
												<?php }else{ ?>
												<tr class="odd"><td class="button-column" colspan="11" >暂时没有报名...</td></tr>
												
												
												<?php } ?>
												
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>

					</body>
					</html>