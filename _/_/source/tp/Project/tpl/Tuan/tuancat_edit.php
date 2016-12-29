<include file="Public:header"/>
	<form id="myform" method="post" action="" frame="true" refresh="true">
		<input type="hidden" name="cat_id" value="{pigcms{$tuan_category_detail.cat_id}"/>
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="80">分类名称</th>
				<td><input type="text" class="input fl" name="cat_name" value="{pigcms{$tuan_category_detail.cat_name}" size="15" placeholder="请输入名称" validate="maxlength:30,required:true"/></td>
			</tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<include file="Public:footer"/>