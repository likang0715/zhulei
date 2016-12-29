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
			<a href="<?php echo U('Admin/area');?>" class="on">区域管理员列表</a>|
			<a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Admin/area_add');?>','添加区域管理',800,320,true,false,false,addbtn,'add',true);">区域管理添加</a>
		</ul>
	</div>
	<table class="search_table" width="100%">
		<tr>
			<td>
				<form action="<?php echo U('Admin/area');?>" method="get">
					<input type="hidden" name="c" value="Admin"/>
					<input type="hidden" name="a" value="area"/>
					筛选: <input type="text" name="keyword" class="input-text" value="<?php echo ($_GET['keyword']); ?>"/>
					<select name="searchtype">
						<option value="id" <?php if($_GET['searchtype'] == 'id'): ?>selected="selected"<?php endif; ?>>管理员ID</option>
						<option value="account" <?php if($_GET['searchtype'] == 'account'): ?>selected="selected"<?php endif; ?>>管理员名称</option>
					</select>
					<?php if($admin_user['type'] != 2): ?>&nbsp; 区域等级 &nbsp;
						<select name="area_level">
							<option value="">全部</option>
							<option value="1" <?php if($_GET['area_level'] == 1): ?>selected="selected"<?php endif; ?>>省级</option>
							<option value="2" <?php if($_GET['area_level'] == 2): ?>selected="selected"<?php endif; ?>>城市级</option>
							<option value="3" <?php if($_GET['area_level'] == 3): ?>selected="selected"<?php endif; ?>>区县级</option>
						</select><?php endif; ?>
					<input type="submit" value="查询" class="button"/>
				</form>
			</td>
		</tr>
	</table>
	<form name="myform" id="myform" action="" method="post">
		<div class="table-list">
			<table width="100%" cellspacing="0">
				<colgroup>
					<col/>
					<col/>
					<col/>
					<col/>
					<col/>
					<col/>
					<col/>
					<col/>
					<col/>
					<col/>
					<col/>
					<col/>
					<col/>
					<col width="180" align="center"/>
				</colgroup>
				<thead>
					<tr>
						<th>ID</th>
						<th>账号</th>
						<th>所属组</th>
						<th>类别</th>
						<th>所属省份</th>
						<th>所属城市</th>
						<th>所属区县</th>
						<th>最后登录时间</th>
						<th>最后登录IP</th>
						<th>登录次数</th>
						<th>推广奖励(总金额-未发送)</th>
						<th class="textcenter">店铺数量</th>
						<th>状态</th>
						<th class="textcenter">操作</th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($admin_list)): if(is_array($admin_list)): $i = 0; $__LIST__ = $admin_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($vo["id"]); ?></td>
								<td><?php echo ($vo["account"]); ?></td>
								<td>
									<?php if($vo['group_status'] == 1): ?><span style="color:green"><?php echo ($vo["group_name"]); ?></span>
									<?php else: ?>
										<del style="color:gray"><?php echo ($vo["group_name"]); ?></del><?php endif; ?>
								</td>
								<td>
									<?php if($vo['area_level'] == 1): ?><span style="background:#00868b;color:#fff;padding:3px 5px;">省级</span>
									<?php elseif($vo['area_level'] == 2): ?>
										<span style="background:#00bfff;color:#fff;padding:3px 5px;">市级</span>
									<?php elseif($vo['area_level'] == 3): ?>
										<span style="background:#7ec0ee;color:#fff;padding:3px 5px;">区县级</span><?php endif; ?>
								</td>
								<td><?php echo ($vo["province_txt"]); ?></td>
								<td><?php echo ($vo["city_txt"]); ?></td>
								<td><?php echo ($vo["county_txt"]); ?></td>
								<td>
									<?php if($vo['last_time'] != 0): echo (date('Y-m-d H:i:s',$vo["last_time"])); ?>
									<?php else: ?>
										未登录<?php endif; ?>
								</td>
								<td><?php echo ($vo["last_ip_txt"]); ?></td>
								<td><?php echo ($vo["login_count"]); ?></td>
								<td>
									<span style="color:green"><?php echo ($vo["reward_total"]); ?></span>
									-
									<span style="color:red"><?php echo ($vo["reward_balance"]); ?></span>
								</td>
								<td class="textcenter"><?php echo ($vo["store_count"]); ?></td>
								<td class="textcenter">
									<!-- <?php if($vo['status'] == 1): ?><font color="green">正常</font><?php else: ?><font color="red">禁止</font><?php endif; ?> -->
									<span class="cb-enable status-enable"><label class="cb-enable <?php if($vo['status'] == 1): ?>selected<?php endif; ?>" data-id="<?php echo $vo['id']; ?>"><span>启用</span><input type="radio" name="status" value="1" <?php if($vo['id'] == 1): ?>checked="checked"<?php endif; ?> /></label></span>
									<span class="cb-disable status-disable"><label class="cb-disable <?php if($vo['status'] == 0): ?>selected<?php endif; ?>" data-id="<?php echo $vo['id']; ?>"><span>禁用</span><input type="radio" name="status" value="0" <?php if($vo['id'] == 0): ?>checked="checked"<?php endif; ?>/></label></span>
								</td>
								<td class="textcenter">
									<?php if($vo["type"] != 0): ?><a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Admin/area_edit',array('id'=>$vo['id']));?>','编辑区域管理员',800,330,true,false,false,editbtn,'edit',true);">编辑</a> |
										<a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Admin/send_reward',array('id'=>$vo['id']));?>','发送奖金',700,200,true,false,false,editbtn,'edit',true);">发送奖金</a><?php endif; ?>
								</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						<tr><td class="textcenter pagebar" colspan="14"><?php echo ($pagebar); ?></td></tr>
					<?php else: ?>
						<tr><td class="textcenter red" colspan="14">列表为空！</td></tr><?php endif; ?>
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
			var admin_id = $(this).data('id');
			$.post("<?php echo U('Admin/admin_status'); ?>",{'status': 1, 'admin_id': admin_id}, function(data){})
		}
	});

	$('.status-disable > .cb-disable').click(function(){
		if (!$(this).hasClass('selected')) {
			var admin_id = $(this).data('id');
			if (!$(this).hasClass('selected')) {
				$.post("<?php echo U('Admin/admin_status'); ?>", {'status': 0, 'admin_id': admin_id}, function (data) {})
			}
		}
	});
})
</script>
	</body>
</html>