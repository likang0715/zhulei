<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Store/tag_edit')}" frame="true" refresh="true">
		<input type="hidden" name="id" value="{pigcms{$store_tag['tag_id']}" >
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="30%">名称</th>
				<td width="70%"><input type="text" class="input fl" name="name" size="20" validate="maxlength:20,required:true" value="{pigcms{$store_tag['name']}" /></td>
			</tr>		
			<tr>
				<th width="30%">排序</th>
				<td width="70%"><input type="text" class="input fl" name="order_by" size="5" validate="maxlength:20,number:true" value="{pigcms{$store_tag['order_by']}" tips="填数字，越小越排前面" /></td>
			</tr>
			<tr>
				<th width="30%">状态</th>
				<td width="70%" class="radio_box">  
                    <span class="cb-enable"><label class="cb-enable <if condition="$store_tag['status'] eq 1">selected</if>"><span>启用</span><input type="radio" name="status" value="1"  <if condition="$store_tag['status'] eq 1">checked="checked"</if>/></label></span>
					<span class="cb-disable"><label class="cb-disable <if condition="$store_tag['status'] eq 0">selected</if>"><span>禁止</span><input type="radio" name="status" value="0"  <if condition="$store_tag['status'] eq 0">checked="checked"</if>/></label></span>

                </td>
			</tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<include file="Public:footer"/>