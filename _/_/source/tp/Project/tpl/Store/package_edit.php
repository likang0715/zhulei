<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Store/package_edit')}" frame="true" refresh="true">
		<input type="hidden" name="id" value="{pigcms{$package['pigcms_id']}" >
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="30%">名称</th>
				<td width="70%"><input type="text" class="input fl" name="name" size="20" validate="maxlength:20,required:true" value="{pigcms{$package['name']}"/></td>
			</tr>
			<tr>
				<th width="30%">有效时间</th>
				<td width="70%"><input type="text" class="input fl" name="time" size="20" validate="maxlength:20,required:true,number:true" value="{pigcms{$package['time']}" tips="月为单位,0则不受限制" /></td>
			</tr>
			<tr>
				<th width="30%">开店数量</th>
				<td width="70%"><input type="text" class="input fl" name="store_nums" size="20" validate="maxlength:20,required:true,number:true" value="{pigcms{$package['store_nums']}" tips="0为不受限制" /></td>
			</tr>
			<tr>
				<th width="30%">店铺独立收款</th>
				<td width="70%" class="radio_box">
                    <span class="cb-enable"><label class="cb-enable <if condition="$package['store_pay_weixin_open'] eq 1">selected</if>"><span>开启</span><input type="radio" name="store_pay_weixin_open" value="1" <if condition="$package['store_pay_weixin_open'] eq 1">checked="checked"</if> /></label></span>
                    <span class="cb-disable"><label class="cb-disable <if condition="$package['store_pay_weixin_open'] eq 0">selected</if>"><span>关闭</span><input type="radio" name="store_pay_weixin_open" value="0"  <if condition="$package['store_pay_weixin_open'] eq 0">checked="checked"</if> /></label></span>
                </td>
			</tr>
			<tr>
				<th width="30%">店铺发展分销商数量</th>
				<td width="70%"><input type="text" class="input fl" name="distributor_nums" size="20" validate="maxlength:20,required:true,number:true" value="{pigcms{$package['distributor_nums']}" tips="0为不受限制" /></td>
			</tr>
			<tr>
				<th width="30%">店铺每日做单限额(仅限平台积分)</th>
				<td width="70%"><input type="text" class="input fl" name="store_point_total" size="20" validate="maxlength:20,required:true,number:true" value="{pigcms{$package['store_point_total']}" tips="0为不受限制" /></td>
			</tr>
			
			<tr>
				<th width="30%">店铺线上交易</th>
				<td width="70%" class="radio_box">
                    <span class="cb-enable"><label class="cb-enable <if condition="$package['store_online_trade'] eq 1">selected</if>"><span>开启</span><input type="radio" name="store_online_trade" value="1" <if condition="$package['store_online_trade'] eq 1">checked="checked"</if>/></label></span>
                    <span class="cb-disable"><label class="cb-disable <if condition="$package['store_online_trade'] eq 0">selected</if>"><span>关闭</span><input type="radio" name="store_online_trade" value="0" <if condition="$package['store_online_trade'] eq 0">checked="checked"</if> /></label></span>
                </td>
			</tr>

			<tr>
				<th width="30%">状态</th>
				<td width="70%" class="radio_box">
					<span class="cb-enable"><label class="cb-enable <if condition="$package['status'] eq 1">selected</if>"><span>正常</span><input type="radio" name="status" value="1"  <if condition="$package['status'] eq 1">checked="checked"</if>/></label></span>
					<span class="cb-disable"><label class="cb-disable <if condition="$package['status'] eq 0">selected</if>"><span>禁止</span><input type="radio" name="status" value="0"  <if condition="$package['status'] eq 0">checked="checked"</if>/></label></span>
				</td>
			</tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<include file="Public:footer"/>