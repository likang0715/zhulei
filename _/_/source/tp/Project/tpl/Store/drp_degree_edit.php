<include file="Public:header"/>

<script>
$(function(){

	$("input[name='store_name']").keyup(function(){
		var store_name = $(this).val();
		if(store_name) {

			$.post("<?php echo U('Store/search_store'); ?>", {'store_name': store_name}, function (obj) {
				var html="";
				$("select[name='store_id']").empty();

				for (var i in obj) {

					html += "<option value='"+obj[i].name+"' data-store_id='"+obj[i].store_id+"'>"+obj[i].name+"</option>";
					if(i == 0) {
						$("input[name='store_name']").val(obj[i].name);
						$("input[name='storeid']").val(obj[i].store_id);
						$("input[name='store_name']").data(obj[i].store_id);
					}
				}
					$("select[name='store_id']").html(html);
			},
			'json'
			)
		}
	})

	$("select[name='store_id']").change(function(){
		$("input[name='store_name']").data("");
		var select_store_name = $(this).val();
		var select_store_id = $("select[name='store_id']").find("option[value='"+select_store_name+"']").attr("data-store_id");

		$("input[name='store_name']").val(select_store_name);
		$("input[name='store_name']").data(select_store_id);
		$("input[name='storeid']").val(select_store_id);
	})
})
</script>

	<form id="myform" method="post" action="{pigcms{:U('Store/drp_degree_edit')}" enctype="multipart/form-data">
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">

            <tr>
				<th width="80">等级名称</th>
				<td><input type="text" class="input fl" name="name" id="name" size="25" value="{pigcms{$array.name}" placeholder="" validate="maxlength:20,required:true" tips=""/></td>
			</tr>
			<if condition="$array['icon']">
				<tr>
					<th width="80">等级图标现图</th>
					<td><img src="{pigcms{$array.icon}" style="max-width:60px;max-height:60px;" class="view_msg"/></td>
				</tr>
			</if>			
			<tr>
				<th width="80">等级图标</th>
				<td><input   type="file" class="input fl" name="pic" style="width:175px;" placeholder="请上传图片" tips="二级分类建议上传！用于网站的店铺列表。"/></td>
			</tr>
			<tr>
				<th width="80">条件积分</th>
				<td>
					<input  type="text" class="input fl" name="condition_point" value="{pigcms{$array.condition_point}"  validate="required:true,maxlength:6,number:true">

				</td>
			</tr>
			<tr>
				<th width="80">等级值</th>
				<td><input type="text" class="input fl" name="value" value="{pigcms{$array.value}" "size="10" placeholder="等级值" validate="required:true,maxlength:6,number:true" tips="等级值越大，将越靠前显示！。"/></td>
			</tr>
			
			<tr>
				<th width="80">等级状态</th>
				<td>
					<span class="cb-enable"><label class="cb-enable selected"><span>启用</span><input type="radio" name="status" value="1" checked="checked" /></label></span>
					<span class="cb-disable"><label class="cb-disable"><span>禁用</span><input type="radio" name="status" value="0" /></label></span>
				</td>
			</tr>
			<tr>
				<th width="80">分销等级图标DIY状态</th>
				<td><?php if($config['is_allow_diy_drp_degree']) {?>开启中<?php }else {?><font color="#f00">关闭中</font><?php }?></td>
			</tr>			
            <tr>
                <th width="80">等级描述</th>
                <td><textarea rows="3" style="width: 97%" class="fl" name="desc" id="desc">{pigcms{$array.description}</textarea></td>
            </tr>
		</table>
		<div class="btn hidden">
            <input type="hidden" name="pigcms_id" value="{pigcms{$array.pigcms_id}" />
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<include file="Public:footer"/>