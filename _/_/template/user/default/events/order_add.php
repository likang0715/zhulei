<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>新增预约</title>
		<meta name="copyright" content="<?php echo $config['site_url']; ?>"/>
		 <link href="./css/base.css" type="text/css" rel="stylesheet"/>
    <link href="./css/freight.css" type="text/css" rel="stylesheet"/>
    <link href="./css/store.css" type="text/css" rel="stylesheet"/>
    <link href="./css/setting_store.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="./static/js/jquery.min.js"></script>
		<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
		<script type="text/javascript" src="./static/js/area/area.min.js"></script>
		<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
		<script type="text/javascript" src="./js/base.js"></script>
<script type="text/javascript">var load_url="<?php dourl('load');?>", store_name_check_url = "<?php dourl('store_name_check'); ?>",store_setting_url="<?php dourl('store'); ?>",store_contact_url="<?php dourl('contact'); ?>",store_physical_add_url="<?php dourl('physical_add'); ?>",store_physical_edit_url="<?php dourl('physical_edit'); ?>",store_physical_del_url="<?php dourl('physical_del'); ?>",static_url="./";</script>
    <script type="text/javascript" src="./js/store_setting.js"></script>

<link rel="stylesheet" href="./skin/css/font-awesome.min.css">
<link rel="stylesheet" href="./skin/css/jquery-ui.css">
<link rel="stylesheet" href="./skin/css/jquery-ui.min.css">
<link rel="stylesheet" href="./skin/css/ace-fonts.css">
<link rel="stylesheet" href="./skin/css/ace.min.css" id="main-ace-style">
<link rel="stylesheet" href="./skin/css/ace-skins.min.css">
<link rel="stylesheet" href="./skin/css/ace-rtl.min.css">
<link rel="stylesheet" href="./skin/css/global.css">
<link rel="stylesheet" href="./skin/css/jquery-ui-timepicker-addon.css">
<script type="text/javascript" src="./skin/js/jquery.min.js"></script>
<script type="text/javascript" src="./static/js/date/WdatePicker.js"></script>
		<script type="text/javascript" src="./static/js/plugin/jquery-ui.js"></script>
		<script type="text/javascript" src="./static/js/plugin/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript">
			var load_url="<?php dourl('load');?>";
			var page_content = "present_index";
			var page_product_list = "product_list";
			var page_present_create = "present_create";
			var page_present_edit = "present_edit";
			var disabled_url = "<?php dourl('disabled') ?>";
			var delete_url = "<?php dourl('delete') ?>";
		</script>
		<script type="text/javascript" src="./js/present.js"></script>

</script>
	</head>
	<body class="font14 usercenter">
		<?php include display('public:header');?>
	<div class="wrap_1000 clearfix container">
		<?php include display('sidebar');?>
		<div class="meal_con">
			<!-- 内容头部 -->
			<div class="meal_con_header">
				新增预约
			</div>
			<div class="meal_con_main">
<?php if($ok_tips){?>
									<div class="form-group" style="margin-left:0px;" id="back">
										<span style="color:blue;"><?php echo $ok_tips;?></span>				
									</div>
							 <?php }?>
							 
<?php if($error_tips){?>
									<div class="form-group" style="margin-left:0px;" id="back">
										<span style="color:blue;"><?php echo $error_tips;?></span>				
									</div>
							 <?php }?>	
  <form method="post" enctype="multipart/form-data" action="<?php echo dourl('meal:order_add'); ?>&store_id=<?php echo $_GET['store_id'];?>" id="store_form">
  <input  type="hidden" name="store_id" value="<?php echo $_GET['store_id'];?>" />
    <table style="width:500px;" align="center">
  	  <tr>
        <th class="paddingT15">预定茶座:</th>
        <td class="paddingT15 wordSpacing5"><select name="tableid">
          <option value="0">请选择</option>
            	<?php foreach($czlist as $value){ ?>
				 <option value="<?php echo $value['cz_id'];?>"><?php echo $value['name'];?></option>
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

<?php include display('public:footer');?>

	</body>
</html>