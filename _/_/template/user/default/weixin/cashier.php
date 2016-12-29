<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8"/> 
	<title>二维码管理 - <?php echo $store_session['name']; ?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>E点茶<?php } ?></title>
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
	<!-- ▼ Table CSS -->
	<link href="<?php echo TPL_URL;?>css/freight.css" type="text/css" rel="stylesheet"/>
	<link href="<?php echo TPL_URL;?>css/table.css" type="text/css" rel="stylesheet"/>
	<!-- ▲ Table CSS -->
	<!-- ▼ Constant JS -->
	<script type="text/javascript">
	var catDom = '<div class="cat_edit"><div class="cat_edit_top"><div class="top_left left"><input type="checkbox" id="all_select" onclick="selectAll($("#all_select"),$(".cat_all"))"><span onclick="selectAll ($("#all_select"),$(".cat_all"))">全选</span><span class="js-del-all">删除</span></div><div class="top_right right"><span>新增分类</span></div></div><?php if(!empty($cat_list)){ ?><div class="cat_edit_list"><div class="cat_item cat_item_t" data-catid=""><div class="cat_item_con list_name_t"><span>分类名称</span></div><div class="cat_item_con list_sort_t"><span>显示排序</span></div><div class="cat_item_con list_btn_t"><span>操作</span></div></div><?php foreach($cat_list as $r){ ?><div class="cat_item" data-catid="<?php echo $r["cat_id"];?>"><div class="cat_item_con list_name"><input type="checkbox" class="cat_all" value="<?php echo $r["cat_id"];?>"><span class="state-show cat-name"><?php echo $r["cat_name"];?></span><input type="text" value="<?php echo $r["cat_name"];?>" name="cat_name" class="state-edit"></div><div class="cat_item_con list_sort"><span class="state-show cat-sort"><?php echo $r["cat_sort"];?></span><input type="text" value="<?php echo $r["cat_sort"];?>" name="cat_sort" class="state-edit"></div><div class="cat_item_con list_btn"><span class="js-cat-edit state-show">编辑</span><span class="js-cat-del state-show"> - 删除</span><span class="js-cat-save state-edit">保存</span><span class="js-cat-cancel state-edit"> - 取消</span></div></div><?php } ?></div><?}else{?><div class="no-results"></div><?php } ?></div>'
	var store_id = "<?php echo $_GET['physical_id'];?>"
	var load_url="<?php  dourl('meal:table',array('physical_id'=>$_GET['physical_id'],'cat_id'=>$_GET['cat_id']));?>";
	var cat_del_url="<?php  dourl('meal:cat_del',array('physical_id'=>$_GET['physical_id']));?>";
	var cat_add_url="<?php  dourl('meal:cat_add',array('physical_id'=>$_GET['physical_id']));?>";
	var cat_edit_url="<?php  dourl('meal:cat_edit',array('physical_id'=>$_GET['physical_id']));?>";
	</script>
	<!-- ▲ Constant JS -->
	<!-- ▼ Base JS -->
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/swiper.jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
	<!-- ▲ Base JS -->
	<!-- ▼ Table JS -->
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/table-main.js"></script>
	<!-- ▲ Table JS -->	
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>js/common.js"></script>
	<script src="<?php echo STATIC_URL;?>js/cart/jscolor.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.form.min.js"></script>
	<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
	<link href="<?php echo TPL_URL;?>css/sendall.css" rel="stylesheet" type="text/css"/>
	<script src="<?php echo TPL_URL;?>js/tpl_msg.js" type="text/javascript"></script>		
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
						<a href="<?php dourl('cashier')?>" data-is="3">二维码管理</a>
					</li>
					<li class="">
						<a href="<?php dourl('cashier_list') ?>" data-is="1">收银台对账</a>
					</li>
				</ul>
			</div>
			<!-- ▲ Third Header -->
			<!-- ▼ Container App -->
			<div class="container-app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="app__content page-setting-weixin">
							<div>
								<table class="ui-table ui-table-list" width="100%" cellspacing="0">
									<colgroup><col> <col> <col><col>  <col width="180" align="center"> </colgroup>
									<thead>
										<tr>
											<th>收款二维码</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($store_physical as $key=>$val){?>
										<tr>
											<td align="center"><a href="<?php echo $config['wap_site_url']."/shoukuan.php?store_id=".$val['store_id']."&pid=".$val['pigcms_id'];?>" target="_blank"><img src="<?php echo $config['wap_site_url']."/shoukuan.php?store_id=".$val['store_id']."&pid=".$val['pigcms_id'];?>" width="180" height="180"></a></td>
										</tr>
										<tr>
											<td align="center"><?php echo $val['name'];?></td>
										</tr>
										<?php }?>

									</tbody>
								</table>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include display('public:footer');?>
	<script>
	$(function(){
		$('#myform').ajaxForm({
			beforeSubmit: showRequest,
			success: showResponse,
			dataType: 'json'
		});
		function showRequest(){

		}
		function showResponse(res){
			tusi(res.err_msg);
			if(res.err_code == 0){
				setTimeout(function(){
					location.reload();
				},1500);
			}
		}
	});	
	</script>
</body>
</html>