<include file="Public:header"/>
<script type="text/javascript" src="static/js/layer/layer/layer.js"></script>
<script type="text/javascript">
var upload=(function(){
	var xhr;
	var obj;
	var src;
	function createXMLHttpRequest(){
		if(window.ActiveXObject){
			xhr = new ActiveXObject("Microsoft.XMLHTTP");
		}else if(window.XMLHttpRequest){
			xhr = new XMLHttpRequest();
		}
	}
	function uploadOne(url,idName,dom,link){
		var fileObj = document.getElementById(idName).files[0];
		var form = new FormData();
		obj=dom;
		src=link;
		form.append("myfile", fileObj);
		createXMLHttpRequest();
		xhr.onreadystatechange = handleStateChange;
		xhr.open("post", url, true);
		xhr.send(form);
	}
	function handleStateChange(){
		if(xhr.readyState == 4){
		        if (xhr.status == 200 || xhr.status == 0){
				var result = xhr.responseText;
				var json = eval("("+result+")");
				obj.val(json.path);
				src.attr("src",json.path);
		        }
		}
	}
	return {uploadOne:uploadOne};
})();
$(function(){
	$("#upload_file1").change(function(){
		var file1=upload.uploadOne('/zc.php?c=index&a=ajax_uploadImg','upload_file1',$("#addImg1"),$("#imgcc"));
	})
	$("#upload_file2").change(function(){
		var file2=upload.uploadOne('/zc.php?c=index&a=ajax_uploadImg','upload_file2',$("#addImg2"),$("#imgdd"));
	})
})
function layerClose(){
	var index = parent.layer.getFrameIndex(window.name);
	parent.layer.close(index);
}
</script>
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<a href="javascript:;" class="on"><?php echo !empty($id) ? '修改幻灯片' : '添加幻灯片'; ?></a>
			</div>
			<form method="post" id="myform" action="{pigcms{:U('News/slideEdit')}">
				<table cellpadding="0" cellspacing="0" class="table_form" width="100%">
					<tr>
						<td  width="120">类别</td>
						<td>
						<select   name="info[class]" >
						<?php  if(!empty($slideClass)){
								foreach ($slideClass as $k => $v) {
						?>
						<option value="<?php echo $k; ?>"   <?php echo $k==$info['class'] ? 'selected' : '';  ?>  ><?php echo $v; ?></option>
						<?php  } } ?>
						</select>
						</td>
					</tr>
					<tr>
						<td>幻灯片名称</td>
						<td><input type="text" style="width: 180px;" class="input-text"  name="info[name]" value="{pigcms{$info.name}" /></td>
					</tr>
                                        <tr>
						<td>备注</td>
						<td><input type="text" style="width: 180px;" class="input-text"  name="info[remark]" value="{pigcms{$info.remark}" /></td>
					</tr>
					<tr>
						<td>PC端图片链接地址</td>
						<td><input type="text" style="width: 180px;" class="input-text"   name="info[link]" value="{pigcms{$info.link}" /></td>
					</tr>
					<tr>
						<td>WAP端图片链接地址</td>
						<td><input type="text" style="width: 180px;" class="input-text"   name="info[waplink]" value="{pigcms{$info.waplink}" /></td>
					</tr>
					<tr>
						<td>PC端幻灯片</td>
						<td>
						<input type="text" style="width: 280px;" class="input-text"  name="info[url]" value="{pigcms{$info.url}" id="addImg1" />&nbsp;&nbsp;
						<input type="file" style="width: 170px;border:none;" name="upload" value="{pigcms{$info.url}" id="upload_file1"  />&nbsp;&nbsp;
						</td>
					</tr>
					<tr>
						<td>
						</td>
						<td>
						<img src="<?php echo !empty($info['url']) ? $info['url'] : 'crowdfunding/template/index/default/static/images/sl255_153.jpg' ; ?>" id="imgcc" style="width: 255px;height: 153px;"/>
						</td>
					</tr>
					<tr>
						<td>WAP端幻灯片</td>
						<td>
						<input type="text" style="width: 280px;" class="input-text"  name="info[wapurl]" value="{pigcms{$info.wapurl}" id="addImg2" />&nbsp;&nbsp;
						<input type="file" style="width: 170px;border:none;" name="upload" value="{pigcms{$info.wapurl}" id="upload_file2" />&nbsp;&nbsp;
						</td>
					</tr>
					<tr>
						<td>
						</td>
						<td>
						<img src="<?php echo !empty($info['wapurl']) ? $info['wapurl'] : 'crowdfunding/template/index/default/static/images/sl255_153.jpg' ; ?>" id="imgdd" style="width: 255px;height: 153px;"/>
						</td>
					</tr>
				</table>
				<div class="btn">
					<input type="hidden"  name="id" value="<?php echo $info['id']; ?>" />
					<input type="submit"  name="dosubmit" value="提交" class="button" />
					<input type="reset"  value="返回" class="button" onclick="javascript:layerClose();" />
				</div>
			</form>
		</div>
<include file="Public:footer"/>