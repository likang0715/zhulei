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
<div class="mainbox">
	<div id="nav" class="mainnav_title">
		<ul>
			<a href="<?php echo U('Store/package');?>" class="on">套餐列表</a>|
			<a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Store/package_add');?>','添加套餐',700,350,true,false,false,addbtn,'add',true);">添加套餐</a>
		</ul>
	</div>
	<table class="search_table" width="100%">
		<tr>
			<td>
				<form action="<?php echo U('Store/package');?>" method="get">
					<input type="hidden" name="c" value="Store"/>
					<input type="hidden" name="a" value="package"/>
					筛选: <input type="text" name="keyword" class="input-text" value="<?php echo ($_GET['keyword']); ?>"/>
					<select name="searchtype">
						<option value="name" <?php if($_GET['searchtype'] == 'name'): ?>selected="selected"<?php endif; ?>>名称</option>
						<option value="id" <?php if($_GET['searchtype'] == 'id'): ?>selected="selected"<?php endif; ?>>序号</option>
					</select>
					<input type="submit" value="查询" class="button"/>
				</form>
			</td>
		</tr>
	</table>
	<form name="myform" id="myform" action="" method="post">
		<div class="table-list">
			<table width="100%" cellspacing="0">
				<colpackage>
					<col/>
					<col/>
					<col/>
					<col/>
					<col/>
					<col/>
					<col width="180" align="center"/>
				</colpackage>
				<thead>
					<tr>
						<th>序号</th>
						<th>名称</th>
						<th>特权有效时间</th>
						<th>开店数量</th>
						<th>状态</th>
						<th class="textcenter">操作</th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($package_list)): if(is_array($package_list)): $i = 0; $__LIST__ = $package_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($vo["pigcms_id"]); ?></td>
									<td>
										<?php echo ($vo["name"]); ?>
										<?php if($vo['is_default'] == 1): ?><span style="color: red;">(初始权限)</span><?php endif; ?>
									</td>
								<?php if($vo['time'] == '0'): ?><td>永久</td>
								<?php else: ?>
								<td><?php echo ($vo["time"]); ?></td><?php endif; ?>
								<?php if($vo['store_nums'] == '0'): ?><td>不限</td>
								<?php else: ?>
									<td><?php echo ($vo["store_nums"]); ?></td><?php endif; ?>							
								<td class="textcenter">
									<!-- <?php if($vo['status'] == 1): ?><font color="green">正常</font><?php else: ?><font color="red">禁止</font><?php endif; ?> -->
									<span class="cb-enable status-enable"><label class="cb-enable <?php if($vo['status'] == 1): ?>selected<?php endif; ?>" data-id="<?php echo $vo['pigcms_id']; ?>"><span>启用</span><input type="radio" name="status" value="1" <?php if($vo['pigcms_id'] == 1): ?>checked="checked"<?php endif; ?> /></label></span>
									<span class="cb-disable status-disable"><label class="cb-disable <?php if($vo['status'] == 0): ?>selected<?php endif; ?>" data-id="<?php echo $vo['pigcms_id']; ?>"><span>禁用</span><input type="radio" name="status" value="0" <?php if($vo['pigcms_id'] == 0): ?>checked="checked"<?php endif; ?>/></label></span>
								</td>
								<td class="textcenter">
									<!-- <a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Store/package_menu',array('id'=>$vo['pigcms_id']));?>','显示列表设置',500,400,true,false,false,editbtn,'edit',true);">显示列表设置</a>
									&nbsp;|&nbsp; -->
									<a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Store/package_access',array('id'=>$vo['pigcms_id']));?>','修改权限',500,400,true,false,false,editbtn,'edit',true);">店铺权限</a>
									&nbsp;|&nbsp;
									<a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Store/package_edit',array('id'=>$vo['pigcms_id']));?>','编辑套餐',620,350,true,false,false,editbtn,'edit',true);">编辑</a>
									&nbsp;|&nbsp;
									<a href="javascript:void(0);" class="package_delete_row" parameter="id=<?php echo ($vo["pigcms_id"]); ?>" url="<?php echo U('Store/package_del');?>">删除</a>
									&nbsp;|&nbsp;
									<a href="javascript:void(0);" class="no_delete_row" parameter="id=<?php echo ($vo["pigcms_id"]); ?>" url="<?php echo U('Store/package_give');?>">赋予全体用户该套餐</a>
									&nbsp;|&nbsp;
									
									<?php if($vo['is_default'] == 1): ?><a href="javascript:void(0);" class="no_delete_row" parameter="id=<?php echo ($vo["pigcms_id"]); ?>" url="<?php echo U('Store/package_default_cancel');?>">取消默认套餐</a> 
									<?php else: ?>
										<a href="javascript:void(0);" class="no_delete_row" parameter="id=<?php echo ($vo["pigcms_id"]); ?>" url="<?php echo U('Store/package_default');?>">设置默认套餐</a><?php endif; ?>
							
								</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						<tr><td class="textcenter pagebar" colspan="9"><?php echo ($pagebar); ?></td></tr>
					<?php else: ?>
						<tr><td class="textcenter red" colspan="8">列表为空！</td></tr><?php endif; ?>
				</tbody>
			</table>
		</div>
	</form>
</div>
<script type="text/javascript">
$(function(){
	//是否启用
	$('.status-enable > .cb-enable').click(function(){
		if (!$(this).hasClass('selected')) {
			var package_id = $(this).data('id');
			$.post("<?php echo U('Store/package_status'); ?>",{'status': 1, 'package_id': package_id}, function(data){})
		}
	});

	$('.status-disable > .cb-disable').click(function(){
		if (!$(this).hasClass('selected')) {
			var package_id = $(this).data('id');
			if (!$(this).hasClass('selected')) {
				$.post("<?php echo U('Store/package_status'); ?>", {'status': 0, 'package_id': package_id}, function (data) {})
			}
		}
	});


	//删除行
	$('.no_delete_row').click(function(){
		var now_dom = $(this);
		window.top.art.dialog({
			icon: 'question',
			title: '请确认',
			id: 'msg' + Math.random(),
			lock: true,
			fixed: true,
			opacity:'0.4',
			resize: false,
			content: '你确定这样操作吗？操作后不能恢复！',
			ok:function (){
				$.post(now_dom.attr('url'),now_dom.attr('parameter'),function(result){
					if(result.status == 1){
						window.top.msg(1,result.info,true);				
						window.top.main_refresh();
					}else{
						window.top.msg(0,result.info);
					}
				});
			},
			cancel:true
		});
		return false;
	});

	//删除行
	$('.package_delete_row').click(function(){
		var now_dom = $(this);
		window.top.art.dialog({
			icon: 'question',
			title: '请确认',
			id: 'msg' + Math.random(),
			lock: true,
			fixed: true,
			opacity:'0.4',
			resize: false,
			content: '你确定这样操作吗？操作后该套餐店铺权限会失效，店铺拥有全部权限！',
			ok:function (){
				$.post(now_dom.attr('url'),now_dom.attr('parameter'),function(result){
					if(result.status == 1){
						window.top.msg(1,result.info,true);				
						if(now_dom.closest('table').find('tr').size()>3){
							now_dom.closest('tr').remove();
							$('#row_count').html(parseInt($('#row_count').html())-1);
						}else{
							window.top.main_refresh();
						}
					}else{
						window.top.msg(0,result.info);
					}
				});
			},
			cancel:true
		});
		return false;
	});
})
</script>
	</body>
</html>