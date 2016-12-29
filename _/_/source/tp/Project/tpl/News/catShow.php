<include file="Public:header"/>
<script type="text/javascript" src="static/js/layer/layer/layer.js"></script>
<script type="text/javascript">
var xhr;
function createXMLHttpRequest(){
    if(window.ActiveXObject){
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }else if(window.XMLHttpRequest){
        xhr = new XMLHttpRequest();
    }
}
function UpladFile(){
    var fileObj = document.getElementById("upload_file").files[0];
    var FileController = "zc.php?c=index&a=ajax_uploadImg";
    var form = new FormData();
    form.append("myfile", fileObj);
    createXMLHttpRequest();
    xhr.onreadystatechange = handleStateChange;
    xhr.open("post", FileController, true);
    xhr.send(form);
}
function handleStateChange(){
    if(xhr.readyState == 4){
        if (xhr.status == 200 || xhr.status == 0){
            var result = xhr.responseText;
            var json = eval("(" + result + ")");
            if(json.code==200){
            	$("#imgcc").attr("src",json.path);
            	$("#imgcc").show();
                $("#addImg").val(json.path);
                layer.msg("图片上传成功");
            }else{
                layer.msg(json.msg);
            }
        }
    }
}
function layerClose(){
	var index = parent.layer.getFrameIndex(window.name);
	parent.layer.close(index);
}
</script>
	<form method="post" action="{pigcms{:U('News/catAmend')}" frame="true" refresh="true" enctype="multipart/form-data" >
		<input type="hidden" name="cat_id" value="{pigcms{$now_category.cat_id}"/>
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">

			<tr>
				<th width="80">分类名称</th>
				<td>{pigcms{$now_category.cat_name}</td>
			</tr>
			<tr>
				<th width="80">分类标识</th>
				<td>{pigcms{$now_category.cat_key}</td>
			</tr>
                        <tr>
                                <th width="80">分类图片</th>
                                <td>
                                    <img src="{pigcms{$now_category.icon}" style=" width: 100px; height: 100px;"/>
                                </td>
                        </tr>
			<tr>
				<th width="80">排序</th>
				<td>{pigcms{$now_category.sort}</td>
			</tr>
			<tr>
				<th width="80">是否显示</th>
				<td class="radio_box">
                                    <if condition="$now_category['cat_state'] eq 1"><span style="color:red;">显示</span><else />隐藏</if>
				</td>
			</tr>
			<tr>
				<th width="80">备注</th>
				<td>
                                     {pigcms{$now_category.desc}
				</td>
			</tr>

		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<include file="Public:footer"/>