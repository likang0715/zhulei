<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>预约管理</title>
		<meta name="copyright" content="<?php echo $config['site_url']; ?>"/>
		 <link href="./css/base.css" type="text/css" rel="stylesheet"/>
    <link href="./css/freight.css" type="text/css" rel="stylesheet"/>
    <link href="./css/store.css" type="text/css" rel="stylesheet"/>
    <link href="./css/setting_store.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="./static/js/jquery.min.js"></script>

		<script type="text/javascript" src="./js/base.js"></script>
<script type="text/javascript">var load_url="<?php dourl('load');?>", store_name_check_url = "<?php dourl('store_name_check'); ?>",store_setting_url="<?php dourl('store'); ?>",store_contact_url="<?php dourl('contact'); ?>",store_physical_add_url="<?php dourl('physical_add'); ?>",store_physical_edit_url="<?php dourl('physical_edit'); ?>",store_physical_del_url="<?php dourl('physical_del'); ?>",static_url="./";</script>



	</head>
	<body class="font14 usercenter"><?php include display('public:header');?>
	<div class="wrap_1000 clearfix container">
		<?php include display('sidebar');?>
		<div class="meal_con">
	<!-- 内容头部 -->
<?php if($ok_tips){?>
	<div class="form-group" style="margin-left:0px;" id="back">
										<span style="color:blue;"><?php echo $ok_tips;?></span>				
									</div>
							 <?php }?>
			<div class="meal_con_main_con">
  <form method="post" enctype="multipart/form-data" action="<?php echo dourl('meal:cat_add'); ?>" >
  <input  type="hidden" name="physical_id" value="<?php echo $_GET['physical_id'];?>" />
    <table style="width:500px;" align="center">
   	   <tr>
        <th class="paddingT15">分类名称:</th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput" name="cat_name" type="text" id="cat_name" value=""/></td>
      </tr>
	  <tr>
        <th class="paddingT15">分类排序:</th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput" name="cat_sort" type="text" id="cat_sort" value="50"/></td>
      </tr>	
	  <tr>
        <th></th>
        <td class="ptb20"><input class="ui-btn ui-btn-primary" type="submit" name="Submit" value="提交" />
      </td>
      </tr>
    </table>
  </form>
</div>
					</div></div>

<?php include display('public:footer');?>

	</body>
</html>