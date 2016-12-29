<include file="Public:header"/>
<form id="myform" method="post" action="{pigcms{:U('Indiana/activityIcon_add')}" enctype="multipart/form-data">
    <input type="hidden" name="cat_id" value="{pigcms{$adver_type}"/>
    <table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
        <tr>
            <th width="80">图标名称</th>
            <td><input type="text" class="input fl" name="name" size="20" placeholder="请输入图标名称" validate="maxlength:20,required:true"/></td>
        </tr>
        <tr>
            <th width="80">图标价格</th>
            <td><input type="text" class="input fl" name="key" style="width:200px;" placeholder="请填写图标价格" validate="required:true"/></td>
        </tr>
        <tr>
            <th width="80">图标</th>
            <td><input type="file" class="input fl" name="pic" style="width:200px;" placeholder="请上传图标" validate="required:true"/></td>
        </tr>
        <tr>
            <th width="80">图标状态</th>
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
