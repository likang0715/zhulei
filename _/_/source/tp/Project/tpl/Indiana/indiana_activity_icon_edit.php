<include file="Public:header"/>
<form id="myform" method="post" action="{pigcms{:U('Indiana/activityIcon_edit')}" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{pigcms{$activity_icon_detail.id}"/>
    <table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
        <tr>
            <th width="80">图标名称</th>
            <td><input type="text" class="input fl" name="name" value="{pigcms{$activity_icon_detail.name}" size="20" placeholder="请输入图标名称" validate="maxlength:20,required:true"/></td>
        </tr>
        <tr>
            <th width="80">图标价格</th>
            <td><input type="text" class="input fl" name="key" value="{pigcms{$activity_icon_detail.key}" style="width:200px;" placeholder="请填写图标价格" validate="required:true"/></td>
        </tr>
        <tr>
            <th width="80">现有图标</th>
            <td><img src="{pigcms{$activity_icon_detail.imgurl}" style="height:80px;" class="view_msg"/></td>
        </tr>
        <tr>
            <th width="80">上传图标</th>
            <td><input type="file" class="input fl" name="pic" style="width:200px;" placeholder="请上传图片" tips="不修改请不上传！上传新图片，老图片会被自动删除！"/></td>
        </tr>
        <tr>
            <th width="80">图标状态</th>
            <td>
                <span class="cb-enable"><label class="cb-enable <if condition="$activity_icon_detail['status'] eq 1">selected</if>"><span>启用</span><input type="radio" name="status" value="1" checked="checked" <if condition="$activity_icon_detail['status'] eq 1">checked="checked"</if>/></label></span>
                <span class="cb-disable"><label class="cb-disable <if condition="$activity_icon_detail['status'] eq 0">selected</if>"><span>关闭</span><input type="radio" name="status" value="0" <if condition="$activity_icon_detail['status'] eq 0">checked="checked"</if>/></label></span>
            </td>
        </tr>
    </table>
    <div class="btn hidden">
        <input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
        <input type="reset" value="取消" class="button" />
    </div>
</form>
<include file="Public:footer"/>
