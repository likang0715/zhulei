<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Admin/group_edit')}" frame="true" refresh="true">
		<input type="hidden" name="id" value="{pigcms{$group['id']}" >
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="30%">组名</th>
				<td width="70%"><input type="text" class="input fl" name="name" size="20" validate="maxlength:20,required:true" value="{pigcms{$group['name']}"/></td>
			</tr>
			<tr>
				<th width="30%">状态</th>
				<td width="70%" class="radio_box">
					<span class="cb-enable"><label class="cb-enable <if condition="$group['status'] eq 1">selected</if>"><span>正常</span><input type="radio" name="status" value="1"  <if condition="$group['status'] eq 1">checked="checked"</if>/></label></span>
					<span class="cb-disable"><label class="cb-disable <if condition="$group['status'] eq 0">selected</if>"><span>禁止</span><input type="radio" name="status" value="0"  <if condition="$group['status'] eq 0">checked="checked"</if>/></label></span>
				</td>
			</tr>
			<tr>
				<th width="30%">备注</th>
				<td width="70%"><input type="text" class="input fl" name="remark" size="50" validate="maxlength:50" value="{pigcms{$group['remark']}"/></td>
			</tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<include file="Public:footer"/>