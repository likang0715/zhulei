<include file="Public:header"/>
<script type="text/javascript" src="static/js/layer/layer/layer.js"></script>
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<a href="javascript:;" class="on"><?php echo !empty($id) ? '修改常见问题' : '添加常见问题'; ?></a>
			</div>
			<form method="post" id="myform" action="{pigcms{:U('Invest/editQuestion')}">
				<table cellpadding="0" cellspacing="0" class="table_form" width="100%">
					<tr>
						<td  width="120">类别</td>
						<td>
						<select   name="info[class]" >
						<?php  if(!empty($questionClass)){
								foreach ($questionClass as $k => $v) {
						?>
						<option value="<?php echo $k; ?>"   <?php echo $k==$info['class'] ? 'selected' : '';  ?>  ><?php echo $v; ?></option>
						<?php  } } ?>
						</select>
						</td>
					</tr>
					<tr>
						<td>常见问题名称</td>
						<td><input type="text" style="width: 280px;" class="input-text"  name="info[question_name]" value="{pigcms{$info.question_name}" validate="required:true" /></td>
					</tr>
					<tr>
						<td>常见问题答案</td>
						<td>
						<textarea name="info[question_answer]" style="width: 280px;height: 100px;">{pigcms{$info.question_answer}</textarea>
						</td>
					</tr>
				</table>
				<div class="btn">
					<input type="hidden"  name="id" value="<?php echo $info['id']; ?>" />
					<input type="submit"  name="dosubmit" value="提交" class="button" />
					<input type="reset"  value="取消" class="button" />
				</div>
			</form>
		</div>
<script type="text/javascript">
$(function(){
	$("input[type=reset]").click(function(){
	var index = parent.layer.getFrameIndex(window.name);
	parent.layer.close(index);
	})
})
</script>
<include file="Public:footer"/>