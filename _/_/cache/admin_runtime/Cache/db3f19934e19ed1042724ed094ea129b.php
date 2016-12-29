<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/html"><head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo C('DEFAULT_CHARSET');?>" />
		<title>网站后台管理 Powered by pigcms.com</title>
		<script type="text/javascript">
			<!--if(self==top){window.top.location.href="<?php echo U('Index/index');?>";}-->
			var kind_editor=null,static_public="<?php echo ($static_public); ?>",static_path="<?php echo ($static_path); ?>",system_index="<?php echo U('Index/index');?>",choose_province="<?php echo U('Area/ajax_province');?>",choose_city="<?php echo U('Area/ajax_city');?>",choose_area="<?php echo U('Area/ajax_area');?>",choose_circle="<?php echo U('Area/ajax_circle');?>",choose_map="<?php echo U('Map/frame_map');?>",get_firstword="<?php echo U('Words/get_firstword');?>",frame_show=<?php if($_GET['frame_show']): ?>true<?php else: ?>false<?php endif; ?>;
		</script>
		<link rel="stylesheet" type="text/css" href="<?php echo ($static_path); ?>css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo ($static_path); ?>css/jquery.ui.css" />
		<script type="text/javascript" src="<?php echo C('JQUERY_FILE');?>"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/plugin/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.form.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.validate.js"></script>
		<script type="text/javascript" src="/static/js/date/WdatePicker.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.colorpicker.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/common.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/date.js"></script>
			<?php if($withdrawal_count > 0): ?><script type="text/javascript">
					$(function(){
						$('#nav_4 > dd > #leftmenu_Order_withdraw', parent.document).html('提现记录 <label style="color:red">(' + <?php echo ($withdrawal_count); ?> + ')</label>')
					})
				</script><?php endif; ?>
			<?php if($unprocessed > 0): ?><script type="text/javascript">
					$(function(){
						if ($('#leftmenu_Credit_returnRecord', parent.document).length > 0) {
							var menu_html = $('#leftmenu_Credit_returnRecord', parent.document).html();
							menu_html = menu_html.split('(')[0];
							menu_html += ' <label style="color:red">(<?php echo ($unprocessed); ?>)</label>';
							$('#leftmenu_Credit_returnRecord', parent.document).html(menu_html);
						}
					})
				</script><?php endif; ?>
		</head>
		<body width="100%" 
		<?php if($bg_color): ?>style="background:<?php echo ($bg_color); ?>;"<?php endif; ?>
> 
		<style type="text/css">
			.c-gray {
				color: #999;
			}
			.table-list tfoot tr {
				height: 40px;
			}
			.green {
				color: green;
			}
			a, a:hover{
				text-decoration: none;
			}
			.click_show{color: #498CD0;}
		</style>
<script type="text/javascript">
	$(function() {
		$('.status-enable > .cb-enable').click(function(){
			if (!$(this).hasClass('selected') ) {
				var url = window.location.href;
				var id = $(this).data('id');
				$.post("<?php echo U('Tag/status'); ?>",{'status': 1, 'id': id}, function(data){
					window.location.href = url;
				})

			}
			if (parseFloat($(this).data('status')) == 0) {
				$(this).removeClass('selected');
			}
			return false;
		})
		$('.status-disable > .cb-disable').click(function(){
			if (!$(this).hasClass('selected') && parseFloat($(this).data('status')) == 1) {
				var url = window.location.href;
				var id = $(this).data('id');
				if (!$(this).hasClass('selected')) {
					$.post("<?php echo U('Tag/status'); ?>", {'status': 0, 'id': id}, function (data) {
						window.location.href = url;
					})
				}
			}
			return false;
		})
	})
</script>
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="<?php echo U('Tag/index');?>" class="on">商城TAG列表</a>|
					<a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Tag/add');?>','添加商城TAG',480,310,true,false,false,addbtn,'add',true);">添加商城TAG</a>
				</ul>
			</div>
			<table class="search_table" width="100%">
				<tr>
					<td>
						<form action="<?php echo U('Tag/index');?>" method="get">
							<input type="hidden" name="c" value="Property"/>
							<input type="hidden" name="a" value="property"/>
						</form>
					</td>
				</tr>
			</table>

			<div class="table-list">
				<table width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>修改</th>
							<th>编号</th>
							<th>属性类别</th>
							<th>属性名称</th>
							<th>状态</th>
							<th class="textcenter" width="100">操作</th>
						</tr>
					</thead>
					<tbody>
						<?php  if (count($tag_list) > 0) { foreach ($tag_list as $tag) { ?>
								<tr class="propertys_tr">
									<td class="first_td">
										<a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Tag/edit', array('id' => $tag['id']));?>','修改TAG - <?php echo ($tag["name"]); ?>',480,310,true,false,false,editbtn,'edit',true);"><img src="<?php echo ($static_path); ?>images/icon_edit.png" width="18" title="修改" alt="修改" /></a></td>
									<td><?php echo $tag['id'] ?></td>
									<td><?php echo $tag['type_name'] ?></td>
									<td>
										<a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Tag/edit', array('id' => $tag['id']));?>','修改TAG - <?php echo ($tag["name"]); ?>',480,310,true,false,false,editbtn,'edit',true);"><?php echo $tag['name'] ?></a>
									</td>
									<td>
										<?php if($tag['status'] == 1): ?><span class="green">启用</span><?php else: ?><span class="red">禁用</span><?php endif; ?>
									</td>
									<td class="end_td">
										<span class="cb-enable status-enable" data-id="<?php echo $tag['id'] ?>" ><label class="cb-enable <?php if($tag['status'] == 1): ?>selected<?php endif; ?>" data-id="<?php echo $tag['id']; ?>" data-status="<?php echo $tag['status'] ?>"><span>启用</span><input type="radio" name="status" value="1" <?php if($tag['status'] == 1): ?>checked="checked"<?php endif; ?> /></label></span>
										<span class="cb-disable status-disable" data-id="<?php echo $tag['id'] ?>" ><label class="cb-disable <?php if($tag['status'] == 0): ?>selected<?php endif; ?>" data-id="<?php echo $tag['id']; ?>"data-status="<?php echo $tag['status'] ?>"><span>禁用</span><input type="radio" name="status" value="0" <?php if($tag['status'] == 0): ?>checked="checked"<?php endif; ?>/></label></span>
									</td>
								</tr>
						<?php  } } ?>
					</tbody>
					<tfoot>
						<?php if(is_array($tag_list)): ?><tr>
							<td class="textcenter pagebar" colspan="7"><?php echo ($page); ?></td>
						</tr>
						<?php else: ?>
						<tr><td class="textcenter red" colspan="7">列表为空！</td></tr><?php endif; ?>
					</tfoot>
				</table>
			</div>
		</div>

<style>
.select-property-tr{  background-color:#3a6ea5;  }
.table-list  .select-property-tr td{padding-left:0px;}
.select-property td{border-top:3px solid #CC5522;background:#e2d7ea}
.select-property .first_td{border-left:3px solid #cc5522}
.select-property .end_td{border-right:3px solid #cc5522}
.property_value th,.property_value td{text-align: center}
.table-list .property_value  tbody td{float:none;text-align: center}
</style>
<script>
$(".show_value").click(function(){
	var property_index = $(".show_value").index($(this));
	//每次点击初始化
	$(".property_value").removeClass("select-property-tr");
	$(".propertys_tr").removeClass("select-property");
	$(".property_value").hide();



	//每次点击new效果
	$(".propertys_tr").eq(property_index).addClass("select-property");

	$(".property_value").eq(property_index).addClass("select-property-tr");


	$(".property_value").eq(property_index).show();
})
</script>
	</body>
</html>