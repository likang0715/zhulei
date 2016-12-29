<include file="Public:header"/>
<script type="text/javascript" src="{pigcms{$static_public}js/area/area.min.js"></script>
<script type="text/javascript">
$(function(){

	function initArea () {

		if ($('.js-regions-wrap').data('province') == '') {
			getProvinces('s1','');
		} else {
			getProvinces('s1', $('.js-regions-wrap').data('province'));
			($("#s2").length > 0) ? getCitys('s2','s1', $('.js-regions-wrap').data('city')) : true;
			($("#s3").length > 0) ? getAreas('s3','s2', $('.js-regions-wrap').data('county')) : true;
		}

		// 当前为区域管理员 禁止修改大于等于该级别的区域
		switch ($('.js-regions-wrap').data('level')) {
			case 1:
				$("select[name=province]").attr("disabled", "disabled").css({ boxShadow:"none", color:"#ccc", borderColor:"#ccc" });
				break;
			case 2:
				$("select[name=province]").attr("disabled", "disabled").css({ boxShadow:"none", color:"#ccc", borderColor:"#ccc" });
				$("select[name=city]").attr("disabled", "disabled").css({ boxShadow:"none", color:"#ccc", borderColor:"#ccc" });
				break;
			default:
				break;
		}

	}
	// initArea();

	$('#s1').live('change', function(){
		if ($(this).val() != '') {
			getCitys('s2','s1','');
		} else {
			$('#s2').html('<option value="">选择城市</option>');
		}

		$('#s3').html('<option value="">选择地区</option>');
	});

	$('#s2').live('change', function(){
		if ($(this).val() != '') {
			getAreas('s3','s2','');
		} else {
			$('#s3').html('<option value="">选择地区</option>');
		}

	});		


	var areaHtml = {
		province: function(){
			return $('<span><select name="province" id="s1" validate="required:true"></select></span>');
		},
		city: function(){
			return $('<span><select name="province" id="s1" validate="required:true"></select></span>' +
				'<span><select name="city" id="s2" validate="required:true"><option value="">选择城市</option></select></span>');
		},
		county: function(){
			return $('<span><select name="province" id="s1" validate="required:true"></select></span>' +
				'<span><select name="city" id="s2" validate="required:true"><option value="">选择城市</option></select></span>' +
				'<span><select name="county" id="s3" validate="required:true"><option value="">选择地区</option></select></span>');
		}
	}

	// 选择区域重复绑定 validate
	$("select[name=area_level]").change(function(){

		var self = $(this);

		if (self.val() == 1) {
			$(".js-regions-wrap").html(areaHtml.province);
		} else if (self.val() == 2) {
			$(".js-regions-wrap").html(areaHtml.city);
		} else if (self.val() == 3) {
			$(".js-regions-wrap").html(areaHtml.county);
		} else {
			$(".js-regions-wrap").html("");
			return;
		}

		$(".js-regions-wrap select").each(function() {
			var self = $(this);
			self.rules("add", { required: true, messages: { required: "必填项"} });
			var validate = self.attr('validate');
			if(validate){
				varlidate_arr = validate.split(',');
				for(var i in varlidate_arr){
					if(varlidate_arr[i] == 'required:true'){
						if(self.attr('id')){
							var em_for = self.attr('id');
						}else{
							var em_for = self.attr('name');
						}
						if(self.val() == ''){
							self.parent().append('<em for="'+em_for+'" generated="true" class="error tips">必填项</em>');
						}else{
							self.parent().append('<em for="'+em_for+'" generated="true" class="error success"></em>');
						}
						break;
					}
				}
			}
		});

		initArea();

	});

})
</script>
<style type="text/css">
.area_select select { width: 120px; margin-right: 5px; }
</style>
<form id="myform" method="post" action="{pigcms{:U('Admin/area_add')}"  enctype="multipart/form-data">
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
			<th width="15%">选择区域</th>
			<td width="35%">
				<select name="area_level" validate="required:true">
					<option value="">选择区域等级</option>
					<volist name="area_level_list" id="vo">
						<option value="{pigcms{$vo.id}">{pigcms{$vo.name}</option>
					</volist>
				</select>
			</td>
			<th width="15%">所属管理员组</th>
			<td width="35%">
				<select name="group_id" validate="required:true">
					<option value="">--请选择--</option>
					<volist name="group_list" id="vo">
						<option value="{pigcms{$vo['id']}">{pigcms{$vo['name']}</option>
					</volist>
				</select>
			</td>
		</tr>
		<tr>
			<th width="15%">区域选择</th>
			<td width="85%" colspan="3">
				<if condition="$admin_user['type'] eq 2">
					<div class="area_select js-regions-wrap isArea" data-level="{pigcms{$admin_user['area_level']}" data-province="{pigcms{$admin_user['province']}" data-city="{pigcms{$admin_user['city']}" data-county=""></div>
				<else/>
					<div class="area_select js-regions-wrap" data-province="" data-city="" data-county=""></div>
				</if>
			</td>
		</tr>
		<tr>
			<th width="15%">真实姓名</th>
			<td width="35%"><input type="text" class="input fl" name="realname" size="20" validate="maxlength:20" value=""/></td>
			<th width="15%">手机号</th>
			<td width="35%"><input type="text" class="input fl" name="phone" size="20" validate="required:true,mobile:true" value="" tips="将用于短信提示，请填写实际手机号码"/></td>
		</tr>
		<tr>
			<th width="15%">邮箱</th>
			<td width="35%"><input type="text" class="input fl" name="email" size="20" validate="email:true" value=""/></td>
			<th width="15%">QQ</th>
			<td width="35%"><input type="text" class="input fl" name="qq" size="20" validate="number:true" value=""/></td>
		</tr>
        <tr>
            <th width="15%">照片</th>
            <td width="85%" colspan="3"><input type="file" class="input fl" name="pic" style="width:200px;"></td>
        </tr>
	</table>
	<div class="btn hidden">
		<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
		<input type="reset" value="取消" class="button" />
	</div>
</form>
<include file="Public:footer"/>