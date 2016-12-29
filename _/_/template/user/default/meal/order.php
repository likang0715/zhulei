<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8"/> 
	<title>订座订单管理 - <?php echo $store_session['name']; ?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
	<meta name="description" content="<?php echo $config['seo_description'];?>">
	<meta name="copyright" content="<?php echo $config['site_url'];?>"/>
	<meta name="renderer" content="webkit">
	<meta name="referrer" content="always">
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<!-- ▼ Base CSS -->
	<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
	<link href="<?php echo STATIC_URL;?>css/jquery.ui.css" type="text/css" rel="stylesheet" />
	<!-- ▲ Base CSS -->
	<!-- ▼ Order CSS -->
	<link href="<?php echo TPL_URL;?>css/freight.css" type="text/css" rel="stylesheet"/>
	<link href="<?php echo TPL_URL;?>css/table-order.css" type="text/css" rel="stylesheet"/>
	<!-- ▲ Order CSS -->
	<!-- ▼ Constant JS -->
	<script type="text/javascript">
	var load_url="<?php  dourl('load');?>";
	var order_add_url = "<?php echo dourl('meal:order_add'); ?>";
	</script>
	<!-- ▲ Constant JS -->
	<!-- ▼ Base JS -->
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui-timepicker-addon.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/swiper.jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
	<!-- ▲ Base JS -->
	<!-- ▼ Order JS -->
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/table_order.js"></script>
	<!-- ▲ Order JS -->			
</head>
<body class="font14 usercenter">
	<?php include display('public:first_sidebar');?>
	<?php include display('sidebar');?>
	<!-- ▼ Container-->
	<div id="container" class="clearfix container right-sidebar">
		<div id="container-left">
			<!-- ▼ Third Header -->
			<div id="third-header">
				<ul class="third-header-inner js-shop-order">
					<?php if(!empty($store_physical)){ ?>
					<?php foreach($store_physical as $value){ ?>
					<li class="store_<?php echo $value['pigcms_id'];?><?php if($value['pigcms_id']==$_GET['physical_id']){ ?> active<?php } ?>" data-id="<?php echo $value['pigcms_id'];?>">
						<a href="#list/<?php echo $value['pigcms_id'];?>"><?php echo $value['name'];?></a>
					</li>
					<?php } ?>
					<?php }else{ ?>
					<script type="text/javascript">
					$(document).ready(function() {
						teaAlert('complete','请先添加线下门店',function () {
							window.location.href = "<?php echo dourl('setting:store'); ?>#physical_store"
						})
					});
					</script>
					<?php } ?>
				</ul>
			</div>
			<!-- ▲ Third Header -->
			<!-- ▼ Container App -->
			<div class="container-app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="app__content">
						<?php include display('order_list_filter');?>
						<div class="meal_con">
							<!-- ▼ Fourth Header -->
							<div id="fourth-header" class="fourth-header unselect">
								<div class="fourth-header-menu">
									<ul class="fourth-header-inner fourth-header-wrapper js-order-status">
										<li <?php if($status='0'){?> class="active"<?php } ?>><a href="javascript:;" data-status="0">全部</a></li>
										<li <?php if($status=='1'){?> class="active" <?php } ?>><a href="javascript:;" data-status="1">待确认</a></li>
										<li <?php if($status=='2'){?> class="active"<?php } ?>><a href="javascript:;" data-status="2">待消费</a></li>
										<li <?php if($status=='3'){?> class="active"<?php } ?>><a href="javascript:;" data-status="3">已完成</a></li>
										<li <?php if($status=='4'){?> class="active" <?php } ?>><a href="javascript:;" data-status="4">已取消</a></li>
									</ul>
								</div>
								<div class="fourth-cat-add">
									<a href="<?php echo dourl('meal:order_add'); ?>&physical_id=<?php echo $physical_id;?>" class="js-order-add"><span class="add-btn">新增预约</span></a>
								</div>
							</div>
							<!-- ▲ Fourth Header -->
							<!-- ▼ Order List -->
							<div class="js-search-result table-order"></div>
							<!-- ▲ Order List -->
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>