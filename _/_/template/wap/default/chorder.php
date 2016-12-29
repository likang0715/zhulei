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
		<!--title><?php echo $pageTitle;?> - <?php echo $now_store['name'];?></title-->
		<title>我的茶会</title>
		<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>pingtai/css/reset.css">
		<link rel="stylesheet" href="<?php echo TPL_URL;?>pingtai/css/common.css">
		<link rel="stylesheet" href="<?php echo TPL_URL;?>pingtai/css/mybaoming.css">
		<script src="<?php echo TPL_URL;?>pingtai/js/jquery-1.7.min.js"></script>
		<script src="<?php echo TPL_URL;?>pingtai/js/jquery.touchSlider.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>pingtai/js/jquery.tabs.js"></script>
		<!–[if lt IE 9]>
		<script src="<?php echo TPL_URL;?>pingtai/js/html5shiv.js"></script>
		<script src="<?php echo TPL_URL;?>pingtai/js/respond.min.js"></script>
		<![endif]–>
		<script>
		$(function () {
			$("#pages a").click(function () {
				var page = $(this).attr("data-page-num");
				location.href = "<?php echo $page_url ?>&page=" + page;
			});
		});
		</script>
	</head>
	<body>
	<div class="myBaoming_main">
		<!-- 选项卡 -->
		<div class="myBaoming">
		    <ul class="index_near_menu">
		   
			<a href="./chorder.php?<?php if($now_store['store_id']){?>id=<?php echo $now_store['store_id'];?>&<?php } ?><?php if($_GET['platform']){?>&platform=1<?php } ?>">
                        <li <?php if($_GET['status']==''){?> class="current" <?php } ?>>
						全部
                        </li>
                    </a>
                  <a href="./chorder.php?<?php if($now_store['store_id']){?>id=<?php echo $now_store['store_id'];?>&<?php } ?>status=1<?php if($_GET['platform']){?>&platform=1<?php } ?>">
                        <li <?php if($_GET['status']=='1'){?> class="current" <?php } ?>>
						待审核
                        </li>
                    </a>
                    <a href="./chorder.php?<?php if($now_store['store_id']){?>id=<?php echo $now_store['store_id'];?>&<?php } ?>status=3<?php if($_GET['platform']){?>&platform=1<?php } ?>">
                        <li  <?php if($_GET['status']=='3'){?> class="current" <?php } ?>>
                        已通过
                        </li>
                    </a>
                   	<a href="./chorder.php?<?php if($now_store['store_id']){?>id=<?php echo $now_store['store_id'];?>&<?php } ?>status=2<?php if($_GET['platform']){?>&platform=1<?php } ?>">
                        <li <?php if($_GET['status']=='2'){?> class="current" <?php } ?>>
                      未通过
                        </li>
                    </a>	
		    </ul>
		    <div class="index_near_con main">
		        <div class="myBaoming_con_01">
		        	<ul>
					<?php foreach($orderList as $key=>$order){ ?>
                         <li>
		        			<div class="myBaoming_con_text">
			            		<h3><?php echo $order['ch_name'];?></h3>
			            		<p>主办方：<?php echo $order['store_name'];?></p>
			            		<p>活动时间：<?php echo date('m-d H:i', strtotime($order['sttime']));?>至<?php echo date('m-d H:i', strtotime($order['endtime']));?></p>
			            		<p>参加人：<span><?php echo $order['name'];?></span><a href="./chorder.php?del_id=<?php echo $order['id'];?>"  <?php if($order['status']==3){?> style="display:none"<?php } ?> class="cancel">取消报名</a></p>
			            		<span class="myBaoming_icon"><?php if($order['status']==1){?>待审核<?php } elseif($order['status']==2){?>未通过<?php } elseif($order['status']==3){?>已通过<?php } ?></span>
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
	</div>
	
	<?php echo $shareData;?>
		</div>
	</body>
</html>
<?php Analytics($now_store['store_id'], 'ucenter', '会员主页', $now_store['store_id']); ?>