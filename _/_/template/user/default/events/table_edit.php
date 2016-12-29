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
				茶桌编辑
			</div>
	<div class="meal_con_main_con">
<?php if($_GET['ok_tips']){?>
									<div class="form-group" style="margin-left:0px;" id="back">
										<span style="color:blue;"><?php echo $_GET['ok_tips'];?></span>				
									</div>
							 <?php }?>
  <form method="post" enctype="multipart/form-data" action="<?php echo dourl('meal:table_edit'); ?>&store_id=<?php echo $_GET['store_id'];?>&cz_id=<?php echo $czn['cz_id'];?>" id="store_form">
  <input  type="hidden" name="cz_id" value="<?php echo $czn['cz_id'];?>" />
  <input  type="hidden" name="store_id" value="<?php echo $czn['store_id'];?>" />
    <table class="infoTable" align="center" style="margin-left: 20px;margin-top:20px;">
      <tr>
        <td class="table_edit_td">所属茶馆:</td>
        <td>
      <?php echo $now_store['name'];?></td>
      </tr>
	   <tr>
        <td class="table_edit_td">茶座编号:</td>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" name="name" type="text" id="store_name" value="<?php echo $czn['name'];?>" /></td>
      </tr>
	   <tr>
        <td class="table_edit_td">茶座位置:</td>
        <td class="paddingT15 wordSpacing5"><select name="wz_id">
          <option value="0">请选择</option>
          <option value="1" <?php if ($czn['wz_id'] == 1) { ?>selected="true"<?php } ?>>大厅</option>
		  <option value="2" <?php if ($czn['wz_id'] == 2) { ?>selected="true"<?php } ?>>包厢</option>
        </select></td>
      </tr>
	   <tr>
        <td class="table_edit_td">容纳人数:</td>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput" name="zno" type="text" id="zno" value="<?php echo $czn['zno'];?>"/></td>
      </tr>
<tr>
        <td class="table_edit_td">价格:</td>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput" name="price" type="text" id="price" value="<?php echo $czn['price'];?>"/> 元/小时</td>
      </tr>
	  <tr>
        <td class="table_edit_td">茶座介绍:</td>
        <td class="paddingT15 wordSpacing5"><textarea name="description" cols="25" rows="5"><?php echo $czn['description'];?></textarea></td>
      </tr>
	    <tr>
        <td class="table_edit_td"> <label for="state">状态:</label></td>
        <td class="paddingT15 wordSpacing5"><label style="float: left;margin-right: 20px;"><input type="radio" <?php if ($czn['status'] == 1) { ?>checked="true"<?php } ?> value="1" name="status">&nbsp;空闲</label><label  style="float: left;margin-right: 20px;"><input type="radio" <?php if ($czn['status'] == 2) { ?>checked="true"<?php } ?> value="2" name="status">&nbsp;使用中</label></td>
      </tr>
      <tr>
        <td class="paddingT15"><input class="ui-btn1 ui-btn-primary " type="submit" name="Submit" value="提交" style="margin-bottom: 20px;"/>
   </td>
      </tr>
    </table>
  </form>
</div>
<br />
					</div>
				</div>



<?php include display('public:footer');?>

	</body>
</html>