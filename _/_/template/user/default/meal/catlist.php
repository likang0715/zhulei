<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8"/> 
	<title>订座</title>
	<meta name="copyright" content="<?php echo $config['site_url']; ?>"/>

	<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
	<script type="text/javascript" src="./static/js/jquery.min.js"></script>

	<script type="text/javascript" src="./js/base.js"></script>

	<link rel="stylesheet" href="./css/bootstrap.min.css">
	<link rel="stylesheet" href="./skin/css/font-awesome.min.css">
	<link rel="stylesheet" href="./skin/css/jquery-ui.css">
	<link rel="stylesheet" href="./skin/css/jquery-ui.min.css">
	<link rel="stylesheet" href="./skin/css/ace-fonts.css">
	<link rel="stylesheet" href="./skin/css/ace.min.css" id="main-ace-style">
	<link rel="stylesheet" href="./skin/css/ace-skins.min.css">
	<link rel="stylesheet" href="./skin/css/ace-rtl.min.css">
	<link rel="stylesheet" href="./skin/css/global.css">
	<link rel="stylesheet" href="./skin/css/jquery-ui-timepicker-addon.css">


	<style type="text/css">
	.jqstooltip {
		position: absolute;
		left: 0px;
		top: 0px;
		visibility: hidden;
		background: rgb(0, 0, 0) transparent;
		background-color: rgba(0, 0, 0, 0.6);
		filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000,endColorstr=#99000000);
		-ms-filter:"progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";
		color: white;
		font: 10px arial, san serif;
		text-align: left;
		white-space: nowrap;
		padding: 5px;
		border: 1px solid white;
		z-index: 10000;
	}

	.jqsfield {
		color: white;
		font: 10px arial, san serif;
		text-align: left;
	}

	.statusSwitch, .orderValidSwitch, .unitShowSwitch, .authTypeSwitch {
		display: none;
	}

	#shopList .shopNameInput, #shopList .tagInput, #shopList .orderPrefixInput
	{
		font-size: 12px;
		color: black;
		display: none;
		width: 100%;
	}
	</style>
	<script type="text/javascript">
	try{ace.settings.check('navbar' , 'fixed')}catch(e){}
	try{ace.settings.check('main-container' , 'fixed')}catch(e){}
	try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
	try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
	</script>
	


</head>
<body class="font14 usercenter">
	<?php include display('public:header');?>
	<div class="wrap_1000 clearfix container">
		<?php include display('sidebar');?>		
		<div class="meal_con">
			<div class="meal_con_header">
				<span><?php echo $now_store['name'];?></span><a href="<?php echo dourl('meal:cat_add'); ?>&physical_id=<?php echo $_GET['physical_id'];?>" style="float:right;  background: #FFFFFF;border: 1px solid #ccc;padding: 0 10px;font-weight: normal;">新增分类</a>
			</div>
			<div class="meal_con_header">
				分类列表
			</div>
			
			<div class="meal_con_main">
					<table class="meal_con_main_table">
						<thead>
							<tr>
								<th>分类名称</th>
								<th>信息修改</th>
							</tr>
						</thead>
						<tbody>
							<?php if(!empty($cat_list)){ ?>
							<?php foreach($cat_list as $value){ ?>
							<tr class="meal_con_main_table_tr">
							<td><?php echo $value['cat_name'];?></td>									
											<td>
									<a style="width:80px;color:#07d;" title="编辑" target="_blank" href="<?php echo dourl('meal:cat_edit'); ?>&physical_id=<?php echo $value['physical_id'];?>&cat_id=<?php echo $value['cat_id'];?>">编辑</a>-<a href="<?php echo dourl('meal:cat_del'); ?>&physical_id=<?php echo $value['physical_id'];?>&cat_id=<?php echo $value['cat_id'];?>" class="delete">删除</a>
								</td>
							</tr>
							
							<?php } ?>
							<?php }else{ ?>
							<tr class="odd"><td class="button-column" colspan="9" >您没有添加店铺，或店铺没开启功能，或店铺正在审核中。</td></tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
					</div>
	</div>
	<?php include display('public:footer');?>

</body>
</html>