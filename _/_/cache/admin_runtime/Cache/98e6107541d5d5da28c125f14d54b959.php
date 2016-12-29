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
.c-gray { color: #999; }
.table-list tfoot tr { height: 40px; }
.green { color: green; }
a, a:hover { text-decoration: none; }
</style>

<div class="mainbox">
	<div id="nav" class="mainnav_title">
		<ul>
			<a href="<?php echo U('Physical/chcate');?>" class="on">茶会分类</a>| <a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Physical/chcate_add');?>','添加分类',600,500,true,false,false,addbtn,'add',true);">添加分类</a>
		</ul>
	</div>
	
	<div class="table-list">
		<table width="100%" cellspacing="0">
			<thead>
				<tr>
					<th>删除 | 修改</th>
					<th>编号</th>
					<th>名称</th>
					<th>描述</th>
					<th>状态</th>
					<th>排序</th>
					
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($categories)): if(is_array($categories)): $i = 0; $__LIST__ = $categories;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$category): $mod = ($i % 2 );++$i;?><tr>
							<td><a url="<?php echo U('Physical/chcate_del', array('id' => $category['cat_id'])); ?>"  class="delete_row"><img src="<?php echo ($static_path); ?>images/icon_delete.png" width="18" title="删除" alt="删除" /></a> | <a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Physical/chcate_edit', array('id' => $category['cat_id']));?>','修改分类 - <?php echo ($category["cat_name"]); ?>',540,<?php if($category['cat_pic']): ?>500<?php else: ?>500<?php endif; ?>,true,false,false,editbtn,'edit',true);"><img src="<?php echo ($static_path); ?>images/icon_edit.png" width="18" title="修改" alt="修改" /></a></td>
							<td><?php echo ($category["cat_id"]); ?></td>
							<td><a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Physical/chcate_edit', array('id' => $category['cat_id']));?>','修改分类 - <?php echo ($category["cat_name"]); ?>',600,<?php if($category['cat_pic']): ?>500<?php else: ?>500<?php endif; ?>,true,false,false,editbtn,'edit',true);"><?php if ($category['cat_level'] > 1){ echo str_repeat('|——', $category['cat_level']); } ?> <span <?php if ($category['cat_level'] == 1){ ?>style="font-weight: bold;" <?php } ?>><?php echo ($category["cat_name"]); ?></span></a></td>
							<td><?php echo ($category["cat_desc"]); ?></td>
							<td><span class="green"><?php if($category['cat_status'] == 1): ?><span class="green">启用</span><?php else: ?><span class="red">禁用</span><?php endif; ?></span></td>
							<td><?php echo ($category["cat_sort"]); ?></td>
						
						</tr><?php endforeach; endif; else: echo "" ;endif; endif; ?>
			</tbody>
			<tfoot>
				<?php if(is_array($categories)): ?><tr>
						<td class="textcenter pagebar" colspan="7"><?php echo ($page); ?></td>
					</tr>
					<?php else: ?>
					<tr>
						<td class="textcenter red" colspan="7">列表为空！</td>
					</tr><?php endif; ?>
			</tfoot>
		</table>
	</div>
</div>
	</body>
</html>