<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>预约管理</title>
	<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
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
	
	<script>

		function changePage(page) {
			if (page.length == 0) {
				return;
			}

			var re = /^[0-9]*[1-9][0-9]*$/;
			if (!re.test(page)) {
				alert("请填写正确的页数");
				return;
			}

			var url = "<?php echo url('meal:table') ?>&store_id=<?php echo $_GET['store_id'];?>";

			location.href = url + "&page=" + page;
		}

		$(function () {
			$("#pages a").click(function () {
				var page = $(this).attr("data-page-num");
				changePage(page);
			});

			$('.cata_right').click(function(){
				var page=<?php echo $_GET['page']?$_GET['page']:1 ?>;
				page++;
				changePage(page);
			});

			$('.cata_left').click(function(){
				var page=<?php echo $_GET['page']?$_GET['page']:1 ?>;
				page--;

				if(page<=0){
					return;
				}
				changePage(page);
			});
		});

		function jumpPage() {
			var page = $("#jump_page").val();
			changePage(page);
		}





	</script>
		
	</head>
	<body class="font14 usercenter">
<?php include display('public:header');?>
<div class="wrap_1000 clearfix container">
			
			
<div class="main-content">
 <div class="js-list-filter-region clearfix ui-box" style="position:relative;">
        <div>
			<a href="<?php echo dourl('meal:table_add'); ?>&store_id=<?php echo $_GET['store_id'];?>" class="ui-btn ui-btn-primary">新增茶座</a>
                 </div>
    </div>
	<!-- 内容头部 -->
	<div class="page-content">
		<div class="page-content-area">
			<style>
				.ace-file-input a {display:none;}
			</style>
			<div class="row">
				<div class="col-xs-12">
					<div id="shopList" class="grid-view">
						<br /><br />
<div class="info" align="center">
<?php if($_GET['ok_tips']){?>
									<div class="form-group" style="margin-left:0px;">
										<span style="color:blue;"><?php echo $_GET['ok_tips'];?></span>				
									</div>
							 <?php }?>
  <form method="post" enctype="multipart/form-data" action="<?php echo dourl('meal:table_edit'); ?>&store_id=<?php echo $_GET['store_id'];?>&cz_id=<?php echo $czn['cz_id'];?>" id="store_form">
  <input  type="hidden" name="cz_id" value="<?php echo $czn['cz_id'];?>" />
  <input  type="hidden" name="store_id" value="<?php echo $czn['store_id'];?>" />
    <table class="infoTable" align="center">
      <tr>
        <th class="paddingT15">所属茶馆:</th>
        <td class="paddingT15 wordSpacing5">
      <?php echo $now_store['name'];?></td>
      </tr>
	   <tr>
        <th class="paddingT15">茶座编号:</th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" name="name" type="text" id="store_name" value="<?php echo $czn['name'];?>" /></td>
      </tr>
	   <tr>
        <th class="paddingT15">茶座位置:</th>
        <td class="paddingT15 wordSpacing5"><select name="wz_id">
          <option value="0">请选择</option>
          <option value="1" <?php if ($czn['wz_id'] == 1) { ?>selected="true"<?php } ?>>大厅</option>
		  <option value="2" <?php if ($czn['wz_id'] == 2) { ?>selected="true"<?php } ?>>包厢</option>
        </select></td>
      </tr>
	   <tr>
        <th class="paddingT15">容纳人数:</th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput" name="zno" type="text" id="zno" value="<?php echo $czn['zno'];?>"/></td>
      </tr>
<tr>
        <th class="paddingT15">价格:</th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput" name="price" type="text" id="price" value="<?php echo $czn['price'];?>"/> 元/小时</td>
      </tr>
	  <tr>
        <th class="paddingT15">茶座介绍:</th>
        <td class="paddingT15 wordSpacing5"><textarea name="description" cols="25" rows="5"><?php echo $czn['description'];?></textarea></td>
      </tr>
      <tr>
     <div class="control-group">
        <label class="control-label">
            <em class="required">*</em>
            门店照片：
        </label>
        <div class="controls">
            <div class="control-action js-picture-list-wrap">
				<ul class="app-image-list clearfix">
					<div class="js-img-list" style="display:inline-block">
						<?php foreach($czn['images_arr'] as $value){ ?>
							<li class="upload-preview-img"><a href="<?php echo $value;?>" target="_blank"><img src="<?php echo $value;?>"></a><a class="js-delete-picture close-modal small hide">×</a></li>
						<?php } ?>
					</div>
					<li class="js-picture-btn-wrap" style="display:inline-block;float:none;vertical-align:top;">
						<a href="javascript:;" class="add js-add-physical-picture">+加图</a>
					</li>
				</ul>
			</div>
        </div>
    </div>
       </tr>

	        <tr>
        <th class="paddingT15"> <label for="state">状态:</label></th>
        <td class="paddingT15 wordSpacing5"><label><input type="radio" <?php if ($czn['status'] == 1) { ?>checked="true"<?php } ?> value="1" name="status">&nbsp;空闲</label><label><input type="radio" <?php if ($czn['status'] == 2) { ?>checked="true"<?php } ?> value="2" name="status">&nbsp;使用中</label></td>
      </tr>
  
     <tr>
      <tr>
        <th></th>
        <td class="ptb20"><input class="ui-btn ui-btn-primary js-physical-edit-submit" type="submit" name="Submit" value="提交" />
   </td>
      </tr>
    </table>
  </form>
</div>
<br />
					</div>
				</div>
	
</div>

		</div>
		 <div class="nav-wrapper--app"></div>
                <div class="app__content"></div>
<?php include display('public:footer');?>
<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
	</body>
</html>