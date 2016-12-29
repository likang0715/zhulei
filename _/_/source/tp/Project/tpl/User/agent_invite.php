<include file="Public:header"/>
<form id="myform" method="post" action="{pigcms{:U('User/agent_invite')}" frame="true" refresh="true">
	<input type="hidden" name="uid" value="{pigcms{$user['uid']}">
	<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
		<tr>
			<th width="15%">ID</th>
			<td width="35%"><div style="height:24px;line-height:24px;">{pigcms{$user['uid']}</div></td>
			<th width="15%">用户名</th>
			<td width="35%"><div style="height:24px;line-height:24px;">{pigcms{$user['nickname']}</div></td>
		</tr>
		<tr>
			<th width="15%">手机号</th>
			<td width="35%"><div style="height:24px;line-height:24px;">{pigcms{$user['phone']}</div></td>
			<th width="15%">状态</th>
			<td width="35%" class="radio_box">
				<if condition="$user['status'] eq 1"> 正常 <else/> 禁止 </if>
			</td>
		</tr>
		<tr>
			<th width="15%">注册时间</th>
			<td width="35%">
				<div style="height:24px;line-height:24px;">{pigcms{$user.reg_time|date='Y-m-d H:i:s',###}</div>
			</td>
			<th width="15%">最后访问时间</th>
			<td width="35%">
				<div style="height:24px;line-height:24px;">{pigcms{$user.last_time|date='Y-m-d H:i:s',###}</div>
			</td>
		</tr>
		<tr>
			<th width="15%">关联客户经理(代理商)</th>
			<td width="35%" colspan="3">
				<select name="invite_admin" style="width:200px;" validate="required:true">
					<option value="">--请选择--</option>
					<volist name="agent_list" id="vo">
						<option value="{pigcms{$vo['id']}" <if condition="$user['invite_admin'] eq $vo['id']">selected=selected</if>>{pigcms{$vo['account']}</option>
					</volist>
				</select>
			</td>
		</tr>
	</table>
	<div class="btn hidden">
		<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
		<input type="reset" value="取消" class="button" />
	</div>
</form>
<include file="Public:footer"/>