<include file="Public:header"/>
<div class="mainbox">
	<div id="nav" class="mainnav_title">
		<ul>
			<a href="{pigcms{:U('Admin/group')}" class="on">管理员组列表</a>|
			<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Admin/group_add')}','添加管理组',700,160,true,false,false,addbtn,'add',true);">添加管理组</a>
		</ul>
	</div>
	<table class="search_table" width="100%">
		<tr>
			<td>
				<form action="{pigcms{:U('Admin/group')}" method="get">
					<input type="hidden" name="c" value="Admin"/>
					<input type="hidden" name="a" value="group"/>
					筛选: <input type="text" name="keyword" class="input-text" value="{pigcms{$_GET['keyword']}"/>
					<select name="searchtype">
						<option value="id" <if condition="$_GET['searchtype'] eq 'id'">selected="selected"</if>>组ID</option>
						<option value="name" <if condition="$_GET['searchtype'] eq 'name'">selected="selected"</if>>名称</option>
					</select>
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
					<col width="180" align="center"/>
				</colgroup>
				<thead>
					<tr>
						<th>ID</th>
						<th>组名</th>
						<th>组员数量</th>
						<th>备注</th>
						<th>添加时间</th>
						<th>修改时间</th>
						<th>状态</th>
						<th class="textcenter">操作</th>
					</tr>
				</thead>
				<tbody>
					<if condition="is_array($group_list)">
						<volist name="group_list" id="vo">
							<tr>
								<td>{pigcms{$vo.id}</td>
								<td>{pigcms{$vo.name}</td>
								<td>{pigcms{$vo.count}</td>
								<td>
									<if condition="$vo.remark eq ''"> 无 <else/> {pigcms{$vo.remark} </if>
								</td>
								<td>{pigcms{$vo.add_time|date='Y-m-d H:i:s',###}</td>
								<td>
									<if condition="$vo.update_time eq 0">
										无
									<else/>
										{pigcms{$vo.update_time|date='Y-m-d H:i:s',###}
									</if>
								</td>
								<td class="textcenter">
									<!-- <if condition="$vo['status'] eq 1"><font color="green">正常</font><else/><font color="red">禁止</font></if> -->
									<span class="cb-enable status-enable"><label class="cb-enable <if condition="$vo['status'] eq 1">selected</if>" data-id="<?php echo $vo['id']; ?>"><span>启用</span><input type="radio" name="status" value="1" <if condition="$vo['id'] eq 1">checked="checked"</if> /></label></span>
									<span class="cb-disable status-disable"><label class="cb-disable <if condition="$vo['status'] eq 0">selected</if>" data-id="<?php echo $vo['id']; ?>"><span>禁用</span><input type="radio" name="status" value="0" <if condition="$vo['id'] eq 0">checked="checked"</if>/></label></span>
								</td>
								<td class="textcenter">
									<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Admin/group_menu',array('id'=>$vo['id']))}','显示列表设置',500,400,true,false,false,editbtn,'edit',true);">显示列表设置</a>
									&nbsp;|&nbsp;
									<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Admin/group_access',array('id'=>$vo['id']))}','修改组权限',500,400,true,false,false,editbtn,'edit',true);">权限管理</a>
									&nbsp;|&nbsp;
									<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Admin/group_edit',array('id'=>$vo['id']))}','编辑管理员组',620,160,true,false,false,editbtn,'edit',true);">编辑</a>
									&nbsp;|&nbsp;
									<a href="javascript:void(0);" class="delete_row" parameter="id={pigcms{$vo.id}" url="{pigcms{:U('Admin/group_del')}">删除</a>
								</td>
							</tr>
						</volist>
						<tr><td class="textcenter pagebar" colspan="9">{pigcms{$pagebar}</td></tr>
					<else/>
						<tr><td class="textcenter red" colspan="8">列表为空！</td></tr>
					</if>
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
			var group_id = $(this).data('id');
			$.post("<?php echo U('Admin/group_status'); ?>",{'status': 1, 'group_id': group_id}, function(data){})
		}
	});

	$('.status-disable > .cb-disable').click(function(){
		if (!$(this).hasClass('selected')) {
			var group_id = $(this).data('id');
			if (!$(this).hasClass('selected')) {
				$.post("<?php echo U('Admin/group_status'); ?>", {'status': 0, 'group_id': group_id}, function (data) {})
			}
		}
	});
})
</script>
<include file="Public:footer"/>