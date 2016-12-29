<include file="Public:header"/>
<form id="myform" method="post" action="{pigcms{:U('Tuan/adver_add')}" enctype="multipart/form-data">
    <input type="hidden" name="cat_id" value="{pigcms{$adver_type}"/>
    <table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
        <tr>
            <th width="80">广告名称</th>
            <td><input type="text" class="input fl" name="name" size="20" placeholder="请输入名称" validate="maxlength:20,required:true"/></td>
        </tr>
        <tr>
            <th width="80">广告图片</th>
            <td><input type="file" class="input fl" name="pic" style="width:200px;" placeholder="请上传图片" validate="required:true"/></td>
        </tr>
        <tr>
            <th width="80">链接地址</th>
            <td><input type="text" class="input fl" name="url" style="width:200px;" placeholder="请填写链接地址" validate="maxlength:200,required:true,url:true"/></td>
        </tr>
        <tr>
            <th width="80">广告状态</th>
            <td>
                <span class="cb-enable"><label class="cb-enable"><span>启用</span><input type="radio" name="status" value="1"/></label></span>
                <span class="cb-disable"><label class="cb-disable selected"><span>关闭</span><input type="radio" name="status" value="0" checked="checked" /></label></span>
            </td>
        </tr>
    </table>
    <div class="btn hidden">
        <input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
        <input type="reset" value="取消" class="button" />
    </div>
</form>
<include file="Public:footer"/>