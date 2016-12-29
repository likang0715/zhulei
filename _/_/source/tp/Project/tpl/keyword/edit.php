<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Keyword/amend')}" frame="true" refresh="true">
		<input type="hidden" name="id" value="{pigcms{$search_hot.id}"/>
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="80">关键词</th>
				<td><input type="text" class="input fl" name="name" size="20" placeholder="请输入关键词" value="{pigcms{$search_hot.name}" validate="maxlength:50,required:true"/></td>
			</tr>
			
			<tr style="display:none">
				<th width="80">热门</th>
				<td class="radio_box">
					<span class="cb-enable">
						<label class="cb-enable <if condition="$search_hot['type']  eq 1">selected</if>">
							<span>开启</span>
							<input type="radio" name="type" value="1" <if condition="$search_hot['type'] eq 1">checked="checked"</if>>
						</label>
					</span>
					<span class="cb-disable">
						<label class="cb-disable <if condition="$search_hot['type'] eq 0">selected</if>">
							<span>关闭</span>
							<input type="radio" name="type" value="0" <if condition="$search_hot['type'] eq 0">checked="checked"</if>>
						</label>
					</span>
					<em tips="开启热门后，会着色显示搜索词" class="notice_tips"></em>
				</td>
			</tr>
			<tr>
				<th width="80">排序</th>
				<td><input type="text" class="input fl" name="sort" size="10" value="{pigcms{$search_hot.sort}" validate="required:true,number:true,maxlength:6" tips="数值越大，排序越前"/></td>
			</tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<include file="Public:footer"/>