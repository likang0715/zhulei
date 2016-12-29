<include file="Public:header"/>
<form id="myform" method="post" action="{pigcms{:U('Admin/send_reward')}" frame="true" refresh="true">
	<input type="hidden" name="id" value="{pigcms{$admin.id}">
	<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
		<tr>
			<th width="15%">总奖金</th>
			<td width="35%">{pigcms{$admin.reward_total}</td>
			<th width="15%">可发送奖金</th>
			<td width="35%">{pigcms{$admin.reward_balance}</td>
		</tr>
		<tr>
			<th width="15%">填写操作金额</th>
			<td width="35%"><input type="text" class="input fl" name="amount" size="20" validate="required:true,maxlength:20,number:true,range:[0,{pigcms{$admin.reward_balance}]" value=""/></td>
			<th width="15%">发送方式</th>
			<td width="35%">
				<select name="send_type">
					<volist name="sendTypeArr" id="vo">
						<option value="{pigcms{$vo['type']}">{pigcms{$vo['name']}</option>
					</volist>
				</select>
			</td>
		</tr>
		<tr>
			<th width="15%">备注(银行卡号、收款人、单号等等)</th>
			<td width="35%" colspan="3">
				<textarea style="width: 99%" name="bak" rows="4"></textarea>
			</td>
		</tr>
	</table>
	<div class="btn hidden">
		<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
		<input type="reset" value="取消" class="button" />
	</div>
</form>
<include file="Public:footer"/>