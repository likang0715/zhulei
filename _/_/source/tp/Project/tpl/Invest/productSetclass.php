<include file="Public:header"/>
<script type="text/javascript" src="static/js/layer/layer/layer.js"></script>
<script type="text/javascript">
var upload=(function(){
	var xhr;
	var obj;
	function createXMLHttpRequest(){
		if(window.ActiveXObject){
			xhr = new ActiveXObject("Microsoft.XMLHTTP");
		}else if(window.XMLHttpRequest){
			xhr = new XMLHttpRequest();
		}
	}
	function uploadOne(url,idName,dom){
		var fileObj = document.getElementById(idName).files[0];
		var form = new FormData();
		obj=dom;
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
				// console.log(json);
				obj.val(json.path);
		        }
		}
	}
	return {uploadOne:uploadOne};
})();
$(function(){
	$("#hiddenImg").change(function(){
		var file1=upload.uploadOne('/zc.php?c=index&a=ajax_uploadImg','hiddenImg',$("#imgsrc"));
	})
	$("#hiddenIcon").change(function(){
		var file2=upload.uploadOne('/zc.php?c=index&a=ajax_uploadImg','hiddenIcon',$("#iconsrc"));
	})
	$(".lookimg").click(function(){
		var img=$(this).parent().find(".input-text").val();
		var imgPath='<img src="'+img+'" style="width:100%;height:100%;"/>';
		if(img == undefined || img==null || img==''){
			layer.msg("请先上传图片");
			return;
		}else{
			layer.open({
			  type: 1,
			  shade: false,
			  title: '图片预览', //不显示标题
			  area: ['500px', '60%'], //宽高
			  content:  '<img src="'+img+'" style="width:100%;height:100%;"/>'
			});
		}
	})
})
</script>
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
					<a href="{pigcms{:U('Invest/product')}" class="on">项目列表</a>
					<a href="{pigcms{:U('Invest/productClass')}" class="on">分类列表</a>
					<a href="{pigcms{:U('Invest/productSetclass')}" class="on">添加分类</a>
			</div>
			<form method="post" id="myform" action="{pigcms{:U('Invest/productSetclass')}" refresh="true" frame="true">
				<table cellpadding="0" cellspacing="0" class="table_form" width="100%">
					<tr>
						<td>
						分类标题：<input type="text" style="width: 160px;" class="input-text"  name="info[name]" value="<?php echo $class['name']; ?>" validate="required:true" />
						</td>
					</tr>
					<tr>
						<td>
						分类描述：<textarea name="info[remark]"  value="" style="width: 300px;height:100px;vertical-align: top;border-radius: 3px;padding: 4px;"><?php echo $class['remark']; ?></textarea>
						</td>
					</tr>
					<tr>
						<td>
						<div>
						分类图片：
						<input type="text" style="width: 360px;" class="input-text"  id="imgsrc"  name="info[img]" value="<?php echo $class['img']; ?>" /><button class="lookimg" onclick="return false;">预览图片</button>&nbsp;&nbsp;<input type="file" name="img_src" value="" style="width: 160px;border: none;" id="hiddenImg" />
						</div>
						</td>
					</tr>
					<tr>
						<td>
						<div>
						分类图标：
						<input type="text" style="width: 360px;" class="input-text"  id="iconsrc"  name="info[icon]" value="<?php echo $class['icon']; ?>" />
						<button class="lookimg" onclick="return false;">预览图片</button>&nbsp;&nbsp;
						<input type="file" name="icon_src" value="" style="width: 160px;border: none;" id="hiddenIcon" />
						</div>
						</td>
					</tr>
				</table>
				<div class="btn">
					<input type="hidden"  name="id" value="<?php echo $class['id']; ?>" />
					<input type="submit"  name="dosubmit" value="提交" class="button" id="dosubmit" />
					<!-- <input type="reset"  value="取消" class="button" /> -->
				</div>
			</form>
		</div>
<include file="Public:footer"/>