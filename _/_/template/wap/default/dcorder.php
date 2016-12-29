<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js" lang="zh-CN">
<head>
	<meta charset="utf-8"/>
	<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
	<meta name="description" content="<?php echo $config['seo_description'];?>" />
	<meta name="HandheldFriendly" content="true"/>
	<meta name="MobileOptimized" content="320"/>
	<meta name="format-detection" content="telephone=no"/>
	<meta http-equiv="cleartype" content="on"/>
	<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
	<title>预约订单-个人中心</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
	<link rel="stylesheet" href="<?php echo TPL_URL;?>pingtai/css/reset.css">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>pingtai/css/common.css">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>pingtai/css/myYuyue.css">
	<script src="<?php echo TPL_URL;?>pingtai/js/jquery-1.7.min.js"></script>
	<script src="<?php echo TPL_URL;?>pingtai/js/jquery.touchSlider.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>pingtai/js/jquery.tabs.js"></script>
	<!–[if lt IE 9]>
	<script src="<?php echo TPL_URL;?>pingtai/js/html5shiv.js"></script>
	<script src="<?php echo TPL_URL;?>pingtai/js/respond.min.js"></script>
	<![endif]–>
	
</head>
<body>
	<div class="myYuyue_main">
		<!-- 选项卡 -->
		<div class="myYuyue">
			<ul class="index_near_menu">
				<a href="./dcorder.php?<?php if($now_store['store_id']){?>id=<?php echo $now_store['store_id'];?>&<?php } ?>action=all<?php if($_GET['platform']){?>&platform=1<?php } ?>">
					<li <?php if($_GET['action']=='all'){?> class="current" <?php } ?>>
						全部
					</li>
				</a>
				<a href="./dcorder.php?<?php if($now_store['store_id']){?>id=<?php echo $now_store['store_id'];?>&<?php } ?>action=dsh<?php if($_GET['platform']){?>&platform=1<?php } ?>">
					<li <?php if($_GET['action']=='dsh'){?> class="current" <?php } ?>>
						待审核
					</li>
				</a>
				<a href="./dcorder.php?<?php if($now_store['store_id']){?>id=<?php echo $now_store['store_id'];?>&<?php } ?>action=dxf<?php if($_GET['platform']){?>&platform=1<?php } ?>">
					<li  <?php if($_GET['action']=='dxf'){?> class="current" <?php } ?>>
						待消费
					</li>
				</a>
				<a href="./dcorder.php?<?php if($now_store['store_id']){?>id=<?php echo $now_store['store_id'];?>&<?php } ?>action=suc<?php if($_GET['platform']){?>&platform=1<?php } ?>">
					<li <?php if($_GET['action']=='suc'){?> class="current" <?php } ?>>
						已完成
					</li>
				</a>
				<a href="./dcorder.php?<?php if($now_store['store_id']){?>id=<?php echo $now_store['store_id'];?>&<?php } ?>action=cancel<?php if($_GET['platform']){?>&platform=1<?php } ?>">
					<li <?php if($_GET['action']=='cancel'){?> class="current" <?php } ?>>
						已关闭
					</li>
				</a>
			</ul>
			<div class="index_near_con">
				<div class="myYuyue_con_01">
					<ul>
						<?php foreach($orderList as $key=>$order){ ?>
						<li>
							<h3>下单时间：<?php echo date('Y-m-d H:i:s', $order['dateline']); ?><span><?php if($order['status']==1){?>待审核<?php } elseif($order['status']==2){?>待消费<?php } elseif($order['status']==3){?>已完成<?php } ?></span></h3>
							<div class="myYuyue_con_box">
								<div class="myYuyue_con_l">
									<img src="<?php echo $order['images'];?>" >
								</div>
								<div class="myYuyue_con_r">
									<h4><?php echo $order['store_name'];?></h4>
									<div class="b_box"><div class="b_left_1"><span>包厢：</span><?php echo $order['tablename'];?></div><div class="b_left_2"><span>人数：</span><?php echo $order['num'];?>人</div></div>
									<div class="b_box"><span>时间：</span><?php echo $order['dd_time'];?>&nbsp;&nbsp;&nbsp;&nbsp;<?php if($order['sc']){?><?php echo $order['sc'];?>小时<?php } ?></div>
								</div>
							</div>
							<div class="myYuyue_con_b cf">
								<a href="./dcorder.php?del_id=<?php echo $order['order_id'];?>"  <?php if($order['status']>2){?> $ style="display:none"<?php } ?> >删除订单</a>
							</div>
						</li>
						<?php } ?>

					</ul>
				</div>

			</div>
		</div>
		<div class="bottom" id="pages">
			<?php echo $pages ?>
		</div>
		<!-- 公共的footer -->
		<?php include display('footer');?>
		<div class="common_footer"></div>

		<?php echo $shareData;?>
	</div>
</body>
</html>
<?php Analytics($now_store['store_id'], 'ucenter', '会员主页', $now_store['store_id']); ?>