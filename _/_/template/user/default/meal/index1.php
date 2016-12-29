<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8"/> 
	<title>订座</title>
	<meta name="copyright" content="<?php echo $config['site_url']; ?>"/>

	<script type="text/javascript" src="./static/js/jquery.min.js"></script>
	<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
	<script type="text/javascript" src="./static/js/area/area.min.js"></script>
	<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
	<script type="text/javascript" src="./js/base.js"></script>

	<script type="text/javascript" src="./js/goods.js"></script>
	<link rel="stylesheet" href="./css/bootstrap.min.css">
	<link rel="stylesheet" href="./skin/css/font-awesome.min.css">
	<link rel="stylesheet" href="./skin/css/jquery-ui.css">
	<link rel="stylesheet" href="./skin/css/jquery-ui.min.css">
	<link rel="stylesheet" href="./skin/css/ace-fonts.css">
	<link rel="stylesheet" href="./skin/css/ace.min.css" id="main-ace-style">
	<link rel="stylesheet" href="./skin/css/ace-skins.min.css">
	<link rel="stylesheet" href="./skin/css/ace-rtl.min.css">
	<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
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
	


</head>
<body class="font14 usercenter">
	<?php include display('public:header');?>
	<div class="wrap_1000 clearfix container">
		<?php include display('sidebar');?>		
		<div class="meal_con">
			<!-- 内容头部 -->
			<div class="meal_con_header">
				分店列表
			</div>
			<div class="meal_con_main">
					<table class="meal_con_main_table">
						<thead>
							<tr>
								<th>分店头像</th>
								<th>分店名称</th>
								<th>分店地址</th>
								<th>联系电话</th>
								<th>信息修改</th>
							</tr>
						</thead>
						<tbody>
							<?php if(!empty($store_physical)){ ?>
							<?php foreach($store_physical as $value){ ?>
							<tr class="meal_con_main_table_tr">
								<?php $array = explode(',', $value['images']); ?>
								<td><span class="avatar"><img class="meal_con_main_shop_logo" src="<?php echo $array[0];?>" width="60" height="60"></span></td>
								<td><div class="shopNameDiv"><?php echo $value['name'];?></div></td>
								<td><?php echo $value['address'];?></td>									
								<td><?php echo $value['phone1'];?>-<?php echo $value['phone2'];?></td>
								<td>
									<a style="width:80px;color:#07d;" title="编辑" target="_blank" href="<?php echo dourl('setting:store'); ?>#physical_store_edit/<?php echo $value['pigcms_id'];?>">编辑</a>
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
			<script type="text/javascript">
			$(function(){
				/*店铺状态*/
				updateStatus(".statusSwitch .ace-switch", ".statusSwitch", "OPEN", "CLOSED", "shopstatus");

				jQuery(document).on('click','#shopList a.red',function(){
					if(!confirm('确定要删除这条数据吗?不可恢复。')) return false;
				});
			});
			function CreateShop(){
				window.location.href = "{pigcms{:U('Config/store_add')}";
			}
			function updateStatus(dom1, dom2, status1, status2, attribute){
				$(dom1).each(function(){
					if($(this).attr("data-status")==status1){
						$(this).attr("checked",true);
					}else{
						$(this).attr("checked",false);
					}
					$(dom2).show();
				}).click(function(){
					var _this = $(this),
					type = 'open',
					id = $(this).attr("data-id");
					_this.attr("disabled",true);
		if(_this.attr("checked")){	//开启
			type = 'open';
		}else{		//关闭
			type = 'close';
		}
		$.ajax({
			url:"{pigcms{:U('Config/store_status')}",
			type:"post",
			data:{"type":type,"id":id,"status1":status1,"status2":status2,"attribute":attribute},
			dataType:"text",
			success:function(d){
				if(!d){		//失败
					if(type=='open'){
						_this.attr("checked",false);
					}else{
						_this.attr("checked",true);
					}
					bootbox.alert("操作失败");
				}
				_this.attr("disabled",false);
			}
		});
	});
			}
			</script>
			<script type="text/javascript" src="{pigcms{$static_public}js/artdialog/jquery.artDialog.js"></script>
			<script type="text/javascript" src="{pigcms{$static_public}js/artdialog/iframeTools.js"></script>
			<script type="text/javascript">
			$(function(){
				$('.see_qrcode').click(function(){
					art.dialog.open($(this).attr('href'),{
						init: function(){
							var iframe = this.iframe.contentWindow;
							window.top.art.dialog.data('iframe_handle',iframe);
						},
						id: 'handle',
						title:'查看渠道二维码',
						padding: 0,
						width: 430,
						height: 433,
						lock: true,
						resize: false,
						background:'black',
						button: null,
						fixed: false,
						close: null,
						left: '50%',
						top: '38.2%',
						opacity:'0.4'
					});
					return false;
				});
			});
			</script>
		</div>
	</div>
	<?php include display('public:footer');?>

</body>
</html>