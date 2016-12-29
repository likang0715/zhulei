<include file="Public:header"/>
<script type="text/javascript" src="{pigcms{$static_public}js/area/area.min.js"></script>
<script type="text/javascript">
$(function(){
	if($('.js-regions-wrap').data('province') == ''){
		getProvinces('s1','');
	}else{
		getProvinces('s1',$('.js-regions-wrap').data('province'));
		getCitys('s2','s1',$('.js-regions-wrap').data('city'));
		$("select[name=province]").attr("disabled", "disabled").css({ color:'#ccc', backgroundColor:'#fafafa', boxShadow:'none' });
	}

	$('#s1').live('change',function(){
		if($(this).val() != ''){
			getCitys('s2','s1','');
		}else{
			$('#s2').html('<option value="">选择城市</option>');
		}
	});

})
</script>
<style type="text/css">
.area_select select { width: 150px; margin-right: 10px; }
</style>
<form id="myform" method="post" action="{pigcms{:U('Admin/area_add')}" frame="true" refresh="true">
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
			<th width="15%">区域选择</th>
			<td width="85%" colspan="3">
				<input type="hidden" name="area_level" value="2">
				<div class="area_select js-regions-wrap" data-province="{pigcms{$admin_user['province']}">
					<span><select name="province" id="s1" validate="required:true"></select></span>
					<span><select name="city" id="s2" validate="required:true"><option value="">选择城市</option></select></span>
				</div>
			</td>
		</tr>
		<tr>
			<th width="15%">真实姓名</th>
			<td width="35%"><input type="text" class="input fl" name="realname" size="20" validate="maxlength:20" value=""/></td>
			<th width="15%">电话</th>
			<td width="35%"><input type="text" class="input fl" name="phone" size="20" validate="number:true" value=""/></td>
		</tr>
		<tr>
			<th width="15%">邮箱</th>
			<td width="35%"><input type="text" class="input fl" name="email" size="20" validate="email:true" value=""/></td>
			<th width="15%">QQ</th>
			<td width="35%"><input type="text" class="input fl" name="qq" size="20" validate="number:true" value=""/></td>
		</tr>
	</table>
	<div class="btn hidden">
		<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
		<input type="reset" value="取消" class="button" />
	</div>
</form>
<include file="Public:footer"/>