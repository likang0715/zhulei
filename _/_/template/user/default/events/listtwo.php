<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8"/> 
	<title>选择分店</title>
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
				选择分店
			</div>
			<div class="meal_con_main">
				<div class="meal_con_main_con">
							<ul>
					<?php if(!empty($store_physical)){ ?>
							<?php foreach($store_physical as $value){ ?>
								<?php $array = explode(',', $value['images']); ?>
								<a href="<?php echo dourl('meal:order'); ?>&store_id=<?php echo $value['pigcms_id'];?>&action=all"><li>
									<div class="shop_list1">
										<span><img class="meal_con_main_shop_logo" src="upload/<?php echo $array[0];?>" width="80" height="80"></span>
								<div class="shop_list1_name"><?php echo $value['name'];?></div>
							</div>
								</li></a>
								
					<?php } ?>
					<?php }else{ ?>
							<tr class="odd"><td class="button-column" colspan="9" >暂时没有店铺...</td></tr>
					<?php } ?>

							</ul>
				</div>
			</div>
		</div>
	</div>
<?php include display('public:footer');?>

</body>
</html>