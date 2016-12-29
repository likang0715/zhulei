<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>预约管理</title>
	<meta name="copyright" content="<?php echo $config['site_url']; ?>"/>
	<script type="text/javascript" src="./static/js/jquery.min.js"></script>
	<script type="text/javascript" src="./js/base.js"></script>
  <link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
	<link rel="stylesheet" href="./skin/css/global.css">	
	</head>
	<body class="font14 usercenter">
<?php include display('public:header');?>
<div class="wrap_1000 clearfix container">
<?php include display('sidebar');?>
<div class="meal_con">
			<!-- 内容头部 -->
			<div class="meal_con_header">
				茶桌列表
			</div>
	<div class="page-content">
<div class="info" align="center">
  <form method="post" enctype="multipart/form-data" action="<?php echo dourl('meal:table_add'); ?>&store_id=<?php echo $_GET['store_id'];?>" id="store_form">
  <input  type="hidden" name="store_id" value="<?php echo $_GET['store_id'];?>" />
    <table class="infoTable" align="center">
      <tr>
        <th class="paddingT15">所属茶馆:</th>
        <td class="paddingT15 wordSpacing5">
      <?php echo $now_store['name'];?></td>
      </tr>
	   <tr>
        <th class="paddingT15">茶座编号:</th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" name="name" type="text" id="store_name" value="" /></td>
      </tr>
	   <tr>
        <th class="paddingT15">茶座位置:</th>
        <td class="paddingT15 wordSpacing5"><select name="wz_id">
          <option value="0">请选择</option>
          <option value="1">大厅</option>
		  <option value="2" selected="true">包厢</option>
        </select></td>
      </tr>
	   <tr>
        <th class="paddingT15">容纳人数:</th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput" name="zno" type="text" id="zno" value=""/></td>
      </tr>
<tr>
        <th class="paddingT15">价格:</th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput" name="price" type="text" id="price" value=""/> 元/小时</td>
      </tr>
	  <tr>
        <th class="paddingT15">茶座介绍:</th>
        <td class="paddingT15 wordSpacing5"><textarea name="description" cols="25" rows="5"></textarea></td>
      </tr>
       <tr>
        <th class="paddingT15"> <label for="state">状态:</label></th>
        <td class="paddingT15 wordSpacing5"><label><input type="radio" checked="true" value="1" name="status">&nbsp;空闲</label><label><input type="radio" value="2" name="status">&nbsp;使用中</label></td>
      </tr>
      <tr>
        <th></th>
        <td class="ptb20"><input class="ui-btn ui-btn-primary " type="submit" name="Submit" value="提交" />
   </td>
      </tr>
    </table>
  </form>
</div>
<br />
					</div>
				</div>
	
</div>

<?php include display('public:footer');?>

	</body>
</html>