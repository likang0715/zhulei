<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8"/> 
	<title>新增订座订单 - <?php echo $store_session['name']; ?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
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
	var load_url="<?php dourl('load');?>";
	var page_content = "present_index";
	var page_product_list = "product_list";
	var page_present_create = "present_create";
	var page_present_edit = "present_edit";
	var disabled_url = "<?php dourl('disabled') ?>";
	var delete_url = "<?php dourl('delete') ?>";
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
</script>
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
					<li class="active">
						<a href="javascript:;">订单详情</a>
					</li>
				</ul>
			</div>
			<!-- ▲ Third Header -->
			<!-- ▼ Container App -->
			<div class="container-app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="app__content">
							<div class="meal_con_main">

								
				               <?php if($ok_tips){?>
				               <script type="text/javascript">
				               $(document).ready(function() {
				                 teaAlert('<?php echo $ok_tips;?>')
				               });
				               </script>
				              <?php }?>
				              
				               <?php if($error_tips){?>
				               <script type="text/javascript">
				               $(document).ready(function() {
				                 teaAlert('<?php echo $error_tips;?>')
				               });
				               </script>
				              <?php }?>	
								<form method="post" enctype="multipart/form-data" action="<?php echo dourl('meal:order_add'); ?>&physical_id=<?php echo $_GET['physical_id'];?>" id="store_form">
									<input  type="hidden" name="physical_id" value="<?php echo $_GET['physical_id'];?>" />
									<table style="width:500px;">
										<tr>
											<th class="paddingT15">预定茶座:</th>
											<td class="paddingT15 wordSpacing5"><select name="tableid">
												<option value="0">请选择</option>
												<?php foreach($czlist as $value){ ?>
												<option value="<?php echo $value['name'];?>"><?php echo $value['name'];?></option>
												<?php } ?>
											</select></td>
										</tr>	
										<tr>
											<th class="paddingT15">联系人:</th>
											<td class="paddingT15 wordSpacing5"><input class="infoTableInput" name="name" type="text" id="zno" value=""/></td>
										</tr>
										<tr>
											<th class="paddingT15">联系电话:</th>
											<td class="paddingT15 wordSpacing5"><input class="infoTableInput" name="phone" type="text" id="zno" value=""/></td>
										</tr>	
										<tr>
											<th class="paddingT15">到店时间:</th>
											<td class="paddingT15 wordSpacing5"><input type="text" name="start_time" value="" class="js-start-time Wdate" id="js-start-time" readonly="readonly" id="" style="cursor:default; background-color:white" /></td>
										</tr>		
										<tr>
											<th class="paddingT15">使用时长:</th>
											<td class="paddingT15 wordSpacing5"><input class="infoTableInput" name="sc" type="text" id="zno" value=""/>小时</td>
										</tr>	

										<tr>
											<th class="paddingT15">备注:</th>
											<td class="paddingT15 wordSpacing5"><textarea rows="3" style="width: 97%" class="fl" name="bz" ></textarea></td>
										</tr>	
										<tr>
											<th class="paddingT15">预定来源:</th>
											<td class="paddingT15 wordSpacing5">
												<select name="type">
													<option value="2">电话预约</option>
													<option value="1">微信预约</option>
												</select></td>
											</tr>				 
											<tr>
												<th class="paddingT15"> <label for="state">状态:</label></th>
												<td class="paddingT15 wordSpacing5"><input type="radio" name="status" value="1" checked="checked">&nbsp;待审核&nbsp;<input type="radio" name="status" value="2">&nbsp;待消费&nbsp;<input type="radio" name="status" value="3">&nbsp;已完成&nbsp;<input type="radio" name="status" value="4" >&nbsp;已取消</td>
											</tr>

											<tr>
												<th></th>
												<td class="ptb20"><input class="ui-btn ui-btn-primary" type="submit" name="Submit" value="提交" />
												</td>
											</tr>
										</table>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php include display('public:footer');?>

	</body>
	</html>