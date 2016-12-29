<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('User/amend')}" frame="true" refresh="true">
		<input type="hidden" name="uid" value="{pigcms{$now_user.uid}"/>
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="15%">ID</th>
				<td width="35%"><div style="height:24px;line-height:24px;">{pigcms{$now_user.uid}</div></td>
				<th width="15%">微信唯一标识</th>
				<td width="35%"><div style="height:24px;line-height:24px;">{pigcms{$now_user.openid}</div></td>
			<tr/>
			<tr>
				<th width="15%">昵称</th>
				<td width="35%"><input type="text" class="input fl" name="nickname" size="20" validate="maxlength:50,required:true" value="{pigcms{$now_user.nickname}"/></td>
				<th width="15%">手机号</th>
				<td width="35%"><input type="text" class="input fl" name="phone" size="20" validate="mobile:true" value="{pigcms{$now_user.phone}"/></td>
			</tr>
			<tr>
				<th width="15%">密码</th>
				<td width="35%"><input type="password" class="input fl" name="pwd" size="20" value="" tips="不修改则不填写"/></td>
                <th width="15%">状态</th>
                <td width="35%" class="radio_box">
                    <span class="cb-enable"><label class="cb-enable <if condition="$now_user['status'] eq 1">selected</if>"><span>正常</span><input type="radio" name="status" value="1"  <if condition="$now_user['status'] eq 1">checked="checked"</if>/></label></span>
                    <span class="cb-disable"><label class="cb-disable <if condition="$now_user['status'] eq 0">selected</if>"><span>禁止</span><input type="radio" name="status" value="0"  <if condition="$now_user['status'] eq 0">checked="checked"</if>/></label></span>
                </td>
			</tr>

			<!--tr>
				<th width="15%">手机号验证</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><if condition="$vo['is_check_phone'] eq 1"><font color="green">已验证</font><else/><font color="red">未验证</font></if></div></td>
				<th width="15%">关注微信号</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><if condition="$vo['is_follow'] eq 1"><font color="green">已关注</font><else/><font color="red">未关注</font></if></div></td>
			</tr-->
			<tr>
				<th width="15%">注册时间</th>
				<td width="35%"><div style="height:24px;line-height:24px;">{pigcms{$now_user.reg_time|date='Y-m-d H:i:s',###}</div></td>
				<th width="15%">注册IP</th>
				<td width="35%"><div style="height:24px;line-height:24px;">{pigcms{$now_user.reg_ip|long2ip=###}</div></td>
			</tr>
			<tr>
				<th width="15%">最后访问时间</th>
				<td width="35%"><div style="height:24px;line-height:24px;">{pigcms{$now_user.last_time|date='Y-m-d H:i:s',###}</div></td>
				<th width="15%">最后访问IP</th>
				<td width="35%"><div style="height:24px;line-height:24px;">{pigcms{$now_user.last_ip|long2ip=###}</div></td>
			</tr>
            <tr>
                <th width="15%">个性签名：</th>
                <td width="35%" colspan="3" style="padding: 7px 15px 9px 15px;"><textarea style="width: 99%" name="intro">{pigcms{$now_user.intro}</textarea></td>
            </tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<include file="Public:footer"/>