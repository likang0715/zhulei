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
<script type="text/javascript" src="./skin/js/jquery.ba-bbq.min.js"></script>
<script type="text/javascript" src="./skin/js/ace-extra.min.js"></script>


<script type="text/javascript" src="./skin/js/bootstrap.min.js"></script>

<!-- page specific plugin scripts -->
<script type="text/javascript" src="./skin/js/bootbox.min.js"></script>
<script type="text/javascript" src="./skin/js/jquery-ui.custom.min.js"></script>
<script type="text/javascript" src="./skin/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="./skin/js/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript" src="./skin/js/jquery.easypiechart.min.js"></script>
<script type="text/javascript" src="./skin/js/jquery.sparkline.min.js"></script>

<!-- ace scripts -->
<script type="text/javascript" src="./skin/js/ace-elements.min.js"></script>
<script type="text/javascript" src="./skin/js/ace.min.js"></script>

<script type="text/javascript" src="./skin/js/jquery.yiigridview.js"></script>
<script type="text/javascript" src="./skin/js/jquery-ui-i18n.min.js"></script>
<script type="text/javascript" src="./skin/js/jquery-ui-timepicker-addon.min.js"></script>
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
  <form method="post" enctype="multipart/form-data" action="<?php echo dourl('meal:order_edit'); ?>&store_id=<?php echo $_GET['store_id'];?>&order_id=<?php echo $_GET['order_id'];?>" id="store_form">
  <input  type="hidden" name="order_id" value="<?php echo $czn['order_id'];?>" />
  <input  type="hidden" name="store_id" value="<?php echo $czn['store_id'];?>" />
    <table style="width:500px;" align="center">
   	   <tr>
        <th class="paddingT15">订单编号:</th>
        <td class="paddingT15 wordSpacing5"><?php echo $czn['orderid'];?></td>
      </tr>
	  <tr>
        <th class="paddingT15">预定茶座:</th>
        <td class="paddingT15 wordSpacing5"><?php echo $czn['tableid'];?></td>
      </tr>	
	  <tr>
        <th class="paddingT15">联系人:</th>
        <td class="paddingT15 wordSpacing5"><?php echo $czn['name'];?></td>
      </tr>
	  <tr>
        <th class="paddingT15">联系电话:</th>
        <td class="paddingT15 wordSpacing5"><?php echo $czn['phone'];?></td>
      </tr>	
	  <tr>
        <th class="paddingT15">到店时间:</th>
        <td class="paddingT15 wordSpacing5"><?php echo $czn['dd_time'];?></td>
      </tr>		
	   <tr>
        <th class="paddingT15">使用时长:</th>
        <td class="paddingT15 wordSpacing5"><?php echo $czn['sc'];?>小时</td>
      </tr>	
	  <tr>
        <th class="paddingT15">下单时间:</th>
        <td class="paddingT15 wordSpacing5"><?php echo date("Y-m-d H:i:s", $czn['dateline'])?></td>
      </tr>	
	  
	  <tr>
        <th class="paddingT15">备注:</th>
        <td class="paddingT15 wordSpacing5"><textarea rows="3" style="width: 97%" class="fl" name="bz" ><?php echo $czn['bz'];?></textarea></td>
      </tr>				 
      <tr>
        <th class="paddingT15"> <label for="state">状态:</label></th>
        <td class="paddingT15 wordSpacing5"><input type="radio" name="status" value="1" <?php if($czn['status']==1){?>checked="checked" <?php }?>>&nbsp;待审核&nbsp;<input type="radio" name="status" value="2"  <?php if($czn['status']==2){?>checked="checked" <?php }?>>&nbsp;待消费&nbsp;<input type="radio" name="status" value="3" <?php if($czn['status']==3){?>checked="checked" <?php }?>>&nbsp;已完成&nbsp;<input type="radio" name="status" value="4"  <?php if($czn['status']==4){?>checked="checked" <?php }?>>&nbsp;已取消</td>
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