<include file="Public:header"/>
<style type="text/css">
	.table_form thead th { color: #000;  }
	.table_form td { border-left: 1px solid #dcdcdc; }
	.table_form tbody th { padding-right: 10px; }
	a.del_btn { float: right; margin: 20px 10px 0 0; }
</style>
<div class="mainbox">
	<div id="nav" class="mainnav_title">
		<ul>
			<a href="{pigcms{:U('Store/diyAttestation')}" class="on">认证自定义表单</a>
		</ul>
	</div>
	<form refresh="true" action="" method="post" id="myform">
	<div class="table-list">
	<table width="100%" cellspacing="0" cellpadding="0" id="tab_0" style="" class="table_form">
		<thead>
			<tr>
				<th>数据类型</th>
				<th>数据可选值</th>
				<th>数据名称</th>
				<th width="260">注释</th>
			</tr>
		</thead>
		<tbody>
			<!--<tr>
				<th width="160">打开认证：</th>
				<td colspan="3"><span class="cb-enable">
					<label class="cb-enable selected"><span>是</span>
						<input type="radio" checked="checked" value="1" name="is_open">
					</label>
					</span><span class="cb-disable">
					<label class="cb-disable "><span>否</span>
						<input type="radio" value="0" name="is_open">
					</label>
					</span></td>
			</tr>-->
			<?php if ($diy_attestation_list) { ?>
				<?php foreach ($diy_attestation_list as $v) { ?>
					<input type="hidden" name="field-id[]" value="<?php echo $v['id'];?>">
					<?php if (strpos($v['type'],'text')) { ?>
						<tr>
							<th width="160">
								<select class="input-small message-input valid" name="field-type[]" onchange="change_fieldType($(this))">
									<option value="text" selected="selected">文本格式</option>
									<option value="image">图片上传</option>
									<option value="select">下拉框</option>
								</select>
							</th>
							<td class="validate_type">
								<span>
									验证类型：
									<select class="valid" name="field-type-str[]">
										<option value="all" <?php if(strpos($v['type'],'all')){?>selected<?php } ?>>不限</option>
										<option value="cn_username" <?php if(strpos($v['type'],'cn_username')){?>selected<?php } ?>>中英数字</option>
										<option value="number" <?php if(strpos($v['type'],'number')){?>selected<?php } ?>>数字</option>
										<option value="email" <?php if(strpos($v['type'],'email')){?>selected<?php } ?>>邮箱</option>
										<option value="qq" <?php if(strpos($v['type'],'qq')){?>selected<?php } ?>>qq</option>
										<option value="url" <?php if(strpos($v['type'],'url')){?>selected<?php } ?>>链接</option>
									</select>
								</span>
							</td>
							<td><input type="text" name="info[]" class="input-text" value="<?php echo $v['info'];?>"></td>
							<td>
								<textarea name="desc[]" type="text" rows="4" cols="30"><?php echo $v['desc'];?></textarea>
								<a href="javascript:void(0)" onClick="diyRow_del($(this),<?php echo $v['id'];?>)" class="del_btn">
									<img src="{pigcms{$static_path}images/icon_delete.png" width="18" title="删除" alt="删除" />
								</a>
							</td>
						</tr>
					<?php } elseif (strpos($v['type'],'image')) { ?>
						<tr>
							<th width="160">
								<select class="input-small message-input valid" name="field-type[]" onchange="change_fieldType($(this))">
									<option value="text" selected="selected">文本格式</option>
									<option value="image" selected>图片上传</option>
									<option value="select">下拉框</option>
								</select>
							</th>
							<td class="validate_type"><input type="hidden" value="" name="field-type-str[]"></td>
							<td><input type="text"  name="info[]" class="input-text" value="<?php echo $v['info'];?>"></td>
							<td>
								<textarea name="desc[]" type="text" rows="4" cols="30"><?php echo $v['desc'];?></textarea>
								<a href="javascript:void(0)" onClick="diyRow_del($(this),<?php echo $v['id'];?>)" class="del_btn">
									<img src="{pigcms{$static_path}images/icon_delete.png" width="18" title="删除" alt="删除" />
								</a>
							</td>
						</tr>
					<?php } else { ?>
						<tr>
							<th width="160">
								<select class="input-small message-input valid" name="field-type[]" onchange="change_fieldType($(this))">
									<option value="text" selected="selected">文本格式</option>
									<option value="image">图片上传</option>
									<option value="select" selected>下拉框</option>
								</select>
							</th>
							<td class="validate_type">
								<textarea name="field-type-str[]" rows="4" cols="30"><?php 
								parse_str($v['type'],$val_str);
								$str='';
								foreach (explode('|',$val_str['value']) as $val) {
									$str.=end(explode(':',$val)).',';	
								} 
								echo rtrim($str,',') ?></textarea>
								<span>请填写下拉菜单具体值，以","隔开即可！(例：男,女)</span>
							</td>
							<td><input type="text" name="info[]" class="input-text" value="<?php echo $v['info'];?>"></td>
							<td>
								<textarea name="desc[]" type="text" rows="4" cols="30"><?php echo $v['desc'];?></textarea>
								<a href="javascript:void(0)" onClick="diyRow_del($(this),<?php echo $v['id'];?>)" class="del_btn">
									<img src="{pigcms{$static_path}images/icon_delete.png" width="18" title="删除" alt="删除" />
								</a>
							</td>
						</tr>
			<?php }}} ?>
		</tbody>
	</table>
	</div>
	<div style=" margin-top:15px; margin-left:7px"><a href="javascript:;" class="js-add-message" style="padding:5px;background:#498CD0;color:#fff;">+ 添加字段</a></div>
	<div style="margin-top:20px;" class="btn">
		<input type="submit" class="button" value="提交" name="dosubmit">
		<span style="color:red;">请不要随便修改认证信息，修改后所有店铺需要重新提交认证资质</span>
	</div>
</form>
</div>
<script type="text/javascript">
var iNow=0;
$('.js-add-message').live('click',function(){
	var html='<tr><th width="160"><input type="hidden" name="field-id[]" value=""><select onchange="change_fieldType($(this))" name="field-type[]" class="input-small message-input valid"><option selected="selected" value="text">单行文本</option><option value="image">图片上传</option><option value="select">下拉框</option></select></th><td class="validate_type"><span>验证类型：<select name="field-type-str[]" class="valid"><option value="all">不限</option><option value="cn_username">中英数字</option><option value="number">数字</option><option value="email">邮箱</option><option value="qq">qq</option><option value="url">链接</option></select></span></td><td><input type="text" value="" placeholder="字段名称" name="info[]" class="input-text" /></td><td><textarea type="text" name="desc[]" placeholder="字段描述" rows="4" cols="30"></textarea><a href="javascript:void(0)" onClick="diyRow_del($(this),0)" class="del_btn"><img src="{pigcms{$static_path}images/icon_delete.png" width="18" title="删除" alt="删除" /></a></td></tr>';
	$('tbody').append(html);
});

function change_fieldType(obj){
	if(obj.find('option:selected').val()=='text'){
		var html='<span>验证类型：<select name="field-type-str[]"><option value="cn_username">中英数字</option><option value="number">数字</option><option value="email">邮箱</option><option value="qq">qq</option><option value="url">链接</option></select></select></span>';
		obj.parents('tr').find('.validate_type').html('').append(html);
	}
	
	if(obj.find('option:selected').val()=='image'){
		var html='<input name="field-type-str[]" class="input-text" value="" type="hidden" />';
		obj.parents('tr').find('.validate_type').html('').append(html);
	}
	
	if(obj.find('option:selected').val()=='select'){
		var html='<textarea name="field-type-str[]" rows="4" cols="30"></textarea><span>请填写下拉菜单具体值，以","隔开即可！(例：男,女)</span>';
		obj.parents('tr').find('.validate_type').html('').append(html);
	}

}


function diyRow_del (obj,id) {
	if (id == 0) {
		obj.parents('tr').remove();

	} else {
		if (!confirm("记录将不可恢复，确定删除？")) {
			return false;
		}

		$.post("<?php echo U('Store/diyAttestation_del'); ?>", {'id': id}, function (res) {
			if(res){
				obj.parents('tr').remove();
			}
		},'json');
	}
}
</script> 
<include file="Public:footer"/>