<include file="Public:header"/>
<form id="myform" method="post" action="{pigcms{:U('Admin/admin_add')}" frame="true" refresh="true">
	<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
		<tr>
			<th width="15%">用户名</th>
			<td width="35%"><input type="text" class="input fl" name="account" size="20" validate="maxlength:20,required:true" value=""/></td>
			<th width="15%">状态</th>
			<td width="35%" class="radio_box">
				<span class="cb-enable"><label class="cb-enable selected"><span>正常</span><input type="radio" name="status" value="1" checked="checked"/></label></span>
				<span class="cb-disable"><label class="cb-disable"><span>禁止</span><input type="radio" name="status" value="0" /></label></span>
			</td>
		</tr>
		<tr>
			<th width="15%">密码</th>
			<td width="35%"><input type="password" class="input fl" name="pwd" size="20" value="" validate="required:true"/></td>
			<th width="15%">重复密码</th>
			<td width="35%"><input type="password" class="input fl" name="repwd" size="20" value="" validate="required:true"/></td>
		</tr>
		<tr>
			<th width="15%">所属管理员组</th>
			<td width="35%">
				<select name="group_id" validate="required:true">
					<option value="">--请选择--</option>
					<volist name="group_list" id="vo">
						<option value="{pigcms{$vo['id']}">{pigcms{$vo['name']}</option>
					</volist>
				</select>
			</td>
			<th width="15%">真实姓名</th>
			<td width="35%"><input type="text" class="input fl" name="realname" size="20" validate="maxlength:20" value=""/></td>
		</tr>
		<tr>
			<th width="15%">邮箱</th>
			<td width="35%"><input type="text" class="input fl" name="email" size="20" validate="email:true" value=""/></td>
			<th width="15%">电话</th>
			<td width="35%"><input type="text" class="input fl" name="phone" size="20" validate="number:true" value=""/></td>
		</tr>
		<tr>
			<th width="15%">QQ</th>
			<td width="35%"><input type="text" class="input fl" name="qq" size="20" validate="number:true" value=""/></td>
			<th width="15%">&nbsp;</th>
			<td width="35%">&nbsp;</td>
		</tr>
	</table>
	<div class="btn hidden">
		<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
		<input type="reset" value="取消" class="button" />
	</div>
</form>
<include file="Public:footer"/>