<include file="Public:header"/>
<div class="mainbox">
	<div id="nav" class="mainnav_title">
		<ul>
			<a href="{pigcms{:U('Admin/area')}" class="on">区域管理员列表</a>|
			<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Admin/area_add')}','添加区域管理',800,320,true,false,false,addbtn,'add',true);">区域管理添加</a>
		</ul>
	</div>
	<table class="search_table" width="100%">
		<tr>
			<td>
				<form action="{pigcms{:U('Admin/area')}" method="get">
					<input type="hidden" name="c" value="Admin"/>
					<input type="hidden" name="a" value="area"/>
					筛选: <input type="text" name="keyword" class="input-text" value="{pigcms{$_GET['keyword']}"/>
					<select name="searchtype">
						<option value="id" <if condition="$_GET['searchtype'] eq 'id'">selected="selected"</if>>管理员ID</option>
						<option value="account" <if condition="$_GET['searchtype'] eq 'account'">selected="selected"</if>>管理员名称</option>
					</select>
					<if condition="$admin_user['type'] neq 2">
						&nbsp; 区域等级 &nbsp;
						<select name="area_level">
							<option value="">全部</option>
							<option value="1" <if condition="$_GET['area_level'] eq 1">selected="selected"</if>>省级</option>
							<option value="2" <if condition="$_GET['area_level'] eq 2">selected="selected"</if>>城市级</option>
							<option value="3" <if condition="$_GET['area_level'] eq 3">selected="selected"</if>>区县级</option>
						</select>
					</if>
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
					<if condition="is_array($admin_list)">
						<volist name="admin_list" id="vo">
							<tr>
								<td>{pigcms{$vo.id}</td>
								<td>{pigcms{$vo.account}</td>
								<td>
									<if condition="$vo['group_status'] eq 1">
										<span style="color:green">{pigcms{$vo.group_name}</span>
									<else/>
										<del style="color:gray">{pigcms{$vo.group_name}</del>
									</if>
								</td>
								<td>
									<if condition="$vo['area_level'] eq 1">
										<span style="background:#00868b;color:#fff;padding:3px 5px;">省级</span>
									<elseif condition="$vo['area_level'] eq 2" />
										<span style="background:#00bfff;color:#fff;padding:3px 5px;">市级</span>
									<elseif condition="$vo['area_level'] eq 3" />
										<span style="background:#7ec0ee;color:#fff;padding:3px 5px;">区县级</span>
									</if>
								</td>
								<td>{pigcms{$vo.province_txt}</td>
								<td>{pigcms{$vo.city_txt}</td>
								<td>{pigcms{$vo.county_txt}</td>
								<td>
									<if condition="$vo['last_time'] neq 0">
										{pigcms{$vo.last_time|date='Y-m-d H:i:s',###}
									<else/>
										未登录
									</if>
								</td>
								<td>{pigcms{$vo.last_ip_txt}</td>
								<td>{pigcms{$vo.login_count}</td>
								<td>
									<span style="color:green">{pigcms{$vo.reward_total}</span>
									-
									<span style="color:red">{pigcms{$vo.reward_balance}</span>
								</td>
								<td class="textcenter">{pigcms{$vo.store_count}</td>
								<td class="textcenter">
									<!-- <if condition="$vo['status'] eq 1"><font color="green">正常</font><else/><font color="red">禁止</font></if> -->
									<span class="cb-enable status-enable"><label class="cb-enable <if condition="$vo['status'] eq 1">selected</if>" data-id="<?php echo $vo['id']; ?>"><span>启用</span><input type="radio" name="status" value="1" <if condition="$vo['id'] eq 1">checked="checked"</if> /></label></span>
									<span class="cb-disable status-disable"><label class="cb-disable <if condition="$vo['status'] eq 0">selected</if>" data-id="<?php echo $vo['id']; ?>"><span>禁用</span><input type="radio" name="status" value="0" <if condition="$vo['id'] eq 0">checked="checked"</if>/></label></span>
								</td>
								<td class="textcenter">
									<if condition="$vo.type neq 0">
										<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Admin/area_edit',array('id'=>$vo['id']))}','编辑区域管理员',800,330,true,false,false,editbtn,'edit',true);">编辑</a> |
										<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Admin/send_reward',array('id'=>$vo['id']))}','发送奖金',700,200,true,false,false,editbtn,'edit',true);">发送奖金</a>
									</if>
								</td>
							</tr>
						</volist>
						<tr><td class="textcenter pagebar" colspan="14">{pigcms{$pagebar}</td></tr>
					<else/>
						<tr><td class="textcenter red" colspan="14">列表为空！</td></tr>
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
<include file="Public:footer"/>