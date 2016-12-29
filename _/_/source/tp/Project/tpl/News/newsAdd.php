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
	<form id="myform" method="post" action="{pigcms{:U('News/newsAdd')}" enctype="multipart/form-data">
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="80">新闻标题</th>
				<td><input type="text" class="input fl" name="news_title" size="50" placeholder="请输入标题" validate="maxlength:50,required:true"/></td>
			</tr>
                        <tr>
				<th width="80">新闻摘要</th>
				<td><input type="text" class="input fl" name="abstract" size="50" placeholder="请输入摘要" validate="maxlength:50,required:true"/></td>
			</tr>
                        <tr>
                            <th width="80">文章类型</th>
                            <td><input name="newsType" type="radio" value="0" checked="checked" />股权众筹 &nbsp;&nbsp;&nbsp;&nbsp;<input name="newsType" type="radio" value="1" />产品众筹</td>
			</tr>
                        <tr>
                            <th width="80">上传新闻图片</th>
                            <td>
                                <input type="text" style="width: 280px;" class="input-text"  name="imgUrl" value="{pigcms{$info.url}" id="addImg" />&nbsp;&nbsp;
                                <input type="file" style="width: 170px;border:none;" name="upload" value="{pigcms{$info.url}" id="upload_file" onchange="UpladFile();" />&nbsp;&nbsp;
                            </td>
                        </tr>
			<tr>
                            <th width="100">新闻分类</th>
                            <td>
                                <select name="cat_key" id="is_push" validate="required:true">
                                        <option value="" selected="selected">请选择分类</option>
                                        <volist name="news_cat_list" id="vo">
                                            <option value="{pigcms{$vo['cat_key']}">{pigcms{$vo.cat_name} -- {pigcms{$vo.cat_key}</option>
                                        </volist>
                                </select>
                                <em class="notice_tips" tips="分类"></em>
                            </td>
                        </tr>
			<tr>
				<th width="80">新闻状态</th>
				<td>
					<span class="cb-enable"><label class="cb-enable selected"><span>显示</span><input type="radio" name="state" value="1" checked="checked" /></label></span>
					<span class="cb-disable"><label class="cb-disable"><span>隐藏</span><input type="radio" name="state" value="0" /></label></span>
				</td>
			</tr>
                        <tr>
                                <th width="80">新闻内容</th>
                                <td>
                                    <textarea id="description" name="news_content"  placeholder="可以在这里添加新闻内容">{pigcms{$leveldata['description']|htmlspecialchars_decode=ENT_QUOTES}</textarea>
                                </td>
                        </tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<script type="text/javascript" src="{pigcms{$static_public}js/artdialog/jquery.artDialog.js"></script>
<script type="text/javascript" src="{pigcms{$static_public}js/artdialog/iframeTools.js"></script>

<link rel="stylesheet" href="{pigcms{$static_public}kindeditor/themes/default/default.css">
<script src="{pigcms{$static_public}kindeditor/kindeditor.js"></script>
<script src="{pigcms{$static_public}kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript">

KindEditor.ready(function(K){
	var editor = K.editor({
		allowFileManager : true
	});
	 //var islock=false;
//	K('.J_selectImage').click(function(){
//		var obj=$(this);
//		editor.uploadJson = "{pigcms{$config.site_url}/index.php?g=Index&c=Upload&a=editor_ajax_upload&upload_dir=system/image";
//		editor.loadPlugin('image', function(){
//			editor.plugin.imageDialog({
//				showRemote : false,
//				imageUrl : K('#course_pic').val(),
//				clickFn : function(url, title, width, height, border, align) {
//					obj.siblings('input').val(url);
//					editor.hideDialog();
//					obj.siblings('img').attr('src',url).show();
//					//window.location.reload();
//				}
//			});
//		});
//	   
//	});

	kind_editor = K.create("#description",{
		width:'500px',
		height:'380px',
		minWidth:'480px',
		resizeType : 1,
		allowPreviewEmoticons:false,
		allowImageUpload : true,
		filterMode: true,
		items : [
			'source', '|', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
			'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
			'insertunorderedlist', '|', 'emoticons', 'image', 'link'
		],
		emoticonsPath : './static/emoticons/',
//		uploadJson : "{pigcms{$config.site_url}/index.php?g=Index&c=Upload&a=editor_ajax_upload&upload_dir=system/image"
	});
});
</script>

<include file="Public:footer"/>