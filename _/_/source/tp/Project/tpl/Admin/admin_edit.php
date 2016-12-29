<include file="Public:header"/>
<form id="myform" method="post" action="{pigcms{:U('Admin/admin_edit')}" frame="true" refresh="true">
	<input type="hidden" name="id" value="{pigcms{$admin.id}">
	<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
		<tr>
			<th width="15%">用户名</th>
			<td width="35%"><input type="text" class="input fl" name="account" size="20" validate="maxlength:20,required:true" value="{pigcms{$admin.account}"/></td>
			<th width="15%">状态</th>
			<td width="35%" class="radio_box">
				<span class="cb-enable"><label class="cb-enable <if condition="$admin['status'] eq 1">selected</if>"><span>正常</span><input type="radio" name="status" value="1"  <if condition="$admin['status'] eq 1">checked="checked"</if>/></label></span>
				<span class="cb-disable"><label class="cb-disable <if condition="$admin['status'] eq 0">selected</if>"><span>禁止</span><input type="radio" name="status" value="0"  <if condition="$admin['status'] eq 0">checked="checked"</if>/></label></span>
			</td>
		</tr>
		<tr>
			<th width="15%">密码</th>
			<td width="35%"><input type="password" class="input fl" name="pwd" size="20" value="" placeholder="不修改则不填写" tips="不修改则不填写"/></td>
			<th width="15%">所属管理员组</th>
			<td width="35%">
				<select name="group_id" validate="required:true">
					<option value="">--请选择--</option>
					<volist name="group_list" id="vo">
						<option value="{pigcms{$vo['id']}" <if condition="$vo.id eq $admin['group_id']">selected=selected</if>>{pigcms{$vo['name']}</option>
					</volist>
				</select>
			</td>
		</tr>
		<tr>
			<th width="15%">真实姓名</th>
			<td width="35%"><input type="text" class="input fl" name="realname" size="20" validate="maxlength:20" value="{pigcms{$admin.realname}"/></td>
			<th width="15%">电话</th>
			<td width="35%"><input type="text" class="input fl" name="phone" size="20" validate="number:true" value="{pigcms{$admin.phone}"/></td>
		</tr>
		<tr>
			<th width="15%">邮箱</th>
			<td width="35%"><input type="text" class="input fl" name="email" size="20" validate="email:true" value="{pigcms{$admin.email}"/></td>
			<th width="15%">QQ</th>
			<td width="35%"><input type="text" class="input fl" name="qq" size="20" validate="number:true" value="{pigcms{$admin.qq}"/></td>
		</tr>
	</table>
	<div class="btn hidden">
		<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
		<input type="reset" value="取消" class="button" />
	</div>
</form>
<include file="Public:footer"/>