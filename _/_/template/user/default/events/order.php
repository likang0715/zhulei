<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>预约管理</title>
		<meta name="copyright" content="<?php echo $config['site_url']; ?>"/>
		<script type="text/javascript" src="./static/js/jquery.min.js"></script>
		<script type="text/javascript" src="./js/base.js"></script>
<link rel="stylesheet" href="./skin/css/global.css">		
	</head>
	<body class="font14 usercenter">
<?php include display('public:header');?>
<div class="wrap_1000 clearfix container">
<?php include display('sidebar');?>
<div class="meal_con">
			<!-- 内容头部 -->
			<div class="meal_con_header">
				<span><?php echo $now_store['name'];?></span><a href="<?php echo dourl('meal:order_add'); ?>&store_id=<?php echo $_GET['store_id'];?>" style="float:right;  background: #FFFFFF;border: 1px solid #ccc;padding: 0 10px;font-weight: normal;">新增预约</a>
			</div>
        <div class="ui-nav">
            <ul>
                <li><a href="<?php echo dourl('meal:order'); ?>&store_id=<?php echo $_GET['store_id'];?>&action=all"  <?php if($_GET['action']=='all'){?> style="color:#FF0000;font-size: 18px;" <?php } ?>>全部</a></li>
                <li><a href="<?php echo dourl('meal:order'); ?>&store_id=<?php echo $_GET['store_id'];?>&action=dsh" <?php if($_GET['action']=='dsh'){?> style="color:#FF0000;font-size: 18px;"  <?php } ?>>待审核</a></li>
                <li><a href="<?php echo dourl('meal:order'); ?>&store_id=<?php echo $_GET['store_id'];?>&action=dxf"  <?php if($_GET['action']=='dxf'){?> style="color:#FF0000;font-size: 18px;" <?php } ?>>待消费</a></li>
                <li><a href="<?php echo dourl('meal:order'); ?>&store_id=<?php echo $_GET['store_id'];?>&action=cancel"  <?php if($_GET['action']=='cancel'){?> style="color:#FF0000;font-size: 18px;" <?php } ?>>已取消</a></li>
                <li><a href="<?php echo dourl('meal:order'); ?>&store_id=<?php echo $_GET['store_id'];?>&action=suc"  <?php if($_GET['action']=='suc'){?> style="color:#FF0000;font-size: 18px;"  <?php } ?>>已完成</a></li>

            </ul>
        </div>
		<div class="meal_con_main">
				<div class="col-xs-12">
						<table class="meal_con_main_table">
							<thead>
								<tr>
									<!-- <th>订单号</th> -->
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
						
										<?php if(!empty($order_list)){ ?>
									<?php foreach($order_list as $value){ ?>
										<tr class="meal_con_main_table_tr">
											<!-- <td><?php echo $value['orderid'];?></td> -->
											<td><?php echo $value['name'];?></td>
											<td><?php echo $value['phone'];?></td>
											<td><?php echo $value['tableid'];?></td>
											<td><?php echo $value['dd_time']; ?></td>
											<td><?php echo $value['sc'];?>小时</td>
											<td><?php echo date('m-d H:i:s', $value['dateline']); ?></td>
											<td><?php echo $value['status'];?></td>
											<td> <a href="<?php echo dourl('meal:order_edit'); ?>&store_id=<?php echo $value['store_id'];?>&order_id=<?php echo $value['order_id'];?>" class="edit">编辑</a>
                            <a href="<?php echo dourl('meal:order_del'); ?>&store_id=<?php echo $value['store_id'];?>&order_id=<?php echo $value['order_id'];?>" class="delete">删除</a></td>
									
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

	</body>
</html>